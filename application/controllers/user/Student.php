<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends Direction_Controller {
  public function __construct() {
    parent::__construct();
    //check_backoffice_permission();
    //print_r($this->session->all_userdata()); die();
    $this->load->model('user_model');
    $this->load->model('Api_model');

    if($this->session->userdata('logedin')==1 && ($this->session->userdata('role')=='student' || $this->session->userdata('role')=='user') || $this->session->userdata('role')=='parent') {  
    $parent_id = $this->session->userdata('user_primary_id');
    $this->data['students'] = $this->user_model->get_children_byparentid($parent_id);  
    } else  {
        redirect(base_url('login'));
    }
    $this->load->model('Messanger_model');
    $this->load->model('questionbank_model');
  }

/*
*   function'll goto student dashboard
*   @params student session
*   @author GBS-R
*/
    
public function index($id = ''){
    //echo 1;die();
    $student_id = $this->session->userdata('user_id');
    if($student_id!=NULL){
        $this->data['examEdit'] = $this->common->get_exam_byid($student_id);
        $details=$this->data['examEdit'];
        // echo '<pre>';
        // print_r($this->data['examEdit']);
    }
    $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
    $this->data['qualification'] = $this->common->get_alldata('am_student_qualification',array('student_id'=>$student_id));
    $room_data=$this->common->get_from_tablerow('hl_room_booking', array("student_id"=>$student_id));
             if(!empty($room_data))
             {
             $this->data['hostel_room_details'] =  $this->Hostel_model->get_hostel_roomdata_byId($room_data['room_id']);
             }
    //echo "<pre>";print_r($this->data['userdata']); die();
    $batch = $this->user_model->get_student_active_batch($student_id);
    if(!empty($batch)) {
    $school_id = $batch->school_id;
    $this->data['batch'] = $batch;
    $this->data['course_Id'] = $this->user_model->get_courseby_subId($student_id);
    $this->data['course_count'] = $this->user_model->get_coursecount_ID($student_id);
    $this->data['courseone'] = $this->user_model->get_courseone($student_id);
    $this->data['sections'] = $this->common->get_upcomming_sections($batch->batch_id); 
    }
    $this->data['examlist'] = $this->user_model->get_student_examss($student_id); 
// echo "<pre>";print_r($this->data['examlist']); die();
    //-----------------------------Messenger ----------------------------------------

    $this->data['conversations'] = $this->Messanger_model->get_conversations();
    $msgnoty = $this->Messanger_model->get_msgnoty();
        $f = 0;
        foreach($msgnoty as $conv){
            if($conv['status']==0 && $conv['archieved']==0){
                $f++;
            }
        }
    $this->data['notifyCount'] = $f;
    // echo $this->db->last_query(); exit;
    $this->data['members'] = $this->Messanger_model->get_members($student_id);
    if($id!=''){$this->data['message'] = $this->Messanger_model->get_messages($id); }
       //count of materials
      $materials = $this->common->get_from_tableresult('mm_subjects', array('course_id'=>$this->data['courseone']->course_id, 'subject_status'=>1));
      $subjectArr = [];
      if(!empty($materials)) {
          foreach($materials as $material) {
              array_push($subjectArr, $material->subject_id);
          }
      }
       $this->data['materials_students']=$this->user_model->get_students_count($student_id); 
       $this->data['materials_count'] = $this->user_model->get_course_materials_count($subjectArr);
     //  $this->data['per']=round(($this->data['materials_students']/ $this->data['materials_count'])*100); 
      $this->data['per']=0; 
        //count of materials
    $this->data['viewload'] = 'student/student_dashboard_view';
    $this->load->view('_layouts_new/_master', $this->data); 
} 


/*
    *   function'll will get batch fee
    *   @params batch_id student_id
    *   @author GBS-R
    */
    public function load_quiz_details($course_id)
    {
        //$this->session->unset('session_data');
         $subject_Id= $this->user_model->get_subjectId_courseid($course_id);
         //$this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);

         $questionset_Ids= array(); 
         $this->data['user_quesions']=array();
         $this->data['course_id']    = $course_id; 
         $this->data['questionset']    = array(); 
         $this->data['options']    = array(); 
         if(!empty($subject_Id)) {
          foreach($subject_Id as $row){
              $module=$this->user_model->get_moduleIdBy_subject($row->subject_id);
              if(!empty($module)) {
              foreach($module as $row1){
                $questions=$this->user_model->get_questionsetBy_subject($row1->subject_id);
                if(!empty($questions)) {
                 foreach($questions as $row2){
                   // echo '<pre>'; print_r($options);
                     array_push($questionset_Ids, $row2->question_set_id);
                 }
                }
              }
            }
          }
        }
       //print_r($this->session->userdata('session_data'));
           if(empty($this->session->userdata('session_data'))){
            if(!empty($questionset_Ids)) {
            $this->data['questionset']=$this->user_model->get_questionset($questionset_Ids);
            $this->session->set_userdata('session_data',$this->data['questionset']);
           }
        } 
        $this->data['viewload'] = 'student/load_quiz_details';
        $this->load->view('_layouts_new/_master', $this->data);
       
    }
    public function course_list_details()
    {
        $student_id = $this->session->userdata('user_id');
        $this->data['course_Id'] = $this->user_model->get_courseby_subId($student_id);
        $this->data['viewload'] = 'student/course_list_details';
        $this->load->view('_layouts_new/_master', $this->data);
       
    }
   
    public function load_fee_details()
    {
        $student_id                         =   $this->session->userdata('user_id');
        $batch                              =   $this->user_model->get_student_active_batch($student_id); 
        $institute_center_map_id = '';
        if(!empty($batch)) {
            $school_id = $batch->school_id;
            $institute_center_map_id = $batch->institute_course_mapping_id;
            }
        // print_r($_POST);
		$this->data['config']				=	$this->home_model->get_config();
        $paidstatus         = array();
        $availableseats     = 0;
        $this->data['verification'] = 0;
        $batch_fee          = $this->student_model->get_batchfee_bystudent_id($student_id, $institute_center_map_id);
        $this->data['batch_fee'] = $batch_fee;
        if(!empty($batch_fee) && $batch_fee->course_id!='' && $batch_fee->fee_definition_id!=''){
            $courseDet = $this->common->get_from_tablerow('am_classes', array('class_id'=>$batch_fee->course_id));
            if(!empty($courseDet) && $courseDet['basic_qualification']!='') {
                $qualiverification = $this->student_model->check_basic_qualification($student_id, $courseDet['basic_qualification']);
                if(!empty($qualiverification)) {
                  $this->data['verification'] = 1;   
                }
            } else {
                $verification       = $this->common->get_from_tableresult('am_student_documents', array('student_id'=>$student_id,'verification'=>1));
                if(!empty($verification)) {
                   $this->data['verification'] = 1; 
                }
            }
        }
        $months = 0;
        $this->data['transport'] = 0;
        $this->data['hostel']    = 0;
        if(!empty($batch_fee) && $batch_fee->batch_id!='') {  
            $batch_id               = $batch_fee->batch_id;
			$institute_course_mapping_id      = $batch_fee->institute_course_mapping_id;
			$this->data['feeheads']= $this->common->get_feedsmapping($institute_course_mapping_id); 
            $batchdetails           = $this->common->get_batch_details($batch_id); //echo '<pre>';print_r($batchdetails);
            $this->data['hostel']   = array();//$this->common->get_hostelFee_byStudentId($student_id);
            $transport_fare         = $this->common->get_fare_by_student($student_id);
            if(!empty($batchdetails)) {
                $months = get_interval_in_month($batchdetails['batch_datefrom'], $batchdetails['batch_dateto']);
                //$this->data['transport'] = $transport_fare*$months;
            }
            $course_totalfee = $batch_fee->course_totalfee;
            $course_id = $batch_fee->course_id;
            $institute_course_mapping_id = $batch_fee->institute_course_mapping_id;
            $registeredstudent = $this->common->get_total_student($batch_id);
            $availableseats = $batchdetails['batch_capacity'];
            $this->data['course_id'] =  $course_id;
            $this->data['student_id'] =  $student_id;
            $paidstatus = $this->common->get_paidstatus($student_id, $institute_course_mapping_id);  
            $discount = $this->common->get_from_tableresult('pp_student_discount', array('student_id'=>$student_id,'course_id'=>$course_id));
            $this->data['discnt'] = ''; 
            if(!empty($discount)) {
                $dicountper = 0;
                $dicntAmt   = 0;
                foreach($discount as $disnt) {
                    if($disnt->st_discount_type==2) {
                        $dicountper  =  $disnt->st_discount*$course_totalfee;
                        $dicntAmt    = $dicountper/100;
                    } else {
                        $dicntAmt    =  $disnt->st_discount;
                    }
                    $this->student_model->update_discount($dicntAmt,$disnt->st_discount_id);
                    if($disnt->discount_status==0) {
                      $this->data['discnt']   = 'Pending';  
                    }
                    
                }
            }
            $x = 0 ;
            $trans = [];
            if(!empty($paidstatus)) {
                foreach($paidstatus as $paid) {  
                    $install = $this->common->get_from_tableresult('pp_student_payment_installment', array('payment_id'=>$paid->payment_id));
                    if(!empty($install)) {
                        foreach($install as $ins) {  
                            $trans[$x]['type'] = $ins->installment.' Installment';
                            $trans[$x]['amount'] = $ins->installment_paid_amount;
                            $trans[$x]['mode'] = $ins->paid_payment_mode;
                            $trans[$x]['date'] = date('d-M-Y', strtotime($ins->createddate));
                            if($ins->paid_payment_mode == 'Cash') {
                                $trans[$x]['transtype'] = '';
                            } else if($ins->paid_payment_mode == 'Cheque') {
                                $trans[$x]['transtype'] = $ins->card_holder_name.'<br> '.$ins->bank_name.'<br> Cheque No:'. $ins->cheque_no;
                            } else { 
                                $trans[$x]['transtype'] = $ins->card_type.'<br> '.$ins->bank_name.'<br> Transaction ID:'. $ins->transaction_id;
                            }
                            $trans[$x]['install_id'] = $ins->paid_install_id;
                            $trans[$x]['institute_course_mapping_id'] = $institute_course_mapping_id;
                            $trans[$x]['student_id'] = $student_id;
                            $trans[$x]['payment_id'] = $paid->payment_id;
                            $trans[$x]['method'] = 'installment';
                            $x++;
                        }
                    }

                    if($paid->payment_type=="onetime") {
                            $trans[$x]['type'] = 'Ontime';
                            $trans[$x]['amount'] = $paid->paid_amount;
                            $trans[$x]['mode'] = $paid->paymentmode;
                            $trans[$x]['date'] = date('d-M-Y', strtotime($paid->createddate));
                            if($paid->paymentmode=='Cash') {
                            $trans[$x]['transtype'] = '';
                            } else if($paid->paymentmode=='Cheque') {
                                $trans[$x]['transtype'] = $paid->card_holder_name.'<br> '.$paid->bank_name.'<br> Cheque No :'. $paid->cheque_no;
                            } else {
                            $trans[$x]['transtype'] = $paid->card_type.'<br> '.$paid->bank_name.'<br> Transaction ID:'. $paid->transaction_id;
                            }
                            $trans[$x]['install_id'] = 0;
                            $trans[$x]['institute_course_mapping_id'] = $institute_course_mapping_id;
                            $trans[$x]['student_id'] = $student_id;
                            $trans[$x]['payment_id'] = $paid->payment_id;
                            $trans[$x]['method'] = 'onetime';
                            $x++;
                    }

                    if($paid->payment_type=="split") {
                        $split = $this->common->get_from_tableresult('pp_student_payment_split', array('payment_id'=>$paid->payment_id));
                        if(!empty($split)) {
                            foreach($split as $spl) { 
                                $trans[$x]['type'] = 'Split payment';
                                $trans[$x]['amount'] = $spl->split_amount;
                                $trans[$x]['mode'] = $spl->paid_payment_mode;
                                $trans[$x]['date'] = date('d-M-Y', strtotime($spl->createddate));
                                if($spl->paid_payment_mode=='Cash') {
                                $trans[$x]['transtype'] = '';
                                } else if($spl->paid_payment_mode=='Cheque') {
                                    $trans[$x]['transtype'] = $spl->card_holder_name.'<br> '.$spl->bank_name.'<br> Cheque No:'. $spl->cheque_no;
                                } else {
                                $trans[$x]['transtype'] = $spl->card_type.'<br> '.$spl->bank_name.'<br>Transaction ID:'. $spl->transaction_id;
                                }
                                $trans[$x]['install_id'] = $spl->paid_split_id;
                                $trans[$x]['institute_course_mapping_id'] = $institute_course_mapping_id;
                                $trans[$x]['student_id'] = $student_id;
                                $trans[$x]['payment_id'] = $paid->payment_id;
                                $trans[$x]['method'] = 'split';
                                $x++;
                            }
                        }
                    }

                    
                    
                }
            }
        
        }
        $this->data['batch_fee'] = $batch_fee;
        $this->data['transactions'] = $trans;
		$view =  $this->load->view('student/student_feepayment_view',$this->data, TRUE);
        echo $view;
    }
    
/*
*   function'll load child list for parent dasboard
*   @params parent id
*   @author GBS-R
*
*/
    
function parent() {
    $parent_id = $this->session->userdata('user_primary_id');
    $this->data['students'] = $this->user_model->get_children_byparentid($parent_id); 
    $this->data['viewload'] = 'student/parent_view';
    $this->load->view('_layouts_new/_master', $this->data);
}    
 
/*
*   function'll get attendance of student
*   @params student id    
*   @author GBS-R
*/
// student_study_materials_view
public function attendance(){
    $student_id = $this->session->userdata('user_id');
    $batch = $this->user_model->get_student_active_batch($student_id); //print_r($batch);
    if(!empty($batch)) {
    $school_id = $batch->school_id;
    $this->data['batch'] = $batch;
    $this->data['attendance'] = $this->common->get_student_attendance($batch->batch_id);    
    }
    echo $this->load->view('student/student_attendance_view', $this->data, TRUE); 

}

 
/*
*   function'll get set session for student dashboard
*   @params student id    
*   @author GBS-R
*/
    
public function childselection(){
    $return = array('status'=>false,'url'=>base_url('parent-dashboard'));
    $student_id = $this->input->post('student_id');
    $batch = $this->user_model->get_student_active_batch($student_id); 
    if(!empty($batch)) {
        $data = array("user_id" => $student_id);
        $this->session->set_userdata($data);
        if($this->session->userdata('user_id')>0) {
            $return = array('status'=>true,'url'=>base_url('student-dashboard'));
            
        }
    }
    print_r(json_encode($return));

}
    
 

public function changechild($student_id = NULL){
    $batch = $this->user_model->get_student_active_batch($student_id); 
    if(!empty($batch)) {
        $data = array("user_id" => $student_id);
        $this->session->set_userdata($data);
        if($this->session->userdata('user_id')>0) {
            redirect(base_url('student-dashboard'));
        }
    } else {
       redirect(base_url('parent-dashboard')); 
    }

}
    
/*
*   function'll get change password
*   @params
*   @author GBS-L
*/
  
    
    public function change_password()
    {
        
    $student_id = $this->session->userdata('user_id');
    $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
    $this->data['qualification'] = $this->common->get_alldata('am_student_qualification',array('student_id'=>$student_id));
    $room_data=$this->common->get_from_tablerow('hl_room_booking', array("student_id"=>$student_id));
             if(!empty($room_data))
             {
             $this->data['hostel_room_details'] =  $this->Hostel_model->get_hostel_roomdata_byId($room_data['room_id']);
             }
    //echo "<pre>";print_r($this->data['userdata']); die();
    $batch = $this->user_model->get_student_active_batch($student_id);
    if(!empty($batch)) {
    $school_id = $batch->school_id;
    $this->data['batch'] = $batch;
    $this->data['notification'] = $this->user_model->get_notification_by_school($school_id);
    }
       
      $this->data['viewload'] = 'student/student_change_password';
      $this->load->view('_layouts_new/_master', $this->data);
         
    }
    
    /*check old passsword is correct or not
     @params old old password
 *    @author GBS-L
 */
    public function check_password()
    {
        if($_POST)
        {
            $old_password=$this->input->post('old_password');

            $user_id=$this->session->userdata['user_primary_id'];
            
            $password_hash=$this->common->get_name_by_id('am_users','user_passwordhash',array('user_id'=>$user_id));
            if(strcmp($old_password,$this->Auth_model->get_pass($password_hash)))
            {
                echo 'false';
            }
            else
            {
                echo 'true';
            }

        }
    }

   // change passsword
    public function password_change()
    {
        if($_POST)
        {
           
            $new_password=$this->input->post('new_password');
            $user_id=$this->session->userdata['user_primary_id'];
            $student_id=$this->session->userdata['user_id'];
            $password_hash= $this->Auth_model->get_hash($new_password);
			$username = '';
			$userDet = $this->common->get_from_tablerow('am_students', array('student_id'=>$student_id));  
			if(!empty($userDet)){
			$username = $userDet['registration_number'];
			}
            $response=$this->Common_model->update('am_users', array('user_passwordhash'=>$password_hash),array('user_id'=>$user_id));
            if($response)
            {
				
				$this->gm_user_registration($username, $new_password, $student_id);
                $ajax_response['st']=1;
                $ajax_response['message']="Successfully Changed Password";
                 $who=$this->session->userdata['user_id'];
                 $what=$this->db->last_query();
                 logcreator('update', 'database', $who, $what, $user_id, 'am_users_backoffice','Channged Password');
            }
            else
            {
                $ajax_response['st']=0;
                $ajax_response['message']="Something went wrong, Please try again later!";
            }
            print_r(json_encode($ajax_response));
        }
    }
	
    public function add_question_details()
    {  
        $question_id=$this->input->post('question_id');
        $ans=$this->input->post('customRadio');
       // print_r($ans);
       // print_r($question_id);
        $course_id=$this->input->post('course_id');

        $ans1=array();
        $ans2=array();
        $choice_selected=array();
        $ans_data=array();
        $answer_lists=array();
        $ques=array();
        $arrques=array();
        $correctans=array();
        $student_id = $this->session->userdata('user_id');
        $postdata['emp_id'] 		    = $student_id;

        $exist=$this->common->check_if_dataExist('assessment',array("emp_id"=>$student_id,"course_id"=>$course_id,'status'=>1));
        if($exist == 0) {
                $result_id=$this->Api_model->insert_assessment(array('course_id'=>$course_id,'emp_id'=>$student_id,'status'=>1));
                //echo $result_id;    
                $result=$this->Api_model->insert_assessment_details(array('assessment_id'=>$result_id,'emp_id'=>$student_id,'status'=>1,'attempt'=>1 ));
                $postdata['assessment_id'] 	    = $result_id;  
                $postdata['attempt'] 		   = 1;
           }else{
                $ass_id=$this->common->get_name_by_id('assessment','id',array('emp_id' => $student_id,'course_id'=>$course_id,'status'=>1));
                
                $attempt=$this->Api_model->get_attemptcount($student_id,$ass_id);
                $up_data=array('assessment_id'=>$ass_id,
                'emp_id'=>$student_id,'status'=>1,'attempt'=>$attempt+1 );
                $this->Api_model->insert_assessment_details($up_data);
                $postdata['assessment_id'] 	    = $ass_id;  
                $postdata['attempt'] 		   = $attempt+1;
        }
            

        foreach($question_id as $key=>$question_ids){
          array_push($ques,$question_ids);
          if (array_key_exists($question_ids,$ans)){
          array_push($ans1,$ans[$question_ids]);
        }
            $corr_ans=$this->user_model->get_ans_questionId($question_ids);
                foreach($corr_ans as $row)
                {
                array_push($ans2,$row->option_number);
                array_push($choice_selected,$row->option_id);
                }
        }
      //  print_r($ans1);die();
      //  $is_correct="";
        foreach($ans1 as $key=>$val){
            if($val==$ans2[$key]){
              $is_correct 		        = true; 
            }else{
              $is_correct 		        = false; 
           } 
           array_push($correctans,$is_correct);  
        }
        //print_r($correctans);
        foreach($ques as $key1=>$ques_ids){
                    $choiceselected = "";
                    $correct_ans    = 0;
                    if (array_key_exists($key1,$choice_selected)){
                    $choiceselected 		    = $choice_selected[$key1]; 
                    }
                    if (array_key_exists($key1,$correctans)){
                    $correct_ans 		        = $correctans[$key1]; 
                    }
                    $answer_list=array('question_id'=>$ques_ids,'is_correct'=>$correct_ans,'choice_selected'=>array($choiceselected));
          array_push($answer_lists,$answer_list);
         }
                 
       $postdata['answer_list']=$answer_lists;
       $jData['method'] = "api/FinishAssessment";
       $jData['type'] = "POST";
       $jData['data'] = json_encode($postdata);
       //print_r($jData['data']);die();
       $this->data['examgrade'] = array();
       $this->session->unset_userdata('session_data');//unset question array
       $mapResponse = json_decode($this->api->rest_api_call($jData));
       if(!empty($mapResponse)) {
        $this->data['examgrade'] = $mapResponse->data;
       }
       $this->data['exam'] = $this->user_model->get_exam_result($student_id);
       $this->data['questioncount']=$this->user_model->get_question_count($student_id,$course_id);
       $this->data['result_publish']=$this->common->get_name_by_id('am_classes','result_publish',array('class_id' => $course_id));
       echo $this->load->view('student/student_finishpage', $this->data, TRUE);             
    }
    public function student_certificate()
    {
        $course_id = $this->input->post('course_id');
        $student_id = $this->session->userdata('user_id');
        $assessment_id=$this->common->get_name_by_id('assessment','id',array('emp_id' => $student_id,'course_id'=>$course_id,'status'=>1));
        $training_id=$this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id'=>$student_id,'course_id'=>$course_id,'status'=>1));

        $myObj = Array();
        $myObj= new stdClass;
        $myObj->emp_id = $student_id;
        $myObj->assessment_id = $assessment_id;
        $myObj->training_id = $training_id;
        $myObj->assessment_status = "Approved";
        $jData['method'] = "api/Create_certificate";
        $jData['type'] = "POST";
        $jData['data'] = json_encode($myObj); 
        $mapResponse = json_decode($this->api->rest_api_call($jData));
        if(!empty($mapResponse)) {
            if($mapResponse->statusCode==200) {
                $response['statusCode'] = 200;
                $response['status']     = TRUE;
                $response['message']    = 'Certificate generated successfully completed';
                $response['data']       = $mapResponse->data->certificate_url;
            } else {
                $response['statusCode'] = 500;
                $response['status']     = FALSE;
                $response['message']    = 'Exam not completed';
                $response['data']       = Null;
            }
        } else {
            $response['statusCode'] = 500;
            $response['status']     = FALSE;
            $response['message']    = 'Exam not completed';
            $response['data']       = Null;
        }
        print_r(json_encode($response));
        // $url="";
        // $this->load->library('pdf');
        // $pdf = $this->pdf->load();
        // $pdf->autoPageBreak = false;
        // $pdf->AddPage('L');
        // $pdf->WriteHTML(); 
        // $pdf->Output($url, "F");


    }
	public function student_result($course_id)
    {
        $student_id = $this->session->userdata('user_id');
        $this->data['course_id']=$course_id;
        $this->data['attempt']=$this->user_model->get_lastattempt($student_id,$course_id);
        $this->data['questioncount']=$this->user_model->get_question_count($student_id,$course_id);
        $subject_Id= $this->user_model->get_subjectId_courseid($course_id);
        $questionset_Ids= array(); 
        $questionid= array(); 

        $this->data['questionset']    = array(); 
        $this->data['options']    = array(); 
        if(!empty($subject_Id)) {
         foreach($subject_Id as $row){
             $module=$this->user_model->get_moduleIdBy_subject($row->subject_id);
             if(!empty($module)) {
             foreach($module as $row1){
               $questions=$this->user_model->get_questionsetBy_subject($row1->subject_id);
               if(!empty($questions)) {
                foreach($questions as $row2){
                  // echo '<pre>'; print_r($options);
                    array_push($questionset_Ids, $row2->question_set_id);
                }
               }
             }
           }
         }
       }
       if(!empty($questionset_Ids)) {
       $this->data['questionset']=$this->user_model->get_questionset($questionset_Ids);

       foreach($this->data['questionset'] as $row3){
          array_push($questionid, $row3->question_id);
      }
      $this->data['results']=$this->user_model->get_resultset($questionid,$student_id);
      

       }
      // echo $this->db->last_query();

       $this->data['viewload'] = 'student/student_result';
       $this->load->view('_layouts_new/_master', $this->data);
       
    }

	public function get_attemptresult()
    {
        $course_id = $this->input->post('id');
        $student_id = $this->session->userdata('user_id');
        $this->data['course_id']=$course_id;
        $this->data['attempt']=$this->user_model->get_lastattempt($student_id,$course_id);
        $this->data['questioncount']=$this->user_model->get_question_count($student_id,$course_id);
         // echo $this->db->last_query();
        $subject_Id= $this->user_model->get_subjectId_courseid($course_id);
        $questionset_Ids= array(); 
        $questionid= array(); 

        $this->data['questionset']    = array(); 
        $this->data['options']    = array(); 
        if(!empty($subject_Id)) {
         foreach($subject_Id as $row){
             $module=$this->user_model->get_moduleIdBy_subject($row->subject_id);
             if(!empty($module)) {
             foreach($module as $row1){
               $questions=$this->user_model->get_questionsetBy_subject($row1->subject_id);
               if(!empty($questions)) {
                foreach($questions as $row2){
                  // echo '<pre>'; print_r($options);
                    array_push($questionset_Ids, $row2->question_set_id);
                }
               }
             }
           }
         }
       }
       if(!empty($questionset_Ids)) {
       $this->data['questionset']=$this->user_model->get_questionset($questionset_Ids);

       foreach($this->data['questionset'] as $row3){
          array_push($questionid, $row3->question_id);
      }
      $this->data['results']=$this->user_model->get_resultset($student_id, $course_id);
      

       }
      // echo $this->db->last_query();

    //    $this->data['viewload'] = 'student/student_result';
    //    $html = $this->load->view('_layouts_new/_master', $this->data, TRUE);
       $html = $this->load->view('student/student_result_ajax', $this->data, TRUE);
       echo $html;
    }

	 public function gm_user_registration($username = NULL, $password = NULL, $userId = NULL) {
      // Authentication Api call
      $postdata['grant_type'] 		= 'password'; 
      $postdata['username'] 		= 'gm_admin'; 
      $postdata['password'] 		= 'password';
      $postdata['scope'] 		    = 'read write trust'; 
      $jsonData['method']           = "oauth/token?grant_type=password&username=gm_admin&password=password&client_id=grandmaster-client&client_secret=grandmaster-secret&scope=read+write+trust";
      $jsonData['type'] = "POST"; 
      $jsonData['data'] = array(); 
      $ajaxResponse = json_decode($this->common->rest_api_auth($jsonData));
    // User insert api cal  
      $data['id'] 		        = $userId;
      $data['password'] 		= $password; 
      $data['userName'] 		= $username; 
      $data['role']['id']       = 2;     
      $jsonData['access_token'] = $ajaxResponse->access_token; 
      $jsonData['method']       = "createOrUpdateUser";
      $jsonData['type']         = "POST"; 
      $jsonData['data']         = json_encode($data); 
      $ajaxResponse = json_decode($this->common->rest_api_call($jsonData));
    }

    
/*
*   function'll get student attended exam list
*   @params student id    
*   @author GBS-R
*/
    
public function myexams(){
    $student_id = $this->session->userdata('user_id');
    $this->data['myexams'] = $this->user_model->get_student_exams($student_id); 
    // show($this->data['myexams']);
    echo $this->load->view('student/student_exams_view', $this->data, TRUE); 
}    



/*
*   function'll get exam details
*   @params student id, exam_id
*   @author GBS-R
*/
    
public function exam_details(){
    $question_paper_id = '';
    $student_id = $this->session->userdata('user_id');
    $exam_id    = $this->input->post('exam_id');
    $attempt    = $this->input->post('attempt');
    $myexam     = $this->user_model->get_student_examdetails($student_id, $exam_id, $attempt);
    $this->data['answer']       = $this->user_model->get_student_exam_question_details($student_id, $exam_id, $attempt);
    $this->data['myexams']      = $myexam;
    $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
    if(!empty($question_paper)) {
       $question_paper_id =  $question_paper['question_paper_id'];
    }
    $this->data['questions']    = array(); 
    $section_ids = $this->common->get_section_ids_byexam_id($exam_id);
    $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids);
     //echo '<pre>';print_r($questions); die();
    if(!empty($questions)) {
        foreach($questions as $key=>$question){
            $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
            $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
            $questions[$key]->subject_name= $sectionDet['section_name'];
            
        }
    }
    //echo '<pre>';print_r($questions); die();
    $this->data['questions']    = $questions;
    // show($this->data);
    echo $this->load->view('student/student_exams_details_view', $this->data, TRUE);
}
    
/*
*   function'll get time taken distribution foreach questions
*   @params student id, exam_id
*   @author GBS-R
*/
    
public function taken_distribution_details(){
    $student_id = $this->session->userdata('user_id');
    $exam_id    = $this->input->post('exam_id');
    $attempt    = $this->input->post('attempt');
    $myexam     = $this->user_model->get_student_examdetails($student_id, $exam_id, $attempt);
    $this->data['answer']       = $this->user_model->get_student_exam_question_details($student_id, $exam_id, $attempt);
    $this->data['myexams']      = $myexam;
    $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
    if(!empty($question_paper)) {
       $question_paper_id =  $question_paper['question_paper_id'];
    }
    $this->data['questions']    = array();
    $section_ids = $this->common->get_section_ids_byexam_id($exam_id);
    $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids); 
    if(!empty($questions)) {
        foreach($questions as $key=>$question){
            $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
            $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
            $questions[$key]->subject_name= $sectionDet['section_name'];
            
        }
    }
    //echo '<pre>';print_r($questions); die();
    $this->data['questions']    = $questions;
    echo $this->load->view('student/exams_time_distribution_view', $this->data, TRUE);
}

/*
*   function'll get question details
*   @params question id
*   @author GBS-R
*/

public function question_details(){ //echo '<pre>';
    $student_id                 = $this->session->userdata('user_id');
    $question_id                = $this->input->post('question_id');
    $selected_choices           = $this->input->post('selected_choices');
    $question_type              = $this->input->post('question_type'); //print_r($_POST);
    $questions                  = $this->user_model->get_question_byid($question_id);
    $selctArr                   = [];
    if($question_type==1 || $question_type==3) {
        $selctArr = explode(',', $selected_choices);
    }
    //print_r($questions);
    $this->data['questions']            =  $questions;
    $this->data['selected_choices']     =  $selected_choices;
    $this->data['question_type']        =  $question_type;
    $this->data['selctArr']             =  $selctArr;
    //show($this->data);
    echo $this->load->view('student/student_exams_question_view', $this->data, TRUE);
}

/*
*   function'll get progress report
*   @params question id
*   @author GBS-R
*/
public function progress_report(){ 
    $student_id = $this->session->userdata('user_id');
    $myexams = $this->user_model->get_student_exams($student_id); //print_r($myexams); 
    $this->data['myexams'] = $myexams;
    if(!empty($myexams)) { 
    $i=1; 
    $outof = '';
    $examStr = '';
    $sectionStr ='';
    $colorcombo = ''; 
    $sectionArr = array();   
    foreach($myexams as $mark) {  //echo '<pre>';print_r($mark); 
        //$examStr .= "'".$mark->exam_name."[A".$mark->attempt."]',";
        $examStr .= "'".$mark->name."[A".$mark->attempt."]',";
        $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
        $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
        $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
        if(!empty($question_paper)) {
           $question_paper_id =  $question_paper['question_paper_id'];
        }
        $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id); //print_r($section_ids);
        $this->data['questions']    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids);
        $questions = $this->data['questions'];
        if(!empty($questions)) {
           foreach($questions as $key=>$question) { //print_r($question);
            $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
            $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
            $questions[$key]->subject_name= $sectionDet['section_name'];
            array_push($sectionArr, $question->subject_id);
           }
           $sectionArr = array_unique($sectionArr);
        }
        $i++;
    }
            $pie        = '';
			$actualsecMark = 0;
            $colors[0]  = '#7cb5ec';
            $colors[1]  = '#434348';
            $colors[2]  = '#90ed7d';
            $colors[3]  = '#f7a35c';
            $colors[4]  = '#e4d354';
            $colors[5]  = '#f15c80';
            $colors[6]  = '#91e8e1';
            $colors[7]  = '#2b908f';
            $colors[8]  = '#f45b5b';
            $colors[9]  = '#f8aec0';
            $colors[10]  = '#0f487f';
            $colors[10]  = '#0f487f';
            $colors[10]  = '#0f487f';
            $colors[11]  = '#ffcccc';$colors[12]  = '#ff9999';$colors[13]  = '#ffcc99';$colors[14]  = '#ffa64d';
            $colors[15]  = '#cc6600';$colors[16]  = '#ff9933';$colors[17]  = '#cccc00';$colors[18]  = '#999900';
            $colors[19]  = '#cccc00';$colors[20]  = '#ff00ff';$colors[21]  = '#cc00cc';$colors[22]  = '#ffccff';
            $colors[23]  = '#b3b3ff';$colors[24]  = '#3333ff';$colors[25]  = '#66e0ff';$colors[26]  = '#ccf5ff';
            $colors[27]  = '#008fb3';$colors[28]  = '#1affc6';$colors[29]  = '#00cc99';$colors[30]  = '#b3ffec';
            $colors[31]  = '#ffcccc';$colors[32]  = '#ff9999';$colors[33]  = '#ffcc99';$colors[34]  = '#ffa64d';
            $colors[35]  = '#cc6600';$colors[36]  = '#ff9933';$colors[37]  = '#cccc00';$colors[38]  = '#999900';
            $colors[39]  = '#cccc00';$colors[40]  = '#ff00ff';$colors[41]  = '#cc00cc';$colors[42]  = '#ffccff';
            $colors[43]  = '#b3b3ff';$colors[44]  = '#3333ff';$colors[45]  = '#66e0ff';$colors[46]  = '#ccf5ff';
            $colors[47]  = '#008fb3';$colors[48]  = '#1affc6';$colors[49]  = '#00cc99';$colors[50]  = '#b3ffec';
            $ccnt = 0; //echo '<pre>';print_r($sectionArr);
            foreach($sectionArr as $section) { //echo '<pre>';print_r($section); 
            	$sectotal   = 0;
				$actualmark = 0;
                //$sectionDet = $this->common->get_from_tablerow('gm_exam_section_config', array('id'=>$section)); 
                $sectionDet = $this->common->gm_exam_section_config_subject_id($section); //print_r($sectionDet);
                $colorcombo .= "'".$colors[$ccnt]."',";
                $sectionStr .= "{name: '".$sectionDet['section_name']."',data: [";//11, 20, 20]},
                $sectionmarkStr = '';
                foreach($myexams as $mark) {  //print_r($mark);
                    $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
                    $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
                    $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
                    if(!empty($question_paper)) {
                       $question_paper_id =  $question_paper['question_paper_id'];
                    }
                    $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id);
                    $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids); 
                    $sectionArr = array();
                    if(!empty($questions)) {
                        foreach($questions as $key=>$question) { 
                         $sectionDett = $this->common->get_section_nameby_details($question->exam_section_details_id); 
                         $questions[$key]->subject_id= $sectionDett['exam_section_config_id'];
                         $questions[$key]->subject_name= $sectionDett['section_name'];
                         array_push($sectionArr, $question->subject_id);
                        }
                        $sectionArr = array_unique($sectionArr);
                     }
                    $pmark 		= 0;
                    $nmark		= 0;
                    foreach($questions as $question) {
                        if($question->subject_id==$section){
                             $anserclass = '';
                            $st_answer = $this->common->get_student_answer($mark->attempt, $mark->exam_id, $this->session->userdata('user_id'), $question->question_id);  
                            if(!empty($st_answer)) {
									$actualmark += $st_answer->actual_mark;
                                if($st_answer->correct==1) {
                                     $pmark += $st_answer->mark;   
                                } else {
                                    $nmark += $st_answer->negative_mark; 
                                }
                            }
                        }
                    }
                    $sectiontotal = $pmark-$nmark;
                    $sectionmarkStr .=  $sectiontotal.',';
                    $sectotal += $sectiontotal;
                	}  
                    $pie .= "['".$sectionDet['section_name'];
                    if($actualmark>0) {
                    $sectiontotalperctage 	= $sectotal/$actualmark;
                    } else {
                    $sectiontotalperctage   = 0;    
                    }
                    $actualsecMark 			= $sectiontotalperctage*100;
                    if($actualsecMark<0) {
                        $actualsecMark = 0;
                    }
                    $pie .= "', ".number_format($actualsecMark,2)."],"; 
                    $sectionStr .= substr($sectionmarkStr, 0, -1)."]},";
                    $ccnt++;
            }//die();
    $examStr                    = substr($examStr, 0, -1); 
    $sectionStr                 = substr($sectionStr, 0, -1);   
    $pie                        = substr($pie, 0, -1);    
    $this->data['exams']        = $examStr; 
    $this->data['sectionStr']   = $sectionStr; 
    $this->data['sectionpie']   = $pie;   
    $this->data['color']        = $colorcombo;     
    }
    echo $this->load->view('student/student_progress_report_view', $this->data, TRUE); 
}

    // public function halltkt_add($notification_id){
    // // {
    // //     if($_POST)
    // //     {
    // //          $data = $_POST;
    // //          $student_id = $this->session->userdata('user_id');
    // //          $res = $this->user_model->halltkt_add($data);
    // //          // echo $this->db->last_query();
    // //          if($res != 0){
    // //              $res=1;  
    // //          }
    // //          print_r($res);
    // //     }
    // // }
    //     $i = 0;
    //     $notification_id       = $this->input->post('notification_id')[$i];
    //     // print_r($notification_id);
    //     // die();
    //     $student_id   = $this->input->post('student_id');
    //     unset($_POST['student_id']);
    //     $hall_tktArr        = $this->input->post('hall_tkt');
        
    //     if(!empty($notification_id)){
    //         // foreach($notification_id as $noti){
    //             if($notification_id[$i]!==NULL){
    //                 $exist=$this->user_model->is_halltkt_exist($student_id,$notification_id[$i]);
    //                 // echo $this->db->last_query();
    //                 if($exist != 0){
    //                     $old = $this->common->get_from_table('web_examlist', array("student_id"=>$student_id));
    //                     $data = array(
    //                             'hall_tkt'=>$hall_tktArr[$i],
    //                             'notification_id'=>$notification_id[$i],
    //                             'student_id'=>$student_id
    //                     );
    //                     $result=$this->user_model->edit_exams($student_id,$data,$notification_id[$i]);
    //                     $message="Edit Hall Ticket";
    //                     $action="Update";
    //                     $table_row_id=$student_id;
    //                     $html=$table_row_id;
    //                 }else{
    //                     $old=""; 
    //                     $data = array( 
    //                             'hall_tkt'=>$hall_tktArr[$i],
    //                             'notification_id'=>$notification_id[$i],
    //                             'student_id'=>$student_id
    //                     );
    //                     $result=$this->user_model->halltkt_add($data);
    //                     $message="Add Hall Ticket";
    //                     $action="insert";
    //                     $table_row_id=$this->db->insert_id();
    //                     $html=$table_row_id;
    //                 }
    //             }
    //             $i++;
    //         // }
    //     }
    // print_r($result);
    // }

    public function halltkt_add(){
        $i = 0;
        $notification_id       = $this->input->post('notification_id');
        $student_id   = $this->input->post('student_id');
        unset($_POST['notification_id']);
        $hall_tktArr        = $this->input->post('hall_tkt');
       
        if(!empty($notification_id)){
            foreach($notification_id as $noti){
                if($notification_id[$i]!==NULL){
                    $exist=$this->user_model->is_halltkt_exist($student_id,$notification_id[$i]);
                    // echo $this->db->last_query();
                    // print_r($exist);
                    // die();
                    if($exist != 0){
						$deplocate = $this->user_model->is_halltkt_duplicatedit($hall_tktArr[$i], $student_id);
						if($deplocate==0) {
                        $old = $this->common->get_from_table('web_examlist', array("student_id"=>$student_id));
                        $data = array(
                                'hall_tkt'=>$hall_tktArr[$i]
                                // 'notification_id'=>$notification_id[$i],
                                // 'student_id'=>$student_id,
                                // 'examlist_id'=>$this->input->post('examlist_id')

                        );
                        $result=$this->user_model->edit_exams($student_id,$notification_id[$i],$data);
                        // echo $this->db->last_query();
                        // print_r($result);
                        // die();
                        $message="Edit Hall Ticket";
                        $action="Update";
                        $table_row_id=$student_id;
                        $html=$table_row_id;
						} else {
							$result = 2;
							break;
						}
                    }else{
						$deplocate = $this->user_model->is_halltkt_duplicate($hall_tktArr[$i]);
						if($deplocate == 0) {
                            $old=""; 
                            $data = array( 
                                'hall_tkt'=>$hall_tktArr[$i],
                                'notification_id'=>$notification_id[$i],
                                'student_id'=>$student_id
                            );
                            $result=$this->user_model->halltkt_add($data);
                            $message="Add Hall Ticket";
                            $action="insert";
                            $table_row_id=$this->db->insert_id();
                            $html=$table_row_id;
						} else {
							$result = 2;
							break;
						}
                    }
                }
                $i++;
            }
        }
        print_r($result);
    }
public function halltkt_edit()
    {
    
        // $id = $this->input->post('examlist_id');
        // unset($_POST['examlist_id']);
        // $data = $_POST;
        // $res = $this->user_model->edit_exams($data, $id);
        // echo $this->db->last_query();
        // if($res != 0){
        //     $res=1;  
        // }
        // print_r($res);
        if($_POST){
            $id = $this->input->post('examlist_id');
            unset($_POST['examlist_id']);
            $data = $_POST;
            $res = $this->user_model->edit_exams($data, $id);
            // echo $this->db->last_query();
            if($res=1){
                $who=$this->session->userdata['user_id'];
                $user_id=$this->session->userdata['user_primary_id'];
                $what=$this->db->last_query();
                logcreator('update', 'database', $who, $what, $user_id, 'web_examlist','Successfully Updated');
            }
            print_r($res);
        }
    }
    

    // Messenger ........................................................ 

    public function get_messages() {
        if($_POST)
        {
            $message = $this->Messanger_model->get_messages($this->input->post('id'),$this->input->post('from'));
            // echo "<pre>"; print_r($message); exit;
            $data='';
            if(isset($message)){if(!empty($message)){$id=$this->session->userdata['user_id']; 
            if($message[0]->receiver==$id){$name = $message[0]->sender_name;}else{$name = $message[0]->receiver_name;}
            $data=$data.'<div class="msg_view_dp">
                            <h4>'.$name.'</h4>
                        </div>
                            <div class="chatbox msg_view" id="boxscroll">';
            foreach($message as $msg){
                if(!empty($msg->attachment)){
                    $file = '<br><a title="download" target="_blank" href="'.base_url($msg->attachment).'"><span class="fa fa-download" >&nbsp;</span>Attachment</a>';
                }else{$file='';}
                if($msg->receiver == $id){ 
                    $data=$data.'<div class="chatbody">
                                    <div class="chatext">
                                        <p><span>'.$msg->message.$file.'</span><br><font class="msg_time">'.date('M-d h:i a',strtotime($msg->send_date)).'</font></p>
                                    </div>
                                </div>';
                }if($msg->sender == $id){
                    $data=$data.'<div class="chatbody">
                                    <div class="chatextrtl">
                                        <p><span>'.$msg->message.$file.'</span><br><font class="msg_time">'.date('M-d h:i a',strtotime($msg->send_date)).'</font></p>
                                    </div>
                                </div>';
                }}
            $data=$data.'</div>
                                <div class="form-row align-items-center Messengerbox">
                                    <div class="col-12">
                                        <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                        <div class="input-group mb-2">
                                            <textarea class="form-control" id="message_text" rows="3"></textarea>
                                            <div class="input-group-prepend">
                                            <button onClick="sendMessage()" class="input-group-text"><i class="fa fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
             }}
             echo $data;
        }
    }
    public function send_message() {
        if($_POST)
        {
            $message = $this->input->post('message');
            $conv_id = $this->input->post('conv_id');
            $from = $this->input->post('from');
            if($this->Messanger_model->send_message($message,$conv_id,$from)){
                echo '<div class="chatbody">
                        <div class="chatextrtl">
                            <p><span>'.$message.'</span><br><font class="msg_time">'.date('M-d h:i a').'</font></div>
                        </div>
                    </div>';
            }else{
                echo '<div class="msg-pos2" style="background-color:red;color:white;"><span>Server Busy Please Try again Later</span></div>';
            }
        }
    }
    public function start_conversation() {
        if($_POST)
        {
            $from_id = $this->session->userdata('user_id'); 
            if(!empty($_FILES['attachment']['name']))
            {
                $folder = time();
                mkdir('./uploads/messages/'.$folder,0777,TRUE);
                $config['upload_path'] = './uploads/messages/'.$folder;
                $filename = "";
                $config['file_name'] = $_FILES['attachment']['name'];
                $config['allowed_types'] = '*';
                $config['max_size'] = '1000000';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('attachment')) {
                    $path = array($this->upload->data());
                    $filename = $path[0]['file_name'];
                    $file_path = 'uploads/messages/'.$folder.'/'.$filename;
                }
            }else{$file_path='';}
            $to = $this->input->post('to');
            foreach($to as $key=>$val)
            {
                $conversation[$key]=array(
                    'from'=>$from_id,
                    'to'=>trim($val),
                    'subject'=>$_POST['subject'],
                    'started_date'=>date('Y-m-d H:i:s')
                );
            }
            // show($conversation);
            $id = $this->Messanger_model->start_conversation($conversation,$this->input->post('message'),$file_path);
            if($id=='a'){
                $ajax_response['st']=2;
                $ajax_response['msg']="Conversation started successfully..!";
            }else{
                $ajax_response['id']=$id;
                $ajax_response['st']=1;
                $ajax_response['msg']="Conversation started successfully..!";
            }
        
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!1";
        }
        print_r(json_encode($ajax_response));
    }
    public function get_conversation() {
        $id=$this->session->userdata('user_id');
        $type = $this->input->post('id');
        $conversations = $this->Messanger_model->get_conversations();
        $html = '<table class="table table-bordered table-sm ExaminationList">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Date &amp; Time</th>
                            <th>Action</th>
                        </tr>';
        if(!empty($conversations)){
            foreach($conversations as $conv){
                $status = 1;
                if ($type == 'Read'){
                    $f = 0;
                }else if($type == 'Archive'){
                    $f = 1;
                }else if($type == 'Unread'){
                    $f = 0;
                    $status = 0;
                }
                if($conv['status']==$status && $conv['archieved']==$f){
        $html .= '<tr>
                    <td>';
                        if($conv['from']==$id){$name = $conv['to_name'];}else{$name = $conv['from_name'];}
                        $html .= $name;
        $html .= '  </td>
                    <td>'.$conv['subject'].'</td>
                    <td>'.date('M-d h:i a',strtotime($conv['started_date'])).'</td>
                    <td>
                        <button onClick="showMessage('.$conv['id'].')" class="fa fa-eye" data-toggle="tooltip" title="View Message"></button>';
                        if ($type == 'Read'){
                            $html .= '<button onClick="msgarchive('.$conv['id'].')" class="fa fa-archive" data-toggle="tooltip" title="Archive this conversation"></button>';
                        }
        $html .='</td>
                </tr>';
                }
            }
        }
        echo $html;
    }
    public function archive_conversation(){
        $id = $this->input->post('id');
        if($id == ''){
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        else{
            if($this->Messanger_model->archieve_conversation($id)){
                $ajax_response['st']=1;
                $ajax_response['msg'] = "Conversation archived successfully..!";
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }
        print_r(json_encode($ajax_response));
}
    
    /*
*   function'll get homework details
*   @params student id, batch_id
*   @author GBS-L
*/
    
public function homework()
{
    $student_id = $this->session->userdata('user_id');
    $batches = $this->user_model->get_student_batch($student_id); 
    $homework=array();
    if(!empty($batches)) 
    {
        foreach($batches as $row)
        {
           $homework= $this->common->get_alldata('am_homework',array("batch_id"=>$row,"status"=>1)); 
     
        } 
         $this->data['homeworks']=$homework;
    }
    echo $this->load->view('student/student_homework_list', $this->data, TRUE);   
}
 /*
*   function'll add homework details
*   @params 
*   @author GBS-L
*/   
    public function add_homework()
    {
            $cpt = count($_FILES['file_name']['name']);
            for($i=0; $i<$cpt; $i++){
                $config = array();
                $files = str_replace(' ', '_', $_FILES['file_name']['name'][$i]);
                $_FILES['file']['name']       = $_FILES['file_name']['name'][$i];
                $_FILES['file']['type']       = $_FILES['file_name']['type'][$i];
                $_FILES['file']['tmp_name']   = $_FILES['file_name']['tmp_name'][$i];
                $_FILES['file']['error']      = $_FILES['file_name']['error'][$i];
                $_FILES['file']['size']       = $_FILES['file_name']['size'][$i];
                $ext = pathinfo($_FILES["file_name"]["name"][$i])['extension'];
                $homework_newname = 'homework_'.$_FILES['file_name']['size'][$i].'_'.rand();
                $config['upload_path']           = 'uploads/homeworks/';
                $config['allowed_types']         = 'jpg|jpeg|png'; 
                $config['file_name']= $homework_newname;
                $this->load->library('upload');
                $this->upload->initialize($config);   
                $upload = $this->upload->do_upload('file'); 
                if($upload)
                {
                    $data=array();
                  $data['file_name'] =$homework_newname.'.'.$ext;;
                  $data['remarks'] =$this->input->post('remark');
                  $data['student_id'] = $this->session->userdata('user_id');  
                  $data['submitted_date'] = date('Y-m-d'); 
                  $data['homework_id'] =$this->input->post('assignment_no'); 
                  $data['status'] =1; 
                  $response=$this->Common_model->insert('am_student_homeworks',$data);
                  if($response !=0)
                  {
                    $ajax_response['st']   =1;
                    $ajax_response['message']=  "Successfully added homework";  
                  }
                  else
                  {
                     $ajax_response['st']   =2;
                     $ajax_response['message']=  "Something went wrong,Please try again later..!";  
                  }
                }else{

                    $ajax_response['st']= 2; //file type error
                    $ajax_response['message']= $this->upload->display_errors();
                }
            }
        print_r(json_encode($ajax_response));
    }
    public function add_homework_old()
    {
        if($_FILES['file_name']['name'] !="")
        {
            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            $config['upload_path']           = 'uploads/homeworks/';
            $config['allowed_types']        = 'jpg|jpeg|png';
            $config['max_size'] = '10000';
            $_FILES['file_name']['size']     = $files['size'];
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');
            $fileData = $this->upload->data();
            if(!$upload)
            {
                 $ajax_response['st']   =3;
                 $ajax_response['message']=  $this->upload->display_errors();
                 print_r(json_encode($ajax_response));
                 return false;
            }
             else
             {    $data=array();
                  $data['file_name'] ='uploads/homeworks/'. $fileData['file_name'];
                  $data['remarks'] =$this->input->post('remark');
                  $data['student_id'] = $this->session->userdata('user_id');  
                  $data['submitted_date'] = date('Y-m-d'); 
                  $data['homework_id'] =$this->input->post('assignment_no'); 
                  $data['status'] =1; 
                  $response=$this->Common_model->insert('am_student_homeworks',$data);
                  if($response !=0)
                  {
                    $ajax_response['st']   =1;
                    $ajax_response['message']=  "Successfully added homework";  
                  }
                  else
                  {
                     $ajax_response['st']   =2;
                     $ajax_response['message']=  "Something went wrong,Please try again later..!";  
                  }
                 
             }  
        }
        else
        {
          $ajax_response['st']   =2;
          $ajax_response['message']=  "Something went wrong,Please try again later..!";  
        }
        print_r(json_encode($ajax_response));
    }
    
    public function get_homework_details()
    {
        if($_POST)
        {
            $homework_id=$this->input->post('homework_id');
            $student_id = $this->session->userdata('user_id');
            $exist=$this->common->check_if_dataExist('am_student_homeworks',array("student_id"=>$student_id,"homework_id"=>$homework_id));
            if($exist!=0)
            {
                $data=$this->common->get_from_tableresult('am_student_homeworks', array("student_id"=>$student_id,"homework_id"=>$homework_id));
                /*foreach($data as $row)
                {
                  $data['submitted_date']=date('d-m-Y',strtotime($row->submitted_date));   
                }*/
               
                $ajax_response['data']=$data;
                $ajax_response['st']=1; 
                
            }
            else
            {
             $ajax_response['st']=0;    
            }
            print_r(json_encode($ajax_response));
        }
    }
    
    public function edit_homework()
    {
        /*print_r($_POST);
        print_r($_FILES);*/
          if(isset($_FILES['file_name']['name']))
          {
            $cpt = count($_FILES['file_name']['name']);  
          
         
         for($i=0; $i<$cpt; $i++){
            if($_FILES['file_name']['name'][$i] !="")
            {
                $config = array();
                $files = str_replace(' ', '_', $_FILES['file_name']['name'][$i]);
                $_FILES['file']['name']       = $_FILES['file_name']['name'][$i];
                $_FILES['file']['type']       = $_FILES['file_name']['type'][$i];
                $_FILES['file']['tmp_name']   = $_FILES['file_name']['tmp_name'][$i];
                $_FILES['file']['error']      = $_FILES['file_name']['error'][$i];
                $_FILES['file']['size']       = $_FILES['file_name']['size'][$i];
                $ext = pathinfo($_FILES["file_name"]["name"][$i])['extension'];
                $homework_newname = 'homework_'.$_FILES['file_name']['size'][$i].'_'.rand();
                $config['upload_path']           = 'uploads/homeworks/';
                $config['allowed_types']         = 'jpg|jpeg|png'; 
                $config['file_name']= $homework_newname;
                $this->load->library('upload');
                $this->upload->initialize($config);   
                $upload = $this->upload->do_upload('file'); 
                if($upload)
                {
                    $data=array();
                  $data['file_name'] =$homework_newname.'.'.$ext;
                  $data['remarks'] =$this->input->post('remark');
                  $data['student_id'] = $this->session->userdata('user_id');  
                  $data['submitted_date'] = date('Y-m-d'); 
                  $data['homework_id'] =$this->input->post('homework_id'); 
                  $data['status'] =1; 
                  $response=$this->Common_model->insert('am_student_homeworks',$data);
                  if($response !=0)
                  {
                      $flag=1;
                    
                  }
                  else
                  {
                       $flag=0;
                     
                  }
                }else{

                    $ajax_response['st']= 2; //file type error
                    $ajax_response['message']= $this->upload->display_errors();
                }
            }
        }
          }
        $edit_ids=$this->input->post('edit_id');
        $edit_data=array();
        foreach($edit_ids as $id)
        {
           if($_FILES['editfile_name_'.$id]['name'] !="")
           {
                //echo $_FILES['editfile_name_'.$id]['name'];
                $files = str_replace(' ', '_', $_FILES['editfile_name_'.$id]);
                $ext = pathinfo($_FILES["editfile_name_".$id]["name"])['extension'];
                $homework_newname = 'homework_'.$_FILES['editfile_name_'.$id]['size'].'_'.rand();
                $this->load->library('upload');
                $config['upload_path']           = 'uploads/homeworks/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size'] = '10000';
                $_FILES['file_name']['size']     = $files['size'];
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('editfile_name_'.$id);
                $fileData = $this->upload->data();
                if(!$upload)
                {
                 $ajax_response['st']   =2;
                 $ajax_response['message']=  $this->upload->display_errors();
                 print_r(json_encode($ajax_response));
                 return false;
                }
               else
               {
                  $edit_data['file_name'] =$homework_newname.'.'.$ext; 
               }     
           }
          else
          {
                $edit_data['file_name'] =$this->input->post('browse_'.$id); 
              
          }
              $edit_data['remarks'] =$this->input->post('remark');
              $edit_data['student_id'] = $this->session->userdata('user_id');  
              $edit_data['submitted_date'] = date('Y-m-d'); 
              $edit_data['homework_id'] =$this->input->post('homework_id'); 
              $edit_data['status'] =1; 
              $edit_response=$this->Common_model->update('am_student_homeworks', $edit_data,array("student_id"=>$edit_data['student_id'],"homework_id"=> $edit_data['homework_id'],'id'=>$id));
              if($edit_response)
               {
                    $flag=1;
                     
              }
              else
              {
                 $flag=0;
                  
              }
             
        }
        if($flag ==1)
        {
             $ajax_response['st']   =1;
             $ajax_response['message']=  "Successfully Updated homework details"; 
        }
        else
        {
          $ajax_response['st']   =0;
          $ajax_response['message']=  "Something went wrong,Please try again later..!";   
        }
        print_r(json_encode($ajax_response));
        
    }
    
    public function delete_homework()
    {
       
        if($_POST)
        {
            $data['student_id']=$this->session->userdata('user_id');   
            $data['homework_id']=$this->input->post('homework_id');
            $data['id']=$this->input->post('edit_id');
            $response=$this->common->delete('am_student_homeworks',$data);
            if($response)
            {
                $ajax_response['st']   =1;
                $ajax_response['message']=  "Successfully deleted the file";  
            }
            else
            {
                $ajax_response['st']   =0;
                $ajax_response['message']=  "Something went wrong,Please try again later..!";   
            }
            print_r(json_encode($ajax_response));
        }
    }
    public function load_ajax_homework()
    {
        $student_id = $this->session->userdata('user_id');
        $batches = $this->user_model->get_student_batch($student_id); 
        $homework=array();
        if(!empty($batches)) 
        {
            $html="";
            foreach($batches as $row)
            {
            $homework= $this->common->get_alldata('am_homework',array("batch_id"=>$row,"status"=>1)); 
               $i=1;
                foreach($homework as $row)
                {
                    $batch_id=$row['batch_id'];
                    $batch_name= $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array('batch_id'=>$batch_id));
                    $student_id=$this->session->userdata('user_id'); 
                        $exist=$this->common->check_if_dataExist('am_student_homeworks',array("homework_id"=>$row['id'],"student_id"=>$student_id));
                         if($exist==0) 
                         {
                           $homework_status= "Pending";  
                         }
                       else
                       {
                           $status=$this->common->get_name_by_id('am_student_homeworks','status',array('student_id'=>$student_id,'homework_id'=>$row['id']));
                           if($status == 1)
                           { 
                                 $homework_status= "Submitted";
                           }
                           elseif($status == 2)
                           { 
                                 $homework_status= "Verified";
                           }
                           else
                           {
                                 $homework_status= "Pending";
                           }
                       }
                    $button="";
                    if($exist != 0) { 
                        if($status !=2)
                        {
                            $button.='<button class="btn btn-default option_btn " title="Edit" onclick="add_homework('.$row['id'].')"><i class="fa fa-pencil "></i></button> ';
                        }
                        $button.=' <button class="btn btn-default option_btn " title="View" onclick="view_homework('.$row['id'].')"><i class="fa fa-eye "></i></button> ';
                     }
                    else
                    {
                      $button.=' <button class="btn btn-default option_btn " title="Edit" onclick="add_homework('.$row['id'].')"><i class="fa fa-pencil "></i></button>';  
                    }
                  $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$batch_name.'</td>
                        <td>'.$row['title'].'</td>
                        <td>'.$row['description'].'</td>
                        <td>'.date('d-m-Y',strtotime($row['date_of_submission'])).'</td>
                        <td>'.$homework_status.'</td>
                        <td>'.$button.'</td>
                         </tr>';  
                    $i++;
                }
     
            } 
            echo $html;
        }  
    }
    public function studymaterials(){
        $student_id = $this->session->userdata('user_id');
        $batch = $this->user_model->get_student_active_batch($student_id); //print_r($batch);
        $this->data['learningModule'] = $this->common->get_upcomming_learning_module($batch->batch_id); 
        // show($this->data['learningModule']);
        // if(!empty($batch)) {
        //     $school_id = $batch->school_id;
        //     $this->data['batch'] = $batch;
        //     // $this->data['attendance'] = $this->common->get_student_attendance($batch->batch_id);    
        // }
        echo $this->load->view('student/student_study_materials_view', $this->data, TRUE); 
    }


    public function study_subject_materials($id){
        $student_id = $this->session->userdata('user_id');
        $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
        $this->data['course'] = $id;
        //$batch = $this->user_model->get_student_active_batch($student_id);
      //  echo $this->db->last_query();
        $materials = $this->common->get_from_tableresult('mm_subjects', array('course_id'=>$id, 'subject_status'=>1));
        $subjectArr = [];
        if(!empty($materials)) {
            foreach($materials as $material) {
                array_push($subjectArr, $material->subject_id);
            }
        }
        if(!empty($subjectArr)) {
        $this->data['materials'] = $this->user_model->get_course_materials($subjectArr);
        }
        $this->data['course_Id'] = $this->user_model->get_courseby_subId($student_id);
       $this->data['subjects'] =   $materials;
       $this->data['viewload'] = 'student/course_subject_list_view';
       $this->load->view('_layouts_new/_master', $this->data);

     
    }



    public function coursestudy_materials($id){
        $student_id = $this->session->userdata('user_id');
        $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
        $materials = $this->common->get_from_tableresult('mm_subjects', array('parent_subject'=>$id, 'subject_status'=>1));
        $this->data['course_id'] = 0;
        $subjectArr = [];
        if(!empty($materials)) {
            foreach($materials as $material) {
                $course_id = $material->parent_subject;
                array_push($subjectArr, $material->subject_id);
            }
        } 
        $courses = $this->common->get_from_tablerow('mm_subjects', array('subject_id'=>$course_id));
        if(!empty($courses)) { $this->data['course_id'] = $courses['course_id']; }
        $matArr = array();
        if(!empty($subjectArr)) {
        foreach($subjectArr as $sub){
        //$this->data['materials'] = $this->user_model->get_course_materials($id);
        $modules = $this->user_model->get_module_materials($sub); 
        if(!empty($modules)) {
        array_push($matArr, $modules);
        }
        } 
        }
        $this->data['modules'] = $matArr;
        
       $this->data['viewload'] = 'student/student_study_notes_menuview';
       $this->load->view('_layouts_new/_master', $this->data);

     
    }

    
    public function study_materials($id){
        $student_id = $this->session->userdata('user_id');
        $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
        $this->data['course'] = $id;
        //$batch = $this->user_model->get_student_active_batch($student_id);
      //  echo $this->db->last_query();
      $this->data['subject'] = 0;  
      $materials = $this->common->get_from_tableresult('mm_subjects', array('course_id'=>$id, 'subject_status'=>1));
        $subjectArr = [];
        if(!empty($materials)) {
            $i = 1;
            foreach($materials as $material) { 
                if($i==1) {
                    $this->data['subject'] = $material->subject_id;
                }
                array_push($subjectArr, $material->subject_id);
                $i++;
            }
        }
        if(!empty($subjectArr)) {
        $this->data['materials'] = $this->user_model->get_course_materials($subjectArr);
        }
        $this->data['course_Id'] = $this->user_model->get_courseby_subId($student_id);
       $this->data['subjects'] =   $materials;
       $this->data['viewload'] = 'student/student_study_notes_view';
       $this->load->view('_layouts_new/_master', $this->data);

     
    }
    public function study_materials_view(){
        $id=$this->input->post('id');
        //echo $id;
        $student_id = $this->session->userdata('user_id');
        $materials = $this->common->get_from_tableresult('mm_subjects', array('course_id'=>$id, 'subject_status'=>1));
        $subjectArr = [];
        if(!empty($materials)) {
            foreach($materials as $material) {
                array_push($subjectArr, $material->subject_id);
            }
        }
        if(!empty($subjectArr)) {
        $this->data['materials'] = $this->user_model->get_course_materials($subjectArr);
        }
        $this->data['course_Id'] = $this->user_model->get_courseby_subId($student_id);

      echo $this->load->view('student/student_studymaterialview', $this->data, TRUE); 
     
    }
    public function print_notes($id = ''){
        if(!empty($id)){
            $filename      = 'report.pdf';
            $pdfFilePath = FCPATH."/uploads/".$filename; 
            $learningModule = $this->questionbank_model->get_learning_module_name($id);
            $batchName = $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$learningModule->course));
            $dataArr['batchName'] = $batchName;
            $learningModuleName = $learningModule->learning_module_name;
            $dataArr['learningModuleName'] = $learningModuleName;
            $dataArr['sequenceNo'] = $learningModule->sequence_no;
            $getSchool = $this->common->get_name_by_id('am_classes','school_id',array('class_id'=>$learningModule->course));
            $dataArr['getSchool'] = $getSchool;
            $student_id = $this->session->userdata('user_id');
            $batch = $this->user_model->get_student_active_batch($student_id); //print_r($batch);
            $learningModule = $this->common->get_upcomming_learning_module($batch->batch_id); 
            // show($learningModule);
            $dataArr['moduleContent'] = '';
            if(!empty($learningModule)) {
                foreach($learningModule as $Module){ 
                    $dataArr['moduleContent'] = $Module->module_content;
                }
            }
            $content = $this->user_model->get_questions($id);
            $dataArr['questionArr'] = $content['questions'];
            $dataArr['passageArr'] = $content['passage'];
            // echo "<pre>"; print_r($dataArr); 
            $html1 = $this->load->view('admin/print_first_page',$dataArr ,TRUE);
            $html2 = $html1.$this->load->view('admin/print_notes',$dataArr ,TRUE);
            ini_set('memory_limit','128M'); // boost the memory limit if it's low 
            $learningModule = $this->questionbank_model->get_learning_module_name($id);
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            // $pdf->SetColumns(0);
            // $pdf->SetHTMLFooter('<div style="text-align:center;"><b>'.$learningModule->learning_module_code.'</b></div>');
            // $pdf->WriteHTML($html1);
            $pdf->SetColumns(0);
            $pdf->SetWatermarkText('Direction');
            $pdf->watermark_font = 'DejaVuSansCondensed';
            $pdf->showWatermarkText = true;
            $pdf->watermarkTextAlpha = 0.2;
            $pdf->SetFooter('<div style="text-align:center;"><b>'.$learningModule->learning_module_code.'</b></div>'); // Add a footer for good measure 
            // $pdf->SetFooter('<div style="text-align:center;"><b>'.PAGENO.'</b></div>'); // Add a footer for good measure 
            $pdf->WriteHTML($html2);
            $pdf->Output($learningModule->learning_module_code.".pdf", 'D');
            $pdf->Output();
        }
    }


    /*
    *   function'll get installment collection
    *   @params post array
    *   @author GBS-R
    */
    
    public function get_batchfee_installment() {
        $installment        = $this->input->post('installment'); //print_r($installment);
        $installment_amt    = $this->input->post('installment_amt'); //print_r($installment_amt);
        $spaidamt = 0;
        if(!empty($installment_amt)) { //print_r($installment);
            foreach($installment_amt as $key=>$val) {
                $spaidamt += $installment_amt[$key];
            }
        }
        if($spaidamt<=0) {
            $html =  '<div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <table class="table table_register table_register_fee table-bordered table-striped">
                                <tr><td class="error">Amount should be greater than 0.</td></tr>    
                            <table>
                        </div>
                    </div>';
                echo $html;
                exit();
        }
        $installment_id     = $this->input->post('installment_id');
        $payable_amt        = $this->input->post('payable_amt');
        $discountapply      = $this->input->post('discountapply');
        $discountAmt        = $this->input->post('discountAmt');
        $otherfee        = $this->input->post('otherfee');
        $hostelfee        = $this->input->post('hostelamt');
        $transfee        = $this->input->post('transamt');
		$institute_course_mapping_id        = $this->input->post('institute_course_mapping_id');
		$centerCourse = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$institute_course_mapping_id));
		if(!empty($centerCourse)) {
			$config['SGST'] = $centerCourse['sgst'];
            $config['CGST']	= $centerCourse['cgst']; 
            if($centerCourse['cess']>0){
            $config['cess']	= 1;    
            $config['cess_value']	= $centerCourse['cess'];
            } else {
            $config['cess']	= 0;    
            $config['cess_value']	= 0;    
            }
		} 
        $paidamt     = 0;
        $html =  '<div class="row"><div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <table class="table table_register table_register_fee table-bordered table-striped">
                    <tbody>';
        
		$selectedInstals = 0;	
        if(!empty($installment)) { //print_r($installment);
        foreach($installment as $key=>$val) {
            //$paidamt += $installment_amt[$val-1];
			$paidamt += $installment_amt[$key];
           $html .= '<tr>
                            <td width="40%">Installment '.$val.'</td><input type="hidden" name="payinginstall'.$selectedInstals.'" value="'.$installment_amt[$key].'"/>
                            <td class="text-right"><label>'.numberformat($installment_amt[$key]).'</label></td>
                        </tr>'; 
		$selectedInstals++;	
        }
//$balance = $payable_amt-$paidamt;
//        $data = array('student_id'=>$this->input->post('student_id'),
//                            'batch_id'=>$this->input->post('batch_id'),
//                         'payment_type'=>$this->input->post('payment_type'),
//                         'payable_amount'=>,
//                         'paid_amount'=>$paidamt,
//                         'balance'=>$balance,
//                         'paymentmode'=>,);
        
    
                       
                 
            if($discountapply==1) {
				//$config				=	$this->home_model->get_config(); print_r($config);
				$taxableAmt 		= 	taxcalculation($paidamt, $config, 0); //print_r($taxableAmt);
				$payableAmt			=	$taxableAmt['totalAmt'];
                $payableAmt 		=   $payableAmt-$discountAmt;
                if(count($installment)>1) {
                     $html .= '<tr>
                            <td>Total</td>
                            <td class="text-right"><label>'.numberformat($paidamt).'</label></td>
                        </tr>';
                        }               
                $html .= '<tr>
                            <td>Discount</td>
                            <td class="text-right"><label>'.numberformat($discountAmt).'</label></td>
                        </tr>';
               $html .= '<input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount_amt" />
			   			<tr>
                            <td>CGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['cgst']).'</label></td>
                        </tr>
						<tr>
                            <td>SGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['sgst']).'</label></td>
                        </tr><input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount" /><input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount_amt" />';	
                if($centerCourse['cess']>0) {
                    $html .= '
                <tr>
                     <td>Cess ['.$centerCourse['cess'].'%]</td>
                     <td class="text-right"><label>'.numberformat($taxableAmt['cess']).'</label></td>
                 </tr>';   
                }        
                $html .= '<tr>
                            <td>Payable Amount[incl:GST]</td>
                            <td class="text-right"><label>'.numberformat($payableAmt).'</label></td>
                        </tr><input type="hidden" class="form-control" value="'.$paidamt.'" name="amt" /><input type="hidden" class="form-control" value="'.$paidamt.'" name="fee_paid_amount" /><input type="hidden" class="form-control" value="'.$payableAmt.'" name="paid_amount" />'; 
                  } else {
					if($selectedInstals>1) {
						$buttondefault = 'btn-default';
					} else {
						$buttondefault = 'btn-info changeAmt';
					}
					//$config				=	$this->home_model->get_config(); print_r($config);
					$taxableAmt 		= 	taxcalculation($paidamt, $config, 0); //print_r($taxableAmt);
				$payableAmt = $taxableAmt['totalAmt'];
				if($otherfee==1) {
                    if($hostelfee>0) {
                        $payableAmt += $hostelfee;
                    $html .= '<tr>
                            <td>Hostel Fee</td>
                            <td class="text-right"><label>'.numberformat($hostelfee).'</label><input type="hidden" name="hostelamt" value="'.$hostelfee.'"/></td>
                        </tr>';
                    }

                    if($transfee>0) {
                        $payableAmt += $transfee;
                     $html .= '<tr>
                            <td>Transport Fee</td>
                            <td class="text-right"><label>'.numberformat($transfee).'</label><input type="hidden" name="transamt" value="'.$transfee.'"/></td>
                        </tr>';
                    }
                }
					$html .= '<tr>
                            <td>CGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['cgst']).'</label></td>
                        </tr>';
				$html .= '<tr>
                            <td>SGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['sgst']).'</label></td>
                        </tr>';
                if($centerCourse['cess']>0) {
                            $html .= '<input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount_amt" />
                        <tr>
                             <td>Cess ['.$centerCourse['cess'].'%]</td>
                             <td class="text-right"><label>'.numberformat($taxableAmt['cess']).'</label></td>
                         </tr>';   
                }
                $html .= '<tr>
                <td>Payable Amount</td>
                <td class="text-right">
                <div class="input-group mb-3">
                  <input type="text" readonly="readonly" class="form-control" value="'.$payableAmt.'" name="paid_amount" id="payableamtchge"/>
                  <input type="hidden" class="form-control" value="'.$paidamt.'" name="amt"/>
                </div><label></label></td>
            </tr><input type="hidden" class="form-control" value="'.$payableAmt.'" name="fee_paid_amount" id="fee_paid_amount_hidden"/>';
                    /*$html .= '<tr>
                            <td>Payable Amount</td>
                            <td class="text-right">
							<div class="input-group mb-3">
							  <input type="text" readonly="readonly" class="form-control" value="'.$payableAmt.'" name="paid_amount" id="payableamtchge"/>
							  <div class="input-group-append">
								<button class="btn '.$buttondefault.' " type="button"><i class="fa fa-pencil"></i></button> 
							  </div>
							</div><label></label></td>
                        </tr><input type="hidden" class="form-control" value="'.$payableAmt.'" name="fee_paid_amount" id="fee_paid_amount_hidden"/>'; */
                    } 
                    $html .= '<tr>
                            <td></td>
                            <td><button class="btn btn-info btn_save paynow" id="paynowbutton">Paynow</button></td>
                        </tr>';
        } else {
           $html .= 'No installment selected!'; 
        }        
        $html .= '</tbody>
                    </table>
                        </div></div><script>
                        $(".modeofpayinstall").change(function(){ 
                            var mode = $(this).val(); 
                            if(mode=="Card") {
                                $(".cardclass").show();
                                $(".chequeclass").hide();
                                $(".onlineclass").hide();
                                $("#cardclassid").prop("disabled", false);
                                $("#transactiontypeid").prop("disabled", true);
                            } else if(mode=="Cheque") {
                                $(".cardclass").hide();
                                $(".onlineclass").hide();
                                $(".chequeclass").show();
                                $("#cardclassid").prop("disabled", true);
                                $("#transactiontypeid").prop("disabled", true);
                            }else if(mode=="Online") {
                                $(".cardclass").hide();
                                $(".chequeclass").hide();
                                $(".onlineclass").show();
                                $("#cardclassid").prop("disabled", true);
                                $("#transactiontypeid").prop("disabled", false);
                            } else {
                                $(".cardclass").hide();
                                $(".chequeclass").hide();
                                $(".onlineclass").hide();
                                $("#cardclassid").prop("disabled", true);
                                $("#transactiontypeid").prop("disabled", true);
                            }
                        });     
                        $(".txtOnly").keypress(function (e) {
			var regex = new RegExp("^[a-zA-Z]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
			else
			{
			e.preventDefault();
			return false;
			}
		}); 
        $(".numbersOnly").keyup(function () { 
    if (this.value != this.value.replace(/[^0-9]/g, "")) {
       this.value = this.value.replace(/[^0-9]/g, "");
    }
}); 

$(".changeAmt").click(function () {
	$("#payableamtchge").prop("readonly", false);
}); 

$("#payableamtchge").blur(function() {
  		//$("#fee_paid_amount_hidden").val($("#payableamtchge").val());
		
    });
    
    $(".splictclassinstall").click(function() {
        val = $(this).val();
        if(val=="split") {
            $("#installsplit").show();
        } else {
            $("#installsplit").hide();
        }
    }); 

    $(".splitpayinstall").keyup(function () { 
        var amt = $(this).val();
        var value = $(this).attr("status"); 
        if(parseInt(amt) > parseInt(value)) {
            $(this).val(value);
        }
    }); 
                    </script>';
        
        
        echo $html;
    }
   
    

    
    public function view_study_material($id = NULL){
        // $id = $this->input->post('id');
        $student_id=$this->session->userdata('user_id');

        if(isset($id)){ 
          $this->load->model('questionbank_model');
          $details = $this->questionbank_model->get_study_material_details($id);
          $training_id=$this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id'=>$id));

        //   echo $this->db->last_query();
        //   echo '<pre>';
        //   print_r($details);
        //   die();
          $myObj = Array();
          $myObj= new stdClass;
          $myObj->emp_id = $student_id;
          $myObj->material_id = $details['id'];
          $myObj->training_id = $training_id;
          $myObj->is_material_viewed = true;
          $myObj->playedTime = "1";
          $myObj->startPage = "1";
          $jData['method'] = "api/update_material_status";
          $jData['type'] = "POST";
          $jData['data'] = json_encode($myObj);
          $mapResponse = json_decode($this->api->rest_api_call($jData));
          if(!empty($details)){ 
            $file = str_replace(' ', '_',$details['material_name']).'.pdf';
            $html2 ='<div style="width:100%;"><img src="inner_assets/images/logo.png" style="width:90px;margin:10px 0px;display:block;float:right;"></div><b style="text-align:center;display:block;margin:0;"><u>Material Name:</u> </b>'.$details['material_name'];
            //$this->load->view('admin/print_first_page',$dataArr ,TRUE);
            $html1 = $details['text_content'];
            $filepath = FCPATH.'materials/study_materials/studyNotesPdf/'.$file;
            $url = base_url('materials/study_materials/studyNotesPdf/'.$file);
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            
            $pdf->SetColumns(0);
            $pdf->SetWatermarkText('IIHRM');
            $pdf->watermark_font = 'DejaVuSansCondensed';
            $pdf->showWatermarkText = true;
            $pdf->watermarkTextAlpha = 0.2;
            //$pdf->SetFooter('<div style="text-align:center;"><img src="./inner_assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure ;)
            // if($this->user_password){
            //   $pdf->SetProtection(array(),$this->user_password,PDF_MASTER_PASSWORD);
            // }
            $pdf->WriteHTML($html2); 
            $pdf->WriteHTML($html1);
            $pdf->Output($file, 'I');
            // $returnData['st']=1;
            // $returnData['url']=$url;
          }
          else{
            // $returnData['st'] 		  = 0;
            // $returnData['message'] 	= 'No such study exists';
          }
        }else{
          // $returnData['st'] 		  = 0;
          // $returnData['message'] 	= 'Network failure.';
        }
        // print_r(json_encode($returnData));
      }



      public function show_study_material(){
        //  echo APIURI;die();
        if($_POST){
            $student_id=$this->session->userdata('user_id');
            $id = $this->input->post('id');
           $study_material['data'] = $this->questionbank_model->get_study_material_details($id);
           $course_id = $study_material['data']['course_id'];
           $training_id=$this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id'=>$student_id,'course_id'=>$course_id,'status'=>1));
          $html = '<div class="row"></div>';
          if(!empty($study_material['data'])){
            $myObj = Array();
            $myObj= new stdClass;
            $myObj->emp_id = $student_id;
            $myObj->material_id = $study_material['data']['id'];
            $myObj->training_id = $training_id;
            $myObj->is_material_viewed = true;
            $myObj->playedTime = "1";
            $myObj->startPage = "1";
            $jData['method'] = "api/Update_material_status";
            $jData['type'] = "POST";
            $jData['data'] = json_encode($myObj);
            $mapResponse = json_decode($this->api->rest_api_call($jData));
            $html = $this->load->view('student/study_material_view',$study_material,TRUE);
          }
          // echo $html;exit;
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Success.';
          $returnData['html'] 	  = $html;
          $returnData['title'] 	  = ucfirst($study_material['data']['material_name']);
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Network failure.';
        }
        print_r(json_encode($returnData));
      }

      
      public function study_material_page_view(){
        //  echo APIURI;die();
        if($_POST){
            $student_id=$this->session->userdata('user_id');
            $id = $this->input->post('id');
           $study_material['data'] = $this->questionbank_model->get_study_material_details($id);
           $course_id = $study_material['data']['course_id'];
           $training_id=$this->common->get_name_by_id('am_student_course_mapping','batch_id',array('student_id'=>$student_id,'course_id'=>$course_id,'status'=>1));
          $html = '<div class="row"></div>';
          if(!empty($study_material['data'])){
            $myObj = Array();
            $myObj= new stdClass;
            $myObj->emp_id = $student_id;
            $myObj->material_id = $study_material['data']['id'];
            $myObj->training_id = $training_id;
            $myObj->is_material_viewed = true;
            $myObj->playedTime = "1";
            $myObj->startPage = "1";
            $jData['method'] = "api/Update_material_status";
            $jData['type'] = "POST";
            $jData['data'] = json_encode($myObj);
            $mapResponse = json_decode($this->api->rest_api_call($jData));
            $html = $this->load->view('student/study_material_page_view',$study_material,TRUE);
          }
          // echo $html;exit;
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Success.';
          $returnData['html'] 	  = $html;
          $returnData['title'] 	  = ucfirst($study_material['data']['material_name']);
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Network failure.';
        }
        print_r(json_encode($returnData));
      }
  
      


}
