<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('received_applications');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <div class="addBtnPosition">
        <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>backoffice/careers">
        <?php echo $this->lang->line('career');?>
        </a>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('name');?></th>
                        <th ><?php echo $this->lang->line('career');?></th> 
                        <th ><?php echo $this->lang->line('email');?></th>
                        <th ><?php echo $this->lang->line('phone');?></th>
                        <th ><?php echo $this->lang->line('resume');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($application as $data){ 
                ?>
                    <tr id="row_<?php echo $data->id; ?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="name_<?php echo $data->id; ?>"> 
                            <?php echo $data->name;?>
                        </td>
                        <td id="career_<?php echo $data->id; ?>">
                        <?php echo 
                            $this->common->get_name_by_id('web_careers','careers_name',array('careers_id'=>$data->career_id)); ?>
                        </td>
                        <td id="email_<?php echo $data->id; ?>">
                            <?php echo $data->email;?>
                        </td>
                        <td id="phone_<?php echo $data->id; ?>">
                            <?php echo $data->phone;?>
                        </td>
                        <td id="resume_<?php echo $data->id; ?>">
                            <a class="btn mybutton  mybuttoninfo" href="<?php echo base_url(); ?>uploads/career_application_doc/<?php echo $data->resume?>" target="_blank">Resume</a>
                        </td>
                        <td id="status_<?php echo $data->id;?>">
                            <?php if($data->status == '0'){?>
                                <span class="btn   pending" onclick="edit_application_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Pending</span>
                            <?php }else if($data->status == '1'){?>
                                <span class="btn   shortListed" onclick="edit_application_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Shortlisted</span>
                            <?php }else if($data->status == '2'){?>
                                <span class="btn   replied" onclick="edit_application_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Replied</span>
                            <?php }else if($data->status == '3'){?>
                                <span class="btn   interviwed" onclick="edit_application_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Interviewed</span>
                            <?php }else if($data->status == '4'){?>
                                <span class="btn   approved"> Selected</span>
                            <?php }else if($data->status == '5'){?>
                                <span class="btn   denied" onclick="edit_application_status('<?php echo $data->id; ?>','<?php echo $data->status; ?>')">Rejected</span>
                            <?php }?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="View" onclick="view_application_comments('<?php echo $data->id;?>')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div> 

<!--add discount modal-->
<div id="view_application_comments" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('status');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="career_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="table-responsive"  id="application_status_table">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="status_change" class="modal fade modalCustom" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('change_status');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="application_status_change" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="id"/>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                        <div class="form-group"> 
                            <label><?php echo $this->lang->line('status');?> <span class="req redbold">*</span></label>
                            <select class="form-control"  name="status" id="status">
                                <option value="">Select</option> 
                                <option value="0">Pending</option>
                                <option value="1">Shortlisted</option>
                                <option value="2">Replied</option>
                                <option value="3">interviewed</option>
                                <option value="4">Selected</option> 
                                <option value="5">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                        <div class="form-group"> 
                            <label><?php echo $this->lang->line('comments');?> <span class="req redbold"></span></label>
                            <textarea name="comments" id="comments" class="form-control" rows="4" cols="50" style="height:unset!important"></textarea>
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
<?php $this->load->view("admin/scripts/received_application_script");?>