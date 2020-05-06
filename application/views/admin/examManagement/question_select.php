
    <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 " id="expandBoard">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="white_card">
                    <h6><?php echo $question_paper->exam_paper_name?> - Question Paper Setup</h6>
                    <hr>
                    
                <button class="btn btn-default add_row add_new_btn  addBtnPosition btnExpand" id="btnExpand">
                    <i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
           <button class="btn btn-default add_row add_new_btn  addBtnPosition btnCompress" id="btnCompress">
                   <i class="fa fa-compress" aria-hidden="true"></i></button>
                 
                    <div class="row">
                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
                            <div class="form-group">
                                <label>Exam Model</label>
                                <input readonly type="text" class="form-control" value="<?php echo $question_paper->exam_name?>">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label style="display: block">&nbsp;</label>
                                <button class="btn btn-info btn_save pull-right">Save & Preview</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select an exam section</label>
                                <select id="section" class="form-control">
                                    <option value="">Select a section</option>
                                    <?php
                                        if(!empty($sections)){
                                            foreach($sections as $row){
                                                echo '<option value="'.$row->id.'">'.$row->section_name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select modules</label>
                                <select id="module" class="form-control">
                                    <option value="">Select a section</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="ques_stat">
                            <?php
                                if(!empty($sections)){
                                    foreach($sections as $row){
                                        echo '<span>'.$row->section_name.' : <span id="sectioncount'.$row->id.'">'.$row->count.'</span></span>';
                                    }
                                }
                            ?>
                            </p>
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
    <div class="chartBlock" id="chartBlock">
        <div class="chartBlockWrapper">
            <button class="close_btn">
                <i class="fa fa-arrow-right"></i>
            </button>
            <div class="scroller dirroombooking" id="loadalldatas">
                <div class="modal-header">
                    <h4>Questions Reordering. <small><i> Drag and shuffle the questions to reorder</i></small></h4>
                </div>
                <div class="modal-body">
                    <div class="row" id="questions_list"></div>
                </div>
                <div class="modal-footer">
                    <button onClick="save_reordered_questions()" class="btn btn-success">Save</button>
                    <button onClick="reorder_paper()" class="btn btn-primary">Reset</button>
                </div> 
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/scripts/examManagement/question_select_script'); ?>
