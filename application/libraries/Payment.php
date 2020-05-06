<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment {

function __construct() {
    $this->gbs_obj = & get_instance();
    //$this->gbs_obj->load->library('curl');
}
    

	public function createpayapp($userdata = NULL) {
		//$this->load->library('paytabs');
		require_once(APPPATH.'libraries/Paytabs.php');
		$pt = new paytabs("ramesh.r@gbs-plus.com", "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w");
		$payment['merchant_email'] 			= 'ramesh.r@gbs-plus.com';
		$payment['secret_key'] 				= "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w";
		$payment['title'] 					= $userdata['customer'];
		$payment['cc_first_name'] 			= $userdata['customer'];
		$payment['cc_last_name'] 			= $userdata['customer'];
		$payment['email'] 					= $userdata['email'];
		$payment['customer_email'] 			= $userdata['email'];
		$payment['cc_phone_number'] 		= "+971";
		$payment['phone_number'] 			= $userdata['phone_number'];
		$payment['billing_address'] 		= $userdata['billing_address'];
		$payment['city'] 					= $userdata['city'];
		$payment['state'] 					= $userdata['state'];
		$payment['postal_code'] 			= $userdata['postal_code_shipping'];
		$payment['country'] 				= $userdata['country'];
		$payment['address_shipping'] 		= $userdata['address_shipping'];
		$payment['address_billing'] 		= $userdata['address_shipping'];
		$payment['city_shipping'] 			= $userdata['city_shipping'];
		$payment['city_billing'] 			= $userdata['city_shipping'];
		$payment['state_shipping'] 			= $userdata['state_shipping'];
		$payment['state_billing'] 			= $userdata['state_shipping'];
		$payment['postal_code_shipping'] 	= $userdata['postal_code_shipping'];;
		$payment['postal_code_billing'] 	= $userdata['postal_code_shipping'];;
		$payment['country_shipping'] 		= $userdata['country_shipping'];
		$payment['country_billing'] 		= $userdata['country_shipping'];
		$payment['products_per_title'] 		= $userdata['reference_no']." service request";
		$payment['product_name'] 			= $userdata['reference_no']." service request";
		$payment['currency'] 				= CURRENCY;
		$payment['unit_price'] 				= $userdata['amount'];
		$payment['quantity'] 				= '1';
		$payment['other_charges'] 			= '0';
		$payment['amount'] 					= $userdata['amount'];
		$payment['discount'] 				= '0';
		$payment['msg_lang'] 				= "english";
		$payment['reference_no'] 			= $userdata['reference_no'];
		$payment['order_id'] 				= $userdata['reference_no'];
		$payment['site_url'] 				= "http://45.56.65.241/";
		$payment['return_url'] 				= "http://45.56.65.241/directiontest/fee-payment-success";
		$payment['cms_with_version'] 		= "FIXT v.1";
		$result = $pt->create_pay_page($payment); // FOR NEW CUSTOMER
		
		return $result;
	}	

    /*
     * Function to send rest api requests
     * Parameters:
     * @request_type {GET/POST}
     * @request_method {Method}
     * @request_data {Data}
     */

     public function createpay($userdata = NULL) { 
		//$this->load->library('paytabs');
		require_once(APPPATH.'libraries/Paytabs.php');
		$pt = new paytabs("ramesh.r@gbs-plus.com", "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w");
		$payment['merchant_email'] 			= 'ramesh.r@gbs-plus.com';
		$payment['secret_key'] 				= "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w";
		$payment['title'] 					= $userdata['customer'];
		$payment['cc_first_name'] 			= $userdata['customer'];
		$payment['cc_last_name'] 			= $userdata['customer'];
		$payment['email'] 					= $userdata['email'];
		$payment['customer_email'] 			= $userdata['email'];
		$payment['cc_phone_number'] 		= "+971";
		$payment['phone_number'] 			= $userdata['phone_number'];
		$payment['billing_address'] 		= $userdata['billing_address'];
		$payment['city'] 					= $userdata['city'];
		$payment['state'] 					= $userdata['state'];
		$payment['postal_code'] 			= $userdata['user_id'];
		$payment['country'] 				= $userdata['country'];
		$payment['address_shipping'] 		= $userdata['address_shipping'];
		$payment['address_billing'] 		= $userdata['address_shipping'];
		$payment['city_shipping'] 			= $userdata['city_shipping'];
		$payment['city_billing'] 			= $userdata['city_shipping'];
		$payment['state_shipping'] 			= $userdata['state_shipping'];
		$payment['state_billing'] 			= $userdata['state_shipping'];
		$payment['postal_code_shipping'] 	= $userdata['user_id'];
		$payment['postal_code_billing'] 	= $userdata['user_id'];
		$payment['country_shipping'] 		= $userdata['country_shipping'];
		$payment['country_billing'] 		= $userdata['country_shipping'];
		$payment['products_per_title'] 		= $userdata['reference_no']." service request";
		$payment['product_name'] 			= $userdata['reference_no']." service request";
		$payment['currency'] 				= CURRENCY;
		$payment['unit_price'] 				= $userdata['amount'];
		$payment['quantity'] 				= '1';
		$payment['other_charges'] 			= '0';
		$payment['amount'] 					= $userdata['amount'];
		$payment['discount'] 				= '0';
		$payment['msg_lang'] 				= "english";
		$payment['reference_no'] 			= $userdata['reference_no'];
		$payment['order_id'] 				= $userdata['reference_no'];
		$payment['site_url'] 				= "http://45.56.65.241/";
		$payment['return_url'] 				= "http://45.56.65.241/directiontest/fee-payment-success";
		$payment['cms_with_version'] 		= "Direction v.1";
		$result = $pt->create_pay_page($payment); // FOR NEW CUSTOMER
		return $result;
	}	
	
	function verify_payment($payment_reference = null){
		require_once(APPPATH.'libraries/Paytabs.php');
		$pt = new paytabs("ramesh.r@gbs-plus.com", "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w");
		$result = $pt->verify_payment(array(
			//PayTabs Merchant Account Details
			"merchant_email" => "ramesh.r@gbs-plus.com",						 // PayTabs Merchant Account's email address
			'secret_key' => "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w", // Secret Key can be fount at PayTabs Merchant Dashboard > Mobile Payments > Secret Key
			'payment_reference'=>$payment_reference
		));
		return $result;
	}

	function verify_payment_transaction($payment_reference = null){
		require_once(APPPATH.'libraries/Paytabs.php');
		$pt = new paytabs("ramesh.r@gbs-plus.com", "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w");
		$result = $pt->verify_payment_transaction(array(
			//PayTabs Merchant Account Details
			"merchant_email" => "ramesh.r@gbs-plus.com",						 // PayTabs Merchant Account's email address
			'secret_key' => "5LUXCuOlNgs8SUON1WUwfbEeBeu7IDaNo4L1yAmmRPvJKjxLgriwDWKebemTRwHgAti93EwUu1EelcZBEh7heSvp6RiYoZfZsx8w", // Secret Key can be fount at PayTabs Merchant Dashboard > Mobile Payments > Secret Key
			'transaction_id'=>$payment_reference
		));
		return $result;
	}
	


}
