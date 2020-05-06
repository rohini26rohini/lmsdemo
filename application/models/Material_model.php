<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Material_model extends Direction_Model {
    
public function __construct() {
    parent::__construct();
}
 
    
public function get_elearning_materials($subject_id = NULL, $type = NULL) {
    $this->db->select('*, mm_subject_course_mapping.subject_id as mastersubject_id');
    $this->db->from('mm_material');
    $this->db->join('mm_subject_course_mapping','mm_subject_course_mapping.subject_id = mm_material.subject_id','LEFT');
    $this->db->join('mm_subjects','mm_subjects.subject_id = mm_subject_course_mapping.subject_master_id','LEFT');
    $this->db->where('mm_material.subject_id', $subject_id);
    $this->db->where('mm_material.material_type', $type);
    $query	     =	$this->db->get();
    $resultArr	 =	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result_array();		
    }

    return $resultArr;
}

public function get_elearning_materials_id($material_id = NULL, $type = NULL) {
    $this->db->select('*');
    $this->db->from('mm_material');
    $this->db->join('mm_subject_course_mapping','mm_subject_course_mapping.subject_id = mm_material.subject_id','LEFT');
    $this->db->join('mm_subjects','mm_subjects.subject_id = mm_subject_course_mapping.subject_master_id','LEFT');
    $this->db->where('mm_material.material_id', $material_id);
    $this->db->where('mm_material.material_type', $type);
    $query	     =	$this->db->get();
    $resultArr	 =	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result_array();		
    }

    return $resultArr;
}
    
    
public function get_syllabus($syllabus_id = NULL, $type = NULL) {
    $this->db->select('*');
    $this->db->from('am_syllabus');
    $this->db->where('syllabus_id', $syllabus_id);
    $query	     =	$this->db->get();
    $resultArr	 =	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row_array();		
    }

    return $resultArr;
}

}