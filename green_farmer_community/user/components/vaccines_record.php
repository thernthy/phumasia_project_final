<?php include"routing/js_request/db_connection.php" ?>
<div class="egg_record_con">
    <div class="conten_decr">
        <h2>ការចាក់វ៉ាក់សាំង</h2>
        <p>សូមវាយបញ្ចូលជាភាសាអង់គ្លេស និង​ លេខសកល លេខត្រូវតែវិជ្ជមានជានិច្ច</p>
    </div>
    <form id="take_vaccin">
    <div class="row mt-5 mb-4">
        <label for="tak_vaccin_barcode" class="col-sm-4 col-form-label">ជ្រើរើស​ លេខសម្គាល់</label>
        <div class="col">
            <select class="form-select"  id="tak_vaccin_barcode" name="tak_vaccin_barcode">
                <?php 
                 $get_b_chicken_id = ("SELECT 
                 Ch_barcode,
                 Vaccines1,
                 Vaccines2,
                 Vaccines3,
                 Reminder, 
                 Status FROM b_chiken WHERE Status='active'");
                 if($get_b_chicken_data_id = mysqli_query($conn, $get_b_chicken_id)){
                    while($id_row = mysqli_fetch_assoc($get_b_chicken_data_id)){
                        $done_vaccines = array();
                        $b_chicken_barcode_id = $id_row['Ch_barcode'];
                        $vanccin_one = $id_row['Vaccines1'];
                        $vanccin_two = $id_row['Vaccines2'];
                        $vanccin_three = $id_row['Vaccines3'];
                        $vanccin_reminder = ($id_row['Reminder'] != '') ? $id_row['Reminder'] : '';
                        
                        if ($vanccin_one != '' && $vanccin_two != '' && $vanccin_three != '' && $vanccin_reminder != '') {
                            continue;
                        }
                        
                        if ($vanccin_one != '') {
                            $done_vaccines[] = " ញូកាស";
                        }
                        
                        if ($vanccin_two != '') {
                            $done_vaccines[] = " កុំប៉ូរ៉ូ";
                        }
                        
                        if ($vanccin_three != '') {
                            $done_vaccines[] = " អ៊ុត";
                        }
                        
                        if ($vanccin_reminder != '') {
                            if ($vanccin_reminder == $vanccin_one) {
                                $done_vaccines[] = " ញូកាស(រំលឹក)";
                            }
                        
                            if ($vanccin_reminder == $vanccin_two) {
                                $done_vaccines[] = " កុំប៉ូរ៉ូ";
                            }
                        
                            if ($vanccin_reminder == $vanccin_three) {
                                $done_vaccines[] = " អ៊ុត";
                            }
                        }
                        
                        echo '
                        <option value="' . $b_chicken_barcode_id . '">'
                        . $b_chicken_barcode_id . '<span>';
                        
                        foreach ($done_vaccines as $vaccine) {
                            echo $vaccine;
                        }
                        
                        echo '</span>
                        </option>
                        ';
                        
                    }
                 }else{
                    echo"<option>Error:".mysqli_error($conn)."</option>";
                 }
                
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <label for="vaccines_select" class="col-sm-4 col-form-label">វ៉ាក់សាំង</label>
        <div class="col">
            <div class="row">
                <select class="form-select"  id="vaccines_select" name="vaccines_select">
                    <option value="vaccin1">ញូកាស</option>
                    <option value="vaccin2">កុំប៉ូរ៉ូ</option>
                    <option value="vaccin3">អ៊ុត</option>
                </select>
            </div>
            <div class="row mt-3 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="reminder" id="reminder" style="margin-left: 3rem; outline:1px solid green;">
                    <label class="btn form-check-label btn-success" for="reminder" style=" border-radius:10px; padding:5px 20px 0px 20px;">រំលឹក</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-4">
    <a href="?employe=processe=str=view=vaccines" class="col text-dark">ពិនិត្យថ្ងៃចាក់វ៉ាក់សាំ</a>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button type="submit" class="btn btn-success">បញ្ចូល</button>
        </div>
    </div>
</form>
</div>
<script>
    document.getElementById('take_vaccin').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://phumasia.com/green_farmer_community/user/routing/get_vaccin_record_req.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const $rep_message = JSON.parse(xhr.responseText);
                const $response_message_text = $rep_message.message;
                alert($response_message_text); // Display the response $response_message_text
                if ($response_message_text === 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ') {
                    location.reload(); // Refresh the page if the data was inserted successfully
                }else if($response_message_text === 'រំលឹករួចរាល់ហើយ!'){
                    location.reload(); 
                }
            }
        };
        xhr.send(formData);
    });
</script>