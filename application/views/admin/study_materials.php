<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('study_materials'); ?></h6>
        <hr>
        <div class="row filter">
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('batch');?></label>
                    <select class="form-control" name="batch_id" id="filter_batch">
                        <option value=""><?php echo $this->lang->line('select'); ?>
                        </option>
                        <?php
                        foreach($learningModule as $row){ ?>
                        <option value="<?php echo $row->batch_id; ?>"><?php echo $row->batch_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div> 
             <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label style="display:block;">&nbsp;</label>
                    <a href="<?php echo base_url(); ?>study-materials"><button type="button" class="btn btn-default add_row add_new_btn btn_add_call">
                        Reset
                    </button></a>
                </div>
            </div>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th class="text-left">Module</th>
                        <th class="text-left">Batch</th>
                        <th class="text-left">Learning Module</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // show($learningModule);
                        if(!empty($learningModule)) {
                            foreach($learningModule as $Module){ //echo '<pre>';print_r($section);
                        ?>
                    <tr>
                        <td><?php echo date('d-M-Y', strtotime($Module->schedule_date));?></td>
                        <td><?php echo date('g:i a', strtotime($Module->schedule_start_time)).' - '.date('g:i a', strtotime($Module->schedule_end_time));?></td>
                        <td class="text-left"><?php echo $Module->subject_name;?></td>
                        <td class="text-left"><?php echo $Module->batch_name?></td>
                        <td class="text-left">
                            <a onclick="downloadLearningModule(<?php echo $Module->learning_module_id; ?>)" class="btn btn-info btn_save" target="_blank">
                            <i class="fa fa-download text-right"></i><?php echo " ". $this->common->get_name_by_id('am_learning_module','learning_module_name',array('id'=>$Module->learning_module_id));?>
                                
                            </a>
                            <!-- href="<?php echo base_url();?>backoffice/faculty-learning-module/<?php //echo $Module->learning_module_id; ?>"<button type="submit" class="btn btn-info btn_save pull-right" id="download_pdf" style="margin-top:40px;">Download ID card</button> -->
                            <?php //echo $this->common->get_name_by_id('am_learning_module','learning_module_name',array('id'=>$Module->learning_module_id));?>
                        </td>
                        <!-- <td><span class="dwdicon"><i class="fa fa-download text-right"></i></span></td> -->
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<?php $this->load->view("admin/scripts/study_materials_script");?>
