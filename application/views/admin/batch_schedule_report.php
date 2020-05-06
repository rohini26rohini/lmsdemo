<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('batch_schedule_report'); ?></h6>
        <hr>
         <form id="search_form">
        <div class="row filter">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('batch');?></label><span class="req redbold">*</span>
                <?php $batches = $this->common->get_alldata('am_batch_center_mapping',array("batch_status"=>1));?>
                    <select class="form-control" id="filter_batch" name="batch_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <?php foreach($batches as $val) {
                            echo '<option value="'.$val["batch_id"].'">'.$val["batch_name"].'</option>';
                        }?>
                    </select>
                </div>
            </div> 
            <div class="col-sm-2 col-12">
                <div class="form-group">
                <label>Subject</label>
                    <select class="form-control" id="filter_subject" name="filter_subject">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('status');?></label>
                    <select class="form-control" id="filter_status" name="status">
                        <option value="">Select</option>
                        <option value="0">Pending</option>
                        <option value="1">completed</option>
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
                    <button class="btn btn-default add_row add_new_btn btn_add_call "> Search </button>
                    <a class="btn btn-default add_row add_new_btn btn_add_call" href="<?php echo base_url('backoffice/batch-schedule-report');?>">
                                  Reset</a>
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
    <form id="filter_form" method="post" action="<?php echo base_url('backoffice/Report/export_batch_report');?>">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <input type="hidden" id="export_batch_id" name="batch_id"/>
    <input type="hidden" id="export_status" name="status"/>
    <input type="hidden" id="export_start_date" name="start_date"/>
    <input type="hidden" id="export_end_date" name="end_date"/>
    <input type="hidden" id="export_subject" name="subject"/>
    <div class="white_card">
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="studentlist_table1" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('batch');?></th>
                        <th><?php echo $this->lang->line('subject');?></th>
                        <th width="50"><?php echo $this->lang->line('date');?></th>
                        <th><?php echo $this->lang->line('start_time');?></th>
                        <th><?php echo $this->lang->line('end_time');?></th>
                        <th><?php echo $this->lang->line('module_name');?></th>
                        <th><?php echo $this->lang->line('staff');?></th>
                        <th><?php echo $this->lang->line('status');?></th>
                        
                    </tr>
                </thead>
                <?php 
                $i=1; foreach($batchArr as $row){  if($row['schedule_type'] == 1) $type = 'Exam'; else $type = 'Class';?>
                    <tr>
                        <td><?php echo $i;?> </td>
                        <td><?php echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));?> </td>
                        <td><?php echo $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$row['subject_master_id']));?> </td>
                        <td><?php echo date('d-m-Y',strtotime($row['schedule_date']));?> </td>
                        <td><?php echo date("g:i a", strtotime($row['schedule_start_time'])); ?> </td>
                        <td><?php echo date("g:i a", strtotime($row['schedule_end_time'])); ?> </td>
                        <td><?php echo $this->common->get_module_fromschedule_idname_by_id($row['module_id']); ?> </td>
                        <td><?php echo $this->common->get_name_by_id('am_staff_personal','name',array("personal_id"=>$row['staff_id'])); ?> </td>
                        <td><?php if($row['class_taken'] == 1){
                            echo 'Completed';
                        }else{
                            echo 'Pending';
                        }
                        ?> </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
        <!-- <button class="btn btn-default add_row btn_map btn_print"  type="submit">
            <i class="fa fa-upload"></i> Export
        </button> -->
        <input type="hidden" name="type1" id="type1">
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

<?php $this->load->view("admin/scripts/batch_schedule_report_script");?>
