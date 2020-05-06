<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api {

    function __construct() {
        $this->gbs_obj = & get_instance();
        //$this->gbs_obj->load->library('curl');
    }

    /*
     * Function to send rest api requests
     * Parameters:
     * @request_type {GET/POST}
     * @request_method {Method}
     * @request_data {Data}
     */


    function rest_api_call($api_Data) {
      // print_r($api_Data['data']);die();
        $CI =& get_instance();
        $token = $CI->session->userdata('token');
        if(empty($token)){
            $token = 'gbsToken';
        }
        $retry_count = 1;

        RETRY:
        $url = APIURI.$api_Data['method'];
       // echo $url;die();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $api_Data['type']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_Data['data']); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
        // curl_setopt($ch, CURLOPT_CAINFO, "C:\xampp7.2\htdocs\fixit\certificate.crt");
        // curl_setopt($ch, CURLOPT_SSLCERT, "C:\xampp7.2\htdocs\fixit\sslforfree.pem");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Auth-Token: '.$token
        ));
        $response = curl_exec($ch);
        $decoded_response = json_decode($response);
        if(empty($decoded_response)){
            if($retry_count<3){
                if($token == 'gbsToken'){
                    $token = $CI->session->userdata('token');
                }else{
                    $token = 'gbsToken';
                }
                $retry_count++;
                goto RETRY;
            }
        }
        // $headers = ['Content-Type: application/json; charset=utf-8; X-Auth-Token: "gbsToken"'];
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return $response;
    }
	
    /*function rest_api_call($api_Data) {
        $CI =& get_instance();
        $url = APIURI . $api_Data['method'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $api_Data['type']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_Data['data']); 
        $headers = ['Content-Type: application/json; charset=utf-8; X-Auth-Token: '.$CI->session->userdata('token')];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }*/


    function rest_api_callimg($api_Data) {
        $CI =& get_instance();
        $url = APIURI . $api_Data['method'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $api_Data['type']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_Data['data']); 
        $headers = ['Content-Type: application/x-www-form-urlencoded; charset=utf-8; X-Auth-Token: '.$CI->session->userdata('token')];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }

    function rest_api_call_img($api_Data) { //print_r($api_Data);
       /* $url = APIURI . $api_Data['method'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $api_Data['type']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_Data['data']);
        $headers = ['Content-Type: multipart/form-data; charset=utf-8'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);*/

        ini_set('max_execution_time', 300);
        $url = APIURI . $api_Data['method'];
        $fp = fopen($api_Data['data']['tmp_name'], 'r');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_UPLOAD, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
        curl_setopt($ch, CURLOPT_INFILE, $api_Data['data']['tmp_name']);
        curl_setopt($ch, CURLOPT_NOPROGRESS, false);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($api_Data['data']['tmp_name']));
        return curl_exec ($ch);
    }

    function paymentapilog($data = array()) {
		// PAYMWENT LOG ENTRY	
		$dupliData['method'] 	= "transactionlog/save";
		$dupliData['type'] 	= "POST";
		$dupliData['data'] 	= json_encode($data);
		$dupliResponse 				= json_decode($this->rest_api_call($dupliData)); 
	}
 

}
