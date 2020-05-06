<style>
    .select2-container--open{
        z-index:99999999!important;
    }
    </style>
<?php //echo $userdata->student_image;
            if(isset($userdata) && $userdata->student_image!='') {
               $profile_img =  base_url().$userdata->student_image; 
            } else {
               $profile_img =  base_url().'assets/images/profile_img.png';
            }
            ?>
<section class="nav_profile ">
    <div class="container">
        <ul class="nav nav-pills ">
            <li <?php if($this->uri->segment(1) != 'messenger'){ echo 'class="active"';} ?>><a data-toggle="pill" href="#studDashboard" <?php if($this->uri->segment(1) != 'messenger'){ echo 'class="active"';} ?>>Dashboard </a></li>
            <li><a data-toggle="pill" href="#studProfile">Profile</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li>
            <li><a data-toggle="pill" href="#myexams" id="studentexams">My Exams</a></li>
            <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Progress Report</a></li>
            <li><a data-toggle="pill" href="#studMaterials">Study Materials</a></li>
            <!-- <li><a data-toggle="pill" href="<?php echo base_url('backoffice/messenger');?>"><?php echo $this->lang->line('messenger');?> </a></li> -->
            <li style="position:relative;"><a data-toggle="pill" href="#stdMessenger" <?php if($this->uri->segment(1) == 'messenger'){ echo 'class="active"';} ?>><?php echo $this->lang->line('messenger');?> </a>
            <?php if($notifyCount != 0){
                        echo '<span class="messanger-noty">'.$notifyCount.'</span>';
                    }?>
            </li>
            <li><a data-toggle="pill" href="#homeworks" id="homework_list">Homeworks</a></li>
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

<?php if(!empty($notification)) { ?>
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
                                <span><?php echo $row->name;?></span>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<section class="profile_page chat-box">
    <div class="container">
        <div class="tab-content">
            <div id="studDashboard" class="tab-pane fade  <?php if($this->uri->segment(1) != 'messenger'){ echo ' active show';}?>">
                <h3>Dashboard</h3>
                <hr class="hrCustom">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                        <div class="Dboard">
                            <h3>Upcoming 5 sections</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm ExaminationList">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th class="text-left">Module</th>
                                            <th class="text-left">Faculty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                if(!empty($sections)) {
                                                    foreach($sections as $section){ //echo '<pre>';print_r($section);
                                                ?>
                                        <tr>
                                            <td><?php echo date('d-M-Y', strtotime($section->schedule_date));?></td>
                                            <td><?php echo date('g:i a', strtotime($section->schedule_start_time)).' - '.date('g:i a', strtotime($section->schedule_end_time));?></td>
                                            <td class="text-left"><?php echo $section->subject_name;?></td>
                                            <td class="text-left"><?php echo $section->name?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="Reg">
                            <div class="profile_details_img" style="background-image: url(<?php echo $profile_img;?>);"></div>
                            <h4><?php echo (isset($userdata) && $userdata->name!='')?$userdata->name:'';?></h4>
                            <span>Reg: #<?php echo (isset($userdata) && $userdata->registration_number!='')?$userdata->registration_number:'';?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="studProfile" class="tab-pane fade">
                <!--
                    
                    <h3>Profile</h3>
                    <hr class="hrCustom">
-->
                <!--
                    <table class="profileWrapper">
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
                        <tr>
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
                                        $course_id= $this->common->get_name_by_id('am_student_course_mapping','course_id',array('student_id' => $studentid));
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
                                        $batch_id= $this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id' => $studentid));
                                        echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array('batch_id' => $batch_id));
                                        ?>
                                    </label>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
-->
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
                                        $course_id= $this->common->get_name_by_id('am_student_course_mapping','course_id',array('student_id' => $studentid));
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
                                        $batch_id= $this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id' => $studentid));
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
                                                    <?php echo $hostel_room_details['room_number']." , ".$hostel_room_details['floor']." , ".$hostel_room_details['building_name'];?>
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
                                    <div class="alert alert-success" id="success_msg" style="display:none;">
                                        <strong>Submitted Succesfully!</strong>
                                    </div>
                                    <div class="alert alert-danger" id="error_msg" style="display:none;">
                                        <strong>Network Error! Please try agin later</strong>
                                    </div>
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
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                            <?php
                                                    $student_exam=$this->common->get_student_exam_byid($exam->student_id,$exam->notification_id);
                                                    if(!empty($student_exam)){
                                                    $j=1; 
                                                    foreach($student_exam as $rows){
                                                    ?>
                                                            <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" value="<?php if(!empty($rows['hall_tkt'])){ echo $rows['hall_tkt']; }?>">
                                                            <?php }$j++;}else{ ?>
                                                            <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" value="">
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
                <?php// print_r($examEdit);if(isset($examEdit)){ ?>
                <div class="alert alert-success" id="success_msg" style="display:none;">
                    <strong>Submitted Succesfully!</strong>
                </div>
                <div class="alert alert-danger" id="error_msg" style="display:none;">
                    <strong>Network Error! Please try agin later</strong>
                </div>


            </div>

            <div id="myschedule" class="tab-pane fade">
                <h3>My schedule</h3>
                <hr class="hrCustom">
                <div class="row">
                    <div class="col-8">
                        <div id='calendar' class="full_calender_wrap"></div>
                    </div>
                </div>
            </div>
            <div id="studAttendance" class="tab-pane fade">
                <div id="attendance" class="tab-pane"></div>
            </div>
            <div id="myexams" class="tab-pane fade">
                <!--
                <h3>My Exams </h3>
                            <hr class="hrCustom">
-->
                <div id="loadmyexam" class="tab-pane"></div>
            </div>
            <div id="studMaterials" class="tab-pane fade">
                <h3>Study Materials</h3>
                <hr class="hrCustom">
                <p>Some content in menu 1.</p>
            </div>
            <div id="studLeave" class="tab-pane fade">
                <h3>Leave Request</h3>
                <hr class="hrCustom">
                <p>Some content in menu 2.</p>
            </div>
            <div id="studProgress" class="tab-pane fade">
                <h3>Progress Report </h3>
                <hr class="hrCustom">
                <p id="loadprogressreport"></p>
            </div>
            <div id="stdMessenger" class="tab-pane fade<?php if($this->uri->segment(1) == 'messenger'){ echo ' active show';} ?> ">  
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
<div id="add_gs" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close glyphicon glyphicon-remove" data-dismiss="modal"></button>
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
                                    $id = $this->session->userdata['user_id'];
                                    foreach($members as $mem){if($id != $mem->user_id){
                                ?>
                                    <option value="<?php echo $mem->personal_id;?>"><?php echo $mem->name."( ".$mem->registration_number." )";?></option>
                                <?php }} ?>
                            </select>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" /> 
                        </div>
                        <div class="form-group">
                            <label>Subject</label><span class="req redbold"> *</span>
                            <input type='text' name='subject' placeholder='Conversation Subject' class='form-control' data-bv-notempty="true"
                                        data-bv-notempty-message="The subject is required and cannot be empty">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea rows='7' name='message' placeholder='Type your message here' class='form-control' rows="10" data-bv-notempty="true"
                                        data-bv-notempty-message="The message is required and cannot be empty"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment (Max File Size 25MB)</label>
                            <input type='file' name='attachment' id='userfile' class='form-control'>
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
<script>
    $(".loader").hide();
    $("#chat_box").show();
    function showMessage(id){
        $(".loader").show();
        $("#chat_box").hide();
        var ci = "<input type='hidden' value='"+id+"' id='c_id'>";
        $.ajax({
            url: "<?php echo base_url('user/Student/get_messages') ?>",
            type: "POST",
            data: {id:id,from:<?php echo $this->session->userdata['user_id']; ?>,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (response)
            {
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
                "subject": {required: true}
            },
            messages: {
                "to[]": {required: "Please select a recipient"},
                "subject": {required: "Please enter a subject"}
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
                    }
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
</script>
<?php $this->load->view("user/scripts/user_script"); ?>
