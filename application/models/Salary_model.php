<?php

class Salary_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_salary_heads($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'salary_heads';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','head', 'type','status');

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
        $this->db->order_by('id', 'asc');
        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), FALSE);
        $this->db->where('status!= ',2,FALSE);
       // $this->db->where('status',2,FALSE);
       // $this->db->where('status', 0);
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
    
    function add_salary_head($data){
        return $this->db->insert('salary_heads', $data);
    }

    function get_salary_head_edit($id){
        return $this->db->select('*')->where('id', $id)->get('salary_heads')->row_array();
    }

    function update_salary_head($id,$data){
        return $this->db->where('id',$id)->update('salary_heads', $data);
    }
    function delete_salary_head($id){
        return $this->db->where('id',$id)->delete('salary_heads');
    }

    function get_salary_heads_dropdown(){
        return $this->db->select('*') ->where('status',4)->or_where('status',1)->get('salary_heads')->result();
    }

    function get_salary_schemes($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'salary_schemes';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','scheme', 'date_from','date_to','amount');

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
        $this->db->order_by('id', 'asc');
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

    function salary_scheme_add($data){
        $this->db->insert('salary_schemes', $data);
        return $this->db->insert_id();
    }

    function update_salary_scheme_data($id,$data){
        return $this->db->where('id',$id)->update('salary_schemes',$data);
    }

    function insert_salary_scheme_detail($data){
        return $this->db->insert_batch('salary_schemes_details',$data);
    }

    function get_salary_scheme_edit($id){
        return $this->db->where('id',$id)->get('salary_schemes')->row_array();
    }

    function get_salary_scheme_details($id){
        $this->db->select('salary_schemes_details.*,salary_heads.head,salary_heads.type');
        $this->db->from('salary_schemes_details');
        $this->db->join('salary_heads','salary_heads.id = salary_schemes_details.sal_heads_id');
        $this->db->where('salary_schemes_details.sal_schemes_id',$id);
        return $this->db->get()->result();
    }

    function get_scheme_head_amount($head_id,$scheme_id){
        return $this->db->select('*')->where('sal_heads_id',$head_id)->where('sal_schemes_id',$scheme_id)->get('salary_schemes_details')->row_array();
    }

    function delete_salary_scheme_details($id){
        return $this->db->where('sal_schemes_id',$id)->delete('salary_schemes_details');
    }

    function get_salary_scheme_drop_down(){
        return $this->db->select('*')->get('salary_schemes')->result();
    }

    function get_staff_salary_drop_down($month = NULL, $year = NULL){
        $this->db->select('am_staff_personal.personal_id,am_staff_personal.name,am_staff_personal.center,am_staff_personal.salary_scheme_id,am_staff_personal.leave_scheme_id,salary_schemes.amount,am_roles.role_name');
        $this->db->from('am_staff_personal');
		$this->db->join('am_roles','am_roles.role=am_staff_personal.role');
        $this->db->join('salary_schemes','salary_schemes.id=am_staff_personal.salary_scheme_id');
        $this->db->join('leave_schemes','leave_schemes.id=am_staff_personal.leave_scheme_id');
		if($month!='' && $year!='') {
			if($month>9) {
			$date = $year.'-'.$month.'-31';
			} else {
			$date = $year.'-0'.$month.'-31';	
			}
		$this->db->where('DATE(am_staff_personal.created_on)<=', $date);
		}
        $this->db->where('am_staff_personal.status',1);
        return $this->db->get()->result(); 
    }

    function get_staff_salary_status($id,$month,$year){
        $this->db->select('id');
        $this->db->where('staff_id',$id);
        $this->db->where('month',$month);
        $this->db->where('year',$year);
        return $this->db->get('salary')->num_rows();
    }

    function leave_scheme_details($id){
        $this->db->select('leave_schemes.*,sum(leave_schemes_details.count) as count');
        $this->db->from('leave_schemes');
        $this->db->join('leave_schemes_details','leave_schemes_details.leave_schemes_id=leave_schemes.id');
        $this->db->where('leave_schemes.id',$id);
        return $this->db->get()->row_array();
    }

    function get_total_staff_leave($staff,$fromDate,$toDate){
        $this->db->select_sum('no_of_days');
        $this->db->where('staff_id',$staff);
        $this->db->where('status',1);
        $this->db->where('start_date >=',$fromDate);
        $this->db->where('end_date <=',$toDate);
        return $this->db->get('leave_entry_log')->row_array();
    }

    function get_salary_basic_pay($id){
        $data = $this->db->select('*')->where('sal_schemes_id',$id)->where('sal_heads_id',1)->get('salary_schemes_details')->row_array();
        if(!empty($data)){
            return $data['amount'];
        }else{
            return "0";
        }
    }

    function get_advance_salary_paid($id,$type){
        $this->db->select_sum('amount');
        $this->db->where('status',1);
        $this->db->where('staff_id',$id);
        $this->db->where('type',$type);
        $data  = $this->db->get('salary_addon_transactions')->row_array();
        if(!empty($data)){
            if($data['amount'] == null){
                return "0";
            }else{
                return $data['amount'];
            }
        }else{
            return "0";
        }
    }

    function add_salary_processing($data){
        // return $this->db->insert_batch('salary',$data);
        $this->db->insert('salary', $data);
        return $this->db->insert_id();
    }

    function get_processed_salaries($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'salary';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        // $aColumns = array('id','scheme', 'date_from','date_to','amount');
        $aColumns = array('id','scheme_id','staff_id','status','month','year','monthly_salary','salary_add','prev_balance','salary_reduction','extra_allowance','extra_deduction','payable_salary','created_on');

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
        //$this->db->where('temple_id', $temple_id);
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

    function add_salary_advance($data){
        $this->db->insert('salary_addon_transactions',$data);
        return $this->db->insert_id();
    }

    function get_salary_advance($temple_id, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'salary_addon_transactions';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        // $aColumns = array('id','scheme', 'date_from','date_to','amount');
        $aColumns = array('id','staff_id','date','amount','type','status','description','processed_salary_id','created_on');

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
        // echo "<pre>"; print_r($output); exit;
        return $output;
    }

    function process_salary_add_ons($staff_id,$payslip_id){
        $data['status'] = 2;
        $data['processed_salary_id'] = $payslip_id;
        $this->db->where('staff_id',$staff_id);
        $this->db->where('status',1);
        $this->db->update('salary_addon_transactions',$data);
    }

    function get_processed_salary_detail($id){
        return $this->db->select('*')->where('id',$id)->get('salary')->row_array();
    }

    function get_salary_addons_by_payslip_id($id){
        return $this->db->select('*')->where('processed_salary_id',$id)->get('salary_addon_transactions')->result();
    }

    function add_staff_salary_head_amount($staffId,$schemeId,$salaryId){
        $salaryHeadAmount = $this->db->select('*')->where('sal_schemes_id',$schemeId)->get('salary_schemes_details')->result();
        $i = 0;
        $detailsArray = array();
        foreach($salaryHeadAmount as $row){
//            $detailsArray[$i]['staff_id'] = $staffId;
//            $detailsArray[$i]['scheme_id'] = $schemeId;
//            $detailsArray[$i]['head_id'] = $row->sal_heads_id;
//            $detailsArray[$i]['salary_process_id'] = $salaryId;
//            $detailsArray[$i]['amount'] = $row->amount;
              $detailsArray['staff_id'] = $staffId;
            $detailsArray['scheme_id'] = $schemeId;
            $detailsArray['head_id'] = $row->sal_heads_id;
            $detailsArray['salary_process_id'] = $salaryId;
            $detailsArray['amount'] = $row->amount;  
            $this->db->insert('salary_heads_amount',$detailsArray);
            $i++;
        } 
        //return $this->db->insert_batch('salary_heads_amount',$detailsArray);
        return true;
    }

    function get_total_pf($staffId,$salaryId,$headId){
        $this->db->select_sum('amount');
        $this->db->where('staff_id',$staffId);
        $this->db->where('head_id',$headId);
        $this->db->where('salary_process_id <=',$salaryId);
        $totalAmount = $this->db->get('salary_heads_amount')->row_array();
        if(!empty($totalAmount)){
            return $totalAmount['amount'];
        }else{
            return "0";
        }
    }
    function delete_salary_advance($id){
        $user = $this->db->select('id')->where('staff_id',$staff_id)->get('users')->row_array();
        if(!empty($user)){
            return $user['id'];
        }else{
            return "0";
        }
    }
}
