<?php
    session_start();
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
    include 'phpqrcode\phpqrcode\qrlib.php';
    require 'vendor/autoload.php'; // Include Composer's autoloader
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE>
<html>
    <head>
        <title>Demand Gen</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/tailwind.config.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
        
    </head>
   
    <body class="transition-colors duration-300 ease-in-out dark:bg-gray-800" id="body">
        
        <!-- Sidebar -->
        <?php include 'sidebar_tailwind.php'; ?>

        <!-- Events -->
        <section class="p-4 sm:ml-64">
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Add Event</h2>
            <form id="eventForm" method="POST" enctype="multipart/form-data">
                <div class="mb-6">
                    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Name</label>
                    <input type="text" id="default-input" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="eventTitle" required>
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <label class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">
                        Upload Participants File <span class="italic text-gray-600">(CSV file)</span>
                    </label>
                    <input class="block w-1/4 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-100 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file" name="csvFile" id="csvFile" accept=".csv" required>
                
                    <label class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">
                        Upload Event File <span class="italic text-gray-600">(CSV file)</span>
                    </label>
                    <input class="block w-1/4 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-100 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file" name="csvSession" id="csvSession" accept=".csv" required>
                </div>
                <button type="submit" form="eventForm" name="btnSubmit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
    
            </form>
        </section>

        <!-- Resources -->
        <section class="p-4 sm:ml-64">
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Downloadables</h2>
            <button onclick="window.location.href='downloadables/Participants.csv';" type="submit" form="eventForm" name="btnSubmit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg  height="20px" width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.5535 16.5061C12.4114 16.6615 12.2106 16.75 12 16.75C11.7894 16.75 11.5886 16.6615 11.4465 16.5061L7.44648 12.1311C7.16698 11.8254 7.18822 11.351 7.49392 11.0715C7.79963 10.792 8.27402 10.8132 8.55352 11.1189L11.25 14.0682V3C11.25 2.58579 11.5858 2.25 12 2.25C12.4142 2.25 12.75 2.58579 12.75 3V14.0682L15.4465 11.1189C15.726 10.8132 16.2004 10.792 16.5061 11.0715C16.8118 11.351 16.833 11.8254 16.5535 12.1311L12.5535 16.5061Z" fill="#ffffff"></path> <path d="M3.75 15C3.75 14.5858 3.41422 14.25 3 14.25C2.58579 14.25 2.25 14.5858 2.25 15V15.0549C2.24998 16.4225 2.24996 17.5248 2.36652 18.3918C2.48754 19.2919 2.74643 20.0497 3.34835 20.6516C3.95027 21.2536 4.70814 21.5125 5.60825 21.6335C6.47522 21.75 7.57754 21.75 8.94513 21.75H15.0549C16.4225 21.75 17.5248 21.75 18.3918 21.6335C19.2919 21.5125 20.0497 21.2536 20.6517 20.6516C21.2536 20.0497 21.5125 19.2919 21.6335 18.3918C21.75 17.5248 21.75 16.4225 21.75 15.0549V15C21.75 14.5858 21.4142 14.25 21 14.25C20.5858 14.25 20.25 14.5858 20.25 15C20.25 16.4354 20.2484 17.4365 20.1469 18.1919C20.0482 18.9257 19.8678 19.3142 19.591 19.591C19.3142 19.8678 18.9257 20.0482 18.1919 20.1469C17.4365 20.2484 16.4354 20.25 15 20.25H9C7.56459 20.25 6.56347 20.2484 5.80812 20.1469C5.07435 20.0482 4.68577 19.8678 4.40901 19.591C4.13225 19.3142 3.9518 18.9257 3.85315 18.1919C3.75159 17.4365 3.75 16.4354 3.75 15Z" fill="#ffffff"></path> </g></svg>  
                <span class="px-2">Download Participant CSV</span>
                
            </button>

            <button onclick="window.location.href='downloadables/Event.csv';" type="submit" form="eventForm" name="btnSubmit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg  height="20px" width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.5535 16.5061C12.4114 16.6615 12.2106 16.75 12 16.75C11.7894 16.75 11.5886 16.6615 11.4465 16.5061L7.44648 12.1311C7.16698 11.8254 7.18822 11.351 7.49392 11.0715C7.79963 10.792 8.27402 10.8132 8.55352 11.1189L11.25 14.0682V3C11.25 2.58579 11.5858 2.25 12 2.25C12.4142 2.25 12.75 2.58579 12.75 3V14.0682L15.4465 11.1189C15.726 10.8132 16.2004 10.792 16.5061 11.0715C16.8118 11.351 16.833 11.8254 16.5535 12.1311L12.5535 16.5061Z" fill="#ffffff"></path> <path d="M3.75 15C3.75 14.5858 3.41422 14.25 3 14.25C2.58579 14.25 2.25 14.5858 2.25 15V15.0549C2.24998 16.4225 2.24996 17.5248 2.36652 18.3918C2.48754 19.2919 2.74643 20.0497 3.34835 20.6516C3.95027 21.2536 4.70814 21.5125 5.60825 21.6335C6.47522 21.75 7.57754 21.75 8.94513 21.75H15.0549C16.4225 21.75 17.5248 21.75 18.3918 21.6335C19.2919 21.5125 20.0497 21.2536 20.6517 20.6516C21.2536 20.0497 21.5125 19.2919 21.6335 18.3918C21.75 17.5248 21.75 16.4225 21.75 15.0549V15C21.75 14.5858 21.4142 14.25 21 14.25C20.5858 14.25 20.25 14.5858 20.25 15C20.25 16.4354 20.2484 17.4365 20.1469 18.1919C20.0482 18.9257 19.8678 19.3142 19.591 19.591C19.3142 19.8678 18.9257 20.0482 18.1919 20.1469C17.4365 20.2484 16.4354 20.25 15 20.25H9C7.56459 20.25 6.56347 20.2484 5.80812 20.1469C5.07435 20.0482 4.68577 19.8678 4.40901 19.591C4.13225 19.3142 3.9518 18.9257 3.85315 18.1919C3.75159 17.4365 3.75 16.4354 3.75 15Z" fill="#ffffff"></path> </g></svg>  
                <span class="px-2">Download Event CSV</span>
            </button>
        </section>
    </body>
</html>
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
                        if (array_filter($data) == []) {
                            continue; // Skip empty rows
                        }
                        $session_title = $data[0]; 
                        $technology = $data[1]; 
                        $technology_line = $data[2]; 
                        $product_name = $data[3];
                        $speaker = $data[4];
                        $speaker_special = $data[5];
                        $date = $data[6];
                        $timeam = $data[7];
                        $timepm = $data[8];
                        $location = $data[9];
                        $sqlSession = "INSERT INTO event_sessions (event_id, session_title, technology, technology_line, product_name, speaker, speaker_special, date, timeam, timepm, location1) VALUES ('$event_id','$session_title', '$technology', '$technology_line', '$product_name', '$speaker', '$speaker_special', '$date', '$timeam', '$timepm', '$location')";
                        mysqli_query($connection, $sqlSession);
                    }
                    fclose($handle);
                } else {
                    echo "Failed to open the CSV file.";
                }
            }

            if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
                $fileName = $_FILES["csvFile"]["name"];
                $tmpName = $_FILES["csvFile"]["tmp_name"];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if ($fileExtension != "csv") {
                    echo "Please upload a CSV file.";
                    exit();
                }
                if (($csvFile = fopen($tmpName, 'r')) !== FALSE) {
                    fgetcsv($csvFile); // Skip the header row
                    // $mail = new PHPMailer(true);
                    // $mail->isSMTP();
                    // $mail->Host = 'sandbox.smtp.mailtrap.io';
                    // $mail->SMTPSecure = 'tls'; // Use 'tls' for TLS encryption
                    // $mail->SMTPAuth = true;
                    // $mail->Username = '156188deb90963';
                    // $mail->Password = '655a23b860f42c';
                    // $mail->Port = 587; // Change to your SMTP port
                    // $mail->setFrom('event@eventrecommender.com', 'New Event');

                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'mail.eventrecommender.com';
                    $mail->SMTPSecure = 'tls'; 
                    $mail->SMTPAuth = true;
                    $mail->Username = 'event@eventrecommender.com';
                    $mail->Password = 'G3Cfah@uMY&~';
                    $mail->Port = 587; // Change to your SMTP port
                    $mail->setFrom('event@eventrecommender.com', 'New Event');

                    while (($row = fgetcsv($csvFile)) !== FALSE) {
                        if (array_filter($row) == []) {
                            continue; // Skip empty rows
                        }
                        $email = $row[0];
                        $full_name = $row[1];
                        $company = $row[2];
                        $designation = $row[3];

                        $sqlInsertParticipant = "INSERT INTO participants (event_id, email, full_name, company, designation, status) VALUES ('$event_id', '$email', '$full_name', '$company', '$designation', 0)";
                        if (mysqli_query($connection, $sqlInsertParticipant)) {
                            $participants_id = mysqli_insert_id($connection);
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
                                        <a href="http://13.238.159.63/event-form.php?eventID='.$event_id.'&email='.$email.'&participants_id='.$participants_id.'"
                                        style="display: inline-block; padding: 12px 24px; background-color: transparent; color: #ffffff; text-decoration: none; border: 2px solid #ffffff; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">
                                            Take the Interest Survey
                                        </a>
                                    </p>
                                </div>
                                <p style="font-size: 16px; color: #ffffff; margin-bottom: 15px; font-style: italic;">
                                    If you have any questions or need assistance, please feel free to contact us at <br> 
                                    <a href="mailto:email@gmail.com" style="color: #3498db; text-decoration: none;">email@gmail.com</a> or <a href="tel:09123456789" style="color: #3498db; text-decoration: none;">09123456789</a>.
                                </p>
                            </body>';
                            
                            $mail->clearAddresses();
                            $mail->addAddress($email); // Recipient's email address
                            $mail->isHTML(true);
                            $mail->Subject = $eventTitle;
                            $mail->Body = $emailContent;

                            if (!$mail->send()) {
                                echo "Failed to send email to $email.<br>";
                            }
                        } else {
                            echo "Failed to insert participant with email: $email.<br>";
                        }
                    }
                    fclose($csvFile);
                } else {
                    echo "Failed to open the CSV file for participants.<br>";
                }
            }
            echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success",
                        text: "Successfully added event",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location = "event_tailwind.php"; // Redirect to the desired page
                    });
                </script>';
        } else {
            echo '<script type="text/javascript">
                    Swal.fire({
                        title: "Warning",
                        text: "Failed to add event. Redirecting in 2 seconds.",
                        icon: "warning",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location = "event_tailwind.php"; // Redirect to the desired page
                    });
                </script>';
        }
    }
?>