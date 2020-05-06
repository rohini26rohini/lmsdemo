<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <?php if(!isset($staffEdit)){ ?>
        <div class="white_card ">
            <h6>Add Employee</h6>
            <hr/>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active personal_details" data-toggle="pill" href="#personal_details">Personnel Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link educational_qualification disabled tabdisabled" data-toggle="pill" href="" >Educational Qualifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link work_experience disabled tabdisabled" data-toggle="pill" href="">Work Experience</a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link other_details disabled tabdisabled" data-toggle="pill" href="">Other Details</a>
                </li>
                -->
                <li class="nav-item">
                    <a class="nav-link approval disabled tabdisabled" data-toggle="pill" href="">For Approval</a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link proofs disabled tabdisabled" data-toggle="pill" href="">Proof to be submitted</a>
                </li>
                -->
                <li class="nav-item">
                    <a class="nav-link subject disabled tabdisabled" data-toggle="pill" href="">Subject</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="personal_details" class=" tab-pane active">
                    <form id="add_personal_details_form" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="avathar_wrap">
                            <!-- <div class="avathar_img"> -->
                                <div id="blah" class="avathar_img" style="background-image: url(<?php echo base_url();?>assets/images/user_3_Artboard_1-512.png);">
                                    <input type="file"  id="file" name="file_name" onchange="readURL(this);"/>
                                    <div class="img_properties">
                                        <span>Upload .jpg,.jpeg,.png,.bmp files only(Max. Size:2MB)</span>
                                    </div>
                                </div>
                            <!-- </div> -->
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Name<span class="req redbold">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="form-control">
                                                <option>Mr.</option>
                                                <option>Mrs.</option>
                                                <option>Ms.</option>
                                                <option>Dr.</option>
                                            </select>
                                            </div>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" aria-label="Text input with dropdown button" data-validate="required" onkeypress="return valNames(event);">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Role<span class="req redbold">*</span></label>
                                        <select class="form-control" name="role" id="role" data-validate="required">
                                            <option value="">Select Role</option>
                                            <?php foreach($roleArr as $role){
                                                ?>
                                                <option value="<?php echo $role['role']; ?>">
                                                    <?php echo $role['role_name']; ?>
                                                </option>
                                                <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Date Of Birth<span class="req redbold">*</span></label>
                                        <input type="text" class="form-control calendarclass" name="dob" id="dob" placeholder="Date Of Birth" data-validate="required" onkeypress="return ValDate(event)">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" id="gender" placeholder="Gender">
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Trans</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Marital Status</label>
                                        <select class="form-control" name="marital_status" id="marital_status" placeholder="Marital Status">
                                            <option>Single</option>
                                            <option>Married</option>
                                            <option>Divorsed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Spouse Name</label>
                                        <input class="form-control" name="spouse_name" id="spouse_name" placeholder="Spouse Name" onkeypress="return valNames(event);"/>
                                    </div>
                                </div>
                            </div>
                        <!-- Data Table Plugin Section Starts Here -->
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Height in Cm</label>
                                    <input class="form-control numbersOnly" name="height" id="height" placeholder="Height in Cm" maxlength="3"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Weight</label>
                                    <input class="form-control numbersOnly" name="weight" id="weight" placeholder="Weight"  maxlength="3"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select class="form-control" name="blood_group" id="blood_group" placeholder="Gender">
                                        <option>A+</option>
                                        <option>O+</option>
                                        <option>B+</option>
                                        <option>AB+</option>
                                        <option>A-</option>
                                        <option>O-</option>
                                        <option>B-</option>
                                        <option>AB-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Primary Contact No/Mobile No.<span class="req redbold">*</span></label>
                                    <input class="form-control" name="mobile" id="mobile" placeholder="Primary Contact No/Mobile No." onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>LandLine No.</label>
                                    <input class="form-control" name="landline" id="landline" placeholder="LandLine No." onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Email<span class="req redbold">*</span></label>
                                    <input class="form-control" name="email" id="email" placeholder="Email"  type="email"/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Permanent Address<span class="req redbold">*</span></label>
                                    <textarea class="form-control" name="permanent_address" id="permanent_address" placeholder="Permenent Address" data-validate="required" onkeypress="return addressValidation(event);"></textarea>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Address for Communication</label>
                                    <textarea class="form-control" name="communication_address" id="communication_address" placeholder="Address for Communication" onkeypress="return addressValidation(event);"></textarea>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Country<span class="req redbold">*</span></label>
                                    <select class="form-control" name="spouse_country" id="spouse_country">
                                        <option value="">Select Country</option>
                                        <?php foreach($countryArr as $country){?>
                                        <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>State<span class="req redbold">*</span></label>
                                    <select class="form-control" name="spouse_state" id="spouse_state">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>City<span class="req redbold">*</span></label>
                                    <select class="form-control" name="spouse_city" id="spouse_city">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Father's Name</label>
                                    <input class="form-control" name="father_name" id="father_name" placeholder="Father's Name" />
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Occupation</label>
                                    <input class="form-control" name="father_job" id="father_job" placeholder="Occupation" />
                                </div>
                            </div>
                            -->
                            <!--
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="father_country" id="father_country">
                                    <option value="">Select Country</option>
                                    <?php 
                                    foreach($countryArr as $country){
                                    if($country['name']=='India') { $selected	=	'selected="selected"'; } else { $selected = ''; }
                                    echo '<option value="'.$country['name'].'" '.$selected.'>'.$country['name'].'</option>';
                                    }
                                    ?> 
                                    <?php foreach($countryArr as $country){?>
                                    <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>State</label>
                                    <select class="form-control" name="father_state" id="father_state">
                                    <option value="">Select State</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control" name="father_city" id="father_city">
                                    <option value="">Select City</option>
                                </select>
                                </div>
                            </div>
                            -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Professional body registration(if applicable)</label>
                                    <textarea class="form-control" name="body_reg" id="body_reg" data-validate="required" onkeypress="return addressValidation(event);"></textarea>
                                </div>
                            </div>
                            <!--
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Regn. No</label>
                                    <input class="form-control" name="reg_no" id="reg_no" placeholder="Regn. No" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Issue Date</label>
                                    <input class="form-control calendarclass" name="issue_date" id="issue_date" placeholder="Issue Date" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input class="form-control calendarclass" name="exp_date" id="exp_date" placeholder="Expiry Date" />
                                </div>
                            </div>
                            -->
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Aadhar Card No.<span class="req redbold">*</span></label>
                                    <input class="form-control" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No." data-validate="required" onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>PAN Card No.<span class="req redbold">*</span></label>
                                    <input class="form-control" name="pan_no" id="pan_no" placeholder="PAN Card No." data-validate="required"   onkeypress="return txtnumberValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>SBT Account No.<span class="req redbold">*</span></label>
                                    <input class="form-control" name="ac_no" id="ac_no" placeholder="SBT Account No." data-validate="required" onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label> IFSC code<span class="req redbold">*</span></label>
                                    <input class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC code" data-validate="required"  onkeypress="return txtnumberValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn_save">Save</button>
                                    <button class="btn btn-default btn_cancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            
            
                <div id="subject" class=" tab-pane fade">
                    <form id="add_subject_form" method="post">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Strong Area</label>
                                    <select class="form-control" name="strong_subject" id="strong_subject">
                                        <option value="">Select Subject</option>
                                        <?php foreach($subjectArr as $subject){?>
                                        <option value="<?php echo $subject['parent_subject'];?>"><?php echo $subject['subject_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Weak Area</label>
                                    <select class="form-control" name="weak_subject" id="weak_subject" onchange="return get_modules(this.value)">
                                        <option value="">Select Subject</option>
                                        <?php foreach($subjectArr as $subject){?>
                                        <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div id="module_selection_holder"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn_save">Save</button>
                                    <button class="btn btn-default btn_cancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?>
<div class="white_card ">
    <h6>Add Employee</h6>
    <hr/>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active personal_details" data-toggle="pill" href="#personal_details">Personnel Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link educational_qualification" data-toggle="pill" href="#educational_qualification">Educational Qualifications</a>
        </li>
        <li class="nav-item">
            <a class="nav-link work_experience" data-toggle="pill" href="#work_experience">Work Experience</a>
        </li>
        <!--
        <li class="nav-item">
            <a class="nav-link other_details" data-toggle="pill" href="#other_details">Other Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link proofs" data-toggle="pill" href="#proofs">Proof to be submitted</a>
        </li>
        -->
        <li class="nav-item">
            <a class="nav-link approval" data-toggle="pill" href="#approval">For Approval</a>
        </li>
        <?php if(!empty($staffEdit)&& $staffEdit['role']=='faculty') { ?>
        <li class="nav-item">
            <a class="nav-link subject" data-toggle="pill" href="#subject">Subject</a>
        </li>
        <?php } ?>
    </ul>
    <div class="tab-content">
        <div id="personal_details" class=" tab-pane active">
            <form id="edit_personal_details_form" method="post" enctype="multipart/form-data">
                <div class="avathar_wrap">
                    <div class="avathar_img">
                        <div id="blah" class="avathar_img" style="background-image: url(<?php echo base_url();?><?php echo $staffEdit['staff_image'];?>">
                            <input type="file"  id="edit_file" name="file_name" onchange="readURL(this);"/>
                            <div class="img_properties">
                                <span>Upload .jpg,.jpeg,.png,.bmp files only(Max. Size:2MB)</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name<span class="req redbold">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select class="form-control">
                                            <option >Mr.</option>
                                            <option>Mrs.</option>
                                            <option>Ms.</option>
                                            <option>Dr.</option>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" aria-label="Text input with dropdown button" data-validate="required" value="<?php echo !empty($staffEdit)?$staffEdit['name']:''; ?>" onkeypress="return valNames(event);">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Role<span class="req redbold">*</span></label>
                                <select class="form-control" name="role" id="role">
                                    <?php 
                                    $roles = $this->db->get('am_roles')->result_array();
                                    foreach($roles as $row2){
                                    ?>
                                    <option <?php if($staffEdit['role'] == $row2['role']) { echo "Selected"; }?> value="<?php echo $row2['role'];?>">
                                        <?php echo $row2['role_name'];?>
                                    </option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date Of Birth<span class="req redbold">*</span></label>
                                <input type="text" class="form-control calendarclass" data-validate="required" name="dob" id="dob" placeholder="Date Of Birth" value="<?php echo !empty($staffEdit)?$staffEdit['dob']:''; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Gender<span class="req redbold">*</span></label>
                                <select class="form-control" name="gender" id="gender" placeholder="Gender" value="<?php echo !empty($staffEdit)?$staffEdit['gender']:''; ?>">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Trans</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Marital Status<span class="req redbold">*</span></label>
                                <select class="form-control" name="marital_status" id="marital_status" placeholder="Marital Status" value="<?php echo !empty($staffEdit)?$staffEdit['marital_status']:''; ?>">
                                    <option>Single</option>
                                    <option>Married</option>
                                    <option>Divorsed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Spouse Name</label>
                                <input class="form-control" name="spouse_name" id="spouse_name" placeholder="Spouse Name" onkeypress="return valNames(event);" value="<?php echo !empty($staffEdit)?$staffEdit['spouse_name']:''; ?>"/>
                            </div>
                        </div>
                    </div>
                    <!-- Data Table Plugin Section Starts Here -->
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Height in Cm</label>
                            <input class="form-control" name="height" id="height" placeholder="Height in Cm" value="<?php echo !empty($staffEdit)?$staffEdit['height']:''; ?>" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Weight</label>
                            <input class="form-control" name="weight" id="weight" placeholder="Weight" value="<?php echo !empty($staffEdit)?$staffEdit['weight']:''; ?>" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Blood Group<span class="req redbold">*</span></label>
                            <select class="form-control" name="blood_group" id="blood_group" placeholder="Blood Group" value="<?php echo !empty($staffEdit)?$staffEdit['blood_group']:''; ?>">
                                <option>A+</option>
                                <option>O+</option>
                                <option>B+</option>
                                <option>AB+</option>
                                <option>A-</option>
                                <option>O-</option>
                                <option>B-</option>
                                <option>AB-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Primary Contact No/Mobile No.<span class="req redbold">*</span></label>
                            <input class="form-control" name="mobile" id="mobile" placeholder="Mobile No." value="<?php echo !empty($staffEdit)?$staffEdit['mobile']:''; ?>" onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>LandLine No.</label>
                            <input class="form-control" name="landline" id="landline" placeholder="LandLine No." value="<?php echo !empty($staffEdit)?$staffEdit['landline']:''; ?>" onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Email<span class="req redbold">*</span></label>
                            <input class="form-control" name="email" id="email" placeholder="Email" value="<?php echo !empty($staffEdit)?$staffEdit['email']:''; ?>" />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Permenent Address<span class="req redbold">*</span></label>
                            <textarea class="form-control" data-validate="required" name="permanent_address" id="permanent_address" placeholder="Permenent Address" value=""  onkeypress="return addressValidation(event);"><?php echo !empty($staffEdit)?$staffEdit['permanent_address']:''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Address for Communication</label>
                            <textarea class="form-control" name="communication_address" id="communication_address" placeholder="Address for Communication" value=""  onkeypress="return addressValidation(event);"><?php echo !empty($staffEdit)?$staffEdit['communication_address']:''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="spouse_country" id="spouse_country">
                                <option value="">Select Country<span class="req redbold">*</span></option>
                                <?php 
                                    $country = $this->db->get('countries')->result_array();
                                    foreach($country as $row2):
                                    ?>
                                    <option
                                        <?php if($staffEdit['spouse_country'] == $row2['id'])echo 'selected';?> value="<?php echo $row2['id'];?>">
                                        <?php echo $row2['name'];?>
                                    </option>
                                <?php endforeach;  ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>State<span class="req redbold">*</span></label>
                            <select class="form-control" name="spouse_state" id="spouse_state">
                                <option value="">Select State</option>
                                <?php foreach($edit_states as $val){ ?>
                                <option  <?php if($staffEdit['spouse_state'] == $val['id'])echo 'selected';?> value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>City<span class="req redbold">*</span></label>
                            <select class="form-control" name="spouse_city" id="spouse_city">
                                <option value="">Select City</option>
                                 <?php foreach($edit_city as $value){ ?>
                                <option  <?php if($staffEdit['spouse_city'] == $value['id'])echo 'selected';?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Professional body registration(if applicable)</label>
                            <textarea class="form-control" data-validate="required" name="body_reg" id="body_reg"  onkeypress="return addressValidation(event);"><?php echo !empty($staffEdit)?$staffEdit['body_reg']:''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Aadhar Card No.<span class="req redbold">*</span></label>
                            <input class="form-control" data-validate="required" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No." value="<?php echo !empty($staffEdit)?$staffEdit['aadhar_no']:''; ?>" onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>PAN Card No.</label>
                            <input class="form-control" data-validate="required" name="pan_no" id="pan_no" placeholder="PAN Card No." value="<?php echo !empty($staffEdit)?$staffEdit['pan_no']:''; ?>"  onkeypress="return txtnumberValidation(event);" />
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>SBT Account No.</label>
                            <input class="form-control" data-validate="required" name="ac_no" id="ac_no" placeholder="SBT Account No." value="<?php echo !empty($staffEdit)?$staffEdit['ac_no']:''; ?>" onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label> IFSC code</label>
                            <input class="form-control" data-validate="required" name="ifsc_code" id="ifsc_code" placeholder="IFSC code" value="<?php echo !empty($staffEdit)?$staffEdit['ifsc_code']:''; ?>"  onkeypress="return txtnumberValidation(event);" />
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <button class="btn btn-info btn_save">Save</button>
                            <button class="btn btn-default btn_cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

<!----------------------------- Educational Qualifications ---------------------------------->
        <div id="educational_qualification" class=" tab-pane fade">
            <form id="add_educational_qualification_form" method="post">
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
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                                <input name="category[]" value="Classx" type="hidden" />
                                <?php
                                $personal_id = '';
                                if(!empty($staffEdit) && $staffEdit['personal_id']!='') {
                                $personal_id =   $staffEdit['personal_id'];
                                }
                                $Classx = $this->common->get_classx_qualify($personal_id, 'Classx');
                                if(!empty($Classx)){
                                        echo '<input name="education_id[]" value="'.$Classx['education_id'].'" type="hidden"/>';
                                    }
                                ?>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Specification</label>
                                        <select type="text" class="form-control subject_select" name="specification[]">
                                            <?php echo (!empty($Classx) && $Classx['specification']!='')?'<option selected="selected">'.$Classx['specification'].'</option>':'';
                                            ?>
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
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>School/College</label>
                                        <input class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($Classx) && $Classx['school']!='')?$Classx['school']:'';?>" onkeypress="return addressValidation(event);" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Year of Passing</label>
                                        <input class="form-control year" name="passing_year[]" id="passing_year" placeholder="Year of Passing" value="<?php echo (!empty($Classx) && $Classx['passing_year']!='')?$Classx['passing_year']:'';?>" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Marks in Percentage</label>
                                        <input class="form-control" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($Classx) && $Classx['marks']!='')?$Classx['marks']:'';?>" onkeypress="return decimalNum(event);" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>University/Institute with City &amp; State</label>
                                <textarea class="form-control" rows="5" name="university[]" id="university" placeholder="University/Institute with City &amp; State" onkeypress="return addressValidation(event);"><?php echo (!empty($Classx) && $Classx['university']!='')?$Classx['university']:'';?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="legendlabel">Class XII or Equivalent</label>
                        </div>
                    </div>
                </div>
                <div class="outline">
                    <div class="row">
                        <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input name="category[]" value="Classxii" type="hidden" />
                                <?php
                                $Classxii = $this->common->get_classx_qualify($personal_id, 'Classxii');
                                if(!empty($Classxii)){
                                    echo '<input name="education_id[]" value="'.$Classxii['education_id'].'" type="hidden"/>';
                                }
                                ?>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Specification</label>
                                        <select type="text" class="form-control subject_select" name="specification[]">
                                            <?php echo (!empty($Classxii) && $Classxii['specification']!='')?'<option selected="selected">'.$Classxii['specification'].'</option>':'';
                                                ?>
                                            <option value="">Select</option>
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
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>School/College</label>
                                        <input class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($Classxii) && $Classxii['school']!='')?$Classxii['school']:'';?>" onkeypress="return addressValidation(event);" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Year of Passing</label>
                                        <input class="form-control year" name="passing_year[]" id="passing_year" placeholder="Year of Passing" value="<?php echo (!empty($Classxii) && $Classxii['passing_year']!='')?$Classxii['passing_year']:'';?>" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Marks in Percentage</label>
                                        <input class="form-control" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($Classxii) && $Classxii['marks']!='')?$Classxii['marks']:'';?>"  onkeypress="return decimalNum(event);"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>University/Institute with City &amp; State</label>
                                <textarea class="form-control" rows="5" name="university[]" id="university" placeholder="University/Institute with City &amp; State" onkeypress="return addressValidation(event);"><?php echo (!empty($Classxii) && $Classxii['university']!='')?$Classxii['university']:'';?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="legendlabel">Degree/Diploma</label>
                            </div>
                        </div>
                    </div>
                    <div class="outline">
                        <div class="row">
                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                <div class="row">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                    <input name="category[]" value="Degree" type="hidden" />
                                    <?php
                                    $Degree = $this->common->get_classx_qualify($personal_id, 'Degree');
                                    if(!empty($Degree)){
                                            echo '<input name="education_id[]" value="'.$Degree['education_id'].'" type="hidden"/>';
                                        }
                                    ?>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Specification</label>
                                            <select type="text" class="form-control subject_select" name="specification[]">
                                                <?php echo (!empty($Degree) && $Degree['specification']!='')?'<option selected="selected">'.$Degree['specification'].'</option>':'';?>
                                                <option value="">Select</option>
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
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>School/College</label>
                                            <input class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($Degree) && $Degree['school']!='')?$Degree['school']:'';?>" onkeypress="return addressValidation(event);" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Year of Passing</label>
                                            <input class="form-control year" name="passing_year[]" id="passing_year" placeholder="Year of Passing" value="<?php echo (!empty($Degree) && $Degree['passing_year']!='')?$Degree['passing_year']:'';?>" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Marks in Percentage</label>
                                            <input class="form-control" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($Degree) && $Degree['marks']!='')?$Degree['marks']:'';?>"  onkeypress="return decimalNum(event);"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>University/Institute with City &amp; State</label>
                                    <textarea class="form-control" rows="5" name="university[]" id="university" placeholder="University/Institute with City &amp; State" onkeypress="return addressValidation(event);"><?php echo (!empty($Degree) && $Degree['university']!='')?$Degree['university']:'';?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="legendlabel">P.G. &amp; Above</label>
                            </div>
                        </div>
                    </div>
                    <div class="outline">
                        <div class="row">
                            <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                                <div class="row">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                    <input name="category[]" value="PG" type="hidden" />
                                    <?php
                                        $pg = $this->common->get_classx_qualify($personal_id, 'PG');
                                        if(!empty($pg)){
                                            echo '<input name="education_id[]" value="'.$pg['education_id'].'" type="hidden"/>';
                                        }
                                        ?>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Specification</label>
                                            <select type="text" class="form-control subject_select" name="specification[]">
                                                <?php echo (!empty($pg) && $pg['specification']!='')?'<option selected="selected">'.$pg['specification'].'</option>':'';?>
                                                <option  value="" >Select</option>
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
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>School/College</label>
                                            <input class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($pg) && $pg['school']!='')?$pg['school']:'';?>" onkeypress="return addressValidation(event);" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Year of Passing</label>
                                            <input class="form-control year" name="passing_year[]" id="passing_year" placeholder="Year of Passing" value="<?php echo (!empty($pg) && $pg['passing_year']!='')?$pg['passing_year']:'';?>" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Marks in Percentage</label>
                                            <input class="form-control" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($pg) && $pg['marks']!='')?$pg['marks']:'';?>"  onkeypress="return decimalNum(event);"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>University/Institute with City &amp; State</label>
                                    <textarea class="form-control" rows="5" name="university[]" id="university" placeholder="University/Institute with City &amp; State" onkeypress="return addressValidation(event);"><?php echo (!empty($pg) && $pg['university']!='')?$pg['university']:'';?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-12">
                            <div class="form-group">
                                <label class="legendlabel">Additional Qualifications</label>
                            </div>
                        </div>
                    </div>
                    <div class="outline">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                                <input name="category[]" value="Others" type="hidden" />
                                <?php
                                $personal_id = '';
                                if(!empty($staffEdit) && $staffEdit['personal_id']!='') {
                                $personal_id =   $staffEdit['personal_id'];
                                }
                                $Others = $this->common->get_classx_qualify($personal_id, 'Others');
                                if(!empty($Others)){
                                    // echo '<input name="education_id[]" value="'.$Others['education_id'].'" type="text"/>';
                                    $i=3;
                                    $countInitializer = count($Others) + 3;
                                    foreach($Others as $row){
                                        $i++;
                                        echo '<input name="education_id[]" value="'.$row['education_id'].'" type="hidden"/>';
                                        echo '<input type="hidden" name="counter" id="counter" value="'.$countInitializer.'">';
                                ?>
                            </div>
                        </div>
                        <div class="add_wrap" id="new_textbox<?=$i?>">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input name="category[]" value="Others" type="hidden" />
                                        <?php if(!empty($Others)){
                                        // echo '<input name="education_id[]" value="'.$Others['education_id'].'" type="text"/>';
                                        } ?>
                                        <label>Specification</label>
                                        <input class="form-control" name="specification[<?=$i?>]" id="specification" placeholder="specification" value="<?php echo (!empty($row) && $row['specification']!='')?$row['specification']:'';?>" onkeypress="return addressValidation(event);" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Marks in Percentage</label>
                                        <input class="form-control" name="marks[<?=$i?>]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($row) && $row['marks']!='')?$row['marks']:'';?>" onkeypress="return decimalNum(event);" />
                                    </div>
                                </div>
                            </div>
                            <?php if($i==4){ ?>
                                <button type="button" class="btn btn-default add_wrap_pos" id="add_more"><i class="fa fa-plus"></i></button>
                            <?php }else{?>
                                <button class="btn add_wrap_pos btn-info remove_section remove_this" id="delete" type="button"  onclick="delete_others(<?php echo $i;?>,<?php echo $row['education_id'];?>)" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fa fa-remove"></i>
                                </button>
                            <?php } ?>
                        </div>
                        <?php } 
                        }
                        else{ 
                            $i=4;?>
                            <div class="add_wrap" id="new_textbox<?=$i?>">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input name="education_id[]" value="5" type="hidden"/>
                                            <label>Specification</label>
                                            <input class="form-control" name="specification[<?=$i?>]" id="specification" placeholder="specification" value="<?php echo (!empty($row) && $row['specification']!='')?$row['specification']:'';?>" onkeypress="return addressValidation(event);" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Marks in Percentage</label>
                                            <input class="form-control" name="marks[<?=$i?>]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($row) && $row['marks']!='')?$row['marks']:'';?>" onkeypress="return decimalNum(event);" />
                                        </div>
                                    </div>
                                </div>
                                <?php if($i==4){ ?>
                                    <button type="button" class="btn btn-default add_wrap_pos" id="add_more" style="min-width:auto">
                                        <i class="fa fa-plus"></i>
                                </button>
                                <?php }else{?>
                                    <button class="btn add_wrap_pos btn-info remove_section remove_this" type="button"  onclick="delete_others(<?php echo $i;?>,<?php echo $row['education_id'];?>)" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                <?php } ?>
                            </div>
                        <?php   } ?>
                        <div id="more_others"></div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn_save">Save</button>
                                    <button class="btn btn-default btn_cancel">Cancel</button>
                                </div>
                            </div>
                        </div>  
                    </div>  
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------------------------------- Work Experience ------------------------------------------>
        <div id="work_experience" class=" tab-pane fade">
            <form id="add_work_experience_form" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                <?php
                $experience = $this->common->get_staffexperience($personal_id);
                if(!empty($experience)) {
                $i = 0 ;
                foreach($experience as $ex) {
                ?>
                <div id="section_duplicate_edit">
                    <?php if($i==0) {echo '<hr class="no_hr">'; } else { echo '<hr>'; } ?>
                    <div class="add_wrap">
                        <div class="row">
                            <input type="hidden" value="<?php echo $ex['experience_id'];?>" name="experience_id[]">
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input class="form-control" name="designationedit[]" id="designation" placeholder="Designation" value="<?php echo $ex['designation'];?>"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Department</label>
                                    <input class="form-control" name="departmentedit[]" id="department" placeholder="Department" value="<?php echo $ex['department'];?>"  onkeypress="return addressValidation(event);" />
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>From</label>
                                    <input class="form-control calendarclass" name="from_dateedit[]" id="from_date" placeholder="From" value="<?php echo $ex['from_date'];?>" />
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>To</label>
                                    <input class="form-control calendarclass" name="to_dateedit[]" id="to_date" placeholder="To" value="<?php echo $ex['to_date'];?>" />
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Total Service In Year(Ex: 5.6 )</label>
                                    <input class="form-control" name="total_serviceedit[]" id="total_service" placeholder="Total Service" value="<?php echo $ex['total_service'];?>"  onkeypress="return decimalNum(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Institution</label>
                                    <input class="form-control" name="institutionedit[]" id="institution" placeholder="Institution" value="<?php echo $ex['institution'];?>"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control" name="cityedit[]" id="city">
                                        <option value="">Select City</option>
                                        <?php foreach($cityArr as $city){?>
                                        <option value="<?php echo $city['city_id'];?>" <?php echo (isset($ex) && $ex['city']==$city['city_id'])?'selected=""selected':'';?>><?php echo $city['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Mode of Separation</label>
                                    <select class="form-control" name="mode_of_separationedit[]" id="mode_of_separation">
                                        <option value="resignation" <?php echo (isset($ex) && $ex['mode_of_separation']=='resignation')?'selected=""selected':'';?>>Resignation</option>
                                        <option value="termination" <?php echo (isset($ex) && $ex['mode_of_separation']=='termination')?'selected=""selected':'';?>>Termination</option>
                                        <option value="retirement" <?php echo (isset($ex) && $ex['mode_of_separation']=='retirement')?'selected=""selected':'';?>>Retirement</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>PF Account Status</label>
                                    <select class="form-control" name="pf_statusedit[]" id="pf_status">
                                        <option value="1" <?php echo (isset($ex) && $ex['pf_status']==1)?'selected=""selected':'';?>>Active</option>
                                        <option value="2" <?php echo (isset($ex) && $ex['pf_status']==2)?'selected=""selected':'';?>>Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>PF Account No.</label>
                                    <input class="form-control" name="pf_ac_noedit[]" id="pf_ac_no" placeholder="PF Account No." value="<?php echo $ex['pf_ac_no'];?>"  onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                        </div>
                        <?php if($i==0) { ?>
                            <button type="button" id="add_block" class="btn btn-default add_wrap_pos">
                                <i class="fa fa-plus"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" id="" class="btn btn-info add_wrap_pos remove_sectionedit">
                                <i class="fa fa-minus"></i>
                            </button>
                        <?php } ?>
                        </div>
                    </div>
                <?php
                $i++;
                }?>
                <?php } else { ?>
                    <div class="add_wrap">    
                        <div class="row">
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input class="form-control" name="designation[]" id="designation" placeholder="Designation"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Department</label>
                                    <input class="form-control" name="department[]" id="department" placeholder="Department"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>From</label>
                                    <input class="form-control calendarclass" name="from_date[]" id="from_date" placeholder="From" />
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>To</label>
                                    <input class="form-control calendarclass" name="to_date[]" id="to_date" placeholder="To" />
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Total Service in Year[Ex:5.6]</label>
                                    <input class="form-control" name="total_service[]" id="total_service" placeholder="Total Service"  onkeypress="return decimalNum(event);" />
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Institution</label>
                                    <input class="form-control" name="institution[]" id="institution" placeholder="Institution"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control" name="city[]" id="city">
                                        <option value="">Select City</option>
                                        <?php foreach($cityArr as $city){?>
                                        <option value="<?php echo $city['city_id'];?>"><?php echo $city['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Mode of Separation</label>
                                    <select class="form-control" name="mode_of_separation[]" id="mode_of_separation">
                                    <option value="resignation">Resignation</option>
                                    <option value="termination">Termination</option>
                                    <option value="retirement">Retirement</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>PF Account Status</label>
                                    <select class="form-control" name="pf_status[]" id="pf_status">
                                    <option value="1">Active</option>
                                    <option value="2">Closed</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>PF Account No.</label>
                                    <input class="form-control" name="pf_ac_no[]" id="pf_ac_no" placeholder="PF Account No."  onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                            <button type="button" id="add_block" class="btn btn-default add_wrap_pos">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                <?php } ?>

                    <div id="dupliate_wrapper"></div>
                        <div id="section_duplicate" style="display:none;">
                            <hr class="no_hr">
                            <div class="add_wrap">
                                <div class="row">
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input class="form-control" name="designation[]" id="designation" placeholder="Designation"  onkeypress="return addressValidation(event);"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input class="form-control" name="department[]" id="department" placeholder="Department"  onkeypress="return addressValidation(event);"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input class="form-control calendarclass" name="from_date[]" id="from_date" placeholder="From" />
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input class="form-control calendarclass" name="to_date[]" id="to_date" placeholder="To" />
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>Total Service in Year[Ex:5.6]</label>
                                            <input class="form-control" name="total_service[]" id="total_service" placeholder="Total Service"  onkeypress="return decimalNum(event);" />
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Institution</label>
                                            <input class="form-control" name="institution[]" id="institution" placeholder="Institution"  onkeypress="return addressValidation(event);"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>City</label>
                                            <select class="form-control" name="city[]" id="city">
                                                <option value="">Select City</option>
                                                <?php foreach($cityArr as $city){?>
                                                <option value="<?php echo $city['city_id'];?>"><?php echo $city['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>Mode of Separation</label>
                                            <select class="form-control" name="mode_of_separation[]" id="mode_of_separation">
                                                <option value="resignation">Resignation</option>
                                                <option value="termination">Termination</option>
                                                <option value="retirement">Retirement</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>PF Account Status</label>
                                            <select class="form-control" name="pf_status[]" id="pf_status">
                                                <option value="1">Active</option>
                                                <option value="2">Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>PF Account No.</label>
                                            <input class="form-control" name="pf_ac_no[]" id="pf_ac_no" placeholder="PF Account No."  onkeypress="return valNum(event);" />
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info add_wrap_pos remove_section">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- 
                        <div class="add_wrap">
                            <div class="row">
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input class="form-control" placeholder="Designation"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <input class="form-control" placeholder="Department"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input class="form-control" placeholder="From"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                    <div class="form-group">
                                        <label>To</label>
                                        <input class="form-control" placeholder="To"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                    <div class="form-group">
                                        <label>Total Service</label>
                                        <input class="form-control" placeholder/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                    <div class="form-group">
                                        <label>Institution</label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                    <div class="form-group">
                                        <label>Mode of Separation</label>
                                        <select class="form-control">
                                            <option>Resignation</option>
                                            <option>Termination</option>
                                            <option>Retirement</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                    <div class="form-group">
                                        <label>Experience Certificate</label>
                                        <select class="form-control">
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-info add_wrap_pos">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        -->
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn_save">Save</button>
                                    <button class="btn btn-default btn_cancel">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="other_details" class=" tab-pane fade">
                        <form id="edit_other_details_form" method="post">
                            <h6>Particulars of Dependents</h6>
                            <hr>
                            <div class="add_wrap">
                                <div class="row">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                    <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name="other_name" id="other_name" placeholder="Name" />
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Relationship</label>
                                            <input class="form-control" name="other_relation" id="other_relation" placeholder="Relationship" />
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>DOB</label>
                                            <input class="form-control calendarclass" name="other_dob" id="other_dob" placeholder="DOB" />
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>Age</label>
                                            <input class="form-control" name="other_age" id="other_age" placeholder="Age" />
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" name="other_gender" id="other_gender" placeholder="Gender">
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Trans</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-default add_wrap_pos">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <!-- 
                            <div class="add_wrap">
                                <div class="row">
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" placeholder="Name"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Relationship</label>
                                            <input class="form-control" placeholder="Relationship"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>DOB</label>
                                            <input class="form-control" placeholder="DOB"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>Age</label>
                                            <input class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" placeholder="Gender">
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Trans</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-info add_wrap_pos">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div> 
                            -->
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="">
                                        <div class="radio">
                                            <label>Do you have any friends or relatives working at Direction Group of institution: (if yes, give details)</label>
                                            <label class="radio-inline "><input type="radio" name="optradio" checked>Yes</label>
                                            <label class="radio-inline "><input type="radio" name="optradio">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>If yes, give details</label>
                                        <textarea class="form-control" name="other_details" id="other_details"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Hobbies or extracurricular activities:</label>
                                        <textarea class="form-control" name="other_hobbies" id="other_hobbies"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm">
                                    <tr>
                                        <th width="40%">Languages Known</th>
                                        <th width="20%">Read</th>
                                        <th width="20%">Write</th>
                                        <th width="20%">Speak</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" class="form-control" name="language[1]" id="language_1" /></td>
                                        <td> <input type="checkbox" value="" name="language_read[1]" id="language_read_1" /></td>
                                        <td> <input type="checkbox" value="" name="language_write[1]" id="language_write_1" /></td>
                                        <td> <input type="checkbox" value="" name="language_speak[1]" id="language_speak_1" /></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" class="form-control" name="language[2]" id="language_2" /></td>
                                        <td> <input type="checkbox" value="" name="language_read[2]" id="language_read_2" /></td>
                                        <td> <input type="checkbox" value="" name="language_write[2]" id="language_write_2" /></td>
                                        <td> <input type="checkbox" value="" name="language_speak[2]" id="language_speak_2" /></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" class="form-control" name="language[3]" id="language_3" /></td>
                                        <td> <input type="checkbox" value="" name="language_read[3]" id="language_read_3" /></td>
                                        <td> <input type="checkbox" value="" name="language_write[3]" id="language_write_3" /></td>
                                        <td> <input type="checkbox" value="" name="language_speak[3]" id="language_speak_3" /></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" value="" class="form-control" name="language[4]" id="language_4" /></td>
                                        <td> <input type="checkbox" value="" name="language_read[4]" id="language_read_4" /></td>
                                        <td> <input type="checkbox" value="" name="language_write[4]" id="language_write_4" /></td>
                                        <td> <input type="checkbox" value="" name="language_speak[4]" id="language_speak_4" /></td>
                                    </tr>
                                </table>
                            </div>
                            <h6>Personal Reference /Emergency Contact</h6>
                            <hr>
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" name="emergency_name" id="emergency_name" />
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input class="form-control" name="emergency_relation" id="emergency_relation" />
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <input class="form-control" name="emergency_contact" id="emergency_contact" />
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="emergency_address" id="emergency_address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" name="emergency_name" id="emergency_name" />
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input class="form-control" name="emergency_relation" id="emergency_relation" />
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <input class="form-control" name="emergency_contact" id="emergency_contact" />
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="emergency_address" id="emergency_address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <button class="btn btn-info btn_save">Save</button>
                                        <button class="btn btn-default btn_cancel">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

<!---------------------------------------------- For Approval ------------------------------------------>
                    <div id="approval" class=" tab-pane fade">
                        <form id="edit_approval_form" method="post">
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <select class="form-control" name="designation" id="designation">
                                            <option value="1">CEO</option>
                                            <option value="2">HR manager</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="department" id="department">
                                            <option value="1">HR</option>
                                            <option value="2">IT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Entry Type</label>
                                        <select class="form-control" name="entry_type" id="entry_type">
                                            <option value="">Select</option>
                                            <option value="Training" <?php echo (!empty($staffEdit) && $staffEdit['entry_type'] == 'Training')?'selected="selected"':'';?>>Training</option>
                                            <option value="Probation" <?php echo (!empty($staffEdit) && $staffEdit['entry_type'] == 'Probation')?'selected="selected"':'';?>>Probation</option>
                                            <option value="Part-time" <?php echo (!empty($staffEdit) && $staffEdit['entry_type'] == 'Part-time')?'selected="selected"':'';?>>Part-time</option>
                                            <option value="Daily hire" <?php echo (!empty($staffEdit) && $staffEdit['entry_type'] == 'Daily hire')?'selected="selected"':'';?>>Daily hire</option>
                                            <option value="Permanent" <?php echo (!empty($staffEdit) && $staffEdit['entry_type'] == 'Permanent')?'selected="selected"':'';?>>Permanent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group" id="loadtimeperiod" style="display:none;">
                                        <label>Time Period</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control calendarclass" name="start_date" id="start_date" value="<?php echo !empty($staffEdit)?$staffEdit['start_date']:''; ?>">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">To</span>
                                            </div>
                                            <input type="text" class="form-control calendarclass" name="end_date" id="end_date" value="<?php echo !empty($staffEdit)?$staffEdit['end_date']:''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>   Reporting Officer/Line Manager </label>
                                        <select class="form-control" name="reporting_head" id="reporting_head"  >
                                            <option value="">Select</option>
                                            <?php 
                                            foreach($staffArr as $row) { 
                                                if(!empty($staffEdit) && $staffEdit['reporting_head']==$row['personal_id']) { $sel = 'selected="selected"'; } else { $sel = '';}
                                                echo '<option value="'.$row['personal_id'].'" '.$sel.'>'.$row['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>Branch </label>
                                        <select class="form-control" name="branch" id="branch">
                                            <option value="">Select</option>
                                            <?php
                                                foreach($branch as $row) {
                                                    if(!empty($staffEdit) && $staffEdit['branch']==$row->institute_master_id) { $sel = 'selected="selected"'; } else { $sel = '';}
                                                    echo '<option value="'.$row->institute_master_id.'" '.$sel.'>'.$row->institute_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>Center</label>
                                        <select class="form-control" name="center" id="center">
                                            <option value="">Select</option>
                                            <?php
                                            if(!empty($staffEdit) && $staffEdit['center']!='') {
                                                foreach($center as $row) {
                                                    if(!empty($staffEdit) && $staffEdit['center']==$row->institute_master_id) { $sel = 'selected="selected"'; } else { $sel = '';}
                                                        echo '<option value="'.$row->institute_master_id.'" '.$sel.'>'.$row->institute_name.'</option>';
                                                }       
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>Functional Head </label>
                                        <input class="form-control" name="functional_head" value="<?php echo !empty($staffEdit)?$staffEdit['functional_head']:''; ?>" />
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>GM HR/CEO</label>
                                        <input class="form-control" name="hr_head" value="<?php echo !empty($staffEdit)?$staffEdit['hr_head']:''; ?>" />
                                    </div>
                                </div>
                                -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn_save">Save</button>
                                        <button class="btn btn-default btn_cancel">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

<!---------------------------------------------- Proof ------------------------------------------>
                    <div id="proofs" class=" tab-pane fade">
                        <form id="edit_proofs_form" method="post">
                            <div class="add_wrap">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Title<span class="req redbold">*</span></label>
                                            <input class="form-control" name="document_title" id="document_title" data-validate="required"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Documents<span class="req redbold">*</span></label>
                                            <input class="form-control" type="file" name="documents" id="documents" data-validate="required"/>
                                            <p>Upload only PDF file (Max Size:2MB).</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-default add_wrap_pos">
                                        <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <button class="btn btn-info btn_save">Save</button>
                                        <button class="btn btn-default btn_cancel">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

<!---------------------------------------------- Subject ------------------------------------------>

                    <div id="subject" class=" tab-pane fade">
                        <form id="edit_subject_form" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                            <div class="row">
                                <?php
                                $subject = $this->common->get_faculty_subject($personal_id);
                                if(!empty($subject)) {
                                    $i = 0 ;
                                    $strong_subjects = array();
                                    $weak_subject = array();
                                    foreach($subject as $sub) {
                                    $modules = $this->common->get_subject_modules($sub['parent_subject_id']);
                                    if(!empty($sub['strong_subject_id'])) {
                                        $strong_subjects = explode(',', $sub['strong_subject_id']);
                                    }
                                    if(!empty($sub['weak_subject_id'])) {
                                        $weak_subject = explode(',', $sub['weak_subject_id']);
                                    }
                                ?>
                                <div class="area_outline">
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" name="faculty_sub_id[]" value="<?php echo $sub['faculty_sub_id'];?>" />
                                            <h4>
                                            <?php if($i==0) { echo 'Primary subject'; } else { echo 'Other Subject';}   ?>
                                            </h4>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <select class="form-control" name="strong_subject<?php echo $sub['faculty_sub_id'];?>" id="strong_subject<?php echo $sub['faculty_sub_id'];?>" onchange="return get_modules(this.value,'strong_modules<?php echo $sub['faculty_sub_id'];?>')">
                                                    <option value="">Select Subject</option>
                                                    <?php foreach($subjectArr as $subject){?>
                                                    <option value="<?php echo $subject['subject_id'];?>" <?php if($subject['subject_id']==$sub['parent_subject_id']) { echo 'selected="selected"';} ?>><?php echo $subject['subject_name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <span id="strong_modules<?php echo $sub['faculty_sub_id'];?>" style="width:100%;">
                                            <div class="form-group">
                                                <label>Strong Modules</label>
                                                <select  class="multiselect-ui form-control" multiple="multiple" name="strong_modules<?php echo $sub['parent_subject_id'];?>[]" id="strong_module<?php echo $sub['parent_subject_id'];?>">
                                                    <option value="">Select Modules</option>
                                                    <?php foreach($modules as $module){?>
                                                    <option value="<?php echo $module['subject_id'];?>" <?php if(in_array($module['subject_id'],$strong_subjects)) { echo 'selected="selected"'; }?> ><?php echo $module['subject_name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Weak Modules</label>
                                                <select  class="multiselect-ui form-control" multiple="multiple" name="weak_modules<?php echo $sub['parent_subject_id'];?>[]" id="weak_module<?php echo $sub['parent_subject_id'];?>">
                                                    <option value="">Select Modules</option>
                                                    <?php foreach($modules as $module){?>
                                                    <option value="<?php echo $module['subject_id'];?>" <?php if(in_array($module['subject_id'],$weak_subject)) { echo 'selected="selected"'; }?>><?php echo $module['subject_name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <?php $i++; ?>
                                <?php } ?>
                                <?php } else { ?>
                                    <div class="area_outline">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                Primary subject
                                                </h4>
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <select class="form-control" name="strong_subject[]" id="strong_subject" onchange="return get_modules(this.value,'strong_modules')">
                                                        <option value="">Select Subject</option>
                                                        <?php foreach($subjectArr as $subject){?>
                                                        <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <span id="strong_modules" style="width:100%;"></span>
                                        </div>
                                    </div>
                                    <div class="area_outline">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                Other Subject
                                                </h4>
                                                <div class="form-group">
                                                    <label>Other Subject</label>
                                                    <select class="form-control" name="strong_subject[]" id="other_subject" onchange="return get_modules_week(this.value,'othersubjects')">
                                                    <option value="">Select Subject</option>
                                                        <?php foreach($subjectArr as $subject){?>
                                                        <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <span  style="width:100%;" id="othersubjects"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div id="module_selection_holder"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <button class="btn btn-info btn_save">Save</button>
                                        <button class="btn btn-default btn_cancel">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</div>
</div>
<?php $this->load->view("admin/scripts/staff_script");?>
