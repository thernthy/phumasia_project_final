
<?php
$currentMonth = date('F/d/Y');
// Display lot Type
$getLotType = "SELECT Lot_type, COUNT(*) as count FROM cashew_record WHERE task='Steaming'
 AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
$getLotType .= " GROUP BY Lot_type";
$viweLotType = mysqli_query($conn, $getLotType);
$lotTypes = array();
while ($row = mysqli_fetch_assoc($viweLotType)) {
    $lotType = $row['Lot_type'];
    $count = $row['count'];
    $lotTypes[] = $lotType;
}
// Display total cashew good, broken, brown
$viewStock = "SELECT SUM(Good) as sttotalGood
FROM cashew_record 
WHERE task = 'Steaming' AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
$view_data = mysqli_query($conn, $viewStock);
if (!$view_data) {
    // Query execution failed, handle the error
    echo "Error: " . mysqli_error($conn);
} else {
    while ($row = mysqli_fetch_assoc($view_data)) {
        $sttotalGood = $row['sttotalGood'];
    }
}
echo '
<div class="row mt-5">
<div class="col-xl-3 col-md-6">
     '.$currentMonth.'
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            Good: <span id="totalGood">';
            echo ($sttotalGood/1000);
echo ' Kg </span>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <span id="lotTypeValue">';
           foreach ($lotTypes as $type) {
               echo $type . ', ';
           }
echo '</span>
        </div>
    </div>
</div>
</div>';
echo ' <div class="card mb-4 mt-5">
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
                    <th>Lot type</th>
                    <th>Date</th>
                    <th>Good</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Lot type</th>
                    <th>Date</th>
                    <th>Good</th>
                </tr>
            </tfoot>
            <tbody>';
            $get_steaming_data = "SELECT date, Name, place, Lot_type, Good FROM cashew_record WHERE task='Steaming' ORDER BY date DESC";
            $view_steaming_data = mysqli_query($conn, $get_steaming_data);
            $exchange_color = '';
            while ($row = mysqli_fetch_assoc($view_steaming_data)) {
                $steaming_ps_name = $row['Name'];
                $steaming_date = $row['date'];
                $steaming_place = $row['place'];
                $steaming_lot_type = $row['Lot_type'];
                $steaming_cw_good = $row['Good'];
                $formatted_date = date('m/d/Y', strtotime($steaming_date));
                echo'<tr>
                <td>'.$steaming_ps_name.'</td>
                <td>'.$steaming_place.'</td>
                <td>'.$steaming_lot_type.'</td>
                <td>'.$formatted_date.'</td>
                <td>'.($steaming_cw_good/1000).' Kg</td>
                </tr>' ;
              }
            echo'</tbody>
        </table>
    </div>
</div>
';
?>