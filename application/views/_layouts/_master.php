<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/images/list_style.png');?>">
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/list_style.png');?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>IIHRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->load->view('includes/common_header.php'); ?>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom_version_1.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/banner.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/lightslider.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/blueimp-gallery.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/blueimp-gallery-indicator.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/developer.css" />
        <link href='<?php echo base_url();?>assets/css/fullcalendar.min.css' rel='stylesheet' />
        <link href='<?php echo base_url();?>assets/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
        <link href="<?php echo base_url();?>assets/css/jquery.jConveyorTicker.min.css" rel="stylesheet">
        <!-- messenger -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <link href='<?php echo base_url();?>./inner_assets/css/select2/select2.min.css' rel='stylesheet' type='text/css'>
        <script src='<?php echo base_url();?>./inner_assets/js/select2/select2.min.js' type='text/javascript'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.min.js "></script>
        <script src="<?php echo base_url();?>assets/js/moment.min.js "></script>
        <script src="<?php echo base_url();?>assets/js/owl.carousel.js "></script>
        <script src="<?php echo base_url();?>assets/js/popper.min.js "></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js "></script>
        <script src="<?php echo base_url();?>assets/js/custom.js "></script>
        <script src="<?php echo base_url();?>assets/js/lightslider.js"></script>
        <script src="<?php echo base_url();?>assets/js/light_slide.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.bootstrap.newsbox.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/blueimp-helper.js"></script>
        <script src="<?php echo base_url();?>assets/js/blueimp-gallery.js"></script>
        <script src="<?php echo base_url();?>assets/js/blueimp-gallery-fullscreen.js"></script>
        <script src="<?php echo base_url();?>assets/js/blueimp-gallery-indicator.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.blueimp-gallery.js"></script>
         <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->
         <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/all.js "></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/fullcalendar.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.jConveyorTicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.marquee.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.toaster.js"></script>
    </head>
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>

    <body>
        <div class="disableEvent">
        <?php 
            $this->load->view('_layouts/header');
            $this->load->view('includes/common_header');
            $this->load->view($viewload);
            $this->load->view('_layouts/footer');
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
    </body>
</html>
