<div class="dai_chiken_contianer">
  <div class="showing_table">
        <div class="table_header">
            <h5>លេខកូដមាន់</h5>
        </div>
        <div class="table_header">
            <h5>កាលបរិច្ឆេទញាស់</h5>
        </div>
        <div class="table_header">
            <h5>ចំនួនសរុប</h5>
        </div>
  </div>
        <?php 
            $get_dai_b_ch = "SELECT SUM(Amount_dai) AS totaledia, Ch_barcode, 	Dia_date		
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
            $get_dai_b_ch .=" GROUP BY Ch_barcode";
            $view_dai_data = mysqli_query($conn, $get_dai_b_ch);
            $check_data = 0;
            if(!$view_dai_data){
                echo"Error:".mysqli_error($conn);
            }else{
                while($row = mysqli_fetch_assoc($view_dai_data)){
                    $dia_b_ch_code = $row['Ch_barcode'];
                    $dia_date = $row['Dia_date'];
                    $dia_total = $row['totaledia'];
                    echo ' 
                    <div class="showing_data">      
                    <h6>'.$dia_b_ch_code.'</h6>
                    <h6>'.Date('d-F-Y', strtotime($dia_date)).'</h6>
                    <h6>'.$dia_total.'​​ ក្បាល</h6>
                    </div>';
                    $check_data ++;
                }
                if($check_data === 0){
                    echo ' 
                    <div class="showing_data">      
                        <h2 style="color:red;">មិនមានទិន្ន័យ</h2>
                    </div>';
                }
            }
        ?>
</div>