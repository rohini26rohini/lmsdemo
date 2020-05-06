<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Register Student</h6>
        <hr/>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#reg1">Personal Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Qualifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Others</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Documents</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Batch Allotted</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Payment</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="reg1" class=" tab-pane active"> 
                <form id="personal_form" method="post"  enctype="multipart/form-data">
                    <div class="avathar_wrap">
                        <div id="blah" class="avathar_img" style="background-image: url(<?php echo base_url();?>assets/images/user_3_Artboard_1-512.png);">
                             <input type="file"  id="file" name="file_name" onchange="readURL(this);"/>
                             <div class="img_properties"><span>Upload .jpg,.jpeg,.png,.bmp files only(Max. Size:2MB)</span></div>
                        </div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Contact Number<span class="req redbold">*</span></label>
                                    <input type="text" class="form-control numbersOnly" placeholder="" maxlength="12" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number'); ?>">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Course<span class="req redbold">*</span></label>
                                    <select class="form-control" name="course_id" id="course">
                                        <option value="">Select</option>
                                        <?php foreach($courseArr as $course){?>
                                            <option value="<?php echo $course['class_id'];?>"><?php echo $course['class_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name<span class="req redbold">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="name" id="name" onkeypress="return valNames(event);">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label style="display:block;">Gender<span class="req redbold">*</span></label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="gender" value="male">Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="gender" value="female">Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label style="display:block;"><?php echo $this->lang->line('blood_group'); ?><span class="req redbold">*</span></label>
                                <select class="form-control" name="blood_group">
                                    <option value=""><?php echo $this->lang->line('select_blood_group'); ?></option>
                                    <option value="A+ve"><?php echo $this->lang->line('a+'); ?></option>
                                    <option value="A-ve"><?php echo $this->lang->line('a-'); ?></option>
                                    <option value="B+ve"><?php echo $this->lang->line('b+'); ?></option>
                                    <option value="B-ve"><?php echo $this->lang->line('b-'); ?></option>
                                    <option value="O+ve"><?php echo $this->lang->line('o+'); ?></option>
                                    <option value="O-ve"><?php echo $this->lang->line('o-'); ?></option>
                                    <option value="AB+ve"><?php echo $this->lang->line('ab+'); ?></option>
                                    <option value="AB-ve"><?php echo $this->lang->line('ab-'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Address<span class="req redbold">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="address"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Street Name<span class="req redbold">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="street" id="street">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>State<span class="req redbold">*</span></label>
                                <select class="form-control" name="state" id="state">
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
                                <select class="form-control" name="district" id="district">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Email ID<span class="req redbold">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="email" id="email">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>WhatsApp No<span class="req redbold">*</span></label>
                                <input type="text" class="form-control numbersOnly" placeholder="" name="whatsapp_number" id="whatsapp_number">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Mobile Number<span class="req redbold">*</span></label>
                                <input type="text" class="form-control numbersOnly" placeholder="" name="mobile_number" id="mobile_number">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date Of Birth<span class="req redbold">*</span></label>
                                <input type="text" class="form-control dob" placeholder="Date Of Birth" name="date_of_birth" onkeypress="return ValDate(event)" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name of Guardian<span class="req redbold">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="guardian_name" onkeypress="return valNames(event);">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Guardian Contact Number<span class="req redbold">*</span></label>
                                <input type="text" class="form-control numbersOnly" maxlength="12" placeholder="" name="guardian_number" id="guardian_number">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <button class="btn btn-info btn_save" id="submitstudent" type="submit">Save</button>
                                <a href="<?php echo base_url();?>backoffice/student-list"><button type="button" class="btn btn-default btn_cancel" >Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="reg2" class=" tab-pane fade">
                <form id="qualifications_form">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>SSLC Total Marks</label>
                                <input type="text" class="form-control" placeholder="(%)">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"> <label>+2/VHSE</label>
                                <div class="input-group input_group_form">
                                    <select type="text" class="form-control subject_select" placeholder="Email" id="demo" name="email">
                                        </select>
                                    <div class="input-group-append percent_box">
                                        <input type="text" class="form-control" placeholder="(%)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"> <label>Degree</label>
                                <div class="input-group input_group_form">
                                    <select type="text" class="form-control subject_select" placeholder="Email" id="demo" name="email">
                                        </select>
                                    <div class="input-group-append percent_box">
                                        <input type="text" class="form-control" placeholder="(%)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"> <label>PG</label>
                                <div class="input-group input_group_form">
                                    <select type="text" class="form-control subject_select" placeholder="Email" id="demo" name="email">
                                        </select>
                                    <div class="input-group-append percent_box">
                                        <input type="text" class="form-control" placeholder="(%)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"> <label>Other</label>
                                <div class="input-group input_group_form">
                                    <select type="text" class="form-control subject_select" placeholder="Email" id="demo" name="email">
                                        </select>
                                    <div class="input-group-append percent_box">
                                        <input type="text" class="form-control" placeholder="(%)">
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
            <div id="reg3" class=" tab-pane fade">
                <form id="other_form">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <table class="table table_register">
                        <tbody>
                            <tr>
                                <td>Hostel Required</td>
                                <td nowrap=""><label class="custom_checkbox">Yes
                                  <input type="checkbox">
                                  <span class="checkmark"></span>
                                </label></td>
                                <td nowrap=""><label class="custom_checkbox">No
                              <input type="checkbox">
                              <span class="checkmark"></span>
                            </label></td>
                            </tr>
                            <tr>
                                <td>Whether the candidate had stayed in any hostel before </td>
                                <td><label class="custom_checkbox">Yes
                                      <input type="checkbox">
                                      <span class="checkmark"></span>
                                    </label></td>
                                <td><label class="custom_checkbox">No
                                  <input type="checkbox">
                                  <span class="checkmark"></span>
                                </label></td>
                            </tr>
                            <tr>
                                <td>Food habit of student
                                </td>
                                <td><label class="custom_checkbox">Veg
                                      <input type="checkbox">
                                      <span class="checkmark"></span>
                                    </label></td>
                                <td nowrap=""><label class="custom_checkbox">Non-Veg
                                  <input type="checkbox">
                                  <span class="checkmark"></span>
                                </label></td>
                            </tr>
                            <tr>
                                <td>Whether the candidate has any medical history of aliment</td>
                                <td><label class="custom_checkbox">Yes
                                      <input type="checkbox">
                                      <span class="checkmark"></span>
                                    </label></td>
                                <td><label class="custom_checkbox">No
                                      <input type="checkbox">
                                      <span class="checkmark"></span>
                                    </label></td>
                            </tr>
                            <tr>
                                <td>Transportation Required</td>
                                <td><label class="custom_checkbox">Yes
                                  <input type="checkbox">
                                  <span class="checkmark"></span>
                                </label></td>
                                <td><label class="custom_checkbox">No
                                  <input type="checkbox">
                                  <span class="checkmark"></span>
                                </label></td>
                            </tr>
                            <tr>
                                <td>Place</td>
                                <td colspan="2">
                                    <div class="form-group">

                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </td>
                            </tr>


                        </tbody>
                    </table>
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

            <div id="reg4" class=" tab-pane fade">
                <form>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <div class="multiselect">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                        <select class="form-control">
        <option>Select an option</option>
      </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div class="checkboxes" id="checkboxes">
                                        <label for="one">
        <input type="checkbox" id="one" />First checkbox</label>
                                        <label for="two">
        <input type="checkbox" id="two" />Second checkbox</label>
                                        <label for="three">
        <input type="checkbox" id="three" />Third checkbox</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="reg5" class=" tab-pane fade">dsads</div>

        </div>
    </div>




</div> 
<?php $this->load->view("admin/scripts/add_student_script");?>
