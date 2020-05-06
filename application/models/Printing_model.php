<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Printing_model extends Direction_Model {
    public function __construct() 
	{
        parent::__construct();
    }


    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Ramesh
	*/
	public function get_questions(){
		$query	=	$this->db->where('question_status',1)->get('am_questions');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
}