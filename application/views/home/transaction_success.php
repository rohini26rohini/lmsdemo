<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/images/list_style.png');?>">
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/list_style.png');?>">
        <link rel="icon" href="<?php echo base_url('direction_v2/images/favicon.ico');?>" type="image/ico" sizes="16x16">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>IIHRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->load->view('includes/common_header.php'); ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

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

    </head>
    <body>
        <div class="disableEvent">
        <?php $this->load->view('includes/common_header');?>
        <section class="inner_page_wrapper">
            <div class="container maincontainer">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                        <div class="PaymentWapper">
                            <div class="paymentheader">
                                <h3>Payment Success</h3>
                            </div>
                                <div class="paymentbody">
                                   <h3>Your payment was successful</h3>
                                   <p>Thank you for your payment. Here are the details of this transaction for your reference.</p>
                                   <p>Transaction ID : <strong><?php echo $tracking_id;?> </strong></p>
                                   <p>Amount Paid : <strong><?php echo $amount;?> </strong></p>
                                </div>
                        </div>
                        <div class="text-center">
                            <?php
                            if($payfrom=='frontend') { ?>
                            <a href="<?php echo base_url();?>" class="btn text-info btn-link mt-2"><i class="fa fa-home"></i> Home</a>
                            <?php } else if($payfrom=='dashboard') { ?>
                                <a href="<?php echo base_url();?>student-dashboard" class="btn text-info btn-link mt-2"><i class="fa fa-home"></i>Goto Dashboard</a>    
                            <?php } ?>
                        </div>
                     </div>
                </div>
            </div>
        </section>

        <?php //$this->load->view('_layouts_new/footer');?>
