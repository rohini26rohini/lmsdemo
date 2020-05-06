<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_success extends Direction_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
    $this->load->model('home_model');
    $this->load->helper('ccavenue_crypto');
  }

public function index() { 
    $this->load->helper('url');
    $this->load->helper('ccavenue_crypto');
    //print_r($_POST); 
    $workingKey = WORKING_KEY; // Working Key should be provided here.
    $encResponse = $_POST ["encResp"]; // This is the response sent by the CCAvenue Server
    $order_id = $_POST['orderNo'];
    $rcvdString = decrypt($encResponse, $workingKey); // Crypto Decryption used as per the specified working key.
    $order_status = "";
    $orderResultArray = array();
    $decryptValues = explode('&', $rcvdString);
    $dataSize = sizeof($decryptValues);
    for ($i = 0; $i < $dataSize; $i ++) {
        $information = explode('=', $decryptValues [$i]);
        if ($i == 3) {
            $order_status = $information [1];
        }
        $orderResultArray [$information [0]] = $information [1];
    }
    $student_id = $orderResultArray['billing_zip'];
    $institute_course_mapping_id = $orderResultArray['merchant_param2'];
    $datastring = explode('-',$orderResultArray['merchant_param1']);
    $amtwithoutgst = $datastring[0];
    $discount = $datastring[1];
    $this->data['respone'] = $orderResultArray;
    $order_status = $orderResultArray['order_status'];
    $dataArr['statustxt'] = $order_status;
    $dataArr['responsedata'] = json_encode($orderResultArray);
    $dataArr['status_message'] = $orderResultArray['status_message'];
    $dataArr['transaction_id'] = $orderResultArray['tracking_id'];
    $payment_type = $orderResultArray['merchant_param4'];
    $payfrom = $orderResultArray['merchant_param5'];
    $this->data['payfrom'] = $payfrom;
    $batch_fee = $this->student_model->get_batchfee_bystudent_id($student_id, $institute_course_mapping_id); //print_r($batch_fee);
    $batch_id = $batch_fee->batch_id;
    $statusflag = 0;
    $paid_amount = $orderResultArray['merchant_param3'];
    if($order_status=='Success') {
      $dataArr['status'] = 1;
      $this->db->where('id', $order_id);
      $this->db->update('pp_onlinepayment_approval', $dataArr);
      $statusflag = 1;
      if($payfrom=='frontend') {
        if($payment_type == 'installment'){ 
          $installment = [];
          $installment_amt = [];
          $installment_id = [];
          $orderArr = $this->common->get_from_tablerow('pp_onlinepayment_approval', array('id'=>$order_id)); 
          if(!empty($orderArr) && $orderArr['postdata']!='') {
              $postdata = json_decode($orderArr['postdata']);
          }
          $installment = $postdata->installment; 
          $installment_amt = $postdata->installment_amt; 
          $installment_amtgst = $postdata->installment_amtgst; 
          $payable_amount = $batch_fee->course_totalfee-$discount;
          $discount_applied = $discount;
          $balance = $payable_amount-$paid_amount;
          $data = array('student_id'=>$student_id,
                    'batch_id'=>$batch_id,
                    'institute_course_mapping_id'=>$institute_course_mapping_id,      
                    'payment_type'=>$payment_type,
                     'total_amount'=>$batch_fee->course_totalfee,      
                    'payable_amount'=>$payable_amount,
                     'discount_applied'=>$discount_applied,      
                    'paid_amount'=>$paid_amount,
                    'balance'=>$balance,
                    'paymentmode'=>'Online',
                    'card_holder_name'=>$orderResultArray['billing_name'],
                    'card_type'=>$orderResultArray['payment_mode'],
                    'bank_name'=>$orderResultArray['card_name'],
                    'transaction_id'=>$orderResultArray['tracking_id'],
                    'status'=>1
                   ); 
          $query        =    $this->student_model->update_student_fee($data);
            if($query) {
                $this->loginapprovalprocess($student_id, $batch_id);
            }
          $paidamt = 0;   
          $disntloop = 0;
          $balaceinstall = 0;
          $lastid = '';
          $installwithoutgst = 0;
      foreach($installment as $key=>$val) {
          $install = array('paid_payment_mode'=>'Online',
                           'installment'=>$val,
                           'installment_paid_amount'=>$installment_amtgst[$key],
                           'installment_amount'=>$installment_amtgst[$key],
                            'installment_amount_withtax'=>$paid_amount,
                            'installment_amount_balance'=>0,
                            'card_holder_name'=>$orderResultArray['billing_name'],
                            'card_type'=>$orderResultArray['payment_mode'],
                            'bank_name'=>$orderResultArray['card_name'], 
                            'transaction_id'=>$orderResultArray['tracking_id'],
                           'payment_id'=>$query
                          ); 
          $this->db->insert('pp_student_payment_installment',$install);
          $lastid .= $val.'-';
          $discount_applied = 0;
          $disntloop++;
      }   
      if($query) {
          $this->common->invoice($query, $lastid, $paid_amount, $amtwithoutgst);
      }
      } else {
        $payable_amount = $batch_fee->course_totalfee-$discount;
        $discount_applied = $discount;
        $balance = $payable_amount-$paid_amount;
        $data = array('student_id'=>$student_id,
                      'batch_id'=>$batch_id,
                      'institute_course_mapping_id'=>$institute_course_mapping_id, 
                      'payment_type'=>$payment_type,
                      'payable_amt_without_gst'=>$amtwithoutgst,
                      'total_amount'=>$batch_fee->course_totalfee, 
                      'payable_amount'=>$payable_amount,
                      'discount_applied'=>$discount_applied,
                      'paid_amount'=>$paid_amount,
                      'balance'=>$balance,
                      'paymentmode'=>'Online',
                      'card_holder_name'=>$orderResultArray['billing_name'],
                      'card_type'=>$orderResultArray['payment_mode'],
                      'bank_name'=>$orderResultArray['card_name'],
                      'transaction_id'=>$orderResultArray['tracking_id'],
                      'status'=>1
                     );
            $query        =    $this->student_model->update_student_fee($data); 
            if($query) {
                  $this->common->invoice($query,'',$paid_amount,$amtwithoutgst);  
                  $this->loginapprovalprocess($student_id, $batch_id);
              }
      }


      } else {
        $installment = [];
        $installment_amt = [];
        $installment_id = [];
        $orderArr = $this->common->get_from_tablerow('pp_onlinepayment_approval', array('id'=>$order_id)); 
        if(!empty($orderArr) && $orderArr['postdata']!='') {
            $postdata = json_decode($orderArr['postdata']);
        }
        $payment_id = $postdata->payment_id;
        $paidArr = $this->common->get_from_tablerow('pp_student_payment', array('payment_id', $payment_id));
        $balance = $paidArr->balance-$paid_amount;
        $discount_applied = $discount;
        if($payment_type == 'installment'){ 
          $installment = $postdata->installment; 
          $installment_amt = $postdata->installment_amt; 
          $installment_id = $postdata->installment_id;  
          $data = array(
            'paid_amount'=>$paid_amount,
            'balance'=>$balance,
            'discount_applied'=>$discount_applied, 
            'paymentmode'=>'Online'
           );
          $query        =    $this->student_model->update_student_feeinstallment($data, $payment_id);
          $paidamt = 0;   
            $disntloop = 0;
            $balaceinstall = 0;
            $lastid = '';
            $installwithoutgst = 0;
        foreach($installment as $key=>$val) {
            $install = array('paid_payment_mode'=>'Online',
                             'installment'=>$val,
                             'installment_paid_amount'=>$paid_amount,
                             'installment_amount'=>$installment_amt[$key],
                              'installment_amount_withtax'=>$paid_amount,
                              'installment_amount_balance'=>0,
                              'card_holder_name'=>$orderResultArray['billing_name'],
                              'card_type'=>$orderResultArray['payment_mode'],
                              'bank_name'=>$orderResultArray['card_name'], 
                              'transaction_id'=>$orderResultArray['tracking_id'],
                             'payment_id'=>$payment_id
                            ); 
            $this->db->insert('pp_student_payment_installment',$install);
            $lastid .= $val.'-';
            $installwithoutgst += $installment_amt[$key];
            $discount_applied = 0;
            $disntloop++;
        }   
        if($query) {
            $this->common->invoice($payment_id, $lastid, $paid_amount, $installwithoutgst);
        }
        } else {
          $paidRow = $this->common->get_from_tablerow('pp_student_payment', array('payment_id'=>$payment_id));
                if(!empty($paidRow)) {
                $balance = 0;
                $paidamt = $paidRow['paid_amount'];
                $newpaidamt = $paidamt+$paid_amount;
                $data = array(  
                      'paid_amount'=>$newpaidamt,
                      'balance'=>$balance
                );
                $this->db->where('payment_id', $payment_id);
                $query        =    $this->db->update('pp_student_payment', $data);
                if($query) {
                    $splitArr = array('payment_id'=>$payment_id,
                                      'paid_payment_mode'=>'Online',
                                      'split_amount'=>$paid_amount,
                                      'split_balance'=>$balance,
                                      'card_holder_name'=>$orderResultArray['billing_name'],
                                      'card_type'=>$orderResultArray['payment_mode'],
                                      'bank_name'=>$orderResultArray['card_name'], 
                                      'transaction_id'=>$orderResultArray['tracking_id'],
                                  );
                    $this->db->insert('pp_student_payment_split', $splitArr); 
                    $split_id = $this->db->insert_id();
                    $invoice_id = $this->common->invoice($query,'', $paid_amount, $paid_amount); 
                    $this->db->where('paid_split_id', $split_id);
                    $this->db->update('pp_student_payment_split', array('pt_invoice_id'=>$invoice_id)); 
                }
                }
        }
      }
    } else {
    if($order_status=='Aborted') {
      $statusflag = 0;
      $dataArr['status'] = 2;
    } else if($order_status=='Failure') {
      $statusflag = 0;
      $dataArr['status'] = 3;  
    } else {
      $statusflag = 0;
      $dataArr['status'] = 4; 
    }
    $this->db->where('id', $order_id);
    $this->db->update('pp_onlinepayment_approval', $dataArr);

  }
  $this->data['statusflag']   = $statusflag;
  $this->data['order_status'] = $order_status;
  $this->data['amount'] = $orderResultArray['amount'];
  $this->data['tracking_id'] = $orderResultArray['tracking_id'];
  if($statusflag == 1) { 
    $this->load->view('home/transaction_success', $this->data);
  } else { 
    $this->load->view('home/transaction_aborted_status', $this->data);
  }

}


    /*
    *   function'll update all status for student login 
    *   @params post array
    *   @author GBS-R
    */
    public function loginapprovalprocess($student_id, $batch_id) {
      //am_user table update
       $student            = $this->user_model->get_student_data_by_id($student_id); 
       $password           = mt_rand(100000,999999);
       $encrypted_password = $this->Auth_model->get_hash($password);
       $dataArr            = array(
       //'user_username'=>$student->registration_number,
       //'user_name'=>$student->name,
       // "registration_number"=>$student->registration_number,
       //'user_emailid'=>$student->email,
       'user_role'=>'student',
       'user_status'=>1,
       //'user_phone'=>$student->contact_number,
       'user_passwordhash'=>$encrypted_password
      );
       if($student->caller_id!='') {
           $this->db->where('call_id',$student->caller_id);
           $this->db->update('cc_call_center_enquiries',array('call_status'=>6));  
       }
       $this->db->where('user_username',$student->registration_number);
       $this->db->where('user_primary_id',$student_id);
       $this->db->update('am_users',$dataArr);
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
       $query = $this->db->update('am_students', $update);
       
       // Hostel allocation
       $where = array('student_id'=>$student_id);
       $this->db->where($where);
       $update = array('status'=>'alloted');
       $hostel = $this->db->update('hl_room_booking', $update);
   
       if($query)
       {
       $this->gm_user_registration($student->registration_number, $password, $student_id);
       // $num=$this->data['userid'];
       // $num=$student;
       // $type="Registration";
       // $email=$this->session->userdata('email');
       // $data=email_header();

         

       $username= $student->registration_number;
       $name= $student->name;
       // $num= $this->data['userid'];
       $type=" Registration";
       $email=$student->email;
       $data = email_header();
       $data.='<tr style="background:#f2f2f2">
               <td style="padding: 20px 0px">
                   <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$name.'</h3>
                   <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The admission process is completed. Now you can login to our website application using following credential.</p>
                   <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$username.'</p>
                   <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>
                   <br><a href="'.base_url('login').'">Click here to login</a> and view your Course details and schedule details
                   </p>
               </td>
           </tr>';
       $data.=email_footer();
       // <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The admission process is completed. Know you can login to our website application using following credential. <p>Your username is <b>'.$username.'</b> and the password is<b>'.$password.'</b></p>

       $this->send_email($type,$email,$data);

      // NOTIFY BATCH FULL    
      $batchnotify = $this->common->get_batch_allocation($batch_id);
      if($batchnotify['status']!=0) {
          $this->sendbatchnotification($batchnotify);
      }    
      // ENDS       

       }
}

    
/*
*   function'll insert user for exam application
*   @params username, password, student id
*   @author GBS-R
*
*/
    
public function gm_user_registration($username = NULL, $password = NULL, $userId = NULL) {
  // Authentication Api call
  $postdata['grant_type'] 		= 'password'; 
  $postdata['username'] 		= 'gm_admin'; 
  $postdata['password'] 		= 'password';
  $postdata['scope'] 		    = 'read write trust'; 
  $jsonData['method']           = "oauth/token?grant_type=password&username=gm_admin&password=password&client_id=grandmaster-client&client_secret=grandmaster-secret&scope=read+write+trust";
  $jsonData['type'] = "POST"; 
  $jsonData['data'] = array();
  $ajaxResponse = json_decode($this->common->rest_api_auth($jsonData)); 
// User insert api cal  
  $data['id'] 		        = $userId;
  $data['password'] 		= $password; 
  $data['userName'] 		= $username;  
  $data['role']['id'] 		= 2;  
  $jsonData['access_token'] = $ajaxResponse->access_token; 
  $jsonData['method']       = "createOrUpdateUser";
  $jsonData['type']         = "POST"; 
  $jsonData['data']         = json_encode($data); 
  $ajaxResponse = json_decode($this->common->rest_api_call($jsonData));    
}

function send_email($type, $email, $data) {

  $this->email->to($email);
  $this->email->subject($type);
  $this->email->message($data);
  $this->email->send();
}



public function sendbatchnotification($batchnotify = NULL) { 
  $vecantseats    = $batchnotify['batch_capacity']-$batchnotify['student_registered']; 
  $center_id      = $batchnotify['center'];
  $branch_id      = $batchnotify['branch']; 
  $branch_name    = '';
  $headsArr       = [];
  $headsmobArr    = [];
  $center_name    = '';
  if($center_id>0) {
      $branch         = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$branch_id)); //print_r($branch);
      if(!empty($branch)) {
          $branch_name =   $branch['institute_name'];
      }
      $centerheads = $this->student_model->staff_centre_branch($center_id); //('am_staff_personal', array('center'=>$center_id,'role'=>'centerhead'));
      if(!empty($centerheads)) {
          foreach($centerheads as $head) {
              array_push($headsArr, $head->email);  
              array_push($headsmobArr, $head->mobile); 
              $center_name =  $head->institute_name; 
          }
      }
  } 
  $type=$batchnotify['batch_name']." Batch status alert";
  if(!empty($batchnotify) && $batchnotify['status']==90){
      $config				=	$this->home_model->get_config(); 
      if(!empty($config)) {
      $emailArr = explode(',', $config['bcnotify']);
      if(!empty(array_filter($emailArr))) {
        $newArr = array_merge($emailArr, $headsArr);
      foreach($newArr as $email) {
      $data = email_header();
      $data.='<tr style="background:#f2f2f2">
              <td style="padding: 20px 0px">
                  <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear </h3>
                  <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">90% of students admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.</p>
                  <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total Seats            : '.$batchnotify['batch_capacity'].'</p>
                  <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total student admitted : '.$batchnotify['student_registered'].'</p>
                  <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Vacant seats           : '.$vecantseats.'</p>
              </td>
          </tr>';
      $data.=email_footer();
      $this->send_email($type,$email,$data);
      }
  }
  $smsArr = explode(',', $config['bcnotifysms']);
  if(!empty(array_filter($smsArr))) {
      $smsnewArr = array_merge($smsArr, $headsmobArr);
      foreach($smsnewArr as $mob_number) { 
  $message = '90% of student admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.';
  send_sms($mob_number,$message);
      }
  }
  }
  } else if(!empty($batchnotify) && $batchnotify['status']==100){
      $config				=	$this->home_model->get_config(); 
      if(!empty($config)) {
      $emailArr = explode(',', $config['bcnotify']);
      if(!empty(array_filter($emailArr))) {
          $newArr = array_merge($emailArr, $headsArr);
      foreach($newArr as $email) {
      $data = email_header();
      $data.='<tr style="background:#f2f2f2">
          <td style="padding: 20px 0px">
          <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Details </h3>
          <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">100% of students admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.</p>
          <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total Seats            : '.$batchnotify['batch_capacity'].'</p>
          <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total student admitted : '.$batchnotify['student_registered'].'</p>
          <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Vacant seats           : '.$vecantseats.'</p>
      </td>
      </tr>';
      $data.=email_footer();
      $this->send_email($type,$email,$data);
      }
  }
  $smsArr = explode(',', $config['bcnotifysms']);
  if(!empty(array_filter($smsArr))) {
      $smsnewArr = array_merge($smsArr, $headsmobArr);
      foreach($smsnewArr as $mob_number) { 
  $message = '100% of student admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.';
  send_sms($mob_number,$message);
      }
  }
}
  }
}




}