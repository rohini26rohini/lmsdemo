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
        if($status=='COMPLETED') {
        ?>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="registration_success">
                                <img src="<?php echo base_url();?>assets/images/success_icon.png" class="img-fluid" style="width:30px;"/>
                                <h3>Success!</h3>
                                <p> Your payment is complete<br> Transaction id: <?php echo $transaction_id;?>.</p>
                            </div>
                        </div>
        <?php } else { ?>
        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="registration_success">
                                <img src="<?php echo base_url();?>assets/images/fail_icon.png" class="img-fluid" style="width:30px;"/>
<!--                                <h3>Failed!</h3>-->
                                <p> Your payment is failed.<br>Transaction id:  <?php echo $transaction_id;?>.</p>
                            </div>
                        </div>
        <?php } ?>
    </div>
</form>
</section>
<?php $this->load->view("user/scripts/user_script"); ?>