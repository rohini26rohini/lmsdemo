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
            <li class="active"><a data-toggle="pill" href="#studDashboard" class="active">Dashboard </a></li>
            <li><a data-toggle="pill" href="#studProfile">Profile</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li>
            <li><a data-toggle="pill" href="#myexams" id="studentexams">My Exams</a></li>
            <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Progress Report</a></li>
            <li><a data-toggle="pill" href="#studMaterials">Study Materials</a></li>
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
                            <span>Exams And Notifications</span>
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

<section class="profile_page">
    <div class="container">
        <div class="tab-content">
            <div id="studDashboard" class="tab-pane fade  active show">
                <h3>Dashboard</h3>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
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
                                                        <td><?php echo date('d-M-Y', strtotime($section->schedule_start_time));?></td>
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
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="NotBox">
                                 <h3>Notification</h3>
                            </div>
                            <div class="NewsNotification">
                                <div class="block-hdnews">
                                    <div class="list-wrpaaer" >
                                        <ul class="list-aggregate" id="marquee-vertical">
                                            <li>
                                                <a href="">Breaking News 1</a>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                </p>
                                            </li>
                                            <li>
                                                <a href="">Breaking News 2</a>
                                                <p>Aliquam consequat nibh in sollicitudin semper. Nam convallis sapien
                                                    nisi, ac vulputate nisi auctor blandit.
                                                    Donec tincidunt varius suscipit. </p>
                                            </li>
                                            <li>
                                                <a href="">Breaking News 3</a>
                                                <p>Ut ut felis suscipit sem porta molestie. Vestibulum ante ipsum primis
                                                    in faucibus orci luctus et ultrices
                                                    posuere cubilia Curae</p>
                                            </li>
                                            <li>
                                                <a href="" title="">Breaking News 4</a>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes,
                                                    nascetur ridiculus mus. In hac habitasse
                                                    platea dictumst. </p>
                                            </li>
                                        </ul>
                                    </div><!-- list-wrpaaer -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="studProfile" class="tab-pane fade">
                    <h3>Profile</h3>
                    <table class="table_content_view table">
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
                                State :
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php $state_id= $userdata->state;
                                        echo $this->common->get_name_by_id('states','name',array('id' => $state_id));
                                        ?>
                                    </label>
                                </div>
                            </div>
                        </th>
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
                                Name of Guardian:
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php echo $userdata->guardian_name;?></label>
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
                                Guardian's Contact No:
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php echo $userdata->guardian_number;?></label>
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

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <h3>Qualification</h3>
                            <table class="table_content_view table">
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
                            <h3>Other Details</h3>
                            <table class="table_content_view table">
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

                <div class="alert alert-success" id="success_msg" style="display:none;">
                    <strong>Submitted Succesfully!</strong>
                </div>
                <div class="alert alert-danger" id="error_msg" style="display:none;">
                    <strong>Network Error! Please try agin later</strong>
                </div>
                <?php  if(isset($examEdit)){ ?>
                    <form  id="examlist" method="post">
                        <div class="table-responsive">
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
                                    //  echo '<pre>';
                                    //  print_r($examlist);
                                $i=1; 
                                foreach($examlist as $exam){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $exam->name;?></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="hidden" name="notification_id[]" id="notification_id" value="<?php echo $exam->notification_id;?>" />
                                                <input type="hidden" name="student_id" id="student_id" value="<?php echo $exam->student_id;?>" />
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                <?php
                                                $student_exam=$this->common->get_student_exam_byid($exam->student_id,$exam->notification_id);
                                                // echo '<pre>';
                                                // print_r($student_exam);
                                                // echo $this->db->last_query();
                                                if(!empty($student_exam)){
                                                $j=1; 
                                                foreach($student_exam as $rows){
                                                ?>
                                                <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" id="hall_tkt"  value="<?php if(!empty($rows['hall_tkt'])){ echo $rows['hall_tkt']; }?>">                                          
                                                    <?php }$j++;}else{ ?>
                                                    <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" id="hall_tkt" value="<?php if(!empty($rows['hall_tkt'])){ echo $rows['hall_tkt']; }?>">
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td><button id="submitbutton<?=$i?>" onclick="submitForm('<?php echo $exam->notification_id;?>')" class="btn btn-sm btn-success">Save</button></td>
                                    </tr>
                                <?php }
                              $i++;  }else {
                                    echo '<tr><td colspan="4" ><b>No Data Found!!</b></td></tr>';
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php }else{ ?>
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
                                    //  echo '<pre>';
                                    //  print_r($examlist);
                                $i=1; 
                                foreach($examlist as $exam){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $exam->name;?></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="hidden" name="edit_examlist_id[]" id="edit_examlist_id" value="<?php echo !empty($examEdit)?$examEdit['examlist_id']:''; ?>" />
                                                <input type="hidden" name="notification_id[]" id="edit_notification_id" value="<?php echo $exam->notification_id;?>" />
                                                <input type="hidden" name="student_id" id="edit_student_id" value="<?php echo $exam->student_id;?>" />
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                <?php
                                                $student_exam=$this->common->get_student_exam_byid($exam->student_id,$exam->notification_id);
                                                // echo '<pre>';
                                                // print_r($student_exam);
                                                if(!empty($student_exam)){
                                                $j=1; 
                                                foreach($student_exam as $rows){
                                                ?>
                                                <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" id="edit_hall_tkt"  value="<?php if(!empty($rows['hall_tkt'])){ echo $rows['hall_tkt']; }else{echo '<input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt" >';}?>">
                                                <?php $j++;}}else{ ?>
                                                    <input type="text" class="form-control" placeholder="Hall Ticket Number" name="hall_tkt[]" id="edit_hall_tkt" value="">
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td><button id="submitbutton<?=$i?>" onclick="submitForm('<?php echo $exam->notification_id;?>')" class="btn btn-sm btn-success">Save</button></td>
                                    </tr>
                                <?php }
                                }else {
                                    echo '<tr><td colspan="4" ><b>No Data Found!!</b></td></tr>';
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php } ?>
            </div>

            <div id="myschedule" class="tab-pane fade">
                <h3>My schedule</h3>
                <div class="row">
                    <div class="col-12">
                        <div id='calendar' class="full_calender_wrap"></div>
                    </div>
                </div>
            </div>
            <div id="studAttendance" class="tab-pane fade">
                <h3>Attendance</h3>
                <div id="attendance" class="tab-pane"></div>
            </div>
            <div id="myexams" class="tab-pane fade">
                <h3>My Exams </h3>
                <div id="loadmyexam" class="tab-pane"></div>
            </div>
            <div id="studMaterials" class="tab-pane fade">
                <h3>Study Materials</h3>
                <p>Some content in menu 1.</p>
            </div>
            <div id="studLeave" class="tab-pane fade">
                <h3>Leave Request</h3>
                <p>Some content in menu 2.</p>
            </div>
            <div id="studProgress" class="tab-pane fade">
                <h3>Progress Report </h3>
                <p>Some content in menu 1.</p>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view("user/scripts/user_script"); ?>