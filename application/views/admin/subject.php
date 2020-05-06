<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage Subjects</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_subject_form')">
            Add Subjects
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table  id="subject_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?>

                        </th>
                        <th>Subject Name

                        </th>
                        <th>Subject Type

                        </th>
                        <th>Parent Subject

                        </th>
                        <th>Course

                        </th>
                        <th>Action

                        </th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($subjectArr as $subject){ 
                $parent_subject = '';
                ?>
                <tr id="row_<?php echo $subject['subject_id'];?>">
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $subject['subject_name'];?>
                    </td>
                    <td>
                        <?php echo $subject['subject_type_id'];?>
                    </td>
                    <td>
                    <?php 
                    $CI =& get_instance();
                    $parent_subject=$CI->get_subjectby_id($subject['parent_subject']);
                    echo $parent_subject;
                    ?>
                    </td>
                    <td>
                        <?php echo $subject['class_name'];?>
                    </td>
                    <td>
                        <button class="btn btn-default option_btn" title="Edit" data-toggle="modal" data-target="#edit_subject" onclick="get_subjectdata(<?php echo $subject['subject_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_subject(<?php echo $subject['subject_id'];?>,'<?php echo $subject['subject_type_id'];?>')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!-- add subject modal-->
<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Subject</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_subject_form" type="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label> Name<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="subject_name" placeholder="Subject/Module Name" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="subject_type_id" id="type" data-validate="required">
                                    <option value="">Select</option>
                                    <option value="Subject">Subject</option>
                                    <option value="Module">Module</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="coursediv" style="display:none;">
                            <div class="form-group"><label>Course<span class="req redbold">*</span></label>
                                <select class="form-control" name="course_id" id="course_id" data-validate="required">
                                    <option value="0">Select</option>
                                    <?php
                                    if(!empty($classesArr)) {
                                        foreach($classesArr as $class) { 
                                            if($class['status']==1) {
                                            echo '<option value="'.$class['class_id'].'">'.$class['class_name'].'</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="parent_div"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div> 
            </form>
        </div>
    </div>
</div>

<!-- edit subject modal-->
<div id="edit_subject" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Subject</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_subject_form" type="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="hidden" name="subject_master_id" id="edit_subjectid" />
                            <div class="form-group"><label> Name<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="subject_name" placeholder="Subject/Module Name" id="edit_subjectname" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="subject_type_id" id="edit_type" data-validate="required">
                                    <option value="">Select</option>
                                    <option value="Subject">Subject</option>
                                    <option value="Module">Module</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="editcoursediv" style="display:none;">
                            <div class="form-group"><label>Course<span class="req redbold">*</span></label>
                                <select class="form-control" name="course_id" id="edit_course_id" data-validate="required">
                                    <option value="0">Select</option>
                                    <?php
                                    if(!empty($classesArr)) {
                                        foreach($classesArr as $class) { 
                                            if($class['status']==1) {
                                            echo '<option value="'.$class['class_id'].'">'.$class['class_name'].'</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_div"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div> 
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/subject_script");?>
