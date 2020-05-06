<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Mentors Meeting List</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here --> 
        <!-- <div class="addBtnPosition">
            <button type="button" class="btn btn-default add_row add_new_btn btn_add_call mentorReferences " onClick="redirect('backoffice/mentors-meeting');">
                Mentors Meeting Schedule
            </button>  
        </div> -->
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th ><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('mentor');?></th>
                        <th ><?php echo $this->lang->line('date');?></th>
                        <th ><?php echo $this->lang->line('time');?></th>
                        <th ><?php echo $this->lang->line('class_room');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1;  
                foreach($meetingArr as $meeting){ ?>
                    <tr id="row_<?php echo $meeting['meeting_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="name_<?php echo $meeting['meeting_id'];?>">
                            <?php echo $meeting['name'];?>
                        </td>
                        <td id="date_<?php echo $meeting['meeting_id'];?>">
                            <?php echo $meeting['date'];?>
                        </td>
                        <td id="time_<?php echo $meeting['meeting_id'];?>">
                            <?php echo date('h:m a', strtotime($meeting['time']));?>
                        </td>
                        <td id="classroom_name_<?php echo $meeting['meeting_id'];?>">
                            <?php echo $meeting['classroom_name'];?>
                        </td>
                        <td>
                            <!-- <button  type="button" class="btn btn-default option_btn " onclick="get_details('<?php echo $meeting['meeting_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_meeting" style="color:blue;cursor:pointer;">
                                <i class="fa fa-eye "></i>
                            </button> -->
                            <button class="btn btn-default option_btn " title="Edit" data-toggle="modal" data-target="#edit_meeting" onclick="get_meetingdata(<?php echo $meeting['meeting_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <!-- <a class="btn btn-default option_btn" onclick="delete_route(<?php echo $meeting['meeting_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a> -->
                        </td>
                        
                    </tr>
                <?php $i++; } //} ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>



<!-- edit_meeting modal-->
<div id="edit_meeting" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Mentors Meeting Schedule</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="white_card">
                <form id="edit_search_form">
                    <div class="row filter">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-sm-3 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('centre');?></label>
                                <select class="form-control" id="edit_filter_centre"  name="centre_id">
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
                        <div class="col-sm-3 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('course');?></label>
                                <select class="form-control" id="edit_filter_course" name="course_id">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>  
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('batch');?></label>
                                <select class="form-control" id="edit_filter_batch" name="batch_id" onchange="edit_get_batch_id();">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('mentor');?></label>                  
                                <select class="form-control" id="edit_staff_id"  name="staff_id" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <form  id="edit_mentors_meeting_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="white_card meetinschedule"></div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="meeting_id" id="edit_meeting_id" value=""/>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                            <div class="table-responsive table_language" style="margin-top:15px;">
                                <table id="institute_data" class="table table-striped table-sm" style="width:100%">
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
                                                    <input type="checkbox" checked="checked" onclick="edit_check_all()" id="edit_main" >
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="centre_id" id="edit_get_center_id" />
                            <input type="hidden" name="course_id" id="edit_get_course_id" />
                            <input type="hidden" name="batch_id" id="edit_get_batch_id" />
                            <input type="hidden" name="staff_id" id="edit_get_staff_id" />
                            <input type="hidden" name="room_id" id="edit_room_id" />

                            <div class="col--sm-6 col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date');?><span class="req redbold">*</span></label>                  
                                    <input type="text" name="date" id="edit_date"  class="form-control dates" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col--sm-6 col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('time');?><span class="req redbold">*</span></label>                  
                                    <input type="text" name="time" id="edit_time" class="form-control time " autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col--sm-6 col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('class_room');?><span class="req redbold">*</span></label>                  
                                    <select class="form-control" id="edit_room_ids"  name="room_id">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>   
<?php $this->load->view("admin/scripts/mentors_meeting_list_script");?>
