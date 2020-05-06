<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hostel extends Direction_Controller {
    
   public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="basic_configuration";
        check_backoffice_permission($module);
    }
    
     public function index(){

		
    }
    public function manage_buildings(){
         check_backoffice_permission('manage_buildings');
		$this->data['page']="admin/hostel_building";
		$this->data['menu']="basic_configuration"; 
        $this->data['groupArr']      = $this->institute_model->get_allgroups(); 
        $this->data['breadcrumb']="Hostel / Building";
        $this->data['menu_item']="manage-buildings";
		$this->load->view('admin/layouts/_master',$this->data); 
    } 
    public function manage_floors(){
         check_backoffice_permission('manage_floors');
		$this->data['page']="admin/hostel_floor";
		$this->data['menu']="basic_configuration";
		$this->data['buildingArr']=$this->common->get_alldata('hl_hostel_building',array('building_status!='=>"2"));
		$this->data['floorArr']=$this->Hostel_model->get_all_hostelFloor();
       // echo "<pre>";print_r($this->data['floorArr']);
        $this->data['breadcrumb']="Hostel / Floor";
        $this->data['menu_item']="manage-floors";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    public function manage_roomtype(){
        check_backoffice_permission('manage_roomtype');
		$this->data['page']="admin/hostel_roomtype";
		$this->data['menu']="basic_configuration";
		$this->data['roomtypeArr']=$this->common->get_alldata_orderby('hl_hostel_roomtype',array('roomtype_status!='=>"2"),'roomtype_id','desc');
        // echo "<pre>";print_r($this->data['roomtypeArr']);
        $this->data['breadcrumb']="Hostel / Room Type";
        $this->data['menu_item']="manage-roomtype";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    public function hostel_building_add()
    {
        
        if($_POST)
        {
            $ajax_response['st']=$this->Hostel_model->hostel_building_add($_POST);
            if($ajax_response['st'] == 1)
            {
               $ajax_response['message']="Building Added Successfully";
            }
            else if($ajax_response['st'] == 2)
            {
                $ajax_response['message']="Already Exist"; 
            }
            else if($ajax_response['st'] == 0)
            {
                $ajax_response['message']="Invalid Request"; 
            }
            print_r(json_encode($ajax_response));
        }
        
    }
    public function get_allsub_byparent()
    {
            $subArr=$this->institute_model->get_allsub_byparent($_POST);
      //  print_r($subArr);
            echo '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                echo '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
        }
    }
 
    public function hostelBuilding_details_ajax()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $order = $this->input->post("order");

        $col = 0;
        $dir = "";
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
            "hl_hostel_building.building_id", 
            "hl_hostel_building.group_id", 
            "hl_hostel_building.branch_id", 
            "hl_hostel_building.centre_id", 
            "hl_hostel_building.building_name", 
            "hl_hostel_building.building_status" 
        );

        if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        
         if(empty($this->input->post('search')['value']))
        {
            $list = $this->Hostel_model->hostelBuilding_details_ajax($start, $length, $order, $dir);
        }
        else {
            $search = $this->input->post('search')['value'];
            // show($search);
            $list = $this->Hostel_model->hostelBuilding_details_ajax_search($start, $length, $order, $dir,$search);
        }
          $data = array();

        $no = $_POST['start'];
        foreach ($list as $rows) {

            $group_name=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$rows['group_id'],"institute_type_id"=>"1"));  
            $branch_name=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$rows['branch_id'],"institute_type_id"=>"2","parent_institute"=>$rows['group_id']));
            $centre_name=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$rows['centre_id'],"institute_type_id"=>"3","parent_institute"=>$rows['branch_id'])); 
            if($rows['building_status'] == "0")
             {
                $status_value=1;
                $status='<span class="btn mybutton mybuttonInactive" onclick="edit_building_status('.$rows['building_id'].','.$status_value.');">Inactive</span>';
                $delete='<a class="btn btn-default option_btn" title="Delete" onclick="delete_buildingdata('.$rows['building_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
             }
            else
            {
                 $status_value=0;
               $status='<span class="btn mybutton  mybuttonActive" onclick="edit_building_status('.$rows['building_id'].','.$status_value.');">Active</span>'; 
                $delete='';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $group_name;
            $row[] = $branch_name;
            $row[] = $centre_name;
            $row[] = $rows['building_name'];
            $row[] = $status;
            $row[] = '<button class="btn btn-default option_btn " title="Edit" onclick="get_buildingdata('.$rows['building_id'].')">
                     <i class="fa fa-pencil "></i></button>'.$delete;
            $data[] = $row;
        }

        $total_rows=$this->Hostel_model->getNum_hostelBuilding_details_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }
   //show building data by id
    public function get_hostel_buildingdata_byId()
    {
        if($_POST){
            $building_id =    $this->input->post('building_id');
            $ajax_data   =    $this->Hostel_model->get_hostel_buildingdata_byId($building_id);
         
            $group_id=$ajax_data['group_id'];
            $branch_id=$ajax_data['branch_id'];
           
            $branchArr=$this->institute_model->get_allsub_byparent(array("parent_institute"=>$group_id));
      
           $branch_html="";
           if(!empty($branchArr)){
                foreach ($branchArr as $row)
                {
                     $branch_html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                }
            }
            $ajax_data['branches']=$branch_html;
            
             $centreArr=$this->institute_model->get_allsub_byparent(array("parent_institute"=>$branch_id));
             $centre_html="";
             if(!empty($centreArr))
             {
                foreach ($centreArr as $row)
                {
                     $centre_html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                }
             }
            $ajax_data['centres']=$centre_html;
            
            print_r(json_encode($ajax_data));
        }
    }
    
    //edit hostel building
    public function hostel_building_edit()
    {
        
        $building_id  =   $this->input->post('building_id');
        unset($_POST['building_id']);
        if($_POST){
            
            $response=$this->Hostel_model->hostel_building_edit($building_id,$_POST); 
            //echo $response;
            if($response == 1)
            {
              $ajax_response['st']=1;  
              $ajax_response['message']="Successfully Updated Building Details";
            }
            else if($response == 2)
            {
               $ajax_response['st']=2;  
              $ajax_response['message']="Already Exist";   
            }
            else 
            {
               $ajax_response['st']=0;  
              $ajax_response['message']="Invalid Request";   
            }
            print_r(json_encode($ajax_response));
            
        }
        
    }
   //delete building 
    function delete_buildingdata(){
        $id      = $this->input->post('id');
        $where = array('building_id'=>$id);
        $data  = array('building_status'=>2); 
        $what = '';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($id!= '') {
            $exist=$this->common->hostel_checking('building',$id);
            if($exist)
            {
                $query = $this->common->delete_fromwhere('hl_hostel_building', $where, $data);
                $res['status']   = true; 
                $res['message']  = 'Building deleted successfully'; 
                $res['data']     = ''; 
                $table_row_id    = $this->db->insert_id();
                logcreator('delete', 'Building detailed deleted', $who, $what, $id, 'hl_hostel_building','Hostel building deleted');
            }
            else
            {
               $res['status']   = '2'; 
               $res['message']  = "Please delete floor details first"; 
            }
              
        } else {
            
           $res['status']   = false; 
           $res['message']  = 'Invalid data'; 
           $res['data']     = array();
           logcreator('error', 'Building detail deletion failed', $who, $what, $id, 'hl_hostel_building','Error while deleting floor details');
        }
        print_r(json_encode($res));
    }
    public function hostel_building_status()
    {
        if($_POST)
        {
            $building_status=$this->input->post('building_status');
            $building_id=$this->input->post('building_id');
            $what = '';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            
            if($building_id!= "" && $building_status!="") {              
            
               if($building_status == 0)
               {
                    $exist=$this->common->hostel_checking('building',$building_id);
                     if($exist)
                     { 
                          $response['st']=$this->Hostel_model->hostel_building_status($building_id,$building_status);
                           $what =$this->db->last_query();
                          logcreator('update', 'Hostel building status deactivated', $who, $what, $building_id, 'hl_hostel_building','Building Status Deactivated');
                     }
                     else
                     {
                        $response['st']="2"; //first decativte floor details
                        
                     }
                }
                else
                {
                    $response['st']=$this->Hostel_model->hostel_building_status($building_id,$building_status);
                    $what =$this->db->last_query();
                    logcreator('update', 'Hostel building status activated', $who, $what, $building_id, 'hl_hostel_building','');
                }
              
            }
            else 
            {
           logcreator('error', 'Hostel building status changing failed', $who, $what, $building_id, 'hl_hostel_building','');    
            }
            print_r(json_encode($response));
        }
    }
    
    //add floor
    public function hostel_floor_add()
    {
        
        if($_POST)
        {
           $ajax_response['st']=$this->Hostel_model->hostel_floor_add($_POST);
             if($ajax_response['st'] == 1)
            {
                  $what=$this->db->last_query();
                  $table_row_id=$this->db->insert_id();
                  $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
               $ajax_response['message']="Floor Added Successfully";
               logcreator('Edit', 'New building floor created', $who, $what, $table_row_id, 'hl_hostel_floor','');
            }
            else if($ajax_response['st'] == 2)
            {
                $ajax_response['message']="Already Exist"; 
            }
            else if($ajax_response['st'] == 0)
            {
                $ajax_response['message']="Invalid Request"; 
            }
            print_r(json_encode($ajax_response));
        }
    }
    
    //delete floor
        function delete_floordata(){
                    $id      = $this->input->post('floor_id');
                    $where = array('floor_id'=>$id);
                    $data  = array('floor_status'=>2);
                    $what = '';
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    if($id!= '') {
                         $exist=$this->common->hostel_checking('floor',$id);
                        if($exist)
                        {
                            $query = $this->common->delete_fromwhere('hl_hostel_floor', $where, $data);
                            $res['status']   = true;
                            $res['message']  = 'Floor deleted successfully';
                            $res['data']     = '';
                            $table_row_id    = $this->db->insert_id();
                            logcreator('delete', 'Building floor deleted', $who, $what, $id, 'hl_hostel_floor',''); 
                        }
                        else
                        {
                           $res['status']   = "2";
                           $res['message']  = 'Please delete room details first';  
                        }
                        
                    } else {

                       $res['status']   = false;
                       $res['message']  = 'Invalid data';
                       $res['data']     = array();
                       logcreator('error', 'Building floor deletion failed', $who, $what, $id, 'hl_hostel_floor','');
                    }
                    print_r(json_encode($res));
    }

    //change status of floor
    public function hostel_floor_status()
    {

        if($_POST)
        {
            $floor_status=$this->input->post('floor_status');
            $floor_id=$this->input->post('floor_id');
            $what = '';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];

            if($floor_id!= "" && $floor_status!="") 
            {
               
               
                if($floor_status == 0)
                {
                        $exist=$this->common->hostel_checking('floor',$floor_id);
                       // echo $this->db->last_query();
                        if($exist)
                        {
                        $response['st']=$this->Hostel_model->hostel_floor_status($floor_id,$floor_status);
                            $what =$this->db->last_query();
                        logcreator('update', 'Building floor status changed to deactivated', $who, $what, $floor_id, 'hl_hostel_floor','');
                        }
                        else
                        {
                          $response['st']=2;//deactivate rooms first  
                        }
                }
                else
                {
                    
                    $response['st']=$this->Hostel_model->hostel_floor_status($floor_id,$floor_status);
                    $what =$this->db->last_query();
                    logcreator('update', 'Building floor status changed to activated', $who, $what, $floor_id, 'hl_hostel_floor','');
                }
            
            }
            else
            {
                logcreator('error', 'Building floor status changing failed', $who, $what, $floor_id, 'hl_hostel_floor','');
            }
            print_r(json_encode($response));
        }
    }
    //get fllor details by floor id
    public function get_hostel_floordata_byId()
    {
        if($_POST){
            $floor_id =    $this->input->post('floor_id');
            $ajax_data['data'] =  $this->common->get_from_tablerow('hl_hostel_floor',array('floor_id'=>$floor_id));
            print_r(json_encode($ajax_data));
        }
    }
    //edit floor
    public function hostel_floor_edit()
    {
       $floor_id  =   $this->input->post('floor_id');
        unset($_POST['floor_id']);

        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($_POST){

            $response=$this->Hostel_model->hostel_floor_edit($floor_id,$_POST);
            $what= $this->db->last_query();
            if($response == 1)
            {
              logcreator('Edit', 'Building floor detail edited', $who, $what, $floor_id, 'hl_hostel_floor','');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Floor Details";
            }
            else if($response == 2)
            {
               $ajax_response['st']=2;
              $ajax_response['message']="Already Exist";
            }
            else
            {
               $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }


            print_r(json_encode($ajax_response));
        }
    }
 //add roomtype
    public function hostel_roomtype_add()
    {
       if($_POST)
        {
           $ajax_response['st']=$this->Hostel_model->hostel_roomtype_add($_POST);
             if($ajax_response['st'] == 1)
            {
                  $what=$this->db->last_query();
                  $table_row_id=$this->db->insert_id();
                  $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
               $ajax_response['message']="RoomType Added Successfully";
               logcreator('Added', 'Hostel new room type added', $who, $what, $table_row_id, 'hl_hostel_roomtype','');
            }
            else if($ajax_response['st'] == 2)
            {
                $ajax_response['message']="Already Exist";
            }
            else if($ajax_response['st'] == 0)
            {
                $ajax_response['message']="Invalid Request";
            }
            print_r(json_encode($ajax_response));
        }
    }

    //edit room type
    public function hostel_roomtype_edit()
    {
       $roomtype_id  =   $this->input->post('roomtype_id');
        unset($_POST['roomtype_id']);

        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($_POST){

            $response=$this->Hostel_model->hostel_roomtype_edit($roomtype_id,$_POST);
            $what= $this->db->last_query();
            if($response == 1)
            {
              logcreator('Edit', 'Hostel room type edited', $who, $what, $roomtype_id, 'hl_hostel_roomtype','');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Roomtype Details";
            }
            else if($response == 2)
            {
               $ajax_response['st']=2;
              $ajax_response['message']="Already Exist";
            }
            else
            {
               $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }


            print_r(json_encode($ajax_response));
        }
    }
        //get roomtype data by id
        public function get_hostel_roomtypedata_byId()
        {
           if($_POST){
            $roomtype_id =    $this->input->post('roomtype_id');
            $ajax_data['data'] =  $this->common->get_from_tablerow('hl_hostel_roomtype',array('roomtype_id'=>$roomtype_id));
            print_r(json_encode($ajax_data));
        }
        }

    //change status of roomtype
    public function hostel_roomtype_status()
    {
         if($_POST)
        {
            $roomtype_status=$this->input->post('roomtype_status');
            $roomtype_id=$this->input->post('roomtype_id');
            $what = '';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];

            if($roomtype_id!= "" && $roomtype_status!="") {
             
              
               if($roomtype_status == 0)
               {
                   $exist=$this->common->hostel_checking('roomtype',$roomtype_id);
                        if($exist)
                        {
                            $response['st']=$this->Hostel_model->hostel_roomtype_status($roomtype_id,$roomtype_status);
                             $what =$this->db->last_query();
                            logcreator('update', 'Building room type status changed to deactivated', $who, $what, $roomtype_id, 'hl_hostel_roomtype','');
                        }
                       else
                       {
                          $response['st']=2;// first decativate rooms
                       }
                }
                else
                {
                     $response['st']=$this->Hostel_model->hostel_roomtype_status($roomtype_id,$roomtype_status);
                     $what =$this->db->last_query();
                    logcreator('update', 'Building room type status changed to activated', $who, $what, $roomtype_id, 'hl_hostel_roomtype','');
                }
            
            }
            else
            {
           logcreator('error', 'Building room type status changing failed', $who, $what, $roomtype_id, 'hl_hostel_roomtype','');
            }
            print_r(json_encode($response));
        }
    }

    //delete roomtype
        function delete_roomtypedata(){

                    $id      = $this->input->post('roomtype_id');
                    $where = array('roomtype_id'=>$id);
                    $data  = array('roomtype_status'=>2);
                    $what = '';
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    if($id!= '') {
                         $exist=$this->common->hostel_checking('roomtype',$id);
                        if($exist)
                        {
                        $query = $this->common->delete_fromwhere('hl_hostel_roomtype', $where, $data);
                        $res['status']   = true;
                        $res['message']  = 'RoomType Data deleted successfully';
                        $res['data']     = '';
                        $table_row_id    = $this->db->insert_id();
                        logcreator('delete', 'Building room type deleted', $who, $what, $id, 'hl_hostel_roomtype','');
                        }
                        else
                        {
                           $res['status']   = 2;
                           $res['message']  = 'Please delete room details first';  
                        }
                    } else {

                       $res['status']   = false;
                       $res['message']  = 'Invalid data';
                       $res['data']     = array();
                       logcreator('error', 'Building room type deletion failed', $who, $what, $id, 'hl_hostel_roomtype','');
                    }
                    print_r(json_encode($res));
    }
     //manage rooms
    public function manage_rooms()
    {
        check_backoffice_permission('manage_rooms');
		$this->data['page']="admin/hostel_rooms";
		$this->data['menu']="basic_configuration";
        $this->data['buildingArr']=$this->common->get_alldata('hl_hostel_building',array('building_status'=>"1"));
        $this->data['roomTypeArr']=$this->common->get_alldata('hl_hostel_roomtype',array('roomtype_status'=>"1"));
        $this->data['roomArr']=$this->Hostel_model->get_allroom_list();
        $this->data['breadcrumb']="Hostel / Rooms";
        $this->data['menu_item']="manage-rooms";
		$this->load->view('admin/layouts/_master',$this->data); 
    } 
    //get floors by building id
    public function get_floors_by_buildingId()
    {
        if($_POST){
                 $floorArr=$this->Hostel_model->get_floors_by_buildingId($_POST);

                    echo '<option value="">Select Floor</option>';
                   if(!empty($floorArr)){
                    foreach ($floorArr as $row)
                    {
                        echo '<option value="' . $row['floor_id'] . '" >' . $row['floor'] . '</option>';
                    }
                   }
          }
  }
    //add rooms
    public function hostel_rooms_add()
    {
        if($_POST)
        {
           $ajax_response['st']=$this->Hostel_model->hostel_rooms_add($_POST);
             if($ajax_response['st'] == 1)
            {
                  $what=$this->db->last_query();
                  $table_row_id=$this->db->insert_id();
                  $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
               $ajax_response['message']="Room Added Successfully";
               logcreator('Added', 'New hostel room added', $who, $what, $table_row_id, 'hl_hostel_rooms','');
            }
            else if($ajax_response['st'] == 2)
            {
                $ajax_response['message']="Already Exist";
            }
            else if($ajax_response['st'] == 0)
            {
                $ajax_response['message']="Invalid Request";
            }
            print_r(json_encode($ajax_response));
        }
    }
    //get room data by id
    public function get_hostel_roomdata_byId()
    {
        if($_POST){
            $room_id =    $this->input->post('room_id');
            $ajax_data['data'] =  $this->Hostel_model->get_hostel_roomdata_byId($room_id);
            $floorArr=$this->Hostel_model->get_floors_by_buildingId(array("building_id"=>$ajax_data['data']['building_id']));

                     $ajax_data['floors']= '<option value="">Select Floor</option>';
                   if(!empty($floorArr)){
                    foreach ($floorArr as $row)
                    {
                        $ajax_data['floors'].= '<option value="' . $row['floor_id'] . '" >' . $row['floor'] . '</option>';
                    }
                   }

            print_r(json_encode($ajax_data));
        }
    }
    
    //edit room
    public function hostel_rooms_edit()
    {
       $room_id  =   $this->input->post('room_id');
        unset($_POST['room_id']);

        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($_POST){

            $response=$this->Hostel_model->hostel_room_edit($room_id,$_POST);
            $what= $this->db->last_query();
            if($response == 1)
            {
              logcreator('Edit', 'Hostel room edited', $who, $what, $room_id, 'hl_hostel_rooms','');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Room Details";
            }
            else if($response == 2)
            {
               $ajax_response['st']=2;
              $ajax_response['message']="Already Exist";
            }
            else
            {
               $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }


            print_r(json_encode($ajax_response));
        }
    }
    
    //delete roomtype
    public function delete_roomdata(){

                    $id      = $this->input->post('room_id');
                    $where = array('room_id'=>$id);
                    $data  = array('room_status'=>2);
                    $what = '';
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    if($id!= '') {
                         $exist=$this->common->hostel_checking('room',$id);
                        if($exist)
                        {
                        $query = $this->common->delete_fromwhere('hl_hostel_rooms', $where, $data);
                        $res['status']   = true;
                        $res['message']  = 'Room Data deleted successfully';
                        $res['data']     = '';
                        $table_row_id    = $this->db->insert_id();
                        logcreator('delete', 'Hostel room deleted', $who, $what, $id, 'hl_hostel_rooms','');
                        }
                        else
                        {
                           $res['status']   = 2;
                           $res['message']  = 'This room is occupied';  
                        }
                    } else {

                       $res['status']   = false;
                       $res['message']  = 'Invalid data';
                       $res['data']     = array();
                       logcreator('error', 'Hostel room deletion failed', $who, $what, $id, 'hl_hostel_rooms','');
                    }
                    print_r(json_encode($res));
    }
    //manage room booking
    public function manage_roombooking($id="")
    {
        check_backoffice_permission('manage_roombooking');
        $this->data['page']="admin/hostel_room_booking";
		$this->data['menu']="basic_configuration";
        $this->data['buildingArr']=$this->common->get_alldata('hl_hostel_building',array('building_status'=>"1"));
        $this->data['roomTypeArr']=$this->Hostel_model->get_roomtype_for_HostelBooking();
        $this->data['breadcrumb']="Hostel / Room Booking";
        $this->data['menu_item']="manage-roombooking";
        if(!empty($id)){
            $this->data['studentid']=$id;
        }
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    //get list of rooms by building,floor and roomtype
    public function get_roomlist_for_booking()
    {
        
        if($_POST)
        {
            $room_id=$this->input->post("room_id");
            unset($_POST['room_id']);
           $roomArr=$this->Hostel_model->get_roomlist_for_booking($_POST);
           
            $ajax_response['html']='';
                if(!empty($roomArr))
                {               $checked="";
                                $class="";
                        foreach($roomArr as $row)
                        { 
                            //show the room as checked in edit
                            if($room_id !="")
                            {    $checked="";
                                 $class="";
                               
                               if($room_id == $row['room_id'])
                               {
                                   $checked="checked";
                                   $class="roomSelected";
                               }
                            }
                         $alloted_beds=$this->common->get_numof_alloted_beds($row['room_id']);
                            //echo $alloted_beds."<br>";
                           // echo $this->db->last_query()."<br>";
                             if($alloted_beds == $row['room_capacity']){

                                $ajax_response['html'].='<li class="roomFill" onclick="get_student();" class="'.$class.'">
                             <div class="roomSpan">
                                    <span>'.$row['room_number'].'</span>
                             </div>
                             <input disabled '.$checked.' type="radio" name="room" value="'.$row['room_id'].'" id="'.$row['room_id'].'"/>
                             <span class="roombed spanFill">'.$alloted_beds.'/'.$row['room_capacity'].'</span>
                            </li>';
                            }
                            else
                            {
                                $ajax_response['html'].='<li  onclick="get_student();" class="'.$class.'">
                             <div class="roomSpan">
                                    <span>'.$row['room_number'].'</span>
                             </div>
                             <input '.$checked.' type="radio" name="room" value="'.$row['room_id'].'" id="'.$row['room_id'].'"/>
                             <span class="roombed">'.$alloted_beds.'/'.$row['room_capacity'].'</span>
                            </li>';
                            }
                         
                        }
                   
                }
            else
            {
                $ajax_response['html']='No Rooms Available';
            }
             print_r(json_encode($ajax_response));
          }
        
    }
    //get students list for hostel
    public function get_studentlist_for_hostel()
    {
        $studentArr=$this->Hostel_model->get_studentlist_for_hostel();
        $ajax_response['html']='<option value="">'.$this->lang->line('select_student').'</option>';
            foreach($studentArr as $row)
            { 
             $ajax_response['html'].='<option value="'.$row['student_id'].'">'.$row['registration_number'].'  ('.$row['name'].')</option>';
            }
             print_r(json_encode($ajax_response));
    }
    //show student for hostel
    public function show_student_for_hostel()
    {
        if($_POST){
            $student_id=$this->input->post('student_id');
            
            $studentArr=$this->common->get_from_tablerow('am_students', array("student_id"=>$student_id));
          
             $ajax_response['html']='<option value="'.$student_id.'">'.$studentArr['registration_number'].'  ('.$studentArr['name'].')</option>';
            
        }
             print_r(json_encode($ajax_response));
    }
    
    public function get_student_hostelDetails()
    {
      if($_POST)
      {  
          $student_id=$this->input->post('student_id');  
          $exist=$this->common->check_if_dataExist('hl_room_booking',array("delete_status"=>"1","student_id"=>$student_id));
          
          if($exist >0)
          {
             $room_data=$this->common->get_from_tablerow('hl_room_booking', array("student_id"=>$student_id));
             if(!empty($room_data))
             {
                 $hostelArr= $this->Hostel_model->get_hostel_roomdata_byId($room_data['room_id']);
                // print_r($hostelArr);
                 $building_id=$hostelArr['building_id'];
                 $floor_id=$hostelArr['floor_id'];
                 $roomtype_id=$hostelArr['roomtype_id'];
                 $room_id=$hostelArr['room_id'];
                 $ajax_data['data']=$hostelArr;
                 $ajax_data['status']=1;
             }
          }
          else
          {
              $ajax_data['status']=0; 
          }
         
          
     }
        else
        {
            $ajax_data['status']=0;  
        }
        print_r(json_encode($ajax_data));
        
    }
    //room booking for student
    public function hostel_rooms_booking()
    {
        if($_POST)
        {
             $room_type=$this->input->post('roomtype_id');
            $from_reg_page=$this->input->post('from_registration');
            // if($from_reg_page != "")
            // {
                $status="payment pending";
            // }
            // else
            // {
            //     $status="alloted";
            // }
            $data = array(
                        "room_id"=>$this->input->post('room'),
                        "student_id"=>$this->input->post('student'),
                        "status"=>$status
                    );
            $student_id=$this->input->post('student');
            $check=$this->common->check_if_dataExist('hl_room_booking',array("student_id"=>$student_id,"delete_status"=>"1","status"=>"payment pending"));
           
            if($check >0)
            {
              $response=$this->Common_model->update('hl_room_booking',$data,array("student_id"=>$student_id,"delete_status"=>"1","status"=>"payment pending"));   
            }
            else
            {
               $response=$this->Hostel_model->hostel_rooms_booking($data);
                if($response == 1)
               {
                //hostel room addedd success
                    $student_status=$this->common->get_name_by_id('am_students','status',array("student_id"=>$student_id));
                   // $check_paid=$this->common->check_if_dataExist('pp_student_payment',array("student_id"=>$student_id,"status"=>"1"));
                    if($student_status == 1)//admitted status
                    {
                        $hostel_fee= $this->common->get_hostel_fee_InBooking($student_id,$room_type);
                        // $payementArr=$this->common->get_from_tablerow('pp_student_payment',array("student_id"=>$student_id));
                        // if($payementArr['hostel_fee'] == "")
                        // {
                        //     $payable_amount= $hostel_fee+$payementArr['payable_amount'];
                        //     $balance= $hostel_fee+$payementArr['balance'];
                        //     $payement_data=array("hostel_fee"=>$hostel_fee,
                        //                          "payable_amount"=>$payable_amount,
                        //                          "balance"=>$balance
                        //                         );
                        //     $update=$this->Common_model->update('pp_student_payment', $payement_data,array("student_id"=>$student_id));  
                        // }
                       
                         //echo $this->db->last_query();
                    }
                }
            }
           
             if($response == 1)
            {
                  $what=$this->db->last_query();
                  $table_row_id=$this->db->insert_id();
                  $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
              logcreator('Insert', 'Alloted room for student', $who, $what, $table_row_id, 'hl_room_booking','');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Alloted Room";
            }
            else
            {
               $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }
            print_r(json_encode($ajax_response));
        }
    }
    
    //search booking
    public function search_roombooking($id="")
    {
        check_backoffice_permission('search_roombooking');
        $this->data['page']="admin/search_roombooking";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Hostel / Search";
        $this->data['menu_item']="search-roombooking";
        $this->data['details']=$this->Hostel_model->all_roombooking_list();
        $this->data['studentArr']=$this->Hostel_model->get_studentlist_for_hostelsearch();
        $this->data['buildingArr']=$this->common->get_alldata('hl_hostel_building',array('building_status'=>"1"));
        $this->data['roomTypeArr']=$this->common->get_alldata('hl_hostel_roomtype',array('roomtype_status'=>"1"));
		$this->load->view('admin/layouts/_master',$this->data);   
    }

    public function get_student_hostel_rent($student_id,$booking_id){
		$html = $this->load->view('admin/hostel/get_student_hostel_rent',['student_id'=>$student_id,'booking_id'=>$booking_id],true);   
        print_r(json_encode($html));
    }
    
    public function get_hostel_rent(){
        if($_POST){
            $html = $this->load->view('admin/hostel/get_hostel_rent',[],true);   
            print_r($html);
        }
    }

    public function payInitial_hostel_rent($student_id,$booking_id){
        $fee_details = $this->Hostel_model->get_student_hostel_rent($student_id,$booking_id); 
        $monthly_fees = $fee_details['monthly_fees'];
        $onetime_fees = $fee_details['onetime_fees'];
        $payed_rent = $this->Hostel_model->get_student_hostel_rent_payments($booking_id); 
        $ph_id = $this->input->post('ph_id');
        $amount = $this->input->post('amount');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $month_amount = $this->input->post('month_amount');
        $data = [];
        if(empty($payed_rent)){
            if(!empty($ph_id)){
                foreach($ph_id as $k=>$val){
                    array_push($data,array(
                        'hl_room_booking_id'=>$monthly_fees['hl_room_booking_id'],
                        'hostel_fee_id'=>$monthly_fees['hostel_fee_id'],
                        'payment_type'=>1,
                        'ph_id'=>$ph_id[$k],
                        'amount'=>$amount[$k],
                        'payable_amount'=>$amount[$k],
                        'payed_amount'=>$amount[$k],
                        'payed_date'=>date('Y-m-d H:i:s',time())
                    ));
                }
            }
            array_push($data,array(
                'hl_room_booking_id'=>$monthly_fees['hl_room_booking_id'],
                'hostel_fee_id'=>$monthly_fees['hostel_fee_id'],
                'payment_type'=>2,
                'month'=>$month[0],
                'amount'=>$month_amount[0],
                'payable_amount'=>$month_amount[0],
                'payed_amount'=>$month_amount[0],
                'from_date'=>date('Y-m-d H:i:s',time()),
                'to_date'=>date('Y-m-t H:i:s',time()),
                'payed_date'=>date('Y-m-d H:i:s',time())
            ));
            // show($data);
            $this->Hostel_model->save_hostel_rent($data); 
            $this->Hostel_model->update_hostel_room_booking(['status'=>'checkin','check_in'=>date('Y-m-d H:i:s',time())],$monthly_fees['hl_room_booking_id']); 
        }else{
            foreach($month as $k=>$val){
                array_push($data,array(
                    'hl_room_booking_id'=>$monthly_fees['hl_room_booking_id'],
                    'hostel_fee_id'=>$monthly_fees['hostel_fee_id'],
                    'payment_type'=>2,
                    'month'=>$month[$k],
                    'amount'=>$month_amount[$k],
                    'payable_amount'=>$month_amount[$k],
                    'payed_amount'=>$month_amount[$k],
                    'from_date'=>date('Y-m-d H:i:s',strtotime($year[$k].'-'.$month[$k].'-01')),
                    'to_date'=>date('Y-m-t H:i:s',strtotime($year[$k].'-'.$month[$k].'-01')),
                    'payed_date'=>date('Y-m-d H:i:s',time())
                ));
            }
            $this->Hostel_model->save_hostel_rent($data); 
        }
        print_r(json_encode(['st'=>true]));
    }

    //get roomlist by building
    public function get_room_by_building()
    {
        if($_POST)
        {
            $roomArr=$this->Hostel_model->get_roomlist_for_booking($_POST); 
            $ajax_response['html']='<option value="">Select</option>';
            if(!empty($roomArr))
            {
                foreach($roomArr as $row)
                {
                    $ajax_response['html'].='<option value="'.$row['room_id'].'">'.$row['room_number'].'</option>';
                }
                
             }
            print_r(json_encode($ajax_response));
        }
    }

    public function student_room_checkout($id){
        $this->Common_model->update('hl_room_booking',['status'=>'checkout','check_out'=>date('Y-m-d',time())],["id"=>$id]);   
        $response['st'] = 1;
        $response['message'] = 'Student checked out successfully';
        print_r(json_encode($response));
    }
    
    //search booking
    public function search_booking()
    {
        if($_POST)
        {
           //print_r($_POST);
            $reg_num=$this->input->post('registration_number');
            $contact_number=$this->input->post('contact_number');
            $building_id=$this->input->post('building_id');
            $room_number=$this->input->post('room_id');
            $status=$this->input->post('status');
            
            
            $where=array();
            $where['delete_status'] = 1;
            if($reg_num)
            {
                $where['am_students.student_id']=$reg_num;
            }
            if($contact_number)
            {
              $where['am_students.contact_number']=$contact_number;
            }
            if($building_id)
            {
              $where['hl_hostel_rooms.building_id']=$building_id;
            }
            if($room_number)
            {
              $where['hl_hostel_rooms.room_number']=$room_number;
            }
            if($status)
            {
              $where['hl_room_booking.status']=$status;
            }
             if($this->input->post('check_in'))
            {
             $check_in=date('Y-m-d',strtotime($this->input->post('check_in')));
              $where['hl_room_booking.check_in']=$check_in;
            }
            if($this->input->post('check_out'))
            {
                $check_out=date('Y-m-d',strtotime($this->input->post('check_out')));
                $where['hl_room_booking.check_out']=$check_out;
            }

            $data=$this->Hostel_model->search_booking($where);
           
            $html = '<thead><tr>
                <th width="50">'.  $this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('student_reg.no').'</th>
                <th>'.$this->lang->line('contact.no').'</th>
                <th>'.$this->lang->line('building').'</th>
                <th>'.$this->lang->line('room_no').'</th>
                <th>'.$this->lang->line('status').'</th>
                <th>'.$this->lang->line('checkin').'</th>
                <th>'.$this->lang->line('checkout').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
                if(!empty($data))
                {
                    $i=1;
                    foreach($data as $row)
                    {
                        $checkin="";
                        $checkout="";
                        if(!empty($row['check_in']))
                        {
                            $checkin = date('d-m-Y',strtotime($row['check_in']));
                        }

                        if(!empty($row['check_out'])){
                                $checkout = date('d-m-Y',strtotime($row['check_out']));
                            }

                        if($row['status'] == "alloted")
                        {
                            $class="registered";
                            $status="Alloted";
                        }
                        else if($row['status'] == "checkin")
                        {
                            $class="admitted";
                            $status="Check In";
                        }
                        else if($row['status'] == "checkout")
                        {
                            $class="inactivestatus";
                            $status="Check Out";
                        }
                        else if($row['status'] == "payment pending")
                        {
                            $class="paymentcompleted";
                            $status="Payment Pending";
                        }

                        $html .= '<tr>
                        <td>'.$i.'</td>
                        <td>'.$row['registration_number'].'</td>
                        <td>'.$row['contact_number'].'</td>
                        <td>'.$row['building_name'].'</td>
                        <td>'.$row['room_number'].'</td>
                        <td>
                                <span class="'.$class.'">'.$status.'</span>
                        </td>
                        <td>'.$checkin.'</td>
                        <td>'.$checkout.'</td>
                        <td>';
                    if($row['status'] == "payment pending"){
                        $html .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_roomdata('. $row['id'].')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                        $html .= '<a class="btn btn-default option_btn" title="Delete" onclick="delete_bookedroomdata('. $row['id'].')">
                                    <i class="fa fa-trash-o"></i>
                                </a>';
                    }
                    if($row['status'] == "checkin"){
                        $html .= '<button onclick="student_room_checkout('.$row['id'].')" style="margin-right:5px;" class="btn btn-danger btn-sm btn_details_view" >
                                    Checkout
                                </button>';
                    }
                    $html .= '<button onclick="get_hostel_rent('.$row['student_id'].','.$row['id'].')" class="btn btn-primary btn-sm btn_details_view" >
                                View and Pay Hostel Rent
                            </button>';
                    $html .= '</td></tr>';
                    $i++;
                }
            }
            echo $html;
        }
    }
    
    
    public function get_booked_roomdata_byId(){
        if($_POST){   
            $id=$this->input->post('id');
            $Booked_room_data=$this->Hostel_model->get_booked_roomdata_byId($id);
            if($Booked_room_data['status'] == "checkin"){
               $ajax_response['date'] =date('d-m-Y',strtotime($Booked_room_data['check_in']));
            }elseif($Booked_room_data['status'] == "checkout"){
               $ajax_response['date'] = date('d-m-Y',strtotime($Booked_room_data['check_out']));
            }
            $ajax_response['roomData']=$Booked_room_data;
            $ajax_response['statusArr']= '<option value="">'.$this->lang->line('select_status').'</option>';
            if($Booked_room_data['status']== "alloted")
            {
              $ajax_response['statusArr'].='<option value="alloted">'.$this->lang->line('alloted').'</option><option value="checkin">'.$this->lang->line('checkin').'</option>';
                                      
            }
            elseif($Booked_room_data['status']== "checkin")
            {
                 $ajax_response['statusArr'].='<option value="checkin">'.$this->lang->line('checkin').'</option><option value="checkout">'.$this->lang->line('checkout').'</option>';
            }
            elseif($Booked_room_data['status']== "payment pending")
            {
                 $ajax_response['statusArr'].='<option value="payment pending">'.$this->lang->line('payment_pending').'</option>';
            }
            else
            {
              $ajax_response['statusArr'].='<option value="checkout">'.$this->lang->line('checkout').'</option>';  
            }
            
            $floorArr=$this->Hostel_model->get_floors_by_buildingId(array("building_id"=>$Booked_room_data['building_id']));

             $ajax_response['floorArr']= '<option value="">'.$this->lang->line('select_floor').'</option>';
             if(!empty($floorArr)){
                    foreach ($floorArr as $row)
                    {
                        $ajax_response['floorArr'].= '<option value="' . $row['floor_id'] . '" >' . $row['floor'] . '</option>';
                    }
            }    
            
            $roomArr=$this->Hostel_model->get_roomlist_for_booking(array("building_id"=>$Booked_room_data['building_id'],"floor_id"=>$Booked_room_data['floor_id'],"roomtype_id"=>$Booked_room_data['roomtype_id']));
           
            $ajax_response['html']='';
                if(!empty($roomArr))
                {
                        foreach($roomArr as $row)
                        { 
                           if($row['room_id'] == $Booked_room_data['room_id'])
                           {
                               $checked="checked";
                               $class="roomSelected";
                           }
                            else
                            {
                              $checked=""; 
                              $class="";
                            }

                         $alloted_beds=$this->common->get_numof_alloted_beds($row['room_id']);
                             if($alloted_beds == $row['room_capacity']){

                                $ajax_response['html'].='<li class="roomFill '.$class.'" onclick="get_student();">
                             <div class="roomSpan">
                                    <span>'.$row['room_number'].'</span>
                             </div>
                             <input readonly '.$checked.' type="radio" name="room" value="'.$row['room_id'].'"/>
                             <span class="roombed spanFill">'.$alloted_beds.'/'.$row['room_capacity'].'</span>
                            </li>';
                            }
                            else
                            {
                                $ajax_response['html'].='<li class="'.$class.'" onclick="get_student();">
                             <div class="roomSpan">
                                    <span>'.$row['room_number'].'</span>
                             </div>
                             <input '.$checked.' type="radio" name="room" value="'.$row['room_id'].'"/>
                             <span class="roombed">'.$alloted_beds.'/'.$row['room_capacity'].'</span>
                            </li>';
                            }
                         
                        }
                   
                }
            else
            {
                $ajax_response['html']='No Rooms Available';
            }
           
            print_r(json_encode($ajax_response));
        }
    }
    
    //change room
    public function change_hostelRoom()
    {
        if($_POST)
        {
            $id=$this->input->post('id');
            $data['room_id']=$this->input->post('room');
            $data['status']=$this->input->post('status');
            if($data['status']=="checkin")
            {  
               $data['check_in']=date('Y-m-d',strtotime($this->input->post('date')));
            }
            elseif($data['status']=="checkout")
            {
             $data['check_out']=date('Y-m-d',strtotime($this->input->post('date')));   
            }
            else
            {
              $data['check_in']=NULL;
              $data['check_out']=NULL;   
            }
            
            $response=$this->Hostel_model->change_hostelRoom($id,$data);
            //echo $this->db->last_query();
           // echo $response;
             if($response == 1)
            {
              $what=$this->db->last_query();
              $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
              logcreator('update', 'database', $who, $what, $id, 'hl_room_booking','Updated room details for student');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Room Details";
            }
            else
            {
              $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }
            print_r(json_encode($ajax_response));
            
        }
    }
    
    public function load_searchbooking_ajax() {
        $this->search_booking();
        exit;
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('student_reg.no').'</th>
                        <th>'.$this->lang->line('contact.no').'</th>
                        <th>'.$this->lang->line('building').'</th>
                        <th>'.$this->lang->line('room_no').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('checkin').'</th>
                        <th>'.$this->lang->line('checkout').'</th>
                        <th>'.$this->lang->line('action').'</th>
                        
                       

                    </tr>
                </thead>';
        $details=$this->Hostel_model->all_roombooking_list();
        //print_r($details);
        $this->data['studentArr']=$this->Hostel_model->get_studentlist_for_hostelsearch();
        $this->data['buildingArr']=$this->common->get_alldata('hl_hostel_building',array('building_status'=>"1"));
        $this->data['roomTypeArr']=$this->common->get_alldata('hl_hostel_roomtype',array('roomtype_status'=>"1"));
        if(!empty($details)) {
            $i=1; 
            foreach($details as $row){ 
                 if($row['status'] == "alloted"){
                     
                   $status= '<span class="registered">Alloted</span>';
                 } 
                else if($row['status'] == "checkin") 
                 {
                   $status= '<span class="admitted">Check In</span>';
                } 
                else if($row['status'] == "checkout")
                {
                   $status='<span class="inactivestatus">Check Out</span>';
                }
                else if($row['status'] == "payment pending")
                {
                   $status='<span class="paymentcompleted">Payment Pending</span>';
                }
                
                $checkin="";
                $checkout="";
                  if($row['check_in'] !="1970-01-01" && $row['check_in'] !=""){
                      $checkin= date('d/m/Y',strtotime($row['check_in']));
                  }
                if($row['check_out'] !="1970-01-01" && $row['check_out'] !=""){
                      $checkout= date('d/m/Y',strtotime($row['check_out']));
                  }
                $html .= ' <tr id="row_'. $row['id'].'">
                    <td>
                        '. $i.'
                    </td>
                    <td>
                        '. $row['registration_number'].'
                    </td>
                    <td>
                        '. $row['contact_number'].'
                    </td>
                    <td>
                        '. $row['building_name'].'
                    </td>
                    <td>
                        '. $row['room_number'].'
                    </td>

                    <td>'.$status.'</td>
                        
                    <td>'.$checkin.'  </td>  
                   
                    <td>'.$checkout.' </td>
                   
                    <td><button class="btn btn-default option_btn " title="Edit" onclick="get_roomdata('. $row['id'].')">
                                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_bookedroomdata('. $row['id'].')"><i class="fa fa-trash-o"></i>
                                    </a></td>
                    </tr>';
                $i++; 
            }
        } echo $html;
    } 
    //load building list by ajax
   public function load_buildingList_ajax() 
   {
     $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('group').'</th>
                        <th>'.$this->lang->line('branch').'</th>
                        <th>'.$this->lang->line('centre').'</th>
                        <th>'.$this->lang->line('building_name').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';  
       $data=$this->Hostel_model->load_buildingList_ajax();
       
       if(!empty($data))
       { $i=1;
         foreach($data as $rows)
           {
             
             $group_name=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$rows['group_id'],"institute_type_id"=>"1"));  
            $branch_name=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$rows['branch_id'],"institute_type_id"=>"2","parent_institute"=>$rows['group_id']));
            $centre_name=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$rows['centre_id'],"institute_type_id"=>"3","parent_institute"=>$rows['branch_id'])); 
             if($rows['building_status'] == "0")
             {
                 $status_value=1;
                 $status='<span class="btn mybutton mybuttonInactive" onclick="edit_building_status('.$rows['building_id'].','.$status_value.');">Inactive</span>';
                 $delete='<a class="btn btn-default option_btn" title="Delete" onclick="delete_buildingdata('.$rows['building_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
             }
            else
            {
                 $status_value=0;
                 $status='<span class="btn mybutton  mybuttonActive" onclick="edit_building_status('.$rows['building_id'].','.$status_value.');">Active</span>';
                 $delete='';
            }
             $html.='<tr >
                 <td>'.$i.'</td>
                 <td>'.$group_name.'</td>
                 <td>'.$branch_name.'</td>
                 <td>'.$centre_name.'</td>
                 <td>'.$rows['building_name'].'</td>
                 <td>'.$status.'</td>
                 <td><button class="btn btn-default option_btn " title="Edit" onclick="get_buildingdata('.$rows['building_id'].')">
                     <i class="fa fa-pencil "></i></button>'.$delete.'</td>
                 
                </tr>';
             $i++;
           }  
       }
       echo $html;
   }
    
    public function load_floorList_ajax()
    {
       $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('building_name').'</th>
                        <th>'.$this->lang->line('floor').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>'; 
        $data=$this->Hostel_model->get_all_hostelFloor();
        if(!empty($data))
         { 
             $i=1;
             foreach($data as $rows)
             {
                 if($rows['floor_status'] == "0")
                 {
                     $s=1;
                     $status='<span class="btn mybutton mybuttonInactive" onclick="edit_floor_status('. $rows['floor_id'].','.$s.');">Inactive</span>';
                     $delete='<a class="btn btn-default option_btn" title="Delete" onclick="delete_floordata('. $rows['floor_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
                 }
                 else
                 {
                     $s=0;
                     $status='<span class="btn mybutton mybuttonActive" onclick="edit_floor_status('. $rows['floor_id'].','.$s.');">Active</span>';
                     $delete='';
                 }
                $html.='<tr >
                 <td>'.$i.'</td>
                 <td>'.$rows['building_name'].'</td>
                 <td>'.$rows['floor'].'</td>
                 <td>'.$status.'</td>
                 <td><button class="btn btn-default option_btn "  title="Edit" onclick="get_floordata('. $rows['floor_id'].')">
                     <i class="fa fa-pencil "></i></button>'.$delete.'
                     </td></tr>';  
                 $i++;
             }
            
         }
        echo $html;
    }
    
    //ajax load roomtype
    public function load_roomtypeList_ajax()
    {
       $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('room_type').'</th>
                        <th>'.$this->lang->line('facilities').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>'; 
        $data=$this->common->get_alldata_orderby('hl_hostel_roomtype',array('roomtype_status!='=>"2"),'roomtype_id','desc');
        if(!empty($data))
         { 
           
            $i=1;
             foreach($data as $rows)
             {
                 if($rows['roomtype_status'] == "0")
                 {
                     $s=1;
                     $status='<span class="btn mybutton mybuttonInactive" onclick="edit_roomtype_status('. $rows['roomtype_id'].','.$s.');">Inactive</span>';
                     $delete='<a class="btn btn-default option_btn" title="Delete" onclick="delete_roomtypedata('. $rows['roomtype_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
                 }
                 else
                 {
                     $s=0;
                     $status='<span class="btn mybutton mybuttonActive" onclick="edit_roomtype_status('. $rows['roomtype_id'].','.$s.');">Active</span>';
                     $delete='';
                 }
                $html.='<tr >
                 <td>'.$i.'</td>
                 <td>'.ucfirst($rows['room_type']).'</td>
                 <td>'.$rows['facilities'].'</td>
                 <td>'.$status.'</td>
                 <td><button class="btn btn-default option_btn " title="Edit" onclick="get_roomtypedata('. $rows['roomtype_id'].')">
                     <i class="fa fa-pencil "></i></button>'.$delete.'</td></tr>';  
                 $i++;
             }
            
         }
        echo $html;
        
    }
    
     //ajax load rooms
    public function load_roomList_ajax()
    {
       $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('building_name').'</th>
                        <th>'.$this->lang->line('floor').'</th>
                        <th>'.$this->lang->line('roomtype').'</th>
                        <th>'.$this->lang->line('room_no').'</th>
                        <th>'.$this->lang->line('accomadatable_persons').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>'; 
         $data=$this->Hostel_model->get_allroom_list();
        // print_r($data);
         if(!empty($data))
         { 
           
            $i=1;
             foreach($data as $rows)
             {
                 
                 if($rows['room_status'] == "0")
                 {
                     $s=1;
                     $status='<span class="btn mybutton mybuttonInactive" onclick="edit_room_status('. $rows['room_id'].','.$s.');">Inactive</span>';
                     $delete='<a class="btn btn-default option_btn" title="Delete" onclick="delete_roomdata('.$rows['room_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
                 }
                 else
                 {
                     $s=0;
                     $status='<span class="btn mybutton mybuttonActive" onclick="edit_room_status('. $rows['room_id'].','.$s.');">Active</span>';
                     $delete='';
                 }
                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['building_name'].'</td>
                        <td>'.$rows['floor'].'</td>
                        <td>'.$rows['room_type'].'</td>
                        <td>'.$rows['room_number'].'</td>
                        <td>'.$rows['room_capacity'].'</td>
                         <td>'.$status.'</td>
                        <td><button class="btn btn-default option_btn " title="Edit" onclick="get_roomdata('.  $rows['room_id'].')">
                     <i class="fa fa-pencil "></i></button>'.$delete.'</td>
                       
                        </tr>';
                 $i++;
             }
         }
        echo $html;
    }
    
  //change room status
    public function hostel_room_status()
    {
       if($_POST)
        {
            $room_status=$this->input->post('room_status');
            $room_id=$this->input->post('room_id');
            $what = '';
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];

            if($room_id!= "" && $room_status!="") {                 
               if($room_status == 0)
               {
                    $exist=$this->common->hostel_checking('room',$room_id);
                  // echo $this->db->last_query();
                    if($exist)
                    {
                     $response['st']=$this->Hostel_model->hostel_room_status($room_id,$room_status);
                     $what =$this->db->last_query();                         
                     logcreator('update', 'database', $who, $what, $room_id, 'hl_hostel_rooms','Hostel room  status deactivated');
                    }
                   else
                   {
                     $response['st']=2;//This room is occupied  
                   }
                }
                else
                {
                     $response['st']=$this->Hostel_model->hostel_room_status($room_id,$room_status);
                     $what =$this->db->last_query(); 
                     logcreator('update', 'database', $who, $what, $room_id, 'hl_hostel_rooms','Hostel room  status activated');
                }
              
            }
            else
            {
           logcreator('error', 'database', $who, $what, $room_id, 'hl_hostel_rooms','Hostel room status changing failed');
            }
            print_r(json_encode($response));
        } 
    }
    //delete booked roomdata
    public function delete_bookedroomdata()
    {
        $id      = $this->input->post('id');
        $where = array('id'=>$id);
        $data  = array('delete_status'=>2); 
        $what = '';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($id!= '') {
            
                $query = $this->common->delete_fromwhere('hl_room_booking', $where, $data);
                $res['status']   = true; 
                $res['message']  = 'Data deleted successfully'; 
                $res['data']     = ''; 

                logcreator('delete', 'database', $who, $what, $id, 'hl_hostel_building','Student room booking details deleted');
           
              
        } else {
            
           $res['status']   = false; 
           $res['message']  = 'Invalid data'; 
           $res['data']     = array();
           logcreator('error', 'database', $who, $what, $id, 'hl_hostel_building','Student room booking details deletion failed');    
        }
        print_r(json_encode($res)); 
    }
    
    //manage hostel fees
    public function manage_hostelfee()
    { 
        check_backoffice_permission('manage_hostelfee');
        $this->data['page']="admin/hostel_fees";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Hostel / Fees";
        $this->data['menu_item']="manage-hostelfee";
        
        $this->data['roomTypeArr']=$this->common->get_alldata('hl_hostel_roomtype',array('roomtype_status'=>"1"));
        $this->data['datas']= $this->Hostel_model->get_allhostelfee();
        $this->data['fee_def']= $this->Hostel_model->get_all_hostel_fee_def();
        
		$this->load->view('admin/layouts/_master',$this->data);   
    }

    public function get_hostel_fees_heads($id){
        $fee_heads = $this->Hostel_model->get_hostel_fee_heads($id);
        $ajax_response['st']=1;
        $ajax_response['data']=$fee_heads;
        print_r(json_encode($ajax_response)); 
    }

    public function save_hostel_fees(){
        if($_POST)
        {
            $room_type = $this->input->post('room_type');
            $mess_type = $this->input->post('mess_type');
            $fee_def = $this->input->post('fee_def');
            $feehead = $this->input->post('feehead');
            $feeamount = $this->input->post('feeamount');
            $fees=$this->input->post('fees');
            $hostel_fee_id = $this->input->post('hostel_fee_id');
            if($hostel_fee_id){
                $check_exist = $this->common->check_if_dataExist('hl_hostel_fees',array("hostel_fee_id !="=>$hostel_fee_id,"room_type"=>$room_type,"mess_type"=>$mess_type,"status"=>1));
                // show($check_exist);
            }else{
                $check_exist = $this->common->check_if_dataExist('hl_hostel_fees',array("room_type"=>$room_type,"mess_type"=>$mess_type,"status"=>1));
            }
            if($check_exist){
                $ajax_response['st']=2;
                $ajax_response['message']='Fee is already defined for this room type';
            }else{
                $data = array(
                    'room_type'=>$room_type,
                    'mess_type'=>$mess_type,
                    'fee_def'=>$fee_def,
                    'fees'=>$fees,
                    'status'=>1
                );
                if($hostel_fee_id){
                    $this->Hostel_model->update_hostel_fees($data,$hostel_fee_id);
                }else{
                    $hostel_fee_id = $this->Hostel_model->save_hostel_fees($data);
                }
                if($hostel_fee_id){
                    if(!empty($feehead)){
                        $fee_definition_details = [];
                        foreach($feehead as $k=>$head){
                            array_push($fee_definition_details,array(
                                'hostel_fee_id'=>$hostel_fee_id,
                                'ph_id'=>$head,
                                'amount'=>$feeamount[$k],
                            ));
                        }
                        $res = $this->Hostel_model->save_hostel_fees_details($fee_definition_details);
                        if($res){
                            $ajax_response['st']=1;
                            $ajax_response['message']='Successfully saved';
                        }else{
                            $ajax_response['st']=2;
                            $ajax_response['message']='DB error';
                        }
                    }else{
                        $ajax_response['st']=2;
                        $ajax_response['message']='DB error';
                    }
                }else{
                    $ajax_response['st']=2;
                    $ajax_response['message']='DB error';
                }
            }
            print_r(json_encode($ajax_response)); 
        }
    }

    public function get_hostel_room_type_fees_details($id){
        if($id){
            $data = $this->Hostel_model->get_hostel_room_type_fees_details($id);
            $ajax_response['st']=1;
            $ajax_response['data']=$data;
            print_r(json_encode($ajax_response)); 
        }
    }

    public function view_hostel_room_type_fees_details($id){
        if($id){
            $data = $this->Hostel_model->view_hostel_room_type_fees_details($id);
            $ajax_response['st']=1;
            $ajax_response['data']=$data;
            print_r(json_encode($ajax_response)); 
        }
    }

    //add hostel fee
    public function hostel_fees_add()
    {
        //print_r($_POST); 
        if($_POST)
        {
            $roomtype=$this->input->post('room-type');
            $messtype=$this->input->post('mess-type');
            $fees=$this->input->post('fees');
            
          
            if(!empty($roomtype)){
                $flag=0;
                foreach($roomtype as $key=>$row)
                {
                    $data['room_type']=$row;
                    $data['mess_type']=$messtype[$key];
                    $data['fees']=$fees[$key];
                    $check_exist=$this->common->check_if_dataExist('hl_hostel_fees',array("room_type"=>$data['room_type'],"mess_type"=>$data['mess_type'],"status"=>1));
                    if($check_exist == 0){
                        $flag=1;
                    }else{
                        $ajax_response['st']=2;
                        print_r(json_encode($ajax_response)); 
                        exit();
                    }
                }
            }
            if($flag==1)
            {

                foreach($roomtype as $key=>$row)
                {
                    $data['room_type']=$row;
                    $data['mess_type']=$messtype[$key];
                    $data['fees']=$fees[$key];
                    $check_exist=$this->common->check_if_dataExist('hl_hostel_fees',array("room_type"=>$data['room_type'],"mess_type"=>$data['mess_type'],"status"=>1));
                    
                   // echo $this->db->last_query();
                    
                    if($check_exist == 0)
                    {
                    $ajax_response['st']=$this->Hostel_model->hostel_fees_add($data);
                    }
                    $what = $this->db->last_query();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $table_row_id=$this->db->insert_id();
                   logcreator('insert', 'database', $who, $what, $table_row_id, 'hl_hostel_fees','Hostel fee added');
                }
            }
            
            print_r(json_encode($ajax_response));
        }
    }
    
    //get hostel_fee_by_id
    public function get_hostelfee_byId()
    {
        //print_r($_POST);
        if($_POST)
        {
            $id=$this->input->post('id');
            $ajax_response['data']=$this->common->get_from_tablerow('hl_hostel_fees', array("hostel_fee_id"=>$id));
            print_r(json_encode($ajax_response));
           
        }
    }
    //hostel fees edit
    public function hostel_fee_edit()
    {
       
        if($_POST)
        {
            $id=$this->input->post('id');
            unset($_POST['id']);
            $response=$this->Hostel_model->hostel_fee_edit($id,$_POST);
            if($response == 1)
            {
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Hostel Fee Details";
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'hl_hostel_fees','Hostel fee edited');
                
            }
            elseif($response == 2)
            {
              $ajax_response['st']=2;
              $ajax_response['message']="Data Already Exist";  
            }
            else
            {
               $ajax_response['st']=0;
               $ajax_response['message']="Invalid Request";
            }
            print_r(json_encode($ajax_response));
        }
    }
    //delete hostel fee
    public function delete_hostelfee()
    {
       if($_POST)
       { 
           $id=$this->input->post('id');
           $response=$this->common->delete_fromwhere('hl_hostel_fees', array("hostel_fee_id"=>$id), array("status"=>2));
           if($response)
           {
                 $ajax_response['st']=1;
                 $ajax_response['message']="Successfully Deleted Hostel Fee Details";
                 $what = $this->db->last_query();
                 $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                 logcreator('delete', 'database', $who, $what, $id, 'hl_hostel_fees','Hostel fee deleted');
           }
           else
           {
               $ajax_response['st']=0;
               $ajax_response['message']="Invalid Request";
           }
           print_r(json_encode($ajax_response));
       }
    }
    
    //load hostel fee by ajax
    public function load_hostelfee_ajax()
    {
       $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('room_type').'
                            </th>
                            <th>
                                '. $this->lang->line('mess_type').'
                            </th>
                            <th>
                                '. $this->lang->line('fees').'
                            </th>
                            <th>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>'; 
        $data= $this->Hostel_model->get_allhostelfee();
         if(!empty($data))
         { 
           
            $i=1;
             foreach($data as $rows)
             {
                 
                if ($rows['mess_type'] == "veg"){ $mess = $this->lang->line('veg');}
                if ($rows['mess_type'] == "nonveg"){ $mess =  $this->lang->line('nonveg');}
                if ($rows['mess_type'] == "na"){ $mess =  'NA';}
                
                 
                 $html.='<tr>
                            <td>'.$i.'</td>
                            <td>'.$rows['room_type'].'</td>
                            <td>'.$mess.'</td>
                            <td>'.numberformat($rows['fees']).'</td>
                            <td>
                                <button class="btn btn-default option_btn "  title="View" onclick="view_feedata('.$rows['hostel_fee_id'].')">
                                    <i class="fa fa-eye "></i>
                                </button>
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_feedata('.$rows['hostel_fee_id'].')">
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_hostelfee('.$rows['hostel_fee_id'].')"><i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>';
                 $i++;
             }
         }
        echo $html;
    }

    /*This function will return the hostel fee
    @params student_id,room_id
    @auther GBS-L*/
    public function get_hostel_fee()
    {
        if($_POST)
        {
            $studentid=$this->input->post('student_id');
            $room_type=$this->input->post('room_type');
            $fees = $this->common->get_hostel_fee_InBooking($studentid,$room_type);
            if(!empty($fees)){
                $html = '<br>';
                foreach($fees as $head=>$fee){
                    $html .= $head.': '.$fee.'<br>';
                }
                $ajax_response['fee']=$html;
            }else{
                $ajax_response['fee']=0;
            }
            print_r(json_encode($ajax_response));
        }
    }

} 
?>
