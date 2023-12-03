<?php
//get chiken egg that shas in put to machin 
$get_ch_in_side_box = ("SELECT `chicken_in_side_box_id`, `date_in_side_box`, `chicken_box_status`, `chicken_in_box_total`
FROM store_chicken_born_process WHERE chicken_box_status ='Active' ");
    if(isset($_POST['fine_barcode'])){
            $bar_code_fine = $_POST['barcode'];
            $start_date_fine = $_POST['starting_date'];
            $ending_date_fine = $_POST['ending_date'];
        if($start_date_fine != '' && $ending_date_fine != ''){
            $get_ch_in_side_box .= " AND date_in_side_box BETWEEN '$start_date_fine' AND '$ending_date_fine'";
        } elseif($start_date_fine != ''){
            $get_ch_in_side_box .= " AND date_in_side_box = '$start_date_fine'";
        } elseif($ending_date_fine != ''){
            $get_ch_in_side_box .= " AND date_in_side_box = '$ending_date_fine'";
        }
    }
    $get_ch_in_side_box .=" ORDER BY MONTH(date_in_side_box) DESC";

//get that of ever data record egg form database 
         $check_alert_egg_button = 0;
         $check_egg_data = 0;
         $check_total_good_egg=0;
         $check_total_broken_egg=0;
         $totale_egg_rocord = 0;
         $get_take_egg_out = ("SELECT SUM(chicken_in_box_total) AS total_take_out, date_in_side_box
         FROM store_chicken_born_process WHERE id!=0");
         $get_egg_rocord_data = ("SELECT `date_and_record`, `broke_egg`, `good_egg` FROM `record_egg` WHERE id!=0");
         if(isset($_POST['fine_barcode'])){
             $bar_code_fine = $_POST['barcode'];
             $start_date_fine = $_POST['starting_date'];
             $ending_date_fine = $_POST['ending_date'];
            if($start_date_fine != '' && $ending_date_fine != ''){
                 $get_egg_rocord_data .= " AND date_and_record BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                 $get_take_egg_out .=" AND date_in_side_box BETWEEN '$start_date_fine' AND '$ending_date_fine'";
            } elseif($start_date_fine != ''){
                    $get_egg_rocord_data .= " AND date_and_record = '$start_date_fine'";
                    $get_take_egg_out .=" AND date_in_side_box = '$start_date_fine'";
             } elseif($ending_date_fine != ''){
                 $get_egg_rocord_data .= " AND date_and_record = '$ending_date_fine'";
                 $get_take_egg_out .=" AND date_in_side_box = '$start_date_fine'";
             }
         }
         $get_egg_rocord_data .=" ORDER BY MONTH(date_and_record) DESC";
         $view_egg_record = mysqli_query($conn, $get_egg_rocord_data);
         $view_take_egg_out = mysqli_query($conn, $get_take_egg_out);
         //get take out egg 
            if(!$view_take_egg_out){
                    echo"Error:".mysqli_error($conn);
            }else{
                $view_take_egg_out_data = mysqli_fetch_assoc($view_take_egg_out);
                $total_take_out = $view_take_egg_out_data['total_take_out'];
            }
         if(!$view_egg_record){
             echo '
             <tr>
             <td colspan="3" style="text-align:center;">'.mysqli_error($conn).'</td>
             </tr>
             ';
         }else{
            //$get_total_egg = mysqli_fetch_assoc($view_egg_record);
           // echo $get_total_egg['good_egg'];
             while($count_record_data = mysqli_fetch_assoc($view_egg_record)){
                 $egg_record_date = date('d-m-Y', strtotime($count_record_data['date_and_record']));
                 $totale_egg_rocord += $count_record_data['good_egg'];
                 $check_alert_egg_button++;
             }
             $total_egg_av = (!$total_take_out)? $totale_egg_rocord:($totale_egg_rocord - $total_take_out);
        }
///get chiken born data from database 
$check_alert_born_button = 0;
$ch_total_born_amount = 0;
$ch_check_born_data = 0;
    $get_born_ch_data = ("SELECT 
    chicken_in_box_total,
    `chicken_born_id`, 
    `chicken_born_total`,
    `chicken_date_born`, 
    `born_status`
    FROM store_chicken_born_process
    WHERE born_status = 'Active'
    ");
    if(isset($_POST['fine_barcode'])){
                $bar_code_fine = $_POST['barcode'];
                $start_date_fine = $_POST['starting_date'];
                $ending_date_fine = $_POST['ending_date'];
                if($start_date_fine != '' && $ending_date_fine != ''){
                    $get_born_ch_data .= " AND chicken_date_born BETWEEN '$start_date_fine' AND '$ending_date_fine'";
                } elseif($start_date_fine != ''){
                    $get_born_ch_data .= " AND chicken_date_born = '$start_date_fine'";
                } elseif($ending_date_fine != ''){
                    $get_born_ch_data .= " AND chicken_date_born = '$ending_date_fine'";
                }
                if($bar_code_fine != 'all'){
                    $get_born_ch_data .= " AND chicken_born_id = '$bar_code_fine'";
                } else{
                    $get_born_ch_data .= " AND chicken_born_id!=''";
                }
    } 
        $get_born_ch_data .= " ORDER BY MONTH(chicken_date_born) DESC";
        $total_born_amount = 0;
        $view_born_ch_data = mysqli_query($conn, $get_born_ch_data);
        while($cound_born_data = mysqli_fetch_assoc($view_born_ch_data)){
                $get_born_id_code = $cound_born_data['chicken_date_born'];
                $total_born_amount += $cound_born_data['chicken_born_total'];
                $check_alert_born_button++;
        }
?>
<div class="check_egg_container">
        <div class="cardHeader" style="margin: 20px;">
            <h2>ពិនិត្យមើល</h2>
            <button class="btn" style="margin:10px;" id="merl_egg" onclick="view_egg_content()">ការកត់ត្រាពង់មាន 
            <?php echo '<span id="has_egg_record_data" style="
                color:red;
                font-weight:800;
            ">'.$check_alert_egg_button.'</span>' ?>
            </button>
            <button class="btn" style="margin:10px;" id="merl_burn" onclick="view_burn_content()">ការញាស់
                <?php echo '<span id="has_egg_record_data" style="
                    color:red;
                    font-weight:800;
                ">'.$check_alert_born_button.'</span>' 
                ?>
            </button>
       </div>
    <div class="egg" id="avarible_agg">
     <b style="z-index:20;" id="egg_data"><?php echo (!$total_egg_av)?0:$total_egg_av?></b>
    </div>
    <div class="egg" id="egg_take_out">
        <button class="view_data_btn"><p id="take_out_data"><?php echo(!$total_born_amount)?0:$total_born_amount ?></p> ក្បល</button>
    </div>
</div>
<div class="check_egg_container_view_data">
    <div class="data_view">
       <div  class="view_in_box_content view_in_box_content_active" id="in_box_chicken">
        <table style="
        padding:20px;
        box-shadow:1px
        0px 10px rgba(0,0,0,.120);
        border-radius:10px;
        "cellspacing="20px">
        <thead style="padding:20px; border-radius: 10px;">
            <tr>
                <td colspan="4" style="
                text-align:center; 
                background-color:blue; 
                padding:15px;
                border-radius:10px; 
                ">
                <h3>មាន់ដែលបានដាក់ភ្ញាស</h3</td>
            </tr>
            <tr style="text-align:center; font-weight: 800;">
                <td>ថ្ងៃដាក់ចូរទូរ</td>
                <td>លេខសម្គាល់</td>
                <td>ចំនួន ដាក់ក្នុងទូរ</td>
                <td>ចំនួន ថ្ងៃដកចេញ</td>
            </tr>
        </thead>
        <tbody >
            <?php
                $ch_in_box_check = 0;
                $view_ch_in_side_box = mysqli_query($conn, $get_ch_in_side_box);
                if(!$view_ch_in_side_box){
                    echo'
                    <tr><td colspan="4">'.mysqli_error($conn).'</td></tr>
                    ';
                }else{
                    while($row = mysqli_fetch_assoc($view_ch_in_side_box)){
                        $ch_in_box_date = date('d-F-Y', strtotime($row['date_in_side_box']));
                        $chicken_in_side_box_id = $row['chicken_in_side_box_id'];
                        $chicken_in_box_total = $row['chicken_in_box_total'];
                        $fine_date_to_take_out  = new DateTime(date('d-m-Y', strtotime($ch_in_box_date)));
                        $current_date = date('Y-m-d');
                        $days_since_in_box = floor((strtotime($current_date) - strtotime($ch_in_box_date)) / (60 * 60 * 24));
                        $date_line_color_cofige = '';
                        if($days_since_in_box >= 18 && $days_since_in_box <=20){
                            $date_line_color_cofige = "yellow";
                        }if($days_since_in_box >=21){
                            $date_line_color_cofige = "red";
                            $update_ch_in_box_data = "UPDATE store_chicken_born_process
                             SET chicken_box_status = 'off'
                             WHERE chicken_in_side_box_id=?";
                            $stmt_update_ch_in_box = mysqli_prepare($conn, $update_ch_in_box_data);
                                if ($stmt_update_ch_in_box) {
                                    mysqli_stmt_bind_param($stmt_update_ch_in_box, "s", $chicken_in_side_box_id);
                                if (mysqli_stmt_execute($stmt_update_ch_in_box)) {

                                    } else {
                                        echo "Error updating b_chiken data: " . mysqli_error($conn);
                                    }
                                    } else {
                                         echo "Error preparing b_chiken update statement: " . mysqli_error($conn);
                                    }
                        }
                        echo'
                        <tr style="text-align:center">
                            <td>'.$ch_in_box_date.'</td>
                            <td>'.$chicken_in_side_box_id.'</td>
                            <td>'.$chicken_in_box_total.'<span style="color:green;"> ក្បាល</span></td>
                            <td style="color:'.$date_line_color_cofige.';">'.(($fine_date_to_take_out->modify('+21 days')->Format('d/m/Y'))).'</td>
                        </tr>
                        
                        ';
                        $ch_in_box_check++;
                    }
                //if thre has not data it will showing here
                    if($ch_in_box_check ===0){
                        echo'
                        <tr style="text-align:center;"><td colspan="4" style="padding:20px 0; color:white; background-color:red;">មិនមានការដាក់ចូរទូរទេ!</td></tr>
                    ';
                    }
                }
            ?>
        </tbody>
        </table>
        </div>
<!--======== showing ever day record of chiken eggg  ==---------->
        <div class="content_data" id="content_egg">
            <table style="
            padding:20px;
            box-shadow:1px
            0px 10px rgba(0,0,0,.120);
            border-radius:10px;
            "cellspacing="20px">
            <thead style="padding:20px; border-radius: 10px;">
                <tr>
                    <td colspan="4" style="
                    text-align:center; 
                    background-color:blue; 
                    padding:15px;
                    border-radius:10px; 
                    ">
                    <h3>ត្រួតពិនិត្យពងមាន់</h3</td>
                </tr>
                <tr style="text-align:center; font-weight: 800;">
                    <td>កាលបរិច្ឆេទ</td>
                    <td>ពងមាន់បែក</td>
                    <td>ពង់មាន់ល្អ</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $view_egg_record = mysqli_query($conn, $get_egg_rocord_data);
                    if(!$view_egg_record){
                        echo '
                        <tr>
                        <td colspan="3" style="text-align:center;">'.mysqli_error($conn).'</td>
                        </tr>
                        ';
                    }else{
                        while($view_egg_data_row = mysqli_fetch_assoc($view_egg_record)){
                            $egg_record_date = date('d-m-Y', strtotime($view_egg_data_row['date_and_record']));
                            $broken_egg = $view_egg_data_row['broke_egg'];
                            $good_egg = $view_egg_data_row['good_egg'];
                            $check_total_good_egg += $good_egg;
                            $check_total_broken_egg += $broken_egg;
                            echo'
                            <tr style="text-align:center;">
                              <td>'.$egg_record_date.'</td>
                              <td>'.$broken_egg.'</td>
                              <td>'.$good_egg.'</td>
                            </tr>
                            ';
                            $check_egg_data++;
                        }
                    }
                    echo ''.($check_egg_data!=0)?"":
                    "<tr>
                    <td colspan='3' style='text-align:center; color:red;'>មិនមានទិន្ន័យទេ!</td>
                    </tr>"
                    .''
                ?>
              <tr>
                <td style="text-align:center; color:green;">ចំនួន កូនមាន់សរុប</td>
                <td  style="text-align:center;"><?php echo $check_total_broken_egg?></td>
                <td  style="text-align:center;"><?php echo $check_total_good_egg?></td>
              </tr>
            </tbody>
            </table>
        </div>

<!--======== showing chiken that has born  ==---------->
        <div class="content_data" id="content_burn">
        <table style="
            padding:20px;
            box-shadow:1px
            0px 10px rgba(0,0,0,.120);
            border-radius:10px;
            "cellspacing="20px">
            <thead style="padding:20px; border-radius: 10px;">
                <tr>
                    <td colspan="6" style="
                    text-align:center; 
                    background-color:blue; 
                    padding:15px;
                    border-radius:10px; 
                    ">
                    <h3>ត្រួតពិនិត្យពងមាន់</h3</td>
                </tr>
                <tr style="text-align:center; font-weight: 800;">
                    <td rowspan="2">លេខ សម្គាល់</td>
                    <td rowspan="2">ចំនួនដាក់ភ្ញាស់</td>
                    <td colspan="2">ចំនួនញាស់</td>
                    <td rowspan="2">ពងចេញពីទូរ</td>
                    <td rowspan="2">ថ្ងៃខែញាស់</td>
                </tr>
                <tr>
                    <td >ចំនួនញាស់</td>
                    <td>អត្រាញាស់</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $view_born_ch_data = mysqli_query($conn, $get_born_ch_data);
                    if(!$view_born_ch_data){
                        echo'
                          <tr style="height:50px; background-color:red; color:white;"><td colspan="6" style="text-align:center;">'.mysqli_error($conn).'</td></tr>
                        ';
                    }else{
                        while($view_data_row = mysqli_fetch_assoc($view_born_ch_data)){
                                $get_born_id_code = $view_data_row['chicken_born_id'];
                                $chicken_in_box_total_con = $view_data_row['chicken_in_box_total'];
                                $chicken_born_total = $view_data_row['chicken_born_total'];
                                $chicken_date_born = $view_data_row['chicken_date_born'];
                                $check_born_percentage = (($chicken_born_total!=0)?$chicken_born_total/$chicken_in_box_total_con*100:0);
                                $ch_total_born_amount += $chicken_born_total;
                                $ch_check_born_data ++;
                                $color_chage = '';
                                if($check_born_percentage <=39){
                                    $color_chage ="red";
                                }if($check_born_percentage>=40 && $check_born_percentage <= 69){
                                    $color_chage = "yellow";
                                }elseif($check_born_percentage>=70){
                                    $color_chage = "green";
                                }
                                echo'
                                    <tr>
                                        <td>'.$get_born_id_code.'</td>
                                        <td>'.$chicken_in_box_total_con.'</td>
                                        <td>'.$chicken_born_total.'</td>
                                        <td>'.round($check_born_percentage, 2).'<span style="color:'.$color_chage.'"> %</span></td>
                                        <td></td>
                                        <td>'.$chicken_date_born.'</td>
                                        <td></td>
                                    </tr>
                                ';
                        }
                    }
                  echo ''.($ch_check_born_data!=0)?"" : "
                  <tr style='color:white; background-color:red; heigth:50px;'>
                  <td colspan='6' style='text-align:center;'>មិនមានការញាស់!</td>
                  </tr>".'';
                ?>
                <tr style="height:50px; background-color:yellow;">
                    <td colspan="3" style="text-align:center;">ចំនួន កូនមាន់សរុប</td>
                    <td colspan="3" style="text-align:center;"><?php echo ($ch_total_born_amount!=0)?$ch_total_born_amount ."<b style='color:green;'> ក្បាល</b>":'<span style="color:red;">0 ក្បាល</span>'?></td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    //egg color config
    const geteggAvirableData = document.getElementById('egg_data').innerText
    function eggAvirableConfigColor(eggAvirableData){
    const eggShape = document.getElementById('avarible_agg')
    if(eggAvirableData <= 49){
             eggShape.classList.add("smailess")
    }
    if(eggAvirableData => 50 && eggAvirableData <=99){
        eggShape.classList.add('lower')
        }if(eggAvirableData>=100 && eggAvirableData <= 249){
            eggShape.classList.add('mubim')
        }if(eggAvirableData>=250){
            eggShape.classList.add('full')
        }
        
    }
    let eggAvirableData = Number(geteggAvirableData)
    eggAvirableConfigColor(eggAvirableData)
    //egg in born machin color config
    const get_take_out_data =document.getElementById('take_out_data').innerText
    function take_out_tada_color_cofig(take_out_data){
        const take_out_shape =document.getElementById('egg_take_out')
        if(take_out_data <= 49){
            take_out_shape.classList.add("smailess")
        }
        if(take_out_data =>50 &&take_out_data <= 99){
            take_out_shape.classList.add('lower')
        }if(take_out_data >= 100 && take_out_data <= 249){
            take_out_shape.classList.add('mubim')
        }if(take_out_data >=250){
            take_out_shape.classList.add('full')
        }
    }
  let take_out_data = Number(get_take_out_data)
  console.log(take_out_data)
  take_out_tada_color_cofig(take_out_data)
</script>

