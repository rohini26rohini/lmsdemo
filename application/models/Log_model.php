<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function log($data) {
        $this->db->insert('am_log', $data);
    }
}