<form id="batchallocationform">

    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="table-responsive table_language table_batch_details" >
            <table class="table table-bordered table-striped table-sm">
                    <tr>
                        <th>Sl</th>
                        <th>Course</th>
                        <th>Start Date</th>
                        <!-- <th>Fees</th> -->
                    </tr>
                <?php
                    if(!empty($studentcourses)) {
                        $i = 1;
                        foreach($studentcourses as $course) { 
                           
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $course->class_name;?></td>
                        <td><?php echo date('d M Y',strtotime($course->created));?></td>
                        <!-- <td><?php //echo numberformat($batch['course_totalfee']);?></td> -->
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                    <?php } else { ?>
                    <tr><td colspan="6">No course available</td></tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label>Course</label>
                        <div class="multiselect">
                            <div class="selectBox" >
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="student_id" value="<?php echo $studentArr['student_id']; ?>"/>
                                <input type="hidden" name="institute_center_map_id" id="institute_center_map_id" value="<?php if(isset($studentcourse) && $studentcourse['institute_course_mapping_id']!='') { echo $studentcourse['institute_course_mapping_id'];} ?>"/>
                                <select class="form-control branchlist" id="selectedcourse" name="selectedcourse" >
                                    <option>Select course</option>
                                    <?php
                                        if(!empty($courses)) {
                                            foreach($courses as $course) {
                                                echo '<option value="'.$course->class_id.'" >'.$course->class_name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label>Branch</label>
                        <div class="multiselect">
                            <div class="selectBox" >
                                <select class="form-control centerlist" name="branch" id="branchlist">
                                    <option>Select branch</option>
                                    <?php
                                        if(!empty($coursebranch)) {
                                            foreach($coursebranch as $center) {
                                                echo '<option value="'.$center->institute_master_id.'" >'.$center->institute_name.'</option>';
                                            }
                                        }
                                    ?>
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label>Center</label>
                        <div class="multiselect">
                            <div class="selectBox" >
                                <select class="form-control batchlist" name="center" id="selectedbatch" <?php  if($studentcourse['branch_id']==0) { ?> style="display:none;" <?php } ?>>
                                    <option>Select center</option>
                                    
                                    </select>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group"  id="loadbatchdetails">
                    <div class="table-responsive table_language table_batch_details" >
                <table class="table table-bordered table-striped table-sm">
                    <tr>
                        <th></th>
                        <th>Batch</th>
                        <th>Start Date</th>
                        <th>End Date</th>

                        <th>Available Seats</th>
                        <th>Fees</th>
                    </tr>
                
                </table>
            </div>
                    </div>
                </div> 
                
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <div class="multiselect">
                            <div class="selectBox" >
                                <button class="btn btn-info" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>   

            </div>

        </div>
        
    </div>

</form>
