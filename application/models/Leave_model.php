<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Leave_model extends Direction_Model {
    public function __construct() 
	{
        parent::__construct();
    }
    
//--------------------------------------- Manage Leave -----------------------------------------------//
    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_leave(){
        $this->db->select('am_leave_request.*,leave_heads.head');
        $this->db->from('am_leave_request'); 
        $this->db->join('leave_heads', 'leave_heads.id=am_leave_request.type_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }
	//------------------------------------------------
	/**
	*This function 'll return the approval table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_approval_list($user_id){
        $this->db->select('am_leave_request.*,leave_heads.head,am_staff_personal.name,am_staff_personal.personal_id,am_staff_personal.reporting_head');
        $this->db->from('am_leave_request'); 
		$this->db->join('leave_heads', 'leave_heads.id=am_leave_request.type_id');
		$this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_leave_request.user_id');
		$this->db->where('am_leave_request.reporting_head',$user_id); 
		$query	=	$this->db->get();
		//echo $this->db->last_query();die();

        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }
	//------------------------------------------------
	/**
	*This function 'll return the leave table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_leave_list($user_id){
        $this->db->select('am_leave_request.*,leave_heads.head');
        $this->db->from('am_leave_request'); 
		$this->db->join('leave_heads', 'leave_heads.id=am_leave_request.type_id');
		// $this->db->join('am_staff_personal', 'am_staff_personal.user_id=am_leave_request.user_id');
		$this->db->where('am_leave_request.user_id',$user_id); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }
    //------------------------------------------------
    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_type(){
       
        $this->db->where('status',1); 
		$query	=	$this->db->get('leave_heads');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
	//------------------------------------------------
	/**
	*This function 'll return existing leave details
	*
	* @access public
	* @params
	* @return integer
	* @author GBS-L
	*/
    public function check_leave($start_date,$end_date,$user_id)
    {
        
         $this->db->where(array("start_date>="=>$start_date,"status"=>1,"leave_status!="=>2,"user_id"=>$user_id));
         $this->db->or_where(array("end_date<="=>$end_date));
         $query= $this->db->get('am_leave_request');
        
            return $query->num_rows();
        
    }/**
	*This function 'll return existing leave details
	*
	* @access public
	* @params
	* @return integer
	* @author GBS-L
	*/
    public function duplicate_leave($start_date,$user_id)
    {
        
        // $this->db->where(array("start_date>="=>$start_date,"status"=>1,"leave_status!="=>2,"user_id"=>$user_id));
         //$this->db->or_where(array("end_date<="=>$end_date));
         $query= $this->db->query("SELECT * FROM am_leave_request 
       WHERE '$start_date' BETWEEN am_leave_request.start_date AND am_leave_request.end_date AND user_id='$user_id'AND leave_status!='2' AND status='1'");
        
            return $query->num_rows();
        
    }
    /*This function 'll return existing leave details
	*
	* @access public
	* @params
	* @return integer
	* @author GBS-L
	*/
    public function duplicate_leave_edit($start_date,$leaveid,$userid)
    {
        
         $query= $this->db->query("SELECT * FROM am_leave_request 
       WHERE '$start_date' BETWEEN am_leave_request.start_date AND am_leave_request.end_date AND leave_id!='$leaveid'AND leave_status!='2' AND status='1' AND user_id='$userid'");
        
            return $query->num_rows();
        
    }
    //------------------------------------------------
    /**
	*This function 'll insert leave details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function leave_add($data)
    {
		$res=$this->db->insert('am_leave_request',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
	//------------------------------------------------
	//------------------------------------------------
    /**
	*This function 'll insert leave_entry_log details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function leave_entry_log_add($data)
    {
		$res=$this->db->insert('leave_entry_log',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get leave details by id
	*
	* @access public
	* @params leave_id
	* @return integer
	* @author Seethal
	*/
    public function get_leavedetails_by_id($id)
    {
        $query	=	$this->db->select('am_leave_request.*,leave_heads.head,am_leave_rejection.description')
					->from('am_leave_request')
					->join('leave_heads', 'leave_heads.id=am_leave_request.type_id')
					->join('am_leave_rejection', 'am_leave_rejection.leave_id=am_leave_request.leave_id')
                    ->where('am_leave_request.leave_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update leave details by id
	*
	* @access public
	* @params leave_id
	* @return integer
	* @author Seethal
	*/
    function leave_edit($data,$id)
    {
        $this->db->where('leave_id',$id);
		$query	= $this->db->update('am_leave_request',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete leave details by id
	*
	* @access public
	* @params leave_id
	* @return integer
	* @author Seethal
	*/
    public function leave_delete($id)
    {
        $this->db->where('leave_id', $id);
        $query=$this->db->delete('am_leave_request');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get leave details by id
	*
	* @access public
	* @params leave_id 
	* @return integer
	* @author Seethal
	*/
    function get_leave_by_id($leave_id)
    {
		$this->db->select('am_leave_request.*,leave_heads.head');
		$this->db->from('am_leave_request');
		$this->db->join('leave_heads', 'leave_heads.id=am_leave_request.type_id');
		$this->db->where('leave_id',$leave_id);
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}
	//------------------------------------------------
	
	/**
	*This function 'll get staff id of a teacher
	*
	* @access public
	* @params teacher id
	* @return staff id
	* @author Seethal
	*/	
	public function get_staff_id($personal_id)
    {
		$this->db->select('*');
		$this->db->where('personal_id',$personal_id);
		return $this->db->get('am_staff_personal')->row_array();
	}
	//------------------------------------------------
	public function leave_request_status($leave_id,$leave_status)
    { 
        if($leave_status == 0){
            $this->db->where('leave_id', $leave_id);
            $query=$this->db->update('am_leave_request',array("leave_status"=> 1));		
            if($query)
            {
                return true; 
            }
            else
            {
                return false;
            }  
        
        }else if($leave_status == 1){
            $this->db->where('leave_id', $leave_id);
            $query=$this->db->update('am_leave_request',array("leave_status"=> 2));		
            if($query)
            {
                return true; 
            }
            else
            {
                return false;
            }  
        }else{
            $this->db->where('leave_id', $leave_id);
            $query=$this->db->update('am_leave_request',array("leave_status"=> 1));		
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


	// public function leave_entry($leave_id,$leave_status,user_id)
    // { $res=$this->db->insert('leave_entry_log',$data);
	//     if($res){
    //         return true;
    //     }else{
    //         return false;
    //     }
	// }
	// public function leave_request_status($data,$leave_id,$leave_status){
	// 	return $this->db->where('leave_id',$leave_id);
	// 	if($data['leave_status']=0){
	// 		$this->db->where('leave_status',1);
	// 	}else if($data['leave_status']=1){
	// 		$this->db->or_where('leave_status',2);
	// 	}else{
	// 		$this->db->or_where('leave_status',1);
	// 	}
	// 	$this->db->update('am_leave_request',$data);
	// 	echo $this->db->last_query();

    // }

	
	public function load_leave_ajax ($user_id)
    {
		$query	=	$this->db->select('am_leave_request.*,leave_heads.head,am_staff_personal.name,am_staff_personal.reporting_head')
					->from('am_leave_request')
					->join('leave_heads', 'leave_heads.id=am_leave_request.type_id')
					->join('am_staff_personal', 'am_staff_personal.user_id=am_leave_request.user_id')
					->where('am_leave_request.user_id',$user_id) 
                //    ->where('am_leave_request.leave_status!=', '0')
				   ->get();
				   
        $resultArr	=	array();
         if($query->num_rows()>0)
         {
           $resultArr=$query->result_array();
         }
         return   $resultArr;  
	}
	
	public function is_description_exist($data)
    {
       $query= $this->db->get_where('am_leave_rejection',$data);
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }
	}
	
	public function description_add($insertArray)
    {	
		$res=$this->db->insert('am_leave_rejection',$insertArray);	

	   if($res)
       {
           return true;
       }
        else
        {
            return false;
        }
	}
	
	public function get_descriptiondetails_by_id($id,$data)
    {
        $this->db->select('*');
        $query= $this->db->get_where('am_leave_rejection',array('leave_id'=>$id));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result();

        }
         return $data_array;
	}
	
	function edit_leave($data,$id){
        $this->db->where('leave_id',$id);
        // $this->db->where('enquiry_type','0');
        $query	= $this->db->update('am_leave_request',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;  
	}
	
//--------------------------------------- Manage Leave Head -----------------------------------------------//
    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_leave_type(){
        $query	=	$this->db->select('*')
                            ->order_by('id', 'desc')
                            ->get('leave_heads');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }

    
    
    function get_leave_schemes($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'leave_schemes';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','scheme', 'date_from','date_to');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        // Ordering
        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, TRUE);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), TRUE);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, TRUE);

                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        //* Filtering
        //* NOTE this does not match the built-in DataTables filtering which does it
        //* word by word on any field. It's possible to do here, but concerned about efficiency
        //* on very large tables, and MySQL's regex functionality is very limited
        if (isset($sSearch) && !empty($sSearch)) {
            $string = '';
            $s = count($aColumns);
            $valinits = 0;
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, TRUE);
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $string .= (($valinits == 0) ? '(' : 'OR ') . "LOWER(`" . $aColumns[$i] . "`) like '%" . strtolower($sSearch) . "%' ";
                    $valinits++;
                }
            }
            $string = $string . ')';
            $this->db->where($string);
        }
        $this->db->order_by('id', 'desc');
        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), FALSE);
        $rResult = $this->db->get($sTable);
        // return $this->db->last_query();
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
        // Total data set length
        $iTotal = $this->db->count_all($sTable);
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $output['aaData'][] = $row;
        }
        return $output;
    }

    //------------------------------------------------
    /**
	*This function 'll return existing leave_head details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_leave_head_exist($data)
    {
        $query= $this->db->get_where('leave_heads',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert leave_head details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function leave_head_add($data)
    {
		$res=$this->db->insert('leave_heads',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get leave_head details by id
	*
	* @access public
	* @params id
	* @return integer
	* @author Seethal
	*/
    public function get_leave_headdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('leave_heads')
                    ->where('leave_heads.id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update leave_head details by id
	*
	* @access public
	* @params id
	* @return integer
	* @author Seethal
	*/
    function leave_head_edit($data,$id)
    {
        $this->db->where('id',$id);
		$query	= $this->db->update('leave_heads',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete leave_head details by id
	*
	* @access public
	* @params id
	* @return integer
	* @author Seethal
	*/
    public function leave_head_delete($id)
    {
        $this->db->where('id', $id);
        $query=$this->db->delete('leave_heads');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get leave_head details by id
	*
	* @access public
	* @params id 
	* @return integer
	* @author Seethal
	*/
    function get_leave_head_by_id($id)
    {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query	=	$this->db->get('leave_heads');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}
	
	public function leave_head_status($id,$status)
    { 
		if($status == 1){
			$this->db->where('id', $id);
			$query=$this->db->update('leave_heads',array("status"=> 1));		
			if($query){
				return true; 
			}else{
				return false;
			}  
		}else{
			$this->db->where('id', $id);
			$query=$this->db->update('leave_heads',array("status"=> 0));		
			if($query){
				return true; 
			}else{
				return false;
			}  
		}
             
	}

//--------------------------------------- Manage Salary Component -----------------------------------------------//
  /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_salary_component(){
        $query	=	$this->db->order_by('id','desc')
                    ->get('salary_heads');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    //------------------------------------------------
    /**
	*This function 'll return existing salary_component details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_salary_component_exist($data)
    {
        $query= $this->db->get_where('salary_heads',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }

    public function is_salary_component_existEdit($data, $id)
    {
        $query= $this->db->where($data)
                        ->where('id !=', $id)
                        ->get('salary_heads');
        if($query->num_rows() >0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert salary_component details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function salary_component_add($data)
    {
		$res=$this->db->insert('salary_heads',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get salary_component details by id
	*
	* @access public
	* @params component_id
	* @return integer
	* @author Seethal
	*/
    public function get_salary_componentdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('salary_heads')
                    ->where('salary_heads.id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update salary_component details by id
	*
	* @access public
	* @params component_id
	* @return integer
	* @author Seethal
	*/
    function salary_component_edit($data,$id)
    {
        $this->db->where('id',$id);
		$query	= $this->db->update('salary_heads',$data);
		$return	=	1;
		if(!$query){
			$return	=	0;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete salary_component details by id
	*
	* @access public
	* @params component_id
	* @return integer
	* @author Seethal
	*/
    public function salary_component_delete($id)
    {
        $this->db->where('id', $id);
        $query=$this->db->delete('salary_heads');
        $return	=	1;
		if(!$query){
			$return	=	0;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get salary_component details by id
	*
	* @access public
	* @params component_id 
	* @return integer
	* @author Seethal
	*/
    function get_salary_component_by_id($id)
    {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query	=	$this->db->get('salary_heads');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}
	
	public function salary_component_status($id,$status)
    { 
		if($status == 1){
			$this->db->where('id', $id);
			$query=$this->db->update('salary_heads',array("status"=> 1));		
			if($query){
				return true; 
			}else{
				return false;
			}  
		}else{
			$this->db->where('id', $id);
			$query=$this->db->update('salary_heads',array("status"=> 0));		
			if($query){
				return true; 
			}else{
				return false;
			}  
		}
             
	}
    
    // HRMS
        
    function leave_scheme_add($data){
        $this->db->insert('leave_schemes', $data);
        return $this->db->insert_id();
    }

    function insert_leave_scheme_detail($data){
        return $this->db->insert_batch('leave_schemes_details',$data);
    }
    
    function get_leave_scheme_edit($id){
        return $this->db->where('id',$id)->get('leave_schemes')->row_array();
    }
    
    function get_leave_scheme_details($id){
        $this->db->select('leave_schemes_details.*,leave_heads.head');
        $this->db->from('leave_schemes_details');
        $this->db->join('leave_heads','leave_heads.id = leave_schemes_details.leave_heads_id');
        $this->db->where('leave_schemes_details.leave_schemes_id',$id);
        return $this->db->get()->result();
	}
	
	//------------------------------------------------
	/**
	*This function 'll return existing leave details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_entry_exist($data)
    {
        $query= $this->db->get_where('leave_entry_log',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert leave details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function leave_entry($data)
    {
		$res=$this->db->insert('leave_entry_log',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
	}
	
	function insert_leave_entry($data){
		$this->db->insert('leave_entry_log', $data);
        $id = $this->db->insert_id();
        //   echo $this->db->last_query();
		return $id;
    }

    function get_leave_heads_dropdown(){
        return $this->db->select('*')->where('status','1')->get('leave_heads')->result();
    }
    
    function get_leave_head_leaves($head_id,$scheme_id){
        return $this->db->select('*')->where('leave_heads_id',$head_id)->where('leave_schemes_id',$scheme_id)->get('leave_schemes_details')->row_array();
    }
    
     function delete_leave_scheme_details($id){
        return $this->db->where('leave_schemes_id',$id)->delete('leave_schemes_details');
    }
    
      function update_leave_scheme($id,$data){
        return $this->db->where('id',$id)->update('leave_schemes',$data);
    }
    
    function get_staff_details($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'vm_staff_details';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','name', 'scheme', 'leave_scheme', 'personal_id');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        // Ordering
        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, TRUE);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), TRUE);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, TRUE);

                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        //* Filtering
        //* NOTE this does not match the built-in DataTables filtering which does it
        //* word by word on any field. It's possible to do here, but concerned about efficiency
        //* on very large tables, and MySQL's regex functionality is very limited
        if (isset($sSearch) && !empty($sSearch)) {
            $string = '';
            $s = count($aColumns);
            $valinits = 0;
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, TRUE);
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $string .= (($valinits == 0) ? '(' : 'OR ') . "LOWER(`" . $aColumns[$i] . "`) like '%" . strtolower($sSearch) . "%' ";
                    $valinits++;
                }
            }
            $string = $string . ')';
            $this->db->where($string);
        }
        $this->db->order_by('name', 'asc');
        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), FALSE);
        $rResult = $this->db->get($sTable);
        // return $this->db->last_query();
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
        // Total data set length
        $iTotal = $this->db->count_all($sTable);
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $output['aaData'][] = $row;
        }
        return $output;
    }
    
    
    function get_leave_entries($filter,$iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'leave_entry_log';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','staff_id', 'date_from', 'date_to', 'no_of_days', 'type', 'status');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        // Ordering
        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, TRUE);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), TRUE);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, TRUE);

                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        //* Filtering
        //* NOTE this does not match the built-in DataTables filtering which does it
        //* word by word on any field. It's possible to do here, but concerned about efficiency
        //* on very large tables, and MySQL's regex functionality is very limited
        if (isset($sSearch) && !empty($sSearch)) {
            $string = '';
            $s = count($aColumns);
            $valinits = 0;
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, TRUE);
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $string .= (($valinits == 0) ? '(' : 'OR ') . "LOWER(`" . $aColumns[$i] . "`) like '%" . strtolower($sSearch) . "%' ";
                    $valinits++;
                }
            }
            $string = $string . ')';
            $this->db->where($string);
        }
        $this->db->order_by('id', 'desc');
        if($filter['leaveEntryStaff'] != ""){
            $this->db->where('staff_id',$filter['leaveEntryStaff']);
        }
        if($filter['leaveDate'] != ""){
            $fromDate = $filter['leaveDate']."-01";
            $toDate = $filter['leaveDate']."-31";
            $this->db->where('date_from >=',$fromDate);
            $this->db->where('date_to <=',$toDate);
        }
        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), FALSE);
        $rResult = $this->db->get($sTable);
        // return $this->db->last_query();
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
        // Total data set length
        $iTotal = $this->db->count_all($sTable);
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $output['aaData'][] = $row;
        }
        return $output;
    }
}
?>