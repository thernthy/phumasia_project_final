<?php
    $sold_out_checking = 0; 
    $get_sold_data = ("SELECT b_ch_sold_barcode, b_ch_sold_date, b_ch_sold_amount, b_ch_price, b_ch_add, 
        b_ch_cmr_name, b_ch_cmr_ad, b_ch_cmr_con_ad, b_ch_note, b_ch_sold_stuts
        FROM b_ch_sold 
        WHERE b_ch_sold_stuts='active' ");
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
            $get_sold_data .= " AND b_ch_sold_barcode= '$bar_code_fine'";
        } else{
            $get_sold_data .= " AND b_ch_sold_barcode!=''";
        }
    } 
    $font_size = ".6rem";
    $totle_b_ch_sold =0;
    $totle_b_ch_sold_price = 0;
    $get_sold_data .=" ORDER BY MONTH(b_ch_sold_date) DESC";
    $view_sold_out_data = mysqli_query($conn, $get_sold_data);
        if($view_sold_out_data){
            while($row = mysqli_fetch_assoc($view_sold_out_data)){
                $sold_barcode_id = $row['b_ch_sold_barcode'];
                $b_ch_sold_date = date('d-F-Y', strtotime($row['b_ch_sold_date']));
                $b_ch_sold_amount = $row['b_ch_sold_amount'];
                $b_ch_price = $row['b_ch_price'];
                $b_ch_add = $row['b_ch_add'];
                $b_ch_cmr_name = $row['b_ch_cmr_name'];
                $b_ch_cmr_ad = $row['b_ch_cmr_ad'];
                $b_ch_cmr_con_ad = $row['b_ch_cmr_con_ad'];
                $b_ch_note = $row['b_ch_note'];
                $b_ch_sold_total_price = ($b_ch_sold_amount * $b_ch_price);
                $b_ch_sold_total_amount = ($b_ch_sold_amount + $b_ch_add);
                $totle_b_ch_sold += $b_ch_sold_amount;
                $totle_b_ch_sold_price += $b_ch_sold_total_price;
                echo'<div class="data_row">
                    <h5>ថ្ងៃ<br><span>'.$b_ch_sold_date.'</span></h5>
                    <h5>
                        <span style="font-size:'.$font_size.'">កូដកូនមាន់</span><br>
                        <a href="#">'.$sold_barcode_id.'</a>
                     </h5>
                     <h5>
                        <span style="font-size:'.$font_size.'">ចំនួនកូនមាន់</span><br>
                        <span>'.$b_ch_sold_amount.'</span>
                     </h5>
                     <h5>
                        <span style="font-size:'.$font_size.'">តម្លៃឯកតា</span><br>
                        <span>'.$b_ch_price.'</span>
                     </h5>
                     <h5>
                        <span style="font-size:'.$font_size.'">តម្លៃសរុប</span><br>
                        <span>'.$b_ch_sold_total_price.'</span>
                    </h5>
                    <h5>
                        <span style="font-size:'.$font_size.';">ថែម</span><br>
                        <span>'.(($b_ch_add!=0)?$b_ch_add:'មិនមានថែម').'</span>
                    </h5>
                     <h5>
                        <span style="font-size:'.$font_size.'">កូនមាន់សរុប</span><br>
                        <span>'.$b_ch_sold_total_amount.'</span>
                        </h5>

                     <h5>
                        <span style="font-size:'.$font_size.';">ឈ្មោះអតិថិជន</span><br>
                        <span>'.(($b_ch_cmr_name!='')?$b_ch_cmr_name:'<span style="color:red; font-size:'.$font_size.';">មិនមាឈ្មោះ</span>').'</span>
                     </h5>
                     <h5>
                        <span style="font-size:'.$font_size.'">អាស័យដ្ឋានអតិថិជន</span><br>
                        <span>'.(($b_ch_cmr_ad!='')?$b_ch_cmr_ad:'<span style="color:red; font-size:'.$font_size.';">មិនមានទីតាំ!</span>').'</span>
                     </h5>
                     <h5>
                        <span style="font-size:'.$font_size.'">ទំនាក់ទំនងអតិថិជន</span><br>
                        <span>'.(($b_ch_cmr_ad!='')?$b_ch_cmr_ad:'<span style="color:red; font-size:'.$font_size.';">គ្នាអាស័ដ្ជាទាក់ទង់</span>').'</span>
                     </h5>
                 </div>';
                $sold_out_checking ++;
            }
        }else{

            }
        if($sold_out_checking === 0){
            echo'
            <div class="data_row">
             <h5 style="color:red;"><span>មិនមានការលក់</span></h5>
            </div>';
        }
?>