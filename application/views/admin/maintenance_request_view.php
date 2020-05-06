<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6><?php echo $this->lang->line('manage_maintenance_service_requests');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('description');?></th>
                        <th><?php echo $this->lang->line('maintenance_type');?></th>
                        <th><?php echo $this->lang->line('centre');?></th>
                        <th><?php echo $this->lang->line('type');?></th>
                        <th><?php echo $this->lang->line('status');?></th>
                        <th><?php echo $this->lang->line('requested_date');?></th>
                        <th><?php echo $this->lang->line('allowed_amount');?></th>
                        <th  class="text-center" nowrap><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php $i=1; foreach($requestArr as $row){?>
                <tr>
                 <td><?php echo $i;?></td>
                 <td><?php echo $row['description'];?></td>
                 <td><?php echo $row['maintenanacetype_name'];?></td>
                 <td><?php echo $row['institute_name'];?></td>
                 <td><?php echo $row['type'];?></td>
                 <td>
                    <?php 
                            if ($row['approved_status']=="Requested") {
                                echo '<span class="inactivestatus">'.$this->lang->line('requested').'</span>';
                            }
                            else if($row['approved_status']=="Waiting for Approval") {
                                echo '<span class="paymentcompleted">'.$this->lang->line('waiting_for_approval').'</span>';
                            }
                            else if($row['approved_status']== "Approved") { 
                                echo '<span class="admitted">'.$this->lang->line('approved').'</span>';
                            }
                            else if($row['approved_status']== "Completed") { 
                                echo '<span class="batchchanged">'.$this->lang->line('completed').'</span>';
                            }
                            else if($row['approved_status']== "Reopen") 
                            { 
                                echo '<span class="registered">'.$this->lang->line('reopened').'</span>';
                            }
                          else if($row['approved_status']== "Declined")
                          {
                             echo '<span class="declined">'.$this->lang->line('declined').'</span>';
                          }
                                
                        ?>  
                    
                    </td>
                 <td><?php echo date('d/m/Y',strtotime($row['created_on']));?></td>
                    <td><?php echo numberformat($row['allowed_amount']);?></td>
                 <td nowrap>
                     
                     <button type="button" class="btn btn-default option_btn " onclick="show_request_data(<?php echo $row['service_id'];?>)" title="Click here to view the details" > <i class="fa fa-eye "></i></button>


                    <?php  if ($row['approved_status']=="Requested" ||  $row['approved_status']=="Reopen" || $row['approved_status']=="Approved") { ?>

                            <select name="status" class="form-control tableSelect c_status" onchange="change_status('<?php echo $row['service_id'];?>');" id="id_<?php echo $row['service_id'];?>">
                                <option>Select</option>
                                  <?php
                                if ($row['approved_status']=="Requested" || $row['approved_status']=="Reopen") { ?>
                                <option value="Approved" >Approve</option>
                                <option value="Waiting for Approval">Send for Approval</option>
                                <option value="Decline">Decline</option>
                               <?php } elseif( $row['approved_status']=="Approved") {?>
                                <option value="Completed">Work Completed</option>
                                 <?php } ?>
                            </select>
                        <?php } ?>
                    </td>


                </tr>
                <?php  $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<!--modal for request-->

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('send_for_approval');?></h4>
                <button type="button" class="close cancel" data-dismiss="modal">&times;</button>

            </div>
                 <form id="send_approval_form" type="post">
                 <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="id" id="id"/>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                       
                        
                       
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('amount');?><span class="req redbold">*</span></label>
                                <input class="form-control numberswithdecimal" type="text" name="total_amount" maxlength="12">
                                </div>
                        </div>
                            
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('comments');?><span class="req redbold">*</span></label>
                                <textarea class="form-control"  name="comments"  onkeypress="return addressValidation(event)" placeholder="Enter Comments..." ></textarea>


                            </div>
                        </div>
                      
                      
                    </div>

                   </div>
                     <div class="modal-footer">
                      <button  class="btn btn-success"><?php echo $this->lang->line('send');?></button>

                            <button class="btn btn-default cancel" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                     </div>
                </form>
        </div>

    </div>
</div>
<!--modal for completion-->

<div id="cModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('maintenance_service_completion');?></h4>
                <button type="button" class="close cancel" data-dismiss="modal">&times;</button>

            </div>
                 <form id="completion_form" type="post">
                 <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="id" id="complete_id"/>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />



                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('total_amount');?><span class="req redbold">*</span></label>
                                <input class="form-control numberswithdecimal" type="text" name="total_amount" maxlength="12">
                                </div>
                        </div>



                    </div>

                   </div>
                     <div class="modal-footer">
                      <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>

                            <button class="btn btn-default cancel" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                     </div>
                </form>
        </div>

    </div>
</div>


<!--show details-->
<div id="showModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('maintenance_service_request_details');?></h4>
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
                                <?php echo $this->lang->line('maintenance_type');?>
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
                            

                            <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('allowed_amount');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_allowed_amount"></span></label>
                                    </div>
                                 </div>
                                </th>

                                <th width="50%">
                                    <div class="media">
                                <?php echo $this->lang->line('requested_amount');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_requested_amount"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
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
                                    <div class="media">
                                <?php echo $this->lang->line('total_amount_taken');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_total_amount"></span></label>
                                    </div>
                                 </div>
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

<div id="declineModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('are_you_sure_to_decline_this_request?');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                 <form id="decline_form" type="post">
                 <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="id" id="decline_id"/>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('comments');?><span class="req redbold">*</span></label>
                                <textarea class="form-control"  name="comments"  ></textarea>

                            </div>
                        </div>


                    </div>

                   </div>
                     <div class="modal-footer">
                      <button  class="btn btn-success"><?php echo $this->lang->line('save');?></button>

                            <button class="btn btn-default cancel" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                     </div>
                </form>
        </div>

    </div>
</div>



<?php $this->load->view("admin/scripts/maintenance_request_view_script");?>
