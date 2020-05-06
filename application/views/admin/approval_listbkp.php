<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Approval List</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here --> 
        <div class="addBtnPosition">
            <button class="btn btn-default add_row btn_map" onClick="redirect('backoffice/approval-list');">
                Leave Approval
            </button>    
            <button class="btn btn-default add_row add_new_btn btn_add_call"  onClick="redirect('backoffice/manage-leave');">
                Add Leave
            </button>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th ><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('name');?></th>
                        <th ><?php echo $this->lang->line('leave_type');?></th>
                        <th ><?php echo $this->lang->line('start_date');?></th>
                        <th ><?php echo $this->lang->line('end_date');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1;  
                foreach($approvalArr as $approve){ echo $approve['reporting_head'].'-'.$staff_id['reporting_head'];
                    //if($approve['reporting_head']!=$staff_id['reporting_head']){
                ?>
                    <tr id="row_<?php echo $approve['leave_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="name_<?php echo $approve['leave_id'];?>">
                            <?php echo $approve['name'];?>
                        </td>
                        <td id="head_<?php echo $approve['leave_id'];?>">
                            <?php echo $approve['head'];?>
                        </td>
                        <td id="start_date_<?php echo $approve['leave_id'];?>">
                            <?php echo $approve['start_date'];?>
                        </td>
                        <td id="end_date_<?php echo $approve['leave_id'];?>">
                            
                        <?php 
                        if($approve['end_date']==''){
                            echo '';
                        }else{
                            echo $approve['end_date'];
                        } 
                            ?>
                        </td>
                        <td id="leave_status_<?php echo $approve['leave_id'];?>">
                            <?php //echo $approve['leave_status'];?>
                            <?php if($approve['leave_status']=="0"){ echo '<a href="#"><span class="pending" onclick="edit_leave_status('.$approve['leave_id'].','.$approve['leave_status'].'); ">Pending</span></a>';}else if($approve['leave_status']=="1"){ echo '<a href="#"><span name="reject_status" id="reject_status_'.$approve['leave_id'].'" class="approved" onclick="get_val('.$approve['leave_id'].');">Approved</span></a>';} else{ echo '<a href="#"><span class="denied" onclick="edit_leave_status('.$approve['leave_id'].','.$approve['leave_status'].');">Rejected</span></a>';} ?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="View" onclick="view_leave(<?php echo $approve['leave_id'];?>)">
                                    <i class="fa fa-eye "></i>
                                </button>
                        </td>
                    </tr>
                <?php $i++; } //} ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--leave rejection reason modal-->
<div id="description_modal" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reason for Reject your Leave Application</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <form id="add_description" type="post">
                        <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="leave_id" class="form-control" id="leave_id" />
                            <input type="hidden" name="status" class="form-control" id="status" />
                            <!-- <input type="hidden" name="user_id" class="form-control" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>"/> -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group"><label> Reason</label>
                                    <input class="form-control" type="text" name="description" placeholder="Reason" id="description">
                                </div>
                            </div>
                            <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <button class="btn btn-info">Save</button>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>-->
                        </div>
                    </form>
                </div>
            </div>
             <div class="modal-footer ">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
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
                            <th>Content :</th>
                            <td id="view_description"> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/leave_script");?>
