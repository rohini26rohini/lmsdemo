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
        <script src="<?php echo base_url();?>direction_v2/js/jquery.min.js "></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    </head>
    <script>
    	window.onload = function() {
    		var d = new Date().getTime();
    		document.getElementById("tid").value = d;
    	};
    </script>
    <body>
        <div class="disableEvent">
        <?php $this->load->view('includes/common_header');?>
        <section class="inner_page_wrapper">
            <div class="container maincontainer">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                        <div class="PaymentWapper">
                            <div class="paymentheader">
                                <h3>Payment Gateway</h3>
                            </div>
                            <?php if($flag == 1) {?>
                                <div class="paymentbody">
                                    <div class="paymentprice">
                                        <img src="<?php echo base_url();?>direction_v2/images/logo/cc_avenue.png" alt="logo" class="img-fluid avenuelogo">
                                        <h3>INR - <span id="payableamt"><?php echo number_format($data,2);?></span></h3>

                                    </div>
                                    <div class="studentdetails">
                                        <h5><?php echo $name;?></h5>
                                        <h6>Course :<span><?php echo $cource;?></span></h6>
                                        <form method="post" name="customerData" action="<?php echo base_url('Transactions');?>">

                                       

                                            <input type="hidden" name="discount" value="<?php echo $discount; ?>"/>
                                            <input type="hidden" name="amt" value="<?php echo $amt; ?>"/>
                                            <input type="hidden" name="paymentmethod" value="<?php echo $paymentmethod; ?>"/>
                                            <input type="hidden" name="payfrom" value="frontend"/>
                                            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>"/>
                                            <input type="hidden" name="institute_course_mapping_id" value="<?php echo $institute_course_mapping_id; ?>"/>
		                                    <input type="hidden" name="order_id" value="<?php echo $orderId; ?>"/>
                                            <input type="hidden" name="paid_amount" id="payableamt_hidden" value="<?php echo $data;?>"/>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                            <?php 
                                            if($paymentmethod=='installment') {
                                                if(!empty($installment)) {
                                                    $x = 1;
                                                    foreach($installment as $ins){ 
                                                        $centerCourse = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$institute_course_mapping_id));
                                                            if(!empty($centerCourse)) {
                                                                    $config['SGST'] = $centerCourse['sgst'];
                                                                    $config['CGST']	= $centerCourse['cgst']; 
                                                                    if($centerCourse['cess']>0){
                                                                    $config['cess']	= 1;    
                                                                    $config['cess_value']	= $centerCourse['cess'];
                                                                    } else {
                                                                    $config['cess']	= 0;    
                                                                    $config['cess_value']	= 0;    
                                                                    }
                                                            } 
                                                            $taxableAmt 		= 	taxcalculation($ins->installment_amount, $config, 0);
                                                            $amount = $taxableAmt['totalAmt'];
                                            ?>
                                            <label class="custom_checkbox" style="color: #787878 !important; margin-top:30px;">
                                            <input type="hidden" class="hostel installmentchk" name="installment_amt[]" value="<?php echo $ins->installment_amount;?>"/>
                                            <?php if($x==1) { ?>
                                             <input type="hidden" class="hostel installmentchk" name="installment[]" value="<?php echo $x;?>"/> installment <?php echo $x.' INR '.number_format($amount-$discount,2);?>
                                            <input type="hidden" class="hostel installmentchk" name="installment_amtgst[]" value="<?php echo $amount-$discount;?>"/>
                                             <span class="checkmark"><img src="<?php echo base_url();?>direction_v2/images/checkboxselect.png" /></span>
                                            <?php } else { ?>
                                            <input type="checkbox" class="hostel installmentchk selectedpay" name="installment[]" value="<?php echo $x;?>" status="<?php echo $amount;?>" /> installment <?php echo $x.' INR '.number_format($amount,2);?>
                                            <input type="hidden" class="hostel installmentchk" name="installment_amtgst[]" value="<?php echo $amount;?>"/>
                                             <span class="checkmark "></span>
                                             <!-- onclick="getpayment('<?php echo $amount;?>');" -->
                                            <?php } ?>
                                            </label>
                                            <?php $x++; ?>
                                            <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <button type="submit" class="btn bnkbg" style="margin-top:30px;">Pay</button>
                                        </form>
                                    </div>
                                </div>
                            <?php } else if($flag == 2){?>
                                <div class="paymentbody">
                                    <span>Sorry, Your payment link expired.</span>
                                </div>
                            <?php } else {?>
                                <div class="paymentbody">
                                    <span>Sorry, Please contact direction office.</span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<script>

    $(".selectedpay").click(function(){ 
        var amt = $(this).attr('status'); 
        var pay = $('#payableamt_hidden').val();
        if($(this).prop("checked") == true){
        var total =  parseFloat(pay) + parseFloat(amt);
        } else {
            var total =  parseFloat(pay) - parseFloat(amt);
        }
        $('#payableamt_hidden').val(total);
        $('#payableamt').html(total.toFixed(2));
    });
</script>

        <?php //$this->load->view('_layouts_new/footer');?>
