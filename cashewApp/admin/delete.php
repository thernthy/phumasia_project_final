<?php
// Check if the form is submitted and the user_id is set
if (isset($_POST['delete_user']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    // Prepare the deletion query
    $delete_query = "DELETE FROM Appuser WHERE id = $user_id";
    // Execute the deletion query
    if (mysqli_query($conn, $delete_query)) {
        // Redirect to index.php after successful deletion
        header("Location: ../index.php");
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If the form is not submitted or the user_id is not set, redirect back to index.php
    header("Location: ../index.php");
    exit;
}
