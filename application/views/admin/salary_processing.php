<link href="<?php echo base_url();?>inner_assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>inner_assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>inner_assets/js/parsley.js" type="text/javascript"></script>
<div class="col-12 col-xs-12 col-sm-8 col-md-8 col-lg-9 col-xl-10 NoPaddingLeft content_wrapper">
                    <div class="tab_nav">
                        <div class="tab_box ">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="white_card ">
                                    <div class="add_dtl" style="display: none;"> 
                                        <form data-validate="parsley" action="" method="post" class="add-edit">
                                                <h3 id="form_title_h2"><?php echo $this->lang->line('new_salary_processing'); ?></h3>
													   <hr class="hrCustom">
   
												<input type="hidden" id="data_grid" name="data_grid">
                                                <input type="hidden" id="selected_id" name="selected_id">
											<div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('year'); ?></span>
                                                    <div class="form-group">
                                                        <select name="year" id="year" class="form-control parsley-validated" data-required="true"></select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('month'); ?></span>
                                                    <div class="form-group">
                                                        <select name="month" id="month" class="form-control parsley-validated" data-required="true" autocomplete="off">
                                                            <option value="">Select Month</option>
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="NewSalary bg_new_form">

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th colspan='2'>
                                                                    <input type="hidden" name="count" id="count"/>
																	<input type="checkbox" class="form-data selectallchk" name="selectallchk" id="selectallchk" checked="checked" style="display:none" />
                                                                    <?php echo $this->lang->line('staff'); ?>
                                                                </th>
																<th><?php echo $this->lang->line('role'); ?></th>
                                                                <th><?php echo $this->lang->line('basic_salary'); ?></th>
                                                                <th><?php echo $this->lang->line('advances_paid'); ?></th>
                                                                <th><?php echo $this->lang->line('other_addition'); ?></th>
                                                                <th><?php echo $this->lang->line('leave_deduction'); ?></th>
                                                                <th><?php echo $this->lang->line('extra_allowance'); ?></th>
                                                                <th><?php echo $this->lang->line('extra_deduction'); ?></th>
                                                                <th><?php echo $this->lang->line('salary_payable'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamic_asset_register"></tbody>
                                                    </table>
                                            </div>
                                            <br>
                                            <div class="row ">
                                                <div class="col-md-12 col-sm-12 col-12 ">
                                                    <button class="btn btn-primary saveButton" id="processsave"><?php echo $this->lang->line('save'); ?></button>
                                                    <a class="btn btn-default" id="cancelEdit"><?php echo $this->lang->line('cancel'); ?></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="dtl_tbl show_form_add"  style="min-height: auto;" >
                                        <h6><?php echo $this->lang->line('processed_salary_details'); ?></h6>
                                        <hr class="hrCustom">
                                        <button type="button" class="btn btn-default add_row btn_map  plus_btn addBtnPosition"><?php echo $this->lang->line('process_salary'); ?></button>
                                        <div class="row filter">
                                            <div class="col-sm-2 col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('month');?></label>
                                                    <select class="form-control" name="month" id="month">
                                                        <option value="">Select Month</option>
                                                        <option value="1">January</option>
                                                        <option value="2">February</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">July</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2 col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('role');?></label>
                                                    <select class="form-control" name="role" id="role">
                                                        <option value=""><?php echo $this->lang->line('select'); ?>
                                                        </option>
                                                        <?php foreach($designation as $data){?>
                                                            <option value="<?php echo $data->role; ?>"><?php echo $data->role_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2 col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('staff');?></label>
                                                    <select class="form-control" name="staff_name" id="staff_name">
                                                        <option value=""><?php echo $this->lang->line('select'); ?>
                                                        </option>
                                                        <?php foreach($staffArr as $data){?>
                                                            <option value="<?php echo $data['name']; ?>"><?php echo $data['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div> 
                                             <div class="col-sm-2 col-12">
                                                <div class="form-group">
                                                    <label style="display:block;">&nbsp;</label>
                                                    <a href="<?php echo base_url(); ?>backoffice/salary-processing"><button type="button" class="btn btn-default add_row add_new_btn btn_add_call">
                                                        Reset
                                                    </button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive table_language ">
                                            <table class="table table-striped table-sm dataTable no-footer" id="salary_processing" table="salary_processing" action_url="<?php echo base_url() ?>service/Salary_data/processed_salaries">
                                                <thead>
                                                    <tr class="bg-warning text-white ">
                                                        <th>ID</th>
														<th><?php echo $this->lang->line('sl'); ?></th>
                                                        <th><?php echo $this->lang->line('staff'); ?></th>
														<th><?php echo $this->lang->line('role'); ?></th>
                                                        <th><?php echo $this->lang->line('salary_month'); ?></th>
                                                        <th><?php echo $this->lang->line('monthly_salary'); ?></th>
                                                        <th><?php echo $this->lang->line('total_addable'); ?></th>
                                                        <th><?php echo $this->lang->line('total_deductable'); ?></th>
                                                        <th><?php echo $this->lang->line('payable_salary'); ?></th>
                                                        <th><?php echo $this->lang->line('processed_on'); ?></th>
                                                        <th><?php echo $this->lang->line('status'); ?></th>
                                                        <th><?php echo $this->lang->line('action'); ?></th>
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
<?php $this->load->view('admin/scripts/salary_processing_script.php'); ?>
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
            <br><div id="other_details" class="table-responsive TblPay"></div>
            <br><div id="other_details1" class="table-responsive TblPay"></div>
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