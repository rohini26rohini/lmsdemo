<body>
    <!-- Top header section starts here -->
	<div class="loader">
    <img src="<?php echo base_url();?>assets/images/loader.gif" />
    </div>
    <div class="container-fluid header_wrapper">
        <div class="log_section">
            <img src="<?php echo base_url();?>inner_assets/images/logo_inner.jpg" class="img-fluid" />
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0">
                <button class="btn btn-default ham_navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <button title="Logout" class="btn btn-info logout_btn float-right r_separation" id="logout">
                    <i class="fa fa-power-off"></i>
                </button>
                <!-- <button title="<?php echo $this->lang->line('settings'); ?>" class="btn btn-info logout_btn float-right r_separation" onClick="redirect('employee');">
                    <i class="fa fa-cogs"></i>
                </button> -->
                
                <div class="float-right r_separation" id="notification_li">
                    <div id="notificationLink"></div>
                    <!-- <a href="#" id="notificationLink"><img src="<?php echo base_url();?>inner_assets/images/notificcationinactive.png" class="img-responsive"></a>
                    <div id="notificationContainer" >
                        <div id="notificationTitle">Notifications</div>
                        <div id="notificationsBody" class="notifications">
                            <ul>
                                <a href="">
                                    <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                </a>
                                <a href="">
                                    <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                </a>
                                <a href="">
                                    <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                </a>
                                <a href="">
                                    <li>Request is Processed on your lorem ipsum content changed<span class="notification_time">8 Hours Ago</span></li>
                                </a>
                            </ul>
                        </div>
                        <div id="notificationFooter"><a href="#">See All</a></div>
                    </div> -->
                </div>
                <div class="login_details float-right ">
                    <?php //print_r($_SESSION);
                    if($this->session->userdata('user_id')!="" && $this->session->userdata('role')=="faculty"){?>
                        <a href="<?php echo base_url(); ?>employee">  Hello, <?php echo $this->session->userdata('name'); ?></a>
                    <?php }else if($this->session->userdata('user_id')!="" && $this->session->userdata('role')=="cch" && $this->session->userdata('role')=="cce"){ ?>
                        <a href="<?php echo base_url(); ?>backoffice/profile">  Hello, <?php echo $this->session->userdata('name'); ?></a>
                    <?php }else{?>
                        Hello, <?php echo $this->session->userdata('name'); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Top header section ends here -->

    <!-- Navigation Section Starts here -->
    <!-- <div class="container-fluid main_nav">
        <button class="btn btn-default nav_close">
            <i class="fa fa-times"></i>
        </button>
        <h3 class="main_nav_h3">
            Direction
            <small>
                The Website Management
            </small>
        </h3>
        <ul class="main_nav_ul flex-wrap">
            <li class="col-md-12 col-sm-12 col-12">
                <a href="#">Basic Configuration</a>
                <a href="#">Sample Questions</a>
                <a href="#">Question Bank</a>
            </li>
        </ul>
    </div> -->
    <!-- Navigation Section Starts here -->

    <!-- Tab section Starts here -->
    <?php $header=FALSE;?>
    
    <div class="container-fluid header_tab">
        
        <div class="row">
            <nav role="navigation" id="nav-main" class="okayNav">
               <ul>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('staff')){$header=TRUE; 
                        if(check_module_permission('manage_staff') && $allowedurls=='' ){ 
                            $allowedurls = 'backoffice/staff-list';
                        }
                        if(check_module_permission('manage_faculty_availablity') && $allowedurls=='' ){ 
                            $allowedurls = 'backoffice/manage-faculty-availablity';
                        }
                        if(check_module_permission('manage-faculty-attendance') && $allowedurls=='' ){ 
                            $allowedurls = 'backoffice/manage-faculty-attendance';
                        }
                        ?>
                    <li><a href="#" onClick="redirect('<?php echo $allowedurls;?>');">Staff Management</a></li>
                    <?php } ?>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('basic_configuration') && $allowedurls=='' ){ $header=TRUE; 
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
                    <li><a href="#" onClick="redirect('<?php echo $allowedurls;?>');">Basic Configuration</a></li>
                    <?php } ?>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('material_management')){
                        $header=TRUE; 
                        if(check_module_permission('manage_materials') && $allowedurls==''){	
						    $allowedurls = 'backoffice/material-management';													 
                        }
						if(check_module_permission('manage_learning_module') || check_module_permission('create_learning_module') || check_module_permission('schedule_learning_module')   && $allowedurls==''){													 
				   		    $allowedurls = 'backoffice/learning-module';
						}
				   ?>
                    <li><a href="#" onClick="redirect('<?php echo $allowedurls;?>');">Material Management</a></li>
                    <?php } ?>
                    <?php// if(check_module_permission('material_management')){$header=TRUE; ?>
                    <!-- <li><a href="#" onClick="redirect('backoffice/material-management');">Material management</a></li> -->
                    <?php //} ?>
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
                    <li><a okayNav__menu-toggle href="#" onClick="redirect('<?php echo $allowedurls;?>');">Exam Management</a></li>
                    <?php } ?>
                    <!-- <?php //if(check_module_permission('exam_management')){$header=TRUE; ?>
                    <li><a href="#" onClick="redirect('backoffice/exam-management');">Exam management</a></li>
                    <?php //} ?> -->
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('class_schedule')){$header=TRUE; 
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
                    <li><a tabindex="-1" href="#" onClick="redirect('<?php echo $allowedurls;?>');">Scheduler</a></li>
                    <?php } ?>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('students')){$header=TRUE; 
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
                    <li><a tabindex="-1" href="#" onClick="redirect('<?php echo $allowedurls;?>');">Student Management</a></li>
                    <?php } ?>
                    <?php if(check_module_permission('attendance')){$header=TRUE; ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('backoffice/daily-attendance');"><?php echo $this->lang->line('attendance'); ?></a></li>
                    <?php } ?>
                    <?php if(check_module_permission('approval')){
                            $header=TRUE; 
                    if($this->session->userdata('role') == 'centerhead' || $this->session->userdata('role')=='admin') {  ?>                                            
                    <li><a tabindex="-1" href="#" onClick="redirect('backoffice/discount-approval');"><?php echo $this->lang->line('approve_management'); ?></a></li>
                    <?php }
                     else if($this->session->userdata('role')=='management' || $this->session->userdata('role')=='admin') {  ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('backoffice/maintenance-amount-approval');"><?php echo $this->lang->line('approve_management'); ?></a>
                    </li>
                    <?php } else {?>
                        <li><a tabindex="-1" href="#" onClick="redirect('backoffice/material-approval');"><?php echo $this->lang->line('approve_management'); ?></a>
                    </li>   
                    <?php } }?>
                    <?php if(check_module_permission('call_center')){$header=TRUE; ?>
                    <li class="dir_management"><a tabindex="-1" href="#" onClick="redirect('backoffice/manage-calls');">Call Centre Management<?php if(isset($cntremaindercalls) && $cntremaindercalls>0) { ?>
                <img src="<?php echo base_url();?>inner_assets/images/notifications_red.png" alt="notifications">
                <?php } ?></a></li>
                    <?php } ?>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('asset_management')){$header=TRUE; 
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
                    if($this->session->userdata('role')=='centerhead') {
                    ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('backoffice/maintenance-services');"><?php echo $this->lang->line('asset_management'); ?></a></li>
                    <?php } 
                    else if($this->session->userdata('role')=='operationhead') {  ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('backoffice/view-maintenance-services');"><?php echo $this->lang->line('asset_management'); ?></a>
                    </li>                               
                    <?php   }
                    else { ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('<?php echo $allowedurls;?>');"><?php echo $this->lang->line('asset_management'); ?></a></li>
                    <?php } ?>
                    <?php } ?>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('content_management')){ $header=TRUE; 
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
                            } 
                        ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('<?php echo $allowedurls;?>');">Content Management</a></li>
                    <?php } ?>
                    <?php if(check_module_permission('report_management')){$header=TRUE; ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('backoffice/report');"><?php echo $this->lang->line('reports'); ?></a></li>
                    <?php } ?>
                    <?php if(check_module_permission('usermanagement')){$header=TRUE; ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('user-management');">User Management</a></li>
                    <?php } ?>
                   <?php 
                   $role=$this->session->userdata['role'];
                   if($role == 'admin'){$header=TRUE; ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('admin-change-password');">Change Password </a></li>
                    <?php } ?>
                    <?php 
                    $allowedurls = '';
                    if(check_module_permission('notifications')){$header=TRUE; 
                        if(check_module_permission('question') && $allowedurls=='' ){ 
                            $allowedurls = 'backoffice/student-notification';
                        } 
                        if(check_module_permission('question') && $allowedurls=='' ){ 
                            $allowedurls = 'backoffice/staff-notification';
                        } 
                        ?>
                    <li><a tabindex="-1" href="#" onClick="redirect('<?php echo $allowedurls;?>');">Notification </a></li>
                    <?php } 
                    $role=$this->session->userdata['role'];?>
                    <?php if(check_module_permission('messenger') && $role == 'faculty'){$header=TRUE; ?>
                    <li style="position:relative;"><a tabindex="-1" href="#" onClick="redirect('backoffice/messenger');"><?php echo $this->lang->line('messenger'); ?> </a>
                    <?php 
                    $user_id = $this->session->userdata['user_id'];
                    $notifyCount = $this->common->notifycount($user_id);
                    if($notifyCount != 0){
                        echo '<span class="messanger-noty">'.$notifyCount.'</span>';
                    }?>
                    </li>
                    <?php } ?>
               </ul>
           </nav>
<!--
        <?php if(check_module_permission('usermanagement')){$header=TRUE; ?>
            <a href="#">
                <div class="main_menu <?php if($menu == "usermanagement"){ echo 'active'; } ?>" onClick="redirect('user-management');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>User management</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('basic_configuration')){$header=TRUE; ?>
            <a href="#">
                <div class="main_menu <?php if($menu == "basic_configuration"){ echo 'active'; } ?>" onClick="redirect('admin-institute');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Basic Configuration</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('question')){$header=TRUE; ?>
            <a href="#">
                <div class="main_menu <?php if($menu == "question"){ echo 'active'; } ?>" onClick="redirect('backoffice/admin-question');">
        
                <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Sample Questions</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('material_management')){$header=TRUE; ?>
             <a href="#">
                <div class="main_menu <?php if($menu == "questionbank"){ echo 'active'; } ?>" onClick="redirect('backoffice/material-management');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Material management</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('exam_management')){$header=TRUE; ?>
             <a href="#">
                <div class="main_menu <?php if($menu == "exam_management"){ echo 'active'; } ?>" onClick="redirect('backoffice/exam-management');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Exam management</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('call_center')){$header=TRUE; ?>
            <a href="#">
                <div class="main_menu <?php if($menu == "call_center"){ echo 'active'; } ?>" onClick="redirect('backoffice/manage-calls');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Call Centre Management</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('staff')){$header=TRUE; ?>
            <a href="#">
                <div class="main_menu <?php if($menu == "staff"){ echo 'active'; } ?>" onClick="redirect('backoffice/staff-list');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Staff Management</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('students')){$header=TRUE; ?>
            <a href="#">
                <div class="main_menu <?php if($menu == "students"){ echo 'active'; } ?>" onClick="redirect('backoffice/student-list');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Student Management</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('bus')){$header=TRUE; ?>
             <a href="#">
                <div class="main_menu <?php if($menu == "bus"){ echo 'active'; } ?>" onClick="redirect('backoffice/manage-bus');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Transport</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('class_schedule')){$header=TRUE; ?>
             <a href="#">
                <div class="main_menu <?php if($menu == "scheduler"){ echo 'active'; } ?>" onClick="redirect('backoffice/scheduler');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>Scheduler</span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('asset_management')){$header=TRUE; ?>
             <a href="#">
                <div class="main_menu <?php if($menu == "asset_management"){ echo 'active'; } ?>" onClick="redirect('backoffice/supportive-services');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span><?php echo $this->lang->line('asset_management'); ?></span>
                </div>
            </a>
        <?php } ?>
        <?php if(check_module_permission('approval')){$header=TRUE; ?>
             <a href="#">
                <div class="main_menu <?php if($menu == "approval" || $menu == "receptionist"){ echo 'active'; } ?>" onClick="redirect('backoffice/discount-approval');">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span><?php echo $this->lang->line('approve_management'); ?></span>
                </div>
            </a>
        <?php } ?>
-->
        
        </div>
    </div>
    





    <div class="container-fluid header_tab">
        <div class="row">
        <?php if(!$header){ ?>
             <a href="#">
                <div class="main_menu">
                    <img src="<?php echo base_url();?>inner_assets/images/student.svg" class="img-responsive" />
                    <span>&nbsp;</span>
                </div>
            </a>
        <?php } ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
            $("#notificationLink").click(function() {
                $("#notificationContainer").fadeToggle(300);
                $("#notification_count").fadeOut("slow");
//                return false;
            });

            //Document Click hiding the popup
//            $(document).click(function() {
//                $("#notificationContainer").hide();
//            });

            //Popup on click
//            $("#notificationContainer").click(function() {
//                return false;
//            });

        });
    </script>
    <!-- Tab section Ends here -->

<script type="text/javascript">
        var navigation = $('#nav-main').okayNav();
    </script>
