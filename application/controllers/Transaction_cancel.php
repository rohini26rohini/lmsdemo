<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_cancel extends Direction_Controller {
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
    echo '<pre>';print_r($_POST); 
    $workingKey = WORKING_KEY; // Working Key should be provided here.
    $encResponse = $_POST ["encResp"]; // This is the response sent by the CCAvenue Server
    $order_id = $_POST['orderNo'];
    $rcvdString = decrypt($encResponse, $workingKey); // Crypto Decryption used as per the specified working key.
    
    //$rcvdString = "order_id=6311&tracking_id=106263030409&bank_ref_no=007570&order_status=Success&failure_message=&payment_mode=Debit Card&card_name=MasterCard Debit Card&status_code=0&status_message=Transaction Successful¤cy=INR&amount=1.0&billing_name=asdsad sadasd&billing_address=sadasd&billing_city=Delhi&billing_state=Delhi&billing_zip=695103&billing_country=India&billing_tel=9898989898&billing_email=nileshn@gbs-plus.com&delivery_name=asdsad sadasd&delivery_address=sadasd&delivery_city=Delhi&delivery_state=Delhi&delivery_zip=695103&delivery_country=India&delivery_tel=9898989898&merchant_param1=532&merchant_param2=Param&merchant_param3=Param&merchant_param4=Param&merchant_param5=Android Registration&vault=N&offer_type=null&offer_code=null&discount_value=0.0&mer_amount=1.0&eci_value=02&retry=N&response_code=0&billing_notes=&trans_date=07/08/2017 18:13:32&bin_country=INDIA";
    //$rcvdString = "order_id=6311&tracking_id=106263428876&bank_ref_no=006111&order_status=Success&failure_message=&payment_mode=Debit Card&card_name=MasterCard Debit Card&status_code=0&status_message=Transaction Successful���cy=INR&amount=550.0&billing_name=Nilesh Nirmalan&billing_address=dasdasd&billing_city=Delhi&billing_state=Delhi&billing_zip=695103&billing_country=India&billing_tel=9656560098&billing_email=nileshn@gbs-plus.com&delivery_name=Nilesh Nirmalan&delivery_address=dasdasd&delivery_city=Delhi&delivery_state=Delhi&delivery_zip=695103&delivery_country=India&delivery_tel=9656560098&merchant_param1=7031&merchant_param2=Param&merchant_param3=Param&merchant_param4=Param&merchant_param5=Param&vault=N&offer_type=null&offer_code=null&discount_value=0.0&mer_amount=1.0&eci_value=02&retry=N&response_code=0&billing_notes=&trans_date=08/08/2017 16:34:32&bin_country=INDIA";
    //$rcvdString = "order_id=981&tracking_id=106269986388&bank_ref_no=008083&order_status=Success&failure_message=&payment_mode=Debit Card&card_name=MasterCard Debit Card&status_code=0&status_message=Transaction Successful���cy=INR&amount=1.0&billing_name=Nilesh Nirmalan Nirmalan&billing_address=dadsadasdasdasd&billing_city=Thiruvananthapuram&billing_state=Kerala&billing_zip=695003&billing_country=India&billing_tel=9898989898&billing_email=nileshn@gbs-plus.com&delivery_name=Nilesh Nirmalan Nirmalan&delivery_address=dadsadasdasdasd&delivery_city=Thiruvananthapuram&delivery_state=Kerala&delivery_zip=695003&delivery_country=India&delivery_tel=9898989898&merchant_param1=7053&merchant_param2=vibha_publications&merchant_param3=Param&merchant_param4=Param&merchant_param5=Param&vault=N&offer_type=null&offer_code=null&discount_value=0.0&mer_amount=1.0&eci_value=02&retry=N&response_code=0&billing_notes=&trans_date=23/08/2017 18:13:14&bin_country=INDIA";
    
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
    print_r($orderResultArray);
    $order_status = $orderResultArray['order_status'];
    if($order_status=='Aborted') {
        
    } else if($order_status=='Failure') {

    } else {

    }


}


}