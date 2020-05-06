<?php
@session_start();
    define("TESTING", "https://localhost:8888/paytabs/apiv2/index");
    define("AUTHENTICATION", "https://www.paytabs.com/apiv2/validate_secret_key");
    define("PAYPAGE_URL", "https://www.paytabs.com/apiv2/create_pay_page");
	define("PAYPAGE_TOKENURL", "https://www.paytabs.com/apiv3/tokenized_transaction_prepare");
    define("VERIFY_URL", "https://www.paytabs.com/apiv2/verify_payment");
	define("VERIFY_URL_TOKEN", "https://www.paytabs.com/apiv2/verify_payment_transaction");

class paytabs {

    private $merchant_id;
    private $merchant_secretKey;
  

    function __construct($merchant_email, $merchant_secretKey) {
        $this->merchant_email = $merchant_email;
        $this->merchant_secretKey = $merchant_secretKey;
        $this->api_key = "";
    }
    
    function authentication(){
        $obj = json_decode($this->runPost(AUTHENTICATION, array("merchant_email"=> 'ramesh.6are@gmail.com', "merchant_secretKey"=>  'dk9jXRClZfWUae8sxfi79OPM3YwwlZ2zjcSg4vC3LyYVN6nkmGswvhiyfP4BO7b7k3ooz0skzqgmxEHTl9pQrIoGxtilBttVxRj6')));
        if($obj->access == "granted")
            $this->api_key = $obj->api_key;
        else 
            $this->api_key = "";
        return $this->api_key;
    }
    
    function create_pay_page($values) {
        $values['merchant_email'] = $this->merchant_email;
        $values['merchant_secretKey'] = $this->merchant_secretKey;
        $values['ip_customer'] = $_SERVER['REMOTE_ADDR'];
        $values['ip_merchant'] = $_SERVER['SERVER_ADDR'];
        return json_decode($this->runPost(PAYPAGE_URL, $values));
    }
	
	function tokenized_transaction_prepare($values) {
        $values['merchant_email'] = $this->merchant_email;
        $values['merchant_secretKey'] = $this->merchant_secretKey;
        $values['ip_customer'] = $_SERVER['REMOTE_ADDR'];
        $values['ip_merchant'] = $_SERVER['SERVER_ADDR'];
        return json_decode($this->runPost(PAYPAGE_TOKENURL, $values));
    }
    
    function send_request(){
        $values['ip_customer'] = $_SERVER['REMOTE_ADDR'];
        $values['ip_merchant'] = $_SERVER['SERVER_ADDR'];
        return json_decode($this->runPost(TESTING, $values));
    }
    
    
     function verify_payment($values){
         /*$values['merchant_email'] = $this->merchant_email;
        $values['merchant_secretKey'] = $this->merchant_secretKey;
        $values['payment_reference'] = $payment_reference;*/
        return json_decode($this->runPost(VERIFY_URL, $values));
    }
	
	function verify_payment_transaction($values){
        /*$values['merchant_email'] = $this->merchant_email;
       $values['merchant_secretKey'] = $this->merchant_secretKey;
       $values['payment_reference'] = $payment_reference;*/
       return json_decode($this->runPost(VERIFY_URL_TOKEN, $values));
   }
    
    
    function runPost($url, $fields) {
        $fields_string = "";
        $ip_address = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        $ip = $_SERVER['REMOTE_ADDR'];

        $ipaddress = array(
            "REMOTE_ADDR" => $ip,
            "HTTP_X_FORWARDED_FOR" => $ip
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ipaddress);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);

        $result = curl_exec($ch);
        //print_r($result);
        curl_close($ch);
        
        return $result;
    }

}
?>