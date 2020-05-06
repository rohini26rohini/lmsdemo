<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('auth');
    }
    
    public function user_authenticate($data) {
        $user = $this->db->get_where('am_users', $data)->row(); 
        if(empty($user)) {
			$data['user_status'] = 1;
            return $this->backoffice_authenticate($data);
        } else {
            if($user->user_username===$data['user_username'] && $user->user_status==1){
                if(strcmp($this->input->post('password'),get_text($user->user_passwordhash))){
                    $array['permition'] = 'no';
                } else {
                    $array['permition'] = 'yes';
                }
            } else {
                $array['permition'] = 'no';
            }
        }

        if($array['permition'] == 'yes') {
            $p = $this->db->select('module')->where('role',$user->user_role)->get('am_role_module_permission')->result_array();
            $permission = array();
            if(!empty($p)){
                foreach($p as $k=>$v){
                    $permission[$k] = $v['module'];
                }
            }
            $data = array(
                "user_primary_id" => $user->user_id,
                "user_id" => $user->user_primary_id,
                "name" => $user->user_name,
                "username" => $user->user_username,
                "email" => $user->user_emailid,
                "role" => $user->user_role,
                "permission" => $permission,
                "backoffice_user" => FALSE,
                "logedin" => TRUE
            );

            $this->session->set_userdata($data);
            return TRUE;
        } else {
            return FALSE;
        }	
    }
    
    public function backoffice_authenticate($data) {
        $user = $this->db->get_where('am_users_backoffice', $data)->row();
        if(empty($user)) {
            $array['permition'] = 'no';
        } else {
            if($user->user_username===$data['user_username']){
                if(strcmp($this->input->post('password'),get_text($user->user_passwordhash))){
                    $array['permition'] = 'no';
                } else {
                    $array['permition'] = 'yes';
                }
            } else {
                $array['permition'] = 'no';
            }
        }

        if($array['permition'] == 'yes') {
            $staff['personal_id'] = '';
            $staff['center'] ='';
            $staff = $this->db->get_where('am_staff_personal', array('user_id'=>$user->user_id))->row_array();
            $p = $this->db->select('module')->where('role',$user->user_role)->get('am_role_module_permission')->result_array();
            $permission = array();
            if(!empty($p)){
                foreach($p as $k=>$v){
                    $permission[$k] = $v['module'];
                }
            }
            $data = array(
                "user_id" => $staff['personal_id'],
                "user_primary_id" => $user->user_id,
                "center" => $staff['center'],
                "name" => $user->user_name,
                "username" => $user->user_username,
                "email" => $user->user_emailid,
                "role" => $user->user_role,
                "permission" => $permission,
                "backoffice_user" => TRUE,
                "logedin" => TRUE
            );

            $this->session->set_userdata($data);
            return TRUE;
        } else {
            return FALSE;
        }	
    }

    public function check_attempt($username){
        $attempt = $this->db->where('username',$username)->get('am_login_attempts')->row_array();
        return $attempt['attempt'];
    }

    public function add_attempt($username){
        $direction_login_attempts = $this->db->where('username',$username)->order_by('id','DESC')->get('am_login_attempts')->row_array();
        if(empty($direction_login_attempts)){
            $data = array(
                'username' => $username,
                'attempt' => 1
            );
            $this->db->insert('am_login_attempts',$data);
        }else{
            $data['attempt'] = $direction_login_attempts['attempt']+1;
            $this->db->where('username',$username)->update('am_login_attempts',$data);
        }
    }

    public function reset_attempt($username){
        $this->db->where('username',$username)->delete('am_login_attempts');
    }
    
    public function get_hash($data)
    {
       return get_hash($data);
    }
    
    public function forgot_password($email_id,$new_password,$table)
    {
         $this->db->where('user_emailid', $email_id);
         $query=$this->db->update($table,array("user_passwordhash"=>$new_password));
        if($query)
        {
            $sql=$this->db->get_where($table,array("user_emailid"=>$email_id));
            return $sql->row()->user_name;
        }
        else
        {   $sql="";
            return $sql;
        }
    }

    function absent_alert($email = '' , $msg = '')
	{
			$heading	=	"Leave Request";
			$email_sub	=	"Leave Request";
			$email_to	=	$email;
			$this->do_email($msg , $email_sub , $email_to, $heading);
			return true;
		
    }
    
    public function get_user_password(){
        if($this->session->userdata('logedin')){
            $data['user_id'] = $this->session->userdata('backoffice_user');
            if($this->session->userdata('backoffice_user')){
                $pass_hash = $this->db->get_where('am_users_backoffice', $data)->row()->user_passwordhash;
            }else{
                $pass_hash = $this->db->get_where('am_users', $data)->row()->user_passwordhash;
            }
            return get_text($pass_hash);
        }else{
            return FALSE;
        }
    }
	
	
    
    public function get_pass($hash){
		return get_text($hash);
    }
	
	
}
