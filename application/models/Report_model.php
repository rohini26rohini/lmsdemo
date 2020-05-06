<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends Direction_Model {

    public function __construct() {
        parent::__construct();

    }
    
    public function load_staff_attendance($start_date,$end_date)
    {
        $this->db->select('am_staff_attendance.*,am_staff_personal.name,am_staff_personal.personal_id,am_roles.role_name');
        $this->db->from('am_staff_attendance'); 
        $this->db->join('am_staff_personal', 'am_staff_personal.personal_id=am_staff_attendance.staff_id');
        $this->db->join('am_roles', 'am_roles.role=am_staff_personal.role');
        $this->db->where(array('am_staff_personal.status'=> '1','am_staff_attendance.date>='=>$start_date,'am_staff_attendance.date<='=>$end_date));
        $this->db->order_by('am_staff_personal.name','asc'); 
		//$this->db->order_by('am_staff_attendance.date','asc'); 
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }
    
    public function view_staff_attendance($staff_id)
    {
        $this->db->select('am_staff_attendance.*');
        $this->db->from('am_staff_attendance'); 
        //$this->db->where(array("DATE_FORMAT(date,'%d')"=>date('M'),"am_staff_attendance.staff_id"=>$staff_id));
        $this->db->like('date', date('Y-m'));
        $this->db->where(array("am_staff_attendance.staff_id"=>$staff_id));
        $this->db->order_by('am_staff_attendance.date','asc'); 
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;
    }
    
    public function search_self_attendance($start_date,$end_date,$personal_id)
    {
        $this->db->select('am_staff_attendance.*');
        $this->db->from('am_staff_attendance'); 
        $this->db->where('date>=', $start_date);
        $this->db->where('date<=', $end_date);
        $this->db->where(array("am_staff_attendance.staff_id"=>$personal_id));
        $this->db->order_by('am_staff_attendance.date','asc'); 
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0)
        {
			$resultArr	=	$query->result_array();
		}

		return $resultArr;   
    }
    
    public function get_batch_schedule_report(){
        $this->db->select('am_schedules.*,am_syllabus_master_details.subject_master_id,am_batch_center_mapping.batch_id')
                    ->from('am_schedules')
                    ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                    ->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                    // ->where('schedule_type',2)
                    ->where('am_schedules.schedule_type',2)
                    ->order_by('am_schedules.schedule_date','desc')
                    ->order_by('am_schedules.schedule_start_time','desc');  
            $query	=	$this->db->get();
            $resultArr	=	array();
            if($query->num_rows() > 0) {
                $resultArr	=	$query->result_array();
            }
        return $resultArr;  
    }

    public function search_batch($where){
        $this->db->select('am_schedules.*,am_batch_center_mapping.batch_id,am_syllabus_master_details.subject_master_id')
                    ->from('am_schedules')
                    ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                    ->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_detail_id=am_schedules.module_id')
                    ->where($where)
                    ->where('am_schedules.schedule_type',2)
                    ->order_by('am_schedules.schedule_date','desc')
                    ->order_by('am_schedules.schedule_start_time','desc');  
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        return $resultArr;  
    }
    public function get_subject($batchId){
        $this->db->select('mm_subjects.*')
                    ->from('am_batch_center_mapping')
                    ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                    ->join('am_classes', 'am_classes.class_id=am_institute_course_mapping.course_master_id')
                    ->join('am_syllabus_master_details', 'am_syllabus_master_details.syllabus_master_id=am_classes.syllabus_id')
                    ->join('mm_subjects', 'mm_subjects.subject_id=am_syllabus_master_details.subject_master_id')
                    ->group_by('am_syllabus_master_details.subject_master_id')
                    ->where('am_batch_center_mapping.batch_id', $batchId)
                    ->where('mm_subjects.subject_type_id', 'Subject')
                    ->where('mm_subjects.subject_status', 1);
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($this->db->last_query());
        return $resultArr;  
    }

    public function get_faculty_schedule_report($where){
        $this->db->select('am_schedules.*,am_batch_center_mapping.batch_id,am_institute_master.institute_name')
                    ->from('am_schedules')
                    ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=am_schedules.schedule_link_id')
                    ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id=am_batch_center_mapping.institute_course_mapping_id')
                    ->join('am_institute_master', 'am_institute_master.institute_master_id=am_institute_course_mapping.institute_master_id')
                    ->where($where)
                    ->where('am_schedules.schedule_type',2)
                    // ->group_by('am_schedules.schedule_id')
                    ->order_by('am_schedules.schedule_date','desc')
                    ->order_by('am_schedules.schedule_start_time','desc');  
            $query	=	$this->db->get();
            $resultArr	=	array();
            if($query->num_rows() > 0) {
                $resultArr	=	$query->result_array();
            }
        return $resultArr;  
    }

    public function get_staff(){
        $this->db->select('am_staff_personal.*,countries.name as countryname');
        $this->db->from('am_staff_personal');
        $this->db->join('countries', 'countries.id = am_staff_personal.spouse_country');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id = am_staff_personal.user_id');
        $this->db->where('am_staff_personal.status', 1);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
        }
        return $resultArr;
    }
    public function get_staffSearch($where){
        $this->db->select('am_staff_personal.*,countries.name as countryname');
        $this->db->from('am_staff_personal');
        $this->db->join('countries', 'countries.id = am_staff_personal.spouse_country');
        $this->db->join('am_users_backoffice', 'am_users_backoffice.user_id = am_staff_personal.user_id');
        $this->db->where($where);
        $this->db->where('am_staff_personal.status', 1);
        $this->db->where('am_users_backoffice.user_status', 1);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();
        }
        return $resultArr;
    }

    public function get_exam_schedule_report(){
        $this->db->select('am_schedules.*,am_batch_center_mapping.batch_id,gm_exam_schedule.name as examName,gm_exam_schedule.status as st')
                    ->from('am_schedules')
                    ->join('gm_exam_schedule', 'gm_exam_schedule.id=am_schedules.schedule_link_id')
                    ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=gm_exam_schedule.batch_id')
                    // ->where('schedule_type',2)
                    ->where('am_schedules.schedule_type',1)
                    ->order_by('am_schedules.schedule_date','desc')
                    ->order_by('am_schedules.schedule_start_time','desc');  
            $query	=	$this->db->get();
            $resultArr	=	array();
            if($query->num_rows() > 0) {
                $resultArr	=	$query->result_array();
            }
        return $resultArr;  
    }
    public function search_exam($where){
        $this->db->select('am_schedules.*,am_batch_center_mapping.batch_id,gm_exam_schedule.name as examName,gm_exam_schedule.status as st')
                    ->from('am_schedules')
                    ->join('gm_exam_schedule', 'gm_exam_schedule.id=am_schedules.schedule_link_id')
                    ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=gm_exam_schedule.batch_id')
                    ->where($where)
                    ->where('am_schedules.schedule_type',1)
                    ->order_by('am_schedules.schedule_date','desc')
                    ->order_by('am_schedules.schedule_start_time','desc');  
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        return $resultArr;  
    }

    public function get_exam($batchId){
        $this->db->select('am_schedules.*,am_batch_center_mapping.batch_id,gm_exam_schedule.id as examId,gm_exam_schedule.name as examName,gm_exam_schedule.status as st')
                    ->from('am_schedules')
                    ->join('gm_exam_schedule', 'gm_exam_schedule.id=am_schedules.schedule_link_id')
                    ->join('am_batch_center_mapping', 'am_batch_center_mapping.batch_id=gm_exam_schedule.batch_id')
                    ->where('am_schedules.schedule_type',1)
                    ->where('gm_exam_schedule.status >=',4)
                    ->where('am_batch_center_mapping.batch_id',$batchId); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($resultArr);
        return $resultArr;  
    }

    // public function get_section($examId){
    //     $this->db->select('gm_exam_definition_exam_sections.exam_sections_id')
    //                 ->from('gm_exam_definition_exam_sections')
    //                 ->join('gm_exam_definition', 'gm_exam_definition.id= gm_exam_definition_exam_sections.exam_definition_id')
    //                 ->join('gm_exam_schedule', 'gm_exam_schedule.exam_definition_id=gm_exam_definition.id')
    //                 ->where('gm_exam_schedule.id',$examId); 
    //     $query	=	$this->db->get();
    //     $resultArr	=	$query->result_array();
    //     $sectionArr = array();
    //     if(!empty($resultArr)){
    //         foreach($resultArr as $key => $row){
    //             $sec = $this->db->select('gm_exam_section_config.section_name,gm_exam_section_config.id')
    //                         ->from('gm_exam_section_config')
    //                         ->where('gm_exam_section_config.id',$row['exam_sections_id'])->get()->row();
    //             $sectionArr[$key]['sectionId'] = $sec->id;
    //             $sectionArr[$key]['sectionName'] = $sec->section_name;
    //         }
    //     }
    //     // show($sectionArr);
    //     return $sectionArr;  
    // }

    public function get_atmt($examId){
        $this->db->select('gm_exam_result.attempt')
                ->from('gm_exam_result')
                ->where('gm_exam_result.exam_id',$examId)
                ->group_by('attempt'); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
        $resultArr	=	$query->result_array();
        }
        // show($resultArr);
        return $resultArr; 
    }

    public function get_sectionTH($examId){
        $this->db->select('gm_exam_definition_exam_sections.exam_sections_id')
            ->from('gm_exam_schedule')
            ->join('gm_exam_definition', 'gm_exam_definition.id= gm_exam_schedule.exam_definition_id')
            ->join('gm_exam_definition_exam_sections', 'gm_exam_definition_exam_sections.exam_definition_id=gm_exam_definition.id')
            ->where('gm_exam_schedule.id',$examId); 
        $query	=	$this->db->get();
        $resultArr	=	$query->result_array();
        $sectionArr = array();
        // show($resultArr);
        if(!empty($resultArr)){
            foreach($resultArr as $key => $row){
                $sec = $this->db->select('gm_exam_section_config.section_name,gm_exam_section_config.id')
                            ->from('gm_exam_section_config')
                            ->where('gm_exam_section_config.id',$row['exam_sections_id'])->get()->row();
                $sectionArr[$key]['sectionId'] = $sec->id;
                $sectionArr[$key]['sectionName'] = $sec->section_name;
            }
        }
        // show($sectionArr);
        return $sectionArr;  
    }

    public function search_section_mark($filter_exam, $section){
        $studentS = $this->db->select('student_id,exam_id,attempt')
                        ->where('exam_id', $filter_exam)
                        ->get('gm_exam_result_summary')->result_array();
        $nofStudents = count($studentS);
        if(!empty($studentS)){
            foreach($studentS as $key=>$std){
                $total = 0;
                foreach($section as $j=>$sec){
                    $posneg = $this->db->select('SUM(negative_mark) as nm,SUM(mark) as pm,secton_id')
                            ->where('student_id',$std['student_id'])
                            ->where('attempt',$std['attempt'])
                            ->where('secton_id',$sec['sectionId'])
                            ->get('gm_exam_result')->result_array();
                            // show($this->db->last_query());
                    if(!empty($posneg)){
                        $secTotal = 0;
                        foreach($posneg as $k=>$pos){
                            $nm = $pos['nm'];
                            $pm = $pos['pm'];
                            // if($nm>$pm){
                            //     $secTotal=$nm-$pm;
                            // }else{
                                $secTotal=$pm-$nm;
                            // }
                           
                        }
                        $studentS[$key][$sec['sectionName']] =$secTotal;
                        //$sectionArr[$j][$sec['sectionName']] = $secTotal;
                    }else{
                        $studentS[$key][$sec['sectionName']] =0;
                        //$sectionArr[$j][$sec['sectionName']] = 0;
                    }
                    $total +=  $secTotal;
                }
                $examTotalMark = $this->common->get_persentage($section);
                if($examTotalMark > 0){
                    $pg = ($total/$examTotalMark)*100;
                    $studentS[$key]['percentage'] =number_format($pg,2);
                }else{
                    $studentS[$key]['percentage'] = 0.00;
                }
                $studentS[$key]['total'] =$total;
                $percentile = $this->common->get_persentail($filter_exam);
                if($percentile > 0){
                    $pr = ($total/$percentile)*100;
                    $studentS[$key]['per'] = number_format($pr,2);
                }else{
                    $studentS[$key]['per'] = 0.00;
                }
            }
        }
        return $studentS;  
    }

    public function get_cource($centreId){
        $this->db->select('am_classes.*,')
                    ->from('am_classes')
                    ->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id=am_classes.class_id')
                    ->where('am_classes.status',1)
                    ->where('am_institute_course_mapping.institute_master_id',$centreId)
                    ->where('am_institute_course_mapping.status',1); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($resultArr);
        return $resultArr;  
    }

    public function get_batch($courseId){
        $this->db->select('am_batch_center_mapping.*')
                    ->from('am_batch_center_mapping')
                    ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
                    ->where('am_institute_course_mapping.course_master_id',$courseId)
                    ->where('am_batch_center_mapping.batch_status',1); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($resultArr);
        return $resultArr;  
    }

    // public function search_centre($where,$courseorbatch){
    //     if($courseorbatch == 0){
    //         $this->db->select('am_classes.class_name, am_institute_course_mapping.institute_course_mapping_id')
    //                     ->from('am_classes')
    //                     ->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id=am_classes.class_id')
    //                     ->where($where)
    //                     ->where('am_classes.status',1); 
    //         $query	=	$this->db->get();
    //     }else if($courseorbatch == 1){
    //         $this->db->select('am_batch_center_mapping.batch_name,am_batch_center_mapping.batch_id')
    //                     ->from('am_batch_center_mapping')
    //                     ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
    //                     ->where($where)
    //                     ->where('am_batch_center_mapping.batch_status',1); 
    //         $query	=	$this->db->get();
    //     }
    //     $resultArr	=	array();
    //     if($query->num_rows() > 0) {
    //         $resultArr	=	$query->result_array();
    //     }

    //     foreach($resultArr as $key=>$row){
    //         if($courseorbatch == 0){
    //             $totalSum = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])->get()->row()->sum;
    //             $resultArr[$key]['total_fee_collected'] = $totalSum;
    //             $totalCash = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])
    //                     ->where('paymentmode', 'Cash')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Cash'] = $totalCash;
    //             $totalCard = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])
    //                     ->where('paymentmode', 'Card')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Card'] = $totalCard;
    //             $totalCheque = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])
    //                     ->where('paymentmode', 'Cheque')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Cheque'] = $totalCheque;
    //             $totalOnline = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])
    //                     ->where('paymentmode', 'Online')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Online'] = $totalOnline;
    //         }else if($courseorbatch == 1){
    //             $totalSum = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('batch_id', $row['batch_id'])->get()->row()->sum;
    //             $resultArr[$key]['total_fee_collected'] = $totalSum;
    //             $totalCash = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('batch_id', $row['batch_id'])
    //                     ->where('paymentmode', 'Cash')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Cash'] = $totalCash;
    //             $totalCard = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('batch_id', $row['batch_id'])
    //                     ->where('paymentmode', 'Card')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Card'] = $totalCard;
    //             $totalCheque = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('batch_id', $row['batch_id'])
    //                     ->where('paymentmode', 'Cheque')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Cheque'] = $totalCheque;
    //             $totalOnline = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
    //                     ->where('batch_id', $row['batch_id'])
    //                     ->where('paymentmode', 'Online')
    //                     ->get()->row()->sum;
    //             $resultArr[$key]['Online'] = $totalOnline;
    //         }
    //     }
    //     // show($resultArr);
    //     return $resultArr;  
    // }

    public function search_centre($where,$courseorbatch){
        if($courseorbatch == 0){
            $this->db->select('am_classes.class_name, am_institute_course_mapping.institute_course_mapping_id')
                        ->from('am_classes')
                        ->join('am_institute_course_mapping', 'am_institute_course_mapping.course_master_id=am_classes.class_id')
                        ->where($where)
                        ->where('am_classes.status',1); 
            $query	=	$this->db->get();
        }else if($courseorbatch == 1){
            $this->db->select('am_batch_center_mapping.batch_name,am_batch_center_mapping.batch_id')
                        ->from('am_batch_center_mapping')
                        ->join('am_institute_course_mapping', 'am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id')
                        ->where($where)
                        ->where('am_batch_center_mapping.batch_status',1); 
            $query	=	$this->db->get();
        }
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($resultArr);
        foreach($resultArr as $key=>$row){
            if($courseorbatch == 0){
                $totalSum = $this->db->select('payment_id')->from('pp_student_payment')
                                    ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])->get()->result_array();
                $total = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
                                    ->where('institute_course_mapping_id', $row['institute_course_mapping_id'])->get()->row()->sum;
                $resultArr[$key]['total_fee_collected'] = $total;
            }else if($courseorbatch == 1) {
                $totalSum = $this->db->select('payment_id')->from('pp_student_payment')
                                    ->where('batch_id', $row['batch_id'])->get()->result_array();
                $total = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
                                    ->where('batch_id', $row['batch_id'])->get()->row()->sum;
                $resultArr[$key]['total_fee_collected'] = $total;
            }
            $paymentIds = [];
            foreach($totalSum as $id){
                array_push($paymentIds,$id['payment_id']);
            }
            // show($paymentIds);
            if(!empty($paymentIds)){

                // Cash total
                
                $cashTotal = 0;
                $totalCashInstallment = $this->db->select('sum(installment_paid_amount) as sum')->from('pp_student_payment_installment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Cash')
                    ->get()->row()->sum;
                    
                $totalCashSplit = $this->db->select('sum(split_amount) as sum')->from('pp_student_payment_split')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Cash')
                    ->get()->row()->sum;
                
                $totalCashOnetime = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('payment_type', 'onetime')
                    ->where('paymentmode', 'Cash')
                    ->get()->row()->sum;

                $cashTotal = $totalCashInstallment + $totalCashSplit + $totalCashOnetime;
                $resultArr[$key]['Cash'] = $cashTotal;

                // Card total

                $cardTotal = 0;
                $totalCardInstallment = $this->db->select('sum(installment_paid_amount) as sum')->from('pp_student_payment_installment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Card')
                    ->get()->row()->sum;

                $totalCardSplit = $this->db->select('sum(split_amount) as sum')->from('pp_student_payment_split')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Card')
                    ->get()->row()->sum;

                $totalCardOnetime = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('payment_type', 'onetime')
                    ->where('paymentmode', 'Card')
                    ->get()->row()->sum;
                    
                $cardTotal = $totalCardInstallment + $totalCardSplit + $totalCardOnetime;
                $resultArr[$key]['Card'] = $cardTotal;

                // Cheque total

                $chequeTotal = 0;
                $totalChequeInstallment = $this->db->select('sum(installment_paid_amount) as sum')->from('pp_student_payment_installment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Cheque')
                    ->get()->row()->sum;

                $totalChequeSplit = $this->db->select('sum(split_amount) as sum')->from('pp_student_payment_split')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Cheque')
                    ->get()->row()->sum;
                    
                $totalCashOnetime = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('payment_type', 'onetime')
                    ->where('paymentmode', 'Cheque')
                    ->get()->row()->sum;
                        
                $chequeTotal = $totalChequeInstallment + $totalChequeSplit + $totalCashOnetime;
                $resultArr[$key]['Cheque'] = $chequeTotal;

                // Online total

                $onlineTotal = 0;
                $totalOnlineInstallment = $this->db->select('sum(installment_paid_amount) as sum')->from('pp_student_payment_installment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Online')
                    ->get()->row()->sum;

                $totalOnlineSplit = $this->db->select('sum(split_amount) as sum')->from('pp_student_payment_split')
                    ->where_in('payment_id', $paymentIds)
                    ->where('paid_payment_mode', 'Online')
                    ->get()->row()->sum;

                $totalOnlineOnetime = $this->db->select('sum(paid_amount) as sum')->from('pp_student_payment')
                    ->where_in('payment_id', $paymentIds)
                    ->where('payment_type', 'onetime')
                    ->where('paymentmode', 'Online')
                    ->get()->row()->sum;

                $onlineTotal = $totalOnlineInstallment + $totalOnlineSplit + $totalOnlineOnetime;
                $resultArr[$key]['Online'] = $onlineTotal;

            }else{
                $resultArr[$key]['Cash'] = 0;
                $resultArr[$key]['Card'] = 0;
                $resultArr[$key]['Cheque'] = 0;
                $resultArr[$key]['Online'] = 0;
            }
        }
        // show($resultArr);
        return $resultArr;  
    }

    public function get_student($batchId){
        $this->db->select('am_students.student_id,am_students.name,am_students.registration_number')
                    ->from('am_students')
                    ->join('am_student_course_mapping', 'am_student_course_mapping.student_id=am_students.student_id')
                    ->where('am_student_course_mapping.status',1)
                    ->where('am_student_course_mapping.batch_id',$batchId); 
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($resultArr);
        return $resultArr;  
    }

    public function get_student_attendance_report($where, $att_type){
        if($att_type == 'class'){
            $this->db->select('am_students.name,am_schedules.module_id,am_attendance.attendance,am_schedules.staff_id,am_attendance.att_date,
                            am_attendance.type, am_schedules.schedule_type,am_attendance.batch_id')
                    ->from('am_attendance')
                    ->join('am_students', 'am_students.student_id=am_attendance.student_id')
                    ->join('am_schedules', 'am_schedules.schedule_id=am_attendance.schedule_id')
                    //->join('gm_exam_schedule', 'gm_exam_schedule.id=am_schedules.schedule_link_id')
                    ->where($where); 
        }if($att_type == 'exam'){
            $this->db->select('am_students.name,am_attendance.attendance,am_attendance.att_date,
                            am_attendance.type,am_attendance.batch_id,gm_exam_schedule.name as examName')
                    ->from('am_attendance')
                    ->join('am_students', 'am_students.student_id=am_attendance.student_id')
                    ->join('gm_exam_schedule', 'gm_exam_schedule.id=am_attendance.schedule_id')
                    // ->join('am_schedules', 'am_schedules.schedule_id=am_attendance.schedule_id')
                    ->where($where); 
        }
        $query	=	$this->db->get();
        $resultArr	=	array();
        if($query->num_rows() > 0) {
            $resultArr	=	$query->result_array();
        }
        // show($this->db->last_query());
        return $resultArr;  
    }

    // public function get_student_attendance_report($where){
    //     $this->db->query('am_students.name,am_attendance.attendance,am_attendance.att_date,
    //                         am_attendance.type, gm_exam_schedule.name as examName, am_attendance.batch_id')
    //                 ->from('am_attendance')
    //                 // ->join('am_students', 'am_students.student_id=am_attendance.student_id')
    //                 // ->join('am_schedules', 'am_schedules.schedule_id=am_attendance.schedule_id')
    //                 // ->join('gm_exam_schedule', 'gm_exam_schedule.id=am_schedules.schedule_link_id')
    //                 ->where($where); 
    //     $query	=	$this->db->get();
    //     $resultArr	=	array();
    //     if($query->num_rows() > 0) {
    //         $resultArr	=	$query->result_array();
    //     }
    //     show($this->db->last_query());
    //     return $resultArr;  
    // }

    public function get_application_logcount() {
        return $this->db->count_all('am_log');
    }


    public function get_application_log($limit, $start){
        $this->db->select('*');
        $this->db->from('am_log');
        $this->db->order_by('log_id', 'desc');
        $this->db->limit($limit, $start);
	    $query	=	$this->db->get();
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result();
        }
        return $resultArr;
    }


}
?>
