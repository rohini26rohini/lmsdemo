<style>
    .select2-container--open{
        z-index:99999999!important;
    }
    </style>
<?php //echo $userdata->student_image;
            if(isset($userdata) && $userdata->student_image!='') {
               $profile_img =  base_url().$userdata->student_image; 
            } else {
               $profile_img =  base_url().'assets/images/avatar.png';
            }
            ?>
<section class="nav_profile ">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a data-toggle="pill" href="#studDashboard" class="active"><span class="ti-layout-media-right-alt"></span>  Dashboard </a></li>
            <li><a data-toggle="pill" href="#studProfile" id="profileid"><span class="ti-user"></span>Profile</a></li>
            <!-- <li><a data-toggle="pill" href="#feedetails" id="feedetailstab">Fee details</a></li>-->
            <!-- <li><a data-toggle="pill" href="#myschedule">My schedule</a></li> -->
            <!--<li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li> -->
             <li><a data-toggle="pill" href="#studProgress" id="studentprogress"><span class="ti-blackboard"></span> Result</a></li> 
            <!--<li><a data-toggle="pill" href="#studMaterials" id="studymaterials">Learning Module</a></li>
            <li><a  href="<?php echo base_url();?>student-dashboard-quiz" >My Quiz</a></li>-->
           
            <!-- <li><a  data-toggle="pill"  href="#stud_Materials" id="study_materials">Study Materials</a></li> -->
            <!-- <li><a data-toggle="pill" href="<?php echo base_url('backoffice/messenger');?>"><?php echo $this->lang->line('messenger');?> </a></li> -->
            <li style="position:relative;"><a data-toggle="pill" href="#stdMessenger"><span class="ti-comments"></span> <?php echo $this->lang->line('messenger');?>  </a>
            <?php if($notifyCount != 0){
                        echo '<span class="messanger-noty">'.$notifyCount.'</span>';
                    }?>
            </li>
            <!-- <li><a data-toggle="pill" href="#homeworks" id="homework_list">Homeworks</a></li> -->
            <?php
            if(!empty($students)) {
            ?>
            <li>
                <div class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo 'Select Child'; ?>
                    </a>
                    <div class="dropdown-menu">
                        <?php
                            foreach($students as $student) {
                                echo '<a class="dropdown-item " href="'.base_url('change/'.$student->student_id).'">'.$student->name.'</a>';
                            }
                        ?>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>

<!-- <?php if(!empty($notification)) { ?>
<section class="marquee_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <div class="marquee_wrap">
                    <div class="jctkr-label">
                        <span>Exams and Notifications</span>
                    </div>
                    <div class="js-conveyor-example">
                        <ul style="list-style-image: url(images/list_style.png)!important;">
                            <?php
                                 foreach($notification as $row) {
                                ?>
                            <li>
                            <a href="<?php echo $row->file; ?>" target="_blank"><span><?php echo $row->name;?></span></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?> -->
<section class="profile_page chat-box">
    <div class="container">
          

        <div class="tab-content">
        <div id="studDashboard" class="tab-pane fade active show">
        <!--<div class="abtbanner BgGrdOrange ">
         <div class="container maincontainer">
            <h3>Take a Test</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Take a Test</li>
            </ol>
        </div>
    </div> -->
    <div class="course--wapper">
        <div class="container p-0">
			<h4>Course overview</h4>
    <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="overview-box">
                        <div id="course-slider" class="owl-carousel owl-theme">
                        <?php 
                        $batch_id = 0;
                        if(!empty($course_Id)) {
                        foreach($course_Id as $row){ 
                            $courseDet = $this->common->get_from_tablerow('am_student_course_mapping', array('student_id'=>$this->session->userdata('user_id'),'course_id'=>$row->course_id, 'status'=>1));
                            if(!empty($courseDet)) {
                                $batch_id = $courseDet['batch_id'];
                            }
                            $teststatus = $this->common->get_from_tablerow('traning_status', array('training_id'=>$batch_id,'emp_id'=>$this->session->userdata('user_id'),'status'=>1));
                            ?>
                            <div class="item">
                                <div class="card">
                                    <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/physics.jpg" alt="Card image">
                                    <div class="card-body course-overview">
                                        <h4 class="card-title"><?php echo $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $row->course_id));?></h4>
                                        <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                        <div class="card-text d-flex justify-space-between">
                                            <!-- <a href="<?php echo base_url();?>student-dashboard-studyMaterials/<?php echo $row->course_id ?>">Details</a> -->
                                            <a class="btn__primary text-white" href="<?php echo base_url();?>course-subject-list/<?php echo $row->course_id ?>">Details</a>
                                            <?php
                                            if($row->active_exam==1) { ?>
                                            <a class="btn__secondary btn" href="<?php echo base_url();?>student-dashboard-quiz/<?php echo $row->course_id; ?>"> Test</a>
                                            <?php } else {
                                            if(!empty($teststatus)) { ?>
                                            <a class="btn__secondary btn" href="<?php echo base_url();?>student-dashboard-quiz/<?php echo $row->course_id; ?>"> Test</a>
                                            <?php }  } ?>
                                        </div>
                                        <div class="proggress-box">
                                            <div id="example-2" class="examples">
                                                <div class="cssProgress">
                                                <div class="progress2">
                                                <?php $progress = $this->common->get_course_progress($this->session->userdata('user_id'), $row->course_id); ?>
                                                    <div class="cssProgress-bar" data-percent="<?php if($progress>100) { echo '100'; } else { echo $progress; }?>" style="width: <?php if($progress>100) { echo '100'; } else { echo $progress; }?>%;">
                                                        <span class="cssProgress-label"><?php if($progress>100) { echo '100'; } else { echo $progress; }?>%</span>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="d-flex">
                                                    <small><?php if($progress>100) { echo '100'; } else { echo $progress; }?>% complete</small>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                foreach($course_Id as $row){
                    ?>
                    <script>
                    $(document).ready(function() {
                    $('#example-<?php echo $row->course_id;?>').progress_fnc();
                    });
                    </script>
                <?php } ?>
                <?php 
                $matArr = [];
                $student_id = $this->session->userdata('user_id');
                $courses = $this->common->get_all_student_courses($student_id);
                foreach($courses as $course) {
                $materials = $this->common->get_from_tableresult('mm_subjects', array('course_id'=>$course->class_id, 'subject_status'=>1));
                $subjectArr = [];
                if(!empty($materials)) {
                    foreach($materials as $material) {
                        array_push($subjectArr, $material->subject_id);
                    }
                }
                if(!empty($subjectArr)) {
                    $materials = $this->common->get_course_materials($subjectArr);
                    }
                    array_push($matArr, $materials);
                } 
                ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card coursesList">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="tabs" role="tablist">
                                <li class="nav-item">
                                    <?php
                                    $completed = 0;
                                    $pending = 0;
                                    if(!empty($matArr)){
                                        foreach($matArr as $mat){
                                            foreach($mat as $m){
                                                $viewed = $this->common->get_from_tablerow('mm_emp_material_view_status', array('emp_id'=>$this->session->userdata('user_id'),'material_id'=>$m->id));
                                    if(!empty($viewed)){
                                                $completed++;
                                                }
                                                if(empty($viewed)){ 
                                                    $pending++;
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <a class="active nav-link active" href="#post" data-toggle="tab">Completed
                                        Topic : <span><?php echo $completed;?></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#link" data-toggle="tab">Upcoming Topic: <span><?php echo $pending;?></span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content ">
                                <div class="tab-pane active content mCustomScrollbar light" id="post" data-mcs-theme="minimal-dark">
                                    <ul>
                                    <?php
                                   //echo '<pre>';
                                   //print_r($matArr);
                                   if(!empty($matArr)){
                                       foreach($matArr as $mat){
                                           foreach($mat as $m){ 
                                               $viewed = $this->common->get_from_tablerow('mm_emp_material_view_status', array('emp_id'=>$this->session->userdata('user_id'),'material_id'=>$m->id));
                                   if(!empty($viewed)){
                                   ?>
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="mr-3" onclick="view_study_material('<?php echo $m->id;?>')">
                                                    <img src="<?php echo base_url();?>assets/images/dashboard/physics.jpg" alt="course"
                                                        class="thumbnail">

                                                </a>
                                                <div class="flex">
                                                    <a href="#" class="text-body" onclick="view_study_material('<?php echo $m->id;?>')"><strong><?php echo $m->material_name;?></strong></a>
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-muted"><?php echo $m->subject_name;?>, 
                                                    <?php
                                                    if($m->text_content!='') { echo 'Note'; } else if($m->video_content!='')
                                                    { echo 'Video'; } else if($m->audio_content!='') {
                                                        echo 'Audio';
                                                    } else {
                                                        echo 'Video';
                                                    }
                                                    ?>
                                                    </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                   <?php } ?>
                                           <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    </ul>
                                </div>
                                <div class="tab-pane content mCustomScrollbar light" id="link" data-mcs-theme="minimal-dark">

                                    <ul>
                                    <?php
                                    if(!empty($matArr)){
                                        foreach($matArr as $mat){
                                            foreach($mat as $m){
                                                $viewed = $this->common->get_from_tablerow('mm_emp_material_view_status', array('emp_id'=>$this->session->userdata('user_id'),'material_id'=>$m->id));
                                    if(empty($viewed)){
                                        ?>
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="mr-3" onclick="view_study_material('<?php echo $m->id;?>')">
                                                    <img src="<?php echo base_url();?>assets/images/dashboard/physics.jpg" alt="course"
                                                        class="thumbnail">

                                                </a>
                                                <div class="flex">
                                                    <a href="#" class="text-body" onclick="view_study_material('<?php echo $m->id;?>')"><strong><?php echo $m->material_name;?></strong></a>
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-muted"><?php echo $m->subject_name;?>
                                                        <?php
                                                        if($m->text_content!='') { echo 'Note'; } else if($m->video_content!='')
                                                        { echo 'Video'; } else if($m->audio_content!='') {
                                                            echo 'Audio';
                                                        } else {
                                                            echo 'Video';
                                                        }
                                                        ?>
                                                    </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php } ?>
                                           <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
            </div>
            </div>
			</div>
            <div class="exam-wapper">
            <div class="container p-0">
            <div class="row">
			<div class="col-md-12">
                        <div class="card cus-result mb-30 dashboardcal">
                            <div class="card-header">
                                <dv class="d-flex justify-space-between align-self">
                                    <h3>Class Schedule</h3>
                                    <!-- <a href="#">View all</a> -->
                                </dv>
                            </div>
                            <div class="card-body">
                                <div id="calendar" class="calendar-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="card cus-result mb-30 dashboardexam">
                            <div class="card-header">
                                <dv class="d-flex justify-space-between align-self">
                                    <h3>Exam Result</h3>
                                    <!-- <a>View all</a> -->
                                </dv>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <!-- <li class="d-flex justify-space-between hidebox">
                                        <div class="d-flex ">
                                            <img src="images/dashboard/clipboard-solid.svg" alt="">
                                            <h4>Level 1 HTML <span>topics 1</span></h4>
                                        </div>
                                        <a href="#">Exam</a>
                                    </li>
                                    <li class="d-flex justify-space-between">
                                        <div class="d-flex ">
                                            <img src="images/dashboard/clipboard-solid.svg" alt="">
                                            <h4>Level 1 HTML <span>topics 1</span></h4>
                                        </div>
                                        <a href="#">Exam</a>
                                    </li> -->
                                    <?php
                                    $totalq = 0;
                                    $ans    = 0;
                                    $percntscore = 0;
                                    $exams = $this->common->get_examsresult($this->session->userdata('user_id'));
                                    if(!empty($exams)) {
                                        foreach($exams as $exam){
                                            $results = $this->common->get_latest_results($this->session->userdata('user_id'), $exam->id);
                                            if(!empty($results)) {
                                                foreach($results as $result) { 
                                            $attempt = $this->common->get_latest_attemps($this->session->userdata('user_id'), $result->assessment_id, $result->attempt);
                                            if(!empty($attempt)) {
                                                //foreach($attempt as $att){
                                                $ans = 0;    
                                                $totalq = count($attempt);
                                                $ans = $attempt[0]['correct'];
                                                if($ans>0) {
                                                $percnt = $ans/$totalq;
                                                $percntscore = $percnt*100;
                                            }
                                          
                                      
                                    ?>
                                    <li class="good d-flex justify-space-between">
                                        <div class="d-flex ">
											<img src="<?php echo base_url();?>assets/images/dashboard/test.svg" alt="#">
											
											
                                            <h4>  <?php echo $exam->class_name;?> <span>Attempt <?php echo $result->attempt;?></span></h4>
                                        </div>
                                        <?php
                                        if($result->grade=='Excellent') {
                                            $gradeclass = 'background-color:#CCFF90; color:#7CB342;';
                                        } else if($result->grade=='Good') {
                                            $gradeclass = 'background-color:#B9F6CA;color:#4CAF50;';
                                        } else if($result->grade=='Above Average') {
                                            $gradeclass = 'background-color:#FFF3E0;color:#F57C00;';
                                        } else {
                                            $gradeclass = 'background-color:#FBE9E7;color:#FF5722;';
                                        }
                                        ?>
										<p><span style="<?php echo $gradeclass;?>"><?php echo (!empty($results) && $result->grade!='')?$result->grade:'';?></span>
										<b class="p__value"><strong><?php echo number_format($percntscore,2);?>%</strong></b>
									</p>
										
                                    </li>
                                        <?php //} ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php   } ?>
                                    <!-- <li class="Failed d-flex justify-space-between">
                                        <div class="d-flex ">
                                            <img src="images/dashboard/clipboard-solid.svg" alt="">
                                            <h4>Level 1 HTML <span>topics 1</span></h4>
                                        </div>
                                        <p><span>Failed</span>3.8</p>
                                    </li>
                                    <li class="excellent d-flex justify-space-between">
                                        <div class="d-flex ">
                                            <img src="images/dashboard/clipboard-solid.svg" alt="">
                                            <h4>Level 1 HTML <span>topics 1</span></h4>
                                        </div>
                                        <p><span>excellent</span>8.8</p>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                   
                </div>
                </div>
                </div>
         </div>
            
            <div id="studProfile" class="tab-pane fade">
           
    <div class="profile">
        <div class="container">
        <h3 class="cus-title">Student Profile <small></small></h3>
            <div class="row">
                <div class="col-md-3">
                    <div class=" profile-box profile-pic">
                        <img src="<?php echo $profile_img ?>" class="img-fluid" alt="">
                        <h5><?php echo $userdata->name;?></h5>
                        <span><?php echo $userdata->email;?> </span>
                    </div>
                    <div class="profile-box d-flex course__taken">
                                <i class="fa fa-graduation-cap"></i>
                                <h4>Courses Taken<span><?php echo $course_count;?> </span></h4>
                            </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <!-- <div class="col-md-4">
                            
                        </div> -->
                        <!-- <div class="col-md-4">
                            <div class="profile-box d-flex">
                                <i class="fa fa-book"></i>
                                <h4>Overall Score<span>592</span></h4>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-4">
                            <div class="profile-box d-flex">
                                <i class="fa fa-question"></i>
                                <h4>Quizzes Taken<span>12</span></h4>
                            </div>
                        </div> -->
                        <table class="profileWrapper profileWrapperRow">
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Name :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->name;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Registration No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->registration_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Address :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->address;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Street:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->street;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            City:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php $city_id= $userdata->district;
                                        echo $this->common->get_name_by_id('cities','name',array('id' => $city_id));
                                        ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            State :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php $state_id= $userdata->state;
                                        echo $this->common->get_name_by_id('states','name',array('id' => $state_id));
                                        ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Contact No :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->contact_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Whatsapp No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->whatsapp_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Mobile No :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->mobile_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Blood Group:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->blood_group;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Email Id :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->email;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Date of Birth:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->date_of_birth;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Name of Guardian:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->guardian_name;?></label>
                                            </div>
                                        </div>

                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Guardian's Contact No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->guardian_number;?></label>
                                            </div>
                                        </div>

                                    </th>
                                </tr>
                                
                            </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
            </div>
            <div id="studProfile11" class="tab-pane fade">
                <div id="accordionReg" class="accordionReg">
                    <div class="card">

                        <a class="card-link" data-toggle="collapse" href="#collapseshow">
                            <div class="profileWrapperHead ">
                                <h3>Profile</h3>
                            </div>
                        </a>
                        <div id="collapseshow" class="collapse show" data-parent="#accordionReg">
                            <table class="profileWrapper profileWrapperRow">
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Name :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->name;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Registration No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->registration_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Address :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->address;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Street:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->street;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <!--                      <tr>
                            <th width="50%">
                                <div class="media">
                                    State :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><?php $state_id= $userdata->state;
                                            echo $this->common->get_name_by_id('states','name',array('id' => $state_id));
                                            ?></label>
                                    </div>

                                </div>
                        </th>
                        <th width="50%">
                            <div class="media">
                                Application No:
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php echo $userdata->registration_number;?></label>
                                </div>
                            </div>
                        </th>
                    </tr>

                    <tr>
                        <th width="50%">
                            <div class="media">
                                Address :
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php echo $userdata->address;?></label>
                                </div>
                            </div>
                        </th>
                        <th width="50%">
                            <div class="media">
                                Street:
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php echo $userdata->street;?></label>
                                </div>
                            </div>
                        </th>
                    </tr>
-->
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            City:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php $city_id= $userdata->district;
                                        echo $this->common->get_name_by_id('cities','name',array('id' => $city_id));
                                        ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            State :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php $state_id= $userdata->state;
                                        echo $this->common->get_name_by_id('states','name',array('id' => $state_id));
                                        ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Contact No :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->contact_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Whatsapp No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->whatsapp_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Mobile No :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->mobile_number;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Blood Group:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->blood_group;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Email Id :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->email;?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Date of Birth:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->date_of_birth;?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Name of Guardian:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->guardian_name;?></label>
                                            </div>
                                        </div>

                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Guardian's Contact No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $userdata->guardian_number;?></label>
                                            </div>
                                        </div>

                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Course:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php $studentid= $userdata->student_id;
                                        $course_id= $this->common->get_name_by_id('am_student_course_mapping','course_id',array('student_id' => $studentid, 'status'=>1));
                                        echo $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $course_id));
                                        ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Batch:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php
                                        $batch_id= $this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id' => $studentid, 'status'=>1));
                                        echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array('batch_id' => $batch_id));
                                        ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="card">

                        <a class="card-link" data-toggle="collapse" href="#collapseOne">
                            <div class="profileWrapperHead">
                                <h3>Qualification</h3>
                            </div>
                        </a>
                        <div id="collapseOne" class="collapse " data-parent="#accordionReg">
                            <table class="profileWrapper profileWrapperRow">
                                <?php foreach($qualification as $row) {?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            <?php echo $row['qualification']." :";?>
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $row['marks']." %";?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>

                    </div>
                    <div class="card">

                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                            <div class="profileWrapperHead">
                                <h3>Other Details</h3>
                            </div>
                        </a>



                        <div id="collapseTwo" class="collapse" data-parent="#accordionReg">
                            <table class="profileWrapper profileWrapperRow">
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Hostel Required :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php  echo $userdata->hostel; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($userdata->hostel == "yes"){
								if($userdata->stayed_in_hostel!='') {
								?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Whether the candidate had stayed in any hostel before :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->stayed_in_hostel; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
								<?php } 
								if($userdata->food_habit!='') {
								?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Food habit of student :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo ucfirst($userdata->food_habit); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
								<?php } ?>
                                <?php if(!empty($hostel_room_details)){?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Hostel Details :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $hostel_room_details['room_number']." , ".$hostel_room_details['floor']." , ".$hostel_room_details['building_name'];?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                                <?php } ?>
<!--
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Whether the candidate has any medical history of aliment :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->medical_history;?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
-->
                                <?php //if($userdata->medical_history == "yes") {?>
<!--
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Medical Description :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->medical_description;?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
-->
                                <?php //} ?>
                                <?php if($userdata->transportation == "yes") {?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Transportation Details:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php
                                                    echo $this->common->get_name_by_id('tt_transport_stop','name',array("transport_id"=>$userdata->stop)).",";
                                                    echo $this->common->get_name_by_id('tt_transport','route_name',array("transport_id"=>$userdata->place ));
                                                    ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                            </table>

                        </div>
                    </div>
                    <div class="card">
                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                            <div class="profileWrapperHead">
                                <h3>Hallticket Details</h3>
                            </div>
                        </a>
                        <div id="collapseThree" class="collapse" data-parent="#accordionReg">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm ExaminationList">
                                    <thead>
                                        <tr>
                                            <th>Sl.no</th>
                                            <th style="text-align: left;">Exam Name</th>
                                            <th>Hall Ticket Number</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- <div class="alert alert-success" id="success_msg" style="display:none;">
                                        <strong>Submitted Succesfully!</strong>
                                    </div>
                                    <div class="alert alert-danger" id="error_msg" style="display:none;">
                                        <strong>Network Error! Please try agin later</strong>
                                    </div> -->
                                    <?php if(!empty($examlist)) {
                                        $i=1; 
                                        foreach($examlist as $exam){?>
                                            <form class="examlist" id="examlist<?php echo $exam->notification_id;?>" method="post">
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td style="text-align: left;"><?php echo $exam->name;?></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="hidden" name="notification_id[]" id="notification_id" value="<?php echo $exam->notification_id;?>" />
                                                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $exam->student_id;?>" />
                                                            <!-- <input type="hidden" name="examlist_id" id="examlist_id" value="" /> -->

                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                            <?php
                                                    $student_exam=$this->common->get_student_exam_byid($exam->student_id,$exam->notification_id);
                                                    if(!empty($student_exam)){
                                                    $j=1; 
                                                    foreach($student_exam as $rows){
                                                    ?>
                                                            <input type="text" class="form-control" placeholder="Hall Ticket Number" id="hltText<?php echo $exam->notification_id; ?>" name="hall_tkt[]" value="<?php if(!empty($rows['hall_tkt'])){ echo $rows['hall_tkt']; }?>">
                                                            <?php }$j++;}else{ ?>
                                                            <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" value="" id="hltText<?php echo $exam->notification_id; ?>">
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                    <td><button class="btn btn-sm btn-success form-submit" id="submitForm<?php echo $exam->notification_id; ?>" onclick="submitForm(<?php echo $exam->notification_id; ?>)">Save</button></td>
                                                </tr>
                                            </form>
                                        <?php }
                                    $i++;  }else {
                                    echo '<tr><td colspan="4" ><b>No Data Found!!</b></td></tr>';
                                } ?>
                                    </tbody>
                                </table>


                                <?php //}else{ ?>
                                <!-- <div class="alert alert-success" id="success_msg" style="display:none;">
                    <strong>Submitted Succesfully!</strong>
                </div>
                <div class="alert alert-danger" id="error_msg" style="display:none;">
                    <strong>Network Error! Please try agin later</strong>
                </div>
                    <form type="post" id="edit_examlist">
                        <div class="table-responsive">
                        <input type="text" name="examlist_id" class="form-control" id="edit_examlist_id" value="<?php echo !empty($examEdit)?$examEdit['examlist_id']:''; ?>" />
                            <table class="table table-bordered table-sm ExaminationList">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Exam Name</th>
                                        <th>Hall Ticket Number</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if(!empty($examlist)) {
                                $i=1; 
                                foreach($examlist as $exam){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $exam->name;?></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="hidden" name="notification_id" id="notification_id" value="<?php echo $exam->notification_id;?>" />
                                                <input type="hidden" name="student_id" id="student_id" value="<?php echo $exam->student_id;?>" />
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                <?php
                                                $student_exam=$this->common->get_student_exam_byid($exam->student_id,$exam->notification_id);
                                                // echo '<pre>';
                                                // print_r($student_exam);
                                                if(!empty($student_exam)){
                                                $i=1; 
                                                foreach($student_exam as $rows){
                                                ?>
                                                <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt"  value="<?php if(!empty($rows['hall_tkt'])){ echo $rows['hall_tkt']; }else{echo '<input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt" >';}?>">
                                                <?php $i++;}}else{ ?>
                                                    <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt"  value="">
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td><button class="btn btn-sm btn-success">Save</button></td>
                                    </tr>
                                <?php }
                                }else {
                                    echo '<tr><td colspan="4" ><b>No Data Found!!</b></td></tr>';
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </form> -->
                                <?php //} ?>
                            </div>
                        </div>
                    </div>


                </div>

                <!--
<div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="profileWrapperHead">
                            <h3>Qualification</h3>
                                </div>
                            <table class="profileWrapper profileWrapperRow">
                                <?php foreach($qualification as $row) {?>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">
                                            <?php echo $row['qualification']." :";?>
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0">
                                                        <?php echo $row['marks']." %";?>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                               <div class="profileWrapperHead">
                            <h3>Other Details</h3>
                            </div>
                            <table class="profileWrapper profileWrapperRow">
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                        Hostel Required :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->stayed_in_hostel; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($userdata->hostel == "yes"){?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Whether the candidate had stayed in any hostel before :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->stayed_in_hostel; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Food habit of student :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo ucfirst($userdata->food_habit); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php if(!empty($hostel_room_details)){?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Hostel Details :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $hostel_room_details['room_number'].",".$hostel_room_details['floor'].",".$hostel_room_details['building_name'];?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Whether the candidate has any medical history of aliment :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->medical_history;?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php if($userdata->medical_history == "yes") {?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Medical Description :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php echo $userdata->medical_description;?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                                <?php if($userdata->transportation == "yes") {?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                        Transportation Details:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php
                                                    echo $this->common->get_name_by_id('tt_transport_stop','name',array("transport_id"=>$userdata->stop)).",";
                                                    echo $this->common->get_name_by_id('tt_transport','route_name',array("transport_id"=>$userdata->place ));
                                                    ?>
                                                </label>
                                             </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
                    </div>
-->
                <div class="alert alert-success" id="success_msg" style="display:none;">
                    <strong>Submitted Succesfully!</strong>
                </div>
                <div class="alert alert-danger" id="error_msg" style="display:none;">
                    <strong>Network Error! Please try agin later</strong>
                </div>


            </div>

            <div id="feedetails" class="tab-pane fade">
                <!-- <h3>Fee Details</h3>
                <hr class="hrCustom"> -->
                <form id="feepayment_form" method="POST" action="<?php echo base_url().'Transactions';?>">
                <div class="row">
                    <div class="col-12" id="studfeedetails">
                        
                    </div>
                </div>
                </form>
            </div>

            <div id="myschedule" class="tab-pane fade">
                <h3>My schedule</h3>
                <hr class="hrCustom">
                <div class="row">
                    <div class="col-12">
                        <div id='calendar111' class="full_calender_wrap"></div>
                    </div>
                </div>
            </div>
            <div id="studAttendance" class="tab-pane fade">
                <div id="attendance" class="tab-pane"></div>
            </div>
            <div id="myexams" class="tab-pane fade">
            <div class="series-wapper quiz">
        <div class="container">
            <div class="series-wapper-header d-flex justify-space-between align-self">
                <h3>Quiz <span>Getting Started with InVision</span></h3>
                <div class="d-flex align-items-center mb-30">
                    <button class="btn">Back to Course </button>
                </div>
            </div>
            <div class="quiz-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Github command to deploy comits?</h5>
                                <div class="card-text lessons">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio" name="example" value="customEx">
                                        <label class="custom-control-label" for="customRadio">Custom radio</label>
                                      </div>
                                      <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio2" name="example" value="customEx">
                                        <label class="custom-control-label" for="customRadio2">Custom radio</label>
                                      </div>
                                      <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio3" name="example" value="customEx">
                                        <label class="custom-control-label" for="customRadio3">Custom radio</label>
                                      </div>
                                      <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio4" name="example" value="customEx">
                                        <label class="custom-control-label" for="customRadio4">Custom radio</label>
                                      </div>
                                </div>

                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-space-between">
                                    <button class="btn btn-light">Skip</button>
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- <div id="loadmyexam" class="tab-pane"></div> -->
            </div>
            <div id="stud_Materials" class="tab-pane fade">
                <div id="materials" class="tab-pane"></div>
            </div>
            <div id="stud_Materialsa" class="tab-pane fade">
            <!-- <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Take a Test</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Take a Test</li>
            </ol>
        </div>
    </div> -->
    <div class="series-wapper">
        <div class="container">
            <div class="series-wapper-header d-flex justify-space-between align-self">
                <h3>Series</h3>
                <div class="d-flex align-items-center mb-30">
                    <span class="mr-2 bold text-muted">Sort:</span> <select class="form-control form-inline">
                        <option value="1">Course Name</option>
                        <option value="2">Price</option>
                        <option value="3">Author</option>
                    </select>
                </div>
            </div>
            <div class="series-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                                <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                            <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                            <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                            <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                            <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                            <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                            <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                                <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image">
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Chapter 1 Sensations and Responses</h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><i class="fa fa-book" aria-hidden="true"></i> 25 Lessons </p>
                                    <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                        4 hours</p>
                                </div>
                                <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div>
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
                <!-- <div id="loadstudymaterials" class="tab-pane"></div> -->
            </div>
            <div id="studLeave" class="tab-pane fade">
                <h3>Leave Request</h3>
                <hr class="hrCustom">
                <p>Some content in menu 2.</p>
            </div>
            
            <div id="studProgress" class="tab-pane fade">
            <div id="loadattmpt" style="display:none;">
            </div>
            <span id="loadexamrslt">
            <!-- <div class="container breadcrumb-boxs">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Take a Test</li>
                </ol>
            </div> -->
                <div class="col-md-12"><h3 class="cus-title">Exam Results </h3></div>
                <div class="col-md-12">
                    <div class="dash-box-shadow exam-box">
                        <dv class="d-flex justify-space-between align-self">
                            <!-- <h3>Exam Schedule</!-->
                            <!-- <a href="#">View all</!-->
                        </dv>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Course</th>
                                        <th>Test Result</th>
                                        <th>Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $exams = $this->common->get_examsby_student($this->session->userdata('user_id'));
                                $i=1; if(!empty($exams)){
                                      foreach($exams as $row){?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['class_name'];//echo $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $row->course_id));
?></td>
                                        <td>
                                        <a data-toggle="pill" href="#studProgressattempt"  onclick="loadresult('<?php echo $row['course_id'] ?>')" >view</a>
                                        <!-- <a href="<?php echo base_url();?>student-dashboard-result/<?php echo $row['course_id']; ?>" >view</a> -->
                                        </td>
                                        <td>
                                        <!-- href="<?php echo base_url();?>student-certificate/<?php echo $row['course_id']; ?>"  -->
                                        <a href="#" class="createcertificate" id="<?php echo $row['course_id'] ?>" style="pointer:cousor;">View</a>
                                        </td>
                                    </tr>
                                       <?php $i++; } }?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </span>
                <!-- <p id="loadprogressreport"></p> -->
            </div>
            <div id="stdMessenger" class="tab-pane fade">  
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                        <div class="white_card">
                            <h6>Messenger</h6>
                            <hr>
                            <!-- Data Table Plugin Section Starts Here -->     
                            <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_gs">
                            Start New Conversation        </button>
                            <div class="nav_profile">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link personal_details active" data-toggle="pill" href="#Unread">Unread</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link educational_qualification" data-toggle="pill" href="#Read" onclick="readTable('Read')">Read</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link work_experience  show" data-toggle="pill" href="#Archive" onclick="readTable('Archive')">Archive</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="Unread">
                                    <table class="table table-bordered table-sm ExaminationList">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <th>Subject</th>
                                                <th>Date &amp; Time</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php $id=$this->session->userdata('user_primary_id'); if(!empty($conversations)){foreach($conversations as $conv){if($conv['status']==0 && $conv['archieved']==0){?>
                                                <tr>
                                                    <td>
                                                        <?php if($conv['from']==$id){$name = $conv['to_name'];}else{$name = $conv['from_name'];} ?>
                                                        <?php echo $name;?>
                                                    </td>
                                                    <td><?php echo $conv['subject'];?></td>
                                                    <td><?php echo date('M-d h:i a',strtotime($conv['started_date']));?></td>
                                                    <td><button onClick='showMessage(<?php echo $conv['id']; ?>)' class="fa fa-eye" data-toggle="tooltip" title="View Message"></button></td>
                                                </tr>
                                            <?php }}} ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="Read">
                                    
                                </div>
                                <div class="tab-pane fade" id="Archive">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                        <div class="white_card chatview" id="chat_box">
                           
                        </div>
                        </div>
                        <div id="conversation_identifier"></div>
                    </div>
                </div>
            <div id="homeworks" class="tab-pane fade">
                <h3>Homeworks</h3>
                <hr class="hrCustom">
                <p id="load_homework">dfgfd</p>
            </div>
        </div>
    </div>
</div>
</section>
<div id="add_gs" class="modal fade modalCustom" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Start a new conversation</h4>
            </div>
            <form id="conversationform" method="post" enctype="multipart/form-data">
                <?php //echo form_open_multipart('user/Student/start_conversation',array('id'=>'conversationform')) ?>
            <div class="modal--body">
                <div class="darkblue_card ">
                    <div class="col-md-12">
                        <div class="form-group  studentconversation">
                            <label>To</label><span class="req redbold"> *</span>
                            <select name='to[]' placeholder='Select another user' class='form-control select2' multiple="multiple" data-bv-notempty="true"
                                        data-bv-notempty-message="Please select user" id="students">
                                <?php 
                                // show($members);
                                    foreach($members as $mem){
                                ?>
                                    <option value="<?php echo $mem->personal_id;?>"><?php echo $mem->name."( ".$mem->registration_number." )";?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" /> 
                        </div>
                        <div class="form-group">
                            <label>Subject</label><span class="req redbold"> *</span>
                            <input type='text' name='subject' placeholder='Conversation Subject' class='form-control' data-bv-notempty="true"
                                        data-bv-notempty-message="The subject is required and cannot be empty">
                        </div>
                        <div class="form-group">
                            <label>Message</label><span class="req redbold"> *</span>
                            <textarea rows='7' name='message' placeholder='Type your message here' class='form-control' rows="10" data-bv-notempty="true"
                                        data-bv-notempty-message="The message is required and cannot be empty"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment (Max File Size 25MB)</label>
                            <input type='file' name='attachment' id='userfile' class='form-control'><br>
                            <small>valid format: pdf,png,xlsx,docx,xls,jpg,doc & jpeg</small>
                            <div id="attachment_error" style="color:red;"> </div>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <div class="col-lg-12 col-md-2 col-sm-2 col-xs-2">
                <div class="chat-sub">
                    <a id='but_im' class="btn btn-success pull-right"> <span class="fa fa-paper-plane"></span></a>
                    <button id='sub_im' type='submit' class="btn btn-success pull-right"> <span class="fa fa-paper-plane"></span></button>
                </div>
            </div>
          </div>
          </form>
        </div>
    </div>
</div>

<div id="view_study_material" class="modal fade form_box modalCustom" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        $('.circlechart').circlechart();
        $('.proggress-line').LineProgressbar({
            percentage: 90,
            radius: '3px',
            height: '5px',
        });
    </script>
<script>

function view_study_material(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('user/Student/show_study_material'); ?>",
            type: "post",
            data: {'id':id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#body').html(obj.html);
                    $('#title').html(obj.title);
                    $('#view_study_material').modal('toggle');
                   
                }else{
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
            }
        });
    }  
    
   
    $(".loader").hide();
    $("#chat_box").show();
    function showMessage(id){
        // alert(id);
        $(".loader").show();
        $("#chat_box").hide();
        var ci = "<input type='hidden' value='"+id+"' id='c_id'>";
        $.ajax({
            url: "<?php echo base_url('user/Student/get_messages') ?>",
            type: "POST",
            data: {id:id,from:<?php echo $this->session->userdata['user_id']; ?>,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (response)
            {
                readTable('Unread');
                // alert(response);
                $(".loader").hide();
                $("#chat_box").show();
                $("#chat_box").html(response);
                $("#conversation_identifier").html(ci);
                $("#chat_box::before").hide();

            }
        });
    }
    function sendMessage(){
        var message = $('#message_text').val();
        var conv_id = $('#c_id').val();
        // if (conv_id == undefined){
        //     conv_id = <?php echo $this->uri->segment(2); ?>
        // }
        // var don = message +" Don "+ conv_id;
        // alert(don);
        $.ajax({
                url: "<?php echo base_url('user/Student/send_message') ?>",
                type: "POST",
                data: {message: message,conv_id:conv_id,from:<?php echo $this->session->userdata['user_id']; ?>,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#boxscroll").prepend(data);
                    $("#message_text").val('');
                }
            });
    }
    $(document).ready(function() {
        $(".select2").select2();

        $("#but_im").hide();
        $('#userfile').bind('change', function () {
            if (this.files[0].size > 26214400) {
                $("#img_err").show();
                $("#img_err").html("<span style='color:red'>*Maximum allowed file size is 25MB. Please select another file</span>");
                $("#but_im").show();
                $("#sub_im").hide();
            } else {
                $("#img_err").html("");
                $("#but_im").hide();
                $("#sub_im").show();
                $("#img_err").hide();
            }
        });
    });
    var add_validation = 0;
        $("form#conversationform").validate({
            rules: {
                "to[]": {required: true},
                "subject": {required: true},
                "message": {required: true}
            },
            messages: {
                "to[]": {required: "Please select a recipient"},
                "subject": {required: "Please enter a subject"},
                "message": {required: "Please enter a message"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if($("#userfile").val() != ''){
                    var file=$("#userfile").get(0).files[0].name;
                    if(file){
                        var file_size = $("#userfile").get(0).files[0].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file.split('.').pop().toLowerCase();
                            if(ext!='pdf' && ext!='png' && ext!='xlsx' && ext!='docx' && ext!='doc' && ext!='xls' && ext!='jpg' && ext!='jpeg'){
                                $("#attachment_error").html('<br><span>Invalid file format</span>');
                                add_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            add_validation = 1;
                        }else{
                            $("#attachment_error").html('<br><span>file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?></span>');
                            add_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
            }
        });
        $("form#conversationform").submit(function(e) {
            e.preventDefault();
            // alert(add_validation);
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>user/Student/start_conversation',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        add_validation = 0;
                        // alert(response);
                        $('#add_gs').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $("#students").val('').trigger('change');
                            $('#conversationform').trigger("reset");
                            showMessage(obj.id); 
                            // $(".select2").reset();
                        }else if(obj.st == 0){
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
        function readTable(id){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('user/Student/get_conversation') ?>",
                type: "POST",
                data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (response)
                {
                    // alert(response);
                    $(".loader").hide();
                    if(id == 'Read'){
                        $("#Read").html(response);
                    }
                    else if(id == 'Archive'){
                        $("#Archive").html(response);
                    }else if(id == 'Unread'){
                        $("#Unread").html(response);
                    }
                }
            });
        }


        function loadresult(id){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('user/Student/get_attemptresult') ?>",
                type: "POST",
                data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (response)
                {
                    $(".loader").hide();
                    $("#loadattmpt").show();
                    $("#loadexamrslt").hide();
                        $("#loadattmpt").html(response);
                   
                }
            });
        }


        function msgarchive(id){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('user/Student/archive_conversation') ?>",
                type: "POST",
                data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (response){
                    $(".loader").hide();
                    var obj = JSON.parse(response);
                    if(obj.st == 1){
                        $.toaster({priority:'success',title:'Success',message:obj.msg});
                        readTable('Read');
                    }else if(obj.st == 0){
                        $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                    }
                }
            });
        }


        /* -----------------------------------------------------
  Pure CSS Progress Bars
  GitHub Project: https://github.com/rkchauhan/pure-css-progress-bars/
  By: Ravikumar Chauhan
  Find me on -
  Twitter: https://twitter.com/rkchauhan01
  Facebook: https://www.facebook.com/ravi032chauhan
  GitHub: https://github.com/rkchauhan
  CodePen: http://codepen.io/rkchauhan
-------------------------------------------------------- */
$(document).ready(function() {



$('.progressStart').on('click', function() {
  var perent = $(this).closest("div").attr("id");
  $('#' + perent).progress_fnc({ type: 'start' });
});

$('.progressReset').on('click', function() {
  var perent = $(this).closest("div").attr("id");
  $('#' + perent).progress_fnc({ type: 'reset' });
});

});


(function($) {

$.fn.progress_fnc = function(options) {
  var settings = $.extend({
    type: 'start'
  }, options);

  var div = $(this);
  var progress = div.find('.cssProgress');

  progress.each(function() {
    var self = $(this);
    var progress_bar = self.find('.cssProgress-bar');
    var progress_label = self.find('.cssProgress-label, .cssProgress-label2');
    var progress_value = progress_bar.data('percent');
    var percentage = parseInt(progress_value, 10) + '%';

    progress_bar.css({'width': '0%', 'transition': 'none', '-webkit-transition': 'none', '-moz-transition': 'none'});

    if(settings.type == 'start') {

      progress_bar.animate({
        width: percentage
      }, {
        duration: 1000,
        step: function(x) {
          progress_label.text(Math.round(x) + '%');
        }
      });
      
    } else if(settings.type == 'reset') {
      progress_bar.css('width', '0%');
      progress_label.text('0%');
    }

  });
}

}(jQuery));

$('.owl-carousel').owlCarousel({
    loop:true,
    margin:20,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:2,
            nav:true,
            loop:false
        }
    }
})

</script>
<?php $this->load->view("user/scripts/user_script"); ?>
