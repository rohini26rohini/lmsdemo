<div class="registration_panel">
                        <form id="registration_form" type="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="register_line">

                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                            <div class="register_progress circle_1 register_active"><span>01</span>
                                            <input type="text" id="next" style="height:0px;width:0px;border:0px;"/>
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


                                                <h5>Personnel Details</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                            <div class="cap_2">


                                                <h5>Qualification</h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                            <div class="cap_3">


                                                <h5>Finish</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-success float_prop" id="success_msg" style="display:none;">
                                    <strong>Submitted Successfully!</strong>
                                </div>
                                <div class="alert alert-danger float_prop" id="error_msg" style="display:none;">
                                    <strong>The file you are attempting to upload is larger than the permitted size.</strong>
                                </div>
                                <div class="image_upload_wrap">
                                     <div class="image_upload">
                                        <div class="form-group">
                                            <label>Upload Image</label>                                      
                                                <div class="avathar">
                                                    <?php  if(isset($_SESSION)&&$_SESSION['student_image']!=""){ ?>
                                                    <input type="hidden" name="student_image" value="<?php echo $_SESSION['student_image']; ?> "/>
                                                    <?php } ?>
                                                     <img id="blah"
                                                          <?php if(isset($_SESSION)&&$_SESSION['student_image']!=""){ ?> 
                                                          src="<?php echo base_url($_SESSION['student_image']); ?>" <?php } else { ?>
                                                          src="<?php echo base_url();?>assets/images/user_3_Artboard_1-512.png" <?php } ?> class="img-responsive"/>
                                                <input type="file" class="form-control" placeholder="Name" id="file" name="file_name" onchange="readURL(this);"/></div>
                                                <div class="img_properties"><span>Upload .jpg,.jpeg,.png,.bmp files only(Max. Size:2MB)</span></div>

                                        </div>
                                    </div>


                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Contact Number<span class="show_error">*</span></label>
                                                <input id="contact_number" type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="<?php echo ( isset($_SESSION)&$_SESSION['contact_number']!="") ? $_SESSION['contact_number'] : '';?>"/>
                                            </div>
                                        </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Course<span class="show_error">*</span></label>
                                                      <select class="form-control"  name="course_id" id="course">
                                                          <option value="">Select</option>
                                                          <?php foreach($courseArr as $course){?>
                                                          <option value="<?php echo $course['class_id'];?>"
                                                                  <?php if( isset($_SESSION)&& $_SESSION['course_id']== $course['class_id']){ echo "selected";}?>><?php echo $course['class_name'];?></option>
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
                                                      <select class="form-control"  name="branch_institute_id" id="branch_institute_id">
                                                           <option value="">Select</option>
                                                          <?php foreach($branchArr as $branch){?>
                                                          <option value="<?php echo $branch->institute_course_mapping_id;?>"
                                                                  <?php if( isset($_SESSION)&& $_SESSION['branch_institute_id']== $branch->institute_course_mapping_id){ echo "selected";}?>><?php echo $branch->institute_name;?></option>
                                                          <?php } ?>
                                                          
                                                    </select>
                                                </div>
                                            </div>
                                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Preferred Batch<span class="show_error">*</span></label>
                                                      <select class="form-control"  name="batch_id" id="batch_id">
                                                        <option value="">Select</option>
                                                          <?php foreach($batchArr as $batch){?>
                                                          <option value="<?php echo $batch->batch_id;?>"
                                                                  <?php if( isset($_SESSION)&& $_SESSION['batch_id']== $batch->batch_id){ echo "selected";}?>><?php echo $batch->batch_name;?></option>
                                                          <?php } ?>  
                                                    </select>
                                                </div>
                                            </div>
                                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Name<span class="show_error">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo ( isset($_SESSION)&$_SESSION['name']!="") ? $_SESSION['name'] : '';?>" onkeypress="return valNames(event,this);" />
                                                </div>
                                            </div>
                                            <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label style="display:block;">Gender<span class="show_error">*</span></label>
                                                    <div class="form-check-inline">
                                                      <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender" value="male" <?php if( isset($_SESSION)&& $_SESSION['gender']== "male"){ echo "checked";}?>>Male
                                                      </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                      <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender" value="female" <?php if( isset($_SESSION)&& $_SESSION['gender']== "female"){ echo "checked";}?>>Female
                                                      </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                           <div class="form-group">
                                            <label style="display:block;"><?php echo $this->lang->line('blood_group'); ?><span class="req redbold">*</span></label>
                                            <select class="form-control" name="blood_group">
                                                            <option value=""><?php echo $this->lang->line('select_blood_group'); ?></option>
                                                            <option
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "A+ve"){ echo "Selected";}?> value="A+ve"><?php echo $this->lang->line('a+'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "A-ve"){ echo "Selected";}?>  value="A-ve"><?php echo $this->lang->line('a-'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "B+ve"){ echo "Selected";}?> value="B+ve"><?php echo $this->lang->line('b+'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "B-ve"){ echo "Selected";}?> value="B-ve"><?php echo $this->lang->line('b-'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "O+ve"){ echo "Selected";}?> aria-disabled=""value="O+ve"><?php echo $this->lang->line('o+'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "O-ve"){ echo "Selected";}?> value="O-ve"><?php echo $this->lang->line('o-'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "AB+ve"){ echo "Selected";}?> value="AB+ve"><?php echo $this->lang->line('ab+'); ?></option>
                                                            <option 
                                                                  <?php if( isset($_SESSION)&& $_SESSION['blood_group']== "AB-ve"){ echo "Selected";}?> value="AB-ve"><?php echo $this->lang->line('ab-'); ?></option>
                                               </select>
                                            </div>
                                    </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Address<span class="show_error">*</span></label>
                                                    <input type="text" class="form-control txtOnly" placeholder="Address" name="address" value="<?php echo ( isset($_SESSION)&$_SESSION['address']!="") ? $_SESSION['address'] : '';?>"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Street Name<span class="show_error">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Street Name" name="street" value="<?php echo ( isset($_SESSION)&$_SESSION['street']!="") ? $_SESSION['street'] : '';?>" onkeypress="return addressValidation(event)"/>
                                                </div>
                                            </div>
                                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>State<span class="show_error">*</span></label>
                                              <select class="form-control"  name="state" id="state"> 
                                                    <option value="">Select</option>
                                                  <?php foreach($stateArr as $state){?>
                                                  <option value="<?php echo $state['id'];?>" <?php if( isset($_SESSION)&& $_SESSION['state']== $state['id']){ echo "selected";}?> ><?php echo $state['name'];?></option>
                                                  <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>City<span class="show_error">*</span></label>
                                                <select class="form-control"  name="district" id="district">
                                                    <option value="">Select</option>
                                                     <?php foreach($DistrictArr as $district){?>
                                                  <option value="<?php echo $district['id'];?>" <?php if( isset($_SESSION)&& $_SESSION['district']== $district['id']){ echo "selected";}?> ><?php echo $district['name'];?></option>
                                                  <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                       
                                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Email ID<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" placeholder="Email Id" name="email" value="<?php echo ( isset($_SESSION)&$_SESSION['email']!="") ? $_SESSION['email'] : '';?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>WhatsApp No<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" placeholder="Whatsapp Number" value="<?php echo ( isset($_SESSION)&$_SESSION['whatsapp_number']!="") ? $_SESSION['whatsapp_number'] : '';?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Mobile Number<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_number" id="mobile_number" value="<?php echo ( isset($_SESSION)&$_SESSION['mobile_number']!="") ? $_SESSION['mobile_number'] : '';?>"/>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Date Of Birth<span class="show_error">*</span></label>
                                                <input type="text" class="form-control calendarclass" placeholder="Date Of Birth" name="date_of_birth" value="<?php echo ( isset($_SESSION)&$_SESSION['date_of_birth']!="") ? $_SESSION['date_of_birth'] : '';?>" onkeypress="return ValDate(event)"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Name of Guardian<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" placeholder="Name of Guardian" 
                                                       name="guardian_name" value="<?php echo ( isset($_SESSION)&$_SESSION['guardian_name']!="") ? $_SESSION['guardian_name'] : '';?>" onkeypress="return valNames(event,this);" />
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Guardian's Contact Number<span class="show_error">*</span></label>
                                                <input type="text" class="form-control" placeholder="Contact Number" name="guardian_number" id="guardian_number" onkeypress="return valNum(event)" value="<?php echo ( isset($_SESSION)&$_SESSION['guardian_number']!="") ? $_SESSION['guardian_number'] : '';?>" onkeypress="return valNum(event)"/>
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
<?php $this->load->view("home/scripts/register_firstpage_script");  ?>
