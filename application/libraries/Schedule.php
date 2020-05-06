<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Schedule {
    function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->database();
        $this->db = $this->_ci->db;
    }
    
    public function get_batch_schedule_details($batch_id,$date,$start_time,$end_time){
        return $this->db->where('schedule_link_id',$batch_id)
                        ->where('schedule_date',$date)
                        ->where('schedule_start_time',$start_time)
                        ->where('schedule_end_time',$end_time)
                        ->where('schedule_status !=',0)
                        ->get('am_schedules')->row_array();
    }

    public function delete_all_conflicted_schedules($batch_id){
        $this->db->where('schedule_link_id',$batch_id) //Delete saved conflicted schedules
                ->where('schedule_type',2)
                ->where('schedule_status',1)
                ->where('(`staff_id`=0 or `schedule_room`=0)')
                ->delete('am_schedules');
        return $this->db->where('schedule_link_id',$batch_id)
                        ->where('schedule_type',2)
                        ->where('schedule_status !=',1)
                        ->where('schedule_status !=',0)
                        ->delete('am_schedules');
    }

    public function create_batch_schedule($batch_id,$date,$start_time,$end_time,$color){
        $batch_detail = $this->get_batch_details($batch_id);
        $data['schedule_type'] = 2;
        $data['schedule_link_id'] = $batch_id;
        $data['schedule_date'] = $date;
        $data['schedule_start_time'] = $start_time;
        $data['schedule_end_time'] = $end_time;
        $data['schedule_status'] = 2;
        $data['schedule_description'] = 'Class schedule for batch '.$batch_detail['batch_name'];
        $data['schedule_color'] = $color;
        
        $faculty_module = $this->get_faculty_module($batch_id,$date,$start_time,$end_time);
        $data['staff_id'] = $faculty_module['faculty'];
        $data['module_id'] = $faculty_module['module'];

        if($faculty_module['faculty']==0){
            $data['schedule_status'] = 3;
        }
        if($faculty_module['module']==0){
            return false;
        }else{
            if($room = $this->get_room($batch_id,$date,$start_time,$end_time)){
                $data['schedule_room'] = $room;
            }else{
                $data['schedule_room'] = 0;
                $data['schedule_status'] = 3;
            }
            if($data['schedule_status'] == 3){
                $data['schedule_color'] = '#FF0000';
            }
            return $data;
        }
    }

    // FIND ROOM AUTOMATION - BEGINS
    public function get_room($batch_id,$date/* Y-m-d */,$start_time/* H:i:s */,$end_time/* H:i:s */){
        $last_room = $this->db->select('schedule_room')
                                ->where('schedule_type',2)
                                ->where('schedule_status !=',0)
                                ->where('schedule_link_id',$batch_id)
                                ->order_by('schedule_id','DESC')
                                ->get('am_schedules')->row();
        if(!empty($last_room)){
            if($this->check_room_eligibility($last_room->schedule_room,$batch_id,$date,$start_time,$end_time)){
                return $last_room->schedule_room;
            }else{
                return $this->get_eligible_room($batch_id,$date,$start_time,$end_time);
            }
        }else{
            return $this->get_eligible_room($batch_id,$date,$start_time,$end_time);
        }
    }

    public function check_room_eligibility($room,$batch_id,$date/* Y-m-d */,$start_time/* H:i:s */,$end_time/* H:i:s */,$batch_capacity=NULL,$room_capacity=NULL,$schedule_id=0){
        if($batch_capacity===NULL){
            $query = $this->db->select('batch_capacity')->where('batch_id',$batch_id)->get('am_batch_center_mapping');
            if($query->num_rows()>0){
                $batch_capacity = $query->row()->batch_capacity;
            }else{
                $batch_capacity = 0;
            }
        }
        if($room_capacity===NULL){
            $query = $this->db->select('total_occupancy')->where('room_id',$room)->get('am_classrooms');
            if($query->num_rows()>0){
                $room_capacity = $query->row()->total_occupancy;
            }else{
                $room_capacity = 0;
            }
        }
        if($batch_capacity > $room_capacity){
            return FALSE;
        }else{
            $room_engaged = $this->db->query("SELECT * FROM `am_schedules` 
                                                WHERE `schedule_status` = 1 
                                                AND `schedule_id` != ".$schedule_id."
                                                AND `schedule_date` = '".$date."' 
                                                AND `schedule_room` = '".$room."' 
                                                AND ((`schedule_start_time` <= '".$start_time."' AND `schedule_end_time` >= '".$start_time."') 
                                                    OR 
                                                    (`schedule_start_time` <= '".$end_time."' AND `schedule_end_time` >= '".$end_time."')
                                                    OR 
                                                    (`schedule_start_time` >= '".$start_time."' AND `schedule_end_time` <= '".$end_time."'))")->num_rows();
            if($room_engaged){
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function get_eligible_room($batch_id,$date/* Y-m-d */,$start_time/* H:i:s */,$end_time/* H:i:s */){
        $batch_details = $this->get_batch_details($batch_id);
        $rooms = $this->db->where('total_occupancy >=',$batch_details['batch_capacity'])
                            ->where('institute_master_id',$batch_details['institute_master_id'])
                            ->where('type',1)
                            ->order_by('total_occupancy','ASC')
                            ->get('am_classrooms')->result();
        if(!empty($rooms)){
            foreach($rooms as $row){
                if($this->check_room_eligibility($row->room_id,$batch_id,$date,$start_time,$end_time,$batch_details['batch_capacity'],$row->total_occupancy)){
                    return $row->room_id;
                    break;
                }
            }
            return FALSE;
        }else{
            return FALSE;
        }
    }
    // FIND ROOM AUTOMATION - ENDS

    // FIND FACULTY & MODULE AUTOMATION - BEGINS
    public function get_faculty_module($batch_id,$date,$start_time,$end_time){
        $batch_syllabus_details = $this->get_batch_syllabus_details($batch_id);
        $last_module = $this->get_last_scheduled_batch_module($batch_id,$date,$start_time);

        // Collect all modules for this batch
        $batch_modules = array();
        if(!empty($batch_syllabus_details)){
            foreach($batch_syllabus_details as $row){
                array_push($batch_modules,array(
                                                'syllabus_master_detail_id'=>$row['syllabus_master_detail_id'],
                                                'module_master_id'=>$row['module_master_id']
                                            ));
            }
        }
        
        // Get the next module based on the last module
        if($last_module==false){
            $next_module = $batch_syllabus_details[0]['syllabus_master_detail_id'];
        }else{
            foreach($batch_syllabus_details as $k=>$v){
                if($batch_syllabus_details[$k]['syllabus_master_detail_id']==$last_module){
                    if(isset($batch_syllabus_details[$k+1]['syllabus_master_detail_id'])){
                        $next_module = $batch_syllabus_details[$k+1]['syllabus_master_detail_id'];
                        break;
                    }else{
                        $next_module = $batch_syllabus_details[0]['syllabus_master_detail_id'];
                    }
                }
            }
        }

        $faculty = 0;
        $module = $next_module;
        $mod=0;
        CHECK_MODULE_COMPLETION:
        if($this->check_batch_module_completion($module,$batch_id)){ // Check if this module is already taken. If taken then get the next module from batch module list
            FIND_NEXT_MODULE:
            if(isset($batch_modules[$mod])){
                $module = $batch_modules[$mod]['syllabus_master_detail_id'];// Get next module
                $mod++;
                if($this->check_module_parent_completion($module,$batch_id)){
                    goto CHECK_MODULE_COMPLETION;
                }else{
                    goto FIND_NEXT_MODULE;
                }
            }else{
                $module = 0;
            }
        }else{ // Get Faculty
            $batch_subjects = $this->get_batch_subjects($batch_id); // Get all subjects for that batch
            $faculties = $this->get_available_faculties($batch_id,$date,$batch_subjects,$start_time,$end_time); // Get all available faculties in that batch center on that date who takes these subjects
            $faculty_modules = $this->get_faculty_modules($faculties);
            
            foreach($batch_modules as $row){
                if($row['syllabus_master_detail_id']==$module){
                    $class_topic = $row['module_master_id'];
                    break;
                }
            }

            // Get a faculty to take this module
            if(!empty($faculty_modules)){
                foreach($faculty_modules as $staff_id=>$val){
                    if(in_array($class_topic,$val['strong_modules'])){
                        $faculty = $staff_id;
                        break;
                    }
                }
                if($faculty==0){
                    foreach($faculty_modules as $staff_id=>$val){
                        if(in_array($class_topic,$val['modules'])){
                            $faculty = $staff_id;
                            break;
                        }
                    }
                }
            }
            if($faculty==0){
                if(!isset($temp_class_topic)){
                    $temp_class_topic = $class_topic;
                }
                goto FIND_NEXT_MODULE;
            }
        }

        if($module == 0){
            if(isset($temp_class_topic)){
                foreach($batch_modules as $row){
                    if($row['module_master_id']==$temp_class_topic){
                        $module = $row['syllabus_master_detail_id'];
                    }
                }
            }
        }
        
        $data['faculty'] = $faculty;
        $data['module'] = $module;
        return $data;
    }

    public function get_available_faculties($batch_id,$date='',$batch_subjects,$start_time='',$end_time=''){
        $faculties = $this->get_faculties_center($batch_id,$batch_subjects);
        $data = array();
        if(!empty($faculties)){
            foreach($faculties as $row){
                if($date != ''){
                    $weekday = strtolower('day_'.date('D',strtotime($date)));
                    if($row['type']==1){
                        if($row[$weekday]){
                            if($start_time!='' && $end_time!=''){
                                $time_available = $this->db->where('avai_id',$row['avai_id'])
                                                            ->where('week_day',ucfirst(date('D',strtotime($date))))
                                                            ->where('start_time <=',date('H:i:s',strtotime($start_time)))
                                                            ->where('end_time >=',date('H:i:s',strtotime($end_time)))
                                                            ->get('am_faculty_availability_detail')->num_rows();
                                if($time_available > 0){
                                    array_push($data,$row['staff_id']);
                                }
                            }else{
                                array_push($data,$row['staff_id']);
                            }
                        }
                    }
                    if($row['type']==2){
                        if((strtotime($row['date_from'])<=strtotime($date)) && (strtotime($row['date_to'])>=strtotime($date))){
                            // array_push($data,$row['staff_id']);
                            if($start_time!='' && $end_time!=''){
                                $time_available = $this->db->where('avai_id',$row['avai_id'])
                                                            ->where('week_day',ucfirst(date('D',strtotime($date))))
                                                            ->where('start_time <=',date('H:i:s',strtotime($start_time)))
                                                            ->where('end_time >=',date('H:i:s',strtotime($end_time)))
                                                            ->get('am_faculty_availability_detail')->num_rows();
                                if($time_available > 0){
                                    array_push($data,$row['staff_id']);
                                }
                            }else{
                                array_push($data,$row['staff_id']);
                            }
                        }
                    }
                }else{
                    array_push($data,$row['staff_id']);
                }
            }
        }
        if(!empty($data) && $date!='' && $start_time!='' && $end_time!=''){
            $fac = $data;
            $data = array();
            $data = $this->filter_faculty_with_availability($fac,$date,$start_time,$end_time);
        }
        return $data;
    }

    public function filter_faculty_with_availability($data,$date,$start_time,$end_time){
        $result = $this->db->select('staff_id')
                            ->where('schedule_type',2)
                            ->where('schedule_status',1)
                            ->where('schedule_date',$date)
                            ->where_in('staff_id',$data)
                            ->where("((`schedule_start_time` <= '".$start_time."' AND `schedule_end_time` >= '".$start_time."')
                                        OR 
                                    (`schedule_start_time` <= '".$end_time."' AND `schedule_end_time` >= '".$end_time."')
                                        OR 
                                    (`schedule_start_time` >= '".$start_time."' AND `schedule_end_time` <= '".$end_time."'))")
                            ->get('am_schedules')->result_array();
        if(!empty($result)){
            $facs = array();
            foreach($result as $row){
                array_push($facs,$row['staff_id']);
            }
            $result = array_diff($data,$facs);
            return $result;
        }else{
            return $data;
        }
    }

    public function get_faculty_modules($faculties){
        $faculty  = array();
        if(!empty($faculties)){
            $fac_mods = $this->db->where_in('staff_id',$faculties)->get('am_faculty_subject_mapping')->result();
            if(!empty($fac_mods)){
                foreach($fac_mods as $row){
                    if(!isset($faculty[$row->staff_id]['strong_modules'])){$faculty[$row->staff_id]['strong_modules']=array();}
                    if(!isset($faculty[$row->staff_id]['weak_modules'])){$faculty[$row->staff_id]['weak_modules']=array();}
                    if(!isset($faculty[$row->staff_id]['modules'])){$faculty[$row->staff_id]['modules']=array();}
                    $faculty[$row->staff_id]['strong_modules'] = array_merge($faculty[$row->staff_id]['strong_modules'],explode(',',$row->strong_subject_id));
                    $faculty[$row->staff_id]['weak_modules'] = array_merge($faculty[$row->staff_id]['weak_modules'],explode(',',$row->weak_subject_id));
                }
            
                foreach($faculties as $val){
                    $modules = $this->db->select('mm_subjects.subject_id,am_faculty_subject_mapping.staff_id')
                                        ->from('mm_subjects')
                                        ->join('am_faculty_subject_mapping','am_faculty_subject_mapping.parent_subject_id=mm_subjects.parent_subject')
                                        ->where('mm_subjects.subject_status',1)
                                        ->where_in('staff_id',$val)
                                        ->get()->result();
                    if(!empty($modules)){
                        foreach($modules as $row){
                            if(isset($faculty[$row->staff_id])){
                                array_push($faculty[$row->staff_id]['modules'],$row->subject_id);
                                if(!empty($faculty[$row->staff_id]['weak_modules'])){
                                    $faculty[$row->staff_id]['modules'] = array_diff($faculty[$row->staff_id]['modules'],$faculty[$row->staff_id]['weak_modules']);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $faculty;
    }

    public function get_last_scheduled_batch_module($batch_id,$date,$start_time){
        $module = $this->db->where('schedule_status !=',0)
                            ->where('schedule_type',2)
                            ->where('schedule_link_id',$batch_id)
                            ->where('schedule_date <=',$date)
                            ->order_by('schedule_date','DESC')
                            ->get('am_schedules');
        if($module->num_rows()>0){
            $date = $module->row()->schedule_date; //When is this batch's last class occured
            return $this->db->where('schedule_status !=',0)
                            ->where('schedule_type',2)
                            ->where('schedule_link_id',$batch_id)
                            ->where('schedule_date',$date)
                            ->order_by('schedule_end_time','DESC')
                            ->get('am_schedules')->row()->module_id;
        }else{
            return false;
        }
    }
    // FIND FACULTY & MODULE AUTOMATION - ENDS

    public function get_batch_details($batch_id) {
        return $this->db->select('*')
                        ->from('am_batch_center_mapping')
                        ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
                        ->where('am_batch_center_mapping.batch_status', 1)
                        ->where('am_batch_center_mapping.batch_id', $batch_id)
                        ->get()->row_array();
    }

    public function get_batch_syllabus_details($batch_id){
        return $this->db->select('am_syllabus_master_details.*')
                        ->from('am_batch_center_mapping')
                        ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
                        ->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id')
                        ->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_id = am_classes.syllabus_id')
                        ->where('am_batch_center_mapping.batch_status', 1)
                        ->where('am_batch_center_mapping.batch_id', $batch_id)
                        ->get()->result_array();
    }

    public function get_batch_subjects($batch_id){
        $data=array();
        $subjects = $this->db->select('am_syllabus_master_details.subject_master_id as subjects')
                                ->from('am_batch_center_mapping')
                                ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
                                ->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id')
                                ->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_id = am_classes.syllabus_id')
                                ->where('am_batch_center_mapping.batch_status', 1)
                                ->where('am_batch_center_mapping.batch_id', $batch_id)
                                ->group_by('am_syllabus_master_details.subject_master_id')
                                ->get()->result_array();
        if(!empty($subjects)){
            foreach($subjects as $row){
                array_push($data,$row['subjects']);
            }
        }
        return $data;
    }

    public function get_faculties_center($batch_id,$batch_subjects){
        return $this->db->select('am_faculty_availability.*')
                        ->from('am_batch_center_mapping')
                        ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
                        ->join('am_faculty_availability', 'am_faculty_availability.center_id = am_institute_course_mapping.institute_master_id')
                        ->join('am_faculty_subject_mapping', 'am_faculty_subject_mapping.staff_id = am_faculty_availability.staff_id')
                        ->join('am_staff_personal', 'am_staff_personal.personal_id = am_faculty_availability.staff_id')
                        ->where('am_batch_center_mapping.batch_status', 1)
                        ->where('am_faculty_availability.status', 1)  // added active status Ramesh 28-03-2020
                        ->where('am_batch_center_mapping.batch_id', $batch_id)
                        ->where('am_staff_personal.status', 1)
                        ->where_in('am_faculty_subject_mapping.parent_subject_id', $batch_subjects)
                        ->order_by('am_staff_personal.faculty_weightage','DESC')
                        //->group_by('am_faculty_subject_mapping.staff_id	')
                        ->get()->result_array();
    }

    public function check_batch_module_completion($module_id,$batch_id){
        return $this->db->where('schedule_link_id',$batch_id)
                        ->where('schedule_type',2)
                        ->where('module_id',$module_id)
                        ->where('schedule_status !=',0)
                        ->get('am_schedules')->num_rows();
    }

    public function check_module_parent_completion($module,$batch_id){
        $module_data = $this->db->select('parent_master_id')
                                ->where('syllabus_master_detail_id',$module)
                                ->where('parent_master_id !=',NULL)
                                ->where('parent_master_id !=',0)
                                ->get('am_syllabus_master_details');
        if($module_data->num_rows()>0){
            $module_id = $module_data->row()->parent_master_id;
            if($this->check_batch_module_completion($module_id,$batch_id)){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return TRUE;
        }
    }

    public function check_batch_availability($batch,$date,$starttime,$endtime,$schedule_id=0){
        // Check class exists for this batch at this time and date
        $batch_engaged = $this->db->query("SELECT * FROM `am_schedules` 
                                            WHERE `schedule_id` != ".$schedule_id."
                                            AND `schedule_status` = 1 
                                            AND `schedule_type` = '2' 
                                            AND `schedule_link_id` = '".$batch."' 
                                            AND `schedule_date` = '".$date."' 
                                            AND ((`schedule_start_time` <= '".$starttime."' AND `schedule_end_time` >= '".$starttime."') 
                                                OR 
                                                (`schedule_start_time` <= '".$endtime."' AND `schedule_end_time` >= '".$endtime."')
                                                OR 
                                                (`schedule_start_time` >= '".$starttime."' AND `schedule_end_time` <= '".$endtime."'))")->num_rows();
        if($batch_engaged){
            return FALSE;
        }else{
            // Check exam exists for this batch at this time and date
            $batch_engaged = $this->db->query("SELECT `am_schedules`.* FROM `am_schedules` 
                                                JOIN `gm_exam_schedule` ON `gm_exam_schedule`.`id`=`am_schedules`.`schedule_link_id`
                                                WHERE `schedule_id` != ".$schedule_id."
                                                AND `am_schedules`.`schedule_status` = 1
                                                AND `am_schedules`.`schedule_type` = '1' 
                                                AND `gm_exam_schedule`.`batch_id` = '".$batch."' 
                                                AND `am_schedules`.`schedule_date` = '".$date."' 
                                                AND ((`am_schedules`.`schedule_start_time` <= '".$starttime."' AND `am_schedules`.`schedule_end_time` >= '".$starttime."') 
                                                    OR 
                                                    (`am_schedules`.`schedule_start_time` <= '".$endtime."' AND `am_schedules`.`schedule_end_time` >= '".$endtime."')
                                                    OR 
                                                    (`am_schedules`.`schedule_start_time` >= '".$starttime."' AND `am_schedules`.`schedule_end_time` <= '".$endtime."'))")->num_rows();
            if($batch_engaged){
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function check_faculty_availability($faculty,$date,$starttime,$endtime,$schedule_id=0){
        // Check class exists for this faculty at this time and date
        $faculty_engaged = $this->db->query("SELECT * FROM `am_schedules` 
                                            WHERE `schedule_status` = 1 
                                            AND `schedule_id` != ".$schedule_id."
                                            AND `schedule_type` = '2' 
                                            AND `staff_id` = '".$faculty."' 
                                            AND `schedule_date` = '".$date."' 
                                            AND ((`schedule_start_time` <= '".$starttime."' AND `schedule_end_time` >= '".$starttime."') 
                                                OR 
                                                (`schedule_start_time` <= '".$endtime."' AND `schedule_end_time` >= '".$endtime."')
                                                OR 
                                                (`schedule_start_time` >= '".$starttime."' AND `schedule_end_time` <= '".$endtime."'))")->num_rows();
        if($faculty_engaged){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function check_module_eligibility($batch,$module,$date,$starttime){
        $module_data = $this->db->select('parent_master_id')
                                ->where('syllabus_master_detail_id',$module)
                                ->where('parent_master_id !=',NULL)
                                ->where('parent_master_id !=',0)
                                ->get('am_syllabus_master_details');
        if($module_data->num_rows()>0){
            $parent_master_id = $module_data->row()->parent_master_id;
            $module_completion = $this->db->where('schedule_link_id',$batch)
                                            ->where('module_id',$parent_master_id)
                                            ->where('schedule_status',1)
                                            ->where('schedule_type',2)
                                            ->where('schedule_date <',$date)
                                            ->get('am_schedules')->num_rows();
            if($module_completion > 0){
                return TRUE;
            }else{
                $module_completion = $this->db->where('schedule_link_id',$batch)
                                                ->where('module_id',$parent_master_id)
                                                ->where('schedule_status',1)
                                                ->where('schedule_type',2)
                                                ->where('schedule_date',$date)
                                                ->where('schedule_end_time <=',$starttime)
                                                ->get('am_schedules')->num_rows();
                if($module_completion > 0){
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
        }else{
            return TRUE;
        }
    }

    

    public function check_exam_room_eligibility($room,$batch_id,$date/* Y-m-d */,$start_time/* H:i:s */,$end_time/* H:i:s */,$batch_capacity=NULL,$room_capacity=NULL,$schedule_id=0){
        if($batch_capacity===NULL){
            $query = $this->db->select('batch_capacity')->where('batch_id',$batch_id)->get('am_batch_center_mapping');
            if($query->num_rows()>0){
                $batch_capacity = $query->row()->batch_capacity;
            }else{
                $batch_capacity = 0;
            }
        }
        if($room_capacity===NULL){
            $query = $this->db->select('total_occupancy')->where('room_id',$room)->get('am_classrooms');
            if($query->num_rows()>0){
                $room_capacity = $query->row()->total_occupancy;
            }else{
                $room_capacity = 0;
            }
        }
        if($batch_capacity > $room_capacity){
            return FALSE;
        }else{
            $room_engaged = $this->db->query("SELECT * FROM `am_schedules` 
                                                WHERE `schedule_status` = 1 
                                                AND `schedule_id` != ".$schedule_id."
                                                AND `schedule_date` = '".$date."' 
                                                AND `schedule_room` = '".$room."' 
                                                AND ((`schedule_start_time` <= '".$start_time."' AND `schedule_end_time` >= '".$start_time."') 
                                                    OR 
                                                    (`schedule_start_time` <= '".$end_time."' AND `schedule_end_time` >= '".$end_time."')
                                                    OR 
                                                    (`schedule_start_time` >= '".$start_time."' AND `schedule_end_time` <= '".$end_time."'))");
            if($room_engaged->num_rows() > 0){
                $details = $room_engaged->result();
                $schedule_type = 1;
                $schedule_link_id = array();
                foreach($details as $row){
                    if($row->schedule_type == 1){
                        $schedule_type = 0;
                        array_push($schedule_link_id,$row->schedule_link_id);
                    }
                }
                if($schedule_type){
                    return FALSE;
                }else{
                    $batch = $this->db->select('am_batch_center_mapping.batch_capacity')
                                        ->from('am_batch_center_mapping')
                                        ->join('gm_exam_schedule','gm_exam_schedule.batch_id=am_batch_center_mapping.batch_id')
                                        ->where_in('gm_exam_schedule.id',$schedule_link_id)
                                        ->get()->result();
                    foreach($batch as $row){
                        $room_capacity = $room_capacity-$row->batch_capacity;
                    }
                    if($batch_capacity > $room_capacity){
                        return FALSE;
                    }else{
                        return TRUE;
                    }
                }
            }else{
                return TRUE;
            }
        }
    }

    public function check_batch_exam_modules_completion($batch,$date,$start_time,$exammodel){
        $modules = $this->db->select('am_syllabus_master_details.syllabus_master_detail_id as module_id,module.subject_name as module_name,subject.subject_name')
                                ->from('gm_exam_definition_exam_sections')
                                ->join('gm_exam_section_config_details','gm_exam_section_config_details.exam_section_config_id=gm_exam_definition_exam_sections.exam_sections_id')
                                ->join('gm_exam_section_details','gm_exam_section_details.id=gm_exam_section_config_details.details_id')
                                ->join('am_syllabus_master_details','am_syllabus_master_details.module_master_id=gm_exam_section_details.subject_id')
                                ->join('mm_subjects as module','module.subject_id=gm_exam_section_details.subject_id')
                                ->join('mm_subjects as subject','subject.subject_id=module.parent_subject')
                                ->where('gm_exam_definition_exam_sections.exam_definition_id',$exammodel)
                                ->group_by('gm_exam_section_details.subject_id')
                                ->get()->result();
        $taken_classes = $this->db->select('module_id')
                                    ->where('schedule_link_id',$batch)
                                    ->where('schedule_type',2)
                                    ->where('class_taken',1)
                                    ->get('am_schedules')->result();
        if(!empty($modules) && !empty($taken_classes)){
            foreach($taken_classes as $k=>$class){
                $taken_classes[$k] = $class->module_id;
            }
            $status = true;
            $data = [];
            foreach($modules as $module){
                if(!in_array($module->module_id,$taken_classes)){
                    array_push($data,$module);
                    $status = false;
                }
            }
            return ['data'=>$data,'status'=>$status];
        }else{
            return ['data'=>$modules,'status'=>false];
        }

    }

}
?>
