<?php
include "js_request/db_connection.php";
$chicken_type = $_POST['chiken_type'];
$sold_barcode = $_POST['sold_bar_code_id'];
$sold_date = $_POST['sold_date_record'];
$sold_amount = $_POST['chicken_sold_amount'];
$sold_add = $_POST['chicken_sold_add'];
$sold_price = $_POST['chicken_sold_price'];
$sold_note = $_POST['note'];
$cmr_name = $_POST['cmr_name'];
$cmr_place_ad = $_POST['cmr_place_ad'];
$cmr_con_ad = $_POST['cmr_con_ad'];
$weight_amount = $_POST['weight_amount'];
$req_message = [];
$b_ch_sold_status = "active";
$chicken_last_b_ch_sold_amount = 0;
if($chicken_type !=''){
    if($chicken_type === 'chicken'){
        $get_last_b_ch_sold_data = ("SELECT 
        chike_sold_qty, chiken_status, chiken_barcode
        FROM chiken WHERE chiken_barcode='$sold_barcode' And chiken_status='active' 
        ");
        if($get_last_b_ch_sold_data_view = mysqli_query($conn, $get_last_b_ch_sold_data)){
            while($row = mysqli_fetch_assoc($get_last_b_ch_sold_data_view)){
                $chicken_last_b_ch_sold_amount += ($row['chike_sold_qty']!=0)?$row['chike_sold_qty']:0;
            }
        }
        $insert_chicken_sold = ("INSERT INTO chiken_sold
        (
        `ch_sold_barcode`, 
        `ch_sold_date`, 
        `ch_qty_amount`, 
        `weight_amount`, 
        `chicken_sold_add`, 
        `ch_price`, 
        `cmr_name`, 
        `cmr_address`, 
        `cmr_contact_address`, 
        `ch_sell_note`, 
        `chicken_status`
        )
        Values (
            '$sold_barcode', 
            '$sold_date', 
            '$sold_amount', 
            '$weight_amount',
            '$sold_add', 
            '$sold_price', 
            '$cmr_name',
            '$cmr_place_ad',
            '$cmr_con_ad',
            '$sold_note',
            '$b_ch_sold_status'
            )
        ");
        if($insert_chicken_sold = mysqli_query($conn, $insert_chicken_sold)){
            $req_message['message'] = "ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ";
            $b_ch_last_sold_amount = ($chicken_last_b_ch_sold_amount!=0)?
            $chicken_last_b_ch_sold_amount + (intval($sold_add)+ intval($sold_amount)): (intval($sold_add) + intval($sold_amount));
            $let_update_new_b_ch_sold = ("UPDATE chiken 
            set chike_sold_qty= $b_ch_last_sold_amount, chiken_sold='active', chike_sold_barcode='$sold_barcode'
            WHERE chiken_barcode='$sold_barcode' AND chiken_status='active'");
            mysqli_query($conn,$let_update_new_b_ch_sold);
            
        }else{
            $req_message['message']="មានបញ្ហា:".mysqli_error($conn);
        }
    }if($chicken_type === 'b_chicken'){
        $get_last_b_ch_sold_data = ("SELECT 
        Sold, Sold_qty, Status, Ch_barcode
        FROM  b_chiken WHERE Ch_barcode='$sold_barcode' And Status='active' 
        ");
        if($get_last_b_ch_sold_data_view = mysqli_query($conn, $get_last_b_ch_sold_data)){
            while($row = mysqli_fetch_assoc($get_last_b_ch_sold_data_view)){
                $chicken_last_b_ch_sold_amount += ($row['Sold_qty']!=0)?$row['Sold_qty']:0;
            }
        }
        $insert_b_chicken_sold = ("INSERT INTO b_ch_sold
        (
            b_ch_sold_barcode, 
            b_ch_sold_date, 
            b_ch_sold_amount, 
            b_ch_price, 
            b_ch_add, 
            b_ch_cmr_name, 
            b_ch_cmr_ad, 
            b_ch_cmr_con_ad, 
            b_ch_note, 
            b_ch_sold_stuts
        )
        Values (
            '$sold_barcode', 
            '$sold_date', 
            '$sold_amount', 
            '$sold_price', 
            '$sold_add', 
            '$cmr_name',
            '$cmr_place_ad',
            '$cmr_con_ad',
            '$sold_note',
            '$b_ch_sold_status'
            )
        ");
        if($insert_b_chicken_sold = mysqli_query($conn, $insert_b_chicken_sold)){
            $req_message['message'] = "ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ";
            $b_ch_last_sold_amount = ($chicken_last_b_ch_sold_amount!=0)?
            $chicken_last_b_ch_sold_amount + (intval($sold_add)+ intval($sold_amount)): (intval($sold_add) + intval($sold_amount));
            $let_update_new_b_ch_sold = ("UPDATE b_chiken 
            set 
            Sold_qty= $b_ch_last_sold_amount, 
            Sold='active', 
            Sold_ch_barcode='$sold_barcode',
            Sold_date='$sold_date'
            WHERE Ch_barcode='$sold_barcode' AND Status='active'");
            mysqli_query($conn,$let_update_new_b_ch_sold);
        }else{
            $req_message['message']="មានបញ្ហា:".mysqli_error($conn);
        }
    }  
}else{
    $req_message['message'] = "សូមធ្វើការជ្រើរើសលេខសម្គាល់មាន់!";
}
// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($req_message);
// Close the database connection
mysqli_close($conn);
?>