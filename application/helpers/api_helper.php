<?php

    function send_json($response){
        $CI = get_instance();
        $CI->output->enable_profiler(FALSE);
        $CI->output->set_content_type('application/json');
		$CI->output->set_header('Accept: application/json');
        $CI->output->set_header('HTTP/1.0 200 OK');
        $CI->output->set_header('HTTP/1.1 200 OK');
        $CI->output->set_status_header(200);
        $CI->output->set_output(json_encode($response,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    function call_api($request){
        $ch = curl_init();
        if($request['type']=='POST'){
            curl_setopt($ch, CURLOPT_POST, count($request['data']));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request['data'])); 
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request['type']);
        curl_setopt($ch, CURLOPT_URL, $request['url']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            if(ENVIRONMENT == 'development'){
                print_r(json_encode(curl_error($ch)));exit;
            }else{
                return curl_error($ch);
            }
        }else{
            if(!empty($response) && is_string($response)){
                json_decode($response);
                if(json_last_error() == JSON_ERROR_NONE){
                    $response = json_decode($response,true);
                }
            }
        }
        curl_close($ch);
        return $response;
    }

?>