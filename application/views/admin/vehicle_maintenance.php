<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('maintenance');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_maintenance" onclick="formclear('add_maintenance_form')">
            Add Maintenance
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('vehicle_number');?></th>
                        <th ><?php echo $this->lang->line('description');?></th>
                        <th ><?php echo $this->lang->line('date');?></th>
                        <th ><?php echo $this->lang->line('amount');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php $i=1; 
                foreach($maintenanceArr as $maintenance){?>
                    <tr id="row_<?php echo $maintenance['maintenance_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </div>
                        <td id="vehicle_number_<?php echo $maintenance['maintenance_id'];?>">
                            <?php echo $maintenance['vehicle_number'];?>
                        </td>
                        <td id="description_<?php echo $maintenance['maintenance_id'];?>">
                            <?php echo $maintenance['description'];?>
                        </td>
                        <td id="date_<?php echo $maintenance['maintenance_id'];?>">
                            <?php echo $maintenance['date'];?>
                        </td>
                        <td id="amount_<?php echo $maintenance['maintenance_id'];?>">
                            <?php echo $maintenance['amount'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_maintenancedata(<?php echo $maintenance['maintenance_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_maintenance(<?php echo $maintenance['maintenance_id'];?>)">
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


<!--edit maintenance modal-->
<div id="edit_maintenance" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Maintenance</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_maintenance_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="maintenance_id" id="edit_maintenance_id" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('vehicle_number');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="bus_id" id="edit_bus_id">
                                    <option value="">Select Vehicle Number</option>
                                    <?php foreach($busArr as $bus){
                                          echo '<option value="'.$bus['bus_id'].'" >'.$bus['vehicle_number'].'</option>';
                                        }
                                    ?>
                                </select>                            
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" name="description" id="edit_description" placeholder="<?php echo $this->lang->line('description');?>" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group" ><label><?php echo $this->lang->line('date');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control hidefuturedate " name="date" id="edit_date" placeholder="<?php echo $this->lang->line('date');?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('amount');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control numbersOnly" name="amount" id="edit_amount"   placeholder="<?php echo $this->lang->line('amount');?>" autocomplete="off"/>
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


<!--add maintenance modal-->
<div id="add_maintenance" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Maintenance</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div> 
            <form id="add_maintenance_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('vehicle_number');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="bus_id" id="bus_id" data-validate="required">
                                    <option value="">Select Vehicle Number</option>
                                    <?php 
                                    foreach($busArr as $bus){
                                            echo '<option value="'.$bus['bus_id'].'">'.$bus['vehicle_number'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" name="description" placeholder="<?php echo $this->lang->line('description');?>" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group" ><label><?php echo $this->lang->line('date');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control hidefuturedate" name="date" placeholder="<?php echo $this->lang->line('date');?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('amount');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control numbersOnly" name="amount" id="amount"  placeholder="<?php echo $this->lang->line('amount');?>" autocomplete="off"/>
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
