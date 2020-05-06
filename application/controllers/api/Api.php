<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Direction_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
    $this->load->model('api_model');
    $this->load->model('api_model');
    $this->load->helper('ccavenue_crypto');
  }

  public function index() { 
    header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 1000");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Auth-Token, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: PUT, POST, GET");
      $postdata = file_get_contents("php://input");
      $request = json_decode($postdata);
     if(!empty($request)) {
       foreach($request as $req) {
            $staff_id = $this->api_model->get_staff_by_badgenumber($req->badgenumber);
            if($staff_id>0) {
              if($req->CheckType==0) {
              $data = array('staff_id'=>$staff_id,
                            'date'=>date('Y-m-d', strtotime($req->AttDate)),
                            'attendance'=>1,
                            'checkintime'=>$req->checktime
                              );
              $this->db->insert('am_staff_attendance', $data); 
              } else if($req->CheckType==1) {
                $where = array('staff_id'=>$staff_id,
                            'date'=>date('Y-m-d', strtotime($req->AttDate))
                              );
                $dataupdate = array('checkouttime'=>$req->checktime
                              );
                $this->db->where($where);
                $this->db->update('am_staff_attendance', $dataupdate);              
              }               
            }
       }
     }

  }


function get_last_scheduletime() {
  header("Content-Type: application/json; charset=UTF-8");
  header('Access-Control-Allow-Headers: "Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token"');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $this->db->order_by('id', 'desc');
  $this->db->limit(1);
  $query=$this->db->get('job_schedule');
  $resultArr=$query->row_array(); 
  $return = $resultArr['last_schedule_time'];
  if($request->time!='') {
    $this->db->insert('job_schedule', array('last_schedule_time'=>$request->time));
  }
  return $return;
}


}