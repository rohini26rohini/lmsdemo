<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Direction_Controller {
	
    public function index(){
        if(NULL !== $this->session->userdata('logedin') && $this->session->userdata('logedin')) {
			if($this->session->userdata('backoffice_user')){
				redirect(base_url('backoffice'));
			}else{
				if($this->session->userdata('role')=='users'){
					redirect(base_url('pay-fee'));
				} else if($this->session->userdata('role')=='student'){
                   redirect(base_url('student-dashboard'));
                } else if($this->session->userdata('role')=='parent'){
                   redirect(base_url('parent'));
                }
			}
		}else{
			$this->data['viewload'] = 'admin/login';
		}
		$this->load->view('_layouts_new/_master', $this->data);
	}
    
    public function authenticate(){ 
		if($this->security->xss_clean($_POST)){
			$username=trim($this->security->xss_clean($this->input->post('username')));
			$password=trim($this->security->xss_clean($this->input->post('password')));
			if($username!='' && $password!='') {
				// if($this->check_captcha($username,$password)){
					$data = array();
					$data['user_username'] = $username;
					$this->load->model('Auth_model');
					if($this->Auth_model->user_authenticate($data) == TRUE) {
					
						$this->Auth_model->reset_attempt($username);
						
						$returnData['st'] = 1;
						$url = $this->session->userdata('url');
						// LOG ENTRY
						$what = 'Login success';
						$table_row_id = 0;
						$who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
						logcreator('Login', 'Login successfully', $who, $what, $table_row_id, 'login');
						// LOG ENTRY ENDS
						if(!empty($url)){
							// $returnData['url'] = $url;
							$returnData['url'] = base_url('backoffice');
						}else{
							$returnData['url'] = base_url('backoffice');
						}
						$returnData['message'] 	= 'Please wait taking you to dashboard.';
					} else {
						$this->Auth_model->add_attempt($username);
						
						$returnData['st'] 		= 0;
						$returnData['message'] 	= 'Wrong credentials. Please try again.';
						$returnData['username'] = $username;
						// LOG ENTRY
						$what = 'Login failed';
						$table_row_id = 0;
						$who = $username.'/';
						logcreator('Login', 'Login failed', $who, $what, $table_row_id, 'login');
						// LOG ENTRY ENDS
					}
				// }else{

				// }
			}else{
				$returnData['st'] 		= 0;
				$returnData['message'] 	= 'Please enter a valid Username and Password.';
				$returnData['username'] = $username;
			}
		}else{
			redirect(base_url('backoffice'));
		}
		print_r(json_encode($returnData));
    }

    public function logout(){
		// LOG ENTRY
		$what = 'logout success';
		$table_row_id = 0;
		$who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
		logcreator('Logout', 'Logout successfully', $who, $what, $table_row_id, 'login');
		// LOG ENTRY ENDS
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
    
	private function check_captcha($username,$password){
		$attempt = $this->Auth_model->check_attempt($username);
		if($attempt){
			$captcha_status = 0;
			if($attempt<CAPTCHA_ATTEMPT){
				$this->Auth_model->add_attempt($username);
				$captcha_status = 1;
			}
			if($attempt==CAPTCHA_ATTEMPT){
				$this->data['captcha'] = $this->new_captcha();
				$this->data['password'] = $password;
				$this->data['username'] = $username;
				$this->Auth_model->add_attempt($username);
			}
			if($attempt>CAPTCHA_ATTEMPT){
				$captcha = $this->input->post('captcha');
				if($captcha==''){
					$this->data['captcha'] = $this->new_captcha();
					$this->data['password'] = $password;
					$this->data['username'] = $username;
				}else{
					$expiration = time() - 7200; // Two hour limit
					$this->db->where('captcha_time < ', $expiration)->delete('captcha');
					$captcha = strtoupper($captcha);
					$image_name = $this->input->post('captcha_img_name');
					$status = $this->db->where('image_name',$image_name)->get('captcha')->row_array();
					if($status['word']==$captcha){$captcha_status=1;}else{
						$this->data['password'] = $password;
						$this->data['username'] = $username;
						$this->data['captcha'] = $this->new_captcha();
						$this->data['captcha_error'] = "Wrong text entered, please try again";
					}
				}
			}
		}else{
			$captcha_status = 1;
		}
		return $captcha_status;
	}

	private function new_captcha(){
		$this->load->helper('captcha');
		$vals = array(
			'word'          => '',
			'img_path'      => './captcha/',
			'img_url'       => base_url('captcha/'),
			'font_path'     => './assets/fonts/bold.ttf',
			'img_width'     => '200',
			'img_height'    => 60,
			'expiration'    => 7200,
			'word_length'   => 5,
			'font_size'     => 20,
			'img_id'        => 'Imageid',
			'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',/*abcdefghijklmnopqrstuvwxyz*/
	
			// White background and border, black text and red grid
			'colors'        => array(
					'background' => array(33, 94, 191, 1),
					'border' => array(255, 255, 255),
					'text' => array(255, 255, 255),
					'grid' => array(255, 255, 255) //array(255, 40, 40)
			)
		);
		$cap = create_captcha($vals);
		$data = array(
			'captcha_time'  => $cap['time'],
			'ip_address'    => $this->input->ip_address(),
			'word'          => $cap['word'],
			'image_name'    => $cap['filename']
		);
		$expiration = time() - 7200; // Two hour limit
		$this->db->where('captcha_time < ', $expiration)->delete('captcha');
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		return $cap;
	}


	public function forgot_password()
    {
        if($this->security->xss_clean($_POST)){
			$email_id=trim($this->security->xss_clean($this->input->post('email')));
			$exist = $this->common->get_from_tablerow('am_users', array('user_emailid'=>$email_id));
			$existback = $this->common->get_from_tablerow('am_users_backoffice', array('user_emailid'=>$email_id));
			$response = '';
			if(empty($exist) && empty($existback)) {
				$returnData['st'] 		= 0;
                $returnData['message'] 	= 'Given email does not exist. Please contact administrator';
			} else {
				$password =mt_rand(100000,999999);
				$encrypted_password= $this->Auth_model->get_hash($password);
				if(!empty($exist)) {
					$students = $this->common->get_from_tablerow('am_students', array('email'=>$email_id)); //print_r($students);
					if(!empty($students)) {
					$dataArr            = array(
						'user_passwordhash'=>$encrypted_password
					   );
						$this->db->where('user_primary_id', $students['student_id']);
						$this->db->update('am_users',$dataArr);
						$this->gm_user_registration($students['registration_number'], $password, $students['student_id']);
					    $response =1;
					} else {
						$returnData['st'] 		= 0;
                		$returnData['message'] 	= 'Failed to reset password, Please contact administrator.';	
					}
				} else if(!empty($existback)){
						$dataArr            = array(
						'user_passwordhash'=>$encrypted_password
					   );
						$this->db->where('user_emailid', $email_id);
						$this->db->update('am_users_backoffice',$dataArr);
						$response = 1;
				} else {
					$returnData['st'] 		= 0;
                	$returnData['message'] 	= 'Given email does not exist. Please contact administrator';
				}
			}
            //$response=$this->Auth_model->forgot_password($email_id,$encrypted_password,$table);
            if($response !="")
            {
                
                
            $data=forgot_password_Email_header();
            $data.='<td style="padding: 26px 26px">
				<h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
				<p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
					Hello, <span><b>'.$response.'</b></span><br> 
                    someone requested to reset the password for this account.<br>
					If it was a mistake, just ignore this email.<br>
					
				</p>
					

					<p  style="font-family: Open Sans, sans-serif;font-size: 13px;line-height: 20px;background: rgba(43, 43, 43, 0.71);color: #fff;display: block;padding: 10px 20px;margin: 0px;">
						<b>Your New Password is  : </b>'.$password.'<br/>
						
					</p>
			</td>';
             $data.=forgot_password_Email_footer();
              
                $this->send_email("Reset Password", $email_id,$data);
                $returnData['st'] 		= 1;
                $returnData['message'] 	= 'Success! Please Check your Email id for new password.';
            }
            else
            {
                $returnData['st'] 		= 0;
                $returnData['message'] 	= 'Error Occured, Please contact administrator.';
            }
            print_r(json_encode($returnData));
        }
    }
    
    // public function forgot_password()
    // {
    //     if($this->security->xss_clean($_POST)){
	// 		$email_id=trim($this->security->xss_clean($this->input->post('email')));
    //         $password =mt_rand(100000,999999);
    //         $encrypted_password= $this->Auth_model->get_hash($password);
    //         $exist=$this->common->check_if_dataExist('am_users',array("user_emailid"=>$email_id));
    //         if($exist == 0)
    //         {
    //            $table="am_users_backoffice";  
    //         }
    //         else
    //         {
    //            $table="am_users"; 
    //         }
    //         $response=$this->Auth_model->forgot_password($email_id,$encrypted_password,$table);
    //         if($response !="")
    //         {
                
                
    //         $data=forgot_password_Email_header();
    //         $data.='<td style="padding: 26px 26px">
	// 			<h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
	// 			<p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
	// 				Hello, <span><b>'.$response.'</b></span><br> 
    //                 someone requested to reset the password for this account.<br>
	// 				If it was a mistake, just ignore this email.<br>
					
	// 			</p>
					

	// 				<p  style="font-family: Open Sans, sans-serif;font-size: 13px;line-height: 20px;background: rgba(43, 43, 43, 0.71);color: #fff;display: block;padding: 10px 20px;margin: 0px;">
	// 					<b>Your New Password is  : </b>'.$password.'<br/>
						
	// 				</p>
	// 		</td>';
    //          $data.=forgot_password_Email_footer();
              
    //             $this->send_email("Reset Password", $email_id,$data);
    //             $returnData['st'] 		= 1;
    //             $returnData['message'] 	= 'Success..!Please Check your Email id for new password.';
    //         }
    //         else
    //         {
    //             $returnData['st'] 		= 0;
    //             $returnData['message'] 	= 'Error Occured..!Please Try again later.';
    //         }
    //         print_r(json_encode($returnData));
    //     }
	// }
	
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
		$data['role']['id'] 		= 2;  
		$jsonData['access_token'] = $ajaxResponse->access_token; 
		$jsonData['method']       = "createOrUpdateUser";
		$jsonData['type']         = "POST"; 
		$jsonData['data']         = json_encode($data); 
		$ajaxResponse = json_decode($this->common->rest_api_call($jsonData));    
	  }


   //check the 
    public function emailCheck()
    {
		
        $email=$this->input->post('email'); 
		$query= $this->db->get_where('am_users',array("user_emailid"=>$email,"user_status"=>1));
       
        if($query->num_rows() > 0){
           echo 'true';
        }
        else
        {
            $sql= $this->db->get_where('am_users_backoffice',array("user_emailid"=>$email,"user_status"=>1));
            if($sql->num_rows() > 0)
            {
               echo 'true';
            }
            else
            {
                echo 'false';  
            }
          
        }
    }
    
    function send_email($type, $email, &$data) {
        $this->email->to($email);
        $this->email->subject($type);
        $this->email->message($data);
        $this->email->send();
     }
}
?>