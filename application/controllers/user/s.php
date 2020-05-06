<?php $question_paper_id = '';
    $student_id = $this->session->userdata('user_id');
    $exam_id    = $this->input->post('exam_id');
    $attempt    = $this->input->post('attempt');
    $myexam     = $this->user_model->get_student_examdetails($student_id, $exam_id, $attempt);
    $this->data['answer']       = $this->user_model->get_student_exam_question_details($student_id, $exam_id, $attempt);
    $this->data['myexams']      = $myexam;
    $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
    if(!empty($question_paper)) {
       $question_paper_id =  $question_paper['question_paper_id'];
    }
    $this->data['questions']    = array(); 
    $section_ids = $this->common->get_section_ids_byexam_id($exam_id);
    $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids);
     //echo '<pre>';print_r($questions); die();
    if(!empty($questions)) {
        foreach($questions as $key=>$question){
            $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
            $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
            $questions[$key]->subject_name= $sectionDet['section_name'];
            
        }
    }
    //echo '<pre>';print_r($questions); die();
    $this->data['questions']    = $questions;
    // show($this->data);
    echo $this->load->view('student/student_exams_details_view', $this->data, TRUE);
    ?>