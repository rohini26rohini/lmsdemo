<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends Direction_controller {

	public function __construct() {
        parent::__construct();
        $module="staff";
        check_backoffice_permission($module);
        $this->load->model('staff_enrollment_model');
       
    }

    public function index(){
         check_backoffice_permission('manage_staff');
        $this->data['page']="admin/stafflist";
		$this->data['menu']="staff";
        $this->data['breadcrumb']="Manage Staff";
        $this->data['menu_item']="backoffice/manage-staff";
        $this->data['staffArr']=$this->staff_enrollment_model->get_staff_list();
        $this->data['roleArr']=$this->common->get_roles();
        $this->data['subjectArr']=$this->common->get_all_subject_type();
		$this->load->view('admin/layouts/_master',$this->data); 
     }
    public function manage_staff($id=NULL)
    { 
      
        if($id!=NULL){
            $this->data['staffEdit'] = $this->staff_enrollment_model->get_staff_personal_by_id($id);
            $details=$this->data['staffEdit'];

             $this->data['edit_states']=$this->common->get_states_byCountry($details['spouse_country']);

             $this->data['edit_city']=$this->common->get_district_bystate($details['spouse_state']);

        }
             
        $this->data['page']="admin/staff_enrollment";
		$this->data['menu']="staff";
        $this->data['breadcrumb']="Manage Staff";
        $this->data['menu_item']="backoffice/manage-staff";
        $this->data['staffArr']=$this->staff_enrollment_model->get_staff_list();
        $this->data['branch'] = $this->common->get_from_tableresult('am_institute_master', array('institute_type_id'=>2,'status'=>1));
        $this->data['center'] = $this->common->get_from_tableresult('am_institute_master', array('institute_type_id'=>3,'status'=>1));
        // $this->data['educationArr']=$this->staff_enrollment_model->get_education_list();
        $this->data['documents'] = $this->staff_enrollment_model->get_staff_documents($id);
        $this->data['countryArr']=$this->common->get_all_countries();
        $this->data['cityArr']=$this->common->get_districts();
        $this->data['roleArr']=$this->common->get_roles();
        $this->data['subjectArr']=$this->common->get_all_subject_type();
        $this->data['salaryArr'] = $this->common->get_salary_scheme_drop_down();
        $this->data['leaveArr'] = $this->common->get_leave_scheme_drop_down();

        $this->load->view('admin/layouts/_master',$this->data); 
    }
  
    public function get_state(){
        $this->db->select('*');
        $this->db->where('country_id',$_POST['id']);
        $this->db->order_by('name');
        $states = $this->db->get('states')->result_array();
            echo '<option value="">Select State</option>';
            foreach($states as $row){ 
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        
    }
    public function get_city(){
        $this->db->select('*');
        $this->db->where('state_id',$_POST['id']);
        $this->db->order_by('name');
        $cities = $this->db->get('cities')->result_array();
            echo '<option value="">Select City</option>';
            foreach($cities as $row){ 
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
    }
    public function staff_personal_add()
    {
        if($_POST){
        // print_r($_FILES); die();
            if(!empty($_FILES['file_name']['name'])) {
                // $staff_image="";
                $files = str_replace(' ', '_', $_FILES['file_name']);
                $this->load->library('upload');
                $config['upload_path']           = 'uploads/staff_images/';
                $config['allowed_types']        = 'jpg|jpeg|png|bmp';
                $config['max_size'] = '2000';
                $_FILES['file_name']['size']     = $files['size'];
                $config['file_name'] =$this->input->post('name').'_'.time();
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('file_name');
                $fileData = $this->upload->data();
                if(!$upload){
                    $ajax_response['st']=3;
                    $ajax_response['msg']=$this->upload->display_errors();
                    print_r(json_encode($ajax_response));
                    return false;
                    // $staff_image="";
                    // unset($_POST['staff_image']);
                }else{
                    $staff_image ='uploads/staff_images/'. $fileData['file_name'];
                    $_POST['staff_image']=$staff_image;
                }
            }
            // else{
            //     $staff_image="";
            //     unset($_POST['staff_image']);
            // }

            $data = $_POST; 
            $staff_personal_exist = $this->staff_enrollment_model->is_staff_personal_exist($_POST['mobile'], $_POST['email']);
            if($staff_personal_exist == 0){ 
                $res = $this->staff_enrollment_model->staff_personal_add($data); 
                // echo 'dff';
                if($res > 0){ 
                    // echo 'tha';
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'am_staff_personal');
                   /* $staff_personal_array=$this->staff_enrollment_model->get_staff_personaldetails_by_id($table_row_id);*/

                     //LOGIN TABLE DATA ENTRY
                     $this->data['userid']=generate_staffid($table_row_id);
                     $this->load->model('Auth_model');
                     $password =mt_rand(100000,999999);
                     $encrypted_password= $this->Auth_model->get_hash($password);
                    
                     $dataArr = array('user_username'=>$_POST['email'],
                                     'user_name'=>$_POST['name'],
                                     "registration_number"=>$this->data['userid'],
                                     'user_emailid'=>$_POST['email'],
                                     'user_role'=>$_POST['role'],
                                     'user_phone'=>$_POST['mobile'],
                                     'user_passwordhash'=>$encrypted_password
                                    );
                                    // echo '<pre>';
                                    // print_r($dataArr);
                                    // die();

                    $response_id=$this->Common_model->insert('am_users_backoffice',$dataArr);
                    if($response_id > 0)
                    {
                        $this->db->where('personal_id', $table_row_id);
                        $query = $this->db->update('am_staff_personal', array('user_id'=>$response_id,'registration_number'=>$this->data['userid']));
                        // Implement email functionality here
                        if($query)
                        {
                            // send email 
                            // $staff_id= $dataArr['user_emailid'];
                            $username= $dataArr['user_emailid'];
                            $name= $dataArr['user_name'];
                            $num= $this->data['userid'];
                            $type=" Staff Registration";
                            $email=$this->input->post('email');
                            $data = email_header();
                            $data.='<tr style="background:#f2f2f2">
                                    <td style="padding: 20px 0px">
                                        <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Hi '.$name.'</h3>
                                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">You are successfully registered.Your login credentials are,</p>
                                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$username.'</p>
                                        <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>
                                    </td>
                                </tr>';
                            $data.=email_footer();
                            $this->send_email($type, $email,$data);
                        }

                        // <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">You are successfully registered.Your login password is '.$num.'</p>

                        $ajax_response['st']=1;//success
                        $ajax_response['id']=$res;
                    }
                }else{
                   $ajax_response['st']=0;
                }
            }else{
                $ajax_response['st']=2;//already exist
                //$html= '-1';
            }
            print_r(json_encode($ajax_response));
        }
    }

   /*
*   function'll edit staff  perssonel details
*   @params all datas
*   @author GBS-L
*/
    public function staff_personal_edit()
    {

        if($_POST)
        {
            $id=$this->input->post('personal_id');
            unset($_POST['personal_id']);
             if(!empty($_FILES['file_name']['name']))
                    {
                        $staff_image="";
                        $files = str_replace(' ', '_', $_FILES['file_name']);
                        $this->load->library('upload');
                        $config['upload_path']           = 'uploads/staff_images/';
                        $config['allowed_types']        = 'jpg|jpeg|png|bmp';
                        $config['max_size'] = '2000';
                        $_FILES['file_name']['size']     = $files['size'];
                        $config['file_name'] =$this->input->post('name').'_'.time();
                        // $_FILES['file_name']['size']     = $files['size'];



                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        $upload = $this->upload->do_upload('file_name');
                        $fileData = $this->upload->data();
                         if(!$upload)
                        {
                           $ajax_response['st']=3;
                           $ajax_response['msg']=$this->upload->display_errors();
                             print_r(json_encode($ajax_response));
                             return false;

                        }
                         else
                         {
                              $staff_image ='uploads/staff_images/'. $fileData['file_name'];
                              $_POST['staff_image']=$staff_image;
                         }

                    }
             $data = $_POST;
            $staff_personal_exist = $this->staff_enrollment_model->is_staff_personal_exist($_POST['mobile'], $_POST['email']);
           if($staff_personal_exist <= 1)
           {
                $res = $this->Common_model->update('am_staff_personal', $data,array("personal_id"=>$id));
                if($res)
                {
                    $what = $this->db->last_query();

                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'database', $who, $what, $id, 'am_staff_personal');


                    // LOGIN TABLE DATA ENTRY
                     /*$this->load->model('Auth_model');
                     $password =mt_rand(100000,999999);
                     $encrypted_password= $this->Auth_model->get_hash($password);*/
                     $dataArr = array('user_username'=>$_POST['email'],
                                     'user_name'=>$_POST['name'],
                                     'user_emailid'=>$_POST['email'],
                                     'user_role'=>$_POST['role'],
                                     'user_phone'=>$_POST['mobile']
                                     //'user_passwordhash'=>$encrypted_password
                                    );
                    $user_id=$this->common->get_name_by_id('am_staff_personal','user_id',array("personal_id"=>$id));
                    $response=$this->Common_model->update('am_users_backoffice',$dataArr,array("user_id"=>$user_id));
                    if($response)
                    {
                        $ajax_response['st']=1;//success

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
                $ajax_response['st']=2; //already exist

            }
            print_r(json_encode($ajax_response));

        }
    }
    public function get_staff_personal_by_id($personal_id){
        $staff_personal_array= $this->staff_enrollment_model->get_staff_personal_by_id($personal_id);
        print_r(json_encode($staff_personal_array));
    }
    public function staff_personals_edit()
    {
        
            $id = $this->input->post('personal_id');
            unset($_POST['personal_id']);
            $data = $_POST;
            $res = $this->staff_enrollment_model->edit_staff_personals($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'am_staff_personal');
            }
            print_r($res);
        
    }
    public function delete_staff_personals()
    {
        $id  = $_POST['id'];
        $res = $this->staff_enrollment_model->delete_staff_personals($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'am_staff_personal');
        }
        print_r($res);     
    }

    function get_modules($subject_id)
    {
        $modules = $this->db->get_where('mm_subjects', array('subject_id' => $subject_id))->result_array();
        echo '<div class="form-group">
                <label class="">Modules</label>
                <div> <select class="form-control " name="modules[]" id="module_holder" multiple="multiple">';
        foreach ($modules as $row) {
            $name = $this->db->get_where('mm_subjects', array(
                'subject_type_id' => $row['subject_type_id']
            ))->row()->subject_type_id;
            echo '<option value="' . $row['subject_type_id'] . '" >' . $name . '</option>';
        }
        echo '</select>';
        echo '</div></div>';
    }

     function get_modules_by_subject($subject_id = NULL)
    {
        
        $modules = $this->db->get_where('mm_subjects', array('parent_subject' => $subject_id))->result_array();
        $options = '<div class="col-12">
                                <div class="form-group" id="strong_modules"><label style="display:block">Strong Modules</label>
                                    <select class="multiselect-ui form-control" multiple="multiple"  name="strong_modules'.$subject_id.'[]" id="strong_modules" >';
         foreach ($modules as $row) {
            $options .= '<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
        }
         $options .= '</select></div>
                            </div>';
         $options .= '<div class="col-12">
                                <div class="form-group" id="strong_modules"><label style="display:block">Weak Modules</label>
                                    <select class="multiselect-ui form-control" multiple="multiple"  name="weak_modules'.$subject_id.'[]" id="weak_modules" >';
         foreach ($modules as $row) {
            $options .= '<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
        }
         $options .= '</select></div>
                            </div>';
        echo  $options;
    }


    function get_modules_by_subjectweek($subject_id)
    {
        $modules = $this->db->get_where('mm_subjects', array('parent_subject' => $subject_id))->result_array();
        $options = '<div class="row"><div class="col-12">
                                <div class="form-group" id="strong_modules"><label style="display:block">Strong Modules</label>
                                    <select class="multiselect-ui form-control" multiple="multiple"  name="strong_modules'.$subject_id.'[]" id="strong_modules" >';
         foreach ($modules as $row) {
            $options .= '<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
        }
         $options .= '</select></div>
                            </div>';
         $options .= '<div class="col-12">
                                <div class="form-group" id="strong_modules"><label style="display:block">Weak Modules</label>
                                    <select class="multiselect-ui form-control" multiple="multiple"  name="weak_modules'.$subject_id.'[]" id="weak_modules" >';
         foreach ($modules as $row) {
            $options .= '<option value="' . $row['subject_id'] . '" >' . $row['subject_name'] . '</option>';
        }
         $options .= '</select></div>
                            </div></div>';
        echo  $options;
    }


    public function get_allsub_modules(){
        if($_POST){
            $subject_id = $this->input->post('subject_id');
            if($subject_type_id == "Module"){
                $type = "Subject"; 
            }
            $subArr = $this->staff_enrollment_model->get_allsub_modules($type); 
            
            echo '<div class ="form-group"><label>Sub Modules</label><select class ="form-control" name ="sub_module[]" multiple="multiple"><option value = "">Select</option>';
            foreach ($subArr as $row) {
                echo '<option value = "' . $row['parent_subject'] . '" >' . $row['subject_name'] . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }
    }


    /*
    *   function'll update faculty strong and weak area
    *   @params subject and module array
    *   @author GBS-R
    */

    public function faculty_subjectupdate()
    { 
        if($_POST){
      
        $personal_id        = $this->input->post('personal_id');
        $strong_subject     = $this->input->post('strong_subject');
            if(count($strong_subject) != count(array_unique($strong_subject)))
            {
                $result['status']   =   false;
                $result['message']  =   'Duplicate Subjects are not allowed';
                $result['data']     =   null;
                print_r(json_encode($result));
                exit();  
            }
        $faculty_sub_id     = $this->input->post('faculty_sub_id');
        $subject_id         = 0;

        if($personal_id!='')
        {
            if(!empty($faculty_sub_id))
            {   //update
                 $new_strong_subject     = array_filter($this->input->post('strong_subject'));
               
                if(!empty($new_strong_subject))
                {
                //check if exist in database
                 $exist=$this->staff_enrollment_model->check_faculty_subject($new_strong_subject,$personal_id);

                if($exist)
                {
                    $result['status']   =   false;
                    $result['message']  =   'Duplicate Subjects are not allowed';
                    $result['data']     =   null;
                    print_r(json_encode($result));
                    exit();
                }
                }
                //insert if any other subject added newly
                if(($new_strong_subject))
                {
                        foreach($new_strong_subject as $key=>$sub)
                        {   
                            $strong_modules     = $this->input->post('strong_modules'.$sub);
                            $weak_modules       = $this->input->post('weak_modules'.$sub);
             
                            if(!empty($strong_modules) && !empty($weak_modules))
                               {
                                   foreach($strong_modules as $val)
                                   {
                                      if (in_array($val, $weak_modules))
                                        {
                                        $result['status']   =   false;
                                        $result['message']  =   'Cannot add the same module as strong and weak';
                                        $result['data']     =   $_POST;
                                        print_r(json_encode($result));
                                        return false;
                                       }
                                   }
                               }
                            if(!empty($strong_modules)){$strongmod = implode(',',$strong_modules);}
                            else {$strongmod = '';}
                            if(!empty($weak_modules)) { $weakmod   =implode(',',$weak_modules); }
                            else {$weakmod = ''; }
                            if($sub != "")
                            {
                            //data to update
                            $add_data[$key] = array('staff_id'=>$personal_id,
                                                    'parent_subject_id'=>$sub,
                                                    'strong_subject_id'=>$strongmod,
                                                    'weak_subject_id'=>$weakmod
                                                    );
                            }
                    }
                $sql  = $this->staff_enrollment_model->insert_faculty_subject($add_data); 
            }
                //update the already added subjects
                    foreach($faculty_sub_id as $key=>$sub_id)
                    {
                        $strong_subject     = $this->input->post('strong_subject'.$sub_id);
                        $strong_modules     = '';
                        $weak_modules       = '';
                        $strong_modules     = $this->input->post('strong_modules'.$strong_subject);
                        $weak_modules       = $this->input->post('weak_modules'.$strong_subject);
                        if( !empty($strong_modules) && !empty($weak_modules))
                               {                          
                               foreach($strong_modules as $val){
                                    if (in_array($val, $weak_modules))
                                    {
                                    $result['status']   =   false;
                                    $result['message']  =   'Cannot add the same module as strong and weak';
                                    $result['data']     =   $_POST;
                                    print_r(json_encode($result));
                                    return false;
                                        
                                    }
                               }
                               }
                        if(!empty($strong_modules)) {
                        $strongmod = implode(',',$strong_modules);
                        } else {
                        $strongmod = '';
                        }
                        if(!empty($weak_modules)) {
                        $weakmod   =implode(',',$weak_modules);
                        } else {
                        $weakmod = '';
                        }
                        if($strong_subject != ""){
                        $data[$key] = array('faculty_sub_id'=>$sub_id,
                                            'parent_subject_id'=>$strong_subject,
                                            'strong_subject_id'=>$strongmod,
                                            'weak_subject_id'=>$weakmod
                                        );
                        }
                    }
                        $query = $this->staff_enrollment_model->update_faculty_subject($data);
                        if($query)
                        {
                            $result['status']   =   true;
                            $result['message']  =   'Data successfully updated';
                            $result['data']     =   $_POST;
                        }
                        else
                        {
                            $result['status']   =   false;
                            $result['message']  =   'Error while updating data';
                            $result['data']     =    '';
                        }
        }
        else
         { 
            
            //insert
                        foreach($strong_subject as $key=>$subject)
                        {
                            $strong_modules     = $this->input->post('strong_modules'.$subject);
                            $weak_modules       = $this->input->post('weak_modules'.$subject);
                             if( !empty($strong_modules) && !empty($weak_modules))
                               {                          
                               foreach($strong_modules as $val){
                                    if (in_array($val, $weak_modules))
                                    {
                                    $result['status']   =   false;
                                    $result['message']  =   'Cannot add the same module as strong and weak';
                                    $result['data']     =   $_POST;
                                    print_r(json_encode($result));
                                    return false;
                                        
                                    }
                               }
                               }
                           
                            if(!empty($strong_modules)) {
                            $strongmod = implode(',',$strong_modules);
                            } else {
                            $strongmod = '';
                            }
                            if(!empty($weak_modules)) {
                            $weakmod   =implode(',',$weak_modules);
                            } else {
                            $weakmod = '';
                            }
                            if($subject != ""){
                            $data[$key] = array('staff_id'=>$personal_id,
                                          'parent_subject_id'=>$subject,
                                          'strong_subject_id'=>$strongmod,
                                          'weak_subject_id'=>$weakmod
                                         );    
                            }
                        }
                             $query  = $this->staff_enrollment_model->insert_faculty_subject($data);
                            
                            if($query) {
                            $result['status']   =   true;
                            $result['message']  =   'Data successfully added';
                            $result['data']     =   $_POST;
                            } else {
                            $result['status']   =   false;
                            $result['message']  =   'Error while updating data';
                            $result['data']     =    $personal_id;
                            }
                        
            }
            }
            else
            {
                $result['status']   =   false;
                $result['message']  =   'Invalid data';
                $result['data']     =   null;
            }
    }
    else
    {
        $result['status']   =   false;
        $result['message']  =   'Invalid data';
        $result['data']     =   null;
    }
        print_r(json_encode($result));
    }

    public function staff_education_add()
    {
       // print_r($_POST);// die();
        $education_id       = $this->input->post('education_id');
        $edit_personal_id   = $this->input->post('personal_id');
        unset($_POST['personal_id']);
        $categoryArr        = $this->input->post('category');
        $specificationArr   = $this->input->post('specification');
        $schoolArr          = $this->input->post('school');
        $passing_yearArr    = $this->input->post('passing_year');
        $marksArr           = $this->input->post('marks');
        $universityArr      = $this->input->post('university');
        $i = -1;
        $html = array();
  
        foreach($categoryArr as $category){
           
            $i++;
            $exist = '';
            
            if(isset($specificationArr[$i])){ 
                if($category =='Others' && isset($education_id[$i])!='')
                {
                    $exist= 1;
                }
                else if(isset($education_id[$i])!='')
                {
                    $exist=$this->staff_enrollment_model->check_specification($edit_personal_id,$category);
                    // echo $this->db->last_query();
                    // print_r($exist);
                }
                if($exist != 0){ 
                    $old=$this->common->get_from_table('am_staff_education', array("personal_id"=>$edit_personal_id));
                    $data= array(
                                'specification'=>!empty($specificationArr[$i]) ? $specificationArr[$i] : '',
                                'marks'=>!empty($marksArr[$i]) ? $marksArr[$i] : '',
                                'category'=>!empty($category) ? $category : '',
                                'school'=>!empty($schoolArr[$i]) ? $schoolArr[$i] : '',
                                'university'=>!empty($universityArr[$i]) ? $universityArr[$i] : '',
                                'passing_year'=>!empty($passing_yearArr[$i]) ? $passing_yearArr[$i] : '',
                                'personal_id'=>!empty($edit_personal_id) ? $edit_personal_id : ''
                            );
                   
                    $result=$this->staff_enrollment_model->staff_education_edit($edit_personal_id[$i],$data,$specificationArr[$i]);
                    $message="Edit Qualification";
                    $action="Update";
                    $table_row_id=$edit_personal_id[$i];
                    array_push($html, $table_row_id);//die();
                }else{ 
                    $old=""; 
                    $data=
                    array('specification'=>!empty($specificationArr[$i]) ? $specificationArr[$i] : '',
                        'marks'=>!empty($marksArr[$i]) ? $marksArr[$i] : '',
                        'category'=>!empty($category) ? $category : '',
                        'school'=>!empty($schoolArr[$i]) ? $schoolArr[$i] : '',
                        'university'=>!empty($universityArr[$i]) ? $universityArr[$i] : '',
                        'passing_year'=>!empty($passing_yearArr[$i]) ? $passing_yearArr[$i] : '',
                        'personal_id'=>!empty($edit_personal_id) ? $edit_personal_id : ''
                    );
                   
                    if($category =='Others'){
                        $exist=$this->staff_enrollment_model->check_specification1($edit_personal_id,$specificationArr[$i],$category);
                        
                        if($exist == '' || $exist == 0){ 
                            $result=$this->staff_enrollment_model->staff_education_add($data);
                            $message="Add Qualification";
                            $action="insert";
                            $table_row_id=$this->db->insert_id();
                            array_push($html, $table_row_id);
                        }
                    }else{
                       
                        $result=$this->staff_enrollment_model->staff_education_edit($edit_personal_id,$category,$data,$specificationArr[$i]);
                        $message="Add Qualification";
                        $action="Update";
                        $table_row_id=$edit_personal_id;                    
                        // array_push($html, $table_row_id);
                    }
                   
                }
            }
        }
        //echo count($html);
    }

 public function staff_education_add_old()
 {
    print_r($_POST);
        $education_id       = $this->input->post('education_id');
        $edit_personal_id   = $this->input->post('personal_id');
        unset($_POST['personal_id']);
        $categoryArr        = $this->input->post('category');
        $specificationArr   = $this->input->post('specification');
        $schoolArr          = $this->input->post('school');
        $passing_yearArr    = $this->input->post('passing_year');
        $marksArr           = $this->input->post('marks');
        $universityArr      = $this->input->post('university');
        $i = 0;
        $html = array();
     foreach($specificationArr as $key=>$specification)
     {
         
         if($specificationArr[$key]!="")
         {  
            $exist=$this->staff_enrollment_model->check_specification($edit_personal_id,$categoryArr[$key]);
            
             if($exist == 0)
             {
                //insert
                 $data= array(
                                'specification'=>!empty($specification) ? $specification : '',
                                'marks'=>!empty($marksArr[$key]) ? $marksArr[$key] : '',
                                'category'=>!empty($categoryArr[$key]) ? $categoryArr[$key] : '',
                                'school'=>!empty($schoolArr[$key]) ? $schoolArr[$key] : '',
                                'university'=>!empty($universityArr[$key]) ? $universityArr[$key] : '',
                                'passing_year'=>!empty($passing_yearArr[$key]) ? $passing_yearArr[$key] : '',
                                'personal_id'=>!empty($edit_personal_id) ? $edit_personal_id : ''
                            );
                
                 $result=$this->staff_enrollment_model->staff_education_add($data); 
                 $table_row_id=$this->db->insert_id();
                 array_push($html, $table_row_id);
                  echo $this->db->last_query();
             }
             else
             {
              
                if($categoryArr[$key] == "Others")
                {
                   // echo $specification;
                  $check=array();
                  $check=$this->common->get_from_tablerow('am_staff_education',array("specification"=>$specification,"personal_id"=>$edit_personal_id,'category'=>$categoryArr[$key])); 
                     echo $categoryArr[$key]."<br>";
                     echo $specification."<br>";
                     echo $edit_personal_id."<br>";
                   // print_r($check);
                   // echo $this->db->last_query();
                    
                   // echo "<br>";
                    if(!empty($check)){
                        echo "update";
                    }
                    if(empty($check))
                    {
                        //insert other
                        $data= array(
                                'specification'=>!empty($specification) ? $specification : '',
                                'marks'=>!empty($marksArr[$key]) ? $marksArr[$key] : '',
                                'category'=>!empty($categoryArr[$key]) ? $categoryArr[$key] : '',
                                'school'=>!empty($schoolArr[$key]) ? $schoolArr[$key] : '',
                                'university'=>!empty($universityArr[$key]) ? $universityArr[$key] : '',
                                'passing_year'=>!empty($passing_yearArr[$key]) ? $passing_yearArr[$key] : '',
                                'personal_id'=>!empty($edit_personal_id) ? $edit_personal_id : ''
                            );
               // echo "insert()";
                            $result=$this->staff_enrollment_model->staff_education_add($data);  
                            $table_row_id=$this->db->insert_id();
                            array_push($html, $table_row_id);
                         echo $this->db->last_query();
                    }
                    else
                    {
                        //update
                         $data= array(
                                'specification'=>!empty($specification) ? $specification : '',
                                'marks'=>!empty($marksArr[$key]) ? $marksArr[$key] : '',
                                'category'=>!empty($categoryArr[$key]) ? $categoryArr[$key] : '',
                                'school'=>!empty($schoolArr[$key]) ? $schoolArr[$key] : '',
                                'university'=>!empty($universityArr[$key]) ? $universityArr[$key] : '',
                                'passing_year'=>!empty($passing_yearArr[$key]) ? $passing_yearArr[$key] : ''
                            );
                        $result=$this->staff_enrollment_model->staff_education_edit($edit_personal_id,$categoryArr[$key],$data); 
                         $table_row_id=$edit_personal_id;      
                    }
                }
                 else
                 {
                     //update
                     //edit
                 $data= array(
                                'specification'=>!empty($specification) ? $specification : '',
                                'marks'=>!empty($marksArr[$key]) ? $marksArr[$key] : '',
                                'category'=>!empty($categoryArr[$key]) ? $categoryArr[$key] : '',
                                'school'=>!empty($schoolArr[$key]) ? $schoolArr[$key] : '',
                                'university'=>!empty($universityArr[$key]) ? $universityArr[$key] : '',
                                'passing_year'=>!empty($passing_yearArr[$key]) ? $passing_yearArr[$key] : ''
                            );
                   $result=$this->staff_enrollment_model->staff_education_edit($edit_personal_id,$categoryArr[$key],$data); 
                   $table_row_id=$edit_personal_id;      
                 }
                  
                
             }
             
             
         }
     }
     print_r($html);
     echo count($html);
 }





    public function staff_experience_add()
    {
        if($_POST){
           
            $data = $_POST;
            //$staff_experience_exist = $this->staff_enrollment_model->is_staff_experience_exist($data);
            //if($staff_experience_exist == 0){
                $experience_ids  = $this->input->post('experience_id');
                $personal_id    = $this->input->post('personal_id');
                $designation    = $this->input->post('designation');
                $department     = $this->input->post('department');
                $from_date      = $this->input->post('from_date');
                $to_date        = $this->input->post('to_date');
                $total_service  = $this->input->post('total_service');
                $institution    = $this->input->post('institution');
                $city           = $this->input->post('city');
                $mode_of_separation = $this->input->post('mode_of_separation');
                $pf_status      = $this->input->post('pf_status');
                $pf_ac_no       = $this->input->post('pf_ac_no');
                if(!empty($experience_ids)) {
                foreach($experience_ids as $key=>$experience_id) {
                if($experience_id!='') {
                $designationedit    = $this->input->post('designationedit');
                $departmentedit     = $this->input->post('departmentedit');
                $from_dateedit      = $this->input->post('from_dateedit');
                $to_dateedit        = $this->input->post('to_dateedit');
                $total_serviceedit  = $this->input->post('total_serviceedit');
                $institutionedit    = $this->input->post('institutionedit');
                $cityedit           = $this->input->post('cityedit');
                $mode_of_separationedit = $this->input->post('mode_of_separationedit');
                $pf_statusedit      = $this->input->post('pf_statusedit');
                $pf_ac_noedit       = $this->input->post('pf_ac_noedit');
                $data = array('designation'=>$designationedit[$key],
                              'department'=>$departmentedit[$key],
                              'from_date'=>$from_dateedit[$key],
                              'to_date'=>$to_dateedit[$key],
                              'total_service'=>$total_serviceedit[$key],
                              'institution'=>$institutionedit[$key],
                              'city'=>$cityedit[$key],
                              'mode_of_separation'=>$mode_of_separationedit[$key],
                              'pf_status'=>$pf_statusedit[$key],
                              'pf_ac_no'=>$pf_ac_noedit[$key]
                             );
                $res            = $this->staff_enrollment_model->staff_experience_edit($data, $experience_id);
                }
                }
                if($res = 1){
                    $what = $this->db->last_query();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'database', $who, $what, $experience_id, 'am_staff_experience');
                    $staff_experience_array=$this->staff_enrollment_model->get_staff_experiencedetails_by_id($experience_id);
                    $html=$experience_id;
                }
                if(!empty($designation)) {
                foreach($designation as $key=>$desi) {
                if($desi!='') {
                $data = array('personal_id'=>$personal_id,
                             'designation'=>$desi,
                              'department'=>$department[$key],
                              'from_date'=>$from_date[$key],
                              'to_date'=>$to_date[$key],
                              'total_service'=>$total_service[$key],
                              'institution'=>$institution[$key],
                              'city'=>$city[$key],
                              'mode_of_separation'=>$mode_of_separation[$key],
                              'pf_status'=>$pf_status[$key],
                              'pf_ac_no'=>$pf_ac_no[$key]
                             );
                $res            = $this->staff_enrollment_model->staff_experience_add($data);
                }
                }
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'am_staff_experience');
                    $staff_experience_array=$this->staff_enrollment_model->get_staff_experiencedetails_by_id($table_row_id);
                    $html=$table_row_id;
                }
            }
                } else {
                if(!empty($designation)) {
                foreach($designation as $key=>$desi) {
                if($desi!='') {
                $data = array('personal_id'=>$personal_id,
                             'designation'=>$desi,
                              'department'=>$department[$key],
                              'from_date'=>$from_date[$key],
                              'to_date'=>$to_date[$key],
                              'total_service'=>$total_service[$key],
                              'institution'=>$institution[$key],
                              'city'=>$city[$key],
                              'mode_of_separation'=>$mode_of_separation[$key],
                              'pf_status'=>$pf_status[$key],
                              'pf_ac_no'=>$pf_ac_no[$key]
                             );
                $res            = $this->staff_enrollment_model->staff_experience_add($data);
                }
                }
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $table_row_id, 'am_staff_experience');
                    $staff_experience_array=$this->staff_enrollment_model->get_staff_experiencedetails_by_id($table_row_id);
                    $html=$table_row_id;
                }
            }
            //}else{
            //    $html=-1;//already exist
            //}

        }
             print_r($html);
    }
    }

/*
*   function'll update staff approval
*   @params approval form array
*   @author GBS-R
*/


public function staff_approvalform() {
    if($_POST){
        $personal_id    = $this->input->post('personal_id');
        if($personal_id!='') {
        $query  = $this->staff_enrollment_model->update_approval_data($_POST, $personal_id);
        $staff = $this->common->get_from_tablerow('am_staff_personal', array('personal_id'=>$personal_id));   
            if(!empty($staff)) {
                $this->db->where('user_id', $staff['user_id']);
                $this->db->update('am_users_backoffice', array('user_status'=>1));
            }
        if($query) {
        $result['status']   =   true;
        $result['message']  =   'Data successfully updated';
        $result['data']     =   $_POST;
        } else {
        $result['status']   =   false;
        $result['message']  =   'Error while updating data';
        $result['data']     =    $personal_id;
        }
        } else {
        $result['status']   =   false;
        $result['message']  =   'Invalid data';
        $result['data']     =   null;
        }
    } else {
        $result['status']   =   false;
        $result['message']  =   'Invalid data';
        $result['data']     =   null;
    }
     print_r(json_encode($result));
}

    
/*
*   function'll list availablity of faculty
*   @params 
*   @author GBS-R
*/

function manage_faculty_availablity() {
    check_backoffice_permission('manage_faculty_availablity');
    $this->data['page']="admin/faculty_availability_list";
    $this->data['menu']="staff";
    $this->data['breadcrumb']="Manage Faculty";
    $this->data['menu_item']="backoffice/manage-faculty-availablity";
    $this->data['staffArr']=$this->staff_enrollment_model->get_faculty_list();
    $this->data['availabilityArr']=$this->staff_enrollment_model->get_faculty_availability_list();
    $this->data['groupArr']      = $this->institute_model->get_allgroups();
    $this->data['centreArr']      = $this->common->get_from_tableresult('am_institute_master',array('institute_type_id'=>3,'status'=>1));
    $this->load->view('admin/layouts/_master',$this->data);
}
    
/*
*   function'll save faculty availablity
*   @params POST array
*   @author GBS-R
*/
    
    public function faculty_availability_action() { 
        if($_POST){
            if($this->input->post('start_date')) {
                $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            } else {
                $start_date = '0000-00-00';
            }
            
            if($this->input->post('end_date')) {
                $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            } else {
                $end_date = '0000-00-00';
            }
            if($this->input->post('sun')) { $sun = $this->input->post('sun');} else {$sun = 0;}
            if($this->input->post('mon')) { $mon = $this->input->post('mon');} else {$mon = 0;}
            if($this->input->post('tue')) { $tue = $this->input->post('tue');} else {$tue = 0;}
            if($this->input->post('wed')) { $wed = $this->input->post('wed');} else {$wed = 0;}
            if($this->input->post('thu')) { $thu = $this->input->post('thu');} else {$thu = 0;}
            if($this->input->post('fri')) { $fri = $this->input->post('fri');} else {$fri = 0;}
            if($this->input->post('sat')) { $sat = $this->input->post('sat');} else {$sat = 0;}
            $exist=$this->common->check_if_dataExist('am_faculty_availability',array('staff_id'=>$this->input->post('faculty'),'center_id'=>$this->input->post('center_name')));
            if($exist ==0)
            {
            $data = array('staff_id'=>$this->input->post('faculty'),
                         'type'=>$this->input->post('type'),
                          'center_id'=>$this->input->post('center_name'),
                          'day_sun'=>$sun,
                          'day_mon'=>$mon,
                          'day_tue'=>$tue,
                          'day_wed'=>$wed,
                          'day_thu'=>$thu,
                          'day_fri'=>$fri,
                          'day_sat'=>$sat,
                          'date_from'=>$start_date,
                          'date_to'=>$end_date
                         );
            $insert = $this->Common_model->insert('am_faculty_availability', $data);
            if($insert) {
                $result['status']   =   true;
                $result['message']  =   'Faculty availability successfully saved.';
                $result['data']     =  $data;  
            } else {
                $result['status']   =   false;
                $result['message']  =   'Can"t connected to server.';
                $result['data']     =   null; 
            }
            }
            else
            {
               $result['status']   =   2;
                $result['message']  =   'This faculity is already available in this centre';
                $result['data']     =   null;
            }
        } else {
            $result['status']   =   false;
            $result['message']  =   'Invalid data';
            $result['data']     =   null;
        }
        
        print_r(json_encode($result));
    }
    
    
        
/*
*   function'll list availablity of faculty via AJAX
*   @params 
*   @author GBS-R
*/

function faculty_availability_loadajax() {
    $html = '<thead>
            <tr>
                <th>'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('faculty_name').'</th>
                <th>'.$this->lang->line('centre').'</th>
                <th>'.$this->lang->line('available_days').'</th>
                <th>'.$this->lang->line('action').'</th>
            </tr>
        </thead>';
    $data = $this->staff_enrollment_model->get_faculty_availability_list();
    if(!empty($data)) {
        $i = 1;
        foreach($data as $d) {
           $availability="";
            $days="";
            if($d->type == 1)
            {
              if($d->day_sun == 1){ $days.= " Sun ,"; }
              if($d->day_mon == 1){ $days.= " Mon ,"; }
              if($d->day_tue == 1){ $days.= " Tue ,"; }
              if($d->day_wed == 1){ $days.= " Wed ,"; }
              if($d->day_thu == 1){ $days.= " Thu ,"; }
              if($d->day_fri == 1){ $days.= " Fri ,"; }
              if($d->day_sat == 1){ $days.= " Sat "; }
                $days = rtrim($days, ',');
                $availability= $days;
            }
          else
          {
            $from=date('d/m/Y',strtotime($d->date_from));
            $to=date('d/m/Y',strtotime($d->date_to));
              $availability= $from ." to ".$to;
          }
            $html .= '<tr>
                        <td>'.$i.'</td>
                        <td>'.$d->name.'</td>
                        <td>'.$d->institute_name.'</td>
                        <td>'.$availability.'</td>
                        <td><button class="btn btn-default option_btn" onclick="get_data('.$d->avai_id.')">
                        <i class="fa fa-pencil"></i>
                        </button>
                            <button class="btn btn-default option_btn" onclick="delete_availability('. $d->avai_id.')">
                        <i class="fa fa-trash-o"></i>
                    </button>
                    </tr>';
            $i++;
        }
    }
    echo $html;
}
 /*
*   function'll list staff via AJAX
*   @params
*   @author GBS-L
*/
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
            "am_staff_personal.role",
            "am_staff_personal.mobile",
            "am_staff_personal.status"

        );

         if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }

           if(empty($this->input->post('search')['value']))
        {
            $list = $this->staff_enrollment_model->get_all_staffList_by_ajax($start, $length, $order, $dir);

              //echo "<pre>"; print_r($list);
        }
        else {
            $search = $this->input->post('search')['value'];

            $list = $this->staff_enrollment_model->get_all_staffList_by_ajax_search($start, $length, $order, $dir,$search);

        }

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $rows) {
            $role_name=$this->common->get_name_by_id('am_roles','role_name',array("role"=>$rows['role']));
            
            $login_status=$this->common->get_name_by_id('am_users_backoffice','user_status',array("user_id"=>$rows['user_id']));
            if($login_status == "1")
            {
               $status='<span class="btn mybutton  mybuttonActive" onclick="edit_staff_status('.$rows['personal_id'].','.$rows['status'].');">
                               '.$this->lang->line('Active').'</span>'; 
            }
            elseif($login_status == "0")
            {
                $status='<span class="btn mybutton  mybuttonInactive" onclick="edit_staff_status('.$rows['personal_id'].','.$rows['status'].');">
                               '.$this->lang->line('Inactive').'</span>';
            }

            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $rows['name'];
            $row[] = $role_name;
            $row[] = $rows['mobile'];
            $row[] = $status;
            $row[] = '<a href="'.base_url().'backoffice/manage-staff/'.$rows['personal_id'].'" name="personal_id" id="clicker" data-personal="'. $rows['personal_id'].'">
                        <button class="btn btn-default option_btn add_new_btn">
                            <i class="fa fa-pencil "></i>
                        </button>
                        </a>
                        <a class="btn btn-default option_btn  " onclick="delete_staff_personals('. $rows['personal_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
            $data[] = $row;
        }

        $total_rows=$this->staff_enrollment_model->get_num_staffList_by_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
}

function send_email($type, $email, $data) {


    $this->email->to($email);
    $this->email->subject($type);
    $this->email->message($data);
    $this->email->send();
 }

    
 public function upload_documents_action()
 {
    $result=array();
    if($_POST){
        $pers_id=$this->input->post('pers_id');
        $education_id=$this->input->post('education_id');
        $category=$this->input->post('category');
        // print_r($category);
        $document_name1=$this->input->post('document_name1');
        $category=$this->input->post('category');
        $verification=$this->input->post('verification1');
       
        // foreach($category as $key=>$item)
        // {


           
        //        if($_FILES['file_name1']['name'][$key] != "")
        //        {
        //               if($verification[$key]== "0")
        //                {
        //                  // echo "verify";
        //                    $result['st'] = 6;
        //                    $result['message'] = 'Please Verify the document before the file choose';
        //                    print_r(json_encode($result));
        //                    return false;
        //               }
        //        }
        //         else
        //         {
        //                    $result['st'] = 6;
        //                    $result['message'] = 'Please Upload the document';
        //                    print_r(json_encode($result));
        //                    return false;
        //         }

         

        // }




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
                if($files['file_name1']['size'][$i]>10000){
                    //$err=1;
                }
            }
        }
        
        if($err==0) {
        for($i=0;$i<count($this->input->post('document_name1'));$i++){
            $education_id=$this->input->post('education_id')[$i];
            $document_name1=$this->input->post('document_name1')[$i];
            $verification1=$this->input->post('verification1')[$i];
            $doc_exist = $this->staff_enrollment_model->is_doc1_exist($pers_id,$document_name1,$education_id);
            if($doc_exist == 0){ 
                if($_FILES['file_name1']['name'][$i]!=''){
                    $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/staff_documents';
                    $config['file_name'] = $fileName = "cert_".$pers_id."_".uniqid();
                    $config['allowed_types'] ='jpg|pdf|docx|doc|JPG|PDF|jpeg|JPEG';
                    $config['max_size'] = '10000';
                    $this->load->library('upload', $config);
                    $_FILES['userfile']['name']= $files['file_name1']['name'][$i];
                    $_FILES['userfile']['type']= $files['file_name1']['type'][$i];
                    $_FILES['userfile']['tmp_name']= $files['file_name1']['tmp_name'][$i];
                    $_FILES['userfile']['error']= $files['file_name1']['error'][$i];
                    $_FILES['userfile']['size']= $files['file_name1']['size'][$i]; 
                    if ($this->upload->do_upload('userfile')) {
                        $upload_data = $this->upload->data();
                        $file_name = 'uploads/staff_documents/'.$upload_data['file_name'];
                        $data=array(
                            'personal_id'=>$pers_id,
                            'education_id'=>$education_id,
                            'document_name'=>$upload_data['file_name'],
                            'specification'=>$document_name1,
                            'verification'=>$verification1,
                            'file'=>$file_name
                        );
                        $exist = $this->common->get_from_tablerow('am_staff_documents', array('personal_id'=>$pers_id,'education_id'=>$education_id,'status'=>1));//print_r($exist); die();
                        if(!empty($exist)) { 
                        $res = $this->staff_enrollment_model->upload_staff_documents_edit($data, array('personal_id'=>$pers_id,'education_id'=>$education_id));    
                        } else { 
                        $res = $this->staff_enrollment_model->upload_staff_documents($data);
                        }
                        $result['st'] = 1;
                        $result['message'] = 'Successfully saved';
                        $result['data'] = array(
                            "staff_documents_id"=>$res,
                            "file"=>base_url($file_name)
                        );
                    }else{ 
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
        $documents['staffEdit']['personal_id'] = $pers_id;
        $documents['documents'] = $this->staff_enrollment_model->get_staff_documents($pers_id);
        $documents     = $documents['documents'];
        // echo '<pre>';
        // print_r($documents['documents']);
        $html = $this->load->view('admin/staff_enrollment',$documents,TRUE);
//      $content = '<li class="data_table_head ">
//                    <div class="col">Qualification name</div>
//                    <div class="col">Document file</div>
//                    <div class="col">Verified</div>
//                    <div class="col actions">Actions</div>
//                </li>';
//                if(!empty($documents)) {
//                foreach($documents as $row){ 
//               $content .= '<li id="row_'.$row->staff_documents_id.'">';
//                if(!empty($row->education_id)){
//                 $content .= '<div class="col">
//                                '.$row->specification.'
//                            </div>';
//                        }else{ 
//                            $content .= '<div class="col">
//                               '.$row->document_name.'
//                            </div>';
//                        }
//                        $content .= '<div class="col">
//                            <a target="_blank" href="'.base_url($row->file).'">Download document</a>
//                        </div>
//                        <div class="col">
//                            Yes &nbsp;<input type="radio" name="verfied'.$row->staff_documents_id.'"'; 
//                                if($row->verification==1){
//                                echo $content .= 'checked="checked"';
//                                }
//                                $content .= 'value="1" onclick="verify_document(
//                            '.$row->staff_documents_id.');"> &nbsp;&nbsp;&nbsp; No &nbsp;<input type="radio" name="verfied'.$row->staff_documents_id.'"';
//                            if($row->verification==0){
//                                    $content .= 'checked="checked"';
//                                }
//$content .= 'value="0" onclick="unverify_document('.$row->staff_documents_id.');">
//                        </div>
//                        <div class="col actions">
//                            <button class="btn btn-default btn_details_view" onclick="delete_docs('.$row->staff_documents_id.')">
//                                <i class="fa fa-trash-o"></i>
//                            </button>
//                        </div>
//                    </li>';
//                }}else { 
//                    $content .= '<li>Please add some documents.</li>';
//                 }
//            $result['data'] = $content;
        
        }else{
            $result['st'] = 3;
            $result['message'] = "The file you trying to upload is invalid, please upload .pdf,.docx,.jpg files only (Max Size:10MB).";
        }  
    }else{
        $result['st'] = 5;
        $result['message'] = 'Network error';
    }
    print_r(json_encode($result));
 }

 public function upload_documents()
 {
     if($_POST){
         $data = $_POST;
         $doc_exist = $this->staff_enrollment_model->is_doc_exist($data);
         if($doc_exist == 0){ 
             $personal_id=$this->input->post('personal_id');
             $education_id=$this->input->post('edu_id');
             $document_name=$this->input->post('document_name');
             $verification=$this->input->post('verification');
             $file_name = str_replace(' ', '_', $_FILES['file_name']['name']);
             if($_FILES['file_name']['name']!=''){
                 $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/staff_documents';
                 $config['file_name'] = "document_".$personal_id."_".$file_name;
                 $config['allowed_types'] ='jpg|pdf|docx|doc';
                 $config['max_size'] = '10000';
                 $this->load->library('upload', $config);
                 if ($this->upload->do_upload('file_name')) {
                     $upload_data = $this->upload->data();
                     $file_name = 'uploads/staff_documents/'.$config['file_name'];
                     $data=array(
                         'personal_id'=>$personal_id,
                         'education_id'=>$education_id,
                         'document_name'=>$document_name,
                         'specification'=>'',
                         'verification'=>$verification,
                         'file'=>$file_name
                     );
                     $res = $this->staff_enrollment_model->upload_staff_documents($data);
                     $result['st'] = 1;
                     $result['message'] = 'Successfully saved';
                     $result['data'] = array(
                         "staff_documents_id"=>$res,
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

 
 public function verify_document(){
    if($_POST){
        $this->staff_enrollment_model->verify_staff_document($this->input->post('id'),$this->input->post('status'));
    }
}

public function get_staff_documents(){
    if($_POST){
        $personal_id = $this->input->post('id');
        $documents = $this->staff_enrollment_model->get_staff_documents($personal_id);

        $html = '<li class="data_table_head ">
                    <div class="col">Document name</div>
                    <div class="col">Document file</div>
                    <div class="col">Verification status</div>
                    <div class="col actions">Actions</div>
                </li>';
                if(!empty($documents)) {
                    foreach($documents as $row){ 
                        $html = $html.'<li id="row_'.$row->staff_documents_id.'">';
                        if(!empty($row->education_id)){
                            $html = $html.'<div class="col">'.$row->specification.'</div>';
                        }else{
                            $html = $html.'<div class="col">'.$row->document_name.'</div>';
                        }
                        $html = $html.'<div class="col"><a target="_blank" href="'.base_url($row->file).'">Download document</a></div>
                            <div class="col">';
                            
                        $html = $html.'Yes &nbsp;<input type="radio" name="verfied'.$row->staff_documents_id.'" ';
                            if($row->verification==1){$html = $html.' checked="checked" ';}
                        $html = $html.'value="1" onclick="verify_document('.$row->staff_documents_id.');">';

                        $html = $html.'&nbsp;&nbsp;&nbsp';
                            
                        $html = $html.'No &nbsp;<input type="radio" name="verfied'.$row->staff_documents_id.'" ';
                            if($row->verification==0){$html = $html.' checked="checked" ';}
                        $html = $html.'value="0" onclick="unverify_document('.$row->staff_documents_id.');">';

                        $html = $html.'</div>
                            <div class="col actions">
                                <!--<button class="btn btn-default option_btn" onclick="edit_document('.$row->staff_documents_id.');">
                                    <i class="fa fa-pencil "></i>
                                </button>-->
                                <button class="btn btn-default option_btn" onclick="delete_fromtable('.$row->staff_documents_id.')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </li>';
                    }
                }
        print_r($html);
    }

}
    public function edit_faculity_availability()
    {
        if($_POST){

            $id=$this->input->post('edit_id');
            if($this->input->post('type') == "2")
            {
                $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                $sun = 0;
                $mon = 0;
                $tue = 0;
                $wed = 0;
                $thu = 0;
                $fri = 0;
                $sat = 0;
            }
            else {
                  $start_date = '0000-00-00';
                  $end_date = '0000-00-00';
                  $sun = $this->input->post('sun');
                  $mon = $this->input->post('mon');
                  $tue = $this->input->post('tue');
                  $wed = $this->input->post('wed');
                  $thu = $this->input->post('thu');
                  $fri = $this->input->post('fri');
                  $sat = $this->input->post('sat');
              }
            $data = array('staff_id'=>$this->input->post('faculty'),
                         'type'=>$this->input->post('type'),
                          'center_id'=>$this->input->post('center_name'),
                          'day_sun'=>$sun,
                          'day_mon'=>$mon,
                          'day_tue'=>$tue,
                          'day_wed'=>$wed,
                          'day_thu'=>$thu,
                          'day_fri'=>$fri,
                          'day_sat'=>$sat,
                          'date_from'=>$start_date,
                          'date_to'=>$end_date
                         );
 $exist=$this->common->check_if_dataExist('am_faculty_availability',array('staff_id'=>$this->input->post('faculty'),'center_id'=>$this->input->post('center_name'),'avai_id!='=>$id));
            if($exist == 0){
            $update = $this->Common_model->update('am_faculty_availability', $data,array('avai_id'=>$id));

            if($update) {

                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'am_faculty_availability');

                $result['status']   =   true;
                $result['message']  =   'Faculty availability successfully Updated.';
                $result['data']     =  $data;
            } else {
                $result['status']   =   false;
                $result['message']  =   'Can"t connected to server.';
                $result['data']     =   null;
            }
            }
            else
            {
                $result['status']   =   2;
                $result['message']  =   'This faculity already available under this centre.';
                $result['data']     =   null;
            }
        } else {
            $result['status']   =   false;
            $result['message']  =   'Invalid data';
            $result['data']     =   null;
        }

        print_r(json_encode($result));
    }

    public function get_faculity_availability_data()
    {
      if($_POST)
      {

          $data=$this->staff_enrollment_model->get_faculty_availability_list_byId($this->input->post('id'));
         $data['date_from']=date('d-m-Y',strtotime($data['date_from']));
         $data['date_to']=date('d-m-Y',strtotime($data['date_to']));
          $ajax_data['data']=$data;
          $center_id=$data['center_id'];
          $branch_id=$data['parent_institute'];
          $ajax_data['group_id']=$this->common->get_name_by_id('am_institute_master','parent_institute',array("institute_master_id"=>$branch_id));


            $subArr=$this->institute_model->get_allsub_byparent(array('parent_institute'=> $ajax_data['group_id']));

            $ajax_data['branches']= '<option value="">Select</option>';
            if(!empty($subArr)){
            foreach ($subArr as $row)
            {
                $ajax_data['branches'].= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
            }
          $subArray=$this->institute_model->get_allsub_byparent(array('parent_institute'=> $data['parent_institute']));

            $ajax_data['centres']= '<option value="">Select</option>';
            if(!empty($subArray)){
            foreach ($subArray as $row)
            {
                $ajax_data['centres'].= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
            }
          print_r(json_encode($ajax_data));
      }
    }
    //delete faculity avilability
    public function delete_staff_availability()
    {
        if($_POST)
        {
            $id=$this->input->post('id');
            $res = $this->common->delete_fromwhere('am_faculty_availability', array('avai_id'=>$id), array('status'=>'2'));
            if($res)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']='Staff Availability Details Deleted Successfully..!';
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'am_faculty_availability','delete staff availability');
            }
            else
            {
                 $ajax_response['st']=2;
                 $ajax_response['msg']='Something went wrong,Please try again later..!';
            }
        print_r(json_encode($ajax_response));

        }
    }

public function delete_faculty()
    {
        $id  = $_POST['id'];
        $res = $this->staff_enrollment_model->delete_faculty($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'am_faculty_availability');
        }
        print_r($res);     
    }

    // public function delete_fromwhere()
    // {
    //     $id      = $this->input->post('id');
    //     $where = array('avai_id'=>$id);
    //     $data  = array('status'=>2);

    //     $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];


    //             $query = $this->common->delete_fromwhere('am_faculty_availability', $where, $data);
    //      if($query) {
    //             $res['status']   = 1;
    //             $res['message']  = 'Faculty Availability Details deleted successfully';
    //             $what = $this->db->last_query();
    //             $table_row_id    = $this->db->insert_id();
    //             logcreator('delete', 'database', $who, $what, $id, 'am_faculty_availability','Faculty Availability Details Deleted');

    //     } else {

    //        $res['status']   = 0;
    //        $res['message']  = 'Something went wrong.Please try again later..!';

    //     }
    //     print_r(json_encode($res));
    // }

    // public function log() {
    //     logcreator($action = '', $objecttype = '', $who = '', $what = '', $table_row_id = '', $tablename='');
    // }

    public function fetch()
    {
        
        $query= $this->db->get_where('am_staff_personal',array("role"=>'5'));
        // $this->data['courseArr']=$this->staff_enrollment_model->getall_list();
        $output = '';
        $filter_name = '';
        $filter_role = '';
        $filter_subject = '';
        $filter_name = $this->input->post('filter_name');
        $filter_role = $this->input->post('filter_role');
        if(!empty($this->input->post('subject')))
          {
             $filter_subject = $this->input->post('subject');  
          }
        
        $data = $this->staff_enrollment_model->fetch_data($filter_name,$filter_role,$filter_subject);
     
    
        $output .= '
            <div class="table-responsive table_language" style="margin-top:15px;">        
                <table id="staff_table" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50">Sl. No.</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Mobile Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
            ';
        if($data->num_rows() > 0){
            $i=1;
            foreach($data->result() as $row){
                
                $login_status=$this->common->get_name_by_id('am_users_backoffice','user_status',array("user_id"=>$row->user_id));
                if($login_status == "1")
                {
                  $status='<span class="btn mybutton  mybuttonActive" onclick="edit_staff_status('.$row->personal_id.','.$row->status.');">
                               '.$this->lang->line('Active').'</span>'; 
                }
                elseif($login_status == "0")
                {
                    $status='<span class="btn mybutton  mybuttonInactive" onclick="edit_staff_status('.$row->personal_id.','.$row->status.');">
                                   '.$this->lang->line('Inactive').'</span>';
                }
                $output .= '
                            <tr>
                            <td>'.$i.'</td>
                            <td> '.$row->name.'</a></td>
                            <td>'.$row->role_name.'</td>
                            <td>'.$row->mobile.'</td>
                            <td>'.$status.'</td>
                            <td>
                                <a href="'.base_url() .'backoffice/manage-staff/'.$row->personal_id.'" name="personal_id" id="clicker" data-personal="'.$row->personal_id.'">
                                    <button class="btn btn-default option_btn add_new_btn">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                </a>
                                <a class="btn btn-default option_btn  " onclick="delete_staff_personals('.$row->personal_id.')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                            </tr>';
                            $i++;
                        }
                $output .=' </table>
                </div>';
        }
        echo $output;
    }

    public function primary_mobileCheck()
    {
        $mobile=$this->input->post('mobile');
        $query= $this->db->get_where('am_staff_personal',array("mobile"=>$mobile));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }

    public function delete_others()
    {
        $id  = $_POST['id'];
        $res = $this->staff_enrollment_model->delete_others($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'database', $who, $what, $id, 'am_staff_education');
        }
        print_r($res); 
        // if($_POST){
        //     $result = $this->student_model->delete_student_others($this->input->post('id'));
        // }   
    }

    public function delete_staff_document(){
        if($_POST){
            $result = $this->staff_enrollment_model->delete_staff_document($this->input->post('id'));
        }
    }

    public function append_document()
    {
        $id = $this->input->post('id');
        $staffEdit = $this->staff_enrollment_model->get_staff_personal_by_id($id);
        // echo '<pre>';
        // print_r($staffEdit);
        // die();
        $html = '';
        $html .= '   <form id="all_qualification_form" method="post" enctype="multipart/form-data">
                    <div id="section_duplicates2">
                        <hr class="no_hr" />
                        <div class="add_wrap">
                            <div class="row" id="result">
                                <input type="hidden" name="pers_id" class="form-control" id="pers_id" value="'.$staffEdit["personal_id"].'" />
                                <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />';
                                $allqualificationArr = $this->common->get_all_others($staffEdit["personal_id"]);
                                if(!empty($allqualificationArr)){
                                $i=1; 
                                $query = array();
                                foreach($allqualificationArr as $rows){
                            $html .= '<input type="hidden" name="education_id[]" id="education_id" value="'.$rows["education_id"].'" />';
                                    $query=  $this->common->get_staff_docs($rows["personal_id"],$rows["education_id"]); 
                            $html .= '<input type="hidden" name="files" id="files" value="'.$query["file"].'" />';
                                    if($rows["category"]=="Classx"){
                                $html .= '<div class="col-sm-4">
                                            <div class="form-group">
                                                <label>SSLC</label>
                                                <input type="hidden" name="category[]" value="'.$rows["category"].'"/>
                                                <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows["specification"].'" placeholder="Document Name" />
                                            </div>
                                        </div>';
                                    }else if($rows["category"]=="Classxii"){ 
                                $html .= '<div class="col-sm-4">
                                            <div class="form-group">
                                                <label>+2/VHSE</label>
                                                <input type="hidden" name="category[]" value="'.$rows["category"].'"/>
                                                <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows["specification"].'" placeholder="Document Name" />
                                            </div>
                                        </div>';
                                    }else if($rows["category"]=="Degree"){ 
                                $html .= '<div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Degree</label>
                                                <input type="hidden" name="category[]" value="'.$rows["category"].'"/>
                                                <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows["specification"].'" placeholder="Document Name" />
                                            </div>
                                        </div>';
                                    }else if($rows["category"]=="PG"){ 
                                $html .= '<div class="col-sm-4">
                                            <div class="form-group">
                                                <label>PG</label>
                                                <input type="hidden" name="category[]" value="'.$rows["category"].'"/>
                                                <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows["specification"].'" placeholder="Document Name" />
                                            </div>
                                        </div>';
                                    }else { 
                                $html .= '<div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Additional Qualification</label>
                                                <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="'.$rows["specification"].'" placeholder="Document Name" />
                                            </div>
                                        </div>';
                                    } 
                                $html .= '<div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Upload File';
                                                if(!empty($query)){ $html .= ' : '.$query['document_name'];} 
                                        $html .= '</label>
                                                <input type="file"  id="file" class="form-control doc_upload myFile"   name="file_name1[]"  multiple="multiple" value="" onchange="validate(this.value)"/>
                                                <p>Upload .pdf,.docx,.jpg files only  (Max Size:10MB).</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label style="display:block">Verified</label>
                                                <select class="form-control"  id="document_verification1" name="verification1[]" value= "">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>';
                                    $i++;}
                                    $html .= '<div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" id= "submit"  class="btn btn-info btn_save">Save</button>
                                    </div>
                                </div>';
                                }
                        
                                $html .= '</div>
                        </div>
                    </div>
              </form> ';
        // $return_array['first'] = $html;
        // print_r(json_encode($return_array));
        echo $html;
        
    }
    
    //
    public function fetch_facultydata()
    {
        if($_POST)
        {

             $output = '';
        $filter_name = '';
        $filter_role = '';
        $filter_subject = '';
        $filter_name = $this->input->post('name');
        $filter_centre = $this->input->post('centre');
        $data = $this->staff_enrollment_model->fetch_facultydata($filter_name,$filter_centre);


    
        $output .= '<div class="table-responsive table_language" style="margin-top:15px;">
                <table id="staff_table" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="50">'.$this->lang->line('sl_no').'</th>
                            <th>'.$this->lang->line('faculty_name').'</th>
                            <th>'.$this->lang->line('centre').'</th>
                            <th>'.$this->lang->line('available_days').'</th>
                            <th>'.$this->lang->line('action').'</th>
                        </tr>
                    </thead>';
        if($data->num_rows() > 0){
            $i=1;
            foreach($data->result() as $row){
                $days="";
                                    if($row->type ==1)
                                    {
                                      if($row->day_sun == 1){ $days.= "Sun ,"; }
                                      if($row->day_mon == 1){ $days.= "Mon ,"; }
                                      if($row->day_tue == 1){ $days.= "Tue ,"; }
                                      if($row->day_wed == 1){ $days.= "Wed ,"; }
                                      if($row->day_thu == 1){ $days.= "Thu ,"; }
                                      if($row->day_fri == 1){ $days.= "Fri ,"; }
                                      if($row->day_sat == 1){ $days.= "Sat "; }
                                     $days = rtrim($days, ',');
                                    }
                                  else
                                  {
                                    $from=date('d/m/Y',strtotime($row->date_from));
                                    $to=date('d/m/Y',strtotime($row->date_to));
                                      $days= $from ." to ".$to;
                                  }

                $output .= '<tr>
                            <td>'.$i.'</td>
                            <td> '.$row->name.'</a></td>
                            <td>'.$row->institute_name.'</td>
                            <td>'.$days.'</td>
                            <td><button class="btn btn-default option_btn" onclick="get_data('.$row->avai_id.')"> <i class="fa fa-pencil "></i> </button><button class="btn btn-default option_btn" onclick="delete_availability('.$row->avai_id.')"><i class="fa fa-trash-o"></i></button>
                            </td>
                            </tr>';
                            $i++;
                        }
                $output .='</table>
                </div>';
        }
        echo $output;
        }
    }

    function get_leave_scheme_drop_down_get(){
        $data['data'] = $this->staff_enrollment_model->get_leave_scheme_drop_down();
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }

    function get_salary_scheme_drop_down_get(){
        $data['data'] = $this->staff_enrollment_model->get_salary_scheme_drop_down();
        if (!$data) {
            echo json_encode(['message' => 'error','viewMessage' => 'Error Occured']);
            return;
        }
        $this->response($data);
    }
public function edit_staff_status()
{
       if($_POST)
       {
           $id=$this->input->post('id');
           $exist=$this->common->check_if_dataExist('am_schedules',array("staff_id"=>$id,"schedule_date>="=>date("Y-m-d")));
          if($exist >0)
           {
              $ajax_response['st']=2; 
              $ajax_response['msg']="This staff is already in a schedule";
              print_r(json_encode($ajax_response));
              exit();
            }
           if($this->input->post('status')== "1")
           {
             $status=0;  
           }
           else
           {
             $status=1;   
           }
          $response=$this->Common_model->update('am_staff_personal', array("status"=>$status), array("personal_id"=>$id));
           if($response)
           {
              $ajax_response['st']=1; 
              $ajax_response['msg']="Successfully Updated Status"; 
           }
           else
           {
               $ajax_response['st']=0; 
               $ajax_response['msg']="Somethimg went wrong,Please try again later..!";
           }
       }
        else
        {
            $ajax_response['st']=0; 
            $ajax_response['msg']="Somethimg went wrong,Please try again later..!";
        }
    print_r(json_encode($ajax_response));
}
 public function load_staffList()
 {
   $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('name').'</th>
                        <th>'.$this->lang->line('role').'</th>
                        <th>'.$this->lang->line('mobile_no').'</th>
                        <th>'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
         $staffArr=$this->staff_enrollment_model->get_staff_list();
       
        if(!empty($staffArr)) 
        {
            $i=1; 
            foreach($staffArr as $row)
            {
                $login_status=$this->common->get_name_by_id('am_users_backoffice','user_status',array("user_id"=>$row['user_id']));
                if($login_status == "1")
                {
                  $status='<span class="btn mybutton  mybuttonActive" onclick="edit_staff_status('.$row['personal_id'].','.$row['status'].');">
                               '.$this->lang->line('Active').'</span>'; 
                }
                elseif($login_status == "0")
                {
                    $status='<span class="btn mybutton  mybuttonInactive" onclick="edit_staff_status('.$row['personal_id'].','.$row['status'].');">
                                   '.$this->lang->line('Inactive').'</span>';
                }
                $html .= '
                            <tr>
                            <td>'.$i.'</td>
                            <td> '.$row['name'].'</a></td>
                            <td>'.$row['role_name'].'</td>
                            <td>'.$row['mobile'].'</td>
                            <td>'.$status.'</td>
                            <td>
                                <a href="'.base_url() .'backoffice/manage-staff/'.$row['personal_id'].'" name="personal_id" id="clicker" data-personal="'.$row['personal_id'].'">
                                    <button class="btn btn-default option_btn add_new_btn">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                </a>
                                <a class="btn btn-default option_btn  " onclick="delete_staff_personals('.$row['personal_id'].')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                            </tr>';
                            $i++;
         }
               
        }
     echo $html;
 }

}
