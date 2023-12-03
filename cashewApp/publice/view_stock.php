<?php
$host = 'mysql1b.xserver.jp';
$user = 'waa_phumasiacom';
$pass = 'EZ6F6DhJJJKF';
$database = 'waa_phumasiacom';
$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$converdTor = 1000;
// Query to retrieve data for the entire year and group by the year
$expend = "SELECT YEAR(date) AS year, lot_type, SUM(good) AS exgoodtotal, SUM(broken) AS exbrokentotal, SUM(brown) AS extotalbrown 
	FROM expend 
	WHERE id!=0
	GROUP BY lot_type";
$getexpeandData = mysqli_query($conn, $expend);
$expendData = array();
while ($row = mysqli_fetch_assoc($getexpeandData)) {
    $year = $row['year'];
    $exLot_type = $row['lot_type'];
    $exgoodtotal = $row['exgoodtotal'];
    $exbrokentotal = $row['exbrokentotal'];
    $extotalBrow = $row['extotalbrown'];
    $expendData[$exLot_type] = array(
        'exgoodtotal' => $exgoodtotal,
        'exbrokentotal' => $exbrokentotal,
        'extotalBrow' => $extotalBrow
    );
}

echo ' <div class="card mb-4 mt-5 shadow-sm p-3">
<div class="card-header">
    <i class="fas fa-table me-1"></i>
	In stock
</div>
	<div class="card-body">
	   <table id="datatablesSimple">
		  <thead>
			 <tr>
             <th>Date</th>
             <th>Lot Number</th>
             <th>Good</th>
             <th>Broken</th>
             <th>Brown</th>
			 </tr>
		  </thead>
		  <tfoot>
			 <tr>
             <th>Date</th>
             <th>Lot Number</th>
             <th>Good</th>
             <th>Broken</th>
             <th>Brown</th>
			 </tr>
		  </tfoot>
		  <tbody>';
$getLotType = "SELECT YEAR(date) AS year, Lot_type, MAX(date) AS last_date, COUNT(*)
 AS count, SUM(Good) AS totalgood, SUM(Broken) AS totalbroken, SUM(brown) AS totalbrown 
	FROM cashew_record
	WHERE Lot_type != '' AND task = 'Packing'
	GROUP BY Lot_type
	ORDER BY YEAR(date) ASC";
$view_users = mysqli_query($conn, $getLotType);
while ($row = mysqli_fetch_assoc($view_users)) {
    $year = $row['year'];
    $lotType = $row['Lot_type'];
    $lastDate = date('d/F/Y', strtotime($row['last_date']));
    $totalGood = $row['totalgood'];
    $totalBroken = $row['totalbroken'];
    $totalBrown = $row['totalbrown'];
    $exgoodtotal = isset($expendData[$lotType]['exgoodtotal']) ? $expendData[$lotType]['exgoodtotal'] : 0;
    $exbrokentotal = isset($expendData[$lotType]['exbrokentotal']) ? $expendData[$lotType]['exbrokentotal'] : 0;
    $extotalBrow = isset($expendData[$lotType]['extotalBrow']) ? $expendData[$lotType]['extotalBrow'] : 0;
    if($totalGood-$exgoodtotal<=0 && $totalBroken-$exbrokentotal<=0 && $totalBrown-$extotalBrow<=0 || $totalBroken===0&&$totalGood===0&&$totalBrown===0){
        continue;
    }
    echo '
		<tr>
			<td>' . $lastDate . '</td>
			<td>' . $lotType . '</td>
			<td>' . (($totalGood - $exgoodtotal) / $converdTor) . ' Kg</td>
			<td>' . (($totalBroken - $exbrokentotal) / $converdTor) . ' Kg</td>
			<td>' . (($totalBrown - $extotalBrow) / $converdTor) . ' Kg</td>
		</tr>
		';
}
echo '</tbody>
   </table>
</div>
</div>
';
?>
