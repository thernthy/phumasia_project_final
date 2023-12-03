<?php
    include"db_con.php";
    $date = $_POST['egg_data_record'];
    $brokenEgg = $_POST['b_egg'];
    $goodEgg = $_POST['g_egg'];
    $g_chicken_egg = $_POST['g_chicken_egg'];
    $m_chicken_egg = $_POST['m_chicken_egg'];
    $not_fit_egg = $_POST['not_fit_egg'];
    // Prepare the INSERT statement
    $stmt = $pdo->prepare("INSERT INTO `record_egg`(`date_and_record`, `broke_egg`, `good_egg`, notfit_egg, m_chicken, g_chicken) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$date, $brokenEgg, $goodEgg, $not_fit_egg, $m_chicken_egg, $g_chicken_egg]);
    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        echo "ទិន្ន័យត្រូវបានបញ្ចូលយ៉ងជោគជ័យ";
    } else {
        echo "មានបញ្ហាសូមពិនិត្យមើទិន្ន័យហើយព្យាយាមម្ដងទៀត!";
    }
?>