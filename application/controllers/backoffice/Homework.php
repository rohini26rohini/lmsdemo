<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homework extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
         $module="Employee";
        //check_backoffice_permission($module);
    }


    public function index()
    {  
        //check_backoffice_permission('home_work');
        $this->data['page']="admin/homework";
		$this->data['menu']="employee";
        $this->data['breadcrumb']="Homework";
        $this->data['menu_item']="home-work";
        $personal_id=$this->session->userdata['user_id'];
        $today=date("Y-m-d");
       // echo $today;
        $this->data['batches']=$this->Homework_model->get_faculity_scheduled_batch($personal_id,$today);
        //echo $this->db->last_query();
       // echo "<pre>";print_r($this->data['batches']); die();
        $this->data['details']=$this->common->get_alldata('am_homework',array("status"=>"1"));
        $this->load->view('admin/layouts/_master',$this->data);
    }
    
    public function add_homework()
    {
        if($_POST)
        {
          
          $_POST['date_of_submission']=date('Y-m-d',strtotime($this->input->post('date_of_submission'))); 
          $exist=$this->common->check_if_dataExist('am_homework',$_POST);
            if($exist == 0)
            {
                $insert_id=$this->Common_model->insert('am_homework', $_POST);
                if($insert_id !=0)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['message']="Homework added Successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['message']="Something went wrong,Please try again later..!";  
                }
            }
            else
            {
                $ajax_response['st']=2;  
                $ajax_response['message']="This data already exist"; 
            }
            
        }
        else
            {
              $ajax_response['st']=0;  
              $ajax_response['message']="Something went wrong,Please try again later..!";  
            }
        print_r(json_encode($ajax_response));
    }
    
    public function delete_homework()
    {
        if($_POST)
        {
            $id=$this->input->post('id');
            $response=$this->Common_model->update('am_homework', array("status"=>"2"),array("id"=>$id));
            if($response)
            {
                  $ajax_response['status']=1;  
                  $ajax_response['message']="Homework deleted Successfully..!";  
            }
            else
            {
                  $ajax_response['status']=0;  
                  $ajax_response['message']="Something went wrong,Please try again later..!";   
            }
        }
        else
        {
                  $ajax_response['status']=0;  
                  $ajax_response['message']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }
    
    public function get_homeworkdata_byId()
    {
        if($_POST)
        {
            $id=$this->input->post('id');
           $details =  $this->common->get_from_tablerow('am_homework',array('id'=>$id,'status'=>1));
            $details['date_of_submission']=date('d-m-Y',strtotime($details['date_of_submission']));
            $ajax_response['data'] =$details;
           print_r(json_encode($ajax_response)); 
        }
    }
    
    public function update_homework()
    {
        if($_POST)
        {
            $id=$this->input->post('edit_id');
            unset($_POST['edit_id']);
            $_POST['date_of_submission']=date('Y-m-d',strtotime( $_POST['date_of_submission']));
            $exist=$this->common->check_if_dataExist('am_homework',$_POST);
            if($exist <=1)
            {
              $response=$this->Common_model->update('am_homework',$_POST,array("id"=>$id)); 
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['message']="Data updated Successfully..!";
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['message']="Something went wrong,Please try again later..!";
                }
            }
            else
            {
              $ajax_response['st']=2;
              $ajax_response['message']="Something went wrong,Please try again later..!";  
            }
        }
        else
            {
              $ajax_response['st']=0;
              $ajax_response['message']="Something went wrong,Please try again later..!";  
            }
        print_r(json_encode($ajax_response));
    }
    
    public function load_homeworkList_ajax()
    {
       $html = '<thead><tr>
                <th width="50">'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('batch').'</th>
                <th>'.$this->lang->line('title').'</th>
                <th>'.$this->lang->line('description').'</th>
                <th>'.$this->lang->line('date_of_submission').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
        $data=$this->common->get_alldata('am_homework',array("status"=>"1"));
        if(!empty($data))
        {
            $i=1;
            foreach($data as $row)
            {
                $batch_name=$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));                                     
                $html.='<tr>
                       <td>'.$i.'</td>
                       <td>'.$batch_name.'</td>
                       <td>'.$row['title'].'</td>
                       <td>'.$row['description'].'</td>
                       <td>'.date('d-m-Y',strtotime($row['date_of_submission'])).'</td>
                       <td><button class="btn btn-default option_btn " title="Edit" onclick="get_homework_data('.$row['id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_homework_data('.$row['id'].')"><i class="fa fa-trash-o"></i>
                    </a></td>
                       </tr>';
                $i++;
            }
        }
        echo $html;  
    }
    
    public function view_batch_student_homework()
    {
        if($_POST)
        {
            $homework_id=$this->input->post('id');
            $batch_id=$this->input->post('batch_id');
             $student_details=$this->student_model->get_student_list_msg(array("am_student_course_mapping.batch_id"=>$batch_id,'am_students.status'=>1));
            //echo "<pre>"; print_r($student_details);
            $html='<div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          
              <h6 class="examavg">Student Homework Details</h6>
              <form id="verify_homework" method="post">
               <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.  $this->security->get_csrf_hash().'" />
              <div class="form-group" id="status"><label>Status</label><select class="form-control" name="status" ><option value="">Select</option><option value="2">Verified</option></select></div>
              <hr class="examavgHr">

                <div class="table-responsive table_language" id="all_data">
                    <table id="batch_examlist_table" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">Sl. No.</th>
                                <th>Student</th>
                                <th>Reg.No</th>
                                <th>Status</th>
                                <th>Submitted date</th>
                                <th><label class="custom_checkbox">'.$this->lang->line('action').'
                    <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                    <span class="checkmark"></span></th>
                            </tr>
                        </thead>
                        <tbody>';
            if(!empty($student_details))
            { $i=1;
                foreach($student_details as $row)
                {
                    $details="";
                    $submitteddate="";
                    $exist_homework=$this->common->check_if_dataExist('am_student_homeworks',array("homework_id"=>$homework_id,"student_id"=>$row['student_id']));
                    if($exist_homework!=0)
                    {
                        $date=$this->common->get_name_by_id('am_student_homeworks','submitted_date',array("homework_id"=>$homework_id,"student_id"=>$row['student_id']));
                       $submitteddate= date('d-m-Y',strtotime($date));
                      $homework_status=$this->common->get_name_by_id('am_student_homeworks','status',array("homework_id"=>$homework_id,"student_id"=>$row['student_id']));
                        if($homework_status ==1)
                        {
                           $status="Submitted"; 
                        }
                        else if($homework_status ==2)
                        {
                           $status="Verified";    
                        }
                        $details='<label class="custom_checkbox">
                            <input type="checkbox" checked="checked" class="all_student" name="student_id[]" value="'.$row['student_id'].'">
                            <span class="checkmark"></span>
                            </label><input type="hidden" name="homework_id[]" value="'.$homework_id.'"/>
                            <button type="button" class="btn btn-primary btn-sm btn_details_view homework_detail" onclick="view_homework_bystudentid('.$row['student_id'].','.$homework_id.')">Details</button>';
                    }
                    else
                    {
                        $status="Pending";
                    }
                    
                   $html.='<tr>
                                <td>'.$i.'</td>
                                <td>'.$row['name'].'</td>
                                <td>'.$row['registration_number'].'</td>
                                <td>'.$status.'</td>
                                <td>'.$submitteddate.'</td>
                                <td>'.$details.'</td>
                            </tr>'; 
                    $i++;
                }
            }
             $html.='</tbody></table></div><button class="btn btn-info btn_save" id="save">Save</button></form></div></div><div  id="student_data">
        </div><script> $("form#verify_homework").validate({
        rules: {
           status: {
                required: true
            }
        },
        messages: {
            status: "Please choose a status"
            },

        submitHandler: function(form) { $.ajax({
                url: "'.base_url().'backoffice/Homework/verify_homework",
                type: "POST",
                data: $("#verify_homework").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                        $("#verify_homework").each(function(){
                                        this.reset();
                                });
                        
                          
                        $.toaster({priority:"success",title:"Success",message:obj.msg});

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:"warning",title:"INVALID",message:obj.msg});
                    }
                     else{
                         $.toaster({priority:"danger",title:"INVALID",message:"Something went wrong,Please try again later..!"});
                    }
                    $(".loader").hide();
                }

            });}


    });</script>';
            echo $html;
        }
    }
    
    public function get_homework_by_batch()
    {
     
        if($_POST)
        {
            $html = '<thead><tr>
                <th width="50">'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('batch').'</th>
                <th>'.$this->lang->line('title').'</th>
                <th>'.$this->lang->line('description').'</th>
                <th>'.$this->lang->line('date_of_submission').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
            $batch_id=$this->input->post('batch_id');
             $data=$this->common->get_alldata('am_homework',array("status"=>"1","batch_id"=>$batch_id));
             if(!empty($data))
             {
                $i=1;
                foreach($data as $row)
                {
                    $batch_name=$this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));                                     
                    $html.='<tr>
                           <td>'.$i.'</td>
                           <td>'.$batch_name.'</td>
                           <td>'.$row['title'].'</td>
                           <td>'.$row['description'].'</td>
                           <td>'.date('d-m-Y',strtotime($row['date_of_submission'])).'</td>
                           <td><button class="btn btn-default option_btn " title="Edit" onclick="get_homework_data('.$row['id'].')">
                         <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_homework_data('.$row['id'].')"><i class="fa fa-trash-o"></i>
                        </a></td>
                           </tr>';
                    $i++;
                }
            }
            echo $html;
        }
    }
    
    public function view_homework_bystudentid()
    {
        if($_POST)
        {
            $student_id=$this->input->post('student_id');
            $homework_id=$this->input->post('homework_id');
            $details=$this->common->get_alldata('am_student_homeworks',array("student_id"=>$student_id,"homework_id"=>$homework_id));
            $html='<div class="table-responsive table_language">
            <p class="dropPara">Remarks:<span>'.$details[0]['remarks'].'</span></p>
            <table id="batch_examlist_table" class="table table-striped table-sm" >
                        <thead>
                            <tr>
                                <th>Files</th>  
                        
                            </tr>
                        </thead>
                        <tbody>';
            if(!empty($details))
            {
                foreach($details as $row)
                {
                  $html.='<tr><td><img src="'.base_url().'uploads/homeworks/'.$row['file_name'].'" style="height:50px; width:auto;"/></td>
                  <td></td>
                  </tr>';   
                }
            }
            $html.='</tbody></table>';
           echo $html; 
        }
    }
    public function view_homework_bystudentid_new()
    {
        if($_POST)
        {
            $student_id=$this->input->post('student_id');
            $homework_id=$this->input->post('homework_id');
            $details=$this->common->get_alldata('am_student_homeworks',array("student_id"=>$student_id,"homework_id"=>$homework_id));
            $html='<div class="inner_page_wrapper gallery-view">
        <div class="container maincontainer">
            <div id="#" class="links">
                <div class="masonry-layout">';
            if(!empty($details))
            {
                foreach($details as $row)
                {
                  /*$html.='<tr><td><img src="'.base_url().'uploads/homeworks/'.$row['file_name'].'" style="height:50px; width:auto;"/></td>
                  <td></td>
                  </tr>';*/
                   $html.='<div class="masonry-layout__panel">
                        <div class="masonry-layout__panel-content">
                            <a href="'.base_url().'uploads/homeworks/'.$row['file_name'].'" data-gallery>
                                <img src="'.base_url().'uploads/homeworks/'.$row['file_name'].'" alt="gallery" class="img-fluid ">
                            </a>
                        </div>
                    </div>'; 
                }
            }
            $html.='</div><div id="blueimp-gallery" class="blueimp-gallery">
                <div class="slides"></div>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close"><span>×</span></a>
                <a class="play-pause" style=" background-image: url("'.base_url().'uploads/homeworks/'.$row['file_name'].'");"></a>
                <ol class="indicator"></ol>
            </div></div></div></div>';
           echo $html; 
        }
    }
    
    public function verify_homework()
    {
        if($_POST)
        {
            $students_ids=$this->input->post('student_id');
            $status=$this->input->post('status');
            $homework_id=$this->input->post('homework_id');
            foreach($students_ids as $key=> $row)
            {
              $response=$this->Common_model->update('am_student_homeworks', array("status"=>$status),array("student_id"=>$row,"homework_id"=>$homework_id[$key]));  
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully Updated Status";
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";  
                }
            }
            print_r(json_encode($ajax_response));
        }
        
    }
}
?>