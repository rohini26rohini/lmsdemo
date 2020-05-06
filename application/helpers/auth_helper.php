<?php

    function get_hash($text){
        if(is_array($text)){
            $data = json_encode($text);
        }
        $CI =& get_instance();
        $CI->load->library('encryption');
        $CI->encryption->initialize(load_config());
        $hash = $CI->encryption->encrypt($text);
        unset($CI->encryption);
        return $hash;
    }

    function get_text($hash){
        $CI =& get_instance();
        $CI->load->library('encryption');
        $CI->encryption->initialize(load_config());
        $text = $CI->encryption->decrypt($hash);
        unset($CI->encryption);
        return $text;
    }
    
    function load_config(){
        return array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => hex2bin('de2c4ef21d5911a3f0fe082c1f7e27d6'),
                    'driver' => 'openssl'
                );
    }

?>