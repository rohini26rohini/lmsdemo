
    <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
        <div class="white_card ">
                <h6>Auto generate Exam Paper</h6>
            <hr>
            <form autocomplete="off" id="generate_question_paper_define" method="post" accept-charset="utf-8">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Exam paper name<span class="req redbold">*</span></label>
                            <input name="generate_question_name" id="generate_question_name" type="text" placeholder="Exam paper name" class="form-control" />
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="exam_model_modules"></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="preview_question_paper"></div>
                </div>
                <button type="submit" class="btn btn-success btn_save">Auto Generate</button>
                <button type="button" onClick="redirect('backoffice/auto-generate-exam-paper');" data-dismiss="modal" class="btn btn-default btn_cancel">Reset</button>
                 <button type="button" id="save_question_paper" class="btn btn-primary pull-right">Save</button>
            </form>
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
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-info btn_cancel">OK</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('admin/scripts/examManagement/auto_generate_exam_paper_script'); ?>