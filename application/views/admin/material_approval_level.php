<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $breadcrumb[1]['name']; ?></h6>
        <hr>
        <?php if(!empty($entitiyArr)){ 	
        foreach($entitiyArr as $entitiy){
        for($i = 1; $i<=$entitiy->flow_levels; $i++){?>
        <div class="row d-flex justify-content-around">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="dash_box custom_box">
                    <h6 class="text-center">Level <?php echo $i;?></h6>
                    <?php if($i != $entitiy->flow_levels) {?>
                    <i class="fa fa-arrow-down"></i>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2" style="display: flex;justify-content: center;align-items: center;">
                <div class="form-group">
                    <button class="btn btn-default " onclick="add_user_to_level(<?php echo $entitiy->id; ?>,<?php echo $i;?>)"><i class="fa fa-plus "></i></button>
                    <button class="btn btn-default " title="Edit" onclick="edit_user_to_level(<?php echo $entitiy->id; ?>,<?php echo $i;?>)"><i class="fa fa-pencil "></i></button>
                    <button class="btn btn-default " title="View" onclick="view_user_to_level(<?php echo $entitiy->id; ?>,<?php echo $i;?>)"><i class="fa fa-eye "></i></button>
                </div>
            </div>
        </div>
        
        <?php } } } ?>
    </div>
</div>
<!--modal-->

<div id="add_user_to_level" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_user');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_user_to_level_form" type="post">
            <div class="modal-body">
               <div class="row">
                   <input type="hidden" name="entity_id" id="entity_id"/>
                   <input type="hidden" name="level" id="level"/>
                   <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                       <div class="form-group"><label><?php echo $this->lang->line('role');?><span class="req redbold">*</span></label>
                            <select class="form-control"  name="role" id="role">
                                <option value="">Select</option>
                                <?php //show($roleArr);
                                 foreach($roleArr as $data){?>
                                    <option value="<?php echo $data->role; ?>"><?php echo $data->role_name; ?></option>
                                <?php } ?>
                            </select>
                       </div>
                   </div>
                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                       <div class="form-group"><label><?php echo $this->lang->line('user');?><span class="req redbold">*</span></label>
                            <select class="form-control"  name="user" id="user">
                                <option value="">Select</option>
                            </select>
                       </div>
                   </div>
               </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>
                <button class="btn btn-default cancel" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="view_user_to_level" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('view_user');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="approval_user">
               
            </div>
        </div>
    </div>
</div>
<div id="edit_user_to_level" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_user');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="approval_user_edit">
               
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/material_approval_script");?>
