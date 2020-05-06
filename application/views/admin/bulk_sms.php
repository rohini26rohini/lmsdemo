<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <form id="bulk_sms_form" method="post" action="">
            <!-- Data Table Plugin Section Starts Here -->
            <div class="white_card">
                <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel1">Select Branch:</label> <span class="req redbold"> *</span>
                            <select class="form-control selectcentre" id="branch" name="branch">
                                <option value="">Select</option>
                                <?php
                                if(!empty($branchArr)) {
                                    foreach($branchArr as $branch){
                                echo '<option value="'.$branch->institute_master_id.'">'.$branch->institute_name.'</option>';
                                    }
                                }
                                ?>
                            </select>
                                </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel1">Select Centre:</label> <span class="req redbold"> *</span>
                            <select class="form-control selectbatch" id="centre" name="centre">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel1">Select Batch:</label> <span class="req redbold"> *</span>
                            <select class="form-control selectstudent" id="batch" name="batch">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label for="sel1">Student list:</label> <span class="req redbold"> *</span>
                            <select id="multi-select-demo" multiple="multiple" id="candidate" name="candidate[]">
                                
                            </select>
                            <span id="student_err_mess" class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group diremainder-sms">
                            <label for="comment">Comment:</label> <span class="req redbold"> *</span>
                            <textarea class="form-control" rows="5" id="message" name="message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="form-group">
                        <button class="btn btn-success">Send</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        
                    </div>
                </div>
  
            </div>
        </form>
    </div>
<?php $this->load->view("admin/scripts/remainder_sms_script");?>


























