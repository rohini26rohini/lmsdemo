<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="basic_configuration";
        check_backoffice_permission($module);
    }

    public function index(){
        check_backoffice_permission("manage_syllabus");
		$this->data['page']="admin/syllabus";
		$this->data['menu']="basic_configuration";
		$this->data['syllabusArr']=$this->syllabus_model->get_syllabus_list();
        $this->data['breadcrumb']="Syllabus";
        $this->data['menu_item']="admin-syllabus";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    public function load_upload_academic_syllabus_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >Title</th>
                        <th>Description</th>
                        <th>Document</th>
                        <th >Action</th>
                       

                    </tr>
                </thead>';
        $syllabusArr = $this->syllabus_model->get_syllabus_list();
        if(!empty($syllabusArr)) {
            $i=1; 
            foreach($syllabusArr as $syllabus){ 
                $html .= '<tr id="row_'.$syllabus['syllabus_id'].'">

                    <td >
                        '.$i.'
                    </td>
                    <td id="name_'.$syllabus['syllabus_id'].'">
                        '.$syllabus['syllabus_name'].'
                    </td>
                    <td id="description_'.$syllabus['syllabus_id'].'">
                        '.$syllabus['syllabus_description'].'
                    </td>
                    <td id="file_name_'.$syllabus['syllabus_id'].'">
                   <a target="_blank" class="btn mybutton" href="'.base_url().'uploads/syllabus/'.$syllabus['file_name'].'">View document</a>      
                    </td>

                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_syllabusdata('.$syllabus['syllabus_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_syllabus('.$syllabus['syllabus_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>


                    </td>
                </tr>';

                 $i++; }
        }
        
        echo $html;
    }
    
   //add syllabus
   public function upload_academic_syllabus()
   {
       $data['syllabus_name']        = strtoupper($this->input->post('title'));
       $data['syllabus_description'] = $this->input->post('description');
      // print_r($_FILES);
       if ($_FILES['file_name'] != '') {
           $files = str_replace(' ', '_', $_FILES['file_name']);
           $this->load->library('upload');
           $config['upload_path']           = 'uploads/syllabus/';
           $config['allowed_types']         = 'pdf|doc|docx';
           $_FILES['file_name']['name']     = $files['name'];
           $_FILES['file_name']['type']     = $files['type'];
           $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
           $_FILES['file_name']['size']     = $files['size'];
           $config['file_name']         = 'syllabus_'.time();
           $this->upload->initialize($config);
           $file_ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION); 
           $upload = $this->upload->do_upload('file_name');
           if ($upload) {
               $data['file_name'] = 'syllabus_'.time().".".$file_ext;
               $syllabus_exist = $this->syllabus_model->is_syllabus_exist(array('syllabus_status'=>1,'syllabus_name'=>strtoupper($this->input->post('title'))));
               if($syllabus_exist == 0){
                   $res=$this->syllabus_model->insert_syllabus($data);
                   $what=$this->db->last_query();
                   $table_row_id=$this->db->insert_id();
                   
                   $query = $this->db->select('*');
                   $this->db->where('syllabus_status', '1');
                   $query	=	$this->db->get('am_syllabus');
                   $row_id= $query->num_rows();
                   
                   $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                   logcreator('insert', 'New syllabus inserted', $who, $what, $table_row_id, 'am_syllabus');
                   if($res=1)
                   {
                       $ajax_response['st']=1;
                       $ajax_response['html']='<tr id="row_'.$table_row_id.'"> <td> '.$row_id.'
                           </td><td id="name_'.$table_row_id.'">
                           '.$data['syllabus_name'] .'
                           </td><td id="description_'.$table_row_id.'">
                           '.$data['syllabus_description'] .'
                           </td> <td>
                               <button class="btn btn-default option_btn " title="Edit" onclick="get_syllabusdata('.$table_row_id.')">
                                               <i class="fa fa-pencil "></i>
                                               </button>
                               <a class="btn btn-default option_btn" title="Delete" onclick="delete_syllabus('.$table_row_id.')">
                                               <i class="fa fa-trash-o"></i>
                                               </a>


                           </td><tr>'; 
                   }
               }
               else
               {
                   $ajax_response['st']=2;//already exist
               }
           }
           else
           {
               $ajax_response['st']=3;//can't upload pdf file
               $ajax_response['msg']= $this->upload->display_errors();
           }
       }
       print_r(json_encode($ajax_response));
   
   }
   
  /*edit syllabus*/
function edit_syllabus()
{
    $data['syllabus_name']        = strtoupper($this->input->post('title'));
    $data['syllabus_description'] = $this->input->post('description');
    $id = $this->input->post('syllabus_id');
    // $files = $this->input->post('files');
    $syllabus_exist          = $this->syllabus_model-> get_syllabus($id);
    if ($syllabus_exist != '') {
        $ajax_response['res'] = 0; //already exist
    }else{
        if (!empty($_FILES['file_name']['name'] != '')){
            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            $config['upload_path']           = 'uploads/syllabus/';
            $config['allowed_types']         = 'pdf|docx|doc';
            $_FILES['file_name']['name']     = $files['name'];
            $_FILES['file_name']['type']     = $files['type'];
            $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
            $_FILES['file_name']['size']     = $files['size'];
            $config['file_name']         = 'syllabus_'.time();
            $this->upload->initialize($config);
            $file_ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION); 

            if($this->upload->do_upload('file_name')){
                $data['file_name'] = 'syllabus_'.time().".".$file_ext;

                $ajax_response['res']=$this->syllabus_model->edit_syllabus($data,$id);
                if($ajax_response['res']=1){
                    $ajax_response['res'] = 1; //successfully updated
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Syllabus uploaded', $who, $what, $id, 'am_syllabus');
                }else{
                    $ajax_response['res']=3; //Invalid request
                }
            }else{
                $ajax_response['res']=2; //file type error
                $ajax_response['msg']= $this->upload->display_errors();
            }
        }else if($this->input->post('files')!= ''){
            $data['file_name'] =$this->input->post('files');
            $ajax_response['res']=$this->syllabus_model->edit_syllabus($data,$id);
            if($ajax_response['res']=1){
                $ajax_response['res'] = 1; //successfully updated
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Syllabus updated', $who, $what, $id, 'am_syllabus');
            }else{
                $ajax_response['res']=3; //Invalid request
            }
        }else{
            $ajax_response['res']=4; //file type error
            // $ajax_response['msg']= "No file Exist";
        }
    }
    print_r(json_encode($ajax_response));
}

   
    
    //delete syllabus
   public function delete_syllabus()
    {
        $id         = $_POST['id'];
       
       $check= $this->common->check_if_dataExist('am_classes',array("syllabus_id"=>$id,"status!="=>2));
        if($check==0) {
        $res        = $this->syllabus_model->delete_syllabus($id);
        if($res==1)
                {
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('delete', 'Syllabus deleted', $who, $what, $id, 'am_syllabus');
                }
           $result['status'] = true;
           $result['message'] = 'Action completed successfully';
           $result['data'] =  '';
        } else {
                $result['status'] = false;
               $result['message'] = "Syllabus can't delete, This syllabus is mapped with course.";
               $result['data'] = null; 
        }
        print_r(json_encode($result)); 
        
    }
   
    public function manage_class(){
        check_backoffice_permission('manage_course');
        $this->data['page']="admin/classes";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Course";
        $this->data['menu_item']="admin-class";
        $this->data['schoolArr']=$this->syllabus_model->get_all_schools();
        $this->data['syllabusArr']=$this->syllabus_model->get_syllabus_list();
        $this->data['classesArr']=$this->Class_model->get_class_list();
		$this->load->view('admin/layouts/_master',$this->data);  
    }
    public function courseColor(){
            $details['cE62'] = $this->common->get_classColor('#E62');
            $details['c9c27b0'] = $this->common->get_classColor('#9c27b0');
            $details['c00BCD4'] = $this->common->get_classColor('#00BCD4');
            $details['cb9a709'] = $this->common->get_classColor('#b9a709');
            $details['c0AF'] = $this->common->get_classColor('#0AF');
            $details['c05A'] = $this->common->get_classColor('#05A');
            $details['cE91E63'] = $this->common->get_classColor('#E91E63');
            $details['cFF9800'] = $this->common->get_classColor('#FF9800');
            $details['c191'] = $this->common->get_classColor('#191');
            $details['cFD0'] = $this->common->get_classColor('#FD0');
            $details['c607D8B'] = $this->common->get_classColor('#607D8B');
            $details['cCDDC39'] = $this->common->get_classColor('#CDDC39');
            $details['c305eb1'] = $this->common->get_classColor('#305eb1');
            $details['c913535'] = $this->common->get_classColor('#913535');
            $details['cfa68db'] = $this->common->get_classColor('#fa68db');
            $details['c005020'] = $this->common->get_classColor('#005020');
            // show($details);
            print_r(json_encode($details));
    }
    public function classes_add()
    {
        if($_POST)
        {
            //print_r($_POST);die();
            unset($_POST['ci_csrf_token']);
        $class_data=$_POST;
        $class_name     =$_POST['class_name'];
        $syllabus_id    =$_POST['syllabus_id'];
        $school_id      =$_POST['school_id'];
        $batch_mode_id  =$_POST['batch_mode_id'];
        $result_publish  =$_POST['result_publish'];
        $class          = $this->Class_model->get_class($class_name,$syllabus_id,$school_id,$batch_mode_id);
            if ($class != '') 
            {
                $ajax_response['st'] = 2;//already exist
               
            } 
            else 
            {
                $res=$this->Class_model->classes_add($class_data);
              if($res)
              {   
                  $table_row_id=$this->db->insert_id();
                  $classcode      =  $this->common->createclass_code($_POST, $table_row_id);
                  $this->db->where('class_id', $table_row_id);
                  $this->db->update('am_classes', array('classcode'=>$classcode));
                  $ajax_response['st'] = 1;
                  $what=$this->db->last_query();
                  $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                  logcreator('insert', 'New class created', $who, $what, $table_row_id, 'am_classes');
                  
                 $course_data=$this->Class_model->get_class_by_id($table_row_id);
                 // echo "<pre>";print_r($course_data);
                 /* $ajax_response['html']='<tr id="row_'.$table_row_id.'"> <td> '.$table_row_id.'
                                        </td><td id="class_name_'.$table_row_id.'">
                                            '.$course_data['class_name'] .'
                                            </td><td id="class_code_'.$table_row_id.'">
                                                '.$course_data['classcode'] .'
                                                    </td><td id="syllabus_name_'.$table_row_id.'">
                                                '.$course_data['syllabus_name'] .'
                                                    </td><td id="school_name_'.$table_row_id.'">
                                                '.$course_data['school_name'] .'
                                                    </td><td id="mode_name_'.$table_row_id.'">
                                                '.$course_data['mode_name'] .'
                                                    </td> <td>
                                                    <button class="btn btn-default option_btn "  onclick="get_editdata('.$table_row_id.')">
                                                    <i class="fa fa-pencil "></i>
                                                        </button>
                                                    <a class="btn btn-default option_btn" onclick="delete_classes('.$table_row_id.')">
                                                    <i class="fa fa-trash-o"></i>
                                                    </a></td><tr>';*/
              }
                else
                {
                     $ajax_response['st'] = 0;//error
                }
            }
    }
         print_r(json_encode($ajax_response));
        
    }
    
    
    public function load_course_ajax() {
        $html = '<thead>  
                     <tr>
                    <th>'.$this->lang->line("sl_no").'</th>
                    <th> Course</th>
                    <th> Code</th>
                    <th>Syllabus</th>
                    <th>School</th>
                    <th>Mode </th>
                    <th>Action</th>
                    </tr>
                </thead>';
        $classesArr=$this->Class_model->get_class_list();
        if(!empty($classesArr)){
        $i=1;
            foreach($classesArr as $class){
            $html .= '<tr id="row_'.$class['class_id'].'">
                <td>
                    '.$i.'
                </td>
                <td id="class_name_'.$class['class_id'].'">
                    '.$class['class_name'].'
                </td>
                <td id="class_code_'.$class['class_id'].'">
                    '.$class['classcode'].'
                </td>
                <td id="syllabus_name_'.$class['class_id'].'">
                    '.$class['syllabus_name'].'
                </td>
                <td id="school_name_'.$class['class_id'].'">
                    '.$class['school_name'].'
                </td>
                <td id="mode_name_'.$class['class_id'].'">
                    '.$class['mode_name'].'
                </td>

                    <td>
                        <button class="btn btn-default option_btn add_new_btn" title="Edit" onclick="get_editdata('.$class['class_id'].')">
                                    <i class="fa fa-pencil "></i>
                                    </button>
                    <a class="btn btn-default option_btn  " title="Delete" onclick="delete_classes('.$class['class_id'].')">
                                    <i class="fa fa-trash-o"></i>
                                    </a>


                </td>
            </tr>';
           

                $i++;
            }
        }
        echo $html;
    }
    
    //delete syllabus
   public function delete_classes()
    {
        $id=$_POST['id'];
        $check      = $this->common->check_for_delete('am_institute_course_mapping','course_master_id',$id,'status',1);
        // echo $this->db->last_query(); exit;
        if($check==0) {
            $res= $this->Class_model->delete_classes($id);
            if($res==1)
            {
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'Class deleted', $who, $what, $id, 'am_classes');
            }
            $result['status'] = true;
            $result['message'] = 'Action completed successfully';
            $result['data'] =  '';
        } else {
            $result['status'] = false;
            $result['message'] = "Course can't delete, This course is mapped with center.";
            $result['data'] = null; 
        }
        print_r(json_encode($result));   
        
    }
    
    public function classes_edit(){
     
        if($_POST){
            unset($_POST['ci_csrf_token']);
            $id=$this->input->post('class_id');
            unset($_POST['class_id']);
            $data=$_POST;
            $res=$this->Class_model->edit_classes($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Class updated', $who, $what, $id, 'am_classes');
            }
            print_r($res);
        }
    }

    public function get_class_by_id($class_id){
        $class_array= $this->Class_model->get_class_by_id($class_id);
        print_r(json_encode($class_array));
    }
    
    public function get_syllabus_by_id($syllabus_id)
    {
        $syllabus_array= $this->syllabus_model->get_syllabus_by_id($syllabus_id);
        print_r(json_encode($syllabus_array)); 
        
    }
    
    //manage institute
    public function manage_institute()
    {
        check_backoffice_permission('manage_institute');
        $this->data['page']="admin/institute";
		$this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Manage Institute";
        $this->data['menu_item']="admin-institute";
        $this->data['typeArr']=$this->institute_model->get_institute_type();
        $this->data['instituteArr']=array();
       // $this->data['instituteArr']=$this->institute_model->get_all_institutes();
        //$this->data['parentArr']=$this->institute_model->get_allparent_institutes($type);
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    // Load institute via ajax
    
    public function load_institute_ajax() {
        $html = '<thead><tr>
                <th>'.$this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('institute_name').'</th>
                <th>'.$this->lang->line('institute_type').'</th>
                <th>'.$this->lang->line('parent_institute').'</th>
                <th>'.$this->lang->line('action').'</th>
            </tr></thead>';
        $institutes = $this->institute_model->get_all_institutes();
        if(!empty($institutes)) {
            $i=1;
            foreach($institutes as $institute) {
                $parent_institute = $this->institute_model->get_instituteby_id($institute['parent_institute']);
              $html .= '<tr>
                <td>'.$i.'</td>
                <td>'.$institute['institute_name'].'</td>
                <td>'.$institute['institute_type'].'</td>
                <td>'.$parent_institute.'</td>
                <td><button class="btn btn-default option_btn " title="Edit" onclick="get_institutedata('.$institute['institute_master_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_institute('.$institute['institute_master_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a></td>
            </tr>'; 
                $i++;
        }
    }
    echo $html;
}
    
    //add institute
    public function institute_add()
    {
        //print_r($_POST);
        if($_POST)
        {
            unset($_POST['ci_csrf_token']);
             $data=$_POST;
            if($data['parent_institute']=='') {
                $data['parent_institute'] = NULL; 
             }
             $institute_exist = $this->institute_model->is_institute_exist($data);
            if($institute_exist == 0)
            {
               $res=$this->institute_model->institute_add($data); 
                if($res=1)
                {
                    $what=$this->db->last_query();
                    $table_row_id=$this->db->insert_id();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'Inserted new branch/centre', $who, $what, $table_row_id, 'am_institute_master');
                    $institute_array=$this->institute_model->get_institutedetails_by_id($table_row_id); 
                    $html='<li id="row_'.$table_row_id.'"><div class="col sl_no "> '.$table_row_id.' </div>
                    <div class="col">'.$institute_array['institute_name'] .'</div>
                    <div class="col " >'.$institute_array['institute_type'] .' </div>
                    <div class="col " >'.$institute_array['parent_institute'] .' </div>
                    <div class="col actions ">
                    <button class="btn btn-default option_btn " title="Edit" onclick="get_institutedata('.$table_row_id.')">
                    <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_institute('.$table_row_id.')"><i class="fa fa-trash-o"></i>
                    </a>
                </div><li>'; 
                // {
                //     $what=$this->db->last_query();
                //     $table_row_id=$this->db->insert_id();
                //     $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                //     $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                //     logcreator('insert', 'database', $who, $what, $table_row_id, 'am_institute_master');
                //     $institute_array=$this->institute_model->get_institutedetails_by_id($table_row_id); 
                //     $html='<li id="row_'.$table_row_id.'"><div class="col sl_no "> '.$table_row_id.' </div>
                //     <div class="col">'.$institute_array['institute_name'] .'</div>
                //     <div class="col " >'.$institute_array['institute_type'] .' </div>
                //     <div class="col " >'.$institute_array['parent_institute'] .' </div>
                //     <div class="col actions ">';
                //         if($institute_array["institute_type_id"]==1){
                //             '<a href="backoffice/view-hierarchy/'.$institute_array["institute_master_id"].'" id="#view_hierarchy" >
                //                 <button class="btn btn-default option_btn " onclick="view_hierarchydata('.$table_row_id.')">
                //                     <i class="fa fa-eye "></i>
                //                 </button>
                //             </a>
                //             <button class="btn btn-default option_btn " onclick="get_institutedata('.$table_row_id.')">
                //                 <i class="fa fa-pencil "></i>
                //             </button>
                //             <a class="btn btn-default option_btn" onclick="delete_institute('.$table_row_id.')">
                //                 <i class="fa fa-trash-o"></i>
                //             </a>';
                //         }else{
                //              '<button class="btn btn-default option_btn " onclick="get_institutedata('.$table_row_id.')">
                //                 <i class="fa fa-pencil "></i>
                //             </button>
                //             <a class="btn btn-default option_btn" onclick="delete_institute('.$table_row_id.')">
                //                 <i class="fa fa-trash-o"></i>
                //             </a>';
                //         }
                //     $html = '</div><li>'; 
                // }
                 }
                
            }
            else
            {
             $html=2;//already exist
            }
             
            print_r($html); 
        }
        
    }
    public function get_allparent_institutes()
    {
        if($_POST){
        $institute_type_id=$this->input->post('institute_type_id');
            
            if($institute_type_id == 3)
            {
                $type=2;
            }
            elseif($institute_type_id == 2)
            {
               $type=1; 
            }
        $parentArr=$this->institute_model->get_allparent_institutes($type); 
            //print_r($parentArr);
            echo '<div class="form-group"><label>Parent Institute<span class="req redbold">*</span></label><select class="form-control" name="parent_institute" id="parent_institute"><option value = "">Select</option>';
            foreach ($parentArr as $row) {
            echo '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
            echo '</select><span id="msg"  class="req redbold"></span>';
            echo '</div>';
                       
        }
    }
    //get institute name by id
    public function get_instituteby_id($id)
    {
       $institute_name=$this->institute_model->get_instituteby_id($id);  
        return $institute_name;
    }
    public function get_institutedetails_by_id($id="NULL")
    {
        $institute_array=$this->institute_model->get_institutedetails_by_id($id); 
        $institute_type_id=$institute_array['institute_type_id'];
        $parent_institute=$institute_array['parent_institute'];
            if($institute_type_id !="" && $institute_type_id!=1)
            {
                        if($institute_type_id == 3)
                            {
                                $type=2;
                            }
                            elseif($institute_type_id == 2)
                            {
                               $type=1; 
                            }
                        $parentArr=$this->institute_model->get_allparent_institutes($type); 
                           // print_r($parentArr);
           
            $html= '<div class="form-group"><label>Parent Institute<span class="req redbold">*</span></label><select class="form-control" name="parent_institute" id="edit_parent_institute"><option value = "">Select</option>';
            foreach ($parentArr as $row) {
            
            $html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
             $html.= '</select>';
             $html.= '</div>';
                $institute_array['parent_institutes']=$html;
    }
        print_r(json_encode($institute_array));
       
    } 
    public function institute_edit()
    {
        if($_POST)
        { //print_r($_POST);
             $data=$_POST;
            
             $institute_exist = $this->institute_model->is_institute_exist_edit($data);
            if($institute_exist == 0)
            {
               $res=$this->institute_model->institute_edit($data); 
                if($res=1)
                {
                    $what=$this->db->last_query();
                    $table_row_id=$this->input->post('institute_master_id');
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Updated branch/centre', $who, $what, $table_row_id, 'am_institute_master');
                }
                
            }
            else
            {
             $res=2;//already exist
            }
             
            print_r($res); 
        }
        
    }
    
    public function delete_institute()
    {
        $id=$_POST['id'];
        $checkhierarchy = $this->institute_model->delete_check_institute_hierarchy($id); 
        // echo $this->db->last_query(); exit;
        if($checkhierarchy == 0) {
        $res= $this->institute_model->delete_institute($id);
        if($res==1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Deleted branch/centre', $who, $what, $id, 'am_institute_master');
        }
            $result['status'] = true;
            $result['message'] = 'Action completed successfully';
            $result['data'] =  '';
        } else {
            $result['status'] = false;
            $result['message'] = "Data can't delete, This data is mapped in institute course mapping screen.";
            $result['data'] = null; 
        }
        print_r(json_encode($result));
    }
    
    public function institute_course_mapping()
    {   
        check_backoffice_permission('manage_course');
        $this->data['page']="admin/institute_course_mapping";
		$this->data['menu']="basic_configuration";
        $this->data['menu_item']="admin-class";
		$this->data['breadcrumb']="Centre Course Mapping";
        $this->data['config']=$this->home_model->get_config();
        $this->data['groupArr']=$this->institute_model->get_allgroups();
        $this->data['classesArr']=$this->Class_model->get_class_list();
        $this->data['mappingArr']=$this->institute_model->getall_institute_course_mapping_list();
        $this->data['fee_def']=$this->Discount_model->get_active_feeDeff();
		$this->load->view('admin/layouts/_master',$this->data); 
    }

    public function get_fee_heads(){
        if($_POST){
            $fee_definition = $this->input->post('fee_definition');
            if(!empty($fee_definition)){
                $heads = $this->Discount_model->get_fee_heads($fee_definition);
                if(!empty($heads)){
                    $data = array();
                    foreach($heads as $row){
                        array_push($data,array('id'=>$row->fee_head_id,'name'=>$row->ph_head_name,'value'=>''));
                    }
                    $result['status'] = true;
                    $result['message'] = "";
                    $result['data'] = $data; 
                }else{
                    $result['status'] = false;
                    $result['message'] = "Fee heads not available please define some fee heads";
                    $result['data'] = null; 
                }
            }else{
                $result['status'] = false;
                $result['message'] = "Invalid data.";
                $result['data'] = null; 
            }
        }else{
            $result['status'] = false;
            $result['message'] = "Invalid data.";
            $result['data'] = null; 
        }
        print_r(json_encode($result));
    }
    
    public function load_institutecoursemap_ajax() {
        $html = '<thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Centre</th>
                            <th>Course</th>
                            <th>Total Fee</th>
                            <th>Action</th>
                        </tr>
                    </thead>';
       $mappingArr  = $this->institute_model->getall_institute_course_mapping_list(); 
        if(!empty($mappingArr)) {
            $i=1; 
            foreach($mappingArr as $map){ 
                        $html .= '<tr id="row_'.$map['institute_course_mapping_id'].'">
                            <td>'.$i.'</td>
                            <td>'.$map['institute_name'].'</td>
                            <td>'.$map['class_name'].'</td>
                            <td>'.$map['course_totalfee'].'</td>
                            <td>';
                            $save = 0;                                 
                                if($map['institute_course_mapping_id']>0) {
                                $save = 0;
                                $started = $this->common->get_from_tableresult('am_student_course_mapping', array('institute_course_mapping_id'=>$map['institute_course_mapping_id']));
                                if(!empty($started)) {
                                 $save = 1;   
                                }
                            }
                                if($save==0) {
                                $html .= '<span class="btn mybutton" onclick="edit_mapping('.$map['institute_course_mapping_id'].')">Edit</span>
                                <span class="btn mybutton" onclick="delete_mapping('.$map['institute_course_mapping_id'].');">Delete</span>';
                                } else {
                                    $html .= '<span class="btn mybutton" onclick="view_mapping('.$map['institute_course_mapping_id'].');" data-toggle="modal" data-target="#show">View</span>';
                                }
                        if($map['status'] != 1) {
                                $html .= '<span class="btn mybutton" onclick="renew_fee('.$map['institute_course_mapping_id'].');">Renew fee</span>';
                        }
                            $html .= '</td>
                        </tr>';
                         $i++;
            }
        }
        echo $html;
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

    public function institute_course_add_mapping(){
        $this->form_validation->set_rules('group_master_id', 'Group', 'trim|required');
        $this->form_validation->set_rules('branch_master_id', 'Branch', 'trim|required');
        $this->form_validation->set_rules('course_master_id', 'Course', 'trim|required');
        $this->form_validation->set_rules('course_paymentmethod', 'Payment method', 'trim|required');
        if($this->form_validation->run()){
            $data['institute_course_mapping_id'] = $this->input->post('institute_course_mapping_id');
            $data['group_master_id'] 	= $this->input->post('group_master_id');
            $data['branch_master_id'] 	= $this->input->post('branch_master_id');
            $data['institute_master_id'] = $this->input->post('institute_master_id');
            $data['course_master_id'] 	= $this->input->post('course_master_id');
            $data['fee_definition_id'] 	= $this->input->post('fee_definition');
            $data['course_tuitionfee'] 	= 0;
			$data['course_totalfee'] 	= 0;
			$data['course_sgst'] 		= 0;
            $data['course_cgst'] 		= 0;
            $data['course_cess'] 		= 0;
			$data['sgst'] 				= 0;
            $data['cgst'] 				= 0;
            $data['cess'] 				= 0;
            $heads = $this->input->post('heads');
			if(!empty($heads)) {
            foreach($heads as $v){
                $data['course_tuitionfee'] += $v;
            }
			}
			$config				=	$this->home_model->get_config(); 
			if(!empty($config)){
				$data['sgst'] 			= $config['SGST'];
                $data['cgst'] 			= $config['CGST'];
                if($config['cess']==1){
                $data['cess'] 			= $config['cess_value'];
                }
				$congigval = taxcalculation($data['course_tuitionfee'], $config, 0); 
				$data['course_totalfee'] 	= $congigval['totalAmt'];
				$data['course_sgst'] 		= $congigval['sgst'];
                $data['course_cgst'] 		= $congigval['cgst'];
                $data['course_cess'] 		= $congigval['cess'];
			}
            $data['course_paymentmethod'] = $this->input->post('course_paymentmethod');
            $renew = $this->input->post('institute_course_fee_renew');
            $course_exist = 0;
            if($data['institute_course_mapping_id']==''){
                $course_exist = $this->institute_model->is_course_exist($data['group_master_id'],$data['branch_master_id'],$data['institute_master_id'],$data['course_master_id']);
            }else{
                $course_exist = $this->institute_model->is_course_exist_edit($data['group_master_id'],$data['branch_master_id'],$data['institute_master_id'],$data['course_master_id'],$data['institute_course_mapping_id']); 
            }
            if($course_exist==0){
                if($renew){
                    $deactivate['institute_course_mapping_id'] = $this->input->post('institute_course_mapping_id');
                    $deactivate['status'] = 0;  
                    $this->institute_model->institute_course_add_mapping($deactivate);
                    $data = array();
                    $data = $this->institute_model->get_institutecourse_mapping_byid($deactivate);
                    if($data['parent_id']==NULL){
                        $data['parent_id'] = $data['institute_course_mapping_id'];
                    }
                    $data['institute_course_mapping_id'] = '';  
                    $data['status'] = 1;  
                }
                //$data['course_tuitionfee'] = $this->input->post('course_tuitionfee');
                //$data['course_cgst'] = $this->input->post('course_cgst');
                //$data['course_sgst'] = $this->input->post('course_sgst');
                // $data['course_totalfee'] = $this->input->post('course_totalfee');
                $data['course_paymentmethod'] = $this->input->post('course_paymentmethod');
                $res = $this->institute_model->institute_course_add_mapping($data);
                $returnData['st'] 		= 1;
                $returnData['message'] 	= 'Course is assigned to the centre';
            }else{
                $returnData['st'] 		= 0;
                $returnData['message'] 	= 'This Course is already available in selected centre';
            }
        }else{
            $returnData['st'] 		  = 0;
            $returnData['message'] 	= validation_errors();
        }
        print_r(json_encode($returnData));
    }

    public function delete_institute_course_mapping(){
        if($_POST){
            $deactivate['institute_course_mapping_id'] = $this->input->post('id');
            $check      = $this->common->check_for_delete('am_batch_center_mapping','institute_course_mapping_id',$deactivate['institute_course_mapping_id'],'batch_status',1);
        if($check==0) {
            $deactivate['status'] = 0;  
            $stat = $this->institute_model->institute_course_add_mapping($deactivate);
           $result['status'] = true;
           $result['message'] = 'Action completed successfully';
           $result['data'] =  '';
        } else {
               $result['status'] = false;
               $result['message'] = "Data can't delete, This data is mapped with batch.";
               $result['data'] = null; 
        }
        } else {
                $result['status'] = false;
               $result['message'] = "Invalid data.";
               $result['data'] = null; 
        }
        print_r(json_encode($result)); 
        
           
    }
    
    public function get_institutecourse_mapping_byid()
    {
        $details['installments'] = array();
        $details['installmentnos']=0;
        $details['fee_definitions'] = array();
        $details = $this->institute_model->get_institutecourse_mapping_byid($_POST); 
        $group_master_id=$details['group_master_id'];
        $started = array();
        $details['save']= 0;
        $institute_course_mapping_id = $details['institute_course_mapping_id'];
        if($institute_course_mapping_id>0) {
            $details['save']= 0;
            $started = $this->common->get_from_tableresult('am_student_course_mapping', array('institute_course_mapping_id'=>$institute_course_mapping_id));
            if(!empty($started)) {
             $details['save']= 1;   
            }
        } 
        $data['parent_institute']=$details['group_master_id'];
        $branchArr=$this->institute_model->get_allsub_byparent($data);
        $html= '<option value="">Select</option>';
        if(!empty($branchArr)){
            foreach ($branchArr as $row){
                $html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
        }
        unset($data['parent_institute']);
        $data['parent_institute']=$details['branch_master_id'];
        $centerArr=$this->institute_model->get_allsub_byparent($data);
        $html1= '<option value="">Select</option>';
        if(!empty($centerArr)){
            foreach ($centerArr as $row){
                $html1.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
            }
        }
        $details['fee_definitions'] = $this->institute_model->get_institute_course_fee_definitions($this->input->post('institute_course_mapping_id'));
        
        if($details['course_paymentmethod']=='installment'){
            $installments = $this->institute_model->get_course_center_fee_installments($_POST); 
            if(!empty($installments)) {
            foreach($installments as $key=>$val) {
               $installments[$key]['installment_duedate'] = date('d-m-Y', strtotime($val['installment_duedate'])) ;
            }
            $details['installments'] = $installments;
            $details['installmentnos']=count($details['installments']);   
            }
        }
        $details['branch']=$html;
        $details['center']=$html1;

        print_r(json_encode($details));
    }
    
    
/*
*   function'll show center course mapping details view
*   @params insti_course_mapp_id
*   @author GBS-R
*/
    
    public function get_institutecourse_mapping_view()
    {
        $details['installments'] = array();
        $details['installmentnos']=0;
        $details['branch'] = '';
        $details['center'] = '';
        $details['course'] = '';
        $details = $this->institute_model->get_institutecourse_mapping_byid($_POST); 
        //$group_master_id=$details['group_master_id'];
        
        if($details['branch_master_id']!='') {
            $branch = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$details['branch_master_id']));
            $details['branch'] = $branch['institute_name'];
        }
        if($details['institute_master_id']!='') {
            $center = $this->common->get_from_tablerow('am_institute_master', array('institute_master_id'=>$details['institute_master_id']));
            $details['center'] = $center['institute_name'];
        }
        if($details['course_master_id']!='') {
            $course = $this->common->get_from_tablerow('am_classes', array('class_id'=>$details['course_master_id']));
            $details['course'] = $course['class_name'];
        }
        if($details['course_paymentmethod']=='installment'){
            $installments = $this->institute_model->get_course_center_fee_installments($_POST); 
            if(!empty($installments)) {
//            foreach($installments as $key=>$val) {
//               $installments[$key]['installment_duedate'] = date('d-m-Y', strtotime($val['installment_duedate'])) ;
//            }
                
            $install = '<table class="table table_register table-bordered table-striped text-center">
                                    <tbody><tr>
                                        <th class="text-center">Installment</th>
                                        <th class="text-center">Amount</th>
                                    </tr>
                    </tbody>';
                $sl = 1;
                foreach($installments as $key=>$val) {
                 $install .= '<tr>
                                        <td class="text-center">'.$sl.'</td>
                                        <td class="text-center">'.$val['installment_amount'].'</td>
                                    </tr>';
            //$details['installments'] = $installments;
            //$details['installmentnos']=count($details['installments']);  
                    $sl++;
            }
          $install .= '</table>';  
          $details['installments'] = $install; 
        }   
    }        
        print_r(json_encode($details));
   
}
    
//--------------------------------------------- Manage Subject ---------------------------------------//
    
    public function manage_subject(){
        check_backoffice_permission('manage_subject');
        $this->data['page'] = "admin/subject";
        $this->data['menu'] = "basic_configuration";
        $this->data['breadcrumb'] = "Manage Subject";
        $this->data['menu_item']="admin-subject";
        // $this->data['typeArr'] = $this->subject_model->get_subject_type();
        $this->data['subjectArr'] = $this->subject_model->get_all_subjects();
        $this->data['classesArr']=$this->Class_model->get_class_list();
        $this->load->view('admin/layouts/_master',$this->data); 
    }
    
    
    public function load_subject_ajax(){
        $html = '<thead>
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>Subject Name</th>
                        <th>Subject Type</th>
                        <th>Parent Subject</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>';
        $subjectArr = $this->subject_model->get_all_subjects();
        if(!empty($subjectArr)) {
        $i=1; 
        foreach($subjectArr as $subject){
            $type="'".$subject["subject_type_id"]."'";
            
        $html .= '<tr id="row_'.$subject['subject_id'].'">
                    <td>
                       '.$i.'
                    </td>
                    <td>
                        '.$subject['subject_name'].'
                    </td>
                    <td>
                        '.$subject['subject_type_id'].'
                    </td>
                    <td>';
            
                    $CI =& get_instance();
                    $parent_subject=$CI->get_subjectby_id($subject['parent_subject']);
                   $html .= $parent_subject;
                    $html .='</td>
                    <td>
                        '.$subject['class_name'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn" title="Edit" data-toggle="modal" data-target="#edit_subject" onclick="get_subjectdata('.$subject['subject_id'].')">
                        <i class="fa fa-pencil "></i>
                    </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_subject('.$subject['subject_id'].','.$type.')">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    </td>

                </tr>';
                $i++; 
            }
        }
        echo $html;
    }
    
    
    //add Subject
    public function subject_add(){
        //print_r($_POST);
        if($_POST){
            $data = $_POST;
            // $data['subject_id']='';
            if(isset($data['parent_subject'])){
                if($data['parent_subject'] != "" && $data['subject_type_id']=='Module'){
                    $data['parent_subject'] = $data['parent_subject'];
                }else{
                    $data['parent_subject'] = NULL;
                }
            }
            $data['subject_status'] = 1;
            $subject_exist = $this->subject_model->is_subject_exist($data);
            if($subject_exist == 0){
                $res = $this->subject_model->subject_add($data); 
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New subject added', $who, $what, $table_row_id, 'mm_subjects');
                    $subject_array=$this->subject_model->get_subjectdetails_by_id($table_row_id); 
                    $html='<li id="row_'.$table_row_id.'"><div class="col sl_no "> '.$table_row_id.' </div>
                    <div class="col">'.$subject_array['subject_name'] .'</div>
                    <div class="col " >'.$subject_array['subject_type_id'] .' </div>
                    <div class="col " >'.$subject_array['parent_subject'] .' </div>
                    <div class="col actions ">
                    <button class="btn btn-default add_row " title="Edit" onclick="get_subjectdata('.$table_row_id.')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_subject('.$table_row_id.')"><i class="fa fa-trash-o"></i>
                    </a>
                    </div><li>'; 
                }
                
            }
            else
            {
             $html=2;//already exist
            }
             
            print_r($html); 
        }
    }
    
    public function get_allparent_subjects(){
        if($_POST){
            $subject_type_id = $this->input->post('subject_type_id');
            if($subject_type_id == "Module"){
                $type = "Subject"; 
            }
            $parentArr = $this->subject_model->get_allparent_subjects($type); 
            //print_r($parentArr);
            echo '<div class ="form-group"><label>Parent Subject</label><select class ="form-control" name ="parent_subject"><option value = "">Select</option>';
            if(!empty($parentArr)){
                foreach ($parentArr as $row) {
                    $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$row['course_id']));
                    echo '<option value = "' . $row['subject_id'] . '" >' . $row['subject_name'] .'   ('.$course_name.')</option>';
                }
            }
            echo '</select>';
            echo '</div>';
        }
    }
    //get Subject name by id
    public function get_subjectby_id($id){
        $institute_name = $this->subject_model->get_subjectby_id($id);  
        return $institute_name;
    }
    public function get_subjectdetails_by_id($id = "NULL"){
        $subject_array = $this->subject_model->get_subjectdetails_by_id($id); 
        
        $subject_type_id = $subject_array['subject_type_id'];
        $parent_subject = $subject_array['parent_subject'];
        if($subject_type_id != "" && $subject_type_id!= "Subject"){
            if($subject_type_id == "Module"){
                $type = "Subject"; 
            }
            $parentArr = $this->subject_model->get_allparent_subjects($type); 
           
            $html = '<div class = "form-group"><label>Parent Subject</label><select class="form-control" name = "parent_subject" id = "edit_parent_subject"><option value = "">Select</option>';
            foreach ($parentArr as $row) {
                 $course_name=$this->common->get_name_by_id('am_classes','class_name',array("class_id"=>$row['course_id']));
                $html.= '<option value = "' . $row['subject_id'] . '" >' . $row['subject_name'] .'   ('.$course_name.')</option>';
            }
            $html.= '</select>';
            $html.= '</div>';
            $subject_array['parent_subjects'] = $html;
        }
        print_r(json_encode($subject_array));
    } 
    public function subject_edit(){
        if($_POST){
            $data=$_POST;
            if(isset($data['parent_subject'])){
                if($data['parent_subject'] != "" && $data['subject_type_id']=='Module'){
                    $data['parent_subject'] = $data['parent_subject'];
                }else{
                    $data['parent_subject'] = NULL;
                }
            }
            // $subject_exist = $this->subject_model->subject_exist($data);
            // if($subject_exist == 0){
            $res = $this->subject_model->subject_edit($data); 
                if($res = 1){
                    $what=$this->db->last_query();
                    $table_row_id = $this->input->post('subject_master_id');
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Edited subject', $who, $what, $table_row_id, 'mm_subjects');
                }
            // }else{
            //     $res = 2;//already exist
            // }
            print_r($res); 
        }
    }

    public function delete_subject(){
        if($_POST){
        $id = $_POST['id'];
        $type = $_POST['type'];
            if($type == "Module")
            {
                $exist=$this->common->check_if_dataExist('am_syllabus_master_details',array("module_master_id"=>$id));
                if($exist == 0)
                {
                    //delete
                    $ajax_response['st'] = $this->subject_model->delete_subject($id);
                    if( $ajax_response['st']  == 1)
                    {
                        $ajax_response['msg']="Subject Details Deleted Successfully!";
                        $what = $this->db->last_query();
                        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('delete', 'Deleted subject', $who, $what, $id, 'mm_subjects');
                    }  
                    
                }
                else
                {
                     $ajax_response['st']=2;
                     $ajax_response['msg']="This module is already assigned under a scheduled syllabus";
                }
                
            }
            else if($type == "Subject")
            {
                $exist=$this->common->check_if_dataExist('mm_subjects',array("subject_status"=>"1","parent_subject"=>$id));
                $exist_in_syllabus=$this->common->check_if_dataExist('am_syllabus_master_details',array("subject_master_id"=>$id));
                if($exist == 0 && $exist_in_syllabus== 0)
                {
                    //delete
                    $ajax_response['st'] = $this->subject_model->delete_subject($id);
                    if( $ajax_response['st']  == 1)
                    {
                         $ajax_response['msg']="Subject Details Deleted Successfully!";
                         $what = $this->db->last_query();
                         $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                         logcreator('delete', 'Deleted subject', $who, $what, $id, 'mm_subjects');
                    }
                    else
                    {
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Something went wrong ,Please try again later..!";  
                    }
                }
                else
                {
                    //can't delete
                    $ajax_response['st']=2;
                    $ajax_response['msg']="This subject have modules/assigned under a scheduled syllabus..!";
                }
               
            }
            else
            {
                  $ajax_response['st']=0;
                  $ajax_response['msg']="Something went wrong ,Please try again later..!";
            }
            
            print_r(json_encode($ajax_response)); 
        }
    }
    
    public function subject_syllabus_mapping()
    {
        check_backoffice_permission('subject_syllabus_mapping');
        $this->data['page']="admin/subject_syllabus_mapping";
		$this->data['menu']="basic_configuration";
		$this->data['syllabusArr']=$this->syllabus_model->get_allsyllabus_list();
        $this->data['subjectArr'] = $this->subject_model->get_all_subjects_subjectype();
        $this->data['coursesArr']=$this->Class_model->get_allclass_list();
        $this->data['mappingArr']=$this->syllabus_model->get_syllabus_module_mapping();
        $this->data['breadcrumb']="Subject Syllabus Mappping";
        $this->data['menu_item']="admin-subject-syllabus";
		$this->load->view('admin/layouts/_master',$this->data);  
    }
    

    // GET CENTER COURSE MAPPING DETAILS
    
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
    public function subject_syllabus_add_mapping()
    {
        $data=array();
        $subject_modules=array();
        $subject_modules=$this->input->post('subject_modules');
        unset($_POST['subject_modules']);
         $data=$_POST;
        print_r($_POST);
         //uploading file using codeigniter upload library
        if ($_FILES['file_name'] != '') {
            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            $config['upload_path']           = 'uploads/syllabus/';
            $config['allowed_types']         = 'pdf';
            $_FILES['file_name']['name']     = $files['name'];
            $_FILES['file_name']['type']     = $files['type'];
            $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
            $_FILES['file_name']['size']     = $files['size'];
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');
            //echo  $this->upload->display_errors();
            if ($upload) {
                   $data['syllabus_file'] = str_replace(' ', '_', $_FILES['file_name']['name']);
                   $mapping_exist= $this->syllabus_model->isexist_subject_syllabus_mapping($data);
                
                if($mapping_exist == 0)
                {
                    $result['res']=$this->syllabus_model->subject_syllabus_add_mapping($data);
                    $module_datas=array();
                   
                    if(!empty($subject_modules)){
                    foreach($subject_modules as $modules)
                    {  
                       
                        unset($data['subject_master_id']);
                        $module_datas=$data;
                        $module_datas['subject_master_id']=$modules;
                        $module_datas['parent_subject_master_id']=$this->input->post('subject_master_id');
                        
                       
                        
                        $this->syllabus_model->subject_syllabus_add_mapping($module_datas);
                        
                       
                    }
                    }
                        if($result['res']==1)
                        {
                            $what=$this->db->last_query();
                            $table_row_id=$this->db->insert_id();

                         $details = $this->syllabus_model->get_subjectSyllabus_mapping_byid($table_row_id);

                            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                            logcreator('insert', 'Subject syllabus mapping done', $who, $what, $table_row_id, 'mm_subject_course_mapping');
                            
                            $result['html']='<li id="row_'.$table_row_id.'"> <div class="col sl_no" id="slno_'.$table_row_id.'">'.$table_row_id.'</div>
                            <div class="col" id="course_'.$table_row_id.'">'.$details['class_name'] .'</div><div class="col " id="subject_'.$table_row_id.'">'.$details['subname'] .'</div><div class="col " id="subject_'.$table_row_id.'">'.$details['syllabus_name'] .'</div> <div class="col actions "><button class="btn btn-default option_btn"  title="Edit" onclick="get_mappingdata('.$table_row_id.')"><i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_mapping('.$table_row_id.')"><i class="fa fa-trash-o"></i></a></div><li>'; 
                            
                         }
                }else
                {
                    $result['res']=3;//already exist
                }
                   
            } 
            else {
                $result['res']=2;//upload pdf file
            }
            
        }
        
        
        print_r(json_encode($result));
    }
    
    public function delete_subject_syllabus_mapping()
    {
        if($_POST)
        {
           
            $id=$this->input->post('syllabus_master_detail_id');
            $exist=$this->common->check_if_dataExist('am_schedules',array("module_id"=>$id,	"schedule_status"=>1));
            if($exist == 0)
            {
                //delete
                $response=$this->syllabus_model->delete_subject_syllabus_mapping($_POST);
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully deleted Subject Syllabus Mapping Details";
                    $what=$this->db->last_query();
                    $table_row_id=$this->input->post('subject_id'); 
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('delete', 'Deleted subject syllabus mapping', $who, $what, $table_row_id, 'mm_subject_course_mapping');
                }
                else
                {
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";
                }
            }
            else
            {
                //can't delete
                $ajax_response['st']=2;
                $ajax_response['msg']="This syllabus module is already scheduled";  
            }
            
        }
        else
        {
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
            
        }
       print_r(json_encode($ajax_response));
    }
    
    
public function get_subjectSyllabus_mapping_byid($id)
    {
        $ajaxresponse = $this->syllabus_model->get_syllabusmaster_details($id);
        $subject_id=$ajaxresponse['subject_master_id'];
        $modules = $this->common->get_from_tableresult('mm_subjects', array('parent_subject'=>$subject_id,'subject_status'=>"1"));
        $ajaxresponse['module'] = '';
        if(!empty($modules)) {
            $moduleoptions = '';
            foreach($modules as $module){
                if($module->subject_id==$ajaxresponse['module_master_id']) { $selcted = 'selected="selected"';} else { $selcted = '';}
                $moduleoptions .= '<option value="'.$module->subject_id.'" '.$selcted.'>'.$module->subject_name.'</option>';
            }
        }
        $ajaxresponse['module'] = $moduleoptions;
       // $parentmodules = $this->syllabus_model->get_syllabus_module_mapping();
   $parentmodules= $this->syllabus_model->get_parent_modules($ajaxresponse['syllabus_master_id'], $subject_id);
        if(!empty($parentmodules)) {
           $parentoptions = '<option value="0">Select parent module</option>';
            foreach($parentmodules as $parent){
                if($parent->syllabus_master_detail_id==$ajaxresponse['parent_master_id']) 
                { 
                    $seled = 'selected="selected"';
                } 
                else
                { 
                    $seled = '';
                }
                $parentoptions .= '<option value="'.$parent->syllabus_master_detail_id.'" '.$seled.'>'.$parent->subject_name.'</option>';
            } 
        }
        $ajaxresponse['parent'] = $parentoptions;
        $ajaxresponse['exist'] = $this->common->check_if_dataExist('am_schedules',array("module_id"=>$id));
        
         print_r(json_encode($ajaxresponse));
    }
    
    
//    public function get_subjectSyllabus_mapping_byid($id)
//    {
//        $ajaxresponse = $this->syllabus_model->get_subjectSyllabus_mapping_byid($id);
//        $parent_subject_id=$ajaxresponse['subject_master_id'];
//        $course_id=$ajaxresponse['course_master_id'];
//        $moduleArr=$this->syllabus_model->get_modules_byparent_in_mapping($parent_subject_id,$course_id);
//        $ajaxresponse['modules']="";
//        foreach($moduleArr as $module){
//        $ajaxresponse['modules']=$ajaxresponse['modules'].'<li id="'.$module['subject_master_id'].'"><a href="#" class="remove_category"><i class="fa fa-remove "></i></a>'.$module['subname'].'<input type="hidden" name="subject_modules[]"  value="'.$module['subject_master_id'].'" id="module_'.$module['subject_master_id'].'</li>"/>';
//
//        }
//         print_r(json_encode($ajaxresponse));
//    }
    public function edit_subject_syllabus_mapping()
    {

        $data=array();
        $subject_modules=array();
        $subject_modules=$this->input->post('subject_modules');
        unset($_POST['subject_modules']);
        $id=$this->input->post('subject_id');
        unset($_POST['subject_id']);
        $data=$_POST;
          if (!empty($_FILES['file_name']['name'] != '')) 
          {
            
                $files = str_replace(' ', '_', $_FILES['file_name']);
                $this->load->library('upload');
                $config['upload_path']           = 'uploads/syllabus/';
                $config['allowed_types']         = 'pdf';
               // $config['max_size']      = '200*1024';
                // $config['max_size'] = '200*1024';
                $_FILES['file_name']['name']     = $files['name'];
                $_FILES['file_name']['type']     = $files['type'];
                $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
                $_FILES['file_name']['size']     = $files['size'];
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('file_name');
                $error = array('error' => $this->upload->display_errors());
                  //print_r($error);
                if ($upload) 
                {
                    $data['syllabus_file'] = str_replace(' ', '_', $_FILES['file_name']['name']); 
                     }
                else 
                {
                   $result['res']=2;//upload pdf file
                }
              
          }        
          $mapping_exist= $this->syllabus_model->isexist_subject_syllabus_mapping_edit($data,$id);
         /* if($mapping_exist == 0)
          {*/
            $result['res']=$this->syllabus_model->edit_subject_syllabus_mapping($data,$id);
       // print_r($this->db->last_query());
              $module_datas=array();
                   
                    if(!empty($subject_modules)){
                        $parent_subject_id=$this->input->post('subject_master_id');
                        $course_master_id=$this->input->post('course_master_id');
                        $module_details=$this->syllabus_model->get_modules_byparent_in_mapping($parent_subject_id,$course_master_id);
                       // print_r($module_details);//old array
                       // print_r($subject_modules);//new array
                       // die();

                        foreach($module_details as $allmodules)
                        {
                            if(!in_array($allmodules['subject_master_id'], $subject_modules))
                            {
                                $this->db->where(array('subject_master_id'=>$allmodules['subject_master_id'],'parent_subject_master_id'=>$parent_subject_id));
		                        $query	= $this->db->update('mm_subject_course_mapping',array('subject_status'=>'2'));
                            }
                        }
                        $i=0;
                     foreach($subject_modules as $subjects)
                         {
                            unset($data['subject_master_id']);

                            if($subjects !=$module_details[$i]['subject_master_id'] )
                            {
                                $data['subject_master_id']=$subjects;
                                $data['parent_subject_master_id']=$this->input->post('subject_master_id');
                                $query=$this->db->insert('mm_subject_course_mapping',$data);
                            }
                         }
                    }

                   /* foreach($subject_modules as $modules)
                    {  
                       foreach($module_details as $allmodules)
                       {
                          if($module_details['subject_id'] == $modules)
                          {

                          }
                       }
                        unset($data['subject_master_id']);
                        $module_datas=$data;
                        $module_datas['subject_master_id']=$modules;
                        $module_datas['parent_subject_master_id']=$this->input->post('subject_master_id');
                        $this->syllabus_model->edit_subject_syllabus_mapping($module_datas,$id); 
                    }*/
            if($result['res']==1)
                {
                 $result['details'] = $this->syllabus_model->get_subjectSyllabus_mapping_byid($id);
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Edited subject syllabus mapping', $who, $what, $id, 'mm_subject_course_mapping');
                 }
        /*}
        else
        {
            $result['res']=3;//already exist
        }*/
           
        
         print_r(json_encode($result));
       
        
    }

    
   /*show all modules under parent subject in add mapping from subject table*/
    public function get_allmodules_by_subjectid()
    {
       
        $module_details=$this->subject_model->get_allmodules_by_subjectid($_POST);
        if(!empty($module_details)){
            foreach ($module_details as $row)
            {
                            echo ' <tr>
                                <td>
                                    <input type="checkbox" value="' . $row['subject_id'] . '" class="check" name="' . $row['subject_name'] . '">
                                </td>
                                <td>' . $row['subject_name'] . '</td>


                          </tr>';
            }
        }
    }
    
    
    /*
    *   function'll get modules of subjects
    *   @params subject id
    *   @author GBS-R
    */
    
    public function get_modules_by_subject_id()
    {
        
        $module_details=$this->subject_model->get_allmodules_by_subjectid($_POST);
        if(!empty($module_details)){
            echo '<option value="">Select</option>';
            foreach ($module_details as $row)
            {
                echo '<option value="' . $row['subject_id'] . '">' . $row['subject_name'] . '</option>';
            }
        }
    }


    public function get_allmodules_by_subjectid_edit()
    {
      if($_POST){
          $course_id=$this->input->post('course_master_id');
          unset($_POST['course_master_id']);
        $module_Arr=$this->subject_model->get_allmodules_by_subjectid($_POST);
        $parent_subject_id=$this->input->post('parent_subject');
        $selected_moduleArr=$this->syllabus_model->get_modules_byparent_in_mapping($parent_subject_id,$course_id);
            if(!empty($module_Arr)){
                    foreach($module_Arr as $modules)
                    {
                        $html="";
                        $select=0;
                        foreach($selected_moduleArr as $selected)
                        {
                            if($modules['subject_id'] == $selected['subject_master_id'])
                            {
                                $select=1;
                            }
                        }
                                $html.= '<tr><td><input type="checkbox" value="' . $modules['subject_id'] . '"';
                                        if($select == 1){ $html.="checked"; }
                                        $html.=' class="check"
                                        name="' . $modules['subject_name'] . '"></td>
                                    <td>' . $modules['subject_name'] . '</td></tr>';
                                echo $html;

                    }
            }
      }

    }
    
    
    
/*
*   function'll get all batch details by course id
*   @params course id
*   @author GBS-R
*/
    
 public function get_all_batch_details()
    {
        $course_id = $this->input->post('course_id');
        $this->data['batches']=$this->batch_model->get_all_batches($course_id);
		$this->load->view('admin/batch_details_view',$this->data);  
    }
    
/*
*   function'll get all branch details by course id
*   @params course id
*   @author GBS-R
*/
    
 public function get_all_branch_details()
    {
        $course_id  = $this->input->post('course_id');
        $branches   = $this->Batch_model->get_all_branches($course_id);
        if(!empty($branches)) {
            echo '<option value="0">Select Branch</option>';
            foreach($branches as $branch) {
               echo '<option value="'.$branch->branch_master_id.'">'.$branch->institute_name.'</option>'; 
            }
        }
    }

    public function get_all_branch_details_cc()
    {
        $selected = $_POST['selected'];
        $course_id  = $this->input->post('course_id');
        // $course_id  = $this->input->post('course_id');
        $branches   = $this->Batch_model->get_all_branches($course_id);
        // if(!empty($branches)) {
            echo '<option value="">Select Branch</option>';
            // foreach($branches as $branch) {
            //    echo '<option value="'.$branch->branch_master_id.'">'.$branch->institute_name.'</option>'; 
            // }

            foreach($branches as $row){ 
                    echo '<option value="'.$row->branch_master_id.'" >'.$row->institute_name.'</option>';

            }
        // }
    }

  
   
    public function get_all_batches_details()
    {$result['st'] = 1;
        $course_id  = $this->input->post('course_id');
        $branch_id  = $this->input->post('branch_id');
        $center_id  = $this->input->post('center_id');
        $batchdet ='';
        $centermapp  = $this->Batch_model->get_course_centermapp($course_id, $branch_id, $center_id); 
        
        $batchdet .='<option value="">Select Branch</option>';
        if(!empty($centermapp)) {
            foreach($centermapp as $coursemap) { //print_r($coursemap);
                $batches = $this->Batch_model->get_all_batches($coursemap->institute_course_mapping_id);
                foreach($batches as $batch) { 
                    $batchdet .= '<option value="'.$batch->batch_id.'" >'.$batch->batch_name.'</option>';
                }
            }
        }
        // $centerhtml = '';
        // $centers  = $this->Batch_model->get_all_centers($course_id, $branch_id); 
        // if(!empty($centers)) {
        //     $centerhtml .= '<option value="0">Select Centre</option>';
        //     foreach($centers as $center) {
        //        $centerhtml .= '<option value="'.$center->institute_master_id.'">'.$center->institute_name.'</option>'; 
        //     }
        // }
     
    print_r(json_encode(array('batches'=>$batchdet,'data'=> $result)));
    } 

/*
*   function'll get all center details by course id, branch id
*   @params course id, branch id
*   @author GBS-R
*/
    
 public function get_all_center_details()
    {
        // $result['html'] = '';
        $result['st'] = 1;
        $batchdet = '';
        $course_id  = $this->input->post('course_id');
        $branch_id  = $this->input->post('branch_id');
        $center_id  = $this->input->post('center_id');
        $centermapp  = $this->Batch_model->get_course_centermapp($course_id, $branch_id, $center_id); 
        if(!empty($centermapp)) {
            foreach($centermapp as $coursemap) { //print_r($coursemap);
            $batches = $this->Batch_model->get_all_batches($coursemap->institute_course_mapping_id);
            if(!empty($batches)) {
                // $result['st'] = 1;
                $batchdet .= '<h6>'.$coursemap->institute_name.'</h6><hr>';
                foreach($batches as $batch) { 
                    $coursedet = $this->common->get_course_syllabus_details($course_id); 
                    $studentbatch = $this->common->get_total_student($batch->batch_id);
                    $availableseats = $batch->batch_capacity-$studentbatch;
                    $percentage = $studentbatch*100;
                    $percentage = $percentage/$batch->batch_capacity;
                    
                    $days="";
                    if($batch->monday == 1){ $days.= "Monday,"; }
                    if($batch->tuesday == 1){ $days.= "Tuesday,"; }
                    if($batch->wednesday == 1){ $days.= "Wednesday,"; }
                    if($batch->thursday == 1){ $days.= "Thursday,"; }
                    if($batch->friday == 1){ $days.= "Friday,"; }
                    if($batch->saturday == 1){ $days.= "Saturday,"; }
                    if($batch->sunday == 1){ $days.= "Sunday"; }
                    $batchdet .= '<div class="card"> 
                                        <div class="card-header" id="headingOne'.$batch->batch_id.'">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$batch->batch_id.'" aria-expanded="true" aria-controls="collapseOne">
                                                  '.$batch->batch_name.'
                                                </button>
                                            </h5>
                                        </div>
                     

                                        <div id="collapse'.$batch->batch_id.'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                                       <ul class="nav nav-pills nav-pills_admin">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#reg1'.$batch->batch_id.'" id="reg_1'.$batch->batch_id.'">Batch Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#reg2'.$batch->batch_id.'" id="reg_2'.$batch->batch_id.'"> Course Details</a>
            </li>
            </ul>
            <div class="tab-content">
                    <div id="reg1'.$batch->batch_id.'" class="tab-pane active">
                                                <p><b>Start date:</b>&nbsp;'.date('d M Y', strtotime($batch->batch_datefrom)).' <b>End date:</b>  '.date('d M Y', strtotime($batch->batch_dateto)).'</p><p><b>Last date of admission:</b>&nbsp;'.date('d M Y', strtotime($batch->last_date)).'</p>
                                                <div class="table-responsive table_language tablePanel">
                                                <table class="table  table-bordered table-striped text-center table-sm">
                                                    <tr style="background-color: rgb(0, 123, 255); color: #fff;font-family: s-bold;">
                                                        <td class="text-center">Sun</td>
                                                        <td class="text-center">Mon</td>
                                                        <td class="text-center">Tue</td>
                                                        <td class="text-center">Wed</td>
                                                        <td class="text-center">Thu</td>
                                                        <td class="text-center">Fri</td>
                                                        <td class="text-center">Sat</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">';
                                                        if($batch->sunday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td>
                                                        <td class="text-center">';
                                                        if($batch->monday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td>
                                                        <td class="text-center">';
                                                        if($batch->tuesday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td>
                                                        <td class="text-center">';
                                                        if($batch->wednesday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td>
                                                        <td class="text-center">';
                                                        if($batch->thursday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td>
                                                        <td class="text-center">';
                                                        if($batch->friday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td>
                                                        <td class="text-center">';
                                                        if($batch->saturday==1) {
                                                            $batchdet .= '<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>';
                                                        }
                                                        $batchdet .= '</td></tr></table></div>';
                                                        
                    
                                                $batchdet .= '<p><b>Seats:</b>&nbsp;</p>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width:'.$percentage.'%">'.$percentage.'%</div>

                                                    <span>'.$studentbatch.'/'.$batch->batch_capacity.'</span>
                                                </div>
                                                <p><b>Available Seats:</b>&nbsp;'.$availableseats.'</p>
                                                <p><b>Fees:</b></p>
                                                <div class="table-responsive table_language">
                                                <table class="table  table-bordered table-striped text-center table-sm">
                                                    <tr>
                                                        <th>Fees:</th>
                                                        <td>'.numberformat($batch->course_tuitionfee).'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>SGST</th>
                                                        <td>'.numberformat($batch->course_cgst).'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>CGST</th>
                                                        <td>'.numberformat($batch->course_sgst).'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <td>'.numberformat($batch->course_totalfee).'</td>
                                                    </tr>
                                                </table>
                                                </div>
                                            </div>
                                              <div id="reg2'.$batch->batch_id.'" class="tab-pane"><div class="table-responsive table_language"><table class="table  table-bordered table-striped text-center table-sm"><tr><th class="text-left" style="background-color: rgb(0, 123, 255);">Sessions</th></tr>';
                                                if(!empty($coursedet)) {
                                                        foreach($coursedet as $course) {
                                                           $batchdet .= '<tr><td class="text-left">'.$course->subject_name.'['.$course->subjectname.']<br/>'.$course->module_content.'</td>';
                                                            
                                                        }
                                                }
                                               $batchdet .= '</table></div>';
                                              $batchdet .= '</div>
                                        </div>
                                      
                                    </div></div>
                                     
                                    </div>';
                }
            $result['message'] = 'Success.';  
            } else {
                // $batchdet .= 'No batch available for this course.';
                $result['st'] = 0;
                $result['message'] = 'No batch available for this course.';


            }
        }
 }
        $centerhtml = '';
        $centers  = $this->Batch_model->get_all_centers($course_id, $branch_id); 
        if(!empty($centers)) {
            $centerhtml .= '<option value="0">Select Centre</option>';
            foreach($centers as $center) {
               $centerhtml .= '<option value="'.$center->institute_master_id.'">'.$center->institute_name.'</option>'; 
            }
        }
     
    print_r(json_encode(array('batches'=>$batchdet,'centers'=>$centerhtml,'data'=> $result,'message'=> $result['message'])));
    } 
    /*
    *   function'll get the institute data by pagination
    *   @params center course mapp id
    *   @author GBS-L
    */
                          
    
    public function institute_details_ajax() 
    {
        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $order = $this->input->post("order");

        $col = 0;
        $dir = "DESC";
        if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

       /* if($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }*/

         $columns_valid = array(
            "am_institute_master.institute_master_id", 
            "am_institute_master.institute_name", 
            "am_institute_master.institute_type_id", 
            "am_institute_master.parent_institute" 
        );

         if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }

           if(empty($this->input->post('search')['value']))
        {
            $list = $this->institute_model->get_all_institutes_by_ajax($start, $length, $order, $dir);
        }
        else {
            $search = $this->input->post('search')['value'];

            $list = $this->institute_model->get_all_institutes_by_ajax_search($start, $length, $order, $dir,$search);

        }

       // $list = $this->institute_model->get_all_institutes_by_ajax($start, $length, $order, $dir);
       // $books = $this->books_model->get_books($start, $length, $order, $dir);

        $data = array();

        $no = $_POST['start'];
       // echo $this->db->last_query();
        foreach ($list as $rows) {
            if(!empty($rows['parent_institute'])) { 
                $parent_institute=$this->institute_model->get_instituteby_id($rows['parent_institute']); 
            }
            else
            {
                 $parent_institute="";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['institute_name'];
            $row[] = $rows['institute_type'];
            $row[] = $parent_institute;
            $row[] = '<button class="btn btn-default option_btn " title="Edit"  onclick="get_institutedata('.$rows['institute_master_id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_institute('.$rows['institute_master_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
            $data[] = $row;
        }

        $total_rows=$this->institute_model->get_num_institutes_by_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }
    
    
/*
*   function'll insert syllabus subject mapping action
*   @params post array
*   @author GBS-R
*/
    
 public function syllabus_module_mapping()
    {
        $course_id  = $this->input->post('syllabus_master_id');
     if($this->input->post('syllabus_master_id')=='' || $this->input->post('subject_master_id') =='' || $this->input->post('module_master_id')=='' || $this->input->post('modulecontent')=='') {
          $result['status'] = false;
           $result['message'] = 'Please enter all mandatory fields';
           $result['data'] = '';
     } else {
        $data = array('syllabus_master_id'=>$this->input->post('syllabus_master_id'),
                     'subject_master_id'=>$this->input->post('subject_master_id'),
                      'module_master_id'=>$this->input->post('module_master_id'),
                      'parent_master_id'=>$this->input->post('parent_module_master_id'),
                      'module_content'=>$this->input->post('modulecontent')
                     ); 
       $exist = array('syllabus_master_id'=>$this->input->post('syllabus_master_id'),
                      'module_master_id'=>$this->input->post('module_master_id')
                     );
       $chkexist = $this->common->get_from_tablerow('am_syllabus_master_details',$exist); 
       if(empty($chkexist)) {
           $query = $this->syllabus_model->insert('am_syllabus_master_details', $data);
           if($query) {
           $result['status'] = true;
           $result['message'] = 'Modules mapped successfully.';
           $result['data'] =  $data;
           } else {
               $result['status'] = false;
               $result['message'] = 'Error while saving data.';
               $result['data'] = $data; 
           }
       } else {
           $result['status'] = false;
           $result['message'] = 'Module already added';
           $result['data'] = $chkexist;
       } 
     }
     print_r(json_encode($result));
    } 
    
 /*
*   function'll edit syllabus subject mapping action
*   @params post array
*   @author GBS-R
*/
    
 public function syllabus_module_mapping_edit()
    {
        if($this->input->post('syllabus_master_id')=='' || $this->input->post('subject_master_id') =='' || $this->input->post('module_master_id')=='' || $this->input->post('modulecontent')=='') {
          $result['status'] = false;
           $result['message'] = 'Please enter all mandatory fields';
           $result['data'] = '';
     } else {
        $syllabus_master_detail_id  = $this->input->post('syllabus_master_detail_id');
        $data = array('syllabus_master_id'=>$this->input->post('syllabus_master_id'),
                     'subject_master_id'=>$this->input->post('subject_master_id'),
                      'module_master_id'=>$this->input->post('module_master_id'),
                      'parent_master_id'=>$this->input->post('parent_module_master_id'),
                      'module_content'=>$this->input->post('modulecontent')
                     ); 
       $exist = array('syllabus_master_id'=>$this->input->post('syllabus_master_id'),
                      'module_master_id'=>$this->input->post('module_master_id'),
                      'syllabus_master_detail_id!='=>$syllabus_master_detail_id
                     );
       $chkexist = $this->common->get_from_tablerow('am_syllabus_master_details',$exist); 
       if(empty($chkexist)) {
           $this->db->where('syllabus_master_detail_id',$syllabus_master_detail_id);
           $query = $this->db->update('am_syllabus_master_details', $data);
           if($query) {
           $result['status'] = true;
           $result['message'] = 'Modules mapped successfully.';
           $result['data'] =  $data;
           } else {
               $result['status'] = false;
               $result['message'] = 'Error while saving data.';
               $result['data'] = $data; 
           }
       } else {
           $result['status'] = false;
           $result['message'] = 'Module already added';
           $result['data'] = $chkexist;
       } 
        }
     print_r(json_encode($result));
    } 
       
/*
*   function'll load syllabus modules mapp ajax
*   @params 
*   @author GBS-R
*/
    
 public function load_syllabus_subject_map() {
     $mappingArr  =   $this->syllabus_model->get_syllabus_module_mapping();
     $html = '<thead>
            <tr>
                <th>Sl. No.</th>
                <th>Syllabus</th>
                <th>Subject</th>
                <th>Module</th>
                <th>Action</th>
            </tr>
        </thead>';
     if(!empty($mappingArr)) {
            $i=1;
            foreach($mappingArr as $mapping){ 
             $subject = $this->common->get_from_tablerow('mm_subjects', array('subject_id'=>$mapping->subject_master_id)); 
             $html .='<tr id="row_'.$mapping->syllabus_master_detail_id.'">
                <td id="slno_'.$mapping->syllabus_master_detail_id.'">'.$i.'</td>
                <td id="course_'.$mapping->syllabus_master_detail_id.'">'.$mapping->syllabus_name.'</td>
                <td id="subject_'.$mapping->syllabus_master_detail_id.'">'.((!empty($subject))?$subject['subject_name']:'').'</td>
                <td id="module_'.$mapping->syllabus_master_detail_id.'">'.$mapping->subject_name.'</td>
                <td>
                <button  type="button" class="btn btn-default option_btn getcoursedetails" id="'.$mapping->syllabus_master_detail_id.'" title="Click here to view the details" data-toggle="modal" data-target="#show" >
                            <i class="fa fa-eye "></i>
                        </button>
                <button class="btn btn-default option_btn " title="Edit" onclick="get_mappingdata('.$mapping->syllabus_master_detail_id.')">
                                    <i class="fa fa-pencil "></i>
                                    </button>


                    <a class="btn btn-default option_btn" onclick="delete_mapping('.$mapping->syllabus_master_detail_id.')">
                                    <i class="fa fa-trash-o"></i>
                                    </a>
                </td>
            </tr>';
             $i++; }
     }
     
     echo $html;
     
 }
    
/*
*   function'll search syllabus modules mapp ajax
*   @params 
*   @author GBS-R
*/
    
 public function get_mapdata() {
     $mappingArr  =   $this->syllabus_model->get_syllabus_module_mapping_search($_POST['subject'], $_POST['syllabus']);
     $html = '<thead>
            <tr>
                <th>Sl. No.</th>
                <th>Syllabus</th>
                <th>Module</th>
                <th>Action</th>
            </tr>
        </thead>';
     if(!empty($mappingArr)) {
            $i=1;
            foreach($mappingArr as $mapping){ 
             $html .='<tr id="row_'.$mapping->syllabus_master_detail_id.'">
                <td id="slno_'.$mapping->syllabus_master_detail_id.'">'.$i.'</td>
                <td id="course_'.$mapping->syllabus_master_detail_id.'">'.$mapping->syllabus_name.'</td>
                <td id="subject_'.$mapping->syllabus_master_detail_id.'">'.$mapping->subject_name.'</td>
                <td>
                <button class="btn btn-default option_btn " title="Edit" onclick="get_mappingdata('.$mapping->syllabus_master_detail_id.')">
                                    <i class="fa fa-pencil "></i>
                                    </button>


                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_mapping('.$mapping->syllabus_master_detail_id.')">
                                    <i class="fa fa-trash-o"></i>
                                    </a>
                </td>
            </tr>';
             $i++; }
     }
     
     echo $html;
     
 }
    
/*
*   Subject syllabus mapping view details
*   @params mapping table id
*   @author GBS-R
*/
    
public function get_syllabus_subject_details() {
    $mapp_id = $this->input->post('mapp_id');
    if($mapp_id!='') {
        $syllabusdet =  $this->common->get_module_syllabus_details($mapp_id); 
        if(!empty($syllabusdet)) {
            $result['data'] = $syllabusdet;
            $result['status'] = true;
            $result['message'] = 'Success';
        } else {
            $result['data'] = NULL;
            $result['status'] = false;
            $result['message'] = 'Faied';
        }
    } else {
            $result['data'] = NULL;
            $result['status'] = false;
            $result['message'] = 'Faied';
    }
    print_r(json_encode($result));
}     
        
    
    
// GET PARENT MODULE BY SYLLABUS AND SUBJECT

public function get_parent_module_bysyllabus()
{
 
        $syllabus_master_id = $this->input->post('syllabus_master_id');
        $subject            = $this->input->post('subject');
        $subArr             = $this->syllabus_model->get_parent_modules($syllabus_master_id, $subject);
        echo '<option value="0">Select parent module</option>';
        if(!empty($subArr)){
        foreach ($subArr as $row)
        {
            echo '<option value="' . $row->syllabus_master_detail_id . '" >' . $row->subject_name . '</option>';
        }
    }
}

function download_academic_syllabus($syllabus_id)
{
    $file_name = $this->db->get_where('am_syllabus', array( 'syllabus_id' => $syllabus_id))->row()->file_name;
    $this->load->helper('download');
    $string = str_replace(' ', '_', strtolower(file_get_contents("uploads/syllabus/" . $file_name)));
    $data = $string;
    $name = $file_name;
    force_download($name, $data);
}
    
/*This function will return the module description by subject and module id
@auther GBS-L*/
    public function get_moduleContent()
    {
        if($_POST)
        {
            $ajax_response['data']=$this->common->get_name_by_id('am_syllabus_master_details','module_content',$_POST);
            print_r(json_encode($ajax_response));
        }
    }
    
    public function check_syllabus()
    {
        if($_POST)
        {
            $syllabus_name=$this->input->post('syllabus_name');
            $exist=$this->common->check_if_dataExist('am_syllabus',array("syllabus_name"=>$syllabus_name,"syllabus_status!="=>"2"));
                if($exist ==0)
               {
                   echo "true";
               }
                else
                {
                    echo "false";
                }
        }
    }
    public function edit_check_syllabus()
    {
        if($_POST)
        {
            $syllabus_name=$this->input->post('syllabus_name');
			$syllabus_id=$this->input->post('syllabus_id');
            $exist=$this->common->check_if_dataExist('am_syllabus',array("syllabus_name"=>$syllabus_name,"syllabus_id!="=>$syllabus_id,"syllabus_status!="=>"2"));
             if($exist >=1)
               {
                   echo "false";
               }
                else
                {
                    echo "true";
                }
        }
    }
 
public function basic_entity(){
    check_backoffice_permission("basic_entity");
    $this->data['page']         = "admin/basic_entity";
    $this->data['menu']         = "basic_configuration";
    $this->data['entities']     = $this->syllabus_model->get_basic_list();
    // show($this->data['entities']);
    $this->data['breadcrumb']   = "Basic Entities";
    $this->data['menu_item']    = "basic-entity";
    $this->load->view('admin/layouts/_master',$this->data); 
}

public function check_basic_entity(){
    $entity = $this->input->post('entity'); 
    $mode   = $this->input->post('mode'); 
    $check  = $this->syllabus_model->check_basic_entity($entity, $mode);
    if($check>0) {
        echo $check;
    } else {
        echo 0;
    }
}


public function checkedit_basic_entity(){
    $entity = $this->input->post('entity'); 
    $mode   = $this->input->post('mode'); 
    $entity_id   = $this->input->post('entity_id'); 
    $check  = $this->syllabus_model->checkedit_basic_entity($entity, $mode, $entity_id);
    if($check>0) {
        echo $check;
    } else {
        echo 0;
    }
}


public function basic_entity_add(){
    $entity = $this->input->post('entity'); 
    $mode   = $this->input->post('mode');
    $level   = $this->input->post('level');
    $data = array('entity_name'=>$entity,
                    'entity_type'=>$mode,
                    'entity_level'=>$level
                    );
    $query = $this->db->insert('am_basic_entity', $data);
    if($query) {
        $data['st'] = 1;
        $data['msg'] = "Entity added successfully";
        $data['st'] = true;
    } else {
        $data['st'] = 0;
        $data['msg'] = 'Error while inserting entity.';
        $data['success'] = false;
    }
    print_r(json_encode($data));
}

public function basic_entity_edit(){
    $entity = $this->input->post('entity'); 
    $mode   = $this->input->post('mode');
    $entity_id   = $this->input->post('entity_id');
    $data = array('entity_name'=>$entity
                    );
    $this->db->where('entity_id', $entity_id);                
    $query = $this->db->update('am_basic_entity', $data);
    if($query) {
        $data['st']     = 1;
        $data['msg']    = "Entity updated successfully";
        $data['st']     = true;
    } else {
        $data['st']         = 0;
        $data['msg']        = 'Error while updating entity.';
        $data['success']    = false;
    }
    print_r(json_encode($data));
}


public function load_basicentity_ajax() {
    $entities     = $this->syllabus_model->get_basic_list();
    $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('title').'</th>
                        <th >'.$this->lang->line('type').'</th> 
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($entities)){
            $i=1; 
            foreach($entities as $data){
                $html.='<tr id="row_'.$data->entity_id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="category_'.$data->entity_id.'">
                                '.$data->entity_name.'
                            </td>
                            <td id="school_'.$data->entity_id.'">
                                '.$data->entity_type.'
                            </td>
                            <td id="status_'.$data->entity_id.'">';
                            if($data->entity_type=='Qualification') {
                                if($data->entity_status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_entity_status('.$data->entity_id.','.$data->entity_status.');">Inactive</span>';
                                }else if($data->entity_status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_entity_status('.$data->entity_id.','.$data->entity_status.');">Active</span>';
                                }
                            } else if($data->entity_type == 'Department'){
                                if($data->entity_status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_entityStaff_status(\''.$data->entity_name.'\',\''.$data->entity_status.'\',\'department\')">Inactive</span>';
                                }else if($data->entity_status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_entityStaff_status(\''.$data->entity_name.'\',\''.$data->entity_status.'\',\'department\')">Active</span>';
                             }
                            }else if($data->entity_type == 'Designation'){
                                if($data->entity_status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_entityStaff_status(\''.$data->entity_name.'\',\''.$data->entity_status.'\',\'designation\')">Inactive</span>';
                                 }else if($data->entity_status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_entityStaff_status(\''.$data->entity_name.'\',\''.$data->entity_status.'\',\'designation\')">Active</span>';
                                 }
                            }else if($data->entity_type == 'Online Transaction'){ 
                                if($data->entity_status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_entityStaff_status(\''.$data->entity_name.'\',\''.$data->entity_status.'\',\'Online Transaction\')">Inactive</span>';
                                }else if($data->entity_status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_entityStaff_status(\''.$data->entity_name.'\',\''.$data->entity_status.'\',\'Online Transaction\')">Active</span>';
                                }
                            }
                $html.='</td>
                            <td id="action_'.$data->entity_id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_category_Data(\''.$data->entity_id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                $i++;  }
                $html.='</td>
                        </tr>';
                
            }
        echo $html;
}


public function get_basicentity_id($id){
    $category_array= $this->syllabus_model->get_basicentity_id($id);
    print_r(json_encode($category_array));
}


public function edit_entity_status(){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $categoryCheck = $this->syllabus_model->categoryCheckassign($id); 
    if($categoryCheck==1 || $status == 0){
        $res = $this->syllabus_model->change_entity_status($id, $status);
        if($res == 1){
            $ajax_response['st']=1;
            $ajax_response['msg']="Status changed successfully.!";
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $id, 'am_basicentity');
        }
    }else{
        $ajax_response['st']=2;
        $ajax_response['msg']="Basic entity already assigned. Can't inactive.! ";
    }
    print_r(json_encode($ajax_response));
}

public function edit_entityStaff_status(){
    $name = $_POST['name'];
    $status = $_POST['status'];
    $field = $_POST['field'];
    $categoryCheck = $this->syllabus_model->categoryCheckassignStaff($name, $field); 
    if($categoryCheck == 1 || $status == 0 || $field == 'Online Transaction'){
        $res = $this->syllabus_model->change_entity_statusStaff($name, $status);
        if($res == 1){
            $ajax_response['st']=1;
            $ajax_response['msg']="Status changed successfully.!";
            $what=$this->db->last_query();
            $id = '1';
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $id, 'am_basicentity');
        }
    }else{
        $ajax_response['st']=2;
        $ajax_response['msg']="Basic entity already assigned. Can't inactive.! ";
    }
    print_r(json_encode($ajax_response));
}

 
public function course_mode(){
    check_backoffice_permission("course_mode");
    $this->data['page']         = "admin/course_mode";
    $this->data['menu']         = "basic_configuration";
    $this->data['entities']     = $this->syllabus_model->get_course_mode();
    $this->data['breadcrumb']   = "Course Mode";
    $this->data['menu_item']    = "course-mode";
    $this->load->view('admin/layouts/_master',$this->data); 
}


public function get_coursemode_id($id){
    $category_array= $this->syllabus_model->get_coursemode_id($id);
    print_r(json_encode($category_array));
}


public function checkedit_coursemode(){
    $entity = $this->input->post('entity');
    $entity_id   = $this->input->post('mode_id'); 
    $check  = $this->syllabus_model->checkedit_coursemode($entity, $entity_id);
    if($check>0) {
        echo $check;
    } else {
        echo 0;
    }
}


public function coursemode_edit(){
    $entity = $this->input->post('entity');
    $entity_id   = $this->input->post('mode_id');
    $data = array('mode'=>$entity
                    );
    $this->db->where('mode_id', $entity_id);                
    $query = $this->db->update('am_batch_mode', $data);
    if($query) {
        $data['st']     = 1;
        $data['msg']    = "Entity updated successfully";
        $data['st']     = true;
    } else {
        $data['st']         = 0;
        $data['msg']        = 'Error while updating entity.';
        $data['success']    = false;
    }
    print_r(json_encode($data));
}


public function load_coursemode_ajax() {
    $entities     = $this->syllabus_model->get_course_mode();
    $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('title').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($entities)){
            $i=1; 
            foreach($entities as $data){
                $html.='<tr id="row_'.$data->mode_id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="category_'.$data->mode_id.'">
                                '.$data->mode.'
                            </td>
                            <td id="action_'.$data->mode_id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_category_Data(\''.$data->mode_id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                $i++;  }
                $html.='</td>
                        </tr>';
                
            }
        echo $html;
}


public function check_coursemode(){
    $entity = $this->input->post('entity'); 
    $check  = $this->syllabus_model->check_coursemode($entity);
    if($check>0) {
        echo $check;
    } else {
        echo 0;
    }
}


public function check_existing(){
    $state = $this->input->post('state');
    $city = $this->input->post('entity'); 
    $check  = $this->Common_model->check_existing('cities', array('state_id'=>$state,'name'=>$city));
    if($check) {
        echo 1;
    } else {
        echo 0;
    }
}




public function coursemode_add(){
    $entity = $this->input->post('entity');
    $data = array('mode'=>$entity
                    );
    $query = $this->db->insert('am_batch_mode', $data);
    $insert_id = $this->db->insert_id();
    $this->db->where('mode_id', $insert_id);
    $this->db->update('am_batch_mode', array('mode_code'=>$insert_id));
    if($query) {
        $data['st'] = 1;
        $data['msg'] = "Entity added successfully";
        $data['st'] = true;
    } else {
        $data['st'] = 0;
        $data['msg'] = 'Error while inserting entity.';
        $data['success'] = false;
    }
    print_r(json_encode($data));
}


 
public function city_listing(){
    check_backoffice_permission("city_creation");
    $this->data['page']         = "admin/city_list";
    $this->data['menu']         = "basic_configuration";
    $this->data['entities']     = $this->syllabus_model->get_cities();
    $this->data['states']     = $this->syllabus_model->get_states();
    $this->data['breadcrumb']   = $this->lang->line('city');
    $this->data['menu_item']    = "basic-city";
    $this->load->view('admin/layouts/_master',$this->data); 
}



public function city_add(){
    $city = $this->input->post('entity');
    $state = $this->input->post('state');
    $data = array('name'=>$city,
                    'state_id'=>$state
                    );
    $query = $this->db->insert('cities', $data);
    if($query) {
        $data['st'] = 1;
        $data['msg'] = "City added successfully";
        $data['st'] = true;
    } else {
        $data['st'] = 0;
        $data['msg'] = 'Error while inserting city.';
        $data['success'] = false;
    }
    print_r(json_encode($data));
}

public function load_city_ajax() {
    $entities     = $this->syllabus_model->get_cities();
    $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('city').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($entities)){
            $i=1; 
            foreach($entities as $data){
                $html.='<tr id="row_'.$data->id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="category_'.$data->id.'">
                                '.$data->name.'
                            </td>
                            <td id="action_'.$data->id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_city_Data(\''.$data->id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                $i++;  }
                $html.='</td>
                        </tr>';
                
            }
        echo $html;
}

public function checkedit_city(){
    $city           = $this->input->post('entity');
    $state          = $this->input->post('state');
    $id        = $this->input->post('id'); 
    $check          = $this->Common_model->check_existing_edit('cities', array('state_id'=>$state,'name'=>$city,'id!='=>$id));
    if($check>0) {
        echo $check;
    } else {
        echo 0;
    }
}

public function get_city_id($id){
    $category_array= $this->syllabus_model->get_city_id($id);
    print_r(json_encode($category_array));
}




public function city_edit(){
    $city = $this->input->post('entity');
    $state_id   = $this->input->post('state');
    $id   = $this->input->post('id');
    $data = array('name'=>$city,
                    'state_id'=>$state_id, 
                    );
    $this->db->where('id', $id);                
    $query = $this->db->update('cities', $data);
    if($query) {
        $data['st']     = 1;
        $data['msg']    = "Entity updated successfully";
        $data['st']     = true;
    } else {
        $data['st']         = 0;
        $data['msg']        = 'Error while updating entity.';
        $data['success']    = false;
    }
    print_r(json_encode($data));
}

    
}


?>
