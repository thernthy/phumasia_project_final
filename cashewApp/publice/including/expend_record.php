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

$date = $_POST['date'];
$lotNumber = $_POST['lotNumber'];
$expendType = $_POST['expendType'];
$good = $_POST['good'];
$broken = $_POST['broken'];
$brown = $_POST['brown'];
$note = $_POST['note'];

// Insert the data into the database
$sql = "INSERT INTO expend (date, expend_type, good, broken, brown, lot_type, note)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssss", $date, $expendType, $good, $broken, $brown, $lotNumber, $note);
if (mysqli_stmt_execute($stmt)) {
    echo "Data inserted successfully!";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}
// Close the statement and the database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
