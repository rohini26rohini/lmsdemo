<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_question_list extends Direction_Controller {

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
            $response['statusCode']  = 400;
            $response['status']      = FALSE;
            $response['message']     = 'Bad request';
            $response['data']        = NULL;
          try {
            if (array_key_exists("emp_id", $request) && array_key_exists("assessment_id", $request))
            {
               if($request->emp_id!='' && $request->assessment_id!='') {
                    // $exist = $this->common->get_from_tablerow('am_student_course_mapping', array('student_id'=>$request->emp_id,'batch_id'=>$request->training_id));
                    // if(!empty($exist)) {
                        $questionset = $this->common->get_from_tablerow('am_course_mapping', array('gm_exam_schedule_id'=>$request->assessment_id)); 
                        if(!empty($questionset)) {
                            $questions = $this->common->get_from_tableresult('mm_question', array('question_set_id'=>$questionset['question_set_id'])); 
                            $data = [];
                            if(!empty($questions)) {
                                foreach($questions as $row=>$question) {
                                    $choices = [];
                                    $ans = [];
                                    $options = $this->common->get_from_tableresult('mm_question_option', array('question_id'=>$question->question_id)); 
                                    foreach($options as $key=>$option) {
                                    $choices[$key]['choice_id'] = $option->option_id;
                                    $choices[$key]['choice_desc'] = $option->option_content;
                                    if($option->option_answer==1) {
                                        array_push($ans, $option->option_id);
                                    }
                                }
                                $data[$row]['question_id'] = $question->question_id;
                                $data[$row]['question_desc'] = $question->question_content;
                                //$data[$row]['correct_ans'] = implode(',', $ans);
                                $data[$row]['correct_ans'] = $ans;
                                $data[$row]['choices'] = $choices;
                                }
                                $response['statusCode']  = 200;
                                $response['status'] = TRUE;
                                $response['message'] = 'Get Question Paper';
                                $response['data'] = $data;
                                print_r(json_encode($response)); 
                            } else {
                                $response['statusCode']  = 400;
                                $response['status']      = FALSE;
                                $response['message']     = 'Questions not assigned to assessment';
                                $response['data']        = NULL; 
                                print_r(json_encode($response));  
                            }
                        } else {
                            $response['statusCode']  = 400;
                            $response['status']      = FALSE;
                            $response['message']     = 'Invalid Employee/Training details';
                            $response['data']        = NULL; 
                            print_r(json_encode($response));  
                        }
                    // } else {
                    //     $response['statusCode']  = 400;
                    //     $response['status']      = FALSE;
                    //     $response['message']     = 'Invalid Employee/Training details';
                    //     $response['data']        = NULL; 
                    //     print_r(json_encode($response)); 
                    // }
                } else {
                print_r(json_encode($response)); 
               }
            } else {
                print_r(json_encode($response)); 
            } 
            } catch (Exception $e){
                print_r(json_encode($response));
            }
        // $myObj='{
        //     "status": true,
        //     "message": "Get Question Paper",
        //     "assessment_id": "1",
        //     "data": [
        //         {
        //             "question_id": "1",
        //             "question_desc": " Muramic acid is present in cell walls of",
        //             "correct_ans": "1",
        //             "choices": [
        //                 {
        //                     "choice_id": "1",
        //                     "choice_desc": "Bacteria and blue-green algae"
        //                 },
        //                 {
        //                     "choice_id": "2",
        //                     "choice_desc": "Green algae"
        //                 },
        //                 {
        //                     "choice_id": "3",
        //                     "choice_desc": "Yeast"
        //                 },
        //                 {
        //                     "choice_id": "4",
        //                     "choice_desc": "All fungi"
        //                 }
        //             ]
        //         },
        //         {
        //             "question_id": "2",
        //             "question_desc": "Growth of cell wall during cell elongation takes place by",
        //             "correct_ans": "2",
        //             "choices": [
        //                 {
        //                     "choice_id": "1",
        //                     "choice_desc": "Apposition"
        //                 },
        //                 {
        //                     "choice_id": "2",
        //                     "choice_desc": "Intussusception"
        //                 },
        //                 {
        //                     "choice_id": "3",
        //                     "choice_desc": "Both 1 and 2"
        //                 },
        //                 {
        //                     "choice_id": "4",
        //                     "choice_desc": "Super position"
        //                 }
        //             ]
        //         }
        //     ]
        // }  
        // ';
        // echo $myObj;
    }
} 


?>