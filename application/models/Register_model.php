<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Register_model extends Direction_Model {

     public function __construct()
     {
        parent::__construct();
     }

    public function register_student($data)
    {
      	$res=$this->db->insert('am_students',$data);
	   if($res)
       {

           return true;
       }
        else
        {
            return false;
        }
    }
    public function add_student_qualification($data)
    {
      		$query=$this->db->insert('am_student_qualification',$data);
            if($query)
            {
                return true;
            }
           else
           {
               return false;
           }
    }
    public function add_student_course($data)
    {
       $query=$this->db->insert('am_student_course_mapping',$data);
            if($query)
            {
                return true;
            }
           else
           {
               return false;
           }
    }
    
    public function save_student_credential($student_credential)
    {
        $query=$this->db->insert('am_users',$student_credential);
            if($query)
            {
                return true;
            }
           else
           {
               return false;
           } 
    }
    
    // function'll get branch by course_id
    public function get_branchby_courseid($course_id = NULL) {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping'); 
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_institute_course_mapping.branch_master_id');
        $this->db->where('am_institute_course_mapping.course_master_id',$course_id);
        $this->db->where('am_institute_course_mapping.status', 1); 
        //$this->db->group_by('am_institute_course_mapping.branch_master_id');
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
        
    }
    
    // function'll get batch by istitute_course_id
    public function get_batch_by_insticourse_id($insti_course_id = NULL) {
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping'); 
        $this->db->where('institute_course_mapping_id',$insti_course_id);
        $this->db->where('batch_status', 1); 
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
        
    }

    public function delete_others($id)
    {
        $this->db->where('qualification_id', $id);
        $query=$this->db->delete('am_student_qualification');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
        return $return;
    }
    
}
?>
