<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('gallery');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_gallery" onclick="formclear('gallary_form')">
        <?php echo $this->lang->line('add_gallery');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('gallery_name');?></th>
                        <th ><?php echo $this->lang->line('school');?></th>
                        <th ><?php echo $this->lang->line('gallery_image');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($gallery_data as $data){ 
                ?>
                    <tr id="row_<?php echo $data->gallery_id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="name_<?php echo $data->gallery_id;?>">
                            <?php echo $data->gallery_name;?>
                        </td>
                        <td id="school_<?php echo $data->gallery_id;?>">
                            <?php echo 
                                $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)); ?>
                        </td>
                        <td id="image_<?php echo $data->gallery_id;?>">
                            <img src="<?php echo base_url() ?>/uploads/gallery/<?php echo $data->gallery_image;?>" style="height:50px; width:auto;"/>         
                        </td>
                        <td id="action_<?php echo $data->gallery_id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_galleryData('<?php echo $data->gallery_id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_gallerydata('<?php echo $data->gallery_id;?>','<?php echo $data->gallery_image;?>')">
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
<div id="add_gallery" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_gallery');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="gallary_form" method="post" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                                <label><?php echo $this->lang->line('gallery_name');?> <span class="req redbold">*</span></label>
                                <!-- <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo $this->lang->line('gallery_name');?>" /> -->
                                <input list="title" name="name" class="form-control" autocomplete="off" placeholder="<?php echo $this->lang->line('gallery_name');?>">
                                <datalist id="title">
                                <?php
                                   foreach($imageD as $data){ ?>
                                    <option value="<?php echo $data->gallery_name;?>"><?php echo $data->gallery_name;?></option>
                                    <?php }?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold"></span></label>
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
                                <label><?php echo $this->lang->line('gallery_image');?> </label><span class="req redbold"> * </span><small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small>
                                <input class="form-control" id="image" name="image[]" type="file" multiple>
                                <label>(<?php echo $this->lang->line('multiple_images_allowed');?>. 'ctrl + select' for upload multiple images)</label>
                                <div id="image_error" style="color:red;"> </div>
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
<div id="edit_gallery" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_gallery');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_gallery_form" method="post" enctype="multipart/form-data"> 
                <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('gallery_name');?> <span class="req redbold">*</span></label>
                                <input type="hidden" id="id" name="id" class="form-control" />
                                <!-- <input type="text" name="name" id="edit_name" class="form-control" placeholder="<?php echo $this->lang->line('gallery_name');?>" /> -->
                                <input list="title" name="name" id="edit_name" class="form-control" autocomplete="off" placeholder="<?php echo $this->lang->line('gallery_name');?>">
                                <datalist id="title">
                                <?php
                                   foreach($imageD as $data){ ?>
                                    <option value="<?php echo $data->gallery_name;?>"><?php echo $data->gallery_name;?></option>
                                    <?php }?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?> <span class="req redbold"></span></label>
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
                                <label><?php echo $this->lang->line('gallery_image');?> </label> <span class="req redbold"> * </span> <small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small>
                                <input class="form-control" id="image1" name="image" type="file">
                                <div id="image_view"> </div>
                                <div id="image_error1" style="color:red;"> </div>
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
<?php $this->load->view("admin/scripts/gallery_script");?>