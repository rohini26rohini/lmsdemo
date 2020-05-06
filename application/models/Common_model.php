<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
        
/*
*   function'll get from table result object
*   @params 
*   @author GBS-R
*/
    
function get_from_table_result_object($table = NULL, $where = NULL) 
    {
		$this->db->select('*');
		$this->db->where($where);
		$query	=	$this->db->get($table);
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
    }    
    
/*
*   function'll insert data array to table
*   @params table name, data array
*   @author GBS-R
*/
    
function insert($table = NULL, $data = NULL) {
    $query = $this->db->insert($table, $data);
    $last_inserted_id = $this->db->insert_id();
    if($query) {
        return $last_inserted_id;
    } else {
        return false;
    }
}    
    /*
*   function'll update data array to table
*   @params table name, data array
*   @author GBS-L
*/

function update($table = NULL, $data = NULL,$where=NULL) {
        $this->db->where($where);
		$query	= $this->db->update($table,$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
}
    /*
*   function'll update data array to table
*   @params table name, data array
*   @author GBS-L
*/

function delete($table = NULL,$where=NULL) {
        $this->db->where($where);
		$query	= $this->db->delete($table);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
}

/*
*   function'll get from table result object
*   @params 
*   @author GBS-R
*/
    
function get_branch() 
    {
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('institute_type_id', 2);
		$this->db->order_by('institute_name', 'ASC');
		$query	=	$this->db->get('am_institute_master');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
    }   

/*
*   function'll get from centre by branch id
*   @params 
*   @author GBS-R
*/
    
function get_centre_list($branch_id = NULL) 
    {
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('parent_institute', $branch_id);
		$this->db->where('institute_type_id', 3);
		$this->db->order_by('institute_name', 'ASC');
		$query	=	$this->db->get('am_institute_master');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
	}
	
	
/*
*   function'll get from centre by branch id
*   @params 
*   @author GBS-R
*/
    
function get_batch_list($centre_id = NULL) 
    {
		$this->db->select('*');
		$this->db->from('am_batch_center_mapping');
		$this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id');
		$this->db->where('batch_status', 1);
		$this->db->where('am_institute_course_mapping.institute_master_id', $centre_id);
		$this->db->order_by('batch_datefrom', 'DESC');
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
	} 	
	

/*
*   function'll get student from batch id
*   @params 
*   @author GBS-R
*/
    
function get_student_batch($batch_id = NULL) 
    {
		$this->db->select('am_students.name,am_students.mobile_number,am_students.contact_number');
		$this->db->from('am_students');
		$this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=am_students.student_id');
		$this->db->where('am_students.status', 1);
		$this->db->where('am_student_course_mapping.batch_id', $batch_id);
		$this->db->order_by('am_students.name', 'ASC');
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
    } 	


	    
function check_existing($table = NULL, $where = NULL) 
{
	$this->db->select('*');
	$this->db->where($where);
	$query	=	$this->db->get($table);
	$result	=	false;
	if($query->num_rows() > 0){
		$result	=	true;		
	}
	return $result;
}    


function check_existing_edit($table = NULL, $where = NULL) 
{
	$this->db->select('*');
	$this->db->where($where);
	$query	=	$this->db->get($table);
	$result	=	false;
	if($query->num_rows() > 0){
		$result	=	true;		
	}
	return $result;

} 



}
