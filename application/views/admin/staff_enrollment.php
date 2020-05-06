<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <?php  if(!isset($staffEdit)){  ?>
        <div class="white_card ">
            <h6>Add Employee</h6>
            <hr/>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active personal_details" data-toggle="pill" href="#personal_details">Personnel Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link educational_qualification disabled tabdisabled" data-toggle="pill" href="#educational_qualification" >Educational Qualifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link work_experience disabled tabdisabled" data-toggle="pill" href="">Work Experience</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link other_details disabled tabdisabled" data-toggle="pill" href="documents">Documents</a>
                </li>
               
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
                            <div id="blah" class="avathar_img" style="background-image: url(<?php echo base_url();?>assets/images/user_3_Artboard_1-512.png);">
                                <input type="file"  id="file" name="file_name" onchange="readURL(this);"/>
                                <div class="img_properties">
                                    <span>Upload .jpg,.jpeg,.png,.bmp files only(Max. Size:2MB)</span>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Name<span class="req redbold">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="form-control" name="honorific">
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
                                        <input type="text" class="form-control dob" name="dob" id="dob" placeholder="Date Of Birth" data-validate="required" onkeypress="return ValDate(event)">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Gender</label><span class="req redbold">*</span>
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
                                    <label>Blood Group</label><span class="req redbold"> *</span>
                                    <select class="form-control" name="blood_group" id="blood_group" placeholder="Gender">
                                        <option value="">Select Blood Group</option>
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
                                    <input class="form-control" name="mobile" id="mobile" placeholder="Primary Contact No/Mobile No." onkeypress="return valNum(event);" maxlength="12"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>LandLine No.</label>
                                    <input class="form-control" name="landline" id="landline" placeholder="LandLine No." onkeypress="return valNum(event);" maxlength="11"/>
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
                                    <textarea class="form-control" name="permanent_address" id="permanent_address" placeholder="Permanent Address" data-validate="required"></textarea>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Address for Communication</label>
                                    <textarea class="form-control" name="communication_address" id="communication_address" placeholder="Address for Communication"></textarea>
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
                                    <label>Aadhaar Card No.<span class="req redbold">*</span></label>
                                    <input class="form-control" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No." data-validate="required" onkeypress="return valNum(event);" maxlength="12"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>PAN Card No.</label>
                                    <input class="form-control" name="pan_no" id="pan_no" placeholder="PAN Card No."   onkeypress="return txtnumberValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Bank Account No.</label>
                                    <input class="form-control" name="ac_no" id="ac_no" placeholder="Bank Account No." data-validate="required" onkeypress="return valNum(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label> IFSC code</label>
                                    <input class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC code" data-validate="required"  onkeypress="return txtnumberValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn_save">Save</button>
                                    <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

<!------------------------------------------ Subject ---------------------------------------------------->
<div id="subjecttab" class=" tab-pane fade">
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
                                    <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
                                </div>
                            </div>
                        </div>
                    </form>
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
                
                <li class="nav-item">
                    <a class="nav-link other_details" data-toggle="pill" onclick="append_document('<?php echo $staffEdit['personal_id'];?>')"   href="#documents">Documents</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link proofs" data-toggle="pill" href="#proofs">Proof to be submitted</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link approval" data-toggle="pill" href="#approval">For Approval</a>
                </li>
                <input type="hidden" value="<?php if(!empty($staffEdit)&& $staffEdit['role']!='') { echo $staffEdit['role'];} ?>" name="role" id="staffrole"/>
                <?php if(!empty($staffEdit)&& $staffEdit['role']=='faculty') { 
                    //if($this->session->userdata('role')=='faculty'){?>
                <li class="nav-item">
                    <a class="nav-link subject" data-toggle="pill" id="subjectt" href="#subject">Subject</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link subject" data-toggle="pill" id="subjecttab" href="#subject" style="display:none;">Subject</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" onclick="idCard_call(<?php echo $staffEdit['personal_id']; ?>)" id="idCard_call" href="#idCard" >ID Card</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="personal_details" class="tab-pane active">
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
                                                <option <?php if($staffEdit['honorific'] == "Mr."){ echo "Selected";}?>>Mr.</option>
                                                <option  <?php if($staffEdit['honorific'] == "Mrs."){ echo "Selected";}?>>Mrs.</option>
                                                <option  <?php if($staffEdit['honorific'] == "Ms."){ echo "Selected";}?>>Ms.</option>
                                                <option  <?php if($staffEdit['honorific'] == "Dr."){ echo "Selected";}?>>Dr.</option>
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
                                    <input type="text" class="form-control dob" data-validate="required" name="dob" id="dob" placeholder="Date Of Birth" value="<?php echo !empty($staffEdit)? date('d-m-Y', strtotime($staffEdit['dob'])):''; ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Gender<span class="req redbold">*</span></label>
                                    <select class="form-control" name="gender" id="gender" placeholder="Gender">
                                        <option <?php echo (!empty($staffEdit) && $staffEdit['gender'] == 'Male')? 'selected':''; ?>>Male</option>
                                        <option <?php echo (!empty($staffEdit) && $staffEdit['gender'] == 'Female')? 'selected':''; ?>>Female</option>
                                        <option <?php echo (!empty($staffEdit) && $staffEdit['gender'] == 'Trans')? 'selected':''; ?>>Trans</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Marital Status<span class="req redbold">*</span></label>
                                    <select class="form-control" name="marital_status" id="marital_status" placeholder="Marital Status">
                                        <option <?php echo (!empty($staffEdit) && $staffEdit['marital_status'] == 'Single')? 'selected':''; ?>>Single</option>
                                        <option <?php echo (!empty($staffEdit) && $staffEdit['marital_status'] == 'Married')? 'selected':''; ?>>Married</option>
                                        <option <?php echo (!empty($staffEdit) && $staffEdit['marital_status'] == 'Divorsed')? 'selected':''; ?>>Divorsed</option>
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
                                <select class="form-control" name="blood_group" id="blood_group" placeholder="Blood Group">
                                 
                                    
                                    <option value="">Select Blood Group</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "A+"){ echo "Selected";}  
                                    }?>>A+</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "O+"){ echo "Selected";}  
                                    }?>>O+</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "B+"){ echo "Selected";}  
                                    }?>>B+</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "AB+"){ echo "Selected";}  
                                    }?>>AB+</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "A-"){ echo "Selected";}  
                                    }?>>A-</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "O-"){ echo "Selected";}  
                                    }?>>O-</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "B-"){ echo "Selected";}  
                                    }?>>B-</option>
                                    <option <?php if(!empty($staffEdit['blood_group'])){
                                      if($staffEdit['blood_group'] == "AB-"){ echo "Selected";}  
                                    }?>>AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Primary Contact No/Mobile No.<span class="req redbold">*</span></label>
                                <input autocomplete="off" class="form-control" name="mobile" id="mobile" placeholder="Primary Contact No/Mobile No." value="<?php echo !empty($staffEdit)?$staffEdit['mobile']:''; ?>" onkeypress="return valNum(event);" maxlength="12"/>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>LandLine No.</label>
                                <input autocomplete="off" class="form-control" name="landline" id="landline" placeholder="LandLine No." value="<?php echo !empty($staffEdit)?$staffEdit['landline']:''; ?>" onkeypress="return valNum(event);" maxlength="11"/>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Email<span class="req redbold">*</span></label>
                                <input autocomplete="off" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo !empty($staffEdit)?$staffEdit['email']:''; ?>" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Permanent Address<span class="req redbold">*</span></label>
                                <textarea class="form-control" data-validate="required" name="permanent_address" id="permanent_address" placeholder="Permanent Address" value="" ><?php echo !empty($staffEdit)?$staffEdit['permanent_address']:''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Address for Communication</label>
                                <textarea class="form-control" name="communication_address" id="communication_address" placeholder="Address for Communication" value="" ><?php echo !empty($staffEdit)?$staffEdit['communication_address']:''; ?></textarea>
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
                                <label>Aadhaar Card No.<span class="req redbold">*</span></label>
                                <input autocomplete="off" class="form-control" data-validate="required" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No." value="<?php echo !empty($staffEdit)?$staffEdit['aadhar_no']:''; ?>" onkeypress="return valNum(event);" maxlength="12"/>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label>PAN Card No.</label>
                                <input autocomplete="off" class="form-control" data-validate="required" name="pan_no" id="pan_no" placeholder="PAN Card No." value="<?php echo !empty($staffEdit)?$staffEdit['pan_no']:''; ?>"  onkeypress="return txtnumberValidation(event);" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label>Bank Account No.</label>
                                <input class="form-control" data-validate="required" name="ac_no" id="ac_no" placeholder="Bank Account No." value="<?php echo !empty($staffEdit)?$staffEdit['ac_no']:''; ?>" onkeypress="return valNum(event);"/>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label> IFSC code</label>
                                <input autocomplete="off" class="form-control" data-validate="required" name="ifsc_code" id="ifsc_code" placeholder="IFSC code" value="<?php echo !empty($staffEdit)?$staffEdit['ifsc_code']:''; ?>"  onkeypress="return txtnumberValidation(event);" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <button class="btn btn-info btn_save">Save</button>
                                <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
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
                                        <select type="text" class="form-control subject_select" name="specification[]" >
                                            <?php echo (!empty($Classx) && $Classx['specification']!='')?'<option selected="selected">'.$Classx['specification'].'</option>':'';
                                            ?>
                                            <option value="">Select</option>
                                            <?php
                                            $qualifications = $this->common->get_qualifications_type('Classx');
                                            if(!empty($qualifications)) {
                                                foreach($qualifications as $qualification) {
                                                    echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>School/College</label>
                                        <input autocomplete="off" class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($Classx) && $Classx['school']!='')?$Classx['school']:'';?>" onkeypress="return addressValidation(event);" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Year of Passing</label>
                                        <input class="form-control passingyear" name="passing_year[]" id="passing_year" placeholder="Year of Passing" autocomplete="off" value="<?php echo (!empty($Classx) && $Classx['passing_year']!='')?$Classx['passing_year']:'';?>" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Marks in Percentage</label>
                                        <input autocomplete="off" class="form-control sslcpercentage" maxlength="5" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($Classx) && $Classx['marks']!='')?$Classx['marks']:'';?>" onkeypress="return decimalNum(event);" />
                                        <span class="req redbold" id="sslc_marks_msg"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>University/Institute with City &amp; State</label>
                                <textarea class="form-control" rows="5" name="university[]" id="university" placeholder="University/Institute with City &amp; State" onkeypress="return (event);"><?php echo (!empty($Classx) && $Classx['university']!='')?$Classx['university']:'';?></textarea>
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
                                            <?php
                                                    $qualifications = $this->common->get_qualifications_type('Classxii');
                                                    if(!empty($qualifications)) {
                                                        foreach($qualifications as $qualification) {
                                                            echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                                                        }
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>School/College</label>
                                        <input autocomplete="off" class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($Classxii) && $Classxii['school']!='')?$Classxii['school']:'';?>" onkeypress="return addressValidation(event);" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Year of Passing</label>
                                        <input class="form-control passingyear" name="passing_year[]" id="passing_year" placeholder="Year of Passing" autocomplete="off" value="<?php echo (!empty($Classxii) && $Classxii['passing_year']!='')?$Classxii['passing_year']:'';?>" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Marks in Percentage</label>
                                        <input autocomplete="off" class="form-control plustwopercentage" maxlength="5" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($Classxii) && $Classxii['marks']!='')?$Classxii['marks']:'';?>"  onkeypress="return decimalNum(event);"/>
                                        <span class="req redbold" id="plustwo_marks_msg"></span>
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
                                                <?php
                                                    $qualifications = $this->common->get_qualifications_type('Degree');
                                                    if(!empty($qualifications)) {
                                                        foreach($qualifications as $qualification) {
                                                            echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>School/College</label>
                                            <input autocomplete="off" class="form-control" name="school[]" id="school" placeholder="School/College" value="<?php echo (!empty($Degree) && $Degree['school']!='')?$Degree['school']:'';?>" onkeypress="return addressValidation(event);" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Year of Passing</label>
                                            <input class="form-control passingyear" name="passing_year[]" id="passing_year" placeholder="Year of Passing" autocomplete="off" value="<?php echo (!empty($Degree) && $Degree['passing_year']!='')?$Degree['passing_year']:'';?>" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Marks in Percentage</label>
                                            <input autocomplete="off" class="form-control degreepercentage" maxlength="5" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($Degree) && $Degree['marks']!='')?$Degree['marks']:'';?>"  onkeypress="return decimalNum(event);"/>
                                            <span class="req redbold" id="degree_marks_msg"></span>
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
                                                <?php
                                                    $qualifications = $this->common->get_qualifications_type('PG');
                                                    if(!empty($qualifications)) {
                                                        foreach($qualifications as $qualification) {
                                                            echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                                                        }
                                                    }
                                                    ?>
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
                                            <input class="form-control passingyear" name="passing_year[]" id="passing_year" placeholder="Year of Passing" value="<?php echo (!empty($pg) && $pg['passing_year']!='')?$pg['passing_year']:'';?>" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Marks in Percentage</label>
                                            <input class="form-control pgpercentage" maxlength="5" name="marks[]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($pg) && $pg['marks']!='')?$pg['marks']:'';?>"  onkeypress="return decimalNum(event);"/>
                                            <span class="req redbold" id="pg_marks_msg"></span>
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
                              <!--  <input name="category[]" value="Others" type="text" />-->
                                <?php
                                $personal_id = '';
                                if(!empty($staffEdit) && $staffEdit['personal_id']!='') {
                                $personal_id =   $staffEdit['personal_id'];
                                }
                                $Others = $this->common->get_classx_qualify($personal_id, 'Others');
                                if(!empty($Others)){
                                    $i=3;
                                    $countInitializer = count($Others) + 3;
                                    foreach($Others as $row){
                                        $i++;
                                       
                                ?>
                                <div class="add_wrap" id="new_textbox<?=$i?>">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <?php
                                     echo '<input name="education_id[]" value="'.$row['education_id'].'" type="hidden"/>';
                                        echo '<input type="hidden" name="counter" id="counter" value="'.$countInitializer.'">';
                                    
                                    ?>
                                                <input name="category[]" value="Others" type="hidden" />
                                                <label>Specification</label>
                                                <input class="form-control spec" name="specification[<?=$i?>]" id="specification_<?=$i?>" placeholder="specification" value="<?php echo (!empty($row) && $row['specification']!='')?$row['specification']:'';?>" onkeypress="return addressValidation(event);" />
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Marks in Percentage</label>
                                                <input class="form-control otherspercentage" maxlength="5" name="marks[<?=$i?>]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($row) && $row['marks']!='')?$row['marks']:'';?>" onkeypress="return decimalNum(event);" />
                                                <span class="req redbold" id="others_marks_msg"></span>
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
                            <?php } }else{ 
                                $i=4;?>
                                <div class="add_wrap" id="new_textbox<?=$i?>">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                 <input type="hidden" name="counter" id="counter" value="<?php echo $i;?>">
                                                <input name="category[]" value="Others" type="hidden" />
                                                <input name="education_id[]" value="5" type="hidden"/>
                                                <label>Specification</label>
                                                <input class="form-control" name="specification[<?=$i?>]" id="specification" placeholder="specification" value="<?php echo (!empty($row) && $row['specification']!='')?$row['specification']:'';?>" onkeypress="return addressValidation(event);" />
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Marks in Percentage</label>
                                                <input class="form-control otherspercentage" maxlength="5" name="marks[<?=$i?>]" id="marks" placeholder="Marks in Percentage" value="<?php echo (!empty($row) && $row['marks']!='')?$row['marks']:'';?>" onkeypress="return decimalNum(event);" />
                                                <span class="req redbold" id="others_marks_msg"></span>
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
                            <?php  } ?>
                            <div id="more_others"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <button class="btn btn-info btn_save" id="Submitbutton">Save</button>
                                <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                                    <label>Previous Designation</label>
                                    <input class="form-control" name="designationedit[]" id="designation" placeholder="Designation" value="<?php echo $ex['designation'];?>"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Previous Department</label>
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
                                    <label  style="font-size: 11px;">Total Service Year(E.g:5.6)</label>
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
                                        <option value="0">Select City</option>
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
                                        <option value="0">Select</option>
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
                                        <option value="0">Select</option>
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
                                    <label>Previous Designation</label>
                                    <input class="form-control" name="designation[]" id="designation" placeholder="Designation"  onkeypress="return addressValidation(event);"/>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Previous Department</label>
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
                                    <label style="font-size: 11px;">Total Service Year(E.g:5.6)</label>
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
                                        <option value="0" >Select City</option>
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
                                    <option value="">Select</option>
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
                                            <label>Previous Designation</label>
                                            <input class="form-control" name="designation[]" id="designation" placeholder="Designation"  onkeypress="return addressValidation(event);"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label>Previous Department</label>
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
                                            <label  style="font-size: 11px;">Total Service Year(E.g:5.6)</label>
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
                                                <option value="0">Select City</option>
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
                                                <option value="">Select</option>
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
                                    <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
                                </div>
                            </div>
                        </div>
	                </form>
	            </div>

<!--------------------------------------- Other Details ------------------------------------------>
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
                                        <label>Gender</label><span class="req redbold">*</span>
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
                                        <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
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
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>Designation</label> 
                                        <select class="form-control" name="designation" id="designation">
                                        <?php
                                                    $qualifications = $this->common->get_basic_entity('Designation');
                                                    print_r($qualifications);
                                                    if(!empty($qualifications)) {
                                                        foreach($qualifications as $qualification) { ?>
                                                            <option value="<?php echo $qualification->entity_name;?>" <?php echo (!empty($staffEdit) && $staffEdit['designation'] == $qualification->entity_name)?'selected="selected"':'';?>><?php echo $qualification->entity_name;?></option>
                                                       <?php }
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" name="department" id="department">
                                            <?php
                                                $qualifications = $this->common->get_basic_entity('Department');
                                                if(!empty($qualifications)) {
                                                    foreach($qualifications as $qualification) { ?>
                                                        <option value="<?php echo $qualification->entity_name;?>" <?php echo (!empty($staffEdit) && $staffEdit['department'] == $qualification->entity_name)?'selected="selected"':'';?>><?php echo $qualification->entity_name;?></option>
                                                   <?php }
                                                } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>Joining Date</label><span class="req redbold"> *</span>
                                        <input type="text" class="form-control calendarclass" name="joining_date" id="joining_date" placeholder="Joining Date" data-validate="required" value="<?php $convertedDate = date('d-m-Y',strtotime($staffEdit['joining_date'])); echo !empty($staffEdit['joining_date'])?$convertedDate:''; ?>" onkeypress="return ValDate(event)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Entry Type</label><span class="req redbold"> *</span>
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
                                    <div class="form-group">
                                        <label>Biometric ID</label><span class="req redbold"> *</span>
                                        <input type="text" class="form-control" name="biometric_id" id="biometric_id" value="<?php echo !empty($staffEdit)?$staffEdit['biometric_id']:''; ?>" placeholder="Biometric ID" data-validate="required"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group" id="loadtimeperiod" style="display:none;">
                                        <label>Time Period</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control calendarclass " name="start_date" id="start_date" value="<?php echo !empty($staffEdit)?$staffEdit['start_date']:''; ?>">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">To</span>
                                            </div>
                                            <input type="text" class="form-control calendarclass " name="end_date" id="end_date" value="<?php echo !empty($staffEdit)?$staffEdit['end_date']:''; ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                                    <div class="form-group">
                                        <label>Salary Scheme<span class="req redbold">*</span></label> 
                                        <select class="form-control" name="salary_scheme_id" id="salary_scheme_id" data-validate="required">
                                            <option value="">Select Salary Scheme</option>
                                            <?php
                                            foreach($salaryArr as $salary) {
                                                if(!empty($staffEdit) && $staffEdit['salary_scheme_id']==$salary['id']) { $sel = 'selected="selected"'; } else { $sel = '';}
                                                echo '<option value="'.$salary['id'].'" '.$sel.'>'.$salary['scheme'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                                    <div class="form-group">
                                        <label>Leave Scheme<span class="req redbold">*</span></label> 
                                        <select name="leave_scheme_id" id="leave_scheme_id" class="form-control"  data-validate="required">
                                        <option value="">Select Leave Scheme</option>
                                            <?php
                                            foreach($leaveArr as $row) {
                                                if(!empty($staffEdit) && $staffEdit['leave_scheme_id']==$row['id']) { $sel = 'selected="selected"'; } else { $sel = '';}
                                                echo '<option value="'.$row['id'].'" '.$sel.'>'.$row['scheme'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label>   Reporting Officer/Line Manager </label><span class="req redbold">*</span>
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
                                        <label>Branch</label><span class="req redbold"> *</span>
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
                                        <label>Centre</label><span class="req redbold"> *</span>
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
                                        <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

<!---------------------------------------------- Documents ------------------------------------------>
                    <div id="documents" class=" tab-pane fade">
                        <form id="all_qualification_form" method="post" enctype="multipart/form-data">
                            <div id="section_duplicates2">
                                <hr class="no_hr" />
                                <div class="add_wrap">
                                    <div class="row" id="result">
                                        <input type="hidden" name="pers_id" class="form-control" id="pers_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        <?php 
                                        $allqualificationArr = $this->common->get_all_others($staffEdit['personal_id']);
                                        // echo '<pre>';
                                         //print_r($allqualificationArr);
                                        // die();
                                        $i=1; 
                                        $query = array();
                                        if(!empty($allqualificationArr)){
                                        foreach($allqualificationArr as $rows){
                                        ?>
                                        <input type="hidden" name="education_id[]" id="education_id" value="<?php echo !empty($rows)?$rows['education_id']:''; ?>" />
                                        <?php $query=  $this->common->get_staff_docs($rows['personal_id'],$rows['education_id']); ?>
                                        <input type="hidden" name="files" id="files" value="<?php echo !empty($query)?$query['file']:''; ?>" />
                                        <?php if($rows['category']=="Classx"){ ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>SSLC</label>
                                                    <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                                                    <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['specification']:''; ?>" placeholder="Document Name" />
                                                </div>
                                            </div>
                                        <?php }else if($rows['category']=="Classxii"){ ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>+2/VHSE</label>
                                                    <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                                                    <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['specification']:''; ?>" placeholder="Document Name" />
                                                </div>
                                            </div>
                                        <?php }else if($rows['category']=="Degree"){ ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Degree</label>
                                                    <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                                                    <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['specification']:''; ?>" placeholder="Document Name" />
                                                </div>
                                            </div>
                                        <?php }else if($rows['category']=="PG"){ ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>PG</label>
                                                    <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                                                    <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['specification']:''; ?>" placeholder="Document Name" />
                                                </div>
                                            </div>
                                        <?php }else { ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Additional Qualification</label>
                                                    <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['specification']:''; ?>" placeholder="Document Name" />
                                                </div>
                                            </div>
                                        <?php } ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Upload File
                                                        <?php if(!empty($query)){ echo " : ".$query['document_name'];} ?>
                                                    </label>
                                                    <input type="file"  id="file" class="form-control doc_upload myFile"   name="file_name1[]"  multiple="multiple" value="" onchange="validate(this.value)"/>
                                                    <p>Upload .pdf,.docx,.jpg files only  (Max Size:10MB).</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label style="display:block">Verified</label>
                                                    <select class="form-control"  id="document_verification1" name="verification1[]" value= "">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php $i++;}?>
                                        
                                            <div class="col-sm-12 save">
                                                <div class="form-group">
                                                    <button type="submit" id= "submit"  class="btn btn-info btn_save">Save</button>
                                                </div>
                                            </div>
                                            <?php }?>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <form id="document_form" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div id="section_duplicate2">
                                        <h6>Other Documents</h6>
                                        <hr/>
                                        <div class="add_wrap">
                                            <div class="row">
                                                <input type="hidden" name="personal_id" id="personal_id" value="<?php echo !empty($staffEdit)?$staffEdit['personal_id']:''; ?>" />
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Document Name</label>
                                                        <input class="form-control" type="text" id="document_name" name="document_name" placeholder="Document Name" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Upload File</label>
                                                        <?php if(!empty($query)){ echo " : ".$query['document_name'];} ?>
                                                        <input type="file" class="form-control" id="docfile" name="file_name"/>
                                                        <p>Upload .pdf,.docx,.jpg files only  (Max Size:10MB).</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label style="display:block">Verified</label>
                                                        <select class="form-control" id="document_verification" name="verification">
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <label style="display:block">&nbsp;</label>
                                                        <button type="submit" id="submitted" class="btn btn-info btn_save">Save Other Documents</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </form>

                        <div class="row">
                            <div class="col-12">
                                <ul class="data_table " id="staff_document_table">
                                    <li class="data_table_head ">
                                        <div class="col">Qualification name</div>
                                        <div class="col">Document file</div>
                                        <div class="col">Verified</div>
                                        <div class="col actions">Actions</div>
                                    </li>
                                    <?php 
                                    if(!empty($documents)) {
                                    foreach($documents as $row){ ?>
                                        <li id="row_<?php echo $row->staff_documents_id;?>">
                                            <?php if(!empty($row->education_id)){?>
                                                <div class="col">
                                                    <?php echo $row->specification;?>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="col">
                                                    <?php echo $row->document_name;?>
                                                </div>
                                            <?php } ?>
                                            <div class="col">
                                                <a target="_blank" href="<?php echo base_url($row->file);?>">Download document</a>
                                            </div>
                                            <div class="col">
                                                Yes &nbsp;<input type="radio" name="verfied<?php echo $row->staff_documents_id;?>" <?php if($row->verification==1){echo 'checked="checked"';}?> value="1" onclick="verify_document(
                                                <?php echo $row->staff_documents_id;?>);"> &nbsp;&nbsp;&nbsp; No &nbsp;<input type="radio" name="verfied<?php echo $row->staff_documents_id;?>" <?php if($row->verification==0){echo 'checked="checked"';}?> value="0" onclick="unverify_document(
                                                <?php echo $row->staff_documents_id;?>);">
                                            </div>
                                            <div class="col actions">
                                                <button class="btn btn-default btn_details_view" title="Delete" onclick="delete_docs('<?php echo $row->staff_documents_id;?>')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>
                                        </li>
                                    <?php }}else { ?>
                                        <li>Please add some documents.</li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
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
                                                <select class="form-control primary" name="strong_subject<?php echo $sub['faculty_sub_id'];?>" id="strong_subject<?php echo $sub['faculty_sub_id'];?>" onchange="return get_modules(this.value,'strong_modules<?php echo $sub['faculty_sub_id'];?>')">
                                                    <option value="">Select Subject</option>
                                                    <?php foreach($subjectArr as $subject){
                                                    
                                                     $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$subject['course_id']));?>
                                                    <option value="<?php echo $subject['subject_id'];?>" <?php if($subject['subject_id']==$sub['parent_subject_id']) { echo 'selected="selected"';} ?>><?php echo $subject['subject_name']."   (".$course_name.")";?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-12">
                                        <span id="strong_modules<?php echo $sub['faculty_sub_id'];?>" style="width:100%;">
                                            <div class="form-group">
                                                <label>Strong Modules</label>
                                                <select  class="multiselect-ui form-control" multiple="multiple" name="strong_modules<?php echo $sub['parent_subject_id'];?>[]" id="strong_module<?php echo $sub['parent_subject_id'];?>">
                                                    <?php foreach($modules as $module){?>
                                                    <option value="<?php echo $module['subject_id'];?>" <?php if(in_array($module['subject_id'],$strong_subjects)) { echo 'selected="selected"'; }?> ><?php echo $module['subject_name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Weak Modules</label>
                                                <select  class="multiselect-ui form-control" multiple="multiple" name="weak_modules<?php echo $sub['parent_subject_id'];?>[]" id="weak_module<?php echo $sub['parent_subject_id'];?>">
                                                   <?php foreach($modules as $module){?>
                                                    <option value="<?php echo $module['subject_id'];?>" <?php if(in_array($module['subject_id'],$weak_subject)) { echo 'selected="selected"'; }?>><?php echo $module['subject_name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </span>
                                        </div></div>
                                </div>

                                <?php $i++; ?>
                                <?php } ?>
                                 <div class="area_outline" >
                                        <div class="row" id="row">
                                            <div class="col-12" id="show_other_subject_0">
                                                <h4>
                                                Other Subject
                                                </h4>
                                                <div class="add_wrap">
                                                <div class="form-group">
                                                    <label>Other Subject</label>
                                                    <select class="form-control" name="strong_subject[]" id="strong_subject" onchange="return get_modules_week(this.value,0)">
                                                    <option value="">Select Subject</option>
                                                        <?php foreach($subjectArr as $subject){
                                                         $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$subject['course_id']));?>
                                                        <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name']."   (".$course_name.")";?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                    <button type="button" class="btn btn-default add_wrap_pos" onclick="addNew()" style="top:unset;bottom:10px;"><i class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                    <span  style="width:100%;" id="othersubjects_0"></span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                <?php } else { ?>
                                    <div class="area_outline">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                Primary subject
                                                </h4>
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <select class="form-control primary" name="strong_subject[]" id="strong_subject" onchange="return get_modules(this.value,'strong_modules')">
                                                        <option value="">Select Subject</option>
                                                        <?php foreach($subjectArr as $subject){
                                                            $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$subject['course_id']));
                                                        ?>
                                                        <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name']."   (".$course_name.")";?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                            <span id="strong_modules" style="width:100%;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="area_outline" >
                                        <div class="row" id="row">
                                            <div class="col-12" id="show_other_subject_0">
                                                <h4>
                                                Other Subject
                                                </h4>
                                                <div class="add_wrap">
                                                <div class="form-group">
                                                    <label>Other Subject</label>
                                                    <select class="form-control" name="strong_subject[]" id="strong_subject" onchange="return get_modules_week(this.value,0)">
                                                    <option value="">Select Subject</option>
                                                        <?php foreach($subjectArr as $subject){
                                                        $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$subject['course_id']));?>
                                                        <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name']."   (".$course_name.")";?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                    <button type="button" class="btn btn-default add_wrap_pos" onclick="addNew()" style="top:unset;bottom:10px;"><i class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                    <span  style="width:100%;" id="othersubjects_0"></span>
                                                    </div>
                                                </div>
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
                                        <!-- <button class="btn btn-default btn_cancel">Cancel</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--   ID Card   -->
                    <div id="idCard" class=" tab-pane fade">
                        
                    </div>
    <?php } ?>
</div>

<?php $this->load->view("admin/scripts/staff_script");?>
