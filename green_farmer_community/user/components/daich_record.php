<?php include"routing/js_request/db_connection.php" ?>
<div class="egg_record_con">
    <div class="conten_decr">
        <h2>កត់ត្រាមាន់ងាប់</h2>
        <p>សូមវាយបញ្ចូលជាភាសាអង់គ្លេស និង​ លេខសកល លេខត្រូវតែវិជ្ជមានជានិច្ច</p>
    </div>
    <form id="chiken_dai_record">
    <div class="row mb-4 mt-4">
        <div class="col">
            <input type="date" class="form-control" id="egg_data_record" name="dai_date_record" >
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <label for="chiken_choose" class="col-sm-4 col-form-label">ជ្រើសរើសមាន់</label>
        <div class="col">
            <select class="form-select"  id="chiken_choose" name="chiken_type">
                <option value=""></option>
                <option value="chicken">មាន់សាច់</option>
                <option value="b_chicken">កូនមាន់</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <label for="dai_bar_code_id" class="col-sm-4 col-form-label">ជ្រើសរើសលេខសម្គាល់</label>
        <div class="col">
            <select class="form-select"  id="dai_bar_code_id" name="dai_bar_code_id" data-chicken-type="">
                
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" name="total_dai_amount" placeholder="ចំនួនងាប់"  required>
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
var chickenChoose = document.getElementById("chiken_choose");
var bornBarCodeId = document.getElementById("dai_bar_code_id");
chickenChoose.addEventListener("change", function() {
    choosedChiken = chickenChoose.value
  fetch(`https://phumasia.com/green_farmer_community/user/routing/handle_chike_type_select.php?chicken_type=${choosedChiken}`)
    .then(response => {
      return response.json();
    })
    .then(data => {
      // Clear existing options
      bornBarCodeId.innerHTML = '';
      // Append new options based on the fetched data
      data.forEach($bornBarCodeIds => {
        const option = document.createElement('option');
        option.value = $bornBarCodeIds;
        option.textContent = $bornBarCodeIds;
        bornBarCodeId.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error:', error);
    });
});

/// send requst to get chicken dai php 
document.getElementById('chiken_dai_record').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://phumasia.com/green_farmer_community/user/routing/get_chiken_dai_record_req.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const $response_message = JSON.parse(xhr.responseText);
            const $response_message_text = $response_message.message;
            alert($response_message_text); // Display the response $response_message_text
            if ($response_message_text === 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ') {
                location.reload(); // Refresh the page if the data was inserted successfully
            }
        }
    };
    xhr.send(formData);
});
</script>