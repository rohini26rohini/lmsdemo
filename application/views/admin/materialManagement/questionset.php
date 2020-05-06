<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <!-- Data Table Plugin Section Starts Here -->
               <h6>Question Set</h6>
        <hr>
                <button class="btn btn-default add_row add_new_btn btn_add_call
addBtnPosition" data-toggle="modal" data-target="#myModal">
                                   Add Question Set
                                </button>

      
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="questionset_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('question_set_name');?></th>
                <th><?php echo $this->lang->line('subject');?></th>
                <th><?php echo $this->lang->line('module');?></th>
                <th><?php echo $this->lang->line('material');?></th>
                <th><?php echo $this->lang->line('approval_status');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1;foreach($questionsetArr as $set){?>
                <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $set['question_set_name'];?></td>
                <td><?php $parent_subject_id = $this->common->get_parentSubject(array("subject_id"=> $set['subject_id']));
                        $parent_subject = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=> $parent_subject_id));
                    echo $parent_subject;?></td>
                <td><?php echo $set['subject_name'];?> </td>
                <td><?php echo $set['material_name'];?></td>
                <td>
                    <?php if($set['question_set_status'] == '100'){?>
                        <span class="btn mybutton mybuttonnew" onclick="view_approve_status(<?php echo $set['question_set_id'];?>)">Pending</span>
                    <?php }else if($set['question_set_status'] == '1'){?>
                        <span class="btn mybutton  mybuttonActive" onclick="view_approve_status(<?php echo $set['question_set_id'];?>)">Approved</span>
                    <?php }else if($set['question_set_status'] == '101'){?>
                        <span class="btn mybutton  mybuttonInactive" onclick="view_approve_status(<?php echo $set['question_set_id'];?>)">Rejected</span>
                    <?php }?>
                </td>
                <td>
                    <button class="btn btn-default option_btn " title="Edit" onclick="get_questionset(<?php echo $set['question_set_id'];?>)"><i class="fa fa-pencil "></i></button>
                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_questionset(<?php echo $set['question_set_id'];?>)"><i class="fa fa-trash-o"></i></a>
                    <?php if($set['question_set_status'] != '1'){?>
                        <button class="btn btn-default add_row add_new_btn btn_add_call" onclick="redirect('backoffice/question-bank')">Add questions</button>
                    <?php } ?>
                </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->
<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_questionset');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_questionset_form" type="post">
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label><?php echo $this->lang->line('question_set_name');?><span class="req redbold">*</span></label>
                            <input class="form-control" type="text" name="question_set_name" placeholder="Question Set Name" onkeypress="return addressValidation(event)">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                            <select class="form-control" id="subject" name="subject_id">
                                 <option value="">Select </option>
                                <?php if(!empty($subjectArr)) {
                                    foreach($subjectArr as $sub) { 
                                    $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$sub['course_id']));?>
                                        <option value="<?php echo $sub['subject_id'];?>"><?php echo $sub['subject_name']."   (".$course_name.")";?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label>Module<span class="req redbold">*</span></label>
                            <select class="form-control" id="modules" name="module_id">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label><?php echo $this->lang->line('material');?><span class="req redbold">*</span></label>
                            <select class="form-control" name="material_id" id="material">
                                 <option value=""><?php echo $this->lang->line('select_material');?></option>
                                 <?php foreach($materials as $row) {
                                     echo '<option value="'.$row->material_id.'">'.$row->material_name.'</option>';
                                 } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <div class="custom-control custom-checkbox MargLeft25">
                            <input type="checkbox" name="approval_chk" class="custom-control-input" id="approval_chk" value="1">
                            <label class="custom-control-label" for="approval_chk"> Approval</label>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="approve_user_div">

                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
                <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--edit modal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_questionset');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="edit_questionset_form" type="post">
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="question_set_id" id="question_set_id"/>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label><?php echo $this->lang->line('question_set_name');?><span class="req redbold">*</span></label>
                            <input class="form-control" type="text" name="question_set_name" placeholder="Question Set Name" onkeypress="return addressValidation(event)" id="question_set_name">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                            <select class="form-control" id="edit_subject" name="subject_id">
                                <option value="">Select Subject</option>
                                <?php 
                                if(!empty($subjectArr))
                                {
                                    foreach($subjectArr as $sub)
                                    {
                                        ?>
                                <option value="<?php echo $sub['subject_id'];?>"><?php echo $sub['subject_name'];?></option>
                                <?php
                                     }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label>Module<span class="req redbold">*</span></label>
                            <select class="form-control" id="edit_modules" name="module_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label><?php echo $this->lang->line('material');?><span class="req redbold">*</span></label>
                             <select class="form-control" name="material_id" id="material_id">
                                    <option value=""><?php echo $this->lang->line('select_material');?></option>
                                    <?php
                                    foreach($materials as $row) {
                                        echo '<option value="'.$row->material_id.'">'.$row->material_name.'</option>';
                                    }
                                    ?>
                                </select>
                           </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <div class="custom-control custom-checkbox MargLeft25">
                            <input type="checkbox" name="approval_chk" class="custom-control-input" id="edit_approval_chk" value="1">
                            <label class="custom-control-label" for="edit_approval_chk"> Approval</label>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="edit_approve_user_div">

                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
                <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
            </div>
            </form>
        </div>

    </div>
</div>
<div id="view_approval_status" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('status');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="career_form" method="post" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="table-responsive"  id="view_approval_status_table">
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/materialManagement/question_set_script");?>
