
<!-- <section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png">
        <div class="container">
            <h3>Registration</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registration</li>
            </ol>
        </div>
    </section> -->
    <!-- <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>admissions</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">admissions</li>
            </ol>
        </div>
    </div> -->
    <section class="inner_page_wrapper">
        <div class="container">
            <div class="row" style="background:white;padding:20px;box-shadow: 0px 8px 16px 0px rgba(114, 114, 114, 0.2);">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12" 
                style="background-repeat: no-repeat; background-image: url(<?php echo base_url();?>assets/images/registration.jpg);">

                </div>
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12" id="next_page">

                    <div class="registration_panel">
                        <form id="registration_form" type="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="register_line">
                                   
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                            <div class="register_progress circle_1 register_active"><span>01</span>

                                            </div>

                                            <!--                                            <h5>Personnal Details</h5>-->

                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                            <div class="register_progress circle_2"><span>02</span>

                                            </div>

                                            <!--                                            <h5>Qualification</h5>-->

                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">


                                            <div class="register_progress circle_3"><span>03</span>



                                                <!--                                            <h5>Finish</h5>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="register_cap">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                            <div class="cap_1 cap_active">


                                                <h5>Personal Details</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                            <div class="cap_2">


                                                <h5>Qualification</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                            <div class="cap_3">


                                                <h5>Other Details</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-success float_prop alert-dismissible" id="success_msg" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Submitted Successfully!</strong>
                                </div>
                                <div class="alert alert-danger float_prop alert-dismissible" id="error_msg" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>The file you are attempting to upload is larger than the permitted size.</strong>
                                </div>
                         
                                <div class="image_upload_wrap">
                                    <div class="image_upload">
                                        <div class="form-group">
                                            <label>Upload Image</label>                                      
                                                 <div class="avathar">                                                     <img id="blah" src="<?php echo base_url();?>assets/images/user_3_Artboard_1-512.png" class="img-responsive"/>
                                                    <input type="file" class="form-control" placeholder="Name" id="file" name="file_name" onchange="readURL(this);"/>
                                                    <div class="img_properties"><span>Upload .jpg,.jpeg,.png,.bmp files only(Max. Size:2MB)</span></div>
                                                </div>

                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row">
                                             <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Contact Number<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" placeholder="Contact Number" maxlength="12" name="contact_number" id="contact_number" onkeypress="return valNum(event)"/>
                                            </div>
                                        </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Course<span class="show_error">*</span></label>
                                                      <select class="form-control"  name="course_id" id="course">
                                                          <option value="">Select</option>
                                                          <?php foreach($courseArr as $course){?>
                                                          <option value="<?php echo $course['class_id'];?>"><?php echo $course['class_name'];?></option>
                                                          <?php } ?>
                                                    </select>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-field">
                                    <div class="row">
                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Branch<span class="show_error">*</span></label>
                                                      <select class="form-control"  name="branch_institute_id" id="branch_institute_id">                                                    </select>
                                                </div>
                                            </div>
                                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Preferred Batch<span class="show_error">*</span></label>
                                                      <select class="form-control"  name="batch_id" id="batch_id">
                                                          
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Name<span class="show_error">*</span></label>
                                                    <input type="text" class="form-control txtOnly" placeholder="Name" name="name" id="name"/>
                                                </div>
                                            </div>
                                            <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label style="display:block;">Gender<span class="show_error">*</span></label>
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
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
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
                                                    <label>Address<span class="show_error">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Address" name="address"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Street Name<span class="show_error">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Street Name" name="street" id="street" onkeypress="return addressValidation(event)"/>
                                                </div>
                                            </div>
                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>State<span class="show_error">*</span></label>
                                              <select class="form-control"  name="state" id="state">
                                                    <option value="">Select</option>
                                                  <?php foreach($stateArr as $state){?>
                                                  <option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
                                                  <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>City<span class="show_error">*</span></label>
                                                <select class="form-control"  name="district" id="district">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Email ID<span class="show_error">*</span></label>
                                                <input type="email" class="form-control" placeholder="Email Id" name="email" id="email"/>
                                            </div>
                                        </div>
                                       
                                       <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Contact Number<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" placeholder="Contact Number" name="contact_number"/>
                                            </div>
                                        </div> -->
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>WhatsApp No.<span class="show_error">*</span></label>
                                                <input type="text" class="form-control numbersOnly" name="whatsapp_number" id="whatsapp_number" placeholder="Whatsapp Number" maxlength="12"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Mobile Number<span class="show_error">*</span></label>
                                                <input type="text" class="form-control numbersOnly" placeholder="Mobile Number" name="mobile_number" id="mobile_number" maxlength="12"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Date Of Birth<span class="show_error">*</span></label>
                                                <input type="text" class="form-control dob" placeholder="Date Of Birth" name="date_of_birth" autocomplete="off" onkeypress="return ValDate(event)"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Name of Guardian<span class="show_error">*</span></label>
                                                <input type="text" class="form-control txtOnly" placeholder="Name of Guardian" name="guardian_name"/>
                                                       
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Guardian's Contact Number<span class="show_error">*</span></label>
                                                <input type="text" class="form-control numbersOnly" placeholder="Contact Number" name="guardian_number" id="guardian_number" maxlength="12"/>
                                            </div>
                                        </div>

                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <button class="btn btn-warning btn_next" type="submit">Next</button>
                                            </div>
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
    </section>
    <?php $this->load->view("home/scripts/register_firstpage_script");  ?>
