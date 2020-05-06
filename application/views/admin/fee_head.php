<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('fee_head');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_fee_head" onclick="clearmodal()">
            Add Fee Head
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('head');?></th>
						<th ><?php echo $this->lang->line('refund');?></th>
<!--						<th ><?php echo $this->lang->line('taxable');?></th>-->
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($fee_head as $head){ 
                ?>
                    <tr>
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $head->ph_head_name;?>
                        </td>
						<td>
                            <?php 
								if($head->ph_refund==1) {
									$ph_refund = 'Yes';
								} else {
									$ph_refund = 'No';
								}
								echo $ph_refund;?>
                        </td>
<!--
						<td>
                            <?php 
								if($head->ph_taxable==1) {
									$ph_taxable = 'Yes';
								} else {
									$ph_taxable = 'No';
								}
								echo $ph_taxable;?>
                        </td>
-->
                        <td>
                        <?php if($head->ph_status == 1) {?> 
                            <span class="btn mybutton  mybuttonActive" onclick="statusChange('<?php echo $head->ph_id;?>','<?php echo $head->ph_status; ?>')">Active</span>
                        <?php }else if($head->ph_status == 0){?>
                            <span class="btn mybutton mybuttonInactive" onclick="statusChange('<?php echo $head->ph_id;?>','<?php echo $head->ph_status; ?>')">Inactive</span>
                        <?php } ?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_feeHeaddata(<?php echo $head->ph_id;?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--add discount modal-->
<div id="add_fee_head" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Fee Head</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_fee_head_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('head');?> <span class="req redbold">*</span></label>
                                <input type="text" name="fee_head" class="form-control" placeholder="<?php echo $this->lang->line('head');?>" data-validate="required" onkeypress="return valNames(event);" autocomplete="off" id="fee_head"/>
                            </div>
                        </div>
						
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="refund" value="1"  id="refund">
							  <label class="form-check-label" for="gridCheck">
								<?php echo $this->lang->line('refund');?>
							  </label>
							</div>
                        </div>
						<!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="taxable" value="1" id="taxable">
							  <label class="form-check-label" for="gridCheck">
								<?php echo $this->lang->line('taxable');?>
							  </label>
							</div>
                        </div>-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!--edit discount modal-->
<div id="edit_fee_head" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Fee Head</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_fee_head_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="ph_id" id="ph_id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('head');?> <span class="req redbold">*</span></label>
                                <input type="text" name="fee_head" class="form-control" placeholder="<?php echo $this->lang->line('head');?>" data-validate="required" onkeypress="return valNames(event);" autocomplete="off" id="edit_head"/>
                            </div>
                        </div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="refund" value="1" id="refundedit">
							  <label class="form-check-label" for="gridCheck">
								<?php echo $this->lang->line('refund');?>
							  </label>
							</div>
                        </div>
						<!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="taxable" value="1" id="taxableedit">
							  <label class="form-check-label" for="gridCheck">
								<?php echo $this->lang->line('taxable');?>
							  </label>
							</div>
                        </div>-->
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/discount_script");?>
