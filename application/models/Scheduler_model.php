<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
        
    public function get_branch(){
        return $this->db->where('institute_type_id',2)->where('status', 1)->get('am_institute_master')->result();
    }

    public function store_schedule_detail($schedule_data){
        return $this->db->insert('am_schedules',$schedule_data);
    }

    public function update_schedule_detail($schedule_data,$schedule_id){
        $updateData['schedule_status']=0;
        $schedule = $this->db->where('schedule_id',$schedule_id)->get('am_schedules')->row();
        //$schedule_data['schedule_description'] = $schedule->schedule_description;
        if($schedule->schedule_status != 3){
            $this->db->where('schedule_id',$schedule_id)->update('am_schedules',$updateData);
            $schedule_data['parent_schedule_id']=$schedule_id;
            return $this->store_schedule_detail($schedule_data);
        }else{
            return $this->db->where('schedule_id',$schedule_id)->update('am_schedules',$schedule_data);
        }
    }

    public function delete_schedule_detail($schedule_data,$schedule_id){
        $this->db->trans_start();
        $schedule = $this->db->where('schedule_id',$schedule_id)->get('am_schedules')->row();
        if($schedule->schedule_type==1){
            $this->db->where('id',$schedule->schedule_link_id)->update('gm_exam_schedule',array('status'=>5));
        }
        $this->db->where('schedule_id',$schedule_id)->update('am_schedules',$schedule_data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function change_exam_status($data,$id){
        if($data['status'] == 3){
            $job['exam_id']=$id;
            $job['job_status']=4;
            $job['job_type']=0;
            $this->db->insert('gm_job_request',$job);
        }
        if($data['status']==4){
            $exam_result = $this->db->where('exam_id',$id)->where('question_type',2)->get('gm_exam_result')->result();
            if(!empty($exam_result)){
                $cassandraData = [];
                foreach($exam_result as $result){
                    array_push($cassandraData,array(
                        "studentId"=>(int)$result->student_id,
                        "examScheduleId"=>(int)$result->exam_id,
                        "attempt"=>(int)$result->attempt,
                        "questionPaperId"=>(int)$result->question_paper_id,
                        "questionId"=>(int)$result->question_id,
                        "questionTypeId"=>(int)$result->question_type,
                        "correct"=>(int)$result->correct,
                        "mark"=>(float)$result->mark,
                        "section_id"=>(int)$result->secton_id
                    ));
                }
                if(!empty($cassandraData)){
                    $tokenData['method'] = "oauth/token?grant_type=password&username=gm_admin&password=password&client_id=grandmaster-client&client_secret=grandmaster-secret&scope=read+write+trust";
                    $tokenData['type'] = "POST"; 
                    $tokenData['data'] = array();
                    $tokenResponse = json_decode($this->common->rest_api_auth($tokenData)); 
                    $jsonData['access_token'] = $tokenResponse->access_token; 
                    $jsonData['method']       = "updateDescriptiveAnswers";
                    $jsonData['type']         = "POST"; 
                    $jsonData['data']         = json_encode($cassandraData); 
                    $response = json_decode($this->common->rest_api_call($jsonData)); 
                    if(!(isset($response->success) && $response->success)){
                        return false;
                    }
                }else{
                    return false;
                }
            }
            $job['exam_id']=$id;
            $job['job_status']=5;
            $job['job_type']=0;
            $this->db->insert('gm_job_request',$job);
        }
        if($data['status']==2){$schedule['schedule_color']=EXAM_START_COLOR;}
        if($data['status']==3){$schedule['schedule_color']=EXAM_FINISH_COLOR;}
        if($data['status']==4){$schedule['schedule_color']=EXAM_RESULT_PUBLISHED_COLOR;}
        if($data['status']==5){$schedule['schedule_color']=EXAM_CLOSED_COLOR;}
        if($data['status']==-1){$schedule['schedule_color']=EXAM_DEACTIVATED_COLOR;}
        $this->db->where('schedule_link_id', $id)->where('schedule_type', 1)->update('am_schedules', $schedule);
        return $this->db->where('id',$id)->update('gm_exam_schedule',$data);
    }

    public function get_gm_exam_schedule_details($schedule_id){
        return $this->db->select('gm_exam_schedule.*')
                        ->from('gm_exam_schedule')
                        ->join('am_schedules','am_schedules.schedule_link_id=gm_exam_schedule.id')
                        ->where('am_schedules.schedule_type',1)
                        ->where('am_schedules.schedule_status',1)
                        ->where('am_schedules.schedule_id',$schedule_id)
                        ->get()->row_array();
    }

    public function get_new_schedule_preview($preview){
        $data = array();
        $i=0;
        foreach($preview as $row){
            $subject_id = $this->db->where('syllabus_master_detail_id',$row['module_id'])->get('am_syllabus_master_details')->row()->module_master_id; 
            $module =  $this->db->where('subject_id',$subject_id)->get('mm_subjects')->row()->subject_name;
            
            $fac =  $this->db->where('personal_id',$row['staff_id'])->get('am_staff_personal');
            if($fac->num_rows()>0){
                $faculty = $fac->row()->name;
            }else{
                $faculty = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>';
            }
            $rooms =  $this->db->where('room_id',$row['schedule_room'])->get('am_classrooms');
            if($rooms->num_rows()>0){
                $room = $rooms->row()->classroom_name;
            }else{
                $room = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>';
            }
            
            $data[date('d-m-Y D',strtotime($row['schedule_date']))][$i] = array(
                                                    'start_time'=>date('h:i a',strtotime($row['schedule_start_time'])),
                                                    'end_time'=>date('h:i a',strtotime($row['schedule_end_time'])),
                                                    'module'=>$module,
                                                    'faculty'=>$faculty,
                                                    'room'=>$room
                                                );
            $data[date('d-m-Y D',strtotime($row['schedule_date']))][$i]['conflict'] = 0;
            if($row['schedule_status']==3){
                $message = '';
                if($row['staff_id']==0){
                    $message = $message.'<i class="fa fa-times" style="color:red;" aria-hidden="true"> No faculty available for this class.</i>';
                }
                if($row['schedule_room']==0){
                    $message = $message.'<i class="fa fa-times" style="color:red;" aria-hidden="true"> No room available for this class.</i>';
                }
                $data[date('d-m-Y D',strtotime($row['schedule_date']))][$i]['conflict'] = 1;
            }
            if($row['schedule_status']==2){
                $message = '<i class="fa fa-check" style="color:green;" aria-hidden="true"></i> New';
            }
            if($row['schedule_status']==1){
                $message = '<i class="fa fa-check" style="color:green;" aria-hidden="true">Already saved</i>';
            }
            $data[date('d-m-Y D',strtotime($row['schedule_date']))][$i]['message'] = $message;                           
            $i++;
        }
        return $data;
    }

    public function get_batch_schedule_date($batch){
        $query = $this->db->where('schedule_type',2)
                            ->where('schedule_link_id',$batch)
                            ->where('schedule_status !=',0)
                            ->order_by('schedule_id','DESC')
                            ->get('am_schedules');
        if($query->num_rows()>0){
            return $query->row()->schedule_date;
        }else{
            return FALSE;
        }
    }

    public function finish_scheduling($batch){
        $this->db->where('schedule_link_id',$batch) //Delete saved conflicted schedules
                ->where('schedule_type',2)
                ->where('schedule_status',1)
                ->where('(`staff_id`=0 or `schedule_room`=0)')
                ->delete('am_schedules');
        $data['schedule_status']=1;
        return $this->db->where('schedule_type',2)
                        ->where('schedule_link_id',$batch)
                        ->where('schedule_status',2)
                        ->or_where('schedule_status',3)
                        ->update('am_schedules',$data);
    }

    public function get_faculty_module($batch_id,$date,$subject,$module_id,$starttime='',$endtime=''){
        $module = $this->db->where('syllabus_master_detail_id',$module_id)->get('am_syllabus_master_details')->row()->module_master_id;
        $batch_subjects[0] = $subject;
        $faculties = $this->schedule->get_available_faculties($batch_id,$date,$batch_subjects,$starttime,$endtime); // Get all available faculties in that batch center on that date who takes these subjects
        $faculty_modules = $this->schedule->get_faculty_modules($faculties);
        $faculty = array();
        // Get a faculty to take this module
        if(!empty($faculty_modules)){
            foreach($faculty_modules as $staff_id=>$val){
                if(in_array($module,$val['strong_modules'])){
                    array_push($faculty,$staff_id);
                }
            }
            if($faculty==0){
                foreach($faculty_modules as $staff_id=>$val){
                    if(in_array($module,$val['modules'])){
                        array_push($faculty,$staff_id);
                    }
                }
            }
        }
        if(!empty($faculty)){
            return $this->db->select('personal_id as id,name')->where_in('personal_id',$faculty)->get('am_staff_personal')->result_array();
        }else{
            return array();
        }
    }

    public function get_schedule_details($id){
        return $this->db->select('am_syllabus_master_details.subject_master_id as subject_id,
                                am_institute_course_mapping.course_master_id as course_id,
                                am_institute_course_mapping.branch_master_id as branch_id,
                                am_institute_course_mapping.institute_master_id as center_id,
                                am_schedules.*')
                        ->from('am_schedules')
                        ->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                        ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                        ->where('am_schedules.schedule_type',2)
                        ->where('am_schedules.schedule_id',$id)
                        ->get()->row_array();
    }

    public function get_batch_course_color($batch_id){
        return $this->db->select('am_classes.color')
                        ->from('am_batch_center_mapping')
                        ->join('am_institute_course_mapping','am_batch_center_mapping.institute_course_mapping_id=am_institute_course_mapping.institute_course_mapping_id')
                        ->join('am_classes','am_classes.class_id=am_institute_course_mapping.course_master_id')
                        ->where('am_batch_center_mapping.batch_id',$batch_id)
                        ->get()->row_array();
    }

    public function check_batch_schedule_exists($batch_id){
        return $this->db->where('schedule_type',2)->where('schedule_link_id',$batch_id)->get('am_schedules')->num_rows();
    }

    public function deactivate_future_batch_schedules($batch_id){
        $data['schedule_status'] = 0;
        $this->db->where('schedule_type',2)
                ->where('schedule_link_id',$batch_id)
                ->where('schedule_date >',date('Y-m-d',time()))
                ->update('am_schedules',$data);
        $this->db->where('schedule_type',2)
                ->where('schedule_link_id',$batch_id)
                ->where('schedule_date',date('Y-m-d',time()))
                ->where('schedule_start_time >=',date('H:i:s',time()))
                ->update('am_schedules',$data);
    }
    public function get_learning_module_details(){
        return $this->db->select('*')
                        ->where('status',1)
                        ->get('am_learning_module')->result_array();
    }
    public function assign_learning_module_save($data){
        $this->db->where('schedule_id',$data['schedule_id'])
                ->where('status',1)
                ->delete('am_schedule_learning_module');
        return $this->db->insert('am_schedule_learning_module',$data);
    }
    // public function get_selected_learning_module($schedule_id){
    //     return $this->db->select('learning_module_id')
    //                     ->where('status',1)
    //                     ->where('schedule_id',$schedule_id)
    //                     ->from('am_schedule_learning_module')
    //                     ->get()->row()->learning_module_id;
    //                     echo $this->db->last_query(); exit;
    // }

    function is_answers_collected_by_job($id){
        $job = $this->db->where('exam_id',$id)->order_by('id','DESC')->get('gm_job_request')->row();
        if(!empty($job->job_status)){
            if($job->job_status == 3){
                return ['status'=>true,'message'=>''];
            }else{
                if($job->job_status != 4 && $job->job_status != 5){
                    $this->db->insert('gm_job_request',['exam_id'=>$id,'job_status'=>4]);
                    return ['status'=>false,'message'=>'Please wait answer collection is in progress.<br>Answer collection job encountered an error please contact system admin.'];
                }else{
                    return ['status'=>false,'message'=>'Please wait answer collection is in progress.'];
                }
            }
        }else{
            $this->db->insert('gm_job_request',['exam_id'=>$id,'job_status'=>4]);
            return ['status'=>false,'message'=>'Please wait answer collection is in progress.'];
        }
    }

    function is_evaluated_descriptive_questions($id){
        $descriptive_questions_to_evaluate = $this->db->where('question_type',2)
                                                        ->where('exam_id',$id)
                                                        ->where('correct',0)
                                                        ->get('gm_exam_result')->num_rows();
        if($descriptive_questions_to_evaluate > 0){
            return false;
        }else{
            return true;
        }
    }
}
