<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commoncontroller extends Direction_controller {

	public function __construct() {
        parent::__construct();
         $this->lang->load('information','english');
        // $this->load->model('encryption');
        // ini_set('memory_limit', '128M');
        $date = date('Y-m-d');
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');
        $this->data['cntremaindercalls'] = count($this->call_center_model->get_remainder_calls($date, $user_id, $role));

    }

    
/*
*   function'll get batch details of student
*   @params student id, barch id
*   @author GBS-R
*
*/
    
public function get_student_batch_details() {
  
  $student_id = $this->input->post('student_id');
    if($student_id!='') {
        $this->data['batchdet'] = $this->student_model->get_student_batch_details($student_id);
        $result= $this->data['batchdet'];
       // print_r( $this->data['batchdet']);
        $this->data['sunday']=$this->common->get_class_session_byday($result->batch_id,'Sun');
        $this->data['monday']=$this->common->get_class_session_byday($result->batch_id,'Mon');
        $this->data['tuesday']=$this->common->get_class_session_byday($result->batch_id,'Tue');
        $this->data['wednesday']=$this->common->get_class_session_byday($result->batch_id,'Wed');
        $this->data['thursday']=$this->common->get_class_session_byday($result->batch_id,'Thu');
        $this->data['friday']=$this->common->get_class_session_byday($result->batch_id,'Fri');
        $this->data['saturday']=$this->common->get_class_session_byday($result->batch_id,'Sat');
        $view =  $this->load->view('admin/student_batch_details',$this->data, TRUE);
        echo $view;
    }  
} 
    
/*
*   function'll get payment details of student
*   @params student id, barch id
*   @author GBS-R
*
*/
    
public function get_student_payment_details() {
  $student_id = $this->input->post('student_id');
    if($student_id!='') {
        $this->data['paymentdet'] = $this->student_model->get_student_payment_details($student_id); //print_r($this->data['paymentdet']);
        $view =  $this->load->view('admin/student_payment_details',$this->data, TRUE);
        echo $view;
    }  
}
    
/*
*   function'll get course details of student
*   @params student id, barch id
*   @author GBS-R
*
*/
    
public function get_student_course_details() {
    $student_id = $this->input->post('student_id');
    if($student_id!='') {
        $this->data['coursedet'] = $this->student_model->get_student_course_details($student_id); 
       // echo "<pre>";print_r($this->data['coursedet']);
        //$main_subject_Arr=$this->student_model->get_course_subject_details($this->data['coursedet']->course_id);
        $this->data['course_syllabusdet'] =  $this->common->get_course_syllabus_details($this->data['coursedet']->course_id); 
        // echo "<pre>";print_r($main_subject_Arr);
//        foreach($main_subject_Arr as $key=>$row)
//        {
//            if(!empty($row['parent_subject_master_id']))
//            {
//                
//          $module_array=$this->subject_model->get_modules_by_subjectCourseid($this->data['coursedet']->course_id,$row['parent_subject_master_id']); 
//                
//           $main_subject_Arr[$key]['module_array']=$module_array;
//            // echo "<pre>";print_r($main_subject_Arr);
//            }
//            else
//            {
//               $main_subject_Arr[$key]['module_array']=array(); 
//            }
//        }
       //$this->data['main_subject_Arr']=$main_subject_Arr; 
       // echo $this->db->last_query();
        $view =  $this->load->view('admin/student_course_details',$this->data, TRUE);
        echo $view;
    }  
} 
    

/*
*   function'll change the password
*   @params old password,user_id
*   @author GBS-L
*
*/

    public function change_password()
    {
        $this->data['page']="admin/change_password";
		$this->data['menu']="employee";
        $this->data['breadcrumb']="Change Password";
        $this->data['menu_item']="backoffice/change-password";
		$this->load->view('admin/layouts/_master',$this->data);
    }

    /*check old passsword is correct or not
     @params old old password
 *    @author GBS-L
 */
    public function check_password()
    {
        if($_POST)
        {
            $old_password=$this->input->post('old');

            $user_id=$this->session->userdata['user_primary_id'];
            $password_hash=$this->common->get_name_by_id('am_users_backoffice','user_passwordhash',array('user_id'=>$user_id));
           // if(strcmp($old_password,$this->encryption->decrypt($password_hash)))
            if(strcmp($old_password,$this->Auth_model->get_pass($password_hash)))
            {
                echo 'false';
            }
            else
            {
                echo 'true';
            }

        }
    }

   // change passsword
    public function password_change()
    {
        if($_POST)
        {
            $new_password=$this->input->post('new');
            $user_id=$this->session->userdata['user_primary_id'];
            //$password_hash= $this->encryption->encrypt($new_password);
            $password_hash= $this->Auth_model->get_hash($new_password);
            $response=$this->Common_model->update('am_users_backoffice', array('user_passwordhash'=>$password_hash),array('user_id'=>$user_id));
            if($response)
            {
                $ajax_response['st']=1;
                $ajax_response['message']="Successfully Changed Password";
                $role=$this->session->userdata['role'];
                if($role == 'admin') { 
                 $who= 0;
                } else {
                    $who=$this->session->userdata['user_id'];   
                }
                 $what=$this->db->last_query();
                 logcreator('update', 'Password changed', $who, $what, $user_id, 'am_users_backoffice','Channged Password');
            }
            else
            {
                $ajax_response['st']=0;
                $ajax_response['message']="Something went wrong.Plase try again later..!";
            }
            print_r(json_encode($ajax_response));
        }
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

    public function get_all_exams()
    {
        $selected = $_POST['selected'];
        $school_id  = $this->input->post('school_id');
        $exams   = $this->Batch_model->get_all_exams($school_id);
        echo '<option value="">Select Exam</option>';
        foreach($exams as $row){ 
                echo '<option value="'.$row['notification_id'].'" >'.$row['name'].'</option>';
        }
    }

    public function edit_get_all_exams()
    {
        // echo "arabijmijnijnji";
        $selected = $_POST['selected'];
        // echo $selected;
        $edit_school_id  = $this->input->post('edit_school_id');
        $exams   = $this->Batch_model->get_all_exams($edit_school_id);

        // echo '<option value="">Select Exam</option>';
        foreach($exams as $row){ 

            if($row['notification_id']==$selected){
                echo '<option value="'.$row['notification_id'].'" >'.$row['name'].'</option>';
            }else{
                
            }
        }
    }

 public function get_all_center_details()
    {
        // $result['html'] = '';
        $result['st'] = 1;
        $batchdet = '';
        $course_id  = $this->input->post('course_id');
        $branch_id  = $this->input->post('branch_id');
        $center_id  = $this->input->post('center_id');
        $centermapp = $this->Batch_model->get_course_centermapp($course_id, $branch_id, $center_id); 
        // show($centermapp);
	 	$config		= $this->home_model->get_config();
        if(!empty($centermapp)) {
            foreach($centermapp as $coursemap) { //print_r($coursemap);
            $batches = $this->Batch_model->get_all_batches($coursemap->institute_course_mapping_id);
            if(!empty($batches)) {
                // $result['st'] = 1;
                $batchdet .= '<h6>'.$coursemap->institute_name.'</h6><hr>';
                foreach($batches as $batch) {
					$feeheads		= $this->common->get_feedsmapping($batch->institute_course_mapping_id); 
                    $coursedet 		= $this->common->get_course_syllabus_details($course_id); 
                    $studentbatch 	= $this->common->get_total_student($batch->batch_id);
                    $availableseats = $batch->batch_capacity-$studentbatch;
                    $percentage 	= $studentbatch*100;
                    $percentage 	= $percentage/$batch->batch_capacity;
                    
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
                                                    <div class="progress-bar" style="width:'.$percentage.'%">'.number_format($percentage,2).'%</div>

                                                    <span>'.$studentbatch.'/'.$batch->batch_capacity.'</span>
                                                </div>
                                                <p><b>Available Seats:</b>&nbsp;'.$availableseats.'</p>
                                                <p><b>Fees:</b></p>
                                                <div class="table-responsive table_language">
                                                <table class="table  table-bordered table-striped text-center table-sm">';
												$addedFees = 0;
												if(!empty($feeheads)) {
													foreach($feeheads as $feehead) {
													$addedFees += $feehead->fee_amount;		
													$batchdet .= '<tr>
																	<th class="text-right">'.$feehead->ph_head_name.'</th>
																	<td class="text-right">'.numberformat($feehead->fee_amount).'</td>
																</tr>';
													}
												}
														$course_cgst = 0;
                                                        $course_sgst = 0;
                                                        $course_cess = 0;
                                                        $course_totalfee = 0;
                                                        $cess = 0;
                                                        if($coursemap->cess>0){
                                                            $cess = 1;
                                                        }
													if(!empty($config)) {
														$taxableAmt = taxcalculation($addedFees, array('SGST'=>$coursemap->sgst,'CGST'=>$coursemap->cgst,'cess'=>$cess,'cess_value'=>$coursemap->cess), 0); 
														$course_cgst = $taxableAmt['cgst'];
                                                        $course_sgst = $taxableAmt['sgst'];
                                                        $course_cess = $taxableAmt['cess'];
														$course_totalfee = $taxableAmt['totalAmt'];
													}
                                                    
                                                    $batchdet .= '<tr>
                                                        <th class="text-right">SGST</th>
                                                        <td class="text-right">'.numberformat($course_sgst).'</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right">CGST</th>
                                                        <td class="text-right">'.numberformat($course_cgst).'</td>
                                                    </tr>';
                                                    if($cess==1) {
                                                    $batchdet .= '<tr>
                                                        <th class="text-right">Cess ['.$coursemap->cess.'%]</th>
                                                        <td class="text-right">'.numberformat($course_cess).'</td>
                                                    </tr>';
                                                    }
                                                    $batchdet .= '<tr>
                                                        <th class="text-right">Total</th>
                                                        <td class="text-right">'.numberformat($course_totalfee).'</td>
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
    
    

    public function data_migration()
    {
        check_backoffice_permission('data_migration');
        $this->data['page']="admin/data_migration";
        $this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Student Migration";
        $this->data['menu_item']="backoffice/data-migration";
        // $this->data['leavetypeArr']=$this->leave_model->get_leave_type();
        $this->data['courseArr']=$this->call_center_model->getall_list();
        $this->data['batchArr']=$this->register_model->get_batch_by_insticourse_id($this->session->userdata('branch_institute_id'));

        $this->load->view('admin/layouts/_master',$this->data); 
    }

    function excel_uploads(){
        if($_POST){
            $course_id=$_POST['course_id'];
            $branch_id=$_POST['branch_id'];
            $center_id=$_POST['center_id'];
            $batch_id=$_POST['batch_id'];
            $res=2;
            $html = '';
            $row_error = '';
            $config['upload_path']   = FCPATH . 'uploads/';
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size']      = '5000';
            $file_name               = $_FILES['question']['name']; //uploded file name
            $allowed                 = explode('|', $config['allowed_types']);
            $ext                     = pathinfo($file_name, PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["question"]["tmp_name"], '././uploads/' . $file_name);
            $this->load->library('upload', $config);
            $this->load->library('excel');
            $spreadsheet = $this->excel->load($config['upload_path'].$file_name);
            $worksheet = $spreadsheet->getActiveSheet();
            $sheetdata = [];
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    if(!empty(trim($cell->getValue()))){
                        array_push($cells,$cell->getValue());
                    }
                }
                if(!empty($cells)){
                    array_push($sheetdata,$cells);
                }else{
                    break;
                }
            }
            // show($sheetdata);
            $highestRow = count($sheetdata);
            //  Get worksheet dimensions
            $sheet = $spreadsheet->getSheet(0); 
            // $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn(); 
            $highestColumn = get_excel_column_number($highestColumn);
            $studentArr = [];
            $qualificationArr1 = [];
            $qualificationArr2 = [];
            $qualificationArr3 = [];
            $qualificationArr4 = [];
            $mapArr = [];
            $payments = [];
            $installments = [];
            for ($i = 2; $i <= $highestRow; $i++){
                $msg = '';
                $instments = [];
                $student_name               = $sheet->getCellByColumnAndRow(1, $i)->getValue();  
                $gender                     = $sheet->getCellByColumnAndRow(2, $i)->getValue();
                $address                    = $sheet->getCellByColumnAndRow(3, $i)->getValue();
                $street_name                = $sheet->getCellByColumnAndRow(4, $i)->getValue();
                $state                      = $sheet->getCellByColumnAndRow(5, $i)->getValue();
                $district                   = $sheet->getCellByColumnAndRow(6, $i)->getValue();
                $email                      = $sheet->getCellByColumnAndRow(7, $i)->getValue();
                $contact_number             = $sheet->getCellByColumnAndRow(8, $i)->getValue();
                $whatsapp_number            = $sheet->getCellByColumnAndRow(9, $i)->getValue();
                $mobile_number              = $sheet->getCellByColumnAndRow(10, $i)->getValue();
                $blood_group                = $sheet->getCellByColumnAndRow(11, $i)->getValue();
                $date_of_birth              = convert_excel_date($sheet->getCellByColumnAndRow(12, $i)->getValue());
                $name_of_guardian           = $sheet->getCellByColumnAndRow(13, $i)->getValue();
                $guardian_contact_number    = $sheet->getCellByColumnAndRow(14, $i)->getValue();
                $sslc                       = $sheet->getCellByColumnAndRow(15, $i)->getValue();
                $percentage_sslc            = $sheet->getCellByColumnAndRow(16, $i)->getValue();
                $plus_two                   = $sheet->getCellByColumnAndRow(17, $i)->getValue();
                $percentage_plus_two        = $sheet->getCellByColumnAndRow(18, $i)->getValue();
                $degree                     = $sheet->getCellByColumnAndRow(19, $i)->getValue();
                $percentage_degree          = $sheet->getCellByColumnAndRow(20, $i)->getValue();
                $pg                         = $sheet->getCellByColumnAndRow(21, $i)->getValue();
                $percentage_pg              = $sheet->getCellByColumnAndRow(22, $i)->getValue();
                $hostel                     = $sheet->getCellByColumnAndRow(23, $i)->getValue();
                $stayed_in_hostel           = $sheet->getCellByColumnAndRow(24, $i)->getValue();
                $food_habit                 = $sheet->getCellByColumnAndRow(25, $i)->getValue();
                $transportation             = $sheet->getCellByColumnAndRow(26, $i)->getValue();
                $payment_type               = $sheet->getCellByColumnAndRow(27, $i)->getValue();
                $total_amount               = $sheet->getCellByColumnAndRow(28, $i)->getValue();
                $discount                   = $sheet->getCellByColumnAndRow(29, $i)->getValue();
                $payable_amount             = $sheet->getCellByColumnAndRow(30, $i)->getValue();
                $payed_amount               = $sheet->getCellByColumnAndRow(31, $i)->getValue();
                $payment_mode               = $sheet->getCellByColumnAndRow(32, $i)->getValue();
                
                if($payment_type=='installment'){
                    $insNo = 1;
                    for($ins=33;$ins<=$highestColumn;$ins++){
                        $instments[$insNo] = $sheet->getCellByColumnAndRow($ins, $i)->getValue();
                        $insNo++;
                    }
                }
                if($student_name=='' ||$student_name==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(1, $i)->getCoordinate(),'Student Name']);
                }
                if($gender=='' ||$gender==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(2, $i)->getCoordinate(),'Gender']);
                }
                if($address=='' ||$address==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(3, $i)->getCoordinate(),'Address']);
                }
                if($street_name=='' ||$street_name==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(4, $i)->getCoordinate(),'Street Name']);
                }
                if($state=='' ||$state==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(5, $i)->getCoordinate(),'State']);
                }
                if($district=='' ||$district==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(6, $i)->getCoordinate(),'District']);
                }
                if($email=='' ||$email==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(7, $i)->getCoordinate(),'Email']);
                }
                if($email!='') {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { } else {
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(7, $i)->getCoordinate(),'Invalid Email']);    
            
                    }

                    $exist = $this->common->count_from_table('am_students', array('email'=>$email));
                    if($exist>0) { 
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(7, $i)->getCoordinate(),'Email already exists']);    
                    }

                    
                }

                if($contact_number=='' ||$contact_number==NULL){
                    if($whatsapp_number=='' ||$whatsapp_number==NULL){
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(8, $i)->getCoordinate(),'Contact Number']);
                    }else{
                        $contact_number = $whatsapp_number;
                    }
                }
                if($contact_number!='') {
                if(is_numeric($contact_number) && $contact_number > 0 && strlen($contact_number)>=10 && strlen($contact_number)<=13) {} else {
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(8, $i)->getCoordinate(),'Invalid Contact Number']);
                }
                $exist = $this->common->count_from_table('am_students', array('contact_number'=>$contact_number));
                    if($exist>0) { 
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(8, $i)->getCoordinate(),'Contact Number already exists']);    
                    }

                }

                if($whatsapp_number=='' ||$whatsapp_number==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(9, $i)->getCoordinate(),'Whatsapp Number']);
                }
                if($whatsapp_number!='') {
                    if(is_numeric($whatsapp_number) && $whatsapp_number > 0 && strlen($whatsapp_number)>=10 && strlen($whatsapp_number)<=13) {} else {
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(9, $i)->getCoordinate(),'Invalid Whatsapp Number']);
                    }
    
                    }
                if($mobile_number=='' ||$mobile_number==NULL){
                    if($whatsapp_number=='' ||$whatsapp_number==NULL){
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(10, $i)->getCoordinate(),'Mobile Number']);
                    }else{

                        $mobile_number = $whatsapp_number;
                    }
                }

                if($mobile_number!='') {
                    if(is_numeric($mobile_number) && $mobile_number > 0 && strlen($mobile_number)>=10 && strlen($mobile_number)<=13) {} else {
                        $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(10, $i)->getCoordinate(),'Invalid Mobile Number']);
                    }
    
                    }



                if($blood_group=='' ||$blood_group==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(11, $i)->getCoordinate(),'Blood Group']);
                }
                if($date_of_birth=='' ||$date_of_birth==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(12, $i)->getCoordinate(),'Date of Birth']);
                }
                if($name_of_guardian=='' ||$name_of_guardian==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(13, $i)->getCoordinate(),'Name of Guardian']);
                }
                if($guardian_contact_number=='' ||$guardian_contact_number==NULL){
                    $html .= get_table_html_tr([$sheet->getCellByColumnAndRow(14, $i)->getCoordinate(),'Guardian Contact Number']);
                }

                $permanent_state_name = ucfirst($state);
                $state = $this->db->get_where('states', array('name' => $permanent_state_name,'country_id'=>'101'))->row();
                if(!empty($state)){
                    $state_id = $state->id;
                }else{
                    $state_id = "0";
                }

                $permanent_city_name = ucfirst($district);
                $district = $this->db->get_where('cities', array('name' => $permanent_city_name))->row();
                if(!empty($district)){
                    $city_id = $district->id;
                }else{
                    $city_id = "0";
                }
                if($gender=='Female'){
                    $gender="female";
                }else{
                    $gender="male";
                }

                if($blood_group=='A +ve'){
                    $blood_group="A+ve";
                }else if($blood_group=='A -ve'){
                    $blood_group="A-ve";
                }else if($blood_group=='B +ve'){
                    $blood_group="B+ve";
                }else if($blood_group=='B -ve'){
                    $blood_group="B-ve";
                }else if($blood_group=='O +ve'){
                    $blood_group="O+ve";
                }else if($blood_group=='O -ve'){
                    $blood_group="O-ve";
                }else if($blood_group=='AB +ve'){
                    $blood_group="AB+ve";
                }else if($blood_group=='AB -ve'){
                    $blood_group="AB-ve";
                }else if($blood_group=='Not Available'){
                    $blood_group="Not Available";
                }
                if ($student_name==""|| $gender=="" || $address=="" || $street_name=="" || !isset($district->id) || !isset($district->state_id)|| $email==""||$contact_number==""|| $whatsapp_number==""|| $mobile_number==""|| $date_of_birth==""|| $name_of_guardian==""|| $guardian_contact_number=="") {   
                    $data['row_error']  = 'ROW :' . $i .  ' not saved! - <b>Error : </b>empty fields provided' . PHP_EOL;
                } else {
                    $state_id= $district->state_id;
                    $city_id= $district->id;
                    $check_name = (!preg_match("/^([a-z\s])+$/i", $student_name)) ? FALSE : TRUE;
                    $check_name = (!preg_match("/^([a-z\s])+$/i", $gender)) ? FALSE : TRUE;
                    // Remove all illegal characters from email
                    $email_id = filter_var($email, FILTER_SANITIZE_EMAIL);
                    // Validate e-mail
                    if (!filter_var($email_id, FILTER_VALIDATE_EMAIL) === false) {
                        
                    } else {
                        $data['row_error'] = 'ROW :' . $i  . ' not saved! - <b>Error : </b>Invalid email id is provided' . PHP_EOL;
                    }
                }
                $mobile_check = 0;
                if (strlen($mobile_number) != 10) {
                    $data['row_error'] = 'ROW :' . $i .  ' not saved! - <b>Error : </b> Invalid Mobile Number' . PHP_EOL;
                }
                
                $user_check =  $this->user_check_new($student_name, $email, $contact_number);
                $quot_check = 0;
                if ($quot_check == 0) {
                    $quot_check = $this->check_for_quotes($student_name);
                }
                if ($quot_check == 0) {
                    $quot_check = $this->check_for_quotes($email);
                }
                if ($quot_check == 1) {
                    $data['row_error'] = 'ROW :' . $i  . ' not saved! - <b>Error : </b> Field Contains invalid characters such as single or double quotes' . PHP_EOL;
                }

                // $centermapp  = $this->user_model->get_course_centermapp($course_id, $branch_id, $center_id); 
                // $centermapp = $this->db->get_where('am_student_course_mapping', array('course_id' => $course_id,'branch_id' => $branch_id,'center_id' => $center_id))->row()->institute_course_mapping_id;
                
                $centermapp = $this->db->get_where('am_institute_course_mapping', array('course_master_id' => $course_id,
                                                                                        'branch_master_id' => $branch_id,
                                                                                        'institute_master_id' => $center_id)
                                                                                        )->row()->institute_course_mapping_id;
                
                //validation for duplication
                if ($user_check != false) { 
                    $data['row_error'] ="Upload failed the email id in row number ".$i." already exist..!";
                }
                if(isset($data['row_error'])){
                    $data['res'] = 0;
                    print_r(json_encode($data));
                    exit;
                }

                $batchdate = $this->common->get_from_table_select_row('am_batch_center_mapping', array('batch_id'=>$batch_id), 'batch_datefrom');
                
                //insertion
                array_push($studentArr,array(
                    'name'              => !empty($student_name) ? $student_name : '',
                    'gender'            => !empty($gender) ? $gender : '',
                    'address'           => !empty($address) ? $address : '',
                    'street'            => !empty($street_name) ? $street_name : '',
                    'state'             => !empty($state_id) ? $state_id : '',
                    'district'          => !empty($city_id) ? $city_id : '',
                    'contact_number'    => !empty($contact_number) ? $contact_number : '',
                    'whatsapp_number'   => !empty($whatsapp_number) ? $whatsapp_number : '',
                    'mobile_number'     => !empty($mobile_number) ? $mobile_number : '',
                    'guardian_name'     => !empty($name_of_guardian) ? $name_of_guardian : '',
                    'guardian_number'   => !empty($guardian_contact_number) ? $guardian_contact_number : '',
                    'email'             => !empty($email) ? $email : '',
                    'date_of_birth'     => !empty($date_of_birth) ? $date_of_birth : '',
                    'hostel'            => !empty($hostel) ? $hostel : '',
                    'blood_group'       => !empty($blood_group) ? $blood_group : '',
                    'stayed_in_hostel'  => !empty($stayed_in_hostel) ? $stayed_in_hostel : '',
                    'food_habit'        => !empty($food_habit) ? $food_habit : '',
                    'transportation'    => !empty($transportation) ? $transportation : '',
                    'transportation'    => !empty($transportation) ? $transportation : '',
                    'admitted_date'     => !empty($batchdate) ? $batchdate['batch_datefrom'] : '2019-01-01',
                    'verified_status '  => 1,
                    'status '           => 1
                ));
                array_push($qualificationArr1,array(
                    'category'          => "sslc",
                    'qualification'     => $sslc,
                    'marks'             => $percentage_sslc
                ));
                array_push($qualificationArr2,array(
                    'category'          => "plustwo",
                    'qualification'     => $plus_two,
                    'marks'             => $percentage_plus_two
                ));
                array_push($qualificationArr3,array(
                    'category'          => "degree",
                    'qualification'     => $degree,
                    'marks'             => $percentage_degree
                ));
                array_push($qualificationArr4,array(
                    'category'          => "pg",
                    'qualification'     => $pg,
                    'marks'             => $percentage_pg
                ));
                array_push($mapArr,array(
                    'institute_course_mapping_id'   => $centermapp,
                    'course_id'                     => $course_id,
                    'branch_id'                     => $branch_id,
                    'center_id'                     => $center_id,
                    'batch_id'                      => $batch_id,
                    'status '                       => 1
                ));
                array_push($payments,array(
                    'institute_course_mapping_id'   => $centermapp,
                    'batch_id'                      => $batch_id,
                    'payment_type'                  => $payment_type,
                    'total_amount'                  => $total_amount,
                    'discount_applied'              => $discount,
                    'payable_amount'                => $payable_amount,
                    'paid_amount'                   => $payed_amount,
                    'paymentmode'                   => $payment_mode,
                    'balance'                       => $payable_amount-$payed_amount,
                    'status'                        => 1
                ));
                array_push($installments,$instments);
            }
            if ($html == '' && $user_check == false) {
                if(!empty($studentArr) && 
                !empty($qualificationArr1) && 
                !empty($qualificationArr2) && 
                !empty($qualificationArr3) && 
                !empty($qualificationArr4) && 
                !empty($payments) && 
                !empty($installments)){
                    // show($installments);
                    foreach($studentArr as $k=>$v){
                        $insert_stat = $this->user_model->insert_data($studentArr[$k],$qualificationArr1[$k],$qualificationArr2[$k],$qualificationArr3[$k],$qualificationArr4[$k],$mapArr[$k],$payments[$k],$installments[$k]);
                        if($insert_stat!=1){
                            // show($v);
                        }
                    }
                    $res = 1;
                    $what=$this->db->last_query();
                    $table_row_id=$this->db->insert_id();
                    $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                    logcreator('insert', 'Student excel imported', $who, $what, $table_row_id, 'am_students');
                }else{
                    $res = 0;
                }
            }else{
                $html = '<strong>Empty Fields are :</strong>
                            <table class="table table-striped table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cell Number</th>
                                        <th>Cell Heading</th>
                                    </tr>
                                </thead>
                                <tbody>'.$html.'</tbody></table>';
                $res = 0;
            }

            $data['res'] = $res;
            $data['html'] = $html;
            print_r(json_encode($data));
        }
    }


    function user_check_new($student_name, $email, $phone) {
        return $this->user_model->user_check_new($student_name, $email, $phone);
        if ($result == true) {
            return "2";
        } else {
            return "0";
        }
    }

    function check_for_quotes($str) {
        return preg_match('~[\'"]~', $str);
    }

      
    public function get_all_batches_details()
    {
        $result['st'] = 1;
        $course_id  = $this->input->post('course_id');
        $branch_id  = $this->input->post('branch_id');
        $center_id  = $this->input->post('center_id');
        $batchdet ='';
        $centermapp  = $this->Batch_model->get_course_centermapp($course_id, $branch_id, $center_id); 
        
        $batchdet .='<option value="">Select Branch</option>';
        if(!empty($centermapp)) {
            foreach($centermapp as $coursemap) { 
                $batches = $this->Batch_model->get_all_batches($coursemap->institute_course_mapping_id);
                foreach($batches as $batch) { 
                    $batchdet .= '<option value="'.$batch->batch_id.'" >'.$batch->batch_name.'</option>';
                }
            }
        }
    print_r(json_encode(array('batches'=>$batchdet,'data'=> $result)));
    } 
   
    
     
    public function staff_migration()
    {
        check_backoffice_permission('staff_migration');
        $this->data['page']="admin/staff_migration";
        $this->data['menu']="basic_configuration";
        $this->data['breadcrumb']="Staff Migration";
        $this->data['menu_item']="backoffice/staff-migration";
        $this->data['courseArr']=$this->call_center_model->getall_list();
        $this->data['batchArr']=$this->register_model->get_batch_by_insticourse_id($this->session->userdata('branch_institute_id'));
        $this->load->view('admin/layouts/_master',$this->data); 
    }

    function staff_uploads(){
        $errflag = 0;
            $res=2;
            $html ='';

        // if($_POST){
        //     $res=2;
            $html .= '<strong>Empty Fields are :</strong>
                        <table class="table table-striped table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cell Number</th>
                                    <th>Cell Heading</th>
                                </tr>
                            </thead>
                            <tbody>';
           $config['upload_path']   = FCPATH . 'uploads/';
           $config['allowed_types'] = 'xls|xlsx|csv';
           $config['max_size']      = '5000';
           $file_name               = $_FILES['question']['name']; //uploded file name
           $allowed                 = explode('|', $config['allowed_types']);
           $ext                     = pathinfo($file_name, PATHINFO_EXTENSION);
       // echo $allowed;
           move_uploaded_file($_FILES["question"]["tmp_name"], '././uploads/' . $file_name);
           $this->load->library('upload', $config);
           $this->load->library('excel');
           $spreadsheet = $this->excel->load($config['upload_path'].$file_name);
           $sheetData = $spreadsheet->getActiveSheet()->toArray();
           //  Get worksheet dimensions
           $sheet = $spreadsheet->getSheet(0); 
           $highestRow = $sheet->getHighestRow(); 
           //echo $highestRow;
           for ($i = 2; $i <= $highestRow; $i++){
              
               $staff_name               = $sheet->getCellByColumnAndRow(1, $i)->getValue();
               $role                     = $sheet->getCellByColumnAndRow(2, $i)->getValue();
               $dob                      = convert_excel_date($sheet->getCellByColumnAndRow(3, $i)->getValue());
               $gender                   = $sheet->getCellByColumnAndRow(4, $i)->getValue();
               $marital_status           = $sheet->getCellByColumnAndRow(5, $i)->getValue();
               $spouse_name              = $sheet->getCellByColumnAndRow(6, $i)->getValue();
               $height                   = $sheet->getCellByColumnAndRow(7, $i)->getValue();
               $weight                   = $sheet->getCellByColumnAndRow(8, $i)->getValue();
               $blood_group              = $sheet->getCellByColumnAndRow(9, $i)->getValue();
               $primary_contact          = $sheet->getCellByColumnAndRow(10, $i)->getValue();
               $landline                 = $sheet->getCellByColumnAndRow(11, $i)->getValue();
               $email                    = $sheet->getCellByColumnAndRow(12, $i)->getValue();
               $permanent_address        = $sheet->getCellByColumnAndRow(13, $i)->getValue();
               $communication_address    = $sheet->getCellByColumnAndRow(14, $i)->getValue();
               $country                  = $sheet->getCellByColumnAndRow(15, $i)->getValue();
               $state                    = $sheet->getCellByColumnAndRow(16, $i)->getValue();
               $city                     = $sheet->getCellByColumnAndRow(17, $i)->getValue();
               $body_reg                 = $sheet->getCellByColumnAndRow(18, $i)->getValue();
               $aadhaar                  = $sheet->getCellByColumnAndRow(19, $i)->getValue();
               $pan                      = $sheet->getCellByColumnAndRow(20, $i)->getValue();
               $ac_no                    = $sheet->getCellByColumnAndRow(21, $i)->getValue();
               $ifsc                     = $sheet->getCellByColumnAndRow(22, $i)->getValue();

               $permanent_country_name = ucfirst($country);
               $country = $this->db->get_where('countries', array('name' => $permanent_country_name))->row();
               if(!empty($country)){
                $spouse_country = $country->id;
               }else{
                $spouse_country = "0";
               }
               $permanent_state_name = ucfirst($state);
               $state = $this->db->get_where('states', array('name' => $permanent_state_name,'country_id'=>'101'))->row();
               if(!empty($state)){
                $spouse_state = $state->id;
               }else{
                $spouse_state = "0";
               }
               $permanent_city_name = ucfirst($city);
               $city = $this->db->get_where('cities', array('name' => $permanent_city_name))->row();
               if(!empty($city)){
                   $spouse_city = $city->id;
               }else{
                   $spouse_city = "0";
               }

               if($role=='Management'){
                    $role="management";
                }else if($role=='Faculty'){
                    $role="faculty";
                }else if($role=='HR'){
                    $role="hr";
                }else if($role=='Receptionist'){
                    $role="receptionist";
                }else if($role=='Call Center Head'){
                    $role="cch";
                }else if($role=='Call Center Executive'){
                    $role="cce";
                }else if($role=='Course Coordinator'){
                    $role="coursecoordinator";
                }else if($role=='Center Head'){
                    $role="centerhead";
                }else if($role=='Material Management Head'){
                    $role="mmh";
                }else if($role=='Material Creator'){
                    $role="mc";
                }else if($role=='Accountant'){
                    $role="accountant";
                }else if($role=='Operation Head'){
                    $role="operationhead";
                }else if($role=='Operation executive'){
                    $role="operationexcutive";
                }else if($role=='Other staff'){
                    $role="others";
                }else if($role=='Hosten Warden'){
                    $role="hotelwarden";
                }else if($role=='Driver'){
                    $role="driver";
                }

               if($staff_name=='' ||$staff_name==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(1, $i)->getCoordinate().'</td>
                            <td>Staff Name</td>
                        </tr>';
                        $errflag = 1;
            }
            if($role=='' ||$role==NULL){
             $html .='<tr>
                         <td>'.$sheet->getCellByColumnAndRow(2, $i)->getCoordinate().'</td>
                         <td>Role</td>
                     </tr>';
                     $errflag = 1;

             }
            if($dob=='' ||$dob==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(3, $i)->getCoordinate().'</td>
                            <td>Date of Birth</td>
                        </tr>';
                        $errflag = 1;

            }
            if($blood_group=='' ||$blood_group==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(9, $i)->getCoordinate().'</td>
                            <td>Blood Group</td>
                        </tr>';
                        $errflag = 1;

            }

            if($primary_contact=='' ||$primary_contact==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(10, $i)->getCoordinate().'</td>
                            <td>Primary Contact Number</td>
                        </tr>';
                        $errflag = 1;

            }
            if($email=='' ||$email==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(12, $i)->getCoordinate().'</td>
                            <td>Email</td>
                        </tr>';
                        $errflag = 1;

        }

        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { } else {
            $html .='<tr>
                        <td>'.$sheet->getCellByColumnAndRow(12, $i)->getCoordinate().'</td>
                        <td>Invalid Email</td>
                    </tr>';
                    $errflag = 1;

        }

            if($permanent_address=='' ||$permanent_address==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(13, $i)->getCoordinate().'</td>
                            <td>Permanent Address</td>
                        </tr>';
                        $errflag = 1;

            }
            if($country=='' ||$country==NULL){
             $html .='<tr>
                         <td>'.$sheet->getCellByColumnAndRow(15, $i)->getCoordinate().'</td>
                         <td>Country</td>
                     </tr>';
                     $errflag = 1;

             }
            if($state=='' ||$state==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(16, $i)->getCoordinate().'</td>
                            <td>State</td>
                        </tr>';
                        $errflag = 1;

            }
            if($city=='' ||$city==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(17, $i)->getCoordinate().'</td>
                            <td>City</td>
                        </tr>';
                        $errflag = 1;

            }
            if($aadhaar=='' ||$aadhaar==NULL){
                $html .='<tr>
                            <td>'.$sheet->getCellByColumnAndRow(19, $i)->getCoordinate().'</td>
                            <td>Aadhaar Card Number</td>
                        </tr>';
                        $errflag = 1;

        }
        
        if(is_numeric($aadhaar) && $aadhaar > 0 && strlen($aadhaar)==12) {} else {
            $html .='<tr>
                        <td>'.$sheet->getCellByColumnAndRow(19, $i)->getCoordinate().'</td>
                        <td>Invalid Aadhaar Card Number</td>
                    </tr>';
                    $errflag = 1;

        }
            if($errflag==0){
               $staff_check =  $this->staff_enrollment_model->is_staff_personal_exist($primary_contact, $email);
                //validation
                  if ($staff_check != false) {
                      $data['res']=0;
                      $data['row_error'] ="The Data in row number ".$i." is already exist..!";
                      print_r(json_encode($data));
                      exit();
                  }
                
                //insertion
                if ($staff_check == false) {
                    $staffArr    = array(
                               'name'                   => !empty($staff_name) ? $staff_name : '',
                               'role'                   => !empty($role) ? $role : '',
                               'dob'                    => !empty($dob) ? $dob : '',
                               'gender'                 => !empty($gender) ? $gender : '',
                               'marital_status'         => !empty($marital_status) ? $marital_status : '',
                               'spouse_name'            => !empty($spouse_name) ? $spouse_name : '',
                               'height'                 => !empty($height) ? $height : '',
                               'weight	'               => !empty($weight) ? $weight	 : '',
                               'blood_group'            => !empty($blood_group) ? $blood_group : '',
                               'mobile'                 => !empty($primary_contact) ? $primary_contact : '',
                               'landline'               => !empty($landline) ? $landline : '',
                               'email'                  => !empty($email) ? $email : '',
                               'permanent_address'      => !empty($permanent_address) ? $permanent_address : '',
                               'communication_address'  => !empty($communication_address) ? $communication_address : '',
                               'spouse_country'         => !empty($spouse_country) ? $spouse_country : '',
                               'spouse_state'           => !empty($spouse_state) ? $spouse_state : '',
                               'spouse_city'            => !empty($spouse_city) ? $spouse_city : '',
                               'body_reg'               => !empty($body_reg) ? $body_reg : '',
                               'aadhar_no'              => !empty($aadhaar) ? $aadhaar : '',
                               'pan_no'                 => !empty($pan) ? $pan : '',
                               'ac_no'                  => !empty($ac_no) ? $ac_no : '',
                               'ifsc_code'              => !empty($ifsc) ? $ifsc : '',
                    );
                    $res    = $this->user_model->insert_staff($staffArr);
                    $table_row_id = $this->db->insert_id();
                    if($table_row_id){
                         $registrationNumber = generate_staffid($table_row_id);
                        if($registrationNumber){
                            $this->db->where('personal_id',$table_row_id);
                            $this->db->update('am_staff_personal', array('registration_number'=>$registrationNumber));
                            $this->load->model('Auth_model');
                            $password =mt_rand(100000,999999);
                            $encrypted_password= $this->Auth_model->get_hash($password);
                            $dataArr = array('user_username'=>$email,
                                            'user_name'=>$staff_name,
                                            "registration_number"=>$registrationNumber,
                                            'user_emailid'=>$email,
                                            'user_role'=>$role,
                                            'user_phone'=>$primary_contact,
                                            'user_passwordhash'=>$encrypted_password
                                           );
                            $response_id=$this->Common_model->insert('am_users_backoffice',$dataArr);
                            if($response_id){
                                $this->db->where('personal_id', $table_row_id);
                                $query = $this->db->update('am_staff_personal', array('user_id'=>$response_id,'registration_number'=>$registrationNumber));
                                $emaildata = email_header();
                                $emaildata.='<tr style="background:#f2f2f2">
                                                <td style="padding: 20px 0px">
                                                    <h3 style="font-family: "Open Sans", sans-serif;color: #333;font-size: 13px; padding: 0px 26px;">Dear '.$staffArr['name'].'</h3>
                                                    <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;">An account has been created for you on Direction application, Now you can login to our website application using following credential.</p>
                                                    <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Username :</b> '.$staffArr['email'].'</p>
                                                    <p style="font-family: "Open Sans", sans-serif;color: #727272;font-size: 13px; padding: 0px 26px;line-height: 26px;"><b>Password :</b> '.$password.'</p>
                                                    <br><a href="'.base_url('login').'">Click here to login</a> and view your Course details and schedule details
                                                    </p>
                                                </td>
                                            </tr>';
                                $emaildata.=email_footer();
                                $jobdata['type']    = 'Staff-migration';
                                $jobdata['user_id'] = $table_row_id;
                                $jobdata['from']    = 'noreply@direction.com';
                                $jobdata['to']      = $staffArr['email'];
                                $jobdata['subject'] = 'Login credentials for login to Direction application';
                                $jobdata['message'] = $emaildata;
                                $this->db->insert('emails', $jobdata);
                            }
                        }
                    }else{
                        $res=3;
                    }
                }
                else{
                    $res=0;
                    $data['row_error'] ="The Data in row number ".$i." is already exist..!";
                }  
                $what=$this->db->last_query();
                $table_id=$this->db->insert_id();
                $who=$this->session->userdata['user_id'].'/'.$this->session->userdata['role'];
                logcreator('insert', 'Staff excel imported', $who, $what, $table_id, 'am_staff_personal');
            }
        }
        // } 
        // $res='';
        // $html = '';
        $html .= '</tbody>
        </table>';
    $data['res'] =$res;
    $data['html'] =$html;
    print_r(json_encode($data));
   
}
function staff_check_new($staff_name, $email, $phone) {
 return $this->user_model->staff_check_new($staff_name, $email, $phone);
   if ($result == true) {
       return "2";
   } else {
       return "0";
   }
}
    
    public function view_students_by_branch($course_id,$center_id){
        // if($id!=NULL){
        //     $this->data['hierarchyView'] = $this->institute_model->get_institutedetails_by_id($id);
        // }
        $role=$this->session->userdata['role'];
        $this->data['page']="admin/students_branch_view";
        if($role == "cch")
        {
         $this->data['menu']="call_center";
         $this->data['breadcrumb']="Batch Details";
        }
        else
        {
            $this->data['menu']="basic_configuration";
            $this->data['breadcrumb']="Manage Institute";
        }      
        
        $this->data['menu_item']="backoffice/view-hierarchy";
        $this->data['subjectArr'] = $this->institute_model->get_all_subjects_subjectype();
        $this->data['moduleArr']=$this->institute_model->get_allmodules_by_subjectid($_POST);
        $this->data['instituteArr']=$this->institute_model->get_all_institutes();
        $this->data['coursedet'] =  $this->common->get_course_syllabus_details($course_id); 
        // $this->data['groupArr']=$this->institute_model->get_instituteby_id($id);
        $details = $this->Batch_model->get_institutecourse_mapping_byid($_POST);
        $data['parent_institute']=$details['group_master_id'];
        $this->data['branchArr']=$this->institute_model->get_allsub_byparent($data);
        $data['parent_institute']=$details['branch_master_id'];
        $this->data['centerArr']=$this->institute_model->get_allsub_byparent($data);
        // $center_id = $this->input->post('center_id');
        $this->data['courseArr']= $this->institute_model->getall_institute_course_mapping_list(); 
        $batch = $this->institute_model->get_all_batches($course_id,$center_id);
        $this->data['batchArr'] = $batch;
        //$this->data['studentArr']=$this->institute_model->get_student_course();
        $this->data['studentArr'] = '';
        if(!empty($batch)) {
            $batch_id = $batch[0]['batch_id'];
            $this->data['studentArr']=$this->institute_model->get_student_inbatch($batch_id);
        }
        // $this->data['batch_id']=$id;
        // echo '<pre>';
        // print_r($this->data);
        // // print_r($this->data['batchArr']);
        // die(); 
		$this->load->view('admin/layouts/_master',$this->data);
    }
	
	
	public function my_exam_list(){
        //check_backoffice_permission('manage_progress_report');
        $this->data['page']="admin/my_exam_list";
		$this->data['menu']="employee";
        $this->data['breadcrumb']="My Exams";
        $this->data['menu_item']="backoffice/my-exams";
        //$this->data['studentArr']=$this->student_model->get_students_progress_list();
		$this->load->view('admin/layouts/_master',$this->data);
    }
	
	public function progress_report_list(){
        //check_backoffice_permission('manage_progress_report');
        $this->data['page']="admin/common_progress_report_list";
		$this->data['menu']="employee";
        $this->data['breadcrumb']="My Exams";
        $this->data['menu_item']="backoffice/progress_report";
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
           $batches=$this->common->get_alldata('am_batch_center_mapping',array("institute_course_mapping_id"=>$institute_course_mapping_id,'batch_status'=>1));
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
                <th width="50">'.$this->lang->line('sl_no').'</th>
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
                            <td>'.$x.'</td>
                            <td>'.$mark->name.'</td>
                            <td>'.$mark->attempt.'</td>
                            <td>'.$mark->max.'</td>
                            <td>'.$mark->min.'</td>
                            <td>'.$mark->avg.'</td>
                            <td><button class="btn btn-primary chartBlockBtn batchaverage" alt="'.$mark->attempt.'" id="'.$mark->exam_id.'">View</button></td>
                        </tr>';
                        $x++; 
                  }
              }    
                
              $where['am_student_course_mapping.batch_id']=$batch_id;
            }
            

            $data=$this->student_model->search_student_progresslist($where);
         $html = '<thead><tr>
                <th width="50">'.$this->lang->line('sl_no').'</th>
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
                            <td>'.$i.'</td>
                            <td>'.$row['registration_number'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['contact_number'].'</td>
                            <td>'.$row['street'].'</td>
                            <td><button class="btn btn-success chartBlockBtn studentindivigualprogress"  id="'.$row['student_id'].'" id="chartBlockBtn">View</button></td>
                        </tr>';
                        $i++; 
             }
             
             $html .= '<script>
                     $(document).ready(function () {
                         $(".chartBlockBtn").click(function () {
                            $("#chartBlock").toggleClass("show");
                            $(".close_btn").fadeIn("200");
                        });
                        $(".close_btn").click(function () {
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

/*
*   function'll get progress report
*   @params question id
*   @author GBS-R
*/
// public function progress_report(){ 
//     $student_id = $this->input->post('student_id');
//     $myexams = $this->user_model->get_student_exams($student_id); //print_r($myexams);
//     $this->data['myexams'] = $myexams;
//     if(!empty($myexams)) { 
//     $i=1; 
//     $outof = '';
//     $examStr = '';
//     $sectionStr ='';
//     $colorcombo = ''; 
//     $sectionArr = array();   
// 	$question_paper_id = 0;
//     foreach($myexams as $mark) {  //echo '<pre>';print_r($mark); 
//         $examStr .= "'".$mark->name."',";
//         $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
//         $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
//         $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
//         if(!empty($question_paper)) {
//            $question_paper_id =  $question_paper['question_paper_id'];
//         }
//         $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id); //print_r($section_ids);
//         $this->data['questions']    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids);
//         $questions = $this->data['questions'];
//         if(!empty($questions)) {
//            foreach($questions as $key=>$question) { //print_r($question);
//             $sectionDet = $this->common->get_section_nameby_details($question->exam_section_details_id); 
//             $questions[$key]->subject_id= $sectionDet['exam_section_config_id'];
//             $questions[$key]->subject_name= $sectionDet['section_name'];
//             array_push($sectionArr, $question->subject_id);
//            }
//            $sectionArr = array_unique($sectionArr);
//         }
//         $i++;
//     }
//             $pie        = '';
//             $sectotal   = 0;
// 			$actualmark = 0;
// 			$actualsecMark = 0;
//             $colors[0]  = '#7cb5ec';
//             $colors[1]  = '#434348';
//             $colors[2]  = '#90ed7d';
//             $colors[3]  = '#f7a35c';
//             $colors[4]  = '#e4d354';
//             $colors[5]  = '#f15c80';
//             $colors[6]  = '#91e8e1';
//             $colors[7]  = '#2b908f';
//             $colors[8]  = '#f45b5b';
//             $colors[9]  = '#f8aec0';
//             $colors[10]  = '#0f487f';
//             $colors[11]  = '#ffcccc';$colors[12]  = '#ff9999';$colors[13]  = '#ffcc99';$colors[14]  = '#ffa64d';
//             $colors[15]  = '#cc6600';$colors[16]  = '#ff9933';$colors[17]  = '#cccc00';$colors[18]  = '#999900';
//             $colors[19]  = '#cccc00';$colors[20]  = '#ff00ff';$colors[21]  = '#cc00cc';$colors[22]  = '#ffccff';
//             $colors[23]  = '#b3b3ff';$colors[24]  = '#3333ff';$colors[25]  = '#66e0ff';$colors[26]  = '#ccf5ff';
//             $colors[27]  = '#008fb3';$colors[28]  = '#1affc6';$colors[29]  = '#00cc99';$colors[30]  = '#b3ffec';
//             $colors[31]  = '#ffcccc';$colors[32]  = '#ff9999';$colors[33]  = '#ffcc99';$colors[34]  = '#ffa64d';
//             $colors[35]  = '#cc6600';$colors[36]  = '#ff9933';$colors[37]  = '#cccc00';$colors[38]  = '#999900';
//             $colors[39]  = '#cccc00';$colors[40]  = '#ff00ff';$colors[41]  = '#cc00cc';$colors[42]  = '#ffccff';
//             $colors[43]  = '#b3b3ff';$colors[44]  = '#3333ff';$colors[45]  = '#66e0ff';$colors[46]  = '#ccf5ff';
//             $colors[47]  = '#008fb3';$colors[48]  = '#1affc6';$colors[49]  = '#00cc99';$colors[50]  = '#b3ffec';
//             $ccnt = 0; //echo '<pre>';print_r($sectionArr);
//             foreach($sectionArr as $section) {
//                 //$sectionDet = $this->common->get_from_tablerow('gm_exam_section_config', array('id'=>$section)); 
//                 $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
//                 $colorcombo .= "'".$colors[$ccnt]."',";
//                 $sectionStr .= "{name: '".$sectionDet['section_name']."',data: [";//11, 20, 20]},
//                 $sectionmarkStr = '';
//                 foreach($myexams as $mark) {  //print_r($mark);
//                     $myexam     = $this->user_model->get_student_examdetails($student_id, $mark->exam_id, $mark->attempt);
//                     $answer       = $this->user_model->get_student_exam_question_details($student_id, $mark->exam_id, $mark->attempt);
//                     $question_paper = $this->common->get_from_tablerow('gm_student_question_paper', array('exam_schedule_id'=>$mark->exam_id,'student_id'=>$student_id)); //print_r($question_paper); //die();
//                     if(!empty($question_paper)) {
//                        $question_paper_id =  $question_paper['question_paper_id'];
//                     }
//                     $section_ids = $this->common->get_section_ids_byexam_id($mark->exam_id);
//                     $questions    = $this->user_model->get_exam_papers_details($question_paper_id, $section_ids); 
//                     $sectionArr = array();
//                     if(!empty($questions)) {
//                         foreach($questions as $key=>$question) { 
//                          $sectionDett = $this->common->get_section_nameby_details($question->exam_section_details_id); 
//                          $questions[$key]->subject_id= $sectionDett['exam_section_config_id'];
//                          $questions[$key]->subject_name= $sectionDett['section_name'];
//                          array_push($sectionArr, $question->subject_id);
//                         }
//                         $sectionArr = array_unique($sectionArr);
//                      }
//                     $pmark = 0;
//                     $nmark= 0;
//                     foreach($questions as $question) {
//                         if($question->subject_id==$section){
//                              $anserclass = '';
//                             $st_answer = $this->common->get_student_answer($mark->attempt, $mark->exam_id, $student_id, $question->question_id); 
//                             if(!empty($st_answer)) {
// 									$actualmark += $st_answer->actual_mark;
//                                 if($st_answer->correct==1) {
//                                      $pmark += $st_answer->mark;   
//                                 } else {
//                                     $nmark += $st_answer->negative_mark; 
//                                 }
//                             }
//                         }
//                     }
//                     $sectiontotal = $pmark-$nmark;
//                     $sectionmarkStr .=  $sectiontotal.',';
//                     $sectotal += $sectiontotal;
//                 }   
//                     $pie .= "['".$sectionDet['section_name'];
// 					$sectiontotalperctage 	= $sectotal/$actualmark;
// 					$actualsecMark 			= $sectiontotalperctage*100;
//                     $pie .= "', ".number_format($actualsecMark,2)."],"; 
//                     $sectionStr .= substr($sectionmarkStr, 0, -1)."]},";
//                     $ccnt++;
//             }//die();
//     $examStr                    = substr($examStr, 0, -1); 
//     $sectionStr                 = substr($sectionStr, 0, -1);   
//     $pie                        = substr($pie, 0, -1);    
//     $this->data['exams']        = $examStr; 
//     $this->data['sectionStr']   = $sectionStr; 
//     $this->data['sectionpie']   = $pie;   
//     $this->data['color']        = $colorcombo;  
// 		echo $this->load->view('student/student_progress_report_view', $this->data, TRUE); 
//     } else {
// 		echo 'Exam result unavailable for this student.';
// 	}
    
// }

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
            $colors[31]  = '#ffcccc';$colors[32]  = '#ff9999';$colors[33]  = '#ffcc99';$colors[34]  = '#ffa64d';
            $colors[35]  = '#cc6600';$colors[36]  = '#ff9933';$colors[37]  = '#cccc00';$colors[38]  = '#999900';
            $colors[39]  = '#cccc00';$colors[40]  = '#ff00ff';$colors[41]  = '#cc00cc';$colors[42]  = '#ffccff';
            $colors[43]  = '#b3b3ff';$colors[44]  = '#3333ff';$colors[45]  = '#66e0ff';$colors[46]  = '#ccf5ff';
            $colors[47]  = '#008fb3';$colors[48]  = '#1affc6';$colors[49]  = '#00cc99';$colors[50]  = '#b3ffec';
            $ccnt = 0; //echo '<pre>';print_r($sectionArr);
            foreach($sectionArr as $section) { //echo '<pre>';print_r($section); 
            	$sectotal   = 0;
				$actualmark = 0;
                //$sectionDet = $this->common->get_from_tablerow('gm_exam_section_config', array('id'=>$section)); 
                $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
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
                    $pmark = 0;
                    $nmark= 0;
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
		echo $this->load->view('student/student_progress_report_view', $this->data, TRUE); 
    } else {
		echo 'Exam result unavailable for this student.';
	}
    
}

/*
*	Refferance module
*	@params 
*	@author
*/
	
public function reference_list()
    {

        // print_r($_SESSION);
        // die();
		if($this->session->userdata('role')=='cch' || $this->session->userdata('role')=='cce') {
		$this->data['menu']="call_center";
		$this->data['breadcrumb'][0]['name']="Manage Calls";
		$this->data['breadcrumb'][0]['url']=base_url('backoffice/manage-calls');
		$this->data['breadcrumb'][1]['name']="Reference List";	
		$this->data['menu_item']    = "backoffice/manage-calls";
		} else {	
		$this->data['menu']			= "employee";
		$this->data['breadcrumb']	= "Reference List";
        $this->data['menu_item']    = "backoffice/reference-list";	
		}
		$this->data['page']         = "admin/reference_list";
        $this->data['usersArr']=$this->common->get_staff_list_by_roles();
        $this->data['courseArr']=$this->call_center_model->getall_list();

        $this->data['call_centerArr'] = $this->call_center_model->get_reference_list($this->session->userdata('user_id'));
        // echo $this->db->last_query();
        // echo '<pre>';
        // print_r($this->data['call_centerArr']);
        // die();
        $user_id            		= $this->session->userdata('user_id');
        $this->data['userid']       = $user_id;
        $role 						= $this->session->userdata('role');
        // $this->data['call_centerArr']=$this->call_center_model->get_refe_list($user_id, $role); 
        // echo $this->db->last_query();
        // echo '<pre>';
        // print_r($this->data['refArr']);
        // die();
		$this->load->view('admin/layouts/_master',$this->data); 
    }
	

    public function cc_assigned_details_ajax() 
    {
      // print_r($_POST); 
        // Datatables Variables
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order  = $this->input->post("order");
        $this->data['courseArr']=$this->call_center_model->getall_list();
        $output = '';
        $filter_name = '';
        $filter_course = '';
        $filter_number = '';
        $filter_status = '';
        $filter_sdate = '';
        $filter_edate = '';
        $filter_enquiry = '';
        $filter_place = '';
        $filter_cce = '';
        $filter_rand_num = '';
        $filter_name = $this->input->post('filter_name');
        $filter_course = $this->input->post('filter_course');
        $filter_number = $this->input->post('filter_number');
        $filter_status = $this->input->post('filter_status');
        $filter_sdate = $this->input->post('filter_sdate');
        $filter_edate = $this->input->post('filter_edate');
        $filter_enquiry = $this->input->post('filter_enquiry');
        $filter_place = $this->input->post('filter_place');
        $filter_rand_num = $this->input->post('filter_rand_num');
        $filter_cce = $this->input->post('filter_cce');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role'); 
        $col    = 0;
        $dir    = "";
        if(!empty($order)) {
            foreach($order as $o) {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        // if($dir != "asc" && $dir != "desc") {
        //     $dir = "desc";
        // }

        $columns_valid = array(
            "cc_call_center_enquiries.call_id", 
            "cc_call_center_enquiries.rand_num", 
            "cc_call_center_enquiries.name", 
            "am_classes.class_name", 
            "cc_call_center_enquiries.primary_mobile", 
            "cc_call_center_enquiries.assignedperson" ,
            "cc_call_center_enquiries.enquiry_type" ,
            "cc_call_center_enquiries.timing" ,
            // "cc_call_center_enquiries.call_status" ,
        );

        if(!isset($columns_valid[$col])) {
            $order = null;
        } else {
            $order = $columns_valid[$col];
        }
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        // echo $role;
        if(empty($this->input->post('search')['value'])){
            // $data = $this->call_center_model->fetch_data($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce, $user_id, $role);

            $list = $this->call_center_model->get_ref_list_by_ajax($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce,$filter_rand_num,$user_id, $role,$start, $length, $order, $dir);
        }else {
            $search = $this->input->post('search')['value'];
            // $list = $this->call_center_model->get_call_center_list_by_ajax_search($user_id, $role,$start, $length, $order, $dir,$search,$search1);
            $list=$this->call_center_model->get_refe_list($user_id, $role); 

        }

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) {
            // if($rows['call_status']==1){
            //     $status = '<select class="form-control" name="call_status_list" id="edit_list_status_'.$rows['call_id'].'" onchange="get_val('.$rows['call_id'].')">
            //     <option selected value="1">Call Received</option>
            //     <option value="2">In Progress</option>
            //     <option value="3">Closed</option>
            //     <option value="4">Blacklisted</option>
            //     <option value="5">Registered</option>
            //     <option value="6">Admitted</option></select>';
            // }else if($rows['call_status']==2){
            //     $status = '<select class="form-control"><option selected value="2">In Progress</option>
            //     <option value="1">Call Received</option>
            //     <option value="3">Closed</option>
            //     <option value="4">Blacklisted</option>
            //     <option value="5">Registered</option>
            //     <option value="6">Admitted</option></select>';
            // }else if($rows['call_status']==3){
            //     $status = '<select class="form-control"><option selected value="3">Closed</option>
            //     <option value="1">Call Received</option>
            //     <option value="2">In Progress</option>
            //     <option value="4">Blacklisted</option>
            //     <option value="5">Registered</option>
            //     <option value="6">Admitted</option></select>';
            // }else if($rows['call_status']==4){
            //     $status = '<select class="form-control"><option selected value="4">Blacklisted</option>
            //     <option value="1">Call Received</option>
            //     <option value="2">In Progress</option>
            //     <option value="3">Closed</option>
            //     <option value="5">Registered</option>
            //     <option value="6">Admitted</option></select>';
            // }else if($rows['call_status']==5){
            //     $status = '<select class="form-control"><option value="4">Blacklisted</option>
            //     <option value="1">Call Received</option>
            //     <option value="2">In Progress</option>
            //     <option value="3">Closed</option>
            //     <option selected value="5">Registered</option>
            //     <option value="6">Admitted</option></select>';
            // }else {
            //     $status = '<select class="form-control"><option  value="4">Blacklisted</option>
            //     <option value="1">Call Received</option>
            //     <option value="2">In Progress</option>
            //     <option value="3">Closed</option>
            //     <option value="5">Registered</option>
            //     <option selected value="6">Admitted</option></select>';
            // }
            if($rows['class_name']!= ''){
                $class = $rows['class_name'];
            }else{
                $class = "";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['rand_num'];
            $row[] = $rows['name'];
            $row[] = $class;
            $row[] = $rows['primary_mobile'];
            $row[] = $rows['assignedperson'];
            $row[] = $rows['enquiry_type'];
            $row[] = date('d/m/Y h:m A', strtotime($rows['timing']));
            // $row[] = $status;
            $row[] ='<button  type="button" class="btn btn-default option_btn " onclick="get_details('.$rows['call_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;">
                        <i class="fa fa-eye "></i>
                    </button>
                    <button type="button" title="Edit" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$rows['call_id'].')">
                        <i class="fa fa-pencil "></i>
                    </button>
                    <a class="btn btn-default option_btn  " title="Delete" onclick="delete_call_centers('.$rows['call_id'].')">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$rows['call_id'].')">
                        Follow Up
                    </button>';  
			 
                  
            $data[] = $row;
        }

        $total_rows=$this->call_center_model->get_num_ref_by_ajax();
        $output = array(
              "draw" => $draw,
              "recordsTotal" => $total_rows,
              "recordsFiltered" => $total_rows,
              "data" => $data
          );
        echo json_encode($output);
        exit();
    }	
  	
    public function load_cc_assigned_ajax() {
        $html = '<thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Reference Key</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Primary Contact</th>
                        <th>Assigned To</th>
                        <th>Enquiry Type</th>
                        <th>Timing</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>';
            $user_id            = $this->session->userdata('user_id');
            $role = $this->session->userdata('role');
            $call_centerArr=$this->call_center_model->get_refe_list($user_id, $role); 
            if(!empty($call_centerArr)) {
            $i=1;
            foreach($call_centerArr as $calls) {
                if($calls['call_status']==1){
                    $selectData = '<option selected value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
                }else if($calls['call_status']==2){
                    $selectData ='<option selected value="2">In Progress</option>
                        <option value="1">Call Received</option>
                        <option value="3">Closed</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
                }else if($calls['call_status']==3){
                    $selectData = '<option selected value="3">Closed</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
                }else if($calls['call_status']==4){
                    $selectData = '<option selected value="4">Blacklisted</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
                }else if($calls['call_status']==5){
                    $selectData = '<option value="4">Blacklisted</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option selected value="5">Registered</option>
                        <option value="6">Admitted</option>';
                }else if($calls['call_status']==6){
                    $selectData = '<option  value="4">Blacklisted</option>
                        <option value="1">Call Received</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                        <option value="5">Registered</option>
                        <option selected value="6">Admitted</option>';
                }else{
                    $selectData = '<option value="">Select Status</option>
                        <option value="1">Answered</option>
                        <option value="2">No Answer</option>
                        <option value="3">Busy</option>
                        <option value="4">Blacklisted</option>
                        <option value="5">Registered</option>
                        <option value="6">Admitted</option>';
                }
        $html .= '<tr>
                <td>'.$i.'</td>
                <td>'.$calls['rand_num'].'</td>
                <td>'.$calls['name'].'</td>
                <td>'.$calls['class_name'].'</td>
                <td>'.$calls['primary_mobile'].'</td>
                <td>'.$calls['assignedperson'].'</td>
                <td>'.$calls['enquiry_type'].'</td>
                <td>'.date('d/m/Y h:m A', strtotime($calls['timing'])).'</td>
                <td>
                <div class="form-group form_zero" >
                <select class="form-control" name="call_status_list" id="edit_list_status_'.$calls['call_id'].'" onchange="get_val('.$calls['call_id'].')">'.$selectData.'</select>
                </div>
                </td>
                <td>
                <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$calls['call_id'].')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;">
                    <i class="fa fa-eye "></i>
                </button>
                <button type="button" title="Edit" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$calls['call_id'].')">
                    <i class="fa fa-pencil "></i>
                </button>';
//                <a class="btn btn-default option_btn  " onclick="delete_call_centers('.$calls['call_id'].')">
//                    <i class="fa fa-trash-o"></i>
//                </a>
                $html .= '<button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick=get_follow_up_data('.$calls['call_id'].');  formclear("add_followup");>
                    Follow Up
                </button>
                </td>
                </tr>'; 
                $i++;
            }
            $html .= '<button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
                    <i class="fa fa-upload"></i> Export
                </button>';
        }
        
        echo $html;
    }
	
	
		    function export_reffered_calls(){
            $filter_name = $this->input->post('filter_name');
            $filter_course = $this->input->post('filter_course');
            $filter_number = $this->input->post('filter_number');
            $filter_status = $this->input->post('filter_status');
            $filter_sdate = $this->input->post('filter_sdate');
            $filter_edate = $this->input->post('filter_edate');
            $filter_enquiry = $this->input->post('filter_enquiry');
            $filter_place = $this->input->post('filter_place');
            $filter_rand_num = $this->input->post('filter_rand_num');
            $filter_cce = $this->input->post('filter_cce');
            $user_id = $this->session->userdata('user_id');
            $role = $this->session->userdata('role'); 
            $data = $this->call_center_model->fetch_data_reffered($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce,$filter_rand_num,$user_id, $role);
            if($data->num_rows() > 0){
            $filename      = 'assignedcalls-report-'.date('Ymd').'.pdf';
            // $pdfFilePath = $filename . ".pdf";
            // $filename = time()."_report.pdf";
            $pdfFilePath = FCPATH."/uploads/".$filename; 
            $dataArr['call_centerArr'] = $data->result_array();
            $this->data['call_centerArr']=$this->call_center_model->get_call_center_list();
			$html = $this->load->view('admin/callcenter_assigned_export',$dataArr ,TRUE);
			ini_set('memory_limit','128M'); // boost the memory limit if it's low ;)
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf->SetFooter('<div style="text-align:center;"><img src="./assets/images/invfoot.png" style="margin:0px;display:block;"/></div>'); // Add a footer for good measure ;)
            $pdf->AddPage('L');
            $pdf->WriteHTML($html); // write the HTML into the PDF
            // $pdf->AddPage('P');
            $pdf->Output($filename, "D"); // save to file because we can
        }else{
            // echo "<body>
            // <h1>Object not found!</h1>
            // <p>
            //     The requested URL was not found on this server.
                
            // </p>
            // </body>";
            $this->session->set_userdata('toaster_error', "Add atleast one Caller Detail");
            redirect(base_url() . 'backoffice/reference-list','refresh');
        }
    }
	

  	/*
*   function'll get maintenance service notification
*   @params center id
*   @author GBS-L
*
*/
   

public function get_notification(){
        $center  = $this->session->userdata('center');
        $list = $this->Approval_model->get_approval_nottification_list($center);
        $maintenance_requestList_director = $this->Approval_model->list_maintenance_service_list("Waiting for Approval");
        $maintenance_requestedList_OperationHead = $this->Approval_model->list_maintenance_service_list("Requested");
        $maintenance_reopenList_OperationHead = $this->Approval_model->list_maintenance_service_list("Reopen");
        $maintenance_approvedby_operationHead = $this->Approval_model->approved_maintenance_service_list("Operation Team","Approved"); 
        $maintenance_approvedby_Director = $this->Approval_model->approved_maintenance_service_list("Management","Approved");
    
        $completed_details = $this->Approval_model->list_maintenance_service_data("Completed");
        $declined_details = $this->Approval_model->list_maintenance_service_data("Declined");
        $empty = 0;
        $data = '';
        $icon = '<img src="'.base_url().'inner_assets/images/notificcationinactive.png" class="img-responsive">';
        $html ='<div id="notificationContainer">
                                <div id="notificationTitle">Notifications</div>
                                <div id="notificationsBody" class="notifications  sb-container customScrollbar">
                                <div class="">
                                    <ul>';
        if(!empty($list) && $this->session->userdata('role')=='centerhead') {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='<a href="'.base_url('backoffice/discount-approval').'">
                        <li><div class="notificationIcon"><i class="fa fa-hand-o-right"></i></div>You have a discount approval notification<span class="notification_time"></span></li>
                    </a>';
        } 
        //waiting for approval-notifcation for director
        if(!empty($maintenance_requestList_director) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "management")) {
           
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='
                        <li><a  href="'.base_url('backoffice/maintenance-amount-approval').'">You have '.$maintenance_requestList_director.' maintenance approval notification<span class="notification_time"></span></a></li>
                    ';
        } 

        
        //requested-notification for Operation Head
        if(!empty($maintenance_requestedList_OperationHead) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='
                        <li><a  href="'.base_url('backoffice/view-maintenance-services').'">You have '.$maintenance_requestedList_OperationHead.' maintenance request notification<span class="notification_time"></span></a></li>
                    ';
        } 
        //reopen-notification for Operation Head
        if(!empty($maintenance_reopenList_OperationHead) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           $data .='<li><a  href="'.base_url('backoffice/view-maintenance-services').'">You have '.$maintenance_reopenList_OperationHead.' maintenance service reopen request notification<span class="notification_time"></span></a></li>
                    ';
        }
   
         //approved-by director notification for Centre Head
        if(!empty($maintenance_approvedby_Director) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead" )) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($maintenance_approvedby_Director as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                    $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/maintenance-services').'">The maintenance service request of '.$row['description'].' has been approved <span class="notification_time"></span></a></li>';
                }
            }
                    
        }
     //approved-by director notification for operation head
        if(!empty($maintenance_approvedby_Director) && ($this->session->userdata('role') == "admin"  || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($maintenance_approvedby_Director as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                    $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/view-maintenance-services').'">The  maintenance service request of '.$row['description'].' has been approved <span class="notification_time"></span></a></li>';
                }
            }
        }
    //approved-by operation head notification for Centre Head
        if(!empty($maintenance_approvedby_operationHead) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($maintenance_approvedby_operationHead as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                    $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/maintenance-services').'">The  maintenance service request of '.$row['description'].' has been approved <span class="notification_time"></span></a></li>';  
                }
            }
        } 
    //completed-notification for Centre Head
        if(!empty($completed_details) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
            foreach($completed_details as $row)
            {
             $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$row['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                  $data .='<li onclick="return read_by('.$this->session->userdata['user_id'].','.$row['notf_id'].')"><a  href="'.base_url('backoffice/maintenance-services').'">The maintenance service of         '.$row['description'].' has been completed.<span class="notification_time"></span></a></li>
                    ';   
                }
               
            }
           
        }
    //declined-by director notification for Centre Head
        if(!empty($declined_details) && ($this->session->userdata('role') == "admin" || $this->session->userdata('role') == "centerhead" )) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           foreach($declined_details as $rows)
            {
               $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$rows['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                  $data .='<li  onclick="return read_by('.$this->session->userdata['user_id'].','.$rows['notf_id'].')"><a href="'.base_url('backoffice/maintenance-services').'" >The maintenance service of '.$rows['description'].' has been declined.<span class="notification_time"></span></a></li>
                        '; 
                }
               
            }
        }
     //declined-by director notification for operation head
        if(!empty($declined_details) && ($this->session->userdata('role') == "admin"  || $this->session->userdata('role') == "operationhead")) {
           $empty = 1;
           $icon = '<img src="'.base_url().'inner_assets/images/notificcationactive.png" class="img-responsive">';
           foreach($declined_details as $rows)
            {
               $check=$this->common->check_if_dataExist('am_notification',array("notification_id"=>$rows['notf_id'],"read_by"=>$this->session->userdata['user_id']));
                if($check <= 0)
                {
                  $data .='<li  onclick="return read_by('.$this->session->userdata['user_id'].','.$rows['notf_id'].')"><a href="'.base_url('backoffice/maintenance-services').'" >The maintenance service of '.$rows['description'].' has been declined.<span class="notification_time"></span></a></li>
                        ';  
                }
              
            }
        }

        if($empty == 0) {
           $data = '<li class="text-center">No notification</li>';
        }


        $html .= $data;
        $html .='</ul></div>
                    </div>
                </div><script>$(document).ready(function(){$(".sb-container").scrollBox();
});</script>';
       print_r(json_encode(array('icon'=>$icon,'data'=>$html)));

    }
    
    public function fetch()
    {
        
        $query= $this->db->get_where('am_staff_personal',array("role"=>'5'));
        $this->data['courseArr']=$this->call_center_model->getall_list();
        $output = '';
        $filter_name = '';
        $filter_course = '';
        $filter_number = '';
        $filter_status = '';
        $filter_sdate = '';
        $filter_edate = '';
        $filter_enquiry = '';
        $filter_place = '';
        $filter_rand_num = '';
        $filter_cce = '';

        $filter_name = $this->input->post('filter_name');
        $filter_course = $this->input->post('filter_course');
        $filter_number = $this->input->post('filter_number');
        $filter_status = $this->input->post('filter_status');
        $filter_sdate = $this->input->post('filter_sdate');
        $filter_edate = $this->input->post('filter_edate');
        $filter_enquiry = $this->input->post('filter_enquiry');
        $filter_place = $this->input->post('filter_place');
        $filter_rand_num = $this->input->post('filter_rand_num');
        $filter_cce = $this->input->post('filter_cce');
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role'); 
        $data = $this->call_center_model->fetch_data_reffered($filter_name,$filter_course,$filter_number,$filter_status,$filter_sdate,$filter_edate,$filter_enquiry,$filter_place,$filter_cce,$filter_rand_num,$user_id, $role);
        // echo $this->db->last_query();
        // echo '<pre>';
        // print_r($data);
        $output .= '
            <div class="table-responsive table_language" style="margin-top:15px;">        
                <table id="callcenter_table" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Reference Key</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Primary Contact</th>
                            <th>Assigned To</th>
                            <th>Enquiry Type</th>
                            <th>Timing</th>
                            <th>Action</th>
                        </tr>
                    </thead>
            ';
        if($data->num_rows() > 0){
            $i=1;
            foreach($data->result() as $row){
                if($row->timing== NULL){
                    $new_date = "";
                }else{
                    $date=strtotime($row->timing); 
                    $new_date = date("d/m/Y h:m A",$date);
                }
                    // if($row->call_status==1){
                    //     $selectData ='<option selected value="1">Call Received</option>
                    //             <option value="2">In Progress</option>
                    //             <option value="3">Closed</option>
                    //             <option value="4">Blacklisted</option>
                    //             <option value="5">Registered</option>
                    //             <option value="6">Admitted</option>';
                    // }else if($row->call_status==2){
                    //     $selectData = '<option selected value="2">In Progress</option>
                    //             <option value="1">Call Received</option>
                    //             <option value="3">Closed</option>
                    //             <option value="4">Blacklisted</option>
                    //             <option value="5">Registered</option>
                    //             <option value="6">Admitted</option>';
                    // }else if($row->call_status==3){
                    //     $selectData = '<option selected value="3">Closed</option>
                    //             <option value="1">Call Received</option>
                    //             <option value="2">In Progress</option>
                    //             <option value="4">Blacklisted</option>
                    //             <option value="5">Registered</option>
                    //             <option value="6">Admitted</option>';
                    // }else if($row->call_status==4){
                    //     $selectData = '<option selected value="4">Blacklisted</option>
                    //             <option value="1">Call Received</option>
                    //             <option value="2">In Progress</option>
                    //             <option value="3">Closed</option>
                    //             <option value="5">Registered</option>
                    //             <option value="6">Admitted</option>';
                    // }else if($row->call_status==5){
                    //     $selectData = '<option  value="4">Blacklisted</option>
                    //             <option value="1">Call Received</option>
                    //             <option value="2">In Progress</option>
                    //             <option value="3">Closed</option>
                    //             <option selected value="5">Registered</option>
                    //             <option value="6">Admitted</option>';
                    // }else if($row->call_status==6){
                    //     $selectData = '<option  value="4">Blacklisted</option>
                    //             <option value="1">Call Received</option>
                    //             <option value="2">In Progress</option>
                    //             <option value="3">Closed</option>
                    //             <option value="5">Registered</option>
                    //             <option selected value="6">Admitted</option>';    
                    // }else{
                    //     $selectData = '<option value="">Select Status</option>
                    //             <option value="1">Answered</option>
                    //             <option value="2">No Answer</option>
                    //             <option value="3">Busy</option>
                    //             <option value="4">Blacklisted</option>
                    //             <option value="5">Registered</option>
                    //             <option value="6">Admitted</option>';
                    // }
                $output .= '
                            <tr>
                            <td>'.$i.'</td>
                            <td>'.$row->rand_num.'</td>
                            <td> <a href ="" onclick="get_details('.$row->call_id.')" title="Click here to view the details" data-toggle="modal" data-target="#show" style="color:blue;cursor:pointer;"> '.$row->name.'</a></td>
                            <td>'.$row->class_name.'</td>
                            <td>'.$row->primary_mobile.'</td>
                            <td>'.$row->street.'</td>
                            <td>'.$row->enquiry_type.'</td>
                            <td>'.$row->timing.'</td>
                            
                            <td>
                            <button  type="button" class="btn btn-default option_btn " onclick="get_details('.$row->call_id.')" title="Click here to view the details" data-toggle="modal" data-target="#show">
                            <i class="fa fa-eye "></i>
                            </button>
                            <button type="button" title="Edit" class="btn btn-default option_btn add_new_btn " onclick="get_editdata('.$row->call_id.')">
                            <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn  " title="Delete" onclick="delete_call_centers('.$row->call_id.')">
                            <i class="fa fa-trash-o"></i>
                            </a>
                            <button type="button" class="btn btn-default option_btn add_new_btn view_btn btn_followup" data-toggle="modal" data-target="#follow_up1" onclick="get_follow_up_data('.$row->call_id.')">
                            Follow Up
                            </button>
                            </td>
                            </tr>';
                            $i++;
                        }
                $output .=' </table>
                </div>';
        }
        //  if($i!= 1){
        $output .= '<button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
                <i class="fa fa-upload"></i> Export
            </button>';
        //  }
        // else
        // {
        //     // $output .= '<span><b><center>Sorry!!! No data Found</center></b><span>';
        // }
        echo $output;
    }


    public function am_user($batch_id = NULL){
        if($batch_id!='') {
            $this->db->select('*');
            $this->db->from('am_students');
            $this->db->join('am_student_course_mapping', 'am_student_course_mapping.student_id = am_students.student_id');
            $this->db->where('am_student_course_mapping.batch_id', $batch_id);
            $this->db->order_by('am_students.student_id','asc');

            $query	=	$this->db->get();
            echo $this->db->last_query();
            $resultArr	=	array(); 
            if($query->num_rows() > 0)
            {
                $resultArr	=	$query->result();echo '<pre>';print_r($resultArr);
                $i =1; 
                foreach($resultArr as $result) {
                    echo $i.' = '.$result->student_id; echo '<br>';
                    $i++;
                }
            }
        }
    }

    public function get_countries(){
        $data = $this->db->get('countries')->result_array();
        print_r(json_encode($data));
    }

    public function get_states($country = 101){//Default India
        $data = $this->db->where('country_id',$country)->get('states')->result_array();
        print_r(json_encode($data));
    }

    public function get_cities($state = 19){//Default Kerala
        $data = $this->db->where('state_id',$state)->get('cities')->result_array();
        print_r(json_encode($data));
    }

}
