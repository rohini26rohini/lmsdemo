<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedulejobs extends Direction_Controller{
	public function __construct() {
        parent::__construct();
	}
	
	public function email(){
		$this->email->send_scheduled_emails();
	}

	public function exam_schedule_coloring(){
		$schedules = [];
		$exams = $this->db->select('gm_exam_schedule.status,am_schedules.schedule_id')
							->from('am_schedules')
							->join('gm_exam_schedule','gm_exam_schedule.id=am_schedules.schedule_link_id')
							->where('am_schedules.schedule_type',1)
							->get()->result_array();
		if(!empty($exams)){
			foreach($exams as $exam){
				$schedule['schedule_id'] = $exam['schedule_id'];
				$schedule['schedule_color'] = '';
				if($exam['status']==2){$schedule['schedule_color']=EXAM_START_COLOR;}
				if($exam['status']==3){$schedule['schedule_color']=EXAM_FINISH_COLOR;}
				if($exam['status']==4){$schedule['schedule_color']=EXAM_RESULT_PUBLISHED_COLOR;}
				if($exam['status']==5){$schedule['schedule_color']=EXAM_CLOSED_COLOR;}
				array_push($schedules,$schedule);
			}
			$this->db->update_batch('am_schedules',$schedules,'schedule_id');
		}
	}

	public function sync_am_gm_student_pass(){
		if($_SERVER['HTTP_HOST'] != 'www.direction.school'){
			exit;
		}
		$previous_date = date('Y-m-d H:i:s',(strtotime ( '-1 day' , time() ) ));
		$students = $this->db->select('am_users.*')
							->from('am_users')
							->where('am_users.user_role','student')
							->where('am_users.modified_date >',$previous_date)
							->get()->result_array();
		if(!empty($students)){
			$this->load->model('Auth_model');
			foreach($students as $row){
				$regNum = $row['user_username'];
				$student_password = $this->Auth_model->get_pass($row['user_passwordhash']);
				$student_id = $row['user_primary_id'];
				$response = $this->common->gm_user_registration($regNum,$student_password,$student_id);
				$message = date("Y-m-d H:i:s").','.$student_id.','.str_replace(',','///',json_encode($response));
				$log_file_path = FCPATH."uploads/_log_cron_job_sync_am_gm_student_pass.csv";
				if(file_exists($log_file_path)){
					$fh = fopen($log_file_path, 'a');
					fwrite($fh, $message."\n");
				}else{
					$fh = fopen($log_file_path, 'w');
					fwrite($fh, 'Date and Time,am_users.user_primary_id,API-response'."\n");
					$fh = fopen($log_file_path, 'a');
					fwrite($fh, $message."\n");
				}
			}
			fclose($fh);
		}
	}


public function attendence_leave_sinking(){
	$staffs = $this->Staff_model->get_active_staff(); //echo '<pre>'; print_r($staffs);
	if(!empty($staffs)) {
		foreach($staffs as $staff) {
			$attendence = $this->Staff_model->get_attendence_by_staff_id($staff->personal_id, date('Y-m-d')); print_r($attendence);
			if(empty($attendence)) {
				$data = array('staff_id'=>$staff->personal_id,
								'date' => date('Y-m-d'),
								'attendance' =>0
								);
				$absent = $this->Staff_model->insert_absent($data);	
				if($absent>0) {
					if($staff->reporting_head) {
						$reporting_head = $staff->reporting_head;
					} else {
						$reporting_head = 0;
					}
					$leavedata = array('user_id'=>$staff->personal_id,
										'reporting_head'=>$reporting_head,
										'type_id'=>0,
										'start_date'=>date('Y-m-d'),
										'end_date'=>date('Y-m-d'),
										'num_days'=>1,
										'leave_status'=>0,
										'status'=>1,
										'title'=>'EMR',
										'description'=>'EMR'
										);
				$leavereq = $this->Staff_model->insert_leaverequest($leavedata);
				// if($leavereq>0) {
				// 	$logdata = array('staff_id'=>$staff->personal_id,
				// 					'leave_heads_id'=>2,
				// 					'start_date'=>date('Y-m-d'),
				// 					'end_date'=>date('Y-m-d'),
				// 					'no_of_days'=>1,
				// 					'type'=>1,
				// 					'status'=>1
				// 					);
				// 	$logentry = $this->Staff_model->insert_leavelog($logdata);					
				// }						
				}			
			}
		}
	}
}


}
