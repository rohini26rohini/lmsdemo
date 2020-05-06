<?php

class Content_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function get_school(){
        return $this->db->select('*')->where('school_status',1)->get('am_schools')->result();
    }
    function success_storie_add($data){
        return $this->db->insert('web_success_stories',$data);
    }
    function get_stories(){
        return $this->db->select('*')->where('success_status',1)->order_by("success_id", "desc")->get('web_success_stories')->result();
    }
    function get_success_id($success_id)
    {
		$this->db->select('*');
		$this->db->where('success_id',$success_id);
		$query	=	$this->db->get('web_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }
    function get_basic_map_heads($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'accounting_map_heads';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','map_head','map_table', 'status');

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
    
    function check_possible_map_head_duplicate($tableName,$id){
        $count = $this->db->where('map_table',$tableName)->where('id !=',$id)->get('accounting_map_heads')->num_rows();
        if($count == 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function add_basic_map_heads($data){
        return $this->db->insert('accounting_map_heads',$data);
    }

    function edit_basic_map_heads($id){
        return $this->db->select('*')->where('id',$id)->get('accounting_map_heads')->row_array();
    }

    function update_basic_map_heads($id,$data){
        return $this->db->where('id',$id)->update('accounting_map_heads',$data);
    }

    function get_accounting_heads($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'view_accounting_groups';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','head','map_head', 'status');

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
        $this->db->where('map_head !=',"");
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

    function get_map_head(){
        return $this->db->select('*')->where('status',1)->get('accounting_map_heads')->result();
    }

    function get_map_item_from_head($lang,$table){
        if($table == "pooja_master"){
            $this->db->select('pooja_master.id,pooja_master_lang.pooja_name as item');
            $this->db->from('pooja_master');
            $this->db->join('pooja_master_lang','pooja_master_lang.pooja_master_id=pooja_master.id');
            $this->db->where('pooja_master_lang.lang_id',$lang);
            $this->db->order_by('pooja_master_lang.pooja_name');
            return $this->db->get()->result();
        }else if($table == "asset_master"){
            $this->db->select('asset_master.id,asset_master_lang.asset_name as item');
            $this->db->from('asset_master');
            $this->db->join('asset_master_lang','asset_master_lang.asset_master_id=asset_master.id');
            $this->db->where('asset_master_lang.lang_id',$lang);
            $this->db->order_by('asset_master_lang.asset_name');
            return $this->db->get()->result();
        }else if($table == "item_master"){
            $this->db->select('item_master.id,item_master_lang.name as item');
            $this->db->from('item_master');
            $this->db->join('item_master_lang','item_master_lang.item_master_id=item_master.id');
            $this->db->where('item_master_lang.lang_id',$lang);
            $this->db->order_by('item_master_lang.name');
            return $this->db->get()->result();
        }else if($table == "auditorium_master"){
            $this->db->select('auditorium_master.id,auditorium_master_lang.name as item');
            $this->db->from('auditorium_master');
            $this->db->join('auditorium_master_lang','auditorium_master_lang.auditorium_master_id=auditorium_master.id');
            $this->db->where('auditorium_master_lang.lang_id',$lang);
            $this->db->order_by('auditorium_master_lang.name');
            return $this->db->get()->result();
        }else if($table == "balithara_master"){
            $this->db->select('balithara_master.id,balithara_master_lang.name as item');
            $this->db->from('balithara_master');
            $this->db->join('balithara_master_lang','balithara_master_lang.balithara_id=balithara_master.id');
            $this->db->where('balithara_master_lang.lang_id',$lang);
            $this->db->order_by('balithara_master_lang.name');
            return $this->db->get()->result();
        }else if($table == "bank_accounts"){
            return $this->db->select('id,account_no as item')->get('bank_accounts')->result();
        }else if($table == "bank_fixed_deposits"){
            return $this->db->select('id,account_no as item')->get('bank_fixed_deposits')->result();
        }else if($table == "donation_category"){
            $this->db->select('donation_category.id,donation_category_lang.category as item');
            $this->db->from('donation_category');
            $this->db->join('donation_category_lang','donation_category_lang.donation_category_id=donation_category.id');
            $this->db->where('donation_category_lang.lang_id',$lang);
            $this->db->order_by('donation_category_lang.category');
            return $this->db->get()->result();
        }else if($table == "postal_charge"){
            return $this->db->select('id')->get('postal_charge')->result();
        }else if($table == "annadhanam_booking"){
            return $this->db->select('id')->get('postal_charge')->result();
        }else if($table == "supplier"){
            return $this->db->select('id,store as item')->get('supplier')->result();
        }else if($table == "salary"){
            return $this->db->select('id,name as item')->get('staff')->result();
        }else if($table == "transaction_heads"){
            $this->db->select('transaction_heads.id,transaction_heads_lang.head as item');
            $this->db->from('transaction_heads');
            $this->db->join('transaction_heads_lang','transaction_heads_lang.transactions_head_id=transaction_heads.id');
            $this->db->where('transaction_heads_lang.lang_id',$lang);
            $this->db->order_by('transaction_heads_lang.head');
            return $this->db->get()->result();
        }else if($table == "pos_receipt_book"){
            return $this->db->select('id,book_eng as item')->get('view_pos_receipt_books')->result();
        }
    }

    function get_mapped_head_items($headId,$lang,$table){
        if($table == "pooja_master"){
            $this->db->select('pooja_master_lang.pooja_name as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('pooja_master_lang','pooja_master_lang.pooja_master_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('pooja_master_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('pooja_master_lang.pooja_name');
            return $this->db->get()->result();
        }else if($table == "asset_master"){
            $this->db->select('asset_master_lang.asset_name as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('asset_master_lang','asset_master_lang.asset_master_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('asset_master_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('asset_master_lang.asset_name');
            return $this->db->get()->result();
        }else if($table == "item_master"){
            $this->db->select('item_master_lang.name as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('item_master_lang','item_master_lang.item_master_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('item_master_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('item_master_lang.name');
            return $this->db->get()->result();
        }else if($table == "auditorium_master"){
            $this->db->select('auditorium_master_lang.name as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('auditorium_master_lang','auditorium_master_lang.auditorium_master_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('auditorium_master_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('auditorium_master_lang.name');
            return $this->db->get()->result();
        }else if($table == "balithara_master"){
            $this->db->select('balithara_master_lang.name as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('balithara_master_lang','balithara_master_lang.balithara_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('balithara_master_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('balithara_master_lang.name');
            return $this->db->get()->result();
        }else if($table == "bank_accounts"){
            $this->db->select('bank_accounts.account_no as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('bank_accounts','bank_accounts.id=accounting_head_mapping.mapped_head_id');
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('bank_accounts.id');
            return $this->db->get()->result();
        }else if($table == "bank_fixed_deposits"){
            $this->db->select('bank_fixed_deposits.account_no as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('bank_fixed_deposits','bank_fixed_deposits.id=accounting_head_mapping.mapped_head_id');
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('bank_fixed_deposits.id');
            return $this->db->get()->result();
        }else if($table == "donation_category"){
            $this->db->select('donation_category_lang.category as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('donation_category_lang','donation_category_lang.donation_category_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('donation_category_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('donation_category_lang.category');
            return $this->db->get()->result();
        }else if($table == "postal_charge"){
            return $this->db->select('id')->order_by('id','asc')->limit(1)->get('postal_charge')->result();
        }else if($table == "annadhanam_booking"){
            return $this->db->select('id')->order_by('id','asc')->limit(1)->get('postal_charge')->result();
        }else if($table == "supplier"){
            $this->db->select('supplier.store as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('supplier','supplier.id=accounting_head_mapping.mapped_head_id');
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('supplier.store');
            return $this->db->get()->result();
        }else if($table == "salary"){
        }else if($table == "transaction_heads"){
            $this->db->select('transaction_heads_lang.head as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('transaction_heads_lang','transaction_heads_lang.transactions_head_id=accounting_head_mapping.mapped_head_id');
            $this->db->where('transaction_heads_lang.lang_id',$lang);
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('transaction_heads_lang.head');
            return $this->db->get()->result();
        }else if($table == "pos_receipt_book"){
            $this->db->select('pos_receipt_book_items.book_no as item');
            $this->db->from('accounting_head_mapping');
            $this->db->join('pos_receipt_book_items','pos_receipt_book_items.id=accounting_head_mapping.mapped_head_id');
            $this->db->where('accounting_head_mapping.accounting_head_id',$headId);
            $this->db->order_by('pos_receipt_book_items.book_no');
            return $this->db->get()->result();
        }
    }

    function add_account_main_head($data){
        $this->db->insert('accounting_head', $data);
        return $this->db->insert_id();
    }

    function edit_account_group($id){
        return $this->db->select('*')->where('id',$id)->get('accounting_head')->row_array();
    }

    function update_account_main_head($id,$data){
        return $this->db->where('id',$id)->update('accounting_head', $data);
    }

    function add_account_sub_head($data){
        return $this->db->insert('accounting_head', $data);
    }

    function add_account_head_mapping($data){
        return $this->db->insert_batch('accounting_head_mapping',$data);
    }

    function edit_account_main_head($id){
        return $this->db->select('*')->where('id',$id)->get('view_accounting_groups')->row_array();
    }

    function get_accounting_sub_heads($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'view_accounting_sub_heads';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','head','parent_head','map_head', 'status');

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

    function edit_account_sub_head($id){
        return $this->db->select('*')->where('id',$id)->get('view_accounting_sub_heads')->row_array();
    }

    function get_account_main_head(){
        return $this->db->select('*')->where('status',1)->get('view_accounting_heads')->result();
    }

    function getAccountHeadInfo($id,$table){
        $this->db->select('accounting_head.*');
        $this->db->from('accounting_head');
        $this->db->join('accounting_map_heads','accounting_map_heads.id=accounting_head.table_id');
        $this->db->join('accounting_head_mapping','accounting_head_mapping.accounting_head_id=accounting_head.id');
        $this->db->where('accounting_head_mapping.mapped_head_id',$id);
        $this->db->where('accounting_map_heads.map_table',$table);
        $this->db->where('accounting_head.type','Child');
        return $this->db->get()->row_array();
    }

    function getAccountHeadInfoFromStaticAccountHead($head){
        return $this->db->select('*')->where('head',$head)->get('accounting_head')->row_array();
    }

    function add_main_account_entry($data){
        $this->db->insert('accounting_entry', $data);
        return $this->db->insert_id();
    }

    function getAccountSubHead($headId,$mappedId){
        $this->db->select('accounting_head.*');
        $this->db->from('accounting_head');
        $this->db->join('accounting_head_mapping','accounting_head_mapping.accounting_head_id=accounting_head.parent');
        $this->db->where('accounting_head_mapping.mapped_head_id',$mappedId);
        $this->db->where('accounting_head.parent',$headId);
        $this->db->where('accounting_head.type','child');
        return $this->db->get()->row_array();
    }

    function getCommonAccountSubHead($type){
        return $this->db->select('*')->where('child_type',$type)->get('accounting_head')->row_array();
    }

    function add_sub_account_entry($data){
        return $this->db->insert('accounting_sub_entry',$data);
    }

    function get_accounting_entries($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'view_accounting_entries';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','date','head','voucher_type', 'voucher_no', 'debit_amount', 'credit_amount', 'status', 'tally_status', 'tally_updated_date');

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
        $this->db->where('status','ACTIVE');
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

    function get_accounting_sub_entries($entryId){
        $this->db->select('accounting_sub_entry.*,accounting_head.head');
        $this->db->from('accounting_sub_entry');
        $this->db->join('accounting_head','accounting_head.id=accounting_sub_entry.sub_head_id');
        $this->db->where('accounting_sub_entry.entry_id',$entryId);
        $this->db->where('accounting_head.type','child');
        return $this->db->get()->result();
    }

    function get_accounting_groups($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho){
        $sTable = 'view_accounting_groups';
        //* Array of database columns which should be read and sent back to DataTables. Use a space where
        //* you want to insert a non-database field (for example a counter or static image)
        $aColumns = array('id','parent_head','head');

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

    function get_accounting_head_groups(){
        return $this->db->select('*')->where('type','Parent')->get('accounting_head')->result();
    }

    function get_all_account_heads_under_parent($id){
        return  $this->db->where('id',$id)->get('view_accounting_groups')->row_array();
    }

    function get_account_tree_structure($parent_group_id,$level){
        $this->db->select('*');
        $this->db->where('parent_group_id',$parent_group_id);
        $this->db->order_by('level','asc');
        $this->db->limit($level);
        return $this->db->get('view_accounting_groups')->result();
    }

    function get_accounting_heads_drop_down(){
        return $this->db->select('*')->where('type','Child')->get('accounting_head')->result();
    }

    function update_main_account_entry($updateData,$whereData){
        $this->db->where('voucher_type',$whereData['voucher_type']);
        $this->db->where('voucher_no',$whereData['voucher_no']);
        $this->db->where('status',$whereData['status']);
        $this->db->update('accounting_entry',$updateData);
    }

//--------------------------------------------- SERVICES ------------------------------------------------//
	/**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	public function get_services(){
        $this->db->select('*');
		$query	=	$this->db->get('web_services');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}
	//------------------------------------------------
    /**
	*This function 'll return existing services details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_services_exist($data)
    {
        $query= $this->db->get_where('web_services',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert services details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function services_add($data)
    {
		$res=$this->db->insert('web_services',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get services details by id
	*
	* @access public
	* @params service_id
	* @return integer
	* @author Seethal
	*/
    public function get_servicesdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('web_services')
                    ->where('web_services.service_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update services details by id
	*
	* @access public
	* @params service_id
	* @return integer
	* @author Seethal
	*/
    function services_edit($data,$id)
    {
        $this->db->where('service_id',$id);
		$query	= $this->db->update('web_services',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete services details by id
	*
	* @access public
	* @params service_id
	* @return integer
	* @author Seethal
	*/
    public function services_delete($id)
    {
        $this->db->where('service_id', $id);
        $query=$this->db->delete('web_services');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get services details by id
	*
	* @access public
	* @params service_id 
	* @return integer
	* @author Seethal
	*/
    function get_services_by_id($service_id)
    {
		$this->db->select('*');
		$this->db->where('service_id',$service_id);
        $query	=	$this->db->get('web_services');
        $resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr; 

    }
    
// Gallery.................................................................. 
    function get_gallery(){
        return $this->db->select('*')->where('gallery_status',1)->order_by("gallery_id", "desc")->get('web_gallery')->result();
    }
    // function get_galleryName(){
    //     $this->db->select('*');
    //     $this->db->where('gallery_status',1); 
    //     $this->db->group_by('gallery_name'); 
	//     $this->db->order_by('gallery_id','DESC');
	//     $this->db->from('web_gallery');
	//     $query = $this->db->get();
	// 	$resultArr	=	array();
	// 	 $afftectedRows = $this->db->affected_rows();
    //  if ($afftectedRows == 1) {
	// 		$resultArr	=	$query->result();
	// 	}
	// 	return $resultArr;
    //     // return $this->db->select('DISTINCT `gallery_image`')->where('gallery_status',1)->get('web_gallery')->result();
    // }
    function get_galleryName(){
        $this->db->select('*');
        $this->db->where('gallery_status',1); 
        $this->db->group_by('gallery_name'); 
	    $this->db->order_by('gallery_id','DESC');
	    $this->db->from('web_gallery');
	    $res=$this->db->get(); 
	    return $res->result();
        // return $this->db->select('DISTINCT `gallery_image`')->where('gallery_status',1)->get('web_gallery')->result();
    }
    // select('DISTINCT `gallery_image`')
    function get_gallery_id($gallery_id)
    {
		$this->db->select('*');
		$this->db->where('gallery_id',$gallery_id);
		$query	=	$this->db->get('web_gallery');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    } 
    
//--------------------------------------------- RESULTS ------------------------------------------------//
	/**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    function get_result() {
        $this->db->select('web_results.*,am_schools.school_name,web_notifications.name as notification_name');
        $this->db->from('web_results'); 
        $this->db->join('am_schools', 'am_schools.school_id=web_results.school_id','left');
        $this->db->join('web_notifications', 'web_notifications.notification_id=web_results.notification_id','left');
        $this->db->order_by('web_results.result_id','desc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }
	//------------------------------------------------
    /**
	*This function 'll return existing result details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_result_exist($data)
    {
        $query= $this->db->get_where('web_results',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll insert result details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function result_add($data)
    {
		$res=$this->db->insert('web_results',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get result details by id
	*
	* @access public
	* @params result_id
	* @return integer
	* @author Seethal
	*/
    public function get_resultdetails_by_id($id)
    {
        $this->db->select('*');
		$this->db->where('result_id',$id);
		$query	=	$this->db->get('web_results');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;

    }
    //------------------------------------------------
    /**
	*This function 'll update result details by id
	*
	* @access public
	* @params result_id
	* @return integer
	* @author Seethal
	*/
    function result_edit($data,$id)
    {
        $this->db->where('result_id',$id);
		$query	= $this->db->update('web_results',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete result result by id
	*
	* @access public
	* @params result_id
	* @return integer
	* @author Seethal
	*/
    public function result_delete($id)
    {
        $this->db->where('result_id', $id);
        $query=$this->db->delete('web_results');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get result details by id
	*
	* @access public
	* @params result_id 
	* @return integer
	* @author Seethal
	*/
    function get_result_by_id($result_id)
    {
        // $this->db->select('*');
		// $this->db->where('result_id',$result_id);
		// $query	=	$this->db->get('web_results');
		// $resultArr	=	array();
		// if($query->num_rows() > 0){
		// 	$resultArr	=	$query->row_array();		
		// }
        // return $resultArr;
        


        $this->db->select('web_results.*,web_notifications.name as notification_name');
        $this->db->from('web_results'); 
        $this->db->join('web_notifications', 'web_notifications.notification_id=web_results.notification_id');
		$this->db->where('result_id',$result_id);
      $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
        return $resultArr;
    }
    //------------------------------------------------
    /**
	*This function 'll fetch result details by id
	*
	* @access public
	* @params result_id 
	* @return integer
	* @author Seethal
	*/
    function fetch_data($hall_ticket_id)
    {
        $query	=	$this->db->select('web_examlist.*,am_students.name,am_students.student_image,am_students.district,cities.name as city_name')
                ->from('web_examlist')
                ->where('examlist_id',$hall_ticket_id)
                ->join('am_students', 'am_students.student_id = web_examlist.student_id','left')
                ->join('cities', 'cities.id = am_students.district')
                ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll fetch exams details by id
	*
	* @access public
	* @params result_id 
	* @return integer
	* @author Seethal
	*/
    function get_all_exams($result_id)
    {
        $this->db->select('web_results.*,web_notifications.name as notification_name');
        $this->db->from('web_results'); 
        $this->db->join('web_notifications', 'web_notifications.notification_id=web_results.notification_id','left');
		$this->db->where('result_id',$result_id);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
            $resultArr	=	$query->result_array();		
        }
        return $resultArr;
    }
    

// General studies.................................................................. 
    function get_gs(){
        return $this->db->select('*')->where('type !=','syllabus')->where('type !=','previous_question')->order_by("id", "desc")->get('web_general_studies')->result();
    }
    function get_general_studies_id($id)
    {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query	=	$this->db->get('web_general_studies');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }    
    public function change_gs_status($id,$status)
    { 
		if($status == 0){
			$this->db->where('id', $id);
			$query=$this->db->update('web_general_studies',array("status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('id', $id);
			$query=$this->db->update('web_general_studies',array("status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
    }

    // previous question and syllabus.................................................................. 

    function get_previous_question_and_syllabus(){
        return $this->db->select('*')->where('type !=','general_studies')->order_by("id", "desc")->get('web_general_studies')->result();
    }
// Career.................................................................. 
	function get_career(){
        return $this->db->select('*')->where('careers_status !=',2)->get('web_careers')->result();
	}
	function get_designation(){
        return $this->db->select('*')->where('role_status',1)->get('am_roles')->result();
	}
	function get_career_data($id)
    {
		$this->db->select('*');
		$this->db->where('careers_id',$id);
		$query	=	$this->db->get('web_careers');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }
    public function change_career_status($id,$status)
    { 
		if($status == 0){
			$this->db->where('careers_id', $id);
			$query=$this->db->update('web_careers',array("careers_status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('careers_id', $id);
			$query=$this->db->update('web_careers',array("careers_status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
    }

// Application.................................................................. 

	function get_application(){
		return $this->db->select('*')->order_by("id", "desc")->get('web_career_apply')->result();
	}
	function get_application_status_id($id){
		return $this->db->select('*')->where('application_id',$id)->get('web_application_status')->result();
	}
	function get_sas($id){
		return $this->db->select('*')->where('school_id',$id)->get('web_special_about')->result();
    }
    function get_application_id($id){
		$this->db->select('*');
		$this->db->where('id',$id);
		$query	=	$this->db->get('web_career_apply');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}  
    
    function get_prepare($id){
		return $this->db->select('*')->where('prepare_id',$id)->get('web_prepare_content')->row_array();
    }
    function get_prepares($prepare_id){
		return $this->db->select('*')->where('prepare_id',$prepare_id)->get('web_prepare_content')->row_array();
	}
// banner --------------------------------------------------------------------------

	function get_banner(){
		return $this->db->select('*')->where('status',1)->order_by("id", "desc")->get('web_banner')->result();
	}
	function get_home_banner($type){
		$this->db->select('*');
		$this->db->where('type',$type);
		$query	=	$this->db->get('web_banner');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
			return count($resultArr);
		}
		return false;
    }    
	function get_banner_id($id){
		$this->db->select('*');
		$this->db->where('id',$id);
		$query	=	$this->db->get('web_banner');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
	}  
	function get_school_banner($type,$school_id){
		$this->db->select('*');
		$this->db->where('type',$type);
		$this->db->where('school_id',$school_id);
		$query	=	$this->db->get('web_banner');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
			return count($resultArr);
		}
		return false;
    } 

//--------------------------------------- EXAMS & NOTIFICATIONS -----------------------------------------------//
    /**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Ramesh
	*/
	public function get_exam(){
        $this->db->select('web_notifications.*,am_schools.school_name');
        $this->db->from('web_notifications'); 
        $this->db->join('am_schools', 'am_schools.school_id=web_notifications.school_id','left');
        $this->db->where('notification_status', '1');

        $this->db->order_by('web_notifications.notification_id','desc'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0){
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
    public function is_exam_exist($data)
    {
        $query= $this->db->get_where('web_notifications',$data);
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
    public function exam_add($data)
    {
		$res=$this->db->insert('web_notifications',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get exam details by id
	*
	* @access public
	* @params notification_id
	* @return integer
	* @author Seethal
	*/
    public function get_examdetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('web_notifications')
                    ->where('web_notifications.notification_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update exam details by id
	*
	* @access public
	* @params notification_id
	* @return integer
	* @author Seethal
	*/
    function exam_edit($id,$data)
    {
        $this->db->where('notification_id',$id);
		$query	= $this->db->update('web_notifications',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete exam details by id
	*
	* @access public
	* @params notification_id
	* @return integer
	* @author Seethal
	*/
    public function exam_delete($id)
    {
        $this->db->where('notification_id', $id);
        $query=$this->db->update('web_notifications',array("notification_status"=>"2"));
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    

    //------------------------------------------------
    /**
	*This function 'll get exam details by id
	*
	* @access public
	* @params notification_id 
	* @return integer
	* @author Seethal
	*/
    function get_exam_by_id($notification_id)
    {
		$this->db->select('*');
		$this->db->where('notification_id',$notification_id);
		$query	=	$this->db->get('web_notifications');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }

    //--------------------------------------------- HOW TO PREPARE ------------------------------------------------//
	/**
	*This function 'll return the bus table list
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
	function get_how_to_prepare(){
        return $this->db->select('*')->order_by("prepare_id", "desc")->get('web_prepare_content')->result();
    }
	//------------------------------------------------
    /**
	*This function 'll return existing how_to_prepare details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function is_how_to_prepare_exist($data)
    {
        $query= $this->db->get_where('web_prepare_content',$data);
        if($query->num_rows()>0){
           return true;
        }else{
            return false;
        }
    }
    function get_categoryby_school($school_id){
        return $this->db->select('*')->where('school_id',$school_id)->where('status',1)->get('web_category')->result();
    }
    function get_howtoprepare_id($id)
    {
		$this->db->select('*');
		$this->db->where('prepare_id',$id);
		$query	=	$this->db->get(' web_prepare_content');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }  
    function get_howtoprepare_id_view($id)
    {
        $this->db->select('*');
        $this->db->from('web_prepare_content');
        $this->db->join('web_category','web_category.id=web_prepare_content.category_id');
        $this->db->join('am_schools','am_schools.school_id=web_prepare_content.school_id');
		$this->db->where('prepare_id',$id);
		$query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }  
    //------------------------------------------------
    /**
	*This function 'll insert how_to_prepare details
	*
	* @access public
	* @params
	* @return integer
	* @author Seethal
	*/
    public function how_to_prepare_add($data)
    {
		$res=$this->db->insert('web_prepare_content',$data);
	    if($res){
            return true;
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll get how_to_prepare details by id
	*
	* @access public
	* @params prepare_id
	* @return integer
	* @author Seethal
	*/
    public function get_how_to_preparedetails_by_id($id)
    {
        $query	=	$this->db->select('*')
                    ->from('web_prepare_content')
                    ->where('web_prepare_content.prepare_id', $id)
                    ->get();
        if($query->num_rows()>0){
           return $query->row_array();
        }else{
            return false;
        }
    }
    //------------------------------------------------
    /**
	*This function 'll update how_to_prepare details by id
	*
	* @access public
	* @params prepare_id
	* @return integer
	* @author Seethal
	*/
    function how_to_prepare_edit($data,$id)
    {
        $this->db->where('prepare_id',$id);
		$query	= $this->db->update('web_prepare_content',$data);
		$return	=	true;
		if(!$query){
			$return	=	false;
		}
		return  $return;
    }
    //------------------------------------------------
    /**
	*This function 'll delete how_to_prepare details by id
	*
	* @access public
	* @params prepare_id
	* @return integer
	* @author Seethal
	*/
    public function how_to_prepare_delete($id)
    {
        $this->db->where('prepare_id', $id);
        $query=$this->db->delete('web_prepare_content');
        $return	=	true;
		if(!$query){
			$return	=	false;
		}
		return $return;
    }
    //------------------------------------------------
    /**
	*This function 'll get how_to_prepare details by id
	*
	* @access public
	* @params prepare_id 
	* @return integer
	* @author Seethal
	*/
    function get_how_to_prepare_by_id($prepare_id)
    {
		$this->db->select('*');
		$this->db->where('prepare_id',$prepare_id);
        $query	=	$this->db->get('web_prepare_content');
        $resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr; 

    }

    public function is_results_exist($hall_tkt,$rank)
    {
        $query= $this->db->get_where('web_results',array("hall_tkt"=>$hall_tkt,"rank"=>$rank));
        if($query->num_rows()>0)
        {
           return true;
        }
        else
        {
            return false;
        }

    }

    // function add_main_account_entry($data){
    //     $this->db->insert('accounting_entry', $data);
    //     return $this->db->insert_id();
    // }


    //-------------------------Category----------------------------------------------------
    function get_category(){
        return $this->db->select('*')->order_by("id", "desc")->get('web_category')->result();
    }
    function get_category_id($id)
    {
		$this->db->select('*');
		$this->db->where('id',$id);
		$query	=	$this->db->get('web_category');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();
		}
		return $resultArr;
    }    
    public function change_category_status($id,$status)
    { 
		if($status == 0){
			$this->db->where('id', $id);
			$query=$this->db->update('web_category',array("status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('id', $id);
			$query=$this->db->update('web_category',array("status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
    }
    public function edit_howtoprepare_status($id,$status)
    { 
		if($status == 0){
			$this->db->where('prepare_id', $id);
			$query=$this->db->update('web_prepare_content',array("prepare_status"=> 1));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}else{
			$this->db->where('prepare_id', $id);
			$query=$this->db->update('web_prepare_content',array("prepare_status"=> 0));		
			if($query){
				return 1; 
			}else{
				return 0;
			}  
		}
    }
    function categoryCheckassign($id)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('category_id',$id);
        $this->db->where('prepare_status',1);
		$query	=	$this->db->get('web_prepare_content');
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
        $this->db->select('*');
        $this->db->where('category_id',$id);
        $this->db->where('status',1);
        $query	=	$this->db->get('web_general_studies');
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
		}
		return $f;
    }    
    function checkDuplication($school_id,$category_id)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('category_id',$category_id);
		$query	=	$this->db->get('web_prepare_content');
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
		return $f;
    }    
    function checkDuplication_edit($school_id,$category_id,$id)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('prepare_id !=',$id);
        $query	=	$this->db->get('web_prepare_content');
        // echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
		return $f;
    }    
    function checkDuplicationGS($school_id,$category_id,$type)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('type',$type);
        $query	=	$this->db->get('web_general_studies');
        // echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
		return $f;
    }  
    function checkDuplicationprevious_question_and_syllabus($school_id,$category_id,$type)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('status',1);
        $this->db->where('type',$type);
        $query	=	$this->db->get('web_general_studies');
        // echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
		return $f;
    }  
    function checkDuplicationGSEdit($school_id,$type,$id)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('type',$type);
        $this->db->where('id !=',$id);
        $query	=	$this->db->get('web_general_studies');
        // echo $this->db->last_query(); exit;
		if($query->num_rows() > 1){
            $f = 0;
            return $f;
        }
		return $f;
    }      
    function checkDuplicationprevious_question_and_syllabusEdit($school_id,$category_id,$type,$id)
    {
        $f = 1;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('status',1);
        $this->db->where('type',$type);
        $this->db->where('id !=',$id);
        $query	=	$this->db->get('web_general_studies');
        // echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
            $f = 0;
            return $f;
        }
		return $f;
    }      
    function checkDuplicationprevious_question_and_syllabus_status($id = NULL, $school_id = NULL, $category_id = NULL, $type = NULL)
    {
        $f = 0;
		$this->db->select('*');
        $this->db->where('school_id',$school_id);
        $this->db->where('category_id',$category_id);
        $this->db->where('status',1);
        $this->db->where('type',$type);
        $this->db->where('id !=',$id);
        $query	=	$this->db->get('web_general_studies');
        // echo $this->db- >last_query(); exit;
		if($query->num_rows() > 0){
            $f = 1;
            return $f;
        }
		return $f;
    }  
}
