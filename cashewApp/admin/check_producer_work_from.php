<form method="post">
    <div class="row mt-4">
        <div class="col-4">
            <input type="date" name="start_date" class="form-control" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>">
        </div>
        <div class="col-2 text-center"> <!-- Add text-center class for center alignment -->
            <span>To</span>
        </div>
        <div class="col-4">
            <input type="date" name="end_date" class="form-control" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>">
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-success" name="producer_check">Check</button>
        </div>
    </div>
</form>



