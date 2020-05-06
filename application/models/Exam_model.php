<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_model_sections(){
        return $this->db->order_by('id','DESC')->get('mm_exam_section_config')->result();
    }

    public function get_rooms_center_branch($center){
        $detail = $this->db->where('institute_master_id',$center)->get('am_institute_course_mapping')->row();
        $this->db->select('am_classrooms.*,am_institute_master.institute_name')
                    ->from('am_classrooms')
                    ->join('am_institute_master','am_institute_master.institute_master_id=am_classrooms.institute_master_id')
                    ->where('am_classrooms.status',1);
        if(!empty($detail)){ $this->db->where('am_classrooms.branch_master_id',$detail->branch_master_id); }
        return $this->db->get()->result();
    }

    public function get_centers(){
        return $this->db->where(array('institute_type_id'=>3,'status'=>1))->get('am_institute_master')->result();
    }

    public function get_model_section($id){
        return $this->db->where('id',$id)->get('mm_exam_section_config')->row();
    }

    public function get_model_section_detail($id){
        return $this->db->where('exam_section_config_id',$id)->get('mm_exam_section_details')->result();
    }

    public function get_section($id){
        return $this->db->where('id',$id)->get('gm_exam_section_config')->row();
    }

    public function get_section_detail($id){
        return $this->db->select('gm_exam_section_details.*')->from('gm_exam_section_details')
                        ->join('gm_exam_section_config_details','gm_exam_section_config_details.details_id=gm_exam_section_details.id')
                        ->where('gm_exam_section_config_details.exam_section_config_id',$id)->get()->result();
    }

    public function get_exam_model($id){
        return $this->db->where('id',$id)->get('gm_exam_definition')->row();
    }

    public function get_exam_schedule_from_calendar($id){
        return $this->db->select('am_institute_course_mapping.institute_master_id,am_schedules.schedule_id,am_schedules.schedule_room,gm_exam_schedule.*')
                        ->from('am_schedules')
                        ->join('gm_exam_schedule','gm_exam_schedule.id=am_schedules.schedule_link_id')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=gm_exam_schedule.batch_id')
                        ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                        ->where('am_schedules.schedule_id',$id)
                        ->get()->row();
    }

    public function add_exam_schedule($schedule_data){
        $this->db->insert('gm_exam_schedule',$schedule_data);
        return $this->db->insert_id();
    }

    public function update_exam_schedule($schedule_data,$schedule_id){
        return $this->db->where('id',$schedule_id)->update('gm_exam_schedule',$schedule_data);
    }

    public function delete_exam_scheduled_question_papers($schedule_id){
        return $this->db->where('exam_schedule_id',$schedule_id)->delete('gm_exam_question_paper');
    }

    public function add_exam_schedule_papers($schedule_paper_data){
        return $this->db->insert_batch('gm_exam_question_paper',$schedule_paper_data);
    }

    public function add_exam_schedule_calendar($calendar_data){
        return $this->db->insert('am_schedules',$calendar_data);
    }
    
    public function update_exam_schedule_calendar($calendar_data,$calendar_schedule_id){
        return $this->db->where('schedule_id',$calendar_schedule_id)->update('am_schedules',$calendar_data);
    }

    public function get_exam_section($id){
        return $this->db->select('gm_exam_section_config.*')->from('gm_exam_section_config')
                        ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_sections_id=gm_exam_section_config.id')
                        ->where('gm_exam_definition_exam_sections.exam_definition_id',$id)
                        ->get()->result();
    }
    
    public function get_exam_templates() {
        return $this->db->select('gm_exam_definition.* , count(gm_exam_definition_exam_sections.exam_definition_id) as sections')
                        ->from('gm_exam_definition')
                        ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_definition_id=gm_exam_definition.id','LEFT')
                        ->where('gm_exam_definition.record_status !=',3)
                        ->order_by('gm_exam_definition.id','DESC')
                        ->group_by('gm_exam_definition_exam_sections.exam_definition_id')->get()->result();
    }
    
    public function get_exam_templates_for_question_papers() {
        return $this->db->select('gm_exam_definition.* , count(gm_exam_definition_exam_sections.exam_definition_id) as sections')
                        ->from('gm_exam_definition')
                        ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_definition_id=gm_exam_definition.id','LEFT')
                        ->where('gm_exam_definition.record_status',2)
                        ->group_by('gm_exam_definition_exam_sections.exam_definition_id')->get()->result();
    }

    public function save_exam_description($exam_deff,$sess_data,$presections){
        $this->db->trans_start();
        $this->db->insert('gm_exam_definition',$exam_deff);
        $exam_id = $this->db->insert_id();
        $this->db->insert_batch('gm_exam_section_config',$sess_data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        $count = count($sess_data);
        for($i=0;$i<$count;$i++){
            $sec_id[$i] = $id;
            $exam_sess_map[$i] = array(
                'exam_definition_id'=>$exam_id,
                'exam_sections_id'=>$id,
            );
            $id++;
        }
        $this->db->insert_batch('gm_exam_definition_exam_sections',$exam_sess_map);
        $this->db->trans_rollback();
        if(!empty($presections)){
            foreach($sec_id as $key=>$val){
                if(!empty($presections[$key])){
                    $detail = $this->db->where('exam_section_config_id',$presections[$key])->get('mm_exam_section_details')->result();
                    if(!empty($detail)){
                        $data = array();
                        foreach($detail as $k=>$row){
                            $data[$k] = array(
                                "mark_per_question"=>$row->mark_per_question,
                                "negative_mark_per_question"=>$row->negative_mark_per_question,
                                "no_of_questions"=>0,
                                "subject_id"=>$row->subject_id,
                                "version"=>$row->version
                            );
                        }
                        $this->db->insert_batch('gm_exam_section_details',$data);
                        $id = $this->db->insert_id();
                        $this->db->trans_complete();
                        $count = count($data);
                        $sess_detail_map = array();
                        for($i=0;$i<$count;$i++){
                            $sess_detail_map[$i] = array(
                                'exam_section_config_id'=>$val,
                                'details_id'=>$id,
                            );
                            $id++;
                        }
                        $this->db->insert_batch('gm_exam_section_config_details',$sess_detail_map);
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return $exam_id;
        }
    }

    public function get_exam_section_details($detail_ids){
        return $this->db->where_in('id',$detail_ids)->get('gm_exam_section_details')->result();
    }

    public function delete_section($id){
        if($this->db->where('exam_section_config_id',$id)->delete('mm_exam_section_details')){
            return $this->db->where('id',$id)->delete('mm_exam_section_config');
        }else{
            return FALSE;
        }
    }

    public function update_exam_section_config($section){
        return $this->db->update_batch('gm_exam_section_config',$section,'id');
    }

    public function update_exam_section_detail($detail){
        return $this->db->update_batch('gm_exam_section_details',$detail,'id');
    }

    public function get_questionsets(){
        return $this->db->where('question_set_status',1)->get('mm_question_set')->result();
    }

    public function get_modules_from_subjectid($id){
        return $this->db->where('parent_subject',$id)
                        ->where('subject_status',1)
                        ->where('subject_type_id','Module')
                        ->get('mm_subjects')->result();
    }

    public function save_section_detail_config($section_name,$data){
        $this->db->trans_start();
        $section['section_name'] = $section_name;
        $this->db->insert('mm_exam_section_config',$section);
        $id = $this->db->insert_id();
        foreach($data as $key=>$val){
            $data[$key]['exam_section_config_id'] = $id;
        }
        $this->db->insert_batch('mm_exam_section_details',$data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return $id;
        }
    }
    
    public function update_section_detail_config($section_data,$detail_data,$section_id){
        $this->db->trans_start();
        $this->db->update_batch('mm_exam_section_config',$section_data,'id');
        $this->db->where('exam_section_config_id',$section_id)->delete('mm_exam_section_details');
        $this->db->insert_batch('mm_exam_section_details',$detail_data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_batch_in_date_center($date,$center){
        return $this->db->select('am_batch_center_mapping.*')
                        ->from('am_batch_center_mapping')
                        ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                        ->where('am_batch_center_mapping.batch_datefrom <=',$date)
                        ->where('am_batch_center_mapping.batch_dateto >=',$date)
                        ->where('am_institute_course_mapping.institute_master_id',$center)
                        ->where('am_institute_course_mapping.status',1)
                        ->where('am_batch_center_mapping.batch_status',1)
                        ->get()->result();
    }

    public function get_external_candidate_batch_in_date_center($date,$center){
        return $this->db->select('am_batch_center_mapping.*')
                        ->from('am_batch_center_mapping')
                        ->where('am_batch_center_mapping.batch_datefrom <=',$date)
                        ->where('am_batch_center_mapping.batch_dateto >=',$date)
                        ->where('am_batch_center_mapping.batch_status',-1)
                        ->get()->result();
    }

    public function get_all_exam_papers(){
        return $this->db->select('gm_exam_paper.*,gm_exam_definition.exam_name')
                        ->from('gm_exam_paper')
                        ->join('gm_exam_definition','gm_exam_definition.id=gm_exam_paper.exam_definition_id')
                        ->where('gm_exam_paper.record_status!=',0)
                        ->order_by('gm_exam_paper.id','DESC')
                        ->get()->result();
    }

    public function get_exam_papers($exammodel){
        return $this->db->where('exam_definition_id',$exammodel)
                        ->where('record_status',1)
                        ->get('gm_exam_paper')->result();
    }

    public function create_question_paper($data){
        $this->db->insert('gm_exam_paper',$data);
        return $this->db->insert_id();
    }

    public function delete_question_paper($question_paper_id){
        $data['record_status']=0;
        $this->db->where('id',$question_paper_id)->update('gm_exam_paper',$data);
    }

    public function delete_exam_paper($exam_id){
        $data['record_status']=3;
        $this->db->where('id',$exam_id)->update('gm_exam_definition',$data);
    }

    public function get_question_paper($id){
        return $this->db->select('gm_exam_definition.exam_name,gm_exam_paper.*')
                        ->from('gm_exam_paper')
                        ->join('gm_exam_definition','gm_exam_definition.id=gm_exam_paper.exam_definition_id')
                        ->where('gm_exam_paper.record_status!=',0)
                        ->where('gm_exam_paper.id',$id)
                        ->get()->row();
    }

    public function get_question_paper_questions($id){
        return $this->db->select('gm_exam_paper_questions.*,mm_question.*,gm_exam_section_config.section_name,gm_exam_section_config.id as sectionId')
                        ->from('gm_exam_paper_questions')
                        ->join('mm_question','mm_question.question_id=gm_exam_paper_questions.question_id')
                        ->join('gm_exam_section_config_details','gm_exam_section_config_details.details_id=gm_exam_paper_questions.exam_section_details_id')
                        ->join('gm_exam_section_config','gm_exam_section_config.id=gm_exam_section_config_details.exam_section_config_id')
                        ->where('gm_exam_paper_questions.exam_paper_id',$id)
                        ->where('gm_exam_paper_questions.status',1)
                        ->order_by('gm_exam_paper_questions.question_number','ASC')
                        ->get()->result();
    }

    public function check_duplicate_paper_name($name){
        $query = $this->db->where('exam_paper_name',$name)->where('record_status !=',0)->get('gm_exam_paper');
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function get_model_sections_by_model_id($id){
        return $this->db->select('gm_exam_section_config.*')
                        ->from('gm_exam_section_config')
                        ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_sections_id=gm_exam_section_config.id')
                        ->where('gm_exam_definition_exam_sections.exam_definition_id',$id)
                        ->get()->result();
    }

    public function get_exam_section_questions($section_id,$exam_id,$module_id){
        $subject_ids = $this->db->where('id',$module_id)->get('gm_exam_section_details')->result();
        if(!empty($subject_ids)){
            foreach($subject_ids as $k=>$val){
                $ids[$k]=$val->subject_id;
            }
        }
        $questions = $this->db->select('mm_subjects.subject_name,
                                        mm_question.question_difficulty,
                                        mm_question.question_id,
                                        mm_question.question_content,
                                        mm_question.paragraph_id,
                                        mm_question.question_set_id,
                                        mm_question_set.question_set_name,
                                        mm_question.question_type')
                                ->from('mm_question')
                                ->join('mm_question_set','mm_question_set.question_set_id=mm_question.question_set_id')
                                ->join('mm_material','mm_material.material_id=mm_question_set.material_id')
                                ->join('mm_subjects','mm_subjects.subject_id=mm_material.subject_id')
                                ->where_in('mm_material.subject_id',$ids)
                                ->where_in('mm_question.question_status','1')
                                ->order_by('mm_question.paragraph_id','ASC')
                                ->get()->result_array();

        $selected_questions = $this->db->select('mm_question.question_difficulty,
                                                mm_question.question_id,
                                                mm_question.question_content,
                                                mm_question.question_set_id,
                                                mm_question.paragraph_id,
                                                mm_question.question_type,
                                                gm_exam_paper_questions.question_number,
                                                gm_exam_paper_questions.id')
                                        ->from('gm_exam_paper_questions')
                                        ->join('gm_exam_section_config_details','gm_exam_section_config_details.details_id=gm_exam_paper_questions.exam_section_details_id')
                                        ->join('mm_question','mm_question.question_id=gm_exam_paper_questions.question_id')
                                        ->where('gm_exam_section_config_details.exam_section_config_id',$section_id)
                                        ->where('gm_exam_paper_questions.exam_paper_id',$exam_id)
                                        ->where('gm_exam_paper_questions.exam_section_details_id',$module_id)
                                        ->where('gm_exam_paper_questions.status',1)
                                        ->order_by('gm_exam_paper_questions.question_number','ASC')
                                        ->get()->result_array();
                                        
        $overall_selected_questions = $this->db->select('mm_question.question_id')
                                                ->from('gm_exam_paper_questions')
                                                ->join('mm_question','mm_question.question_id=gm_exam_paper_questions.question_id')
                                                ->where('gm_exam_paper_questions.exam_paper_id',$exam_id)
                                                ->where('gm_exam_paper_questions.status',1)
                                                ->order_by('gm_exam_paper_questions.question_number','ASC')
                                                ->get()->result_array();
        
        $existing_questions = [];
        if(!empty($overall_selected_questions)){
            foreach($overall_selected_questions as $row){
                array_push($existing_questions,$row['question_id']);
            }
        }
        if(!empty($questions)){
            foreach($questions as $k=>$v){
                $questions[$k]['selected']=0;
                if(!empty($selected_questions)){
                    foreach($selected_questions as $row){
                        if($v['question_id']==$row['question_id']){
                            $questions[$k]['selected']=1;
                        }
                    }
                }
                if(!empty($existing_questions)){
                    if($questions[$k]['selected']==0 && in_array($v['question_id'],$existing_questions)){
                        unset($questions[$k]);
                    }
                }
            }
        }
        $data['questions'] = $questions;
        $data['selected_questions'] = $selected_questions;
        return $data;
    }

    public function delete_selected_question($id,$exam_id){
        $data['status']=2;
        $this->db->where('id',$id)->update('gm_exam_paper_questions',$data);
        $exam_paper['record_status']=2;
        $this->db->where('id',$exam_id)->update('gm_exam_paper',$exam_paper);
        return $this->db->select('mm_question.question_id')
                        ->from('mm_question')
                        ->join('gm_exam_paper_questions','gm_exam_paper_questions.question_id=mm_question.question_id')
                        ->where('gm_exam_paper_questions.id',$id)
                        ->get()->row();
    }

    public function reorder_exam_paper_questions_after_question_delete($exam_id,$question_id){
        $section_id = $this->db->select('gm_exam_section_config_details.exam_section_config_id')
                                ->from('gm_exam_section_config_details')
                                ->join('gm_exam_paper_questions','gm_exam_paper_questions.exam_section_details_id=gm_exam_section_config_details.details_id')
                                ->where('gm_exam_paper_questions.exam_paper_id',$exam_id)
                                ->where('gm_exam_paper_questions.question_id',$question_id)
                                ->get()->row();
        $details = $this->db->where('exam_section_config_id',$section_id->exam_section_config_id)->get('gm_exam_section_config_details')->result();
        $exam_section_details_id=array();
        foreach($details as $k=>$v){
            $exam_section_details_id[$k]=$v->details_id;
        }
        $questions = $this->db->where('exam_paper_id',$exam_id)
                                ->where('status',1)
                                ->where_in('exam_section_details_id',$exam_section_details_id)
                                ->order_by('question_number','ASC')
                                ->get('gm_exam_paper_questions')->result();
        if(!empty($questions)){
            $data=array();
            foreach($questions as $k=>$v){
                $data[$k]=array(
                    'id'=>$v->id,
                    'question_number'=>$k+1
                );
            }
            $this->db->update_batch('gm_exam_paper_questions',$data,'id');
        }
    }

    public function get_exam_section_details_per_section($section_id){
        return $this->db->select('mm_subjects.subject_name,gm_exam_section_details.id,gm_exam_section_details.no_of_questions,gm_exam_section_details.subject_id,gm_exam_section_config_details.exam_section_config_id as section_id')
                        ->from('gm_exam_section_details')
                        ->join('gm_exam_section_config_details','gm_exam_section_details.id=gm_exam_section_config_details.details_id','left')
                        ->join('mm_subjects','mm_subjects.subject_id=gm_exam_section_details.subject_id','left')
                        ->where('gm_exam_section_config_details.exam_section_config_id',$section_id)
                        ->get()->result_array();
    }

    public function get_exam_section_details_per_exam_paper($exam_paper_id){
        return $this->db->select('gm_exam_section_config.id as section_id,gm_exam_section_config.section_name,gm_exam_section_details.id,gm_exam_section_details.no_of_questions,mm_subjects.subject_name')
                        ->from('gm_exam_section_details')
                        ->join('mm_subjects','mm_subjects.subject_id=gm_exam_section_details.subject_id')
                        ->join('gm_exam_section_config_details','gm_exam_section_config_details.details_id=gm_exam_section_details.id')
                        ->join('gm_exam_section_config','gm_exam_section_config.id=gm_exam_section_config_details.exam_section_config_id')
                        ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_sections_id=gm_exam_section_config_details.exam_section_config_id')
                        ->join('gm_exam_definition','gm_exam_definition.id=gm_exam_definition_exam_sections.exam_definition_id')
                        ->join('gm_exam_paper','gm_exam_paper.exam_definition_id=gm_exam_definition.id')
                        ->where('gm_exam_paper.id',$exam_paper_id)
                        ->get()->result_array();
    }

    public function get_new_question_ids($qids,$exam_paper_id,$module_id){
        $questions = $this->db->select('question_id')
                                ->where('exam_paper_id',$exam_paper_id)
                                ->where('exam_section_details_id',$module_id)
                                ->where('status',1)
                                ->get('gm_exam_paper_questions')->result();
        $new_questions = $qids;
        if(!empty($questions)){
            $new_questions = array();
            foreach($questions as $k=>$v){
                $qtns[$k] = $v->question_id;
            }
            $i=0;
            foreach($qids as $row){
                if(!in_array($row,$qtns)){
                    $new_questions[$i] = $row;
                    $i++;
                }
            }
        }
        return $new_questions;
    }

    public function get_question_subjects($qids){
        return $this->db->select('mm_question.question_id,mm_material.subject_id')
                        ->from('mm_question')
                        ->join('mm_question_set','mm_question_set.question_set_id=mm_question.question_set_id','left')
                        ->join('mm_material','mm_material.material_id=mm_question_set.material_id','left')
                        ->where_in('mm_question.question_id',$qids)
                        ->get()->result_array();
    }

    public function get_last_question_number($exam_paper_id,$module_id){
        $query = $this->db->where('exam_paper_id',$exam_paper_id)
                            ->where_in('exam_section_details_id',$module_id)
                            ->where('status',1)
                            ->order_by('question_number','DESC')
                            ->get('gm_exam_paper_questions');
        if($query->num_rows() > 0){
            return $query->row()->question_number;
        }else{
            return 0;
        }
    }

    public function save_exam_paper_section_questions($exam_paper_id,$module_id,$delete_qids,$data){
        $this->db->trans_start();
        if(!empty($delete_qids)){
            $this->db->where('exam_paper_id',$exam_paper_id)
                     ->where('exam_section_details_id',$module_id)
                     ->where_in('question_id',$delete_qids)
                     ->delete('gm_exam_paper_questions');
        }
        if(!empty($data)){
            $this->db->insert_batch('gm_exam_paper_questions',$data);
        }
        $exam_paper['record_status']=2;
        $this->db->where('id',$exam_paper_id)->update('gm_exam_paper',$exam_paper);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function reorder_exam_paper_questions($exam_paper_id,$section_id){
        $questions = $this->db->where('exam_paper_id',$exam_paper_id)
                                ->where_in('exam_section_details_id',$section_id)
                                ->where('status',1)
                                ->order_by('question_number','ASC')
                                ->get('gm_exam_paper_questions')->result();
        $qids = array();
        foreach($questions as $k=>$row){
            $qids[$k] = $row->question_id;
        }
        $ques_details = $this->db->select('question_id,paragraph_id')->where_in('question_id',$qids)->get('mm_question')->result();
        $qstnKs = array();
        $paraKs = array();
        foreach($ques_details as $row){
            $qstnKs[$row->question_id] = $row->paragraph_id;
            if(isset($paraKs[$row->paragraph_id])){
                if(!in_array($row->question_id,$paraKs[$row->paragraph_id])){
                    array_push($paraKs[$row->paragraph_id],$row->question_id);
                }
            }else{
                $paraKs[$row->paragraph_id] = array();
                array_push($paraKs[$row->paragraph_id],$row->question_id);
            }
        }
        $ordered = array();
        foreach($qids as $q){
            if(!in_array($q,$ordered)){
                if(isset($paraKs[$qstnKs[$q]]) && !empty($paraKs[$qstnKs[$q]])){
                    foreach($paraKs[$qstnKs[$q]] as $qs){
                        if(!in_array($qs,$ordered)){
                            array_push($ordered,$qs);
                        }
                    }
                }else{
                    array_push($ordered,$q);
                }
            }
        }
        $data = array();
        if(!empty($ordered)){
            foreach($ordered as $key=>$val){
                $number = $key+1;
                array_push($data,array(
                                        'question_id'=>$val,
                                        'question_number'=>$number
                                    ));
            }
        }
        $this->db->where('exam_paper_id',$exam_paper_id)
                    ->where_in('exam_section_details_id',$section_id)
                    ->update_batch('gm_exam_paper_questions',$data,'question_id');
    }

    public function finish_creating_question_paper($exam_paper_id, $approvel_user){
        if($approvel_user !=0 ){
            $data['record_status']=100;
        }else{
            $data['record_status']=1;
        }
        $this->db->where('id',$exam_paper_id)->update('gm_exam_paper',$data);
    }

    public function get_exam_details_questions($exam_paper_id,$details_id){
        return $this->db->where('exam_paper_id',$exam_paper_id)
                                ->where_in('exam_section_details_id',$details_id)
                                ->where('status',1)
                                ->get('gm_exam_paper_questions')->result_array();
    }

    public function update_exam_model($id,$data){
        $sections = $this->db->select('gm_exam_section_config.*')
                            ->from('gm_exam_section_config')
                            ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_sections_id=gm_exam_section_config.id')
                            ->where('gm_exam_definition_exam_sections.exam_definition_id',$id)
                            ->get()->result_array();
        $data['duration_in_min'] = 0;
        foreach($sections as $row){
            $data['duration_in_min'] = $data['duration_in_min']+$row['duration_in_min'];
        }
        return $this->db->where('id',$id)->update('gm_exam_definition',$data);
    }

    public function get_exam_model_save_preview($id){
        return $this->db->select('gm_exam_definition.exam_name,gm_exam_definition.instructions,gm_exam_definition.instrct_avail,gm_exam_definition.calc_avail,
                                    gm_exam_section_config.section_name,gm_exam_section_details.*,mm_subjects.subject_name')
                        ->from('gm_exam_section_details')
                        ->join('mm_subjects','mm_subjects.subject_id=gm_exam_section_details.subject_id')
                        ->join('gm_exam_section_config_details','gm_exam_section_config_details.details_id=gm_exam_section_details.id')
                        ->join('gm_exam_section_config','gm_exam_section_config.id=gm_exam_section_config_details.exam_section_config_id')
                        ->join('gm_exam_definition_exam_sections','gm_exam_definition_exam_sections.exam_sections_id=gm_exam_section_config.id')
                        ->join('gm_exam_definition','gm_exam_definition.id=gm_exam_definition_exam_sections.exam_definition_id')
                        ->where('gm_exam_definition.id',$id)
                        ->get()->result();
    }

    public function finish_exam_model_creation($id){
        $data['record_status']=2;
        return $this->db->where('id',$id)->update('gm_exam_definition',$data);
    }

    public function get_section_modules($section_id){
        return $this->db->select('gm_exam_section_details.id as module_id,mm_subjects.subject_name as module_name,gm_exam_section_details.mark_per_question as mark')
                        ->from('gm_exam_section_config_details')
                        ->join('gm_exam_section_details','gm_exam_section_details.id=gm_exam_section_config_details.details_id')
                        ->join('mm_subjects','mm_subjects.subject_id=gm_exam_section_details.subject_id')
                        ->where('gm_exam_section_config_details.exam_section_config_id',$section_id)
                        ->get()->result_array();
    }

    public function check_examname($examname,$id=0){
        return $this->db->like('exam_name',$examname,'none')
                        ->where('id !=',$id)
                        ->where('record_status !=',3)
                        ->get('gm_exam_definition')->num_rows();
    }

    public function scheduled_question_papers($id){
        return $this->db->where('question_paper_id',$id)->get('gm_exam_question_paper')->result();
    }

    public function get_exam_model_modules($exam_model){
        return $this->db->select('gm_exam_section_details.id as exam_section_details_id,
                            gm_exam_section_details.mark_per_question,
                            gm_exam_section_details.negative_mark_per_question,
                            gm_exam_section_details.no_of_questions,
                            subject.subject_name as subject_name,
                            module.subject_name as module_name,
                            module.subject_id as module_id,
                            gm_exam_section_config.section_name')
                        ->from('gm_exam_definition_exam_sections')
                        ->join('gm_exam_section_config_details','gm_exam_section_config_details.exam_section_config_id=gm_exam_definition_exam_sections.exam_sections_id')
                        ->join('gm_exam_section_details','gm_exam_section_details.id=gm_exam_section_config_details.details_id')
                        ->join('mm_subjects as module','module.subject_id=gm_exam_section_details.subject_id')
                        ->join('mm_subjects as subject','module.parent_subject=subject.subject_id')
                        ->join('gm_exam_section_config','gm_exam_section_config.id=gm_exam_definition_exam_sections.exam_sections_id')
                        ->where('gm_exam_definition_exam_sections.exam_definition_id',$exam_model)
                        ->get()->result_array();
    }

    public function get_module_questions($subject_id,$difficulty){
        return $this->db->select('mm_question.*')
                        ->from('mm_question')
                        ->join('mm_question_set','mm_question_set.question_set_id=mm_question.question_set_id')
                        ->where('mm_question.question_difficulty',$difficulty)
                        ->where('mm_question_set.subject_id',$subject_id)
                        ->where('mm_question.question_status',1)
                        ->get()->result();
    }

    public function get_questions($question_ids){
        return $this->db->where_in('question_id',$question_ids)->get('mm_question')->result();
    }

    public function save_exam_paper_questions($data){
        return $this->db->insert_batch('gm_exam_paper_questions',$data);
    }

    public function get_levelOne_user($entityId){
        return $this->db->select('approval_flow_entity_details.*,
                            am_users_backoffice.user_name,
                            am_users_backoffice.user_role,
                            am_users_backoffice.registration_number')
                         ->from('approval_flow_entity_details')
                         ->join('am_users_backoffice','am_users_backoffice.user_id=approval_flow_entity_details.user_id')
                         ->where('approval_flow_entity_details.level',1)
                         ->where('approval_flow_entity_details.status',1)
                         ->where('approval_flow_entity_details.flow_entities',$entityId)
                         ->get()->result();
    }
    public function get_approve_statusEP($id){
        return $this->db->select('approval_flow_jobs.*,
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
                         ->get()->result();
    }
    public function get_passage_content($passage_id){
        return $this->db->where('paragraph_id',$passage_id)->get('mm_question_paragraph')->row();
    }

    public function get_question_content($question_id){
        return $this->db->where('question_id',$question_id)->get('mm_question')->row();
    }

    public function get_question_options($question_id){
        return $this->db->where('question_id',$question_id)->get('mm_question_option')->result();
    }
    public function get_full_question($question_id){
        $data['question'] = $this->get_question_content($question_id);
        $data['passage'] = $this->get_passage_content($data['question']->paragraph_id);
        $data['options'] = $this->get_question_options($question_id);
        return $data;
    }
    function update_exam_paper_questions($data){
        return $this->db->update_batch('gm_exam_paper_questions',$data,'id');
    }

/******************** Exam valuation **********************************************************************/

    public function get_exam_valuation(){
        return $this->db->select('gm_exam_schedule.*,am_batch_center_mapping.batch_name,am_institute_master.institute_name')
                        ->from('gm_exam_schedule')
                        ->join('gm_exam_question_paper','gm_exam_question_paper.exam_schedule_id=gm_exam_schedule.id')
                        ->join('gm_exam_paper_questions','gm_exam_paper_questions.exam_paper_id=gm_exam_question_paper.question_paper_id')
                        ->join('mm_question','mm_question.question_id=gm_exam_paper_questions.question_id')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=gm_exam_schedule.batch_id')
                        ->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                        ->join('am_institute_master','am_institute_master.institute_master_id=am_institute_course_mapping.institute_master_id')
                        ->where('gm_exam_schedule.status >=',3)
                        ->where('mm_question.question_type',2)
                        ->where('gm_exam_paper_questions.status',1)
                        ->group_by('gm_exam_schedule.id')
                        ->order_by('gm_exam_schedule.status','ASC')
                        ->order_by('gm_exam_schedule.id','DESC')
                        ->get()->result();
    }

    public function exam_descriptive_questions($id){
        return $this->db->select('gm_exam_schedule.*,gm_exam_paper_questions.question_id,gm_exam_paper_questions.question_number
                            ,mm_question.question_content,module.subject_name as module_name,subject.subject_name as subject_name')
                         ->from('gm_exam_schedule')
                         ->join('gm_exam_question_paper','gm_exam_question_paper.exam_schedule_id=gm_exam_schedule.id')
                         ->join('gm_exam_paper_questions','gm_exam_paper_questions.exam_paper_id=gm_exam_question_paper.question_paper_id')
                         ->join('mm_question','mm_question.question_id=gm_exam_paper_questions.question_id')
                         ->join('mm_question_set','mm_question_set.question_set_id=mm_question.question_set_id')
                         ->join('mm_material','mm_material.subject_id=mm_question_set.subject_id')
                         ->join('mm_subjects as module','module.subject_id=mm_question_set.subject_id')
                         ->join('mm_subjects as subject','subject.subject_id=module.parent_subject')
                         ->where('gm_exam_question_paper.exam_schedule_id',$id)
                         ->where('mm_question.question_type',2)
                         ->where('gm_exam_schedule.status >=',3)
                         ->where('gm_exam_paper_questions.status',1)
                         ->group_by('gm_exam_paper_questions.id')
                         ->get()->result();
    }
    public function get_QuestionAndGivenAnswer($id, $questionId = NULL){
        $data['answers'] = $this->db->select('gm_exam_result.*,gm_exam_schedule.status as exam_schedule_status')
                                    ->from('gm_exam_result')
                                    ->join('gm_exam_schedule','gm_exam_schedule.id=gm_exam_result.exam_id')
                                    ->where('gm_exam_result.question_id',$questionId)
                                    ->where('gm_exam_result.question_type',2)
                                    ->where('gm_exam_result.exam_id',$id)
                                    ->get()->result();
        if(!empty($data['answers'])){
            foreach($data['answers'] as $k=>$row){
                if($row->correct){
                    $user_id = $this->db->where('attempt',$row->attempt)
                                        ->where('exam_id',$row->exam_id)
                                        ->where('question_id',$row->question_id)
                                        ->where('student_id',$row->student_id)
                                        ->order_by('id','DESC')
                                        ->get('gm_exam_result_evaluation_log')->row()->user_id;
                    $data['answers'][$k]->evaluated_by = $this->db->where('user_id',$user_id)->get('am_users_backoffice')->row()->user_name;
                }else{
                    $data['answers'][$k]->evaluated_by = '';
                }
            }
        }
        $data['question'] = $this->db->where('question_id',$questionId)
                                    ->get('mm_question')->row();
        $data['passage'] = '';
        if($data['question']->paragraph_id!=0){
            $data['passage'] = $this->db->where('paragraph_id',$data['question']->paragraph_id)
                                        ->get('mm_question_paragraph')->row()->paragraph_content;
        }
        return $data;
    }

    function get_answer_evaluate($attempt,$exam_id,$question_id,$student_id){
        $answer = $this->db->where('attempt',$attempt)
                            ->where('exam_id',$exam_id)
                            ->where('question_id',$question_id)
                            ->where('student_id',$student_id)
                            ->get('gm_exam_result')->row();
        $data['attempt'] = $answer->attempt;
        $data['exam_id'] = $answer->exam_id;
        $data['question_id'] = $answer->question_id;
        $data['student_id'] = $answer->student_id;
        $data['actual_mark'] = $answer->actual_mark;
        $data['mark'] = $answer->mark;
        $data['answer'] = $answer->selected_choices;
        $question = $this->db->where('question_id',$question_id)->get('mm_question')->row();
        $data['question'] = $question->question_content;
        $data['question_solution'] = $question->question_solution;
        $data['passage'] = '';
        if($question->paragraph_id!=0){
            $data['passage'] = $this->db->where('paragraph_id',$question->paragraph_id)
                                        ->get('mm_question_paragraph')->row()->paragraph_content;
        }
        return $data;
    }

    function save_answer_evaluate($attempt,$exam_id,$question_id,$student_id,$mark){
        $stat = $this->db->where('attempt',$attempt)
                        ->where('exam_id',$exam_id)
                        ->where('question_id',$question_id)
                        ->where('student_id',$student_id)
                        ->update('gm_exam_result',['mark'=>$mark,'correct'=>1]);
        if($stat){
            return $this->db->insert('gm_exam_result_evaluation_log',array(
                                        'attempt'=>$attempt,
                                        'exam_id'=>$exam_id,
                                        'question_id'=>$question_id,
                                        'student_id'=>$student_id,
                                        'user_id'=>(int)$this->session->userdata('user_primary_id'),
                                        'mark'=>$mark
                                    ));
        }else{return false;}
    }
}
