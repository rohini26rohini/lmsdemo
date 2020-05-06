<?php

class Staff_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_staff_designations($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'view_staff_designations';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','designation_eng', 'designation_alt', 'status');

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
        $this->db->order_by('designation_eng', 'asc');
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

    function insert_designation(){
        $data['status'] = 1;
        $this->db->insert('staff_designation', $data);
        return $this->db->insert_id();
    }

    function insert_designation_detail($data){
        $response = $this->db->insert('staff_designation_lang', $data);
        return $response;
    }

    function get_staff_designation_edit($id){
        return $this->db->select('*')->where('id', $id)->get('view_staff_designations')->row_array();
    }

    function delete_designation_lang($id){
        return $this->db->where('designation_id',$id)->delete('staff_designation_lang');
    }

    function get_staff_designation_list($lang_id){
        $this->db->select('staff_designation.id,staff_designation_lang.designation');
        $this->db->from('staff_designation');
        $this->db->join('staff_designation_lang','staff_designation.id=staff_designation_lang.designation_id');
        $this->db->where('staff_designation.status',1);
        $this->db->where('staff_designation_lang.lang_id',$lang_id);
        return $this->db->get()->result();
    }

    function get_all_staff($filter,$lang,$iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'vm_staff_details';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        if($lang == '1'){
            $aColumns = array('id','personal_id', 'name', 'mobile', 'designation', 'entry_type', 'status');
        }else{
            $aColumns = array('id','personal_id', 'name', 'mobile', 'designation', 'entry_type', 'status');
        }

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
        if($filter['staffId'] != ''){
            $this->db->where('personal_id',$filter['staffId']);
        }
        if($filter['staffName'] != ''){
            $this->db->like('LOWER(name)',strtolower($filter['staffName']));
        }
        if($filter['staffPhone'] != ''){
            $this->db->where('mobile',$filter['staffPhone']);
        }
        if($filter['staffDesignation'] != ''){
            $this->db->where('designation',$filter['staffDesignation']);
        }
        if($filter['staffType'] != ''){
            $this->db->where('entry_type',$filter['staffType']);
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

    function insert_staff($data){
        $response = $this->db->insert('staff', $data);
        if($response){
            return $this->db->insert_id();
        }else{
            return $response;
        }
    }

    function insert_user($data){
        $response = $this->db->insert('users', $data);
        if($response){
            return $this->db->insert_id();
        }else{
            return $response;
        }
    }

    function insert_user_roles($data){
        $response = $this->db->insert('user_role_mapping', $data);
        return $response;
    }

    function get_staff_edit($id){
        $staff =  $this->db->select('*')->where('personal_id', $id)->get('vm_staff_details')->row_array();
        $user = array();
        $roles = array();
            $user = $this->db->select('user_id,user_name')->where('user_id',$staff['user_id'])->get('am_users_backoffice')->row_array();
            if(!empty($user)){
                $this->db->select('am_roles.roles_id,am_roles.role');
                $this->db->from('am_roles');
                $this->db->join('am_staff_personal','am_staff_personal.role = am_roles.role');
                $this->db->where('am_staff_personal.user_id',$user['user_id']);
                $roles = $this->db->get()->result();
            }
        // $data['payslip_id'] = $staff;
        $data['staff'] = $staff;
        $data['user'] = $user;
        $data['roles'] = $roles;
        return $data;
    }

    function update_staff($id,$data){
        return $this->db->where('id',$id)->update('staff',$data);
    }

    function update_user($id,$data){
        return $this->db->where('id',$id)->update('users',$data);
    }

    function get_staff_user_id($staff_id){
        $user = $this->db->select('id')->where('staff_id',$staff_id)->get('users')->row_array();
        if(!empty($user)){
            return $user['id'];
        }else{
            return "0";
        }
    }

    function delete_user_role_mapping($user_id){
        return $this->db->where('user_id',$user_id)->delete('user_role_mapping');
    }

    function get_staff_drop_down(){
        return $this->db->select('*')
            ->join('am_users_backoffice','am_users_backoffice.user_id=am_staff_personal.user_id')
            ->where(array('am_staff_personal.status'=>1,'am_users_backoffice.user_status'=>'1'))
             ->order_by('am_staff_personal.name','asc')
            ->get('am_staff_personal')
           
            ->result();
    }
    
    public function daily_schedule($centre_id)
    {
        $this->db->select('*');
        $this->db->from('am_schedules');
        $this->db->join('am_classrooms','am_classrooms.room_id = am_schedules.schedule_room');
        $this->db->join('gm_exam_schedule','gm_exam_schedule.id = am_schedules.schedule_link_id');
        $this->db->join('am_batch_center_mapping','am_batch_center_mapping.batch_id = gm_exam_schedule.batch_id');
        $this->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
        $this->db->where(array("am_schedules.schedule_status"=>1,"am_schedules.schedule_type"=>1,"am_institute_course_mapping.institute_master_id"=>$centre_id,"am_schedules.schedule_date"=>date("Y-m-d")));    
       
        $query= $this->db->get();  
      
        $resultArr	=	array();
        $exam_Arr	=	array();
        $class_Arr	=	array();
        if($query->num_rows()>0)
        {
           $exam_Arr=$query->result_array(); 
        }
         $this->db->select('am_schedules.*,am_staff_personal.name,am_classrooms.classroom_name,am_syllabus_master_details.module_master_id,mm_subjects.subject_name as module,am_batch_center_mapping.batch_name,am_institute_course_mapping.course_master_id,am_institute_course_mapping.institute_master_id as centreid');
        $this->db->from('am_schedules');
        $this->db->join('am_classrooms','am_classrooms.room_id = am_schedules.schedule_room');
        $this->db->join('am_staff_personal','am_staff_personal.personal_id = am_schedules.staff_id');
        $this->db->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id = am_schedules.module_id');
        $this->db->join('mm_subjects','mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
       
        $this->db->join('am_batch_center_mapping','am_batch_center_mapping.batch_id = am_schedules.schedule_link_id');
        $this->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');

        $this->db->where(array("am_schedules.schedule_status"=>1,"am_schedules.schedule_type"=>2,"am_institute_course_mapping.institute_master_id"=>$centre_id,"am_schedules.schedule_date"=>date("Y-m-d")));
        $sql= $this->db->get();  
     
         if($sql->num_rows()>0)
        {
           $class_Arr=$sql->result_array(); 
        }
        $resultArr=array_merge($exam_Arr,$class_Arr);
      return $resultArr;  
    }
    
    public function search_schedule($centre_id,$date)
    {
        $this->db->select('*');
        $this->db->from('am_schedules');
        $this->db->join('am_classrooms','am_classrooms.room_id = am_schedules.schedule_room');
        $this->db->join('gm_exam_schedule','gm_exam_schedule.id = am_schedules.schedule_link_id');
        $this->db->join('am_batch_center_mapping','am_batch_center_mapping.batch_id = gm_exam_schedule.batch_id');
        $this->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
         $this->db->where(array("am_schedules.schedule_status"=>1,"am_schedules.schedule_type"=>1,"am_institute_course_mapping.institute_master_id"=>$centre_id,"am_schedules.schedule_date"=>$date));
        $query= $this->db->get();  
       
        $resultArr	=	array();
        $exam_Arr	=	array();
        $class_Arr	=	array();
        if($query->num_rows()>0)
        {
           $exam_Arr=$query->result_array(); 
        }
         $this->db->select('am_schedules.*,am_staff_personal.name,am_classrooms.classroom_name,am_syllabus_master_details.module_master_id,mm_subjects.subject_name as module,am_batch_center_mapping.batch_name,am_institute_course_mapping.course_master_id,am_institute_course_mapping.institute_master_id as centreid');
        $this->db->from('am_schedules');
        $this->db->join('am_classrooms','am_classrooms.room_id = am_schedules.schedule_room');
        $this->db->join('am_staff_personal','am_staff_personal.personal_id = am_schedules.staff_id');
        $this->db->join('am_syllabus_master_details','am_syllabus_master_details.syllabus_master_detail_id = am_schedules.module_id');
        $this->db->join('mm_subjects','mm_subjects.subject_id = am_syllabus_master_details.module_master_id');
       
        $this->db->join('am_batch_center_mapping','am_batch_center_mapping.batch_id = am_schedules.schedule_link_id');
        $this->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
      
        $this->db->where(array("am_schedules.schedule_status"=>1,"am_schedules.schedule_type"=>2,"am_institute_course_mapping.institute_master_id"=>$centre_id,"am_schedules.schedule_date"=>$date));
        $sql= $this->db->get();  
      
         if($sql->num_rows()>0)
        {
           $class_Arr=$sql->result_array(); 
        }
        $resultArr=array_merge($exam_Arr,$class_Arr);
      return $resultArr;    
        
    }
     
    /*
    *   function'll get all staff list for attendance with today's date
    *   @author GBS-L
    *
    */
    
    public function get_staff_list_for_attendance($date)
    {
       $this->db->select('am_staff_personal.name,am_staff_personal.personal_id,am_roles.role_name');
        $this->db->from('am_staff_personal'); 
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id=am_staff_personal.user_id');
        $this->db->where(array('am_staff_personal.status'=> '1','am_users_backoffice.user_status'=>'1','am_staff_personal.joining_date<='=>$date));
        $this->db->order_by('am_staff_personal.name','asc'); 
        $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;  
    }
    /*
    *   function'll get marked attendance of staff
    *   @params, date
    *   @author GBS-L
    *
    */
    
    public function get_marked_attendance_staff($date = NULL) {
        $this->db->select('am_staff_attendance.*,am_staff_personal.name,am_staff_personal.personal_id,am_roles.role_name');
        $this->db->from('am_staff_attendance'); 
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_staff_attendance.staff_id');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->where(array('am_staff_personal.status'=> '1','am_staff_attendance.date'=>$date));
        $this->db->order_by('am_staff_personal.name','asc'); 
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }

    function save_faculty_availability($data,$weekday_times){
        $this->db->trans_start();
        $status = $this->db->insert('am_faculty_availability',$data);
        if($status) {
            $insert = $this->db->insert_id();
            $availability_detail = [];
            foreach($weekday_times as $weektimes){
                if(!empty($weektimes)){
                    foreach($weektimes as $wtms){
                        $wtms['avai_id'] = $insert;
                        array_push($availability_detail,$wtms);
                    }
                }
            }
            if(!empty($availability_detail)){
                $status = $this->db->insert_batch('am_faculty_availability_detail',$availability_detail);
                if($status){
                    $this->db->trans_complete();
                    return true;
                }else{
                    $this->db->trans_rollback();
                    return false;
                }
            }else{
                $this->db->trans_complete();
                return true;
            }
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }
    function edit_faculty_availability($data,$weekday_times,$id){
        $this->db->trans_start();
        $status = $this->db->where('avai_id',$id)->update('am_faculty_availability',$data);
        if($status) {
            // $insert = $this->db->insert_id();
            $availability_detail = [];
            foreach($weekday_times as $weektimes){
                if(!empty($weektimes)){
                    foreach($weektimes as $wtms){
                        $wtms['avai_id'] = $id;
                        array_push($availability_detail,$wtms);
                    }
                }
            }
            // show($availability_detail);
            if(!empty($availability_detail)){
                $this->db->where('avai_id',$id)->delete('am_faculty_availability_detail');
                $status = $this->db->insert_batch('am_faculty_availability_detail',$availability_detail);
                if($status){
                    $this->db->trans_complete();
                    return true;
                }else{
                    $this->db->trans_rollback();
                    return false;
                }
            }else{
                $this->db->trans_complete();
                return true;
            }
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }


    function get_active_staff(){
        return $this->db->select('*')
            ->join('am_users_backoffice','am_users_backoffice.user_id=am_staff_personal.user_id')
            ->where(array('am_staff_personal.status'=>1,'am_users_backoffice.user_status'=>'1'))
             ->order_by('am_staff_personal.personal_id','asc')
            ->get('am_staff_personal')
           
            ->result();
    }

    function get_attendence_by_staff_id($staff_id = NULL, $date = NULL) {
        $this->db->select('*');
        $this->db->where('date', $date);
        $this->db->where('staff_id', $staff_id);
        $query	=	$this->db->get('am_staff_attendance');
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->row();
		}
		return $resultArr;
    }

    function insert_absent($data){
        $this->db->insert('am_staff_attendance', $data);
        return $this->db->insert_id();
    }

    function insert_leaverequest($data){
        $this->db->insert('am_leave_request', $data);
        return $this->db->insert_id();
    }

    function insert_leavelog($data){
        $this->db->insert('leave_entry_log', $data);
        return $this->db->insert_id();
    }
     
        


}
