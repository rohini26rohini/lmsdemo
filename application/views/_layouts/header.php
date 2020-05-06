<div class="loader">
        <img src="<?php echo base_url('assets/images/loader.svg'); ?>" class="img-fluid" />
        <img src="<?php echo base_url('assets/images/iihrm.jpg'); ?>" class="img-fluid" />
    </div>
<header class="header_wrap header_inner stickyCustom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right flex-row-reverse">
                    <div class="logo_wrap">
                        <?php
                            $logo = "iihrm.jpg";
                            // if(isset($logo_banking)){$logo = "logo_banking.png";}
                            // if(isset($logo_ias))    {$logo = "logo_ias.png";}
                            // if(isset($logo_junior)) {$logo = "logo_junior.png";}
                            // if(isset($logo_psc))    {$logo = "logo_psc.png";}
                            // if(isset($logo_ssc))    {$logo = "logo_ssc.png";}
                            // if(isset($logo_UGC))    {$logo = "logo_UGC.jpg";}
                        ?>
                        <a href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/images/'.$logo);?>" class="img-fluid" /></a>
                    </div>
                    <ul>
                        <li><a href="<?php echo base_url();?>">Home</a></li>
                        <li>
                            <div class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">About Us
                                <i class="fa fa-caret-down caret_down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('about-us');?>">About Us</a>
                                    <a class="dropdown-item" href="<?php echo base_url('our-team');?>">Our Team</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">Connect Us
                                <i class="fa fa-caret-down caret_down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('request-a-call-back');?>">Request A Call Back</a>
                                    <a class="dropdown-item" href="<?php echo base_url('raise-a-query');?>">Raise A Query</a>
                                    <a class="dropdown-item" href="<?php echo base_url('find-us');?>">Find Us</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">Careers
                                <i class="fa fa-caret-down caret_down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('work-with-us');?>">Work with Us</a>
                                    <a class="dropdown-item" href="<?php echo base_url('grow-with-us');?>">Grow with Us</a>

                                </div>
                            </div>
                        </li>
                        <li><a href="<?php echo base_url('gallery');?>">Gallery</a></li>
                        <li><a href="<?php echo base_url('contact-us');?>"> Contact Us</a></li>
                        <?php 
                        if(NULL !== $this->session->userdata('logedin') && $this->session->userdata('logedin')){
                            ?>
                        <li>
                          <?php 
                            if(isset($userdata) && $userdata->student_image!='') {
                            
                               $profile_img =  base_url().$userdata->student_image; 
                            } else {
                               $profile_img =  base_url().'assets/images/profile_img.png';
                            }
                            ?>      
                            <div class="dropdown profile_wrapper">
                                <a href="" class="dropdown-toggle profile" data-toggle="dropdown">
                                    <div class="profile_avathar" style="background-image: url(<?php echo $profile_img;?>"></div>
                                   <?php echo (isset($userdata) && $userdata->name!='')?$userdata->name:'';?>
                                    <i class="fa fa-caret-down caret_down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu">
                                  <?php
                                    if($this->session->userdata('role') == "student"){?>
                                    <a class="dropdown-item" href="#" onclick="window.location.assign('<?php echo base_url();?>backoffice/changepassword');">Change Password</a>
                                    <?php } ?>
                                    <a class="dropdown-item" href="#" onclick="window.location.assign('<?php echo base_url();?>backoffice/logout');">Logout</a>
                                </div>
                            </div>
                        </li>
                        <li id="notification_li">
                            <a href="#" id="notificationLink"><img src="<?php echo base_url();?>assets/images/notificcation.png" class="img-responsive"/></a>
                            <div id="notificationContainer">
                                <div id="notificationTitle">Notifications</div>
                                <div id="notificationsBody" class="notifications">
                                    <ul>
                                        <a href="">
                                            <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                        </a>
                                        <a href="">
                                            <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                        </a>
                                        <a href="">
                                            <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                        </a>
                                        <a href="">
                                            <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                        </a>


                                    </ul>
                                </div>
                               <div id="notificationFooter"><a href="#">See All</a></div>
                            </div>
                        </li>
                        <?php } else { ?>
                        <li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" onclick="url('<?php echo base_url('login');?>')" >Login</button>
                                <button type="button" class="btn btn-warning" onclick="url('<?php echo base_url('registration');?>')" style="color:#fff !important;">Register</button>
                            </div>
                        </li>
                        <?php } ?>
                        
                    </ul>
                    <section class="mobile_screen_wrapper d-xl-none d-lg-none d-md-block">
                        <button class="ham_nav"><span class=""><i class="fa fa-bars fa-1x"></i></span></button>
                    </section>
                </div>
            </div>
        </div>
    </header>
    <section class="mobile_nav " style="display:none">
        <button class="nav_close"><i class="fa fa-remove"></i></button>
        <div class="mobile_nav_scroll">

            <ul id="accordion">
                <li>
                    <a data-toggle="collapse" data-parent="#accordion" data-target="#home"><span>Home</span></a>
                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#accordion" data-target="#about"><span>About Us</span><i class="root_arw"><span class="fa fa-chevron-down "></span></i></a>
                    <div id="about" class="panel-collapse collapse">
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Our Team</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" data-parent="#accordion" data-target="#facility"><span>Connect Us</span><i class="root_arw"><span class="fa fa-chevron-down "></span></i></a>
                    <div id="facility" class="panel-collapse collapse">
                        <ul>
                            <li><a href="#">Request A Call Back</a></li>
                            <li><a href="#">Raise A Query</a></li>
                            <li><a href="#">Find Us</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#accordion" data-target="#career"><span>Careers</span><i class="root_arw"><span class="fa fa-chevron-down "></span></i></a>
                    <div id="career" class="panel-collapse collapse">
                        <ul>
                            <li><a href="#">Work with Us</a></li>
                            <li><a href="#">Grow with Us</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#">Gallery</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="<?php echo base_url('registration');?>">Register</a></li>
            </ul>
        </div>
    </section>
