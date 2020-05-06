<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php $this->lang->line('student_report'); ?></h6>
        <hr>
         <form id="search_form">
        <div class="row filter">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            
          <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('start_month');?></label>
                        <input type="text" class="form-control month_year" name="start_date" onkeypress="return ValDate(event)" autocomplete="off" id="start_date">
                    </div>
                </div>
            <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('end_month');?></label>
                        <input type="text" class="form-control month_year" name="end_date" onkeypress="return ValDate(event)" autocomplete="off" id="end_date">
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
    <div class="white_card">
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table  id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('date');?></th>
                        <th><?php echo $this->lang->line('attendance');?></th></tr>
                </thead>
               <tbody id="staff_attendance">
                   <?php if(!empty($details)){ $i=1;
                   foreach($details as $row){?>
                   <tr>
                   <td><?php echo $i;?></td>
                   <td><?php echo date('d-m-Y',strtotime($row['date']));?></td>
                   <td><?php if($row['attendance'] == "1")
                   { echo "<span><i class='fa fa-check text-success'></i></span>";} 
                    else 
                   {
                       echo "<span><i class='fa fa-times text-danger'></i></span>";
                   }?></td>
                   </tr>
                   <?php $i++; } }?>
                </tbody>
                
               
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
        
    </div>
    </form>
</div>


<?php $this->load->view("admin/scripts/view_attendance_byperson_script");?>
<?php //$this->load->view("admin/scripts/staff_attendance_report_script");?>
