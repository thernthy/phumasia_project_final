<style>
    .edit_container{
        position: fixed;
        left: 0;
        z-index: 20;
        top: 2rem;
        width: 100%;
        height:100vh;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        display: none;
    }
#editForm{
 position: relative;
 width: 450px;
 background-color: white;
 box-shadow: 1px 0px 10px rgba(0,0,0,0.132);
 padding: 20px;
 display: flex;
 flex-direction: column;
 justify-content: space-between;
 align-items: center;
 border-radius: 20px;
}
.edite_form span{
    position: absolute;
    right: -15px;
    top: -15px;
    color: red;
    font-size: 1.5rem;
    padding: 10px;
    border-radius: 30px;
    box-shadow: 1px 0px 10px rgba(0,0,0,0.132);
}
.edite_form input{
    padding: 5px;
    border: 1px solid green;
    border-radius: 10px;
    outline: 0;
    margin: 5px 0;
}
.edite_form button{
    border: 0;
    color: green;
    background-color: transparent;
}
</style>


<?php
include 'check_recor_filter.php';
$year = 2023;
if(isset($_POST['view_record_filter'])){
    $selectDate = $_POST['selectDate'];
    $selectTask = $_POST['selectTask'];   
       if($selectTask !== "all"){
                echo '
            <div class="card mb-4 mt-5">
                <div class="card-header">
                <i class="fa-solid fa-user"></i>
                    user
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Place</th>
                                <th>Lot Number</th>
                                <th>Good</th>
                                <th>Broken</th>
                                <th>Brown</th>
                                <th>Task</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Place</th>
                                <th>Lot Number</th>
                                <th>Good</th>
                                <th>Broken</th>
                                <th>Brown</th>
                                <th>Task</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>';
                        $get_record_data = "SELECT id, date, Name, place, Lot_type, Good, Broken, Brown, task
                        FROM cashew_record
                        WHERE task = '$selectTask' ";
                        if ($selectDate !== 'all') {
                            if ($selectDate === 'today') {
                                $get_record_data .= " AND DATE(date) = CURDATE()";
                            } elseif ($selectDate === 'yesterday') {
                                $get_record_data .= " AND DATE(date) = CURDATE() - INTERVAL 1 DAY";
                            } elseif ($selectDate === 'thisWeek') {
                            $get_record_data .= " AND YEARWEEK(date) = YEARWEEK(CURDATE())";
                            } elseif ($selectDate === 'lastWeek') {
                                $get_record_data .= " AND YEARWEEK(date) = YEARWEEK(CURDATE()) - 1";
                            } elseif ($selectDate === 'thisMonth') {
                                $get_record_data .= " AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
                            } elseif ($selectDate === 'lastMonth') {
                                $get_record_data .= " AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) - 1";
                            }
                        }
                        $get_record_data .=" ORDER BY Good DESC";
                        $view_record_data = mysqli_query($conn, $get_record_data);
                        while ($row = mysqli_fetch_assoc($view_record_data)) {
                            $id = $row['id'];
                            $date = $row['date'];
                            $name = $row['Name'];
                            $place = $row['place'];
                            $lot_Type = $row['Lot_type'];
                            $good = $row['Good'];
                            $broken = $row['Broken'];
                            $brown = $row['Brown'];
                            $task = $row['task'];
                            $formattedDate = date('F j, Y', strtotime($date));
                                echo '
                                <tr>
                                <td>'.$formattedDate.'</td>
                                <td>'.$name.'</td>
                                <td>'.$place.'</td>
                                <td>'.$lot_Type.'</td>
                                <td>'.($good/1000).' Kg</td>
                                <td>'.($broken/1000).' Kg</td>
                                <td>'.($brown/1000).' Kg</td>
                                <td>'.$task.' Kg</td>
                                    <td>
                                    <button class="btn btn-danger" onclick="deleteRecord('.$id.', \''.$name.'\')">Del Record</button>
                                    </td>
                                </tr>';
                            }
                        echo '
                        </tbody>
                    </table>
                </div>
            </div>';
       }else{
        echo '
        <div class="card mb-4 mt-5">
            <div class="card-header">
            <i class="fa-solid fa-user"></i>
                user
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Lot Number</th>
                            <th>Good</th>
                            <th>Broken</th>
                            <th>Brown</th>
                            <th>Task</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Lot Number</th>
                            <th>Good</th>
                            <th>Broken</th>
                            <th>Brown</th>
                            <th>Task</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';
                    $get_record_data = "SELECT id, date, Name, place, Lot_type, Good, Broken, Brown, task
                    FROM cashew_record 
                    WHERE task!= ''";
                    if ($selectDate !== 'all') {
                        if ($selectDate === 'today') {
                            $get_record_data .= " AND DATE(date) = CURDATE()";
                        } elseif ($selectDate === 'yesterday') {
                            $get_record_data .= " AND DATE(date) = CURDATE() - INTERVAL 1 DAY";
                        } elseif ($selectDate === 'thisWeek') {
                        $get_record_data .= " AND YEARWEEK(date) = YEARWEEK(CURDATE())";
                        } elseif ($selectDate === 'lastWeek') {
                            $get_record_data .= " AND YEARWEEK(date) = YEARWEEK(CURDATE()) - 1";
                        } elseif ($selectDate === 'thisMonth') {
                            $get_record_data .= " AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
                        } elseif ($selectDate === 'lastMonth') {
                            $get_record_data .= " AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) - 1";
                        }
                    } 
                    $get_record_data .=" ORDER BY Good DESC";
                    $view_record_data = mysqli_query($conn, $get_record_data);
                    while ($row = mysqli_fetch_assoc($view_record_data)) {
                        $id = $row['id'];
                        $date = $row['date'];
                        $name = $row['Name'];
                        $place = $row['place'];
                        $lot_Type = $row['Lot_type'];
                        $good = $row['Good'];
                        $broken = $row['Broken'];
                        $brown = $row['Brown'];
                        $task = $row['task'];
                        $formattedDate = date('F j, Y', strtotime($date));
                            echo '
                            <tr>
                            <td>'.$formattedDate.'</td>
                            <td>'.$name.'</td>
                            <td>'.$place.'</td>
                            <td>'.$lot_Type.'</td>
                            <td>'.($good/1000).' Kg</td>
                            <td>'.($broken/1000).' Kg</td>
                            <td>'.($brown/1000).' Kg</td>
                            <td>'.$task.' Kg</td>
                                <td>
                                <button class="btn btn-danger" onclick="deleteRecord('.$id.', \''.$name.'\')">Del Record</button>
                                </td>
                            </tr>';
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>';
       }
}else{
    echo '
        <div class="card mb-4 mt-5">
            <div class="card-header">
            <i class="fa-solid fa-user"></i>
                user
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Lot Number</th>
                            <th>Good</th>
                            <th>Broken</th>
                            <th>Brown</th>
                            <th>Task</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Lot Number</th>
                            <th>Good</th>
                            <th>Broken</th>
                            <th>Brown</th>
                            <th>Task</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';
                    $get_record_data = "SELECT id, date, Name, place, Lot_type, Good, Broken, Brown, task
                    FROM cashew_record 
                    WHERE task!= ''  ORDER BY Good DESC"; 
                    
                    $view_record_data = mysqli_query($conn, $get_record_data);
                    while ($row = mysqli_fetch_assoc($view_record_data)) {
                        $id = $row['id'];
                        $date = $row['date'];
                        $name = $row['Name'];
                        $place = $row['place'];
                        $lot_Type = $row['Lot_type'];
                        $good = $row['Good'];
                        $broken = $row['Broken'];
                        $brown = $row['Brown'];
                        $task = $row['task'];
                        $formattedDate = date('F j, Y', strtotime($date));
                            echo '
                            <tr>
                            <td>'.$formattedDate.'</td>
                            <td>'.$name.'</td>
                            <td>'.$place.'</td>
                            <td>'.$lot_Type.'</td>
                            <td>'.($good/1000).' Kg</td>
                            <td>'.($broken/1000).' Kg</td>
                            <td>'.($brown/1000).' Kg</td>
                            <td>'.$task.'</td>
                                <td style="display:flex; flex-daraction:row;">
                                 <button class="btn btn-danger" onclick="deleteRecord('.$id.', \''.$name.'\')">Del</button>
                                 <button 
                                 class="btn btn-success" 
                                 onclick="editRecord(
                                    '.$id.',
                                    \''.$formattedDate.'\',
                                     \''.$name.'\',
                                     \''.$place.'\',
                                      \''.$lot_Type.'\',
                                      \''.$good.'\',
                                      \''.$broken.'\',
                                      \''.$brown.'\',
                                      \''.$task.'\',

                                      )">
                                 Edit</button>
                                </td>
                            </tr>';
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>';
}
?>
<div class="edit_container" id="edit_container">
    <form id="editForm" class="edite_form">
    <span onclick="closeEdit()"><i class="fa-solid fa-xmark"></i></span>
    <input type="hidden" class="form-control" id="editId" name="editId">
    <input type="date" id="date" name="date">
    <input type="text" id="editName" name="editName" placeholder="Name">
    <input type="text" id="editPlace" name="editPlace" placeholder="Place">
    <input type="text" id="lot_type" name="lot_type" placeholder="lot_type">
    <input type="text" id="good" name="good" placeholder="good">
    <input type="text" id="broken" name="broken" placeholder="broken">
    <input type="text" id="brown" name="brown" placeholder="brown">
    <input type="text" id="task" name="task" placeholder="task">
    <!-- Add more input fields for other data fields -->
    <button type="submit">Save</button>
    </form>
</div>
<script>
    function deleteRecord(recordId, recordName) {
        if (confirm("Are you sure you want to delete the record for " + recordName + "?")) {
            // Perform the delete operation
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("POST", "view_record/delete_record.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("record_id=" + recordId);
        }
    }
function editRecord(editId, date, name, place, lot_type, good, broken, browm,task){
        const edit_container =document.getElementById('edit_container');
        edit_container.style.display="flex"
        console.log(place)
        var formartDate = formatDate(date)
        document.getElementById('editId').value = editId;
        document.getElementById('date').value = formartDate;
        document.getElementById('editName').value = name;
        document.getElementById('editPlace').value = place;
        document.getElementById('lot_type').value = lot_type;
        document.getElementById('good').value = good;
        document.getElementById('broken').value = broken;
        document.getElementById('brown').value = browm;
        document.getElementById('task').value = task;
        console.log(editId)
    }
    function formatDate(date) {
    var formattedDate = new Date(date);
    var year = formattedDate.getFullYear();
    var month = ("0" + (formattedDate.getMonth() + 1)).slice(-2);
    var day = ("0" + formattedDate.getDate()).slice(-2);
    return year + "-" + month + "-" + day;
    }
    function closeEdit(){
        const edit_container =document.getElementById('edit_container');
        edit_container.style.display="none"
    }
//handle save button 
document.getElementById('editForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission
  const date = document.getElementById('date').value;
  const name = document.getElementById('editName').value;
  const place = document.getElementById('editPlace').value;
  const lot_type = document.getElementById('lot_type').value;
  const good = document.getElementById('good').value;
  const broken = document.getElementById('broken').value;
  const brown = document.getElementById('brown').value;
  // Perform validation
  if (date === '' || name === '' || place === '' || lot_type === '') {
    alert('Please input all data.'); // Display alert for missing data
    return; // Stop further execution
  }

  if (Number(good) < 0 || Number(broken) < 0 || Number(brown) < 0) {
    alert('Please do not enter negative numbers.'); // Display alert for negative numbers
    return; // Stop further execution
  }
  // Proceed with form submission if validation passes
  const formData = new FormData(this);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'view_record/get_edit_req.php', true);
  xhr.onload = function() {
    if (xhr.status === 200) {
        console.log(xhr.responseText)
      const response = JSON.parse(xhr.responseText);
      const message_pr_re = response.message_pr_re;
      alert(message_pr_re); // Display the response message_pr_re
        if (message_pr_re === 'ទិន្ន័យបានបញ្ចូលយ៉ាងជោគជ័យ') {
            location.reload(); // Refresh the page if the data was inserted successfully
        }
    }
  };
  xhr.send(formData);
});
</script>
