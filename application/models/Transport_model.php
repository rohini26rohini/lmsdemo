<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transport_model extends Direction_Model {

    public function __construct() {
        parent::__construct();
    }
//--------------------------------------- Manage Bus -----------------------------------------------//
    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    function get_bus_list($limit='',$page='')
    {
        $this->db->select('*');
        $this->db->from('tt_bus');
        $this->db->order_by('bus_id','desc');
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
    function get_busroute_list($limit='',$page='')
    {
        $this->db->select('tt_bus.*,tt_transport.transport_id,tt_transport.bus_id');
		$this->db->from('tt_bus');
		$this->db->join('tt_transport', 'tt_transport.bus_id = tt_bus.bus_id');
		$this->db->where_not_in('tt_transport.bus_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();
        }
        return $resultArr;
	}
    //------------------------------------------------
    /**
	*This function 'll return existing bus details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_bus_exist($data)
    {
        $query= $this->db->get_where('tt_bus',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert bus details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function bus_add($data)
    {
		$res=$this->db->insert('tt_bus',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    public function get_busdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('tt_bus')
                    ->where('tt_bus.bus_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function edit_bus($data,$id)
    {
        $this->db->where('bus_id',$id);
		$query	= $this->db->update('tt_bus',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    public function delete_bus($id)
    {
        $this->db->where('bus_id', $id);
        $query=$this->db->delete('tt_bus');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get bus details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function get_bus_by_id($bus_id)
    {
		$this->db->select('*');
		$this->db->where('bus_id',$bus_id);
		$query	=	$this->db->get('tt_bus');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }

//--------------------------------------- Manage Route -----------------------------------------------//

    /**
	*This function 'll return the route table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    function get_route_list($limit='',$page='')
    {
        $this->db->select('tt_transport.*,tt_bus.bus_id,tt_bus.vehicle_number');
        $this->db->from('tt_transport');
        $this->db->join('tt_bus', 'tt_bus.bus_id=tt_transport.bus_id');
        $this->db->order_by('tt_transport.transport_id', 'desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();
        }
		return $resultArr;
	}
	
	public function get_transport($id) {
	
        $this->db->select('*');
        $this->db->where('transport_id',$id);
	    $query	=	$this->db->get('tt_transport');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
		
    }
    //------------------------------------------------
    /**
	*This function 'll return existing route details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_route_exist($data)
    {
        $query= $this->db->get_where('tt_transport',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
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
    public function route_add($detailsArr)
    {
		foreach($detailsArr as  $key=>$row){
			$res=$this->db->insert('tt_transport_stop',$row);
		}
	    if($res){
            return true;
        }else{
            return false;
        }
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
    public function get_routedetails_by_id($id)
    {
		$query	=	$this->db->select('*')
					->from('tt_transport')
					->where('tt_transport.transport_id', $id)
					->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
		}
    }
    //------------------------------------------------
    /**
	*This function 'll update route details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function edit_route($data,$id)
    {
        $this->db->where('stop_id',$id);
		$query	= $this->db->update('tt_transport_stop',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete route details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    public function delete_route($id)
    {
        $this->db->where('transport_id', $id);
        $query=$this->db->delete('tt_transport');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
	}
	
	public function checkAssignedRoute($id){
		$this->db->select('place')
				->from('am_students')
				->where('place',$id);
		$query	=	$this->db->get();
		$resultArr	=	true;
		if($query->num_rows() > 0){
			$resultArr	=	false;
		}
		return $resultArr;
	}
	
	public function checkAssignedStop($id){
		$this->db->select('stop')
				->from('am_students')
				->where('stop',$id);
		$query	=	$this->db->get();
		$resultArr	=	true;
		if($query->num_rows() > 0){
			$resultArr	=	false;
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
    function get_route_by_id($transport_id)
    {
		$query	= $this->db->select('*')
		->from('tt_transport')
		->where('tt_transport.transport_id', $transport_id)
		->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}
	//---------------------------------------------------------
	 /**
	*This function 'll get route details by id
	*
	* @access public
	* @params transport id
	* @return integer
	* @author Seethal
	*/
    function view_route_by_id($transport_id)
    {
		$query	= $this->db->select('tt_transport.*,tt_transport_stop.stop_id,tt_transport_stop.transport_id,tt_transport_stop.name,tt_transport_stop.distance,tt_transport_stop.latitude,tt_transport_stop.longitude,am_staff_personal.name,tt_bus.vehicle_number')
		->from('tt_transport')
		->where('tt_transport.transport_id', $transport_id)
		//->join('am_roles', 'am_roles.roles_id = tt_transport.role')
		->join('tt_bus', 'tt_bus.bus_id = tt_transport.bus_id')
		->join('am_staff_personal', 'am_staff_personal.personal_id = tt_transport.role')
		->join('tt_transport_stop', 'tt_transport_stop.transport_id = tt_transport.transport_id')
		->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}


	
	//---------------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/	
	function insert_transport($data){		
		$this->db->insert('tt_transport',$data);	
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
	public function add_stop($stopArr){
		foreach($stopArr as  $key=>$row){
          $this->db->insert('tt_transport_stop',$row);
		}
		return true;
	}
	//---------------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/
	public function edit_transport($data,$transport_id){
		$this->db->where('transport_id',$transport_id);
		$res	= $this->db->update('tt_transport',$data);
		if($res){
			return true;
		}else{
			return false;
		}
	}
	//---------------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/
    function check_vehicle_number_exists($bus_id){
		$this->db->select('transport_id');
		$this->db->where('bus_id', $bus_id);
		$query	= $this->db->get('tt_transport');
		$return	= $query->num_rows();
		return $return;
		
	}
	//---------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/
	function check_driver_exists($role=''){
		$this->db->select('transport_id');
		$this->db->where('role',$role);
		$query	=	$this->db->get('tt_transport');
		$return	= $query->num_rows();
		return $return;
	}
	//----------------------------------------------------
	/**
	* @params 
	* @author Seethal 
	*/
	function get_stop_byroute($transport_id = '') {
		$this->db->select('*');
		$this->db->where('transport_id',$transport_id);
		$query	=	$this->db->get('tt_transport_stop');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}

	//------------------------------------------------
	/**
	*This function 'll update stop
	*
	* @access public
	* @params array
	* @return boolean true/false
	* @author Seethal
	*/	
    function update_stop_batch($stopArr, $exist = NULL) {
		foreach($stopArr as  $key=>$row){
			$this->db->select('stop_id');
			//$this->db->where('name',$row['name']);
			$this->db->where('stop_id',$row['stop_id']);
		    //$this->db->where('transport_id',$row['transport_id']);
			$query	= $this->db->get('tt_transport_stop');
			if($query->num_rows() > 0){ 
				$resultArr	= $query->result_array();
				if($exist) {
					unset($row['route_fare']);
				}
				foreach ($resultArr as $result) {
					$stop_id = $result['stop_id']; 
					$this->db->where('stop_id',$stop_id);
					$this->db->update('tt_transport_stop',$row);
				}
		    } else {
			 	$this->db->insert('tt_transport_stop',$row);
		   	}
			
		}
	}
	//------------------------------------------------
	/**
	*This function 'll delete stop details by id
	*
	* @access public
	* @params stop id
	* @return integer
	* @author Seethal
	*/
	public function delete_stop($id){
		$this->db->where('stop_id',$id);
		return $this->db->delete('tt_transport_stop');
	}
	//------------------------------------------------
	public function get_stop_by_id($transport_id)
    {
        $this->db->select('*');
        $query= $this->db->get_where('tt_transport_stop',array('transport_id'=>$transport_id));
        $data_array=array();
        if($query->num_rows()>0)
        {
           $data_array= $query->result_array();

        }
        return $data_array;
	}
	//--------------------------------------- Vehicle Maintenance -----------------------------------------------//
    /**
	*This function 'll return the maintenance table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    function get_maintenance_list($limit='',$page='')
    {
        $this->db->select('*');
        $this->db->from('tt_maintenance');
        $this->db->order_by('maintenance_id','desc');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();
        }
		return $resultArr;
    }
	//------------------------------------------------
	   /**
	*This function 'll return the maintenance table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    function get_maintenanceroute_list($limit='',$page='')
    {
        $this->db->select('tt_maintenance.*,tt_bus.bus_id,tt_bus.bus_id,tt_bus.vehicle_number');
		$this->db->from('tt_maintenance');
		$this->db->join('tt_bus', 'tt_bus.bus_id = tt_maintenance.bus_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();
        }
        return $resultArr;
	}
    //------------------------------------------------
    /**
	*This function 'll return existing maintenance details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_maintenance_exist($data)
    {
        $query= $this->db->get_where('tt_maintenance',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert maintenance details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function maintenance_add($data)
    {
		$res=$this->db->insert('tt_maintenance',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get maintenance details by id
	*
	* @access public
	* @params maintenance id
	* @return integer
	* @author Seethal
	*/
    public function get_maintenancedetails_by_id($id)
    {
        $query	=	$this->db->select('tt_maintenance.*,tt_bus.bus_id,tt_bus.vehicle_number')
					->from('tt_maintenance')
					->join('tt_bus', 'tt_bus.bus_id = tt_maintenance.bus_id')
                    ->where('tt_maintenance.maintenance_id', $id)
                    ->get();
					$resultArr	=	array();
					if($query->num_rows() > 0){
						$resultArr	=	$query->row_array();
					}
					return $resultArr;
    }
    //------------------------------------------------
    /**
	*This function 'll update maintenance details by id
	*
	* @access public
	* @params maintenance id
	* @return integer
	* @author Seethal
	*/
    function edit_maintenance($data,$id)
    {
        $this->db->where('maintenance_id',$id);
		$query	= $this->db->update('tt_maintenance',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete maintenance details by id
	*
	* @access public
	* @params maintenance id
	* @return integer
	* @author Seethal
	*/
    public function delete_maintenance($id)
    {
        $this->db->where('maintenance_id', $id);
        $query=$this->db->delete('tt_maintenance');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get maintenance details by id
	*
	* @access public
	* @params maintenance id
	* @return integer
	* @author Seethal
	*/
    function get_maintenance_by_id($maintenance_id)
    {
		$this->db->select('*');
		$this->db->where('maintenance_id',$maintenance_id);
		$query	=	$this->db->get('tt_maintenance');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}
	

	public function insert_fee_def($data)
    {
		$res=$this->db->insert('tt_fee_definiftion',$data);
		$rows=  $this->db->insert_id();
	    if($rows>0){
			return $rows;
		}else{
		return FALSE;
		}
	}


	public function insert_fee_def_details($row)
    {
		$res=$this->db->insert('tt_fee_definiftion_details',$row);
	    if($res){
            return true;
        }else{
            return false;
        }
	}

	public function get_feeDeff(){
        return $this->db->select('*')->get('tt_fee_definiftion')->result();
	}

	public function get_payment_head(){
        return $this->db->select('*')->where('ph_status',1)->get('am_payment_heads')->result();
	}
	

		
	function get_feedef_id($id)
    {
		$query	= $this->db->select('*')
		->from('am_fee_definition')
		->where('fd_id', $id)
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
		->from('tt_fee_definiftion_details')
		->where('fd_id', $id)
		->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
		}
	
		return $resultArr;
		
	}

	public function fee_details_delete($id)
    {
        $this->db->where('fd_id', $id);
        $query=$this->db->delete('tt_fee_definiftion_details');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
	}



	
	public function change_fee_status($id, $status)
    {
		if($status == 0){
			$this->db->where('fd_id', $id);
			$query=$this->db->update('tt_fee_definiftion',array("fd_status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('fd_id', $id);
			$query=$this->db->update('tt_fee_definiftion',array("fd_status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
	}

public function delete_fee_def_details($transport_id = NULL) {
		$this->db->where('fd_id', $transport_id);
        $query=$this->db->delete('tt_fee_definiftion_details');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
}

function get_fee_definition_id($transport_id)
{
	$this->db->select('*');
	$this->db->join('am_payment_heads', 'am_payment_heads.ph_id = tt_fee_definiftion_details.fee_id');
	$this->db->where('fd_id',$transport_id);
	$query	=	$this->db->get('tt_fee_definiftion_details');
	$resultArr	=	array();
	if($query->num_rows() > 0){
		$resultArr	=	$query->result();
	}
	return $resultArr;
}

function get_student_transfee($student_id = NULL) {
	$this->db->select('*');
	$this->db->join('am_students', 'am_students.place = tt_transport.transport_id');
	$this->db->join('tt_transport_stop', 'tt_transport_stop.stop_id = am_students.stop');
	$this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
	$this->db->where('am_students.student_id',$student_id);
	$query	=	$this->db->get('tt_transport');
	$resultArr	=	array();
	if($query->num_rows() > 0){
		$resultArr	=	$query->row();
	}
	return $resultArr;
}

function get_student_transfee_def($fee_definition = NULL, $transport_id = NULL) {
	$this->db->select('*');
	$this->db->join('am_payment_heads', 'am_payment_heads.ph_id = tt_fee_definiftion_details.fee_id');
	$this->db->where('tt_fee_definiftion_details.fee_def_id',$fee_definition);
	$this->db->where('tt_fee_definiftion_details.fd_id',$transport_id);
	$query	=	$this->db->get('tt_fee_definiftion_details');
	$resultArr	=	array();
	if($query->num_rows() > 0){
		$resultArr	=	$query->result();
	}
	return $resultArr;
}


function check_exist_route($transport_id = '')
{
	$this->db->select('*');
	$this->db->from('am_students');
	$this->db->where('place',$transport_id);
	$query	=	$this->db->get();
	$resultArr	=	false;
	if($query->num_rows() > 0){
		$resultArr	=	true;
	}
	return $resultArr;
}



}
