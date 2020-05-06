<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('previous_question_and_syllabus');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_gs" onclick="formclear('gs_form')">
        <?php echo $this->lang->line('add_previous_question_and_syllabus');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('school');?></th>
                        <th ><?php echo $this->lang->line('category');?></th> 
                        <th ><?php echo $this->lang->line('type');?></th> 
                        <th ><?php echo $this->lang->line('document');?></th> 
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($gs_data as $data){ 
                ?>
                    <tr id="row_<?php echo $data->id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="school_<?php echo $data->id;?>">
                            <?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)); ?>
                        </td>
                        <td id="category_<?php echo $data->id;?>">
                            <?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$data->category_id)); ?>
                        </td>
                        <td id="type_<?php echo $data->id;?>">
                            <?php if($data->type == 'syllabus'){ echo 'Syllabus'; } 
                            if($data->type == 'previous_question'){ echo 'Previous Question'; }
                            ?>
                        </td>
                        <td id="document_<?php echo $data->id;?>">
                            <a class="btn mybutton  mybuttoninfo" href="<?php echo base_url(); ?>uploads/webcontent/generalstudies/<?php echo $data->topic_attachment?>" target="_blank">View Document</a>
                        </td>
                        <td id="status_<?php echo $data->id;?>">
                            <?php if($data->status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_gs_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>','<?php echo $data->school_id; ?>','<?php echo $data->category_id; ?>','<?php echo $data->type; ?>')">Inactive</span>
                            <?php }else if($data->status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_gs_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>','<?php echo $data->school_id; ?>','<?php echo $data->category_id; ?>','<?php echo $data->type; ?>')">Active</span>
                            <?php }?>
                        </td>
                        <td id="action_<?php echo $data->id;?>">
                            <button class="btn btn-default option_btn" title="Edit" onclick="get_general_studies_Data('<?php echo $data->id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <?php if($data->status == '0'){?>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_general_studies_Data('<?php echo $data->id;?>')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            <?php }?>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div> 

<!--add discount modal-->
<div id="add_gs" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_previous_question_and_syllabus');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="gs_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="school" id="school">
                                <option value="">Select</option>
                                    <?php 
                                    if(!empty($school)) {
                                        foreach($school as $schools){
                                        echo '<option value="'.$schools->school_id.'">'.$schools->school_name.'</option>';
                                        }
                                    }
                                    ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="category" id="category">
                                    <option value="">Select</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="type">
                                    <option value="syllabus" selected>Syllabus</option>
                                    <option value="previous_question">Previous Question</option>
                                </select> 
                            </div>
                            <div class="form-group" id="topic_div">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('topic_document');?> </label><span class="req redbold"> * </span><small><?php echo "  ( ". $this->lang->line('restriction_document_format')." ) ";?> </small>
                                <input class="form-control" id="topic_document" name="topic_document" type="file">
                                <div id="document_error" style="color:red;"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit_gs" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_previous_question_and_syllabus');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_gs_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="id"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="school" id="edit_school">
                                <option value="">Select</option>
                                    <?php 
                                    if(!empty($school)) {
                                        foreach($school as $schools){
                                        echo '<option value="'.$schools->school_id.'">'.$schools->school_name.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="category" id="category_edit">
                                    <option value="">Select</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="type_edit">
                                    <option value="syllabus" selected>Syllabus</option>
                                    <option value="previous_question">Previous Question</option>
                                </select> 
                            </div>
                            <div class="form-group" id="topic_div_edit">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('topic_document');?> </label><span class="req redbold"> * </span><small><?php echo "  ( ". $this->lang->line('restriction_document_format')." ) ";?> </small>
                                <input class="form-control" id="edit_topic_document" name="topic_document" type="file">
                                <div id="document_view" style="color:blue;"> </div>
                                <div id="edit_document_error" style="color:red;"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/previous_question_and_syllabus_script");?>