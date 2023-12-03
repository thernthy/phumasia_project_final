<style>
    .edit_container {
        position: fixed;
        left: 0;
        z-index: 20;
        top: 2rem;
        width: 100%;
        height: 100vh;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        display: none;
    }

    #editForm {
        position: relative;
        width: 450px;
        background-color: white;
        box-shadow: 1px 0px 10px rgba(0, 0, 0, 0.132);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        border-radius: 20px;
    }

    .edite_form span {
        position: absolute;
        right: -15px;
        top: -15px;
        color: red;
        font-size: 1.5rem;
        padding: 10px;
        border-radius: 30px;
        box-shadow: 1px 0px 10px rgba(0, 0, 0, 0.132);
    }

    .edite_form input {
        padding: 5px;
        border: 1px solid green;
        border-radius: 10px;
        outline: 0;
        margin: 5px 0;
    }

    .edite_form button {
        border: 0;
        color: green;
        background-color: transparent;
    }
</style>

<div class="card mb-4 mt-5">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Export Per Year
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <!-- Table header and footer omitted for brevity -->
            <tbody>
                <?php
                $converdTor = 1000;
                $get_oven_data = "SELECT id, date, expend_type, good, broken, brown, lot_type, note FROM expend WHERE id!=0 ORDER BY date ASC";
                $view_oven_data = mysqli_query($conn, $get_oven_data);

                while ($row = mysqli_fetch_assoc($view_oven_data)) {
                    $expend_type = $row['expend_type'];
                    $expend_date = $row['date'];
                    $expend_lot_type = $row['lot_type'];
                    $expend_cw_good = $row['good'];
                    $expend_cw_brock = $row['broken'];
                    $expend_cw_brown = $row['brown'];
                    $note_message = $row['note'];
                    $expend_id = $row['id'];
                    $formatted_date = date('Y-m-d', strtotime($expend_date));
                    $escaped_note_message = htmlspecialchars($note_message, ENT_QUOTES, 'UTF-8');
                    ?>
                    <tr>
                        <td><?= $expend_type ?></td>
                        <td><?= $expend_lot_type ?></td>
                        <td><?= $formatted_date ?></td>
                        <td><?= ($expend_cw_good / $converdTor) ?> Kg</td>
                        <td><?= ($expend_cw_brock / $converdTor) ?> Kg</td>
                        <td><?= ($expend_cw_brown / $converdTor) ?> Kg</td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteExport(<?= $expend_id ?>, '<?= $expend_date ?>')">Delete</button>
                            <button class="btn btn-success" onclick="editRecord(<?= $expend_id ?>, '<?= $formatted_date ?>', '<?= $expend_type ?>', '<?= $expend_lot_type ?>', '<?= $expend_cw_good ?>', '<?= $expend_cw_brock ?>', '<?= $expend_cw_brown ?>', '<?= $escaped_note_message ?>')">Edit</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="edit_container" id="edit_container">
        <form id="editForm" class="edite_form">
            <span onclick="closeEdit()"><i class="fa-solid fa-xmark"></i></span>
            <input type="hidden" class="form-control" id="editId" name="editId">
            <input type="date" id="date" name="date">
            <div class="row">
                <label for="expent_lot">Select lot number</label>
                <select class="form-select" id="expent_lot"​ name="expent_lot">
                    <option selected id="selected_lot_type"></option>
                    <?php
                    $get_epend_lot_type = "SELECT lot_type FROM expend WHERE lot_type!='' ORDER BY lot_type ASC";
                    $expent_lot_type_view = mysqli_query($conn, $get_epend_lot_type);

                    while ($row = mysqli_fetch_assoc($expent_lot_type_view)) {
                        $expent_view_lot_type = $row['lot_type'];
                        echo '<option value="' . $expent_view_lot_type . '">' . $expent_view_lot_type . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="row mt-2">
                <label for="">Select expent type</label>
                <select class="form-select" id="expendType" name="expendType" onchange="handleNote()">
                    <option selected id="expend_type"></option>
                    <option value="Export to Japan">Export to Japan</option>
                    <option value="Local Market">Local Market</option>
                    <option value="Products">Products</option>
                    <option value="Disposal">Disposal</option>
                </select>
            </div>
            <div class="form-group" id="note_control" style="display: none;">
                <input type="text" class="form-control" name="note" id="note" placeholder="write some reason">
            </div>
            <div class="row mt-2">
                <label for="">Good</label>
                <input type="text" id="good" name="good" placeholder="good">
            </div>
            <div class="row mt-2">
                <label for="">Broken</label>
                <input type="text" id="broken" name="broken" placeholder="broken">
            </div>
            <div class="row mt-2">
                <label for="">Brown</label>
                <input type="text" id="brown" name="brown" placeholder="brown">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<script>
    function deleteExport(recordId, expend_date) {
        if (confirm("Are you sure you want to delete the record for " + expend_date + "?")) {
            // Perform the delete operation
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "view_record/delete_expend.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("export_id=" + recordId);
        }
    }
    var export_id = 0;
    function editRecord(expend_id, formatted_date, expend_type, expend_lot_type, expend_cw_good, expend_cw_brock, expend_cw_brown, note_message) {
        const edit_container = document.getElementById('edit_container');
        edit_container.style.display = "flex";
        document.getElementById('editId').value = expend_id;
        document.getElementById('date').value = formatted_date;
        document.getElementById('expent_lot').value = expend_lot_type;
        document.getElementById('expendType').value = expend_type;
        document.getElementById('note').value = note_message;
        document.getElementById('good').value = expend_cw_good;
        document.getElementById('broken').value = expend_cw_brock;
        document.getElementById('brown').value = expend_cw_brown;
        handleNote();
        export_id = expend_id;
    }

    function closeEdit() {
        const edit_container = document.getElementById('edit_container');
        edit_container.style.display = "none";
        const editForm = document.getElementById('editForm');
        if (editForm) {
            editForm.reset();
        }
    }

    function handleNote() {
        const noteControl = document.getElementById('note_control');
        const expendType = document.getElementById('expendType').value;
        if (expendType === "Disposal") {
            noteControl.style.display = "block";
        } else {
            noteControl.style.display = "none";
        }
    }

document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const date = document.getElementById('date').value;
        const expent_lot = document.getElementById('expent_lot').value;
        const expendType = document.getElementById('expent_lot').value;
        const note = document.getElementById('note').value;
        const good = document.getElementById('good').value;
        const broken = document.getElementById('broken').value;
        const brown = document.getElementById('brown').value;
        if (date === '' || expent_lot === '' || expendType === '' || note === '' || good === '' || broken === '' || brown === '') {
            alert('Please input all data.');
            return;
        }

        if (Number(good) < 0 || Number(broken) < 0 || Number(brown) < 0) {
            alert('Please do not enter negative numbers.');
            return;
        }

        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'commponents/handle_request/export_edite.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const message_pr_re = response.message_pr_re;
                alert(message_pr_re);
                if (message_pr_re === 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ') {
                    location.reload();
                }
            }
        };
        xhr.send(formData);
    });
</script>
