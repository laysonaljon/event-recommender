<?php
include 'connection.php';
$connection = openConnection();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'participantName' => ''];

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
                // Query to get participant name
                $sqlParticipant = "SELECT full_name FROM participants WHERE participants_id = '$scannedData'";
                $participantResult = $connection->query($sqlParticipant);
                $participantName = $participantResult->fetch_assoc()['full_name'] ?? 'Unknown Participant';

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
    http_response_code(400); // Bad Request
    $response['message'] = 'Invalid input data';
}

echo json_encode($response);
?>
