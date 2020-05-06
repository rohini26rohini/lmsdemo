<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends Direction_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
    $this->load->model('home_model');
    $this->load->helper('ccavenue_crypto');
  }

public function index() { 
    $json = json_encode($_POST);
    $pay['institute_course_mapping_id'] =  $this->input->post('institute_course_mapping_id');
    $pay['student_id'] =  $this->input->post('student_id');
    $paymentmethod =  $this->input->post('paymentmethod');
    $payfrom =  $this->input->post('payfrom');
    $pay['postdata'] =  $json;
    $pay['status'] =  0;
    if($this->input->post('order_id')) {  
    $order_id   = $this->input->post('order_id'); 
    $this->db->where('id', $order_id);
    $this->db->update('pp_onlinepayment_approval', $pay);
    } else {
    $this->db->insert('pp_onlinepayment_approval', $pay);
    $order_id = $this->db->insert_id();
    } 
    if($order_id>0) {
    $student            = $this->user_model->get_student_data_by_id($pay['student_id']); 
    $ccavenueVars ['merchant_id'] = CCAVENUE_MERCHANT_ID;
    $ccavenueVars ['redirect_url'] = CCAVENUE_SUCCESS_URL;
    $ccavenueVars ['cancel_url'] = CCAVENUE_CANCEL_URL;
    $ccavenueVars ['order_id'] = $order_id;
    $ccavenueVars ['amount'] = $this->input->post('paid_amount');
    $ccavenueVars ['language'] = 'English';
    $ccavenueVars ['billing_name'] = $student->name;
    $ccavenueVars ['billing_address'] = $student->address;
    $ccavenueVars ['billing_city'] = $student->districtname;
    $ccavenueVars ['billing_state'] = $student->statename;
    $ccavenueVars ['billing_zip'] = $student->student_id;
    $ccavenueVars ['billing_country'] = 'India';
    $ccavenueVars ['billing_tel'] =$student->contact_number;
    $ccavenueVars ['billing_email'] = $student->email;
    $ccavenueVars ['delivery_name'] = $student->name;
    $ccavenueVars ['delivery_address'] = $student->address;
    $ccavenueVars ['delivery_city'] = $student->districtname;
    $ccavenueVars ['delivery_state'] = $student->statename;
    $ccavenueVars ['delivery_zip'] = $student->student_id;
    $ccavenueVars ['delivery_country'] = 'India';
    $ccavenueVars ['delivery_tel'] = $student->contact_number;
    $ccavenueVars ['merchant_param1'] = $this->input->post('amt').'-'.$this->input->post('discount').'-';
    $ccavenueVars ['merchant_param2'] = $pay['institute_course_mapping_id'];
    $ccavenueVars ['merchant_param3'] = $this->input->post('paid_amount');
    $ccavenueVars ['merchant_param4'] = $paymentmethod;
    $ccavenueVars ['merchant_param5'] = $payfrom;
    $ccavenueVars ['promo_code'] = '';
    $ccavenueVars ['customer_identifier'] = $student->name;
    $ccavenueVars ['currency'] = 'INR';
    $merchant_data = '';
    $working_key = WORKING_KEY; // Shared by CCAVENUES
    $access_code = ACCESS_CODE; // Shared by CCAVENUES
    foreach ($ccavenueVars as $key => $value) {
        $merchant_data .= $key . '=' . $value . '&';
        // echo $key.'='.$value.'<br>';
    }
    // echo $merchant_data;
    $encrypted_data = encrypt($merchant_data, WORKING_KEY); // Method for encrypting the data.
    // echo '<br>Ence<br>'.$encrypted_data;
    // exit();
    $paymentDataArray ['encrypted_data'] = $encrypted_data;
    $paymentDataArray ['access_code'] = ACCESS_CODE;
    // $this->load->view('template/header', $paymentDataArray);
    //die();
    $this->load->view('payinc/ccavenue_checkout_redirect', $paymentDataArray);
} else {
    echo 'Somthing went wrong';
}
    // $this->load->view('template/footer', $paymentDataArray);
  // $this->load->helper('Crypto');
  // show($_POST);
  // include(FCPATH.'application\third_party\Crypto.php');
	// error_reporting(0);
// 	$merchant_data='';
// 	$working_key='565EA2998D87D6DBE14E23B017423F27';//Shared by CCAVENUES
// 	$access_code='AVOH85GE27AU24HOUA';//Shared by CCAVENUES
	
// 	foreach ($_POST as $key => $value){
// 		$merchant_data.=$key.'='.$value.'&';
// 	}
//   $encrypted_data = '';
//   $encrypted_data=$this->encrypt($merchant_data,$working_key); // Method for encrypting the data.
//     $html = '<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
//     <input type=hidden name=encRequest value="'.$encrypted_data.'">
//     <input type=hidden name=access_code value="'.$access_code.'">
//     <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value='.$this->security->get_csrf_hash().'" />
//     <p>Please wait </p>
//     </form>
//     </center>
//     <script language=\'javascript\'>document.redirect.submit();</script>';
//   //echo $html;

}


public function success() {
    $this->load->helper('url');
    $this->load->helper('ccavenue_crypto');
    echo '<pre>';print_r($_POST); Print_r($_REQUEST);echo 'success';
    die();

}

public function cancel() {
    $this->load->helper('url');
    $this->load->helper('ccavenue_crypto');
    print_r($_POST); echo 'cancel';
}




public function direction_online_payment($code) {
    $f = 0;
    $paymentCode = base64_decode($code);
    $paymentInfo = $this->home_model->get_paymentInfo_by_paymentcode($paymentCode); 
    if(!empty($paymentInfo) && strtotime(date('Y-m-d H:i:s')) < strtotime($paymentInfo->payment_expired)){
    $batch_fee = $this->student_model->get_batchfee_bystudent_id($paymentInfo->student_id, $paymentInfo->institute_course_mapping_id); 
      $paidfee = $this->common->get_paidstatus($paymentInfo->student_id, $paymentInfo->institute_course_mapping_id);
      if(!empty($paidfee)) {
        $f = 2;
      } else {
      $this->data['paymentmethod'] = $batch_fee->course_paymentmethod;
      $this->data['batch_fee'] = $batch_fee;  
      $this->data['installment'] = [];
      if(!empty($batch_fee) && $batch_fee->course_paymentmethod == 'installment'){
        $installment = $this->common->get_batch_installment($batch_fee->institute_course_mapping_id); 
        $this->data['installment'] = $installment;
        if(!empty($installment)){
          $amountwithoutgst = $installment[0]->installment_amount;
        }
        $centerCourse = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$batch_fee->institute_course_mapping_id));
            if(!empty($centerCourse)) {
                    $config['SGST'] = $centerCourse['sgst'];
                    $config['CGST']	= $centerCourse['cgst']; 
                    if($centerCourse['cess']>0){
                    $config['cess']	= 1;    
                    $config['cess_value']	= $centerCourse['cess'];
                    } else {
                    $config['cess']	= 0;    
                    $config['cess_value']	= 0;    
                    }
            } 
            $taxableAmt 		= 	taxcalculation($amountwithoutgst, $config, 0);
            $amount = $taxableAmt['totalAmt'];
      }
      if(!empty($batch_fee) && $batch_fee->course_paymentmethod == 'onetime'){
        $amount = $batch_fee->course_totalfee;
        $amountwithoutgst = $batch_fee->course_tuitionfee;
      }
      $discount = $this->common->get_student_discount_detailsstatusone($batch_fee->student_id, $batch_fee->course_master_id);
      $discountAmount = 0;
      if(!empty($discount)) {
        foreach($discount as $disc){
          $discountAmount += $disc->discount_amount;
        }
      }
      // show($discountAmount);
      if($discountAmount >= $amount){
        $f = 0;
      }else{
        $amount -= $discountAmount;
        $f = 1;
      }
      
      $this->data['orderId']  = $paymentInfo->id;
      $this->data['discount'] = $discountAmount;
      $this->data['amt']      = $amountwithoutgst;
      $this->data['student_id'] = $paymentInfo->student_id;
      $this->data['institute_course_mapping_id'] = $paymentInfo->institute_course_mapping_id;
      $this->data['name'] = $this->common->get_name_by_id('am_students','name',array('student_id'=>$paymentInfo->student_id));
      $this->data['cource'] = $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$batch_fee->course_master_id));
      $this->data['data'] = $amount;
    }
    }else{
      $f = 2;
    }
    $this->data['flag'] = $f;
    $this->load->view('home/direction_online_payment', $this->data);
  }
  


public function redirect_payment(){
    // error_reporting(0);
	  $workingKey='';		//Working Key should be provided here.
	  $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	  $rcvdString=$this->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	  $order_status="";
	  $decryptValues=explode('&', $rcvdString);
	  $dataSize=sizeof($decryptValues);
	  $html .= "<center>";

	  for($i = 0; $i < $dataSize; $i++) {
	  	$information=explode('=',$decryptValues[$i]);
	  	if($i==3)	$order_status=$information[1];
	  }
  
	  if($order_status==="Success") {
	    $html .= "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
	  } else if($order_status==="Aborted") {
	    $html .= "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	  } else if($order_status==="Failure") {
	    $html .= "<br>Thank you for shopping with us.However,the transaction has been declined.";
	  } else {
	    $html .= "<br>Security Error. Illegal access detected";
    }
    
	  $html .= "<br><br>";
	  $html .= "<table cellspacing=4 cellpadding=4>";
	  for($i = 0; $i < $dataSize; $i++) {
	  	$information=explode('=',$decryptValues[$i]);
	    $html .= '<tr><td>'.$information[0].'</td><td>'.urldecode($information[1]).'</td></tr>';
	  }
	  $html .= "</table><br>";
    $html .= "</center>";
    echo $html;
}


/*
* @param1 : Plain String
* @param2 : Working key provided by CCAvenue
* @return : Decrypted String
*/
function encrypt($plainText,$key)
{
	$key = $this->hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt($encryptedText,$key)
{
	$key = $this->hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = $this->hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
}