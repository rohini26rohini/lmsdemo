<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
         <h6>Manage Class Rooms</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row btn_map btn_add_call addBtnPosition" data-toggle="modal" onclick="formclear('add_classrooms_form')" data-target="#add_classrooms">
            Add Class Room
        </button>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="table-responsive table_language" style="margin-top:15px;">
                    <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">Sl. No.</th>
                                <th>Centre</th>
                                <th>Class Name</th>
                                <th>Total Occupancy</th>
                                <th>Class Room Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php $i=1;
                        foreach($classroomsArr as $rooms){?>
                        <tr id="row_<?php echo $rooms['room_id'];?>">
                            <td><?php echo $i;?></td>
                            <td id="institute_name_<?php echo $rooms['room_id'];?>">
                                <?php echo $rooms['institute_name'];?></td>
                            <td id="classroom_name_<?php echo $rooms['room_id'];?>">
                                <?php echo $rooms['classroom_name'];?></td>
                            <td id="classroom_name_<?php echo $rooms['total_occupancy'];?>">
                                <?php if($rooms['total_occupancy'] == "0"){echo $rooms['total_occupancy']="";}else{echo $rooms['total_occupancy'];}?></td>
                            <td>
                                <?php 
                                    if($rooms['type'] == "1"){
                                        echo "Class Room";
                                    }elseif($rooms['type'] == "2"){
                                        echo "Lab";
                                    }
                                  else
                                  {
                                      echo "Virtual Classroom";
                                  }
                                ?>
                            </td>
                            <td>
                                <button  type="button" class="btn btn-default option_btn " onclick="get_details('<?php echo $rooms['room_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_classrooms" style="color:blue;cursor:pointer;">
                                    <i class="fa fa-eye "></i>
                                </button>
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_classroomsdata(<?php echo $rooms['room_id'];?>); edit_types(<?php echo $rooms['room_id'];?>);" >
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_fromtable(<?php echo $rooms['room_id'];?>)">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $i++;} ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table Plugin Section Starts Here -->
</div>

<!--edit classroom modal-->
<div id="edit_classrooms" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Class Name</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_classrooms_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" class ="exclude-status" name="room_id" id="edit_room_id" />
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label>Group<span class="req redbold">*</span></label>
                                <input class ="exclude-status" name="room_id" id="mapping_id" type="hidden" />
                                <select class="form-control" name="group_master_id" id="group1">
                                    <option value="">Select</option>
                                    <?php
                                    foreach($groupArr as $group){?>
                                    <option value="<?php  echo $group['institute_master_id'] ?>"><?php  echo $group['institute_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label>Branch<span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_master_id" id="branch1">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label>Centre<span class="req redbold">*</span></label>
                                <select class="form-control" name="institute_master_id" id="center1">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group"><label>Class Name<span class="req redbold">*</span></label>
                                <input type="text" name="classroom_name" id="classroom_name" class="form-control" placeholder="Class Name" data-validate="required"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label >Class Room Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="edit_type" onchange="edit_types();">
                                    <!-- <option value="">Select</option> -->
                                    <option value="1">Class Room</option>
                                    <option value="2">Lab</option>
                                    <option value="3">Virtual Classroom</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 other" id="edit_other">
                            <div class="form-group"><label>Total Occupancy  <span class="req redbold">*</span></label>
                                <input type="text" name="total_occupancy" id="edit_total_occupancy" class="form-control" placeholder="Total Occupancy" data-validate="required"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <!-- <button class="btn btn-default" data-dismiss="modal">Cancel</button> -->
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>

                </div> 
            </form>
        </div>
    </div>
</div>

<!--view classroom modal-->
<div id="view_classrooms" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Classrooms</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table_view_model">
                    <table class="table table-striped">
                        <tr>
                            <th>Group:</th>
                            <td id="group_view"></td>
                        </tr>
                        <tr>
                            <th>Branch:</th>
                            <td id="branch_view"> </td>
                        </tr>
                        <tr>
                            <th>Centre:</th>
                            <td id="centre_view"> </td>
                        </tr>
                        <tr>
                            <th>Class Name:</th>
                            <td id="class_name_view"> </td>
                        </tr>
                        <tr>
                            <th>Total Occupancy:</th>
                            <td id="total_occupancy_view"> </td>
                        </tr>
                        <tr>
                            <th>Class Room Type:</th>
                            <td id="room_type_view"> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--add classroom modal-->
<div id="add_classrooms" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Class Name</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form id="add_classrooms_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label >Group<span class="req redbold">*</span></label>
                                <input name="room_id" id="mapping_id" class ="exclude-status" type="hidden" />
                                <select class="form-control" name="group_master_id" id="group">
                                    <option value="">Select</option>
                                    <?php
                                    foreach($groupArr as $group){?>
                                    <option value="<?php  echo $group['institute_master_id'] ?>"><?php  echo $group['institute_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label >Branch<span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_master_id" id="branch">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label >Centre<span class="req redbold">*</span></label>
                                <select class="form-control" name="institute_master_id" id="center">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group "><label >Class Name<span class="req redbold">*</span></label>
                                <input type="text" name="classroom_name" class="form-control" placeholder="Class Name" data-validate="required" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <div class="form-group">
                                <label >Class Room Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="type" onchange="roomtype();">
                                    <!-- <option value="">Select</option> -->
                                    <option value="1" selected>Class Room</option>
                                    <option value="2">Lab</option>
                                    <option value="3">Virtual Classroom</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 other" id="other">
                            <div class="form-group"><label>Total Occupancy  <span class="req redbold">*</span></label>
                                <input type="text" name="total_occupancy" id="total_occupancy" class="form-control numbersOnly" maxlength="3" placeholder="Total Occupancy" data-validate="required"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                    <!-- <button class="btn btn-default" type="reset" onclick="clear_id()">Cancel</button> -->
                </div> 
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/classrooms_script.php");?>
