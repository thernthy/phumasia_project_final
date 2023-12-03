<?php
// Check if the user ID is set in the query parameters
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
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
    // Prepare the deletion query
    $delete_query = "DELETE FROM Appuser WHERE id = $user_id";

    // Execute the deletion query
    if (mysqli_query($conn, $delete_query)) {
        // Return a success message
        echo "User deleted successfully.";
    } else {
        // Return an error message
        echo "Error deleting user: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Return an error message if the user ID is not set
    echo "User ID not provided.";
}
?>
