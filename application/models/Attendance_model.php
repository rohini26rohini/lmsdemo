<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
    *   function'll get all student in a batch
    *   @params batch id
    *   @author GBS-R
    *
    */
    
    public function get_student_bybatch($batch_id = NULL,$date) {
        $this->db->select('am_students.student_id,am_students.registration_number,am_students.name,am_student_course_mapping.batch_id');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_students', 'am_students.student_id = am_student_course_mapping.student_id');
        $this->db->where('am_student_course_mapping.batch_id', $batch_id);
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->where('am_students.admitted_date<=', $date);
        $this->db->order_by('am_students.registration_number', 'ASC');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }
    
    /*
    *   function'll get all student attendance 
    *   @params attendance array
    *   @author GBS-R
    *
    */
    
    function update_attendance($data = NULL) {
        $query = $this->db->insert('am_attendance', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
        
    }
    
    /*
    *   function'll update student attendance 
    *   @params attendance array
    *   @author GBS-R
    *
    */
    
    function update_attendancebyid($data = NULL, $id = NULL) {
        $this->db->where('att_id', $id);
        $query = $this->db->update('am_attendance', $data);
        if($query) {
            return true;
        } else {
            return false;
        }
        
    }
    
    /*
    *   function'll get marked attendance
    *   @params batch id, schedle id, date
    *   @author GBS-R
    *
    */
    
    public function get_marked_attendance($batch_id = NULL, $schedule_id = NULL, $date = NULL, $type = NULL) {
        $this->db->select('am_attendance.*,am_students.student_id,am_students.registration_number,am_students.name,am_students.admitted_date');
        $this->db->from('am_attendance');
        $this->db->join('am_students', 'am_students.student_id = am_attendance.student_id');
        $this->db->where('am_attendance.batch_id', $batch_id);
        $this->db->where('am_attendance.schedule_id', $schedule_id);
        $this->db->where('am_attendance.att_date', $date);
        $this->db->where('am_attendance.type', $type);
        $this->db->where('am_students.status', 1);
        $this->db->order_by('am_students.registration_number', 'ASC');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }
}

?>
