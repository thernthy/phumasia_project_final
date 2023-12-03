<?php
// Retrieve the username from the request
$username = $_GET['username'] ?? '';
// Create a new MySQLi object
$mysqli = new mysqli('mysql1b.xserver.jp', 'waa_phumasiacom', 'EZ6F6DhJJJKF', 'waa_phumasiacom');

// Check for connection errors
if ($mysqli->connect_errno) {
    // Handle the connection error
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

$sql = "SELECT date, Name, place, Lot_type, Good, Broken, Brown, task, id FROM cashew_record WHERE Name = ? AND MONTH(date) = ?";
$stmt = $mysqli->prepare($sql);

// Get the current month
$month = date('m');
$stmt->bind_param('si', $username, $month);

// Execute the query
$stmt->execute();

// Bind the result to variables
$stmt->bind_result($date, $name, $place, $lotType, $good, $broken, $brown, $task, $id);

// Create an empty array to store the user data
$userData = array();

// Fetch the data and store it in the array
while ($stmt->fetch()) {
    // Format the date as desired (month/day/year)
    $formattedDate = date('m/d/Y', strtotime($date));

    $userData[] = array(
        'date' => $formattedDate,
        'name' => $name,
        'place' => $place,
        'lotType' => $lotType,
        'good' => $good,
        'broken' => $broken,
        'brown' => $brown,
        'task' => $task,
        'id' => $id
    );
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();

// Return the user data as JSON response
header('Content-Type: application/json');
echo json_encode($userData);
?>


