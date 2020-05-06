<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <div class="row filter">
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label>Registration Number</label>
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

        </div>
    </div>
        <!-- Data Table Plugin Section Starts Here -->
    <div class="white_card">
        <div class="row ">
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right flex-row-reverse ">
                <a href="<?php echo base_url();?>backoffice/manage-student"><button class="btn btn-default add_row add_new_btn btn_add_call" >
                                    Add Student
                                </button></a>

            </div>
        </div>
        <div class="table-responsive">
            <ul class="data_table " id="students_data">
                <li class="data_table_head ">
                    <div class="col  ">Sl. No.</div>
                    <div class="col  ">Reg No</div>
                    <div class="col ">Name</div>
                    <div class="col ">Email</div>
                    <div class="col ">Contact Number</div>
                    <div class="col ">Location</div>
                    <div class="col ">Status</div>
                    <div class="col actions">Action</div>

                </li>
                <?php $i=1; foreach($studentArr as $student){ 
                $ccstatus = '';

                if($student['caller_id']>0) { 
                $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$student['caller_id']));
                     if(!empty($callcentre['call_status'])){
                $ccstatus = $callcentre['call_status'];
                } }
                ?>
                <li>

                    <div class="col">
                        <?php echo $i;?>
                    </div>

                    <div class="col">
                        <?php echo $student['registration_number'];?>
                    </div>
                    <div class="col">
                        <?php echo $student['name'];?>
                    </div>
                    <div class="col">
                        <?php echo $student['email'];?>
                    </div>
                    <div class="col">
                        <?php echo $student['contact_number'];?>
                    </div>
                    <div class="col">

                        <?php echo $student['street'];?>

                    </div>
                    <div class="col">
                        
                        <?php 
                            if ($student['status']==1) { echo '<span class="admitted">Admitted</span>';}
                            else if($student['status']==2) { echo '<span class="paymentcompleted">Fee Paid</span>';}
                            else if($student['status']==4) { echo '<span class="batchchanged">Batch Changed</span>';}
                            else if($student['status']==5) { echo '<span class="inactivestatus">Inactive</span>';}
                            else  { echo '<span class="registered">Registered</span>';}
                                if($ccstatus==4) { echo '<span class="inactivestatus" style="margin-top:3px;">blacklist</span>';}
                        ?>  
                    </div>
                    <div class="col actions">
                    <a href ="<?php echo base_url('backoffice/view-student/'.$student['student_id']);?>" id="#view_student" ><button class="btn btn-default option_btn " title="View" onclick="view_studentdata(<?php echo $student['student_id'];?>)">
                            <i class="fa fa-eye "></i>
                        </button></a>
                        <a class="btn btn-primary btn-sm btn_details_view" href="<?php echo base_url();?>backoffice/manage-students/<?php echo $student['student_id'];?>">Details

                        </a>
                    </div>
                </li>

                <?php $i++; } ?>



            </ul>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>


<?php $this->load->view("admin/scripts/studentlist_script");?>
