<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_student_list($course = null)
    {
        $this->db->select('am_students.*, cities.name as city_name,am_student_course_mapping.course_id');
        $this->db->from('am_students');
        $this->db->join('cities', 'cities.id = am_students.district');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
        $this->db->where('am_students.status <',10);
        if(!empty($course)){
            $this->db->where_in('am_student_course_mapping.course_id', $course);   
        }
        $this->db->group_by('am_students.student_id');
        $this->db->order_by('am_students.student_id','desc');

	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }

    function get_student_profile_list() {
        $this->db->select('am_students.*,am_student_qualification.category,am_student_qualification.qualification,am_student_qualification.marks');
        $this->db->from('am_students'); 
        $this->db->where('am_students.status <',10);
        $this->db->join('am_student_qualification', 'am_student_qualification.student_id=am_students.student_id');
        $this->db->order_by('am_students.student_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }


     public function get_studentview_by_id($id)
    {
        $query	= $this->db->select('*')
                ->from('am_students')
                ->where('am_students.student_id', $id)
                //->join('am_student_qualification', 'am_students.student_id = am_student_qualification.student_id')
                ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    
    /*
    *
    *
    *
    */
    
     public function get_studentquali_by_id($id)
    {
        $query	= $this->db->select('*')
                ->from('am_student_qualification')
                ->where('student_id', $id)
                //->join('am_student_qualification', 'am_students.student_id = am_student_qualification.student_id')
                ->get();
        if($query->num_rows()>0){
           return $query->result_array();
        }else{
            return false;
        }
    }

    public function get_studentdocument_by_id($id)
    {
        $query	= $this->db->select('*')
                ->from('am_student_documents')
                ->where('student_id', $id)
                ->where('status', '1')
                ->get();
        if($query->num_rows()>0){
           return $query->result_array();
        }else{
            return false;
        }
    }

    public function get_all_others($student_id)
    {
        $this->db->select('*');
        $this->db->where('student_id',$student_id);
        $query = $this->db->get('am_student_qualification');
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
        }
      return   $resultArr;
    }

    public function get_all_doc($student_documents_id,$student_id)
    {
        $this->db->select('*');
        $this->db->where('student_id',$student_id);
        $this->db->where('student_documents_id',$student_documents_id);
        $query = $this->db->get('am_student_qualification');
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
        }
      return   $resultArr;
    }

    public function get_all_others1($stud_id,$document_name1,$file1,$document_verification1)
    {
        $this->db->select('*');
        $this->db->where('student_id',$stud_id);
        $this->db->where('document_name',$document_name1);
        $this->db->where('file',$file1);
        $this->db->where('document_verification',$document_verification1);
        $query = $this->db->get('am_student_qualification');
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
        }
      return   $resultArr;
    }



     public function search_students($data)
     {
        unset($data['ci_csrf_token']);
       $query= $this->db->select('*')
            ->from('am_students')
            ->like($data)
            ->where('status!=','2')->get();
         $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;

     }

    public function get_studentdetails_byid($id)
    {
        $query= $this->db->get_where('am_students',array("student_id"=>$id));
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->row_array();
        }
        return   $resultArr;
    }

    function get_stud_det($student_id) {
        $this->db->select('am_students.*,am_schools.school_name');
        $this->db->from('am_students'); 
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=am_students.student_id');
        $this->db->join('am_classes', 'am_classes.class_id=am_student_course_mapping.course_id');
        $this->db->join('am_schools', 'am_schools.school_id=am_classes.school_id');
        $this->db->where('am_students.student_id',$student_id);
        $this->db->order_by('am_students.student_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->row_array();		
        }
        return $resultArr;
    }

    public function get_studentqualification($id)
    {
      $query= $this->db->get_where('am_student_qualification',array("student_id"=>$id));
      $resultArr	=	array();
      if($query->num_rows()>0)
      {
         $resultArr=$query->result_array();
      }
    return   $resultArr;
    }


    public function get_student_qualification_byid1($student_id)
    {
        $this->db->select('*');
        $this->db->where('student_id',$student_id);
        $this->db->like('category', 'other');
        $query= $this->db->get_where('am_student_qualification',array("student_id"=>$student_id));
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
        }
      return   $resultArr;
    }


    public function student_register($student_id="",$data)
    {
        // $data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));
        // show($data);
        if(!empty($student_id)){
            $this->db->where('student_id', $student_id);
            $query=$this->db->update('am_students',$data);
        }
        else{
           $query=$this->db->insert('am_students',$data);
        }
        if($query){
            return true;
        }
        else{
            return false;
        }
    }

    public function edit_student_qualification($student_id,$category,$data,$qualification)
    {
        if($category == "other"){
            $this->db->where(array('student_id'=>$student_id,'qualification'=>$qualification,'category'=>$category));
        }else{
            $this->db->where(array('student_id'=>$student_id,'category'=>$category));
        }
      $query=$this->db->update('am_student_qualification',$data);

        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function add_student($data)
    {
       $res=$this->db->insert('am_students',$data);
        if($res)
        {
           return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }

    public function delete_others($id)
    {
        $this->db->where('qualification_id', $id);
        $query=$this->db->delete('am_student_qualification');
        if($query)
        {
             $this->db->where('qualification_id', $id);
             $sql=$this->db->delete('am_student_documents');
             $return	=	true; 
        }
		else{
			$return	=	false;
		}
        return $return;
    }

    public function check_qualification($student_id,$category)
    {
       $query= $this->db->get_where('am_student_qualification',array("student_id"=>$student_id,"category"=>$category));
        return $query->num_rows();

    }
    public function check_qualification1($student_id,$qualification,$category)
    {
       $query= $this->db->get_where('am_student_qualification',array("student_id"=>$student_id,"qualification"=>$qualification,"category"=>$category));
        return $query->num_rows();

    }

    public function add_student_qualification($data)
    {
        $query=$this->db->insert('am_student_qualification',$data);
            if($query)
            {
                return true;
            }
           else
           {
               return false;
           }
    }

    
    /*
    *   function'll get course student data
    *   @params student id
    *   @author GBS-R
    */
    
    // public function get_student_course($student_id)
    // {
    //    $query= $this->db->get_where('am_student_course_mapping',array("student_id"=>$student_id));
    //     //return $query;
    //     if($query->num_rows()>0)
    //     {
    //          $resultArr=$query->row_array();
    //         return $resultArr;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
    
    public function get_student_course($id)
    {
        $this->db->select('*');
        $this->db->where('student_id', $id);
        //$query= $this->db->get_where('am_student_course_mapping',array("student_id"=>$id));
        $this->db->order_by('student_course_id','desc');
        $query= $this->db->get('am_student_course_mapping');
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->row_array();

        }
        return $details;
    }
        
    
    /*
    *   function'll get batch fee
    *   @params student id, batch id
    *   @author GBS-R
    */
    
    public function get_batchfee_bystudent($student_id, $institute_center_map_id)
    {
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_student_course_mapping.institute_course_mapping_id');
        $this->db->where('am_student_course_mapping.student_id', $student_id);
        $this->db->where('am_student_course_mapping.institute_course_mapping_id', $institute_center_map_id);
        //$this->db->where('am_student_course_mapping.status',2);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
	
	
	/*
    *   function'll get batch fee
    *   @params student id, batch id
    *   @author GBS-R
    */
    
    public function get_batchfee_bystudent_id($student_id, $institute_center_map_id)
    {
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_student_course_mapping.institute_course_mapping_id');
        $this->db->where('am_student_course_mapping.student_id', $student_id);
        $this->db->where('am_student_course_mapping.institute_course_mapping_id', $institute_center_map_id);
        //$this->db->where('am_student_course_mapping.status',2);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
    
//    public function get_batchfee_bystudent($student_id, $batch_id)
//    {
//        $this->db->select('*');
//        $this->db->from('am_student_course_mapping');
//        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
//        $this->db->where('am_student_course_mapping.student_id', $student_id);
//        $this->db->where('am_student_course_mapping.batch_id', $batch_id);
//        //$this->db->where('am_student_course_mapping.status',2);
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
    *   function'll update student batch fee 
    *   @params post array
    *   @author GBS-R
    */
    
    public function update_student_fee($data)
    {
        $this->db->insert('pp_student_payment',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id!='')
        {
            return $insert_id;
        }
        else
        {
            return false;
        }
    }

    public function get_student_card_details($id){
        return $this->db->select('am_classes.class_name,am_schools.school_name,am_schools.school_code')
                        ->from('am_student_course_mapping')
                        ->join('am_classes','am_classes.class_id=am_student_course_mapping.course_id')
                        ->join('am_schools','am_schools.school_id=am_classes.school_id')
                        ->where('am_student_course_mapping.student_id',$id)
                        ->where('am_student_course_mapping.status',1)
                        ->get()->row_array();
    }
    
    /*
    *   function'll update installment
    *   @params data array, payment id
    *   @author GBS-R
    *
    */
    
      public function update_student_feeinstallment($data, $payment_id)
    {

//      $this->db->where(array('payment_id'=>$payment_id));
//      $query=$this->db->update('pp_student_payment',$data);
        $sql = 'UPDATE pp_student_payment SET paid_amount = paid_amount + '.$data['paid_amount'].', balance = balance - '.$data['paid_amount']. ', paymentmode="'.$data['paymentmode'].'" WHERE payment_id="'.$payment_id.'"';  
        $query = $this->db->query($sql);  
        if($query)
        {
            return $payment_id;
        }
        else {
            return false;
        }  
      }
          
  
          
    //check if student already selected a course or not
    public function is_course_existfor_student($id)
    {
         $this->db->select('*');
         $query= $this->db->get_where('am_student_course_mapping',array("student_id"=>$id));
         return $query->num_rows();
    }
          
          
    //
    public function edit_student_course($course_id,$student_id)
    {
         $this->db->where(array('student_id'=>$student_id));
         $query=$this->db->update('am_student_course_mapping',array('course_id'=>$course_id));
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //upload documents of students
    public function upload_student_documents($data){
        $this->db->insert('am_student_documents',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id!=''){
            return $insert_id;
        }else{
            return false;
        }  
    }
    
    public function upload_student_documents_edit($data, $where){
        $this->db->where($where);
        $query = $this->db->update('am_student_documents',$data);
        if($query){
            return true;
        }else{
            return false;
        }  
    }

    public function get_student_documents($id){
        return $this->db->where('student_id',$id)->where('status',1)->get('am_student_documents')->result();
    }
    public function get_student_qual_documents($id){
        return $this->db->where('student_id',$id)->get('am_student_qualification')->result_array();
    }

    public function get_student_document($id){
        return $this->db->where('student_documents_id',$id)->get('am_student_documents')->row_array();
    }

    public function delete_student_document($id){
        $data['status']=0;
        $this->db->where('student_documents_id',$id)->update('am_student_documents',$data);
    }
    public function delete_student_others($id){
        $data['status']=0;
        $this->db->where('qualification_id',$id)->update('am_student_qualification',$data);
    }

    public function verify_student_document($id,$verification){
        $data['verification']=$verification;
        $this->db->where('student_documents_id',$id)->update('am_student_documents',$data);

    }
    
    
    /*
    *   function'll get discount packages
    *   @params 
    *   @author GBS-R
    */
    
    public function get_discounts()
    {
        $this->db->select('*');
        $this->db->from('am_discount_packages');
        $this->db->join('am_discount_master', 'am_discount_master.package_master_id = am_discount_packages.package_master_id');
        $this->db->where('am_discount_packages.package_status', 1);
        $this->db->where('am_discount_master.status', 1);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }
    
    /*
    *   function'll delte existing discount of student
    *   @params student_id, course_id, package_id
    *   @author GBS-R
    */
          
    public function deletediscount($student_id, $course_id, $dis) {
        $this->db->where('student_id', $student_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('package_id', $dis);
        $this->db->delete("pp_student_discount");
    }

    
    /*
    *   function'll get student batch details
    *   @params student_id
    *   @author GBS-R
    */
    
    public function get_student_batch_details($student_id = NULL)
    {
        $this->db->select('am_student_course_mapping.*,am_batch_center_mapping.*,am_institute_master.*,am_classes.*,am_batch_mode.*, a.institute_name as center');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_student_course_mapping.institute_course_mapping_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_student_course_mapping.branch_id');
        $this->db->join('am_institute_master as a', 'a.institute_master_id = am_institute_course_mapping.institute_master_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->join('am_batch_mode', 'am_batch_mode.mode_id = am_classes.batch_mode_id');
        $this->db->where('am_student_course_mapping.student_id', $student_id);
        $this->db->where('am_student_course_mapping.status!=', 4);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
    
        
    /*
    *   function'll get student payment details
    *   @params student_id
    *   @author GBS-R
    */
    
    public function get_student_payment_details($student_id = NULL)
    {
        $this->db->select('*');
        $this->db->from('pp_student_payment');
        //$this->db->where('status', 1);
        $this->db->where('student_id', $student_id);
        $this->db->where('parent_payment_id', NULL);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();		
		}
		
		return $resultArr;
    }
    
        /*
    *   function'll get student course details
    *   @params student_id
    *   @author GBS-R
    */
    // public function filename_exists($qualification)
    // {
    //     $this->db->select('*'); 
    //     $this->db->from('am_student_qualification');
    //     $this->db->where('qualification', $qualification);
    //     $query = $this->db->get();
    //     $result = $query->result_array();
    //     return $result;
    // }

    function filename_exists($qualification) {
        $this->db->where('qualification', $qualification);
        return $this->db->count_all_results('am_student_qualification'); 
      }
    public function get_student_course_details($student_id = NULL)
    {
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_student_course_mapping.branch_id');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->join('am_syllabus', 'am_syllabus.syllabus_id = am_classes.syllabus_id');
        $this->db->join('am_batch_mode', 'am_batch_mode.mode_id = am_classes.batch_mode_id');
        $this->db->where('am_student_course_mapping.student_id', $student_id);
        //$this->db->where('am_discount_master.status!=', 4);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;
    }
        /*
    *   function'll get subject details under a course 
    *   @params course_id
    *   @author GBS-L
    */
    
    public function get_course_subject_details($courseid)
    {
       // $query= $this->db->select('t1.parent_subject_master_id, t2.subject_name, t3.class_name')
        $query= $this->db->select('t1.parent_subject_master_id,t1.syllabus_file,t2.subject_name')
         ->from('mm_subject_course_mapping as t1')
         ->where('t1.subject_status', '1')
         ->where('t1.course_master_id', $courseid)
         ->group_by('t1.parent_subject_master_id')
         ->join('mm_subjects as t2', 't1.parent_subject_master_id = t2.subject_id')
        // ->join('am_classes as t3', 't1.course_master_id = t3.class_id')
         ->get();
        $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }
    
    
    /*
    *
    *   function'll apply discount to student
    *   @params amount, discount id
    *   @author GBS-R
    */
    
     public function update_discount($discount_amount,$st_discount_id)
    {
         $this->db->where(array('st_discount_id'=>$st_discount_id));
         $query=$this->db->update('pp_student_discount',array('discount_amount'=>$discount_amount));
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function is_doc_exist($data)
    {
       $query= $this->db->get_where('am_student_documents',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }





    //     $query= $this->db->get_where('am_students',array("student_id"=>$id));
    //     $resultArr	=	array();
    //     if($query->num_rows()>0)
    //     {
    //        $resultArr=$query->row_array();
    //     }
    //   return   $resultArr;



    // $this->db->where($data);
    // $query= $this->db->get('am_institute_master');
    public function is_doc1_exist($stud_id,$document_name1,$qualification_id)
    {

        // $this->db->where($data);
        // $query= $this->db->get('am_student_documents');
        $query= $this->db->get_where('am_student_documents',array("student_id"=>$stud_id,"qualification_id"=>$qualification_id,"document_name"=>$document_name1));
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }

    }
    public function get_student_docs($student_id,$qualification_id)
    {
    $query= $this->db->where('student_id',$student_id)->where('qualification_id',$qualification_id)->get('am_student_documents')->row_array(); 
    }
    
    
    /*
    *   function'll get the student list by pagination
    *   @author GBS-L
    */
    public function student_list_pagination($start, $length, $order, $dir)
    {
        if($order !=null) {
            $this->db->order_by($order, $dir);
        }
         $query	  = $this->db->select('*')
                    ->from('am_students')
                    ->limit($length,$start)
                    ->order_by('am_students.student_id','desc')

                    ->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    }
    /*
    *   function'll get the number of data in a single page, student list by pagination
    *   @author GBS-L
    */
    public function get_num_student_list_pagination()
    {

		$query	= $this->db->select('*')
                  ->from('am_students')
                  ->order_by('am_students.student_id','desc')
                  ->get();


		return $query->num_rows();

    }

    public function save_student_credential($student_credential)
    {
        $query=$this->db->insert('am_users',$student_credential);
            if($query)
            {
                return true;
            }
           else
           {
               return false;
           } 
    }
    
    /*
    *   function'll check basic qualification document verified or not
    *   @params student id, category
    *   @author GBS-R
    */ 
    
    function check_basic_qualification($student_id, $category) {
        $this->db->select('*');
        $this->db->from('am_student_documents'); 
        $this->db->join('am_student_qualification', 'am_student_qualification.qualification_id=am_student_documents.qualification_id');
        $this->db->where('am_student_documents.student_id', $student_id); 
        $this->db->where('am_student_qualification.category', $category); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }


    function get_student_exams(){
        $this->db->distinct(); 
        $this->db->select('*');
        $this->db->from('web_notifications');
        $this->db->where('notification_status', 1);

        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();
        }
        return $resultArr;
    }

    public function get_exam_list()
    {
        $this->db->distinct(); 
        $this->db->select('web_examlist.*, am_students.name as student_name,am_students.contact_number,am_classes.class_name,web_notifications.name as exam_name');
        $this->db->from('web_examlist');
        $this->db->join('am_students', 'am_students.student_id = web_examlist.student_id');
        $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id','left');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->order_by('am_students.student_id','desc');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}
		return $resultArr;
    }

    function fetch_data($filter_exam,$filter_course)
    {
        $this->db->distinct(); 
        $this->db->select('web_examlist.*, am_students.name as student_name,am_students.contact_number,am_classes.class_name,web_notifications.name as exam_name');
        $this->db->from('web_examlist');
        $this->db->join('am_students', 'am_students.student_id = web_examlist.student_id','left');
        $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id','left');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id','left');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        if($filter_exam != ''){
            $this->db->where('web_notifications.notification_id', $filter_exam);
        }
        if($filter_course != ''){
            $this->db->where('am_classes.class_id', $filter_course);
        }
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->order_by('am_students.student_id','desc');
        return $this->db->get();

        // $this->db->select('am_students.*, am_students.name as student_name,am_students.contact_number,cities.name as city_name,am_student_course_mapping.course_id,web_examlist.hall_tkt,am_classes.class_name,web_notifications.name as exam_name');
        // $this->db->from('am_students');
        // $this->db->join('cities', 'cities.id = am_students.district');
        // $this->db->join('web_examlist', 'web_examlist.student_id = am_students.student_id','left');
        // $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id');
        // $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
        // $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        // if($filter_exam != ''){
        //     $this->db->where('web_notifications.notification_id', $filter_exam);
        // }
        // if($filter_course != ''){
        //     $this->db->where('am_classes.class_id', $filter_course);
        // }
        // $this->db->where('am_students.status <',10);
        // // $this->db->where('am_student_course_mapping.status', 1);
        // $this->db->order_by('am_students.student_id','desc');
        // // echo $this->db->last_query(); exit;
        // return $this->db->get();

    }

    function fetch_data_teacher($filter_exam,$filter_course, $courseArr)
    {
        $this->db->distinct(); 
        $this->db->select('web_examlist.*, am_students.name as student_name,am_students.contact_number,am_classes.class_name,web_notifications.name as exam_name');
        $this->db->from('web_examlist');
        $this->db->join('am_students', 'am_students.student_id = web_examlist.student_id','left');
        $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id','left');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id','left');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        // if($filter_exam != ''){
        //     $this->db->where('web_notifications.notification_id', $filter_exam);
        // }
        // if($filter_course != ''){
        //     $this->db->where('am_classes.class_id', $filter_course);
        // }
        if(!empty($courseArr)) {
            $this->db->where_in('am_student_course_mapping.course_id', $courseArr);
        }
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->order_by('am_students.student_id','desc');
        return $this->db->get();

    }

    
    public function get_exam_list_by_ajax($filter_exam,$filter_course,$start,$length,$order, $dir) 
    {
        if($order != null) {
            $this->db->order_by($order, $dir);
        }
        $this->db->distinct(); 
        $this->db->select('web_examlist.*, am_students.name as student_name,am_students.contact_number,am_classes.class_name,web_notifications.name,web_notifications.name as exam_name');
        $this->db->from('web_examlist');
        $this->db->join('am_students', 'am_students.student_id = web_examlist.student_id');
        $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id','left');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        if($filter_exam != ''){
            $this->db->where('web_notifications.notification_id', $filter_exam);
        }
        if($filter_course != ''){
            $this->db->where('am_classes.class_id', $filter_course);
        }
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->order_by('am_students.student_id','desc');
        $this->db->limit($length,$start);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }

    public function get_num_exams_by_ajax()
    {
        $this->db->distinct(); 
        $this->db->select('web_examlist.*, am_students.name as student_name,am_students.contact_number,am_classes.class_name,web_notifications.name,web_notifications.name as exam_name');
        $this->db->from('web_examlist');
        $this->db->join('am_students', 'am_students.student_id = web_examlist.student_id');
        $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id','left');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->order_by('am_students.student_id','desc');
        $query	=	$this->db->get();
        // echo $this->db->last_query();
        return $query->num_rows();
    }

    
    function edit_examlist($data,$id){
        $this->db->where('examlist_id',$id);
		$query	= $this->db->update('web_examlist',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
    }

    function get_all_exams($filter_course) { 
        $this->db->distinct(); 
        $this->db->select('web_notifications.*,web_notifications.name as exam_name');
        $this->db->from('web_examlist');
        $this->db->join('am_students', 'am_students.student_id = web_examlist.student_id','left');
        $this->db->join('web_notifications', 'web_notifications.notification_id = web_examlist.notification_id','left');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id','left');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where('am_classes.class_id', $filter_course);
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->order_by('am_students.student_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();		
        }
    
        return $resultArr;
    }
    
    function get_all_branches($course_id) {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
        $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
        $this->db->group_by('am_institute_course_mapping.branch_master_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();		
        }
    
        return $resultArr;
    } 


    
    /*
    *   function'll list the student list for progress report
    *   @params 
    *   @author GBS-L
    */ 
    public function get_students_progress_list()
    {
        $this->db->select('am_students.*, cities.name as city_name');
        $this->db->from('am_students');
        $this->db->join('cities', 'cities.id = am_students.district');
        //$this->db->join('am_student_qualification', 'am_student_qualification.student_id = am_students.student_id');
        $this->db->where('am_students.status','1');
        $this->db->order_by('am_students.student_id','desc');

	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }
    
    /*This function will return the list of course under te schoolid and centre id
    @params school_id,centre_id
    @auther GBS-L
    */
    public function get_course_bySchool_centre($school_id,$centre_id)
    {
        $this->db->select('*');
        $this->db->from('am_classes');
        //$this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_master_id = am_classes.class_id');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id = am_classes.class_id');
        $this->db->where(array('am_classes.school_id'=>$school_id,'am_institute_course_mapping.institute_master_id'=>$centre_id,"am_classes.status"=>"1","am_institute_course_mapping.status"=>"1"));
        $this->db->group_by('am_classes.class_name');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr; 
    }
    
    /*This function will return the list of students 
    @params school_id,centre_id,course_id_batch_id
    @auther GBS-L
    */
    public function search_student_progresslist($where)
    {
        $this->db->select('am_students.*');
        $this->db->from('am_students');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
        $this->db->where('am_students.status','1');
        $this->db->where($where);
        $this->db->order_by('am_students.student_id','desc');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }
    
    
/*
*   function'll get student exam detail by id
*   @params student id
*   @author GBS-R
*/


    function get_batch_examdetails($batch_id = NULL) {
        //$this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*,gm_exam_question_paper.*');
        $this->db->select('gm_exam_result_summary.*,gm_exam_schedule.*,gm_exam_definition.*,MAX(gm_exam_result_summary.total_mark) as max, MIN(gm_exam_result_summary.total_mark) as min ,AVG(gm_exam_result_summary.total_mark) as avg');
        $this->db->from('gm_exam_result_summary');
        $this->db->join('gm_exam_schedule', 'gm_exam_schedule.id = gm_exam_result_summary.exam_id');
        $this->db->join('gm_exam_definition', 'gm_exam_definition.id = gm_exam_schedule.exam_definition_id');
        //$this->db->join('gm_exam_question_paper', 'gm_exam_question_paper.exam_schedule_id = gm_exam_result_summary.exam_id');
        $this->db->where('gm_exam_schedule.batch_id', $batch_id);
        $this->db->where('gm_exam_schedule.status !=', -1);
        $this->db->group_by('gm_exam_result_summary.attempt');
        $this->db->group_by('gm_exam_result_summary.exam_id');
        //$this->db->where('gm_exam_schedule.status', 4);
        //$this->db->where('gm_exam_result_summary.attempt', $attempt);
	    $query	=	$this->db->get();
        //echo $this->db->last_query();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}
		return $resultArr;
    }
    
/*
*   function'll get student exam detail by id
*   @params student id
*   @author GBS-R
*/
    
    function get_section_fromqsn($attempt = NULL, $exam_id = NULL) {
        $this->db->select('secton_id');
        $this->db->from('gm_exam_result');
        $this->db->where('attempt', $attempt);
        $this->db->where('exam_id', $exam_id);
        $this->db->group_by('secton_id');
	    $query	=	$this->db->get();
		$resultArr	=	array();
        $sectionArr = array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
            if(!empty($resultArr)) {
                foreach($resultArr as $result) { 
                    array_push($sectionArr, $result['secton_id']);
                }
                
            }
		}

		return $sectionArr;
    }
  /*
    *   function'll get the student list report by pagination
    *   @author GBS-L
    */
    public function student_report_pagination($start, $length, $order, $dir)
    {
        if($order !=null) {
            $this->db->order_by($order, $dir);
        }
         $query	  = $this->db->select('am_students.*,am_student_course_mapping.course_id')
                    ->from('am_students')
                    ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
                    ->limit($length,$start)
                    ->order_by('am_students.student_id','desc')
                    ->group_by('am_students.student_id')
                    ->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    }  
    
    public function search_student($where)
    {
      $query	  = $this->db->select('am_students.*,am_student_course_mapping.*,am_classes.school_id,cc_call_center_enquiries.call_status,am_student_course_mapping.status as student_course_status,am_students.status as student_status')
                    ->from('am_students')
                    ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
                    ->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id')
                    ->join('cc_call_center_enquiries', 'cc_call_center_enquiries.call_id = am_students.caller_id','LEFT')
                    ->where($where)
                    ->where('am_students.status <',10)
                    ->order_by('am_students.student_id','desc')
                    ->group_by('am_students.student_id')
                    ->get();
        $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    }  
    
    public function get_student_list_msg($where)
    {
       $query	  = $this->db->select('am_students.*,am_student_course_mapping.*')
                    ->from('am_students')
                    ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
                    ->where($where)
                    ->where(array("am_students.status"=>1))
                    
                    ->get();
        $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr; 
    }
    // public function get_student_lists($where)
    // {
    //    $query	  = $this->db->select('am_students.*,am_student_course_mapping.*')
    //                 ->from('am_students')
    //                 ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
    //                 ->where($where)
    //                 ->where(array("am_students.status"=>1))
                    
    //                 ->get();
    //     $resultArr	=	array();
	// 	if($query->num_rows() > 0)
    //     {
	// 		$resultArr	=	$query->result_array();
	// 	}

	// 	return $resultArr; 
    // }

    function get_staff_list_by_roles($role = NULL) {
        // $this->db->distinct();
        $this->db->select('am_staff_personal.*,countries.name as countryname,am_mentor.student_id');
        $this->db->from('am_staff_personal');
        $this->db->join('countries', 'countries.id = am_staff_personal.spouse_country');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id = am_staff_personal.user_id');
        $this->db->join('am_mentor', 'am_mentor.staff_id = am_staff_personal.personal_id');
        $this->db->where_in('am_users_backoffice.user_role', $role);
        $this->db->group_by('am_mentor.staff_id');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
            
        }
        return $resultArr;
    }

    //------------------------------------------------
    /**
	*This function 'll return existing exam details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_mentor_exist($student_ids)
    {
        $query= $this->db->get_where('am_mentor',array("student_id"=>$student_ids));
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert exam details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function mentor_add($data)
    {
		$res=$this->db->insert('am_mentor',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    public function get_student_list_byMentor($where)
    {
       $query	  = $this->db->select('am_students.*,am_student_course_mapping.*')
                    ->from('am_students')
                    ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
                    ->join('am_mentor', 'am_mentor.student_id = am_students.student_id')
                    ->where($where)
                    ->where('am_students.status <',10)
                    
                    ->get();
        $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr; 
    }

    public function edit_get_student_list_byMentor($where)
    {
       $query	  = $this->db->select('am_students.*,am_student_course_mapping.*')
                    ->from('am_students')
                    ->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id')
                    ->join('am_mentor_meeting_details', 'am_mentor_meeting_details.student_id = am_students.student_id')
                    ->where($where)
                    
                    ->get();
        $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr; 
    }

    // public function get_classrooms()
    // {
    //     $query	=	$this->db->get('am_classrooms');
	// 	$resultArr	=	array();
	// 	if($query->num_rows() > 0){
	// 		$resultArr	=	$query->result_array();		
	// 	}
	// 	return $resultArr;
    // }
    

    function get_classrooms($batch_id) {
        $this->db->select('*');
        $this->db->from('am_classrooms');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_classrooms.institute_master_id');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_master_id = am_institute_master.institute_master_id','left');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id','left');
        $this->db->where('am_batch_center_mapping.batch_id', $batch_id);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
            
        }
        return $resultArr;
    }

    function edit_get_classrooms($batch_id) {
        $this->db->select('*');
        $this->db->from('am_classrooms');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_classrooms.institute_master_id');
        $this->db->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_master_id = am_institute_master.institute_master_id','left');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.institute_course_mapping_id = am_institute_course_mapping.institute_course_mapping_id','left');
        $this->db->where('am_batch_center_mapping.batch_id', $batch_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();		
        }
    
        return $resultArr;
    }

    //---------------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/	
	function insert_meeting($data){		
		$this->db->insert('am_mentor_meeting',$data);	
		$rows=  $this->db->insert_id();
		if($rows>0){
			return $rows;
		}else{
		return FALSE;
		}
	}
    //---------------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/
	public function edit_meeting($data,$meeting_id){
		$this->db->where('meeting_id',$meeting_id);
		$res	= $this->db->update('am_mentor_meeting',$data);
		if($res){
			return true;
		}else{
			return false;
		}
    }
    

    function update_details_batch($detailsArr) {
		foreach($detailsArr as  $key=>$row){
			$this->db->select('details_id');
		    $this->db->where('student_id',$row['student_id']);
		    $this->db->where('meeting_id',$row['meeting_id']);
		    $query	= $this->db->get('am_mentor_meeting_details');
			if($query->num_rows() > 0){
				$resultArr	= $query->result_array();
				foreach ($resultArr as $result) {
					$details_id = $result['details_id']; 
					$this->db->where('details_id',$details_id);
					$this->db->update('am_mentor_meeting_details',$row);
				}
		    } else {
			 	$this->db->insert('am_mentor_meeting_details',$row);
		   	}
		}
	}

	//------------------------------------------------

    /**
	*This function 'll insert route details 
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function details_add($detailsArr)
    {
		foreach($detailsArr as  $key=>$row){
			$res=$this->db->insert('am_mentor_meeting_details',$row);
		}
	    if($res){
            return true;
        }else{
            return false;
        }
    }


    public function insert_data($detailsArr)
    {
        $this->db->trans_start();
        foreach($detailsArr as  $key=>$row){
            $this->db->insert('am_mentor_meeting_details',$row);
            $student_id = $this->db->insert_id();
            // $mapArr['student_id']=$student_id;
            $this->db->insert('am_student_feedback',$student_id);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return "2";  
        }else{
            $this->db->trans_commit();
            return "1";
        }
    }
    //------------------------------------------------
    function get_meeting_list() {
        // $this->db->select('am_mentor_meeting_details.*,am_mentor_meeting.date,am_mentor_meeting.time,am_classrooms.classroom_name,am_staff_personal.name');
        // $this->db->from('am_mentor_meeting_details'); 
        // $this->db->join('am_mentor_meeting', 'am_mentor_meeting.meeting_id=am_mentor_meeting_details.meeting_id');
        // $this->db->join('am_classrooms', 'am_classrooms.room_id=am_mentor_meeting.room_id','left');
        // $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_mentor_meeting.staff_id','left');
        // $query	=	$this->db->get();
        // $resultArr	=	array();
        // if($query->num_rows() > 0){
        //     $resultArr	=	$query->result_array();		
        // }
        // return $resultArr;
        $this->db->select('am_mentor_meeting.*,am_classrooms.classroom_name,am_staff_personal.name');
        $this->db->from('am_mentor_meeting'); 
        $this->db->join('am_classrooms', 'am_classrooms.room_id=am_mentor_meeting.room_id');
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_mentor_meeting.staff_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }

      //------------------------------------------------
    /**
	*This function 'll get route details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function get_meetings_by_id($meeting_id)
    {
		// $query	= $this->db->select('*')
		// ->from('am_mentor_meeting')
		// ->where('am_mentor_meeting.meeting_id', $meeting_id)
		// ->get();
		// $resultArr	=	array();
		// if($query->num_rows() > 0){
		// 	$resultArr	=	$query->row_array();
		// }
        // return $resultArr;
        







        $query	=	$this->db->select('am_mentor_meeting.*, am_batch_center_mapping.batch_id,am_batch_center_mapping.batch_name')
                         ->from('am_mentor_meeting')
                         ->where('am_mentor_meeting.meeting_id', $meeting_id)
                         ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_mentor_meeting.batch_id','left')
                         ->get();
        if($query->num_rows()>0)
        {
           return $query->row_array();
        }
        else
        {
            return false;
        }
	}
	//---------------------------------------------------------
	public function get_meeting_details_by_id($meeting_id)
    {
        $this->db->select('*');
        $query= $this->db->get_where('am_mentor_meeting_details',array('meeting_id'=>$meeting_id));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();

        }
         return $data_array;
    }
    
    function get_stud_list() {
        // $this->db->select('am_mentor_meeting_details.*,am_mentor_meeting.date,am_mentor_meeting.time,am_classrooms.classroom_name,am_staff_personal.name');
        // $this->db->from('am_mentor_meeting_details'); 
        // $this->db->join('am_mentor_meeting', 'am_mentor_meeting.meeting_id=am_mentor_meeting_details.meeting_id');
        // $this->db->join('am_classrooms', 'am_classrooms.room_id=am_mentor_meeting.room_id','left');
        // $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_mentor_meeting.staff_id','left');
        // $query	=	$this->db->get();
        // $resultArr	=	array();
        // if($query->num_rows() > 0){
        //     $resultArr	=	$query->result_array();		
        // }
        // return $resultArr;
        $this->db->select('am_mentor_meeting_details.*,am_students.name,am_students.registration_number,am_student_feedback.comment');
        $this->db->from('am_mentor_meeting_details'); 
        $this->db->join('am_students', 'am_students.student_id=am_mentor_meeting_details.student_id');
        $this->db->join('am_student_feedback', 'am_student_feedback.student_id=am_mentor_meeting_details.student_id','left');

        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }


    public function feedback_add($data)
    {
        if($data['student_id']== 'All'){
            $mentors =$this->db->select('student_id,meeting_id')->where('meeting_id',$data['meeting_id'])->get('am_mentor_meeting_details')->result();
            foreach($mentors as  $key=>$row){
                $feedback =$this->db->select('feedback_id,student_id,meeting_id,feedback_status')->where('meeting_id',$data['meeting_id'])->where('student_id',$row->student_id)->get('am_student_feedback')->row_array();
                if(!empty($feedback)){
                    $query=$this->db->where('feedback_id',$feedback['feedback_id'])->delete('am_student_feedback');	
                    $mentors[$key]->comment = $this->input->post('comment');
                    $mentors[$key]->feedback_status = $feedback['feedback_status']; 	
                }else{
                    $mentors[$key]->feedback_status =  1; 	
                }
                $mentors[$key]->comment = $this->input->post('comment');            
            }
            $res =$this->db->insert_batch('am_student_feedback',$mentors);
            if($res){
                return true;
            }else{
                return false;
            }
        }else{
            $feedbacks =$this->db->select('feedback_id,student_id,meeting_id,feedback_status')->where('meeting_id',$data['meeting_id'])->where('student_id',$data['student_id'])->get('am_student_feedback')->row_array();
            if(!empty($feedbacks)){
                $this->db->where('feedback_id',$feedbacks['feedback_id']);
                $query	= $this->db->update('am_student_feedback',$data);
                $return	=	true;
                if(!$query){
                    $return	=	false;
                }
                return  $return;
            }else{
                $res = $this->db->insert('am_student_feedback',$data);	
                if($res){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    public function is_feedback_exist($data)
    {
        if($data['student_id']== 'All'){
            $query= $this->db->get_where('am_student_feedback',$data);
            if($query->num_rows()>0){
            return true;
            }else{
                return false;
            }
        }
    }

    public function get_staff_id($personal_id)
    {

        $this->db->select('am_mentor_meeting.*,am_staff_personal.name');
        // $this->db->from('am_mentor_meeting'); 
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_mentor_meeting.staff_id');


		// $this->db->select('*');
		$this->db->where('am_staff_personal.personal_id',$personal_id);
        return $this->db->get('am_mentor_meeting')->row_array();
        
    }
    
    //------------------------------------------------
    /**
	*This function 'll get discount details by id
	*
	* @access public
	* @params package_master_id
	* @return integer
	* @author Seethal
	*/
    public function get_feedbackdetails_by_id($id)
    {
        // $query	=	$this->db->select('*')
        //             ->from('am_student_feedback')
        //             ->where('am_student_feedback.feedback_id', $id)
        //             ->get();
        // if($query->num_rows()>0){
        //    return $query->row_array();
        // }else{
        //     return false;
        // }
        $this->db->select('am_mentor_meeting_details.*,am_students.name,am_students.registration_number,am_student_feedback.comment');
        $this->db->from('am_mentor_meeting_details'); 
        $this->db->join('am_students', 'am_students.student_id=am_mentor_meeting_details.student_id');
        $this->db->join('am_student_feedback', 'am_student_feedback.student_id=am_mentor_meeting_details.student_id');
        $query	=	$this->db->get();
        if($query->num_rows()>0){
            return $query->result_array();
         }else{
             return false;
         }
    }
    function get_staff_active_batch($staff_id = NULL) {
        $this->db->select('*');
        $this->db->from('am_schedules'); 
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=am_schedules.schedule_link_id');
        $this->db->join('am_schedule_learning_module', 'am_schedule_learning_module.schedule_id = am_schedules.schedule_id');
        $this->db->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_detail_id = am_schedules.module_id');
        $this->db->join('mm_subjects', 'mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
        // $this->db->join('mm_subjects', 'mm_subjects.subject_id = am_schedules.module_id');
        $this->db->where('am_schedules.schedule_type',2);
        $this->db->where('am_schedules.staff_id',$staff_id);
        $this->db->order_by('am_schedules.schedule_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();
        }
        // show($resultArr);
        return $resultArr;
    }
    function get_single_batch($staff_id, $batch_id) {
        $this->db->select('*');
        $this->db->from('am_schedules'); 
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=am_schedules.schedule_link_id');
        $this->db->join('am_schedule_learning_module', 'am_schedule_learning_module.schedule_id = am_schedules.schedule_id');
        $this->db->join('mm_subjects', 'mm_subjects.subject_id = am_schedules.module_id');
        $this->db->where('am_schedules.schedule_type',2);
        $this->db->where('am_schedules.staff_id',$staff_id);
        $this->db->where('am_batch_center_mapping.batch_id',$batch_id);
        // $this->db->order_by('am_schedules.schedule_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result();
        }
        // show($resultArr);
        return $resultArr;
    }

    function get_stud_meeting_list($student_id) {
        $this->db->select('am_mentor_meeting.*,am_classrooms.classroom_name,am_staff_personal.name,am_mentor_meeting_details.student_id,am_batch_center_mapping.batch_name,am_classes.class_name,am_institute_master.institute_name');
        $this->db->from('am_mentor_meeting'); 
        $this->db->join('am_mentor_meeting_details', 'am_mentor_meeting_details.meeting_id=am_mentor_meeting.meeting_id');
        $this->db->join('am_classrooms', 'am_classrooms.room_id=am_mentor_meeting.room_id');
        $this->db->join('am_students', 'am_students.student_id=am_mentor_meeting_details.student_id');
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_mentor_meeting.staff_id');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=am_mentor_meeting.batch_id');
        $this->db->join('am_classes', 'am_classes.class_id=am_mentor_meeting.course_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_mentor_meeting.centre_id');

        $this->db->where('am_students.student_id',$student_id);

        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->row_array();		
        }
        return $resultArr;
    }
    public function get_active_job($user_id){
        $this->db->select('approval_flow_entity_details.*,approval_flow_entities.entity_name,approval_flow_entities.flow_levels');
        $this->db->from('approval_flow_entities'); 
        $this->db->join('approval_flow_entity_details', 'approval_flow_entity_details.flow_entities=approval_flow_entities.id');
        // $this->db->group_by('approval_flow_entity_details.flow_entities');
        $this->db->where('approval_flow_entity_details.user_id',$user_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    // public function get_active_job($user_id){
    //     $this->db->select('approval_flow_entity_details.*,approval_flow_entities.entity_name,approval_flow_entities.flow_levels');
    //     $this->db->from('approval_flow_entity_details'); 
    //     $this->db->join('approval_flow_entities', 'approval_flow_entities.id=approval_flow_entity_details.flow_entities');
    //     // $this->db->group_by('approval_flow_entity_details.flow_entities');
    //     $this->db->where('approval_flow_entity_details.user_id',$user_id);
    //     $query	=	$this->db->get();
    //     $resultArr	=	array();
    //     if($query->num_rows() > 0){
    //         $resultArr	=	$query->result();		
    //     }
    //     return $resultArr;
    // }
    public function get_active_jobs($id){
        $this->db->select('approval_flow_jobs.*,approval_flow_entity_details.flow_entities,approval_flow_entity_details.level'); 
        $this->db->from('approval_flow_jobs'); 
        $this->db->join('approval_flow_entity_details', 'approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id');
        $this->db->where('approval_flow_jobs.flow_detail_id',$id);
        $this->db->order_by('approval_flow_jobs.id','DESC');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
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
    public function get_carrentLevel($flowDetailId){
        $user_id = $this->session->userdata('user_primary_id');
        $this->db->select('*'); 
        $this->db->where('user_id',$user_id);
        $this->db->where('id',$flowDetailId);
        $query	=	$this->db->get('approval_flow_entity_details');
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    public function get_maximumLevel($flowEntities){
        $this->db->select('flow_levels'); 
        $this->db->where('id',$flowEntities);
        $query	=	$this->db->get('approval_flow_entities');
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->row()->flow_levels;		
        }
        return $resultArr;
    }
    public function get_nextUsers($level, $flowEntities){
        $this->db->select('*'); 
        $this->db->where('level',$level);
        $this->db->where('flow_entities',$flowEntities);
        $query	=	$this->db->get('approval_flow_entity_details');
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    public function get_jobsUsers($flowDetailId){
        $this->db->select('*');
        $this->db->where('flow_detail_id',$flowDetailId);
        $query	=	$this->db->get('approval_flow_jobs');
        $resultArr	=	array();
        $resultArr	=	$query->num_rows();		
        return $resultArr;
    }
    public function get_jobstatusChange($jobId, $status){
        $this->db->where('id', $jobId);
        $query=$this->db->update('approval_flow_jobs',array('status'=>$status));
        if($query){
            return 1;
        }else{
            return 0;
        }
    }
    public function get_questionsetStatusChange($flowId, $entityID){
        $getEntity = $this->db->where('id',$flowId)->get('approval_flow_entities')->row();
        // show($getEntity);
        if(!empty($getEntity)){
            $this->db->where($getEntity->primary_key_column, $entityID);
            $query=$this->db->update($getEntity->entity_table_name ,array($getEntity->table_status_column => $getEntity->approval_completed_status));
            if($query){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public function get_checkJob($jobId,$entity_id, $status){
        $this->db->select('approval_flow_entity_details.*');
        $this->db->from('approval_flow_entity_details');
        $this->db->join('approval_flow_jobs','approval_flow_jobs.flow_detail_id = approval_flow_entity_details.id');
        $this->db->where('approval_flow_jobs.id', $jobId);
        $flowEntities = $this->db->get()->row()->flow_entities;
        $this->db->select('approval_flow_jobs.flow_detail_id, approval_flow_jobs.entity_id');
        $this->db->from('approval_flow_jobs');
        $this->db->join('approval_flow_entity_details','approval_flow_entity_details.id=approval_flow_jobs.flow_detail_id');
        $this->db->where('approval_flow_entity_details.flow_entities', $flowEntities);
        $this->db->where('approval_flow_jobs.entity_id',$entity_id);
        $this->db->where('approval_flow_jobs.status',$status);
        $this->db->order_by('approval_flow_jobs.id','DESC');
        $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
            $resultArr	=	$query->row_array();
            $resultArr['rejected_by'] = $jobId;
        }
        // show($resultArr);
        return $resultArr;
    }
    public function update_entityStatus($jobId, $entityID){
        $this->db->select('approval_flow_entities.*');
        $this->db->from('approval_flow_entities');
        $this->db->join('approval_flow_entity_details','approval_flow_entity_details.flow_entities = approval_flow_entities.id');
        $this->db->where('approval_flow_entity_details.id', $entityID);
        $flow_levels = $this->db->get()->row();
        // echo $this->db->last_query(); exit;
        // show($flow_levels);
        $getEntity = $this->db->where('id',$flow_levels->id)->get('approval_flow_entities')->row();
        if(!empty($getEntity)){
            $this->db->where($getEntity->primary_key_column, $jobId);
            $query=$this->db->update($getEntity->entity_table_name ,array($getEntity->table_status_column => 101));
            if($query){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        // $this->db->where('question_set_id', $entityID);
        // $query = $this->db->update('mm_question_set',array('question_set_status'=>$status));
        // if($query){
        //     return 1;
        // }else{
        //     return 0;
        // }
    }
    public function get_entityStatus($jobId){
        // $this->db->select('approval_flow_entities.flow_levels');
        // $this->db->from('approval_flow_entities');
        // $this->db->join('approval_flow_entity_details','approval_flow_entity_details.flow_entities = approval_flow_entities.id');
        // $this->db->where('approval_flow_entity_details.id', $jobId);
        // $flow_levels = $this->db->get()->row()->flow_levels;
        $this->db->select('approval_flow_entity_details.level');
        $this->db->from('approval_flow_entity_details');
        $this->db->join('approval_flow_jobs','approval_flow_jobs.flow_detail_id = approval_flow_entity_details.id');
        $this->db->where('approval_flow_jobs.id', $jobId);
        $level = $this->db->get()->row()->level;
        if($level == 1){
            return 1;
        }else{
            return 0;
        }
    }



    function staff_centre_branch($center_id = NULL) {
        $this->db->select('*'); 
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_staff_personal.center');
        $this->db->where('am_staff_personal.center',$center_id);
        $this->db->where('am_staff_personal.role','centerhead');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }

    /*
    *   function'll get batch details
    *   @params 
    *   @author GBS-R
    */
    
    public function get_batch_list()
    {
        $this->db->select('*');
        $this->db->from('am_batch_center_mapping');
        $this->db->where('am_batch_center_mapping.batch_status', 1);
        $this->db->order_by('am_batch_center_mapping.batch_datefrom', 'DESC');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }


        /*
    *   function'll get batch details
    *   @params 
    *   @author GBS-R
    */
    
    public function get_batch_student($batch_id = NULL)
    {
       
        $this->db->select('*');
        $this->db->from('am_students');
        $this->db->join('am_student_course_mapping','am_student_course_mapping.student_id = am_students.student_id');
        $this->db->join('am_users','am_users.user_primary_id = am_students.student_id');
        $this->db->where('am_student_course_mapping.batch_id', $batch_id);
        $this->db->where('am_students.status', 1);
        $this->db->where('am_student_course_mapping.status', 1);
        $this->db->group_by('am_student_course_mapping.student_id');
        $this->db->order_by('am_students.student_id', 'ASC');
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }

    public function get_student_bysearch($applicationno = NULL, $email = NULL, $mobileno = NULL, $name = NULL, $route = NULL){
        // show($email);
        $this->db->select('am_students.*,am_student_course_mapping.course_id');
        $this->db->from('am_students');
        //$this->db->join('am_students','tt_student_transport.student_id = am_students.student_id');
        //$this->db->join('tt_transport','tt_transport.transport_id = tt_student_transport.route_id');
        //$this->db->join('cities', 'cities.id = am_students.district');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');        
        $this->db->join('am_users','am_users.user_primary_id = am_students.student_id');
        if($applicationno!='') {
            $this->db->like('am_students.registration_number', $applicationno);
        }
        if($email!='') {
            $this->db->like('am_students.email', $email);
        }
        if($mobileno!='') {
            $this->db->like('am_students.mobile_number', $mobileno);
        } 
        // if($name!='') {
        //     $this->db->like('am_students.name', $name);
        // } 
        // if($route!='') {
        //     $this->db->like('am_students.place', $route);
        // } 
        $this->db->where('am_students.status', 1);
        $this->db->group_by('am_students.student_id');
        $this->db->order_by('am_students.registration_number','asc');
        $query	=	$this->db->get(); //echo $this->db->last_query();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result();
		}

		return $resultArr;
    }

            /*
    *   function'll get batch details
    *   @params 
    *   @author GBS-R
    */
    
    // public function get_student_bysearch($applicationno = NULL, $email = NULL, $mobileno = NULL, $name = NULL, $route = NULL)
    // {
       
    //     $this->db->select('*');
    //     $this->db->from('am_students');
    //     $this->db->join('am_student_course_mapping','am_student_course_mapping.student_id = am_students.student_id');
    //     $this->db->join('am_users','am_users.user_primary_id = am_students.student_id');
    //     $this->db->join('tt_transport','tt_transport.transport_id = am_students.place');
    //     if($applicationno!='') {
    //     $this->db->like('am_students.registration_number', $applicationno);
    //     }
    //     if($email!='') {
    //         $this->db->like('am_students.email', $email);
    //     }
    //     if($mobileno!='') {
    //         $this->db->like('am_students.mobile_number', $mobileno);
    //     } 
    //     if($name!='') {
    //         $this->db->like('am_students.name', $name);
    //     } 
    //     if($route!='') {
    //         $this->db->like('am_students.place', $route);
    //     } 
    //     $this->db->where('am_students.transportation', 'yes');  
    //     $this->db->where('am_students.place is NOT NULL', NULL, FALSE);   
    //     $this->db->where('am_students.status', 1);
    //     $this->db->order_by('am_students.student_id', 'ASC');
    //     $query	=	$this->db->get(); //echo $this->db->last_query();
	// 	$resultArr	=	array();
	// 	if($query->num_rows() > 0)
    //     {
	// 		$resultArr	=	$query->result();
	// 	}

	// 	return $resultArr;
    // }
    public function get_transport_student_list() {
        $this->db->select('am_students.*,tt_student_transport.*,tt_transport.*,tt_student_transport.status as trans_status, cities.name as city_name,am_student_course_mapping.course_id');
        $this->db->from('tt_student_transport');
        $this->db->join('am_students','tt_student_transport.student_id = am_students.student_id');
        $this->db->join('tt_transport','tt_transport.transport_id = tt_student_transport.route_id');
        $this->db->join('cities', 'cities.id = am_students.district');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
        $this->db->order_by('tt_student_transport.st_id','desc');

	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array(); 
		}
        return $resultArr;
    }

    // public function get_transport_student_list()
    // {
    //     $this->db->select('am_students.*,tt_transport.*, cities.name as city_name,am_student_course_mapping.course_id');
    //     $this->db->from('am_students');
    //     $this->db->join('cities', 'cities.id = am_students.district');
    //     $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
    //     $this->db->join('tt_transport','tt_transport.transport_id = am_students.place');
    //     //$this->db->where('am_students.transportation', 'yes');
    //     $this->db->where('am_students.place is NOT NULL', NULL, FALSE);
    //     $this->db->group_by('am_students.student_id');
    //     $this->db->order_by('am_students.student_id','desc');

	//     $query	=	$this->db->get();
	// 	$resultArr	=	array();
	// 	if($query->num_rows() > 0)
    //     {
	// 		$resultArr	=	$query->result_array();
	// 	}

	// 	return $resultArr;
    // }


        
    /*
    *   function'll get the student list by pagination
    *   @author GBS-L
    */
    public function trans_student_list_pagination($start, $length, $order, $dir)
    {
        if($order !=null) {
            $this->db->order_by($order, $dir);
        }
         $query	  = $this->db->select('*')
                    ->from('am_students')
                    ->join('tt_transport','tt_transport.transport_id = am_students.place')
                    ->where('am_students.transportation', 'yes')
                    ->where('am_students.place is NOT NULL', NULL, FALSE)
                    ->limit($length,$start)
                    ->order_by('am_students.student_id','desc')

                    ->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    }
    /*
    *   function'll get the number of data in a single page, student list by pagination
    *   @author GBS-L
    */
    public function get_trans_num_student_list_pagination()
    {

		$query	= $this->db->select('*')
                  ->from('am_students')
                  ->join('tt_transport','tt_transport.transport_id = am_students.place')
                  ->where('am_students.transportation', 'yes')
                  ->where('am_students.place is NOT NULL', NULL, FALSE)
                  ->order_by('am_students.student_id','desc')
                  ->get();


		return $query->num_rows();

    }

    /* External Student Management Starts*/
    public function get_external_batches(){
        return $this->db->where('batch_id <',0)->where('institute_course_mapping_id',-1)->where('batch_status',-1)->get('am_batch_center_mapping')->result_array();
    }

    public function get_external_batch($batch_id){
        return $this->db->where('batch_id',$batch_id)->where('institute_course_mapping_id',-1)->where('batch_status',-1)->get('am_batch_center_mapping')->row_array();
    }

    public function get_external_batch_id(){
        $batch = $this->db->order_by('batch_id','ASC')->get('am_batch_center_mapping')->row();
        if(!empty($batch)){
            $batch_id = $batch->batch_id;
            $batch_id = $batch_id-1;
            if($batch_id==0){
                $batch_id = -1;
            }
        }else{
            $batch_id = -1;
        }
        return $batch_id;
    }

    public function add_external_batch($data){
        return $this->db->insert('am_batch_center_mapping',$data);
    }

    public function update_external_batch($batch_id,$data){
        return $this->db->where('batch_id',$batch_id)->update('am_batch_center_mapping',$data);
    }

    public function get_external_candidates(){
        return $this->db->select('am_students.*,am_batch_center_mapping.batch_name')
                        ->from('am_students')
                        ->join('am_student_course_mapping','am_student_course_mapping.student_id=am_students.student_id')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_student_course_mapping.batch_id')
                        ->where('am_students.status',11)
                        ->where('am_student_course_mapping.status',1)
                        ->order_by('am_students.student_id','DESC')
                        ->get()->result_array();
    }

    public function get_external_candidates_batch(){
        return $this->db->where('batch_id <',0)
                        ->where('batch_status',-1)
                        ->order_by('batch_id','ASC')
                        ->get('am_batch_center_mapping')->result_array();
    }

    public function get_external_candidate($candidate_id){
        return $this->db->select('am_students.*,am_student_course_mapping.batch_id,am_batch_center_mapping.batch_name,states.name as statename,cities.name as locationname')
                        ->from('am_students')
                        ->join('am_student_course_mapping','am_student_course_mapping.student_id=am_students.student_id')
                        ->join('am_batch_center_mapping','am_batch_center_mapping.batch_id=am_student_course_mapping.batch_id')
                        ->join('states','states.id=am_students.state')
                        ->join('cities','cities.id=am_students.district')
                        ->where('am_students.status',11)
                        ->where('am_student_course_mapping.status',1)
                        ->where('am_students.student_id',$candidate_id)
                        ->get()->row_array();
    }

    public function add_external_candidate($studentArr,$batch_id){
        $studentArr['registration_number'] = date('ymdHis',time()).mt_rand(10,99);
        $studentArr['status'] = 11;
        $this->db->trans_start();
        $this->db->insert('am_students',$studentArr);
        $student_id = $this->db->insert_id();
        $mapArr = array(
            'student_id'=>$student_id,
            'course_id'=>-1,
            'institute_course_mapping_id'=>-1,
            'branch_id'=>2,
            'center_id'=>-1,
            'batch_id'=>$batch_id,
            'status'=>1
        );
        $this->db->insert('am_student_course_mapping',$mapArr);
        $password = mt_rand(9999,99999);//date('d-m-Y',strtotime($studentArr['date_of_birth']));
        $encrypted_password = $this->Auth_model->get_hash($password);
		$student_credential = array(
                                    "user_name"=>$studentArr['name'],
                                    "user_primary_id"=>$student_id,
                                    "user_username"=>$studentArr['registration_number'],
                                    "user_emailid"=>$studentArr['email'],
                                    "user_passwordhash"=>$encrypted_password,
                                    "user_role"=>"student",
                                    "user_status"=>0,
                                    "user_phone"=>$studentArr['mobile_number']
                                );
        $this->db->insert('am_users',$student_credential);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;  
        }else{
            $this->db->trans_commit();
            $this->common->gm_user_registration($studentArr['registration_number'],$password,$student_id);
            $emaildata = email_header();
            $emaildata.='<tr style="background:#f2f2f2"><td style="padding: 20px 0px">
                            <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$studentArr['name'].'</h3>
                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">An account has been created for you to attend Direction examinations, please keep the credentials safe.</p>
                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Registration Number / Username :</b> '.$studentArr['registration_number'].'</p>
                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>
                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">We will send you the examination details as SMS in your registered mobile number <b>'.$studentArr['mobile_number'].'</b></p>
                        </td></tr>';
            $emaildata.=email_footer();
            $this->email->to($studentArr['email']);
            $this->email->subject('Welcome to Direction');
            $this->email->message($emaildata);
            $this->email->send();
            return true;  
        }
    }

    public function update_external_candidate($student_id,$studentArr,$batch_id){
        $this->db->trans_start();
        $this->db->where('student_id',$student_id)->update('am_students',$studentArr);
        $mapArr = array(
            'student_id'=>$student_id,
            'course_id'=>-1,
            'institute_course_mapping_id'=>-1,
            'branch_id'=>2,
            'center_id'=>-1,
            'batch_id'=>$batch_id,
            'status'=>1,
        );
        $this->db->where('student_id',$student_id)->update('am_student_course_mapping',$mapArr);
		$student_credential = array(
                                    "user_name"=>$studentArr['name'],
                                    "user_emailid"=>$studentArr['email'],
                                    "user_phone"=>$studentArr['mobile_number']
                                );
        $this->db->where('user_primary_id',$student_id)->update('am_users',$student_credential);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;  
        }else{
            $this->db->trans_commit();
            return true;  
        }
    }

    public function delete_external_candidate($candidate_id){
        $this->db->trans_start();
        $this->db->where('student_id',$candidate_id)->update('am_students',['status'=>12]);
        $this->db->where('student_id',$candidate_id)->update('am_student_course_mapping',['status'=>0]);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;  
        }else{
            $this->db->trans_commit();
            return true;  
        }
    }
    /* External Student Management Ends*/

    public function get_onlinepayment_approvalisExist($insertArr){
        $insertArr['status'] = 0;
        unset($insertArr['code']);
        unset($insertArr['payment_expired']);
        $query= $this->db->get_where('pp_onlinepayment_approval',$insertArr);
        $result	=	1;
        if($query->num_rows() > 0){
           $result = 0;
        }
        return   $result;
    }

    public function remove_onlinepayment_approvalisExist($insertArr){
        $insertArr['status'] = 0;
        unset($insertArr['code']);
        unset($insertArr['payment_expired']);
        $this->db->where($insertArr);
        $query=$this->db->delete('pp_onlinepayment_approval');
        $result	=	0;
        if($query){
           $result = 1;
        }
        return   $result;
    }


    public function get_batchbranch_details($id = NULL, $institute_course_mapping_id = NULL)
    {
        $this->db->distinct(); 
        $this->db->select('*');
        $this->db->from('am_student_course_mapping');
        $this->db->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id = am_student_course_mapping.batch_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_student_course_mapping.center_id');
        $this->db->where('am_student_course_mapping.institute_course_mapping_id', $institute_course_mapping_id);
        $this->db->where('am_student_course_mapping.student_id', $id);
        $query	=	$this->db->get();
        // echo $this->db->last_query();
        $resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}

		return $resultArr;  
    }



    // LMS

    public function get_student_courses($id)
    {
        $this->db->select('*');
        $this->db->join('am_classes', 'am_classes.class_id = am_student_course_mapping.course_id');
        $this->db->where('am_student_course_mapping.student_id', $id);
        $this->db->where('am_student_course_mapping.status', 1);
        //$query= $this->db->get_where('am_student_course_mapping',array("student_id"=>$id));
        $this->db->order_by('student_course_id','desc');
        $query= $this->db->get('am_student_course_mapping');
        $details=array();
        if($query->num_rows()>0)
        {
           $details= $query->result();

        }
        return $details;
    }
        

    
    
}
?>
