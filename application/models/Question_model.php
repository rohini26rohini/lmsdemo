<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_School()
    {
        $this->db->select('*');
        $this->db->where('school_status','1');
	    $query	=	$this->db->get('am_schools');
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    public function insert_question_paper($data)
    {
        $query	= $this->db->insert('am_questions',$data);	
		$return	=	true;
		
		if(!$query){
			$return	=	false;
		}
		
		return $return;
         
    }
    
    public function get_questions()
    {
        $this->db->select('am_questions.*,am_schools.school_name');
        $this->db->from('am_questions');
        $this->db->join('am_schools', 'am_questions.school_id = am_schools.school_id');
        $this->db->where('am_questions.question_status','1');
        $this->db->order_by('question_id','DESC');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    public function question_delete($question_id)
    {
            $updateData = array('question_status' => '2');
            $this->db->where('question_id', $question_id);
           $query= $this->db->update('am_questions', $updateData);
        if($query){ return true;}
        else
        {
            return false;
        }
    }
    
    public function get_question_by_id($id)
    {
        
         $this->db->select('am_questions.*,am_schools.school_name');
        $this->db->from('am_questions');
        $this->db->join('am_schools', 'am_questions.school_id = am_schools.school_id');
        $this->db->where(array('question_status'=>'1','question_id'=>$id));
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row_array();
		}

		return $resultArr;
    }
    public function edit_question($data,$id)
    {
           $this->db->where('question_id', $id);
           $query= $this->db->update('am_questions', $data);
              if($query){
                  return true;
              }
            else
            {
                return false;
            }  
    }
    
    public function sample_questions_ajax($start='', $length='', $order='', $dir='')
    {
      
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }
				$query	=	$this->db->select('am_questions.*,am_schools.school_name')
                           ->from('am_questions')
                           ->where('am_questions.question_status','1')
                           ->join('am_schools', 'am_questions.school_id = am_schools.school_id')
                         ->limit($length,$start)
                         ->order_by('question_id','DESC')
                         ->get();

		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

		return $resultArr;    
    }
    
    public function getNum_sample_questions_ajax()
    {
      $query	=	$this->db->select('am_questions.*,am_schools.school_name')
                           ->from('am_questions')
                           ->where('am_questions.question_status','1')
                           ->join('am_schools', 'am_questions.school_id = am_schools.school_id') 
                            ->get();
        return $query->num_rows();
 
    }
    
    
        
}
