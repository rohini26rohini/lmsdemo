<?php

class Email_model extends CI_Model {
	function new_email($data) { $this->db->insert('emails',$data); return $this->db->insert_id();}
	function send_email($id) { $data['status']=1; $this->db->where('id',$id)->update('emails',$data); }
	function get_unsend_emails() { return $this->db->where('status',0)->get('emails')->result(); }
}

?>