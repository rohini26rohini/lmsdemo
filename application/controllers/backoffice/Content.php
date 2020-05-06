<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="content_management";
        check_backoffice_permission($module);
    }

    public function index()
    {

		
    }
    public function success_stories()
    {
        check_backoffice_permission('success_stories');
        $this->data['page']="admin/success_stories";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Success Stories";
        $this->data['menu_item']="backoffice/success-stories";
        $this->data['school'] = $this->Content_model->get_school();
        $this->data['stories'] = $this->Content_model->get_stories();
        $this->load->view('admin/layouts/_master',$this->data);
        
    }
    public function success_storie_add()
    {
        if($_POST){
            $data=array();
            $data['name']= $this->input->post('name');
            $data['location']= $this->input->post('location');
            $data['school_id']= $this->input->post('school');
            $document_type= $this->input->post('document_type');
            $data['document_type']=$document_type;
            if($document_type == 1){
                $data['description']= $this->input->post('description');
                if ($_FILES['file_name']['name'] != '') {
                    $files = str_replace(' ', '_', $_FILES['file_name']);
                    $this->load->library('upload');
                    $ext = pathinfo($_FILES["file_name"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/success_stories/';
                    $config['allowed_types']         = 'jpg|jpeg|png';
                    $_FILES['file_name']['name']     = $files['name'];
                    $_FILES['file_name']['type']     = $files['type'];
                    $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
                    $_FILES['file_name']['size']     = $files['size'];
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file_name'))
                    {
                        $data['document'] = $config['file_name'].".".$ext; 
                    }
                    else{
                        $ajax_response['st']=2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        print_r(json_encode( $ajax_response));
                        exit();
                    }
                }
            }else if($document_type == 2){
                $data['description']= $this->input->post('link');
            }
            $response=$this->Common_model->insert('web_success_stories', $data);
            if($response != 0)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully added data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New success stories added', $who, $what, $response, 'web_success_stories');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..1!";
            }       
        }
        else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..2!";
        }
        print_r(json_encode( $ajax_response));
    }    
    public function get_success_id($success_id){
        $success_array= $this->Content_model->get_success_id($success_id);
        print_r(json_encode($success_array));
    }
    public function success_storie_edit()
    {
        // print_r($_POST);
        // print_r($_FILES);
        if($_POST){
            $data=array();
            $id = $this->input->post('id');
            $data['name']= $this->input->post('name');
            $data['location']= $this->input->post('location');
            $data['school_id']= $this->input->post('school');
            $document_type= $this->input->post('document_type');
            $data['document_type']=$document_type;
            if($document_type == 1){
                $data['description']= $this->input->post('description');
                if ($_FILES['file_name']['name'] != '') {
                    $files = str_replace(' ', '_', $_FILES['file_name']);
                    $this->load->library('upload');
                    $ext = pathinfo($_FILES["file_name"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/success_stories/';
                    $config['allowed_types']         = 'jpg|jpeg|png';
                    $_FILES['file_name']['name']     = $files['name'];
                    $_FILES['file_name']['type']     = $files['type'];
                    $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
                    $_FILES['file_name']['size']     = $files['size'];
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file_name'))
                    {
                        $data['document'] = $config['file_name'].".".$ext; 
                    
                    }
                    else{
                        $ajax_response['st']=2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        print_r(json_encode( $ajax_response));
                        exit();
                    }
                }else{
                    unset($data['document']);
                }
            }else if($document_type == 2){
                $data['description']= $this->input->post('link');
            }
            $response=$this->Common_model->update('web_success_stories', $data ,array('success_id'=>$id));
           // echo $this->db->last_query();
            if($response)
            {
                $ajax_response['st']=1;
                $ajax_response['id']=$id;
                $ajax_response['msg']="Successfully updated data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Success stories updated', $who, $what, $id, 'web_success_stories');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }       
        }
        else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    } 
    
    public function load_success_story_ajax(){
        $data = $this->Content_model->get_stories();
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('name').'</th>
                        <th >'.$this->lang->line('document_type').'</th>
                        <th >'.$this->lang->line('school').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($data)){
            $i=1; 
            foreach($data as $story){
                $html.='<tr id="row_'.$story->success_id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="name_'.$story->success_id.'">
                                '.$story->name.'
                            </td>
                            <td id="document_'.$story->success_id.'">';
                                if($story->document_type == 1)
                                    $html.='Text';
                                if($story->document_type == 2)
                                    $html.='Video';
                                // if($story->document_type == 3)
                                //     $html.='<a href='.base_url().'/uploads/success_stories/'.$story->document.' target="_blank">Document</a>';
                $html.='</td>
                                <td id="school_'.$story->success_id.'">
                                '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$story->school_id)).'
                            </td>
                            <td id="school_'.$story->success_id.'">
                                <button title="Edit" class="btn btn-default option_btn " onclick="get_successdata(\''.$story->success_id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_successdata(\''.$story->success_id.'\')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>';
                $i++;
            }
        }
        echo $html;
    }
    public function load_success_story_ajaxExtra($id){
        $ajax_response['action'] = '';
        $ajax_response['document'] = '';
        $success = $this->Content_model->get_success_id($id);
        // show($success);
        $ajax_response['name'] = $success['name'];
        if($success['document_type'] == 1)
            $ajax_response['document'] =  'Text';
        if($success['document_type'] == 2)
            $ajax_response['document'] =  'Video';
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$success['school_id']));
        $ajax_response['action'] .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_successdata('.$success['success_id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_successdata('.$success['success_id'].')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>';
        print_r(json_encode( $ajax_response));
    }
    public function success_delete()
    {
        if($_POST)
        {
        $id  = $_POST['id'];
        $res = $this->common->delete_fromwhere('web_success_stories', array('success_id'=>$id), array('success_status'=>'2'));
        // $res = $this->common->delete('web_success_stories', array('success_id'=>$id));
        if($res){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Success stories deleted', $who, $what, $id, 'web_success_stories');
            $ajax_response['st']=1;
            $ajax_response['msg']="Successfully deleted data";

        }
        else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
    }
    else{
        $ajax_response['st']=0;
        $ajax_response['msg']="Something went wrong,Please try again later..!";
    }
        print_r(json_encode($ajax_response));
    }
    public function successNamecheck()
    {
        $name=$this->input->post('name');
        $query= $this->db->get_where('web_success_stories',array("name"=>$name,'success_status'=> '1'));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }

    // Gallery.................................................................. 


    public function gallery()
    {
        check_backoffice_permission('gallery');
        $this->data['page']="admin/gallery";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Gallery";
        $this->data['menu_item']="backoffice/gallery";
        $this->data['gallery_data'] = $this->Content_model->get_gallery();
        $this->data['school'] = $this->Content_model->get_school();
        $this->data['imageD'] = $this->Content_model->get_galleryName();
        // show($this->data['imageD']);
        // echo $this->db->last_query(); exit;
        // echo "<pre>"; print_r($this->data['imageD']); exit;
        $this->load->view('admin/layouts/_master',$this->data);
        
    }
    public function gallery_add()
    {
        if($_POST){
            $data=array();
            $data['gallery_name']= $this->input->post('name'); 
            $data['school_id']= $this->input->post('school'); 
            $data['gallery_key'] = $this->convert( $data['gallery_name'] ); 
            $cpt = count($_FILES['image']['name']);
            for($i=0; $i<$cpt; $i++){
                $config = array();
                $files = str_replace(' ', '_', $_FILES['image']['name'][$i]);
                $_FILES['file']['name']       = $_FILES['image']['name'][$i];
                $_FILES['file']['type']       = $_FILES['image']['type'][$i];
                $_FILES['file']['tmp_name']   = $_FILES['image']['tmp_name'][$i];
                $_FILES['file']['error']      = $_FILES['image']['error'][$i];
                $_FILES['file']['size']       = $_FILES['image']['size'][$i];
                $ext = pathinfo($_FILES["image"]["name"][$i])['extension'];
                $banner_newname = 'banner_'.$_FILES['image']['size'][$i].'_'.rand();
                $config['upload_path']           = 'uploads/gallery/';
                $config['allowed_types']         = 'jpg|jpeg|png'; 
                $config['file_name']= $banner_newname;
                $this->load->library('upload');
                $this->upload->initialize($config);   
                $upload = $this->upload->do_upload('file'); 
                if($upload)
                {
                    $data['gallery_image'] = $banner_newname.'.'.$ext; 
                    $response=$this->Common_model->insert('web_gallery', $data);
                    if($response)
                    {
                        $flag = 1;
                        $ajax_response['st']=1;
                        $ajax_response['msg']="Successfully added data";
                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('insert', 'New gallery image added', $who, $what, $response, 'web_gallery');
                    } 
                }else{
                    $flag = 3;
                    $ajax_response['st']= 2; //file type error
                    $ajax_response['msg']= $this->upload->display_errors();
                    
                }
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }   
    public function load_gallery_ajax(){
        $gallery_data = $this->Content_model->get_gallery();
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('gallery_name').'</th>
                        <th >'.$this->lang->line('school').'</th>
                        <th >'.$this->lang->line('gallery_image').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($gallery_data)){
            $i=1; 
            foreach($gallery_data as $data){
                $html.='<tr id="row_'.$data->gallery_id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="name_'.$data->gallery_id.'">
                                '.$data->gallery_name.'
                            </td>
                            <td id="school_'.$data->gallery_id.'">
                                '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)).'
                            </td>
                            <td id="school_'.$data->gallery_id.'">
                                <img src="'.base_url().'/uploads/gallery/'.$data->gallery_image.'" style="height:50px; width:auto;"/>
                            </td>
                            <td id="action_'.$data->gallery_id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_galleryData(\''.$data->gallery_id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>
                                <a class="btn btn-default option_btn" title="Delete" onclick="delete_gallerydata(\''.$data->gallery_id.'\')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>';
                $i++;
            }
        }
        echo $html;
    }
    public function load_gallery_ajaxExtra($id){
        $ajax_response['action'] = '';
        $ajax_response['document'] = '';
        $gallery = $this->Content_model->get_gallery_id($id);
        // show($gallery);
        $ajax_response['name'] = $gallery['gallery_name'];
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$gallery['school_id']));
        $ajax_response['image'] = '<img src="'.base_url().'/uploads/gallery/'.$gallery['gallery_image'].'" style="height:50px; width:auto;"/>';
        $ajax_response['action'] .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_galleryData('.$gallery['gallery_id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_gallerydata('.$gallery['gallery_id'].','.$gallery['gallery_image'].')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>';
        print_r(json_encode( $ajax_response));
    }
    public function get_gallery_id($gallery_id){
        $gallery_array= $this->Content_model->get_gallery_id($gallery_id);
        print_r(json_encode($gallery_array));
    }
    public function gallery_edit()
    {
        if($_POST){
            $data=array();
            $id = $this->input->post('id');
            $data['gallery_name']= $this->input->post('name');
            $data['school_id']= $this->input->post('school'); 
            $data['gallery_key'] = str_replace(' ', '-', $data['gallery_name']); 
            if($_FILES['image']['name'] != ''){
                $files = str_replace(' ', '_', $_FILES['image']);
                $_FILES['image']['name']     = $files['name'];
                $_FILES['image']['type']     = $files['type'];
                $_FILES['image']['tmp_name'] = $files['tmp_name'];
                $_FILES['image']['size']     = $files['size'];
                $ext = pathinfo($_FILES["image"]["name"])['extension'];
                $config['file_name'] = time();
                $config['upload_path']           = 'uploads/gallery/';
                $config['allowed_types']         = 'jpg|jpeg|png';
                $this->load->library('upload',$config);
                $upload = $this->upload->do_upload('image');
                if($upload){
                    $data['gallery_image'] = $config['file_name'].".".$ext; 
                }else{
                    $ajax_response['st']= 2; //file type error
                    $ajax_response['msg']= $this->upload->display_errors();
                    exit();
                }
            }else{
                unset($data['gallery_image']);
            }
            $response=$this->Common_model->update('web_gallery', $data ,array('gallery_id'=>$id));
            // echo $this->db->last_query();
             if($response)
             { 
                $ajax_response['st']=1;
                $ajax_response['id']=$id;
                $ajax_response['msg']="Successfully updated data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Gallery image edited', $who, $what, $id, 'web_gallery');
             }
             else{
                 $ajax_response['st']=0;
                 $ajax_response['msg']="Something went wrong,Please try again later..!";
             }       
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }   
    public function gallery_delete()
    {
        if($_POST){
            $id  = $_POST['id'];
            // $name = $_POST['name'];
            $res = $this->common->delete_fromwhere('web_gallery', array('gallery_id'=>$id), array('gallery_status'=>'2'));
            // $res = $this->common->delete('web_success_stories', array('success_id'=>$id));
            if($res){
                // unlink(base_url().'/uploads/gallery/'.$name);
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'Gallery image deleted', $who, $what, $id, 'web_gallery');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully deleted data";

            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }


    // general studies -------------------------------------------------------------

    public function general_studies()
    { 
        check_backoffice_permission('general_studies');
        $this->data['page']="admin/general_studies.php";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="General Studies";
        $this->data['menu_item']="backoffice/general-studies";
        $this->data['gs_data'] = $this->Content_model->get_gs();
        $this->data['school'] = $this->Content_model->get_school();
        // echo $this->db->last_query(); exit;
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function general_studies_add()
    {
        //  print_r($_POST);
        if($_POST){
            $data=array();
            $data['school_id']= $this->input->post('school'); 
            $data['type']= 'general_studies';
            $data['topic_title']= $this->input->post('topic_title');
            $data['topic_key'] = $this->convert( $data['topic_title'] ); 
            // $checkDuplication = $this->Content_model->checkDuplicationGS($data['school_id'],$data['type']);
            // if($checkDuplication){
                if($_FILES['topic_document']['name'] != ''){
                    $files = str_replace(' ', '_', $_FILES['topic_document']);
                    $_FILES['topic_document']['name']     = $files['name'];
                    $_FILES['topic_document']['type']     = $files['type'];
                    $_FILES['topic_document']['tmp_name'] = $files['tmp_name'];
                    $_FILES['topic_document']['size']     = $files['size'];
                    $ext = pathinfo($_FILES["topic_document"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/webcontent/generalstudies';
                    $config['allowed_types']         = 'xlsx|doc|docx|ppt';
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $upload = $this->upload->do_upload('topic_document');
                    if($upload){
                        $data['topic_attachment'] = $config['file_name'].".".$ext; 
                    }else{
                        $ajax_response['st']= 2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        print_r(json_encode( $ajax_response));
                        exit();
                    }
                    // echo "don";
                }
                // show($data);
                $response=$this->Common_model->insert('web_general_studies', $data); 
                // echo $this->db->last_query(); exit;
                if($response != 0)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully added data";
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New general studies content added.', $who, $what, $response, 'web_general_studies');
                }
                else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";
                } 
            // }else{
            //     $ajax_response['st']=2;
            //     $ajax_response['msg']="Document already exist!";
            // }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function load_general_studies_ajax(){
        $gs_data = $this->Content_model->get_gs();
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('school').'</th>
                        <th >'.$this->lang->line('topic_title').'</th>
                        <th >'.$this->lang->line('document').'</th> 
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($gs_data)){
            $i=1; 
            foreach($gs_data as $data){
                $html.='<tr id="row_'.$data->id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="school_'.$data->id.'">
                                '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)).'
                            </td>
                            <td id="topic_'.$data->id.'">
                                '.$data->topic_title.'
                            </td>
                            <td id="document_'.$data->id.'">
                                <a class="btn mybutton  mybuttoninfo" href="'.base_url().'uploads/webcontent/generalstudies/'.$data->topic_attachment.'" target="_blank">View Document</a>
                            </td>
                            <td id="status_'.$data->id.'">';
                                if($data->status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_gs_status('.$data->id.','.$data->status.');">Inactive</span>';
                                }else if($data->status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_gs_status('.$data->id.','.$data->status.');">Active</span>';
                                }
                $html.='</td>
                            <td id="action_'.$data->id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_general_studies_Data(\''.$data->id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                if($data->status == '0'){
                $html.='<a class="btn btn-default option_btn" title="Delete" onclick="delete_general_studies_Data('.$data->id.')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
                                    }
                $html.='</td>
                        </tr>';
                $i++;
            }
        } 
        echo $html;
    }
    public function load_general_studies_ajaxExtra($id){
        $ajax_response['action'] = '';
        $ajax_response['status'] = '';
        $general = $this->Content_model->get_general_studies_id($id);
        // show($general);
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$general['school_id']));
        $ajax_response['topic'] = $general['topic_title'];
        if($general['status'] == '0'){
            $ajax_response['status'] .= '<span class="btn mybutton mybuttonInactive" onclick="edit_gs_status('.$general['id'].','.$general['status'].')">Inactive</span>';
        }else if($general['status'] == '1'){
            $ajax_response['status'] .= '<span class="btn mybutton  mybuttonActive" onclick="edit_gs_status('.$general['id'].','.$general['status'].')">Active</span>';
        }
        $ajax_response['document'] = '<a class="btn mybutton  mybuttoninfo" href="'.base_url().'uploads/webcontent/generalstudies/'.$general['topic_attachment'].'" target="_blank">View Document</a>';
        $ajax_response['action'] .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_general_studies_Data('.$general['id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>';
                                    if($general['status'] == '0'){
                                        $ajax_response['action'] .= '<a class="btn btn-default option_btn" title="Delete" onclick="delete_general_studies_Data('.$general['id'].')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>';
                                    }
        print_r(json_encode( $ajax_response));
    }
    public function get_general_studies_id($id){
        $general_studies_array= $this->Content_model->get_general_studies_id($id);
        print_r(json_encode($general_studies_array));
    }
    public function general_studies_edit()
    {
        // print_r($_POST);
        // print_r($_FILES);die();
        if($_POST){
            $data=array();
            $id = $this->input->post('id');
            $data['school_id']= $this->input->post('school'); 
            // $data['category_id']= $this->input->post('category');
            $data['type']= 'general_studies';
            $checkDuplication = $this->Content_model->checkDuplicationGSEdit($data['school_id'],$data['type'],$id);
            if($checkDuplication){
                if($this->input->post('topic_title')){
                    $data['topic_title']= $this->input->post('topic_title');
                    $data['topic_key'] = $this->convert( $data['topic_title'] ); 
                }
                if($_FILES['topic_document']['name'] != ''){
                    $files = str_replace(' ', '_', $_FILES['topic_document']);
                    $_FILES['topic_document']['name']     = $files['name'];
                    $_FILES['topic_document']['type']     = $files['type'];
                    $_FILES['topic_document']['tmp_name'] = $files['tmp_name'];
                    $_FILES['topic_document']['size']     = $files['size'];
                    $ext = pathinfo($_FILES["topic_document"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/webcontent/generalstudies';
                    $config['allowed_types']         = 'xlsx|doc|docx|ppt';
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $upload = $this->upload->do_upload('topic_document');
                    if($upload){
                        $data['topic_attachment'] = $config['file_name'].".".$ext; 
                    }else{
                        $ajax_response['st']= 2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        exit();
                    }
                }else{
                    unset($data['topic_attachment']);
                }
                $response=$this->Common_model->update('web_general_studies', $data ,array('id'=>$id));
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['id']=$id;
                    $ajax_response['msg']="Successfully updated data";
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'General studies content updated', $who, $what, $id, 'web_general_studies');
                }
                else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";
                }  
            }else{
                $ajax_response['st']=2;
                $ajax_response['msg']="Document already exist!";
            }     
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }  
    public function edit_Gs_status(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $what = '';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $res = $this->Content_model->change_gs_status($id, $status);
        if($res == 1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'General studies status changed', $who, $what, $id, 'web_general_studies');
        }
        print_r($res);
    }
    public function general_studies_delete()
    {
        if($_POST){
            $id  = $_POST['id'];
            $res = $this->common->delete('web_general_studies', array('id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'General studies content deleted', $who, $what, $id, 'web_general_studies');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully deleted data";
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }

    //...........previous question and syllabus............................................................

    public function previous_question_and_syllabus(){
        check_backoffice_permission('general_studies');
        $this->data['page']="admin/previous_question_and_syllabus.php";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Previews Question Pappers - syllabus";
        $this->data['menu_item']="backoffice/previous-question-and-syllabus";
        $this->data['gs_data'] = $this->Content_model->get_previous_question_and_syllabus();
        $this->data['school'] = $this->Content_model->get_school();
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function topicCheck()
    {
        $topic_title=$this->input->post('topic_title');
        $query= $this->db->get_where('web_general_studies',array("topic_title"=>$topic_title,'status'=> '1'));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function load_previous_question_and_syllabus_ajax(){
        $gs_data = $this->Content_model->get_previous_question_and_syllabus();
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('school').'</th>
                        <th >'.$this->lang->line('category').'</th> 
                        <th >'.$this->lang->line('type').'</th> 
                        <th >'.$this->lang->line('document').'</th> 
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($gs_data)){
            $i=1; 
            foreach($gs_data as $data){
                $html.='<tr id="row_'.$data->id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="school_'.$data->id.'">
                                '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)).'
                            </td>
                            <td id="category_'.$data->id.'">
                                '.$this->common->get_name_by_id('web_category','category',array('id'=>$data->category_id)).'
                            </td>
                            <td id="type_'.$data->id.'">';
                                if($data->type == 'syllabus'){ $html.='Syllabus'; } 
                                if($data->type == 'previous_question'){ $html.='Previous Question'; }
                $html.='</td>
                            <td id="document_'.$data->id.'">
                                <a class="btn mybutton  mybuttoninfo" href="'.base_url().'uploads/webcontent/generalstudies/'.$data->topic_attachment.'" target="_blank">View Document</a>
                            </td>
                            <td id="status_'.$data->id.'">';
                                if($data->status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_gs_status('.$data->id.','.$data->status.','.$data->school_id.','.$data->category_id.',\''.$data->type.'\');">Inactive</span>';
                                }else if($data->status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_gs_status('.$data->id.','.$data->status.');">Active</span>';
                                }
                $html.='</td>
                            <td id="action_'.$data->id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_general_studies_Data(\''.$data->id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                if($data->status == '0'){
                $html.='<a class="btn btn-default option_btn" title="Delete" onclick="delete_general_studies_Data('.$data->id.')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
                                    }
                $html.='</td>
                        </tr>';
                $i++;
            }
        } 
        echo $html;
    }
    public function load_previous_question_and_syllabus_ajaxExtra($id){
        $ajax_response['action'] = '';
        $ajax_response['document'] = '';
        $ajax_response['status'] = '';
        $ajax_response['type'] = '';
        $Ps = $this->Content_model->get_general_studies_id($id);
        // show($Ps);
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$Ps['school_id']));
        $ajax_response['category'] = $this->common->get_name_by_id('web_category','category',array('id'=>$Ps['category_id']));
        if($Ps['type'] == 'syllabus'){ $ajax_response['type'] .= 'Syllabus'; } 
        if($Ps['type'] == 'previous_question'){ $ajax_response['type'] .= 'Previous Question'; }
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$Ps['school_id']));
        $ajax_response['document'] = '<a class="btn mybutton  mybuttoninfo" href="'.base_url().'uploads/webcontent/generalstudies/'.$Ps['topic_attachment'].'" target="_blank">View Document</a>';
        if($Ps['status'] == '0'){
            $ajax_response['status'] .= '<span class="btn mybutton mybuttonInactive" onclick="edit_gs_status('.$Ps['id'].','.$Ps['status'].','.$Ps['school_id'].','.$Ps['category_id'].',\''.$Ps['type'].'\')">Inactive</span>';
        }else if($Ps['status'] == '1'){
            $ajax_response['status'] .= '<span class="btn mybutton  mybuttonActive" onclick="edit_gs_status('.$Ps['id'].','.$Ps['status'].','.$Ps['school_id'].','.$Ps['category_id'].',\''.$Ps['type'].'\')">Active</span>';
        }
        $ajax_response['action'] .= '<button class="btn btn-default option_btn" title="Edit" onclick="get_general_studies_Data('.$Ps['id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>';
        if($Ps['status'] == '0'){
            $ajax_response['action'] .= '<a class="btn btn-default option_btn" title="Delete" onclick="delete_general_studies_Data('.$Ps['id'].')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>';
        }
        print_r(json_encode( $ajax_response));
    }
    public function previous_question_and_syllabus_add()
    {
        //  print_r($_POST);
        if($_POST){
            $data=array();
            $data['school_id']= $this->input->post('school'); 
            $data['category_id']= $this->input->post('category');
            $data['type']= $this->input->post('type');
            $checkDuplication = $this->Content_model->checkDuplicationprevious_question_and_syllabus($data['school_id'],$data['category_id'],$data['type']);
            if($checkDuplication){
                if($_FILES['topic_document']['name'] != ''){
                    $files = str_replace(' ', '_', $_FILES['topic_document']);
                    $_FILES['topic_document']['name']     = $files['name'];
                    $_FILES['topic_document']['type']     = $files['type'];
                    $_FILES['topic_document']['tmp_name'] = $files['tmp_name'];
                    $_FILES['topic_document']['size']     = $files['size'];
                    $ext = pathinfo($_FILES["topic_document"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/webcontent/generalstudies';
                    $config['allowed_types']         = 'xlsx|doc|docx|ppt';
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $upload = $this->upload->do_upload('topic_document');
                    if($upload){
                        $data['topic_attachment'] = $config['file_name'].".".$ext; 
                    }else{
                        $ajax_response['st']= 2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        exit();
                    }
                    // echo "don";
                }
                // show($data);
                $response=$this->Common_model->insert('web_general_studies', $data); 
                // echo $this->db->last_query(); exit;
                if($response != 0)
                {
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully added data";
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'database', $who, $what, $response, 'web_general_studies');
                }
                else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";
                } 
            }else{
                $ajax_response['st']=2;
                $ajax_response['msg']="Document already exist!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function previous_question_and_syllabus_id($id){
        $general_studies_array= $this->Content_model->get_general_studies_id($id);
        print_r(json_encode($general_studies_array));
    }
    public function previous_question_and_syllabus_edit()
    {
        if($_POST){
            $data=array();
            $id = $this->input->post('id');
            $data['school_id']= $this->input->post('school'); 
            $data['category_id']= $this->input->post('category');
            $data['type']= $this->input->post('type');
            $checkDuplication = $this->Content_model->checkDuplicationprevious_question_and_syllabusEdit($data['school_id'],$data['category_id'],$data['type'],$id);
            if($checkDuplication){
                if($_FILES['topic_document']['name'] != ''){
                    $files = str_replace(' ', '_', $_FILES['topic_document']);
                    $_FILES['topic_document']['name']     = $files['name'];
                    $_FILES['topic_document']['type']     = $files['type'];
                    $_FILES['topic_document']['tmp_name'] = $files['tmp_name'];
                    $_FILES['topic_document']['size']     = $files['size'];
                    $ext = pathinfo($_FILES["topic_document"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/webcontent/generalstudies';
                    $config['allowed_types']         = 'xlsx|doc|docx|ppt';
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $upload = $this->upload->do_upload('topic_document');
                    if($upload){
                        $data['topic_attachment'] = $config['file_name'].".".$ext; 
                    }else{
                        $ajax_response['st']= 2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        print_r(json_encode( $ajax_response));
                        exit();
                    }
                }else{
                    unset($data['topic_attachment']);
                }
                $response=$this->Common_model->update('web_general_studies', $data ,array('id'=>$id));
                if($response)
                {
                    $ajax_response['st']=1;
                    $ajax_response['id']=$id;
                    $ajax_response['msg']="Successfully updated data";
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Content management previous question paper/syllabus updated', $who, $what, $id, 'web_general_studies');
                }
                else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!";
                }  
            }else{
                $ajax_response['st']=2;
                $ajax_response['msg']="Document already exist!";
            }     
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }  
    public function edit_previous_question_and_syllabus_status(){
        // show($_POST);
        $id = $_POST['id'];
        $status = $_POST['status'];
        $what = '';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($_POST['status'] != 1){
            $checkDuplication = $this->Content_model->checkDuplicationprevious_question_and_syllabus_status($id,$_POST['school_id'],$_POST['category_id'],$_POST['type']);
            if($checkDuplication){
                $res = 0;
                print_r($res);
                exit; 
            }else{
                $res = $this->Content_model->change_gs_status($id, $status);
                if($res == 1){
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Content management previous question paper/syllabus status changed', $who, $what, $id, 'web_general_studies');
                    print_r($res);
                }
            }
        }else{
            $res = $this->Content_model->change_gs_status($id, $status);
            if($res == 1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Content management previous question paper/syllabus status changed', $who, $what, $id, 'web_general_studies');
                print_r($res);
            }
        }
    }
    public function previous_question_and_syllabus__delete()
    {
        if($_POST){
            $id  = $_POST['id'];
            $res = $this->common->delete('web_general_studies', array('id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'Content management previous question paper/syllabus deleted', $who, $what, $id, 'web_general_studies');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully deleted data";
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }

    //...........careers............................................................
    
    public function careers()
    {
        check_backoffice_permission('careers');
        $this->data['page']="admin/careers.php";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Careers";
        $this->data['menu_item']="backoffice/careers";
        $this->data['designation'] = $this->Content_model->get_designation(); 
        // echo $this->db->last_query(); exit;
        $this->data['career_data'] = $this->Content_model->get_career();
        $this->data['DistrictArr'] = $this->common->get_district_bystate('19'); 
        // echo $this->db->last_query(); exit;
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function careerNamecheck()
    {
        $name=$this->input->post('name');
        $query= $this->db->get_where('web_careers',array("careers_name"=>$name,'careers_status'=> '1'));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function careerNamecheck_edit(){
        $name=$this->input->post('name');
        $exist= $this->common->check_if_dataExist('web_careers',array("careers_name"=>$name,'careers_status'=> '1'));
        if($exist <= 1)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
      }
    public function career_add()
    {
        // print_r($_POST);
        if($_POST){
            $data=array();
            $data['careers_name'] = $this->input->post('name');
            $data['careers_location'] = $this->input->post('location');
            $data['careers_date'] = $this->input->post('career_date');
            $data['careers_eligibility'] = $this->input->post('eligibility');
            $base_salary_from = $this->input->post('base_salary_from');
            $base_salary_to = $this->input->post('base_salary_to');
            $data['careers_base_salary'] = $base_salary_from . "-" . $base_salary_to;
            $experience_from = $this->input->post('experience_from');
            $experience_to = $this->input->post('experience_to');
            $data['careers_experience'] = $experience_from . "-" . $experience_to;
            $data['careers_employment_type'] = $this->input->post('employment_type');
            $data['careers_job_description'] = $this->input->post('job_description');
            $response=$this->Common_model->insert('web_careers', $data);

            // echo $this->db->last_query(); exit;
            if($response != 0)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully added data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New career information addedd', $who, $what, $response, 'web_careers');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }
    public function load_career_ajax(){
        $career_data = $this->Content_model->get_career();
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('job_title').'</th>
                        <th >'.$this->lang->line('location').'</th>
                        <th >'.$this->lang->line('carrer_last_date').'</th>
                        <th >'.$this->lang->line('employment_type').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($career_data)){
            $i=1; 
            foreach($career_data as $data){
                $html.='<tr id="row_'.$data->careers_id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="careers_'.$data->careers_id.'">
                                '.$data->careers_name.'
                            </td>
                            <td id="location_'.$data->careers_id.'">
                                '.$data->careers_location.'
                            </td>
                            <td id="date_'.$data->careers_id.'">
                                '.$data->careers_date.'
                            </td>
                            <td id="employment_type_'.$data->careers_id.'">
                                '.$data->careers_employment_type.'
                            </td>
                            <td>';
                                if($data->careers_status == 0){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_career_status(\''.$data->careers_id.'\',\''.$data->careers_status.'\')">Inactive</span>';
                                }else if($data->careers_status == 1) {
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_career_status(\''.$data->careers_id.'\',\''.$data->careers_status.'\')">Active</span>';
                                }
                $html.='</td>
                            <td id="action_'.$data->careers_id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_career_Data(\''.$data->careers_id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                if($data->careers_status == 0){
                $html.='<a class="btn btn-default option_btn" title="Delete" onclick="delete_career_Data('.$data->careers_id.')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
                                    }
                $html.='</td>
                    </tr>';
                $i++;
            }
        } 
        echo $html;
    }
    public function load_career_ajaxExtra($id){
        $ajax_response['action'] = '';
        $ajax_response['status'] = '';
        $career = $this->Content_model->get_career_data($id);
        // show($career);
        $ajax_response['careers'] = $career['careers_name'];
        $ajax_response['location'] = $career['careers_location'];
        $ajax_response['date'] = $career['careers_date'];
        $ajax_response['employment_type'] = $career['careers_employment_type'];
        if($career['careers_status'] == 0){
            $ajax_response['status'] .= '<span class="btn mybutton mybuttonInactive" onclick="edit_career_status('.$career['careers_id'].','.$career['careers_status'].')">Inactive</span>';
        }else if($career['careers_status'] == 1) {
            $ajax_response['status'] .= '<span class="btn mybutton  mybuttonActive" onclick="edit_career_status('.$career['careers_id'].','.$career['careers_status'].')">Active</span>';
        }
        $ajax_response['action'] .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_career_Data('.$career['careers_id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>';
        if($career['careers_status'] == 0){
            $ajax_response['action'] .= '<a class="btn btn-default option_btn" title="Delete" onclick="delete_career_Data('.$career['careers_id'].')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>';
        }
        print_r(json_encode($ajax_response));
    }
    public function get_career_id($id){
        $career_array= $this->Content_model->get_career_data($id);
        print_r(json_encode($career_array));
    }
    public function career_edit()
    {
        // print_r($_POST);
        if($_POST){
            $data=array();
            $id =  $this->input->post('id');
            $data['careers_name'] = $this->input->post('name');
            $data['careers_location'] = $this->input->post('location');
            $data['careers_date'] = $this->input->post('career_date');
            $data['careers_eligibility'] = $this->input->post('eligibility');
            $base_salary_from = $this->input->post('base_salary_from');
            $base_salary_to = $this->input->post('base_salary_to');
            $data['careers_base_salary'] = $base_salary_from . "-" . $base_salary_to;
            $experience_from = $this->input->post('experience_from');
            $experience_to = $this->input->post('experience_to');
            $data['careers_experience'] = $experience_from . "-" . $experience_to;
            $data['careers_employment_type'] = $this->input->post('employment_type');
            $data['careers_job_description'] = $this->input->post('job_description');
            $response=$this->Common_model->update('web_careers', $data ,array('careers_id'=>$id));
            if($response)
            {
                $ajax_response['st']=1;
                $ajax_response['id']=$id;
                $ajax_response['msg']="Successfully updated data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'database', $who, $what, $id, 'web_success_stories');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }       
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }
    public function career_delete()
    {
        if($_POST){
            $id  = $_POST['id'];
            $res = $this->common->delete_fromwhere('web_careers', array('careers_id'=>$id), array('careers_status'=>'2'));
            // $res = $this->common->delete('web_success_stories', array('success_id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'web_careers');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully deleted data";

            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }
    public function edit_career_status(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $res = $this->Content_model->change_career_status($id, $status);
        if($res == 1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'database', $who, $what, $id, 'web_careers');
        }
        print_r($res);
    }
    // Received application ................................................................ 
    public function receivedApplication()
    {
        check_backoffice_permission('received_applications');
        $this->data['page']="admin/received_applications.php";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Received Application";
        $this->data['menu_item']="backoffice/received-applications";
        $this->data['application'] = $this->Content_model->get_application(); 
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function change_application_status()
    {
        if($_POST){
            $data = array();
            $data1 = array();
            $id =  $this->input->post('id');
            $data['application_id'] =  $this->input->post('id');
            $data['status'] = $this->input->post('status');
            $data['comment'] = $this->input->post('comments');
            $response = $this->Common_model->insert('web_application_status', $data);
            if($response != 0){

                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'database', $who, $what, $id, 'web_application_status');
                $data1['status'] = $this->input->post('status');
                $response=$this->Common_model->update('web_career_apply', $data1 ,array('id'=>$id));
                if($response){
                    $ajax_response['st']=1;
                    $ajax_response['id']=$id;
                    $ajax_response['msg']="Status updated successfully";
                    $what = $this->db->last_query();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'database', $who, $what, $id, 'web_career_apply');
                }else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later0..!";
                }
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later2..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later3..!";
        }
        print_r(json_encode($ajax_response));
    }
    public function load_application_ajax(){
        $application = $this->Content_model->get_application(); 
        $html = '<thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('name').'</th>
                        <th >'.$this->lang->line('career').'</th>
                        <th >'.$this->lang->line('email').'</th>
                        <th >'.$this->lang->line('phone').'</th>
                        <th >'.$this->lang->line('resume').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($application)){
            $i=1; 
            foreach($application as $data){
                $html.='<tr>
                            <td>
                                '.$i.'
                            </td>
                            <td>
                                '.$data->name.'
                            </td>
                            <td>
                                '.$this->common->get_name_by_id('web_careers','careers_name',array('careers_id'=>$data->career_id)).'
                            </td>
                            <td>
                                '.$data->email.'
                            </td>
                            <td>
                                '.$data->phone.'
                            </td>
                            <td>
                                <a class="btn mybutton  mybuttoninfo" href='.base_url().'/uploads/career_application_doc/'.$data->resume.' target="_blank">Resume</a>
                            </td>
                            <td>';
                            if($data->status == '0'){
                                $html .= '<span class="btn   pending" onclick="edit_application_status(\''.$data->id.'\',\''.$data->status.'\')">Pending</span>';
                            }else if($data->status == '1'){
                                $html .= '<span class="btn   shortListed" onclick="edit_application_status(\''.$data->id.'\',\''.$data->status.'\')">Shortlisted</span>';
                            }else if($data->status == '2'){
                                $html .= '<span class="btn   replied" onclick="edit_application_status(\''.$data->id.'\',\''.$data->status.'\')">Replied</span>';
                            }else if($data->status == '3'){
                                $html .= '<span class="btn   interviwed" onclick="edit_application_status(\''.$data->id.'\',\''.$data->status.'\')">Interviewed</span>';
                            }else if($data->status == '4'){
                                $html .= '<span class="btn   approved"> Selected</span>';
                            }else if($data->status == '5'){
                                $html .= '<span class="btn   denied" onclick="edit_application_status(\''.$data->id.'\',\''.$data->status.'\')">Rejected</span>';
                            }
                            $html .= '</td>
                            <td>
                            <button class="btn btn-default option_btn " title="View" onclick="view_application_comments(\''.$data->id.'\')">
                                <i class="fa fa-eye"></i>
                            </button>
                            </a>
                            </td>
                        </tr>';
                $i++;
            }
        } 
        echo $html;
    }
    public function load_application_ajaxExtra($id){
        $ajax_response['status'] = '';
        $application = $this->Content_model->get_application_id($id); 
        // show($application);
        if($application['status'] == '0'){
            $ajax_response['status'] .= '<span class="btn   pending" onclick="edit_application_status('.$application['id'].','.$application['status'].')">Pending</span>';
        }else if($application['status'] == '1'){
            $ajax_response['status'] .= '<span class="btn   shortListed" onclick="edit_application_status('.$application['id'].','.$application['status'].')">Shortlisted</span>';
        }else if($application['status'] == '2'){
            $ajax_response['status'] .= '<span class="btn   replied" onclick="edit_application_status('.$application['id'].','.$application['status'].')">Replied</span>';
        }else if($application['status'] == '3'){
            $ajax_response['status'] .= '<span class="btn   interviwed" onclick="edit_application_status('.$application['id'].','.$application['status'].')">Interviewed</span>';
        }else if($application['status'] == '4'){
            $ajax_response['status'] .= '<span class="btn   approved"> Selected</span>';
        }else if($application['status'] == '5'){
            $ajax_response['status'] .= '<span class="btn   denied" onclick="edit_application_status('.$application['id'].','.$application['status'].')">Rejected</span>';
        }
        print_r(json_encode( $ajax_response));
    }
    public function get_application_status_id($id){
        $application_status = $this->Content_model->get_application_status_id($id); 
        $html = ' <table class="table table-striped table-sm" style="width:100%"><thead> 
                    <tr class="lightBg">
                        <th>'.$this->lang->line('date').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('comments').'</th>
                    </tr>
                </thead>';
        if(!empty($application_status)){
            foreach($application_status as $data){
                $html.='<tr>
                            <td>
                                '.date('d/m/Y',strtotime($data->created_date)).'
                            </td>
                            <td>';
                            if($data->status == '0'){$html.='Pending';}
                            else if($data->status == 1){$html.='Shortlisted';}
                            else if($data->status == 2){$html.='Replied';}
                            else if($data->status == 3){$html.='Interviewed';}
                            else if($data->status == 4){$html.='Selected';}
                            else if($data->status == 5){$html.='Rejected';}
                            $html.='</td>
                            <td>
                                '.$data->comment.'
                            </td>
                        </tr>';
            }
        }else{
            $html.='<tr>
                        <td colspan="3" class="text-center">
                            <span>No Activities</span>
                        </td>
                    </tr>';
        }
        $html.='</table>';
        echo $html;
    }

//Special about school ................................................................. 

    public function special_about_school()
    {
        check_backoffice_permission('special_about_school');
        $this->data['page']="admin/splAbout_school.php";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Special About School";
        $this->data['menu_item']="backoffice/special-about-school";
        $this->data['school'] = $this->Content_model->get_school();
        $this->data['special_school_id'] = 1;
        $this->data['single_school'] = $this->Content_model->get_sas('1');
        // echo $this->db->last_query(); exit;
        // echo $this->db->last_query(); exit;
        // $this->data['application'] = $this->Content_model->get_application(); 
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_spl_id($id){
        $html ='';
        $single_school = $this->Content_model->get_sas($id);
        if(!empty($single_school)){
            $j=0;
            foreach($single_school as $data){
                $j++;
                $html.='<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                            <div class="form-group Commentsboxs"> 
                                <div class="row">
                                    <div class="col-md-1 text-center justify-content-sm-center d-sm-flex">
                                        <span class="Commentno">'.$j.'</span>
                                    </div>
                                    <div class="col-md-11">
                                        <input type="text" name="keyword'.$j.'" id="keyword'.$j.'" class="form-control" value="'.$data->keywords.'"/>
                                        <input type="hidden" name="id'.$j.'" id="id'.$j.'" value="'.$data->about_id.'"/>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }else{
            $html.='<span>No Keys</span>';
        }
        echo $html;
    }

    
    public function update_keywords(){
        $k = 0;
        // print_r($_POST);
        if($_POST){
            for($i=1;$i<=10;$i++){
                $keyword = $this->input->post('keyword'.$i);
                $id = $this->input->post('id'.$i);
                $response = $this->Common_model->update('web_special_about', array('keywords'=>$keyword) ,array('about_id'=>$id));
                // echo $this->db->last_query(); exit;
                if($response){
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Content management special about school updated', $who, $what, $id, 'web_special_about');
                }else{
                    $k = 1;
                }
            }
            if($k == 0)
            { 
               $ajax_response['st']=1;
               $ajax_response['msg']="Successfully updated all keywords.!";
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later1..!";
            }       
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later2..!";
        }
        print_r(json_encode( $ajax_response));
    }


    //--------------------------------------------- SERVICES ------------------------------------------------//
    public function services()
    {
        check_backoffice_permission('services');
        $this->data['page']="admin/services";
        $this->data['menu']="content_management";
        $this->data['breadcrumb']="Services";
        $this->data['menu_item']="backoffice/services";
        $this->data['serviceArr'] = $this->Content_model->get_services();
        $this->load->view('admin/layouts/_master',$this->data);
    } 

    public function services_add()
    {
        if($_POST){
            $data=array();
            $data['service_content']= $this->input->post('service_content'); 
            $data['title']= $this->input->post('title');
            // $title = $data['title'];
            $response=$this->Common_model->insert('web_services', $data); 
            // echo $this->db->last_query(); exit;
            if($response != 0)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully added data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New services added', $who, $what, $response, 'web_services');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            } 
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function services_edit()
    {

        if($_POST){
            
            $data=array();
            $id = $this->input->post('service_id');
            $title = $this->input->post('title');
            $data['service_content']= $this->input->post('service_content'); 
            if($title == 'Honorary-Director'){
                if($_FILES['image']['name'] != ''){
                    $files = str_replace(' ', '_', $_FILES['image']);
                    $_FILES['image']['name']     = $files['name'];
                    $_FILES['image']['type']     = $files['type'];
                    $_FILES['image']['tmp_name'] = $files['tmp_name'];
                    $_FILES['image']['size']     = $files['size'];
                    $ext = pathinfo($_FILES["image"]["name"])['extension'];
                    $config['file_name'] = time();
                    $config['upload_path']           = 'uploads/IAS-director/';
                    $config['allowed_types']         = 'jpg|png|jpeg';
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $upload = $this->upload->do_upload('image');
                    if($upload){
                        $data['mentor_image'] = $config['file_name'].".".$ext; 
                    }else{
                        $ajax_response['st']= 2; //file type error
                        $ajax_response['msg']= $this->upload->display_errors();
                        print_r(json_encode( $ajax_response));
                        exit();
                    }
                }else{
                    unset($data['mentor_image']);
                }
            }
            $response=$this->Common_model->update('web_services', $data ,array('service_id'=>$id));
            if($response)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully updated data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Services edited', $who, $what, $id, 'web_services');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }       
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }

    public function services_delete()
    {
        $id  = $_POST['id'];
        $res = $this->Content_model->services_delete($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Services deleted', $who, $what, $id, 'web_services');
        }
        print_r($res);
    }

    public function get_services_by_id($service_id){
        $services_array= $this->Content_model->get_services_by_id($service_id);
        print_r(json_encode($services_array));
    }

    public function load_services_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('title').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $serviceArr = $this->Content_model->get_services();
        if(!empty($serviceArr)) {
            $i=1; 
            foreach($serviceArr as $service){ 
                $html .= '<tr id="row_'.$service['service_id'].'">
                    <td>
                        '.$i.'
                    </td>
                   
                    <td id="title_'.$service['service_id'].'">
                        '.$service['title'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_servicesdata('.$service['service_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    //--------------------------------------------- RESULTS ------------------------------------------------//
    public function result()
    {
        check_backoffice_permission('result');
        $this->data['page']="admin/result";
        $this->data['menu']="content_management";
        $this->data['breadcrumb']="Results";
        $this->data['menu_item']="backoffice/result";
        $this->data['schoolArr']=$this->common->get_schools();
        $this->data['hallticketArr'] = $this->common->get_halltickets();
        $this->data['cityArr']=$this->common->get_districts();
        $this->data['resultArr'] = $this->Content_model->get_result();
        // echo '<pre>';
        // print_r($this->data['resultArr']);
        // die();
        $this->load->view('admin/layouts/_master',$this->data);
    }

    public function result_add()
    {
        $school_idArr           = $this->input->post('school_id');
        $notification_idArr     = $this->input->post('notification_id');
        $files = $_FILES;
        // print_r("1");
        $err=0;
        for($i=1;$i<=$this->input->post('counter');$i++){
            if($_FILES['file_name']['name'][$i]!=''){
                $typeArr = explode('.', $_FILES['file_name']['name'][$i]);
                if((end($typeArr)== 'jpg') ||(end($typeArr)== 'JPG') ||(end($typeArr)== 'JPEG') ||(end($typeArr)== 'jpeg')||(end($typeArr)== 'PNG') ||(end($typeArr)== 'png')){
                 }else{
                     $err=1;
                 }
            }else{
                $ajax_response['st']=2;
                $ajax_response['msg']="Please select a file to Upload";
                print_r(json_encode($ajax_response));
                exit();  
            }
            if($_FILES['file_name']['name'][$i]!=''){
                $typeArr = explode('.', $_FILES['file_name']['name'][$i]);
                if($files['file_name']['size'][$i]>1000000){
                     //$err=1;
                }
            }
        }
            // print_r("2");
        if($err==0) {
            for($i=1;$i<=$this->input->post('counter');$i++){
                if($this->input->post('name')[$i]!==NULL){
                    // print_r("3");
                    $hall_tktArr            = $this->input->post('hall_tkt')[$i];
                    $nameArr                = $this->input->post('name')[$i];
                    $rankArr                = $this->input->post('rank')[$i];
                    $cityArr                = $this->input->post('city_id')[$i];
                    $fileArr                = $this->input->post('file_name')[$i];
                    $file_name = '';
                    if (isset($_FILES['file_name']['name'][$i])) {
                        // print_r("4");
                        $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/results';
                        $config['file_name'] = $fileName = "student_".$nameArr."_".uniqid();
                        $config['allowed_types'] ='jpg|png|jpeg';
                        $config['max_size'] = '10000000';
                        $this->load->library('upload', $config);
                        $_FILES['userfile']['name']= $files['file_name']['name'][$i];
                        $_FILES['userfile']['type']= $files['file_name']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['file_name']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['file_name']['error'][$i];
                        $_FILES['userfile']['size']= $files['file_name']['size'][$i];  
                        if ($this->upload->do_upload('userfile')) {
                            // print_r("5");
                            $upload_data = $this->upload->data();
                            $file_name = 'uploads/results/'.$upload_data['file_name'];
                        }
                    }
                    $exist=$this->Content_model->is_results_exist($hall_tktArr,$rankArr);
                    if($exist == 0){
                        $data=array(
                            'school_id'             => $school_idArr,
                            'notification_id'       => $notification_idArr,
                            'hall_tkt'              => $hall_tktArr,
                            'name'                  => $nameArr,
                            'rank'                  => $rankArr,
                            'city_id'               => $cityArr,
                            'file_name'             => $file_name
                        );
                        $res = $this->Content_model->result_add($data);
                        if($res = 1){
                            // print_r("6");
                            $what = $this->db->last_query();
                            $table_row_id = $this->db->insert_id();
            
                            // $query = $this->db->select('*');
                            // $query	=	$this->db->get('web_results');
                            // $row_id= $query->num_rows();
            
                            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                            logcreator('insert', 'New exam result added in content management', $who, $what, $table_row_id, 'web_results');
                            $ajax_response['st']=1;
                            $ajax_response['msg']='Result Added Successfully..!';

                            // $result_array=$this->Content_model->get_resultdetails_by_id($table_row_id);
                            // $html=' <li id="row_'.$table_row_id.'">
                            //             <div class="col sl_no "> '.$row_id.' </div>
                            //             <div class="col " >'.$result_array['name'] .' </div>
                            //             <div class="col " >'.$result_array['rank'] .' </div>
                            //             <div class="col actions ">
                            //                 <button class="btn btn-default option_btn "  onclick="get_resultdata('.$table_row_id.')">
                            //                     <i class="fa fa-pencil "></i>
                            //                 </button>
                            //                 <a class="btn btn-default option_btn" onclick="delete_result('.$table_row_id.')">
                            //                     <i class="fa fa-trash-o"></i>
                            //                 </a>
                            //             </div>
                            //         <li>';
                        }else{
                            $ajax_response['st']=0;
                            $ajax_response['msg']='Something went wrong,Please try again later..!';

                        }
                    }else{
                        $ajax_response['st']=2; //already exist
                        $ajax_response['msg']='HallTicket or Rank already exist';

                    }
                }
            }
        }else{
            $ajax_response['st'] = 3;
            $ajax_response['msg'] = "The file you trying to upload is invalid, please upload .jpg,.jpg,.png files only (Max Size:5MB).";
        }
        print_r(json_encode($ajax_response));
  
    }

    public function result_edit()
    {
        $data['hall_tkt']         = $this->input->post('hall_tkt');
        $data['name']             = $this->input->post('name');
        $data['rank']             = $this->input->post('rank');
        $data['city_id']          = $this->input->post('city_id');
        $data['file_name']        = $this->input->post('file_name');
        $id = $this->input->post('edit_result_id');
        if (!empty($_FILES['file_name']['name'] != '')){
            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            // $config['upload_path']           = base_url('uploads/results/'.$data['file_name']);
            $config['upload_path']           = $this->config->item('absolute_path') . 'uploads/results';
            $config['file_name'] = $fileName = "Result_of_".$data['name']."_".uniqid();
            $config['allowed_types']         = 'jpg|png|jpeg';
            $config['max_size']              = '10000000';
            $ext = pathinfo($_FILES["file_name"]["name"])['extension'];
            $config['file_name'] = time();
//             $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/results';
//             $config['allowed_types']         = 'jpg|png|jpeg|bmp';
//             $config['max_size']              = '10000000';
//             $this->load->library('upload');
            $_FILES['file_name']['name']     = $files['name'];
            $_FILES['file_name']['type']     = $files['type'];
            $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
            $_FILES['file_name']['size']     = $files['size'];
            $this->upload->initialize($config);
            if($this->upload->do_upload('file_name')){
                $data['file_name'] = 'uploads/results/'.$config['file_name'].".".$ext; 
                // print_r("one");
                // $data['file_name'] = 'uploads/results/'.str_replace(' ', '_', $_FILES['file_name']['name']); 
                $ajax_response['res']=$this->Content_model->result_edit($data,$id);
                if($ajax_response['res']=1){
                    $ajax_response['res'] = 1; //successfully updated
                    $what=$this->db->last_query();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('update', 'Exam result updated in content management', $who, $what, $id, 'web_results');
                }else{
                    $ajax_response['res'] = 3; //Invalid request
                }
            }else{
                $ajax_response['res'] = 2; //file type error
                $ajax_response['msg']= $this->upload->display_errors();
            }
        }else if($this->input->post('files')!= ''){
            $data['file_name'] =$this->input->post('files');
            $ajax_response['res']=$this->Content_model->result_edit($data,$id);
            if($ajax_response['res'] = 1){
                $ajax_response['res'] = 1; //successfully updated
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Exam result updated in content management', $who, $what, $id, 'web_results');
            }else{
                $ajax_response['res'] = 3; //Invalid request
            }
        }
        else{
            $ajax_response['res'] = 4; //file type error
            // $ajax_response['msg']= "No file Exist";
        }
        print_r(json_encode($ajax_response));
    }

    public function result_delete()
    {
        $id      = $this->input->post('id');
        $what = '';
        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($id!= '') {
            $query = $this->Content_model->result_delete($id);
            $res['status']   = true;
            $res['message']  = 'Result Deleted Successfully';
            $what =$this->db->last_query();
            logcreator('delete', 'Exam result deleted in content management', $who, $what, $id, 'web_results','Result Deleted Successfully');
        }
        else {
            $res['status']   = false;
            $res['message']  = 'Invalid data';
            logcreator('insert', 'Exam result deletion failed in content management', $who, $what, $id, 'web_results','Error while deleting Result');
        }
        print_r(json_encode($res));
    }

    public function view_result_by_id($transport_id){
        $this->data['result_details']= $this->Content_model->view_result_by_id($transport_id);
        $stop_id = $this->input->post('stop_id');
        $this->db->select('*');
        $this->db->where('transport_id',$transport_id);
        $query = $this->db->get('tt_transport_stop')->result_array();
        $this->data['stop_details']=$this->Content_model->get_stop_by_id($transport_id);
        print_r(json_encode($this->data));
    }

    public function get_result_by_id($result_id){
        $data['discount_array']= $this->Content_model->get_result_by_id($result_id);
        // echo $this->db->last_query();
        $data['exams'] = $this->Content_model->get_all_exams($data['discount_array']['result_id']);
        print_r(json_encode($data));
    }
    
    public function fetch($hall_ticket_id){
        $data= $this->Content_model->fetch_data($hall_ticket_id);
        print_r(json_encode($data));
    }
     
    public function load_result_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('exam_name').'</th>
                        <th >'.$this->lang->line('school').'</th>
                        <th >'.$this->lang->line('location').'</th>
                        <th >'.$this->lang->line('name').'</th>
                        <th >'.$this->lang->line('rank').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $resultArr = $this->Content_model->get_result();
        if(!empty($resultArr)) {
            $i=1; 
            foreach($resultArr as $result){ 
                $html .= '<tr id="row_'.$result['result_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="notification_name_'.$result['result_id'].'">
                        '.$result['notification_name'].'
                    </td>
                    <td id="school_name_'.$result['result_id'].'">
                        '.$result['school_name'].'
                    </td>
                    <td id="scity_id_'.$result['result_id'].'">
                        '.$result['city_id'].'
                    </td>
                    <td id="sname_'.$result['result_id'].'">
                        '.$result['name'].'
                    </td>
                    <td id="rank_'.$result['result_id'].'">
                        '.$result['rank'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_resultdata('.$result['result_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_result('.$result['result_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
                $i++; 
            }
        }
        echo $html;
    }
// Banner .................................................................
    public function banner()
    {
        check_backoffice_permission('banner');
        $this->data['page']="admin/banner.php";
		$this->data['menu']="content_management";
        $this->data['breadcrumb']="Banner";
        $this->data['menu_item']="backoffice/banner";
        $this->data['banner'] = $this->Content_model->get_banner();
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function get_school_for_banner(){
        $html ='';
        $school = $this->Content_model->get_school();
        if(!empty($school)) {
                $html .='<div class="form-group">
                                <label>'.$this->lang->line("school").'<span class="req redbold">*</span></label>
                                <select class="form-control" name="school" id="school">';
                                foreach($school as $schools){
                                    $html .='<option value="'.$schools->school_id.'">'.$schools->school_name.'</option>';
                                }
                                $html .='</select>
                            </div>';
        }else{
            $html.='<span>No Schools</span>';
        }
        echo $html;
    }
    public function banner_add()
    {
        // print_r($_POST);
        //  print_r($_FILES);
        if($_POST){
            $data=array();
            $school_id = $this->input->post('school'); 
            $type = $this->input->post('type');
            $data['type']= $this->input->post('type');
            $data['school_id']= $this->input->post('school'); 
            if($type == 'Home_top_banner'){
                $type_count = $this->Content_model->get_home_banner($type);
                if($type_count >0){
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Home top banner already exits.!";
                    print_r(json_encode( $ajax_response));
                    exit();
                }
            }
            if($type == 'School_banner'){
                $type_count = $this->Content_model->get_school_banner($type,$school_id);
                if($type_count >= 5){
                    $ajax_response['st']=0;
                    $ajax_response['msg']="already 5 school banner exits.!";
                    print_r(json_encode( $ajax_response));
                    exit();
                }
            }
            if($_FILES['banner']['name'] != ''){
                $files = str_replace(' ', '_', $_FILES['banner']);
                $_FILES['banner']['name']     = $files['name'];
                $_FILES['banner']['type']     = $files['type'];
                $_FILES['banner']['tmp_name'] = $files['tmp_name'];
                $_FILES['banner']['size']     = $files['size'];
                $config['upload_path']           = 'uploads/banner_images/';
                $config['allowed_types']         = 'jpg|png|jpeg';
                $config['file_name'] = time();
                $ext = pathinfo($_FILES["banner"]["name"])['extension'];
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('banner');
                if($upload){
                    $data['banner_image'] = $config['file_name'].".".$ext; 
                }else{
                    $ajax_response['st']= 2; //file type error
                    $ajax_response['msg']= $this->upload->display_errors();
                    exit();
                }
                // echo "don";
            }
            $response=$this->Common_model->insert('web_banner', $data); 
            // echo $this->db->last_query(); exit;
            if($response != 0)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully added data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New banner addedd', $who, $what, $response, 'web_banner');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            } 
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function load_banner_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('type').'</th>
                        <th >'.$this->lang->line('banner').'</th>
                        <th >'.$this->lang->line('school').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
                $banner = $this->Content_model->get_banner();
        if(!empty($banner)) {
            $i=1; 
            foreach($banner as $data){ 
                $html .= '<tr id="row_'.$data->id.'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="type_'.$data->id.'">
                        '.$data->type.'
                    </td>
                    <td id="image_'.$data->id.'">
                        <img src="'.base_url().'/uploads/banner_images/'.$data->banner_image.'" style="height:50px; width:auto;"/>
                    </td>
                    <td id="school_'.$data->id.'">
                        '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)).'
                    </td>
                    <td id="action_'.$data->id.'">
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_bannerData('.$data->id.')">
                        <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_bannerdata('.$data->id.')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    public function load_banner_ajaxExtra($id) {
        $ajax_response['action'] = '';
        $banner = $this->Content_model->get_banner_id($id);
        // show($banner);
        $ajax_response['type'] = $banner['type'];
        $ajax_response['image'] = '<img src="'.base_url().'/uploads/banner_images/'.$banner['banner_image'].'" style="height:50px; width:auto;"/>';
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$banner['school_id']));
        $ajax_response['action'] .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_bannerData('.$banner['id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_bannerdata('.$banner['id'].')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>';
        print_r(json_encode( $ajax_response));
    }
    public function get_banner_id($id){
        $banner_array= $this->Content_model->get_banner_id($id);
        print_r(json_encode($banner_array));
    }
    public function get_school_for_banner_edit($id){
        $html ='';
        $school = $this->Content_model->get_school();
        if(!empty($school)) {
                $html .='<div class="form-group">
                            <label>'.$this->lang->line("school").'<span class="req redbold">*</span></label>
                            <select class="form-control" name="school" id="school">';
                            foreach($school as $schools){
                                $html .='<option value="'.$schools->school_id.'"';
                                if($schools->school_id == $id){$html .='selected';}
                                $html .='>'.$schools->school_name.'</option>';
                            }
                            $html .='</select>
                        </div>';
        }else{
            $html.='<span>No Schools</span>';
        }
        echo $html;
    }
    public function banner_edit()
    {
        if($_POST){
            $data=array();
            $id = $this->input->post('id');
            // $data['type']= $this->input->post('type');
            $data['school_id']= $this->input->post('school'); 
            if($_FILES['banner']['name'] != ''){
                $files = str_replace(' ', '_', $_FILES['banner']);
                $_FILES['banner']['name']     = $files['name'];
                $_FILES['banner']['type']     = $files['type'];
                $_FILES['banner']['tmp_name'] = $files['tmp_name'];
                $_FILES['banner']['size']     = $files['size'];
                $config['upload_path']           = 'uploads/banner_images/';
                $config['allowed_types']         = 'jpg|png|jpeg';
                $config['file_name'] = time();
                $ext = pathinfo($_FILES["banner"]["name"])['extension'];
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('banner');
                if($upload){
                    $data['banner_image'] = $config['file_name'].".".$ext; 
                }else{
                    $ajax_response['st']= 2; //file type error
                    $ajax_response['msg']= $this->upload->display_errors();
                    exit();
                }
            }else{
                unset($data['banner_image']);
            }
            $response=$this->Common_model->update('web_banner', $data ,array('id'=>$id));
             if($response)
             { 
                $ajax_response['st']=1;
                $ajax_response['id']=$id;
                $ajax_response['msg']="Successfully updated data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Website banner updated', $who, $what, $id, 'web_banner');
             }
             else{
                 $ajax_response['st']=0;
                 $ajax_response['msg']="Something went wrong,Please try again later..!";
             }       
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function banner_delete()
    {
        if($_POST){
            $id  = $_POST['id'];
            $res = $this->common->delete('web_banner', array('id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'Website banner deleted', $who, $what, $id, 'web_banner');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully deleted data";
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode($ajax_response));
    }

//--------------------------------------------- EXAMS & NOTIFICATIONS ------------------------------------------------//
    public function exams_notifications()
    {
        check_backoffice_permission('exams_notifications');
        $this->data['page']="admin/exams_notifications";
        $this->data['menu']="content_management";
        $this->data['breadcrumb']="Upcoming Exams & Notifications";
        $this->data['menu_item']="backoffice/exams-notifications";
        $this->data['schoolArr']=$this->common->get_schools();
        $this->data['examArr'] = $this->Content_model->get_exam();
        $this->load->view('admin/layouts/_master',$this->data);
    }
    public function exam_add()
    {
        if($_POST){
            $data = $_POST;
            if($data['vacancy']=='') {
                $data['vacancy'] = 0;
            }
            $exam_exist = $this->Content_model->is_exam_exist($data);
            if($exam_exist == 0){
                $res = $this->Content_model->exam_add($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New exam details added in content management', $who, $what, $table_row_id, 'web_notifications');
                    $exam_array=$this->Content_model->get_examdetails_by_id($table_row_id);
                    $html='<li id="row_'.$table_row_id.'">
                            <div class="col sl_no "> '.$table_row_id.' </div>
                                <div class="col " >'.$exam_array['school_id'] .' </div>
                                <div class="col " >'.$exam_array['name'] .' </div>
                                <div class="col " >'.$exam_array['post'] .' </div>
                                <div class="col " >'.$exam_array['vacancy'] .' </div>
                                <div class="col " >'.$exam_array['start_date'] .' </div>
                                <div class="col " >'.$exam_array['end_date'] .' </div>
                                <div class="col actions ">
                                    <button class="btn btn-default option_btn "  title="Edit" onclick="get_examdata('.$table_row_id.')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_exam('.$table_row_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            <li>';
                }
                // else{
                //     $res = 2;
                // }
            }else{
                $html=2;//already exist
            }
            print_r($html);
        }
    }

    public function exam_edit()
    {
        if($_POST){
            $notification_id = $this->input->post('notification_id');
            unset($_POST['notification_id']);
            $data = $_POST;
            if(isset($data['vacancy'])){
                if($data['vacancy'] != ""){
                    $data['vacancy'] = $data['vacancy'];
                }else{
                    $data['vacancy'] = 0;
                }
            }
            $res = $this->Content_model->exam_edit($notification_id,$data);
            if($res == 1){
                $ajax_response['st']=1;
                $ajax_response['id']=$notification_id;
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('Edit', 'Exam details edited in content management', $who, $what, $notification_id, 'web_notifications','Upcoming Exams & Notifications Updated');
            }
            print_r(json_encode( $ajax_response));
        }
    }

    public function exam_delete()
    {
        $id=$_POST['id'];
        // $check      = $this->common->check_for_delete('web_results','notification_id',$id);
        $check= $this->common->check_if_dataExist('web_results',array("notification_id"=>$id,"result_status!="=>2));
        if($check==0) {
            $res= $this->Content_model->exam_delete($id);
            if($res==1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'Exam details deleted from content management', $who, $what, $id, 'web_notifications');
            }
            $result['status'] = true;
            $result['message'] = 'Action completed successfully';
            $result['data'] =  '';
        } else {
            $result['status'] = false;
            $result['message'] = "Exam can't delete, This Exam is mapped with result.";
            $result['data'] = null; 
        }
        print_r(json_encode($result)); 
    }

    public function get_exam_by_id($notification_id){
        $exam_array= $this->Content_model->get_exam_by_id($notification_id);
        print_r(json_encode($exam_array));
    }
    
    public function load_exams_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th>'.$this->lang->line('school').'</th>
                        <th>Exam</th>
                        <th>Post</th>
                        <th>Vacancy</th>
                        <th>'.$this->lang->line('start_date').'</th>
                        <th>'.$this->lang->line('end_date').'</th>
                        <th>'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $exams = $this->Content_model->get_exam();
        if(!empty($exams)) {
            $i=1; 
            foreach($exams as $exam){ 
                $html .= '<tr id="row_'.$exam['notification_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="school_'.$exam['notification_id'].'">
                        '.$exam['school_name'].'
                    </td>
                    <td id="name_'.$exam['notification_id'].'">
                        '.$exam['name'].'
                    </td>
                    <td id="post_'.$exam['notification_id'].'">
                        '.$exam['post'].'
                    </td>
                    <td id="vacancy_'.$exam['notification_id'].'">
                        '.$exam['vacancy'].'
                    </td>
                    <td id="start_date_'.$exam['notification_id'].'">
                        '.$exam['start_date'].'
                    </td>
                    <td id="end_date_'.$exam['notification_id'].'">
                        '.$exam['end_date'].'
                    </td>
                    <td id="action_'.$exam['notification_id'].'">
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_examdata('.$exam['notification_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_exam('.$exam['notification_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    public function load_exams_ajaxExtra($id) {
        // $id  = $_POST['id'];
        $ajax_response['status'] = '';
        $ajax_response['action'] = '';
        $exams = $this->Content_model->get_exam_by_id($id);
        // show($exams);
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$exams['school_id']));
        $ajax_response['name'] = $exams['name'];
        $ajax_response['post'] = $exams['post'];
        $ajax_response['vacancy'] = $exams['vacancy'];
        $ajax_response['start_date'] = $exams['start_date'];
        $ajax_response['end_date'] = $exams['end_date'];
        $ajax_response['action'] .= '<td>
                                        <button class="btn btn-default option_btn " title="Edit" onclick="get_examdata('.$exams['notification_id'].')">
                                            <i class="fa fa-pencil "></i>
                                        </button>
                                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_exam('.$exams['notification_id'].')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>';
        print_r(json_encode( $ajax_response));
    }
        //--------------------------------------------- HOW TO PREPARE ------------------------------------------------//
        public function how_to_prepare(){
            check_backoffice_permission('how_to_prepare');
            $this->data['page']="admin/how_to_prepare";
            $this->data['menu']="content_management";
            $this->data['breadcrumb']="How To Prepare";
            $this->data['menu_item']="backoffice/how_to_prepare";
            $this->data['prepareArr'] = $this->Content_model->get_how_to_prepare();
            $this->data['school'] = $this->Content_model->get_school();
            $this->data['special_school_id'] = 1;
            // $this->data['single_school'] = $this->Content_model->get_prepare('1');
            $this->load->view('admin/layouts/_master',$this->data);
        } 
        public function get_categoryby_school(){
            $html ='';
            $school_id=$this->input->post('school_id');
            $category = $this->Content_model->get_categoryby_school($school_id);
            $html .='<option value="">Select</option>';
            // echo $this->db->last_query(); exit;
            if(!empty($category)) {
                foreach($category as $cat){
                    $html .='<option value="'.$cat->id.'">'.$cat->category.'</option>';
                }
            }
            echo $html;
        }
        public function get_categoryby_school_edit(){
            $html ='';
            $school_id=$this->input->post('school_id');
            $category_id=$this->input->post('category_id');
            $category = $this->Content_model->get_categoryby_school($school_id);
            $html .='<option value="">Select</option>';
            // echo $this->db->last_query(); exit;
            if(!empty($category)) {
                foreach($category as $cat){
                    $html .='<option value="'.$cat->id.'"';
                    if($cat->id == $category_id ){$html .='selected';}
                    $html .='>'.$cat->category.'</option>';
                }
            }
            echo $html;
        }
        public function howtoprepare_add(){
            //  show($_POST);
            if($_POST){
                $data=array();
                $data['school_id']= $this->input->post('school'); 
                $data['category_id']= $this->input->post('category');
                $data['content']= $this->input->post('content');
                $checkDuplication = $this->Content_model->checkDuplication($data['school_id'],$data['category_id']);
                if($checkDuplication){
                    $response = $this->Common_model->insert('web_prepare_content', $data); 
                    // echo $this->db->last_query(); exit;
                    if($response != 0)
                    {
                        $ajax_response['st']=1;
                        $ajax_response['msg']="Successfully added data";
                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('insert', 'New how to prepare contnet added', $who, $what, $response, 'web_prepare_content');
                    }
                    else{
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Something went wrong,Please try again later..!";
                    } 
                }else{
                    $ajax_response['st']=2;
                    $ajax_response['msg']="Prepare for this category already exist!";
                }
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!2";
            }
            print_r(json_encode( $ajax_response));
        }
        public function howtoprepare_edit(){
            //  show($_POST);
            if($_POST){
                $data=array();
                $data['school_id']= $this->input->post('school'); 
                $data['category_id']= $this->input->post('category');
                $data['content']= $this->input->post('content');
                $id = $this->input->post('id');
                $checkDuplication = $this->Content_model->checkDuplication_edit($data['school_id'],$data['category_id'],$id);
                if($checkDuplication){
                    $response = $this->Common_model->update('web_prepare_content', $data ,array('prepare_id'=>$id));
                    // echo $this->db->last_query(); exit;
                    if($response){
                        $ajax_response['st']=1;
                        $ajax_response['id'] = $id;
                        $ajax_response['msg']="Successfully updated data";
                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('update', 'How to prepare content edited', $who, $what, $id, 'web_prepare_content');
                    }
                    else{
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Something went wrong,Please try again later..!1";
                    }
                }else{
                    $ajax_response['st']=2;
                    $ajax_response['msg']="Prepare for this category already exist!";
                } 
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
            print_r(json_encode( $ajax_response));
        }
        public function load_howtoprepare_ajax(){
            $howToPrepare = $this->Content_model->get_how_to_prepare();
            $html = ' <thead> 
                        <tr>
                            <th>'.$this->lang->line('sl_no').'</th>
                            <th >'.$this->lang->line('category').'</th>
                            <th >'.$this->lang->line('school').'</th> 
                            <th >'.$this->lang->line('status').'</th>
                            <th >'.$this->lang->line('action').'</th>
                        </tr>
                    </thead>';
            if(!empty($howToPrepare)){
                $i=1; 
                foreach($howToPrepare as $data){
                    $html.='<tr id="prepare'.$data->prepare_id.'">
                                <td>
                                    '.$i.'
                                </td>
                                <td id="category'.$data->prepare_id.'">
                                    '.$this->common->get_name_by_id('web_category','category',array('id'=>$data->category_id)).'
                                </td>
                                <td id="school'.$data->prepare_id.'">
                                    '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)).'
                                </td>
                                <td id="status'.$data->prepare_id.'">';
                                    if($data->prepare_status == '0'){
                                        $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_howtoprepare_status('.$data->prepare_id.','.$data->prepare_status.');">Inactive</span>';
                                    }else if($data->prepare_status == '1'){
                                        $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_howtoprepare_status('.$data->prepare_id.','.$data->prepare_status.');">Active</span>';
                                    }
                    $html.='</td><td id="action'.$data->prepare_id.'">
                                <button type="button" class="btn btn-default option_btn " onclick="get_howtoprepare_Data_view('.$data->prepare_id.')" title="Click here to view the details" data-toggle="modal" data-target="#view_classrooms" style="color:blue;cursor:pointer;">
                                    <i class="fa fa-eye "></i>
                                </button>
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_howtoprepare_Data('.$data->prepare_id.')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
            if($data->prepare_status == '0'){
                    $html.='<a class="btn btn-default option_btn" title="Delete" onclick="delete_howtoprepare_Data('.$data->prepare_id.')">
                                <i class="fa fa-trash-o"></i>
                            </a>';
                }
                    $html.='</td>
                            </tr>';
                    $i++;
                }
            } 
            echo $html;
        }
        public function load_howtopreparestatus_ajax($id){
            $ajax_response['status'] = '';
            $ajax_response['action'] = '';
            $howToPrepare = $this->Content_model->get_howtoprepare_id($id);
            $ajax_response['category'] = $this->common->get_name_by_id('web_category','category',array('id'=>$howToPrepare['category_id']));
            $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$howToPrepare['school_id']));
            if($howToPrepare['prepare_status'] == '0'){
                $ajax_response['status'] .= '<span class="btn mybutton mybuttonInactive" onclick="edit_howtoprepare_status('.$howToPrepare['prepare_id'].','.$howToPrepare['prepare_status'].')">Inactive</span>';
            }else if($howToPrepare['prepare_status'] == '1'){
                $ajax_response['status'] .= '<span class="btn mybutton  mybuttonActive" onclick="edit_howtoprepare_status('.$howToPrepare['prepare_id'].','.$howToPrepare['prepare_status'].')">Active</span>';
            }
            $ajax_response['action'] .= '<button type="button" class="btn btn-default option_btn " onclick="get_howtoprepare_Data_view('.$howToPrepare['prepare_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#view_classrooms" style="color:blue;cursor:pointer;">
                        <i class="fa fa-eye "></i>
                    </button>
                <button class="btn btn-default option_btn " title="Edit" onclick="get_howtoprepare_Data('.$howToPrepare['prepare_id'].')">
                    <i class="fa fa-pencil "></i>
                </button>';
            if($howToPrepare['prepare_status'] == '0'){
                $ajax_response['action'] .= '<a class="btn btn-default option_btn" title="Delete" onclick="delete_howtoprepare_Data('.$howToPrepare['prepare_id'].')">
                    <i class="fa fa-trash-o"></i>
                </a>';
            }
            print_r(json_encode( $ajax_response));
        }
        public function get_howtoprepare_id($id){
            $howtoprepare_array= $this->Content_model->get_howtoprepare_id($id);
            print_r(json_encode($howtoprepare_array));
        }
        public function get_howtoprepare_id_view($id){
            $howtoprepare_array= $this->Content_model->get_howtoprepare_id_view($id);
            print_r(json_encode($howtoprepare_array));
        }    
        public function howtoprepare_delete(){
            if($_POST){
                $id  = $_POST['id'];
                // $res = $this->common->delete_fromwhere('web_category', array('id'=>$id), array('careers_status'=>'2'));
                $res = $this->common->delete('web_prepare_content', array('prepare_id'=>$id));
                // echo $this->db->last_query(); exit;
                if($res){
                    $what = $this->db->last_query();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('delete', 'HOw to prepare content deleted', $who, $what, $id, 'web_prepare_content');
                    $ajax_response['st']=1;
                    $ajax_response['msg']="Successfully deleted data";

                }
                else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..!1";
                }
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!2";
            }
            print_r(json_encode($ajax_response));
        }
     public function sample_questions(){
        check_backoffice_permission('question');
		$this->data['page']="admin/questions";
		$this->data['menu']="content_management";
        $this->data['menu_item']="sample_questions";
        $this->data['breadcrumb']="Sample Questions";
		$this->data['school']=$this->question_model->get_School();
		$this->data['question_details']=$this->question_model->get_questions();
		$this->load->view('admin/layouts/_master.php',$this->data); 
    }  
    public function convert( $title )
    {
        $nameout = strtolower( $title );
        $nameout = str_replace(' ', '-', $nameout );
        $nameout = str_replace('.', '-', $nameout);
        $nameout = str_replace(';', '-', $nameout);
        $nameout = str_replace('/', '-', $nameout);
        $nameout = str_replace('?', '', $nameout);
        $nameout = str_replace('(', '', $nameout);
        $nameout = str_replace(')', '', $nameout);
        $nameout = str_replace('@', '', $nameout);
        $nameout = str_replace('=', '', $nameout);
        $nameout = str_replace('&', '', $nameout);
        $nameout = str_replace('"', '', $nameout);
        $nameout = str_replace('<', '', $nameout);
        $nameout = str_replace('>', '', $nameout);
        $nameout = str_replace('`', '-', $nameout);
        $nameout = str_replace(']', '-', $nameout);
        $nameout = str_replace('[', '', $nameout);
        $nameout = str_replace('~', '', $nameout);
        $nameout = str_replace('^', '', $nameout);
        $nameout = str_replace('\'', '', $nameout);
        $nameout = str_replace('|', '', $nameout);
        $nameout = str_replace('}', '', $nameout);
        $nameout = str_replace('{', '', $nameout);
        $nameout = str_replace('%', '', $nameout);
        $nameout = str_replace('#', '', $nameout);
        $nameout = str_replace('$', '', $nameout);
        $nameout = str_replace("'", '', $nameout);
        return $nameout;
    }
    public function convertimage( $title )
    {
        // $nameout = strtolower( $title );
        $nameout = str_replace(' ', '_', $title );
        return $nameout;
    }

    //---------------------------------Category----------------------------------------------------


    public function category(){
        check_backoffice_permission('category');
        $this->data['page']="admin/category";
        $this->data['menu']="content_management";
        $this->data['breadcrumb']="Category";
        $this->data['menu_item']="backoffice/category";
        $this->data['categoryArr'] = $this->Content_model->get_category();
        $this->data['school'] = $this->Content_model->get_school();
        $this->load->view('admin/layouts/_master',$this->data);
    } 
    public function categoryCheck(){
        $topic_title=$this->input->post('topic_title');
        $query= $this->db->get_where('web_category',array("category"=>$topic_title,'status'=> '1'));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }

    public function category_add()
    {
        //  show($_POST);
        if($_POST){
            $data=array();
            $data['school_id']= $this->input->post('school'); 
            $data['category']= $this->input->post('category');
            $data['category_key'] = $this->convert( $data['category'] ); 
            // show($data);
            $response = $this->Common_model->insert('web_category', $data); 
            // echo $this->db->last_query(); exit;
            if($response != 0)
            {
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully added data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New category added in content management', $who, $what, $response, 'web_category');
            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!1";
            } 
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!2";
        }
        print_r(json_encode( $ajax_response));
    }
    public function load_category_ajax(){
        $category = $this->Content_model->get_category();
        $html = ' <thead> 
                    <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('category').'</th>
                        <th >'.$this->lang->line('school').'</th> 
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        if(!empty($category)){
            $i=1; 
            foreach($category as $data){
                $html.='<tr id="row_'.$data->id.'">
                            <td>
                                '.$i.'
                            </td>
                            <td id="category_'.$data->id.'">
                                '.$data->category.'
                            </td>
                            <td id="school_'.$data->id.'">
                                '.$this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id)).'
                            </td>
                            <td id="status_'.$data->id.'">';
                                if($data->status == '0'){
                                    $html.='<span class="btn mybutton mybuttonInactive" onclick="edit_catogory_status('.$data->id.','.$data->status.');">Inactive</span>';
                                }else if($data->status == '1'){
                                    $html.='<span class="btn mybutton  mybuttonActive" onclick="edit_catogory_status('.$data->id.','.$data->status.');">Active</span>';
                                }
                $html.='</td>
                            <td id="action_'.$data->id.'">
                                <button class="btn btn-default option_btn " title="Edit" onclick="get_category_Data(\''.$data->id.'\')">
                                    <i class="fa fa-pencil "></i>
                                </button>';
                                if($data->status == '0'){
                $html.='<a class="btn btn-default option_btn" title="Delete" onclick="delete_catogory_Data('.$data->id.')">
                            <i class="fa fa-trash-o"></i>
                        </a>';
                                    }
                $html.='</td>
                        </tr>';
                $i++;
            }
        } 
        echo $html;
    }
    public function load_category_ajaxExtra($id){
        // $id  = $_POST['id'];
        $ajax_response['status'] = '';
        $ajax_response['action'] = '';
        $category = $this->Content_model->get_category_id($id);
        // show($category);
        $ajax_response['category'] = $category['category'];
        $ajax_response['school'] = $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$category['school_id']));
        if($category['status'] == '0'){
            $ajax_response['status'] .= '<span class="btn mybutton mybuttonInactive" onclick="edit_catogory_status('.$category['id'].','.$category['status'].')">Inactive</span>';
        }else if($category['status'] == '1'){
            $ajax_response['status'] .= '<span class="btn mybutton  mybuttonActive" onclick="edit_catogory_status('.$category['id'].','.$category['status'].')">Active</span>';
        }
        $ajax_response['action'] .= '<button class="btn btn-default option_btn " title="Edit" onclick="get_category_Data('.$category['id'].')">
                                        <i class="fa fa-pencil "></i>
                                    </button>';
        if($category['status'] == '0'){
            $ajax_response['action'] .= '<a class="btn btn-default option_btn" title="Delete" onclick="delete_catogory_Data('.$category['id'].')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>';
        }
        print_r(json_encode( $ajax_response));
    }
    public function get_category_id($id){
        $category_array= $this->Content_model->get_category_id($id);
        print_r(json_encode($category_array));
    }
    public function categoryCheck_edit(){
        $topic_title=$this->input->post('topic_title');
        $id = $this->input->post('id');
        $query= $this->db->get_where('web_category',array("category"=>$topic_title,'id!='=>$id));
        if($query->num_rows()>= 1)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function category_edit()
    {
        //  show($_POST);
        if($_POST){
            $data=array();
            $data['school_id']= $this->input->post('school'); 
            $data['category']= $this->input->post('category');
            $data['category_key'] = $this->convert( $data['category'] ); 
            $id = $this->input->post('id');
            $response = $this->Common_model->update('web_category', $data ,array('id'=>$id));
            // echo $this->db->last_query(); exit;
            if($response){
                $ajax_response['st']=1;
                $ajax_response['id'] = $id;
                $ajax_response['msg']="Successfully updated data";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Category edited in content management', $who, $what, $id, 'web_category');
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            } 
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function edit_category_status(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $categoryCheck = $this->Content_model->categoryCheckassign($id);
        if($categoryCheck || $status == 0){
            $res = $this->Content_model->change_category_status($id, $status);
            if($res == 1){
                $ajax_response['st']=1;
                $ajax_response['msg']="Status changed successfully.!";
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Category status changed in content management', $who, $what, $id, 'web_category');
            }
        }else{
            $ajax_response['st']=2;
            $ajax_response['msg']="Category already assigned. Can't inactive.! ";
        }
        print_r(json_encode($ajax_response));
    }
    public function edit_howtoprepare_status(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $res = $this->Content_model->edit_howtoprepare_status($id, $status);
        if($res == 1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'How to prepare status changed in content management', $who, $what, $id, 'web_prepare_content');
        }
        print_r($res);
    }
    public function category_delete()
    {
        if($_POST){
            $id  = $_POST['id'];
            $res = $this->common->delete('web_category', array('id'=>$id));
            if($res){
                $what = $this->db->last_query();
                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'Category deleted from content management', $who, $what, $id, 'web_category');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully deleted data";

            }
            else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!1";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!2";
        }
        print_r(json_encode($ajax_response));
    }
}