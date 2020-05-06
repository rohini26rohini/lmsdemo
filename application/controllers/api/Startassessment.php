<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StartAssessment extends Direction_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Api_model');
        $headers = getallheaders();
        if (array_key_exists("X-Auth-Token",$headers) && array_key_exists("X-UserId",$headers)) {
            $result = auth($headers['X-Auth-Token'],$headers['X-UserId']); 
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
        //   if (array_key_exists("emp_id",$request->key) && array_key_exists("assessment_id",$$request->key) )
        //   {
          $emp_id=$request->key->emp_id;
          $assessment_id=$request->key->assessment_id;
          $status=1;
          $emp_exist=$this->common->check_if_dataExist('am_students',array("student_id"=>$emp_id,"status"=>1));
          if($emp_exist==0){
              $myObj['statusCode'] = 400;
              $myObj['status'] = TRUE;
              $myObj['message'] = 'Invaild Emp_id';
              print_r(json_encode($myObj));
              exit();
          }
          $exist=$this->common->check_if_dataExist('orido_exam_log',array("emp_id"=>$emp_id,"assessment_id"=>$assessment_id,"status"=>$status));        
         
          $attempt_count = $this->Api_model->get_attemptcount_startass($emp_id,$assessment_id);
          
           if(empty($attempt_count)){
              $attempt=0;
           }else{  $attempt=$attempt_count; }
  
         
          $data=array('assessment_id'=>$assessment_id,
          'emp_id'=>$emp_id,
          'attempt'=>1,
          'end_time '=>0,
          'start_time'=>time(),
          'status'=>1
          );
          $updatedata=array('assessment_id'=>$assessment_id,
          'emp_id'=>$emp_id,
          'attempt'=>1+$attempt,
          'end_time '=>0,
          'start_time'=>time(),
          'status'=>1
          );
        //  print_r($updatedata);
          $insert=array(
            'emp_id'=>$emp_id,
            'assessment_id'=>$assessment_id,
            'attempt'=>$attempt+1
          );
         
          if($exist!=0){
            $result=$this->Api_model->insert_startassessment($updatedata);
        }else{
            $result=$this->Api_model->insert_startassessment($data); 
        } 
    // }
    // else{
    //     $myObj['statusCode']  = 400;
    //     $myObj['status']      = FALSE;
    //     $myObj['message']     = 'Invalid request';
    //     print_r(json_encode($myObj));
    //     exit();
    // }
         if($result) {
            $myObj['statusCode']  = 200;
            $myObj['status']      = TRUE;
            $myObj['message']     = 'Assessment status  successfully';
            $myObj['data']['key']        =  $insert;
            $myObj['data']['starttime']        = time();
            $myObj['data']['end_time']        =  0;
            $myObj['data']['status']        =  "STARTED";
           
          } else {
            $myObj['statusCode']  = 500;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Invaild Request';
          
          }
         print_r(json_encode($myObj));
} 

}
?>