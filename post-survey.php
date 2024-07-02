<?php
    session_start();
    include 'connection.php';
    require 'vendor/autoload.php'; // Include Composer's autoloader

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $event_id = isset($_GET['eventID']) ? $_GET['eventID'] : null;
    $email = isset($_GET['email']) ? $_GET['email'] : null;
    
    // try {
    //     if ($event_id !== null && $email !== null) {
    //         $connection = openConnection();
    //         $strSql = "SELECT * FROM participants where event_id = '$event_id' and email = '$email'";
    //         $result = mysqli_query($connection, $strSql);
    //         if ($result) {
    //             if (mysqli_num_rows($result) > 0) {
    //                 $reqPersons = mysqli_fetch_array($result);
    //                 mysqli_free_result($result);
    //             }
    //         }
           
    //     } else {
    //         throw new Exception('No event ID or email');
    //     }
    // } catch (Exception $e) {
    //     echo 'Error: ' . $e->getMessage();
    // }

    function getAttendance($connection, $email, $event_id){
        $sessionsInfo = array();
        $sqlSelectAttendance = "SELECT * FROM attendance as a 
                                join event_sessions as es on a.session_title = es.session_title  where a.event_id = '$event_id' and a.email = '$email'";
        $result = mysqli_query($connection, $sqlSelectAttendance);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $sessionsInfo[] = $row;
            }
        }
        return $sessionsInfo;
    }
    function getTechnologiesLine($connection, $session_title, $event_id){
        $technologiesArray = array();
        $sqlTechnologies = "SELECT * FROM event_sessions  where event_id = '$event_id' and session_title = '$session_title'";
        $result = mysqli_query($connection, $sqlTechnologies);
        if($result){
            while ($row = mysqli_fetch_assoc($result)) {
                $technologiesArray[] = $row;
            }
        }
        return $technologiesArray;
    }
?>
    <?php include 'link.php'; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    /* Define the hidden class to hide elements */
    .hidden {
        display: none;
    }
    .bg-primary {
    background-color: #C9C9C8!important;
    }
    /* Center the content both horizontally and vertically */
    .vh-100 {
      min-height: 100vh;
    }

/* Add this CSS to your stylesheet or within a <style> tag in your HTML */


</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var checkboxes = document.querySelectorAll('.session-checkbox');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            var sessionId = this.getAttribute('data-session');
            var techCheckboxes = document.querySelectorAll('.tech-checkboxes[data-session="' + sessionId + '"]');
            
            techCheckboxes.forEach(function (techCheckbox) {
                // Toggle the hidden class to show/hide the checkboxes
                techCheckbox.classList.toggle("hidden", !this.checked);
            }.bind(this));
        });
    });
});

</script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="http://localhost/event-recommender/jshttp://localhost/new-event-recommender/event-recommender/js/tailwind.config.js"></script>


<!-- Your HTML code remains unchanged -->
<!-- https://wp.technologyreview.com/wp-content/uploads/2019/04/mit-final-gif-tsjisse-talsma-10.gif-->
<body id="page-top">
    <section class="bg-white dark:bg-gray-900 p-10 flex justify-center ...  bg-cover" style="background-image: url('https://media-s3-us-east-1.ceros.com/g3-communications/images/2021/04/21/bf088fa43296be6d4cee5685a37e6a30/untitled.gif');">      
        <?php
            $connection = openConnection();
            $attendance = getAttendance($connection, $email, $event_id);
            if (!empty($attendance)){ ?>
                <div class="w-full max-w-5xl p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Thank you for attending the event!!</h2>
                    <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Hope you had a great time, let us know what you think about the event. Cheers!!!</p>
                    <form method="post">
                        <div class="form-group">
                            <label for="card-body-survey" class="block mb-2 text-m font-bold text-gray-900 dark:text-gray-400">Which of the sessions you've attended did you enjoy the most?</label>
                            <div class="card-body" id="card-body-survey">
                                <?php
                                $printedSessions = []; // Create an array to track printed session titles

                                foreach ($attendance as $value) {
                                    $session_title = $value['session_title'];

                                    // Check if the session title has already been printed
                                    if (!in_array($session_title, $printedSessions)) {
                                        // Mark the session title as printed
                                        $printedSessions[] = $session_title;
                                        ?>
                                        <label class="mb-2 flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                            <input type="checkbox" class="session-checkbox mx-1" data-session="<?php echo $session_title; ?>" name="session[]" value="<?php echo $session_title; ?>"><?php echo $session_title; ?>
                                        </label>
                                        <div class="tech-checkboxes hidden" data-session="<?php echo $session_title; ?>">
                                            <div class="w-full max-w mb-2 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                                <p class="text-m font-normal text-gray-900 dark:text-gray-400">What topics from this session do you thinks would be useful to you?</p>
                                            
                                                <div class="columns-2 p-2">
                                                    <?php
                                                        $technologies = getTechnologiesLine($connection, $session_title, $event_id);
                                                        $existingTechLines = []; // Array to store existing technology lines

                                                        foreach ($technologies as $checkboxValue) {
                                                            $techLine = $checkboxValue['technology_line'];

                                                            // Check if the technology line already exists
                                                            if (!in_array($techLine, $existingTechLines)) {
                                                                // If it doesn't exist, add it to the array of existing technology lines
                                                                $existingTechLines[] = $techLine;

                                                                // Output the checkbox HTML
                                                                ?>
                                                                <div class="w-full flex mb-1 items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                                                    <label for="technology_line[]" class="w-full py-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                        <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" name="technology_line[]" id="technology_<?php echo $techLine; ?>" value="<?php echo $techLine; ?>">
                                                                        <?php echo $techLine; ?>
                                                                    </label>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment" class="block mb-2 text-m font-bold text-gray-900 dark:text-gray-400">Comment:</label>
                            <textarea placeholder="Share us your thoughts..." class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" id="comment" name="comment" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="suggestion" class="block mb-2 text-m font-bold text-gray-900 dark:text-gray-400">Suggestion:</label>
                            <textarea placeholder="Let us know what you think..." class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" id="suggestion" name="suggestion" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="message" class="block mb-2 text-m font-bold text-gray-900 dark:text-gray-400">Your message</label>
                            <input class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" id="S_event" name="S_event" required></input>
                        </div>
                        <button type="submit" class="py-3 px-5 text-m font-bold text-center text-white rounded-lg bg-primary-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="btnSubmit">Submit</button>
                    </form>
                </div>
        
            <?php
            }
            else{
                echo '
                    <div class="col-md-12 d-flex justify-content-center align-items-center vh-100">
                        <div class="card bg-primary">
                            <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bgS-gray-800 dark:border-gray-700">
                                <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-l dark:text-white ">Your response was already sent!</h5>
                                <p class="mb-3 text-sm font-normal text-gray-500 dark:text-gray-400">Thank you for attending the event and responding to this survey, we hope you had a great time with us!</p>
                                <img class="h-auto max-w-full mx-auto" src="https://media2.giphy.com/media/nnZZfXUevHdz27aH7u/giphy.gif?cid=ecf05e472kgs6a5ubeemzq7aq6bkpy309bgm93y5zz79li92&ep=v1_gifs_related&rid=giphy.gif&ct=g" alt="image description">
                            </div>
                        </div>
                    </div>
                    ';
            }
        ?>
        <!-- Page Wrapper -->
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <?php include'script.php'; ?>
    </section>
</body>

<?php
if (isset($_POST['btnSubmit'])) {
    $connection = openConnection();
    $comment = $_POST['comment'];
    $suggestion = $_POST['suggestion'];
    $S_event = $_POST['S_event'];
    $sqlInsertComment = "INSERT INTO comment (comment, suggestion, similar_event, event_id, email) VALUES ('$comment', '$suggestion', '$S_event', '$event_id', '$email')";
    
    $dataset = array();
    $selected_data = [];
    if (mysqli_query($connection, $sqlInsertComment)) {
        $comment_id = mysqli_insert_id($connection);
        if (isset($_POST['technology_line']) && is_array($_POST['technology_line'])) {
            foreach ($_POST['technology_line'] as $technology_line) {
                $sqlInsertSurvey = "INSERT INTO survey (comment_id, technology_line) VALUES('$comment_id', '$technology_line')";
                if (mysqli_query($connection, $sqlInsertSurvey)) {
                    $selected_data[] = $technology_line;
                }
            }
        }
    }
    $strSqlGetTechnologyLine = "SELECT * FROM response where event_id = '$event_id' AND email = '$email'";
    // Execute the SQL query and fetch the data
    $result = mysqli_query($connection, $strSqlGetTechnologyLine);
    // Fetch rows and add them to the dataset array
    while ($row = mysqli_fetch_assoc($result)) {
        $selected_data[] = $row['response'];
    }
    // Retrieve the dataset
    $datasetSql = "SELECT * from event_sessions where event_id = '$event_id'";
    
    // Execute the SQL query and fetch the data
    $resultDataset = mysqli_query($connection, $datasetSql);
    
    // Initialize an array to store dataset entries
    $dataset = array();

    // Fetch rows and add them to the dataset array
    while ($row = mysqli_fetch_assoc($resultDataset)) {
        $dataset[] = $row;
    }
    /// Combine the data into an associative array
    $dataToPass = array(
        "user_preferences" => $selected_data,
        "dataset" => $dataset
    );
     // Encode the data as JSON
    $jsonData = json_encode($dataToPass);
    // Create a temporary file to store the JSON data
    $tempFile = tempnam(sys_get_temp_dir(), 'json_data');
    file_put_contents($tempFile, $jsonData);

    // Use escapeshellarg to properly escape the file path for the command line
    $fileArg = escapeshellarg($tempFile);

    // Call your Python script with the file path as an argument
    $command = "python new-product.py $fileArg";
    exec($command, $output, $returnCode);

    // Remove the temporary file
    unlink($tempFile);
    if ($returnCode === 0) {
        $emailContent = '
            <body style="text-align: center; font-family: Arial, sans-serif; background-color: #050a19; color: #333; margin: 0 auto; padding: 20px; border-radius: 10px; max-width: 900px;">
                <h1 style="color: #ffffff; font-size: 36px; font-weight: bold; font-family: Remachine Script, cursive;">Discover top-notch products tailored just for you!</h1>
                <img src="https://i.gifer.com/7S7F.gif" alt="Event Image" draggable="false" style="width: 600px; height: 400px;" />
                
                
                <div style="margin: 0 auto; max-width: 600px; margin-bottom: 20px;">
                    <p style="font-size: 20px; line-height: 150%; text-align: center; color: #ffffff; margin-bottom: 50px;">
                        We hope this email finds you well and that you\'ve been enjoying the sessions and content you recently attended. Your interests and preferences matter to us, and we\'re thrilled to share some personalized product recommendations tailored just for you.
                    </p>
        ';
        $processedProductNames = []; // Array to store processed product names

        foreach ($output as $line) {
            // Parse the JSON data sent by the Python script
            $json_data = json_decode($line, true);

            if ($json_data) {
                foreach ($json_data as $result) {
                    $product_name = $result['product_name'];

                    // Check if the product name is not already processed
                    if (!in_array($product_name, $processedProductNames)) {
                        // Add the product name to the processed list
                        $processedProductNames[] = $product_name;

                        $strsqlInsertProduct = "INSERT INTO product_recommend (event_id, email, product_name) VALUES('$event_id', '$email', '$product_name')";
                        mysqli_query($connection, $strsqlInsertProduct);
                        // Add the product name to the email content
                        $emailContent .= '
                            <div style="background-color: #24a74b; padding: 20px; border-radius: 10px; margin-bottom: 20px; text-align: left; display: flex; align-items: center;">
                                <img src="https://cdn-icons-png.flaticon.com/512/10248/10248137.png" alt="Speaker Icon" style="display: inline-block; width: 30px; height: 30px; margin-right: 5px; padding:5px">
                                <h2 style="display: inline-block; color: #ffffff; font-size: 16px; font-weight: bold; margin-bottom: 5px;">'.$product_name.'</h2>
                            </div>
                        ';
                    }
                }
            }
        }

        $emailContent .= '
                    </div>

                    <p style="font-size: 16px; color: #ffffff; margin-bottom: 15px; margin-top: 50px; font-style: italic;">
                        If you have any questions or need assistance, please feel free to contact us at <br> 
                        <a href="mailto:email@gmail.com" style="color: #9ec6e0; text-decoration: none;">email@gmail.com</a> or <a href="tel:09123456789" style="color: #9ec6e0; text-decoration: none;">09123456789</a>.
                    </p>
                
                </body>
                ';
            $mail = new PHPMailer(true);
            // SMTP settings (you may need to configure these)
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPSecure = 'tls'; // Use 'tls' for TLS encryption
            $mail->SMTPAuth = true;
            $mail->Username = 'cfb40b95b2f107';
            $mail->Password = 'eb5ad7a1ab00fc';
            $mail->Port = 587; // Change to your SMTP port

            // Set the "From" address correctly
            $mail->setFrom('event@eventrecommender.com', 'Event Organizer');

            $mail->addAddress($email); // Recipient's email address
            $mail->isHTML(true);
            $mail->Subject = "Our Curated Selection for You!";

            // Embed the QR code image in the email body
            $mail->Body = $emailContent;

            // Send the email
            if ($mail->send()) {
                echo '<script type="text/javascript">
                    swal({
                        title: "Success",
                        text: "Successfully Answered survey",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = "./post-survey.php";
                    });
                </script>';
            } else {
                echo "Email sending failed: " . $mail->ErrorInfo;
            }
    }
    else {
        // There was an error executing the Python script
        echo "Error executing Python script. Return code: $returnCode";
    }
}

?>