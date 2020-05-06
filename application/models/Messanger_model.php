<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Messanger_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
	public function get_conversations() {
        $role = $this->session->userdata('role');
        $id = $this->session->userdata['user_id'];
        // echo $id = $this->session->userdata['user_id']; exit;
        $conversations = $this->db->where('from',$id)->or_where('to',$id)->get('conversations')->result_array();
        if(!empty($conversations)){
            foreach($conversations as $key=>$val)
            {
                $status = $this->db->where('conversation_id',$val['id'])->where('receiver',$id)->order_by('id','DESC')->get('messages')->row_array();
                if(!empty($status)){$conversations[$key]['status'] = $status['status'];}else{$conversations[$key]['status'] = 1;}
            }
        }
        return $conversations;
	}
    public function get_members($student_id){
        $batch_id = $this->db->select('batch_id')->from('am_student_course_mapping')->where('student_id',$student_id)->where('status', 1)->get()->row()->batch_id;
        // $this->db->select('staff_id')->from('am_schedules')->where('schedule_type',2)->where('schedule_link_id',$batch_id);
        // $query	=	$this->db->get();
        // $resultArr	= $query->result_array();		
        // echo "<pre>"; print_r($resultArr); exit;
        $this->db->select('am_staff_personal.*');
        $this->db->from('am_staff_personal'); 
        $this->db->where(array("am_staff_personal.status"=> 1));
        $this->db->join('am_schedules', 'am_schedules.staff_id=am_staff_personal.personal_id');  
        $this->db->where(array("am_schedules.schedule_link_id"=>$batch_id,"schedule_type"=>2));
        $this->db->group_by('personal_id'); 
        $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
		    $resultArr	=	$query->result();		
        }
        // echo $this->db->last_query(); exit;
		// echo "<pre>"; print_r($resultArr); exit;
		return $resultArr;
    }
    public function get_messages($id,$uid=''){
        if($uid == ''){
            $u_id = $this->session->userdata['user_id'];
        }else{
            $u_id = $uid;
        }
        $messages = $this->db->select('messages.*,conversations.archieved')->from('messages')
                             ->join('conversations','conversations.id=messages.conversation_id')
                             ->where('messages.conversation_id',$id)->order_by('messages.id','DESC')
                             ->get()->result();
        $msg = $this->db->where('conversation_id',$id)->where('receiver',$u_id)->order_by('id','DESC')->get('messages')->row_array();
        if(!empty($msg)){
            if($msg['status']==0){
                $data['status']=1;
                // $data['read_date']=date('Y-m-d H:i:s');
                $this->db->where('id',$msg['id'])->update('messages',$data);
            }
        }
        // echo $this->db->last_query(); exit;
        if(!empty($messages[0])){return $messages;}else{return array();}
    }
    public function send_message($message,$conv_id,$from){
        $conv = $this->db->where('id',$conv_id)->get('conversations')->row_array();
        if(!empty($conv))
        {
            if($conv['from']!=$from){
                $to=$conv['from'];
                $from_name=$conv['to_name'];
                $to_name=$conv['from_name'];
            }else{
                $to=$conv['to'];
                $from_name=$conv['from_name'];
                $to_name=$conv['to_name'];
            }
            // $to_detals = $this->db->where('id',$to)->get('users')->row_array();
            $messages = array(
                                'conversation_id'=>$conv_id,
                                'sender'=>$from,
                                'receiver'=>$to,
                                'sender_name'=>$from_name,
                                'receiver_name'=>$to_name,
                                'message'=>$message,
                                'send_date'=>date('Y-m-d H:i:s'),
                                'status'=>0
                            );
            $this->db->trans_begin();
            $this->db->trans_strict(FALSE);
            $this->db->insert('messages', $messages);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                // $this->load->model('email');
                // $data['title'] = 'Chat notification'; 
                // $data['message'] = '<p>Dear '.$to_detals["name"].',</p><p><b>'.$from_name.'</b> has send you a message on the conversation Titled: "<b>'.$conv['subject']
                //                         . '</b>"<p>Message: <b>'.$message.'<b></p>'
                //                         . '<p>Please login to reply</p>'
                //                         . '<p>Click here to <a href"'.base_url('login').'">LOGIN</a></p>';
                // $content = $this->load->view('email/general_email', $data,TRUE);
                // $this->email->to($to_detals['email']);
                // $this->email->from('vibhaindia.org');
                // $this->email->subject('vibhaiindia.org chat notification');
                // $this->email->message($content);
                // $this->email->send();
                return TRUE;
            }
        }else{
            return FALSE;
        }
    }
    public function start_conversation($convers,$msg,$file=''){
        // // $this->load->model('email');
        // $role = $this->session->userdata('name');
        // if($role == 'faculty'){
        //     $roledb = 'am_users';
        // }else if($role == 'student' || $role == 'parent'){
        //     $roledb = 'am_users_backoffice';
        // }
        $i=0;
        foreach($convers as $con)
        {
            $e = explode('_',$con['to']);
            if(count($e)==1){
                $convs[$i]=$con;
                $msgs[$i]=array(
                    'sender'=>$con['from'],
                    'receiver'=>$con['to'],
                    'message'=>$msg,
                    'attachment'=>$file,
                    'send_date'=>$con['started_date']
                );
                $i++;
            }else{
                $id = $e[0];
                $members = $this->db->where('entity',$id)
                        ->where("(role='member' OR role='master')")
                        ->get($roledb)->result();
                foreach($members as $ms)
                {
                    $con['to'] = $ms->id;
                    $convs[$i]=$con;
                    $msgs[$i]=array(
                        'sender'=>$con['from'],
                        'receiver'=>$con['to'],
                        'message'=>$msg,
                        'attachment'=>$file,
                        'send_date'=>$con['started_date']
                    );
                    $i++;
                }
            }
        }
        foreach($convs as $key=>$val){
            $conversation=$convs[$key];
            $message=$msgs[$key];
            $role = $this->session->userdata('role');
            if($role == 'faculty'){
                //$from = $this->session->userdata('name');
                $from = $this->db->select('name,email')->where('personal_id',$conversation['from'])->get('am_staff_personal')->row_array();
                $to =  $this->db->select('name,email')->where('student_id',$conversation['to'])->get('am_students')->row_array();
            }else if($role == 'student' || $role == 'parent'){
                // echo "<pre>"; print_r($this->session->all_userdata()); exit;
                //$from = $this->session->userdata('name');
                $from = $this->db->select('name,email')->where('student_id',$conversation['from'])->get('am_students')->row_array();
                $to =  $this->db->select('name')->where('personal_id',$conversation['to'])->get('am_staff_personal')->row_array();
            }
            // $from = $this->db->select('name,email')->where('user_id',$conversation['from'])->get($roledb)->row_array();
            // $to =  $this->db->select('user_name,user_emailid')->where('user_id',$conversation['to'])->get($roledb)->row_array();
            $conversation['from_name']= $from['name'];
            $conversation['to_name']=$to['name'];
            $this->db->trans_begin();
            $this->db->trans_strict(FALSE);
            $this->db->insert('conversations', $conversation);
            $message['conversation_id'] = $this->db->insert_id();
            $message['sender_name'] = $from['name'];
            $message['receiver_name'] = $to['name'];
            $message['status'] = 0;
            $this->db->insert('messages', $message);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                // $data['title'] = 'Chat notification'; 
                // $data['message'] = '<p>Dear '.$to["name"].',</p><p>'.$from['name'].' has started a new conversation with you</p>'
                //                         .'<p>Titled: '.$conversation["subject"].'</p>'
                //                         .'<p>Message: '.$msg.'</p>'
                //                         . '<p>Please login to reply</p>'
                //                         . '<p>Click here to <a href"'.base_url('login').'">LOGIN</a></p>';
                // $content = $this->load->view('email/general_email', $data,TRUE);
                // $this->email->to($to['email']);
                // $this->email->from('vibhaindia.org');
                // $this->email->subject('vibhaiindia.org chat notification');
                // $this->email->message($content);
                // $this->email->attachment($file);
                // $this->email->send();
            }
        }
        if(count($convs)==1){
            return $message['conversation_id'];
        }else{
            return 'a';
        }
    }
    public function archieve_conversation($id){
        $data['archieved']=1;
        return $this->db->where('id',$id)->update('conversations',$data);
    }
    public function get_faculity_scheduled_batch($personal_id)
    {
        $this->db->select('am_batch_center_mapping.*');
        $this->db->from('am_batch_center_mapping'); 
        $this->db->join('am_schedules', 'am_schedules.schedule_link_id=am_batch_center_mapping.batch_id');
        $this->db->where(array("am_schedules.schedule_type"=>"2","am_schedules.schedule_status"=>1,"am_schedules.staff_id"=>$personal_id, "am_batch_center_mapping.batch_status"=>1));
        $this->db->where(array("am_batch_center_mapping.batch_status"=> 1)); 
        $this->db->group_by('am_batch_center_mapping.batch_id'); 
        $query	=	$this->db->get();
        // echo $this->db->last_query(); exit;
		$resultArr	=	array();
		if($query->num_rows() > 0){
		    $resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }

    public function get_students_by_batchid($batch_id)
    {
        $this->db->select('am_students.*');
        $this->db->from('am_students'); 
        $this->db->where(array("am_students.status"=> 1));
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=am_students.student_id');
        $this->db->where(array("am_student_course_mapping.batch_id"=>$batch_id));
        $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
		    $resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    public function get_msgnoty() {
        $id = $this->session->userdata['user_id'];
        $conversations = $this->db->where('from',$id)->or_where('to',$id)->get('conversations')->result_array();
        if(!empty($conversations)){
            foreach($conversations as $key=>$val)
            {
                $status = $this->db->where('conversation_id',$val['id'])->where('receiver',$id)->order_by('id','DESC')->get('messages')->row_array();
                if(!empty($status)){$conversations[$key]['status'] = $status['status'];}else{$conversations[$key]['status'] = 1;}
            }
        }
        // echo "<pre>"; print_r($conversations); exit;
        return $conversations;
	}
}