<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_material_list extends Direction_Controller {

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
        $response['statusCode'] = 400;
        $response['status']     = FALSE;
        $response['message']    = 'Bad Request';
        $response['data']       = Null;
     
            if (array_key_exists("training_id",$request) && array_key_exists("emp_id",$request))
            {
        if($request->emp_id!='' && $request->training_id) {
            $course = $this->Api_model->get_emp_materials($request->emp_id, $request->training_id); 
            if(!empty($course)) {
                $data = [];
                $response['statusCode'] = 200;
                $response['status']     = TRUE;
                $response['message']    = 'study material details';
                $data['course_name']    = $course->class_name;
                $data['course_id']      = $course->class_id;
                $data['training_name']    = $course->batch_name;
                $data['training_id']      = $course->batch_id;
                $data['study_material_list'] = [];
                $course_id = $course->class_id;
                $results = $this->Api_model->get_training_material($course_id);
                if(!empty($results)) {
                    foreach($results as $row) { 
                        if($row->material_id == 'PDF') {
                            $url = base_url().'materials/'.$row->pdf_notes;
                        } else if($row->material_id == 'PPT') {
                            $url = base_url().'materials/'.$row->ppt_notes;
                        } else if($row->material_id == 'Video') {
                            $url = base_url().'materials/'.$row->video_content;
                        } else if($row->material_id == 'Audio') {
                            $url = base_url().'materials/'.$row->audio_content;
                        } else if($row->material_id == 'Images') {
                            $url = base_url().'materials/'.$row->image_notes;
                        } else if($row->material_id == 'Text') {
                            $url = $row->text_notes;
                        }
                        array_push($data['study_material_list'], array(
                            'chapter_id'=>$row->id,
                            'item_title'=>$row->TOPIC,
                            'item_type'=>$row->material_id,
                            'description'=>$row->description,
                            'item_url'=>$url,
                            'playedTime'=>''
                    ));
                    $response['data']       = $data;
                    }
                } else {
                    $response['statusCode'] = 200;
                    $response['status']     = TRUE;
                    $response['message']    = 'study material details';
                    $response['data']       = $data;
                }
            } else {
            $response['statusCode'] = 200;
            $response['status']     = TRUE;
            $response['message']    = 'No result found';
            $response['data']       = Null;
            }
        }
    }
    else{
        $response['statusCode'] = 400;
        $response['status']     = FALSE;
        $response['message']    = 'Bad Request';
        $response['data']       = Null;
    }
        print_r(json_encode($response));
   
// $myObj='{
//     "status": true,
//     "message": "study material details",
//     "data": {
//         "chapter_name": "Life Process Videos",
//         "item_type": "audio",
//         "item_title": "Introduction",
//         "item_url": "http://gbs-plus-test.info/lms/uploads/audio.mp3",
//         "study_material_list": [
//             {
//                 "chapter_id": "1",
//                 "item_title": "Life Process Video",
//                 "item_type": "video",
//                 "item_url": "http://gbs-plus-test.info/lms/uploads/video.mp4",
//                 "playedTime": "10:05"
//             },
//             {
//                 "chapter_id": "2",
//                 "item_title": "Life Process Audio",
//                 "item_type": "audio",
//                 "item_url": "http://gbs-plus-test.info/lms/uploads/audio.mp3",
//                 "playedTime": "10:05"
//             },
//             {
//                 "chapter_id": "1",
//                 "item_title": "Life Process Document",
//                 "item_type": "document",
//                 "item_url": "http://gbs-plus-test.info/lms/uploads/document.pdf",
//                 "startPage": "5"
//             }
//         ]
//     }
// }
// ';
// echo $myObj;
    }
}
?>