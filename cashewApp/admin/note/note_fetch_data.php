<?php
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
// Check if the AJAX request has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ID sent from the client-side
    $id = $_POST['id'];
    // Prepare and execute the SQL query to fetch the note from the database
    $get_note_query = "SELECT note FROM expend WHERE id = $id";
    $result = mysqli_query($conn, $get_note_query);
    // Check if the query was successful
    if ($result) {
        // Fetch the note from the query result
        $row = mysqli_fetch_assoc($result);
        $note = $row['note'];
        // Check if the note is empty or equals 0
        if ($note === '' || $note === '0') {
            $note = 'No reason'; // Set the note to "No reason"
        }
        // Return the note as a JSON response
        $response = array('note' => $note);
        echo json_encode($response);
    } else {
        // Handle the error case
        $error = mysqli_error($conn);
        $response = array('error' => $error);
        echo json_encode($response);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
