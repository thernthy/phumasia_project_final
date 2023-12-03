<?php
include '../db_conn.php';
// Assuming you have a database connection established
// Check if the place parameter is set
if (isset($_GET['place'])) {
    // Retrieve the selected place
    $selectedPlace = $_GET['place'];
    // Prepare the query to fetch names based on the selected place
    $query = "SELECT username FROM Appuser WHERE place = ?";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "s", $selectedPlace);
    mysqli_stmt_execute($statement);
    // Fetch the names
    $result = mysqli_stmt_get_result($statement);
    // Store the names in an array
    $names = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $names[] = $row['username'];
    }
    // Return the names as JSON data
    echo json_encode($names);
} else {
    // Place parameter is not set
    echo "No place selected.";
}
?>
