

<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
// Logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}
include"header.php";
?>
<body>
<div class="container">      
    <?php include "components/navbar.php" ?>
    <!-- ========================= Main ==================== -->
    <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search">
                <form method="post">
                        <label>
                            <input type="date" placeholder="Search here" name="starting_date" value="<?php echo isset($_POST['starting_date']) ? $_POST['starting_date'] : ''; ?>">
                            <input type="date" placeholder="Search here" name="ending_date" value="<?php echo isset($_POST['starting_date']) ? $_POST['ending_date'] : ''; ?>">
                            <select id="barcode_check" class="barcode_check" name="barcode">
                                <option value="all" <?php if(isset($_POST['barcode']) && $_POST['barcode'] == 'all') echo 'selected'; ?>>All</option>
                                <?php 
                                $get_barcode = "SELECT Ch_barcode, Status FROM b_chiken WHERE Ch_barcode!=''";
                                $view_barcode = mysqli_query($conn, $get_barcode);
                                if ($view_barcode) {
                                    while ($row = mysqli_fetch_assoc($view_barcode)) {
                                        $barcode = $row['Ch_barcode'];
                                        echo '<option value="'.$barcode.'"'.(isset($_POST['barcode']) && $_POST['barcode'] == $barcode ? ' selected' : '').'>'.$barcode.'</option>';
                                    }
                                } else {
                                    echo "Error: " . mysqli_error($conn);
                                }
                                ?>
                            </select>
                            <button class="fine_barcode" id="fine_barcode" name="fine_barcode">fine</button>
                        </label>
                    </form>
                </div>

                <!-- <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>  -->
            </div>
        <?php
         if (isset($_GET['admin'])) {
            $admin = $_GET['admin'];
            switch ($admin) {
                case 'admin/home':
                    include "components/home.php";
                    break;
                case 'admin/dia':
                    include "components/dai_b_chiken.php";
                    break;
                case 'admin/chiken':
                    include "components/chiken.php";
                    break;
                case 'admin/edge':
                    include "components/cheking_edge.php";
                    break;
                }
        }else{
            include "components/home.php"; 
        }
        ?>
    </div>
</div>


<!-- =========== Scripts =========  -->
<script src="assets/js/main.js"></script>
<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/c49fa14979.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="components/fine.js"></script>

</body>
</html> 
