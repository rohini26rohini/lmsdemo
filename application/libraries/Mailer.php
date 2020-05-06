<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * GBS-PLUS
 */

// ------------------------------------------------------------------------

/**
 * GBS-PLUS Email Class
 *
 * Third-Party Libraries Required:
 *   *Composer
 *   *Phpmailer 6.0.6
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Mailer {
	private $gbs;
    public function __construct()
    {
        $this->gbs = & get_instance();
        $this->ci = get_instance(); 
        $this->gbs->load->model('email/email_model');
    }
    
    public function username($data)    { $this->username =  $data; }
    public function password($data)    { $this->password =  $data; }
    public function host($data)        { $this->host =  $data; }
    public function to($data)          { $this->to =  $data; }
    public function from($data)        { $this->from =  $data; } 
    public function fromName($data)    { $this->from =  $data; } 
    public function title($data)       { $this->title =  $data; } 
    public function subject($data)     { $this->subject =  $data; } 
    public function message($data)     { $this->message =  $data; } 
    public function cc($data)          { $this->cc =  $data; } 
    public function bcc($data)         { $this->bcc =  $data; }
    public function file($data)        { $this->file =  $data; }
    public function emailJobId($data)  { $this->emailJobId =  $data; }
    
    public function send()
    {
        $mail_stamp = '<b style="text-align:center;font-size: 35px;margin-left: 30%;">GBS-PLUS EMAIL SOFTWARE</b>';
        
        /*******  FROM  *******/
        if(isset($this->from)){
            $from = $this->from;
        }else{
            $from = $this->ci->config->item('email_fromAdress');
        }
        
        /*******  FROM  NAME *******/
        if(isset($this->fromName)){
            $fromName = $this->fromName;
        }else{
            $fromName = $this->ci->config->item('email_fromName');
        }
        
        /*******  USERNAME *******/
        if(isset($this->username)){
            $username = $this->username;
        }else{
            $username = $this->ci->config->item('email_username');
        }

        /*******  FROM  NAME *******/
        if(isset($this->password)){
            $password = $this->password;
        }else{
            $password = $this->ci->config->item('email_password');
        }

        /*******  FROM  NAME *******/
        if(isset($this->host)){
            $host = $this->host;
        }else{
            $host = $this->ci->config->item('email_host');
        }

        /*******  TO  *******/
        if(isset($this->to)){
            $to = $this->to;
        }else{
            $error = '<font style="color: red;font-size: 22px;text-align: center;margin-left: 37%;">ADDRESS is missing</font>';
            echo '<pre>';
            print_r($error);
        }
        
        /*******  SUBJECT  *******/
        if(isset($this->subject)){
            $subject = $this->subject;
        }else{
            $error = '<font style="color: red;font-size: 22px;text-align: center;margin-left: 37%;">SUBJECT is missing</font>';
            echo '<pre>';
            print_r($error);
        }
        
        /*******  MESSAGE  *******/
        if(isset($this->message)){
            $message = $this->message;
        }else{
            $error = '<font style="color: red;font-size: 22px;text-align: center;margin-left: 37%;">EMAIL CONTENT is missing</font>';
            echo '<pre>';
            print_r($error);
        }
        
        /*******  CC  *******/
        if(isset($this->cc)){
            $cc = $this->cc;
        }else{
            $cc = NULL;
        }
        
        /*******  BCC  *******/
        if(isset($this->bcc)){
            $bcc = $this->bcc;
        }else{
            $bcc = NULL;
        }
        
        /*******  FILE ATTACHMENT  *******/
        if(isset($this->file)){
            $file = $this->file;
        }else{
            $file = NULL;
        }
        
        if(isset($error)){
            echo '<br>';
            print_r($mail_stamp);
            exit;
        }else{
			$mail_data=array(
				'from'=>$from,
				'to'=>$to,
				'cc'=>$cc,
				'bcc'=>$bcc,
				'subject'=>$subject,
				'message'=>$message,
				'file'=>$file,
				'status'=>0,
				'created_date'=>date('Y-m-d h:i:s')
			);
            if(isset($this->emailJobId)){
                $id = $this->emailJobId;
            }else{
                $id = $this->gbs->email_model->new_email($mail_data);
            }
            $this->send_mail_task($id, $from, $fromName, $host, $username, $password, $to, $cc, $bcc, $subject, $message, $file);
        }
    } 

    public function send_scheduled_emails(){
        $emails = $this->gbs->email_model->get_unsend_emails();
		if(!empty($emails)){
			foreach($emails as $email){
                $this->emailJobId($email->id);
                $this->to($email->to);
                $this->subject($email->subject);
                $this->message($email->message);
				if(!empty($email->cc)){$this->cc($email->cc);}
				if(!empty($email->bcc)){$this->bcc($email->bcc);}
				if(!empty($email->file)){$this->file($email->file);}
				$this->send();
			}
		}

    }
    
    private function send_mail_task($id, $from, $fromName, $host, $username, $password, $to, $cc, $bcc, $subject, $message, $file)
    {
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true); 
        $mail->SMTPDebug = 0;         
        $mail->isSMTP();                               
        $mail->Host = $host;
        $mail->SMTPAuth = true;                          
        $mail->Username = $username;                
        $mail->Password = $password;                    
        $mail->SMTPSecure = "ssl";                   
        $mail->Port = 465;   
        $mail->From = $from;
        $mail->FromName = $fromName;
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
        $mail->addAddress($to);
        if($cc != NULL){$mail->AddCC($cc);}
        if($bcc != NULL){$mail->AddCC($bcc);}
        if($file != NULL){$mail->addAttachment($file);}
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = "This is the plain text version of the email content";      
        if($mail->send()){
			$this->gbs->email_model->send_email($id);
		}
    }
}