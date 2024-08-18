<?php
include 'connection.php';
$connection = openConnection();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'participantName' => ''];

if (isset($_POST['scanned_data'], $_POST['event_id'], $_POST['dropdownSession'])) {
    $scannedData = $_POST['scanned_data']; // This seems to be the email
    $event_id = $_POST['event_id'];
    $session_title = $_POST['dropdownSession'];
    $dateIn = date("Y-m-d");
    $timeIn = date("H:i:s");

    // Get the participant's ID using the email
    $sqlParticipant = "SELECT participants_id, full_name FROM participants WHERE email = '$scannedData' AND event_id = '$event_id'";
    $participantResult = $connection->query($sqlParticipant);

    if ($participantResult && $participantResult->num_rows > 0) {
        $participantRow = $participantResult->fetch_assoc();
        $participants_id = $participantRow['participants_id'];
        $participantName = $participantRow['full_name'];

        // Check if the participant has already been scanned for this session
        $sqlSearch = "SELECT * FROM attendance WHERE event_id = '$event_id' AND participants_id='$participants_id' AND session_title='$session_title'";
        $result = $connection->query($sqlSearch);

        if ($result) {
            if ($result->num_rows === 0) {
                // Insert data into the database
                $sqlInsert = "INSERT INTO attendance (event_id, session_title, participants_id, dateIn, timeIn, email) 
                              VALUES ('$event_id', '$session_title', '$participants_id', '$dateIn', '$timeIn', '$scannedData')";
                
                if ($connection->query($sqlInsert) === TRUE) {
                    // Prepare JSON response
                    $response['success'] = true;
                    $response['message'] = 'Participant successfully scanned!';
                    $response['participantName'] = $participantName;
                } else {
                    $response['message'] = 'Error: ' . htmlspecialchars($connection->error);
                }
            } else {
                $response['message'] = 'Participant already scanned for this session!';
            }
        } else {
            $response['message'] = 'Error executing query: ' . htmlspecialchars($connection->error);
        }
    } else {
        $response['message'] = 'Participant not found!';
    }
} else {
    http_response_code(400); // Bad Request
    $response['message'] = 'Invalid input data';
}

// Return the response as JSON
echo json_encode($response);

?>
