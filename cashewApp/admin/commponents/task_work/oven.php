
<?php
$currentMonth = date('F/d/Y');
$converdTor = 1000;
// Display lot Type
$getLotType = "SELECT Lot_type, COUNT(*) as count FROM cashew_record WHERE task = 'Oven'
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
$viewStock = "SELECT SUM(Good) as sttotalGood, SUM(Broken) as sttotalBroken, SUM(Brown) as sttotalBrown
FROM cashew_record 
WHERE task = 'Oven' AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
$view_data = mysqli_query($conn, $viewStock);
if (!$view_data) {
    // Query execution failed, handle the error
    echo "Error: " . mysqli_error($conn);
} else {
    while ($row = mysqli_fetch_assoc($view_data)) {
        $sttotalGood = $row['sttotalGood'];
        $sttotalBroken = $row['sttotalBroken'];
        $sttotalBrown = $row['sttotalBrown'];
    }
}
echo '
<div class="row mt-5">
<div class="col-xl-3 col-md-6">
     '.($currentMonth).'
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            Good: <span id="totalGood">';
            echo ($sttotalGood/$converdTor);
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
<div class="col-xl-3 col-md-6">
       '.$currentMonth.'
    <div class="card bg-warning text-white mb-4">
        <div class="card-body">
         Broken: <span id="totalBroken"> ' . ($sttotalBroken/$converdTor) . ' Kg</span>
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
<div class="col-xl-3 col-md-6">
     '.$currentMonth.'
    <div class="card bg-danger text-white mb-4">
        <div class="card-body">
         Brown: <span id="totalBrown">  ' . ($sttotalBrown/$converdTor) . ' Kg </span>
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
                    <th>Broken</th>
                    <th>Brown</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Lot type</th>
                    <th>Date</th>
                    <th>Good</th>
                    <th>Broken</th>
                    <th>Brown</th>
                </tr>
            </tfoot>
            <tbody>';
            $get_oven_data = "SELECT date, Name, place, Lot_type, Good, Broken, Brown FROM cashew_record WHERE task='oven' ORDER BY date DESC";
            $view_oven_data = mysqli_query($conn, $get_oven_data);
            while ($row = mysqli_fetch_assoc($view_oven_data)) {
                $oven_ps_name = $row['Name'];
                $oven_date = $row['date'];
                $oven_place = $row['place'];
                $oven_lot_type = $row['Lot_type'];
                $oven_cw_good = $row['Good'];
                $oven_cw_brock = $row['Broken'];
                $oven_cw_brown = $row['Brown'];
                $formatted_date = date('m/d/Y', strtotime($oven_date));
                echo'<tr>
                <td>'.$oven_ps_name.'</td>
                <td>'.$oven_place.'</td>
                <td>'.$oven_lot_type.'</td>
                <td>'.$formatted_date.'</td>
                <td>'.($oven_cw_good/$converdTor).' Kg</td>
                <td>'.($oven_cw_brock/$converdTor).' Kg</td>
                <td>'.($oven_cw_brown/$converdTor).' Kg</td>
                </tr>' ;
              }
            echo'</tbody>
        </table>
    </div>
</div>
';
?>