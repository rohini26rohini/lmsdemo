<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6>Manage Holidays</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
         <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_holiday_form')">
                                   <?php echo $this->lang->line('add_holidays');?>
                                </button>
        
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('date');?></th>
                <th><?php echo $this->lang->line('description');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php $i=1;foreach($holidayArr as $day){?>
                <tr>
                    <td><?php echo $i;?></td>
                 <td><?php echo date('d/m/Y',strtotime($day['date']));?></td>
                 <td><?php echo $day['description'];?></td>

                 <td><button class="btn btn-default option_btn " title="Edit"  onclick="get_holidaydata(<?php echo $day['id'];?>)">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_holidaydata(<?php echo $day['id'];?>)"><i class="fa fa-trash-o"></i>
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_holidays');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="add_holiday_form">
            <div class="modal-body">  
                <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('date');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control calendarclass" name="date" onkeypress="return ValDate(event)" autocomplete="off">
                            </div>
                                </div>



                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" type="text" name="description" placeholder="Description" onkeypress="return valNames(event);"></textarea>
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
<!--edit modal-->
<div id="editModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_holidays');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
           
                <form id="edit_holiday_form">
                     <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('date');?><span class="req redbold">*</span></label>
                                <input type="hidden" id="id" name="id"/>
                                <input type="text" class="form-control calendarclass" name="date" onkeypress="return ValDate(event)" autocomplete="off" id="date">
                            </div>
                                </div>



                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                                <textarea class="form-control" type="text" name="description" placeholder="Description" onkeypress="return valNames(event);" id="description"></textarea>
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



<?php $this->load->view("admin/scripts/holidays_script");?>
