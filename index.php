<?php
include('backend/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<!-- header -->
<?php include('header.php'); ?>
<body>
    <!-- body -->
    <?php
    // $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // // this is the condition, so when the actual link is equal to http://localhost/phumasia/ its gonna call the body.php file and when not its gonna call the "ourhistory.php" page
    //  if ($actual_link=="http://localhost/phumasia/") {
    //     // home page
    //     include('body.php'); 
    // } else if ($actual_link=="http://localhost/phumasia/history") {
    //     // im adding a new condition here that would call ourhistory.php page when we go to this address: http://localhost/phumasia/history
    //     include('otherpages/ourhistory.php');
    // } else {
    //     //  nothing
    //     echo "wrong page";
    // }

    include('body.php');
        
    ?>
</body>

<!-- javascript files -->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v14.0"
    nonce="3PsAlkWR"></script>
<script src="app.js"></script>
<script src="slide.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script type="text/javascript">
    $('#product').click(function () {
        $('.dropdown.products').slideToggle();
        $('.dropdown.homstay').css({
            'display': 'none'
        })
        $('.dropdown.activity').css({
            'display': 'none'
        })
    });
    /* Dropdown1*/
    $('#activity').click(function () {
        $('.dropdown.activity').slideToggle()
        $('.dropdown.homstay').css({
            'display': 'none'
        })
        $('.dropdown.products').css({
            'display': 'none'
        })
    });

    $('#homestay').click(function () {
        $('.dropdown.homstay').slideToggle();
        $('.dropdown.activity').css({
            'display': 'none'
        })
        $('.dropdown.products').css({
            'display': 'none'
        })
    });

    function showingknowmore() {
        $('.know-morecontant').slideToggle(1000)
        $('.contan3').slideToggle()
    }
    /* translate  khmer*/
    function khmer() {
        $('#english').css({
            'display': 'none'
        })
        $('#khmer').css({
            'display': 'block'
        })

        /* contan-two translate*/
        $('#english1').css({
            'display': 'none'
        })
        $('#khmer1').css({
            'display': 'block'
        })

        /* contan3 translate*/
        $('#english2').css({
            'display': 'none'
        })
        $('#khmer2').css({
            'display': 'block'
        })

        /* contan4 translate*/
        $('#english3').css({
            'display': 'none'
        })
        $('#khmer3').css({
            'display': 'block'
        })

        /* contan5 translate*/
        $('#english4').css({
            'display': 'none'
        })
        $('#khmer4').css({
            'display': 'block'
        })

        /* contan6 translate*/
        $('#english5').css({
            'display': 'none'
        })
        $('#khmer5').css({
            'display': 'block'
        })
    }

    /* translate japanese*/
    function japanes() {
        $('#khmer').css({
            'display': 'none'
        })
        $('#japanese').css({
            'display': 'block'
        })

        /* contan-two translate*/
        $('#khmer1').css({
            'display': 'none'
        })
        $('#japanese1').css({
            'display': 'block'
        })

        /* contan3 translate*/
        $('#khmer2').css({
            'display': 'none'
        })
        $('#japanese2').css({
            'display': 'block'
        })

        /* contan4 translate*/
        $('#khmer3').css({
            'display': 'none'
        })
        $('#japanese3').css({
            'display': 'block'
        })

        /* contan5 translate*/
        $('#khmer4').css({
            'display': 'none'
        })
        $('#japanese4').css({
            'display': 'block'
        })

        /* contan6 translate*/
        $('#khmer5').css({
            'display': 'none'
        })
        $('#japanese5').css({
            'display': 'block'
        })
    }

    /* translate English*/
    function english() {
        $('#khmer').css({
            'display': 'none'
        })
        $('#japanese').css({
            'display': 'none'
        })
        $('#english').css({
            'display': 'block'
        })

        /* contan-two translate*/
        $('#khmer1').css({
            'display': 'none'
        })
        $('#japanese1').css({
            'display': 'none'
        })
        $('#english1').css({
            'display': 'block'
        })

        /* contan3 translate*/
        $('#khmer2').css({
            'display': 'none'
        })
        $('#japanese2').css({
            'display': 'none'
        })
        $('#english2').css({
            'display': 'block'
        })

        /* contan4 translate*/
        $('#khmer3').css({
            'display': 'none'
        })
        $('#japanese3').css({
            'display': 'none'
        })
        $('#english3').css({
            'display': 'block'
        })

        /* contan5 translate*/
        $('#khmer4').css({
            'display': 'none'
        })
        $('#japanese4').css({
            'display': 'none'
        })
        $('#english4').css({
            'display': 'block'
        })

        /* contan6 translate*/
        $('#khmer5').css({
            'display': 'none'
        })
        $('#japanese5').css({
            'display': 'none'
        })
        $('#english5').css({
            'display': 'block'
        })
    }
    $('.downdouractivity').click(function () {
        $('#downd').toggleClass('downd');
    });

    $('.dace').click(function () {
        $('#dace').toggleClass('downd');
    });

    $('.IT').click(function () {
        $('#IT').toggleClass('downd');
    });
    AOS.init();
</script>

</html>