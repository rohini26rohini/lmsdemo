<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FinishAssessment extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Api_model');
    //     $headers = getallheaders();
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
    //       $result = auth($headers['x-auth-token'],$headers['x-userid']); 
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
     
          $postdata = file_get_contents("php://input"); //echo $postdata;
          $request = json_decode($postdata);  //die();
          if (array_key_exists("emp_id",$request) && array_key_exists("assessment_id",$request) && 
          array_key_exists("attempt",$request) && array_key_exists("answer_list",$request)) 
        {
          $emp_id=$request->emp_id;
          $assessment_id=$request->assessment_id;
          $attempt=$request->attempt;
          //$total_questions=count($request->answers);
          $iscorrect = 0;
          $total_questions = 0;
          $emp_exist=$this->common->check_if_dataExist('am_students',array("student_id"=>$emp_id,"status"=>1));
          if($emp_exist==0){
              $myObj['statusCode'] = 400;
              $myObj['status'] = TRUE;
              $myObj['message'] = 'Invaild Emp_id';
              print_r(json_encode($myObj));
              exit();
          }
          if(!empty($request->answer_list)) {
          foreach($request->answer_list as $row)
              {
                $total_questions++;
                if($row->is_correct == true){
                  $iscorrect++;
                }
              //$iscorrect=$row->is_correct+$iscorrect;
              }
              $correct =  $iscorrect;
              $per = number_format(($correct/$total_questions)*100);
        
             if( $per>=90 &&  $per<=100)
            {
            $grade= "Excellent";
            }
            else if( $per>=70 &&  $per<90)
            {
              $grade="Good";
            }
            else if( $per>=50 &&  $per<70)
            {
              $grade="Above Average";
            }
            else if( $per<50)
            {
              $grade="Below Average";
            }
            $datalist=array('total_questions'=>$total_questions,
            'correct_answered'=>$correct,
            'grade'=>$grade
            );
       
         $orido_exam_log=array('assessment_id'=>$assessment_id,
         'emp_id'=>$emp_id,
         'attempt'=>$attempt,
         'end_time '=>0,
         'start_time'=>time(),
         'status'=>1
         );
        
           $last_id=$this->Api_model->insert_startassessment($orido_exam_log);
           
            foreach($request->answer_list as $row)
              { 
                $content= implode(',', $row->choice_selected); 
                $question_id= $row->question_id; 

            $datas=array('assessment_id'=>$assessment_id,
          'emp_id'=>$emp_id,
          'exam_log_id'=>$last_id,
          'attempt'=>$attempt,
          'question_id'=>$question_id,
          'content'=>$content,
          'correct'=>$correct
          );
          $result=$this->Api_model->insert_finishassessemnt($datas); 
        }
      //   $exist=$this->common->check_if_dataExist('assessment',array("emp_id"=>$emp_id,"assessment_id"=>$assessment_id));
      //   if($exist == 0) {
      //     $result=$this->Api_model->insert_assessment($data=array('assessment_id'=>$assessment_id,
      //     'emp_id'=>$emp_id,
      //     'status'=>0
      // ));
      //     $result=$this->Api_model->insert_assessment_details(array('assessment_id'=>$assessment_id,
      //     'emp_id'=>$emp_id,
      //     'status'=>1,
      //     'attempt'=>$attempt
      //         ));
      //   }
        $this->Api_model->update_grade($assessment_id, $emp_id,$attempt, array('grade'=>$grade));

       
          if($result) {
            $myObj['statusCode']  = 200;
            $myObj['status']      = TRUE;
            $myObj['message']     = 'Assessment Finished successfully';
            $myObj['data']        =  $datalist;
          } else {
            $myObj['statusCode']  = 500;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Invaild Request';
          
          }
        } else {
            $myObj['statusCode']  = 400;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Bad Request';
        }
        } else {
            $myObj['statusCode']  = 400;
            $myObj['status']      = FALSE;
            $myObj['message']     = 'Bad Request';
        }

          print_r(json_encode($myObj));
        
} 

}
?>