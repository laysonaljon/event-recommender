<?php
    session_start();
    include 'connection.php';
    date_default_timezone_set('Asia/Manila');
    $user_id = $_SESSION['user_id'];

    
    require 'vendor/autoload.php'; // Include Composer's autoloader

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Function to get event session titles, dates, and times for a specific event
    function getEventSessionsInfo($connection, $event_id) {
        $sessionsInfo = array();
        $sql = "SELECT DISTINCT session_title, date, timeam, timepm, event_id FROM event_sessions WHERE event_id = '$event_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sessionsInfo[] = $row;
            }
        }
        return $sessionsInfo;
    }

    function hasLocationData($event_id) {
        // Open database connection
        $con = openConnection();
    
        // Prepare the SQL statement
        $stmt = $con->prepare("SELECT COUNT(*) FROM location WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
    
        // Close the statement and connection
        $stmt->close();
        $con->close();
    
        // Return true if records exist, false otherwise
        if($count > 0)
            $validate = True;
        else
            $validate = False;
        return $validate;
    }
    
?>
<!DOCTYPE>
<html>
    <head>
        <title>Demand Gen</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/tailwind.config.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    </head>
        
    </head>
   
    <body class="transition-colors duration-300 ease-in-out dark:bg-gray-800" id="body">
        
        <!-- Sidebar -->
        <?php include 'sidebar_tailwind.php'; ?>

        
        <!-- Events -->
        <section class="p-4 sm:ml-64 ">
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">WPS</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <!-- Upload Modal -->
            <form method="post" enctype="multipart/form-data" action="" name="uploadForm">
                <div id="uploadLocation" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                        <p class="text-xl font-semibold text-gray-800 mb-4">Upload Location</p>
                        <p class="text-gray-700 mb-4">Please select a CSV file to upload for this event.</p>
                        <input type="hidden" id="upload_event_id" name="upload_event_id" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                        <div class="mb-4">
                            <input type="file" id="upload_file" name="upload_file" accept=".csv" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex justify-end">
                            <button id="cancelUpload" type="button" class="mr-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none">Cancel</button>
                            <button id="confirmUpload" name="confirmUpload" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none disabled:bg-gray-700 px-4 py-2 rounded-md" disabled>Upload</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Event Name</th>
                            <th scope="col" class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $con = openConnection();
                        $strSql = "SELECT * FROM events WHERE user_id = '$user_id' AND event_status != 0 ORDER BY event_id DESC";
                        $events = getRecord($con, $strSql);
                        foreach($events as $event) {
                            $event_id = $event['event_id'];
                            $event_title = $event['event_title'];
                            $eventSessions = getEventSessionsInfo($con, $event_id);
                            $hasLocationData = hasLocationData($event_id);
                            $totalCount = getTotalDistinctSessionTitlesByEvent($event_id);
                    ?>
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?php echo $event_title; ?></th>
                                <td class="px-4 py-3">
                                    <?php if (!$hasLocationData) { ?>
                                        <button 
                                            type="button" 
                                            onclick="openUploadModalLocation(<?php echo $event_id; ?>)" 
                                            class="w-[200px] rounded-lg border border-blue-700 px-3 py-1 text-center text-sm font-medium text-blue-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-600 dark:hover:text-white dark:focus:ring-blue-900 lg:w-auto"
                                        >
                                        Upload
                                        </button>
                                    <?php } else { ?>
                                        <button 
                                            type="button" 
                                            onclick="window.location.href='http://localhost/locations_tailwind.php?event_id=<?php echo $event_id; ?>'" 
                                            class="w-[200px] rounded-lg border border-green-700 px-3 py-1 text-center text-sm font-medium text-green-700 hover:bg-green-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-green-300 dark:border-green-500 dark:text-green-500 dark:hover:bg-green-600 dark:hover:text-white dark:focus:ring-green-900 lg:w-auto"
                                        >
                                            View
                                        </button>

                                        <?php } ?>
                                </td>
                            </tr>
                    <?php
                        }
                        // Close the database connection
                        closeConnection($con);
                    ?>
                    </tbody>
                </table>
            </div>
        </section>

        
      
<!-- Ensure you load SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
<?php
if (isset($_POST['confirmUpload'])) {
    // Check if file was uploaded without errors
    if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
        // Get the event ID from the hidden input field
        $event_id = $_POST['upload_event_id'];

        // Get file details
        $file_tmp = $_FILES['upload_file']['tmp_name'];
        $file_name_parts = explode('.', $_FILES['upload_file']['name']);
        $file_ext = strtolower(end($file_name_parts));

        // Check if the uploaded file is a CSV
        if ($file_ext == "csv") {
            // Open the CSV file
            if (($handle = fopen($file_tmp, "r")) !== FALSE) {
                // Skip the first row (header)
                $header = fgetcsv($handle, 1000, ",");

                // Prepare to insert data into the location table
                $insert_data = [];
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Assume the CSV columns are in the same order as the table fields
                    $insert_data[] = [
                        'event_id' => $event_id,
                        'date_and_time' => $data[0],
                        'device_id' => $data[1],
                        'user_id' => $data[2],
                        'location' => $data[3],
                        'signal_strength' => $data[4],
                        'access_point' => $data[5],
                        'action' => $data[6]
                    ];
                }
                fclose($handle);

                // Insert data into the database
                // Using your existing connection function
                $con = openConnection();

                // Prepare the SQL statement
                $stmt = $con->prepare("INSERT INTO location (event_id, date_and_time, device_id, user_id, location, signal_strength, access_point, action) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                foreach ($insert_data as $row) {
                    $stmt->bind_param("isssssss", $row['event_id'], $row['date_and_time'], $row['device_id'], $row['user_id'], $row['location'], $row['signal_strength'], $row['access_point'], $row['action']);
                    $stmt->execute();
                }

                $strSql = "SELECT * FROM attendance where event_id = '$event_id' group by email";
                $result = getRecord($con, $strSql);

                // Enable error reporting
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                set_time_limit(60); // Increase the time limit to 60 seconds (adjust as needed)


                // Use PHPMailer

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'mail.eventrecommender.com';
                $mail->SMTPSecure = 'tls'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'event@eventrecommender.com';
                $mail->Password = 'G3Cfah@uMY&~';
                $mail->Port = 587; // Change to your SMTP port
                $mail->setFrom('event@eventrecommender.com', 'New Event');

                try {
                    foreach ($result as $row) {
                        // Email parameters for each record
                        $to = $row['email'];
                        $event_id = $row['event_id'];
                        $subject = "POST SURVEY EVENT";
                        $message = '
                        <body style="text-align: center; font-family: Arial, sans-serif; background-color: #1f432d; color: #333; margin: 0 auto; padding: 20px; border-radius: 10px; max-width: 900px;">
                            <h1 style="color: #ffffff; font-size: 36px; font-weight: bold; font-family: Remachine Script, cursive;">Thank you for Joining Us!</h1>
                            <img src="https://png.pngtree.com/png-vector/20220724/ourmid/pngtree-celebration-people-celebrate-standing-happiness-png-image_6063519.png" alt="Event Image" draggable="false" style="width: 300px; height: 200px;" />
    
                            <div style="margin: 0 auto; max-width: 600px;">
                                <p style="font-size: 20px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 15px;">
                                    We appreciate your participation in our event, '.$eventTitle.'. <br>
                                    To help us improve future events, please take a moment to fill out our post-event survey.
                                </p>
                    
                                <p style="font-size: 16px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 15px; font-style: italic;">
                                    Thank you for your time and feedback!
                                </p>
                                <p style="text-align: center; margin: 40px;">
                                    <a href="http://13.238.159.63/event-form.php?eventID='.$event_id.'&email='.$email.'&participants_id='.$participants_id.'"
                                    style="display: inline-block; padding: 12px 24px; background-color: transparent; color: #ffffff; text-decoration: none; border: 2px solid #ffffff; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">
                                        Click to Access Post Event Survey
                                    </a>
                                </p>
                            </div>
                            <p style="font-size: 16px; color: #ffffff; margin-bottom: 15px; font-style: italic;">
                                Best regards,<br>
                                The Event Team
                            </p>
                        </body>
                        ';
                        
                        $mail->setFrom($from);
                        $mail->addAddress($to);
                        $mail->Subject = $subject;
                        $mail->msgHTML($message);
                        
                        $mail->send();
                    }
                } catch (Exception $e) {
                    echo "Email sending failed. Error: " . $mail->ErrorInfo;
                }

                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Success!",
                        text: "Redirecting in 2 seconds. Successfully upload location",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function(){
                        window.location.href = "./wps_tailwind.php";
                    });
                </script>
            ';
            }
        } else {
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Redirecting in 3 seconds. Failed to upload location.",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./wps_tailwind.php";
                });
            </script>
        ';
        }
    }
}
?>



<script>
    function openUploadModalLocation(eventId) {
        document.getElementById('upload_event_id').value = eventId;
        document.getElementById('uploadLocation').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadLocation').classList.add('hidden');
    }

    document.getElementById('cancelUpload').addEventListener('click', closeUploadModal);

       function toggleUploadButton() {
        const fileInput = document.getElementById('upload_file');
        const uploadButton = document.getElementById('confirmUpload');
        
        if (fileInput.files.length > 0) {
            uploadButton.disabled = false;
        } else {
            uploadButton.disabled = true;
        }
    }

    document.getElementById('upload_file').addEventListener('change', toggleUploadButton);

    document.addEventListener('DOMContentLoaded', () => {
        toggleUploadButton();
    });
</script>

