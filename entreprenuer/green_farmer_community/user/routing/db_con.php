<?php
$host = 'localhost';  // server
$user = 'root';
$pass = '';
$database = 'scy_chiken_db';
try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Your remaining code here
    
} catch (PDOException $e) {
    echo "Database Connection Error: " . $e->getMessage();
    die();
}
?>
