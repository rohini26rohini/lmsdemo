<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        // $module="employee";
        // check_backoffice_permission($module);
        $this->load->model('leave_model');


    }
//--------------------------------------- Manage Leave -----------------------------------------------//

    public function index()
    {
        
		$this->data['page']         = "admin/leave";
        $this->data['menu']         = "employee";
        $this->data['breadcrumb']   = "Leave Request";
        $this->data['menu_item']    = "backoffice/manage-leave";
        $this->data['leaveArr']     = $this->leave_model->get_leave_list($this->session->userdata('user_id'));
        $this->data['typeArr']      = $this->leave_model->get_type();
        $this->data['staff_id']     = $this->leave_model->get_staff_id($this->session->userdata('user_id'));
		$this->load->view('admin/layouts/_master',$this->data); 
    }

    
    public function leave_add()
    {
        if($_POST){
         
            $data = $_POST;
            // print_r($_POST); die();
            $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
            $end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
            $date1 = new DateTime($start_date);
            $date2 = new DateTime($end_date);
            $data['num_days']  = ($date2->diff($date1)->format('%a')) + 1;
            // show($data);
            $user_id=$this->input->post('user_id');
                $data['start_date']=$start_date;
                $data['end_date']=$end_date;
                $res = $this->leave_model->leave_add($data);
                if($res)
                {
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New leave head added', $who, $what, $table_row_id, 'am_leave_request');
                    $ajax_response['st']=1;
                            
                }
                else
                {
                     $ajax_response['st']=0;
                }
           // }
           // else{
           //     $ajax_response['st']=2;//already exist
           // }
            
        }
        else
        {
             $ajax_response['st']=0;
        }
        print_r(json_encode($ajax_response));
    }
    public function duplicate_leave_start_back($start_date,$user_id)
    {
        $start_date=date('Y-m-d',strtotime($start_date));
         $exist=$this->Leave_model->duplicate_leave($start_date,$user_id);
       // echo $this->db->last_query();
        //echo "<br>".$exist;
        if($exist >= 1)
        {
            return false;
        }
        
        else
        {
            return true;
        }
        
    }
    public function duplicate_leave_end_back($end_date,$user_id)
    {
         $start_date=date('Y-m-d',strtotime($end_date));
         $exist=$this->Leave_model->duplicate_leave($start_date,$user_id);
       // echo $this->db->last_query();
        //echo "<br>".$exist;
        if($exist >= 1)
        {
            return false;
        }
        
        else
        {
            return true;
        }
        
    }
    public function leave_edit()
    {
        if($_POST){
            $id = $this->input->post('leave_id');
            unset($_POST['leave_id']);
            $data = $_POST;
            $data['start_date']=date('Y-m-d',strtotime($this->input->post('start_date')));
            $data['end_date']=date('Y-m-d',strtotime($this->input->post('end_date')));
            $date1 = new DateTime($data['start_date']);
            $date2 = new DateTime($data['end_date']);
            $data['num_days']  = ($date2->diff($date1)->format('%a')) + 1;
            // show($data);
            $res = $this->leave_model->leave_edit($data, $id);
            if($res){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Leave head edited', $who, $what, $id, 'am_leave_request');
                $ajax_response['st']=1;
            }
            else
            {
                 $ajax_response['st']=0;
            }
            
        }
        else
            {
                 $ajax_response['st']=0;
            }
        print_r(json_encode($ajax_response));
    }

    public function leave_delete()
    {
        $id  = $_POST['id'];
        $res = $this->leave_model->leave_delete($id);
        if($res){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Leave head deleted', $who, $what, $id, 'am_leave_request');
            $ajax_response['st']=1;
        }
        else
        {
             $ajax_response['st']=0;
        }
        print_r(json_encode($ajax_response));
    }

    public function get_leave_by_id($leave_id){
        $leave_array= $this->leave_model->get_leave_by_id($leave_id);
        $leave_array['start_date']=date('d-m-Y',strtotime($leave_array['start_date']));
        $leave_array['end_date']=date('d-m-Y',strtotime($leave_array['end_date']));
        print_r(json_encode($leave_array));
    }

    public function load_leave_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('leave_type').'</th>
                        <th >'.$this->lang->line('start_date').'</th>
                        <th >'.$this->lang->line('end_date').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $leaveArr = $this->leave_model->get_leave_list($this->session->userdata('user_id'));
        // echo '<pre>';
        // print_r("xcv");
    
        if(!empty($leaveArr)) {
            $i=1; 
            foreach($leaveArr as $leave){
                if($leave['leave_status']==0){
                    $status ='<span class="pending">Pending</span>';
                }else if($leave['leave_status']==1){
                    $status ='<span class="approved">Approved</span>';
                }else{
                    $status = '<span class="denied">Rejected</span>';
                }
                $html .= '<tr id="row_'.$leave['leave_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="type_'.$leave['leave_id'].'">
                        '.$leave['head'].'
                    </td>
                    <td id="start_date_'.$leave['leave_id'].'">
                        '.date('d-m-Y',strtotime($leave['start_date'])).'
                    </td>
                    <td id="end_date_'.$leave['leave_id'].'">
                        '.date('d-m-Y',strtotime($leave['end_date'])).'
                    </td>
                    <td id="leave_status_'.$leave['leave_id'].'">
                        '.$status.'
                    </td>
                    <td>';
                    if($leave['leave_status']==0){
                    $html .= '<button class="btn btn-default option_btn " title="View" onclick="view_leave('.$leave['leave_id'].')">
                                <i class="fa fa-eye "></i>
                            </button><button class="btn btn-default option_btn " title="Edit" onclick="get_leavedata('.$leave['leave_id'].')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_leave('.$leave['leave_id'].')">
                                <i class="fa fa-trash-o"></i>
                            </a>';
                    }else{
                    $html .= '<button class="btn btn-default option_btn " title="View" onclick="view_leave('.$leave['leave_id'].')">
                                <i class="fa fa-eye "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_leave('.$leave['leave_id'].')">
                                <i class="fa fa-trash-o"></i>
                            </a>';
                    }
                $html .= '</td>
                </tr>';
            $i++; 
            } 
        }
        echo $html;
    }

    public function approval_list()
    { 
        check_backoffice_permission('approval_list'); 
		$this->data['page']         = "admin/approval_list";
        $this->data['menu']         = "employee";
        $this->data['menu_item']    = "backoffice/manage-leave";
        $this->data['breadcrumb']   = "Leave Approval List";
        $this->data['staff_id']     = $this->leave_model->get_staff_id($this->session->userdata('user_id'));
        $this->data['approvalArr']  = $this->leave_model->get_approval_list($this->session->userdata('user_id'));
        // echo $this->db->last_query();
        // echo '<pre>';
        // print_r($this->data['approvalArr']);
        $this->data['typeArr']     = $this->leave_model->get_type();
		$this->load->view('admin/layouts/_master',$this->data); 
    }

    public function leave_status()
    {
        if($_POST)
        {
            $leave_status=$this->input->post('leave_status');
            $leave_id=$this->input->post('leave_id');
            // $user_id=$this->input->post('user_id');
            $what = '';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $res = $this->leave_model->leave_request_status($leave_id, $leave_status);
         
            if($res=1){
                $what=$this->db->last_query();
                $this->db->select('*');
                $this->db->where('leave_id',$leave_id);
                $this->db->where('status',2);
                $query = $this->db->get('am_leave_rejection')->row_array();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $leave_id, 'am_leave_request', 'Leave head status changed');


                $what=$this->db->last_query();
                $this->db->select('*');
                $this->db->where('leave_id',$leave_id);
                $this->db->where('leave_status',1);
                $query = $this->db->get('am_leave_request')->row_array();
               
                $approveArray['staff_id'] = $query['user_id'];
                $approveArray['start_date'] = $query['start_date'];
                $approveArray['end_date'] = $query['end_date'];
                $insert_tbl =$this->leave_model->insert_leave_entry($approveArray);
                // echo $this->db->last_query();
                // echo '<pre>';
                // print_r($insert_tbl);

                // $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                // logcreator('insert', 'database', $who, $what, $leave_id, 'leave_entry_log');



                $leave_array=$this->leave_model->get_leavedetails_by_id($leave_id);
                    if($leave_array['leave_status']==0){
                        $status ="Pending";
                    }else if($leave_array['leave_status']==1){
                        $status ="Approved";
                    }else{
                        $status ="Rejected";
                    }

                   
                    $html='<li id="row_'.$leave_id.'">
                                <div class="col sl_no "> '.$leave_id.' </div>
                                <div class="col " >'.$leave_array['head'] .' </div>
                                <div class="col " >'.$leave_array['start_date'] .' </div>
                                <div class="col " >'.$leave_array['end_date'] .' </div>
                                <div class="col " >'.$status .' </div>
                            <li>';

                             // send email
                    $num=$this->session->userdata('user_id');
                    $type="Leave Request";
                    $email=$this->session->userdata('email');
                    $data=email_header();
                    $data.='<tr style="background:#f2f2f2">
                            <td style="padding: 20px 0px">
                                <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi</h3>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Your leave application is '.$status.'. </p>';
                                if($status==2){
                                    $data.='<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The reason is '.$leave_array['description'].'. </p>';
                                }
                    $data.='</td>
                        </tr>';
                    $data.=email_footer();
                    $this->send_email($type, $email,$data);

            }
            print_r($res);
        }
    }

    function send_email($type, $email, &$data)
    {
        $this->email->to($email);
        $this->email->subject($type);
        $this->email->message($data);
        $this->email->send();
    }

    public function load_approve_leave_ajax() 
    {
        
     $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('name').'</th>
                        <th>'.$this->lang->line('leave_type').'</th>
                        <th>'.$this->lang->line('start_date').'</th>
                        <th>'.$this->lang->line('end_date').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('action').'</th>

                    </tr>
                </thead>';  
       $data=$this->leave_model->get_approval_list($this->session->userdata('user_id'));
       if(!empty($data))
       { $i=1;
         foreach($data as $rows)
           {
            // if($rows['leave_status'] == "0"){
            //      $status_value=1;
            //      $status='<a href="#"><span class="approved" onclick="edit_leave_status('.$rows['leave_id'].','.$status_value.');">Approved</span></a>';
            // }else if($rows['leave_status'] == "1"){
            //      $status_value=2;
            //      $status='<a href="#"><span class="denied" onclick="edit_leave_status('.$rows['leave_id'].','.$status_value.');">Rejected</span></a>';
            // }
        //     else if($rows['leave_status'] == "1"){
        //         $status_value=2;
        //         $status='<a href="#"><span class="approved" onclick="edit_leave_status('.$rows['leave_id'].','.$status_value.');">Rejected</span></a>';
        //    }else{
        //         $status_value=2;
        //         $status='<a href="#"><span class="denied" onclick="edit_leave_status('.$rows['leave_id'].','.$status_value.');">Rejected</span></a>';
        //    }
        if($rows['leave_status']=="0"){ 
            $status= '<a href="#"><span class="pending" onclick="edit_leave_status('.$rows['leave_id'].','.$rows['leave_status'].'); ">Pending</span></a>';
        }else if($rows['leave_status']=="1"){ 
            $status= '<a href="#"><span name="reject_status" id="reject_status_'.$rows['leave_id'].'" class="approved" onclick=" get_val('.$rows['leave_id'].');">Approved</span></a>';
        }else{ 
            $status= '<a href="#"><span  class="denied" onclick="edit_leave_status('.$rows['leave_id'].','.$rows['leave_status'].'); ">Rejected</span></a>';
        } 
             $html.='<tr id="row_'.$rows['leave_id'].'">
                 <td>'.$i.'</td>
                 <td id="name_'.$rows['leave_id'].'">'.$rows['name'].'</td>
                 <td id="head_'.$rows['leave_id'].'">'.$rows['head'].'</td>
                 <td id="start_date_'.$rows['leave_id'].'">'.$rows['start_date'].'</td>
                 <td id="end_date_'.$rows['leave_id'].'">'.$rows['end_date'].'</td>
                 <td id="leave_status_'.$rows['leave_id'].'">'.$status.'</td>
                 <td>
                    <button class="btn btn-default option_btn " title="View" onclick="view_leave('.$rows['leave_id'].')">
                        <i class="fa fa-eye "></i>
                    </button>
                 </td>
                </tr>';
             $i++;


              // send email
                    $num=$this->session->userdata('user_id');
                    $type="Leave Request";
                    $email=$this->session->userdata('email');
                    $data=email_header();
                    $data.='<tr style="background:#f2f2f2">
                            <td style="padding: 20px 0px">
                                <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi</h3>
                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Your leave application is '.$status.'. </p>';
                                if($rows['leave_status']=="2"){
                                    $data.='<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The reason is '.$rows['description'].'. </p>';
                                }
                    $data.='</td>
                        </tr>';
                    $data.=email_footer();
                    $this->send_email($type, $email,$data);
                   
                    // $this->auth_model->absent_alert($receiver_email, $email_msg); //SEND EMAIL PAYMENT STATUS
           }  
       }
       echo $html;
   }

    public function description_add()
    {
        if($_POST){
            $data = $_POST;
            $description_exist = $this->leave_model->is_description_exist($data);
            if($description_exist == 0){ 
                $leave_id = $this->input->post('leave_id');
                $status = 2;
                    $insertArray = array();
                    $insertArray['leave_id'] = $data['leave_id'];
                    $insertArray['status'] = 2;
                    $insertArray['description'] = $data['description'];
                    $res = $this->leave_model->description_add($insertArray);
            $leave_id = $this->input->post('leave_id');
            if($res = 1){
                $what = $this->db->last_query();
                $table_row_id = $this->db->insert_id();
                $this->db->where('leave_id', $leave_id);
                $this->db->update('am_leave_request', array('leave_status'=> 2));
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'database', $who, $what, $table_row_id, 'am_leave_rejection');
                $leave_array=$this->leave_model->get_leavedetails_by_id($leave_id);
                    if($leave_array['leave_status']==0){
                        $status ="Pending";
                    }else if($leave_array['leave_status']==1){
                        $status ="Approved";
                    }else{
                        $status ="Rejected";
                    }
                    $html='<li id="row_'.$leave_id.'">
                                <div class="col sl_no "> '.$leave_id.' </div>
                                <div class="col " >'.$leave_array['head'] .' </div>
                                <div class="col " >'.$leave_array['start_date'] .' </div>
                                <div class="col " >'.$leave_array['end_date'] .' </div>
                                <div class="col " >'.$status .' </div>
                            <li>';

                             // send email
                    $num=$this->session->userdata('user_id');
                    $type="Leave Request";
                    $email=$this->session->userdata('email');
                    $data=email_header();
                    $data.='<tr style="background:#f2f2f2">
                            <td style="padding: 20px 0px">
                                <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi</h3>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Your leave application is '.$status.'. </p>';
                                if($leave_array['leave_status']==2){
                                    $data.='<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The reason is '.$leave_array['description'].'. </p>';
                                }
                    $data.='</td>
                        </tr>';
                    $data.=email_footer();
                    $this->send_email($type, $email,$data);
                
            }
            // print_r($res);
        }else{
            $html=2;//already exist
        }
            print_r($res);
        }
    }

    public function get_leave_val()
    {
        if($_POST){
            $id = $this->input->post('id');
            $selectid = $this->input->post('selectid');
            // $this->db->select('*');
            // $this->db->where('enquiry_id',$id);
            // $query = $this->db->get('cc_enquiries')->row_array();
            $data['leave_status'] = $selectid;
            if($res=1){
                $what=$this->db->last_query();
                $table_row_id = $this->db->insert_id();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'am_leave_request');

            $this->db->select('*');
            $this->db->where('leave_id',$id);
            $this->db->where('leave_status',1);
            $query = $this->db->get('am_leave_request')->row_array();

            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('insert', 'database', $who, $what, $table_row_id, 'leave_entry_log');

            }
            print_r($res);
        }
    }

//--------------------------------------- Manage Leave Types -----------------------------------------------//
public function leave_head()
    {
        check_backoffice_permission('leave_head');
        $this->data['page']="admin/leave_head";
        $this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Leave Head";
        $this->data['menu_item']="backoffice/leave-head";
        $this->data['leavetypeArr']=$this->leave_model->get_leave_type();
        $this->load->view('admin/layouts/_master',$this->data); 
    }

    public function load_leave_head_ajax() {
        $html = '<thead> 
                <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('leave_head').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $leavetypeArr = $this->leave_model->get_leave_type();
        if(!empty($leavetypeArr)) {
            $i=1; 
            foreach($leavetypeArr as $leavetype){
            if($leavetype['status'] == "0"){
                $s=1;
                $status='<span class="btn mybutton mybuttonInactive" onclick="edit_status('. $leavetype['id'].','.$s.');">Inactive</span>';
                $action=' <button class="btn btn-default option_btn " title="Edit" onclick="get_leavehead_data('.$leavetype['id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_leavehead('.$leavetype['id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
            }else{
                $s=0;
                $status='<span class="btn mybutton mybuttonActive" onclick="edit_status('. $leavetype['id'].','.$s.');">Active</span>';
                  $action=' <button class="btn btn-default option_btn " title="Edit" onclick="get_leavehead_data('.$leavetype['id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        ';
            }
                $html .= '<tr id="row_'.$leavetype['id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="head_'.$leavetype['id'].'">
                        '.$leavetype['head'].'
                    </td>
                    <td id="status_'.$leavetype['id'].'">
                        '.$status.'
                    </td>
                    <td>
                        '.$action.'
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }

    public function leave_head_add()
    {
        if($_POST){
            $data = $_POST;
            $leave_head_exist = $this->leave_model->is_leave_head_exist($data);
            if($leave_head_exist == 0){
                $res = $this->leave_model->leave_head_add($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'leave_heads', 'New leave head added');
                    $leave_head_array=$this->leave_model->get_leave_headdetails_by_id($table_row_id);
                    $html='<li id="row_'.$table_row_id.'">
                            <div class="col sl_no "> '.$table_row_id.' </div>
                                <div class="col " >'.$leave_head_array['head'] .' </div>
                                <div class="col actions ">
                                    <button class="btn btn-default option_btn " title="Edit" onclick="get_leavehead_data('.$table_row_id.')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_leavehead('.$table_row_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            <li>';
                }
            }else{
                $html=2;//already exist
            }
            print_r($html);
        }
    }

    public function leave_head_edit()
    {
        if($_POST){
            $id = $this->input->post('id');
            unset($_POST['id']);
            $data = $_POST;
            $res = $this->leave_model->leave_head_edit($data, $id);
            if($res){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'leave_heads', 'Leave head edited');
                 
               
            }
            print_r($res);
        }
    }

    public function leave_head_delete()
    {
        $id  = $_POST['id'];
        $exist=$this->common->check_if_dataExist('am_leave_request',array("type_id"=>$id));
        $check=$this->common->check_if_dataExist('leave_schemes_details',array("leave_heads_id"=>$id));
        if($exist == 0 && $check==0){
        $res = $this->leave_model->leave_head_delete($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'leave_heads', 'Leave head deleted');
        }
        }
        else
        {
            if($exist!=0)
            {
                $res=2; 
            } 
            if($check!=0)
            {
                $res=3; 
            }
           
        }
        print_r($res);
    }

    public function get_leave_head_by_id($id){
        $leave_head_array= $this->leave_model->get_leave_head_by_id($id);
        print_r(json_encode($leave_head_array));
    }

    
    public function leave_head_status()
    {
        if($_POST)
        { //print_r($_POST);
            $status=$this->input->post('status');
            $id=$this->input->post('id');
            $what = '';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $res = $this->leave_model->leave_head_status($id, $status);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'Leave head status changed');
                $leave_head_array=$this->leave_model->get_leave_headdetails_by_id($id);
                if($leave_head_array['status'] == "0"){
                    $s=1;
                    $status='<span class="btn mybutton mybuttonInactive" onclick="edit_status('. $leave_head_array['id'].','.$s.');">Inactive</span>';
                }else{
                    $s=0;
                    $status='<span class="btn mybutton mybuttonActive" onclick="edit_status('. $leave_head_array['id'].','.$s.');">Active</span>';
                }
                $html='<li id="row_'.$id.'">
                        <div class="col sl_no "> '.$id.' </div>
                            <div class="col " >'.$leave_head_array['head'] .' </div>
                            <div class="col " >'.$status .' </div>

                            <div class="col actions ">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_leavehead_data('.$id.')">
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_leavehead('.$id.')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        <li>';

            }
            print_r($res);
        }
    }
 //--------------------------------------- Manage Salary Component -----------------------------------------------//
   
 public function salary_component()
 {
     check_backoffice_permission('salary_component');
     $this->data['page']="admin/salary_component";
     $this->data['menu']="basic_configuration";
     $this->data['breadcrumb']="Salary Component";
     $this->data['menu_item']="backoffice/salary-component";
     $this->data['salarycomponentArr']=$this->leave_model->get_salary_component();
     $this->load->view('admin/layouts/_master',$this->data); 
 }

 public function load_salary_component_ajax() {
     $html = '<thead> 
             <tr>
                     <th>'.$this->lang->line('sl_no').'</th>
                     <th >'.$this->lang->line('salary_component').'</th>
                     <th >'.$this->lang->line('type').'</th>
                     <th >'.$this->lang->line('status').'</th>
                     <th >'.$this->lang->line('action').'</th>
                 </tr>
             </thead>';
     $salarycomponentArr = $this->leave_model->get_salary_component();
     if(!empty($salarycomponentArr)) {
         $i=1; 
         foreach($salarycomponentArr as $salarycomponent){
         if ($salarycomponent['status'] == "4") {  
                $status='<span title="Con\'t change..!">Non editable</span>';
         }
         else if($salarycomponent['status'] == "0"){
             $s=1;
             $status='<span class="btn mybutton mybuttonInactive" onclick="edit_status('. $salarycomponent['id'].','.$s.');">Inactive</span>';
         }else{
             $s=0;
             $status='<span class="btn mybutton mybuttonActive" onclick="edit_status('. $salarycomponent['id'].','.$s.');">Active</span>';
         }
             $html .= '<tr id="row_'.$salarycomponent['id'].'">
                 <td>
                     '.$i.'
                 </td>
                 <td id="name_'.$salarycomponent['id'].'">
                     '.$salarycomponent['head'].'
                 </td>
                 <td id="type_'.$salarycomponent['id'].'">
                     '.$salarycomponent['type'].'
                 </td>
                 <td id="status_'.$salarycomponent['id'].'">
                     '.$status.'
                 </td>
                 <td>';
                 if ($salarycomponent['status'] != "4") {  
            $html .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_salarycomponent_data('.$salarycomponent['id'].')">
                         <i class="fa fa-pencil "></i>
                     </button>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_salarycompnent('.$salarycomponent['id'].')">
                         <i class="fa fa-trash-o"></i>
                     </a>';
                    }else{
            $html .= '<span title="Con\'t change..!">Non editable</span>';
                    }
            $html .= '</td>
             </tr>';
         $i++; 
         }
     }
     echo $html;
 }

 public function salary_component_add()
 {
     if($_POST){
         $data = $_POST;
         $salary_component_exist = $this->leave_model->is_salary_component_exist($data);
         if($salary_component_exist == 0){
             $res = $this->leave_model->salary_component_add($data); 
             if($res == 1){
                 $what = $this->db->last_query();
                 $table_row_id = $this->db->insert_id();
                 $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                 logcreator('insert', 'database', $who, $what, $table_row_id, 'leave_heads', 'New salary component added');
                 $ajax_response['st'] = 1;
                 $ajax_response['msg'] = 'New salary component added Succesfully';
             }
         }else{
            $ajax_response['st'] = 2;
            $ajax_response['msg'] = 'Salary component Already Exist';
         }
        print_r(json_encode( $ajax_response));
     }
 }

 public function salary_component_edit(){
    if($_POST){
        $id = $this->input->post('id');
        unset($_POST['id']);
        $data = $_POST;
        $salary_component_exist = $this->leave_model->is_salary_component_existEdit($data, $id);
        // show($salary_component_exist);
        if($salary_component_exist == 0){
            $res = $this->leave_model->salary_component_edit($data, $id);
            if($res == 1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'salary_heads', 'Salary component edited');
                $ajax_response['st'] = 1;
                $ajax_response['msg'] = 'Leave Head Updated Succesfully';
            }
        }else{
            $ajax_response['st'] = 2;
            $ajax_response['msg'] = 'Leave Head Already Exist';
        }
       print_r(json_encode( $ajax_response));
    }
 }

 public function salary_component_delete()
 {
     $id  = $_POST['id'];
     $res = $this->leave_model->salary_component_delete($id);
     if($res == 1){
         $what = $this->db->last_query();
         $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
         logcreator('delete', 'database', $who, $what, $id, 'leave_heads', 'Salary component deleted');
     }
     print_r($res);
 }

 public function get_salary_component_by_id($id){
     $salary_component_array= $this->leave_model->get_salary_component_by_id($id);
     print_r(json_encode($salary_component_array));
 }

 
 public function salary_component_status()
 {
     if($_POST)
     {
         $status=$this->input->post('status');
         $id=$this->input->post('id');
         $what = '';
         $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
         $res = $this->leave_model->salary_component_status($id, $status);
         if($res=1){
             $what=$this->db->last_query();
             $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
             logcreator('update', 'database', $who, $what, $id, 'am_salary_components', 'Salary component status changed');
             $salary_component_array=$this->leave_model->get_salary_componentdetails_by_id($id);
             if ($salary_component_array['status'] == "4") {  
                $status='<span title="Con\'t change..!">Non editable</span>';
                }
             else if($salary_component_array['status'] == "0"){
                 $s=1;
                 $status='<span class="btn mybutton mybuttonInactive" onclick="edit_status('. $salary_component_array['id'].','.$s.');">Inactive</span>';
             }else{
                 $s=0;
                 $status='<span class="btn mybutton mybuttonActive" onclick="edit_status('. $salary_component_array['id'].','.$s.');">Active</span>';
             }
             $html='<li id="row_'.$id.'">
                     <div class="col sl_no "> '.$id.' </div>
                         <div class="col " >'.$salary_component_array['head'] .' </div>
                         <div class="col " >'.$salary_component_array['type'] .' </div>
                         <div class="col " >'.$status .' </div>

                         <div class="col actions ">
                             ';
                 if ($salary_component_array['status'] != "4") {  
            $html .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_salarycomponent_data('.$salary_component_array['id'].')">
                         <i class="fa fa-pencil "></i>
                     </button>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_salarycomponent('.$salary_component_array['id'].')">
                         <i class="fa fa-trash-o"></i>
                     </a>';
                    }else{
            $html .= '<span title="Con\'t change..!">Non editable</span>';
                    }
            $html .= '
                         </div>
                     <li>';

         }
         print_r($res);
     }
 }


 public function leave_entry()
 {
     if($_POST){
         $data = $_POST;
         $leave_exist = $this->leave_model->is_entry_exist($data);
         if($leave_exist == 0){
             $res = $this->leave_model->leave_entry($data);
             
             if($res = 1){
                 $what = $this->db->last_query();
                 $table_row_id = $this->db->insert_id();
                 $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                 logcreator('insert', 'database', $who, $what, $table_row_id, 'leave_entry_log', 'New leave log inserted');
                //  $leave_array=$this->leave_model->get_leavedetails_by_id($table_row_id);
                //  if($leave['leave_status']==0){
                //      $status ='<span class="pending">Pending</span>';
                //  }else if($leave['leave_status']==1){
                //      $status ='<span class="approved">Approved</span>';
                //  }else{
                //      $status = '<span class="denied">Rejected</span>';
                //  }
                //  $html='<li id="row_'.$table_row_id.'">
                //          <div class="col sl_no "> '.$table_row_id.' </div>
                //              <div class="col " >'.$leave_array['head'] .' </div>
                //              <div class="col " >'.$leave_array['start_date'] .' </div>
                //              <div class="col " >'.$leave_array['end_date'] .' </div>
                //              <div class="col " >'.$status .' </div>
                //              <div class="col actions ">';
                //              if($leave_array['leave_status']==0){
                //  $html =    '<button class="btn btn-default option_btn "  onclick="view_leave('.$table_row_id.')">
                //                  <i class="fa fa-eye "></i>
                //              </button>
                //              <button class="btn btn-default option_btn "  onclick="get_leavedata('.$table_row_id.')">
                //                  <i class="fa fa-pencil "></i>
                //              </button>
                //              <a class="btn btn-default option_btn" onclick="delete_leave('.$table_row_id.')">
                //                  <i class="fa fa-trash-o"></i>
                //              </a>';
                //              }else{
                //  $html =    '<button class="btn btn-default option_btn "  onclick="view_leave('.$table_row_id.')">
                //                  <i class="fa fa-eye "></i>
                //              </button>
                //              <a class="btn btn-default option_btn" onclick="delete_leave('.$table_row_id.')">
                //                  <i class="fa fa-trash-o"></i>
                //              </a>';
                //              }
                                 
                //  $html =      '</div>
                //          <li>';
             }
         }else{
             $html=2;//already exist
         }
         print_r($html);
     }
 }

 public function num_days() {
    $dateone = date('Y-m-d', strtotime($this->input->post('start_date')));
    $datetwo = date('Y-m-d', strtotime($this->input->post('end_end')));
    //  show($date1);
    $date1 = new DateTime($dateone);
    $date2 = new DateTime($datetwo);
    echo $days  = $date2->diff($date1)->format('%a');
    // $date1 = strtotime($dateone);
    // $date2 = strtotime($datetwo);
    // $datediff = $date1 - $date2;
    // echo round($datediff / (60 * 60 * 24));
    // $diff  = date_diff($date1, $date2);
    // echo $diff->format("%R%a") + 1 . ' days';
 }
    
    public function check_headName()
    {
        //print_r($_POST);
        $head_name=$this->input->post('head_name');
        $exist=$this->common->check_if_dataExist("leave_heads",array("head"=>$head_name,"status!="=>2));
        if($exist == 0)
        {
            echo "true";
        }
        
        else
        {
            echo "false";
        }
    }
     public function check_headName_edit()
     {
        $head_name=$this->input->post('head');
        $head_id=$this->input->post('head_id');
        $exist=$this->common->check_if_dataExist("leave_heads",array("head"=>$head_name,"id!="=>$head_id,"status!="=>2));
        if($exist >= 1)
        {
            echo "false";
        }
        
        else
        {
            echo "true";
        }
     }
    
    public function duplicate_leave_start()
    {
         $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
         $user_id=$this->input->post('user_id');
         $exist=$this->Leave_model->duplicate_leave($start_date,$user_id);
       // echo $this->db->last_query();
        //echo "<br>".$exist;
        if($exist >= 1)
        {
            echo "false";
        }
        
        else
        {
            echo "true";
        }
        
    }
    public function duplicate_leave_end()
    {
         $start_date=date('Y-m-d',strtotime($this->input->post('end_date')));
         $user_id=$this->input->post('user_id');
         $exist=$this->Leave_model->duplicate_leave($start_date,$user_id);
       // echo $this->db->last_query();
        //echo "<br>".$exist;
        if($exist >= 1)
        {
            echo "false";
        }
        
        else
        {
            echo "true";
        }
        
    }
    public function duplicate_leave_start_edit()
    {
         $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
         $leave_id=$this->input->post('leave_id');
         $user_id=$this->input->post('user_id');
         $exist=$this->Leave_model->duplicate_leave_edit($start_date,$user_id,$leave_id);
        if($exist >= 1)
        {
            echo "false";
        }
        
        else
        {
            echo "true";
        }
        
    }
    public function duplicate_leave_end_edit()
    {
         $start_date=date('Y-m-d',strtotime($this->input->post('end_date')));
         $leave_id=$this->input->post('leave_id');
         $user_id=$this->input->post('user_id');
         $exist=$this->Leave_model->duplicate_leave_edit($start_date,$user_id,$leave_id);
        if($exist >= 1)
        {
            echo "false";
        }
        
        else
        {
            echo "true";
        }
        
    }
}
?>