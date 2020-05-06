<link href="<?php echo base_url();?>inner_assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>inner_assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>inner_assets/js/parsley.js" type="text/javascript"></script>

<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 "><div class="white_card ">
                    <div class="tab_nav">
                        <div class="tab_box ">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="add_dtl " style="display: none;">
                                        <form data-validate="parsley" action="" method="post" class="add-edit">
                                                    <h6 id="form_title_h2"><?php echo $this->lang->line('new_leave_scheme'); ?></h6>
													<hr class="hrCustom">
                                                <input type="hidden" id="data_grid" name="data_grid">
                                                <input type="hidden" id="selected_id" name="selected_id">
											<div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('scheme_name'); ?><span class="asterisk">*</span></span>
                                                    <div class="form-group">
                                                        <input type="text" name="name" id="name" class=" form-control parsley-validated" data-required="true"/>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('from_date'); ?><span class="asterisk">*</span></span>
                                                    <div class="form-group calendar_iconless">
                                                        <input type="text" name="from_date" id="from_date" class="form-control parsley-validated" data-required="true" readonly=""/>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <span class="span_label "><?php echo $this->lang->line('to_date'); ?><span class="asterisk">*</span></span>
                                                    <div class="form-group calendar_iconless">
                                                        <input type="text" name="to_date" id="to_date" class="form-control parsley-validated" data-required="true" readonly=""/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg_form ">
                                         
													<div class="table-responsive table_language">
                                                    <table class="table  table-bordered table-striped table-sm" >
                                                        <thead>
                                                            <tr>
                                                                <th><input type="hidden" name="count" id="count"/><?php echo $this->lang->line('leave_head'); ?></th>
                                                                <th><?php echo $this->lang->line('total_leave'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamic_asset_register"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row ">
                                                <div class="col-md-12 col-sm-12 col-12 ">
                                                    <button class="btn btn-info btn_save"><?php echo $this->lang->line('save'); ?></button>
                                                    <a class="btn btn-default btn_cancel" id="cancelEdit"><?php echo $this->lang->line('cancel'); ?></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="dtl_tbl show_form_add"  style="min-height: auto;" >
                                                <h6><?php echo $this->lang->line('leave_scheme_details'); ?></h6>
														<hr class="hrCustom">
                                                <button type="button" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition plus_btn"><?php echo $this->lang->line('new_leave_scheme'); ?></button>

                                        <div class="table-responsive table_language" >
                                            <table class="table table-striped table-sm dataTable no-footer" id="leave_schemes" table="leave_schemes" action_url="<?php echo base_url() ?>service/Leave_data/leave_schemes_details">
                                                <thead>
                                                    <tr class="bg-warning text-white ">
                                                        <th>ID</th>
                                                        <th><?php echo $this->lang->line('leave_scheme'); ?></th>
                                                        <th><?php echo $this->lang->line('from'); ?></th>
                                                        <th><?php echo $this->lang->line('to'); ?></th>
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
  


<?php $this->load->view('admin/scripts/leave_scheme_script.php'); ?>
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