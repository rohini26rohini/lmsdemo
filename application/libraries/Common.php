<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common {

function __construct() {
    $this->gbs_obj = & get_instance();
}
    
// Function will get content using type
// @params type
// @author GBS-R

function get_content($type = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
	$this->_ci->db->where('content_type', $type);
	$query = $this->_ci->db->get('web_content');
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
}
    
// Function will get directors list
// @params type
// @author GBS-R

function get_director($position = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
	$this->_ci->db->where('position', $position);
	$query = $this->_ci->db->get('web_direction_ourteam');
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
}

function get_elearning_materials($school_id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where('school_id', $school_id);
    $this->_ci->db->where('status', '1');
    //$this->db->order_by('id', 'desc');
    $query	=	$this->_ci->db->get('web_general_studies');
    $resultArr	=	array();
    if($query->num_rows() > 0){
        $resultArr	=	$query->row_array();		
    }
    return $resultArr;
}

    
// Function will get directors list
// @params type
// @author GBS-R

function get_othermembers($position = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
	$this->_ci->db->where('position!=', $position);
	$query = $this->_ci->db->get('web_direction_ourteam');
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
} 
    
// Function will get subject by school
// @params school id
// @author GBS-R

function get_subject_by_school($id = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*, mm_subjects.subject_id as mastersubject_id');
    $this->_ci->db->from('mm_subjects');
    $this->_ci->db->join('mm_subject_course_mapping','mm_subject_course_mapping.subject_master_id = mm_subjects.subject_id');
	$this->_ci->db->join('am_classes','am_classes.class_id = mm_subject_course_mapping.course_master_id');
    //$this->_ci->db->join('mm_subjects','mm_subjects.subject_id = mm_subject_course_mapping.course_master_id');
	$this->_ci->db->where('am_classes.school_id', $id);
    $this->_ci->db->where('mm_subjects.subject_status', 1);
    $this->_ci->db->where('mm_subjects.subject_type_id', 'Subject');
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
} 
    
    
// Function will get Previous question by school
// @params school id
// @author GBS-R

function get_question_by_school($id = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $this->_ci->db->select('*, mm_subjects.subject_id as mastersubject_id');
    $this->_ci->db->from('mm_subjects');
    $this->_ci->db->join('mm_subject_course_mapping','mm_subject_course_mapping.subject_master_id = mm_subjects.subject_id');
	$this->_ci->db->join('am_classes','am_classes.class_id = mm_subject_course_mapping.course_master_id');
    //$this->_ci->db->join('mm_subjects','mm_subjects.subject_id = mm_subject_course_mapping.course_master_id');
	$this->_ci->db->where('am_classes.school_id', $id);
    $this->_ci->db->where('mm_subjects.subject_status', 1);
    $this->_ci->db->where('mm_subjects.subject_type_id', 'Previous Questions');
//	$this->_ci->db->select('*');
//    $this->_ci->db->from('mm_subject_course_mapping');
//	$this->_ci->db->join('am_classes','am_classes.class_id = mm_subject_course_mapping.course_master_id','LEFT');
//	$this->_ci->db->where('am_classes.school_id', $id);
//    $this->_ci->db->where('mm_subject_course_mapping.subject_type', 'Previous Questions');
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
} 
    
// Function will get modules by subjectid
// @params subject_id
// @author GBS-R

function get_modules($subject_master_id = NULL, $subject_id = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('mm_subjects');
    $this->_ci->db->join('mm_subject_course_mapping','mm_subject_course_mapping.subject_id = mm_subjects.subject_id');
	$this->_ci->db->where('mm_subjects.parent_subject', $subject_master_id);
    //$this->_ci->db->where('mm_subject_course_mapping1.subject_id', $subject_id);
	$query = $this->_ci->db->get('');
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
} 

    
// Function will get mode of batch
// @params 
// @author GBS-R

function get_modes() {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
	$query = $this->_ci->db->get('am_batch_mode');
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
} 
    
// Function will get syllabus by school
// @params school id
// @author GBS-R

function get_syllabus_by_school($id = NULL) {
    
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('am_syllabus');
	$this->_ci->db->join('am_classes','am_classes.syllabus_id = am_syllabus.syllabus_id','LEFT');
	$this->_ci->db->where('am_classes.school_id', $id);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return FALSE;
	}
}


	//-----------------------------------------------
	/**
	* @params 
	* @return all districts
	* @author Seethal 
	*/
	function get_districts() {
    
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
		$query = $this->_ci->db->get('city');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}
	//---------------------------------------------------
	/**
	* @params 
	* @return all countries
	* @author Seethal 
	*/
	public function get_all_countries() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get('countries');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
	//---------------------------------------------------

	/**
	* @params 
	* @return all roles
	* @author Seethal 
	*/
	public function get_roles() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get('am_roles');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}

	//-----------------------------------------------
	/**
	* @params 
	* @return all halltickets
	* @author Seethal 
	*/
	function get_halltickets() {
    
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where('status', 1);
		$query = $this->_ci->db->get('web_examlist');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}
	//---------------------------------------------------

    public function getSingle_roles($id = NULL) {
		$this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('am_staff_personal');
	$this->_ci->db->join('am_roles','am_roles.role = am_staff_personal.role');
	$this->_ci->db->where('am_staff_personal.personal_id', $id);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->row_array();
	} else {
		return FALSE;
	}
	}
    //---------------------------------------------------

	/**
	* @params 
	* @return all salary_schemes
	* @author Seethal 
	*/
	public function get_salary_scheme_drop_down() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get('salary_schemes');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
    //---------------------------------------------------

	/**
	* @params 
	* @return all leave_schemes
	* @author Seethal 
	*/
	public function get_leave_scheme_drop_down() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get('leave_schemes');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
    //---------------------------------------------------
	/**
	* @params 
	* @return all drivers
	* @author Seethal 
	*/
	public function get_drivers() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
		$this->_ci->db->where('status','1');
        $query = $this->_ci->db->get('am_staff_personal');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
    //---------------------------------------------------
  
	/**
	* @params 
	* @return all discounts
	* @author Seethal 
	*/
	public function get_discounts() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get('am_discount_master');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
	//---------------------------------------------------
	/**
	* @params 
	* @return all subjects
	* @author Seethal 
	*/
	public function get_all_subjects() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get('mm_subjects');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}

	/**
    * function'll will get subject type
	* @params
	* @return all subjects
	* @author GBS-R
	*/
	public function get_all_subject_type() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('subject_type_id','Subject');
        $this->_ci->db->where('subject_status','1');
        $query = $this->_ci->db->get('mm_subjects');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
	//---------------------------------------------------
    
    
// Function will get courses by school
// @params school id
// @author GBS-R

function get_coursesby_school($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('am_batch_center_mapping');
	$this->_ci->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
    $this->_ci->db->join('am_classes','am_classes.class_id = am_institute_course_mapping.course_master_id');
    $this->_ci->db->join('am_batch_mode','am_batch_mode.mode_id = am_batch_center_mapping.batch_mode');
    $this->_ci->db->where('am_classes.school_id', $id);
    $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return FALSE;
	}
}

	//------------------------------------------------------------
    /**
	* @params
	* @return all states under India
	* @author GBS-L
	*/
	public function get_all_states() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
         $this->_ci->db->where(array('country_id'=>'101'));
         $this->_ci->db->order_by('name', 'asc');
         $query = $this->_ci->db->get('states');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
	//------------------------------------------------------------
    /**
	* @params
	* @return all states under India
	* @author GBS-L
	*/
	public function get_states_byCountry($country_id) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
         $this->_ci->db->where(array('country_id'=>$country_id));
         $query = $this->_ci->db->get('states');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    


    function get_prepare($id){
		return $this->db->select('*')->where('school_id',$id)->get('web_prepare_content')->result();
	}
    //------------------------------------------------------------
    /**
	* @params state id
	* @return all districts under a state
	* @author GBS-L
	*/
	public function get_district_bystate($id) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('state_id',$id);
        $this->_ci->db->order_by('name');
        $query = $this->_ci->db->get('cities');
         $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();
            return $data_array;
        }
          return $data_array;

    }
    
    public function get_dist_bystate($id) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('state_id',$id);
        // $this->_ci->db->where('id',$dist_id);
        $this->_ci->db->order_by('name');
        $query = $this->_ci->db->get('cities');
         $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();
            return $data_array;
        }
          return $data_array;

    }
    
    public function get_all_others($personal_id)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->distinct();
        $this->_ci->db->select('*');
        $this->_ci->db->where('personal_id',$personal_id);
        $query = $this->_ci->db->get('am_staff_education');
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
        }
      return   $resultArr;
    }

    public function get_staff_docs($personal_id,$education_id)
    {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->where('personal_id',$personal_id);
        $this->_ci->db->where('education_id',$education_id);
        $query = $this->_ci->db->get('am_staff_documents');
        
        if($query){ return true;}
        else
        {
            return false;
        }


        // $query= $this->_ci->db->where('personal_id',$personal_id)->where('education_id',$education_id)->get('am_staff_documents')->row_array(); 

    }
    
    
    public function delete_fromwhere($table, $where, $data){
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->where($where);
        $query= $this->_ci->db->update($table, $data);
        if($query){ return true;}
        else
        {
            return false;
        }
    }
    public function delete($table, $where){
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->where($where);
        $query= $this->_ci->db->delete($table);
        if($query){ return true;}
        else
        {
            return false;
        }
    }
    
    
    /*
    *   Common update function
    *   @params table name, where, update data
    *   @author GBS-R
    */
     public function update($table, $where, $data){
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->where($where);
        $query= $this->_ci->db->update($table, $data);
        if($query){ return true;}
        else
        {
            return false;
        }
    }

    //------------------------------------------------------------
    /**
	* @params :student_id ,category of qualification
	* @return the qualification name and percentage of marks scored
	* @author GBS-L
	*/
    public function get_student_qualification_byid($id,$type)
    {
         $this->_ci->db->select('qualification,marks,qualification_id');
        $query= $this->_ci->db->get_where('am_student_qualification',array("student_id"=>$id,"category"=>$type));
        $resultArr	=	array();
        if($type == "other"){
            if($query->num_rows()>0)
            {
            $resultArr=$query->result_array();
            }
        }else{
            if($query->num_rows()>0)
            {
            $resultArr=$query->row_array();
            }
        }
      return   $resultArr;
    }

    public function get_student_exam_byid($student_id,$notification_id)
    {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $query= $this->_ci->db->get_where('web_examlist',array("student_id"=>$student_id,"notification_id"=>$notification_id));
        $resultArr	=	array();
            if($query->num_rows()>0)
            {
            $resultArr=$query->result_array();
            }
        
      return   $resultArr;
    }

    public function get_exam_byid($student_id)
    {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $query= $this->_ci->db->get_where('web_examlist',array("student_id"=>$student_id));
        $resultArr	=	array();
            if($query->num_rows()>0)
            {
            $resultArr=$query->result_array();
            }
        
      return   $resultArr;
    }

    public function get_all_student_others($student_id)
    {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array('student_id'=>$student_id));
        $query = $this->_ci->db->get('am_student_qualification');
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
        }
      return   $resultArr;
    }

    public function get_student_docs($student_id,$qualification_id)
    {
    $query= $this->_ci->db->where('student_id',$student_id)->where('qualification_id',$qualification_id)->get('am_student_documents')->row_array(); 
    }

    


// Function will get qualification by class and id
// @params class, id
// @author GBS-R

public function get_classx_qualify($id = NULL, $type = NULL) {
    // $this->_ci =& get_instance();
    // $this->_ci->load->database();
    // $this->_ci->db->select('*');
    // $this->_ci->db->where('personal_id',$id);
    // $this->_ci->db->where('category',$type);
    // $query = $this->_ci->db->get('am_staff_education');
    $this->_ci->db->select('*');
    $query= $this->_ci->db->get_where('am_staff_education',array("personal_id"=>$id,"category"=>$type));
    $data_array=array();
    if($type == "Others"){
        if($query->num_rows()>0)
        {
        $data_array=$query->result_array();
        }
    }else{
        if($query->num_rows()>0)
        {
        $data_array=$query->row_array();
        }
    }
  return   $data_array;
}

// Function will get experience by id
// @params id
// @author GBS-R


public function get_staffexperience($id = NULL, $type = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where('personal_id',$id);
    $query = $this->_ci->db->get('am_staff_experience');
     $data_array=array();
    if($query->num_rows()>0)
    {
       $data_array= $query->result_array();
        return $data_array;
    }
      return $data_array;
}


    /**
    * function'll will get faculty subject
	* @params faculty id
	* @return all subjects
	* @author GBS-R
	*/
	public function get_faculty_subject($id = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('staff_id', $id);
        $query = $this->_ci->db->get('am_faculty_subject_mapping');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}


    /**
    * function'll will get faculty subject
	* @params faculty id
	* @return all subjects
	* @author GBS-R
	*/
	public function get_subject_modules($id = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('subject_status', 1);
        $this->_ci->db->where('parent_subject', $id);
        $query = $this->_ci->db->get('mm_subjects');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
    
    /**
    * function'll will get table 
	* @params faculty table 
    * @return all subjects
	* @author GBS-R
	*/
	public function get_table_result($table = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $query = $this->_ci->db->get($table);
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return json_encode($result);
	}


    /**
    * function'll will get table row by using id
	* @params faculty table and where
    * @return all subjects
	* @author GBS-R
	*/
	public function get_from_table($table = NULL, $where = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get($table);
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        }

        return json_encode($result);
	}
    
    /**
    * function'll will get table row by using id
	* @params faculty table and where
    * @return all subjects
	* @author GBS-R
	*/
	public function get_from_tablerow($table = NULL, $where = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get($table);
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        }

        return $result;
    }
    
    /**
    * function'll will get table row by using id
	* @params faculty table and where
    * @return all subjects
	* @author GBS-R
	*/
	public function get_from_table_select_row($table = NULL, $where = NULL, $select = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select($select);
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get($table);
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            
        }

        return $result;
    }
    
    /**
    * function'll will get table row by using id
	* @params faculty table and where
    * @return all subjects
	* @author GBS-R
	*/
	public function get_from_tableresult($table = NULL, $where = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get($table);
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }
    function get_optionBy_ques_id($question_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('mm_question_option');
        $this->_ci->db->where('question_id', $question_id);
        $this->_ci->db->where('option_status', 1);
        $query	=	$this->_ci->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
    
    public function get_from_tablesingleselect($table = NULL, $where = NULL, $select = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select($select);
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get($table);
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->row()->$select;
        }

        return $result;
	}
// Function will get student discount
// @params school id
// @author GBS-R

function get_student_discount_details($student_id = NULL, $course_id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('pp_student_discount');
	$this->_ci->db->join('am_discount_packages','am_discount_packages.package_id = pp_student_discount.package_id');
    $this->_ci->db->join('am_discount_master','am_discount_master.package_master_id = am_discount_packages.package_master_id');
	$this->_ci->db->where('pp_student_discount.student_id', $student_id);
    $this->_ci->db->where('pp_student_discount.course_id', $course_id);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return FALSE;
	}
}

function get_student_discount_detailsstatusone($student_id = NULL, $course_id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('pp_student_discount');
	$this->_ci->db->join('am_discount_packages','am_discount_packages.package_id = pp_student_discount.package_id');
    $this->_ci->db->join('am_discount_master','am_discount_master.package_master_id = am_discount_packages.package_master_id');
	$this->_ci->db->where('pp_student_discount.student_id', $student_id);
    $this->_ci->db->where('pp_student_discount.course_id', $course_id);
    $this->_ci->db->where('pp_student_discount.discount_status', 1);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result();
	} else {
		return FALSE;
	}
}
    
    
    /*
    *   function'll get branches based on course
    *   @params course id
    *   @author GBS-R
    */
    
    public function get_branch_basedon_course($course_id,$selectedbranch) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $options = '';
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_institute_course_mapping');
        $this->_ci->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
        $this->_ci->db->where('am_institute_course_mapping.course_master_id', $course_id);
        $this->_ci->db->group_by('am_institute_course_mapping.branch_master_id');
        $query	=	$this->_ci->db->get();
        $resultArr	=	array();
        $select = '';
        if($query->num_rows() > 0)
        {
            $branches	=	$query->result();
            if(!empty($branches)) {
            $options .= '<option value="">Select Branch</option>';
            foreach($branches as $row){ 
                   if($row->branch_master_id==$selectedbranch) { $select = 'selected="selected"';}
                   $options .= '<option value="'.$row->branch_master_id.'" '.$select.'>'.$row->institute_name.'</option>';
           
            }
        }
        } else {
          $options .='<option value="">Select Branch</option>';  
        }
        
        return $options ;
    }
    
    
    /*
    *   function'll get center based on course and branch
    *   @params course id, branch id
    *   @author GBS-R
    */
    
    public function get_centerby_branch_course($course_id, $branch_id, $selectedcenter) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $options = '';
        $this->_ci->db->select('*');
    $this->_ci->db->from('am_institute_course_mapping');
    $this->_ci->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
    $this->_ci->db->where('am_institute_course_mapping.course_master_id', $course_id);
    $this->_ci->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
    $this->_ci->db->group_by('am_institute_course_mapping.institute_master_id');
    $query	=	$this->_ci->db->get();
    $resultArr	=	array();
    $select = '';
    if($query->num_rows() > 0)
    {
        $centers	=	$query->result();		
        if(!empty($centers)) {
            $options .= '<option value="">Select Center</option>';
            foreach($centers as $row){ 
                   if($row->institute_master_id==$selectedcenter) { $select = 'selected="selected"';}
                   $options .= '<option value="'.$row->institute_master_id.'" '.$select.'>'.$row->institute_name.'</option>';
           
            }
        }
        } else {
          $options .='<option value="">Select Center</option>';  
        }
        
        return $options ;
    }
    
    
    
    /*
    *   function'll list available course centers 
    *   @params
    *   @author GBS-R
    *
    */
    
    function get_centerby_branchcourse($branch_id = NULL, $course_id = NULL) 
    {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_institute_course_mapping');
        $this->_ci->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->_ci->db->where('am_institute_master.status', 1);
        //$this->_ci->db->where('am_institute_course_mapping.status', 1);
        if($course_id != NULL){
            $this->_ci->db->where('am_institute_course_mapping.course_master_id', $course_id);
        }
        if($branch_id != NULL){
            $this->_ci->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
        }
		$query	=	$this->_ci->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }
    
    function get_centerby_branchcourse_status($branch_id = NULL, $course_id = NULL) 
    {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_institute_course_mapping');
        $this->_ci->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->_ci->db->where('am_institute_master.status', 1);
        //$this->_ci->db->where('am_institute_course_mapping.status', 1);
        if($course_id != NULL){
            $this->_ci->db->where('am_institute_course_mapping.course_master_id', $course_id);
        }
        if($branch_id != NULL){
            $this->_ci->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
        }
		$query	=	$this->_ci->db->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
 
       }


    /*
    *   function'll get batch list by center course mapping table
    *   @params center course mapp id
    *   @author GBS-R
    */
    
    function get_batchby_coursecentermapp($coursemapp_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_center_mapping');
        $this->_ci->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
        $this->_ci->db->where('am_batch_center_mapping.institute_course_mapping_id', $coursemapp_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
     function get_batchby_coursecentermapp_status($coursemapp_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_center_mapping');
        $this->_ci->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        //$this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
        $this->_ci->db->where('am_batch_center_mapping.institute_course_mapping_id', $coursemapp_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }


    function get_batchby_coursecentermapp_id($coursemapp_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_center_mapping');
        $this->_ci->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
        $this->_ci->db->where('am_batch_center_mapping.institute_course_mapping_id', $coursemapp_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    /*
    *   function'll get paid status of student
    *   @params student_id, batch_id
    *   @author GBS-R
    */
    
    function get_paidstatus($student_id, $batch_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment');
        $this->_ci->db->where('status', 1);
        $this->_ci->db->where('student_id', $student_id);
        $this->_ci->db->where('institute_course_mapping_id', $batch_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }
    
    
    /*
    *   function'll get installment fee
    *   @params batch_id
    *   @author GBS-R
    */
    
    function get_batch_installment($institute_course_mapping_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_fee_installment');
        $this->_ci->db->where('institute_course_mapping_id', $institute_course_mapping_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }
    
    /*
    *   function'll get student early paid fee
    *   @params student id, batch_id
    *   @author GBS-R
    */
    
    function get_early_fee_bystudent($student_id, $batch_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment');
        $this->_ci->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = pp_student_payment.batch_id');
        $this->_ci->db->where('pp_student_payment.student_id', $student_id);
        $this->_ci->db->where('am_batch_center_mapping.batch_id!=', $batch_id);
        $this->_ci->db->where('pp_student_payment.status', 1);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }
    
    
    /*
    *   function'll get student paid fee
    *   @params student id, batch_id
    *   @author GBS-R
    */
    
    function get_paidinstallment($student_id, $batch_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment');
        $this->_ci->db->where('student_id', $student_id);
        $this->_ci->db->where('institute_course_mapping_id', $batch_id);
        $this->_ci->db->where('status', 1);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }
    
    
    /*
    *   function'll get student paid installment
    *   @params installment count, payment id
    *   @author GBS-R
    */
    
    function paidinstallment($installment, $payment_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment_installment');
        $this->_ci->db->where('payment_id', $payment_id);
        $this->_ci->db->where('installment', $installment);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }

    /*
    *   function'll get student paid installment
    *   @params installment count, payment id
    *   @author GBS-R
    */
    
    function receipt_paid_installment($paid_install_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*,pp_student_payment_installment.transaction_id as transaction_id,pp_student_payment_installment.card_type as card_type');
        $this->_ci->db->from('pp_student_payment_installment');
        $this->_ci->db->join('pp_student_payment', 'pp_student_payment.payment_id = pp_student_payment_installment.payment_id');
        $this->_ci->db->where('pp_student_payment_installment.paid_install_id', $paid_install_id);
        $this->_ci->db->where('pp_student_payment.status', 1);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }


    /*
    *   function'll get student paid installment
    *   @params installment count, payment id
    *   @author GBS-R
    */
    
    function receipt_paid_ontime($payment_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment');
        $this->_ci->db->where('payment_id', $payment_id);
        $this->_ci->db->where('status', 1);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }
    
    
    
    /*
    *   function'll get student paid installment
    *   @params installment count, payment id
    *   @author GBS-R
    */
    
    function paidinstallment_id($payment_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment_installment');
        $this->_ci->db->where('payment_id', $payment_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }
    
    
     /*
    *   function'll get student paid installment
    *   @params installment count, payment id
    *   @author GBS-R
    */
    
    function student_installment_payment_details($payment_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('pp_student_payment_installment');
        $this->_ci->db->where('payment_id', $payment_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }
    
    
    /*
    *   function'll get total number of student in a batch
    *   @paras batch id
    *   @author GBS-R
    */
    
    function get_total_student($batch_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_student_course_mapping');
        $this->_ci->db->where('status', 1);
        $this->_ci->db->where('batch_id', $batch_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	0;
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->num_rows();		
		}
		
		return $resultArr;
    }
    
    /*
    *   function'll get total number of student in a batch
    *   @paras batch id
    *   @author GBS-R
    */
    
    function get_batch_details($batch_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_center_mapping');
        $this->_ci->db->where('batch_id', $batch_id);
	    $query = $this->_ci->db->get();
		$resultArr = array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		return $resultArr;
    }
    
    function batch_class_details($batch_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_class_details');
        $this->_ci->db->where('batch_id', $batch_id);
        $this->_ci->db->order_by('class_sequence_number','ASC');
	    $query = $this->_ci->db->get();
		$resultArr = array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    
    
    /*
    *   function'll get staff details by id
    *   @params staff id
    *   @author GBS-R
    */
    
    function get_staff_details_by_id($personal_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('am_staff_personal.*,countries.name as countryname,am_users_backoffice.user_role as user_role,states.name as statename, states.name as statename, cities.name as cityname,am_roles.role_name');
        $this->_ci->db->from('am_staff_personal');
        $this->_ci->db->join('countries', 'countries.id = am_staff_personal.spouse_country');
        $this->_ci->db->join('am_roles', 'am_roles.role = am_staff_personal.role');

        $this->_ci->db->join('am_users_backoffice', 'am_users_backoffice.user_role = am_staff_personal.role');
        $this->_ci->db->join('states', 'states.id = am_staff_personal.spouse_state');
        $this->_ci->db->join('cities', 'cities.id = am_staff_personal.spouse_city');
        $this->_ci->db->where('am_staff_personal.personal_id', $personal_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();
            
            // Educational qualification
            $this->_ci->db->select('*');
            $this->_ci->db->from('am_staff_education');
            $this->_ci->db->where('personal_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['education'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['education']	=	$query->result_array();


            }
            
            // Experience
            $this->_ci->db->select('am_staff_experience.*,city.city_id,city.name');
            $this->_ci->db->from('am_staff_experience');
            $this->_ci->db->join('city', 'city.city_id = am_staff_experience.city');
            $this->_ci->db->where('personal_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['experience'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['experience']	=	$query->result_array();


            }


            // Documents
            $this->_ci->db->select('*');
            $this->_ci->db->from('am_staff_documents');
            $this->_ci->db->where('personal_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['documents'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['documents']	=	$query->result_array();


            }

            // Subjects
            $this->_ci->db->select('*');
            $this->_ci->db->from('am_faculty_subject_mapping');
            $this->_ci->db->where('staff_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['subjects'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['subjects']	=	$query->result_array();


            }
            
            // Experience
            $this->_ci->db->select('*');
            $this->_ci->db->from('am_staff_family');
            $this->_ci->db->where('personal_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['family'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['family']	=	$query->result_array();


            }
            
            // Language
            $this->_ci->db->select('*');
            $this->_ci->db->from('am_staff_language');
            $this->_ci->db->where('personal_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['language'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['language']	=	$query->result_array();


            }
            
            // Others details
            $this->_ci->db->select('*');
            $this->_ci->db->from('am_staff_others');
            $this->_ci->db->where('personal_id', $personal_id);
            $query	=	$this->_ci->db->get();
             $resultArr['others'] ='';
            if($query->num_rows() > 0)
            {
                $resultArr['others']	=	$query->result_array();


            }
            
		}
		
		return $resultArr;
    }
    
    
    /*
    *   function'll get conversion ratio by user    
    *   @params user id
    *   @author GBS-R
    */
    
    function get_conversionrate(/*$staff_id = NULL,*/ $date = NULL) { 
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // Total received calls
        $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->where('user_id', $staff_id);
        $query	=	$this->_ci->db->get();
         $totalcall_received = 0;
        if($query->num_rows() > 0)
        {
            $totalcall_received	=	$query->num_rows();
        }
        $resultArr['totalcall_received'] = $totalcall_received;
                                                                
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('cc_call_center_enquiries.user_id', $staff_id);
        $this->_ci->db->where('am_students.status', 1);
        $query	=	$this->_ci->db->get();
        $totalcall_converted = 0;
        if($query->num_rows() > 0)
        {
        $totalcall_converted	=	$query->num_rows();
        }
        $resultArr['totalcall_converted'] = $totalcall_converted;
        
        $today_received_call = 0;
        $sql = 'SELECT * FROM cc_call_center_enquiries where DATE(created_on) = DATE("'.$date.'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_call = $query->num_rows();
        }
        $resultArr['today_received_call'] = $today_received_call; 
        
        $today_converted_call = 0;
        $resultArr['totalcall_received'] = $totalcall_received;
        $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where  am_students.status=1 AND DATE(cc_call_center_enquiries.created_on) = DATE("'.$date.'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_converted_call = $query->num_rows();
        }
        $resultArr['today_converted_call'] = $today_converted_call; 
        
        
        return $resultArr;
    }
    
    
    /*
    *   function'll get total conversion ratio 
    *   @params user id
    *   @author GBS-R
    */
    
    function get_totalconversionrate($date) { 
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // Total received calls
        // $date="Y-m-d";
        $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->where('YEAR(created_on)', $date);
        $query	=	$this->_ci->db->get();
       
         $totalcall_received = 0;

        if($query->num_rows() > 0)
        {
            $totalcall_received	=	$query->num_rows();
        }
        $resultArr['totalcall_received'] = $totalcall_received;
                                                           
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        $this->_ci->db->where('am_students.status', 1);
        $query	=	$this->_ci->db->get();
        $totalcall_converted = 0;
        if($query->num_rows() > 0)
        {
        $totalcall_converted	=	$query->num_rows();
        }
        $resultArr['totalcall_converted'] = $totalcall_converted;
        
        $today_received_call = 0;
        $sql = 'SELECT * FROM cc_call_center_enquiries where DATE(created_on) = DATE("'.$date.'")';
//  echo $sql;
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_call = $query->num_rows();
        }
        $resultArr['today_received_call'] = $today_received_call; 
        // print_r($resultArr['today_received_call']);
        // echo $this->_ci->db->last_query();
        // die();  
        $today_converted_call = 0;
        $resultArr['totalcall_received'] = $totalcall_received;
        $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where am_students.status=1 AND DATE(am_students.admitted_date) = DATE("'.$date.'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_converted_call = $query->num_rows();
        }
        $resultArr['today_converted_call'] = $today_converted_call; 
        
       
        return $resultArr;
      
    }


    
    function get_totalconversionrate1($date) {
        $date1 = $date."-01-01";
        $date2 = $date."-12-31";
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // Total received calls
        // $date="Y-m-d";
        $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)>=', date('Y-m-d',strtotime($date1)));
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)<=', date('Y-m-d',strtotime($date2)));
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->where('YEAR(created_on)', $date);
        $query	=	$this->_ci->db->get();
       
         $totalcall_received = 0;

        if($query->num_rows() > 0)
        {
            $totalcall_received	=	$query->num_rows();
        }
        $resultArr['totalcall_received'] = $totalcall_received;
                                                           
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        $this->_ci->db->where('am_students.status', 1);
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)>=', date('Y-m-d',strtotime($date1)));
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)<=', date('Y-m-d',strtotime($date2)));
        $query	=	$this->_ci->db->get();
        $totalcall_converted = 0;
        if($query->num_rows() > 0)
        {
        $totalcall_converted	=	$query->num_rows();
        }
        $resultArr['totalcall_converted'] = $totalcall_converted;
        
        $today_received_call = 0;

        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)>=', date('Y-m-d',strtotime($date1)));
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)<=', date('Y-m-d',strtotime($date2)));
        $sql = 'SELECT * FROM cc_call_center_enquiries where DATE(created_on) = DATE("'.date("Y-m-d").'")';
//  echo $sql;
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        // echo $this->_ci->db->last_query(); exit;
        if(!empty($result)) {
            $today_received_call = $query->num_rows();
        }
        $resultArr['today_received_call'] = $today_received_call; 
        // print_r($resultArr['today_received_call']);
        // echo $this->_ci->db->last_query();
        // die();  
        $today_converted_call = 0;
        $resultArr['totalcall_received'] = $totalcall_received;
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)>=', date('Y-m-d',strtotime($date1)));
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)<=', date('Y-m-d',strtotime($date2)));
        $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where am_students.status=1 AND DATE(am_students.admitted_date) = DATE("'.date("Y-m-d").'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_converted_call = $query->num_rows();
        }
        $resultArr['today_converted_call'] = $today_converted_call; 
        
       
        return $resultArr;
      
    }
    
    
    
    /*
    *   function'll get total conversion ratio  CCE
    *   @params user id
    *   @author GBS-R
    */
    
    function get_totalconversionrate_cce($date, $user_id) { 
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // Total received calls
        // $date="DD/MM/YYYY";
        $resultArr = array();  
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->where('user_id', $user_id);
        $this->_ci->db->where('enquiry_type', 'Course related');
        $query	=	$this->_ci->db->get();
        //echo $this->_ci->db->last_query();
        //die();
         $totalcall_courserelated = 0;
        if($query->num_rows() > 0)
        {
            $totalcall_courserelated	=	$query->num_rows();
        }
        $resultArr['totalcall_courserelated'] = $totalcall_courserelated;
        
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->where('user_id', $user_id);
        $query	=	$this->_ci->db->get();
        // echo $this->_ci->db->last_query();
        // die();
         $totalcall_received = 0;
        if($query->num_rows() > 0)
        {
            $totalcall_received	=	$query->num_rows();
        }
        $resultArr['totalcall_received'] = $totalcall_received;
                                                                
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        $this->_ci->db->where('cc_call_center_enquiries.user_id', $user_id);
        $this->_ci->db->where('am_students.status', 1);
        $query	=	$this->_ci->db->get();
        $totalcall_converted = 0;
        if($query->num_rows() > 0)
        {
        $totalcall_converted	=	$query->num_rows();
        }
        $resultArr['totalcall_converted'] = $totalcall_converted;
        
        $today_received_call = 0;
        $sql = 'SELECT * FROM cc_call_center_enquiries where user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.$date.'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_call = $query->num_rows();
        }
        $resultArr['today_received_call'] = $today_received_call; 
        
        $today_received_courserelated = 0;
        $sql = 'SELECT * FROM cc_call_center_enquiries where enquiry_type="Course related" AND user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.$date.'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_courserelated = $query->num_rows();
        }
        $resultArr['today_received_courserelated'] = $today_received_courserelated; 
        
        $today_converted_call = 0;
        $resultArr['totalcall_received'] = $totalcall_received;
        $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where cc_call_center_enquiries.user_id="'.$user_id.'" AND am_students.status=1 AND DATE(cc_call_center_enquiries.created_on) = DATE("'.$date.'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_converted_call = $query->num_rows();
        }
        $resultArr['today_converted_call'] = $today_converted_call; 
        return $resultArr;
    }

    function get_totalconversionrate_cce1($date, $user_id) { 
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // Total received calls
        // $date="DD/MM/YYYY";
        $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->where('user_id', $user_id);
        $query	=	$this->_ci->db->get();
        // echo $this->_ci->db->last_query();
        // die();
         $totalcall_received = 0;
        if($query->num_rows() > 0)
        {
            $totalcall_received	=	$query->num_rows();
        }
        $resultArr['totalcall_received'] = $totalcall_received;
                                                                
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        $this->_ci->db->where('cc_call_center_enquiries.user_id', $user_id);
        $this->_ci->db->where('am_students.status', 1);
        $query	=	$this->_ci->db->get();
        $totalcall_converted = 0;
        if($query->num_rows() > 0)
        {
        $totalcall_converted	=	$query->num_rows();
        }
        $resultArr['totalcall_converted'] = $totalcall_converted;
        
        $today_received_call = 0;
        $sql = 'SELECT * FROM cc_call_center_enquiries where user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.date("Y-m-d").'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_call = $query->num_rows();
        }
        $resultArr['today_received_call'] = $today_received_call; 
        
        $today_converted_call = 0;
        $resultArr['totalcall_received'] = $totalcall_received;
        $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where cc_call_center_enquiries.user_id="'.$user_id.'" AND am_students.status=1 AND DATE(cc_call_center_enquiries.created_on) = DATE("'.date("Y-m-d").'")';
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_converted_call = $query->num_rows();
        }
        $resultArr['today_converted_call'] = $today_converted_call; 
        
        
        return $resultArr;
    }
    
    
    /*
    *   function'll get todays received call list
    *   @params date
    *   @author GBS-R
    *
    */
    
    public function get_todays_call($date = NULL, $user_id = NULL) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();  
        $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        if($user_id!='') {
            $this->_ci->db->where('user_id', $user_id);
            $this->_ci->db->where('DATE(created_on)', date("Y-m-d"));
            // $sql = 'SELECT * FROM cc_call_center_enquiries  where user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.date("Y-m-d").'")';
        } else {
            $this->_ci->db->where('DATE(created_on)', date("Y-m-d"));
            // $sql = 'SELECT * FROM cc_call_center_enquiries  where DATE(created_on) = DATE("'.date("Y-m-d").'")';
        }
        $query	=	$this->_ci->db->get();
        $resultArr = array();   
        // $query = $this->_ci->db->query($sql);
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();
            foreach($resultArr as $key=>$result) {
                    if($result->course_id!='') {
                        $course = $this->get_from_tablerow('am_classes', array('class_id'=>$result->course_id));
                        $resultArr[$key]->class_name = $course['class_name'];
                    } else {
                        $resultArr[$key]->class_name = '';
                    }

            }
        } 
    // echo '<pre>';
    // print_r($resultArr);       
     return $resultArr;
    }
    
     /*
    *   function'll get todays admitted list
    *   @params date
    *   @author GBS-R
    *
    */
    
    public function get_admitted_today($date = NULL, $status = NULL, $user_id = NULL) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();  
        if($user_id!='') {
            $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_classes ON am_classes.class_id = cc_call_center_enquiries.course_id JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id  where user_id="'.$user_id.'" AND cc_call_center_enquiries.call_status='.$status.' AND DATE(am_students.admitted_date) = "'.$date.'"';
        } else {
            $sql = 'SELECT * FROM cc_call_center_enquiries join am_classes on am_classes.class_id = cc_call_center_enquiries.course_id JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id   where cc_call_center_enquiries.call_status='.$status.' AND DATE(am_students.admitted_date) = "'.$date.'"';
        }
        $result = array();
        $query = $this->_ci->db->query($sql);
        if($query->num_rows()>0) {
            $result = $query->result(); 
        }return $result;
    }
    
    /*
    *   function'll get list of calls with inprogress status
    *   @params user_id
    *   @author GBS-R
    *
    */
    
    public function get_progresscall($status = NULL, $user_id = NULL) {
        // $date1 = $date."-01-01";
        // $date2 = $date."-12-31";
       $this->_ci =& get_instance();
       $this->_ci->load->database();    
       $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_classes', 'am_classes.class_id = cc_call_center_enquiries.course_id');
        if($user_id!='') {
        $this->_ci->db->where('user_id', $user_id);
        }
        $this->_ci->db->where('call_status', $status);
        $query	=	$this->_ci->db->get();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();
            foreach($resultArr as $key=>$result) {
                    if($result->course_id!='') {
                        $course = $this->get_from_tablerow('am_classes', array('class_id'=>$result->course_id));
                        // show($course);
                        if(!empty($course)){
                            $resultArr[$key]->class_name = $course['class_name'];
                        }
                    } else {
                        $resultArr[$key]->class_name = '';
                    }

            }
        } 
        return $resultArr;
    }

    public function get_progresscall1($status = NULL, $user_id = NULL,$date= NULL) {
        $date1 = $date."-01-01";
        $date2 = $date."-12-31";
        $this->_ci =& get_instance();
        $this->_ci->load->database();    
        $resultArr = array();                                                         
        $this->_ci->db->select('*');
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)>=', date('Y-m-d',strtotime($date1)));
        $this->_ci->db->where('DATE(cc_call_center_enquiries.created_on)<=', date('Y-m-d',strtotime($date2)));
        $this->_ci->db->from('cc_call_center_enquiries');
        //$this->_ci->db->join('am_classes', 'am_classes.class_id = cc_call_center_enquiries.course_id');
        if($user_id!='') {
        $this->_ci->db->where('user_id', $user_id);
        
        }
        $this->_ci->db->where('call_status', $status);
        
        $query	=	$this->_ci->db->get();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();
            foreach($resultArr as $key=>$result) {
                    if($result->course_id!='') {
                        $course = $this->get_from_tablerow('am_classes', array('class_id'=>$result->course_id));
                        $resultArr[$key]->class_name = $course['class_name'];
                    } else {
                        $resultArr[$key]->class_name = '';
                    }

            }
        } 
        return $resultArr;
    }
    
    
    
    /*
    *   function'll get staff list by role
    *   @params role
    *   @author GBS-R
    */
    
    function get_staff_list_by_roles($role = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('am_staff_personal.*,countries.name as countryname');
        $this->_ci->db->from('am_staff_personal');
        $this->_ci->db->join('countries', 'countries.id = am_staff_personal.spouse_country');
        $this->_ci->db->join('am_users_backoffice', 'am_users_backoffice.user_id = am_staff_personal.user_id');
        $this->_ci->db->where('am_staff_personal.status', 1);
        $this->_ci->db->where('am_users_backoffice.user_status', 1);
        $this->_ci->db->where_in('am_users_backoffice.user_role', $role);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
        }
        return $resultArr;
    }

    function get_leaveBystaff($staffId, $headId, $sdate = NULL, $eDate = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select_sum('num_days');
        $this->_ci->db->where('user_id', $staffId);
        $this->_ci->db->where('type_id', $headId);
        $this->_ci->db->where('leave_status', 1);
        if($sdate != NULL){
            $this->_ci->db->where('start_date>=', $sdate);
        }
        if($eDate != NULL){
            $this->_ci->db->where('end_date<=', $eDate);
        }
	    $query	=	$this->_ci->db->get('am_leave_request');
        if($query->row()->num_days == ''){
            return 0;
        }
        return $query->row()->num_days;
    }

    function get_leaveBystaff_total($staffId, $sdate = NULL, $eDate = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select_sum('num_days');
        $this->_ci->db->where('user_id', $staffId);
        $this->_ci->db->where('leave_status', 1);
        if($sdate != NULL){
            $this->_ci->db->where('start_date>=', $sdate);
        }
        if($eDate != NULL){
            $this->_ci->db->where('end_date<=', $eDate);
        }
	    $query	=	$this->_ci->db->get('am_leave_request');
        if($query->row()->num_days == ''){
            return 0;
        }
        return $query->row()->num_days;
    }
    
    
    /*
    *   Rest BASIC AUTHENTICATION API call
    *   @params api details
    *   @author GBS-R
    */
    function gm_user_registration($username = NULL, $password = NULL, $studentId = NULL) {
        // Authentication Api call
        $jsonData['method'] = "oauth/token?grant_type=password&username=gm_admin&password=password&client_id=grandmaster-client&client_secret=grandmaster-secret&scope=read+write+trust";
        $jsonData['type'] = "POST"; 
        $jsonData['data'] = array();
        $ajaxResponse = json_decode($this->rest_api_auth($jsonData)); 
        
        // User insert api cal  
        $data['id'] 		    = $studentId;
        $data['password'] 		= $password; 
        $data['userName'] 		= $username; 
        $data['role']['id'] 	= 2;   
        $jsonData['access_token'] = $ajaxResponse->access_token; 
        $jsonData['method']       = "createOrUpdateUser";
        $jsonData['type']         = "POST"; 
        $jsonData['data']         = json_encode($data); 
        $ajaxResponse = json_decode($this->rest_api_call($jsonData)); 
        return $ajaxResponse;
    }
    
    /*
    *   Rest BASIC AUTHENTICATION API call
    *   @params api details
    *   @author GBS-R
    */
    
    function rest_api_auth($api_Data) {
        $CI =& get_instance();
        $url = APIURI . $api_Data['method'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $api_Data['type']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_Data['data']); 
        $headers = array(
                        "Authorization: Basic Z3JhbmRtYXN0ZXItY2xpZW50OmdyYW5kbWFzdGVyLXNlY3JldA==",
                        "Content-Type: application/x-www-form-urlencoded",
                        "Postman-Token: 4ec77b98-c7b8-4bad-9d1a-023504fd0b58",
                        "cache-control: no-cache",
                        "client_id: grandmaster-client",
                        "client_secret: grandmaster-secret",
                        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
                      );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }

    /*
    *   Rest  API call
    *   @params api details
    *   @author GBS-R
    */
    function rest_api_call($api_Data) { 
        $CI =& get_instance();
        $url = APIURI . $api_Data['method'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $api_Data['type']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_Data['data']); 
        $headers = array(
                        "Authorization: Bearer ".$api_Data['access_token'],
                        "Content-Type: application/json",
                        "Postman-Token: 3b2aa9dd-2896-4905-9635-40b38fce5caf",
                        "cache-control: no-cache",
                        "value: Bearer ".$api_Data['access_token']
                      );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $message = date("Y-m-d H:i:s").','.$url.','.str_replace(',','///',json_encode($api_Data)).','.str_replace(',','///',json_encode(json_decode($response))).','.str_replace(',','///',json_encode($response));
        $log_file_path = FCPATH."uploads/_log_create_update_am_gm_student.csv";
        if(file_exists($log_file_path)){
            $fh = fopen($log_file_path, 'a');
            fwrite($fh, $message."\n");
        }else{
            $fh = fopen($log_file_path, 'w');
            fwrite($fh, 'Date and Time,API URL,API-request,API-response-json,API-response-json-less'."\n");
            $fh = fopen($log_file_path, 'a');
            fwrite($fh, $message."\n");
        }
        return $response;
    }
    
    /*
    *   function'll check student course changing or not
    *   @params student id, course id
    *   @author GBS-R
    *
    */
    
    function check_batch_allocation_duplicate($student_id, $course_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('student_id', $student_id);
        $this->_ci->db->where('status', 1);
        $this->_ci->db->where('course_id', $course_id);
        $query = $this->_ci->db->get('am_student_course_mapping');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result;
        } else {
            return FALSE;
        }
    }
    
   /* @params table,needed field, and where condition array
	* @return the name
	* @author GBS-L
	*/
	 function get_name_by_id($table,$field,$where)
    {
       $this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select($field);
        $this->_ci->db->where($where); 
        $query = $this->_ci->db->get($table);
         if ($query->num_rows() > 0) {
            $result = $query->row()->$field;
            return $result;
        } else {
            return FALSE;
        }
    }
    /* @params table,needed field, and where condition array
	* @return the name
	* @author GBS-L
	*/
	 function get_last_data($table,$field,$where,$orderbyfield,$orderby)
    {
       $this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select($field);
        $this->_ci->db->where($where); 
          $this->_ci->db->order_by($orderbyfield,$orderby);
        $query = $this->_ci->db->get($table);
         if ($query->num_rows() > 0) {
            $result = $query->row()->$field;
            return $result;
        } else {
            return FALSE;
        }
    }


    function get_student_schedule($table,$field,$where,$orderbyfield,$orderby)
    {
       $this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select($field);
        $this->_ci->db->where($where); 
          $this->_ci->db->order_by($orderbyfield,$orderby);
        $query = $this->_ci->db->get($table);
         if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    /* @params table where condition as array
	* @return the result array
	* @author GBS-L
	*/
	 function get_alldata($table,$where)
    {
         $this->_ci =& get_instance();
		 $this->_ci->load->database();
         $query=$this->_ci->db->get_where($table,$where);
         $result_array=array();
         if ($query->num_rows() > 0) 
         {
            $result_array = $query->result_array();
           
         } 
         return $result_array;
         
    }
    /* @params table where condition as array and orderby as array
	* @return the result array
	* @author GBS-L
	*/
	 function get_alldata_orderby($table,$where,$orderbyfield,$orderby)
    {
         $this->_ci =& get_instance();
		 $this->_ci->load->database();
         $this->_ci->db->order_by($orderbyfield,$orderby);
         $this->_ci->db->where($where);
         $query=$this->_ci->db->get($table);
         $result_array=array();
         if ($query->num_rows() > 0)
         {
            $result_array = $query->result_array();

         }
         return $result_array;

    }
    
    /*
    *   function'll create class code 
    *   @params post array
    *   @author GBS-R
    */
    
    public function createclass_code($data = NULL, $id = NULL) {
        $school = $this->get_from_table('am_schools',array('school_id'=>$_POST['school_id'])); 
        $mode   = $this->get_from_table('am_batch_mode',array('mode_id'=>$_POST['batch_mode_id']));
        $school = json_decode($school);
        $mode = json_decode($mode);
        $classcode = 'D'.$school->school_code.$mode->mode_code.date('mY').$id;
        return $classcode;
    }
    
    
    /*
    *   function'll list of subject and module in course 
    *   @params course id
    *   @author GBS-R
    *
    */
    
    function get_course_subject_details($course_id = NULL) 
    {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('mm_subject_course_mapping');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = mm_subject_course_mapping.subject_master_id');
        $this->_ci->db->where('mm_subjects.subject_status', 1);
        $this->_ci->db->where('mm_subjects.subject_type_id', 'Subject');
        $this->_ci->db->where('mm_subject_course_mapping.subject_status', 1);
        $this->_ci->db->where('mm_subject_course_mapping.course_master_id', $course_id);
        $this->_ci->db->where('mm_subject_course_mapping.subject_status', 1);
		$query	    =	$this->_ci->db->get();
		$subjects	=	array();
		if($query->num_rows() > 0){
			$subjects	=	$query->result();	
            foreach($subjects as $key=>$subject) {
                $this->_ci->db->select('*');
                $this->_ci->db->from('mm_subject_course_mapping');
                $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = mm_subject_course_mapping.subject_master_id');
                $this->_ci->db->where('mm_subjects.subject_status', 1);
                $this->_ci->db->where('mm_subjects.subject_type_id', 'Module');
                $this->_ci->db->where('mm_subject_course_mapping.subject_status', 1);
                 $this->_ci->db->where('mm_subject_course_mapping.course_master_id', $course_id);
                $this->_ci->db->where('mm_subject_course_mapping.parent_subject_master_id', $subject->subject_master_id);
                $this->_ci->db->where('mm_subject_course_mapping.subject_status', 1);
                $subquery	    =	$this->_ci->db->get();
                if($subquery->num_rows() > 0){
                   $subjects[$key]->modules	=	$subquery->result(); 
                } else {
                   $subjects[$key]->modules   =   array(); 
                }
            }
            
		}
		return $subjects;
    }
    
   function get_course_syllabus_details($course_id = NULL) 
    {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('am_syllabus_master_details.*, am_syllabus.*, am_classes.*, mm_subjects.*, a.subject_name as subjectname');
        $this->_ci->db->from('am_syllabus_master_details');
        $this->_ci->db->join('am_syllabus', 'am_syllabus.syllabus_id = am_syllabus_master_details.syllabus_master_id');
        $this->_ci->db->join('am_classes', 'am_classes.syllabus_id = am_syllabus.syllabus_id');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
       $this->_ci->db->join('mm_subjects as a', 'a.subject_id = am_syllabus_master_details.subject_master_id');
        $this->_ci->db->where('am_classes.class_id', $course_id);
		$query	    =	$this->_ci->db->get();
        if($query->num_rows() > 0){
			$subjects	=	$query->result();
            return $subjects;
        } else {
            return false;
        }
   }
    
    
       function get_module_syllabus_details($mapping_id = NULL) 
    {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        //$this->_ci->db->select('am_syllabus_master_details.*, am_syllabus.*, am_classes.*, mm_subjects.*, a.subject_name as subjectname');
        $this->_ci->db->select('am_syllabus_master_details.*, am_syllabus.*, mm_subjects.*, a.subject_name as subjectname');   
        $this->_ci->db->from('am_syllabus_master_details');
        $this->_ci->db->join('am_syllabus', 'am_syllabus.syllabus_id = am_syllabus_master_details.syllabus_master_id');
        //$this->_ci->db->join('am_classes', 'am_classes.syllabus_id = am_syllabus.syllabus_id');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
        $this->_ci->db->join('mm_subjects as a', 'a.subject_id = am_syllabus_master_details.subject_master_id');
        $this->_ci->db->where('am_syllabus_master_details.syllabus_master_detail_id', $mapping_id);
		$query	    =	$this->_ci->db->get();
        if($query->num_rows() > 0){
			$subjects	=	$query->row();
            return $subjects;
        } else {
            return false;
        }
   }
    
    
    
    
/*
*   function'll check delete posibility
*   @params table name, field, value
*   @author GBS-R
*/
    
public function check_for_delete($table = NULL, $field = NULL, $value = NULL, $status = NULL, $statusval = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where($field, $value);
    if($status != NULL &&  $statusval != NULL){
        $this->_ci->db->where($status, $statusval);
    }
    $query = $this->_ci->db->get($table);
    if ($query->num_rows() > 0) {
        return $query->num_rows();
    } else {
        return 0;
    }
}    

public function get_center_in_branch($branch_id){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('institute_master_id as id,institute_name as center_name');
    $this->_ci->db->where('institute_type_id',3);
    $this->_ci->db->where('status',1);
    $this->_ci->db->where('parent_institute',$branch_id);
    return $this->_ci->db->get('am_institute_master')->result_array();
}

public function get_courses_in_center($center_id){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    return $this->_ci->db->select('am_classes.class_id as id,am_classes.class_name as course_name')
                            ->from('am_institute_course_mapping')
                            ->join('am_classes','am_classes.class_id=am_institute_course_mapping.course_master_id')
                            ->where('am_institute_course_mapping.institute_master_id',$center_id)
                            ->where('am_classes.status',1)
                            ->where('am_institute_course_mapping.status',1)
                            ->get()->result_array();
}

public function get_batch_in_center_course($center_id,$course_id){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('am_batch_center_mapping.batch_id as id,am_batch_center_mapping.batch_name');
    $this->_ci->db->from('am_batch_center_mapping');
    $this->_ci->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
    $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
    $this->_ci->db->where('am_institute_course_mapping.institute_master_id', $center_id);
    $this->_ci->db->where('am_institute_course_mapping.course_master_id', $course_id);
    return $this->_ci->db->get()->result_array();
}

public function get_course_subjects($course_id){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    return $this->_ci->db->select('mm_subjects.subject_id as id,mm_subjects.subject_name')
                            ->from('am_classes')
                            ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_id=am_classes.syllabus_id')
                            ->join('mm_subjects','mm_subjects.subject_id=am_syllabus_master_details.subject_master_id')
                            ->where('am_classes.class_id',$course_id)
                            ->group_by('am_syllabus_master_details.subject_master_id')
                            ->get()->result_array();
}

public function get_course_subject_modules($course_id,$subject_id){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    return $this->_ci->db->select('am_syllabus_master_details.syllabus_master_detail_id as id,mm_subjects.subject_name')
                            ->from('am_classes')
                            ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_id=am_classes.syllabus_id')
                            ->join('mm_subjects','mm_subjects.subject_id=am_syllabus_master_details.module_master_id')
                            ->where('am_classes.class_id',$course_id)
                            ->where('am_syllabus_master_details.subject_master_id',$subject_id)
                            ->group_by('am_syllabus_master_details.module_master_id')
                            ->get()->result_array();
}


public function get_examsby_student($student_id = NULL){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    return $this->_ci->db->select('*')
                            ->from('assessment')
                            ->join('am_classes','am_classes.class_id=assessment.course_id')
                            ->where('assessment.emp_id',$student_id)
                            ->get()->result_array();
}




public function get_all_student_courses($student_id = NULL){
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
         $this->_ci->db->from('am_student_course_mapping');
         $this->_ci->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
         $this->_ci->db->where('student_id', $student_id);
         $this->_ci->db->where('am_student_course_mapping.status', 1);
         $this->_ci->db->order_by('created', 'desc');
         $query	=	$this->_ci->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
         return $resultArr;
}


function get_course_materials($course_id = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->from('mm_study_material');
    $this->_ci->db->join('mm_material', 'mm_material.material_id = mm_study_material.material_id');
    $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = mm_material.subject_id');
    $this->_ci->db->where_in('mm_subjects.parent_subject', $course_id);
    $this->_ci->db->where('mm_study_material.status', 1);
    $this->_ci->db->order_by('mm_study_material.id', 'asc');   
    $query	=	$this->_ci->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    // echo $this->db->last_query();
    return $resultArr;
}
   
    /*
*   function'll return the alloted number of beds in a room
*   @params room id
*   @author GBS-L
*/
    
    public function get_numof_alloted_beds($room_id)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array('room_id'=>$room_id,'delete_status'=>1));
        $where = '(status="checkin" or status = "alloted")';
        $this->_ci->db->where($where);
        $query= $this->_ci->db->get('hl_room_booking');
        return $query->num_rows();
    }
    
     /*
*   function'll check before delete and inactive building,floor,roomtype,rooms; that anything is active under     the current deleting element 
*   @params room id
*   @author GBS-L
*/
    public function hostel_checking($type,$id)
    {
       if($type=="building") 
       {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->where(array('building_id'=>$id,'floor_status'=>1));
            $query = $this->_ci->db->get("hl_hostel_floor");  
       }
        elseif($type=="floor")
        {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->where(array('floor_id'=>$id,'room_status'=>1));
            $query = $this->_ci->db->get("hl_hostel_rooms");  
        }
        elseif($type=="roomtype")
        {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->where(array('roomtype_id'=>$id,'room_status'=>1));
            $query = $this->_ci->db->get("hl_hostel_rooms");  
        }
        elseif($type=="room")
        {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->where(array('room_id'=>$id,'status!='=>'checkout'));
            $query = $this->_ci->db->get("hl_room_booking");    
        }
       
        if($query->num_rows()== 0)
        {
            
            return true;
        }
        else
        {
           return false;  
        }
           
        
    }
    /*
    *   function'll return the number of rows,if data exist
    *   @params table and where condition
    *   @author GBS-L
    */
     public function check_if_dataExist($table,$where)
     {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->where($where);
            $query = $this->_ci->db->get($table);
            return $query->num_rows();
             
     }
     public function check_Exist($table,$where1,$where2)
     {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->where($where1);
            $this->_ci->db->where($where2);
            $query = $this->_ci->db->get($table);
            return $query->num_rows();
             
     }
    

    //show parent subject by module id
    // @author GBS-L
    public function get_parentSubject($where)
    {
        $this->_ci =& get_instance();
            $this->_ci->load->database(); 
       $where['subject_status']=1;
       $query	=	$this->_ci->db->select('*')
                     ->from('mm_subjects')
                     ->where($where)
                     ->order_by('mm_subjects.subject_name')
                     ->get()->row()->parent_subject;
		if($query)
        {
            return $query;
        }
        else
        {
            return false;
        }
    }

    public function status_checking($status,$id)
    {
       if($status==0) 
       {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array('leave_id'=>$id,'leave_status'=>0));
        $query = $this->_ci->db->get("am_leave_request");  
       }else if($status==1){
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array('leave_id'=>$id,'leave_status'=>1));
        $query = $this->_ci->db->get("am_leave_request");  
       }
        if($query->num_rows()<= 0)
        {
            return true;
        }
        else
        {
           return false;  
        }
           
        
    }
    
    
    /*
    *   function'll get total conversion ratio  CCE
    *   @params user id
    *   @author GBS-R
    */
    
    function get_summary_cc($user_id = NULL, $sdate = NULL, $edate = NULL) { 
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // Total received calls
        // $date="DD/MM/YYYY";
        $resultArr = array();  
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->where('user_id', $user_id);
        if($sdate && $edate) {
           $this->_ci->db->where('DATE(created_on) >=', date('Y-m-d', strtotime($sdate)));
           $this->_ci->db->where('DATE(created_on) <=', date('Y-m-d', strtotime($edate)));
        }else
        if($sdate!='') {
            $this->_ci->db->where('DATE(created_on)', date('Y-m-d', strtotime($sdate)));
        }else
        if($edate!='') {
            $this->_ci->db->where('DATE(created_on)<=', date('Y-m-d', strtotime($edate)));
        }
        $this->_ci->db->where('enquiry_type', 'Course related');
        $query	=	$this->_ci->db->get();
        //echo $this->_ci->db->last_query();
        //die();
         $totalcall_courserelated = 0;
        if($query->num_rows() > 0)
        {
            $totalcall_courserelated	=	$query->num_rows();
        }
        $resultArr['totalcall_courserelated'] = $totalcall_courserelated;
        
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        if($sdate && $edate) {
           $this->_ci->db->where('DATE(created_on) >=', date('Y-m-d', strtotime($sdate)));
           $this->_ci->db->where('DATE(created_on) <=', date('Y-m-d', strtotime($edate)));
        }else
        if($sdate!='') {
            $this->_ci->db->where('DATE(created_on)', date('Y-m-d', strtotime($sdate)));
        }else
        if($edate!='') {
            $this->_ci->db->where('DATE(created_on)<=', date('Y-m-d', strtotime($edate)));
        }
        $this->_ci->db->where('user_id', $user_id);
        $query	=	$this->_ci->db->get();
        // echo $this->_ci->db->last_query();
        // die();
         $totalcall_received = 0;
        if($query->num_rows() > 0)
        {
            $totalcall_received	=	$query->num_rows();
        }
        $resultArr['totalcall_received'] = $totalcall_received;
                                                                
        $this->_ci->db->select('*');
        $this->_ci->db->from('cc_call_center_enquiries');
        $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        $this->_ci->db->where('cc_call_center_enquiries.user_id', $user_id);
        if($sdate && $edate) {
           $this->_ci->db->where('DATE(created_on) >=', date('Y-m-d', strtotime($sdate)));
           $this->_ci->db->where('DATE(created_on) <=', date('Y-m-d', strtotime($edate)));
        }else
        if($sdate!='') {
            $this->_ci->db->where('DATE(created_on)', date('Y-m-d', strtotime($sdate)));
        }else
        if($edate!='') {
            $this->_ci->db->where('DATE(created_on)<=', date('Y-m-d', strtotime($edate)));
        }
        $this->_ci->db->where('am_students.status', 1);
        $query	=	$this->_ci->db->get();
        $totalcall_converted = 0;
        if($query->num_rows() > 0)
        {
        $totalcall_converted	=	$query->num_rows();
        }
        $resultArr['totalcall_converted'] = $totalcall_converted;
        
        $today_received_call = 0;
        //$sql = 'SELECT * FROM cc_call_center_enquiries where user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.$date.'")';
        $sql = 'SELECT * FROM cc_call_center_enquiries where user_id="'.$user_id.'"';
        if($sdate && $edate) {
           $sql .= ' AND DATE(created_on) >='. date('Y-m-d', strtotime($sdate));
           $sql .= ' AND DATE(created_on) <='. date('Y-m-d', strtotime($edate));
        }else
        if($sdate!='') {
            $sql .= ' AND DATE(created_on) ='. date('Y-m-d', strtotime($sdate));
        }else
        if($edate!='') {
            $sql .= ' AND DATE(created_on)<='. date('Y-m-d', strtotime($edate));
        }
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_call = $query->num_rows();
        }
        $resultArr['today_received_call'] = $today_received_call; 
        
        $today_received_courserelated = 0;
        //$sql = 'SELECT * FROM cc_call_center_enquiries where enquiry_type="Course related" AND user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.$date.'")';
        $sql = 'SELECT * FROM cc_call_center_enquiries where enquiry_type="Course related" AND user_id="'.$user_id.'"';
        if($sdate && $edate) {
           $sql .= ' AND DATE(created_on) >='. date('Y-m-d', strtotime($sdate));
           $sql .= ' AND DATE(created_on) <='. date('Y-m-d', strtotime($edate));
        }else
        if($sdate!='') {
            $sql .= ' AND DATE(created_on) ='. date('Y-m-d', strtotime($sdate));
        }else
        if($edate!='') {
            $sql .= ' AND DATE(created_on)<='. date('Y-m-d', strtotime($edate));
        }
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_received_courserelated = $query->num_rows();
        }
        $resultArr['today_received_courserelated'] = $today_received_courserelated; 
        
        $received_inprogress = 0;
        //$sql = 'SELECT * FROM cc_call_center_enquiries where enquiry_type="Course related" AND user_id="'.$user_id.'" AND DATE(created_on) = DATE("'.$date.'")';
        $sql = 'SELECT * FROM cc_call_center_enquiries where call_status=2 AND user_id="'.$user_id.'"';
        if($sdate && $edate) {
           $sql .= ' AND DATE(created_on) >='. date('Y-m-d', strtotime($sdate));
           $sql .= ' AND DATE(created_on) <='. date('Y-m-d', strtotime($edate));
        }else
        if($sdate!='') {
            $sql .= ' AND DATE(created_on) ='. date('Y-m-d', strtotime($sdate));
        }else
        if($edate!='') {
            $sql .= ' AND DATE(created_on)<='. date('Y-m-d', strtotime($edate));
        }
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $received_inprogress = $query->num_rows();
        }
        $resultArr['received_inprogress'] = $received_inprogress; 
        
        $today_converted_call = 0;
        $resultArr['totalcall_received'] = $totalcall_received;
        //$sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where cc_call_center_enquiries.user_id="'.$user_id.'" AND am_students.status=1 AND DATE(cc_call_center_enquiries.created_on) = DATE("'.$date.'")';
        $sql = 'SELECT * FROM cc_call_center_enquiries JOIN am_students ON am_students.caller_id = cc_call_center_enquiries.call_id where cc_call_center_enquiries.user_id="'.$user_id.'" AND am_students.status=1';
        if($sdate && $edate) {
           $sql .= ' AND DATE(created_on) >='.date('Y-m-d', strtotime($sdate));
           $sql .= ' AND DATE(created_on) <='. date('Y-m-d', strtotime($edate));
        }else
        if($sdate!='') {
            $sql .= ' AND DATE(created_on) ='.date('Y-m-d', strtotime($sdate));
        }else
        if($edate!='') {
            $sql .= ' AND DATE(created_on)<='.date('Y-m-d', strtotime($edate));
        }
        $query = $this->_ci->db->query($sql);
        $result = $query->result_array(); 
        if(!empty($result)) {
            $today_converted_call = $query->num_rows();
        }
        $resultArr['today_converted_call'] = $today_converted_call; 
        
        
        return $resultArr;
    }

    function get_fare_by_student($student_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('tt_transport_stop.route_fare');
        $this->_ci->db->from('tt_transport_stop');
        $this->_ci->db->join('am_students', 'am_students.stop = tt_transport_stop.stop_id');
        $this->_ci->db->where_in('am_students.student_id', $student_id);
        $query	=	$this->_ci->db->get();
        if($query->num_rows() > 0){
            return $query->row()->route_fare;
        }else{
            return 0;
        }

    }



    // Function will get student hostel fee
    // @params student id
    // @author GBS-L
    public function get_hostelFee_byStudentId($id)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array("student_id"=>$id));
        $query = $this->_ci->db->get('hl_room_booking');


        if($query->num_rows() > 0)
        {
           $roomid= $query->row()->room_id;
           $this->_ci->db->select('*');
           $this->_ci->db->where(array("room_id"=>$roomid));
           $sql = $this->_ci->db->get('hl_hostel_rooms');


            if($sql->num_rows() > 0)
            {
                $roomtype_id= $sql->row()->roomtype_id;
                $this->_ci->db->select('*');
                $this->_ci->db->where(array("student_id"=>$id));
                $querys = $this->_ci->db->get('am_students');

                if($querys->num_rows() > 0)
                {
                  $food_habit= $querys->row()->food_habit;
                  $this->_ci->db->select('*');
                  $this->_ci->db->where(array("status"=>1,"room_type"=>$roomtype_id,"mess_type"=>$food_habit));
                  $query_sql = $this->_ci->db->get('hl_hostel_fees');

                    if($query_sql->num_rows() > 0)
                       { 
                         $fees= $query_sql->row()->fees;
                           return $fees;
                       }
                    else
                    {
                        return false;
                    }

                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    
    /*
    *   function'll get batches by center
    *   @params center id
    *   @author GBS-R
    */
    
    function get_batches_by_center($center_id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_batch_center_mapping');
        $this->_ci->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        if($center_id!='') {
        $this->_ci->db->where('am_institute_course_mapping.institute_master_id', $center_id);
        }
        $this->_ci->db->where('am_institute_course_mapping.status', 1);
        $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }  
    
    /*
    *   function'll get attendance screen by date
    *   @params batch id, today date
    *   @author GBS-R
    */
    
    function get_timetable($batch_id = NULL, $date = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_schedules');
//        $this->_ci->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_schedules.institute_course_mapping_id');
//        if($center_id!='') {
//        $this->_ci->db->where('am_institute_course_mapping.institute_master_id', $center_id);
//        }
        $this->_ci->db->where('am_schedules.schedule_link_id', $batch_id);
        $this->_ci->db->where('am_schedules.schedule_date', $date);
        $this->_ci->db->where('am_schedules.schedule_type', 2);
        $this->_ci->db->where('am_schedules.schedule_status', 1);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    } 
    
    
    /*
    *   function'll get student attenance
    *   @params batch id, today date
    *   @author GBS-R
    */ 
    
    function get_student_attendance($batch_id = NULL, $date = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_schedules');
        $this->_ci->db->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_detail_id = am_schedules.module_id');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
//        if($center_id!='') {
//        $this->_ci->db->where('am_institute_course_mapping.institute_master_id', $center_id);
//        }
        $this->_ci->db->where('am_schedules.schedule_link_id', $batch_id);
        if($date!='') {
        $this->_ci->db->where('am_schedules.schedule_date', $date);
        }
        $this->_ci->db->where('am_schedules.schedule_type', 2);
        $this->_ci->db->where('am_schedules.schedule_status', 1);
        if($date=='') {
        $this->_ci->db->group_by('am_schedules.schedule_date');
        }
        $this->_ci->db->order_by('am_schedules.schedule_date', 'asc');
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }      
    
    /*
    *   function'll get student attenance by schedule
    *   @params schedule id, student_id
    *   @author GBS-R
    */
    
    function getstudent_attendance($schedule_id = NULL, $student_id = NULL, $type = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_attendance');
        $this->_ci->db->where('schedule_id', $schedule_id);
        $this->_ci->db->where('student_id', $student_id);
        $this->_ci->db->where('type', $type);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }   
    
    
    /*
    *   function'll get batch upcomming five sections
    *   @params batch id, today date
    *   @author GBS-R
    */
    
    function get_upcomming_sections($batch_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_schedules');
        $this->_ci->db->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_detail_id = am_schedules.module_id');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
        $this->_ci->db->join('am_staff_personal', 'am_staff_personal.personal_id = am_schedules.staff_id');
        $this->_ci->db->where('am_schedules.schedule_link_id', $batch_id);
        $this->_ci->db->where('am_schedules.schedule_type', 2);
        $this->_ci->db->where('am_schedules.schedule_status', 1);
        $this->_ci->db->order_by('am_schedules.schedule_date', 'asc');
        $this->_ci->db->limit('5');
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }   

    function get_upcomming_learning_module($batch_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_schedules');
        $this->_ci->db->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_detail_id = am_schedules.module_id');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
        $this->_ci->db->join('am_staff_personal', 'am_staff_personal.personal_id = am_schedules.staff_id');
        $this->_ci->db->join('am_schedule_learning_module', 'am_schedule_learning_module.schedule_id = am_schedules.schedule_id');
        $this->_ci->db->where('am_schedules.schedule_link_id', $batch_id);
        $this->_ci->db->where('am_schedules.schedule_type', 2);
        $this->_ci->db->where('am_schedules.schedule_status', 1);
        $this->_ci->db->order_by('am_schedules.schedule_date', 'asc');
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }   


    
    /*
    *   function'll get module in a session
    *   @params module id
    *   @author GBS-R
    */
    
    function get_module($module_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_syllabus_master_details');
        $this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
        $this->_ci->db->where('am_syllabus_master_details.syllabus_master_detail_id', $module_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }      
    


    public function get_hostel_fee_InBooking($student_id,$roomtype_id)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array("student_id"=>$student_id));
        $querys = $this->_ci->db->get('am_students');
        if($querys->num_rows() > 0)
        {
          $food_habit= $querys->row()->food_habit;$this->_ci->db->select('*');
          $this->_ci->db->where(array("room_type"=>$roomtype_id,"mess_type"=>$food_habit,"status"=>"1"));
          $query_sql = $this->_ci->db->get('hl_hostel_fees');
          if($query_sql->num_rows() > 0){
                $fees = $query_sql->row()->fees;
                $hostel_fee_id = $query_sql->row()->hostel_fee_id;
                $data = [];
                if($fees){
                    $data['Monthly fees'] = $fees;
                }
                $hl_hostel_fees_details = $this->_ci->db->select('hl_hostel_fees_details.*,am_payment_heads.ph_head_name')
                                                        ->from('hl_hostel_fees_details')
                                                        ->join('am_payment_heads','am_payment_heads.ph_id=hl_hostel_fees_details.ph_id')
                                                        ->where('hl_hostel_fees_details.hostel_fee_id',$hostel_fee_id)
                                                        ->get()->result_array();
                if(!empty($hl_hostel_fees_details)){
                    foreach($hl_hostel_fees_details as $row){
                        $data[$row['ph_head_name']] = $row['amount'];
                    }
                }
                // show($data);
                return $data;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function get_transport_fee($student_id,$place,$stop)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where(array("student_id"=>$student_id));
        $querys = $this->_ci->db->get('am_students');
        if($querys->num_rows() > 0){
            $place= $querys->row()->place;
            $this->_ci->db->select('*');
            $this->_ci->db->where(array("stop_id"=>$stop,"transport_id"=>$place,"status"=>"1"));
            $query_sql = $this->_ci->db->get('tt_transport_stop');
            if($query_sql->num_rows() > 0){
                $route_fare= $query_sql->row()->route_fare;
                return $route_fare;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    public function get_document_details_by_id($user_id,$document_id)
    {
    return $this->_ci->db->where('personal_id',$user_id)->where('staff_documents_id',$document_id)->get('am_staff_documents')->row_array();

    }

    function get_topscore($attempt = NULL, $exam_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select_max('total_mark');
        $this->_ci->db->from('gm_exam_result_summary');
        $this->_ci->db->where('attempt', $attempt);
        $this->_ci->db->where('exam_id', $exam_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }  

    /*
    *   function'll get lowest mark in exam
    *   @params attempt, exam id
    *   @author GBS-R
    */

    function get_minscore($attempt = NULL, $exam_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select_min('total_mark');
        $this->_ci->db->from('gm_exam_result_summary');
        $this->_ci->db->where('attempt', $attempt);
        $this->_ci->db->where('exam_id', $exam_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }

    /*
    *   function'll get average mark in exam
    *   @params attempt, exam id
    *   @author GBS-R
    */

    function get_average($attempt = NULL, $exam_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_result_summary');
        $this->_ci->db->where('attempt', $attempt);
        $this->_ci->db->where('exam_id', $exam_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
        $returnArr = array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
            $count = $query->num_rows();
            $total = 0;
            foreach($resultArr as $result) {
               $total += $result->total_mark;
            }
            $average = $total/$count;
		    $returnArr = array('count'=>$count,
                          'average'=>$average);
		}
		return $returnArr;
    }

    /*
    *   function'll get student answered question in exams
    *   @params attempt, exam id, student id, question id
    *   @author GBS-R
    */

    function get_student_answer($attempt = NULL, $exam_id = NULL, $student_id = NULL, $question_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_result');
        $this->_ci->db->where('attempt', $attempt);
        $this->_ci->db->where('exam_id', $exam_id);
        $this->_ci->db->where('student_id', $student_id);
        $this->_ci->db->where('question_id', $question_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
	
	/*
    *   function'll get student answered question in exams
    *   @params exam id, question id
    *   @author GBS-R
    */

    function get_student_answer_review($exam_id = NULL, $question_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_time_avg');
        $this->_ci->db->where('exam_id', $exam_id);
        $this->_ci->db->where('question_id', $question_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }

    public function get_exam_details_by_scheduleid($id){
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->db = $this->_ci->db;
        $examDetails = $this->db->select('gm_exam_section_details.*,gm_exam_schedule.name as examname')
                                ->from('gm_exam_schedule')
                                ->join('gm_exam_definition_exam_sections','gm_exam_schedule.exam_definition_id=gm_exam_definition_exam_sections.exam_definition_id')
                                ->join('gm_exam_section_config_details','gm_exam_section_config_details.exam_section_config_id=gm_exam_definition_exam_sections.exam_sections_id')
                                ->join('gm_exam_section_details','gm_exam_section_details.id=gm_exam_section_config_details.details_id')
                                ->where('gm_exam_schedule.id',$id)
                                ->get()->result();
        $data=array(
            'examname'=>'',
            'totalquestions'=>0,
            'totalmarks'=>0
        );
        if(!empty($examDetails)){
            foreach($examDetails as $k=>$v){
                $data['examname'] = $v->examname;
                $data['totalquestions'] = $data['totalquestions']+$v->no_of_questions;
                $data['totalmarks'] = $data['totalmarks']+($v->no_of_questions*$v->mark_per_question);
            }
        }
        return $data;
    }

    public function get_notification_bystudent($notification_id) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
         $this->_ci->db->where(array('notification_id'=>$notification_id));
         $query = $this->_ci->db->get('web_notifications');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    public function get_holidays(){
		$this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->db = $this->_ci->db;
        $data = $this->db->get('am_holidays')->result();
        $holidays = array();
        if(!empty($data)){
            foreach($data as $row){
                array_push($holidays,$row->date);
            }
        }
        return $holidays;
    }
    
    
    /*
    *   function'll get seection name by section details id
    *   @params sesstion details id
    *   @author GBS-R
    */
    
    function get_section_nameby_details($module_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_section_config');
        $this->_ci->db->join('gm_exam_section_config_details', 'gm_exam_section_config_details.exam_section_config_id = gm_exam_section_config.id');
        $this->_ci->db->where('gm_exam_section_config_details.details_id', $module_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
    } 


    /*
    *   function'll get seection name by section details id
    *   @params sesstion details id
    *   @author GBS-R
    */
    
    function gm_exam_section_config_subject_id($module_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_section_config');
        //$this->_ci->db->join('gm_exam_section_config_details', 'gm_exam_section_config_details.exam_section_config_id = gm_exam_section_config.id');
        $this->_ci->db->where('gm_exam_section_config.id', $module_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
    } 
	
	
	    /*
    *   function'll get seection highest mark by section details id
    *   @params sesstion details id
    *   @author GBS-R
    */
    
    function gm_exam_section_highest($sectionid = NULL, $exam_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_section_high_mark');
		$this->_ci->db->where('gm_exam_section_high_mark.exam_id', $exam_id);
        $this->_ci->db->where('gm_exam_section_high_mark.sectionid', $sectionid);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
    } 
    
    
    
    /*
    *   function'll get seection ids by examid
    *   @params exam id
    *   @author GBS-R
    */
    
    function get_section_ids_byexam_id($id = NULL) {
        $sectionArr = array();
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_definition_exam_sections');
        $this->_ci->db->join('gm_exam_schedule', 'gm_exam_schedule.exam_definition_id = gm_exam_definition_exam_sections.exam_definition_id');
        $this->_ci->db->where('gm_exam_schedule.id', $id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result(); 
            foreach($resultArr as $row){
            array_push($sectionArr, $row->exam_sections_id);
            }
		}
		//echo '<pre>';print_r($sectionArr);
        if(!empty($sectionArr)) {
		return implode(',', $sectionArr);
        } else {
            return false;
        }
    }
    
    
    /*
    *   function'll get seection name by section details id
    *   @params sesstion details id
    *   @author GBS-R
    */
    
    function get_section_name($module_id = NULL) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_section_config');
        $this->_ci->db->join('gm_exam_section_config_details', 'gm_exam_section_config_details.details_id = gm_exam_section_config.id');
        $this->_ci->db->where('gm_exam_section_config_details.details_id', $module_id);
	    $query	=	$this->_ci->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
    } 
    
    /**
    * function'll will get exam summary details 
	* @params table name, where
    * @return student exam result
	* @author GBS-R
	*/
	public function get_avgmark_exam($where = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('AVG(gm_exam_result_summary.total_mark) as avg');
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get('gm_exam_result_summary');
        $result = '';
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }

        return $result->avg;
	}
    
    /**
    * function'll will get exam summary details 
	* @params table name, where
    * @return student exam result
	* @author GBS-R
	*/
	public function get_from_exam_summary($where = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('gm_exam_result_summary.*');
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get('gm_exam_result_summary');
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
	}
    
    /**
    * function'll will get student section sum mark
	* @params table name, where
    * @return student exam result
	* @author GBS-R
	*/
	public function get_student_section_sum($where = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('SUM(mark) as mark');
        $this->_ci->db->where($where);
        $query = $this->_ci->db->get('gm_exam_result');
        $result = '';
        if ($query->num_rows() > 0) {
            $result = $query->row(); 
            return $result->mark;
        } else {
            return false;
        }

        
	}
    
    function get_submenu_label($subMenuId){
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where('sub_menu_id',$subMenuId);
        $this->_ci->db->where('lang_id',$this->languageId);
        return $this->_ci->db->get('system_sub_menu_lang')->row_array();
    }

    function get_classes($school_id) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_classes');
        $this->_ci->db->where('am_classes.school_id', $school_id);
		$this->_ci->db->where('am_classes.status!=', 2);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    function get_notifications($school_id) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('web_notifications');
        $this->_ci->db->where('web_notifications.school_id', $school_id);
        $this->_ci->db->where('web_notifications.notification_status', 1);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function get_all_results($school_id) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('web_notifications');
        $this->_ci->db->where('web_notifications.school_id', $school_id);
        $this->_ci->db->where('web_notifications.notification_status', 1);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
        // $this->_ci =& get_instance();
        // $this->_ci->load->database();
        // $this->_ci->db->select('web_results.*,web_notifications.name as notification_name');
        // $this->_ci->db->from('web_results');
        // $this->_ci->db->join('web_notifications','web_notifications.notification_id = web_results.notification_id','LEFT');
        // $this->_ci->db->where('web_results.result_id', $result_id);
        // $query = $this->_ci->db->get();
        // if ($query->num_rows() > 0) {
        //     return $query->result();
        // } else {
        //     return FALSE;
        // }
    }

    function get_all_examresults($school_id) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('web_notifications');
        $this->_ci->db->where('web_notifications.school_id', $school_id);
        $this->_ci->db->where('web_notifications.notification_status', 1);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    function get_examresults() {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('web_notifications');
        // $this->_ci->db->where('web_notifications.school_id', $school_id);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    function get_detailed_batch($class,$id) {
        // $this->db->select('*');
        // $this->db->where('school_id', $id);
        // $this->db->where('notification_id', $notification);
        // $query	=	$this->db->get('web_notifications');
        // $resultArr	=	array();
        // if($query->num_rows() > 0){
        //      $resultArr	=	$query->result();		
        // }
        // return $resultArr;
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('am_batch_center_mapping');
	$this->_ci->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
    $this->_ci->db->join('am_classes','am_classes.class_id = am_institute_course_mapping.course_master_id');
    $this->_ci->db->join('am_batch_mode','am_batch_mode.mode_id = am_batch_center_mapping.batch_mode');
    $this->_ci->db->where('am_classes.school_id', $id);
    $this->_ci->db->where('am_classes.class_id', $class);
    $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);

	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
    }

    function get_our_program($id) {
        // $this->db->select('*');
        // $this->db->where('school_id', $id);
        // $this->db->where('notification_id', $notification);
        // $query	=	$this->db->get('web_notifications');
        // $resultArr	=	array();
        // if($query->num_rows() > 0){
        //      $resultArr	=	$query->result();		
        // }
        // return $resultArr;
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('am_batch_center_mapping');
	$this->_ci->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
    $this->_ci->db->join('am_classes','am_classes.class_id = am_institute_course_mapping.course_master_id');
    $this->_ci->db->join('am_batch_mode','am_batch_mode.mode_id = am_batch_center_mapping.batch_mode');
    $this->_ci->db->where('am_classes.school_id', $id);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
		return $query->result_array();
	} else {
		return FALSE;
	}
    }

    public function get_exams($exam_definition_id)
    {
    //     $this->_ci =& get_instance();
	// 	$this->_ci->load->database();
    //     $this->_ci->db->select('*');
    //     $this->_ci->db->where(array('id'=>$exam_definition_id));
    //     $query = $this->_ci->db->get('gm_exam_definition');
    //     $resultArr	=	array();
    //     if($query->num_rows()>0)
    //     {
    //        $resultArr=$query->row_array();
    //     }
    //   return   $resultArr;


      $this->_ci =& get_instance();
      $this->_ci->load->database();
      $this->_ci->db->select('*');
      $this->_ci->db->where(array('id'=>$exam_definition_id));
      $query = $this->_ci->db->get('gm_exam_definition');
      if ($query->num_rows() > 0) {
          $result = $query->result_array();
          return $result;
      } else {
          return FALSE;
      }



    }

        //---------------------------------------------------
  
	/**
	* @params 
	* @return all schools
	* @author Seethal 
	*/
	public function get_schools() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $query = $this->_ci->db->get('am_schools');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    /**
	* @params 
	* @return all exams
	* @author Seethal 
	*/
	public function get_all_exams() {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where('notification_status',1);
        $query = $this->_ci->db->get('web_notifications');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
	}
	//---------------------------------------------------

    
    /*
    *   get exam schedules
    *   @params batch_id, date
    *   @author GBS-R
    */
    
    function get_examtimetable($batch_id, $date = NULL) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_schedule');
        if($date!='') {
        //$this->_ci->db->where('DATE(start_date_time)', $date);
        $this->_ci->db->like('start_date_time', $date);
        }
        $this->_ci->db->where('batch_id', $batch_id);
        $this->_ci->db->where('status!=', 0);
        if($date=='') {
        $this->_ci->db->group_by('DATE(start_date_time)');
        }
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
     function get_examtimetablelike($batch_id, $date = NULL) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('gm_exam_schedule');
        if($date!='') {
        $this->_ci->db->like('start_date_time', $date);
        }
        $this->_ci->db->where('batch_id', $batch_id);
        $this->_ci->db->where('status!=', 0);
        if($date=='') {
        //$this->_ci->db->group_by('DATE(start_date_time)');
        }
        $query = $this->_ci->db->get(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    

    function total_friends($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Friends reference'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_magazine($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Magazine Advertising'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_newspaper($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Newspaper Advertising'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_outdoor($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Outdoor Advertising'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_radio($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Radio Advertising'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_tv($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Television Advertising'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_mail($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Direct Mail Advertising'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
    function total_website($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Direction website'); 
        $this->_ci->db->where('status', 1);

        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }

    function total_social($user_id = NULL)
    {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->from('cc_call_center_enquiries');
        // $this->_ci->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        // $this->_ci->db->where('am_students.status','1');
        // if($user_id!='') {
        //     $this->_ci->db->where('user_id', $user_id);
        // }
        $this->_ci->db->like('cc_call_center_enquiries.source','Social media'); 
        $this->_ci->db->where('status', 1);
        $query = $this->_ci->db->get();
        $rowcount = $query->num_rows();
        return  $rowcount;
    }
	
	
	/**
    * function'll will get individual fee heads of batch by course center map id
	* @params
	* @return all heads with fee
	* @author GBS-R
	*/
	public function get_feedsmapping($institute_course_mapping_id = NULL) {
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->db->select('*');
        $this->_ci->db->where('am_institute_course_mapping_id', $institute_course_mapping_id);
        $query = $this->_ci->db->get('vm_course_fee_headsvalues');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }
    


    /*
    *   Batch total strength and allocation
    *   @params batch_id
    */
    
    public function get_batch_allocation($batch_id = NULL) {
        $array = array('status'=>0);
        $array['center_id']          = $batch_id;
        $array['center_id']          = '';
        $array['batch_name']        = '';
        $array['batch_capacity']    = '';
        $array['batch_mode']        = '';
        $array['student_registered']= '';
        $array['center']= '';
        $array['branch']         = '';
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_student_course_mapping');
        $this->_ci->db->join('am_batch_center_mapping','am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->_ci->db->join('am_batch_mode','am_batch_mode.mode_id = am_batch_center_mapping.batch_mode');
        $this->_ci->db->where('am_student_course_mapping.batch_id', $batch_id);
        $this->_ci->db->where('am_student_course_mapping.status', 1);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array(); //print_r($result);
            $totalstudent   = count($result);
            $totalseats     = $result[0]['batch_capacity'];
            $percent        = $totalseats*90;
            $totalpercent   = $percent/100;
            if($totalstudent>$totalpercent && $totalstudent<$totalseats) { 
                $array['status']            = 90;
                $array['batch_id']          = $batch_id;
                $array['branch']         = $result[0]['branch_id'];
                $array['center_id']         = $result[0]['center_id'];
                $array['batch_name']        = $result[0]['batch_name'];
                $array['batch_capacity']    = $result[0]['batch_capacity'];
                $array['batch_mode']        = $result[0]['mode'];
                $array['student_registered']= $totalstudent;
                $array['center']            = $result[0]['center_id'];
                return $array;
            } else if($totalseats==$totalstudent){
                $array['status']            = 100;
                $array['batch_id']          = $batch_id;
                $array['branch']         = $result[0]['branch_id'];
                $array['center_id']         = $result[0]['center_id'];
                $array['batch_name']        = $result[0]['batch_name'];
                $array['batch_capacity']    = $result[0]['batch_capacity'];
                $array['batch_mode']        = $result[0]['mode'];
                $array['student_registered']= $totalstudent;
                $array['center']            = $result[0]['center_id'];
                return $array;
            }
        } else {
            return $array;
        }
    }
	
	/*
    *   QUERY BUILDER
    */
    
    public function querybuilder() {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        $options = '';
        $this->_ci->db->select('*');
        $this->_ci->db->from('am_institute_course_fee_definition');
        $this->_ci->db->join('am_payment_heads', 'am_payment_heads.ph_id = am_institute_course_fee_definition.fee_head_id');
        //$this->_ci->db->where('am_institute_course_mapping.course_master_id', $course_id);
        //$this->_ci->db->group_by('am_institute_course_mapping.branch_master_id');
        $query	=	$this->_ci->db->get();
		echo $this->_ci->db->last_query();
        $query = $this->_ci->db->get(); 
        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = array();;
        }
		echo '<pre>'; print_r($return);
    }
    public function notifycount($id) {
        $this->_ci =& get_instance();
		$this->_ci->load->database();
        // $id = $this->session->userdata['user_id'];
        $conversations = $this->_ci->db->where('from',$id)->or_where('to',$id)->get('conversations')->result_array();
        if(!empty($conversations)){
            foreach($conversations as $key=>$val)
            {
                $status = $this->_ci->db->where('conversation_id',$val['id'])->where('receiver',$id)->order_by('id','DESC')->get('messages')->row_array();
                if(!empty($status)){$conversations[$key]['status'] = $status['status'];}else{$conversations[$key]['status'] = 1;}
            }
        }
        // echo "<pre>"; print_r($conversations); exit;
        $f = 0;
        foreach($conversations as $conv){
            if($conv['status']==0 && $conv['archieved']==0){
                $f++;
            }
        }
        return $f;
    }
    public function get_class_session_byday($batch_id,$day){
        $class_array=$this->get_alldata_orderby('am_batch_class_details',array("batch_id"=>$batch_id,"week_day"=>$day),'class_sequence_number','ASC');
        if(!empty($class_array)){
            $html='<span>';
            foreach($class_array as $row){
                 $start_time =date('h:i A',strtotime($row['start_time'])); 
                 $end_time=date('h:i A',strtotime($row['end_time']));
                 $html.='<p style="font-size:10px;">'.$start_time.'<i style="display:block;text-align:center;font-style:normal;"> to </i>'.$end_time.'</p>'; 
            } 
            $html.='</span>';
        }
        else{
            $html='';
        }
        return $html;
    }
    // public function get_from_tableresult($table = NULL, $where = NULL) {
	// 	$this->_ci =& get_instance();
	// 	$this->_ci->load->database();
	// 	$this->_ci->db->select('*');
    //     $this->_ci->db->where($where);
    //     $query = $this->_ci->db->get($table);
    //     $result = array();
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result();
    //     }

    //     return $result;
    // }
    

public function invoice($payment_id = NULL, $installment = NULL, $invoiceAmount = NULL, $installwithoutgst = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select_max('inv_sequence');
    $query = $this->_ci->db->get('pp_invoice');
    if ($query->num_rows() > 0) {
        $result = $query->row(); 
        if($result->inv_sequence!='') {
            $last = $result->inv_sequence+1;
        } else {
            $last = 1;
        }
        $data['inv_sequence']               = $last;
        $data['inv_no']                     = 'INV'.$last;
        $data['payment_id']                 = $payment_id;
        $data['installment_id']             = $installment;
        $data['invoice_amount_without_gst'] = $installwithoutgst;
        $data['invoice_amount']             = $invoiceAmount;
        $this->_ci->db->insert('pp_invoice', $data); 
        return $this->_ci->db->insert_id();
    } else {
        return FALSE;
    }

}

function get_approvalUserByJobid($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('am_users_backoffice.user_name');
    $this->_ci->db->from('am_users_backoffice');
	$this->_ci->db->join('approval_flow_entity_details','approval_flow_entity_details.user_id = am_users_backoffice.user_id');
    $this->_ci->db->join('approval_flow_jobs','approval_flow_jobs.flow_detail_id = approval_flow_entity_details.id');
    // $this->_ci->db->join('am_batch_mode','am_batch_mode.mode_id = am_batch_center_mapping.batch_mode');
    $this->_ci->db->where('approval_flow_jobs.id', $id);
    // $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
        return $query->row()->user_name;
	} else {
		return FALSE;
	}
}
function get_classColor($color = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('class_name');
    $this->_ci->db->where('color', $color);
    $this->_ci->db->where('status', 1);
	$query = $this->_ci->db->get('am_classes');
	if ($query->num_rows() > 0) {
        $result = $query->result_array();
        $classes ='';
        foreach($result as $row){
            $classes .= $row['class_name'].', ';
        }
        return trim($classes, ', ');
	} else {
		return 'None';
	}
}

function count_from_table($table, $where) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where($where);
    $query = $this->_ci->db->get($table);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->num_rows();
    }
    return $result;
}


function get_qualifications() {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where('entity_type', 'Qualification');
    $this->_ci->db->where('entity_status', 1);
    $query = $this->_ci->db->get('am_basic_entity');
    if ($query->num_rows() > 0) {
        $result = $query->result();
        return $result;
    } else {
        return FALSE;
    }
}

function get_qualifications_type($type = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where('entity_level', $type);
    $this->_ci->db->where('entity_type', 'Qualification');
    $this->_ci->db->where('entity_status', 1);
    $query = $this->_ci->db->get('am_basic_entity');
    if ($query->num_rows() > 0) {
        $result = $query->result();
        return $result;
    } else {
        return FALSE;
    }
}


    function get_basic_entity($type = NULL) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->where('entity_type', $type);
        $this->_ci->db->where('entity_status', 1);
        $query = $this->_ci->db->get('am_basic_entity');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

function receipt_paid_trans($id, $pay_id, $inv_id) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->where('pay_id', $pay_id);
    $this->_ci->db->where('invoice_id', $inv_id);
    $query = $this->_ci->db->get('tt_payment_details'); //echo $this->_ci->db->last_query();
    if ($query->num_rows() > 0) {
        $result = $query->result();
        return $result;
    } else {
        return FALSE;
    }
}


function get($table = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $query = $this->_ci->db->get($table);
    if ($query->num_rows() > 0) {
        $result = $query->result();
        return $result;
    } else {
        return FALSE;
    }
}

function paid_students_trans($where = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select('*');
    $this->_ci->db->from('tt_payment_details');
	$this->_ci->db->join('am_payment_heads','am_payment_heads.ph_id = tt_payment_details.fee_id');
    $this->_ci->db->where($where);
    // $this->_ci->db->where('am_batch_center_mapping.batch_status', 1);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
        return $query->result();
	} else {
		return FALSE;
	}
}

function get_approvalCheckExists($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $query = $this->_ci->db->select('approval_flow_jobs.*,
                                approval_flow_jobs.assign_date,
                                approval_flow_jobs.updated_date,
                                am_learning_module.learning_module_name,
                                approval_flow_entity_details.user_id,
                                approval_flow_entity_details.level')
                            ->from('approval_flow_jobs')
                            ->join('am_learning_module','am_learning_module.id=approval_flow_jobs.entity_id')
                            ->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id')
                            ->where('approval_flow_entity_details.flow_entities',2)
                            ->where('approval_flow_jobs.entity_id',$id)
                            ->order_by('approval_flow_jobs.id','ASC')
                            ->get();
    return $query->num_rows();
}

function get_approvalCheckExistsEP($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $query = $this->_ci->db->select('approval_flow_jobs.*,
                                approval_flow_jobs.assign_date,
                                approval_flow_jobs.updated_date,
                                gm_exam_paper.exam_paper_name,
                                approval_flow_entity_details.user_id,
                                approval_flow_entity_details.level')
                            ->from('approval_flow_jobs')
                            ->join('gm_exam_paper','gm_exam_paper.id=approval_flow_jobs.entity_id')
                            ->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id')
                            ->where('approval_flow_entity_details.flow_entities',3)
                            ->where('approval_flow_jobs.entity_id',$id)
                            ->order_by('approval_flow_jobs.id','ASC')
                            ->get();
    return $query->num_rows();
}

function get_approvalCheckFlowCheck($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $query = $this->_ci->db->select('approval_flow_jobs.*,
                                        approval_flow_jobs.assign_date,
                                        approval_flow_jobs.updated_date,
                                        am_learning_module.learning_module_name,
                                        approval_flow_entity_details.user_id,
                                        approval_flow_entity_details.level')
                                    ->from('approval_flow_jobs')
                                    ->join('am_learning_module','am_learning_module.id=approval_flow_jobs.entity_id')
                                    ->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id')
                                    ->where('approval_flow_entity_details.flow_entities',2)
                                    ->where('approval_flow_jobs.entity_id',$id)
                                    ->order_by('approval_flow_jobs.id','ASC')
                                    ->get();
    return $query->num_rows();
}
function get_batchname_fromschedule_id($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $this->_ci->db->select('am_batch_center_mapping.batch_name')
                                    ->from('am_batch_center_mapping')
                                    ->join('gm_exam_schedule','gm_exam_schedule.batch_id=am_batch_center_mapping.batch_id')
                                    ->where('gm_exam_schedule.id',$id);
    $query = $this->_ci->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->batch_name;
    } else {
        return FALSE;
    }
}



function get_totalpaid_split($payment_id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
	$this->_ci->db->select_sum('split_amount');
    $this->_ci->db->from('pp_student_payment_split');
    $this->_ci->db->where('payment_id', $payment_id);
	$query = $this->_ci->db->get();
	if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->split_amount;
	} else {
		return FALSE;
	}
}


function get_module_fromschedule_idname_by_id($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $this->_ci->db->select('mm_subjects.subject_name')
                                    ->from('mm_subjects')
                                    ->join('am_syllabus_master_details','am_syllabus_master_details.module_master_id=mm_subjects.subject_id')
                                    ->where('am_syllabus_master_details.syllabus_master_detail_id',$id);
    $query = $this->_ci->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->subject_name;
    } else {
        return FALSE;
    }
}

function get_faculty($table = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $query = $this->_ci->db->get($table);
    if ($query->num_rows() > 0) {
        $result = $query->result();
        return $result;
    } else {
        return FALSE;
    }
}
function get_approvalAorR($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    return $this->_ci->db->select('approval_flow_jobs.status')
                                    ->from('approval_flow_jobs')
                                    ->join('am_learning_module','am_learning_module.id=approval_flow_jobs.entity_id')
                                    ->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id')
                                    ->where('approval_flow_entity_details.flow_entities',2)
                                    ->where('approval_flow_jobs.entity_id',$id)
                                    ->order_by('approval_flow_jobs.id','DESC')
                                    ->get()->row()->status;
    //  $query->num_rows();
}
function get_approvalCheckExistsEdit($id = NULL) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $query = $this->_ci->db->select('approval_flow_jobs.*,
                                approval_flow_jobs.assign_date,
                                approval_flow_jobs.updated_date,
                                am_learning_module.learning_module_name,
                                approval_flow_entity_details.user_id,
                                approval_flow_entity_details.level')
                            ->from('approval_flow_jobs')
                            ->join('am_learning_module','am_learning_module.id=approval_flow_jobs.entity_id')
                            ->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id')
                            ->where('approval_flow_entity_details.flow_entities',2)
                            ->where('approval_flow_jobs.entity_id',$id)
                            ->where('approval_flow_jobs.status !=',3)
                            ->order_by('approval_flow_jobs.id','ASC')
                            ->get();
    return $query->num_rows();
}

function get_centre() {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $this->_ci->db->select('am_institute_master.*')
                    ->from('am_institute_master')
                    ->where('am_institute_master.institute_type_id',3)
                    ->where('am_institute_master.status',1);
    $query = $this->_ci->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    } else {
        return FALSE;
    }
}

function get_persentail($examId) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $query = $this->_ci->db->select('heigh_mark')
                    ->from('gm_exam_summary')
                    ->where('exam_id',$examId)->get();
    if($query->num_rows() > 0){
        return $query->row()->heigh_mark;
    }else{
        return 0;
    }
}

function get_persentage($section) {
    $this->_ci =& get_instance();
	$this->_ci->load->database();
    $sum = 0;
    foreach($section as $sec){
        $don = $this->_ci->db->select('gm_exam_section_details.mark_per_question,gm_exam_section_details.no_of_questions')
                    ->from('gm_exam_section_details')
                    ->join('gm_exam_section_config_details', 'gm_exam_section_config_details.details_id = gm_exam_section_details.id')
                    ->where('gm_exam_section_config_details.exam_section_config_id',$sec['sectionId'])->get()->row();
        $sum += $don->mark_per_question * $don->no_of_questions;
    }
    return $sum;
}


function get_branch() {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->from('am_institute_master');
    $this->_ci->db->where('institute_type_id', 2);
    $this->_ci->db->where('status', 1);
    $query = $this->_ci->db->get();
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return FALSE;
    }
}


// LMS

function get_course_progress($student_id, $course_id) {
    $count = 0;
    $materialcount = 0;
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $batch_id = 0;
    $courseDet = $this->get_from_tablerow('am_student_course_mapping', array('student_id'=>$student_id,'course_id'=>$course_id, 'status'=>1));
    if(!empty($courseDet)) {
        $batch_id = $courseDet['batch_id'];
        $materialcount = $this->get_student_materia_count($student_id, $batch_id);
    }

    $this->_ci->db->select('*');
    $this->_ci->db->from('mm_subjects');
    $this->_ci->db->where('course_id', $course_id);
    $this->_ci->db->where('subject_status', 1);
    $query = $this->_ci->db->get();
    if ($query->num_rows() > 0) {
        $subjects = $query->result();
        foreach($subjects as $subject) {
        $this->_ci->db->select('*');
        $this->_ci->db->from('mm_subjects');
        $this->_ci->db->where('parent_subject', $subject->subject_id);
        $this->_ci->db->where('subject_status', 1);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
        $modules = $query->result();
        foreach($modules as $module) {
            $this->_ci->db->select('*');
            $this->_ci->db->from('mm_material');
            $this->_ci->db->where('subject_id', $module->subject_id);
            $this->_ci->db->where('material_status', 1);
            $this->_ci->db->where('material_type', 'study material');
            $query = $this->_ci->db->get();
            if ($query->num_rows() > 0) {
                $materials = $query->result();
                foreach($materials as $material) {
                $this->_ci->db->select('count(*) as count');
                $this->_ci->db->from('mm_study_material');
                $this->_ci->db->where('material_id', $material->material_id);
                $this->_ci->db->where('status', 1);
                $query = $this->_ci->db->get();
                if ($query->num_rows() > 0) {
                    $result = $query->row();
                    $count += $result->count;
                }
            }
        }
        }
    }
        }
        
    } 
    $percentage = 0;
    if($materialcount>0) {
        $cnt = $materialcount/$count;
        $percentage = $cnt*100;
    } 
    return floor($percentage);
    
}



function get_student_materia_count($student_id = NULL, $batch_id = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->from('mm_emp_material_view_status');
    $this->_ci->db->where('emp_id', $student_id);
    $this->_ci->db->where('training_id', $batch_id);
    $this->_ci->db->where('status', 1);
    $query = $this->_ci->db->get();
    return $query->num_rows();
}



function get_examsresult($id) {
$this->_ci =& get_instance();
$this->_ci->load->database();
$this->_ci->db->select('*');
$this->_ci->db->from('assessment');
$this->_ci->db->join('am_classes','am_classes.class_id = assessment.course_id');
$this->_ci->db->where('assessment.emp_id', $id);
$query = $this->_ci->db->get();
if ($query->num_rows() > 0) {
    return $query->result();
} else {
    return FALSE;
}
}



function get_latest_results($id = NULL, $assessment_id = NULL) {
    $this->_ci =& get_instance();
    $this->_ci->load->database();
    $this->_ci->db->select('*');
    $this->_ci->db->from('assessment_details');
    $this->_ci->db->where('assessment_details.emp_id', $id);
    $this->_ci->db->where('assessment_details.assessment_id', $assessment_id);
    $this->_ci->db->order_by('assessment_details.id', 'desc');
    //$this->_ci->db->limit(1);
    $query = $this->_ci->db->get();
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return FALSE;
    }
    }



    function get_latest_attemps($emp_id = NULL, $assessment_id = NULL, $attempt = NULL) {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->_ci->db->select('*');
        $this->_ci->db->from('orido_exam_answers');
        $this->_ci->db->where('orido_exam_answers.emp_id', $emp_id);
        $this->_ci->db->where('orido_exam_answers.assessment_id', $assessment_id);
        $this->_ci->db->where('orido_exam_answers.attempt', $attempt);
        $query = $this->_ci->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
        }

        function get_module_materials($material_id = NULL) {
            $this->_ci =& get_instance();
            $this->_ci->load->database();
            $this->_ci->db->select('*');
            $this->_ci->db->from('mm_study_material');
            $this->_ci->db->join('mm_material', 'mm_material.material_id = mm_study_material.material_id');
            //$this->_ci->db->join('mm_subjects', 'mm_subjects.subject_id = mm_material.subject_id');
            $this->_ci->db->where('mm_material.material_id', $material_id);
            $this->_ci->db->where('mm_study_material.status', 1);
            $this->_ci->db->order_by('mm_study_material.id', 'asc');   
            $query	=	$this->_ci->db->get();
            $resultArr	=	array();
            if($query->num_rows() > 0)
            {
                $resultArr	=	$query->result();		
            }
            // echo $this->db->last_query();
            return $resultArr;
        }
             

}
