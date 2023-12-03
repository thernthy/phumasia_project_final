
<?php
$converdTor = 1000;
$currentMonth = date('F/d/Y');
echo ' <div class="card mb-4 mt-5">
<div class="card-header">
    <i class="fas fa-table me-1"></i>
     Detail
</div>
     <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                   <th>Name</th>
                    <th>Place</th>
                    <th>Lot Number</th>
                    <th>Date</th>
                    <th>Good</th>
                    <th>Broken</th>
                    <th>Brown</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Place</th>
                    <th>Lot Number</th>
                    <th>Date</th>
                    <th>Good</th>
                    <th>Broken</th>
                    <th>Brown</th>
                </tr>
            </tfoot>
            <tbody>';
            $get_hardshell_data = "SELECT date, Name, place, Lot_type, Good, Broken, Brown
             FROM cashew_record WHERE task='Hardshell' ORDER BY date DESC";
            $view_hardshell_data = mysqli_query($conn, $get_hardshell_data);
            while ($row = mysqli_fetch_assoc($view_hardshell_data)) {
                $hardshell_ps_name = $row['Name'];
                $hardshell_date = $row['date'];
                $hardshell_place = $row['place'];
                $hardshell_lot_type = $row['Lot_type'];
                $hardshell_cw_good = $row['Good'];
                $hardshell_cw_broken = $row['Broken'];
                $hardshell_cw_brown = $row['Brown'];
                $formatted_date = date('m/d/Y', strtotime($hardshell_date));
                echo'<tr>
                <td>'.$hardshell_ps_name.'</td>
                <td>'.$hardshell_place.'</td>
                <td>'.$hardshell_lot_type.'</td>
                <td>'.$formatted_date.'</td>
                <td>'.($hardshell_cw_good/$converdTor).' Kg</td>
                <td>'.($hardshell_cw_brown/$converdTor).' Kg</td>
                <td>'.($hardshell_cw_brown/$converdTor).' Kg</td>
                </tr>' ;
              }
            echo'</tbody>
        </table>
    </div>
</div>
';
?>