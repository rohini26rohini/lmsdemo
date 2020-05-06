<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Student Migration</h6>
        <hr>
        <form enctype="multipart/form-data" id="datamigration_form" method="post" >
            <div class="row ">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="col-sm-3 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('course');?><span class="req redbold">*</span></label>
                        <select class="form-control filter_change" name="course_id" id="course" onchange="get_branch()">
                            <option value="">Select Course</option>
                            <?php foreach($courseArr as $course){?>
                            <?php  if($course['status']==1) {?>
                            <option value="<?php  echo $course['class_id'] ?>"><?php  echo $course['class_name'] ?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div> 
                <div class="col-sm-3 col-12">
                    <div class="form-group">
                        <label> Branch<span class="req redbold">*</span></label>
                        <select class="form-control" name="branch_id" id="branch_id" onchange="get_center()">
                            <option value="">Select Branch</option>
                        </select>              
                    </div>
                </div>
                <div class="col-sm-3 col-12">
                    <div class="form-group">
                        <label> Centre<span class="req redbold">*</span></label>
                        <select class="form-control" name="center_id" id="center_id" onchange="get_batch()">
                            <option value="">Select Centre</option>
                        </select>              
                    </div>
                </div>
                <div class="col-sm-3 col-12">
                    <div class="form-group">
                    <label><?php echo $this->lang->line('batch');?><span class="req redbold">*</span></label>
                        <select class="form-control" name="batch_id" id="batch_id" >
                            <option value="">Select Batch</option>
                        </select> 
                    </div>
                </div>
            </div>
   
            <!-- Data Table Plugin Section Starts Here -->
            <div id="loadreportview" style="display:block;">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label>Upload File<span class="req redbold">*</span></label>
                            <!-- <input type="file" class="form-control" id="file" name="file_name" > -->
                            <input class="form-control" type="file" name="question" onchange="readURL(this);">
                             <p>Upload xls,xlsx,csv files only.</p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                        <label style="display:block">&nbsp</label>
                           <a class="btn btn-info btn_save" href="<?php echo base_url().'uploads/samples/student_data.xlsx'; ?>" download><i class="entypo-download"></i>Click here to download sample</a>
                            <button type="submit" class="btn btn-info btn_save"><i class="fa fa-upload"></i><?php echo 'Upload';?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive table_language" id="cell">
          
                <!-- <table class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cell No.</th>
                            <th>Cell Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A2</td>
                            <td>Student Name</td>
                        </tr>
                    </tbody>
                </table> -->
            </div>

        </form>
    </div>
</div>

<?php $this->load->view("admin/scripts/data_migration_script");?>
