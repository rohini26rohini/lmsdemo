<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Sms_model extends Direction_Model {
    
        public function __construct() {
            parent::__construct();
        }
    
    
        public function send_sms($mobile,$msg)
        {
            $url="http://www.way2sms.com/api/v1/sendCampaign";
            $message = urlencode
                ($msg);// urlencode your message
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
            curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=HZ2KQS4BLVJ8ROMHOXYFBXCZI8DHI7EP&secret=FG8GRBLM9XFP8LZ1&usetype=stage &phone=$mobile&senderid=abcd&message=$message");// post data
            // query parameter values must be given without squarebrackets.
             // Optional Authentication:
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }
}
    


?>
