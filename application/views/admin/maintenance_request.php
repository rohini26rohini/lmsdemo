<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6><?php echo $this->lang->line('manage_maintenance_service');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->

                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_form')">
                                   <?php echo $this->lang->line('add_new_maintenanace_service');?>
                                </button>


        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('centre');?></th>
                <th><?php echo $this->lang->line('type');?></th>
                <th><?php echo $this->lang->line('requested_date');?></th>
                <th><?php echo $this->lang->line('maintenance_service_type');?></th>
                <th><?php echo $this->lang->line('description');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th nowrap><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1; foreach($requestArr as $row){?>
                <tr>
                 <td><?php echo $i;?></td>
                
                 
                 <td><?php echo $row['institute_name'];?></td>
                 <td><?php echo $row['type'];?></td>
                 <td><?php echo date('d-m-Y',strtotime($row['created_on']));?></td>
                <td><?php echo $row['maintenanacetype_name'];?></td>
                 <td><?php echo $row['description'];?></td>
                 <td>
                    <?php 
                            if ($row['approved_status']=="Requested") {
                                echo '<span class="inactivestatus">Requested</span>';
                            }
                            else if($row['approved_status']=="Waiting for Approval") {
                                echo '<span class="paymentcompleted">Waiting for Approval</span>';
                            }
                            else if($row['approved_status']== "Approved") { 
                                echo '<span class="admitted">Approved</span>';
                            }
                            else if($row['approved_status']== "Completed") { 
                                echo '<span class="batchchanged">Completed</span>';
                            }
                            else if($row['approved_status']== "Reopen") 
                            { 
                                echo '<span class="registered">Re-opened</span>';
                            } else if($row['approved_status']== "Declined")
                            {
                                echo '<span class="declined">Declined</span>';
                            }

                                
                        ?>  
                    
                    </td>
                 <td nowrap>
                     <button type="button" class="btn btn-default option_btn " onclick="show_request_data(<?php echo $row['service_id'];?>)" title="Click here to view the details" > <i class="fa fa-eye "></i></button>
                    
                     <?php if($row['approved_status'] == "Requested" || $row['approved_status'] == "Reopen") {?>
                     <button class="btn btn-default option_btn " title="Edit" onclick="get_requestdata(<?php echo $row['service_id'];?>)">
                     <i class="fa fa-pencil "></i></button>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_requestdata(<?php echo $row['service_id'];?>)"><i class="fa fa-trash-o"></i>
                    </a>
                     <?php } elseif($row['approved_status'] == "Completed"){ ?>
                     <select name="status" class="form-control tableSelect c_status" onchange="change_status('<?php echo $row['service_id'];?>');" id="id_<?php echo $row['service_id'];?>">
                                <option>Select</option>
                                <option value="Reopen">Reopen</option>
                      </select>
                     <?php } ?>
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_maintenanace_service');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                 <form id="add_form" type="post">
                 <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label><?php echo $this->lang->line('group');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="group_name" id="group_name">
                                        <option value=""><?php echo $this->lang->line('select');?></option>
                                        <?php 
                                        foreach($groupArr as $row) {
                                            echo '<option value="'.$row['institute_master_id'].'">'.$row['institute_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label><?php echo $this->lang->line('branch');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="branch_name" id="branch_name">
                                        <option value=""><?php echo $this->lang->line('select');?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label><?php echo $this->lang->line('centre');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="center_name" id="center_name">
                                        <option value=""><?php echo $this->lang->line('select');?></option>
                                    </select>
                                </div>
                            </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="description" placeholder="Description" onkeypress="return addressValidation(event)"></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('maintenance_service_type');?><span class="req redbold">*</span></label>
                               <select class="form-control" name="maintenance_type">
                                   <option value=""><?php echo $this->lang->line('select');?></option>
                                   <?php
                                   foreach($typeArr as $row)
                                   {
                                   ?>
                                   <option value="<?php echo $row['id'];?>"><?php echo $row['type'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="type">
                                <option value=""><?php echo $this->lang->line('select');?></option>
                                <option value="<?php echo $this->lang->line('maintenance');?>"><?php echo $this->lang->line('maintenance');?></option>
                                <option value="<?php echo $this->lang->line('procurement');?>"><?php echo $this->lang->line('procurement');?></option>
                                </select>
                            </div>
                        </div>




                    </div>

            </div>
                     <div class="modal-footer">
                      <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>

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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_maintenance_service');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                <form id="edit_form" type="post">
                  <div class="modal-body">

                     <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                         <input type="hidden" name="id" id="edit_id"/>
                         
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label><?php echo $this->lang->line('group');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="group_name" id="edit_group_name">
                                        <option value=""><?php echo $this->lang->line('select');?></option>
                                        <?php 
                                        foreach($groupArr as $row) {
                                            echo '<option value="'.$row['institute_master_id'].'">'.$row['institute_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label><?php echo $this->lang->line('branch');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="branch_name" id="edit_branch_name">
                                        <option value=""><?php echo $this->lang->line('select');?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label><?php echo $this->lang->line('centre');?><span class="req redbold">*</span></label>
                                    <select class="form-control" name="center_name" id="edit_center_name">
                                        <option value=""><?php echo $this->lang->line('select');?></option>
                                    </select>
                                </div>
                            </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="description" placeholder="Description" onkeypress="return addressValidation(event)" id="edit_description"></div>
                        </div>
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('maintenance_service_type');?><span class="req redbold">*</span></label>
                               <select class="form-control" id="edit_mtype" name="maintenance_type">
                                   <option value=""><?php echo $this->lang->line('select');?></option>
                                   <?php
                                   foreach($typeArr as $row)
                                   {
                                   ?>
                                   <option value="<?php echo $row['id'];?>"><?php echo $row['type'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('type');?><span class="req redbold">*</span></label>
                                <select class="form-control" id="edit_type" name="type">
                                <option value=""><?php echo $this->lang->line('select');?></option>
                                <option value="<?php echo $this->lang->line('maintenance');?>"><?php echo $this->lang->line('maintenance');?></option>
                                <option value="<?php echo $this->lang->line('procurement');?>"><?php echo $this->lang->line('procurement');?></option>
                                </select>
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
<!--show details-->
<div id="showModal" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('maintenance_service_details');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills ">
                    <table class="table table_register_view ">
                        <tbody>
                            <tr>
                                <th  colspan="2" ><h6 id="coursedet_view"></h6>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('description');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_description"></span></label>
                                    </div>
                                 </div>
                                </th>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('maintenance_service_type');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_mtype"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('centre');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_centre"></span></label>
                                    </div>
                                 </div>

                                </th>
                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('type');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_type"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
                            <tr>
                                
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('requested_date');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_request_date"></span></label>
                                    </div>
                                 </div>
                                </th>
                                

                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('status');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_status"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
                           <!-- <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('requested_date');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_request_date"></span></label>
                                    </div>
                                 </div>
                                </th>

                                <th width="50%">
                                   <div class="media">
                                <?php echo $this->lang->line('approved_by');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_approved_by"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>-->
                            <!-- <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('date_of_approval');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_date_of_approval"></span></label>
                                    </div>
                                 </div>
                                </th>

                                <th width="50%">
                                   <div class="media">
                                <?php echo $this->lang->line('comments');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_comments"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>-->
                             <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('date_of_completion');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_date_of_completion"></span></label>
                                    </div>
                                 </div>
                                </th>

                                <th width="50%">

                                </th>
                            </tr>

                        </tbody>
                    </table>
                    <div style="width:100%" >
                        <h5>History</h5>
                            <div class="table-responsive table_language" >
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                           <?php echo $this->lang->line('sl_no');?>
                                        </th>
                                        <th>
                                           <?php echo $this->lang->line('date');?>
                                        </th>
                                        <th>
                                           <?php echo $this->lang->line('status');?>
                                        </th>
                                        <th>
                                           <?php echo $this->lang->line('comments');?>
                                        </th>
                                        <th>
                                           <?php echo $this->lang->line('authority');?>
                                        </th>
                                        <th>
                                           <?php echo $this->lang->line('user');?>
                                        </th>
                                    </tr>

                                </thead>
                                <tbody id="show_history">

                                </tbody>
                            </table>
                        </div>
                        </div>

                </ul>


            </div>
        </div>
    </div>
</div>
<!--reopen modal-->
<div id="reopenModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('send_for_approval');?></h4>
                <button type="button" class="close cancel" data-dismiss="modal">&times;</button>

            </div>
                 <form id="reopen_form" type="post">
                 <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="id" id="complete_id"/>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('comments');?><span class="req redbold">*</span></label>
                                <textarea class="form-control"  name="comments"  onkeypress="return addressValidation(event)" placeholder="Enter Comments..." ></textarea>


                            </div>
                        </div>


                    </div>

                   </div>
                     <div class="modal-footer">
                      <button  class="btn btn-success"><?php echo $this->lang->line('send');?></button>

                            <button class="btn btn-default cancel" data-dismiss="modal" ><?php echo $this->lang->line('cancel');?></button>

                     </div>
                </form>
        </div>

    </div>
</div>



<?php $this->load->view("admin/scripts/maintenance_request_script");?>
