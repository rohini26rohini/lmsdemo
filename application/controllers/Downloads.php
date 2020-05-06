<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads extends Direction_Controller {

	public function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if(isset($_GET['url']) && !empty($_GET['url'])){
			//if(check_backoffice_permission('')) {
				$path = FCPATH."/materials/".$_GET['url'];
				$handle = @fopen($path, "rb");
				@header("Cache-Control: no-cache, must-revalidate");
				@header("Pragma: no-cache");
				@header("Content-Disposition: attachment; filename= ".basename($path));
				@header("Content-type: application/octet-stream");
				@header("Content-Length: ".filesize($path));
				@header('Content-Transfer-Encoding: binary');
				ob_end_clean();
				@fpassthru($handle);
			// }else{
			// 	redirect('404');
			// }
		}else{
			redirect('404');
		}
	}
	
    public function upload_image_ckeditor(){
        if(!empty($_FILES['file'])){
            $ext = explode('.',$_FILES['file']['name']);
            $config['upload_path']          = './uploads/ckeditor';
            $config['allowed_types']        = 'gif|jpeg|jpg|png|bmp';
            $config['file_name']            = uniqid().'.'.end($ext);
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $url = base_url('/uploads/ckeditor/'.$config['file_name']);
            if ($this->upload->do_upload('file')){
                $data=array("url"=>$url);
                echo json_encode($data);
            }else{
                print_r($this->upload->display_errors());exit;
            }
        }
    }

    public function test($id){
        $this->common->get_exam_details_by_scheduleid($id);
    }
	
}
