<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_management extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="basic_configuration";
        check_backoffice_permission($module);
    }
    
    public function scheme() {
         check_backoffice_permission("leave_scheme");
		$this->data['page']="admin/leave_scheme";
		$this->data['menu']="basic_configuration";
		//$this->data['syllabusArr']=$this->syllabus_model->get_syllabus_list();
        $this->data['breadcrumb']="Leave / Leave Scheme";
        $this->data['menu_item']="leave-scheme";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    public function staff_leave_status(){
         check_backoffice_permission("staff_leave_status");
        $this->data['page']="admin/leave_staff_status";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Leave / Staff Leave Status";
        $this->data['menu_item']="staff-leave-status";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
   /* public function staff_leave_entry(){
         $this->data['page']="admin/leave_entry";
		$this->data['menu']="basic_configuration";
		//$this->data['syllabusArr']=$this->syllabus_model->get_syllabus_list();
        $this->data['breadcrumb']="Leave / Staff Leave Status";
        $this->data['menu_item']="backoffice/staff-leave-status";
		$this->load->view('admin/layouts/_master',$this->data);
    }*/
    
 /*public function scheme() {
        $this->data['subMenuId'] = '70';
        $this->data['subMenuLabel'] = $this->common_functions->get_submenu_label($this->data['subMenuId']);
        $this->load->view('includes/header',$this->data);
        $this->load->view('leave/leave_scheme',$this->data);
        $this->load->view('leave/leave_scheme_script',$this->data);
        $this->load->view('includes/footer');
    }

    public function staff_leave_status(){
        $this->data['subMenuId'] = '82';
        $this->data['subMenuLabel'] = $this->common_functions->get_submenu_label($this->data['subMenuId']);
        $this->load->view('includes/header',$this->data);
        $this->load->view('leave/leave_staff_status',$this->data);
        $this->load->view('leave/leave_staff_status_script',$this->data);
        $this->load->view('includes/footer');
    }

    public function staff_leave_entry(){
        $this->data['subMenuId'] = '83';
        $this->data['subMenuLabel'] = $this->common_functions->get_submenu_label($this->data['subMenuId']);
        $this->load->view('includes/header',$this->data);
        $this->load->view('leave/leave_entry',$this->data);
        $this->load->view('leave/leave_entry_script',$this->data);
        $this->load->view('includes/footer');
    }
*/
}
?>