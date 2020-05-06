<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6><?php echo $this->lang->line('manage_supportive_services') ?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
       
                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_service_form')">
                                   <?php echo $this->lang->line('add_new_supportive_service');?>
                                </button>

           
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('service_name');?></th>
                <th><?php echo $this->lang->line('contract_type');?></th>

                <th><?php echo $this->lang->line('contact_person');?></th>
                <th><?php echo $this->lang->line('mobile_no');?></th>
                <th><?php echo $this->lang->line('emailid');?></th>
                <th><?php echo $this->lang->line('document');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1;foreach($serviceArr as $service){?>
                <tr>
                    <td><?php echo $i;?></td>
                 <td><?php echo $service['description'];?></td>
                 <td><?php echo $service['type'];?></td>
                 <td><?php echo $service['contact_person'];?></td>
                 <td><?php echo $service['mobile_number'];?></td>
                 <td><?php echo $service['email_id'];?></td>
                 <td>
                    <?php if($service['file'] !="") {?>
                     <a target="_blank" class="btn mybutton btn_add_call " href="<?php echo base_url().$service['file'];?>">View document</a>
                    <?php } ?>
                 </td>
                 <td>
                     <button type="button" class="btn btn-default option_btn " onclick="view_servicedata(<?php echo $service['id'];?>)" title="Click here to view the details" >
                            <i class="fa fa-eye "></i>
                        </button>
                     <button class="btn btn-default option_btn " title="Edit" onclick="get_servicedata(<?php echo $service['id'];?>)">
                     <i class="fa fa-pencil "></i></button>

                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_servicedata(<?php echo $service['id'];?>)"><i class="fa fa-trash-o"></i>
                    </a></td>
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_new_supportive_service');?></h4>
                <button type="button" class="close" data-dismiss="modal"  >&times;</button>

            </div>
                 <form id="add_service_form" type="post" enctype="multipart/form-data">
                      <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                         
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('service_name');?><span class="req redbold">*</span></label>
                                   <input  type="text" name="description" class="form-control" onkeypress="return addressValidation(event)" placeholder="Service Name"/>
                                </div>
                        </div>
                       
                       
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('contract_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="type" >
                                        <option value=""><?php echo $this->lang->line('select_contract_type');?></option>
                                       <option value="Agreement"><?php echo $this->lang->line('agreement');?></option>
                                       <option value="Lease"><?php echo $this->lang->line('lease');?></option>
                                    </select>
                        </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('from');?><span class="req redbold">*</span></label>
                                    <input class="form-control start_date " type="text" name="date_from" id="start_date" placeholder="Date" autocomplete="off" onkeypress="return ValDate(event)">
                                </div>
                        </div>
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('to');?><span class="req redbold">*</span></label>
                                    <input class="form-control end_date " type="text" name="date_to" id="end_date" placeholder="Date" autocomplete="off" onkeypress="return ValDate(event)">
                                </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label style="display:block"><?php echo $this->lang->line('alert_required');?><span class="req redbold">*</span></label>
                                
                            <div class="form-check-inline">
                              <label class="form-check-label">
                                 <input type="radio" name="alert" value="1" class="form-group"/>
                                    <?php echo $this->lang->line('yes');?>
                              </label>
                            </div>
                            <div class="form-check-inline">
                              <label class="form-check-label">
                                <input type="radio" name="alert" value="0" class="form-group" />
                                            <?php echo $this->lang->line('no');?>
                              </label>
                            </div>
                              
                               
                                </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('contact_person');?><span class="req redbold">*</span></label>
                                <input class="form-control " type="text" name="contact_person" placeholder="Contact Person" onkeypress="return valNames(event);" ></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('mobile_no');?><span class="req redbold">*</span></label>
                                <input class="form-control numbersOnly" type="text" name="mobile_number" placeholder="Mobile Number"  maxlength="12">
                            </div>
                        </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('emailid');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="email" name="email" placeholder="Email Id" >
                            </div>
                        </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('file_upload');?><!--<span class="req redbold">*</span>--></label>
                                <input class="form-control" type="file" name="file_name" >
                                <label>Upload jpg,jpeg,png,bmp,pdf,doc,docx files only  (Max Size:10MB).</label>
                            </div>
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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_supportive_service');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="edit_service_form" type="post">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="id"/>
                         
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('service_name');?><span class="req redbold">*</span></label>
                                  <!-- <textarea name="description" id="edit_title" class="form-control" onkeypress="return addressValidation(event)"></textarea>-->
                                <input  type="text" name="description" class="form-control" id="edit_title" onkeypress="return addressValidation(event)" placeholder="Service Name"/>
                                </div>
                        </div>
                       
                       
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('contract_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="type" id="edit_type">
                                        <option value=""><?php echo $this->lang->line('select_contract_type');?></option>
                                       <option value="Agreement"><?php echo $this->lang->line('agreement');?></option>
                                       <option value="Lease"><?php echo $this->lang->line('lease');?></option>
                                    </select>
                        </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('from');?><span class="req redbold">*</span></label>
                                    <input class="form-control start_date" type="text" name="from" id="edit_start_date" placeholder="Date" autocomplete="off" onkeypress="return ValDate(event)"/>
                                </div>
                        </div>
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('to');?><span class="req redbold">*</span></label>
                                    <input class="form-control end_date " type="text" name="to" id="edit_end_date" placeholder="Date" autocomplete="off" onkeypress="return ValDate(event)" />
                                </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label style="display:block"><?php echo $this->lang->line('alert_required');?><span class="req redbold">*</span></label>
                                
                            <div class="form-check-inline">
                              <label class="form-check-label">
                                 <input type="radio" name="alert" value="1" class="form-group " id="alert_yes"/>
                                    <?php echo $this->lang->line('yes');?>
                              </label>
                            </div>
                            <div class="form-check-inline">
                              <label class="form-check-label">
                                <input type="radio" name="alert" value="0" class="form-group " id="alert_no"/>
                                            <?php echo $this->lang->line('no');?>
                              </label>
                            </div>
                              
                               
                                </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('contact_person');?><span class="req redbold">*</span></label>
                                <input class="form-control " type="text" name="contact_person" placeholder="Contact Person" onkeypress="return valNames(event);" id="edit_contact_person"/></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('mobile_no');?><span class="req redbold">*</span></label>
                                <input class="form-control numbersOnly" type="text" name="mobile_number" placeholder="Mobile Number" maxlength="12" id="edit_mobile"/>
                            </div>
                        </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('emailid');?><span class="req redbold">*</span></label>
                                <input class="form-control" type="email" name="email" placeholder="Email Id" id="edit_email"/>
                            </div>
                        </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('file_upload');?><!--<span class="req redbold">*</span>--></label>
                                <input class="form-control" type="file" name="file_name">
                                 <label>Upload jpg,jpeg,png,bmp,pdf,doc,docx files only  (Max Size:10MB).</label>
                                <span id="edit_file"></span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                    <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
                   <button class="btn btn-default" data-dismiss="modal">
                    <?php echo $this->lang->line('cancel');?></button>
            </div>
     </form>
        </div>

    </div>
</div>
<!--show details-->
<div id="show" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('supportive_service_details');?></h4>
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
                               <?php echo $this->lang->line('service_name');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_title"></span></label>
                                    </div>
                                 </div>
                                </th>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('contract_type');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_type"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('contact_person');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_name"></span></label>
                                    </div>
                                 </div>

                                </th>
                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('mobile_no');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_number"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('emailid');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_email"></span></label>
                                    </div>
                                 </div>
                                                      </th>

                                <th width="50%">
                                <div class="media">
                               <?php echo $this->lang->line('alert_required');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_alert"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('from');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_from"></span></label>
                                    </div>
                                 </div>
                                </th>

                                <th width="50%">
                                   <div class="media">
                                <?php echo $this->lang->line('to');?>
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="show_to"></span></label>
                                    </div>
                                 </div>
                                </th>
                            </tr>

                        </tbody>
                    </table>


                </ul>


            </div>
        </div>
    </div>
</div>



<?php $this->load->view("admin/scripts/supportive_service_script");?>
