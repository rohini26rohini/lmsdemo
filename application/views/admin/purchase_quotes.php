<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>
            <?php echo $this->lang->line('manage_purchase_quotes') ;?>
        </h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_form')">
           <?php echo $this->lang->line('add_purchase_quote') ;?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">
                            <?php echo $this->lang->line('sl_no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('title');?>
                        </th>
                        <!-- <th><?php //echo $this->lang->line('type');?></th>-->

                        <th>
                            <?php echo $this->lang->line('status');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('action');?>
                        </th>
                    </tr>
                </thead>

                <?php $i=1; foreach($dataArr as $data){?>
                <tr>

                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $data['title'];?>
                    </td>
                    <!-- <td >
                        <?php //echo $data['type'];?>
                    </td>-->

                    <td>
                        <?php
                         
                       
                        if ($data['purchase_status']=="Draft") {
                                echo '<span class="inactivestatus">Draft</span>';
                            }
                            else if($data['purchase_status']=="Quote Approved") {
                                echo '<span class="admitted">Quote Approved</span>';
                            }
                            else if($data['purchase_status']== "Completed") { 
                                echo '<span class="batchchanged">Completed</span>';
                            }
                        
                       ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-default option_btn " onclick="view_data(<?php echo $data['id'];?>)" title="Click here to view the details">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_data(<?php echo $data['id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_quote(<?php echo $data['id'];?>)">
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

<!--edit  modal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('edit_purchase_quotes'); ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form enctype="multipart/form-data" id="edit_form" method="post">
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" id="edit_id" name="id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('title') ;?> <span class="req redbold">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Title" id="edit_title" /></div>
                        </div>
                        <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('type') ;?><span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="type">
                                <option value="">Select</option>
                                <option value="a">a</option>
                                <option value="b">b</option>
                                <option value="c">c</option>
                                </select>
                            </div>
                        </div>-->
                        <!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('upload_file') ;?><span class="req redbold">*</span></label>
                                <input type="file" class="form-control" id="file" name="file_name" onchange="readURL(this);">
                                <p>Upload .pdf,.docx files only  (Max Size:10MB).</p>
                            </div>
                        </div>-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm" id="edit_purchasequote_table">
                                    <thead>
                                        <tr>

                                            <th>
                                                <?php echo $this->lang->line('description');?><span class="req redbold">*</span>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('file_upload');?><span class="req redbold">*</span>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('action');?>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 show_purchase">
                            <div class="form-group"><label><?php echo $this->lang->line('purchase_order_no') ;?> <span class="req redbold">*</span></label>
                                <input type="text" name="purchase_order_no" class="form-control" placeholder="Purchase Order No" id="edit_orderno" /></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 show_purchase">
                            <div class="form-group"><label><?php echo $this->lang->line('amount') ;?> <span class="req redbold">*</span></label>
                                <input type="text" name="amount" class="form-control numberswithdecimal" placeholder="Amount" id="edit_amount" maxlength="12"/></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 show_purchase">
                            <div class="form-group"><label><?php echo $this->lang->line('date_of_purchase') ;?> <span class="req redbold">*</span></label>
                                <input type="text" name="date_of_purchase" class="form-control calendarclass" placeholder="Date of Purchase" id="edit_date" autocomplete="off" onkeypress="return ValDate(event)"/></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="add_moreDiv">
                            <button type="button" class="btn btn-info btn-sm btnNewAdd" onclick="addNewrow()"><i class="fa fa-plus"></i><?php echo $this->lang->line('add_more');?></button>
                        </div>


                    </div>


                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" type="submit"><?php echo $this->lang->line('save'); ?></button>
                    <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('add_purchase_quote') ;?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form enctype="multipart/form-data" id="add_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('title') ;?> <span class="req redbold">*</span></label>
                                <input type="text" name="title" class="title form-control" placeholder="Title" /></div>
                        </div>
                       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm" id="purchasequote_table">
                                    <thead>
                                        <tr>

                                            <th>
                                                <?php echo $this->lang->line('description');?><span class="req redbold">*</span>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('file_upload');?><span class="req redbold">*</span>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('action');?>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row_1">
                                            <td> 
                                                <div class="form-group form_zero"><input type="text" id="description[1]" class="description_validate form-control" placeholder="Description" name="description[]" /></div>
                                            </td>
                                            <td>
                                                <input type="file" class="file_validate form-control" id="file_name[1]" name="file_name[]" /><p>Upload .pdf,.docx files only  (Max Size:10MB).</p>
                                            </td>
                                            
                                            <td data-title="">
                                                <button  class="btn btn-danger option_btn" id="removeButton1" onclick="remove('1');" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i>
                                                </button>
                                            </td>
      
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <button type="button" class="btn btn-info btn-sm btnNewAdd" onclick="addNew()" ><i class="fa fa-plus"></i><?php echo $this->lang->line('add_more');?></button>
                        </div>


                    </div>


                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add_button"><?php echo $this->lang->line('save'); ?></button>
                    <a class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </form>
        </div>

    </div>
</div>
<!--show modal-->
<div id="showModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('purchase_quotes_details'); ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="status_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6> <?php echo $this->lang->line('title');?> :     <small id="show_title"></small> </h6>
                            <hr>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm" id="show_purchasequote_table">
                                    <thead>
                                        <tr>

                                            <th>
                                                <?php echo $this->lang->line('description');?>
                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('file_upload');?>

                                            </th>
                                            <th>
                                                <?php echo $this->lang->line('action');?>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>

    </div>
</div>
<?php $this->load->view("admin/scripts/purchase_quotes_script");?>
