<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_certificate extends Direction_Controller {

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
        $this->load->model('Api_model');

        header("Content-Type: application/json; charset=UTF-8"); 
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $response['statusCode'] = 400;
        $response['status']     = FALSE;
        $response['message']    = 'Bad Request';
        $response['data']       = Null;
        if (array_key_exists("emp_id",$request) && array_key_exists("assessment_id",$request)  && array_key_exists("training_id",$request) && array_key_exists("assessment_status",$request) )
        { 
            $status = array('Approved', 'Rejected');
            if(in_array($request->assessment_status, $status)) { 
            $check = $this->Api_model->get_assessment_status($request->assessment_id, $request->emp_id);
           // echo $this->db->last_query();
            if($check) {
                $dataArr = array('approved_status'=>$request->assessment_status);
                $response = $this->generate_certificate($request->assessment_id, $request->training_id, $request->emp_id, $dataArr);
            } else {
                $response['statusCode'] = 500;
                $response['status']     = FALSE;
                $response['message']    = 'Assessment not completed';
                $response['data']       = Null;
            }
        }
        } 
        print_r(json_encode($response));
    // header("Content-type: text/json");
    // $myObj='{
    //     "status": true,
    //     "message": "Certificate created successfully",
    //     "data":
    //     {
    //         "certificate_url":"http://gbs-plus-test.info/lms/certificate/65.pdf"
    //     }
    // }
    // ';
    // echo $myObj;
        }



        function generate_certificate($assessment_id = NULL, $training_id = NULL, $emp_id = NULL, $data) {
            if($assessment_id!='' && $training_id!='' && $emp_id !=''){
                $details = $this->Api_model->get_users_training_details($assessment_id, $training_id, $emp_id);
               // echo $this->db->last_query();
               // print_r($details);die();
                $highscore = $this->Api_model->get_highscoreatt($assessment_id,$emp_id);
                $assessmnt = $this->Api_model->get_last_assessment($assessment_id, $emp_id, $highscore->attempt);
                $emp_name_consion = str_replace(' ', '_',$details->em_name);
                $file = "certificate_".$emp_name_consion.$assessment_id.$emp_id.'.pdf';
                $coursename = '';
                if($details->course_id>0) {
                    $courses = $this->common->get_from_tablerow('am_classes', array('class_id'=>$details->course_id));
                    if(!empty($courses)) {
                        $coursename = $courses['class_name'];
                    }
                } 
                $scoredetails = $this->Api_model->get_scoredet($assessment_id, $emp_id, $assessmnt->attempt);
                // $html2 ='<div style="width:100%;"><img src="inner_assets/images/ooredoo-logo.png" style="height:40px;margin:10px 0px;display:block;float:right;" /></div>';
                // $html2 .= '<div style="width:950px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
                // <div style="width:900px; height:510px; padding:20px; text-align:center; border: 5px solid #787878">
                //        <span style="font-size:50px; font-weight:bold">Certificate of Completion</span>
                //        <br><br>
                //        <span style="font-size:25px"><i>This is to certify that</i></span>
                //        <br><br>
                //        <span style="font-size:30px"><b>'.$details->em_name.'</b></span><br/>
                //        <span style="font-size:25px"><i>has completed the training</i></span> <br/>
                //        <span style="font-size:30px">'.$details->batch_name.'</span> <br/><br/>
                //        <span style="font-size:20px">with grade of <b>'.$assessmnt->grade.'</b></span> <br/><br/>
                //        <span style="font-size:20px"><i>dated</i></span><br>
                //       <span style="font-size:20px">'.date('d-M-Y').'</span>
                // </div>
                // </div>'; 
                $html2 ='
                <style>
                    .red{
                        color: red;
                    }
                    .inline{
                        display: inline-flex;
                        margin: 0px;
                    }
                    div,h1,h2,h3,h4{
                        margin: 5px 2px 2px 2px ;
                        font-weight: normal;
                        
                    }
                    h2{
                        font-weight: bold;  
                    }
                    
                    
                </style>
                    <div style="width:100%; margin: 20px;background-color:white;">
                        <div align="right" ></div>
                
                            <div align="center" style="text-align:center; width:100%;">
                                <div  ><img height="50px" src="direction_v2/images/logo/iihrm.jpg"></div>
                                <div style="transform: rotate(180deg);" ><img  height="100px" src="inner_assets/images/dzn.png"></div>
                            
                                <h2 style="font-size:26px;">Certificate of Completion</h2>
                                <h3 style="font-size:20px;">Present to</h3>
                                <h2 class="red" style="font-size:20px;">'.$details->em_name.'</h2>
                                <h3 style="font-size:20px;">for completing training in</h3>
                                <h2 class="red" style="font-size:20px;">'.$coursename.'</h2>
                               <!-- <h3 class="red" style="font-size:20px;">'.$details->batch_id.'</h3>-->
                                <div  class="inline">
                                    <h3 style="font-size:20px;">Score: <span class="red">'.$scoredetails['score'].'</span> of <span class="red">'.$scoredetails['total'].'</span></h3>
                                </div>
                                <br>
                                <div  class="inline">
                                    <h3 style="font-size:20px;">Attempt:  <span class="red">'.$assessmnt->attempt.'</span></h3>
                                    
                                </div>
                                <br>
                                <div  class="inline">
                                    <span style="font-size:20px;">Grade: <span class="red">'.$assessmnt->grade.'</span></h3>                                    
                                </div>
                                <br>
                                <div  class="inline">
                                    <h3 style="font-size:20px;">Issued on </h3>
                                    <h3 class="red" style="font-size:20px;">'.date('d-M-Y').'</h3>
                                </div>
                                <div  ><img  height="100px" src="inner_assets/images/dzn.png"></div>
                                <h1 class="red" >IIHRM</h1>
                                <p>Office: +1111111111 <br> Fax: +2222222222</p>
                                <p>P.O Box 874 P.C. 111, <br>Indonesia</p>
                            
                            
                            
                            </div>
                
                    </div>'; 
                $filepath = FCPATH.'uploads/certificate/'.$file;
                $url = base_url('uploads/certificate/'.$file);

                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                //$pdf->SetFooter('<div style="text-align:center;">Ooredoo</div>'); // Add a footer for good measure ;)
                $pdf->autoPageBreak = false;
                $pdf->AddPage('L');
                $pdf->WriteHTML($html2); 
                $pdf->Output($filepath, "F");

                if (file_exists($filepath)) {
                    $data['approved_date'] = date('d-M-Y');
                    $data['certificate_url'] = $url;
                    $update = $this->Api_model->update_certificate_status($assessment_id, $emp_id, $data);
                    if($update) {
                        $response['statusCode'] = 200;
                        $response['status']     = TRUE;
                        $response['message']    = 'Certificate created successfully';
                        $response['data']       = array('certificate_url'=>$url);
                    } else {
                        $response['statusCode'] = 400;
                        $response['status']     = FALSE;
                        $response['message']    = 'Invalid Request';
                        $response['data']       = Null;  
                    }
                } else {
                    $response['statusCode'] = 400;
                    $response['status']     = FALSE;
                    $response['message']    = 'Invalid Request';
                    $response['data']       = Null;
                }
            } else {
                $response['statusCode'] = 400;
                $response['status']     = FALSE;
                $response['message']    = 'Invalid Request';
                $response['data']       = Null;
            }
            return $response;
        }
}
?>