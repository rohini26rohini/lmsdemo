<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_training extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        $headers = getallheaders();
        if (array_key_exists("X-Auth-Token",$headers) && array_key_exists("X-UserId",$headers)) {
            $result = auth($headers['X-Auth-Token'],$headers['X-UserId']); 
            $this->userid = $headers['X-UserId'];
        if($result=='SUCCESS') {

        } else {
            $response['statusCode']  = 401;
            $response['status']      = FALSE;
            $response['message']     = 'Authentication failed';
            print_r(json_encode($response));
            exit();
        }
        } else if (array_key_exists("x-auth-token",$headers) && array_key_exists("x-userid",$headers)) {
          $result = auth($headers['x-auth-token'],$headers['x-userid']); 
          $this->userid = $headers['x-userid'];
        if($result=='SUCCESS') {

        } else {
            $response['statusCode']  = 401;
            $response['status']      = FALSE;
            $response['message']     = 'Authentication failed';
            print_r(json_encode($response));
            exit();
        }
    } else {
            $response['statusCode']  = 401;
            $response['status']      = FALSE;
            $response['message']     = 'Authentication failed';
            print_r(json_encode($response));
            exit();
        }
      }
    public function index(){
      if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    } else {
        header("Access-Control-Allow-Origin: *");  
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");      
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    header("Content-Type: application/json; charset=UTF-8"); 
          $postdata = file_get_contents("php://input");
          $request = json_decode($postdata);
          // if (array_key_exists("training_name",$request) && array_key_exists("course_id",$request) && 
          // array_key_exists("emp_list",$request) && array_key_exists("emp_id",$request) && 
          // array_key_exists("emp_name",$request) && array_key_exists("role",$request)) 
          // {
            if (array_key_exists("training_name",$request) && array_key_exists("course_id",$request) && 
            array_key_exists("emp_list",$request) ) 
          {
            $emp_exist=$this->common->check_if_dataExist('am_course_mapping',array("course_id"=>$request->course_id));
            if($emp_exist==0){
                $myObj['statusCode'] = 400;
                $myObj['status'] = false;
                $myObj['message'] = 'Invaild Course Id';
                print_r(json_encode($myObj));
                exit();
            }
            $training_id = '';
            if (array_key_exists("training_id",$request)) {
              $training_id = $request->training_id;
            }

            $areaID = 0;
            if (array_key_exists("areaID",$request)) {
              $areaID = $request->areaID;
            }
          
          if($request->course_id!='' && !empty($request->emp_list)) {
            $course_id = $request->course_id;
            $emp_list  = $request->emp_list;
          //die();
          $courseDetails            = $this->common->get_from_tablerow('am_course_mapping', array('course_id'=>$course_id));
          $question_id              = $this->input->post('question_id');
          $exam_sections_id         = (!empty($courseDetails)?$courseDetails['exam_sections_id']:'');
          $question_set             = (!empty($courseDetails)?$courseDetails['question_set_id']:'');
          $exam_definition_id       = (!empty($courseDetails)?$courseDetails['exam_definition_id']:'');
          $question_paper_id        = (!empty($courseDetails)?$courseDetails['question_paper_id']:'');
          $material_id              = (!empty($courseDetails)?$courseDetails['material_id']:'');
          $module_id                = (!empty($courseDetails)?$courseDetails['module_id']:'');
          $subject_id               = (!empty($courseDetails)?$courseDetails['subject_id']:'');
          $institute_course_mapping_id       = (!empty($courseDetails)?$courseDetails['institute_course_mapping_id']:'');
          if($institute_course_mapping_id=='' && $exam_sections_id == '' && $exam_definition_id =='' && $question_set = '') {
              $myObj['statusCode']  = 400;
              $myObj['status']      = FALSE;
              $myObj['message']     = 'Bad request';
              print_r(json_encode($myObj));
              exit();
          }
          $is_communication = 0;
          $way_of_notify = NULL;
          $publish_date = NULL;
          if (array_key_exists("is_communication",$request) && $request->is_communication==1) {
            $is_communication = 1;
            $way_of_notify = $request->way_of_notify;
            $publish_date = date('d-M-y',strtotime($request->publish_date));
          }
          $data     = array('institute_course_mapping_id'=>$institute_course_mapping_id,
                                  'batch_datefrom'=>date('Y-m-d'),
                                  'batch_dateto'=>date('Y-m-d',strtotime('31-DEC-99')),
                                  'batch_name'=>$request->training_name,
                                  'batch_mode'=>1,
                                  'batch_status'=>1,
                                  'batch_capacity'=>$areaID,
                                  'publish_date'=>$publish_date,
                                  'way_of_notify'=>$way_of_notify,
                                  'is_communication'=>$is_communication,
                                  'created_by'=>$this->userid,
                                  'created_date'=>date('Y-m-d'),
                                  'last_date'=>date('Y-m-d',strtotime('31-DEC-99'))
                                 ); 
                $data['monday']     = TRUE;
                $data['tuesday']    = TRUE;
                $data['wednesday']  = TRUE;
                $data['thursday']   = TRUE;
                $data['friday']     = TRUE;
                $data['saturday']   = TRUE;
                $data['sunday']     = TRUE; 
                //$existbatch = $this->common->get_from_tablerow('am_batch_center_mapping', array('institute_course_mapping_id'=>$institute_course_mapping_id));
                //if(!empty($existbatch)) {
                if($training_id!='') {
                  //$batch_id = $existbatch['batch_id'];
                  $batch_id = $training_id;
                  $this->Api_model->delete_emp_course_mapping($batch_id); 
                  $this->gm_exam_schedule($batch_id, $request->training_name, $exam_definition_id, $question_paper_id);
                  $this->Api_model->update_training_data($batch_id, array('batch_name'=>$request->training_name,
                                                                            'publish_date'=>$publish_date,
                                                                            'way_of_notify'=>$way_of_notify,
                                                                            'modified_by'=>$this->userid,
                                                                            'modified_date'=>date('Y-m-d'),
                                                                            'is_communication'=>$is_communication)
                                                                          );
                } else {
                  $batch_id = $this->Batch_model->insert_batchdetails($data,$_POST);
                  $this->gm_exam_schedule($batch_id, $request->training_name, $exam_definition_id, $question_paper_id);
                }
                $branch_id=2;
                $center_id=3;
                $existstudArr = [];
                $newstudArr   = [];
                //$existingstud = $this->common->get_from_tableresult('am_student_course_mapping', array('batch_id'=>$batch_id, 'status'=>1));
                $existingstud = $this->Api_model->get_exist_student_batch($batch_id); 
                $areaID = rand();
                foreach($emp_list as $list) { 
                  $result = true;
                  array_push($newstudArr, $list->emp_id);
                  $exist = $this->common->get_from_tablerow('am_students', array('student_id'=>$list->emp_id));
                  if(empty($exist)) { 
                  $result = $this->employee_enroll($list, $institute_course_mapping_id, $center_id, $course_id, $branch_id, $batch_id);
                  } else { 
                    $this->Api_model->update_empdata($list->emp_id, $list->emp_name, $list->designation_Id, $areaID);
                    if(!empty($existingstud)) { 
                      foreach($existingstud as $stud) {  
                        array_push($existstudArr,$stud->student_id);
                      }
                      if (!in_array($list->emp_id, $existstudArr))
                      { 
                        $result = $this->update_training($list->emp_id, $institute_course_mapping_id, $center_id, $course_id, $branch_id, $batch_id);
                      }

                    } else {
                      $result = $this->update_training($list->emp_id, $institute_course_mapping_id, $center_id, $course_id, $branch_id, $batch_id);
                    }
                  }
                  //die();
                  
                }
                foreach($existingstud as $stud) { 
                  if (!in_array($stud->student_id, $newstudArr))
                    {
                      $result = $this->employee_deactive($stud->student_id, $batch_id);
                    }
                }
               
                if($result) {
                  $myObj['statusCode']  = 200;
                  $myObj['status']      = TRUE;
                  $myObj['message']     = 'Employees assigned to training successfully';
                  $myObj['data']        = NULL;
                } else {
                  $myObj['statusCode']  = 500;
                  $myObj['status']      = FALSE;
                  $myObj['message']     = 'Internal server error';
                  $myObj['data']        = NULL;
                }
              }
            } else {
              $myObj['statusCode']  = 400;
              $myObj['status']      = FALSE;
              $myObj['message']     = 'Bad request';
              print_r(json_encode($myObj));
              exit();
          }
        // $myObj='{
        //     "statusCode": 200,
        //     "status": true,
        //     "message": "Employees assigned to training successfully",
        //     "data": null
        // }
        // ';
        print_r(json_encode($myObj));
       
} 


function employee_deactive($student_id = NULL, $batch_id= NULL) {
  $mapp = array(
    'student_id'                     => $student_id,
    'batch_id'                      => $batch_id
  );
  $this->db->where($mapp);
  return $this->db->update('am_student_course_mapping',array('status'=>4));
}



function gm_exam_schedule($batch_id = NULL, $training_name = NULL, $exam_definition_id = NULL, $question_paper_id = NULL) {
  //--------------------------------------------------
  $schedule_data = array(
    'batch_id'=>$batch_id,
    'end_date_time'=>date('Y-m-d H:i:s',strtotime('2035-12-30 00:00:00')),
    'start_date_time'=>date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s"))),
    'name'=>$training_name,
    'no_of_attempts'=>0,
    'no_of_question_papers'=>1,
    'result_immeadiate'=>1,
    'status'=>1,
    'version'=>1,
    'exam_definition_id'=>$exam_definition_id
  );
  $schedule_id = $this->exam_model->add_exam_schedule($schedule_data);
  $room_id = $this->Api_model->create_room();
  $calendar_data=array(
    'schedule_type'=>1,
    'schedule_link_id'=>$schedule_id,
    'schedule_status'=>1,
    'schedule_date'=>date('Y-m-d'),
    'schedule_start_time'=>date('H:i:s',strtotime(date("Y-m-d H:i:s"))),
    'schedule_end_time'=>date('H:i:s',strtotime(date('2035-12-30 23:30:30'))),
    'schedule_room'=>$room_id,
    'schedule_description'=>'Exam - '.$training_name
  );
  $this->exam_model->add_exam_schedule_calendar($calendar_data); 
      $schedule_paper_data=array(
        'question_paper_id'=>$question_paper_id,
        'exam_schedule_id'=>$schedule_id,
        'version'=>1
      );
  $res = $this->exam_model->add_exam_schedule_papers($schedule_paper_data); // Add question papers for exam schedule
  
  $this->Api_model->update_mapping($question_paper_id, array('gm_exam_schedule_id'=>$schedule_id));
//------------------------------------------------------
}



function update_training($student_id = NULL, $institute_course_mapping_id = NULL, $center_id = NULL, $course_id = NULL, $branch_id = NULL, $batch_id= NULL) {
  $mapp = array(
    'institute_course_mapping_id'   => $institute_course_mapping_id,
    'student_id'                     => $student_id,
    'course_id'                     => $course_id,
    'branch_id'                     => $branch_id,
    'center_id'                     => $center_id,
    'batch_id'                      => $batch_id,
    'status '                       => 1
  );
  return $this->db->insert('am_student_course_mapping',$mapp); 
}



function employee_enroll($employee = array(), $institute_course_mapping_id = NULL, $center_id = NULL, $course_id = NULL, $branch_id = NULL, $batch_id= NULL) {
  //insertion
  $studentArr = [];
  $qualificationArr1 = [];
  $qualificationArr2 = [];
  $qualificationArr3 = [];
  $qualificationArr4 = [];
  $mapArr = [];
  $role = 'Role';
  $designation_Id = rand();
  $areaID = 0;
  if (array_key_exists("role",$employee)) {
    $role = $employee->role;
  }
  if (array_key_exists("designation_Id",$employee)) {
    $designation_Id = $employee->designation_Id;
  }
  if (array_key_exists("areaID",$employee)) {
    $areaID = $employee->areaID;
  }
  array_push($studentArr,array(
    'student_id'        => !empty($employee) ? $employee->emp_id : '',
    'name'              => !empty($employee) ? $employee->emp_name : '',
    'gender'            => !empty($employee) ? 'male' : '',
    'address'           => $role,
    'street'            => !empty($employee) ? "oman" : '',
    'state'             => !empty($employee) ? '17' : '',
    'district'          => !empty($employee) ? 1668 : '',
    'contact_number'    => !empty($employee) ? $designation_Id : '',    // Employee designation_Id
    'whatsapp_number'   => !empty($employee) ? rand() : '',
    'mobile_number'     => !empty($employee) ? $areaID : '',            // Area ID
    'guardian_name'     => !empty($employee) ? "ooredoo emp" : '',
    'guardian_number'   => !empty($employee) ? rand() : '',
    'email'             => !empty($employee) ? rand().'@getnada.com' : '',
    'date_of_birth'     => !empty($employee) ? '1984-04-21' : '',
    'hostel'            => !empty($employee) ? '' : '',
    'blood_group'       => !empty($employee) ? 'Not Available' : '',
    'stayed_in_hostel'  => !empty($employee) ? '' : '',
    'food_habit'        => !empty($employee) ? '' : '',
    'transportation'    => !empty($employee) ? '' : '',
    'transportation'    => !empty($employee) ? '' : '',
    'admitted_date'     => !empty($employee) ? date('Y-m-d') : '2019-01-01',
    'trans_start_date'  => !empty($employee) ? date('Y-m-d') : '2019-01-01',
    'verified_status '  => 1,
    'status '           => 1
));
array_push($qualificationArr1,array(
    'category'          => "sslc",
    'qualification'     => 'sslc',
    'marks'             => 70
));
array_push($qualificationArr2,array(
    'category'          => "plustwo",
    'qualification'     => "plustwo",
    'marks'             => 70
));
array_push($qualificationArr3,array(
    'category'          => "degree",
    'qualification'     => "degree",
    'marks'             => 70
));
array_push($qualificationArr4,array(
    'category'          => "pg",
    'qualification'     => "pg",
    'marks'             => 70
));
array_push($mapArr,array(
    'institute_course_mapping_id'   => $institute_course_mapping_id,
    'course_id'                     => $course_id,
    'branch_id'                     => $branch_id,
    'center_id'                     => $center_id,
    'batch_id'                      => $batch_id,
    'status '                       => 1
));
$insert_stat = $this->user_model->insert_data($studentArr,$qualificationArr1,$qualificationArr2,$qualificationArr3,$qualificationArr4,$mapArr);
if($insert_stat==1) {
  return true;
} else {
  return false;
}
}

}
?>