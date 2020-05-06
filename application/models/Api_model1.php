<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }
    
    //get all request
    
    public function get_staff_by_badgenumber($badgenumber = NULL){
        $this->db->select('personal_id');
        $query=$this->db->get_where('am_staff_personal', array('biometric_id'=>$badgenumber));
        if($query->num_rows()>0)
        {
           $resultArr=$query->row_array(); 
           return $resultArr['personal_id'];
        }else{
            return false;
        }
    }
}

?>
