<style type="text/css">
	.bootsrap-datetimepickar-widget[style]{
		background: #ff0 !important;
		position: absolute  !important;
    	left: unset  !important;
    	right: 0px  !important;
    	top: 0px  !important;
    	bottom: auto !important;;
	}
	
</style>


<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card">
        <h6>Manage Batch</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->

        <?php //if(count($batchArr)>=3){ ?>
            <!-- <span class="btn-danger pull-right" style="padding: 2px 7px 2px 7px;margin-bottom: 7px;">
                Maximum batch creation limit exceeded for this license please reniew your license
            </span> -->
        <?php //}else{ ?>
            <div class="addBtnPosition">
                <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>backoffice/batch-merge">
                    Batch Mergings
                </a>
                <button class="chartBlockBtn btn btn-default add_row add_new_btn btn_add_call" onclick="clear_id(); formclear('add_batch_form');">
                    Add Batch
                </button>
            </div>
        <?php //} ?>

        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data1" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Batch</th>
                        <th>Batch code</th>
                        <th>Course</th>
                        <th>Centre</th>
                        <th><?php echo $this->lang->line('Allocated_Seats/Total_Seats');?></th>
                        <th>Action </th>
                    </tr>
                </thead>
                <?php  
            if(!empty($batchArr)) { 
            $i=1; foreach($batchArr as $batch){?>
                <tr id="row_<?php echo $batch['batch_id'];?>">

                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $batch['batch_name'];?>
                    </td>
                    <td>
                        <?php echo $batch['batch_code'];?>
                    </td>
                    <td>
                        <?php echo $batch['class_name'];?>
                    </td>
                    <td>
                        <?php echo $batch['institute_name'];?>
                    </td>
                    <td><?php $CI =& get_instance();
                          $allocated=$CI->allocated_students_inbatch($batch['batch_id']);
                          if($batch['batch_capacity']< $allocated) { echo '<span class="error">batch capacity exceeded.</span> Total seats:'.$batch['batch_capacity'].', Admitted:'. $allocated; } else { echo $allocated. " / ".$batch['batch_capacity']; }?>
                    </td>

                    <td>
                        <button type="button" class="btn btn-default option_btn " onclick="get_batch_details('<?php echo $batch['batch_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#show">
                            <i class="fa fa-eye "></i>
                        </button>
                        <!-- <button class="btn btn-default option_btn getbatchdetails" data-toggle="modal" data-target="#myModal"  id="<?php echo $batch['batch_id'];?>">
                        <i class="fa fa-pencil "></i>
                    </button>-->
                        <button class="btn btn-default option_btn getbatchdetails chartBlockBtn" title="Edit" id="<?php echo $batch['batch_id'];?>">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <button class="btn btn-default option_btn" title="Delete" onclick="delete_fromtable('<?php echo $batch['batch_id'];?>')">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>

                <?php $i++; }} 
            ?>

            </table>
            <!-- Data Table Plugin Section Starts Here -->
        </div>
    </div>
</div>

<!--modal-->



<div id="show" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Batch Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills ">
                    <table class="table table_register_view ">
                        <tbody>
                            <tr>
                                <th colspan="2">
                                    <h6 id="coursedet_view"></h6>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                    <div class="media">
                                        Batch Name :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="batchname_view"></span></label>
                                        </div>
                                    </div>
                                </th>
                                <th width="50%">
                                    <div class="media">
                                        Total No of Student :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="nostudent_view"></span></label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                    <div class="media">
                                        Start Date :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="startdate_view"></span></label>
                                        </div>
                                    </div>

                                </th>
                                <th width="50%">
                                    <div class="media">
                                        End Date :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="enddate_view"></span></label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                           <!-- <tr>
                                <th width="50%">
                                    <div class="media">
                                        Start Time :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="start_time_view"></span></label>
                                        </div>
                                    </div>
                                </th>

                                <th width="50%">
                                    <div class="media">
                                        End Time :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="end_time_view"></span></label>
                                        </div>
                                    </div>
                                </th>
                            </tr>-->
                            <tr>
                                <th width="50%">
                                    <div class="media">
                                        Last Date of Admission :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="last_date_view"></span></label>
                                        </div>
                                    </div>
                                </th>

                                <th width="50%">

                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <table class="table table_register table-bordered table-striped text-center">
                                        <h6>Week Days</h6>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">Sun</td>
                                                <td class="text-center">Mon</td>
                                                <td class="text-center">Tue</td>
                                                <td class="text-center">Wed</td>
                                                <td class="text-center">Thu</td>
                                                <td class="text-center">Fri</td>
                                                <td class="text-center">Sat</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_sun_view" style="display:none;">
                                                    
                                                </td>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_mon_view" style="display:none;">
                                                </td>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_tue_view" style="display:none;">
                                                </td>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_wed_view" style="display:none;">
                                                </td>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_thu_view" style="display:none;">
                                                </td>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_fri_view" style="display:none;">
                                                </td>
                                                <td class="text-center">
                                                    <img src="<?php echo base_url();?>inner_assets/images/check-mark.svg" width="16" id="batch_sat_view" style="display:none;">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td id="v_sun"></td>
                                                <td id="v_mon"></td>
                                                <td id="v_tue"></td>
                                                <td id="v_wed"></td>
                                                <td id="v_thu"></td>
                                                <td id="v_fri"></td>
                                                <td id="v_sat"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table_register table-bordered table-striped text-center">
                        <h6>Fee details</h6>
                        <tbody>
                            <tr>
                                <th>
                                    <div class="media">
                                        Tuition Fee : <label class="mt-0 ml-2 mb-0"><span id="tuition_fee_view"></span></label>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="media">
                                        CGST :<label class="mt-0 ml-2 mb-0"><span id="cgst_fee_view"></span></label>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="media">
                                        SGST :<label class="mt-0 ml-2 mb-0"><span id="sgst_fee_view"></span></label>
                                    </div>
                                </th>
                            </tr>
                            <tr id="cessrow">
                                <th>
                                    <div class="media">
                                        Cess [<span id="cess_fee_val"></span>] :<label class="mt-0 ml-2 mb-0"><span id="cess_fee_view"></span></label>

                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="media">
                                        Total Fee :<label class="mt-0 ml-2 mb-0"><span id="total_fee_view"></span></label>

                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="media">
                                        Mode of Pay:<label class="mt-0 ml-2 mb-0"><span id="mode_fee_view"></span></label>

                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div id="instalment_details">
                    </div>
                </ul>

                <div class="tab-content">
                    <div id="head1" class="tab-pane active">
                        <p id="errormsg"></p>
                        <form id="history" type="post">
                            <div class="row">
                                <input type="hidden" class="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="call_id" class="form-control exclude-status" id="history_call_id" />
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive table_language" id="history_view"></div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div id="head2" class="tab-pane">
                        <p id="errormsg"></p>
                        <form id="add_followup" type="post">
                            <div class="row">
                                <input type="hidden" class="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="call_id" class="form-control exclude-status" id="follow_call_id" />
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time<span class="req redbold">*</span></label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date" data-validate="required" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status<span class="req redbold">*</span></label>
                                        <select class="form-control" name="status" id="status" data-validate="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Answered</option>
                                            <option value="2">No Answer</option>
                                            <option value="3">Busy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Comments</label>
                                        <input class="form-control" type="text" name="comment" placeholder="Comments" id="comment" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-info">Update</button>
                                </div>
                               <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button type="button" class="btn btn-default close" data-dismiss="modal">Cancel</button>
                                </div>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chartBlock" id="chartBlock">
    <div class="chartBlockWrapper">
        <button class="close_btn">
            <i class="fa fa-arrow-right"></i>
        </button>

        <div class="scroller" id="loadalldatas">
            <h4 class="modal-title">Batch Management</h4>
            <form autocomplete="off" id="add_batch_form" type="post">
                <div class="modal-body">
                    <div class="tab-content">


                        <div class="row">

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input class="form-control" type="hidden" name="batch_id" id="batch_id">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Group<span class="req redbold">*</span></label>
                                    <select class="form-control" name="group_name" id="group_name">
                                        <!-- <option value="">Select a group</option> -->
                                        <?php 
                                        $x = 0;
                                        foreach($groupArr as $row) {
                                        ?>

                                        <option <?php if($x==0) { echo 'selected="selected"'; }?> value="<?php echo $row['institute_master_id']; ?>">
                                            <?php echo $row['institute_name']; ?>
                                        </option>
                                        <?php
                                            $x++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Branch<span class="req redbold">*</span></label>
                                    <select class="form-control" name="branch_name" id="branch_name">
                                        <option value="">Select a group</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Centre<span class="req redbold">*</span></label>
                                    <select class="form-control" name="center_name" id="center_name">
                                        <option value="">Select a branch</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Courses<span class="req redbold">*</span></label>
                                    <select class="form-control" name="course_name" id="course_name">
                                        <option value="">Select a Center</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Batch Name<span class="req redbold">*</span></label>
                                    <input class="form-control" type="text" name="batch_name" id="batch_name" placeholder="Batch Name">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Total No of Student<span class="req redbold">*</span></label>
                                    <input class="form-control numbersOnly" type="text" min="1" name="no_student" id="no_student" placeholder="Total No of Student">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Start Date<span class="req redbold">*</span></label>
                                    <input class="form-control calendarclass" type="text" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>End date<span class="req redbold">*</span></label>
                                    <input class="form-control calendarclass" type="text" name="end_date" id="end_date" placeholder="End date" autocomplete="off">
                                </div>
                            </div>

                            <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Session start time<span class="req redbold">*</span></label>
                                    <input class="form-control time" type="text" name="start_time" id="start_time" placeholder="Start time">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Session end time<span class="req redbold">*</span></label>
                                    <input class="form-control " type="time" name="end_time" id="end_time" placeholder="End time">
                                </div>
                            </div>-->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Last Date of Admission<span class="req redbold">*</span></label>
                                    <input class="form-control calendarclass" type="text" name="last_date" id="last_date" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="installments"> </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                            <div class="form-group1">
                                <label>Define weekly shifts<span class="req redbold">*</span></label>
                            </div>
                            <div class="table--responsive table_language">
                                <table class="table table-bordered table-sm" style="text-align:center !important;">
                                    <tr>
                                        <th>Sunday </th>
                                        <th>Monday </th>
                                        <th>Tuesday </th>
                                        <th>Wednesday </th>
                                        <th>Thursday </th>
                                        <th>Friday </th>
                                        <th>Saturday </th>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="weekday[]" value="sunday" id="sunday" class="batch_session_days" />
                                        </td>
                                        <td>
                                            <input type="checkbox" name="weekday[]" value="monday" id="monday" class="batch_session_days" />
                                            <!--<div id="monday_div"></div>-->
                                        </td>
                                        <td><input type="checkbox" name="weekday[]" value="tuesday" id="tuesday" class="batch_session_days" />
                                            <!--<div id="tuesday_div"></div>-->
                                        </td>
                                        <td><input type="checkbox" name="weekday[]" value="wednesday" id="wednesday" class="batch_session_days" /><!-- <div id="wednesday_div"></div>-->
                                        </td>
                                        <td><input type="checkbox" name="weekday[]" value="thursday" id="thursday" class="batch_session_days" />
                                            <!--<div id="thursday_div"></div>-->
                                        </td>
                                        <td><input type="checkbox" name="weekday[]" value="friday" id="friday" class="batch_session_days" />
                                            <!--<div id="friday_div"></div>-->
                                        </td>
                                        <td><input type="checkbox" name="weekday[]" value="saturday" id="saturday" class="batch_session_days" />
                                            <!--<div id="saturday_div"></div>-->
                                        </td>
                                    </tr>
                                    <tr id="show_td">
                                        <td>
                                            <table class="batch_days" id="sunday_div">

                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="monday_div">

                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="tuesday_div">

                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="wednesday_div">

                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="thursday_div">

                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="friday_div">

                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="saturday_div">

                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>




                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" id="batch_save">Save</button>
                    <button type="reset" class="btn btn-default date-close" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>

    </div>

</div>

<?php $this->load->view("admin/scripts/batch_script");?>
