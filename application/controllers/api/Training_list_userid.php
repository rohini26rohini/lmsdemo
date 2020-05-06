<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training_list_userid extends Direction_Controller {

    public function __construct() {
        parent::__construct();
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
    public function index($userId = NULL, $is_communication = NULL){
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
        $userId =$this->uri->segment(3);
        $is_communication =$this->uri->segment(4);
        try{ 
        if($userId>0 && $is_communication!='') {
            $results = $this->Api_model->get_student_trainings($userId, $is_communication);
            if(!empty($results)) {
                $response['statusCode'] = 200;
                $response['status'] = TRUE;
                $response['message'] = 'Successfull';
                $data = [];
                $assessment_id = NULL;
                foreach($results as $list) { 
                    if($list->gm_exam_schedule_id>0) {
                        $assessment_id = $list->gm_exam_schedule_id;
                    }
                    $totalMaterial = 0;
                    $course_id = $list->course_id;
                    $materials = $this->common->get_from_tableresult('mm_study_material', array('module_id'=>$course_id));
                    if(!empty($materials)) {
                    $totalMaterial = count($materials);
                    }
                    $prograss = ''; 
                    $percentage = 0;
                    $materialStatus = $this->Api_model->check_material_emp_status($userId, $list->batch_id);
                    if(!empty($materialStatus)) {
                        $prograss = "TRAINING IN PROGRESS";
                        $completedCnt = count($materialStatus);
                        $val = $completedCnt/$totalMaterial;
                        $percentage = $val*100;
                        if($percentage>0) {
                            $percentage = number_format($percentage,2);
                        }
                    }
                    $tranStatus = $this->Api_model->get_training_status($list->batch_id, $userId);
                    if(!empty($tranStatus)) {
                        $prograss = "TRAINING COMPLETED";
                        $percentage = 100;
                    }
                    $assessStatus = $this->Api_model->get_assessment_status($assessment_id, $userId);
                    if(!empty($assessStatus)) {
                        $prograss = "ASSESSMENT COMPLETED";
                        $percentage = 100;
                    }
                    $appStatus = $this->Api_model->get_assessment_appstatus($assessment_id, $userId);
                    if(!empty($appStatus)) {
                        $prograss = "DOWNLOAD CERTIFICATE";
                        $percentage = 100;
                    }
                    array_push($data, array('training_id'=>$list->batch_id,
                                            'training_name'=>$list->batch_name,
                                            'course_id'=>$list->class_id,
                                            'course_name'=>$list->class_name,
                                            'assessment_id'=>$assessment_id,
                                            'status'=>$prograss,
                                            'percentage'=>$percentage,
                                            'created_date'=>date('d/m/Y H:i:s', strtotime($list->batch_creationdate))
                                        ));
                }
                $response['list'] = $data;
            } else {
                $response['statusCode'] = 200;
                $response['status']     = TRUE;
                $response['message']    = 'No result found';
                $response['list']       = Null;
            }
        } else {
            $response['statusCode'] = 400;
            $response['status']     = FALSE;
            $response['message']    = 'Bad Request';
            $response['list']       = Null;
        }
        print_r(json_encode($response));
        } catch (Exception $e){
            print_r(json_encode($response));
        }
// header("Content-type: text/json");
// $myObj='{
//     "statusCode": 200,
//     "status": true,
//     "message": "successfull",
//     "list": [
//         {
//             "training_id": "1",
//             "training_name": "New Shababiah digital sim",
//             "course_id": "11",
//             "course_name": "Android",
//             "course_title": "Learn how to customize the color",
//             "icon_url": "http://gbs-plus-test.info/lms/photos/courseicon1.png",
//             "status": "in_progress",
//             "percentage": "20",
//             "createdDate": "20-1-20 10:05:35"
//         },
//         {
//             "training_id": "2",
//             "training_name": "Shababiah sim",
//             "course_id": "13",
//             "course_name": "php",
//             "course_title": "Learn how to customize the color",
//             "icon_url": "http://gbs-plus-test.info/lms/photos/courseicon1.png",
//             "status": "in_progress",
//             "percentage": "20",
//             "createdDate": "20-1-20 10:05:35"
//         }
//     ]
// }
// ';
// echo $myObj;
    }
}

?>