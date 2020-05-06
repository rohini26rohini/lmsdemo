<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage Users</h6>
        <hr>
       <!-- <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_institute_form')">
                                    Add User
                                </button>-->   
        <!-- Data Table Plugin Section Starts Here -->
        
        <div class="table-responsive table_language" >
        <table id="institute_data" class="table table-striped table-sm" style="width:100%">
            <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('name');?></th>
                <th><?php echo $this->lang->line('role');?></th>
                <th><?php echo $this->lang->line('username');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>

            

            <?php
            if(!empty($users)) {
              
            $i=1; foreach($users as $user){?>
            <tr id="row_<?php echo $user['user_id'];?>">

                <td>
                    <?php echo $i;?>
                </td>
                <td>
                    <?php echo $user['user_name'];?>
                </td>
                <td>
                    <?php echo $user['user_role'];?>
                </td>
                <td>
                     <?php echo $user['user_username'];?>
                </td>

                <td>
                <!-- <span class="btn mybutton mybuttonActive"  data-toggle="modal" data-target="#resetpassword"  onclick="resetpassword_status(<?php echo $user['user_id'];?>);"><?php echo $this->lang->line('reset');?></span> -->
                <a class="btn mybutton mybuttonActive" onclick="resendpassword_status(<?php echo $user['user_id'];?>,'<?php echo $user['user_username'];?>');" style="color:#fff;">Resend Password</a>
                    <?php 
                           if($user['user_status'] == 1)
                            {
                    ?>
                   &nbsp;&nbsp;<span class="btn mybutton mybuttonActive" onclick="edit_status(<?php echo $user['user_id'];?>,<?php echo $user['user_status'];?>);">Ban User</span>
                   <?php  } else
                           {?>
                    &nbsp;&nbsp;<span class="btn mybutton btn mybutton mybuttonInactive" onclick="edit_status(<?php echo $user['user_id'];?>,<?php echo $user['user_status'];?>);">Activate User</span>
                    <?php } ?>
                </td>

            </tr>

            <?php $i++; }
            } ?>

            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<div id="resetpassword" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('reset');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_category_form" method="post">
                <div class="modal-body">
                    <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('new_password_is');?></label>
                                <h3 id="newpassword_show"></h3>
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
<?php $this->load->view("admin/scripts/user_script");?>
