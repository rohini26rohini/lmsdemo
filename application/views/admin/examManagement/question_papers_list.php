
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                          <h6>Manage Exam Papers</h6>
                        <hr>
                        <!-- Data Table Plugin Section Starts Here -->

                        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" style="margin-right: 180px;" onClick="redirect('backoffice/auto-generate-exam-paper');">
                            Autogenerate Exam Paper 
                        </button>
                        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal">
                            Create Exam Paper
                        </button>
                       <div class="table-responsive table_language" style="margin-top:15px;">
                            <table id="institute_data" class="table table-striped table-sm">
                                <thead>
                                <tr><th width="8%">Sl.No.</th>
                                    <th width="22%">Exam paper Name</th>
                                    <th width="20%">Exam model</th>
                                    <th width="15%">Creation status</th>
                                    <th width="15%">Approve status</th>
                                    <th width="20%">Action</th>
                                </tr></thead>
                                <?php /*show($questionpapers);*/ $i=1; if(!empty($questionpapers)){ foreach($questionpapers as $row){ ?>
                                <tr id="paper<?php echo $row->id;?>">
                                    <td width="8%"><?php echo $i; ?></td>
                                    <td><?php echo $row->exam_paper_name; ?></td>
                                    <td><?php echo $row->exam_name; ?></td>
                                    <td width="15%">
                                    <?php 
                                        if($row->record_status == 1 || $row->record_status == 101 || $row->record_status == 100){
                                            echo '<div style="color:green;" class="col ">Completed</div>';
                                        }else{
                                            echo '<div style="color:red;" class="col ">Pending</div>';
                                        }
                                    ?>
                                    </td>
                                    <td width="15%">
                                    <?php 
                                    $approvalCheck = $this->common->get_approvalCheckExistsEP($row->id);//show($approvalCheck);
                                    if($approvalCheck != 0){
                                        if($row->record_status==1){
                                            echo '<span class="btn mybutton  mybuttonActive" onclick="view_approve_status('.$row->id.')">Completed</span>';
                                        }else if($row->record_status==100){
                                            echo '<span class="btn mybutton mybuttonnew" onclick="view_approve_status('.$row->id.')">Pending</span>';
                                        }else if($row->record_status==101){
                                            echo '<span class="btn mybutton  mybuttonInactive" onclick="view_approve_status('.$row->id.')">Rejected</span>';
                                        }else{
                                            echo '<div style="color:red;" class="col ">Approval Not Started</div>';
                                        }
                                    }
                                    ?></td>
                                    <td width="30%">
                                        
                                    <?php
                                        if(count($this->exam_model->scheduled_question_papers($row->id))){?>
                                            <button class="btn btn-default option_btn" title="View" onclick="view_question_paper('<?php echo $row->id;?>')">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <?php echo "Can't edit or delete. Already scheduled";
                                        }else{
                                        if($row->record_status != 100){
                                            if(!($row->record_status == 1 && $approvalCheck > 0 )){?>
                                            <button class="btn btn-default option_btn" title="Edit" onClick="redirect('backoffice/question-paper?id=<?php echo $row->id;?>');">
                                                <i class="fa fa-pencil "></i>
                                            </button>
                                            <?php }?>
                                            <button class="btn btn-default option_btn" title="Delete" onclick="delete_question_paper('<?php echo $row->id;?>')">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        <?php }?>
                                        <button class="btn btn-default option_btn" title="View" onclick="view_question_paper('<?php echo $row->id;?>')">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    <?php } ?>
                                    </td>
                                </tr>
                                <?php $i++; } }?>
                                
                            </table>
                        </div>

                    </div>
                </div>

    <div id="myModal" class="modal fade modalCustom" role="dialog">
        <div class="modal-dialog" style="max-width: 767px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create a new exam paper</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form autocomplete="off" id="question_paper_define" method="post" accept-charset="utf-8">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="row">
                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                             <div class="form-group">
                                 <label>Exam paper name<span class="req redbold">*</span></label>
                                 <input name="question_name" id="question_name" type="text" placeholder="Exam paper name" class="form-control" />
                             </div>
                         </div>
                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                             <div class="form-group">
                                 <label>Select exam model<span class="req redbold">*</span></label>
                                 <select name="exam_model" id="exam_model" class="form-control">
                                     <option value="">Select exam model</option>
                                     <?php
                                         if(!empty($examtemplates)){
                                             foreach($examtemplates as $row){
                                                 echo '<option value="'.$row->id.'">'.$row->exam_name.'</option>';
                                             }
                                         }
                                     ?>
                                 </select>
                             </div>
                         </div>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn_save">Continue</button>
                        <button type="button" data-dismiss="modal" class="btn btn-default btn_cancel">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="myModal2" class="modal fade modalCustom" role="dialog">
        <div class="modal-dialog" style="max-width: 767px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Autogenerate question paper</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form autocomplete="off" id="generate_question_paper_define" method="post" accept-charset="utf-8">
                    <div class="modal-body">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Question paper name<span class="req redbold">*</span></label>
                                    <input name="generate_question_name" id="generate_question_name" type="text" placeholder="Question paper name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select exam model<span class="req redbold">*</span></label>
                                    <select name="generate_exam_model" id="generate_exam_model" class="form-control">
                                        <option value="">Select exam model</option>
                                        <?php
                                            if(!empty($examtemplates)){
                                                foreach($examtemplates as $row){
                                                    echo '<option value="'.$row->id.'">'.$row->exam_name.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="question_paper_error"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="exam_model_modules"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn_save">Generate</button>
                        <button type="button" data-dismiss="modal" class="btn btn-default btn_cancel">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div id="modal" class="modal fade form_box modalCustom questionbank-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modal_body"></div>
            </div>
        </div>
    </div>
    <div id="finishmodal" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="text-align: center;" class="modal-title" id="finishmodal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="finishmodal_body"></div>
                <div class="modal-footer" id="finishmodal_footer"></div> 
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
                        <div class="table-responsive"  id="view_approval_status_table">
                                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/scripts/examManagement/question_papers_list_script'); ?>