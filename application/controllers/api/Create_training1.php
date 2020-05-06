<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_training extends Direction_Controller {

    public function __construct() {
        parent::__construct();
      }
    public function index(){
      try{
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Headers: "Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token"');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
          $postdata = file_get_contents("php://input");
          $request = json_decode($postdata);
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
          $data     = array('institute_course_mapping_id'=>$institute_course_mapping_id,
                                  'batch_datefrom'=>date('d-M-y'),
                                  'batch_dateto'=>date('d-M-y',strtotime('31-DEC-99')),
                                  'batch_name'=>$request->training_name,
                                  'batch_mode'=>1,
                                  'batch_status'=>1,
                                  'batch_capacity'=>50000,
                                  'last_date'=>date('d-M-y',strtotime('31-DEC-99'))
                                 ); 
                $data['monday']     = TRUE;
                $data['tuesday']    = TRUE;
                $data['wednesday']  = TRUE;
                $data['thursday']   = TRUE;
                $data['friday']     = TRUE;
                $data['saturday']   = TRUE;
                $data['sunday']     = TRUE; 
                $existbatch = $this->common->get_from_tablerow('am_batch_center_mapping', array('institute_course_mapping_id'=>$institute_course_mapping_id));
                if(!empty($existbatch)) {
                  $batch_id = $existbatch['batch_id'];
                } else {
                  $batch_id = $this->Batch_model->insert_batchdetails($data,$_POST);
                }
                $branch_id=2;
                $center_id=3;
                $existstudArr = [];
                $newstudArr   = [];
                $existingstud = $this->common->get_from_tableresult('am_student_course_mapping', array('batch_id'=>$batch_id, 'status'=>1));
                foreach($emp_list as $list) { 
                  array_push($newstudArr, $list->emp_id);
                  $exist = $this->common->get_from_tablerow('am_students', array('student_id'=>$list->emp_id));
                  if(empty($exist)) {
                  $result = $this->employee_enroll($list, $institute_course_mapping_id, $center_id, $course_id, $branch_id, $batch_id);
                  } else { 
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
          } else {
              $myObj['statusCode']  = 400;
              $myObj['status']      = FALSE;
              $myObj['message']     = 'Invalid request';
              $myObj['data']        = NULL;
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
      catch(Exception $e) 
      {
              $myObj['statusCode']  = 400;
              $myObj['status']      = FALSE;
              $myObj['message']     = 'Invalid request';
              $myObj['data']        = NULL;
              print_r(json_encode($myObj));
      }
} 


function employee_deactive($student_id = NULL, $batch_id= NULL) {
  $mapp = array(
    'student_id'                     => $student_id,
    'batch_id'                      => $batch_id
  );
  $this->db->where($mapp);
  return $this->db->update('am_student_course_mapping',array('status'=>4));
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
  array_push($studentArr,array(
    'student_id'        => !empty($employee) ? $employee->emp_id : '',
    'name'              => !empty($employee) ? $employee->emp_name : '',
    'gender'            => !empty($employee) ? 'male' : '',
    'address'           => !empty($employee) ? $employee->role : '',
    'street'            => !empty($employee) ? "oman" : '',
    'state'             => !empty($employee) ? '17' : '',
    'district'          => !empty($employee) ? 1668 : '',
    'contact_number'    => !empty($employee) ? rand() : '',
    'whatsapp_number'   => !empty($employee) ? rand() : '',
    'mobile_number'     => !empty($employee) ? rand() : '',
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