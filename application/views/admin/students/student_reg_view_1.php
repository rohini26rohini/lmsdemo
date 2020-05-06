
<form id="personal_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <input type="hidden" id="student_id" name="student_id" value="<?php echo $studentArr['student_id'];?>"/>
    <div class="avathar_wrap">
    <div id="blah" class="avathar_img " style="background-image: url(<?php echo base_url();?><?php echo $studentArr['student_image'];?>);">
        <input type="file" class="form-control" id="file" name="file_name" onchange="readURL(this);"/>
        <div class="img_properties"><span>Only accept .jpg,.jpeg,.png,.bmp files <br>(Max.file size:2MB)</span></div>
    </div>
 
 


    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group">
            <label>Contact Number<span class="req redbold">*</span></label>
            <input type="text" class="form-control numbersOnly" maxlength="12" placeholder="" value="<?php echo $studentArr['contact_number'];?>" name="contact_number" id="contact_number" onkeypress="return valNum(event)">
        </div>
    </div>
        
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label>Name<span class="req redbold">*</span></label>
                <input type="text" class="form-control" placeholder="" value="<?php echo $studentArr['name'];?>" name="name" onkeypress="return valNames(event);">
            </div>
        </div>

         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
            <div class="form-group">
                <label style="display:block;">Gender<span class="req redbold">*</span></label>
                <div class="form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" value="male" <?php  if($studentArr['gender'] == "male"){ echo "checked";}?>>Male
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" value="female" <?php  if($studentArr['gender'] == "female"){ echo "checked";}?>>Female
                    </label>
                </div>
            </div>
        </div>
         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
            <div class="form-group">
                                <label style="display:block;"><?php echo $this->lang->line('blood_group'); ?><span class="req redbold">*</span></label>
                                <select class="form-control" name="blood_group">
                                                <option value=""><?php echo $this->lang->line('select_blood_group'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "A+ve"){ echo "Selected";}?> value="A+ve"><?php echo $this->lang->line('a+'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "A-ve"){ echo "Selected";}?> value="A-ve"><?php echo $this->lang->line('a-'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "B+ve"){ echo "Selected";}?> value="B+ve"><?php echo $this->lang->line('b+'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "B-ve"){ echo "Selected";}?> value="B-ve"><?php echo $this->lang->line('b-'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "O+ve"){ echo "Selected";}?> value="O+ve"><?php echo $this->lang->line('o+'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "O-ve"){ echo "Selected";}?> value="O-ve"><?php echo $this->lang->line('o-'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "AB+ve"){ echo "Selected";}?> value="AB+ve"><?php echo $this->lang->line('ab+'); ?></option>
                                                <option <?php if($studentArr['blood_group'] == "AB-ve"){ echo "Selected";}?> value="AB-ve"><?php echo $this->lang->line('ab-'); ?></option>
                                       </select>

                            </div>
                        </div>
<input type="hidden" name="course_id" value="<?php if(!empty($Selectedcourse)){ echo $Selectedcourse['course_id']; } ?>" />
<!--
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Course<span class="req redbold">*</span></label>
                <select class="form-control" name="course_id" id="course">
                    <option value="">Select</option>
                    <?php foreach($courseArr as $course){ ?>
                    <option value="<?php echo $course['class_id'];?>"
                            <?php if(!empty($Selectedcourse)){if($Selectedcourse['course_id'] == $course['class_id']){ echo "selected";} }?>><?php echo $course['class_name'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
-->

        

    </div>

    <!-- Data Table Plugin Section Starts Here -->
</div>

<div class="row">

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label>Address<span class="req redbold">*</span></label>
                <input type="text" class="form-control" placeholder="" value="<?php echo $studentArr['address'];?>" name="address">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label>Street Name<span class="req redbold">*</span></label>
                <input type="text" class="form-control" placeholder="" value="<?php echo $studentArr['street'];?>" name="street" onkeypress="return addressValidation(event)">
            </div>
        </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>State<span class="req redbold">*</span></label>
            <select class="form-control" name="state" id="state">
                    <option value="">Select</option>
                    <?php foreach($stateArr as $state){?>
                    <option value="<?php echo $state['id'];?>" <?php if($state['id']==$studentArr['state']){ echo "Selected";} ?>><?php echo $state['name'];?></option>
                    <?php } ?>
                </select>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>City<span class="req redbold">*</span></label>
            <select class="form-control" name="district" id="district">
                <option value="">Select</option>
                <?php
                foreach($DistrictArr as $district){?>
                        <option value="<?php echo $district['id'];?>" <?php if($district['id']==$studentArr['district']){ echo "Selected";} ?>><?php echo $district['name'];?></option>
                <?php } ?>
                                </select>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Email ID<span class="req redbold">*</span></label>
            <input type="email" class="form-control" placeholder="" value="<?php echo $studentArr['email'];?>" name="email" id="email">
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>WhatsApp No<span class="req redbold">*</span></label>
            <input type="text" class="form-control numbersOnly" placeholder="" value="<?php echo $studentArr['whatsapp_number'];?>" name="whatsapp_number" maxlength="12" >
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Mobile Number<span class="req redbold">*</span></label>
            <input type="text" class="form-control numbersOnly" placeholder="" value="<?php echo $studentArr['mobile_number'];?>" name="mobile_number"  maxlength="12" >
        </div>
    </div>
   
    
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Date Of Birth<span class="req redbold">*</span></label>
            <input type="text" class="form-control calendarclass" placeholder="Date Of Birth" name="date_of_birth" id="dob" value="<?php echo date('d-m-Y', strtotime($studentArr['date_of_birth']));?>"  onkeypress="return ValDate(event)"/>
        </div>
    </div>
     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Name of Guardian<span class="req redbold">*</span></label>
            <input type="text" class="form-control" placeholder="" value="<?php echo $studentArr['guardian_name'];?>" name="guardian_name" onkeypress="return valNames(event);">
        </div>
    </div> 
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Guardian's Contact Number<span class="req redbold">*</span></label>
            <input type="text" class="form-control numbersOnly" placeholder="" value="<?php echo $studentArr['guardian_number'];?>" name="guardian_number" maxlength="12">
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="form-group">
            <button class="btn btn-info btn_save">Save</button>
            <!--<button class="btn btn-default btn_cancel">Cancel</button>-->
        </div>
    </div>
</div>
</form>
