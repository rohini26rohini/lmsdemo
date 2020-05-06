<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Success Stories</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_stories" onclick="formclear('success_stories_form')">
        <?php echo $this->lang->line('add_success_stories');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('name');?></th>
                        <th ><?php echo $this->lang->line('document_type');?></th>
                        <th ><?php echo $this->lang->line('school');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($stories as $story){ 
                ?>
                    <tr id="row_<?php echo $story->success_id;?>">
                        <td>
                            <?php echo $i;?>
                        </td >
                        <td id="name_<?php echo $story->success_id;?>">
                            <?php echo $story->name;?>
                        </td>
                        <td id="document_<?php echo $story->success_id;?>">
                            <?php   if($story->document_type == 1)
                                        echo 'Text';
                                    if($story->document_type == 2)
                                        echo 'Video';
                            ?>
                        </td>
                        <td id="school_<?php echo $story->success_id;?>">
                            <?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$story->school_id));?>
                        </td>
                        <td id="action_<?php echo $story->success_id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_successdata('<?php echo $story->success_id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_successdata('<?php echo $story->success_id;?>')">
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

<!--add discount modal-->
<div id="add_stories" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_success_stories');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="success_stories_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('name');?> <span class="req redbold">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="<?php echo $this->lang->line('name');?>" onkeypress="return valNames(event);"/>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('location');?> <span class="req redbold">*</span></label>
                                <input type="text" name="location" class="form-control" placeholder="<?php echo $this->lang->line('location');?>"/>
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
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="document_type" id="document_type">
                                    <option value="">Select</option>
                                    <option value="1">Text </option>
                                    <option value="2">Youtube link </option>
                                </select>
                            </div>
                            <div class="form-group" id="document_input">
                                
                            </div>
                            <div class="form-group" id="image_error" style="color:red;"> </div>
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
<div id="edit_stories" class="modal fade form_box modalCustom" role="dialog"> 
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_success_stories');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_success_stories_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('name');?> <span class="req redbold">*</span></label>
                                <input type="text" id="edit_name" name="name" onkeypress="return valNames(event);" class="form-control" placeholder="<?php echo $this->lang->line('success_stories_name');?>" />
                                <input type="hidden" id="id" name="id" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('location');?> <span class="req redbold">*</span></label>
                                <input type="text" name="location" id="edit_location" class="form-control" placeholder="<?php echo $this->lang->line('location');?>"/>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="school" id="edit_school">
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
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="document_type" id="edit_document_type">
                                <option value="">Select</option>
                                    <option value="1">Text </option>
                                    <option value="2">Youtube link </option>
                                </select>
                            </div>
                            <div class="form-group" id="document_input_edit">   
                            </div>
                            <div class="form-group" id="document_input_edit1">  
                            </div>
                            <div class="form-group" id="image_error1" style="color:red;"> </div>
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
<?php $this->load->view("admin/scripts/success_stories_script");?>
