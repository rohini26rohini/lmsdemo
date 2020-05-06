<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_training extends Direction_Controller {

    public function __construct() {
        parent::__construct();
      }
    public function index(){
header("Content-type: text/json");
$myObj='{
    "statusCode": 200,
    "status": true,
    "message": "Successfully Updated the training assign",
    "data": null
}
';
echo $myObj;
    }
}  
?>