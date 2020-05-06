<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_users() {
        return $this->db->where('user_role !=','admin')->get('am_users_backoffice')->result_array();
    }
    
    public function get_student_data_by_id($student_id = NULL) {
        $this->db->select('am_students.*, states.name as statename, cities.name as districtname');
        $this->db->from('am_students');
        //$this->db->join('am_student_qualification', 'am_student_qualification.student_id = am_students.student_id','LEFT');
        $this->db->join('states', 'states.id = am_students.state');
        $this->db->join('cities', 'cities.id = am_students.district');
        $this->db->where('am_students.student_id', $student_id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
    
    
    /*
    *   function'll get student batch fee 
    *   @params student id
    *   @author GBS-R
    *
    */
    
    
     public function get_coursefee($student_id) {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        //$this->db->join('am_student_qualification', 'am_student_qualification.student_id = am_students.student_id','LEFT');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where('am_student_course_mapping.student_id', $student_id);
        //$this->db->where('am_student_course_mapping.status', 0);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;    
    }
    
//    public function get_coursefee($student_id) {
//        $this->db->select('*');
//        $this->db->from('am_batch_center_mapping');
//        //$this->db->join('am_student_qualification', 'am_student_qualification.student_id = am_students.student_id','LEFT');
//        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.batch_id = am_batch_center_mapping.batch_id');
//        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
//        $this->db->where('am_student_course_mapping.student_id', $student_id);
//        $this->db->where('am_student_course_mapping.status', 2);
//	    $query	=	$this->db->get();
//		$resultArr	=	array();
//		if($query->num_rows() > 0)
//        {
//			$resultArr	=	$query->row();
//		}
//
//		return $resultArr;    
//    }

/*
*   function'll get student active course details
*   @params student id
*   @author GBS-R
*/


    function get_student_active_batch($student_id = NULL) {
       $this->db->select('am_student_course_mapping.*, am_classes.*, am_batch_center_mapping.batch_name,am_batch_center_mapping.batch_capacity,
       am_batch_center_mapping.batch_code,am_batch_center_mapping.batch_mode,am_batch_center_mapping.batch_datefrom,am_batch_center_mapping.batch_dateto,
       am_batch_center_mapping.batch_start_time,am_batch_center_mapping.batch_end_time,am_batch_center_mapping.batch_status');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where('am_student_course_mapping.student_id', $student_id);
        $this->db->where('am_student_course_mapping.status', 1);
        $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
    /*
*   function'll get student active course details
*   @params student id
*   @author GBS-L
*/


    function get_student_batch($student_id = NULL) {
       $this->db->select('am_student_course_mapping.batch_id');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where(array('am_student_course_mapping.status'=>2,'am_student_course_mapping.student_id'=> $student_id/*,'am_batch_center_mapping.batch_datefrom>='=>date('Y-m-d'),'am_batch_center_mapping.batch_dateto<='=>date('Y-m-d')*/));
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }


/*
*   function'll get student active course details
*   @params student id
*   @author GBS-R
*/


    function get_notification_by_school($school_id = NULL) {
       $this->db->select('*');
        $this->db->from('web_notifications');
        $this->db->where('school_id', $school_id);
        $this->db->where('notification_status', 1);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }
    function get_exam_result($student_id = NULL) {
        $this->db->select('*');
         $this->db->from('orido_exam_answers');
         $this->db->join('assessment_details', 'assessment_details.assessment_id = orido_exam_answers.assessment_id');
         $this->db->where('orido_exam_answers.emp_id', $student_id);
         $this->db->order_by('orido_exam_answers.id', 'desc');
         $this->db->limit('1');

         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->row();
         }
 
         return $resultArr;
     }
     function get_question_count($student_id = NULL,$course_id) {
        $this->db->select('count(question_id) as count');
         $this->db->from('orido_exam_answers');
         $this->db->join('assessment', 'assessment.id = orido_exam_answers.assessment_id');
         $this->db->where('orido_exam_answers.emp_id', $student_id);
         $this->db->where('assessment.course_id', $course_id);
         $this->db->group_by('orido_exam_answers.exam_log_id');
        // $this->db->limit('1');

         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->row();
         }
 
         return $resultArr;
     }
    function get_assessment() {
        $this->db->select('max(id) as id');
         $this->db->from('assessment');
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->row();
         }
 
         return $resultArr;
     }
    function get_ans_questionId($id = NULL) {
        $this->db->select('option_number,option_id');
         $this->db->from('mm_question_option');
         $this->db->where('question_id', $id);
       //  $this->db->where('option_number', $ans);
         $this->db->where('option_answer', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
    
     function get_courseby_subId($student_id = NULL) {
        $this->db->select('*');
         $this->db->from('am_student_course_mapping');
         $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
         $this->db->where('student_id', $student_id);
         $this->db->where('am_student_course_mapping.status', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
     function get_subjectId_courseid($course_id = NULL) {
        $this->db->select('*');
         $this->db->from('mm_subjects');
         $this->db->where('course_id', $course_id);
         $this->db->where('subject_status', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
     function get_lastattempt($emp = NULL,$course_id) {
        $this->db->select('assessment_details.attempt as attempt');
         $this->db->from('assessment_details');
         $this->db->join('assessment', 'assessment.id = assessment_details.assessment_id');
         $this->db->where('assessment.course_id', $course_id);
         $this->db->where('assessment.emp_id', $emp);
         $this->db->where('assessment.status', 1);
         $this->db->order_by('assessment_details.id', 'desc');
         $this->db->limit(1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->row();
         }
 
         return $resultArr;
     }
     function get_moduleIdBy_subject($parent_id = NULL) {
        $this->db->select('*');
         $this->db->from('mm_subjects');
         $this->db->where('parent_subject', $parent_id);
         $this->db->where('subject_status', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
     function get_questionsetBy_subject($subject_id = NULL) {
        $this->db->select('*');
         $this->db->from('mm_question_set');
         $this->db->where('subject_id', $subject_id);
         $this->db->where('question_set_status', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
     function get_questionset($question) {
         $this->db->select('*');
         $this->db->from('mm_question');
         $this->db->where_in('question_set_id',$question);
         $this->db->where('paragraph_id', 0);
         $this->db->where('question_status', 1);
         $this->db->where('question_type', 1);
         $this->db->limit('10');
         $this->db->order_by('rand()');
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
     function get_resultset($student_id = NULL, $course_id = NULL) {
        $this->db->select('*,assessment_details.attempt as attemptcount');
        $this->db->from('assessment_details');
        $this->db->join('assessment', 'assessment.id = assessment_details.assessment_id');
        $this->db->where('assessment_details.emp_id',$student_id);
        $this->db->where('assessment.course_id',$course_id);
        $this->db->order_by('assessment_details.id','desc');
        $query	=	$this->db->get(); //echo $this->db->last_query();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();
        }

        return $resultArr;
    }
     function get_optionBy_ques_id($question_id = NULL) {
        $this->db->select('*');
         $this->db->from('mm_question_option');
         $this->db->where_in('question_id', $question_id);
         $this->db->where('option_status', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }
     function get_courseone($student_id = NULL) {
        $this->db->select('*');
         $this->db->from('am_student_course_mapping');
         $this->db->where('student_id', $student_id);
         $this->db->where('status', 1);
         $this->db->limit(1);
         $this->db->order_by('course_id','asc');
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->row();
         }
 
         return $resultArr;
     }
     function get_coursecount_ID($student_id = NULL) {
        $this->db->select('*');
         $this->db->from('am_student_course_mapping');
         $this->db->where('student_id', $student_id);
         $this->db->where('status', 1);
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->num_rows();
         }
 
         return $resultArr;
     }
/*
*   function'll get student all exam
*   @params student id
*   @author GBS-R
*/


    function get_student_exams($student_id = NULL) {
       //$this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*, count(gm_exam_result_summary.exam_id) as atemt');
        $this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*');
        $this->db->from('gm_exam_result_summary');
        $this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = gm_exam_result_summary.exam_id');
        $this->db->join('gm_exam_definition', 'gm_exam_definition.id = gm_exam_schedule.exam_definition_id');
        $this->db->where('gm_exam_result_summary.student_id', $student_id);
        $this->db->where('gm_exam_schedule.status !=', -1);
        $this->db->order_by('gm_exam_result_summary.exam_id', "DESC");
        $this->db->order_by('gm_exam_result_summary.attempt', "DESC");
        //$this->db->where('gm_exam_result_summary.attendance_status', '');
        //$this->db->group_by('gm_exam_result_summary.exam_id');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }

    function get_student_examss($student_id = NULL) {
        //$this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*, count(gm_exam_result_summary.exam_id) as atemt');
        $this->db->distinct(); 
        $this->db->select('web_notifications.*,web_notifications.name as notification,am_student_course_mapping.student_id');
         $this->db->from('web_notifications');
         $this->db->join('am_classes', 'am_classes.school_id = web_notifications.school_id');
        //  $this->db->join('web_examlist', 'web_examlist.notification_id = web_notifications.notification_id');

         $this->db->join('am_student_course_mapping', 'am_student_course_mapping.course_id = am_classes.class_id');
         $this->db->where('am_student_course_mapping.student_id', $student_id);
         $this->db->where('web_notifications.notification_status', 1);
         //$this->db->group_by('gm_exam_result_summary.exam_id');
         $query	=	$this->db->get();
         $resultArr	=	array();
         if($query->num_rows() > 0)
         {
             $resultArr	=	$query->result();
         }
 
         return $resultArr;
     }

     function get_exams_by_id($student_id) 
    {
		$this->db->select('*');
		$this->db->where('student_id',$student_id);
		$query	=	$this->db->get('am_staff_personal');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
        return $resultArr;
        // print_r($this->db->last_query()) ;
        // die();
    }

/*
*   function'll get student all exam
*   @params student id
*   @author GBS-S
*/


// function get_student_examlist($student_id = NULL) {
//      $this->db->select('web_examlist.*');
//      $this->db->from('web_examlist');
//      $this->db->join('am_classes', 'am_classes.school_id = web_notifications.school_id');
//          $this->db->join('am_student_course_mapping', 'am_student_course_mapping.course_id = am_classes.class_id');
//          $this->db->where('am_student_course_mapping.student_id', $student_id);
//      $query	=	$this->db->get();
//      $resultArr	=	array();
//      if($query->num_rows() > 0)
//      {
//          $resultArr	=	$query->result();
//      }

//      return $resultArr;
//  }
    


/*
*   function'll get student exam detail by id
*   @params student id
*   @author GBS-R
*/


    function get_student_examdetails($student_id = NULL, $exam_id = NULL, $attempt = NULL) {
        //$this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*,gm_exam_question_paper.*');
        $this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*');
        $this->db->from('gm_exam_result_summary');
        $this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = gm_exam_result_summary.exam_id');
        $this->db->join('gm_exam_definition', 'gm_exam_definition.id = gm_exam_schedule.exam_definition_id');
        //$this->db->join('gm_exam_question_paper', 'gm_exam_question_paper.exam_schedule_id = gm_exam_result_summary.exam_id');
        $this->db->where('gm_exam_result_summary.student_id', $student_id);
        $this->db->where('gm_exam_result_summary.exam_id', $exam_id);
        $this->db->where('gm_exam_result_summary.attempt', $attempt);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }

/*
*   function'll get exam question paper
*   @params question paper id
*   @author GBS-R
*/


    function get_exam_papers_details($question_paper_id = NULL, $section_ids = NULL) {
        $finalArr = array();
        $sql = "select q.question_id,mq.question_content,mq.paragraph_id,cast('' as BINARY) as paragraph_content,mq.question_solution,q.exam_section_details_id,q.question_number from gm_exam_paper_questions q,mm_question mq where exam_paper_id = ".$question_paper_id." and mq.question_id = q.question_id and mq.paragraph_id = 0 and q.status=1 order by q.question_number ASC";
        $query = $this->db->query($sql);
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}
       /*$sql = "select q.question_id,mq.question_content,mp.paragraph_id,mp.paragraph_content,mq.question_solution,q.exam_section_details_id,q.question_number from 
        gm_exam_paper_questions q,mm_question mq,mm_question_paragraph mp where mq.question_id = q.question_id and 
        mp.paragraph_id = mq.paragraph_id and q.exam_paper_id=".$question_paper_id." and q.exam_section_details_id in (".$section_ids.") order by q.question_number";*/
        $sql = "select q.question_id,mq.question_content,mp.paragraph_id,mp.paragraph_content,mq.question_solution,q.exam_section_details_id,q.question_number 
        from gm_exam_paper_questions q,mm_question mq,mm_question_paragraph mp 
        where mq.question_id = q.question_id 
        and mp.paragraph_id = mq.paragraph_id 
        and q.exam_paper_id=".$question_paper_id." and q.status=1 order by q.question_number ASC";
            
        $resultPara = array();
        $query = $this->db->query($sql);
		if($query->num_rows() > 0)
        {
			$resultPara	=	$query->result();
        }
        
        $finalArr = array_merge($resultArr,$resultPara);
        // show($finalArr);
        $finalArr = sortorderqn($finalArr);
		return $finalArr;
    }

/*
*   function'll get question by id
*   @params question id
*   @author GBS-R
*/


    function get_question_byid($question_id = NULL) {
        $this->db->select('*');
        $this->db->from('mm_question');
        $this->db->where('question_id', $question_id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();
            $this->db->select('*');
            $this->db->from('mm_question_option');
            $this->db->where('question_id', $question_id);
            $query	=	$this->db->get();
            if($query->num_rows() > 0)
            {
                $resultArr['options']	=	$query->result_array();
            }

            $this->db->select('*');
            $this->db->from('mm_question_paragraph');
            $this->db->where('paragraph_id', $resultArr['paragraph_id']);
            $query	=	$this->db->get();
            if($query->num_rows() > 0)
            {
                $resultArr['paragraph']	=	$query->row();
            }

		}

		return $resultArr;
    }
    
/*
*   function'll get student exam question details
*   @params student id
*   @author GBS-R
*/


    function get_student_exam_question_details($student_id = NULL, $exam_id = NULL, $attempt = NULL) {
       $this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*,gm_exam_question_paper.*');
        $this->db->from('gm_exam_result_summary');
        $this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = gm_exam_result_summary.exam_id');
        $this->db->join('gm_exam_definition', 'gm_exam_definition.id = gm_exam_schedule.exam_definition_id');
        $this->db->join('gm_exam_question_paper', 'gm_exam_question_paper.exam_schedule_id = gm_exam_result_summary.exam_id');
        $this->db->where('gm_exam_result_summary.student_id', $student_id);
        $this->db->where('gm_exam_result_summary.exam_id', $exam_id);
        $this->db->where('gm_exam_result_summary.attempt', $attempt);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }

    public function halltkt_add($data)
    {
        $this->db->insert('web_examlist',$data);	
        $rows=  $this->db->insert_id();
        if($rows > 0){
            return "1";
        }else{
            return "2";
        }
    }

    function edit_exams($id,$notification_id,$data){
        $this->db->where('student_id',$id);
        $this->db->where('notification_id',$notification_id);
        $query	= $this->db->update('web_examlist',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
    }
    
    
    /*
    *   function'll get list of child by parent id
    *   @params parent id
    *   @author GBS-R
    */
    
    function get_children_byparentid($parent_id) 
    {
		$this->db->select('*');
		$this->db->where('parent_id',$parent_id);
		$query	=	$this->db->get('am_students');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
    }

    public function is_halltkt_exist($student_id,$notification_id)
    {
        // $query= $this->db->get_where('web_examlist',$data);
        // if($query->num_rows()>0){
        //    return true;
        // }else{
        //     return false;
        // }

       $query= $this->db->get_where('web_examlist',array("student_id"=>$student_id,"notification_id"=>$notification_id));
        return $query->num_rows();

    
    }
	
	 public function is_halltkt_duplicatedit($hallticket_no, $student_id)
    {
        
       $query= $this->db->get_where('web_examlist',array("hall_tkt"=>$hallticket_no));
        return $query->num_rows();

    
    }
	
	 public function is_halltkt_duplicate($hallticket_no)
    {
        
       $query= $this->db->get_where('web_examlist',array("hall_tkt"=>$hallticket_no));
        return $query->num_rows();

    
    }

    function insert_staff($data){
		// $this->db->insert('am_staff_personal', $data);
        // $staff_id = $this->db->insert_id();
        // return $staff_id;
        $res	= $this->db->insert('am_staff_personal',$data);	
        if($res)
        {
           return 1;
        }
        else
        {
            return 2;
        }
    }
    // function insert_qualification($data){
	// 	$this->db->insert('am_student_qualification', $data);
    //     $qualification_id = $this->db->insert_id();
	// 	return $qualification_id;
    // }

    public function insert_data($studentArr,$qualificationArr1,$qualificationArr2,$qualificationArr3,$qualificationArr4,$mapArr,$payment,$installment)
    {
        $this->db->trans_start();
        $this->db->insert('am_students',$studentArr);
        $student_id = $this->db->insert_id();
		$regNum = generate_userid($student_id);
        $this->db->where('student_id', $student_id)->update('am_students', array('registration_number'=>$regNum));

        $qualificationArr1['student_id']=$student_id;
        $this->db->insert('am_student_qualification',$qualificationArr1);
        $qualification_id = $this->db->insert_id();
        $this->db->insert('am_student_documents',['student_id'=>$student_id,
                                                    'qualification_id'=>$qualification_id,
                                                    'qualification'=>$qualificationArr1['qualification'],
                                                    'document_name'=>'',
                                                    'file'=>'',
                                                    'verification'=>1,
                                                    'status'=>1]);

        $qualificationArr2['student_id']=$student_id;
        $this->db->insert('am_student_qualification',$qualificationArr2);
        $qualification_id = $this->db->insert_id();
        $this->db->insert('am_student_documents',['student_id'=>$student_id,
                                                    'qualification_id'=>$qualification_id,
                                                    'qualification'=>$qualificationArr2['qualification'],
                                                    'document_name'=>'',
                                                    'file'=>'',
                                                    'verification'=>1,
                                                    'status'=>1,]);

        $qualificationArr3['student_id']=$student_id;
        $this->db->insert('am_student_qualification',$qualificationArr3);
        $qualification_id = $this->db->insert_id();
        $this->db->insert('am_student_documents',['student_id'=>$student_id,
                                                    'qualification_id'=>$qualification_id,
                                                    'qualification'=>$qualificationArr3['qualification'],
                                                    'document_name'=>'',
                                                    'file'=>'',
                                                    'verification'=>1,
                                                    'status'=>1,]);

        $qualificationArr4['student_id']=$student_id;
        $this->db->insert('am_student_qualification',$qualificationArr4);
        $qualification_id = $this->db->insert_id();
        $this->db->insert('am_student_documents',['student_id'=>$student_id,
                                                    'qualification_id'=>$qualification_id,
                                                    'qualification'=>$qualificationArr4['qualification'],
                                                    'document_name'=>'',
                                                    'file'=>'',
                                                    'verification'=>1,
                                                    'status'=>1,]);

        $mapArr['student_id']=$student_id;
        $this->db->insert('am_student_course_mapping',$mapArr);

        // PAYMENT TABLE
        $payment['student_id'] = $student_id;
        $this->db->insert('pp_student_payment',$payment);
        $payment_id = $this->db->insert_id();
        
        // PAYMENT INSTALLMENT TABLE
        $cessvalue = 0;
        $installments = [];
        if($payment['payment_type']=='installment'){
            $sgst = $this->db->where('key','SGST')->get('am_config')->row()->value;
            $cgst = $this->db->where('key','CGST')->get('am_config')->row()->value;
            $cess = $this->db->where('key','cess')->get('am_config')->row()->value;
            if($cess==1) {
                $cessvalue = $this->db->where('key','cess_value')->get('am_config')->row()->value;   
            }
            $taxPer = ($sgst+$cgst+$cessvalue+100)/100;
            foreach($installment as $k=>$inst){
                array_push($installments,array(
                    'payment_id' => $payment_id,
                    'paid_payment_mode' => $payment['paymentmode'],
                    'installment' => $k,
                    'installment_amount' => $inst,
                    'installment_amount_withtax' => $inst*$taxPer,
                    'installment_paid_amount' => $inst*$taxPer,
                ));
            }
            if(!empty($installments)){
                $this->db->insert_batch('pp_student_payment_installment',$installments);
            }
            foreach($installment as $k=>$inst){
                $this->common->invoice($payment_id, $k, $inst*$taxPer, $inst);   
            }
        } else {
            $coursefee = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$payment['institute_course_mapping_id']));
            $this->common->invoice($payment_id, Null, $payment['paid_amount'], $coursefee['course_tuitionfee']); 
        }

		// USER TABLE
		$student_password = mt_rand(100000,999999);
        $encrypted_password = $this->Auth_model->get_hash($student_password);
		$student_credential=array(
            "user_name"=>$studentArr['name'],
            "user_primary_id"=>$student_id,
            "user_username"=>$regNum,
            "user_emailid"=>$studentArr['email'],
            "user_passwordhash"=>$encrypted_password,
            "user_role"=>"student",
            "user_status"=>1,
            "user_phone"=>$studentArr['mobile_number']
            );
        $query = $this->db->insert('am_users',$student_credential);
		if($query){
			//check parent as already have a login credential or not
            $guardian_number=$studentArr['guardian_number'];
            $exist=$this->common->check_if_dataExist("am_users",array("user_username"=>$guardian_number,"user_role"=>"parent"));
            if($exist == 0){
                $password = mt_rand(100000,999999);
                $encrypted_password = $this->Auth_model->get_hash($password);    
                $parent_credential=array(
                                        "user_name"=>$studentArr['guardian_name'],
                                        "user_username"=>$studentArr['guardian_number'],
                                        "user_emailid"=>$studentArr['email'],
                                        "user_passwordhash"=>$encrypted_password,
                                        "user_role"=>"parent",
                                        "user_status"=>1,
                                        "user_phone"=>$studentArr['guardian_number']
                                    );
                $patentquery = $this->db->insert('am_users',$parent_credential);
                $parent_id=$this->common->get_name_by_id("am_users","user_id",array("user_username"=>$guardian_number,"user_role"=>"parent"));
            }else{
                $parent_id=$this->common->get_name_by_id("am_users","user_id",array("user_username"=>$guardian_number,"user_role"=>"parent"));
            }
			$this->Common_model->update("am_students", array("parent_id"=>$parent_id),array("student_id"=>$student_id));
		}
		// USER TABLE ENDS
		
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return "2";  
        }else{
            $this->db->trans_commit();
            $this->common->gm_user_registration($regNum,$student_password,$student_id);
            $emaildata = email_header();
            $emaildata.='<tr style="background:#f2f2f2">
                            <td style="padding: 20px 0px">
                                <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$studentArr['name'].'</h3>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">An account has been created for you on Direction application, Now you can login to our website application using following credential.</p>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$regNum.'</p>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$student_password.'</p>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><a href="'.base_url('login').'">Click here to login</a> and view your Course details and schedule details</p>
                            </td>
                        </tr>';
            $emaildata.=email_footer();
            $jobdata['from']    = 'noreply@direction.org.in';
            $jobdata['to']      = $studentArr['email'];
            $jobdata['subject'] = 'Login credentials for login to Direction application';
            $jobdata['message'] = $emaildata;
            $this->db->insert('emails', $jobdata);
            return "1";
        }
    }

    public function insert_student($data)
    {
        $query	= $this->db->insert('am_students',$data);	
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    public function insert_qualification($data)
    {
        $query	= $this->db->insert('am_student_qualification',$data);	
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }

    public function add_permission($data)
    {
      $query=$this->db->insert_batch('am_role_module_permission', $data);
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }

    function user_check_new($student, $email, $phone) {
        $this->db->select('*');
       // $this->db->where('name', $student);
        $this->db->or_where('contact_number', $phone);
        $this->db->or_where('email', $email);
        $this->db->where('status', 1);
        $out = $this->db->get('am_students')->num_rows();
        return $out;
        /*if (!empty($out)) {
            return "0";
        } else {
            return "2";
        }*/
    }
    function staff_check_new($staff, $email, $phone) {
        $this->db->select('*');
        $this->db->where('name', $staff);
        $this->db->where('mobile', $phone);
        $this->db->where('email', $email);
        $out = $this->db->get('am_staff_personal')->row_array();
        if (!empty($out)) {
            return "0";
        } else {
            return "2";
        }
    }

    function get_course_centermapp($course_id, $branch_id, $center_id = NULL) {
        $this->db->select('institute_course_mapping_id');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
        $this->db->where('am_institute_course_mapping.branch_master_id', $branch_id);
        if($center_id!='') {
        $this->db->where('am_institute_course_mapping.institute_master_id', $center_id);
        }
        $this->db->group_by('am_institute_course_mapping.institute_master_id');   //   <--- Edited GBS-R 10-01-2019 --->
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->row_array();		
        }
    
        return $resultArr;
    }

	public function get_questions($id){
        $questionSet = $this->db->select('question_id')->where('learning_module_id',$id)->get('am_learning_module_questions')->result_array();
        $q = array();
        $i =0;
        foreach($questionSet as $question){
            $questionContent = $this->db->select('*')->where('question_id',$question['question_id'])->get('mm_question')->row_array();
            array_push($q, $questionContent);
            $questionOptions = $this->db->select('*')->where('question_id',$question['question_id'])->get('mm_question_option')->result_array();
            $q[$i]['options'] = $questionOptions;
            $questionOptions = $this->db->select('*')->where('question_id',$question['question_id'])->get('mm_question_option')->result_array();
            $i++; 
        }
        $passageTemp = $this->db->select('mm_question_paragraph.*')
                            ->from('mm_question')
                            ->join('mm_question_paragraph', 'mm_question_paragraph.paragraph_id = mm_question.paragraph_id')
                            ->join('am_learning_module_questions', 'am_learning_module_questions.question_id = mm_question.question_id')
                            ->where('am_learning_module_questions.learning_module_id',$id)
                            ->get()->result_array();
        $passage = [];                   
        foreach($passageTemp as $passag){
            $passage[$passag['paragraph_id']] = $passag;
        }
        return ['questions'=>$q,'passage'=>$passage];
        // show($passage);
    }
    public function get_questions_by_learning_module_id($id){
        $query	=	$this->db->where('question_status',1)->get('am_questions');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }

function get_course_materials($course_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_study_material');
    $this->db->join('mm_material', 'mm_material.material_id = mm_study_material.material_id');
    $this->db->join('mm_subjects', 'mm_subjects.subject_id = mm_material.subject_id');
    $this->db->where_in('mm_subjects.parent_subject', $course_id);
    $this->db->where('mm_study_material.status', 1);
    $this->db->order_by('mm_study_material.id', 'asc');   
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->result();		
    }
    return $resultArr;
}


function get_module_materials($module_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_subjects');
    //$this->db->join('mm_material', 'mm_material.material_id = mm_study_material.material_id');
    $this->db->join('mm_material', 'mm_material.subject_id = mm_subjects.subject_id');
    $this->db->where('mm_subjects.subject_id', $module_id);
    $this->db->where('mm_material.material_type', 'study material');
    $this->db->where('mm_material.material_status', 1);
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->row();		
    }
    return $resultArr;
}




function get_course_materials_count($course_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_study_material');
    $this->db->join('mm_material', 'mm_material.material_id = mm_study_material.material_id');
    $this->db->join('mm_subjects', 'mm_subjects.subject_id = mm_material.subject_id');
    $this->db->where_in('mm_subjects.parent_subject', $course_id);
    $this->db->where('mm_study_material.status', 1);
    $this->db->order_by('mm_study_material.id', 'asc');   
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->num_rows();		
    }
    // echo $this->db->last_query();
    return $resultArr;
}
function get_students_count($emp_id = NULL) {
    $this->db->select('*');
    $this->db->from('mm_emp_material_view_status');
    $this->db->where('mm_emp_material_view_status.emp_id', $emp_id);
   // $this->db->where_in('mm_emp_material_view_status.material_id', $mat);

    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0)
    {
        $resultArr	=	$query->num_rows();		
    }
    // echo $this->db->last_query();
    return $resultArr;
}
}
