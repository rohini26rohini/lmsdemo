<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        $module="exam_management";
        check_backoffice_permission($module);
    }

    public function exam_template(){
      check_backoffice_permission('create_exam_model');
      $this->data['templates'] = $this->exam_model->get_exam_templates();
      $this->data['sections'] = $this->exam_model->get_model_sections();
      // echo '<pre>';print_r($this->data['templates']);exit;
      $this->data['page']="admin/examManagement/exam_definition";
      $this->data['menu']="exam_management";

      $this->data['breadcrumb'][0]['name']="Exam management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
      $this->data['breadcrumb'][1]['name']="Exam model";
      
      $this->data['menu_item']="create_exam_model";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function exam_section(){
      check_backoffice_permission('create_exam_section');
      $this->data['sections'] = $this->exam_model->get_model_sections();
      // show($this->data['sections']);
      $this->data['page']="admin/examManagement/exam_sections";
      $this->data['menu']="exam_management";

      $this->data['breadcrumb'][0]['name']="Exam management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
      $this->data['breadcrumb'][1]['name']="Exam section";
      
      $this->data['menu_item']="create_exam_section";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function section_definition(){
      check_backoffice_permission('create_exam_section');
      $this->data['subjects'] = $this->subject_model->get_all_subjects_subjectype();
      // echo '<pre>';print_r($this->data['subjects']);exit;
      $this->data['page']="admin/examManagement/exam_section_definition";
      $this->data['menu']="exam_management";

      $this->data['breadcrumb'][0]['name']="Exam management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
      $this->data['breadcrumb'][1]['name']="Exam section";
      
      $this->data['menu_item']="create_exam_section";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function section_definition_edit(){
      check_backoffice_permission('create_exam_section');
      if($_GET['id']>0){
        $this->data['section'] = $this->exam_model->get_model_section($_GET['id']);
        $this->data['details'] = $this->exam_model->get_model_section_detail($_GET['id']);
        $this->data['modules'] = $this->subject_model->get_full_modules();
        $this->data['subjects'] = $this->subject_model->get_full_subjects();
        
        // echo '<pre>';print_r($this->data['subjects']);exit;
        $this->data['page']="admin/examManagement/exam_section_definition_edit";
        $this->data['menu']="exam_management";
  
        $this->data['breadcrumb'][0]['name']="Exam management";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
        $this->data['breadcrumb'][1]['name']="Exam section";
        
        $this->data['menu_item']="create_exam_section";
        $this->load->view('admin/layouts/_master.php',$this->data);
      }else{
        redirect('404');
      }
    }

    public function define_exam_sections(){
      check_backoffice_permission('create_exam_model');
      if($_GET['id']>0){
        $this->data['sections'] = $this->exam_model->get_exam_section($_GET['id']);
        $this->data['exam'] = $this->exam_model->get_exam_model($_GET['id']);
        $this->data['page']="admin/examManagement/exam_definition_section_list";
        $this->data['menu']="exam_management";
  
        $this->data['breadcrumb'][0]['name']="Exam management";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
        $this->data['breadcrumb'][1]['name']="Exam template";
        
        $this->data['menu_item']="create_exam_model";
        $this->load->view('admin/layouts/_master.php',$this->data);
      }else{
        redirect('404');
      }
    }

    public function list_exam_paper(){
      check_backoffice_permission('create_question_paper');
      $this->data['questionpapers'] = $this->exam_model->get_all_exam_papers();
      $this->data['examtemplates'] = $this->exam_model->get_exam_templates_for_question_papers();
      $this->data['page']="admin/examManagement/question_papers_list";
      $this->data['menu']="exam_management";

      $this->data['breadcrumb'][0]['name']="Exam management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
      $this->data['breadcrumb'][1]['name']="Exam papers";
      
      $this->data['menu_item']="create_question_paper";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function exam_paper(){
      check_backoffice_permission('create_question_paper');
      if($_GET['id']){
        if(count($this->exam_model->scheduled_question_papers($_GET['id']))){
          redirect('404');
        }
        $this->data['question_paper'] = $this->exam_model->get_question_paper($_GET['id']);
        if(!empty($this->data['question_paper'])){
          $this->data['questions'] = $this->exam_model->get_question_paper_questions($_GET['id']);
          $this->data['sections'] = $this->exam_model->get_model_sections_by_model_id($this->data['question_paper']->exam_definition_id);
          if(!empty($this->data['sections'])){
            foreach($this->data['sections'] as $key=>$val){
              $this->data['sections'][$key]->count=0;
              foreach($this->data['questions'] as $question){
                if($val->id==$question->sectionId){
                  $this->data['sections'][$key]->count++;
                }
              }
            }
          }
          $this->data['page']="admin/examManagement/question_select";
          $this->data['menu']="exam_management";
    
          $this->data['breadcrumb'][0]['name']="Exam management";
          $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
          $this->data['breadcrumb'][1]['name']="Exam papers";
          $this->data['breadcrumb'][1]['url']=base_url('backoffice/exam-paper');
          $this->data['breadcrumb'][2]['name']="Create exam paper";
          
          $this->data['menu_item']="create_question_paper";
          $this->load->view('admin/layouts/_master.php',$this->data);
        }else{
          redirect('404');
        }
      }else{
        redirect('404');
      }
    }

    public function auto_generate_exam_paper(){
      check_backoffice_permission('create_question_paper');
      $this->data['questionpapers'] = $this->exam_model->get_all_exam_papers();
      $this->data['examtemplates'] = $this->exam_model->get_exam_templates_for_question_papers();
      $this->data['page']="admin/examManagement/auto_generate_exam_paper";
      $this->data['menu']="exam_management";

      $this->data['breadcrumb'][0]['name']="Exam management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-management');
      $this->data['breadcrumb'][1]['name']="Exam papers";
      $this->data['breadcrumb'][1]['url']=base_url('backoffice/exam-paper');
      $this->data['breadcrumb'][2]['name']="Auto generate question papers";
      
      $this->data['menu_item']="create_question_paper";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    public function exam_schedule(){
      check_backoffice_permission('exam_schedule');
      $this->data['exammodels'] = $this->exam_model->get_exam_templates();
      $this->data['centers'] = $this->exam_model->get_centers();
      if(isset($_GET['id'])){
        $this->data['details'] = $this->exam_model->get_exam_schedule_from_calendar($_GET['id']);
      }
      $this->data['page']="admin/examManagement/exam_schedule";
      $this->data['menu']="exam_management";

      $this->data['breadcrumb'][0]['name']="Exam management";
      $this->data['breadcrumb'][0]['url']=base_url('backoffice/material-management');
      $this->data['breadcrumb'][1]['name']="Exam schedule";
      
      $this->data['menu_item']="exam_schedule";
      $this->load->view('admin/layouts/_master.php',$this->data);
    }

    /********************** API calls *********************/

    function save_exam_description(){
      if($_POST){
        $this->form_validation->set_rules('examname', 'Exam name', 'required');
        $this->form_validation->set_rules('examduration', 'Exam duration', 'required');
        $this->form_validation->set_rules('examtype', 'Exam type', 'required');
        if($this->form_validation->run()){
          if($this->exam_model->check_examname($this->input->post('examname'))){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'This name is already used please define a new exam name.';
            print_r(json_encode($returnData));
            exit;
          }
          $exam_deff = array(
                          'exam_name'=>$this->input->post('examname'),
                          'duration_in_min'=>$this->input->post('examduration'),
                          'follow_section_sequnce'=>0,
                          'version'=>1
                        );
          if($this->input->post('examtype')==3){
            $exam_deff['follow_section_sequnce']=1;
          }
          $sections = $this->input->post('sections');
          $presections = $this->input->post('presection');
          if(empty($sections) || empty($presections)){
            if($this->input->post('examtype')==3 || 2){
              $returnData['st'] 		  = 0;
              $returnData['message'] 	= 'Please define session names';
              print_r(json_encode($returnData));
              exit;
            }
            // For type 1
            $sess_data[0]=array(
                              'duration_in_min'=>$exam_deff['duration_in_min'],
                              'section_name'=>$exam_deff['exam_name'],
                              'sequnce'=>1,
                              'version'=>1
                            );
          }else{
            // For type 2 and 3
            $sess_count = count($sections);
            foreach($sections as $key=>$val){
              $sess_data[$key]=array(
                                  'duration_in_min'=>$exam_deff['duration_in_min']/$sess_count,
                                  'section_name'=>$val,
                                  'sequnce'=>$key+1,
                                  'version'=>1
                                );
            }
          }
          if(!empty($exam_deff) && !empty($sess_data)){
            $db_response = $this->exam_model->save_exam_description($exam_deff,$sess_data,$presections);
            if($db_response){
              $returnData['st'] 		  = 1;
              $returnData['message'] 	= 'New exam model created please define subjects and modules';
              $returnData['data'] 		= $db_response;
            }else{
              $returnData['st'] 		  = 0;
              $returnData['message'] 	= 'Exam not saved please try again later';
            }

          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Exam not saved please try again later';
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

    public function update_section_description(){
      if($_POST){
        $this->form_validation->set_rules('section_name', 'Section name', 'required');
        $this->form_validation->set_rules('duration_in_min', 'Section duration', 'required');
        if($this->form_validation->run()){
          $detail_id = $this->input->post('detail_id');
          $number_of_questions = $this->input->post('number_of_questions');
          $positivemark = $this->input->post('positivemark');
          $negativemark = $this->input->post('negativemark');
          $section[0] = array(
            'id'=>$this->input->post('section_id'),
            'section_name'=>$this->input->post('section_name'),
            'duration_in_min'=>$this->input->post('duration_in_min')
          );
          if(count($detail_id)==count($number_of_questions) && count($detail_id)==count($positivemark) && count($detail_id)==count($negativemark)){
            $section_details = $this->exam_model->get_exam_section_details($detail_id);
            // echo '<pre>'; print_r($section_details);exit;
            foreach($detail_id as $k=>$det_id){
              if(!$number_of_questions[$k]){
                $returnData['st'] 		  = 0;
                $returnData['message'] 	= 'Please provide a valid number of questions';
                print_r(json_encode($returnData));
                exit;
              }
              $detail[$k]=array(
                'id'=>$det_id,
                'mark_per_question'=>$positivemark[$k],
                'negative_mark_per_question'=>$negativemark[$k],
                'no_of_questions'=>$number_of_questions[$k]
              );
              $valid_detail[$k]=$detail[$k];
              $valid_detail[$k]['subject_id']=$section_details[$k]->subject_id;
            }
            foreach($valid_detail as $v1){
              foreach($valid_detail as $v2){
                if($v1['id']!=$v2['id']){
                  if($v1['subject_id']==$v2['subject_id']){
                    if($v1['mark_per_question']==$v2['mark_per_question'] && $v1['negative_mark_per_question']==$v2['negative_mark_per_question']){
                      $returnData['st'] 		  = 0;
                      $returnData['message'] 	= 'Please define different mark distribution for identical modules';
                      print_r(json_encode($returnData));
                      exit;
                    }
                  }
                }
              }
            }
            if($this->exam_model->update_exam_section_config($section) || $this->exam_model->update_exam_section_detail($detail)){
              $returnData['st'] 		  = 1;
              $returnData['message'] 	= 'Successfully saved';
            }else{
              $returnData['st'] 		  = 0;
              $returnData['message'] 	= 'No new changes found';
            }
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Some fields are missing';
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

    public function get_exam_section(){
      if($_GET['id']){
        $data['section'] = $this->exam_model->get_section($_GET['id']);
        $data['details'] = $this->exam_model->get_section_detail($_GET['id']);
        // $data['subjects'] = $this->subject_model->get_full_subjects();
        $data['modules'] = $this->subject_model->get_full_modules();
        if(!empty($data['section'])){
          if(empty($data['details'])){
            //type 1

          }else{
            //type 2 and 3
            $html = $this->load->view('admin/examManagement/html/exam_definition_details',$data,TRUE);
            $returnData['st'] 		= 1;
            $returnData['data'] 	= $html;
          }
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Section not found';
        }
      }else{
				$returnData['st'] 		  = 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_modules(){
      if($_GET){
        if($_GET['id']){
          $html = '<option value="">Select a module</option>';
          $modules = $this->exam_model->get_modules_from_subjectid($_GET['id']);
          if(!empty($modules)){
            foreach($modules as $row){
              $html = $html.'<option value="'.$row->subject_id.'">'.$row->subject_name.'</option>';
            }
          }
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Subject not found';
          $returnData['html'] 	= $html;
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Subject not found';
        }
      }else{
				$returnData['st'] 		  = 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function save_section_description(){
      if($_POST){
        $this->form_validation->set_rules('section_name', 'Section name', 'trim|required');
        if($this->form_validation->run()){
          $modules = $this->input->post('module');
          $positivemark = $this->input->post('positivemark');
          $negativemark = $this->input->post('negativemark');
          $section_name = $this->input->post('section_name');
          foreach($modules as $key=>$val){
            $data[$key] = array(
              'mark_per_question'=>$positivemark[$key],
              'negative_mark_per_question'=>$negativemark[$key],
              'version'=>1,
              'subject_id'=>$val,
            );
          }
          $section_id = $this->input->post('section_id');
          if(!empty($section_id)){
            $section_data[0]=array(
              'id'=>$section_id,
              'section_name'=>$section_name
            );
            foreach($data as $k=>$v){
              $data[$k]['exam_section_config_id']=$section_id;
            }
            $result = $this->exam_model->update_section_detail_config($section_data,$data,$section_id);
          }else{
            $result = $this->exam_model->save_section_detail_config($section_name,$data);
          }
          if($result){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Section information successfully saved';
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Server busy please try again later';
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

    public function delete_section(){
      if($_POST){
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required');
        if($this->form_validation->run()){
          if($this->exam_model->delete_section($this->input->post('section_id'))){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Section deleted successfully';
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= validation_errors();
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

    public function exam_model_save_preview(){
      if($_POST){
        $id = $this->input->post('exam_definition_id');
        if(!empty($id)){
          if($this->exam_model->check_examname($this->input->post('examname'),$id)){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'This name is already used please define a new exam name.';
            print_r(json_encode($returnData));
            exit;
          }
          $exam_model = $this->exam_model->get_exam_model_save_preview($id);
          $exam_instructions = '';
          $exam_calc_avail = '';
          $data['title'] = 'Please review and click on Finish button to complete the exam model creation';
          $body = '<div class="row"><div class="table-responsive table_language">
                    <table class="table table-bordered table-striped table-sm">
                      <tr>
                        <th>Section name</th>
                        <th>Module name</th>
                        <th>No. of questions</th>
                        <th>Mark per question</th>
                        <th>Negative mark</th>
                      </tr>';
          if(!empty($exam_model)){
            $exam_instructions = $exam_model[0]->instructions;
            $exam_calc_avail = $exam_model[0]->calc_avail;
            foreach($exam_model as $row){
              $body  = $body.'<tr>
                                <td>'.$row->section_name.'</td>
                                <td>'.$row->subject_name.'</td>
                                <td>'.$row->no_of_questions.'</td>
                                <td>'.$row->mark_per_question.'</td>
                                <td>'.$row->negative_mark_per_question.'</td>
                              </tr>';
            }
          }
          $body .= '</table></div></div>';
          $body .= '<div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Calculator Required<span class="req redbold">*</span></label>
                          <select onchange="calculator_available" name="calculator_available" id="calculator_available" class="form-control">';
          if($exam_calc_avail==0){$body .= '<option selected value="0">No</option>';}else{$body .= '<option value="0">No</option>';}
          if($exam_calc_avail==1){$body .= '<option selected value="1">Yes</option>';}else{$body .= '<option value="1">Yes</option>';}
          $body .= '</select>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Instruction</label>
                          <textarea class="ckeditor" name="instruction" id="instruction">'.$exam_instructions.'</textarea>
                        </div>
                      </div>
                    </div>';
          $data['body'] = $body;
          $data['footer'] = '<button type="submit" class="btn btn-success">Finish</button>';
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Please review the exam model';
          $returnData['data'] 		= $data;
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

    public function finish_exam_model_creation(){
      if($_POST){
          $id = $this->input->post('exam_definition_id');
          $data['exam_name'] = $this->input->post('examname');
          $data['calc_avail'] = $this->input->post('calculator_available');
          $data['instructions'] = $this->input->post('instruction');
          $data['instrct_avail'] = 1;
          if(empty(str_replace(' ','',$data['instructions']))){$data['instrct_avail'] = 0;}
          if(!empty($id) && !empty($data['exam_name'])){
            $this->exam_model->update_exam_model($id,$data);
            $result = $this->exam_model->finish_exam_model_creation($id);
            if($result){
              $returnData['st'] 		  = 1;
              $returnData['message'] 	= 'Exam model creation successfully completed';
            }else{
              $returnData['st'] 		  = 0;
              $returnData['message'] 	= 'Server busy please try again later';
            }
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Network Error please try again later';
          }
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_batch_in_date_center(){
      if($_POST){
        $date = date('Y-m-d',strtotime($this->input->post('examdate')));
        $center = $this->input->post('center');
        $batches = $this->exam_model->get_batch_in_date_center($date,$center);
        $external_candidate_batch = $this->exam_model->get_external_candidate_batch_in_date_center($date,$center);
        $batches = array_merge($batches,$external_candidate_batch);
        if(!empty($batches)){
          $html = '<option value="">Select a batch</option>';
          foreach($batches as $row){
            $batch_name = $row->batch_name;
            if($row->batch_status == -1){$batch_name = $batch_name.' (External Candidate Batch)';}
            $html = $html.'<option value="'.$row->batch_id.'">'.$batch_name.'</option>';
          }
        }else{
          $html = '<option value="">No batch is available at this date</option>';
        }
				$returnData['st'] 		= 1;
				$returnData['html'] 	= $html;
      }else{
				$returnData['st'] 		  = 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_exam_paper_model(){
      if($_POST){
        $exammodel = $this->input->post('exammodel');
        $papers = $this->exam_model->get_exam_papers($exammodel);
        $html = '';
        if(!empty($papers)){
          foreach($papers as $row){
            $html = $html.'<option value="'.$row->id.'">'.$row->exam_paper_name.'</option>';
          }
        }
				$returnData['st'] 		= 1;
				$returnData['html'] 	= $html;
      }else{
				$returnData['st'] 		  = 0;
				$returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function get_exam_rooms_center(){
      if($_POST){
        $center = $this->input->post('center');
        $rooms = $this->exam_model->get_rooms_center_branch($center);
        if(!empty($rooms)){
          $html = '<option value="">Select a room</option>';
          foreach($rooms as $row){
            $html = $html.'<option value="'.$row->room_id.'">'.$row->institute_name.' - '.$row->classroom_name.'</option>';
          }
        }else{
          $html = '<option value="">No rooms available for this center</option>';
        }
        $returnData['st'] 		= 1;
        $returnData['html'] 	= $html;
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Network Error';
      }
      print_r(json_encode($returnData));
    }

    public function schedule_exam(){
      if($_POST){
        $this->form_validation->set_rules('examdate', 'Exam date', 'trim|required');
        $this->form_validation->set_rules('starttime', 'Exam start time', 'trim|required');
        $this->form_validation->set_rules('batch', 'Batch', 'trim|required');
        $this->form_validation->set_rules('exammodel', 'Exam model', 'trim|required');
        $this->form_validation->set_rules('examname', 'Exam name', 'trim|required');
        $this->form_validation->set_rules('examroom', 'Exam room', 'trim|required');
        $this->form_validation->set_rules('result', 'Result publishment', 'trim|required');
        if($this->form_validation->run()){
          $examdate = $this->input->post('examdate');
          $batch = $this->input->post('batch');
          $exammodel = $this->input->post('exammodel');
          $examname = $this->input->post('examname');
          $exam = $this->exam_model->get_exam_model($exammodel);
          $start_time = date('H:i:s',strtotime($this->input->post('starttime')));
          $end_time = date('H:i:s',strtotime($this->input->post('endtime')));
          // $end_time = date('H:i:s',strtotime($start_time)+$exam ->duration_in_min*60);
          $exampapers = $this->input->post('exampapers');
          $examroom = $this->input->post('examroom');
          $result = (int)$this->input->post('result');
          $date = date('Y-m-d',strtotime($examdate));
          $schedule_id = $this->input->post('schedule_id');
          $calendar_schedule_id = $this->input->post('calendar_schedule_id');
          if(empty($schedule_id)){$schedule_id=0;}
          if(empty($calendar_schedule_id)){$calendar_schedule_id=0;}
          if(strtotime($start_time)>strtotime($end_time)){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Invalid time';
            print_r(json_encode($returnData));
            exit;
          }
          if($result==0){
            $starttime = date('i',strtotime($examdate.' '.$start_time));
            $endtime = date('i',strtotime($examdate.' '.$end_time));
            if($exam->duration_in_min != ($endtime-$starttime)){
              $returnData['st'] 		  = 2;
              $returnData['message'] 	= 'Invalid time';
              print_r(json_encode($returnData));
              exit;
            }
          }
          if(!$this->schedule->check_batch_availability($batch,$date,$start_time,$end_time,$calendar_schedule_id)){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'This batch already have a schedule at this time';
            print_r(json_encode($returnData));
            exit;
          }
          if(!$this->schedule->check_exam_room_eligibility($examroom,$batch,$date,$start_time,$end_time,NULL,NULL,$calendar_schedule_id)){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'The total number of students in this batch exceeds the available seats in this room at this time.';
            print_r(json_encode($returnData));
            exit;
          }
          if(!$this->input->post('force_exam_schedule')){
            $module_completion = $this->schedule->check_batch_exam_modules_completion($batch,$date,$start_time,$exammodel);
            if(!$module_completion['status']){
              $returnData['st'] 		  = 3;
              $returnData['message'] 	= 'Some classes are pending for this batch';
              $returnData['modules'] 	= $module_completion['data'];
              print_r(json_encode($returnData));
              exit;
            }
          }
          $data = [];
          $schedule_data = array(
            'batch_id'=>$batch,
            'end_date_time'=>date('Y-m-d H:i:s',strtotime($examdate.' '.$end_time)),
            'start_date_time'=>date('Y-m-d H:i:s',strtotime($examdate.' '.$start_time)),
            'name'=>$examname,
            'no_of_attempts'=>0,
            'no_of_question_papers'=>count($exampapers),
            'result_immeadiate'=>$result,
            'no_of_attempts'=>!$result,
            'status'=>1,
            'version'=>1,
            'exam_definition_id'=>$exammodel
          );
          
          if($schedule_id == 0){
            $schedule_id = $this->exam_model->add_exam_schedule($schedule_data); // Add exam schedule for grand master
          }else{
            $this->exam_model->update_exam_schedule($schedule_data,$schedule_id); // Update exam schedule for grand master
            $this->exam_model->delete_exam_scheduled_question_papers($schedule_id);
          }

          $calendar_data=array(
            'schedule_type'=>1,
            'schedule_link_id'=>$schedule_id,
            'schedule_status'=>1,
            'schedule_date'=>date('Y-m-d',strtotime($examdate)),
            'schedule_start_time'=>date('H:i:s',strtotime($start_time)),
            'schedule_end_time'=>date('H:i:s',strtotime($end_time)),
            'schedule_room'=>$examroom,
            'schedule_description'=>'Exam - '.$examname
          );
          
          if(empty($calendar_schedule_id)){
            $this->exam_model->add_exam_schedule_calendar($calendar_data); // Add exam schedule for calendar view
          }else{
            $this->exam_model->update_exam_schedule_calendar($calendar_data,$calendar_schedule_id); // Update exam schedule for calendar view
          }
          if(!empty($exampapers)){
            foreach($exampapers as $k=>$v){
              $schedule_paper_data[$k]=array(
                'question_paper_id'=>$v,
                'exam_schedule_id'=>$schedule_id,
                'version'=>1
              );
            }
          }
          $res = $this->exam_model->add_exam_schedule_papers($schedule_paper_data); // Add question papers for exam schedule
          if($res){
            $students = $this->Common_model->get_student_batch($batch);
            if(!empty($students)){
              $message = 'Exam '.$examname.' is scheduled on '.date('d-M-Y',strtotime($calendar_data['schedule_date'])).' '.date('h:i a',strtotime($calendar_data['schedule_start_time'])).' please login to www.direction.school for more details.';
              foreach($students as $row){
                $mobile_number = $row->mobile_number;
                send_sms($mobile_number,$message);
                $data = array('user_number'=>$mobile_number,'message'=>$row->mobile_number,'type'=>'exam_schedule','status'=>1);
                $this->Common_model->insert('am_sms_notification',$data);
              }
            }
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Successfully saved';
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Server Error';
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

    public function create_question_paper(){
      if($_POST){
        $this->form_validation->set_rules('question_name', 'Question paper name', 'trim|required');
        $this->form_validation->set_rules('exam_model', 'Exam model', 'trim|required');
        if($this->form_validation->run()){
          $duplicate_name = $this->exam_model->check_duplicate_paper_name($this->input->post('question_name'));
          if($duplicate_name){
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'This name is already taken';
            print_r(json_encode($returnData));
            exit;
          }
          $data=array(
            'exam_paper_name'=>$this->input->post('question_name'),
            'exam_definition_id'=>$this->input->post('exam_model'),
            'status'=>1,
            'version'=>1
          );
          $result = $this->exam_model->create_question_paper($data);
          if($result){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'New question paper created successfully please wait taking you to the question paper definition screen';
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

   public function delete_question_paper(){
     if($question_paper_id=$this->input->post('question_paper_id')){
      if(count($this->exam_model->scheduled_question_papers($question_paper_id))){
        $returnData['st'] 		  = FALSE;
      }else{
        $this->exam_model->delete_question_paper($question_paper_id);
        $returnData['st'] 		  = TRUE;
      }
     }else{
      $returnData['st'] 		  = FALSE;
     }
     print_r(json_encode($returnData));
   }

   public function delete_exam_paper(){
    if($exam_id=$this->input->post('exam_id')){
     $this->exam_model->delete_exam_paper($exam_id);
     $returnData['st'] 		  = TRUE;
    }else{
     $returnData['st'] 		  = FALSE;
    }
    print_r(json_encode($returnData));
   }

   public function delete_selected_question(){
    $id=$this->input->post('id');
    $exam_id=$this->input->post('exam_id');
    $section_id=$this->input->post('section_id');
    if($id){

      $question_id = $this->exam_model->delete_selected_question($id,$exam_id);
      $this->exam_model->reorder_exam_paper_questions_after_question_delete($exam_id,$question_id->question_id);
      
      $section_details = $this->exam_model->get_exam_section_details_per_section($section_id);
      foreach($section_details as $k=>$v){
        $details_id[$k] = $v['id'];
      }
      $questions = $this->exam_model->get_exam_details_questions($exam_id,$details_id);
      $count=0;
      if(!empty($questions)){
        $count = count($questions);
      }

      $returnData['st'] 		    = TRUE;
      $returnData['data'] 		  = $question_id->question_id;
      $returnData['count'] 		  = $count;
    }else{
     $returnData['st'] 		    = FALSE;
    }
    print_r(json_encode($returnData));
   }

   public function get_section_selected_questions(){
    $section_id=$this->input->post('section_id');
    $module_id=$this->input->post('module_id');
    $exam_id=$this->input->post('exam_id');
    if($section_id && $exam_id && $module_id){
      $questions = $this->exam_model->get_exam_section_questions($section_id,$exam_id,$module_id);
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
       $exam_paper_id = $this->input->post('exam_id');
       $section_id = $this->input->post('section_id');
       $module_id = $this->input->post('module_id');
       if(!empty($qids)){
        $section_details = $this->exam_model->get_exam_section_details_per_section($section_id);
        foreach($section_details as $k=>$v){
          $details_id[$k] = $v['id'];
        }
        $new_question_ids = $this->exam_model->get_new_question_ids($qids,$exam_paper_id,$module_id);
        $data=array();
        // $count=0;
        // if(!empty($new_question_ids)){
        //   $question_details = $this->exam_model->get_question_subjects($new_question_ids);
        //   $last_question_number = $this->exam_model->get_last_question_number($exam_paper_id,$module_id);
        //   foreach($section_details as $k=>$v){
        //     $section_details[$k]['selected_count']=0;
        //     foreach($question_details as $qk=>$row){
        //       if($v['subject_id']==$row['subject_id']){
        //         $section_details[$k]['selected_count']++;
        //         if(!empty($new_question_ids)){
        //           $last_question_number++;
        //           $data[$qk]=array(
        //             'exam_paper_id'=>$exam_paper_id,
        //             'question_id'=>$question_details[$qk]['question_id'],
        //             'question_number'=>$last_question_number,
        //             'exam_section_details_id'=>$section_details[$k]['id'],
        //             'status'=>1,
        //             'version'=>1
        //           );
        //         }
        //       }
        //     }
        //   }
        // }
        $current_question_number = $this->exam_model->get_last_question_number($exam_paper_id,$details_id);
        if(!empty($new_question_ids)){
          foreach($new_question_ids as $k=>$qid){
            $current_question_number++;
            $data[$k]=array(
              'exam_paper_id'=>$exam_paper_id,
              'question_id'=>$qid,
              'question_number'=>$current_question_number,
              'exam_section_details_id'=>$module_id,
              'status'=>1,
              'version'=>1
            );
          }
        }
        // echo '<pre>';print_r($data);exit;

        $result = $this->exam_model->save_exam_paper_section_questions($exam_paper_id,$module_id,$delete_qids,$data);
        if($result){
          $questions = $this->exam_model->get_exam_details_questions($exam_paper_id,$details_id);
          $count=0;
          if(!empty($questions)){
            $count = count($questions);
          }
          $this->exam_model->reorder_exam_paper_questions($exam_paper_id,$details_id);
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Questions added successfully';
          $returnData['data'] 		= $count;//count($data);
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

   public function save_preview_exam_paper(){
    if($_POST){
      $exam_paper_id = $this->input->post('exam_id');
      $view = $this->input->post('view');
      $details = $this->exam_model->get_exam_section_details_per_exam_paper($exam_paper_id);
      $questions = $this->exam_model->get_question_paper_questions($exam_paper_id);
      foreach($details as $k=>$v){
        $details[$k]['selected']=0;
        foreach($questions as $row){
          if($row->exam_section_details_id==$v['id']){
            $details[$k]['selected']++;
          }
        }
      }
      $valid=1;
      $data['title']="Please verify the details and click on Finish button to save the question paper";
      $returnData['message'] 	= 'Preview and finish';
      $returnData['status'] 	= 1;
      foreach($details as $row){
        if($row['no_of_questions'] != $row['selected']){
          $valid=0;
          $returnData['status'] 	= 0;
          $returnData['message'] 	= 'One or more errors found';
          $data['title']="One or more modules doesnot have required number of questions. Please see the details below for more information";
          break;
        }
      }
      if(!$valid){
        $det=array();
        foreach($details as $k=>$row){
          $det[$row['section_id']]['section_name']=$row['section_name'];
          $det[$row['section_id']]['modules'][$k]=$row;
        }
        $body = '<div class="table-responsive table_language"><table class="table table-bordered table-striped table-sm">';
        foreach($det as $row){
          $body = $body.'<tr><th>'.$row['section_name'].'</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
          $body = $body.'<tr><th>Module Name</th><th>Required questions</th><th>Selected questions</th></tr>';
          foreach($row['modules'] as $modules){
            $body = $body.'<tr>';
            if($modules['no_of_questions']!=$modules['selected']){
              $body = $body.'<td>'.$modules['subject_name'].'&nbsp;&nbsp;&nbsp;<i class="fa fa-times" style="color:red;" aria-hidden="true"></i></td>';
            }else{
              $body = $body.'<td>'.$modules['subject_name'].'&nbsp;&nbsp;&nbsp;<i class="fa fa-check" style="color:green;" aria-hidden="true"></i></td>';
            }
            $body = $body.'<td>'.$modules['no_of_questions'].'</td>';
            $body = $body.'<td>'.$modules['selected'].'</td></tr>';
          }
          $body = $body.'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
        }
        $body = $body.'</table></div>';
      }else{
        $preview=array();
        foreach($questions as $row){
          if(!isset($preview[$row->sectionId])){$preview[$row->sectionId]=array();}
          array_push($preview[$row->sectionId],$row);
        }
        $htmlView['preview'] = $preview;
        if(!$view){
          $htmlView['view'] = 1;
        }else{
          $htmlView['view'] = 0;
        }
        $body = $this->load->view('admin/examManagement/html/exam_paper_preview',$htmlView,TRUE);
        // $chkApprovel = $this->exam_model->chkApprovel($exam_paper_id);
        if(!$view){
          $approvel = '<div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                  <div class="custom-control custom-checkbox MargLeft25">
                      <input type="checkbox" name="approval_chk" class="custom-control-input" id="approval_chk" onChange="approval_chk()" value="1">
                      <label class="custom-control-label" for="approval_chk"> Approval</label>
                  </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 approve_user_div" id="approve_user_div">             
              </div>
          </div>';
          $body .= $approvel;
        }
        $data['footer'] = ' <button onClick="finish_paper()" class="btn btn-success">Finish</button>';
        $data['footer'] .= ' <button onClick="reorder_paper()" class="btn btn-primary">Reorder Questions</button>';
      }
      $data['body']=$body;
      $returnData['st'] 		  = 1;
      $returnData['data']   	= $data;
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
  }

  public function reorder_exam_paper(){
    $exam_paper_id = $this->input->post('exam_id');
    $questions = $this->exam_model->get_question_paper_questions($exam_paper_id);
    $preview=array();
    foreach($questions as $row){
      if(!isset($preview[$row->sectionId])){$preview[$row->sectionId]=array();}
      array_push($preview[$row->sectionId],$row);
    }
    $htmlView['preview'] = $preview;
    $body = $this->load->view('admin/examManagement/html/reorder_exam_paper',$htmlView,TRUE);
    $returnData['st'] 		  = 1;
    $returnData['data']   	= $body;
    print_r(json_encode($returnData));
  }

  public function save_reordered_questions_exam_paper(){
    $exam_paper_id = $this->input->post('exam_id');
    $exam_paper_question_ids = $this->input->post('exam_paper_question_id');
    $questions = $this->exam_model->get_question_paper_questions($exam_paper_id);
    $section_questions = [];
    foreach($questions as $question){
      if(!isset($section_questions[$question->sectionId])){
        $section_questions[$question->sectionId] = [];
      }
      array_push($section_questions[$question->sectionId],$question->id);
    }
    $reordered_section_questions = [];
    foreach($section_questions as $section=>$questions){
      $i=1;
      foreach($exam_paper_question_ids as $question_id){
        if(in_array($question_id,$questions)){
          array_push($reordered_section_questions,array(
            'id'=>$question_id,
            'question_number'=>$i
          ));
          $i++;
        }
      }
    }
    $this->exam_model->update_exam_paper_questions($reordered_section_questions);
    $returnData['st'] 		  = 1;
    print_r(json_encode($returnData));
  }

  public function finish_question_paper(){
    if($_POST){
      $exam_paper_id = $this->input->post('exam_id');
      $approvel_user = $this->input->post('user_id');
      if(!empty($exam_paper_id)){
        $this->exam_model->finish_creating_question_paper($exam_paper_id, $approvel_user);
        if($approvel_user != 0){
          $data1=array(
            "flow_detail_id"=>$approvel_user,
            "entity_id"=>$exam_paper_id
          );
          $this->Common_model->insert('approval_flow_jobs', $data1); 
        }
        $returnData['st'] 		  = 1;
        $returnData['message'] 	= 'Question paper created successfully';
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

  public function get_section_modules(){
    if($_POST){
      $section_id = $this->input->post('section_id');
      if(!empty($section_id)){
        $section_modules = $this->exam_model->get_section_modules($section_id);
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

  public function get_exam_details(){
    if($_POST){
      $exammodel = $this->input->post('exammodel');
      if(!empty($exammodel)){
        $exammodel_details = $this->exam_model->get_exam_model($exammodel);
        $returnData['st'] 		  = 1;
        $returnData['data'] 		= $exammodel_details;
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

  public function get_exam_model_modules(){
    if($_POST){
      $exammodel = $this->input->post('exammodel');
      if(!empty($exammodel)){
        $exammodel_details = $this->exam_model->get_exam_model_modules($exammodel);
        // echo '<pre>';print_r($exammodel_details);exit;
        $returnData['st'] 		  = 1;
        $returnData['data'] 		= $exammodel_details;
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

  public function save_autogenerate_question_paper(){
    if($_POST){
        $random_question_paper = $this->session->userdata('random_question_paper');
        if(!empty($random_question_paper)){
          $data = array(
                        'exam_definition_id'=>$random_question_paper['exam_definition_id'],
                        'exam_paper_name'=>$random_question_paper['question_paper_name'],
                        'status'=>1,
                        'record_status'=>1,
                        'version'=>1
                      );
          $paper_id = $this->exam_model->create_question_paper($data);
          $data = array();
          foreach($random_question_paper['selected_questions'] as $detail){
            if(!isset($temp[$detail['sec_id']])){$temp[$detail['sec_id']]=1;}
            foreach($detail['questions'] as $question){
              array_push($data,array(
                'exam_paper_id'=>$paper_id,
                'question_id'=>$question,
                'question_number'=>$temp[$detail['sec_id']]++,
                'exam_section_details_id'=>$detail['detail_id'],
                'status'=>1,
                'version'=>1,
              ));
            }
          }
          if($this->exam_model->save_exam_paper_questions($data)){
            $returnData['st'] 		  = 1;
            $returnData['message'] 	= 'Exam paper successfully created';
          }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= 'Server error please try again later';
          }
        }else{
          $returnData['st'] 		  = 0;
          $returnData['message'] 	= 'Invalid request please try again later';
        }
    }else{
      $returnData['st'] 		  = 0;
      $returnData['message'] 	= 'Network Error';
    }
    print_r(json_encode($returnData));
  }

  public function autogenerate_question_paper(){
    if($_POST){
      $this->form_validation->set_rules('generate_question_name', 'Question paper name', 'trim|required');
      $this->form_validation->set_rules('generate_exam_model', 'Exam model', 'trim|required');
      if($this->form_validation->run()){
        $details_id = $this->input->post('exam_section_details_id');
        $difficulty = $this->input->post('difficulty');
        $module = array();
        $data = $this->regenerate_question_paper($details_id,$difficulty);
        $combos = $data['combos'];
        $error = $data['error'];
        if(empty($error)){
          $exam_sections = $this->exam_model->get_exam_section($this->input->post('generate_exam_model'));
          if(!empty($exam_sections)){
            foreach($exam_sections as $k=>$row){
              $exam_sections[$k]->questions = array();
              $section_detail = $this->exam_model->get_section_detail($row->id);
              if(!empty($section_detail)){
                foreach($section_detail as $sec){
                  foreach($combos as $ck=>$com){
                    if($com['detail_id'] == $sec->id){
                      $combos[$ck]['sec_id'] = $row->id;
                      $exam_sections[$k]->questions = array_merge($exam_sections[$k]->questions,$com['questions']);
                    }
                  }
                }
              }
            }
            foreach($exam_sections as $k=>$row){
              $exam_section_questions['preview'][$row->id] = array();
              $questions = $this->exam_model->get_questions($row->questions);
              $question_number = 1;
              if(!empty($questions)){
                foreach($questions as $qstn){
                  $sec_qstn = new stdClass;
                  $sec_qstn->id = $qstn->question_id;
                  $sec_qstn->section_name = $row->section_name;
                  $sec_qstn->question_content = $qstn->question_content;
                  $sec_qstn->question_number = $question_number++;
                  array_push($exam_section_questions['preview'][$row->id],$sec_qstn);
                }
              }
            }
          }
          $body = $this->load->view('admin/examManagement/html/auto_generate_exam_paper_preview',$exam_section_questions,TRUE);
          $returnData['st'] 		  = 1;
          $returnData['message'] 	= 'Question paper generated successfully';
          $returnData['data'] 	  = $body;
          $this->session->unset_userdata('random_question_paper');
          $this->session->set_userdata(array('random_question_paper'=>array('selected_questions'=>$combos,
                                                                            'question_paper_name'=>$this->input->post('generate_question_name'),
                                                                            'exam_definition_id'=>$this->input->post('generate_exam_model')
                                                                          )));
        }else{
          $details = $this->exam_model->get_exam_model_modules($this->input->post('generate_exam_model'));
          $error_message 	= '<span style="color:red;">Not enough questions for the following modules</span><br><table class="table table-sm table-bordered"><tr style="color:#fff;background:#014e94;"><th>Subject</th><th>Module</th><th>Difficulty</th><th>Questions shortage</th></tr>';
          $temp=array();
          foreach($error as $row){
            if($row['difficulty'] == 1){$difficulty = 'Easy';}
            if($row['difficulty'] == 2){$difficulty = 'Medium';}
            if($row['difficulty'] == 3){$difficulty = 'Hard';}
            foreach($details as $det){
              if($row['subject_id'] == $det['module_id']){
                if(!isset($temp[$row['subject_id']][$row['difficulty']])){
                  $temp[$row['subject_id']][$row['difficulty']]='';
                  $error_message 	.= '<tr style="color:#fff;background:#fcb212;">
                                        <td>'.$det['subject_name'].'</td>
                                        <td>'.$det['module_name'].'</td>
                                        <td>'.$difficulty.'</td>
                                        <td>'.$row['required_more'].'</td>
                                      </tr>';
                }
              }
            }
          }
          $returnData['st'] 		  = 2;
          $returnData['message'] 	= 'Not enough questions in question bank';
          $returnData['data'] 	= $error_message;
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

  private function regenerate_question_paper($details_id,$difficulty){
    if(!empty($details_id)){
      $combos = array();
      foreach($details_id as $k=>$row){
        $details = $this->exam_model->get_exam_section_details($row);
        if(!isset($module[$details[0]->subject_id][$difficulty[$k]]['questions'])){
          $questions = $this->exam_model->get_module_questions($details[0]->subject_id,$difficulty[$k]);
          $selected_questions = array();
          if(!empty($questions)){
            foreach($questions as $qstn){
              array_push($selected_questions,$qstn->question_id);
            }
          }
          $module[$details[0]->subject_id][$difficulty[$k]]['questions']=$selected_questions;
        }
        array_push($combos,array(
          'detail_id'=>$row,
          'subject_id'=>$details[0]->subject_id,
          'difficulty'=>$difficulty[$k],
          'nos'=>$details[0]->no_of_questions,
          'questions'=>array()
        ));
      }
    }
    $error=array();
    if(!empty($combos)){
      foreach($combos as $k=>$val){
        $questions = $module[$val['subject_id']][$val['difficulty']]['questions'];
        if(count($questions) < $val['nos']){
          $error[$k]=$val;
          $error[$k]['required_more']=$val['nos']-count($questions);
        }else{
          $rand_keys = array();
          $rand_keys = array_rand($questions,$val['nos']);
          if(!empty($rand_keys)){
            if(is_array($rand_keys)){
              foreach($rand_keys as $keys){
                array_push($combos[$k]['questions'],$questions[$keys]);
                unset($questions[$keys]);
              }
            }else{
              array_push($combos[$k]['questions'],$questions[$rand_keys]);
              unset($questions[$rand_keys]);
            }
          }
          $module[$val['subject_id']][$val['difficulty']]['questions'] = $questions;
        }
      }
    }
    return array('combos'=>$combos,'error'=>$error);
  }
  public function get_levelOne_user(){
    $html ='';
    $entityId = $this->input->post('id');
    $users = $this->exam_model->get_levelOne_user($entityId);
    // show($users);
    if(!empty($users)) {
            $html .='<div class="form-group">
                            <label>'.$this->lang->line("approve_users").'<span class="req redbold">*</span></label>
                            <select class="form-control" name="approve_users" id="approve_users">';
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
public function get_approve_status(){
  $materialId = $this->input->post('id');
  $statusInfo = $this->exam_model->get_approve_statusEP($materialId);
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

/******************** Exam Evaluation **********************************************************************/

  public function exam_valuation(){
    check_backoffice_permission('exam_valuation');
    $this->data['exam'] = $this->exam_model->get_exam_valuation();
    $this->data['page']="admin/examManagement/exam_valuation";
    $this->data['menu']="exam_management";
    $this->data['breadcrumb'][0]['name']="Exams To Evaluate";
    $this->data['menu_item']="exam_valuation";
    $this->load->view('admin/layouts/_master.php',$this->data);
  }
  public function exam_descriptive_questions($id){
    check_backoffice_permission('exam_valuation');
    $this->data['questions'] = $this->exam_model->exam_descriptive_questions($id);
    $exam_name = $this->common->get_name_by_id('gm_exam_schedule','name',array('id'=>$id));
    $this->data['page']="admin/examManagement/exam_descriptive_questions";
    $this->data['menu']="exam_management";
    $this->data['breadcrumb'][0]['name']="Exams To Evaluate";
    $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-valuation');
    $this->data['breadcrumb'][1]['name'] = $exam_name;
    $this->data['menu_item'] = "exam_valuation";
    $this->data['exam_name'] = $exam_name;
    $this->load->view('admin/layouts/_master.php',$this->data);
  }
  public function get_single_question($id, $questionId){
    $this->data['exam'] = $this->exam_model->get_QuestionAndGivenAnswer($id, $questionId);
    // show($this->data['exam']);
    $exam_name = $this->common->get_name_by_id('gm_exam_schedule','name',array('id'=>$id));
    $this->data['page']="admin/examManagement/exam_users_question";
    $this->data['menu']="exam_management";
    $this->data['breadcrumb'][0]['name']="Exams To Evaluate";
    $this->data['breadcrumb'][0]['url']=base_url('backoffice/exam-valuation');
    $this->data['breadcrumb'][1]['name'] = $exam_name;
    $this->data['breadcrumb'][1]['url']=base_url('backoffice/exam-descriptive-questions/'.$id);
    $this->data['breadcrumb'][2]['name'] = 'Question';
    $this->data['menu_item'] = "exam_valuation";
    $this->data['exam_name'] = $exam_name;
    $this->load->view('admin/layouts/_master.php',$this->data);
  }

  public function get_answer_evaluate(){
    if($_POST){
      $attempt = $this->input->post('attempt');
      $exam_id = $this->input->post('exam_id');
      $question_id = $this->input->post('question_id');
      $student_id = $this->input->post('student_id');
      $data = $this->exam_model->get_answer_evaluate($attempt,$exam_id,$question_id,$student_id);
      $data['answer'] = base64_decode($data['answer']);
      print(json_encode($data));
    }
  }

  public function save_evaluate_answer(){
    if($_POST){
      $attempt = $this->input->post('attempt');
      $exam_id = $this->input->post('exam_id');
      $question_id = $this->input->post('question_id');
      $student_id = $this->input->post('student_id');
      $mark = $this->input->post('mark');
      $status = $this->exam_model->save_answer_evaluate($attempt,$exam_id,$question_id,$student_id,$mark);
      if($status){
        $returnData['st'] 		  = 1;
        $returnData['message'] 	= 'Question evaluated successfully';
        $returnData['data'] 	  = ['attempt'=>$attempt,'exam_id'=>$exam_id,'question_id'=>$question_id,'student_id'=>$student_id];
      }else{
        $returnData['st'] 		  = 0;
        $returnData['message'] 	= 'Error occured please try again later';
      }
      print_r(json_encode($returnData));
    }
  }
  public function get_questionEP(){
    if($_POST){
      $question_id = $this->input->post('question_id');
      $epId = $this->input->post('epId');
      if(!empty($question_id)){
        $result = $this->exam_model->get_full_question($question_id);
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
                    <a class="btn btn-default add_new_btn btn_add_call addBtnPosition" onclick="view_question_paper('.$epId.',1)">
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
