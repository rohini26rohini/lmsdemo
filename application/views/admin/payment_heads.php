<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6><?php echo $this->lang->line('manage_payment_heads');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->

                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_form')">
                                   <?php echo $this->lang->line('add_new_payment_head');?>
                                </button>


        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('payment_heads');?></th>
                <th ><?php echo $this->lang->line('status'); ?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1; foreach($dataArr as $row){?>
                <tr>
                 <td><?php echo $i;?></td>
                 <td><?php echo $row['fee_head'];?></td>
                 <td><?php echo $row['status'];?></td>
                 <td>
                     <button class="btn btn-default option_btn " title="Edit" onclick="get_feedata(<?php echo $row['id'];?>)">
                     <i class="fa fa-pencil "></i></button>

                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_feedata(<?php echo $row['id'];?>)"><i class="fa fa-trash-o"></i>
                    </a>
                </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_payment_head');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                 <form id="add_form" type="post">
                 <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('payment_head');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="fee_head" placeholder="Allowed Amount" onkeypress="return addressValidation(event)">
                            </div>
                        </div>




                    </div>

            </div>
                     <div class="modal-footer">
                      <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save');?></button>

                            <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                     </div>
                </form>
        </div>

    </div>
</div>
<!--edit modal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_payment_head');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                <form id="edit_form" type="post">
                  <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="edit_id"/>
                       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('allowed_amount');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="allowed_amount" placeholder="Allowed Amount" onkeypress="return addressValidation(event)"  id="edit_amount">
                            </div>
                        </div>




                    </div>

            </div>
                                <div class="modal-footer">
                                                            <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
  <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                                </div>
     </form>
        </div>

    </div>
</div>



<?php $this->load->view("admin/scripts/payment_head_script");?>
