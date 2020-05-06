<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">

<div class="white_card ">
        <h6><?php echo $this->lang->line('manage_room_booking');?></h6>
        <hr>
    <form id="allocate_student_room" type="post">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <input type="hidden" value="<?php if(!empty($studentid)){echo $studentid; }?>" id="studentid" name="from_registration"/>

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                         <input type="hidden" name="student" id="student"/>

                       
                        <div class="form-group">
                            <label><?php echo $this->lang->line('building');?><span class="req redbold">*</span></label>
                            <select class="form-control" name="building_id" id="building_id" onchange="get_rooms();">
                                <option value=""><?php echo $this->lang->line('select_building');?></option>
                                <?php   foreach($buildingArr as $row) {
                                            echo '<option value="'.$row['building_id'].'">'.$row['building_name'].'</option>';
                                        } ?>
                            </select>
                         </div>
                    </div>
                     <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('floor');?><span class="req redbold">*</span></label>
                            <select class="form-control" name="floor_id" id="floor_id" onchange="get_rooms();">
                                <option value=""><?php echo $this->lang->line('select_floor');?></option>

                            </select>
                         </div>
                    </div>
                     <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('roomtype');?><span class="req redbold">*</span></label>
                            <select class="form-control" name="roomtype_id" id="roomtype_id" onchange="get_rooms();">
                                                    <option value=""><?php echo $this->lang->line('select_roomtype');?></option>
                                                    <?php
                                                    foreach($roomTypeArr as $row) {
                                                        echo '<option value="'.$row['roomtype_id'].'">'.$row['room_type'].'</option>';
                                                    }
                                                    ?>
                            </select>
                         </div>
                    </div>


                </div>


                <div class="roomStructure" >
                    <label><?php echo $this->lang->line('rooms');?><span class="req redbold">*</span></label>
                    <ul class="rooms" id="show_rooms">
                     <!--<li>
                         <div class="roomSpan">
                                <span>33A</span>
                         </div>
                         <input type="radio" name="room"  data-toggle="modal" data-target="#myModal" data-placement="bottom"/>
                         <span class="roombed">3/10</span>
                    </li>
                    <li>
                        <div class="roomSpan">
                            <span>33A</span>
                        </div>
                        <input type="radio" name="room"  data-toggle="modal" data-target="#myModal" data-placement="bottom"/>
                        <span class="roombed">3/10</span>

                    </li>
                     <li class="roomFill">
                     <div class="roomSpan">
                            <span>33A</span>
                     </div>
                     <input type="radio" name="room" disabled data-toggle="modal" data-target="#myModal" data-placement="bottom"/>
                        <span class="roombed">3/10</span>
                        </li>-->
                    </ul>
                    <span id="room_msg" class="error"></span>
                </div>

            <span class="spanBold" id="show_fee"></span>
            <span class="error" id="save_alert" style="display:block"></span>
            <div class="row">
                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="form-group">
                      <button class="btn btn-info btn_save" onclick="clearfield()"><?php echo $this->lang->line('save');?></button>
                     </div>
                </div>
            </div>
        </form>
    </div>
</div>





  <div class="modal fade modalCustom " id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title"><?php echo $this->lang->line('student_list'); ?></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
           <form id="add_student_form" type="post">
               
                <div class="modal-body"> 
                    <div class="row">
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">

                            <label style="display:block"><?php echo $this->lang->line('student');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="student_list" id="show_students" style='width: 100%;'>
                                </select>
                            </div> 
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="bbb" class="btn btn-success" ><?php echo $this->lang->line('add');?></button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                </div>
        </form>
      </div>
      
    </div>
  </div>


<?php $this->load->view("admin/scripts/hostel_roombooking_script");?>
