<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <div class="row filter" id="example">
            
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label> Role</label>
                    <select class="form-control filter_change" name="filter_role" id="filter_role">
                        <option value="">Select Role</option>
                        <?php foreach($roleArr as $role){ ?>
                        <option value="<?php echo $role['role']; ?>">
                        <?php echo $role['role_name']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div> 
           
                
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label style="display:block;">&nbsp;</label>
                    <a href="<?php echo base_url();?>backoffice/staff-notification"><button type="button" class="btn btn-default add_row add_new_btn btn_add_call" id="reset_form">
                        Reset
                    </button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="white_card ">
        <h6>Manage Staff Notification</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <form id="staff_notf">
        <div class="row">
             <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div id="result">
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50">Sl. No.</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th><label class="custom_checkbox"><?php echo $this->lang->line('action');?>
                    <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                    <span class="checkmark"></span>
                    </label></th>
                        </tr>
                    </thead>
                    <?php 
                    $i=1;
                    foreach($staffArr as $staff){
                        
                       $status=$this->common->get_name_by_id('am_users_backoffice','user_status',array("user_id"=>$staff['user_id']));
                    ?>
                    <tr>
                        <td >
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $staff['name'];?>
                        </td>
                        <td>
                            <?php echo $staff['role_name'];?>
                        </td>
                        <td>
                            <label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                            <input type="checkbox" checked="checked" class="all_staff" name="staff_id[]" value="<?php echo $staff['user_id']; ?>" />
                            <span class="checkmark"></span>
                            </label>
                            
                        </td> 
                       
                    </tr>
                    <?php $i++;} ?>
                </table>
            </div>
            </div>
            </div>
             <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
               <div class="col--sm-6 col-12">
                <div class="form-group">
                    <label>message</label>
                    <textarea class="form-control" name="message"></textarea>
                   </div>
               </div>
            <div class="form-group col-12">
                      <button class="btn btn-info btn_save">Save</button>
                     </div>
           </div> 
        </div>
            </form>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<?php// $this->load->view("admin/scripts/staff_script");?>
<?php $this->load->view("admin/scripts/staff_notification_script");?>
