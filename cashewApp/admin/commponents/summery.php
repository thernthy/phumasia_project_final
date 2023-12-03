<div class="mt-5 mb-4">
	  <?php include 'checking_form.php'?>
</div>
<?php
if(isset($_POST['check'])){
    $select_lotType = $_POST['lottype'];
    $selectDate = $_POST['selectDate'];
	$start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $selectTask = $_POST['selectTask'];
    $converdTor = 1000;
    $content_btw_total_n_instock = '';
			if($selectTask != 'Steaming'){ 
				if($selectTask === "Packing"){
					$expend = "SELECT YEAR(date) AS year, lot_type, SUM(good) AS exgoodtotal, SUM(broken) AS exbrokentotal, SUM(brown) AS extotalbrown 
					FROM expend 
					WHERE lot_type!=''";
					if ($start_date != '' && $end_date != '') {
						$expend .= " AND date BETWEEN '$start_date' AND '$end_date'";
					} elseif ($start_date != '') {
						$expend .= " AND date = '$start_date'";
					} elseif ($end_date != '') {
						$expend .= " AND date = '$end_date'";
					}elseif($select_lotType!='all'){
						$expend .= " AND lot_type = '$select_lotType'";
					}
					$expend .= " GROUP BY date ASC";
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
					echo '
					<div class="mt-6 pt-5">
					<h2>In Stock</h2>
					<table class="table table-bordered">
						<thead style="background-color: green; color: white;">
						<tr>
						<th>Date</th>
						<th>Lot number</th>
						<th>Good</th>
						<th>Broken</th>
						<th>Brown</th>
						</tr>
						</thead>
						<tbody>';
					$get_packing_date = "SELECT YEAR(date) AS year, Lot_type, SUM(Good) AS totalGood,
						SUM(Broken) AS totalBroken, SUM(Brown) AS totalBrown,date,
						task, date
						FROM cashew_record
						WHERE task= 'Packing'";
					if ($start_date != '' && $end_date != '') {
						$get_packing_date .= " AND date BETWEEN '$start_date' AND '$end_date'";
					}if ($start_date != '') {
						$get_packing_date .= " AND date = '$start_date'";
					}if ($end_date != '') {
						$get_packing_date .= " AND date = '$end_date'";
					}if($select_lotType!='all'){
						$get_packing_date .= " AND Lot_type = '$select_lotType'";
					}if($select_lotType==='all'){
						$get_packing_date .= " AND Lot_type!= ''";
					}
					$get_packing_date .= " GROUP BY Lot_type ORDER BY date ASC";
					$result = mysqli_query($conn, $get_packing_date);
					if ($result) {
						// Fetch the data from the result set
						while ($row = mysqli_fetch_assoc($result)) {
							$year = $row['year'];
							$lotType = $row['Lot_type'];
							$totalGood = $row['totalGood'];
							$totalBroken = $row['totalBroken'];
							$totalBrown = $row['totalBrown'];
							$lastDate = date("d/m/Y", strtotime($row['date']));
							$exgoodtotal = isset($expendData[$lotType]['exgoodtotal']) ? $expendData[$lotType]['exgoodtotal'] : 0;
							$exbrokentotal = isset($expendData[$lotType]['exbrokentotal']) ? $expendData[$lotType]['exbrokentotal'] : 0;
							$extotalBrow = isset($expendData[$lotType]['extotalBrow']) ? $expendData[$lotType]['extotalBrow'] : 0;
							if($totalGood - $exgoodtotal<=0 && $totalBroken - $exbrokentotal<=0 && $totalBrown - $extotalBrow<=0 || 
								$totalGood===0 && $totalBroken===0 && $totalBrown===0){
								continue;
							}
							echo '<tr>
								<td>' . $lastDate . '</td>
								<td>' . $lotType . '</td>
								<td>' . (($totalGood - $exgoodtotal) / $converdTor) . ' Kg</td>
								<td>' . (($totalBroken - $exbrokentotal) / $converdTor) . ' Kg</td>
								<td>' . (($totalBrown - $extotalBrow) / $converdTor) . ' Kg</td>
							</tr>';
						}
					}
					echo '</tbody>
						</table>
						</div>';
				}
				$viewEachlotTotal = "SELECT 
					YEAR(date) AS year,
					MAX(date) AS last_date, 
					Lot_type, 
					SUM(Good) as totalGood, 
					SUM(Broken) as totalBroken, 
					SUM(Brown) as totalBrown,
					task,
					date 
					FROM cashew_record
					WHERE  task='$selectTask' AND Lot_type!=''";
						if($start_date != '' && $end_date != ''){
							$viewEachlotTotal  .=" AND date BETWEEN '$start_date' AND '$end_date'";
						}elseif($start_date != ''){
							$viewEachlotTotal  .=" AND date = '$start_date'";
						}elseif($end_date != ''){
							$viewEachlotTotal .=" AND date = '$end_date'";
						}elseif($select_lotType!='all'){
							$viewEachlotTotal .=" AND Lot_type= '$lotType'";
						}
					$viewEachlotTotal .= " GROUP BY Lot_type ORDER BY YEAR(date) ASC";
					$viewEachCashew = mysqli_query($conn, $viewEachlotTotal);
					echo '<h4 class="mb-4">producing</h4>';
					echo '<table class="table table-bordered">
						<thead style="background-color: green; color: white;">
							<tr>
							<th>Date</th>
							<th>Lot Number</th>
							<th>Good</th>
								<th>Broken</th>
								<th>Brown</th>
								<th>Total</th>
							</tr>
						</thead>
					<tbody>';
					if ($viewEachCashew) {
						while ($producing_data = mysqli_fetch_assoc($viewEachCashew)) {
							$each_lottype = $producing_data['Lot_type'];
							$producing_date = $producing_data['last_date'];
							$each_totalGood = $producing_data['totalGood'];
							$each_totalBroken = $producing_data['totalBroken'];
							$each_totalBrown = $producing_data['totalBrown'];
							echo '<tr>
								<td>' . (date('d/m/Y', strtotime($producing_date))) . '</td>
								<td>' . $each_lottype . '</td>
								<td>' . ($each_totalGood / $converdTor) . ' Kg</td>
								<td>' . ($each_totalBroken / $converdTor) . ' Kg</td>
								<td>' . ($each_totalBrown / $converdTor) . ' Kg</td>
								<td>' . (($each_totalGood + $each_totalBroken) / $converdTor) . ' Kg</td>
							</tr>';
						}
					}
					echo '</tbody>
					</table>';
				///===============++++++++++++++++ loop expend Cashew showing to the table ====================+++++++++++++++
				//expending part
				if($selectTask==='Packing'){
					echo ' <div class="card mb-4 mt-5">
					<div class="card-header">
					<i class="fas fa-table me-1"></i>
						Export
					</div>
						<div class="card-body">
						<table id="datatablesSimple">
							<thead>
								<tr>
								<th>Date</th>
								<th>Expend Type</th>
									<th>Lot Number</th>
									<th>Good</th>
									<th>Broken</th>
									<th>Brown</th>
								</tr>
							</thead>
							<tfoot>
							<tr>
						<th>Date</th>
						<th>Export Type</th>
						<th>Lot Number</th>
						<th>Good</th>
						<th>Broken</th>
						<th>Brown</th>
						</tr>
					</tfoot>
					<tbody>';
					$viewEachlotTotalEx = "SELECT date, id, expend_type, good, broken, brown, lot_type
					FROM expend
					WHERE lot_type!=''";
					if($start_date!= '' && $end_date!=''){
						$viewEachlotTotalEx .=" AND date BETWEEN '$start_date' AND '$end_date'";
					}elseif($start_date != ''){
						$viewEachlotTotalEx .=" AND date = '$start_date'";
					}elseif($end_date != ''){
						$viewEachlotTotalEx .=" AND date = '$end_date'";
					}elseif($select_lotType!='all'){
						$viewEachlotTotalEx .=" AND lot_type='$lotType'";
					}
					$viewEachlotTotalEx .= " ORDER BY date ASC";
					$view_expend_data = mysqli_query($conn, $viewEachlotTotalEx);
					if ($view_expend_data) {
						while ($row = mysqli_fetch_assoc($view_expend_data)) {
							$id = $row['id'];
							$expend_type = $row['expend_type'];
							$expend_date = $row['date'];
							$expend_lot_type = $row['lot_type'];
							$expend_cw_good = $row['good'];
							$expend_cw_brock = $row['broken'];
							$expend_cw_brown = $row['brown'];
							$formatted_date = date('d/m/Y', strtotime($expend_date));
							if($expend_type === "Disposal"){
								$expend_type = '<span class="expend-link" data-id="'.$id.'" style="cursor: pointer;	text-decoration: solid; ">Desposal</span>';
							}else{
								$expend_type;
							}
							echo '<tr>
									<td>' .$formatted_date . '</td>
									<td>' .$expend_type. '</td>
	                                <td>' . $expend_lot_type . '</td>
									<td>' . ($expend_cw_good / $converdTor) . ' Kg</td>
									<td>' . ($expend_cw_brock / $converdTor) . ' Kg</td>
									<td>' . ($expend_cw_brown / $converdTor) . ' Kg</td>
								</tr>';
						}
					}
					echo'</tbody>
					</table>
					</div>
					</div>
					';
				}
		    }else{
				    echo '<div class="card mb-4 mt-5">
						<div class="card-header">
							<i class="fas fa-table me-1"></i>
							Steaming
						</div>
						<div class="card-body">
							<table id="datatablesSimple">
								<thead>
									<tr>
									    <th>Date</th>
										<th>Lot Number</th>
										<th>Good</th>
									</tr>
								</thead>
								<tfoot>
								  <tr>
								    <th>Date</th>
									<th>Lot Number</th>
									<th>Good</th>
								  </tr>
								</tfoot>
								<tbody>';
                                    $get_steaming_data = "SELECT 
									YEAR(Date) as year, 
									MAX(date) AS last_date, Lot_type, SUM(Good) as totalGood FROM cashew_record 
                                    WHERE task='Steaming' AND Lot_type= '$select_lotType' ";
									if($start_date !== '' && $end_date !==''){
										$viewEachlotTotalEx .=" AND date BETWEEN '$start_date' AND '$end_date'";
									}elseif($start_date === ''){
										$viewEachlotTotalEx .=" AND date = '$end_date'";
									}elseif($end_date === ''){
										$viewEachlotTotalEx .=" AND date = '$start_date'";
									}
									$get_steaming_data .= " GROUP BY YEAR(date), Lot_type ORDER BY YEAR(date) DESC";
									$view_steaming_data = mysqli_query($conn, $get_steaming_data);
									if (!$view_steaming_data) {
										die('Query Error: ' . mysqli_error($conn));
									}
									while ($row = mysqli_fetch_assoc($view_steaming_data)) {
									$Steaming_date = $row['last_date'];
									$Steaming_lot_type = $row['Lot_type'];
									$Steaming_cw_good = $row['totalGood'];
									echo '<tr>
									<td>' . (strtotime("d/m/Y'", $Steaming_date)) . '</td>
									<td>' . ($Steaming_lot_type) . '</td>
									<td>' . ($Steaming_cw_good / $converdTor) . ' Kg</td>
									</tr>';
									}
								echo'</tbody>
							</table>
						</div>
					</div>
						';
		         }
}
else{///if there no some click on chekc button it will display this part 
// Specify the desired year
    $converdTor = 1000;
	$expend = "SELECT lot_type, SUM(good) as exgoodtotal, SUM(broken) as exbrokentotal, SUM(brown) as extotalbrown 
	FROM expend 
	WHERE id != 0 
	GROUP BY lot_type";
	$getexpeandData = mysqli_query($conn, $expend);
	$expendData = array();
	while ($row = mysqli_fetch_assoc($getexpeandData)) {
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

echo '
<div class="row mt-6 pt-6 shadow-sm p-3 bg-white rounded" style="margin-top: 4rem; border-radius: 10px">
<h4 class="mb-4 pt-6">In stock</h4>
<table class="table table-bordered">
 <thead style="background-color: green; color: white;">
	 <tr>
		 <th>Date</th>
		 <th>Lot Number</th>
		 <th>Good</th>
		 <th>Broken</th>
		 <th>Brown</th>
	 </tr>
 </thead>
 <tbody>';
		$getLotType = "SELECT Lot_type, date, COUNT(*) as count, SUM(Good) as totalgood, SUM(Broken) as totalbroken, SUM(brown) as totalbrown 
		FROM cashew_record
		WHERE Lot_type != '' AND task = 'Packing' 
		GROUP BY Lot_type ORDER BY date ASC";
		$view_users = mysqli_query($conn, $getLotType);
		while ($row = mysqli_fetch_assoc($view_users)) {
		$lotType = $row['Lot_type'];
		$lastDate = date('d/m/Y', strtotime($row['date']));
		$totalGood = $row['totalgood'];
		$totalBroken = $row['totalbroken'];
		$totalBrown = $row['totalbrown'];
		$exgoodtotal = isset($expendData[$lotType]['exgoodtotal']) ? $expendData[$lotType]['exgoodtotal'] : 0;
		$exbrokentotal = isset($expendData[$lotType]['exbrokentotal']) ? $expendData[$lotType]['exbrokentotal'] : 0;
		$extotalBrow = isset($expendData[$lotType]['extotalBrow']) ? $expendData[$lotType]['extotalBrow'] : 0;
		if($totalGood - $exgoodtotal<=0 && $totalBroken - $exbrokentotal<=0 && $totalBrown - $extotalBrow<=0 || 
			$totalGood===0 && $totalBroken===0 && $totalBrown===0){
			continue;
		}
			echo '
			<tr>
				<td>'.$lastDate.'</td>
				<td>'.$lotType.'</td>
				<td>'.(($totalGood - $exgoodtotal) / $converdTor).' Kg</td>
				<td>'.(($totalBroken - $exbrokentotal) / $converdTor).' Kg</td>
				<td>'.(($totalBrown - $extotalBrow) / $converdTor).' Kg</td>
			</tr>
			';
		}

echo '
 </tbody>
</table>
</div>';

echo '
<div class="shadow-sm p-3 mt-4 bg-white rounded">
<h4 class="mb-4">producing</h4>';
echo '<table class="table table-bordered">
	   <thead style="background-color: green; color: white;">
		  <tr>
			 <th>Date</th>
			 <th>Lot Number</th>
			 <th> Good</th>
			 <th> Broken</th>
			 <th> Brown</th>
			 <th> Total</th>
		  </tr>
	   </thead>
	   <tbody>';
$get_packing_data = "SELECT date, Lot_type, SUM(Good) as totalGood, SUM(Broken) as totalBroken, SUM(Brown) as totalBrown
    FROM cashew_record 
    WHERE task = 'Packing' GROUP BY Lot_type
    ORDER BY date ASC";
$view_packing_data = mysqli_query($conn, $get_packing_data);
if ($view_packing_data) {
    while ($row = mysqli_fetch_assoc($view_packing_data)) {
	   $lottype = $row['Lot_type'];
	   $datepack = $row['date'];
	   $p_Good = $row['totalGood'];
	   $p_Broken = $row['totalBroken'];
	   $p_Brown = $row['totalBrown'];
	   $formattedDate = date("d/m/Y", strtotime($datepack));
	   echo '<tr>
		    <td>' . $formattedDate . '</td>
		    <td>' . $lottype . '</td>
		    <td>' . ($p_Good/$converdTor) . ' Kg</td>
		    <td>' . ($p_Broken/$converdTor) . ' Kg</td>
		    <td>' . ($p_Brown/$converdTor) . ' Kg</td>
		    <td>' . (($p_Good+$p_Broken)/$converdTor) . ' Kg</td>
	    </tr>';
    }
}
echo '</tbody>
    </table>
	</div>
	';
	
//expending part
echo ' <div class="card mb-4 mt-5">
<div class="card-header">
    <i class="fas fa-table me-1"></i>
	Export
</div>
	<div class="card-body">
	   <table id="datatablesSimple">
		  <thead>
			 <tr>
			    <th>Date</th>
			    <th>Export Type</th>
				<th>Lot Number</th>
				<th>Good</th>
				<th>Broken</th>
				<th>Brown</th>
			 </tr>
		  </thead>
		  <tfoot>
			 <tr>
				<th>Date</th>
				<th>Expend Type</th>
				<th>Lot Number</th>
				<th>Good</th>
				<th>Broken</th>
				<th>Brown</th>
			 </tr>
		  </tfoot>
		  <tbody>';
		  $get_oven_data = "SELECT date, id, expend_type, good, broken, brown, lot_type
		  FROM expend WHERE id!=0  ORDER BY date ASC";
		  $view_oven_data = mysqli_query($conn, $get_oven_data);
		  while ($row = mysqli_fetch_assoc($view_oven_data)){
			$id = $row['id'];
			 $expend_type = $row['expend_type'];
			 $expend_date = $row['date'];
			 $expend_lot_type = $row['lot_type'];
			 $expend_cw_good = $row['good'];
			 $expend_cw_brock = $row['broken'];
			 $expend_cw_brown = $row['brown'];
			 $formatted_date = date('d/m/Y', strtotime($expend_date));
			 if($expend_type === "Disposal"){
				$expend_type = '<span class="expend-link" data-id="'.$id.'" style="cursor: pointer;	text-decoration: solid; ">Desposal</span>';
			}else{
				$expend_type;
			}
			 echo'<tr>
			 <td>'.$formatted_date.'</td>
			 <td>'.$expend_type.'</td>
			 <td>'.($expend_lot_type).'</td>
			 <td>'.($expend_cw_good/$converdTor).' Kg</td>
			 <td>'.($expend_cw_brock/$converdTor).' Kg</td>
			 <td>'.($expend_cw_brown/$converdTor).' Kg</td>
			 </tr>' ;
		    }
		  echo'</tbody>
	   </table>
    </div>
</div>
';
}
?>
<style>
.note_pop_up_container {
  width: 100%;
  height: 100vh;
  padding: 10px;
  position: fixed;
  top: 0;
  left: 0;
  justify-content: center;
  align-items: center;
  display: none;
}

.note_pop_up {
  position: relative;
  width: 40%;
  background-color: white;
  border-radius: 10px;
}
#not_pop_close_btn {
  position: absolute;
  font-size: 1.5rem;
  right: 10px;
  top: 10px;
  color: red;
}
.note_pop_up h5{
	padding: 20px 1px;
	color: yellow;
}
</style>
<div class="note_pop_up_container">
  <div class="note_pop_up shadow-sm p-3">
   <button id="not_pop_close_btn" class="btn"><i class="fas fa-times-circle"></i></button>
   <h5>Note</h5>
    <p id="note_content"></p>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const expendLinks = document.querySelectorAll('.expend-link');
  const notePopUpContainer = document.querySelector('.note_pop_up_container');
  const notePopUpCloseBtn = document.querySelector('#not_pop_close_btn');
  expendLinks.forEach(function(link) {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      const id = this.getAttribute('data-id');
      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Set the request URL and method
      const url = 'http://phumasia.com/cashew_app_web/admin/note/note_fetch_data.php'; // Replace with your PHP script URL
      const method = 'POST';
      xhr.open(method, url, true);

      // Set the request headers if needed
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

      // Set the data to be sent in the request body
      const data = 'id=' + encodeURIComponent(id);

      // Set the callback function to handle the server response
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Process the server response here
            const response = JSON.parse(xhr.responseText);
            const noteContent = document.getElementById('note_content');
            noteContent.innerHTML = response.note; // Update the note content

            // Show the pop-up container
            notePopUpContainer.style.display = 'flex';
          } else {
            // Handle the error case here
          }
        }
      };
      // Send the request
      xhr.send(data);
    });
  });
  notePopUpCloseBtn.addEventListener('click', function() {
  notePopUpContainer.style.display = 'none';
});

});
</script>





