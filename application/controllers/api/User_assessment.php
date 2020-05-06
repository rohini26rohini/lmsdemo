<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_assessment extends Direction_Controller {

    public function __construct() {
        parent::__construct();
      }
    public function index($userId = NULL){
      //  echo $userId;die();
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Headers: "Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token"');
        header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS');
        $userId =$this->uri->segment(3);
        $data = [];
       
      //  $userId =2478;
      $exist=$this->common->check_if_dataExist('assessment',array("emp_id"=>$userId));
       if($exist==0) {
           $response['statusCode'] = 400;
           $response['status']     = FALSE;
           $response['message']    = 'Invalid request';
           print_r(json_encode($response));
           exit();
        }

       if($userId>0) {
        $results = $this->Api_model->get_assessment_empid($userId);
        foreach($results as $list) { 
            $attemptdata = [];
            $assessment_results = $this->Api_model->get_emp_assessment($userId,$list->assessment_id);
            if(!empty($assessment_results)) {
            foreach($assessment_results  as $list1) { 
                array_push($attemptdata,array('attempt'=>$list1->attempt,
                'grade'=>$list1->grade,
                'date'=>$list1->date
            ));
            }
        }
            array_push($data,array('assessment_id'=>$list->assessment_id,'attempt'=>$attemptdata));
        }
        $response['statusCode'] = 200;
        $response['status'] = TRUE;
        $response['message'] = 'Successfully';
        $response['userId']=$userId;
        $response['assessment']= $data;
        print_r(json_encode($response));
       }
       else {
        $response['statusCode'] = 400;
        $response['status']     = FALSE;
        $response['message']    = 'Invalid Request';
        print_r(json_encode($response));
    }

    }
}

?>