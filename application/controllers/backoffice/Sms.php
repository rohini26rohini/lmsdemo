<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends Direction_Controller {
    public function __construct() {
        parent::__construct();
       
       
    }
    
    public function send_sms()
    {
        $message="hai hello lekshmi";
        $mobile="918304042338";
        $this->Sms_model->send_sms($mobile,$message);
    }
}
?>