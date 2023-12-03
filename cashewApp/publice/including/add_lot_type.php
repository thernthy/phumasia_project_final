<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted lot number value
    $lotNumber = $_POST['lot_number'];

    // Validate the lot number value
    if (empty($lotNumber)) {
        // Return an error response
        $response = array('success' => false, 'message' => 'Please enter a lot number!');
        echo json_encode($response);
        exit; // Stop further execution
    }
    $lotNumber = strtoupper($lotNumber);
    // Connect to your database
    $dbHost = 'mysql1b.xserver.jp';
    $dbName = 'waa_phumasiacom';
    $dbUser = 'waa_phumasiacom';
    $dbPass = 'EZ6F6DhJJJKF';
    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the lot number already exists in the lot_type table
        $stmt = $pdo->prepare("SELECT * FROM lot_type WHERE lot_type = :lot_number");
        $stmt->bindParam(':lot_number', $lotNumber);
        $stmt->execute();
        $existingLot = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingLot) {
            // Return an error response
            $response = array('success' => false, 'message' => 'Lot number already exists in the data');
            echo json_encode($response);
        } else {
            // Insert the new lot number into the lot_type table
            $stmt = $pdo->prepare("INSERT INTO lot_type (lot_type) VALUES (:lot_number)");
            $stmt->bindParam(':lot_number', $lotNumber);
            $stmt->execute();
            // Reset the lot number to an empty string
            $lotNumber = '';
            // Return a success response
            $response = array('success' => true, 'message' => 'Lot number added successfully');
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Return an error response if there's an exception
        $response = array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
        echo json_encode($response);
    }
}
?>
