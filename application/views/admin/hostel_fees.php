<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>
            <?php echo $this->lang->line('manage_hostel_fees');?>
        </h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#addEditHostelFeeModal" onclick="formclear('add_edit_hostel_fees')">
            <?php echo $this->lang->line('add_hostel_fee');?>
        </button>
       
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table class="table table-striped table-sm" style="width:100%" id="institute_data">
                    <thead>
                        <tr>
                            <th width="50"><?php echo $this->lang->line('sl_no');?></th>

                            <th>
                                <?php echo $this->lang->line('room_type');?>
                            </th>
                            <th>
                                <?php echo $this->lang->line('mess_type');?>
                            </th>
                            <th>
                                <?php echo $this->lang->line('fees')." (".CURRENCY.")";?>
                            </th>
                            <th>
                                <?php echo $this->lang->line('action');?>
                            </th>
                        </tr>
                    </thead>
                        <?php 
                        $i=1;
                        foreach($datas as $data)
                        {
                        ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php echo $data['room_type'];?>
                        </td>
                        <td>
                             <?php if ($data['mess_type'] == "veg"){ echo $this->lang->line('veg');} ?>
                             <?php if ($data['mess_type'] == "nonveg"){ echo $this->lang->line('nonveg');} ?>
                             <?php if ($data['mess_type'] == "na"){ echo 'NA';} ?>
                        </td>
                        <td>
                            <?php echo $data['fees'];?>
                            
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="View" onclick="view_feedata(<?php echo $data['hostel_fee_id'];?>)">
                                <i class="fa fa-eye "></i>
                            </button>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_feedata(<?php echo $data['hostel_fee_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_hostelfee(<?php echo $data['hostel_fee_id'];?>)"><i class="fa fa-trash-o"></i>
                    </a>
                        
                        </td>
                    </tr>
                    <?php $i++; } ?>
                </table>
               
            </div>
       
        <!-- Data Table Plugin Section Starts Here -->
    </div>
    
</div>
<div id="addEditHostelFeeModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_hostel_fee');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_edit_hostel_fees" type="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <input type="hidden" id="hostel_fee_id" name="hostel_fee_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Room type<span class="req redbold">*</span></label>
                                <select class="roomtype form-control" name="room_type" id="room_type" required>
                                    <option  value=""><?php echo $this->lang->line('select_roomtype');?></option>
                                    <?php if(!empty($roomTypeArr)){ foreach($roomTypeArr as $row){  ?>
                                    <option value="<?php echo $row['roomtype_id']; ?>"><?php echo $row['room_type']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mess type<span class="req redbold">*</span></label>
                                <select class="messtype form-control" name="mess_type" id="mess_type" required>
                                    <option value=""><?php echo $this->lang->line('select_messtype');?></option>
                                    <option  value="veg"><?php echo $this->lang->line('veg');?></option>
                                    <option value="nonveg"><?php echo $this->lang->line('nonveg');?></option> 
                                    <option value="na">NA</option> 
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fee definition for one time<span class="req redbold">*</span></label>
                                <select class="fee_definition form-control" name="fee_def" id="fee_def" required>
                                    <option value="">Select a fee definition</option>
                                    <?php if(!empty($fee_def)){ foreach($fee_def as $row){  ?>
                                    <option value="<?php echo $row['fee_definition_id']; ?>"><?php echo $row['fee_definition']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>     
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Monthly fee<span class="req redbold">*</span></label>
                                <input onkeypress="return decimalNum(event)" type="text" placeholder="Fees" class="fees form-control" name="fees" id="fees" value=""/>
                            </div>
                        </div>     
                    </div>
                    <div class="row" id="fee_heads"></div>
                    <div class="row col-sm-12" id="fee_heads_errors"></div>
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="viewHostelFees" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Hostel Fees</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row" id="view_hostel_fees"></div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_hostel_fee');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                 <form id="add_hostel_fees" type="post">
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                 <div class="modal-body">

                    <div class="row">
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                        <table class="table table-striped table-sm" id="hostelfee_table">
                         <thead>
                        <tr>
                           
                            <th>
                                <?php echo $this->lang->line('room_type');?><span class="req redbold">*</span>
                            </th>
                            <th>
                                <?php echo $this->lang->line('mess_type');?><span class="req redbold">*</span>
                            </th>
                            <th>
                                <?php echo $this->lang->line('fees');?><span class="req redbold">*</span>
                            </th>
                            <th>
                               
                            </th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            <tr id="row_1">
                                <td> 
                                    <div class="form-group form_zero">
                                        <select class="roomtype form-control" name="room-type[1]" id="room-type_1" required>
                                            <option  value=""><?php echo $this->lang->line('select_roomtype');?>
                                            </option><?php if(!empty($roomTypeArr)){ foreach($roomTypeArr as $row){  ?>
                                            <option value="<?php echo $row['roomtype_id']; ?>"><?php echo $row['room_type']; ?></option><?php } } ?>
                                        </select>
                                    </div>
                                </td>
                                    <td> 
                                        <div class="form-group form_zero">
                                            <select class="messtype form-control" name="mess-type[1]" id="mess-type_1" required>
                                                <option value=""><?php echo $this->lang->line('select_messtype');?></option>
                                                <option  value="veg"><?php echo $this->lang->line('veg');?></option>
                                                <option value="nonveg"><?php echo $this->lang->line('nonveg');?></option> 
                                            </select>
                                        </div>
                                </td>
                                    <td> 
                                        <input type="text" placeholder="Fees" class="fees form-control" name="fees[1]" id="fees_'1"  value="" required/>
                                </td>
                                    <td data-title=""><button  class="btn btn-danger option_btn" id="removeButton1" onclick="remove('1');" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button>
                                </td>
                                </tr>
                        </tbody>
                        </table></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <button type="button" class="btn btn-info btn-sm btnNewAdd" onclick="addNew()"><i class="fa fa-plus"></i><?php echo $this->lang->line('add_more');?></button>
                        </div>


                    </div>

                 </div>
                 <div class="modal-footer">
                  <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_hostel_fee');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                 <form id="edit_hostel_fees" type="post">
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                     <input type="hidden" name="id" id="edit_id"/>
                 <div class="modal-body">

                    <div class="row">
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                        <table class="table table-striped table-sm">
                         <thead>
                        <tr>
                           
                            <th>
                                <?php echo $this->lang->line('room_type');?><span class="req redbold">*</span>
                            </th>
                            <th>
                                <?php echo $this->lang->line('mess_type');?><span class="req redbold">*</span>
                            </th>
                            <th>
                                <?php echo $this->lang->line('fees');?><span class="req redbold">*</span>
                            </th>
                            <th>
                               
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                               <td> 
                                   <div class="form-group form_zero">
                                   <select class="form-control" name="room_type" id="edit_roomtype">
                                       <option  value=""><?php echo $this->lang->line('select_roomtype');?></option>
                                       <?php if(!empty($roomTypeArr)){ foreach($roomTypeArr as $row){  ?><option value="<?php echo $row['roomtype_id']; ?>"><?php echo $row['room_type']; ?></option>
                                       <?php } } ?>
                                   </select>
                                   </div>
                                </td>
                                <td> 
                                    <div class="form-group form_zero">
                                        <select class="form-control" name="messtype" id="edit_messtype">
                                            <option value=""><?php echo $this->lang->line('select_messtype');?></option>
                                            <option  value="veg"><?php echo $this->lang->line('veg');?></option>
                                            <option value="nonveg"><?php echo $this->lang->line('nonveg');?></option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" placeholder="Fees" class=" form-control numberswithdecimal" name="fees" id="edit_fees"  value="" />
                                </td>
                            
                            </tr>
                        </tbody>
                        </table></div>
                        </div>
                        

                    </div>

                 </div>
                 <div class="modal-footer">
                  <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                 </div>
                </form>
        </div>

    </div>
</div>



<?php $this->load->view("admin/scripts/hostel_fees_script");?>
