<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">

    <div class="white_card ">
        <h6>
            <?php echo $this->lang->line('manage_config_settings');?>
        </h6>
        <hr>
        <form id="add_config_settings" type="post">
            <div class="bg_form ">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="table-responsive table_language">
                    <table class="table  table-bordered table-striped table-sm">
                        <tbody id="dynamic_asset_register">
                        <tr>
                                <td>
                                    Company Registration Number
                                </td>
                                <td>
                                    <?php 
                                    $crn=$this->common->get_name_by_id('am_config','value',array("key"=>"company_registration"));
                                    ?>
                                    <input type="text" name="crn" class="form-control" required autocomplete="off" value="<?php if($crn !=""){ echo $crn; } ?>" onkeypress="return blockSpecialChar(event)">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    GST Code
                                </td>
                                <td>
                                    <?php 
                                    $gstc=$this->common->get_name_by_id('am_config','value',array("key"=>"company_gst_code"));
                                    ?>
                                    <input type="text" name="gstc" class="form-control" required autocomplete="off" value="<?php if($gstc !=""){ echo $gstc; } ?>" onkeypress="return blockSpecialChar(event)">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Registration Confirmation Received E-mail Id </td>
                                <td>
                                    <?php 
                                    $remail=$this->common->get_name_by_id('am_config','value',array("key"=>"register_mail"));
                                    ?>
                                    <input type="email" name="register_mail" class="form-control  " data-required="true" autocomplete="off" value="<?php if($remail !=""){ echo $remail; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Payment Confirmation Received E-mail Id
                                </td>
                                <td>
                                    <?php 
                                    $pemail=$this->common->get_name_by_id('am_config','value',array("key"=>"payment_mail"));
                                    ?>
                                    <input type="email" name="payment_mail" class="form-control  " data-required="true" autocomplete="off" value="<?php if($pemail !=""){ echo $pemail; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Request Callback Received E-mail Id
                                </td>
                                <td>
                                    <?php 
                                    $cemail=$this->common->get_name_by_id('am_config','value',array("key"=>"callback_mail"));
                                    ?>
                                    <input type="email" name="callback_mail" class="form-control  " data-required="true" autocomplete="off" value="<?php if($cemail !=""){ echo $cemail; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Batch/Center Notification E-mails [Enter separated by commas]
                                </td>
                                <td>
                                    <?php 
                                    $bcnotify=$this->common->get_name_by_id('am_config','value',array("key"=>"bcnotify"));
                                    ?>
                                    <input type="text" name="bcnotify" class="form-control  " data-required="true" autocomplete="off" value="<?php if($bcnotify !=""){ echo $bcnotify; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Batch/Center Notification SMS [Enter separated by commas]
                                </td>
                                <td>
                                    <?php 
                                    $bcnotifysms=$this->common->get_name_by_id('am_config','value',array("key"=>"bcnotifysms"));
                                    ?>
                                    <input type="text" name="bcnotifysms" class="form-control  " data-required="true" autocomplete="off" value="<?php if($bcnotifysms !=""){ echo $bcnotifysms; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Material upload faculty only
                                </td>
                                <td>
                                    <?php 
                                    $material_upload=$this->common->get_name_by_id('am_config','value',array("key"=>"material_upload"));
                                    ?>
                                    <input id="material_upload" type="checkbox" name="material_upload" <?php if($material_upload ==1){ echo 'checked="checked"'; } ?> value="1">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    CGST
                                </td>
                                <td>
                                    <?php 
                                    $gst=$this->common->get_name_by_id('am_config','value',array("key"=>"CGST"));
                                    ?>
                                    <input type="text" name="gst" class="form-control numberswithdecimal " data-required="true" autocomplete="off" value="<?php if($gst !=""){ echo $gst; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    SGST
                                </td>
                                <td>
                                    <?php 
                                    $sgst=$this->common->get_name_by_id('am_config','value',array("key"=>"SGST"));
                                    ?>
                                    <input type="text" name="sgst" class="form-control numberswithdecimal" data-required="true" autocomplete="off" value="<?php if($sgst !=""){ echo $sgst; } ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cess
                                </td>
                                <td>
                                    <?php 
                                    $cess=$this->common->get_name_by_id('am_config','value',array("key"=>"cess"));
                                    ?>
                                    <input id="cessdef" type="checkbox" name="cess" <?php if($cess ==1){ echo 'checked="checked"'; } ?> value="1">
                                </td>
                            </tr>
                           
                            <tr id="cesspercntge" <?php if($cess ==1){ } else { echo 'style="display:none"';} ?>>
                                <td>
                                    Cess %
                                </td>
                                <td>
                                    <?php 
                                    $cess_value=$this->common->get_name_by_id('am_config','value',array("key"=>"cess_value"));
                                    ?>
                                    <input type="text" name="cessvalue" class="form-control numberswithdecimal" required data-pattern-error="Please enter cess %."  data-required="true"  min="1" max="100" autocomplete="off" value="<?php if($cess_value !=""){ echo $cess_value; } ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 col-sm-12 col-12 ">
                    <button class="btn btn-info btn_save">Save</button>
                    <a href="<?php echo base_url();?>backoffice/config-settings" class="btn btn-default btn_cancel" id="cancelEdit">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>





<div class="modal fade modalCustom " id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('student_list'); ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_student_form" type="post">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">

                                <label style="display:block"><?php echo $this->lang->line('student');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="student_list" id="show_students" style='width: 100%;'>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="bbb" class="btn btn-success"><?php echo $this->lang->line('add');?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                </div>
            </form>
        </div>

    </div>
</div>


<?php $this->load->view("admin/scripts/config_settings_script");?>
