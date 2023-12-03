<?php
$selectTask = $_POST['selectTask'];
$selectDate = $_POST['selectDate'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$exgoodtotal= 0;
$exbrokentotal=0;
$extotalBrown=0;
$converdTor = 1000;//convertor from g to kg
$year = 2023; //=++++=====Get year ===++++==
///this it will get data from database and 
if($selectTask !=='Steaming'){
// View in each lot total Good  Broken Brown for expend a day+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    if($selectTask === 'Packing'){
        $expend = "SELECT YEAR(date) AS year, lot_type, SUM(good) as exgoodtotal, SUM(broken) as exbrokentotal, SUM(brown) as extotalbrown 
        FROM expend 
        WHERE id != 0";
        if($start_date !== '' && $end_date !==''){
            $expend .=" AND date BETWEEN '$start_date' AND '$end_date'";
        }elseif($start_date === ''){
            $expend .=" AND date = '$end_date'";
        }elseif($end_date === ''){
            $expend .=" AND date = '$start_date'";
        }
        $expend .=" GROUP BY YEAR(date), lot_type";
        $getexpeandData = mysqli_query($conn, $expend);
        $expendData = array();
        while ($row = mysqli_fetch_assoc($getexpeandData)) {
        $year = $row['year'];   
        $exLot_type = $row['lot_type'];
        $exgoodtotal = $row['exgoodtotal'];
        $exbrokentotal = $row['exbrokentotal'];
        $extotalBrow = $row['extotalbrown'];
        $expendData[$year][$exLot_type ]= array(
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
            $Instock = "SELECT YEAR(date) AS year, Lot_type, MAX(date) as last_date, COUNT(*) as count, SUM(Good) as totalgood, SUM(Broken) as totalbroken, SUM(brown) as totalbrown 
            FROM cashew_record
            WHERE Lot_type != '' AND task = 'Packing' ";
                    if($start_date !== '' && $end_date !==''){
                        $Instock .=" AND date BETWEEN '$start_date' AND '$end_date'";
                    }elseif($start_date === ''){
                        $Instock .=" AND date = '$end_date'";
                    }elseif($end_date === ''){
                        $Instock .=" AND date = '$start_date'";
                    }
                $Instock .=" GROUP BY YEAR(date), Lot_type ORDER BY date ASC";
            $view_users = mysqli_query($conn, $Instock);
            while ($row = mysqli_fetch_assoc($view_users)) {
            $year = $row['year'];
            $lotType = $row['Lot_type'];
            $lastDate = date('d/F/Y', strtotime($row['last_date']));
            $totalGood = $row['totalgood'];
            $totalBroken = $row['totalbroken'];
            $totalBrown = $row['totalbrown'];
            $exgoodtotal = isset($expendData[$year][$lotType]['exgoodtotal']) ? $expendData[$year][$lotType]['exgoodtotal'] : 0;
            $exbrokentotal = isset($expendData[$year][$lotType]['exbrokentotal']) ? $expendData[$year][$lotType]['exbrokentotal'] : 0;
            $extotalBrow = isset($expendData[$year][$lotType]['extotalBrow']) ? $expendData[$year][$lotType]['extotalBrow'] : 0;
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
        $get_packing_data = "SELECT YEAR(date) AS year, MAX(date) as last_date,
        Lot_type, SUM(Good) as totalGood, SUM(Broken) as totalBroken, SUM(Brown) as totalBrown
        FROM cashew_record 
        WHERE task = 'Packing' 
        ";
        if($start_date !== '' && $end_date !==''){
            $get_packing_data .=" AND date BETWEEN '$start_date' AND '$end_date'";
        }elseif($start_date === ''){
        $get_packing_data .=" AND date = '$end_date'";
        }elseif($end_date === ''){
            $get_packing_data .=" AND date = '$start_date'";
        }
        $get_packing_data .=" GROUP BY Lot_type";
        $get_packing_data .=" ORDER BY date ASC";
        $view_packing_data = mysqli_query($conn, $get_packing_data);
        if ($view_packing_data) {
        while ($row = mysqli_fetch_assoc($view_packing_data)) {
           $lottype = $row['Lot_type'];
           $datepack = $row['last_date'];
           $p_Good = $row['totalGood'];
           $p_Broken = $row['totalBroken'];
           $p_Brown = $row['totalBrown'];
           $formattedDate = date("m/d/Y", strtotime($datepack));
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
              $get_packing_data = "SELECT date, id, expend_type, good, broken, brown, lot_type
              FROM expend WHERE id!=0 ";
                if($start_date !== '' && $end_date !==''){
                    $get_packing_data .=" AND date BETWEEN '$start_date' AND '$end_date'";
                }elseif($start_date === ''){
                    $get_packing_data .=" AND date = '$end_date'";
                }elseif($end_date === ''){
                    $get_packing_data .=" AND date = '$start_date'";
                }
                $get_packing_data .=" ORDER BY date ASC";
                
              $view_packing_data = mysqli_query($conn, $get_packing_data);
              while ($row = mysqli_fetch_assoc($view_packing_data)){
                $id = $row['id'];
                 $expend_type = $row['expend_type'];
                 $expend_date = $row['date'];
                 $expend_lot_type = $row['lot_type'];
                 $expend_cw_good = $row['good'];
                 $expend_cw_brock = $row['broken'];
                 $expend_cw_brown = $row['brown'];
                 $formatted_date = date('m/d/Y', strtotime($expend_date));
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
    }else{
           
    echo '
    <div class="shadow-sm p-3 bg-white rounded" style="margin-top: 5rem;">
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
        WHERE task = '$selectTask'  ";
            if($start_date !== '' && $end_date !==''){
                $get_packing_data .=" AND date BETWEEN '$start_date' AND '$end_date'";
            }elseif($start_date === ''){
                $get_packing_data .=" AND date = '$end_date'";
            }elseif($end_date === ''){
                $get_packing_data .=" AND date = '$start_date'";
            }
        $get_packing_data .="  GROUP BY Lot_type";
        $get_packing_data .=" ORDER BY date ASC";
    $view_packing_data = mysqli_query($conn, $get_packing_data);
    if ($view_packing_data) {
        while ($row = mysqli_fetch_assoc($view_packing_data)) {
           $lottype = $row['Lot_type'];
           $datepack = $row['date'];
           $p_Good = $row['totalGood'];
           $p_Broken = $row['totalBroken'];
           $p_Brown = $row['totalBrown'];
           $formattedDate = date("m/d/Y", strtotime($datepack));
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
    }
}else{
    echo '
    <div class="row shadow-sm pt-5" style="margin-top: 4rem;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Steamer name</th>
                    <th>Lot Number</th>
                    <th>Total Good</th>
                </tr>
            </thead>
            <tbody>
        ';
            $viewEachlotTotal = "SELECT Name, date, Lot_type, Good 
            FROM cashew_record 
            WHERE task = '$selectTask'";
                        if($start_date !== '' && $end_date !==''){
                            $viewEachlotTotal.=" AND date BETWEEN '$start_date' AND '$end_date'";
                        }elseif($start_date === ''){
                            $viewEachlotTotal.=" AND date = '$end_date'";
                        }elseif($end_date === ''){
                            $viewEachlotTotal.=" AND date = '$start_date'";
                        }
            $viewEachlotTotal .=" ORDER BY date ASC";
            $viewEachCashew = mysqli_query($conn, $viewEachlotTotal);
            if ($viewEachCashew) {
                while ($row = mysqli_fetch_assoc($viewEachCashew)) {
                    $lottypeEch = $row['Lot_type'];
                    $steaming_date = $row['date'];
                    $totalGoodEch = $row['Good'];
                    $name = $row['Name'];
                    $formatted_date = date('F/d/Y', strtotime($steaming_date));
                    echo '<tr>
                        <td>' .$formatted_date. '</td>
                        <td>' . $name. '</td>
                        <td>' . $lottypeEch . '</td>
                        <td>' . ($totalGoodEch/$converdTor) . ' Kg </td>
                    </tr>';
                }
            }
            echo '
            </tbody>
        </table> 
    </div>';
}
?>

