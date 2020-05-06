<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('banner');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_banner" onclick="formclear('banner_form');">
        <?php echo $this->lang->line('add_banner');?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('type');?></th>
                        <th ><?php echo $this->lang->line('banner');?></th>
                        <th ><?php echo $this->lang->line('school');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($banner as $data){  
                ?>
                    <tr id="row_<?php echo $data->id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="type_<?php echo $data->id;?>">
                            <?php echo $data->type;?>
                        </td>
                        <td id="image_<?php echo $data->id;?>">
                            <img src="<?php echo base_url() ?>/uploads/banner_images/<?php echo $data->banner_image;?>" style="height:50px; width:auto;"/>         
                        </td>
                        <td id="school_<?php echo $data->id;?>">
                            <?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id));?>
                        </td>
                        <td id="action_<?php echo $data->id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_bannerData('<?php echo $data->id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_bannerdata('<?php echo $data->id;?>')">
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
<div id="add_banner" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_banner');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="banner_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="type">
                                    <option value="">Select</option>
                                    <option value="Home_top_banner">Home top banner</option>
                                    <option value="Inner_slider">Inner slider</option>
                                    <option value="School_banner">School banner</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="school_select">
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('banner_image');?> </label> <span class="req redbold"> * </span><small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small>
                                <input class="form-control" id="banner" name="banner" type="file">
                                <br><b class="req redbold">*  </b><b>Note: Height x Width :- Home top banner / School banner - 1848px x 686px<br></b>
                                <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Inner slider: 907px x 469px</b>
                                <div id="banner_error" style="color:red;"> </div>

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
<div id="edit_banner" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_banner');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_banner_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="id" />
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?> <span class="req redbold">*</span></label>
                                <input class="form-control" name="type" id="edit_type" readonly>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="school_select_edit">
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('banner_image');?> </label><small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small>
                                <input class="form-control" id="edit_banner_image" name="banner" type="file">
                                <div id="banner_image"> </div>
                                <div id="edit_banner_error1" style="color:red;"> </div>
                                <br><b class="req redbold">*  </b><b>Note: Height x Width :- Home top banner / School banner - 1848px x 686px<br></b>
                                <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Inner slider: 907px x 469px</b>
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
<?php $this->load->view("admin/scripts/banner_script");?>