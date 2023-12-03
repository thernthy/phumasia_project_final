<?php
include "js_request/db_connection.php";
$process_data = $_POST['process_data_record'];
$total_process_amount = $_POST['total_process_amount'];
$bar_code_id = $_POST['bar_code_id'];
$process_status = "active";
// Check if the barcode already exists in the table
$check_query = "SELECT chicken_in_side_box_id FROM store_chicken_born_process WHERE chicken_in_side_box_id = '$bar_code_id'";
$result = mysqli_query($conn, $check_query);
$response_pr = array();

if (mysqli_num_rows($result) > 0) {
    // Barcode already exists
    $response_pr['message_pr_re'] = 'លេខសម្គាល់មានហើយ សូមបញ្ចូលលេខសម្គាល់ម្ដងទៀត!';
} else {
    // Barcode doesn't exist, insert the data into the table
    $insert_query = "INSERT INTO store_chicken_born_process (chicken_in_side_box_id, date_in_side_box, chicken_box_status, chicken_in_box_total) 
                     VALUES ('$bar_code_id', '$process_data', '$process_status', '$total_process_amount')";
    if (mysqli_query($conn, $insert_query)) {
        $response_pr['message_pr_re'] = 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ';
    } else {
        $response_pr['message_pr_re'] = 'មានបញ្ចាសូមពិនត្យមើលទិន្ន័យហើយសាកល្បងម្ដងទៀត!';
    }
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response_pr);

// Close the database connection
mysqli_close($conn);
?>


