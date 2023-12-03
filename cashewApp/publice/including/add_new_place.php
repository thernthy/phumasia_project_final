<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted place value
    $newPlace = $_POST['place'];
    // Validate the place value
    if (empty($newPlace)) {
        // Return an error response
        $response = array('success' => false, 'message' => 'Please enter a lot number!');
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
        // Check if the place already exists in the place table
        $stmt = $pdo->prepare("SELECT * FROM place WHERE place = :place");
        $stmt->bindParam(':place', $newPlace);
        $stmt->execute();
        $existingPlace = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingPlace) {
            // Return an error response
            $response = array('success' => false, 'message' => 'Place already exists in the data');
            echo json_encode($response);
        } else {
            // Insert the new place into the place table
            $stmt = $pdo->prepare("INSERT INTO place (place) VALUES (:place)");
            $stmt->bindParam(':place', $newPlace);
            $stmt->execute();

            // Return a success response
            $response = array('success' => true, 'message' => 'Place added successfully');
            echo json_encode($response);
            $newPlace = ''; // Reset $newPlace to an empty string
        }
    } catch (PDOException $e) {
        // Return an error response if there's an exception
        $response = array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
        echo json_encode($response);
    }
}
?>
