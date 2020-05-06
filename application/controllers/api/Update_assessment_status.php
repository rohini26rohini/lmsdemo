<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_assessment_status extends Direction_Controller {

    public function __construct() {
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
    try{
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
      if (array_key_exists("emp_id",$request) && array_key_exists("assessment_id",$request) && array_key_exists("status",$request) )
        {
            $emp_id=$request->emp_id;
            $assessment_id=$request->assessment_id;
            $status=$request->status;
        $emp_exist=$this->common->check_if_dataExist('am_students',array("student_id"=>$emp_id,"status"=>1));
        if($emp_exist==0){
            $myObj['statusCode'] = 400;
            $myObj['status'] = TRUE;
            $myObj['message'] = 'Invaild emp_id';
            print_r(json_encode($myObj));
            exit();
        }
        $exist=$this->common->check_if_dataExist('assessment',array("emp_id"=>$emp_id,"assessment_id"=>$assessment_id,"status"=>$status));        
        $attempt_count = $this->Api_model->get_attemptcount($emp_id,$assessment_id);

         if(empty($attempt_count)){
            $attempt=0;
         }else{ $attempt=$attempt_count; }

        $data_details=array('assessment_id'=>$assessment_id,
        'emp_id'=>$emp_id,
        'status'=>$status,
        'attempt'=>1+$attempt
            );

        $data=array('assessment_id'=>$assessment_id,
            'emp_id'=>$emp_id,
            'status'=>$status
        );

        if($exist==0){
            if($status==2){
                $result=$this->Api_model->update_assessment($emp_id,$assessment_id);
            }
            else{
                $result=$this->Api_model->insert_assessment($data);
            }
            $result=$this->Api_model->insert_assessment_details($data_details);
        }else{
            $result=$this->Api_model->insert_assessment_details($data_details); 
        } 
        }
        else{
            $myObj['statusCode']  = 400;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Invalid request';
            print_r(json_encode($myObj));
            exit();
        }
        if($result) {
            $myObj['statusCode']  = 200;
            $myObj['status']      = TRUE;
            $myObj['message']     = 'Assessment status updated successfully';
           
          } else {
            $myObj['statusCode']  = 500;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Internal server error';
          
          }
        }
        catch (RequestException  $e) {
            $myObj['statusCode']  = 400;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Invalid request';
         
        }
          print_r(json_encode($myObj));

      }



//     public function index(){
// header("Content-type: text/json");
// $myObj='{
//     "statusCode": 200,
//     "status": true,
//     "message": "Assessment assigned successfully"
// }
// ';
// echo $myObj;
//     }
}
?>