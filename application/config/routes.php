<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


/******************** Website *************************************************************************/

$route['default_controller']                        = 'Home';
$route['exam-result']                               = 'Home/exam_result';
$route['login']                                     = 'backoffice/login';

$route['direction-ias-study-circle']                = 'Home/iasstudycircle';
$route['direction-school-for-ssc-examinations']     = 'Home/sscexaminations';
$route['direction-school-for-netjrf-examinations']  = 'Home/netjrfexaminations';
$route['direction-school-of-banking']               = 'Home/schoolofbanking';
$route['direction-school-for-psc-examinations']     = 'Home/pscexaminations';
$route['direction-junior']                          = 'Home/directionjunior';
$route['direction-school-for-entrance-examinations']   = 'Home/entranceexamination';
$route['direction-ias-aspirants']                   = 'Home/iasaspirants';
// $route['direction-ias-aspirants/(:any)']         = 'Home/iasaspirants/$1';
$route['direction-ias-upscaspirants']               = 'Home/iasupscaspirants';
$route['direction-net-jrf']                         = 'Home/jrf';
$route['direction-net-net']                         = 'Home/net';
$route['direction-net-msc']                         = 'Home/msc';

$route['direction-psc-kas']                         = 'Home/kas';
$route['direction-psc-psc']                         = 'Home/psc';
$route['direction-psc-ldc']                         = 'Home/ldc';
$route['direction-psc-ua']                          = 'Home/ua';
$route['direction-psc-sa']                          = 'Home/sa';
$route['direction-psc-ag']                          = 'Home/ag';
$route['direction-net-hsst']                        = 'Home/hsst';

$route['direction-ssc-cgl']                         = 'Home/cgl';
$route['direction-ssc-chsl']                        = 'Home/chsl';
$route['direction-ssc-cpo']                         = 'Home/cpo';
$route['direction-ssc-mts']                         = 'Home/mts';
$route['direction-ssc-je']                          = 'Home/je';

$route['direction-bank-clerk']                     = 'Home/clerk';
$route['direction-bank-po']                        = 'Home/po';
$route['direction-bank-so']                        = 'Home/so';
$route['direction-bank-rrb']                       = 'Home/rrb';

$route['direction-junior-std-eight']               = 'Home/std_eight';
$route['direction-junior-std-ten']                 = 'Home/std_ten';

$route['about-us']                                  = 'Home/aboutus';
$route['our-team']                                  = 'Home/ourteam';
$route['sample-test/(:any)']                        = 'Home/exam/$1';
$route['request-a-call-back']                       = 'Home/requestcallback';
$route['raise-a-query']                             = 'Home/raisequery';
$route['find-us']                                   = 'Home/findus';
$route['work-with-us']                              = 'Home/workwithus'; 
$route['grow-with-us']                              = 'Home/growwithus';
$route['gallery']                                   = 'Home/gallery';
$route['gallery/(:any)']                            = 'Home/schoolgallery/$1';
$route['contact-us']                                = 'Home/contactus';
$route['contact']                                   = 'Home/contactus';
$route['privacy-policy']                            = 'Home/privacy_policy';
$route['why-direction']                             = 'Home/whydirection';
$route['success-stories']                           = 'Home/success_stories';
$route['school-stories/(:any)']                           = 'Home/school_stories/$1';
$route['about-ias-study-circle']                    = 'Home/about_ias_study_circle';
$route['results/(:any)/(:any)']                     = 'Home/results/1/$1';
$route['services']                                  = 'Home/services';
$route['sitemap']                                  = 'Home/sitemap';
$route['difp']                                     = 'Home/difp';
$route['single-story/(:any)']                      = 'Home/single_story/$1';
$route['success-story/(:any)']                     = 'Home/success_story/$1';
$route['single-school-story/(:any)']               = 'Home/single_school_story/$1';

$route['direction-ias-study-circle/(:any)']         = 'Home/elearningtutorials/1/$1';
$route['direction-ias-study-circle/(:any)/(:any)']  = 'Home/elearningtutorials/$1/$2';
$route['direction-school-for-ssc-examinations/(:any)']            = 'Home/elearningtutorials/4/$1';
$route['direction-school-for-ssc-examinations/(:any)/(:any)']     = 'Home/elearningtutorials/$1/$2';
$route['direction-school-for-netjrf-examinations/(:any)']         = 'Home/elearningtutorials/2/$1';
$route['direction-school-for-netjrf-examinations/(:any)/(:any)']  = 'Home/elearningtutorials/$1/$2';
$route['direction-school-of-banking/(:any)']                      = 'Home/elearningtutorials/5/$1';
$route['direction-school-for-entrance-examinations/(:any)']                      = 'Home/elearningtutorials/7/$1';
$route['direction-school-for-rrb-examinations/(:any)']                      = 'Home/elearningtutorials/8/$1';
$route['direction-school-of-banking/(:any)/(:any)']               = 'Home/elearningtutorials/$1/$2';
$route['direction-school-for-psc-examinations/(:any)']            = 'Home/elearningtutorials/3/$1';
$route['direction-school-for-psc-examinations/(:any)/(:any)']     = 'Home/elearningtutorials/$1/$2';
$route['direction-school-for-ssc-examination-questions/(:any)']   = 'Home/previousquestions/$1';
$route['direction-school-for-ssc-examination-questions/(:any)/(:any)']          = 'Home/previousquestions/$1/$2';
$route['direction-school-for-netjrf-examination-questions/(:any)']              = 'Home/previousquestions/$1';
$route['direction-school-for-netjrf-examination-questions/(:any)/(:any)']       = 'Home/previousquestions/$1/$2';
$route['direction-school-of-banking-questions/(:any)']                          = 'Home/previousquestions/$1';
$route['direction-school-of-banking-questions/(:any)/(:any)']                   = 'Home/previousquestions/$1/$2';
$route['direction-school-for-psc-examination-questions/(:any)']                 = 'Home/previousquestions/$1';
$route['direction-school-for-psc-examination-questions/(:any)/(:any)']          = 'Home/previousquestions/$1/$2';
$route['direction-junior/(:any)']                                               = 'Home/elearningtutorials/6/$1';
$route['course-detail/(:any)']                                                  = 'Home/course_detail/$1';
$route['success-stories/(:any)']                                                = 'Home/success_stories_detail/$1';

$route['how-to-prepare-ias']                        = 'Home/iashowtoprepare';
$route['how-to-prepare-net']                        = 'Home/netjrfhowtoprepare';
$route['how-to-prepare-psc']                        = 'Home/pschowtoprepare';
$route['how-to-prepare-ssc']                        = 'Home/sschowtoprepare';
$route['how-to-prepare-banking']                    = 'Home/bankinghowtoprepare';
$route['how-to-prepare-junior']                     = 'Home/juniorhowtoprepare';
$route['how-to-prepare-entrance']                   = 'Home/entrancehowtoprepare';
$route['how-to-prepare-rrb']                        = 'Home/rrbhowtoprepare';

$route['achievers-meet-ias']                        = 'Home/iasachieversmeet';
$route['achievers-meet-ias/(:num)']                 = 'Home/iasachieversmeet/$1';
$route['achievers-meet-net']                        = 'Home/netachieversmeet';
$route['achievers-meet-net/(:num)']                 = 'Home/netachieversmeet/$1';
$route['achievers-meet-psc']                        = 'Home/pscachieversmeet';
$route['achievers-meet-psc/(:num)']                 = 'Home/pscachieversmeet/$1';
$route['achievers-meet-ssc']                        = 'Home/sscachieversmeet';
$route['achievers-meet-ssc/(:num)']                 = 'Home/sscachieversmeet/$1';
$route['achievers-meet-banking']                    = 'Home/bankingachieversmeet';
$route['achievers-meet-banking/(:num)']             = 'Home/bankingachieversmeet/$1';
$route['achievers-meet-junior']                     = 'Home/juniorachieversmeet';
$route['achievers-meet-junior/(:num)']              = 'Home/juniorachieversmeet/$1';

$route['upcoming-notifications']                    = 'Home/upcoming_notifications';
$route['upcoming-notifications-ias']                = 'Home/upcoming_notifications_ias';
$route['upcoming-notifications-net']                = 'Home/upcoming_notifications_net';
$route['upcoming-notifications-psc']                = 'Home/upcoming_notifications_psc';
$route['upcoming-notifications-ssc']                = 'Home/upcoming_notifications_ssc';
$route['upcoming-notifications-banking']            = 'Home/upcoming_notifications_banking';
$route['upcoming-notifications-junior']             = 'Home/upcoming_notifications_junior';
$route['upcoming-notifications-entrance']           = 'Home/upcoming_notifications_entrance';
$route['upcoming-notifications-rrb']                = 'Home/upcoming_notifications_rrb';

$route['ias-director']                              = 'Home/ias_director';


$route['backoffice/admin-subject-syllabus']         = 'backoffice/Courses/subject_syllabus_mapping';

$route['detailed-notification/(:num)']              = 'Home/detailed_notification/$1';
$route['detailed-notification-ias']                 = 'Home/detailed_notification_ias';
$route['detailed-notification-ias/(:num)']          = 'Home/detailed_notification_ias/$1';
$route['detailed-notification-net']                 = 'Home/detailed_notification_net';
$route['detailed-notification-net/(:num)']          = 'Home/detailed_notification_net/$1';
$route['detailed-notification-psc']                 = 'Home/detailed_notification_psc';
$route['detailed-notification-psc/(:num)']          = 'Home/detailed_notification_psc/$1';
$route['detailed-notification-ssc']                 = 'Home/detailed_notification_ssc';
$route['detailed-notification-ssc/(:num)']          = 'Home/detailed_notification_ssc/$1';
$route['detailed-notification-banking']             = 'Home/detailed_notification_banking';
$route['detailed-notification-banking/(:num)']      = 'Home/detailed_notification_banking/$1';
$route['detailed-notification-junior']              = 'Home/detailed_notification_junior';
$route['detailed-notification-junior/(:num)']       = 'Home/detailed_notification_junior/$1';
$route['detailed-notification-entrance']            = 'Home/detailed_notification_entrance';
$route['detailed-notification-entrance/(:num)']     = 'Home/detailed_notification_entrance/$1';
$route['detailed-notification-rrb']                 = 'Home/detailed_notification_rrb';
$route['detailed-notification-rrb/(:num)']          = 'Home/detailed_notification_rrb/$1';
$route['registration']                              = 'Register/index';
$route['all_notifications/(:num)/(:num)']           = 'Home/all_notifications/$1/$2';

$route['detailed_result']                    = 'Home/detailed_result';
$route['detailed_results/(:num)']            = 'Home/detailed_results/$1';
$route['detailed_result/(:num)/(:num)']      = 'Home/detailed_result/$1/$2';
$route['detailed_batch']                     = 'Home/detailed_batch';
$route['detailed_batch/(:num)/(:num)']       = 'Home/detailed_batch/$1/$2';
$route['detailed-batch-net']                 = 'Home/detailed_batch_net';
$route['detailed-batch-net/(:num)']          = 'Home/detailed_batch_net/$1';
$route['detailed-batch-psc']                 = 'Home/detailed_batch_psc';
$route['detailed-batch-psc/(:num)']          = 'Home/detailed_batch_psc/$1';
$route['detailed-batch-ssc']                 = 'Home/detailed_batch_ssc';
$route['detailed-batch-ssc/(:num)']          = 'Home/detailed_batch_ssc/$1';
$route['detailed-batch-banking']             = 'Home/detailed_batch_banking';
$route['detailed-batch-banking/(:num)']      = 'Home/detailed_batch_banking/$1';
$route['detailed-batch-junior']              = 'Home/detailed_batch_junior';
$route['detailed-batch-junior/(:num)']       = 'Home/detailed_batch_junior/$1';
$route['detailed-batch-entrance']            = 'Home/detailed_batch_entrance';
$route['detailed-batch-entrance/(:num)']     = 'Home/detailed_batch_entrance/$1';
$route['detailed-batch-rrb']                 = 'Home/detailed_batch_rrb';
$route['detailed-batch-rrb/(:num)']          = 'Home/detailed_batch_rrb/$1';
/********************************* Student ****************************************************/

$route['pay-fee']                            = 'user/User/online_fee_payment';
$route['fee-payment-success']                = 'user/User/payment_success';
$route['student-dashboard']                  = 'user/Student';
$route['student-dashboard-quiz/(:num)']                  = 'user/Student/load_quiz_details/$1';
$route['student-dashboard-quizfinish']                  = 'user/Student/student_finishpage';
$route['student-dashboard-result/(:num)']                  = 'user/Student/student_result/$1';
$route['student-dashboard-course']                  = 'user/Student/course_list_details';
$route['student-dashboard-courselist']                  = 'user/Student/student_course_list';
$route['student-dashboard/(:num)']           = 'user/view_exam/$1';
$route['course-subject-list/(:num)']           = 'user/Student/study_subject_materials/$1';
$route['course-materials/(:num)']           = 'user/Student/coursestudy_materials/$1';
$route['student-dashboard-studyMaterials/(:num)']           = 'user/Student/study_materials/$1';
$route['student-certificate/(:num)']           = 'user/Student/student_certificate/$1';
$route['parent-dashboard']                   = 'user/Student/parent';
$route['change/(:num)']                      = 'user/Student/changechild/$1';
$route['proceed-topayment']                  = 'user/User/payment_update';
$route['change-password']                  	 = 'user/Student/change_password';

/******************** Back Office **********************************************************************/
$route['backoffice/success-stories']                   = 'backoffice/Content/success_stories';
$route['backoffice/services']                          = 'backoffice/Content/services';
$route['backoffice/result']                            = 'backoffice/Content/result';
$route['backoffice/exams-notifications']               = 'backoffice/Content/exams_notifications';
$route['backoffice/how_to_prepare']                    = 'backoffice/Content/how_to_prepare';

$route['admin-syllabus']                                = 'backoffice/Courses/index';
$route['admin-institute']                               = 'backoffice/Courses/manage_institute';
$route['admin-course']                                  = 'backoffice/Courses/manage_class';
$route['admin-subject']                                 = 'backoffice/Courses/manage_subject';
$route['backoffice/manage-classrooms']                  = 'backoffice/Home/manage_classrooms';
$route['backoffice/view-hierarchy']                     = 'backoffice/Home/view_hierarchy';
$route['backoffice/view-hierarchy/(:num)']              = 'backoffice/Home/view_hierarchy/$1';
$route['backoffice/view-branch-students']               = 'backoffice/Home/view_students_by_branch';
$route['backoffice/view-branch-students/(:any)/(:any)'] = 'backoffice/Commoncontroller/view_students_by_branch/$1/$2';
//$route['backoffice/view-branch-students/(:any)/(:any)'] = 'backoffice/Home/view_students_by_branch/$1/$2';
$route['backoffice/leave-head']                         = 'backoffice/Leave/leave_head';
$route['backoffice/salary-component']                   = 'backoffice/Leave/salary_component';
$route['backoffice/data-migration']                     = 'backoffice/Commoncontroller/data_migration';
$route['backoffice/staff-migration']                    = 'backoffice/Commoncontroller/staff_migration';

/******************** Scheduler **********************************************************************/

$route['backoffice/class-schedule']            = 'backoffice/scheduler/class_schedule';
$route['backoffice/manual-class-schedule']     = 'backoffice/scheduler/manual_class_schedule';
$route['backoffice/success-stories']           = 'backoffice/Content/success_stories';
$route['backoffice/gallery']                   = 'backoffice/Content/gallery';
$route['gallery-view/(:any)']                  = 'Home/gallery_view/$1';
$route['backoffice/general-studies']           = 'backoffice/Content/general_studies';
$route['backoffice/previous-question-and-syllabus']           = 'backoffice/Content/previous_question_and_syllabus';
$route['backoffice/careers']                   = 'backoffice/Content/careers';
$route['backoffice/received-applications']     = 'backoffice/Content/receivedApplication';
$route['backoffice/special-about-school']      = 'backoffice/Content/special_about_school';
$route['backoffice/banner']                    = 'backoffice/Content/banner';
$route['direction-school-for-rrb-examinations']                      = 'Home/rrb_examination';

$route['backoffice/profile']                    = 'backoffice/Call_center/profile';
$route['backoffice/cc-dashboard']               = 'backoffice/Call_center/cc_dashboard';
$route['backoffice/cc-dashboard/(:num)']        = 'backoffice/Call_center/cc_dashboard/$1';
$route['backoffice/in-progress-call-list']      = 'backoffice/Call_center/in_progress_call_list';
$route['backoffice/closed-call-list']           = 'backoffice/Call_center/closed_call_list';
$route['backoffice/unnecessary-call-list']      = 'backoffice/Call_center/unnecessary_call_list';
$route['backoffice/registered-call-list']       = 'backoffice/Call_center/registered_call_list';
$route['backoffice/admitted-call-list']         = 'backoffice/Call_center/admitted_call_list';
$route['backoffice/call-received-today']        = 'backoffice/Call_center/call_received_today';
$route['backoffice/call-admitted-today']        = 'backoffice/Call_center/call_admitted_today';
$route['backoffice/fee-structure']              = 'backoffice/Call_center/fee_structure';
$route['backoffice/call-summary']               = 'backoffice/Call_center/call_summary';
$route['backoffice/manage-calls']               = 'backoffice/Call_center/index';
$route['backoffice/manage-calls/(:num)/(:num)'] = 'backoffice/Call_center/index/$1/$2';
$route['backoffice/remainder-calls']            = 'backoffice/Call_center/remainder_calls';
$route['backoffice/remainder-sms']              = 'backoffice/Call_center/remainder_sms';
$route['backoffice/bulk-sms']                   = 'backoffice/Call_center/bulk_sms';
//$route['backoffice/reference-list']           = 'backoffice/Call_center/reference_list';
$route['backoffice/reference-list']             = 'backoffice/Commoncontroller/reference_list';

$route['backoffice/manage-queries']             = 'backoffice/Call_center/manage_query';
$route['backoffice/manage-callbacks']           = 'backoffice/Call_center/manage_callbacks';
$route['backoffice/export-callcenter']          = 'backoffice/Call_center/export_callcenter';
$route['backoffice/export-reffered-calls']      = 'backoffice/Commoncontroller/export_reffered_calls';
$route['backoffice/printing']                   = 'backoffice/Printing/print_sheet';
$route['backoffice/print-notes']                = 'backoffice/Printing/print_notes';
$route['backoffice/print-application/(:num)']   = 'backoffice/Students/print_application/$1';

// Discount Menu
$route['backoffice/discount']                   = 'backoffice/Discount/index';
$route['backoffice/discount-packages']          = 'backoffice/Discount/discount_packages';
$route['backoffice/payment-heads']              = 'backoffice/Discount/payment_heads';
$route['backoffice/fee-defnition']              = 'backoffice/Discount/fee_defnition';
$route['backoffice/fee-head']                   = 'backoffice/Discount/fee_head';
$route['backoffice/basic-entity']               = 'backoffice/Courses/basic_entity';
$route['backoffice/course-mode']                = 'backoffice/Courses/course_mode';
$route['backoffice/city']                       = 'backoffice/Courses/city_listing';

$route['backoffice/manage-bus']                 = 'backoffice/Transport/index';
$route['backoffice/manage-route']               = 'backoffice/Transport/manage_route';
$route['backoffice/maintenance']                = 'backoffice/Transport/vehicle_maintenance';
$route['backoffice/transportation-fee-definition']= 'backoffice/Transport/transportation_fee_definition';
$route['backoffice/transport-fee-collection']   = 'backoffice/Transport/transport_fee_collection';


$route['backoffice/manage-leave']               = 'backoffice/Leave/index';
$route['backoffice/approval-list']              = 'backoffice/Leave/approval_list';


$route['backoffice/staff-list']                 = 'backoffice/Staff/index';
$route['backoffice/manage-faculty-availablity'] = 'backoffice/Staff/manage_faculty_availablity';
$route['backoffice/manage-staff']               = 'backoffice/Staff/manage_staff';
$route['backoffice/manage-faculty-attendance']  = 'backoffice/Staff/manage_faculty_attendance';

$route['backoffice/manage-staff/(:num)']        = 'backoffice/Staff/manage_staff/$1';
$route['backoffice/student-list']               = 'backoffice/Students/index';
$route['backoffice/manage-external-batch']      = 'backoffice/Students/external_batch';
$route['backoffice/manage-external-candidates'] = 'backoffice/Students/external_candidates';
$route['backoffice/manage-students/(:num)']     = 'backoffice/Students/manage_student_registration/$1';
$route['backoffice/manage-student']             = 'backoffice/Students/add_student_view';
$route['backoffice/register-student']           = 'backoffice/Students/add_student';
$route['backoffice/view-student']               = 'backoffice/Students/view_student';
$route['backoffice/view-student/(:num)']        = 'backoffice/Students/view_student/$1';
// $route['backoffice/download-idcard/(:num)']  = 'backoffice/Students/download_idcard/$1';
$route['backoffice/view-document/(:num)']       = 'backoffice/Employee/view_document/$1';
$route['backoffice/hallticket']                 = 'backoffice/Students/hallticket';
$route['backoffice/mentor']                     = 'backoffice/Students/mentor';
$route['backoffice/mentor/(:num)']                     = 'backoffice/Students/mentor/$1';

$route['backoffice/mentors-meeting']            = 'backoffice/Students/mentors_meeting';
$route['backoffice/mentors-meeting-list']       = 'backoffice/Students/mentors_meeting_list';

$route['backoffice/export-hallticket']          = 'backoffice/Students/export_hallticket';
// $route['backoffice/download-idcard/(:num)']     = 'backoffice/Students/download_idcard/$1';
$route['backoffice/view-document/(:num)']       = 'backoffice/Employee/view_document/$1';
$route['backoffice/student-reseipt']            = 'backoffice/Receipt';


$route['backoffice']                    = 'backoffice/Home';
$route['backoffice/sample-questions']   = 'backoffice/Content/sample_questions';

$route['backoffice/manage-batch']       = 'backoffice/Home/manage_batch';
$route['backoffice/batch-merge']        = 'backoffice/Home/batch_merge';
$route['backoffice/manage-fees']        = 'backoffice/Home/manage_fees';


$route['backoffice/upload-question-set-excel']  = 'backoffice/Questionbank/question_excel_upload';
$route['backoffice/material-management']        = 'backoffice/Questionbank/materials';
$route['backoffice/manage-materials']           = 'backoffice/Questionbank/materials';
$route['backoffice/create-question-set-single'] = 'backoffice/Questionbank/single';
$route['backoffice/create-question-set-group']  = 'backoffice/Questionbank/group';
$route['backoffice/update-question-set-group']  = 'backoffice/Questionbank/update_question';
$route['backoffice/question-bank']              = 'backoffice/Questionbank/question_bank';
$route['backoffice/question-set']               = 'backoffice/Questionbank/question_set';
$route['backoffice/study-material']             = 'backoffice/Questionbank/study_material';
$route['backoffice/add-study-material']         = 'backoffice/Questionbank/add_edit_study_material';
$route['backoffice/view-study-material']        = 'backoffice/Questionbank/view_study_material';
$route['backoffice/download-study-material/(:num)']     = 'backoffice/Pdfs/download_study_material/$1';

$route['backoffice/learning-module']                    = 'backoffice/Questionbank/learning_module';
$route['backoffice/create-learning-module']             = 'backoffice/Questionbank/create_learning_module'; 
$route['backoffice/schedule-learning-module']           = 'backoffice/Questionbank/schedule_learning_module'; 

$route['backoffice/exam-paper']                 = 'backoffice/Exam/list_exam_paper';
$route['backoffice/auto-generate-exam-paper']   = 'backoffice/Exam/auto_generate_exam_paper';
$route['backoffice/question-paper']             = 'backoffice/Exam/exam_paper';
$route['backoffice/exam-template']              = 'backoffice/Exam/exam_template';
$route['backoffice/exam-management']            = 'backoffice/Exam/exam_schedule';
$route['backoffice/exam-section']               = 'backoffice/Exam/exam_section';
$route['backoffice/exam-schedule']              = 'backoffice/Exam/exam_schedule';
$route['backoffice/logout']                     = 'backoffice/login/logout';

$route['backoffice/manage-buildings']                  = 'backoffice/Hostel/manage_buildings';
$route['backoffice/manage-floors']                     = 'backoffice/Hostel/manage_floors';
$route['backoffice/manage-roomtype']                   = 'backoffice/Hostel/manage_roomtype';
$route['backoffice/manage-rooms']                      = 'backoffice/Hostel/manage_rooms';
$route['backoffice/manage-roombooking']                = 'backoffice/Hostel/manage_roombooking';
$route['backoffice/manage-roombooking/(:num)']         = 'backoffice/Hostel/manage_roombooking/$1';
$route['backoffice/search-roombooking']                = 'backoffice/Hostel/search_roombooking';
$route['backoffice/search-roombooking/(:num)']         = 'backoffice/Hostel/search_roombooking/$1';
$route['backoffice/manage-hostelfee']                  = 'backoffice/Hostel/manage_hostelfee';
// $route['backoffice/export-batch-report']            = 'backoffice/Report/export_batch_report';
$route['schedules']                                    = 'backoffice/Calendar/view_schedules';

// Attendance
$route['backoffice/daily-attendance']                   = 'backoffice/Attendance/daily_attendance';

// Discount Approval
$route['backoffice/discount-approval']                  = 'backoffice/Approval/discount_approval';
$route['backoffice/maintenance-amount-approval']        = 'backoffice/Approval/maintenance_request_approval';

// Employee
$route['employee']                                      = 'backoffice/Employee';
$route['view-schedules']                                = 'backoffice/Employee/common_calendar';
$route['daily-schedule']                                = 'backoffice/Employee/daily_schedule';
$route['study-materials']                               = 'backoffice/Employee/studymaterials';
$route['backoffice/my-exam']    						= 'backoffice/Commoncontroller/my_exam_list';
$route['backoffice/progress-report']    				= 'backoffice/Commoncontroller/progress_report_list';
// Faculty
$route['Faculty']                                       = 'backoffice/Employee';

// Receptionist
$route['Receptionist']                                  = 'backoffice/Employee';

// Center Head
$route['Center-head']                                   = 'backoffice/Employee';

// Operation Head
$route['Operation-head']                                = 'backoffice/Employee';

//Course-coordinator
$route['Course-coordinator']                            = 'backoffice/Employee';

// Course-coordinator
$route['Employee']                                      = 'backoffice/Employee';


$route['backoffice/manage-holidays']                    = 'backoffice/Holidays/index';
$route['backoffice/supportive-services']                = 'backoffice/Asset/manage_supportive_services';
$route['backoffice/maintenance-type']                   = 'backoffice/Asset/manage_maintenance_type';
$route['backoffice/maintenance-services']               = 'backoffice/Asset/manage_maintenance_services';
$route['backoffice/view-maintenance-services']          = 'backoffice/Asset/manage_maintenance_service_requests';
$route['backoffice/manage-purchase-quotes']             = 'backoffice/Asset/manage_purchase_quotes';
$route['backoffice/Asset-category']                     = 'backoffice/Asset/index';
$route['backoffice/Asset']                              = 'backoffice/Asset/asset';


// $route['content-management']            = 'backoffice/Content/success_stories';


$route['institute-course-mapping']      = 'backoffice/Courses/institute_course_mapping';
$route['user-management']               = 'backoffice/usermanagement';
$route['usermanagement-users']          = 'backoffice/usermanagement/index';
$route['admin-change-password']         = 'backoffice/usermanagement/admin_change_password';
$route['usermanagement-permission']     = 'backoffice/usermanagement/permission';
$route['usermanagement-features']       = 'backoffice/usermanagement/features';
$route['define-permission/(:num)']      = 'backoffice/usermanagement/define_permission/$1';


$route['backoffice/change-password']    = 'backoffice/Commoncontroller/change_password';
$route['backoffice/homework']           = 'backoffice/Homework/index';
$route['backoffice/mentor-view']        = 'backoffice/Employee/mentor_view';


$route['backoffice/progress-reportlist']    = 'backoffice/Students/progress_report_list';
$route['backoffice/leave-scheme']           = 'backoffice/Leave_management/scheme';
$route['backoffice/staff-leave-status']     = 'backoffice/Leave_management/staff_leave_status';


$route['backoffice/salary-scheme']              = 'backoffice/salary/scheme';
$route['backoffice/salary-processing']          = 'backoffice/salary/salary_processing';
$route['backoffice/salary-advances']            = 'backoffice/salary/salary_advances';
$route['backoffice/view-attendance']            = 'backoffice/Employee/employee_attendance';
$route['backoffice/student-notification']       = 'backoffice/Notification/index';
$route['backoffice/staff-notification']         = 'backoffice/Notification/staff_notification';
$route['backoffice/users-password-reset']       = 'backoffice/Students/users_password_reset';
$route['backoffice/config-settings']            = 'backoffice/Config_settings/index';
$route['404_override']                          = 'custom404';
$route['translate_uri_dashes']                  = FALSE;
$route['backoffice/messenger']                  = 'backoffice/Messanger';
$route['messenger/(:num)']                      = 'user/Student/conversation/$1';
$route['backoffice/faculty-learning-module/(:num)']                                     = 'backoffice/Employee/print_notes/$1';
$route['backoffice/category']                                                           = 'backoffice/Content/category';
$route['direction-school-for-netjrf-examinations-syllabus/(:any)']                      = 'Home/syllabus_view/2/$1';
$route['direction-school-for-netjrf-examinations-previous-question/(:any)']             = 'Home/previous_question_view/2/$1';
$route['direction-school-for-psc-examinations-syllabus/(:any)']                         = 'Home/syllabus_view/3/$1';
$route['direction-school-for-psc-examinations-previous-question/(:any)']                = 'Home/previous_question_view/3/$1';
$route['direction-school-for-ssc-examinations-syllabus/(:any)']                         = 'Home/syllabus_view/4/$1';
$route['direction-school-for-ssc-examinations-previous-question/(:any)']                = 'Home/previous_question_view/4/$1';
$route['direction-school-of-banking-syllabus/(:any)']                                   = 'Home/syllabus_view/5/$1';
$route['direction-school-of-banking-previous-question/(:any)']                          = 'Home/previous_question_view/5/$1';
$route['direction-school-for-entrance-examinations-syllabus/(:any)']                    = 'Home/syllabus_view/7/$1';
$route['direction-school-for-entrance-examinations-previous-question/(:any)']           = 'Home/previous_question_view/7/$1';
$route['direction-junior-syllabus/(:any)']                                              = 'Home/syllabus_view/6/$1';
$route['direction-junior-previous-question/(:any)']                                     = 'Home/previous_question_view/6/$1';
$route['direction-school-for-rrb-examinations-syllabus/(:any)']                         = 'Home/syllabus_view/8/$1';
$route['direction-school-for-rrb-examinations-previous-question/(:any)']                = 'Home/previous_question_view/8/$1';
$route['direction-ias-study-circle-how-to-prepare']                                     = 'Home/how_to_prepare/1';
$route['direction-school-for-netjrf-examinations-how-to-prepare']                       = 'Home/how_to_prepare/2';
$route['direction-school-for-psc-examinations-how-to-prepare']                          = 'Home/how_to_prepare/3';
$route['direction-school-for-ssc-examinations-how-to-prepare']                          = 'Home/how_to_prepare/4';
$route['direction-school-of-banking-how-to-prepare']                                    = 'Home/how_to_prepare/5';
$route['direction-school-for-entrance-examinations-how-to-prepare']                     = 'Home/how_to_prepare/7';
$route['direction-junior-how-to-prepare']                                               = 'Home/how_to_prepare/6';
$route['direction-school-for-rrb-examinations-how-to-prepare']                          = 'Home/how_to_prepare/8';
$route['direction-ias-study-circle-general-studies/(:any)']                             = 'Home/general_studies/1/$1';
$route['result']                                                                        = 'Home/result';
$route['backoffice/material-approval']                                                  = 'backoffice/Approval/material_approval';
$route['backoffice/question-set-approval-levels']                                       = 'backoffice/Approval/material_approval_level/1';
$route['backoffice/learning-module-approval-levels']                                    = 'backoffice/Approval/material_approval_level/2';
$route['backoffice/exam-paper-approval-levels']                                         = 'backoffice/Approval/material_approval_level/3';
$route['approve-management']                                                            = 'backoffice/Employee/approve_management';
$route['approve-jobs/(:num)']                                                           = 'backoffice/Employee/approve_jobs/$1';
$route['view-question/(:num)']                                                          = 'backoffice/Employee/view_question/$1';
$route['backoffice/update-question-set-forapprovel-group']                              = 'backoffice/Employee/update_question';
$route['view-learning-module']                                                          = 'backoffice/Employee/create_learning_module';
$route['view-exam-paper']                                                               = 'backoffice/Employee/create_exam_paper';

/******************** Exam valuation **********************************************************************/

$route['backoffice/exam-valuation']                     = 'backoffice/Exam/exam_valuation';
$route['backoffice/exam-descriptive-questions/(:num)']  = 'backoffice/Exam/exam_descriptive_questions/$1';
$route['backoffice/get-single-question/(:num)/(:num)']  = 'backoffice/Exam/get_single_question/$1/$2';


/******************** Report **********************************************************************/ 

$route['backoffice/report']                     = 'backoffice/Report';
$route['backoffice/student-report']             = 'backoffice/Report/student_report';
$route['backoffice/staff-attendance-report']    = 'backoffice/Report/staff_attendance_report';
$route['backoffice/batch-schedule-report']      = 'backoffice/Report/batch_schedule_report';
$route['backoffice/facualty-allocated-report']  = 'backoffice/Report/facualty_allocated_report';
$route['backoffice/staff-leave-report']         = 'backoffice/Report/staff_leave_report';
$route['backoffice/exam-schedule-report']       = 'backoffice/Report/exam_schedule_report';
$route['backoffice/batch-wise-student']         = 'backoffice/Report/batch_wise_student';
$route['backoffice/exam-avgmark-report']        = 'backoffice/Report/exam_avgmark_report';
$route['backoffice/center-wise-fee-report']     = 'backoffice/Report/center_wise_fee_report';
$route['backoffice/student-attendance-report']  = 'backoffice/Report/student_attendance_report';
$route['backoffice/application-log']            = 'backoffice/Report/application_log';
$route['backoffice/application-log/(:num)']     = 'backoffice/Report/application_log';

/******************************** Payment **********************************************************/

$route['direction-online-payment/(:any)'] = 'Transactions/direction_online_payment/$1';

 
/********************************** Transaction *********************************************** */

//$route['payment/success']                    = 'Transactions/success';
//$route['payment/cancel']                    = 'Transactions/cancel';