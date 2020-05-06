<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Salary_data extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->common_functions->get_common();
        $this->load->model('Salary_model');
        $this->load->model('General_Model');
        $this->load->model('Staff_model');
        $this->languageId = $this->session->userdata('language');
        $this->templeId = $this->session->userdata('temple');
    }

    function salary_heads_get() {
        $iDisplayStart = $this->input->get_post('iDisplayStart', TRUE);
        $iDisplayLength = $this->input->get_post('iDisplayLength', TRUE);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', TRUE);
        $iSortingCols = $this->input->get_post('iSortingCols', TRUE);
        $sSearch = $this->input->get_post('sSearch', TRUE);
        $sEcho = $this->input->get_post('sEcho', TRUE);
        $sSearch = trim($sSearch);
        $all = $this->Salary_model->get_salary_heads($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        if ($all) {
            $this->response($all, 200);
        } else {
            $this->response('Error', 404);
        }
    }

    function salary_head_add_post(){
        $assetData['head'] = $this->input->post('name');
        $assetData['type'] = $this->input->post('type');
        if(!$this->General_Model->checkDuplicateEntry('salary_heads','head',$this->input->post('name'))){
            echo json_encode(['message' => 'error','viewMessage' => 'Salary Head   already exist']);
            return;
        }
        if($this->Salary_model->add_salary_head($assetData)){
            echo json_encode(['message' => 'success','viewMessage' => 'Successfully Added', 'grid' => 'salary_heads']);
        }else{
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
        }
    }

    function salary_head_edit_get(){
        $balithara_id = $this->get('id');
        $data['editData'] = $this->Salary_model->get_salary_head_edit($balithara_id);
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }

    function salary_head_update_post(){
        $id = $this->input->post('selected_id');
        if(!$this->General_Model->checkDuplicateEntry('salary_heads','head',$this->input->post('name'),'id',$id)){
            echo json_encode(['message' => 'error','viewMessage' => 'Salary Head already exist']);
            return;
        }
        $assetData['head'] = $this->input->post('name');
        $assetData['type'] = $this->input->post('type'); 
        
        if (!$this->Salary_model->update_salary_head($id,$assetData)) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        echo json_encode(['message' => 'success','viewMessage' => 'Successfully Updated', 'grid' => 'salary_heads']);
    }

    function get_salary_head_drop_down_post(){
        $scheme_id = $this->input->post('scheme_id');
        $data['salary_heads'] = $this->Salary_model->get_salary_heads_dropdown();
        foreach($data['salary_heads'] as $key => $row){
            if($scheme_id == 0){
                $data['salary_heads'][$key]->amount = "0";
            }else{
                $amountArray = $this->Salary_model->get_scheme_head_amount($row->id,$scheme_id);
                if(empty($amountArray)){
                    $data['salary_heads'][$key]->amount = "0";
                }else{
                    $data['salary_heads'][$key]->amount = $amountArray['amount'];
                }
            }
        }
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }

    function get_salary_scheme_drop_down_get(){
        $data['data'] = $this->Salary_model->get_salary_scheme_drop_down();
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }

    function salary_scheme_details_get(){
        $iDisplayStart = $this->input->get_post('iDisplayStart', TRUE);
        $iDisplayLength = $this->input->get_post('iDisplayLength', TRUE);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', TRUE);
        $iSortingCols = $this->input->get_post('iSortingCols', TRUE);
        $sSearch = $this->input->get_post('sSearch', TRUE);
        $sEcho = $this->input->get_post('sEcho', TRUE);
        $sSearch = trim($sSearch);
        $all = $this->Salary_model->get_salary_schemes($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        if ($all) {
            $this->response($all, 200);
        } else {
            $this->response('Error', 404);
        }
    }

    function add_salary_scheme_post(){
        $dataArray = array();
        if(!$this->General_Model->checkDuplicateEntry('salary_schemes','scheme',$this->input->post('name'))){
            echo json_encode(['message' => 'error','viewMessage' => 'Salary Schemes already exist']);
            return;
        }
        $dataArray['scheme'] = $this->input->post('name');
        $dataArray['date_from'] = date('Y-m-d',strtotime($this->input->post('from_date')));
        $dataArray['date_to'] = date('Y-m-d',strtotime($this->input->post('to_date')));
        $dataArray['schemetype'] = $this->input->post('schemetype');
        $salary_scheme_id = $this->Salary_model->salary_scheme_add($dataArray);
        if (!$salary_scheme_id) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $detailsArray = array();
        $amount = 0;
        for($i=0;$i<count($this->input->post('head_id'));$i++){
            if(($this->input->post('head_id')[$i])){
                $detailsArray[$i]['sal_schemes_id'] = $salary_scheme_id;
                $detailsArray[$i]['sal_heads_id'] = $this->input->post('head_id')[$i];
                $detailsArray[$i]['amount'] = $this->input->post('amount')[$i];
                if($this->input->post('type')[$i] == "ADD"){
                    $amount = $amount + $this->input->post('amount')[$i];
                }else{
                    $amount = $amount - $this->input->post('amount')[$i];
                }
            }
        }
        $dataUpdateArray = array();
        $dataUpdateArray['amount'] = $amount;
        $this->Salary_model->update_salary_scheme_data($salary_scheme_id,$dataUpdateArray);
        $response = $this->Salary_model->insert_salary_scheme_detail($detailsArray);
        if (!$response) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        echo json_encode(['message' => 'success','viewMessage' => 'Successfully Added', 'grid' => 'salary_schemes']);
    }

    function salary_scheme_edit_get(){
        $scheme_id = $this->get('id');
        $data['main'] = $this->Salary_model->get_salary_scheme_edit($scheme_id); 
        $data['details'] = $this->Salary_model->get_salary_scheme_details($scheme_id);
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }

    function update_salary_scheme_post(){
        $scheme_id = $this->input->post('selected_id');
        if(!$this->General_Model->checkDuplicateEntry('salary_schemes','scheme',$this->input->post('name'))){
            echo json_encode(['message' => 'error','viewMessage' => 'Salary Schemes already exist']);
            return;
        }
        if(!$this->Salary_model->delete_salary_scheme_details($scheme_id)){
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $detailsArray = array();
        $amount = 0;
        for($i=0;$i<count($this->input->post('head_id'));$i++){
            if(($this->input->post('head_id')[$i])){
                $detailsArray[$i]['sal_schemes_id'] = $scheme_id;
                $detailsArray[$i]['sal_heads_id'] = $this->input->post('head_id')[$i];
                $detailsArray[$i]['amount'] = $this->input->post('amount')[$i];
                if($this->input->post('type')[$i] == "ADD"){
                    $amount = $amount + $this->input->post('amount')[$i];
                }else{
                    $amount = $amount - $this->input->post('amount')[$i];
                }
            }
        }
        $this->Salary_model->insert_salary_scheme_detail($detailsArray);
        $dataUpdateArray = array();
        $dataUpdateArray['amount'] = $amount;
        $dataUpdateArray['scheme'] = $this->input->post('name');
        $dataUpdateArray['date_from'] = date('Y-m-d',strtotime($this->input->post('from_date')));
        $dataUpdateArray['date_to'] = date('Y-m-d',strtotime($this->input->post('to_date')));
        $dataArray['schemetype'] = $this->input->post('schemetype');
        $response = $this->Salary_model->update_salary_scheme_data($scheme_id,$dataUpdateArray);
        if (!$response) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        echo json_encode(['message' => 'success','viewMessage' => 'Successfully Added', 'grid' => 'salary_schemes']);
    }

    function get_staff_salary_drop_down_post(){
    
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $staffData = $this->Salary_model->get_staff_salary_drop_down($month,$year); 
        foreach($staffData as $key => $row){
            $staffData[$key]->salary_status = $this->Salary_model->get_staff_salary_status($row->personal_id,$month,$year);
             
            $leaveCount = $this->Salary_model->leave_scheme_details($row->leave_scheme_id);
            $totalLeaveCount = $this->Salary_model->get_total_staff_leave($row->personal_id,$leaveCount['date_from'],$leaveCount['date_to']);
            $deductableLeave = $totalLeaveCount['no_of_days'] - $leaveCount['count'];
            $leaveDeductableAmount = 0;
            if($deductableLeave > 0){
                $basic_pay = $this->Salary_model->get_salary_basic_pay($row->salary_scheme_id);
                $leaveDeductableAmount = ((WORKING_DAYS-$deductableLeave)/WORKING_DAYS)*$basic_pay;
            }
            $staffData[$key]->leaveDeductableAmount = $leaveDeductableAmount;
            $staffData[$key]->advancePaid = $this->Salary_model->get_advance_salary_paid($row->personal_id,'DEDUCT');
            $staffData[$key]->advanceDeduction = $this->Salary_model->get_advance_salary_paid($row->personal_id,'ADD');
        }  
        $this->response($staffData);
    }

    function processed_salaries_get(){
        $iDisplayStart = $this->input->get_post('iDisplayStart', TRUE);
        $iDisplayLength = $this->input->get_post('iDisplayLength', TRUE);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', TRUE);
        $iSortingCols = $this->input->get_post('iSortingCols', TRUE);
        $sSearch = $this->input->get_post('sSearch', TRUE);
        $sEcho = $this->input->get_post('sEcho', TRUE);
        $sSearch = trim($sSearch);
        $all = $this->Salary_model->get_processed_salaries($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
		$x = 1;
        foreach($all['aaData'] as $key => $row){
            $staff = $this->Staff_model->get_staff_edit($row[2]); 
			$all['aaData'][$key]['sl'] 		= $iDisplayStart+$x;
            $all['aaData'][$key]['staff'] 	= $staff['staff']['name'];
			$all['aaData'][$key]['role'] 	= $staff['roles'][0]->role;
            $all['aaData'][$key]['add_on'] 	= $row[7] + $row[9] + $row[11];
            $all['aaData'][$key]['deduct'] 	= $row[8] + $row[10];
            $processed_on 					= $row[5]."-".$row[4]."-01";
            $all['aaData'][$key]['salary_for'] = date('M,Y',strtotime($processed_on));
			$x++;
        }
        if ($all) {
            $this->response($all, 200);
        } else {
            $this->response('Error', 404);
        }
    }

    /*function add_salary_processing_post(){
        $count = count($this->input->post('staff'));
        $salaryProcessingArray = array(); print_r($this->input->post('staff_select')[0]); echo $this->input->post('staff')[0];die('ramesh');
        for($i=0;$i<$count;$i++){
            if(isset($this->input->post('staff_select')[$i])){
                $salaryProcessingArray['temple_id'] = $this->input->post('center')[$i];
                $salaryProcessingArray['scheme_id'] = $this->input->post('scheme')[$i];
                $salaryProcessingArray['staff_id'] = $this->input->post('staff')[$i];
                $salaryProcessingArray['status'] = "ACTIVE";
                $salaryProcessingArray['date'] = date('Y-m-d');
                $salaryProcessingArray['month'] = $this->input->post('month');
                $salaryProcessingArray['year'] = $this->input->post('year');
                $salaryProcessingArray['monthly_salary'] = $this->input->post('salary')[$i];
                $salaryProcessingArray['salary_add'] = $this->input->post('advance_amount')[$i];
                $salaryProcessingArray['prev_balance'] = $this->input->post('prev_balance')[$i];
                $salaryProcessingArray['salary_reduction'] = $this->input->post('leave_amount')[$i];
                $salaryProcessingArray['extra_allowance'] = $this->input->post('allowance')[$i];
                $salaryProcessingArray['extra_deduction'] = $this->input->post('deduction')[$i];
                $payable_salary = $this->input->post('salary')[$i] + $this->input->post('prev_balance')[$i] + $this->input->post('allowance')[$i] -  $this->input->post('advance_amount')[$i] -  $this->input->post('leave_amount')[$i] -  $this->input->post('deduction')[$i];
                $salaryProcessingArray['payable_salary'] = $payable_salary;
                if($this->session->userdata('user_id')!='') {
                    $user_id = $this->session->userdata('user_id');
                } else {
                    $user_id =  '00'.$this->session->userdata('user_primary_id'); 
                }
                $salaryProcessingArray['created_by'] = $user_id;
                $salary_id = $this->Salary_model->add_salary_processing($salaryProcessingArray);
                $this->Salary_model->process_salary_add_ons($this->input->post('staff')[$i],$salary_id);
                $this->Salary_model->add_staff_salary_head_amount($this->input->post('staff')[$i],$this->input->post('scheme')[$i],$salary_id);
               
                $accountEntryMain = array();
                $accountEntryMain['entry_from'] = "web";
                $accountEntryMain['type'] = "Debit";
                $accountEntryMain['voucher_type'] = "Voucher";
                $accountEntryMain['sub_type1'] = "Cash";
                $accountEntryMain['sub_type2'] = "";
                $accountEntryMain['head'] = $this->input->post('staff')[$i];
                $accountEntryMain['table'] = "salary";
                $accountEntryMain['date'] = date('Y-m-d');
                $accountEntryMain['voucher_no'] = $salary_id;
                $accountEntryMain['amount'] = $payable_salary;
                $accountEntryMain['description'] = "";
                $this->accounting_entries->accountingEntry($accountEntryMain);
                
            }
        }
        if($salary_id){
            echo json_encode(['message' => 'success','viewMessage' => 'Successfully Added', 'grid' => 'salary_processing']);
        }else{
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
    } */
	
	
	function add_salary_processing_post(){
        $count = $this->input->post('count');
        $salaryProcessingArray = array();
        for($i=1;$i<=$count;$i++){
            if($this->input->post('staff_select_'.$i) !== NULL){
                $salaryProcessingArray['temple_id'] = $this->input->post('center_'.$i);
                $salaryProcessingArray['scheme_id'] = $this->input->post('scheme_'.$i);
                $salaryProcessingArray['staff_id'] = $this->input->post('staff_'.$i);
                $salaryProcessingArray['status'] = "ACTIVE";
                $salaryProcessingArray['date'] = date('Y-m-d');
                $salaryProcessingArray['month'] = $this->input->post('month');
                $salaryProcessingArray['year'] = $this->input->post('year');
                $salaryProcessingArray['monthly_salary'] = $this->input->post('salary_'.$i);
                $salaryProcessingArray['salary_add'] = $this->input->post('advance_amount_'.$i);
                $salaryProcessingArray['prev_balance'] = $this->input->post('prev_balance_'.$i);
                $salaryProcessingArray['salary_reduction'] = $this->input->post('leave_amount_'.$i);
                $salaryProcessingArray['extra_allowance'] = $this->input->post('allowance_'.$i);
                $salaryProcessingArray['extra_deduction'] = $this->input->post('deduction_'.$i);
                $payable_salary = $this->input->post('salary_'.$i) + $this->input->post('prev_balance_'.$i) + $this->input->post('allowance_'.$i) -  $this->input->post('advance_amount_'.$i) -  $this->input->post('leave_amount_'.$i) -  $this->input->post('deduction_'.$i);
				
                if($this->session->userdata('user_id')!='') {
                    $user_id = $this->session->userdata('user_id');
                } else {
                    $user_id =  '00'.$this->session->userdata('user_primary_id'); 
                }
                $salaryProcessingArray['payable_salary'] = $payable_salary;
                $salaryProcessingArray['created_by'] = $user_id; 
                $salary_id = $this->Salary_model->add_salary_processing($salaryProcessingArray);
                $this->Salary_model->process_salary_add_ons($this->input->post('staff_'.$i),$salary_id);
                $this->Salary_model->add_staff_salary_head_amount($this->input->post('staff_'.$i),$this->input->post('scheme_'.$i),$salary_id);
                /**Accounting Entry Start*/
                $accountEntryMain = array();
                $accountEntryMain['temple_id'] = $this->input->post('center_'.$i);
                $accountEntryMain['entry_from'] = "web";
                $accountEntryMain['type'] = "Debit";
                $accountEntryMain['voucher_type'] = "Voucher";
                $accountEntryMain['sub_type1'] = "Cash";
                $accountEntryMain['sub_type2'] = "";
                $accountEntryMain['head'] = $this->input->post('staff_'.$i);
                $accountEntryMain['table'] = "salary";
                $accountEntryMain['date'] = date('Y-m-d');
                $accountEntryMain['voucher_no'] = $salary_id;
                $accountEntryMain['amount'] = $payable_salary;
                $accountEntryMain['description'] = "";
                $this->accounting_entries->accountingEntry($accountEntryMain);
                /**Accounting Entry End */
            }
        }
        if($salary_id){
            echo json_encode(['message' => 'success','viewMessage' => 'Successfully Added', 'grid' => 'salary_processing']);
        }else{
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
    }


    function salary_processing_view_get(){
        $salary_id = $this->get('id');
        $data['salary'] = $this->Salary_model->get_processed_salary_detail($salary_id);
        $data['staff'] = $this->Staff_model->get_staff_edit($data['salary']['staff_id']); //echo '<pre>'; print_r($data['staff']);
        $data['salary_scheme'] = $this->Salary_model->get_salary_scheme_details($data['salary']['scheme_id']);
        $data['salary_addons'] = $this->Salary_model->get_salary_addons_by_payslip_id($salary_id);
        $processing_time = $data['salary']['year']."-".$data['salary']['month']."-01";
        $data['salary']['processing_time'] = strtoupper(date('F Y',strtotime($processing_time)));
        $data['total_pf_taken'] = $this->Salary_model->get_total_pf($data['salary']['staff_id'],$salary_id,3); //echo '<pre>';print_r($data);
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }

    function add_salary_advance_post(){
        $data['staff_id'] = $this->input->post('staff');
        $data['date'] = date('Y-m-d',strtotime($this->input->post('date')));
        $data['description'] = $this->input->post('description');
        $data['amount'] = $this->input->post('amount');
        $data['type'] = $this->input->post('type'); 
        if($this->session->userdata('user_id')!='') {
           $user_id =  $this->session->userdata('user_id');
        } else {
           $user_id =  '00'.$this->session->userdata('user_primary_id'); 
        }
        if($id = $this->Salary_model->add_salary_advance($data)){
            //echo $id;
            /**Accounting Entry Start*/
            if($this->input->post('type') == "ADD"){
                $accountEntryMain = array();
                $accountEntryMain['entry_from'] = "web";
                $accountEntryMain['type'] = "Debit";
                $accountEntryMain['voucher_type'] = "Voucher";
                $accountEntryMain['sub_type1'] = "Cash";
                $accountEntryMain['sub_type2'] = "";
                $accountEntryMain['head'] = 1;
                $accountEntryMain['table'] = "salary";
                $accountEntryMain['date'] = date('Y-m-d');
                $accountEntryMain['voucher_no'] = $id;
                $accountEntryMain['amount'] = $this->input->post('amount');
                $accountEntryMain['description'] = "";
                $accountEntryMain['accountType'] = "Salary Advance";
                $this->accounting_entries->accountingEntry($accountEntryMain);
            }else{
                $accountEntryMain = array();
                $accountEntryMain['entry_from'] = "web";
                $accountEntryMain['type'] = "Credit";
                $accountEntryMain['voucher_type'] = "Voucher";
                $accountEntryMain['sub_type1'] = "";
                $accountEntryMain['sub_type2'] = "Cash";
                $accountEntryMain['head'] = 1;
                $accountEntryMain['table'] = "salary";
                $accountEntryMain['date'] = date('Y-m-d');
                $accountEntryMain['voucher_no'] = $id;
                $accountEntryMain['amount'] = $this->input->post('amount');
                $accountEntryMain['description'] = "";
                $accountEntryMain['accountType'] = "Salary Reduction";
                $this->accounting_entries->accountingEntry($accountEntryMain);
            }
            /**Accounting Entry End */
            echo json_encode(['message' => 'success','viewMessage' => 'Successfully Added', 'grid' => 'salary_advance']);
        }else{
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
    }

    function get_salary_advance_get(){
        $iDisplayStart = $this->input->get_post('iDisplayStart', TRUE);
        $iDisplayLength = $this->input->get_post('iDisplayLength', TRUE);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', TRUE);
        $iSortingCols = $this->input->get_post('iSortingCols', TRUE);
        $sSearch = $this->input->get_post('sSearch', TRUE);
        $sEcho = $this->input->get_post('sEcho', TRUE);
        $sSearch = trim($sSearch);
        $all = $this->Salary_model->get_salary_advance($this->templeId,$iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
		$x = 1;
        foreach($all['aaData'] as $key => $row){
            $staff = $this->Staff_model->get_staff_edit($row[1]);
			$all['aaData'][$key]['sl'] = $x;
            $all['aaData'][$key]['staff'] = $staff['staff']['name'];
            if ($all['aaData'][$key]['7'] == ''){
                $all['aaData'][$key]['payslip'] = '0';
            }else{
                $all['aaData'][$key]['payslip'] = '1';
            }
            $all['aaData'][$key]['aid'] = $all['aaData'][$key]['0'];
			$x++;
        }
        // echo "Ramesh<pre>"; print_r($all);
        if ($all) {
            $this->response($all, 200);
        } else {
            $this->response('Error', 404);
        }
    }

    function print_salary_invoice_in_pdf_get(){
        $salary_id = $this->get('salary_process_id');
        $listData['salary'] = $this->Salary_model->get_processed_salary_detail($salary_id);
        $listData['staff'] = $this->Staff_model->get_staff_edit($listData['salary']['staff_id']); 
        $listData['salary_scheme'] = $this->Salary_model->get_salary_scheme_details($listData['salary']['scheme_id']);
        $listData['salary_addons'] = $this->Salary_model->get_salary_addons_by_payslip_id($salary_id);
        $processing_time = $listData['salary']['year']."-".$listData['salary']['month']."-01";
        $listData['salary']['processing_time'] = strtoupper(date('F Y',strtotime($processing_time)));
        $listData['total_pf_taken'] = $this->Salary_model->get_total_pf($listData['salary']['staff_id'],$salary_id,3);
       // echo '<pre>'; print_r($listData);die();
        $this->load->library('Pdftc');
        $this->load->view("admin/salary_slip", $listData);
    }
    public function delete_salary_advance_post()
    {
        if($_POST){
            $id  = $_POST['id'];
            $res = $this->common->delete('salary_addon_transactions', array('id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'salary_addon_transactions');
                echo json_encode(['message' => 'success','viewMessage' => 'Successfully Deleted', 'grid' => 'salary_advance']);
                return;
            }
            else{
                echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
                return;
            }
        }else{
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
    }
}
