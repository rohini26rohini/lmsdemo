<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('basic_entity');?></h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_category" onclick="formclear('add_category_form')">
        <?php echo $this->lang->line('add_basic_entity');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('title');?></th>
                        <th ><?php echo $this->lang->line('type');?></th> 
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($entities as $entity){ 
                ?>
                    <tr id="row_<?php echo $entity->entity_id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="category_<?php echo $entity->entity_id;?>">
                            <?php echo $entity->entity_name; ?>
                        </td>
                        <td id="school_<?php echo $entity->entity_id;?>">
                            <?php echo $entity->entity_type ?>
                        </td>
                        <td id="status_<?php echo $entity->entity_id;?>">
                        <?php if($entity->entity_type=='Qualification') { ?>
                            <?php if($entity->entity_status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_entity_status('<?php echo $entity->entity_id; ?>','<?php echo $entity->entity_status; ?>')">Inactive</span>
                            <?php }else if($entity->entity_status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_entity_status('<?php echo $entity->entity_id; ?>','<?php echo $entity->entity_status; ?>')">Active</span>
                            <?php }?>
                        <?php }else if($entity->entity_type == 'Department'){ ?>
                            <?php if($entity->entity_status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_entityStaff_status('<?php echo $entity->entity_name; ?>','<?php echo $entity->entity_status; ?>','department')">Inactive</span>
                            <?php }else if($entity->entity_status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_entityStaff_status('<?php echo $entity->entity_name; ?>','<?php echo $entity->entity_status; ?>','department')">Active</span>
                            <?php }?>
                        <?php }else if($entity->entity_type == 'Designation'){ ?>
                            <?php if($entity->entity_status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_entityStaff_status('<?php echo $entity->entity_name; ?>','<?php echo $entity->entity_status; ?>','designation')">Inactive</span>
                            <?php }else if($entity->entity_status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_entityStaff_status('<?php echo $entity->entity_name; ?>','<?php echo $entity->entity_status; ?>','designation')">Active</span>
                            <?php }?>
                        <?php } else if($entity->entity_type == 'Online Transaction'){ ?>
                            <?php if($entity->entity_status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_entityStaff_status('<?php echo $entity->entity_name; ?>','<?php echo $entity->entity_status; ?>','Online Transaction')">Inactive</span>
                            <?php }else if($entity->entity_status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_entityStaff_status('<?php echo $entity->entity_name; ?>','<?php echo $entity->entity_status; ?>','Online Transaction')">Active</span>
                            <?php }?>
                        <?php } ?>
                        </td>
                        <td id="action_<?php echo $entity->entity_id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_category_Data('<?php echo $entity->entity_id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>   
    </div>
</div> 
<div id="add_category" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_basic_entity');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('entity_name');?> <span class="req redbold">*</span></label>
                                <input type="text" name="entity" id="entity" class="form-control" placeholder="<?php echo $this->lang->line('entity_name');?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="mode" id="mode">
                                    <!-- <option value="Course Mode" selected="selected">Course Mode</option> -->
                                    <option value="Qualification" selected="selected">Qualification</option> 
                                    <option value="Designation" selected="selected">Designation</option> 
                                    <option value="Department" selected="selected">Department</option> 
                                    <option value="Online Transaction" selected="selected">Online Transaction</option> 
                                </select> 
                            </div>
                            <div class="form-group" id="leveldiv">
                                <label><?php echo $this->lang->line('level');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="level" id="level">
                                    <!-- <option value="Course Mode" selected="selected">Course Mode</option> -->
                                    <option value="Classx" selected="selected">Class X or Below</option> 
                                    <option value="Classxii" selected="selected">Class XII or Equivalent</option> 
                                    <option value="Degree" selected="selected">Degree/Diploma</option> 
                                    <option value="PG" selected="selected">P.G. & Above</option> 
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit_category" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_entity');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="entity_id" id="entity_id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('entity_name');?> <span class="req redbold">*</span></label>
                                <input type="text" name="entity" id="entity_edit" class="form-control" placeholder="<?php echo $this->lang->line('entity_name');?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="mode" id="mode_edit" readonly>
                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="level" id="level_edit" readonly>
                                   
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/basic_entity_script");?>