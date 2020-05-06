
<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>&nbsp;</h6>
        <a class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" href="<?php echo $breadcrumb[1]['url'];?>">
            Back
        </a>
        <hr>
        <div class="row">
            <?php if(!empty($exam['passage'])){ ?>
                <div class="form-group col-sm-12">
                    <div class="title-header">Passage</div>
                    <div class="title-body"><?php echo $exam['passage']?></div>
                </div>
            <?php } ?>
                <div class="form-group col-sm-12">
                    <div class="title-header">Question</div>
                    <div class="title-body"><?php echo $exam['question']->question_content?></div>
                </div>
        </div>
        <hr>
        <h6>Answers</h6>
        <hr>
        <div class="table-responsive">
            <?php if(!empty($exam['answers'])){ ?>
            <table class="table table-bordered scrolling table-sm Tblcategory table-striped">
                <thead>
                    <tr class="bg-warning text-white">
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th>Answers</th>
                        <th>Status</th>
                        <th>Evaluated by</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($exam['answers'] as $k=>$answers){ ?>
                    <tr class="TblMinCategory">
                        <td><?php echo $k+1;?></td>
                        <td class = 'txtwrap'><?php 
                            echo limit_html_string(base64_decode($answers->selected_choices),10);
                        ?></td>
                        <td id="evaluate_status_<?php echo $answers->attempt.'_'.$answers->exam_id.'_'.$answers->question_id.'_'.$answers->student_id;?>">
                            <?php if($answers->correct){echo 'Evaluated';}else{echo 'Not Evaluated';}?>
                        </td>
                        <td id="evaluated_by_<?php echo $answers->attempt.'_'.$answers->exam_id.'_'.$answers->question_id.'_'.$answers->student_id;?>">
                            <?php echo $answers->evaluated_by;?>
                        </td>
                        <td>    
                            <?php if($answers->exam_schedule_status == 3){?>
                            <button id="evaluate_btn_<?php echo $answers->attempt.'_'.$answers->exam_id.'_'.$answers->question_id.'_'.$answers->student_id;?>" class="btn mybutton mybuttonnew" onclick="answer_evaluate(<?php echo $answers->attempt.','.$answers->exam_id.','.$answers->question_id.','.$answers->student_id;?>);">
                                <?php if($answers->correct){echo 'Re-evaluate';}else{echo 'Evaluate';}?>
                            </button>
                            <?php }else{ ?>
                            <button id="evaluate_btn_view_<?php echo $answers->attempt.'_'.$answers->exam_id.'_'.$answers->question_id.'_'.$answers->student_id;?>" class="btn mybutton mybuttonnew" onclick="answer_evaluate_view(<?php echo $answers->attempt.','.$answers->exam_id.','.$answers->question_id.','.$answers->student_id;?>);">
                               View
                            </button>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php }else{ ?>
                No students have attended this question.
            <?php } ?>
        </div>
    </div>
</div>
<div id="question_valuate" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Evaluate Descriptive Question</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="answer_evaluate" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="modal-body descriptive_question_box">
                    <div class="row" id="answer_details"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="question_valuate_view" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content cus_question">
            <div class="modal-header">
                <h4 class="modal-title">Evaluate Descriptive Question</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <div class="row" id="answer_details_view"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" data-dismiss="modal" type="button">Ok</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/scripts/examManagement/exam_evaluation_script'); ?>
