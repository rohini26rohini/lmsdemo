<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Homework_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_faculity_scheduled_batch($personal_id,$today)
    {
         $this->db->select('am_batch_center_mapping.*');
         $this->db->from('am_batch_center_mapping'); 
         //$this->db->where(array("am_batch_center_mapping.batch_status"=> 1,"am_batch_center_mapping.batch_datefrom>="=>$today,"am_batch_center_mapping.batch_dateto<="=>$today));
        $this->db->where(array("am_batch_center_mapping.batch_status"=> 1));
         $this->db->join('am_schedules', 'am_schedules.schedule_link_id=am_batch_center_mapping.batch_id');
         $this->db->where(array("am_schedules.schedule_type"=>"2","am_schedules.schedule_status"=>1,"am_schedules.staff_id"=>$personal_id));
         $this->db->group_by('am_batch_center_mapping.batch_id');
         $query	=	$this->db->get();
		 $resultArr	=	array();
		 if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
}
?>