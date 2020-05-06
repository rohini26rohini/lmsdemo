<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Staff Attendance Report</h6>
        <hr>
         <form id="search_form">
        <div class="row filter">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            
          <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('start_date');?></label>
                        <input type="text" class="form-control dob" name="start_date" onkeypress="return ValDate(event)" autocomplete="off" id="start_date">
                    </div>
                </div>
            <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('end_date');?></label>
                        <input type="text" class="form-control dob" name="end_date" onkeypress="return ValDate(event)" autocomplete="off" id="end_date">
                    </div>
                </div>
            <div class="col-sm-12 col-12 filerPad text-right">
                    <button class="btn btn-default add_row add_new_btn btn_add_call ">
                                  Search                                </button>
                </div>
            
        </div>
        </form>
    </div>
    <!-- Data Table Plugin Section Starts Here -->
      <form id="export_data" method="post" action="<?php echo base_url('backoffice/Report/export_staff_attendance_report');?>">
           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <input name="start_date" id="export_startdate" type="hidden"/>
          <input name="end_date" id="export_enddate"  type="hidden"/>
    <div class="white_card" style="display:none;">
        <div class="table-responsive table_language" style="margin-top:15px;" id="staff_detail">
           
        </div>
       
        <button class="btn btn-default add_row btn_map btn_print"  type="submit" id="export" style="display:none;">
            <i class="fa fa-upload"></i> Export
        </button>
    </div>
    </form>
</div>
<?php $this->load->view("admin/scripts/staff_attendance_report_script");?>
