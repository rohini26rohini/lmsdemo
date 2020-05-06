<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Subject_model extends Direction_Model {
    
     public function __construct() 
     {
        parent::__construct();
     }
    
    // public function get_subject_type()
    // {
    //     $this->db->where('status', '1');
	// 	$query	=	$this->db->get('am_subject_type');
	// 	$resultArr	=	array();
	// 	if($query->num_rows() > 0){
	// 		$resultArr	=	$query->result_array();		
	// 	}
	// 	return $resultArr;
    // }
    
    public function subject_add($data)
    {	
        if($data['parent_subject'] == ""){
            $data['parent_subject'] = NULL;
        }
		$res=$this->db->insert('mm_subjects',$data);	
	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
    }
    public function get_allparent_subjects($type){
        $query = $this->db->where('subject_type_id',$type)
                            ->where('subject_status',1)
                            ->order_by('subject_name', 'ASC')
                            ->get('mm_subjects');
        $resultArr	=	array();
        if($query->num_rows()>0){
           $resultArr=$query->result_array(); 
        }
        return   $resultArr;
    }
    
    public function is_subject_exist($data)
    {
       $query= $this->db->get_where('mm_subjects',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    
    public function get_all_subjects()
    {
		$query	=	$this->db->select('*')
                     ->from('mm_subjects')
                     ->where('mm_subjects.subject_status', '1')
                    ->order_by('mm_subjects.subject_id','desc')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();	
            if(!empty($resultArr)) {
                foreach($resultArr as $key=>$result) {
                $resultArr[$key]['class_name'] = '';
                    $course = $this->common->get_from_tablerow('am_classes', array('class_id'=>$result['course_id']));
                    if(!empty($course)) { 
                       $resultArr[$key]['class_name'] =  $course['class_name'];
                    } else {
                        $psubject = $this->common->get_from_tablerow('mm_subjects', array('subject_id'=>$result['parent_subject']));
                        if(!empty($psubject)) { 
                            $mcourse = $this->common->get_from_tablerow('am_classes', array('class_id'=>$psubject['course_id']));
                    if(!empty($mcourse)) { 
                       $resultArr[$key]['class_name'] =  $mcourse['class_name'];
                        }
                    }
		}
            }
        }
        }
		
		return $resultArr;
 
    }
    public function get_subjectby_id($id)
    {
        $this->db->select('subject_name');
        $query= $this->db->get_where('mm_subjects',array('subject_id'=>$id));
        if($query->num_rows()>0)
        {
           return $query->row()->subject_name;
        }
        else
        {
            return false;
        }
    }
    // public function get_subjectdetails_by_id($id)
    // {
    //     $query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
    //                  ->from('am_institute_master')
    //                  ->where('am_institute_master.institute_master_id', $id)
    //                  ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
    //                  ->get();
    //     if($query->num_rows()>0)
    //     {
    //        return $query->row_array();
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    function get_subjectdetails_by_id($id)
    {
		$this->db->select('*');
		$this->db->where('subject_id',$id);
		$query	=	$this->db->get('mm_subjects');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }





    
    public function delete_subject($id)
    {
        $this->db->where('subject_id', $id);
        $query=$this->db->update('mm_subjects',array('subject_status'=>"2"));
        $return	=	true; 
        if(!$query){
			$return	=	false;
		}
		
		return $return;
    }
    
    public function subject_edit($data)
    {
        $id=$data['subject_master_id'];
        unset($data['subject_master_id']);
        $this->db->where('subject_id',$id);
		$query	= $this->db->update('mm_subjects',$data);
		
		
		$return	=	true;
		
		if(!$query){
			$return	=	false;
		}
		
		return  $return;
        
    }
    public function get_allgroups()
    {
        $this->db->select('*');
        $query= $this->db->get_where('mm_subjects',array('subject_status'=>'1','subject_type_id'=>'Model'));
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    public function get_allsub_byparent($where)
    {
        $this->db->select('*');
        $query= $this->db->get_where('mm_subjects',$where);
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function is_course_exist($data)
    {
         unset($data['subject_course_mapping_id']);
       $this->db->select('*');
        $query= $this->db->get_where('mm_subject_course_mapping',$data);
        
           return $query->num_rows();
        
       
    }
    public function subject_course_add_mapping($data)
    {
        if(!empty($data['subject_course_mapping_id']))
        {
            $edit_id=$data['subject_course_mapping_id'];  
            unset($data['subject_course_mapping_id']);
            $this->db->where('subject_course_mapping_id',$edit_id);
		    $res	= $this->db->update('mm_subject_course_mapping',$data);
        }
        else
        {
          $res=$this->db->insert('mm_subject_course_mapping',$data);  
        }
       
	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
        
        
       
    }
    
    public function getall_subject_course_mapping_list()
    {
       $query= $this->db->select('t1.*, t2.subject_name, t3.class_name')
         ->from('mm_subject_course_mapping as t1')
         ->where('t1.subject_status', '1')
         ->join('mm_subjects as t2', 't1.subject_id = t2.subject_id')
         ->join('mm_classes as t3', 't1.course_master_id = t3.class_id')
         ->get();
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function get_subjectcourse_mapping_byid($where)
    {
       $this->db->select('*');
        $query= $this->db->get_where('mm_subject_course_mapping',$where);
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
    //show only subjects with subject_type subject
    public function get_all_subjects_subjectype()
    {
        $query	=	$this->db->select('*')
                     ->from('mm_subjects')
                     ->where(array("mm_subjects.subject_status"=>"1","mm_subjects.subject_type_id"=>"Subject"))
                     ->order_by('mm_subjects.subject_id','desc')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    /*show all modules under parent subject in add mapping from subject table*/
    public function get_allmodules_by_subjectid($where)
    {
        $where['subject_status']=1;
        $query	=	$this->db->select('*')
                     ->from('mm_subjects')
                     ->where($where)
                     ->order_by('mm_subjects.subject_name')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    /*show only modules*/
     public function get_all_modules()
        {
            $query	=	$this->db->select('*')
                         ->from('mm_subjects')
                         ->where(array("mm_subjects.subject_status"=>"1","mm_subjects.subject_type_id"=>"Module"))
                         ->order_by('mm_subjects.subject_name')
                         ->get();

            $resultArr	=	array();

            if($query->num_rows() > 0){
                $resultArr	=	$query->result_array();
            }

            return $resultArr;
        }

    /* Show full modules */
    public function get_full_modules(){
        $query	=	$this->db->select('modules.*,subjects.subject_name as subjectName')
                    ->from('mm_subjects as modules')
                    ->join('mm_subjects as subjects','subjects.subject_id=modules.parent_subject')
                    ->where('modules.subject_type_id','Module')
                    ->order_by('modules.subject_name')
                    ->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();
        }
        return $resultArr;
    }
    
    //show full subjects
    public function get_full_subjects(){
        $query	=	$this->db->select('*')
                     ->from('mm_subjects')
                     ->where(array("mm_subjects.subject_type_id"=>"Subject","mm_subjects.subject_status"=>1))
                     ->order_by('mm_subjects.subject_name')
                     ->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    
    /*
*   function'll get  list of modules
*   @params course_id, parent subject master id
*   @author GBS-R
*
*/
    public function get_modules_by_subjectCourseid($courseid,$parentSubjectId)
    {
      
        $query	=	$this->db->select('mm_subject_course_mapping.subject_master_id,mm_subjects.subject_name,mm_subject_course_mapping.syllabus_file')
                     ->from('mm_subject_course_mapping')
                    ->where(array("mm_subject_course_mapping.course_master_id"=>$courseid,
                          "mm_subject_course_mapping.parent_subject_master_id"=>$parentSubjectId))
                    ->where('mm_subject_course_mapping.subject_status', '1')
                     ->join('mm_subjects','mm_subjects.subject_id=mm_subject_course_mapping.subject_master_id')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
   

}

?>
