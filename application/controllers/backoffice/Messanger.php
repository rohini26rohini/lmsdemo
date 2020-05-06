<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messanger extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="messenger";
        check_backoffice_permission($module);
    }
    public function index($id = '')
    {
        check_backoffice_permission('messenger');
        $this->data['page']="admin/messenger";
		$this->data['menu']="messenger";
        $this->data['breadcrumb']="Messenger";
        $this->data['menu_item']="backoffice/messenger";
        $this->data['conversations'] = $this->Messanger_model->get_conversations();
        $msgnoty = $this->Messanger_model->get_msgnoty();
        $f = 0;
        foreach($msgnoty as $conv){
            if($conv['status']==0 && $conv['archieved']==0){
                $f++;
            }
        }
        $this->data['notifyCount'] = $f;
        $personal_id=$this->session->userdata['user_id'];
        $this->data['batches']=$this->Messanger_model->get_faculity_scheduled_batch($personal_id);
        if($id!=''){$this->data['message'] = $this->Messanger_model->get_messages($id); }
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_messages() {
        if($_POST)
        {
            $message = $this->Messanger_model->get_messages($this->input->post('id'),$this->input->post('from'));
            // echo "<pre>"; print_r($message); exit;
            $data='';
            if(isset($message)){if(!empty($message)){$id=$this->session->userdata['user_id']; 
                if($message[0]->receiver==$id){$name = $message[0]->sender_name;}else{$name = $message[0]->receiver_name;}
                $data=$data.'<div class="msg_view_dp">
                                <h4>'.$name.'</h4>
                            </div>
                                <div class="chatbox msg_view" id="boxscroll">';
                foreach($message as $msg){
                    if(!empty($msg->attachment)){
                        $file = '<br><a title="download" target="_blank" href="'.base_url($msg->attachment).'"><span class="fa fa-download" >&nbsp;</span>Attachment</a>';
                    }else{$file='';}
                    if($msg->receiver == $id){ 
                        $data=$data.'<div class="chatbody">
                                        <div class="chatext">
                                            <p><span>'.$msg->message.$file.'</span><br><font class="msg_time">'.date('M-d h:i a',strtotime($msg->send_date)).'</font></p>
                                        </div>
                                    </div>';
                    }if($msg->sender == $id){
                        $data=$data.'<div class="chatbody">
                                        <div class="chatextrtl">
                                            <p><span>'.$msg->message.$file.'</span><br><font class="msg_time">'.date('M-d h:i a',strtotime($msg->send_date)).'</font></p>
                                        </div>
                                    </div>';
                    }}
                $data=$data.'</div>
                                    <div class="form-row align-items-center Messengerbox">
                                        <div class="col-12">
                                            <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                            <div class="input-group mb-2">
                                                <textarea class="form-control" id="message_text" rows="3"></textarea>
                                                <div class="input-group-prepend">
                                                <!--<input type="file"> <i class="fa fa-paperclip" aria-hidden="true"></i>-->
                                                <button onClick="sendMessage()" class="input-group-text"><i class="fa fa-paper-plane"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                 }}
                 echo $data;
        }
    }
        
    public function send_message() {
        if($_POST)
        {
            $message = $this->input->post('message');
            $conv_id = $this->input->post('conv_id');
            $from = $this->input->post('from');
            if($this->Messanger_model->send_message($message,$conv_id,$from)){
                echo '<div class="chatbody">
                        <div class="chatextrtl">
                            <p><span>'.$message.'</span><br><font class="msg_time">'.date('M-d h:i a').'</font></div>
                        </div>
                    </div>';
            }else{
                echo '<div class="msg-pos2" style="background-color:red;color:white;"><span>Server Busy Please Try again Later</span></div>';
            }
        }
    }
    public function start_conversation() {
        if($_POST)
        {
            $from_id = $this->session->userdata('user_id');
            if(!empty($_FILES['attachment']['name']))
            {
                $folder = time();
                mkdir('./uploads/messages/'.$folder,0777,TRUE);
                $config['upload_path'] = './uploads/messages/'.$folder;
                $filename = "";
                $config['file_name'] = $_FILES['attachment']['name'];
                $config['allowed_types'] = '*';
                $config['max_size'] = '1000000';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('attachment')) {
                    $path = array($this->upload->data());
                    $filename = $path[0]['file_name'];
                    $file_path = 'uploads/messages/'.$folder.'/'.$filename;
                }
            }else{$file_path='';}
            $to = $this->input->post('to');
            foreach($to as $key=>$val)
            {
                $conversation[$key]=array(
                    'from'=>$from_id,
                    'to'=>trim($val),
                    'subject'=>$_POST['subject'],
                    'started_date'=>date('Y-m-d H:i:s')
                );
            }
            // show($conversation);
            $id = $this->Messanger_model->start_conversation($conversation,$this->input->post('message'),$file_path);
            if($id=='a'){
                $ajax_response['st']=2;
                $ajax_response['msg']="Conversation started successfully..!";
            }else{
                $ajax_response['id']=$id;
                $ajax_response['st']=1;
                $ajax_response['msg']="Conversation started successfully..!";
            }
        
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }
    public function get_conversation() {
        $id=$this->session->userdata('user_id');
        $type = $this->input->post('id');
        $conversations = $this->Messanger_model->get_conversations();
        $html = '<table class="table table-bordered table-sm ExaminationList">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Date &amp; Time</th>
                            <th>Action</th>
                        </tr>';
        if(!empty($conversations)){
            foreach($conversations as $conv){
                $status = 1;
                if ($type == 'Read'){
                    $f = 0;
                }else if($type == 'Archive'){
                    $f = 1;
                }else if($type == 'Unread'){
                    $f = 0;
                    $status = 0;
                }
                if($conv['status']==$status && $conv['archieved']==$f){
        $html .= '<tr>
                    <td>';
                        if($conv['from']==$id){$name = $conv['to_name'];}else{$name = $conv['from_name'];}
                        $html .= $name;
        $html .= '  </td>
                    <td>'.$conv['subject'].'</td>
                    <td>'.date('M-d h:i a',strtotime($conv['started_date'])).'</td>
                    <td>
                        <button onClick="showMessage('.$conv['id'].')" class="fa fa-eye" data-toggle="tooltip" title="View Message"></button>';
                        if ($type == 'Read'){
                            $html .= '<button onClick="msgarchive('.$conv['id'].')" class="fa fa-archive" data-toggle="tooltip" title="Archive this conversation"></button>';
                        }
        $html .='</td>
                </tr>';
                }
            }
        }
        echo $html;
    }
    public function archive_conversation(){
        $id = $this->input->post('id');
        if($id == ''){
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        else{
            if($this->Messanger_model->archieve_conversation($id)){
                $ajax_response['st']=1;
                $ajax_response['msg'] = "Conversation archived successfully..!";
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }
        print_r(json_encode($ajax_response));
    }

    public function get_students_by_batchid()
    {
      
       if($_POST)
       {
           $batch_id=$this->input->post('batch_id');
           $students=$this->Messanger_model->get_students_by_batchid($batch_id);
        //    print_r($this->db->last_query()); exit;
           $html="";
           if(!empty($students))
           {
               foreach($students as $row)
               {
                 $html.='<option value="'.$row['student_id'].'">'.$row['name'].'('.$row['registration_number'].')</option>';
               }
           }
           echo $html;
       }
    }
}