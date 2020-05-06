<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_enrollment_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    public function is_staff_personal_exist($mobile = NULL, $email = NULL)
    {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('mobile', $mobile);
        $this->db->or_where('email', $email);
        $query= $this->db->get('am_staff_personal');
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    public  function staff_personal_add($data)
    {	
        $this->db->insert('am_staff_personal',$data);
        $rows =  $this->db->insert_id();
        if($rows > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }
    public function get_staff_personaldetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                         ->from('am_staff_personal')
                         ->where('am_staff_personal.personal_id', $id)
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
    function get_staff_personal_by_id($personal_id) 
    {
		$this->db->select('*');
		$this->db->where('personal_id',$personal_id);
		$query	=	$this->db->get('am_staff_personal');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
        return $resultArr;
        // print_r($this->db->last_query()) ;
        // die();
    }

    function get_staff_list($limit='',$page='') {
        $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        //$this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->order_by('am_staff_personal.personal_id','desc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        // echo $this->db->last_query(); exit;
        return $resultArr;
    }
     function getactive_staff_list($limit='',$page='') {
        $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where('am_staff_personal.status',1); 
        $this->db->where('am_users_backoffice.user_status',1); 
        $this->db->order_by('am_staff_personal.personal_id','desc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
         
        return $resultArr;
    }

    function get_users_list($limit='',$page='') {
        $this->db->select('am_staff_personal.*,am_users_backoffice.user_name,am_users_backoffice.user_username');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->order_by('am_staff_personal.personal_id','desc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }

    // function get_call_center_list($limit='',$page='') {
    //     $this->db->select('cc_call_center_enquiries.*,am_classes.class_name');
    //     $this->db->from('cc_call_center_enquiries'); 
    //     $this->db->join('am_classes', 'am_classes.class_id=cc_call_center_enquiries.course_id');
    //     $this->db->order_by('cc_call_center_enquiries.course_id','asc'); 
    //     $query	=	$this->db->get();
    //     $resultArr	=	array();
    //     if($query->num_rows() > 0){
    //         $resultArr	=	$query->result_array();		
    //     }
    //     return $resultArr;
    // }
    function edit_staff_personals($data,$id){
        $this->db->where('personal_id',$id);
		$query	= $this->db->update('am_staff_personal',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
    }
    public function delete_staff_personals($id)
    {
        $this->db->where('personal_id', $id);
        $query=$this->db->delete('am_staff_personal');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
		return $return;
    }

    public function delete_faculty($id)
    {
        $this->db->where('avai_id', $id);
        $query=$this->db->delete('am_faculty_availability');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
		return $return;
    }

    function get_allsub_modules($type) 
    {
		$this->db->select('*');
        $this->db->where('type','Module');
        $this->db->where('subject_status','1');
        
		$query	=	$this->db->get('mm_subjects');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    

//     function get_call_center(){
// 		$this->db->select('*');
// 		$res = $this->db->get('cc_call_center_enquiries')->row_array();
// 	    return $res;
		
//     }

    

//     public function delete_call_centers($id)
//     {
//         $this->db->where('call_id', $id);
//         $query=$this->db->delete('cc_call_center_enquiries');
//         $return	=	true; 
// 		if(!$query){
// 			$return	=	false;
// 		}
// 		return $return;
//     }

//     function edit_call_centers($data,$id){
//         $this->db->where('call_id',$id);
// 		$query	= $this->db->update('cc_call_center_enquiries',$data);
// 		$return	=	true;
// 		if(!$query){
// 			$return	=	false;
// 		}
// 		return  $return;  
//     }

//     function get_call_center_by_id($call_id) 
//     {
// 		$this->db->select('*');
// 		$this->db->where('call_id',$call_id);
// 		$query	=	$this->db->get('cc_call_center_enquiries');
// 		$resultArr	=	array();
// 		if($query->num_rows() > 0){
// 			$resultArr	=	$query->row_array();		
// 		}
// 		return $resultArr;
//     }

//     function get_course_by_id($class_id) 
//     {
// 		$this->db->select('*');
// 		$this->db->where('class_id',$class_id);
// 		$query	=	$this->db->get('am_classes');
// 		$resultArr	=	array();
// 		if($query->num_rows() > 0){
// 			$resultArr	=	$query->row_array();		
// 		}
// 		return $resultArr;
//     }
 
//     function get_city_by_id($city_id) 
//     {
// 		$this->db->select('*');
// 		$this->db->where('city_id',$city_id);
// 		$query	=	$this->db->get('cc_call_center_enquiries');
// 		$resultArr	=	array();
// 		if($query->num_rows() > 0){
// 			$resultArr	=	$query->row_array();		
// 		}
// 		return $resultArr;
//     }
 










//     public function call_center_add($data)
//     {	
// 		$res=$this->db->insert('cc_call_center_enquiries',$data);	
// 	   if($res)
//        {
//            return true;
//        }
//         else
//         {
//             return false;
//         }
//     }
//     public function get_allparent_call_centers($course)
//     {
//         $this->db->order_by('name', 'ASC');
//         $query= $this->db->get_where('cc_call_center_enquiries',array("course_id"=>$course));
//         $resultArr	=	array();
//         if($query->num_rows()>0)
//         {
//            $resultArr=$query->result_array(); 
//         }
//       return   $resultArr;
//     }
    
    
    
//     public function get_all_call_centers()
//     {
//         $query	=	$this->db->select('cc_call_center_enquiries.*, am_classes.class_id,am_classes.class_name')
//                      ->from('cc_call_center_enquiries')
//                      ->where('cc_call_center_enquiries.status', '1')
//                      ->join('am_classes', 'cc_call_center_enquiries.course_id = am_classes.class_id')
//                      ->get();
// 		$resultArr	=	array();
		
// 		if($query->num_rows() > 0){
// 			$resultArr	=	$query->result_array();		
// 		}
		
// 		return $resultArr;
 
//     }
//     public function get_course_list()
//     {
        
// 		$query	=	$this->db->select('*')
//                      ->from('am_classes')
//                     //  ->where('cc_call_center_enquiries.status', '1')
//                      ->get();
		
// 		$resultArr	=	array();
		
// 		if($query->num_rows() > 0){
// 			$resultArr	=	$query->result_array();		
// 		}
		
// 		return $resultArr;
 
//     }
//     function get_call_centerby_id($call_id) 
//     {
// 		$this->db->select('*');
// 		$this->db->where('call_id',$call_id);
// 		$query	=	$this->db->get('cc_call_center_enquiries');
// 		$resultArr	=	array();
// 		if($query->num_rows() > 0){
// 			$resultArr	=	$query->row_array();		
// 		}
// 		return $resultArr;
//     }




    
    
    

    
//     public function call_center_edit($data)
//     {
//         $id=$data['call_center_id'];
//         unset($data['call_center_id']);
//         $this->db->where('call_id',$id);
// 		$query	= $this->db->update('cc_call_center_enquiries',$data);
		
		
// 		$return	=	true;
		
// 		if(!$query){
// 			$return	=	false;
// 		}
		
// 		return  $return;
        
//     }
//     public function get_allgroups()
//     {
//         $this->db->select('*');
//         $query= $this->db->get_where('cc_call_center_enquiries',array('status'=>'1','course_id'=>'Model'));
//         if($query->num_rows()>0)
//         {
//            return $query->result_array();
//         }
//         else
//         {
//             return false;
//         }
//     }
//     public function get_allsub_byparent($where)
//     {
//         $this->db->select('*');
//         $query= $this->db->get_where('cc_call_center_enquiries',$where);
//         if($query->num_rows()>0)
//         {
//            return $query->result_array();
//         }
//         else
//         {
//             return false;
//         }
//     }
    
   
    

//     // public function get_call_centerdetails_by_id($id)
//     // {
        
//     //     $query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
//     //                  ->from('am_institute_master')
//     //                  ->where('am_institute_master.institute_master_id', $id)
//     //                  ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
//     //                  ->get();
        
//     //   /*  $this->db->select('*');
//     //     $query= $this->db->get_where('am_institute_master',array('institute_master_id'=>$id));*/
//     //     if($query->num_rows()>0)
//     //     {
//     //        return $query->row_array();
//     //     }
//     //     else
//     //     {
//     //         return false;
//     //     }
//     // }
    
//    /*___________________________________manage queries________________________________________________*/
    
//     public function get_all_queries()
//     {
//         $this->db->select('*');
//         $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'1'));
//         $data_array=array();
//         if($query->num_rows()>0)
//         {
//            $data_array= $query->result_array();
           
//         }
//          return $data_array;
//     } 
//     public function get_all_callbacks()
//     {
//         $this->db->select('*');
//         $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'0'));
//         $data_array=array();
//         if($query->num_rows()>0)
//         {
//            $data_array= $query->result_array();
           
//         }
//          return $data_array;
//     }

//      /*get query details by id*/
//     public function get_query_by_id($id)
//     {
//        $this->db->select('*');
//         $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'1','enquiry_id'=>$id));
//         $data_array=array();
//         if($query->num_rows()>0)
//         {
//            $data_array= $query->row_array();

//         }
//          return $data_array;
//     }
//     /*get call backs details by id*/
//     public function get_callbacks_by_id($id)
//     {
//        $this->db->select('*');
//         $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'0','enquiry_id'=>$id));
//         $data_array=array();
//         if($query->num_rows()>0)
//         {
//            $data_array= $query->row_array();

//         }
//          return $data_array;
//     }


public function is_staff_education_exist($data)
    {
       $query= $this->db->get_where('am_staff_education',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    public  function staff_education_add($data)
    {	
        // $this->db->insert('am_staff_education',$data);	
        // $rows=  $this->db->insert_id();
        // if($rows > 0){
        //     return $rows;
        // }else{
        //     return FALSE;
        // }

        $query=$this->db->insert('am_staff_education',$data);
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
    *   Function'll update qualification
    *   @params id, post array
    *   @author GBS-R
    */

    public function staff_education_edit($id,$data) {
        $this->db->where('education_id',$id);
         $query	= $this->db->update('am_staff_education',$data);
        //  $this->db->where(array('student_id'=>$student_id,'qualification'=>$qualification,'category'=>$category));

 		// $return	=	false;
 		if($query){
 			$return	=	true;
 		}else{
             return false;
         }
    }

    //  public function staff_education_edit($education_id,$category,$data,$specification)
    // {
    //     if($category == "Others"){
    //         $this->db->where(array('education_id'=>$education_id,'specification'=>$specification,'category'=>$category));
    //     }else{
    //         $this->db->where(array('education_id'=>$education_id,'category'=>$category));
    //     }
    //   $query=$this->db->update('am_staff_education',$data);

    //     if($query)
    //     {
    //         return 1;
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }
    // public function staff_education_edit($edit_personal_id,$data,$specification,$category)
    // {
    //     if($category == "Others"){
    //         $condtion=array('personal_id'=>$edit_personal_id,'specification'=>$specification,'category'=>$category);
    //         $this->db->where(array('personal_id'=>$edit_personal_id,'specification'=>$specification,'category'=>$category));
    //     }else{
    //         $condtion=array('personal_id'=>$edit_personal_id,'category'=>$category);
    //         $this->db->where(array('personal_id'=>$edit_personal_id,'category'=>$category));
    //     }
    //   $query=$this->db->update('am_staff_education',$data);

    //     if($query)
    //     {
    //         //return true;
    //         return $this->common->get_name_by_id('am_staff_education','education_id',$condtion);
            
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    public function check_specification($personal_id,$categoryArr)
    {
       $query= $this->db->get_where('am_staff_education',array("personal_id"=>$personal_id,"category"=>$categoryArr));
        return $query->row_array();
        // return $query;
        //      if($query->num_rows()>0)
        // {
        //     return 	$resultArr	=	$query->row_array();	
        // }
        // else
        // {
        //     return 0;
        // }

    }
    public function check_specification1($personal_id,$specification,$category)
    {
       $query= $this->db->get_where('am_staff_education',array("personal_id"=>$personal_id,"specification"=>$specification,"category"=>$category));
        return $query->num_rows();

    }

    // public function staff_education_edit($education_id,$category,$data,$specification)
    // {
    //     if($category == "Others"){
    //         $this->db->where(array('education_id'=>$education_id,'specification'=>$specification,'category'=>$category));
    //     }else{
    //         $this->db->where(array('education_id'=>$education_id,'category'=>$category));
    //     }
    //   $query=$this->db->update('am_staff_education',$data);

    //     if($query)
    //     {
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }


    public function get_staff_educationdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                         ->from('am_staff_education')
                         ->where('am_staff_education.education_id', $id)
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
    function get_staff_education_by_id($education_id) 
    {
		$this->db->select('*');
		$this->db->where('education_id',$education_id);
		$query	=	$this->db->get('am_staff_education');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
        return $resultArr;
        // print_r($this->db->last_query()) ;
        // die();
    }

    public function is_staff_experience_exist($data)
    {
       $query= $this->db->get_where('am_staff_experience',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    public  function staff_experience_add($data)
    {	
        $this->db->insert('am_staff_experience',$data);	
        $rows=  $this->db->insert_id();
        if($rows > 0){
            return $rows;
        }else{
            return FALSE;
        }
    }

     /*
    *   Function'll update experience
    *   @params id, post array
    *   @author GBS-R
    */

    public function staff_experience_edit($data, $id) {
        $this->db->where('experience_id',$id);
 		$query	= $this->db->update('am_staff_experience',$data);
 		$return	=	false;
 		if($query){
 			$return	=	true;
 		}
    }

    public function is_staff_other_exist($data)
    {
       $query= $this->db->get_where('am_staff_others',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    public  function staff_other_add($data)
    {	
        $this->db->insert('am_staff_others',$data);	
        $rows=  $this->db->insert_id();
        if($rows > 0){
            return $rows;
        }else{
            return FALSE;
        }
    }
    public function get_staff_experiencedetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                         ->from('am_staff_experience')
                         ->where('am_staff_experience.experience_id', $id)
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
    function get_staff_experience_by_id($experience_id) 
    {
		$this->db->select('*');
		$this->db->where('experience_id',$experience_id);
		$query	=	$this->db->get('am_staff_experience');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
        return $resultArr;
        // print_r($this->db->last_query()) ;
        // die();
    }


    /*
    *   Function'll update approval form
    *   @params id, post array
    *   @author GBS-R
    */

    public function update_approval_data($data, $id) {
        $this->db->where('personal_id',$id);
 		$query	= $this->db->update('am_staff_personal',$data);
 		$return	=	false;
 		if($query){
 			$return	=	true;
 		}
        return $return;
    }



    /*
    *   Function'll insert strong and weak area
    *   @params id, post array
    *   @author GBS-R
    */

    public  function insert_faculty_subject($data)
    {
        $this->db->insert_batch('am_faculty_subject_mapping',$data);
        $rows=  $this->db->insert_id();
        if($rows > 0){
            return $rows;
        }else{
            return FALSE;
        }
    }

     /*
    *   Function'll update faculty subject form
    *   @params id, post array
    *   @author GBS-R
    */

    public function update_faculty_subject($data) {
 		$this->db->update_batch('am_faculty_subject_mapping',$data,'faculty_sub_id');
 		return true;
    }
    
     /*
    *   Function'll active faculty
    *   @params id, post array
    *   @author GBS-R
    */
    
    function get_faculty_list() {
        $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where('am_users_backoffice.user_status',1);
        $this->db->where('am_staff_personal.status',1);
        $this->db->where('am_staff_personal.role', 'faculty');
        $this->db->order_by('am_staff_personal.name','asc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }
    
    
    function get_faculty_availability_list() {
        $this->db->select('*');
        $this->db->from('am_faculty_availability');
        $this->db->where(array('am_faculty_availability.status'=>'1'));
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_faculty_availability.staff_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_faculty_availability.center_id');
        $this->db->order_by('am_faculty_availability.avai_id','desc');
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();		
		}
        return $resultArr;
    }

 public function get_all_staffList_by_ajax($start,$length,$order, $dir)
    {
         /*if($order !=null) {
            $this->db->order_by($order, $dir);
        }*/

        $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->order_by('am_staff_personal.personal_id','desc');
        $this->db->limit($length,$start);
        $query	=	$this->db->get();
		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

        return $resultArr;
        
        $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
            if($filter_name != ''){
                $this->db->like('name', $filter_name);
            }
            if($filter_role!= ''){
                $this->db->like('am_staff_personal.role', $filter_role);
            }
            
        $this->db->order_by('am_staff_personal.personal_id', 'DESC');
        return $this->db->get();

    }
    public function get_num_staffList_by_ajax()
    {

       $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->order_by('am_staff_personal.personal_id','desc');
        $query	=	$this->db->get();
		return $query->num_rows();

    }
    public function get_all_staffList_by_ajax_search($start,$length,$order, $dir,$search)
    {
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }
		$this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->order_by('am_staff_personal.personal_id','desc');
        $this->db->limit($length,$start);
        $this->db->like('am_staff_personal.name',$search);
        $this->db->or_like('am_staff_personal.role',$search);
        $this->db->or_like('am_staff_personal.mobile',$search);
        $query	=	$this->db->get();
		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

        return $resultArr;

    }
    public function get_allactive_staffList_by_ajax_search($start,$length,$order, $dir,$search)
    {
         if($order !=null) {
            $this->db->order_by($order, $dir);
        }
		$this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
         $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where('am_users_backoffice.user_status',1);
        $this->db->where('am_staff_personal.status',1);
        $this->db->order_by('am_staff_personal.personal_id','desc');
        $this->db->limit($length,$start);
        $this->db->like('am_staff_personal.name',$search);
        $this->db->or_like('am_staff_personal.role',$search);
        $this->db->or_like('am_staff_personal.mobile',$search);
        $query	=	$this->db->get();
		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

        return $resultArr;

    }


    public function upload_staff_documents_edit($data, $where){
        $this->db->where($where);
        $query = $this->db->update('am_staff_documents',$data);
        if($query){
            return true;
        }else{
            return false;
        }  
    }

    public function get_staff_documents($id){
        return $this->db->where('personal_id',$id)->where('status',1)->get('am_staff_documents')->result();
    }

    //upload documents of students
    public function upload_staff_documents($data){
        $this->db->insert('am_staff_documents',$data);
        $insert_id = $this->db->insert_id();
        if($insert_id!=''){
            return $insert_id;
        }else{
            return false;
        }  
    }

    public function is_doc_exist($data){
        $query= $this->db->where($data)->where('status !=', 0)->get('am_staff_documents');
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function verify_staff_document($id,$verification){
        $data['verification']=$verification;
        $this->db->where('staff_documents_id',$id)->update('am_staff_documents',$data);

    }

    public function is_doc1_exist($pers_id,$document_name1,$education_id)
    {
        $query= $this->db->get_where('am_staff_documents',array("personal_id"=>$pers_id,"education_id"=>$education_id,"document_name"=>$document_name1));
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }

    }
    function get_faculty_availability_list_byId($id) {
        $this->db->select('*');
        $this->db->from('am_faculty_availability');
        $this->db->where(array("avai_id"=>$id));
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_faculty_availability.staff_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_faculty_availability.center_id');
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
        return $resultArr;
    }

    function fetch_data($filter_name,$filter_role,$filter_subject)
    {
        $this->db->select('*');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
       
            if($filter_name != ''){
                $this->db->like('name', $filter_name);
            }
            if($filter_role!= ''){
                $this->db->where('am_staff_personal.role', $filter_role);
            }
        if($filter_subject!= ''){
                $this->db->join('am_faculty_subject_mapping', 'am_faculty_subject_mapping.staff_id=am_staff_personal.personal_id','left');
                $this->db->where('am_faculty_subject_mapping.parent_subject_id', $filter_subject);
                $this->db->group_by('staff_id');
            }
            
        $this->db->order_by('am_staff_personal.personal_id', 'DESC');
        return $this->db->get();
    }
    
    

    public function delete_others($id)
    {
        $this->db->where('education_id', $id);
        $query=$this->db->delete('am_staff_education');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
        return $return;
    }

    public function delete_staff_document($id){
        $data['status']=0;
        $this->db->where('staff_documents_id',$id)->update('am_staff_documents',$data);
    }

    function insert_education($data){		
		$this->db->insert('am_staff_education',$data);	
		$rows=  $this->db->insert_id();
		if($rows>0){
			return $rows;
		}else{
		return FALSE;
		}
    }
    
    public function education_add($educationArr)
    {
		foreach($educationArr as  $key=>$row){
			$res=$this->db->insert('am_staff_education',$row);
		}
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    public function fetch_facultydata($filter_name,$filter_centre)
    {
        $this->db->select('*');
        $this->db->from('am_faculty_availability');
        $this->db->where(array('am_faculty_availability.status'=>'1'));
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_faculty_availability.staff_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_faculty_availability.center_id');
         if($filter_name != ''){
                $this->db->like('am_staff_personal.name', $filter_name);
            }
            if($filter_centre!= ''){
                $this->db->where('am_faculty_availability.center_id', $filter_centre);
            }
		return	$this->db->get();

    }
   
    public function check_faculty_subject($check_data,$id)
    {
            return $this->db->where_in("parent_subject_id",$check_data)->where('staff_id',$id)
             ->get('am_faculty_subject_mapping')
            ->num_rows();
    }

    function get_salary_scheme_drop_down(){
        return $this->db->select('*')->get('salary_schemes')->result();
    }

    function get_leave_scheme_drop_down(){
        return $this->db->select('*')->get('leave_schemes')->result();
    }

    public function get_allactive_staffList_by_ajax($start,$length,$order, $dir)
    {
         /*if($order !=null) {
            $this->db->order_by($order, $dir);
        }*/

        $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where('am_staff_personal.status',1); 
        $this->db->where('am_users_backoffice.user_status',1); 
        $this->db->order_by('am_staff_personal.personal_id','desc');
        $this->db->limit($length,$start);
        $query	=	$this->db->get();
		$resultArr	=	array();

		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}

        return $resultArr;
        
       /* $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
            if($filter_name != ''){
                $this->db->like('name', $filter_name);
            }
            if($filter_role!= ''){
                $this->db->like('am_staff_personal.role', $filter_role);
            }
            
        $this->db->order_by('am_staff_personal.personal_id', 'DESC');
        return $this->db->get();*/

    }
    public function get_activenum_staffList_by_ajax()
    {

       $this->db->select('am_staff_personal.*,am_roles.role_name,am_roles.role');
        $this->db->from('am_staff_personal');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
         $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where('am_staff_personal.status',1); 
        $this->db->where('am_users_backoffice.user_status',1); 
        $this->db->order_by('am_staff_personal.personal_id','desc');
        $query	=	$this->db->get();
		return $query->num_rows();

    }
    
    function active_staff_fetch($filter_role)
    {
        $this->db->select('*');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');  
        if($filter_role!= ''){
            $this->db->where('am_staff_personal.role', $filter_role);
        }
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where('am_staff_personal.status',1); 
        $this->db->where('am_users_backoffice.user_status',1);    
        $this->db->order_by('am_staff_personal.personal_id', 'DESC');
        return $this->db->get();
    }
}
