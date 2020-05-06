<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Syllabus_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
	/**
	*This function 'll return the syllabus table list count
	*
	* @access public
	* @params 
	* @return integer
	* @author Lekshmi
	*/	
	public function syllabus_count() {

        return $this->db->count_all('am_syllabus');
    }
	//--------------------------------------------------
	
	
	/**
	*This function 'll list syllabus table
	*
	* @access public
	* @params 
	* @return result array
	* @author Lekshmi
	*/	
  
	function get_syllabus_list($limit=0,$page=0) {
		$this->db->select('*');
		//$this->db->where('school_id', $this->session->userdata('school_id'));
		$this->db->where('syllabus_status', '1');
		$this->db->order_by( 'syllabus_id', 'DESC');
		$query	=	$this->db->get('am_syllabus');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
       }


	//------------------------------------------------
    /**
	*This function 'll list syllabus table
	*
	* @access public
	* @params 
	* @return result array in alphabetic order to show in drop downs
	* @author Lekshmi
	*/	
  
	function get_allsyllabus_list() {
		$this->db->select('*');
		$this->db->where('syllabus_status', '1');
		$this->db->order_by( 'syllabus_name', 'ASC');
		$query	=	$this->db->get('am_syllabus');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
       }


	//------------------------------------------------

	
	/**
	*This function 'll insert syllabus details
	*
	* @access public
	* @params array
	* @return integer
	* @author Lekshmi
	*/	
	function insert_syllabus($data=0){	
	
		$res=$this->db->insert('am_syllabus',$data);
         //logcreator($action = '', $objecttype = '', $who = '', $what = '', $table_row_id = '', $tablename='');
		return True;
        }
	    

	

        
	    

	//-------------------------------------------------
	
	/**
	*This function 'll update syllabus details by id
	*
	* @access public
	* @params 
	* @return result array
	* @author Lekshmi
	*/	
	public function edit_syllabus($editArr='',$id=0){
		$this->db->where('syllabus_id',$id);
		$query	= $this->db->update('am_syllabus',$editArr);
		
		
		$return	=	true;
		
		if(!$query){
			$return	=	false;
		}
		
		return  $return;
	}
		
	function insert_section($data2=''){	
	
		$this->db->insert('am_section',$data2);	
	    return True;
        
        }
	    

	//-------------------------------------------------
  /**
	*This function return syllabus name
	*
	* @params syllabus id
	* @return result array
	* @author vijila
	*/
	function get_syllabus_name($id=''){
       
            $this->db->select('syllabus_name');
		    $this->db->where('syllabus_id',$id);
		    $res = $this->db->get('am_syllabus')->row_array();
		 return $res;
		
    }
	/*--------------------------------------*/


	/**
	*This function 'll list syllabus table
	*
	* @access public
	* @params 
	* @return result array
	* @author Lekshmi
	*/	
  
	function get_all_syllabus() {
		
		//$this->db->where('school_id', $this->session->userdata('school_id'));
		$this->db->where('syllabus_status', '1');
		$query	=	$this->db->get('am_syllabus');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
       }
    function get_all_schools() {
		
		//$this->db->where('school_id', $this->session->userdata('school_id'));
		$this->db->where('school_status', '1');
		$query	=	$this->db->get('am_schools');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
       }


	//------------------------------------------------
    function delete_syllabus($id)
    {
        $this->db->where('syllabus_id', $id);
        $query=$this->db->update('am_syllabus',array("syllabus_status"=>"2"));
        $return	=	true; 
		
		if(!$query){
			$return	=	false;
		}
		
		return $return;
    }
    
    function get_syllabus_by_id($syllabus_id) 
    {
		$this->db->select('*');
		$this->db->where('syllabus_id',$syllabus_id);
		$query	=	$this->db->get('am_syllabus');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
 
       }
     function get_syllabus($syllabus_name=""){
		$this->db->select('syllabus_id');
		$this->db->where('syllabus_name',$syllabus_name);
		$res = $this->db->get('am_syllabus')->row_array();
	    return $res;
		
    }
    public function subject_syllabus_add_mapping($data)
    {
      $res= $this->db->insert('mm_subject_course_mapping',$data);	
	    if($res)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function isexist_subject_syllabus_mapping($data)
    {
        
        $data['subject_status']=1;
        $query= $this->db->get_where('mm_subject_course_mapping',$data);
        
		return $query->num_rows();
        
    }public function isexist_subject_syllabus_mapping_edit($data,$id)
    {
         $data['subject_status']=1;
        $this->db->select('*');
		$this->db->where($data);
        $this->db->where_not_in('subject_id', $id);
		$res = $this->db->get('mm_subject_course_mapping')->row_array();
	    return $res;
        
		return $query->num_rows();
        
    }
    public function get_allsubject_syllabus_mapping()
    {
         //$query=$this->db->get_where('mm_subject_course_mapping',array("subject_status"=>"1"));
        
      $query= $this->db->select('mm_subject_course_mapping.*, am_classes.class_name, am_syllabus.syllabus_name,mm_subjects.subject_name as subname')
             ->from('mm_subject_course_mapping')
             ->where(array("mm_subject_course_mapping.subject_status"=> "1","mm_subject_course_mapping.parent_subject_master_id"=>NULL))
             ->join('am_classes ', 'mm_subject_course_mapping.course_master_id = am_classes.class_id')
             ->join('am_syllabus', 'mm_subject_course_mapping.syllabus_master_id = am_syllabus.syllabus_id')
             ->join('mm_subjects', 'mm_subject_course_mapping.subject_master_id = mm_subjects.subject_id')
             ->get();
		 $resultArr	=	array();
		
		if( $this->db->affected_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
        
    }
    
    public function delete_subject_syllabus_mapping($where)
    {
        
         $this->db->where($where);
		 $query	= $this->db->delete('am_syllabus_master_details');
		if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
		
		
    }
    
    public function get_subjectSyllabus_mapping_byid($id)
    {
         $query= $this->db->select('mm_subject_course_mapping.*, am_classes.class_name, am_syllabus.syllabus_name,mm_subjects.subject_name as subname')
             ->from('mm_subject_course_mapping')
             ->where(array('mm_subject_course_mapping.subject_status'=>'1','mm_subject_course_mapping.subject_id'=>$id))
             ->join('am_classes ', 'mm_subject_course_mapping.course_master_id = am_classes.class_id')
             ->join('am_syllabus', 'mm_subject_course_mapping.syllabus_master_id = am_syllabus.syllabus_id')
             ->join('mm_subjects', 'mm_subject_course_mapping.subject_master_id = mm_subjects.subject_id')
             ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->row_array();
           return $details;
        }
        else
        {
            return false;
        } 
    }
    
    public function edit_subject_syllabus_mapping($data,$id)
    {
         $this->db->where(array("subject_id"=>$id));
		 $query	= $this->db->update('mm_subject_course_mapping',$data);
		if($query)
        {
            return true;
        }
        else
        {
            return false;
        } 
    }
    
    public function get_modules_byparent_in_mapping($parent_subject_id,$course_id)
    {
       $query= $this->db->select('mm_subject_course_mapping.subject_master_id,mm_subjects.subject_name as subname')
             ->from('mm_subject_course_mapping')
             ->where(array('mm_subject_course_mapping.subject_status'=>'1','mm_subject_course_mapping.parent_subject_master_id'=>$parent_subject_id,'mm_subject_course_mapping.course_master_id'=>$course_id))
             ->join('mm_subjects', 'mm_subject_course_mapping.subject_master_id = mm_subjects.subject_id')
             ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result_array();
           return $details;
        }
        else
        {
            return false;
        }  
	}
	
	  /**
	*This function 'll return existing syllabus details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_syllabus_exist($data)
    {
        $query= $this->db->get_where('am_syllabus',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    
/*
*   function'll insert data to tables
*   @params table name, data array
*   @author GBS-R
*/
    
public function insert($table, $data) { 
    $query = $this->db->insert($table, $data);
	    if($query)
        {
            return true;
        }
        else
        {
            return false;
        }                                   
} 
    
/*
*   function'll get_syllabus_module_mapping
*   @params table name, data array
*   @author GBS-R
*/    
    
   public function get_syllabus_module_mapping()
    {
         $query= $this->db->select('am_syllabus_master_details.syllabus_master_detail_id,am_syllabus_master_details.subject_master_id,am_syllabus.*,mm_subjects.*')
             ->from('am_syllabus_master_details')
             //->where(array('mm_subject_course_mapping.subject_status'=>'1','mm_subject_course_mapping.subject_id'=>$id))
             //->join('am_classes ', 'mm_subject_course_mapping.course_master_id = am_classes.class_id')
             ->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id')
             ->join('am_syllabus', 'am_syllabus.syllabus_id = am_syllabus_master_details.syllabus_master_id')
             ->order_by('am_syllabus_master_details.syllabus_master_detail_id', 'desc')
             ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result();
           return $details;
        }
        else
        {
            return false;
        } 
    }
    
    
/*
*   function'll get_syllabus_module_mapping
*   @params table name, data array
*   @author GBS-R
*/    
    
   public function get_syllabus_module_mapping_search($subject = NULL, $syllabus = NULL)
    {
       $this->db->select('am_syllabus_master_details.syllabus_master_detail_id,am_syllabus.*,mm_subjects.*');
       $this->db->from('am_syllabus_master_details');
       $this->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
       $this->db->join('am_syllabus', 'am_syllabus.syllabus_id = am_syllabus_master_details.syllabus_master_id');
       if($subject!='') {
          $this->db->where('am_syllabus_master_details.subject_master_id', $subject); 
       }
       if($syllabus!='') {
           $this->db->where('am_syllabus_master_details.syllabus_master_id', $syllabus);  
       }
       $this->db->order_by('am_syllabus_master_details.syllabus_master_detail_id', 'desc');
       $query = $this->db->get();
       $details=array();
       if($query->num_rows()>0)
        {
           $details= $query->result();
           return $details;
        }
        else
        {
            return false;
        } 
    } 
    
/*
*   function'll get_parent_modules
*   @params table name, data array
*   @author GBS-R
*/    
    
   public function get_parent_modules($syllabus_id = NULL, $subject_id = NULL)
    {
         $query= $this->db->select('am_syllabus_master_details.syllabus_master_detail_id,am_syllabus.*,mm_subjects.*')
             ->from('am_syllabus_master_details')
             ->where(array('am_syllabus_master_details.syllabus_master_id'=>$syllabus_id,'am_syllabus_master_details.subject_master_id'=>$subject_id,'mm_subjects.subject_status'=>1,'am_syllabus.syllabus_status'=>1))
             ->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id')
             ->join('am_syllabus', 'am_syllabus.syllabus_id = am_syllabus_master_details.syllabus_master_id')
             ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result();
           return $details;
        }
        else
        {
            return false;
        } 
    } 
    
    function get_syllabusmaster_details($id = NULL) {
		
		//$this->db->where('school_id', $this->session->userdata('school_id'));
		$this->db->where('syllabus_master_detail_id', $id);
		$query	=	$this->db->get('am_syllabus_master_details');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
 
       }

       public function get_syllabus_docs($syllabus_id,$file_name)
    {
    $query= $this->db->where('syllabus_id',$syllabus_id)->where('file_name',$file_name)->get('am_syllabus')->row_array(); 
    }
    
/*
*   function'll list basic entity
*   @params 
*   @author GBS-R
*/
  
function get_basic_list() {
		$this->db->select('*');
        $this->db->order_by('entity_type', 'ASC');
        $this->db->order_by('entity_name', 'ASC');
		$query	    =	$this->db->get('am_basic_entity');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		return $resultArr;
 
       }

function check_basic_entity($entity = NULL, $mode = NULL) {
    $this->db->select('*');
    $this->db->where('entity_name', $entity);
    $this->db->where('entity_type', $mode);
    $query	    =	$this->db->get('am_basic_entity');
    $resultArr	=	0;
    if($query->num_rows() > 0){
        $resultArr	=	$query->num_rows();		
    }
    return $resultArr;

} 

function checkedit_basic_entity($entity = NULL, $mode = NULL, $entity_id = NULL) {
    $this->db->select('*');
    $this->db->where('entity_name', $entity);
    $this->db->where('entity_type', $mode);
    $this->db->where('entity_id!=', $entity_id);
    $query	    =	$this->db->get('am_basic_entity');
    $resultArr	=	0;
    if($query->num_rows() > 0){
        $resultArr	=	$query->num_rows();		
    }
    return $resultArr;

} 


function get_basicentity_id($entity_id = NULL) {
    $this->db->select('*');
    $this->db->where('entity_id', $entity_id);
    $query	    =	$this->db->get('am_basic_entity');
    $resultArr	=	[];
    if($query->num_rows() > 0){
        $resultArr	=	$query->row();		
    }
    return $resultArr;

} 

function categoryCheckassign($qualification)
{
    $f = 1;
    $this->db->select('*');
    $this->db->where('qualification',$qualification);
    $query	=	$this->db->get('cc_call_center_enquiries'); //echo $this->db->last_query();
    if($query->num_rows() > 0){
        $f = 0;
        
    }

    $this->db->select('*');
    $this->db->where('specification',$qualification);
    $query	=	$this->db->get('am_staff_education'); //echo $this->db->last_query();
    if($query->num_rows() > 0){
        $f = 0;
        
    }

    $this->db->select('*');
    $this->db->where('qualification',$qualification);
    $query	=	$this->db->get('am_student_qualification'); //echo $this->db->last_query();
    if($query->num_rows() > 0){
        $f = 0;
        
    }
    
    return $f;
}


public function change_entity_status($id,$status)
{ 
    if($status == 0){
        $this->db->where('entity_id', $id);
        $query=$this->db->update('am_basic_entity',array("entity_status"=> 1));		
        if($query){
            return 1; 
        }else{
            return 0;
        }  
    }else{
        $this->db->where('entity_id', $id);
        $query=$this->db->update('am_basic_entity',array("entity_status"=> 0));		
        if($query){
            return 1; 
        }else{
            return 0;
        }  
    }
}

// COURSE MODE

function get_course_mode() {
    $this->db->select('*');
    $this->db->order_by('mode', 'ASC');
    $query	    =	$this->db->get('am_batch_mode');
    $resultArr	=	array();
    if($query->num_rows() > 0){
        $resultArr	=	$query->result();		
    }
    return $resultArr;

   }

function get_coursemode_id($entity_id = NULL) {
    $this->db->select('*');
    $this->db->where('mode_id', $entity_id);
    $query	    =	$this->db->get('am_batch_mode');
    $resultArr	=	[];
    if($query->num_rows() > 0){
        $resultArr	=	$query->row();		
    }
    return $resultArr;

} 


function checkedit_coursemode($entity = NULL, $entity_id = NULL) {
    $this->db->select('*');
    $this->db->where('mode', $entity);
    $this->db->where('mode_id!=', $entity_id);
    $query	    =	$this->db->get('am_batch_mode');
    $resultArr	=	0;
    if($query->num_rows() > 0){
        $resultArr	=	$query->num_rows();		
    }
    return $resultArr;

} 


function check_coursemode($entity = NULL) {
    $this->db->select('*');
    $this->db->where('mode', $entity);
    $query	    =	$this->db->get('am_batch_mode');
    $resultArr	=	0;
    if($query->num_rows() > 0){
        $resultArr	=	$query->num_rows();		
    }
    return $resultArr;

}

function categoryCheckassignStaff($name, $field)
{
    if($field != 'Online Transaction'){
        $f = 1;
        $this->db->select('*');
        $this->db->where($field, $name);
        $query	=	$this->db->get('am_staff_personal'); //echo $this->db->last_query();
        if($query->num_rows() > 0){
            $f = 0;
        }
        // show($this->db->last_query());
        return $f;
    }else{
        return 1;
    }
}
public function change_entity_statusStaff($name,$status)
{ 
    if($status == 0){
        $this->db->where('entity_name', $name);
        $query=$this->db->update('am_basic_entity',array("entity_status"=> 1));		
        if($query){
            return 1; 
        }else{
            return 0;
        }  
    }else{
        $this->db->where('entity_name', $name);
        $query=$this->db->update('am_basic_entity',array("entity_status"=> 0));		
        if($query){
            return 1; 
        }else{
            return 0;
        }  
    }
}

// CITY


function get_cities() {
    $this->db->select('*');
    $this->db->where('state_id', 19);
    $this->db->order_by('id', 'desc');
    $query	    =	$this->db->get('cities');
    $resultArr	=	array();
    if($query->num_rows() > 0){
        $resultArr	=	$query->result();		
    }
    return $resultArr;

   }


   function get_states() {
    $this->db->select('*');
    $this->db->where('country_id', 101);
    $this->db->order_by('name', 'asc');
    $query	    =	$this->db->get('states');
    $resultArr	=	array();
    if($query->num_rows() > 0){
        $resultArr	=	$query->result();		
    }
    return $resultArr;

   }  
   
   
function get_city_id($id = NULL) {
    $this->db->select('*');
    $this->db->where('id', $id);
    $query	    =	$this->db->get('cities');
    $resultArr	=	[];
    if($query->num_rows() > 0){
        $resultArr	=	$query->row();		
    }
    return $resultArr;

} 
    
}
