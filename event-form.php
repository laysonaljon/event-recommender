<?php
    session_start();
    include 'connection.php';
    include 'phpqrcode\phpqrcode\qrlib.php';
    require 'vendor/autoload.php'; // Include Composer's autoloader

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $event_id = isset($_GET['eventID']) ? $_GET['eventID'] : null;
    $email = isset($_GET['email']) ? $_GET['email'] : null;
    
    try {
        if ($event_id !== null && $email !== null) {
            $connection = openConnection();
            $strSql = "SELECT * FROM participants where event_id = '$event_id' and email = '$email'";
            $result = mysqli_query($connection, $strSql);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $reqPersons = mysqli_fetch_array($result);
                    mysqli_free_result($result);
                }
                else{
                    $message = "You are not registered on this event!";
                }
            }

           
        } else {
            $message = "";
            throw new Exception('');
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        $message = "";
    }
    
?>

<?php


if (isset($_POST['btnSubmit'])) {
    // Establish a database connection if needed
    $connection = openConnection();

    $email = $_GET['email'];
    $event_id = $_GET['eventID'];
    $participants_id = $_GET['participants_id'];

    // Perform database updates
    $updateParticipantSql = "UPDATE participants SET status = 1 WHERE event_id = '$event_id' AND email = '$email'";
    mysqli_query($connection, $updateParticipantSql);
    
    $updateEventSql = "UPDATE events SET event_status = 2 WHERE event_id = '$event_id'";
    mysqli_query($connection, $updateEventSql);
    
    $selected_data = [];
    if (isset($_POST["technology"])) {
        $selectedTechnologies = $_POST["technology"];
    
        foreach ($selectedTechnologies as $selectedTechId) {
            $selectedDropdownValue = $_POST["dropdown_" . $selectedTechId];
            // Insert the selected technology_id and dropdown value into your database
            $insertSql = "INSERT INTO response (event_id, email, response) VALUES ('$event_id','$email', '$selectedDropdownValue')";
            mysqli_query($connection, $insertSql);
            $selected_data[] = $selectedDropdownValue;
        }
    }

    // Retrieve the dataset
    $datasetSql = "SELECT * FROM event_sessions WHERE event_id = '$event_id'";
    $result = mysqli_query($connection, $datasetSql);
    $dataset = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataset[] = $row;
    }

    // Combine the data into an associative array
    $dataToPass = [
        "user_preferences" => $selected_data,
        "dataset" => $dataset
    ];

    // Encode the data as JSON
    $jsonData = json_encode($dataToPass);
    $tempFile = tempnam(sys_get_temp_dir(), 'json_data');
    file_put_contents($tempFile, $jsonData);
    $fileArg = escapeshellarg($tempFile);
    $command = "python new-recommendation.py $fileArg";
    exec($command, $output, $returnCode);
    unlink($tempFile);

    // Generate the QR code
    $outputFileName = "$email.png";
    $textToEncode = $email;
    QRcode::png($textToEncode, $outputFileName, QR_ECLEVEL_L, 3);

    if ($returnCode === 0) {
        $emailContent = ''; // Initialize email content
        $printed_session_ids = [];
        $reserved_time1 = [];
        $reserved_time2 = [];

        foreach ($output as $line) {
            $json_data = json_decode($line, true);

            if ($json_data) {
                $emailContent = '
                    <body style="text-align: center; font-family: Arial, sans-serif; background-color: #203149; color: #333; margin: 0 auto; padding: 20px; border-radius: 10px; max-width: 900px;">
                        <h1 style="color: #ffffff; font-size: 36px; font-weight: bold; font-family: Remachine Script, cursive;">Your Journey Map is Ready!</h1>
                        <div style="margin: 0 auto; max-width: 600px;">
                            <p style="font-size: 20px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 15px;">
                                Here\'s your personalized journey map based on the interests you\'ve selected in the survey.  
                            </p>
                    ';

                foreach ($json_data as $result) {
                    $session_id = $result['Session ID'];
                    $session_title = $result['Session Title'];
                    $date1 = $result['Date'];
                    $time1 = $result['Timeam'];
                    $time2 = $result['Timepm'];
                    $speaker = $result['Speaker'];
                    $time_slot_identifier = "$date1-$time1";

                    if (!in_array($session_title, $printed_session_ids)) {
                        if (!empty($time1) && !in_array($time_slot_identifier, $reserved_time1)) {
                            $emailContent .= '
                            <div style="background-color: #bcd5ca; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                                <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">'.$result['Session Title'].'</p>
                                
                                <div style="display: inline-block; margin-right: 20px; text-align: center; align-items: center;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/8801/8801434.png" alt="Speaker Icon" style="display: inline-block; width: 20px; height: 20px; margin-right: 5px;">
                                    <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; display: inline-block;">'.$speaker.'</p>
                                </div>

                                <div style="display: inline-block; margin-right: 20px; text-align: center; align-items: center;">
                                    <img src="https://icones.pro/wp-content/uploads/2022/08/icone-du-calendrier-des-evenements-vert.png" alt="Calendar Icon" style="display: inline-block; width: 20px; height: 20px; margin-right: 5px;">
                                    <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; display: inline-block;">'.$date1.'</p>
                                </div>

                                <div style="display: inline-block; margin-right: 20px; text-align: center; align-items: center;">
                                    <img src="https://icones.pro/wp-content/uploads/2021/03/symbole-de-l-horloge-verte.png" alt="Calendar Icon" style="display: inline-block; width: 20px; height: 20px; margin-right: 5px;">
                                    <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; display: inline-block;">'.$time1.'</p>
                                </div>
                            </div>
                            ';
                            $reserved_time1[] = $time_slot_identifier;
                            $sqlInsertSessionRecommend = "INSERT INTO sesion_recommend (event_id, session_title, participants_id) VALUES ('$event_id', '$session_title', '$participants_id')";
                            mysqli_query($connection, $sqlInsertSessionRecommend);
                        } elseif (!empty($time2) && !in_array($time_slot_identifier, $reserved_time2)) {
                            $emailContent .= '
                            <div style="background-color: #bcd5ca; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; ">
                                <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">'.$result['Session Title'].'</p>
                                
                                <div style="display: inline-block; margin-right: 20px; text-align: center; align-items: center;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/8801/8801434.png" alt="Speaker Icon" style="display: inline-block; width: 20px; height: 20px; margin-right: 5px; margin-bottom: -4px;">
                                    <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; display: inline-block;">'.$speaker.'</p>
                                </div>

                                <div style="display: inline-block; margin-right: 20px; text-align: center; align-items: center;">
                                    <img src="https://icones.pro/wp-content/uploads/2022/08/icone-du-calendrier-des-evenements-vert.png" alt="Calendar Icon" style="display: inline-block; width: 20px; height: 20px; margin-right: 5px;">
                                    <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; display: inline-block;">'.$date1.'</p>
                                </div>

                                <div style="display: inline-block; margin-right: 20px; text-align: center; align-items: center;">
                                    <img src="https://icones.pro/wp-content/uploads/2021/03/symbole-de-l-horloge-verte.png" alt="Calendar Icon" style="display: inline-block; width: 20px; height: 20px; margin-right: 5px;">
                                    <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; display: inline-block;">'.$time2.'</p>
                                </div>
                            </div>
                            ';
                            $reserved_time2[] = $time_slot_identifier;
                            $sqlInsertSessionRecommend = "INSERT INTO sesion_recommend (event_id, session_title, participants_id) VALUES ('$event_id', '$session_title', '$participants_id')";
                            mysqli_query($connection, $sqlInsertSessionRecommend);
                        }
                        $printed_session_ids[] = $session_title;
                    }
                }

                $emailContent .= '
                    <div style="background-color: #203149; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                        <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #ffffff;">Your registration has been confirmed!</p>
                        <p style="font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #ffffff;">Please save the QR code below to enter the event:</p>
                        <div style="margin: 0 auto;">
                            <img src="'.$outputFileName.'" alt="QR Code">
                        </div>
                    </div>
                </div>
                </body>';
            } else {
                // Handle the case where the JSON data is invalid or empty
                echo "Error: Invalid or empty JSON data";
            }
        }

        // Email configuration
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'mail.eventrecommender.com';
            $mail->SMTPSecure = 'tls'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'event@eventrecommender.com';
            $mail->Password = 'G3Cfah@uMY&~';
            $mail->Port = 587; // Change to your SMTP port
            $mail->setFrom('event@eventrecommender.com', 'New Event');

            // Recipients
            $mail->addAddress($email);

            // Attachments
            $mail->addAttachment($outputFileName); // Add QR code attachment

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Personalized Journey Map';
            $mail->Body = $emailContent;

            // Send the email
            $mail->send();
            echo 'Email has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Clean up
        unlink($outputFileName); // Delete the QR code image
    } else {
        echo "An error occurred while running the Python script.";
    }
    header("Refresh:0");
}
?>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/js/tailwind.config.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Style for the dropdown menus */

        .body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
    </style>
<body id="page-top">
<section class="bg-cover" style="background-image: url('https://media-s3-us-east-1.ceros.com/g3-communications/images/2021/04/21/bf088fa43296be6d4cee5685a37e6a30/untitled.gif');">
    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column body">

            <div id="content" class="container">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">         
                        <?php
                        if (isset($message)) {
                            echo '<h5 class="mb-3 text-base font-semibold text-gray-900 md:text-l dark:text-white">Sorry, you are not registered in this event!</h5>';
                            echo '<p class="mb-3 text-sm font-normal text-gray-500 dark:text-gray-400">Please check your email again or contact the event organizer for more details. Thank you!</p>'; 
                            echo '<img class="h-auto max-w-full mx-auto" src="https://media4.giphy.com/media/Bc4oup2pdP5iKFAYiF/200w.gif?cid=6c09b9520ewqcrypuassw0qj1nck4jcukefjjr5322adfum0&ep=v1_gifs_search&rid=200w.gif&ct=g" alt="image description">';
                        } else {
                            if ($reqPersons['status'] == 1) {
                                echo '<h5 class="mb-3 text-base font-semibold text-gray-900 md:text-l dark:text-white text-center">Thank you for sharing your Interest with us!!</h5>';
                                echo '<p class="mb-3 text-sm font-normal text-gray-500 dark:text-gray-400 text-center">We will send you a journey map for the event based on your interest.</p>'; 
                                echo '<img class="h-auto max-w-full mx-auto" src="https://assets-global.website-files.com/6091b7081a1d7e13ccd7603a/63f018f7c54c02f7cdc1c256_giphy-3.gif" alt="image description">';
                            } elseif (isset($message)) {
                                echo "No email and event ID found";
                            } else {
                        ?>
                        <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white text-center">
                        Interest Survey Form
                        </h5>
                        <p class="mb-3 text-sm font-normal text-gray-500 dark:text-gray-400 text-center">Tell us your interest and we'll take care of the rest!!</p>

                        <form method="post">
                            <input type="hidden" value="<?php echo $_GET['eventID'] ?>" name="event_id">
                            <input type="hidden" value="<?php echo $_GET['email'] ?>" name="email">
                            <div class="form-group">
                                <?php
                                $con = openConnection();

                                // Retrieve distinct technologies from the event_session table
                                $strSql = "SELECT DISTINCT technology FROM event_sessions where event_id = '$event_id'";
                                $result = getRecord($con, $strSql);

                                // Loop through the distinct technologies and create a dropdown for each
                                foreach ($result as $key => $value) {
                                    $techName = $value['technology'];
                                    $techNameFormatted = str_replace(' ', '_', $techName);
                                    
                                    // Query the event_session table for technology lines related to the current technology
                                    $dropdownSql = "SELECT DISTINCT technology_line FROM event_sessions WHERE technology = '$techName'";
                                    $dropdownResult = getRecord($con, $dropdownSql);
                                    echo '<div class="mb-3 flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">';
                                    echo '<label for="technology[]" class="ms-2 mb-0 text-sm font-medium text-gray-900 dark:text-gray-300">';
                                    echo '<input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="technology[]" id="technology_' . $techNameFormatted . '" value="' . $techNameFormatted . '">';
                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $techName;
                                    echo '</label>';
                                    echo '</div>';

                                    // Create the dropdown menu
                                    echo '<select class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 hidden ..." name="dropdown_' . $techNameFormatted  . '">';
                                    foreach ($dropdownResult as $dropdownKey => $dropdownValue) {
                                        $optionValue = $dropdownValue['technology_line'];
                                        echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                                    }
                                    echo '</select>';
                                    
                                }
                                ?>
                                <button type="submit"  class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="btnSubmit">Submit Form</button>
                            </form>
                        </div>
                    </div>
                <?php } } ?>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    </section>
    <?php //include 'script.php'; ?>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        var maxChecked = 3; // Set the maximum number of checkboxes allowed

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                var checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');

                if (checkedCheckboxes.length >= maxChecked) {
                    checkboxes.forEach(function (cb) {
                        if (!cb.checked) {
                            cb.disabled = true;
                        }
                    });
                } else {
                    checkboxes.forEach(function (cb) {
                        cb.disabled = false;
                    });
                }

                var techName = this.value;
                var dropdown = document.querySelector('select[name="dropdown_' + techName + '"]');

                if (this.checked) {
                    dropdown.style.display = "block";
                    // Print the name of the checked technology to the console
                    console.log("Checked technology: " + techName);
                } else {
                    dropdown.style.display = "none";
                }
            });
        });
    });

</script>