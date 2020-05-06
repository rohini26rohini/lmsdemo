<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Class_model extends Direction_Model {
    
     public function __construct() 
     {
        parent::__construct();
     }
    
    
       public  function classes_add($data)
       {	
            $this->db->insert('am_classes',$data);	
            $rows=  $this->db->insert_id();
           
             if($rows > 0)
             {
             return $rows;
             }else{
             return FALSE;
            }
       }
    
    function get_class($class_name,$syllabus_id,$school_id,$batch_mode_id){
		$this->db->select('class_id');
		$this->db->where('class_name',$class_name);
		$this->db->where('syllabus_id',$syllabus_id);
		$this->db->where('school_id', $school_id);
		$this->db->where('batch_mode_id', $batch_mode_id);
		$this->db->where('am_classes.status', '1');
		$res = $this->db->get('am_classes')->row_array();
	 return $res;
		
    }
    
    function get_class_list($limit='',$page='') {



		$this->db->select('am_classes.*,am_syllabus.syllabus_name,am_schools.school_name,am_batch_mode.mode as mode_name');
        $this->db->from('am_classes'); 
        $this->db->where('am_classes.status', '1');
        $this->db->join('am_schools', 'am_schools.school_id=am_classes.school_id');
        $this->db->join('am_syllabus', 'am_syllabus.syllabus_id=am_classes.syllabus_id');
        $this->db->join('am_batch_mode', 'am_batch_mode.mode_id=am_classes.batch_mode_id');
        // $this->db->where('c.album_id',$id);
        //$this->db->group_by('am_classes.class_name');
        $this->db->order_by('am_classes.class_id','desc');

		//$this->db->where('syllabus_id',$sylabus_id);
        //$this->db->limit( $limit, $page);
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
       }
    //get class name in ascending orderto show in dropdowns
    function get_allclass_list($limit='',$page='') {
		$this->db->select('am_classes.*,am_syllabus.syllabus_name,am_schools.school_name');
        $this->db->from('am_classes'); 
        $this->db->where('am_classes.status', '1');
        $this->db->join('am_schools', 'am_schools.school_id=am_classes.school_id');
        $this->db->join('am_syllabus', 'am_syllabus.syllabus_id=am_classes.syllabus_id');
        $this->db->order_by('am_classes.class_name','asc'); 
		
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
       }
    
    function delete_classes($id)
    {
        $this->db->where('class_id', $id);
        $query=$this->db->update('am_classes',array("status"=>"2"));
        $return	=	true; 
		
		if(!$query){
			$return	=	false;
		}
		
		return $return;
    }
    
    function edit_classes($data,$id){
        $this->db->where('class_id',$id);
		$query	= $this->db->update('am_classes',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}else{
            $color['schedule_color'] = $data['color'];
            $batches = $this->db->select('am_batch_center_mapping.batch_id')
                                ->from('am_batch_center_mapping')
                                ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                                ->join('am_classes','am_classes.class_id=am_institute_course_mapping.course_master_id')
                                ->where('am_classes.class_id',$id)
                                ->get()->result();
          
            $batch_ids = array();  
            if(!empty($batches))
            {
                foreach($batches as $k=>$v){
                    $batch_ids[$k] = $v->batch_id;
                }
                $this->db->where('schedule_type',2)
                            ->where_in('schedule_link_id',$batch_ids)
                            ->update('am_schedules',$color);
            }
        }
		return  $return;  
    }

    function get_class_by_id($class_id) 
    {
        $this->db->select('am_classes.*,am_syllabus.syllabus_name,am_schools.school_name,am_batch_mode.mode as mode_name');
        $this->db->from('am_classes'); 
        $this->db->where(array('am_classes.status'=> '1','am_classes.class_id'=>$class_id));
        $this->db->join('am_schools', 'am_schools.school_id=am_classes.school_id');
        $this->db->join('am_syllabus', 'am_syllabus.syllabus_id=am_classes.syllabus_id');
        $this->db->join('am_batch_mode', 'am_batch_mode.mode_id=am_classes.batch_mode_id');
		/*$this->db->select('*');
		$this->db->where('class_id',$class_id);
        $this->db->where('am_classes.status', '1');*/
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
 
       }
    
    
    /*
    *   function'll list all active courses
    *   @params
    *   @author GBS-R
    *
    */
    
    function get_active_courses() 
    {
		$this->db->select('*');
        $this->db->where('am_classes.status', '1');
		$query	=	$this->db->get('am_classes');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }
    
    /*
    *   function'll list available course branch 
    *   @params
    *   @author GBS-R
    *
    */
    
    function get_courses_centerlist($id = NULL) 
    {
		$this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
        $this->db->where('am_institute_master.status', 1);
        $this->db->where('am_institute_course_mapping.status', 1);
        $this->db->where('am_institute_course_mapping.course_master_id', $id);
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }
    
    function get_courses_centerlist_status($id = NULL) 
    {
		$this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
        $this->db->where('am_institute_master.status', 1);
        //$this->db->where('am_institute_course_mapping.status', 1);
        $this->db->where('am_institute_course_mapping.course_master_id', $id);
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }
    
        
    function get_branch_courselist_status($id = NULL) 
    {
        $this->db->distinct('am_institute_master.institute_master_id');
		$this->db->select('am_institute_master.*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
        $this->db->where('am_institute_master.status', 1);
        //$this->db->where('am_institute_course_mapping.status', 1);
        $this->db->where('am_institute_course_mapping.course_master_id', $id);
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }
    
     /*
    *   function'll list available course centers 
    *   @params
    *   @author GBS-R
    *
    */
    
    function get_centerby_branchcourse($branch_id = NULL, $course_id = NULL) 
    {
		$this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->db->where('am_institute_master.status', 1);
        $this->db->where('am_institute_master.institute_type_id', 3);
        $this->db->where('am_institute_course_mapping.status', 1);
        $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
        $this->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
		$query	=	$this->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }
    
	    
}
?>
