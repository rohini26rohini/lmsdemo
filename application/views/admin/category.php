<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('category');?></h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_category" onclick="formclear('add_category_form')">
        <?php echo $this->lang->line('add_category');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('catagory');?></th>
                        <th ><?php echo $this->lang->line('school');?></th> 
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($categoryArr as $data){ 
                ?>
                    <tr id="row_<?php echo $data->id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="category_<?php echo $data->id;?>">
                            <?php echo $data->category; ?>
                        </td>
                        <td id="school_<?php echo $data->id;?>">
                            <?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)); ?>
                        </td>
                        <td id="status_<?php echo $data->id;?>">
                            <?php if($data->status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_catogory_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Inactive</span>
                            <?php }else if($data->status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_catogory_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Active</span>
                            <?php }?>
                        </td>
                        <td id="action_<?php echo $data->id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_category_Data('<?php echo $data->id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <?php if($data->status == '0'){?>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_catogory_Data('<?php echo $data->id;?>')">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <?php }?>
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_category');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <input type="text" name="category" id="category" class="form-control" placeholder="<?php echo $this->lang->line('category');?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="school" id="school">
                                <option value="">Select</option>
                                    <?php 
                                    if(!empty($school)) {
                                        foreach($school as $schools){
                                        echo '<option value="'.$schools->school_id.'">'.$schools->school_name.'</option>';
                                        }
                                    }
                                    ?>
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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_category');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <input type="text" name="category" id="category_edit" class="form-control" placeholder="<?php echo $this->lang->line('category');?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="school" id="school_edit">
                                <option value="">Select</option>
                                    <?php 
                                    if(!empty($school)) {
                                        foreach($school as $schools){
                                        echo '<option value="'.$schools->school_id.'">'.$schools->school_name.'</option>';
                                        }
                                    }
                                    ?>
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
<?php $this->load->view("admin/scripts/catogory_script");?>