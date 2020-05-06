<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $module="question";
        check_backoffice_permission($module);
        $this->load->model('question_model');
    }
    
    public function index(){
		$this->data['page']="admin/questions";
		$this->data['menu']="question";
        $this->data['breadcrumb']="Questions";
		$this->data['school']=$this->question_model->get_School();
		$this->data['question_details']=$this->question_model->get_questions();
		$this->load->view('admin/layouts/_master.php',$this->data); 
    }
    
    public function question_upload(){
        if($_POST){
            
            if($_FILES['question']['name']!= "")
            {
                
                $allowed =  array('xls','xlsx','csv','ods');
                $filename = $_FILES['question']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    $data['st']=2;
                    print_r(json_encode($data));
                    return false;
                }
            }
           
            
            $school_name=$_POST['school_name'];
        
            $config['upload_path']   = FCPATH . 'uploads/';
            $config['allowed_types'] = 'xls|xlsx|csv|ods';
            $config['max_size']      = '5000';
            $file_name               = $_FILES['question']['name']; //uploded file name
            $allowed                 = explode('|', $config['allowed_types']);
            $ext                     = pathinfo($file_name, PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["question"]["tmp_name"], '././uploads/' . $file_name);
            $this->load->library('upload', $config);
            $this->load->library('excel');
            
            $spreadsheet = $this->excel->read($config['upload_path'].$file_name);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
            //  Get worksheet dimensions
            $sheet = $spreadsheet->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            if($highestRow >1){
            for ($i = 2; $i <= $highestRow; $i++){
                $question_serial_no  = $sheet->getCellByColumnAndRow(1, $i)->getValue();
                $question            = $sheet->getCellByColumnAndRow(2, $i)->getValue();
                $question_option_a   = $sheet->getCellByColumnAndRow(3, $i)->getValue();
                $question_option_b   = $sheet->getCellByColumnAndRow(4, $i)->getValue();
                $question_option_c   = $sheet->getCellByColumnAndRow(5, $i)->getValue();
                $question_option_d   = $sheet->getCellByColumnAndRow(6, $i)->getValue();
                $answer              = $sheet->getCellByColumnAndRow(7, $i)->getValue();
                   
               //validation
                  if($question_serial_no=="" || $question=="" || $question_option_a=="" || $question_option_b=="" || $question_option_c=="" || $question_option_d=="" || $answer=="") 
                  {
                                         
                       $data['st']=0; 
                       $data['msg']="Some data in row number ".$i."  is empty..!"; 
                       print_r(json_encode($data));
                       return false; 
                  }
                 }
            for ($i = 2; $i <= $highestRow; $i++){
                $question_serial_no  = $sheet->getCellByColumnAndRow(1, $i)->getValue();
                $question            = $sheet->getCellByColumnAndRow(2, $i)->getValue();
                $question_option_a   = $sheet->getCellByColumnAndRow(3, $i)->getValue();
                $question_option_b   = $sheet->getCellByColumnAndRow(4, $i)->getValue();
                $question_option_c   = $sheet->getCellByColumnAndRow(5, $i)->getValue();
                $question_option_d   = $sheet->getCellByColumnAndRow(6, $i)->getValue();
                $answer              = $sheet->getCellByColumnAndRow(7, $i)->getValue();
               
                //insert
             if($question_serial_no!="" && $question!="" && $question_option_a!="" && $question_option_b!="" && $question_option_c!="" && $question_option_d!="" && $answer!="") {
                $question_data     = array(
                    'question_serialno' => $question_serial_no,
                    'school_id' => $school_name,
                    'question' => $question,
                    'question_option_a' => $question_option_a,
                    'question_option_b' => $question_option_b,
                    'question_option_c' => $question_option_c,
                    'question_option_d' => $question_option_d,
                    'answer' => $answer,
                );
                 $data['st']= $this->question_model->insert_question_paper($question_data);
                 $what=$this->db->last_query();
                 $table_row_id=$this->db->insert_id();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'database', $who, $what, $table_row_id, 'am_questions', 'New questions uploaded');
            }
            else
            {
                $data['st']=3; 
                print_r(json_encode($data));
                return false;
            }
            }  
            }
            else
            {
              $data['st']=3;   
            }
        
        }
        else
        {
            $data['st']=0;
        }
        print_r(json_encode($data));
    }

    public function question_delete(){
       
       $question_id= $this->input->post('subject_id');
       $res=$this->question_model->question_delete($question_id); 
        if($res){
             print_r($res);
        }
    }

    public function get_question_by_id($id)
    {
        $question=$this->question_model->get_question_by_id($id);
        print_r(json_encode($question));
    }
    
    public function edit_question()
    {
         $id=$this->input->post('question_id');
         unset($_POST['question_id']);
         $result['res']=$this->question_model->edit_question($_POST,$id);
            if($result['res'])
            {
                $result['question']=$this->question_model->get_question_by_id($id);
            }
         print_r(json_encode($result));
    }
    
    
    public function sample_questions_ajax()
    {
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

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
         $columns_valid = array(
            "am_questions.question_id", 
            "am_questions.school_id", 
            "am_questions.question_serialno", 
            "am_questions.question"
         );

         if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        
            $list = $this->question_model->sample_questions_ajax($start, $length, $order, $dir);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {

            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['school_name'];
            $row[] = $rows['question_serialno'];
            $row[] = $rows['question'];
            $row[] = '<a class="btn btn-default option_btn" title="Edit" onclick="get_question('.$rows['question_id'].')"><i class="fa fa-pencil icon"></i></a> <a class="btn btn-default option_btn" title="Delete" onclick="delete_question('.$rows['question_id'].')"><i class="fa fa-trash-o"></i></a>';
            $data[] = $row;
        }

        $total_rows=$this->question_model->getNum_sample_questions_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }
    
    public function refresh_question_ajax()
    {
        
       $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('school').'</th>
                        <th>Question Paper Serial No</th>
                        <th>'.$this->lang->line('question').'</th>
                        <th>'.$this->lang->line('action').'</th>
                        </tr>
                </thead>';
       $question_details=$this->question_model->get_questions(); 
        if(!empty($question_details))
        {   $i=1;
            foreach($question_details as $row)
            { 
                $html.='<tr>
                <td>'.$i.'</td>
                <td>'.$row['school_name'].'</td>
                <td>'.$row['question_serialno'].'</td>
                <td>'.$row['question'].'</td>
                <td><a class="btn btn-default option_btn" title="Edit" onclick="get_question('.$row['question_id'].')"><i class="fa fa-pencil icon"></i></a> <a class="btn btn-default option_btn" title="Delete" onclick="delete_question('.$row['question_id'].')"><i class="fa fa-trash-o"></i></a></td>
                
                </tr>';
                $i++;
            }
        }
        echo $html;
    }
}
?>
