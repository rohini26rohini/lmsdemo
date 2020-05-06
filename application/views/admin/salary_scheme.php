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

                                                    <h6 id="form_title_h2"><?php echo $this->lang->line('new_salary_scheme'); ?></h6>
<hr class="hrCustom">
                                                <input type="hidden" id="data_grid" name="data_grid">
                                                <input type="hidden" id="selected_id" name="selected_id">
											<div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <div class="form-group">
                                                    <label><?php echo $this->lang->line('scheme_name'); ?> <span class="asterisk">*</span></label>
                                                    
                                                        <input type="text"  name="name" id="name" class=" form-control parsley-validated" data-required="true"/>
                                                    </div>
                                                </div>
<!--
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('from_date'); ?> <span class="asterisk">*</span></span>
                                                    <div class="form-group calendar_iconless">
                                                        <input type="text" name="from_date" id="from_date" class="form-control parsley-validated" data-required="true" readonly=""/>
                                                    </div>
                                                </div>

-->
                                                     <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line('from_date'); ?></label>
                                                            <input type="text" class="form-control calendarclass parsley-validated" name="from_date" data-required="true" />
                                                        </div>
                                                        </div>                                               
<!--
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('to_date'); ?> <span class="asterisk">*</span></span>
                                                    <div class="form-group calendar_iconless">
                                                        <input type="text" name="to_date" id="to_date" class="form-control parsley-validated" data-required="true" readonly=""/>
                                                    </div>
                                                </div>
-->
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('to_date'); ?> </label>
                                                        <input type="text" class="form-control calendarclass parsley-validated" data-required="true"  name="to_date"  />
                                                    </div>
                                                </div>                                                
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                             <div class="form-group calendar_iconless">
                                                    <label><?php echo $this->lang->line('type'); ?> <span class="asterisk">*</span></label>
                                   
                                                        <select name="schemetype" id="schemetype" class="form-control parsley-validated" data-required="true">
                                                            <option value="">Select</option>
                                                            <option value="Monthly">Monthly</option>
                                                           <!-- <option value="Hourly">Hourly</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive NewSalary">
                                                    <table class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <input type="hidden" name="count" id="count"/>
                                                                    <?php echo $this->lang->line('salary_head'); ?>
                                                                </th>
                                                                <th><?php echo $this->lang->line('type'); ?></th>
                                                                <th><?php echo $this->lang->line('amount'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamic_asset_register"></tbody>
                                                    </table>
                                            </div>
                                            <br>
                                            <div class="row ">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('total_amount'); ?><span class="asterisk">*</span></span>
                                                    <div class="form-group">
                                                        <input type="number" name="total_amount" id="total_amount" min="1" class="form-control parsley-validated" readonly data-required="true" autocomplete="off">
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
                                    <div class="dtl_tbl show_form_add"  style="min-height: auto;" >
                                                 <h6><?php echo $this->lang->line('salary_scheme_details'); ?></h6>
												<hr class="hrCustom">
                                                   <button type="button" class="btn btn-default add_row btn_map  plus_btn addBtnPosition"><?php echo $this->lang->line('new_salary_scheme'); ?></button>

                                        <div class="table-responsive table_language" >
                                            <table class="table table-striped table-sm dataTable no-footer" id="salary_schemes" table="salary_schemes" action_url="<?php echo base_url() ?>service/Salary_data/salary_scheme_details">
                                                <thead>
                                                    <tr class="bg-warning text-white ">
                                                        <th>ID</th>
                                                        <th><?php echo $this->lang->line('salary_scheme'); ?></th>
                                                        <th><?php echo $this->lang->line('from'); ?></th>
                                                        <th><?php echo $this->lang->line('to'); ?></th>
                                                        <th><?php echo $this->lang->line('amount(₹)'); ?></th>
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
<?php $this->load->view("admin/scripts/salary_scheme_script");?>
<div class="modal fade ModelCustom" id="viewModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title" id="viewModalTitle">View Salary Scheme</h4>
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