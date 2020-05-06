<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }
    
    //get all request
    
    public function get_staff_by_badgenumber($badgenumber = NULL){
        $this->db->select('personal_id');
        $query=$this->db->get_where('am_staff_personal', array('biometric_id'=>$badgenumber));
        if($query->num_rows()>0)
        {
           $resultArr=$query->row_array(); 
           return $resultArr['personal_id'];
        }else{
            return false;
        }
    }

    // WITHOUT designation id

    // public function get_user_details($trainingId= NULL){
    // $this->db->select('am_student_course_mapping.student_id as userList');
    // $this->db->from('am_student_course_mapping'); 
    // if($trainingId!=""){
    //     $this->db->where('am_student_course_mapping.batch_id',$trainingId);
    // }
    // $this->db->where('am_student_course_mapping.status',1);
    // $this->db->order_by('am_student_course_mapping.student_course_id','desc');
    // $query	=	$this->db->get();
    // $resultArr	=	array();
    // if($query->num_rows() > 0){
    //     $resultArr	=	$query->result_array();		
    // }
    // return $resultArr;

    // }

    // WITH designation id

    public function get_user_details($trainingId= NULL){
        $this->db->select('am_student_course_mapping.student_id as userList, am_students.contact_number as designation_id');
        $this->db->from('am_student_course_mapping'); 
        $this->db->join('am_students', 'am_students.student_id=am_student_course_mapping.student_id'); 
        if($trainingId!=""){
            $this->db->where('am_student_course_mapping.batch_id',$trainingId);
        }
        $this->db->where('am_student_course_mapping.status',1);
        $this->db->order_by('am_student_course_mapping.student_course_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
        }
    


    public function get_training_details($trainingId= NULL){       
        $this->db->select('am_batch_center_mapping.batch_id as training_id,
        am_batch_center_mapping.batch_name as training_name,am_batch_center_mapping.batch_capacity as areaId,am_batch_center_mapping.publish_date as publish_date,
        am_batch_center_mapping.way_of_notify as way_of_notify,am_batch_center_mapping.is_communication as is_communication_training,
        am_classes.class_id as course_id,am_classes.class_name as course_name, am_course_mapping.*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id'); 
        $this->db->join('am_course_mapping', 'am_course_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_classes.class_id=am_institute_course_mapping.course_master_id'); 
         if($trainingId!=""){
        $this->db->where('am_batch_center_mapping.batch_id',$trainingId);
         }
        $this->db->where('am_classes.status',1);
        $this->db->order_by('am_batch_center_mapping.batch_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }

    public function get_training_list_count($keyword = NULL, $is_communication = NULL) {
        $this->db->select('*');
        $this->db->from('am_classes');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
        $this->db->join('am_course_mapping', 'am_course_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
        //$this->db->where('am_institute_course_mapping.institute_master_id', $id);
        $this->db->where('am_classes.status', 1);
        if($keyword !='') {
            $this->db->like('am_classes.class_name', $keyword); 
            $this->db->or_like('am_batch_center_mapping.batch_name', $keyword); 
        }
        if($is_communication==1) {
            $this->db->where('am_batch_center_mapping.is_communication', $is_communication);  
        } else if($is_communication==0) {
            $this->db->where('am_batch_center_mapping.is_communication', $is_communication);  
        }
	    $query	=	$this->db->get();
		$resultArr	=	0;
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->num_rows();		
		}
		return $resultArr;
    }

    public function get_training_list($page = NULL, $size = NULL, $sort = NULL, $order = NULL, $keyword = NULL, $is_communication = NULL) {
        $limit = $size; 
        $start = 0;
        if($page>1) {
        $limit = $size * $page; 
        $start = $size * ($page-1);
        }
        if($limit<=0) {
            $limit = 20;
        } 
        $this->db->select('*');
        $this->db->from('am_classes');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
        $this->db->join('am_course_mapping', 'am_course_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
        //$this->db->where('am_institute_course_mapping.institute_master_id', $id);
        $this->db->where('am_classes.status', 1);
        if($keyword !='') {
            $this->db->like('am_classes.class_name', $keyword); 
            $this->db->or_like('am_batch_center_mapping.batch_name', $keyword); 
        }
        if($is_communication==1) {
            $this->db->where('am_batch_center_mapping.is_communication', $is_communication);  
        } else if($is_communication==0) {
            $this->db->where('am_batch_center_mapping.is_communication', $is_communication);  
        }
        if($sort!='' && $order != '') {
        $this->db->order_by('am_classes.'.$sort, $order);
        }
        $this->db->limit($limit, $start);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		return $resultArr;
    }
    function get_student_trainings($userId = NULL, $is_communication = NULL){
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_students', 'am_students.student_id = am_student_course_mapping.student_id');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_student_course_mapping.institute_course_mapping_id');
        $this->db->join('am_course_mapping', 'am_course_mapping.institute_course_mapping_id = am_student_course_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->where('am_classes.status', 1);
        $this->db->where('am_batch_center_mapping.batch_status', 1);
        $this->db->where('am_student_course_mapping.student_id', $userId);
        if($is_communication==1) {
            $this->db->where('am_classes.is_communication', 1);
        } else {
            $this->db->where('am_classes.is_communication', NULL);
        }
        $query	=	$this->db->get(); //echo $this->db->last_query();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
        }
        return $resultArr;
}
public function get_active_courses($emp_id = NULL, $courseStatus = NULL, $is_communication = NULL) {
    $this->db->select('am_classes.*,am_institute_course_mapping.*, am_classes.status as course_status');
    $this->db->from('am_classes');
    $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
    //$this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
   if($courseStatus!='') {
        $this->db->where('am_classes.status', $courseStatus);
    }
    if($is_communication==1) {
        $this->db->where('am_classes.is_communication', $is_communication);    
    } else {
        $this->db->where('am_classes.is_communication', NULL);  
    }
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}
public function get_active_courses_emp_id($emp_id = NULL, $courseStatus = NULL, $is_communication = NULL) {
    $this->db->select('am_classes.*,am_institute_course_mapping.*, am_classes.status as course_status');
    $this->db->from('am_classes');
    $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
    $this->db->join('am_student_course_mapping', 'am_student_course_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
    if($courseStatus!='') {
    $this->db->where('am_classes.status', $courseStatus);
    }
    if($is_communication==1) {
        $this->db->where('am_classes.is_communication', $is_communication);    
    } else {
        $this->db->where('am_classes.is_communication', NULL);  
    }
    $this->db->where('am_student_course_mapping.student_id', $emp_id);
    $this->db->where('am_student_course_mapping.status', 1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}
public function get_emp_materials($emp_id = NULL, $training_id = NULL) {
    $this->db->select('*');
    $this->db->from('am_classes');
    $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
    $this->db->join('am_student_course_mapping', 'am_student_course_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
    $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
    $this->db->where('am_student_course_mapping.student_id', $emp_id);
    $this->db->where('am_student_course_mapping.batch_id', $training_id);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}
public function get_training_material($course_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_study_material');
    $this->db->where('module_id', $course_id);
    $this->db->where('status', 1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}

    public function insert_assessment($data)
    {
        $query	= $this->db->insert('assessment',$data);	
		$return	=   $this->db->insert_id();
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    public function insert_startassessment($data)
    {
        $query	= $this->db->insert('orido_exam_log',$data);	
		$return	=   $this->db->insert_id();
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    public function insert_assessment_details($data)
    {
        $query	= $this->db->insert('assessment_details',$data);	
		$return	=   true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    public function insert_finishassessemnt($data)
    {
        $query	= $this->db->insert('orido_exam_answers',$data);	
		$return	=   true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    public function update_assessment($emp_id,$assessment_id)
    {
        $data = array(
            'emp_id'                     => $emp_id,
            'assessment_id'              => $assessment_id
          );
          $this->db->where($data);
          return $this->db->update('assessment',array('status'=>0));
    }

    public function update_startassessment($data)
    {
        
          $this->db->where($data);
          return $this->db->update('orido_exam_log');
    }

    public function get_attemptcount($emp_id,$assessment_id){
        $this->db->select('assessment_details.attempt');
        $this->db->from('assessment_details'); 
        $this->db->where('assessment_details.emp_id',$emp_id);
        $this->db->where('assessment_details.assessment_id',$assessment_id);
        $this->db->order_by('assessment_details.id','desc');
        $this->db->limit(1);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->row()->attempt;		
        }
        return $resultArr;
       
}
public function get_attemptcount_startass($emp_id,$assessment_id){
    $this->db->select('orido_exam_log.attempt');
    $this->db->from('orido_exam_log'); 
    $this->db->where('orido_exam_log.emp_id',$emp_id);
    $this->db->where('orido_exam_log.assessment_id',$assessment_id);
    $this->db->order_by('orido_exam_log.id','desc');
    $this->db->limit(1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0){
        $resultArr	=	$query->row()->attempt;		
    }
    return $resultArr;
   
}

public function insert_training_status($data) {
    $rows = $this->db->insert('traning_status', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}


public function insert_material_status($data) {
    $rows = $this->db->insert('mm_emp_material_view_status', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}

public function update_material_status($data, $emp_id = NULL, $material_id = NULL, $training_id = NULL) {
    $this->db->where('emp_id', $emp_id);
    $this->db->where('material_id', $material_id);
    $this->db->where('training_id', $training_id);
    $rows = $this->db->update('mm_emp_material_view_status', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}

public function check_material_status($emp_id = NULL, $material_id = NULL, $training_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_emp_material_view_status');
    $this->db->where('emp_id', $emp_id);
    $this->db->where('material_id', $material_id);
    $this->db->where('training_id', $training_id);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}

public function check_material_emp_status($emp_id = NULL, $training_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_emp_material_view_status');
    $this->db->where('emp_id', $emp_id);
    $this->db->where('training_id', $training_id);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}


public function get_student_course_by_trainid($traning_id = NULL) {
    $this->db->select('*');
    $this->db->from('am_student_course_mapping');
    $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id = am_student_course_mapping.institute_course_mapping_id');
    $this->db->where('am_batch_center_mapping.batch_id', $traning_id);
    $this->db->where('am_batch_center_mapping.batch_status', 1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}


public function update_training_status($training_id = NULL, $emp_id = NULL, $data) {
    $this->db->where('emp_id', $emp_id);
    $this->db->where('training_id', $training_id);
    $rows = $this->db->update('traning_status', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}

public function get_training_status($training_id = NULL, $emp_id = NULL) {
    $this->db->where('emp_id', $emp_id);
    $this->db->where('training_id', $training_id);
    $this->db->where('status', 1);
    $query	=	$this->db->get('traning_status');
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    if(!empty($resultArr)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

public function get_assessment_status($assessment_id = NULL, $emp_id = NULL) {
    $this->db->where('emp_id', $emp_id);
    $this->db->where('id', $assessment_id);
    $this->db->where('status', 1);
    $query	=	$this->db->get('assessment');
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    if(!empty($resultArr)) {
        return TRUE;
    } else {
        return FALSE;
    }
}


public function get_assessment_appstatus($assessment_id = NULL, $emp_id = NULL) {
    $statusarr = array('Approved', 'Rejected');
    $this->db->where('emp_id', $emp_id);
    $this->db->where('assessment_id', $assessment_id);
    //$this->db->where_in('approved_status', $statusarr);
    $this->db->where_in('approved_status!=', NULL);
    $query	=	$this->db->get('assessment');
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    if(!empty($resultArr)) {
        return TRUE;
    } else {
        return FALSE;
    }
}




public function create_room() {
    $data = array('classroom_name' => rand(),
    'institute_master_id' => 3,
    'branch_master_id' => 2,
    'group_master_id' => 1,
    'type' => 2,
    'total_occupancy' => 1000000
                    );
    $res = $this->db->insert('am_classrooms',$data);
    return $this->db->insert_id();
}


public function update_mapping($question_paper_id = NULL, $data) {
    $this->db->where('question_paper_id', $question_paper_id);
    $rows = $this->db->update('am_course_mapping', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// public function get_trainingstatus($training_id = NULL, $emp) {
//     $this->db->select('*');
//     $this->db->from('mm_emp_material_view_status');
//     $this->db->where('emp_id', $emp_id);
//     $this->db->where('training_id', $training_id);
//     $query	=	$this->db->get();
//     $resultArr	=	array();
//     if($query->num_rows() > 0)
//     {
//         $resultArr	=	$query->result();		
//     }
//     return $resultArr;
// }


function delete_emp_course_mapping($training_id = NULL) {
    $this->db->where('batch_id', $training_id);
    $this->db->delete('am_student_course_mapping');
}

public function update_training_data($training_id = NULL, $data) {
    if($training_id>0) {
        $this->db->where('batch_id', $training_id);
    $rows = $this->db->update('am_batch_center_mapping', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
    } else {
        return FALSE; 
    }
}


public function get_completed_assessment_count($assessment_id = NULL, $sort = NULL, $keyword = NULL) {
    $this->db->select('am_students.name as em_name,assessment.*,gm_exam_schedule.*');
    $this->db->from('assessment');
    $this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = assessment.assessment_id');
    $this->db->join('am_students', 'am_students.student_id = assessment.emp_id');
    $this->db->where('assessment.status', 1);
    if($sort == 1) {
        $this->db->where('assessment.approved_status', NULL);
    } 
    if($assessment_id>0) {
        $this->db->where('assessment.assessment_id', $assessment_id);
    }
    $query	=	$this->db->get(); 
    $resultArr	=	0;
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->num_rows();		
    }
    return $resultArr;
}

public function get_completed_assessment($assessment_id = NULL, $sort = NULL, $page = NULL, $size = NULL, $sortfield = NULL, $order = NULL, $keyword = NULL) {
    $limit = $size; 
    $start = 0;
    if($page>1) {
    $limit = $size * $page; 
    $start = $size * ($page-1);
    }
    if($limit<=0) {
        $limit = 20;
    }
    $statusarr = array('Approved', 'Rejected');
    $this->db->select('am_students.name as em_name,assessment.*,gm_exam_schedule.*');
    $this->db->from('assessment');
    $this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = assessment.assessment_id');
    $this->db->join('am_students', 'am_students.student_id = assessment.emp_id');
    //$this->db->join('am_course_mapping', 'am_course_mapping.gm_exam_schedule_id = gm_exam_schedule.id');
    $this->db->where('assessment.status', 1);
    if($sort == 1) {
        $this->db->where('assessment.approved_status', NULL);
        //$this->db->where_not_in('assessment.approved_status', $statusarr);
        //$this->db->where('assessment.approved_status is NULL', NULL, FALSE);  //$this->db->where('field is NOT NULL', NULL, FALSE);
    } 
    if($assessment_id>0) {
        $this->db->where('assessment.assessment_id', $assessment_id);
    }
    if($sortfield!='' && $order != '') {
    //$this->db->order_by($sortfield, $order);
    }
    //$this->db->limit($limit, $start);
    $query	=	$this->db->get(); //echo $this->db->last_query();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}


public function get_highscoreatt($assessment_id = NULL, $emp_id = NULL) {
    $this->db->select('*');
    $this->db->from('orido_exam_answers');
    $this->db->where('assessment_id', $assessment_id);
    $this->db->where('emp_id', $emp_id);
    $this->db->order_by('correct', 'desc');
    $this->db->group_by('attempt');
    $this->db->limit(1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}


public function get_last_assessment($assessment_id = NULL, $emp_id = NULL, $att = NULL) {
    $this->db->select('*');
    $this->db->from('assessment_details');
    $this->db->where('assessment_id', $assessment_id);
    $this->db->where('emp_id', $emp_id);
    $this->db->where('attempt', $att);
    $this->db->where('grade is NOT NULL', NULL, FALSE);
    $this->db->order_by('id', 'desc');
    $this->db->limit(1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}

public function get_scoredet($assessment_id = NULL, $emp_id = NULL, $attempt = NULL) {
    $this->db->select('*');
    $this->db->from('orido_exam_answers');
    $this->db->where('assessment_id', $assessment_id);
    $this->db->where('emp_id', $emp_id);
    $this->db->where('attempt', $attempt);
    $query	=	$this->db->get();
    $resultArr['total'] = 0;
    $resultArr['score']	= 0;
    if($query->num_rows() > 0)
    {
        $data	=	$query->result_array();
        $resultArr['total'] = count($data);
        $resultArr['score']	= $data[0]['correct'];	
    }
    return $resultArr;
}




public function update_grade($assessment_id = NULL, $emp_id = NULL,$attempt = NULL, $data) {
    $this->db->where('assessment_id', $assessment_id);
    $this->db->where('emp_id', $emp_id);
    $this->db->where('attempt', $attempt);
    $rows = $this->db->update('assessment_details', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}


public function get_training_details_assmnet($assessment_id = NULL) {
    $this->db->select('*');
    $this->db->from('am_batch_center_mapping');
    $this->db->join('am_course_mapping', 'am_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
    $this->db->where('am_course_mapping.gm_exam_schedule_id', $assessment_id);
    $query	=	$this->db->get(); 
    $resultArr	=	array(); 
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}



public function get_users_training_details($assessment_id = NULL, $training_id = NULL, $emp_id = NULL) {
    $this->db->select('am_students.name as em_name,assessment.*, am_student_course_mapping.*');
    $this->db->from('assessment');
    //$this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = assessment.id');
    $this->db->join('am_students', 'am_students.student_id = assessment.emp_id');
   // $this->db->join('am_course_mapping', 'am_course_mapping.gm_exam_schedule_id = gm_exam_schedule.id');
    $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
    $this->db->where('assessment.emp_id', $emp_id);
    $this->db->where('assessment.id', $assessment_id);
    $this->db->where('am_student_course_mapping.batch_id', $training_id);
    $query	=	$this->db->get(); 
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}



public function update_certificate_status($assessment_id = NULL, $emp_id = NULL, $data) {
    $this->db->where('assessment_id', $assessment_id);
    $this->db->where('emp_id', $emp_id);
    $rows = $this->db->update('assessment', $data);
    if($rows) {
        return TRUE;
    } else {
        return FALSE;
    }
}




public function get_exist_student_batch($training_id = NULL) {
    $this->db->select('am_student_course_mapping.*');
    $this->db->from('am_student_course_mapping');
    $this->db->join('am_students', 'am_students.student_id = am_student_course_mapping.student_id');
    $this->db->where('am_student_course_mapping.batch_id', $training_id);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}


public function get_material_byid($id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_study_material');
    $this->db->where('mm_study_material.id', $id);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}


function get_assessment_empid($userId = NULL){
    $this->db->select('*');
    $this->db->from('assessment');
    $this->db->where('assessment.emp_id', $userId);
    $query  =   $this->db->get(); 
    $resultArr  =   array();
    if($query->num_rows() > 0)
    {
        $resultArr  =   $query->result();       
    }
    return $resultArr;
}
function get_emp_assessment($userId,$assessment_id){
    $this->db->select('*');
    $this->db->from('assessment_details');
    $this->db->where('assessment_details.emp_id', $userId);
    $this->db->where('assessment_details.assessment_id', $assessment_id);
    $query  =   $this->db->get(); 
    $resultArr  =   array();
    if($query->num_rows() > 0)
    {
        $resultArr  =   $query->result();       
    }
    return $resultArr;
}


public function update_empdata($emp_id,$emp_name, $designation_Id, $areaID)
    {
        $data = array(
            'name'                     => $emp_name,
            'contact_number'              => $designation_Id,
            'mobile_number'              => $areaID
          );
          $this->db->where('student_id', $emp_id);
          return $this->db->update('am_students', $data);
    }




}

?>
