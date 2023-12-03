<?php
include "js_request/db_connection.php";
$vaccine = $_POST['vaccines_select'];
$vaccine_barcode = (!$_POST['tak_vaccin_barcode'])?'':$_POST['tak_vaccin_barcode'];
$rep_message['message'] = '';
$check_vaccin = ("SELECT Ch_barcode, Vaccines1, Vaccines2, Vaccines3, Reminder, Status 
FROM b_chiken WHERE Status='active' AND Ch_barcode='$vaccine_barcode'");
if($get_vaccin = mysqli_query($conn, $check_vaccin)){
    while($vaccine_row = mysqli_fetch_assoc($get_vaccin)){
        $vaccin_one = ($vaccine_row['Vaccines1']!='')?$vaccine_row['Vaccines1']:'';
        $vaccin_two = ($vaccine_row['Vaccines2']!='')?$vaccine_row['Vaccines2']:'';
        $vaccin_three = ($vaccine_row['Vaccines3']!='')?$vaccine_row['Vaccines3']:'';
        $reminder = ($vaccine_row['Reminder']!='')?$vaccine_row['Reminder']:'';
    }
}else{
    echo"error:".mysqli_error($conn);
}
if (isset($_POST['reminder'])) {
    if($reminder!=''){
        $rep_message['message'] = "រំលឹករួចរាល់ហើយ!";
    }else{
       $let_set_reminder_data  = ("UPDATE b_chiken SET Reminder='$vaccine' 
       WHERE Ch_barcode='$vaccine_barcode' AND Status='active'");
       (mysqli_query($conn, $let_set_reminder_data))?
       $rep_message['message']="ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ":
       $rep_message['message']="មានបញ្ហា " .mysqli_error($conn);
    }

}else{
   if($vaccine_barcode!=''){
        if($vaccine === $vaccin_one){
            $rep_message['message'] = "វ៉ាក់សាំងញូកាសមានហើយ!";
        }elseif($vaccine === $vaccin_two){
            $rep_message['message'] = "វ៉ាក់សាំងកុំប៉ូរ៉ូមានហើយ!";
        }elseif($vaccine === $vaccin_three){
            $rep_message['message'] = "វ៉ាក់សាំងកុំប៉ូរ៉ូមានហើយ!";
        }else{
            if($vaccine ==="vaccin1"){
                $update_vaccin = ("UPDATE b_chiken SET Vaccines1='$vaccine' 
                WHERE Ch_barcode='$vaccine_barcode' AND Status='active'");
            }
            if($vaccine ==="vaccin2"){
                $update_vaccin = ("UPDATE b_chiken SET Vaccines2='$vaccine' 
                WHERE Ch_barcode='$vaccine_barcode' AND Status='active'");
            }
            if($vaccine ==="vaccin3"){
                $update_vaccin = ("UPDATE b_chiken SET Vaccines3='$vaccine' 
                WHERE Ch_barcode='$vaccine_barcode' AND Status='active'");
            }
            if(mysqli_query($conn, $update_vaccin)){
                $rep_message['message'] = "ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ";
            }else{
                $rep_message['message'] = "error:" .mysqli_error($conn);
            }
        }
   }else{
    $rep_message['message'] = "មិនមានលេខសម្គាល់កូនមាន់!";
   }
}

header('Content-Type: application/json');
echo json_encode($rep_message);
// Close the database connection
mysqli_close($conn);
?>