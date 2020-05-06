<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Add Employee</h6>
        <hr/>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#personal_details">Personnel Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#educational_qualification">Educational Qualifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#work_experience">Work Experience</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#other_details">Other Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#approval">For Approval</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#proofs">Proof to be submitted</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="personal_details" class=" tab-pane active">
            <form id="add_personal_details_form" method="post">
                <div class="avathar_wrap">
                    <div class="avathar_img">
                        <input type="file" />
                    </div>
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="personal_id" class="form-control" id="edit_personal_id"/>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select class="form-control">
                                            <option>Mr.</option>
                                            <option>Mrs.</option>
                                            <option>Ms.</option>
                                            <option>Dr.</option>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"  aria-label="Text input with dropdown button" data-validate="required"  onkeypress="return valNames(event);">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Employee ID</label>
                                <input type="text" class="form-control" name="emp_id" id="emp_id" placeholder="Employee ID"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date Of Birth<span class="req redbold">*</span></label>
                                <input type="text" class="form-control dob" name="dob" id="dob" placeholder="Date Of Birth">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender" id="gender" placeholder="Gender" >
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Trans</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Data Table Plugin Section Starts Here -->
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Height in Cm</label>
                            <input class="form-control" name="height" id="height" placeholder="Height in Cm" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Weight</label>
                            <input class="form-control" name="weight" id="weight" placeholder="Weight" />
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
                            <label>Mobile No.</label>
                            <input class="form-control" name="mobile" id="mobile" placeholder="Mobile No."  onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>LandLine No.</label>
                            <input class="form-control" name="landline" id="landline" placeholder="LandLine No."  onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" id="email" placeholder="Email"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Marital Status</label>
                            <select class="form-control" name="marital_status" id="marital_status" placeholder="Marital Status">
                                <option>Single</option>
                                <option>Married</option>
                                <option>Divorsed</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Spouse Name</label>
                            <input class="form-control" name="spouse_name" id="spouse_name" placeholder="Spouse Name"  onkeypress="return valNames(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Occupation</label>
                            <input class="form-control" name="spouse_job" id="spouse_job" placeholder="Occupation"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="spouse_country" id="spouse_country">
                                <option value="">Select Country</option>
                                <!-- <?php 
                                foreach($countryArr as $country){
								if($country['name']=='India') { $selected	=	'selected="selected"'; } else { $selected = ''; }
								echo '<option value="'.$country['name'].'" '.$selected.'>'.$country['name'].'</option>';
                                }
                                ?> -->
                                <?php foreach($countryArr as $country){?>
                                <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>State</label>
                            <select class="form-control" name="spouse_state" id="spouse_state">
                                <option value="">Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>City</label>
                            <select class="form-control" name="spouse_city" id="spouse_city">
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Father's Name</label>
                            <input class="form-control" name="father_name" id="father_name" placeholder="Father's Name"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Occupation</label>
                            <input class="form-control" name="father_job" id="father_job" placeholder="Occupation"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="father_country" id="father_country">
                                <option value="">Select Country</option>
                                <!-- <?php 
                                foreach($countryArr as $country){
								if($country['name']=='India') { $selected	=	'selected="selected"'; } else { $selected = ''; }
								echo '<option value="'.$country['name'].'" '.$selected.'>'.$country['name'].'</option>';
                                }
                                ?> -->
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Professional body registration(if applicable)<span class="req redbold">*</span></label>
                            <textarea class="form-control" name="body_reg" id="body_reg"  onkeypress="return addressValidation(event);"></textarea>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Regn. No</label>
                            <input class="form-control" name="reg_no" id="reg_no" placeholder="Regn. No"/> 
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Issue Date</label>
                            <input class="form-control calendarclass" name="issue_date" id="issue_date" placeholder="Issue Date"/>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input class="form-control calendarclass" name="exp_date" id="exp_date" placeholder="Expiry Date"/> 
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>PAN Card No.<span class="req redbold">*</span></label>
                            <input class="form-control" name="pan_no" id="pan_no" placeholder="PAN Card No."  onkeypress="return txtnumberValidation(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>SBT Account No.<span class="req redbold">*</span></label>
                            <input class="form-control" name="ac_no" id="ac_no" placeholder="SBT Account No."  onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label> IFSC code<span class="req redbold">*</span></label>
                            <input class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC code"  onkeypress="return txtnumberValidation(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Aadhaar Card No.<span class="req redbold">*</span></label>
                            <input class="form-control" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Card No."  onkeypress="return valNum(event);"/>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Permenent Address<span class="req redbold">*</span></label>
                            <textarea class="form-control" name="permanent_address" id="permanent_address" placeholder="Permenent Address" ></textarea>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Address for Communication</label>
                            <textarea class="form-control" name="communication_address" id="communication_address" placeholder="Address for Communication"></textarea>
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

            <div id="educational_qualification" class=" tab-pane fade">
            <form id="edit_educational_qualification_form" method="post">
                <div class="row">
                    <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Specification</label>
                                    <select class="form-control">
                                        <option>Qualification1</option>
                                        <option>Qualification1</option>
                                        <option>Qualification1</option>
                                        <option>Qualification1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>School/College</label>
                                    <input class="form-control" placeholder="School/College"/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Year of Passing</label>
                                    <input class="form-control year" placeholder="Year of Passing"/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Marks in Percentage</label>
                                    <input class="form-control" placeholder="Marks in Percentage"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>University/Institute with City &amp; State</label>
                            <textarea class="form-control" rows="5" placeholder="University/Institute with City &amp; State"></textarea>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <button class="btn btn-info btn_save">Save</button>
                            <button class="btn btn-warning btn_add">Add More</button>
                            <button class="btn btn-default btn_cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>    
            </div>

            <div id="work_experience" class=" tab-pane fade">
            <form id="edit_work_experience_form" method="post">
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
                                <input class="form-control calendarclass" placeholder="From"/>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label>To</label>
                                <input class="form-control calendarclass" placeholder="To"/>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label>Total Service</label>
                                <input class="form-control" placeholder="Total Service"/>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label>Institution</label>
                                <input class="form-control" placeholder="Institution"/>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label>City</label>
                                <select class="form-control" name="city">
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
                                <select class="form-control">
                                    <option>Resignation</option>
                                    <option>Termination</option>
                                    <option>Retirement</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label>PF Account Status</label>
                                    <select class="form-control">
                                    <option>Active</option>
                                    <option>Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label>PF Account No.</label>
                                <input class="form-control" placeholder="PF Account No."/>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-default add_wrap_pos">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <hr>

                <!-- <div class="add_wrap">
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
                    </div> -->
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
                                <input class="form-control calendarclass" placeholder="DOB"/>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label>Age</label>
                                <input class="form-control" placeholder="Age"/>
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
                    <button class="btn btn-default add_wrap_pos">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- <div class="add_wrap">
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
                 </div> -->
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
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Hobbies or extracurricular activities:</label>
                            <textarea class="form-control"></textarea>
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
                            <td><input type="text" value="" class="form-control" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                        </tr>
                        <tr>
                            <td><input type="text" value="" class="form-control" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                        </tr>
                        <tr>
                            <td><input type="text" value="" class="form-control" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                        </tr>
                        <tr>
                            <td><input type="text" value="" class="form-control" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
                            <td> <input type="checkbox" value="" /></td>
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
                                    <input class="form-control" />
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <input class="form-control" />
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Contact No.</label>
                                    <input class="form-control" />
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                        <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Relationship</label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control"></textarea>
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
                <div id="approval" class=" tab-pane fade">
                <form id="edit_approval_form" method="post">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Entry Type</label>
                                <select class="form-control">
                                    <option>Training</option>
                                    <option>Probation</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Time Period</label>
                                <div class="input-group">
                                    <input type="text" class="form-control calendarclass">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">To</span>
                                    </div>
                                    <input type="text" class="form-control calendarclass">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>   Reporting Officer/Line Manager </label>
                                <input class="form-control" /> 
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Functional Head </label>
                                <input class="form-control" />
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>GM HR/CEO</label>
                                <input class="form-control" />
                            </div>
                        </div> -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                                    <div class="form-group">
                                        <label>Salary Scheme<span class="req redbold">*</span></label> 
                                        <select class="form-control" name="salary_scheme_id" id="salary_scheme_id" data-validate="required">
                                            <option value="">Select Salary Scheme</option>
                                            <?php foreach($salaryArr as $salary){
                                                ?>
                                                <option value="<?php echo $salary['id']; ?>"><?php echo $salary['scheme']; ?></option>
                                                <?php
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
                                            <?php foreach($leaveArr as $leave){
                                                ?>
                                                <option value="<?php echo $leave['id']; ?>"><?php echo $leave['scheme']; ?></option>
                                                <?php
                                                }
                                            ?>
                                        </select>
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

                <div id="proofs" class=" tab-pane fade">
                <form id="edit_proofs_form" method="post">
                    <div class="add_wrap">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Title<span class="req redbold">*</span></label>
                                    <input class="form-control" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Documents<span class="req redbold">*</span></label>
                                    <input class="form-control" type="file" name="documents"/>
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
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php $this->load->view("admin/scripts/staff_script");?>
