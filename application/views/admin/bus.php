<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('manage_bus');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_bus" onclick="formclear('add_bus_form')">
            Add Bus
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('vehicle_number');?></th>
                        <th ><?php echo $this->lang->line('model/brand');?></th>
                        <th ><?php echo $this->lang->line('seating_capacity');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php $i=1; 
                foreach($busArr as $bus){?>
                    <tr id="row_<?php echo $bus['bus_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="vehicle_number_<?php echo $bus['bus_id'];?>">
                            <?php echo $bus['vehicle_number'];?>
                        </td>
                        <td id="vehicle_made_<?php echo $bus['bus_id'];?>">
                            <?php echo $bus['vehicle_made'];?>
                        </td>
                        <td id="vehicle_seat_<?php echo $bus['bus_id'];?>">
                            <?php echo $bus['vehicle_seat'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_busdata(<?php echo $bus['bus_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_bus(<?php echo $bus['bus_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>


<!--edit bus modal-->
<div id="edit_bus" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Bus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_bus_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="bus_id" id="edit_bus_id" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Vehicle Number <span class="req redbold">*</span></label>
                                <input type="text" name="vehicle_number" id="edit_vehicle_number" class="form-control" placeholder="Vehicle Number" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Model/Brand<span class="req redbold">*</span></label>
                                <input type="text" name="vehicle_made" id="edit_vehicle_made" class="form-control" placeholder="Made" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Seating Capacity<span class="req redbold">*</span></label>
                                <input type="text" name="vehicle_seat" id="edit_vehicle_seat" class="form-control numbersOnly" placeholder="Seating Capacity" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="edit_description" placeholder="Description" autocomplete="off"></textarea>
                            </div>
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


<!--add bus modal-->
<div id="add_bus" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Bus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div> 
            <form id="add_bus_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Vehicle Number <span class="req redbold">*</span></label>
                                <input type="text" name="vehicle_number" class="form-control" placeholder="Vehicle Number" autocomplete="off" id="busno"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Model/Brand<span class="req redbold">*</span></label>
                                <input type="text" name="vehicle_made" class="form-control" placeholder="Model/Brand" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Seating Capacity<span class="req redbold">*</span></label>
                                <input type="text" name="vehicle_seat" class="form-control numbersOnly" placeholder="Seating Capacity" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" placeholder="Description" autocomplete="off"></textarea>
                            </div>
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

<?php $this->load->view("admin/scripts/transport_script");?>
