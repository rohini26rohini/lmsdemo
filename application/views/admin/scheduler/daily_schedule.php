<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
         <h6><?php echo $this->lang->line('manage_daily_schedule'); ?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="col-sm-4 col-12">
                    <div class="form-group">
                        <label>Select Date</label>
                        <input type="text" class="form-control calendarclass" name="check_out" id="search_data" autocomplete="off" value="<?php echo date('d-m-Y');?>">
                    </div>
                </div>
        
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="schedule_datatable" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('Schedule_type');?></th>
                <th><?php echo $this->lang->line('start_time');?></th>
                <th><?php echo $this->lang->line('end_time');?></th>
                <th><?php echo $this->lang->line('course');?></th>
                <th><?php echo $this->lang->line('batch');?></th>
                <th><?php echo $this->lang->line('module');?></th>
                <th>faculty / Exam</th>
                <th><?php echo $this->lang->line('class_room');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php 
              
                $i=1;
                foreach($details as $row)
                {
                   if($row['schedule_type'] == "1")
                                { 
                                 $schedule_type="Exam";
                       
                       
                                } 
                                else
                                {
                                  $schedule_type= "Class";
                                  
                                } 
                    $course_name=$this->common->get_name_by_id("am_classes","class_name",array("class_id"=>$row['course_master_id']));
                
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $schedule_type;?>  </td>
                    <td><?php echo date('h:i A',strtotime($row['schedule_start_time']) );?></td>
                    <td><?php echo date('h:i A',strtotime($row['schedule_end_time']) );?></td>
                    <td><?php echo $course_name; ?></td>
                    <td><?php echo $row['batch_name'];?></td>
                    <td><?php if(isset($row['module'])){ echo $row['module'];}?></td>
                    <td><?php echo $row['name'] ;?></td>
                    <td><?php echo $row['classroom_name'] ;?></td>
                    <td>
                        <?php if ($row['class_taken'] == 0){?>
                        <span class="btn mybutton  mybuttonInactive" onclick="change_status(<?php echo $row['schedule_id'];?>,<?php echo $row['class_taken'];?>);"><?php echo $this->lang->line('pending'); ?></span>
                    <?php } else {?>
                        <span class="btn mybutton  mybuttonActive" onclick="change_status(<?php echo $row['schedule_id'];?>,<?php echo $row['class_taken'];?>);"><?php echo $this->lang->line('finished'); ?></span>
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



<?php $this->load->view("admin/scripts/daily_schedule_script");?>
