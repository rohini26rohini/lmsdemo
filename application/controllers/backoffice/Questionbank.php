<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questionbank extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        $module="material_management";
        check_backoffice_permission($module);
        $this->load->model('questionbank_model');
    }
    
    
    public function materials(){
        check_backoffice_permission("manage_materials");
      $this->data['materialArr'] = $this->questionbank_model->get_materials(); 
      $this->data['materialtype'] =$this->questionbank_model->getall_material_type();
      $this->data['page']="admin/materialManagement/materials";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Materials";
      
      $this->data['menu_item']="materials";
      $this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function question_set(){
        check_backoffice_permission("manage_questionset");
      $this->data['questionsetArr'] = $this->questionbank_model->get_all_questionset();
      $this->data['subjectArr'] = $this->subject_model->get_full_subjects();
    
      $this->data['page']="admin/materialManagement/questionset";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/question-set');
      $this->data['breadcrumb'][1]['name']="Question Set";

      $this->data['menu_item']="questionset";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function question_bank(){
      check_backoffice_permission("manage_questionbank");
      $this->data['materials'] = $this->questionbank_model->get_question_material();
      $this->data['page']="admin/materialManagement/questionbank";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Question Bank";

      $this->data['menu_item']="questionbank";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }
    public function get_levelOne_user(){
      $html ='';
      $entityId = $this->input->post('id');
      $users = $this->questionbank_model->get_levelOne_user($entityId);
      // show($school);
      if(!empty($users)) {
              $html .='<div class="form-group">
                              <label>'.$this->lang->line("approve_users").'<span class="req redbold">*</span></label>
                              <select class="form-control" name="approve_users" id="approve_users">
                              <option value="">select</option>';
                              foreach($users as $user){
                                  $html .='<option value="'.$user->id.'">'.$user->user_name.'( '.$user->registration_number.' )</option>';
                              }
                              $html .='</select>
                          </div>';
      }else{
          $html.='<span>No Users</span>';
      }
      echo $html;
  }
    public function update_question(){
      if($_GET['qid']){
        $question_id = $this->input->get('qid');
        if(!empty($question_id)){
          $result = $this->questionbank_model->get_full_question($question_id);
          if(!empty($result)){
            $this->data['data'] = $result;
            $this->data['page']="admin/materialManagement/question_update";
            $this->data['menu']="questionbank";

            $this->data['breadcrumb'][0]['name']="Material management";
            $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
            $this->data['breadcrumb'][1]['name']="Question Bank";
            $this->data['breadcrumb'][1]['url']=base_url('backoffice/question-bank');

            $this->data['menu_item']="questionbank";
            $this->load->view('admin/layouts/_master.php',$this->data); 
          }else{
            redirect('404');
          }
        }
      }else{
        redirect('404');
      }
    }
    
    public function single(){
      $this->data['questionsets'] = $this->questionbank_model->get_questionsets();
      $this->data['page']="admin/materialManagement/single";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Non passaged questions";
      
      $this->data['menu_item']="questionbank";
      $this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function group(){
      $this->data['questionsets'] = $this->questionbank_model->get_questionsets();
      $this->data['paragraphs'] = $this->questionbank_model->get_paragraphs();
      $this->data['page']="admin/materialManagement/paragraph";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Passaged questions";
      
      $this->data['menu_item']="questionbank";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function study_material(){
      check_backoffice_permission('manage_study_material');
      $this->data['study_materials'] = $this->questionbank_model->get_study_materials();
      $this->data['page']="admin/materialManagement/study_materials";
      $this->data['menu']="questionbank";
      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Study material";
      $this->data['menu_item']="study_material";
      $this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function add_edit_study_material(){
      $this->data['subjectArr'] = $this->subject_model->get_full_subjects();
      $this->data['page']="admin/materialManagement/study_materials_add_edit";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      if(!isset($_GET['id'])){
        if(isset($_GET['material_id'])){
          // exit;
        }
        $this->data['breadcrumb'][1]['name']="Add study material";
      }else{
        $this->data['breadcrumb'][1]['name']="Edit study material";
        $study_material = $this->questionbank_model->get_study_material_details($_GET['id']);
        $this->data['study_material'] = $study_material;
        $this->data['moduleArr'] = $this->subject_model->get_allmodules_by_subjectid(array('parent_subject'=>$study_material['subject_id']));
        $this->data['materialArr'] = $this->common->get_alldata('mm_material',array("subject_id"=>$study_material['module_id'],"material_type"=>'study material'));
        // echo '<pre>';print_r($this->data);die();
      }
      
      $this->data['menu_item']="study_material";
      $this->load->view('admin/layouts/_master.php',$this->data); 
    }


/************************* AJAX CALLS *************************/

    public function save_single_question(){
      if($_POST){
        $_POST['checkQuestion'] = !is_html_empty($this->input->post('question'));//trim(trim(trim($this->input->post('question'),'&nbsp;'),'<br />'));
        $this->form_validation->set_rules(array(
          array(
            'field' => 'checkQuestion',
            'label' => 'Question',
            'rules' => 'required',
            'errors' => array(
                    'required' => 'Question is empty'
            )
          ),
          array(
            'field' => 'question_set',
            'label' => 'Question set',
            'rules' => 'required',
            'errors' => array(
                    'required' => 'Please select a question set'
            )
          )
        ));

        if(!$this->form_validation->run()){
          $returnData['st'] 		= 0;
          $returnData['message'] 	= strip_tags(validation_errors());
          print_r(json_encode($returnData));
          exit;
        }

        $question_id = $this->input->post('question_id');
        $question = array(
                        "question_set_id"=>$this->input->post('question_set'),
                        "question_content"=>$this->input->post('question'),
                        "question_solution"=>$this->input->post('solution'),
                        "question_difficulty"=>$this->input->post('difficulty'),
                        "question_type"=>$this->input->post('question_type')
                    );
        if(!empty($this->input->post('paragraph_id'))){
          $question['paragraph_id'] = $this->input->post('paragraph_id');
        }
        if(is_html_empty($this->input->post('solution'))){
          $question['question_solution'] = NULL;
        }
        
        if($question['question_type']==1){
          $optionname = $this->input->post('optionname');
          $option = $this->input->post('option');
          $answers = $this->input->post('answer');
          if(!empty($option)){
            foreach($option as $row){
              if(is_html_empty($row)){
                $returnData['st'] 		= 0;
                $returnData['message'] 	= 'Some options are empty';
                print_r(json_encode($returnData));
                exit;
              }
            }
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Please define choices';
            print_r(json_encode($returnData));
            exit;
          }
          if(empty($answers)){
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Please mention the correct answer';
            print_r(json_encode($returnData));
            exit;
          }
        }

        if($question_id){
          if($this->input->post('paragraph_id')){
            $paragraph['paragraph_content'] = $this->input->post('passage');
            $paragraph_id = $this->input->post('paragraph_id');
            $this->questionbank_model->update_passage($paragraph,$paragraph_id);
          }
          $this->questionbank_model->update_question($question,$question_id);
        }else{
          $question_id = $this->questionbank_model->insert_question($question);
        }

        if($question['question_type']==1){
          if(!empty($optionname) && !empty($option) && !empty($answers) && (count($optionname)==count($option))){
            $alphabets = alphabets();
            foreach($optionname as $key=>$val){
              $option[$key] = array(
                "option_number"=>$alphabets[$key],
                "option_content"=>$option[$key],
                "option_answer"=>0
              );
              foreach($answers as $akey=>$aval){
                if($val == $aval){
                  $option[$key]['option_answer'] = 1;
                }
              }
            }
            if($question_id){
              foreach($option as $key=>$val){
                $option[$key]['question_id'] = $question_id;
              }
              if($this->questionbank_model->insert_option($option,$question_id)){
                $returnData['st'] 		= 1;
                $returnData['message'] 	= 'Successfully saved';
              }else{
                $returnData['st'] 		= 0;
                $returnData['message'] 	= 'Sorry technical problem options not saved';
              }
            }else{
              $returnData['st'] 		= 0;
              $returnData['message'] 	= 'Sorry technical problem question not saved';
            }
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Some fields are missing';
          }
        }else{
          $returnData['st'] 		= 1;
          $returnData['message'] 	= 'Successfully saved';
        }

      }else{
				$returnData['st'] 		= 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function save_passage(){
      if($_POST){

        $this->form_validation->set_rules('question_set', 'Question set', 'required');
        $this->form_validation->set_rules('passagetype', 'Passage type', 'required');

        $question_set = $this->input->post('question_set');
        $passagetype = $this->input->post('passagetype');
        $passage_id = $this->input->post('passage_id');
        $passage = $this->input->post('passage');

        if($passagetype == 'existing'){
          $this->form_validation->set_rules('passage_id', 'Passage', 'required');
        }if($passagetype == 'new'){
          $this->form_validation->set_rules('passage', 'Passage', 'required');
        }

        if($this->form_validation->run()){

          if($passagetype == 'existing'){
            $pdata = $this->questionbank_model->get_passage($passage_id);
          }if($passagetype == 'new'){
            $pdata['paragraph_content'] = $passage;
            $pdata['question_set_id'] = $question_set;
            $pdata['paragraph_id'] = $this->questionbank_model->insert_passage($pdata);
          }
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Passage saved. You can add questions to it.';
          $returnData['data'] 		= $this->load->view('admin/materialManagement/group',$pdata,TRUE);

        }else{

          $returnData['st'] 		= 0;
          $returnData['message'] 	= validation_errors();//'All fields are mandatory';

        }

      }else{

				$returnData['st'] 		= 0;
				$returnData['message'] 	= 'Network Error';

      }
      print_r(json_encode($returnData));

    }

    public function get_passage(){
      if($_POST){
        $passage_id = $this->input->post('passage_id');
        $passage = $this->questionbank_model->get_passage($passage_id);
        $returnData['st'] 		  = 1;
        $returnData['message'] 	= '';
        if(isset($passage['paragraph_content'])){
          $returnData['data'] 		= $passage['paragraph_content'];
        }else{
          $returnData['data'] 		= '';
        }
      }else{
				$returnData['st'] 		= 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_existing_passage(){
      if($_POST){
        $this->form_validation->set_rules('question_set', 'Question set', 'required');
        if($this->form_validation->run()){
          $question_set = $this->input->post('question_set');
          $passages = $this->questionbank_model->get_question_set_passages_id($question_set);
          if(!empty($passages)){
            foreach($passages as $k=>$v){
              $passages[$k]->paragraph_content = limit_html_string($v->paragraph_content,20);
            }
          }
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Please select a passage';
          $returnData['data'] 		= $passages;
        }else{
          $returnData['st'] 		= 0;
          $returnData['message'] 	= validation_errors();
        }
      }else{
				$returnData['st'] 		= 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_module(){
      if($_POST){
        $subject = $this->input->post('subject');
        $modules = $this->questionbank_model->get_module($subject);
        $module = '<option value="">Select a module</option>';
        if(!empty($modules)){
          foreach($modules as $row){
            $module .= '<option value="'.$row->subject_id.'">'.$row->subject_name.'</option>';
          }
        }
        print_r($module);
      }
    }
    
    public function delete_material(){
      $material_id=$this->input->post('material_id');
      $returnData['st']=$this->questionbank_model->delete_material($material_id);
      print_r(json_encode($returnData));
    }
    
    public function get_material_by_id($id)
    {

       $material=$this->questionbank_model->get_material_by_id($id); 
       $materialtype =$this->questionbank_model->getall_material_type(); 
        $html1= '<option value="">Select</option>';
        if(!empty($materialtype)){
            foreach ($materialtype as $materials)
            {
                $html1.='<option value="' . $materials['material_type_name'] . '" >' . $materials['material_type_name'] . '</option>';
            }
        }
       $subArr = $this->subject_model->get_all_subjects();//all subjects and modules
        $html= '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                $html.='<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
            }
        }
        
        $subArrs = $this->subject_model->get_all_subjects_subjectype();//only subjects
         $subject_html= '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArrs as $row)
            {
                $subject_html.='<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
            }
        }
           
       $returnData['parent_subject'] = $this->common->get_parentSubject(array("subject_id"=>$material['subject_id']));
        
        $returnData['materialtype']=$html1;
        $returnData['material']=$material;
        $returnData['modules']=$html;
        $returnData['subject']=$subject_html;
        print_r(json_encode($returnData));
    }

    /*show subject or module based on the material type*/
    public function get_subjects()
    {
        
        $subArr = $this->subject_model->get_all_subjects_subjectype();//only subjects
            
        $html= '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                $html.='<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
            }
        }
        $returnData['subject']=$html;
        print_r(json_encode($returnData));
    }
    
    //show all modules under a subject
    public function get_modules()
    {
      unset($_POST['gbsplus_csrf_token']);
        if($_POST){
        //$_POST['parent_subject']=$this->input->post('subject_id'); 
        $subArr = $this->subject_model->get_allmodules_by_subjectid($_POST);
            
        $html= '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                $html.='<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
            }
        }
        $returnData['modules']=$html;
        print_r(json_encode($returnData));
        }
    }
    public function add_material(){
      if($_POST){ 
        $material_link="";
        if(!empty($_FILES['file_name']['name'])){
          $files = str_replace(' ', '_', $_FILES['file_name']);
          $config['upload_path']           = 'uploads/materials/';
          $config['allowed_types']        = 'pdf';
          $config['file_name'] =$this->input->post('material_name').'_'.time();
          $this->load->library('upload',$config);
          $this->upload->initialize($config);
          $upload = $this->upload->do_upload('file_name');
          $fileData = $this->upload->data();
          if($upload){
            $material_link = $fileData['file_name'];
          }
          if(!$upload){
            $ajaxresponse['st']=3;
            $ajaxresponse['message']='Please Choose Pdf file'; exit();
          }
        }
        $data=array(
          "material_type"=>$this->input->post('material_type'),
          "subject_id"=>$this->input->post('module_id'),
          "material_name"=>$this->input->post('material_name'),
          "material_link"=>$material_link
        );
        //check if the same data is available or not
        $material_exist = $this->questionbank_model->is_material_exist($data);
        // show($material_exist);
        if($material_exist){
          $ajaxresponse['st']=2;
          $ajaxresponse['message']='Already Exist';
          print_r(json_encode($ajaxresponse)); exit;
        }else{
          $material_id = $this->questionbank_model->add_material($data);
          if($material_id != 0){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('insert', 'database', $who, $what, $material_id, 'mm_material', 'New material name created');
            $ajaxresponse['st']=1;
            $ajaxresponse['message']='Successfully Added';
            print_r(json_encode($ajaxresponse)); exit;
          }else{
            $ajaxresponse['st']=0;
            $ajaxresponse['message']='Error Occured';
          }
        }
      }
      print_r(json_encode($ajaxresponse));
    }

    public function get_question_set_material(){
      if($_POST){
        $material = $this->input->post('material');
        $modules = $this->questionbank_model->get_question_set_material($material);
        // echo '<pre>';print_r($material);exit;
        $module = '<option value="">Select a question set</option>';
        if(!empty($modules)){
          foreach($modules as $row){
            $module .= '<option value="'.$row->question_set_id.'">'.$row->question_set_name.'</option>';
          }
        }
        print_r($module);
      }
    }

    public function get_questions(){
      if($_POST){
        $question_set = $this->input->post('question_set');
        if(!empty($question_set)){
          $result = $this->questionbank_model->get_questions($question_set);
          $list=' <div class="table-responsive table_language"><table id="institute_data" class="table table-striped table-sm">
                    <thead><tr>
                        <th width="70">Sl.No.</th>
                        <th>Passage</th>
                        <th>Question</th>
                        <th width="150">Difficulty</th>
                        <th width="150">Availability</th>
                        <th>Actions</th>
                    </tr></thead><tbody>';
          if(!empty($result['questions'])){
            $i=1;
            foreach($result['questions'] as $row){

              $list=$list.'<tr id="row_'.$row->question_id.'"><td>'.$i.'</td>
                       ';
              if($row->paragraph_id!=0 && $row->paragraph_id!=NULL){          
                $list=$list.'<td onClick="viewPassage('.$row->paragraph_id.')"><a href="javascript:void()">'.limit_html_string($row->paragraph_content,10).'</a></td>';
              }else{          
                $list=$list.'<td>No passage</td>';
              }
              $list = $list.'<td onClick="viewQuestion('.$row->question_id.')"><a href="javascript:void()">'.limit_html_string($row->question_content,10).'</a></td>
                        <td>'.get_question_difficulty($row->question_difficulty).'</td>';
              if($row->edit_protected || $row->delete_protected){
                $list = $list.'<td onClick="viewUsedMaterials('.$row->question_id.')"><a href="javascript:void()">Used</a></td>';
              }else{
                $list = $list.'<td>New</td>';
              }
              $list = $list.'<td>
                            <a class="btn btn-default option_btn" title="View" onClick="get_question('.$row->question_id.')">
                              <i class="fa fa-eye icon"></i>
                            </a>';
              if(!$row->edit_protected){
                $list = $list.'<a class="btn btn-default option_btn" title="Edit" onClick="edit_question('.$row->question_id.')">
                                <i class="fa fa-pencil icon"></i>
                              </a>';
              }
              if(!$row->delete_protected){
                $list = $list.'<a class="btn btn-default option_btn" title="Delete" onClick="delete_question('.$row->question_id.')">
                                <i class="fa fa-trash-o"></i>
                              </a>';
              }
              $list = $list.'</td>
                      </tr>';
              $i++;  
            }
          }
          $list.='</tbody></table></div>';
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'success';
          $returnData['data'] 		= $list;
          // $returnData['pages'] 		= $result['pages'];
        }else{
          $returnData['st'] 		= 0;
          $returnData['message'] 	= 'Please select a question set';
        }
        print_r(json_encode($returnData));
      }
    }
    
    public function load_questions_ajax(){
        $list = '<thead><tr>
                    <th width="50">Sl.No.</th>
                    <th>Passage</th>
                    <th>Question</th>
                    <th>Difficulty</th>
                    <th>Version</th>
                    <th>Actions</th>
                </tr></thead>'; 
          if($_POST){
            $id = $this->input->post('id');
            $question_set = $this->common->get_name_by_id('mm_question','question_set_id',array("question_id"=>$id));
            if(!empty($question_set)){
                $result = $this->questionbank_model->get_questions($question_set);
                if(!empty($result['questions'])){
                  $i=1;
                  foreach($result['questions'] as $row){  
                    $list=$list.'<tr id="row_'.$row->question_id.'"><td>'.$i.'</td>';
                    if($row->paragraph_id!=0 && $row->paragraph_id!=NULL){          
                        $list=$list.'<td onClick="viewPassage('.$row->paragraph_id.')"><a href="javascript:void()">'.limit_html_string($row->paragraph_content,20).'</a></td>';
                    }else{          
                        $list=$list.'<td>No passage</td>';
                    }
                    $list = $list.'<td onClick="viewQuestion('.$row->question_id.')"><a href="javascript:void()">'.limit_html_string($row->question_content,20).'</a></td>
                    <td>'.get_question_difficulty($row->question_difficulty).'</td>
                    <td>'.$row->question_version.'</td>
                    <td>
                    <a class="btn btn-default option_btn" title="View" onClick="get_question('.$row->question_id.')">
                      <i class="fa fa-eye icon"></i>
                    </a>
                    <a class="btn btn-default option_btn" title="Edit" onClick="edit_question('.$row->question_id.')">
                      <i class="fa fa-pencil icon"></i>
                    </a> 
                    <a class="btn btn-default option_btn" title="Delete" onClick="delete_question('.$row->question_id.')">
                    <i class="fa fa-trash-o"></i></a>
                    </td>
                    </tr>';
                    $i++; 
                  }
                } 
            }
          }
        echo $list;
      }

    public function get_passage_content(){
      if($_POST){
        $passage_id = $this->input->post('passage_id');
        if(!empty($passage_id)){
          $result = $this->questionbank_model->get_passage_content($passage_id);
          if(!empty($result)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "Passage";
            $returnData['body'] 		= $result->paragraph_content;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Passage not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }

    public function get_question_content(){
      if($_POST){
        $question_id = $this->input->post('question_id');
        if(!empty($question_id)){
          $result = $this->questionbank_model->get_question_content($question_id);
          if(!empty($result)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "Question";
            $returnData['body'] 		= $result->question_content;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Question not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }

    public function get_question_usages(){
      if($_POST){
        $question_id = $this->input->post('question_id');
        if(!empty($question_id)){
          $result = $this->questionbank_model->get_question_usages($question_id);
          if(!empty($result)){
            // show($result);
            $list = '<div class="row">
                      <div class="col-sm-12">
                        <div class="table-responsive table_language">
                          <table class="table table-bordered table-striped table-sm text-center">
                            <thead>
                              <tr>
                                <th>Exam Paper Name</th>
                                <th>Question Number</th>
                              </tr>
                            </thead>
                            <tbody>';
            foreach($result as $row){
              $list .= '<tr><td>'.$row->exam_paper_name.'</td><td>'.$row->question_number.'</td></tr>';
            }
            $list .= '</tbody></table></div></div>';
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "List of Exam Papers where this Question is Used";
            $returnData['body'] 		= $list;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Exam papers not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }

    public function get_question(){
      if($_POST){
        $question_id = $this->input->post('question_id');
        if(!empty($question_id)){
          $result = $this->questionbank_model->get_full_question($question_id);
          $list='';
          if(!empty($result)){
            if($result['question']->question_difficulty == 1){$question_difficulty='Easy';}
            if($result['question']->question_difficulty == 2){$question_difficulty='Medium';}
            if($result['question']->question_difficulty == 3){$question_difficulty='Hard';}

            if($result['question']->question_type == 1){$question_type='Objective';}
            if($result['question']->question_type == 2){$question_type='Descriptive';}
            
            $list.='<div class="row" style="margin-left: 15px;">';
            $list.='<div class="form-group col-sm-4">
                        <div class="title-header">Difficulty</div>
                        <div class="title-body"><h6>'.$question_difficulty.'</h6></div>
                      </div>';
            $list.='<div class="form-group col-sm-4">
                        <div class="title-header">Question Type</div>
                        <div class="title-body"><h6>'.$question_type.'</h6></div>
                      </div>';
            if(!empty($result['passage'])){
              $list.='<div class="form-group col-sm-12">
                        <div class="title-header">Passage</div>
                        <div class="title-body">'.$result['passage']->paragraph_content.'</div>
                      </div>';
            }
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Question</div>
                      <div class="title-body">'.$result['question']->question_content.'</div>
                    </div>';
            if($result['question']->question_type == 1){
              $list.='<div class="form-group col-sm-12">
                        <div class="title-header">Options</div>
                        <div class="title-body"><ul>';
              $answer = '';
              if(!empty($result['options'])){
                foreach($result['options'] as $row){
                  if($row->option_answer == 1){
                    $answer .= ' ('.$row->option_number.') '.$row->option_content;
                  }
                  $list.='<li>('.$row->option_number.') '.$row->option_content.'</li>';
                }
              }
              $list.='</ul></div></div>';
              $list.='<div class="form-group col-sm-12">
                        <div class="title-header">Answer</div>
                        <div class="title-body">'.$answer.'</div>
                      </div>';
            }
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Solution</div>
                      <div class="title-body">'.$result['question']->question_solution.'</div>
                    </div>';
            
            $list.='</div>';
          
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Success';
            $returnData['title'] 		= "Question";
            $returnData['body'] 		= $list;
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= 'Passage not found';
          }
        }
        print_r(json_encode($returnData));
      }
    }
    
    public function edit_material()
    {
        if($_POST)
        {    
            $material_id=$this->input->post('material_id');
             unset($_POST['material_id']); 
           
               $material_link = ""; 
           
                  if(!empty($_FILES['file_name']['name']))
                    {

                        $files = str_replace(' ', '_', $_FILES['file_name']);

                        $config['upload_path']           = 'uploads/materials/';
                        $config['allowed_types']        = 'pdf';
                        $config['file_name'] =$this->input->post('material_name').'_'.time();

                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        $upload = $this->upload->do_upload('file_name');
                        $fileData = $this->upload->data();
                           if($upload)
                           {
                              $material_link= $fileData['file_name'];
                           }

                         if(!$upload)
                        {
                          // echo  $this->upload->display_errors();
                             $ajaxresponse['st']=3;
                             $ajaxresponse['message']='Please Choose a Pdf file';
                             print_r(json_encode($ajaxresponse));exit();
                        }
                } 
         
             $data=array(
                            "material_type"=>$this->input->post('material_type'),
                            "subject_id"=>$this->input->post('module_id'),
                            "subject_id"=>$this->input->post('module_id'),
                            "material_name"=>$this->input->post('material_name'),
                            "material_link"=>$material_link
                        );
             
             $result = $this->questionbank_model->edit_material($data,$material_id);
             if($result != 0)
               {
                    $ajaxresponse['updated_details']=$this->questionbank_model->get_material_by_id($material_id); 
                 
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'database', $who, $what, $material_id, 'mm_material', 'Material name edited');
                 
                   $ajaxresponse['st']=1;
                   $ajaxresponse['message']='Successfully Updated';

               }
               else
               {
                   //error occured
                   $ajaxresponse['st']=0;
                   $ajaxresponse['message']='Error Occured';
               }
             print_r(json_encode($ajaxresponse));
        }
    }

    //get material by subject id
    public function get_material_subjectId()
    {
        if($_POST)
        {
          $subject_id=$this->input->post('id');
          $materialArr=$this->common->get_alldata('mm_material',array("material_status"=>1,"subject_id"=>$subject_id));
          $html='<option value="">Select</option>';
          if(!empty($materialArr)){
            foreach($materialArr as $row){
              if(!empty($this->input->post('type'))){
                if($row['material_type'] == $this->input->post('type')){
                  $html .= '<option value="'.$row['material_id'].'">'.$row['material_name'].'</option>';
                }
              }else{
                $html .= '<option value="'.$row['material_id'].'">'.$row['material_name'].'</option>';
              }
            }
          }
        $returnData['material']=$html;
        print_r(json_encode($returnData));
            
        }
    }
    
    //add questionset
    public function questionset_add()
    {
        // print_r($_POST);die();
         if($_POST)
        {
          if($this->input->post('approval_chk')){
            $data=array(
              "question_set_name"=>$this->input->post('question_set_name'),
              "subject_id"=>$this->input->post('module_id'),
              "material_id"=>$this->input->post('material_id')
            );
          }else{
            $data=array(
              "question_set_name"=>$this->input->post('question_set_name'),
              "subject_id"=>$this->input->post('module_id'),
              "material_id"=>$this->input->post('material_id'),
              "question_set_status" => 1
            );
          }
            $ajax_response['st']=$this->questionbank_model->questionset_add($data);
           
            if($ajax_response['st'] == 1)
            {
              $what=$this->db->last_query();
              $table_row_id=$this->db->insert_id();
              if($this->input->post('approval_chk')){
                $data1=array(
                  "flow_detail_id"=>$this->input->post('approve_users'),
                  "entity_id"=>$table_row_id
                );
                // $this->Common_model->update('mm_question',array("question_status"=>"0"),array("question_id"=>$id)); 
                $response=$this->Common_model->insert('approval_flow_jobs', $data1); 
              }
              $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
              $ajax_response['message']="Question Set Added Successfully";
              logcreator('insert', 'database', $who, $what, $table_row_id, 'mm_question_set','Added question set details');
            }
            else if($ajax_response['st'] == 2)
            {
                $ajax_response['message']="Already Exist"; 
            }
            else if($ajax_response['st'] == 0)
            {
                $ajax_response['message']="Invalid Request"; 
            }
            print_r(json_encode($ajax_response));
        }
    }
    //delete question set
    public function delete_questionset()
    {
       $id      = $this->input->post('question_set_id');
                    $where = array('question_set_id'=>$id);
                    $data  = array('question_set_status'=>2);
                    $what = '';
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    if($id!= '') {
                        $query = $this->common->delete_fromwhere('mm_question_set', $where, $data);
                        $res['status']   = true;
                        $res['message']  = 'Question Set deleted successfully';
                        $res['data']     = '';
                        $table_row_id    = $this->db->insert_id();
                        logcreator('delete', 'database', $who, $what, $id, 'hl_hostel_floor','Question set deleted');
                    } else {

                       $res['status']   = false;
                       $res['message']  = 'Invalid data';
                       $res['data']     = array();
                       logcreator('insert', 'database', $who, $what, $id, 'hl_hostel_floor','Question set deletion failed');
                    }
                    print_r(json_encode($res)); 
    }
    //get_question set data by id
    public function get_questionset_data_byId(){
      if($_POST){
          $question_set_id =    $this->input->post('question_set_id');
          $ajax_data['data'] =  $this->common->get_from_tablerow('mm_question_set',array('question_set_id'=>$question_set_id));
          $data=$ajax_data['data'];
          $ajax_data['parent_subject'] = $this->common->get_parentSubject(array("subject_id"=>$data['subject_id']));
          $moduleArr = $this->subject_model->get_allmodules_by_subjectid(array("parent_subject"=> $ajax_data['parent_subject']));
          $ajax_data['modules']= '<option value="">Select</option>';
          if(!empty($moduleArr)){
            foreach ($moduleArr as $row){
              $ajax_data['modules'].='<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
            }
          }
          $materialArr=$this->common->get_alldata('mm_material',array("subject_id"=>$data['subject_id']));
          $ajax_data['material']='<option value="">Select</option>';
          if(!empty($materialArr)){
          foreach($materialArr as $row){
            $ajax_data['material'] .= '<option value="'.$row['material_id'].'">'.$row['material_name'].'</option>';
          }
      }
        print_r(json_encode($ajax_data));
      }
    }
    //edit question set
    public function questionset_edit()
    {
        $question_set_id  =   $this->input->post('question_set_id');
        unset($_POST['question_set_id']);
        $data=array(
             "question_set_name"=>$this->input->post('question_set_name'),
             "subject_id"=>$this->input->post('module_id'),
             "material_id"=>$this->input->post('material_id')
             );
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($_POST){

            $response=$this->questionbank_model->questionset_edit($question_set_id,$data);
            $what= $this->db->last_query();
            if($response == 1)
            {
              logcreator('Edit', 'database', $who, $what, $question_set_id, 'mm_question_set','updated question set details');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Question Set Details";
            }
            else if($response == 2)
            {
               $ajax_response['st']=2;
              $ajax_response['message']="Already Exist";
            }
            else
            {
               $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }


            print_r(json_encode($ajax_response));
        }
    }
    //load material list by ajax
     public function load_materialList_ajax() {
        $html = '<thead> 
                   <tr>
                        <th width="50">'.$this->lang->line('sl_no').'</th>
                        <th>Material Type</th>
                        <th>Subject</th>
                        <th>Module</th>
                        <th>Material Name</th>
                        <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
       $materialArr= $this->questionbank_model->get_materials(); 
       $this->data['materialtype'] =$this->questionbank_model->getall_material_type();
      
        if(!empty($materialArr)) {
            $i=1; 
            foreach($materialArr as $material){
                // $module_id=$material['subject_id'];
                // $parent_subject_id = $this->common->get_parentSubject(array("subject_id"=>$module_id));
                // $parent_subject=$this->subject_model->get_subjectby_id($parent_subject_id);
                $button="";
                $url="'backoffice/question-set'";
                 if($material['material_type']=='question'){
                    $button='<button class="btn btn-default add_row add_new_btn btn_add_call" onclick="redirect('.$url.')">
                        Add questions sets
                    </button>';
                  }
                  else if($material['material_type']=='study material'){
                        $button="<button class='btn btn-default add_row add_new_btn btn_add_call' onclick=redirect('backoffice/add-study-material?material_id=".$material['material_id']."')>
                            Add study material
                        </button>";
                         }
                
                $html .= '<tr>
                    <td>
                        '.$i.'
                    </td>
                    <td>
                        '.ucfirst($material['material_type']).'
                    </td>
                    <td>
                        '.$material['subject_name'].'
                    </td>
                    <td>
                        '.$material['module_name'].'
                    </td>
                    <td>
                        '.$material['material_name'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_materialdata('.$material['material_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_material('.$material['material_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>'.$button.'

                    </td>
                </tr>';

                 $i++; }
        }
        echo $html;
    }


     //load question set list by ajax
     public function load_questionsetList_ajax() {
        $html = '<thead>
                    <tr>
                      <th width="50">'.$this->lang->line('sl_no').'</th>
                      <th>'.$this->lang->line('questionset_name').'</th>
                      <th>'.$this->lang->line('subject').'</th>
                      <th>'.$this->lang->line('module').'</th>
                      <th>'.$this->lang->line('material').'</th>
                      <th>'.$this->lang->line('approval_status').'</th>
                      <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
       $questionsetArr= $this->questionbank_model->get_all_questionset();


        if(!empty($questionsetArr)) {
            $i=1;
            foreach($questionsetArr as $question){

                 $module_id=$question['subject_id'];
                 $parent_subject_id = $this->common->get_parentSubject(array("subject_id"=>$module_id));
                 $parent_subject=$this->subject_model->get_subjectby_id($parent_subject_id);

                $html .= '<tr>

                    <td>
                        '.$i.'
                    </td>
                    <td>
                        '.$question['question_set_name'].'
                    </td>
                    <td>
                        '.$parent_subject.'
                    </td>
                    <td>
                        '.$question['subject_name'].'
                    </td>
                    <td>
                        '.$question['material_name'].'
                    </td>
                    <td>';
                      if($question['question_set_status'] == '100'){
                        $html .= '<span class="btn mybutton mybuttonInactive">Pending</span>';
                      }else if($question['question_set_status'] == '1'){
                        $html .= '<span class="btn mybutton  mybuttonActive" onclick="view_approve_status('.$question['question_set_id'].')">Approved</span>';
                      }else if($question['question_set_status'] == '101'){
                        $html .= '<span class="btn mybutton  mybuttonInactive" onclick="view_approve_status('.$question['question_set_id'].')">Rejected</span>';
                    }
                $html .= '</td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_questionset('.$question['question_set_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_questionset('.$question['question_set_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
                        if($question['question_set_status'] != '1'){
                          $html .= '<button class="btn btn-default add_row add_new_btn btn_add_call" onclick="redirect(\'backoffice/question-bank\')">Add questions</button>';
                        } 
                $html .= '</td>
                </tr>';

                 $i++; }
        }

        echo $html;
    }

    public function save_study_material(){
      $this->form_validation->set_rules('subject', 'Subject', 'required');
      $this->form_validation->set_rules('modules', 'Module', 'required');
      $this->form_validation->set_rules('material', 'Material', 'required');
      $this->form_validation->set_rules('description', 'Description', 'required');
      if($this->form_validation->run()){
        $data = array(
          'material_id'=>$this->input->post('material'),
          'description'=>$this->input->post('description'),
          'youtube_notes'=>$this->input->post('youtube_notes'),
          'text_content'=>$this->input->post('study_notes')
        );
        if(!empty($_FILES['video_notes']['name'])){
          $file_name = explode('.',$_FILES['video_notes']['name']);
          $name = trim($data['description']).'_'.time().'_'.$file_name[0].'.'.end($file_name);
          $this->load->library('upload');
          $config['upload_path']    = FCPATH.'materials/study_materials/video';
          $config['allowed_types']  = '*';
          $config['max_size']       = VIDEO_LECTURE_SIZE;
          $config['file_name']      = $name;
          $this->load->library('upload',$config);
          $this->upload->initialize($config);
          $upload = $this->upload->do_upload('video_notes');
          $fileData = $this->upload->data();
          if($upload){
            $data['video_content'] = 'downloads?url=study_materials/video/'.$fileData['file_name'];
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= $this->upload->display_errors();
            print_r(json_encode($returnData));
            exit;
          }
        }
        if(!empty($_FILES['audio_notes']['name'])){
          $file_name = explode('.',$_FILES['audio_notes']['name']);
          $name = trim($data['description']).'_'.time().'_'.$file_name[0].'.'.end($file_name);
          $this->load->library('upload');
          $config['upload_path']    = FCPATH.'materials/study_materials/audio';
          $config['allowed_types']  = '*';
          $config['max_size']       = AUDIO_LECTURE_SIZE;
          $config['file_name']      = $name;
          $this->load->library('upload',$config);
          $this->upload->initialize($config);
          $upload = $this->upload->do_upload('audio_notes');
          $fileData = $this->upload->data();
          if($upload){
            $data['audio_content'] = 'downloads?url=study_materials/audio/'.$fileData['file_name'];
          }else{
            $returnData['st'] 		= 0;
            $returnData['message'] 	= $this->upload->display_errors();
            print_r(json_encode($returnData));
            exit;
          }
        }
        if($this->input->post('study_material_id')==''){
          $result = $this->questionbank_model->save_study_material($data);
        //  echo $this->db->last_query();
        }else{
          $result = $this->questionbank_model->update_study_material($data,$this->input->post('study_material_id'));
           //echo $this->db->last_query();
        }
        if($result){
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Study material successfully saved';
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Internal server error please try again later.';
        }
      }else{
        $returnData['st'] 		= 0;
        $returnData['message'] 	= validation_errors();
      }
      print_r(json_encode($returnData));
    }

    public function delete_study_material(){
      if($_POST){
        $data = array();
        if($this->input->post('type')=='video'){$data['video_content']=NULL;}
        if($this->input->post('type')=='audio'){$data['audio_content']=NULL;}
        if($this->input->post('type')=='delete'){$data['status']=0;}
        if(!empty($data)){
          $result = $this->questionbank_model->update_study_material($data,$this->input->post('id'));
          if($result){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Successfully deleted';
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Internal server error please try again later.';
          }
        }
      }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Network failure.';
      }
      print_r(json_encode($returnData));
    }

    public function view_study_material(){
      if($_POST){
        $id = $this->input->post('id');
        $study_material['data'] = $this->questionbank_model->get_study_material_details($id);
          // echo '<pre>';print_r($study_material['data']);exit;
        $html = '<div class="row"></div>';
        if(!empty($study_material['data'])){
          $html = $this->load->view('admin/materialManagement/html/study_material_view',$study_material,TRUE);
        }
        // echo $html;exit;
        $returnData['st'] 		  = 1;
        $returnData['message'] 	= 'Success.';
        $returnData['html'] 	  = $html;
        $returnData['title'] 	  = ucfirst($study_material['data']['material_name']);
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Network failure.';
      }
      print_r(json_encode($returnData));
    }

    public function material_nameCheck()
    {
        if($_POST)
           {
               $name=$this->input->post('material_name');
               $num=$this->common->check_if_dataExist('mm_material',array("material_name"=>$name,"material_status"=>1));

                if($num >0)
                {
                   echo 'false';
                }
                else
                {
                    echo 'true';
                }
           }
    }
    public function editmaterial_nameCheck()
    {
        if($_POST)
           {
               $name=$this->input->post('material_name');
               $id=$this->input->post('id');
               $num=$this->common->check_if_dataExist('mm_material',array("material_name"=>$name,"material_id!="=>$id));

                if($num >0)
                {
                   echo 'false';
                }
                else
                {
                    echo 'true';
                }
           }
    }
    
    public function delete_question()
    {
        if($_POST)
        {
            $id=$this->input->post('id');
            $exist=$this->common->check_if_dataExist('gm_exam_paper_questions',array("question_id"=>$id));
             if($exist == 0)
             {
               $response= $this->Common_model->update('mm_question',array("question_status"=>"0"),array("question_id"=>$id)); 
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']='Question deleted Successfully';
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']='Something went wrong,Please try again later..!';
                }
            } 
            else
            {
              $ajax_response['st']=2;
              $ajax_response['msg']='This question is already added in a question paper.';  
            }
          }
        else
        {
           $ajax_response['st']=0;
           $ajax_response['msg']='Something went wrong,Please try again later..!';
        }
        print_r(json_encode($ajax_response));
        }
    
    public function question_excel_upload()
    {
      $this->data['questionsets'] = $this->questionbank_model->get_questionsets();
      $this->data['paragraphs'] = $this->questionbank_model->get_paragraphs();
      $this->data['page']="admin/materialManagement/question_upload_excel";
      $this->data['menu']="questionbank";

      $this->data['breadcrumb'][0]['name']="Material management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Excel upload questions";
      
      $this->data['menu_item']="questionbank";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }
    
     public function question_upload(){
        if($_POST){
            if($_FILES['question']['name']!= ""){
                $allowed =  array('xls','xlsx','csv','ods');
                $filename = $_FILES['question']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    $ajax_response['st']=2;
                    $ajax_response['msg']="This file type is not allowed !";
                    print_r(json_encode($ajax_response));
                    return false;
                }
            }
           
            $question_set=$_POST['question_set'];
        
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
            if($highestRow>1){
                $this->db->trans_begin();
                //validation
                $flag=1;
              
                 for($i = 2; $i <= $highestRow; $i++)
                 {  
                    $question_no = $sheet->getCellByColumnAndRow(1, $i)->getValue();
                    if($question_no!=""){
                    $question = $sheet->getCellByColumnAndRow(2, $i)->getValue();
                    $passage = $sheet->getCellByColumnAndRow(3, $i)->getValue();
                    $option1=$sheet->getCellByColumnAndRow(4, $i)->getValue();
                    $option2=$sheet->getCellByColumnAndRow(5, $i)->getValue();
                    $option3=$sheet->getCellByColumnAndRow(6, $i)->getValue();
                    $option4=$sheet->getCellByColumnAndRow(7, $i)->getValue();
                    $option5=$sheet->getCellByColumnAndRow(8, $i)->getValue();
                    $option = array();
                    array_push($option,$sheet->getCellByColumnAndRow(4, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(5, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(6, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(7, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(8, $i)->getValue());
                    $answer = $sheet->getCellByColumnAndRow(9, $i)->getValue();  
                    $correctanswer = $sheet->getCellByColumnAndRow(9, $i)->getValue(); 
                    $difficulty = $sheet->getCellByColumnAndRow(11, $i)->getValue(); 
                    $answer = explode(' ',trim($answer));  
                        if(count($answer)!=2)
                        {
                            $this->db->trans_rollback();
                            $ajax_response['st']=0;
                            $ajax_response['msg']="Some rows in the excel are not compatible..!";
                            print_r(json_encode($ajax_response));
                            exit();
                        } 
                        if($question_no =="" || $question=="" || $option1=="" || $option2=="" || $option3=="" || $option4==""  || $correctanswer=="" || $difficulty=="")
                        { 
                            $ajax_response['st']=0;
                            $ajax_response['msg']="There is an error in row number ".$i." !";
                            print_r(json_encode($ajax_response));
                            exit();
                        }
                        
                        $option_data=array();
                        $flag=0;
                        foreach($option as $k=>$row){
                            $ans=0;
                            if(($answer[1]-1)==$k){$ans=1; $flag=1;}
                            array_push($option_data,array(
                               // 'question_id'=>$question_id,
                                'option_number'=>alphabets()[$k],
                                'option_content'=>$row,
                                'option_answer'=>$ans
                            ));
                        }
                        if($flag == 0)
                        {
                            //no answer
                            $ajax_response['st']=0;
                            $ajax_response['msg']="Answer not found in row  ".$i."!";
                            print_r(json_encode($ajax_response));
                            exit();
                        }
                        $exist=$this->common->check_if_dataExist('mm_question',array("question_content"=>$question));
                        if($exist!=0)
                        {   $check_option_array=array();
                            $question_id=$this->common->get_name_by_id('mm_question','question_id',array("question_content"=>$question,"question_set_id"=>$question_set,"question_status"=>1));
                            $option_data=$check_option_array;
                            $check_option_array['question_id']=$question_id;
                            $check=$this->common->check_if_dataExist('mm_question_option',$check_option_array);
                            if($check !=0)
                            {
                                //duplication in question with option
                            $ajax_response['st']=0;
                            $ajax_response['msg']="The question in row number ".$i." already exist!";
                            print_r(json_encode($ajax_response));
                            exit(); 
                            }
                        }
                       
                 }else
                    {
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Add question number in row ".$i."!";
                        print_r(json_encode($ajax_response));
                        exit();  
                    }
                 }
                //insertion
                for($i = 2; $i <= $highestRow; $i++){
                    $question_no = $sheet->getCellByColumnAndRow(1, $i)->getValue();
                    if($question_no!=""){
                    $question = $sheet->getCellByColumnAndRow(2, $i)->getValue();
                    $passage = $sheet->getCellByColumnAndRow(3, $i)->getValue();
                    $option1=$sheet->getCellByColumnAndRow(4, $i)->getValue();
                    $option2=$sheet->getCellByColumnAndRow(5, $i)->getValue();
                    $option3=$sheet->getCellByColumnAndRow(6, $i)->getValue();
                    $option4=$sheet->getCellByColumnAndRow(7, $i)->getValue();
                    $option5=$sheet->getCellByColumnAndRow(8, $i)->getValue();
                    $option = array();
                    array_push($option,$sheet->getCellByColumnAndRow(4, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(5, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(6, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(7, $i)->getValue());
                    array_push($option,$sheet->getCellByColumnAndRow(8, $i)->getValue());
                    $answer = $sheet->getCellByColumnAndRow(9, $i)->getValue();  
                    $correctanswer = $sheet->getCellByColumnAndRow(9, $i)->getValue();  
                    $answer = explode(' ',trim($answer));  
                    if(count($answer)!=2)
                    {
                        $this->db->trans_rollback();
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Some rows in the excel are not compatible..!";
                        print_r(json_encode($ajax_response));
                        exit();
                    }
                    $question_solution = $sheet->getCellByColumnAndRow(10, $i)->getValue();
                    $difficulty = $sheet->getCellByColumnAndRow(11, $i)->getValue(); 
                    if($question_no!="" && $question!="" &&  $option1!="" && $option2!="" && $option3!="" && $option4!="" && $correctanswer!="")
                    {
                    $difficulty_val=2;
                    if($difficulty == "Easy"){
                     $difficulty_val=1;   
                    }
                    if($difficulty == "Medium"){
                        $difficulty_val=2;  
                    }
                    if($difficulty == "Hard"){
                        $difficulty_val=3;  
                    }
                    $paragraph_id=0;
                    if(trim($passage) != ""){
                        $data=array(
                            "question_set_id"=>$question_set,
                            "paragraph_content"=>$passage
                        );
                        $exist_passage_data=$this->common->get_from_tablerow('mm_question_paragraph',array("paragraph_content"=>$passage));
                        if(!empty($exist_passage_data)){
                          $paragraph_id= $exist_passage_data['paragraph_id']; 
                        }else{
                         $paragraph_id=$this->Common_model->insert('mm_question_paragraph', $data);   
                        }

                    }
                    $question_data=array(
                        "question_set_id"=>$question_set,
                        "paragraph_id"=>$paragraph_id,
                        "question_content"=>$question,
                        "question_solution"=>$question_solution,
                        "question_difficulty"=>$difficulty_val,
                    );
                    $question_id=$this->Common_model->insert('mm_question', $question_data);
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']="There is an error in row number ".$i." !";
                    print_r(json_encode($ajax_response));
                    exit();
                }
                    $option_data=array();
                    $flag=0;
                    foreach($option as $k=>$row){
                      if($row != ''){
                        $ans=0;
                        if(($answer[1]-1)==$k){$ans=1; $flag=1;}
                        array_push($option_data,array(
                            'question_id'=>$question_id,
                            'option_number'=>alphabets()[$k],
                            'option_content'=>$row,
                            'option_answer'=>$ans
                        ));
                      }
                    }
                    if($flag == 0)
                    {
                        //no answer
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Answer not found in row  ".$i."!";
                        print_r(json_encode($ajax_response));
                        exit();
                    }
                    $this->questionbank_model->question_option_insert($option_data);
                        $this->db->trans_commit(); 
                        $ajax_response['st']=1;
                        $ajax_response['msg']="Questions Added Successfully..!";
                }
                
            }
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Empty file uploaded";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }

// ---------------------------------- Learning module -----------------------------------------------------

  public function learning_module(){
    // check_backoffice_permission('manage_learning_module');
    $this->data['learningModule'] = $this->questionbank_model->get_learning_module();
    $this->data['course'] = $this->questionbank_model->get_cource();
    $this->data['page']="admin/materialManagement/learning_module";
    $this->data['menu']="questionbank";
    $this->data['breadcrumb'][0]['name']="Material management";
    $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
    $this->data['breadcrumb'][1]['name']="Learning Module";
    $this->data['menu_item']="learning_module";
    $this->load->view('admin/layouts/_master.php',$this->data); 
  }
  public function create_question_paper(){
    if($_POST){
      $this->form_validation->set_rules('learning_module_name', 'Learning module name', 'trim|required');
      if($this->form_validation->run()){
        $duplicate_name = $this->questionbank_model->check_duplicate_module_name($this->input->post('learning_module_name'));
        if($duplicate_name){
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'This name is already taken';
          print_r(json_encode($returnData));
          exit;
        }
        $learningModuleCode = "D";
        $getSchool = $this->common->get_name_by_id('am_classes','school_id',array('class_id'=>$this->input->post('course')));
        $schoolCode = $this->common->get_name_by_id('am_schools','school_code',array('school_id'=>$getSchool));
        $learningModuleCode .= strtoupper($schoolCode);
        $batchModeId = $this->common->get_name_by_id('am_classes','batch_mode_id',array('class_id'=>$this->input->post('course')));
        $learningModuleCode .= $batchModeId;
        $learningModuleCode .= "LM";
        $subject = $this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$this->input->post('subject')));
        $subjectFirstLtr = substr($subject,0,1);
        $learningModuleCode .= strtoupper($subjectFirstLtr);
        $nOcurence = $this->questionbank_model->get_nOcurence($this->input->post('course'),$this->input->post('subject'));
        $learningModuleCode .= $nOcurence;
        $learningModuleCode .= date('m').date('y');
        $learningModuleCode .= "V1";
        $learningModuleCode = $this->questionbank_model->confirmModuleCode($learningModuleCode);
        if($this->input->post('approval_chk')){
          $data=array(
            'learning_module_name'=>$this->input->post('learning_module_name'),
            'course'=>$this->input->post('course'),
            'subject'=>$this->input->post('subject'),
            'learning_module_code '=> $learningModuleCode,
            'sequence_no' => $nOcurence
          );
        }else{
          $data=array(
            'learning_module_name'=>$this->input->post('learning_module_name'),
            'course'=>$this->input->post('course'),
            'subject'=>$this->input->post('subject'),
            'learning_module_code '=> $learningModuleCode,
            'status' => 1,
            'sequence_no' => $nOcurence
          );
        }
        $result = $this->questionbank_model->create_question_module($data);
        if($result){
          $table_row_id=$this->db->insert_id();
          if($this->input->post('approval_chk')){
            $data1=array(
              "flow_detail_id"=>$this->input->post('approve_users'),
              "entity_id"=>$table_row_id
            );
            // $this->Common_model->update('mm_question',array("question_status"=>"0"),array("question_id"=>$id)); 
            $response=$this->Common_model->insert('approval_flow_jobs', $data1); 
          }
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'New learning module created successfully please wait taking you to the question paper definition screen';
          $returnData['data'] 	= $result;
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'server busy please try again later';
        }
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= validation_errors();
      }
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
  }

  public function create_learning_module(){
    check_backoffice_permission('create_learning_module');
    if($_GET['id']){ 
      $this->data['learningModule'] = $this->questionbank_model->get_learning_module_name($_GET['id']);
      // show($this->data['learningModule']);
      if(!empty($this->data['learningModule'])){
        $this->data['course'] = $this->questionbank_model->get_cource();
        $this->data['page']="admin/materialManagement/create_learning_module";
        $this->data['menu']="questionbank";
        $this->data['breadcrumb'][0]['name']="Material management";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
        $this->data['breadcrumb'][1]['name']="Learning Module";
        $this->data['breadcrumb'][1]['url']=base_url('backoffice/learning-module');
        $this->data['breadcrumb'][2]['name']="Edit Learning Module";
        $this->data['menu_item']="create_learning_module";
        $this->load->view('admin/layouts/_master.php',$this->data);
      }else{
        redirect('404');
      }
    }else{
      redirect('404');
    }
    // echo '<pre>'; print_r($this->data['course']); exit;
  } 
  
  public function get_subject(){
    if($_POST){
      $course_id = $this->input->post('course_id');
      if(!empty($course_id)){
        $section_modules = $this->questionbank_model->get_subject($course_id);
        $returnData['st'] 		  = 1;
        $returnData['data'] 		= $section_modules;
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Please try again later';
      }
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
  }

  public function get_subject_questions(){
    $learning_module_id=$this->input->post('learning_module_id');
    if($learning_module_id){
      $questions = $this->questionbank_model->get_selected_subject_questions($learning_module_id);
      // show($questions);
      // echo '<pre>';print_r($questions);exit;
      if(!empty($questions)){
        foreach($questions['questions'] as $k=>$v){
          $questions['questions'][$k]['question_content'] = limit_html_string($v['question_content'],10);
        }
        foreach($questions['selected_questions'] as $k=>$v){
          $questions['selected_questions'][$k]['question_content'] = limit_html_string($v['question_content'],10);
        }
      }
      $returnData['st'] 		    = TRUE;
      $returnData['questions'] 	= $questions;
    }else{
      $returnData['st'] 		    = FALSE;
      $returnData['questions'] 	= array();
    }
     print_r(json_encode($returnData));
   }

   public function save_selected_questions(){
    if($_POST){
      $qids = $this->input->post('question_ids');
      $delete_qids = $this->input->post('unselected_question_ids');
      $l_module_id = $this->input->post('module_id');
      // $course_id = $this->input->post('course_id');
      // $subject_id = $this->input->post('subject_id');
      if(!empty($qids)){
        $new_question_ids = $this->questionbank_model->get_new_question_ids($qids,$l_module_id);
        // echo '<pre>';print_r($new_question_ids);exit;
        $data=array();
        $current_question_number = $this->questionbank_model->get_last_question_number($l_module_id);
        if(!empty($new_question_ids)){
          foreach($new_question_ids as $k=>$qid){
            $current_question_number++;
            $data[$k]=array(
              'question_number'=>$current_question_number,
              'learning_module_id'=>$l_module_id,
              'question_id'=>$qid,
            );
          }
        }
        $result = $this->questionbank_model->save_learning_module_questions($l_module_id,$delete_qids,$data);
        if($result){
          $this->questionbank_model->reorder_exam_paper_questions($l_module_id);
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Questions added successfully';
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Server busy please try again later';
        }
      }else{
       $returnData['st'] 		  = 0;
       $returnData['message'] 	= 'Please select atleast one question to add in this section';
      }
    }else{
     $returnData['st'] 		  = 0;
     $returnData['message'] 	= 'Network Error';
   }
   print_r(json_encode($returnData));
  }
  public function delete_selected_question(){
    $id=$this->input->post('id');
    $module_id=$this->input->post('module_id');
    if($id){
      // show($id);
      $question_id = $this->questionbank_model->delete_selected_question($id);
      $this->questionbank_model->reorder_exam_paper_questions($module_id);
      // echo '<pre>'; print_r($question_id); exit;
      $returnData['st'] 		    = TRUE;
      $returnData['data'] 		  = $question_id;
    }else{
     $returnData['st'] 		    = FALSE;
    }
    print_r(json_encode($returnData));
  }
  public function save_learning_module_name(){
    $name = $this->input->post('name');
    $module_id = $this->input->post('module_id');
    if($module_id){
      $result = $this->questionbank_model->save_learning_module_name($module_id,$name);
      $duplicate_name = $this->questionbank_model->check_duplicate_module_name_edit($name);
      if($duplicate_name){
        $returnData['st'] 		  = 2;
        $returnData['msg'] 	= 'This name is already taken';
        print_r(json_encode($returnData));
        exit;
      }
      if($result){
        $returnData['st'] 		    = 1;
        $returnData['msg'] 		  = 'Learning module updated successfully!';
      }else{
        $returnData['st'] 		    = 0;
        $returnData['msg'] 		  = 'Somthing wrong!';
      }
    }else{
      $returnData['st'] 		    = 0;
      $returnData['msg'] 		  = 'Somthing wrong!';
    }
    print_r(json_encode($returnData));
  }
  public function get_single_learning_module(){
    $body = '';
    $id = $this->input->post('id');
    $view = $this->input->post('view'); 
    if($id){
      $learningModule = $this->questionbank_model->get_learning_module_name($id);
      $data['title'] = $learningModule->learning_module_name;
      $course = '<div class="row">
                    <div class="col-sm-12">
                        <div>
                            &nbsp;&nbsp;Cource&nbsp;&nbsp;:&nbsp;&nbsp;<b>'.$this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$learningModule->course)).'</b>
                        </div>
                    </div>
                  </div>';
      $subject = '<div class="row">
                    <div class="col-sm-12">
                        <div>
                          &nbsp;&nbsp;Subject&nbsp;&nbsp;:&nbsp;&nbsp;<b>'.$this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$learningModule->subject)).'</b>
                        </div>
                    </div>
                  </div><div class="row">&nbsp;</div>';
      $body .= $course;
      $body .= $subject;
      $questions = $this->questionbank_model->get_questions_by_learning_module_id($learningModule->id);
      // show($questions);
          $body .= '<div class="row">
                      <div class="col-sm-12">
                        <div class="title-header">
                          &nbsp;&nbsp;Questions
                        </div>
                          <div class="table-responsive table_language">
                            <table class="table table-bordered table-striped table-sm">
                              <tr>
                                <th>Sl.No</th>
                                <th>Question</th>
                                <th>Difficulty</th>
                              </tr>';
          if(!empty($questions)){
            // show($questions);
            $i = 0;
            foreach($questions as $row){
              if($row['question_difficulty'] == 1){$dfclty = '<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'; }
              else if($row['question_difficulty'] == 2){$dfclty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>'; }
              else if($row['question_difficulty'] == 3){$dfclty = '<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'; }
              $body  = $body.'<tr>
                                <td>'.++$i.'</td>
                                <td ';
                                if($view != 2){ 
                                  $body .= 'title="View Question details" style="cursor:pointer;" onclick="getQuestion('.$row['question_id'].','.$row['learning_module_id'].');"';
                                }
                                $body .= '>'.limit_html_string($row['question_content'],10).'</td>'
                                .$dfclty.
                              '</tr>';
            }
          }else{
            $body  = $body.'<tr>
                                <td colspan="3" style="text-align:center;">No Questions assigned</td>
                            </tr>';
          }
          $data['body'] = $body.'</table></div></div></div>';
          $data['footer'] = '<button class="btn btn-info close" data-dismiss="modal">OK</button>';
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Please review the exam model';
          $returnData['data'] 		= $data;
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Please try again later';
        }
    print_r(json_encode($returnData));
  }
  public function edit_learning_module_status(){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $what = '';
    $res = $this->questionbank_model->edit_learning_module_status($id, $status);
    if($res == 1){
        $what=$this->db->last_query();
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        logcreator('update', 'database', $who, $what, $id, 'am_learning_module', 'Learning module status changed');
    }
    print_r($res);
  }
  public function load_learning_module_ajax(){
    $learningModule = $this->questionbank_model->get_learning_module();
    $html = ' <thead> 
                <tr>
                  <th width="50">'.$this->lang->line('sl_no').'</th>
                  <th>'.$this->lang->line('name').'</th>
                  <th>Course</th>
                  <th>Subject</th>
                  <th>'.$this->lang->line('approval_status').'</th>
                  <th>'.$this->lang->line('status').'</th>
                  <th width="12%">'.$this->lang->line('action').'</th>
                </tr>
            </thead>';
    if(!empty($learningModule)){
        $i=1; 
        foreach($learningModule as $module){
            $html.='<tr>
                        <td>
                            '.$i.'
                        </td>
                        <td>
                          '.$module->learning_module_name.'
                        </td>
                        <td>
                          '.$this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$module->course)).'
                        </td>
                        <td>
                          '.$this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$module->subject)).'
                        </td>
                        <td>';
                            $approvalCheck = $this->common->get_approvalCheckExists($module->id);//show($approvalCheck);
                            if($approvalCheck != 0){
                              $AorR = $this->common->get_approvalAorR($module->id); print_r($AorR);
                              if($module->status == '100'){
                                $html.='<span class="btn mybutton mybuttonnew" onclick="view_approve_status(\''.$module->id.'\')">Pending</span>';
                              }else if($module->status == '1'  && $AorR == 2){
                                $html.='<span class="btn mybutton  mybuttonActive" onclick="view_approve_status(\''.$module->id.'\')">Approved</span>';
                              }else if($module->status == '101' && $AorR == 3){
                                $html.='<span class="btn mybutton  mybuttonInactive" onclick="view_approve_status(\''.$module->id.'\')">Rejected</span>';
                              }else if($AorR == 3){
                                $html.='<span class="btn mybutton  mybuttonInactive" onclick="view_approve_status(\''.$module->id.'\')">Rejected</span>';
                              }else if($AorR == 2){
                                $html.='<span class="btn mybutton  mybuttonActive" onclick="view_approve_status(\''.$module->id.'\')">Approved</span>';
                              }
                            }
            $html.='</td>
                        <td>';
                          if($module->status == 1) {
                            $html.='<span class="btn mybutton mybuttonActive" onclick="edit_lm_status(\''.$module->id.'\',\''.$module->status.'\')">Active</span>';
                          }else if($module->status != '100'){
                            $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_lm_status(\''.$module->id.'\',\''.$module->status.'\')">Inactive</span>';
                          }
            $html.='</td>
                    <td>
                      <a class="btn btn-default option_btn " title="View" onclick="view_learning_module('.$module->id.');">
                        <i class="fa fa-eye "></i>
                      </a>';
                      if($module->status != '1'){
                        $approvalCheck1 = $this->common->get_approvalCheckExists($module->id); //show($approvalCheck1);
                        if($approvalCheck1 <= 1){
                        if (check_module_permission('create_learning_module')){ 
                          $html.='<a class="btn btn-default option_btn " title="Edit" href="'.base_url().'backoffice/create-learning-module?id='.$module->id.'">
                                    <i class="fa fa-pencil "></i>
                                  </a>';
                        } 
                      }
                      }
                      if (check_module_permission('create_learning_module')){
                        $html.='<a class="btn btn-default option_btn mybuttonCopy copybutton" onclick="learning_module_copy(\''.$module->id.'\',\''.$module->learning_module_name.'\',\''.$module->course.'\',\''.$module->subject.'\',\''.$module->learning_module_code.'\')">
                                Copy
                              </a>';
                      }
                      $html.='</td>
                </tr>';
            $i++;
        }
    } 
    echo $html;
}
  public function schedule_learning_module(){
    check_backoffice_permission('schedule_learning_module');
    $this->data['learningModule'] = $this->questionbank_model->get_learning_module();
    $this->data['course'] = $this->questionbank_model->get_cource();
    $this->data['page']="admin/materialManagement/schedule_learning_module";
    $this->data['menu']="questionbank";
    $this->data['breadcrumb'][0]['name']="Material management";
    $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
    $this->data['breadcrumb'][1]['name']="Learning Module";
    $this->data['breadcrumb'][1]['url']=base_url('backoffice/learning-module');
    $this->data['breadcrumb'][2]['name']="Schedule Learning Module";
    $this->data['menu_item']="learning_module";
    $this->load->view('admin/layouts/_master.php',$this->data); 
  }
  public function learning_module_copy(){
    // show($_POST);
    $id = $_POST['moduleId'];
    $name = $_POST['moduleName'];
    $course = $_POST['moduleCourse'];
    $subject = $_POST['moduleSubject'];
    $learningModuleCode = $_POST['learningModuleCode'];
    $learningModuleCode = substr($learningModuleCode,0,9); 
    $learningModuleCode .= date('m').date('y');
    $learningModuleCode .= "V";
    $data['version'] = $this->questionbank_model->get_version($id);
    $data['learning_module_name'] = $name. ' Copy '. $data['version'];
    $data['course'] = $course;
    $data['subject'] = $subject;
    $data['learning_module_code'] = $learningModuleCode. $data['version'];
    $data['learning_module_code'] = $this->questionbank_model->confirmModuleCode($data['learning_module_code']);
    $data['parent_id'] = $id;
    if(!$this->input->post('approval_chk')){
      $data['status'] = 1;
    }
    $questionExist = $this->questionbank_model->check_questionExist($id);
    if($questionExist){
      $insertId = $this->questionbank_model->insert_learning_module_copy($data);
      if($insertId){
          $what=$this->db->last_query();
          $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
          logcreator('update', 'database', $who, $what, $id, 'am_learning_module', 'New learning module created from exist copy.');
          $questions = $this->questionbank_model->select_assinged_questions($insertId, $id);
          if($questions){
            if($this->input->post('approval_chk')){
              $data1=array(
                "flow_detail_id"=>$this->input->post('approve_users'),
                "entity_id"=>$insertId
              );
              // $this->Common_model->update('mm_question',array("question_status"=>"0"),array("question_id"=>$id)); 
              $response=$this->Common_model->insert('approval_flow_jobs', $data1); 
            }
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Copy of '.$name.' learning module created successfully please wait taking you to the question paper definition screen';
            $returnData['data'] 	= $insertId;
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Server busy please try again later';
          }
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Somthing wrong!';
      }
    }else{
      $returnData['st'] 		  = 2;
      $returnData['message'] 	= 'No questions available!';
    }
    print_r(json_encode($returnData));
  }
  public function get_approve_status(){
    $materialId = $this->input->post('id');
    $statusInfo = $this->questionbank_model->get_approve_status($materialId);
    // show($statusInfo);
    $html = '<table class="table table-striped table-sm" style="width:100%"><thead> 
                    <tr class="lightBg">
                        <th>'.$this->lang->line('level').'</th>
                        <th >'.$this->lang->line('user').'</th>
                        <th >'.$this->lang->line('approval_status').'</th>
                        <th >'.$this->lang->line('remark').'</th>
                        <th >'.$this->lang->line('assigned_date').'</th>
                        <th >'.$this->lang->line('updated_date').'</th>
                    </tr>
                </thead>';
        if(!empty($statusInfo)){
            foreach($statusInfo as $data){
                $html.='<tr>
                            <td>
                                '.$data->level.'
                            </td>
                            <td>
                                '.$this->common->get_name_by_id('am_users_backoffice','user_name',array("user_id"=>$data->user_id)).'
                            </td>
                            <td>';
                            if($data->status == 1){$html.='New';}
                            else if($data->status == 2){$html.='Approved';}
                            else if($data->status == 3){$html.='Rejected';}
                            $html.='</td>
                            <td>
                                '.$data->remarks.'
                            </td>
                            <td>'.date('d/m/Y',strtotime($data->assign_date)).'</td>
                            <td>'.date('d/m/Y',strtotime($data->updated_date)).'</td>
                        </tr>';
            }
        }else{
            $html.='<tr>
                        <td colspan="6" class="text-center">
                            <span>No Activities</span>
                        </td>
                    </tr>';
        }
        $html.='</table>';
        echo $html;
  }
  public function get_learning_module(){
    // $html = 'Don';
    if($_POST){
      $scheduleId =  $this->input->post('id');
      $learningModule = $this->scheduler_model->get_learning_module_details();
      if($learningModule){
        $html = '<tbody>
                  <tr>
                    <th>#</th>
                    <th>Learning Module</th>
                  </tr>';
        foreach($learningModule as $data){
          $html .= '<tr>
                      <td><input name="module_id" type="radio" value="'.$data['id'].'" id="module_id'.$data['id'].'"></td>
                      <td>'.$data['learning_module_name'].'</td>
                    </tr>';
        }
        $html .= '</tbody><input name="schedule_id" type="hidden" value="'.$scheduleId.'" id="scheduleId">';
      }else{
        $html = '';
      }
    }
    echo $html;
  }
  public function assign_learning_module_save(){
    if($_POST){
      $selectedlearningmodule = $this->input->post('selectedlearningmodule');
      $scheduleId = $this->input->post('scheduleId');
      $data['schedule_id'] = $scheduleId;
      $data['learning_module_id'] = $selectedlearningmodule;
      if($this->scheduler_model->assign_learning_module_save($data)){
        $returnData['st'] 		  = 1;
        $returnData['msg'] 	= 'Learning module assinged successfully';
      }else{
        $returnData['st'] 		  = 0;
        $returnData['scheduleId'] = $scheduleId;
        $returnData['message'] 	= 'Internal server error please try again later';
      }
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Access denied';
    }
    print_r(json_encode($returnData));
  }
  public function get_questionLM(){
    if($_POST){
      $question_id = $this->input->post('question_id');
      $lmId = $this->input->post('lmId');
      if(!empty($question_id)){
        $result = $this->questionbank_model->get_full_question($question_id);
        $list='';
        if(!empty($result)){
          if($result['question']->question_difficulty == 1){$question_difficulty='Easy';}
          if($result['question']->question_difficulty == 2){$question_difficulty='Medium';}
          if($result['question']->question_difficulty == 3){$question_difficulty='Hard';}

          if($result['question']->question_type == 1){$question_type='Objective';}
          if($result['question']->question_type == 2){$question_type='Descriptive';}
          
          $list.='<div class="row" style="margin-left: 15px;">';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Difficulty</div>
                      <div class="title-body"><h6>'.$question_difficulty.'</h6></div>
                    </div>';
          $list.='<div class="form-group col-sm-4">
                      <div class="title-header">Question Type</div>
                      <div class="title-body"><h6>'.$question_type.'</h6></div>
                    </div>
                  <div class="form-group col-sm-4">
                    <a class="btn btn-default add_new_btn btn_add_call addBtnPosition" onclick="view_learning_module('.$lmId.',1)">
                      Back
                    </a>
                  </div>';
          if(!empty($result['passage'])){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Passage</div>
                      <div class="title-body">'.$result['passage']->paragraph_content.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Question</div>
                    <div class="title-body">'.$result['question']->question_content.'</div>
                  </div>';
          if($result['question']->question_type == 1){
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Options</div>
                      <div class="title-body"><ul>';
            $answer = '';
            if(!empty($result['options'])){
              foreach($result['options'] as $row){
                if($row->option_answer == 1){
                  $answer .= ' ('.$row->option_number.') '.$row->option_content;
                }
                $list.='<li>('.$row->option_number.') '.$row->option_content.'</li>';
              }
            }
            $list.='</ul></div></div>';
            $list.='<div class="form-group col-sm-12">
                      <div class="title-header">Answer</div>
                      <div class="title-body">'.$answer.'</div>
                    </div>';
          }
          $list.='<div class="form-group col-sm-12">
                    <div class="title-header">Solution</div>
                    <div class="title-body">'.$result['question']->question_solution.'</div>
                  </div>';
          
          $list.='</div>';
        
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Success';
          $returnData['title'] 		= "Question";
          $returnData['body'] 		= $list;
        }else{
          $returnData['st'] 		= 0;
          $returnData['message'] 	= 'Passage not found';
        }
      }
      print_r(json_encode($returnData));
    }
  }
}
?>
