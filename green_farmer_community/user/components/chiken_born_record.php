<?php include"routing/js_request/db_connection.php" ?>
<div class="egg_record_con">
    <div class="conten_decr">
        <h2>កត់ត្រាមាន់ញាស់</h2>
        <p>សូមវាយបញ្ចូលជាភាសាអង់គ្លេស និង​ លេខសកល លេខត្រូវតែវិជ្ជមានជានិច្ច</p>
    </div>
    <form id="chicken_born">
    <div class="row mb-4 mt-4">
        <div class="col">
            <input type="date" class="form-control" id="egg_data_record" name="born_date_record" placeholder="Select date" aria-label="date">
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <label for="bar_code_id" class="col-sm-4 col-form-label">ជ្រើសរើសមាន់</label>
        <div class="col">
            <select class="form-select" aria-label="Default select example" name="born_bar_code_id">
                <?php 
                  $get_bar_code_id = ("SELECT 
                   chicken_in_side_box_id,
                   	chicken_box_status,
                   date_in_side_box
                  FROM store_chicken_born_process 
                  WHERE chicken_in_side_box_id!='' AND 	chicken_box_status='active' ORDER BY date_in_side_box ASC");
                  $get_bar_code_id_row = mysqli_query($conn, $get_bar_code_id);
                  if(!$get_bar_code_id_row){
                    echo"Erorr: ".mysqli_error($conn); 
                  }else{
                    while($view_bar_code_row = mysqli_fetch_assoc($get_bar_code_id_row)){
                        $bar_code_id_data = $view_bar_code_row['chicken_in_side_box_id'];
                        echo'
                            <option value="'.$bar_code_id_data.'">'.$bar_code_id_data.'</option>
                        ';
                    }
                  }
                ?>

            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" name="total_born_amount" placeholder="ចំនួនញាស់" aria-label="total_egg" required>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button type="submit" class="btn btn-success">បញ្ចូល</button>
        </div>
    </div>
</form>
</div>
<script>
document.getElementById('chicken_born').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://phumasia.com/green_farmer_community/user/routing/get_chiken_born_record_req.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const $response_pr = JSON.parse(xhr.responseText);
            const message_pr_re = $response_pr.message_pr_re;
            alert(message_pr_re); // Display the response message_pr_re
            if (message_pr_re === 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ') {
                location.reload(); // Refresh the page if the data was inserted successfully
            }
        }
    };
    xhr.send(formData);
});
</script>