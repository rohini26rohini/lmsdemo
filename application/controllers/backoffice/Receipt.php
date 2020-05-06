<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        // $module="students";
        // check_backoffice_permission($module);
    }

    public function index(){
        // check_backoffice_permission("manage_students");
        $this->data['page']="admin/student_reseipt_view";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Student Receipt";
        $this->data['menu_item']="backoffice/manage-students";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function download_receipt($id = NULL, $institute_course_mapping_id = NULL, $paid_install_id = NULL, $payment_id = NULL){
        $this->data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
        $this->data['studentcard']  = $this->student_model->get_student_card_details($id);
        $this->data['batchbranch']  = $this->student_model->get_batchbranch_details($id, $institute_course_mapping_id);
        // echo '<pre>';
        // print_r($this->data['batchbranch']);
        // die();
        // $this->db->where('student_id', $data['studentArr']['student_id']);
        // $this->db->update('am_students', array('idcard_status'=> 1));
        $this->data['feeheads']= $this->common->get_feedsmapping($institute_course_mapping_id); 
        if($paid_install_id>0) {
            $this->data['feespaid']= $this->common->receipt_paid_installment($paid_install_id); 
            // show($this->data['feespaid']);
        } else {
            $this->data['feespaid']= $this->common->receipt_paid_ontime($payment_id);     
        }
        $this->data['studRrstno'] = $this->common->get_name_by_id('am_students','registration_number',array("student_id"=>$id));
        $html = $this->load->view('admin/pdf/student_receipt',$this->data,TRUE);//echo '<pre>';echo $html; die();
        $file = 'invoice.pdf';
        $filepath = FCPATH.'uploads/student_receipt/'.$file;
        $url = base_url('uploads/student_receipt/'.$file);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html); 
        $pdf->Output($filepath, "F");
        $returndata['st']=1;
        $returndata['url']=$url;
        print_r(json_encode($returndata));
    }


    public function download_splitreceipt($id = NULL, $institute_course_mapping_id = NULL, $paid_install_id = NULL, $payment_id = NULL, $split_id = NULL){
        $this->data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
        $this->data['studentcard']  = $this->student_model->get_student_card_details($id);
        $this->data['batchbranch']  = $this->student_model->get_batchbranch_details($id, $institute_course_mapping_id);
        $this->data['feeheads']= $this->common->get_feedsmapping($institute_course_mapping_id); 
        if($paid_install_id>0) {
        $this->data['feespaid']= $this->common->receipt_paid_installment($paid_install_id); 
        } else {
            $this->data['feespaid']= $this->common->receipt_paid_ontime($payment_id);     
        }
        $this->data['split'] = $this->common->get_from_tablerow('pp_student_payment_split', array('paid_split_id'=>$split_id));
        $this->data['studRrstno'] = $this->common->get_name_by_id('am_students','registration_number',array("student_id"=>$id));
        $html = $this->load->view('admin/pdf/student_splitreceipt',$this->data,TRUE); //echo '<pre>';echo $html; die();
        $file = 'invoice_'.$split_id.'.pdf';
        $filepath = FCPATH.'uploads/student_receipt/'.$file;
        $url = base_url('uploads/student_receipt/'.$file);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html); 
        $pdf->Output($filepath, "F");
        $returndata['st']=1;
        $returndata['url']=$url;
        print_r(json_encode($returndata));
    }


    public function download_trans_receipt($id = NULL,  $inv_id = NULL, $pay_id = NULL){
        $this->data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
        $this->data['studentcard']  = $this->student_model->get_student_card_details($id);
        $this->data['invoice_id'] = $inv_id;
        // echo '<pre>';
        // print_r($data['studentcard']);
        // die();
        // $this->db->where('student_id', $data['studentArr']['student_id']);
        // $this->db->update('am_students', array('idcard_status'=> 1));
        //$this->data['feeheads']= $this->common->get_feedsmapping($institute_course_mapping_id); 
        $this->data['feespaid']= $this->common->receipt_paid_trans($id, $pay_id, $inv_id); 
        $html = $this->load->view('admin/pdf/student_trans_receipt',$this->data,TRUE);//echo '<pre>';echo $html; die();
        $file = 'trans_invoice.pdf';
        $filepath = FCPATH.'uploads/student_receipt/'.$file;
        $url = base_url('uploads/student_receipt/'.$file);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html); 
        $pdf->Output($filepath, "F");
        $returndata['st']=1;
        $returndata['url']=$url;
        print_r(json_encode($returndata));
    }

    public function download_hostel_receipt($id = NULL,$inv_id = NULL){
        $this->data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
        $this->data['studentcard']  = $this->student_model->get_student_card_details($id);
        $this->data['invoice_id'] = $inv_id;
        $this->data['feespaid']= $this->Hostel_model->get_invoice_payments($inv_id); 
        $html = $this->load->view('admin/pdf/student_hostel_receipt',$this->data,TRUE);
        $file = 'hostel_invoice.pdf';
        $filepath = FCPATH.'uploads/student_receipt/'.$file;
        $url = base_url('uploads/student_receipt/'.$file);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html); 
        $pdf->Output($filepath, "F");
        $returndata['st']=1;
        $returndata['url']=$url;
        print_r(json_encode($returndata));
    }
}
?>
