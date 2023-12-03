
<?php
include("db_connection.php");
//get dai For baybe chicken total
$get_bch_dai_data = "SELECT 
SUM(Amount_dai) AS totalDai, Ch_barcode, Dia_date, chicken_type FROM bch_dai
WHERE Status_dia='active' AND chicken_type='b_chicken'";
if(isset($_POST['fine_barcode'])){
    $bar_code_fine = $_POST['barcode'];
    $start_date_fine = $_POST['starting_date'];
    $ending_date_fine = $_POST['ending_date'];
    if($start_date_fine != '' && $ending_date_fine != ''){
        $get_bch_dai_data .= " AND Dia_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
    } elseif($start_date_fine != ''){
        $get_bch_dai_data .= " AND Dia_date = '$start_date_fine'";
    } elseif($ending_date_fine != ''){
        $get_bch_dai_data .= " AND Dia_date = '$ending_date_fine'";
    }
    if($bar_code_fine != 'all'){
        $get_bch_dai_data .= " AND Ch_barcode = '$bar_code_fine'";
    } else{
        $get_bch_dai_data .= " AND Ch_barcode!=''";
    }
}
$view_bch_dai_data = mysqli_query($conn, $get_bch_dai_data);
$avirable_bch = 0;
if($view_bch_dai_data){
    $row = mysqli_fetch_assoc($view_bch_dai_data);
    $total_dia = $row['totalDai'];
}
//get sold out For baby chicken totale and fine avarible baby chicken 
$get_bch_data = ("SELECT SUM(Qty) AS totalBabyChiken, SUM(Sold_qty) AS totalsold, Take_out_date, Status FROM b_chiken WHERE Status='active' ");
        if(isset($_POST['fine_barcode'])){
            $bar_code_fine = $_POST['barcode'];
            $start_date_fine = $_POST['starting_date'];
            $ending_date_fine = $_POST['ending_date'];
            if($start_date_fine != '' && $ending_date_fine != ''){
                $get_bch_data .= " AND Take_out_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
            } elseif($start_date_fine != ''){
                $get_bch_data .= " AND Take_out_date = '$start_date_fine'";
            } elseif($ending_date_fine != ''){
                $get_bch_data .= " AND Take_out_date = '$ending_date_fine'";
            }
            if($bar_code_fine != 'all'){
                $get_bch_data .= " AND Ch_barcode = '$bar_code_fine'";
            } else{
                $get_bch_data .= " AND Ch_barcode!=''";
            }
        }
        $viw_bch_data = mysqli_query($conn, $get_bch_data);
        if ($viw_bch_data) {
            $row = mysqli_fetch_assoc($viw_bch_data);
            $total_bch = $row['totalBabyChiken'];
            $sold_aout_amount = (!$row['totalsold'])?0:$row['totalsold'];
        }
        $avirable_bch = $total_bch - ($total_dia + $sold_aout_amount);

//get sold out total amount b_chiken 
$get_total_b_ch_sold = ("SELECT 
    b_ch_sold_barcode,	
    b_ch_sold_stuts, 
    b_ch_sold_amount, 
    SUM(b_ch_sold_amount) AS totalsold,
    SUM(b_ch_add) AS totalAdd, 
    b_ch_sold_date
    FROM b_ch_sold WHERE b_ch_sold_stuts= 'active'");
    if(isset($_POST['fine_barcode'])){
        $bar_code_fine = $_POST['barcode'];
        $start_date_fine = $_POST['starting_date'];
        $ending_date_fine = $_POST['ending_date'];
        if($start_date_fine != '' && $ending_date_fine != ''){
            $get_total_b_ch_sold .= " AND b_ch_sold_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
        } elseif($start_date_fine != ''){
            $get_total_b_ch_sold .= " AND b_ch_sold_date = '$start_date_fine'";
        } elseif($ending_date_fine != ''){
            $get_total_b_ch_sold .= " AND b_ch_sold_date = '$ending_date_fine'";
        }
        if($bar_code_fine != 'all'){
            $get_total_b_ch_sold .= " AND b_ch_sold_barcode = '$bar_code_fine'";
        } else{
            $get_total_b_ch_sold .= " AND b_ch_sold_barcode!=''";
        }
    } 
    $total_sold_b_ch_amount_sold = mysqli_query($conn, $get_total_b_ch_sold);
    if(!$total_sold_b_ch_amount_sold){echo'Error:'.mysqli_error($conn);}{
        $total_sold_amount_data = mysqli_fetch_assoc($total_sold_b_ch_amount_sold);
        $total_sold_amount = $total_sold_amount_data['totalsold'];
        $total_add = (!$total_sold_amount_data['totalAdd'])?0:$total_sold_amount_data['totalAdd'];
        $total_sold = $total_add + $total_sold_amount;
    }
?>
            <!--========= totale check circle block ====== --->
            <div class="card_check">
                <div class="circle" id="circle">
                    <p id="avarible_checken"><?php echo $total_bch ?></p><span>​​ ក្បាល</span>
                    <h5>កូនមាន់ផលិតបាន</h5>
                </div>
                <div class="circle dia" id="dia">
                    <p id="dai_checken"><?php echo (!$total_dia)? 0 : $total_dia ?></p><span>​​ ក្បាល</span>
                    <h5>កូនមាន់ស្លាប់</h5>
                </div>
                <div class="circle" id="sold">
                    <p id="sold_checken"><?php echo (!$avirable_bch)? 0 :$avirable_bch?></p><span>​​ ក្បាល</span>
                    <h5>កូនមាន់នៅសល់</h5>
                </div>
                <div class="circle" id="b_ch_sold_block">
                    <p id="b_ch_sold"><?php echo (!$total_sold_amount)?0:$total_sold_amount?></p><span>​​ ក្បាល</span>
                    <h5>កូនមាន់លក់ចេញ</h5>
                </div>
            </div>
            <!-- ================ Order Details List ================= -->
            <div class="details"> 
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>ពិនិត្យកូនមាន់</h2>
                        <!--<button class="btn" onclick="viewAllBadyChiken()">មើលបន្ថែម</button>-->
                    </div>

                    <table>
                        <thead>
                            <tr style="font-size: 1rem; text-align:center;">
                                <td>កាលបរិច្ឆេទញាស់</td>
                                <td>លេខ សម្គាល់</td>
                                <td>ចំនួនថ្ងៃ</td>
                                <td>ចំនួន សរុប</td>
                                <td>ញូកាស</td>
                                <td>កុំប៉ូរ៉ូ</td>
                                <td style="text-align:center;">អ៊ុត</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $get_bch_dai_data = ("SELECT SUM(Amount_dai) AS totalDai, Ch_barcode, Status_dia, chicken_type
                            FROM bch_dai WHERE Status_dia='active'And chicken_type='b_chicken' ");
                            if(isset($_POST['fine_barcode'])){
                                $bar_code_fine = $_POST['barcode'];
                                $start_date_fine = $_POST['starting_date'];
                                $ending_date_fine = $_POST['ending_date'];
                                if($start_date_fine != '' && $ending_date_fine != ''){
                                    $get_bch_dai_data .= " AND Dia_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                                } elseif($start_date_fine != ''){
                                    $get_bch_dai_data .= " AND Dia_date = '$start_date_fine'";
                                } elseif($ending_date_fine != ''){
                                    $get_bch_dai_data .= " AND Dia_date = '$ending_date_fine'";
                                }
                                if($bar_code_fine != 'all'){
                                    $get_bch_dai_data .= " AND Ch_barcode = '$bar_code_fine'";
                                } else{
                                    $get_bch_dai_data .= " AND Ch_barcode!=''";
                                }
                            }
                            $get_bch_dai_data .=" GROUP BY Ch_barcode";
                            $view_bch_dai_data = mysqli_query($conn, $get_bch_dai_data);
                            $bch_dai_barcode = array();
                            if($view_bch_dai_data){
                                while($row = mysqli_fetch_assoc($view_bch_dai_data)){
                                    $total_bch_data = $row['totalDai'];
                                    $dia_bar_code = $row['Ch_barcode'];
                                    $dai_status = $row['Status_dia'];
                                    $bch_dai_barcode[$dia_bar_code] = array(
                                        'totaldai' => $total_bch_data
                                    );
                                }
                            }
                            $get_each_bch_data = "SELECT 
                            Ch_barcode, Take_out_date, Qty, Vaccines1, Vaccines2, Vaccines3, Reminder, Status,
                            Sold, Sold_qty
                            FROM b_chiken WHERE Status = 'active' ";
                            if(isset($_POST['fine_barcode'])){
                                $bar_code_fine = $_POST['barcode'];
                                $start_date_fine = $_POST['starting_date'];
                                $ending_date_fine = $_POST['ending_date'];
                                if($start_date_fine != '' && $ending_date_fine != ''){
                                    $get_each_bch_data .= " AND Take_out_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                                } elseif($start_date_fine != ''){
                                    $get_each_bch_data .= " AND Take_out_date = '$start_date_fine'";
                                } elseif($ending_date_fine != ''){
                                    $get_each_bch_data .= " AND Take_out_date = '$ending_date_fine'";
                                }
                                if($bar_code_fine != 'all'){
                                    $get_each_bch_data .= " AND Ch_barcode = '$bar_code_fine'";
                                } else{
                                    $get_each_bch_data .= " AND Ch_barcode!=''";
                                }
                            }
                            $get_each_bch_data .=" ORDER BY MONTH(Take_out_date) DESC LIMIT 12";
                            $view_each_bch_data = mysqli_query($conn, $get_each_bch_data);
                            if ($view_each_bch_data) {
                                while ($row = mysqli_fetch_assoc($view_each_bch_data)) {
                                    $bar_code_id = $row['Ch_barcode'];
                                    $take_out_date = $row['Take_out_date'];
                                    $ch_sold_out = $row['Sold'];
                                    $ch_sold_amount = $row['Sold_qty'];
                                    $amount = ($ch_sold_amount!=0)? $row['Qty'] - $ch_sold_amount : $row['Qty'];
                                    $vaccines_one = $row['Vaccines1'];
                                    $vaccines_two = $row['Vaccines2'];
                                    $vaccines_three = $row['Vaccines3'];
                                    $reminder = $row['Reminder'];
                                    $status = $row['Status'];
                                    $current_date = date('Y-m-d');
                                    $bch_total_dai = isset($bch_dai_barcode[$bar_code_id]['totaldai']) ? $bch_dai_barcode[$bar_code_id]['totaldai'] : 0;
                                    $chek_vaccines = '';
                                    $days_since_insert = floor((strtotime($current_date) - strtotime($take_out_date)) / (60 * 60 * 24));
                                    $get_chiken_avarible = $amount - $bch_total_dai;
                                    if($days_since_insert == 30) {
                                        if(!$get_chiken_avarible <=0){
                                                $chiken_status = "active";
                                                $insert_chiken = "INSERT INTO chiken (chiken_barcode, chiken_qty, chiken_date, chiken_status)
                                                VALUES (?, ?, ?, ?)";
                                                $stmt = mysqli_prepare($conn, $insert_chiken);
                                                if ($stmt) {
                                                    if (mysqli_stmt_bind_param($stmt, "ssss", $bar_code_id, $get_chiken_avarible, $current_date, $chiken_status)) {
                                                        if (mysqli_stmt_execute($stmt)) {
                                
                                                        } else {
                                                            echo "Error executing INSERT statement: " . mysqli_error($conn);
                                                        }

                                                    } else {
                                                        echo "Error binding parameters for INSERT statement: " . mysqli_error($conn);
                                                    }
                                                } else {
                                                    echo "Error preparing INSERT statement: " . mysqli_error($conn);
                                                }
                                            }
                                            $update_bch_data = "UPDATE b_chiken SET Status = 'off' WHERE Ch_barcode=?";
                                            $stmt_update_bch = mysqli_prepare($conn, $update_bch_data);
                                            if ($stmt_update_bch) {
                                                mysqli_stmt_bind_param($stmt_update_bch, "s", $bar_code_id);
                                                if (mysqli_stmt_execute($stmt_update_bch)) {
                                                } else {
                                                    echo "Error updating b_chiken data: " . mysqli_error($conn);
                                                }
                                            } else {
                                                echo "Error preparing b_chiken update statement: " . mysqli_error($conn);
                                            }
                                            $update_bch_dai = "UPDATE bch_dai SET Status_dia ='off'  
                                            WHERE Ch_barcode=? And chicken_type='b_chicken'";
                                            $stmt_update_bch_dai = mysqli_prepare($conn, $update_bch_dai);
                                            if ($stmt_update_bch_dai) {
                                                mysqli_stmt_bind_param($stmt_update_bch_dai, "s", $bar_code_id);
                                                if (mysqli_stmt_execute($stmt_update_bch_dai)) {
                                                } else {
                                                    echo "Error updating bch_dai data: " . mysqli_error($conn);
                                                }
                                            } else {
                                                echo "Error preparing bch_dai update statement: " . mysqli_error($conn);
                                            }
                                            // $update_b_ch_sold = "UPDATE b_ch_sold SET b_ch_sold_stuts = 'Off' WHERE b_ch_sold_barcode=?";
                                            // $stmt_update_b_ch_sold = mysqli_prepare($conn, $update_b_ch_sold);
                                            // if ($stmt_update_b_ch_sold) {
                                            //     mysqli_stmt_bind_param($stmt_update_b_ch_sold, "s", $bar_code_id);
                                            //     if (mysqli_stmt_execute($stmt_update_b_ch_sold)) {
                                            //     } else {
                                            //         echo "Error updating b_ch_sold data: " . mysqli_error($conn);
                                            //     }
                                            // } else {
                                            //     echo "Error preparing b_ch_sold update statement: " . mysqli_error($conn);
                                            // }
                                    }
                                    ///chack reminder vaccines 

                                    $font_size= .8;
                                    $fir_vaccinecheckdate = new DateTime(date('d-m-Y', strtotime($take_out_date)));
                                    echo '<tr style="text-align:center;">
                                    <td style="font-size:'.$font_size.'rem;">'.date('d/m/Y', strtotime($take_out_date)).'</td>
                                    <td style="font-size:'.$font_size.'rem;">'.$bar_code_id.'</td>
                                    <td style="font-size:'.$font_size.'rem;">'
                                    .(($days_since_insert != 0) ? $days_since_insert." <span style='color:green;'>​​ថ្ងៃ</span>" : 
                                    '<span style="color: green;">ថ្ងៃនេះ</span>').
                                    '</td>
                                    <td style="font-size:'.$font_size.'rem;">'.($amount - $bch_total_dai).'</td>
                                    <td style="font-size:'.$font_size.'rem; color:'.(($vaccines_one!='')?'green':'red').'">
                                        '.(($fir_vaccinecheckdate->modify('+2 days')->Format('d/m/Y'))).'<br>
                                        '.(($reminder!='' && $reminder===$vaccines_one)?"<span style='color:black; font-size:.5rem;'>រំលឹក</span>":'').'
                                    </td>
                                    <td style="font-size:'.$font_size.'rem;color:'.(($vaccines_two!='')? 'green':'red').';">
                                        '.(($fir_vaccinecheckdate->modify('+7 days')->Format('d/m/Y'))).'<br>
                                        '.(($reminder!='' && $reminder===$vaccines_two)?"<span style='color:black;font-size:.5rem;'>រំលឹក</span>":'').'
                                    </td>
                                    <td style="font-size:'.$font_size.'rem;color:'.(($vaccines_three!='')? 'green':'red').';">
                                        '.(($fir_vaccinecheckdate->modify('+7 days')->Format('d/m/Y'))).'<br>
                                        '.(($reminder!='' && $reminder===$vaccines_three)?"<span style='color:black;font-size:.5rem;'>រំលឹក</span>":'').'
                                    </td>
                                </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>មាន់លក់ចេញ</h2>
                        <button class="btn" onclick="viewAllBadyChikenSold()">មើលលម្អិត</button>
                    </div>
                    <table>
                        <?php
                          $sold_out_checking = 0; 
                            $get_sold_data = ("SELECT b_ch_sold_stuts, b_ch_sold_barcode, SUM(b_ch_sold_amount) AS totalsold, b_ch_sold_date
                            FROM b_ch_sold WHERE b_ch_sold_stuts= 'active' AND b_ch_sold_barcode  !=''");
                            if(isset($_POST['fine_barcode'])){
                                $bar_code_fine = $_POST['barcode'];
                                $start_date_fine = $_POST['starting_date'];
                                $ending_date_fine = $_POST['ending_date'];
                                if($start_date_fine != '' && $ending_date_fine != ''){
                                    $get_sold_data .= " AND b_ch_sold_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                                } elseif($start_date_fine != ''){
                                    $get_sold_data .= " AND b_ch_sold_date = '$start_date_fine'";
                                } elseif($ending_date_fine != ''){
                                    $get_sold_data .= " AND b_ch_sold_date = '$ending_date_fine'";
                                }
                                if($bar_code_fine != 'all'){
                                    $get_sold_data .= " AND b_ch_sold_barcode  ='$bar_code_fine'";
                                } else{
                                    $get_sold_data .= " AND b_ch_sold_barcode !=''";
                                }
                            } 
                            $get_sold_data .="GROUP BY b_ch_sold_barcode  ORDER BY MONTH(b_ch_sold_date) DESC LIMIT 12";
                            $view_sold_out_data = mysqli_query($conn, $get_sold_data);
                            if($view_sold_out_data){
                                while($row = mysqli_fetch_assoc($view_sold_out_data)){
                                    $sold_barcode_id = $row['b_ch_sold_barcode'];
                                    $sold_out_amount = $row['totalsold'];
                                    $sold_out_data = date('d-m-Y', strtotime($row['b_ch_sold_date']));
                                    echo'
                                    <tr>
                                        <td>
                                            <h4><a href="#">'.$sold_barcode_id.'</a><br>
                                            <span>'.'ចំនួន:'.'<b style="color:green;"> '.$sold_out_amount.'</b>'.' ​ក្បាល'.'</span></h4>
                                        </td>
                                        <td>
                                            <h5>ថ្ងៃ <br><span>'.$sold_out_data.'</span></h5>
                                        </td>
                                    </tr>
                                    ';
                                    $sold_out_checking ++;
                                }
                            }else{
                                echo'
                                <tr>
                                    <td style="text-align:center; color:red;">
                                    <span class="danger" >No sold out!</span>
                                    </td>
                                </tr>
                                ';
                            }
                            if($sold_out_checking === 0){
                                echo'
                                <tr>
                                    <td style="text-align:center; color:red;">
                                        <span class="danger">No sold out!</span>
                                    </td>
                                </tr>
                                ';
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div class="viewAll_bch_container" id="viewAll_bch_container">
                <div class="data_dable">
                    <i class="fa-solid fa-circle-xmark" onclick="viewAllBadyChikenClose()"></i>
                    <?php include "routing/viewall_ch.php"?>
                </div>
            </div>
            <div class="viewAll_bch_container" id="viewAll_bch_container_sold">
                <div class="data_dable">
                    <i class="fa-solid fa-circle-xmark" onclick="viewAllBadyChikenCloseSold()"></i>
                    <?php include"routing/viewall_ch_sold.php" ?>
                    <div style="position: absolute; bottom:10px; right:20px;">
                        <h5>ចំនួនលក់សរុប: <?php echo (($totle_b_ch_sold!=0)?'<span style="color:green;">'.$totle_b_ch_sold.' ក្បាល</span>':'<span style="color:red;">'.$totle_b_ch_sold.'</span>')?></h5>
                        <h5>ចំនួនទឹកប្រាក់សរុប: <?php echo (($totle_b_ch_sold_price!=0)?'<span style="color:green;">'.number_format($totle_b_ch_sold_price).' រៀល</span>':'<span style="color:red;">'.$totle_b_ch_sold_price.'</span>')?> </h5>
                    </div>
                </div>
            </div>
           <!-- <button class="print_btn">Print</button>
    <div class="container_print_paper">
        <div class="a4-paper">
             Your content to be displayed on the A4 paper goes here 
            <h1>Hello, A4 Paper!</h1>
            <p>This is an example of an A4-sized paper using CSS.</p>
        </div>
    </div>-->