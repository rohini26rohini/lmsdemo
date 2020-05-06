<link href="<?php echo base_url();?>inner_assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>inner_assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>inner_assets/js/parsley.js" type="text/javascript"></script>
<div class="col-12 col-xs-12 col-sm-8 col-md-8 col-lg-9 col-xl-10 NoPaddingLeft">
                    <div class="tab_nav">
                        <div class="tab_box ">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="add_dtl" style="display: none;">
                                        <form data-validate="parsley" action="" method="post" class="add-edit">

                                                    <h3 id="form_title_h2">New Leave Entry</h3>
													<hr class="hrCustom">

                                                <input type="hidden" id="data_grid" name="data_grid">
                                                <input type="hidden" id="selected_id" name="selected_id">
											<div class="row">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                    <span class="span_label ">Staff<span class="asterisk">*</span></span>
                                                    <div class="form-group">
                                                        <select name="staff" id="staff" class="form-control parsley-validated" data-required="true"></select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                    <span class="span_label ">From Date<span class="asterisk">*</span></span>
                                                    <div class="form-group">
                                                        <input type="text" name="from_date" id="from_date" class="form-control parsley-validated"  data-required="true" readonly=""/>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                    <span class="span_label ">To Date<span class="asterisk">*</span></span>
                                                    <div class="form-group">
                                                        <input type="text" name="to_date" id="to_date" class="form-control parsley-validated"  data-required="true" readonly=""/>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                    <span class="span_label ">Type<span class="asterisk">*</span></span>
                                                    <div class="form-group">
                                                        <select name="type" id="type" class="form-control parsley-validated" data-required="true"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12 col-sm-12 col-12 ">
                                                    <button class="btn btn-primary saveButton">Save</button>
                                                    <a class="btn btn-default" id="cancelEdit">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="dtl_tbl show_form_add"  style="min-height: auto;" >
                                        <h3>Staff Leave Entries</h3>
										<hr class="hrCustom">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-12 calendar_iconless">
                                                <span class="span_label">Staff</span>
                                                <div class="form-group">
                                                    <select id="filter_staff" class="form-control">
                                                        <option value="">Select Staff</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-12 calendar_iconless">
                                                <span class="span_label">Month</span>
                                                <div class="form-group">
                                                    <input type="text" id="filter_date" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-6 col-12">
                                                <br>
                                                <div class="form-group">
                                                    <button class="btn btn-primary" onclick="get_scheduled_pooja_list()">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default add_row btn_map  plus_btn">New Leave Entry</button>
                                        <div class="table-responsive table_language" >
                                            <table class="table table-striped table-sm dataTable no-footer" id="leave_entry" table="leave_entry_log" action_url="<?php echo base_url() ?>service/Leave_data/get_leave_entries">
                                                <thead>
                                                    <tr class="bg-warning text-white ">
                                                        <th>ID</th>
                                                        <th>Staff</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>No of Days</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
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
    </section>
</section>
<?php $this->load->view('admin/scripts/leave_entry_script'); ?>