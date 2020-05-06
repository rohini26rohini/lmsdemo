<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <form id="search_form">
        <div class="row filter">
             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
             
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('centre');?></label>
                   
                    <select class="form-control" id="filter_centre"  name="centre_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <?php 
                        $centre=$this->common->get_alldata('am_institute_master',array("institute_type_id"=>"3","status"=>"1"));
                        if(!empty($centre))
                        {
                            foreach($centre as $val)
                            {
                                ?>
                        <option value="<?php echo $val['institute_master_id']; ?>"><?php echo $val['institute_name']; ?></option>
                        <?php
                            }
                        }
                        ?>
                        
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('course');?></label>
                   
                    <select class="form-control" id="filter_course" name="course_id">
                     <option value=""><?php echo $this->lang->line('select'); ?></option>  
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('batch');?></label>
                    <select class="form-control" id="filter_batch" name="batch_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label style="display:block;">&nbsp;</label>
                    <a href="<?php echo base_url();?>backoffice/student-notification"><button type="button" class="btn btn-default add_row add_new_btn btn_add_call" id="reset_form">
                        Reset
                    </button></a>
                </div>
            </div>
          
            
            </div></form>
    </div>
    <div class="white_card ">
        <h6>Student Notification</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
         <form id="msg_form">
        <div class="row">
       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>
                            <?php echo $this->lang->line('sl_no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('student_reg.no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('student_name');?>
                        </th>
                        <th> <label class="custom_checkbox"><?php echo $this->lang->line('action');?>
                    <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                    <span class="checkmark"></span>
                    </label>
                            
                        </th>
                        
                    </tr>
                </thead>
                        <tbody>
                        </tbody>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
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
    </div>
</div>

<?php $this->load->view("admin/scripts/student_notification_script");?>
