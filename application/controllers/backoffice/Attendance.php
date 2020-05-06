<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="attendance";
        check_backoffice_permission($module);

    }
    
    /*
    *   function'll load attendance sheet 
    *   @params center
    *   @autor GBS-R
    *
    */ 

    public function daily_attendance(){
        $user_id = $this->session->userdata('user_id');
        $center  = $this->session->userdata('center');
        $this->data['batches'] = $this->common->get_batches_by_center($center);
        // echo $this->db->last_query(); 
        //echo"<pre>"; print_r($this->data['batches']); die();
        $this->data['page']="admin/daily_attendance_mark_view";
		$this->data['menu']="attendance";
        $this->data['breadcrumb']="Attendance";
        $this->data['menu_item']="daily_attendance";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    
    /*
    *   function'll load individual batch attendance sheet marking view
    *   @params batch id, date, session
    *   @autor GBS-R
    *
    */

    public function attendancesheet_load_view(){
        $batch_id                       = $this->input->post('batch_id');
        $this->data['batch_id']         = $batch_id;
        $this->data['schedule_id']      = $this->input->post('schedule_id');
        $this->data['dateval']          = $this->input->post('dateval');
        $this->data['type']             = $this->input->post('type');
        $this->data['students']         = $this->Attendance_model->get_student_bybatch($batch_id,date('Y-m-d', strtotime($this->data['dateval'])));
       //print_r($this->data['students']);echo $this->db->last_query();
        $marked = $this->Attendance_model->get_marked_attendance($batch_id, $this->data['schedule_id'], date('Y-m-d', strtotime($this->data['dateval'])), $this->data['type']);
        if(!empty($marked)) {
        $this->data['students'] = $marked; 
          //echo "<pre>"; print_r( $this->data['students']);
        echo $this->load->view('admin/attendance_marked_sheet',$this->data, true);    
        } else {
		echo $this->load->view('admin/attendance_marking_sheet',$this->data, true);
        }
    }
    
    /*
    *   function'll save attendance
    *   @params batch id, schedule id, student array
    *   @autor GBS-R
    *
    */

    public function save_attendance($date = NULL){
        $schedule_id = $this->input->post('schedule_id');
        $student_id = $this->input->post('student_id');
        $batch_id = $this->input->post('batch_id');
        $type = $this->input->post('type');
        if($date && $schedule_id && $student_id && $batch_id) {
        if(!empty($student_id)) {
            foreach($student_id as $student) {
                $attendance = $this->input->post('attendance_'.$student);
                if($attendance==1) {
                   $presant = 1 ;
                } else {
                   $presant = 0 ; 
                }
                $date = date('Y-m-d', strtotime($date));
                $data = array('schedule_id'=>$schedule_id,
                             'batch_id'=>$batch_id,
                             'student_id'=>$student,
                             'att_date'=>$date,
                             'attendance'=>$presant,
                              'type'=>$type
                             );
                $resultarr = $this->Attendance_model->update_attendance($data);
            }
            $result['status'] = true;
            $result['data'] = $resultarr;
            $result['message'] = 'Attendance marked successfully.'; 
        } else {
            $result['status'] = false;
            $result['data'] = false;
            $result['message'] = 'Student not allocated in this batch.'; 
        }
        } else {
            $result['status'] = false;
            $result['data'] = false;
            $result['message'] = 'Invalid data.';
        }
        
        print_r(json_encode($result));
    }
    
    
    /*
    *   function'll update attendance
    *   @params batch id, schedule id, student array
    *   @autor GBS-R
    *
    */

    public function update_attendance($date = NULL){
        $att_id = $this->input->post('att_id');
        $batch_id = $this->input->post('batch_id');
        if(!empty($att_id)) {
            foreach($att_id as $id) {
                $attendance = $this->input->post('attendance_'.$id);
                if($attendance==1) {
                   $presant = 1 ;
                } else {
                   $presant = 0 ; 
                }
                $date = date('Y-m-d', strtotime($date));
                $data = array(
                             'attendance'=>$presant
                             );
                $resultarr = $this->Attendance_model->update_attendancebyid($data, $id);
            }
            $result['status'] = true;
            $result['data'] = $resultarr;
            $result['message'] = 'Attendance updated successfully.'; 
        } else {
            $result['status'] = false;
            $result['data'] = false;
            $result['message'] = 'Invalid data.';
        }
        
        print_r(json_encode($result));
    }
    
    
     /*
    *   function'll load individual batch schdules onclick
    *   @params batch id, date
    *   @autor GBS-R
    *
    */

    public function showing_schedules_view(){
        $batch_id                       = $this->input->post('batch_id');
        $this->data['batch_id']         = $batch_id;
        $this->data['date']             = date('Y-m-d', strtotime($this->input->post('dateval')));
        $this->load->view('admin/batch_schedules_load_view',$this->data);
    }

}
