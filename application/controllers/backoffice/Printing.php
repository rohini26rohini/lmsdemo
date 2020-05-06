<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Printing extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        check_backoffice_permission();
        $this->load->library('pdf');
    }
    public function print_sheet(){
        $this->data['page']="admin/printing";
		$this->data['menu']="reports";
        $this->data['breadcrumb']="Download & Print";
        $this->data['menu_item']="backoffice/printing";
        // $this->data['studentArr']=$this->student_model->get_student_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    function print_notes(){
        $filename      = 'report.pdf';
        $pdfFilePath = FCPATH."/uploads/".$filename; 
        $dataArr['questionArr'] = $this->Printing_model->get_questions();
        $html1 = $this->load->view('admin/print_first_page',$dataArr ,TRUE);
        $html2 = $this->load->view('admin/print_notes',$dataArr ,TRUE);
        ini_set('memory_limit','128M'); // boost the memory limit if it's low 
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter('<div style="text-align:center;"><img src="./assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure 
        $pdf->SetColumns(0);
        $pdf->WriteHTML($html1);
        if($this->input->post('single')==='single'){
            $pdf->SetColumns(0);
        }else{
            $pdf->SetColumns(2,'J');
        }
        $pdf->SetWatermarkText('Direction');
        $pdf->watermark_font = 'DejaVuSansCondensed';
        $pdf->showWatermarkText = true;
        $pdf->watermarkTextAlpha = 0.2;
        $pdf->WriteHTML($html2);
        if($this->input->post('download')===''){
            $pdf->Output("notes.pdf", 'D');
        }else{
            $pdf->Output("notes.pdf", 'F');
        }
        $pdf->Output();
    }
}
