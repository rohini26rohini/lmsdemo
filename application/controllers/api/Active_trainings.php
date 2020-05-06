<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Active_trainings extends Direction_Controller {

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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if (array_key_exists("emp_id",$request) && array_key_exists("courseStatus",$request) && array_key_exists("is_communication",$request))
        {
        if($request->emp_id!='') {
                $courselist = $this->Api_model->get_active_courses_emp_id($request->emp_id, $request->courseStatus, $request->is_communication);
        } else {
                $courselist = $this->Api_model->get_active_courses($request->emp_id, $request->courseStatus, $request->is_communication);
        } 
        if(!empty($courselist)) {
                $data = [];
                $response['statusCode'] = 200;
                $response['status'] = TRUE;
                $response['message'] = 'Training List';
                foreach($courselist as $list) { 
                        array_push($data, array(
                                                'course_id'=>$list->class_id,
                                                'course_name'=>$list->class_name,
                                                'created_date'=>date('d/m/Y H:i:s', strtotime($list->created_time)),
                                                'status'=>$list->course_status
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
                $response['statusCode']  = 400;
                $response['status']      = FALSE;
                $response['message']     = 'Invalid request';
                print_r(json_encode($response));
                exit();
        }

        print_r(json_encode($response));
        //     header("Content-type: text/json");
        //     $myObj='{
        //             "statusCode": 200,
        //             "status": true,
        //             "message": "Training List",
        //             "courses": [
        //             {
        //             "course_id": "1",
        //             "course_name": "Android",
        //             "course_title": "Learn how to customize the color"
        //             },
        //             {
        //             "course_id": "2",
        //             "course_name": "iOS",
        //             "course_title": "Learn how to customize the color"
        //             },
        //             {
        //             "course_id": "3",
        //             "course_name": "Php",
        //             "course_title": "My SQL Database"
        //             }
        //             ]
        //             }';
        //     echo $myObj;
    }


    // function auth() {
    //     ini_set('max_execution_time', 300);
    //     //echo '<pre>'; print_r(getallheaders());
    //     //$data = json_encode($userArr);
    //     //$url = APIURI.'api/Api';
    //     $data = [];
    //     $data['accept']= array("*/*");
    //     $data['accept-encoding']= array("gzip");
    //     $data['apkversion']= array("1.0.17");
    //     $data['apkversioncode']= array("17");
    //     $data['authorization']= array("17");
    //     $data['content-length']= array("0");
    //     $data['content-type']= array("application/json");
    //     $data['x-auth-token']= array("235a2eb7-6768-4611-82fc-40a1e990c047");
    //     $data['x-userid']= array("5529");
    //     $data['x-request-id']= array("1321313113131");
    //     echo json_encode($data); 
    //     $url = 'http://10.0.14.40:9986/sd-application/v1/api/heartbeat';
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 86400);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //     //curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, ''); 
    //     $headers = ['accept-encoding: gzip; x-request-id: 1321313113131; authorization: xxx; content-length: 0; Content-Type: application/json; x-auth-token: b9280b26-1491-452d-acaa-4b53704ec68c; x-userid:5529'];
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
    //     //print_r(http_response_code()); echo '----';
    //     print_r($headers);
    //     $result = curl_exec($ch); print_r($result);
    //     $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); print_r($retcode);
    //     $curl_error = curl_error($ch); print_r($curl_error);
    //     curl_close($ch); die();
    // }

    function auth() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://10.0.14.40:9986/sd-application/v1/api/heartbeat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "x-auth-token: b9280b26-1491-452d-acaa-4b53704ec68c",
            "x-userid: 5529"
        ),
        ));

        $response = curl_exec($curl);
        //print_r(http_response_code());
        curl_close($curl);
        echo $response;
    }
} 


?>
