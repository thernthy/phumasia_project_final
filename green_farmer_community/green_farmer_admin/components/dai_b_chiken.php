<div class="dai_chiken_contianer">
  <div class="showing_table">
  </div>
    <table width="100%" cellspacing="0px" style="text-align:center;">
        <thead style="padding: 10px; background-color:green; color:white;">
            <tr style="font-weight:800; font-size:1rem;">
                <td><h5>លេខកូដមាន់</h5></td> 
                <td><h5>កាលបរិច្ឆេទ</h5></td> 
                <td><h5>ប្រភេទមាន់</h5></td> 
                <td><h5>ចំនួនសរុប</h5></td> 
            </tr>
        </thead> 
        <tbody> 
        <?php 
            $get_dai_b_ch = "SELECT SUM(Amount_dai) AS totaledia, Ch_barcode, Dia_date, chicken_type		
            FROM bch_dai WHERE Ch_barcode!='' ";
           if(isset($_POST['fine_barcode'])){
                $bar_code_fine = $_POST['barcode'];
                $start_date_fine = $_POST['starting_date'];
                $ending_date_fine = $_POST['ending_date'];
                    if($start_date_fine != '' && $ending_date_fine != ''){
                        $get_dai_b_ch .= " AND Dia_date BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                    } elseif($start_date_fine != ''){
                        $get_dai_b_ch .= " AND Dia_date = '$start_date_fine'";
                    } elseif($ending_date_fine != ''){
                        $get_dai_b_ch .= " AND Dia_date = '$ending_date_fine'";
                    }
                    if($bar_code_fine != 'all'){
                        $get_dai_b_ch .= " AND Ch_barcode = '$bar_code_fine'";
                    } else{
                        $get_dai_b_ch .= " AND Ch_barcode!=''";
                    }
            }
            $get_dai_b_ch .=" GROUP BY chicken_type, Ch_barcode ORDER BY Dia_date DESC";
            $view_dai_data = mysqli_query($conn, $get_dai_b_ch);
            $check_data = 0;
            if(!$view_dai_data){
                echo"Error:".mysqli_error($conn);
            }else{
                while($row = mysqli_fetch_assoc($view_dai_data)){
                    $dia_b_ch_code = $row['Ch_barcode'];
                    $dia_date = $row['Dia_date'];
                    $chicken_type = $row['chicken_type'];
                    $dia_total = $row['totaledia'];
                    echo ' 
                    <tr style="height:40px;">     
                        <td><h6>'.$dia_b_ch_code.'</h6></td>
                        <td><h6>'.Date('d-F-Y', strtotime($dia_date)).'</h6></td>
                        <td><h6>'.(($chicken_type==='b_chicken')?'កូនមាន់':'មាន់សាច់').'</h6></td>
                        <td><h6>'.$dia_total.'​​ ក្បាល</h6></td>
                    </tr>';
                    $check_data ++;
                }
                if($check_data === 0){
                    echo ' 
                    <div class="showing_data">      
                        <h2 style="color:red;">មិនមានទិន្នន័យទេ!</h2>
                    </div>';
                }
            }
        ?>
        </tbody>
    </table>
</div>