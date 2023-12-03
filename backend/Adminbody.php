<style>
    .aminhome{
        margin:5rem 2rem;
    }
</style>


<div class="aminhome"> 
    <?php
    if(isset($_GET['Admin'])){
            $Admin = $_GET['Admin'];
            switch($Admin) {
                case 'home':
                    include "includes/home.php";
                break;
                case 'activitypost':
                    include "includes/create.php";
                break;       
                case 'productpost':
                    include "includes/post_product.php";
                break;   
                case 'oldmessages':
                    include "message/oldmessage.php";
                break;       
            }
        }else{
            include "includes/home.php";
        }
    ?>
</div>