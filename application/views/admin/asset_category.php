<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('asset_category'); ?> </h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_category" onclick="formclear('add_category_form')">
            <?php echo $this->lang->line('add_asset_category'); ?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('category');?></th>
                       <!-- <th ><?php echo $this->lang->line('status');?></th>-->
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($dataArr as $row){ 
                ?>
                    <tr >
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td >
                            <?php echo $row['name'];?>
                        </td>
                        <!-- <td id="status_<?php echo $leavetype['id'];?>">
                            <?php if($leavetype['status']=="1"){ echo '<a href="#"><span onclick="edit_status('.$leavetype['id'].','.$leavetype['status'].');" name="reject_status" id="reject_status_'.$leavetype['id'].'" class="approved">Active</span></a>';} else{ echo '<a href="#"><span class="denied" onclick="edit_status('.$leavetype['id'].','.$leavetype['status'].');">Inactive</span></a>';} ?>
                        </td> 
                        <td><?php if ($leavetype['status'] == "0") {  $status=1;?>
                   <span class="btn mybutton mybuttonInactive" onclick="edit_status(<?php echo $leavetype['id'];?>,<?php echo $status;?>);">Inactive</span>
                 <?php   }
                    else
                    { $status=0;?>
                       <span class="btn mybutton mybuttonActive" onclick="edit_status(<?php echo $leavetype['id'];?>,<?php echo $status;?>);">Active</span>
                  <?php  }?>
                    </td>-->
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_category_data(<?php echo $row['id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_category(<?php echo $row['id'];?>)">
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

<!--add leavetype modal-->
<div id="add_category" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_asset_category'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="status" value="1" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('category');?> <span class="req redbold">*</span></label>
                                <input type="text" name="category" class="form-control" placeholder="<?php echo $this->lang->line('category');?>" data-validate="required"  autocomplete="off" id="category"/>
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

<!--edit leavetype modal-->
<div id="edit_category" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_asset_category'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form  id="edit_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="edit_id" />
                       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('category');?><span class="req redbold">*</span></label>
                                <input type="text" name="name" class="form-control" id="edit_category_name" data-validate="required" placeholder="<?php echo $this->lang->line('category');?>"  autocomplete="off"/>
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
<?php $this->load->view("admin/scripts/asset_category_script");?>
