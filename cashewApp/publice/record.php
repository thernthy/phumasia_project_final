

<style>
#addPlaceModal{
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}
#confirmModal{
    position: fixed;
    top: 0;
}
.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}
#addLotNoModal{
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

#back_btn{
    position: absolute;
    top: 1rem;
    left: 2rem;
    padding: 5px 20px;
}
@media screen and (max-width: 780px) {
  .modal-content {
    margin: 0;
    width: 100%;
  }
#back_btn{
    top: 1rem;
    left: 2rem;
    padding: 5px 20px;
}
}
</style>

<div id="confirmModal" class="modal confirm">
    <div class="modal-content center-modal">
        <div class="modal-header">
            <h5 class="modal-title">Confirm</h5>
            <button type="button" class="close" onclick="closeConfirmModal()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="confirmData"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="closeConfirmModal()">Edit</button>
            <button type="button" class="btn btn-success" id="confirmButton">Confirm</button>
        </div>
    </div>
</div>
<a href="?user=home">
<button class="btn btn-success" id="back_btn">
    <span><i class="fa-solid fa-arrow-left"></i></span>
    back
</button>
</a>

<div class="container mt-5 pb-2">
<h1>Record</h1>
    <form id="recordForm">
        <div class="form-group">
            <label for="place">Select Place:</label>
            <select class="form-control" id="place" name="place" onchange="handleName()">
            <option value=''></option>
                <?php
                $getPlace = mysqli_query($conn, "SELECT place FROM Appuser WHERE id!= 0 GROUP BY place");
                if (mysqli_num_rows($getPlace) > 0) {
                    while ($row = mysqli_fetch_assoc($getPlace)) {
                        $place = $row['place'];
                        echo "<option value='$place'>$place</option>";
                    }
                }
                ?>
            </select>
            <span class="btn btn-primary mt-3" onclick="showAddPlaceForm()">Add_Place</span>
        </div>
        <div class="form-group">
            <label for="name">Select Name:</label>
            <select class="form-control" id="name" name="name"></select>
        </div>
        <div class="form-group">
            <label for="lotType">Lot Number:</label>
            <select class="form-control" id="lotType" name="lotType">
                    <?php
                        $getLotType = mysqli_query($conn, "SELECT lot_type FROM lot_type WHERE id != 0 GROUP BY lot_type");
                        while ($row = mysqli_fetch_assoc($getLotType)) {
                         $lotType = $row['lot_type'];
                         echo "<option value='$lotType'>$lotType</option>";
                     }
                     ?>
            </select>
            <span class='btn btn-primary mt-3' onclick="showAddLotNoModal()">Add_Lot_No</span>
        </div>
        <div class="form-group">
            <label for="select_task">Select task:</label>
            <select class="form-control" id="select_task" name="select_task" onchange="handleTask()">
                    <?php
                        $gettask = mysqli_query($conn, "SELECT task FROM task WHERE id != 0 GROUP BY task");
                        while ($row = mysqli_fetch_assoc($gettask)) {
                         $task = $row['task'];
                         echo "<option value='$task'>$task</option>";
                     }
                     ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date">Select Date:</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <div class="form-row">
            <div class="col">
                <label for="good" id="l-good">Good:</label>
                <input type="number" class="form-control" id="good" name="good" placeholder="....g">
            </div>
            <div class="col controler">
                <label for="broken">Broken:</label>
                <input type="number" class="form-control" id="broken" name="broken" placeholder="....g">
            </div>
            <div class="col controler">
                <label for="brown">Brown:</label>
                <input type="number" class="form-control" id="brown" name="brown" placeholder="....g">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
<!-- Modal for Add Place -->
<div id="addPlaceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Add Place</h4>
        <button type="button" class="close" onclick="closeAddPlaceModal()">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="addPlaceForm" method="post">
                <div class="form-group">
                <label for="newPlace">Enter Place:</label>
                <input type="text" class="form-control" id="newPlace" name="newPlace">
                </div>
                <button type="submit" class="btn btn-primary" name="add_place">Add</button>
            </form>
        </div>
    </div>
</div>
<div id="addLotNoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Lot Number</h5>
            <button type="button" class="close" onclick="closeAddLotnumberModal()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="addLotNumForm">
                <div class="form-group">
                    <label for="lot_number">Lot Number:</label>
                    <input type="text" class="form-control" id="lot_number" name="lot_number">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
<script src="js/handle_record_form.js"></script>
<script src="https://kit.fontawesome.com/c49fa14979.js" crossorigin="anonymous"></script>