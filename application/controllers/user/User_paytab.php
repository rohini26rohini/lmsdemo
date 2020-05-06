<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Direction_Controller {
  public function __construct() {
    parent::__construct();
    //check_backoffice_permission();
  }

/*
*   online payment view
*   @params student id
*   @author GBS-R
*/
    
public function online_fee_payment()
{
    $student_id = $this->session->userdata('user_id');
    $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
    $fee      = $this->user_model->get_coursefee($student_id);
    $batch_id = $fee->batch_id;
    $batchdetails = $this->common->get_batch_details($batch_id);
    $registeredstudent = $this->common->get_total_student($batch_id);
    $availableseats = $batchdetails['batch_capacity'];
    if(!empty($batchdetails)) {
    $availableseats = $batchdetails['batch_capacity']-$registeredstudent;
    }
    if($availableseats>0) {
      $this->data['seats']   = 'available';
    } else {
      $this->data['seats']   = 'unavailable'; 
    } 
    $this->data['hostel']   = $this->common->get_hostelFee_byStudentId($student_id);
    $this->data['transport']= $this->common->get_fare_by_student($student_id); 
    $discount = $this->common->get_student_discount_details($fee->student_id, $fee->course_id);
    if(!empty($discount)) {
                $dicountper = 0;
                $dicntAmt   = 0;
                $course_totalfee = $fee->course_totalfee;
                foreach($discount as $disnt) {
                    if($disnt->st_discount_type==2) {
                        $dicountper  =  $disnt->st_discount*$course_totalfee;
                        $dicntAmt    = $dicountper/100;
                    } else {
                        $dicntAmt    =  $disnt->st_discount;
                    }
                    $this->student_model->update_discount($dicntAmt,$disnt->st_discount_id);
                }
            }
    $this->data['fee']      = $fee;
    $this->data['viewload'] = 'user/online_payment_view';
    $this->load->view('_layouts/_master', $this->data); 
}    
  
/*
*   function'll get online payment
*   @params post array    
*   @author GBS-R
*/

    
function payment_update() {
            $student_id = $this->session->userdata('user_id');
            $amount     = $this->input->post('paidamount');
            $discount   = $this->input->post('discount');
            $student    = $this->user_model->get_student_data_by_id($student_id); 
            $batch      = $this->user_model->get_coursefee($student_id);
            $payparams['customer'] 			=  $student->name;
			$payparams['user_id'] 			=  $student_id;
            $payparams['amount'] 		    =  $amount;
			$payparams['reference_no'] 		=  $student_id.'-'.$batch->institute_course_mapping_id.'-'.$batch->batch_id.'-'.$discount;
			$payparams['email'] 			=  $student->email;
			if($student->contact_number) {
				$payparams['phone_number'] 	=  $student->contact_number;
			} else {
				$payparams['phone_number'] 	=  $student->mobile_number;
			}
			$payparams['billing_address'] 	=  $student->address;
			if($student->districtname!='') {
			$payparams['city'] 				=  $student->districtname;
			} else {
			$payparams['city'] 				=  'city';	
			}
			if($student->statename!='') {
			$payparams['state'] 			=  $student->statename;
			} else {
			$payparams['state'] 			=  'state';	
			}
			$payparams['postal_code'] 		=  '123456';
			$payparams['country'] 			=  'ARE';//$userData->contactInformation->country;
			$payparams['address_shipping'] 	=  $student->address;
			if($student->districtname!='') {
			$payparams['city_shipping'] 	=  $student->districtname;
			} else {
			$payparams['city_shipping'] 	=  'city';	
			}
			if($student->statename!='') {
			$payparams['state_shipping'] 	=  $student->statename;
			} else {
			$payparams['state_shipping'] 	=  'state';
			}
			$payparams['postal_code_shipping'] =  '123456';
			$payparams['country_shipping'] 	 =  'ARE';//$userData->contactInformation->country;
			$payparams['cardsaved'] 			=  0;
			$paymentdet = $this->payment->createpay($payparams); //print_r($payparams);die();
            if($paymentdet->response_code==4012) {
                $result = $paymentdet;
            } else {
                $result = false;
            }
            print_r(json_encode($result));
}


public function payment_success() {
    //print_r($_POST);
    //Array ( [payment_reference] => 230755 );stdClass Object ( [result] => The payment is completed successfully! [response_code] => 100 [pt_invoice_id] => 230815 [amount] => 1800 [currency] => AED [reference_no] => 54-5 [transaction_id] => 264872 )
    $this->data['transaction_id'] = 0;
    if(isset($_POST)){
    $payment_reference 		= 	$_REQUEST['payment_reference'];
    if($payment_reference!='') {
    $returnparams 			= 	$this->payment->verify_payment($payment_reference); 
    $this->data['transaction_id'] = $_REQUEST['payment_reference'];
    $discountAmt = 0;    
    if($returnparams->response_code==100) {
        $reference_no = explode('-',$returnparams->reference_no);
        $batch      = $this->user_model->get_coursefee($reference_no[0]);
        if($reference_no[3]==1) {
            $discount = $this->common->get_student_discount_details($batch->student_id, $batch->course_id);
                $discountAmt = 0;    
                if(!empty($discount)) {
                    foreach($discount as $dis) {
                        $discountAmt += $dis->discount_amount;
                    }
                }
        }
        $this->data['status'] = 'COMPLETED';
        $payableAmt = $batch->course_totalfee-$discountAmt;
        $balance    = $batch->course_totalfee-$returnparams->amount;
        $data = array('student_id'=>$reference_no[0],
                      'institute_course_mapping_id'=>$reference_no[1],
                      'batch_id'=>$reference_no[2],
                      'payment_type'=>$batch->course_paymentmethod,
                      'total_amount'=>$batch->course_totalfee,
                      'payable_amount'=>$payableAmt,
                      'discount_applied'=>$discountAmt,
                      'paid_amount'=>$returnparams->amount,
                      'balance'=>$balance,
                      'paymentmode'=>'online',
                      'pt_invoice_id'=>$returnparams->pt_invoice_id,
                      'transaction_id'=>$returnparams->transaction_id,
                      'status'=>1
                     ); 
      $payment_id = $this->student_model->update_student_fee($data);
        if($payment_id!='') {
          if($batch->course_paymentmethod=='installment') {
              $install = array('payment_id'=>$payment_id,
                              'paid_payment_mode'=>'online',
                               'installment'=>1,
                               'installment_paid_amount'=>$returnparams->amount,
                               'installment_amount'=>$returnparams->amount,
                               'pt_invoice_id'=>$returnparams->pt_invoice_id,
                                'transaction_id'=>$returnparams->transaction_id
                              );
              $this->db->insert('pp_student_payment_installment',$install);
          }
             $this->loginapprovalprocess($reference_no[0], $reference_no[2]);
//          $this->db->where('user_primary_id',$reference_no[0]);
//          $this->db->update('am_users',array('user_role'=>'student'));
//          // am_student_course_mapping table update
//            $where = array('student_id'=>$reference_no[0],'batch_id'=>$reference_no[2]);
//            $this->db->where($where);
//            $update = array('status'=>1);
//            $this->db->update('am_student_course_mapping', $update);
//            // am_student table update
//            $where = array('student_id'=>$reference_no[0]);
//            $this->db->where($where);
//            $update = array('status'=>1,'admitted_date'=>date('Y-m-d'));
//            $this->db->update('am_students', $update);
      }    
    } else {
        $this->data['status'] = 'FAILED';
        $reference_no = explode('-',$returnparams->reference_no);
        $batch      = $this->user_model->get_coursefee($reference_no[0]);
        $balance = $batch->course_totalfee-$returnparams->amount;
        $data = array('student_id'=>$reference_no[0],
                     'institute_course_mapping_id'=>$reference_no[1],
                     'batch_id'=>$reference_no[2],
                      'payment_type'=>$batch->course_paymentmethod,
                      'payable_amount'=>$batch->course_totalfee,
                      'discount_applied'=>$discountAmt,
                      'paid_amount'=>$returnparams->amount,
                      'balance'=>$balance,
                      'paymentmode'=>'online',
                      'transaction_id'=>$returnparams->transaction_id,
                      'status'=>2
                     );
      $payment_id = $this->student_model->update_student_fee($data);
       
    }
    } else {
        $this->data['status'] = 'FAILED';
    }
    } else {
        $this->data['status'] = 'FAILED';
    }
    
    $student_id = $this->session->userdata('user_id');
    $this->data['userdata'] = $this->user_model->get_student_data_by_id($student_id);
    $this->data['fee']      = $this->user_model->get_coursefee($student_id);
    $this->data['viewload'] = 'user/online_paymentsuccess_view';
    $this->load->view('_layouts/_master', $this->data);
}    
  
    
    
    /*
    *   function'll update all status for student login 
    *   @params post array
    *   @author GBS-R
    */
    public function loginapprovalprocess($student_id, $batch_id) {
           //am_user table update
            $student    = $this->user_model->get_student_data_by_id($student_id); 
            if($student->caller_id!='') {
                $this->db->where('call_id',$student->caller_id);
                $this->db->update('cc_call_center_enquiries',array('call_status'=>6));  
            }
            $this->db->where('user_primary_id',$student_id);
            $this->db->update('am_users',array('user_role'=>'student','user_status'=>1));
            // am_student_course_mapping table update
            $where = array('student_id'=>$student_id,'batch_id'=>$batch_id);
            $this->db->where($where);
            $this->db->where('status!=', 4);
            $update = array('status'=>1);
            $this->db->update('am_student_course_mapping', $update);
            // am_student table update
            $where = array('student_id'=>$student_id);
            $this->db->where($where);
            $update = array('status'=>1,'admitted_date'=>date('Y-m-d'));
            $this->db->update('am_students', $update);
        
            // Hostel allocation
            $where = array('student_id'=>$student_id);
            $this->db->where($where);
            $update = array('status'=>'alloted');
            $hostel = $this->db->update('hl_room_booking', $update);
    }
    
}
