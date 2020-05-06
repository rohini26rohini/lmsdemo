<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <form id="remainder_sms_form" method="post" action="">
            <!-- Data Table Plugin Section Starts Here -->
            <div class="white_card">
                <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel1">Select progress:</label> <span class="req redbold">*</span>
                            <select class="form-control smssendingtype" id="type" name="type">
                                <option value="">Select</option>
                                <option value="Hot">Hot</option>
                                <option value="Warm">Warm</option>
                                <option value="Cold ">Cold </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label for="sel1">Select student:</label> <span class="req redbold">*</span>
                            <select id="multi-select-demo" multiple="multiple" name="candidate[]">
                                
                            </select>
                            <span id="student_err_mess" class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group diremainder-sms">
                            <label for="comment">Comment:</label> <span class="req redbold">*</span>
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


























