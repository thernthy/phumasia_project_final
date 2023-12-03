<?php
    $get_bch_dai_data = ("SELECT SUM(Amount_dai) AS totalDai, Ch_barcode, Status_dia
        FROM bch_dai WHERE Status_dia=0 GROUP BY Ch_barcode");
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
    $get_each_bch_data_from = "SELECT 
        Ch_barcode, Take_out_date, Qty, Vaccines1, Vaccines2, Vaccines3, Reminder, Status, Sold, Sold_qty
        FROM (
            SELECT Ch_barcode, Take_out_date, Qty, Vaccines1, Vaccines2, Vaccines3, Reminder, Status, Sold, Sold_qty
            FROM b_chiken
            WHERE Status = 0
            ORDER BY MONTH(Take_out_date) 
            LIMIT 18446744073709551615 OFFSET 13
            ) AS subquery";
    $view_each_bch_data = mysqli_query($conn, $get_each_bch_data_from);
        $checkdata = 0;
        if ($view_each_bch_data) {
            while ($row = mysqli_fetch_assoc($view_each_bch_data)) {
                $bar_code_id = $row['Ch_barcode'];
                $take_out_date = $row['Take_out_date'];
                $ch_sold_out = $row['Sold'];
                $ch_sold_amount = $row['Sold_qty'];
                $amount = ($ch_sold_out !=0 || '')? $row['Qty'] - $ch_sold_amount : $row['Qty'];
                $vaccines_one = $row['Vaccines1'];
                $vaccines_two = $row['Vaccines2'];
                $vaccines_three = $row['Vaccines3'];
                $reminder = $row['Reminder'];
                $status = $row['Status'];
                $current_date = date('Y-m-d');
                $checkdata++;
                $bch_total_dai = isset($bch_dai_barcode[$bar_code_id]['totaldai']) ? $bch_dai_barcode[$bar_code_id]['totaldai'] : 0;
                $chek_vaccines = '';
                $days_since_insert = floor((strtotime($current_date) - strtotime($take_out_date)) / (60 * 60 * 24));
                $get_chiken_avarible = $amount - $bch_total_dai;
                    if($days_since_insert < 2){
                        $chek_vaccines = '<span class="status pending">រងចាំ</span>';
                    }else{
                        if($days_since_insert >1 && $days_since_insert <= 8){
                            if($vaccines_one != ''){
                        $chek_vaccines = '<span class="status delivered">ញូកាស</span>';
                            }else{
                                $chek_vaccines = '<span class="status return">ថ្ងៃចាក់វ៉ាក់សាំញូកាស</span>';
                            }
                            }elseif($days_since_insert >= 9 && $days_since_insert <= 15){
                                if($vaccines_two != ''){
                                    $chek_vaccines = '<span class="status delivered">កុំប៉ូរ៉ូ</span>';
                                }else{
                                    $chek_vaccines = '<span class="status return">ថ្ងៃចាក់វ៉ាក់សាំកុំប៉ូរ៉ូ</span>';
                                }
                               }elseif($days_since_insert >= 16 && $days_since_insert <= 20){
                                    if($vaccines_three != ''){
                                        $chek_vaccines = '<span class="status delivered">អ៊ុត</span>';
                                    }else{
                                        $chek_vaccines = '<span class="status return">ថ្ងៃចាក់វ៉ាក់សាំ​អ៊ុត</span>';
                                    }
                                    }elseif($days_since_insert >= 21 && $days_since_insert <= 24){
                                       if($reminder !=''){
                                           $chek_vaccines = '<span class="status delivered">រំលឹករួច</span>';
                                        }else{
                                                $chek_vaccines = '<span class="status delivered">រំលឹក</span>';
                                            }
                                    }elseif($days_since_insert >= 25 && $days_since_insert <= 29){
                                        $chek_vaccines = '<span class="status delivered"><a href="#">ពិនិត្យមើល</a></span>';
                                    }elseif ($days_since_insert == 30) {
                                            $insert_chiken = "INSERT INTO chiken (chiken_barcode, chiken_qty, chiken_date)
                                            VALUES (?, ?, ?)";
                                            $stmt = mysqli_prepare($conn, $insert_chiken);
                                            if ($stmt) {
                                                if (mysqli_stmt_bind_param($stmt, "sss", $bar_code_id, $get_chiken_avarible, $current_date)) {
                                                    if (mysqli_stmt_execute($stmt)) {
                                                        $update_bch_data = "UPDATE b_chiken SET Status = 1 WHERE Ch_barcode=?";
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
                                                        $update_bch_data = "UPDATE bch_dai SET Status_dia = 1 WHERE Ch_barcode=?";
                                                        $stmt_update_bch_dai = mysqli_prepare($conn, $update_bch_data);
                                                        if ($stmt_update_bch_dai) {
                                                            mysqli_stmt_bind_param($stmt_update_bch_dai, "s", $bar_code_id);
                                                            if (mysqli_stmt_execute($stmt_update_bch_dai)) {
                                                            } else {
                                                                echo "Error updating bch_dai data: " . mysqli_error($conn);
                                                            }
                                                        } else {
                                                            echo "Error preparing bch_dai update statement: " . mysqli_error($conn);
                                                        }
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
                    }
                                   echo '<div class="data_row">
                                        <h5>'.date('d-m-Y', strtotime($take_out_date)).'</h5>
                                        <h5>'.$bar_code_id.'</h5>
                                        <h5>'
                                        .(($days_since_insert != 0) ? $days_since_insert." <span style='color:green;'>​​ថ្ងៃ</span>" : 
                                        '<span style="color: green;">ថ្ងៃនេះ</span>').
                                        '</h5>
                                        <h5>'.($amount - $bch_total_dai).'</h5>
                                        <h5>'.$chek_vaccines.'</h5>
                                        <h5>shfhsf</h5>
                                    </div>';
            }
                                //check if there has no data 
                                if($checkdata === 0){
                                    echo '
                                    <div class="data_row">
                                     <h5>គ្មាទិន្ន័យ</h5>
                                    </div>
                                    ';
                                }
                            }else {
                                // Error handling
                                echo "Error: " . mysqli_error($conn);
                            }
?>