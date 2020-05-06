
<body class="<?php
$color = $this->uri->segment(1);
$logo = $this->uri->segment(1);
if($color == 'direction-ias-study-circle'){echo 'iasbdy';}
if($color == 'direction-school-for-netjrf-examinations'){echo 'netbdy';}
if($color == 'direction-school-for-psc-examinations'){echo 'pscbdy';}
if($color == 'direction-school-for-ssc-examinations'){echo 'sscbdy';}
if($color == 'direction-school-of-banking'){echo 'bnkbdy';}
if($color == 'direction-school-for-entrance-examinations'){echo 'entbdy';}
if($color == 'direction-junior'){echo 'juniorbdy';}
if($color == 'direction-school-for-rrb-examinations'){echo 'rrbbdy';}
?>">
    <div class="loader">
        <img src="<?php echo base_url();?>assets/images/loader.gif">
        <!-- <img src="<?php echo base_url();?>direction_v2/images/loader_logo.png"> -->

    </div>
    <div class=" loaderSelect">
                                    <img src="<?php echo base_url();?>direction_v2/images/loader-select.svg">
                                </div>
    <header class="">
		<div class="header-inner">
        <div class="container maincon-tainer">
            <div class="">
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-lg-flex d-md-block "> -->
                <div class="menu__wrap">
                    <div class="Logo <?php if($logo == 'direction-ias-study-circle' || $logo == 'direction-school-for-netjrf-examinations' || $logo == 'direction-school-for-psc-examinations' || $logo == 'direction-school-for-ssc-examinations' || $logo == 'direction-school-of-banking' || $logo == 'direction-school-for-entrance-examinations' || $logo == 'direction-junior' || $logo == 'direction-school-for-rrb-examinations'){ echo 'mainlogo'; }else{ echo 'home-mainlogo'; } ?>">
                        <a href="<?php echo base_url('home');?>">
                        <?php 
                        $logo_img = "iihrm.jpg";
                        // if($logo == 'direction-ias-study-circle'){$logo_img = "ias.png";}
                        // else if($logo == 'direction-school-for-netjrf-examinations'){$logo_img = "jrf.png";}
                        // else if($logo == 'direction-school-for-psc-examinations'){$logo_img = "psc.png";}
                        // else if($logo == 'direction-school-for-ssc-examinations'){$logo_img = "ssc.png";}
                        // else if($logo == 'direction-school-of-banking'){$logo_img = "Banking.png";}
                        // else if($logo == 'direction-school-for-entrance-examinations'){$logo_img = "Entrance.png";}
                        // else if($logo == 'direction-junior'){$logo_img = "junior.png";}
                        // else if($logo == 'direction-school-for-rrb-examinations'){$logo_img = "rrb.png";}
                        // else{$logo_img = "logo.png";}
                        ?>
                            <img src="<?php echo base_url();?>direction_v2/images/logo/<?php echo $logo_img; ?>" alt="logo" class="img-fluid">
                        </a>
                    </div>
                    <div class="MainNav align-self-center">
                        <nav> 
                            <a id="resp-menu" class="responsive-menu" href="#"><i class="fas fa-bars"></i></a>
                            <ul class="menu">
                                <li><a class="homer" href="<?php echo base_url();?>"> Home</a>
                                </li>
                                <li><a href="<?php echo base_url('about-us');?>"> About Us</a>
                                </li>
								<li class="Courses"><a href="#">Courses <span class="ti-angle-down themify-icon-pos"></span></a>
								
                                    <ul class="sub-menu dropdown__menu">
                                        <li><a href="<?php echo base_url('direction-ias-study-circle');?>">BBA Courses <span class="ti-angle-right"></span></a>
                                <?php $classes= $this->common->get_classes(1); 
                                        if(!empty($classes)) { ?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/1">'.$classes['class_name'].' <span class="ti-angle-right"></span></a></li>';
                                                }?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-netjrf-examinations');?>">NET/JRF Examination Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(2); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/2">'.$classes['class_name'].'</a></li>';
                                                }?>  
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-psc-examinations');?>">MBA Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(3); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/3">'.$classes['class_name'].'</a></li>';
                                                }?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-ssc-examinations');?>">SSC Examination Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(4); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/4">'.$classes['class_name'].'</a></li>';
                                                }?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-of-banking');?>">Banking Examination Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(5); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/5">'.$classes['class_name'].'</a></li>';
                                                }?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-entrance-examinations');?>">Entrance examination Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(7); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/7">'.$classes['class_name'].'</a></li>';
                                                } ?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-junior');?>">B-tech Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(6); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/6">'.$classes['class_name'].'</a></li>';
                                                }?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-rrb-examinations');?>">RRB examination Courses <span class="ti-angle-right"></span></a>
                                        <?php $classes= $this->common->get_classes(8); 
                                        if(!empty($classes)) {?>
                                            <ul>
                                                <?php foreach($classes as $classes) {
                                                    echo '<li><a href="'.base_url('detailed_batch/'.$classes['class_id']).'/8">'.$classes['class_name'].'</a></li>';
                                                }?>
                                            </ul>
                                <?php   } ?>
                                        </li>
                                    </ul>
                                </li>

                                <!-- <li><a href="<?php echo base_url('services');?>"> Services</a></li> -->
                                <li><a href="<?php echo base_url('registration');?>"> Register</a></li>
                                <?php $resultsArr= $this->common->get_all_examresults(1); 
                               
                               if(!empty($resultsArr)){
                                    echo '<li><a href="'.base_url('detailed_results/'.$resultsArr['school_id']).'">Results</a></li>';
                               }else{ ?>
                                <li><a href="<?php echo base_url('result');?>"> Results</a></li>
                              <?php } ?>
                               




                                <li><a href="<?php echo base_url('work-with-us');?>"> Careers</a></li>
                                <li><a href="<?php echo base_url('gallery');?>"> Gallery</a></li>
                                <li><a href="<?php echo base_url('contact-us');?>"> Contact Us</a></li>
<!--
                                <li class="relogin  btn BtnOrang"><a href="<?php echo base_url('login');?>"> Login</a></li>
                                <li class="login btn BtnOrang"><a href="<?php echo base_url('login');?>">Login</a></li>
-->
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
                                <a  class="dropdown-toggle profile" data-toggle="dropdown">
                                    <div class="profile_avathar" style="background-image: url(<?php echo $profile_img;?>"></div>
                                   <?php echo (isset($userdata) && $userdata->name!='')?$userdata->name:'';?>
                                    <i class="fa fa-caret-down caret_down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu">
                                  <?php
                                    if($this->session->userdata('role') == "student"){?>
									<a class="dropdown-item" href="#" onclick="window.location.assign('<?php echo base_url();?>student-dashboard');"> <span class="ti-layout-media-right-alt"></span> Dashboard</a>
                                    <a class="dropdown-item" href="#" onclick="window.location.assign('<?php echo base_url();?>change-password');"> <span class="ti-lock"></span> Change Password</a>
                                    <?php } else { ?>
									<a class="dropdown-item" href="#" onclick="window.location.assign('<?php echo base_url();?>backoffice');"><span class="ti-layout-media-right-alt"></span> Dashboard</a>
									<?php }?>
                                    <a class="dropdown-item" href="#" onclick="window.location.assign('<?php echo base_url();?>backoffice/logout');"> <span class="ti-power-off"></span> Logout</a>
                                </div>
                            </div>
                        </li>
                        <!-- <li id="notification_li">
                            <a href="#" id="notificationLink"><img src="<?php echo base_url();?>assets/images/notificcation.png" class="img-responsive"/></a>
                            <div id="notificationContainer">
                                <div id="notificationTitle">Notifications</div>
                                <div id="notificationsBody" class="notifications">
                                    <ul>

                                    </ul>
                                </div>

                            </div>
                        </li> -->
                        <?php } else { ?>
                        <li class="relogin  btn BtnOrang"><a href="<?php echo base_url('login');?>"> Log in</a></li>
								<li class="login btn BtnOrang"><a href="<?php echo base_url('login');?>">Log in</a></li>
								<li class="reg__btn"><a href="<?php echo base_url('registration');?>"> Sign Up</a></li>
						<?php } ?>
						
						
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
		</div>
						</div>
    </header>
</body>
