<?php
include "js_request/db_connection.php";
$dai_date_record = $_POST['dai_date_record'];
$dai_bar_code_id = $_POST['dai_bar_code_id'];
$total_dai_amount = $_POST['total_dai_amount'];
$chicken_type = $_POST['chiken_type'];
$status_dia = "active";
if($total_dai_amount === ''){
    $response_message['message'] = 'សូមបញ្ចូលចំនួនងាប់';
}else{
        $insert_data_to_chicken_dai = "INSERT 
        INTO bch_dai
            (Ch_barcode, Amount_dai, chicken_type, Dia_date, Status_dia) 
        VALUES ('$dai_bar_code_id', '$total_dai_amount','$chicken_type', '$dai_date_record', '$status_dia')";
        if(mysqli_query($conn, $insert_data_to_chicken_dai)){
            $response_message['message'] = 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ';
        }else{
            $response_message['message'] = 'Error:'.mysqli_error($conn);
        }
}
// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response_message);
// Close the database connection
mysqli_close($conn);
?>