<?php

function logcreator($action = NULL, $objecttype = NULL, $who = NULL, $what = NULL, $table_row_id = NULL, $table = NULL, $message = NULL, $new = NULL) {
    $data = array('log_action'=>$action,
                  'log_objecttype'=>$objecttype,
                  'log_who'=>$who,
                  'log_old'=>$what,
                  'log_new'=>$new,
                  'log_table_row_id'=>$table_row_id,
                  'log_table'=>$table,
                  'log_message'=>$message
                  );
    $CI = get_instance();
    $CI->load->model('Log_model');
    $CI->Log_model->log($data);
}

function user_dashboards(){
    $CI = get_instance();
    $role = $CI->session->userdata('role');
    if($role == 'users'){
        redirect(base_url('pay-fee'));
    } 
    if($role == 'student'){
        redirect(base_url('student-dashboard'));
    } 
    if($role == 'parent'){
        redirect(base_url('parent-dashboard'));
    } 
//     if($role == 'others')
//    {
//        redirect(base_url('employee')); 
//    } 
    if($role == 'others' || 
        $role == 'receptionist' || 
       $role == 'management' || 
        $role == 'operationhead' || 
        $role == 'centerhead' || 
        $role == 'hr' || 
        $role == 'coursecoordinator' || 
       $role == 'mmh' ||
       $role == 'mc' ||
       $role == 'accountant' ||
       $role == 'operationexcutive' ||
       $role == 'hostelwarden' ||
       $role == 'driver' ||
       $role == 'branchhead' ||
       $role == 'Schedule Coordinator' ||
       $role == 'operationmaintenanceexecutive' ||
       $role == 'JRFACULTY-COORDINATOR-QA' ||
       $role == 'PROJECT-HEAD-RD' ||
       $role == 'BRANCH-IN-CHARGE-HO-SENIOR-EXECUTIVE-HOSTEL' ||
       $role == 'HEAD-DEPT-OF-ENGLISH' ||
       $role == 'MATERIAL-COORDINATOR-JUNIOR-FACULTY' ||
       $role == 'BATCH-COORDINATOR' ||
       $role == 'MANAGER-ADMISSIONS' ||
       $role == 'DATA-ENTRY-ASSISTANT' ||
       $role == 'LIBRARIAN-CUM-SUPERVISOR' ||
       $role == 'SUPERVISOR-DATA-ENTRY' ||
       $role == 'ACADEMIC-COORDINATOR' ||
       $role == 'OFFICE-ASSISTANT-PRINTING' ||
       $role == 'DATA-ENTRY-OPERATOR' ||
       $role == 'ACCOUNTS-ASSOCIATE' ||
       $role == 'IT-ADMIN' ||
       $role == 'DEPUTY-MANAGER-BD' ||
       $role == 'PART-TIME-MATERIAL-COORDINATOR-JUNIOR-FACULTY' ||
       $role == 'HEAD-IT' ||
       $role == 'CHIEF-OPERATING-OFFICER' ||
       $role == 'ACADEMIC-COORDINATOR-IAS-STUDY-CIRCLE' ||
       $role == 'ACADEMIC-COORDIANTOR-DIFP' ||
       $role == 'COURSE-DIRECTOR-IAS-STUDY-CIRCLE' ||
       $role == 'JUNIOR-HR-ASSOCIATE' ||
       $role == 'ADMISSION-DESK-STAFF' ||
       $role == 'TRAINEE-RECEPTION-AND-ADMISSION' ||
       $role == 'MANAGER-MARKET-RESEARCH' ||
       $role == 'MANAGER-CALL-CENTRE' ||
       $role == 'BD-ADVISOR' ||
       $role == 'ASST-HR-MANAGER' ||
       $role == 'ASSISTANT-MANAGER-OPERATIONS' ||
       $role == 'OPERATIONS-ASSISTANT' ||
       $role == 'CAT-COORDINATOR' ||
       $role == 'TRAINEEBATCHCOORDINATOR' ||
       $role == 'TEACHINGMATERIALPREPARATIONFORJAM/UGC' ||
       $role == 'JRSYSTEMADMIN' ||
       $role == 'ACADEMICHEAD' ||
       $role == 'PRINTINGASSISTANTONCONTRACT' ||
       $role == 'MARKETINGJRDIGITALMARKETING' ||
       $role == 'ACADEMICCOUNSELORCUMSRCALLCENTREASSOCIATE' ||
       $role == 'ARIASFACULTY' ||
       $role == 'SRBATCHCOORDINATOR' ||
       $role == 'DTPOPERATOR' ||
       $role == 'ACADEMICCOORDINATORIASSTUDYCIRCLEKAS' ||
       $role == 'MATERIALASSISTANTKAS' ||
       $role == 'TRAINEEDTPOPERATOR' ||
       $role == 'GRAPHICDESIGNER' ||
       $role == 'ASSTMANAGERMATERIALSINCHARGE' ||
       $role == 'DTPOPERATORDESIGNER' ||
       $role == 'PARTTIMEBATCHCOORDINATORONLINEPROJECTPREPARATION' ||
       $role == 'MATERIALREPARATIONFORNETPHYSICS' ||
       $role == 'HEADDEPTOFPHYSICS' ||
       $role == 'DIRECTOROFIASSTUDYCIRCLE' ||
       $role == 'FACULTY-IAS-KAS-MATERIAL-PREPARATION' ||
       $role == 'CHIEF-DEVELOPMENT-OFFICER' ||
       $role == 'MD' ||
       $role == 'CHAIRMAN' ||
       $role == 'ADMISSION-DESK-CUM-BATCH-COORDINATOR' ||
       $role == 'IT-SYSTEM-ASSSOCIATE' ||
       $role == 'SR-ASSOCIATE-OPERATIONS' ||
        $role == 'faculty')
        {
            redirect(base_url('employee')); 
        }  
    // if($role == 'receptionist'){
    //     redirect(base_url('Receptionist')); 
    // }
    // if($role == 'operationhead'){
    //     redirect(base_url('Operation-head')); 
    // }
    // if($role == 'coursecoordinator'){
    //     redirect(base_url('Course-coordinator'));
    // }
    // if($role == 'centerhead'){
    //     redirect(base_url('Center-head'));
    // }
    // if($role == 'others'){
    //     redirect(base_url('Employee'));
    // }
}

function check_backoffice_permission($module=NULL){
    $CI = get_instance();
    if(NULL !== $CI->session->userdata('logedin') && $CI->session->userdata('logedin')){
        if(!$CI->session->userdata('backoffice_user')){
            user_dashboards();
        }
		if($module!=NULL){
			if(!check_module_permission($module)){
				redirect('404');
			}
		}
        return TRUE;
    }else{
        $data = array(
            "url" => current_url()
        );
        $CI->session->set_userdata($data);
        redirect(base_url('backoffice/login'));
    }
}

function check_module_permission($module){
    $CI = get_instance();
    $module_status = $CI->db->where('status',1)->where('module',$module)->get('am_backoffice_modules')->num_rows();
    if($module_status==0){
        return FALSE;
    }
    if(NULL !== $CI->session->userdata('logedin') && $CI->session->userdata('logedin')){
        if($CI->session->userdata('role')=='admin'){
            return TRUE;
        }else{
            $role_modules = $CI->session->userdata('permission');
			if(!empty($role_modules)){
				if(in_array($module,$role_modules)){
					return TRUE;
				}else{
					return FALSE;
				}
			}else{
				return FALSE;
			}
        }
    }else{
        return FALSE;
    }
}

function check_user_management_permission($module_id, $role_id){
    if($module_id == 20){
        if($role_id != 8){
            return false;
        }
    }
    
    if($module_id == 21){
        if($role_id != 1){
            return false;
        }
    }
    return true;
}


function batchcodegeneration($coursemapp_id, $mode) {
    $CI = get_instance();
    $CI->load->model('Batch_model');
    $coursedet = $CI->Batch_model->courseandschool($coursemapp_id);// print_r($coursedet);
    $modedetails = $CI->Batch_model->get_mode_id($mode); //print_r($modedetails);
    //$batchcode = 'DS'.$coursedet['school_code'].$modedetails['mode_code'].date('m').date('y').'-01';
    $batchcode = 'DS'.$coursedet['school_code'].$modedetails['mode_code'].date('m').date('y');
    return $batchcode;
}  

function generate_userid($student_id)
{
    $CI = get_instance();
    $numlength = strlen((string)$student_id);
        $total_length=4-$numlength;
        $code="";
        for($i=0;$i<=$total_length;$i++)
        {
           $code.=0; 
        }
        
         $generate_num=$code.$student_id;
         $serial_num="D00".$generate_num;
         return $serial_num;
}

function generate_staffid($personal_id)
{
    $CI = get_instance();
    $numlength = strlen((string)$personal_id);
        $total_length=4-$numlength;
        $code="";
        for($i=0;$i<=$total_length;$i++)
        {
           $code.=0; 
        }
        
         $generate_num=$code.$personal_id;
         $serial_num="DE00".$generate_num;
         return $serial_num;
}

function generate_ccid($call_id)
{
    $CI = get_instance();
    $numlength = strlen((string)$call_id);
        $total_length=4-$numlength;
        $code="";
        for($i=0;$i<=$total_length;$i++)
        {
           $code.=0; 
        }
        
         $generate_num=$code.$call_id;
         $serial_num="CC00".$generate_num;
         return $serial_num;
}

function alphabets(){
    return array( 'a', 'b', 'c', 'd', 'e',
                    'f', 'g', 'h', 'i', 'j',
                    'k', 'l', 'm', 'n', 'o',
                    'p', 'q', 'r', 's', 't',
                    'u', 'v', 'w', 'x', 'y',
                    'z'
                    );
}

function get_question_difficulty($id=2){
    $difficulty[1] = 'Easy';
    $difficulty[2] = 'Medium';
    $difficulty[3] = 'Hard';
    return $difficulty[$id];
}

function numberformat($amount = 0) {
    return 'INR '.number_format($amount, 2);
}

function numberformatwithout($amount = 0) {
    return number_format($amount, 2);
}

function numberformatwithoutcomma($amount = 0) {
    return number_format($amount, 2, '.', '');
}

function roundoff($value = 0) {
    if(preg_match('/./',$value)) {
    return number_format($value, 2);
    } else {
      return $value;  
    }
}

function limit_html_string($text, $limit) {
    $text = strip_tags($text);
    if (strlen($text) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        if(sizeof($pos) >$limit)
        {
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    return $text;
}


function get_interval_in_month($from, $to) {
    $fromYear = date("Y", strtotime($from));
        $fromMonth = date("m", strtotime($from));
        $toYear = date("Y", strtotime($to));
        $toMonth = date("m", strtotime($to));
        if ($fromYear == $toYear) {
            return ($toMonth-$fromMonth)+1;
        } else {
            return (12-$fromMonth)+1+$toMonth;
        }
}


function taxcalculation ($taxable, $config, $nontaxable) {
	$sgstval = $config['SGST'];
    $cgstval = $config['CGST'];
    $cessval = $config['cess_value'];
	$sgstper = $taxable*$sgstval;
	$sgst	 = $sgstper/100;
	$cgstper = $taxable*$cgstval;
    $cgst	 = $cgstper/100;
    $cess    = 0;
    if($config['cess']==1) {
    $cessper = $taxable*$cessval;
    $cess	 = $cessper/100;
    }
	$grandtotal = $taxable+$sgst+$cgst+$cess;
	$resultArr['totalFee'] 	= $taxable+$nontaxable;
	$resultArr['totalAmt'] 	= $grandtotal+$nontaxable;
	$resultArr['sgst'] 		= $sgst;
    $resultArr['cgst'] 		= $cgst;
    $resultArr['cess'] 		= $cess;
	return $resultArr;
	
}


function gstcalculation ($taxable, $sgst = NULL, $cgst = NULL) {
    $gst = $sgst+$cgst;
    if($gst>0) {
	$gstper = $taxable*$gst;
	$gstAmt	 = $gstper/100;
    $result 		= $gstAmt;
    } else {
    $result 		= 0;    
    }
	return $result;
	
}

function numberTowords2222($num)
{

$ones = array(
0 =>"ZERO",
1 => "ONE",
2 => "TWO",
3 => "THREE",
4 => "FOUR",
5 => "FIVE",
6 => "SIX",
7 => "SEVEN",
8 => "EIGHT",
9 => "NINE",
10 => "TEN",
11 => "ELEVEN",
12 => "TWELVE",
13 => "THIRTEEN",
14 => "FOURTEEN",
15 => "FIFTEEN",
16 => "SIXTEEN",
17 => "SEVENTEEN",
18 => "EIGHTEEN",
19 => "NINETEEN",
"014" => "FOURTEEN"
);
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){
$rettxt .= " and ";
if($decnum < 20){
$rettxt .= $ones[$decnum];
}elseif($decnum < 100){
$rettxt .= $tens[substr($decnum,0,1)];
$rettxt .= " ".$ones[substr($decnum,1,1)];
}
}
return $rettxt;
}

function numberTowords1111($num)
{ 
error_reporting(0);    
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
$rettxt .= " and "; 
if($decnum < 20){ 
$rettxt .= $ones[$decnum]; 
}elseif($decnum < 100){ 
$rettxt .= $tens[substr($decnum,0,1)]; 
$rettxt .= " ".$ones[substr($decnum,1,1)]; 
} 
} 
return $rettxt; 
}


function installmentsequence($install = NULL) {
    $word = array(1=>'st',
                    2=>'nd',
                    3=>'rd',
                    4=>'th'
                    );
    if($install>3){
        return $install.$word[4];
    } else {
        return $install.$word[$install]; 
    }
}



function show($data){
    echo '<pre>';print_r($data);exit;
}

function SaveViaTempFile($objWriter){
    // $filePath = '' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
    $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
    $objWriter->save($filePath);
    readfile($filePath);
    unlink($filePath);
    exit;
}

function get_table_html_tr($data){
    $html = '<tr>';
    if(!empty($data)){
        foreach($data as $row){
            $html .= '<td>'.$row.'</td>';
        }
    }
    $html .= '</tr>';
    return $html;
}


function convert_excel_date($x){
    if((date('d-m-Y', strtotime($x)) != $x)){
        // print_r($x);
        $x =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($x);
        $x = $x->format('d-m-Y');
    }
    return date('Y-m-d', strtotime($x));
}

function get_excel_column_number($column){
    $alphabets = range('A', 'Z');
    $chars = strlen($column);
    return (26*($chars-1)) + array_search(substr($column,-1), $alphabets) + 1;
}

function send_sms_new($number,$message){
    $username="DIRECTION";
	$Password="dir@2006";
	$sender='BSHSMS';
	$priority='ndnd';
	$stype='normal';
    $message=urlencode($message);
    // $var = "user=".$username."&pass=".$Password."&sender=".$sender."&phone=".$number."&text=".$message."&priority=".$priority."&stype=".$stype."";
    // $url = 'http://bhashsms.com/api/sendmsg.php?'.$var;
    // $curl = curl_init($url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    // $response = curl_exec($curl);
    // curl_close($curl);
    // if($_SERVER['HTTP_HOST']=='www.direction.school'){
    // return $response;
    // }
    $url = array(
        'user'=>"DIRECTION",
        'pass'=>"dir@2006",
        'sender'=>"BSHSMS",
        'phone'=>$number,
        'text'=>urlencode($message),
        'priority'=>"ndnd",
        'stype'=>"normal"
    );
    $request['type'] = 'GET';
    $request['url'] = 'http://bhashsms.com/api/sendmsg.php?'.http_build_query($url);
    show(call_api($request));
    if($_SERVER['HTTP_HOST']=='www.direction.school'){call_api($request);}
    return true;
}

function send_sms($mob_number,$message){
    $url = array(
        'APIKey'=>'n65lE5ia6keSRlBUiPBaJA',
        'senderid'=>'DIRCTN',
        'channel'=>1,
        'DCS'=>0,
        'flashsms'=>0,
        'number'=>$mob_number,
        'text'=>$message,
        'route'=>1
    );
    $request['type'] = 'GET';
    $request['url'] = 'http://sms.qzion.com/api/mt/SendSMS?'.http_build_query($url);
    if($_SERVER['HTTP_HOST']=='www.direction.school'){call_api($request);}
    return true;
}

function get_month_between_dates($date1,$date2){
    $startMonth = date('m',strtotime($date1));
    $startYear = date('Y',strtotime($date1));
    $endMonth = date('m',strtotime($date2));
    $endYear = date('Y',strtotime($date2));
    $data = array();
    $key = 0;
    for($i=$startYear;$i<=$endYear;$i++){
        $startItemMonth = 1;
        $endItemMonth = 12;
        if($i == $startYear){
            $startItemMonth = $startMonth;
        }
        if($i == $endYear){
            $endItemMonth = $endMonth;
        }
        for($j=$startItemMonth;$j<=$endItemMonth;$j++){
            $key++;
            $data[$key]['date'] = date('Y-m-d',strtotime($i."-".$j."-01"));
            $data[$key]['year'] = date('Y',strtotime($i."-".$j."-01"));
            $data[$key]['month'] = date('m',strtotime($i."-".$j."-01"));
        }
    }
    return $data;
}


function get_remaining_days($start = NULL, $end = NULL, $cnt = NULL, $year = NULL, $month = NULL, $amount = NULL) {
    $timestamp      = strtotime($start);
    $monthdays = (int)date('t', strtotime($year.'-'.$month.'-01'));
    $perday    = 0 ;
    if($amount>0) {
        $perday = $amount/$monthdays;
    }
    $daysRemaining  = (int)date('t', $timestamp) - (int)date('j', $timestamp);
    $monthstart     = date('m', strtotime($start)); 
    $monthend       = date('m', strtotime($end));
    $days = 0;
    if($cnt==1) {
        $days       = $daysRemaining+1;    
    } else {
        $date1      = strtotime($year.'-'.$month.'-01');
        $date2      = strtotime($end);  
        $diff       = abs($date2 - $date1); 
        $years      = floor($diff / (365*60*60*24));
        $months     = floor(($diff - $years * 365*60*60*24) 
                                    / (30*60*60*24));
        if($months==1) {
            $days = (int)date('t', strtotime($year.'-'.$month.'-01'));
        } else {                            
        $days       = floor(($diff - $years * 365*60*60*24 -  
                    $months*30*60*60*24)/ (60*60*24)); 
        }
    }
    // if($monthstart == $monthend) {
    //     $date1      = strtotime($start);
    //     $date2      = strtotime($end);  
    //     $diff       = abs($date2 - $date1); 
    //     $years      = floor($diff / (365*60*60*24));
    //     $months     = floor(($diff - $years * 365*60*60*24) 
    //                                 / (30*60*60*24));
    //                                 echo '333-'.$days       = floor(($diff - $years * 365*60*60*24 -  
    //                 $months*30*60*60*24)/ (60*60*24)); 
    //     $hours      = floor(($diff - $years * 365*60*60*24  
    //                     - $months*30*60*60*24 - $days*60*60*24) 
    //                                     / (60*60));
    //     $minutes    = floor(($diff - $years * 365*60*60*24  
    //                     - $months*30*60*60*24 - $days*60*60*24  
    //                             - $hours*60*60)/ 60); 
    //     } 
        $remainingdaysamt = $perday*$days;
        $returnArr = array('days'=>$days, 'amount'=>number_format($remainingdaysamt, 2, '.', '')); //print_r($returnArr);
        return $returnArr;
    }

    function is_html_empty($html){
        if(strpos($html, 'img') !== false){
            return false;
        }
        $html = str_replace("<br />","",$html);
        $html = str_replace("&nbsp;","",$html);
        $html = str_replace("<p> </p>","",$html);
        $html = trim($html);
        if(empty($html) && $html!==0 && $html!=='0'){
            return true;
        }
        return false;
    }


    function totalpercentage($total = NULL, $config = NULL) { 
        $array = [];
        $array['texableval']    = 0;
        $array['texablevalget'] = 0;
        $array['total']         = $total; 
        $array['cgst']          = 0;
        $array['sgst']          = 0;
        $array['gst']           = 0;
        $array['cess']          = 0;
        $cessamt = 0;
        $taxable = 0;
        $sgstamt = 0;
        $cgstamt = 0;
        if($total!='') {
            $tax = $config['sgst'] + $config['cgst'] + 100;
            if($config['cess']>0) {
                $tax += $config['cess'];
            }
            $totalAmt = $total*100;
            $taxable = $totalAmt/$tax;
            $array['texableval'] = $taxable;
            $cgst = $taxable*$config['cgst'];
            $cgstamt = $cgst/100;
            $sgst = $taxable*$config['sgst'];
            $sgstamt = $sgst/100;
            if($config['cess']>0) {
                $cess = $taxable*$config['cess'];
                $cessamt = $cess/100;
                $array['cess']          = $cessamt;
            }
            $array['cgst']          = $cgstamt;
            $array['sgst']          = $sgstamt;
            $array['gst']           = $sgstamt+$cgstamt;
            $array['texablevalget'] = $taxable+$sgstamt+$cgstamt+$cessamt;
        }
        return $array;
    }
    function numberTowords($num) {
        $count = 0;
        global $ones, $tens, $triplets;
        $ones = array(
          '',
          ' One',
          ' Two',
          ' Three',
          ' Four',
          ' Five',
          ' Six',
          ' Seven',
          ' Eight',
          ' Nine',
          ' Ten',
          ' Eleven',
          ' Twelve',
          ' Thirteen',
          ' Fourteen',
          ' Fifteen',
          ' Sixteen',
          ' Seventeen',
          ' Eighteen',
          ' Nineteen'
        );
        $tens = array(
          '',
          '',
          ' Twenty',
          ' Thirty',
          ' Forty',
          ' Fifty',
          ' Sixty',
          ' Seventy',
          ' Eighty',
          ' Ninety'
        );
      
        $triplets = array(
          '',
          ' Thousand',
          ' Million',
          ' Billion',
          ' Trillion',
          ' Quadrillion',
          ' Quintillion',
          ' Sextillion',
          ' Septillion',
          ' Octillion',
          ' Nonillion'
        );
        return convertNum($num);
      }
      
      /**
       * Function to dislay tens and ones
       */
      function commonloop($val, $str1 = '', $str2 = '') {
        global $ones, $tens;
        $string = '';
        if ($val == 0)
          $string .= $ones[$val];
        else if ($val < 20)
          $string .= $str1.$ones[$val] . $str2;  
        else
          $string .= $str1 . $tens[(int) ($val / 10)] . $ones[$val % 10] . $str2;
        return $string;
      }
      
      /**
       * returns the number as an anglicized string
       */
      function convertNum($num) {
        $num = (int) $num;    // make sure it's an integer
      
        if ($num < 0)
          return 'negative' . convertTri(-$num, 0);
      
        if ($num == 0)
          return 'Zero';
        return convertTri($num, 0);
      }
      
      /**
       * recursive fn, converts numbers to words
       */
      function convertTri($num, $tri) {
        global $ones, $tens, $triplets, $count;
        $test = $num;
        $count++;
        // chunk the number, ...rxyy
        // init the output string
        $str = '';
        // to display hundred & digits
        if ($count == 1) {
          $r = (int) ($num / 1000);
          $x = ($num / 100) % 10;
          $y = $num % 100;
          // do hundreds
          if ($x > 0) {
            $str = $ones[$x] . ' Hundred';
            // do ones and tens
            $str .= commonloop($y, ' and ', '');
          }
          else if ($r > 0) {
            // do ones and tens
            $str .= commonloop($y, ' and ', '');
          }
          else {
            // do ones and tens
            $str .= commonloop($y);
          }
        }
        // To display lakh and thousands
        else if($count == 2) {
          $r = (int) ($num / 10000);
          $x = ($num / 100) % 100;
          $y = $num % 100;
          $str .= commonloop($x, '', ' Lakh ');
          $str .= commonloop($y);
          if ($str != '')
            $str .= $triplets[$tri];
        }
        // to display till hundred crore
        else if($count == 3) {
          $r = (int) ($num / 1000);
          $x = ($num / 100) % 10;
          $y = $num % 100;
          // do hundreds
          if ($x > 0) {
            $str = $ones[$x] . ' Hundred';
            // do ones and tens
            $str .= commonloop($y,' and ',' Crore ');
          }
          else if ($r > 0) {
            // do ones and tens
            $str .= commonloop($y,' and ',' Crore ');
          }
          else {
            // do ones and tens
            $str .= commonloop($y);
          }
        }
        else {
          $r = (int) ($num / 1000);
        }
        // add triplet modifier only if there
        // is some output to be modified...
        // continue recursing?
        if ($r > 0)
          return convertTri($r, $tri+1) . $str;
        else
          return $str;
      }

      function sortorderqn($db = []) {
        $col  = 'question_number';
        $sort = array();
        foreach ($db as $i => $obj) {
          $sort[$i] = $obj->{$col};
        }
        
        $sorted_db = array_multisort($sort, SORT_ASC, $db);
        return $db;
      }
?>
