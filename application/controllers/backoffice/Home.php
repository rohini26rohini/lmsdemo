<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        if($this->uri->segment(2) && strtolower($this->uri->segment(2))!='home' && strtolower($this->uri->segment(3))!='index'){
            $module="basic_configuration";
            check_backoffice_permission($module);
        }else{
            check_backoffice_permission($module=NULL);
        }
    }
    
    public function index(){
        $this->data['title'] = '';
        user_dashboards();
		$this->load->view('admin/dashboard',$this->data); 
    }
    
    public function manage_batch(){
        check_backoffice_permission("manage_batch");
        $this->data['page']          = "admin/batchlist";
		$this->data['menu']          = "basic_configuration";
        $this->data['breadcrumb']    = "Manage Batch";
        $this->data['menu_item']     = "batchlist";
        $this->data['config']        = $this->home_model->get_config();
        $this->data['batchArr']      = $this->Batch_model->get_batch();
        // show($this->data['batchArr']);
        $this->data['groupArr']      = $this->institute_model->get_allgroups();
        $this->data['classesArr']    = $this->Class_model->get_class_list();
		$this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function batch_merge(){
        check_backoffice_permission("batch_merge");
        $this->data['page']          = "admin/batch_merge";
		$this->data['menu']          = "basic_configuration";
        $this->data['breadcrumb'][0]['name']="Manage Batch";
        $this->data['breadcrumb'][0]['url']=base_url('backoffice/manage-batch');
        $this->data['breadcrumb'][1]['name']="Batch Merge";
        $this->data['menu_item']     = "batchlist";
        $this->data['batchArr']      = $this->Batch_model->get_carrentActiveBatch();
        // show($this->db->last_query());
		$this->load->view('admin/layouts/_master.php',$this->data); 
    }

    public function merge_batch(){
        $fBatch = $this->input->post('fbatch');
        $tBatch = $this->input->post('tbatch');
        $studentArr = $this->input->post('students');
        // show($studentArr);
        if($fBatch == $tBatch){
            $res['st']   = 2; 
            $res['msg']  = 'Sorry, you can\'t merge same batch'; 
        }else if(empty($studentArr)){
            $res['st']   = 2; 
            $res['msg']  = 'Select at least one student'; 
        }else{
            $toNewbatch = $this->Batch_model->get_eachStudents($fBatch,$studentArr);
            $fbatchStudentstwo = $this->Batch_model->update_fbatchStudents($fBatch,$studentArr);
            if($fbatchStudentstwo){
                $insertArr = array();
                foreach($toNewbatch as $row){
                    unset($row['student_course_id']);
                    $row['batch_id'] = $tBatch;
                    $row['status'] = 1;
                    array_push($insertArr, $row);
                }
                $this->db->insert_batch('am_student_course_mapping', $insertArr); 
                $res['st']   = 1; 
                $res['msg']  = 'Batch merged successfully.!'; 
            }
        }
        print_r(json_encode($res));
    }

    public function get_fbatchStudents(){
        $fBatch = $this->input->post('fbatch');
        $fbatchStudentsone = $this->Batch_model->get_fbatchStudents($fBatch);
        // show($fbatchStudentsone);
        if(empty($fbatchStudentsone)){
            $html = '<div class="studentList"><ul>No students available in this batch</ul></div>';
        }else{
            $html = '<div class="studentList"><ul><li class="selectall"><span>Select all </span><div class="form-check">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input studentListinput" name="all" value="all">
                    </label></div></li>
                    <script>
                    $(document).ready(function(){
                        $("input[name=all]").click(function(){
                            if($(this).prop("checked") == true){
                                $("input[name=\'students[]\']").prop("checked", true);
                            }else if($(this).prop("checked") == false){
                                $("input[name=\'students[]\']").prop("checked", false);
                            }
                        });
                    });</script>';
            $i = 1;
            foreach($fbatchStudentsone as $studends){
                $html .= '<li class="stulist"><span class="slno">'.$i.'</span><div class="form-check"><label class="form-check-label">'.
                            $this->common->get_name_by_id('am_students','name',array('student_id'=>$studends['student_id'])).
                            '<span>&nbsp; '.$this->common->get_name_by_id('am_students','registration_number',array('student_id'=>$studends['student_id'])).'</span><input type="checkbox" class="form-check-input studentListinput" name="students[]" value="'.$studends['student_id'].'">
                        </label></div></li>';
                $i++;
            }
            $html .= '</ul></div>';
        }
        echo $html;
    }
    
    public function load_batch_ajax() {
        $html = '<thead>
                <tr>
                <th >Sl. No.</th>
                <th >Batch</th>   
                <th >Batch code</th>
                <th >Course</th> 
                <th >Centre</th>                
                <th >'.$this->lang->line("Allocated_Seats/Total_Seats").'</th>                
                <th >Action </th>
             </tr>
            </thead>';
        $batchArr= $this->Batch_model->get_batch();
        if(!empty($batchArr)) { 
            $i=1; 
            foreach($batchArr as $batch){
            $html .= '<tr id="row_'.$batch['batch_id'].'">

                <td>
                    '.$i.'
                </td>
                <td>
                    '.$batch['batch_name'].'
                </td>
                <td>
                    '.$batch['batch_code'].'
                </td>
                <td>
                    '.$batch['class_name'].'
                </td>
                <td>
                     '.$batch['institute_name'].'
                </td>
                <td>';
                    $CI =& get_instance();
                          $allocated=$CI->allocated_students_inbatch($batch['batch_id']);
                $html .= $allocated. " / ".$batch['batch_capacity'];
                $html .='</td><td>
                    <button  type="button" class="btn btn-default option_btn " onclick="get_batch_details('.$batch['batch_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#show" >
                            <i class="fa fa-eye "></i>
                        </button>
                    <button class="btn btn-default option_btn getbatchdetails chartBlockBtn"  title="Edit" id="'. $batch['batch_id'].'">
                        <i class="fa fa-pencil "></i>
                    </button>
                    <button class="btn btn-default option_btn" title="Delete" onclick="delete_fromtable('.$batch['batch_id'].')">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>';

            $i++; 
            }
            $html.='<script>$(document).ready(function () { $(".chartBlockBtn").click(function () { $("#chartBlock").addClass("show");$(".close_btn").fadeIn("200"); });
            $(".close_btn").click(function () {
                            $(this).hide();
                            $("#chartBlock").removeClass(("show"));
                        }); });</script>';
        } 
        
        echo $html;
    }
    
    // function'll return the allocated sets under each batch
    // @author GBS-L
    public function allocated_students_inbatch($batch_id)
    {
    return $this->Batch_model->allocated_students_inbatch($batch_id);
    }
    
    /*
    *   Get list of fees
    *   @params array()
    *   @author GBS-R
    *
    */
    
   public function manage_fees(){
        
        $this->data['page']          = "admin/fees_list_view";
		$this->data['menu']          = "basic_configuration";
        $this->data['breadcrumb']    = "Manage Fees";
        $this->data['menu_item']     = "managefees";
        $this->data['batchArr']      = $this->Batch_model->get_batch();
        $this->data['groupArr']      = $this->institute_model->get_allgroups();
        $this->data['classesArr']    = $this->Class_model->get_class_list();
		$this->load->view('admin/layouts/_master.php',$this->data); 
        
    }
    
     public function get_batchdetails(){

        $id          = $this->input->post('batch_id');
        $result      = $this->Batch_model->get_batchby_id($id);
        $group       = $result->group_master_id;
        $branchlist  = $this->Batch_model->get_where('am_institute_master', array('parent_institute'=>$group,'status'=>1)); 
        $branch      = $result->branch_master_id; 
        $centerlist  = $this->Batch_model->get_where('am_institute_master', array('parent_institute'=>$branch,'status'=>1)); 
        $center      = $result->institute_master_id; 
        $courselist  = $this->Batch_model->get_courseby_center($center); 
        $course      = $result->institute_course_mapping_id;  
        $class_timing=array();
        $class_sessions=$this->common->get_alldata('am_batch_class_details',array("batch_id"=>$id));
        //print_r($class_sessions);
         
         $html['monday']='';
         $html['tuesday']='';
         $html['wednesday']='';
         $html['thursday']='';
         $html['friday']='';
         $html['saturday']='';
         $html['sunday']='';
       if(!empty($class_sessions)){           
 //echo "<pre>"; print_r($class_sessions);
         $days=array();
         $m=0;$tu=0;$w=0;$th=0;$f=0;$sa=0;$su=0;
         foreach($class_sessions as $row)
         {
             $counter=0;
            
             if($row['week_day'] == "Mon"){$day="monday";$m++;$counter=$m;}
             if($row['week_day'] == "Tue"){$day="tuesday";$tu++;$counter=$tu;}
             if($row['week_day'] == "Wed"){$day="wednesday";$w++;$counter=$w;}
             if($row['week_day'] == "Thu"){$day="thursday";$th++;$counter=$th;}
             if($row['week_day'] == "Fri"){$day="friday";$f++;$counter=$f;}
             if($row['week_day'] == "Sat"){$day="saturday";$sa++;$counter=$sa;}
             if($row['week_day'] == "Sun"){$day="sunday";$su++;$counter=$su;}
             if(!isset($html[$day])){$html[$day]='';}
             
              $start_time =date('h:i A',strtotime($row['start_time'])); 
              $end_time=date('h:i A',strtotime($row['end_time']));
             
             $counter_input='<input type="hidden" id="counter_'.$day.'" value="'.$counter.'"/>';
             if(in_array($row['week_day'],$days))
             {
               $button='<button type="button" class="btn btn-round btn-danger btn-block option_btn"  onclick=remove("'.$counter.'","'.$day.'") title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button>';  
             }
             else
             {
                 array_push($days,$row['week_day']);
                 $button='<button type="button" class="btn-round btn btn-block btn-info btn-sm mt-2" onclick=addNew_batch_sessiontime("'.$day.'")><i class="fa fa-plus"></i></button>';  
             }
             
             $html[$day].='<tr id="'.$day.'_row_'.$counter.'"><td><div class="batchlist-form" style="width:80px; margin:auto;">'.$counter_input.'<div class="form-group" style="margin-bottom:0"><label>Start time<span class="req redbold">*</span></label><input class="form-control itime start_time" type="text" name="'.$day.'_start_time[]" id="'.$day.'_start_time_'.$counter.'" placeholder="Start time" value="'.$start_time.'"></div><div class="form-group" style="margin-bottom:0"><label>End time<span class="req redbold">*</span></label><input class="form-control itime end_time" type="text" name="'.$day.'_end_time[]"  placeholder="End time" value="'.$end_time.'" id="'.$day.'_end_time_'.$counter.'"></div></div>'.$button.'</div></td></tr><script>$(".itime").datetimepicker({format : "hh:mm a"});$("#'.$day.'_start_time_'.$counter.'").on("dp.change", function (e) {$("#'.$day.'_end_time_'.$counter.'").data("DateTimePicker").minDate(e.date); });$("#'.$day.'_end_time_'.$counter.'").on("dp.change", function (e) {  $("#'.$day.'_start_time_'.$counter.'").data("DateTimePicker").maxDate(e.date);});</script>';
         }
         
          $html[$day].='<script>$(".itime").datetimepicker({format : "hh:mm a"});
          </script>';
       }
         
         
        // print_r($class_timing); die();
          $res['class_timing']=$html;
         $branch_option = '<option value="">Select</option>';
         if(!empty($branchlist)) {
             foreach($branchlist as $brnh) {
                 if($branch==$brnh->institute_master_id) {
                     $bselted = 'selected="selected"'; } else { $bselted = '';}
             $branch_option .= '<option value="'.$brnh->institute_master_id.'" '.$bselted.'>'.$brnh->institute_name.'</option>';
             }
         $result->batch_creationdate = $branch_option;
         }
         $center_option = '<option value="">Select</option>';
         if(!empty($centerlist)) {
             foreach($centerlist as $cntr) {
                 if($center==$cntr->institute_master_id) { $cselted = 'selected="selected"'; } else { $cselted = '';}
             $center_option .= '<option value="'.$cntr->institute_master_id.'" '.$cselted.'>'.$cntr->institute_name.'</option>';
             }
            $result->created_time = $center_option;
         }
         $course_option = '<option value="">Select</option>';
         if(!empty($courselist)) {
             foreach($courselist as $crse) {
                 if($course==$crse->institute_course_mapping_id) { $crselted = 'selected="selected"'; } else { $crselted = '';}
             $course_option .= '<option value="'.$crse->institute_course_mapping_id.'" '.$crselted.'>'.$crse->class_name.'</option>';
             }
            $result->modified_date = $course_option;
         }
         $result->batch_datefrom = date('d-m-Y',strtotime($result->batch_datefrom));
         $result->batch_dateto = date('d-m-Y',strtotime($result->batch_dateto));
         $result->last_date = date('d-m-Y',strtotime($result->last_date));
         $result->due_dates="";
         $date="";
         if($result->course_paymentmethod == "installment")
         {
            $result->number_of_installements=$this->common->check_if_dataExist('am_batch_fee_installment',array("institute_course_mapping_id"=>$result->institute_course_mapping_id));
             $duedate_Arr=$this->common->get_alldata('am_batch_instalment_duedate',array("batch_id"=>$id));
             for($i=0;$i<$result->number_of_installements;$i++)
             {
                 $num=$i+1;
                // print_r($duedate_Arr[$i]['due_date']);$date="";
                 if(!empty($duedate_Arr)) {
                    $date= date('d-m-Y',strtotime($duedate_Arr[$i]['due_date']));
                     //echo $date;
                 }
             $result->due_dates.='<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group"><label>Due Date of Installment '.   $num.'<span class="req redbold">*</span></label><input class="form-control calendarclass" type="text" name="duedate[]"  placeholder="" value="'.$date.'"></div></div>';
             }
             $result->due_dates.='<script>$(".calendarclass").datetimepicker({
                                            format:"DD-MM-YYYY",useCurrent:false});</script>';
         }
        if($result) {
            $res['status']   = true; 
            $res['message']  = 'Batch details updated successfully'; 
            $res['data']     = $result; 
        } else {
            $res['status']   = false; 
            $res['message']  = 'Error while selecting batch!'; 
            $res['data']     = '';
        }
         print_r(json_encode($res));
    }
    
    
        public function get_batchdetail_view()
        {
        $id          = $this->input->post('batch_id');
        $result      = $this->Batch_model->get_batchby_id($id); 
        $group       = $result->group_master_id;
        $groupdetgails  = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$group)); 
        $branch      = $result->branch_master_id; 
        $centerdetgails  = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$branch)); 
        $center      = $result->institute_master_id; 
        $centerdetails  = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$center));  
        $course      = $result->course_master_id;  
        $coursedetails  = $this->common->get_from_tablerow('am_classes', array('class_id'=>$course));  
             
         $result->group_master_id = $groupdetgails['institute_name'];
         $result->branch_master_id = $centerdetgails['institute_name'];
         $result->institute_master_id = $centerdetails['institute_name'];
         $result->course_master_id = $coursedetails['class_name'].', '.$groupdetgails['institute_name'].', '.$centerdetgails['institute_name'].', '.$centerdetails['institute_name'];
         $branch_option = '';
         if(!empty($branchlist)) {
             foreach($branchlist as $brnh) {
                 if($branch==$brnh->institute_master_id) { $bselted = 'selected="selected"'; } else { $bselted = '';}
             $branch_option .= '<option value="'.$brnh->institute_master_id.'" '.$bselted.'>'.$brnh->institute_name.'</option>';
             }
        
         }
         $center_option = '';
         if(!empty($centerlist)) {
             foreach($centerlist as $cntr) {
                 if($center==$cntr->institute_master_id) { $cselted = 'selected="selected"'; } else { $cselted = '';}
             $center_option .= '<option value="'.$cntr->institute_master_id.'" '.$cselted.'>'.$cntr->institute_name.'</option>';
             }
            $result->created_time = $center_option;
         }
         $course_option = '';
         if(!empty($courselist)) {
             foreach($courselist as $crse) {
                 if($course==$crse->institute_course_mapping_id) { $crselted = 'selected="selected"'; } else { $crselted = '';}
             $course_option .= '<option value="'.$crse->institute_course_mapping_id.'" '.$crselted.'>'.$crse->class_name.'</option>';
             }
            $result->modified_date = $course_option;
         }
         $result->course_tuitionfee = numberformat($result->course_tuitionfee);   
         $result->course_cgst = numberformat($result->course_cgst);     
         $result->course_sgst = numberformat($result->course_sgst); 
         $result->course_cess = numberformat($result->course_cess);     
         $result->course_totalfee = numberformat($result->course_totalfee);          
         /*$result->batch_start_time = date('g:i a',strtotime($result->batch_start_time));
         $result->batch_end_time = date('g:i a',strtotime($result->batch_end_time));*/
         $result->batch_datefrom = date('d-m-Y',strtotime($result->batch_datefrom));
         $result->batch_dateto = date('d-m-Y',strtotime($result->batch_dateto));
         $result->last_date = date('d-m-Y',strtotime($result->last_date));
            
        $res['sunday']=$this->get_class_session_byday($result->batch_id,'Sun');
        $res['monday']=$this->get_class_session_byday($result->batch_id,'Mon');
        $res['tuesday']=$this->get_class_session_byday($result->batch_id,'Tue');
        $res['wednesday']=$this->get_class_session_byday($result->batch_id,'Wed');
        $res['thursday']=$this->get_class_session_byday($result->batch_id,'Thu');
        $res['friday']=$this->get_class_session_byday($result->batch_id,'Fri');
        $res['saturday']=$this->get_class_session_byday($result->batch_id,'Sat');
        $instalmentDudate = $this->Batch_model->get_instalment_dudate($id);
        if(!empty($instalmentDudate)) {   
            $install = '<table class="table table_register table-bordered table-striped text-center"><h6>Installment details</h6>
                                <tbody><tr>
                                    <th class="text-center">Installment</th>
                                    <th class="text-center">Due date</th>
                                </tr>
                </tbody>';
            $sl = 1;
            foreach($instalmentDudate as $key=>$val) {
                $install .= '<tr>
                                <td class="text-center">'.$val['installment'].'</td>
                                <td class="text-center">'.date('d-m-Y',strtotime($val['due_date'])).'</td>
                            </tr>';
                $sl++;
            }
            $install .= '</table>';  
        }else{
            $install = '';
        } 
        $result->instalment_details = $install;
        if($result) {
            $res['status']   = true; 
            $res['message']  = 'Batch details updated successfully'; 
            $res['data']     = $result; 
        } else {
            $res['status']   = false; 
            $res['message']  = 'Error while selecting batch!'; 
            $res['data']     = '';
        }
        print_r(json_encode($res));
    }
    
    // Batch creation
    // @Params  post array
    // @Author GBS-R
    
     public function batch_actions(){
        // print_r($_POST); die();
        
        if($_POST){
          
            $this->form_validation->set_rules('group_name', 'Group', 'required');
            $this->form_validation->set_rules('branch_name', 'Branch', 'required');
            $this->form_validation->set_rules('center_name', 'Centre', 'required');
            $this->form_validation->set_rules('course_name', 'Course', 'required');
            $this->form_validation->set_rules('batch_name', 'Batch', 'required');
            $this->form_validation->set_rules('no_student', 'Number of students', 'required');
            $this->form_validation->set_rules('start_date', 'Start date', 'required');
            $this->form_validation->set_rules('end_date', 'End date', 'required');
            //$this->form_validation->set_rules('start_time', 'Session start time', 'required');
            //$this->form_validation->set_rules('end_time', 'Session end time', 'required');
            $this->form_validation->set_rules('last_date', 'Last Date of Admission', 'required');
            $weekdays=$this->input->post('weekday');
//            echo '<pre>';print_r($_POST);exit;
            foreach($weekdays as $days)
            {
                $start=$this->input->post($days.'_start_time');
                $end=$this->input->post($days.'_end_time');      
                 foreach($start as $key=>$val){
                     if(!empty($start[$key]) && !empty($end[$key])){
                         if(isset($start[$key+1]) && isset($end[$key+1])){
                             if((strtotime($start[$key]) < strtotime($start[$key+1]) && 
                                 (strtotime($start[$key+1]) < strtotime($end[$key]))
                                ) || (
                                 (strtotime($start[$key]) < strtotime($end[$key+1])) && 
                                 strtotime($end[$key+1]) < strtotime($end[$key]))){
                                    $res['status']   = false; 
                                    $res['message']  = "Some class schedules have invalid start time end time";
                                    $res['data']     = array(); 
                                    print_r(json_encode($res));
                                    exit;
                             }
                         }
                     }else{
                        $res['status']   = false; 
                        $res['message']  = "Some class timings are empty";
                        $res['data']     = array(); 
                        print_r(json_encode($res));
                        exit;
                     }
                }
            }
            
            if($this->form_validation->run()){
                $batch_id = $this->input->post('batch_id');
                $institute_course_mapping_id = $this->input->post('course_name');
                $duedate = $this->input->post('duedate');
                $num_of_installements=$this->common->check_if_dataExist("am_batch_fee_installment",array("institute_course_mapping_id"=>$institute_course_mapping_id));
                for($j=0;$j<$num_of_installements;$j++)
                {
                   if($duedate[$j] == "")
                   {
                        $res['status']   = false; 
                        $res['message']  = 'Some due date fields are empty'; 
                        $res['data']     = '';   
                         print_r(json_encode($res));
                         exit();
                   }
                }
                $mode  = $this->Batch_model->get_batch_mode($institute_course_mapping_id);

                $data     = array('institute_course_mapping_id'=>$institute_course_mapping_id,
                                  'batch_datefrom'=>date('Y-m-d',strtotime($this->input->post('start_date'))),
                                  'batch_dateto'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
                                 // 'batch_start_time'=>date('H:i:s',strtotime($this->input->post('start_time'))),
                                 // 'batch_end_time'=>date('H:i:s',strtotime($this->input->post('end_time'))),
                                  'batch_name'=>$this->input->post('batch_name'),
                                  'batch_mode'=>$mode,
                                  'batch_capacity'=>$this->input->post('no_student'),
                                  'last_date'=>date('Y-m-d',strtotime($this->input->post('last_date')))
                                 ); 
                $data['monday'] = in_array('monday',$this->input->post('weekday'));
                $data['tuesday'] = in_array('tuesday',$this->input->post('weekday'));
                $data['wednesday'] = in_array('wednesday',$this->input->post('weekday'));
                $data['thursday'] = in_array('thursday',$this->input->post('weekday'));
                $data['friday'] = in_array('friday',$this->input->post('weekday'));
                $data['saturday'] = in_array('saturday',$this->input->post('weekday'));
                $data['sunday'] = in_array('sunday',$this->input->post('weekday'));
                $weekdays=$this->input->post('weekday');
                
                if($batch_id!='') {
                        $this->scheduler_model->deactivate_future_batch_schedules($batch_id);
                        $query = $this->Batch_model->update_batchdetails($data,$batch_id,$_POST);
                        $what = $this->db->last_query();
                        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    if($query = 1)
                    {

                        $exist=$this->common->check_if_dataExist('am_batch_instalment_duedate',array("batch_id"=>$batch_id));
                        $edit_due_date = $this->input->post('duedate');
                        //print_r($edit_due_date);
                        if($exist !=0)
                        {

                           $delete=$this->Common_model->delete('am_batch_instalment_duedate',array("batch_id"=>$batch_id));
                            //echo $this->db->last_query();
                            if($delete)
                            {
                                $i=1;
							if(!empty($edit_due_date)) {	
                            foreach($edit_due_date as $date)
                            {
                                $due_detail['due_date']=date('Y-m-d',strtotime($date));
                                $due_detail['batch_id']=$batch_id;
                                $due_detail['installment']=$i;
                                $this->Common_model->insert('am_batch_instalment_duedate', $due_detail);
                             $i++;
                            }
							}
                            }
                        }
                        else
                        {
                           $i=1;
							if(!empty($edit_due_date)) {	
                            foreach($edit_due_date as $date)
                            {
                                $due_detail['due_date']=date('Y-m-d',strtotime($date));
                                $due_detail['batch_id']=$batch_id;
                                $due_detail['installment']=$i;
                                $this->Common_model->insert('am_batch_instalment_duedate', $due_detail);
                                $i++;
                            }
							}
                        }
                        $res['status']   = true; 
                        $res['message']  = 'Batch details updated successfully'; 
                        $res['data']     = '';   
                        logcreator('update', 'Batch detail edited', $who, $what, $batch_id, 'am_batch_center_mapping','batch updated');
                    } else {
                        $res['status']   = false; 
                        $res['message']  = 'Error while updating batch'; 
                        $res['data']     = ''; 
                        logcreator('update', 'Batch detail edit failed', $who, $what, '', 'am_batch_center_mapping','Error while updating batch');
                    }
                } else {
                        $code['batch_code'] = batchcodegeneration($this->input->post('course_name'),$mode);
                        $query = $this->Batch_model->insert_batchdetails($data,$_POST);

                        $what = $this->db->last_query();
                        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                      if($query != 0){

                            $table_row_id = $query;
                            $due_date = $this->input->post('duedate');
                          $i=1;
                          if(!empty($due_date)) {
                            foreach($due_date as $date)
                            {
                                $due_detail['due_date']=date('Y-m-d',strtotime($date));
                                $due_detail['batch_id']=$table_row_id;
                                $due_detail['installment']=$i;
                                $this->Common_model->insert('am_batch_instalment_duedate', $due_detail);
                                $i++;
                            }
                        }
                        //insert the unique batchcode
                        $code['batch_code']= $code['batch_code'].'-'.$table_row_id;
                        $sql = $this->Batch_model->update_batchdetails($code, $table_row_id,$_POST);
                        $what_code=$this->db->last_query();
                        if($sql == 1)
                        {
                          //logcreator('update', 'database', $who, $what_code, $table_row_id, 'am_batch_center_mapping','batchcode added');  
                        }
                        $res['status']   = true; 
                        $res['message']  = 'Batch details added successfully'; 
                        $res['data']     = $table_row_id; 
                        logcreator('insert', 'New batch created', $who, $what, $table_row_id, 'am_batch_center_mapping','batch added');
                    } else {
                        $res['status']   = false; 
                        $res['message']  = 'Error while adding batch'; 
                        $res['data']     = $query; 
                        logcreator('insert', 'Batch creation failed', $who, $what, '', 'am_batch_center_mapping','Error while adding batch');
                    }
                }

            }else{
                $res['status']   = false; 
                $res['message']  = validation_errors();
                $res['data']     = array(); 
            }
        } else {
           $res['status']   = false; 
           $res['message']  = 'Invalid data'; 
           $res['data']     = array();     
        }
        print_r(json_encode($res));
    }

    public function check_batch_schedule_exists(){
        if($_POST){
            $batch_id = $this->input->post('batch_id');
            if($this->scheduler_model->check_batch_schedule_exists($batch_id)){
                $res['status']   = true;
            }else{
                $res['status']   = false;
            }
            print_r(json_encode($res));
        }
    }

    public function batch_save1(){
        if($_POST){
            // echo '<pre>';print_r($_POST);exit;
            $data = array('institute_course_mapping_id'=>$this->input->post('course_name'),
                            'batch_name'=>$this->input->post('batch_name'),
                            'batch_datefrom'=>date('Y-m-d',strtotime($this->input->post('start_date'))),
                            'batch_dateto'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
                            'batch_capacity'=>$this->input->post('no_student'),
                            'batch_mode'=>$this->input->post('mode'),
                            'batch_tuitionfee'=>$this->input->post('tuition_fee'),
                            'batch_cgst'=>$this->input->post('cgst'),
                            'batch_sgst'=>$this->input->post('sgst'),
                            'batch_totalfee'=>$this->input->post('totalfee'),
                            'batch_paymentmethod'=>$this->input->post('paymentmethod')
                            );
            $installmentnos = $this->input->post('installmentnos');
            if($this->input->post('paymentmethod') == 'installment'){
                $installment = $this->input->post('installment');
                if($installmentnos){
                    if(!empty($installment)){
                        $sum = 0;
                        foreach($installment as $key=>$val){
                            $instData[$key]['installment_amount'] = $val;
                            $sum = $sum + $val;
                        }
                        if($sum != $data['batch_totalfee']){
                            $res['status']   = false; 
                            $res['message']  = 'Instalments doesnt add up to total fee'; 
                            $res['data']     = array();
                            print_r(json_encode($res));exit;
                        }
                    }else{
                        $res['status']   = false; 
                        $res['message']  = 'Please define installments'; 
                        $res['data']     = array();
                        print_r(json_encode($res));exit;
                    }
                }
            }
            $data['batch_code'] = batchcodegeneration($this->input->post('course_name'),$this->input->post('mode'));
            $query = $this->Batch_model->insert_batchdetails($data);
            $table_row_id = $this->db->insert_id();
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            if($installmentnos && $query){
                foreach($instData as $key=>$val){
                    $instData[$key]['batch_center_mapping_id'] = $table_row_id;
                }
                $this->Batch_model->insert_batchFeedetails($instData);
            }
            if($query == 1){
                $res['status']   = true; 
                $res['message']  = 'Batch details added successfully'; 
                $res['data']     = $table_row_id; 
                logcreator('insert', 'New batch created', $who, $what, $table_row_id, 'am_batch_center_mapping','batch added');
            } else {
                $res['status']   = false; 
                $res['message']  = 'Error while adding batch'; 
                $res['data']     = $query; 
                logcreator('insert', 'New batch creation failed', $who, $what, '', 'am_batch_center_mapping','Error while adding batch');
            }
        } else {
           $res['status']   = false; 
           $res['message']  = 'Invalid data'; 
           $res['data']     = array();     
        }
        print_r(json_encode($res));
    }
    
    /*
    *   Delete from table
    *   @params table, primary key
    *   @author GBS-R
    */
    
    function delete_fromwhere(){
        $id      = $this->input->post('id');
        $where = array('batch_id'=>$id);
        $data  = array('batch_status'=>2); 
        $what = '';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($id!= '') {
            $check      = $this->common->check_for_delete('am_student_course_mapping','batch_id',$id);
            if($check==0) {
            $query = $this->common->delete_fromwhere('am_batch_center_mapping', $where, $data);
            $table_row_id    = $this->db->insert_id();
            logcreator('delete', 'Batch detailed deleted', $who, $what, $id, 'am_batch_center_mapping','batch deleted');
                $result['status'] = true;
               $result['message'] = 'Action completed successfully';
               $result['data'] =  '';
            } else {
                $result['status'] = false;
               $result['message'] = "Batch can't remove, Student already enrolled in this batch.";
               $result['data'] = null; 
            }
        } else {
            
               $result['status'] = false;
               $result['message'] = "Invalid data.";
               $result['data'] = null; 
           logcreator('insert', 'Batch detail deletion failed', $who, $what, $id, 'am_batch_center_mapping','Error while deleting batch');    
        }
        print_r(json_encode($result));
    }
    
    public function log() {
        logcreator($action = '', $objecttype = '', $who = '', $what = '', $table_row_id = '', $tablename='');
    }




    //----------------------------------Manage Classrooms-------------------------------------------//

    public function manage_classrooms(){
        check_backoffice_permission('manage_classrooms');
        $this->data['page'] = "admin/classrooms";
        $this->data['menu'] = "basic_configuration.php";
        $this->data['breadcrumb'] = "Manage Class Rooms";
        $this->data['menu_item']="backoffice/manage-classrooms";
        $this->data['classroomsArr']      = $this->Batch_model->get_classrooms_list();
        $this->data['batchArr']      = $this->Batch_model->get_batch();
        $this->data['groupArr']      = $this->institute_model->get_allgroups();
        $this->load->view('admin/layouts/_master.php',$this->data);
    }
    
    
    public function load_classromm_ajax(){
        $html = '<thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Centre</th>
                            <th>Class Name</th>
                            <th>Total Occupancy</th>
                            <th>Class room Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>';
        $classroomsArr      = $this->Batch_model->get_classrooms_list();
        if(!empty($classroomsArr)) {
            $i=1;
                    foreach($classroomsArr as $rooms){
                        if($rooms['total_occupancy'] == "0")
                        {
                            $total_occupancy ="";
                         }
                        else
                        {
                           $total_occupancy = $rooms['total_occupancy'];  
                        }

                        if($rooms['type'] == "1")
                        {
                            $type_name="Class Room";
                        }
                        elseif($rooms['type'] == "2")
                        {
                            $type_name="Lab";
                         }
                        else
                        {
                           $type_name="Virtual Classroom";  
                        }
                    $html .= '<tr id="row_'.$rooms['room_id'].'">
                        <td>'.$i.'</td>
                        <td id="institute_name_'.$rooms['room_id'].'">
                            '.$rooms['institute_name'].'</td>
                        <td id="classroom_name_'.$rooms['room_id'].'">
                            '.$rooms['classroom_name'].'</td>
                        <td id="total_occupancy_'.$rooms['room_id'].'">
                            '.$total_occupancy.'</td>
                            <td>'.$type_name.'</td>
                        <td>
                        <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$rooms['room_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#view_classrooms" style="color:blue;cursor:pointer;">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_classroomsdata('.$rooms['room_id'].'); edit_types('.$rooms['room_id'].');">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_fromtable('.$rooms['room_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a></td>
                    </tr>';
                    $i++;
                    } 
        }
        echo $html;
    }
    
    
    public function get_centercoursemapping()
    {
            $center_id = $this->input->post('center_id');
            $subArr=$this->institute_model->get_allcoursebycenter($center_id);
      //  print_r($subArr);
            echo '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                echo '<option value="' . $row->institute_course_mapping_id . '" >' . $row->class_name . '</option>';
            }
        }
    }
    public function get_allsub_byparent()
    {
            $subArr=$this->institute_model->get_allsub_byparent($_POST);
            echo '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                echo '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
        }
    }

    public function classrooms_add()
    {
        if($_POST){
            $data = $_POST;
            if($data['total_occupancy']=='') {
                $data['total_occupancy'] = 0;
            }
            $classrooms_exist = $this->Batch_model->is_classrooms_exist($data);
            if($classrooms_exist == 0){
                $res = $this->Batch_model->institute_course_add_mapping($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New class room created', $who, $what, $table_row_id, 'am_classrooms');
                    $classrooms_array=$this->Batch_model->get_classroomsdetails_by_id($table_row_id);
                    $html='<li id="row_'.$table_row_id.'">
                            <div class="col sl_no "> '.$table_row_id.' </div>
                                <div class="col " >'.$classrooms_array['group_id'] .' </div>
                                <div class="col " >'.$classrooms_array['classroom_name'] .' </div>
                                <div class="col actions ">
                                    <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$classrooms_array['table_row_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#view_classrooms" style="color:blue;cursor:pointer;">
                                        <i class="fa fa-eye "></i>
                                    </button>
                                    <button class="btn btn-default option_btn " title="Edit" onclick="get_classroomsdata('.$table_row_id.'); edit_types('.$table_row_id.');">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_classrooms('.$table_row_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            <li>';
                }
            }else{
                $html=2;//already exist
            }
            print_r($html);
        }
    }
    public function classrooms_edit()
    {
        if($_POST){
            $id = $this->input->post('room_id');
            unset($_POST['room_id']);
            $data = $_POST;
            if($data['total_occupancy']=='') {
                $data['total_occupancy'] = 0;
            }
            $res = $this->Batch_model->edit_classrooms($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Class room edited', $who, $what, $id, 'am_classrooms');
            }
            print_r($res);
        }
    }

    public function delete_classrooms()
    {
        $id  = $_POST['id'];
        $res = $this->Batch_model->delete_classrooms($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Class room deleted', $who, $what, $id, 'am_classrooms');
        }
        print_r($res);
    }

    public function get_classrooms_by_id($room_id){
        $classrooms_array= $this->Batch_model->get_classrooms_by_id($room_id);
        print_r(json_encode($classrooms_array));
    }
    
    public function get_class_rooms_by_id($room_id){
        $classrooms_array= $this->Batch_model->get_class_rooms_by_id($room_id);
        $classrooms_array['group_master_id']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$classrooms_array['group_master_id']));
        $classrooms_array['branch_master_id']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$classrooms_array['branch_master_id']));
        print_r(json_encode($classrooms_array));
    }
    public function get_classrooms()
    {
        $details = $this->Batch_model->get_institutecourse_mapping_byid($_POST);
        //$group_master_id=$details['group_master_id'];
        $data['parent_institute']=$details['group_master_id'];
            $branchArr=$this->institute_model->get_allsub_byparent($data);
             $html= '<option value="">Select</option>';
            if(!empty($branchArr)){
                    foreach ($branchArr as $row)
                    {
                        $html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                    }
           }
          unset($data['parent_institute']);
          $data['parent_institute']=$details['branch_master_id'];
          $centerArr=$this->institute_model->get_allsub_byparent($data);
            $html1= '<option value="">Select</option>';
           if(!empty($centerArr)){
            foreach ($centerArr as $row)
            {
                $html1.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
           }
       $details['branch']=$html;
       $details['center']=$html1;
        print_r(json_encode($details));
    }
    public function add_classrooms()
    {  
        if($_POST){
            $data = $_POST;
            $check_data = $_POST;
            if($data['total_occupancy']=='') {
                $data['total_occupancy'] = 0;
            }
            unset($check_data['total_occupancy']);
            $course_exist = $this->Batch_model->is_course_exist($check_data);
            if($course_exist==0){
                $res = $this->Batch_model->institute_course_add_mapping($data);
            }
            else{
                $res=2; //already exist
            }
            print_r($res);
        }
    }
//-----------------------------------View Hierarchy------------------------------------------------//



    public function view_hierarchy($id=NULL){
        if($id!=NULL){
            $this->data['hierarchyView'] = $this->institute_model->get_institutedetails_by_id($id);
        }
        $this->data['page']="admin/hierarchy_view";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Manage Institute";
        $this->data['menu_item']="backoffice/view-hierarchy";
        $this->data['instituteArr']=$this->institute_model->get_all_institutes();
        $this->data['groupArr']=$this->institute_model->get_instituteby_id($id);
        $details = $this->Batch_model->get_institutecourse_mapping_byid($_POST);
        $data['parent_institute']=$details['group_master_id'];
        $this->data['branchArr']=$this->institute_model->get_allsub_byparent($data); 
        $data['parent_institute']=$details['branch_master_id'];
        $this->data['centerArr']=$this->institute_model->get_allsub_byparent($data); 
        $center_id = $this->input->post('center_id');
        $this->data['courseArr']= $this->institute_model->getall_institute_course_mapping_list();
        // echo '<pre>';
        // print_r($this->data);
        // die(); 
		$this->load->view('admin/layouts/_master',$this->data);
    }
    

    public function fetch()
    {

        $output = '';
        $batch_id = '';
        $batch_id = $this->input->post('batch_id');
        $data = $this->institute_model->get_student_inbatch($batch_id);
        $output .= '<thead>
                        <tr>
                            <th width="50">Sl no.</th>
                            <th>Name</th>
                            <th>Registration No</th>
                            
                        </tr>
                        </thead><tbody><tr>';
//        <th>Action</th>
                        $i=1;  if(!empty($data)){
                        foreach($data as $student){
                        $output .= '
                                <td>'.$i.'</td>
                                <td> '.$student->student_name.'</td>
                                <td>'.$student->registration_number.'</td>
                        
                        </tr>';
//                            <td><a href ="'.base_url('backoffice/view-student/'.$student->student_id).'" id="#view_student" ><button class="btn btn-default option_btn " onclick="view_studentdata('.$student->student_id.')">
//                            <i class="fa fa-eye "></i>
//                        </button></a></td>
                        $i++;
                        } 
                         } else {
                        $output .= ' <tr>
                                    <td colspan="4">No data available</td>
                                    </tr><tbody>';
                        }
                        $output .= '';
            echo $output;
    }
    
    //check batch name duplication
    public function check_batchName()
    {
       if($_POST)
       {
            $batch_name=$this->input->post('batch_name');
            $batch_id=$this->input->post('batch_id');
           if($batch_id != "")
           {
              $query= $this->db->get_where('am_batch_center_mapping',array("batch_name"=>$batch_name,"batch_id!="=>$batch_id,"batch_status"=>'1')); 
           }
           else
           {
             $query= $this->db->get_where('am_batch_center_mapping',array("batch_name"=>$batch_name,"batch_status"=>'1'));  
           }
            echo $query->num_rows;
        
            if($query->num_rows()>0)
            {
               echo 'false';
            }
            else
            {
                echo 'true';
            } 
       }
        
    }

    public function get_type(){
        if($_POST){
            $html ='';
            $type = $this->input->post('type');
            if($type == "3"){
                $html = '<div class="form-group"><label>Total Occupancy  <span class="req redbold">*</span></label>
                                <input type="text" name="total_occupancy" id="total_occupancy" class="form-control numbersOnly" maxlength="3" placeholder="Total Occupancy" data-validate="required"/>
                            </div>';       
            }
        echo $html;
        }
    }
    public function get_edit_type(){
        if($_POST){
            // $html ='';
            $type = $this->input->post('type');
            //   echo $enquiry_type;
            // if($enquiry_type == "Others"){
                $html= ' <div class="form-group"><label>Total Occupancy  <span class="req redbold">*</span></label>
                <input type="text" name="total_occupancy" id="edit_total_occupancy" class="form-control" placeholder="Total Occupancy" data-validate="required"/>
            </div> ';       
        // }
        echo $html;
        }
    }
public function get_count_duedate()
{
    if($_POST)
    {
      //  print_r($_POST);
        $course_id=$this->input->post('course_id');

        if($course_id != "")
        {
            $number_of_installment=$this->common->check_if_dataExist('am_batch_fee_installment',array("institute_course_mapping_id"=>$course_id));
           // echo $this->db->last_query();
           //echo $number_of_installment;
            $ajax_response['due_dates']="";
            if($number_of_installment > 0){
                $ajax_response['st']=1;
            for($i=1;$i<=$number_of_installment;$i++)
             {

                $ajax_response['due_dates'].='<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-      12"><div class="form-group"><label>Due Date of Installment '. $i .'<span class="req redbold">*</span></label><input class="form-control calendarclass" type="text" name="duedate[]"  placeholder=""></div></div>';
             }
             $ajax_response['due_dates'].='<script>$(".calendarclass").datetimepicker({
                                            format:"DD-MM-YYYY",useCurrent:false});</script>';
            }
            else
            {
            $ajax_response['st']=0;
            }
        }
        else
        {
         $ajax_response['st']=0;
        }

    }
    else
    {
         $ajax_response['st']=0;
    }

    print_r(json_encode($ajax_response));
}

public function get_class_session_byday($batch_id,$day) {
    $class_array=$this->common->get_alldata_orderby('am_batch_class_details',array("batch_id"=>$batch_id,"week_day"=>$day),'class_sequence_number','ASC');
    if(!empty($class_array))
    {
        $html='<table cellpadding="0" cellspacing="0">';
      foreach($class_array as $row)
      {
           $start_time =date('h:i A',strtotime($row['start_time'])); 
           $end_time=date('h:i A',strtotime($row['end_time']));
           $html.='<tr><td style="font-size:11px"> '.$start_time.'<br> to <br>'.$end_time.'</td></tr>'; 
      } 
         $html.='</table>';
    }
    else
    {
        $html='';
    }
    return $html;
    
}
    

}
?>
