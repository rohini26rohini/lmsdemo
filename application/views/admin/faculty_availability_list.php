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
<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <div class="row filter" id="example">
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="filter_name" id="filter_facultyname" class="form-control " placeholder="Search..." autocomplete="off"/>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label> Centre</label>
                    <select class="form-control filter_facultychange" name="filter_role" id="filter_centre">
                        <option value="">Select Centre</option>
                        <?php foreach($centreArr as $role){ ?>
                        <option value="<?php echo $role->institute_master_id; ?>">
                        <?php echo $role->institute_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div> 
            
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label style="display:block;">&nbsp;</label>
                    <button type="reset" class="btn btn-default add_row add_new_btn btn_add_call" id="reset_form" onclick="resetPage()">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="white_card ">
        <h6>Manage Faculty</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
       
        <button id="chartBlockBtn" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal">
            <?php echo $this->lang->line('add_availability');?>
        </button>
       <!-- <button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
            <i class="fa fa-upload"></i> Export
        </button>-->
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="faculty_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            <?php echo $this->lang->line('sl_no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('faculty_name');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('centre');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('available_days');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('action');?>
                        </th>
                    </tr>
                </thead>
                <?php
                $i = 1; 
                if(!empty($availabilityArr)) {
                    foreach($availabilityArr as $availability) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $availability->name;?>
                        </td>
                        <td>
                            <?php echo $availability->institute_name;?>
                        </td>
                        <td>
                            <?php   $days="";
                                    if($availability->type ==1)
                                    {
                                      if($availability->day_sun == 1){ $days.= "Sun ,"; }
                                      if($availability->day_mon == 1){ $days.= "Mon ,"; }
                                      if($availability->day_tue == 1){ $days.= "Tue ,"; }
                                      if($availability->day_wed == 1){ $days.= "Wed ,"; }
                                      if($availability->day_thu == 1){ $days.= "Thu ,"; }
                                      if($availability->day_fri == 1){ $days.= "Fri ,"; }
                                      if($availability->day_sat == 1){ $days.= "Sat "; }
                                        $days = rtrim($days, ',');
                                        echo $days;
                                    }
                                  else
                                  {
                                    $from=date('d/m/Y',strtotime($availability->date_from));
                                    $to=date('d/m/Y',strtotime($availability->date_to));
                                      echo $from ." to ".$to;
                                  }

                            ?>

                        </td>
                        <td>
                            <button class="btn btn-default option_btn" title="View" onclick="view_availability('<?php echo $availability->avai_id;?>')">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button id="chartBlockBtnEdit" class="btn btn-default option_btn" title="Edit" onclick="get_data('<?php echo $availability->avai_id; ?>','edit')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <button class="btn btn-default option_btn" title="Delete" onclick="delete_availability('<?php echo $availability->avai_id;?>')">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<div class="chartBlock" id="chartBlock"> 
    <div class="chartBlockWrapper">
        <button class="close_btn">
            <i class="fa fa-arrow-right"></i>
        </button>

        <div class="scroller" id="loadalldatas">
<!-- <div id="myModal" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('add_faculty_availability');?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div> -->
            <h4 class="modal-title" id="editavlHead">
                <?php echo $this->lang->line('add_faculty_availability');?>
            </h4>
            <form id="faculty_availability_form" type="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" id="edit_id" name="edit_id"/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('faculty');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="faculty" id="type">
                                    <option value="">Select</option>
                                    <?php foreach($staffArr as $staff){?>
                                    <option value="<?php echo $staff['personal_id'];?>"><?php echo $staff['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('group');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="group_name" id="group_name">
                                        <option value="">Select a group</option>
                                        <?php 
                                        foreach($groupArr as $row) {
                                            echo '<option value="'.$row['institute_master_id'].'">'.$row['institute_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('branch');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_name" id="branch_name">
                                        <option value="">Select a branch</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('centre');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="center_name" id="center_name">
                                        <option value="">Select a centre</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group" style="margin:0;"><label style="display:block"><?php echo $this->lang->line('type');?><span class="req redbold">*</span></label> </div>
                            <!--                                <input class=" " type="radio" name="type" value="1" checked/> Weekly   <input class="typeswitch" type="radio" name="type" value="2" /> Date-->
                            <div class="form-check-inline">
                                <label class="form-check-label custom_radio">
                            <input type="radio" class="form-check-input typeswitch" name="type" value="1" checked="checked">Weekly
                                      <span class="radiomark " ></span>
                          </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label custom_radio">
                            <input type="radio" class="form-check-input typeswitch" name="type" value="2">Date
                                      <span class="radiomark "></span>
                          </label>
                            </div>

                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 daterange" style="display:none;">
                            <div class="form-group"><label><?php echo $this->lang->line('start_date');?><span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="start_date" id="start_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 daterange" style="display:none;">
                            <div class="form-group"><label><?php echo $this->lang->line('end_date');?><span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="end_date" id="end_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="parent_div">

                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="weeklydiv">
                            <div class="form-group1">
                                <div class="table--responsive table_language">
                                    <table class="table table-bordered table-sm" style="text-align:center !important;">
                                        <tr style="background-color: rgb(0, 123, 255); color: #fff;font-family: s-bold;">
                                            <td class="text-center">Sun</td>
                                            <td class="text-center">Mon</td>
                                            <td class="text-center">Tue</td>
                                            <td class="text-center">Wed</td>
                                            <td class="text-center">Thu</td>
                                            <td class="text-center">Fri</td>
                                            <td class="text-center">Sat</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="sun" value="1" id="sunday" class="batch_session_days add_check"></td>
                                            <td><input type="checkbox" name="mon" value="1" id="monday" class="batch_session_days add_check"></td>
                                            <td><input type="checkbox" name="tue" value="1" id="tuesday" class="batch_session_days add_check"></td>
                                            <td><input type="checkbox" name="wed" value="1" id="wednesday" class="batch_session_days add_check"></td>
                                            <td><input type="checkbox" name="thu" value="1" id="thursday" class="batch_session_days add_check"></td>
                                            <td><input type="checkbox" name="fri" value="1" id="friday" class="batch_session_days add_check"></td>
                                            <td><input type="checkbox" name="sat" value="1" id="saturday" class="batch_session_days add_check"></td>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <!-- <button type="cancel" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
                </div>
            </form>
        </div>



    </div>

</div>
<!--editModal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('edit_faculty_availability');?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="edit_form" type="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" id="edit_id" name="edit_id"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('faculty');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="faculty" id="edit_type">
                                <option value="">Select</option>
                                    <?php foreach($staffArr as $staff){?>
                                    <option value="<?php echo $staff['personal_id'];?>"><?php echo $staff['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('group');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="group_name" id="edit_group_name">
                                        <option value="">Select a group</option>
                                        <?php
                                        foreach($groupArr as $row) {
                                            echo '<option value="'.$row['institute_master_id'].'">'.$row['institute_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('branch');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_name" id="edit_branch_name">
                                        <option value="">Select a branch</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('centre');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="center_name" id="edit_center_name">
                                        <option value="">Select a centre</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group" style="margin:0;">
                                <label style="display:block"><?php echo $this->lang->line('type');?>
                                    <span class="req redbold">*</span></label>
                            </div>

                            <div class="form-check-inline">
                                <label class="form-check-label custom_radio">
                            <input type="radio" class="form-check-input edit_typeswitch" name="type" value="1" checked="checked" id="edit_weekly">Weekly
                                      <span class="radiomark " ></span>
                          </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label custom_radio">
                            <input type="radio" class="form-check-input edit_typeswitch" name="type" value="2" id="edit_date">Date
                                      <span class="radiomark "></span>
                          </label>
                            </div>

                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_weeklydiv">
                            <div class="form-group">
                                <div class="table-responsive table_language">
                                    <table class="table  table-bordered table-striped text-center table-sm">
                                        <tr style="background-color: rgb(0, 123, 255); color: #fff;font-family: s-bold;">
                                            <td class="text-center">Sun</td>
                                            <td class="text-center">Mon</td>
                                            <td class="text-center">Tue</td>
                                            <td class="text-center">Wed</td>
                                            <td class="text-center">Thu</td>
                                            <td class="text-center">Fri</td>
                                            <td class="text-center">Sat</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="sun" value="1" id="sun" class="edit_check"></td>
                                            <td><input type="checkbox" name="mon" value="1" id="mon" class="edit_check"></td>
                                            <td><input type="checkbox" name="tue" value="1" id="tue" class="edit_check"></td>
                                            <td><input type="checkbox" name="wed" value="1" id="wed" class="edit_check"></td>
                                            <td><input type="checkbox" name="thu" value="1" id="thu" class="edit_check"></td>
                                            <td><input type="checkbox" name="fri" value="1" id="fri" class="edit_check"></td>
                                            <td><input type="checkbox" name="sat" value="1" id="sat" class="edit_check"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 editdaterange" style="display:none;">
                            <div class="form-group"><label><?php echo $this->lang->line('start_date');?><span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="start_date" id="edit_start_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 editdaterange" style="display:none;">
                            <div class="form-group"><label><?php echo $this->lang->line('end_date');?><span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="end_date" id="edit_end_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_parent_div">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>



    </div>
</div>

<div id="view_chartBlock" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Faculty Availability</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('faculty');?></label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewfaculty"></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('group');?></label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewgroup"></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('branch');?></label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewbranch"></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('centre');?></label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewcentre"></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="form-group">
                                <label>Type</label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewType"></label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="viewdate" style="display:none;">
                            <div class="form-group">
                                <label>Start date</label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewstartDate"></label>
                            </div>
                            <div class="form-group">
                                <label>End date</label>&nbsp;&nbsp;&nbsp;:
                                <label id="viewendDate"></label>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="form-group col-sm-4" id="sundaydiview" style="display:none;"></div>
                            <div class="form-group col-sm-4" id="mondaydiview" style="display:none;"></div>
                            <div class="form-group col-sm-4" id="tuesdaydiview" style="display:none;"></div>
                            <div class="form-group col-sm-4" id="wednesdaydiview" style="display:none;"></div>
                            <div class="form-group col-sm-4" id="thursdaydiview" style="display:none;"></div>
                            <div class="form-group col-sm-4" id="fridaydiview" style="display:none;"></div>
                            <div class="form-group col-sm-4" id="saturdaydiview" style="display:none;"></div>
                        </div></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/staff_script");?>
