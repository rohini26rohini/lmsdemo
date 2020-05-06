<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Success_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
	/**
	*This function 'll return the success stories table list count
	*
	* @access public
	* @params 
	* @return integer
	* @author Seethal
	*/	
	public function stories_count() {
        return $this->db->count_all('am_success_stories');
    }
	//--------------------------------------------------
	
	/**
	*This function 'll list success stories table
	*
	* @access public
	* @params 
	* @return result array
	* @author Seethal
	*/	
	function get_stories_list_by_school($id) {
		$this->db->select('*');
		$this->db->where('success_status', '1');
		$this->db->where('document_type', '1');
		$this->db->where('school_id', $id);
		$this->db->limit(5);
		$this->db->order_by('success_id','desc');
		$query	=	$this->db->get('web_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}
	function get_stories_list() {
		$this->db->select('*');
		$this->db->where('success_status', '1');
		// $this->db->where('document_type', '1');
		// $this->db->limit(5);
		$this->db->order_by('success_id','desc');
		$query	=	$this->db->get('web_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}
	function get_stories_list_limit() {
		$this->db->select('*');
		$this->db->where('success_status', '1');
		$this->db->where('document_type', '1');
		$this->db->limit(5);
		$this->db->order_by('success_id','desc');
		$query	=	$this->db->get('web_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
	//------------------------------------------------

	/**
	*This function 'll insert success stories details
	*
	* @access public
	* @params array
	* @return integer
	* @author Seethal
	*/	
	function insert_stories($data=0){	
		$res=$this->db->insert('am_success_stories',$data);
		return True;
    }
	//-------------------------------------------------
	
	/**
	*This function 'll check if  success stories already exist or not.
	*
	* @access public
	* @params array
	* @return integer
	* @author Seethal
	*/	
	function get_stories($name=''){
        $this->db->select('*');
		$this->db->where('name',$name);
		$res = $this->db->get('am_success_stories')->row_array();
		return $res;
    }
	//-------------------------------------------------
	
	/**
	*This function 'll update success stories details by id
	*
	* @access public
	* @params 
	* @return result array
	* @author Seethal
	*/	
	public function edit_stories($editArr='',$id=0){
		$this->db->where('success_id',$id);
		$query	= $this->db->update('am_success_stories',$editArr);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $this->db->last_query();
	}
	//------------------------------------------------	
	
	/**
	*This function 'll  delete success storiesby id
	*
	* @access public
	* @params 
	* @return result array
	* @author Seethal
	*/
		
	/*public function delete_syllabus($param2=''){
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('am_syllabus');*/
		
		/*//admission table
		$this->db->where('syllabus',$param2);
		$query	= $this->db->delete('admission');	
		
		//class table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('class');	
		
		//enroll table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('enroll');
		
		//fees table
		$this->db->where('syllabus',$param2);
		$this->db->delete('fees');
		
		//fees_cat_discount table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('fees_cat_discount');
		
		//fees_class table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('fees_class');
		
		//period table
		$this->db->where('syllabus',$param2);
		$this->db->delete('period');
		
		//period_class table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('period_class');
		
		//period_grade table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('period_grade');
		
		//period_subject_hour table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('period_subject_hour');
		
		//section table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('section');
		
		//subject table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('subject');
		
		//teacher table
		$this->db->where('syllabus_id',$param2);
		$this->db->delete('teacher');
		
		//teacher_attendance table
		$this->db->where('syllabus_id',$param2);
		$query = $this->db->delete('teacher_attendance');
		*/
		
		/*$return	=	true; 
		
		if(!$query){
			$return	=	false;
		}
		
		return $return;
	}*/
	
	//------------------------------------------------
	
  /**
	*This function return success stories name
	*
	* @params syllabus id
	* @return result array
	* @author Seethal
	*/
	function get_stories_name($id=''){
        $this->db->select('name');
        $this->db->where('success_id',$id);
        $res = $this->db->get('am_success_stories')->row_array();
		return $res;
    }
	/*--------------------------------------*/

	/**
	*This function 'll list success stories table
	*
	* @access public
	* @params 
	* @return result array
	* @author Seethal
	*/	
	function get_all_stories() {
		//$this->db->where('school_id', $this->session->userdata('school_id'));
		$this->db->where('success_status', '1');
		$query	=	$this->db->get('am_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
	//------------------------------------------------
    /**
	*This function 'll detete success stories details
	*
	* @access public
	* @params array
	* @return integer
	* @author Seethal
	*/	
    function delete_stories($id){
        $this->db->where('success_id', $id);
        $query=$this->db->delete('am_success_stories');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
		return $return;
	}
	function get_school_stories_list($id) {
		$this->db->select('*');
		$this->db->where('success_status', '1');
		$this->db->where('school_id', $id);
		$this->db->order_by('success_id','desc');
		$query	=	$this->db->get('web_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}
}