<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Call_center extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="call_center";
        check_backoffice_permission($module);
        $this->load->model('call_center_model');
        $this->load->model('institute_model');

        $this->load->model('staff_enrollment_model');
        date_default_timezone_set('Asia/Karachi');
       
    }

    public function index($id=NULL,$date = ""){
        if($id!=NULL){
            $this->data['callEdit'] = $this->call_center_model->get_call_centerdetails_by_id($id);
            // $followup_array=$this->call_center_model->get_followupdetails_by_id($table_row_id);
            // echo '<pre>';
            // print_r($this->data['callEdit']);
            // die();
        }
        if($date == ""){
            $date=date('Y-m-d');
          }
        
       
          $user_id            = $this->session->userdata('user_id');
          
        $this->data['cce']  = $this->common->get_staff_list_by_roles(array('cce','cch'));
        $this->data['inprogress']   = 0;
        $this->data['unnecessary']  = 0;
        $this->data['register']     = 0;
        $this->data['closed']       = 0;
        $this->data['userid']       = $user_id;
        if($this->session->userdata('role')=='cce') {
        $this->data['total']        = $this->common->get_totalconversionrate_cce($date, $user_id); 
        $calls                      = $this->common->get_progresscall(2,$user_id);
        $closed                     = $this->common->get_progresscall(3,$user_id);
        $unnecessary                = $this->common->get_progresscall(4,$user_id);
        $register                   = $this->common->get_progresscall(5,$user_id);
        } else {
        $this->data['myrate']       = $this->common->get_totalconversionrate_cce($date, $user_id);     
        $this->data['total']        = $this->common->get_totalconversionrate($date); 
        $calls                      = $this->common->get_progresscall(2); 
        $closed                     = $this->common->get_progresscall(3); 
        $unnecessary                = $this->common->get_progresscall(4); 
        $register                   = $this->common->get_progresscall(5); 
        }
        $this->data['inprogress']   = count($calls);
        $this->data['unnecessary']  = count($unnecessary);
        $this->data['register']     = count($register);
        $this->data['closed']       = count($closed);
        $role = $this->session->userdata('role');
        $this->data['page']="admin/call_center";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Manage Calls";
        $this->data['menu_item']="backoffice/manage-calls";
        $this->data['call_centerArr']=$this->call_center_model->get_call_center_list($user_id, $role); 
        // echo $this->db->last_query();
        // $this->data['courseArr']=$this->call_center_model->get_course_list();
        $this->data['courseArr']=$this->call_center_model->getall_list();
       
        // $this->data['cityArr']=$this->common->get_districts();
        $callArr=$this->call_center_model->get_call_centerdetails_by_id($id);
        $this->data['roleArr']=$this->common->get_roles();
        // $this->data['usersArr']=$this->staff_enrollment_model->get_users_list();
        $this->data['usersArr']=$this->common->get_staff_list_by_roles();
        $this->data['staffArr']=$this->staff_enrollment_model->get_staff_list();
        $this->data['stateArr']=$this->common->get_all_states(19);
        $this->data['citiesArr']=$this->common->get_from_table('cities',array('state_id'=>19));
        $state_id=$callArr['state'];
        // echo '<pre>';
        // print_r($this->data['call_centerArr']);
        // die();
        // $this->data['DistrictArr']=$this->common->get_district_bystate($state_id);
        $this->data['DistrictArr']=$this->common->get_dist_bystate(19);

        // $course_id  = $this->input->post('course_id');
        // $this->data['branchArr']   = $this->call_center_model->get_all_branches($course_id);
		$this->load->view('admin/layouts/_master',$this->data); 
    }

    public function get_district_bystate()
     {
        $id=$this->input->post('state_id');
        $DistrictArr=$this->common->get_district_bystate($id);
        echo '<option value="" selected="selected">Select District</option>';
        foreach($DistrictArr as $row)
        {
          echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
     }

     public function get_city(){
        $selected = $_POST['selected'];
        if($selected=='19'){
            $this->db->select('*');
            $this->db->where('state_id','19');
            // $this->db->where('id','1947');
            $this->db->order_by('name');
            $cities = $this->db->get('cities')->result_array();
                echo '<option value="" >Select City</option>';
                foreach($cities as $row){ 
                    if($selected == $row['id']){
                        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
                    }else{
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
                }
        }else{
        $this->db->select('*');
        $this->db->where('state_id',$_POST['id']);
        $this->db->order_by('name');
        $cities = $this->db->get('cities')->result_array();
            echo '<option value="" >Select City</option>';
            foreach($cities as $row){ 
                if($selected == $row['id']){
                    echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
                }else{
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
            }
        } 
    }

//     public function get_branch(){
//         $selected = $_POST['selected'];
//        $this->db->select('*');
//        $this->db->where('course_id',$_POST['class_id']);
//        $this->db->order_by('institute_name');
//        $branch = $this->db->get('am_institute_course_mapping')->result_array();
//            echo '<option value="" >Select Branch</option>';
//            foreach($cities as $row){ 
//                if($selected == $row['id']){
//                    echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
//                }else{
//                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
//                }
//            }
//    }

public function description_add()
{
    if($_POST){
        $data = $_POST;
        $description_exist = $this->call_center_model->is_description_exist($data);
        if($description_exist == 0){ 
            $enquiry_id = $this->input->post('enquiry_id');
            $status = $this->input->post('status');
            // $query = $this->db->select('status');
            //         $this->db->from('cc_enquiries');
            //         $this->db->where('enquiry_id', $enquiry_id);
            //         $row_id= $query->num_rows();
            $this->db->select('*');
            $this->db->where('enquiry_id',$enquiry_id);
            $query = $this->db->get('cc_enquiries')->row_array();
            // echo $this->db->last_query();
            $data['status'] = $query['status'];
            // print_r($data['status']);
            // print_r($query['status']);
            $res = $this->call_center_model->description_add($data);
        // $this->data['followupArr'] = $this->call_center_model->followup_add($data);
        // echo '<pre>';
        // print_r($res);
        // die();
        $enquiry_id = $this->input->post('enquiry_id');
        if($res = 1){
            $what = $this->db->last_query();
            $table_row_id = $this->db->insert_id();
            $this->db->where('enquiry_id', $enquiry_id);
            $this->db->update('cc_enquiries', array('enquiry_type'=> 0));
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('insert', 'database', $who, $what, $table_row_id, 'cc_callback_description');
            $description_array=$this->call_center_model->get_descriptiondetails_by_id($table_row_id,$data);
        // echo $this->db->last_query();
        // print_r($this->data['description_array']);
        // die();
        print_r(json_encode($description_array));
            
        }
    }else{
        $html=2;//already exist
    }
        print_r($res);
    }
}

// public function load_cc_ajax() {
//     $html = '<thead>
//                 <tr>
//                     <th>Sl. No.</th>
//                     <th>Name</th>
//                     <th>Course</th>
//                     <th>Primary Contact</th>
//                     <th>Street</th>
//                     <th>Enquiry Type</th>
//                     <th>Status</th>
//                     <th>Action</th>
//                 </tr>
//             </thead>';
//         $user_id            = $this->session->userdata('user_id');
//         $role = $this->session->userdata('role');
//         $call_centerArr=$this->call_center_model->get_call_center_list($user_id, $role); 

//         if(!empty($call_centerArr)) {
//         $i=1;
//         foreach($call_centerArr as $calls) {
//           $html .= '<tr>
//             <td>'.$i.'</td>
//             <td>'.$calls['name'].'</td>
//             <td>'.$calls['class_name'].'</td>
//             <td>'.$calls['primary_mobile'].'</td>
//             <td>'.$calls['street'].'</td>
//             <td>'.$calls['enquiry_type'].'</td>
//             <td>'.$calls['primary_mobile'].'</td>';
//              if($calls['call_status']==1){
//                 echo '<option selected value="1">Call Received</option>
//                     <option value="2">In Progress</option>
//                     <option value="3">Closed</option>
//                     <option value="4">Blacklisted</option>
//                     <option value="5">Registered</option>
//                     <option value="6">Admitted</option>';
//             }else if($calls['call_status']==2){
//                 echo '<option selected value="2">In Progress</option>
//                     <option value="1">Call Received</option>
//                     <option value="3">Closed</option>
//                     <option value="4">Blacklisted</option>
//                     <option value="5">Registered</option>
//                     <option value="6">Admitted</option>';
//             }else if($calls['call_status']==3){
//                 echo '<option selected value="3">Closed</option>
//                     <option value="1">Call Received</option>
//                     <option value="2">In Progress</option>
//                     <option value="4">Blacklisted</option>
//                     <option value="5">Registered</option>
//                     <option value="6">Admitted</option>';
//             }else if($calls['call_status']==4){
//                 echo '<option selected value="4">Blacklisted</option>
//                     <option value="1">Call Received</option>
//                     <option value="2">In Progress</option>
//                     <option value="3">Closed</option>
//                     <option value="5">Registered</option>
//                     <option value="6">Admitted</option>';
//             }else if($calls['call_status']==5){
//                 echo '<option value="4">Blacklisted</option>
//                     <option value="1">Call Received</option>
//                     <option value="2">In Progress</option>
//                     <option value="3">Closed</option>
//                     <option selected value="5">Registered</option>
//                     <option value="6">Admitted</option>';
//             }else if($calls['call_status']==6){
//                 echo '<option  value="4">Blacklisted</option>
//                     <option value="1">Call Received</option>
//                     <option value="2">In Progress</option>
//                     <option value="3">Closed</option>
//                     <option value="5">Registered</option>
//                     <option selected value="6">Admitted</option>';
//             }else{
//                 echo '<option value="">Select Status</option>
//                     <option value="1">Answered</option>
//                     <option value="2">No Answer</option>
//                     <option value="3">Busy</option>
//                     <option value="4">Blacklisted</option>
//                     <option value="5">Registered</option>
//                     <option value="6">Admitted</option>';
//             }
//             $html .= '  <td>
//                             <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$calls['call_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;">
//                                 <i class="fa fa-eye "></i>
//                             </button>
//                             <button type="button" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$calls['call_id'].')">
//                                 <i class="fa fa-pencil "></i>
//                             </button>
//                             <a class="btn btn-default option_btn  " onclick="delete_call_centers('.$calls['call_id'].')">
//                                 <i class="fa fa-trash-o"></i>
//                             </a>
//                             <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$calls['call_id'].');  formclear('add_followup');">
//                                 Follow Up
//                             </button>
//                         </td>
//         </tr>'; 
//             $i++;
//         }
//     }
//     echo $html;
// }

    public function call_center_add()
    {
        if($_POST){
            $data = $_POST;
            // echo '<pre>';
            // print_r($data);
            // die();
            if($data['user_id']=='') {
                $data['user_id'] = 0;
            }
            if(isset($data['timing'])){
                if($data['timing'] != ""){
                    $data['timing'] = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$data['timing'])));
                }
            }
            if(isset($data['branch_name'])){
                if($data['branch_name'] != ""){
                    $data['branch_name'] = $this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$branch_id,"status"=>1));  
                }else{
                    $data['branch_name'] = 0;
                }
            }
            // }else{
            //         $status = "";
            //     }
               
            $call_center_exist = $this->call_center_model->is_call_center_exist($data);
            if($call_center_exist == 0){ 
                $res = $this->call_center_model->call_center_add($data); 
                if($res = 1){
                    $what = $this->db->last_query();
                    // $sel =$this->db->select(COUNT('*'));
                    $table_row_id = $this->db->insert_id();
                    // $count = $table_row_id['COUNT(*)'];
                    // $count = $this->db->select(count('*'));
                    // $this->db->from('cc_call_center_enquiries');

                    // print_r($count);
                    
                    // if($this->session->userdata('role')=='cch') {
                        $query = $this->db->select('*');
                        $this->db->where('status', '1');
                        $query	=	$this->db->get('cc_call_center_enquiries');
                        $row_id= $query->num_rows();
                    // }
                    // echo $query->num_rows();
                    // echo $this->db->last_query();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'cc_call_center_enquiries');
                    $call_center_array= $this->call_center_model->get_call_centerdetails_by_id($table_row_id);
                    // echo $this->db->last_query();
                    // print_r($call_center_array);
                    // die();
                
                    if($call_center_array['status']==1){
                        $status = '<select class="form-control"><option selected value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="4">Un necessary</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option></select>';
                    }else if($call_center_array['call_status']==2){
                        $status = '<select class="form-control"><option selected value="2">In Progress</option>
                        <option value="1">Call Received</option>
                        <option value="3">Closed</option>
                        <option value="4">Un necessary</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option></select>';
                    }else if($call_center_array['call_status']==3){
                        $status = '<select class="form-control"><option selected value="3">Closed</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="4">Un necessary</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option></select>';
                    }else if($call_center_array['call_status']==4){
                        $status = '<select class="form-control"><option selected value="4">Un necessary</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option></select>';
                    }else if($call_center_array['call_status']==5){
                        $status = '<select class="form-control"><option value="4">Un necessary</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option selected value="5">Registered</option>
                        <option value="6">Admitted</option></select>';
                    }else {
                        $status = '<select class="form-control"><option  value="4">Un necessary</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="5">Registered</option>
                        <option selected value="6">Admitted</option></select>';
                    }
              
                    if($call_center_array['class_name']!= ''){
                        $class = $call_center_array['class_name'];
                    }else{
                        $class = "";
                    }
                    if($call_center_array['timing']== NULL){
                        $new_date = "";
                    }else{
                        $date=strtotime($call_center_array['timing']); 
                        $new_date = date("d/m/Y h:i:s A",$date);
                    }
                    $html='<li id="row_'.$table_row_id.'">
                                <div class="col sl_no "> '.$row_id.' </div>
                                <div class="col "> <a href ="" onclick="get_details('.$table_row_id.')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;"> '.$call_center_array['name'].'</a></div>

                                <div class="col " >'.$class .' </div>
                                <div class="col " >'.$call_center_array['primary_mobile'] .' </div>
                                <div class="col " >'.$call_center_array['street'] .' </div>
                                <div class="col " >'.$call_center_array['enquiry_type'].' </div>
                                <div class="col " ><div class="form-group form_zero">'.$status.'</div> </div>
                                <div class="col actions ">
                                <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$table_row_id.')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;">
                            <i class="fa fa-eye "></i>
                        </button>
                                    <button type="button" class="btn btn-default option_btn "  onclick="get_editdata('.$table_row_id.')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_call_centers('.$table_row_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$table_row_id.')">
                                        Follow Up
                                    </button>
                                </div>
                            </li>
                            <button class="btn btn-default add_row btn_map btn_print" id="export" type="submit"><i class="fa fa-upload"></i> Export</button>
                            ';
                   
                            // if($row_id!=1){
                            //     $html='      <button class="btn btn-default add_row btn_map btn_print" id="export" type="submit">
                            //     <i class="fa fa-upload"></i> Export
                            // </button>';
                            // }
                     
                            
                    // }
                    // <button class="btn btn-default add_row btn_map btn_print " type="submit">
                            //     <i class="fa fa-upload"></i> Export
                            // </button>
                }
            }else{
                $html=2;//already exist
            }
            print_r($html); 
        }
    }

    public function delete_call_centers()
    {
        $id  = $_POST['id'];
        $res = $this->call_center_model->delete_call_centers($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'cc_call_center_enquiries');
            
        }
        print_r($res);    
    }

    

    public function delete_followup()
    {
        $id  = $_POST['followup_id'];
        $res = $this->call_center_model->delete_followup($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'cc_followup');
        }
        print_r($res);    
    }

    public function call_centers_edit()
    {
        if($_POST){
            $id = $this->input->post('call_id');
            unset($_POST['call_id']);
            $data = $_POST;
        if(isset($data['timing'])){
            if($data['timing'] != ""){
                $data['timing'] = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$data['timing'])));
            }
        }
        if(isset($data['branch_id'])){
            if($data['branch_id'] != ""){
                $data['branch_id'] = $data['branch_id'];
            }else{
                $data['branch_id'] = 0;
            }
        }

        if(isset($data['center_id'])){
            if($data['center_id'] != ""){
                $data['center_id'] = $data['center_id'];
            }else{
                $data['center_id'] = 0;
            }
        }




            // $data['timing'] = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$data['timing'])));
            $res = $this->call_center_model->edit_call_centers($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'cc_call_center_enquiries');
            }
            print_r($res);
        }
    }
    public function get_call_center_by_id($call_id){
        // $call_center_array['timing'] = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$call_center_array['timing'])));
        $call_center_array= $this->call_center_model->get_call_center_by_id($call_id);

        $call_center_array['branchoption'] = '';
        $call_center_array['centeroption'] = '';
        if($call_center_array){
            $branch = $this->common->get_branch_basedon_course($call_center_array['course_id'],$call_center_array['branch_id']);
            $call_center_array['branchoption'] = $branch;
            $branch = $this->common->get_branch_basedon_course($call_center_array['course_id'],$call_center_array['branch_id']);
            $centers    =   $this->common->get_centerby_branch_course($call_center_array['course_id'],$call_center_array['branch_id'],$call_center_array['center_id']); 
            $call_center_array['centeroption'] = $centers;
        }
        $user_id=$call_center_array['user_id'];
        $course_id=$call_center_array['course_id'];
        $branch_id=$call_center_array['branch_id'];
        $center_id=$call_center_array['center_id'];
        $state=$call_center_array['state'];
        $city=$call_center_array['district'];
        $call_center_array['user_id'] = '';
        if($user_id>0) {
            $staff = $this->common->get_from_tablerow('am_staff_personal', array('personal_id'=>$user_id));
            $call_center_array['user_id'] = $staff['name'];
        }
        if(!empty($course_id))
        {
           $call_center_array['course_name']=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$course_id,"status"=>1));  
        }
        if(!empty($branch_id))
        {
           $call_center_array['branch_name']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$branch_id,"status"=>1));  
        }else{
            $call_center_array['branch_name']="" ;
        }
        if(!empty($center_id))
        {
           $call_center_array['center_name']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$center_id,"status"=>1));  
        }else{
            $call_center_array['center_name']="" ;
        }
        if(!empty($state))
        {
          $call_center_array['state_name']=$this->common->get_name_by_id('states','name',array("id"=>$state));  
        } 
        if(!empty($city))
        {
          $call_center_array['city_name']=$this->common->get_name_by_id('cities','name',array("id"=>$city));  
        }
        if(isset($call_center_array['timing'])){
            if($call_center_array['timing'] != ""){
                $call_center_array['timing'] = date("d/m/Y h:i:s A",strtotime($call_center_array['timing']));
            }
        }
        // if(isset($call_center_array['branch_name'])){
        //     if($call_center_array['branch_name'] != ""){
        //         $call_center_array['branch_name'] = $this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$branch_id,"status"=>1));  
        //     }else{
        //         $data['branch_name'] = 0;
        //     }
        // }

        //  $call_center_array['timing']=date('d/m/Y h:i A',strtotime($call_center_array['timing']));
        // echo '<pre>';
        // print_r($call_center_array);
        // die();

        print_r(json_encode($call_center_array));
    }
    public function get_followup_by_id($followup_id){
        $followup_array= $this->call_center_model->get_followup_by_id($followup_id);
        print_r(json_encode($followup_array));
        //  echo $this->db->last_query();
    }

    public function get_course_by_id($class_id)
    {
        $course_array= $this->call_center_model->get_course_by_id($class_id);
        print_r(json_encode($course_array)); 
        
    }

    public function get_city_by_id($city_id)
    {
        $city_array= $this->call_center_model->get_city_by_id($city_id);
        print_r(json_encode($city_array)); 
        
    }

    
    /*manage query*/
    
    public function manage_query()
    {
        $this->data['page']="admin/manage_queries";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Manage Queries";
        $this->data['menu_item']="backoffice/manage-queries";
        $this->data['queryArr']=$this->call_center_model->get_all_queries();
		$this->load->view('admin/layouts/_master',$this->data);  
    }
       /*manage call backs*/
    public function manage_callbacks()
    {
        $this->data['page']="admin/manage_callbacks";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Manage Call Backs";
        $this->data['menu_item']="backoffice/manage-callbacks";
        $this->data['callbackArr']=$this->call_center_model->get_all_callbacks();
        // $call_id = $this->input->post('call_id');
        // echo '<pre>';
        // print_r($this->data['callbackArr']);
        // die();
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    /*get query details by id*/
    public function get_query_by_id($id)
    {
       $query_details=$this->call_center_model->get_query_by_id($id);
        return print_r(json_encode($query_details));
    }
    /*get callback details by id*/
    public function get_callbacks_by_id($id)
    {
        $this->data['callback_details']=$this->call_center_model->get_callbacks_by_id($id);
        // echo $this->db->last_query();
        // die();
        $enquiry_id = $this->input->post('enquiry_id');
        // $status = $this->input->post('status');
            $this->db->select('*');
            $this->db->where('enquiry_id',$enquiry_id);
            $query = $this->db->get('cc_enquiries')->row_array();
            // echo $this->db->last_query();
            $data['status'] = $query['status'];
        $this->data['description_details']=$this->call_center_model->get_descriptiondetails_by_id($id,$data);
        // echo $this->db->last_query();

        print_r(json_encode($this->data));
    //    print_r($callback_details);
    //    die();
    }

    public function followup_add()
    {
        if($_POST){
            $data = $_POST;
            $followup_exist = $this->call_center_model->is_followup_exist($data);
            if($followup_exist == 0){ 
            $res = $this->call_center_model->followup_add($data);
            // $this->data['followupArr'] = $this->call_center_model->followup_add($data);
            // echo '<pre>';
            // print_r($res);
            // die();
            $call_id = $this->input->post('call_id');
            if($res = 1){
                $what = $this->db->last_query();
                $table_row_id = $this->db->insert_id();

                $query= $this->db->get_where('cc_call_center_enquiries',array('call_id'=>$call_id));
                $data = $query->row_array();
                // print_r($query->row_array());die();
                $this->db->where('call_id', $call_id);
                if($data['call_status'] == 1 ||$data['call_status'] == 2 || $data['call_status'] == 3 || $data['call_status'] == 4){
                    $this->db->update('cc_call_center_enquiries', array('call_status'=>2));
                }
                
                
                $query = $this->db->select('*');
                $this->db->where('followup_status', '1');
                $this->db->where('call_id', $call_id);
                $query	=	$this->db->get('cc_followup');
                $row_id= $query->num_rows();
                
                
                
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'database', $who, $what, $table_row_id, 'cc_followup');
                $followup_array=$this->call_center_model->get_followupdetails_by_id($table_row_id);
                if($followup_array['status'] == '1'){
                    $status = "Answered";
                }else if($followup_array['status'] == '2'){
                    $status = "No Answer";
                }else{
                    $status = "Busy";
                }
                $html='<tr id="row_'.$table_row_id.'">
                                <td>'.$row_id.'</td>
                                <td>'.$followup_array['date'].'</td>
                                <td>'.$status.'</td>
                                <td>'.$followup_array['comment'].'</td>
                                <td>
                                    <a class="btn btn-default option_btn" title="Delete" style="width:auto;" onclick="delete_followup('.$table_row_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>';
            }
        }else{
            $html=2;//already exist
        }
            print_r($html);
        }
    }

    public function get_val()
    {
        if($_POST){
            $id = $this->input->post('id');
            $selectid = $this->input->post('selectid');
            // $this->db->select('*');
            // $this->db->where('enquiry_id',$enquiry_id);
            // $query = $this->db->get('cc_enquiries')->row_array();
            $data['call_status'] = $selectid;
            $res = $this->call_center_model->edit_call_centers($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'cc_call_center_enquiries');
            }
            print_r($res);

        }
    }

    public function get_callback_val()
    {
        if($_POST){
            $id = $this->input->post('id');
            $selectid = $this->input->post('selectid');
            // $this->db->select('*');
            // $this->db->where('enquiry_id',$id);
            // $query = $this->db->get('cc_enquiries')->row_array();
            $data['status'] = $selectid;
            // print_r($data['status']);

            $res = $this->call_center_model->edit_call_backs($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'cc_enquiries');
            }
            print_r($res);
        }
    }

    public function get_query_val()
    {
        if($_POST){
            $id = $this->input->post('id');
            $selectid = $this->input->post('selectid');
            $data['status'] = $selectid;
            $res = $this->call_center_model->edit_query($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'cc_enquiries');
            }
            print_r($res);
        }
    }

    public function fetch()
    {
        $query= $this->db->get_where('am_staff_personal',array("role"=>'5'));
        $output = '';
        $filter_name = '';
        $filter_course = '';
        $filter_number = '';
        $filter_status = '';
        $filter_sdate = '';
        $filter_edate = '';
        $filter_enquiry = '';
        $filter_place = '';
        $filter_cce = '';

        $filter_name = $this->input->post('filter_name');
        $filter_course = $this->input->post('filter_course');
        $filter_number = $this->input->post('filter_number');
        $filter_status = $this->input->post('filter_status');
        $filter_sdate = $this->input->post('filter_sdate');
        $filter_edate = $this->input->post('filter_edate');
        $filter_enquiry = $this->input->post('filter_enquiry');
        $filter_place = $this->input->post('filter_place');
        $filter_cce = $this->input->post('filter_cce');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role'); 
        $data = $this->call_center_model->fetch_data($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce, $user_id, $role);
        // echo $this->db->last_query();
        $output .= '
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="callcenter_table" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Primary Contact</th>
                        <th>Street</th>
                        <th>Enquiry Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            ';
        if($data->num_rows() > 0){
            $i=1;
            foreach($data->result() as $row){
                if($row->timing== NULL){
                    $new_date = "";
                }else{
                    $date=strtotime($row->timing); 
                    $new_date = date("d/m/Y h:i:s A",$date);
                }
                    if($row->call_status==1){
                        $selectData ='<option selected value="1">Call Received</option>
                                <option value="2">In Progress</option>
                                <option value="3">Closed</option>
                                <option value="4">Blacklisted</option>
                                <option value="5">Registered</option>
                                <option value="6">Admitted</option>';
                    }else if($row->call_status==2){
                        $selectData = '<option selected value="2">In Progress</option>
                                <option value="1">Call Received</option>
                                <option value="3">Closed</option>
                                <option value="4">Blacklisted</option>
                                <option value="5">Registered</option>
                                <option value="6">Admitted</option>';
                    }else if($row->call_status==3){
                        $selectData = '<option selected value="3">Closed</option>
                                <option value="1">Call Received</option>
                                <option value="2">In Progress</option>
                                <option value="4">Blacklisted</option>
                                <option value="5">Registered</option>
                                <option value="6">Admitted</option>';
                    }else if($row->call_status==4){
                        $selectData = '<option selected value="4">Blacklisted</option>
                                <option value="1">Call Received</option>
                                <option value="2">In Progress</option>
                                <option value="3">Closed</option>
                                <option value="5">Registered</option>
                                <option value="6">Admitted</option>';
                    }else if($row->call_status==5){
                        $selectData = '<option  value="4">Blacklisted</option>
                                <option value="1">Call Received</option>
                                <option value="2">In Progress</option>
                                <option value="3">Closed</option>
                                <option selected value="5">Registered</option>
                                <option value="6">Admitted</option>';
                    }else if($row->call_status==6){
                        $selectData = '<option  value="4">Blacklisted</option>
                                <option value="1">Call Received</option>
                                <option value="2">In Progress</option>
                                <option value="3">Closed</option>
                                <option value="5">Registered</option>
                                <option selected value="6">Admitted</option>';    
                    }else{
                        $selectData = '<option value="">Select Status</option>
                                <option value="1">Answered</option>
                                <option value="2">No Answer</option>
                                <option value="3">Busy</option>
                                <option value="4">Blacklisted</option>
                                <option value="5">Registered</option>
                                <option value="6">Admitted</option>';
                    }
                $output .= '
                            <li id="row_'.$row->call_id.'">
                            <div class="col sl_no ">'.$i.'</div>
                            <div class="col " id="name_'.$row->call_id.'"> <a href ="" onclick="get_details('.$row->call_id.')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;"> '.$row->name.'</a></div>
                            <div class="col " id="course_id_'.$row->call_id.'">'.$row->class_name.'</div>
                            <div class="col " id="primary_mobile_'.$row->call_id.'">'.$row->primary_mobile.'</div>
                            <div class="col " id="street_'.$row->call_id.'">'.$row->street.'</div>
                            <div class="col " id="enquiry_type_'.$row->call_id.'">'.$row->enquiry_type.'</div>
                            <div class="col " id="call_status_'.$row->call_id.'">
                            <div class="form-group form_zero" >
                            <select class="form-control" name="call_status_list" id="edit_list_status_'.$row->call_id.'" onchange="get_val('.$row->call_id.')">'.$selectData.'</select>
                            </div>
                            </div>
                            <div class="col actions "><button  type="button" class="btn btn-default option_btn " onclick="get_details('.$row->call_id.')" title="Click here to view the details" data-toggle="modal" data-target="#show">
                            <i class="fa fa-eye "></i>
                        </button>
                            <button type="button" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$row->call_id.')">
                            <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn  " title="Delete" onclick="delete_call_centers('.$row->call_id.')">
                            <i class="fa fa-trash-o"></i>
                            </a>
                            <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$row->call_id.')">
                            Follow Up
                            </button>
                            </div>
                            </li>';
                            $i++;
                        }
                $output .= '
                            </ul>
                            </div>
                            ';
                        //    if($i!= 1){
                        //    } 
                
        }
        // if($i!= 1){
        $output .= '<button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
                <i class="fa fa-upload"></i> Export
            </button>';
        // }
        // else
        // {
        //     $output .= '<span><b><center>Sorry!!! No data Found</center></b><span>';
        // }
        echo $output;
    }

    function export_callcenter(){
            $filter_name = $this->input->post('filter_name');
            $filter_course = $this->input->post('filter_course');
            $filter_number = $this->input->post('filter_number');
            $filter_status = $this->input->post('filter_status');
            $filter_sdate = $this->input->post('filter_sdate');
            $filter_edate = $this->input->post('filter_edate');
            $filter_enquiry = $this->input->post('filter_enquiry');
            $filter_place = $this->input->post('filter_place');
            $filter_cce = $this->input->post('filter_cce');
            $user_id = $this->session->userdata('user_id');
            $role = $this->session->userdata('role'); 
            $data = $this->call_center_model->fetch_data($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce, $user_id, $role);
            if($data->num_rows() > 0){
            $filename      = 'report.pdf';
            // $pdfFilePath = $filename . ".pdf";
            // $filename = time()."_report.pdf";
            $pdfFilePath = FCPATH."/uploads/".$filename; 
            $dataArr['call_centerArr'] = $data->result_array();
            $this->data['call_centerArr']=$this->call_center_model->get_call_center_list();
			$html = $this->load->view('admin/callcenter_export',$dataArr ,TRUE);
			ini_set('memory_limit','128M'); // boost the memory limit if it's low ;)
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf->SetFooter('<div style="text-align:center;"><img src="./assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure ;)
			$pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($filename, "D"); // save to file because we can
        }else{
            // echo "<body>
            // <h1>Object not found!</h1>
            // <p>
            //     The requested URL was not found on this server.
                
            // </p>
            // </body>";
            $this->session->set_userdata('toaster_error', "Add atleast one Caller Detail");
            redirect(base_url() . 'backoffice/manage-calls','refresh');
        }
    }
    
    public function emailCheck()
    {
        $email_id=$this->input->post('email_id');
        $query= $this->db->get_where('cc_call_center_enquiries',array("email_id"=>$email_id));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function primary_mobileCheck()
    {
        $primary_mobile=$this->input->post('primary_mobile');
        $query= $this->db->get_where('cc_call_center_enquiries',array("primary_mobile"=>$primary_mobile));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function father_mobileCheck()
    {
        $father_mobile=$this->input->post('father_mobile');
        $query= $this->db->get_where('cc_call_center_enquiries',array("father_mobile"=>$father_mobile,"status"=>"0"));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function mother_mobileCheck()
    {
        $mother_mobile=$this->input->post('mother_mobile');
        $query= $this->db->get_where('cc_call_center_enquiries',array("mother_mobile"=>$mother_mobile,"status"=>"0"));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function editprimary_mobileCheck()
    {
        $primary_mobile      = $this->input->post('primary_mobile');
        $hidden_user_id      = $this->input->post('hidden_user_id');
        $check_mobile = $this->call_center_model->check_mobile_exists($primary_mobile, $hidden_user_id);
        echo json_encode($check_mobile);
    }
    function check_email_exists()
    {
        $email_id            = $this->input->post('email_id');
        $hidden_user_id      = $this->input->post('hidden_user_id');
        $check_email = $this->call_center_model->check_email_exists($email_id, $hidden_user_id);
        echo json_encode($check_email);
    }
    
    
    
//-------------------------------------------- Staff profile -----------------------------------------//
    public function profile(){
        $user_id = $this->session->userdata('user_id');
        if($user_id!=NULL){
            $this->data['staff'] = $this->common->get_staff_details_by_id($user_id);
            // echo '<pre>';
            // print_r($this->data['staff']);
            // die();
        }
        $this->data['conversion'] = $this->common->get_totalconversionrate_cce(date('Y-m-d'), $user_id); 
        
        $this->data['page']="admin/staff_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Profile";
        $this->data['menu_item']="backoffice/profile";
		$this->load->view('admin/layouts/_master',$this->data);
    }    

    
    /*
    *
    *   Call center head dashboard
    *
    */
    public function cc_dashboard($date=""){
        if($date == ""){
            $date=date('Y');
            
          }
        $user_id            = $this->session->userdata('user_id');
        $this->data['cce']  = $this->common->get_staff_list_by_roles(array('cce','cch'));
        $this->data['inprogress']   = 0;
        $this->data['unnecessary']  = 0;
        $this->data['register']     = 0;
        $this->data['closed']       = 0;
        $this->data['userid']       = $user_id;
        if($this->session->userdata('role')=='cce') {
        $this->data['total']        = $this->common->get_totalconversionrate_cce($date, $user_id); 
        $calls                      = $this->common->get_progresscall(2,$user_id);
        $closed                     = $this->common->get_progresscall(3,$user_id);
        $unnecessary                = $this->common->get_progresscall(4,$user_id);
        $register                   = $this->common->get_progresscall(5,$user_id);
        } else {
        $this->data['myrate']       = $this->common->get_totalconversionrate_cce($date, $user_id);     
        $this->data['total']        = $this->common->get_totalconversionrate1($date); 
        $calls                      = $this->common->get_progresscall(2); 
        $closed                     = $this->common->get_progresscall(3); 
        $unnecessary                = $this->common->get_progresscall(4); 
        $register                   = $this->common->get_progresscall(5); 
        }
        $this->data['inprogress']   = count($calls);
        $this->data['unnecessary']  = count($unnecessary);
        $this->data['register']     = count($register);
        $this->data['closed']       = count($closed);
        // echo '<pre>';
        // print_r($this->data['total']);
        // die();
        $this->data['upcomming_batchArr']       = $this->Batch_model->get_upcomming_batch();
        $this->data['running_batchArr']         = $this->Batch_model->get_running_batch();
        $this->data['page']         = "admin/cc_dashboard_view";
		$this->data['menu']         = "call_center";
        $this->data['breadcrumb']   = "";
        $this->data['menu_item']    = "backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    
    public function get_date()
    {
        $date = $this->input->post('date');
        // $this->data['cce'] = $this->common->get_staff_list_by_roles(array('cce','cch'));

        // $user_id            = $this->session->userdata('user_id');
        // if($this->session->userdata('role')=='cce') {
        // $data1 = $this->call_center_model->calls_today($date, $user_id); 
        // $data2 = $this->call_center_model->admitted_today($date, $user_id); 
        // $data3 = $this->call_center_model->total_calls($date, $user_id); 
        // $data4 = $this->call_center_model->total_admitted($date, $user_id);
        // }else{
        // $data1 = $this->call_center_model->calls_today($date, NULL); 
        // $data2 = $this->call_center_model->admitted_today($date, NULL); 
        // $data3 = $this->call_center_model->total_calls($date, NULL); 
        // $data4 = $this->call_center_model->total_admitted($date, NULL);
        // }
        // $this->data['cce'] = $this->common->get_staff_list_by_roles(array('cce','cch'));
        // $this->data['inprogress']   = 0;
        // $this->data['unnecessary']  = 0;
        // $this->data['register']     = 0;
        // $this->data['closed']       = 0;
        // $user_id            = $this->session->userdata('user_id');
        // $this->data['userid']       = $user_id;
        // if($this->session->userdata('role')=='cce') {
        // $this->data['total']        = $this->common->get_totalconversionrate_cce($date, $user_id); 
        // $calls                      = $this->common->get_progresscall1(2,$user_id,$date);
        // $closed                     = $this->common->get_progresscall1(3,$user_id,$date);
        // $unnecessary                = $this->common->get_progresscall1(4,$user_id,$date);
        // $register                   = $this->common->get_progresscall1(5,$user_id,$date);
        // } else {
        // $this->data['myrate']       = $this->common->get_totalconversionrate_cce($date, $user_id);     
        // $this->data['total']        = $this->common->get_totalconversionrate($date); 
        // $calls                      = $this->common->get_progresscall1(2,NULL,$date); 
        // $closed                     = $this->common->get_progresscall1(3,NULL,$date); 
        // $unnecessary                = $this->common->get_progresscall1(4,NULL,$date); 
        // $register                   = $this->common->get_progresscall1(5,NULL,$date); 
        // }
        // $this->data['inprogress']   = count($calls);
        // $this->data['unnecessary']  = count($unnecessary);
        // $this->data['register']     = count($register);
        // $this->data['closed']       = count($closed);
        $user_id            = $this->session->userdata('user_id');
        $this->data['cce']  = $this->common->get_staff_list_by_roles(array('cce','cch'));
        $this->data['inprogress']   = 0;
        $this->data['unnecessary']  = 0;
        $this->data['register']     = 0;
        $this->data['closed']       = 0;
        $this->data['userid']       = $user_id;
        if($this->session->userdata('role')=='cce') {
        $this->data['total']        = $this->common->get_totalconversionrate_cce1($date, $user_id); 
        $data1 = $this->call_center_model->calls_today($date, $user_id); 
        $data2 = $this->call_center_model->admitted_today($date, $user_id); 
        $calls                      = $this->common->get_progresscall(2,$user_id);
        $closed                     = $this->common->get_progresscall(3,$user_id);
        $unnecessary                = $this->common->get_progresscall(4,$user_id);
        $register                   = $this->common->get_progresscall(5,$user_id);
        } else {
        $data1 = $this->call_center_model->calls_today($date, NULL); 
        $data2 = $this->call_center_model->admitted_today($date, NULL); 
        $this->data['myrate']       = $this->common->get_totalconversionrate_cce($date, $user_id);     
        $this->data['total']        = $this->common->get_totalconversionrate1($date); 
        
        $calls                      = $this->common->get_progresscall(2); 
        $closed                     = $this->common->get_progresscall(3); 
        $unnecessary                = $this->common->get_progresscall(4); 
        $register                   = $this->common->get_progresscall(5); 
        }
        $this->data['inprogress']   = count($calls);
        $this->data['unnecessary']  = count($unnecessary);
        $this->data['register']     = count($register);
        $this->data['closed']       = count($closed);
        $html1 = '  <a href="'.base_url('backoffice/call-received-today').'">
                        <div class="dash_box dash_box_in">
                            <p>Call Received Today</p>
                            <h4>'.$this->data['total']["today_received_call"].'</h4>
                        </div>
                    </a> ';
        $html2 = '  <a href="'.base_url('backoffice/call-admitted-today').'">
                        <div class="dash_box dash_box_in">
                            <p>Total Admitted Today</p>
                            <h4>'.$this->data['total']['today_converted_call'].'</h4>
                        </div>
                    </a>'; 
        $html3 = '  <a href="'.base_url('backoffice/manage-calls').'">
                        <div class="dash_box dash_box_in">
                            <p>Total Call Received</p>
                            <h4>'.$this->data['total']['totalcall_received'].'</h4>
                        </div>
                    </a>';                           
        $html4 = '  <a href="'.base_url('backoffice/admitted-call-list').'">
                        <div class="dash_box dash_box_in">
                            <p>Total Admitted</p>
                            <h4>'.$this->data['total']['totalcall_converted'].'</h4>
                        </div>
                    </a>';
        $html5 = '  <a href="'.base_url('backoffice/in-progress-call-list').'">
                        <div class="dash_box dash_box_in">
                            <p>Calls In Progress</p>
                            <h4>'.$this->data['inprogress'].'</h4>
                        </div>
                    </a>'; 
        $html6 = '  <a href="'.base_url('backoffice/closed-call-list').'">
                        <div class="dash_box dash_box_in">
                            <p>Calls Closed</p>
                            <h4>'.$this->data['closed'].'</h4>
                        </div>
                    </a> ';
        $html7 = '  <a href="'.base_url('backoffice/unnecessary-call-list').'">
                        <div class="dash_box dash_box_in">
                            <p>Blacklisted Calls</p>
                            <h4>'.$this->data['unnecessary'].'</h4>
                        </div>
                    </a>';
        $html8 = '  <a href="'.base_url('backoffice/registered-call-list').'">
                        <div class="dash_box dash_box_in">
                            <p>Registered Calls</p>
                            <h4>'.$this->data['register'].'</h4>
                        </div>
                    </a>';

        $return_array['first'] = $html1;
        $return_array['second'] = $html2; 
        $return_array['third'] = $html3; 
        $return_array['fourth'] = $html4; 
        $return_array['fifth'] = $html5; 
        $return_array['sixth'] = $html6; 
        $return_array['seventh'] = $html7; 
        $return_array['eighth'] = $html8; 
        print_r(json_encode($return_array));
        
    }
    
    /*
    *
    *   function'll get conversion ratio of selected executive
    *
    *
    */
    
    
    function get_cc_executiveratio(){
        $user_id = $this->input->post('user_id');
        $date=date('Y-m-d');
        $total        = $this->common->get_totalconversionrate_cce($date, $user_id);
        print_r(json_encode($total));
    }
    
    /*
    *
    *   List In Progressed status calls
    *
    */
    
    public function in_progress_call_list() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_progresscall(2, $user_id);
        } else {
        $this->data['calls'] = $this->common->get_progresscall(2); 
        }
        $this->data['page']="admin/list_inprogress_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="In progress call list";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    /*
    *
    *   List Closed status calls
    *
    */
    
    public function closed_call_list() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_progresscall(3, $user_id);
        } else {
        $this->data['calls'] = $this->common->get_progresscall(3); 
        }
        $this->data['page']="admin/list_closed_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Closed call list";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    /*
    *
    *   Unnecessary status calls
    *
    */
    
    public function unnecessary_call_list() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_progresscall(4, $user_id);
        } else {
        $this->data['calls'] = $this->common->get_progresscall(4); 
        }
        $this->data['page']="admin/list_unnecessary_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Blacklisted call list";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    /*
    *
    *   Registered status calls
    *
    */
    
    public function registered_call_list() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_progresscall(5, $user_id);
        } else {
        $this->data['calls'] = $this->common->get_progresscall(5); 
        }
        $this->data['page']="admin/list_registered_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Registered call list";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    
    /*
    *
    *   Admitted status calls
    *
    */
    
    public function admitted_call_list() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_progresscall(6, $user_id);
        } else {
        $this->data['calls'] = $this->common->get_progresscall(6); 
        }
        $this->data['page']="admin/list_admitted_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Admitted call list";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    
    /*
    *
    *   Total Call received today
    *
    */
    
    public function call_received_today() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_todays_call(date('Y-m-d'), $user_id);
        } else {
        $this->data['calls'] = $this->common->get_todays_call(date('Y-m-d')); 
        }
        // echo $this->db->last_query();
        $this->data['page']="admin/today_received_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Received Call Today";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    
    /*
    *
    *   Total admitted today
    *
    */
    
    public function call_admitted_today() {
        $user_id = $this->session->userdata('user_id');
        if($this->session->userdata('role')=='cce') {
        $this->data['calls'] = $this->common->get_admitted_today(date('Y-m-d'), 6, $user_id);
        } else {
        $this->data['calls'] = $this->common->get_admitted_today(date('Y-m-d'), 6); 
        }
        $this->data['page']="admin/today_admitted_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Admitted Call Today";
        $this->data['menu_item']="backoffice/cc-dashboard";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    
    /*
    *
    *   Fee structure
    *
    */
    public function fee_structure(){
        
        $this->data['cce'] = $this->common->get_staff_list_by_roles(array('cce','cch'));
        $this->data['total'] = $this->common->get_totalconversionrate(date('Y-m-d')); 
        $this->data['courseArr']=$this->call_center_model->get_course_list();
        $this->data['page']="admin/fee_structure_view";
		$this->data['menu']="call_center";
        $this->data['breadcrumb']="Fees Structure";
        $this->data['menu_item']="backoffice/fee-structure";
		$this->load->view('admin/layouts/_master',$this->data);
    } 

    public function get_type(){
        if($_POST){
            $enquiry_type = $this->input->post('enquiry_type');
            if($enquiry_type == "Fee related" ||$enquiry_type == "Parent call" ||$enquiry_type == "General Enquiry"){
                // $type = "Subject"; 
            }
            echo '
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group"><label>Description</label>
                        <input class="form-control" type="text" name="description" id="description" placeholder="Description" data-validate="required">
                    </div>
                </div>
            </div>';
        }
    }
    public function get_edittype(){
        if($_POST){
            $enquiry_type = $this->input->post('edit_enquiry_type');
            if($enquiry_type == "Fee related" ||$enquiry_type == "Parent call" ||$enquiry_type == "General Enquiry"){
                // $type = "Subject"; 
            }
            echo '<div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group"><label>Description</label>
                        <input class="form-control" type="text" name="description" id="edit_description" placeholder="Description" data-validate="required">
                    </div>
                </div>
            </div>';
        }
    }

    public function get_course_related(){
        if($_POST){
        $this->data['stateArr']=$this->common->get_all_states(19);
        $this->data['courseArr']=$this->call_center_model->get_course_list();
        // $id=$this->input->post('state_id');
        $DistrictArr=$this->common->get_dist_bystate(19);
        // $this->data['DistrictArr']=$this->common->get_district_bystate($state_id);
            $enquiry_type = $this->input->post('enquiry_type');
            if($enquiry_type == "Course related"){
                // $type = "Subject"; 
            }
            $html = '<div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label>State<span class="req redbold">*</span></label>
                <select class="form-control" name="state" id="state" onchange="get_city()">
                    <option value="">Select </option>';
                    foreach($this->data['stateArr'] as $state){
                        if($state['id']=='19') { $selected	=	'selected="selected"'; } else { $selected = ''; }
                        $html .= '<option value="'.$state["id"].'" '.$selected.'>'.$state["name"].'</option>';

                     } 
                     $html .='</select>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label>City<span class="req redbold">*</span></label>
                <select class="form-control" name="district" id="district" >
                    <option value="">Select City</option>';
                    foreach($DistrictArr as $district){
                        if($district['id']=='1947') { $selected	=	'selected="selected"'; } else { $selected = ''; }
                        $html .= '<option value="'.$district["id"].'" '.$selected.'>'.$district["name"].'</option>';
                     } 
                     $html .= '</select>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label> Street Name</label>
                <input class="form-control" type="text" name="street" placeholder="Street" data-validate="required">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label> Qualification</label>
                <select class="form-control" name="qualification">
                    <option value="">Select</option>
                        <option  >AHSLC</option>
                        <option  >Anglo Indian School Leaving Certificate</option>
                        <option  >CBSE Xth</option>
                        <option  >ICSE Xth</option>
                        <option  >JTSLC</option>
                        <option  >Matriculation Certificate</option>
                        <option  >Secondary School Examination</option>
                        <option  >SSC</option>
                        <option  >SSLC</option>
                        <option  >SSLC with Agricultural Optional</option>
                        <option  >Standard X Equivalency</option>
                        <option  >THSLC Xth</option>
                        <option  >AHSS</option>
                        <option  >CBSE XIIth</option>
                        <option  >ICSE XIIth</option>
                        <option  >Plus 2</option>
                        <option  >Plus Two Equivalency</option>
                        <option  >Pre Degree</option>
                        <option  >Pre University</option>
                        <option  >Senior Secondary School Examination</option>
                        <option  >SSSC</option>
                        <option  >THSE - XII</option>
                        <option  >VHSE</option>
                        <option  >VHSE Pass in Trade only for Employment Purpose</option>
                            <option >B Voc</option>
                            <option  >BA</option>
                            <option  >BA Honours</option>
                            <option  >Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                            <option  >Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                            <option  >Bachelor of Design</option>
                            <option  >Bachelor of Divinity</option>
                            <option  >Bachelor of Occupational Therapy - BOT</option>
                            <option  >Bachelor of Science BS</option>
                            <option  >Bachelor of Science in Applied Sciences</option>
                            <option  >Bachelor of Textile</option>
                            <option  >BAL</option>
                            <option  >BAM</option>
                            <option  >BAMS</option>
                            <option  >BArch</option>
                            <option  >BBA</option>
                            <option  >BBM</option>
                            <option  >BBS</option>
                            <option  >BBS Bachelor of Business Studies</option>
                            <option  >BBT</option>
                            <option  >BCA</option>
                            <option  >BCJ</option>
                            <option  >BCom</option>
                            <option  >BComHonours</option>
                            <option  >BComEd</option>
                            <option  >BCS - Bachelor of Corporate Secretaryship</option>
                            <option  >BCVT </option>
                            <option  >BDS</option>
                            <option  >BE</option>
                            <option  >BEd</option>
                            <option  >BFA</option>
                            <option  >BFA Hearing Impaired</option>
                            <option  >BFSc</option>
                            <option  >BFT</option>
                            <option  >BHM</option>
                            <option  >BHMS</option>
                            <option  >BIL Bachelor of Industrial Law</option>
                            <option  >BIT</option>
                            <option  >BLiSc</option>
                            <option  >BMMC</option>
                            <option  >BMS - Bachelor of Management Studies</option>
                            <option  >BNYS</option>
                            <option  >BPA</option>
                            <option  >BPE</option>
                            <option  >BPEd</option>
                            <option  >BPharm</option>
                            <option  >BPlan</option>
                            <option  >BPT</option>
                            <option  >BRIT - Bachelor of Radiology and Imaging Technology</option>
                            <option  >BRS - Bachelor in Rehabilitation Scinece</option>
                            <option  >BRT Bachelor in Rehabilitation Technology</option>
                            <option  >BSc</option>
                            <option  >BSc Honours </option>
                            <option  >BSc Honours Agriculture</option>
                            <option  >BSc MLT</option>
                            <option  >BScEd</option>
                            <option  >BSMS</option>
                            <option  >BSW</option>
                            <option  >BTech</option>
                            <option  >BTHM</option>
                            <option  >BTM (Honours)</option>
                            <option  >BTS</option>
                            <option  >BTTM</option>
                            <option  >BUMS</option>
                            <option  >BVA - Bachelor of Visual Arts</option>
                            <option  >BVC Bachelor of Visual Communication</option>
                            <option  >BVSC&amp;AH</option>
                            <option  >Degree from Indian Institute of Forest Management</option>
                            <option  >Degree in Special Training in Teaching HI/VI/MR</option>
                            <option  >Graduation in Cardio Vascular Technology</option>
                            <option  >Integrated Five Year BA,LLB Degree</option>
                            <option  >Integrated Five Year BCom,LLB Degree</option>
                            <option  >LLB</option>
                            <option  >MBBS</option>
                            <option  >Post Basic B.Sc</option>
                            <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                            <option value="BA - MA Integrated">BA - MA Integrated</option>
                            <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                            <option value="DM">DM</option>
                            <option value="DNB">DNB</option>
                            <option value="LLM">LLM</option>
                            <option value="M Des  Master of Design">M Des  Master of Design</option>
                            <option value="MA">MA</option>
                            <option value="MArch">MArch</option>
                            <option value="Master in Audiology and Speech Language Pathology(MASLP)">Master in Audiology and Speech Language Pathology(MASLP)</option>
                            <option value="Master in Software Engineering">Master in Software Engineering</option>
                            <option value="Master of Applied Science">Master of Applied Science</option>
                            <option value="Master of Communication">Master of Communication</option>
                            <option value="Master of Fashion Technology">Master of Fashion Technology</option>
                            <option value="Master of Health Administration">Master of Health Administration</option>
                            <option value="Master of Hospital Administration">Master of Hospital Administration</option>
                            <option value="Master of Human Resource Management">Master of Human Resource Management</option>
                            <option value="Master of Interior  Architecture and Design">Master of Interior  Architecture and Design</option>
                            <option value="Master of International Business">Master of International Business</option>
                            <option value="Master of Journalism and Television Production">Master of Journalism and Television Production</option>
                            <option value="Master of Management in Hospitality">Master of Management in Hospitality</option>
                            <option value="Master of Occupational Therapy - MOT">Master of Occupational Therapy - MOT</option>
                            <option value="Master of Public Health">Master of Public Health</option>
                            <option value="Master of Rehabilitation Science">Master of Rehabilitation Science</option>
                            <option value="Master of Rural Development">Master of Rural Development</option>
                            <option value="Master of Technology (Pharm)">Master of Technology (Pharm)</option>
                            <option value="Master of Tourism Management">Master of Tourism Management</option>
                            <option value="Master of Travel and Tourism Management">Master of Travel and Tourism Management</option>
                            <option value="Master of Urban and Rural Planning">Master of Urban and Rural Planning</option>
                            <option value=">Master of Visual Communication">Master of Visual Communication</option>
                            <option value="Master of Womens Studies">Master of Womens Studies</option>
                            <option value="Masters in Business Law">Masters in Business Law</option>
                            <option value="MBA">MBA</option>
                            <option value="MBEM Master of Building Engineering and Management">MBEM Master of Building Engineering and Management </option>
                            <option value="MCA">MCA</option>
                            <option value="MCh">MCh</option>
                            <option value="MCJ">MCJ</option>
                            <option value="MCom">MCom</option>
                            <option value="MCP Master in City Planning">MCP Master in City Planning</option>
                            <option value="MD">MD</option>
                            <option value="MD Homeo">MD Homeo</option>
                            <option  >MD SIDHA</option>
                            <option value="MD SIDHA">MD-Ayurveda</option>
                            <option value="MDS">MDS</option>
                            <option value="ME">ME </option>
                            <option value="MEd">MEd</option>
                            <option value="MFA">MFA</option>
                            <option value="MFM Master of Fashion Management">MFM Master of Fashion Management</option>
                            <option value="MFM Master of Financial Management">MFM Master of Financial Management</option>
                            <option value="MFSc">MFSc</option>
                            <option value="MHMS">MHMS</option>
                            <option value="MHSc CCD">MHSc CCD</option>
                            <option value="MLA Master of Landscape Architecture">MLA Master of Landscape Architecture</option>
                            <option value="MLiSc">MLiSc</option>
                            <option value="MPA">MPA</option>
                            <option value="MPE">MPE</option>
                            <option value="MPEd">MPEd</option>
                            <option value="MPharm">MPharm</option>
                            <option value="MPhil - Arts">MPhil - Arts</option>
                            <option value="MPhil - Clinical Psychology">MPhil - Clinical Psychology</option>
                            <option value="MPhil - Commerce">MPhil - Commerce</option>
                            <option value="MPhil - Education">MPhil - Education</option>
                            <option value="MPhil - Futures Studies">MPhil - Futures Studies</option>
                            <option value="MPhil - Management Studies">MPhil - Management Studies</option>
                            <option  >Mphil - Medical and Social Psychology">Mphil - Medical and Social Psychology</option>
                            <option value="MPhil - Physical Education">MPhil - Physical Education</option>
                            <option value="MPhil - Science">MPhil - Science</option>
                            <option value="Mphil - Theatre Arts ">Mphil - Theatre Arts </option>
                            <option value="MPlan">MPlan</option>
                            <option value="MPT">MPT</option>
                            <option value="MS Master of Science">MS Master of Science </option>
                            <option value="MS Master of Surgery">MS Master of Surgery</option>
                            <option value="MS Pharm">MS Pharm</option>
                            <option value="MSc">MSc</option>
                            <option value="MSc 5 years">MSc 5 years</option>
                            <option value="MSc MLT">MSc MLT</option>
                            <option value="MScEd">MScEd</option>
                            <option value="MScTech">MScTech</option>
                            <option value="MSW">MSW</option>
                            <option value="MTA">MTA</option>
                            <option value="MTech">MTech</option>
                            <option value="MUD Master of Urban Design">MUD Master of Urban Design</option>
                            <option value="MVA Master of Visual Arts1">MVA Master of Visual Arts</option>
                            <option value="MVSc">MVSc</option>
                            <option value="One Year Post Graduate Diploma in Personnel Management and Industrial Relations">One Year Post Graduate Diploma in Personnel Management and Industrial Relations</option>
                            <option value="P G Diploma in Quality Assurance in Microbiology">P G Diploma in Quality Assurance in Microbiology</option>
                            <option value="PDCFA">PDCFA</option>
                            <option value="PG  Diploma (from Other Institutions)">PG  Diploma (from Other Institutions)</option>
                            <option value="PG  Diploma (from University)">PG  Diploma (from University)</option>
                            <option value="PG Certificate in  Career Educational Councelling">PG Certificate in  Career Educational Councelling</option>
                            <option value="PG Certificate in Criminology and Criminal Justice Admin">PG Certificate in Criminology and Criminal Justice Admin.</option>
                            <option value="PG Diploma in Accomodation Operation and Management">PG Diploma in Accomodation Operation and Management</option>
                            <option value="PG Diploma in Beauty Therapy">PG Diploma in Beauty Therapy</option>
                            <option value="PG Diploma in Beauty Therapy and Cosmetology">PG Diploma in Beauty Therapy and Cosmetology</option>
                            <option value="PG Diploma in Clinical Perfusion">PG Diploma in Clinical Perfusion</option>
                            <option value="PG Diploma in Dialysis Therapy">PG Diploma in Dialysis Therapy</option>
                            <option value="PG Diploma in Food Analysis and Quality Assuarance">PG Diploma in Food Analysis and Quality Assuarance</option>
                            <option value="PG Diploma in Medicine">PG Diploma in Medicine</option>
                            <option value="PG Diploma in Neuro Electro Physiology">PG Diploma in Neuro Electro Physiology</option>
                            <option value="PG Diploma in Plastic Processing and Testing">PG Diploma in Plastic Processing and Testing</option>
                            <option value="PG Diploma in Plastic Processing Technology">PG Diploma in Plastic Processing Technology</option>
                            <option value="PG Diploma in Wind Power Development">PG Diploma in Wind Power Development</option>
                            <option value="PG Professional Diploma in Special Education">PG Professional Diploma in Special Education</option>
                            <option value="PG Translation Diploma English-Hindi">PG Translation Diploma English-Hindi</option>
                            <option value="PGDBA HR">PGDBA HR</option>
                            <option value="PGDHRM">PGDHRM</option>
                            <option value="PGDiploma in Dialysis Technology PGDDT">PGDiploma in Dialysis Technology PGDDT</option>
                            <option value="Pharm D">Pharm D</option>
                            <option value="Post Graduate Diploma in AccommodationOperation and Mngmnt">Post Graduate Diploma in AccommodationOperation and Mngmnt</option>
                            <option value="Post Graduate Diploma in Anaesthesiology (DA)">Post Graduate Diploma in Anaesthesiology (DA)</option>
                            <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option><option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
                            <option value="Post Graduate Diploma in Child Health">Post Graduate Diploma in Child Health</option>
                            <option value="Post Graduate Diploma in Clinical Child Development">Post Graduate Diploma in Clinical Child Development</option>
                            <option value="Post Graduate Diploma in Clinical Nutrition and Dietetics">Post Graduate Diploma in Clinical Nutrition and Dietetics</option>
                            <option value="Post Graduate Diploma in Clinical Pathology">Post Graduate Diploma in Clinical Pathology</option>
                            <option value="Post Graduate Diploma in Clinical Psychology">Post Graduate Diploma in Clinical Psychology</option>
                            <option value="Post Graduate Diploma in Counselling">Post Graduate Diploma in Counselling</option>
                            <option value="Post Graduate Diploma in Dairy Development">Post Graduate Diploma in Dairy Development</option>
                            <option value="Post Graduate Diploma in Dairy Quality Control">Post Graduate Diploma in Dairy Quality Control</option>
                            <option value="Post Graduate Diploma in Dissaster management">Post Graduate Diploma in Dissaster management</option>
                            <option value="Post Graduate Diploma in eGovernance">Post Graduate Diploma in eGovernance</option>
                            <option value="Post Graduate Diploma in Finance and HR Management">Post Graduate Diploma in Finance and HR Management</option>
                            <option value="Post Graduate Diploma in Financial Management">Post Graduate Diploma in Financial Management</option>
                            <option value="Post Graduate Diploma in Folk Dance and Cultural studies">Post Graduate Diploma in Folk Dance and Cultural studies</option>
                            <option value="Post Graduate Diploma in Food Science and Technology">Post Graduate Diploma in Food Science and Technology </option>
                            <option value="Post Graduate Diploma in International Business Operations">Post Graduate Diploma in International Business Operations</option>
                            <option value="Post Graduate Diploma in IT Enabled Services and BPO">Post Graduate Diploma in IT Enabled Services and BPO</option>
                            <option value="Post Graduate Diploma in Journalism">Post Graduate Diploma in Journalism</option>
                            <option value="Post Graduate Diploma in Journalism and Communication">Post Graduate Diploma in Journalism and Communication</option>
                            <option value="Post Graduate Diploma in Management">Post Graduate Diploma in Management</option>
                            <option value="Post Graduate Diploma in Management (PGDM)">Post Graduate Diploma in Management (PGDM)</option>
                            <option value="Post Graduate Diploma in Management of Learning Disabilities">Post Graduate Diploma in Management of Learning Disabilities</option>
                            <option value="Post Graduate Diploma in Marine Technology (Mechanical)">Post Graduate Diploma in Marine Technology (Mechanical)</option>
                            <option value="Post Graduate Diploma in Marketing Management">Post Graduate Diploma in Marketing Management</option>
                            <option value="Post Graduate Diploma in Nutrition and Dietetics">Post Graduate Diploma in Nutrition and Dietetics</option>
                            <option value="Post Graduate Diploma in Orthopaedics">Post Graduate Diploma in Orthopaedics</option>
                            <option value="Post Graduate Diploma in Otorhyno Laryngology">Post Graduate Diploma in Otorhyno Laryngology</option>
                            <option value="Post Graduate Diploma in Personnel Management">Post Graduate Diploma in Personnel Management</option>
                            <option value="Post Graduate Diploma in Psychiatric Social Work">Post Graduate Diploma in Psychiatric Social Work</option>
                            <option value="Post Graduate Diploma in Public Relations">Post Graduate Diploma in Public Relations</option>
                            <option value="Post Graduate Diploma in Public Relations Management">Post Graduate Diploma in Public Relations Management</option>
                            <option value="Post Graduate Diploma in Regional/City Planning">Post Graduate Diploma in Regional/City Planning</option>
                            <option value="Post Graduate Diploma in Software Engineering">Post Graduate Diploma in Software Engineering</option>
                            <option value="Post graduate Diploma in Town and Country Planning">Post graduate Diploma in Town and Country Planning</option>
                            <option value="Post Graduate Diploma in Travel and Tourism Management">Post Graduate Diploma in Travel and Tourism Management</option>
                            <option value="Professional Diploma in Clinical Psychology">Professional Diploma in Clinical Psychology</option>
            </select>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label> Course<span class="req redbold">*</span></label>
                <select class="form-control" name="course_id" id="course" data-validate="required" onchange="get_branch()">
                    <option value="">Select Course</option>';
                       foreach($this->data['courseArr'] as $course) {
                        if($course["status"]==1) {
                            $html .= '<option value="'.$course["class_id"].'">'.$course["class_name"].'</option>';
                        } 
                     } 
                     $html .= '</select>         
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label> Branch<span class="req redbold">*</span></label>
                <select class="form-control" name="branch_id" id="branch_id" data-validate="required" onchange="get_center()">
                    <option value="0">Select Branch</option>
                </select>              
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label> Centre<span class="req redbold"></span></label>
                <select class="form-control" name="center_id" id="center_id" data-validate="required">
                    <option value="0">Select Centre</option>
                </select>              
            </div>
        </div>        
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label>Father Mobile</label>
                <input class="form-control" type="text" name="father_mobile" id="father_mobile" placeholder="Father Mobile" data-validate="required">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label>Mother Mobile</label>
                <input class="form-control" type="text" name="mother_mobile" id="mother_mobile" placeholder="Mother Mobile" data-validate="required">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label>Email Id</label>
                <input class="form-control" type="text" name="email_id" id="email_id" placeholder="Email Id">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label>Source</label>
                <input class="form-control" type="text" name="source" placeholder="Source">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group" ><label>Timing</label>
                <input class="form-control datetime " type="text" name="timing" placeholder="Timing">
                    <script> 
                        $(function () {
                            $(".datetime").datetimepicker({
                                maxDate: new Date(),
                                format: "DD/MM/YYYY hh:mm:ss A"
                            });
                        });
                    </script>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label> Status</label>
                <select class="form-control" name="call_status" disabled>
                    <option value="1">Call Received</option>
                    <option value="2">In Progress</option>
                    <option value="3">Closed</option>
                    <option value="4">Un necessary</option>
                </select>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"><label>Hostel</label>
                <select class="form-control" name="hostel">
                    <option value="">Select Hostel</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group"><label>Description</label>
                <input class="form-control" type="text" name="comments" placeholder="Description">
            </div>
        </div></div>';
        echo $html;
        }
    }
    
    
    
    public function get_callcenter_paginations() { //print_r($_REQUEST);
        $data = array(
        array('Name'=>'parvez', 'Empid'=>11, 'Salary'=>101),
        array('Name'=>'alam', 'Empid'=>1, 'Salary'=>102),
        array('Name'=>'phpflow', 'Empid'=>21, 'Salary'=>103)							
        );


        $results = array(
                    "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                  "aaData"=>$data);
        /*while($row = $result->fetch_array(MYSQLI_ASSOC)){
          $results["data"][] = $row ;
        }*/

    echo json_encode($results);
    }

  


    public function get_editcourse_related(){
        // if($id!=NULL){
        //     $this->data['callEdit'] = $this->call_center_model->get_call_centerdetails_by_id($id);
        // }
        if($_POST){
        $this->data['stateArr']=$this->common->get_all_states();
        $this->data['courseArr']=$this->call_center_model->get_course_list();
        $id=$this->input->post('state_id');
        $DistrictArr=$this->common->get_dist_bystate(19,1947);
        $course_id  = $this->input->post('edit_course');
        $this->data['branchArr']   = $this->call_center_model->get_all_branches($course_id);
            $enquiry_type = $this->input->post('edit_enquiry_type');
            if($enquiry_type == "Course related"){
            }
            $html = '<div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>State<span class="req redbold">*</span></label>
                                <select class="form-control" name="state" id="edit_state" onchange="get_editcity()">
                                    <option value="">Select</option>';
                                    foreach($this->data['stateArr'] as $state){
                                        if($state['id']=='19') { $selected	=	'selected="selected"'; } else { $selected = ''; }
                                        $html .= '<option value="'.$state["id"].'" '.$selected.'>'.$state["name"].'</option>';
                
                                     } 
                                    
                        $html .='</select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>City<span class="req redbold">*</span></label>
                                <select class="form-control" name="district" id="edit_district">
                                    <option value="">Select</option>';
                                    foreach($DistrictArr as $district){
                                        if($district['id']=='1947') { $selected	=	'selected="selected"'; } else { $selected = ''; }
                                        $html .= '<option value="'.$district["id"].'" '.$selected.'>'.$district["name"].'</option>';
                                     } 
                        $html .= '</select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Street Name</label>
                                <input class="form-control" type="text" name="street" placeholder="Street" id="edit_street" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Qualification</label>
                                <select class="form-control" name="qualification" id="edit_qualification">
                              <option value="">Select</option>
                                        <option  >AHSLC</option>
                                        <option  >Anglo Indian School Leaving Certificate</option>
                                        <option  >CBSE Xth</option>
                                        <option  >ICSE Xth</option>
                                        <option  >JTSLC</option>
                                        <option  >Matriculation Certificate</option>
                                        <option  >Secondary School Examination</option>
                                        <option  >SSC</option>
                                        <option  >SSLC</option>
                                        <option  >SSLC with Agricultural Optional</option>
                                        <option  >Standard X Equivalency</option>
                                        <option  >THSLC Xth</option>
                                        <option  >AHSS</option>
                                        <option  >CBSE XIIth</option>
                                        <option  >ICSE XIIth</option>
                                        <option  >Plus 2</option>
                                        <option  >Plus Two Equivalency</option>
                                        <option  >Pre Degree</option>
                                        <option  >Pre University</option>
                                        <option  >Senior Secondary School Examination</option>
                                        <option  >SSSC</option>
                                        <option  >THSE - XII</option>
                                        <option  >VHSE</option>
                                        <option  >VHSE Pass in Trade only for Employment Purpose</option>
                                  <option >B Voc</option>
                                            <option  >BA</option>
                                            <option  >BA Honours</option>
                                            <option  >Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                                            <option  >Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                                            <option  >Bachelor of Design</option>
                                            <option  >Bachelor of Divinity</option>
                                            <option  >Bachelor of Occupational Therapy - BOT</option>
                                            <option  >Bachelor of Science BS</option>
                                            <option  >Bachelor of Science in Applied Sciences</option>
                                            <option  >Bachelor of Textile</option>
                                            <option  >BAL</option>
                                            <option  >BAM</option>
                                            <option  >BAMS</option>
                                            <option  >BArch</option>
                                            <option  >BBA</option>
                                            <option  >BBM</option>
                                            <option  >BBS</option>
                                            <option  >BBS Bachelor of Business Studies</option>
                                            <option  >BBT</option>
                                            <option  >BCA</option>
                                            <option  >BCJ</option>
                                            <option  >BCom</option>
                                            <option  >BComHonours</option>
                                            <option  >BComEd</option>
                                            <option  >BCS - Bachelor of Corporate Secretaryship</option>
                                            <option  >BCVT </option>
                                            <option  >BDS</option>
                                            <option  >BE</option>
                                            <option  >BEd</option>
                                            <option  >BFA</option>
                                            <option  >BFA Hearing Impaired</option>
                                            <option  >BFSc</option>
                                            <option  >BFT</option>
                                            <option  >BHM</option>
                                            <option  >BHMS</option>
                                            <option  >BIL Bachelor of Industrial Law</option>
                                            <option  >BIT</option>
                                            <option  >BLiSc</option>
                                            <option  >BMMC</option>
                                            <option  >BMS - Bachelor of Management Studies</option>
                                            <option  >BNYS</option>
                                            <option  >BPA</option>
                                            <option  >BPE</option>
                                            <option  >BPEd</option>
                                            <option  >BPharm</option>
                                            <option  >BPlan</option>
                                            <option  >BPT</option>
                                            <option  >BRIT - Bachelor of Radiology and Imaging Technology</option>
                                            <option  >BRS - Bachelor in Rehabilitation Scinece</option>
                                            <option  >BRT Bachelor in Rehabilitation Technology</option>
                                            <option  >BSc</option>
                                            <option  >BSc Honours </option>
                                            <option  >BSc Honours Agriculture</option>
                                            <option  >BSc MLT</option>
                                            <option  >BScEd</option>
                                            <option  >BSMS</option>
                                            <option  >BSW</option>
                                            <option  >BTech</option>
                                            <option  >BTHM</option>
                                            <option  >BTM (Honours)</option>
                                            <option  >BTS</option>
                                            <option  >BTTM</option>
                                            <option  >BUMS</option>
                                            <option  >BVA - Bachelor of Visual Arts</option>
                                            <option  >BVC Bachelor of Visual Communication</option>
                                            <option  >BVSC&amp;AH</option>
                                            <option  >Degree from Indian Institute of Forest Management</option>
                                            <option  >Degree in Special Training in Teaching HI/VI/MR</option>
                                            <option  >Graduation in Cardio Vascular Technology</option>
                                            <option  >Integrated Five Year BA,LLB Degree</option>
                                            <option  >Integrated Five Year BCom,LLB Degree</option>
                                            <option  >LLB</option>
                                            <option  >MBBS</option>
                                            <option  >Post Basic B.Sc</option>
                                <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                                            <option value="BA - MA Integrated">BA - MA Integrated</option>
                                            <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                                            <option value="DM">DM</option>
                                            <option value="DNB">DNB</option>
                                            <option value="LLM">LLM</option>
                                            <option value="M Des  Master of Design">M Des  Master of Design</option>
                                            <option value="MA">MA</option>
                                            <option value="MArch">MArch</option>
                                            <option value="Master in Audiology and Speech Language Pathology(MASLP)">Master in Audiology and Speech Language Pathology(MASLP)</option>
                                            <option value="Master in Software Engineering">Master in Software Engineering</option>
                                            <option value="Master of Applied Science">Master of Applied Science</option>
                                            <option value="Master of Communication">Master of Communication</option>
                                            <option value="Master of Fashion Technology">Master of Fashion Technology</option>
                                            <option value="Master of Health Administration">Master of Health Administration</option>
                                            <option value="Master of Hospital Administration">Master of Hospital Administration</option>
                                            <option value="Master of Human Resource Management">Master of Human Resource Management</option>
                                            <option value="Master of Interior  Architecture and Design">Master of Interior  Architecture and Design</option>
                                            <option value="Master of International Business">Master of International Business</option>
                                            <option value="Master of Journalism and Television Production">Master of Journalism and Television Production</option>
                                            <option value="Master of Management in Hospitality">Master of Management in Hospitality</option>
                                            <option value="Master of Occupational Therapy - MOT">Master of Occupational Therapy - MOT</option>
                                            <option value="Master of Public Health">Master of Public Health</option>
                                            <option value="Master of Rehabilitation Science">Master of Rehabilitation Science</option>
                                            <option value="Master of Rural Development">Master of Rural Development</option>
                                            <option value="Master of Technology (Pharm)">Master of Technology (Pharm)</option>
                                            <option value="Master of Tourism Management">Master of Tourism Management</option>
                                            <option value="Master of Travel and Tourism Management">Master of Travel and Tourism Management</option>
                                            <option value="Master of Urban and Rural Planning">Master of Urban and Rural Planning</option>
                                            <option value=">Master of Visual Communication">Master of Visual Communication</option>
                                            <option value="Master of Womens Studies">Master of Womens Studies</option>
                                            <option value="Masters in Business Law">Masters in Business Law</option>
                                            <option value="MBA">MBA</option>
                                            <option value="MBEM Master of Building Engineering and Management">MBEM Master of Building Engineering and Management </option>
                                            <option value="MCA">MCA</option>
                                            <option value="MCh">MCh</option>
                                            <option value="MCJ">MCJ</option>
                                            <option value="MCom">MCom</option>
                                            <option value="MCP Master in City Planning">MCP Master in City Planning</option>
                                            <option value="MD">MD</option>
                                            <option value="MD Homeo">MD Homeo</option>
                                            <option  >MD SIDHA</option>
                                            <option value="MD SIDHA">MD-Ayurveda</option>
                                            <option value="MDS">MDS</option>
                                            <option value="ME">ME </option>
                                            <option value="MEd">MEd</option>
                                            <option value="MFA">MFA</option>
                                            <option value="MFM Master of Fashion Management">MFM Master of Fashion Management</option>
                                            <option value="MFM Master of Financial Management">MFM Master of Financial Management</option>
                                            <option value="MFSc">MFSc</option>
                                            <option value="MHMS">MHMS</option>
                                            <option value="MHSc CCD">MHSc CCD</option>
                                            <option value="MLA Master of Landscape Architecture">MLA Master of Landscape Architecture</option>
                                            <option value="MLiSc">MLiSc</option>
                                            <option value="MPA">MPA</option>
                                            <option value="MPE">MPE</option>
                                            <option value="MPEd">MPEd</option>
                                            <option value="MPharm">MPharm</option>
                                            <option value="MPhil - Arts">MPhil - Arts</option>
                                            <option value="MPhil - Clinical Psychology">MPhil - Clinical Psychology</option>
                                            <option value="MPhil - Commerce">MPhil - Commerce</option>
                                            <option value="MPhil - Education">MPhil - Education</option>
                                            <option value="MPhil - Futures Studies">MPhil - Futures Studies</option>
                                            <option value="MPhil - Management Studies">MPhil - Management Studies</option>
                                            <option  >Mphil - Medical and Social Psychology">Mphil - Medical and Social Psychology</option>
                                            <option value="MPhil - Physical Education">MPhil - Physical Education</option>
                                            <option value="MPhil - Science">MPhil - Science</option>
                                            <option value="Mphil - Theatre Arts ">Mphil - Theatre Arts </option>
                                            <option value="MPlan">MPlan</option>
                                            <option value="MPT">MPT</option>
                                            <option value="MS Master of Science">MS Master of Science </option>
                                            <option value="MS Master of Surgery">MS Master of Surgery</option>
                                            <option value="MS Pharm">MS Pharm</option>
                                            <option value="MSc">MSc</option>
                                            <option value="MSc 5 years">MSc 5 years</option>
                                            <option value="MSc MLT">MSc MLT</option>
                                            <option value="MScEd">MScEd</option>
                                            <option value="MScTech">MScTech</option>
                                            <option value="MSW">MSW</option>
                                            <option value="MTA">MTA</option>
                                            <option value="MTech">MTech</option>
                                            <option value="MUD Master of Urban Design">MUD Master of Urban Design</option>
                                            <option value="MVA Master of Visual Arts1">MVA Master of Visual Arts</option>
                                            <option value="MVSc">MVSc</option>
                                            <option value="One Year Post Graduate Diploma in Personnel Management and Industrial Relations">One Year Post Graduate Diploma in Personnel Management and Industrial Relations</option>
                                            <option value="P G Diploma in Quality Assurance in Microbiology">P G Diploma in Quality Assurance in Microbiology</option>
                                            <option value="PDCFA">PDCFA</option>
                                            <option value="PG  Diploma (from Other Institutions)">PG  Diploma (from Other Institutions)</option>
                                            <option value="PG  Diploma (from University)">PG  Diploma (from University)</option>
                                            <option value="PG Certificate in  Career Educational Councelling">PG Certificate in  Career Educational Councelling</option>
                                            <option value="PG Certificate in Criminology and Criminal Justice Admin">PG Certificate in Criminology and Criminal Justice Admin.</option>
                                            <option value="PG Diploma in Accomodation Operation and Management">PG Diploma in Accomodation Operation and Management</option>
                                            <option value="PG Diploma in Beauty Therapy">PG Diploma in Beauty Therapy</option>
                                            <option value="PG Diploma in Beauty Therapy and Cosmetology">PG Diploma in Beauty Therapy and Cosmetology</option>
                                            <option value="PG Diploma in Clinical Perfusion">PG Diploma in Clinical Perfusion</option>
                                            <option value="PG Diploma in Dialysis Therapy">PG Diploma in Dialysis Therapy</option>
                                            <option value="PG Diploma in Food Analysis and Quality Assuarance">PG Diploma in Food Analysis and Quality Assuarance</option>
                                            <option value="PG Diploma in Medicine">PG Diploma in Medicine</option>
                                            <option value="PG Diploma in Neuro Electro Physiology">PG Diploma in Neuro Electro Physiology</option>
                                            <option value="PG Diploma in Plastic Processing and Testing">PG Diploma in Plastic Processing and Testing</option>
                                            <option value="PG Diploma in Plastic Processing Technology">PG Diploma in Plastic Processing Technology</option>
                                            <option value="PG Diploma in Wind Power Development">PG Diploma in Wind Power Development</option>
                                            <option value="PG Professional Diploma in Special Education">PG Professional Diploma in Special Education</option>
                                            <option value="PG Translation Diploma English-Hindi">PG Translation Diploma English-Hindi</option>
                                            <option value="PGDBA HR">PGDBA HR</option>
                                            <option value="PGDHRM">PGDHRM</option>
                                            <option value="PGDiploma in Dialysis Technology PGDDT">PGDiploma in Dialysis Technology PGDDT</option>
                                            <option value="Pharm D">Pharm D</option>
                                            <option value="Post Graduate Diploma in AccommodationOperation and Mngmnt">Post Graduate Diploma in AccommodationOperation and Mngmnt</option>
                                            <option value="Post Graduate Diploma in Anaesthesiology (DA)">Post Graduate Diploma in Anaesthesiology (DA)</option>
                                            <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option><option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
                                            <option value="Post Graduate Diploma in Child Health">Post Graduate Diploma in Child Health</option>
                                            <option value="Post Graduate Diploma in Clinical Child Development">Post Graduate Diploma in Clinical Child Development</option>
                                            <option value="Post Graduate Diploma in Clinical Nutrition and Dietetics">Post Graduate Diploma in Clinical Nutrition and Dietetics</option>
                                            <option value="Post Graduate Diploma in Clinical Pathology">Post Graduate Diploma in Clinical Pathology</option>
                                            <option value="Post Graduate Diploma in Clinical Psychology">Post Graduate Diploma in Clinical Psychology</option>
                                            <option value="Post Graduate Diploma in Counselling">Post Graduate Diploma in Counselling</option>
                                            <option value="Post Graduate Diploma in Dairy Development">Post Graduate Diploma in Dairy Development</option>
                                            <option value="Post Graduate Diploma in Dairy Quality Control">Post Graduate Diploma in Dairy Quality Control</option>
                                            <option value="Post Graduate Diploma in Dissaster management">Post Graduate Diploma in Dissaster management</option>
                                            <option value="Post Graduate Diploma in eGovernance">Post Graduate Diploma in eGovernance</option>
                                            <option value="Post Graduate Diploma in Finance and HR Management">Post Graduate Diploma in Finance and HR Management</option>
                                            <option value="Post Graduate Diploma in Financial Management">Post Graduate Diploma in Financial Management</option>
                                            <option value="Post Graduate Diploma in Folk Dance and Cultural studies">Post Graduate Diploma in Folk Dance and Cultural studies</option>
                                            <option value="Post Graduate Diploma in Food Science and Technology">Post Graduate Diploma in Food Science and Technology </option>
                                            <option value="Post Graduate Diploma in International Business Operations">Post Graduate Diploma in International Business Operations</option>
                                            <option value="Post Graduate Diploma in IT Enabled Services and BPO">Post Graduate Diploma in IT Enabled Services and BPO</option>
                                            <option value="Post Graduate Diploma in Journalism">Post Graduate Diploma in Journalism</option>
                                            <option value="Post Graduate Diploma in Journalism and Communication">Post Graduate Diploma in Journalism and Communication</option>
                                            <option value="Post Graduate Diploma in Management">Post Graduate Diploma in Management</option>
                                            <option value="Post Graduate Diploma in Management (PGDM)">Post Graduate Diploma in Management (PGDM)</option>
                                            <option value="Post Graduate Diploma in Management of Learning Disabilities">Post Graduate Diploma in Management of Learning Disabilities</option>
                                            <option value="Post Graduate Diploma in Marine Technology (Mechanical)">Post Graduate Diploma in Marine Technology (Mechanical)</option>
                                            <option value="Post Graduate Diploma in Marketing Management">Post Graduate Diploma in Marketing Management</option>
                                            <option value="Post Graduate Diploma in Nutrition and Dietetics">Post Graduate Diploma in Nutrition and Dietetics</option>
                                            <option value="Post Graduate Diploma in Orthopaedics">Post Graduate Diploma in Orthopaedics</option>
                                            <option value="Post Graduate Diploma in Otorhyno Laryngology">Post Graduate Diploma in Otorhyno Laryngology</option>
                                            <option value="Post Graduate Diploma in Personnel Management">Post Graduate Diploma in Personnel Management</option>
                                            <option value="Post Graduate Diploma in Psychiatric Social Work">Post Graduate Diploma in Psychiatric Social Work</option>
                                            <option value="Post Graduate Diploma in Public Relations">Post Graduate Diploma in Public Relations</option>
                                            <option value="Post Graduate Diploma in Public Relations Management">Post Graduate Diploma in Public Relations Management</option>
                                            <option value="Post Graduate Diploma in Regional/City Planning">Post Graduate Diploma in Regional/City Planning</option>
                                            <option value="Post Graduate Diploma in Software Engineering">Post Graduate Diploma in Software Engineering</option>
                                            <option value="Post graduate Diploma in Town and Country Planning">Post graduate Diploma in Town and Country Planning</option>
                                            <option value="Post Graduate Diploma in Travel and Tourism Management">Post Graduate Diploma in Travel and Tourism Management</option>
                                            <option value="Professional Diploma in Clinical Psychology">Professional Diploma in Clinical Psychology</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Course<span class="req redbold">*</span></label>
                                <select class="form-control" name="course_id" id="edit_course" data-validate="required" onchange="get_editbranch()">
                                    <option value="">Select Course</option>';
                                    foreach($this->data["courseArr"] as $course){
                                    if($course['status']==1) {
                            $html .= '<option value="'.$course['class_id'].'">'.$course['class_name'].'</option>';
                                     } 
                                    } 
                        $html .= '</select>              
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Branch<span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_id" id="edit_branch" data-validate="required" onchange="get_editcenter()">
                                    <option value="">Select Branch</option>';
                                 
                                    foreach($this->data['branchArr'] as $branch){
                                         $selected = '';
                                         if($call_centerArr['branch_id'] == $branch['branch_master_id']){
                                            $selected = 'selected="selected"';
                                          }
                                          $html .= '<option value="'.$branch['branch_master_id'].'" '.$selected.'>'.$branch['institute_name'].'</option>'; 
                                        }
                        $html .= '</select>              
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Centre<span class="req redbold">*</span></label>
                                <select class="form-control" name="center_id" id="edit_center" data-validate="required">
                                    <option value="">Select Centre</option>
                                </select>              
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Father Mobile</label>
                                <input class="form-control" type="text" name="father_mobile" placeholder="Father Mobile" id="edit_father_mobile" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Mother Mobile</label>
                                <input class="form-control" type="text" name="mother_mobile" placeholder="Mother Mobile" id="edit_mother_mobile" data-validate="required">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Email Id</label>
                                <input class="form-control" type="text" name="email_id" placeholder="Email Id" id="edit_email_id">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Source</label>
                                <input class="form-control" type="text" name="source" placeholder="Source" id="edit_source">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Timing</label>
                                <input class="form-control datetime" type="text" name="timing" placeholder="Timing" id="edit_timing">
                                <script> 
                                    $(function () {
                                        $(".datetime").datetimepicker({
                                            maxDate: new Date(),
                                            format: "DD/MM/YYYY hh:mm:ss A"
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Status</label>
                                <select class="form-control" name="call_status" id="edit_call_status">
                                    <option value="">Select Status</option>
                                    <option value="1">Call Received</option>
                                    <option value="2">In Progress</option>
                                    <option value="3">Closed</option>
                                    <option value="4">Blacklisted</option>
                                    <option value="5">Registered</option>
                                    <option value="6">Admitted</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label> Hostel</label>
                                <select class="form-control" name="hostel" id="edit_hostel">
                                    <option value="">Select Hostel</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label> Description</label>
                                <input class="form-control" type="text" name="comments" placeholder="Description" id="edit_comments">
                            </div>
                        </div></div>';
                        echo $html;
                    }
                }
      
    public function callback_fetch()
    {
        $query= $this->db->get_where('cc_enquiries');
        $output = '';
        $filter_status = '';
        $filter_sdate = '';
        $filter_edate = '';
        $filter_status = $this->input->post('filter_status');
        $filter_sdate = $this->input->post('filter_sdate');
        $filter_edate = $this->input->post('filter_edate');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role'); 
        $data = $this->call_center_model->call_back_fetch_data($filter_status,$filter_sdate,$filter_edate,$user_id, $role);
        // echo $this->db->last_query();
        $output .= '<div class="table-responsive">
                        <ul class="data_table " id="callback_data">
                            <li class="data_table_head ">
                                <div class="col sl_no ">Sl. No.
                                    <div class="sort_option ">
                                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col  "> Date & Time<div class="sort_option ">
                                    <button class="btn btn-default sort_up ">
                                        <i class="fa fa-caret-left "></i>
                                    </button>
                                    <button class="btn btn-default sort_down ">
                                        <i class="fa fa-caret-right "></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="col  "> Name<div class="sort_option ">
                                    <button class="btn btn-default sort_up ">
                                        <i class="fa fa-caret-left "></i>
                                    </button>
                                    <button class="btn btn-default sort_down ">
                                        <i class="fa fa-caret-right "></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="col ">Status
                                    <div class="sort_option ">
                                        <button type="button" class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                                        <button type="button" class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col actions">Action
                                    <div class="sort_option ">
                                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                                    </div>
                                </div>
                            </li>';
                            if($data->num_rows() > 0){
                                $i=1;
                                foreach($data->result() as $row){
                                    if($row->created_time== NULL){
                                        $new_date = "";
                                    }else{
                                        $date=strtotime($row->created_time); 
                                        $new_date = date("d/m/Y h:i:s A",$date);
                                    }
                                    if($row->status=="Received"){
                                        $selectData ='<option selected value="Received">Received</option>
                                                <option value="Replied">Replied</option>
                                                <option value="Un neccessary">Un neccessary</option>';
                                    }else if($row->status=="Replied"){
                                        $selectData = '<option  value="Received">Received</option>
                                                <option selected value="Replied">Replied</option>
                                                <option value="Un neccessary">Un neccessary</option>';
                                    }else if($row->status=="Un neccessary"){
                                        $selectData = '<option value="Received">Received</option>
                                                <option value="Replied">Replied</option>
                                                <option selected value="Un neccessary">Un neccessary</option>';
                                    }else{
                                        $selectData = '
                                                <option value="Received">Received</option>
                                                <option value="Replied">Replied</option>
                                                <option value="Un neccessary">Un neccessary</option>';
                                    }
                        $output .= '<li>
                                    <div class="col sl_no ">'.$i.'</div>
                                    <div class="col">'.$new_date.'</div>
                                    <div class="col ">'.$row->enquiry_name.'</div>
                                    <div class="col ">
                                    <div class="form-group form_zero" >
                                    <select class="form-control" name="call_back_status" id="call_back_status_'.$row->enquiry_id.'" onchange="get_val('.$row->enquiry_id.')">'.$selectData.'</select>
                                    </div>
                                    </div>
                                    <div class="col actions ">
                                    <button class="btn btn-default option_btn " data-toggle="modal" data-target="#view_queries" onclick="get_callback('.$row->enquiry_id.')">
                                    <i class="fa fa-eye "></i>
                                    </button>
                                    </div>
                                    </li>';
                                    $i++;
                                }
                        $output .= '</ul>
                                    </div>';
                            }else{
                                $output .= '<span><b><center>Sorry!!! No data Found</center></b><span>';
                            }
                        echo $output;
    }

    public function query_fetch()
    {
        $query= $this->db->get_where('cc_enquiries');
        $output = '';
        $filter_status = '';
        $filter_sdate = '';
        $filter_edate = '';
        $filter_status = $this->input->post('filter_status');
        $filter_sdate = $this->input->post('filter_sdate');
        $filter_edate = $this->input->post('filter_edate');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role'); 
        $data = $this->call_center_model->query_fetch_data($filter_status,$filter_sdate,$filter_edate,$user_id, $role);
        // echo $this->db->last_query();
        // die();
        $output .= '<div class="table-responsive">
                        <ul class="data_table " id="query_data">
                            <li class="data_table_head ">
                                <div class="col sl_no ">Sl. No.
                                    <div class="sort_option ">
                                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col  "> Date & Time<div class="sort_option ">
                                    <button class="btn btn-default sort_up ">
                                        <i class="fa fa-caret-left "></i>
                                    </button>
                                    <button class="btn btn-default sort_down ">
                                        <i class="fa fa-caret-right "></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="col  "> Name<div class="sort_option ">
                                    <button class="btn btn-default sort_up ">
                                        <i class="fa fa-caret-left "></i>
                                    </button>
                                    <button class="btn btn-default sort_down ">
                                        <i class="fa fa-caret-right "></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="col ">Status
                                    <div class="sort_option ">
                                        <button type="button" class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                                        <button type="button" class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col actions">Action
                                    <div class="sort_option ">
                                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                                    </div>
                                </div>
                            </li>';
                            if($data->num_rows() > 0){
                                $i=1;
                                foreach($data->result() as $row){
                                    if($row->created_time== NULL){
                                        $new_date = "";
                                    }else{
                                        $date=strtotime($row->created_time); 
                                        $new_date = date("d/m/Y h:i:s A",$date);
                                    }
                                    if($row->status=="Received"){
                                        $selectData ='<option selected value="Received">Received</option>
                                                <option value="Replied">Replied</option>
                                                <option value="Un neccessary">Un neccessary</option>';
                                    }else if($row->status=="Replied"){
                                        $selectData = '<option  value="Received">Received</option>
                                                <option selected value="Replied">Replied</option>
                                                <option value="Un neccessary">Un neccessary</option>';
                                    }else if($row->status=="Un neccessary"){
                                        $selectData = '<option value="Received">Received</option>
                                                <option value="Replied">Replied</option>
                                                <option selected value="Un neccessary">Un neccessary</option>';
                                    }else{
                                        $selectData = '
                                                <option value="Received">Received</option>
                                                <option value="Replied">Replied</option>
                                                <option value="Un neccessary">Un neccessary</option>';
                                    }
                        $output .= '<li>
                                    <div class="col sl_no ">'.$i.'</div>
                                    <div class="col">'.$new_date.'</div>
                                    <div class="col ">'.$row->enquiry_name.'</div>
                                    <div class="col ">
                                    <div class="form-group form_zero" >
                                    <select class="form-control" name="query_status" id="query_status_'.$row->enquiry_id.'" onchange="get_val('.$row->enquiry_id.')">'.$selectData.'</select>
                                    </div>
                                    </div>
                                    <div class="col actions ">
                                    <button class="btn btn-default option_btn " onclick="get_query('.$row->enquiry_id.')">
                                    <i class="fa fa-eye "></i>
                                    </button>
                                    </div>
                                    </li>';
                                    $i++;
                                }
                        $output .= '</ul>
                                    </div>';
                            }else{
                                $output .= '<span><b><center>Sorry!!! No data Found</center></b><span>';
                            }
                        echo $output;
    }
    public function cc_details_ajax() 
    {
      // print_r($_POST); 
        // Datatables Variables
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order  = $this->input->post("order");
        $col    = 0;
        $dir    = "";
        if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

        $columns_valid = array(
            "cc_call_center_enquiries.call_id", 
            "cc_call_center_enquiries.name", 
            "am_classes.class_name", 
            "cc_call_center_enquiries.primary_mobile", 
            "cc_call_center_enquiries.street" ,
            "cc_call_center_enquiries.enquiry_type" ,
            "cc_call_center_enquiries.call_status" ,
        );

        if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        if(empty($this->input->post('search')['value'])){
            $list = $this->call_center_model->get_call_center_list_by_ajax($user_id, $role,$start, $length, $order, $dir);
        }else {
            $search = $this->input->post('search')['value'];
            $list = $this->call_center_model->get_call_center_list_by_ajax_search($user_id, $role,$start, $length, $order, $dir,$search);
        }

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {
            if($rows['call_status']==1){
                $status ='<option selected value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
            }else if($rows['call_status']==2){
                $status = '<option selected value="2">In Progress</option>
                        <option value="1">Call Received</option>
                        <option value="3">Closed</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
            }else if($rows['call_status']==3){
                $status = '<option selected value="3">Closed</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
            }else if($rows['call_status']==4){
                $status = '<option selected value="4">Blacklisted</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
            }else if($rows['call_status']==5){
                $status = '<option  value="4">Blacklisted</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option selected value="5">Registered</option>
                        <option value="6">Admitted</option>';
            }else if($rows['call_status']==6){
                $status = '<option  value="4">Blacklisted</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="5">Registered</option>
                        <option selected value="6">Admitted</option>';    
            }else{
                $status = '<option value="">Select Status</option>
                        <option value="1">Answered</option>
                        <option value="2">No Answer</option>
                        <option value="3">Busy</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
            }
            if($rows['class_name']!= ''){
                $class = $rows['class_name'];
            }else{
                $class = "";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['name'];
            $row[] = $class;
            $row[] = $rows['primary_mobile'];
            $row[] = $rows['street'];
            $row[] = $rows['enquiry_type'];
            $row[] = $status;
            $row[] ='<button type="button" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$rows['call_id'].')">
                        <i class="fa fa-pencil "></i>
                    </button> 
                    <a class="btn btn-default option_btn  " title="Delete" onclick="delete_call_centers('.$rows['call_id'].')">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$rows['call_id'].')">
                        Follow Up
                    </button>';        
            $data[] = $row;
        }

        $total_rows=$this->call_center_model->get_num_callcenters_by_ajax($user_id, $role);
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }

    // public function fetch()
    // {
    //     // print_r($_POST); 
    //     $draw   = intval($this->input->post("draw"));
    //     $start  = intval($this->input->post("start"));
    //     $length = intval($this->input->post("length"));
    //     $order  = $this->input->post("order");
    //     $col    = 0;
    //     $dir    = "";
    //     if(!empty($order)) {
    //         foreach($order as $o) {
    //             $col = $o['column'];
    //             $dir= $o['dir'];
    //         }
    //     }
    //     if($dir != "asc" && $dir != "desc") {
    //         $dir = "asc";
    //     }
    //     $columns_valid = array(
    //         "cc_call_center_enquiries.call_id", 
    //         "cc_call_center_enquiries.name", 
    //         "am_classes.class_name", 
    //         "cc_call_center_enquiries.primary_mobile", 
    //         "cc_call_center_enquiries.street" ,
    //         "cc_call_center_enquiries.enquiry_type" ,
    //         "cc_call_center_enquiries.call_status" ,
    //     );
    //     if(!isset($columns_valid[$col])) {
    //         $order = null;
    //     } else {
    //         $order = $columns_valid[$col];
    //     }
    //     //  print_r($columns_valid); 
        
    //     $user_id = $this->session->userdata('user_id');
    //     $role = $this->session->userdata('role');
    //     $datas =array();
    //     $data_date =array();
    //     if($this->input->post('filter_name')['value']!=""){
    //         $datas['name'] = $this->input->post('filter_name')['value'];
    //     }
    //     if($this->input->post('filter_course')['value']!=""){
    //         $datas['course_id'] = $this->input->post('filter_course')['value'];
    //     }
    //     if($this->input->post('filter_number')['value']!=""){
    //         $datas['primary_mobile'] = $this->input->post('filter_number')['value'];
    //     }
    //     if($this->input->post('filter_status')['value']!=""){
    //         $datas['call_status'] = $this->input->post('filter_status')['value'];
    //     }
    //     if($this->input->post('filter_sdate')['value']!=""){
    //         $data_date['timing'] = $this->input->post('filter_sdate')['value'];
    //     }
    //     if($this->input->post('filter_edate')['value']!=""){
    //         $data_date['timing'] = $this->input->post('filter_edate')['value'];
    //     }
    //     if($this->input->post('filter_enquiry')['value']!=""){
    //         $datas['enquiry_type'] = $this->input->post('filter_enquiry')['value'];
    //     }
    //     if($this->input->post('filter_place')['value']!=""){
    //         $datas['street'] = $this->input->post('filter_place')['value'];
    //     }
    //     if($this->input->post('filter_cce')['value']!=""){
    //         $datas['user_id'] = $this->input->post('filter_cce')['value'];
    //     }
    //     // if(empty($this->input->post('search')['value'])){
    //     if(empty($datas) && empty($data_date)){
    //         $list = $this->call_center_model->get_call_center_list_by_ajax($user_id, $role,$start, $length, $order, $dir);
    //     }else {
    //         // $search = $this->input->post('search')['value'];

    //         $list = $this->call_center_model->get_call_center_list_by_ajax_search($user_id, $role,$start, $length, $order, $dir,$data1,$data_date);
    //     }
    //     // echo '<pre>';
    //     // print_r($datas);
    //     $data = array();
    //     $no = $_POST['start'];
    //     foreach ($list as $rows) {
    //         if($rows['call_status']==1){
    //             $status ='<option selected value="1">Call Received</option>
    //                     <option value="2">In Progress</option>
    //                     <option value="3">Closed</option>
    //                     <option value="4">Blacklisted</option>
    //                     <option value="5">Registered</option>
    //                     <option value="6">Admitted</option>';
    //         }else if($rows['call_status']==2){
    //             $status = '<option selected value="2">In Progress</option>
    //                     <option value="1">Call Received</option>
    //                     <option value="3">Closed</option>
    //                     <option value="4">Blacklisted</option>
    //                     <option value="5">Registered</option>
    //                     <option value="6">Admitted</option>';
    //         }else if($rows['call_status']==3){
    //             $status = '<option selected value="3">Closed</option>
    //                     <option value="1">Call Received</option>
    //                     <option value="2">In Progress</option>
    //                     <option value="4">Blacklisted</option>
    //                     <option value="5">Registered</option>
    //                     <option value="6">Admitted</option>';
    //         }else if($rows['call_status']==4){
    //             $status = '<option selected value="4">Blacklisted</option>
    //                     <option value="1">Call Received</option>
    //                     <option value="2">In Progress</option>
    //                     <option value="3">Closed</option>
    //                     <option value="5">Registered</option>
    //                     <option value="6">Admitted</option>';
    //         }else if($rows['call_status']==5){
    //             $status = '<option  value="4">Blacklisted</option>
    //                     <option value="1">Call Received</option>
    //                     <option value="2">In Progress</option>
    //                     <option value="3">Closed</option>
    //                     <option selected value="5">Registered</option>
    //                     <option value="6">Admitted</option>';
    //         }else if($rows['call_status']==6){
    //             $status = '<option  value="4">Blacklisted</option>
    //                     <option value="1">Call Received</option>
    //                     <option value="2">In Progress</option>
    //                     <option value="3">Closed</option>
    //                     <option value="5">Registered</option>
    //                     <option selected value="6">Admitted</option>';    
    //         }else{
    //             $status = '<option value="">Select Status</option>
    //                     <option value="1">Answered</option>
    //                     <option value="2">No Answer</option>
    //                     <option value="3">Busy</option>
    //                     <option value="4">Blacklisted</option>
    //                     <option value="5">Registered</option>
    //                     <option value="6">Admitted</option>';
    //         }
    //         if($rows['class_name']!= ''){
    //             $class = $rows['class_name'];
    //         }else{
    //             $class = "";
    //         }
    //         $no++;
    //         $row = array();
    //         $row[] = $no;
    //         $row[] = $rows['name'];
    //         $row[] = $class;
    //         $row[] = $rows['primary_mobile'];
    //         $row[] = $rows['street'];
    //         $row[] = $rows['enquiry_type'];
    //         $row[] = $status;
    //         $row[] ='<button type="button" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$rows['call_id'].')">
    //                     <i class="fa fa-pencil "></i>
    //                 </button> 
    //                 <a class="btn btn-default option_btn  " onclick="delete_call_centers('.$rows['call_id'].')">
    //                     <i class="fa fa-trash-o"></i>
    //                 </a>
    //                 <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$rows['call_id'].')">
    //                     Follow Up
    //                 </button>';        
    //         $data[] = $row;
    //     }
    //     // echo '<pre>';
    //     // print_r($data[]);
    //     // die();
    //     $total_rows=$this->call_center_model->get_num_callcenters_by_ajax($user_id, $role);
    //     $output = array(
    //           "draw" => $draw,
    //           "recordsTotal" => $total_rows,
    //           "recordsFiltered" => $total_rows,
    //           "data" => $data
    //       );
    //     echo json_encode($output);
    //     exit();
    // }

}
