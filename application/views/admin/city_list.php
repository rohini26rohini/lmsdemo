<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('city');?></h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_category" onclick="formclear('add_category_form')">
        <?php echo $this->lang->line('add_city');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('city');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($entities as $entity){ 
                ?>
                    <tr id="row_<?php echo $entity->id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="category_<?php echo $entity->id;?>">
                            <?php echo $entity->name; ?>
                        </td>
                        <td id="action_<?php echo $entity->id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_city_Data('<?php echo $entity->id;?>')">
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_city');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_city_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('state');?> <span class="req redbold">*</span></label>
                                   <select class="form-control" name="state" id="state">
                                   <option value="" >Select state</option>
                                   <?php
                                   $selected = '';
                                   if(!empty($states)) {
                                        foreach($states as $state) {
                                            $selected = '';
                                            if($state->id==19) { $selected='selected="selected"';}
                                            echo '<option value="'.$state->id.'" '.$selected.'>'.$state->name.'</option>';
                                        }
                                   }
                                   ?>
                                   </select>
                                </div>
                            </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('city');?><span class="req redbold">*</span></label>
                                <input type="text" name="entity" id="entity" class="form-control" placeholder="<?php echo $this->lang->line('add_city');?>" />
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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_city');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_city_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="mode_id" />
                    <input type="hidden" name="state" id="edit_state" />
                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('state');?> <span class="req redbold">*</span></label>
                                   <select class="form-control" name="state" id="edit_state" readonly="readonly">
                                   <option value="" >Select state</option>
                                   <?php
                                   $selected = '';
                                   if(!empty($states)) {
                                        foreach($states as $state) {
                                            $selected = '';
                                            if($state->id==19) { $selected='selected="selected"';}
                                            echo '<option value="'.$state->id.'" '.$selected.'>'.$state->name.'</option>';
                                        }
                                   }
                                   ?>
                                   </select>
                                </div>
                            </div> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('city');?> <span class="req redbold">*</span></label>
                                <input type="text" name="entity" id="entity_edit" class="form-control" placeholder="<?php echo $this->lang->line('add_city');?>" />
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
<?php $this->load->view("admin/scripts/basic_mode_script");?>