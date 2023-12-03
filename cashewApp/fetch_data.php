<?php
// Assuming you have already established a database connection ($conn)
if (isset($_GET['lottype']) && isset($_GET['selectDate']) && isset($_GET['selectTask'])) {
    $lotType = $_GET['lottype'];
    $selectDate = $_GET['selectDate'];
    $selectTask = $_GET['selectTask'];

    // Construct the SQL query based on the provided conditions
    $sql = "SELECT Lot_type, COUNT(*) as count, SUM(Good) as totalGood, SUM(Broken) as totalBroken, SUM(Brown) as totalBrown
     FROM cashew_record WHERE Lot_type = '$lotType' AND task = '$selectTask'";

    // Append additional conditions for selectDate
    if ($selectDate === 'today') {
        $sql .= " AND DATE(date) = CURDATE()";
    } elseif ($selectDate === 'yesterday') {
        $sql .= " AND DATE(date) = CURDATE() - INTERVAL 1 DAY";
    } elseif ($selectDate === 'thisWeek') {
        $sql .= " AND YEARWEEK(date) = YEARWEEK(CURDATE())";
    } elseif ($selectDate === 'lastWeek') {
        $sql .= " AND YEARWEEK(date) = YEARWEEK(CURDATE()) - 1";
    } elseif ($selectDate === 'thisMonth') {
        $sql .= " AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
    } elseif ($selectDate === 'lastMonth') {
        $sql .= " AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) - 1";
    }

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Process the query result
    if ($result) {
        // Fetch the data from the result set
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        $totalGood = $row['totalGood'];
        $totalBroken = $row['totalBroken'];
        $totalBrown = $row['totalBrown'];

        // Prepare the response data
        $response = array(
            'success' => true,
            'count' => $count,
            'totalGood' => $totalGood,
            'totalBroken' => $totalBroken,
            'totalBrown' => $totalBrown
        );
    } else {
        // Handle any errors that occur during the query
        $response = array(
            'success' => false,
            'error' => mysqli_error($conn)
        );
    }

    // Close the database connection
    mysqli_close($conn);

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
