<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Direction_Controller extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
				$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				$this->load->library('Mailer', NULL, 'email');
				if(!$this->session->userdata('backoffice_user')){
					if($_POST){$this->filter_post();}
					if($_GET){$this->filter_get();}
				}
    }
    
	private function filter_post(){
		$this->load->helper('security');
		$_POST = $this->security->xss_clean($_POST);
	}

	private function filter_get(){
		$this->load->helper('security');
		$_GET = $this->security->xss_clean($_GET);
	}

}
?>
