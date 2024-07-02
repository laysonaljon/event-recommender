<?php
include 'connection.php';
$connection = openConnection();

if (isset($_POST['scanned_data'], $_POST['event_id'], $_POST['dropdownSession'])) {
    $scannedData = $_POST['scanned_data'];
    $event_id = $_POST['event_id'];
    $session_title = $_POST['dropdownSession'];
    $dateIn = date("Y-m-d");
    $timeIn = date("H:i:s");

    // Check if the participant has already been scanned for this session
    $sqlSearch = "SELECT * FROM attendance WHERE event_id = '$event_id' AND participants_id='$scannedData' AND session_title='$session_title'";
    $result = $connection->query($sqlSearch);

    if ($result) {
        if ($result->num_rows === 0) {
            // Insert data into the database
            $sqlInsert = "INSERT INTO attendance (event_id, session_title, participants_id, dateIn, timeIn) 
                          VALUES ('$event_id', '$session_title', '$scannedData', '$dateIn', '$timeIn')";
            
            if ($connection->query($sqlInsert) === TRUE) {
                // Redirect to success page with parameters
                header("Location: event_qr_scanner_tailwind.php?event_id=$event_id&session_title=$session_title&success=1&participants_id=$scannedData");
                exit;
            } else {
                echo "Error: " . $sqlInsert . "<br>" . $connection->error;
            }
        } else {
            // Participant has already been scanned for this session
            header("Location: event_qr_scanner_tailwind.php?event_id=$event_id&session_title=$session_title&success=2&participants_id=$scannedData");
            exit;
        }
    } else {
        echo "Error executing query: " . $connection->error;
    }
} else {
    http_response_code(400); // Bad Request
    echo "Invalid input data";
}
?>
