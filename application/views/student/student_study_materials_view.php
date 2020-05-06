<h3>Learning Modules</h3>
<hr class="hrCustom">
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="Dboard">
            <div class="table-responsive">
                <table class="table table-bordered table-sm ExaminationList">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th class="text-left">Module</th>
                            <th class="text-left">Faculty</th>
                            <th class="text-left">Learning Module</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // show($learningModule);
                        if(!empty($learningModule)) {
                            foreach($learningModule as $Module){ //echo '<pre>';print_r($section); ?>
                                <tr>
                                    <td><?php echo date('d-M-Y', strtotime($Module->schedule_date));?></td>
                                    <td><?php echo date('g:i a', strtotime($Module->schedule_start_time)).' - '.date('g:i a', strtotime($Module->schedule_end_time));?></td>
                                    <td class="text-left"><?php echo $Module->subject_name;?></td>
                                    <td class="text-left"><?php echo $Module->name?></td>
                                    <td class="text-left">
                                        <a href="<?php echo base_url();?>user/Student/print_notes/<?php echo $Module->learning_module_id; ?>" class="learningmoduleDwld btn btn-info btn_save">
                                        <i class="fa fa-download text-right"></i><?php echo " ". $this->common->get_name_by_id('am_learning_module','learning_module_name',array('id'=>$Module->learning_module_id));?>

                                        </a>
                                        <!-- <button type="submit" class="btn btn-info btn_save pull-right" id="download_pdf" style="margin-top:40px;">Download ID card</button> -->
                                    </td>
                                    <!-- <td><span class="dwdicon"><i class="fa fa-download text-right"></i></span></td> -->
                                </tr>
                        <?php } ?>
                    <?php }else{?>
                        <tr><th colspan="5" al="">No Data Found!!</th></tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
        <div class="Reg">
            
        </div>
    </div> -->
</div>