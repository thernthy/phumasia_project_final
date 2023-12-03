<div class="egg_record_con">
    <div class="conten_decr">
        <h2>កត់ត្រាពង់មានចូលទូរ</h2>
        <p>ទិន្ន័យដែលមិនត្រូវបានអនុញ្ញាត: អក្យ ឬ លេខ ជាភាសារខ្មែរ​!<br> លេខត្រូវតែវិជ្ជាមានជានិច្ច</p>
    </div>
    <form id="process_record">
    <div class="row mb-4 mt-4">
        <div class="col">
            <input type="date" class="form-control" id="egg_data_record" name="process_data_record" placeholder="Select date" aria-label="date">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" name="total_process_amount" placeholder="ចំនួនពង់ដែលដាក់ចូល" aria-label="total_egg" required>
        </div>
    </div>
    <div class="row mt-4">
        <label for="bar_code_id" class="col-sm-3 col-form-label">Bar corde ID</label>
        <div class="col">
            <input type="text" class="form-control" id="bar_code_id" name="bar_code_id" required>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <button type="submit" class="btn btn-success">Add</button>
        </div>
    </div>
</form>
</div>
<script>
document.getElementById('process_record').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost/Green_famer_project/user/routing/get_process_data_req.php', true);
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