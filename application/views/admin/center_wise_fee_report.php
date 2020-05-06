<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <!-- Data Table Plugin Section Starts Here-->
    <div class="white_card">
        <div class="centerWise">
            <h6><?php echo $this->lang->line('center_wise_fee_report'); ?></h6>
            <hr>
            <form id="search_form">
                <div class="row filter">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo  $this->security->get_csrf_hash();?>" />
                    <div class="col-sm-2 col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('centre');?></label><span class="req redbold">*</span>
                            <?php $centre = $this->common->get_centre(); //show($centre); ?>
                            <select class="form-control" id="filter_centre" name="centre_id">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php foreach($centre as $val) {
                                    echo '<option value="'.$val["institute_master_id"].'">'.$val["institute_name"].'</option>';
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('course');?></label><span class="req redbold"></span>
                            <select class="form-control form-control-sm" id="filter_course" name="course_id">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-12 batchwise" style="display: none">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('batch');?></label><span class="req redbold"></span>
                            <select class="form-control" id="filter_batch" name="batch_id">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                            </select>
                        </div>
                    </div> 
                    <input type="hidden" id="courseorbatch" name="courseorbatch" value='0'/>
                    <div class="col-sm--10 col--12" style="margin-top:31px;">
                        <div class="form-group">
                            <button class="btn btn-default add_row add_new_btn btn_add_call centerWiseSearch"> Search </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-sm--10 col--12" style="margin-top:31px;">
                        <div class="form-group">
                        &nbsp;<a class="btn btn-default add_row add_new_btn btn_add_call" href="<?php echo base_url('backoffice/center-wise-fee-report');?>">
                Reset</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
            <div class="alert alert-warning alert-dismissible fade show alertemp" role="alert" <?php if(!$this->session->flashdata('item')) { echo 'style="display:none;"'; }?>>
                <?php echo $this->session->flashdata('item'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id='white_card_tbl' style="display: none">
            <form id="filter_form" method="post" action="<?php echo base_url('backoffice/Report/export_fee_centre_report');?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <input type="hidden" id="export_centre" name="centre_id"/>
                <input type="hidden" id="export_course" name="course_id"/>
                <input type="hidden" id="export_batch" name="batch_id"/>
                <input type="hidden" id="export_courseorbatch" name="courseorbatch"/> 
                <ul class="nav nav-pills">
                    <li class="nav-item"><a data-toggle="pill" class="active nav-link courcewisetab" href="#home">Course Wise</a></li>
                    <li class="nav-item"><a data-toggle="pill" class="nav-link batchwisetab"  href="#menu1">Batch Wise</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane  in active">
                        <div class="table-responsive">
                            <table class="table table-striped" id="cource_wise_data">
                                
                            </table>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-striped" id="batch_wise_data">
                                
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type" id="type">
                <div class="dropup dropup-export exportbtn" style="display:none;">
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
            </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/centre_wise_fee_report_script");?>
