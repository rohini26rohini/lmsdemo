<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Services</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <!-- <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_services" onclick="formclear('add_services_form')">
            Add Services
        </button> -->
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
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
                        <td id="title_<?php echo $service['service_id'];?>">
                            <?php echo $service['title'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_servicesdata(<?php echo $service['service_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <!-- <a class="btn btn-default option_btn" onclick="delete_services(<?php echo $service['service_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a> -->
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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="title" id="title">
                                <option value="">Select</option>
                                    <option value="Services">Services</option>
                                    <option value="Honorary Director">Honorary Director</option>
                                    <option value="About-DIFP">About DIFP</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="mentorImg">
                            
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold">*</span></label>
                                <textarea type="text" name="service_content" id="service_content"></textarea>
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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('type');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control" name="title" id="edit_title" readonly>
                                
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="image_view">
                            
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_mentorImg">
                            
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('content');?><span class="req redbold"></span></label>
                                <textarea type="text" name="service_content" id="edit_service_content"></textarea>
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

<?php $this->load->view("admin/scripts/service_script");?>
