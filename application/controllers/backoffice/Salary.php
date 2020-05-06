<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->lang->load('information','english');
        $module="basic_configuration";
        check_backoffice_permission($module);
        //$this->common_functions->get_common();
        //$this->common_functions->set_language();
        //$this->common_functions->check_view_permission();
//        $this->data['permissions'] = $this->common_functions->get_user_permissions();
//        $this->data['languages'] = $this->common_functions->get_languages();
//        $this->data['temples'] = $this->common_functions->get_temples();
//        $this->data['mainmenu'] = $this->common_functions->main_menus();
//        $this->data['main_menu_id'] = '15';
//        $this->data['submenu'] = $this->common_functions->sub_menus($this->data['main_menu_id']);
//        $this->data['mainMenuLabel'] = $this->common_functions->get_menu_label($this->data['main_menu_id']);
    }
    
     public function scheme(){
        check_backoffice_permission('salary_scheme');
        $this->data['page']="admin/salary_scheme";
		$this->data['menu']="basic_configuration";
		//$this->data['syllabusArr']=$this->syllabus_model->get_syllabus_list();
        $this->data['breadcrumb']="Salary / Scheme";
        $this->data['menu_item']="salary-scheme";
		$this->load->view('admin/layouts/_master',$this->data);
    }

//    public function scheme() {
//        $this->data['subMenuId'] = '57';
//        $this->data['subMenuLabel'] = $this->common_functions->get_submenu_label($this->data['subMenuId']);
//        $this->load->view('includes/header',$this->data);
//        $this->load->view('salary/salary_scheme',$this->data);
//        $this->load->view('salary/salary_scheme_script',$this->data);
//        $this->load->view('includes/footer');
//    }

    public function salary_processing() {
        check_backoffice_permission('salary_processing');
        $this->data['page']="admin/salary_processing";
		$this->data['menu']="basic_configuration";
        $this->data['designation'] = $this->Content_model->get_designation(); 
        $this->data['staffArr']=$this->staff_enrollment_model->get_staff_list();
        $this->data['breadcrumb']="Salary / Salary Processing";
        $this->data['menu_item']="salary-processing";
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function salary_advances() {
       check_backoffice_permission('salary_advances');
        $this->data['page']="admin/salary_advances";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Salary / Salary Advances";
        $this->data['menu_item']="salary-advances";
		$this->load->view('admin/layouts/_master',$this->data);
        
//        $this->data['subMenuId'] = '81';
//        $this->data['subMenuLabel'] = $this->common_functions->get_submenu_label($this->data['subMenuId']);
//        $this->load->view('includes/header',$this->data);
//        $this->load->view('salary/salary_advances',$this->data);
//        $this->load->view('salary/salary_advances_script',$this->data);
//        $this->load->view('includes/footer');
    }

}