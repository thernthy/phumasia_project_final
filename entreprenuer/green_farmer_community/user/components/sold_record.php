<div class="egg_record_con">
    <div class="conten_decr">
        <h2>កត់ត្រាមាន់ងាប់</h2>
        <p>ទិន្ន័យដែលមិនត្រូវបានអនុញ្ញាត: អក្យ ឬ លេខ ជាភាសារខ្មែរ​!<br> លេខត្រូវតែវិជ្ជាមានជានិច្ច</p>
    </div>
    <form id="chicken_sold">
    <div class="row mb-4 mt-4">
        <div class="col">
            <input type="date" class="form-control" id="egg_data_record" name="sold_date_record" >
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <label for="chiken_choose" class="col-sm-4 col-form-label">ជ្រើរើស​ មាន់</label>
        <div class="col">
            <select class="form-select"  id="chiken_choose" name="chiken_type">
                <option value=""></option>
                <option value="chicken">មាន់សាច់</option>
                <option value="b_chicken">កូនមាន់</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <label for="dai_bar_code_id" class="col-sm-4 col-form-label">ជ្រើរើស​ លេខសម្គាល់</label>
        <div class="col">
            <select class="form-select"  id="dai_bar_code_id" name="sold_bar_code_id" data-chicken-type="">
                
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <input type="text" class="form-control" name="chicken_sold_amount" placeholder="ចំនួនលក់"  required>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="chicken_sold_add" placeholder="ថែម">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="chicken_sold_price" placeholder="តម្លៃ"  required>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="col-4">
            <input type="text" class="form-control" name="cmr_name" placeholder="ឈ្មោះអតិថិជន">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="cmr_place_ad" placeholder="ទីតាំអតិថិជន">
        </div>
        <div class="col-4">
            <input type="text" class="form-control" name="cmr_con_ad" placeholder="អាស័យដ្ឋានទាក់ទង់">
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="col">
            <input type="text" class="form-control" name="note" placeholder="កត់ចំណាំ">
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
  fetch(`http://localhost/Green_famer_project/user/routing/handle_sold_chicken_type.php?chicken_type=${choosedChiken}`)
    .then(response => {
      return response.json();
    })
    .then(data => {
      // Clear existing options
      bornBarCodeId.innerHTML = '';
      // Append new options based on the fetched data
      data.forEach($chicken_sold_barcode => {
        const option = document.createElement('option');
        option.value = $chicken_sold_barcode;
        option.textContent = $chicken_sold_barcode;
        bornBarCodeId.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error:', error);
    });
});
// send resquest to 
/// send requst to get chicken dai php 
document.getElementById('chicken_sold').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/Green_famer_project/user/routing/get_chicken_sold_req.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const $req_message = JSON.parse(xhr.responseText);
            const $response_message_text = $req_message.message;
            alert($response_message_text); // Display the response $response_message_text
            if ($response_message_text === 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ') {
                location.reload(); // Refresh the page if the data was inserted successfully
            }
        }
    };
    xhr.send(formData);
});
</script>