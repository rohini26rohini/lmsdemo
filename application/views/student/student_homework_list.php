<div class="table-responsive">
    <table class="table table-bordered table-sm ExaminationList">
        <thead>
            <tr>
                <th>Sl.no</th>
                <th>Batch</th>
                <th>Title</th>
                <th>Description</th>
                <th>date of Submissiom</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="homework_body">
            <?php $i=1;foreach($homeworks as $row){?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php $batch_id=$row['batch_id'];
                    echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array('batch_id'=>$batch_id));
                    ?></td>
                <td><?php echo $row['title'];?></td>
                <td><?php echo  $row['description'];?></td>
                <td><?php echo  date('d-m-Y',strtotime($row['date_of_submission']));?></td>
                <td><?php
                        $student_id=$this->session->userdata('user_id'); 
                        $exist=$this->common->check_if_dataExist('am_student_homeworks',array("homework_id"=>$row['id'],"student_id"=>$student_id));
                         if($exist==0) 
                         {
                           echo "Pending";  
                         }
                       else
                       {
                           $status=$this->common->get_name_by_id('am_student_homeworks','status',array('student_id'=>$student_id,'homework_id'=>$row['id']));
                           if($status == 1)
                           { 
                               echo "Submitted";
                           }
                           elseif($status == 2)
                           { 
                               echo "Verified";
                           }
                           else
                           {
                               echo "Pending";
                           }
                       }
                                                   
                    ?></td>
                <td>
                    <?php  if($exist != 0) { if($status !=2){?>
                    
                    <button class="btn btn-default option_btn " title="Edit" onclick="add_homework(<?php echo $row['id'];?>)"><i class="fa fa-pencil "></i></button>
                    <?php } ?>
                    
                    <button class="btn btn-default option_btn " title="View" onclick="view_homework(<?php echo $row['id'];?>)">
                        <i class="fa fa-eye "></i></button>
                    <?php }else
                    { ?>
                    <button class="btn btn-default option_btn " title="Edit" onclick="add_homework(<?php echo $row['id'];?>)"><i class="fa fa-pencil "></i></button>
                    <?php }?>
                </td>
            </tr>
            <?php $i++;}?>
        </tbody>
    </table>
</div>
<!--add-->
<div class="modal forgotmodal student-dashboard fade" id="view">
    <div class="modal-dialog">
        <form id="add_homework" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title inner_head" >Add Homework</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="forgotmodalbox">

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group" >
                                            <label>Upload File<span class="req redbold">*</span></label>
                                            <input type="file" class="form-control" id="file" name="file_name[]" multiple> <small> ( Only jpeg , jpg &amp; png formats supported. Maximum size is 5 MB)</small>
                                            <label>(<?php echo $this->lang->line('multiple_images_allowed');?>. 'ctrl + select' for upload multiple images)</label>
                                            <span id="image_error" style="color:red"></span>
                                        </div>
                                        
                                        <input type="hidden" name="assignment_no" id="assignment_no" />
                                        <div class="form-group">
                                            <label>Remarks<span class="req redbold"></span></label>
                                            <input type="text" class="form-control" name="remark" id="remark">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-info btn-submit d-block mysubmit btn-sm" type="submit" id="button_type">Submit</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--edit-->
<div class="modal forgotmodal student-dashboard fade" id="edit">
    <div class="modal-dialog">
        <form id="edit_homework" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title inner_head" >Edit Homewoek</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="forgotmodalbox">

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div id="edit_file">
                                            <table class="table table-bordered table-sm ExaminationList ">
                                                <tr>
                                                    <th>File Upload</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tbody id="tbody"></tbody>
                                            </table>
                                              <div class="form-group">
                                            <button type="button" class="btn btn-info btn-sm btnAddModal" onclick="addNew()"><i class="fa fa-plus"></i>Add More</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="homework_id" id="homework_id" />
                                        <input type="hidden" id="counter" />
                                        
                                        <div class="form-group">
                                            <label>Remarks<span class="req redbold"></span></label>
                                            <input type="text" class="form-control" name="remark" id="edit_remark">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-info btn-submit d-block mysubmit btn-sm" type="submit" id="button_type">Update</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--view-->
<div class="modal forgotmodal student-dashboard fade" id="show">
    <div class="modal-dialog">
        <form id="add_homework" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title inner_head">Homework Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="forgotmodalbox">

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">
                                    <table class="table table_register_view Homeworkstbl">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h6>Submitted on:<small id="show_date"></small></h6>
                                                </td>


                                            </tr>
                                            <tr>


                                                <td>
                                                    <h6>Remarks :<small id="show_remarks"></small></h6>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h6>Uploaded Files :</h6>
                                                    <ul class="nav nav-bar" id="show_uploaded_files">

                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('student/scripts/student_homework_script'); ?>
