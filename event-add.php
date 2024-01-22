<?php
    session_start();
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
    include 'phpqrcode\phpqrcode\qrlib.php';
    require 'vendor/autoload.php'; // Include Composer's autoloader
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="calendar-svgrepo-com.svg" type="image/svg+xml">
    <title>Add Event</title>


    <?php include'link.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-calendar"></i> Add Event</h6>
                        </div>
                        <div class="card-body">
                            <form id="eventForm" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="eventTitle">Event Title:</label>
                                    <input type="text" id="eventTitle" name="eventTitle" class="form-control" required>
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="csvFile">Select a CSV file for participant:</label>
                                    <input type="file" class="form-control-file" name="csvFile" id="csvFile" accept=".csv" required>
                                </div>
                                <div class="form-group">
                                    <label for="csvSession">Select a CSV file for session:</label>
                                    <input type="file" class="form-control-file" name="csvSession" id="csvSession" accept=".csv" required>
                                </div>
                                <!-- Submit Button -->
                                <div class="text-center mt-3">
                                    <button type="submit" form="eventForm" name="btnSubmit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class=" bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span> &copy; Copyright Demand Generation</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <?php include'script.php'; ?>

</body>
</html>
// initial email
<?php
    if (isset($_POST['btnSubmit'])) {
        $connection = openConnection();
        $user_id = $_POST['user_id'];   
        $eventTitle = $_POST['eventTitle'];
        // Handle the uploaded CSV file for csvSession
        $eventInsertSql = "INSERT INTO events (event_title, user_id, event_status) VALUES ('$eventTitle', '$user_id', 1)";
        if (mysqli_query($connection, $eventInsertSql)) {
            $event_id = mysqli_insert_id($connection);
            if (isset($_FILES["csvSession"])) {
                $csvSessionFile = $_FILES["csvSession"]["tmp_name"];

                if (($handle = fopen($csvSessionFile, "r")) !== FALSE) {
                    // Skip the first row (header)
                    fgetcsv($handle);

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Check if the data row is empty, and skip it if it is
                        if (array_filter($data) == []) {
                            continue; // Skip empty rows
                        }

                        // Assuming the CSV file has at least 9 columns
                        $session_title = $data[0]; 
                        $technology = $data[1]; 
                        $technology_line = $data[2]; 
                        $product_name = $data[3];
                        $speaker = $data[4];
                        $speaker_special = $data[5];
                        $date = $data[6];
                        $timeam = $data[7];
                        $timepm = $data[8];

                        $sqlSession = "INSERT INTO event_sessions (event_id, session_title, technology, technology_line, product_name, speaker, speaker_special, date, timeam, timepm) VALUES ('$event_id','$session_title', '$technology', '$technology_line', '$product_name', '$speaker', '$speaker_special', '$date', '$timeam', '$timepm')";
                        mysqli_query($connection, $sqlSession);
                    }
                    fclose($handle);
                } else {
                    echo "Failed to open the CSV file.";
                }
                 // Check if a file was uploaded
                if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
                    // Get the uploaded file details
                    $fileName = $_FILES["csvFile"]["name"];
                    $tmpName = $_FILES["csvFile"]["tmp_name"];
                    $fileSize = $_FILES["csvFile"]["size"];

                    // Check if the uploaded file is a CSV
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if ($fileExtension != "csv") {
                        echo "Please upload a CSV file.";
                        exit();
                    }

                    // Open the uploaded CSV file
                    $csvFile = fopen($tmpName, 'r');

                    // Initialize a string to store the values from the first column
                    $firstColumnValues = '';

                    // Read and process the CSV data
                    while (($row = fgetcsv($csvFile)) !== false) {
                        // Check if there is a value in the first column
                        if (isset($row[0])) {
                            $firstColumnValues .= $row[0] . ','; // Use ',' for separation
                        }
                    }

                    // Close the CSV file
                    fclose($csvFile);
                    // Remove trailing comma
                    $firstColumnValues = rtrim($firstColumnValues, ',');

                    // Now, $firstColumnValues should be a string
                    //echo "<p>$firstColumnValues</p>";

                    // Split the concatenated values into an array
                    $data = explode(',', $firstColumnValues);
                    $mail = new PHPMailer(true);
                    // SMTP settings (you may need to configure these)
                    $mail->isSMTP();
                    $mail->Host = 'mail.laundryandwash.com';
                    $mail->SMTPSecure = 'tls'; // Use 'tls' for TLS encryption
                    $mail->SMTPAuth = true;
                    $mail->Username = 'event@laundryandwash.com';
                    $mail->Password = 'GhZ%3SiW]x=Z';
                    $mail->Port = 587; // Change to your SMTP port
                    // Set the "From" address correctly
                    $mail->setFrom('event@laundryandwash.com', 'New Event');

                    foreach ($data as $value) {
                        $emailContent = '
                        <body style="text-align: center; font-family: Arial, sans-serif; background-color: #1f432d; color: #333; margin: 0 auto; padding: 20px; border-radius: 10px; max-width: 900px;">
                            <h1 style="color: #ffffff; font-size: 36px; font-weight: bold; font-family: Remachine Script, cursive;">Join Us for an Exciting Event!</h1>
                            <img src="https://www.dixonusd.org/higgins/wp-content/uploads/sites/5/2023/10/5f51e401c1ad366c50bc64c1_hero-image-Events.png" alt="Event Image" draggable="false" style="width: 300px; height: 200px;" />
                            <h2 style="color: #ffffff; font-size: 30px; font-weight: bold;">'.$eventTitle.'</h2>
                            
                            <div style="margin: 0 auto; max-width: 600px;">
                                <p style="font-size: 20px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 15px;">
                                    Exciting news! We\'re inviting you to a dynamic and engaging seminar that\'s all about unlocking your potential and having a blast while doing it. Get ready for an event that\'s as fun as it is enlightening!
                                </p>

                                <p style="font-size: 16px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 20px;">
                                    This is your chance to soak up knowledge from industry pros, connect with fellow enthusiasts, and discover new passion. Trust us; you won\'t want to miss out!
                                </p>
                                
                                <p style="font-size: 16px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 15px; font-style: italic;">
                                    Click the button below to take the interest survey and secure your spot:
                                </p>
                                
                                <p style="text-align: center; margin: 40px;">
                                    <a href="http://localhost/event-recommender/event-form.php?eventID='.$event_id.'&email='.$value.'"
                                    style="display: inline-block; padding: 12px 24px; background-color: transparent; color: #ffffff; text-decoration: none; border: 2px solid #ffffff; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">
                                        Take the Interest Survey
                                    </a>
                                </p>
                            </div>


                            <p style="font-size: 16px; color: #ffffff; margin-bottom: 15px; font-style: italic;">
                                If you have any questions or need assistance, please feel free to contact us at <br> 
                                <a href="mailto:email@gmail.com" style="color: #3498db; text-decoration: none;">email@gmail.com</a> or <a href="tel:09123456789" style="color: #3498db; text-decoration: none;">09123456789</a>.
                            </p>

                        </body>
                        ';
                        $mail->addAddress($value); // Recipient's email address
                        $mail->isHTML(true);
                        $mail->Subject = $eventTitle;
                        $mail->Body = $emailContent;
                
                        if ($mail->send()) {
                            $sqlInsertParticipants = "INSERT INTO participants (event_id, email, status) VALUES('$event_id', '$value', 0)";
                            mysqli_query($connection, $sqlInsertParticipants);
                        } else {
                           echo "failed to send email to " . $value;
                        }
                    }
                
                } else {
                    echo "Error uploading the file.";
                }
            }
        echo '<script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Redirecting in 2 seconds.\nSuccessfully add event",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                       
                    });
                </script>';
        }
        else{
            echo '<script type="text/javascript">
                    swal({
                        title: "Warning",
                        text: "Redirecting in 2 seconds.\Failed to add event",
                        icon: "warning",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        
                    });
                </script>';
        }
    }
?>  