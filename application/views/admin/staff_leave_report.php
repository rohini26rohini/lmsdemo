<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('staff_leave_report'); ?></h6>
        <hr>
        <form id="search_form">
        <div class="row filter">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('staff');?></label><span class="req redbold">*</span>
                    <?php $faculty = $this->common->get_staff_list_by_roles();?>
                    <select class="form-control" id="filter_faculty" name="faculty_id">
                        <option value="">All</option>
                        <?php foreach($faculty as $val) {
                            echo '<option value="'.$val["personal_id"].'">'.$val["name"].' ('.$val["registration_number"].')</option>';
                        }?>
                    </select>
                </div>
            </div> 
            <!-- <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('type');?></label><span class="req redbold"></span>
                <?php $batches = $this->common->get_alldata('leave_heads',array("status"=>1));?>
                    <select class="form-control" id="filter_batch" name="batch_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <?php foreach($batches as $val) {
                            echo '<option value="'.$val["id"].'">'.$val["head"].'</option>';
                        }?>
                    </select>
                </div>
            </div>  -->
            <!-- <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('status');?></label>
                    <select class="form-control" id="filter_status" name="status">
                        <option value="">Select</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="2">Rejected</option>
                    </select>
                </div>
            </div> -->
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
                <a class="btn btn-default add_row add_new_btn btn_add_call" href="<?php echo base_url('backoffice/staff-leave-report');?>">
                Reset</a>
            </div>
        </div>
        </form>
    </div>
    <!-- Data Table Plugin Section Starts Here -->
    <form id="filter_form" method="post" action="<?php echo base_url('backoffice/Report/export_leave_report');?>">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <input type="hidden" id="export_faculty_id" name="faculty_id"/>
    <input type="hidden" id="export_start_date" name="start_date"/>
    <input type="hidden" id="export_end_date" name="end_date"/>
    <div class="white_card">
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="studentlist_table1" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('staff');?></th>
                        <?php $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
                        foreach($leaveHeads as $head){
                            echo '<th>'.$head['head'].'</th>';
                        }?>
                        <th><?php echo $this->lang->line('total');?></th>
                    </tr>
                </thead><?php 
                $i = 1;
                // $faculty = $this->common->get_staff_list_by_roles();
                foreach($staff as $row){
                ?> <tr> 
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <?php $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
                        foreach($leaveHeads as $head){?>
                            <td><?php echo $this->common->get_leaveBystaff($row['personal_id'], $head['id']);?></td>
                        <?php } ?>
                    <td><?php echo $this->common->get_leaveBystaff_total($row['personal_id']);?></td>
                </tr>
                <?php $i++; } ?>
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
<?php $this->load->view("admin/scripts/staff_leave_report_script");?>