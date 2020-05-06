<?php
defined('BASEPATH') OR exit('No direct script amanage_student_registrationccess allowed');

class Students extends Direction_Controller {

    public function __construct() {
        parent::__construct();
        $module="students";
        check_backoffice_permission($module);
    }

    public function index(){
        check_backoffice_permission("manage_students");
        $this->data['page']="admin/student_list";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Manage Students";
        $this->data['menu_item']="backoffice/manage-students";
        $this->data['studentArr']=[];//$this->student_model->get_student_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function add_student_view(){
        $this->data['page']="admin/add_student";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Register Student";
        $this->data['menu_item']="backoffice/manage-students";
        $this->data['stateArr']=$this->common->get_all_states();
        $this->data['courseArr']=$this->Class_model->get_allclass_list();
         //echo "<pre>";print_r($this->data['courseArr']);die();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function add_student(){
        // show($_POST);
        if($_POST){
        unset($_POST['ci_csrf_token']);
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|callback_contactnum_check');
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|callback_emailid_check');
            $this->form_validation->set_rules('course_id', 'Course', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('blood_group', 'Blood Group', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('street', 'Street Name', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('district', 'City', 'trim|required');
            $this->form_validation->set_rules('whatsapp_number', 'WhatsApp No', 'trim|required');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
            $this->form_validation->set_rules('date_of_birth', 'Date Of Birth', 'trim|required');
            $this->form_validation->set_rules('guardian_name', 'Name of Guardian', 'trim|required');
            $this->form_validation->set_rules('guardian_number', 'Guardian Contact Number', 'trim|required');
            //$this->form_validation->set_rules('contact_number', 'Contact Number', 'callback_contactnum_check');
            if($this->form_validation->run()){
                if(!empty($_FILES['file_name']['name'])){
                    $files = str_replace(' ', '_', $_FILES['file_name']);
                    $this->load->library('upload');
                    $config['upload_path']           = 'uploads/student_images/';
                    $config['allowed_types']        = 'jpg|jpeg|png|bmp';
                    $config['max_size'] = '2000';
                    $_FILES['file_name']['size']     = $files['size'];
                    $config['file_name'] =$this->input->post('name').'_'.time();
                    // $_FILES['file_name']['size']     = $files['size'];
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    $upload = $this->upload->do_upload('file_name');
                    $fileData = $this->upload->data();
                    if(!$upload){
                        // echo  $this->upload->display_errors();
                        $student_image="";
                        unset($_POST['student_image']);
                    }else{
                        $student_image ='uploads/student_images/'. $fileData['file_name'];
                        $_POST['student_image']=$student_image;
                    }
                }else{
                    $student_image = "";
                    unset($_POST['student_image']);
                }
                $course_id=$this->input->post('course_id');
                unset($_POST['course_id']);
                //check the numbers with call centre
                $contact_numbers=array(
                    "0"=>$this->input->post('contact_number'),
                    "1"=>$this->input->post('whatsapp_number'),
                    "2"=>$this->input->post('mobile_number'),
                    "3"=>$this->input->post('guardian_number'),
                );
                foreach($contact_numbers as $number){
                    $query=$this->db->select('*')
                    ->from('cc_call_center_enquiries')
                    ->or_like('primary_mobile', $number)
                    ->or_like('father_mobile', $number)
                    ->or_like('mother_mobile', $number)
                    ->get();
                    if($query->num_rows() > 0)
                    {   //get caller_id
                        $caller_id=$query->row()->call_id;
                        //save the caller id in student registration table
                        $_POST['caller_id']=$caller_id;              
                       //change the status in call center 
                             $this->db->where('call_id',$caller_id);
		                     $query	= $this->db->update('cc_call_center_enquiries',array("call_status"=>"5"));
                             break;	

                    }
                }
                //register student
                $_POST['date_of_birth'] = date('Y-m-d',strtotime($_POST['date_of_birth']));
                // show($_POST);
                $student_id=$this->student_model->add_student($_POST);
                //generate the userid and password
                $this->data['userid']=generate_userid($student_id);
                $this->load->model('Auth_model');
                $password =mt_rand(100000,999999);
                $encrypted_password= $this->Auth_model->get_hash($password);
                $student_credential=array(
                    "user_name"=>$this->input->post('name'),
                    "user_primary_id"=>$student_id,
                    "user_username"=>$this->data['userid'],
                    "user_emailid"=>$this->input->post('email'),
                    "user_passwordhash"=>$encrypted_password,
                    "user_role"=>"users",
                    "user_phone"=>$this->input->post('mobile_number'),
                    "user_image"=>$this->input->post('student_image')
                );
                /**********save the generated userid,password,userimage and user role************/
                $this->register_model->save_student_credential($student_credential);
                //save userid in reg table
                $this->db->where('student_id', $student_id);
                $query= $this->db->update('am_students',array("registration_number"=>$this->data['userid']));
                //check parent as already have a login credential or not
                $guardian_number=$this->input->post('guardian_number');
                $exist=$this->common->check_if_dataExist("am_users",array("user_username"=>$guardian_number,"user_role"=>"parent"));
                if($exist == 0){
                    // Parent credentials insert
                    $password =mt_rand(100000,999999);
                    $parent_password= $this->Auth_model->get_hash($password);
                    $parent_credential=array(
                        "user_name"=>$this->input->post('guardian_name'),
                        //"user_primary_id"=>$student_id,
                        "user_username"=>$this->input->post('guardian_number'),
                        "user_emailid"=>$this->input->post('email'),
                        "user_passwordhash"=>$parent_password,
                        "user_role"=>"parent",
                        "user_phone"=>$this->input->post('guardian_number')
                    );
                    $sql= $this->register_model->save_student_credential($parent_credential);
                    $parent_id=$this->common->get_name_by_id("am_users","user_id",array("user_username"=>$guardian_number,"user_role"=>"parent"));
                }else{
                    $parent_id=$this->common->get_name_by_id("am_users","user_id",array("user_username"=>$guardian_number,"user_role"=>"parent"));
                }
                if($query){
                    //insert parent id
                    $this->Common_model->update("am_students", array("parent_id"=>$parent_id),array("student_id"=>$student_id));
                      // send email
                    $num=$this->data['userid'];
                    $type="Registration";
                    $email=$this->input->post('email');
                    $data=email_header();
                    $data.='<tr style="background:#f2f2f2">
                            <td style="padding: 20px 0px">
                                <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi</h3>
                                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">You are successfully registered.Your Token number is '.$num.'
                                </p>
                            </td>
                        </tr>';
                    $data.=email_footer();
                    $this->send_email($type, $email,$data);
                }
                //create log
                $new=$this->common->get_from_table('am_students', array("student_id"=>$student_id));
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                $message=$_POST['name']."New student details added";
                //logcreator('insert','database',$who,'',$student_id, 'am_students', $message, $new);
                if($student_id != 0){
                    $course_detail=array(
                        'course_id'=> $course_id,
                        'student_id'=> $student_id
                        ); 
                          $course_result=$this->register_model->add_student_course($course_detail);
                          unset($_POST['student_id']);
                          $new=$this->common->get_from_table('am_student_course_mapping', array("student_id"=>$student_id));
                          $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                          $message="New student details added, Name: ".$_POST['name'];
                          logcreator('insert','database',$who,'',$student_id, 'am_student_course_mapping', $message, $new);
                          //redirect(base_url().'backoffice/manage-students/'.$student_id);
                          $returnData['st'] 		  = 11;
                          $returnData['message'] 	= $student_id;
                          print_r(json_encode($returnData));
                    exit();
                }
            }else{
                $returnData['st'] 		  = 0;
                $returnData['message'] 	= strip_tags(explode('</p>',validation_errors())[0]);
                print_r(json_encode($returnData));
            }
        }else{
            $returnData['st'] 		  = 2;
            $returnData['message'] 	= "Something went wrong,Please try again later..!";
            print_r(json_encode($returnData));  
        }
    }
    public function contactnum_check()
        {

                $contact_number=$this->input->post('contact_number');
                $query= $this->db->get_where('am_students',array("contact_number"=>$contact_number));
                if($query->num_rows()>0)
                {
                     $this->form_validation->set_message('contactnum_check', 'This {field} already exist');
                   return FALSE;
                }
                else
                {
                    return TRUE;
                }
               
        }
   
    public function emailid_check()
        {

                $email=$this->input->post('email');
                $query= $this->db->get_where('am_students',array("email"=>$email));
                if($query->num_rows()>0)
                {
                     $this->form_validation->set_message('emailid_check', 'This {field} already exist');
                   return FALSE;
                }
                else
                {
                    return TRUE;
                }
               
        }

    public function search_students()
    {
     
        $resultArr=$this->student_model->search_students($_POST);
           $html=' <thead>
                     <tr>
                         <th width="50">'. $this->lang->line('sl_no').'</th>
                         <th>'. $this->lang->line('application.no').'</th>
                         <th>'. $this->lang->line('name').'</th>
                         <th>'. $this->lang->line('emailid').'</th>
                         <th>'. $this->lang->line('contact.no').'</th>
                         <th>'. $this->lang->line('location').'</th>
                         <th>'. $this->lang->line('status').'</th>
                         <th>'. $this->lang->line('action').'</th>
                     </tr>
                 </thead>';
        if(!empty($resultArr))
        {
      
            $i=1;
            foreach($resultArr as $result)
            {
                 if ($result['status']==1)
            {
                $status= '<span class="admitted">Admitted</span>';
            }
            else if($result['status']==2) 
            {
                $status= '<span class="paymentcompleted">Fee Paid</span>';
            }
            else if($result['status']==4) 
            { 
                $status= '<span class="batchchanged">Batch Changed</span>';
            }
            else if($result['status']==5) 
            {
                $status= '<span class="inactivestatus">Inactive</span>';
            }
            else 
            {
                $status= '<span class="registered">Registered</span>';
            }
            
            if($result['caller_id']>0) 
            { 
                $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$result['caller_id']));
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

                
                
                $href=base_url('backoffice/view-student/'.$result['student_id']);
                $href_edit= base_url('backoffice/manage-students/'.$result['student_id']);
                $href_download= base_url('backoffice/print-application/'.$result['student_id']);

               $html.='<tr><td>'.$i.'</td>
               <td>'.$result['registration_number'].'</td>
               <td>'.$result['name'].'</td>
               <td>'.$result['email'].'</td>
               <td>'.$result['contact_number'].'</td>
               <td>'.$result['street'].'</td>
               <td>'.$status." ".$blacklist_status.'</td>
               <td><a href ="'.$href.'" id="#view_student" >
                        <button  type="button" class="btn btn-default option_btn " title="View" onclick="view_studentdata("'.$result['student_id'].'")">
                            <i class="fa fa-eye "></i>
                        </button>
                    </a> 
                    <a href ="'.$href_download.'" target="_blank">
                        <i class="fa fa-download"></i>
                    </a>
                    <a class="btn btn-primary btn-sm" href="'.$href_edit.'">
                        Details
                    </a>
                </td>
               </tr>';
                $i++;
            }
        }
        /*$ajax_response['html']=$html;
        print_r(json_encode($ajax_response));*/
        echo $html;

    }

    public function manage_student_registration($id)
    {
        $this->data['page']             = "admin/student_reg_view"; 
		$this->data['menu']             = "students";
        $this->data['breadcrumb']       = "Manage Students";
        $this->data['menu_item']        = "backoffice/manage-students";
        $this->data['stateArr']         =  $this->common->get_all_states();
        $this->data['routeArr']         =  $this->transport_model->get_route_list();
        $this->data['courseArr']        =  $this->Class_model->get_allclass_list();
        $studentArr=$this->student_model->get_studentdetails_byid($id);
        $this->data['stopArr']=$this->common->get_alldata('tt_transport_stop',array("transport_id"=>$studentArr['place']));
        $room_data=$this->common->get_from_tablerow('hl_room_booking', array("student_id"=>$id,"delete_status"=>"1","status !="=>"checkout"));
        if(!empty($room_data)){
             $this->data['hostel_room_details'] =  $this->Hostel_model->get_hostel_roomdata_byId($room_data['room_id']);
        }


        $this->data['studentcourse']    = $this->student_model->get_student_course($id);
        $this->data['discounts']        = $this->student_model->get_discounts();
        if(!empty($this->data['studentcourse'])){
            $course_id                      = $this->data['studentcourse']['course_id'];
            $this->data['coursecenter']     = $this->Class_model->get_courses_centerlist_status($course_id);
            $this->data['coursebranch']     = $this->Class_model->get_branch_courselist_status($course_id);
        }
        
        $this->data['courses']          = $this->Class_model->get_active_courses();
        $state_id                       = $studentArr['state'];
        $this->data['Selectedcourse']   = $this->data['studentcourse'];//$this->student_model->get_student_course($id);
        $this->data['studentcard']      = $this->student_model->get_student_card_details($id);
        // $this->data['documents']        = $this->student_model->get_student_documents($id);
        $this->data['documents'] = $this->student_model->get_student_documents($id);
        // echo '<pre>';
        // print_r($this->data['documents']);
        $this->data['studentcourses']      = $this->student_model->get_student_courses($id);
        $this->data['DistrictArr']      = $this->common->get_district_bystate($state_id);
        $this->data['studentArr']       = $studentArr;
          //print_r( $this->data['studentArr']); die();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function download_idcard($id){ 
        $data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
        $data['studentcard']  = $this->student_model->get_student_card_details($id);
        // echo '<pre>';
        // print_r($data['studentcard']);
        // die();
        $this->db->where('student_id', $data['studentArr']['student_id']);
        $this->db->update('am_students', array('idcard_status'=> 1)); 
        $html = $this->load->view('admin/pdf/id_print',$data,TRUE);
        $file = $data['studentArr']['name'].$data['studentArr']['student_id'].'.pdf';
        $filepath = FCPATH.'uploads/student_id_cards/'.$file;
        $url = base_url('uploads/student_id_cards/'.$file);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html); 
        $pdf->Output($filepath, "F");
        $returndata['st']=1;
        $returndata['url']=$url;
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $message="Student ID Card downloaded";
        logcreator('update','Download',$who,'',$id, 'am_student', $message);
        print_r(json_encode($returndata));
    }


    function get_student_course_view() {
        $student_id = $this->input->post('student_id');
        $this->data['student_id'] = $student_id;
        $this->data['courseslist'] = $this->Class_model->get_active_courses();
        $this->data['courses'] = $this->student_model->get_student_courses($student_id); //echo '<pre>';print_r($this->data['courses']);
        $html = $this->load->view('admin/students/student_reg_view_55',$this->data, TRUE);
        echo $html;
    }


    function student_course_adding() {
        $student_id     = $this->input->post('student_id');
        $selectedcourse = $this->input->post('selectedcourse');
        $institute_course_mapp = $this->common->get_from_tablerow('am_institute_course_mapping', array('course_master_id'=>$selectedcourse,'status'=>1)); 
        $studentmapp['student_id'] = $student_id;
        $studentmapp['course_id'] = $selectedcourse;
        $studentmapp['institute_course_mapping_id'] = $institute_course_mapp['institute_course_mapping_id'];
        $studentmapp['branch_id']    = $institute_course_mapp['branch_master_id'];
        $studentmapp['center_id']    = $institute_course_mapp['institute_master_id'];
        $studentmapp['batch_id']     = $selectedcourse;
        $studentmapp['status']      = 1;
        $result = $this->db->insert('am_student_course_mapping', $studentmapp);
        if($result) {
            echo 1;
        } else {
            echo 2;
        }
    }

//     function download_idcard($id){
//         $data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
//         // echo '<pre>';
//         // print_r($data['studentcard']);
//         // die();
       
//         // $data = $this->call_center_model->fetch_data($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce, $user_id, $role);
//         // if($data->num_rows() > 0){
//         $filename      = $data['studentArr']['name'].$data['studentArr']['student_id'].'.pdf';
//         $pdfFilePath = FCPATH.'uploads/student_id_cards/'.$filename; 
//         $url = base_url('uploads/student_id_cards/'.$filename);
//         $data['studentcard']  = $this->student_model->get_student_card_details($id);
//         $html = $this->load->view('admin/pdf/id_print',$data,TRUE);
//         ini_set('memory_limit','128M'); // boost the memory limit if it's low ;)
//         $this->load->library('pdf');
//         $pdf = $this->pdf->load();
//         $pdf->SetFooter('<div style="text-align:center;"><img src="./assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure ;)
//         $pdf->WriteHTML($html); // write the HTML into the PDF
//         $pdf->Output($filename, "D"); 
//         $returndata['st']=1;
//         $returndata['url']=$url;
//         print_r(json_encode($returndata));// save to file because we can
//     // }else{
//     //     $this->session->set_userdata('toaster_error', "Add atleast one Caller Detail");
//     //     redirect(base_url() . 'backoffice/manage-calls','refresh');
//     // }
// }

    public function get_student_idcard_preview($id){
        $data['studentArr']   = $this->student_model->get_studentdetails_byid($id);
        $data['studentcard']  = $this->student_model->get_student_card_details($id);
        $html = $this->load->view('admin/students/student_reg_view_8',$data,TRUE);
        $returndata['st']=1;
        $returndata['html']=$html;
        print_r(json_encode($returndata)); 
    }
    
     public function emailCheck_edit()
    {
        $email=$this->input->post('email');
        $student_id=$this->input->post('student_id');
        $query= $this->db->get_where('am_students',array("email"=>$email,"student_id!="=>$student_id));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    } 
    public function emailCheck()
    {
        $email=$this->input->post('email');
        $query= $this->db->get_where('am_students',array("email"=>$email));
        
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function contact_numberCheck()
    {
        $contact_number=$this->input->post('contact_number');
        $query= $this->db->get_where('am_students',array("contact_number"=>$contact_number));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function edit_contact_numberCheck()
    {
        $contact_number=$this->input->post('contact_number');
        $student_id=$this->input->post('student_id');
        $query= $this->db->get_where('am_students',array("contact_number"=>$contact_number,"student_id!="=>$student_id));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }

    public function student_register()
    {
        $student_id=$this->input->post('student_id');
        $parent_id=$this->common->get_name_by_id('am_students','parent_id',array("student_id"=>$student_id));
        /*uploading student image*/
        if(!empty($_FILES['file_name']['name']))
        { //print_r($_FILES);

            $files = str_replace(' ', '_', $_FILES['file_name']);
            $config['upload_path']           = 'uploads/student_images/';
            $config['allowed_types']        = 'jpg|png|jpeg|bmp';
            $config['max_size']      = '2000';
            $_FILES['file_name']['size']     = $files['size'];
            $config['file_name'] =$this->input->post('name').'_'.time();
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');
            $studentArr['student_id']="";
            $fileData = $this->upload->data();
           
             if($upload)
             {
                $student_image = $fileData['file_name'];            
                $_POST['student_image']='uploads/student_images/'.$student_image; 
             }
            else
            {
                $student_image="";
               unset($_POST['student_image']);
            }
        }
        else
        {
            $student_image="";
            unset($_POST['student_image']);
        }
        $student_id=$this->input->post('student_id');
        $course_id=$this->input->post('course_id');
        unset($_POST['student_id']);
        unset($_POST['course_id']);
        $course_detail=array(
            'course_id'=> $course_id,
            'student_id'=> $student_id
            );
        
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        /*check is there any course choosen*/
        $course_exist=$this->student_model->is_course_existfor_student($student_id);
        if($course_exist == 0)
        {   //add course
            $old="";
            $course_result=$this->register_model->add_student_course($course_detail);
            $action="insert";
            $table_id=$this->db->insert_id();
        }
        else
        {
            //edit course
          $old=$this->common->get_from_table('am_student_course_mapping', array("student_id"=>$student_id));
          //$course_result=$this->student_model->edit_student_course($course_id,$student_id);
          $action="update";
          $table_id=$student_id;
        }
        //log insertion of course
        $message="Student ".$this->input->post('name')." course details updated";
        $new=$this->common->get_from_table('am_student_course_mapping', array("student_id"=>$student_id));
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        logcreator($action,'database',$who,$old,$table_id,'am_student_course_mapping', $message, $new);
        
        //log insertion of student details
         $old_data=$this->common->get_from_table('am_students', array("student_id"=>$student_id));
        //insert student details
       // print_r($_POST);
        if($this->input->post('transportation') == "no")
        {
            $transdata = $this->common->get_from_tablerow('tt_student_transport', array('student_id'=>$student_id,'status'=>1));
            if(!empty($transdata)){
                $transArr = array(
                                'status'=>2
                            );
            $this->Common_model->update('tt_student_transport', $transArr, array('st_id'=>$transdata['st_id'])); 
            }
            unset($_POST['place']);
            unset($_POST['stop']);
            unset($_POST['trans_start_date']);
            
        }
        else
        {
            if(isset($_POST['trans_start_date'])) {
            $_POST['trans_start_date'] = date('Y-m-d', strtotime($_POST['trans_start_date']));
            }
            $transdata = $this->common->get_from_tablerow('tt_student_transport', array('student_id'=>$student_id,'status'=>1));
            if(!empty($transdata)){
                if(isset($_POST['place']) || isset($_POST['place'])){
                    $transArr = array('route_id'=>$_POST['place'],
                        'stop_id'=>$_POST['stop'],
                        'status'=>1
                    );
                    $this->Common_model->update('tt_student_transport', $transArr, array('st_id'=>$transdata['st_id'])); 
                }
            } else {
                
                if(isset($_POST['place']) || isset($_POST['place'])){
                    $transArr = array('student_id'=>$student_id,
                        'route_id'=>$_POST['place'],
                        'stop_id'=>$_POST['stop'],
                        'status'=>1
                    );    
                    $this->Common_model->insert('tt_student_transport', $transArr); 
                }
            }              
            $student_status=$this->common->get_name_by_id('am_students','status',array("student_id"=>$student_id));
        if($student_status ==1){
            if(isset($_POST['place']) || isset($_POST['place'])){
                $transport_fee= $this->common->get_transport_fee($student_id,$_POST['place'],$_POST['stop']);
            }
            // $paymentArr=$this->common->get_from_tablerow('pp_student_payment',array("student_id"=>$student_id));
            // if($paymentArr['transport_fee'] == "" || $paymentArr['transport_fee'] == 0.00){
            //     $payable_amount = $transport_fee+$paymentArr['payable_amount'];
            //     $balance        = $transport_fee+$paymentArr['balance'];
            //     $payment_data   = array("transport_fee"=>$transport_fee,
            //                             "payable_amount"=>$payable_amount,
            //                             "balance"=>$balance
            //                         );
            //     $update=$this->Common_model->update('pp_student_payment', $payment_data,array("student_id"=>$student_id));
            // }
        }
        }
        // show($_POST);
        if(isset($_POST['date_of_birth'])) {
        $dob = str_replace("/","-",$_POST['date_of_birth']);
        $_POST['date_of_birth'] = date('Y-m-d',strtotime($dob));
        }
        $ajaxresponse['st']=$this->student_model->student_register($student_id,$_POST);
        //  echo $this->db->last_query();
        if($this->input->post('guardian_name') !="" || $this->input->post('guardian_number') !="")
        {
             $this->db->where('user_id', $parent_id);
             $sql=$this->db->update('am_users',array('user_name'=>$this->input->post('guardian_name'),'user_username'=>$this->input->post('guardian_number')));  
        }
         
        
             if($this->input->post('name') !="" || $this->input->post('email')!="" || $this->input->post('contact_number')!="")
             { 
                   //update the user details in am_user table 
                   $user_data['user_name']=$this->input->post('name');
                   $user_data['user_emailid']=$this->input->post('email');
                   $user_data['user_phone']=$this->input->post('contact_number');  
                    $this->db->where('user_primary_id', $student_id);
                    $query=$this->db->update('am_users',$user_data); 
                    $this->db->where('user_id', $parent_id);
                    $sql=$this->db->update('am_users',array("user_emailid"=>$this->input->post('email')));
                   
             }
        $new_data=$this->common->get_from_table('am_students', array("student_id"=>$student_id));
        $message = 'Student '.$this->input->post('name').' details updated';
        logcreator($action,'database',$who,$old_data,$student_id, 'am_students', $message, $new_data);
        //$ajaxresponse['tab']=2;
        print_r(json_encode($ajaxresponse));

    }
    


     public function get_district_bystate()
     {
        $id=$this->input->post('state_id');
        $DistrictArr=$this->common->get_district_bystate($id);
        echo '<option value="">Select City</option>';
        foreach($DistrictArr as $row)
        {
          echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
     }

    //--------------------------------------------View Students-----------------------------------------//
    public function view_student($id=NULL){
        if($id!=NULL)
        {
            $studView = $this->student_model->get_studentview_by_id($id);
            $room_data=$this->common->get_from_tablerow('hl_room_booking', array("student_id"=>$id,"delete_status"=>"1"));
             if(!empty($room_data))
             {
             $this->data['hostel_room_details'] =  $this->Hostel_model->get_hostel_roomdata_byId($room_data['room_id']);
             }

            $studquali = $this->student_model->get_studentquali_by_id($studView['student_id']);

            $studdocuments = $this->student_model->get_studentdocument_by_id($studView['student_id']);
            $this->data['history_details']=$this->common->get_alldata('am_student_status',array("student_id"=>$studView['student_id']));
            $this->data['studView'] = $studView;
            $this->data['studquali'] = $studquali;
            $this->data['studdocuments'] = $studdocuments;
            $this->data['meetingArr']   = $this->student_model->get_stud_meeting_list($studView['student_id']);
            // echo '<pre>';
            // print_r($this->data['meetingArr']);

        }
        $this->data['page']="admin/student_view";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Student Profile";
        $this->data['menu_item']="backoffice/view-student";
        $this->data['studArr']=$this->student_model->get_student_profile_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    
     /*
    *   function'll get branch by course
    *   @params course id
    *   @author GBS-R
    *
    */
    
    public function get_branchlistby_course (){
        $course_id  = $this->input->post('course_id');
        // $course_id  = $this->input->post('course_id');
        $branches   = $this->Batch_model->get_all_branches($course_id);
        if(!empty($branches)) {
            echo '<option value="">Select Branch</option>';
            foreach($branches as $row){ 
                    echo '<option value="'.$row->branch_master_id.'" >'.$row->institute_name.'</option>';
           
            }
        }
    }
    
    
    /*
    *   function'll get centers by course and branch
    *   @params course id, branch id
    *   @author GBS-R
    *
    */
    
    public function get_centerby_coursebranch (){
        $branch_id  =   $this->input->post('branch_id');
        $course_id  =   $this->input->post('course_id');
        $centers    =   $this->Class_model->get_centerby_branchcourse($branch_id, $course_id);
        $options = '';
        if(!empty($centers)) {
            $options .= '<option value="">Select center</option>';
            foreach($centers as $center) {
                $options .= '<option value="'.$center->institute_course_mapping_id.'" >'.$center->institute_name.'</option>';
            }
        } 
        echo $options;
    }
    


    /*
    *   function'll get batch by center course mapp
    *   @params center course mapp id
    *   @author GBS-R
    *
    */
    
    public function get_center_coursebatch (){
        $center_course_id   =   $this->input->post('center_course_id');
        $batches            =   $this->Batch_model->get_batchby_coursecentermapp($center_course_id); 
        $options = '';
        if(!empty($batches)) {
            $options .= '<div class="table-responsive table_language table_batch_details" >
                                <table class="table table-bordered table-striped table-sm">
                                    <tr>
                                        <th></th>
                                        <th>Batch</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>

                                        <th>Available Seats</th>
                                        <th>Fees</th>
                                    </tr>';
            foreach($batches as $batch) {
                $studentbatch = $this->common->get_total_student($batch['batch_id']);
                $options .= '<tr>
                                        <td><input type="radio" name="batch" value="'.$batch['batch_id'].'"/></td>
                                        <td>'.$batch['batch_name'].'</td>
                                        <td>'.date('d M Y',strtotime($batch['batch_datefrom'])).'</td>
                                        <td>'.date('d M Y',strtotime($batch['batch_dateto'])).'</td>';
$totalstunt = $batch['batch_capacity']-$studentbatch;
if($totalstunt<0) {
    $availablecnt = '<span class="error">Invalid batch capacity, Total student admitted is '.$studentbatch.'</span>';
} else {
    $availablecnt = $totalstunt;
}
$options .= '<td>'.$availablecnt.'/'.$batch['batch_capacity'].'</td>
                                        <td>'.numberformat($batch['course_totalfee']).'</td>
                                    </tr>';
            }
        } 
        echo $options;
    }
    
//    public function get_center_coursebatch (){
//        $center_course_id   =   $this->input->post('center_course_id');
//        $batches            =   $this->Batch_model->get_batchby_coursecentermapp($center_course_id); 
//        $options = '';
//        if(!empty($batches)) {
//            $options .= '<option value="">Select Batch</option>';
//            foreach($batches as $batch) {
//                $options .= '<option value="'.$batch['batch_id'].'" >'.$batch['batch_name'].'</option>';
//            }
//        } 
//        echo $options;
//    }
    
    
/*
*   function'll approve online payment
*   @params student_id
*   @author GBS-R
*
*/
    
// public function online_pay_approve(){
//     $student_id  =   $this->input->post('student_id');
//     if($student_id != '') {
//         $password =mt_rand(100000,999999);
//         $encrypted_password= $this->Auth_model->get_hash($password);
//         $data        =   array('user_status'=>1,'user_passwordhash'=>$encrypted_password);
//         $where       =   array('user_primary_id'=>$student_id);
//         $this->db->where($where);
//         $query       =   $this->db->update('am_users', $data); 
//         if($query) {
//             $studentArr =   $this->student_model->get_studentdetails_byid($student_id); 
//                               $num=$studentArr['registration_number'];
//                               $type="Registration";
//                               $email=$studentArr['email'];
//                               $data=email_header();
//                               $data.='<tr style="background:#f2f2f2">
//                                         <td style="padding: 20px 0px">
//                                             <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi</h3>
//                                             <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Online payment approved you can pay fee using given login details,   <a href="'.base_url('login').'">click here to login</a>.<br/> Your username is '.$num.' and the password is '.$password.'.
//                                             </p>
//                                         </td>
//                                     </tr>';
//                                 $data.=email_footer();
//                             $this->send_email($type,$email,$data);
//             echo true;
//         } else {
//             echo false;
//         } 
//     }
    
// }    
    

public function online_pay_approve(){
    $student_id = $this->input->post('student_id');
    $online_payment_expiry=$this->common->get_name_by_id('am_config','value',array("key"=>"online_payment_expiry"));
    $instituteCourseMappingIdpayment = $this->input->post('instituteCourseMappingIdpayment');
    if($student_id != '' && $instituteCourseMappingIdpayment != '') { 
        $studentArr =   $this->student_model->get_studentdetails_byid($student_id); 
        $type="Payment Link";
        $studentname=$studentArr['name'];
        $email=$studentArr['email'];
        if($online_payment_expiry>0) {
            $insertArr['payment_expired'] = date("Y-m-d H:i:s", strtotime("+".$online_payment_expiry." hours"));
        } else {
            $insertArr['payment_expired'] = date("Y-m-d H:i:s", strtotime("+48 hours"));   
        }
        $insertArr['code'] = mt_rand(100000,999999);
        $insertArr['student_id'] = $student_id;
        $insertArr['institute_course_mapping_id'] = $instituteCourseMappingIdpayment;
        $isExist = $this->student_model->get_onlinepayment_approvalisExist($insertArr); 
        if(!$isExist){ 
            $this->student_model->remove_onlinepayment_approvalisExist($insertArr); 
        }
            $insertArr['status'] = 0;
            if($this->db->insert('pp_onlinepayment_approval', $insertArr)){
                $data=email_header();
                $encriptedCode = base64_encode( $insertArr['code'] );
                $data.='<tr style="background:#f2f2f2">
                        <td style="padding: 20px 0px">
                            <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$studentname.',</h3>
                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">
                            Online payment approved. You can pay fee using given link,
                                <a href="'.base_url('direction-online-payment/'.$encriptedCode).'">click here to pay</a>.<br/>
                            </p>
                        </td>
                    </tr>';
                $data.=email_footer();
                if($this->send_email($type,$email,$data)){
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $message = "Online payment approved for student ".$studentname;
                    logcreator('update','database',$who,'',$student_id,'am_student', $message);
                    echo 1;
                }else{
                    echo 1;
                }
            }else{
                echo 0;
            }
        // }else{
        //     echo 2;
        // }
    }else{
        echo 0;
    }
}
     /*
    *   function'll get batch by center course mapp
    *   @params center course mapp id
    *   @author GBS-R
    *
    */
    
        public function student_batch_allocationcheck(){
        $student_id         =   $this->input->post('student_id');
        $course             =   $this->input->post('selectedcourse');
        $branch             =   $this->input->post('branch');
        $center             =   $this->input->post('center');
        $batch              =   $this->input->post('batch');
        $existcheck = $this->common->check_batch_allocation_duplicate($student_id, $course); 
        if(!empty($existcheck)) {
            //if($existcheck->course_id==$course) {
               echo 2; 
            } else {
                echo 1;
            }
        // } else {
        //         echo 1;
        // }
        
//        $data               =   array('branch_id'=>$branch,
//                                        'center_id'=>$center,
//                                        'batch_id'=>$batch,
//                                        'status'=>1);
//        $where              =   array('student_id'=>$student_id,
//                                      'course_id'=>$course);
//        $this->db->where($where);
//        $query              =   $this->db->update('am_student_course_mapping', $data); 
//        if($query) {
////            $where   =   array('student_id'=>$student_id);
////            $this->db->where($where);
////            $this->db->update('am_students', array('status'=>1));
////            $where = array('student_id'=>$student_id,'batch_id'=>$batch);
////            $this->db->where($where);
////            $update = array('status'=>1);
////            $this->db->update('am_student_course_mapping', $update);
//            echo 1;
//        } else {
//            echo 0;
//        }
    }
    
    public function student_batch_allocation(){ 
        $student_id         =   $this->input->post('student_id');
        $course             =   $this->input->post('selectedcourse');
        $branch             =   $this->input->post('branch');
        $center             =   $this->input->post('center');
        $batch              =   $this->input->post('batch');
        $center_id          =   '';
        $batchdetails       = $this->common->get_batch_details($batch); 
        $registeredstudent  = $this->common->get_total_student($batch);
        $availableseats = $batchdetails['batch_capacity']-$registeredstudent;
        if($availableseats>0) {
        $insti_center_mapdata = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$center));
        if(!empty($insti_center_mapdata)) {
            $center_id = $insti_center_mapdata['institute_master_id'];
        }    
        $checkpayment = $this->common->get_paidinstallment($student_id, $center);
        if(!empty($checkpayment)) {
        $data               =   array('branch_id'=>$branch,
                                        'institute_course_mapping_id'=>$center,
                                        'center_id'=>$center_id,
                                        'batch_id'=>$batch
                                     );    
        } else {
        $data               =   array('branch_id'=>$branch,
                                        'institute_course_mapping_id'=>$center,
                                        'center_id'=>$center_id,
                                        'batch_id'=>$batch,
                                        'status'=>1
                                        //'status'=>2
                                     );    
        }
        $where              =   array('student_id'=>$student_id,
                                      'course_id'=>$course);
        $this->db->where($where);
        $query              =   $this->db->update('am_student_course_mapping', $data); 
        if($query) {
              $this->db->where('student_id', $student_id);
              $this->db->where('course_id!=', $course);
              $this->db->update('am_student_course_mapping', array('status'=>4));
              $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                $message = "Student batch reallocated";
                logcreator('update','database',$who,'',$student_id,'am_student', $message);
//            $where   =   array('student_id'=>$student_id);
//            $this->db->where($where);
//            $this->db->update('am_students', array('status'=>1));
//            $where = array('student_id'=>$student_id,'batch_id'=>$batch);
//            $this->db->where($where);
//            $update = array('status'=>1);
//            $this->db->update('am_student_course_mapping', $update);
            echo 1;
        } else {
            echo 0;
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $message = "Student batch reallocation failed";
            logcreator('update','database',$who,'',$student_id,'am_student', $message);
        }
        } else {
            echo 2;
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $message = "Student batch reallocation failed due to unavailability of seats";
            logcreator('update','database',$who,'',$student_id,'am_student', $message);
        }
    }
    
    /*
    *
    *
    *
    *
    */
    
    public function student_change_batch_allocation(){ 
        $student_id         =   $this->input->post('student_id');
        $course             =   $this->input->post('selectedcourse');
        $branch             =   $this->input->post('branch');
        $center             =   $this->input->post('center');
        $batch              =   $this->input->post('batch');
        $center_id          =   '';
        $insti_center_mapdata = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$center));
        if(!empty($insti_center_mapdata)) {
            $center_id = $insti_center_mapdata['institute_master_id'];
        } 

        $data               =   array('branch_id'=>$branch,
                                        'center_id'=>$center_id,
                                        'institute_course_mapping_id'=>$center,
                                        'batch_id'=>$batch,
                                        'student_id'=>$student_id,
                                        'course_id'=>$course,
                                        'status'=>1,
                                     );
        $batchdetails            = $this->common->get_batch_details($batch);
        $registeredstudent  = $this->common->get_total_student($batch);
        // $availableseats = $batchdetails['batch_capacity']-$registeredstudent;
        // if($availableseats>0) {
        $query              =   $this->db->insert('am_student_course_mapping', $data); 
        if($query) {
            //   $this->db->where('student_id', $student_id);
            //   $this->db->where('course_id!=', $course);
            //   $this->db->update('am_student_course_mapping', array('status'=>4));
              $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $message = "Student batch reallocated";
            logcreator('update','database',$who,'',$student_id,'am_student', $message);
            echo 1;
        } else {
            echo 0;
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $message = "Student batch reallocation failed";
            logcreator('update','database',$who,'',$student_id,'am_student', $message);
        }
        // } else {
        //     $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        //     $message = "Student batch reallocation failed due to unavailability of seats";
        //     logcreator('update','database',$who,'',$student_id,'am_student', $message);
        //     echo 2;
        // }
    }
    
    /*
    *   function'll will get batch fee
    *   @params batch_id student_id
    *   @author GBS-R
    
    // OLD FLOW  28-05-2019
	
    public function get_batchfee_view()
    {
        $student_id                         =   $this->input->post('student_id');
        $institute_center_map_id            =   $this->input->post('institute_center_map_id');
        $paidstatus         = array();
        $availableseats     = 0;
        $this->data['verification'] = 0;
        $batch_fee          = $this->student_model->get_batchfee_bystudent($student_id, $institute_center_map_id); //print_r($batch_fee);
        if(!empty($batch_fee) && $batch_fee->course_id!='')
        {
         $courseDet = $this->common->get_from_tablerow('am_classes', array('class_id'=>$batch_fee->course_id));
            if(!empty($courseDet) && $courseDet['basic_qualification']!='') {
                $qualiverification = $this->student_model->check_basic_qualification($student_id, $courseDet['basic_qualification']);
                if(!empty($qualiverification)) {
                  $this->data['verification'] = 1;   
                }
            } else {
                $verification       = $this->common->get_from_tableresult('am_student_documents', array('student_id'=>$student_id,'verification'=>1));
                if(!empty($verification)) {
                   $this->data['verification'] = 1; 
                }
            }
        }
        $months = 0;
        $this->data['transport'] = 0;
        $this->data['hostel']    = 0;
        if(!empty($batch_fee) && $batch_fee->batch_id!='')
        {  
            
            $batch_id               = $batch_fee->batch_id;
            $batchdetails           = $this->common->get_batch_details($batch_id); //echo '<pre>';print_r($batchdetails);
            $this->data['hostel']   = $this->common->get_hostelFee_byStudentId($student_id);
            $transport_fare         = $this->common->get_fare_by_student($student_id);
            if(!empty($batchdetails)) {
                $months = get_interval_in_month($batchdetails['batch_datefrom'], $batchdetails['batch_dateto']);
                $this->data['transport'] = $transport_fare*$months;
            }
            $course_totalfee = $batch_fee->course_totalfee;
            $course_id = $batch_fee->course_id;
            $institute_course_mapping_id = $batch_fee->institute_course_mapping_id;
            $registeredstudent = $this->common->get_total_student($batch_id);
            $availableseats = $batchdetails['batch_capacity'];
            $this->data['course_id'] =  $course_id;
            $this->data['student_id'] =  $student_id;
            $paidstatus = $this->common->get_paidstatus($student_id, $institute_course_mapping_id); 
            $discount = $this->common->get_from_tableresult('pp_student_discount', array('student_id'=>$student_id,'course_id'=>$course_id));
            $this->data['discnt'] = ''; 
            if(!empty($discount)) {
                $dicountper = 0;
                $dicntAmt   = 0;
                foreach($discount as $disnt) {
                    if($disnt->st_discount_type==2) {
                        $dicountper  =  $disnt->st_discount*$course_totalfee;
                        $dicntAmt    = $dicountper/100;
                    } else {
                        $dicntAmt    =  $disnt->st_discount;
                    }
                    $this->student_model->update_discount($dicntAmt,$disnt->st_discount_id);
                    if($disnt->discount_status==0) {
                      $this->data['discnt']   = 'Pending';  
                    }
                    
                }
            }
        
        if(!empty($batchdetails)) {
        $availableseats = $batchdetails['batch_capacity']-$registeredstudent;
        }
        if($availableseats>0) {
          $this->data['seats']   = 'available';
        } else {
          $this->data['seats']   = 'unavailable'; 
        } 
        if(!empty($paidstatus)) {
          $this->data['seats']   = 'available';  
        }
        }
        $this->data['batch_fee'] = $batch_fee;
		$view =  $this->load->view('admin/batch_feepayment_view',$this->data, TRUE);
        echo $view;
    }
	*/
	
	/*
    *   function'll will get batch fee
    *   @params batch_id student_id
    *   @author GBS-R
    */
    
    public function get_batchfee_view()
    {
        $student_id                         =   $this->input->post('student_id');
        $institute_center_map_id            =   $this->input->post('institute_center_map_id');
        // print_r($_POST);
		$this->data['config']				=	$this->home_model->get_config();
        $paidstatus         = array();
        $availableseats     = 0;
        $this->data['verification'] = 0;
        $batch_fee          = $this->student_model->get_batchfee_bystudent_id($student_id, $institute_center_map_id); 
        $this->data['batch_fee'] = $batch_fee;
        if(!empty($batch_fee) && $batch_fee->course_id!='' && $batch_fee->fee_definition_id!=''){
            $this->data['verification'] = 1; 
            $courseDet = $this->common->get_from_tablerow('am_classes', array('class_id'=>$batch_fee->course_id));
            if(!empty($courseDet) && $courseDet['basic_qualification']!='') {
                
                // Qaulification and document verification removed as per direction request;

                // $qualiverification = $this->student_model->check_basic_qualification($student_id, $courseDet['basic_qualification']);
                // if(!empty($qualiverification)) {
                //   $this->data['verification'] = 1;   
                // }
            } else {
                $this->data['verification'] = 1; 
                // Qaulification and document verification removed as per direction request;

                // $verification       = $this->common->get_from_tableresult('am_student_documents', array('student_id'=>$student_id,'verification'=>1));
                // if(!empty($verification)) {
                //    $this->data['verification'] = 1; 
                // }
            }
        }
        $months = 0;
        $this->data['transport'] = 0;
        $this->data['hostel']    = 0;
        if(!empty($batch_fee) && $batch_fee->batch_id!='') {  
            $batch_id               = $batch_fee->batch_id;
			$institute_course_mapping_id      = $batch_fee->institute_course_mapping_id;
			$this->data['feeheads']= $this->common->get_feedsmapping($institute_course_mapping_id); 
            $batchdetails           = $this->common->get_batch_details($batch_id); //echo '<pre>';print_r($batchdetails);
            $this->data['hostel']   = array();//$this->common->get_hostelFee_byStudentId($student_id);
            $transport_fare         = $this->common->get_fare_by_student($student_id);
            if(!empty($batchdetails)) {
                $months = get_interval_in_month($batchdetails['batch_datefrom'], $batchdetails['batch_dateto']);
                //$this->data['transport'] = $transport_fare*$months;
            }
            $course_totalfee = $batch_fee->course_totalfee;
            $course_id = $batch_fee->course_id;
            $institute_course_mapping_id = $batch_fee->institute_course_mapping_id;
            $registeredstudent = $this->common->get_total_student($batch_id);
            $availableseats = $batchdetails['batch_capacity'];
            $this->data['course_id'] =  $course_id;
            $this->data['student_id'] =  $student_id;
            $paidstatus = $this->common->get_paidstatus($student_id, $institute_course_mapping_id); 
            $discount = $this->common->get_from_tableresult('pp_student_discount', array('student_id'=>$student_id,'course_id'=>$course_id));
            $this->data['discnt'] = ''; 
            if(!empty($discount)) {
                $dicountper = 0;
                $dicntAmt   = 0;
                foreach($discount as $disnt) {
                    if($disnt->st_discount_type==2) {
                        $dicountper  =  $disnt->st_discount*$course_totalfee;
                        $dicntAmt    = $dicountper/100;
                    } else {
                        $dicntAmt    =  $disnt->st_discount;
                    }
                    $this->student_model->update_discount($dicntAmt,$disnt->st_discount_id);
                    if($disnt->discount_status==0) {
                      $this->data['discnt']   = 'Pending';  
                    }
                    
                }
            }
            if(!empty($batchdetails)) {
                $availableseats = $batchdetails['batch_capacity']-$registeredstudent;
            }
            if($availableseats>=0) {
                $this->data['seats']   = 'available';
            } else {
                $this->data['seats']   = 'unavailable'; 
            } 
            if(!empty($paidstatus)) {
                $this->data['seats']   = 'available';  
            }
        }
        $this->data['batch_fee'] = $batch_fee;
		$view =  $this->load->view('admin/batch_feepayment_view',$this->data, TRUE);
        echo $view;
    }
    
//    public function get_batchfee_view()
//    {
//        $student_id         =   $this->input->post('student_id');
//        $batch_id           =   $this->input->post('batch_id');
//        $this->data['batch_fee'] = $this->student_model->get_batchfee_bystudent($student_id, $batch_id); 
//		$view =  $this->load->view('admin/batch_feepayment_view',$this->data, TRUE);
//         echo $view;
//    }
//   
    
    
    /*
    *   function'll will update discount
    *   @params student_id
    *   @author GBS-R
    */
    
     public function student_discount($course_id = NULL)
    { 
        //echo $course_id;die();
        $student_id         =   $this->input->post('student_id');
        $discountArr        =   $this->input->post('discounts');
         if(empty($discountArr)) { $discountArr = array(); }
         //if(!empty($discountArr)) {
             $existArr = array();
             $disntcheck = $this->common->get_from_tableresult('pp_student_discount',array('student_id'=>$student_id,
                              'course_id'=>$course_id));
                 if(!empty($disntcheck)) {
                     foreach($disntcheck as $dis) {
                         array_push($existArr,$dis->package_id);
                     }
                 }
             if(!empty($existArr)) {
                 foreach($existArr as $dis) { 
                    if(!in_array($dis, $discountArr)) { 
                       $this->student_model->deletediscount($student_id, $course_id, $dis); 
                        $query = 1; 
                        $result['status']   = true;
                        $result['message']  = 'Discount removed for student!';
                        $result['data']     = ''; 
                    }
                 }
                 if($query==1) {
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $message = "Student discount removed";
                    logcreator('update','database',$who,'',$student_id,'am_student', $message);
                 }
             }
             foreach($discountArr as $discount) {
                 $package = $this->common->get_from_tablerow('am_discount_packages',array('package_id'=>$discount));
                 $data = array('student_id'=>$student_id,
                              'course_id'=>$course_id,
                               'package_id'=>$package['package_id'],
                               'st_discount_type'=>$package['package_type'],
                               'st_discount'=>$package['package_amount']
                              );
                 if (in_array($package['package_id'], $existArr)) {
                 $query = 1;    
                 } else {
                 $query = $this->db->insert('pp_student_discount',$data);
                 }
                 if($query) {
                    $result['status']   = true;
                    $result['message']  = 'Discount submitted for approval!';
                    $result['data']     = ''; 
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $message = "Student discount submitted for approval";
                    logcreator('update','database',$who,'',$student_id,'am_student', $message);
                 } else {
                    $result['status']   = false;
                    $result['message']  = 'Action failed please try again!';
                    $result['data']     = ''; 
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $message = "Student discount updation failed";
                    logcreator('update','database',$who,'',$student_id,'am_student', $message);
                 }
             }
//         } else {
//            $result['status']   = false;
//            $result['message']  = 'Discount package not selected!';
//            $result['data']     = '';
//         }
if(empty($discountArr) && empty($existArr)) {
    $result['status']   = false;
               $result['message']  = 'Discount package not selected!';
               $result['data']     = '';
}
         print_r(json_encode($result));
     }
    
    
    
    
    /*
    *   function'll will update payment
    *   @params batch_id student_id
    *   @author GBS-R
    */
    
     public function student_batch_payment()
    {   
        $student_id         =   $this->input->post('student_id');
        $batch_id           =   $this->input->post('batch_id');
        $hostel_fee         =   $this->input->post('hostelamt');
        $transport_fee      =   $this->input->post('transamt');
        $institute_course_mapping_id           =   $this->input->post('institute_course_mapping_id');
        $paid_amount        =   $this->input->post('paid_amount');
        $balance            =   0;
        $parent_payment_id  =   $this->input->post('parent_payment_id'); 
        $payment_id         =   $this->input->post('payment_id'); 
        $payment_type       =   $this->input->post('payment_type');
        $splitvalue       =   $this->input->post('splitvalue');
        $discount_applied   =   0;
        $checkfee_paid_amount    =   $this->input->post('fee_paid_amount');
         if($this->input->post('discount_amt')) { 
            $discount_applied       =   $this->input->post('discount_amt'); 
         }

        $cardholdername = '';
        $bankname = '';
        $checkpayment = $this->common->get_paidinstallment($student_id, $institute_course_mapping_id);
         if(!empty($checkpayment)) {
             if($checkpayment->balance<=0) {
               $result['status']   = false;
                $result['message']  = 'Fees already paid!';
                $result['data']     = '';
                print_r(json_encode($result));
                die();  
             }
         } 
        if($this->input->post('modeofpay')=='Card') {
           if($this->input->post('cardholdername')=='' || $this->input->post('bankname')=='') {
                $result['status']   = false;
                $result['message']  = 'Please enter card details!';
                $result['data']     = '';
                print_r(json_encode($result));
                die();
           } 
        } 

        
        if($this->input->post('modeofpay')=='Cheque') {
           if($this->input->post('accholdername')=='' || $this->input->post('bankaccount')=='' || $this->input->post('chequeno')=='') {
                $result['status']   = false;
                $result['message']  = 'Please enter cheque details!';
                $result['data']     = '';
                print_r(json_encode($result));
                die();
           } 
        }

        if($this->input->post('modeofpay')=='Online') {
            if($this->input->post('cardtype') == '' || $this->input->post('transactionid') == '') {
                 $result['status']   = false;
                 $result['message']  = 'Please enter online payment details!';
                 $result['data']     = '';
                 print_r(json_encode($result));
                 die();
            } 
         }
        
        if($splitvalue != 'split') {
        if($checkfee_paid_amount < $discount_applied) {
            $result['status']   = false;
            $result['message']  = 'Applied dicount is more than payable amount.';
            $result['data']     = '';
            print_r(json_encode($result));
            die();
        }
    } 
         //die('Ramesh');
        if($this->input->post('cardholdername')!='') {
            $cardholdername = $this->input->post('cardholdername');
        }
        if($this->input->post('accholdername')!='') {
            $cardholdername = $this->input->post('accholdername');
        }
         if($this->input->post('bankname')!='') {
             $bankname = $this->input->post('bankname');
            }
         if($this->input->post('bankaccount')!='') {
             $bankname = $this->input->post('bankaccount');
            }
        if(isset($_POST) && $student_id!='' && $batch_id!='') {
        if($splitvalue == 'split') {
            $splitamount = $this->input->post('splitamount');
            if($splitamount=='') {
                $result['status']   = false;
                $result['message']  = 'Please enter amount.';
                $result['data']     = '';
                print_r(json_encode($result));
                die();
            }
            if($payment_type == 'installment') {
                if($payment_id!='') {
                    $paidRow = $this->common->get_from_tablerow('pp_student_payment', array('payment_id'=>$payment_id)); 
                    $totlpaid =  $this->common->get_totalpaid_split($payment_id);
                    if($totlpaid>=$paidRow['payable_amount']) {
                        $result['status']   = false;
                        $result['message']  = 'Fee payment already completed.';
                        $result['data']     = '';
                        print_r(json_encode($result));
                        die();
                    }
                    if(!empty($paidRow)) {
                        $payablebalance = $this->input->post('payablebalance');
                    if($payablebalance=='') {
                        $payablebalance = $this->input->post('paid_amount');   
                    }
                    $splitamount = $this->input->post('splitamount');
                    $balance = $payablebalance-$splitamount;
                    $paidamt = $paidRow['paid_amount'];
                    $newpaidamt = $paidamt+$splitamount;
                    $data = array(
                          'payment_type'=>$splitvalue, 
                          'paid_amount'=>$newpaidamt,
                          'balance'=>$balance
                    );
                    $this->db->where('payment_id', $payment_id);
                    $query        =    $this->db->update('pp_student_payment', $data);
                    if($query) { 
                        $splitArr = array('payment_id'=>$payment_id,
                                          'paid_payment_mode'=>$this->input->post('modeofpay'),
                                          'split_amount'=>$splitamount,
                                          'split_balance'=>$balance,
                                          'card_holder_name'=>$cardholdername,
                                          'card_type'=>$this->input->post('cardtype'),
                                          'bank_name'=>$bankname,
                                          'cheque_no'=>$this->input->post('chequeno'),
                                          'transaction_id'=>$this->input->post('transactionid')
                                      );
                        $this->db->insert('pp_student_payment_split', $splitArr); 
                        $split_id = $this->db->insert_id();
                        $invoice_id = $this->common->invoice($query,'', $splitamount, $splitamount); 
                        $this->db->where('paid_split_id', $split_id);
                        $this->db->update('pp_student_payment_split', array('pt_invoice_id'=>$invoice_id));
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        $message = "Student payment done [Split payment]";
                        logcreator('insert','database',$who,'',$student_id,'am_student', $message); 
                    }
                    }
                } else {
                $splitamount = $this->input->post('splitamount');
                $balance = $this->input->post('payableamount')-$splitamount;
                $data = array('student_id'=>$student_id,
                          'batch_id'=>$batch_id,
                          'institute_course_mapping_id'=>$this->input->post('institute_course_mapping_id'),      
                          'payment_type'=>$splitvalue,
                           'total_amount'=>$this->input->post('payableamount')+$discount_applied,      
                          'payable_amount'=>$this->input->post('payableamount'),
                          'hostel_fee'=>0,
                          'transport_fee'=>0,
                          'discount_applied'=>$discount_applied,      
                          'paid_amount'=>$splitamount,
                          'balance'=>$balance,
                          'paymentmode'=>$this->input->post('modeofpay'),
                          'card_holder_name'=>$cardholdername,
                          'card_type'=>$this->input->post('cardtype'),
                          'bank_name'=>$bankname,
                          'transaction_id'=>$this->input->post('transactionid'), 
                          'cheque_no'=>$this->input->post('chequeno'),      
                          'status'=>1
                );
                $query        =    $this->student_model->update_student_fee($data);
                  if($query) {
                      $splitArr = array('payment_id'=>$query,
                                        'paid_payment_mode'=>$this->input->post('modeofpay'),
                                        'split_amount'=>$splitamount,
                                        'split_balance'=>$balance,
                                        'card_holder_name'=>$cardholdername,
                                        'card_type'=>$this->input->post('cardtype'),
                                        'bank_name'=>$bankname,
                                        'transaction_id'=>$this->input->post('transactionid'), 
                                        'cheque_no'=>$this->input->post('chequeno')
                                    ); 
                      $this->db->insert('pp_student_payment_split', $splitArr); 
                      $split_id = $this->db->insert_id();
                      $invoice_id = $this->common->invoice($query,'', $splitamount, $splitamount); 
                      $this->db->where('paid_split_id', $split_id);
                      $this->db->update('pp_student_payment_split', array('pt_invoice_id'=>$invoice_id));             
                      $this->loginapprovalprocess($student_id, $batch_id);
                      $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                      $message = "New student payment completed and admitted to batch [Split payment]";
                      logcreator('insert','database',$who,'',$student_id,'am_student', $message);
                  }
                }
                
                
            } else {
            if($payment_id!='') {
                $paidRow = $this->common->get_from_tablerow('pp_student_payment', array('payment_id'=>$payment_id));
                $totlpaid =  $this->common->get_totalpaid_split($payment_id);
                if($totlpaid>=$paidRow['payable_amount']) {
                    $result['status']   = false;
                    $result['message']  = 'Fee payment already completed.';
                    $result['data']     = '';
                    print_r(json_encode($result));
                    die();
                }
                if(!empty($paidRow)) {
                $payablebalance = $this->input->post('payablebalance');
                $splitamount = $this->input->post('splitamount');
                $balance = $payablebalance-$splitamount;
                $paidamt = $paidRow['paid_amount'];
                $newpaidamt = $paidamt+$splitamount;
                $data = array(  
                      'paid_amount'=>$newpaidamt,
                      'balance'=>$balance
                );
                $this->db->where('payment_id', $payment_id);
                $query        =    $this->db->update('pp_student_payment', $data);
                if($query) {
                    $splitArr = array('payment_id'=>$payment_id,
                                      'paid_payment_mode'=>$this->input->post('modeofpay'),
                                      'split_amount'=>$splitamount,
                                      'split_balance'=>$balance,
                                      'card_holder_name'=>$cardholdername,
                                      'card_type'=>$this->input->post('cardtype'),
                                      'bank_name'=>$bankname,
                                      'cheque_no'=>$this->input->post('chequeno'),
                                      'transaction_id'=>$this->input->post('transactionid')
                                  );
                    $this->db->insert('pp_student_payment_split', $splitArr); 
                    $split_id = $this->db->insert_id();
                    $invoice_id = $this->common->invoice($query,'', $splitamount, $splitamount); 
                    $this->db->where('paid_split_id', $split_id);
                    $this->db->update('pp_student_payment_split', array('pt_invoice_id'=>$invoice_id)); 
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $message = "Student payment done [Split payment]";
                    logcreator('insert','database',$who,'',$student_id,'am_student', $message);
                }
                }
            } else {
            $splitamount = $this->input->post('splitamount');
            $balance = $this->input->post('payableamount')-$splitamount;
            $data = array('student_id'=>$student_id,
                      'batch_id'=>$batch_id,
                      'institute_course_mapping_id'=>$this->input->post('institute_course_mapping_id'),      
                      'payment_type'=>$splitvalue,
                       'total_amount'=>$this->input->post('payableamount')+$discount_applied,      
                      'payable_amount'=>$this->input->post('payableamount'),
                      'hostel_fee'=>0,
                      'transport_fee'=>0,
                       'discount_applied'=>$discount_applied,      
                      'paid_amount'=>$splitamount,
                      'balance'=>$balance,
                      'paymentmode'=>$this->input->post('modeofpay'),
                      'card_holder_name'=>$cardholdername,
                      'card_type'=>$this->input->post('cardtype'),
                      'bank_name'=>$bankname,
                      'cheque_no'=>$this->input->post('chequeno'),      
                      'transaction_id'=>$this->input->post('transactionid'),      
                      'status'=>1
            );
            $query        =    $this->student_model->update_student_fee($data);
              if($query) {
                  $splitArr = array('payment_id'=>$query,
                                    'paid_payment_mode'=>$this->input->post('modeofpay'),
                                    'split_amount'=>$splitamount,
                                    'split_balance'=>$balance,
                                    'card_holder_name'=>$cardholdername,
                                    'card_type'=>$this->input->post('cardtype'),
                                    'bank_name'=>$bankname,
                                    'cheque_no'=>$this->input->post('chequeno'),
                                    'transaction_id'=>$this->input->post('transactionid')
                                );
                  $this->db->insert('pp_student_payment_split', $splitArr); 
                  $split_id = $this->db->insert_id();
                  $invoice_id = $this->common->invoice($query,'', $splitamount, $splitamount); 
                  $this->db->where('paid_split_id', $split_id);
                  $this->db->update('pp_student_payment_split', array('pt_invoice_id'=>$invoice_id));             
                  $this->loginapprovalprocess($student_id, $batch_id);
                  $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                  $message = "New student payment completed and admitted to batch [Split payment]";
                  logcreator('insert','database',$who,'',$student_id,'am_student', $message);
              }
            }
        }
        } else { 

        if($payment_type == 'installment'){ //echo '<pre>';
            $fee_paid_amount    = $this->input->post('fee_paid_amount');
            $installment        = $this->input->post('installment'); //print_r($installment);
            $installment_amt    = $this->input->post('installment_amt');//print_r($installment_amt);
            $installment_id     = $this->input->post('installment_id');
            $payable_amt        = $this->input->post('payable_amt');
            $paid_amount        =   $this->input->post('paid_amount');
			$payinginstall0     = $this->input->post('payinginstall0');							   
            $payment_id       =   $this->input->post('payment_id');
            $balance = $this->input->post('payableamount')-$paid_amount;
            if($payment_id != '') {
            $data = array(
                      'paid_amount'=>$paid_amount,
                      'balance'=>$balance,
                      'discount_applied'=>$discount_applied, 
                      'paymentmode'=>$this->input->post('modeofpay')
                     );
            $query        =    $this->student_model->update_student_feeinstallment($data, $payment_id); 
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $message = "Student payment done [Installment]";
            logcreator('insert','database',$who,'',$student_id,'am_student', $message);   
            } else {
            $data = array('student_id'=>$student_id,
                      'batch_id'=>$batch_id,
                      'institute_course_mapping_id'=>$this->input->post('institute_course_mapping_id'),      
                      'payment_type'=>$this->input->post('payment_type'),
                       'total_amount'=>$this->input->post('payableamount')+$discount_applied,      
                      'payable_amount'=>$this->input->post('payableamount'),
                      'hostel_fee'=>$hostel_fee,
                      'transport_fee'=>$transport_fee,
                       'discount_applied'=>$discount_applied,      
                      'paid_amount'=>$paid_amount,
                      'balance'=>$balance,
                      'paymentmode'=>$this->input->post('modeofpay'),
                      'card_holder_name'=>$cardholdername,
                      'card_type'=>$this->input->post('cardtype'),
                      'bank_name'=>$bankname,
                      'cheque_no'=>$this->input->post('chequeno'),   
                      'transaction_id'=>$this->input->post('transactionid'),    
                      'status'=>1
                     );
            $query        =    $this->student_model->update_student_fee($data);
              if($query) {
                  $this->loginapprovalprocess($student_id, $batch_id);
                  $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                  $message = "New student payment completed and admitted to batch [Installment]";
                  logcreator('insert','database',$who,'',$student_id,'am_student', $message);
              }
            }
            $paidamt = 0;   
            $disntloop = 0;
            $balaceinstall = 0;
            $lastid = '';
            $installwithoutgst = 0;
        foreach($installment as $key=>$val) {
            $paidamt += $installment_amt[$key];
            $paidAmtwithdicnt = $paid_amount;
            //$paidAmtwithdicnt = $fee_paid_amount; chamged 06-11-2019//$installment_amt[$key];
            if($discount_applied>0 && $disntloop==0) {
            $fee_paid_amount = $installment_amt[$key]-$discount_applied;
            }
			if(count($installment)==1) {
				$paidAmtwithdicnt 	= $paid_amount;
				$balaceinstall 		= $fee_paid_amount-$paid_amount;
			}
            $install = array('paid_payment_mode'=>$this->input->post('modeofpay'),
                             'installment'=>$val,
                             'installment_paid_amount'=>$paidAmtwithdicnt,
                             'installment_amount'=>$installment_amt[$key],
							 'installment_amount_withtax'=>$fee_paid_amount,
							 'installment_amount_balance'=>$balaceinstall,
                              'card_holder_name'=>$cardholdername,
                              'card_type'=>$this->input->post('cardtype'),
                              'bank_name'=>$bankname,
                              'cheque_no'=>$this->input->post('chequeno'),   
                              'transaction_id'=>$this->input->post('transactionid'), 
                             'payment_id'=>$query
                            ); 
            $this->db->insert('pp_student_payment_installment',$install);
            $lastid .= $val.'-';
            $installwithoutgst += $installment_amt[$key];
            $discount_applied = 0;
            $disntloop++;
        }   
        if($query) {
            $this->common->invoice($query, $lastid, $fee_paid_amount, $installwithoutgst);
        }
        } else if($payment_type == 'onetime'){
        $fee_amount_without_gst     = 0;    
        $fee_amount_without_gst     = $this->input->post('fee_amount_without_gst');    
        $fee_paid_amount    = $this->input->post('fee_paid_amount');    
        if($paid_amount!='') {
            $balance = $this->input->post('payableamount')-$paid_amount;
        } else {
        $paid_amount        =   $this->input->post('payableamount');   
        } 
        if($payment_id!='') {
        $paid_amount        =   $this->input->post('paid_amount');    
        if($paid_amount!='') {
            $balance = $this->input->post('payableamount')-($paid_amount+$this->input->post('amtpaid'));
        } else {
            $paid_amount        =   $this->input->post('payablebalance');   
        }   //amtpaid
            
        $data = array('parent_payment_id'=>$parent_payment_id,
                      'student_id'=>$student_id,
                      'batch_id'=>$batch_id,
                      'institute_course_mapping_id'=>$this->input->post('institute_course_mapping_id'),
                      'payment_type'=>$this->input->post('payment_type'),
                      'payable_amt_without_gst'=>$fee_amount_without_gst,
                      'total_amount'=>$fee_paid_amount,
                      'payable_amount'=>$this->input->post('payableamount'),
                      'hostel_fee'=>$hostel_fee,
                      'transport_fee'=>$transport_fee,
                      'discount_applied'=>$discount_applied,
                      'paid_amount'=>$paid_amount,
                      'balance'=>$balance,
                      'paymentmode'=>$this->input->post('modeofpay'),
                      'card_holder_name'=>$cardholdername,
                      'card_type'=>$this->input->post('cardtype'),
                      'bank_name'=>$bankname,
                      'cheque_no'=>$this->input->post('chequeno'),  
                      'transaction_id'=>$this->input->post('transactionid'), 
                      'status'=>1
                     ); 
            $query        =    $this->student_model->update_student_fee($data); 
            if($query) {
                $this->common->invoice($query,'',$paid_amount,$fee_amount_without_gst);
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                $message = "Student payment done [Onetime]";
                logcreator('insert','database',$who,'',$student_id,'am_student', $message);
            }
        } else {   
        $data = array('student_id'=>$student_id,
                      'batch_id'=>$batch_id,
                      'institute_course_mapping_id'=>$this->input->post('institute_course_mapping_id'),
                      'payment_type'=>$this->input->post('payment_type'),
                      'payable_amt_without_gst'=>$fee_amount_without_gst,
                      'total_amount'=>$fee_paid_amount,
                      'payable_amount'=>$this->input->post('payableamount'),
                      'hostel_fee'=>$hostel_fee,
                      'transport_fee'=>$transport_fee,
                      'discount_applied'=>$discount_applied,
                      'paid_amount'=>$paid_amount,
                      'balance'=>$balance,
                      'paymentmode'=>$this->input->post('modeofpay'),
                      'card_holder_name'=>$cardholdername,
                      'card_type'=>$this->input->post('cardtype'),
                      'bank_name'=>$bankname,
                      'cheque_no'=>$this->input->post('chequeno'),  
                      'transaction_id'=>$this->input->post('transactionid'), 
                      'status'=>1
                     );
            $query        =    $this->student_model->update_student_fee($data); 
            if($query) {
                  $this->common->invoice($query,'',$paid_amount,$fee_amount_without_gst);  
                  $this->loginapprovalprocess($student_id, $batch_id);
                  $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                  $message = "New student payment completed and admitted to batch [Onetime]";
                  logcreator('insert','database',$who,'',$student_id,'am_student', $message);
              }
        }
        
        } 
    }
        if($query) {
            $result['status']   = true;
            $result['message']  = 'Payment successfully updated!';
            $result['data']     = $data;
        } else {
            $result['status']   = false;
            $result['message']  = 'Payment failed please try again!';
            $result['data']     = $data;
        }
        } else {
            $result['status']   = false;
            $result['message']  = 'Payment failed please try again!';
            $result['data']     = '';
        }
		print_r(json_encode($result));
    }
    
    /*
    *   function'll update all status for student login 
    *   @params post array
    *   @author GBS-R
    */
    public function loginapprovalprocess($student_id, $batch_id) {
           //am_user table update
            $student            = $this->user_model->get_student_data_by_id($student_id); 
            $password           = mt_rand(100000,999999);
            $encrypted_password = $this->Auth_model->get_hash($password);
            $dataArr            = array(
            //'user_username'=>$student->registration_number,
            //'user_name'=>$student->name,
            // "registration_number"=>$student->registration_number,
            //'user_emailid'=>$student->email,
            'user_role'=>'student',
            'user_status'=>1,
            //'user_phone'=>$student->contact_number,
            'user_passwordhash'=>$encrypted_password
           );
            if($student->caller_id!='') {
                $this->db->where('call_id',$student->caller_id);
                $this->db->update('cc_call_center_enquiries',array('call_status'=>6));  
            }
            $this->db->where('user_username',$student->registration_number);
            $this->db->where('user_primary_id',$student_id);
            $this->db->update('am_users',$dataArr);
            // am_student_course_mapping table update
            $where = array('student_id'=>$student_id,'batch_id'=>$batch_id);
            $this->db->where($where);
            $this->db->where('status!=', 4);
            $update = array('status'=>1);
            $this->db->update('am_student_course_mapping', $update);
            // am_student table update
            $where = array('student_id'=>$student_id);
            $this->db->where($where);
            $update = array('status'=>1,'admitted_date'=>date('Y-m-d'));
            $query = $this->db->update('am_students', $update);
            
            // Hostel allocation
            $where = array('student_id'=>$student_id);
            $this->db->where($where);
            $update = array('status'=>'alloted');
            $hostel = $this->db->update('hl_room_booking', $update);
        
            if($query)
            {
            $this->gm_user_registration($student->registration_number, $password, $student_id);
            // $num=$this->data['userid'];
            // $num=$student;
            // $type="Registration";
            // $email=$this->session->userdata('email');
            // $data=email_header();

              

            $username= $student->registration_number;
            $name= $student->name;
            // $num= $this->data['userid'];
            $type=" Registration";
            $email=$student->email;
            $data = email_header();
            $data.='<tr style="background:#f2f2f2">
                    <td style="padding: 20px 0px">
                        <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$name.'</h3>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The admission process is completed. Now you can login to our website application using following credential.</p>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$username.'</p>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>
                        <br><a href="'.base_url('login').'">Click here to login</a> and view your Course details and schedule details
                        </p>
                    </td>
                </tr>';
            $data.=email_footer();
            // <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The admission process is completed. Know you can login to our website application using following credential. <p>Your username is <b>'.$username.'</b> and the password is<b>'.$password.'</b></p>

            $this->send_email($type,$email,$data);

           // NOTIFY BATCH FULL    
           $batchnotify = $this->common->get_batch_allocation($batch_id);
           if($batchnotify['status']!=0) {
               $this->sendbatchnotification($batchnotify);
           }    
           // ENDS       

            }
    }
    
    
    public function admittapprovalprocess($student_id) {
        //am_user table update
         $student            = $this->user_model->get_student_data_by_id($student_id); 
         $password           = mt_rand(100000,999999);
         $encrypted_password = $this->Auth_model->get_hash($password);
         $dataArr            = array(
         'user_role'=>'student',
         'user_status'=>1,
         'user_passwordhash'=>$encrypted_password
        );
         
         $this->db->where('user_username',$student->registration_number);
         $this->db->where('user_primary_id',$student_id);
         $this->db->update('am_users',$dataArr);
         // am_student_course_mapping table update
        //  $where = array('student_id'=>$student_id,'batch_id'=>$batch_id);
        //  $this->db->where($where);
        //  $this->db->where('status!=', 4);
        //  $update = array('status'=>1);
        //  $this->db->update('am_student_course_mapping', $update);
         // am_student table update
         $where = array('student_id'=>$student_id);
         $this->db->where($where);
         $update = array('status'=>1,'admitted_date'=>date('Y-m-d'));
         $query = $this->db->update('am_students', $update);
         
         // Hostel allocation
        //  $where = array('student_id'=>$student_id);
        //  $this->db->where($where);
        //  $update = array('status'=>'alloted');
        //  $hostel = $this->db->update('hl_room_booking', $update);
         if($query)
         { 
         $username= $student->registration_number;
         $name= $student->name;
         // $num= $this->data['userid'];
         $type=" Registration";
         $email=$student->email;
         $data = email_header();
         $data.='<tr style="background:#f2f2f2">
                 <td style="padding: 20px 0px">
                     <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$name.'</h3>
                     <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">The admission process is completed. Now you can login to our website application using following credential.</p>
                     <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$username.'</p>
                     <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>
                     <br><a href="'.base_url('login').'">Click here to login</a> and view your Course details and schedule details
                     </p>
                 </td>
             </tr>';
         $data.=email_footer();
         $this->send_email($type,$email,$data);

        // NOTIFY BATCH FULL    
        //$batchnotify = $this->common->get_batch_allocation($batch_id);
       // if($batchnotify['status']!=0) {
            //$this->sendbatchnotification($batchnotify);
        //}    
        // ENDS       

         }
 }
 
 
    /*
    *   function'll get installment collection
    *   @params post array
    *   @author GBS-R
    */
    
    public function get_batchfee_installment() {
        $installment        = $this->input->post('installment'); //print_r($installment);
        $installment_amt    = $this->input->post('installment_amt'); //print_r($installment_amt);
        $spaidamt = 0;
        if(!empty($installment_amt)) { //print_r($installment);
            foreach($installment_amt as $key=>$val) {
                $spaidamt += $installment_amt[$key];
            }
        }
        if($spaidamt<=0) {
            $html =  '<div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <table class="table table_register table_register_fee table-bordered table-striped">
                                <tr><td class="error">Amount should be greater than 0.</td></tr>    
                            <table>
                        </div>
                    </div>';
                echo $html;
                exit();
        }
        $installment_id     = $this->input->post('installment_id');
        $payable_amt        = $this->input->post('payable_amt');
        $discountapply      = $this->input->post('discountapply');
        $discountAmt        = $this->input->post('discountAmt');
        $otherfee        = $this->input->post('otherfee');
        $hostelfee        = $this->input->post('hostelamt');
        $transfee        = $this->input->post('transamt');
		$institute_course_mapping_id        = $this->input->post('institute_course_mapping_id');
		$centerCourse = $this->common->get_from_tablerow('am_institute_course_mapping', array('institute_course_mapping_id'=>$institute_course_mapping_id));
		if(!empty($centerCourse)) {
			$config['SGST'] = $centerCourse['sgst'];
            $config['CGST']	= $centerCourse['cgst']; 
            if($centerCourse['cess']>0){
            $config['cess']	= 1;    
            $config['cess_value']	= $centerCourse['cess'];
            } else {
            $config['cess']	= 0;    
            $config['cess_value']	= 0;    
            }
		} 
        $paidamt     = 0;
        $html =  '<div class="row"><div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <table class="table table_register table_register_fee table-bordered table-striped">
                    <tbody>';
        
		$selectedInstals = 0;	
        if(!empty($installment)) { //print_r($installment);
        foreach($installment as $key=>$val) {
            //$paidamt += $installment_amt[$val-1];
			$paidamt += $installment_amt[$key];
           $html .= '<tr>
                            <td width="40%">Installment '.$val.'</td><input type="hidden" name="payinginstall'.$selectedInstals.'" value="'.$installment_amt[$key].'"/>
                            <td class="text-right"><label>'.numberformat($installment_amt[$key]).'</label></td>
                        </tr>'; 
		$selectedInstals++;	
        }
//$balance = $payable_amt-$paidamt;
//        $data = array('student_id'=>$this->input->post('student_id'),
//                            'batch_id'=>$this->input->post('batch_id'),
//                         'payment_type'=>$this->input->post('payment_type'),
//                         'payable_amount'=>,
//                         'paid_amount'=>$paidamt,
//                         'balance'=>$balance,
//                         'paymentmode'=>,);
        
    
                       
                 
            if($discountapply==1) {
				//$config				=	$this->home_model->get_config(); print_r($config);
				$taxableAmt 		= 	taxcalculation($paidamt, $config, 0); //print_r($taxableAmt);
				$payableAmt			=	$taxableAmt['totalAmt'];
                $payableAmt 		=   $payableAmt-$discountAmt;
                if(count($installment)>1) {
                     $html .= '<tr>
                            <td>Total</td>
                            <td class="text-right"><label>'.numberformat($paidamt).'</label></td>
                        </tr>';
                        }
                if($otherfee==1) {
                    if($hostelfee>0) {
                        $payableAmt += $hostelfee;
                    $html .= '<tr>
                            <td>Hostel Fee</td>
                            <td class="text-right"><label>'.numberformat($hostelfee).'</label><input type="hidden" name="hostelamt" value="'.$hostelfee.'"/></td>
                        </tr>';
                    }

                    if($transfee>0) {
                        $payableAmt += $transfee;
                     $html .= '<tr>
                            <td>Transport Fee</td>
                            <td class="text-right"><label>'.numberformat($transfee).'</label><input type="hidden" name="transamt" value="'.$transfee.'"/></td>
                        </tr>';
                    }
                }
                $html .= '<tr>
                            <td>Discount</td>
                            <td class="text-right"><label>'.numberformat($discountAmt).'</label></td>
                        </tr>';
               $html .= '<input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount_amt" />
			   			<tr>
                            <td>CGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['cgst']).'</label></td>
                        </tr>
						<tr>
                            <td>SGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['sgst']).'</label></td>
                        </tr>';	
                if($centerCourse['cess']>0) {
                    $html .= '<input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount_amt" />
                <tr>
                     <td>Cess ['.$centerCourse['cess'].'%]</td>
                     <td class="text-right"><label>'.numberformat($taxableAmt['cess']).'</label></td>
                 </tr>';   
                }        
                $html .= '<tr>
                            <td>Payable Amount[incl:GST]</td>
                            <td class="text-right"><label>'.numberformat($payableAmt).'</label></td>
                        </tr><input type="hidden" class="form-control" value="'.$paidamt.'" name="fee_paid_amount" /><input type="hidden" class="form-control" value="'.$payableAmt.'" name="paid_amount" />'; 
                  } else {
					if($selectedInstals>1) {
						$buttondefault = 'btn-default';
					} else {
						$buttondefault = 'btn-info changeAmt';
					}
					//$config				=	$this->home_model->get_config(); print_r($config);
					$taxableAmt 		= 	taxcalculation($paidamt, $config, 0); //print_r($taxableAmt);
				$payableAmt = $taxableAmt['totalAmt'];
				if($otherfee==1) {
                    if($hostelfee>0) {
                        $payableAmt += $hostelfee;
                    $html .= '<tr>
                            <td>Hostel Fee</td>
                            <td class="text-right"><label>'.numberformat($hostelfee).'</label><input type="hidden" name="hostelamt" value="'.$hostelfee.'"/></td>
                        </tr>';
                    }

                    if($transfee>0) {
                        $payableAmt += $transfee;
                     $html .= '<tr>
                            <td>Transport Fee</td>
                            <td class="text-right"><label>'.numberformat($transfee).'</label><input type="hidden" name="transamt" value="'.$transfee.'"/></td>
                        </tr>';
                    }
                }
					$html .= '<tr>
                            <td>CGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['cgst']).'</label></td>
                        </tr>';
				$html .= '<tr>
                            <td>SGST</td>
                            <td class="text-right"><label>'.numberformat($taxableAmt['sgst']).'</label></td>
                        </tr>';
                if($centerCourse['cess']>0) {
                            $html .= '<input type="hidden" class="form-control" value="'.$discountAmt.'" name="discount_amt" />
                        <tr>
                             <td>Cess ['.$centerCourse['cess'].'%]</td>
                             <td class="text-right"><label>'.numberformat($taxableAmt['cess']).'</label></td>
                         </tr>';   
                }
                $html .= '<tr>
                <td>Payable Amount</td>
                <td class="text-right">
                <div class="input-group mb-3">
                  <input type="text" readonly="readonly" class="form-control" value="'.$payableAmt.'" name="paid_amount" id="payableamtchge"/>
                 
                </div><label></label></td>
            </tr><input type="hidden" class="form-control" value="'.$payableAmt.'" name="fee_paid_amount" id="fee_paid_amount_hidden"/>';
                    /*$html .= '<tr>
                            <td>Payable Amount</td>
                            <td class="text-right">
							<div class="input-group mb-3">
							  <input type="text" readonly="readonly" class="form-control" value="'.$payableAmt.'" name="paid_amount" id="payableamtchge"/>
							  <div class="input-group-append">
								<button class="btn '.$buttondefault.' " type="button"><i class="fa fa-pencil"></i></button> 
							  </div>
							</div><label></label></td>
                        </tr><input type="hidden" class="form-control" value="'.$payableAmt.'" name="fee_paid_amount" id="fee_paid_amount_hidden"/>'; */
                    } 
                        $html .= '<tr><input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />
                            <td>Payment Mode </td>
                            <td><select class="form-control modeofpayinstall" name="modeofpay">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Online">Online</option>
                          </select></td>
                        </tr>
                        <tr class="cardclass" style="display:none;">
                            <td>Card Type</td>
                            <td><select class="form-control" name="cardtype" id="cardclassid" disabled>
                            <option value="Visa">Visa</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="Maestro">Maestro</option>
                            <option value="Discover">Discover</option>
                            <option value="American Express">American Express</option>
                          </select></td>
                        </tr>
                        <tr class="cardclass" style="display:none;">
                            <td>Card Holder Name<span class="req redbold">*</span></td>
                            <td><input type="text" class="form-control" value="" name="cardholdername" onkeypress="return valNames(event);"/></td>
                        </tr>
                        <tr class="cardclass" style="display:none;">
                            <td>Bank Name<span class="req redbold">*</span></td>
                            <td><input type="text" class="form-control" value="" name="bankname" onkeypress="return valNames(event);"/></td>
                        </tr>
                        <tr class="onlineclass" style="display:none;">
                            <td>Transaction Type <span class="req redbold">*</span></td>
                            <td><select class="form-control" name="cardtype" id="transactiontypeid" disabled><option value="">Select</option>';
                            $transTypearr = $this->common->get_basic_entity('Online Transaction');
                            foreach($transTypearr as $row){
                                $html .= '<option value="'.$row->entity_name.'">'.$row->entity_name.'</option>';
                            }
                                    
                            $html .= '</select>
                            </td>
                        </tr>
                        <tr class="onlineclass" style="display:none;">
                            <td>Transaction Id <span class="req redbold">*</span></td>
                            <td><input type="text" class="form-control" value="" name="transactionid" onkeypress="return blockSpecialChar(event);"/></td>
                        </tr>
                        <tr class="chequeclass" style="display:none;">
                            <td>Bank name<span class="req redbold">*</span></td>
                            <td><input type="text" class="form-control" name="bankaccount" onkeypress="return valNames(event);"/></td>
                        </tr>
                        <tr class="chequeclass" style="display:none;">
                            <td>Account Holder Name<span class="req redbold">*</span></td>
                            <td><input type="text" class="form-control" value="" name="accholdername" onkeypress="return valNames(event);"/></td>
                        </tr>
                        <tr class="chequeclass" style="display:none;">
                            <td>Cheque No<span class="req redbold">*</span></td>
                            <td><input type="text" class="form-control numbersOnly" value="" name="chequeno" maxlength="6" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="form-check-inline mt-3">
                            <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input splictclassinstall" name="splitvalue" checked="checked" value="onetime">Pay Installment
                                    </label>
                                </div>
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input splictclassinstall" name="splitvalue" value="split">Pay Split Amount 
                                </label>
                                </div></td>
                        </tr>
                        <tr id="installsplit" style="display:none;">
                            <td>Split Amount</td>
                            <td><input type="text" class="form-control  splitpayinstall" status="'.$payableAmt.'" name="splitamount" id="splitpayinstall" onkeypress="return isNumberKey(this, event);"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="btn btn-info btn_save paynow" id="paynowbutton">Paynow</button></td>
                        </tr>';
        } else {
           $html .= 'No installment selected!'; 
        }        
        $html .= '</tbody>
                    </table>
                        </div></div><script>
                        $(".modeofpayinstall").change(function(){ 
                            var mode = $(this).val(); 
                            if(mode=="Card") {
                                $(".cardclass").show();
                                $(".chequeclass").hide();
                                $(".onlineclass").hide();
                                $("#cardclassid").prop("disabled", false);
                                $("#transactiontypeid").prop("disabled", true);
                            } else if(mode=="Cheque") {
                                $(".cardclass").hide();
                                $(".onlineclass").hide();
                                $(".chequeclass").show();
                                $("#cardclassid").prop("disabled", true);
                                $("#transactiontypeid").prop("disabled", true);
                            }else if(mode=="Online") {
                                $(".cardclass").hide();
                                $(".chequeclass").hide();
                                $(".onlineclass").show();
                                $("#cardclassid").prop("disabled", true);
                                $("#transactiontypeid").prop("disabled", false);
                            } else {
                                $(".cardclass").hide();
                                $(".chequeclass").hide();
                                $(".onlineclass").hide();
                                $("#cardclassid").prop("disabled", true);
                                $("#transactiontypeid").prop("disabled", true);
                            }
                        });     
                        $(".txtOnly").keypress(function (e) {
			var regex = new RegExp("^[a-zA-Z]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
			else
			{
			e.preventDefault();
			return false;
			}
		}); 
        $(".numbersOnly").keyup(function () { 
    if (this.value != this.value.replace(/[^0-9]/g, "")) {
       this.value = this.value.replace(/[^0-9]/g, "");
    }
}); 

$(".changeAmt").click(function () {
	$("#payableamtchge").prop("readonly", false);
}); 

$("#payableamtchge").blur(function() {
  		//$("#fee_paid_amount_hidden").val($("#payableamtchge").val());
		
    });
    
    $(".splictclassinstall").click(function() {
        val = $(this).val();
        if(val=="split") {
            $("#installsplit").show();
        } else {
            $("#installsplit").hide();
        }
    }); 

    $(".splitpayinstall").keyup(function () { 
        var amt = $(this).val();
        var value = $(this).attr("status"); 
        if(parseInt(amt) > parseInt(value)) {
            $(this).val(value);
        }
    }); 
                    </script>';
        
        
        echo $html;
    }
    

    /*get query details by id*/
    public function get_studentview_by_id($id)
    {
       $stud_details=$this->student_model->get_studentview_by_id($id);
        return print_r(json_encode($stud_details));
    }
    
    function send_email($type, $email, $data) {
        // //print_r($data);
        // $config = Array(
        //               'protocol' => 'smtp',
        //               'smtp_host' => 'ssl://smtp.googlemail.com',
        //               'smtp_port' => 465,
        //               'smtp_user' => 'nileshtest11111@gmail.com', // change it to yours
        //               'smtp_pass' => 'gbsgbsgbsgbs#', // change it to yours
        //               'mailtype' => 'html',
        //               'charset' => 'iso-8859-1',
        //               'wordwrap' => TRUE
        //             );
        //   $this->load->library('email', $config);
        //   $this->email->set_newline("\r\n");
        //   $this->email->from('nileshtest11111@gmail.com'); // change it to yours

        $this->email->to($email);
        $this->email->subject($type);
        $this->email->message($data);
        $this->email->send();
        /*if($this->email->send()){
            echo 'Email sent.';
        }*/
     }
    public function check_number()
    {
        if($_POST){
                $number=$this->input->post('contact_num');
                $query=$this->db->select('*')
                ->from('cc_call_center_enquiries')
                ->or_like('primary_mobile', $number)
                ->or_like('father_mobile', $number)
                ->or_like('mother_mobile', $number)
                ->get();
                 $resultArr	=	array();
                 if($query->num_rows() > 0)
                 {
                                  $resultArr=$query->row_array();
                          //loading cities under the state
                             $DistrictArr=$this->common->get_district_bystate($resultArr['state']);
                                $html= '<option value="">Select City</option>';
                                foreach($DistrictArr as $row)
                                {
                                   $html.= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                }
                                $resultArr['cities']=$html;
                             //loading branches under the course
                              $courses = $this->register_model->get_branchby_courseid($resultArr['course_id']); 
                                    $options= '<option value="">Select </option>';
                                     if(!empty($courses)) {
                                            foreach($courses as $course) {
                                                $options .= '<option value="'.$course->institute_course_mapping_id.'">'.$course->institute_name.'</option>';
                                            }
                                         $resultArr['branches']=$options;
                                        }
                             //loading batches under the branch
                              $batches = $this->register_model->get_batch_by_insticourse_id($resultArr['branch_id']); 
                                    $optionsb= '<option value="">Select </option>';
                                     if(!empty($batches)) {
                                            foreach($batches as $batch) {
                                               $optionsb .= '<option value="'.$batch->batch_id.'">'.$batch->batch_name.'</option>';
                                            }
                                         $resultArr['batches']=$optionsb;
                                        } 
                      
                 }
                print_r(json_encode($resultArr));
           }

    }

    public function register_student_qualification()
    {
       // print_r($_POST);
        $student_id=$this->input->post('student_id');
        unset($_POST['student_id']);
        $categoryArr=$this->input->post('category');
        $this->data['studentArr']=$this->student_model->get_student_list();
         $marksArr=$this->input->post('marks');
        $qualificationArr=$this->input->post('qualification');
        $i=0;
        $ajax_response['st']=0;
        foreach($categoryArr as $category)
               {
                   if(!empty($qualificationArr[$i]))
                   {
                      if($category =='other')
                      {
                        $exist=$this->student_model->check_qualification1($student_id,$qualificationArr[$i],$category);
                      }
                       else
                       {
                        $exist=$this->student_model->check_qualification($student_id,$category);

                      }
                       if($exist != 0)
                       {
                           $old=$this->common->get_from_table('am_student_qualification', array("student_id"=>$student_id));
                           $data=array('qualification'=>$qualificationArr[$i],
                                       'marks'=>$marksArr[$i]
                                      );
                           $result=$this->student_model->edit_student_qualification($student_id,$category,$data,$qualificationArr[$i]);
                             $message="Student qualification details edited";
                             $action="Update";
                             $table_row_id=$student_id;
                       }
                       else
                       {
                          $old=""; 
                          $data=array('qualification'=>$qualificationArr[$i],'marks'=>$marksArr[$i],'category'=>$category,'student_id'=>$student_id);
                          $result=$this->student_model->add_student_qualification($data);
                            $message="Added student qualification details";
                            $action="insert";
                            $table_row_id=$this->db->insert_id();
                       }
                        

                       if($result)
                       {
                        
                            $ajax_response['st']=1;
                            $documents['studentArr']['student_id'] = $student_id;
                            $documents['documents'] = $this->student_model->get_student_documents($student_id);
                            $html = $this->load->view('admin/students/student_reg_view_4',$documents,TRUE);
                            $ajax_response['first'] = $html;
                       }
                       else
                       {
                           $ajax_response['st']=0;
                       }
                     //log of qualification
                       $new=$this->common->get_from_table('am_student_qualification', array("student_id"=>$student_id));
                       $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role']; logcreator($action,'database',$who,$old,$table_row_id, 'am_student_qualification', $message, $new);
                   }
              $i++;
              }
        print_r(json_encode($ajax_response));

    }
    
    
    public function upload_documents_action()
    {
        // show($_POST);
        $result=array();
        if($_POST){
            $stud_id=$this->input->post('stud_id');
            $course_id=$this->input->post('course_id');
            $category=$this->input->post('category');            // print_r($category);
            $document_name1=$this->input->post('document_name1');
            $verification=$this->input->post('verification1');
            $course_qualification=$this->common->get_name_by_id('am_classes','basic_qualification',array("class_id"=>$course_id));
            $qualification_id=$this->input->post('qualification_id');
            foreach($category as $key=>$item)
            {


                if($item == $course_qualification)
                {
                   if($_FILES['file_name1']['name'][$key] != "")
                   {
                          if($verification[$key]== "0")
                           {
                             // echo "verify";
                               $result['st'] = 6;
                               $result['message'] = 'Please Verify the '.ucfirst($course_qualification)  .'  document';
                               print_r(json_encode($result));
                               return false;
                          }
                   }
                    else
                    {
                               $result['st'] = 6;
                               $result['message'] = 'Please Upload the '.ucfirst($course_qualification)  .'  document';
                               print_r(json_encode($result));
                               return false;
                    }

                }

            }


            $files = $_FILES;
            $err=0;
            for($i=0;$i<count($this->input->post('document_name1'));$i++){
                if($_FILES['file_name1']['name'][$i]!=''){
                   $typeArr = explode('.', $_FILES['file_name1']['name'][$i]);
                    if((end($typeArr)== 'pdf')|| (end($typeArr)== 'PDF')|| (end($typeArr)== 'docx')||(end($typeArr)== 'doc')||(end($typeArr)== 'jpg') ||(end($typeArr)== 'JPG') ||(end($typeArr)== 'JPEG') ||(end($typeArr)== 'jpeg')){
                    }else{
                        $err=1;
                    }
                }
                
                if($_FILES['file_name1']['name'][$i]!=''){
                   $typeArr = explode('.', $_FILES['file_name1']['name'][$i]);
                    if($files['file_name1']['size'][$i]>1000000){
                        //$err=1;
                    }
                }
            }
            
            if($err==0) {
            for($i=0;$i<count($this->input->post('document_name1'));$i++){
                $qualification_id=$this->input->post('qualification_id')[$i];
                $document_name1=$this->input->post('document_name1')[$i];
                $verification1=$this->input->post('verification1')[$i];
                // $category=$this->input->post('category')[$i];
                $doc_exist = $this->student_model->is_doc1_exist($stud_id,$document_name1,$qualification_id);
                if($doc_exist == 0)
                {
                    if($_FILES['file_name1']['name'][$i]!=''){
                        $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/student_documents';
                        $config['file_name'] = $fileName = "cert_".$stud_id."_".uniqid();
                        $config['allowed_types'] ='jpg|pdf|docx|doc|JPG|PDF|jpeg|JPEG';
                        $config['max_size'] = '1000000';
                        $this->load->library('upload', $config);
                        $_FILES['userfile']['name']= $files['file_name1']['name'][$i];
                        $_FILES['userfile']['type']= $files['file_name1']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['file_name1']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['file_name1']['error'][$i];
                        $_FILES['userfile']['size']= $files['file_name1']['size'][$i]; 
                        if($_FILES['userfile']['size'] >= 80000000){
                            $result['st'] = 2;
                            $result['message'] = 'File is too large. Maximum size is 10 MB';
                            print_r(json_encode($result)); exit;
                        }
                        if ($this->upload->do_upload('userfile'))
                        {
                            $upload_data = $this->upload->data();
                            $file_name = 'uploads/student_documents/'.$upload_data['file_name'];
                            $data=array(
                                'student_id'=>$stud_id,
                                'qualification_id'=>$qualification_id,
                                'document_name'=>$upload_data['file_name'],
                                'qualification'=>$document_name1,
                                'verification'=>$verification1,
                                // 'category'=>$category,
                                'file'=>$file_name
                            );
                            $exist = $this->common->get_from_tablerow('am_student_documents', array('student_id'=>$stud_id,'qualification_id'=>$qualification_id,'status'=>1));//print_r($exist); die();
                            if(!empty($exist)) { 
                            $res = $this->student_model->upload_student_documents_edit($data, array('student_id'=>$stud_id,'qualification_id'=>$qualification_id));    
                            } else { 
                            $res = $this->student_model->upload_student_documents($data);
                            }
                            $verification = $this->common->get_from_tableresult('am_student_documents', array('student_id'=>$stud_id,'verification'=>1));  
                            if(!empty($verification)) {
                               $where = array('student_id'=>$stud_id);
                               $updatedata = array('verified_status'=>1);    
                               $this->common->update('am_students', $where, $updatedata);
                            }
                            $result['st'] = 1;
                            $result['message'] = 'Successfully saved';
                            $result['data'] = array(
                                "student_documents_id"=>$res,
                                "file"=>base_url($file_name)
                            );
                        }else{ 
                            $message = $this->upload->display_errors();
                            $result['st'] = 2;
                            $result['message'] = $message;
                        }
                    }
                }
                else
                {
                    $result['st'] = 0;
                    $result['message'] = 'Data Already Exist';
                }
            }
            $documents['studentArr']['student_id'] = $stud_id;
            $documents['documents'] = $this->student_model->get_student_documents($stud_id);
            $html = $this->load->view('admin/students/student_reg_view_4',$documents,TRUE);
            }else{
                $result['st'] = 3;
                $result['message'] = "The file you trying to upload is invalid, please upload .pdf,.docx,.jpg files only (Max Size:10MB).";
                // $result['first'] = $html;
            }  
        }else{
            $result['st'] = 5;
            $result['message'] = 'Network error';
        }
        print_r(json_encode($result));
    }

    
    public function upload_documents1()
    {
        if($_POST){
            $stud_id=$this->input->post('stud_id');
            $qualification_id=$this->input->post('qualification_id');
            $document_name1=$this->input->post('document_name1');
            $files = $_FILES;
            $err=0;
            for($i=0;$i<count($this->input->post('document_name1'));$i++){
                if($_FILES['file_name1']['name'][$i]!=''){
                    if(($files['file_name1']['type'][$i]== 'pdf')||($files['file_name1']['type'][$i]== 'docx')||($files['file_name1']['type'][$i]== 'doc')||($files['file_name1']['type'][$i]== 'jpg') && ($files['file_name1']['size'][$i]==100000)){
                        $err=0;
                    }else{
                        $err=1;
                    }
                }
            }

            for($i=0;$i<count($this->input->post('document_name1'));$i++){
                $qualification_id=$this->input->post('qualification_id')[$i];
                $document_name1=$this->input->post('document_name1')[$i];
                $verification1=$this->input->post('verification1')[$i];
                $doc_exist = $this->student_model->is_doc1_exist($stud_id,$document_name1,$qualification_id);
                if($doc_exist == 0){ 
                    if($_FILES['file_name1']['name'][$i]!=''){
                        $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/student_documents';
                        $config['file_name'] = $fileName = "cert_".$stud_id."_".uniqid();
                        $config['allowed_types'] ='jpg|pdf|docx|doc';
                        $config['max_size'] = '10000000';
                        $this->load->library('upload', $config);
                        $_FILES['userfile']['name']= $files['file_name1']['name'][$i];
                        $_FILES['userfile']['type']= $files['file_name1']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['file_name1']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['file_name1']['error'][$i];
                        $_FILES['userfile']['size']= $files['file_name1']['size'][$i];  
                        if ($this->upload->do_upload('userfile')) {
                            $upload_data = $this->upload->data();
                            $file_name = 'uploads/student_documents/'.$upload_data['file_name'];
                            $data=array(
                                'student_id'=>$stud_id,
                                'qualification_id'=>$qualification_id,
                                'document_name'=>$upload_data['file_name'],
                                'qualification'=>$document_name1,
                                'verification'=>$verification1,
                                'file'=>$file_name
                            );
                            $res = $this->student_model->upload_student_documents($data);
                            $result['st'] = 1;
                            $result['message'] = 'Successfully saved';
                            $result['data'] = array(
                                "student_documents_id"=>$res,
                                "file"=>base_url($file_name)
                            );
                        }else{
                            $err=1;
                            $message = $this->upload->display_errors();
                            $result['st'] = 2;
                            $result['message'] = $this->upload->display_errors();
                        }
                    }
                }else{
                    $result['st'] = 0;
                    $result['message'] = 'Data Already Exist';
                }
            }
            $documents['studentArr']['student_id'] = $stud_id;
            $documents['documents'] = $this->student_model->get_student_documents($stud_id);
            $html = $this->load->view('admin/students/student_reg_view_4',$documents,TRUE);
            if($err==1){
                $result['st'] = 3;
                $result['message'] = "invalid type";
                // $result['first'] = $html;
            }  
        }else{
            $result['st'] = 5;
            $result['message'] = 'Network error';
        }
        print_r(json_encode($result));
    }



    // public function upload_documents1()
    // {
    //     // print_r($_FILES);
    //     if($_POST){
    //         $stud_id=$this->input->post('stud_id');
    //         // $file1=$this->input->post('file1');
    //         $files = $_FILES;
    //         for($i=0;$i<count($this->input->post('document_name1'));$i++){
    //             $qualification_id=$this->input->post('qualification_id')[$i];
    //             $document_name1=$this->input->post('document_name1')[$i];
    //             $verification1=$this->input->post('verification1')[$i];
    //             $doc_exist = $this->student_model->is_doc1_exist($stud_id,$document_name1);
    //             if($doc_exist == 0){ 
    //                 if($_FILES['file_name1']['name'][$i]!=''){
    //                     $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/student_documents';
    //                     $config['file_name'] = $fileName = "cert_".$stud_id."_".uniqid();
    //                     $config['allowed_types'] ='jpg|pdf|docx|doc';
    //                     $config['max_size'] = '10000';
    //                     $this->load->library('upload', $config);
    //                     $_FILES['userfile']['name']= $files['file_name1']['name'][$i];
    //                     $_FILES['userfile']['type']= $files['file_name1']['type'][$i];
    //                     $_FILES['userfile']['tmp_name']= $files['file_name1']['tmp_name'][$i];
    //                     $_FILES['userfile']['error']= $files['file_name1']['error'][$i];
    //                     $_FILES['userfile']['size']= $files['file_name1']['size'][$i];  
    //                     if ($this->upload->do_upload('userfile')) {
    //                         $upload_data = $this->upload->data();
    //                         $file_name = 'uploads/student_documents/'.$upload_data['file_name'];
    //                         $data=array(
    //                             'student_id'=>$stud_id,
    //                             'qualification_id'=>$qualification_id,
    //                             'document_name'=>$upload_data['file_name'],
    //                             'qualification'=>$document_name1,
    //                             'verification'=>$verification1,
    //                             'file'=>$file_name
    //                         );
    //                         $res = $this->student_model->upload_student_documents($data);
    //                         $result['st'] = 1;
    //                         // $result['message'] = 'Successfully saved';
    //                         $result['data'] = array(
    //                             "student_documents_id"=>$res,
    //                             "file"=>base_url($file_name)
    //                         );
    //                     }else{
    //                         $result['st'] = 2;
    //                         // $result['message'] = $this->upload->display_errors();
    //                     }
    //                 }
    //                 else{
    //                     $result['st'] = 4;
    //                     // $result['message'] = "Please select a file";
    //                 }
    //             }else{
    //                 $result['st'] = 5;
    //                 $result['message'] = 'Please select a file';
    //             }
    //         }
    //         $documents['studentArr']['student_id'] = $stud_id;
    //         $documents['documents'] = $this->student_model->get_student_documents($stud_id);
    //         $html = $this->load->view('admin/students/student_reg_view_4',$documents,TRUE);
    //         $result['st'] = 1;
    //         // $result['message'] = 'Successfully saved';
    //         $result['first'] = $html;
       
    //     }else{
    //         $result['st'] = 3;
    //         // $result['message'] = 'Network error';
    //     }
    //     print_r(json_encode($result));
    // }

    public function upload_documents()
    {
        if($_POST){
            unset($_POST['ci_csrf_token']);
            $data = $_POST;
            $doc_exist = $this->student_model->is_doc_exist($data);
            if($doc_exist == 0){ 
            // $this->form_validation->set_rules('document_name', 'Document name', 'required');
            // $this->form_validation->set_rules('verification', 'Verification', 'required');
            // if($this->form_validation->run()){
                $student_id=$this->input->post('student_id');
                $qualification_id=$this->input->post('qual_id');
                $document_name=$this->input->post('document_name');
                $verification=$this->input->post('verification');
                $file_name = str_replace(' ', '_', $_FILES['file_name']['name']);
                if($_FILES['file_name']['name']!=''){
                    $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/student_documents';
                    $config['file_name'] = "document_".$student_id."_".$file_name;
                    $config['allowed_types'] ='jpg|pdf|docx|doc';
                    $config['max_size'] = '10000';
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('file_name')) {
                        $upload_data = $this->upload->data();
                        //$file_name = str_replace(' ', '_', $_FILES['file_name']['name']);

                        // $file_name = 'uploads/student_documents/'.$upload_data['file_name'];
                        $file_name = 'uploads/student_documents/'.$config['file_name'];
                        $data=array(
                            'student_id'=>$student_id,
                            'qualification_id'=>$qualification_id,
                            'document_name'=>$document_name,
                            'qualification'=>'',
                            'verification'=>$verification,
                            'file'=>$file_name
                        );
                        $res = $this->student_model->upload_student_documents($data);
                        $result['st'] = 1;
                        $result['message'] = 'Successfully saved';
                        $result['data'] = array(
                            "student_documents_id"=>$res,
                            "file"=>base_url($file_name)
                        );
                    }
                    else{
                        $result['st'] = 0;
                        $result['message'] = $this->upload->display_errors();
                    }
                }else{
                    $result['st'] = 0;
                    $result['message'] = "Please add details";
                }
            // }else{
            //     $result['st'] = 0;
            //     $result['message'] = "Please add data";
            // }
        }else{
            $result['st'] = 0;
            $result['message'] = 'Data Already Exist';
        }

        }else{
            $result['st'] = 0;
            $result['message'] = 'Network error';
        }
        print_r(json_encode($result));
    }

    public function get_student_document(){
        if($_POST){
            $result = $this->student_model->get_student_document($this->input->post('id'));
        }
        print_r(json_encode($result));
    }

    public function delete_student_document(){
        if($_POST){
            $result = $this->student_model->delete_student_document($this->input->post('id'));
        }
    }

    public function delete_others()
    {
       
        $id  = $_POST['id'];
        $res = $this->student_model->delete_others($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'am_student_qualification', 'Student qualification details removed');
        }
        print_r($res); 
        
    }
    

    public function verify_document(){
        if($_POST){
            $this->student_model->verify_student_document($this->input->post('id'),$this->input->post('status'));
        }
    }

    public function get_student_documents(){
        if($_POST){
            $student_id = $this->input->post('id');
            $documents = $this->student_model->get_student_documents($student_id);

            $html = '<li class="data_table_head ">
                        <div class="col">Document name</div>
                        <div class="col">Document file</div>
                        <div class="col">Verification status</div>
                        <div class="col actions">Actions</div>
                    </li>';
                    if(!empty($documents)) {
                        foreach($documents as $row){ 
                            $html = $html.'<li id="row_'.$row->student_documents_id.'">';
                            if(!empty($row->qualification_id)){
                            $html = $html.'<div class="col">'.$row->qualification.'</div>';
                            }else{
                                $html = $html.'<div class="col">'.$row->document_name.'</div>';
                            }
                            $html = $html.'<div class="col"><a target="_blank" href="'.base_url($row->file).'">Download document</a></div>
                                <div class="col">';
                                
                            $html = $html.'Yes &nbsp;<input type="radio" name="verfied'.$row->student_documents_id.'" ';
                                if($row->verification==1){$html = $html.' checked="checked" ';}
                            $html = $html.'value="1" onclick="verify_document('.$row->student_documents_id.');">';

                            $html = $html.'&nbsp;&nbsp;&nbsp';
                                
                            $html = $html.'No &nbsp;<input type="radio" name="verfied'.$row->student_documents_id.'" ';
                                if($row->verification==0){$html = $html.' checked="checked" ';}
                            $html = $html.'value="0" onclick="unverify_document('.$row->student_documents_id.');">';

                            $html = $html.'</div>
                                <div class="col actions">
                                    <!--<button class="btn btn-default option_btn" title="Edit" onclick="edit_document('.$row->student_documents_id.');">
                                        <i class="fa fa-pencil "></i>
                                    </button>-->
                                    <button class="btn btn-default option_btn" title="Delete" onclick="delete_fromtable('.$row->student_documents_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </div>
                            </li>';
                    }}
            print_r($html);
        }
    }

    function filename_exists()
    {
        $qualification = $this->input->post('qualification');
        $exists = $this->student_model->filename_exists($qualification);
    
        $count = count($exists);
        // echo $count 
    
        if (empty($count)) {
            return true;
        } else {
            return false;
        }
    }

//     public function fetch()
//     {
//         $output = '';
//         $document_name1 = '';
//         $file1 = '';
       
//         $stud_id = $this->input->post('stud_id');
//         $document_name1 = $this->input->post('document_name1');
//         $file1 = $this->input->post('file1');
//         $document_verification1 = $this->input->post('document_verification1');
//         $data = $this->student_model->get_all_others1($stud_id,$document_name1,$file1,$document_verification1);
//         // echo $this->db->last_query();
//         $output .= '
//         <input type="hidden" name="stud_id" id="stud_id" value="'.$stud_id.'" />
//         <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
//         if($data->num_rows() > 0){
//             $i=1;
//             foreach($data->result() as $rows){
//                 if($rows['category']=="sslc"){ 
//                     $output .= '    <div class="col-sm-4">
//                         <div class="form-group">
//                             <label>SSLC</label>
//                             <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows['qualification'].'" placeholder="Document Name" />
//                         </div>
//                     </div>';
//                  }else if($rows['category']=="plustwo"){
//                     $output .= '    <div class="col-sm-4">
//                         <div class="form-group">
//                             <label>+2/VHSE</label>
//                             <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows['qualification'].'" placeholder="Document Name" />
//                         </div>
//                     </div>';
//                  }else if($rows['category']=="degree"){ 
//                     $output .= '    <div class="col-sm-4">
//                         <div class="form-group">
//                             <label>Degree</label>
//                             <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows['qualification'].'" placeholder="Document Name" />
//                         </div>
//                     </div>';
//                  }else if($rows['category']=="pg"){ 
//                     $output .= '    <div class="col-sm-4">
//                         <div class="form-group">
//                             <label>PG</label>
//                             <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows['qualification'].'" placeholder="Document Name" />
//                         </div>
//                     </div>';
//                 }else { 
//                     $output .= '    <div class="col-sm-4">
//                         <div class="form-group">
//                             <label>Additional Qualification</label>
//                             <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows['qualification'].'" placeholder="Document Name" />
//                         </div>
//                     </div>';
//                  } 
//                 $output .= '    <div class="col-sm-4">
//                         <div class="form-group">
//                             <label>Upload File</label>
//                             <input type="file"  id="file1" class="form-control"  name="file_name1[]" onchange="readURL1(this);"  multiple/>
//                             <p>Upload .pdf,.docx files only  (Max Size:5MB).</p>
//                         </div>
//                     </div>
//                     <div class="col-sm-4">
//                         <div class="form-group">
//                             <label style="display:block">Verified</label>
//                             <select class="form-control"  id="document_verification1" name="verification1[]">
//                                 <option value="0">No</option>
//                                 <option value="1">Yes</option>
//                             </select>
//                         </div>
//                     </div>';
//         }
//         echo $output;
//     }
// }
    
    
    /*
    *   function'll get the student list by pagination
    *   @author GBS-L
    */
                          
    
    public function student_list_pagination() 
    {
      // print_r($_POST); 
        // Datatables Variables
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
            "am_students.email", 
            "am_students.contact_number", 
            "am_students.street", 
            "am_students.status",
            "am_students.verified_status",
            "am_students.idcard_status"
        );

         if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
   
            $list = $this->student_model->student_list_pagination($start, $length, $order, $dir);
       
        

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $rows) {
            if ($rows['status']==1)
            {
                $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$rows['student_id'].')"><span class="admitted">Admitted</span></a>';
            }
            else if($rows['status']==2) 
            {
                $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$rows['student_id'].')"><span class="paymentcompleted">Fee Paid</span></a>';
            }
            else if($rows['status']==4) 
            { 
                $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$rows['student_id'].')"><span class="batchchanged">Batch Changed</span></a>';
            }
            else if($rows['status']==5) 
            {
                $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$rows['student_id'].')"><span class="inactivestatus">Inactive</span></a>';
            }
            else if($rows['status']==0 && $rows['verified_status']==1) {
                $status= '<span class="paymentpending">Payment Pending</span>';
            }
            else 
            {
                $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$rows['student_id'].')"><span class="registered">Registered</span></a>';
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
             if($rows['idcard_status']==1){
                $id_status = '<span class="iddownload" style="margin-top:3px;">Downloaded</span>';
            }else{
                $id_status =  '<span class="idpending" style="margin-top:3px;">Pending</span>';
            }
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['registration_number'];
            $row[] = $rows['name'];
            $row[] = $rows['email'];
            $row[] = $rows['contact_number'];
            $row[] = $rows['street'];
            $row[] = $status." ".$blacklist_status;
            $row[] = $id_status;
            $row[] = '<a href ="'.base_url('backoffice/view-student/'.$rows['student_id']).'" id="#view_student" >  
                        <button title="View" class="btn btn-default option_btn " onclick="view_studentdata('. $rows['student_id'].')">
                            <i class="fa fa-eye "></i>
                        </button>
                      </a>
                        <a href ="'.base_url('backoffice/print-application/'.$rows['student_id']).'" target="_blank">
                            <i class="fa fa-download"></i>
                        </a>
                        <a class="btn btn-primary btn-sm btn_details_view" href="'.base_url().'backoffice/manage-students/'. $rows['student_id'].'">
                            Details
                        </a>';
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

    //get stop by route
    public function get_stop_by_routeid(){
        if($_POST){
            $id=$this->input->post('id');
            $stopArr=$this->common->get_alldata('tt_transport_stop',array("transport_id"=>$id));
            $count = count($stopArr);
            $result['count'] = $count;
            foreach($stopArr as $row){
                $result['id'] = $row['stop_id'];
                break;
            }
            if(!empty($stopArr)){
                $html = '';
                //$html='<option value="">Select</option>';
                foreach($stopArr as $row){
                    $html.='<option value="'.$row['stop_id'].'">'.$row['name'].'</option>';
                }
            }
            $result['html'] = $html;
            print_r(json_encode($result));
        }
    }

   public function get_fare_byStopId()
   {
      if($_POST)
      {
          $stop=$this->input->post('id');
          $fare=$this->common->get_name_by_id('tt_transport_stop','route_fare',array("stop_id"=>$stop));
          $ajax_response['fare']=numberformat($fare);
            print_r(json_encode($ajax_response));
      }
   }

/*
*   function'll get attendance of student
*   @params student id    
*   @author GBS-R
*/
    
public function attendance(){
    $student_id = $this->input->post('student_id');
    $this->data['student_id'] = $student_id;
    $batch = $this->user_model->get_student_active_batch($student_id); 
    if(!empty($batch)) {
    $school_id = $batch->school_id;
    $this->data['batch'] = $batch;
    $this->data['attendance'] = $this->common->get_student_attendance($batch->batch_id);    
    }
    echo $this->load->view('admin/student_attendance_view', $this->data, TRUE); 
} 
    
/*
*   function'll insert user for exam application
*   @params username, password, student id
*   @author GBS-R
*
*/
    
    public function gm_user_registration($username = NULL, $password = NULL, $userId = NULL) {
      // Authentication Api call
      $postdata['grant_type'] 		= 'password'; 
      $postdata['username'] 		= 'gm_admin'; 
      $postdata['password'] 		= 'password';
      $postdata['scope'] 		    = 'read write trust'; 
      $jsonData['method']           = "oauth/token?grant_type=password&username=gm_admin&password=password&client_id=grandmaster-client&client_secret=grandmaster-secret&scope=read+write+trust";
      $jsonData['type'] = "POST"; 
      $jsonData['data'] = array();
      $ajaxResponse = json_decode($this->common->rest_api_auth($jsonData)); 
    // User insert api cal  
      $data['id'] 		        = $userId;
      $data['password'] 		= $password; 
      $data['userName'] 		= $username;  
      $data['role']['id'] 		= 2;  
      $jsonData['access_token'] = $ajaxResponse->access_token; 
      $jsonData['method']       = "createOrUpdateUser";
      $jsonData['type']         = "POST"; 
      $jsonData['data']         = json_encode($data); 
      $ajaxResponse = json_decode($this->common->rest_api_call($jsonData));    
    }
    
/*
*   function'll get progress report
*   @params question id
*   @author GBS-R

public function progress_report(){
    $student_id = $this->input->post('student_id');
    $myexams = $this->user_model->get_student_exams($student_id); 
    $this->data['myexams'] = $myexams;
    if(!empty($myexams)) { 
    $i=1; 
    $outof = '';
    $examStr = '';
    $sectionStr ='';
    foreach($myexams as $mark) { 
        $examStr .= "'".$mark->name."',";
        $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
        $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
        $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
        if(!empty($question_paper)) {
           $question_paper_id =  $question_paper['question_paper_id'];
        }
        $this->data['questions']    = $this->user_model->get_exam_papers_details($question_paper_id); 
        $questions = $this->data['questions'];
        $sectionArr = array();
        if(!empty($questions)) {
           foreach($questions as $question) { 
               array_push($sectionArr, $question->exam_section_details_id);
           }
           $sectionArr = array_unique($sectionArr);
        }
        $i++;
    }
            $pie        = '';
            $sectotal   = 0;
            foreach($sectionArr as $section) {
                //$sectionDet = $this->common->get_from_tablerow('gm_exam_section_config', array('id'=>$section)); 
                $sectionDet = $this->common->get_section_nameby_details($section); 
                $sectionStr .= "{name: '".$sectionDet['section_name']."',data: [";//11, 20, 20]},
                $sectionmarkStr = '';
                foreach($myexams as $mark) { 
                    $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
                    $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
                    $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
        if(!empty($question_paper)) {
           $question_paper_id =  $question_paper['question_paper_id'];
        }
                    $questions    = $this->user_model->get_exam_papers_details($question_paper_id); 
                    $sectionArr = array();
                    $pmark = 0;
                    $nmark= 0;
                    foreach($questions as $question) {
                        if($question->exam_section_details_id==$section){
                             $anserclass = '';
                            $st_answer = $this->common->get_student_answer($mark->attempt, $mark->exam_id, $student_id, $question->question_id); 
                            if(!empty($st_answer)) {
                                if($st_answer->correct==1) {
                                     $pmark += $st_answer->mark;   
                                } else {
                                    $nmark += $st_answer->negative_mark; 
                                }
                            }
                        }
                    }
                    $sectiontotal = $pmark-$nmark;
                    $sectionmarkStr .=  $sectiontotal.',';
                    $sectotal += $sectiontotal;
                }   
                    $pie .= "['".$sectionDet['section_name'];
                    $pie .= "', ".$sectotal."],"; 
                    $sectionStr .= substr($sectionmarkStr, 0, -1)."]},";
            }
    $examStr = substr($examStr, 0, -1); 
    $sectionStr = substr($sectionStr, 0, -1);   
    $pie = substr($pie, 0, -1);    
    $this->data['exams'] = $examStr; 
    $this->data['sectionStr'] = $sectionStr; 
    $this->data['sectionpie'] = $pie;     
    }
    echo $this->load->view('student/student_progress_report_view', $this->data, TRUE); 
}*/
	
	/*
*   function'll get progress report
*   @params question id
*   @author GBS-R
*/
public function progress_report(){ 
    $student_id = $this->input->post('student_id');
    $myexams = $this->user_model->get_student_exams($student_id); //print_r($myexams); 
    $this->data['myexams'] = $myexams;
    if(!empty($myexams)) { 
    $i=1; 
    $outof = '';
    $examStr = '';
    $sectionStr ='';
    $colorcombo = ''; 
    $sectionArr = array();   
    foreach($myexams as $mark) {  //echo '<pre>';print_r($mark); 
        //$examStr .= "'".$mark->exam_name."[A".$mark->attempt."]',";
        $examStr .= "'".$mark->name."[A".$mark->attempt."]',";
        $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
        $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
        $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
        if(!empty($question_paper)) {
           $question_paper_id =  $question_paper['question_paper_id'];
        }
        $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id); //print_r($section_ids);
        $this->data['questions']    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids);
        $questions = $this->data['questions'];
        if(!empty($questions)) {
           foreach($questions as $key=>$question) { //print_r($question);
            $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
            $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
            $questions[$key]->subject_name= $sectionDet['section_name'];
            array_push($sectionArr, $question->subject_id);
           }
           $sectionArr = array_unique($sectionArr);
        }
        $i++;
    }
            $pie        = '';
			$actualsecMark = 0;
            $colors[0]  = '#7cb5ec';
            $colors[1]  = '#434348';
            $colors[2]  = '#90ed7d';
            $colors[3]  = '#f7a35c';
            $colors[4]  = '#e4d354';
            $colors[5]  = '#f15c80';
            $colors[6]  = '#91e8e1';
            $colors[7]  = '#2b908f';
            $colors[8]  = '#f45b5b';
            $colors[9]  = '#f8aec0';
            $colors[10]  = '#0f487f';
            $colors[10]  = '#0f487f';
            $colors[10]  = '#0f487f';
            $colors[11]  = '#ffcccc';$colors[12]  = '#ff9999';$colors[13]  = '#ffcc99';$colors[14]  = '#ffa64d';
            $colors[15]  = '#cc6600';$colors[16]  = '#ff9933';$colors[17]  = '#cccc00';$colors[18]  = '#999900';
            $colors[19]  = '#cccc00';$colors[20]  = '#ff00ff';$colors[21]  = '#cc00cc';$colors[22]  = '#ffccff';
            $colors[23]  = '#b3b3ff';$colors[24]  = '#3333ff';$colors[25]  = '#66e0ff';$colors[26]  = '#ccf5ff';
            $colors[27]  = '#008fb3';$colors[28]  = '#1affc6';$colors[29]  = '#00cc99';$colors[30]  = '#b3ffec';
            $ccnt = 0; //echo '<pre>';print_r($sectionArr);
            foreach($sectionArr as $section) { //echo '<pre>';print_r($section); 
            	$sectotal   = 0;
				$actualmark = 0;
                //$sectionDet = $this->common->get_from_tablerow('gm_exam_section_config', array('id'=>$section)); 
                $sectionDet = $this->common->gm_exam_section_config_subject_id($section); //print_r($sectionDet);
                $colorcombo .= "'".$colors[$ccnt]."',";
                $sectionStr .= "{name: '".$sectionDet['section_name']."',data: [";//11, 20, 20]},
                $sectionmarkStr = '';
                foreach($myexams as $mark) {  //print_r($mark);
                    $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
                    $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
                    $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
                    if(!empty($question_paper)) {
                       $question_paper_id =  $question_paper['question_paper_id'];
                    }
                    $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id);
                    $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids); 
                    $sectionArr = array();
                    if(!empty($questions)) {
                        foreach($questions as $key=>$question) { 
                         $sectionDett = $this->common->get_section_nameby_details($question->exam_section_details_id); 
                         $questions[$key]->subject_id= $sectionDett['exam_section_config_id'];
                         $questions[$key]->subject_name= $sectionDett['section_name'];
                         array_push($sectionArr, $question->subject_id);
                        }
                        $sectionArr = array_unique($sectionArr);
                     }
                    $pmark 		= 0;
                    $nmark		= 0;
                    foreach($questions as $question) {
                        if($question->subject_id==$section){
                             $anserclass = '';
                            $st_answer = $this->common->get_student_answer($mark->attempt, $mark->exam_id, $student_id, $question->question_id);  
                            if(!empty($st_answer)) {
									$actualmark += $st_answer->actual_mark;
                                if($st_answer->correct==1) {
                                     $pmark += $st_answer->mark;   
                                } else {
                                    $nmark += $st_answer->negative_mark; 
                                }
                            }
                        }
                    }
                    $sectiontotal = $pmark-$nmark;
                    $sectionmarkStr .=  $sectiontotal.',';
                    $sectotal += $sectiontotal;
                	}  
                    $pie .= "['".$sectionDet['section_name'];
                    if($actualmark>0) {
                    $sectiontotalperctage 	= $sectotal/$actualmark;
                    } else {
                    $sectiontotalperctage   = 0;    
                    }
                    $actualsecMark 			= $sectiontotalperctage*100;
                    if($actualsecMark<0) {
                        $actualsecMark = 0;
                    }
                    $pie .= "', ".number_format($actualsecMark,2)."],"; 
                    $sectionStr .= substr($sectionmarkStr, 0, -1)."]},";
                    $ccnt++;
            }//die();
    $examStr                    = substr($examStr, 0, -1); 
    $sectionStr                 = substr($sectionStr, 0, -1);   
    $pie                        = substr($pie, 0, -1);    
    $this->data['exams']        = $examStr; 
    $this->data['sectionStr']   = $sectionStr; 
    $this->data['sectionpie']   = $pie;   
    $this->data['color']        = $colorcombo;     
    }
    echo $this->load->view('student/student_progress_report_view', $this->data, TRUE); 
    // $student_id = $this->input->post('student_id');
    // $myexams = $this->user_model->get_student_exams($student_id); 
    // $this->data['myexams'] = $myexams;
    // if(!empty($myexams)) { 
    // $i=1; 
    // $outof = '';
    // $examStr = '';
    // $sectionStr ='';
    // $colorcombo = ''; 
    // $sectionArr = array(); 
	// $question_paper_id = 0;	
    // foreach($myexams as $mark) {  
    //     $examStr .= "'".$mark->name."',";
    //     $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
    //     $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
    //     $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
    //     if(!empty($question_paper)) {
    //        $question_paper_id =  $question_paper['question_paper_id'];
    //     }
    //     $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id); 
    //     $this->data['questions']    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids);
    //     $questions = $this->data['questions'];
    //     if(!empty($questions)) {
    //        foreach($questions as $key=>$question) { 
    //         $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
    //         $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
    //         $questions[$key]->subject_name= $sectionDet['section_name'];
    //         array_push($sectionArr, $question->subject_id);
    //        }
    //        $sectionArr = array_unique($sectionArr);
    //     }
    //     $i++;
    // }
    //         $pie        = '';
    //         $sectotal   = 0;
    //         $colors[0]  = '#7cb5ec';
    //         $colors[1]  = '#434348';
    //         $colors[2]  = '#90ed7d';
    //         $colors[3]  = '#f7a35c';
    //         $colors[4]  = '#e4d354';
    //         $colors[5]  = '#f15c80';
    //         $colors[6]  = '#91e8e1';
    //         $colors[7]  = '#2b908f';
    //         $colors[8]  = '#f45b5b';
    //         $colors[9]  = '#f8aec0';
    //         $colors[10]  = '#0f487f';
    //         $ccnt = 0; 
    //         foreach($sectionArr as $section) {
    //             $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
    //             $colorcombo .= "'".$colors[$ccnt]."',";
    //             $sectionStr .= "{name: '".$sectionDet['section_name']."',data: [";
    //             $sectionmarkStr = '';
    //             foreach($myexams as $mark) {  
    //                 $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
    //                 $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
    //                 $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
    //                 if(!empty($question_paper)) {
    //                    $question_paper_id =  $question_paper['question_paper_id'];
    //                 }
    //                 $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id);
    //                 $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids); 
    //                 $sectionArr = array();
    //                 if(!empty($questions)) {
    //                     foreach($questions as $key=>$question) { 
    //                      $sectionDett = $this->common->get_section_nameby_details($question->exam_section_details_id); 
    //                      $questions[$key]->subject_id= $sectionDett['exam_section_config_id'];
    //                      $questions[$key]->subject_name= $sectionDett['section_name'];
    //                      array_push($sectionArr, $question->subject_id);
    //                     }
    //                     $sectionArr = array_unique($sectionArr);
    //                  }
    //                 $pmark = 0;
    //                 $nmark= 0;
    //                 foreach($questions as $question) {
    //                     if($question->subject_id==$section){
    //                          $anserclass = '';
    //                         $st_answer = $this->common->get_student_answer($mark->attempt, $mark->exam_id, $student_id, $question->question_id); 
    //                         if(!empty($st_answer)) {
    //                             if($st_answer->correct==1) {
    //                                  $pmark += $st_answer->mark;   
    //                             } else {
    //                                 $nmark += $st_answer->negative_mark; 
    //                             }
    //                         }
    //                     }
    //                 }
    //                 $sectiontotal = $pmark-$nmark;
    //                 $sectionmarkStr .=  $sectiontotal.',';
    //                 $sectotal += $sectiontotal;
    //             }   
    //                 $pie .= "['".$sectionDet['section_name'];
    //                 $pie .= "', ".$sectotal."],"; 
    //                 $sectionStr .= substr($sectionmarkStr, 0, -1)."]},";
    //                 $ccnt++;
    //         }
    // $examStr                    = substr($examStr, 0, -1); 
    // $sectionStr                 = substr($sectionStr, 0, -1);   
    // $pie                        = substr($pie, 0, -1);    
    // $this->data['exams']        = $examStr; 
    // $this->data['sectionStr']   = $sectionStr; 
    // $this->data['sectionpie']   = $pie;   
    // $this->data['color']        = $colorcombo;  
	// $this->data['width']		= 3;
    // }
    // echo $this->load->view('student/student_progress_report_view', $this->data, TRUE); 
}
    /*
    This function will return the list of student for progress report
    @auther:GBS-L
    */
    
      public function progress_report_list(){
         check_backoffice_permission('manage_progress_report');
        $this->data['page']="admin/progress_report_list";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Manage Students";
        $this->data['menu_item']="backoffice/progress-reportlist";
        //$this->data['studentArr']=$this->student_model->get_students_progress_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }
     
                          
    
    
    
    public function get_course_bySchool()
    {
         $select= '';
      if($_POST)
      { 
          $school_id=$this->input->post('school');
          $centre_id=$this->input->post('centre_id');
          $courses=$this->student_model->get_course_bySchool_centre($school_id,$centre_id);
          if(!empty($courses)){
               
          foreach($courses as $val) 
           {
             $select.='<option value="'.$val["institute_course_mapping_id"].'">'.$val["class_name"].'</option>';  
           }
          }
          else
          {
            $select.= '<option value="">Select</option>';  
          }
      }
        print_r($select);
    }
    
    public function get_batch_byCourse()
    {
        $select= '';
      if($_POST)
      {   
           $institute_course_mapping_id=$this->input->post('course_id');
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
public function search_student_progresslist()
{
    $examhtml = '';
    $html  = '';
    if($_POST)
    {
       
            $school_id=$this->input->post('school_id');
            $centre_id=$this->input->post('centre_id');
            $institute_course_mapping_id=$this->input->post('course_id');
            $batch_id=$this->input->post('batch_id');
        
            $where=array();
            
            if($institute_course_mapping_id)
            {
            $where['am_student_course_mapping.institute_course_mapping_id']=$institute_course_mapping_id;
            }
            if($batch_id)
            {
              //$myexams = $this->common->get_from_tableresult('gm_exam_schedule', array('batch_id'=>$batch_id,'status'=>4)); 
              $myexams = $this->student_model->get_batch_examdetails($batch_id); 
              if(!empty($myexams)) {
                  $examhtml .='<thead><tr>
                <th width="8%">'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('exam_name').'</th>
                <th>'.$this->lang->line('attempt').'</th>
                <th>'.$this->lang->line('max').'</th>
                <th>'.$this->lang->line('min').'</th>
                <th>'.$this->lang->line('average').'</th>
                <th>'.$this->lang->line('details').'</th>
                </tr></thead>';
                  $x =1;
                  foreach($myexams as $mark){ 
                        $topscore = $this->common->get_topscore($mark->attempt, $mark->exam_id);
                        $minscore = $this->common->get_minscore($mark->attempt, $mark->exam_id);
                        $average = $this->common->get_average($mark->attempt, $mark->exam_id);
                        $questionDet = $this->common->get_exam_details_by_scheduleid($mark->exam_id);
                        if(!empty($questionDet)) {
                            $outof = $questionDet['totalmarks'];
                        }
                      $examhtml .= '<tr>
                            <td width="8%">'.$x.'</td>
                            <td>'.$mark->name.'</td>
                            <td>'.$mark->attempt.'</td>
                            <td>'.$mark->max.'</td>
                            <td>'.$mark->min.'</td>
                            <td>'.number_format($mark->avg, 2).'</td>
                            <td><button class="btn btn-success btn-sm chartBlockBtn batchaverage" alt="'.$mark->attempt.'" id="'.$mark->exam_id.'">View</button></td>
                        </tr>';
                        $x++; 
                  }
              }    
                
              $where['am_student_course_mapping.batch_id']=$batch_id;
            }
            

            $data=$this->student_model->search_student_progresslist($where);
         $html = '<thead><tr>
                <th width="8%">'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('application.no').'</th>
                <th>'.$this->lang->line('name').'</th>
                <th>'.$this->lang->line('emailid').'</th>
                <th>'.$this->lang->line('contact.no').'</th>
                <th>'.$this->lang->line('location').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
         if(!empty($data))
         {
             $i=1;
             foreach($data as $row)
             {
                $html .= '<tr>
                            <td width="8%">'.$i.'</td>
                            <td>'.$row['registration_number'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['contact_number'].'</td>
                            <td>'.$row['street'].'</td>
                            <td><button class="btn btn-success btn-sm chartBlockBtn studentindivigualprogress"  id="'.$row['student_id'].'"        id="chartBlockBtn">View</button></td>
                        </tr>';
                        $i++; 
             }
             
             $html .= '<script>
                     $(document).ready(function () {
                        $(document).on("click", ".chartBlockBtn", function () {
                        //  $(".chartBlockBtn").click(function () {
                            $("#chartBlock").toggleClass("show");
                            $(".close_btn").fadeIn("200");
                        });
                        $(document).on("click", ".close_btn", function () {
                        // $(".close_btn").click(function () {
                            $(this).hide();
                            $("#chartBlock").removeClass(("show"));
                        });
                    });
                    </script>';
         }
        
    }
    
    print_r(json_encode(array('students'=>$html,'exams'=>$examhtml)));
}
    
    
/*
*   function will show batch student performance
*   @params exam id, attempt
*   @author GBS-R
*
*/
    
function get_batch_exam_details() {
    $attempt = $this->input->post('attempt');
    $exam_id = $this->input->post('exam_id');
    $examavg = $this->common->get_avgmark_exam(array('attempt'=>$attempt,'exam_id'=>$exam_id));
    $examdetails = $this->common->get_from_exam_summary(array('attempt'=>$attempt,'exam_id'=>$exam_id));
    $html = '<div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          
              <h6 class="examavg">Above Average Students</h6>
            <hr class="examavgHr">

                <div class="table-responsive table_language">
                    <table id="batch_examlist_table" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">'.$this->lang->line('sl_no').'</th>
                                <th>'.$this->lang->line('student').'</th>
                                <th>'.$this->lang->line('reg_no').'</th>
                                <th>'.$this->lang->line('contact.no').'</th>
                                <th>'.$this->lang->line('mark').'</th>
                            </tr>
                        </thead>';
                if(!empty($examdetails)) {
                    $i=1;
                    foreach($examdetails as $exam) { 
                        if($exam->total_mark>=$examavg){
                        $student = $this->common->get_from_tablerow('am_students', array('student_id'=>$exam->student_id)); 
                  $html .= '<tr>
                                <td>'.$i.'</th>
                                <td>'.$student['name'].'</td>
                                <td>'.$student['registration_number'].'</td>
                                <td>'.$student['contact_number'].'</td>
                                <td>'.$exam->total_mark.'</td>
                            </tr>';
                        $i++;
                        }
                    }
                }
                        
               $html .= '</table>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <h6 class="examavg">Below Average Students</h6>
            <hr class="examavgHr">

                <div class="table-responsive table_language">
                    <table id="batch_examlist_table" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">'.$this->lang->line('sl_no').'</th>
                                <th>'.$this->lang->line('student').'</th>
                                <th>'.$this->lang->line('reg_no').'</th>
                                <th>'.$this->lang->line('contact.no').'</th>
                                <th>'.$this->lang->line('mark').'</th>
                            </tr>
                        </thead>';
                            if(!empty($examdetails)) {
                                $i=1;
                                foreach($examdetails as $exam) { 
                                    if($exam->total_mark<$examavg){
                                    $student = $this->common->get_from_tablerow('am_students', array('student_id'=>$exam->student_id)); 
                              $html .= '<tr>
                                            <td>'.$i.'</th>
                                            <td>'.$student['name'].'</td>
                                            <td>'.$student['registration_number'].'</td>
                                            <td>'.$student['contact_number'].'</td>
                                            <td>'.$exam->total_mark.'</td>
                                        </tr>';
                                    $i++;
                                    }
                                }
                            }    
                    $html .= '</table>
                </div>
            </div>
        </div>';
    $sectionreport = array();
    $sectionDet = $this->student_model->get_section_fromqsn($attempt, $exam_id); 
    if(!empty($sectionDet)) {
        foreach($sectionDet as $key=>$section) { 
            $secDet = $this->common->get_section_name($section);                                   
            $sectionreport[$key]['section_id']      = $section;  
            $sectionreport[$key]['section_name']    = $secDet['section_name']; 
            $studaArr = array();
            $avgmark = 0;
            $cnt = 0;
            foreach($examdetails as $ekey=>$exam) { 
                $student = $this->common->get_from_tablerow('am_students', array('student_id'=>$exam->student_id));                   $totalmark = $this->common->get_student_section_sum(array('student_id'=>$exam->student_id,'secton_id'=>$section, 'attempt'=>$attempt, 'exam_id'=>$exam_id)); 
                $studaArr[$ekey] = array('student_id'=>$exam->student_id,
                                                            'student_name'=>$student['name'],
                                                            'registration_number'=>$student['registration_number'],
                                                            'contact_number'=>$student['contact_number'],
                                                            'mark'=>$totalmark);  
                $avgmark += $totalmark;
                $cnt++;
            }
            
            $sectionreport[$key]['section_avg']    = $avgmark/$cnt; 
            $sectionreport[$key]['students'] = $studaArr;
                                            
        }
    }
    //print_r($sectionreport);
    
    if(!empty($sectionreport)) {
        $html .= '<h6 class="examavg">Sesstion Wise Score</h6>
            <hr class="examavgHr">';
        foreach($sectionreport as $section) {
            $html .= '<div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <h6 class="examavg sectionwise">Above Average Students For <b class="examavg">'.$section['section_name'].'</b></h6>
            <hr class="examavgHr">

                <div class="table-responsive table_language">
                    <table id="batch_examlist_table" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">'.$this->lang->line('sl_no').'</th>
                                <th>'.$this->lang->line('student').'</th>
                                <th>'.$this->lang->line('reg_no').'</th>
                                <th>'.$this->lang->line('contact.no').'</th>
                                <th>'.$this->lang->line('mark').'</th>
                            </tr>
                        </thead>';
            
            if(!empty($section['students'])) {
                $c =1;
                foreach($section['students'] as $val) {
                    if($val['mark']>=$section['section_avg']) {
                    $html .= '<tr>
                                            <td>'.$c.'</th>
                                            <td>'.$val['student_name'].'</td>
                                            <td>'.$val['registration_number'].'</td>
                                            <td>'.$val['contact_number'].'</td>
                                            <td>'.$val['mark'].'</td>
                                        </tr>';
                                    $c++;
                    }
                }
                
                $html .= '</table>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <h6 class="examavg sectionwise">Below Average Students For <b class="examavg">'.$section['section_name'].'</b></h6>
            <hr class="examavgHr">

                <div class="table-responsive table_language">
                    <table id="batch_examlist_table" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50">'.$this->lang->line('sl_no').'</th>
                                <th>'.$this->lang->line('student').'</th>
                                <th>'.$this->lang->line('reg_no').'</th>
                                <th>'.$this->lang->line('contact.no').'</th>
                                <th>'.$this->lang->line('mark').'</th>
                            </tr>
                        </thead>';
                foreach($section['students'] as $val) {
                    if($val['mark']<$section['section_avg']) {
                    $html .= '<tr>
                                            <td>'.$c.'</th>
                                            <td>'.$val['student_name'].'</td>
                                            <td>'.$val['registration_number'].'</td>
                                            <td>'.$val['contact_number'].'</td>
                                            <td>'.$val['mark'].'</td>
                                        </tr>';
                                    $c++;
                    }
                }
                 $html .= '</table>
                </div>
            </div>
        </div>';
            }
        }
    }
    echo $html;
}    

public function hallticket(){
     check_backoffice_permission('manage_hallticket');
    $this->data['page']="admin/hallticket";
    $this->data['menu']="students";
    $this->data['breadcrumb']="Hall Ticket";
    $this->data['menu_item']="backoffice/hallticket";
    $this->data['notificationArr'] = $this->student_model->get_student_exams(); 
    $this->data['examArr']=$this->student_model->get_exam_list();
    // show($this->data['examArr']);
    $this->data['courseArr']=$this->Class_model->get_allclass_list();
    $this->load->view('admin/layouts/_master',$this->data);
}

public function fetch(){
    $output = '';
    $filter_exam = '';
    $filter_course = '';
    $filter_exam = $this->input->post('filter_exam');
    $filter_course = $this->input->post('filter_course');
    // $role = $this->session->userdata['role'];
    // if($role=='faculty') {
    // $user_id =    $this->session->userdata['user_id'];
    // $subjectArr = $this->common->get_from_tableresult('am_faculty_subject_mapping', array('staff_id'=>$user_id));
    // $parentsub = [];
    // $courseArr = [];
    // if(!empty($subjectArr)) {
    //     foreach($subjectArr as $subject){
    //         array_push($parentsub, $subject->parent_subject_id);
    //     }
    //     if(!empty($parentsub)) {
    //     $parentsub = array_unique($parentsub); 
    //     foreach($parentsub as $sub) {
    //         $couseArr = $this->common->get_from_tablerow('mm_subjects', array('subject_id'=>$sub));
    //         array_push($courseArr, $couseArr['course_id']);
    //     }
    //     }
    // }
    // if(!empty($courseArr)) {
    //     $courseArr = array_unique($courseArr); 
    // }
    
    // $datax = $this->student_model->fetch_data_teacher($filter_exam, $filter_course, $courseArr);  
    // echo $this->db->last_query();  
    // } else {
    $datax = $this->student_model->fetch_data($filter_exam,$filter_course);
    //}
    $output .= '
    <div class="table-responsive table_language" style="margin-top:15px;">
    <table id="syllabus_data" class="table table-striped table-sm selectstatus" style="width:100%">
        <thead>
            <tr>
                <th width="50">'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('exam').'</th>
                <th>'.$this->lang->line('name').'</th>
                <th>'.$this->lang->line('contact.no').'</th>
                <th>'.$this->lang->line('course').'</th>
                <th>'.$this->lang->line('hallticket').'</th>
                <th>'.$this->lang->line('status').'</th>
            </tr>
        </thead>
        ';
    if($datax->num_rows() > 0){
        $i=1;
        foreach($datax->result() as $row){
            if($row->status != '') {
                if($row->status == 1){
                    $selectData = ' <option selected value="1">Passed</option>
                                    <option value="2">Failed</option>';    
                }else if($row->status == 0){
                    $selectData = ' <option value="1">Passed</option>
                                    <option selected value="2">Failed</option>';
                }
            }else{
                $selectData = ' <option selected value="0">Select Status</option>
                                <option value="1">Passed</option>
                                <option value="2">Failed</option>';
            }
            $output .= '
                        <tr>
                        <td>'.$i.'</td>
                        <td>'.$row->exam_name.'</td>
                        <td>'.$row->student_name.'</td>
                        <td>'.$row->contact_number.'</td>
                        <td>'.$row->class_name.'</td>
                        <td>'.$row->hall_tkt.'</td>
                        <td>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status_'.$row->student_id.'" onchange="get_val('.$row->student_id.')">
                                    '.$selectData.'
                                    </select>
                                </div>
                            </div>
                        </td>
                        </tr>';
                        $i++;
                        // <td>
                        //     <form class="form-inline " >
                        //         <div class="form-group customtxtbx">
                        //             <input type="text" class="form-control" name="hall_tkt" id="hall_tkt" value="'.$row->hall_tkt.'">
                        //         </div>
                        //     </form>
                        // </td>
                        // <td>
                        //     <button type="submit" class="btn btn-success  btn_save btn_add_call btn-sm" id="submitForm'.$filter_exam.'" onclick="submitForm('.$filter_exam.')">Save</button>
                        // </td>
                    }
            $output .=' </table>
            </div>';
    }
    $output .= '<button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
                    <i class="fa fa-upload"></i> Export
                </button>';
    echo $output;
}

function export_hallticket(){
        $filter_exam = $this->input->post('filter_exam');
        $filter_course = $this->input->post('filter_course');
        // show($_POST);
        $data = $this->student_model->fetch_data($filter_exam,$filter_course);
        if($data->num_rows() > 0){
        $filename      = 'report.pdf';
        $pdfFilePath = FCPATH."/uploads/".$filename; 
        $dataArr['examArr'] = $data->result_array();
        // show($dataArr['examArr']);
        $this->data['examArr']=$this->student_model->get_exam_list();
        $dataArr['examArrpdf'] = $data->result_array();
        // show($dataArr['examArr']);
        $html = $this->load->view('admin/hallticket_export',$dataArr ,TRUE);
        ini_set('memory_limit','128M'); // boost the memory limit if it's low ;)
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter('<div style="text-align:center;"><img src="./assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure ;)
        $pdf->AddPage('L');
        $pdf->WriteHTML($html); // write the HTML into the PDF
        // $pdf->AddPage('P');
        $pdf->Output($filename, "D"); // save to file because we can
    }else{
        $this->session->set_userdata('toaster_error', "Add atleast one Hall Ticket");
        redirect(base_url() . 'backoffice/hallticket','refresh');
    }
}

public function get_val(){
    if($_POST){
        $id = $this->input->post('id');
        $selectid = $this->input->post('selectid');
        $data['status'] = $selectid;
        $res = $this->student_model->edit_examlist($data, $id);
        if($res=1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $id, 'web_examlist','Student exam list updated');
        }
        print_r($res);

    }
}

public function get_exam()
{
    if($_POST){
        $id = $this->input->post('id');
        $selectid = $this->input->post('selectid');
        $data['filter_course'] = $selectid;
        $res = $this->student_model->edit_examlist($data, $id);
        if($res=1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $id, 'web_examlist','Student exam list updated');
        }
        print_r($res);

    }
}

    public function hallticket_details_ajax() 
    {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order  = $this->input->post("order");
        $output = '';
        $filter_exam = '';
        $filter_course = '';
        $filter_exam = $this->input->post('filter_exam');
        $filter_course = $this->input->post('filter_course');
        $col    = 0;
        $dir    = "";
        if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
        // show($col);
        // show($col);
        $columns_valid = array(
            "web_examlist.examlist_id", 
            "web_notifications.exam_name", 
            "am_students.student_name", 
            "am_students.contact_number" ,
            "am_classes.class_name",          
            "web_examlist.hall_tkt" ,
            "web_examlist.status" 
        );
        if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        if(empty($this->input->post('search')['value'])){
            $list = $this->student_model->get_exam_list_by_ajax($filter_exam,$filter_course,$start, $length, $order, $dir);
        }else{
            $search = $this->input->post('search')['value'];
            $list=$this->student_model->get_exam_list($filter_exam,$filter_course); 
        }
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {
            if($rows['status']==1){
                $status = ' <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status_'.$rows['examlist_id'].'" onchange="get_val('.$rows['examlist_id'].')">
                                        <option selected value="1">Passed</option>
                                        <option value="0">Failed</option>
                                    </select>
                                </div>
                            </div>';
            }else if($rows['status']==2) {
                $status = ' <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status_'.$rows['examlist_id'].'" onchange="get_val('.$rows['examlist_id'].')">
                                        <option value="1">Passed</option>
                                        <option selected value="2">Failed</option>
                                    </select>
                                </div>
                            </div>';
            }
            else{
                $status = ' <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status_'.$rows['examlist_id'].'" onchange="get_val('.$rows['examlist_id'].')">
                                        <option selected value="0">Select Status</option>
                                        <option value="1">Passed</option>
                                        <option value="2">Failed</option>
                                        </select>
                                        </div>
                                    </div>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['exam_name'];
            $row[] = $rows['student_name'];
            $row[] = $rows['contact_number'];
            $row[] = $rows['class_name'];
            $row[] = $rows['hall_tkt'];
            $row[] = $status;
            $data[] = $row;
        }
        $total_rows=$this->student_model->get_num_exams_by_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        //   show($output);
        echo json_encode($output);
        exit();
    }

    public function get_all_exam_details_cc()
    {
        // show($_POST);
        $selected = $_POST['selected'];
        $filter_course  = $this->input->post('filter_course');
        $exams   = $this->student_model->get_all_exams($filter_course);
            echo '<option value="">Select Exam</option>';
             foreach($exams as $row){ 
                echo '<option value="'.$row->notification_id.'" >'.$row->exam_name.'</option>';
            }
    }

  
 public function status_change_student()
 {
    if($_POST)
     {
       
         $id=$this->input->post('id');
         $status=$this->input->post('status');
         if($status == 1)
            {
            $this->Common_model->update('am_students', array("status"=>1),array("student_id"=>$id)); 
            $this->Common_model->update('am_users', array("user_status"=>1),array("user_primary_id"=>$id)); 
            $this->admittapprovalprocess($id);
            } elseif($status == 5)
            { 
            $this->Common_model->update('am_users', array("user_status"=>0),array("user_primary_id"=>$id));   
            }
            $ajax_response['st']=1;
            $ajax_response['msg']="Successfuly changed status";
    //       $previous_status=$this->common->get_name_by_id('am_students','status',array("student_id"=>$id));
      
    //      if($previous_status != $status)
    //      {
    //           if($status == "5")//inactivate
    //          {
    //             $reason=$this->input->post('description');
    //          }
    //          else if($status == "1")//activate
    //          {
    //              $reason="";
    //              $old_status=$this->common->get_name_by_id('am_student_status','previous_status',array("student_id"=>$id));
    //              $status=$old_status;                
    //          }
    //           $data=array(
    //                      "student_id"=>$id,
    //                      "previous_status"=>$previous_status,
    //                      "current_status"=>$status,
    //                      "reason"=>$reason,
    //                );  
    //      $response=$this->Common_model->insert('am_student_status',$data);
    //          if($response)
    //          {
    //              $res=$this->Common_model->update('am_students', array("status"=>$status),array("student_id"=>$id)); 
    //                  if($res)
    //                  {
    //                      if($status == "1")
    //                      {
    //                         $this->Common_model->update('am_students', array("status"=>1),array("student_id"=>$id)); 
    //                         $this->Common_model->update('am_users', array("user_status"=>1),array("user_primary_id"=>$id)); 
    //                         $this->admittapprovalprocess($id);
    //                      }
    //                      elseif($status == "5")
    //                      {
    //                        $this->Common_model->update('am_users', array("user_status"=>0),array("user_primary_id"=>$id));   
    //                      }
    //                     $ajax_response['st']=1;
    //                     $ajax_response['msg']="Successfuly changed status";
    //                  }
    //                  else
    //                  {
    //                    $ajax_response['st']=0;
    //                    $ajax_response['msg']="Something went wrong,please try again later..!";  
    //                  }
    //          }
    //          else
    //          {
    //            $ajax_response['st']=0;
    //            $ajax_response['msg']="Something went wrong,please try again later..!";  
    //          }
    //      }
    //     else
    //     {
    //        $ajax_response['st']=2;
    //        $ajax_response['msg']="No Changes";   
    //     }
    // }
      } else
     {
       $ajax_response['st']=0;
       $ajax_response['msg']="Something went wrong,please try again later..!";  
     }
     print_r(json_encode($ajax_response));
 }
    
    public function load_student_ajax(){
        $role = $this->session->userdata['role'];
    if($role=='faculty') {
    $user_id =    $this->session->userdata['user_id'];
    $subjectArr = $this->common->get_from_tableresult('am_faculty_subject_mapping', array('staff_id'=>$user_id));
    $parentsub = [];
    $courseArr = [];
    if(!empty($subjectArr)) {
        foreach($subjectArr as $subject){
            array_push($parentsub, $subject->parent_subject_id);
        }
        if(!empty($parentsub)) {
        $parentsub = array_unique($parentsub); 
        foreach($parentsub as $sub) {
            $couseArr = $this->common->get_from_tablerow('mm_subjects', array('subject_id'=>$sub));
            array_push($courseArr, $couseArr['course_id']);
        }
        }
    }
    if(!empty($courseArr)) {
        $courseArr = array_unique($courseArr); 
    }
    $studentArr = $this->student_model->get_student_list($courseArr);  
    echo $this->db->last_query();  
    } else {
        $studentArr = $this->student_model->get_student_list();  
    }
        $html = '<thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('application.no').'</th>
                        <th>'.$this->lang->line('name').'</th>
                        <th>'.$this->lang->line('emailid').'</th>
                        <th>'.$this->lang->line('contact.no').'</th>
                        <th>'.$this->lang->line('location').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th>'.$this->lang->line('idcard_status').'</th>
                        <th style="width:15%">'.$this->lang->line('action').'</th> 
                    </tr>
                </thead>';
        $html .= '<tbody>';
        if(!empty($studentArr)){
            $i=1; 
            foreach($studentArr as $row){
                if($row['status']==1){
                    $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$row['student_id'].')"><span class="admitted">Admitted</span></a>';
                }else if($row['status']==2){
                    $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$row['student_id'].')"><span class="paymentcompleted">Fee Paid</span></a>';
                }else if($row['status']==4){ 
                    $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$row['student_id'].')"><span class="batchchanged">Batch Changed</span></a>';
                }else if($row['status']==5){
                    $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$row['student_id'].')"><span class="inactivestatus">Inactive</span></a>';
                }else if($row['status']==0 && $row['verified_status']==1){
                    $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$row['student_id'].')"><span class="paymentpending">Payment Pending</span></a>';
                }else{
                    $status= '<a title="Click here to change the status" style="cursor:pointer" onclick="change_student_status('.$row['student_id'].')"><span class="registered">Registered</span></a>';
                }
                $blacklist_status="";
                // if($row['caller_id']>0){
                //     $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$row['caller_id']));
                //     if(!empty($callcentre['call_status'])){
                //         $ccstatus = $callcentre['call_status'];
                //         if($ccstatus==4){ 
                //             $blacklist_status= '<span class="inactivestatus" style="margin-top:3px;">blacklist</span>';
                //         }
                //     }
                // }
                $blacklist_status="";
                if($row['idcard_status']==1){
                    $id_status = '<span class="iddownload" style="margin-top:3px;">Downloaded</span>';
                }else{
                    $id_status =  '<span class="idpending" style="margin-top:3px;">Pending</span>';
                }
                $html .= '<tr ><td >'.$i.'</td>
                            <td>'.$row['registration_number'].'</td>
                            <td >'.$row['name'].'</td>
                            <td >'.$row['email'].'</td>
                            <td >'.$row['contact_number'].'</td>
                            <td >'.$row['street'].'</td>
                            <td >'.$status."".$blacklist_status.'</td>
                            <td>'.$id_status.'</td>
                            <td style="width:15%">
                                <a href ="'.base_url('backoffice/view-student/'.$row['student_id']).'" id="#view_student" >
                                    <button class="btn btn-default option_btn " title="View" onclick="view_studentdata('. $row['student_id'].')">
                                        <i class="fa fa-eye "></i>
                                    </button>
                                </a>
                                <a href ="'.base_url('backoffice/print-application/'.$row['student_id']).'" target="_blank">
                                    <i class="fa fa-download"></i>
                                </a>
                                <a class="btn btn-primary btn-sm btn_details_view" href="'.base_url().'backoffice/manage-students/'. $row['student_id'].'">
                                    Details
                                </a>
                            </td>
                        </tr>';
                $i++; 
            }
        }
        $html .= '</tbody>';
        echo $html;
    }

//-----------------------------------MANAGE MENTOR--------------------------------------------------//    
    public function mentor(){
        check_backoffice_permission('manage_mentor');
        $this->data['page']="admin/mentor";
        $this->data['menu']="students";
        $this->data['breadcrumb']="Mentor";
        $this->data['menu_item']="backoffice/mentor";
        $this->data['usersArr']=$this->common->get_staff_list_by_roles();
        $this->data['centreArr']      = $this->common->get_from_tableresult('am_institute_master',array('institute_type_id'=>3,'status'=>1));
        $this->load->view('admin/layouts/_master',$this->data);
    }

    public function get_centercoursemapping()
    {
        $center_id = $this->input->post('center_id');
        $subArr=$this->institute_model->get_allcoursebycenter($center_id);
        echo '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row){
                echo '<option value="' . $row->class_id . '" >' . $row->class_name . '</option>';
            }
        }
    }

    public function edit_get_centercoursemapping()
    {
        $centre_id = $this->input->post('centre_id');
        $subArr=$this->institute_model->get_allcoursebycenter($centre_id);
        echo '<option value="">Select</option>';
        if(!empty($subArr)){
            foreach ($subArr as $row){
                echo '<option value="' . $row->class_id . '" >' . $row->class_name . '</option>';
            }
        }
    }
    
    public function get_batches_byCourse()
    {
        $select= '';
        if($_POST){   
            $course_id=$this->input->post('course_id');
            $center=$this->input->post('center');
            $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches=$this->common->get_alldata('am_batch_center_mapping',array("institute_course_mapping_id"=>$institute_course_mapping_id,"batch_status"=>1));
            echo '<option value="">Select</option>';
            if(!empty($batches)){
                foreach($batches as $val){
                    $select.='<option value="'.$val["batch_id"].'">'.$val["batch_name"].'</option>';  
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }

    public function edit_get_batches_byCourse()
    {
        $select= '';
        if($_POST){   
            $course_id=$this->input->post('course_id');
            $center=$this->input->post('center');
//  echo "fgdgd";
//  echo $center;            
// die();
            $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches=$this->common->get_alldata('am_batch_center_mapping',array("institute_course_mapping_id"=>$institute_course_mapping_id,"batch_status"=>1));
            // echo '<option value="">Select</option>';
            if(!empty($batches)){
                foreach($batches as $val){
                    $select.='<option value="'.$val["batch_id"].'">'.$val["batch_name"].'</option>';  
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }

    public function get_batchesss_byCourse()
    {
        $select= '';
        if($_POST){   
            $course_id=$this->input->post('course_id');
            $center=$this->input->post('center');
            $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches=$this->common->get_alldata('am_batch_center_mapping',array("institute_course_mapping_id"=>$institute_course_mapping_id,"batch_status"=>1));
            // echo '<option value="">Select</option>';
            if(!empty($batches)){
                foreach($batches as $val){
                    $select.='<option value="'.$val["batch_id"].'">'.$val["batch_name"].'</option>';  
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }

    public function get_mentors_byBatch()
    {
        $select= '';
        if($_POST){   
            $batch_id   = $this->input->post('batch_id');
            $course_id  = $this->input->post('course_id');
            $center     = $this->input->post('center');
            $institute_course_mapping_id = $this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches                     = $this->common->get_name_by_id('am_batch_center_mapping','batch_id',array("institute_course_mapping_id"=>$institute_course_mapping_id,'batch_id'=>$batch_id,'batch_status'=>1));
            $usersArr=$this->student_model->get_staff_list_by_roles();
            if(!empty($usersArr)){
                foreach($usersArr as $val){
                    if($val['role']=='management' || $val['role']=='faculty' || $val['role']=='centerhead'){ 
                        $select.='<option value="'.$val["personal_id"].'">'.$val["name"].'</option>';  
                    }
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }

    public function edit_get_mentors_byBatch()
    {
        $select= '';
        if($_POST){   
            $batch_id   = $this->input->post('batch_id');
            $course_id  = $this->input->post('course_id');
            $center     = $this->input->post('center');
            $institute_course_mapping_id = $this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches                     = $this->common->get_name_by_id('am_batch_center_mapping','batch_id',array("institute_course_mapping_id"=>$institute_course_mapping_id,'batch_id'=>$batch_id,'batch_status'=>1));
            $usersArr=$this->student_model->get_staff_list_by_roles();
            if(!empty($usersArr)){
                foreach($usersArr as $val){
                    if($val['role']=='management' || $val['role']=='faculty' || $val['role']=='centerhead'){ 
                        $select.='<option value="'.$val["personal_id"].'">'.$val["name"].'</option>';  
                    }
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }
    
    public function edit_get_rooms_byBatch()
    {
        $select= '';
        if($_POST){   
            $batch_id   = $this->input->post('batch_id');
            $course_id  = $this->input->post('course_id');
            $center     = $this->input->post('center');
            // print_r($room_id."vv");
            $institute_course_mapping_id = $this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches                     = $this->common->get_name_by_id('am_batch_center_mapping','batch_id',array("institute_course_mapping_id"=>$institute_course_mapping_id,'batch_id'=>$batch_id,'batch_status'=>1));
            $usersArr=$this->student_model->edit_get_classrooms($batches);
            // echo $this->db->last_query();
            // echo '<pre>';
            // print_r($usersArr);
            echo '<option value="">Select</option>';
            if(!empty($usersArr)){
                foreach($usersArr as $val){
                    $select.='<option value="'.$val->room_id.'" >'.$val->classroom_name.'</option>';  
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }

 

    public function get_student_list()
    {
       $html='  <thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('application.no').'</th>
                        <th>'.$this->lang->line('student_name').'</th>
                        <th>
                            <label class="custom_checkbox">'.$this->lang->line('action').'
                            <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                            <span class="checkmark"></span>
                            </label>
                        </th>
                    </tr>
                </thead>';
        if($_POST){ 
            $where=array();
            $centre_id=$this->input->post('centre_id');
            if($centre_id !=""){
                $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("institute_master_id"=>$centre_id));
                $where['am_student_course_mapping.institute_course_mapping_id']=$institute_course_mapping_id;   
            }
            $course_id=$this->input->post('course_id');
            if($course_id!=""){
                $where['am_student_course_mapping.course_id']=$course_id;   
            }
            $batch_id=$this->input->post('batch_id');
            if($batch_id!=""){
                $where['am_student_course_mapping.batch_id']=$batch_id;   
            }
            $where['am_students.status']=1;
            $student_details=$this->student_model->get_student_list_msg($where);
            // echo $this->db->last_query();
            // echo '<pre>';
            // print_r($student_details);
            // die();
            if(!empty($student_details)){ 
                $i=1;
                foreach($student_details as $row){
                    $html.='<tr>
                                <td style="padding: .75rem!important;">'.$i.'</td>
                                <td style="padding: .75rem!important;">'.$row['registration_number'].'</td>
                                <td style="padding: .75rem!important;">'.$row['name'].'</td>
                                <td style="padding: .75rem!important;"><label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                                    <input type="checkbox" checked="checked" id="main" class="all_student" name="student_id[]" value="'.$row['student_id'].'" />
                                    <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>';
                    $i++;
                }
            }
        }
        echo $html;
    }

    public function mentor_add()
    {
        if($_POST){
            $student_ids=$this->input->post('student_id');
            $staff_id=$this->input->post('staff_id');
            if($staff_id != "" && !empty($student_ids)){
                foreach($student_ids as $key=>$item){
                    $exist=$this->student_model->is_mentor_exist($student_ids[$key]);
                    if($exist == 0){
                        $data=array(
                            'staff_id'         => $staff_id,
                            'student_id'       => $student_ids[$key]
                        );
                        $response=$this->student_model->mentor_add($data);
                        $ajax_response['st']=1;
                        $ajax_response['msg']="Successfully Assigned to Mentor";  
                    }else{
                        $ajax_response['st']=3; //already exist
                        $ajax_response['msg']='Student already Assigned to a Mentor';

                    }
                }
            }else{
               $ajax_response['st']=2;
               $ajax_response['msg']="Please choose atleast one student"; 
            }
            print_r(json_encode($ajax_response));
        }
    }
    
    public function mentors_meeting(){
        $this->data['page']         = "admin/mentors_meeting";
        $this->data['menu']         = "students";
        $this->data['breadcrumb']   = "Mentors Meeting";
        $this->data['menu_item']    = "mentor";
        $this->data['centreArr']    = $this->common->get_from_tableresult('am_institute_master',array('institute_type_id'=>3,'status'=>1));
        $this->load->view('admin/layouts/_master',$this->data);
    }

    public function get_student_list_byMentor()
    {
       $html='  <thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('application.no').'</th>
                        <th>'.$this->lang->line('student_name').'</th>
                        <th>
                            <label class="custom_checkbox">'.$this->lang->line('action').'
                            <input type="checkbox" checked="checked" onclick="check_all()" id="main" >
                            <span class="checkmark"></span>
                            </label>
                        </th>
                    </tr>
                </thead>';
        if($_POST){ 
            $where=array();
            $centre_id=$this->input->post('centre_id');
            if($centre_id !=""){
                $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("institute_master_id"=>$centre_id));
                $where['am_student_course_mapping.institute_course_mapping_id']=$institute_course_mapping_id;   
            }
            $course_id=$this->input->post('course_id');
            if($course_id!=""){
                $where['am_student_course_mapping.course_id']=$course_id;   
            }
            $batch_id=$this->input->post('batch_id');
            if($batch_id!=""){
                $where['am_student_course_mapping.batch_id']=$batch_id;   
            }
            $where['am_students.status']=1;
            $student_details=$this->student_model->get_student_list_byMentor($where);
            // echo $this->db->last_query();
            // echo '<pre>';
            // print_r($student_details);
            // die();
            if(!empty($student_details)){ 
                $i=1;
                foreach($student_details as $row){
                    $html.='<tr>
                                <td style="padding: .75rem!important;">'.$i.'</td>
                                <td style="padding: .75rem!important;">'.$row['registration_number'].'</td>
                                <td style="padding: .75rem!important;">'.$row['name'].'</td>
                                <td style="padding: .75rem!important;"><label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                                    <input type="checkbox" checked="checked" id="main" class="all_student" name="student_id[]" value="'.$row['student_id'].'" />
                                    <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>';
                    $i++;
                }
            }
        }
        echo $html;
    }

    public function edit_get_student_list_byMentor()
    {
        // echo "jkj";
       $html='  <thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('application.no').'</th>
                        <th>'.$this->lang->line('student_name').'</th>
                        <th>
                            <label class="custom_checkbox">'.$this->lang->line('action').'
                            <input type="checkbox" checked="checked" onclick="edit_check_all()" id="edit_main" >
                            <span class="checkmark"></span>
                            </label>
                        </th>
                    </tr>
                </thead>';
        if($_POST){ 
            $where=array();
            $centre_id=$this->input->post('centre_id');
            if($centre_id !=""){
                $institute_course_mapping_id=$this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("institute_master_id"=>$centre_id));
                $where['am_student_course_mapping.institute_course_mapping_id']=$institute_course_mapping_id;   
            }
            $course_id=$this->input->post('course_id');
            if($course_id!=""){
                $where['am_student_course_mapping.course_id']=$course_id;   
            }
            $batch_id=$this->input->post('batch_id');
            if($batch_id!=""){
                $where['am_student_course_mapping.batch_id']=$batch_id;   
            }
            $where['am_students.status']=1;
            $student_details=$this->student_model->edit_get_student_list_byMentor($where);
            // echo $this->db->last_query();
            // echo '<pre>';
            // print_r($student_details);
            // die();
            if(!empty($student_details)){ 
                $i=1;
                foreach($student_details as $row){
                    $html.='<tr>
                                <td style="padding: .75rem!important;">'.$i.'</td>
                                <td style="padding: .75rem!important;">'.$row['registration_number'].'</td>
                                <td style="padding: .75rem!important;">'.$row['name'].'</td>
                                <td style="padding: .75rem!important;"><label  style="margin:0 important;margin-top:-8px!important;" class="custom_checkbox">
                                    <input type="checkbox" checked="checked" id="edit_main" class="all_student" name="student_id[]" value="'.$row['student_id'].'" />
                                    <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>';
                    $i++;
                }
            }
        }
        echo $html;
    }

    public function get_rooms_byBatch()
    {
        $select= '';
        if($_POST){   
            $batch_id   = $this->input->post('batch_id');
            $course_id  = $this->input->post('course_id');
            $center     = $this->input->post('center');
            $institute_course_mapping_id = $this->common->get_name_by_id('am_institute_course_mapping','institute_course_mapping_id',array("course_master_id"=>$course_id,'status'=>1,'institute_master_id'=>$center));
            $batches                     = $this->common->get_name_by_id('am_batch_center_mapping','batch_id',array("institute_course_mapping_id"=>$institute_course_mapping_id,'batch_id'=>$batch_id,'batch_status'=>1));
            $usersArr=$this->student_model->get_classrooms($batches);
            // echo $this->db->last_query();
            // echo '<pre>';
            // print_r($usersArr);
            // die();
            // echo '<option value="">Select</option>';
            if(!empty($usersArr)){
                foreach($usersArr as $val){
                    $select.='<option value="'.$val["room_id"].'">'.$val["classroom_name"].'</option>';  
                }
            }else{
                $select.= '<option value="">Select</option>'; 
            }
        }
        print_r($select);
    }

   

    public function mentors_meeting_add()
    {
        $data['centre_id']  = $this->input->post('centre_id');
        $data['course_id']  = $this->input->post('course_id');
        $data['batch_id']   = $this->input->post('batch_id');
        $data['staff_id']   = $this->input->post('staff_id');
        $data['date']       = $this->input->post('date');
        $data['time']       = date('H:i:s',strtotime($this->input->post('time')));
        $data['room_id']    = $this->input->post('room_id');
        $meeting_id         = $this->student_model->insert_meeting($data);
        if ($meeting_id) {
            $meeting_idArr       = $meeting_id;
            $student_idArr       = $this->input->post('student_id');
            $detailsArr          = array();
            if (!empty($student_idArr)) {
                foreach ($student_idArr as $key => $val) {
                    if (!empty($student_idArr[$key])) {
                        $tempArr = array(
                            'student_id' => $student_idArr[$key],
                            'meeting_id' => $meeting_idArr
                        );
                        array_push($detailsArr, $tempArr);
                    }
                }
            }
            if (!empty($detailsArr)) {
                $res = $this->student_model->details_add($detailsArr);
            }
        }
        if($res = 1){
            $what = $this->db->last_query();
            $table_row_id = $this->db->insert_id();

            $query = $this->db->select('*');
            $query	=	$this->db->get('am_mentor_meeting');
            $row_id= $query->num_rows();

            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('insert', 'database', $who, $what, $table_row_id, 'am_mentor_meeting', 'Mendor meeting scheduled for student');
        }
        print_r($res);
    }

    public function mentors_meeting_edit()
    {
        $data['centre_id']  = $this->input->post('centre_id');
        $data['course_id']  = $this->input->post('course_id');
        $data['batch_id']   = $this->input->post('batch_id');
        $data['staff_id']   = $this->input->post('staff_id');
        $data['date']       = $this->input->post('date');
        $data['time']       = date('H:i:s',strtotime($this->input->post('time')));
        $data['room_id']    = $this->input->post('room_id');
        $meeting_id         = $this->input->post('meeting_id');
        $update         = $this->student_model->edit_meeting($data,$meeting_id);
        echo $this->db->last_query();

        if ($update) {
            $meeting_idArr       = $meeting_id;
            $student_idArr       = $this->input->post('student_id');
            $detailsArr          = array();
            if (!empty($student_idArr)) {
                foreach ($student_idArr as $key => $val) {
                    if (!empty($student_idArr[$key])) {
                        $tempArr = array(
                            'student_id' => $student_idArr[$key],
                            'meeting_id' => $meeting_idArr
                        );
                        array_push($detailsArr, $tempArr);
                    }
                }
            }
            if (!empty($detailsArr)) {
                $res = $this->student_model->update_details_batch($detailsArr);
            }
        }
        if($res = 1){
            $what = $this->db->last_query();
            $table_row_id = $this->db->insert_id();

            $query = $this->db->select('*');
            $query	=	$this->db->get('am_mentor_meeting');
            $row_id= $query->num_rows();

            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $table_row_id, 'am_mentor_meeting'.'Mendor meeting schedule edited');
        }
        print_r($res);
    }

    public function mentors_meeting_list(){
        $this->data['page']         = "admin/mentors_meeting_list";
        $this->data['menu']         = "students";
        $this->data['breadcrumb']   = "Mentors Meeting";
        $this->data['menu_item']    = "mentor";
        $this->data['meetingArr']   = $this->student_model->get_meeting_list();
        $this->load->view('admin/layouts/_master',$this->data);
    }

    public function get_meetings_by_id($meeting_id){
        $this->data['meetings']= $this->student_model->get_meetings_by_id($meeting_id);
        // echo '<pre>';
        // print_r($this->data['meetings']);
        // die();
        $edit_transport_id = $this->input->post('edit_meeting_id');
        $this->db->select('*');
        $this->db->where('meeting_id',$meeting_id);
        $query = $this->db->get('am_mentor_meeting_details')->result_array();
        $this->data['meetings_details']=$this->student_model->get_meeting_details_by_id($meeting_id);
        // echo '<pre>';
        // print_r($this->data['meetings_details']);
        // die();
        print_r(json_encode($this->data));
    }

    function print_application($id){
        $filename      = 'report.pdf';
        $pdfFilePath = FCPATH."/uploads/".$filename; 
        $dataArr['studentArr']   = $this->student_model->get_stud_det($id);
        $dataArr['studentArr']['date_of_birth'] = date('d-M-Y', strtotime($dataArr['studentArr']['date_of_birth']));
        // show($dataArr['studentArr']);
        $dataArr['qualificationArr']   = $this->student_model->get_studentqualification($id);

        //  echo '<pre>';
        //  print_r($dataArr['studentArr']);
        //  die();
        $html = $this->load->view('admin/application_form',$dataArr ,TRUE);
        ini_set('memory_limit','512M'); // boost the memory limit if it's low 
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetFooter('<div style="text-align:center;"></div>'); // Add a footer for good measure 
        $pdf->WriteHTML($html);
        //$pdf->Output("notes.pdf", 'F');
        $pdf->Output();
    }

    public function sendbatchnotification($batchnotify = NULL) { 
        $vecantseats    = $batchnotify['batch_capacity']-$batchnotify['student_registered']; 
        $center_id      = $batchnotify['center'];
        $branch_id      = $batchnotify['branch']; 
        $branch_name    = '';
        $headsArr       = [];
        $headsmobArr    = [];
        $center_name    = '';
        if($center_id>0) {
            $branch         = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$branch_id)); //print_r($branch);
            if(!empty($branch)) {
                $branch_name =   $branch['institute_name'];
            }
            $centerheads = $this->student_model->staff_centre_branch($center_id); //('am_staff_personal', array('center'=>$center_id,'role'=>'centerhead'));
            if(!empty($centerheads)) {
                foreach($centerheads as $head) {
                    array_push($headsArr, $head->email);  
                    array_push($headsmobArr, $head->mobile); 
                    $center_name =  $head->institute_name; 
                }
            }
        } 
        $type=$batchnotify['batch_name']." Batch status alert";
        if(!empty($batchnotify) && $batchnotify['status']==90){
            $config				=	$this->home_model->get_config(); 
            if(!empty($config)) {
            $emailArr = explode(',', $config['bcnotify']);
            if(!empty(array_filter($emailArr))) {
              $newArr = array_merge($emailArr, $headsArr);
            foreach($newArr as $email) {
            $data = email_header();
            $data.='<tr style="background:#f2f2f2">
                    <td style="padding: 20px 0px">
                        <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear </h3>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">90% of students admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.</p>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total Seats            : '.$batchnotify['batch_capacity'].'</p>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total student admitted : '.$batchnotify['student_registered'].'</p>
                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Vacant seats           : '.$vecantseats.'</p>
                    </td>
                </tr>';
            $data.=email_footer();
            $this->send_email($type,$email,$data);
            }
        }
        $smsArr = explode(',', $config['bcnotifysms']);
        if(!empty(array_filter($smsArr))) {
            $smsnewArr = array_merge($smsArr, $headsmobArr);
            foreach($smsnewArr as $mob_number) { 
        $message = '90% of student admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.';
        send_sms($mob_number,$message);
            }
        }
        }
        } else if(!empty($batchnotify) && $batchnotify['status']==100){
            $config				=	$this->home_model->get_config(); 
            if(!empty($config)) {
            $emailArr = explode(',', $config['bcnotify']);
            if(!empty(array_filter($emailArr))) {
                $newArr = array_merge($emailArr, $headsArr);
            foreach($newArr as $email) {
            $data = email_header();
            $data.='<tr style="background:#f2f2f2">
                <td style="padding: 20px 0px">
                <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Details </h3>
                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">100% of students admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.</p>
                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total Seats            : '.$batchnotify['batch_capacity'].'</p>
                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Total student admitted : '.$batchnotify['student_registered'].'</p>
                <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">Vacant seats           : '.$vecantseats.'</p>
            </td>
            </tr>';
            $data.=email_footer();
            $this->send_email($type,$email,$data);
            }
        }
        $smsArr = explode(',', $config['bcnotifysms']);
        if(!empty(array_filter($smsArr))) {
            $smsnewArr = array_merge($smsArr, $headsmobArr);
            foreach($smsnewArr as $mob_number) { 
        $message = '100% of student admitted in '.$batchnotify['batch_name'].', '.$center_name.', '.$branch_name.'. Kindly do the needful.';
        send_sms($mob_number,$message);
            }
        }
    }
        }
    }


public function testbatchfull($batch_id = NULL){
    $batchnotify = $this->common->get_batch_allocation($batch_id); //print_r($batchnotify);
           if($batchnotify['status']!=0) {
               $this->sendbatchnotification($batchnotify);
           } 
}

public function getpass($password = 123456) {
    echo $password.'<br>';  //=mt_rand(100000,999999);
    echo $encrypted_password= $this->Auth_model->get_hash($password);
}



public function users_password_reset() {
    //check_backoffice_permission('Users-password-reset');
    $this->data['page']           ="admin/users_password_reset";
    $this->data['menu']           ="students";
    $this->data['breadcrumb']     ="Users Password Reset";
    $this->data['menu_item']      ="Users-password-reset";
    $this->data['batch']          = $this->student_model->get_batch_list('am_batch_center_mapping');
    $this->load->view('admin/layouts/_master',$this->data);
}



public function get_batch_student() {
    $batch_id = $this->input->post('id');
    $students = $this->student_model->get_batch_student($batch_id); 
    // show($students);
    if(!empty($students)) {
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('name').'</th>
                        <th >'.$this->lang->line('applicationno').'</th>
                        <th >'.$this->lang->line('email').'</th>
                        <th >'.$this->lang->line('mobileno').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
            $i=1; 
            foreach($students as $student){
                $html.='<tr id="row_'.$student->student_id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="name_'.$student->name.'">
                                '.$student->name.'
                            </td>
                            <td id="document_'.$student->registration_number.'">
                            '.$student->registration_number.'
                                </td>
                                <td id="school_'.$student->email.'">
                                '.$student->email.'
                            </td>
                            <td id="school_'.$student->mobile_number.'">
                                    '.$student->mobile_number.'
                                </td>
                            <td>
                            <!--<button class="btn btn-success passwordreset" data-toggle="modal" data-target="#resetpassword" type="button" status="'.$student->student_id.'" alt="Student">Reset Student</button>
                            <button class="btn btn-success passwordreset" data-toggle="modal" data-target="#resetpassword" type="button" status="'.$student->student_id.'" alt="Parent" >Reset Parent</button>-->
                            <a class="btn btn-default add_row add_new_btn btn_add_call" onclick=emailPassword("'.$student->student_id.'","Student","'.$student->email.'","'.$student->guardian_number.'")>Resend Student</a>
                            &nbsp;&nbsp;<a class="btn btn-default add_row add_new_btn btn_add_call" onclick=emailPassword("'.$student->student_id.'","Parent","'.$student->email.'","'.$student->guardian_number.'")>Resend Parent</a>
                            </td>
                        </tr>';
                $i++;
            }
            $html .= '<script>
            $(".passwordreset").click(function(){
                $("#viewchangedpassword").html("");
                var id = $(this).attr("status");
                var type = $(this).attr("alt");
                $.confirm({
                    title: "Alert message",
                    content: "Do you want to reset password?",
                    icon: "fa fa-question-circle",
                    animation: "scale",
                    closeAnimation: "scale",
                    opacity: 0.5,
                    buttons: {
                        "confirm": {
                            text: "Proceed",
                            btnClass: "btn-blue",
                            action: function() {
                                $(".loader").show();
                                $.ajax({
                                    url: "'.base_url().'backoffice/Students/passwordresetuser",
                                    type: "POST",
                                    data:{'.$this->security->get_csrf_token_name().': "'.$this->security->get_csrf_hash().'","id":id,"type":type},
                                    success: function(response) {
                                        $("#viewchangedpassword").html(response);
                                        $(".loader").hide();
                                    }
                                });
                            }
                        },
                        cancel: function() {
                            $("#resetpassword").modal("toggle");
                        },
                    }
                });
            });  
            </script>';
        } else {
            $html = 0;
        }
        echo $html;
    }


    public function get_student_bysearch() {
        $applicationno = $this->input->post('id');
        $email = $this->input->post('email');
        $mobileno = $this->input->post('mobileno');
        $students = $this->student_model->get_student_bysearch($applicationno, $email, $mobileno); 
        // show($students);
        if(!empty($students)) {
            $html = '<thead> 
                        <tr>
                            <th>'.$this->lang->line('sl_no').'</th>
                            <th >'.$this->lang->line('name').'</th>
                            <th >'.$this->lang->line('applicationno').'</th>
                            <th >'.$this->lang->line('email').'</th>
                            <th >'.$this->lang->line('mobileno').'</th>
                            <th >'.$this->lang->line('action').'</th>
                        </tr>
                    </thead>';
                $i=1; 
                foreach($students as $student){
                    $html.='<tr id="row_'.$student->student_id.'">
                                <td>
                                    '.$i.'
                                </td>
                                <td id="name_'.$student->name.'">
                                    '.$student->name.'
                                </td>
                                <td id="document_'.$student->registration_number.'">
                                '.$student->registration_number.'
                                    </td>
                                    <td id="school_'.$student->email.'">
                                    '.$student->email.'
                                </td>
                                <td id="school_'.$student->mobile_number.'">
                                    '.$student->mobile_number.'
                                </td>
                                <td>
                                    <!--<button class="btn btn-success passwordreset" data-toggle="modal" data-target="#resetpassword" type="button" status="'.$student->student_id.'" alt="Student">Reset Student</button>
                                    <button class="btn btn-success passwordreset" data-toggle="modal" data-target="#resetpassword" type="button" status="'.$student->student_id.'" alt="Parent" >Reset Parent</button>-->
                                    <a class="btn btn-default add_row add_new_btn btn_add_call" onclick=emailPassword("'.$student->student_id.'","Student","'.$student->email.'","'.$student->guardian_number.'")>Resend Student</a>
                                    &nbsp;&nbsp;<a class="btn btn-default add_row add_new_btn btn_add_call" onclick=emailPassword("'.$student->student_id.'","Parent","'.$student->email.'","'.$student->guardian_number.'")>Resend Parent</a>
                                </td>
                            </tr>';
                    $i++;
                }
                $html .= '<script>
                $(".passwordreset").click(function(){
                    $("#viewchangedpassword").html("");
                    var id = $(this).attr("status");
                    var type = $(this).attr("alt");
                    $.confirm({
                        title: "Alert message",
                        content: "Do you want to reset password?",
                        icon: "fa fa-question-circle",
                        animation: "scale",
                        closeAnimation: "scale",
                        opacity: 0.5,
                        buttons: {
                            "confirm": {
                                text: "Proceed",
                                btnClass: "btn-blue",
                                action: function() {
                                    $(".loader").show();
                                    $.ajax({
                                        url: "'.base_url().'backoffice/Students/passwordresetuser",
                                        type: "POST",
                                        data:{'.$this->security->get_csrf_token_name().': "'.$this->security->get_csrf_hash().'","id":id,"type":type},
                                        success: function(response) {
                                            $("#viewchangedpassword").html(response);
                                            $(".loader").hide();
                                        }
                                    });
                                }
                            },
                            cancel: function() {
                                $("#resetpassword").modal("toggle");
                            },
                        }
                    });
                });  
                </script>';
            } else {
                $html = 0;
            }
            echo $html;
        }

    


function passwordresetuser() {
    $student = $this->input->post('id');
    $type = $this->input->post('type');
    if($student !='' && $type!='') {
        $studentArr = $this->student_model->get_stud_det($student);
        if($type=='Student') {
            $password           = mt_rand(100000,999999);
            $encrypted_password = $this->Auth_model->get_hash($password);
            $dataArr            = array(
            'user_passwordhash'=>$encrypted_password
           );
            $this->db->where('user_primary_id',$student);
            $this->db->update('am_users',$dataArr);
            $this->gm_user_registration($studentArr['registration_number'], $password, $student);
            echo 'New password is: <h2>'.$password.'</h2>';
        } else if($type=='Parent'){
            $password           = mt_rand(100000,999999);
            $encrypted_password = $this->Auth_model->get_hash($password);
            $dataArr            = array(
            'user_passwordhash'=>$encrypted_password
           );
            $this->db->where('user_id',$studentArr['parent_id']);
            $this->db->update('am_users',$dataArr);
            echo 'New password is: <h2>'.$password.'</h2>';
        }
    } else {
        echo '<span style="color:red;">In-valid data submitted</span>';
    }

}  


function email_passwordresetuser() {
    $student = $this->input->post('id');
    $type = $this->input->post('type');
    $email = $this->input->post('email');
    $guardian_number = $this->input->post('user_username');
    if($student !='' && $type!='') {
        $studentArr = $this->student_model->get_stud_det($student);
        if($type=='Student') {
            $userdata = $this->db->where('user_primary_id',$student)->get('am_users')->row_array();
            $password = $this->Auth_model->get_pass($userdata['user_passwordhash']);
            // $password           = mt_rand(100000,999999);
            // $encrypted_password = $this->Auth_model->get_hash($password);
            // $dataArr            = array(
            //                                 'user_passwordhash'=>$encrypted_password
            //                             );
            // $this->db->where('user_primary_id',$student);
            // $this->db->update('am_users',$dataArr);
            $this->gm_user_registration($userdata['user_username'], $password, $student);
            
            $data=email_header();
            $data.='<td style="padding: 26px 26px">
				<h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
				<p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
					Hi '.$userdata['user_name'].',<br><br>
					Please find the Username and Password for your Direction account<br>
				</p>
				<p  style="font-family: Open Sans, sans-serif;font-size: 13px;line-height: 20px;background: rgba(43, 43, 43, 0.71);color: #fff;display: block;padding: 10px 20px;margin: 0px;">
					<b>Your Username  : </b>'.$userdata['user_username'].'<br/>
					<b>Your Password : </b>'.$password.'<br/>
				</p>
			</td>';
            $data.=email_footer();

            $this->email->to($email);
            $this->email->subject('Your Direction Account Details');
            $this->email->message($data);
            $this->email->send();
            send_sms($studentArr['contact_number'],'Username and Password for your Direction account. Username: '.$userdata['user_username'].'  Password: '.$password);

            $sendSt = $this->send_email("Your Direction Account Details", $email,$data);
            
            $jobdata['from']    = 'noreply@direction.com';
            $jobdata['to']      = $email;
            $jobdata['subject'] = 'Your Direction Account Details';
            $jobdata['message'] = $data;
            $jobdata['status'] = $sendSt;
            $this->db->insert('emails', $jobdata);

            $returnData['st'] 		= 1;
            $returnData['msg'] 	= 'Inform user to check registerd Email for new password.';

        } else if($type=='Parent'){
            $password           = mt_rand(100000,999999);
            $encrypted_password = $this->Auth_model->get_hash($password);
            $dataArr            = array(
                                    'user_passwordhash'=>$encrypted_password
                                );

            $data=email_header();
            $data.='<td style="padding: 26px 26px">
                <h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
                <p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
                    Hello,<br> 
                    Someone requested to reset the password for this account.<br>
                    If it was a mistake, just ignore this email.<br>
                    
                </p>
                <p  style="font-family: Open Sans, sans-serif;font-size: 13px;line-height: 20px;background: rgba(43, 43, 43, 0.71);color: #fff;display: block;padding: 10px 20px;margin: 0px;">
                    <b>Your New Password is  : </b>'.$password.'<br/>
                    
                </p>
            </td>';
            $data.=email_footer();
            $sendSt = $this->send_email("Reset Password", $email,$data);
            
            $message = "Direction changed your account password. New password is".$password;
            // send_sms($guardian_number,$message); 
            $this->db->where('user_id',$studentArr['parent_id']);
            $this->db->update('am_users',$dataArr);
            $returnData['st'] 		= 1;
            $returnData['password'] = $password;
            $returnData['msg'] 	= 'Inform parent to check SMS for new password.';
        }
    } else {
        $returnData['st'] 		= 2;
        $returnData['msg'] 	= 'In-valid data submitted';
    }
    print_r(json_encode($returnData));
}  




public function get_student_trans_search() {
    $applicationno = $this->input->post('id');
    $email = $this->input->post('email');
    $mobileno = $this->input->post('mobileno');
    $name = $this->input->post('name');
    $route = $this->input->post('route');
    $students = $this->student_model->get_student_bysearch($applicationno, $email, $mobileno, $name, $route); 
    if(!empty($students)) {
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('name').'</th>
                        <th >'.$this->lang->line('application.no').'</th>
                        <th >'.$this->lang->line('email').'</th>
                        <th >'.$this->lang->line('mobileno').'</th>
                        <th >'.$this->lang->line('route').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
            $i=1; 
            // show($students);
            if(!empty($students)){
                foreach($students as $student){
                    $html.='<tr id="row_'.$student->student_id.'">
                                <td>
                                    '.$i.'
                                </td>
                                <td id="name_'.$student->name.'">
                                    '.$student->name.'
                                </td>
                                <td id="document_'.$student->registration_number.'">
                                '.$student->registration_number.'
                                    </td>
                                    <td id="school_'.$student->email.'">
                                    '.$student->email.'
                                </td>
                                <td id="school_'.$student->mobile_number.'">
                                    '.$student->mobile_number.'
                                </td>
                                <td id="school_'.$student->route_name.'">
                                    '.$student->route_name.'
                                </td>
                                <td id="school_'.$student->mobile_number.'">';
                                if ($student->trans_status== 1) { $html.= '<span class="admitted">Active</span>';}
                                    else if($student->trans_status==2) { $html.= '<span class="paymentcompleted">Cancelled</span>';}
    
                                $html.='</td>
                                <td>
                                <a class="btn btn-primary btn-sm btn_details_view" onclick=loadpayscreen("'.$student->student_id.'","'.$student->st_id.'")>
                                Pay   
                               </a>
                                </td>
                            </tr>';
                    $i++;
                }
            }
        } else {
            $html = 0;
        }
        echo $html;
    }
    
    /* External Student Management Starts*/
    public function external_batch(){
        check_backoffice_permission("external_batch");
        $this->data['page']="admin/students/external_batch";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Manage External Batch";
        $this->data['menu_item']="external_batch";
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function load_external_batches_list(){
        $external_batches = $this->student_model->get_external_batches();
        $data = [];
        if(!empty($external_batches)){
            foreach($external_batches as $batches){
                array_push($data,[
                    'batch_id'=>$batches['batch_id'],
                    'batch_name'=>$batches['batch_name'],
                    'batch_code'=>$batches['batch_code'],
                    'batch_creationdate'=>date('d-M-Y h:i a',strtotime($batches['batch_creationdate']))
                ]);
            }
            print_r(json_encode(['st'=>1,'data'=>$data]));
        }else{
            print_r(json_encode(['st'=>0]));
        }
    }
    public function checkDuplication_add(){
        $batch = $this->input->post('batch_name');
        $batch_id = $this->input->post('batch_id');
        $query= $this->db->get_where('am_batch_center_mapping',array("batch_name"=>$batch,'institute_course_mapping_id'=>-1,'batch_id !='=>$batch_id));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function edit_ext_batch_details($batch_id){
        $external_batch = $this->student_model->get_external_batch($batch_id);
        if(!empty($external_batch)){
            $data = ['batch_name'=>$external_batch['batch_name'],
                    'batch_id'=>$external_batch['batch_id']];
            print_r(json_encode(['st'=>1,'data'=>$data]));
        }else{
            print_r(json_encode(['st'=>0]));
        }
    }

    public function add_edit_ext_batch(){
        if($_POST){
            $batch_id = $this->input->post('batch_id');
            $batch_name = $this->input->post('batch_name');
            if(empty($batch_id)){
                $batch_id = $this->student_model->get_external_batch_id();
                $data = array(
                            'batch_id'=>$batch_id,
                            'batch_code'=>'DEXT-'.date('Ym').$batch_id,
                            'batch_name'=>$batch_name,
                            'institute_course_mapping_id'=>(int)-1,
                            'batch_datefrom'=>date('Y-m-d',time()),
                            'batch_dateto'=>date('Y-m-d',strtotime('2034-12-31')),
                            'monday'=>1,
                            'tuesday'=>1,
                            'wednesday'=>1,
                            'thursday'=>1,
                            'friday'=>1,
                            'saturday'=>1,
                            'sunday'=>1,
                            'batch_status'=>-1
                        );
                $this->student_model->add_external_batch($data);
                $data = 'Batch added successfully..!';
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                $message = "New external batch created";
                logcreator('insert','database',$who,json_encode($data),0,'', $message);
            }else{
                $this->student_model->update_external_batch($batch_id,['batch_name'=>$batch_name]);
                $data = 'Batch edited successfully..!';
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                $message = "External batch edited";
                logcreator('insert','database',$who,json_encode($data),0,'', $message);
            }
            print_r(json_encode(['st'=>1,'data'=>$data]));
        }
    }

    public function delete_ext_batch($batch_id){
        $this->student_model->update_external_batch($batch_id,['batch_status'=>-2]);
        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $message = "External batch deleted";
        logcreator('insert','database',$who,'',$batch_id,'', $message);
        print_r(json_encode(['st'=>1]));
    }

    public function external_candidates(){
        check_backoffice_permission("external_candidates");
        $this->data['page']="admin/students/external_candidates";
		$this->data['menu']="students";
        $this->data['breadcrumb']="Manage External Candidates";
        $this->data['menu_item']="external_candidates";
        $this->data['batches']=$this->student_model->get_external_candidates_batch();
		$this->load->view('admin/layouts/_master',$this->data);
    }

    public function load_external_candidates_list(){
        $external_candidates = $this->student_model->get_external_candidates();
        $data = [];
        if(!empty($external_candidates)){
            foreach($external_candidates as $candidates){
                array_push($data,[
                    'student_id'=>$candidates['student_id'],
                    'name'=>$candidates['name'],
                    'email'=>$candidates['email'],
                    'contact_number'=>$candidates['contact_number'],
                    'whatsapp_number'=>$candidates['whatsapp_number'],
                    'mobile_number'=>$candidates['mobile_number'],
                    'registration_number'=>$candidates['registration_number'],
                    'batch_name'=>$candidates['batch_name']
                ]);
            }
            print_r(json_encode(['st'=>1,'data'=>$data]));
        }else{
            print_r(json_encode(['st'=>0]));
        }
    }

    public function get_ext_candidate_details($candidate_id){
        $external_candidate = $this->student_model->get_external_candidate($candidate_id);
        if(!empty($external_candidate)){
            $external_candidate['gender'] = ucfirst($external_candidate['gender']);
            $external_candidate['date_of_birth'] = (!empty(trim($external_candidate['date_of_birth'])))?date('d-m-Y',strtotime($external_candidate['date_of_birth'])):'';
            print_r(json_encode(['st'=>1,'data'=>$external_candidate]));
        }else{
            print_r(json_encode(['st'=>0]));
        }
    }

    public function edit_ext_candidate_details($candidate_id){
        $external_candidate = $this->student_model->get_external_candidate($candidate_id);
        if(!empty($external_candidate)){
            $external_candidate['date_of_birth'] = (!empty(trim($external_candidate['date_of_birth'])))?date('d-m-Y',strtotime($external_candidate['date_of_birth'])):'';
            print_r(json_encode(['st'=>1,'data'=>$external_candidate]));
        }else{
            print_r(json_encode(['st'=>0]));
        }
    }

    public function add_edit_ext_candidate(){
        if($_POST){
            $this->form_validation->set_rules('batch_id', 'External candidate`s batch', 'required');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
            //$this->form_validation->set_rules('email', 'Email ID', 'trim|required');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('district', 'Location', 'trim|required');
            // $this->form_validation->set_rules('date_of_birth', 'Date Of Birth', 'trim|required');
            // $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
            // $this->form_validation->set_rules('address', 'Address', 'trim|required');
            // $this->form_validation->set_rules('street', 'Street Name', 'trim|required');
            // $this->form_validation->set_rules('whatsapp_number', 'WhatsApp No', 'trim|required');
            // $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
            if($this->form_validation->run()){
                $student_id = $this->input->post('student_id');
                $batch_id = $this->input->post('batch_id');
                $data['contact_number'] = $this->input->post('contact_number');
                $data['name'] = $this->input->post('name');
                $data['gender'] = $this->input->post('gender');
                $data['address'] = $this->input->post('address');
                $data['street'] = $this->input->post('street');
                $data['state'] = $this->input->post('state');
                $data['district'] = $this->input->post('district');
                $data['whatsapp_number'] = $this->input->post('whatsapp_number');
                $data['mobile_number'] = $this->input->post('mobile_number');
                $dob = $this->input->post('date_of_birth');
                (!empty(trim($dob)))?$data['date_of_birth']=date('Y-m-d',strtotime($dob)):$data['date_of_birth']=NULL;
                $data['email'] = $this->input->post('email');
                if(empty($student_id)){
                    $this->student_model->add_external_candidate($data,$batch_id);
                    $returnData['message'] 	= "Candidate added successfully";
                }else{
                    $this->student_model->update_external_candidate($student_id,$data,$batch_id);
                    $returnData['message'] 	= "Candidate updated successfully";
                }
                $returnData['st'] 		= 1;
            }else{
                $returnData['st'] 		= 0;
                $returnData['message'] 	= strip_tags(explode('</p>',validation_errors())[0]);
            }
        }else{
            $returnData['st'] 		= 2;
            $returnData['message'] 	= "Something went wrong,Please try again later..!";
        }
        print_r(json_encode($returnData));
    }

    public function delete_ext_candidate($candidate_id){
        $this->student_model->delete_external_candidate($candidate_id);
        $data = 'Candidate deleted successfully..!';
        print_r(json_encode(['st'=>1,'data'=>$data]));
    }
    /* External Student Management Ends*/

}
?>
