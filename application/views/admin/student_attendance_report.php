<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('student_attendance_report'); ?></h6>
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
                <label><?php echo $this->lang->line('student');?></label>
                    <select class="form-control" id="filter_student" name="student">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('type');?></label>
                    <select class="form-control" id="filter_type" name="att_type">
                        <option value="class" selected>Class</option>
                        <option value="exam">Exam</option>
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
                <a class="btn btn-default add_row add_new_btn btn_add_call" href="<?php echo base_url('backoffice/student-attendance-report');?>">
                Reset</a>
            </div>
            
        </div>
        </form>
        <!-- <h2><?php //echo $this->session->flashdata('item'); ?></h2>  -->
    </div>
    <div class="alert alert-warning alert-dismissible fade show alertemp" role="alert" <?php if(!$this->session->flashdata('item')) { echo 'style="display:none;"'; }?>>
        <?php echo $this->session->flashdata('item'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- Data Table Plugin Section Starts Here -->
    <form id="filter_form" method="post" action="<?php echo base_url('backoffice/Report/export_student_attendance_report');?>">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <input type="hidden" id="export_student_id" name="student_id"/>
    <input type="hidden" id="export_batch_id" name="batch_id"/>
    <input type="hidden" id="export_type" name="att_type"/>
    <input type="hidden" id="export_start_date" name="start_date"/>
    <input type="hidden" id="export_end_date" name="end_date"/>
    <div class="white_card" id="white_card_tbl" style="display: none">
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="studentlist_table1" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('student');?></th>
                        <th><?php echo $this->lang->line('subjectorexam');?></th>
                        <th><?php echo $this->lang->line('attendance');?></th>
                        <th><?php echo $this->lang->line('staff');?></th>
                        <th><?php echo $this->lang->line('date');?></th>
                    </tr>
                </thead>
            </table>
        </div>
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

<?php $this->load->view("admin/scripts/student_attendance_report_script");?>
