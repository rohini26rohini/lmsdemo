<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounting_entries {

    function __construct() {
        $this->obj = & get_instance();
        $this->obj->load->model('Account_model');
        $this->userId = $this->obj->session->userdata('user_id');
        $this->languageId = $this->obj->session->userdata('language');
        $this->roleId = $this->obj->session->userdata('role');
    }

    function accountingEntry($data){
        if(isset($data['accountType'])){
            $getAccountHead = $this->obj->Account_model->getAccountHeadInfoFromStaticAccountHead($data['accountType']);
        }else{
            $getAccountHead = $this->obj->Account_model->getAccountHeadInfo($data['head'],$data['table']);
        }
        if(!empty($getAccountHead)){
            $accountEntry = array();
            $accountEntry['date'] = $data['date'];
            if(isset($data['status'])){
                $accountEntry['status'] = $data['status'];
            }
            $accountEntry['account_head'] = $getAccountHead['id'];
            $accountEntry['voucher_type'] = $data['voucher_type'];
            $accountEntry['voucher_no'] = $data['voucher_no'];
            $accountEntry['description'] = $data['description'];
            if($data['type'] == "Credit"){
                $accountEntry['credit_amount'] = $data['amount'];
            }else{
                $accountEntry['debit_amount'] = $data['amount'];
            }
            $entryId = $this->obj->Account_model->add_main_account_entry($accountEntry);
            if($entryId){
                $subEntryData = array();
                if($data['sub_type1'] == ""){
                    $subEntryData['sub_head_id'] = $getAccountHead['id'];
                }else{
                    $getCommonSubHead1 = $this->obj->Account_model->getAccountHeadInfoFromStaticAccountHead($data['sub_type1']);
                    $subEntryData['sub_head_id'] = $getCommonSubHead1['id'];
                }
                $subEntryData['entry_id'] = $entryId;
                $subEntryData['credit'] = $data['amount'];
                $subEntryData['type'] = "To";
                $this->obj->Account_model->add_sub_account_entry($subEntryData);
                $subEntryData = array();
                if($data['sub_type2'] == ""){
                    $subEntryData['sub_head_id'] = $getAccountHead['id'];
                }else{
                    $getCommonSubHead2 = $this->obj->Account_model->getAccountHeadInfoFromStaticAccountHead($data['sub_type2']);
                    $subEntryData['sub_head_id'] = $getCommonSubHead2['id'];
                }
                $subEntryData['entry_id'] = $entryId;
                if(isset($data['amount2'])){
                    $subEntryData['debit'] = $data['amount2'];
                }else{
                    $subEntryData['debit'] = $data['amount'];
                }
                $subEntryData['type'] = "By";
                $this->obj->Account_model->add_sub_account_entry($subEntryData);
                if(isset($data['sub_type3'])){
                    $subEntryData = array();
                    if($data['sub_type3'] == ""){
                        $subEntryData['sub_head_id'] = $getAccountHead['id'];
                    }else{
                        $getCommonSubHead2 = $this->obj->Account_model->getAccountHeadInfoFromStaticAccountHead($data['sub_type3']);
                        $subEntryData['sub_head_id'] = $getCommonSubHead2['id'];
                    }
                    $subEntryData['entry_id'] = $entryId;
                    if(isset($data['amount3'])){
                        $subEntryData['debit'] = $data['amount3'];
                    }else{
                        $subEntryData['debit'] = $data['amount'];
                    }
                    $subEntryData['type'] = "By";
                    $this->obj->Account_model->add_sub_account_entry($subEntryData);
                }
            }
        }
    }

    function update_main_account_entry($updateData,$whereData){
        $this->obj->Account_model->update_main_account_entry($updateData,$whereData);
    }

}
