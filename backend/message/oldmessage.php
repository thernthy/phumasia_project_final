
<style>
    .personviwe{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    }

    .posersonviweinfo {
    width: calc(50% - 20px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    text-align: center;
    }
</style>
<div class='personviwe'>
<?php 
include '../header.php';

    $query= "SELECT * FROM message WHERE status=1 ORDER BY date DESC";               // SQL query to fetch all table data
    $view_users= mysqli_query($conn,$query); 
    while($row= mysqli_fetch_assoc($view_users)){
        $id = $row['id'];                
        $date = $row['date'];        
        $email = $row['email'];        
        $phoneNumber = $row['phoneNumber'];         
        $subject = $row['subject'];
        $message = $row['messages'];
        echo"
            <div class='card shadow p-3 mb-5 bg-body-tertiary rounded posersonviweinfo' style='width: 450px; margin: 5rem auto;'>
                    <div class='card-header'>
                        <p><span style='color: red;'>date:</span><strong>{$date}</strong></p>
                        {$email}
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>{$subject}</h5>
                        <p class='card-text'>{$message}</p>
                        <p><strong>{$phoneNumber}</strong></p>
                        <a href='./index.php' class='btn btn-primary'>Back</a>
                    </div>
            </div>
        ";
    }
?>
</div>