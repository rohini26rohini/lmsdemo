<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <?php if(isset($staff)){// echo '<pre>';print_r($staff);?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="white_card ">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#view1">Personnel Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#view2"> Educational Qualifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#view3"> Work Experience</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#view4"> Documents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#view5">For Approval</a>
                           <!-- <a class="nav-link getbatchdetails" data-toggle="pill" href="#view5"> For Approval</a>-->
                        </li>
                        <?php if($staff['role_name']=="Faculty"){ ?>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="pill" href="#view6"> Subjects</a>
                        </li>
                        <?php } ?>
                    </ul>

                    <div id="view_staff" class="tab-content">
    <!------------------------------------------- Personal Details ------------------------------------------>
                        <div id="view1" class=" tab-pane active">
                            <div class="avathar_wrap">
                                <div class="avathar_img" style="background-image: url(<?php echo base_url();?><?php echo $staff['staff_image'];?>);"></div>
                                <table class="table table_register_view">
                                    <tbody>
                                        <tr>
                                            <th width="50%" colspan="2">Staff Id:
                                                <label>&nbsp;&nbsp;<?php echo $staff['registration_number']; ?></label>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">Name:
                                                <label>&nbsp;&nbsp;<?php echo $staff['name']; ?></label>
                                            </th>
                                            <th width="50%">Role :
                                                <label>&nbsp;&nbsp;<?php echo $staff['role_name'];?></label>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">Date of Birth:
                                                <label>&nbsp;&nbsp;<?php echo $staff['dob']; ?></label>
                                            </th>
                                            <th width="50%">Gender :
                                                <label>&nbsp;&nbsp;<?php echo $staff['gender'];?></label>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">Marital Status:
                                                <label>&nbsp;&nbsp;<?php echo $staff['marital_status']; ?></label>
                                            </th>
                                            <th width="50%">Spouse Name :
                                                <label>&nbsp;&nbsp;<?php echo $staff['spouse_name'];?></label>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th width="50%">Height in Cm:
                                                <label>&nbsp;&nbsp;<?php echo $staff['height']; ?></label>
                                            </th>
                                            <th width="50%">Weight :
                                                <label>&nbsp;&nbsp;<?php echo $staff['weight'];?></label>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Data Table Plugin Section Starts Here -->
                            </div>
                            <table class="table table_register_view">
                                <tbody>
                                    <tr>
                                        <th width="50%">Blood Group:
                                            <label>&nbsp;&nbsp;<?php echo $staff['blood_group'];?></label>
                                        </th>
                                        <th width="50%">Primary Contact No/Mobile:
                                            <label>&nbsp;&nbsp;<?php echo $staff['mobile'];?></label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">LandLine Number:
                                            <label>&nbsp;&nbsp;<?php echo $staff['landline'];?></label>
                                        </th>
                                        <th width="50%">Email:
                                            <label>&nbsp;&nbsp;<?php echo $staff['email'];?></label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">Permanent Address:
                                            <label>&nbsp;&nbsp;<?php echo $staff['permanent_address'];?></label>
                                        </th>
                                        <th width="50%">Address for Communication:
                                            <label>&nbsp;&nbsp;<?php echo $staff['communication_address'];?></label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">Country:
                                            <label>&nbsp;&nbsp;<?php echo $staff['countryname'];//echo $this->db->get_where('cities', array('id' => $staff['father_city']))->row()->name; ?></label>
                                        </th>
                                        <th width="50%">State:
                                            <label>&nbsp;&nbsp;<?php echo $staff['statename'].', '.$staff['countryname'];//echo $this->db->get_where('states', array('id' => $staff['father_state']))->row()->name; ?></label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">City:
                                            <label>&nbsp;&nbsp;<?php echo $staff['cityname'];//echo $this->db->get_where('cities', array('id' => $staff['father_city']))->row()->name; ?></label>
                                        </th>
                                        <th width="50%" style="text-align:unset">Professional body registration(if applicable):
                                            <label>&nbsp;&nbsp;<?php echo $staff['body_reg'];//echo $this->db->get_where('states', array('id' => $staff['father_state']))->row()->name; ?></label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">Aadhaar Card No. :
                                            <label>&nbsp;&nbsp; <?php echo $staff['aadhar_no']?></label>
                                        </th>
                                        <th width="50%">PAN No. :
                                            <label>&nbsp;&nbsp; <?php echo $staff['pan_no']?></label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">Bank Account No. :
                                            <label>&nbsp;&nbsp; <?php echo $staff['ac_no']?></label>
                                        </th>
                                        <th width="50%">IFSC code:
                                            <label>&nbsp;&nbsp;<?php echo $staff['ifsc_code']?></label>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <?php   if($this->session->userdata('role')=='cch'|| $this->session->userdata('role')=='cce') { ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                                <div class="time_table">
                                    <h5>Conversion Rate </h5>
                                    <ul>
                                        <!--
                                        <li><span>Todays
                                            <?php echo (isset($conversion))?$conversion['today_converted_call']:'';?>/<?php echo (isset($conversion))?$conversion['today_received_call']:'';?> - </span>Rate : <?php
                                            $percentage = 0;
                                            if(isset($conversion) && $conversion['today_received_call']>0) {
                                            $rate = $conversion['today_converted_call']/$conversion['today_received_call'];
                                            $percentage = $rate*100;
                                            }
                                            echo $percentage.'%';
                                            ?>
                                        </li>
                                        -->
                                        <li><span>Total
                                            <?php echo (isset($conversion))?$conversion['totalcall_converted']:'';?>/<?php echo (isset($conversion))?$conversion['totalcall_courserelated']:'';?> - </span>Rate : <?php
                                            $percentage = 0;
                                            if(isset($conversion) && $conversion['totalcall_courserelated']>0) {
                                            $rate = $conversion['totalcall_converted']/$conversion['totalcall_courserelated'];
                                            $percentage = $rate*100;
                                            }
                                            echo number_format($percentage,2).'%';
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php  }?>
                        </div>




    <!-------------------------------------- Educational Qualifications  ------------------------------------>
                        <div id="view2" class=" tab-pane fade">
                            <?php
                            if(!empty($staff['education'])){
                            $i=1;
                            foreach($staff['education'] as $edu){ ?>
                                <?php
                                if($edu['category']=='Classx'){?>
                                    <div class="row">
                                        <div class=" col-12">
                                            <div class="form-group">
                                                <label class="legendlabel">Class X or Below</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="outline">
                                        <div class="row">
                                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Specification : <?php echo $edu['specification']?></label>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>School/College : <?php echo $edu['school']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Year of Passing : <?php echo $edu['passing_year']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Marks in Percentage : <?php echo $edu['marks']?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label>University/Institute with City &amp; State : <?php echo $edu['university']?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else if($edu['category']=='Classxii'){ ?>
                                    <div class="row">
                                        <div class=" col-12">
                                            <div class="form-group">
                                                <label class="legendlabel">Class XII or Equivalent</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="outline">
                                        <div class="row">
                                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Specification : <?php echo $edu['specification']?></label>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>School/College : <?php echo $edu['school']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Year of Passing : <?php echo $edu['passing_year']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Marks in Percentage : <?php echo $edu['marks']?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label>University/Institute with City &amp; State : <?php echo $edu['university']?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else if($edu['category']=='Degree'){ ?>
                                    <div class="row">
                                        <div class=" col-12">
                                            <div class="form-group">
                                                <label class="legendlabel">Degree/Diploma</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="outline">
                                        <div class="row">
                                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Specification : <?php echo $edu['specification']?></label>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>School/College : <?php echo $edu['school']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Year of Passing : <?php echo $edu['passing_year']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Marks in Percentage : <?php echo $edu['marks']?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label>University/Institute with City &amp; State : <?php echo $edu['university']?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else if($edu['category']=='PG'){ ?>
                                    <div class="row">
                                        <div class=" col-12">
                                            <div class="form-group">
                                                <label class="legendlabel">P.G. & Above</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="outline">
                                        <div class="row">
                                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Specification : <?php echo $edu['specification']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>School/College : <?php echo $edu['school']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Year of Passing : <?php echo $edu['passing_year']?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Marks in Percentage : <?php echo $edu['marks']?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label>University/Institute with City &amp; State : <?php echo $edu['university']?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="row">
                                        <div class=" col-12">
                                            <div class="form-group">
                                                <label class="legendlabel">Additional Qualifications</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="outline">
                                        <div class="row">
                                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Specification : <?php echo $edu['specification']?></label>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label>Marks in Percentage : <?php echo $edu['marks']?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php $i++; }} ?>
                        </div>

<!---------------------------------------- Work Experience  ---------------------------------------------->
                        <div id="view3" class=" tab-pane fade">
                            <?php
                            if(!empty($staff['experience'])){
                            $i=1;
                            foreach($staff['experience'] as $exp){ ?>
                                <table class="table table_register_view" style="wisth:100%">
                                    <tbody>
                                        <tr>
                                            <th width="50%">
                                                <div class="media">Previous Designation :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['designation']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th width="50%">
                                                <div class="media">Previous Department :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['department']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">
                                                <div class="media">From :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['from_date']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th width="50%">
                                                <div class="media">To :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['to_date'];?></label>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">
                                                <div class="media">Total Service In Year(E.g. : 5.6 ) :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['total_service']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th width="50%">
                                                <div class="media">Institution :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['institution']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">
                                                <div class="media">City :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['name']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th width="50%">
                                                <div class="media">Mode of Separation :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['mode_of_separation']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">
                                                <div class="media">PF Account Status :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php if($exp['pf_status']==1){ echo "Active";}else{ echo "Closed";}?></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th width="50%">
                                                <div class="media">PF Account No. :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $exp['pf_ac_no']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php $i++; } }?>
                        </div>

<!---------------------------------------- Documents  ---------------------------------------------->
                        <div id="view4" class=" tab-pane fade">
                            <div class="table-responsive table_language">
                                <table class="table table_register_view table-bordered table-sm table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Document Name</th>
                                            <th>Document File</th>
                                            <th>Verified</th>
                                        </tr>
                                        <?php
                                        if(!empty($staff['documents'])){
                                        $i=1;
                                        foreach($staff['documents'] as $doc) { 
                                        ?>
                                        <tr>
                                            <td>
                                                <label>&nbsp;&nbsp;<?php echo $i; ?></label>
                                            </td>
                                            <td>
                                                <label>&nbsp;&nbsp;<?php if(!empty($doc['education_id'])){ echo $doc['specification']; }else{echo $doc['document_name'];}?></label>
                                            </td>
                                            <td>
                                                <label>&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url().$doc['file']; ?>">View document</a></label>
                                                <!-- <label>&nbsp;&nbsp;<a href="<?=base_url('backoffice/Employee/view_document/'.$doc['staff_documents_id'])?>" target="_blank">View document</a></label> -->
                                            </td>
                                            <td>
                                                <label>&nbsp;&nbsp;<?php if($doc['verification']=='1'){echo "Yes";}else{echo "No";}?></label>
                                            </td>
                                        </tr>
                                        <?php $i++;} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

<!---------------------------------------- For Approval  ---------------------------------------------->
                        <div id="view5" class=" tab-pane fade">
                            <table class="table table_register_view" style="wisth:100%">
                                <tbody>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">Designation :
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $staff['designation'];  ?></label>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="50%">
                                            <div class="media">Department :
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $staff['department']; ?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">Reporting Officer/Line Manager :
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0">
                                                        <?php 
                                                         $staff_id= $staff['reporting_head'];
                                                        echo $this->common->get_name_by_id('am_staff_personal','name',array("personal_id"=>$staff_id));
                                                        ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="50%">
                                            <div class="media">Entry Type :
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0"><?php echo $staff['entry_type']?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php if($staff['entry_type']!="Permanent"){ ?>
                                        <tr>
                                            <th width="50%">
                                                <div class="media">From :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $staff['start_date']?></label>
                                                    </div>
                                                </div>
                                            </th>
                                            <th width="50%">
                                                <div class="media">To :
                                                    <div class="media-body">
                                                        <label class="mt-0 ml-2 mb-0"><?php echo $staff['end_date'];?></label>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    <?php  } ?>
                                    <tr>
                                        <th width="50%">
                                            <div class="media">Branch :
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0">
                                                        <?php 
                                                       $branch= $staff['branch'];
                             echo $this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$branch));
                                                        ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="50%">
                                            <div class="media">Centre :
                                                <div class="media-body">
                                                    <label class="mt-0 ml-2 mb-0">
                                                        <?php
                                                       $center= $staff['center'];
                             echo $this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$center));
                                                        ?></label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

<!-------------------------------------------- Subject  ------------------------------------------------>
                        <div id="view6" class=" tab-pane fade">
                            <div class="table-responsive table_language PirSub">
                                <span class="text-center primary">Primary Subject</span>
                                <table class="table table_register_view table-bordered table-sm table-striped ">
                                    <tbody>
                                        <tr>
                                        </tr>
                                        <tr>
                                            <!-- <th>Sl. No.</th> -->
                                            <th>Subject</th>
                                            <th>Strong Modules</th>
                                            <th>Weak Modules</th>
                                        </tr>
                                        <tr>
                                        <?php
                                        $i=0;
                                        if(!empty($staff['subjects'])){
                                            foreach($staff['subjects'] as $sub) {
                                                $subject_name   = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$sub['parent_subject_id']));
                                                $strong_modules = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$sub['strong_subject_id']));
                                                $weak_modules   = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$sub['weak_subject_id']));
                                                $i++;
                                            if($i==1){
                                            ?>
                                                <!-- <td><label>1</label></td> -->
                                                <td>
                                                    <label>
                                                        <?php echo $subject_name;?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <?php
                                                        $strong_module =   explode(',',$sub['strong_subject_id']);
                                                        $count = count($strong_module);
                                                        for($i=0;$i<$count;$i++){
                                                            echo "<li>".$this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$strong_module[$i]))."</li>";
                                                        }
                                                        ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <?php
                                                        $weak_module =   explode(',',$sub['weak_subject_id']);
                                                        $count = count($weak_module);
                                                        for($i=0;$i<$count;$i++){
                                                            echo "<li>".$this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$weak_module[$i]))."</li>";
                                                        }
                                                        ?>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php }} }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive table_language PirSub">
                                <span class="text-center primary">Other Subject</span>
                                <table class="table table_register_view table-bordered table-sm table-striped ">
                                    <tbody>
                                        <tr>
                                        </tr>
                                        <tr>
                                            <!-- <th>Sl. No.</th> -->
                                            <th>Subject</th>
                                            <th>Strong Modules</th>
                                            <th>Weak Modules</th>
                                        </tr>
                                        <tr>
                                        <?php
                                        $i=0;
                                        if(!empty($staff['subjects'])){
                                            foreach($staff['subjects'] as $sub) {
                                                $subject_name   = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$sub['parent_subject_id']));
                                                $strong_modules = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$sub['strong_subject_id']));
                                                $weak_modules   = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$sub['weak_subject_id']));
                                            $i++;
                                            if($i!=1){
                                            ?>
                                                <!-- <td>
                                                    <label>
                                                        <?php echo $i;?>
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label>
                                                        <?php echo $subject_name;?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <ul>
                                                    <?php
                                                        $strong_module =   explode(',',$sub['strong_subject_id']);
                                                        $count = count($strong_module);
                                                        for($i=0;$i<$count;$i++){
                                                            echo "<li>".$this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$strong_module[$i]))."</li>";
                                                        }
                                                        ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                    <?php
                                                        $weak_module =   explode(',',$sub['weak_subject_id']);
                                                        $count = count($weak_module);
                                                        for($i=0;$i<$count;$i++){
                                                            echo "<li>".$this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$weak_module[$i]))."</li>";
                                                        }
                                                        ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php }} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
<!-------------------------------------------------------------------------------------------------------->
                    </div>
                </div>
            </div>
        </div>
    <?php }else{?>
    <?php }?>
</div>
<?php $this->load->view("admin/scripts/student_view_script");?>

