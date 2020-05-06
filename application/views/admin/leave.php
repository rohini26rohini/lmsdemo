<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Manage Leave</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here --> 
        <div class="addBtnPosition">
        <?php if(check_module_permission('approval_list')){ ?>
            <button class="btn btn-default add_row btn_map" onClick="redirect('backoffice/approval-list');">
                Leave Approval
            </button>   
        <?php } ?>
            <button class="btn btn-default add_row add_new_btn btn_add_call clear_date" data-toggle="modal" data-target="#add_leave" onclick="formclear('add_leave_form')">
                Add Leave
            </button>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th ><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('leave_type');?></th>
                        <th ><?php echo $this->lang->line('start_date');?></th>
                        <th ><?php echo $this->lang->line('end_date');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($leaveArr as $leave){ 
                ?>
                    <tr id="row_<?php echo $leave['leave_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="head_<?php echo $leave['leave_id'];?>">
                            <?php echo $leave['head'];?>
                        </td>
                        <td id="start_date_<?php echo $leave['leave_id'];?>">
                            <?php echo date('d-m-Y',strtotime($leave['start_date']));?>
                        </td>
                        <td id="end_date_<?php echo $leave['leave_id'];?>">
                            <?php echo date('d-m-Y',strtotime($leave['end_date']));?>
                        </td>
                        <td id="leave_status_<?php echo $leave['leave_id'];?>">
                            <?php if($leave['leave_status']==0){echo '<span class="pending">Pending</span>';}else if($leave['leave_status']==1){echo '<span class="approved">Approved</span>';} else{echo '<span class="denied">Rejected</span>';} ?>
                        </td>
                        <td>
                            <?php if($leave['leave_status']==0){ ?>
                            <button class="btn btn-default option_btn " title="View" onclick="view_leave(<?php echo $leave['leave_id'];?>)">
                                <i class="fa fa-eye "></i>
                            </button>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_leavedata(<?php echo $leave['leave_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_leave(<?php echo $leave['leave_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <?php }else{ ?>
                                <button class="btn btn-default option_btn " title="View" onclick="view_leave(<?php echo $leave['leave_id'];?>)">
                                    <i class="fa fa-eye "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_leave(<?php echo $leave['leave_id'];?>)">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            <?php  } ?>
                        </td>
                    </tr>
                <?php $i++; }  ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--add leave modal-->
<div id="add_leave" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Leave</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_leave_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" class ="exclude-status" name="user_id" id="user_id" value="<?php if(!empty($staff_id['personal_id'])) {echo $staff_id['personal_id']; }?>" />
                        <input type="hidden" class ="exclude-status" name="reporting_head" value="<?php if(!empty($staff_id['reporting_head'])) {echo $staff_id['reporting_head']; }?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('leave_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="type_id" id="id">
                                    <option value="">Select Leave Type</option>
                                    <?php foreach($typeArr as $type){
                                        // $selected = '';
                                        // if($typeArr['id'] == $type['id']){
                                        //     $selected = 'selected="selected"';
                                        // }
                                        echo '<option value="'.$type['id'].'" >'.$type['head'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('start_date');?><span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('end_date');?></label><span class="req redbold"> *</span>
                                <input class="form-control calendarclass" type="text" name="end_date" id="end_date"  placeholder="End date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('subject');?><span class="req redbold">*</span></label>
                                <input class="form-control " type="text" name="title"  placeholder="Subject" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('reason');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" name="description" placeholder="Content"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                            <!-- <label>Number of Days</label> -->
                                <input class="form-control" type="hidden" name="num_days" id="num_days" placeholder="Number of Days" autocomplete="off">
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

<!--edit leave modal-->
<div id="edit_leave" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Leave</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_leave_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="leave_id" id="edit_leave_id" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('leave_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="type_id" id="edit_id">
                                    <option value="">Select Leave Type</option>
                                    <?php foreach($typeArr as $type){
                                        $selected = '';
                                        if($typeArr['id'] == $type['id']){
                                            $selected = 'selected="selected"';
                                        }
                                        echo '<option value="'.$type['id'].'" '.$selected.'>'.$type['head'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('start_date');?><span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="start_date" id="edit_start_date" placeholder="Start Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('end_date');?></label><span class="req redbold">*</span>
                                <input class="form-control calendarclass" type="text" name="end_date" id="edit_end_date"  placeholder="End date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('subject');?><span class="req redbold">*</span></label>
                                <input class="form-control " type="text" name="title" id="edit_title"  placeholder="Subject" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('reason');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" name="description" id="edit_description" placeholder="Content"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                            <!-- <label>Number of Days</label> -->
                                <input class="form-control calendarclass" type="hidden" name="num_days" id="edit_num_days" placeholder="Number of Days" autocomplete="off">
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

<!--view leave modal-->
<div id="view_leaves" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Leave</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table_view_model">
                    <table class="table table-striped">
                        <tr>
                            <th>Leave Type :</th>
                            <td id="view_head"></td>
                        </tr>
                        <tr>
                            <th>Start Date :</th>
                            <td id="view_start_date"> </td>
                        </tr>
                        <tr>
                            <th>End Date :</th>
                            <td id="view_end_date"> </td>
                        </tr>
                        <tr>
                            <th>Subject :</th>
                            <td id="view_title"> </td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('reason');?> :</th>
                            <td id="view_description"> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/leave_script");?>
