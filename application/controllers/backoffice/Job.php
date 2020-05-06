<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        
    }

    public function index()
    {

		
    }
    
    public function supportive_service_alert()
    {
        $check_array=array(
        "0"=>"7",
        "1"=>"1",
        "2"=>"0",
        );
        foreach($check_array as $row)
        {
           $check_date=date('Y-m-d', strtotime('+'.$row.'days')); 
            
           $service_data=$this->common->get_alldata('assets_supportive_services',array("status"=>1,"alert"=>"1","date_to"=>$check_date)); 
         
            if(!empty($service_data))
            {
                foreach($service_data as $row)
                {
                    $email_id=$this->common->get_name_by_id('am_config','value',array("key"=>"alert"));
                   
                            $data = email_header();
                            $data.='<tr style="background:#f2f2f2">
                                    <td style="padding: 20px 0px">
                                        <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi </h3>
                                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">This is to inform you that your supportive service of '.$row['description'].' will be expired on '.date('d M Y',strtotime($row['date_to'])).'</p>';
                                        /*<p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$username.'</p>
                                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>*/
                                   $data.=' </td>
                                </tr>';
                            $data.=email_footer();
                           // $this->send_email('Expiry Alert',$email_id,$data); 
                            $this->send_email('Expiry Alert','lekshmi@nada.email',$data); 
                }
            }
         
        }
        
        
       
        
        
    }
    function send_email($type, $email, $data) {


    $this->email->to($email);
    $this->email->subject($type);
    $this->email->message($data);
    $this->email->send();
 }
    
}
?>