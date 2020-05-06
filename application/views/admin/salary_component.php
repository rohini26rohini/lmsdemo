<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('salary_component');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_salary_component" onclick="formclear('add_salary_component_form')">
            Add <?php echo $this->lang->line('salary_component');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('salary_component');?></th>
                        <th ><?php echo $this->lang->line('type');?></th>
                        <th ><?php echo $this->lang->line('status');?></th> 
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($salarycomponentArr as $salarycomponent){ 
                ?>
                    <tr id="row_<?php echo $salarycomponent['id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="salary_head_<?php echo $salarycomponent['id'];?>">
                            <?php echo $salarycomponent['head'];?>
                        </td>
                        <td id="type_<?php echo $salarycomponent['id'];?>">
                            <?php echo $salarycomponent['type'];?>
                        </td>
                        <td>
                        <?php 
                            if ($salarycomponent['status'] == "4") {  
                            ?>
                            <span title="Con't change..!">Non editable</span>

                            <?php }
                            else if ($salarycomponent['status'] == "0") {  
                                $status=1;
                            ?>
                            <span class="btn mybutton mybuttonInactive" onclick="edit_status(<?php echo $salarycomponent['id'];?>,<?php echo $status;?>);">Inactive</span>
                            <?php 
                            }else{ $status=0;
                            ?>
                            <span class="btn mybutton mybuttonActive" onclick="edit_status(<?php echo $salarycomponent['id'];?>,<?php echo $status;?>);">Active</span>
                            <?php }?>
                        </td>
                        <td>
                        <?php if ($salarycomponent['status'] != "4") {  
                            ?>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_salarycomponent_data(<?php echo $salarycomponent['id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_salarycompnent(<?php echo $salarycomponent['id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        <?php }else{?>
                            <span title="Con't change..!">Non editable</span>
                        <?php } 
                            ?>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--add salarycomponent modal-->
<div id="add_salary_component" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Salary Component</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_salary_component_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="status" value="1" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('salary_component');?> <span class="req redbold">*</span></label>
                                <input type="text" name="head" class="form-control" placeholder="<?php echo $this->lang->line('salary_component');?>" data-validate="required" onkeypress="return valNames(event);" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="type">
                                    <option value="">Select Type</option>
                                    <option value="ADD">ADD</option>
                                    <option value="DEDUCT">DEDUCT</option>
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

<!--edit salarycomponent modal-->
<div id="edit_salary_component" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Salary Component</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_salary_component_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="edit_component_id" />
                        <input type="hidden" name="status" id="status"/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('salary_component');?><span class="req redbold">*</span></label>
                                <input type="text" name="head" class="form-control" id="edit_salary_head" data-validate="required" placeholder="<?php echo $this->lang->line('salary_component');?>" onkeypress="return valNames(event);" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="edit_type">
                                    <option value="">Select Type</option>
                                    <option value="ADD">ADD</option>
                                    <option value="DEDUCT">DEDUCT</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/salary_component_script");?>
