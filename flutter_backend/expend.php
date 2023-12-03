<?php
// Get the POST data
$expendingType = $_POST['expendingType'];
$good = $_POST['good'];
$broken = $_POST['broken'];
$brown = $_POST['brown'];
$date = $_POST['date'];

// Perform your database insertion here
// Modify the code below to fit your database setup

// Assuming you are using MySQLi
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phumasa_cashew_nut";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    $response = array('success' => false);
    echo json_encode($response);
    die();
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO expend (date, expend_type, good, broken, brown) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    $response = array('success' => false);
    echo json_encode($response);
    die();
}

// Bind the variables to the prepared statement
$stmt->bind_param("sssss", $date, $expendingType, $good, $broken, $brown );
// Execute the statement
if ($stmt->execute()) {
    $response = array('success' => true);
    echo json_encode($response);
} else {
    $response = array('success' => false);
    echo json_encode($response);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
