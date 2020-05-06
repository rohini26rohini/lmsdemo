<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
<?php if(!isset($callEdit)){?>
    <div class="transparent_card ">
        <form id="filter_form" method="post" action="<?php echo base_url('backoffice/export-callcenter');?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="row filter" id="example">
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="filter_name" id="filter_name" class="form-control filter_class" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" name="filter_course" id="filter_course" class="form-control filter_class" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Primary Contact</label>
                        <input type="text" name="filter_number" id="filter_number"  class="form-control filter_class" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control filter_class" name="filter_status" id="filter_status" >
                            <option value="">Select Status</option>
                            <option value="1">Call Received</option>
                            <option value="2">In Progress</option>
                            <option value="3">Closed</option>
                            <option value="4">Blacklisted</option>
                            <option value="5">Registered</option>
                            <option value="6">Admitted</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label> Street</label>
                        <input type="text" name="filter_place" id="filter_place" class="form-control filter_class" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label> Start Date</label>
                        <input type="text" name="filter_sdate" id="filter_sdate" class="form-control filter_class dates" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label> End Date</label>
                        <input type="text" name="filter_edate" id="filter_edate" class="form-control filter_class dates" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Enquiry Type</label>
                        <input type="text" name="filter_enquiry" id="filter_enquiry"  class="form-control filter_class" placeholder="Search..."/>
                    </div>
                </div>
                <?php
                    if($this->session->userdata('role')=='cch') {
                ?>
                <div class="col-sm-2 col-12">
                    <div class="form-group"> <?php //print_r($staffArr); ?>
                    <label> Call Centre Executive</label>
                        <!-- <input type="text" name="filter_cce" id="filter_cce" class="form-control filter_class" placeholder="Search..."/> -->
                        <select class="form-control filter_class" name="filter_cce" id="filter_cce">
                            <option value="">Select</option>
                            <?php foreach($usersArr as $users){?>
                            <?php  if($users['role']=='cce'){ ?>
                            <option value="<?php  echo $users['personal_id'] ?>"><?php  echo $users['name'] ?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Data Table Plugin Section Starts Here -->
            <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                    <button type="button" class="btn btn-default pagination_nav ">
                        <i class="fa fa-caret-left "></i>
                    </button>
                    <button type="button" class="btn btn-default pagination_nav ">
                        <i class="fa fa-caret-right "></i>
                    </button>
                    <span class="number_records ">
                        Showing 1-10 of 103 records.
                    </span>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right flex-row-reverse ">
                    <button type="button" class="btn btn-default add_row add_new_btn" data-toggle="modal" data-target="#add_call_center">
                        <i class="fa fa-plus "></i>
                    </button>
                </div>
            </div>
            <div id="result">
                <div class="table-responsive">
                    <ul class="data_table" id ="call_center_data">
                        <li class="data_table_head ">
                            <div class="col sl_no ">Sl. No.
                            </div>
                            <div class="col  ">Name
                            </div>
                            <div class="col ">Course
                            </div>
                            <div class="col ">Primary Contact
                            </div>
                            <div class="col ">Street
                            </div>
                            <div class="col ">Timing
                            </div>
                            <div class="col ">Enquiry Type
                            </div>
                            <div class="col ">Status
                            </div>
                            <div class="col actions">Action
                            </div>
                        </li>
                        <?php 
                        $i=1;
                        foreach($call_centerArr as $calls){?>
                        <li id="row_<?php echo $calls['call_id'];?>">
                            <div class="col sl_no ">
                                <?php echo $i;?>
                            </div>
                            <div class="col " id="name_<?php echo $calls['call_id'];?>">
                                <a onclick="get_details('<?php echo $calls['call_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;"> <?php echo $calls['name'];?></a>
                            </div>
                            <div class="col " id="course_id_<?php echo $calls['call_id'];?>">
                                <?php echo $calls['class_name'];?>
                            </div>
                            <div class="col " id="primary_mobile_<?php echo $calls['call_id'];?>">
                                <?php echo $calls['primary_mobile'];?>
                            </div>
                            <div class="col " id="street_<?php echo $calls['call_id'];?>">
                                <?php echo $calls['street'];?>
                            </div>
                            <div class="col " id="timing_<?php echo $calls['call_id'];?>">
                                <?php 
                                $date=strtotime($calls['timing']); 
                                echo date("d/m/Y h:i:s A",$date);


                                // $new_date = str_replace('-', '/', $calls['timing']);
                                // echo date('d/m/Y hh:mm:ss A',strtotime($new_date));
                                ?>
                            </div>
                            <div class="col " id="enquiry_type_<?php echo $calls['call_id'];?>">
                                <?php echo $calls['enquiry_type'];?>
                            </div>
                            <div class="col " id="call_status_<?php echo $calls['call_id'];?>">
                                        <div class="form-group form_zero" >
                                        <select class="form-control" name="call_status_list" id="edit_list_status_<?php echo $calls['call_id'];?>" onchange="get_val(<?php echo $calls['call_id'];?>)">
                                                    <!-- <option value="">Select Status</option> -->
                                                    <?php if($calls['call_status']==1){
                                                        echo '<option selected value="1">Call Received</option>
                                                            <option value="2">In Progress</option>
                                                            <option value="3">Closed</option>
                                                            <option value="4">Blacklisted</option>
                                                            <option value="5">Registered</option>
                                                            <option value="6">Admitted</option>';
                                                    }else if($calls['call_status']==2){
                                                        echo '<option selected value="2">In Progress</option>
                                                            <option value="1">Call Received</option>
                                                            <option value="3">Closed</option>
                                                            <option value="4">Blacklisted</option>
                                                            <option value="5">Registered</option>
                                                            <option value="6">Admitted</option>';
                                                    }else if($calls['call_status']==3){
                                                        echo '<option selected value="3">Closed</option>
                                                            <option value="1">Call Received</option>
                                                            <option value="2">In Progress</option>
                                                            <option value="4">Blacklisted</option>
                                                            <option value="5">Registered</option>
                                                            <option value="6">Admitted</option>';
                                                    }else if($calls['call_status']==4){
                                                        echo '<option selected value="4">Blacklisted</option>
                                                            <option value="1">Call Received</option>
                                                            <option value="2">In Progress</option>
                                                            <option value="3">Closed</option>
                                                            <option value="5">Registered</option>
                                                            <option value="6">Admitted</option>';
                                                    }else if($calls['call_status']==5){
                                                        echo '<option value="4">Blacklisted</option>
                                                            <option value="1">Call Received</option>
                                                            <option value="2">In Progress</option>
                                                            <option value="3">Closed</option>
                                                            <option selected value="5">Registered</option>
                                                            <option value="6">Admitted</option>';
                                                    }else if($calls['call_status']==6){
                                                        echo '<option  value="4">Blacklisted</option>
                                                            <option value="1">Call Received</option>
                                                            <option value="2">In Progress</option>
                                                            <option value="3">Closed</option>
                                                            <option value="5">Registered</option>
                                                            <option selected value="6">Admitted</option>';
                                                    }else{
                                                        echo '<option value="">Select Status</option>
                                                            <option value="1">Answered</option>
                                                            <option value="2">No Answer</option>
                                                            <option value="3">Busy</option>
                                                            <option value="4">Blacklisted</option>
                                                            <option value="5">Registered</option>
                                                            <option value="6">Admitted</option>';
                                                    }
                                                    ?>


                                        </select>
                                        </div>
                            </div>
                            <div class="col actions ">
                                <button type="button" class="btn btn-default option_btn add_new_btn " onclick="get_editdata(<?php echo $calls['call_id'];?>)">
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn  " title="Delete" onclick="delete_call_centers(<?php echo $calls['call_id'];?>)">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                               
                                <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data(<?php echo $calls['call_id'];?>)">
                                Follow Up
                                </button>
                            </div>
                        </li>
                      <?php  //if($i == 1){ ?>
                            <!-- <button class="btn btn-default add_row btn_map btn_print " type="submit">
                                        <i class="fa fa-upload"></i> Export
                                    </button> -->
                           <?php// } ?>
                        <?php $i++;}?>
                    </ul>
                </div>
            <!-- Data Table Plugin Section Starts Here -->
                
           
           <?php if($i!= 1){?>
<!--
            <button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
                <i class="fa fa-upload"></i> Export
            </button>
-->
          <?php  } ?>
            <!-- <a href ="<?php //echo base_url('backoffice/export-callcenter');?>"> -->
            
            <!-- </a> -->
            </div>
        </form>
    </div>
</div>

<div id="add_call_center" class="modal fade form_box" role="dialog">
    <div class="modal-dialog " style="max-width: 80%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Add New Call Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add_call_center_form" method="post">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        
                         <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                            <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id');?>" />
                            <div class="form-group">
                                <label>Enquiry Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="enquiry_type" id="enquiry_type" >
                                    <option value="">Select Enquiry Type</option>
                                    <option value="Course related">Course related</option>
                                    <option value="Fee related">Fee related</option>
                                    <option value="Parent call">Parent call</option>
                                    <option value="General Enquiry">General Enquiry</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                            <label>Name<span class="req redbold">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Name" data-validate="required"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Primary/Whatsapp Number<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="primary_mobile" id="primary_mobile" placeholder="Primary Number" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="course_related">

                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>State<span class="req redbold">*</span></label>
                                <select class="form-control" name="state" id="state">
                                    <option value="">Select</option>
                                    <?php// foreach($stateArr as $state){?>
                                    <option value="<?php //echo $state['id'];?>"><?php //echo $state['name'];?></option>
                                    <?php //} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>City<span class="req redbold">*</span></label>
                                <select class="form-control" name="district" id="district">
                                    <option value="">Select</option>
                                    <?php
                                    //foreach($DistrictArr as $district){?>
                                        <option value="<?php //echo $district['id'];?>"><?php //echo $district['name'];?></option>
                                    <?php //} ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Street Name</label>
                                <input class="form-control" type="text" name="street" placeholder="Street" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Qualification</label>
                                <select class="form-control" name="qualification">
                                    <option value="">Select</option>
                                        <option  >AHSLC</option>
                                        <option  >Anglo Indian School Leaving Certificate</option>
                                        <option  >CBSE Xth</option>
                                        <option  >ICSE Xth</option>
                                        <option  >JTSLC</option>
                                        <option  >Matriculation Certificate</option>
                                        <option  >Secondary School Examination</option>
                                        <option  >SSC</option>
                                        <option  >SSLC</option>
                                        <option  >SSLC with Agricultural Optional</option>
                                        <option  >Standard X Equivalency</option>
                                        <option  >THSLC Xth</option>
                                        <option  >AHSS</option>
                                        <option  >CBSE XIIth</option>
                                        <option  >ICSE XIIth</option>
                                        <option  >Plus 2</option>
                                        <option  >Plus Two Equivalency</option>
                                        <option  >Pre Degree</option>
                                        <option  >Pre University</option>
                                        <option  >Senior Secondary School Examination</option>
                                        <option  >SSSC</option>
                                        <option  >THSE - XII</option>
                                        <option  >VHSE</option>
                                        <option  >VHSE Pass in Trade only for Employment Purpose</option>
                                            <option >B Voc</option>
                                            <option  >BA</option>
                                            <option  >BA Honours</option>
                                            <option  >Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                                            <option  >Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                                            <option  >Bachelor of Design</option>
                                            <option  >Bachelor of Divinity</option>
                                            <option  >Bachelor of Occupational Therapy - BOT</option>
                                            <option  >Bachelor of Science BS</option>
                                            <option  >Bachelor of Science in Applied Sciences</option>
                                            <option  >Bachelor of Textile</option>
                                            <option  >BAL</option>
                                            <option  >BAM</option>
                                            <option  >BAMS</option>
                                            <option  >BArch</option>
                                            <option  >BBA</option>
                                            <option  >BBM</option>
                                            <option  >BBS</option>
                                            <option  >BBS Bachelor of Business Studies</option>
                                            <option  >BBT</option>
                                            <option  >BCA</option>
                                            <option  >BCJ</option>
                                            <option  >BCom</option>
                                            <option  >BComHonours</option>
                                            <option  >BComEd</option>
                                            <option  >BCS - Bachelor of Corporate Secretaryship</option>
                                            <option  >BCVT </option>
                                            <option  >BDS</option>
                                            <option  >BE</option>
                                            <option  >BEd</option>
                                            <option  >BFA</option>
                                            <option  >BFA Hearing Impaired</option>
                                            <option  >BFSc</option>
                                            <option  >BFT</option>
                                            <option  >BHM</option>
                                            <option  >BHMS</option>
                                            <option  >BIL Bachelor of Industrial Law</option>
                                            <option  >BIT</option>
                                            <option  >BLiSc</option>
                                            <option  >BMMC</option>
                                            <option  >BMS - Bachelor of Management Studies</option>
                                            <option  >BNYS</option>
                                            <option  >BPA</option>
                                            <option  >BPE</option>
                                            <option  >BPEd</option>
                                            <option  >BPharm</option>
                                            <option  >BPlan</option>
                                            <option  >BPT</option>
                                            <option  >BRIT - Bachelor of Radiology and Imaging Technology</option>
                                            <option  >BRS - Bachelor in Rehabilitation Scinece</option>
                                            <option  >BRT Bachelor in Rehabilitation Technology</option>
                                            <option  >BSc</option>
                                            <option  >BSc Honours </option>
                                            <option  >BSc Honours Agriculture</option>
                                            <option  >BSc MLT</option>
                                            <option  >BScEd</option>
                                            <option  >BSMS</option>
                                            <option  >BSW</option>
                                            <option  >BTech</option>
                                            <option  >BTHM</option>
                                            <option  >BTM (Honours)</option>
                                            <option  >BTS</option>
                                            <option  >BTTM</option>
                                            <option  >BUMS</option>
                                            <option  >BVA - Bachelor of Visual Arts</option>
                                            <option  >BVC Bachelor of Visual Communication</option>
                                            <option  >BVSC&amp;AH</option>
                                            <option  >Degree from Indian Institute of Forest Management</option>
                                            <option  >Degree in Special Training in Teaching HI/VI/MR</option>
                                            <option  >Graduation in Cardio Vascular Technology</option>
                                            <option  >Integrated Five Year BA,LLB Degree</option>
                                            <option  >Integrated Five Year BCom,LLB Degree</option>
                                            <option  >LLB</option>
                                            <option  >MBBS</option>
                                            <option  >Post Basic B.Sc</option>
                                            <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                                            <option value="BA - MA Integrated">BA - MA Integrated</option>
                                            <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                                            <option value="DM">DM</option>
                                            <option value="DNB">DNB</option>
                                            <option value="LLM">LLM</option>
                                            <option value="M Des  Master of Design">M Des  Master of Design</option>
                                            <option value="MA">MA</option>
                                            <option value="MArch">MArch</option>
                                            <option value="Master in Audiology and Speech Language Pathology(MASLP)">Master in Audiology and Speech Language Pathology(MASLP)</option>
                                            <option value="Master in Software Engineering">Master in Software Engineering</option>
                                            <option value="Master of Applied Science">Master of Applied Science</option>
                                            <option value="Master of Communication">Master of Communication</option>
                                            <option value="Master of Fashion Technology">Master of Fashion Technology</option>
                                            <option value="Master of Health Administration">Master of Health Administration</option>
                                            <option value="Master of Hospital Administration">Master of Hospital Administration</option>
                                            <option value="Master of Human Resource Management">Master of Human Resource Management</option>
                                            <option value="Master of Interior  Architecture and Design">Master of Interior  Architecture and Design</option>
                                            <option value="Master of International Business">Master of International Business</option>
                                            <option value="Master of Journalism and Television Production">Master of Journalism and Television Production</option>
                                            <option value="Master of Management in Hospitality">Master of Management in Hospitality</option>
                                            <option value="Master of Occupational Therapy - MOT">Master of Occupational Therapy - MOT</option>
                                            <option value="Master of Public Health">Master of Public Health</option>
                                            <option value="Master of Rehabilitation Science">Master of Rehabilitation Science</option>
                                            <option value="Master of Rural Development">Master of Rural Development</option>
                                            <option value="Master of Technology (Pharm)">Master of Technology (Pharm)</option>
                                            <option value="Master of Tourism Management">Master of Tourism Management</option>
                                            <option value="Master of Travel and Tourism Management">Master of Travel and Tourism Management</option>
                                            <option value="Master of Urban and Rural Planning">Master of Urban and Rural Planning</option>
                                            <option value=">Master of Visual Communication">Master of Visual Communication</option>
                                            <option value="Master of Womens Studies">Master of Womens Studies</option>
                                            <option value="Masters in Business Law">Masters in Business Law</option>
                                            <option value="MBA">MBA</option>
                                            <option value="MBEM Master of Building Engineering and Management">MBEM Master of Building Engineering and Management </option>
                                            <option value="MCA">MCA</option>
                                            <option value="MCh">MCh</option>
                                            <option value="MCJ">MCJ</option>
                                            <option value="MCom">MCom</option>
                                            <option value="MCP Master in City Planning">MCP Master in City Planning</option>
                                            <option value="MD">MD</option>
                                            <option value="MD Homeo">MD Homeo</option>
                                            <option  >MD SIDHA</option>
                                            <option value="MD SIDHA">MD-Ayurveda</option>
                                            <option value="MDS">MDS</option>
                                            <option value="ME">ME </option>
                                            <option value="MEd">MEd</option>
                                            <option value="MFA">MFA</option>
                                            <option value="MFM Master of Fashion Management">MFM Master of Fashion Management</option>
                                            <option value="MFM Master of Financial Management">MFM Master of Financial Management</option>
                                            <option value="MFSc">MFSc</option>
                                            <option value="MHMS">MHMS</option>
                                            <option value="MHSc CCD">MHSc CCD</option>
                                            <option value="MLA Master of Landscape Architecture">MLA Master of Landscape Architecture</option>
                                            <option value="MLiSc">MLiSc</option>
                                            <option value="MPA">MPA</option>
                                            <option value="MPE">MPE</option>
                                            <option value="MPEd">MPEd</option>
                                            <option value="MPharm">MPharm</option>
                                            <option value="MPhil - Arts">MPhil - Arts</option>
                                            <option value="MPhil - Clinical Psychology">MPhil - Clinical Psychology</option>
                                            <option value="MPhil - Commerce">MPhil - Commerce</option>
                                            <option value="MPhil - Education">MPhil - Education</option>
                                            <option value="MPhil - Futures Studies">MPhil - Futures Studies</option>
                                            <option value="MPhil - Management Studies">MPhil - Management Studies</option>
                                            <option  >Mphil - Medical and Social Psychology">Mphil - Medical and Social Psychology</option>
                                            <option value="MPhil - Physical Education">MPhil - Physical Education</option>
                                            <option value="MPhil - Science">MPhil - Science</option>
                                            <option value="Mphil - Theatre Arts ">Mphil - Theatre Arts </option>
                                            <option value="MPlan">MPlan</option>
                                            <option value="MPT">MPT</option>
                                            <option value="MS Master of Science">MS Master of Science </option>
                                            <option value="MS Master of Surgery">MS Master of Surgery</option>
                                            <option value="MS Pharm">MS Pharm</option>
                                            <option value="MSc">MSc</option>
                                            <option value="MSc 5 years">MSc 5 years</option>
                                            <option value="MSc MLT">MSc MLT</option>
                                            <option value="MScEd">MScEd</option>
                                            <option value="MScTech">MScTech</option>
                                            <option value="MSW">MSW</option>
                                            <option value="MTA">MTA</option>
                                            <option value="MTech">MTech</option>
                                            <option value="MUD Master of Urban Design">MUD Master of Urban Design</option>
                                            <option value="MVA Master of Visual Arts1">MVA Master of Visual Arts</option>
                                            <option value="MVSc">MVSc</option>
                                            <option value="One Year Post Graduate Diploma in Personnel Management and Industrial Relations">One Year Post Graduate Diploma in Personnel Management and Industrial Relations</option>
                                            <option value="P G Diploma in Quality Assurance in Microbiology">P G Diploma in Quality Assurance in Microbiology</option>
                                            <option value="PDCFA">PDCFA</option>
                                            <option value="PG  Diploma (from Other Institutions)">PG  Diploma (from Other Institutions)</option>
                                            <option value="PG  Diploma (from University)">PG  Diploma (from University)</option>
                                            <option value="PG Certificate in  Career Educational Councelling">PG Certificate in  Career Educational Councelling</option>
                                            <option value="PG Certificate in Criminology and Criminal Justice Admin">PG Certificate in Criminology and Criminal Justice Admin.</option>
                                            <option value="PG Diploma in Accomodation Operation and Management">PG Diploma in Accomodation Operation and Management</option>
                                            <option value="PG Diploma in Beauty Therapy">PG Diploma in Beauty Therapy</option>
                                            <option value="PG Diploma in Beauty Therapy and Cosmetology">PG Diploma in Beauty Therapy and Cosmetology</option>
                                            <option value="PG Diploma in Clinical Perfusion">PG Diploma in Clinical Perfusion</option>
                                            <option value="PG Diploma in Dialysis Therapy">PG Diploma in Dialysis Therapy</option>
                                            <option value="PG Diploma in Food Analysis and Quality Assuarance">PG Diploma in Food Analysis and Quality Assuarance</option>
                                            <option value="PG Diploma in Medicine">PG Diploma in Medicine</option>
                                            <option value="PG Diploma in Neuro Electro Physiology">PG Diploma in Neuro Electro Physiology</option>
                                            <option value="PG Diploma in Plastic Processing and Testing">PG Diploma in Plastic Processing and Testing</option>
                                            <option value="PG Diploma in Plastic Processing Technology">PG Diploma in Plastic Processing Technology</option>
                                            <option value="PG Diploma in Wind Power Development">PG Diploma in Wind Power Development</option>
                                            <option value="PG Professional Diploma in Special Education">PG Professional Diploma in Special Education</option>
                                            <option value="PG Translation Diploma English-Hindi">PG Translation Diploma English-Hindi</option>
                                            <option value="PGDBA HR">PGDBA HR</option>
                                            <option value="PGDHRM">PGDHRM</option>
                                            <option value="PGDiploma in Dialysis Technology PGDDT">PGDiploma in Dialysis Technology PGDDT</option>
                                            <option value="Pharm D">Pharm D</option>
                                            <option value="Post Graduate Diploma in AccommodationOperation and Mngmnt">Post Graduate Diploma in AccommodationOperation and Mngmnt</option>
                                            <option value="Post Graduate Diploma in Anaesthesiology (DA)">Post Graduate Diploma in Anaesthesiology (DA)</option>
                                            <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option><option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
                                            <option value="Post Graduate Diploma in Child Health">Post Graduate Diploma in Child Health</option>
                                            <option value="Post Graduate Diploma in Clinical Child Development">Post Graduate Diploma in Clinical Child Development</option>
                                            <option value="Post Graduate Diploma in Clinical Nutrition and Dietetics">Post Graduate Diploma in Clinical Nutrition and Dietetics</option>
                                            <option value="Post Graduate Diploma in Clinical Pathology">Post Graduate Diploma in Clinical Pathology</option>
                                            <option value="Post Graduate Diploma in Clinical Psychology">Post Graduate Diploma in Clinical Psychology</option>
                                            <option value="Post Graduate Diploma in Counselling">Post Graduate Diploma in Counselling</option>
                                            <option value="Post Graduate Diploma in Dairy Development">Post Graduate Diploma in Dairy Development</option>
                                            <option value="Post Graduate Diploma in Dairy Quality Control">Post Graduate Diploma in Dairy Quality Control</option>
                                            <option value="Post Graduate Diploma in Dissaster management">Post Graduate Diploma in Dissaster management</option>
                                            <option value="Post Graduate Diploma in eGovernance">Post Graduate Diploma in eGovernance</option>
                                            <option value="Post Graduate Diploma in Finance and HR Management">Post Graduate Diploma in Finance and HR Management</option>
                                            <option value="Post Graduate Diploma in Financial Management">Post Graduate Diploma in Financial Management</option>
                                            <option value="Post Graduate Diploma in Folk Dance and Cultural studies">Post Graduate Diploma in Folk Dance and Cultural studies</option>
                                            <option value="Post Graduate Diploma in Food Science and Technology">Post Graduate Diploma in Food Science and Technology </option>
                                            <option value="Post Graduate Diploma in International Business Operations">Post Graduate Diploma in International Business Operations</option>
                                            <option value="Post Graduate Diploma in IT Enabled Services and BPO">Post Graduate Diploma in IT Enabled Services and BPO</option>
                                            <option value="Post Graduate Diploma in Journalism">Post Graduate Diploma in Journalism</option>
                                            <option value="Post Graduate Diploma in Journalism and Communication">Post Graduate Diploma in Journalism and Communication</option>
                                            <option value="Post Graduate Diploma in Management">Post Graduate Diploma in Management</option>
                                            <option value="Post Graduate Diploma in Management (PGDM)">Post Graduate Diploma in Management (PGDM)</option>
                                            <option value="Post Graduate Diploma in Management of Learning Disabilities">Post Graduate Diploma in Management of Learning Disabilities</option>
                                            <option value="Post Graduate Diploma in Marine Technology (Mechanical)">Post Graduate Diploma in Marine Technology (Mechanical)</option>
                                            <option value="Post Graduate Diploma in Marketing Management">Post Graduate Diploma in Marketing Management</option>
                                            <option value="Post Graduate Diploma in Nutrition and Dietetics">Post Graduate Diploma in Nutrition and Dietetics</option>
                                            <option value="Post Graduate Diploma in Orthopaedics">Post Graduate Diploma in Orthopaedics</option>
                                            <option value="Post Graduate Diploma in Otorhyno Laryngology">Post Graduate Diploma in Otorhyno Laryngology</option>
                                            <option value="Post Graduate Diploma in Personnel Management">Post Graduate Diploma in Personnel Management</option>
                                            <option value="Post Graduate Diploma in Psychiatric Social Work">Post Graduate Diploma in Psychiatric Social Work</option>
                                            <option value="Post Graduate Diploma in Public Relations">Post Graduate Diploma in Public Relations</option>
                                            <option value="Post Graduate Diploma in Public Relations Management">Post Graduate Diploma in Public Relations Management</option>
                                            <option value="Post Graduate Diploma in Regional/City Planning">Post Graduate Diploma in Regional/City Planning</option>
                                            <option value="Post Graduate Diploma in Software Engineering">Post Graduate Diploma in Software Engineering</option>
                                            <option value="Post graduate Diploma in Town and Country Planning">Post graduate Diploma in Town and Country Planning</option>
                                            <option value="Post Graduate Diploma in Travel and Tourism Management">Post Graduate Diploma in Travel and Tourism Management</option>
                                            <option value="Professional Diploma in Clinical Psychology">Professional Diploma in Clinical Psychology</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Course<span class="req redbold">*</span></label>
                                <select class="form-control" name="course_id" id="course" data-validate="required">
                                    <option value="">Select Course</option>
                                        <?php foreach($courseArr as $course) {
                                        if($course['status']==1) {
                                        ?>
                                    <option value="<?php echo $course['class_id'] ;?>"><?php echo $course['class_name'] ;?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>         
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Branch<span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_id" id="branch_id" data-validate="required">
                                    <option value="0">Select Branch</option>
                                </select>              
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Centre<span class="req redbold"></span></label>
                                <select class="form-control" name="center_id" id="center_id" data-validate="required">
                                    <option value="0">Select Centre</option>
                                </select>              
                            </div>
                        </div>        
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Father Mobile</label>
                                <input class="form-control" type="text" name="father_mobile" id="father_mobile" placeholder="Father Mobile" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Mother Mobile</label>
                                <input class="form-control" type="text" name="mother_mobile" id="mother_mobile" placeholder="Mother Mobile" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Email Id</label>
                                <input class="form-control" type="text" name="email_id" id="email_id" placeholder="Email Id">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Source</label>
                                <input class="form-control" type="text" name="source" placeholder="Source">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group" ><label>Timing</label>
                                <input class="form-control datetime " type="text" name="timing" placeholder="Timing">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Status</label>
                                <select class="form-control" name="call_status" disabled>
                                    <option value="1">Call Received</option>
                                    <option value="2">In Progress</option>
                                    <option value="3">Closed</option>
                                    <option value="4">Blacklisted</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Hostel</label>
                                <select class="form-control" name="hostel">
                                    <option value="">Select Hostel</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Description</label>
                                <input class="form-control" type="text" name="comments" placeholder="Description">
                            </div>
                        </div> -->
                        </div>
                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"></div> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_div">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <button class="btn btn-info">Save</button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                        </div>
                           <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            
                            <div class="table-responsive">
                                <div class="accordion accordion_branch" id="accordionExample">
                                    Please select course and branch to view batch details
                                </div>
                            </div>
                        </div>


                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="follow_up1" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Follow Up</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-pills_admin">
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="pill" href="#head1">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#head2">Add Follow up</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="head1" class="tab-pane active">
                    <p id="errormsg"></p>
                        <form id="history" type="post">
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="call_id" class="form-control" id="history_call_id"/>

                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Description</label>
                                        <input class="form-control" type="text" name="comments" placeholder="Description" id="comments">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time</label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date">

                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status<span class="req redbold">*</span></label>
                                        <select class="form-control" name="status" id="status" data-validate="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Call Received</option>
                                            <option value="2">In Progress</option>
                                            <option value="2">Closed</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive table_language" id="history_view"></div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div id="head2" class="tab-pane">
                    <p id="errormsg"></p>
                        <form id="add_followup" type="post">
                            <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="call_id" class="form-control" id="follow_call_id" />
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time<span class="req redbold">*</span></label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date" data-validate="required">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status<span class="req redbold">*</span></label>
                                        <select class="form-control" name="status" id="status" data-validate="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Answered</option>
                                            <option value="2">No Answer</option>
                                            <option value="3">Busy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Comments</label>
                                        <input class="form-control" type="text" name="comment" placeholder="Comments" id="comment">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-info">Update</button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <!--edit class modal-->
<div id="edit_call_center" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Edit Call Centre</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit_call_center_form" method="post">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="call_id" class="form-control" id="edit_call_id"/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Enquiry Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="enquiry_type" id="edit_enquiry_type" >
                                    <option value="">Select Enquiry Type</option>
                                    <option value="Course related">Course related</option>
                                    <option value="Fee related">Fee related</option>
                                    <option value="Parent call">Parent call</option>
                                    <option value="General Enquiry">General Enquiry</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Name<span class="req redbold">*</span></label>
                                <input type="text" name="name" class="form-control" id="edit_name" data-validate="required"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Primary/Whatsapp Number<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="primary_mobile" placeholder="Primary Number" id="edit_primary_mobile" data-validate="required">
                            </div>
                        </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_course_related">

                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>State<span class="req redbold">*</span></label>
                                <select class="form-control" name="state" id="edit_state">
                                    <option value="">Select</option>
                                    <?php foreach($stateArr as $state){?>
                                    <option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>City<span class="req redbold">*</span></label>
                                <select class="form-control" name="district" id="edit_district">
                                    <option value="">Select</option>
                                    <?php
                                    foreach($DistrictArr as $district){?>
                                        <option value="<?php echo $district['id'];?>"><?php echo $district['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Street Name</label>
                                <input class="form-control" type="text" name="street" placeholder="Street" id="edit_street" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Qualification</label>
                                <select class="form-control" name="qualification" id="edit_qualification">
                              <option value="">Select</option>
                                        <option  >AHSLC</option>
                                        <option  >Anglo Indian School Leaving Certificate</option>
                                        <option  >CBSE Xth</option>
                                        <option  >ICSE Xth</option>
                                        <option  >JTSLC</option>
                                        <option  >Matriculation Certificate</option>
                                        <option  >Secondary School Examination</option>
                                        <option  >SSC</option>
                                        <option  >SSLC</option>
                                        <option  >SSLC with Agricultural Optional</option>
                                        <option  >Standard X Equivalency</option>
                                        <option  >THSLC Xth</option>
                                        <option  >AHSS</option>
                                        <option  >CBSE XIIth</option>
                                        <option  >ICSE XIIth</option>
                                        <option  >Plus 2</option>
                                        <option  >Plus Two Equivalency</option>
                                        <option  >Pre Degree</option>
                                        <option  >Pre University</option>
                                        <option  >Senior Secondary School Examination</option>
                                        <option  >SSSC</option>
                                        <option  >THSE - XII</option>
                                        <option  >VHSE</option>
                                        <option  >VHSE Pass in Trade only for Employment Purpose</option>
                                  <option >B Voc</option>
                                            <option  >BA</option>
                                            <option  >BA Honours</option>
                                            <option  >Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                                            <option  >Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                                            <option  >Bachelor of Design</option>
                                            <option  >Bachelor of Divinity</option>
                                            <option  >Bachelor of Occupational Therapy - BOT</option>
                                            <option  >Bachelor of Science BS</option>
                                            <option  >Bachelor of Science in Applied Sciences</option>
                                            <option  >Bachelor of Textile</option>
                                            <option  >BAL</option>
                                            <option  >BAM</option>
                                            <option  >BAMS</option>
                                            <option  >BArch</option>
                                            <option  >BBA</option>
                                            <option  >BBM</option>
                                            <option  >BBS</option>
                                            <option  >BBS Bachelor of Business Studies</option>
                                            <option  >BBT</option>
                                            <option  >BCA</option>
                                            <option  >BCJ</option>
                                            <option  >BCom</option>
                                            <option  >BComHonours</option>
                                            <option  >BComEd</option>
                                            <option  >BCS - Bachelor of Corporate Secretaryship</option>
                                            <option  >BCVT </option>
                                            <option  >BDS</option>
                                            <option  >BE</option>
                                            <option  >BEd</option>
                                            <option  >BFA</option>
                                            <option  >BFA Hearing Impaired</option>
                                            <option  >BFSc</option>
                                            <option  >BFT</option>
                                            <option  >BHM</option>
                                            <option  >BHMS</option>
                                            <option  >BIL Bachelor of Industrial Law</option>
                                            <option  >BIT</option>
                                            <option  >BLiSc</option>
                                            <option  >BMMC</option>
                                            <option  >BMS - Bachelor of Management Studies</option>
                                            <option  >BNYS</option>
                                            <option  >BPA</option>
                                            <option  >BPE</option>
                                            <option  >BPEd</option>
                                            <option  >BPharm</option>
                                            <option  >BPlan</option>
                                            <option  >BPT</option>
                                            <option  >BRIT - Bachelor of Radiology and Imaging Technology</option>
                                            <option  >BRS - Bachelor in Rehabilitation Scinece</option>
                                            <option  >BRT Bachelor in Rehabilitation Technology</option>
                                            <option  >BSc</option>
                                            <option  >BSc Honours </option>
                                            <option  >BSc Honours Agriculture</option>
                                            <option  >BSc MLT</option>
                                            <option  >BScEd</option>
                                            <option  >BSMS</option>
                                            <option  >BSW</option>
                                            <option  >BTech</option>
                                            <option  >BTHM</option>
                                            <option  >BTM (Honours)</option>
                                            <option  >BTS</option>
                                            <option  >BTTM</option>
                                            <option  >BUMS</option>
                                            <option  >BVA - Bachelor of Visual Arts</option>
                                            <option  >BVC Bachelor of Visual Communication</option>
                                            <option  >BVSC&amp;AH</option>
                                            <option  >Degree from Indian Institute of Forest Management</option>
                                            <option  >Degree in Special Training in Teaching HI/VI/MR</option>
                                            <option  >Graduation in Cardio Vascular Technology</option>
                                            <option  >Integrated Five Year BA,LLB Degree</option>
                                            <option  >Integrated Five Year BCom,LLB Degree</option>
                                            <option  >LLB</option>
                                            <option  >MBBS</option>
                                            <option  >Post Basic B.Sc</option>
                                <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                                            <option value="BA - MA Integrated">BA - MA Integrated</option>
                                            <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                                            <option value="DM">DM</option>
                                            <option value="DNB">DNB</option>
                                            <option value="LLM">LLM</option>
                                            <option value="M Des  Master of Design">M Des  Master of Design</option>
                                            <option value="MA">MA</option>
                                            <option value="MArch">MArch</option>
                                            <option value="Master in Audiology and Speech Language Pathology(MASLP)">Master in Audiology and Speech Language Pathology(MASLP)</option>
                                            <option value="Master in Software Engineering">Master in Software Engineering</option>
                                            <option value="Master of Applied Science">Master of Applied Science</option>
                                            <option value="Master of Communication">Master of Communication</option>
                                            <option value="Master of Fashion Technology">Master of Fashion Technology</option>
                                            <option value="Master of Health Administration">Master of Health Administration</option>
                                            <option value="Master of Hospital Administration">Master of Hospital Administration</option>
                                            <option value="Master of Human Resource Management">Master of Human Resource Management</option>
                                            <option value="Master of Interior  Architecture and Design">Master of Interior  Architecture and Design</option>
                                            <option value="Master of International Business">Master of International Business</option>
                                            <option value="Master of Journalism and Television Production">Master of Journalism and Television Production</option>
                                            <option value="Master of Management in Hospitality">Master of Management in Hospitality</option>
                                            <option value="Master of Occupational Therapy - MOT">Master of Occupational Therapy - MOT</option>
                                            <option value="Master of Public Health">Master of Public Health</option>
                                            <option value="Master of Rehabilitation Science">Master of Rehabilitation Science</option>
                                            <option value="Master of Rural Development">Master of Rural Development</option>
                                            <option value="Master of Technology (Pharm)">Master of Technology (Pharm)</option>
                                            <option value="Master of Tourism Management">Master of Tourism Management</option>
                                            <option value="Master of Travel and Tourism Management">Master of Travel and Tourism Management</option>
                                            <option value="Master of Urban and Rural Planning">Master of Urban and Rural Planning</option>
                                            <option value=">Master of Visual Communication">Master of Visual Communication</option>
                                            <option value="Master of Womens Studies">Master of Womens Studies</option>
                                            <option value="Masters in Business Law">Masters in Business Law</option>
                                            <option value="MBA">MBA</option>
                                            <option value="MBEM Master of Building Engineering and Management">MBEM Master of Building Engineering and Management </option>
                                            <option value="MCA">MCA</option>
                                            <option value="MCh">MCh</option>
                                            <option value="MCJ">MCJ</option>
                                            <option value="MCom">MCom</option>
                                            <option value="MCP Master in City Planning">MCP Master in City Planning</option>
                                            <option value="MD">MD</option>
                                            <option value="MD Homeo">MD Homeo</option>
                                            <option  >MD SIDHA</option>
                                            <option value="MD SIDHA">MD-Ayurveda</option>
                                            <option value="MDS">MDS</option>
                                            <option value="ME">ME </option>
                                            <option value="MEd">MEd</option>
                                            <option value="MFA">MFA</option>
                                            <option value="MFM Master of Fashion Management">MFM Master of Fashion Management</option>
                                            <option value="MFM Master of Financial Management">MFM Master of Financial Management</option>
                                            <option value="MFSc">MFSc</option>
                                            <option value="MHMS">MHMS</option>
                                            <option value="MHSc CCD">MHSc CCD</option>
                                            <option value="MLA Master of Landscape Architecture">MLA Master of Landscape Architecture</option>
                                            <option value="MLiSc">MLiSc</option>
                                            <option value="MPA">MPA</option>
                                            <option value="MPE">MPE</option>
                                            <option value="MPEd">MPEd</option>
                                            <option value="MPharm">MPharm</option>
                                            <option value="MPhil - Arts">MPhil - Arts</option>
                                            <option value="MPhil - Clinical Psychology">MPhil - Clinical Psychology</option>
                                            <option value="MPhil - Commerce">MPhil - Commerce</option>
                                            <option value="MPhil - Education">MPhil - Education</option>
                                            <option value="MPhil - Futures Studies">MPhil - Futures Studies</option>
                                            <option value="MPhil - Management Studies">MPhil - Management Studies</option>
                                            <option  >Mphil - Medical and Social Psychology">Mphil - Medical and Social Psychology</option>
                                            <option value="MPhil - Physical Education">MPhil - Physical Education</option>
                                            <option value="MPhil - Science">MPhil - Science</option>
                                            <option value="Mphil - Theatre Arts ">Mphil - Theatre Arts </option>
                                            <option value="MPlan">MPlan</option>
                                            <option value="MPT">MPT</option>
                                            <option value="MS Master of Science">MS Master of Science </option>
                                            <option value="MS Master of Surgery">MS Master of Surgery</option>
                                            <option value="MS Pharm">MS Pharm</option>
                                            <option value="MSc">MSc</option>
                                            <option value="MSc 5 years">MSc 5 years</option>
                                            <option value="MSc MLT">MSc MLT</option>
                                            <option value="MScEd">MScEd</option>
                                            <option value="MScTech">MScTech</option>
                                            <option value="MSW">MSW</option>
                                            <option value="MTA">MTA</option>
                                            <option value="MTech">MTech</option>
                                            <option value="MUD Master of Urban Design">MUD Master of Urban Design</option>
                                            <option value="MVA Master of Visual Arts1">MVA Master of Visual Arts</option>
                                            <option value="MVSc">MVSc</option>
                                            <option value="One Year Post Graduate Diploma in Personnel Management and Industrial Relations">One Year Post Graduate Diploma in Personnel Management and Industrial Relations</option>
                                            <option value="P G Diploma in Quality Assurance in Microbiology">P G Diploma in Quality Assurance in Microbiology</option>
                                            <option value="PDCFA">PDCFA</option>
                                            <option value="PG  Diploma (from Other Institutions)">PG  Diploma (from Other Institutions)</option>
                                            <option value="PG  Diploma (from University)">PG  Diploma (from University)</option>
                                            <option value="PG Certificate in  Career Educational Councelling">PG Certificate in  Career Educational Councelling</option>
                                            <option value="PG Certificate in Criminology and Criminal Justice Admin">PG Certificate in Criminology and Criminal Justice Admin.</option>
                                            <option value="PG Diploma in Accomodation Operation and Management">PG Diploma in Accomodation Operation and Management</option>
                                            <option value="PG Diploma in Beauty Therapy">PG Diploma in Beauty Therapy</option>
                                            <option value="PG Diploma in Beauty Therapy and Cosmetology">PG Diploma in Beauty Therapy and Cosmetology</option>
                                            <option value="PG Diploma in Clinical Perfusion">PG Diploma in Clinical Perfusion</option>
                                            <option value="PG Diploma in Dialysis Therapy">PG Diploma in Dialysis Therapy</option>
                                            <option value="PG Diploma in Food Analysis and Quality Assuarance">PG Diploma in Food Analysis and Quality Assuarance</option>
                                            <option value="PG Diploma in Medicine">PG Diploma in Medicine</option>
                                            <option value="PG Diploma in Neuro Electro Physiology">PG Diploma in Neuro Electro Physiology</option>
                                            <option value="PG Diploma in Plastic Processing and Testing">PG Diploma in Plastic Processing and Testing</option>
                                            <option value="PG Diploma in Plastic Processing Technology">PG Diploma in Plastic Processing Technology</option>
                                            <option value="PG Diploma in Wind Power Development">PG Diploma in Wind Power Development</option>
                                            <option value="PG Professional Diploma in Special Education">PG Professional Diploma in Special Education</option>
                                            <option value="PG Translation Diploma English-Hindi">PG Translation Diploma English-Hindi</option>
                                            <option value="PGDBA HR">PGDBA HR</option>
                                            <option value="PGDHRM">PGDHRM</option>
                                            <option value="PGDiploma in Dialysis Technology PGDDT">PGDiploma in Dialysis Technology PGDDT</option>
                                            <option value="Pharm D">Pharm D</option>
                                            <option value="Post Graduate Diploma in AccommodationOperation and Mngmnt">Post Graduate Diploma in AccommodationOperation and Mngmnt</option>
                                            <option value="Post Graduate Diploma in Anaesthesiology (DA)">Post Graduate Diploma in Anaesthesiology (DA)</option>
                                            <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option><option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
                                            <option value="Post Graduate Diploma in Child Health">Post Graduate Diploma in Child Health</option>
                                            <option value="Post Graduate Diploma in Clinical Child Development">Post Graduate Diploma in Clinical Child Development</option>
                                            <option value="Post Graduate Diploma in Clinical Nutrition and Dietetics">Post Graduate Diploma in Clinical Nutrition and Dietetics</option>
                                            <option value="Post Graduate Diploma in Clinical Pathology">Post Graduate Diploma in Clinical Pathology</option>
                                            <option value="Post Graduate Diploma in Clinical Psychology">Post Graduate Diploma in Clinical Psychology</option>
                                            <option value="Post Graduate Diploma in Counselling">Post Graduate Diploma in Counselling</option>
                                            <option value="Post Graduate Diploma in Dairy Development">Post Graduate Diploma in Dairy Development</option>
                                            <option value="Post Graduate Diploma in Dairy Quality Control">Post Graduate Diploma in Dairy Quality Control</option>
                                            <option value="Post Graduate Diploma in Dissaster management">Post Graduate Diploma in Dissaster management</option>
                                            <option value="Post Graduate Diploma in eGovernance">Post Graduate Diploma in eGovernance</option>
                                            <option value="Post Graduate Diploma in Finance and HR Management">Post Graduate Diploma in Finance and HR Management</option>
                                            <option value="Post Graduate Diploma in Financial Management">Post Graduate Diploma in Financial Management</option>
                                            <option value="Post Graduate Diploma in Folk Dance and Cultural studies">Post Graduate Diploma in Folk Dance and Cultural studies</option>
                                            <option value="Post Graduate Diploma in Food Science and Technology">Post Graduate Diploma in Food Science and Technology </option>
                                            <option value="Post Graduate Diploma in International Business Operations">Post Graduate Diploma in International Business Operations</option>
                                            <option value="Post Graduate Diploma in IT Enabled Services and BPO">Post Graduate Diploma in IT Enabled Services and BPO</option>
                                            <option value="Post Graduate Diploma in Journalism">Post Graduate Diploma in Journalism</option>
                                            <option value="Post Graduate Diploma in Journalism and Communication">Post Graduate Diploma in Journalism and Communication</option>
                                            <option value="Post Graduate Diploma in Management">Post Graduate Diploma in Management</option>
                                            <option value="Post Graduate Diploma in Management (PGDM)">Post Graduate Diploma in Management (PGDM)</option>
                                            <option value="Post Graduate Diploma in Management of Learning Disabilities">Post Graduate Diploma in Management of Learning Disabilities</option>
                                            <option value="Post Graduate Diploma in Marine Technology (Mechanical)">Post Graduate Diploma in Marine Technology (Mechanical)</option>
                                            <option value="Post Graduate Diploma in Marketing Management">Post Graduate Diploma in Marketing Management</option>
                                            <option value="Post Graduate Diploma in Nutrition and Dietetics">Post Graduate Diploma in Nutrition and Dietetics</option>
                                            <option value="Post Graduate Diploma in Orthopaedics">Post Graduate Diploma in Orthopaedics</option>
                                            <option value="Post Graduate Diploma in Otorhyno Laryngology">Post Graduate Diploma in Otorhyno Laryngology</option>
                                            <option value="Post Graduate Diploma in Personnel Management">Post Graduate Diploma in Personnel Management</option>
                                            <option value="Post Graduate Diploma in Psychiatric Social Work">Post Graduate Diploma in Psychiatric Social Work</option>
                                            <option value="Post Graduate Diploma in Public Relations">Post Graduate Diploma in Public Relations</option>
                                            <option value="Post Graduate Diploma in Public Relations Management">Post Graduate Diploma in Public Relations Management</option>
                                            <option value="Post Graduate Diploma in Regional/City Planning">Post Graduate Diploma in Regional/City Planning</option>
                                            <option value="Post Graduate Diploma in Software Engineering">Post Graduate Diploma in Software Engineering</option>
                                            <option value="Post graduate Diploma in Town and Country Planning">Post graduate Diploma in Town and Country Planning</option>
                                            <option value="Post Graduate Diploma in Travel and Tourism Management">Post Graduate Diploma in Travel and Tourism Management</option>
                                            <option value="Professional Diploma in Clinical Psychology">Professional Diploma in Clinical Psychology</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Course<span class="req redbold">*</span></label>
                                <select class="form-control" name="course_id" id="edit_course" data-validate="required">
                                    <option value="">Select Course</option>
                                    <?php foreach($courseArr as $course){
                                    if($course['status']==1) {
                                    ?>
                                    <option value="<?php echo $course['class_id'];?>"><?php echo $course['class_name'];?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>              
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Branch<span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_id" id="edit_branch" data-validate="required">
                                    <option value="">Select Branch</option>
                                    <?php 
                                    foreach($branchArr as $branch){
                                         $selected = '';
                                         if($call_centerArr['branch_id'] == $branch['branch_master_id']){
                                            $selected = 'selected="selected"';
                                          }
                                          echo '<option value="'.$branch['branch_master_id'].'" '.$selected.'>'.$branch['institute_name'].'</option>'; 
                                        }
                                    ?>
                                </select>              
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Centre<span class="req redbold">*</span></label>
                                <select class="form-control" name="center_id" id="edit_center" data-validate="required">
                                    <option value="">Select Centre</option>
                                </select>              
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Father Mobile</label>
                                <input class="form-control" type="text" name="father_mobile" placeholder="Father Mobile" id="edit_father_mobile" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Mother Mobile</label>
                                <input class="form-control" type="text" name="mother_mobile" placeholder="Mother Mobile" id="edit_mother_mobile" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Email Id</label>
                                <input class="form-control" type="text" name="email_id" placeholder="Email Id" id="edit_email_id">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Source</label>
                                <input class="form-control" type="text" name="source" placeholder="Source" id="edit_source">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Timing</label>
                                <input class="form-control datetime" type="text" name="timing" placeholder="Timing" id="edit_timing">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Status</label>
                                <select class="form-control" name="call_status" id="edit_call_status">
                                    <option value="">Select Status</option>
                                    <option value="1">Call Received</option>
                                    <option value="2">In Progress</option>
                                    <option value="3">Closed</option>
                                    <option value="4">Blacklisted</option>
                                    <option value="5">Registered</option>
                                    <option value="6">Admitted</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Hostel</label>
                                <select class="form-control" name="hostel" id="edit_hostel">
                                    <option value="">Select Hostel</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label> Description</label>
                                <input class="form-control" type="text" name="comments" placeholder="Description" id="edit_comments">
                            </div>
                        </div> -->
                    </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="des_edit_div">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"></div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <button class="btn btn-info">Save</button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!--show details-->
<div id="show" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Caller Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills ">
                    <table class="table table_register_view course_related">
                        <tbody>
                            <tr>
                                <th width="50%">Name:
                                    <label>&nbsp;&nbsp;<span id="name"></span></label>
                                </th>
                                <th width="50%">Course:
                                    <label>&nbsp;&nbsp;<span id="course_id"></span></label>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">Branch:
                                    <label>&nbsp;&nbsp;<span id="branch"></span></label>
                                </th>
                                <th width="50%">Center:
                                    <label>&nbsp;&nbsp;<span id="center"></span></label>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">Qualification:
                                    <label>&nbsp;&nbsp;<span id="qualification"></span></label>
                                </th>
                                <th width="50%">State:
                                    <label>&nbsp;&nbsp;<span id="state_name"></span></label>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">City:
                                    <label>&nbsp;&nbsp;<span id="city"></span></label>
                                </th>
                                <th width="50%">Street:
                                    <label>&nbsp;&nbsp;<span id="street"></span></label>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">Primary No.:
                                    <label>&nbsp;&nbsp;<span id="pmobile"></span></label>
                                </th>
                                <th width="50%">Email Id:
                                    <label>&nbsp;&nbsp;<span id="email"></span></label>
                                </th>
                            </tr> 
                            <tr>
                                <th width="50%">Father Mobile:
                                    <label>&nbsp;&nbsp;<span id="fmobile"></span></label>
                                </th>
                                <th width="50%">Mother Mobile:
                                    <label>&nbsp;&nbsp;<span id="mmobile"></span></label>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">Source:
                                    <label>&nbsp;&nbsp;<span id="show_source"></span></label>
                                </th>
                                <th width="50%">Timing:
                                    <label>&nbsp;&nbsp;<span id="show_timing"></span></label>
                                </th>
                            </tr> 
                            <tr>
                                <th width="50%">Description:
                                    <label>&nbsp;&nbsp;<span id="show_comments"></span></label>
                                </th>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table_register_view other">
                        <tbody>
                            <tr>
                                <th width="50%">Name:
                                    <label>&nbsp;&nbsp;<span id="other_name"></span></label>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">Primary No.:
                                    <label>&nbsp;&nbsp;<span id="other_pmobile"></span></label>
                                </th>
                            </tr> 
                            <tr>
                                <th width="50%">Description:
                                    <label>&nbsp;&nbsp;<span id="show_description"></span></label>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </ul>

                <div class="tab-content">
                    <div id="head1" class="tab-pane active">
                    <p id="errormsg"></p>
                        <form id="history" type="post">
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="call_id" class="form-control" id="history_call_id"/>

                              
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive table_language" id="history_view"></div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div id="head2" class="tab-pane">
                    <p id="errormsg"></p>
                        <form id="add_followup" type="post">
                            <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="call_id" class="form-control" id="follow_call_id" />
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time<span class="req redbold">*</span></label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date" data-validate="required">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status<span class="req redbold">*</span></label>
                                        <select class="form-control" name="status" id="status" data-validate="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Answered</option>
                                            <option value="2">No Answer</option>
                                            <option value="3">Busy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Comments</label>
                                        <input class="form-control" type="text" name="comment" placeholder="Comments" id="comment">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-info">Update</button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php }else{?>





<?php }?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/call_center_script");?>
