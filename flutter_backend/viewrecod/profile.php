<?php
// Retrieve the username from the request
$username = $_GET['username'] ?? '';

// Create a new MySQLi object
$mysqli = new mysqli('mysql1b.xserver.jp', 'waa_phumasiacom', 'EZ6F6DhJJJKF', 'waa_phumasiacom');

// Check for connection errors
if ($mysqli->connect_errno) {
    // Handle the connection error
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

// Get the current month
$month = date('m');
// Prepare the SQL statement to retrieve the specified user's total good
$sql = "SELECT SUM(Good) AS totalGood, SUM(Broken) AS totalBroken, SUM(Brown) AS totalBrown FROM cashew_record WHERE Name = ? AND MONTH(date) = ?";
$stmt = $mysqli->prepare($sql);
// Bind the parameters to the SQL statement
$stmt->bind_param('si', $username, $month);

// Execute the prepared statement
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Check if a row was found
if ($result->num_rows > 0) {
    // Retrieve the specified user's total good
    $row = $result->fetch_assoc();
    $specifiedUserTotalGood = $row['totalGood'];
    $totalBroken = $row['totalBroken'];
    $totalBrown = $row['totalBrown'];
    $totalCashew = ($totalBroken + $specifiedUserTotalGood); 
    $salaryDoller = $totalCashew * 1;
    $salaryRel = $salaryDoller * 4100;
    $formattedSalaryRel = number_format($salaryRel, 0, '.', ',');
    // Prepare the SQL statement to rank the users
    $sql = "SELECT Name, SUM(Good) AS totalGood, (SELECT COUNT(*) + 1 FROM (SELECT SUM(Good) AS totalGood FROM cashew_record WHERE Name != ? AND MONTH(date) = ? GROUP BY Name HAVING SUM(Good) > ?) AS rankings) AS rank FROM cashew_record WHERE MONTH(date) = ? GROUP BY Name ORDER BY totalGood DESC";

    // Execute the query
    $stmt = $mysqli->prepare($sql);

    // Bind the parameters to the SQL statement
    $stmt->bind_param('sisi', $username, $month, $specifiedUserTotalGood, $month);

    // Execute the prepared statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        // Initialize variables
        $rank = 0;

        // Iterate through the result set
        while ($row = $result->fetch_assoc()) {
            // Increment rank
            $rank++;

            // Check if the current row corresponds to the specified user
            if ($row['Name'] == $username) {
                // Close the statement and database connection
                $stmt->close();
                $mysqli->close();

                // Send the response as JSON
                header('Content-Type: application/json');
                echo json_encode(array(
                    'totalGood' => $specifiedUserTotalGood,
                    'totalBroken' => $totalBroken,
                    'totalBrown' => $totalBrown,
                    'rank' => $rank,
                    'Name' => $row['Name'],
                    'salaryDoller' => $salaryDoller,
                    'salaryRel' => $formattedSalaryRel,
                    'totaCashew' => $totalCashew
                ));
                exit();
            }
        }

        // User not found in the result set
        $stmt->close();
        $mysqli->close();
        echo json_encode(array('error' => 'Username not found.'));
    } else {
        // Query execution failed
        $stmt->close();
        $mysqli->close();
        echo json_encode(array('error' => 'Failed to fetch user rankings.'));
    }
} else {
    // No matching user found
    $stmt->close();
    $mysqli->close();
    echo json_encode(array('error' => 'Username not found.'));
}
?>
