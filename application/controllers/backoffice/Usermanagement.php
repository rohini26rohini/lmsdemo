<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermanagement extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        $module="usermanagement";
        check_backoffice_permission($module);
        $this->load->model('auth_model');
    }
    
    public function index(){
      $this->data['users'] = $this->user_model->get_users();
       //echo '<pre>';print_r($this->data['users']);exit;
      $this->data['page']="admin/user";
      $this->data['menu']="usermanagement";
      $this->data['breadcrumb']="User management / Users";
      $this->data['menu_item']="users";
      $this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function roles(){
      $this->data['users'] = $this->user_model->get_users();
      // echo '<pre>';print_r($this->data['users']);exit;
      $this->data['page']="admin/roles";
      $this->data['menu']="usermanagement";
      $this->data['breadcrumb']="User management";
      $this->data['menu_item']="role";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function permission(){
      $this->data['roles'] = $this->common->get_alldata('am_roles',array("role_status"=>"1"));
      $this->data['page']="admin/permission";
      $this->data['menu']="usermanagement";
      $this->data['breadcrumb']="User management / Permission";
      $this->data['menu_item']="permissions";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }
    public function define_permission($id)
    {

        $main_modules = $this->common->get_alldata('am_backoffice_modules',array("parent_module_id"=>"0"));
        $sub_moduleArr=array();
        foreach($main_modules as $modules)
        {
          $sub_modules=$this->common->get_alldata('am_backoffice_modules',array("parent_module_id"=>$modules['backoffice_modules_id'])); 
            if(!empty($sub_modules))
            {
                foreach($sub_modules as $key=>$row)
                {
                   
                   $sub_moduleArr[$modules['backoffice_modules_id']][]=$row['backoffice_modules_id']; 
                }
            }
             else
            {
              $sub_moduleArr[$modules['backoffice_modules_id']]=array(); 
            }
        }
       $this->data['modules']=$sub_moduleArr; 
       $this->data['page']="admin/define_permission";
       $this->data['menu']="usermanagement";
       $this->data['breadcrumb']="User management / Permission";
       $this->data['menu_item']="permissions";
       $this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function add_permission()
    {
       // print_r($_POST);
        if($_POST)
        {
            $role=$this->input->post('role');
            $module=$this->input->post('module');
            $data=array();

             $exist=$this->common->check_if_dataExist('am_role_module_permission',array("role"=>$role));
            if($exist > 0)
            {
             //delete
                $response=$this->common->delete('am_role_module_permission', array("role"=>$role));
                if($response == 1)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully Added Permission";
                    $what = json_encode($_POST);
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Successfully Added Permission', $who, $what, 0, 'am_role_module_permission', 'Module permission updated');
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later...!";
                    $what = json_encode($_POST);
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'updating Permission', $who, $what, 0, 'am_role_module_permission', 'Module permission updation failed');
                }

            }
            if(!empty($module))
            {
              foreach($module as $key=>$row)
                {
                    $data[$key]=array(
                            "role"=>$role,
                            "module"=>$row
                        );
                }
                $response=$this->user_model->add_permission($data);
                if($response == 1)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully Added Permission";
                    $what = json_encode($_POST);
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Successfully Added Permission', $who, $what, 0, 'am_role_module_permission', 'Module permission updated');
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later...!";
                    $what = json_encode($_POST);
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'updating Permission', $who, $what, 0, 'am_role_module_permission', 'Module permission updation failed');
                }
            }

           // print_r($data);

        }
        else
        {
          $ajax_response['st']=0;
        $ajax_response['msg']="Something went wrong,Please try again later...!";
        }
        print_r(json_encode($ajax_response));
    }
    /*This function will change the status of user
    @params id,status
    @auther GBS-L*/
    public function change_user_status()
    {
        if($_POST)
        {
           $id=$this->input->post('id'); 
           $status=$this->input->post('status'); 
            if($status == 0){ $status=1;}
            else{ $status=0;}
           
            $response=$this->Common_model->update('am_users_backoffice', array("user_status"=>$status),array("user_id"=>$id));
            if($response)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully Updated";
                $what = json_encode($_POST);
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, 'User status', 'am_users_backoffice', 'User status changed');
            }
            else
            {
               $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,please try again later..!"; 
                $what = json_encode($_POST);
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, 'User status', 'am_users_backoffice', 'User status changing failed');
            }
        }
        else
        {
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,please try again later..!"; 
                $what = json_encode($_POST);
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, 'User status', 'am_users_backoffice', 'User status changing failed');
        }
        print_r(json_encode($ajax_response));
    }
    /*This function load the details of user by ajax
    @params 
    @auther GBS-L*/
    public function load_users_ajax()
    {
        $html = '<thead><tr>
                <th>'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('name').'</th>
                <th>'.$this->lang->line('role').'</th>
                <th>'.$this->lang->line('username').'</th>
                <th>'.$this->lang->line('action').'</th>
            </tr></thead>';
        $users = $this->user_model->get_users();
        if(!empty($users)) {
            $i=1;
            foreach($users as $row) {
                // $status = '<span class="btn mybutton mybuttonActive"  data-toggle="modal" data-target="#resetpassword"  onclick="resetpassword_status('.$row['user_id'].');">'.$this->lang->line("reset").'</span>&nbsp;';
                $status = '<a class="btn mybutton mybuttonActive"  onclick="resendpassword_status('.$row['user_id'].',\''.$row['user_username'].'\');">Resend Password</a>';
                if($row['user_status'] == 1)
                {
                    $status .= '<span class="btn mybutton mybuttonActive" onclick="edit_status('. $row['user_id'].','.$row['user_status'].');">Ban User</span>';
                }
                else
                {
                    $status .= '<span class="btn mybutton mybuttonInactive" onclick="edit_status('. $row['user_id'].','.$row['user_status'].');">Activate User</span>';
                }
              
              $html .= '<tr>
                <td>'.$i.'</td>
                <td>'.$row['user_name'].'</td>
                <td>'.$row['user_role'].'</td>
                <td>'.$row['user_username'].'</td>
                <td>'.$status.'</td>
                
            </tr>'; 
                $i++;
        }
    }
    echo $html;
    }
  /*
   This function load the details of Features by ajax
    @params 
    @auther GBS-L
    */
    public function features()
    {
        $main_modules = $this->common->get_alldata('am_backoffice_modules',array("parent_module_id"=>"0"));
        $sub_moduleArr=array();
        foreach($main_modules as $modules)
        {  
             $sub_modules=$this->common->get_alldata('am_backoffice_modules',array("parent_module_id"=>$modules['backoffice_modules_id'])); 
          
            if(!empty($sub_modules))
            {
                foreach($sub_modules as $key=>$row)
                {
                   
                   $sub_moduleArr[$modules['backoffice_modules_id']][]=$row['backoffice_modules_id']; 
                }
            }
            else
            {
              $sub_moduleArr[$modules['backoffice_modules_id']]=array(); 
            }
        } 
       $this->data['modules']=$sub_moduleArr; 
       $this->data['main_modules']=$main_modules; 
       $this->data['page']="admin/features";
       $this->data['menu']="usermanagement";
       $this->data['breadcrumb']="User management / Features";
       $this->data['menu_item']="features";
       $this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function all_module_action()
    {
        // print_r($_POST);
        if($_POST)
        {
            //print_r($_POST);
            $status=$this->input->post('status');
           $response=$this->Common_model->update('am_backoffice_modules', array("status"=>$status) ,array("module !="=>"usermanagement"));
            if($response)
            {
                $check=$this->common->check_if_dataExist('am_backoffice_modules',array("status"=>"0"));
               if($status == 0)
               {
                   $ajax_response['status']="false";//uncheck
               }
                else
                {
                   $ajax_response['status']="true";//check
                }
                $ajax_response['check']=$check;
            }
            else
            {
                $ajax_response['status']="error";
            }
        }
        else
        {
           $ajax_response['status']="error";
        }
        print_r(json_encode($ajax_response));
    }

    public function main_module_action()
    {
        if($_POST)
        {
           // print_r($_POST);
            $status=$this->input->post('status');
            $parent_module_id=$this->input->post('parent_module_id');
            $Module_id=$this->input->post('backoffice_modules_id');
            $response=$this->Common_model->update('am_backoffice_modules', array("status"=>$status) ,array("backoffice_modules_id"=>$Module_id));
            if($response)
            {
               $res=$this->Common_model->update('am_backoffice_modules', array("status"=>$status) ,array("parent_module_id"=>$parent_module_id));
                if($res)
                {
                    $check=$this->common->check_if_dataExist('am_backoffice_modules',array("status"=>"0"));
                   if($status == 0)
                    {
                        $ajax_response['status']="false";//uncheck
                    }
                    else
                    {
                        $ajax_response['status']="true";//check
                    }
                    $ajax_response['check']=$check;
                }
                 else
                {
                    $ajax_response['status']="error";
                }
            }
            else
            {
              $ajax_response['status']="error";
            }
        }
        else
            {
              $ajax_response['status']="error";
            }
        print_r(json_encode($ajax_response));
    }

    public function sub_module_action()
    {
       if($_POST)
        {
           // print_r($_POST);
            $parent_id=$this->input->post('parent_id');
            $status=$this->input->post('status');
            $Module_id=$this->input->post('backoffice_modules_id');
            $response=$this->Common_model->update('am_backoffice_modules', array("status"=>$status) ,array("backoffice_modules_id"=>$Module_id));
            if($response)
            {   if($status == 1)
                {
                   $this->Common_model->update('am_backoffice_modules', array("status"=>$status) ,array("backoffice_modules_id"=>$parent_id)); 
                }
                
                    $check=$this->common->check_if_dataExist('am_backoffice_modules',array("status"=>"0"));
                   if($status == 0)
                    {
                        $ajax_response['status']="false";//uncheck
                    }
                    else
                    {
                        $ajax_response['status']="true";//check
                    }
                 $ajax_response['check']=$check;
            }
            else
            {
              $ajax_response['status']="error";
            }
        }
        else
            {
              $ajax_response['status']="error";
            }
        print_r(json_encode($ajax_response));
    }


function reset_password() {
    $id = $this->input->post('id');
    if($id!='') { 
        $staff = $this->common->get_from_tablerow('am_users_backoffice', array('user_id'=>$id));
        if(!empty($staff)) { 
            $user_id = $staff['user_id'];    
            $this->load->model('Auth_model');
            $password =mt_rand(100000,999999);
            $encrypted_password= $this->Auth_model->get_hash($password);
            $dataArr = array(
                            'user_passwordhash'=>$encrypted_password
                        );
            $this->db->where('user_id', $user_id); 
            $this->db->update('am_users_backoffice', $dataArr);           
            $data['st']         = 1;
            $data['message']    = 'Password reset successfully.';
            $data['data']       = $password;
            $what = $password;
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, 'User reset password', 'am_users_backoffice', 'User reset password');
        } else {
            $data['st']         = 0;
            $data['message']    = 'User does not exist.';
            $data['data']       = $id; 
            $what = $password;
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, 'User reset password', 'am_users_backoffice', 'User reset password failed, User does not exist.');
        }
    } else {
        $data['st']         = 0;
        $data['message']    = 'Error while updating password.';
        $data['data']       = $id;
        $what = $password;
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        logcreator('update', 'database', $who, $what, 'User reset password', 'am_users_backoffice', 'User reset password failed');
    }
    print_r(json_encode($data));
}

function resend_password() {
    // show($_POST);
    $id = $this->input->post('id');
    $email = $this->input->post('email');
    if($id!='') { 
        $staff = $this->common->get_from_tablerow('am_users_backoffice', array('user_id'=>$id));
        if(!empty($staff)) { 
            $user_id = $staff['user_id'];    
            $this->load->model('Auth_model');
            $password =mt_rand(100000,999999);
            $encrypted_password= $this->Auth_model->get_hash($password);
            $dataArr = array(
                            'user_passwordhash'=>$encrypted_password
                        );
            $this->db->where('user_id', $user_id); 
            $this->db->update('am_users_backoffice', $dataArr);    
            
            $emailData=email_header();
            $emailData.='<td style="padding: 26px 26px">
				<h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
				<p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
					Hello,<br> 
                    Someone requested to reset the password for this account.<br>
					If it was a mistake, just ignore this email.<br>
					
				</p>
				<p  style="font-family: Open Sans, sans-serif;font-size: 13px;line-height: 20px;background: rgba(43, 43, 43, 0.71);color: #fff;display: block;padding: 10px 20px;margin: 0px;">
					<b>Your New Password is  : </b>'.$password.'<br/>
					
				</p>
			</td>';
            $emailData.=email_footer();

            $sendSt = $this->send_email("Reset Password", $email,$emailData);
            $jobdata['from']    = 'noreply@direction.com';
            $jobdata['to']      = $email;
            $jobdata['subject'] = 'Reset Password';
            $jobdata['message'] = $emailData;
            $jobdata['status'] = $sendSt;
            $this->db->insert('emails', $jobdata);

            $data['st']         = 1;
            $data['message']    = 'Password reset successfully, Please inform to check registered email for new password';
            $data['data']       = $password;
            $what = json_encode($jobdata);
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, 'User resend password', 'am_users_backoffice', 'User resend password function triggered.');
        } else {
            $data['st']         = 0;
            $data['message']    = 'User does not exist.';
            $data['data']       = $id; 
        }
    } else {
        $data['st']         = 0;
        $data['message']    = 'Error while updating password.';
        $data['data']       = $id;
    }
    print_r(json_encode($data));
}

public function admin_change_password() {
        $this->data['users'] = $this->user_model->get_users();
      // echo '<pre>';print_r($this->data['users']);exit;
      $this->data['page']="admin/admin_change_password";
      $this->data['menu']="usermanagement";
      $this->data['breadcrumb']="User management / Change password";
      $this->data['menu_item']="changepassword";
      $this->load->view('admin/layouts/_master.php',$this->data);
}

function send_email($type, $email, $data) {
    $this->email->to($email);
    $this->email->subject($type);
    $this->email->message($data);
    $this->email->send();
}

}
?>
