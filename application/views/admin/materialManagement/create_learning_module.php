
    <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 " id="expandBoard">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="white_card">
                    <h6>
                     <b>Edit learning module</b></h6>
                    <hr>
                    
                <button class="btn btn-default add_row add_new_btn  addBtnPosition btnExpand" id="btnExpand">
                    <i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
           <button class="btn btn-default add_row add_new_btn  addBtnPosition btnCompress" id="btnCompress">
                   <i class="fa fa-compress" aria-hidden="true"></i></button>
                   <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <h6>Course <i class="fa fa-angle-double-right"></i> <?php echo $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$learningModule->course));?></h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <h6>Subject <i class="fa fa-angle-double-right"></i> <?php echo $this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$learningModule->subject));?></h6>
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" id="name" name="name" value="<?php echo $learningModule->learning_module_name; ?>">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label style="display: block">&nbsp;</label>
                                <button class="btn btn-info btn_save_name pull-right">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="relative" id="question_select_section">
                        <button class="btn btn-info btn_ques save_selected">
                            <i class="fa fa-angle-double-right"></i>
                        </button>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <!-- <p style="text-align:left;">
                                    <span style="color:green;font-weight:bold;font-size:15px;">E</span> - Easy &nbsp;&nbsp;&nbsp;
                                    <span style="color:blue;font-weight:bold;font-size:15px;">M</span> - Medium &nbsp;&nbsp;&nbsp;
                                    <span style="color:red;font-weight:bold;font-size:15px;">H</span> - Hard
                                </p> -->
                                <div class="table-responsive table_language padding_right_15" style="/*overflow: scroll;height: 500px;*/">
                                    <table class="table table-bordered table-striped table-sm" id="section_questions">
                                        <tr>
                                            <th colspan="3">Select Questions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th>Question</th>
                                            <th></th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="table-responsive table_language padding_left_15" style="/*overflow: scroll;height: 500px;*/">
                                    <table class="table table-bordered table-striped table-sm" id="selected_questions">
                                        <tr>
                                            <th colspan="3">Selected Questions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th>Question</th>
                                            <th style="width: 50px;">
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal" class="modal fade form_box questionbank-modal" role="dialog">
        <div class="modal-dialog" >
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
    <?php $this->load->view('admin/scripts/materialManagement/learning_module_script'); ?>
