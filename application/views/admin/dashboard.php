<!DOCTYPE html>
<html lang="en">

<head>
    <title>IIHRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/custom_ver2.0.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/jquery-confirm.min.css">
</head>

<body>
    <!-- Top header section starts here -->
    <div class="container-fluid header_wrapper">
        <div class="log_section">
            <img src="<?php echo base_url();?>inner_assets/images/logo_inner.jpg" class="img-fluid" />
        </div>
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0">
                <button class="btn btn-default ham_navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <button class="btn btn-info logout_btn float-right r_separation" id="logout">
                    <i class="fa fa-power-off"></i>
                </button>
                <!-- <div class="float-right r_separation" id="notification_li">
                    <div id="notificationLink"></div>
                </div> -->

                <div class="login_details float-right ">
                    Hello, <?php echo $this->session->userdata('name'); ?>
                </div>
            </div>
        </div>
        
    </div>
    <div class="container-fluid header_tab">
        <div class="row">
            <a href="#">
                <div class="main_menu" onClick="redirect('backoffice');">
                    <span>Dashboard</span>
                </div>
            </a>
        </div>
    </div>
    <!-- Top header section ends here -->

    <?php $xx = 0; ?>
    <div class="base">
        <div class="container-fluid">
            <div class="row">
            <?php if(check_module_permission('staff')){ ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url('backoffice/staff-list');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/staff-list');?>">
                        <div class="dash_box">
                            <i class="fa fa-user box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Staff
                                <small>Manage staff</small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php 
            $allowedurls = '';
            if(check_module_permission('basic_configuration')){ 
                if(check_module_permission('manage_institute') && $allowedurls=='' ){ 
                    $allowedurls = 'admin-institute';
                    }
                    if(check_module_permission('manage_course') && $allowedurls==''){													 
                       $allowedurls = 'admin-course';
                    }
                    if(check_module_permission('manage_batch') && $allowedurls==''){													 
                       $allowedurls = 'backoffice/manage-batch';
                    }
                    if(check_module_permission('payment_heads') && $allowedurls==''){													 
                       $allowedurls = 'backoffice/payment-heads';
                    }
                    if(check_module_permission('discount') && $allowedurls==''){													 
                       $allowedurls = 'backoffice/discount';
                    }
                   if(check_module_permission('manage_syllabus') && $allowedurls==''){													 
                       $allowedurls = 'admin-syllabus';
                    }
                    if(check_module_permission('manage_course') && $allowedurls==''){													 
                        $allowedurls = 'admin-course';
                     }
                     if(check_module_permission('manage_batch') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-batch';
                     }
                     if(check_module_permission('manage_subject') && $allowedurls==''){													 
                        $allowedurls = 'admin-subject';
                     }
                     if(check_module_permission('subject_syllabus_mapping') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/admin-subject-syllabus';
                     }
                     if(check_module_permission('manage_classrooms') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-classrooms';
                     }
                     if(check_module_permission('manage_bus') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-bus';
                     }
                     if(check_module_permission('manage_route') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-route';
                     }
                     if(check_module_permission('vehicle_maintenance') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/maintenance';
                     }
                     if(check_module_permission('manage_buildings') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-buildings';
                     }
                     if(check_module_permission('manage_floors') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-floors';
                     }
                     if(check_module_permission('manage_roomtype') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-roomtype';
                     }
                     if(check_module_permission('manage_rooms') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-rooms';
                     }
                     if(check_module_permission('manage_hostelfee') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-hostelfee';
                     }
                     if(check_module_permission('manage_roombooking') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-roombooking';
                     }
                     if(check_module_permission('search_roombooking') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/search-roombooking';
                     }
                     if(check_module_permission('manage_holidays') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/manage-holidays';
                     }
                     if(check_module_permission('leave_head') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/leave-head';
                     }
                     if(check_module_permission('leave_scheme') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/leave-scheme';
                     }
                     if(check_module_permission('staff_leave_status') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/staff-leave-status';
                     }
                     if(check_module_permission('salary_component') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/salary-component';
                     }
                     if(check_module_permission('salary_scheme') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/salary-scheme';
                     }
                     if(check_module_permission('salary_advances') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/salary-advances';
                     }
                     if(check_module_permission('salary_processing') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/salary-processing';
                     }
                     if(check_module_permission('student_migration') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/data-migration';
                     }
                     if(check_module_permission('staff_migration') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/staff-migration';
                     }
                     if(check_module_permission('config_settings') && $allowedurls==''){													 
                        $allowedurls = 'backoffice/config-settings';
                     }
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);//base_url('admin-institute');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-cog box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Basic Configurations
                               <small>Institute/Courses/Batch/Subjects</small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php 
              $value=$this->common->get_name_by_id('am_config','value',array('key'=>'material_upload'));
            if($value == 0){  
            $allowedurls = '';
            if(check_module_permission('material_management')){ 
                if(check_module_permission('manage_materials') && $allowedurls==''){	
                    $allowedurls = 'backoffice/material-management';													 
                }
                if(check_module_permission('manage_learning_module') || check_module_permission('create_learning_module') || check_module_permission('schedule_learning_module')   && $allowedurls==''){													 
                       $allowedurls = 'backoffice/learning-module';
                }
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-file-text box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Material management
                                <small>Questions and study materials</small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } }
                if($this->session->userdata('role')=='faculty'){
                  $allowedurls = '';
                  if(check_module_permission('material_management')){ 
                      if(check_module_permission('manage_materials') && $allowedurls==''){	
                          $allowedurls = 'backoffice/material-management';													 
                      }
                      if(check_module_permission('manage_learning_module') || check_module_permission('create_learning_module') || check_module_permission('schedule_learning_module')   && $allowedurls==''){													 
                             $allowedurls = 'backoffice/learning-module';
                      }
                      ?>
                      <?php $xx++; ?>
                      <?php $redirectmenu = base_url($allowedurls);?>
                      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                          <a href="<?php echo base_url($allowedurls);?>">
                              <div class="dash_box">
                                  <i class="fa fa-file-text box_icon"></i>
                                  <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                  <h5>Material management
                                      <small>Questions and study materials</small>
                                  </h5>
                              </div>
                          </a>
                      </div>
                  <?php } 

            } ?>
            <?php 
            $allowedurls = '';
            if(check_module_permission('exam_management')){ 
                $header=TRUE; 
                if(check_module_permission('exam_schedule') && $allowedurls==''){	
                    $allowedurls = 'backoffice/exam-schedule';													 
                }
                if(check_module_permission('exam_valuation') && $allowedurls==''){													 
                       $allowedurls = 'backoffice/exam-valuation';
                }
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-pencil box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Exam management
                                <small>Exam and question papers</small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php 
            $allowedurls = '';
            if(check_module_permission('class_schedule')){ 
                if(check_module_permission('manage_schedule') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/scheduler';
                }
                if(check_module_permission('manage_class_schedule') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/class-schedule';
                }
                if(check_module_permission('manual_class_schedule') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/manual-class-schedule';
                }
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-calendar box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Scheduler<small>Class schedules</small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php 
            $allowedurls = '';
            if(check_module_permission('students')){ 
                if(check_module_permission('manage_students') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/student-list';
                    }
                    if(check_module_permission('manage_progress_report') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/progress-reportlist';
                        }
                    if(check_module_permission('manage_hallticket') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/hallticket';
                        }  
                    if(check_module_permission('manage_mentor') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/mentor';
                        } 
                    if(check_module_permission('users-password-reset') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/users-password-reset';
                        }  
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-users box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Student Management
                           </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('attendance')){ ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url('backoffice/daily-attendance');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/daily-attendance');?>">
                        <div class="dash_box">
                            <i class="fa fa-calendar box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5><?php echo $this->lang->line('attendance'); ?>
                                <small><?php echo $this->lang->line('daily_attendance'); ?></small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?> 
            <?php if(check_module_permission('approval')){ ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url('backoffice/discount-approval');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/discount-approval');?>">
                        <div class="dash_box">
                            <i class="fa fa-list-alt box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5><?php echo $this->lang->line('approve_management'); ?>
                                <small></small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php if(check_module_permission('call_center')){ ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url('backoffice/cc-dashboard');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/cc-dashboard');?>">
                        <div class="dash_box">
                            <i class="fa fa-phone box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Call Centre Management
                                <!-- <small>Lorem ipsum of smal things</small> -->
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php 
            $allowedurls = '';
            if(check_module_permission('asset_management')){ 
                    if(check_module_permission('asset_category') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/Asset-category';
                    }
                    if(check_module_permission('asset') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/Asset';
                        }
                    if(check_module_permission('supportive_services') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/supportive-services';
                        }  
                    if(check_module_permission('maintenance_service_type') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/maintenance-type';
                    }
                    if(check_module_permission('maintenance_services') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/maintenance-services';
                    }
                    if(check_module_permission('view_maintenance_services') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/view-maintenance-services';
                    }
                    if(check_module_permission('manage_purchase_quotes') && $allowedurls=='' ){ 
                        $allowedurls = 'backoffice/manage-purchase-quotes';
                    }     
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-list-alt box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5><?php echo $this->lang->line('asset_management'); ?>
                                <small></small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>

            <?php 
            $allowedurls = '';
            if(check_module_permission('content_management')){ 
                if(check_module_permission('category') && $allowedurls=='' ){ 
                $allowedurls = 'backoffice/category';
                }
                if(check_module_permission('banner') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/banner';
                } 
                if(check_module_permission('special_about_school') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/special-about-school';
                }
                if(check_module_permission('services') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/services';
                }
                if(check_module_permission('how_to_prepare') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/how_to_prepare';
                }
                if(check_module_permission('success_stories') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/success-stories';
                }
                if(check_module_permission('gallery') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/gallery';
                }
                if(check_module_permission('general_studies') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/general-studies';
                }
                if(check_module_permission('careers') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/careers';
                }
                if(check_module_permission('exams_notifications') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/exams-notifications';
                }
                if(check_module_permission('result') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/result';
                }
                if(check_module_permission('question') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/sample-questions';
                }    ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-address-book  box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>Content Management
                               <!-- <small>Backoffice users and roles</small> -->
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?> 
            <?php if(check_module_permission('report_management')){ ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url('backoffice/student-report');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/report');?>">
                        <div class="dash_box">
                            <i class="fa fa-book box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5><?php echo $this->lang->line('reports'); ?>
                                <!-- <small>Lorem ipsum of smal things</small> -->
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php 
            $allowedurls = '';
            if(check_module_permission('notifications')){ 
                if(check_module_permission('question') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/student-notification';
                } 
                if(check_module_permission('question') && $allowedurls=='' ){ 
                    $allowedurls = 'backoffice/staff-notification';
                } 
                ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url($allowedurls);?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url($allowedurls);?>">
                        <div class="dash_box">
                            <i class="fa fa-bell  box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5><?php echo $this->lang->line('notifications');?> 
                               <!-- <small>Backoffice users and roles</small> -->
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?> 
            <!-- <?php //if(check_module_permission('messenger')){ ?>
<?php //$xx++; ?>
<?php //$redirectmenu = base_url('backoffice/messenger');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('backoffice/messenger');?>">
                        <div class="dash_box">
                            <i class="fa fa-bell  box_icon"></i> -->
                            <!-- <i class="fa fa-comments box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5><?php echo $this->lang->line('messenger');?> 
                               <small>Message service</small>
                            </h5>
                        </div>
                    </a>
                </div> -->
            <?php //} ?> 
            <?php if(check_module_permission('usermanagement')){ ?>
				<?php $xx++; ?>
				<?php $redirectmenu = base_url('user-management');?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="<?php echo base_url('user-management');?>">
                        <div class="dash_box">
                            <i class="fa fa-address-book  box_icon"></i>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h5>User Management
                               <small>Backoffice users and roles</small>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
<?php $this->load->view('includes/common_header');?>
<?php if($xx==1) { 
	if($this->session->userdata('role')=='cch'){  
	?>
	<script>
	window.location.href = '<?php echo $redirectmenu;?>'; //Will take you to Google.
	</script>
	<?php } else if($this->session->userdata('role')=='cce'){ ?>
	<script>
	window.location.href = '<?php echo base_url('backoffice/manage-calls');?>'; //Will take you to Google.
	</script>
<?php } else { ?>
	<script>
	window.location.href = '<?php echo $redirectmenu;?>'; //Will take you to Google.
	</script>
	<?php } ?>
<?php } ?>
     <!-- Script Section Starts here -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/bootstrap-multiselect.css" />
    <script src="<?php echo base_url();?>inner_assets/js/popper.min.js "></script>
    <script src="<?php echo base_url();?>inner_assets/js/bootstrap.min.js "></script>
    <script src="<?php echo base_url();?>inner_assets/js/moment.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.toaster.js"></script> 
    <script src="<?php echo base_url();?>inner_assets/js/custom.js "></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.tooltipster.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/all.js?v=<?php echo time();?>" type="text/javascript"></script>
</body>
</html>
