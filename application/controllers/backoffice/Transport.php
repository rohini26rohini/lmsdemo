<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="basic_configuration";
        check_backoffice_permission($module);
        $this->load->model('transport_model');

    }
//--------------------------------------- Manage Bus -----------------------------------------------//
    public function index($id=NULL){
        check_backoffice_permission('manage_bus');
        $this->data['page']="admin/bus";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Manage Bus";
        $this->data['menu_item']="backoffice/manage-bus";
        $this->data['busArr']=$this->transport_model->get_bus_list();
        $this->data['roleArr']=$this->common->get_roles();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function bus_add()
    {
        if($_POST){
            $data = $_POST;
            $bus_exist = $this->transport_model->is_bus_exist($data);
            if($bus_exist == 0){
                $res = $this->transport_model->bus_add($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'tt_bus', 'New vehicle details added');
                    $bus_array=$this->transport_model->get_busdetails_by_id($table_row_id);
                    $html='<li id="row_'.$table_row_id.'">
                            <div class="col sl_no "> '.$table_row_id.' </div>
                                <div class="col " >'.$bus_array['vehicle_number'] .' </div>
                                <div class="col " >'.$bus_array['vehicle_made'] .' </div>
                                <div class="col " >'.$bus_array['vehicle_seat'] .' </div>
                                <div class="col actions ">
                                    <button class="btn btn-default option_btn " title="Edit"  onclick="get_busdata('.$table_row_id.')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_bus('.$table_row_id.')">
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

    public function bus_edit()
    {
        if($_POST){
            $id = $this->input->post('bus_id');
            unset($_POST['bus_id']);
            $data = $_POST;
            $res = $this->transport_model->edit_bus($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'tt_bus', 'Vehicle details edited');
            }
            print_r($res);
        }
    }

    public function delete_bus()
    {
        $id  = $_POST['id'];
        $res = $this->transport_model->delete_bus($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'tt_bus', 'Vehicle details removed');
        }
        print_r($res);
    }

    public function get_bus_by_id($bus_id){
        $bus_array= $this->transport_model->get_bus_by_id($bus_id);
        print_r(json_encode($bus_array));
    }

    public function load_bus_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('vehicle_number').'</th>
                        <th >'.$this->lang->line('model/brand').'</th>
                        <th >'.$this->lang->line('seating_capacity').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $routeArr = $this->transport_model->get_bus_list();
        if(!empty($routeArr)) {
            $i=1; 
            foreach($routeArr as $bus){ 
                $html .= '<tr id="row_'.$bus['bus_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="vehicle_number_'.$bus['bus_id'].'">
                        '.$bus['vehicle_number'].'
                    </td>
                    <td id="vehicle_made_'.$bus['bus_id'].'">
                        '.$bus['vehicle_made'].'
                    </td>
                    <td id="vehicle_seat_'.$bus['bus_id'].'">
                        '.$bus['vehicle_seat'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_busdata('.$bus['bus_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_bus('.$bus['bus_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }



//--------------------------------------- Manage Route -----------------------------------------------//
    public function manage_route($id=NULL){
         check_backoffice_permission('manage_route');
        $this->data['page']="admin/route";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Manage Route";
        $this->data['menu_item']="backoffice/manage-route";
        $this->data['busArr']=$this->transport_model->get_bus_list();
        $this->data['edit_dataArr'] = $this->transport_model->get_transport($id=NULL);
        $this->data['routeArr']=$this->transport_model->get_route_list();
        $this->data['roleArr']=$this->common->get_roles();
        $this->data['driverArr']=$this->common->get_drivers();
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function route_add()
    {
        // show($_POST);
        $fee_id1 = $this->input->post('fee_id');
        if(!empty($fee_id1)) {
            foreach($fee_id1 as $id){
                $fee_amount = $this->input->post('fee_amount'.$id);
                if($fee_amount == '') {
                    $html = "1";
                    print_r($html);
                    exit;
                }
            }
        }
        // show($fee_id1);
        $this->load->library('googlemaps');
        $config['center'] = '8.481566968051856, 76.97254872617725';
        $config['zoom']   = '6';
        $this->googlemaps->initialize($config);
        $marker              = array();
        $marker['position']  = '8.48428, 76.97186208066944';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->add_marker($marker);
        $page_data['map']         = $this->googlemaps->create_map();
            $data['route_name']        = $this->input->post('route_name');
            $data['fee_definition']    = $this->input->post('fee_definition');
            $data['role']              = $this->input->post('role');
            $data['bus_id']            = $this->input->post('bus_id');
            $data['description']       = $this->input->post('description');
            $data['route_number']      = $this->input->post('route_number');
            $transport_id              = $this->transport_model->insert_transport($data);
            if ($transport_id) {
                //Deposits
                $fee_id = $this->input->post('fee_id');
                if(!empty($fee_id)) {
                    foreach($fee_id as $id){
                        $fee_amount = $this->input->post('fee_amount'.$id);
                        $feedata['fd_id'] = $transport_id;
                        $feedata['fee_def_id'] = $data['fee_definition'];
                        $feedata['fee_id'] = $id;
                        $feedata['fee_amount'] = $fee_amount;
                        $this->db->insert('tt_fee_definiftion_details', $feedata);
                    }
                }
                //Ends

                $nameArr            = $this->input->post('name');
                $transport_idArr    = $transport_id;
                $lattitudeArr       = $this->input->post('lat');
                $longitudeArr       = $this->input->post('lon');
                $distanceArr        = $this->input->post('distance');
                $route_fareArr        = $this->input->post('route_fare');
                $stopArr            = array();
                if (!empty($nameArr)) {
                    foreach ($nameArr as $key => $val) {
                        if (!empty($nameArr[$key])) {
                            $tempArr = array(
                                'name' => $nameArr[$key],
                                'transport_id' => $transport_idArr,
                                'latitude' => $lattitudeArr[$key],
                                'longitude' => $longitudeArr[$key],
                                'distance' => $distanceArr[$key],
                                'route_fare' => $route_fareArr[$key]
                            );
                            array_push($stopArr, $tempArr);
                        }
                    }
                }
                if (!empty($stopArr)) {
                    $res = $this->transport_model->route_add($stopArr);
                }
            }
            if($res = 1){
                $what = $this->db->last_query();
                $table_row_id = $this->db->insert_id();

                $query = $this->db->select('*');
                $query	=	$this->db->get('tt_transport');
                $row_id= $query->num_rows();

                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'database', $who, $what, $table_row_id, 'tt_transport', 'New route details created');
                $route_array=$this->transport_model->get_routedetails_by_id($table_row_id);
                $html='<li id="row_'.$table_row_id.'">
                        <div class="col sl_no "> '.$row_id.' </div>
                            <div class="col " >'.$route_array['route_name'] .' </div>
                            <div class="col " >'.$route_array['vehicle_number'] .' </div>
                            <div class="col " >'.$route_array['route_number'] .' </div>
                            <div class="col " >'.$route_array['description'] .' </div>
                            <div class="col actions ">
                                <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$route_array['transport_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#view_route" style="color:blue;cursor:pointer;">
                                    <i class="fa fa-eye "></i>
                                </button>
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_routedata('.$table_row_id.')">
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_route('.$table_row_id.')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        <li>';
            }
            print_r($html);
    }

    public function route_edit()
    {
        $this->load->library('googlemaps');
        $config['center'] = '8.481566968051856, 76.97254872617725';
        $config['zoom']   = '6';
        $this->googlemaps->initialize($config);
        $marker              = array();
        $marker['position']  = '8.48428, 76.97186208066944';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->add_marker($marker);
        $page_data['map']          = $this->googlemaps->create_map();
            $data['route_name']        = $this->input->post('edit_route_name');
            $data['fee_definition']    = $this->input->post('fee_definition');
            $data['role']              = $this->input->post('edit_role');
            $data['bus_id']            = $this->input->post('edit_bus_id');
            $data['description']       = $this->input->post('edit_description');
            $data['route_number']      = $this->input->post('edit_route_number');
            $transport_id              = $this->input->post('edit_transport_id');
            $exist = $this->transport_model->check_exist_route($transport_id);
            if($exist) {
                //return false;
                //exit();
                unset($data['fee_definition']);
            }
            $update                    = $this->transport_model->edit_transport($data, $transport_id);
            if ($update) {
                 //Deposits
                 if($exist) {} else{
                 $delete_fee = $this->transport_model->delete_fee_def_details($transport_id);
                 $fee_id = $this->input->post('fee_id');
                 if(!empty($fee_id) && $delete_fee) {
                     foreach($fee_id as $id){
                         $fee_amount = $this->input->post('fee_amount'.$id);
                         $feedata['fd_id'] = $transport_id;
                         $feedata['fee_def_id'] = $data['fee_definition'];
                         $feedata['fee_id'] = $id;
                         $feedata['fee_amount'] = $fee_amount;
                         $this->db->insert('tt_fee_definiftion_details', $feedata);
                     }
                 }
                }
                 //Ends

                $stopidArr         = $this->input->post('stop_id'); 
                $nameArr         = $this->input->post('name');
                $distanceArr     = $this->input->post('distance');
                $route_fareArr        = $this->input->post('route_fare');
                $lattitudeArr       = $this->input->post('lat');
                $longitudeArr       = $this->input->post('lon');
                $transport_idArr = $transport_id;
                $stopArr         = array();
                if (!empty($nameArr)) {
                    foreach ($nameArr as $key => $val) {
                        if (!empty($nameArr[$key])) { 
                            if (!empty($stopidArr[$key])) {
                                $stop_id = $stopidArr[$key];
                            } else {
                                $stop_id = null;    
                            }
                            $tempArr = array(
                                'name' => $nameArr[$key],
                                'stop_id' => $stop_id,
                                'distance' => $distanceArr[$key],
                                'route_fare' => $route_fareArr[$key],
                                'transport_id' => $transport_idArr,
                                'latitude' => $lattitudeArr[$key],
                                'longitude' => $longitudeArr[$key]
                            );
                            array_push($stopArr, $tempArr);
                        }
                    }
                } 
                if (!empty($stopArr)) {
                    $res = $this->transport_model->update_stop_batch($stopArr, $exist);
                }
            }
            if($res = 1){
                $what = $this->db->last_query();
                $table_row_id = $this->db->insert_id();

                $query = $this->db->select('*');
                $query	=	$this->db->get('tt_transport');
                $row_id= $query->num_rows();  

                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $table_row_id, 'tt_transport', 'Route details edited');
            }
            if($exist) {
                return false;
                exit();
            }
            print_r($res);
    }

    public function delete_route()
    {
        $id  = $_POST['id'];
        $assignedRoute = $this->transport_model->checkAssignedRoute($id);
        if($assignedRoute){
            $res = $this->transport_model->delete_route($id);
            if($res=1){
                $ajax_response['st'] = 1;
                $ajax_response['msg']="Successfully Deleted..!";
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'tt_transport', 'Route details removed');
            }else{
                $ajax_response['st'] = 0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st'] = 2;
            $ajax_response['msg']="Sorry, Can't delete this root. already assigned to student";
        }
        print_r(json_encode($ajax_response));
    }
    function delete_stop($id = '')
    {
        $id     = $this->input->post('stop_id');
        $assignedRoute = $this->transport_model->checkAssignedStop($id);
        if($assignedRoute){
            $delete = $this->transport_model->delete_stop($id);
            if ($delete) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo 2;
        }
    }

    public function view_route_by_id($transport_id){
       // echo $transport_id; die();
        $this->data['route_details']= $this->transport_model->view_route_by_id($transport_id);
       // echo $this->db->last_query(); die();
        $stop_id = $this->input->post('stop_id');
        $this->db->select('*');
        $this->db->where('transport_id',$transport_id);
        $query = $this->db->get('tt_transport_stop')->result_array();
        $this->data['stop_details']=$this->transport_model->get_stop_by_id($transport_id);
        $fee_definition             =   $this->transport_model->get_fee_definition_id($transport_id);
        $html = '';
        $feeDef = '';
        if(!empty($fee_definition)) {
            foreach($fee_definition as $fee) {
                $html .= '<div class= "table-responsive table_language">
                            <table class="table table_followup table-sm table-bordered table-striped">
                                <tr>
                                    <td width="60%">'.$fee->ph_head_name.'</td>
                                    <td width="40%">'.$fee->fee_amount.'</td>
                                </tr>
                            </table>
                        </div>';
                $feeDef = $fee->fee_def_id;
            }
        }
        $this->data['feeDef'] = $this->common->get_name_by_id('am_fee_definition','fee_definition',array('fee_definition_id'=>$feeDef));
        $this->data['fees'] =  $html; 
        print_r(json_encode($this->data));
    }
    // <div class="form-group">
    //     <label>'.$fee->ph_head_name.'<span class="req redbold">*</span></label><input type="hidden" name="fee_id[]" value="'.$fee->fee_id.'">
    //     <input type="number" min="0" name="fee_amount'.$fee->fee_id.'" class="form-control numbersOnly tooltipstered" placeholder="'.$fee->ph_head_name.'" value="'.$fee->fee_amount.'" autocomplete="off">
    // </div>
    public function get_route_by_id($transport_id){
        $this->data['route_details']= $this->transport_model->get_route_by_id($transport_id);
        $edit_transport_id = $this->input->post('edit_transport_id');
        $this->db->select('*');
        $this->db->where('transport_id',$transport_id);
        $query = $this->db->get('tt_transport_stop')->result_array();
        $this->data['stop_details'] =   $this->transport_model->get_stop_by_id($transport_id);
        $fee_definition             =   $this->transport_model->get_fee_definition_id($transport_id);
        $html = '';
        if(!empty($fee_definition)) {
            foreach($fee_definition as $fee) {
                $html .= '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>'.$fee->ph_head_name.'<span class="req redbold">*</span></label><input type="hidden" name="fee_id[]" value="'.$fee->fee_id.'">
                                <input type="number" min="0" name="fee_amount'.$fee->fee_id.'" class="form-control numbersOnly tooltipstered" placeholder="'.$fee->ph_head_name.'" value="'.$fee->fee_amount.'" autocomplete="off">
                            </div>
                        </div>';
            }
        }
        $this->data['fees'] =  $html; 
        print_r(json_encode($this->data));
    }
    
     
    public function load_route_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >Route Number</th>
                        <th >Route Name</th>
                        <th >'.$this->lang->line('vehicle_number').'</th>
                        <th >'.$this->lang->line('description').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $routeArr = $this->transport_model->get_route_list();
        if(!empty($routeArr)) {
            $i=1; 
            foreach($routeArr as $route){ 
                $html .= '<tr id="row_'.$route['transport_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="route_number_'.$route['transport_id'].'">
                        '.$route['route_number'].'
                    </td>
                    <td id="route_name_'.$route['transport_id'].'">
                        '.$route['route_name'].'
                    </td>
                    <td id="vehicle_number_'.$route['transport_id'].'">
                        '.$route['vehicle_number'].'
                    </td>
                    <td id="description_'.$route['transport_id'].'">
                        '.$route['description'].'
                    </td>
                    <td>
                        <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$route['transport_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#view_route" style="color:blue;cursor:pointer;">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_routedata('.$route['transport_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_route('.$route['transport_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
//--------------------------------------- Vehicle Maintenance -----------------------------------------------//
    public function vehicle_maintenance($id=NULL){
         check_backoffice_permission('vehicle_maintenance');
        $this->data['page']="admin/vehicle_maintenance";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Maintenance";
        $this->data['menu_item']="backoffice/vehicle_maintenance";
        $this->data['maintenanceArr']=$this->transport_model->get_maintenanceroute_list();
        $this->data['busArr']=$this->transport_model->get_bus_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function maintenance_add()
    {
        if($_POST){
            $data = $_POST;
            $maintenance_exist = $this->transport_model->is_maintenance_exist($data);
            if($maintenance_exist == 0){
                $res = $this->transport_model->maintenance_add($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'tt_maintenance' ,'New vehicle maintenance details added');
                    $maintenance_array=$this->transport_model->get_maintenancedetails_by_id($table_row_id);
                    $html='<li id="row_'.$table_row_id.'">
                                <div class="col sl_no "> '.$table_row_id.' </div>
                                <div class="col " >'.$maintenance_array['vehicle_number'] .' </div>
                                <div class="col " >'.$maintenance_array['description'] .' </div>
                                <div class="col " >'.$maintenance_array['date'] .' </div>
                                <div class="col " >'.$maintenance_array['amount'] .' </div>
                                <div class="col actions ">
                                    <button class="btn btn-default option_btn " title="Edit" onclick="get_maintenancedata('.$table_row_id.')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_maintenance('.$table_row_id.')">
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

    public function maintenance_edit()
    {
        if($_POST){
            $id = $this->input->post('maintenance_id');
            unset($_POST['maintenance_id']);
            $data = $_POST;
            $res = $this->transport_model->edit_maintenance($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'tt_maintenance', 'Vehicle maintenance details edited');
            }
            print_r($res);
        }
    }

    public function delete_maintenance()
    {
        $id  = $_POST['id'];
        $res = $this->transport_model->delete_maintenance($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'tt_maintenance', 'Vehicle maintenance details removed');
        }
        print_r($res);
    }

    public function get_maintenance_by_id($maintenance_id){
        $maintenance_array= $this->transport_model->get_maintenance_by_id($maintenance_id);
        print_r(json_encode($maintenance_array));
    }

    public function load_maintenance_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('vehicle_number').'</th>
                        <th >'.$this->lang->line('description').'</th>
                        <th >'.$this->lang->line('date').'</th>
                        <th >'.$this->lang->line('amount').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $maintenanceArr = $this->transport_model->get_maintenanceroute_list();
        if(!empty($maintenanceArr)) {
            $i=1; 
            foreach($maintenanceArr as $maintenance){ 
                $html .= '<tr id="row_'.$maintenance['maintenance_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="vehicle_number_'.$maintenance['maintenance_id'].'">
                        '.$maintenance['vehicle_number'].'
                    </td>
                    <td id="description_'.$maintenance['maintenance_id'].'">
                        '.$maintenance['description'].'
                    </td>
                    <td id="date_'.$maintenance['maintenance_id'].'">
                        '.$maintenance['date'].'
                    </td>
                    <td id="amount_'.$maintenance['maintenance_id'].'">
                        '.$maintenance['amount'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_maintenancedata('.$maintenance['maintenance_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_maintenance('.$maintenance['maintenance_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
public function check_bus_number()
{
    if($_POST)
    {
        $vehicle_number=$this->input->post('vehicle_number');
       
        $exist=$this->common->check_if_dataExist('tt_bus',array("vehicle_number"=>$vehicle_number));
       if($exist ==0)
       {
           echo "true";
       }
        else
        {
            echo "false";
        }
    }
}
    public function edit_check_bus_number()
{
    if($_POST)
    {
        //print_r($_POST);
        $vehicle_number=$this->input->post('vehicle_number');
        $bus_id=$this->input->post('id');
       
        $exist=$this->common->check_if_dataExist('tt_bus',array("vehicle_number"=>$vehicle_number,"bus_id!="=>	$bus_id));
       if($exist >0)
           
       {
           echo "false";
       }
        else
        {
            echo "true";
        }
    }
}


public function transportation_fee_definition() {
    check_backoffice_permission('trans_fee_definition');
    $this->data['page']         = "admin/trans_fee_defnition";
    $this->data['menu']         = "basic_configuration";
    $this->data['feeDeff']      = $this->transport_model->get_feeDeff();
    $this->data['breadcrumb']   = $this->lang->line('fee_defnition');
    $this->data['menu_item']    = "trans_fee_def";
    $this->load->view('admin/layouts/_master',$this->data); 
}

public function get_payment_head(){
    $counter = $_POST['counter'];
    $html ="";
    $paymentHead = $this->transport_model->get_payment_head();
    $html .='<select class="form-control stopname" name="payment_head['.$counter.']" id="payment_head'.$counter.'">
                <option value="">Select</option>';
    if(!empty($paymentHead)){
        foreach($paymentHead as $Head){
            $html .= '<option value="'.$Head->ph_id.'" >'.$Head->ph_head_name.'</option>';
          }
    }
    $html .='</select>';
    echo $html;
}
public function fee_def_add(){
    if($_POST)
    {
        $data['fd_title']        = $this->input->post('title');
        $fee_def_id              = $this->transport_model->insert_fee_def($data);
        if($fee_def_id){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('insert', 'database', $who, $what, $fee_def_id, 'tt_fee_definiftion', 'Transportaion fee definition added');
        }
        if ($fee_def_id) {
            $paymentHeadArr     = $this->input->post('payment_head');
            $feeamountArr       = $this->input->post('feeamount');
            $fee_def_idArr      = $fee_def_id;
            $stopArr            = array();
            if (!empty($paymentHeadArr)) {
                foreach ($paymentHeadArr as $key => $val) {
                    if (!empty($paymentHeadArr[$key])) {
                        $tempArr = array(
                            'fd_id' => $fee_def_idArr,
                            'fee_id' => $paymentHeadArr[$key],
                            'fee_amount' => $feeamountArr[$key]
                        );
                        array_push($stopArr, $tempArr);
                    }
                }
            }
            if (!empty($stopArr)) {
                $f = 1;
                foreach($stopArr as  $key=>$row){ 
                    $response = $this->transport_model->insert_fee_def_details($row);
                    if($response == false){
                        $f = 0;
                    }else{
                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('insert', 'database', $who, $what, $response, 'tt_fee_definiftion_details','Transportaion fee definition details added');
                    }
                }
                if($f == 1){
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully added data";
                }
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
    }else{
        $ajax_response['st']=0;
        $ajax_response['msg']="Something went wrong,Please try again later..!";
    }
    print_r(json_encode( $ajax_response));
}
public function load_fee_def_ajax() {
    $html = '<thead> 
               <tr>
                    <th width="10%">'.$this->lang->line('sl_no').'</th>
                    <th >'.$this->lang->line('title').'</th>
                    <th >'.$this->lang->line('status').'</th>
                    <th width="15%">'.$this->lang->line('action').'</th>
                </tr>
            </thead>';
            $feeDeff = $this->transport_model->get_feeDeff();
    if(!empty($feeDeff)) {
        $i=1; 
        foreach($feeDeff as $data){
            $html .= '<tr>
                <td>
                    '.$i.'
                </td>
                <td>
                    '.$data->fd_title.'
                </td>
                <td>';
                if($data->fd_status == 1) {
                    $html .= '<span class="btn mybutton  mybuttonActive" onclick="statusChange('.$data->fd_id.','.$data->fd_status.')">Active</span>';
                }else if($data->fd_status == 0){
                    $html .= '<span class="btn mybutton mybuttonInactive" onclick="statusChange('.$data->fd_id.','.$data->fd_status.')">Inactive</span>'; 
                }
                $html .= '</td>
                <td width="15%">
                    <button  type="button" class="btn btn-default option_btn " onclick="view_feedef('.$data->fd_id.')" title="Click here to view the details" data-toggle="modal" data-target="#view_fee" style="color:blue;cursor:pointer;">
                    <i class="fa fa-eye "></i>
                    </button>
                    <button class="btn btn-default option_btn " title="Edit" onclick="edit_feedef('.$data->fd_id.')">
                        <i class="fa fa-pencil "></i>
                    </button>
                </td>
            </tr>';
        $i++; 
        }
    }
    echo $html;
}
public function titleCheck()
{
    $title=$this->input->post('title');
    $query= $this->db->get_where('am_fee_definition',array("fee_definition"=>$title,'fee_definition_status'=> '1'));
    if($query->num_rows()>0)
    {
       echo 'false';
    }
    else
    {
        echo 'true';
    }
}
public function edit_fee_status()
{
// print_r($_POST);
    $id = $this->input->post('id');
    $status = $this->input->post('st');
    $res = $this->transport_model->change_fee_status($id, $status);
    if($res == 1){
        $what=$this->db->last_query();
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        logcreator('update', 'database', $who, $what, $id, 'am_fee_definition', 'Transportaion fee definition status changed');
    }
    print_r($res);
}
public function get_feedef_by_id_old($id){
    $html ='';
    $result1 = "";
    $counter = 1;
    $feedef = $this->transport_model->get_feedef_id($id); 
    $details = $this->transport_model->get_details_id($id);
    // print_r($details);
    foreach($details as $dt){
        $result1 = "";
        $paymentHead = $this->transport_model->get_payment_head();
        $result1 .='<select class="form-control stopname" name="payment_head['.$counter.']" id="payment_head'.$counter.'">
                    <option value="">Select</option>';
        if(!empty($paymentHead)){
            foreach($paymentHead as $Head){
                $result1 .= '<option value="'.$Head->ph_id.'"';
                if($Head->ph_id == $dt->fee_head_id){ $result1 .= 'selected'; }
                $result1 .= '>'.$Head->ph_head_name.'</option>';
              }
        }
        $result1 .='</select>';
        $html .='<tr id="stop_tr_'.$counter.'" class="tr"><td data-title="Stop Name">'.$result1.'</td>';
        $html .='<td data-title=""><input class="form-control numberswithdecimal"  type="hidden" id="id'.$counter.'" name="id'.$counter.'"value="'.$dt->fee_definition_details_id.'">';
        $html .='<a href="javascript:void(0)" class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs valid" id="'.$counter.'" onclick="deletefunction(this.id);  edit_removeTextbox('.$counter.');" title="Click here to remove fee definition" ><i class="fa fa-remove"></i></a></td>';
        $html .='</tr>';
        $counter++;
    }
    $feedef['html'] = $html;
    $feedef['counter'] = $counter;
    print_r(json_encode($feedef));
}

public function get_feedef_by_id()
{
  
   if($_POST)
   {
      $id=$this->input->post('edit_id');
      
      $fee_defenition_name=$this->common->get_name_by_id('tt_fee_definiftion','fd_title',array("fd_id"=>$id));
      $details = $this->transport_model->get_details_id($id);
     // print_r($details);
     $data=array();
     $counter=1;
    
     $html="";
      foreach($details as $row) 
      {
        $select="";
        $paymentHead = $this->transport_model->get_payment_head();
        $select .='<select class="form-control stopname" name="payment_head['.$counter.']" id="payment_head'.$counter.'">
                    <option value="">Select</option>';
           if(!empty($paymentHead)){
            foreach($paymentHead as $Head){
                $select .= '<option value="'.$Head->ph_id.'"';
                if($Head->ph_id == $row['fee_id'])
                { $select .= 'selected'; }
                $select .= '>'.$Head->ph_head_name.'</option>';
              }
            }
         $select .='</select>';
         $html.='<tr id="fee_def_'.$counter.'">
                <td class="tr">'. $select.'<input type="hidden" value="'.$row['fdd_id'].'"/></td>
                <td class="tr"><input type="text" name="feeamount['.$counter.']" class="form-control numberswithdecimal" value="'.$row['fee_amount'].'"/></td>
                <td><a class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs valid" id="'.$counter.'" onclick="deletefunction('.$row['fdd_id'].','.$counter.');" title="Click here to remove fee definition" ><i class="fa fa-remove"></i></a>
                </td>
                </tr>';
                $counter++;
      }
     
      $data['name']=$fee_defenition_name;
      $data['html']=$html;
      print_r(json_encode($data));
   } 
}

public function delete_fee_sub_defenition()
{
    print_r($_POST);
}

public function fee_def_edit(){
    if($_POST)
    {
        $id = $this->input->post('edit_fee_id');
        $data['fd_title']        = $this->input->post('title');
        // $fee_def_id              = $this->Discount_model->insert_fee_def($data);
        $response =$this->Common_model->update('tt_fee_definiftion', $data ,array('fd_id'=>$id));
        if($response){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $response, 'tt_fee_definiftion', 'Transportaion fee defintion edited');
            if ($id) {
                $res = $this->transport_model->fee_details_delete($id);
                if($res){
                    $paymentHeadArr     = $this->input->post('payment_head');
                    $feeamountArr     = $this->input->post('feeamount');
                    $idArr      = $id;
                    $stopArr            = array();
                    if (!empty($paymentHeadArr)) {
                        foreach ($paymentHeadArr as $key => $val) {
                            if (!empty($paymentHeadArr[$key])) {
                                $tempArr = array(
                                    'fd_id' => $idArr,
                                    'fee_amount' => $feeamountArr[$key],
                                    'fee_id' => $paymentHeadArr[$key]
                                );
                                array_push($stopArr, $tempArr);
                            }
                        }
                    }
                    if (!empty($stopArr)) {
                        $f = 1;
                        foreach($stopArr as  $key=>$row){
                            $response = $this->transport_model->insert_fee_def_details($row);
                            if($response == false){
                                $f = 0;
                            }else{
                                $what=$this->db->last_query();
                                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                                logcreator('insert', 'database', $who, $what, $response, 'am_fee_definition_details', 'Transportaion fee definition details edited');
                            }
                        }
                        if($f == 1){
                            $ajax_response['st']=1;
                            $ajax_response['msg']="Successfully updated data";
                        }
                    }
                }else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..1!";
                }
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..2!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..3!";
        }
    }else{
        $ajax_response['st']=0;
        $ajax_response['msg']="Something went wrong,Please try again later..4!";
    }
    print_r(json_encode( $ajax_response));
}
public function view_feedef_by_id()
{
    if($_POST){
        $id=$this->input->post('id');
        $fee_defenition_name=$this->common->get_name_by_id('tt_fee_definiftion','fd_title',array("fd_id"=>$id));
        $details = $this->transport_model->get_details_id($id);
        $data=array();
        $html="";
        foreach($details as $row){
            $select="";
            $paymentHead = $this->transport_model->get_payment_head();
            if(!empty($paymentHead)){
                foreach($paymentHead as $Head){
                    if($Head->ph_id == $row['fd_id'])
                    { $select = $Head->ph_head_name; }
                }
            }
            $html.='<tr>
                   <td class="tr">'. $select.'</td>
                   <td class="tr" style="text-align:right;">'. $row['fee_amount'].'</td>
                   </tr>';
        }
        $data['name']=$fee_defenition_name;
        $data['html']=$html;
        print_r(json_encode($data));
   } 
}


public function get_fee_heads() {
    $fd_id = $this->input->post('fd_id');
    $fees = $this->Discount_model->get_fee_headsbyid($fd_id); //print_r($fees);
    $html = '';
    $data['status'] = 0;
    $data['data']   = '';
    if(!empty($fees)) {
        $data['status'] = 1;
        $data['message'] = "Loading data...";
        $i=1;
        foreach($fees as $fee) {
            $html .= '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>'.$fee['ph_head_name'].'<span class="req redbold">*</span></label><input type="hidden" name="fee_id[]" value="'.$fee['fee_head_id'].'">
                                <input type="number"  min="0" name="fee_amount'.$fee['fee_head_id'].'" class="form-control numbersOnly tooltipstered validationcls'.$i.'" placeholder="Amount" autocomplete="off">
                            </div>
                    </div>';
            $i++;
        }
        $data['data'] = $html;
    } else {
        $data['message'] = "Invalid fee definition.";
    }
    print_r(json_encode($data));
}

public function transport_fee_collection() {
    check_backoffice_permission('transport_fee_collection');
    $this->data['page']         = "admin/trans_fee_collection";
    $this->data['menu']         = "basic_configuration";
    $this->data['studentArr']   = $this->student_model->get_transport_student_list();
    $this->data['routes']       = $this->common->get('tt_transport');
    $this->data['breadcrumb']   = $this->lang->line('fee_collection');
    $this->data['menu_item']    = "transport-fee-collection";
    $this->load->view('admin/layouts/_master',$this->data); 
    
}

public function transport_fee_collection_old() {
    check_backoffice_permission('transport_fee_collection');
    $this->data['page']         = "admin/trans_fee_collection";
    $this->data['menu']         = "basic_configuration";
    $this->data['studentArr']   = $this->student_model->get_transport_student_list();
    $this->data['routes']       = $this->common->get('tt_transport');
    $this->data['breadcrumb']   = $this->lang->line('fee_collection');
    $this->data['menu_item']    = "transport-fee-collection";
    $this->load->view('admin/layouts/_master',$this->data); 
    
}


/*
    *   function'll get the student list by pagination
    *   @author GBS-L
    */
                          
    
    public function trans_student_list_pagination() 
    {
      // print_r($_POST); 
        // Datatables Variables
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

        if($dir != "desc" && $dir != "desc") {
            $dir = "desc";
        }

         $columns_valid = array(
            "am_students.registration_number", 
            "am_students.name", 
            "am_students.email", 
            "am_students.contact_number", 
            "tt_transport.route_name", 
            "am_students.status"
        );

         if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
   
            $list = $this->student_model->trans_student_list_pagination($start, $length, $order, $dir);
       
        

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $rows) {
            if ($rows['status']==1)
            {
                $status= '<a style="cursor:pointer"><span class="admitted">Admitted</span></a>';
            }
            else if($rows['status']==2) 
            {
                $status= '<a style="cursor:pointer"><span class="paymentcompleted">Fee Paid</span></a>';
            }
            else if($rows['status']==4) 
            { 
                $status= '<a style="cursor:pointer"><span class="batchchanged">Batch Changed</span></a>';
            }
            else if($rows['status']==5) 
            {
                $status= '<a style="cursor:pointer"><span class="inactivestatus">Inactive</span></a>';
            }
            else if($rows['status']==0 && $rows['verified_status']==1) {
                $status= '<span class="paymentpending">Payment Pending</span>';
            }
            else 
            {
                $status= '<a style="cursor:pointer"><span class="registered">Registered</span></a>';
            }
            
            if($rows['caller_id']>0) 
            { 
                $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$rows['caller_id']));
                     if(!empty($callcentre['call_status']))
                     {
                       $ccstatus = $callcentre['call_status'];
                         if($ccstatus==4)
                            { 
                                $blacklist_status= '<span class="inactivestatus" style="margin-top:3px;">blacklist</span>';
                            }
                     }
            }
            
            $blacklist_status="";
            $id_status = '';
            
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['registration_number'];
            $row[] = $rows['name'];
            $row[] = $rows['email'];
            $row[] = $rows['contact_number'];
            $row[] = $rows['route_name'];
            $row[] = $status." ".$blacklist_status;
            //$row[] = $id_status;
            $row[] = '<a class="btn btn-primary btn-sm btn_details_view transpay" onclick="loadpayscreen('.$rows['student_id'].')">
                            Pay
                            
                    </a>';
            $data[] = $row; // href="'.base_url().'backoffice/transport-fee-collection/'. $rows['student_id'].'"
        }
        $total_rows=$this->student_model->get_trans_num_student_list_pagination();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }



    public function get_transportfee($student_id = NULL, $st_id = NULL) {
        $data         = $this->transport_model->get_student_transfee($student_id); 
        $this->data['data']         = $data;
        $this->data['student_id']   = $student_id;
        $this->data['st_id']        = $st_id;
        $this->data['student_status']  = 'Active'; 
        $student_trans= $this->common->get_from_tablerow('tt_student_transport', array('st_id'=>$st_id)); 
        if(!empty($student_trans) && $student_trans['status']==2) {
            $this->data['student_status']  = 'Cancelled'; 
        }
        $this->data['student_trans'] = $student_trans;
        $this->data['batch']        = $this->common->get_from_tablerow('am_batch_center_mapping', array('batch_id'=>$data->batch_id));
        $this->Common_model->update('tt_student_transport', array('batch_id'=>$data->batch_id), array('st_id'=>$st_id));
        $this->data['student']      = $this->common->get_from_tablerow('am_students', array('student_id'=>$student_id));
        $this->data['fees']         = $this->transport_model->get_student_transfee_def($data->fee_definition, $data->transport_id);
        $html = $this->load->view('admin/trans_fee_collection_view',$this->data, TRUE); 
        echo $html; 
    }

    public function trans_payment() { //echo '<pre>';print_r($_POST);
        $months = $this->input->post('month');
        $student_id = $this->input->post('student_id');
        $st_id = $this->input->post('st_id');
        $pay_id = $this->input->post('pay_id');
        $monthly = $this->input->post('monthly');
        if(!empty($months)) {
            $html = '<table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">
            <tr><th>'.$this->lang->line('month').'</th><th class="text-right">'.$this->lang->line('amount').'[INR]</th></tr>
            ';
            $fee_id = $this->input->post('fee_id'); //print_r($fee_id);
            if(!empty($fee_id)) {
                foreach($fee_id as $id) {
                    $feeamt = $this->input->post('feeamount'.$id);
                    $html .= '<input type="hidden" name="feeamount'.$id.'" value="'.$feeamt.'" /><input type="hidden" name="fee_id[]" value="'.$id.'" />';
                }
            }
            $total = 0;
            foreach($months as $month) {
                $monthly = $this->input->post('monthly'.$month);
                $mnth       =   $this->input->post('month'.$month);
                $monthtxt = date('M', strtotime('2019-'.$mnth.'-01'));
                $amount     =   $this->input->post('recurring'.$month);
                $year       =   $this->input->post('year'.$month);
                $total      +=  $amount;
                $html .= '
                <tr>
                    <td>'.$monthtxt.' - '.$year.'</td><input type="hidden" name="amount'.$month.'" value="'.$monthly.'" />
                    <input type="hidden" name="year'.$month.'" value="'.$year.'" />
                    <input type="hidden" name="month'.$month.'" value="'.$mnth.'" />
                    <td class="text-right">'.$amount.'</td><input type="hidden" name="month[]" value="'.$month.'" />
                </tr>';
            }
            $html .= '
                <tr>
                    <td><strong>'.$this->lang->line('total').'</strong></td>
                    <td class="text-right"><strong>'.numberformatwithout($total).'</strong></td>
                </tr>
                <tr>
                    <td><strong>'.$this->lang->line('payable_amount').'</strong></td>
                    <td><input class="form-control" type="text" style="text-align:right;" value="'.numberformatwithoutcomma($total).'" name="payable_amount" readonly/></td>
                </tr><input type="hidden" name="student_id" value="'.$student_id.'" />
                <input type="hidden" name="st_id" value="'.$st_id.'" />
                <input type="hidden" name="pay_id" value="'.$pay_id.'" />
                <tr class="dirbtntransport">
                    <td></td><input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />
                    <td style="text-align:right;"><input type="button" onclick="trans_payment_process()" class="btn btn-info btn_save" value="Pay" name="submit"/></td>
                </tr>';
            $html .='</table>';
            $data['status']     =   true;
            $data['message']    =   'Success';
            $data['data']       =   $html;
        } else {
            $data['status']     =   false;
            $data['message']    =   'Please choose a month to pay';
            $data['data']       =   '';
        }

        echo json_encode($data);
    }


    public function trans_payment_process() {
        $months = $this->input->post('month');
        $student_id = $this->input->post('student_id');
        $st_id = $this->input->post('st_id');
        $payable_amount = $this->input->post('payable_amount');
        $fee_id = $this->input->post('fee_id');
        $pay_id = $this->input->post('pay_id');
        if(!empty($months)) {
            if($pay_id>0) {
                $data = array('paid_amount'=>$payable_amount
                            );
              $this->db->where('pay_id', $pay_id);              
              $this->db->update('tt_payments', $data);  
            } else {
            $data = array('student_id'=>$student_id,
                            'st_id'=>$st_id,
                            'paid_amount'=>$payable_amount
                            );
            $this->db->insert('tt_payments', $data);  
            $pay_id = $this->db->insert_id();   
            }  
            $invoice = array('invoice_no'=>'INVT'.$pay_id.rand(),
                            'invoice_amount'=>$payable_amount,
                            'pay_id'=>$pay_id
                            );       
            $this->db->insert('tt_invoice', $invoice);
            $invoice_id = $this->db->insert_id(); 
            if(!empty($fee_id)) {
                foreach($fee_id as $id) {
                    $feeamt = $this->input->post('feeamount'.$id);
                    $feeArr = array('pay_id'=>$pay_id,
                                    'fee_id'=>$id,
                                    'invoice_id'=>$invoice_id,
                                    'feeamount'=>$feeamt,
                                    'fee_type'=>'onetime'
                                    );
                    $this->db->insert('tt_payment_details', $feeArr);             
                }
            }
            foreach($months as $month) {
                $amount = $this->input->post('amount'.$month);
                $year = $this->input->post('year'.$month);
                $mnth = $this->input->post('month'.$month);
                    $monthArr = array('pay_id'=>$pay_id,
                                    'fee_id'=>$mnth,
                                    'year'=>$year,
                                    'invoice_id'=>$invoice_id,
                                    'feeamount'=>$amount,
                                    'fee_type'=>'monthly'
                                    );
                    $this->db->insert('tt_payment_details', $monthArr); 
            }
            if($pay_id>0) {
                $return['status']   = true;
                $return['message']  = 'Payment completed successfully.';
                $return['data']     = '';
            } else {
                $return['status']   = false;
                $return['message']  = 'Payment failed, please try again.';
                $return['data']     = '';
            }
        } else {
            $return['status']   = false;
            $return['message']  = 'Payment failed, please try again.';
            $return['data']     = '';
        }
        echo json_encode($return);
    }


    
    public function trans_canncel_process($student = NULL, $st_id = NULL) {
        if($student!='' && $st_id!='') {

            $query = $this->Common_model->update('tt_student_transport', array('status'=>2), array('st_id'=>$st_id));
            $query = $this->Common_model->update('am_students', array('transportation'=>'no'), array('student_id'=>$student));
            
            if($query) {
                $return['status']   = true;
                $return['message']  = 'Transportation cancelled successfully.';
                $return['data']     = '';
            } else {
                $return['status']   = false;
                $return['message']  = 'Cancellation failed, please try again.';
                $return['data']     = '';
            }
        } else {
            $return['status']   = false;
            $return['message']  = 'Cancellation failed, please try again.';
            $return['data']     = '';
        }
        echo json_encode($return);
    }


}
