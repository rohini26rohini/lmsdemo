<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_schedules($sdate,$edate) {
        $role = $this->session->userdata('role');
        if($role == 'faculty'){
            $faculty_id = $this->session->userdata('user_id');
            return $this->get_faculty_schedules($faculty_id,$sdate,$edate);
        }
        if($role == 'student' || $role == 'parent'){
            $student_id = $this->session->userdata('user_id');
            return $this->get_student_schedules($student_id,$sdate,$edate);
        }
        if($role == 'receptionist'){
            $receptionist_id = $this->session->userdata('user_id');
            return $this->get_receptionist_schedules($receptionist_id,$sdate,$edate);
        }
        if($role == 'centerhead'){
            $centerhead_id = $this->session->userdata('user_id');
            return $this->get_receptionist_schedules($centerhead_id,$sdate,$edate);
        } 
        if($role == 'cch' || $role=='cce'){
            if(isset($_GET['batch_id'])){
                return $this->get_class_exam_batch_schedules(array($_GET['batch_id']),$sdate,$edate);
            }
        }
        if(isset($_GET['batch_id'])){
            return $this->get_class_exam_batch_schedules(array($_GET['batch_id']),$sdate,$edate);
        }
        return $this->db->where('schedule_date >=',$sdate)
                        ->where('schedule_date <=',$edate)
                        ->where('schedule_status',1)
                        ->get('am_schedules')->result();
    }
    
    public function get_all_classes($sdate,$edate) {
        return $this->db->where('schedule_date >=',$sdate)
                        ->where('schedule_date <=',$edate)
                        ->where('schedule_status',1)
                        ->where('schedule_type',2)
                        ->get('am_schedules')->result();
    }

    public function get_receptionist_schedules($receptionist_id,$sdate,$edate){
        $batches = $this->db->select('am_batch_center_mapping.batch_id')
                                ->from('am_staff_personal')
                                ->join('am_institute_course_mapping','am_institute_course_mapping.institute_master_id=am_staff_personal.center')
                                ->join('am_batch_center_mapping','am_batch_center_mapping.institute_course_mapping_id=am_institute_course_mapping.institute_course_mapping_id')
                                ->where('am_staff_personal.personal_id',$receptionist_id)
                                ->get()->result();
        if(!empty($batches)){
            $batch_ids=array();
            foreach($batches as $row){
                array_push($batch_ids,$row->batch_id);
            }
			return $this->get_class_exam_batch_schedules($batch_ids,$sdate,$edate);
        }else{
            return array();
        }
    }

    public function get_faculty_schedules($faculty_id,$sdate,$edate){
        return $this->db->where('schedule_date >=',$sdate)
                        ->where('schedule_date <=',$edate)
                        ->where('schedule_type',2)
                        ->where('staff_id',$faculty_id)
                        ->where('schedule_status',1)
                        ->where('schedule_room !=',0)
                        ->get('am_schedules')->result();
    }

    public function get_student_schedules($student_id,$sdate,$edate){
       // $batch_id[0] = $this->db->where('student_id',$student_id)->get('am_student_course_mapping')->row()->batch_id;
        //$batch_id = $this->common->get_last_data('am_student_course_mapping','batch_id',array('student_id'=>$student_id),'student_course_id','desc');
        // $batch_id = $this->common->get_student_schedule('am_student_course_mapping','batch_id',array('student_id'=>$student_id),'student_course_id','desc');
        // print_r($batch_id); return $this->get_class_exam_batch_schedules($batch_id,$sdate,$edate);
        $batchArr = array();
        $batch_id = $this->common->get_student_schedule('am_student_course_mapping','batch_id',array('student_id'=>$student_id, 'status'=>1),'student_course_id','desc');
        if(!empty($batch_id)) {
            foreach($batch_id as $row) {
                array_push($batchArr, $row->batch_id);
            }
        }
        return $this->get_class_exam_batch_schedules($batchArr,$sdate,$edate);
    }
    
    public function get_schedule_details($id) {
        return $this->db->where('schedule_id',$id)->get('am_schedules')->row();
    }

    public function get_exam_schedule_details($id){
        return $this->db->select('gm_exam_schedule.name as examname,
                                    gm_exam_schedule.id as examid,
                                    gm_exam_schedule.result_immeadiate,
                                    gm_exam_schedule.status as examstatus,
                                    am_schedules.schedule_type,
                                    am_schedules.schedule_date,
                                    am_schedules.schedule_start_time,
                                    am_schedules.schedule_end_time,
                                    am_schedules.schedule_description,
                                    am_schedules.schedule_link_id,
                                    am_schedules.schedule_id,
                                    am_classrooms.classroom_name as description,
                                    am_batch_center_mapping.batch_name')
                        ->from('am_schedules')
                        ->join('gm_exam_schedule','gm_exam_schedule.id=am_schedules.schedule_link_id')
                        ->join('am_classrooms','am_classrooms.room_id=am_schedules.schedule_room')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=gm_exam_schedule.batch_id')
                        ->where('am_schedules.schedule_type',1)
                        ->where('gm_exam_schedule.id',$id)
                        ->get()->row_array();
    }

    public function get_batch_schedule_details($id){
        return $this->db->select('am_schedules.*,
                                am_classrooms.classroom_name as classroom_name,
                                am_batch_center_mapping.batch_name,
                                am_staff_personal.name as faculty_name,
                                am_syllabus_master_details.module_content as module_content,
                                mm_subjects.subject_name as module_name,
                                am_institute_master.institute_name as center_name')
                        ->from('am_schedules')
                        ->join('am_classrooms','am_classrooms.room_id=am_schedules.schedule_room')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                        ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                        ->join('am_institute_master','am_institute_master.institute_master_id=am_institute_course_mapping.institute_master_id')
                        ->join('am_staff_personal','am_staff_personal.personal_id=am_schedules.staff_id')
                        ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                        ->join('mm_subjects','mm_subjects.subject_id=am_syllabus_master_details.module_master_id')
                        ->where('am_schedules.schedule_type',2)
                        ->where('am_schedules.schedule_id',$id)
                        ->get()->row_array();
     }

     public function get_batch_schedule_details_noroom($id){
         return $this->db->select('am_schedules.*,
                                 am_batch_center_mapping.batch_name,
                                 am_staff_personal.name as faculty_name,
                                 am_syllabus_master_details.module_content as module_content,
                                 mm_subjects.subject_name as module_name,
                                 am_institute_master.institute_name as center_name')
                         ->from('am_schedules')
                         ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                         ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                         ->join('am_institute_master','am_institute_master.institute_master_id=am_institute_course_mapping.institute_master_id')
                         ->join('am_staff_personal','am_staff_personal.personal_id=am_schedules.staff_id')
                         ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                         ->join('mm_subjects','mm_subjects.subject_id=am_syllabus_master_details.module_master_id')
                         ->where('am_schedules.schedule_type',2)
                         ->where('am_schedules.schedule_id',$id)
                         ->get()->row_array();
      }

      public function get_batch_schedule_details_nofaculty($id){
          return $this->db->select('am_schedules.*,
                                  am_classrooms.classroom_name as classroom_name,
                                  am_batch_center_mapping.batch_name,
                                  am_syllabus_master_details.module_content as module_content,
                                  mm_subjects.subject_name as module_name,
                                  am_institute_master.institute_name as center_name')
                          ->from('am_schedules')
                          ->join('am_classrooms','am_classrooms.room_id=am_schedules.schedule_room')
                          ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                          ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                          ->join('am_institute_master','am_institute_master.institute_master_id=am_institute_course_mapping.institute_master_id')
                          ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                          ->join('mm_subjects','mm_subjects.subject_id=am_syllabus_master_details.module_master_id')
                          ->where('am_schedules.schedule_type',2)
                          ->where('am_schedules.schedule_id',$id)
                          ->get()->row_array();
       }

       public function get_batch_schedule_details_no_room_faculty($id){
           return $this->db->select('am_schedules.*,
                                   am_batch_center_mapping.batch_name,
                                   am_syllabus_master_details.module_content as module_content,
                                   mm_subjects.subject_name as module_name,
                                   am_institute_master.institute_name as center_name')
                           ->from('am_schedules')
                           ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                           ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                           ->join('am_institute_master','am_institute_master.institute_master_id=am_institute_course_mapping.institute_master_id')
                           ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                           ->join('mm_subjects','mm_subjects.subject_id=am_syllabus_master_details.module_master_id')
                           ->where('am_schedules.schedule_type',2)
                           ->where('am_schedules.schedule_id',$id)
                           ->get()->row_array();
        }

        public function get_class_exam_batch_schedules($batch_ids,$sdate,$edate){
            $exam_schedules = $this->db->select('id')->where_in('batch_id',$batch_ids)->get('gm_exam_schedule')->result_array();
            $data=array();
            $exam_schedule_ids[0]=0;
            foreach($exam_schedules as $k=>$v){
                $exam_schedule_ids[$k]=$v['id'];
            }
            $class =  $this->db->where('schedule_date >=',$sdate)
                                ->where('schedule_date <=',$edate)
                                ->where('schedule_type',2)
                                ->where_in('schedule_link_id',$batch_ids)
                                ->where('schedule_status',1)
                                ->where('(`staff_id`!=0 or `schedule_room`!=0)')
                                ->get('am_schedules')->result();
            $exams = $this->db->where('schedule_date >=',$sdate)
                                ->where('schedule_date <=',$edate)
                                ->where_in('schedule_link_id',$exam_schedule_ids)
                                ->where('schedule_type',1)
                                ->where('schedule_status',1)
                                ->get('am_schedules')->result();
            foreach($class as $row){
                $date = $row->schedule_date.' '.$row->schedule_start_time;
                $data[strtotime($date)] = $row;
            }
            foreach($exams as $row){
                $date = $row->schedule_date.' '.$row->schedule_start_time;
                $data[strtotime($date)] = $row;
            }
            ksort($data);
            return $data;
        }

        public function get_learning_module_schedule_details($schedule_id){
            return $this->db->select('*')
                            ->where('schedule_id',$schedule_id)
                            ->where('status',1)
                            ->get('am_schedule_learning_module')->row_array();
        }
    
        public function get_courses_in_center($center_id){
            return $this->db->select('am_classes.class_name,am_institute_course_mapping.institute_course_mapping_id')
                            ->from('am_institute_course_mapping')
                            ->join('am_classes','am_classes.class_id=am_institute_course_mapping.course_master_id')
                            ->where('am_institute_course_mapping.institute_master_id',$center_id)
                            ->where('am_institute_course_mapping.status',1)
                            ->get()->result();
        }

        public function get_batches_in_center_course($institute_course_mapping_id){
            return $this->db->where('institute_course_mapping_id',$institute_course_mapping_id)->get('am_batch_center_mapping')->result();
        }
    
}