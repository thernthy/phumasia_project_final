<?php
// Retrieve the id from the request
$id = $_GET['id'] ?? '';
// Create a new MySQLi object
$mysqli = new mysqli('mysql1b.xserver.jp', 'waa_phumasiacom', 'EZ6F6DhJJJKF', 'waa_phumasiacom');
// Check for connection errors
if ($mysqli->connect_errno) {
    // Handle the connection error
    $response = array(
        'status' => 'error',
        'message' => 'Failed to connect to MySQL: ' . $mysqli->connect_error
    );
    echo json_encode($response);
    exit();
}

// Prepare the SQL statement with a placeholder for the id
$sql = "DELETE FROM cashew_record WHERE id = ?";
$stmt = $mysqli->prepare($sql);

// Check for statement preparation error
if (!$stmt) {
    // Handle the statement preparation error
    $response = array(
        'status' => 'error',
        'message' => 'Failed to prepare statement: ' . $mysqli->error
    );
    echo json_encode($response);
    exit();
}

// Bind the id parameter to the statement
$stmt->bind_param('s', $id);

// Execute the query
if (!$stmt->execute()) {
    // Handle the query execution error
    $response = array(
        'status' => 'error',
        'message' => 'Failed to execute query: ' . $stmt->error
    );
    echo json_encode($response);
    exit();
}

// Check the affected rows
if ($stmt->affected_rows > 0) {
    // Deletion successful
    $response = array(
        'status' => 'success',
        'message' => 'Record deleted successfully'
    );
    echo json_encode($response);
} else {
    // No rows affected, record not found
    $response = array(
        'status' => 'error',
        'message' => 'Record not found'
    );
    echo json_encode($response);
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();
?>
