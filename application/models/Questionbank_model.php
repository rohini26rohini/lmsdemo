<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questionbank_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_subjects(){
        return $this->db->where('subject_type_id','Subject')->where('subject_status',1)->get('mm_subjects')->result();
    }
    
    public function get_module($sub){
        return $this->db->where('parent_subject',$sub)->where('subject_type_id','Module')->where('subject_status',1)->get('mm_subjects')->result();
    }

    public function get_questionsets(){
        return $this->db->where('question_set_status !=',2)->get('mm_question_set')->result();
    }

    public function insert_question($question){
        $this->db->insert('mm_question',$question);
        return $this->db->insert_id();
    }

    public function update_question($question,$question_id){
        return $this->db->where('question_id',$question_id)->update('mm_question',$question);
    }

    public function insert_option($option,$question_id){
        $this->db->where('question_id',$question_id)->delete('mm_question_option');
        return $this->db->insert_batch('mm_question_option',$option);
    }

    public function get_paragraphs(){
        return $this->db->where('paragraph_status',1)->get('mm_question_paragraph')->result();
    }

    public function get_passage($passage_id){
        return $this->db->where('paragraph_id',$passage_id)->get('mm_question_paragraph')->row_array();
    }

    public function insert_passage($data){
        $this->db->insert('mm_question_paragraph',$data);
        return $this->db->insert_id();
    }

    public function update_passage($paragraph,$paragraph_id){
        return $this->db->where('paragraph_id',$paragraph_id)->update('mm_question_paragraph',$paragraph);
    }

    public function get_question_set_passages_id($question_set){
        return $this->db->select('mm_question_paragraph.*,mm_question_paragraph.paragraph_id as id')->where('question_set_id',$question_set)->get('mm_question_paragraph')->result();
    }

    public function get_question_material(){
        return $this->db->where('material_status',1)->where('material_type','question')->get('mm_material')->result();
    }

    public function get_question_set_material($material){
        return $this->db->where('material_id',$material)->where('question_set_status',1)->get('mm_question_set')->result();
    }

    public function get_question_usages($question_id){
        return $this->db->select('gm_exam_paper.*,gm_exam_paper_questions.question_number,mm_question.question_content')->from('gm_exam_paper')
                        ->join('gm_exam_paper_questions','gm_exam_paper_questions.exam_paper_id=gm_exam_paper.id')
                        ->join('mm_question','gm_exam_paper_questions.question_id=mm_question.question_id')
                        ->where('gm_exam_paper_questions.question_id',$question_id)
                        ->where('gm_exam_paper.record_status !=',0)
                        ->get()->result();
    }

    public function get_questions($question_set){
        $passaged_questions = $this->db->select('mm_question.*,mm_question_paragraph.paragraph_content')
                                        ->from('mm_question')
                                        ->join('mm_question_paragraph','mm_question_paragraph.paragraph_id=mm_question.paragraph_id')
                                        ->where(array('mm_question.question_set_id'=>$question_set,'mm_question.question_status'=>1))
                                        ->get()->result();
        $nonpassaged_questions = $this->db->where(array('mm_question.question_set_id'=>$question_set,'mm_question.question_status'=>1))
                                            ->where('paragraph_id',0)
                                            ->or_where('paragraph_id',NULL)
                                            ->get('mm_question')->result();
        $questions = array_merge($passaged_questions,$nonpassaged_questions);
        $return['questions'] = array();
        foreach($questions as $k=>$v){
            $return['questions'][$v->question_id] = $v;
        }
        if(!empty($return['questions'])){
            krsort($return['questions']);
        }
        $delete_protected_questions = $this->db->select('gm_exam_paper_questions.question_id as id')//->get('gm_exam_paper_questions')->result();
                                                ->from('mm_question')
                                                ->join('gm_exam_paper_questions','gm_exam_paper_questions.question_id=mm_question.question_id')
                                                ->join('gm_exam_paper','gm_exam_paper.id=gm_exam_paper_questions.exam_paper_id')
                                                ->where(array('mm_question.question_set_id'=>$question_set,'mm_question.question_status'=>1,'gm_exam_paper_questions.status'=>1,'gm_exam_paper.record_status !='=>0))
                                                ->group_by('mm_question.question_id')
                                                ->get()->result();
        $edit_protected_questions = $this->db->select('gm_exam_paper_questions.question_id as id')
                                                ->from('mm_question')
                                                ->join('gm_exam_paper_questions','gm_exam_paper_questions.question_id=mm_question.question_id')
                                                ->join('gm_exam_paper','gm_exam_paper.id=gm_exam_paper_questions.exam_paper_id')
                                                ->join('gm_exam_question_paper','gm_exam_question_paper.question_paper_id=gm_exam_paper.id')
                                                ->join('gm_exam_schedule','gm_exam_schedule.id=gm_exam_question_paper.exam_schedule_id')
                                                ->where(array('mm_question.question_set_id'=>$question_set,
                                                            'mm_question.question_status'=>1,
                                                            'gm_exam_paper_questions.status'=>1,
                                                            'gm_exam_paper.record_status !='=>0,
                                                            'gm_exam_schedule.start_date_time <='=>date('Y-m-d H:i:s',time())
                                                            )
                                                        )
                                                ->group_by('mm_question.question_id')
                                                ->get()->result();
        foreach($edit_protected_questions as $k=>$v){
            $edit_protected_questions[$k] = $edit_protected_questions[$k]->id;
        }
        foreach($delete_protected_questions as $k=>$v){
            $delete_protected_questions[$k] = $delete_protected_questions[$k]->id;
        }
        if(!empty($return['questions'])){
            foreach($return['questions'] as $k=>$v){
                $return['questions'][$k]->edit_protected = false;
                $return['questions'][$k]->delete_protected = false;
                if(in_array($v->question_id,$edit_protected_questions)){
                    $return['questions'][$k]->edit_protected = true;
                }
                if(in_array($v->question_id,$delete_protected_questions)){
                    $return['questions'][$k]->delete_protected = true;
                }
            }
        }
        return $return;
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

    public function get_study_materials(){
        $query = $this->db->select('mm_study_material.*,
                                    mm_material.material_name,
                                    module.subject_name as module_name,
                                    subject.subject_name as subject_name')
                            ->from('mm_study_material')
                            ->join('mm_material', 'mm_material.material_id = mm_study_material.material_id')
                            ->join('mm_subjects as module', 'mm_material.subject_id = module.subject_id')
                            ->join('mm_subjects as subject', 'subject.subject_id = module.parent_subject')
                            ->where('mm_material.material_status !=',0)
                            ->where('mm_material.material_type','study material')
                            ->where('mm_study_material.status !=',0)
                            ->order_by('mm_study_material.id','DESC')
                            ->get();
		$resultArr = array();
		if($query->num_rows() > 0){
			$resultArr = $query->result_array();		
		}
		return $resultArr;
    }

    public function get_materials(){
        $query = $this->db->select('mm_material.*, module.subject_name as module_name,subject.subject_name as subject_name')
                            ->from('mm_material')
                            ->join('mm_subjects as module', 'mm_material.subject_id = module.subject_id')
                            ->join('mm_subjects as subject', 'subject.subject_id = module.parent_subject')
                            ->where('(`mm_material.material_type`="question" or `mm_material.material_type`="study material")')
                            ->where('mm_material.material_status',1)
                            ->order_by('mm_material.material_id','DESC')
                            ->get();
		$resultArr = array();
		if($query->num_rows() > 0){
			$resultArr = $query->result_array();		
        }
		return $resultArr;
    }
    
    public function delete_material($material_id)
    {
        $this->db->where('material_id', $material_id);
        $query=$this->db->update('mm_material',array("material_status"=>"2"));
        if($query){
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function get_material_by_id($material_id)
    {
       return $this->db->select('mm_material.*, mm_subjects.subject_name')
                     ->from('mm_material')
                     ->where(array('material_id'=>$material_id))
                     ->join('mm_subjects', 'mm_material.subject_id = mm_subjects.subject_id')
                     ->get()->row_array();
     // return $this->db->where(array('material_id'=>$material_id))->get('mm_material')->row_array();    
        
    }
    
    public function getall_material_type()
    {
         $query	=	$this->db->select('*')
                     ->from('mm_material_type')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }

    public function add_material($data)
    {
       $query= $this->db->insert('mm_material',$data);
        if($query)
        {
            return $this->db->insert_id();
        }
        else
        {
             return false;
        }

    }
     public function is_material_exist($data)
    {
        $data['material_status']=1;
        $query= $this->db->get_where('mm_material',$data);
        if($query->num_rows()>0)
        {
           return 1;//already exist
        }
        else
        {
            return 0;
        }
    }
    
    public function edit_material($materail_details,$material_id)
    {
        $this->db->where('material_id', $material_id);
        $query=$this->db->update('mm_material',$materail_details);
        if($query){
            return true;
        }
        else
        {
            return false;
        } 
    }
    //get all question set
    public function get_all_questionset()
    {
        $query	=	$this->db->select('mm_question_set.*, mm_material.material_name,mm_subjects.subject_name')
                     ->from('mm_question_set')
                     ->where('mm_question_set.question_set_status !=',2)
                     ->join('mm_material', 'mm_question_set.material_id = mm_material.material_id')
                     ->join('mm_subjects', 'mm_question_set.subject_id = mm_subjects.subject_id')
                     ->order_by('mm_question_set.question_set_id','desc')
                     ->get();
        $resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    } 
    //get question set materials
    public function get_questionset_material()
    {
      //return $this->db->where('material_type','question')->get('mm_material')->result(); 
        
        $query	=	$this->db->select('mm_material.*')
                     ->from('mm_material')
                     ->where('mm_material.material_status',1)
                     ->where('mm_material.material_type','question')
                     ->where('mm_subjects.subject_type_id','Module')
                     ->where('mm_subjects.subject_status','1')
                     ->join('mm_subjects', 'mm_material.subject_id = mm_subjects.subject_id')
                     ->get();
        //return $this->db->last_query();
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }
    public function questionset_add($data)
    {
         $this->db->select('*');
         $this->db->where($data);
         $this->db->where('question_set_status!=','2');
         $query= $this->db->get('mm_question_set');
         if($query->num_rows()>0)
         {
             return 2;
         }
         else
         {
               $res=$this->db->insert('mm_question_set',$data);
            
               if($res)
                {
                   return true;
                }
                else
                {
                    return false;
                }
         }
    }
    //edit question set 
    public function questionset_edit($id,$data)
    {
          $this->db->select('*');
          $this->db->where($data);
          $this->db->where('question_set_status!=','2');
          $this->db->where('question_set_id!=',$id);
         $query= $this->db->get('mm_question_set');
        // return $query->num_rows();
         if($query->num_rows()>=1)
         {
             return 2;
         }
         else
         {
               $this->db->where('question_set_id', $id);
               $query=$this->db->update('mm_question_set',$data);
               if($query)
               {
                 return true;
               }
              else
              {
                 return false;
              }
         }  
    }

    public function save_study_material($data){
        return $this->db->insert('mm_study_material',$data);
    }

    public function update_study_material($data,$study_material_id){
        return $this->db->where('id',$study_material_id)->update('mm_study_material',$data);
    }

    public function get_study_material_details($id){
        return $this->db->select('mm_study_material.*, module.subject_id as module_id,subject.subject_id as subject_id,mm_material.material_name, subject.course_id as course_id')
                        ->from('mm_study_material')
                        ->join('mm_material', 'mm_material.material_id = mm_study_material.material_id')
                        ->join('mm_subjects as module', 'mm_material.subject_id = module.subject_id')
                        ->join('mm_subjects as subject', 'subject.subject_id = module.parent_subject')
                        ->where('mm_study_material.id',$id)
                        ->get()->row_array();
    }
    
    public function question_option_insert($data)
    {
        $query=$this->db->insert_batch('mm_question_option', $data); 
        if($query) 
        {
         return true;
        } 
        else 
        {
        return false;
        }
    }

// ---------------------------------- Learning module ----------------------------------------------------- 

    public function get_learning_module(){
        return $this->db->order_by('id','desc')->get('am_learning_module')->result();
    }
    public function get_cource(){
        return $this->db->where('status',1)->get('am_classes')->result();
    }
    public function get_subject($course_id){
        return $this->db->where('subject_status',1)->where('course_id',$course_id)->get('mm_subjects')->result();
    }
    public function get_subject_questions($subject_id){
        return $this->db->select('mm_subjects.subject_name as module_name,mm_question.*')
                        ->from('mm_question')
                        ->join('mm_question_set','mm_question_set.question_set_id=mm_question.question_set_id')
                        ->join('mm_subjects','mm_subjects.subject_id=mm_question_set.subject_id')
                        ->where('mm_subjects.parent_subject',$subject_id)
                        ->where('mm_question.question_status',1)
                        ->get()->result_array();
    }

    public function get_selected_subject_questions($id){
        $subject_id = $this->db->where('id',$id)->get('am_learning_module')->row_array()['subject'];
        $questions = $this->get_subject_questions($subject_id);
        $selected_questions = $this->db->select('mm_question.question_difficulty,
                                                mm_question.question_id,
                                                mm_question.question_content,
                                                mm_question.question_set_id,
                                                mm_question.paragraph_id,
                                                am_learning_module_questions.question_number,
                                                am_learning_module_questions.id')
                                        ->from('am_learning_module_questions')
                                        ->join('mm_question','mm_question.question_id=am_learning_module_questions.question_id')
                                        ->where('am_learning_module_questions.learning_module_id',$id)
                                        ->get()->result_array();
        if(!empty($selected_questions)){
            foreach($questions as $k=>$v){
                $questions[$k]['selected']=0;
                foreach($selected_questions as $row){
                    if($v['question_id']==$row['question_id']){
                        $questions[$k]['selected']=1;
                    }
                }
            }
        }
        $data['questions'] = $questions;
        $data['selected_questions'] = $selected_questions;
        return $data;
    }

    public function check_duplicate_module_name($name){
        $query = $this->db->where('learning_module_name',$name)->where('status !=',0)->get('am_learning_module');
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function check_duplicate_module_name_edit($name){
        if($_POST){
            $exist = $this->common->check_if_dataExist('am_learning_module',array('learning_module_name'=>$name));
            if($exist <= 1)
            {
              return FALSE;
            }
            else
            {
              return TRUE;
            }
        }  
    }
    public function create_question_module($data){
        $this->db->insert('am_learning_module',$data);
        return $this->db->insert_id();
    }
    public function get_learning_module_name($id){
        return $this->db->select('*')->from('am_learning_module')->where('id',$id)->get()->row();
    }
    public function get_new_question_ids($qids,$l_module_id){
        $questions = $this->db->select('question_id')
                                ->where('learning_module_id',$l_module_id)
                                ->get('am_learning_module_questions')->result();
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
    public function save_learning_module_questions($l_module_id,$delete_qids,$data){
        $this->db->trans_start();
        if(!empty($delete_qids)){
            $this->db->where('learning_module_id',$l_module_id)
                     ->where_in('question_id',$delete_qids)
                     ->delete('am_learning_module_questions');
        }
        if(!empty($data)){
            $this->db->insert_batch('am_learning_module_questions',$data);
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }
    public function get_last_question_number($l_module_id){
        $query = $this->db->where('learning_module_id',$l_module_id)
                            ->order_by('question_number','DESC')
                            ->get('am_learning_module_questions');
        if($query->num_rows() > 0){
            return $query->row()->question_number;
        }else{
            return 0;
        }
    }
    public function delete_selected_question($id){
        $qid = $this->db->select('question_id')->from('am_learning_module_questions')->where('id',$id)->get()->row()->question_id;
        $this->db->where('id',$id)->delete('am_learning_module_questions');
        return $qid;
    }
    public function reorder_exam_paper_questions($l_module_id){
        $questions = $this->db->where('learning_module_id',$l_module_id)
                                ->order_by('question_number','ASC')
                                ->get('am_learning_module_questions')->result();
        $qids = array();
        $ques_details = array();
        if(!empty($questions)){
            foreach($questions as $k=>$row){
                if($row->question_id){
                    $qids[$k] = $row->question_id;
                }
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
            $this->db->where('learning_module_id',$l_module_id)
                        ->update_batch('am_learning_module_questions',$data,'question_id');
        }
    }
    public function save_learning_module_name($module_id,$name){
        // $query = $this->db->where('learning_module_id',$module_id)
        //                 ->get('am_learning_module_questions');
        // if($query->num_rows() == 0){
        //     $data['status'] = 0;
        // }
        $data['learning_module_name'] = $name;
        // show($data);
        return $this->db->where('id',$module_id)
                ->update('am_learning_module',$data);  
    }
    public function get_questions_by_learning_module_id($id){
        return $this->db->select('mm_question.question_difficulty,
                                 mm_question.question_id,
                                 mm_question.question_content,
                                 mm_question.question_set_id,
                                 mm_question.paragraph_id,
                                 am_learning_module_questions.learning_module_id,
                                 am_learning_module_questions.question_number,
                                 am_learning_module_questions.id')
                         ->from('am_learning_module_questions')
                         ->join('mm_question','mm_question.question_id=am_learning_module_questions.question_id')
                         ->where('am_learning_module_questions.learning_module_id',$id)
                         ->get()->result_array();
    }
    public function edit_learning_module_status($id,$status)
    { 
		if($status == 0){
			$this->db->where('id', $id);
			$query=$this->db->update('am_learning_module',array("status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('id', $id);
			$query=$this->db->update('am_learning_module',array("status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
    }
    public function get_version($id){
        $res = $this->db->where('parent_id',$id)
                        ->order_by('id','DESC')
                        ->get('am_learning_module')->row_array();
        if(!empty($res)){
            $version = $res['version'] + 1;
        }else{
            $version = 2;
        }
        return $version;
    }
    public function insert_learning_module_copy($data){
        $this->db->insert('am_learning_module',$data);
        return $this->db->insert_id();
    }
    public function select_assinged_questions($insertId, $id){
        $res = $this->db->where('learning_module_id',$id)
                        ->get('am_learning_module_questions')->result_array();
        // show($res);
        // $selectedQuestions = array();
        foreach($res as $key=>$row){
            if($res[$key]['learning_module_id'] == $id){
                $res[$key]['learning_module_id'] = $insertId;
                unset($res[$key]['id']);
            }
        }
        return $this->db->insert_batch('am_learning_module_questions',$res);
        // show($res);
    }
    public function check_questionExist($id){
        $res = $this->db->where('learning_module_id',$id)
                        ->get('am_learning_module_questions')->result_array();
        if(!empty($res)){
            return true;
        }else{
            return false;
        }
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
    public function get_approve_status($id){
        return $this->db->select('approval_flow_jobs.*,
                                  approval_flow_jobs.assign_date,
                                  approval_flow_jobs.updated_date,
                                  mm_question_set.question_set_name,
                                  approval_flow_entity_details.user_id,
                                  approval_flow_entity_details.level')
                         ->from('approval_flow_jobs')
                         ->join('mm_question_set','mm_question_set.question_set_id=approval_flow_jobs.entity_id')
                         ->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id')
                         ->where('approval_flow_entity_details.flow_entities',1)
                         ->where('approval_flow_jobs.entity_id',$id)
                         ->order_by('approval_flow_jobs.id','ASC')
                         ->get()->result();
    }
    public function get_approve_statusLM($id){
        return $this->db->select('approval_flow_jobs.*,
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
                         ->get()->result();
    }
    public function confirmModuleCode($learningModuleCode){
        $res = $this->db->select('learning_module_code')->from('am_learning_module')->where('learning_module_code',$learningModuleCode)
                        ->get()->row();
        if(!empty($res)){
            $lastDigit = substr($learningModuleCode, -1);
            $lastDigit = (int)$lastDigit + 1;
            $learningModuleCode = substr_replace($learningModuleCode,$lastDigit,-1);
            // show($learningModuleCode);
        }
        return $learningModuleCode;
    }
    public function get_nOcurence($course,$subject)
    {
        $query	=	$this->db->select('*')
                     ->where('course',$course)
                     ->where('subject',$subject)
                     ->get('am_learning_module');
        $a	= 0;
		if($query->num_rows() == 0){
			$a	=	001;		
		}else{
            $a	= $query->num_rows() + 1000 + 1;
            $a = substr($a, 1);
            // show($a);
        }
		
		return $a;
    } 
}
