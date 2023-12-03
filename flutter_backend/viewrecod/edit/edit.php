<?php
// Retrieve the id from the request
$id = $_GET['id'] ?? '';
// Create a new MySQLi object
$mysqli = new mysqli('mysql1b.xserver.jp', 'waa_phumasiacom', 'EZ6F6DhJJJKF', 'waa_phumasiacom');
// Check for connection errors
if ($mysqli->connect_errno) {
    // Handle the connection error
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

// Prepare the SQL statement with a placeholder for the id
$sql = "SELECT date, Name, place, Lot_type, Good, Broken, Brown, task FROM cashew_record WHERE id = ?";
$stmt = $mysqli->prepare($sql);

// Check for statement preparation error
if (!$stmt) {
    // Handle the statement preparation error
    echo 'Failed to prepare statement: ' . $mysqli->error;
    exit();
}

// Bind the id parameter to the statement
$stmt->bind_param('s', $id);

// Execute the query
if (!$stmt->execute()) {
    // Handle the query execution error
    echo 'Failed to execute query: ' . $stmt->error;
    exit();
}

// Bind the result to variables
$stmt->bind_result($date, $name, $place, $lotType, $good, $broken, $brown, $task);

// Create an empty array to store the user data
$userData = array();

// Fetch the data and store it in the array
while ($stmt->fetch()) {
    // Format the date as desired (month/day/year)
    $formattedDate = date('m/d/Y', strtotime($date));

    // Convert good, broken, and brown to strings
    $goodString = strval($good);
    $brokenString = strval($broken);
    $brownString = strval($brown);

    $userData[] = array(
        'date' => $formattedDate,
        'name' => $name,
        'place' => $place,
        'lotType' => $lotType,
        'good' => $goodString,
        'broken' => $brokenString,
        'brown' => $brownString,
        'task' => $task,
    );
}

// Close the statement
$stmt->close();

// Close the database connection
$mysqli->close();

// Return the user data as JSON response
header('Content-Type: application/json');
echo json_encode($userData);
?>
