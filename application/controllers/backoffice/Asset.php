<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="asset_management";
        check_backoffice_permission($module);
      //  print_r($_POST);
    }

    public function index()
    {
       
        check_backoffice_permission('asset_category');
        $this->data['page']="admin/asset_category";
		$this->data['menu']="asset_management";
        $this->data['breadcrumb']="Asset Category";
        $this->data['menu_item']="Asset-category";
         $this->data['dataArr']=$this->common->get_alldata_orderby('assets_category',array('status'=>1),'id','desc');
		$this->load->view('admin/layouts/_master',$this->data);
		
    }
    public function manage_supportive_services()
    {
        check_backoffice_permission('supportive_services');
        $this->data['page']="admin/supportive_services";
		$this->data['menu']="asset_management";
        $this->data['breadcrumb']="Supportive Services";
        $this->data['menu_item']="backoffice/supportive-services";
        $this->data['serviceArr']=$this->common->get_alldata_orderby('assets_supportive_services',array('status'=>1),'id','desc');
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    public function add_service()
    {
       
        $document="";
        if(!empty($_FILES['file_name']['name']))
        {

            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            $config['upload_path']           = 'uploads/supportive_service_documents/';
            $config['allowed_types']        = 'jpg|jpeg|png|bmp|pdf|doc|docx';
            $config['max_size'] = '10000';
            $_FILES['file_name']['size']     = $files['size'];
            //$config['file_name'] =$this->input->post('description').'_'.time();
            // $_FILES['file_name']['size']     = $files['size'];
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');
            $fileData = $this->upload->data();
             if(!$upload)
            {
                 $ajax_response['st']   =3;
                 $ajax_response['message']=  $this->upload->display_errors();
                 print_r(json_encode($ajax_response));
                  return false;
            }
             else
             {
                  $document ='uploads/supportive_service_documents/'. $fileData['file_name'];
                 
             }
           
        }
        if($_POST)
        {
           $data=array(
                "description"=>$this->input->post('description'),
                "type"=>$this->input->post('type'),
                "date_from"=>date('Y-m-d',strtotime($this->input->post('date_from'))),
                "date_to"=>date('Y-m-d',strtotime($this->input->post('date_to'))),
                "alert"=>$this->input->post('alert'),
                "contact_person"=>$this->input->post('contact_person'),
                "mobile_number"=>$this->input->post('mobile_number'),
                "email_id"=>$this->input->post('email'),
                "status"=>1,
                "file"=>$document
            ); 
            $check_data=$data;
            unset($check_data['file']);
            $exist=$this->common->check_if_dataExist('assets_supportive_services',$check_data);
            /*echo $this->db->last_query()."<br>";
            echo $exist;*/
                if($exist == 0)
                {
                   $response_id=$this->Common_model->insert('assets_supportive_services',$data);
                   if($response_id != 0)
                   {
                      $ajax_response['st']=1; 
                      $ajax_response['message']="Successfully Added Supportive Service..!";
                       
                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('insert', 'database', $who, $what, $response_id, 'assets_supportive_services','Added Supportive Service');
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
               $ajax_response['message']="This Data Already Exist..!";   
            }
            
          print_r(json_encode($ajax_response)); 
        }
    }
    
   //get service data by id
    public function get_serviceData_by_id()
    {
        if($_POST)
        {
            $id=$this->input->post('id');
            $ajax_response=$this->common->get_from_tablerow('assets_supportive_services',array("id"=>$id));
            $ajax_response['start_date']=date('d-m-Y',strtotime($ajax_response['date_from']));
            $ajax_response['end_date']=date('d-m-Y',strtotime($ajax_response['date_to']));
            $ajax_response['file']=str_replace('uploads/supportive_service_documents/', '', $ajax_response['file']);
            print_r(json_encode($ajax_response));
        }
    }

    //edit supportive service
    public function edit_service()
    {
      //  print_r($_POST);//die();
        if($_POST)
        {

            $id=$this->input->post('id');
            unset($_POST['id']);
            $document="";
        if(!empty($_FILES['file_name']['name']))
        {

            $files = str_replace(' ', '_', $_FILES['file_name']);
            $this->load->library('upload');
            $config['upload_path']           = 'uploads/supportive_service_documents/';
            $config['allowed_types']        = 'jpg|jpeg|png|bmp|pdf|doc|docx';
            $config['max_size'] = '10000';
            $_FILES['file_name']['size']     = $files['size'];
            //$config['file_name'] =$this->input->post('description').'_'.time();
            // $_FILES['file_name']['size']     = $files['size'];
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('file_name');


             if($upload)
            {
                  $fileData = $this->upload->data();
                  $document ='uploads/supportive_service_documents/'. $fileData['file_name'];
            }
             else
             {

                 $ajax_response['st']   =3;
                 $ajax_response['message']=  $this->upload->display_errors();
                  print_r(json_encode($ajax_response));
                  return false;

             }

        }

            $data=array(
                "description"=>$this->input->post('description'),
                "type"=>$this->input->post('type'),
                "date_from"=>date('Y-m-d',strtotime($this->input->post('from'))),
                "date_to"=>date('Y-m-d',strtotime($this->input->post('to'))),
                "alert"=>$this->input->post('alert'),
                "contact_person"=>$this->input->post('contact_person'),
                "mobile_number"=>$this->input->post('mobile_number'),
                "email_id"=>$this->input->post('email')

            );
           // print_r($data);die();
            $check_data=$data;
            if(!empty($document))
               {
                   $data['file']=$document;//for not replace by null,if there is no file uploaded
                   unset($check_data['file']);
               }

            $check_data['id!=']=$id;
            $exist=$this->common->check_if_dataExist('assets_supportive_services',$check_data);
                if($exist == 0)
                {

                   $response_id=$this->Common_model->update('assets_supportive_services',$data,array("id"=>$id));
                    //echo $this->db->last_query();
                   if($response_id != 0)
                   {
                      $ajax_response['st']=1;
                      $ajax_response['message']="Successfully Updated Supportive Service..!";

                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('update', 'database', $who, $what, $response_id, 'assets_supportive_services','Updated Supportive Service');
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
               $ajax_response['message']="This Data Already Exist..!";
            }

          print_r(json_encode($ajax_response));
        }
    }
    //delete service

    public function delete_service()
    {
        $id      = $this->input->post('id');
        $where = array('id'=>$id);
        $data  = array('status'=>2);

        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];


                $query = $this->common->delete_fromwhere('assets_supportive_services', $where, $data);
         if($query) {
                $res['status']   = 1;
                $res['message']  = 'Supportive Service Details deleted successfully';
                $what = $this->db->last_query();
                $table_row_id    = $this->db->insert_id();
                logcreator('delete', 'database', $who, $what, $id, 'assets_supportive_services','Supprortie Sevice Details Deleted');

        } else {

           $res['status']   = 0;
           $res['message']  = 'Something went wrong.Please try again later..!';

        }
        print_r(json_encode($res));
    }

    //load service by ajax
    public function load_supportive_service_ajax()
    {
       $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('service_name').'
                            </th>
                            <th>
                                '. $this->lang->line('contract_type').'
                            </th>
                            <th>
                                '. $this->lang->line('contact_person').'
                            </th>
                            <th>
                                '. $this->lang->line('mobile_no').'
                            </th>
                            <th>
                                '. $this->lang->line('emailid').'
                            </th>
                            <th>
                                '. $this->lang->line('document').'
                            </th>
                            <th>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>';
        $data=$this->common->get_alldata_orderby('assets_supportive_services',array('status'=>1),'id','desc');
         if(!empty($data))
         {

            $i=1;
             foreach($data as $rows)
             {
                 $doc="";
                 if($rows['file'] != "")
                    {
                       $doc='<a target="_blank" class="btn mybutton btn_add_call " href="'.  base_url().$rows['file'].'">View document</a>'; 
                    }

                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['description'].'</td>
                        <td>'.$rows['type'].'</td>
                        <td>'.$rows['contact_person'].'</td>
                        <td>'.$rows['mobile_number'].'</td>
                        <td>'.$rows['email_id'].'</td>
                        <td>'.$doc.'
                        
                        
                        
                        </td></td>


                        <td><button type="button" class="btn btn-default option_btn " onclick="view_servicedata('. $rows['id'].')" title="Click here to view the details" >
                            <i class="fa fa-eye "></i>
                        </button><button title="Edit" class="btn btn-default option_btn "  onclick="get_servicedata('.  $rows['id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_servicedata('.$rows['id'].')"><i class="fa fa-trash-o"></i>
                    </a></td>

                        </tr>';
                 $i++;
             }
         }
        echo $html;
    }
    
    
    //manage mainatanance type
    public function manage_maintenance_type()
    {
        check_backoffice_permission('maintenance_service_type');
        $this->data['page']="admin/maintenance_type";
		$this->data['menu']="asset_management";
        $this->data['breadcrumb']="Maintenance Service Type";
        $this->data['menu_item']="backoffice/maintenance-service-type";
        $this->data['typeArr']=$this->common->get_alldata_orderby('assets_maintenance_service_type',array('status'=>1),'id','desc');
		$this->load->view('admin/layouts/_master',$this->data);
    }

    //add maintenenace type
    public function add_maintenance_type()
    {
         if($_POST)
        {
           $data=array(
                        "type"=>$this->input->post('type'),
                        "allowed_amount"=>$this->input->post('allowed_amount')

           );

            $exist=$this->common->check_if_dataExist('assets_maintenance_service_type',array('type'=>$this->input->post('type'),'status'=>'1'));
                if($exist == 0)
                {
                   $response_id=$this->Common_model->insert('assets_maintenance_service_type',$data);
                    /* echo $this->db->last_query()."<br>";
                     echo $response_id;  */
                   if($response_id != 0)
                   {
                      $ajax_response['st']=1;
                      $ajax_response['message']="Successfully Added Maintenance Service Type..!";

                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('insert', 'database', $who, $what, $response_id, 'assets_maintenance_service_type','Added Maintenance Service Type');
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
               $ajax_response['message']="This Data Already Exist..!";
            }

          print_r(json_encode($ajax_response));
        }
    }
 //get maintenance  service type by id
    public function get_maintenancetype_byId()
    {

       if($_POST)
       {
            $ajax_response['data']=$this->common->get_from_tablerow('assets_maintenance_service_type' ,array("id"=>$this->input->post('id')));
           print_r(json_encode($ajax_response));
        }
    }

    //edit maintenance service type by id
    public function edit_maintenance_type()
    {

        if($_POST)
        {
           $id= $this->input->post('id');
           $data=array(
                        "type"=>$this->input->post('type'),
                        "allowed_amount"=>$this->input->post('allowed_amount')

           );
           $check_data=$data;
            unset($check_data['allowed_amount']);
            $check_data['id!=']=$id;
            $exist=$this->common->check_if_dataExist('assets_maintenance_service_type',$check_data);
                if($exist == 0)
                {
                   $response=$this->Common_model->update('assets_maintenance_service_type',$data,array('id'=>$id));
                    /* echo $this->db->last_query()."<br>";
                     echo $response_id;  */
                   if($response)
                   {
                      $ajax_response['st']=1;
                      $ajax_response['message']="Successfully Updated Maintenance Service Type..!";

                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('update', 'database', $who, $what, $id, 'assets_maintenance_service_type','Updated Maintenance Service Type.');
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
               $ajax_response['message']="This Data Already Exist..!";
            }

          print_r(json_encode($ajax_response));
        }
    }
    //delete maintenance type

    public  function delete_maintenanace_type()
    {
        if($_POST){
        $id      = $this->input->post('id');
        $where = array('id'=>$id);
        $data  = array('status'=>2);

        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        $exist=$this->common->check_if_dataExist('assets_maintenance_service',array("maintenance_type"=>$id));
          
            if($exist==0){
        $query = $this->common->delete_fromwhere('assets_maintenance_service_type', $where, $data);
        if($query)
        {
                $what = $this->db->last_query();
                $res['status']   = true;
                $res['message']  = 'Maintenance Service Type Details deleted successfully';
                logcreator('delete', 'database', $who, $what, $id, 'assets_maintenance_service_type','Maintenance Service Type Details Deleted');

        }
        else
        {

           $res['status']   = false;
           $res['message']  = 'Something went wrong.Please try again later..!';
        }
            }
            else
            {
             $res['status']   = false;
             $res['message']  = 'Some maintenance services are added under this maintenanace type..!';   
            }
        print_r(json_encode($res));
        }
    }

    //load maintenance type service by ajax
    public function maintenanace_type_byAjax()
    {
       $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('type').'
                            </th>
                            <th>
                                '. $this->lang->line('allowed_amount').'
                            </th>
                            <th>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>';
        $data=$this->common->get_alldata_orderby('assets_maintenance_service_type',array('status'=>1),'id','desc');
         if(!empty($data))
         {

            $i=1;
             foreach($data as $rows)
             {

                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['type'].'</td>
                        <td>'.$rows['allowed_amount'] .' Rs </td>
                        <td><button title="Edit" class="btn btn-default option_btn "  onclick="get_typedata('.  $rows['id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_typedata('.$rows['id'].')"><i class="fa fa-trash-o"></i>
                    </a></td>

                        </tr>';
                 $i++;
             }
         }
        echo $html;
    }
    
    
    //manage maintenance services
    public function manage_maintenance_services()
    {
        check_backoffice_permission('maintenance_services');
        $this->data['page']="admin/maintenance_request";
		
        $this->data['breadcrumb']="Maintenance Service";
        $user_role=$this->session->userdata['role'];
       /* if($user_role == "admin")
        {*/
          $this->data['menu']="asset_management";
        /*}
        else if($user_role == "centerhead" || $user_role == "operationhead")
        {
          $this->data['menu']="receptionist"; 
        }*/
        $this->data['menu_item']="backoffice/maintenance-services"; 
        $this->data['typeArr']=$this->common->get_alldata('assets_maintenance_service_type',array('status'=>1));
        $this->data['groupArr']      = $this->institute_model->get_allgroups();
        $this->data['requestArr']=$this->Asset_model->get_allmaintenanace_requestList();
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    //add maintenence request
    public function add_maintenance_request()
    {
        if($_POST)
        {
          
            $data=array(
                        "type"=>$this->input->post('type'),
                        "maintenance_type"=>$this->input->post('maintenance_type'),
                        "description"=>$this->input->post('description'), 
                        "institute_id"=>$this->input->post('center_name') 
                         
                  );

            /*$exist=$this->common->check_if_dataExist('assets_maintenance_service',$data);
                if($exist == 0)
                {*/
                   $response_id=$this->Common_model->insert('assets_maintenance_service',$data);
                    /* echo $this->db->last_query()."<br>";
                     echo $response_id;  */
                   if($response_id != 0)
                   {
                       
                        $what=$this->db->last_query();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('insert', 'database', $who, $what, $response_id, 'assets_maintenance_service','Added Maintenance Service Request');
                       
                        $service_request_array=array(
                                                       "service_id"=>$response_id,
                                                       "approved_status"=>"Requested",
                                                        "approved_by"=>$this->session->userdata['user_primary_id'], 
                                                        "approving_authority"=>$this->session->userdata['role']
                                                    );
                        $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$service_request_array);
                           if($insert_id!="")
                           {
                             $ajax_response['st']=1;
                             $ajax_response['message']="Successfully Added Maintenance Service Request..!";  
                                $query=$this->db->last_query();
                                logcreator('insert', 'database', $who, $query, $insert_id, 'assets_maintenance_service_details','Added Maintenance Service Request');
                           }
                       
                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
    
                   }
                    else
                    {
                      $ajax_response['st']=0;
                      $ajax_response['message']="Something went wrong,Please try again later..!";
                    }
/*                }
            else
            {
               $ajax_response['st']=2;
               $ajax_response['message']="This Data Already Exist..!";
            }*/

          print_r(json_encode($ajax_response));

        }
    }
    
   //get maintenance request details by id
    public function get_maintenance_request_byId()
    {

        if($_POST)
        { 
            $id=$this->input->post('id');
          
            $history_data=$this->common->get_alldata('assets_maintenance_service_details', array("service_id"=>$id));// echo "<pre>"; print_r($history_data); die();
            $ajax_response['history']='';
            $ajax_response['old_dates']='';
            $ajax_response['old_amount_requested']='';
            $ajax_response['old_amount_taken']='';
            $approved_by='';
            if(!empty($history_data))
            {  $i=1; 
                foreach($history_data as $val)
                {
                    if($val['approved_by']!= "")
                    { 
                        if($val['approved_by'] != 0)
                        {
                          
                            $approved_userdetail=$this->common->get_from_tablerow('am_users_backoffice',array("user_id"=>$val['approved_by']));
                           
                           
                            $approved_by=$approved_userdetail['user_name'];
                        }
                        else
                        {
                          $approved_by="Admin";  
                        }
                    }
                    else
                    {
                        $approved_by='';
                    }
                   $date= date("d/m/Y",strtotime($val['created_on']));
                   $ajax_response['history'].='<tr><td>'.$i.'</td><td>'.$date.'</td><td>'.$val['approved_status'].'</td><td>'.$val['comments'].'</td><td>'.$val['approving_authority'].'</td><td>'.$approved_by.'</td></tr>';
                    
                    if($val['date_of_completion']!=""){
                    $ajax_response['old_dates'].='<label>'.date("d/m/Y",strtotime($val['date_of_completion'])).'</label><br>';
                    }
                     if($val['requested_amount']!="" && $val['approved_status']=="Waiting for Approval"){
                    $ajax_response['old_amount_requested'].='<label>INR '.$val['requested_amount'].'</label><br>';
                     }
                    if($val['total_amount']!=""){
                    $ajax_response['old_amount_taken'].='<label>INR '.$val['total_amount'].'</label><br>';
                     }
                    $i++;
                }
            }
            $data=$this->Asset_model->get_maintenance_request_byId($id);
              
            if($data['date_of_approval']!="")
            {
                $data['date_of_approval']=date("d/m/Y",strtotime($data['date_of_approval']));
            }
             if($data['date_of_completion']!="")
            {
                $data['date_of_completion']=date("d/m/Y",strtotime($data['date_of_completion']));
            }
            if($data['requested_amount']!="")
            {
                $data['requested_amount']=numberformat($data['requested_amount']);
            }
            if($data['total_amount']!="")
            {
                $data['total_amount']=numberformat($data['total_amount']);
            }
            if($data['allowed_amount']!="")
            {
                $data['allowed_amount']=numberformat($data['allowed_amount']);
            }

             $data['created_on']=date("d/m/Y",strtotime($data['created_on']));
            if(!empty($data['approved_by']))
            {
                 $approved_userdetail=$this->common->get_from_tablerow('am_users_backoffice',array("user_id"=>$val['approved_by']));
                           
                            $data['approved_by']=$approved_userdetail['user_name']."(".$approved_userdetail['user_role'].")";
            }
            $ajax_response['data']=$data;
            


            $ajax_response['centre_name']=$this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$data['institute_id']));
            $branch_id=$this->common->get_name_by_id('am_institute_master','parent_institute',array("institute_master_id"=>$data['institute_id']));
            $group_id=$this->common->get_name_by_id('am_institute_master','parent_institute',array("institute_master_id"=>$branch_id));
            $ajax_response['branch_id']=$branch_id;
            $ajax_response['group_id'] =$group_id;
            
            $branchArr=$this->institute_model->get_allsub_byparent(array("parent_institute"=>$group_id));
      
           $branch_html="";
           if(!empty($branchArr)){
                foreach ($branchArr as $row)
                {
                     $branch_html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                }
            }
            $ajax_response['branches']=$branch_html;
            
             $centreArr=$this->institute_model->get_allsub_byparent(array("parent_institute"=>$branch_id));
             
             $centre_html="";
             if(!empty($centreArr))
             {
                foreach ($centreArr as $row)
                {
                     $centre_html.= '<option value="' . $row['institute_master_id'] . '" >' . $row['institute_name'] . '</option>';
                }
             }
            $ajax_response['centres']=$centre_html;
            
            
           // echo $this->db->last_query();
            print_r(json_encode($ajax_response));
        }
    }
    
    //edit maintenance request
    public function edit_maintenance_request()
    {
        if($_POST)
        {
           // print_r($_POST);
            $id=$this->input->post('id');
            $data=array(
                        "type"=>$this->input->post('type'),
                        "maintenance_type"=>$this->input->post('maintenance_type'),
                        "description"=>$this->input->post('description'), 
                        "institute_id"=>$this->input->post('center_name'), 
                  );

                $response=$this->Common_model->update('assets_maintenance_service',$data,array('id'=>$id));
                    if($response != 0)
                   {
                       
                         $what=$this->db->last_query();
                         $table_row_id    = $this->db->insert_id();
                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                        logcreator('update', 'database', $who, $what, $table_row_id, 'assets_maintenance_service','Updated Maintenance Service Request');
                       
                             $ajax_response['st']=1;
                             $ajax_response['message']="Successfully Updated Maintenance Service Request..!";  
                   }
                    else
                    {
                      $ajax_response['st']=0;
                      $ajax_response['message']="Something went wrong,Please try again later..!";
                    }
        }
        print_r(json_encode($ajax_response));
    }
    //delete maintenance request data
    public function delete_maintenanceRequest_data()
    {
        if($_POST)
        {
           
                $id=$this->input->post('id');
                $where = array('id'=>$id);
                $data  = array('status'=>2);

                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                $query = $this->common->delete_fromwhere('assets_maintenance_service', $where, $data);
                if($query)
                {
                        $what = $this->db->last_query();
                        $res['st']   = true;
                        $res['message']  = 'Maintenance Service Request Deleted Successfully';
                        logcreator('delete', 'database', $who, $what, $id, 'assets_maintenance_service','Maintenance Service Request Deleted');

                }
                else
                {

                   $res['st']   = false;
                   $res['message']  = 'Something went wrong.Please try again later..!';
                }
                print_r(json_encode($res));
                
        }
    }
    
    //load maintenance request by ajax
    
    public function load_service_request_byAjax()
    {
      $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('centre').'
                            </th>
                            <th>
                                '. $this->lang->line('type').'
                            </th> 
                            <th>
                                '. $this->lang->line('requested_date').'
                            </th>
                            <th>
                                '. $this->lang->line('maintenance_service_type').'
                            </th>
                            <th>
                                '. $this->lang->line('description').'
                            </th>
                            <th>
                                '. $this->lang->line('status').'
                            </th>
                            <th nowrap>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>';
        $data=$this->Asset_model->get_allmaintenanace_requestList();
         if(!empty($data))
         {

            $i=1;
             foreach($data as $rows)
             {
                $status="" ;
                 if ($rows['approved_status']=="Requested") {
                                $status.= '<span class="inactivestatus">'.$this->lang->line('requested').'</span>';
                            }
                            else if($rows['approved_status']=="Waiting for Approval") {
                                $status.= '<span class="paymentcompleted">'.$this->lang->line('waiting_for_approval').'</span>';
                            }
                            else if($rows['approved_status']== "Approved") { 
                                $status.= '<span class="admitted">'.$this->lang->line('approved').'</span>';
                            }
                            else if($rows['approved_status']== "Completed") { 
                                $status.= '<span class="batchchanged">'.$this->lang->line('completed').'</span>';
                            }
                            else if($rows['approved_status']== "Reopen") 
                            { 
                                $status.= '<span class="registered">'.$this->lang->line('reopened').'</span>';
                            } else if($rows['approved_status']== "Declined")
                            {
                                $status.= '<span class="declined">'.$this->lang->line('declined').'</span>';
                            }
                   $action="";
                  if ($rows['approved_status']=="Requested" || $rows['approved_status'] == "Reopen")
                  {
                     $action.='<button title="Edit" class="btn btn-default option_btn "  onclick="get_requestdata('.$rows['service_id'].')">
                     <i class="fa fa-pencil "></i></button>
                     <a class="btn btn-default option_btn" title="Delete" onclick="delete_requestdata('.$rows['service_id'].')"><i class="fa fa-trash-o"></i>
                    </a>';
                  }
                elseif($rows['approved_status'] == "Completed")
                {
                     $action.='<select name="status" class="form-control tableSelect c_status" onchange="change_status('.$rows['service_id'].');" id="id_'.$rows['service_id'].'">
                                <option>Select</option>
                                <option value="Reopen">Reopen</option>
                      </select>';
                 }

                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['institute_name'].'</td>
                        <td>'.$rows['type'].'</td>
                        <td>'.date('d-m-Y',strtotime($rows['created_on'])).' </td>
                        <td>'.$rows['maintenanacetype_name'].'</td>
                        <td>'.$rows['description'].'</td>
                        <td>'.$status.'</td>
                       
                        <td nowrap>
                        <button type="button" class="btn btn-default option_btn " onclick="show_request_data('. $rows['service_id'].')" title="Click here to view the details" > <i class="fa fa-eye "></i></button>'.$action.'

                        </td>
                        </tr>';
                 $i++;
             }
         }
        echo $html;  
    }
    
    
    
    /*manage maintenanace service request*/
    public function manage_maintenance_service_requests()
    {
        
        check_backoffice_permission('view_maintenance_services');
        $this->data['page']="admin/maintenance_request_view";
		
        $this->data['breadcrumb']="Maintenance Service Requests";
       /* $user_role=$this->session->userdata['role'];
        if($user_role == "admin")
        {*/
          $this->data['menu']="asset_management";
       // }
       // else if($user_role == "centerhead")
       // {
        //  $this->data['menu']="receptionist"; 
       // }
        $this->data['menu_item']="backoffice/view-maintenance-services"; 
        $this->data['typeArr']=$this->common->get_alldata('assets_maintenance_service_type',array('status'=>1));
        $this->data['groupArr']      = $this->institute_model->get_allgroups();
        $this->data['requestArr']=$this->Asset_model->get_allmaintenanace_requestList();
         //echo "<pre>"; print_r($this->data['requestArr']); die();
		$this->load->view('admin/layouts/_master',$this->data);   
    }
    
    //approve request by operation head
    public function approve_request_byOperationHead()
    {
        if($_POST)
        {
            //print_r($_SESSION);die();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $id=$this->input->post('id');
            $data=array(
                        "approved_status"=>"Approved",
                        "service_id"=>$id,
                       
                        "approving_authority"=>"Operation Team",
                        "date_of_approval"=>date('Y-m-d')
                        );
            if($this->session->userdata['user_id'] =="" && $this->session->userdata['role'] == "admin")
          {
              $data["approved_by"]=0; 
          }
          else
          {
            $data["approved_by"]=$this->session->userdata['user_primary_id'];
          }
            
            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);
            //echo $this->db->last_query();
                           if($insert_id!="")
                           {
                                 $ajax_response['st']=1;
                                $ajax_response['message']="Request Approved Successfully!";  
                                $query=$this->db->last_query();
                                logcreator('insert', 'database', $who, $query, $insert_id, 'assets_maintenance_service_details','Request Approved');
                           }
                       
                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));
        }
    }
    
    //send for approval
    public function send_for_approval()
    {
        if($_POST)
        {
           // print_r($_POST);
           $data=array(
                        "service_id"=>$this->input->post('id'),
                        "comments"=>$this->input->post('comments'),
                        "requested_amount"=>$this->input->post('total_amount'),
                        "approved_status"=>"Waiting for Approval",
                        "date_of_approval"=>date('Y-m-d'),
                        "approved_by"=>$this->session->userdata['user_primary_id'],
                        "approving_authority"=>$this->session->userdata['role']
           );
            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);
           // echo $this->db->last_query();
                           if($insert_id!="")
                           {
                                 $ajax_response['st']=1;
                                $ajax_response['message']="Send for Approval Successfully!";  
                                $query=$this->db->last_query();
                                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                                logcreator('insert', 'database', $who, $query, $insert_id, 'assets_maintenance_service_details','Send for Approval');
                           }
                       
                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));
        }
    }

    public function complete_task()
    {
      if($_POST)
      {
          //  print_r($_POST); die();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $id=$this->input->post('id');
            $total_amount=$this->input->post('total_amount');
            $data=$this->Asset_model->get_maintenance_request_byId($id);

          $approved_userdetail=$this->common->get_from_tablerow('am_staff_personal',array("personal_id"=>$data['approved_by']));
            $data=array(
                        "approved_status"=>"Completed",
                        "service_id"=>$id,
                        "requested_amount"=>$data['requested_amount'],
                        "approved_by"=>$this->session->userdata['user_primary_id'],
                        "approving_authority"=>$this->session->userdata['role'],
                        "date_of_completion"=>date('Y-m-d'),
                        "total_amount"=>$total_amount,
                        );

            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);
                           if($insert_id!="")
                           {
                                $ajax_response['st']=1;
                                $ajax_response['message']="Request Completed Successfully!";
                                $query=$this->db->last_query();
                                logcreator('insert', 'database', $who, $query, $insert_id, 'assets_maintenance_service_details','Request Completed');
                           }

                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));

      }
    }
  //reopen the completed request by branch head
    public function Reopen_request()
    {
       if($_POST)
       {
           $data=array(
                        "service_id"=>$this->input->post('id'),
                        "comments"=>$this->input->post('comments'),
                        "approved_status"=>"Reopen",
                        "approved_by"=>$this->session->userdata['user_primary_id'],
                        "approving_authority"=>$this->session->userdata['role']
                     );
            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);

                           if($insert_id!="")
                           {
                                 $ajax_response['st']=1;
                                $ajax_response['message']="Service Reopened Successfully!";
                                $query=$this->db->last_query();
                                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                                logcreator('insert', 'database', $who, $query, $insert_id, 'assets_maintenance_service_details','reopen request');

                           }

                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));
       }
    }
/*This unction will load the maintenance request list by ajax for operation team
@auther GBS-L
*/
    public function load_service_request_view_byAjax()
    {
      $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('description').'
                            </th>
                            <th>
                                '. $this->lang->line('maintenance_type').'
                            </th>
                            <th>
                                '. $this->lang->line('centre').'
                            </th>
                            <th>
                                '. $this->lang->line('type').'
                            </th>
                            <th>
                                '. $this->lang->line('status').'
                            </th>
                            <th>
                                '. $this->lang->line('requested_date').'
                            </th>
                            <th>
                                '. $this->lang->line('allowed_amount').'
                            </th>
                            <th nowrap>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>';
        $data=$this->Asset_model->get_allmaintenanace_requestList();
         if(!empty($data))
         {

            $i=1;
             foreach($data as $rows)
             {
                $status="" ;
                 if ($rows['approved_status']=="Requested") {
                                $status.= '<span class="inactivestatus">'.$this->lang->line('requested').'</span>';
                            }
                            else if($rows['approved_status']=="Waiting for Approval") {
                                $status.= '<span class="paymentcompleted">'.$this->lang->line('waiting_for_approval').'</span>';
                            }
                            else if($rows['approved_status']== "Approved") {
                                $status.= '<span class="admitted">'.$this->lang->line('approved').'</span>';
                            }
                            else if($rows['approved_status']== "Completed") {
                                $status.= '<span class="batchchanged">'.$this->lang->line('completed').'</span>';
                            }
                            else if($rows['approved_status']== "Reopen")
                            {
                                $status.= '<span class="registered">'.$this->lang->line('reopened').'</span>';
                            } else if($rows['approved_status']== "Declined")
                            {
                                $status.= '<span class="declined">'.$this->lang->line('declined').'</span>';
                            }
                     $action="";
                     $option="";
                       if ($rows['approved_status']=="Requested" || $rows['approved_status']=="Reopen") {
                           $option.='<option value="Approved" >Approve</option>
                                <option value="Waiting for Approval">Send for Approval</option>';
                       }
                      elseif( $rows['approved_status']=="Approved") {
                                 $option.='<option value="Completed">Work Completed</option>';
                         }

                     if ($rows['approved_status']=="Requested" ||  $rows['approved_status']=="Reopen" || $rows['approved_status']=="Approved")
                     {
                        $action.='<select name="status" class="form-control tableSelect c_status" onchange="change_status('.$rows['service_id'].');" id="id_'.$rows['service_id'].'">
                        <option>Select</option>'.$option.'</select>';
                     }


                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['description'].'</td>
                        <td>'.$rows['maintenanacetype_name'].'</td>
                        <td>'.$rows['institute_name'].'</td>
                        <td>'.$rows['type'].'</td>
                        <td>'.$status.'</td>
                        <td>'.date('d/m/Y',strtotime($rows['created_on'])).' </td>
                        <td>'.numberformat($rows['allowed_amount']).' </td>
                        <td nowrap>
                        <button type="button" class="btn btn-default option_btn " onclick="show_request_data('. $rows['service_id'].')" title="Click here to view the details" > <i class="fa fa-eye "></i></button>'.$action.'

                        </td>
                        </tr>';
                 $i++;
             }
         }
        echo $html;
    }

    /*This function will list the purchase quotes
    */
    public function manage_purchase_quotes()
    {
        check_backoffice_permission('manage_purchase_quotes');
        $this->data['page']="admin/purchase_quotes";
        $this->data['breadcrumb']="Purchase Quotes";
        $this->data['menu']="asset_management";
        $this->data['menu_item']="backoffice/manage-purchase-quotes";
        $this->data['dataArr']=$this->common-> get_alldata_orderby('asset_purchase',array('status'=>'1'),'id','DESC');
		$this->load->view('admin/layouts/_master',$this->data);
    }

    /**/
    public function add_purchase_quotes(){
        if($_POST){
            $purchase_data=array(
                "title"=>strtoupper($this->input->post('title')),
                "purchase_status"=>"Draft",
                "status"=>1
            );
            $duplicationCheck=$this->Asset_model->duplicationCheck($purchase_data);
            if($duplicationCheck == 0){
                $purchase_id=$this->Common_model->insert('asset_purchase', $purchase_data);
                if($purchase_id != 0){
                    $descriptionArr=$this->input->post('description');
                    $files = $_FILES;
                    $err=0;
                    for($i=0;$i<count($descriptionArr);$i++){
                        if($_FILES['file_name']['name'][$i]!=''){
                            $typeArr = explode('.', $_FILES['file_name']['name'][$i]);
                            if( (end($typeArr)== 'docx')||(end($typeArr)== 'doc')||(end($typeArr)== 'pdf')){
                            }else{
                                $err=1;
                            }
                        }else{
                            $ajax_response['st'] = 4;
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
                    if($err==0) {
                        for($i=0;$i<count($descriptionArr);$i++){ 
                            if($_FILES['file_name']['name'][$i]!='') {
                                $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/purchase_quotes';
                                $name = str_replace(' ', '_', $_FILES['file_name']['name'][$i]);
                                $config['file_name'] =time().$name;
                                $config['allowed_types'] ='pdf|docx|doc';
                                $config['max_size'] = '1000000';
                                $this->load->library('upload', $config);
                                $_FILES['file_name']['name']= $files['file_name']['name'][$i];
                                $_FILES['file_name']['type']= $files['file_name']['type'][$i];
                                $_FILES['file_name']['tmp_name']= $files['file_name']['tmp_name'][$i];
                                $_FILES['file_name']['error']= $files['file_name']['error'][$i];
                                $_FILES['file_name']['size']= $files['file_name']['size'][$i];
                                if($this->upload->do_upload('file_name')){
                                    $upload_data = $this->upload->data();
                                    $file_name = 'uploads/purchase_quotes/'.$upload_data['file_name'];
                                    $data=array(
                                        'description'=>$this->input->post('description')[$i],
                                        'quote_file'=>$file_name,
                                        'asset_purchase_id'=>$purchase_id,
                                        'quote_status'=>'Draft'
                                    );
                                    $response_id=$this->Common_model->insert('asset_purchase_quotes',$data);
                                    if($response_id >0){
                                        $what=$this->db->last_query();
                                        $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                                        logcreator('insert', 'database', $who, $what, $response_id, 'asset_purchase','added purchase quotes');
                                        $ajax_response['st']=1;
                                        $ajax_response['msg']='Purchase Quote Added Successfully..!';
                                    }else {
                                        $ajax_response['st']=0;
                                        $ajax_response['msg']='Something went wrong,Please try again later..!';
                                    }
    
                                } else {
                                    //UPLOAD FAILED
                                    $ajax_response['st']=2;
                                    $ajax_response['msg']=$this->upload->display_errors();
                                    print_r(json_encode($ajax_response));
                                    exit();
                                }
                            } else {
                                $ajax_response['st']=0;
                                $ajax_response['msg']='Something went wrong,Please try again later..!';  
                            }
                    
                        }
                    } else {
                        $ajax_response['st']=2;
                        $ajax_response['msg']="Only Upload Files with extension .pdf,.doc,.docx"; 
                    }
                }
            }else{
                $ajax_response['st']=2;
                $ajax_response['msg']='Already exist!'; 
            }
        }else{ 
            $ajax_response['st']=0;
            $ajax_response['msg']='Something went wrong,Please try again later..!'; 
        }
        print_r(json_encode($ajax_response));
    }
    
    public function delete_purchaseQuote()
    {
        if($_POST)
        {
             $id=$this->input->post('id');
             $query = $this->common->delete_fromwhere('asset_purchase', array("id"=>$id), array("status"=>"2"));
            if($query) {
                $res['st']   = 1;
                $res['message']  = 'Purchase Quote Details deleted successfully';
                $what = $this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'asset_purchase','Purchase Quote Details Deleted');

        } else {

           $res['st']   = 0;
           $res['message']  = 'Something went wrong.Please try again later..!';

        }
        print_r(json_encode($res));
            
        }
    }
    
    public function get_purchaseQuote_byId()
    {
        if($_POST) { 
            $id=$this->input->post('id');
            $data=$this->Asset_model->get_purchaseQuote_byId($id);
            // show($data);
           
           if(!empty($data))
           {
            if($data[0]['date_of_purchase'] != "")
            {
            $data[0]['date_of_purchase']=date('d-m-Y',strtotime($data[0]['date_of_purchase']));
            }
           }
           
          
            $ajax_response['data']=$data;
          
            print_r(json_encode($ajax_response));
        }
    }
    
    public function edit_purchaseQuote(){
        if($_POST){
            // show($_POST);
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            $id=$this->input->post('id');
            $status= $this->common->get_name_by_id('asset_purchase','purchase_status',array("id"=>$id));
            if($status != "Draft"){
                //updation after changing the status as approved
                //puchase detail update
                if(!empty($this->input->post('purchase_order_no')) && !empty($this->input->post('amount')) && !empty($this->input->post('date_of_purchase'))){
                    $data=array(
                        "purchase_order_no" =>$this->input->post('purchase_order_no'),
                        "amount" => $this->input->post('amount'),
                        "date_of_purchase" =>date('Y-m-d',strtotime($this->input->post('date_of_purchase'))),
                        "purchase_status" =>"Completed"
                    );
                    $update=$this->Common_model->update('asset_purchase',$data,array("id"=>$id));
                    if($update) {
                        $what=$this->db->last_query();
                        logcreator('update', 'database', $who, $what, $id, 'asset_purchase','update purchase quotes');
                        $ajax_response['st']=1;
                        $ajax_response['msg']='Purchase Quote Details Updated Successfully..!'; 
                        print_r(json_encode($ajax_response));
                        exit();
                    } else {
                        $ajax_response['st']=0;
                        $ajax_response['msg']='Something went wrong,Please try again later..!';
                        print_r(json_encode($ajax_response));
                        exit();
                    }
                } else {
                    $ajax_response['st']=0;
                    $ajax_response['msg']='Please fill the mandatory fields';    
                    print_r(json_encode($ajax_response));
                    exit();
                }
            }
            $title = $this->input->post('title');
            $edit_quote_id = $this->input->post('edit_quote_id');
            $descriptionArr = $this->input->post('new_description');
            if(!empty($descriptionArr)){
                foreach($descriptionArr as $row) {
                    if($row == "") {
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Some description fields are empty..!";
                        print_r(json_encode($ajax_response));
                        exit();  
                    }
                }
            }
            $i=0;
            $err=0;
            if($edit_quote_id){
                foreach($edit_quote_id as $key =>$value) {
                    // echo "<pre>"; print_r($_FILES['editfile_name'.$value]['name']);
                    if($_FILES['editfile_name'.$value]['name']!='') {
                        $typeArr = explode('.', $_FILES['editfile_name'.$value]['name']); 
                        if((end($typeArr) == 'docx')||(end($typeArr) == 'doc')||(end($typeArr) == 'pdf')){
                        }else{
                            $err = 1;
                        }
                    }
                    $i++;
                }
            }
            // exit;
            // show($edit_quote_id);
            if($err == 0){
                $duplicationCheck=$this->Asset_model->duplicationCheckEdit($title, $id);
                if($duplicationCheck == 0){
                    $response=$this->Common_model->update('asset_purchase', array("title"=>$title),array("id"=>$id));
                    if($response){
                        foreach($edit_quote_id as $key =>$value){ //$old_file=$this->input->post('oldfile'.$value);
                            if(!empty($_FILES['editfile_name'.$value]['name'])){
                                 //update and upload file
                                $files = str_replace(' ', '_', $_FILES['editfile_name'.$value]);
                                $config['upload_path']           = 'uploads/purchase_quotes/';
                                $config['allowed_types']        = 'pdf|docx|doc';
                                $config['max_size']      = '1000000';
                                $config['file_name'] = time().$files['name'];
                                $_FILES['editfile_name'.$value]['size']     = $files['size'];
                                $this->load->library('upload',$config);
                                $this->upload->initialize($config);
                                if($this->upload->do_upload('editfile_name'.$value)){
                                    $fileData = $this->upload->data();
                                    $quotes_data= array(
                                        "quote_file"=>'uploads/purchase_quotes/'.$fileData['file_name'],
                                        "description"=>$this->input->post('editdescription'.$value)
                                    );
                                    $update_response=$this->Common_model->update('asset_purchase_quotes', $quotes_data,array("quote_id"=>$value)); 
                                    $what=$this->db->last_query();
                                    logcreator('update', 'database', $who, $what, $id, 'asset_purchase','update purchase quotes');
                                    $ajax_response['st']=1;
                                    $ajax_response['msg']='Purchase Quote Details Updated Successfully..!';
                                } else {
                                    $ajax_response['st']=2;
                                    $ajax_response['msg']=$this->upload->display_errors();
                                    print_r(json_encode($ajax_response));
                                    exit();
                                }             
                            } else {
                                $update_response=$this->Common_model->update('asset_purchase_quotes', array("description"=>$this->input->post('editdescription'.$value)),array("quote_id"=>$value));
                                if($update_response) {
                                    $what=$this->db->last_query();
                                    logcreator('update', 'database', $who, $what, $id, 'asset_purchase','update purchase quotes');
                                    $ajax_response['st']=1;
                                    $ajax_response['msg']='Purchase Quote Details Updated Successfully..!';
                                } else {
                                    $ajax_response['st']=0;
                                    $ajax_response['msg']='Something went wrong,Please try again later..!';
                                } 
                            }
                        }
                        //insert new purchase quote
                        if(!empty($descriptionArr)){
                            for($i=0;$i<count($descriptionArr);$i++) {
                                $files = $_FILES;
                                if($_FILES['file_name']['name'][$i]!='') {
                                    $config['upload_path'] = $this->config->item('absolute_path') . 'uploads/purchase_quotes';
                                    $name = str_replace(' ', '_', $_FILES['file_name']['name'][$i]);
                                    $config['file_name'] =time().$name;
                                    $config['allowed_types'] ='pdf|docx|doc';
                                    $config['max_size'] = '1000000';
                                    $this->load->library('upload', $config);
                                    $_FILES['file_name']['name']= $files['file_name']['name'][$i];
                                    $_FILES['file_name']['type']= $files['file_name']['type'][$i];
                                    $_FILES['file_name']['tmp_name']= $files['file_name']['tmp_name'][$i];
                                    $_FILES['file_name']['error']= $files['file_name']['error'][$i];
                                    $_FILES['file_name']['size']= $files['file_name']['size'][$i];
                                    if($this->upload->do_upload('file_name')) {
                                        $upload_data = $this->upload->data();
                                        $file_name = 'uploads/purchase_quotes/'.$upload_data['file_name'];
                                        $data=array(
                                            'description'=>$this->input->post('new_description')[$i],
                                            'quote_file'=>$file_name,
                                            'asset_purchase_id'=>$id,
                                            'quote_status'=>'Draft'
                                        );
                                        $response_id=$this->Common_model->insert('asset_purchase_quotes',$data);
                                        if($response_id >0) {  
                                            $what=$this->db->last_query();
                                            logcreator('update', 'database', $who, $what, $response_id, 'asset_purchase','update purchase quotes');
                                            $ajax_response['st']=1;
                                            $ajax_response['msg']='Purchase Quote Details Updated Successfully..!';
                                        } else {  
                                            $ajax_response['st']=0;
                                            $ajax_response['msg']='Something went wrong,Please try again later..!';
                                        }
                                    } else {
                                        //UPLOAD FAILED
                                        $ajax_response['st']=2;
                                        $ajax_response['msg']=$this->upload->display_errors();
                                    }
                                }
                            }
                        }  
                    } else {
                        //failed to update
                        $ajax_response['st']=0;
                        $ajax_response['msg']='Something went wrong,Please try again later..!';
                    }
                }else{
                    $ajax_response['st']=2;
                    $ajax_response['msg']='Already exist!'; 
                    print_r(json_encode($ajax_response));
                    exit(); 
                }
            } else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Invalid file. Please check";
                print_r(json_encode($ajax_response));
                exit(); 
            }
        } else {
            //failed to update
            $ajax_response['st']=0;
            $ajax_response['msg']='Something went wrong,Please try again later..!';
        }
        print_r(json_encode($ajax_response));
    }
    
    public function changeStatus_purchaseQuote()
    {
        if($_POST)
        {   
            
            $quote_id=$this->input->post('quote_id');
            $quote_status=$this->input->post('quote_status');
            $id=$this->input->post('id');
            $response=$this->Common_model->update('asset_purchase_quotes', array("quote_status"=>$quote_status),array("quote_id"=>$quote_id,'asset_purchase_id'=>$id));
           
            if($response)
            {
              $update=$this->Common_model->update('asset_purchase_quotes', array("quote_status"=>"Declined"),array("quote_id!="=>$quote_id,'asset_purchase_id'=>$id)); 
                if($update)
                { if($quote_status == "Approved")
                    {
                        $this->Common_model->update('asset_purchase', array("purchase_status"=>"Quote Approved"),array('id'=>$id)); 
                        $ajax_response['st']=1;   
                        $ajax_response['msg']='Purchase Quotes Approved Successfully';
                    }
                 else
                 {
                     $exist=$this->common->check_if_dataExist("asset_purchase_quotes",array("asset_purchase_id"=>$id,"quote_status"=>"Approved"));
                     if($exist ==0)
                     {
                          $this->Common_model->update('asset_purchase', array("purchase_status"=>"Draft"),array('id'=>$id));  
                     }
                     $ajax_response['st']=1;   
                     $ajax_response['msg']='Purchase Quotes Declined Successfully';
                 }
                    
                  $data=$this->common->get_alldata('asset_purchase_quotes',array('asset_purchase_id'=>$id));
                    if(!empty($data))
                    {
                      $ajax_response['data']=$data;  
                    }
                   
                }
                else
                {
                  $ajax_response['st']=0;   
                  $ajax_response['msg']='Something went wrong..!Please try again later';   
                  
                }
            }
            else
                {
                  $ajax_response['st']=0;   
                  $ajax_response['msg']='Something went wrong..!Please try again later';   
                }
        
        }
        else
                {
                  $ajax_response['st']=0;   
                  $ajax_response['msg']='Something went wrong..!Please try again later';   
                }
        print_r(json_encode($ajax_response));
    }
    
    //delete quote
    public function delete_Quote()
    {
        if($_POST)
        {
             $id=$this->input->post('id');
             $query = $this->Asset_model->delete_delete_Quote($id);
            if($query) {
                $res['st']   = 1;
                $res['message']  = 'Purchase Quote Details deleted successfully';
                $what = $this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('delete', 'database', $who, $what, $id, 'asset_purchase_quotes','Purchase Quote Details Deleted');

        } else {

           $res['st']   = 0;
           $res['message']  = 'Something went wrong.Please try again later..!';

        }
        print_r(json_encode($res));
            
        }
    }
    
    public function load_purchaseQuotes_Ajax()
    {
        $html = '<thead>
                        <tr>
                            <th width="50">'. $this->lang->line('sl_no').'</th>

                            <th>
                                '. $this->lang->line('title').'
                            </th>
                            <th>
                                '. $this->lang->line('status').'
                            </th>
                            
                            <th>
                                '. $this->lang->line('action').'
                            </th>
                        </tr>
                    </thead>';
      $data=$this->common-> get_alldata_orderby('asset_purchase',array('status'=>'1'),'id','DESC');
        if(!empty($data))
         {

            $i=1;
             foreach($data as $rows)
             {
                 
                         
                       
                        if ($rows['purchase_status']=="Draft") {
                                $status= '<span class="inactivestatus">Draft</span>';
                            }
                            else if($rows['purchase_status']=="Quote Approved") {
                                $status= '<span class="admitted">Quote Approved</span>';
                            }
                            else if($rows['purchase_status']== "Completed") { 
                                $status= '<span class="batchchanged">Completed</span>';
                            }
                        
                      
                 $html.='<tr>
                        <td>'.$i.'</td>
                        <td>'.$rows['title'].'</td>
                        <td>'.$status .' </td>
                        <td><button type="button" class="btn btn-default option_btn " onclick="view_data('.$rows['id'].')" title="Click here to view the details">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn" title="Edit" onclick="get_data('.$rows['id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_quote('.$rows['id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a></td>

                        </tr>';
                 $i++;
             }
         }
        echo $html;
        
    }
        
        public function asset_category_add()
        {
            //print_r($_POST);
            if($_POST)
            {
                $category=$this->input->post('category');
                $response=$this->Common_model->insert('assets_category', array("name"=>$category));
                if($response)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['msg']="Asset Category added successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['msg']="Something went wrong,Please try again later..!";   
                }
            }
            print_r(json_encode($ajax_response));
        }
    
    public function check_categoryName()
    {
      //print_r($_POST);  
        if($_POST)
        {
          $category=$this->input->post('category');
            $exist=$this->common->check_if_dataExist('assets_category',array("name"=>$category,"status"=>1));
             if($exist == 0)
        {
            echo "true";
        }
        
        else
        {
            echo "false";
        }
        }
    }
    
    public function get_category_data()
    {
        if($_POST)
        {
          $category_id=$this->input->post('id');
            $asset_category=$this->common->get_from_tablerow('assets_category',array("id"=>$category_id));
            print_r(json_encode($asset_category)); 
        }
    }
    
    public function edit_category()
    {
       if($_POST)
            {
                $name=$this->input->post('name');
                $id=$this->input->post('id');
                $response=$this->Common_model->update('assets_category', array("name"=>$name),array("id"=>$id));
         
                if($response)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['msg']="Asset Category updated successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['msg']="Something went wrong,Please try again later..!";   
                }
            }
            print_r(json_encode($ajax_response)); 
    }
    
    public function delete_category()
    {
      if($_POST)
            {
                $id=$this->input->post('id');
                $response=$this->Common_model->update('assets_category', array("status"=>2),array("id"=>$id));
         $exist=$this->common->check_if_dataExist('assets_asset_data',array("category"=>$id,"status"=>'1'));
          if($exist == 0)
          {
                if($response)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['msg']="Asset Category deleted successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['msg']="Something went wrong,Please try again later..!";   
                }
          }
          else
          {
            $ajax_response['st']=2;  
            $ajax_response['msg']="Data exists under this category..!";   
          }
               print_r(json_encode($ajax_response)); 
            }
    }
    
     public function asset()
    {
        check_backoffice_permission('asset');
        $this->data['page']="admin/asset";
		$this->data['menu']="asset_management";
        $this->data['breadcrumb']="Asset";
        $this->data['menu_item']="Asset";
         $this->data['category']=$this->common->get_alldata_orderby('assets_category',array('status'=>1),'id','desc');
        $this->data['assets']=$this->common->get_alldata_orderby('assets_asset_data',array('status'=>1),'id','desc');
		$this->load->view('admin/layouts/_master',$this->data);
		
    }
    
    public function assets_add()
    {
    
        if($_POST)
        {
          $data['category']=$this->input->post('category');
          $data['total_number']=$this->input->post('total_no');
          $data['item_status']=$this->input->post('status');
          $data['price_per_unit']=$this->input->post('price');
            $exist=$this->common->check_if_dataExist('assets_asset_data',$data);
            if($exist== 0){
                $response=$this->Common_model->insert('assets_asset_data',$data);
                if($response)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['msg']="Assets data added successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['msg']="Something went wrong,Please try again later..!";   
                }
            }
            else
            {
              $ajax_response['st']=2;  
              $ajax_response['msg']="This data already exist!";  
            }
             print_r(json_encode($ajax_response));
        }  
    }
    
     public function delete_assets()
    {
       if($_POST)
            {
                $id=$this->input->post('id');
                $response=$this->Common_model->update('assets_asset_data', array("status"=>2),array("id"=>$id));
         
                if($response)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['msg']="Data deleted successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['msg']="Something went wrong,Please try again later..!";   
                }
               print_r(json_encode($ajax_response)); 
            } 
    }
    
    //ajax load category list
    public function load_category_ajax()
    {
         $html = '<thead><tr>
                <th width="50">'.  $this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('category').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
     $data=$this->common->get_alldata_orderby('assets_category',array('status'=>1),'id','desc');
        if(!empty($data))
        {
            $i=1;
            foreach($data as $rows)
            {
                $html.='<tr>
                       <td>'.$i.'</td>
                       <td>'.$rows['name'].'</td>
                       <td><button class="btn btn-default option_btn " title="Edit" onclick="get_category_data('.  $rows['id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_category('. $rows['id'].')"><i class="fa fa-trash-o"></i>
                    </a></td>
                       </tr>';
                $i++;
            }
        }
        echo $html;
    }
    
    public function get_asset_data()
    {
       if($_POST)
        {
          $id=$this->input->post('id');
            $asset=$this->common->get_from_tablerow('assets_asset_data',array("id"=>$id));
            print_r(json_encode($asset)); 
        } 
    }
    
    public function edit_assets()
    {
      if($_POST)
            {
                
             $data['total_number']=$this->input->post('total_no');
             $data['price_per_unit']=$this->input->post('price');
                $id=$this->input->post('id');
                $response=$this->Common_model->update('assets_asset_data', $data,array("id"=>$id));
         
                if($response)
                {
                  $ajax_response['st']=1;  
                  $ajax_response['msg']="Data updated successfully..!";  
                }
                else
                {
                  $ajax_response['st']=0;  
                  $ajax_response['msg']="Something went wrong,Please try again later..!";   
                }
            }
            print_r(json_encode($ajax_response));   
    }
    
    //ajax load asset list
    public function load_asset_ajax()
    {
         $html = '<thead><tr>
                <th width="50">'.  $this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('category').'</th>
                <th>'.$this->lang->line('total_num').'</th>
                <th>'.$this->lang->line('status').'</th>
                <th>'.$this->lang->line('price_per_unit').' (INR)</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
     $data=$this->common->get_alldata_orderby('assets_asset_data',array('status'=>1),'id','desc');
        if(!empty($data))
        {
            $i=1;
            foreach($data as $rows)
            {
                $category=$this->common->get_name_by_id('assets_category','name',array("id"=>$rows['category']));
                $html.='<tr>
                       <td>'.$i.'</td>
                       <td>'.$category.'</td>
                       <td>'.$rows['total_number'].'</td>
                       <td>'.$rows['item_status'].'</td>
                       <td>'.$rows['price_per_unit'].'</td>
                       <td><button class="btn btn-default option_btn " title="Edit" onclick="get_asset_data('.  $rows['id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_assets('. $rows['id'].')"><i class="fa fa-trash-o"></i>
                    </a></td>
                       </tr>';
                $i++;
            }
        }
        echo $html;
    }
    
    public function check_category_edit()
    {
        if($_POST)
        {
          $category=$this->input->post('category');
          $id=$this->input->post('id');
          $exist=$this->common->check_if_dataExist('assets_category',array("name"=>$category,"status"=>1,"id!="=>$id));
           
             if($exist == 0)
        {
            echo "true";
        }
        
        else
        {
            echo "false";
        }
        } 
    }
    //decline request
    public function decline_request()
    {
       
        if($_POST)
        {
            
            $details=$this->Asset_model->get_maintenance_request_byId($this->input->post('id'));
            $data=array(
                        "service_id"=>$this->input->post('id'),
                        "comments"=>$this->input->post('comments'),
                        "approved_status"=>"Declined",
                        "declined_date"=>date('Y-m-d'),
                        "approved_by"=>$this->session->userdata['user_primary_id'],
                        "approving_authority"=>$this->session->userdata['role']
           );
            $insert_id=$this->Common_model->insert('assets_maintenance_service_details',$data);

                           if($insert_id!="")
                           {
                                $ajax_response['st']=1;
                                $ajax_response['message']="Request Declined Successfully!";
                                $query=$this->db->last_query();
                                $who = $this->session->userdata['user_id'].'/'.$this->session->userdata('role');
                                logcreator('insert', 'database', $who, $query, $insert_id, 'assets_maintenance_service_details');
                           }

                          else
                           {
                              $ajax_response['st']=0;
                              $ajax_response['message']="Something went wrong,Please try again later..!";
                           }
            print_r(json_encode($ajax_response));
        }
    }
}
?>
