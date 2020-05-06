<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends Direction_Model {
    
    public function __construct() {
        parent::__construct();
	}
	
	function get_config(){
		$config = $this->db->get('am_config')->result();
		$result = array();
		if(!empty($config)){
			foreach($config as $row){
				$result[$row->key] = $row->value;
			}
		}
		return $result;
	}

	function get_stories_list($id,$limit=0,$page=0) {
		$this->db->select('*');
		$this->db->where('school_id', $id);
		$this->db->where('success_status', '1');
		//$this->db->limit( $limit, $page);
		$query	=	$this->db->get('web_success_stories');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}
			
    // function get_result_list($id,$limit=0,$page=0) {
	// 	$this->db->select('*');
	// 	$this->db->where('school_id', $id);
	// 	$this->db->where('result_status', '1');
	// 	//$this->db->limit( $limit, $page);
	// 	$query	=	$this->db->get('web_results');
	// 	$resultArr	=	array();
	// 	if($query->num_rows() > 0){
	// 		$resultArr	=	$query->result_array();		
	// 	}
	// 	return $resultArr;
	// }
		
	function get_notification_list($id,$limit=0,$page=0) {
		$this->db->select('*');
		$this->db->where('school_id', $id);
		$this->db->where('notification_status', '1');
		//$this->db->limit( $limit, $page);
		$query	=	$this->db->get('web_notifications');
		$resultArr	=	array();
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		return $resultArr;
	}

    function get_team_list($id,$limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			$this->db->where('team_status', '1');
			//$this->db->limit( $limit, $page);
			$query	=	$this->db->get('web_ourteam');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}
		
		function get_special_list($id,$limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			$this->db->where('about_status', '1');
			//$this->db->limit( $limit, $page);
			$query	=	$this->db->get('web_special_about');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}

		function get_achievers_list($year,$id,$limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			$this->db->where('year', $year);
			//$this->db->limit( $limit, $page);
			$query	=	$this->db->get('web_achievers_gallery');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}

		function get_prepare_list($id,$limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			$this->db->where('prepare_status', '1');
			//$this->db->limit( $limit, $page);
			$query	=	$this->db->get('web_prepare_content');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			// show($resultArr);
			return $resultArr;
		}

		function get_detailed_notification($notification,$id) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			$this->db->where('notification_id', $notification);
			$query	=	$this->db->get('web_notifications');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				 $resultArr	=	$query->result();		
			}
			return $resultArr;
		}

		function get_detail_notification($id) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			// $this->db->where('notification_id', $notification);
			$query	=	$this->db->get('web_notifications');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				 $resultArr	=	$query->result();		
			}
			return $resultArr;
		}

		function get_detailed_notifications($notification,$id) {
			$this->db->select('web_notifications.*,web_results.city_id');
			$this->db->from('web_notifications');
			$this->db->join('web_results','web_results.notification_id = web_notifications.notification_id');
			$this->db->where('web_notifications.notification_id', $notification);
			$this->db->where('web_notifications.school_id', $id);
			$query = $this->db->get();
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->row_array();		
		   }
		   return $resultArr;
		}

		function get_det_notifications($id) {
			
				$this->db->select('web_notifications.*,web_results.city_id');
				$this->db->from('web_notifications');
				$this->db->join('web_results','web_results.notification_id = web_notifications.notification_id');
				// $this->db->where('web_notifications.notification_id', $notification);
				$this->db->where('web_notifications.school_id', $id);
				$query = $this->db->get();
				$resultArr	=	array();
				if($query->num_rows() > 0){
					$resultArr	=	$query->row_array();		
			   }
			   return $resultArr;
			}
		
		function get_detailed_result($notification,$id) {
			$this->db->select('web_results.*,web_notifications.name as exam_name');
			$this->db->from('web_results');
			$this->db->join('web_notifications','web_notifications.notification_id = web_results.notification_id');
			$this->db->where('web_results.notification_id', $notification);
			$this->db->where('web_results.school_id', $id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return FALSE;
			}
		}

		function get_detailed_results($id) {
			$this->db->select('web_results.*,web_notifications.name as exam_name');
			$this->db->from('web_results');
			$this->db->join('web_notifications','web_notifications.notification_id = web_results.notification_id');
			// $this->db->where('web_results.notification_id', $notification);
			$this->db->where('web_results.school_id', $id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return FALSE;
			}
		}
		function get_galleries(){
			$this->db->select('*, COUNT(gallery_id) as total')
								->where('gallery_status',1)
								->group_by('gallery_name')
								->order_by('gallery_id','desc');
			$query	      =	$this->db->get('web_gallery');
			//echo $this->db->last_query(); exit;
			$resultArr	  =	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result();		
			}
			return $resultArr;	
		}

		function get_gallery($name){
			return $this->db->where('gallery_name',$name)->where('gallery_status',1)->get('web_gallery')->result();
		}

		function get_corefeatures(){
			return $this->db->where('corefeature_status',1)->get('web_core_features')->result();
		}

		function get_careers(){
			return $this->db->where('careers_status',1)->get('web_careers')->result();
		}

		function get_school_sample_questions($id){
			return $this->db->select('question_id')->where('school_id',$id)->where('question_status',1)->get('am_questions')->result();
		}

		function get_sample_question($id){
			return $this->db->where('question_id',$id)->get('am_questions')->row();
		}

		function get_next_sample_question($id){
			return $this->db->select('question_id,school_id,question,question_option_a as opt1,question_option_b as opt2,question_option_c as opt3,question_option_d as opt4')
							->where('question_id',$id)
							->get('am_questions')->row();
		}

		function get_school_names($id){
			return $this->db->where('school_id',$id)->get('am_schools')->row();
		}

		function get_questions_answers($questions){
			return $this->db->where_in('question_id',$questions)->get('am_questions')->result();
		}

		function get_year_list($id,$limit=0,$page=0) {
			$query = $this->db->distinct()
			    ->select('year')
				->from('web_achievers_gallery')
				->where('school_id', $id)
				// ->where('gallery_status',$year)
				// ->where('gallery_status',0)
				->get();
	 		return $query->result();
		}
    

    function get_slidercontent($school = NULL) {
			$this->db->select('*');
			$this->db->where('school_id', $school);
			$query	      =	$this->db->get('web_slider_content');
			$resultArr	  =	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}

    public function enquiry_add($data)
    {
        $this->db->insert('cc_enquiries',$data);	
            $rows=  $this->db->insert_id(); 
           
             if($rows > 0)
             {
             return $rows;
             }else{
             return FALSE;
            }
    }
    
    /*
    *   Get course details by id
    *   @params id
    *   @author GBS-R
    */
    
    public function get_coursedetails_id($id = NULL) {
			$this->db->select('*');
			$this->db->from('am_batch_center_mapping');
            $this->db->join('am_institute_course_mapping','am_institute_course_mapping.institute_course_mapping_id = am_batch_center_mapping.institute_course_mapping_id');
            $this->db->join('am_classes','am_classes.class_id = am_institute_course_mapping.course_master_id');
            $this->db->join('am_batch_mode','am_batch_mode.mode_id = am_batch_center_mapping.batch_mode');
            $this->db->where('am_batch_center_mapping.batch_id', $id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return FALSE;
            }
		}


		public function get_successdetails_id($id = NULL) {
			$this->db->select('*');
			$this->db->from('web_success_stories');
            $this->db->where('web_success_stories.success_id', $id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return FALSE;
            }
		}

		function get_schools($limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('school_status', '1');
			//$this->db->limit( $limit, $page);
			$query	=	$this->db->get('am_schools');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}
    
    
    
    /*
    *   Get general studies materials
    *   @params school id
    *   @authoe GBS-R
    *
    */
    
    	function get_elearning_materials($school_id = NULL , $type = NULL) {
			$this->db->select('*');
			$this->db->where('web_general_studies.school_id', $school_id);
			$this->db->where('web_general_studies.type', $type);
			$this->db->join('web_category','web_category.id = web_general_studies.category_id');
			// $this->db->join('web_general_studies','web_general_studies.category_id = web_category.id');
			$this->db->where('web_general_studies.status', '1');
            $this->db->order_by('web_category.id', 'desc');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result();		
			}
			return $resultArr;
		}
		function get_gs_materials($school_id = NULL , $type = NULL) {
			$this->db->select('*');
			$this->db->where('school_id', $school_id);
			$this->db->where('type', $type);
			$this->db->where('status', '1');
            $this->db->order_by('id', 'desc');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result();		
			}
			return $resultArr;
		}
		function get_elearning_materials_maxid($school_id = NULL, $type) {
			$id = $this->db->query('SELECT MAX(category_id) AS `maxid` FROM `web_general_studies` WHERE `school_id` = '.$school_id.' AND `type` = "'.$type.'" AND `status` = 1 order by `id` desc')->row()->maxid;
			$this->db->select('category_key');
			$this->db->from('web_category');
			$this->db->where('id', $id);
			$result = $this->db->get()->row();
			if(!empty($result)){
				return $result->category_key;
			}else{
				return false;
			}
		}

		function get_general_studies_maxid($school_id = NULL, $type) {
			$id = $this->db->query('SELECT MAX(id) AS `maxid` FROM `web_general_studies` WHERE `school_id` = '.$school_id.' AND `type` = "'.$type.'" AND `status` = 1 order by `id` desc')->row()->maxid;
			$this->db->select('topic_key');
			$this->db->from('web_general_studies');
			$this->db->where('id', $id);
			$result = $this->db->get()->row();
			if(!empty($result)){
				return $result->topic_key;
			}else{
				return false;
			}
		}

		function get_values_list($limit=0,$page=0) {
			$this->db->select('*');
			//$this->db->limit( $limit, $page);
			$query	=	$this->db->get('web_aboutus_values');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}

		function get_service_list($limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('service_status', '1');
			$query	=	$this->db->get('web_services');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;
		}
		function get_results($limit=0,$page=0) {
			$this->db->select('*');
			$this->db->where('result_status', '1');
			$this->db->where('school_id', '1');
			$query	=	$this->db->get('web_results');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			return $resultArr;



		// $this->db->distinct('exam_name'); 
		// $this->db->select('web_results.*,gm_exam_definition.exam_name,city.city_name');
		// $this->db->join('gm_exam_definition', 'gm_exam_definition.id = web_results.exam_definition_id');
		// $this->db->join('city', 'city.city_id = web_results.city_id');
		// // $this->db->group_by('exam_name');
		// $query	=	$this->db->get('web_results');
		// $resultArr	=	array();
		// if($query->num_rows() > 0){
		// 	$resultArr	=	$query->result_array();		
		// }
		// return $resultArr;


		}

		function get_exams(){
			return $this->db->get('gm_exam_definition')->result_array();
		}


		function get_images($galery_key) {
			$this->db->select('*');
			$this->db->where('gallery_key', $galery_key);
			$this->db->where('gallery_status',1);
			$query	=	$this->db->get('web_gallery');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				 $resultArr	=	$query->result();		
			}
			return $resultArr;
		}
		
    /*
    *   Get general studies materials bu key
    *   @params school id
    *   @authoe GBS-R
    *
    */
    function get_elearning_materials_id($school_id = NULL, $topic = NULL) {
			$this->db->select('*');
            $this->db->where('school_id', $school_id);
        	$this->db->where('topic_key', $topic);
			$this->db->where('status', '1');
            //$this->db->order_by('id', 'desc');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->row();		
			}
			return $resultArr;
		}
		function get_elearning_materials_categoryid($school_id = NULL, $module = NULL, $type = NULL) {
			$this->db->select('id');
			$this->db->from('web_category');
            $this->db->where('category_key', $module);
			$id	=	$this->db->get()->row()->id;

			$this->db->select('*');
			$this->db->where('category_id', $id);
			$this->db->where('type', $type);
			$this->db->where('status', '1');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->row();		
			}
			return $resultArr;
		}

		function get_general_studies_categoryid($school_id = NULL, $model = NULL, $type = NULL) {
			$this->db->select('*');
			$this->db->where('school_id', $school_id);
			$this->db->where('type', $type);
			$this->db->where('topic_key', $model);
			$this->db->where('status', '1');
            // $this->db->order_by('id', 'desc');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			// echo $this->db->last_query(); exit;
			if($query->num_rows() > 0){
				$resultArr	=	$query->row();		
			}
			return $resultArr;
		}

		function get_appricant_post($id) {
			$this->db->select('careers_name');
			$this->db->where('careers_id', $id);
			$this->db->from('web_careers');
			return $this->db->get()->row()->careers_name;
		}
		function get_banner() {
			$this->db->select('*');
			$this->db->where('type', 'Home_top_banner');
			// $this->db->where('type', 'School_banner');
			// $this->db->limit(10);  
			$resultArr = array();
			$query	=	$this->db->get('web_banner');
			if($query->num_rows() > 0){
				$resultArr	=	$query->row_array();	
			}
			return $resultArr;
		}
		function get_school_banner($id) {
			$this->db->select('*');
			$this->db->where('school_id', $id);
			$this->db->limit(1);  
			$resultArr = array();
			$query	=	$this->db->get('web_banner');
			if($query->num_rows() > 0){
				$resultArr	=	$query->row_array();	
			}
			return $resultArr;
		}
		function get_inner_slider() {
			$this->db->select('*');
			$this->db->where('type', 'Inner_slider');
			$this->db->where('status',1);
			$resultArr = array();
			$query	=	$this->db->get('web_banner');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();	
			}
			return $resultArr;
		}
		function get_school_banner1($id) {
			$this->db->select('*');
			$this->db->where('type', 'School_banner');
			$this->db->where('school_id', $id);
			$resultArr = array();
			$query	=	$this->db->get('web_banner');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();	
			}
			return $resultArr;
		}
		function get_gallery_forSchool($id){
			return $this->db->select('*')->where('gallery_status',1)->where('school_id',$id)->order_by("gallery_id", "desc")->limit(5)->get('web_gallery')->result();
		}
		function schoolgallery($id){
			$this->db->select('*, COUNT(gallery_id) as total')
								->where('gallery_status',1)
								->where('school_id',$id)
								->group_by('gallery_name')
								->order_by('gallery_id','desc');
			return $this->db->get('web_gallery')->result();		
		}
		function servicetitle($title){ 
			return $this->db->select('*')->where('service_status',1)->where('title',$title)->get('web_services')->result();
		}
		function getmailReceiver($sMail){ 
			return $this->db->select('value')->where('key',$sMail)->get('am_config')->row()->value;
		}
		public function inactiveCareer($id){
			$arr=array('careers_id'=>$id);
			$this->db->where($arr);
			$this->db->set('careers_status',0) ;
			$this->db->update('web_careers');
		}
		function single_story($id){ 
			return $this->db->select('*')->where('success_id',$id)->get('web_success_stories')->result();
		}
		function bread_crumb($id) {
			$this->db->select('school_id');
			$this->db->where('success_id', $id);
			$this->db->from('web_success_stories');
			return $this->db->get()->row()->school_id;
		}
		function get_prepare_listSearch($search,$school) {
			$this->db->select('web_prepare_content.*,web_category.category');
			$this->db->from('web_prepare_content');
			$this->db->join('web_category','web_category.id = web_prepare_content.category_id');
			$this->db->like('web_category.category', $search);
			$this->db->where('web_prepare_content.school_id', $school);
			$this->db->where('web_prepare_content.prepare_status', '1');
			$query	=	$this->db->get();
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result_array();		
			}
			// show($resultArr);
			return $resultArr;
		}
		function get_elearning_materialsSearch($school_id = NULL , $type = NULL , $search) {
			$this->db->select('*');
			$this->db->where('web_general_studies.school_id', $school_id);
			$this->db->where('web_general_studies.type', $type);
			$this->db->join('web_category','web_category.id = web_general_studies.category_id');
			$this->db->where('web_general_studies.status', '1');
			$this->db->like('web_category.category', $search);
            $this->db->order_by('web_category.id', 'desc');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->result();		
			}
			return $resultArr;
		}
		function get_elearning_materials_categoryidSearch($school_id = NULL, $module = NULL, $type = NULL) {
			$this->db->select('id');
			$this->db->from('web_category');
            $this->db->where('category_key', $module);
			$id	=	$this->db->get()->row()->id;

			$this->db->select('*');
			$this->db->where('category_id', $id);
			$this->db->where('type', $type);
			$this->db->where('status', '1');
			$query	=	$this->db->get('web_general_studies');
			$resultArr	=	array();
			if($query->num_rows() > 0){
				$resultArr	=	$query->row();		
			}
			return $resultArr;
		}
		function get_elearning_materials_maxidSearch($school_id = NULL, $type, $search) {
			$id = $this->db->query('SELECT MAX(category_id) AS `maxid` FROM `web_general_studies` WHERE `school_id` = '.$school_id.' AND `type` = "'.$type.'" AND `status` = 1 order by `id` desc')->row()->maxid;
			$this->db->select('category_key');
			$this->db->from('web_category');
			$this->db->like('category', $search);
			$this->db->where('id', $id);
			$result = $this->db->get()->row();
			if(!empty($result)){
				return $result->category_key;
			}else{
				return false;
			}
		}

		function get_paymentInfo_by_paymentcode($code) {
			$this->db->select('*');
			$this->db->where('code', $code);
			$this->db->where('status!=', 1);
			$query	=	$this->db->get('pp_onlinepayment_approval');
			$result	=	array();
			if($query->num_rows() > 0){
				$result	=	$query->row();		
			}
			// show($resultArr);
			return $result;
		}
}
