<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfs extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        check_backoffice_permission();
        $this->load->library('pdf');
        $this->load->model('Auth_model');
        $this->user_password = $this->Auth_model->get_user_password();
    }
    
    public function download_study_material($id){
      // $id = $this->input->post('id');

      if(isset($_POST['id'])){
        $this->load->model('questionbank_model');
        $details = $this->questionbank_model->get_study_material_details($this->input->post('id'));
        // echo $this->db->last_query();
        // echo '<pre>';
        // print_r($details);
        // die();
        if(!empty($details)){
          $file = str_replace(' ', '_',$details['material_name']).'.pdf';
          $html2 ='<div style="width:100%;"><img src="inner_assets/images/logo.png" style="width:90px;margin:10px 0px;display:block;float:right;"></div><b style="text-align:center;display:block;margin:0;"><u>Material Name:</u> </b>'.$details['material_name'];
          $html1 = $details['text_content'];
          $filepath = FCPATH.'materials/study_materials/studyNotesPdf/'.$file;
          $url = base_url('materials/study_materials/studyNotesPdf/'.$file);
          $this->load->library('pdf');
          $pdf = $this->pdf->load();
          $pdf->SetFooter('<div style="text-align:center;"><img src="./assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure ;)
          // if($this->user_password){
          //   $pdf->SetProtection(array(),$this->user_password,PDF_MASTER_PASSWORD);
          // }
          $pdf->WriteHTML($html2); 
          $pdf->WriteHTML($html1);
          $pdf->Output($file, "D");
          // $returnData['st']=1;
          // $returnData['url']=$url;
        }
        else{
          // $returnData['st'] 		  = 0;
          // $returnData['message'] 	= 'No such study exists';
        }
      }else{
        // $returnData['st'] 		  = 0;
        // $returnData['message'] 	= 'Network failure.';
      }
      // print_r(json_encode($returnData));
    }



}
?>
