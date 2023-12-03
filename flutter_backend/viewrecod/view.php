<?php
$host = 'mysql1b.xserver.jp';
$database = 'waa_phumasiacom';
$username = 'waa_phumasiacom';
$password = 'EZ6F6DhJJJKF';

// Create a PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fetch data and calculate totals based on the selected month
$month = isset($_GET['month']) ? $_GET['month'] : 'this month';
// Define the base query for all months
$query = "SELECT 
            Name, 
            Good,
            Broken,
            Brown
          FROM cashew_record";

// Adjust the query to filter by month if a specific month is selected
if ($month === 'today') {
    $query .= " WHERE DATE(Date) = CURDATE()";
} elseif ($month === 'yesterday') {
    $query .= " WHERE DATE(Date) = CURDATE() - INTERVAL 1 DAY";
} elseif ($month === 'this week') {
    $query .= " WHERE YEARWEEK(Date) = YEARWEEK(CURDATE())";
} elseif ($month === 'last week') {
    $query .= " WHERE YEARWEEK(Date) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK)";
} elseif ($month === 'this month') {
    $query .= " WHERE MONTH(Date) = MONTH(CURDATE())";
} elseif ($month === 'last month') {
    $query .= " WHERE MONTH(Date) = MONTH(CURDATE() - INTERVAL 1 MONTH)";
}

// Complete the query with grouping and ordering
$query .= " 
            ORDER BY Good DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
