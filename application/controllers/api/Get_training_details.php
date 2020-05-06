<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_training_details extends Direction_Controller {

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
    public function index($trainingId= NULL){
   
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
        $exist=$this->common->check_if_dataExist('am_batch_center_mapping',array("batch_id"=>$trainingId));
       // echo $this->db->last_query(); echo $exist;
        if($exist==0 && $trainingId!="") {
            $response['statusCode'] = 400;
            $response['status']     = FALSE;
            $response['message']    = 'Invalid request';
            $response['list']       = Null;
            print_r(json_encode($response));
            exit();
         }
        $data = [];
        $list1 = $this->Api_model->get_training_details($trainingId);
        if(empty($list1) && $trainingId=="") {
            $response['statusCode'] = 200;
            $response['status'] = TRUE;
            $response['message'] = 'No result found';
            $response['list'] = Null;
        } else {
            //$list1 = $this->Api_model->get_training_details($trainingId);
            $response['statusCode'] = 200;
            $response['status'] = TRUE;
            $response['message'] = 'Successfull';
            $response['list'] = '';
            $assessment_id = NULL;
            $data = [];
            foreach($list1 as $row) { 
                $userlist=$this->Api_model->get_user_details($row['training_id']);
                $userli="";
                $desig = [];
                foreach($userlist as $row1){
                    $desig[$row1['designation_id']] = [];
                    $userli="";
                    foreach($userlist as $row2){
                        if($row1['designation_id']==$row2['designation_id']) {
                        $userli.=$row2['userList'].',';
                        }
                    }
                    $desig[$row1['designation_id']] = rtrim($userli,',');
                }
                if($row['gm_exam_schedule_id']>0) {
                    $assessment_id = $row['gm_exam_schedule_id'];
                }
                if($row['is_communication_training']==1) {
                    $is_communication = $row['is_communication_training'];
                    $way_of_notify = $row['way_of_notify'];
                    $publish_date = date('Y-m-d', strtotime($row['publish_date']));
                } else {
                    $is_communication = '';
                    $way_of_notify = '';
                    $publish_date = '';
                }
               array_push($data, array(
                   'training_id'=>$row['training_id'],
                   'assessment_id'=>$assessment_id,
                   'training_name'=>$row['training_name'],
                   'areaId'=>$row['areaId'],
                   'course_id'=>$row['course_id'],
                   'course_name'=>$row['course_name'],
                   'course_title'=>"",
                   'icon_url'=>"",
                   'is_communication'=>$is_communication,
                   'way_of_notify'=>$way_of_notify,
                   'publish_date'=>$publish_date,
                   'user_List'=>$desig
               ));
          }
          $response['list'] = $data;
          print_r(json_encode($response));
        }        
    }

}
?>