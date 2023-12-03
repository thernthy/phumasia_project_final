
<style>
.form_position{
    position: fixed;
    top: 2.5rem;
    width: 100%;
    padding: 20px 20px;
    z-index: 100;
    background-color: white;
    left: 11rem;
}
.form_position label{
    color: gray;
    opacity: .5;
    font-size: .5rem;
}
@media screen and (max-width: 1000px)  {
    .form_position{
    left: 0rem;
    }
}
</style>


<form method="post" class="form_position shadow-sm bg-white rounded">
    <div class="row">
        <div class="col-2">
            <label>Select Lot:</label>
            <select class="form-select" id="lotTypeSelect" name="lottype" onchange="getData()">
                <option value="all" <?php if(isset($_POST['lottype']) && $_POST['lottype'] == 'all') echo 'selected'; ?>>All</option>
                <?php
                $query = "SELECT Lot_type, COUNT(*) as count FROM cashew_record WHERE Lot_type != '' GROUP BY Lot_type";
                $view_users = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($view_users)) {
                    $lotType = $row['Lot_type'];
                    $count = $row['count'];
                    echo "<option value='$lotType' " . (isset($_POST['lottype']) && $_POST['lottype'] == $lotType ? 'selected' : '') . ">$lotType</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-2">
            <label>Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>">
        </div>
        <div class="col-2">
            <label>End Date:</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>">
        </div>
        <div class="col-2">
            <label>select Task:</label>
            <select class="form-select" id="taskselect" name="selectTask" onchange="getData()">
                <option value="Packing" <?php if(isset($_POST['selectTask']) && $_POST['selectTask'] == 'Packing') echo 'selected'; ?>>Packing</option>
                <?php
                $query = "SELECT task, COUNT(*) as count FROM cashew_record WHERE task != '' GROUP BY task";
                $view_users = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($view_users)) {
                    $task = $row['task'];
                    $count = $row['count'];
                    echo "<option value='$task' " . (isset($_POST['selectTask']) && $_POST['selectTask'] == $task ? 'selected' : '') . ">$task</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-primary" name="check" style="margin-top: 15px;">Check</button>
        </div>
    </div>
</form>

