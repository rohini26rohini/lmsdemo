<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <!-- Data Table Plugin Section Starts Here -->
        <div class="row ">
             <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#reg1" id="reg_1">Students</a>
                            </li>
                        </ul>
                        <div class="tab-content"> 
                            <div id="reg1"  class=" tab-pane active">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                                                <div class="form-group">
                                                    <label>Application.No</label>
                                                    <input class="form-control" type="text" id="applicationno" name="applicationno" placeholder="Application.No" aria-invalid="false">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 dir_upr">
                                                <div class="form-group">
                                                    <label>E-mail</label>
                                                    <input class="form-control" type="text" id="email" name="email" placeholder="E-mail" aria-invalid="false">
                                                </div>
                                                <span>OR</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                                            <div class="form-group">
                                                    <label>Mobile Number</label>
                                                    <input class="form-control" type="text" id="mobileno" name="mobileno" placeholder="Mobile Number" onkeypress="return valNum(event);" aria-invalid="false">
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <button class="btn btn-success" id="searchbutton" type="button">Search</button>
                                            <a href="<?php echo base_url('backoffice/users-password-reset')?>" class="btn btn-primary" >Reset</a>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <label>Batch</label>
                                            <select class="form-control search_syllabus_mapp" id="get_batch_student">
                                                <option value="">Select Batch</option>
                                                <?php
                                                if(!empty($batch)) { 
                                                foreach($batch as $bath) {
                                                    ?>
                                                    <option value="<?php echo $bath->batch_id;?>"><?php echo $bath->batch_name;?></option>
                                                    <?php
                                                }
                                                 } ?>
                                            </select>
                                        </div>
                                    </div> 
                                </div>  
                                <div class="table-responsive table_language" style="margin-top:15px;">
                                    <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('sl_no');?></th>
                                                <th><?php echo $this->lang->line('name');?></th>
                                                <th><?php echo $this->lang->line('applicationno');?></th>
                                                <th><?php echo $this->lang->line('email');?></th>
                                                <th><?php echo $this->lang->line('mobileno');?></th>
                                                <th><?php echo $this->lang->line('action');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="resetpassword" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_syllabus_form" method="post">
                <div class="modal-body">
                    <p id="viewchangedpassword"></p>
                </div>        
            </form>
        </div>
    </div>
</div>


<div id="resetparent" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reset Parent Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id=""></p>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/user_reset_pass_script");?> 
