<link href="<?php echo base_url();?>inner_assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>inner_assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>inner_assets/js/parsley.js" type="text/javascript"></script>
<div class="col-12 col-xs-12 col-sm-8 col-md-8 col-lg-9 col-xl-10 NoPaddingLeft content_wrapper ">
    <div class="tab_nav">
        <div class="tab_box ">
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="white_card ">
                        <div class="add_dtl" style="display: none;">
                            <form data-validate="parsley" action="" method="post" class="add-edit">
                                <h3 id="form_title_h2">
                                    <?php echo $this->lang->line('new_salary_advance'); ?>
                                </h3>
                                <hr class="hrCustom">

                                <input type="hidden" id="data_grid" name="data_grid">
                                <input type="hidden" id="selected_id" name="selected_id">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <span class="span_label "><?php echo $this->lang->line('staff'); ?></span>
                                        <div class="form-group">
                                            <select name="staff" id="staff" class="form-control parsley-validated" data-required="true"></select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <span class="span_label "><?php echo $this->lang->line('date'); ?></span>
                                        <div class="form-group">
                                            <input type="text" class="form-control calendarclass parsley-validated" name="date" data-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <span class="span_label "><?php echo $this->lang->line('type'); ?></span>
                                        <div class="form-group">
                                            <select name="type" id="type" class="form-control parsley-validated" data-required="true">
												
											</select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <span class="span_label "><?php echo $this->lang->line('amount'); ?></span>
                                        <div class="form-group">
                                            <input type="number" name="amount" id="amount" class="form-control parsley-validated" data-required="true" min="0.0" step="0.1" />
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                        <span class="span_label "><?php echo $this->lang->line('description'); ?></span>
                                        <div class="form-group">
                                            <textarea name="description" id="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12 col-sm-12 col-12 ">
                                        <button class="btn btn-primary saveButton"><?php echo $this->lang->line('save'); ?></button>
                                        <a class="btn btn-default" id="cancelEdit"><?php echo $this->lang->line('cancel'); ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="dtl_tbl show_form_add" style="min-height: auto;">

                            <h6>
                                <?php echo $this->lang->line('salary_advance_list'); ?>
                            </h6>
                            <hr class="hrCustom">

                            <button type="button" class="btn btn-default add_row btn_map  plus_btn addBtnPosition"><?php echo $this->lang->line('new_salary_add_on'); ?></button>


                            <div class="table-responsive table_language">
                                <table class="table table-striped table-sm dataTable no-footer" id="salary_advance" table="salary_advance" action_url="<?php echo base_url() ?>service/Salary_data/get_salary_advance">
                                    <thead>
                                        <tr class="bg-warning text-white ">
                                            <th>ID</th>
											<th><?php echo $this->lang->line('sl'); ?></th>
                                            <th>
                                                <?php echo $this->lang->line('staff'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('date'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('amount').' ('.CURRENCY.')'; ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('type'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('status'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('description'); ?>
                                            </th>
<!--
                                            <th>
                                                <?php echo $this->lang->line('payslip_id'); ?>
                                            </th>
-->
                                            <th>
                                                <?php echo $this->lang->line('created_on'); ?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('action'); ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
</div>
</section>
</section>
<?php $this->load->view('admin/scripts/salary_advances_script.php'); ?>
<div class="modal fade ModelCustom" id="viewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalTitle">View Leave Scheme</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <table class="table table-bordered scrolling table-sm tableViewModal">
                    <tbody id="viewModalContent"></tbody>
                </table>
                <br>
                <div id="other_details" class="table-responsive TblPay"></div>
                <br>
                <div id="other_details1" class="table-responsive TblPay"></div>
            </div>
            <!-- Modal footer -->
            <!--
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
-->
        </div>
    </div>
</div>
