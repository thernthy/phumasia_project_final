<?php

// Retrieve the input data from the HTTP POST request
$selectedPlace = $_POST['selectedPlace'];
$selectedName = $_POST['selectedName'];
$selectedDate = $_POST['selectedDate'];
$lotTypeText = $_POST['lotTypeText'];
$goodText = $_POST['goodText'];
$brokenText = $_POST['brokenText'];
$brownText = $_POST['brownText'];
$selectedTask = $_POST['selectedTask'];
// TODO: Perform necessary validation and sanitization of the input data
// Connect to your MySQL database (replace with your own credentials)
$host = 'mysql1b.xserver.jp';
$database = 'waa_phumasiacom';
$username = 'waa_phumasiacom';
$password = 'EZ6F6DhJJJKF';
$dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
try {
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare the SQL statement
    $sql = "INSERT INTO cashew_record (date, place, name, Lot_type, Good, Broken, Brown, task) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($sql);

    // Bind the input parameters to the prepared statement
    $statement->bindParam(1, $selectedDate);
    $statement->bindParam(2, $selectedPlace);
    $statement->bindParam(3, $selectedName);
    $statement->bindParam(4, $lotTypeText);
    $statement->bindParam(5, $goodText);
    $statement->bindParam(6, $brokenText);
    $statement->bindParam(7, $brownText);
    $statement->bindParam(8, $selectedTask);
    // Execute the SQL statement
    $statement->execute();
    // Prepare the response
    $response = array('success' => true, 'message' => 'Data inserted successfully');
    echo json_encode($response);
} catch (PDOException $e) {
    // Prepare the response
    $response = array('success' => false, 'message' => 'Data insertion failed: ' . $e->getMessage());
    echo json_encode($response);
}
?>
