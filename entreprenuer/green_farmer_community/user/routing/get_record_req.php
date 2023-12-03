<?php
    include"db_con.php";
    $date = $_POST['egg_data_record'];
    $brokenEgg = $_POST['b_egg'];
    $goodEgg = $_POST['g_egg'];
    // Prepare the INSERT statement
    $stmt = $pdo->prepare("INSERT INTO `record_egg`(`date_and_record`, `broke_egg`, `good_egg`) VALUES (?, ?, ?)");
    $stmt->execute([$date, $brokenEgg, $goodEgg]);
    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        echo "Data inserted successfully!";
    } else {
        echo "Failed to insert data!";
    }
?>