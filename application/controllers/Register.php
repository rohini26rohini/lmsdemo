<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Direction_Controller {

	public function __construct() {
        parent::__construct();
       // $this->load->model('Register_model');

    }
    
    public function index()
    {
        $this->data['stateArr']=$this->common->get_all_states();
        $this->data['courseArr']=$this->Class_model->get_allclass_list();
        $this->data['routeArr']=$this->transport_model->get_route_list();
       // print_r($this->data['routeArr']);die();
        $this->data['viewload'] = 'home/register_first_view';
        // $this->data['viewload'] = 'home/register_second_view'; 

                           $this->session->unset_userdata('name');
                           $this->session->unset_userdata('blood_group');
                           $this->session->unset_userdata('course_id');
                           $this->session->unset_userdata('branch_institute_id');
                           $this->session->unset_userdata('batch_id');
                           $this->session->unset_userdata('address');
                           $this->session->unset_userdata('gender');
                           $this->session->unset_userdata('email');
                           $this->session->unset_userdata('street');
                           $this->session->unset_userdata('state');
                           $this->session->unset_userdata('district');
                           $this->session->unset_userdata('guardian_number');
                           $this->session->unset_userdata('contact_number');
                           $this->session->unset_userdata('whatsapp_number');
                           $this->session->unset_userdata('mobile_number');
                           $this->session->unset_userdata('guardian_name');
                           $this->session->unset_userdata('date_of_birth');
                           $this->session->unset_userdata('hostel');
                           $this->session->unset_userdata('medical_history');
                           $this->session->unset_userdata('medical_description');
                           $this->session->unset_userdata('transportation');
                           $this->session->unset_userdata('place');
                           $this->session->unset_userdata('stayed_in_hostel');
                           $this->session->unset_userdata('food_habit');
                           $this->session->unset_userdata('category');
                           $this->session->unset_userdata('qualification');
                           $this->session->unset_userdata('marks');
                           $this->session->unset_userdata('student_image');
        // $this->load->view('_layouts/_master', $this->data);
        $this->load->view('_layouts_new/_master', $this->data);
    } 
    public function register_second_view()
    {
        // print_r($_POST); //die();
        // print_r($_FILES); //die();
        if($_FILES['file_name']['name']  !="")
        {
           $files = str_replace(' ', '_', $_FILES['file_name']);
            $config['upload_path']           = 'uploads/student_images/';
            $config['allowed_types']        = 'jpg|png|jpeg|bmp';
            $config['max_size'] = '2000';
            $_FILES['file_name']['size']     = $files['size'];
            $config['file_name'] =$this->input->post('name').'_'.time();
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');
            $fileData = $this->upload->data();
             //echo "<pre>";print_r($fileData);
            if(!$upload)
            {
              // echo  $this->upload->display_errors();
                 $student_image="";
                 
            }
            else
            {
               $student_image = 'uploads/student_images/'.$fileData['file_name']; 
               // echo "file".$student_image;
            }
        }
        else if($this->input->post('student_image') !="")
        {
            $student_image=$this->input->post('student_image'); 
            //echo "session_file".$student_image;
        }
        else
        {
            $student_image="";
             //echo "nothing".$student_image;
        }
        $course_id=$this->input->post('course_id');
        $branch_institute_id=$this->input->post('branch_institute_id');
        $batch_id=$this->input->post('batch_id');
        $name=$this->input->post('name');
        $blood_group=$this->input->post('blood_group');
        $gender=$this->input->post('gender');
        $address=$this->input->post('address');
        $street=$this->input->post('street');
        $state=$this->input->post('state');
        $district=$this->input->post('district');
        $guardian_number=$this->input->post('guardian_number');
        $contact_number=$this->input->post('contact_number');
        $whatsapp_number=$this->input->post('whatsapp_number');
        $mobile_number=$this->input->post('mobile_number');
        $guardian_name=$this->input->post('guardian_name');
        $email=$this->input->post('email');
        $date_of_birth=$this->input->post('date_of_birth');

        $register_details = array(
                   'course_id' =>$course_id,
                    'branch_institute_id' =>$branch_institute_id,
                    'batch_id' =>$batch_id,
                    'name'  => $name,
                    'blood_group'  => $blood_group,
                    'gender'  => $gender,
                    'address'  => $address,
                    'street'  => $street,
                    'state'  => $state,
                    'district'  => $district,
                    'guardian_number'  => $guardian_number,
                    'contact_number'  => $contact_number,
                    'whatsapp_number'  => $whatsapp_number,
                    'mobile_number'  => $mobile_number,
                    'guardian_name'  => $guardian_name,
                    'email'  => $email,
                    'date_of_birth'  => $date_of_birth,
                    'student_image'  => $student_image
                    
        );
        // print_r($register_details); die();

       $this->session->set_userdata($register_details);
       return  $this->load->view('home/register_second_view' ,TRUE);
    }
    public function register_third_view()
    {
        $this->data['routeArr']=$this->transport_model->get_route_list();
        // echo '<pre>';print_r($_POST);
        $register_details['category'] = $this->input->post('category');
        $register_details['qualification'] = $this->input->post('qualification');
        $register_details['marks'] = $this->input->post('marks');
        $this->session->set_userdata($register_details);
    
         return $this->load->view('home/register_third_view',$this->data);
        // return $this->load->view('home/register_third_view',TRUE);
    }

    public function register()
    {
       
        $hostel=$this->input->post('hostel');
         if($hostel == "yes")
         {
            $stayed_in_hostel=$this->input->post('stayed_in_hostel');
            $food_habit=$this->input->post('food_habit');
             $register_details=array(
            'stayed_in_hostel'=> $stayed_in_hostel,
            'food_habit'=> $food_habit
            );
            $this->session->set_userdata($register_details);
         }
         else
         {
              $this->session->unset_userdata('stayed_in_hostel');
              $this->session->unset_userdata('food_habit');
         }
           $medical_history=$this->input->post('medical_history');
           $medical_description=$this->input->post('medical_description');
           $transportation=$this->input->post('transportation');
           $place=$this->input->post('place');

        $register_details=array(
            'hostel'=> $hostel,
            'medical_history'=> $medical_history,
            'medical_description'=> $medical_description,
            'transportation'=> $transportation,
            'place'=> $place,
            );
        $this->session->set_userdata($register_details);
        
            $student_details=array(
            'name'=> $this->session->userdata('name'),
            'blood_group'=> $this->session->userdata('blood_group'),
            'gender'=> $this->session->userdata('gender'),
            'address'=> $this->session->userdata('address'),
            'email'=> $this->session->userdata('email'),
            'street'=> $this->session->userdata('street'),
            'state'=> $this->session->userdata('state'),
            'district'=> $this->session->userdata('district'),
            'guardian_number'=> $this->session->userdata('guardian_number'),
            'contact_number'=> $this->session->userdata('contact_number'),
            'whatsapp_number'=> $this->session->userdata('whatsapp_number'),
            'mobile_number'=> $this->session->userdata('mobile_number'),
            'guardian_name'=> $this->session->userdata('guardian_name'),
            'date_of_birth'=> date('Y-m-d',strtotime($this->session->userdata('date_of_birth'))),
            'hostel'=> $this->session->userdata('hostel'),
            'medical_history'=> $this->session->userdata('medical_history'),
            'medical_description'=> $this->session->userdata('medical_description'),
            'transportation'=> $this->session->userdata('transportation'),
            'place'=> $this->session->userdata('place'),
            'stayed_in_hostel'=> $this->session->userdata('stayed_in_hostel'),
            'food_habit'=> $this->session->userdata('food_habit'),
            'student_image'=> $this->session->userdata('student_image'),
        );
        // show($student_details);
        //check the numbers with call centre
         $contact_numbers=array(
                                "0"=> $this->session->userdata('contact_number'),
                                "1"=> $this->session->userdata('whatsapp_number'),
                                "2"=> $this->session->userdata('mobile_number'),
                                "3"=> $this->session->userdata('guardian_number'),
                            );
                foreach($contact_numbers as $number)
                {
                    $query=$this->db->select('*')
                    ->from('cc_call_center_enquiries')
                    ->or_like('primary_mobile', $number)
                    ->or_like('father_mobile', $number)
                    ->or_like('mother_mobile', $number)
                    ->get();

                    if($query->num_rows() > 0)
                    {   //get caller_id
                        $caller_id=$query->row()->call_id; 
                       // echo $query->num_rows()."<br>";
                        //save the caller id in student registration table
                        $student_details['caller_id']=$caller_id;              
                       //change the status in call center 
                            $query= $this->db->get_where('cc_call_center_enquiries',array('call_id'=>$caller_id));
                            $data = $query->row_array();
                             $this->db->where('call_id',$caller_id);
                             if($data['call_status'] == 1 ||$data['call_status'] == 2 || $data['call_status'] == 3 || $data['call_status'] == 5 || $data['call_status'] == 6){
                             $query	= $this->db->update('cc_call_center_enquiries',array("call_status"=>"5"));
                             }
                             break;	
                    }
                }
        //insert student details 

          $res=$this->register_model->register_student($student_details);
          $student_id=$this->db->insert_id();
        if($res)
        {   //add student course
            $batch_id = $this->session->userdata('batch_id');
            $batchdetails = $this->Batch_model->get_batch_center_branch($batch_id);
            $course_detail=array(
            'course_id'=> $this->session->userdata('course_id'),
            'institute_course_mapping_id'=>$batchdetails->institute_course_mapping_id,     
            'branch_id'=>$batchdetails->branch_master_id,   
            'center_id'=>$batchdetails->institute_master_id, 
            'batch_id'=>$this->session->userdata('batch_id'), 
            'student_id'=> $student_id
            );
             $course_result=$this->register_model->add_student_course($course_detail);
                $categoryArr=$this->session->userdata('category');
                $qualificationArr=$this->session->userdata('qualification');
                $marksArr=$this->session->userdata('marks');
                //add educational qualification of student
               $i=0;
               foreach($categoryArr as $category)
               {
                   if(!empty($qualificationArr[$i]))
                   {
                       $data=array('student_id'=>$student_id,'category'=>$category,'qualification'=>$qualificationArr[$i],'marks'=>$marksArr[$i]);
                       $result=$this->register_model->add_student_qualification($data);
                       if($result)
                       {
                            $ajax_response['st']=1;                     
                       }
                       else
                       {
                            $ajax_response['st']=0;
                       }

                   }
                 $i++;
               }
             //generate the userid and password
                             $this->data['userid']=generate_userid($student_id);
                             $this->load->model('Auth_model');
                             $password =mt_rand(100000,999999);
                             $encrypted_password= $this->Auth_model->get_hash($password);
                            
            $student_credential=array(
            "user_name"=>$this->session->userdata('name'),
            "user_primary_id"=>$student_id,
            "user_username"=>$this->data['userid'],
            "user_emailid"=>$this->session->userdata('email'),
            "user_passwordhash"=>$encrypted_password,
            "user_role"=>"users",
            "user_phone"=>$this->session->userdata('mobile_number'),
            "user_image"=>$this->session->userdata('student_image')
            );
            /**********save the generated userid,password,userimage and user role************/
             $this->register_model->save_student_credential($student_credential);
             //save userid in reg table
             $this->db->where('student_id', $student_id);
              $query= $this->db->update('am_students',array("registration_number"=>$this->data['userid']));
            
            //check parent as already have a login credential or not
                $guardian_number=$this->session->userdata('guardian_number');
                $exist=$this->common->check_if_dataExist("am_users",array("user_username"=>$guardian_number,"user_role"=>"parent"));
                if($exist == 0)
                {
            // Parent login data save
            $password = mt_rand(100000,999999);
            $parent_password = $this->Auth_model->get_hash($password);
            $parent_credential=array(
            "user_name"=>$this->session->userdata('guardian_name'),
            //"user_primary_id"=>$student_id,
            "user_username"=>$this->session->userdata('guardian_number'),
            "user_emailid"=>$this->session->userdata('email'),
            "user_passwordhash"=>$parent_password,
            "user_role"=>"parent",
            "user_phone"=>$this->session->userdata('guardian_number')
            );
            $patentquery = $this->register_model->save_student_credential($parent_credential);
            $parent_id=$this->common->get_name_by_id("am_users","user_id",array("user_username"=>$guardian_number,"user_role"=>"parent"));
        }
        else
        {
           $parent_id=$this->common->get_name_by_id("am_users","user_id",array("user_username"=>$guardian_number,"user_role"=>"parent"));

        }
            
            // Ends Here
            
            
           
                          if($query)
                          {
                              //insert parent id
                            $this->Common_model->update("am_students", array("parent_id"=>$parent_id),array("student_id"=>$student_id));
                              //$this->gm_user_registration($this->data['userid'], $password, $student_id);
                              
                              //email
                              $num=$this->data['userid'];
                              $type="Registration";
                              $email=$this->session->userdata('email');
                              $data=email_header();
                              $data.='<tr style="background:#f2f2f2">
                                        <td style="padding: 20px 0px">
                                            <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi '.$this->session->userdata('name').'</h3>
                                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">We have received your registration request and are currently in draft status please feel free to reach out to our any one branch and complete your admission process.
                                            <p style="font-family: "Open Sans", sans-serif;color: #333;font-size: 14px;">Your token number is <b>'.$num.'</b></p><p style="font-family: "Open Sans", sans-serif;color: #333;font-size: 12px;">Please keep the token number for your records.</p>
                                            </p>
                                        </td>
                                    </tr>';
//                              $data.='<tr style="background:#f2f2f2">
//                                        <td style="padding: 20px 0px">
//                                            <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi</h3>
//                                            <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">You are successfully registered.Your username is '.$num.' and the password is'.$password.'
//                                            </p>
//                                        </td>
//                                    </tr>';
                                $data.=email_footer();

                              $this->send_email($type,$email,$data);
                              $number = $this->session->userdata('mobile_number');
                              $message = 'Your Direction registration number is '.$num.' please feel free to reach out to any one of our branch and complete your admission process';
                              send_sms($number,$message);
                              $ajax_response['st']=1;
                          }
                        else
                        {
                            $ajax_response['st']=0;
                        }
                           $this->session->unset_userdata('name');
                           $this->session->unset_userdata('blood_group');
                           $this->session->unset_userdata('gender');
                           $this->session->unset_userdata('address');
                           $this->session->unset_userdata('course_id');
                           $this->session->unset_userdata('branch_institute_id');
                           $this->session->unset_userdata('batch_id');
                           $this->session->unset_userdata('street');
                           $this->session->unset_userdata('state');
                           $this->session->unset_userdata('district');
                           $this->session->unset_userdata('guardian_number');
                           $this->session->unset_userdata('contact_number');
                           $this->session->unset_userdata('whatsapp_number');
                           $this->session->unset_userdata('mobile_number');
                           $this->session->unset_userdata('guardian_name');
                           $this->session->unset_userdata('date_of_birth');
                           $this->session->unset_userdata('hostel');
                           $this->session->unset_userdata('medical_history');
                           $this->session->unset_userdata('medical_description');
                           $this->session->unset_userdata('transportation');
                           $this->session->unset_userdata('place');
                           $this->session->unset_userdata('stayed_in_hostel');
                           $this->session->unset_userdata('food_habit');
                           $this->session->unset_userdata('category');
                           $this->session->unset_userdata('qualification');
                           $this->session->unset_userdata('marks');
                           $this->session->unset_userdata('student_image');
                           $this->session->unset_userdata('email');

        }
        else
        {
             $ajax_response['st']=0;
        }
        if($ajax_response['st']==1)
        {
           return $this->load->view('home/register_success',$this->data);
        }
        else
        {
            $this->data['error']="Error";
            return $this->load->view('home/register_third_view',$this->data);
        }
    }
    
    public function get_district_bystate($id="")
    {
        $id=$this->input->post('state_id');
        $DistrictArr=$this->common->get_district_bystate($id);
        echo '<option value="">Select City</option>';
        foreach($DistrictArr as $row)
        {
          echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    
    public function previous_of_secondpage()
    {
        $register_details=array(
            'category'=> $this->input->post('category'),
            'qualification'=> $this->input->post('qualification'),
            'marks'=> $this->input->post('marks')
            );
         $this->session->set_userdata($register_details);
         $this->data['stateArr']=$this->common->get_all_states();
         $this->data['courseArr']=$this->Class_model->get_allclass_list();
         $this->data['DistrictArr']=$this->common->get_district_bystate($this->session->userdata('state')); 
       // print_r($_SESSION);
        //branch
       $this->data['branchArr']=$this->register_model->get_branchby_courseid($this->session->userdata('course_id'));
        
        /* $branchoptions = '';
            if(!empty($branches)) {
                foreach($branches as $branch) {
                  
                    $select="";
                   if($branch->institute_course_mapping_id == $this->session->userdata('branch_institute_id'))
                   {
                      $select="Selected"; 
                   }
                     $branchoptions .='<option value="'.$branch['institute_course_mapping_id'].'" '.$select.'>'.$branch['institute_name'].'</option>';
                }
            } 
         $this->data['branchArr']= $branchoptions;*/
        //batch
            $this->data['batchArr']=$this->register_model->get_batch_by_insticourse_id($this->session->userdata('branch_institute_id'));
           /* $options = '';
            if(!empty($batches)) {
                foreach($batches as $batch) {
                    $bselect="";
                    if($batch->batch_id == $this->session->userdata('batch_id')){ 
                       $bselect= 'Selected';
                    }
                    $options .= '<option value="'.$batch->batch_id.'" '.$bselect.'>'.$batch->batch_name.'</option>';
                }
            } 
        
         $this->data['batchArr']= $options;*/
        
       return $this->load->view('home/register_firstpage_previousview', $this->data); 
    } 
    public function previous_of_thirdpage()
    {
        $hostel=$this->input->post('hostel');
         if($hostel == "yes")
         {
            $stayed_in_hostel=$this->input->post('stayed_in_hostel');
            $food_habit=$this->input->post('food_habit');
             $register_details=array(
            'stayed_in_hostel'=> $stayed_in_hostel,
            'food_habit'=> $food_habit
            );
              $this->session->set_userdata($register_details);
         }
           $medical_history=$this->input->post('medical_history');
           $medical_description=$this->input->post('medical_description');
           $transportation=$this->input->post('transportation');
           $place=$this->input->post('place');

        $register_details=array(
            'hostel'=> $hostel,
            'medical_history'=> $medical_history,
            'medical_description'=> $medical_description,
            'transportation'=> $transportation,
            'place'=> $place,
            );
            $this->session->set_userdata($register_details);
         
        
       return $this->load->view('home/register_second_view',TRUE); 
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
    /*public function mobileCheck()
    {
        $mobile_number=$this->input->post('mobile_number');
        $query= $this->db->get_where('am_students',array("mobile_number"=>$mobile_number,"status"=>"0"));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }*/
    public function contactNumCheck()
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
    

   
public function sample()
{    $this->load->model('Auth_model');
     $password =mt_rand(100000,999999);
    $encrypted_password= $this->Auth_model->get_hash($password);
}
    function send_email($type, $email, &$data) {
        $this->email->to($email);
        $this->email->subject($type);
        $this->email->message($data);
        $this->email->send();
     }
    
    public function check_number()
    {
        if($_POST)
        {
        $number=$this->input->post('contact_num');
        $query= $this->db->get_where('am_students',array("contact_number"=>$number));
        $resultArr	=array();
                if($query->num_rows()== 0)
                {

                        $query=$this->db->select('*')
                        ->from('cc_call_center_enquiries')
                        ->or_like('primary_mobile', $number)
                        ->or_like('father_mobile', $number)
                        ->or_like('mother_mobile', $number)
                        ->get();
                        
                         if($query->num_rows() > 0)
                         {
                            $resultArr	=	$query->row_array();
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
                   
                } 
            else
            {
                 $resultArr['st']="exist";
            }
             print_r(json_encode($resultArr));
           }

    }

// 
    
public function get_branch_by_course_id() {
    $options = '<option value="">Select</option>';
    if(isset($_POST) && $_POST['course_id']!='') {
        $courses = $this->register_model->get_branchby_courseid($_POST['course_id']); 
        
        if(!empty($courses)) {
            foreach($courses as $course) {
                $options .= '<option value="'.$course->institute_course_mapping_id.'">'.$course->institute_name.'</option>';
            }
        } 
        
    }
    echo $options;
}    

    
public function get_batch_by_insticourse_id() {
     $options = '<option value="">Select</option>';
    if(isset($_POST) && $_POST['branch_institute_id']!='') {
        $batches = $this->register_model->get_batch_by_insticourse_id($_POST['branch_institute_id']); 
       
        if(!empty($batches)) {
            foreach($batches as $batch) {
                $options .= '<option value="'.$batch->batch_id.'">'.$batch->batch_name.'</option>';
            }
        } 
        
    }
    echo $options;
}  
    
    public function gm_user_registration($username = NULL, $password = NULL, $userId = NULL) {
        $this->common->gm_user_registration($username,$password,$userId);  
    }
    
    public function test($student_id = 112, $password="123456", $username = 'D0000112') {
      //$batchdetails = $this->Batch_model->get_batch_center_branch($student_id);
      //print_r($batchdetails);
      // Authentication Api call
      $postdata['grant_type'] 		= 'password'; 
      $postdata['username'] 		= 'gm_admin'; 
      $postdata['password'] 		= 'password';
      $postdata['scope'] 		    = 'read write trust'; 
      $jsonData['method']           = "oauth/token?grant_type=password&username=gm_admin&password=password&client_id=grandmaster-client&client_secret=grandmaster-secret&scope=read+write+trust";
      $jsonData['type'] = "POST"; 
      $jsonData['data'] = array();
      $ajaxResponse = json_decode($this->common->rest_api_auth($jsonData)); 
      print_r($jsonData);
	  print_r($ajaxResponse);
    // User insert api cal  
      $data['id'] 		        = $student_id;
      $data['password'] 		= $password; 
      $data['userName'] 		= $username;
      $data['role']['id'] 		= 2;  
      $jsonData['access_token'] = $ajaxResponse->access_token; 
      $jsonData['method']       = "createOrUpdateUser";
      $jsonData['type']         = "POST"; 
      $jsonData['data']         = json_encode($data); print_r($jsonData);
      $ajaxResponse = json_decode($this->common->rest_api_call($jsonData));    print_r($ajaxResponse); 
    }

    function passhash($password = NULL) {
        if($password!='') {
            $encrypted_password= $this->Auth_model->get_hash($password);
            echo 'Password: '. $password;
            echo 'Hash: '.$encrypted_password;
        }
    }

    public function delete_others()
    {
        $id  = $_POST['id'];
        $res = $this->register_model->delete_others($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'am_student_qualification');
        }
        print_r($res); 
        // if($_POST){
        //     $result = $this->student_model->delete_student_others($this->input->post('id'));
        // }   
    }

}
?>
