<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6>Manage Hostel Rooms</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
       
                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_room_form')">
                                   <?php echo $this->lang->line('add_new_room');?>
                                </button>

           
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('building_name');?></th>
                <th><?php echo $this->lang->line('floor');?></th>
                <th><?php echo $this->lang->line('roomtype');?></th>
                <th><?php echo $this->lang->line('room_no');?></th>
                <th><?php echo $this->lang->line('accomadatable_persons');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1;foreach($roomArr as $room){?>
                <tr>
                    <td><?php echo $i;?></td>
                 <td><?php echo $room['building_name'];?></td>
                 <td><?php echo $room['floor'];?></td>
                 <td><?php echo $room['room_type'];?></td>
                 <td><?php echo $room['room_number'];?></td>
                 <td><?php echo $room['room_capacity'];?></td>
                 <td><?php  if ($room['room_status'] == "0") {  $status=1;?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_room_status(<?php echo $room['room_id'];?>,<?php echo $status;?>);">Inactive</span>
                 <?php      }else{ $status=0;?>
                                <span class="btn mybutton mybuttonActive" onclick="edit_room_status(<?php echo $room['room_id'];?>,<?php echo $status;?>);">Active</span>
                  <?php     }?>
                </td>
                <td><button class="btn btn-default option_btn "  title="Edit" onclick="get_roomdata(<?php echo $room['room_id'];?>)">
                    <i class="fa fa-pencil "></i></button>
                     <?php if ($room['room_status'] == "0") { ?>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_roomdata(<?php echo $room['room_id'];?>)"><i class="fa fa-trash-o"></i>
                    </a><?php } ?></td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_room');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                 <form id="add_room_form" type="post">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('building');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="building_id" id="building_id">
                                        <option value=""><?php echo $this->lang->line('select_building');?></option>
                                        <?php 
                                        foreach($buildingArr as $row) {
                                            echo '<option value="'.$row['building_id'].'">'.$row['building_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                       
                       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('floor');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="floor_id" id="floor_id">
                                        <option value=""><?php echo $this->lang->line('select_floor');?></option>
                                       
                                    </select>
                        </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_type');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="roomtype_id" id="roomtype_id">
                                        <option value=""><?php echo $this->lang->line('select_roomtype');?></option>
                                        <?php 
                                        foreach($roomTypeArr as $row) {
                                            echo '<option value="'.$row['roomtype_id'].'">'.$row['room_type'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_no');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="room_number" placeholder="Room Number" onkeypress="return addressValidation(event)"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_capacity');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="room_capacity" placeholder="Room Capacity" onkeypress="return valNum(event)">
                            </div>
                        </div>
                       
                      


                    </div>

            </div>
                     <div class="modal-footer">
                      <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>

                            <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                     </div>
                </form>
        </div>

    </div>
</div>
<!--edit modal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_new_room');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                            <form id="edit_room_form" type="post">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="room_id" id="room_id"/>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('building');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="building_id" id="edit_building_id">
                                        <option value=""><?php echo $this->lang->line('select_building');?></option>
                                        <?php
                                        foreach($buildingArr as $row) {
                                            echo '<option value="'.$row['building_id'].'">'.$row['building_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('floor');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="floor_id" id="edit_floor_id">
                                        <option value=""><?php echo $this->lang->line('select_floor');?></option>

                                    </select>
                        </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_type');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="roomtype_id" id="edit_roomtype_id">
                                        <option value=""><?php echo $this->lang->line('select_roomtype');?></option>
                                        <?php
                                        foreach($roomTypeArr as $row) {
                                            echo '<option value="'.$row['roomtype_id'].'">'.$row['room_type'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_no');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="room_number" placeholder="Room Number" onkeypress="return addressValidation(event)" id="edit_roomno"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_capacity');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="room_capacity" placeholder="Room Capacity" onkeypress="return valNum(event)" id="edit_room_capcity">
                            </div>
                        </div>


                    </div>

            </div>
                                <div class="modal-footer">
                                                            <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
  <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                                </div>
     </form>
        </div>

    </div>
</div>



<?php $this->load->view("admin/scripts/hostel_room_script");?>
