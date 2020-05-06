<!-- <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>How To Prepare</h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_prepare" onclick="formclear('add_prepare_form')">
            Add How To Prepare
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('school');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($prepareArr as $prepare){ 
                ?>
                    <tr id="row_<?php echo $prepare['prepare_id'];?>">
                        <td >
                            <?php echo $i;?>
                        </td>
                        <td id="school_name_<?php echo $prepare['prepare_id'];?>">
                            <?php echo $prepare['school_name'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " onclick="get_how_to_preparedata(<?php echo $prepare['prepare_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
    </div>
</div>

<div id="add_prepare" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add How To Prepare</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_prepare_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                            <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="mentorImg"></div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold">*</span></label>
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

<div id="edit_prepare" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit How To Prepare</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_prepare_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="prepare_id" id="edit_prepare_id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                            <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="image_view"></div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_mentorImg"></div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold">*</span></label>
                                <textarea type="text" name="content" id="edit_content"></textarea>
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
</div> -->

<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>How To Prepare</h6>
        <hr>
        <div class="row">
        <form id="prepare_form" class="splform" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                <div class="form-group">
                    <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                    <select class="form-control" name="school_id" id="school_id" onchange="change_special(this.value)">
                        <?php 
                        if(!empty($schoolArr)) {
                            foreach($schoolArr as $school){
                                echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                }
                            
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="keywords">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold">*</span></label>
                                <!-- <textarea type="text" name="content" id="content"></textarea> -->
                                <input type="text" name="content" id="content" value="">

                                <!-- <input type="hidden" name="id<?php echo $j ?>" id="id<?php echo $j ?>" value="<?php echo $Sschools->about_id ?>"/> -->

                            </div>
                        </div>
                        </div>
            <!-- <div id="keywords">
                <?php  
                $j =0;
                    if(!empty($single_school)) {
                        foreach($single_school as $Sschools){ $j++;?>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                                <div class="form-group Commentsboxs"> 
                                    <div class="row">
                                        <div class="col-md-1 text-center justify-content-sm-center d-sm-flex">
                                            <span class="Commentno"><?php echo $j ?></span>
                                        </div>
                                        <div class="col-md-11">
                                            <textarea type="text" name="content<?php echo $j ?>" id="content<?php echo $j ?>"><?php echo $Sschools->keywords ?></textarea>

                                            <input type="hidden" name="id<?php echo $j ?>" id="id<?php echo $j ?>" value="<?php echo $Sschools->about_id ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
            </div> -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                <button class="btn btn-success sasupdate" type="submit">Update</button>
            </div>
        </form>
        </div>   
    </div>
</div> 

<?php $this->load->view("admin/scripts/how_to_prepare_script");?>
