<?php include "mene.php"; ?>
<?php
    //content 
    if(isset($_GET['phumasia'])){
        $phumasia = $_GET['phumasia'];
        switch($phumasia) {
            case 'home':
                include "routing/hom.php";
            break;
            case'our_history':
                include "routing/ourhistory.php";
                break;
            case'agriculture':
                include "routing/agriculture.php";
                break;
            case'dance':
                include "routing/dance.php";
                break;
            case'--trandictional':
                include "routing/trandictional.php";
                break;
            case'/news':
                    include "routing/News.php";
                    break;
            case'/enterpreneur':
                include "routing/entrepreneur.php";
                break;
            case'/experienceairbnb':
                include "routing/experience_airbnb.php";
                break;
            case'/products':
                include "routing/products.php";
                break;
            case'/contact':
                include "routing/contact.php";
                break;
        }
    }else{
        include "routing/hom.php";
    }
?>
<!-------------------Footer------------------------------>
<?php include('footer.php'); ?> 
