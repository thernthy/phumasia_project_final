<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $editId = $_POST['editId'];
    $date = date('Y-m-d',strtotime($_POST['date']));
    $name = $_POST['editName'];
    $place = $_POST['editPlace'];
    $lot_type = strtoupper($_POST['lot_type']); // Convert to uppercase
    $good = $_POST['good'];
    $broken = $_POST['broken'];
    $brown = $_POST['brown'];
    $task = $_POST['task'];
    // Perform any additional server-side validation if needed
    // Update the record in the database
    $uqdate_chashew_record = "UPDATE cashew_record 
    SET date='$date', Name='$name', place='$place', Lot_type='$lot_type', Good='$good', Broken='$broken', Brown='$brown', task='$task' WHERE id='$editId'";
if (mysqli_query($conn, $uqdate_chashew_record)) {
    // Query executed successfully
    $response = array('message_pr_re' => 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ');
} else {
    // Error in the query execution
    $response = array('message_pr_re' => mysqli_error($conn));
}
    // Return the response as JSON
    echo json_encode($response);
}
?>