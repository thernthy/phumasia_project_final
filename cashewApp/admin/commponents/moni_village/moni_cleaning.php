<?php
include "check_producer_work_from.php";

if(isset($_POST['producer_check'])){
    // Retrieve the start date and end date from the AJAX request
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare the query with date range condition
    $get_hardshell_data = "SELECT date, Name, place,
                           SUM(Good) as totalgood, SUM(Broken) as totalbroken, SUM(Brown) as totalbrown
                           FROM cashew_record
                           WHERE task='Cleaning' AND place= 'moni village' 
                           AND date BETWEEN '$start_date' AND '$end_date'
                           GROUP BY Name
                           ORDER BY date DESC";

    // Execute the query
    $result = $conn->query($get_hardshell_data);

    // Close the connection
    $conn->close();
}else{
        // Prepare the query with date range condition
        $get_hardshell_data = "SELECT date, Name, place, 
        SUM(Good) as totalgood, SUM(Broken) as totalbroken, SUM(Brown) as totalbrown
        FROM cashew_record 
        WHERE task='Cleaning' And place= 'moni village'
        AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())
        GROUP BY Name
        ORDER BY date DESC";
    // Execute the query
    $result = $conn->query($get_hardshell_data);

    // Close the connection
    $conn->close();
}
?>

<div class="card mb-4 mt-5">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Detail
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Date</th>
                    <th>Good</th>
                    <th>Broken</th>
                    <th>Brown</th>
                </tr>
            </thead>
            <tbody id="result"> <!-- Add id attribute here -->
                <?php
                if ($result->num_rows > 0) {
                    // Output the data
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                            <td>' . $row['Name'] . '</td>
                            <td>' . $row['place'] . '</td>
                            <td>'.date('F/j/Y', strtotime($row['date'])).'</td>
                            <td>' . ($row['totalgood']/1000) . ' Kg</td>
                            <td>' . ($row['totalbroken']/1000) . ' Kg</td>
                            <td>' . ($row['totalbrown']/1000) . ' Kg</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No records found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>