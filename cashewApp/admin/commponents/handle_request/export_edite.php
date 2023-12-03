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
    // Get the form data from the JavaScript request
    $editId = $_POST['editId'];
    $date = $_POST['date'];
    $expent_lot = $_POST['expent_lot'];
    $expendType = $_POST['expendType'];
    if($expendType !="Disposal"){
        $note = '';
    }else{
        $note = $_POST['note'];
    }
    $good = $_POST['good'];
    $broken = $_POST['broken'];
    $brown = $_POST['brown'];

    // Perform any additional server-side validation if needed

    // Update the record in the database
    $update_expend_record = "UPDATE expend 
    SET date='$date', lot_type='$expent_lot', expend_type='$expendType', note='$note', good='$good', broken='$broken', brown='$brown' WHERE id='$editId'";

    if (mysqli_query($conn, $update_expend_record)) {
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
