<?php
$host = 'mysql1b.xserver.jp'; 
$user = 'waa_phumasiacom';   
$pass = "EZ6F6DhJJJKF";   
$database = 'waa_phumasiacom'; 
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
