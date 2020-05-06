<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('exam_avgmark_report'); ?></h6>
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
                <label>Exam</label><span class="req redbold">*</span>
                    <select class="form-control" id="filter_exam" name="filter_exam">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-12 filerPad text-right">
                <button class="btn btn-default add_row add_new_btn btn_add_call "> Search </button>
                <a class="btn btn-default add_row add_new_btn btn_add_call" href="<?php echo base_url('backoffice/exam-avgmark-report');?>">
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
    <form id="filter_form" method="post" action="<?php echo base_url('backoffice/Report/export_section_mark');?>">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <input type="hidden" id="export_exam" name="exam"/>
    <div class="white_card" id="white_card_tbl" style="display: none">
        <div class="table-responsive table_language" style="margin-top:15px;" id="studentlist_tablONE">
            <table id="studentlist_table1" class="table table-striped table-sm" style="width:100%">
                
            </table>
        </div>
        <input type="hidden" name="type" id="type">
        <div class="dropup dropup-export">
            <button type="button" class="btn btn-sm btn-default add_row btn_map btn_print dropdown-toggle" data-toggle="dropdown">
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
<?php $this->load->view("admin/scripts/exam_avgmark_report_script");?>