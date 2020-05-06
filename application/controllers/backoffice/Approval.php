

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="approval";
        check_backoffice_permission($module);
       
    }

    public function index(){
         //check_backoffice_permission('profile');
        $user_id = $this->session->userdata('user_id');
        if($user_id!=NULL){
            $this->data['staff'] = $this->common->get_staff_details_by_id($user_id);
        }
        $this->data['page']="admin/staff_view";
		$this->data['menu']="receptionist";
        $this->data['breadcrumb']="Profile";
        $this->data['menu_item']="backoffice/profile";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
/*
*   function'll list pending discount approval in center
*   @params center id
*   @author GBS-R
*
*/
    
public function discount_approval(){ 
   // print_r($_SESSION);//die();
    //check_backoffice_permission('discount_approval');
        $user_id = $this->session->userdata('user_id');
        $center  = $this->session->userdata('center');
    if($user_id == "" && $center== "")
    {
        
         $this->data['list'] = $this->Approval_model->get_approval_list_admin();
    }
    else
    {
        $this->data['list'] = $this->Approval_model->get_approval_list($center);  
    }
  //echo $this->db->last_query();die();
        $this->data['page']="admin/discount_approval_view";
		$this->data['menu']="approval";
        $this->data['breadcrumb']="Discount Approval";
        $this->data['menu_item']="backoffice/Approval";
		$this->load->view('admin/layouts/_master',$this->data);
    }    
    
/*
*   function'll show details of discount approval 
*   @params student id
*   @author GBS-R
*
*/
    
public function approval_detail_view(){ 
       // check_backoffice_permission('maintenance_amount_approval');
        $user_id = $this->session->userdata('user_id');
        $center  = $this->session->userdata('center');
        $student_id = $this->input->post('student_id');
        $course_id = $this->input->post('course_id');
    if($user_id == "" && $center== "")
    {
        
         $this->data['data'] = $this->Approval_model->get_approval_details_admin($course_id, $student_id);
    }
    else
    {
        $this->data['data'] = $this->Approval_model->get_approval_details($center, $student_id, $course_id); 
    }  
       
		echo $this->load->view('admin/approval_detail_view',$this->data, TRUE);
    } 
   
/*
*   function'll update approval status 
*   @params discount id, status
*   @author GBS-R
*
*/
    
public function update_discount_approval(){ 
        $user_id = $this->session->userdata('user_id');
        $center  = $this->session->userdata('center');
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $update = $this->Approval_model->update_approval_status($type, $id); 
        if($update) {
           echo $type; 
        } else {
            echo -1;
        }
		
    }


/*
*   function'll get maintenance service notification
*   @params center id
*   @author GBS-L
*
*/
   

public function get_notification(){
        $center  = $this->session->userdata('center');
        $list = $this->Approval_model->get_approval_nottification_list($center);
        $maintenance_requestList_director = $this->Approval_model->list_maintenance_service_list("Waiting for Approval");
        $maintenance_requestedList_OperationHead = $this->Approval_model->list_maintenance_service_list("Requested");
        $maintenance_reopenList_OperationHead = $this->Approval_model->list_maintenance_service_list("Reopen");
        $maintenance_approvedby_operationHead = $this->Approval_model->approved_maintenance_service_list("Operation Team","Approved"); 
        $maintenance_approvedby_Director = $this->Approval_model->approved_maintenance_service_list("Management","Approved");
    
        $completed_details = $this->Approval_model->list_maintenance_service_data("Completed");
        $declined_details = $this->Approval_model->list_maintenance_service_data("Declined");
        $empty = 0;
        $data = '';
        $icon = '<img src="'.base_url().'inner_assets/images/notificcationinactive.png" class="img-responsive">';
        $html ='<div id="notificationContainer">
                                <div id="notificationTitle">Notifications</div>
                                <div id="notificationsBody" class="notifications  sb-container customScrollbar">
                                <div class="">
                                    <ul>';
        if(!empty($list) && $this->session->userdata('role')=='centerhead') {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='<a href="'.base_url('backoffice/discount-approval').'">
                        <li><div class="notificationIcon"><i class="fa fa-hand-o-right"></i></div>You have a discount approval notification<span class="notification_time"></span></li>
                    </a>';
        } 
        //waiting for approval-notifcation for director
        if(!empty($maintenance_requestList_director) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "management")) {
           
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='
                        <li><a  href="'.base_url('backoffice/maintenance-amount-approval').'">You have '.$maintenance_requestList_director.' maintenance approval notification<span class="notification_time"></span></a></li>
                    ';
        } 

        
        //requested-notification for Operation Head
        if(!empty($maintenance_requestedList_OperationHead) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='
                        <li><a  href="'.base_url('backoffice/view-maintenance-services').'">You have '.$maintenance_requestedList_OperationHead.' maintenance request notification<span class="notification_time"></span></a></li>
                    ';
        } 
        //reopen-notification for Operation Head
        if(!empty($maintenance_reopenList_OperationHead) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='<li><a  href="'.base_url('backoffice/view-maintenance-services').'">You have '.$maintenance_reopenList_OperationHead.' maintenance service reopen request notification<span class="notification_time"></span></a></li>
                    ';
        }
   
         //approved-by director notification for Centre Head
        if(!empty($maintenance_approvedby_Director) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead" )) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($maintenance_approvedby_Director as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                    $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/maintenance-services').'">The maintenance service request of '.$row['description'].' has been approved <span class="notification_time"></span></a></li>';
                }
            }
                    
        }
     //approved-by director notification for operation head
        if(!empty($maintenance_approvedby_Director) && ($this->session->userdata('role') == "admin"  || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($maintenance_approvedby_Director as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                    $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/view-maintenance-services').'">The  maintenance service request of '.$row['description'].' has been approved <span class="notification_time"></span></a></li>';
                }
            }
        }
    //approved-by operation head notification for Centre Head
        if(!empty($maintenance_approvedby_operationHead) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($maintenance_approvedby_operationHead as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                    $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/maintenance-services').'">The  maintenance service request of '.$row['description'].' has been approved <span class="notification_time"></span></a></li>';  
                }
            }
        } 
    //completed-notification for Centre Head
        if(!empty($completed_details) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($completed_details as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                  $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/maintenance-services').'">The maintenance service of         '.$row['description'].' has been completed.<span class="notification_time"></span></a></li>
                    ';   
                }
               
            }
           
        }
    //declined-by director notification for Centre Head
        if(!empty($declined_details) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead" )) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           foreach($declined_details as $rows)
            {
               $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$rows['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                  $data .='<li  onclick="return read_by('.$this->session->userdata['user_id'].','.$rows['notf_id'].')"><a href="'.base_url('backoffice/maintenance-services').'" >The maintenance service of '.$rows['description'].' has been declined.<span class="notification_time"></span></a></li>
                        '; 
                }
               
            }
        }
     //declined-by director notification for operation head
        if(!empty($declined_details) && ($this->session->userdata('role') == "admin"  || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           foreach($declined_details as $rows)
            {
               $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$rows['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                  $data .='<li  onclick="return read_by('.$this->session->userdata['user_id'].','.$rows['notf_id'].')"><a href="'.base_url('backoffice/maintenance-services').'" >The maintenance service of '.$rows['description'].' has been declined.<span class="notification_time"></span></a></li>
                        ';  
                }
              
            }
        }

        if($empty == 0) {
           $data = '<li class="text-center">No notification</li>';
        }


        $html .= $data;
        $html .='</ul></div>
                    </div>
                </div><script>$(document).ready(function(){$(".sb-container").scrollBox();
});</script>';
       print_r(json_encode(array('icon'=>$icon,'data'=>$html)));

    }


    /*
*   function'll show maintenance service requests
*   @params
*   @author GBS-L
*
*/

    public function maintenance_request_approval()
    {
      
        $this->data['page']="admin/maintanence_approval_view";
		$this->data['menu']="approval";
        $this->data['breadcrumb']="Maintenance Approval";
        $this->data['menu_item']="backoffice/maintenance-approval";
        
        $this->data['requestArr']=$this->Approval_model->maintenanace_requestList_forApproval();
       // print_r($this->data['requestArr']);die();
		$this->load->view('admin/layouts/_master',$this->data);
    }
     /*
*   function'll update approval for  maintenance service requests
*   @params id
*   @author GBS-L
*
*/
    public function approve_request_byManagement()
    {
      if($_POST)
      { 
          $details=$this->Asset_model->get_maintenance_request_byId($this->input->post('id'));
          $data=array(
                        "service_id"=>$this->input->post('id'),
                       // "comments"=>$details['comments'],
                        "requested_amount"=>$details['requested_amount'],
                        "approved_status"=>"Approved",
                        "date_of_approval"=>date('Y-m-d'),
                        "approved_by"=>$this->session->userdata['user_primary_id'],
                        "approving_authority"=>"Management"
           );
          if($this->session->userdata['user_id'] =="")
          {
              $data["approved_by"]=0; 
          }
          else
          {
            $data["approved_by"]=$this->session->userdata['user_primary_id'];
          }
         
            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);

                           if($insert_id!="")
                           {
                                 $ajax_response['st']=1;
                                $ajax_response['message']="Request Approved Successfully!";
                                $query=$this->db->last_query();
                                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata('role');
                                logcreator('insert', 'Maintenance service request approved', $who, $query, $insert_id, 'assets_maintenance_service_details');
                           }

                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));
      }
    }

    //decline request
    public function decline_request_byManagement()
    {
        if($_POST)
        {
            //print_r($_POST);
            $details=$this->Asset_model->get_maintenance_request_byId($this->input->post('id'));
            $data=array(
                        "service_id"=>$this->input->post('id'),
                        "comments"=>$this->input->post('comments'),
                        "requested_amount"=>$details['requested_amount'],
                        "approved_status"=>"Declined",
                        "declined_date"=>date('Y-m-d'),
                        "approved_by"=>$this->session->userdata['user_primary_id'],
                        "approving_authority"=>"Management",
           );
            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);

                           if($insert_id!="")
                           {
                                $ajax_response['st']=1;
                                $ajax_response['message']="Request Declined Successfully!";
                                $query=$this->db->last_query();
                                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata('role');
                                logcreator('insert', 'Maintenance service request declined', $who, $query, $insert_id, 'assets_maintenance_service_details');
                           }

                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));
        }
    }

    /*This function will load the maintenance request list by ajax for DIRECTOR
    @auther GBS-L
    */
    public function load_service_request_byAjax()
    {
      $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('description').'
                            </th>
                            <th>
                                '. $this->lang->line('maintenance_type').'
                            </th>
                            <th>
                                '. $this->lang->line('centre').'
                            </th>
                            <th>
                                '. $this->lang->line('type').'
                            </th>
                            <th>
                                '. $this->lang->line('status').'
                            </th>
                            <th>
                                '. $this->lang->line('requested_date').'
                            </th>
                            <th>
                                '. $this->lang->line('allowed_amount').'
                            </th>
                            <th nowrap>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>';
        //$data=$this->Asset_model->get_allmaintenanace_requestList();
        $data=$this->Approval_model->maintenanace_requestList_forApproval();
         if(!empty($data))
         {

            $i=1;
             foreach($data as $rows)
             {
                 $current_status=$this->common->get_last_data('assets_maintenance_service_details','approved_status',array("service_id"=>$rows['service_id']),'id','desc');
                $status="" ;
                 if ($current_status=="Requested") {
                                $status.= '<span class="inactivestatus">'.$this->lang->line('requested').'</span>';
                            }
                            else if($current_status=="Waiting for Approval") {
                                $status.= '<span class="paymentcompleted">'.$this->lang->line('waiting_for_approval').'</span>';
                            }
                            else if($current_status== "Approved") {
                                $status.= '<span class="admitted">'.$this->lang->line('approved').'</span>';
                            }
                            else if($current_status== "Completed") {
                                $status.= '<span class="batchchanged">'.$this->lang->line('completed').'</span>';
                            }
                            else if($current_status== "Reopen")
                            {
                                $status.= '<span class="registered">'.$this->lang->line('reopened').'</span>';
                            } else if($current_status== "Declined")
                            {
                                $status.= '<span class="declined">'.$this->lang->line('declined').'</span>';
                            }
                     $action="";

                     if ($current_status=="Waiting for Approval")
                     {
                        $action.='<select name="status" class="form-control tableSelect c_status" onchange="change_status('.$rows['service_id'].');" id="id_'.$rows['service_id'].'">
                        <option>Select</option><option value="Accept">Accept</option><option value="Decline">Decline</option></select>';
                     }


                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['description'].'</td>
                        <td>'.$rows['maintenanacetype_name'].'</td>
                        <td>'.$rows['institute_name'].'</td>
                        <td>'.$rows['type'].'</td>
                        <td>'.$status.'</td>
                        <td>'.date('d/m/Y',strtotime($rows['created_on'])).' </td>
                        <td>'.numberformat($rows['allowed_amount']).' </td>
                        <td nowrap>
                        <button type="button" class="btn btn-default option_btn " onclick="show_request_data('. $rows['service_id'].')" title="Click here to view the details" > <i class="fa fa-eye "></i></button>'.$action.'

                        </td>
                        </tr>';
                 $i++;
             }
         }
        echo $html;
    }

    public function read_notification()
    {
        if($_POST)
        {
           
            $this->Common_model->insert('am_notification', $_POST);
            
        }
    }
    
     //get maintenance request details by id
    public function get_maintenance_request_byId()
    {

        if($_POST)
        {
            $id=$this->input->post('id');
           // echo $id;
            $history_data=$this->common->get_alldata('assets_maintenance_service_details', array("service_id"=>$id)); 
            //echo "<pre>"; print_r($history_data);
            $ajax_response['history']='';
             $ajax_response['old_dates']='';
            $ajax_response['old_amount_requested']='';
            $ajax_response['old_amount_taken']='';
            $approved_by='';
            if(!empty($history_data))
            {  $i=1;
                foreach($history_data as $val)
                {
                    if(!empty($val['approved_by']))
                    {
                       /* $approved_userdetail=$this->common->get_from_tablerow('am_staff_personal',array("personal_id"=>$val['approved_by']));

                        $role=$this->common->get_name_by_id('am_roles','role_name',array("role"=>$approved_userdetail['role']));
                        $approved_by=$approved_userdetail['name']."(".$role.")";*/
                        $approved_userdetail=$this->common->get_from_tablerow('am_users_backoffice',array("user_id"=>$val['approved_by']));
                           
                           
                            $approved_by=$approved_userdetail['user_name'];
                    }
                   $date= date("d/m/Y",strtotime($val['created_on']));
                   $ajax_response['history'].='<tr><td>'.$i.'</td><td>'.$date.'</td><td>'.$val['approved_status'].'</td><td>'.$val['comments'].'</td><td>'.$val['approving_authority'].'</td><td>'.$approved_by.'</td></tr>';
                     if($val['date_of_completion']!=""){
                    $ajax_response['old_dates'].='<label>'.date("d/m/Y",strtotime($val['date_of_completion'])).'</label><br>';
                    }
                     if($val['requested_amount']!="" && $val['approved_status']=="Waiting for Approval"){
                    $ajax_response['old_amount_requested'].='<label>INR '.$val['requested_amount'].'</label><br>';
                     }
                    if($val['total_amount']!=""){
                    $ajax_response['old_amount_taken'].='<label>INR '.$val['total_amount'].'</label><br>';
                     }
                    $i++;
                }
            }
            $data=$this->Asset_model->get_maintenance_request_byId($id);
            if($data['date_of_approval']!="")
            {
                $data['date_of_approval']=date("d/m/Y",strtotime($data['date_of_approval']));
            }
             if($data['date_of_completion']!="")
            {
                $data['date_of_completion']=date("d/m/Y",strtotime($data['date_of_completion']));
            }
            if($data['requested_amount']!="")
            {
                $data['requested_amount']=numberformat($data['requested_amount']);
            }
            if($data['total_amount']!="")
            {
                $data['total_amount']=numberformat($data['total_amount']);
            }
            if($data['allowed_amount']!="")
            {
                $data['allowed_amount']=numberformat($data['allowed_amount']);
            }

             $data['created_on']=date("d/m/Y",strtotime($data['created_on']));
            
               if($val['approved_by']!= "")
                    { 
                        if($val['approved_by'] != 0)
                        {
                          
                            $approved_userdetail=$this->common->get_from_tablerow('am_users_backoffice',array("user_id"=>$val['approved_by']));
                           
                            $approved_by=$approved_userdetail['user_name']."(".$approved_userdetail['user_role'].")";
                        }
                        else
                        {
                          $approved_by="Admin";  
                        }
                    }
                    else
                    {
                        $approved_by='';
                    }
            
            $ajax_response['data']=$data;
            


            $ajax_response['centre_name']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$data['institute_id']));
            $branch_id=$this->common->get_name_by_id('am_institute_master','parent_institute',array("institute_master_id"=>$data['institute_id']));
            $group_id=$this->common->get_name_by_id('am_institute_master','parent_institute',array("institute_master_id"=>$branch_id));
            $ajax_response['branch_id']=$branch_id;
            $ajax_response['group_id'] =$group_id;
            
            $branchArr=$this->institute_model->get_allsub_byparent(array("parent_institute"=>$group_id));
      
           $branch_html="";
           if(!empty($branchArr)){
                foreach ($branchArr as $row)
                {
                     $branch_html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                }
            }
            $ajax_response['branches']=$branch_html;
            
             $centreArr=$this->institute_model->get_allsub_byparent(array("parent_institute"=>$branch_id));
             
             $centre_html="";
             if(!empty($centreArr))
             {
                foreach ($centreArr as $row)
                {
                     $centre_html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                }
             }
            $ajax_response['centres']=$centre_html;
            
            
           // echo $this->db->last_query();
            print_r(json_encode($ajax_response));
        }
    }
    
    public function load_discount_approval()
    {
       $html = '<thead><tr>
                <th width="50">'.  $this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('student_name').'</th>
                <th>'.$this->lang->line('course').'</th>
                <th>'.$this->lang->line('place').'</th>
                <th>'.$this->lang->line('centre').'</th>
                <th>'.$this->lang->line('status').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
        $user_id = $this->session->userdata('user_id');
        $center  = $this->session->userdata('center');
    if($user_id == "" && $center== "")
    {
        
        $data = $this->Approval_model->get_approval_list_admin();
    }
    else
    {
        $data = $this->Approval_model->get_approval_list($center);  
    }
        if(!empty($data))
        {
            $i=1;
            foreach($data as $row)
            {
                if($row->discount_status==1) {
                    $status= '<span class="admitted">Approved</span>'; 
                }
                else if($row->discount_status==2)
                { 
                    $status= '<span class="declined">Declined</span>';
                }
                 else 
                { 
                $status= '<span class="inactivestatus">Pending</span>';
                 }
                $html.='<tr>
                       <td>'.$i.'</td>
                       <td>'. $row->name.'</td>
                       <td>'.$row->class_name.'</td>
                       <td>'.$row->street.', '.$row->city.'</td>
                       <td>'.$row->institute_name.'</td>
                       <td>'.$status.'</td>
                       <td><span class="btn mybutton " onclick="getapprovaldetails('.$row->student_id.','.$row->course_id.')" data-toggle="modal" data-target="#show" >Manage</span></td>
                       </tr>';
                $i++;
            }
        }
        echo $html; 
    }
    public function material_approval()
    {
        check_backoffice_permission('material_approval');
        $this->data['page']="admin/material_approval_view";
		$this->data['menu']="approval";
        $this->data['breadcrumb']="Material Approval";
        $this->data['menu_item']="backoffice/material-approval";
        $this->data['entitiyArr']=$this->Approval_model->get_entities();
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function material_approval_level($id = NULL)
    {
        $this->data['page']="admin/material_approval_level";
        $this->data['menu']="approval";
        $this->data['breadcrumb'][0]['name']="Material Approval";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-approval');
        if($id == 1){
            $this->data['breadcrumb'][1]['name']="Question Set Level";
        }else if ($id == 2){
            $this->data['breadcrumb'][1]['name']="Learning Module Level";
        }else if ($id == 3){
            $this->data['breadcrumb'][1]['name']="Exam Paper Level";
        }
        
        $this->data['menu_item']="backoffice/question-set-approval-levels";
        $this->data['entitiyArr']=$this->Approval_model->get_entities_byID($id);
        $this->data['roleArr']=$this->Approval_model->get_designation();
        // show($this->data['roleArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_approvel_user(){
        $role = $this->input->post('role');
        $html = '';
        $users = $this->Approval_model->get_approvel_user($role);
        // echo $this->db->last_query(); exit;
        // show($users);
        $html = '<option value="">Select</option>';
        if(!empty($users)) {
            foreach($users as $user){
                $html .='<option value="'.$user->user_id.'">'.$user->user_name.'( '.$user->registration_number.' )</option>';
            }
        }
        echo $html;
    }
    public function add_user_to_approvel_detail(){
        if($_POST){
            $data=array();
            $data['flow_entities']= $this->input->post('entity_id');
            $data['level']= $this->input->post('level'); 
            $data['user_id']= $this->input->post('user');
            $checkDuplication = $this->Approval_model->checkDuplication($data['flow_entities'],$data['level'],$data['user_id']);
            if($checkDuplication){
                $response = $this->Common_model->insert('approval_flow_entity_details', $data); 
                if($response != 0)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully added data";
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $response, 'approval_flow_entity_details');
                }
                else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";
                } 
            }else{
                $ajax_response['st']=2;
                $ajax_response['msg']="User already exist!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function get_approvel_user_foreach_level(){
        $level = $this->input->post('level');
        $id = $this->input->post('id');
        $html = '';
        $users = $this->Approval_model->get_approvel_user_foreach_level($level, $id);
        $html .= '<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                             <b>'.$this->common->get_name_by_id('approval_flow_entities','entity_name',array('id'=>$id)).'
                             - <b><i>Level '.$level.'</i></b>
                             </b>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <b>Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></b>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <div class="form-group">';
        if(!empty($users)){
            $i = 0;
            foreach($users as $user){
                $user->user_id = $this->common->get_name_by_id('am_users_backoffice','user_name',array('user_id'=>$user->user_id)).' ( '. $this->common->get_name_by_id('am_users_backoffice','registration_number',array('user_id'=>$user->user_id)) .' )';
                $html .= '<b>'.++$i.' - '.$user->user_id.'</b><br>';
            }
            $html .= '</div>
            </div></div>';
        }else{
            $html .= '<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <div class="form-group">
                            <span><b style="color:red;">No users found!</b></span>
                        </div>
                    </div></div>';
        }
        echo $html;
    }
    public function get_approvel_user_edit(){
        $level = $this->input->post('level');
        $id = $this->input->post('id');
        $html = '';
        $users = $this->Approval_model->get_approvel_user_foreach_level($level, $id);
        $html .= '<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                             <b>'.$this->common->get_name_by_id('approval_flow_entities','entity_name',array('id'=>$id)).'
                             - <b><i>Level '.$level.'</i></b>
                             </b>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <b>Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></b>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <div class="form-group">';
        if(!empty($users)){
            $i = 0;
            foreach($users as $user){
                $user->user_id = $this->common->get_name_by_id('am_users_backoffice','user_name',array('user_id'=>$user->user_id)).' ( '. $this->common->get_name_by_id('am_users_backoffice','registration_number',array('user_id'=>$user->user_id)) .' )';
                $html .= '<div class="row"><div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                            '.++$i.' - <span class="btn mybutton  mybuttonActive">'.$user->user_id.'</span><br>
                            <div class="form-group">
                            </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <a style="cursor: pointer;" onclick="remove_user('.$user->id.','.$id.','.$level.')" title="Remove user ?"><i class="fa fa-remove" style="color:red;"></i></a>
                            <div class="form-group">
                            </div>
                          </div></div>';
            }
            $html .= '</div>
            </div></div>';
        }else{
            $html .= '<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <div class="form-group">
                            <span><b style="color:red;">No users found!</b></span>
                        </div>
                    </div></div>';
        }
        echo $html;
    }
    public function remove_user_from_level(){
        if($_POST){
            $id = $this->input->post('remove_id');
            $res = $this->common->delete('approval_flow_entity_details', array('id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'approval_flow_entity_details');
                $ajax_response['st']=1;
                $ajax_response['msg']="User removed successfully!";

            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!1";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
}
