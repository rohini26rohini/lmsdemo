<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <div class="white_card ">
            <h6>Manage Students</h6>
            <hr>
            <a href="<?php echo base_url();?>backoffice/manage-student">
                <button type="button" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" >
                    Add Student
                </button>
            </a>
            <div class="row filter">
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('application.no');?></label>
                        <input type="text" id="filter_regnum" class="form-control" placeholder="Search..." />
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="filter_name" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Email</label>
                        <input type="text" id="filter_email" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Contact Number</label>
                        <input type="text" id="filter_number" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Location</label>
                        <input type="text" id="filter_location" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label style="display:block;">&nbsp;</label>
                        <a href="<?php echo base_url(); ?>backoffice/student-list"><button type="button" class="btn btn-default add_row add_new_btn btn_add_call">
                            Reset
                        </button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="white_card">
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table id="studentlist_table" class="table table-striped table-sm dirstudent-list" style="width:100%">
                    <thead>
                        <tr>
                            <th class="dirslslno" width="50"><?php echo $this->lang->line('sl_no');?></th>
                            <th><?php echo $this->lang->line('application.no');?></th>
                            <th><?php echo $this->lang->line('name');?></th>
                            <th class="diremailli"><?php echo $this->lang->line('emailid');?></th>
                            <th><?php echo $this->lang->line('contact.no');?></th>
                            <th><?php echo $this->lang->line('location');?></th>
                            <th><?php echo $this->lang->line('status');?></th>
                            <th><?php echo $this->lang->line('idcard_status');?></th>
                            <th class="dirbaksl"><?php echo $this->lang->line('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1; foreach($studentArr as $student){break; 
                    $ccstatus = '';
                    if($student['caller_id']>0) { 
                    $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$student['caller_id']));
                    if(!empty($callcentre['call_status'])){
                    $ccstatus = $callcentre['call_status'];
                    } }
                    ?>
                    <tr>
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $student['registration_number'];?>
                        </td>
                        <td>
                            <?php echo $student['name'];?>
                        </td>
                        <td>
                            <?php echo $student['email'];?>
                        </td>
                        <td>
                            <?php echo $student['contact_number'];?>
                        </td>
                        <td>
                            <?php echo $student['street'];?>
                        </td>
                        <td>
                                    
                                    
                            <?php 
                                if ($student['status']==1) { echo '<span class="admitted">Admitted</span>';}
                                else if($student['status']==2) { echo '<span class="paymentcompleted">Fee Paid</span>';}
                                else if($student['status']==4) { echo '<span class="batchchanged">Batch Changed</span>';}
                                else if($student['status']==5) { echo '<span class="inactivestatus">Inactive</span>';}
                                else if($student['status']==0 && $student['verified_status']==1) { echo '<span class="paymentpending">Payment Pending</span>';}
                                else  { echo '<span class="registered">Payment Pending</span>';}
                                if($ccstatus==4) { echo '<span class="inactivestatus" style="margin-top:3px;">blacklist</span>';}
                            ?>  
                        </td>
                        <td>
                            <?php if($student['idcard_status']==1){
                                echo '<span class="iddownload" style="margin-top:3px;">Downloaded</span>';
                            }else{
                                echo '<span class="idpending" style="margin-top:3px;">Pending</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href ="<?php echo base_url('backoffice/view-student/'.$student['student_id']);?>" id="#view_student" >
                                <button title="View" class="btn btn-default option_btn " title="View" onclick="view_studentdata(<?php echo $student['student_id'];?>)">
                                    <i class="fa fa-eye "></i>
                                </button>
                            </a>
                            <a href ="<?php echo base_url('backoffice/print-application/'.$student['student_id']);?>" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
                            <a class="btn btn-primary btn-sm btn_details_view" href="<?php echo base_url();?>backoffice/manage-students/<?php echo $student['student_id'];?>">
                                Details
                            </a>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Student</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
             <form enctype="multipart/form-data" id="add_form" method="post">
            <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Status <span class="req redbold">*</span></label>
                                <select class="form-control" name="status" id="status_change">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="5">Inactive</option>
                                </select>
                               
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="show_desc" style="display:none;">
                            <div class="form-group"><label>Description<span class="req redbold">*</span></label>
                                <input type="text" name="description" class="form-control" />
                            </div>
                        </div>
                        
                        <input type="hidden" name="id" id="status_id"/>

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
<?php $this->load->view("admin/scripts/studentlist_script");?>
