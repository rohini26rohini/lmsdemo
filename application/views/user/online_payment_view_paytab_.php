<section class="top_strip top_strip_profile" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
    <div class="container">
        <div class="profile_details">
            <?php 
            if(isset($userdata) && $userdata->student_image!='') {
               $profile_img =  base_url().'uploads/student_images/'.$userdata->student_image; 
            } else {
               $profile_img =  base_url().'assets/images/profile_img.png';
            }
           
            ?>
            <div class="profile_details_img" style="background-image: url(<?php echo $profile_img;?>);"></div>
            <h4><?php echo (isset($userdata) && $userdata->name!='')?$userdata->name:'';?></h4>
            <ul>
                <li><img src="<?php echo base_url();?>assets/images/mail_round.png" class="img-responsive" /> <?php echo (isset($userdata) && $userdata->email!='')?$userdata->email:'';?></li>
                <li><img src="<?php echo base_url();?>assets/images/telephone_profile.png" class="img-responsive" /><?php  if(isset($userdata) && $userdata->contact_number!='') { echo $userdata->contact_number; } else if(isset($userdata) && $userdata->whatsapp_number!='') { echo $userdata->whatsapp_number; } else if(isset($userdata) && $userdata->mobile_number!='') { echo $userdata->mobile_number; }?></li>
                <li><img src="<?php echo base_url();?>assets/images/location-profile.png" class="img-responsive" /><?php echo (isset($userdata) && $userdata->address!='')?$userdata->address:'';?></li>
            </ul>
        </div>
    </div>
</section>
<section class="nav_profile">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a data-toggle="pill" href="#my_profile" class="active">Pay Fee </a></li>
            <!--
                <li class="active"><a data-toggle="pill" href="#my_profile" class="active">My Profile </a></li>
                <li><a data-toggle="pill" href="#my_course">My Course </a></li>
                <li><a data-toggle="pill" href="#tutorials">Tutorials </a></li>
                <li><a data-toggle="pill" href="#my_results">My Results </a></li>
                <li><a data-toggle="pill" href="#study_materials">Study Materials </a></li>
                <li><a data-toggle="pill" href="#schedules">Schedules </a></li>
                <li><a data-toggle="pill" href="#notfication">Notification </a></li>
-->
        </ul>
    </div>
</section>
<section class="profile_page">
    <form id="onlinepayform" method="post">
    <div class="container">
        <?php
        if(!empty($fee)) {
            if($seats == 'available') {
        ?>
        <div class="tab-content">
            <div id="my_profile" class="tab-pane fade  active show table-responsive">
                <h3><?php echo (isset($fee) && $fee->class_name!='')?$fee->class_name:'';?></h3>


                <table class="table table-striped">
                    <?php //echo '<pre>';print_r($fee);
                    if(isset($fee) && $fee->course_paymentmethod=='onetime') {
                        $discount = $this->common->get_student_discount_details($fee->student_id, $fee->course_id);
                        $discountAmt = 0;    
                        if(!empty($discount)) {
                            foreach($discount as $dis) {
                                if($dis->discount_status==1) {
                                $discountAmt += $dis->discount_amount;
                                }
                            }
                        }
                    ?>
                    <tr>
                        <th>Tution Fee</th>
                        <td>Pay</td>
                    </tr>
                    <tr>
                        <?php
                        if($discountAmt > 0) {
                            $payable = $fee->course_totalfee;
                        ?>
                        <td> Total Fee : <b><?php echo numberformat($fee->course_totalfee);?></b> <br>
                            <?php
                            if($hostel!='') { 
                               echo 'Hostel Fee : <b>'.numberformat($hostel).'</b><br>'; 
                                $payable += $hostel;
                            }
                            ?>
                            <?php
                            if($transport!='') { 
                               echo 'Transport Fee : <b>'.numberformat($transport).'</b><br>'; 
                                $payable += $transport;
                            }
                            ?>
                             Discount : <b><?php echo '-'.numberformat($discountAmt);?></b><br>
                        <?php echo 'Payable Amount :  <b>'.numberformat($payable-$discountAmt).'</b>';?>
                        <input type="hidden" value="1" name="discount" />    
                        <input type="hidden" value="<?php echo $payable-$discountAmt;?>" name="paidamount" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        </td>
                        <?php } else { ?>
                        <td>
                            Total Fee : <b><?php echo numberformat($fee->course_totalfee);?></b> <br>
                            <?php
                            $payable = $fee->course_totalfee;          
                            if($hostel!='') { 
                               echo 'Hostel Fee : <b>'.numberformat($hostel).'</b><br>'; 
                                $payable += $hostel;
                            }
                            ?>
                            <?php
                            if($transport!='') { 
                               echo 'Transport Fee : <b>'.numberformat($transport).'</b><br>'; 
                                $payable += $transport;
                            }
                            ?>
                        <?php echo 'Payable Amount :  <b>'.numberformat($payable);?>
                        <input type="hidden" value="<?php echo $payable;?>" name="paidamount" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        </td>
                        <?php } ?>
<!--
                        <td>Rs.100.00</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
-->
                        <td><button type="submit" class="btn btn-warning pay_btn userpay">Pay</button></td>
                    </tr>
                    <?php 
                    } else { 
                    $discount = $this->common->get_student_discount_details($fee->student_id, $fee->course_id);
                    $discountAmt = 0;    
                    if(!empty($discount)) {
                        foreach($discount as $dis) {
                            $discountAmt += $dis->discount_amount;
                        }
                    }
                    $installment = $this->common->get_batch_installment($fee->institute_course_mapping_id); 
                    if(!empty($installment)) {
                    $i = 0;    
                    ?>
                    <tr>
                        <th>Tution Fee</th>
                        <td>Pay</td>
                    </tr>
                    <?php foreach($installment as $install) { 
                    if($i==0) {
                        
                    ?>
                    <tr>
                        <?php
                        if($discountAmt > 0) {
                            $payable = $install->installment_amount;
                        ?>
                        <td> First Installment : <b><?php echo numberformat($install->installment_amount);?></b> <br>
                            <?php
                            if($hostel!='') { 
                               echo 'Hostel Fee : <b>'.numberformat($hostel).'</b><br>'; 
                                $payable += $hostel;
                            }
                            ?>
                            <?php
                            if($transport!='') { 
                               echo 'Transport Fee : <b>'.numberformat($transport).'</b><br>'; 
                                $payable += $transport;
                            }
                            ?>
                             Discount : <b><?php echo '-'.numberformat($discountAmt);?></b><br>
                        <?php echo 'Payable Amount :  <b>'.numberformat($payable-$discountAmt).'</b>';?>
                        <input type="hidden" value="1" name="installment" />
                        <input type="hidden" value="1" name="discount" />    
                        <input type="hidden" value="<?php echo $payable-$discountAmt;?>" name="paidamount" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        </td>
                        <?php } else { ?>
                        <td>
                        <?php
                             $payable = $install->installment_amount;          
                            if($hostel!='') { 
                               echo 'Hostel Fee : <b>'.numberformat($hostel).'</b><br>'; 
                                $payable += $hostel;
                            }
                            ?>
                            <?php
                            if($transport!='') { 
                               echo 'Transport Fee : <b>'.numberformat($transport).'</b><br>'; 
                                $payable += $transport;
                            }
                            ?>    
                        <?php echo 'Payable Amount :  <b>'.numberformat($payable);?>
                        <input type="hidden" value="1" name="installment" />
                        <input type="hidden" value="<?php echo $payable;?>" name="paidamount" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        </td>
                        <?php } ?>
<!--
                        <td>Rs.100.00</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
                        <td>Quarter</td>
-->
                        <td><button class="btn btn-warning pay_btn userpay">Pay</button></td>
                    </tr>
                    <?php $i++;?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </table>
                <style>
                    .pay_btn {
                        font-family: s-bold;
                        padding: 6px 15px;
                        font-size: 14px;
                        background-color: #eb6228;
                        border-color: #eb6228;
                        color: #fff !important;
                        float: left;
                    }

                </style>
            </div>

        </div>
        <?php } else { echo 'Batch already filled please contact Direction Office for details.';} ?>
        <?php  } else { echo 'Please Direction office for fee payment.';} ?>
    </div>
</form>
</section>
<?php $this->load->view("user/scripts/user_script"); ?>