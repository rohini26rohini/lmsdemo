<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_settings extends Direction_Controller {

   public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="basic_configuration";
        //check_backoffice_permission($module);
    }

     public function index()
     {
        // echo "jkhsadj";
         check_backoffice_permission('config_settings');
        $this->data['page']           ="admin/config_settings";
		$this->data['menu']           ="basic_configuration";
        $this->data['breadcrumb']     ="Config Settings";
        $this->data['menu_item']      ="config-settings";
		$this->load->view('admin/layouts/_master',$this->data); 
     }
    public function add_config_settings()
    {
        
        if($_POST)
        {
            $register_mail=$this->input->post('register_mail');
            $payment_mail=$this->input->post('payment_mail');
            $callback_mail=$this->input->post('callback_mail');
            $bcnotify=$this->input->post('bcnotify');
            $bcnotifysms=$this->input->post('bcnotifysms');
            $gst=$this->input->post('gst');
            $sgst=$this->input->post('sgst');
            $cess=$this->input->post('cess');
            $material_upload=$this->input->post('material_upload');
            $companyRegistration=$this->input->post('crn');
            $companyGstCode=$this->input->post('gstc');
            if(!$cess) {
                $cess = 0;
            }
            if(!$material_upload) {
                $material_upload = 0;
            }
            $cessvalue=$this->input->post('cessvalue');
			$config				=	$this->home_model->get_config();
            $data = array(
                           array(
                              'key' => 'register_mail' ,
                              'value' => $register_mail,
                               ),
                            array(
                              'key' => 'payment_mail' ,
                              'value' => $payment_mail ,
                               ),
                            array(
                              'key' => 'callback_mail' ,
                              'value' => $callback_mail ,
                               ),
                            array(
                               'key' => 'bcnotify' ,
                               'value' => $bcnotify ,
                                ),
                            array(
                                'key' => 'bcnotifysms' ,
                                'value' => $bcnotifysms ,
                                ),    
                            array(
                              'key' => 'CGST' ,
                              'value' => $gst,
                               ),
                            array(
                              'key' => 'SGST' ,
                              'value' => $sgst,
                               ),
                            array(
                                'key' => 'cess' ,
                                'value' => $cess,
                                 ),
                            array(
                                'key' => 'cess_value' ,
                                'value' => $cessvalue,
                                 ),
                            array(
                                'key' => 'company_registration' ,
                                'value' => $companyRegistration,
                                ),
                            array(
                                'key' => 'company_gst_code' ,
                                'value' => $companyGstCode,
                            ),
                            array(
                                'key' => 'material_upload' ,
                                'value' => $material_upload,
                                )
                                 

                        );

            
            $exist=$this->common->check_if_dataExist('am_config',array("key"=>"register_mail","key"=>"payment_mail","key"=>"callback_mail","key"=>"gst","key"=>"sgst","key"=>"cess","key"=>"cess_value","key"=>"bcnotify","key"=>"bcnotifysms"));
           // echo $exist;
           if($exist == 0)
           {
               
               $response  = $this->Config_settings_model->insert_config($data);
               if($response == 1)
               {
                   $ajax_response['st']=1;
                   $ajax_response['msg']="Data successfully added!"; 
               }
               else
               {
                  $ajax_response['st']=0;
                  $ajax_response['msg']="Something went wrong,Please try again later..!";  
               }
              
           }
            else
            {   
				if($config['SGST']!=$sgst || $config['CGST']!=$gst) {
					$centerCourse = $this->common->get_from_tableresult('am_institute_course_mapping', array('status'=>1));
					foreach($centerCourse as $course) {
						$studentCourse = $this->common->get_from_tableresult('am_student_course_mapping', array('institute_course_mapping_id'=>$course->institute_course_mapping_id));
						if(empty($studentCourse)) {
							$taxconfig['SGST'] = $sgst;
							$taxconfig['CGST'] = $gst;
							//$fee['course_tuitionfee'] 	= $course->course_tuitionfee;
							$congigval = taxcalculation($course->course_tuitionfee, $taxconfig, 0); 
							$fee['course_totalfee'] 	= $congigval['totalAmt'];
							$fee['course_sgst'] 		= $congigval['sgst'];
							$fee['course_cgst'] 		= $congigval['cgst'];
							$fee['cgst'] 				= $gst;
							$fee['sgst'] 				= $sgst;
							$this->db->where('institute_course_mapping_id', $course->institute_course_mapping_id);
							$this->db->update('am_institute_course_mapping', $fee);
						}
					}
				} 
                $response  = $this->Config_settings_model->update_config($data);
               if($response ==1)
               {
                   $ajax_response['st']=1;
                   $ajax_response['msg']="Successfully updated..!";
                   $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                   $json = json_encode($data);
                   logcreator('insert', 'database', $who, $json, '1 ', 'am_config', 'Config setting updated');
               }
               else
               {
                    $ajax_response['st']=1;
                   $ajax_response['msg']="No changes made..!";  
                   $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                   $json = json_encode($data);
                   logcreator('insert', 'database', $who, $json, '1 ', 'am_config', 'Config setting updation triggered, No changes updated');
               }
            }
            
        }
        else
        {
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                   $json = json_encode($data);
                   logcreator('insert', 'database', $who, $json, 'config setting ', 'am_config', 'Config setting updation failed');
        }
        print_r(json_encode($ajax_response));
    }


public function invoice_migration() {
    $this->db->select('*');
    $query = $this->db->get('pp_student_payment');
    if($query->num_rows() > 0){
        $payments = $query->result();
        foreach($payments as $payment) { 
            if($payment->payment_type = 'installment') { //echo '<pre>'; print_r($payment);
                $this->db->select('*');
                $this->db->where('payment_id', $payment->payment_id);
                $query = $this->db->get('pp_student_payment_installment');
                if($query->num_rows() > 0){
                    $installments = $query->result();
                    foreach($installments as $installment) { //print_r($installment);
                    $this->common->invoice($payment->payment_id, $installment->installment, $installment->installment_paid_amount, $installment->installment_amount);
                    }
                }
            } else {
                $coursefee = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$payment->institute_course_mapping_id));
                $this->common->invoice($payment->payment_id, Null, $payment->paid_amount, $coursefee['course_tuitionfee']);
            }

        }
    }
}


}
?>