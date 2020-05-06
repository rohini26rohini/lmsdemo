<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holidays extends Direction_Controller {

   public function __construct() {
        parent::__construct();
        $this->lang->load('information','english');
        $module="basic_configuration";
        check_backoffice_permission();
    }

     public function index(){
     check_backoffice_permission('manage_holidays');
        $this->data['page']           ="admin/holidays";
		$this->data['menu']           ="basic_configuration";
        $this->data['holidayArr']       = $this->Holiday_model->get_allholidays();
        $this->data['breadcrumb']     ="Holidays";
        $this->data['menu_item']      ="manage-holidays";
		$this->load->view('admin/layouts/_master',$this->data);
    }

    //add holiday
    public function add_holiday()
    {
        //print_r($_POST);
          if($_POST)
          {
              $data['date']=date("Y-m-d",strtotime($this->input->post('date')));
              $data['description']=$this->input->post('description');
              $ajax_response['st']=$this->Holiday_model->add_holiday($data);


            if($ajax_response['st'] == 1)
            {
                 $what=$this->db->last_query();
                 $table_row_id=$this->db->insert_id();
                 $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                 $ajax_response['message']="Holiday Added Successfully";
               logcreator('insert', 'New holiday added', $who, $what, $table_row_id, 'am_holidays','holiday added');
            }
            else if($ajax_response['st'] == 2)
            {
                $ajax_response['message']="This date is already assigned as a holiday";
            }
            else if($ajax_response['st'] == 0)
            {
                $ajax_response['message']="Invalid Request";
            }
            print_r(json_encode($ajax_response));
        }
    }

    //get holidaya data by id
    public function get_holidaydata_byId()
    {
      if($_POST){
            $id =    $this->input->post('id');
            $ajax_data['data'] =  $this->common->get_from_tablerow('am_holidays',array('id'=>$id));
         $ajax_data['data']['date']= date("d-m-Y",strtotime($ajax_data['data']['date']));
            print_r(json_encode($ajax_data));
        }
    }

    //edit holiday
    public function edit_holiday()
    {
        //print_r($_POST); die();
        $id  =   $this->input->post('id');
        unset($_POST['id']);

        $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
        if($_POST){
            $data['date']=date("Y-m-d",strtotime($this->input->post('date')));
            $data['description']=$this->input->post('description');
            $response=$this->Holiday_model->edit_holiday($id,$data);
            $what= $this->db->last_query();
            if($response == 1)
            {
              logcreator('Edit', 'Holiday edited', $who, $what, $id, 'am_holidays','updated holiday details');
              $ajax_response['st']=1;
              $ajax_response['message']="Successfully Updated Holiday Details";
            }
            else if($response == 2)
            {
               $ajax_response['st']=2;
              $ajax_response['message']="This day is already assigned as a holiday";
            }
            else
            {
               $ajax_response['st']=0;
              $ajax_response['message']="Invalid Request";
            }


            print_r(json_encode($ajax_response));
        }
    }

    //delete holidays
    public function delete_holidaydata()
    {
        $id      = $this->input->post('id');

                    $what = '';
                    $who = $this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    if($id!= '') {
                        $query = $this->Holiday_model->delete_holidaydata($id);
                        $res['status']   = true;
                        $res['message']  = 'Holiday deleted successfully';
                        $what =$this->db->last_query();

                        logcreator('delete', 'Holiday deleted', $who, $what, $id, 'am_holidays','Holiday deleted');
                    }
               else {

                       $res['status']   = false;
                       $res['message']  = 'Invalid data';
                       logcreator('insert', 'Holiday deletion failed', $who, $what, $id, 'am_holidays','Error while deleting holiday');
                    }
                    print_r(json_encode($res));
    }
    
    //ajax load holiday list
    public function load_holidayList_ajax()
    {
         $html = '<thead><tr>
                <th width="50">'.  $this->lang->line('sl_no').'</th>
                <th>'.$this->lang->line('date').'</th>
                <th>'.$this->lang->line('description').'</th>
                <th>'.$this->lang->line('action').'</th>
                </tr></thead>';
        $data = $this->Holiday_model->get_allholidays();
        if(!empty($data))
        {
            $i=1;
            foreach($data as $rows)
            {
                $html.='<tr>
                       <td>'.$i.'</td>
                       <td>'.date('d/m/Y',strtotime($rows['date'])).'</td>
                       <td>'.$rows['description'].'</td>
                       <td><button class="btn btn-default option_btn "  title="Edit" onclick="get_holidaydata('.  $rows['id'].')">
                     <i class="fa fa-pencil "></i></button><a class="btn btn-default option_btn" title="Delete" onclick="delete_holidaydata('. $rows['id'].')"><i class="fa fa-trash-o"></i>
                    </a></td>
                       </tr>';
                $i++;
            }
        }
        echo $html;
    }
}
?>
