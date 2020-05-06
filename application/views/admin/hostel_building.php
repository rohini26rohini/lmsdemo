<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Manage Hostel Building</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_building_form')">
            Add Hostel Buildings
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="hostel_building_table" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('group');?></th>
                <th><?php echo $this->lang->line('branch');?></th> 
                <th><?php echo $this->lang->line('centre');?></th>
                <th><?php echo $this->lang->line('building_name');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                </tr>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->
<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_building');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
             <form id="add_building_form" type="post">
            <div class="modal-body">
               
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('group');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="group_id" id="group_name">
                                        <option value=""><?php echo $this->lang->line('select_group');?></option>
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
                                    <select class="form-control" name="branch_id" id="branch_name">
                                        <option value=""><?php echo $this->lang->line('select_branch');?></option>
                                    </select>
                                </div>
                        </div> 
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                           <div class="form-group"><label><?php echo $this->lang->line('centre');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="centre_id" id="center_name">
                                        <option value=""><?php echo $this->lang->line('select_centre');?></option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('building_name');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="building_name" placeholder="Building Name" onkeypress="return addressValidation(event)"></div>
                        </div>
                       
                      
                       

                    </div>
              
            </div>
             <div class="modal-footer">
    <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
       <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
        </div> </form>

        </div>

    </div>
</div>
<!--edit modal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_building_details');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
               <form id="edit_building_form" type="post">
            <div class="modal-body">
             
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input name="building_id" type="hidden" id="building_id"/>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('group');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="group_id" id="group_id">
                                        <option value=""><?php echo $this->lang->line('select_group');?></option>
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
                                    <select class="form-control" name="branch_id" id="branch_id">
                                        <option value=""><?php echo $this->lang->line('select_branch');?></option>
                                    </select>
                                </div>
                        </div> 
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                           <div class="form-group"><label><?php echo $this->lang->line('centre');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="centre_id" id="centre_id">
                                        <option value=""><?php echo $this->lang->line('select_centre');?></option>
                                    </select>
                                </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('building_name');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="building_name" id="building_name" placeholder="Building Name" onkeypress="return addressValidation(event)"></div>
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

<?php $this->load->view("admin/scripts/hostel_building_script");?>
