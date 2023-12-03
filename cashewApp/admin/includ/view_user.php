<?php
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
                    <th>Name</th>
                    <th>Role</th>
                    <th>Place</th>
                    <th>Place</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Place</th>
                    <th>Place</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>';
            $get_user = "SELECT id, username, role, place, password
            FROM Appuser
            WHERE id != 0
            ORDER BY username DESC";
            $view_user_data = mysqli_query($conn, $get_user);
            while ($row = mysqli_fetch_assoc($view_user_data)) {
                $id = $row['id'];
                $username = $row['username'];
                $password = $row['password'];
                $place = $row['place'];
                $role = $row['role'];
                    echo '
                    <tr>
                        <td>' . $username . '</td>
                        <td>' . $role . '</td>
                        <td>' . $place . ' </td>
                        <td>' . $password . '</td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteUser(' . $id . ')">Delete</button>
                        </td>
                    </tr>';
                }
            echo '
            </tbody>
        </table>
    </div>
</div>';
?>
<script>
    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhttp.open("DELETE", "includ/delete_user.php?user_id=" + userId, true);
            xhttp.send();
        }
    }
</script>
