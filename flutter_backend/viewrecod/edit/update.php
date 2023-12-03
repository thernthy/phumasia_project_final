<?php
// Get the ID and updated values from the request
$id = $_GET['id'];
$data = json_decode(file_get_contents('php://input'), true);

// Extract the updated values
$selectedDate = $data['selectedDate'];
$selectedName = $data['selectedName'];
$selectedPlace = $data['selectedPlace'];
$lotTypeText = $data['lotTypeText'];
$goodText = $data['goodText'];
$brokenText = $data['brokenText'];
$brownText = $data['brownText'];
$selectedTask = $data['selectedTask'];

// TODO: Implement your database update logic here

// Connect to the database
$servername = "mysql1b.xserver.jp";
$username = "waa_phumasiacom";
$password = "EZ6F6DhJJJKF";
$dbname = "waa_phumasiacom";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the update statement
$stmt = $conn->prepare("UPDATE cashew_record SET date = ?, Name = ?, place = ?, Lot_type = ?, Good = ?, Broken = ?, Brown = ?, task = ? WHERE id = ?");
$stmt->bind_param("ssssssssi", $selectedDate, $selectedName, $selectedPlace, $lotTypeText, $goodText, $brokenText, $brownText, $selectedTask, $id);

// Execute the update statement
$updateSuccessful = $stmt->execute();

// Close the prepared statement and database connection
$stmt->close();
$conn->close();

// Prepare the response
$response = array();

// Check if the update was successful
if ($updateSuccessful) {
    $response['status'] = 'success';
    $response['message'] = 'Record updated successfully.';
} else {
    $response['status'] = 'failure';
    $response['message'] = 'Failed to update record.';
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>


