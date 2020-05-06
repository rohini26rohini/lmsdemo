<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Completed_assessment_list extends Direction_Controller {

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
        //?page=1&size=20&sort=createdDate&order=desc&keywo rd= 
            $response['statusCode'] = 400;
            $response['status']     = FALSE;
            $response['message']    = 'Bad request';
            $response['assessment_list']       = Null;
            $sort = '';
            $assessment_id = 0;
        if(!isset($_GET['page']) || !isset($_GET['size']) || !isset($_GET['sort']) || !isset($_GET['order'])) {
            $response['statusCode'] = 400;
            $response['status']     = FALSE;
            $response['message']    = 'In valid request';
            $response['assessment_list']       = Null;
        } else { 
            $page      = (int)$_GET['page'];
            $size      = (int)$_GET['size'];
            $sortfield = $_GET['sort'];
            $order     = $_GET['order'];
            $keyword   = $_GET['keyword'];
            $totalPages = 0;
            $totalElements= 0;
            if(isset($_GET['status'])) {
                $sort = $_GET['status'];
            }
            if(isset($_GET['assessment_id'])) {
                $assessment_id = $_GET['assessment_id'];
            }
            $res = [];
            $totalElements = $this->Api_model->get_completed_assessment_count($assessment_id, $sort, $keyword);
            $list = $this->Api_model->get_completed_assessment($assessment_id, $sort, $page, $size, $sortfield, $order, $keyword);//print_r($list);
            if(!empty($list)) { 
                foreach($list as $key=>$row) { 
                    $trains = $this->Api_model->get_training_details_assmnet($row->assessment_id); 
                    $res[$key]['emp_id']                = $row->emp_id;
                    $res[$key]['emp_name']              = $row->em_name;
                    $res[$key]['training_id']           = $trains->batch_id;
                    $res[$key]['training_name']         = $trains->batch_name;
                    $res[$key]['assessment_id']         = $row->assessment_id;
                    $res[$key]['assessment_name']       = $row->name;
                    $res[$key]['assessment_rating']     = '';
                    $res[$key]['certificate_status']    = 'not';
                    if($row->approved_status=="Approved" || $row->approved_status=="Rejected") {
                        $res[$key]['certificate_status']    = 'generated';
                    }
                    $result = $this->Api_model->get_last_assessment($row->assessment_id, $row->emp_id); 
                    if(!empty($result)) {
                        $res[$key]['assessment_rating']     = $result->grade;
                    } 
                } 
                $response['statusCode'] = 200;
                $response['status']     = 'success';
                $response['message']    = 'Completed assessment list';
                $response['page'] = $page-1;
                $response['size'] = $size;
                $response['totalElements'] = $totalElements;
                $response['totalPages'] = $totalPages;
                $response['last'] = false;
                if($totalPages==$page){
                $response['last'] = true;
                }
                $response['assessment_list']       = $res;  
            } else {
                $response['statusCode'] = 200;
                $response['status']     = 'success';
                $response['message']    = 'No data found';
                $response['assessment_list']       = Null;  
            }
        }

        $json = json_encode($response);
        echo $json;
// $myObj='{
//     "statusCode": 200,
//     "status": "success",
//     "assessment_list": [
//         {
//             "emp_id": "10",
//             "emp_name": "Employee 1",
//             "training_id": "1",
//             "training_name": "2G_training",
//             "assessment_id": "11",
//             "assessment_name": "2G_assessment",
//             "assessment_status": "completed",
//             "assessment_rating": "very_good",
//             "certificate_status": "generated"
//         },
//         {
//             "emp_id": "11",
//             "emp_name": "Employee 11",
//             "training_id": "12",
//             "training_name": "3G_training",
//             "assessment_id": "13",
//             "assessment_name": "3G_assessment",
//             "assessment_status": "completed",
//             "assessment_rating": "good",
//             "certificate_status": "generated"
//         },
//         {
//             "emp_id": "12",
//             "emp_name": "Employee 12",
//             "training_id": "13",
//             "training_name": "4G_training",
//             "assessment_id": "14",
//             "assessment_name": "4G_assessment",
//             "assessment_status": "completed",
//             "assessment_rating": "Excellent",
//             "certificate_status": "generated"
//         }
//     ]
// }
// ';
// echo $myObj;
    }
}
?>