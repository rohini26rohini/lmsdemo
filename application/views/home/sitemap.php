<!DOCTYPE html>
<html lang="en">
    <body>
        <div class="abtbanner BgGrdOrange ">
            <div class="container maincontainer">
                <h3>Sitemap</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sitemap</li>
                </ol>
            </div>
        </div>

        <section class="inner_page_wrapper sitemaps">
            <div class="container maincontainer">
                <ul class="sitmapList">
                    <li><a href="<?php echo base_url(); ?>">Home </a>
                        <ul>
                            <li><a href="<?php echo base_url('success-stories');?>">Success Stories</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url('about-us');?>"> About Us</a></li>
                    <li><a href="#">Courses</a>
                        <ul class="sub-menu ">
                            <li><a href="<?php echo base_url('direction-ias-study-circle');?>">Direction IAS Study circle</a>
                                <ul>
                                    <li><a href="<?php echo base_url('ias-director');?>">Honorary Director</a></li>
                                    <li><a href="<?php echo base_url('upcoming-notifications-ias');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/1');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-ias-study-circle-how-to-prepare');?>">How to Prepare</a></li>
                                    <li><a href="<?php echo base_url('how-to-prepare-ias');?>">How to Prepare</a></li>
                                    <?php if($general_studies) { ?>
                                    <li><a href="<?php echo base_url('direction-ias-study-circle-general-studies/'.$general_studies);?>">General Studies</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-school-for-netjrf-examinations');?>">Direction School for NET/JRF Examinations </a>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-net');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/2');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-school-for-netjrf-examinations-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(2);  
                                    if(!empty($tutorialcontent)){
                                        if($tutorialcontent['topic_key']!== null){
                                            echo '<li><a href="'.base_url('direction-school-for-netjrf-examinations/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                        }else{

                                        }
                                }else{
                                }?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-school-for-psc-examinations');?>">Direction School for PSC Examinations </a>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-psc');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/3');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-school-for-psc-examinations-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(3);  
                                    if(!empty($tutorialcontent)){
                                        if($tutorialcontent['topic_key']!== null){
                                            echo '<li><a href="'.base_url('direction-school-for-psc-examinations/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                        }else{

                                        }
                                }else{
                                }?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-school-for-ssc-examinations');?>">Direction School for SSC Examinations </a>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-ssc');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/4');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-school-for-ssc-examinations-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(4);
                                    if(!empty($tutorialcontent)){
                                            if($tutorialcontent['topic_key']!== null){
                                                echo '<li><a href="'.base_url('direction-school-for-ssc-examinations/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                            }else{

                                            }
                                    }else{
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-school-of-banking');?>">Direction School of Banking </a>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-banking');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/5');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-school-of-banking-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(5);  
                                    if(!empty($tutorialcontent)){
                                        if($tutorialcontent['topic_key']!== null){
                                            echo '<li><a href="'.base_url('direction-school-of-banking/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                        }else{

                                        }
                                }else{
                                }?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-junior');?>">Direction Junior </a>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-junior');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/6');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-junior-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(6); 
                                    if(!empty($tutorialcontent)){
                                        if($tutorialcontent['topic_key']!== null){
                                            echo '<li><a href="'.base_url('direction-junior/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                        }else{

                                        }
                                }else{
                                }?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-school-for-entrance-examinations');?>">Direction School for entrance examinations </a></li>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-entrance');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/7');" href="#">Take a Test</a></li>
                                        <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-school-for-entrance-examinations-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(7);  
                                    if(!empty($tutorialcontent)){
                                        if($tutorialcontent['topic_key']!== null){
                                            echo '<li><a href="'.base_url('direction-school-for-entrance-examinations/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                        }else{

                                        }
                                }else{
                                }?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('direction-school-for-rrb-examinations');?>">Direction school for RRB examinations </a>
                                <ul>
                                    <li><a href="<?php echo base_url('upcoming-notifications-rrb');?>">Upcoming Exams & Notifications</a></li>
                                    <li><a onClick="redirect('sample-test/8');" href="#">Take a Test</a></li>
                                    <?php $message = $this->session->flashdata('data_name'); 
                                        if(isset($message)){
                                        echo '  <div class="alert alert-danger alert-dismissible fade show">
                                                    <strong> '.$message.'.</strong>
                                                </div>';  
                                        }?>
                                    <li><a href="<?php echo base_url('direction-school-for-rrb-examinations-how-to-prepare');?>">How to Prepare</a></li>
                                    <?php $tutorialcontent  = $this->common->get_elearning_materials(8);   
                                    if(!empty($tutorialcontent)){
                                        if($tutorialcontent['topic_key']!== null){
                                            echo '<li><a href="'.base_url('direction-school-for-rrb-examinations/'.$tutorialcontent['topic_key']).'">General Studies</a></li>';
                                        }else{

                                        }
                                }else{
                                }?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- <li><a href="<?php echo base_url('services');?>"> Services</a></li> -->
                    <li><a href="<?php echo base_url('registration');?>"> Admission</a></li>
                    
                    <?php $resultsArr= $this->common->get_all_examresults(1); 
                               if(!empty($resultsArr)){
                                    echo '<li><a href="'.base_url('detailed_results/'.$resultsArr['school_id']).'">Results</a></li>';
                               }else{ ?>
                                <li><a href="<?php echo base_url('result');?>"> Results</a></li>
                              <?php }
                                
                                ?>



                    <li><a href="<?php echo base_url('work-with-us');?>"> Careers</a></li>
                    <li><a href="<?php echo base_url('gallery');?>"> Gallery</a>
                        <!-- <ul>
                            <li><a href="<?php echo base_url();?>Home/gallery_view">Gallery View</a></li>
                        </ul> -->
                    </li>
                    <li><a href="<?php echo base_url('contact-us');?>"> Contact Us</a></li>
                    <li class="relogin "><a href="<?php echo base_url('login');?>"> Login</a></li>

                </ul>
            </div>
        </section>
    </body>
</html>