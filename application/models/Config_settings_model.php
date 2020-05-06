<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_settings_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    function insert_config($data)
    {
         $query=$this->db->insert_batch('am_config', $data);
       if($query)
           {
               return true;
           }
        else
        {
            return false;
        }  
    }
    function update_config($data)
    {
       $query=$this->db->update_batch('am_config', $data,'key');
       if($query)
       {
           return true;
       }
        else
        {
            return false;
        }
    }
}
?>
        