<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Direction_Controller {

   public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="notification";
        check_backoffice_permission();
    }

     public function index(){
     check_backoffice_permission('student_notification');
        $this->data['page']           ="admin/student_notification";
		$this->data['menu']           ="notification";
        $this->data['breadcrumb']     ="Student Notification";
        $this->data['menu_item']      ="student-notification";
        $this->data['centreArr']      = $this->common->get_from_tableresult('am_institute_master',array('institute_type_id'=>3,'status'=>1));
		$this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_centercoursemapping()
    {
            $center_id = $this->input->post('center_id');
            $subArr=$this->institute_model->get_allcoursebycenter($center_id);
       // print_r($subArr);
            echo '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                echo '<option value="' . $row->class_id . '" >' . $row->class_name . '</option>';
            }
        }
    }
    
     public function get_batch_byCourse()
    {
        $select= '';
      if($_POST)
      {   
         
           $course_id=$this->input->post('course_id');
           $center=$this->input->post('center');
          
          $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
         
           $batches=$this->common->get_alldata('am_batch_center_mapping',array("institute_course_mapping_id"=>$institute_course_mapping_id,"batch_status"=>1));
         
          if(!empty($batches))
          {
             
           foreach($batches as $val) 
           {
             $select.='<option value="'.$val["batch_id"].'">'.$val["batch_name"].'</option>';  
           }
          }
          else
          {
              $select.= '<option value="">Select</option>'; 
          }
      }
        print_r($select);
    }
    
    public function get_student_list()
    {
       $html='<thead><tr>
                <th>'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('student_reg.no').'</th>
                <th>'.$this->lang->line('student_name').'</th>
                <th>
                    <label class="custom_checkbox">'.$this->lang->line('action').'
                    <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                    <span class="checkmark"></span>
                    </label>
               </th>
             </tr></thead>';
        if($_POST)
        { $where=array();
            $centre_id=$this->input->post('centre_id');
            if($centre_id !="")
            {
                /*$institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("institute_master_id"=>$centre_id));
             $where['am_student_course_mapping.institute_course_mapping_id']=$institute_course_mapping_id; */  
             $where['am_student_course_mapping.center_id']=$centre_id;   
            }
            
            $course_id=$this->input->post('course_id');
            if($course_id!="")
            {
             $where['am_student_course_mapping.course_id']=$course_id;   
            }
            $batch_id=$this->input->post('batch_id');
            if($batch_id!="")
            {
             $where['am_student_course_mapping.batch_id']=$batch_id;   
            }
             $where['am_students.status']=1;
       
             $student_details=$this->student_model->get_student_list_msg($where);
        
             if(!empty($student_details))
             { $i=1;
               foreach($student_details as $row)
               {
                 $html.='<tr>
                        <td style="padding: .75rem!important;">'.$i.'</td>
                        <td style="padding: .75rem!important;">'.$row['registration_number'].'</td>
                        <td style="padding: .75rem!important;">'.$row['name'].'</td>
                        <td style="padding: .75rem!important;"><label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                            <input type="checkbox" checked="checked" class="all_student" name="student_id[]" value="'.$row['student_id'].'" />
                            <span class="checkmark"></span>
                            </label>
                        </td>
                       </tr>';
                   $i++;
               }
            }
        
        }
        //$html.='</table></div>';
         echo $html;
    }
    
    public function send_message_student()
    {
        if($_POST)
        {
            $student_ids=$this->input->post('student_id');
            $message=$this->input->post('message');
            if($message != "" && !empty($student_ids))
            {
                foreach($student_ids as $row)
                {
                   
                    $mobile=$this->common->get_name_by_id('am_students','contact_number',array('student_id'=>$row));
                    $response=$this->Sms_model->send_sms($mobile,$message);
                   
                      $ajax_response['st']=1;
                      $ajax_response['msg']="Successfully sent notification";  
                   
                    
                }
            }
            else
            {
               $ajax_response['st']=2;
               $ajax_response['msg']="Please choose atleast one student"; 
            }
            print_r(json_encode($ajax_response));
        }
    }
    
    public function staff_notification(){
     check_backoffice_permission('staff_notification');
        $this->data['page']           ="admin/staff_notification";
		$this->data['menu']           ="notification";
        $this->data['breadcrumb']     ="Staff Notification";
        $this->data['menu_item']      ="staff-notification";
        $this->data['staffArr']=$this->staff_enrollment_model->getactive_staff_list();
        $this->data['roleArr']=$this->common->get_roles();
         // print_r($this->data['roleArr']);die();
		$this->load->view('admin/layouts/_master',$this->data);
    }
   public function load_staffList_byAjax()
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

        // if($dir != "asc" && $dir != "desc") {
        //     $dir = "asc";
        // }

        $columns_valid = array(
            "am_staff_personal.name",
            "am_staff_personal.role"
           // "am_staff_personal.mobile",
            //"am_staff_personal.status"

        );

         if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }

           if(empty($this->input->post('search')['value']))
        {
            $list = $this->staff_enrollment_model->get_allactive_staffList_by_ajax($start, $length, $order, $dir);
        }
        else {
            $search = $this->input->post('search')['value'];

            $list = $this->staff_enrollment_model->get_all_staffList_by_ajax_search($start, $length, $order, $dir,$search);

        }
        $data = array();

        $no = $_POST['start'];
        foreach ($list as $rows) {
            $role_name=$this->common->get_name_by_id('am_roles','role_name',array("role"=>$rows['role']));
           
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $rows['name'];
            $row[] = $role_name;
            $row[] = '<td><label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                            <input type="checkbox" checked="checked" class="all_staff" name="staff_id[]" value="'.$rows['user_id'].'" />
                            <span class="checkmark"></span>
                            </label></td>';
            $data[] = $row;
        }

        $total_rows=$this->staff_enrollment_model->get_activenum_staffList_by_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
}
    
    
    public function active_staff_fetch()
    {
       
        $output = '';
        $filter_role = $this->input->post('filter_role'); 
        $data = $this->staff_enrollment_model->active_staff_fetch($filter_role);  
        $output .= '
            <div class="table-responsive table_language" style="margin-top:15px;">        
                <table id="staff_table" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50">Sl. No.</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th><label class="custom_checkbox">'.$this->lang->line('action').'
                    <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                    <span class="checkmark"></span>
                    </label></th>
                        </tr>
                    </thead>
            ';
        if($data->num_rows() > 0){
            $i=1;
            foreach($data->result() as $row){
                
                $output .= '
                            <tr>
                            <td>'.$i.'</td>
                            <td> '.$row->name.'</a></td>
                            <td>'.$row->role_name.'</td>
                            <td><label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                            <input type="checkbox" checked="checked" class="all_staff" name="staff_id[]" value="'.$row->user_id.'" />
                            <span class="checkmark"></span>
                            </label></td>
                            </tr>';
                            $i++;
                        }
                $output .=' </table>
                </div>';
        }
        echo $output;
    }

   public function send_message_staff()
   {
        if($_POST)
        {
            $staff_ids=$this->input->post('staff_id');
            $message=$this->input->post('message');
            if($message != "" && !empty($staff_ids))
            {
                foreach($staff_ids as $row)
                {
                   
                    $mobile=$this->common->get_name_by_id('am_staff_personal','mobile',array('user_id'=>$row));
                    $response=$this->Sms_model->send_sms($mobile,$message);
                   
                      $ajax_response['st']=1;
                      $ajax_response['msg']="Successfully sent notification";  
                }
            }
            else
            {
               $ajax_response['st']=2;
               $ajax_response['msg']="Please choose atleast one Staff"; 
            }
            print_r(json_encode($ajax_response));
        }
   }
}

?>