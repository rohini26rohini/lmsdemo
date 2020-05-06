<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom404 extends Direction_Controller {

	public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('404');
	}
    
}
?>