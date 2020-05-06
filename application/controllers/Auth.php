<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
    }
    
    public function Login(){
        if(NULL !== $this->session->userdata('logedin') && $this->session->userdata('logedin')) {
            redirect(base_url());
        } else {
			if($this->security->xss_clean($_POST)){
				$username=trim($this->security->xss_clean($this->input->post('username')));
				$password=trim($this->security->xss_clean($this->input->post('password')));
				if($username!='' && $password!='') {
					if($this->check_captcha($username,$password)){
						$data = array();
						$data['user_emailid'] = $username;
						$data['user_status'] = 1;
						if($this->Auth_model->login($data) == TRUE) {
							$this->Auth_model->reset_attempt($username);
							$returnData['st'] 		= 1;
							$returnData['message'] 	= '<p class="alert alert-success" style="padding:15px;">User successfully login.</p>';
						} else {
							$this->Auth_model->add_attempt($username);
							$returnData['st'] 		= 0;
							$returnData['message'] 	= '<p class="alert alert-danger" style="padding:15px;">Username or Password didnot match. Please try again.</p>';
							$returnData['username'] = $username;
						}
					}
				}else{
					$returnData['st'] 		= 0;
					$returnData['message'] 	= '<p class="alert alert-danger" style="padding:15px;">Please enter a valid Username and Password.</p>';
					$returnData['username'] = $username;
				}
				print_r(json_encode($returnData));
				exit;
			}
            $this->data['page']="home/login";
            $this->load->view('auth/login',$this->data); 
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
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
    
}
?>