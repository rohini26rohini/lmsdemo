<div class="relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
    <h6>Total Admitted Call</h6>
        <hr>
    <div class="transparent_card ">
            
            <div id="result">
                <div class="table-responsive table_language">
                    
        
    <table id="cc_iprogresstable" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
            <th>Sl. No.</th>
                <th>Name</th>
                <th>Enquiry Type</th>
                <th>Course</th>
                <th>Primary Contact</th>
                <th>Street</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <?php 
    if(!empty($calls)) {
    ?>
        <tbody>
            <?php 
             $i=1;
            foreach($calls as $call) { 
            ?>
            <tr>
            <td><?php echo $i;?></td>
                <td><?php echo $call->name;?></td>
                <td><?php echo $call->enquiry_type;?></td>
                <td><?php echo $call->class_name;?></td>
                <td><?php echo $call->primary_mobile;?></td>
                <td><?php echo $call->street;?></td>
                 <td><?php if($call->timing!='') { echo date('d/m/Y h:m:s', strtotime($call->timing));}?></td>
            </tr>
            <?php $i++;} ?>
        </tbody>
         <?php } ?>
    </table>
   
                </div>
            <!-- Data Table Plugin Section Starts Here -->
            </div>
           
    </div>
    </div>
</div>

<div id="follow_up1" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Follow Up</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-pills_admin">
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="pill" href="#head1">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#head2">Add Follow up</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="head1" class="tab-pane active">
                    <p id="errormsg"></p>
                        <form id="history" type="post">
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="call_id" class="form-control" id="history_call_id"/>

                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Comments</label>
                                        <input class="form-control" type="text" name="comments" placeholder="Comments" id="comments">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time</label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date">

                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status<span class="req redbold">*</span></label>
                                        <select class="form-control" name="status" id="status" data-validate="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Call Received</option>
                                            <option value="2">In Progress</option>
                                            <option value="2">Closed</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive table_language" id="history_view"></div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div id="head2" class="tab-pane">
                    <p id="errormsg"></p>
                        <form id="add_followup" type="post">
                            <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="call_id" class="form-control" id="follow_call_id" />
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time</label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="1">Answered</option>
                                            <option value="2">No Answer</option>
                                            <option value="3">Busy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Comments</label>
                                        <input class="form-control" type="text" name="comment" placeholder="Comments" id="comment">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-info">Update</button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
