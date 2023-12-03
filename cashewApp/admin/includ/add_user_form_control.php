<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Get the form data
    $username = $_POST['username'];
    $place = $_POST['place'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $user_id = $_GET['user_id'];
    
    // Check if the user already exists in the Appuser table
    $check_query = "SELECT * FROM Appuser WHERE username = '$username'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        // User already exists, return an error message
        echo "User already exists.";
    } elseif ($role === "Admin" || $role === "User") {
        // Check if the password is at least 8 characters long
        if (strlen($password) < 8) {
            // Password is less than 8 characters, return an error message
            echo "Password must be at least 8 characters long.";
        } else {
            // User does not exist, insert the data into the database
            $insert_query = "INSERT INTO Appuser (username, place, role, password) VALUES ('$username', '$place', '$role', '$password')";
            if ($conn->query($insert_query) === TRUE) {
                // Return a success message
                echo "User added successfully.";
            } else {
                // Return an error message
                echo "Error adding user: " . $conn->error;
            }
        }
    } else {
        // User does not exist, insert the data into the database
        $insert_query = "INSERT INTO Appuser (username, place, role, password) VALUES ('$username', '$place', '$role', '$password')";
        if ($conn->query($insert_query) === TRUE) {
            // Return a success message
            echo "User added successfully.";
        } else {
            // Return an error message
            echo "Error adding user: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>
