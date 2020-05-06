

    <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <div class="white_card">
            <h6>Questions</h6>
            <hr>
            <div class="addBtnPosition">
                <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonActive" onclick="approve_entity_job(<?php echo $entityID;?>, <?php echo $jobId;?>, <?php echo $flowDetailId;?>);">
                    Approve
                </button>
                <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonInactive" onclick="reject_entity_job(<?php echo $entityID;?>, <?php echo $jobId;?>, <?php echo $flowDetailId;?>);">
                    Reject
                </button>
            </div>
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table id="institute_data1" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50">Sl.No.</th>
                            <th>Passage</th>
                            <th>Question</th>
                            <th>Difficulty</th>
                            <th>Version</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php  
                if(!empty($questions)) { 
                $i=1; foreach($questions['questions'] as $question){?>
                    <tr id="row_<?php echo $question->question_id;?>">
                        <td><?php echo $i;?></td>
                        <?php if($question->paragraph_id!=0 && $question->paragraph_id!=NULL){  ?>        
                            <td onClick="viewPassage('<?php echo $question->paragraph_id; ?>')"><a href="javascript:void()"><?php echo limit_html_string($question->paragraph_content,20); ?></a></td>
                        <?php }else{  ?>     
                            <td>No passage</td>   
                        <?php }  ?>
                        <td onClick="viewQuestion('<?php echo $question->question_id;?>')"><a href="javascript:void()"><?php echo limit_html_string($question->question_content,20); ?></a></td>
                        <td><?php echo get_question_difficulty($question->question_difficulty); ?></td>
                        <td><?php echo $question->question_version; ?></td>
                        <td>
                            <a class="btn btn-default option_btn" title="View" onClick="get_question(<?php echo $question->question_id; ?>)">
                              <i class="fa fa-eye icon"></i>
                            </a>
                            <a class="btn btn-default option_btn" title="Edit" onClick="edit_question(<?php echo $question->question_id; ?>)">
                              <i class="fa fa-pencil icon"></i>
                            </a> 
                            <a class="btn btn-default option_btn" title="Delete" onClick="delete_question(<?php echo $question->question_id; ?>)">
                            <i class="fa fa-trash-o"></i></a>
                        </td>

                      </tr>

                    <?php $i++; }} 
                ?>
                </table>
                <!-- Data Table Plugin Section Starts Here -->
            </div>
        </div>
    </div>
    
    <div id="modal" class="modal fade form_box modalCustom questionbank-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modal_body">


                </div>
            </div>
        </div>
    </div>
    <div id="reject_entity_job" class="modal fade modalCustom" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $this->lang->line('approvel_reject');?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="reject_entity_job_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="id"/>
                        <input type="hidden" name="jobId" id="jobId"/>
                        <input type="hidden" name="flowDetailId" id="flowDetailId"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('remark');?> <span class="req redbold">*</span></label>
                                <textarea name="remark" id="remark" class="form-control" rows="4" cols="50" style="height:unset!important"></textarea>
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
    <?php $this->load->view("admin/scripts/approve_management_script");?>
