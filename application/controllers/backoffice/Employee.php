<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends Direction_Controller {

	public function __construct() {
        parent::__construct();
         $this->lang->load('information','english');
        $module="Employee";
        check_backoffice_permission();
        $this->load->model('questionbank_model');
    }

   public function index($id=NULL,$date = ""){
        // print_r($this->session->all_userdata());
        $user_id = $this->session->userdata('user_primary_id');
        if($user_id!=NULL){
            $personal_id=$this->common->get_name_by_id('am_staff_personal','personal_id',array("user_id"=>$user_id));
            $this->data['staff'] = $this->common->get_staff_details_by_id($personal_id);
        } 
        /*$this->data['staff']['role']=$this->common->get_name_by_id('am_roles','role_name',array("roles_id"=>$this->data['staff']['role']));
        $this->data['staff']['center']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$this->data['staff']['center']));
        $this->data['staff']['branch']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$this->data['staff']['branch']));
        $this->data['staff']['reporting_head']=$this->common->get_name_by_id('am_staff_personal','name',array("personal_id"=>$this->data['staff']['reporting_head']));*/
        // $this->data['staff']['subjects']['parent_subject_id']=$this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$this->data['staff']['parent_subject_id']));


        // $this->data['branch'] = $this->common->get_from_tableresult('am_institute_master', array('institute_type_id'=>2,'status'=>1));
        // $this->data['center'] = $this->common->get_from_tableresult('am_institute_master', array('institute_type_id'=>3,'status'=>1));
        $this->data['page']="admin/staff_view";
		$this->data['menu']="employee";
        $this->data['breadcrumb']="Profile";
        $this->data['menu_item']="profile";
        $this->load->view('admin/layouts/_master',$this->data);
        
    }

    public function common_calendar(){
        if(check_module_permission('calendar')){
            $this->data['page']="admin/scheduler/index";
            $this->data['menu']="employee";
            $this->data['breadcrumb']="Schedules";
            $this->data['menu_item']="schedules";
            $this->load->view('admin/layouts/_master',$this->data);
        }else{
            redirect("404");
        }
    }


    public function view_document($document_id){
        $user_id = $this->session->userdata('user_id');
        if($user_id!=NULL){
            $this->data['staff'] = $this->common->get_staff_details_by_id($user_id);

        // echo '<pre>';
        // print_r($this->data['staff']);
        // die();

        }
        $this->data['document'] = $this->common->get_document_details_by_id($user_id,$document_id);
         echo $this->db->last_query();
         echo '<pre>';
         print_r($this->data['document']);
        // die();
            $this->load->view('admin/view_document',$this->data);

    }
    
//daily shedule
    public function daily_schedule(){    
        if(check_module_permission('daily_schedule')){
            $this->data['page']="admin/scheduler/daily_schedule";
            $this->data['menu']="employee";
            $this->data['breadcrumb']="Daily Schedule";
            $this->data['menu_item']="daily_schedule";
            $centre_id=$this->session->userdata('center');
            $this->data['details']=$this->Staff_model->daily_schedule($centre_id);
   
              $this->load->view('admin/layouts/_master',$this->data);
        }else{
            redirect("404");
        }
    }
    
    public function schedule_status_change()
    {
       
        if($_POST)
        {
            $id=$this->input->post('id');
            $status=$this->input->post('status');
            $today = strtotime(date('d-m-Y'));
            $dateselected = strtotime($this->input->post('dateselected')); 
            if ($today >= $dateselected) {
            if($status ==0)
            {
                $status=1;
            }
            else
            {
                $status=0;
            }
           $response=$this->Common_model->update("am_schedules", array("class_taken"=>$status),array("schedule_id"=>$id));
            if($response)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully Changed Status";
            }
            else
            {
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!"; 
            }
          } else {
            $ajax_response['st']=0;
            $ajax_response['msg']="Can't change future date schedule status."; 
          }
        }
        else
        {
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";  
        }
        print_r(json_encode($ajax_response));
    }
    
    public function load_ajax_daily_schedule()
    {
      $html = '<thead>  
                     <tr>
                    <th>'.$this->lang->line("sl_no").'</th>
                    <th> '.$this->lang->line('Schedule_type').'</th>
                    <th> '.$this->lang->line('start_time').'</th>
                    <th> '.$this->lang->line('end_time').'</th>
                    <th> '.$this->lang->line('course').'</th>
                    <th> '.$this->lang->line('batch').'</th>
                    <th> '.$this->lang->line('module').'</th>
                    <th> '.$this->lang->line('faculty').'</th>
                    <th> '.$this->lang->line('class_room').'</th>
                    <th> '.$this->lang->line('action').'</th>
                    </tr>
                </thead>'; 
         $centre_id=$this->session->userdata('center');
      $details=$this->Staff_model->daily_schedule($centre_id);
        
        
        if(!empty($details))
        {    $i=1;
            foreach($details as $row)
            {
                if($row['schedule_type'] == "1")
                                { 
                                 $schedule_type="Exam";
                       
                       
                                } 
                                else
                                {
                                  $schedule_type= "Class";
                                  
                                } 
                    $course_name=$this->common->get_name_by_id("am_classes","class_name",array("class_id"=>$row['course_master_id']));
                if ($row['class_taken'] == 0)
                {
                  $status='<span class="btn mybutton  mybuttonInactive" onclick="change_status('.$row['schedule_id'].','.$row['class_taken'].');">'. $this->lang->line('pending').'</span>';  
                }
                else
                {
                  $status='<span class="btn mybutton  mybuttonActive" onclick="change_status('.$row['schedule_id'].','.$row['class_taken'].');">'.$this->lang->line('finished').'</span>';    
                }
                if(isset($row['module']))
                {
                    $module= $row['module'];
                }else
                {
                   $module=""; 
                }
                $html.=' <tr>
                    <td>'.$i.'</td>
                    <td>'.$schedule_type.'  </td>
                    <td>'.date('h:i A',strtotime($row['schedule_start_time']) ).'</td>
                    <td>'.date('h:i A',strtotime($row['schedule_end_time']) ).'</td>
                    <td>'.$course_name.'</td>
                    <td>'. $row['batch_name'].'</td>
                    <td>'.$module.'</td>
                    <td>'. $row['name'] .'</td>
                    <td>'. $row['classroom_name'] .'</td>
                    <td>'. $status .'</td>
                    
                
                </tr>';
              
                $i++;
            }
         
        }
        echo $html;
    }
    
    public function search_schedule()
    {
       // print_r($_POST);
        if($_POST)
        {
               $date=date('Y-m-d',strtotime($this->input->post('date')));
              $html = '<thead>  
                     <tr>
                    <th>'.$this->lang->line("sl_no").'</th>
                    <th> '.$this->lang->line('Schedule_type').'</th>
                    <th> '.$this->lang->line('start_time').'</th>
                    <th> '.$this->lang->line('end_time').'</th>
                    <th> '.$this->lang->line('course').'</th>
                    <th> '.$this->lang->line('batch').'</th>
                    <th> '.$this->lang->line('module').'</th>
                    <th> Faculty / Exam name </th>
                    <th> '.$this->lang->line('class_room').'</th>
                    <th> '.$this->lang->line('action').'</th>
                    </tr>
                </thead>'; 
             $centre_id=$this->session->userdata('center');
            $details=$this->Staff_model->search_schedule($centre_id,$date);
               // echo $this->db->last_query();
                          //echo "<pre>";
                         // print_r($details);
 
        if(!empty($details))
        {    $i=1;
            foreach($details as $row)
            {
                if($row['schedule_type'] == "1")
                                { 
                                 $schedule_type="Exam";
                       
                       
                                } 
                                else
                                {
                                  $schedule_type= "Class";
                                  
                                } 
                    $course_name=$this->common->get_name_by_id("am_classes","class_name",array("class_id"=>$row['course_master_id']));
                if ($row['class_taken'] == 0)
                {
                  $status='<span class="btn mybutton  mybuttonInactive" onclick="change_status('.$row['schedule_id'].','.$row['class_taken'].');">'. $this->lang->line('pending').'</span>';  
                }
                else
                {
                  $status='<span class="btn mybutton  mybuttonActive" onclick="change_status('.$row['schedule_id'].','.$row['class_taken'].');">'.$this->lang->line('finished').'</span>';    
                }
                if(isset($row['module']))
                {
                    $module= $row['module'];
                }else
                {
                   $module=""; 
                }
                
                $html.=' <tr>
                    <td>'.$i.'</td>
                    <td>'.$schedule_type.'  </td>
                    <td>'.date('h:i A',strtotime($row['schedule_start_time']) ).'</td>
                    <td>'.date('h:i A',strtotime($row['schedule_end_time']) ).'</td>
                    <td>'.$course_name.'</td>
                    <td>'. $row['batch_name'].'</td>
                    <td>'. $module.'</td>
                    <td>'. $row['name'] .'</td>
                    <td>'. $row['classroom_name'] .'</td>
                    <td>'. $status .'</td>
                    
                
                </tr>';
              
                $i++;
            }
         
        }
        echo $html;
        }
    }
    
    public function employee_attendance()
    {
      
     // if(check_module_permission('view-attendance')){
            $this->data['page']="admin/view_attendance_by_person";
            $this->data['menu']="employee";
            $this->data['breadcrumb']="My Attendance";
            $this->data['menu_item']="view-attendance";
            $user_id = $this->session->userdata('user_primary_id');
            $personal_id=$this->common->get_name_by_id('am_staff_personal','personal_id',array("user_id"=>$user_id));
            $this->data['details']=$this->Report_model->view_staff_attendance($personal_id);
             $this->load->view('admin/layouts/_master',$this->data);
        //}else{
          //  redirect("404");
        //}  
    }
    
    public function search_self_attendance()
    {
       
        if($_POST)
        {
            $s_date=$this->input->post('start_date');
            $e_date=$this->input->post('end_date');
            $start_date=date('Y-m-d',strtotime('01-'.$s_date));
            $end_date=date('Y-m-d',strtotime('31-'.$e_date));
            $user_id = $this->session->userdata('user_primary_id');
            $personal_id=$this->common->get_name_by_id('am_staff_personal','personal_id',array("user_id"=>$user_id));
            $attendance_data=$this->Report_model->search_self_attendance($start_date,$end_date,$personal_id);
            $html='<thead>  
                    <tr>
                    <th>'.$this->lang->line("sl_no").'</th>
                    <th> '.$this->lang->line('date').'</th>
                    <th> '.$this->lang->line('attendance').'</th>
                    </tr>
                </thead>'; //print_r($attendance_data);
            if(!empty($attendance_data))
            {
                $i=1;
                foreach($attendance_data as $row)
                {
                    if($row['attendance'] == "1")
                    { 
                        $attendance= "<span><i class='fa fa-check text-success'></i></span>";
                    } 
                   else 
                   {
                       $attendance= "<span><i class='fa fa-times text-danger'></i></span>";
                   }
                   $html.='<tr>
                    <td>'.$i.'</td>
                    <td>'.date('d-m-Y',strtotime($row['date'])).'</td>
                    <td>'.$attendance.'</td>
                    </tr>'; 
                    $i++;
                }
            }
            echo $html;
            
        }
    }

    public function mentor_view(){
        $this->data['page']         = "admin/mentor_view";
        $this->data['menu']         = "employee";
        $this->data['breadcrumb']   = "Mentors Meeting";
        $this->data['menu_item']    = "backoffice/mentor-view";
        $this->data['studentArr']   = $this->student_model->get_stud_list();
        $this->data['staff_id']     = $this->student_model->get_staff_id($this->session->userdata('user_id'));
        $this->load->view('admin/layouts/_master',$this->data);
    }

    public function feedback_add()
    {
        if($_POST){
            $data = $_POST;
            $feedback_exist = $this->student_model->is_feedback_exist($data);
            if($feedback_exist == 0){
                $res = $this->student_model->feedback_add($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'am_student_feedback');
                    // $feedback_array=$this->student_model->get_feedbackdetails_by_id($table_row_id);
                    // $html='<li id="row_'.$table_row_id.'">
                    //         <div class="col sl_no "> '.$table_row_id.' </div>
                    //         <div class="col " >'.$feedback_array['registration_number'] .' </div>
                    //         <div class="col " >'.$feedback_array['name'] .' </div>
                    //         <div class="col " >'.$feedback_array['comment'] .' </div>
                    //         <li>';
                }
            }else{
                $res=2;//already exist
            }
            print_r($res);
        }
    }

    public function load_feedback_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('application.no').'</th>
                        <th >'.$this->lang->line('student_name').'</th>
                        <th >Feedback</th>

                    </tr>
                </thead>';
        $students = $this->student_model->get_stud_list();
        if(!empty($students)) {
            $i=1; 
            foreach($students as $stud){ 
                $html .= '<tr id="row_'.$stud['details_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="registration_number_'.$stud['details_id'].'">
                        '.$stud['registration_number'].'
                    </td>
                    <td id="name_'.$stud['details_id'].'">
                        '.$stud['name'].'
                    </td>
                    <td id="comment_'.$stud['details_id'].'">
                        '.$stud['comment'].'
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    public function studymaterials(){
        $this->data['page']         = "admin/study_materials";
        $this->data['menu']         = "employee";
        $this->data['breadcrumb']   = "Study Materials";
        $this->data['menu_item']    = "study-materials";
        $staff_id = $this->session->userdata('user_id');
        $this->data['learningModule'] = $this->student_model->get_staff_active_batch($staff_id); //print_r($batch);
        // $this->data['learningModule'] = $this->common->get_upcomming_learning_module($batch->batch_id); 
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_studymaterial_by_batch(){
        if($_POST)
        {
            $html = '<thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th class="text-left">Module</th>
                            <th class="text-left">Batch</th>
                            <th class="text-left">Learning Module</th>
                        </tr>
                    </thead>';
            $staff_id = $this->session->userdata('user_id');
            $batch_id=$this->input->post('batch_id');
            $learningModule = $this->student_model->get_single_batch($staff_id,$batch_id); //print_r($batch);
             if(!empty($learningModule))
             {
                $i=1;
                foreach($learningModule as $Module)
                {                                 
                    $html.='<body>
                                <tr>
                                    <td>'.date('d-M-Y', strtotime($Module->schedule_date)).'</td>
                                    <td>'.date('g:i a', strtotime($Module->schedule_start_time)).' - '.date('g:i a', strtotime($Module->schedule_end_time)).'</td>
                                    <td class="text-left">'.$Module->subject_name.'</td>
                                    <td class="text-left">'.$Module->batch_name.'</td>
                                    <td class="text-left">
                                        <a href="'.base_url().'backoffice/faculty-learning-module/'.$Module->learning_module_id.'" class="btn btn-info btn_save">
                                            <i class="fa fa-download text-right"></i>'." ". $this->common->get_name_by_id('am_learning_module','learning_module_name',array('id'=>$Module->learning_module_id)).'
                                        </a>
                                    </td>
                                </tr>
                            </body>';
                    $i++;
                }
            }
            echo $html;
        }
    }
    public function print_notes($id = ''){
      if(!empty($id)){
        $filename      = $id.'module'.time().'.pdf';
        // $pdfFilePath = FCPATH."/uploads/".$filename; 
        $learningModule = $this->questionbank_model->get_learning_module_name($id);
        $batchName = $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$learningModule->course));
        $dataArr['batchName'] = $batchName;
        $learningModuleName = $learningModule->learning_module_name;
        $dataArr['learningModuleName'] = $learningModuleName;
        $dataArr['sequenceNo'] = $learningModule->sequence_no;
        $getSchool = $this->common->get_name_by_id('am_classes','school_id',array('class_id'=>$learningModule->course));
        $dataArr['getSchool'] = $getSchool;
        $student_id = $this->session->userdata('user_id');
        $batch = $this->user_model->get_student_active_batch($student_id);
        $learningModule = $this->common->get_upcomming_learning_module($batch->batch_id); 
        $dataArr['moduleContent'] = '';
        if(!empty($learningModule)) {
            foreach($learningModule as $Module){ 
                $dataArr['moduleContent'] = $Module->module_content;
            }
        }
        $content = $this->user_model->get_questions($id);
        $dataArr['questionArr'] = $content['questions'];
        $dataArr['passageArr'] = $content['passage'];
        $html1 = $this->load->view('admin/print_first_page',$dataArr ,TRUE);
        $html2 = $html1.$this->load->view('admin/print_notes',$dataArr ,TRUE);
        ini_set('memory_limit','128M'); // boost the memory limit if it's low 
        $learningModule = $this->questionbank_model->get_learning_module_name($id);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetColumns(0);
        $pdf->SetWatermarkText('Direction');
        $pdf->watermark_font = 'DejaVuSansCondensed';
        $pdf->showWatermarkText = true;
        $pdf->watermarkTextAlpha = 0.2;
        $pdf->SetFooter('<div style="text-align:center;"><b>'.$learningModule->learning_module_code.'</b></div>'); // Add a footer for good measure 
        $filepath = FCPATH.'uploads/materials/'.$filename;
        $url = base_url('uploads/materials/'.$filename);
        $pdf->WriteHTML($html2); 
        $pdf->Output($filepath, "F");
        $returndata['st']=1;
        $returndata['url']=$url;
        print_r(json_encode($returndata));
      }
    }

    // --------------------------------------------Approve management ----------------------------------------------------------------------------------------------
    
    public function approve_management(){
        $this->data['page']         = "admin/approve_management";
        $this->data['menu']         = "employee";
        $this->data['breadcrumb']   = "Approve Management";
        $this->data['menu_item']    = "approve-management";
        $user_id = $this->session->userdata('user_primary_id');
        $this->data['approveManagement'] = $this->student_model->get_active_job($user_id);
        // show($this->data['approveManagement']);
        $this->load->view('admin/layouts/_master',$this->data);
    }

    public function approve_jobs($id){
        $this->data['page']         = "admin/approve_job";
        $this->data['menu']         = "employee";
        $this->data['breadcrumb'][0]['name']="Approve Management";
        $this->data['breadcrumb'][0]['url']=base_url('approve-management');
        // $this->data['breadcrumb'][1]['name']="Approval Tasks";
        $this->data['menu_item']    = "approve-management";
        $this->data['jobs'] = $this->student_model->get_active_jobs($id);
        // show($this->data['jobs']);
        foreach($this->data['jobs'] as $job){
          if($job->flow_entities == 1){
            $this->data['breadcrumb'][1]['name'] = 'Question Set Approval Tasks';
            $this->data['materialName'] = 'Question Set';
          }else if($job->flow_entities == 2){
            $this->data['breadcrumb'][1]['name'] = 'Learning Module Approval Tasks';
            $this->data['materialName'] = 'Learning Module';
          }else if($job->flow_entities == 3){
            $this->data['breadcrumb'][1]['name'] = 'Exam Paper Approval Tasks';
            $this->data['materialName'] = 'Exam Paper';
          }
        }
        // show($this->data['jobs']);
        $this->load->view('admin/layouts/_master',$this->data);
    }
    
    public function view_question($id){
      $this->data['page']         = "admin/approve_question_view";
      $this->data['menu']         = "employee";
      $user_id = $this->session->userdata('user_primary_id');
      $jobId = $this->common->get_from_tablesingleselect('approval_flow_entity_details', array('status'=>1,'user_id'=>$user_id),'id');
      $entityID = $this->common->get_name_by_id('approval_flow_jobs','entity_id',array('id'=>$id));
      $flowDetailId = $this->common->get_name_by_id('approval_flow_jobs','flow_detail_id',array('id'=>$id));
      // echo $this->db->last_query();  exit;
      $this->data['breadcrumb'][0]['name']="Approve Management";
      $this->data['breadcrumb'][0]['url']=base_url('approve-management');
      $this->data['breadcrumb'][1]['name']="Approval Jobs";
      $this->data['breadcrumb'][1]['url']=base_url('approve-jobs/'.$flowDetailId);
      $this->data['breadcrumb'][2]['name']="Material View";
      $this->data['menu_item']    = "approve-management";
      $this->data['entityID'] = $entityID;
      $this->data['jobId'] = $id;
      $this->data['flowDetailId'] = $flowDetailId;
      $this->data['questions'] = $this->student_model->get_questions($entityID);
      // show($this->data['questions']);
      $this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_passage_content(){
      if($_POST){
        $passage_id = $this->input->post('passage_id');
        if(!empty($passage_id)){
          $result = $this->student_model->get_passage_content($passage_id);
          if(!empty($result)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "Passage";
            $returnData['body'] 		= $result->paragraph_content;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Passage not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }
    public function get_question_content(){
      if($_POST){
        $question_id = $this->input->post('question_id');
        if(!empty($question_id)){
          $result = $this->student_model->get_question_content($question_id);
          if(!empty($result)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "Question";
            $returnData['body'] 		= $result->question_content;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Passage not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }
    public function get_question(){
      if($_POST){
        $question_id = $this->input->post('question_id');
        if(!empty($question_id)){
          $result = $this->questionbank_model->get_full_question($question_id);
          $list='';
          if(!empty($result)){
            if($result['question']->question_difficulty == 1){$question_difficulty='Easy';}
            if($result['question']->question_difficulty == 2){$question_difficulty='Medium';}
            if($result['question']->question_difficulty == 3){$question_difficulty='Hard';}
    
            if($result['question']->question_type == 1){$question_type='Objective';}
            if($result['question']->question_type == 2){$question_type='Descriptive';}
            
            $list.='<div class="row" style="margin-left: 15px;">';
            $list.='<div class="form-group col-sm-4">
                        <div class="title-header">Difficulty</div>
                        <div class="title-body"><h6>'.$question_difficulty.'</h6></div>
                      </div>';
            $list.='<div class="form-group col-sm-4">
                        <div class="title-header">Question Type</div>
                        <div class="title-body"><h6>'.$question_type.'</h6></div>
                      </div>';
            if(!empty($result['passage'])){
              $list.='<div class="form-group col-sm-12">
                        <div class="title-header">Passage</div>
                        <div class="title-body">'.$result['passage']->paragraph_content.'</div>
                      </div>';
            }
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Question</div>
                      <div class="title-body">'.$result['question']->question_content.'</div>
                    </div>';
            if($result['question']->question_type == 1){
              $list.='<div class="form-group col-sm-12">
                        <div class="title-header">Options</div>
                        <div class="title-body"><ul>';
              $answer = '';
              if(!empty($result['options'])){
                foreach($result['options'] as $row){
                  if($row->option_answer == 1){
                    $answer .= ' ('.$row->option_number.') '.$row->option_content;
                  }
                  $list.='<li>('.$row->option_number.') '.$row->option_content.'</li>';
                }
              }
              $list.='</ul></div></div>';
              $list.='<div class="form-group col-sm-12">
                        <div class="title-header">Answer</div>
                        <div class="title-body">'.$answer.'</div>
                      </div>';
            }
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Solution</div>
                      <div class="title-body">'.$result['question']->question_solution.'</div>
                    </div>';
            
            $list.='</div>';
          
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "Question";
            $returnData['body'] 		= $list;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Passage not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }
    public function update_question(){
        if($_GET['qid']){
          $question_id = $this->input->get('qid');
          if(!empty($question_id)){
            $result = $this->questionbank_model->get_full_question($question_id);
            // echo $entityID = $this->common->get_name_by_id('mm_question','question_set_id',array('question_id'=>$_GET['qid'])); exit;
            if(!empty($result)){
                $this->data['data'] = $result;
                $this->data['page']="admin/question_update_for_approval";
                $this->data['menu']         = "employee";
                $this->data['breadcrumb']   = "Approve Management";
                $this->data['menu_item']    = "approve-management";
                $this->load->view('admin/layouts/_master.php',$this->data); 
            }else{
              redirect('404');
            }
          }
        }else{
          redirect('404');
        }
    }
    public function save_single_question(){
        if($_POST){
            $_POST['checkQuestion'] = trim(trim(strip_tags($this->input->post('question')),'&nbsp;'));
            $this->form_validation->set_rules(array(
              array(
                'field' => 'checkQuestion',
                'label' => 'Question',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'Please add some non graphical content in question'
                )
              ),
              array(
                'field' => 'question_set',
                'label' => 'Question set',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'Please select a question set'
                )
              )
            ));
            if(!$this->form_validation->run()){
              $returnData['st'] 		= 0;
              $returnData['message'] 	= strip_tags(validation_errors());
              print_r(json_encode($returnData));
              exit;
            }
            $question_id = $this->input->post('question_id');
            $question = array(
                            "question_set_id"=>$this->input->post('question_set'),
                            "question_content"=>$this->input->post('question'),
                            "question_solution"=>$this->input->post('solution'),
                            "question_difficulty"=>$this->input->post('difficulty')
                        );
            if(!empty($this->input->post('paragraph_id'))){
              $question['paragraph_id'] = $this->input->post('paragraph_id');
            }
            if(empty(strip_tags($this->input->post('solution')))){
              $question['question_solution'] = NULL;
            }
            $optionname = $this->input->post('optionname');
            $option = $this->input->post('option');
            $answers = $this->input->post('answer');
            $validation = 1;
            if(!empty($option)){
              foreach($option as $row){
                if(trim(trim(strip_tags($row),'&nbsp;')=='')){
                  $validation = 0;
                  $returnData['st'] 		= 0;
                  $returnData['message'] 	= 'Please add some non graphical content in options';
                  print_r(json_encode($returnData));
                  exit;
                }
              }
            }else{
              $returnData['st'] 		= 0;
              $returnData['message'] 	= 'Please define choices';
              print_r(json_encode($returnData));
              exit;
            }
            if(empty($answers)){
              $returnData['st'] 		= 0;
              $returnData['message'] 	= 'Please mention the correct answer';
              print_r(json_encode($returnData));
              exit;
            }
            if(!empty($optionname) && !empty($option) && !empty($answers) && (count($optionname)==count($option))){
              $alphabets = alphabets();
              foreach($optionname as $key=>$val){
                $option[$key] = array(
                  "option_number"=>$alphabets[$key],
                  "option_content"=>$option[$key],
                  "option_answer"=>0
                );
                foreach($answers as $akey=>$aval){
                  if($val == $aval){
                    $option[$key]['option_answer'] = 1;
                  }
                }
              }
            
              if($question_id){
                // echo '<pre>';print_r($question);exit;
                if($this->input->post('paragraph_id')){
                  $paragraph['paragraph_content'] = $this->input->post('passage');
                  $paragraph_id = $this->input->post('paragraph_id');
                  $this->questionbank_model->update_passage($paragraph,$paragraph_id);
                }
                $this->questionbank_model->update_question($question,$question_id);
              }else{
                $question_id = $this->questionbank_model->insert_question($question);
              }
            
              if($question_id){
                foreach($option as $key=>$val){
                  $option[$key]['question_id'] = $question_id;
                }
                if($this->questionbank_model->insert_option($option,$question_id)){
                  $returnData['st'] 		= 1;
                  $returnData['message'] 	= 'Successfully saved';
                }else{
                  $returnData['st'] 		= 0;
                  $returnData['message'] 	= 'Sorry technical problem options not saved';
                }
              }else{
                $returnData['st'] 		= 0;
                $returnData['message'] 	= 'Sorry technical problem question not saved';
              }
            }else{
              $returnData['st'] 		= 0;
              $returnData['message'] 	= 'Some fields are missing';
            }
        }else{
                  $returnData['st'] 		= 0;
                  $returnData['message'] 	= 'Network Error';
        }
        print_r(json_encode($returnData));
    }
    public function delete_question(){
        if($_POST){
            $id=$this->input->post('id');
            $exist=$this->common->check_if_dataExist('gm_exam_paper_questions',array("question_id"=>$id));
            if($exist == 0){
                $response= $this->Common_model->update('mm_question',array("question_status"=>"0"),array("question_id"=>$id)); 
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']='Question deleted Successfully';
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']='Something went wrong,Please try again later..!';
                }
            } 
            else{
                $ajax_response['st']=2;
                $ajax_response['msg']='This question is already added in a question paper.';  
            }
        }
        else{
           $ajax_response['st']=0;
           $ajax_response['msg']='Something went wrong,Please try again later..!';
        }
        print_r(json_encode($ajax_response));
    }
    public function load_questions_ajax(){
        $list = '<thead><tr>
                    <th width="50">Sl.No.</th>
                    <th>Passage</th>
                    <th>Question</th>
                    <th>Difficulty</th>
                    <th>Version</th>
                    <th>Actions</th>
                </tr></thead>'; 
        if($_POST){
            $id = $this->input->post('id');
            $question_set = $this->common->get_name_by_id('mm_question','question_set_id',array("question_id"=>$id));
            if(!empty($question_set)){
                $result = $this->student_model->get_questions($question_set);
                if(!empty($result['questions'])){
                $i=1;
                    foreach($result['questions'] as $row){      
                            $list=$list.'<tr id="row_'.$row->question_id.'"><td>'.$i.'</td>
                            ';
                            if($row->paragraph_id!=0 && $row->paragraph_id!=NULL){          
                                $list=$list.'<td onClick="viewPassage('.$row->paragraph_id.')"><a href="javascript:void()">'.limit_html_string($row->paragraph_content,20).'</a></td>';
                            }else{          
                                $list=$list.'<td>No passage</td>';
                            }
                        $list = $list.'<td onClick="viewQuestion('.$row->question_id.')"><a href="javascript:void()">'.limit_html_string($row->question_content,20).'</a></td>
                        <td>'.get_question_difficulty($row->question_difficulty).'</td>
                        <td>'.$row->question_version.'</td>
                        <td>
                        <a class="btn btn-default option_btn" title="View" onClick="get_question('.$row->question_id.')">
                          <i class="fa fa-eye icon"></i>
                        </a>
                        <a class="btn btn-default option_btn" title="Edit" onClick="edit_question('.$row->question_id.')">
                          <i class="fa fa-pencil icon"></i>
                        </a> 
                        <a class="btn btn-default option_btn" title="Delete" onClick="delete_question('.$row->question_id.')">
                        <i class="fa fa-trash-o"></i></a>
                        </td>
                        </tr>';
                    $i++; 
                    }
                } 
            }
        }
        echo $list;
    }
  public function reject_entity_job(){
    // show($_POST);
    if($_POST){
      $entity_id = $this->input->post('id');
      $remark = $this->input->post('remark');
      $jobId = $this->input->post('jobId');
      $flowDetailId = $this->input->post('flowDetailId');
      $levelCompleteCheck = $this->student_model->get_entityStatus($jobId);
      // show($levelCompleteCheck);
      if($levelCompleteCheck){
        $response = $this->student_model->update_entityStatus($entity_id,$flowDetailId);
        // echo $this->db->last_query();
      }else{
        $checkJob = $this->student_model->get_checkJob($jobId,$entity_id, 2);
        if(!empty($checkJob)){
          $response1 = $this->Common_model->insert('approval_flow_jobs', $checkJob); 
        }
      } 
      $response = $this->Common_model->update('approval_flow_jobs',array("status"=>"3", "remarks"=>$remark),array("id"=>$jobId)); 
      if($response){
        $ajax_response['st']=1;
        $ajax_response['msg']='Rejected Successfully';
      }
      else{
        $ajax_response['st']=0;
        $ajax_response['msg']='Something went wrong,Please try again later..!';
      } 
    }else{
      $ajax_response['st']=0;
      $ajax_response['msg']='Something went wrong,Please try again later..!';
    }
    print_r(json_encode($ajax_response));
  }
  public function approve_entity_job(){
    if($_POST){
      $entityID = $this->input->post('entityID');
      $jobId = $this->input->post('jobId');
      $flowDetailId = $this->input->post('flowDetailId');
      $level = $this->student_model->get_carrentLevel($flowDetailId); 
      $levels = $this->student_model->get_maximumLevel($level[0]->flow_entities); 
      $joblevel = $level[0]->level;
      if($joblevel < $levels){
        $joblevel = (int)$joblevel + 1;
        $nextUsers = $this->student_model->get_nextUsers($joblevel, $level[0]->flow_entities);
        $list = array();
        foreach($nextUsers as $Users){
          $job = $this->student_model->get_jobsUsers($Users->id);
          $list[$Users->id] = $job;
        }
        asort($list);
        if(!empty($list)){
          $id = array_keys($list)[0]; 
          $data = array('flow_detail_id' => $id, 'entity_id' => $entityID);
          $response = $this->Common_model->insert('approval_flow_jobs', $data); 
          if($response){
            $this->student_model->get_jobstatusChange($jobId, 2);
            // echo $this->db->last_query(); exit;
            $ajax_response['st']=1;
            $ajax_response['msg']='Aproved successfully. Material transferd to next level';
          }
          else{
            $ajax_response['st']=0;
            $ajax_response['msg']='Something went wrong,Please try again later..!';
          }
        } else {
          $ajax_response['st']=0;
          $ajax_response['msg']='You does\'t have a user in the next level. Please add user and try again..!';
        }
      }else{
        $response = $this->student_model->get_jobstatusChange($jobId, 2);
        // echo $this->db->last_query(); exit;
        if($response){

          $response1 = $this->student_model->get_questionsetStatusChange($level[0]->flow_entities, $entityID);
          // echo $this->db->last_query(); exit;
        }
        if($response1){
          $ajax_response['st']=1;
          $ajax_response['msg']='Aproved successfully. Material is ready to use';
        }
        else{
          $ajax_response['st']=0;
          $ajax_response['msg']='Something went wrong,Please try again later..!';
        } 
      }
    }
    print_r(json_encode($ajax_response));
  }
  public function create_learning_module(){
    // echo $_GET['id']; exit;
    // // check_backoffice_permission('create_learning_module');
    if($_GET['id']){ 
      $this->data['learningModule'] = $this->questionbank_model->get_learning_module_name($_GET['id']);
      // show($this->data['learningModule']);
      if(!empty($this->data['learningModule'])){
        $id = $_GET['jobid'];
        $user_id = $this->session->userdata('user_primary_id');
        $jobId = $this->common->get_from_tablesingleselect('approval_flow_entity_details', array('status'=>1,'user_id'=>$user_id),'id');
        $entityID = $this->common->get_name_by_id('approval_flow_jobs','entity_id',array('id'=>$id));
        $flowDetailId = $this->common->get_name_by_id('approval_flow_jobs','flow_detail_id',array('id'=>$id));
        $this->data['course'] = $this->questionbank_model->get_cource();
        $this->data['page']="admin/approve_learning_module";
        $this->data['menu']="employee";
        $this->data['breadcrumb'][0]['name']="Approve Management";
        $this->data['breadcrumb'][0]['url']=base_url('approve-management');
        $this->data['breadcrumb'][1]['name']="Approval Jobs";
        $this->data['breadcrumb'][1]['url']=base_url('approve-jobs/'.$flowDetailId);
        $this->data['breadcrumb'][2]['name']="Material View";
        $this->data['menu_item']    = "approve-management";
        $this->data['entityID'] = $entityID;
        $this->data['jobId'] = $id;
        $this->data['flowDetailId'] = $flowDetailId;
        $this->data['LMId'] = $_GET['id'];
        $this->load->view('admin/layouts/_master.php',$this->data);
      }else{
        redirect('404');
      }
    }else{
      redirect('404');
    }
    // echo '<pre>'; print_r($this->data['course']); exit;
  }
  public function get_subject_questions(){
    $learning_module_id=$this->input->post('learning_module_id');
    if($learning_module_id){
      $questions = $this->questionbank_model->get_selected_subject_questions($learning_module_id);
      // show($questions);
      // echo '<pre>';print_r($questions);exit;
      if(!empty($questions)){
        foreach($questions['questions'] as $k=>$v){
          $questions['questions'][$k]['question_content'] = limit_html_string($v['question_content'],10);
        }
        foreach($questions['selected_questions'] as $k=>$v){
          $questions['selected_questions'][$k]['question_content'] = limit_html_string($v['question_content'],10);
        }
      }
      $returnData['st'] 		    = TRUE;
      $returnData['questions'] 	= $questions;
    }else{
      $returnData['st'] 		    = FALSE;
      $returnData['questions'] 	= array();
    }
     print_r(json_encode($returnData));
   }
   public function save_learning_module_name(){
    $name = $this->input->post('name');
    $module_id = $this->input->post('module_id');
    if($module_id){
      $result = $this->questionbank_model->save_learning_module_name($module_id,$name);
      $duplicate_name = $this->questionbank_model->check_duplicate_module_name_edit($name);
      if($duplicate_name){
        $returnData['st'] 		  = 2;
        $returnData['msg'] 	= 'This name is already taken';
        print_r(json_encode($returnData));
        exit;
      }
      if($result){
        $returnData['st'] 		    = 1;
        $returnData['msg'] 		  = 'Learning module updated successfully!';
      }else{
        $returnData['st'] 		    = 0;
        $returnData['msg'] 		  = 'Somthing wrong!';
      }
    }else{
      $returnData['st'] 		    = 0;
      $returnData['msg'] 		  = 'Somthing wrong!';
    }
    print_r(json_encode($returnData));
  }
  public function save_selected_questions(){
    if($_POST){
      $qids = $this->input->post('question_ids');
      $delete_qids = $this->input->post('unselected_question_ids');
      $l_module_id = $this->input->post('module_id');
      // $course_id = $this->input->post('course_id');
      // $subject_id = $this->input->post('subject_id');
      if(!empty($qids)){
        $new_question_ids = $this->questionbank_model->get_new_question_ids($qids,$l_module_id);
        // echo '<pre>';print_r($new_question_ids);exit;
        $data=array();
        $current_question_number = $this->questionbank_model->get_last_question_number($l_module_id);
        if(!empty($new_question_ids)){
          foreach($new_question_ids as $k=>$qid){
            $current_question_number++;
            $data[$k]=array(
              'question_number'=>$current_question_number,
              'learning_module_id'=>$l_module_id,
              'question_id'=>$qid,
            );
          }
        }
        $result = $this->questionbank_model->save_learning_module_questions($l_module_id,$delete_qids,$data);
        if($result){
          $this->questionbank_model->reorder_exam_paper_questions($l_module_id);
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Questions added successfully';
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Server busy please try again later';
        }
      }else{
       $returnData['st'] 		  = 0;
       $returnData['message'] 	= 'Please select atleast one question to add in this section';
      }
    }else{
     $returnData['st'] 		  = 0;
     $returnData['message'] 	= 'Network Error';
   }
   print_r(json_encode($returnData));
  }
  public function get_approve_status(){
    $materialId = $this->input->post('id');
    $statusInfo = $this->questionbank_model->get_approve_statusLM($materialId);
    // show($statusInfo);
    $html = '<table class="table table-striped table-sm" style="width:100%"><thead> 
                    <tr class="lightBg">
                        <th>'.$this->lang->line('level').'</th>
                        <th >'.$this->lang->line('user').'</th>
                        <th >'.$this->lang->line('approval_status').'</th>
                        <th >'.$this->lang->line('remark').'</th>
                        <th >'.$this->lang->line('assigned_date').'</th>
                        <th >'.$this->lang->line('updated_date').'</th>
                    </tr>
                </thead>';
        if(!empty($statusInfo)){
            foreach($statusInfo as $data){
              $html.='<tr>
                          <td>
                              '.$data->level.'
                          </td>
                          <td>
                              '.$this->common->get_name_by_id('am_users_backoffice','user_name',array("user_id"=>$data->user_id)).'
                          </td>
                          <td>';
                          if($data->status == 1){$html.='New';}
                          else if($data->status == 2){$html.='Approved';}
                          else if($data->status == 3){$html.='Rejected';}
                          $html.='</td>
                          <td>
                              '.$data->remarks.'
                          </td>
                          <td>'.date('d/m/Y',strtotime($data->assign_date)).'</td>
                          <td>'.date('d/m/Y',strtotime($data->updated_date)).'</td>
                      </tr>';
            }
        }else{
            $html.='<tr>
                        <td colspan="6" class="text-center">
                            <span>No Activities</span>
                        </td>
                    </tr>';
        }
        $html.='</table>';
        echo $html;
  }
  // ------------------ Exam-paper Approval -----------------------------------------------

  public function create_exam_paper(){
    if($_GET['id']){ 
      $id = $_GET['jobid'];
      if(count($this->exam_model->scheduled_question_papers($_GET['id']))){
        redirect('404');
      }
      $user_id = $this->session->userdata('user_primary_id');
      $flowDetailId = $this->common->get_name_by_id('approval_flow_jobs','flow_detail_id',array('id'=>$id));
      $entityID = $this->common->get_name_by_id('approval_flow_jobs','entity_id',array('id'=>$id));
      $jobId = $this->common->get_from_tablesingleselect('approval_flow_entity_details', array('status'=>1,'user_id'=>$user_id),'id');
      $this->data['question_paper'] = $this->exam_model->get_question_paper($_GET['id']);
      if(!empty($this->data['question_paper'])){
        $this->data['questions'] = $this->exam_model->get_question_paper_questions($_GET['id']);
        $this->data['sections'] = $this->exam_model->get_model_sections_by_model_id($this->data['question_paper']->exam_definition_id);
        if(!empty($this->data['sections'])){
          foreach($this->data['sections'] as $key=>$val){
            $this->data['sections'][$key]->count=0;
            foreach($this->data['questions'] as $question){
              if($val->id==$question->sectionId){
                $this->data['sections'][$key]->count++;
              }
            }
          }
        }
        $this->data['page']="admin/approve_exam_paper";
        $this->data['menu']="employee";
        $this->data['breadcrumb'][0]['name']="Approve Management";
        $this->data['breadcrumb'][0]['url']=base_url('approve-management');
        $this->data['breadcrumb'][1]['name']="Approval Jobs";
        $this->data['breadcrumb'][1]['url']=base_url('approve-jobs/'.$flowDetailId);
        $this->data['breadcrumb'][2]['name']="Material View";
        $this->data['menu_item']    = "approve-management";
        $this->data['entityID'] = $entityID;
        $this->data['jobId'] = $id;
        $this->data['flowDetailId'] = $flowDetailId;
        $this->data['LMId'] = $_GET['id'];
        $this->load->view('admin/layouts/_master.php',$this->data);
      }else{
        redirect('404');
      }
    }else{
        redirect('404');
    }
  }
  public function save_preview_exam_paper(){
    $data['footer'] = '';
    if($_POST){
      $exam_paper_id = $this->input->post('exam_id');
      $view = $this->input->post('view');
      $details = $this->exam_model->get_exam_section_details_per_exam_paper($exam_paper_id);
      $questions = $this->exam_model->get_question_paper_questions($exam_paper_id);
      foreach($details as $k=>$v){
        $details[$k]['selected']=0;
        foreach($questions as $row){
          if($row->exam_section_details_id==$v['id']){
            $details[$k]['selected']++;
          }
        }
      }
      $valid=1;
      $data['title']="Please verify the details";
      $returnData['message'] 	= 'Preview and finish';
      $returnData['status'] 	= 1;
      foreach($details as $row){
        if($row['no_of_questions'] != $row['selected']){
          $valid=0;
          $returnData['status'] 	= 0;
          $returnData['message'] 	= 'One or more errors found';
          $data['title']="One or more modules doesnot have required number of questions. Please see the details below for more information";
          break;
        }
      }
      if(!$valid){
        $det=array();
        foreach($details as $k=>$row){
          $det[$row['section_id']]['section_name']=$row['section_name'];
          $det[$row['section_id']]['modules'][$k]=$row;
        }
        $body = '<div class="table-responsive table_language"><table class="table table-bordered table-striped table-sm">';
        foreach($det as $row){
          $body = $body.'<tr><th>'.$row['section_name'].'</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
          $body = $body.'<tr><th>Module Name</th><th>Required questions</th><th>Selected questions</th></tr>';
          foreach($row['modules'] as $modules){
            $body = $body.'<tr>';
            if($modules['no_of_questions']!=$modules['selected']){
              $body = $body.'<td>'.$modules['subject_name'].'&nbsp;&nbsp;&nbsp;<i class="fa fa-times" style="color:red;" aria-hidden="true"></i></td>';
            }else{
              $body = $body.'<td>'.$modules['subject_name'].'&nbsp;&nbsp;&nbsp;<i class="fa fa-check" style="color:green;" aria-hidden="true"></i></td>';
            }
            $body = $body.'<td>'.$modules['no_of_questions'].'</td>';
            $body = $body.'<td>'.$modules['selected'].'</td></tr>';
          }
          $body = $body.'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
        }
        $body = $body.'</table></div>';
      }else{
        $preview=array();
        foreach($questions as $row){
          if(!isset($preview[$row->sectionId])){$preview[$row->sectionId]=array();}
          array_push($preview[$row->sectionId],$row);
        }
        $htmlView['preview'] = $preview;
        if(!$view){
          $htmlView['view'] = 1;
        }else{
          $htmlView['view'] = 0;
        }
        $body = $this->load->view('admin/examManagement/html/exam_paper_preview',$htmlView,TRUE);
        $entityID = $this->input->post('entityID');
        $jobId = $this->input->post('jobId');
        $flowDetailId = $this->input->post('flowDetailId');
        $data['footer'] = ' <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonActive" onclick="approve_entity_job('.$entityID.','.$jobId.','.$flowDetailId.');">
                              Approve
                          </button>
                          <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonInactive" onclick="reject_entity_job('.$entityID.','.$jobId.','.$flowDetailId.');">
                              Reject
                          </button>';
      }
      $data['body']=$body;
      $returnData['st'] 		  = 1;
      $returnData['data']   	= $data;
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
   }
   public function get_section_selected_questions(){
    $section_id=$this->input->post('section_id');
    $module_id=$this->input->post('module_id');
    $exam_id=$this->input->post('exam_id');
    if($section_id && $exam_id && $module_id){
      $questions = $this->exam_model->get_exam_section_questions($section_id,$exam_id,$module_id);
      if(!empty($questions)){
        foreach($questions['questions'] as $k=>$v){
          $questions['questions'][$k]['question_content'] = limit_html_string($v['question_content'],10);
        }
        foreach($questions['selected_questions'] as $k=>$v){
          $questions['selected_questions'][$k]['question_content'] = limit_html_string($v['question_content'],10);
        }
      }
      $returnData['st'] 		    = TRUE;
      $returnData['questions'] 	= $questions;
    }else{
      $returnData['st'] 		    = FALSE;
      $returnData['questions'] 	= array();
    }
     print_r(json_encode($returnData));
   }
   public function delete_selected_question(){
    $id=$this->input->post('id');
    $exam_id=$this->input->post('exam_id');
    $section_id=$this->input->post('section_id');
    if($id){

      $question_id = $this->exam_model->delete_selected_question($id,$exam_id);
      $this->exam_model->reorder_exam_paper_questions_after_question_delete($exam_id,$question_id->question_id);
      
      $section_details = $this->exam_model->get_exam_section_details_per_section($section_id);
      foreach($section_details as $k=>$v){
        $details_id[$k] = $v['id'];
      }
      $questions = $this->exam_model->get_exam_details_questions($exam_id,$details_id);
      $count=0;
      if(!empty($questions)){
        $count = count($questions);
      }

      $returnData['st'] 		    = TRUE;
      $returnData['data'] 		  = $question_id->question_id;
      $returnData['count'] 		  = $count;
    }else{
     $returnData['st'] 		    = FALSE;
    }
    print_r(json_encode($returnData));
   }
   public function finish_question_paper(){
    if($_POST){
      $exam_paper_id = $this->input->post('exam_id');
      $approvel_user = $this->input->post('user_id');
      if(!empty($exam_paper_id)){
        $this->exam_model->finish_creating_question_paper($exam_paper_id, $approvel_user);
        if($approvel_user != 0){
          $data1=array(
            "flow_detail_id"=>$approvel_user,
            "entity_id"=>$exam_paper_id
          );
          $this->Common_model->insert('approval_flow_jobs', $data1); 
        }
        $returnData['st'] 		  = 1;
        $returnData['message'] 	= 'Question paper created successfully';
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Please try again later';
      }
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
  }
  public function get_section_modules(){
    if($_POST){
      $section_id = $this->input->post('section_id');
      if(!empty($section_id)){
        $section_modules = $this->exam_model->get_section_modules($section_id);
        $returnData['st'] 		  = 1;
        $returnData['data'] 		= $section_modules;
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Please try again later';
      }
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
  }
  public function save_selected_questionsexam(){
    if($_POST){
      $qids = $this->input->post('question_ids');
      $delete_qids = $this->input->post('unselected_question_ids');
      $exam_paper_id = $this->input->post('exam_id');
      $section_id = $this->input->post('section_id');
      $module_id = $this->input->post('module_id');
      if(!empty($qids)){
       $section_details = $this->exam_model->get_exam_section_details_per_section($section_id);
       foreach($section_details as $k=>$v){
         $details_id[$k] = $v['id'];
       }
       $new_question_ids = $this->exam_model->get_new_question_ids($qids,$exam_paper_id,$module_id);
       $data=array();
       // $count=0;
       // if(!empty($new_question_ids)){
       //   $question_details = $this->exam_model->get_question_subjects($new_question_ids);
       //   $last_question_number = $this->exam_model->get_last_question_number($exam_paper_id,$module_id);
       //   foreach($section_details as $k=>$v){
       //     $section_details[$k]['selected_count']=0;
       //     foreach($question_details as $qk=>$row){
       //       if($v['subject_id']==$row['subject_id']){
       //         $section_details[$k]['selected_count']++;
       //         if(!empty($new_question_ids)){
       //           $last_question_number++;
       //           $data[$qk]=array(
       //             'exam_paper_id'=>$exam_paper_id,
       //             'question_id'=>$question_details[$qk]['question_id'],
       //             'question_number'=>$last_question_number,
       //             'exam_section_details_id'=>$section_details[$k]['id'],
       //             'status'=>1,
       //             'version'=>1
       //           );
       //         }
       //       }
       //     }
       //   }
       // }
       $current_question_number = $this->exam_model->get_last_question_number($exam_paper_id,$details_id);
       if(!empty($new_question_ids)){
         foreach($new_question_ids as $k=>$qid){
           $current_question_number++;
           $data[$k]=array(
             'exam_paper_id'=>$exam_paper_id,
             'question_id'=>$qid,
             'question_number'=>$current_question_number,
             'exam_section_details_id'=>$module_id,
             'status'=>1,
             'version'=>1
           );
         }
       }
       // echo '<pre>';print_r($data);exit;

       $result = $this->exam_model->save_exam_paper_section_questions($exam_paper_id,$module_id,$delete_qids,$data);
       if($result){
         $questions = $this->exam_model->get_exam_details_questions($exam_paper_id,$details_id);
         $count=0;
         if(!empty($questions)){
           $count = count($questions);
         }
         $this->exam_model->reorder_exam_paper_questions($exam_paper_id,$details_id);
         $returnData['st'] 		  = 1;
         $returnData['message'] 	= 'Questions added successfully';
         $returnData['data'] 		= $count;//count($data);
       }else{
         $returnData['st'] 		  = 0;
         $returnData['message'] 	= 'Server busy please try again later';
       }
      }else{
       $returnData['st'] 		  = 0;
       $returnData['message'] 	= 'Please select atleast one question to add in this section';
      }
    }else{
     $returnData['st'] 		  = 0;
     $returnData['message'] 	= 'Network Error';
   }
   print_r(json_encode($returnData));
  }
  public function get_questions(){
    if($_POST){
      $question_id = $this->input->post('question_id');
      if(!empty($question_id)){
        $result = $this->questionbank_model->get_full_question($question_id);
        $list='';
        $question_difficulty = '';
        if(!empty($result)){
          if($result['question']->question_difficulty == 1){$question_difficulty='Easy';}
          if($result['question']->question_difficulty == 2){$question_difficulty='Medium';}
          if($result['question']->question_difficulty == 3){$question_difficulty='Hard';}

          if($result['question']->question_type == 1){$question_type='Objective';}
          if($result['question']->question_type == 2){$question_type='Descriptive';}
          
          $list.='<div class="row" style="margin-left: 15px;">';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Difficulty</div>
                      <div class="title-body"><h6>'.$question_difficulty.'</h6></div>
                    </div>';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Question Type</div>
                      <div class="title-body"><h6>'.$question_type.'</h6></div>
                    </div>';
          if(!empty($result['passage'])){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Passage</div>
                      <div class="title-body">'.$result['passage']->paragraph_content.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Question</div>
                    <div class="title-body">'.$result['question']->question_content.'</div>
                  </div>';
          if($result['question']->question_type == 1){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Options</div>
                      <div class="title-body"><ul>';
            $answer = '';
            if(!empty($result['options'])){
              foreach($result['options'] as $row){
                if($row->option_answer == 1){
                  $answer .= ' ('.$row->option_number.') '.$row->option_content;
                }
                $list.='<li>('.$row->option_number.') '.$row->option_content.'</li>';
              }
            }
            $list.='</ul></div></div>';
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Answer</div>
                      <div class="title-body">'.$answer.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Solution</div>
                    <div class="title-body">'.$result['question']->question_solution.'</div>
                  </div>';
          
          $list.='</div>';
        
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Success';
          $returnData['title'] 		= "Question";
          $returnData['body'] 		= $list;
        }else{
          $returnData['st'] 		= 0;
          $returnData['message'] 	= 'Passage not found';
        }
      }
      print_r(json_encode($returnData));
    }
  }
  public function delete_selected_questions(){
    $id=$this->input->post('id');
    $module_id=$this->input->post('module_id');
    if($id){
      $question_id = $this->questionbank_model->delete_selected_question($id);
      $this->questionbank_model->reorder_exam_paper_questions($module_id);
      // echo '<pre>'; print_r($question_id); exit;
      $returnData['st'] 		    = TRUE;
      $returnData['data'] 		  = $question_id;
    }else{
     $returnData['st'] 		    = FALSE;
    }
    print_r(json_encode($returnData));
  }
  public function get_single_learning_module(){
    $body = '';
    $id = $this->input->post('id');
    if($id){
      $learningModule = $this->questionbank_model->get_learning_module_name($id);
      $data['title'] = $learningModule->learning_module_name;
      $course = '<div class="row">
                          <div class="col-sm-12">
                              <div>
                                  &nbsp;&nbsp;Cource&nbsp;&nbsp;:&nbsp;&nbsp;<b>'.$this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$learningModule->course)).'</b>
                              </div>
                          </div>
                        </div>';
      $subject = '<div class="row">
                            <div class="col-sm-12">
                                <div>
                                  &nbsp;&nbsp;Subject&nbsp;&nbsp;:&nbsp;&nbsp;<b>'.$this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$learningModule->subject)).'</b>
                                </div>
                            </div>
                          </div><div class="row">&nbsp;</div>';
      $body .= $course;
      $body .= $subject;
      $questions = $this->questionbank_model->get_questions_by_learning_module_id($learningModule->id);
      // show($questions);
          $body .= '<div class="row">
                      <div class="col-sm-12">
                        <div class="title-header">
                          &nbsp;&nbsp;Questions
                        </div>
                          <div class="table-responsive table_language">
                            <table class="table table-bordered table-striped table-sm">
                              <tr>
                                <th>Sl.No</th>
                                <th>Question</th>
                                <th>Difficulty</th>
                              </tr>
                  ';
          if(!empty($questions)){
            $i = 0;
            foreach($questions as $row){
              if($row['question_difficulty'] == 1){$dfclty = '<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'; }
              else if($row['question_difficulty'] == 2){$dfclty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>'; }
              else if($row['question_difficulty'] == 3){$dfclty = '<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'; }
              $body  = $body.'<tr>
                                <td>'.++$i.'</td>
                                <td title="View Question details" onclick="getQuestion('.$row['question_id'].','.$row['learning_module_id'].');" style="cursor:pointer;">'.limit_html_string($row['question_content'],10).'</td>'
                                .$dfclty.
                              '</tr>';
            }
          }else{
            $body  = $body.'<tr>
                                <td colspan="3" style="text-align:center;">No Questions assigned</td>
                            </tr>';
          }
          $data['body'] = $body.'</table></div></div></div>';
          $data['footer'] = '<button class="btn btn-info close" data-dismiss="modal">OK</button>';
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Please review the exam model';
          $returnData['data'] 		= $data;
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Please try again later';
        }
    print_r(json_encode($returnData));
  }
  public function view_rejectedRemark(){
    $returnData['remark'] = $this->common->get_name_by_id('approval_flow_jobs','remarks',array('id'=>$this->input->post('id')));
    print_r(json_encode($returnData));
   }
   
   public function get_questionLM(){
    if($_POST){
      $question_id = $this->input->post('question_id');
      $lmId = $this->input->post('lmId');
      if(!empty($question_id)){
        $result = $this->questionbank_model->get_full_question($question_id);
        $list='';
        if(!empty($result)){
          if($result['question']->question_difficulty == 1){$question_difficulty='Easy';}
          if($result['question']->question_difficulty == 2){$question_difficulty='Medium';}
          if($result['question']->question_difficulty == 3){$question_difficulty='Hard';}

          if($result['question']->question_type == 1){$question_type='Objective';}
          if($result['question']->question_type == 2){$question_type='Descriptive';}
          
          $list.='<div class="row" style="margin-left: 15px;">';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Difficulty</div>
                      <div class="title-body"><h6>'.$question_difficulty.'</h6></div>
                    </div>';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Question Type</div>
                      <div class="title-body"><h6>'.$question_type.'</h6></div>
                    </div>
                  <div class="form-group col-sm-4">
                    <a class="btn btn-default add_new_btn btn_add_call addBtnPosition" onclick="view_learning_module('.$lmId.',1)">
                      Back
                    </a>
                  </div>';
          if(!empty($result['passage'])){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Passage</div>
                      <div class="title-body">'.$result['passage']->paragraph_content.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Question</div>
                    <div class="title-body">'.$result['question']->question_content.'</div>
                  </div>';
          if($result['question']->question_type == 1){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Options</div>
                      <div class="title-body"><ul>';
            $answer = '';
            if(!empty($result['options'])){
              foreach($result['options'] as $row){
                if($row->option_answer == 1){
                  $answer .= ' ('.$row->option_number.') '.$row->option_content;
                }
                $list.='<li>('.$row->option_number.') '.$row->option_content.'</li>';
              }
            }
            $list.='</ul></div></div>';
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Answer</div>
                      <div class="title-body">'.$answer.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Solution</div>
                    <div class="title-body">'.$result['question']->question_solution.'</div>
                  </div>';
          
          $list.='</div>';
        
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Success';
          $returnData['title'] 		= "Question";
          $returnData['body'] 		= $list;
        }else{
          $returnData['st'] 		= 0;
          $returnData['message'] 	= 'Passage not found';
        }
      }
      print_r(json_encode($returnData));
    }
  }
  public function get_questionEP(){
    if($_POST){
      $question_id = $this->input->post('question_id');
      $epId = $this->input->post('epId');
      if(!empty($question_id)){
        $result = $this->exam_model->get_full_question($question_id);
        $list='';
        if(!empty($result)){
          if($result['question']->question_difficulty == 1){$question_difficulty='Easy';}
          if($result['question']->question_difficulty == 2){$question_difficulty='Medium';}
          if($result['question']->question_difficulty == 3){$question_difficulty='Hard';}

          if($result['question']->question_type == 1){$question_type='Objective';}
          if($result['question']->question_type == 2){$question_type='Descriptive';}
          
          $list.='<div class="row" style="margin-left: 15px;">';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Difficulty</div>
                      <div class="title-body"><h6>'.$question_difficulty.'</h6></div>
                    </div>';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Question Type</div>
                      <div class="title-body"><h6>'.$question_type.'</h6></div>
                    </div>
                  <div class="form-group col-sm-4">
                    <a class="btn btn-default add_new_btn btn_add_call addBtnPosition" onclick="view_question_paper('.$epId.',1)">
                      Back
                    </a>
                  </div>';
          if(!empty($result['passage'])){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Passage</div>
                      <div class="title-body">'.$result['passage']->paragraph_content.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Question</div>
                    <div class="title-body">'.$result['question']->question_content.'</div>
                  </div>';
          if($result['question']->question_type == 1){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Options</div>
                      <div class="title-body"><ul>';
            $answer = '';
            if(!empty($result['options'])){
              foreach($result['options'] as $row){
                if($row->option_answer == 1){
                  $answer .= ' ('.$row->option_number.') '.$row->option_content;
                }
                $list.='<li>('.$row->option_number.') '.$row->option_content.'</li>';
              }
            }
            $list.='</ul></div></div>';
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Answer</div>
                      <div class="title-body">'.$answer.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Solution</div>
                    <div class="title-body">'.$result['question']->question_solution.'</div>
                  </div>';
          
          $list.='</div>';
        
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Success';
          $returnData['title'] 		= "Question";
          $returnData['body'] 		= $list;
        }else{
          $returnData['st'] 		= 0;
          $returnData['message'] 	= 'Passage not found';
        }
      }
      print_r(json_encode($returnData));
    }
  }
}
