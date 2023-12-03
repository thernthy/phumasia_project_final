
<style>
    #table{
    animation: fadeOut .8s ease-in-out;
}
@keyframes fadeOut {
    0% {
        transform: translateX(100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}
th{
    padding:  5px;
    border: 0;
    text-align: center;
    box-shadow: 1px 0px 10px rgb(0, 0, 0, 0.180);
    border-radius: 10px;
    background-color: green;
}
td{
    padding: 5px;
    border: 0;
    text-align: center;
}
.Sell_container{
  border-radius: 20px;
  margin: 20px 0px;
  position: relative;
  width: 100%;
  padding: 20px;
  box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
}
.view_sell{
  overflow: auto;
  position: relative;
  background: var(--white);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
  display: flex;
  justify-content: center;
  align-items: center;
  display:none;
  margin: 20px 0px;
}
.view_sell.active{
    display: block;
}
.chicken_contaner_control{
    overflow: auto;
}
.chicken_contaner_control table{
    width: 100%;
}
/* Webkit-based browsers */
.chicken_contaner_control::-webkit-scrollbar {
  width: 3px;
}

.chicken_contaner_control::-webkit-scrollbar-track {
  background-color: transparent;
}

.chicken_contaner_control::-webkit-scrollbar-thumb {
  background-color: green;
  border-radius: 5px;
}
.chicken_contaner_control::-webkit-scrollbar-thumb:hover {
  background-color: rgb(124, 235, 50);
}
.view_sell table{
    width: 100%;
}
@media (max-width: 659px) {
    .chicken_contaner_control table{
        width: 700px;
    }
    .view_sell table{
        width: 1024px;
    }
}
</style>
<div class="chicken_contaner_control">
<table id="table"
cellpadding="20px"
style="padding:20px; margin-top: 20px;
 box-shadow: 1px 0px 10px rgb(0,0,0,.130);
  border-radius:10px;">
  <tr style="color:white;">
    <th>ថ្ងៃចូល</th>
    <th>លេខសម្គាល់</th>
    <th>ចំនួនថ្ងៃ</th>
    <th>ចំនួនមាន់នៅសល់</th>
  </tr>
  <?php 
            $get_chiken_data = "SELECT chiken_qty, chiken_barcode, chiken_date, chiken_status,
             chiken_sold, chike_sold_qty,
             chike_sold_barcode, 
             chiken_sold_date			
            FROM chiken WHERE chiken_barcode!='' AND chiken_status=0 ";
           if(isset($_POST['fine_barcode'])){
                $bar_code_fine = $_POST['barcode'];
                $start_date_fine = $_POST['starting_date'];
                $ending_date_fine = $_POST['ending_date'];
                    if($start_date_fine != '' && $ending_date_fine != ''){
                        $get_chiken_data .= " AND chiken_date  BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                    } elseif($start_date_fine != ''){
                        $get_chiken_data .= " AND chiken_date  = '$start_date_fine'";
                    } elseif($ending_date_fine != ''){
                        $get_chiken_data .= " AND chiken_date  = '$ending_date_fine'";
                    }
                    if($bar_code_fine != 'all'){
                        $get_chiken_data .= " AND chiken_barcode = '$bar_code_fine'";
                    } else{
                        $get_chiken_data .= " AND chiken_barcode!=''";
                    }
            }
            $total = 0;
            $get_chiken_data .=" GROUP BY chiken_barcode";
            $view_chiken_data = mysqli_query($conn, $get_chiken_data);
            $check_data = 0;
            if(!$view_chiken_data){
                echo"Error:".mysqli_error($conn);
            }else{
                while($row = mysqli_fetch_assoc($view_chiken_data)){
                    $chike_sold_qty = $row['chike_sold_qty'];
                    $chiken_sold = $row['chike_sold_qty'];
                    $chiken_code = $row['chiken_barcode'];
                    $chiken_date  = date('Y-m-d', strtotime($row['chiken_date']));
                    $chiken_qty = ($chiken_sold!=0)? $row['chiken_qty'] - $chike_sold_qty : $row['chiken_qty'];
                    $chicken_current_date =  date('Y-m-d');
                    $total += $chiken_qty;
                    $days_since_insert_chicken = floor((strtotime($chicken_current_date) - strtotime($chiken_date)) / (60 * 60 * 24));
                    $days_since_insert_chicken +=30;
                    $check_data ++;
                    echo'
                    <tr>
                        <td>'.date('d-F-Y', strtotime($chiken_date)).'</td>
                        <td>'.$chiken_code.'</td>
                        <td>'.(($days_since_insert_chicken!=0)?$days_since_insert_chicken."<span style='color:green;'> ថ្ងៃ</span>" : '<span style="color:green;">ថ្ងៃនេះ</span>').'</td>
                        <td>'.$chiken_qty.'</td>
                    </tr>
                    ';
                }

                echo'
                 <tr>
                   <td colspan="4"><b>Total: </b> '.$total.' ក្បាល</td>
                 </tr>
                ';
                if($check_data === 0){
                    echo ' 
                    <div class="showing_data">      
                        <h2 style="color:red;">មិនមានទិន្ន័យ</h2>
                    </div>';
                }
            }
        ?>
  <!-- Add more rows as needed -->
</table>
</div>

<div class="Sell_container">
    <div class="cardHeader" style="margin: 20px;">
            <h2>ពិនិត្យមើលការលក់</h2>
            <button class="btn" style="margin:10px;" id="merl_btn" onclick="view_sold_ch_data()">មើលការលក់</button>
       </div>
                <?php
                    $get_sold_info = "SELECT ch_sold_barcode, ch_sold_date, 
                    ch_qty_amount, chicken_sold_add, ch_price, cmr_name, cmr_address, weight_amount,
                    cmr_contact_address, ch_sell_note FROM chiken_sold WHERE ch_sold_barcode!='' ";
                    if(isset($_POST['fine_barcode'])){
                        $bar_code_fine = $_POST['barcode'];
                        $start_date_fine = $_POST['starting_date'];
                        $ending_date_fine = $_POST['ending_date'];
                            if($start_date_fine != '' && $ending_date_fine != ''){
                                $get_sold_info .= " AND ch_sold_date  BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                            } elseif($start_date_fine != ''){
                                $get_sold_info .= " AND ch_sold_date  = '$start_date_fine'";
                            } elseif($ending_date_fine != ''){
                                $get_sold_info .= " AND ch_sold_date  = '$ending_date_fine'";
                            }
                            if($bar_code_fine != 'all'){
                                $get_sold_info .= " AND ch_sold_barcode = '$bar_code_fine'";
                            } else{
                                $get_sold_info .= " AND ch_sold_barcode!=''";
                            }
                    }
                    $view_ch_sold_ifo = mysqli_query($conn, $get_sold_info);
                    $check_data_sold = 0;
                    $total_ch_sold = 0;
                    $total_price = 0;
                    echo "
                    <div class='view_sell' id='ch_sold_content'>
                    <table>
                        <thead>
                            <tr style='font-size: .8rem; font-weight:800;'>
                                <td>ថ្ងៃលក់ចេញ</td>
                                <td>លេខ សម្គាល់</td>
                                <td>ចំនួនមាន់</td>
                                <td>ថែម</td>
                                <td>ចំនួនគីឡូ</td>
                                <td>តម្លៃឯកតា</td>
                                <td>តម្លៃសរុប</td>
                                <td>ឈ្មោះអតិថិជន</td>
                                <td>អាសយដ្ឋានអតិថិជន</td>
                                <td>ទំនាក់ទំនងអតិថិជន</td>
                                <td>កំណត់ចំណាំ</td>
                            </tr>
                        </thead>
                    <tbody>
                    ";
                    if(!$view_ch_sold_ifo){
                        echo"Error:".mysqli_error($conn);
                    }else{
                        while($row = mysqli_fetch_assoc($view_ch_sold_ifo)){
                            $ch_sold_date = date('d-F-Y', strtotime($row['ch_sold_date']));
                            $ch_sold_barcode = $row['ch_sold_barcode'];
                            $ch_sold_amount = $row['ch_qty_amount'];
                            $ch_sold_add = $row['chicken_sold_add'];
                            $ch_sold_price = $row['ch_price'];
                            $ch_sold_cmr_name = $row['cmr_name'];
                            $ch_sold_cmr_add = $row['cmr_address'];
                            $ch_sold_cmr_contact_add = $row['cmr_contact_address'];
                            $ch_sold_note = $row['ch_sell_note'];
                            $weight_amount = $row['weight_amount'];
                            $total_amount = ($ch_sold_amount * $ch_sold_price);
                            $total_ch_sold += $ch_sold_amount;
                            $total_price += $total_amount;
                            $check_data_sold++;
                            echo'
                                <tr style="font-size:.8rem;">
                                 <td>'.$ch_sold_date.'</td>
                                 <td>'.$ch_sold_barcode.'</td>
                                 <td>'.$ch_sold_amount.'</td>
                                 <td>'.$ch_sold_add.'</td>
                                 <td>'.$weight_amount.'</td>
                                 <td>'.number_format($ch_sold_price).' ៛</td>
                                 <td>'.number_format($total_amount).' ៛</td>
                                 <td>'.(($ch_sold_cmr_name!=0)?$ch_sold_cmr_name:'<span style="color:red;">មិនមានឈ្មោះ</span>').'</td>
                                 <td>'.(($ch_sold_cmr_add!=0)?$ch_sold_cmr_add:'<span style="color:red;">មិនមានទីតាំង</span>').'</td>
                                 <td>'.(($ch_sold_cmr_contact_add!=0)?$ch_sold_cmr_contact_add:'<span style="color:red;">គ្មានលេខទំនាកទំនង</span>').'</td>
                                 <td>'.$ch_sold_note.'</td>
                                </tr>
                            
                            ';
                        }
                    }
                    echo"
                        </tbody>
                        </table>
                          <div style='padding:20px; margin:20px;'>
                          <span style='color:".(($total_ch_sold!=0)?'green':'red')."'>ចំនួនកូនមាន់លក់សរុប <span style='color:black; font-weight: 600;'>".$total_ch_sold."</span> ក្បាល</span><br>
                          <span style='color:".(($total_price!=0)?'green':'red')."'>ទឹកប្រាក់សរុប <span style='color:black; font-weight: 600;'>".number_format($total_price)."</span> រៀល</span><br>
                          </div>
                        </div>
                        ";
                    if($check_data_sold === 0){
                        echo"
                            <h4 style='text-align:center; color:red;'>មិនមានទិន្នន័យទេ!</h4>
                        ";
                    }else{
                        echo"
                        <h4 style='text-align:center; color:green;'>ការលក់មាន​: ".$check_data_sold."</h4>
                        ";
                    }
                ?>
</div>