<?php 
include "routing/js_request/db_connection.php";

$let_get_vaccines_data = ("SELECT 
Ch_barcode, Vaccines1, Vaccines2, Vaccines3, Reminder, Status, Take_out_date
FROM b_chiken
WHERE Status='active' ORDER BY MONTH(Take_out_date) ASC 
");
if(!$get_vaccin_data = mysqli_query($conn, $let_get_vaccines_data)){
    echo"error: ".mysqli_error($conn);
}

?>
<div class="recentOrders">
    <div class="cardHeader">
        <h2>ពិនិត្យវ៉ាក់សាំង</h2>
    </div>
    <table>
        <thead>
            <tr style="font-size: 1rem;">
                <td>លេខ សម្គាល់</td>
                <td>ញូកាស</td>
                <td>កុំប៉ូរ៉ូ</td>
                <td>អ៊ុត</td>
                <td>រំលឹក</td>
            </tr>
        </thead>
        <tbody>
            <?php
             while($vaccin_data_row = mysqli_fetch_assoc($get_vaccin_data)){
                $corlor_con_fig = '';
                $b_ch_barcode_id = $vaccin_data_row['Ch_barcode'];
                $vaccin_one = $vaccin_data_row['Vaccines1'];
                $vaccin_two = $vaccin_data_row['Vaccines2'];
                $vaccin_three = $vaccin_data_row['Vaccines3'];
                $vaccin_reminder = $vaccin_data_row['Reminder'];
                $take_out_date  = $vaccin_data_row['Take_out_date'];
                $vaccin_reminder_disply = '';
                if($vaccin_reminder===$vaccin_one){
                    $vaccin_reminder_disply = "ញូកាស";
                }elseif($vaccin_reminder===$vaccin_two){
                    $vaccin_reminder_disply = "	កុំប៉ូរ៉ូ";
                }else{
                    $vaccin_reminder_disply = "	អ៊ុត";
                }
                $date_take_vaccin = new DateTime(date('d-m-Y', strtotime($take_out_date)));
               echo'
                <tr>
                 <td>'.$b_ch_barcode_id.'</td>
                 <td>
                 '.((!$vaccin_one)?"<span style='color:red;'>មិនទាន់ចាក់</span>":"<span style='color:green;'>បានចាក់ហើយ</span>").'
                 <br>
                 <span>'.(($date_take_vaccin->modify('+2 days')->Format('d/m/Y'))).'</span>
                 <td>'
                 .((!$vaccin_two)?"<span style='color:red;'>មិនទាន់ចាក់</span>":"<span style='color:green;'>បានចាក់ហើយ</span>").
                 '
                 <br>
                 <span>'.(($date_take_vaccin->modify('+7 days')->Format('d/m/Y'))).'</span>
                 <td>'
                 .((!$vaccin_three)?"<span style='color:red;'>មិនទាន់ចាក់</span>":"<span style='color:green;'>បានចាក់ហើយ</span>").'
                 <br>
                 <span>'.(($date_take_vaccin->modify('+7 days')->Format('d/m/Y'))).'</span>
                 </td>
                 <td>'.((!$vaccin_reminder)?"<span style='color:red;'>មិនទាន់រំលឹក</span>":"<span style='color:green;'>".$vaccin_reminder_disply."</span>").'</td>
                </tr>
               ';
             }
             
             ?>
        </tbody>
    </table>
</div>