<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
<?php if(isset($studView)){ //show($studView);?>
    <input type="hidden" id="student_id" value="<?php echo $studView['student_id'];?>" />
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="white_card tab">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#view1">Personnel Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#view3"> Qualifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#view2"> Other Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#view4"> Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link getbatchdetails" data-toggle="pill" href="#view5" <?php if($studView['status'] != 1) echo 'style="display:none;"'; ?>> Batch Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link getpaymentdetails" data-toggle="pill" href="#view6" <?php if($studView['status'] != 1) echo 'style="display:none;"'; ?>> Payment Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link getcoursedetails" data-toggle="pill" href="#view7" <?php if($studView['status'] != 1) echo 'style="display:none;"'; ?>> Course Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link studentattendance" data-toggle="pill" href="#attendance" <?php if($studView['status'] != 1) echo 'style="display:none;"'; ?>>Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link studentprogress" data-toggle="pill" href="#progressreport" <?php if($studView['status'] != 1) echo 'style="display:none;"'; ?>>Progress Report</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link studentprogress" data-toggle="pill" href="#mentordetails">Mentor Details</a>
                    </li> -->
                </ul>
                <div id="view_student" class="tab-content">
                    
                    <div id="view1" class=" tab-pane active">
                        <div class="avathar_wrap avathar_stud">
                            <div class="avathar_img" style="background-image: url(<?php echo base_url();?><?php echo $studView['student_image'];?>);">
                            </div>
                            <label class="registration_label"><?php echo $studView['registration_number'] ?></label>
                            <table class="table table_register_view">
                                <tbody>
                                    <tr>
                                        <th width="50%" colspan="2">
                                            <div class="media">
                                                Name:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $studView['name'] ?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">
                                                Address:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $studView['address']?></label>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="50%">
                                            <div class="media">
                                                Street:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $studView['street']?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">
                                                State:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $this->db->get_where('states', array('id' => $studView['state']))->row()->name; ?></label>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="50%">
                                            <div class="media">
                                                City:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $this->db->get_where('cities', array('id' => $studView['district']))->row()->name; ?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">
                                                Contact No:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $studView['contact_number']?></label>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="50%">
                                            <div class="media">
                                                Whatsapp No:
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $studView['whatsapp_number']?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Data Table Plugin Section Starts Here -->
                        </div>
                        <table class="table table_register_view">
                            <tbody>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Mobile :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['mobile_number']?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Name Of Guardian:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['guardian_name']?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Email ID:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['email']?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            DOB:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo date('d-m-Y',strtotime($studView['date_of_birth'])); ?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%" >
                                        <div class="media">
                                            Guardian's Contact No:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['guardian_number']?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%" >
                                        <div class="media">
                                           Blood Group:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['blood_group']?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                      <?php   if(!empty($history_details)){ ?>
                        <h6>History</h6>
                        <hr>
                        <div class="table-responsive table_language">
                            <table class="table table-striped table-sm ">
                            <tr>
                                <th>Sl No.</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Reason</th>
                            </tr>
                            <?php
                           $i=1;
                           foreach($history_details as $row){?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row['create_date'])); ?></td>
                                    <td><?php if($row['current_status'] == 1) 
                                             { echo "Active";}else
                                      {
                                        echo "Inactive"; }?></td>
                                    <td><?php echo $row['reason'];?></td>
                                </tr>
                            <?php $i++; } ?>
                            </table>
                        </div>
                        <?php 
} ?>
                    </div>

                    <div id="view2" class=" tab-pane fade">
                        <table class="table table_register_view" style="wisth:100%"> 
                            <tbody>
                                <tr>
                                    <th width="50%">
                                            <div class="media">
                                                     Hostel Required :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['hostel']?></label>
                                            </div>
                                        </div>
                             
                                    </th>
                                    <th width="50%">
                                                  <div class="media">
                                  Whether the candidate had stayed in any hostel before:
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['stayed_in_hostel']?></label>
                                            </div>
                                        </div>

                                    </th>
                                </tr>
                    
                                <?php if($studView['hostel'] == "yes" && !empty($hostel_room_details)){ ?>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                         Building :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $hostel_room_details['building_name'];?></label>
                                            </div>
                                        </div>
                                    </th>
                          
                                    <th width="50%">
                                        <div class="media">
                                         Floor :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $hostel_room_details['floor'];?></label>
                                            </div>
                                        </div>
                                    <th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                         Room Type :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $hostel_room_details['room_type'];?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                         Room No :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $hostel_room_details['room_number'];?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <?php  }?>
                                            <tr>
                                    <th width="50%">
                                          <div class="media">
                                                     Food habit of student :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['food_habit']?></label>
                                            </div>
                                        </div>

                                    </th>
                                    <!-- <th width="50%">
                                        <div class="media">
                                                Whether the candidate has any medical history of aliment :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['medical_history'];?></label>
                                            </div>
                                        </div>
                                    </th> -->
                                    <th width="50%">
                                       <div class="media">
                                            Transportation Required :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php if(!empty($studView['transportation'])) { echo $studView['transportation']; }?></label>
                                            </div>
                                        </div> 
                                    </th>
                                </tr>
                                <?php //if($studView['medical_history'] == "yes"){ ?>
                                <!-- <tr>
                                    <th colspan="2">
                                        <div class="media">
                                        If Yes( medical history of aliment), Details :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $studView['medical_description'];?></label>
                                            </div>
                                        </div>
                                    <th>
                                </tr> -->
                                <?php // }?>
                                <tr>
                                    <!-- <th width="50%">
                                       <div class="media">
                                            Transportation Required :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php if(!empty($studView['transportation'])) { echo $studView['transportation']; }?></label>
                                            </div>
                                        </div> 
                                    </th> -->
                                    <th width="50%">
                                        <div class="media">
                                            Route :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php if(!empty($studView['place'])) {
                                                        echo $this->common->get_name_by_id('tt_transport','route_name',array("transport_id"=>$studView['place'] ));
                                                    }?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%" colspan="2">
                                       <div class="media">
                                            Boarding Point :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php if(!empty($studView['stop'])){
                                                        echo $this->common->get_name_by_id('tt_transport_stop','name',array("transport_id"=>$studView['place'] ));
                                                    } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <!-- <th width="50%" colspan="2">
                                       <div class="media">
                                            Boarding Point :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0">
                                                    <?php if(!empty($studView['stop'])){
                                                        echo $this->common->get_name_by_id('tt_transport_stop','name',array("transport_id"=>$studView['place'] ));
                                                    } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </th> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div id="view3" class=" tab-pane fade">
                        <table class="table table_register_view" style="wisth:100%"> 
                            <tbody>
                                <?php
                                if(!empty($studquali)) {
                                    foreach($studquali as $quali) {
                                        if($quali['marks']!='') {
                                ?>
                                <tr>
<th >
                                        <div class="media">
                                          <?php echo $quali['qualification'];?> :
                                            <div class="media-body">
                                                
                                                <label class="mt-0 ml-2 mb-0"><?php echo $quali['marks']?>(%)</label>
                                            </div>
                                        </div>
                                    </th>
                           
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="view4" class=" tab-pane fade">
                        <div class="table-responsive table_language">
                            <table class="table table_register_view table-bordered table-sm table-striped"> 
                                <tbody>
                                <tr>
                                    <th>Sl.No.</th>
                                    <!-- <th>Qualification</th> -->
                                    <th>Document Name</th>
                                    <th>Document File</th>
                                    <th>Verified</th>
                                    </tr>
                                    <?php
                                    $i=1;
                                    if(!empty($studdocuments)) {
                                        $i=1;
                                        foreach($studdocuments as $documents) {
                                            if($documents['file']!='') {
                                    ?>
                                    <tr>
                                        <td>
                                            <label>&nbsp;&nbsp;<?php echo $i; ?></label>
                                        </td>
                                        <td>
                                            <label>&nbsp;&nbsp;<?php if(!empty($documents['qualification_id'])){ echo $documents['qualification']; }else{echo $documents['document_name'];}?></label>
                                        </td>
                                        <!-- <td>
                                            <label>&nbsp;&nbsp;<?php echo $documents['document_name']?></label>
                                        </td> -->
                                        <td>
                                        <?php if($documents['file']!='') { ?>
                                            <label>&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url($documents['file']);?>">View document</a></label>
                                        <?php } ?>
                                        </td>
                                        <td>
                                            <label>&nbsp;&nbsp;<?php if($documents['verification']=='1'){echo "Yes";}else{echo "No";}?></label>
                                        </td>
                                    </tr>
                                    <?php $i++;}} ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div id="view5" class=" tab-pane fade">
                        
                    </div>
                    
                    <div id="view6" class=" tab-pane fade">
                    </div>
                    
                    <div id="view7" class=" tab-pane fade">
                        
                    </div>
                    
                    <div id="attendance" class=" tab-pane fade">
                        
                    </div>
                    
                    <div id="progressreport" class=" tab-pane fade">
                       
                    </div>

                    <div id="mentordetails" class=" tab-pane fade">
                        <table class="table table_register_view" style="wisth:100%"> 
                            <tbody>
                                <tr>
                                    <th width="50%">
                                        <div class="media">
                                            Mentor :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $meetingArr['name']?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                        <div class="media">
                                            Date  :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $meetingArr['date']?></label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                          <div class="media">
                                            Time :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php echo $meetingArr['time']?></label>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="50%">
                                       <div class="media">
                                            Classroom :
                                            <div class="media-body">
                                                <label class="mt-0 ml-2 mb-0"><?php if(!empty($meetingArr['classroom_name'])) { echo $meetingArr['classroom_name']; }?></label>
                                            </div>
                                        </div> 
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
<!--
        <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
            <div class="white_card  " style="margin: 0;">
                <div id='calendar' class="full_calender_wrap"></div>
            </div>
        </div>
-->
<!--
        <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="time_table">
                    <h5>Monday</h5>
                    <ul>
                        <li><span>09.00-10.00 AM-</span>English</li>
                        <li><span>10.00-11.00 AM-</span>Mathematics</li>
                        <li><span>11.00-12.00 PM-</span>General Science</li>
                        <li><span>12.00-01.00 PM-</span>Physics</li>
                        <li><span>01.00-02.00 PM-</span>Chemistry</li>
                        <li><span>02.00-03.00 PM-</span>Hindi</li>
                        <li><span>03.00-04.00 PM-</span>Biology</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="assignment">
                    <h4>Student Assignment</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="schedule">
                    <h4>Exam Schedule</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                </div>
            </div>
        </div>
    </div>
-->
</div>
<?php }else{?>





<?php }?>
            </div>
<!--
        </div>
    </div>
</div>
-->

<?php $this->load->view("admin/scripts/student_view_script");?>

