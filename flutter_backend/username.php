<?php
$db = mysqli_connect('mysql1b.xserver.jp', 'waa_phumasiacom', 'EZ6F6DhJJJKF', 'waa_phumasiacom');
if (!$db) {
    echo json_encode("Database connection failed!");
} else {
    $selectedPlace = $_GET['selectedPlace'] ?? '';
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM Appuser WHERE place = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $selectedPlace);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $names = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['username'];
        }
        echo json_encode($names);
    } else {
        echo json_encode("Error fetching names from the database!");
    }
}
?>
