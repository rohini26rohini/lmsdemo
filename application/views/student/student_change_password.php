<section class="nav_profile">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a data-toggle="pill" href="#studDashboard" class="active">Dashboard </a></li>
            <!-- <li><a data-toggle="pill" href="#studProfile">Profile</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li>
            <li><a data-toggle="pill" href="#myexams" id="studentexams">My Exams</a></li>
            <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Progress Report</a></li>
            <li><a data-toggle="pill" href="#studMaterials">Study Materials</a></li>
            <li><a data-toggle="pill" href="<?php echo base_url('backoffice/messenger');?>"><?php echo $this->lang->line('messenger');?> </a></li> -->
        </ul>
    </div>
</section>

<section class="profile_page">
    <div class="container">
        <div class="tab-content">
            <div class="tab-pane fade  active show">
                <div class="ChangePswd">
                    <h4><?php echo $this->lang->line('change_password');?></h4>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                           <form id="password_form"> 
                          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />      
                    <div class="form-group">
                        <label><?php echo $this->lang->line('old_password');?></label><span style="color: #ed1c24"> *</span>
                        <input type="password" class="form-control" placeholder="Old Password" id="old" name="old_password">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('new_password');?></label><span style="color: #ed1c24"> *</span>
                        <input type="password" class="form-control" placeholder="New Password" id="new" name="new_password">
                    </div>
		    <div class="form-group">
                        <label><?php echo $this->lang->line('confirm_password');?></label><span style="color: #ed1c24"> *</span>
                        <input type="password" class="form-control" placeholder="Confirm Password" id="retype" name="retype_password">
                    </div>
                    <div class="">
                        <button class="btn btn-info btn-submit">Submit</button>
                    </div>
                        </form>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="studDashboard" class="tab-pane fade   show">
                <h3>Dashboard</h3>
                <p>Some content in menu 1.</p>
            </div>
            <div id="studProfile" class="tab-pane fade">
                <h3>Profile</h3>
                <hr class="hrCustom">
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
                                City:
                                <div class="media-body">
                                    <label class="mt-0 ml-2 mb-0"><?php $city_id= $userdata->district;
                                             echo $this->common->get_name_by_id('cities','name',array('id' => $city_id));
                                            ?></label>
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
                                            ?></label>
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

                                            ?></label>
                                </div>
                            </div>
                        </th>
                    </tr>

                </table>
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
            <div id="studProgress" class="tab-pane fade">
                <h3>Progress Report </h3>
                <p id="loadprogressreport"></p>
            </div> 

            <div id="studMaterials" class="tab-pane fade">
                <h3>Study Materials</h3>
                <p>Some content in menu 1.</p>
            </div>
<!--            <div id="studLeave" class="tab-pane fade">
                <h3>Leave Request</h3>
                <p>Some content in menu 2.</p>
            </div>
            <div id="studProgress" class="tab-pane fade">
                <h3>Progress Report </h3>
                <p>Some content in menu 1.</p>
            </div>
-->

        </div>
    </div>
</section>
<!--
<section class="nav_profile">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a data-toggle="pill" href="#my_profile" class="active">Dashboard </a></li>
                <li class="active"><a data-toggle="pill" href="#my_profile" class="active">My Profile </a></li>
                <li><a data-toggle="pill" href="#my_course">My Course </a></li>
                <li><a data-toggle="pill" href="#tutorials">Tutorials </a></li>
                <li><a data-toggle="pill" href="#my_results">My Results </a></li>
                <li><a data-toggle="pill" href="#study_materials">Study Materials </a></li>
                <li><a data-toggle="pill" href="#schedules">Schedules </a></li>
                <li><a data-toggle="pill" href="#notfication">Notification </a></li>
        </ul>
    </div>
</section>
<section class="profile_page">
    <form id="onlinepayform" method="post">
    <div class="container">
        Comming Soon
    </div>
</form>
</section>
-->
<?php $this->load->view("user/scripts/user_script"); ?>
<?php $this->load->view("student/scripts/change_password_script"); ?>
