<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Services</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_services" onclick="formclear('add_services_form')">
            Add Services
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <!-- <th ><?php echo $this->lang->line('school');?></th> -->
                        <th ><?php echo $this->lang->line('title');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($serviceArr as $service){ 
                ?>
                    <tr id="row_<?php echo $service['service_id'];?>">
                        <td >
                            <?php echo $i;?>
                        </td>
                        <!-- <td id="name_<?php echo $service['service_id'];?>">
                            <?php echo $service['school_name'];?>
                        </td> -->
                        <td id="title_<?php echo $service['service_id'];?>">
                            <?php echo $service['title'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_servicesdata(<?php echo $service['service_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_services(<?php echo $service['service_id'];?>)">
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

<!--add services modal-->
<div id="add_services" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Services</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_services_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id" id="school_id">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        $selected = '';
                                        if($schoolArr['school_id'] == $school['school_id']){
                                            $selected = 'selected="selected"';
                                        }
                                        echo '<option value="'.$school['school_id'].'" '.$selected.'>'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('title');?><span class="req redbold">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="<?php echo $this->lang->line('title');?>" autocomplete="off"/>
                            </div>
                        </div>
                        <!-- <div class='form-group col-sm-12'>
                            <div class="title-header">&nbsp;&nbsp;<?php echo $this->lang->line('content');?></div>
                            <textarea class="" name="service_content" id="service_content"></textarea>
                        </div> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold">*</span></label>
                                <input type="text" name="service_content" rows="10" class="form-control" placeholder="<?php echo $this->lang->line('content');?>" autocomplete="off"/>
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

<!--edit services modal-->
<div id="edit_services" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Services</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_services_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="service_id" id="edit_service_id" />
                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id" id="edit_school_id">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $dis){
                                        $selected = '';
                                        if($schoolArr['school_id'] == $dis['school_id']){
                                            $selected = 'selected="selected"';
                                        }
                                        echo '<option value="'.$dis['school_id'].'" '.$selected.'>'.$dis['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('title');?><span class="req redbold">*</span></label>
                                <input type="text" name="title" id="edit_title" class="form-control" placeholder="<?php echo $this->lang->line('title');?>" autocomplete="off"/>
                            </div>
                        </div>
                        <!-- <div class='form-group col-sm-12'>
                            <div class="title-header">&nbsp;&nbsp;<?php echo $this->lang->line('content');?></div>
                            <textarea class="" name="service_content" id="edit_service_content"></textarea>
                        </div> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold">*</span></label>
                                <input type="text" name="service_content" id="edit_service_content" rows="10" class="form-control" placeholder="<?php echo $this->lang->line('content');?>" autocomplete="off"/>
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

<?php //$this->load->view("admin/scripts/service_script");?>
