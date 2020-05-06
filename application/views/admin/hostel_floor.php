<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
          <h6>Manage Hostel Floor</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
     
                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_floor_form')">
                                  <?php echo $this->lang->line('add_new_floor');?>
                                </button>

           
              <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('building_name');?></th>
                <th><?php echo $this->lang->line('floor');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1;foreach($floorArr as $floor){?>
                <tr id="row_<?php echo $floor['floor_id'];?>">
                    <td><?php echo $i;?></td>
                 <td><?php echo $floor['building_name'];?></td>
                 <td><?php echo $floor['floor'];?></td>
                 <td><?php if ($floor['floor_status'] == "0") {  $status=1;?>
                   <span class="btn mybutton mybuttonInactive" onclick="edit_floor_status(<?php echo $floor['floor_id'];?>,<?php echo $status;?>);">Inactive</span>
                 <?php   } 
                    else 
                    { $status=0;?>
                       <span class="btn mybutton mybuttonActive" onclick="edit_floor_status(<?php echo $floor['floor_id'];?>,<?php echo $status;?>);">Active</span>
                  <?php  }?>
                    </td>
                 <td><button class="btn btn-default option_btn " title="Edit" onclick="get_floordata(<?php echo $floor['floor_id'];?>)">
                     <i class="fa fa-pencil "></i></button>
                     <?php if($floor['floor_status'] == "0"){?>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_floordata(<?php echo $floor['floor_id'];?>)"><i class="fa fa-trash-o"></i>
                    </a> <?php } ?>
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_floor');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
             <form id="add_floor_form" type="post">
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
                                <input class="form-control" type="text" name="floor" placeholder="Floor Name" onkeypress="return addressValidation(event)"></div>
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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_floor_details');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
               <form id="edit_floor_form" type="post">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="hidden" name="floor_id" id="edit_floor_id"/>
                            <div class="form-group"><label><?php echo $this->lang->line('building');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="building_id" id="building">
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
                                <input class="form-control" type="text" name="floor" placeholder="Floor Name" onkeypress="return addressValidation(event)" id="floor"></div>
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



<?php $this->load->view("admin/scripts/hostel_floor_script");?>
