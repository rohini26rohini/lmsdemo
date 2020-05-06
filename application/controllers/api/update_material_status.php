<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_material_status extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Api_model');
    //     $headers = getallheaders();
    //     if (array_key_exists("X-Auth-Token",$headers) && array_key_exists("X-UserId",$headers)) {
    //         $result = auth($headers['X-Auth-Token'],$headers['X-UserId']); 
    //     if($result=='SUCCESS') {

    //     } else {
    //         $response['statusCode']  = 401;
    //         $response['status']      = FALSE;
    //         $response['message']     = 'Authentication failed';
    //         print_r(json_encode($response));
    //         exit();
    //     }
    //     } else if (array_key_exists("x-auth-token",$headers) && array_key_exists("x-userid",$headers)) {
    //         $result = auth($headers['x-auth-token'],$headers['x-userid']); 
    //     if($result=='SUCCESS') {

    //     } else {
    //         $response['statusCode']  = 401;
    //         $response['status']      = FALSE;
    //         $response['message']     = 'Authentication failed';
    //         print_r(json_encode($response));
    //         exit();
    //     }
    // } else {
    //         $response['statusCode']  = 401;
    //         $response['status']      = FALSE;
    //         $response['message']     = 'Authentication failed';
    //         print_r(json_encode($response));
    //         exit();
    //     }
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
        $response['statusCode'] = 400;
        $response['status']     = FALSE;
        $response['message']    = 'Bad Request';
        $response['data']       = Null;
       
        if(array_key_exists("emp_id",$request)
         && array_key_exists("startPage",$request) 
          && array_key_exists("playedTime",$request) 
          && array_key_exists("is_material_viewed",$request) 
          && array_key_exists("material_id",$request) 
          && array_key_exists("training_id",$request))
        {  
        if($request->emp_id!='' && $request->material_id!='' && $request->training_id!='') {
            if($request->is_material_viewed) {
                $is_material_viewed = 1;
            } else {
                $is_material_viewed = 0;
            }
            $data = array("emp_id"=>$request->emp_id,
                            "material_id"=>$request->material_id,
                            "training_id"=>$request->training_id,
                            "is_material_viewed"=>$is_material_viewed,
                            "playedTime"=>$request->playedTime,
                            "startPage"=>$request->startPage,
                            "status"=>1
                    );
            $check = $this->Api_model->check_material_status($request->emp_id, $request->material_id, $request->training_id);        
            if(!empty($check)) {
                $result = $this->Api_model->update_material_status($data);  
            } else {
                $traindata = array('training_id'=>$request->training_id,
                                    'emp_id'=>$request->emp_id,
                                    'status'=>0,
                                    );  
                $result = $this->Api_model->insert_material_status($data); 
             $traning_status = $this->common->get_from_tableresult('traning_status', array('emp_id'=>$request->emp_id,
                       'training_id'=>$request->training_id
                       ));
               if(empty($traning_status)){   
                   $result = $this->Api_model->insert_training_status($traindata);       
               }   
            }    
            
            if($result) {  
                $percentage = 0;
                $messge = 'Material view status updated successfully';
                $studentDet = $this->Api_model->get_student_course_by_trainid($request->training_id);
                if(!empty($studentDet)) {
                //$listmaterial = $this->common->get_from_tableresult('mm_study_material', array('material_id'=>$studentDet->course_id));
                $materials = $this->common->get_from_tableresult('mm_subjects', array('course_id'=>$studentDet->course_id, 'subject_status'=>1));
                $subjectArr = [];
                if(!empty($materials)) {
                    foreach($materials as $material) {
                        array_push($subjectArr, $material->subject_id);
                    }
                }
                $listmaterial = $this->user_model->get_course_materials($subjectArr); print_r($listmaterial);
                $totalmaterial = count($listmaterial);
                if(!empty($listmaterial)) {
                    $cnt = 0;
                    $done = 0;
                    foreach($listmaterial as $material) {  print_r($material);
                        // if($material->id )
                        $materialstatus = $this->common->get_from_tableresult('mm_emp_material_view_status', array('emp_id'=>$request->emp_id,
                        'material_id'=>$material->id,
                        'training_id'=>$request->training_id
                        ));
                        if(empty($materialstatus)) {
                            $cnt++;
                        } else {
                            $done++;
                        }
                        if($done>0) {
                            $div = $done/$totalmaterial;
                            $percentage = $div*100;
                        }
                    }
                    if($cnt<1) {
                        $traindata = array('status'=>1);
                        $update_train = $this->Api_model->update_training_status($request->training_id, $request->emp_id, $traindata);
                        if($update_train) {
                            $messge = "Training successfully completed";
                        }
                    }
                } 
                }
                $response['statusCode'] = 200;
                $response['status']     = TRUE;
                $response['message']    = $messge;
                $response['data']       = array('training_completion'=>$percentage.'%');
            } else {
                $response['statusCode'] = 500;
                $response['status']     = FALSE;
                $response['message']    = 'Internal server error';
                $response['data']       = Null;
            }
        }
    }else{
        $response['statusCode']  = 400;
        $response['status']      = FALSE;
        $response['message']     = 'Invalid request';
    }
        print_r(json_encode($response));
   
        // header("Content-type: text/json");
        // $myObj='{
        //     "status": true,
        //     "message": "Material view status updated successfully",
        //     "data": {
        //         "training_completion": "10%"
        //     }
        // }
        // ';
        // echo $myObj;
    }
} 
?>