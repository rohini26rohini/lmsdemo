<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/images/apple-icon-57x57.png');?>">
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon-32x32.png');?>">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.ico');?>" type="image/ico" sizes="16x16">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>IIHRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->load->view('includes/common_header.php'); ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
		<!-- <link rel="stylesheet" id="themify-icons-css" href="https://themify.me/wp-content/themes/themify-v32/themify-icons/themify-icons.css" type="text/css" media="all"> -->

        <link rel="stylesheet" href="<?php echo base_url();?>direction_v2/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>direction_v2/css/common.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>direction_v2/css/jquery.jConveyorTicker.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>direction_v2/css/verticalslider.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>direction_v2/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>direction_v2/css/blueimp-gallery.css">
        <link rel="stylesheet" href="<?php echo base_url();?>direction_v2/css/blueimp-gallery-indicator.css">
        <link rel="stylesheet" href="<?php echo base_url();?>direction_v2/css/jquery.toaster.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>direction_v2/css/custom_version.css">
        <link href='<?php echo base_url();?>direction_v2/css/simplelightbox.min.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>direction_v2/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/developer.css" />
        <link href='<?php echo base_url();?>assets/css/fullcalendar.min.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
        <link href="<?php echo base_url();?>assets/css/jquery.jConveyorTicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/jquery.jConveyorTicker.min.css" rel="stylesheet">
        <!-- messenger -->
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'> -->
         <link href="<?php echo base_url();?>direction_v2/css/jquery-confirm.min.css" rel="stylesheet">
         <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/common.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/progresscircle.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/cssprogress.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/dashboard-style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/custom-scroll/jquery.mCustomScrollbar.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/cssnew/lms-custom.css">


    
        <script src="<?php echo base_url();?>direction_v2/js/jquery.min.js "></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/popper.min.js "></script>
         <script src="<?php echo base_url();?>direction_v2/js/bootstrap.min.js "></script>
        <script src="<?php echo base_url();?>direction_v2/js/all.js "></script>
        <script src="<?php echo base_url();?>assets/js/moment.min.js "></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/fullcalendar.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.jConveyorTicker.min.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/custom.js "></script>
       <!-- <script src="<?php echo base_url();?>direction_v2/js/bootstrap.min.js "></script>-->
        <script src="<?php echo base_url();?>direction_v2/js/jquery.newsTicker.min.js "></script>
        <script src="<?php echo base_url();?>direction_v2/js/script.js "></script>
        <script src="<?php echo base_url();?>direction_v2/js/jquery.marquee.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/owl.carousel.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/verticalTicker.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/blueimp-helper.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/blueimp-gallery.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/blueimp-gallery-fullscreen.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/blueimp-gallery-indicator.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/jquery.blueimp-gallery.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/jquery.toaster.js"></script>
        <script src="<?php echo base_url();?>direction_v2/js/jquery-confirm.min.js"></script>

       <script src="<?php echo base_url();?>assets/js/js_new/progresscircle.js"></script>
       <script src="<?php echo base_url();?>assets/js/js_new/script.js"></script>
       <script src="<?php echo base_url();?>assets/css/cssnew/custom-scroll/jquery.mCustomScrollbar.concat.min.js"></script>
       <script src="<?php echo base_url();?>assets/js/jquery.lineProgressbar.js"></script>



   

        <style>
        .select2-container{
            width: 100% !important;
        }
    </style>

    </head>

    <body>
        <div class="disableEvent">
        <?php 
            $this->load->view('_layouts_new/header');
            // $this->load->view('libraries/Common');
            $this->load->view('includes/common_header');
            $this->load->view($viewload);
            $this->load->view('_layouts_new/footer');
        ?>
        </div>
        <script>
            var base_url = $("#directionBaseURL").val();
            var csrfName = $("#csrfName").val();
            var csrfHash = $("#csrfHash").val();
            function redirect(page){
                window.location.assign(base_url+page);
            }
        </script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

				<script>
    (function($){
        $(window).on("load",function(){
            $(".content").mCustomScrollbar();
        });
    })(jQuery);
</script>
    </body>
</html>
