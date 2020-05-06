<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends Direction_Controller {

	public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="basic_configuration";
        check_backoffice_permission($module);

    }
//--------------------------------------- Manage Discount -----------------------------------------------//

    public function index(){
        check_backoffice_permission('discount');
		$this->data['page']="admin/discount";
		$this->data['menu']="basic_configuration";
		$this->data['discounts']=$this->Discount_model->get_discount();
        $this->data['breadcrumb']="Discount";
        $this->data['menu_item']="discount";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    
    public function discount_add()
    {
        if($_POST){
            $data = $_POST;
            $discount_exist = $this->Discount_model->is_discount_exist($data);
            if($discount_exist == 0){
                $res = $this->Discount_model->discount_add($data);
                if($res = 1){
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New discount type added', $who, $what, $table_row_id, 'am_discount_master');
                    $discount_array=$this->Discount_model->get_discountdetails_by_id($table_row_id);
                    $html='<li id="row_'.$table_row_id.'">
                            <div class="col sl_no "> '.$table_row_id.' </div>
                                <div class="col " >'.$discount_array['package_name'] .' </div>
                                <div class="col actions ">
                                    <button class="btn btn-default option_btn " title="Edit" onclick="get_discountdata('.$table_row_id.')">
                                        <i class="fa fa-pencil "></i>
                                    </button>
                                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_discount('.$table_row_id.')">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                            <li>';
                }
            }else{
                $html=2; //already exist
            }
            print_r($html);
        }
    }

    public function discount_edit()
    {
        if($_POST){
            $id = $this->input->post('package_master_id');
            unset($_POST['package_master_id']);
            $data = $_POST;
            $res = $this->Discount_model->discount_edit($data, $id);
            if($res=1){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Discount type edited', $who, $what, $id, 'am_discount_master');
            }
            print_r(trim($res));
        }
    }

    public function discount_delete()
    {
        $id  = $_POST['id'];
        $res = $this->Discount_model->discount_delete($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Discount type deleted', $who, $what, $id, 'am_discount_master');
        }
        print_r($res);
    }

    public function get_discount_by_id($package_master_id){
        $discount_array= $this->Discount_model->get_discount_by_id($package_master_id);
        print_r(json_encode($discount_array));
    }

    public function load_discount_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('category').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $discounts = $this->Discount_model->get_discount();
        if(!empty($discounts)) {
            $i=1; 
            foreach($discounts as $discount){ 
                $html .= '<tr id="row_'.$discount['package_master_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="name_'.$discount['package_master_id'].'">
                        '.$discount['package_name'].'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_discountdata('.$discount['package_master_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_discount('.$discount['package_master_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }

//--------------------------------------- Manage Discount Packages -----------------------------------------------//
  
    public function discount_packages(){
        check_backoffice_permission('discount_packages');
        $this->data['page']="admin/discount_packages";
        $this->data['menu']="basic_configuration";
        $this->data['discounts']=$this->Discount_model->get_discount_packages();
        $this->data['discountArr']=$this->common->get_discounts();
        $this->data['breadcrumb']="Discount Packages";
        $this->data['menu_item']="discount-packages";
        $this->load->view('admin/layouts/_master',$this->data); 
    }

    public function discount_packages_add()
    {
        if($_POST){
            $_POST['package_status']=1;
            $data = $_POST;
            $check_array=array(
                        "package_master_id"=>$this->input->post('package_master_id'),
                        "package_type"=>$this->input->post('package_type'),
                        "package_status"=>'1'
            );
            $exist=$this->common->check_if_dataExist('am_discount_packages',$check_array);
           
            if($exist == 0)
            {
                $res = $this->Discount_model->discount_packages_add($data);
                if($res = 1)
                {
                    $what = $this->db->last_query();
                    $table_row_id = $this->db->insert_id();
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'New discount package added', $who, $what, $table_row_id, 'am_discount_packages');
                    $ajax_response['st']=1;
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

    public function discount_packages_edit()
    {
        if($_POST){
            $id = $this->input->post('package_id');
            unset($_POST['package_id']);
            $data = $_POST;
             $_POST['package_status']=1;
          
             $check_array=array(
                        "package_master_id"=>$this->input->post('package_master_id'),
                        "package_type"=>$this->input->post('package_type'),
                        "package_status"=>$this->input->post('package_status'),
				 		"package_id!="=>$id
            );
            $exist=$this->common->check_if_dataExist('am_discount_packages',$check_array);
            //echo $exist;die();
            if($exist >=1)
            {
                $ajax_response['st']=2; 
            }
            else
            {
              $res = $this->Discount_model->discount_packages_edit($data, $id);
              if($res)
               {
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Discount package edited', $who, $what, $id, 'am_discount_packages');
                $ajax_response['st']=1;
               
              }
              else
              {  
                 $ajax_response['st']=0;
              }  
            }
            
            print_r(json_encode($ajax_response));
        }
    }

    public function discount_packages_delete()
    {
        $id  = $_POST['id'];
        $res = $this->Discount_model->discount_packages_delete($id);
        if($res=1){
            $what = $this->db->last_query();
            $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('delete', 'Discount package deleted', $who, $what, $id, 'am_discount_packages');
        }
        print_r($res);
    }

    public function get_discount_packages_by_id($package_id){
        $discount_packages_array= $this->Discount_model->get_discount_packages_by_id($package_id);
        print_r(json_encode($discount_packages_array));
    }

    public function load_discount_packages_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('category').'</th>
                        <th >'.$this->lang->line('package_type').'</th>
                        <th >'.$this->lang->line('discount').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $discounts = $this->Discount_model->get_discount_packages();
        if(!empty($discounts)) {
            $i=1; 
            foreach($discounts as $discount){ 
                if($discount['package_type']==1){ 
                    $amount = numberformat($discount['package_amount']);
                }else{ 
                    $amount = $discount['package_amount'].'%';
                }
                if($discount['package_type']==1){ 
                    $type = "Absolute";
                }else{ 
                    $type = "Percentage";
                }
                $html .= '<tr id="row_'.$discount['package_id'].'">
                    <td>
                        '.$i.'
                    </td>
                    <td id="name_'.$discount['package_id'].'">
                        '.$discount['package_name'].'
                    </td>
                    <td id="type_'.$discount['package_id'].'">
                        '.$type.'
                    </td>
                    <td id="discount_'.$discount['package_id'].'">
                        '.$amount.'
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_discount_packagesdata('.$discount['package_id'].')">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_discount_packages('.$discount['package_id'].')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    
    public function payment_heads()
    {
       check_backoffice_permission('payment_heads');
		$this->data['page']="admin/payment_heads";
		$this->data['menu']="basic_configuration";
		$this->data['dataArr']=$this->common->get_alldata_orderby('am_fee_heads',array("status!=","2"), 'ph_id', 'dsec');
        $this->data['breadcrumb']="Payment Heads";
        $this->data['menu_item']="payment_head";
		$this->load->view('admin/layouts/_master',$this->data);   
    }
    
    public function check_category_name()
    {
        if($_POST)
        {
            $name=$this->input->post('discount_name');
            $exist=$this->common->check_if_dataExist('am_discount_master',array('package_name'=>$name,'status'=>'1'));
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
    
    public function check_category_name_edit()
    {
      if($_POST)
        {
            $name=$this->input->post('discount_name');
            $exist=$this->common->check_if_dataExist('am_discount_master',array('package_name'=>$name,'status'=>'1'));
        //  echo $exist;
            if($exist <= 1)
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
        }  
    }
    public function fee_defnition(){
        check_backoffice_permission('fee_defnition');
		$this->data['page']="admin/fee_defnition";
		$this->data['menu']="basic_configuration";
		$this->data['feeDeff']=$this->Discount_model->get_feeDeff();
        $this->data['breadcrumb']="Fee Definition";
        $this->data['menu_item']="fee-defnition";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    public function get_payment_head(){
        $counter = $_POST['counter'];
        $html ="";
        $paymentHead = $this->Discount_model->get_payment_head();
        $html .='<select class="form-control stopname" name="payment_head['.$counter.']" id="payment_head'.$counter.'">
                    <option value="">Select</option>';
        if(!empty($paymentHead)){
            foreach($paymentHead as $Head){
                $html .= '<option value="'.$Head->ph_id.'" >'.$Head->ph_head_name.'</option>';
              }
        }
        $html .='</select>';
        echo $html;
    }
    public function fee_def_add(){
        if($_POST)
        {
            $data['fee_definition']        = $this->input->post('title');
            $data['fee_type']               = $this->input->post('type');
            $fee_def_id              = $this->Discount_model->insert_fee_def($data);
            if($fee_def_id){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New fee definition added', $who, $what, $fee_def_id, 'am_fee_definition');
            }
            if ($fee_def_id) {
                $paymentHeadArr     = $this->input->post('payment_head');
                $fee_def_idArr      = $fee_def_id;
                $stopArr            = array();
                if (!empty($paymentHeadArr)) {
                    foreach ($paymentHeadArr as $key => $val) {
                        if (!empty($paymentHeadArr[$key])) {
                            $tempArr = array(
                                'fee_definition_id' => $fee_def_idArr,
                                'fee_head_id' => $paymentHeadArr[$key]
                            );
                            array_push($stopArr, $tempArr);
                        }
                    }
                }
                if (!empty($stopArr)) {
                    $f = 1;
                    foreach($stopArr as  $key=>$row){
                        $response = $this->Discount_model->insert_fee_def_details($row);
                        if($response == false){
                            $f = 0;
                        }else{
                            $what=$this->db->last_query();
                            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                            logcreator('insert', 'Fee definition details added', $who, $what, $response, 'am_fee_definition_details');
                        }
                    }
                    if($f == 1){
                        $ajax_response['st']=1;
                        $ajax_response['msg']="Successfully added data";
                    }
                }
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
    public function load_fee_def_ajax() {
        $html = '<thead> 
                   <tr>
                        <th width="10%">'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('title').'</th>
                        <th >'.$this->lang->line('type').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th width="15%">'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
                $feeDeff = $this->Discount_model->get_feeDeff();
        if(!empty($feeDeff)) {
            $i=1; 
            foreach($feeDeff as $data){
                $html .= '<tr>
                    <td>
                        '.$i.'
                    </td>
                    <td>
                        '.$data->fee_definition.'
                    </td>
                    <td>
                    '.$data->fee_type.'
                </td>
                    <td>';
                    if($data->fee_definition_status == 1) {
                        $html .= '<span class="btn mybutton  mybuttonActive" onclick="statusChange('.$data->fee_definition_id.','.$data->fee_definition_status.')">Active</span>';
                    }else if($data->fee_definition_status == 0){
                        $html .= '<span class="btn mybutton mybuttonInactive" onclick="statusChange('.$data->fee_definition_id.','.$data->fee_definition_status.')">Inactive</span>'; 
                    }
                    $html .= '</td>
                    <td width="15%">
                        <button  type="button" class="btn btn-default option_btn " onclick="view_feedef('.$data->fee_definition_id.')" title="Click here to view the details" data-toggle="modal" data-target="#view_fee" style="color:blue;cursor:pointer;">
                        <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="edit_feedef('.$data->fee_definition_id.')">
                            <i class="fa fa-pencil "></i>
                        </button>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    public function titleCheck()
    {
        $title=$this->input->post('title');
        $query= $this->db->get_where('am_fee_definition',array("fee_definition"=>$title,'fee_definition_status'=> '1'));
        if($query->num_rows()>0)
        {
           echo 'false';
        }
        else
        {
            echo 'true';
        }
    }
    public function edit_fee_status()
    {
// print_r($_POST);
        $id = $this->input->post('id');
        $status = $this->input->post('st');
        $res = $this->Discount_model->change_fee_status($id, $status);
        if($res == 1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'Fee definition status changed', $who, $what, $id, 'am_fee_definition');
        }
        print_r($res);
    }
    public function get_feedef_by_id_old($id){
        $html ='';
        $result1 = "";
        $counter = 1;
        $feedef = $this->Discount_model->get_feedef_id($id); 
        $details = $this->Discount_model->get_details_id($id);
        // print_r($details);
        foreach($details as $dt){
            $result1 = "";
            $paymentHead = $this->Discount_model->get_payment_head();
            $result1 .='<select class="form-control stopname" name="payment_head['.$counter.']" id="payment_head'.$counter.'">
                        <option value="">Select</option>';
            if(!empty($paymentHead)){
                foreach($paymentHead as $Head){
                    $result1 .= '<option value="'.$Head->ph_id.'"';
                    if($Head->ph_id == $dt->fee_head_id){ $result1 .= 'selected'; }
                    $result1 .= '>'.$Head->ph_head_name.'</option>';
                  }
            }
            $result1 .='</select>';
            $html .='<tr id="stop_tr_'.$counter.'" class="tr"><td data-title="Stop Name">'.$result1.'</td>';
            $html .='<td data-title=""><input type="hidden" id="id'.$counter.'" name="id'.$counter.'"value="'.$dt->fee_definition_details_id.'">';
            $html .='<a href="javascript:void(0)" class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs valid" id="'.$counter.'" onclick="deletefunction(this.id);  edit_removeTextbox('.$counter.');" title="Click here to remove fee definition" ><i class="fa fa-remove"></i></a></td>';
            $html .='</tr>';
            $counter++;
        }
        $feedef['html'] = $html;
        $feedef['counter'] = $counter;
        print_r(json_encode($feedef));
    }

    public function get_feedef_by_id()
    {
      
       if($_POST)
       {
          $id=$this->input->post('edit_id');
          
          $fee_defenition_name=$this->common->get_name_by_id('am_fee_definition','fee_definition',array("fee_definition_id"=>$id));
          $fee_type=$this->common->get_name_by_id('am_fee_definition','fee_type',array("fee_definition_id"=>$id));
          $details = $this->Discount_model->get_details_id($id);
         // print_r($details);
         $data=array();
         $counter=1;
        
         $html="";
          foreach($details as $row)
          {
            $select="";
            $paymentHead = $this->Discount_model->get_payment_head();
            $select .='<select class="form-control stopname" name="payment_head['.$counter.']" id="payment_head'.$counter.'">
                        <option value="">Select</option>';
               if(!empty($paymentHead)){
                foreach($paymentHead as $Head){
                    $select .= '<option value="'.$Head->ph_id.'"';
                    if($Head->ph_id == $row['fee_head_id'])
                    { $select .= 'selected'; }
                    $select .= '>'.$Head->ph_head_name.'</option>';
                  }
                }
             $select .='</select>';
             $html.='<tr id="fee_def_'.$counter.'">
                    <td class="tr">'. $select.'<input type="hidden" value="'.$row['fee_definition_details_id'].'"/></td>
                    <td><a class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs valid" id="'.$counter.'" onclick="deletefunction('.$row['fee_definition_details_id'].','.$counter.');" title="Click here to remove fee definition" ><i class="fa fa-remove"></i></a>
                    </td>
                    </tr>';
                    $counter++;
          }
         
          $data['name']=$fee_defenition_name;
          $data['type']=$fee_type;
          $data['html']=$html;
          print_r(json_encode($data));
       } 
    }

    public function delete_fee_sub_defenition()
    {
        print_r($_POST);
    }

    public function fee_def_edit(){
        if($_POST)
        {
            $id = $this->input->post('edit_fee_id');
            $data['fee_definition']        = $this->input->post('title');
            $data['fee_type']               = $this->input->post('type');
            // $fee_def_id              = $this->Discount_model->insert_fee_def($data);
            $response =$this->Common_model->update('am_fee_definition', $data ,array('fee_definition_id'=>$id));
            if($response){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Fee definition edited', $who, $what, $response, 'am_fee_definition');
                if ($id) {
                    $res = $this->Discount_model->fee_details_delete($id);
                    if($res){
                        $paymentHeadArr     = $this->input->post('payment_head');
                        $idArr      = $id;
                        $stopArr            = array();
                        if (!empty($paymentHeadArr)) {
                            foreach ($paymentHeadArr as $key => $val) {
                                if (!empty($paymentHeadArr[$key])) {
                                    $tempArr = array(
                                        'fee_definition_id' => $idArr,
                                        'fee_head_id' => $paymentHeadArr[$key]
                                    );
                                    array_push($stopArr, $tempArr);
                                }
                            }
                        }
                        if (!empty($stopArr)) {
                            $f = 1;
                            foreach($stopArr as  $key=>$row){
                                $response = $this->Discount_model->insert_fee_def_details($row);
                                if($response == false){
                                    $f = 0;
                                }else{
                                    $what=$this->db->last_query();
                                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                                    logcreator('insert', 'Fee definition detailed edited', $who, $what, $response, 'am_fee_definition_details');
                                }
                            }
                            if($f == 1){
                                $ajax_response['st']=1;
                                $ajax_response['msg']="Successfully updated data";
                            }
                        }
                    }else{
                        $ajax_response['st']=0;
                        $ajax_response['msg']="Something went wrong,Please try again later..1!";
                    }
                }else{
                    $ajax_response['st']=0;
                    $ajax_response['msg']="Something went wrong,Please try again later..2!";
                }
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..3!";
            }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..4!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function view_feedef_by_id()
    {
        if($_POST){
            $id=$this->input->post('id');
            $fee_defenition_name=$this->common->get_name_by_id('am_fee_definition','fee_definition',array("fee_definition_id"=>$id));
            $fee_type=$this->common->get_name_by_id('am_fee_definition','fee_type',array("fee_definition_id"=>$id));
            $details = $this->Discount_model->get_details_id($id);
            $data=array();
            $html="";
            foreach($details as $row){
                $select="";
                $paymentHead = $this->Discount_model->get_payment_head();
                if(!empty($paymentHead)){
                    foreach($paymentHead as $Head){
                        if($Head->ph_id == $row['fee_head_id'])
                        { $select = $Head->ph_head_name; }
                    }
                }
                $html.='<tr>
                       <td class="tr">'. $select.'</td>
                       </tr>';
            }
            $data['name']=$fee_defenition_name;
            $data['type']=$fee_type;
            $data['html']=$html;
            print_r(json_encode($data));
       } 
    }
    // ------------------------------- Fee Head .................................................... 
    public function fee_head(){
        check_backoffice_permission('fee_head');
		$this->data['page']="admin/fee_head";
		$this->data['menu']="basic_configuration";
		$this->data['fee_head']=$this->Discount_model->get_feeHead();
        $this->data['breadcrumb']="Fee Head";
        $this->data['menu_item']="fee-head";
		$this->load->view('admin/layouts/_master',$this->data); 
    }
    public function check_fee_head_name()
    {
        if($_POST)
        {
            $name=$this->input->post('head_name');
            $exist=$this->common->check_if_dataExist('am_payment_heads',array('ph_head_name'=>$name,'ph_status'=>'1'));
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
    public function fee_head_add()
    {
        if($_POST)
        {
            
            $data['ph_head_name']   = $this->input->post('fee_head');
            $query = $this->common->get_from_tablerow('am_payment_heads', array('ph_head_name'=>$data['ph_head_name']));
            if(empty($query)) {
			if($this->input->post('refund')) {
			$data['ph_refund']   	= $this->input->post('refund');
			} else {
			$data['ph_refund']   	= 0;	
			}
			if($this->input->post('taxable')) {
			$data['ph_taxable']   	= $this->input->post('taxable');
			} else {
			$data['ph_taxable']   	= 0;	
			}
            $response               = $this->Discount_model->insert_fee_head($data);
            if($response){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'New fee head created', $who, $what, $response, 'am_payment_heads');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully added data";
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        } else {
            $ajax_response['st']=0;
                $ajax_response['msg']="Fee head already exists.";
        }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function load_fe_head_ajax() {
        $html = '<thead> 
                   <tr>
                        <th>'.$this->lang->line('sl_no').'</th>
                        <th >'.$this->lang->line('fee_head').'</th>
						<th >'.$this->lang->line('refund').'</th>
                        <th >'.$this->lang->line('status').'</th>
                        <th >'.$this->lang->line('action').'</th>
                    </tr>
                </thead>';
        $fee_head = $this->Discount_model->get_feeHead();
        if(!empty($fee_head)) {
            $i=1; 
            foreach($fee_head as $head){ 
				if($head->ph_refund==1) {
					$ph_refund = 'Yes';
				} else {
					$ph_refund = 'No';
				}
				if($head->ph_taxable==1) {
					$ph_taxable = 'Yes';
				} else {
					$ph_taxable = 'No';
				}
                $html .= '<tr>
                    <td>
                        '.$i.'
                    </td>
                    <td>
                        '.$head->ph_head_name.'
                    </td>
					<td>
                        '.$ph_refund.'
                    </td>
                    <td>';
                        if($head->ph_status == 1) {
                            $html .= '<span class="btn mybutton  mybuttonActive" onclick="statusChange('.$head->ph_id.','.$head->ph_status.')">Active</span>';
                        }else if($head->ph_status == 0){
                            $html .= '<span class="btn mybutton mybuttonInactive" onclick="statusChange('.$head->ph_id.','.$head->ph_status.')">Inactive</span>';
                        }
                $html .= '</td>
                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_feeHeaddata('.$head->ph_id.')">
                            <i class="fa fa-pencil "></i>
                        </button>
                    </td>
                </tr>';
            $i++; 
            }
        }
        echo $html;
    }
    public function get_fee_head_by_id($id){
        $fee_head_array= $this->Discount_model->get_fee_head_by_id($id);
        print_r(json_encode($fee_head_array));
    }
    public function check_fee_head_name_edit(){
      if($_POST)
        {
            $name=$this->input->post('head_name');
            $exist=$this->common->check_if_dataExist('am_payment_heads',array('ph_head_name'=>$name,'ph_status'=>'1'));
            if($exist <= 1)
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
        }  
    }
    public function fee_head_edit(){
        if($_POST)
        {
            $data['ph_head_name']   = $this->input->post('fee_head');
			if($this->input->post('refund')) {
			$data['ph_refund']   	= $this->input->post('refund');
			} else {
			$data['ph_refund']   	= 0;	
			}
			if($this->input->post('taxable')) {
			$data['ph_taxable']   	= $this->input->post('taxable');
			} else {
			$data['ph_taxable']   	= 0;	
			}
            $id = $this->input->post('ph_id');
            $query = $this->common->get_from_tablerow('am_payment_heads', array('ph_head_name'=>$data['ph_head_name'],'ph_id!='=>$id));
            if(empty($query)) {
            $response               = $this->Discount_model->update_fee_head($data, $id);
            if($response){
                $what=$this->db->last_query();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('update', 'Fee head edited', $who, $what, $response, 'am_payment_heads');
                $ajax_response['st']=1;
                $ajax_response['msg']="Successfully updated data";
            }else{
                $ajax_response['st']=0;
                $ajax_response['msg']="Something went wrong,Please try again later..!";
            }
        } else {
                $ajax_response['st']=0;
                $ajax_response['msg']="Fee head already exists";
        }
        }else{
            $ajax_response['st']=0;
            $ajax_response['msg']="Something went wrong,Please try again later..!";
        }
        print_r(json_encode( $ajax_response));
    }
    public function edit_fee_head_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('st');
        $res = $this->Discount_model->change_fee_head_status($id, $status);
        if($res == 1){
            $what=$this->db->last_query();
            $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
            logcreator('update', 'Fee head status changed', $who, $what, $id, 'am_payment_heads');
        }
        print_r($res);
    }
}
?>
