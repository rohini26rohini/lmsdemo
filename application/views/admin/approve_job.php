<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <?php if(!empty($jobs)) {?>
    <div class="white_card">
        <h6><?php echo $breadcrumb[1]['name'];?></h6>
        <hr>
        <!-- <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_banner" onclick="formclear('banner_form');">
        Approve
        </button> -->
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data1" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Sl. No.</th>
                        <th width="50%"><?php echo $materialName; ?> Name</th>
                        <th width="25%"><?php echo $materialName; ?> Assigned date</th>
                        <th width="10%">Status</th>
                        <th width="10%">Action </th>
                    </tr>
                </thead>
                <?php  
            if(!empty($jobs)) { 
                // show($jobs);
            $i=1; foreach($jobs as $job){?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td>
                        <?php if($job->flow_entities == 1){?>
                            <?php echo $this->common->get_name_by_id('mm_question_set','question_set_name',array('question_set_id'=>$job->entity_id));?>
                        <?php }else if($job->flow_entities == 2){?>
                            <?php echo $this->common->get_name_by_id('am_learning_module','learning_module_name',array('id'=>$job->entity_id));?>
                        <?php }else if($job->flow_entities == 3){?>
                            <?php echo $this->common->get_name_by_id('gm_exam_paper','exam_paper_name',array('id'=>$job->entity_id));?>
                        <?php }?>
                    </td>
                    <td><?php echo date('d-M-Y h:i a',strtotime($job->assign_date));?></td>
                    <td>
                        <?php if($job->status == '1'){?>
                            <span class="btn mybutton mybuttonnew">New</span>
                            <?php if($this->common->get_approvalUserByJobid($job->rejected_by)) {
                                // show($this->common->get_approvalUserByJobid($job->rejected_by))?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!-- <span class="btn mybutton mybuttonnew1" title="Click here to view reason" onclick="view_rejectedRemark('<?php echo $this->common->get_name_by_id('approval_flow_jobs','remarks',array('id'=>$job->rejected_by));?>')">Rejected by <?php echo $this->common->get_approvalUserByJobid($job->rejected_by)?></span> -->
                                <span class="btn mybutton mybuttonnew1" title="Click here to view reason" onclick="view_rejectedRemark('<?php echo $job->rejected_by;?>','<?php echo $this->common->get_approvalUserByJobid($job->rejected_by)?>')">Rejected by Level 2 User</span>
                            <?php } ?>
                        <?php }else if($job->status == '2'){ ?>
                            <span class="btn mybutton  mybuttonActive">Approved</span>
                        <?php }else if($job->status == '3'){ ?>
                            <span class="btn mybutton  mybuttonInactive">Rejected</span>
                        <?php } ?>
                    </td>
                    <td>
                    <?php if($job->status == '1'){ ?>
                        <?php if($job->flow_entities == 1){ ?>
                            <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>view-question/<?php echo $job->id; ?>" title="Click here to view the details">
                                <i class="fa fa-eye "></i> Action
                            </a>
                        <?php }else if($job->flow_entities == 2){ ?>
                            <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>view-learning-module?id=<?php echo  $job->entity_id;?>&jobid=<?php echo $job->id;?>" title="Click here to view the details">
                                <i class="fa fa-eye "></i> Action
                            </a>
                        <?php }else if($job->flow_entities == 3){ ?>
                            <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>view-exam-paper?id=<?php echo  $job->entity_id;?>&jobid=<?php echo $job->id;?>" title="Click here to view the details">
                                <i class="fa fa-eye "></i> Action
                            </a>
                        <?php }?>
                    <?php }else if($job->status == '2' || $job->status == '3'){?>
                        <?php if($job->flow_entities == 3){?>
                            <a href="#" title="View" title="View" onclick="view_question_paper('<?php echo $job->entity_id;?>')">
                                <i class="fa fa-eye "></i>
                            </a>
                        <?php }else if($job->flow_entities == 2){ ?>
                            <a href="#" title="View" title="View" onclick="view_learning_module('<?php echo $job->entity_id;?>')">
                                <i class="fa fa-eye "></i>
                            </a>
                    <?php } }?>
                    </td>
                </tr>
                <?php $i++; }} ?>
            </table>
            <!-- Data Table Plugin Section Starts Here -->
        </div>
    </div>
    <?php } else {?>
    <div class="white_card">
        <h6>No Material Available For Approval</h6>
    </div>
    <?php } ?>
</div>
<div id="finishmodal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="text-align: center;" class="modal-title" id="finishmodal_title">Title</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="finishmodal_body"></div>
            <div class="modal-footer" id="finishmodal_footer"></div> 
        </div>
    </div>
</div>
<div id="view_learning_module" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="text-align: center;" class="modal-title" id="learning_module_namem">Title</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="finishmodal_body1">
            </div>
            <div class="modal-footer" id="finishmodal_footer1"></div> 
        </div>
    </div>
</div>
<div id="view_rejectedRemark" class="modal fade form_box" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="text-align: center;" class="modal-title">Rejection Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="rejectedUser"></div>
                <div id="reason"></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal">Cancel</a>
            </div> 
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/approve_management_script");?>
