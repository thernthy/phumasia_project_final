<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form id="expendingForm" class="shadow-sm p-3">
        <div class="form-group">
          <label for="date">Date:</label>
          <input type="date" class="form-control" id="date" required>
        </div>
        <div class="form-group">
          <label for="lotNumber">Lot Number:</label>
          <select class="form-control" id="lotNumber" required>
          <?php
              $getLotType = mysqli_query($conn, "SELECT Lot_type FROM cashew_record WHERE id != 0 GROUP BY Lot_type");
              while ($row = mysqli_fetch_assoc($getLotType)) {
                $lotType = $row['Lot_type'];
                echo "<option value='$lotType'>$lotType</option>";
              }
           ?>
          </select>
          <a class="item-link" href="?user=view=stock" style="padding: 10px 20px;">view stock</a>
        </div>
        <div class="form-group">
          <label for="expendType">Export Type:</label>
          <select class="form-control" id="expendType" onchange="handleNote()" required>
            <option value="Export to Japan">Export to Japan</option>
            <option value="Local Market">Local Market</option>
            <option value="Products">Products</option>
            <option value="Disposal">Disposal</option>
          </select>
        </div>
        <div class="row">
          <div class="form-group col-4">
            <label for="good">Good:</label>
            <input type="number" class="form-control" id="good" placeholder=".....g" required>
          </div>
          <div class="form-group col-4">
            <label for="broken">Broken:</label>
            <input type="number" class="form-control" id="broken" placeholder=".....g" required>
          </div>
          <div class="form-group col-4">
            <label for="brown">Brown:</label>
            <input type="number" class="form-control" id="brown" placeholder=".....g" required>
          </div>
        </div>
        <div class="form-group" id="note_control" style="display: none;">
          <input type="text" class="form-control" name="note" id="note" placeholder="write some reason">
        </div>
        <button type="button" class="btn btn-primary" id="addBtn">Add</button>
      </form>
    </div>
  </div>
  <div class="row justify-content-center">
    <div id="confirmBlock" style="display: none;" class="col-md-6">
      <table class="table shadow-sm p-3">
        <thead class="thead-dark">
          <tr>
            <th>Date</th>
            <th>Lot Number</th>
            <th>Export Type</th>
            <th>Good</th>
            <th>Broken</th>
            <th>Brown</th>
            <th>Note</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td id="confirmDate"></td>
            <td id="confirmLotNumber"></td>
            <td id="confirmExpendType"></td>
            <td><span id="confirmGood"></span> g</td>
            <td><span id="confirmBroken"></span> g</td>
            <td><span id="confirmBrown"></span> g</td>
            <td><span id="confirmnote"></span></td>
          </tr>
        </tbody>
      </table>
      <button type="button" class="btn btn-success" id="confirmBtn">Confirm</button>
      <button type="button" class="btn btn-danger" id="editBtn">Edit</button>
    </div>
  </div>
</div>
<script src="js/handle_expend.js"></script>