
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                        <h6>Schedule Exam</h6>
                        <hr>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                                <form autocomplete="off" id="schedule_exam_form" type="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />       
                                <input type="hidden" name="schedule_id" value="<?php if(isset($details)){echo $details->id;}?>">   
                                <input type="hidden" name="calendar_schedule_id" value="<?php if(isset($details)){echo $details->schedule_id;}?>">   
                                    <div class="left_form">
                                        <div class="row">
                                        
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam name<span class="req redbold">*</span></label>
                                                    <input type="text" placeholder="Exam name" value="<?php if(isset($details)){echo $details->name;} ?>" name="examname" id="examname" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam start date<span class="req redbold">*</span></label>
                                                    <input type="text" value="<?php if(isset($details)){
                                                        if(strtotime($details->start_date_time) >= strtotime("+1 day")){
                                                            $start_date_time = strtotime($details->start_date_time);
                                                        }else{
                                                            $start_date_time = strtotime("+1 day",time());
                                                        }
                                                        echo date('d-m-Y',$start_date_time);
                                                    } ?>" name="examdate" id="examdate" class="form-control duedate" />
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Time<span class="req redbold">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" value="<?php if(isset($details)){echo date('h:i a',strtotime($details->start_date_time));} ?>" name="starttime" id="starttime" class="form-control time" placeholder="Start Time">
                                                        <input type="text" value="<?php if(isset($details)){echo date('h:i a',strtotime($details->end_date_time));} ?>" name="endtime" id="endtime" class="form-control time" placeholder="End Time">
                                                    </div>    
                                                    <label id="duration-error" class="error"></label>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Center<span class="req redbold">*</span></label>
                                                    <select name="center" id="center" class="form-control">
                                                        <option value="">Select a center</option>
                                                        <?php
                                                            if(!empty($centers)){
                                                                foreach($centers as $row){
                                                                    echo '<option value="'.$row->institute_master_id.'">'.$row->institute_name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Batch<span class="req redbold">*</span></label>
                                                    <select name="batch" id="batch" class="form-control">
                                                        <option value="">Please select a center to select its batches</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam Model<span class="req redbold">*</span></label>
                                                    <select name="exammodel" id="exammodel" class="form-control">
                                                        <option value="">Select an exam model</option>
                                                        <?php
                                                            if(!empty($exammodels)){
                                                                foreach($exammodels as $row){
                                                                    echo '<option value="'.$row->id.'">'.$row->exam_name.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    <label id="exam_duration"></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam Paper<span class="req redbold">*</span></label>
                                                    <select name="exampapers[]" id="exampapers" multiple="multiple" class="form-control" style="height: 100px !important;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam Room<span class="req redbold">*</span></label>
                                                    <select name="examroom" id="examroom" class="form-control">
                                                        <option value="">Select an exam room</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam type<span class="req redbold">*</span></label><br>
                                                    <select name="result" id="result" class="form-control">
                                                        <option value="">Select an exam type</option>
                                                        <option <?php if(isset($details)){if($details->result_immeadiate==0){ echo ' selected ';}}?> value="0">Final exam</option>
                                                        <option <?php if(isset($details)){if($details->result_immeadiate==1){ echo ' selected ';}}?> value="1">Mock exam</option>
                                                    </select>
                                                    <!-- <label>Mock exam&nbsp;&nbsp;<input value="1" type="radio" <?php if(isset($details)){if($details->result_immeadiate==1){ echo ' checked="true" ';}else{echo ' checked="false" ';}}?> name="result" id="result"/></label>&nbsp;&nbsp;&nbsp;
                                                    <label>Final exam&nbsp;&nbsp;<input value="0" type="radio" <?php if(isset($details)){if($details->result_immeadiate==0){ echo ' checked="true" ';}}else{echo ' checked="true" ';}?> name="result" id="result"/></label> -->
                                                </div>
                                            </div>
                                            <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label>Exam end time<span class="req redbold">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" value="<?php if(isset($details)){echo date('h:i a',strtotime($details->start_date_time));} ?>" name="starttime" id="starttime" class="form-control time" placeholder="Start Time">
                                                        <input type="text" value="<?php if(isset($details)){echo date('h:i a',strtotime($details->end_date_time));} ?>" name="endtime" id="endtime" class="form-control time" placeholder="End Time">
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <button type="button" onClick="go_back()" class="btn btn-default btn_left_form btn_save ">Back</button>
                                                <button type="submit" class="btn btn-info btn_save btn_left_form">Save</button>
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
    <div id="errormodal" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="text-align: center;" class="modal-title" id="errormodal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="errormodal_body"></div>
                <div class="modal-footer" id="errormodal_footer">
                    <button type="button" class="btn btn-danger" onclick="force_exam_schedule()" data-dismiss="modal">Skip Classes and Schedule Exam</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div> 
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/scripts/examManagement/exam_schedule_script'); ?>
