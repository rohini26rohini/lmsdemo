<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="report_management";
        check_backoffice_permission();
    }


    public function index(){ 
        check_backoffice_permission('report_management');
        $this->data['page']="admin/report";
        $this->data['breadcrumb']="Report";
        $this->load->view('admin/report',$this->data); 
    }

    public function student_report(){
        check_backoffice_permission('student_report');
        $this->data['page']="admin/student_report";
        $this->data['menu']="student_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Student Report";
        // $this->data['breadcrumb']="Student Report";
        $this->data['menu_item']="backoffice/student-report";
        $this->data['studentArr']=$this->student_model->get_student_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function student_report_pagination(){
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $col = 0;
        $dir = "";
        if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
        if($dir != "desc" && $dir != "desc") {
            $dir = "desc";
        }
        $columns_valid = array(
            "am_students.registration_number", 
            "am_students.name", 
            "am_students.course_id", 
            "am_students.email", 
            "am_students.contact_number", 
            "am_students.street", 
            "am_students.status"
        );
        if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        $list = $this->student_model->student_report_pagination($start, $length, $order, $dir);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {
            $course=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$rows['course_id']));
            if ($rows['status']==1){
                $status= 'Admitted';
            }
            else if($rows['status']==2) 
            {
                $status= 'Fee Paid';
            }
            else if($rows['status']==4) 
            { 
                $status= 'Batch Changed';
            }
            else if($rows['status']==5) 
            {
                $status= 'Inactive';
            }
            else if($rows['status']==0 && $rows['verified_status']==1) {
                $status= 'Payment Pending';
            }
            else 
            {
                $status= 'Registered';
            }
             if($rows['caller_id']>0) 
            { 
                $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$rows['caller_id']));
                     if(!empty($callcentre['call_status']))
                     {
                       $ccstatus = $callcentre['call_status'];
                         if($ccstatus==4)
                            { 
                                $blacklist_status= '<span class="inactivestatus" style="margin-top:3px;">blacklist</span>';
                            }
                     }
            }
            
            $blacklist_status="";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['registration_number'];
            $row[] = $rows['name'];
            $row[] = $course;
            $row[] = $rows['email'];
            $row[] = $rows['contact_number'];
            $row[] = $rows['street'];
            $row[] = $status." ".$blacklist_status;
            $data[] = $row;
        }
        $total_rows=$this->student_model->get_num_student_list_pagination();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }
    
    public function search_student()
    {
         $html = '<thead><tr>
                <th width="50">'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('application.no').'</th>
                <th>'.$this->lang->line('name').'</th>
                <th>'.$this->lang->line('course').'</th>
                <th>'.$this->lang->line('emailid').'</th>
                <th>'.$this->lang->line('contact.no').'</th>
                <th>'.$this->lang->line('location').'</th>
                <th>'.$this->lang->line('status').'</th>
                </tr></thead>';
        if($_POST) {
            $school_id=$this->input->post('school_id');
            $centre_id=$this->input->post('centre_id');
            $course_id=$this->input->post('course_id');
            $batch_id=$this->input->post('batch_id');
            $status=$this->input->post('status');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $where=array();
            if($school_id != "")
            {
                $where['am_classes.school_id']=$school_id;
            }
            if($centre_id !="")
            {
                $where['am_student_course_mapping.center_id']=$centre_id;
            }
            if($course_id !="")
            {
                $where['am_student_course_mapping.institute_course_mapping_id']=$course_id;
            }
            if($batch_id !="")
            {
                $where['am_student_course_mapping.batch_id']=$batch_id;
            }
            if($status !="")
            { 
              
                if($status != "blacklist")
               {
                $where['am_students.status']=$status;
               }
              else
              {
                  
               $where['cc_call_center_enquiries.call_status']="4";
              }
            }
            if($start_date !="") {
                $where['am_students.admitted_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !="") {
                $where['am_students.admitted_date<=']=date('Y-m-d',strtotime($end_date));
            }
            $data=$this->student_model->search_student($where); 
            if(!empty($data))
            { $i=1;
                foreach($data as $row)
                {
                    $course=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$row['course_id']));
                    $status="";
                            if ($row['student_status']==1) { $status= 'Admitted';}
                            else if($row['student_status']==2) {  $status= 'Fee Paid';}
                            else if($row['student_status']==4) {  $status= 'Batch Changed';}
                            else if($row['student_status']==5) {  $status= 'Inactive';}
                            else if($row['student_status']==0 && $row['verified_status']==1) {
                                 $status= 'Payment Pending';}
                            else  {  $status= 'Payment Pending';}
                            if($row['call_status']==4) {  $status= 'Blacklist';}
                     $html .= '<tr>
                            <td>'.$i.'</td>
                            <td>'.$row['registration_number'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$course.'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['contact_number'].'</td>
                            <td>'.$row['street'].'</td>
                            <td>'.$status.'</td>
                        </tr>';
                        $i++; 
                }
            }
        }
        echo $html;
    }
    
    /*
    
    */
    public function export_student_report() {
        if($_POST) {
            $school_id=$this->input->post('school_id');
            $centre_id=$this->input->post('centre_id');
            $course_id=$this->input->post('course_id');
            $batch_id=$this->input->post('batch_id');
            $status=$this->input->post('status');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $type=$this->input->post('type');
            $where=array();
            if($school_id != ""){
                $where['am_classes.school_id']=$school_id;
            }
            if($centre_id !=""){
                $where['am_student_course_mapping.center_id']=$centre_id;
            }
            if($course_id !=""){
                $where['am_student_course_mapping.institute_course_mapping_id']=$course_id;
            }
            if($batch_id !=""){
                $where['am_student_course_mapping.batch_id']=$batch_id;
            }
            if($status !=""){
                if($status != "blacklist"){
                    $where['am_students.status']=$status;
                } else {  
                    $where['cc_call_center_enquiries.call_status']="4";
                }
            }
            if($start_date !=""){
                $where['am_students.admitted_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_students.admitted_date<=']=date('Y-m-d',strtotime($end_date));
            }
            $data['studentArr']=$this->student_model->search_student($where);
            // show($data['studentArr']);
            if(!empty($data['studentArr'])){
                if($type == 'pdf'){
                    $filename      = 'students_report.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/student_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    $pdf->SetHeader();
                    $pdf->SetFooter('<div style="text-align:center;"></div></body></html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('P');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'students_report-'.date('Ymd').'.xlsx';
                    $this->load->library('excel');
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sl.No.');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Application.No.');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'School');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Centre');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Batch');       
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Contact Number');       
                    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Address');       
                    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Location');       
                    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Status');       
                    // set Row
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['studentArr'] as $row) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['registration_number']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['name']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $this->common->get_name_by_id('am_schools','school_name',array("school_id"=>$row['school_id'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$row['center_id'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['contact_number']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['address']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row['street']);
                        $ccstatus = '';
                        if($row['caller_id']>0) { 
                            $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$row['caller_id']));
                            if(!empty($callcentre['call_status'])){
                                $ccstatus = $callcentre['call_status'];
                            } 
                        }
                        if ($row['student_status']==1) { $status1 = 'Admitted';}
                        else if($row['student_status']==2) { $status1 = 'Fee Paid';}
                        else if($row['student_status']==4) { $status1 = 'Batch Changed';}
                        else if($row['student_status']==5) { $status1 = 'Inactive';}
                        else if($row['student_status']==0 && $row['verified_status']==1) { $status1 = 'Payment Pending';}
                        else  { $status1 = 'Payment Pending';}
                        if($ccstatus==4) { $status1 = 'Blacklist';}
                        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $status1);
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/student-report'); 
            }
        }
    }
    
   public function staff_attendance_report()
    {
        check_backoffice_permission('staff_attendance_report');
        $this->data['page']="admin/staff_attendance_report";
        $this->data['menu']="staff_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Staff Report";
        $this->data['menu_item']="staff_attendance_report";
		$this->load->view('admin/layouts/_master',$this->data);
    }
    
    public function load_staff_attendance()
    {
      if($_POST)
      {
          $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
          $end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
          $attendance_data=$this->Report_model->load_staff_attendance($start_date,$end_date);
          //echo '<pre>';print_r($attendance_data);//die();
          $date_array=array();
         foreach($attendance_data as $key=>$row)
         {
            $date_array[$key]=$row['date']; 
         }
          $date_array=array_unique($date_array);
          $html='<table  class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">'. $this->lang->line("sl_no").'</th>
                        <th>'. $this->lang->line("name").'</th>
                        <th>'.  $this->lang->line("role").'</th>
                        <th>'. $this->lang->line("attendance").'</th></tr>
                </thead>
               <tbody>';
         foreach($date_array as $row)
         {//echo '<pre>'.print_r($row);
           //echo $row."<br>";
             $html.='<tr><td colspan="4" class="text-center s-attendance">'.date('d-m-Y',strtotime($row)).'</td><tr>';
             $i=1; 
             foreach($attendance_data as $val)
             { 
                if($val['date'] == $row)
                {
                     if($val['attendance'] == 0)
                     {
                         $attendance="<span><i class='fa fa-times text-danger'></i></span>";
                       
                     }
                    else
                    {
                       $attendance="<span><i class='fa fa-check text-success'></i></span>";  
                    }
                   $html.='<tr>
                           <td>'.$i.'</td>
                           <td>'.$val['name'].'</td>
                           <td>'.$val['role_name'].'</td>
                           <td>'.$attendance.'</td>
                           <tr>';
					$i++;
                }
               //$i++;
             }
         }
          $html.='</tbody></table>';
          echo $html;
        }
    
    }
    
    public function export_staff_attendance_report(){
        if($_POST)
        {
            $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
            $end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
            $data['attendance_data']=$this->Report_model->load_staff_attendance($start_date,$end_date);
            foreach($data['attendance_data'] as $key=>$row) {
                $date_array[$key]=$row['date']; 
            }
            $data['date_array']=array_unique($date_array);
            if(!empty($data)) {
                $filename      = 'staff_attendance_report.pdf';
                $pdfFilePath = FCPATH."/uploads/".$filename; 
                $html = $this->load->view('admin/pdf/staff_attendance_report',$data,TRUE);
                ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                $pdf->SetFooter('<div style="text-align:center;"></div></body>
                </html>'); // Add a footer for good measure ;)
                $pdf->AddPage('L');
                $pdf->WriteHTML($html); // write the HTML into the PDF
                //$pdf->WriteHTML('Hello World');
                $pdf->Output($filename, "D"); // save to file because we can
               
            }
           
        }
    }
    public function batch_schedule_report(){
        check_backoffice_permission('batch_schedule_report');
        $this->data['page'] = "admin/batch_schedule_report";
        $this->data['menu'] = "schedule_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Batch Schedule Report";
        $this->data['menu_item'] = "batch-schedule-report";
        $this->data['batchArr']=$this->Report_model->get_batch_schedule_report();
        // show($this->data['batchArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function search_batch() {
        $html = '<thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('batch').'</th>
                        <th>'.$this->lang->line('subject').'</th>
                        <th>'.$this->lang->line('date').'</th>
                        <th>'.$this->lang->line('start_time').'</th>
                        <th>'.$this->lang->line('end_time').'</th> 
                        <th>'.$this->lang->line('module_name').'</th>
                        <th>'.$this->lang->line('staff').'</th>
                        <th>'.$this->lang->line('status').'</th>
                    </tr>
                </thead><tbody>';
        if($_POST) {
            $batch_id = $this->input->post('batch_id');
            $status = $this->input->post('status');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $subject = $this->input->post('filter_subject');
            $where = array();
            if($status !=""){    
               $where['am_schedules.class_taken'] = $status;
            }
            if($start_date !=""){
                $where['am_schedules.schedule_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_schedules.schedule_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($subject != ""){
                $where['am_syllabus_master_details.subject_master_id'] = $subject;
            }
            if($batch_id != ""){
                $where['am_batch_center_mapping.batch_id'] = $batch_id;
            }
            $data = $this->Report_model->search_batch($where);
            if(!empty($data))
            { $i=1;
                foreach($data as $row) {
                    $html .= '<tr>
                        <td>'.$i.'</td>
                        <td>'.$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id'])).'</td>
                        <td>'.$this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$row['subject_master_id'])).'</td>
                        <td>'.date('d-m-Y',strtotime($row['schedule_date'])).'</td>
                        <td>'.date("g:i a", strtotime($row['schedule_start_time'])).'</td>
                        <td>'.date("g:i a", strtotime($row['schedule_end_time'])).'</td>
                        <td>'.$this->common->get_module_fromschedule_idname_by_id($row['module_id']).'</td>
                        <td>'.$this->common->get_name_by_id('am_staff_personal','name',array("personal_id"=>$row['staff_id'])).'</td>
                        <td>';
                            if($row['class_taken'] == 1){
                                $html .= 'Completed';
                            }else{
                                $html .= 'Pending';
                            }
                    $html .= '</td>
                    </tr>';
                    $i++; 
                }
                $html .= '</tbody>';
            }
        }
        echo $html;
    }
    public function export_batch_report() {
        if($_POST) {
            $batch_id=$this->input->post('batch_id');
            $status=$this->input->post('status');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $subject=$this->input->post('subject');
            $type1=$this->input->post('type1');
            $where = array();
            if($status !=""){    
               $where['am_schedules.class_taken'] = $status;
            }
            if($start_date !=""){
                $where['am_schedules.schedule_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_schedules.schedule_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($subject != ""){
                $where['am_syllabus_master_details.subject_master_id'] = $subject;
            }
            if($batch_id != ""){
                $where['am_batch_center_mapping.batch_id'] = $batch_id;
            }
            $data['report'] = $this->Report_model->search_batch($where);
            // show($this->db->last_query());
            if(!empty($data['report'])){
                if($type1 == 'pdf'){
                    $filename      = 'batch_report.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/batch_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    // $pdf->SetHeader('Content-Type: application/pdf');
                    $pdf->SetFooter('<div style="text-align:center;"></div></body>
                    </html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('p');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'batch_report-'.date('Ymd').'.xlsx';
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->lang->line('sl_no'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $this->lang->line('batch'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', $this->lang->line('subject'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', $this->lang->line('date'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', $this->lang->line('start_time'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', $this->lang->line('end_time'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', $this->lang->line('module_name'));             
                    $objPHPExcel->getActiveSheet()->SetCellValue('H1', $this->lang->line('staff'));             
                    $objPHPExcel->getActiveSheet()->SetCellValue('I1', $this->lang->line('status'));     
                    // set Row
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['report'] as $row) { if($row['schedule_type'] == 1) $type = 'Exam'; else $type = 'Class';
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $batch = $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $batch);
                        $subject = $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$row['subject_master_id']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('c' . $rowCount, $subject);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, date('d-m-Y',strtotime($row['schedule_date'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, date("g:i a", strtotime($row['schedule_start_time'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, date("g:i a", strtotime($row['schedule_end_time'])));
                            $moduleExam = $this->common->get_module_fromschedule_idname_by_id($row['module_id']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $moduleExam);
                            $staff = $this->common->get_name_by_id('am_staff_personal','name',array("personal_id"=>$row['staff_id']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $staff);
                        if($row['class_taken'] == 1){
                            $status = 'Completed';
                        }else{
                            $status = 'Pending';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $status);
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/batch-schedule-report'); 
            }
        }
    }
    public function get_subject(){
        $batchId = $this->input->post('batch_id');
        $subjectArr = $this->Report_model->get_subject($batchId);
        // show($subjectArr);
        $html = '<option value="">'.$this->lang->line("select").'</option>';
        if(!empty($subjectArr)){
             foreach($subjectArr as $row){
                $html .= '<option value="'.$row["subject_id"].'">'.$row["subject_name"].'</option>';
            }
        }
        echo $html;
    }

    public function facualty_allocated_report(){
        check_backoffice_permission('facualty_allocated_report');
        $this->data['page'] = "admin/facualty_allocated_report";
        $this->data['menu'] = "staff_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Facualty Allocated Report";
        // $this->data['breadcrumb'] = "Facualty Allocated Report";
        $this->data['menu_item'] = "facualty-allocated-report";
        // $this->data['batchArr']=$this->Report_model->get_batch_schedule_report();/
        // show($this->data['batchArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function search_faculty_allocation() {
        $html = '<thead>
                    <tr>
                        <th width="50">'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('batch').'</th>
                        <th>'.$this->lang->line('centre').'</th>
                        <th>'.$this->lang->line('date').'</th>
                        <th>'.$this->lang->line('start_time').'</th>
                        <th>'.$this->lang->line('end_time').'</th> 
                        <th>'.$this->lang->line('module_name').'</th>
                        <th>'.$this->lang->line('status').'</th>
                    </tr>
                </thead><tbody>';
        if($_POST) {
            $faculty_id = $this->input->post('faculty_id');
            $batch_id = $this->input->post('batch_id');
            $status = $this->input->post('status');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $where = array();
            if($status !=""){    
               $where['am_schedules.class_taken'] = $status;
            }
            if($start_date !=""){
                $where['am_schedules.schedule_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_schedules.schedule_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($faculty_id != ""){
                $where['am_schedules.staff_id'] = $faculty_id;
            }
            if($batch_id != ""){
                $where['am_batch_center_mapping.batch_id'] = $batch_id;
            }
            $data = $this->Report_model->get_faculty_schedule_report($where);
            // show($data);
            // show($this->db->last_query());
            if(!empty($data))
            { $i=1;
                foreach($data as $row) {
                    $html .= '<tr>
                        <td>'.$i.'</td>
                        <td>'.$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id'])).'</td>
                        <td>'.$row['institute_name'].'</td>
                        <td>'.date('d-m-Y',strtotime($row['schedule_date'])).'</td>
                        <td>'.date("g:i a", strtotime($row['schedule_start_time'])).'</td>
                        <td>'.date("g:i a", strtotime($row['schedule_end_time'])).'</td>
                        <td>'.$this->common->get_module_fromschedule_idname_by_id($row['module_id']).'</td>
                        <td>';
                            if($row['class_taken'] == 1){
                                $html .= 'Completed';
                            }else{
                                $html .= 'Pending';
                            }
                    $html .= '</td>
                    </tr>';
                    $i++; 
                }
                $html .= '</tbody>';
            }
        }
        echo $html;
    }

    public function export_faculty_report() { 
        if($_POST) {
            $faculty_id=$this->input->post('faculty_id');
            $batch_id=$this->input->post('batch_id');
            $status=$this->input->post('status');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $type=$this->input->post('type');
            // show($type);
            $where = array();
            if($status !=""){    
               $where['am_schedules.class_taken'] = $status;
            }
            if($start_date !=""){
                $where['am_schedules.schedule_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_schedules.schedule_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($faculty_id != ""){
                $where['am_schedules.staff_id'] = $faculty_id;
            }
            if($batch_id != ""){
                $where['am_batch_center_mapping.batch_id'] = $batch_id;
            }
            $data['report'] = $this->Report_model->get_faculty_schedule_report($where);
            // show($this->db->last_query());
            if(!empty($data['report'])){
                if($type == 'pdf'){
                    $filename      = 'faculty_report-'.date('Ymd').'.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/faculty_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    // $pdf->SetHeader('Content-Type: application/pdf');
                    $pdf->SetFooter('<div style="text-align:center;"></div></body>
                    </html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('p');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'faculty_report-'.date('Ymd').'.xlsx';
                    $this->load->library('excel');
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->lang->line('sl_no'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $this->lang->line('batch'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', $this->lang->line('centre'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', $this->lang->line('date'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', $this->lang->line('start_time'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', $this->lang->line('end_time'));           
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', $this->lang->line('module_name'));           
                    $objPHPExcel->getActiveSheet()->SetCellValue('H1', $this->lang->line('status'));
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['report'] as $row) { if($row['schedule_type'] == 1) $type = 'Exam'; else $type = 'Class';
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $batch = $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $batch);
                        $objPHPExcel->getActiveSheet()->SetCellValue('c' . $rowCount, $row['institute_name']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, date('d-m-Y',strtotime($row['schedule_date'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, date("g:i a", strtotime($row['schedule_start_time'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, date("g:i a", strtotime($row['schedule_end_time'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->common->get_module_fromschedule_idname_by_id($row['module_id']));
                        if($row['class_taken'] == 1){
                            $status = 'Completed';
                        }else{
                            $status = 'Pending';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $status);
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/facualty-allocated-report'); 
            }
        }
    }

    public function staff_leave_report(){
        check_backoffice_permission('staff_leave_report');
        $this->data['page'] = "admin/staff_leave_report";
		$this->data['menu'] = "staff_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Staff Leave Report";
        $this->data['menu_item'] = "staff-leave-report";
        $this->data['staff'] = $this->Report_model->get_staff();
        // show($this->data['staff']);
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function search_leave() {
        $html = '<thead><tr>
                    <th>'.$this->lang->line('sl_no').'</th>
                    <th>'.$this->lang->line('staff').'</th>';
                    $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
                    foreach($leaveHeads as $head){
                        $html .= '<th>'.$head['head'].'</th>';
                    }
        $html .= '<th>'.$this->lang->line('total').'</th>';
                $html .= '</tr>
                        </thead><tbody>';
        if($_POST) {
            $faculty_id = $this->input->post('faculty_id');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $where = array();
            if($start_date !=""){
                $start_date = date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $end_date = date('Y-m-d',strtotime($end_date));
            }
            if($faculty_id != ""){
                $where['am_staff_personal.personal_id'] = $faculty_id;
            }
            $data = $this->Report_model->get_staffSearch($where);
            // show($this->db->last_query());
            if(!empty($data))
            { $i=1;
                foreach($data as $row) {
                    $html .= '<tr> 
                                <td>'.$i.'</td>
                                <td>'.$row['name'].'</td>';
                                $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
                                    foreach($leaveHeads as $head){
                                        $html .= '<td>'.$this->common->get_leaveBystaff($row['personal_id'], $head['id'], $start_date, $end_date).'</td>';
                                    }
                    $html .= '<td>'.$this->common->get_leaveBystaff_total($row['personal_id'], $start_date, $end_date).'</td>';
                    $html .= '</tr>';
                    $i++; 
                }
                $html .= '</tbody>';
            }
        }
        echo $html;
    }
    public function export_leave_report() {
        if($_POST) {
            $faculty_id=$this->input->post('faculty_id');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $type=$this->input->post('type');
            // show($type);
            $where = array();
            if($start_date !=""){
                $start_date = date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $end_date = date('Y-m-d',strtotime($end_date));
            }
            if($faculty_id != ""){
                $where['am_staff_personal.personal_id'] = $faculty_id;
            }
            $data['report'] = $this->Report_model->get_staffSearch($where);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            // show($this->db->last_query());
            if(!empty($data['report'])){
                if($type == 'pdf'){
                    $filename      = 'leave_report-'.date('Ymd').'.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/leave_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    // $pdf->SetHeader('Content-Type: application/pdf');
                    $pdf->SetFooter('<div style="text-align:center;"></div></body>
                    </html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('p');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'faculty_report-'.date('Ymd').'.xlsx';
                    $letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    $this->load->library('excel');
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->lang->line('sl_no'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $this->lang->line('staff'));
                    $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
                    $key = 2;
                    foreach($leaveHeads as $head){
                        $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key].'1', $head['head']);
                        $key++;
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key].'1', $this->lang->line('total'));
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['report'] as $row) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['name']);
                        $key = 2;
                        foreach($leaveHeads as $head){
                            $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key] . $rowCount, $this->common->get_leaveBystaff($row['personal_id'], $head['id'],$start_date,$end_date));
                            $key++;
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key] . $rowCount, $this->common->get_leaveBystaff_total($row['personal_id'],$start_date,$end_date));
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }
        }
    }

    public function exam_schedule_report(){
        check_backoffice_permission('exam_schedule_report');
        $this->data['page'] = "admin/exam_schedule_report";
		$this->data['menu'] = "schedule_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Exam Schedule Report";
        $this->data['menu_item'] = "exam-schedule-report";
        $this->data['batchArr']=$this->Report_model->get_exam_schedule_report();
        // show($this->data['batchArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function search_exam() {
        $html = '<thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('batch').'</th>
                        <th>'.$this->lang->line('exam_name').'</th>
                        <th>'.$this->lang->line('date').'</th>
                        <th>'.$this->lang->line('start_time').'</th>
                        <th>'.$this->lang->line('end_time').'</th> 
                        <th>'.$this->lang->line('status').'</th>
                    </tr>
                </thead><tbody>';
        if($_POST) {
            $batch_id = $this->input->post('batch_id');
            $status = $this->input->post('status');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $where = array();
            if($status !=""){    
               $where['gm_exam_schedule.status'] = $status;
            }
            if($start_date !=""){
                $where['am_schedules.schedule_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_schedules.schedule_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($batch_id != ""){
                $where['am_batch_center_mapping.batch_id'] = $batch_id;
            }
            $data = $this->Report_model->search_exam($where);
            // show($data);
            if(!empty($data))
            { $i=1;
                foreach($data as $row) {
                    $html .= '<tr>
                        <td>'.$i.'</td>
                        <td>'.$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id'])).'</td>
                        <td>'.$row['examName'].'</td>
                        <td>'.date('d-m-Y',strtotime($row['schedule_date'])).'</td>
                        <td>'.date("g:i a", strtotime($row['schedule_start_time'])).'</td>
                        <td>'.date("g:i a", strtotime($row['schedule_end_time'])).'</td>
                        <td>';
                            if($row['st'] == 0){
                                $html .= 'CREATED';
                            }else if($row['st'] == 1){
                                $html .= 'SCHEDULED';
                            }else if($row['st'] == 2){
                                $html .= 'STARTED';
                            }else if($row['st'] == 3){
                                $html .= 'FINISHED';
                            }else if($row['st'] == 4){
                                $html .= 'RESULT PUBLISHED';
                            }else if($row['st'] == 5){
                                $html .= 'CLOSED';
                            }
                    $html .= '</td>
                    </tr>';
                    $i++; 
                }
                $html .= '</tbody>';
            }
        }
        echo $html;
    }
    public function export_exam_report() {
        if($_POST) {
            $batch_id=$this->input->post('batch_id');
            $status=$this->input->post('status');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $type1=$this->input->post('type1');
            $where = array();
            if($status !=""){    
               $where['gm_exam_schedule.status'] = $status;
            }
            if($start_date !=""){
                $where['am_schedules.schedule_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_schedules.schedule_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($batch_id != ""){
                $where['am_batch_center_mapping.batch_id'] = $batch_id;
            }
            $data['report'] = $this->Report_model->search_exam($where);
            // show($data['report']);
            if(!empty($data['report'])){
                if($type1 == 'pdf'){
                    $filename      = 'batch_exam_report.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/batch_exam_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    // $pdf->SetHeader('Content-Type: application/pdf');
                    $pdf->SetFooter('<div style="text-align:center;"></div></body>
                    </html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('p');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'batch_report-'.date('Ymd').'.xlsx';
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->lang->line('sl_no'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $this->lang->line('batch'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', $this->lang->line('exam_name'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', $this->lang->line('date'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', $this->lang->line('start_time'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', $this->lang->line('end_time'));         
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', $this->lang->line('status'));     
                    // set Row
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['report'] as $row) { if($row['schedule_type'] == 1) $type = 'Exam'; else $type = 'Class';
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $batch = $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $batch);
                        $subject = $row['examName'];
                        $objPHPExcel->getActiveSheet()->SetCellValue('c' . $rowCount, $subject);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, date('d-m-Y',strtotime($row['schedule_date'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, date("g:i a", strtotime($row['schedule_start_time'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, date("g:i a", strtotime($row['schedule_end_time'])));
                        if($row['st'] == 0){
                            $status = 'CREATED';
                        }else if($row['st'] == 1){
                            $status = 'SCHEDULED';
                        }else if($row['st'] == 2){
                            $status = 'STARTED';
                        }else if($row['st'] == 3){
                            $status = 'FINISHED';
                        }else if($row['st'] == 4){
                            $status = 'RESULT PUBLISHED';
                        }else if($row['st'] == 5){
                            $status = 'CLOSED';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $status);
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/exam-schedule-report'); 
            }
        }
    }

    public function exam_avgmark_report(){
        check_backoffice_permission('exam_avgmark_report');
        $this->data['page'] = "admin/exam_avgmark_report";
		$this->data['menu'] = "exam_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Exam Mark Report";
        $this->data['menu_item'] = "exam-avgmark-report";
        // show($this->data['batchArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function get_exam(){
        $batchId = $this->input->post('batch_id');
        $subjectArr = $this->Report_model->get_exam($batchId);
        // show($subjectArr);
        $html = '<option value="">'.$this->lang->line("select").'</option>';
        if(!empty($subjectArr)){
             foreach($subjectArr as $row){
                $html .= '<option value="'.$row["examId"].'">'.$row["examName"].'</option>';
            }
        }
        echo $html;
    }

    public function get_atmt(){
        $examId = $this->input->post('exam_id');
        $sectionArr = $this->Report_model->get_atmt($examId);
        $html = '<option value="">'.$this->lang->line("select").'</option>';
        if(!empty($sectionArr)){
             foreach($sectionArr as $row){
                $html .= '<option value="'.$row["attempt"].'">'.$row["attempt"].'</option>';
            }
        }
        echo $html;
    }

    // public function get_section(){
    //     $examId = $this->input->post('exam_id');
    //     $sectionArr = $this->Report_model->get_section($examId);
    //     $html = '<option value="all">'.$this->lang->line("select").'</option>';
    //     if(!empty($sectionArr)){
    //          foreach($sectionArr as $row){
    //             $html .= '<option value="'.$row["sectionId"].'">'.$row["sectionName"].'</option>';
    //         }
    //     }
    //     echo $html;
    //}

    public function search_section_mark() {
        if($_POST) {
            $filter_exam = $this->input->post('filter_exam');
            $html = '<table id="studentlist_table1" class="table table-striped table-sm" style="width:100%"><thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('student_name').'</th>
                        <th>'.$this->lang->line('exam_name').'</th>
                        <th>'.$this->lang->line('attempt').'</th>';
                        $section = $this->Report_model->get_sectionTH($filter_exam);
                        foreach($section as $head){
                            $html .= '<th>'.$head['sectionName'].'</th>';
                        }
            $html .= '<th>'.$this->lang->line('mark').'</th>
                        <th>'.$this->lang->line('percentage').'(%)</th>
                        <th>'.$this->lang->line('percentile_score').'(%)</th>
                    </tr>
                </thead><tbody>';
            $data = $this->Report_model->search_section_mark($filter_exam, $section);
            // show($data);
            if(!empty($data))
            { $ii=1;
                foreach($data as $row) {
                    $html .= '<tr>
                        <td>'.$ii.'</td>
                        <td>'.$this->common->get_name_by_id('am_students','name',array("student_id"=>$row['student_id'])).'</td>
                        <td>'.$this->common->get_name_by_id('gm_exam_schedule','name',array("id"=>$row['exam_id'])).'</td>
                        <td>'.$row['attempt'].'</td>';
                        $section = $this->Report_model->get_sectionTH($filter_exam);
                        foreach($section as $head){
                            $html .= '<td>'.$row[$head['sectionName']].'</td>';
                        }
                    $html .= '<td>'.$row['total'].'</td>
                        <td>'.$row['percentage'].'</td>
                        <td>'.$row['per'].'</td>
                    </tr>';
                    $ii++; 
                }
                $html .= '</tbody></table>';
            }
        }
        echo $html;
    }

    public function export_section_mark() {
        if($_POST) {
            $exam=$this->input->post('exam');
            $type=$this->input->post('type');
            $section = $this->Report_model->get_sectionTH($exam);
            $data['report'] = $this->Report_model->search_section_mark($exam,$section);
            $data['section'] = $section;
            if(!empty($data['report'])){
                if($type == 'pdf'){
                    $filename      = 'batch_section_mark_report.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/batch_section_mark_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    // $pdf->SetHeader('Content-Type: application/pdf');
                    $pdf->SetFooter('<div style="text-align:center;"></div></body>
                    </html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('p');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    $filename      = 'batch_report-'.date('Ymd').'.xlsx';
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->lang->line('sl_no'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $this->lang->line('student_name'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', $this->lang->line('exam_name'));
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', $this->lang->line('attempt'));
                    $key = 4;
                    $section = $this->Report_model->get_sectionTH($exam);
                    foreach($section as $head){
                        $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key].'1', $head['sectionName']);
                        $key++;
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key].'1', $this->lang->line('mark'));
                    $objPHPExcel->getActiveSheet()->SetCellValue($letters[++$key].'1', $this->lang->line('percentage').'(%)');     
                    $objPHPExcel->getActiveSheet()->SetCellValue($letters[++$key].'1', $this->lang->line('percentile_score').'(%)');     
                    // set Row
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['report'] as $row) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $this->common->get_name_by_id('am_students','name',array("student_id"=>$row['student_id'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('c' . $rowCount, $this->common->get_name_by_id('gm_exam_schedule','name',array("id"=>$row['exam_id'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['attempt']);
                        $key = 4;
                        foreach($section as $head){
                            $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key] . $rowCount, $row[$head['sectionName']]);
                            $key++;
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($letters[$key] . $rowCount, $row['total']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($letters[++$key] . $rowCount, $row['percentage']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($letters[++$key] . $rowCount, $row['per']);
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/exam-avgmark-report'); 
            }
        }
    }
// conineu

    public function center_wise_fee_report(){
        check_backoffice_permission('center_wise_fee_report');
        $this->data['page'] = "admin/center_wise_fee_report";
		$this->data['menu'] = "fee_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Center Wise Fee Report";
        $this->data['menu_item'] = "center-wise-fee-report";
        // show($this->data['batchArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function get_cource(){
        $centreId = $this->input->post('centreId');
        // show($centreId);
        $subjectArr = $this->Report_model->get_cource($centreId);
        // show($subjectArr);
        $html = '<option value="">'.$this->lang->line("select").'</option>';
        if(!empty($subjectArr)){
             foreach($subjectArr as $row){
                $html .= '<option value="'.$row["class_id"].'">'.$row["class_name"].'</option>';
            }
        }
        echo $html;
    }

    public function get_batch(){
        $courseId = $this->input->post('courseId');
        $subjectArr = $this->Report_model->get_batch($courseId);
        // show($this->db->last_query());
        $html = '<option value="">'.$this->lang->line("select").'</option>';
        if(!empty($subjectArr)){
             foreach($subjectArr as $row){
                $html .= '<option value="'.$row["batch_id"].'">'.$row["batch_name"].'</option>';
            }
        }
        echo $html;
    }

    public function search_centre() {
        if($_POST) {
            $centreId = $this->input->post('centre_id');
            $courseId = $this->input->post('course_id');
            $courseorbatch = $this->input->post('courseorbatch');
            if($courseorbatch == 1){
                $batchId = $this->input->post('batch_id');
            }
            if($courseorbatch == 1){
                if($courseId != ""){
                    $where['am_institute_course_mapping.course_master_id'] = $courseId;
                }
                if($batchId !=""){
                    $where['am_batch_center_mapping.batch_id'] = $batchId;
                }
            }else{
                if($centreId !="all"){    
                    $where['am_institute_course_mapping.institute_master_id'] = $centreId;
                }
                if($courseId != ""){
                    $where['am_institute_course_mapping.course_master_id'] = $courseId;
                }
            }
            $data = $this->Report_model->search_centre($where, $courseorbatch);
            $html = '<thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>';
                        if($courseorbatch == 1){
                            $html .= 'Batch Name';
                        }else{
                            $html .= 'Course Name';
                        }
            $html .= '</th>
                        <th class="text-right">Total Fee Collected</th>
                        <th class="text-right">Cash</th>
                        <th class="text-right">Card</th>
                        <th class="text-right">Cheque</th>
                        <th class="text-right">Online</th>
                    </tr> 
                </thead>
                <tbody>';
            if(!empty($data)){ 
                $totalFeeCollected = $Cash = $Card = $Cheque = $Online = 0;
                $i=1;
                foreach($data as $row) {
                    $totalFeeCollected += $row['total_fee_collected'];
                    $Cash += $row['Cash'];
                    $Card += $row['Card'];
                    $Cheque += $row['Cheque'];
                    $Online += $row['Online'];
                    $html .= '<tr>
                            <td>'.$i.'</td>';
                            if($courseorbatch == 1){
                                $html .= '<td>'.$row['batch_name'].'</td>';
                            }else{
                                $html .= '<td>'.$row['class_name'].'</td>';
                            }
                    $html .= '<td class="text-right">'.numberformat($row['total_fee_collected']).'</td>
                            <td  class="text-right">'.numberformat($row['Cash']).'</td>
                            <td  class="text-right">'.numberformat($row['Card']).'</td>
                            <td  class="text-right">'.numberformat($row['Cheque']).'</td>
                            <td  class="text-right">'.numberformat($row['Online']).'</td>
                        </tr>';
                    $i++; 
                }
                $html .= '<tr>
                            <th>#</th>
                            <th>Total</th>
                            <th class="text-right">'.numberformat($totalFeeCollected).'</td>
                            <th class="text-right">'.numberformat($Cash).'</th>
                            <th class="text-right">'.numberformat($Card).'</th>
                            <th class="text-right">'.numberformat($Cheque).'</th>
                            <th class="text-right">'.numberformat($Online).'</th>
                        </tr>';
                $html .= '</tbody>';
            }else{
                $html .= '<tr>
                            <td rowspan=6>
                                No records available
                            </td>
                        </tr>';
            }
        }
        echo $html;
    }

    public function export_fee_centre_report() {
        if($_POST) {
            $centreId=$this->input->post('centre_id');
            $courseId=$this->input->post('course_id');
            $courseorbatch=$this->input->post('courseorbatch');
            if($courseorbatch == 1){
                $batchId=$this->input->post('batch_id');
            }
            $type=$this->input->post('type');
            $where = array();
            if($courseorbatch == 1){
                if($courseId != ""){
                    $where['am_institute_course_mapping.course_master_id'] = $courseId;
                }
                if($batchId !=""){
                    $where['am_batch_center_mapping.batch_id'] = $batchId;
                }
            }else{
                if($centreId !="all"){    
                    $where['am_institute_course_mapping.institute_master_id'] = $centreId;
                }
                if($courseId != ""){
                    $where['am_institute_course_mapping.course_master_id'] = $courseId;
                }
            }
            $data['report'] = $this->Report_model->search_centre($where, $courseorbatch);
            $data['courseorbatch'] = $courseorbatch;
            // show($this->db->last_query());
            if(!empty($data['report'])){
                if($type == 'pdf'){
                    $filename      = 'centre_wise_fee_report.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/centre_wise_fee_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    // $pdf->SetHeader('Content-Type: application/pdf');
                    $pdf->SetFooter('<div style="text-align:center;"></div></body>
                    </html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('p');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'batch_report-'.date('Ymd').'.xlsx';
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $this->lang->line('sl_no'));
                    if($courseorbatch == 1){ $name = 'Batch Name'; }else{ $name = 'Course Name'; }
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', $name);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Total Fee Collected');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Cash');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Card');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Cheque');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Online');
                    // set Row
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['report'] as $row) { 
                        $totalFeeCollected += $row['total_fee_collected'];
                        $Cash += $row['Cash'];
                        $Card += $row['Card'];
                        $Cheque += $row['Cheque'];
                        $Online += $row['Online'];
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        if($courseorbatch == 1){ $name = $row['batch_name']; }else{ $name = $row['class_name']; }
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $name);
                        $objPHPExcel->getActiveSheet()->SetCellValue('c' . $rowCount, numberformat($row['total_fee_collected']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, numberformat($row['Cash']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, numberformat($row['Card']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, numberformat($row['Cheque']));
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, numberformat($row['Online']));
                        $rowCount++;
                        $j++;
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, '#');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total');
                    $objPHPExcel->getActiveSheet()->SetCellValue('c' . $rowCount, numberformat($totalFeeCollected));
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, numberformat($Cash));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, numberformat($Card));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, numberformat($Cheque));
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, numberformat($Online));
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/center-wise-fee-report'); 
            }
        }
    }

    public function student_attendance_report(){
        check_backoffice_permission('student_attendance_report');
        $this->data['page'] = "admin/student_attendance_report";
		$this->data['menu'] = "student_reports";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Student Attendance Report";
        $this->data['menu_item'] = "student-attendance-report";
        // show($this->data['batchArr']);
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function get_student(){
        $batchId = $this->input->post('batch_id');
        $studentArr = $this->Report_model->get_student($batchId);
        $html = '<option value="">'.$this->lang->line("select").'</option>';
        if(!empty($studentArr)){
             foreach($studentArr as $row){
                $html .= '<option value="'.$row["student_id"].'">'.$row["name"].' ('.$row["registration_number"].')</option>';
            }
        }
        echo $html;
    }

    public function search_students_attendance() {
        $html = '<thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('student').'</th>
                        <th>'.$this->lang->line('subjectorexam').'</th>
                        <th>'.$this->lang->line('attendance').'</th>
                        <th>'.$this->lang->line('staff').'</th>
                        <th>'.$this->lang->line('date').'</th>
                        <th>'.$this->lang->line('type').'</th>
                    </tr>
                </thead>';
        if($_POST) {
            $batch_id = $this->input->post('batch_id');
            $student = $this->input->post('student');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $att_type = $this->input->post('att_type');
            $where = array();
            if($batch_id != ""){
                $where['am_attendance.batch_id'] = $batch_id;
            }
            if($student !=""){    
               $where['am_attendance.student_id'] = $student;
            }
            if($start_date !=""){
                $where['am_attendance.att_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_attendance.att_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($att_type !=""){
                $where['am_attendance.type'] = $att_type;
            }
            $data = $this->Report_model->get_student_attendance_report($where, $att_type);
            // show($data);
            // show($this->db->last_query());
            if(!empty($data))
            { $i=1;
                foreach($data as $row) {
                    $html .= '<tr>
                        <td width="8%">'.$i.'</td>
                        <td>'.$row['name'].'</td>
                        <td>';
                            if($att_type == 'class') {
                                $html .= $this->common->get_module_fromschedule_idname_by_id($row['module_id']).'</td>';}
                            else { $html .=$row['examName'].'</td>';}
                        if($row['attendance'] == 1){$attendance = 'P';} else { $attendance = 'A'; }
                    $html .= '<td>'.$attendance.'</td>
                        <td>';
                        if($att_type == 'class') {
                            $html .= $this->common->get_name_by_id('am_staff_personal','name',array('personal_id'=>$row['staff_id']));
                        }else{
                            $html .='';
                        }
                    $html .= '</td>
                        <td>'.date('d-m-Y',strtotime($row['att_date'])).'</td>
                        <td>'.ucfirst($row['type']).'</td>
                        </tr>';
                    $i++; 
                }
                $html .= '</tbody>';
            }
        }
        echo $html;
    }

    public function export_student_attendance_report() {
        if($_POST) {
            $student_id=$this->input->post('student_id');
            $batch_id=$this->input->post('batch_id');
            $att_type=$this->input->post('att_type');
            $start_date=$this->input->post('start_date');
            $end_date=$this->input->post('end_date');
            $type=$this->input->post('type');
            $where=array();
            if($batch_id != ""){
                $where['am_attendance.batch_id'] = $batch_id;
            }
            if($student_id !=""){    
               $where['am_attendance.student_id'] = $student_id;
            }
            if($start_date !=""){
                $where['am_attendance.att_date>=']=date('Y-m-d',strtotime($start_date));
            }
            if($end_date !=""){
                $where['am_attendance.att_date<=']=date('Y-m-d',strtotime($end_date));
            }
            if($att_type !=""){
                $where['am_attendance.type'] = $att_type;
            }
            $data['studentArr']=$this->Report_model->get_student_attendance_report($where, $att_type);
            $data['att_type'] = $att_type;
            // show($data['studentArr']);
            if(!empty($data['studentArr'])){
                if($type == 'pdf'){
                    $filename      = 'students_report.pdf';
                    $pdfFilePath = FCPATH."/uploads/".$filename; 
                    $html = $this->load->view('admin/pdf/student_attendance_report',$data,TRUE);
                    //  echo $html;die();
                    ini_set('memory_limit','512M'); // boost the memory limit if it's low ;)
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load();
                    $pdf->SetWatermarkText('Direction');
                    $pdf->watermark_font = 'DejaVuSansCondensed';
                    $pdf->showWatermarkText = true;
                    $pdf->watermarkTextAlpha = 0.2;
                    $pdf->SetHeader();
                    $pdf->SetFooter('<div style="text-align:center;"></div></body></html>'); // Add a footer for good measure ;)
                    $pdf->AddPage('P');
                    $pdf->WriteHTML($html); // write the HTML into the PDF
                    //$pdf->WriteHTML('Hello World');
                    $pdf->Output($filename, "D"); // save to file because we can
                }else{
                    $filename      = 'students_attendance_report-'.date('Ymd').'.xlsx';
                    $this->load->library('excel');
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->setActiveSheetIndex(0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sl.No.');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Student');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Subject / Exam');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Attendance');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Staff');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Date');       
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Type');     
                    // set Row
                    $rowCount = 2;
                    $j = 1;
                    foreach ($data['studentArr'] as $row) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $j);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['name']);
                        if($att_type == 'class') {
                            $suborExam= $this->common->get_module_fromschedule_idname_by_id($row['module_id']);
                        }else { $suborExam= $row['examName'];}
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $suborExam);
                        if($row['attendance'] == 1){$att = 'P';} else { $att = 'A'; }
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $att);
                        if($att_type == 'class'){
                            if($this->common->get_name_by_id('am_staff_personal','name',array('personal_id'=>$row['staff_id']))){
                                $stafName = $this->common->get_name_by_id('am_staff_personal','name',array('personal_id'=>$row['staff_id']));
                            }else{
                                $stafName = '';
                            }
                        }else{
                            $stafName = '';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $stafName);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, date('d-m-Y',strtotime($row['att_date'])));
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, ucfirst($row['type']));
                        $rowCount++;
                        $j++;
                    }
                    
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=".$filename);
                    header("Cache-Control: max-age=0");
                    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    $objWriter->save(FCPATH.'uploads/samples/'.$filename);
                    redirect(base_url('uploads/samples/'.$filename));
                }
            }else{
                $this->session->set_flashdata('item','No records found..!'); 
                redirect('backoffice/student-attendance-report'); 
            }
        }
    }


    public function application_log(){
        check_backoffice_permission('application_log');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->data['page'] = "admin/application_log";
		$this->data['menu'] = "application_log";
        $this->data['breadcrumb'][0]['name']="Report";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/report');
        $this->data['breadcrumb'][1]['name']="Application Log";
        $this->data['menu_item'] = "application-log";
        // Pagination
        $config = array();
        $config["base_url"]     = base_url() . "backoffice/application-log";
        $config["total_rows"]   = $this->Report_model->get_application_logcount();
        $config["per_page"]     = 25;
        $config["uri_segment"]  = 3;
        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->data["slno"]     = $this->uri->segment(3)+1;
        $this->data["links"]    = $this->pagination->create_links();
        $this->data['list']     = $this->Report_model->get_application_log($config["per_page"], $page);
		$this->load->view('admin/layouts/_master',$this->data);
    }

}
?>
