<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage Hostel Room Type</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
       
                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition"data-toggle="modal" data-target="#myModal" onclick="formclear('add_roomtype_form')">
                                    <?php echo $this->lang->line('add_room_types');?>
                                </button>

         
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('room_type');?></th>
                <th><?php echo $this->lang->line('facilities');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1;foreach($roomtypeArr as $type){?>
                <tr>
                    <td><?php echo $i;?></td>
                 <td><?php echo $type['room_type'];?></td>
                 <td><?php echo $type['facilities'];?></td>
                 <td><?php if ($type['roomtype_status'] == "0") {  $status=1;?>
                   <span class="btn mybutton mybuttonInactive" onclick="edit_roomtype_status(<?php echo $type['roomtype_id'];?>,<?php echo $status;?>);">Inactive</span>
                 <?php   }
                    else
                    { $status=0;?>
                       <span class="btn mybutton mybuttonActive" onclick="edit_roomtype_status(<?php echo $type['roomtype_id'];?>,<?php echo $status;?>);">Active</span>
                  <?php  }?>
                    </td>
                 <td><button class="btn btn-default option_btn " title="Edit" onclick="get_roomtypedata(<?php echo $type['roomtype_id'];?>)">
                     <i class="fa fa-pencil "></i></button>
                     <?php if($type['roomtype_status'] == "0"){?>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_roomtypedata(<?php echo $type['roomtype_id'];?>)"><i class="fa fa-trash-o"></i>
                    </a>
                     <?php } ?>
                    </td>
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

         Modal content
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_room_types');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
             <form id="add_roomtype_form">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_type');?><span class="req redbold">*</span></label>
                                    <input class="form-control" type="text" name="room_type" placeholder="Room Type" onkeypress="return addressValidation(event)">
                            </div>
                                </div>



                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('facilities_label');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" type="text" name="facilities" placeholder="Facilities" onkeypress="return addressValidation(event)"></textarea>
                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">


                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">



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

         Modal content
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_room_types');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                            <form id="edit_roomtype_form">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="hidden" name="roomtype_id" id="roomtype_id"/>
                            <div class="form-group"><label><?php echo $this->lang->line('room_type');?><span class="req redbold">*</span></label>
                                    <input class="form-control" type="text" name="room_type" placeholder="Room Type" onkeypress="return addressValidation(event)" id="roomtype">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('facilities_label');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" type="text" name="facilities" placeholder="Facilities" onkeypress="return addressValidation(event)" id="facility"></textarea>
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


<?php $this->load->view("admin/scripts/hostel_roomtype_script");?>
