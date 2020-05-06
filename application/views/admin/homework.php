<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('manage_homework'); ?></h6>
        <hr>
         <div class="row filter">
            
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('batch');?></label>
                    <select class="form-control" name="batch_id" id="filter_batch">
                        <option value=""><?php echo $this->lang->line('select'); ?>
                        </option>
                        <?php
                        foreach($batches as $row){ ?>
                        <option value="<?php echo $row['batch_id']; ?>"><?php echo $row['batch_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div> 
             <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label style="display:block;">&nbsp;</label>
                    <a href="<?php echo base_url(); ?>backoffice/homework"><button type="button" class="btn btn-default add_row add_new_btn btn_add_call">
                        Reset
                    </button></a>
                </div>
            </div>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_holiday_form')">
            <?php echo $this->lang->line('add_homework');?>
        </button>

        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('batch');?></th>
                        <th><?php echo $this->lang->line('title');?></th>
                        <th><?php echo $this->lang->line('description');?></th>
                        <th><?php echo $this->lang->line('date_of_submission');?></th>
                        <th><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php $i=1;foreach($details as $row){?>
                <tr>
                <td><?php echo $i;?></td>
                <td><?php $batch_name=$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));
                                                    
                echo $batch_name;?></td>
                
                 <td><?php echo $row['title'];?></td>
                 <td><?php echo $row['description'];?></td>
                 <td><?php echo date('d-m-Y',strtotime($row['date_of_submission']));?></td>
                 <td>
                     <button class="btn btn-default option_btn"  title="Edit" onclick="get_homework_data(<?php echo $row['id'];?>)">
                     <i class="fa fa-pencil "></i>
                     </button>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_homework_data(<?php echo $row['id'];?>)"><i class="fa fa-trash-o"></i>
                    </a>
                     <button class="btn btn-primary btn-sm btn_details_view chartBlockBtn" onclick="view(<?php echo $row['id'];?>,<?php echo $row['batch_id']; ?>)">Details</button>
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
                <h4 class="modal-title"><?php echo $this->lang->line('add_homework');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="add_homework_form">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('batch');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="batch_id" id="batch_mode_id">
                                    <option value=""><?php echo $this->lang->line('select'); ?>
                                    </option>
                                    <?php
                                    foreach($batches as $row){ ?>
                                    <option value="<?php echo $row['batch_id']; ?>"><?php echo $row['batch_name']; ?></option>
                                    <?php } ?>
                               </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('title');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control" name="title"  autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                               <textarea class="form-control" name="description" ></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('date_of_submission');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control calendarclass"  onkeypress="return ValDate(event)" autocomplete="off" name="date_of_submission">
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
                <h4 class="modal-title"><?php echo $this->lang->line('edit_homework');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <form id="edit_homework_form">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="edit_id" id="edit_id"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('batch');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="batch_id" id="edit_batch">
                                    <option value=""><?php echo $this->lang->line('select'); ?>
                                    </option>
                                    <?php
                                    foreach($batches as $row){ ?>
                                    <option value="<?php echo $row['batch_id']; ?>"><?php echo $row['batch_name']; ?></option>
                                    <?php } ?>
                               </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('title');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control" name="title"  autocomplete="off" id="edit_title">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>
                               <textarea class="form-control" name="description" id="edit_description"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('date_of_submission');?><span class="req redbold">*</span></label>
                                <input type="text" class="form-control calendarclass"  onkeypress="return ValDate(event)" autocomplete="off" name="date_of_submission" id="edit_date">
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
<div class="chartBlock" id="chartBlock">
    <div class="chartBlockWrapper">
        <button class="close_btn" >
            <i class="fa fa-arrow-right"></i>
        </button>
         <button class="backModalBtn" id="previous" style="display:none;">
            <i class="fa fa-arrow-left"></i>
        </button>
    <div class="scroller" id="loadalldatas"> 
        
        </div>
         
    </div>

</div>


<?php $this->load->view("admin/scripts/homework_script");?>
