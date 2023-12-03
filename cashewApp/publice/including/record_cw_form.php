<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data values
    $date = $_POST['date'];
    $name = $_POST['name'];
    $place = $_POST['place'];
    $lotType = $_POST['lotType'];
    $good = $_POST['good'];
    $broken = $_POST['broken'];
    $brown = $_POST['brown'];
    $task = $_POST['selectTask'];
    // Validate the required fields
    if (empty($date) || empty($name) || empty($place) || empty($lotType) ||  empty($task)) {
        // Return an error response
        $response = array('success' => false, 'message' => 'Please fill in all required fields.');
        echo json_encode($response);
        exit; // Stop further execution
    }
    // Connect to your database
    $dbHost = 'mysql1b.xserver.jp';
    $dbName = 'waa_phumasiacom';
    $dbUser = 'waa_phumasiacom';
    $dbPass = 'EZ6F6DhJJJKF';

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert the data into the cashew_record table
        $stmt = $pdo->prepare("INSERT INTO cashew_record (date, Name, place, Lot_type, Good, Broken, Brown, task) 
                              VALUES (:date, :name, :place, :lotType, :good, :broken, :brown, :task)");
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':place', $place);
        $stmt->bindParam(':lotType', $lotType);
        $stmt->bindParam(':good', $good);
        $stmt->bindParam(':broken', $broken);
        $stmt->bindParam(':brown', $brown);
        $stmt->bindParam(':task', $task);
        $stmt->execute();

        // Return a success response
        $response = array('success' => true, 'message' => 'Data inserted successfully');
        echo json_encode($response);
    } catch (PDOException $e) {
        // Return an error response if there's an exception
        $response = array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
        echo json_encode($response);
    }
}
?>
