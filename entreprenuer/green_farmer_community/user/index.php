<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}
include ("header.php") 
?>
<body>
<?php
if (isset($_GET['employe'])) {
            $employe = $_GET['employe'];
            switch ($employe) {
                case 'home':
                    include "components/home.php";
                    break;
                case 'egg=record':
                    include "components/egg_record.php";
                    break;
                case 'processe=str=record':
                    include "components/processe_str_record.php";
                    break;
                case 'processe=str=b=ch':
                    include "components/chiken_born_record.php";
                    break;
                case 'processe=str=dai=chiken':
                    include "components/daich_record.php";
                    break;
                case 'processe=str=sold=chicken':
                    include "components/sold_record.php";
                    break;
                case 'processe=str=Vaccines=vaccines':
                    include "components/vaccines_record.php";
                    break;
                case 'processe=str=view=vaccines':
                    include "components/view_vaccines.php";
                    break;
                }
        }else{
            include "components/home.php"; 
        }
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
<script src="https://kit.fontawesome.com/c49fa14979.js" crossorigin="anonymous"></script>
<script src="routing/js_request/record_egg.js"></script>
</body>
</html>

