<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <div class="white_card">
            <h6>Manage External Candidates</h6>
            <hr>
            <button type="button" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" onclick="add_ext_candidate()">
                Add External Candidates
            </button>
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table id="external_candidates" class="table table-striped table-sm dirstudent-list" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">Sl.No.</th>
                            <th width="20%">Name</th>
                            <th width="15%">Email</th>
                            <th width="10%">Contact No.</th>
                            <!-- <th width="10%">Whatsapp No.</th>
                            <th width="10%">Mobile No.</th> -->
                            <th width="15%">Registration No.</th>
                            <th width="20%">Batch</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="external_candidates_body">
                        <tr>
                            <td></td>
                            <td>Loading please wait</td>
                            <td></td>
                            <td></td>
                            <!-- <td></td>
                            <td></td> -->
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<div id="add_edit" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="add_edit_title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
             <form enctype="multipart/form-data" id="add_edit_form" method="post" autocomplete="no">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>External candidate's batch<span class="req redbold">*</span></label>
                                <select name="batch_id" id="batch_id"class="form-control">
                                    <option value="">Select a batch</option>
                                    <?php 
                                        if(!empty($batches)){ 
                                            foreach($batches as $row){
                                                echo '<option value="'.$row['batch_id'].'">'.$row['batch_name'].'</option>';
                                            }
                                        } 
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Candidate Name<span class="req redbold">*</span></label>
                                <input type="text" name="name" id="name"class="form-control" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Contact Number<span class="req redbold">*</span></label>
                                <input class="form-control numbersOnly valid" maxlength="12" name="contact_number" id="contact_number" onkeypress="return valNum(event)"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Email</label>
                                <input type="email" name="email" id="email" class="form-control valid"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>State<span class="req redbold">*</span></label>
                                <select name="state" id="state"class="form-control">
                                    <option value="">Select a state</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Location<span class="req redbold">*</span></label>
                                <select name="district" id="district"class="form-control">
                                    <option value="">Select a state</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Mobile Number</label>
                                <input class="form-control numbersOnly valid" maxlength="12" name="mobile_number" id="mobile_number" onkeypress="return valNum(event)"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Whatsapp Number</label>
                                <input class="form-control numbersOnly valid" maxlength="12" name="whatsapp_number" id="whatsapp_number" onkeypress="return valNum(event)"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Date of Birth</label>
                                <input type="text" class="form-control calendarclass valid" name="date_of_birth" id="date_of_birth" onkeypress="return ValDate(event)"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Gender</label>
                                <select name="gender" id="gender"class="form-control">
                                    <option value="">Select a gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Address</label>
                                <input type="text" name="address" id="address"class="form-control" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Street</label>
                                <input type="text" name="street" id="street"class="form-control" />
                            </div>
                        </div>
                        <input type="hidden" name="student_id" id="student_id"/>
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
<div id="view_candidates" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Candidate Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <table class="table table-bordered table-striped table-sm">
                <tbody>
                    <tr>
                        <th>External candidate's batch</th>
                        <td id="view_ext_can_batch"></td>
                    </tr>
                    <tr>
                        <th>Candidate Name</th>
                        <td id="view_ext_can_name"></td>
                    </tr>
                    <tr>
                        <th>Contact Number</th>
                        <td id="view_ext_can_connum"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="view_ext_can_email"></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td id="view_ext_can_state"></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td id="view_ext_can_location"></td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td id="view_ext_can_mobnum"></td>
                    </tr>
                    <tr>
                        <th>Whatsapp Number</th>
                        <td id="view_ext_can_watnum"></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td id="view_ext_can_dob"></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td id="view_ext_can_gen"></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td id="view_ext_can_addr"></td>
                    </tr>
                    <tr>
                        <th>Street</th>
                        <td id="view_ext_can_strt"></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/students/external_candidates_script");?>
