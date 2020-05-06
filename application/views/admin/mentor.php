<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <form id="search_form">
            <div class="row filter">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('centre');?></label>
                        <select class="form-control" id="filter_centre"  name="centre_id">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php $centre=$this->common->get_alldata('am_institute_master',array("institute_type_id"=>"3","status"=>"1"));
                            if(!empty($centre)){
                                foreach($centre as $val){?>
                                    <option value="<?php echo $val['institute_master_id']; ?>"><?php echo $val['institute_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('course');?></label>
                        <select class="form-control" id="filter_course" name="course_id">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>  
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label><?php echo $this->lang->line('batch');?></label>
                        <select class="form-control" id="filter_batch" name="batch_id">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 col-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-default add_row add_new_btn btn_add_call mentorReferences " onClick="redirect('backoffice/mentors-meeting');">
                            Mentors Meeting Schedule
                        </button>
                    </div>
                </div>
                <div class="col-sm-3 col-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-default add_row add_new_btn btn_add_call mentorReferences " onClick="redirect('backoffice/mentors-meeting-list');">
                            Mentors Meeting
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="white_card ">
        <h6>Assign Mentor</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <form id="mentor_form" method="post">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                    <div class="table-responsive table_language" style="margin-top:15px;">
                        <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        <?php echo $this->lang->line('sl_no');?>
                                    </th>
                                    <th>
                                        <?php echo $this->lang->line('application.no');?>
                                    </th>
                                    <th>
                                        <?php echo $this->lang->line('student_name');?>
                                    </th>
                                    <th>
                                        <label class="custom_checkbox"><?php echo $this->lang->line('action');?>
                                            <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
        <!-- Data Table Plugin Section Starts Here -->
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <!-- <input type="hidden" name="counter" id="counter" value="" /> -->
                    <div class="col--sm-6 col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('mentor');?><span class="req redbold">*</span></label>                  
                            <select class="form-control" id="staff_id"  name="staff_id">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php if(!empty($usersArr)){
                                        foreach($usersArr as $users){?>
                                            <?php if($users['role']=='management' || $users['role']=='faculty' || $users['role']=='centerhead'){ ?>
                                                <option value="<?php echo $users['personal_id'] ?>"><?php  echo $users['name'] ?></option>
                                            <?php }
                                        }
                                    }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <button class="btn btn-success btn_save">Save</button>
                    </div>
                </div> 
            </div>
        </form>
    </div>
</div>
<?php $this->load->view("admin/scripts/mentor_script");?> 
