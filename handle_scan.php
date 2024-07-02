<?php
session_start();
include 'connection.php';

// Assuming getSessionByEvent function is defined somewhere
$event_id = $_POST['event_id'];
$session_title = $_POST['session_title'];
$scannedData = $_POST['scanned_data'];
date_default_timezone_set('Asia/Manila');

// Validate and process the scanned data here
$connection = openConnection();
$dateIn = date("Y-m-d");
$timeIn = date("H:i:s");

$sqlSearch = "SELECT * FROM attendance WHERE event_id = '$event_id' AND email='$scannedData' AND session_title='$session_title'";
$result = $connection->query($sqlSearch);

if ($result->num_rows === 0) {
    // Insert data into the database
    $sqlInsert = "INSERT INTO attendance (event_id, session_title, email, dateIn, timeIn) 
                  VALUES ('$event_id', '$session_title', '$scannedData', '$dateIn', '$timeIn')";
    if ($connection->query($sqlInsert) === TRUE) {
        $response = array('success' => 1);
    } else {
        $response = array('success' => 0, 'error' => $connection->error);
    }
} else {
    $response = array('success' => 2);
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
