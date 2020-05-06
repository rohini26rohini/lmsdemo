<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <div class="row filter" id="example">
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="filter_name" id="filter_name" class="form-control filter_class" placeholder="Search..." autocomplete="off"/>
                </div>
            </div>
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
            <div class="col-sm-2 col-12" style="display:none" id="show_subject">
                <div class="form-group">
                    <label> Subject</label>
                    <select class="form-control filter_change" name="filter_subject" id="filter_subject">
                        <option value="">Select Subject</option>
                        <?php  foreach($subjectArr as $sub){ ?>
                        <option value="<?php echo $sub['subject_id']; ?>">
                        <?php echo $sub['subject_name']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label style="display:block;">&nbsp;</label>
                    <button type="reset" class="btn btn-default add_row add_new_btn btn_add_call" id="reset_form" onclick="resetPage()">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="white_card ">
        <h6>Manage Staffs</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <a href ="<?php echo base_url('backoffice/manage-staff');?>" id="#add_staff_personal">
            <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition">
                Add Staff
            </button>
        </a>
        <div id="result">
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table id="staff_table" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50">Sl. No.</th>
                            <th>Name</th>
							<th>ID</th>
                            <th>Role</th>
                            <th>Mobile Number</th>
                            <th>Joining Date</th>
                            <th><?php echo $this->lang->line('status'); ?></th>
                            <th>Action</th>
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
                            <?php echo $staff['registration_number'];?>
                        </td>
                        <td>
                            <?php echo $staff['role_name'];?>
                        </td>
                        <td>
                            <?php echo $staff['mobile'];?>
                        </td> 
                        <td>
                            <?php echo $staff['joining_date'] != null ? date('d-m-Y',strtotime($staff['joining_date'])):'&nbsp;'; ?>
                            <?php //echo date('d-m-Y',strtotime($staff['joining_date']));?>
                        </td>
                       <td>
                          
                          <?php if($status == "1"){ ?> 
                           <span class="btn mybutton  mybuttonActive" onclick="edit_staff_status(<?php echo $staff['personal_id'];?>,<?php echo $status;?>);">
                               <?php echo $this->lang->line('Active');?></span>
                           <?php }
                        else if($status == "0"){?>
                           <span class="btn mybutton  mybuttonInactive" onclick="edit_staff_status(<?php echo $staff['personal_id'];?>,<?php echo $status;?>);"><?php echo $this->lang->line('Inactive');?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <a title="Edit" href="<?php echo base_url() . 'backoffice/manage-staff/'.$staff['personal_id']; ?>" name="personal_id" id="clicker" data-personal="<?php echo $staff['personal_id']; ?>">
                            <button class="btn btn-default option_btn add_new_btn">
                                <i class="fa fa-pencil "></i>
                            </button>
                            </a>
                            <!-- <button class="btn btn-default option_btn add_new_btn" onclick="get_editdata(<?php echo $staff['personal_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button> -->
                            <a class="btn btn-default option_btn  " title="Delete" onclick="delete_staff_personals(<?php echo $staff['personal_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $i++;} ?>
                </table>
            </div>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<?php $this->load->view("admin/scripts/staff_script");?>
