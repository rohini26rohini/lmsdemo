<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Direction_Controller {
	public function index()
	{
            $this->load->view('welcome_message');
	}

	public function test_mail($email){
		$this->email->to($email);
		$this->email->subject('Testing email');
		$this->email->message('Email service is working properly');
		$this->email->send();
	}
	
	public function list_user_credentials(){
		$students = $this->db->order_by('user_id','DESC')->get('am_users')->result();
		$html = '<table><tr><th>Name</th><th>Username</th><th>Password</th><th>Role</th></tr>';
		$this->load->model('Auth_model');
		foreach($students as $row){
			$html .= '<tr><td>'.$row->user_name.'</td><td>'.$row->user_username.'</td><td>'.$this->Auth_model->get_pass($row->user_passwordhash).'</td><td>'.$row->user_role.'</td></tr>';
		}
		$html .= '</table>';
		echo $html;
	}

	public function list_student_credentials(){
		$students = $this->db->select('am_users.*,am_batch_center_mapping.batch_name,am_students.email')->from('am_users')
          								->join('am_students','am_students.student_id=am_users.user_primary_id')
          								->join('am_student_course_mapping','am_student_course_mapping.student_id=am_students.student_id')
          								->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_student_course_mapping.batch_id')
          								->where("am_users.user_role","student")
          								->where("am_users.user_status",1)
          								->where("am_students.verified_status",1)
          								->where("am_student_course_mapping.status",1)
          								->order_by('am_batch_center_mapping.batch_id','ASC')
          								->order_by('am_users.user_name','ASC')
          								->get()->result();
		$html = '<table><tr><th>Batch Name</th><th>Student name</th><th>Email</th><th>Student username</th><th>Password</th></tr>';
		$this->load->model('Auth_model');
		foreach($students as $row){
			$html .= '<tr><td>'.$row->batch_name.'</td><td>'.$row->user_name.'</td><td>'.$row->email.'</td><td>'.$row->user_username.'</td><td>'.$this->Auth_model->get_pass($row->user_passwordhash).'</td></tr>';
		}
		$html .= '</table>';
		echo $html;
	}
	
	public function list_student_credentials_pass(){
		$students = $this->db->select('am_users.*')->from('am_users')
								->join('am_students','am_students.student_id=am_users.user_primary_id')
								->where(["user_role"=>"student","verified_status"=>1,"status"=>1])
								->order_by('student_id','ASC')
								->get()->result();
		$html = '<table><tr><th>Student username</th><th>Password</th></tr>';
		$this->load->model('Auth_model');
		foreach($students as $row){
			$html .= '<tr><td>'.$row->user_username.'</td><td>'.$this->Auth_model->get_pass($row->user_passwordhash).'</td></tr>';
		}
		$html .= '</table>';
		echo $html;
	}
	
	public function list_student_credentials_ver(){
		$students = $this->db->select('gm_user.*')->from('gm_user')
								->join('am_students','am_students.student_id=gm_user.id')
								->where(["verified_status"=>1,"am_students.status"=>1])
								->order_by('am_students.student_id','ASC')
								->get()->result();
		$html = '<table><tr><th>Student username</th><th>Password</th><th>Version</th></tr>';
		$this->load->model('Auth_model');
		foreach($students as $row){
			$html .= '<tr><td>'.$row->user_name.'</td><td>'.$row->password.'</td><td>'.$row->version.'</td></tr>';
		}
		$html .= '</table>';
		echo $html;
	}

	public function list_staff_credentials(){
		$users = $this->db->where("user_role !=","admin")->order_by('user_role')->get('am_users_backoffice')->result();
		$html = '<table><tr><th>Role</th><th>Name</th><th>Username</th><th>Password</th></tr>';
		$this->load->model('Auth_model');
		foreach($users as $row){
			$html .= '<tr><td>'.$row->user_role.'</td><td>'.$row->user_name.'</td><td>'.$row->user_username.'</td><td>'.$this->Auth_model->get_pass($row->user_passwordhash).'</td></tr>';
		}
		$html .= '</table>';
		echo $html;
	}

	function send_sms($mob_number,$message){
		send_sms($mob_number,$message);
	}

	function send_students_email(){
		$students = $this->db->select('am_users.*')->from('am_users')
          							->join('am_students','am_students.student_id=am_users.user_primary_id')
          							->join('am_student_course_mapping','am_student_course_mapping.student_id=am_students.student_id')
          							->where("am_users.user_role","student")
          							->where("am_users.user_status",1)
          							->where("am_students.verified_status",1)
          							->where("am_student_course_mapping.status",1)
          							->order_by('am_users.user_id','DESC')
									->get()->result();
		$this->load->model('Auth_model');
		foreach($students as $row){
			$emaildata = email_header();
			$emaildata.='<tr style="background:#f2f2f2">
					<td style="padding: 20px 0px">
						<h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$row->user_name.'</h3>
						<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">An account has been created for you on Direction application, Now you can login to our website application using following credential.</p>
						<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$row->user_username.'</p>
						<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$this->Auth_model->get_pass($row->user_passwordhash).'</p>
						<br><a href="'.base_url('login').'">Click here to login</a> and view your Course details and schedule details
						</p>
					</td>
				</tr>';
			$emaildata.=email_footer();
			$jobdata['from']    = 'noreply@direction.org.in';
			$jobdata['to']      = $row->user_emailid;
			$jobdata['subject'] = 'Login credentials for login to Direction application';
			$jobdata['message'] = $emaildata;
			$count = $this->db->where('to',$jobdata['to'])->get('emails')->num_rows();
			if($count==0){
				$this->db->insert('emails', $jobdata);
			}
		}
	}
}
