<?php $this->load->view('admin/includes/header.php'); ?>
<?php $this->load->view('admin/includes/inner_header.php'); ?>
    <div class="base">
       <?php $this->load->view('admin/includes/breadcrumbs.php'); ?>
        <div class="container-fluid">
            <div class="row">
            <?php if(check_module_permission('staff_leave_report') || check_module_permission('staff_attendance_report') ||
                        check_module_permission('facualty_allocated_report')){ 
                            $url = '';
                            if(check_module_permission('staff_leave_report')){$url = 'backoffice/staff-leave-report'; }
                            if(check_module_permission('facualty_allocated_report')){$url = 'backoffice/facualty-allocated-report'; }
                            if(check_module_permission('staff_attendance_report')){$url = 'backoffice/staff-attendance-report'; }?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($url);?>">
                        <div class="dash_box reportBoxs">
                            <!-- <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                            <div class="reportWappers">
                                <h5> <i class="fa fa-address-book" aria-hidden="true"></i>Staff Report</h5>
                            </div>
                        </div>
                        
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('student_report') || check_module_permission('student_attendance_report')){ 
                $url = '';
                if(check_module_permission('student_report')){$url = 'backoffice/student-report'; }
                if(check_module_permission('student_attendance_report')){$url = 'backoffice/student-attendance-report'; }?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($url);?>">
                        <div class="dash_box reportBoxs">
                            <!-- <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                            <div class="reportWappers">
                                <h5> <i class="fa fa-address-book" aria-hidden="true"></i>Student Report</h5>
                            </div>
                        </div>
                        
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('batch_schedule_report') || check_module_permission('exam_schedule_report')){ 
                $url = '';
                if(check_module_permission('batch_schedule_report')){$url = 'backoffice/batch-schedule-report'; }
                if(check_module_permission('exam_schedule_report')){$url = 'backoffice/exam-schedule-report'; }?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($url);?>">
                        <div class="dash_box reportBoxs">
                            <!-- <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                            <div class="reportWappers">
                                <h5> <i class="fa fa-address-book" aria-hidden="true"></i>Schedule Report</h5>
                            </div>
                        </div>
                        
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('exam_avgmark_report')){ 
                $url = '';
                if(check_module_permission('exam_avgmark_report')){$url = 'backoffice/exam-avgmark-report'; }?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($url);?>">
                        <div class="dash_box reportBoxs">
                            <!-- <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                            <div class="reportWappers">
                                <h5> <i class="fa fa-address-book" aria-hidden="true"></i>Exam Report</h5>
                            </div>
                        </div>
                        
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('center_wise_fee_report')){ 
                $url = '';
                if(check_module_permission('center_wise_fee_report')){$url = 'backoffice/center-wise-fee-report'; }?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/center-wise-fee-report');?>">
                        <div class="dash_box reportBoxs">
                            <!-- <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                            <div class="reportWappers">
                                <h5> <i class="fa fa-address-book" aria-hidden="true"></i>Fee Report</h5>
                            </div>
                        </div>
                        
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('application_log')){ 
                $url = '';
                if(check_module_permission('application_log')){$url = 'backoffice/application-log'; }?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/application-log');?>">
                        <div class="dash_box reportBoxs">
                            <!-- <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
                            <div class="reportWappers">
                                <h5> <i class="fa fa-address-book" aria-hidden="true"></i>Application Log</h5>
                            </div>
                        </div>
                        
                    </a>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
<?php $this->load->view('admin/includes/footer.php'); ?>
