<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('how_to_prepare');?></h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_howtoprepare" onclick="formclear('add_howtoprepare_form')">
        <?php echo $this->lang->line('add_how_to_prepare');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('category');?></th>
                        <th ><?php echo $this->lang->line('school');?></th> 
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                // show($prepareArr);
                foreach($prepareArr as $data){ 
                ?>
                    <tr id="prepare<?php echo $data->prepare_id?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="category<?php echo $data->prepare_id?>">
                            <?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$data->category_id)); ?>
                        </td>
                        <td id="school<?php echo $data->prepare_id?>">
                            <?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)); ?>
                        </td>
                        <td id="status<?php echo $data->prepare_id?>">
                            <?php if($data->prepare_status == '0'){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_howtoprepare_status('<?php echo $data->prepare_id; ?>','<?php echo $data->prepare_status; ?>')">Inactive</span>
                            <?php }else if($data->prepare_status == '1'){?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_howtoprepare_status('<?php echo $data->prepare_id; ?>','<?php echo $data->prepare_status; ?>')">Active</span>
                            <?php }?>
                        </td>
                        <td id="action<?php echo $data->prepare_id?>">
                            <button type="button" class="btn btn-default option_btn " onclick="get_howtoprepare_Data_view('<?php echo $data->prepare_id;?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_classrooms" style="color:blue;cursor:pointer;">
                                    <i class="fa fa-eye "></i>
                                </button>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_howtoprepare_Data('<?php echo $data->prepare_id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <?php if($data->prepare_status == '0'){?>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_howtoprepare_Data('<?php echo $data->prepare_id;?>')">
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
<div id="add_howtoprepare" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_how_to_prepare');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_howtoprepare_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                <label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="category" id="category">
                                    <option value="">Select</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold"></span></label>
                                <textarea type="text" name="content" id="content"></textarea>
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
<div id="edit_howtoprepare" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_how_to_prepare');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_howtoprepare_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="category" id="category_edit">
                                    <option value="">Select</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold"></span></label>
                                <textarea type="text" name="content" id="content_edit"></textarea>
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
<div id="view_howtoprepare" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('how_to_prepare');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_howtoprepare_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-4">
                                <b>Category </b><br>
                            </div>
                            <div class="col-sm-8" id="singlecategory">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-4">
                                <b>School Name </b><br>
                            </div>
                            <div class="col-sm-8" id="single_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <b>Content </b><br>
                            </div>
                            <div class="col-sm-8" id="single_content">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/how_to_prepare_script");?>