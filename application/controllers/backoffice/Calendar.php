<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends Direction_Controller {

	  public function __construct() {
        parent::__construct();
        if(!check_module_permission('calendar')){redirect('404');}
    }

    public function get_calendar_events(){
      $sdate = date('Y-m-d',strtotime($_GET['start']));
      $edate = date('Y-m-d',strtotime($_GET['end']));
      $data = array();
      $schedules = $this->calendar_model->get_schedules($sdate,$edate);
      $data = $this->get_calendar_data($schedules);
      print_r(json_encode($data,2));
    }

    public function get_calendar_classes(){
      $sdate = date('Y-m-d',strtotime($_GET['start']));
      $edate = date('Y-m-d',strtotime($_GET['end']));
      $data = array();
      $schedules = $this->calendar_model->get_all_classes($sdate,$edate);
      $data = $this->get_calendar_classes_data($schedules);
      print_r(json_encode($data,2));
    }

    public function reschedule_permission(){
      if($_GET['id']){
        $type = $this->calendar_model->get_schedule_details($_GET['id']);
        if($type->schedule_type==1){
          $module = 'exam_management';
          $fields = $this->calendar_model->get_exam_schedule_details($type->schedule_link_id);
          $fields['schedule_date'] = date('d-m-Y D',strtotime($fields['schedule_date']));
          $fields['schedule_end_time'] = date('h:i a',strtotime($fields['schedule_end_time']));
          $fields['schedule_start_time'] = date('h:i a',strtotime($fields['schedule_start_time']));
          if($fields['examstatus'] == 1){$fields['statusname']='Scheduled';$fields['newstatusname']='Start exam';}
          if($fields['examstatus'] == 2){$fields['statusname']='Started';$fields['newstatusname']='Finish exam';}
          if($fields['examstatus'] == 3){$fields['statusname']='Finished';$fields['newstatusname']='Publish exam result';}
          if($fields['examstatus'] == 4){$fields['statusname']='Result published';$fields['newstatusname']='Close exam';}
          if($fields['examstatus'] == 5){$fields['statusname']='Closed';$fields['newstatusname']='Deactivate';}
          if($fields['examstatus'] == -1){$fields['statusname']='Deactivated';$fields['newstatusname']='';}
          if($fields['result_immeadiate']){
            $fields['result_immeadiate']='Mock';
          }else{
            $fields['result_immeadiate']='Final';
          }
        }
        if($type->schedule_type==2){
          $module = 'class_schedule';
          if(!$type->staff_id && !$type->schedule_room){
            $fields = $this->calendar_model->get_batch_schedule_details_no_room_faculty($type->schedule_id);
            $fields['classroom_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No class room available';
            $fields['faculty_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No faculty available to take this class';
          }
          if(!$type->schedule_room && $type->staff_id){
            $fields = $this->calendar_model->get_batch_schedule_details_noroom($type->schedule_id);
            $fields['classroom_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No class room available';
          }
          if(!$type->staff_id && $type->schedule_room){
            $fields = $this->calendar_model->get_batch_schedule_details_nofaculty($type->schedule_id);
            $fields['faculty_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No faculty available to take this class';
          }
          if($type->staff_id && $type->schedule_room){
            $fields = $this->calendar_model->get_batch_schedule_details($type->schedule_id);
            // show($type);
          }
          $fields['schedule_date'] = date('d-m-Y',strtotime($fields['schedule_date']));
          $fields['schedule_end_time'] = date('h:i a',strtotime($fields['schedule_end_time']));
          $fields['schedule_start_time'] = date('h:i a',strtotime($fields['schedule_start_time']));
          $fields['reschedule_modal_datetime'] = $fields['schedule_date'].'&nbsp;&nbsp;&nbsp;'.$fields['schedule_start_time'].' to '.$fields['schedule_end_time'];
        }
        
        $data['st'] = FALSE;
        $data['examst'] = FALSE;
        if(check_module_permission($module)){
          $data['st'] = TRUE;
          if(isset($fields['newstatusname']) && $fields['newstatusname']!=''){
            $data['examst'] = TRUE;
          }
          if(isset($fields['examstatus']) && $fields['examstatus']!=1){
            $data['st'] = FALSE;
          }
        }
        $data['data'] = $fields;
      }else{
        $data['st'] = FALSE;
      }
      print_r(json_encode($data));
    }
    
    public function assign_learning_module(){
      if($_GET['id']){
        $type = $this->calendar_model->get_schedule_details($_GET['id']);
        if($type->schedule_type==1){
          $module = 'exam_management';
          $fields = $this->calendar_model->get_exam_schedule_details($type->schedule_link_id);
          $fields['schedule_date'] = date('d-m-Y D',strtotime($fields['schedule_date']));
          $fields['schedule_end_time'] = date('h:i a',strtotime($fields['schedule_end_time']));
          $fields['schedule_start_time'] = date('h:i a',strtotime($fields['schedule_start_time']));
          if($fields['examstatus'] == 1){$fields['statusname']='Scheduled';$fields['newstatusname']='Start exam';}
          if($fields['examstatus'] == 2){$fields['statusname']='Started';$fields['newstatusname']='Finish exam';}
          if($fields['examstatus'] == 3){$fields['statusname']='Finished';$fields['newstatusname']='Publish exam result';}
          if($fields['examstatus'] == 4){$fields['statusname']='Result published';$fields['newstatusname']='Close exam';}
          if($fields['examstatus'] == 5){$fields['statusname']='Closed';$fields['newstatusname']='';}
          if($fields['result_immeadiate']){
            $fields['result_immeadiate']='Mock';
          }else{
            $fields['result_immeadiate']='Final';
          }
        }
        if($type->schedule_type==2){
          $module = 'class_schedule';
          if(!$type->staff_id && !$type->schedule_room){
            $fields = $this->calendar_model->get_batch_schedule_details_no_room_faculty($type->schedule_id);
            $fields['classroom_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No class room available';
            $fields['faculty_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No faculty available to take this class';
          }
          if(!$type->schedule_room && $type->staff_id){
            $fields = $this->calendar_model->get_batch_schedule_details_noroom($type->schedule_id);
            $fields['classroom_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No class room available';
          }
          if(!$type->staff_id && $type->schedule_room){
            $fields = $this->calendar_model->get_batch_schedule_details_nofaculty($type->schedule_id);
            $fields['faculty_name'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No faculty available to take this class';
          }
          if($type->staff_id && $type->schedule_room){
            $fields = $this->calendar_model->get_batch_schedule_details($type->schedule_id);
          }
          $fields['schedule_date'] = date('d-m-Y',strtotime($fields['schedule_date']));
          $fields['schedule_end_time'] = date('h:i a',strtotime($fields['schedule_end_time']));
          $fields['schedule_start_time'] = date('h:i a',strtotime($fields['schedule_start_time']));
          $fields['reschedule_modal_datetime'] = $fields['schedule_date'].'&nbsp;&nbsp;&nbsp;'.$fields['schedule_start_time'].' to '.$fields['schedule_end_time'];
          $learningModule = $this->calendar_model->get_learning_module_schedule_details($type->schedule_id);
          // show($learningModule);
          $fields['assinged_module_flag'] = 0;
          if($learningModule){
            $fields['learning_module'] = '<a class="close" data-dismiss="modal" onclick="view_learning_module('.$learningModule['learning_module_id'].','.$type->schedule_id.');">'.$this->common->get_name_by_id('am_learning_module','learning_module_name',array('id'=>$learningModule['learning_module_id'])).'</a>';
          }else{
            $fields['assinged_module_flag'] = 1;
            $fields['learning_module'] = '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i>&nbsp;&nbsp; No learning module assigned';
          }
        }
        
        $data['st'] = FALSE;
        $data['examst'] = FALSE;
        if(check_module_permission($module)){
          $data['st'] = TRUE;
          if(isset($fields['newstatusname']) && $fields['newstatusname']!=''){
            $data['examst'] = TRUE;
          }
          if(isset($fields['examstatus']) && $fields['examstatus']!=1){
            $data['st'] = FALSE;
          }
        }
        $data['data'] = $fields;
      }else{
        $data['st'] = FALSE;
      }
      print_r(json_encode($data));
    }

    public function get_calendar_filter_content($type,$type_id=NULL){
      if($type=='branch'){
        $table = 'am_institute_master';
        $where = ['institute_type_id'=>2,'status'=>1];
        $result = $this->Common_model->get_from_table_result_object($table,$where);
        $html = '<option value="">Select Branch</option>';
        if(!empty($result)){
          foreach($result as $row){
            $html .='<option value="'.$row->institute_master_id.'">'.$row->institute_name.'</option>';
          }
        }
      }
      if($type=='center'){
        $table = 'am_institute_master';
        $where = ['institute_type_id'=>3,'status'=>1,'parent_institute'=>$type_id];
        $result = $this->Common_model->get_from_table_result_object($table,$where);
        $html = '<option value="">Select Center</option>';
        if(!empty($result)){
          foreach($result as $row){
            $html .='<option value="'.$row->institute_master_id.'">'.$row->institute_name.'</option>';
          }
        }
      }
      if($type=='course'){
        $result = $this->calendar_model->get_courses_in_center($type_id);
        $html = '<option value="">Select Course</option>';
        if(!empty($result)){
          foreach($result as $row){
            $html .='<option value="'.$row->institute_course_mapping_id.'">'.$row->class_name.'</option>';
          }
        }
      }
      if($type=='batch'){
        $result = $this->calendar_model->get_batches_in_center_course($type_id);
        $html = '<option value="">Select Batch</option>';
        if(!empty($result)){
          foreach($result as $row){
            $html .='<option value="'.$row->batch_id.'">'.$row->batch_name.'</option>';
          }
        }
      }
      print_r($html);
    }

    /** Private Functions begins */

    private function get_calendar_data($schedules){
      if(!empty($schedules)){
        $k=0;
        foreach($schedules as $v){ 
          $data[$k]=array(
            'title'=>$v->schedule_description,
            'start'=>$v->schedule_date.'T'.$v->schedule_start_time,
            'end'=>$v->schedule_date.'T'.$v->schedule_end_time,
            'url'=>'javascript:reschedule('.$v->schedule_id.');'
          );
          if($v->schedule_type==2 && (empty($v->schedule_room) || empty($v->staff_id))){
            $data[$k]['className'] = 'calendar_class_conflict';
          }else{
            if($v->class_taken==1) {
              $data[$k]['color'] = '#c9c8c7';  
            } else {
              $data[$k]['color'] = $v->schedule_color;
            }
          }
          $k++;
        }
        return $data;
      }
    }
    
    private function get_calendar_classes_data($schedules){
      if(!empty($schedules)){
        $k=0;
        foreach($schedules as $v){
          $data[$k]=array(
            'title'=>$v->schedule_description,
            'start'=>$v->schedule_date.'T'.$v->schedule_start_time,
            'end'=>$v->schedule_date.'T'.$v->schedule_end_time,
            'url'=>'javascript:assign_learning_module('.$v->schedule_id.');'
          );
          if($v->schedule_type==2 && (empty($v->schedule_room) || empty($v->staff_id))){
            $data[$k]['className'] = 'calendar_class_conflict';
          }else{
            $data[$k]['color'] = $v->schedule_color;
          }
          $k++;
        }
        return $data;
      }
    }
  }
?>
