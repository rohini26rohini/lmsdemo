<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card">
<?php if(isset($cce)){ //print_r($total);//print_r($staff);?>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
            <label><b style="color:#000;">Course</b><span class="error"> *</span></label>
                <select class="form-control" name="course_id" id="feecourse">
                <option value="">Select Course</option>
                <?php 
                if(!empty($courseArr)) {
                foreach($courseArr as $course) { 
                ?>
                <option value="<?php echo $course['class_id'];?>"><?php echo $course['class_name'];?></option>
                <?php } ?>
                <?php } ?>
                </select>
            </div>
        </div>
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
				<label><b style="color:#000;">Branch</b><span class="error"> *</span></label>
                <select class="form-control" name="branch_id" id="feebranch_id" data-validate="required">
                <option value="">Select Branch</option>
            </select>
            </div>
        </div>
        </div>
    </div>
<!--
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="form-group">
            <label>Centre</label>
                <select class="form-control" name="center_id" id="center_id" data-validate="required">
                    <option value="">Select Centre</option>
                </select>
            </div>
        </div>
-->
    <div class="white_card">
        <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
         <div class="table-responsive">
                                <div class="accordion accordion_branch" id="accordionExample">
                                    
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

