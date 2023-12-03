<?php
include "js_request/db_connection.php";
$born_bar_code_id = $_POST['born_bar_code_id'];
$born_date_record = $_POST['born_date_record'];
$total_born_amount = $_POST['total_born_amount'];
$process_status = "off";
$born_active = "active";
if($total_born_amount === ''){
    $response_pr['message_pr_re'] = 'សូមបញ្ចូលចំនួនញាស់';
}else{
    // Barcode doesn't exist, insert the data into the table
    $update_born_data = "UPDATE `store_chicken_born_process`
    SET  chicken_born_id='$born_bar_code_id', chicken_born_total='$total_born_amount',
        chicken_date_born='$born_date_record', born_status='$born_active'
    WHERE chicken_in_side_box_id ='$born_bar_code_id'";
    if (mysqli_query($conn, $update_born_data)) {
        $response_pr['message_pr_re'] = 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ';
        $update_process_off = "UPDATE `store_chicken_born_process`
        SET chicken_box_status='$process_status' WHERE chicken_in_side_box_id ='$born_bar_code_id'";
        mysqli_query($conn, $update_process_off);
        $insert_data_to_bch = "INSERT 
        INTO b_chiken
            (Ch_barcode, Take_out_date, Qty, Status) 
        VALUES ('$born_bar_code_id', '$born_date_record','$total_born_amount', 'active')";
        mysqli_query($conn, $insert_data_to_bch);
    } else {
        $response_pr['message_pr_re'] = 'មានបញ្ចាសូមពិនត្រមើលទិន្ន័យហើយសាកល្បងម្ដងទៀត!';
    }
}


// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response_pr);

// Close the database connection
mysqli_close($conn);
?>