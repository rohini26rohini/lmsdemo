
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                        <h6>Automated class scheduler</h6>
                        <hr>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                                <form autocomplete="off" id="schedule_exam_form" type="post">
                                    <div class="left_form">
                                        <div class="row">

                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Branch<span class="req redbold">*</span></label>
                                                    <select name="branch" id="branch" class="form-control">
                                                        <option value="">Select a Branch</option>
                                                        <?php
                                                            if(!empty($branch)){
                                                                foreach($branch as $row){
                                                                    echo '<option value="'.$row->institute_master_id.'">'.$row->institute_name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Center<span class="req redbold">*</span></label>
                                                    <select name="center" id="center" class="form-control">
                                                        <option value="">Select a Center</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Course<span class="req redbold">*</span></label>
                                                    <select name="course" id="course" class="form-control">
                                                        <option value="">Select a Course</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Batch<span class="req redbold">*</span></label>
                                                    <select name="batch" id="batch" class="form-control">
                                                        <option value="">Select a Batch</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 datefield">
                                                <div class="form-group"><label>Start Date (Optional)</label>
                                                    <input class="form-control calendarclass" type="text" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 datefield">
                                                <div class="form-group"><label>End date (Optional)</label>
                                                    <input class="form-control calendarclass" type="text" name="end_date" id="end_date"  placeholder="End date" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <button type="button" class="btn btn-default btn_left_form btn_save ">Cancel</button>
                                                <button type="submit" class="btn btn-info btn_save btn_left_form">View schedule</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div id='calendar' class="full_calender_wrap"></div>
                            </div>

                        </div>
                    </div>
                </div>
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
    <?php $this->load->view('admin/scripts/scheduler/class_schedule_script'); ?>