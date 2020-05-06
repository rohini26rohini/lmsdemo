<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Institute_model extends Direction_Model {
    
     public function __construct() 
     {
        parent::__construct();
     }
    
    public function get_institute_type()
    {
        $this->db->where('status', '1');
		$query	=	$this->db->get('am_institute_type');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }
    
    public function institute_add($data)
    {	
	
		$res=$this->db->insert('am_institute_master',$data);	
	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
    }
    public function get_allparent_institutes($type)
    {
        $this->db->where('status', 1);
        $this->db->order_by('institute_name', 'ASC');
        $query= $this->db->get_where('am_institute_master',array("institute_type_id"=>$type));
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
      return   $resultArr;
    }
    
    public function is_institute_exist($data)
    {
        $this->db->where('status!=',2);
        $this->db->where($data);
       $query= $this->db->get('am_institute_master');
        
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
  
/*
*
*   Check check_institute_hierarchy 
*
*/
    
    public function check_institute_hierarchy($id = NULL){
        $this->db->where('group_master_id', $id);
        $this->db->or_where('branch_master_id', $id);
        $this->db->or_where('institute_master_id', $id);
        $this->db->where('status', '1');
        $query= $this->db->get('am_institute_course_mapping');
        if($query->num_rows()>0)
        {
           return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }

    public function delete_check_institute_hierarchy($id = NULL){
        $f =0;
        $this->db->where('group_master_id', $id);
        $this->db->where('status', '1');
        $query= $this->db->get('am_institute_course_mapping');
        if($query->num_rows()>0)
        {
            $f = 1;
            return $f;
        }
        
        $this->db->where('branch_master_id', $id);
        $this->db->where('status', '1');
        $query= $this->db->get('am_institute_course_mapping');
        if($query->num_rows()>0)
        {
            $f = 1;
            return $f;
        }

        $this->db->or_where('institute_master_id', $id);
        $this->db->where('status', '1');
        $query= $this->db->get('am_institute_course_mapping');
        if($query->num_rows()>0)
        {
            $f = 1;
            return $f;
        }
        return $f;
    }
    
    public function is_institute_exist_edit($data)
    {
        $id = $data['institute_master_id'];
        unset($data['institute_master_id']);
        $this->db->where('status!=',2);
        $this->db->where('institute_master_id!=',$id);
        $this->db->where($data);
       $query= $this->db->get('am_institute_master');
        
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    
    public function get_all_institutes()
    {
        
		$query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
                     ->from('am_institute_master')
                     ->where('am_institute_master.status', '1')
                     ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
    }
    public function get_instituteby_id($id)
    {
        $this->db->select('institute_name');
        $query= $this->db->get_where('am_institute_master',array('institute_master_id'=>$id));
        if($query->num_rows()>0)
        {
           return $query->row()->institute_name;
        }
        else
        {
            return false;
        }
    }


    
    public function get_institutedetails_by_id($id)
    {
        
        $query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
                     ->from('am_institute_master')
                     ->where('am_institute_master.institute_master_id', $id)
                     ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
                     ->get();
        
      /*  $this->db->select('*');
        $query= $this->db->get_where('am_institute_master',array('institute_master_id'=>$id));*/
        if($query->num_rows()>0)
        {
           return $query->row_array();
        }
        else
        {
            return false;
        }
    }
    
    public function delete_institute($id)
    {
        $this->db->where('institute_master_id', $id);
        $query=$this->db->update('am_institute_master',array("status"=>"2"));
        $return	=	true; 
		
		if(!$query){
			$return	=	false;
		}
		
		return $return;
    }
    
    public function institute_edit($data)
    {
        $id=$data['institute_master_id'];
        unset($data['institute_master_id']);
        if($data['institute_type_id'] == 1)
        {
           unset($data['parent_institute']);  
        }
        $this->db->where('institute_master_id',$id);
		$query	= $this->db->update('am_institute_master',$data);
		
		
		$return	=	true;
		
		if(!$query){
			$return	=	false;
		}
		
		return  $return;
        
    }
    public function get_allgroups() 
    {
        $this->db->select('*');
        $query= $this->db->get_where('am_institute_master',array('status'=>'1','institute_type_id'=>'1'));
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    public function get_allsub_byparent($where)
    {
        $where['status']=1;
        $this->db->select('*');
        $query= $this->db->get_where('am_institute_master',$where);
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function is_course_exist($group,$branch,$center,$course){
        $data = array('group_master_id'=>$group,
                     'branch_master_id'=>$branch,
                     'institute_master_id'=>$center,
                     'course_master_id'=>$course,
                      'status'=>1
                     );
        $this->db->select('*');
      //  $this->db->where('status!=','2');
        $query= $this->db->get_where('am_institute_course_mapping',$data);
        return $query->num_rows();
    }

    public function is_course_exist_edit($group,$branch,$center,$course,$id){
        return $this->db->where('group_master_id',$group)
                        ->where('branch_master_id',$branch)
                        ->where('institute_master_id',$center)
                        ->where('course_master_id',$course)
                        ->where('status',1)
                        ->where('institute_course_mapping_id !=',$id)
                        ->get('am_institute_course_mapping')->num_rows();
    }

    public function institute_course_add_mapping($data){
        $this->db->trans_begin();
        $res = '';
        if(!empty($data['institute_course_mapping_id'])){
            
            $edit_id=$data['institute_course_mapping_id'];
            unset($data['institute_course_mapping_id']);  
            $this->db->where('institute_course_mapping_id',$edit_id);
            $result = $this->db->update('am_institute_course_mapping',$data);
		    if($result){
                // echo $this->db->last_query(); exit;
                $res = $edit_id;
            }
            $this->db->where('am_institute_course_mapping_id',$res)->delete('am_institute_course_fee_definition');
            // echo $this->db->last_query(); exit;
        }else{
            unset($data['institute_course_mapping_id']);
            $this->db->insert('am_institute_course_mapping',$data);  //echo $this->db->last_query(); exit;
            $res=$this->db->insert_id();
        }
		// echo $res; exit;
	    if($res){
            $fee_definition = array();
            $heads = $this->input->post('heads');
            $head_ids = $this->input->post('head_ids');
            if(!empty($head_ids)){
            foreach($heads as $k=>$v){
                array_push($fee_definition,array(
                    'am_institute_course_mapping_id'=>$res,
                    'fee_head_id'=>$head_ids[$k],
                    'fee_amount'=>$v
                ));
            }
            }
            $this->db->insert_batch('am_institute_course_fee_definition',$fee_definition); 
            // echo $this->db->last_query();  exit;
            if(isset($data['course_paymentmethod']) && $data['course_paymentmethod'] == 'installment'){
                $installment = $this->input->post('installment');
                $duedate     = $this->input->post('duedate');
                if(!empty($installment)){
                    $data=array();
                    foreach($installment as $key=>$val){
                        $data[$key] = array(
                            'institute_course_mapping_id'=>$res,
                            'installment_amount'=>$val,
                            'installment_duedate'=>date('Y-m-d', strtotime($duedate[$key]))
                        );
                    }
                    $this->db->where('institute_course_mapping_id',$res)->delete('am_batch_fee_installment');
                    $this->db->insert_batch('am_batch_fee_installment',$data);
                    $this->db->trans_commit();
                    return true;
                }else{
                    $this->db->trans_rollback();
                    return false;
                }
            }else{
				$this->db->trans_commit();
				return true;
			}
        }else{
            // $this->db->trans_rollback();
            $this->db->trans_commit();
            return false;
        }   
    }

    public function get_institute_course_fee_definitions($id){
        $fees = $this->db->select('am_institute_course_fee_definition.*,am_payment_heads.ph_head_name')
                        ->join('am_payment_heads','am_payment_heads.ph_id=am_institute_course_fee_definition.fee_head_id')
                        ->where('am_institute_course_fee_definition.am_institute_course_mapping_id',$id)
                        ->get('am_institute_course_fee_definition')->result();
        $data = array();
        if(!empty($fees)){
            foreach($fees as $row){
                array_push($data,array('id'=>$row->fee_head_id,'name'=>$row->ph_head_name,'value'=>$row->fee_amount));
            }
        }
        return $data;
    }
    
    public function getall_institute_course_mapping_list()
    {
       $query= $this->db->select('t1.*, t2.institute_name, t3.class_name,t3.class_id')
         ->from('am_institute_course_mapping as t1')
         ->where('t1.status', '1')
         ->join('am_institute_master as t2', 't1.institute_master_id = t2.institute_master_id')
         ->join('am_classes as t3', 't1.course_master_id = t3.class_id')
         ->order_by('class_id', 'desc')
         ->get();
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();
            return $data_array;
        }
          return $data_array;
        
    }
    
    public function get_course_center_fee_installments($where)
    {
        $query= $this->db->select('installment_amount,installment_duedate')->get_where('am_batch_fee_installment',$where);
        $details=array();
        if($this->db->affected_rows()>0)
        {
           $details= $query->result_array();
           return $details;
        }
        else
        {
            return false;
        } 
    }

    


    // public function get_course_center_fee_installments($where)
    // {
    //     $query= $this->db->select('installment_amount,installment_duedate')->get_where('am_batch_fee_installment',$where);
    //     $details=array();
    //     if($query->num_rows()>0)
    //     {
    //        $details= $query->result_array();
    //        return $details;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    
    // GET COURSES BY CENTER
    
     public function get_allcoursebycenter($id = NULL)
    {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_classes', 'am_classes.class_id = am_institute_course_mapping.course_master_id'); 
        $this->db->where('am_institute_course_mapping.institute_master_id', $id);
        $this->db->where('am_institute_course_mapping.status', 1);
        $query= $this->db->get();
        if($query->num_rows()>0)
        {
           return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function get_batchby_id($id = NULL)
    {
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->where('am_batch_center_mapping.batch_id', $id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();		
		}
		
		return $resultArr;
    }

    // public function get_institutecourse_mapping_byid($where)
    // {
    //    $this->db->select('*');
    //     $query= $this->db->get_where('am_classrooms',$where);
    //     $details=array();
    //     if($query->affected_rows()>0)
    //     {
    //        $details= $query->result_array();
    //        return $details;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    public function get_modules_byparent_in_mapping($parent_subject_id)
    {
       $query= $this->db->select('mm_subject_course_mapping.subject_master_id,mm_subjects.subject_name as subname')
             ->from('mm_subject_course_mapping')
             ->where(array('mm_subject_course_mapping.subject_status'=>'1','mm_subject_course_mapping.parent_subject_master_id'=>$parent_subject_id))
             ->join('mm_subjects', 'mm_subject_course_mapping.subject_master_id = mm_subjects.subject_id')
             ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result_array();
           return $details;
        }
        else
        {
            return false;
        }  
    }

    public function get_all_subjects_subjectype()
    {
        $query	=	$this->db->select('*')
                     ->from('mm_subjects')
                     ->where(array("mm_subjects.subject_status"=>"1","mm_subjects.subject_type_id"=>"Subject"))
                     ->order_by('mm_subjects.subject_name')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }

    public function get_allmodules_by_subjectid($where)
    {
        $where['subject_status']=1;
        $query	=	$this->db->select('*')
                     ->from('mm_subjects')
                     ->where($where)
                     ->where('subject_type_id','Module')
                     ->order_by('mm_subjects.subject_name')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
    }

    public function get_student_course()
    {
       
        $query= $this->db->select('t1.student_course_id,t1.student_id,t1.course_id,t1.center_id,t1.batch_id,t3.name,t3.registration_number')
                ->from('am_student_course_mapping as t1')
                ->join('am_batch_center_mapping as t2','t1.batch_id = t2.batch_id')
                ->join('am_students as t3','t1.student_id = t3.student_id')
                ->where('t1.status', '1')
                ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result_array();

        }
        return $details;
    }
    function get_all_batches($course_id,$center_id) {
        $query= $this->db->select('t1.batch_id,t1.batch_name,t1.institute_course_mapping_id, t2.institute_course_mapping_id,t2.institute_master_id, t2.course_master_id, t3.class_id,t3.class_name')
                        ->from('am_batch_center_mapping as t1')
                        ->join('am_institute_course_mapping as t2', 't1.institute_course_mapping_id = t2.institute_course_mapping_id')
                        ->join('am_classes as t3', 't2.course_master_id = t3.class_id')
                        ->join('am_institute_master as t4', 't2.institute_master_id = t4.institute_master_id')
                        ->where('t1.batch_status', '1')
                        ->where('t3.class_id', $course_id)
                        ->where('t4.institute_master_id', $center_id)
                        ->get();
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result_array();

        }
        return $details;
    }

    function fetch_data($batch_id)
    {

        // $this->db->select('cc_call_center_enquiries.*, am_classes.class_id,am_classes.class_name');
        // $this->db->from('cc_call_center_enquiries');
        // $this->db->join('am_classes', 'cc_call_center_enquiries.course_id = am_classes.class_id');
        //     if($batch_id != ''){
        //         $this->db->like('batch_id', $batch_id);
        //     }
        // $this->db->order_by('call_id', 'DESC');
        // return $this->db->get();
        $query= $this->db->select('t1.batch_id,t1.batch_name,t1.institute_course_mapping_id, t2.institute_course_mapping_id,t2.institute_master_id, t2.course_master_id, t3.class_id,t3.class_name');
        $this->db->from('am_batch_center_mapping as t1');
        $this->db->join('am_institute_course_mapping as t2', 't1.institute_course_mapping_id = t2.institute_course_mapping_id');
        $this->db->join('am_classes as t3', 't2.course_master_id = t3.class_id');
        $this->db->join('am_institute_master as t4', 't2.institute_master_id = t4.institute_master_id');
        $this->db->where('t1.batch_status', '1');
        $this->db->where('t1.batch_id', $batch_id);
        if($batch_id != ''){
            $this->db->like('batch_id', $batch_id);
        }
        
        // ->where('t3.class_id', $course_id)
        // ->where('t4.institute_master_id', $center_id)
        return $this->db->get();
        // $details=array();
        // if($query->num_rows()>0)
        // {
        //    $details= $query->result_array();

        // }
        // return $details;
    }
    
    
    public function get_all_institutes_by_ajax($start,$length,$order, $dir) 
    {
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }


		$query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
                     ->from('am_institute_master')
                     ->where('am_institute_master.status', '1')
                     ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
                     ->limit($length,$start)
                     ->order_by('am_institute_master.institute_master_id','DESC')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
    }
    public function get_num_institutes_by_ajax()
    {

		$query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
                     ->from('am_institute_master')
                     ->where('am_institute_master.status', '1')
                     ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
                     ->order_by('am_institute_master.institute_master_id','DESC')
                     ->get();


		return $query->num_rows();

    }

    public function get_all_institutes_by_ajax_search($start,$length,$order, $dir,$search)
    {
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }


		$query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
                     ->from('am_institute_master')
                     ->where('am_institute_master.status', '1')
                     ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
                     ->limit($length,$start)
                     ->like('institute_name',$search)
                     ->or_like('institute_type',$search)
                     ->order_by('am_institute_master.institute_master_id','DESC')
                     ->get();

		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

		return $resultArr;

    }
        /*
    *   function'll get branches
    *   @params course_id
    *   @author GBS-L
    */
    
     public function get_all_branches()
    {
        $this->db->order_by('institute_name', 'ASC');
        $query= $this->db->get_where('am_institute_master',array("institute_type_id"=>"2"));
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
      return   $resultArr;
    }



 public function get_institutecourse_mapping_byid($where)
    {
       $this->db->select('*');
        $query= $this->db->get_where('am_institute_course_mapping',$where);
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->row_array();
           return $details;
        }
        else
        {
            return false;
        } 
    }
    
    /*
    *   function'll get list of student in batch
    *   @params batch id
    *   @author GBS-R
    */
    
        public function get_student_inbatch($id = NULL)
    {
        $this->db->select('am_student_course_mapping.*, am_students.name as student_name,am_students.registration_number');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_students', 'am_students.student_id = am_student_course_mapping.student_id');     
        $this->db->where('am_student_course_mapping.batch_id', $id);
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->where('am_students.status', 1);
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
