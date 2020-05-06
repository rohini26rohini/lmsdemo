<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Call_center_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }

    function get_call_center_list($user_id = NULL, $role = NULL, $limit='',$page='') {
        $this->db->select('cc_call_center_enquiries.*,am_classes.class_name');
        $this->db->from('cc_call_center_enquiries'); 
        $this->db->join('am_classes', 'am_classes.class_id=cc_call_center_enquiries.course_id','left');
        if($user_id && $role=='cce') {
        $this->db->where('cc_call_center_enquiries.user_id', $user_id);    
        }
        $this->db->order_by('cc_call_center_enquiries.created_on','desc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }

    public function get_callbacks($id)
    {
        $query= $this->db->select('cc_enquiries.*,cc_callback_description.description_id,cc_callback_description.description,cc_callback_description.modified_on')
                ->from('cc_enquiries')
                ->where('cc_enquiries.enquiry_id', $id)
                ->join('cc_callback_description', 'cc_enquiries.enquiry_id = cc_callback_description.enquiry_id')
                ->get();
        
                if($query->num_rows()>0)
                {
                    return $query->result_array();
                }
                else
                {
                    return false;
                }
    }
    // public function get_all_callbacks()
    // {
    //     $this->db->select('*');
    //     $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'0'));
    //     $data_array=array();
    //     if($query->num_rows()>0)
    //     {
    //        $data_array= $query->result_array();
           
    //     }
    //      return $data_array;
    // }




    function get_call_center(){
		$this->db->select('*');
		$res = $this->db->get('cc_call_center_enquiries')->row_array();
	    return $res;
		
    }

    public  function call_centers_add($data)
    {	
        // $data['timing'] = date("Y-m-d h:i:s a",strtotime($data['timing']));
        $this->db->insert('cc_call_center_enquiries',$data);	
        $rows=  $this->db->insert_id();
        // echo $this->db->last_query();
        // die();
        if($rows > 0){
            return $rows;
        }else{
            return FALSE;
        }
    }

    public function delete_call_centers($id)
    {
        $this->db->where('call_id', $id);
        $query=$this->db->delete('cc_call_center_enquiries');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
		return $return;
    }

    public function delete_followup($id)
    {
        $this->db->where('followup_id', $id);
        $query=$this->db->delete('cc_followup');
        $return	=	true; 
		if(!$query){
			$return	=	false;
		}
		return $return;
    }


    function edit_call_centers($data,$id){
        $this->db->where('call_id',$id);
		$query	= $this->db->update('cc_call_center_enquiries',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
    }

    function edit_call_backs($data,$id){
        $this->db->where('enquiry_id',$id);
        // $this->db->where('enquiry_type','0');
        $query	= $this->db->update('cc_enquiries',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
    }

    function edit_query($data,$id){
        $this->db->where('enquiry_id',$id);
		$query	= $this->db->update('cc_enquiries',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
    }


    function get_call_center_by_id($call_id) 
    {
		$this->db->select('*');
		$this->db->where('call_id',$call_id);
		$query	=	$this->db->get('cc_call_center_enquiries');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		return $resultArr;
    }
    function get_followup_by_id($followup_id)
    {

		$this->db->select('*');
        $this->db->where('call_id',$followup_id);
        // $this->db->where('followup_id',$followup_id);
        $this->db->order_by('followup_id','desc');
        // $this->db->limit(1);
		$query	=	$this->db->get('cc_followup');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();
		}
		return $resultArr;
    }



    function get_course_by_id($class_id) 
    {
		$this->db->select('*');
		$this->db->where('class_id',$class_id);
		$query	=	$this->db->get('am_classes');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		return $resultArr;
    }
 
    function get_city_by_id($city_id) 
    {
		$this->db->select('*');
		$this->db->where('city_id',$city_id);
		$query	=	$this->db->get('cc_call_center_enquiries');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		return $resultArr;
    }
 
    public function description_add($data)
    {	
		$res=$this->db->insert('cc_callback_description',$data);	
	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
    }









    public function call_center_add($data)
    {	
        $res=$this->db->insert('cc_call_center_enquiries',$data);	
        // echo $this->db->last_query();
	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
    }
    public function get_allparent_call_centers($course)
    {
        $this->db->order_by('name', 'ASC');
        $query= $this->db->get_where('cc_call_center_enquiries',array("course_id"=>$course));
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array(); 
        }
      return   $resultArr;
    }


    function get_all_branches($course_id) {
        $this->db->select('*');
        $this->db->from('am_institute_course_mapping');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id = am_institute_course_mapping.branch_master_id');
        $this->db->where('am_institute_course_mapping.course_master_id', $course_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0)
        {
            $resultArr	=	$query->result_array();		
        }
    
        return $resultArr;
    }  
    
    public function is_call_center_exist($data)
    {
       $query= $this->db->get_where('cc_call_center_enquiries',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function is_followup_exist($data)
    {
       $query= $this->db->get_where('cc_followup',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }
    public function is_follow_exist($data)
    {
       $query= $this->db->get_where('cc_followup',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function is_description_exist($data)
    {
       $query= $this->db->get_where('cc_callback_description',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function followup_add($data)
    {
		$res=$this->db->insert('cc_followup',$data);
	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
    }
    
    public function get_all_call_centers()
    {
        $query	=	$this->db->select('cc_call_center_enquiries.*, am_classes.class_id,am_classes.class_name')
                     ->from('cc_call_center_enquiries')
                     ->where('cc_call_center_enquiries.status', '1')
                     ->join('am_classes', 'cc_call_center_enquiries.course_id = am_classes.class_id')
                     ->get();
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
    }
    public function get_course_list()
    {
        
		$query	=	$this->db->select('*')
                     ->from('am_classes')
                    //  ->where('cc_call_center_enquiries.status', '1')
                     ->get();
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
 
    }
    // public function get_call_centerby_id($id)
    // {
    //     $this->db->select('name');
    //     $query= $this->db->get_where('cc_call_center_enquiries',array('call_id'=>$id));
    //     if($query->num_rows()>0)
    //     {
    //        return $query->row()->name;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
    function get_call_centerby_id($call_id) 
    {
		$this->db->select('*');
		$this->db->where('call_id',$call_id);
		$query	=	$this->db->get('cc_call_center_enquiries');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		return $resultArr;
    }




    public function get_call_centerdetails_by_id($id)
    {
        // $this->db->select('*');
        // $query= $this->db->get_where('cc_call_center_enquiries',array('call_id'=>$id));

        $query	=	$this->db->select('cc_call_center_enquiries.*, am_classes.class_id,am_classes.class_name')
                         ->from('cc_call_center_enquiries')
                         ->where('cc_call_center_enquiries.call_id', $id)
                         ->join('am_classes', 'cc_call_center_enquiries.course_id = am_classes.class_id','left')
                         ->get();



        if($query->num_rows()>0)
        {
           return $query->row_array();
        }
        else
        {
            return false;
        }
        // echo $this->db->last_query();
    }
    
    

    
    public function call_center_edit($data)
    {
        $id=$data['call_center_id'];
        unset($data['call_center_id']);
        $this->db->where('call_id',$id);
		$query	= $this->db->update('cc_call_center_enquiries',$data);
		
		
		$return	=	true;
		
		if(!$query){
			$return	=	false;
		}
		
		return  $return;
        
    }
    public function get_allgroups()
    {
        $this->db->select('*');
        $query= $this->db->get_where('cc_call_center_enquiries',array('status'=>'1','course_id'=>'Model'));
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
        $this->db->select('*');
        $query= $this->db->get_where('cc_call_center_enquiries',$where);
        if($query->num_rows()>0)
        {
           return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
   
    

    // public function get_call_centerdetails_by_id($id)
    // {
        
    //     $query	=	$this->db->select('am_institute_master.*, am_institute_type.institute_type')
    //                  ->from('am_institute_master')
    //                  ->where('am_institute_master.institute_master_id', $id)
    //                  ->join('am_institute_type', 'am_institute_master.institute_type_id = am_institute_type.institute_type_id')
    //                  ->get();
        
    //   /*  $this->db->select('*');
    //     $query= $this->db->get_where('am_institute_master',array('institute_master_id'=>$id));*/
    //     if($query->num_rows()>0)
    //     {
    //        return $query->row_array();
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
    
   /*___________________________________manage queries________________________________________________*/
    
    public function get_all_queries()
    {
        $this->db->select('*');
        $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'1'));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();
           
        }
         return $data_array;
    } 
    public function get_all_callbacks()
    {
        $this->db->select('*');
        $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'0'));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();
           
        }
         return $data_array;
    }

     /*get query details by id*/
    public function get_query_by_id($id)
    {
       $this->db->select('*');
        $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'1','enquiry_id'=>$id));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->row_array();

        }
         return $data_array;
    }
    /*get call backs details by id*/
    public function get_callbacks_by_id($id)
    {
       $this->db->select('*');
        $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'0','enquiry_id'=>$id));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->row_array();

        }
         return $data_array;
    }

    public function get_descriptiondetails_by_id($id,$data)
    {
        // $query	=	$this->db->select('*')
        //                  ->from('cc_callback_description')
        //                  ->where('cc_callback_description.description_id', $id)
        //                  ->where('cc_callback_description.enquiry_id', $enquiry_id)
        //                  ->where('cc_callback_description.status', $data['status'])
        //                  ->get();
        // if($query->num_rows()>0)
        // {
        //    return $query->result_array();
        // }
        // else
        // {
        //     return false;
        // }
        $this->db->select('*');
        $query= $this->db->get_where('cc_callback_description',array('enquiry_id'=>$id));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result();

        }
         return $data_array;
    }

   

   

    // public function get_call_centerdetails_by_id($id)
    // {
    //     $query	=	$this->db->select('cc_call_center_enquiries.*, am_classes.class_id,am_classes.class_name')
    //                      ->from('cc_call_center_enquiries')
    //                      ->where('cc_call_center_enquiries.call_id', $id)
    //                      ->join('am_classes', 'cc_call_center_enquiries.course_id = am_classes.class_id','left')
    //                      ->get();



    //     if($query->num_rows()>0)
    //     {
    //        return $query->row_array();
    //     }
    //     else
    //     {
    //         return false;
    //     }
       
    // }






    public function insert_followdetails($data)
    {
        $query	= $this->db->insert('cc_followup',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;

    }
    public function get_all_followup()
    {
        $this->db->select('*');
        $query= $this->db->get_where('cc_enquiries',array('enquiry_type'=>'1'));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();
           
        }
         return $data_array;
    } 

    // UPDATE BATCH

    public function update_followdetails($data, $id)
    {
        $this->db->where('call_id', $id);
        $query	= $this->db->update('cc_followup',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;

    }
    public function get_followupdetails_by_id($id)
    {
        // $this->db->select('*');
        // $query= $this->db->get_where('cc_call_center_enquiries',array('call_id'=>$id));

        $query	=	$this->db->select('*')
                         ->from('cc_followup')
                         ->where('cc_followup.followup_id', $id)
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

    // public function get_descriptiondetails_by_id($id,$enquiry_id,$data)
    // {
    //     $query	=	$this->db->select('*')
    //                      ->from('cc_callback_description')
    //                      ->where('cc_callback_description.description_id', $id)
    //                      ->where('cc_callback_description.enquiry_id', $enquiry_id)
    //                      ->where('cc_callback_description.status', $data['status'])
    //                      ->get();
    //     if($query->num_rows()>0)
    //     {
    //        return $query->result_array();
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
  // function'll get branch by course_id
  public function get_branchby_courseid($course_id = NULL) {
    $this->db->select('*');
    $this->db->from('am_institute_course_mapping'); 
    $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_institute_course_mapping.branch_master_id');
    $this->db->where('am_institute_course_mapping.course_master_id',$course_id);
    $this->db->where('am_institute_course_mapping.status', 1); 
    $query	=	$this->db->get();
    $resultArr	=	array();
    if($query->num_rows() > 0){
        $resultArr	=	$query->result();		
    }
    
    return $resultArr;
    
}

    function fetch_data($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place, $filter_cce,$user_id, $role)
    {
        $role = $this->session->userdata('role'); 
        $user_id = $this->session->userdata('user_id');
        $this->db->select('cc_call_center_enquiries.*, am_classes.class_id,am_classes.class_name');
        $this->db->from('cc_call_center_enquiries');
        $this->db->join('am_classes', 'cc_call_center_enquiries.course_id = am_classes.class_id','left');
        $start_date = str_replace('/', '-', $filter_sdate);
        $end_date = str_replace('/', '-', $filter_edate);
        // $this->db->where('user_id', $this->session->userdata('role'));
            if($filter_name != ''){
                $this->db->like('name', $filter_name);
            }
            if($filter_course != ''){
                $this->db->like('class_name', $filter_course);
            }
            if($filter_number != ''){
                $this->db->like('primary_mobile', $filter_number);
            }
            if($filter_status != ''){
                $this->db->where('call_status', $filter_status);

            }
            if($filter_place != ''){
                $this->db->like('street', $filter_place);
            }
            if($filter_sdate != ''){
                
                // $this->db->where('timing>=', $filter_sdate);
                // $this->db->where('DATE_FORMAT(timing,"%Y-%m-%d")>=', date('Y-m-d',strtotime($start_date)));
                $this->db->where('DATE(cc_call_center_enquiries.timing)>=', date('Y-m-d',strtotime($start_date)));

            }
            
            if($filter_edate != ''){
                // $this->db->where('timing<=', $filter_edate);
                // $this->db->where('DATE_FORMAT(timing,"%Y-%m-%d")>=', date('Y-m-d',strtotime($end_date)));
                $this->db->where('DATE(cc_call_center_enquiries.timing)<=', date('Y-m-d',strtotime($end_date)));

            }
            if($filter_enquiry != ''){
                $this->db->like('enquiry_type', $filter_enquiry);
            }
            if($filter_cce!= ''){
                $this->db->like('cc_call_center_enquiries.user_id', $filter_cce);
            }
            if($user_id>0 && $role=='cce') {
                $this->db->where('cc_call_center_enquiries.user_id', $user_id);    
            }
        $this->db->order_by('cc_call_center_enquiries.created_on', 'DESC');
        // echo $this->db->last_query();
        return $this->db->get();
    }


    function call_back_fetch_data($filter_status,$filter_sdate,$filter_edate,$user_id, $role)
    {
        $role = $this->session->userdata('role'); 
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('cc_enquiries');
        $this->db->where('enquiry_type', '0');
        $start_date = str_replace('/', '-', $filter_sdate);
        $end_date = str_replace('/', '-', $filter_edate);
            if($filter_status != ''){
                $this->db->where('status', $filter_status);
            }
            if($filter_sdate != ''){
                $this->db->where('DATE(cc_enquiries.created_time)>=', date('Y-m-d',strtotime($start_date)));
            }
            if($filter_edate != ''){
                $this->db->where('DATE(cc_enquiries.created_time)<=', date('Y-m-d',strtotime($end_date)));
            }       
        return $this->db->get();
    }

    function query_fetch_data($filter_status,$filter_sdate,$filter_edate,$user_id, $role)
    {
        $role = $this->session->userdata('role'); 
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('cc_enquiries');
        $this->db->where('enquiry_type', '1');
        $start_date = str_replace('/', '-', $filter_sdate);
        $end_date = str_replace('/', '-', $filter_edate);
            if($filter_status != ''){
                $this->db->where('status', $filter_status);
            }
            if($filter_sdate != ''){
                $this->db->where('DATE(cc_enquiries.created_time)>=', date('Y-m-d',strtotime($start_date)));
            }
            if($filter_edate != ''){
                $this->db->where('DATE(cc_enquiries.created_time)<=', date('Y-m-d',strtotime($end_date)));
            }       
        return $this->db->get();
    }

    function fetch_date($date)
    {
    
        $new_date = str_replace('/', '-', $date);
        $this->db->select('call_id');
        $this->db->where('DATE(created_on)', date('Y-m-d',strtotime($new_date)));
		$query	=	$this->db->get('cc_call_center_enquiries');
			$resultArr['today_received_call']	=	$query->num_rows();		
        return $resultArr;
    }

function fetch_date1($date)
    {
    
        $new_date = str_replace('/', '-', $date);
        $this->db->select('call_id');
        $this->db->from('cc_call_center_enquiries');
        $this->db->join('am_students', 'am_students.caller_id = cc_call_center_enquiries.call_id');
        $this->db->where('am_students.status','1');
        $this->db->where('DATE(cc_call_center_enquiries.created_on)', date('Y-m-d',strtotime($new_date)));
		$query	=	$this->db->get();
        $resultArr['today_converted_call']	=	$query->num_rows();	
        return $resultArr;
    }


    function check_email_exists($email_id,$hidden_user_id){
		$this->db->select('call_id');
		$this->db->where('email_id',$email_id);
		if(is_numeric($hidden_user_id)){
			$this->db->where('call_id <>',$hidden_user_id);
		}
		$query	=	$this->db->get('cc_call_center_enquiries');
		$return	=	true;
		if($query->num_rows() > 0){
			$return	=	false;
		}
		return $return;
    }
    
    function check_mobile_exists($primary_mobile,$hidden_user_id){
		$this->db->select('call_id');
		$this->db->where('primary_mobile',$primary_mobile);
		if(is_numeric($hidden_user_id)){
			$this->db->where('call_id <>',$hidden_user_id);
		}
		$query	=	$this->db->get('cc_call_center_enquiries');
		$return	=	true;
		if($query->num_rows() > 0){
			$return	=	false;
		}
		return $return;
	}
}
