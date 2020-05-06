<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coursecoordinator extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="coursecoordinator";
        //check_backoffice_permission($module);

    }

    public function index($id=NULL,$date = ""){
        $user_id = $this->session->userdata('user_id');
        if($user_id!=NULL){
            $this->data['staff'] = $this->common->get_staff_details_by_id($user_id);
        }
        $this->data['page']="admin/staff_view";
		$this->data['menu']="coursecoordinator";
        $this->data['breadcrumb']="Profile";
        $this->data['menu_item']="backoffice/profile";
		$this->load->view('admin/layouts/_master',$this->data);
    }


}
