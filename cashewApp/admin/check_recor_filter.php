
<form method="post">
    <div class="row">
        <div class="col-5">
            <label for="dateSelect" class="form-label">Select Date:</label>
            <select class="form-select" id="dateSelect" name="selectDate" onchange="getData()">
                <option value="all" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'all') echo 'selected'; ?>>All</option>
                <option value="today" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'today') echo 'selected'; ?>>Today</option>
                <option value="yesterday" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'yesterday') echo 'selected'; ?>>Yesterday</option>
                <option value="thisWeek" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'thisWeek') echo 'selected'; ?>>This Week</option>
                <option value="lastWeek" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'lastWeek') echo 'selected'; ?>>Last Week</option>
                <option value="thisMonth" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'thisMonth') echo 'selected'; ?>>This Month</option>
                <option value="lastMonth" <?php if(isset($_POST['selectDate']) && $_POST['selectDate'] == 'lastMonth') echo 'selected'; ?>>Last Month</option>
            </select>
        </div>
        <div class="col-5">
            <label for="taskselect" class="form-label">Select Task:</label>
            <select class="form-select" id="taskselect" name="selectTask" onchange="getData()">
                <option value="all" <?php if(isset($_POST['selectTask']) && $_POST['selectTask'] == 'all') echo 'selected'; ?>>All</option>
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
        <div class="col-2 align-self-center">
            <button type="submit" class="btn btn-primary" name="view_record_filter">filter</button>
        </div>
    </div>
</form>

