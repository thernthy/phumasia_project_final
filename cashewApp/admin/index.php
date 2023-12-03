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
include 'header.php';
?>
<style>
body{
    font-family: 'PT Sans', sans-serif;
}
</style>
<body class="sb-nav-fixed">
    <?php include 'menuBar.php'?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <?php
                if (isset($_GET['Admin'])) {
                    $Admin = $_GET['Admin'];
                    switch ($Admin) {
                        case 'view-user':
                            include "includ/view_user.php";
                            break;
                        case 'view-record':
                            include "view_record/view_record.php";
                            break;
                        case 'add-user':
                            include "includ/add_user.php";
                            break;
                        case 'summery':
                            include "commponents/summery.php";
                            break;
                        case 'expend':
                            include "commponents/expending.php";
                            break;
                        case 'Oven':
                            include "commponents/task_work/oven.php";
                            break;
                        case 'Packing':
                            include "commponents/task_work/packing.php";
                            break;
                        case 'Steaming':
                            include "commponents/task_work/steaming.php";
                            break;
                        case 'Inner skin':
                            include "commponents/task_work/inner_skin.php";
                            break;
                        case 'Cleaning':
                            include "commponents/task_work/cleaning.php";
                            break;
                        case 'Hardshell':
                            include "commponents/task_work/hardshell.php";
                            break;
                        case 'phumasia/Packing':
                            include "commponents/phumasia/pst_packing.php";
                            break;
                        case 'phumasia/Steaming':
                            include "commponents/phumasia/pst_steaming.php";
                            break;
                        case 'phumasia/Inner skin':
                            include "commponents/phumasia/pst_inner_skin.php";
                            break;
                        case 'phumasia/Cleaning':
                            include "commponents/phumasia/pst_cleaning.php";
                            break;
                        case 'phumasia/Oven':
                            include "commponents/phumasia/pst_oven.php";
                            break;
                        case 'scy/Oven':
                            include "commponents/SCY/sdk_oven.php";
                            break;
                        case 'scy/Steaming':
                            include "commponents/SCY/sdk_steaming.php";
                            break;
                        case 'scy/Inner skin':
                            include "commponents/SCY/sdk_inner_skin.php";
                            break;
                        case 'scy/Cleaning':
                            include "commponents/SCY/sdk_cleaning.php";
                            break;
                        case 'moni_village/Hardshell':
                                include "commponents/moni_village/moni_mother.php";
                                break;
                        case 'moni_village/Cleaning':
                                include "commponents/moni_village/moni_cleaning.php";
                                break;
                        case 'moni_village/Inner skin':
                                include "commponents/moni_village/moni_inner_skin.php";
                                break;
                        case 'spk_village/Hardshell':
                                include "commponents/spk_village/spk_hardshell.php";
                                break;
                        case 'spk_village/Cleaning':
                               include "commponents/spk_village/spk_cleaning.php";
                               break;
                       case 'spk_village/Inner skin':
                                include "commponents/spk_village/spk_inner_skin.php";
                                break;
                    }
                } else {
                    include "commponents/summery.php";
                }
                ?>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Phumasia &copy; cashew nut record 2023</div>
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
            crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </div>
</body>
