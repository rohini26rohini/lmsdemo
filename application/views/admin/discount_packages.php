<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Discount Packages</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_discount_packages" onclick="formclear('add_discount_packages_form')">
            Add Discount Packages
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('category');?></th>
                        <th ><?php echo $this->lang->line('package_type');?></th>
                        <th ><?php echo $this->lang->line('amount');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($discounts as $discount){ 
                ?>
                    <tr id="row_<?php echo $discount['package_id'];?>">
                        <td >
                            <?php echo $i;?>
                        </td>
                        <td id="name_<?php echo $discount['package_id'];?>">
                            <?php echo $discount['package_name'];?>
                        </td>
                        <td id="type_<?php echo $discount['package_id'];?>">
                            <?php if($discount['package_type']==1){ echo "Absolute";}else{ echo "Percentage";}?>
                        </td>
                        <td id="discount_<?php echo $discount['package_id'];?>">
                            <?php if($discount['package_type']==1) { echo numberformat($discount['package_amount']);} else { echo $discount['package_amount'].'%'; }?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_discount_packagesdata(<?php echo $discount['package_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_discount_packages(<?php echo $discount['package_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
    <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--add discount package modal-->
<div id="add_discount_packages" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Discount Packages</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_discount_packages_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="package_master_id" id="package_master_id">
                                    <option value="">Select Discount Category</option>
                                    <?php foreach($discountArr as $dis){
                                        $selected = '';
                                        if($discountArr['package_master_id'] == $dis['package_master_id']){
                                            $selected = 'selected="selected"';
                                        }
                                        echo '<option value="'.$dis['package_master_id'].'" '.$selected.'>'.$dis['package_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('package_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="package_type" id="package_type">
                                    <option value="">Select Package Type</option>
                                    <option value="1">Absolute</option>
                                    <option value="2">Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('discount_amount');?><span class="req redbold">*</span></label>
                                <input type="text" name="package_amount" class="form-control numberswithdecimal" maxlength="5" id="discount_amount" placeholder="<?php echo $this->lang->line('amount');?>" autocomplete="off"/>
                            </div>
                            <span class="req redbold" id="discount_amount_msg"></span>

                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <input type="text" name="package_desc" class="form-control" placeholder="<?php echo $this->lang->line('description');?>" autocomplete="off"/>
                            </div>
                        </div>
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

<!--edit discount package modal-->
<div id="edit_discount_packages" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Discount Packages</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_discount_packages_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="package_id" id="edit_package_id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('category');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="package_master_id" id="edit_package_master_id">
                                    <option value="">Select Discount Category</option>
                                    <?php foreach($discountArr as $dis){
                                        $selected = '';
                                        if($discountArr['package_master_id'] == $dis['package_master_id']){
                                            $selected = 'selected="selected"';
                                        }
                                        echo '<option value="'.$dis['package_master_id'].'" '.$selected.'>'.$dis['package_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('package_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="package_type" id="edit_package_type">
                                    <option value="">Select Package Type</option>
                                    <option value="1">Absolute</option>
                                    <option value="2">Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('discount_amount');?><span class="req redbold">*</span></label>
                                <input type="text" name="package_amount" id="edit_package_amount"  class="form-control numberswithdecimal" placeholder="<?php echo $this->lang->line('discount');?>" autocomplete="off"/>
                            </div>
                            <span class="req redbold" id="edit_discount_amount_msg"></span>

                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <input type="text" name="package_desc" id="edit_package_desc" class="form-control" placeholder="<?php echo $this->lang->line('description');?>" autocomplete="off"/>
                            </div>
                        </div>
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
