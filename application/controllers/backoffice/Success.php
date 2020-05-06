<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Success extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="basic_configuration";
        check_backoffice_permission();
        $this->load->model('success_model');
    }
    
    public function index(){
        $this->data['page']="admin/success.php";
		$this->data['menu']="success";
        $this->data['successArr']=$this->success_model->get_stories_list();
        $this->data['breadcrumb']="success";
		$this->load->view('admin/layouts/_master.php',$this->data); 
    }
    
    public function upload_image()
    {
        //  $data['POST']=$_POST;
        //  $data['FILES']=$_FILES;
        //  print_r($data); die();
        // $data['school_id']   = $this->session->userdata('school_id');
        $data['name']        = strtoupper($this->input->post('name'));
        $data['description'] = $this->input->post('description');
        //uploading file using codeigniter upload library
        if ($_FILES['file_name'] != '') { 
            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            $config['upload_path']           = 'uploads/success_stories/';
            $config['allowed_types']         = 'pdf';
            $_FILES['file_name']['name']     = $files['name'];
            $_FILES['file_name']['type']     = $files['type'];
            $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
            $_FILES['file_name']['size']     = $files['size'];
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');
            if ($upload) {
                $data['file_name'] = str_replace(' ', '_', $_FILES['file_name']['name']);
            } else {
                //$this->session->set_flashdata('error_message', 'Please Upload pdf file');
               // redirect(base_url() . 'admin-syllabus','refresh');
            }
            
        }
        $res=$this->success_model->insert_stories($data);
        //  print_r($res);
    }
    public function delete_stories($success_id){
      $res=$this->success_model->delete_stories($success_id); 
        if($res){
            redirect("admin-success");
        }
    }
}
?>