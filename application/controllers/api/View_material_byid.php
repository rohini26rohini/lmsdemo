<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_material_byid extends Direction_Controller {

    public function __construct() {
        parent::__construct();
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
    public function index($id = NULL){
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
        $id =$this->uri->segment(3);
        try{ 
        if($id>0) {
            $results = $this->Api_model->get_material_byid($id); 
            if(!empty($results)) {
                $response['statusCode'] = 200;
                $response['status']     = TRUE;
                $response['message']    = 'Successfull';
                $response['url']        = NULL;
                if($results->material_id=='Video') {
                    $path_to_content = base_url().'materials/'.$results->video_content;
                    header('Content-type: video/mp4');
                }
                if($results->material_id=='PPT') {
                    $path_to_content = base_url().'materials/'.$results->ppt_notes;
                    if($results->ppt_notes!='') {
                        $ppt = explode('.', $results->ppt_notes);
                        $typ = end($ppt);
                    }
                    header('Content-type: application/vnd.ms-powerpoint');
                    if($typ == 'pptx') {
                        header('Content-type: application/vnd.openxmlformats-officedocument.presentationml.presentation');     
                    }
                }
                if($results->material_id=='Audio') {
                    $path_to_content = base_url().'materials/'.$results->audio_content;
                    header('Content-type: application/json');
                }
                if($results->material_id=='Images') {
                    $path_to_content = base_url().'materials/'.$results->image_notes;
                    header('Content-type: application/json');
                }
                if($results->material_id=='PDF') {
                    $path_to_content = base_url().'materials/'.$results->pdf_notes;
                    header('Content-type: application/json');
                }
                if($results->material_id=='Text') {
                    $path_to_content = $results->text_notes;
                    header('Content-type: application/json');
                }
                $response['url'] = $path_to_content;
            } else {
                $response['statusCode'] = 200;
                $response['status']     = TRUE;
                $response['message']    = 'No result found';
                $response['url']       = Null;
            }
        } else {
            $response['statusCode'] = 400;
            $response['status']     = FALSE;
            $response['message']    = 'Bad Request';
            $response['url']       = Null;
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