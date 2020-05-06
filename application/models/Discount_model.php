<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Discount_model extends Direction_Model {
    public function __construct() 
	{
        parent::__construct();
    }
    
//--------------------------------------- Manage Discount -----------------------------------------------//
    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Ramesh
	*/
	public function get_discount(){
		$query	=	$this->db->get('am_discount_master');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
    }
    //------------------------------------------------
    /**
	*This function 'll return existing discount details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_discount_exist($data)
    {
        $query= $this->db->get_where('am_discount_master',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert discount details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function discount_add($data)
    {
		$res=$this->db->insert('am_discount_master',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
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
    public function get_discountdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('am_discount_master')
                    ->where('am_discount_master.package_master_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update discount details by id
	*
	* @access public
	* @params package_master_id
	* @return integer
	* @author Seethal
	*/
    function discount_edit($data,$id)
    {
        $this->db->where('package_master_id',$id);
		$query	= $this->db->update('am_discount_master',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete discount details by id
	*
	* @access public
	* @params package_master_id
	* @return integer
	* @author Seethal
	*/
    public function discount_delete($id)
    {
        $this->db->where('package_master_id', $id);
        $query=$this->db->delete('am_discount_master');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
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
    function get_discount_by_id($package_master_id)
    {
		$this->db->select('*');
		$this->db->where('package_master_id',$package_master_id);
		$query	=	$this->db->get('am_discount_master');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }

//--------------------------------------- Manage Discount Packages -----------------------------------------------//
	/**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Ramesh
	*/
	public function get_discount_packages(){
        $this->db->select('am_discount_packages.*,am_discount_master.package_name');
        $this->db->join('am_discount_master', 'am_discount_master.package_master_id = am_discount_packages.package_master_id');
		$query	=	$this->db->get('am_discount_packages');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}
	//------------------------------------------------
    /**
	*This function 'll return existing discount_packages details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_discount_packages_exist($data)
    {
        $query= $this->db->get_where('am_discount_packages',$data);
    
            return $query->num_rows;
        
    }
    //------------------------------------------------
    /**
	*This function 'll insert discount_packages details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function discount_packages_add($data)
    {
		$res=$this->db->insert('am_discount_packages',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get discount_packages details by id
	*
	* @access public
	* @params package_id
	* @return integer
	* @author Seethal
	*/
    public function get_discount_packagesdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('am_discount_packages')
                    ->where('am_discount_packages.package_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update discount_packages details by id
	*
	* @access public
	* @params package_id
	* @return integer
	* @author Seethal
	*/
    function discount_packages_edit($data,$id)
    {
        $this->db->where('package_id',$id);
		$query	= $this->db->update('am_discount_packages',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete discount_packages details by id
	*
	* @access public
	* @params package_id
	* @return integer
	* @author Seethal
	*/
    public function discount_packages_delete($id)
    {
        $this->db->where('package_id', $id);
        $query=$this->db->delete('am_discount_packages');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get discount_packages details by id
	*
	* @access public
	* @params package_id 
	* @return integer
	* @author Seethal
	*/
    function get_discount_packages_by_id($package_id)
    {
		$this->db->select('am_discount_packages.*,am_discount_master.package_name');
		$this->db->where('package_id',$package_id);
        $this->db->join('am_discount_master', 'am_discount_master.package_master_id = am_discount_packages.package_master_id');
		$query	=	$this->db->get('am_discount_packages');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}

	public function get_feeDeff(){
        return $this->db->select('*')->order_by('fee_definition_id', 'desc')->get('am_fee_definition')->result();
	}
	
	public function get_payment_head(){
        return $this->db->select('*')->where('ph_status',1)->get('am_payment_heads')->result();
	}
	
	public function insert_fee_def($data)
    {
		$res=$this->db->insert('am_fee_definition',$data);
		$rows=  $this->db->insert_id();
	    if($rows>0){
			return $rows;
		}else{
		return FALSE;
		}
	}

	public function insert_fee_def_details($row)
    {
		$res=$this->db->insert('am_fee_definition_details',$row);
	    if($res){
            return true;
        }else{
            return false;
        }
	}

	public function change_fee_status($id, $status)
    {
		if($status == 0){
			$this->db->where('fee_definition_id', $id);
			$query=$this->db->update('am_fee_definition',array("fee_definition_status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('fee_definition_id', $id);
			$query=$this->db->update('am_fee_definition',array("fee_definition_status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
	}
	
	function get_feedef_id($id)
    {
		$query	= $this->db->select('*')
		->from('am_fee_definition')
		->where('fee_definition_id', $id)
		->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}

	function get_details_id($id)
    {
		$query	= $this->db->select('*')
		->from('am_fee_definition_details')
		->where('fee_definition_id', $id)
		->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}
	
		return $resultArr;
		
	}

	public function fee_details_delete($id)
    {
        $this->db->where('fee_definition_id', $id);
        $query=$this->db->delete('am_fee_definition_details');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
	}

	public function get_feeHead(){
        return $this->db->select('*')->order_by('ph_id', 'desc')->get('am_payment_heads')->result();
	}

	public function insert_fee_head($data)
    {
		$res = $this->db->insert('am_payment_heads',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
	}

	function get_fee_head_by_id($id)
    {
		$this->db->select('*');
		$this->db->where('ph_id',$id);
		$query	=	$this->db->get('am_payment_heads');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}

	function update_fee_head($data,$id)
    {
        $this->db->where('ph_id',$id);
		$query	= $this->db->update('am_payment_heads',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
	}

	public function change_fee_head_status($id, $status)
    {
		if($status == 0){
			$this->db->where('ph_id', $id);
			$query=$this->db->update('am_payment_heads',array("ph_status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('ph_id', $id);
			$query=$this->db->update('am_payment_heads',array("ph_status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
	}

	public function get_active_feeDeff(){
        return $this->db->where('fee_definition_status',1)->where('fee_type','Course Fee')->get('am_fee_definition')->result();
	}
	
	public function get_fee_heads($fee_definition){
		return $this->db->select('am_fee_definition_details.*,am_payment_heads.ph_head_name')
						->from('am_fee_definition_details')
						->join('am_payment_heads','am_payment_heads.ph_id=am_fee_definition_details.fee_head_id')
						->where('am_fee_definition_details.fee_definition_id',$fee_definition)
						->get()->result();
	}



	public function get_fee_headsbyid($fd_id = NULL){
        $this->db->select('*');
        $this->db->join('am_payment_heads', 'am_payment_heads.ph_id = am_fee_definition_details.fee_head_id');
		$this->db->where('am_fee_definition_details.fee_definition_id', $fd_id);
		$query	=	$this->db->get('am_fee_definition_details');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}



}

?>
