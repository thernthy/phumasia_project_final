<?php
// Assuming you have established the database connection
if(isset($_POST['export_id'])) {
    $recordId = $_POST['export_id'];
    $host = 'mysql1b.xserver.jp';  // server
    $user = 'waa_phumasiacom';
    $pass = 'EZ6F6DhJJJKF';
    $database = 'waa_phumasiacom';
    // Establishing connection
    $conn = mysqli_connect($host, $user, $pass, $database);
    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Delete the record from the database
    $delete_query = "DELETE FROM expend WHERE id = $recordId";
    if(mysqli_query($conn, $delete_query)) {
        // Deletion successful
        echo "Record deleted successfully";
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
