<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assigned_trainings extends Direction_Controller {

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
    public function index(){
        //header("Access-Control-Allow-Origin: http://10.0.14.40:9985");
        // header("Access-Control-Allow-Origin: *");
        // header("Content-Type: application/json; charset=UTF-8");
        // header("Access-Control-Allow-Credentials: true");
        // header("Access-Control-Max-Age: 1000");
        // header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
        // header("Access-Control-Allow-Methods: PUT, POST, GET");
        //echo $_SERVER['HTTP_ORIGIN']."HTTP_ORIGIN";
        // if (isset($_SERVER['HTTP_ORIGIN'])) {
        // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        // } else {
        //     header("Access-Control-Allow-Origin: *");    
        // }
        // header("Content-Type: application/json; charset=UTF-8");
        // header('Access-Control-Allow-Credentials: true');
        // header('Access-Control-Max-Age: 86400');    // cache for 1 day
        // header("Access-Control-Allow-Methods: GET, POST, OPTIONS");   
        //header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
        // Allow from any origin
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
        $is_communication = '100';
        try{
        if(!isset($_GET['page']) || !isset($_GET['size']) || !isset($_GET['sort']) || !isset($_GET['order'])) {
            $response['statusCode'] = 400;
            $response['status']     = FALSE;
            $response['message']    = 'In valid request';
            $response['list']       = Null;
        } else {
        $page      = (int)$_GET['page'];
        $size      = (int)$_GET['size'];
        $sort      = $_GET['sort'];
        $order     = $_GET['order'];
        $keyword   = $_GET['keyword'];
        if(isset($_GET['is_communication'])) {
            $is_communication = $_GET['is_communication'];
        } 
        // COURSE LIST
        $totalPages = 0;
        $data = [];
        $totalElements = $this->Api_model->get_training_list_count($keyword, $is_communication);
        if($totalElements>0) {
            $totalPages = $totalElements/$size;
            if($totalPages<=1) {
                $totalPages = 0;
            } else {
                $totalPages -= 1;
            }
        }
        $courselist = $this->Api_model->get_training_list($page, $size, $sort, $order, $keyword, $is_communication);
        if(!empty($courselist)) {
            $response['statusCode'] = 200;
            $response['status'] = TRUE;
            $response['message'] = 'Successfull';
            $response['page'] = $page-1;
            $response['size'] = $size;
            $response['totalElements'] = $totalElements;
            $response['totalPages'] = $totalPages;
            $response['last'] = false;
            if($totalPages==$page){
            $response['last'] = true;
            }
            $assessment_id = NULL;
            foreach($courselist as $list) { 
                if($list->gm_exam_schedule_id>0) {
                    $assessment_id = $list->gm_exam_schedule_id;
                }
                if($list->is_communication==1) {
                    $publish_date = date('Y-m-d', strtotime($list->publish_date));
                    $way_of_notify = $list->way_of_notify;
                    $is_communication = $list->is_communication;
                } else {
                    $publish_date = "";
                    $way_of_notify = "";
                    $is_communication = "";
                }
                array_push($data, array('training_id'=>$list->batch_id,
                                        'training_name'=>$list->batch_name,
                                        'course_id'=>$list->class_id,
                                        'course_name'=>$list->class_name,
                                        'assessment_id'=>$assessment_id,
                                        'is_communication'=>$is_communication,
                                        'way_of_notify'=>$way_of_notify,
                                        'publish_date'=>$publish_date,
                                        'created_date'=>date('d-m-Y H:i:s', strtotime($list->batch_creationdate))
                                    ));
            }
            $response['list'] = $data;
        } else {
            $response['statusCode'] = 200;
            $response['status'] = TRUE;
            $response['message'] = 'No result found';
            $response['list'] = Null;
        }
    }
        print_r(json_encode($response));
        } catch (Exception $e){
            print_r(json_encode($response));
        }
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
        //             "created_date": "20/1/2020 10:05:56"
        //         },
        //         {
        //             "training_id": "2",
        //             "training_name": "Shababiah 3G sim",
        //             "course_id": "21",
        //             "course_name": "Java",
        //             "course_title": "Learn how to customize the color",
        //             "created_date": "20/1/2020 11:05:56"
        //         },
        //         {
        //             "training_id": "3",
        //             "training_name": "Shababiah 5G sim",
        //             "course_id": "11",
        //             "course_name": "Android",
        //             "course_title": "Learn how to customize the color",
        //             "created_date": "20/1/2020 12:05:56"
        //         }
        //     ]
        // }  
        // ';
        // echo $myObj;
} 

}
?>