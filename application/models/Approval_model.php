<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function get_approval_list($center_id = NULL) {
        $this->db->select('pp_student_discount.*,am_student_course_mapping.*,am_classes.*,am_institute_master.*,am_students.*,cities.name as city');
        $this->db->from('pp_student_discount'); 
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=pp_student_discount.student_id');
        $this->db->join('am_classes', 'am_classes.class_id=am_student_course_mapping.course_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_student_course_mapping.center_id');
        $this->db->join('am_students', 'am_students.student_id=pp_student_discount.student_id');
        $this->db->join('cities', 'cities.id=am_students.district');
        $this->db->where('am_student_course_mapping.center_id', $center_id);
        //$this->db->where('pp_student_discount.discount_status', 0);
        $this->db->group_by('pp_student_discount.student_id');
        $this->db->group_by('pp_student_discount.course_id');
        $query	=	$this->db->get(); 
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    
    
    public function get_approval_details($center_id = NULL, $student_id = NULL, $course_id = NULL) {
        $this->db->select('pp_student_discount.*,am_student_course_mapping.*,am_classes.*,am_institute_master.*,am_students.*,am_discount_packages.*,am_discount_master.*,cities.name as city,am_students.status as studentstatus');
        $this->db->from('pp_student_discount'); 
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=pp_student_discount.student_id');
        $this->db->join('am_classes', 'am_classes.class_id=am_student_course_mapping.course_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_student_course_mapping.center_id');
        $this->db->join('am_students', 'am_students.student_id=pp_student_discount.student_id');
        $this->db->join('cities', 'cities.id=am_students.district');
        $this->db->join('am_discount_packages', 'am_discount_packages.package_id=pp_student_discount.package_id');
        $this->db->join('am_discount_master', 'am_discount_master.package_master_id=am_discount_packages.package_master_id');
        $this->db->where('pp_student_discount.student_id', $student_id);
        $this->db->where('pp_student_discount.course_id', $course_id);
        $this->db->where('am_student_course_mapping.center_id', $center_id);
        $this->db->group_by('pp_student_discount.st_discount_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    
    
    public function update_approval_status($status, $id) {
        $this->db->where('st_discount_id', $id);
        $query = $this->db->update('pp_student_discount', array('discount_status'=>$status));
        if($query) {
            return true;
        } else {
            return false;
        }
        
    }
    

    public function get_approval_nottification_list($center_id = NULL) {
        $this->db->select('pp_student_discount.*,am_student_course_mapping.*');
        $this->db->from('pp_student_discount');
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=pp_student_discount.student_id');
//        $this->db->join('am_classes', 'am_classes.class_id=am_student_course_mapping.course_id');
//        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_student_course_mapping.center_id');
//        $this->db->join('am_students', 'am_students.student_id=pp_student_discount.student_id');
//        $this->db->join('cities', 'cities.id=am_students.district');
        $this->db->where('am_student_course_mapping.center_id', $center_id);
        $this->db->where('pp_student_discount.discount_status', 0);
        $this->db->group_by('pp_student_discount.student_id');
        $this->db->group_by('pp_student_discount.course_id');
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();
        }
        return $resultArr;
    }

/*This function will return the maintenance service request list for director
@auther GBS-L
*/
    public function maintenanace_requestList_forApproval()
    {
       $query= $this->db->select('assets_maintenance_service.*,assets_maintenance_service_details.*,am_institute_master.institute_name,assets_maintenance_service_type.type as maintenanacetype_name,assets_maintenance_service_type.allowed_amount')
                     ->from('assets_maintenance_service')
                     ->where('assets_maintenance_service.status', '1')
                     ->join('assets_maintenance_service_details', 'assets_maintenance_service.id = assets_maintenance_service_details.service_id')
                    ->join('am_institute_master', 'assets_maintenance_service.institute_id = am_institute_master.institute_master_id')
                   ->join('assets_maintenance_service_type', 'assets_maintenance_service.maintenance_type = assets_maintenance_service_type.id')
                   ->order_by('assets_maintenance_service_details.id','DESC')
                     ->get();

        $resultArr	=	array();
        $check_array	=	array();
        $result	=	array();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();
            foreach($resultArr as $row)
            {
                    if($row['approved_status']=="Waiting for Approval"){
                        if(!in_array($row['service_id'],$check_array)){
                            array_push($check_array,$row['service_id']);
                            array_push($result,$row);
                             }
                    }
              
            }


        }

       return   $result;
    }
/*This function will return the number of maintenance service request list for director
@auther GBS-L
*/

    public function list_maintenance_service_list($status)
    {
        $query= $this->db->select('assets_maintenance_service.*,assets_maintenance_service_details.*,am_institute_master.institute_name,assets_maintenance_service_type.type as maintenanacetype_name,assets_maintenance_service_type.allowed_amount')
                     ->from('assets_maintenance_service')
                     ->where('assets_maintenance_service.status', '1')
                     ->join('assets_maintenance_service_details', 'assets_maintenance_service.id = assets_maintenance_service_details.service_id')
                    ->join('am_institute_master', 'assets_maintenance_service.institute_id = am_institute_master.institute_master_id')
                   ->join('assets_maintenance_service_type', 'assets_maintenance_service.maintenance_type = assets_maintenance_service_type.id')
                   ->order_by('assets_maintenance_service_details.id','DESC')
                     ->get();

        $resultArr	=	array();
        $check_array	=	array();
        $result	=	array();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();

            foreach($resultArr as $row)
            {
              // echo "<pre>"; print_r($row['service_id']);
                if(!in_array($row['service_id'],$check_array)){
                    array_push($check_array,$row['service_id']);
                    if($row['approved_status']==$status){
                        array_push($result,$row);
                    }
                }
            }


        }

       return   count($result);
    }
    
/*This function will return the number of maintenance service request approved
@params approved_by,status
@auther GBS-L
*/

    public function approved_maintenance_service_list($approvedby,$status)
    {
        $query= $this->db->select('assets_maintenance_service.*,assets_maintenance_service_details.id as notf_id,assets_maintenance_service_details.*,am_institute_master.institute_name,assets_maintenance_service_type.type as maintenanacetype_name,assets_maintenance_service_type.allowed_amount')
                     ->from('assets_maintenance_service')
                     ->where('assets_maintenance_service.status', '1')
                     /*->where(array('assets_maintenance_service_details.approved_status'=>'Waiting for Approval','assets_maintenance_service.status'=>'1'))*/
                     ->join('assets_maintenance_service_details', 'assets_maintenance_service.id = assets_maintenance_service_details.service_id')
                    ->join('am_institute_master', 'assets_maintenance_service.institute_id = am_institute_master.institute_master_id')
                   ->join('assets_maintenance_service_type', 'assets_maintenance_service.maintenance_type = assets_maintenance_service_type.id')
                   ->order_by('assets_maintenance_service_details.id','DESC')

                     ->get();

        $resultArr	=	array();
        $check_array	=	array();
        $result	=	array();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();

            foreach($resultArr as $row)
            {
              // echo "<pre>"; print_r($row['service_id']);
                if(!in_array($row['service_id'],$check_array)){
                    array_push($check_array,$row['service_id']);
                    if($row['approved_status']==$status && $row['approving_authority']==$approvedby){
                        array_push($result,$row);
                    }
                }
            }


        }

       return   $result;
    }
/*This function will return the details of maintenance service request with status declined and completed
@params approved_by,status
@auther GBS-L
*/

    public function list_maintenance_service_data($status)
    {
      $query= $this->db->select('assets_maintenance_service.*,assets_maintenance_service_details.id as notf_id,assets_maintenance_service_details.*,am_institute_master.institute_name,assets_maintenance_service_type.type as maintenanacetype_name,assets_maintenance_service_type.allowed_amount')
                     ->from('assets_maintenance_service')
                     ->where('assets_maintenance_service.status', '1')
                     ->join('assets_maintenance_service_details', 'assets_maintenance_service.id = assets_maintenance_service_details.service_id')
                    ->join('am_institute_master', 'assets_maintenance_service.institute_id = am_institute_master.institute_master_id')
                   ->join('assets_maintenance_service_type', 'assets_maintenance_service.maintenance_type = assets_maintenance_service_type.id')
                   ->order_by('assets_maintenance_service_details.id','DESC')

                     ->get();

        $resultArr	=	array();
        $check_array	=	array();
        $result	=	array();
        $resultArr	=	array();
        if($query->num_rows()>0)
        {
           $resultArr=$query->result_array();

            foreach($resultArr as $row)
            {
              // echo "<pre>"; print_r($row['service_id']);
                if(!in_array($row['service_id'],$check_array)){
                    array_push($check_array,$row['service_id']);
                    if($row['approved_status']==$status){
                        array_push($result,$row);
                    }
                }
            }


        }

       return   $result;  
    }
    
     public function get_approval_list_admin() {
        $this->db->select('pp_student_discount.*,am_student_course_mapping.*,am_classes.*,am_institute_master.*,am_students.*,cities.name as city');
        $this->db->from('pp_student_discount'); 
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=pp_student_discount.student_id');
        $this->db->join('am_classes', 
                        'am_classes.class_id=am_student_course_mapping.course_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_student_course_mapping.center_id');
        $this->db->join('am_students', 'am_students.student_id=pp_student_discount.student_id');
        $this->db->join('cities', 'cities.id=am_students.district');
       
        $this->db->group_by('pp_student_discount.student_id');
        $this->db->group_by('pp_student_discount.course_id');
        $this->db->order_by('pp_student_discount.st_discount_id','desc');
        $query	=	$this->db->get(); 
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    
    public function get_approval_details_admin($course_id = NULL, $student_id = NULL) {
        $this->db->select('pp_student_discount.*,am_student_course_mapping.*,am_classes.*,am_institute_master.*,am_students.*,am_discount_packages.*,am_discount_master.*,cities.name as city,am_students.status as studentstatus');
        $this->db->from('pp_student_discount'); 
        $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id=pp_student_discount.student_id');
        $this->db->join('am_classes', 'am_classes.class_id=am_student_course_mapping.course_id');
        $this->db->join('am_institute_master', 'am_institute_master.institute_master_id=am_student_course_mapping.center_id');
        $this->db->join('am_students', 'am_students.student_id=pp_student_discount.student_id');
        $this->db->join('cities', 'cities.id=am_students.district');
        $this->db->join('am_discount_packages', 'am_discount_packages.package_id=pp_student_discount.package_id');
        $this->db->join('am_discount_master', 'am_discount_master.package_master_id=am_discount_packages.package_master_id');
        if($student_id!='') {
        $this->db->where('pp_student_discount.student_id', $student_id);
        }
        $this->db->where('pp_student_discount.course_id', $course_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    public function get_entities() {
        $this->db->select('*');
        $query	=	$this->db->get('approval_flow_entities');
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    public function get_entities_byID($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query	=	$this->db->get('approval_flow_entities');
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result();		
        }
        return $resultArr;
    }
    function get_designation(){
        return $this->db->select('*')->where('role_status',1)->get('am_roles')->result();
    }
    function get_approvel_user($role){
        return $this->db->select('*')->where('user_status',1)->where('user_role',$role)->get('am_users_backoffice')->result();
    }
    function checkDuplication($flow_entities,$level,$user_id)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('flow_entities',$flow_entities);
        $this->db->where('level',$level);
        $this->db->where('user_id',$user_id);
		$query	=	$this->db->get('approval_flow_entity_details');
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
		return $f;
    }  
    function get_approvel_user_foreach_level($level, $id){
        return $this->db->select('*')->where('level',$level)->where('flow_entities',$id)->where('status',1)->get('approval_flow_entity_details')->result();
    }
}
