<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('student_report'); ?></h6>
        <hr>
         <form id="search_form">
        <div class="row filter">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('school');?></label>
                   
                    <select class="form-control" id="filter_school" onchange="get_course();" name="school_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <?php 
                        $schools=$this->common->get_alldata('am_schools',array("school_status"=>"1"));
                        if(!empty($schools))
                        {
                            foreach($schools as $val)
                            {
                                ?>
                        <option value="<?php echo $val['school_id']; ?>"><?php echo $val['school_name']; ?></option>
                        <?php
                            }
                        }
                        ?>
                        
                    </select>
                </div>
            </div>   
            
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('centre');?></label>
                   
                    <select class="form-control" id="filter_centre" onchange="get_course();" name="centre_id">
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
                <label><?php echo $this->lang->line('status');?></label>
                    <select class="form-control" id="filter_status" name="status">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <option value="1"><?php echo $this->lang->line('admitted'); ?></option>
                        <option value="4"><?php echo $this->lang->line('Batch_Changed'); ?></option>
                        <option value="blacklist"><?php echo $this->lang->line('Blacklist'); ?> </option>
                        <option value="1"><?php echo $this->lang->line('Fee_Paid'); ?></option>
                        <option value="5"><?php echo $this->lang->line('Inactive'); ?></option>
                        <option value="0"><?php echo $this->lang->line('payment_pending'); ?></option>
                      
                    </select>
                </div>
            </div>
          <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('start_date');?></label>
                        <input type="text" class="form-control calendarclass" name="start_date" onkeypress="return ValDate(event)" autocomplete="off" id="start_date">
                    </div>
                </div>
            <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('end_date');?></label>
                        <input type="text" class="form-control calendarclass" name="end_date" onkeypress="return ValDate(event)" autocomplete="off" id="end_date">
                    </div>
                </div>
            <div class="col-sm-12 col-12 filerPad text-right">
                    <button class="btn btn-default add_row add_new_btn btn_add_call ">
                                  Search                                </button>
                </div>
            
        </div>
        </form>
    </div>

    <div class="alert alert-warning alert-dismissible fade show alertemp" role="alert" <?php if(!$this->session->flashdata('item')) { echo 'style="display:none;"'; }?>>
        <?php echo $this->session->flashdata('item'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <!-- Data Table Plugin Section Starts Here -->
      <form id="filter_form" method="post" action="<?php echo base_url('backoffice/Report/export_student_report');?>">
           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <input type="hidden" id="export_school" name="school_id"/>
          <input type="hidden" id="export_centre_id" name="centre_id"/>
          <input type="hidden" id="export_course_id" name="course_id"/>
          <input type="hidden" id="export_batch_id" name="batch_id"/>
          <input type="hidden" id="export_status" name="status"/>
          <input type="hidden" id="export_start_date" name="start_date"/>
          <input type="hidden" id="export_end_date" name="end_date"/>
    <div class="white_card">
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="studentlist_table1" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('application.no');?></th>
                        <th><?php echo $this->lang->line('name');?></th>
                        <th><?php echo $this->lang->line('course');?></th>
                        <th><?php echo $this->lang->line('emailid');?></th>
                        <th><?php echo $this->lang->line('contact.no');?></th>
                        <th><?php echo $this->lang->line('location');?></th>
                        <th><?php echo $this->lang->line('status');?></th>
                        
                    </tr>
                </thead>
                <?php 
                $i=1; foreach($studentArr as $student){ 
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
                        <?php echo $this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$student['course_id'])) ;?>
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
                            if ($student['status']==1) { echo 'Admitted';}
                            else if($student['status']==2) { echo 'Fee Paid';}
                            else if($student['status']==4) { echo 'Batch Changed';}
                            else if($student['status']==5) { echo 'Inactive';}
                            else if($student['status']==0 && $student['verified_status']==1) { echo 'Payment Pending';}
                            else  { echo 'Payment Pending';}
                            if($ccstatus==4) { echo 'Blacklist';}
                        ?>  
                    </td>
                    
                   
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
        <!-- <button class="btn btn-default add_row btn_map btn_print"  type="submit">
            <i class="fa fa-upload"></i> Export
        </button> -->
        <input type="hidden" name="type" id="type">
        <div class="dropup dropup-export">
            <button type="button" class="btn btn-sm btn-default add_row btn_map btn_print dropdown-toggle"      data-toggle="dropdown">
                <i class="fa fa-upload"></i> Export
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" style="cursor: pointer;" onclick="export_data('pdf')">
                    <i class="fa fa-file-pdf-o"></i>
                    Pdf
                  </a>
                <a class="dropdown-item" style="cursor: pointer;" onclick="export_data('excel')">
                    <i class="fa fa-file-excel-o"></i>
                    Excel
                </a>
            </div>
        </div>
    </div>
    </form>
</div>


<?php $this->load->view("admin/scripts/student_report_script");?>
