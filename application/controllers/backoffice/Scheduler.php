<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scheduler extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        $module="class_schedule";
        check_backoffice_permission($module);
    }

    public function index(){
        check_backoffice_permission("manage_schedule");
      $this->data['menu']="scheduler";
      $this->data['breadcrumb'][0]['name']="Scheduler";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/scheduler');
      $this->data['page']="admin/scheduler/index";
      $this->data['menu_item']="index";
      $this->load->view('admin/layouts/_master',$this->data);
    }

    public function class_schedule(){
      check_backoffice_permission("manage_class_schedule");
      $this->data['menu']="scheduler";
      $this->data['breadcrumb'][0]['name']="Scheduler";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/scheduler');
      $this->data['breadcrumb'][1]['name']="Automated Class schedule";
      $this->data['branch'] = $this->scheduler_model->get_branch();
      $this->data['page']="admin/scheduler/class_schedule";
      $this->data['menu_item']="class_schedule";
      $this->load->view('admin/layouts/_master',$this->data);
    }
    
    public function manual_class_schedule(){
      check_backoffice_permission("manual_class_schedule");
      $this->data['menu']="scheduler";
      $this->data['breadcrumb'][0]['name']="Scheduler";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/scheduler');
      $this->data['breadcrumb'][1]['name']="Manual Class schedule";
      if(isset($_GET['id']) && !empty($_GET['id'])){
        $schedule_detail = $this->scheduler_model->get_schedule_details($_GET['id']);
        $reschedule_data=array(
                              'schedule_id'=>$schedule_detail['schedule_id'],
                              'course_id'=>$schedule_detail['course_id'],
                              'branch_id'=>$schedule_detail['branch_id'],
                              'center_id'=>$schedule_detail['center_id'],
                              'subject_id'=>$schedule_detail['subject_id'],
                              'batch_id'=>$schedule_detail['schedule_link_id'],
                              'date'=>date('d-m-Y',strtotime($schedule_detail['schedule_date'])),
                              'calendar_date'=>date('Y-m-d',strtotime($schedule_detail['schedule_date'])),
                              'start_time'=>date('h:i a',strtotime($schedule_detail['schedule_start_time'])),
                              'end_time'=>date('h:i a',strtotime($schedule_detail['schedule_end_time'])),
                              'room'=>$schedule_detail['schedule_room'],
                              'staff_id'=>$schedule_detail['staff_id'],
                              'module_id'=>$schedule_detail['module_id']
                            );
        // echo '<pre>';print_r($reschedule_data);exit;
        $this->data['reschedule_data'] = $reschedule_data;
      }
      $this->data['branch'] = $this->scheduler_model->get_branch();
      $this->data['page']="admin/scheduler/manual_class_schedule";
      $this->data['menu_item']="manual_class_schedule";
      $this->load->view('admin/layouts/_master',$this->data);
    }

    /** AJAX CALLS **/

    public function get_center(){
      if($_POST){
        $branch_id = $this->input->post('branch_id');
        $data['centers'] = $this->common->get_center_in_branch($branch_id);
        print_r(json_encode($data,2));
      }
    }

    public function get_course(){
      if($_POST){
        $center_id = $this->input->post('center_id');
        $data['courses'] = $this->common->get_courses_in_center($center_id);
        // show($data['courses']);
        print_r(json_encode($data,2));
      }
    }

    public function get_batch(){
      if($_POST){
        $center_id = $this->input->post('center_id');
        $course_id = $this->input->post('course_id');
        $data['batch'] = $this->common->get_batch_in_center_course($center_id,$course_id);
        print_r(json_encode($data));
      }
    }

    public function get_course_subjects(){
      if($_POST){
        $course_id = $this->input->post('course_id');
        $data['subjects'] = $this->common->get_course_subjects($course_id);
        print_r(json_encode($data));
      }
    }

    public function get_course_subject_modules(){
      if($_POST){
        $course_id = $this->input->post('course_id');
        $subject_id = $this->input->post('subject_id');
        $data['modules'] = $this->common->get_course_subject_modules($course_id,$subject_id);
        print_r(json_encode($data));
      }
    }

    public function get_exam_rooms_center(){
      if($_POST){
        $center = $this->input->post('center');
        $rooms = $this->exam_model->get_rooms_center_branch($center);
        if(!empty($rooms)){
          $html = '<option value="">Select a room</option>';
          foreach($rooms as $row){
            $html = $html.'<option value="'.$row->room_id.'">'.$row->institute_name.' - '.$row->classroom_name.'</option>';
          }
        }else{
          $html = '<option value="">No rooms available for this center</option>';
        }
        $returnData['st'] 		= 1;
        $returnData['html'] 	= $html;
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_faculty_module(){
      if($_POST){
        $batch = $this->input->post('batch');
        $subject = $this->input->post('subject');
        $module = $this->input->post('module');
        $date = $this->input->post('date');
        $starttime = $this->input->post('starttime');
        $endtime = $this->input->post('endtime');
        $faculties = $this->scheduler_model->get_faculty_module($batch,$date,$subject,$module,$starttime,$endtime);
        if(!empty($faculties)){
          $html = '<option value="">Select a faculty</option>';
          foreach($faculties as $row){
            $html = $html.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
          }
        }else{
          $html = '<option value="">No faculties are available to take this class in this center</option>';
        }
        $returnData['st'] 		= 1;
        $returnData['html'] 	= $html;
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_batch_schedule_available_dates(){
      if($_POST){
        $batch = $this->common->get_batch_details($this->input->post('batch'));
        $data['batch_datefrom'] = date('Y-m-d',strtotime($batch['batch_datefrom']));
        $data['batch_dateto'] = date('Y-m-d',strtotime($batch['batch_dateto']));
        $data['datefrom'] = date('d-m-Y',strtotime($batch['batch_datefrom']));
        $data['dateto'] = date('d-m-Y',strtotime($batch['batch_dateto']));
        print_r(json_encode($data));
      }
    }

    public function schedule_batch(){
      $this->form_validation->set_rules('branch', 'Branch', 'trim|required');
      $this->form_validation->set_rules('center', 'Center', 'trim|required');
      $this->form_validation->set_rules('batch', 'Batch', 'trim|required');
      if($this->form_validation->run()){

        // Collect start date, end date and batch id
        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');
        $batch_id   = $this->input->post('batch');
        $batch_details = $this->common->get_batch_details($batch_id);
        if(empty($start_date)){$start_date = $batch_details['batch_datefrom'];}
        if(empty($end_date)){$end_date = $batch_details['batch_dateto'];}

        // Check whether the given start date and end date is not in between the batch date
        if((strtotime($start_date)>strtotime($end_date)) ||
          (strtotime($start_date)<strtotime($batch_details['batch_datefrom'])) ||
          (strtotime($end_date)>strtotime($batch_details['batch_dateto'])))
        {
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Please specify a valid start time and end time';
          print_r(json_encode($returnData));
          exit;
        }

        if(!empty($batch_details)){
          $batch_class_details = $this->get_batch_class_details($batch_id);
          $batch_weekdays = $this->get_batch_weekdays($batch_details);
          $schedule_color = $this->scheduler_model->get_batch_course_color($batch_id);
          $holidays = $this->common->get_holidays();// Get all holiday dates

          $date = date('Y-m-d',strtotime($start_date));
          $preview_schedule_data = array();
          $i=0;

          $this->schedule->delete_all_conflicted_schedules($batch_id);// Delete all conflicted and unapproved schedules for this batch
          
          while(strtotime($date) <= strtotime($end_date)){ // Iterate all dates starting from start date to end date 
            if(!in_array($date,$holidays)){ // Skip holidays
              $current_weeekday = date('D',strtotime($date));
              if(in_array($current_weeekday,$batch_weekdays)){ // Check whether the selected date's week day is in batch's scheduled weekday
                if(isset($batch_class_details[$current_weeekday]) && !empty($batch_class_details[$current_weeekday])){ // Check if this day has any classes for this batch
                  foreach($batch_class_details[$current_weeekday] as $row){ // Iterate all classes for the selected date
                    $class_details = array();
                    $class_details = $this->schedule->get_batch_schedule_details($batch_id,$date,$row['start_time'],$row['end_time']);// Find if this batch is already scheduled
                    if(empty($class_details)){ // If this batch is not scheduled on this day and time
                      $class_details = $this->schedule->create_batch_schedule($batch_id,$date,$row['start_time'],$row['end_time'],$schedule_color['color']); // Create a new batch schedule
                      if($class_details == false){ // Check if all modules are scheduled
                        break;
                      }else{
                        $this->scheduler_model->store_schedule_detail($this->create_schedule_data($class_details)); // Save this batch schedule in DB
                      }
                    }
                    $preview_schedule_data[$i] = $this->create_schedule_data($class_details);
                    $i++;
                  }
                  if($class_details == false){
                    break;
                  }
                }
              }
            }
            $date = date('Y-m-d', strtotime("+1 day", strtotime($date))); // Increment day by one
          }
          
          if(!empty($preview_schedule_data)){
            $data['body'] = $this->scheduler_model->get_new_schedule_preview($preview_schedule_data);
            $data['title'] = 'Course schedule recommendation for the batch <strong>'.$batch_details['batch_name'].'</strong> starting from <strong>'.date('d-m-Y',strtotime($start_date)).'</strong> to <strong>'.date('d-m-Y',strtotime($end_date)).'</strong>';
            $data['footer'] = '<button onClick="finish_scheduling()" class="btn btn-success">Save</button>';
            $returnData['st'] 		  = 1;
            $returnData['message'] 	=  'Please review this course schedule recommendation';
            $returnData['data'] 		= $data;
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Please goto basic setting and define class timing details for this batch. ';
          }
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Batch details are incomplete. Please goto basic setting and define batch details';
        }

      }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= validation_errors();
      }
      print_r(json_encode($returnData));
    }

    public function finish_scheduling(){
      $batch = $this->input->post('batch');
      $date = $this->scheduler_model->get_batch_schedule_date($batch);
      if($this->scheduler_model->finish_scheduling($batch)){
        $returnData['st'] 		  = 1;
        $returnData['message'] 	= 'Successfully scheduled ';
        $returnData['date'] 		= date('Y-m-d',strtotime($date));
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $json = json_encode($batch);
        logcreator('insert', 'Course scheduling', $who, $json, 0, 'am_schedules', 'New schedule created for batch');
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Internal server error please try again later';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $json = json_encode($batch);
        logcreator('insert', 'Course scheduling', $who, $json, 0, 'am_schedules', 'Course scheduling failed');
      }
      print_r(json_encode($returnData));
    }

    private function get_batch_weekdays($data){
      $weekdays=array();
      if(!empty($data)){
        if($data['monday']){array_push($weekdays,'Mon');}
        if($data['tuesday']){array_push($weekdays,'Tue');}
        if($data['wednesday']){array_push($weekdays,'Wed');}
        if($data['thursday']){array_push($weekdays,'Thu');}
        if($data['friday']){array_push($weekdays,'Fri');}
        if($data['saturday']){array_push($weekdays,'Sat');}
        if($data['sunday']){array_push($weekdays,'Sun');}
      }
      return $weekdays;
    }

    private function get_batch_class_details($batch_id){
      $classes = array();
      $data = $this->common->batch_class_details($batch_id);
      $i=0;
      if(!empty($data)){
        foreach($data as $row){
          $classes[$row['week_day']][$i] = $row;
          $i++;
        }
      }
      return $classes;
    }

    private function create_schedule_data($class_details){
      return array(
              'schedule_type'=>$class_details['schedule_type'],
              'schedule_link_id'=>$class_details['schedule_link_id'],
              'schedule_status'=>$class_details['schedule_status'],
              'schedule_date'=>$class_details['schedule_date'],
              'schedule_start_time'=>$class_details['schedule_start_time'],
              'schedule_end_time'=>$class_details['schedule_end_time'],
              'schedule_room'=>$class_details['schedule_room'],
              'staff_id'=>$class_details['staff_id'],
              'module_id'=>$class_details['module_id'],
              'schedule_description'=>$class_details['schedule_description'],
              'schedule_color'=>$class_details['schedule_color']
            );
    }

    public function manually_schedule_batch(){
      $this->form_validation->set_rules('branch', 'Branch', 'trim|required');
      $this->form_validation->set_rules('center', 'Center', 'trim|required');
      $this->form_validation->set_rules('course', 'Course', 'trim|required');
      $this->form_validation->set_rules('batch', 'Batch', 'trim|required');
      $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
      $this->form_validation->set_rules('module', 'Module', 'trim|required');
      $this->form_validation->set_rules('date', 'Date', 'trim|required');
      $this->form_validation->set_rules('starttime', 'Start time', 'trim|required');
      $this->form_validation->set_rules('endtime', 'End time', 'trim|required');
      $this->form_validation->set_rules('faculty', 'Faculty', 'trim|required');
      $this->form_validation->set_rules('room', 'Room', 'trim|required');
      if($this->form_validation->run()){
        $batch = $this->input->post('batch');
        $module = $this->input->post('module');
        $date = date('Y-m-d',strtotime($this->input->post('date')));
        $starttime = date('H:i:s',strtotime($this->input->post('starttime')));
        $endtime = date('H:i:s',strtotime($this->input->post('endtime')));
        $faculty = $this->input->post('faculty');
        $room = $this->input->post('room');
        $schedule_id = $this->input->post('schedule_id');
        if(empty($schedule_id)){$schedule_id=0;}
        if(strtotime($starttime)>=strtotime($endtime)){
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Invalid start and end time';
          print_r(json_encode($returnData));
          exit;
        }
        if(!$this->schedule->check_batch_availability($batch,$date,$starttime,$endtime,$schedule_id)){
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'This batch already have a schedule at this time';
          print_r(json_encode($returnData));
          exit;
        }
        if(!$this->schedule->check_room_eligibility($room,$batch,$date,$starttime,$endtime,NULL,NULL,$schedule_id)){
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'This room is not available for this batch';
          print_r(json_encode($returnData));
          exit;
        }
        if(!$this->schedule->check_faculty_availability($faculty,$date,$starttime,$endtime,$schedule_id)){
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'This faculty already have a schedule at this time';
          print_r(json_encode($returnData));
          exit;
        }
        if(!$this->schedule->check_module_eligibility($batch,$module,$date,$starttime,$endtime)){
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'This topic cannot be scheduled unless its parent topic is scheduled before this date';
          print_r(json_encode($returnData));
          exit;
        }
        $schedule_color = $this->scheduler_model->get_batch_course_color($batch);
          $batch_name=$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$batch));
        $data = array(
                      'schedule_type'=>2,
                      'schedule_link_id'=>$batch,
                      'schedule_status'=>1,
                      'schedule_date'=>$date,
                      'schedule_start_time'=>$starttime,
                      'schedule_end_time'=>$endtime,
                      'schedule_room'=>$room,
                      'staff_id'=>$faculty,
                      'module_id'=>$module,
                      'schedule_description'=>'Class schedule for batch '.$batch_name,
                      'schedule_color'=>$schedule_color['color']
                    );
         // print_r($data);
        if(!empty($schedule_id)){
          if($this->scheduler_model->update_schedule_detail($data,$schedule_id)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Rescheduled successfully';
            $returnData['date'] 		= date('Y-m-d',strtotime($date));
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $json = json_encode($data);
            logcreator('update', 'Manual Course rescheduling', $who, $json, 0, 'am_schedules', 'Batch rescheduled');
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Internal server error please try again later';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $json = json_encode($data);
            logcreator('update', 'Manual Course Rescheduling', $who, $json, 0, 'am_schedules', 'Batch rescheduling failed');
          }
        }else{
          if($this->scheduler_model->store_schedule_detail($data)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Scheduled successfully';
            $returnData['date'] 		= date('Y-m-d',strtotime($date));
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $json = json_encode($data);
            logcreator('update', 'Manual Course rescheduling', $who, $json, 0, 'am_schedules', 'New batch schedule created');
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Internal server error please try again later';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $json = json_encode($data);
            logcreator('update', 'Manual Course Rescheduling', $who, $json, 0, 'am_schedules', 'Batch scheduling failed');
          }
        }
        //echo $this->db->last_query();
      }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= validation_errors();
      }
      print_r(json_encode($returnData));
    }
    
    public function delete_schedule(){
      if(isset($_POST['schedule_id'])){
        $schedule_id = $this->input->post('schedule_id');
        $data['schedule_status'] = 0;
        if($this->scheduler_model->delete_schedule_detail($data,$schedule_id)){
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Schedule cancelled';
          $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
          $json = json_encode($_POST);
          logcreator('update', 'database', $who, $json, ' Course scheduling ', 'am_schedules', 'Batch schedule cancelled');
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Internal server error please try again later';
          $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
          $json = json_encode($_POST);
          logcreator('update', 'database', $who, $json, ' Course scheduling ', 'am_schedules', 'Batch schedule cancelling failed');
        }
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Access denied';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $json = json_encode($_POST);
        logcreator('update', 'database', $who, $json, ' Course scheduling ', 'am_schedules', 'Batch schedule cancelling failed, Access denied');
      }
      print_r(json_encode($returnData));
    }

    public function change_exam_status(){
      if(isset($_POST['schedule_id'])){
        $schedule_id = $this->input->post('schedule_id');
        $schedule = $this->scheduler_model->get_gm_exam_schedule_details($schedule_id);
        if($schedule['status'] == 1){
          $statusname='Exam started';
          $data['status'] = 2;
        }
        if($schedule['status'] == 2){
          $statusname='Exam finished';
          $data['status'] = 3;
        }
        if($schedule['status'] == 3){
          $job_status = $this->scheduler_model->is_answers_collected_by_job($schedule['id']);
          if(!$job_status['status']){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= $job_status['message'];
            print_r(json_encode($returnData));
            exit;
          }
          $evaluated = $this->scheduler_model->is_evaluated_descriptive_questions($schedule['id']);
          if(!$evaluated){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Some answered descriptive questions are not evaluated. Without evaluating the answers the result cannot be published.';
            print_r(json_encode($returnData));
            exit;
          }
          $statusname='Exam result published';
          $data['status'] = 4;
          $data['end_date_time'] = date("Y-m-d H:i:s"); 
          // $time['schedule_end_time']=date('H:i:s');	
          // $this->db->where('schedule_id', $schedule_id);
          // $this->db->update('am_schedules', $time);
		    }
        if($schedule['status'] == 4){
          $statusname='Exam closed';
          $data['status'] = 5; 
          $data['end_date_time'] = date("Y-m-d H:i:s"); 
          // $time['schedule_end_time']=date('H:i:s');	
          // $this->db->where('schedule_id', $schedule_id);
          // $this->db->update('am_schedules', $time);
        }
        
        if($schedule['status'] == 5){
          $statusname='Exam Deactivated';
          $data['status'] = -1; 
        }
        
        if($this->scheduler_model->change_exam_status($data,$schedule['id'])){
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= $statusname;
          $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
          $json = json_encode($data);
          logcreator('update', 'database', $who, $json, ' Exam status update ', 'am_schedules', $statusname);
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Internal server error please try again later';
          $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
          $json = json_encode($data);
          logcreator('update', 'database', $who, $json, ' Exam status update ', 'am_schedules', 'Exam status changing failed');
        }
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Access denied';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
          $json = json_encode($data);
          logcreator('update', 'database', $who, $json, ' Exam status update ', 'am_schedules', 'Exam status changing failed, Access denied.');
      }
      print_r(json_encode($returnData));
    }
}
?>
