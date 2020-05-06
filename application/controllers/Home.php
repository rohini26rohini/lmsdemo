<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Direction_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('home_model');
  }

  public function index(){
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/home';
    $this->data['successArr']=$this->success_model->get_stories_list_limit();
    // $this->data['notifications']=$this->success_model->get_stories_list(1);
    $school_banner = array();
    $this->data['notification'] = $this->common->get_all_exams(); 
    $homeTop = $this->home_model->get_banner(); 
    if(!empty($homeTop)){
      $school_banner[0] = $this->home_model->get_banner(); 
    }
    $schools = $this->home_model->get_schools();
    $i=1;
    foreach($schools as $key =>$data){
      $temp = $this->home_model->get_school_banner($data['school_id']); 
      if (!empty($temp)){
        $school_banner[$i] = $temp;
        $i++;
      }
    }
    $this->data['banner'] = $school_banner;
    // echo '<pre>'; print_r($this->data['banner']); exit;
    $this->data['inner_slider'] = $this->home_model->get_inner_slider(); 
    // echo '<pre>'; print_r($this->data['inner_slider']); exit;
    $this->data['corefeatures']=$this->home_model->get_corefeatures();
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);

  }
      

  public function iasstudycircle($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 1;
    $tutorialcontent         = $this->home_model->get_gs_materials(1, 'general_studies'); 
    // echo $this->db->last_query(); exit;
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(1);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(1);
    $this->data['detailedArr']=$this->common->get_our_program(1);
    $this->data['mentor']=$this->home_model->servicetitle('Honorary-Director');
    $this->data['general_studies'] = $this->home_model->get_general_studies_maxid(1, 'general_studies'); 
    // echo $this->db->last_query(); exit;
    $this->data['logo_ias'] = 1;
    $this->data['viewload'] = 'home/iasstudycircle_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }
  public function iasaspirants($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/iasaspirants';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Civil Services Exam For aspirants";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function iasupscaspirants($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/iasupscaspirants';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Upsc Civil Services Examinations";
    $this->data['viewload'] = 'home/ias_upscaspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function jrf($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/jrf';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Junior Research Fellowship (JRF)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function net($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/net';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "National Eligibility Test(NET)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function msc($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/msc';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Joint admission test for M.Sc. Exams (Physics)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function kas($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/kas';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Kerala Administrative Services (KAS)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function psc($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/psc';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "General PSC";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function ldc($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/ldc';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Lower Division Clerk(LDC)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function ua($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/ua';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "University Assistant (UA)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function sa($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/sa';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Secretariat Assistant";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function ag($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/ag';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Assistant Grade";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function hsst($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/hsst';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "HSST";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function cgl($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/cgl';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Combined Graduate Level(CGL)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function chsl($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/chsl';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Combined Higher Secondary level(CHSL)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function cpo($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/cpo';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Central Police Organization(CPO)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function mts($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/mts';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Multi-tasking Staff(MTS)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function je($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/je';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Junior Engineer(JE)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function clerk($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/clerk';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Clerk";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function po($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/po';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Probationary Officer (PO)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function so($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/so';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Specialist Officer (SO)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function rrb($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/rrb';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "Regional Rural Bank (RRB)";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function std_eight($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/std_eight';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "8th Standard";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function std_ten($year= "") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['viewload'] = 'home/std_ten';
    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['logo_ias'] = 1;
    $this->data['course'] = "10th Standard";
    $this->data['viewload'] = 'home/ias_aspirants_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }
    
public function about_ias_study_circle() {
    
    $this->data['viewload'] = 'home/about_ias_study_circle_view';
    $this->load->view('_layouts/_master', $this->data);

  }

  public function ias_director() {
    
    $this->data['viewload'] = 'home/ias_director';
    $this->data['mentor']=$this->home_model->servicetitle('Honorary-Director');
    $this->load->view('_layouts_new/_master', $this->data); 

  }

  public function single_story($id) {
    
    $this->data['viewload'] = 'home/single_story';
    $this->data['breadcrumb'] = $this->home_model->bread_crumb($id);
    $this->data['story']= $this->home_model->single_story($id);
    $this->load->view('_layouts_new/_master', $this->data); 

  }

  public function success_story($id) {
    
    $this->data['viewload'] = 'home/single_story';
    $this->data['breadcrumb'] = 0;
    $this->data['story']= $this->home_model->single_story($id);
    $this->load->view('_layouts_new/_master', $this->data); 

  }
    
  public function single_school_story($id) {
    
    $this->data['viewload'] = 'home/single_story';
    $this->data['breadcrumb'] = $this->home_model->bread_crumb($id);
    $this->data['story']= $this->home_model->single_story($id);
    $this->load->view('_layouts_new/_master', $this->data); 

  }
      
  public function sscexaminations($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 4;
    $tutorialcontent         = $this->home_model->get_elearning_materials(4); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(4);
    $this->data['notificationArr']=$this->home_model->get_notification_list(4);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(4);
    $this->data['teamArr']=$this->home_model->get_team_list(4);
    $this->data['specialArr']=$this->home_model->get_special_list(4);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,4);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(4);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(4);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(4);
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(4, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(4, 'previous_question'); 
    $this->data['logo_ssc'] = 1;
    $this->data['viewload'] = 'home/sscexaminations_view';
    $this->load->view('_layouts_new/_master', $this->data);
      
  }
      

  public function netjrfexaminations($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 2;
    $tutorialcontent         = $this->home_model->get_elearning_materials(2); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(2);
    $this->data['notificationArr']=$this->home_model->get_notification_list(2);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(2);
    $this->data['teamArr']=$this->home_model->get_team_list(2);
    $this->data['specialArr']=$this->home_model->get_special_list(2);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,2);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(2);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(2);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(2);
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(2, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(2, 'previous_question'); 
    $this->data['logo_UGC'] = 1;
    $this->data['viewload'] = 'home/netjrfexaminations_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);

      
  }
      
      
  public function schoolofbanking($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 5;
    $tutorialcontent         = $this->home_model->get_elearning_materials(5); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(5);
    $this->data['notificationArr']=$this->home_model->get_notification_list(5);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(5);
    $this->data['teamArr']=$this->home_model->get_team_list(5);
    $this->data['specialArr']=$this->home_model->get_special_list(5);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,5);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(5);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(5);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(5);
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(5, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(5, 'previous_question'); 
    $this->data['logo_banking'] = 1;
    $this->data['viewload'] = 'home/schoolofbanking_view';
    $this->load->view('_layouts_new/_master', $this->data);
      
  }
      
      
  public function pscexaminations($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 3;
    $tutorialcontent         = $this->home_model->get_elearning_materials(3); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(3);
    $this->data['notificationArr']=$this->home_model->get_notification_list(3);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(3);
    $this->data['teamArr']=$this->home_model->get_team_list(3); 
    $this->data['specialArr']=$this->home_model->get_special_list(3);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,3);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(3);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(3);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(3);
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(3, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(3, 'previous_question'); 
    $this->data['logo_psc'] = 1;
    $this->data['viewload'] = 'home/pscexaminations_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);

      
  }
      
      
  public function directionjunior($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 6;
    $tutorialcontent         = $this->home_model->get_elearning_materials(6); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(6);
    $this->data['notificationArr']=$this->home_model->get_notification_list(6);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(6);
    $this->data['teamArr']=$this->home_model->get_team_list(6);
    $this->data['specialArr']=$this->home_model->get_special_list(6);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,6);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(6);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(6);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(6);
    $this->data['DIFP']=$this->home_model->servicetitle('About-DIFP');
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(6, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(6, 'previous_question'); 
    $this->data['logo_junior'] = 1;
    $this->data['viewload'] = 'home/directionjunior_view';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function entranceexamination($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 7;
    $tutorialcontent         = $this->home_model->get_elearning_materials(7); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(7);
    $this->data['notificationArr']=$this->home_model->get_notification_list(7);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(7);
    $this->data['teamArr']=$this->home_model->get_team_list(7);
    $this->data['specialArr']=$this->home_model->get_special_list(7);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,7);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(7);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(7);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(7);
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(7, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(7, 'previous_question'); 
    $this->data['logo_junior'] = 1;
    $this->data['viewload'] = 'home/entrance_view';
    $this->load->view('_layouts_new/_master', $this->data);
      
  }
  public function rrb_examination($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['school'] = 8;
    $tutorialcontent         = $this->home_model->get_elearning_materials(8); 
    $this->data['tutorials'] = $tutorialcontent;
    $this->data['slider']=$this->home_model->get_slidercontent(8);
    $this->data['notificationArr']=$this->home_model->get_notification_list(8);
    $this->data['successArr']=$this->success_model->get_stories_list_by_school(8);
    $this->data['teamArr']=$this->home_model->get_team_list(8);
    $this->data['specialArr']=$this->home_model->get_special_list(8);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,8);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(8);
    $this->data['schoolBannerArr']=$this->home_model->get_school_banner1(8);
    $this->data['schoolgalleryArr']=$this->home_model->get_gallery_forSchool(8);
    $this->data['syllabus'] = $this->home_model->get_elearning_materials_maxid(8, 'syllabus'); 
    $this->data['previous_question'] = $this->home_model->get_elearning_materials_maxid(8, 'previous_question'); 
    $this->data['logo_rrb'] = 1;
    $this->data['viewload'] = 'home/rrb_examination_view';
    $this->load->view('_layouts_new/_master', $this->data);
      
  }  
      
  public function aboutus(){
    $this->data['viewload'] = 'home/aboutus_view';
    $this->data['valuesArr']=$this->home_model->get_values_list();
    $this->data['about']=$this->home_model->servicetitle('About-us');
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);

  }

        
  public function privacy_policy(){
    $this->data['viewload'] = 'home/privacy_policy_view';
    $this->data['valuesArr']=$this->home_model->get_values_list();
    $this->data['about']=$this->home_model->servicetitle('About-us');
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);

  }
  // public function gallery_view($galery_key = NULL){
  //   $this->data['viewload'] = 'home/gallery_view';
  //   $this->data['images'] = $this->home_model->get_images($galery_key);
  //   $this->load->view('_layouts_new/_master', $this->data);

  // }
      
  public function ourteam(){
    $this->data['viewload'] = 'home/ourteam_view';
    $this->load->view('_layouts/_master', $this->data);
  }
      
  public function requestcallback(){
    $this->data['viewload'] = 'home/requestcallback_view';
    $this->load->view('_layouts/_master', $this->data);
  }

      
  public function raisequery(){
    $this->data['viewload'] = 'home/raisequery_view';
    $this->load->view('_layouts/_master', $this->data);
  }

  public function result(){
    $this->data['viewload'] = 'home/no_data';
    $this->load->view('_layouts_new/_master', $this->data);
  }
    
  public function contactus(){
    $this->data['viewload'] = 'home/contactus_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }    
      
  public function findus(){
    $this->data['viewload'] = 'home/findus_view';
    $this->load->view('_layouts/_master', $this->data);
  }
      
  public function workwithus(){
    $this->data['careers'] = $this->home_model->get_careers();
    $this->data['viewload'] = 'home/workwithus_view';
    // $this->data['career_data'] = 'home/workwithus_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }
   
  public function career_apply(){
    // print_r($_POST);
    // print_r($_FILES);
    if($_POST){
      $data=array();
      $name_applicant = $this->input->post('name'); 
      $applicant_id = $this->input->post('career_id'); 
      $data['name']= $this->input->post('name'); 
      $name = $this->input->post('name'); 
      $data['career_id']= $this->input->post('career_id');
      $data['email']= $this->input->post('email');
      $email = $this->input->post('email');
      $data['phone']= $this->input->post('phone');
      // echo "step one";
      if($_FILES['resume']['name'] != ''){
        // echo "step two";
        $files = str_replace(' ', '_', $_FILES['resume']);
        $_FILES['resume']['name']     = $files['name'];
        $_FILES['resume']['type']     = $files['type'];
        $_FILES['resume']['tmp_name'] = $files['tmp_name'];
        $_FILES['resume']['size']     = $files['size'];
        $config['upload_path']           = 'uploads/career_application_doc/';
        $config['allowed_types']         = 'pdf|docx';
        $this->load->library('upload');
        $this->upload->initialize($config);
        $upload = $this->upload->do_upload('resume');
        if($upload){
          // echo "step three";
            $data['resume'] = str_replace(' ', '_', $_FILES['resume']['name']); 
        }else{
          // echo "step four";
            $ajax_response['st']= 2; //file type error
            $ajax_response['msg']= 'The file type you are attempting to upload is not valid';
            print_r(json_encode( $ajax_response));
            exit;
        }
      }
      $response=$this->Common_model->insert('web_career_apply', $data); 
      // echo $this->db->last_query(); exit;
      if($response != 0)
      {
        // echo "step five";
        $ajax_response['st']=1;
        $ajax_response['msg']="Applied successfully.!";
        $appricant_post = $this->home_model->get_appricant_post($applicant_id);
        $data=email_header();
        $data.='<td style="padding: 26px 26px">
                  <h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
                  <p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
                    Hello,<br> 
                    <b>You received an application from Mr/Mis. '.$name_applicant.' for the post of '.$appricant_post.'</b>
                  </p>
                </td>';
        $data.=email_footer();
        $sMail = $this->home_model->getmailReceiver('');
        $this->send_email("New Job Application", $sMail,$data);

        $datad=email_header();
        $datad.='<td style="padding: 26px 26px">
                  <h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
                  <p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
                    Hello, '.$name.'<br> 
                    <b>Your application for the post \''.$appricant_post.'\' is received successfully. We will get back to you soon.!</b>
                  </p>
                </td>';
        $datad.=email_footer();
        $this->send_email("Application Recevied", $email,$datad);
      }
      else{
        // echo "step six";
          $ajax_response['st']=0;
          $ajax_response['msg']="Something went wrong,Please try again later..!";
      } 
  }else{
      // echo "step seven";
      $ajax_response['st']=0;
      $ajax_response['msg']="Something went wrong,Please try again later..!";
  }
  print_r(json_encode( $ajax_response));
  }

  function send_email($type, $email, &$data) {
    $this->email->to($email);
    $this->email->subject($type);
    $this->email->message($data);
    $this->email->send();
 }

  public function growwithus(){
    $this->data['viewload'] = 'home/growwithus_view';
    $this->load->view('_layouts/_master', $this->data);
  }

  public function gallery_view($galery_key = NULL){
    $this->data['viewload'] = 'home/gallery_view';
    $this->data['key'] = $galery_key;
    $this->data['images'] = $this->home_model->get_images($galery_key);
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function results($notification="",$school_id=""){
    if($notification == ""){
      $notification=  $_POST['notification_id'];
    }
    if($school_id == ""){
      $school_id=  $_POST['school_id'];
    }
    $this->data['batchArr']=$this->common->get_classes(1);
    $this->data['detailedArr']=$this->home_model->get_detailed_results($notification,$school_id);
    //   echo '<pre>';
    // print_r($this->data['detailedArr']);
    // die();
    $this->data['examArr']=$this->home_model->get_detailed_notification($notification,$school_id);
    $this->data['eresults'] = $this->home_model->get_detailed_notifications($notification,$school_id);
    // $this->data['examresults'] = $this->home_model->get_results();
    $this->data['viewload'] = 'home/results';
    $this->load->view('_layouts_new/_master', $this->data);
  }


  // public function detailed_results($notification="",$school_id=""){
  //   if($notification == ""){
  //     $notification=  $_POST['notification_id'];
  //   }
  //   if($school_id == ""){
  //     $school_id=  $_POST['school_id'];
  //   }
    
  //   $this->data['batchArr']=$this->common->get_classes(1);
  //   $this->data['detailedArr']=$this->home_model->get_detailed_results($notification,$school_id);
  //   $this->data['examArr']=$this->home_model->get_detailed_notification($notification,$school_id);
  //   $this->data['eresults'] = $this->home_model->get_detailed_notifications($notification,$school_id);
  //   // $this->data['eresults'] =   $this->db->get_where('web_notifications', array('notification_id =' => $notification,'school_id' => $school_id) )->row_array(); 
  
  //   // echo $this->db->last_query();
  //   // echo '<pre>';
  //   // print_r($this->data['eresults']['name']);
  //   // die();
  //   $this->data['viewload'] = 'home/detailed_result';
  //   $this->load->view('_layouts_new/_master', $this->data);
  // }



  public function services(){
    $this->data['serviceArr']=$this->home_model->get_service_list();
    $this->data['viewload'] = 'home/services';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function difp(){
    $this->data['viewload'] = 'home/difp';
    $this->data['DIFP']=$this->home_model->servicetitle('About-DIFP');
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function sitemap(){
    $this->data['general_studies'] = $this->home_model->get_general_studies_maxid(1, 'general_studies'); 
    $this->data['viewload'] = 'home/sitemap';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function whydirection(){
    $this->data['viewload'] = 'home/whydirection_view';
    $this->load->view('_layouts/_master', $this->data);
  } 

  public function success_stories(){
    $this->load->model('success_model');
    $this->data['successArr']=$this->success_model->get_stories_list();
    $this->data['breadcrumb'] = 0;
    $this->data['viewload'] = 'home/success_stories_view';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function school_stories($id){
    $this->load->model('success_model');
    $this->data['successArr']=$this->success_model->get_school_stories_list($id);
    $this->data['breadcrumb'] = $id;
    $this->data['viewload'] = 'home/success_stories_view';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function gallery(){
    if(empty($_GET['name'])){
      $this->data['galleries'] = $this->home_model->get_galleries();
      $this->data['viewload'] = 'home/gallery';
      // $this->load->view('_layouts/_master', $this->data);
      $this->load->view('_layouts_new/_master', $this->data);
    }else{
      $this->data['gallery'] = $this->home_model->get_gallery($_GET['name']);
      $this->data['viewload'] = 'home/gallery_view';
      // $this->load->view('_layouts/_master', $this->data);
      $this->load->view('_layouts_new/_master', $this->data);
    }
  }
    
public function elearningtutorials($key = NULL, $module = NULL) {
//   $tutorial = explode('-', $key); 
//   $subject_id = $tutorial[1]; 
//   $this->data['tutorials'] = '';
//   $this->data['material'] = '';
//   if($subject_id!='') {
//       $tutorialcontent         = $this->Material_model->get_elearning_materials($subject_id, 'E-learning'); 
//       $this->data['tutorials'] = $tutorialcontent;
//   } 
//   if($module != '') { 
//        $module = explode('-', $module); 
//        $material_id = $module[1]; 
//        $materialcontent        = $this->Material_model->get_elearning_materials_id($material_id, 'E-learning'); 
//        $this->data['material'] = $materialcontent; 
//   }
   if($key!='') {
       $tutorialcontent         = $this->home_model->get_elearning_materials($key, 'general_studies'); 
       $this->data['tutorials'] = $tutorialcontent;
   }  
   if($module != '') { 
        $materialcontent        = $this->home_model->get_elearning_materials_id($key, $module); 
        $this->data['material'] = $materialcontent; 
   }
  //  show($this->data['tutorials']);
   $this->data['breadcrumb'] = $key;
   $this->data['viewload'] = 'home/tutoriallisting_view';
   $this->load->view('_layouts_new/_master', $this->data); 
}

public function syllabus_view($school, $module) {
  if($school!='') {
      $tutorialcontent         = $this->home_model->get_elearning_materials($school, 'syllabus'); 
      $this->data['tutorials'] = $tutorialcontent;
  } 
  if($module != '') { 
    $materialcontent        = $this->home_model->get_elearning_materials_categoryid($school, $module, 'syllabus'); 
    $this->data['material'] = $materialcontent; 
  }
  $this->data['breadcrumb'] = $school;
  $this->data['viewload'] = 'home/syllabus_view';
  $this->load->view('_layouts_new/_master', $this->data); 
}

public function general_studies($school, $module) {
  // echo 'HI'; exit;
  if($school!='') {
      $tutorialcontent         = $this->home_model->get_gs_materials($school, 'general_studies'); 
      $this->data['tutorials'] = $tutorialcontent;
  } 
  if($module != '') { 
    $materialcontent        = $this->home_model->get_general_studies_categoryid($school, $module, 'general_studies'); 
    $this->data['material'] = $materialcontent; 
    // show($this->data['material']);
  }
  $this->data['breadcrumb'] = $school;
  $this->data['viewload'] = 'home/tutoriallisting_view';
  $this->load->view('_layouts_new/_master', $this->data); 
}

public function how_to_prepare($school) {
  if($school != '') {
      $tutorialcontent         = $this->home_model->get_prepare_list($school); 
      $this->data['howToPrepare'] = $tutorialcontent;
      // show($this->data['tutorials']);
  }
  $this->data['breadcrumb'] = $school;
  $this->data['viewload'] = 'home/howtoprepare_view';
  $this->load->view('_layouts_new/_master', $this->data); 
}
    
public function previous_question_view($school, $module) {
  if($school!='') {
      $tutorialcontent         = $this->home_model->get_elearning_materials($school, 'previous_question'); 
      $this->data['tutorials'] = $tutorialcontent;
  }
  if($module != '') { 
    $materialcontent        = $this->home_model->get_elearning_materials_categoryid($school, $module, 'previous_question'); 
    $this->data['material'] = $materialcontent; 
  }
  $this->data['breadcrumb'] = $school;
  $this->data['viewload'] = 'home/previous_question_view';
  $this->load->view('_layouts_new/_master', $this->data); 
}

public function previousquestions($key = NULL, $module = NULL) {
   $tutorial = explode('-', $key); 
   $subject_id = $tutorial[1]; 
   $this->data['tutorials'] = '';
   $this->data['material'] = '';
   if($subject_id!='') {
       $tutorialcontent         = $this->Material_model->get_elearning_materials($subject_id, 'Previousquestion'); 
       $this->data['tutorials'] = $tutorialcontent;
   } 
   if($module != '') { 
        $module = explode('-', $module); 
        $material_id = $module[1]; 
        $materialcontent        = $this->Material_model->get_elearning_materials_id($material_id, 'Previousquestion'); 
        $this->data['material'] = $materialcontent; 
   }
   $this->data['viewload'] = 'home/tutoriallisting_view';
   $this->load->view('_layouts/_master', $this->data); 
}
    
public function juniorsyllabus($key = NULL, $module = NULL) {
   $tutorial = explode('-', $key); 
   $syllabus_id = $tutorial[1]; 
   $this->data['syllabus'] = '';
   $this->data['syllabuslist']  = '';
   if($syllabus_id!='') {
       $syllabuscontent         = $this->Material_model->get_syllabus($syllabus_id); 
       $this->data['syllabus']  = $syllabuscontent;
   } 
   $this->data['syllabuslist']  = $this->common->get_syllabus_by_school(6);
   $this->data['viewload']      = 'home/syllabus_view';
   $this->load->view('_layouts/_master', $this->data); 
}    

public function iashowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
  $this->data['viewload'] = 'home/howtoprepare_view_ias';
  $this->data['breadcrumb'] = 1;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function netjrfhowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(2);
  $this->data['viewload'] = 'home/howtoprepare_view_net';
  $this->data['breadcrumb'] = 2;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function pschowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(3);
  $this->data['viewload'] = 'home/howtoprepare_view_psc';
  $this->data['breadcrumb'] = 3;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function sschowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(4); 
  $this->data['viewload'] = 'home/howtoprepare_view_ssc';
  $this->data['breadcrumb'] = 4;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function bankinghowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(5);
  $this->data['viewload'] = 'home/howtoprepare_view_banking';
  $this->data['breadcrumb'] = 5;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function juniorhowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(6);
  $this->data['viewload'] = 'home/howtoprepare_view_junior';
  $this->data['breadcrumb'] = 6;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function entrancehowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(7);
  $this->data['viewload'] = 'home/howtoprepare_view_entrance';
  $this->data['breadcrumb'] = 7;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function rrbhowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(8);
  $this->data['viewload'] = 'home/howtoprepare_view_rrb';
  $this->data['breadcrumb'] = 8;
  $this->load->view('_layouts_new/_master', $this->data);
}

public function iasachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function netachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,2);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_net';
  $this->load->view('_layouts/_master', $this->data);
}

public function pscachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,3);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_psc';
  $this->load->view('_layouts/_master', $this->data);
}

public function sscachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,4);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_ssc';
  $this->load->view('_layouts/_master', $this->data);
}

public function bankingachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,5);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_banking';
  $this->load->view('_layouts/_master', $this->data);
}

public function juniorachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,6);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_junior';
  $this->load->view('_layouts/_master', $this->data);
}

public function entranceachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,7);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_entrance';
  $this->load->view('_layouts/_master', $this->data);
}

public function rrbachieversmeet($year=""){
  if($year == ""){
    $year=date('Y');
  }
  $this->load->model('home_model');
  $this->data['galleryArr']=$this->home_model->get_achievers_list($year,8);
  $this->data['yearArr']=$this->home_model->get_year_list(1);
  $this->data['viewload'] = 'home/achievers_meet_view_rrb';
  $this->load->view('_layouts/_master', $this->data);
}

public function upcoming_notifications_ias(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(1);
  $this->data['viewload'] = 'home/notification_view_ias';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications(){
  $this->load->model('home_model');
  $this->data['notificationArr'] = $this->common->get_all_exams(); 

  // $this->data['notificationArr']=$this->home_model->get_notification_list();
  $this->data['viewload'] = 'home/notification_view_ias';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_net(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(2);
  $this->data['viewload'] = 'home/notification_view_net';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_psc(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(3);
  $this->data['viewload'] = 'home/notification_view_psc';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_ssc(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(4);
  $this->data['viewload'] = 'home/notification_view_ssc';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_banking(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(5);
  $this->data['viewload'] = 'home/notification_view_banking';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_junior(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(6);
  $this->data['viewload'] = 'home/notification_view_junior';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_entrance(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(7);
  $this->data['viewload'] = 'home/notification_view_entrance';
  // $this->load->view('_layouts/_master', $this->data);
  $this->load->view('_layouts_new/_master', $this->data);

}

public function upcoming_notifications_rrb(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(8);
  $this->data['viewload'] = 'home/notification_view_rrb';
  $this->load->view('_layouts_new/_master', $this->data);

}

public function detailed_notification_ias($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(1);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,1);
  // $this->data['detailedArr']=$this->home_model->get_detailed_results($notification,1);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification($school=""){
  if($school == ""){
    $school=  $_POST['school_id'];
  }
  $this->load->model('home_model');
  $this->data['notifications']=$this->home_model->get_notification_list($school);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,$school);
  // $this->data['detailedArr']=$this->home_model->get_detailed_results($notification,1);
  $this->data['viewload'] = 'home/detailed_notification';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_net($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(2);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,2);
  $this->data['viewload'] = 'home/detailed_notification_net';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_psc($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(3);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,3);
  $this->data['viewload'] = 'home/detailed_notification_psc';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_ssc($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(4);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,4);
  $this->data['viewload'] = 'home/detailed_notification_ssc';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_banking($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(5);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,5);
  $this->data['viewload'] = 'home/detailed_notification_banking';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_junior($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(6);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,6);
  $this->data['viewload'] = 'home/detailed_notification_junior';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_entrance($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(7);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,7);
  $this->data['viewload'] = 'home/detailed_notification_entrance';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_notification_rrb($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(8);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,8);
  $this->data['viewload'] = 'home/detailed_notification_rrb';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function exam($id=''){
  
  if(!empty($id)){
    $this->data['breadcrumb'] = $id;
    $questions = $this->session->userdata('sample_questions'.$id);
    if($id==1){$this->data['logo_ias']='';$time = 300;} //IAS
    if($id==2){$this->data['logo_UGC']='';$time = 600;} //NET/JRF 
    if($id==3){$this->data['logo_psc']='';$time = 600;} //PSC
    if($id==4){$this->data['logo_ssc']='';$time = 300;} //SSC
    if($id==5){$this->data['logo_banking']='';$time = 180;} //BANKING
    if($id==6){$this->data['logo_junior']='';$time = 600;} //JUNIUR
    if($id==7){$this->data['logo_entrance']='';$time = 600;} //JUNIUR
    if($id==8){$this->data['logo_rrb']='';$time = 600;} //JUNIUR
    if(!empty($questions) && $questions != "null"){
      if($this->session->userdata('sample_examSubmit'.$id)){
        redirect('exam-result?id='.$id);
      }
      $quest = json_decode($questions);
      $currentQuestion = $this->session->userdata('sample_currentquestion'.$id);
    }else{
        $questions=array();
      $raw_questions = $this->home_model->get_school_sample_questions($id);
      $school_name = $this->home_model->get_school_names($id);
      foreach($raw_questions as $key=>$val){
        $questions[$val->question_id] = $val;
      }
     $quest = array_rand($questions, 10);
      $this->session->set_userdata(array(
        'sample_questionSchool'.$id=>$school_name->school_name,
        'sample_questions'.$id=>json_encode($quest),
        'sample_currentMaxtime'.$id=>$time,
        'sample_currenttime'.$id=>$time,
        'sample_answers'.$id=>json_encode(array()),
        'sample_currentquestion'.$id=>$quest[0],
        'sample_currentquestionnumber'.$id=>0,
        'sample_examSubmit'.$id=>0
      ));
      $currentQuestion = $quest[0];
    }
    if(!empty($quest)){
      $this->data['question'] = $this->home_model->get_sample_question($currentQuestion);
      $this->data['questions'] = json_encode($quest);
      $this->data['school'] = $id;
      $this->data['viewload'] = 'home/exam';
      $this->load->view('_layouts_new/_master', $this->data);
    }else{
      //redirect('direction-ias-study-circle');
        //$uri= $this->uri->slash_segment(3,'leading');
        //redirect($uri);
        $this->session->set_flashdata('data_name', 'Sample test currently unavailable,Please try again later..!');
        redirect($_SERVER['HTTP_REFERER']);
    }
  }else{
    redirect('404');
  }
}

public function nextQuestion(){
  if($_POST){
    $answer = $this->input->post('answer');
    $question = $this->input->post('question');
    $nextQuestion = $this->input->post('nextQuestion');
    $school = $this->input->post('school');
    $nextQuestionNumber = $this->input->post('nextQuestionNumber');
    $saveAnswer[0][$question] = $answer;

    /*SAVE ANSWER*/
    $answered = json_decode($this->session->userdata('sample_answers'.$school));
    if(!is_array($answered) && empty($answered)){$answered = array();}
    $answered = array_merge($answered,$saveAnswer);
    $this->session->unset_userdata('sample_answers'.$school);
    $this->session->unset_userdata('sample_currentquestion'.$school);
    $this->session->set_userdata(array(
      'sample_answers'.$school=>json_encode($answered),
      'sample_currentquestion'.$school=>$nextQuestion,
      'sample_currentquestionnumber'.$school=>$nextQuestionNumber
    ));

    /* GET ANOTHER QUESTION */
    $questions = json_decode($this->session->userdata('sample_questions'.$school));
    if(!empty($questions) && in_array($nextQuestion,$questions)){
      $nextSampleQuestion = $this->home_model->get_next_sample_question($nextQuestion);
      $returnData['st'] 		= 1;
      $returnData['message'] 	= '<p class="alert alert-danger" style="padding:15px;">Success.</p>';
      $returnData['data'] = $nextSampleQuestion;
    }else{
      $returnData['st'] 		= 0;
      $returnData['message'] 	= '<p class="alert alert-danger" style="padding:15px;">Question not found.</p>';
      $returnData['data'] = array();
    }

  }else{
    $returnData['st'] 		= 0;
    $returnData['message'] 	= '<p class="alert alert-danger" style="padding:15px;">Server not responding.</p>';
    $returnData['data'] = array();
  }
  print_r(json_encode($returnData));
}

public function update_timer(){
  if($_POST){
    $time = $this->input->post('time');
    $school = $this->input->post('school');
    $this->session->unset_userdata('sample_currenttime'.$school);
    $this->session->set_userdata(array(
      'sample_currenttime'.$school=>json_encode($time)
    ));
  }
}

public function exam_result(){
  if(!empty($_GET['id'])){
    if(!empty($this->session->userdata('sample_questions'.$_GET['id']))){
      $this->session->set_userdata(array(
        'sample_examSubmit'.$_GET['id']=>1
      ));
      $questions = json_decode($this->session->userdata('sample_questions'.$_GET['id']));
      $answers = json_decode($this->session->userdata('sample_answers'.$_GET['id']),1);
       
      $answer = array();
      foreach($answers as $row){
        foreach($row as $key=>$val){
          $answer[$key] = $val;
            
        }
      }
      $raw_questions = $this->home_model->get_questions_answers($questions);
      
      $this->data['exam'] = $this->session->userdata('sample_questionSchool'.$_GET['id']);
      // print_r($this->data['exam']);exit;
      $this->data['questions'] = $raw_questions;
      $this->data['answers'] = $answer;
      $this->data['totalQuestions'] = count($questions);
      $this->data['questionsAttempted'] = 0;
      $this->data['correctAnswers'] = 0;
      $this->data['wrongAnswers'] = 0;
      $this->data['score'] = 0;
      
       foreach($raw_questions as $row){
         if($answer[$row->question_id] != '' &&  $answer[$row->question_id] != NULL && !empty($answer[$row->question_id])){
           $this->data['questionsAttempted']++;
           if($answer[$row->question_id] == $row->answer){
             $this->data['correctAnswers']++;
             $this->data['score']++;
           }else{
             $this->data['wrongAnswers']++;
             if(DAILY_TEST_NEGATIVE){
               $this->data['score'] = $this->data['score']-0.25;
             }
           }
         }
       }
      $id = $_GET['id'];
      if($id==1){$this->data['logo_ias']='';} //IAS
      if($id==2){$this->data['logo_UGC']='';} //NET/JRF 
      if($id==3){$this->data['logo_psc']='';} //PSC
      if($id==4){$this->data['logo_ssc']='';} //SSC
      if($id==5){$this->data['logo_banking']='';} //BANKING
      if($id==6){$this->data['logo_junior']='';} //JUNIUR
      
      $this->data['viewload'] = 'home/exam_result';
      $this->load->view('_layouts_new/_master', $this->data);
    }else{
      redirect('404');
    }
  }else{
    redirect('404');
  }
}

public function logout(){
  $this->session->sess_destroy();
  redirect(base_url('backoffice'));
}
    
    public function enquiry_add()
    {
      
      $enquiryName = $_POST['enquiry_name']; 
      $enquiryPhone = $_POST['enquiry_phone']; 
      $enquiryEmail = $_POST['enquiry_email']; 
         $res = $this->home_model->enquiry_add($_POST);
       
        if($res != 0)
        {
          $data=email_header();
          $data.='<td style="padding: 26px 26px">
                    <h3 style="font-family:  Open Sans, sans-serif;color: #333;font-size: 13px;margin: 0px;"></h3>
                    <p style="font-family: Open Sans, sans-serif;color: #727272;font-size: 13px;line-height: 26px; margin: 0px;">
                      Hello,<br> 
                      <b>You have a new enquiry from Mr/Mis. '.$enquiryName.'</b> <br> 
                      <b>Details</b>
                      <p>Phone :'.$enquiryPhone.'</p>
                      <p>Email :'.$enquiryEmail.'</p>
                    </p>
                  </td>';
          $data.=email_footer();
          $sMail = $this->home_model->getmailReceiver('callback_mail');
          $this->send_email("New Enquiry",$sMail,$data);
          $res=1; 
        }
          print_r($res);
    }
    
    
/*
*   Course details view
*   @params course id
*   @author GBS-R
*/
    
public function course_detail($id = NULL)
{
    $this->data['course'] = $this->home_model->get_coursedetails_id($id);
    $this->data['viewload'] = 'home/coursedetails_view';
    $this->load->view('_layouts/_master', $this->data); 
} 

public function success_stories_detail($id = NULL)
{
    $this->data['successArr'] = $this->home_model->get_successdetails_id($id);
    $this->data['viewload'] = 'home/successdetails_view';
    $this->load->view('_layouts_new/_master', $this->data); 
} 

public function detailed_batch($batch="",$school_id=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  if($school_id == ""){
    $school_id=  $_POST['school_id'];
  } 
  $this->data['breadcrumb'] = $school_id; 
  $this->data['batchArr']=$this->common->get_classes(1);
  $this->data['detailedArr']=$this->common->get_detailed_batch($batch,$school_id);
  $this->data['viewload'] = 'home/detailed_batch';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_result($notification="",$school_id=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  if($school_id == ""){
    $school_id=  $_POST['school_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(1);
  $this->data['detailedArr']=$this->home_model->get_detailed_result($notification,$school_id);
  $this->data['examArr']=$this->home_model->get_detailed_notification($notification,$school_id);
  $this->data['eresults'] = $this->home_model->get_detailed_notifications($notification,$school_id);
  $this->data['viewload'] = 'home/detailed_result';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_results($school_id=""){
  if($school_id == ""){
    $school_id=  $_POST['school_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(1);
  $this->data['detailedArr']=$this->home_model->get_detailed_results($school_id);
  $this->data['examArr']=$this->home_model->get_detail_notification($school_id);
  $this->data['eresults'] = $this->home_model->get_det_notifications($school_id);
  $this->data['viewload'] = 'home/detailed_results';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function all_notifications($notification="",$school_id=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  if($school_id == ""){
    $school_id=  $_POST['school_id'];
  }
  $this->data['notifications'] = $this->common->get_all_exams(); 

  $this->data['notificationArr']=$this->home_model->get_notification_list(1);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,$school_id);


  $this->data['batchArr']=$this->common->get_classes(1);
  $this->data['detailedArr']=$this->home_model->get_detailed_results($notification,$school_id);
  $this->data['examArr']=$this->home_model->get_detailed_notification($notification,$school_id);
  $this->data['eresults'] = $this->home_model->get_detailed_notifications($notification,$school_id);
  $this->data['viewload'] = 'home/detailed_notification';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function detailed_batch_net($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(2);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,2);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_psc($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(3);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,3);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_ssc($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(4);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,4);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_banking($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(5);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,5);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_junior($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(6);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,6);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_entrance($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(7);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,7);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_rrb($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_classes(8);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,8);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function schoolgallery($id = NULL){
  $this->data['viewload'] = 'home/school_gallery';
  $this->data['images'] = $this->home_model->schoolgallery($id);
  $this->data['breadcrumb'] = $id;
  // echo $this->db->last_query(); exit;
  $this->load->view('_layouts_new/_master', $this->data);
}
public function careerCheck(){
   $data = $this->home_model->get_careers();
  //  echo '<pre>'; print_r($data);
  foreach($data as $val){ 
    $lastDate = date($val->careers_date);
    date_default_timezone_set('asia/kolkata'); # add your city to set local time zone
    $now = date('d-m-Y');
    if($now > $lastDate){
      echo "expired";
      $this->home_model->inactiveCareer($val->careers_id);
    }else{
      echo "NO";
    }
  }
}
    
 public function get_class_session_byday($batch_id,$day)
  {
    $class_array=$this->common->get_alldata_orderby('am_batch_class_details',array("batch_id"=>$batch_id,"week_day"=>$day),'class_sequence_number','ASC');
    if(!empty($class_array))
    {
        $html='<table cellpadding="0" cellspacing="0">';
      foreach($class_array as $row)
      {
           $start_time =date('h:i A',strtotime($row['start_time'])); 
           $end_time=date('h:i A',strtotime($row['end_time']));
           $html.='<tr><td style="font-size:11px"> '.$start_time.'<br> to <br>'.$end_time.'</td></tr>'; 
      } 
         $html.='</table>';
    }
    else
    {
        $html='';
    }
    return $html;   
}
public function how_to_prepareSearch() {
  $html = ''; 
  $search = $this->input->post('search'); 
  $school = $this->input->post('school'); 
  if($search != '') {
      $howToPrepare         = $this->home_model->get_prepare_listSearch($search,$school); 
      if(!empty($howToPrepare)){
        $html .= '<div class="col-md-3">
          <div class="bnkhowprepare" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <ul class="nav flex-column nav-pills">';
                  $i=1; foreach($howToPrepare as $howTo){
                    $html .= '<li class=""><a class="nav-link'; if($i==1){ $html .= ' active'; } $html .= '" id="v-pills-id-'.$i.'" data-toggle="pill" href="#v-pills-'.$i.'" role="tab" aria-controls="v-pills-home" aria-selected="true">&nbsp;'.$this->common->get_name_by_id('web_category','category',array('id'=>$howTo['category_id'])).'</a></li>';
                  $i++; }
              $html .= '</ul>
          </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">';
                $i=1; foreach($howToPrepare as $howTo){ 
        $html .= '<div class="tab-pane fade'; if($i==1){ $html .= 'show active'; } $html .= '" id="v-pills-'.$i.'" role="tabpanel" aria-labelledby="v-pills-id-'.$i.'">
                    <h4>'.$this->common->get_name_by_id('web_category','category',array('id'=>$howTo['category_id'])).'</h4>
                    <p>
                    '.$howTo['content'].'
                    </p>
                </div>';
                $i++; }
        $html .= '</div>
        </div>';
      }else{
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
        <span>Content not found</span>
        </div>
        ';
      }
  }
  echo $html;
}
public function previous_question_viewSearch() {
  $html = ''; 
  $search = $this->input->post('search'); 
  $school = $this->input->post('school'); 
  $segment = $this->input->post('segment'); 
  if($search != '') {
      $module = $this->home_model->get_elearning_materials_maxidSearch($school, 'previous_question', $search); 
      $tutorialcontent         = $this->home_model->get_elearning_materialsSearch($school, 'previous_question', $search);
      $materialcontent        = $this->home_model->get_elearning_materials_categoryidSearch($school, $module, 'syllabus'); 
      if(!empty($tutorialcontent)){
        $html .= '<div class="  Topicswrapper ">
                <ul class="TopicList">';
                 if(!empty($tutorialcontent)) {
                        foreach($tutorialcontent as $tutorial) {
                         $html .= '<li class="'; if($tutorial->category_key == $this->uri->segment(2)){ $html .= 'active-2'; } $html .= '"><a href="'.base_url().$segment.'/'.$tutorial->category_key.'">'.$this->common->get_name_by_id('web_category','category',array('id'=>$tutorial->category_id)).'</a></li>';
                    }
                   }
        $html .= '</ul>
           </div>';
      }else{
        $html .= '
        <span>Content not found</span>';
      }
  }
  echo $html;
}
public function syllabus_viewSearch() {
  $html = ''; 
  $search = $this->input->post('search'); 
  $school = $this->input->post('school'); 
  $segment = $this->input->post('segment'); 
  if($search != '') {
      $module = $this->home_model->get_elearning_materials_maxidSearch($school, 'previous_question', $search); 
      // echo $module; exit;
      $tutorialcontent         = $this->home_model->get_elearning_materialsSearch($school, 'syllabus', $search);
      $materialcontent        = $this->home_model->get_elearning_materials_categoryidSearch($school, $module, 'syllabus'); 
      if(!empty($tutorialcontent)){
        $html .= '<div class="col-md-3"><div class="  Topicswrapper ">
        <ul class="TopicList">';
         if(!empty($tutorialcontent)) {
                foreach($tutorialcontent as $tutorial) {
                 $html .= '<li class="'; if($tutorial->category_key == $this->uri->segment(2)){ $html .= 'active-2'; } $html .= '"><a href="'.base_url().$segment.'/'.$tutorial->category_key.'">'.$this->common->get_name_by_id('web_category','category',array('id'=>$tutorial->category_id)).'</a></li>';
            }
           }
        $html .= '</ul>
           </div></div>';
           $html .= '<div class="col-md-9">';
                    if(!empty($materialcontent)) {
            $html .= '<div class="grow_wrap TopicListDet">';
                    $file = './uploads/webcontent/generalstudies/'.$materialcontent->topic_attachment;
                    if($materialcontent->topic_attachment != '') { 
                    if(file_exists($file)) {
                        $ext = pathinfo($materialcontent->topic_attachment, PATHINFO_EXTENSION);
                        if($ext != 'pdf'){
                          $url = 'https://view.officeapps.live.com/op/embed.aspx?'.http_build_query(array('src'=>base_url('uploads/webcontent/generalstudies/'.$materialcontent->topic_attachment)));
                          $iframe = '<iframe src="'.$url.'" frameborder="0" width="100%" height="800px"></iframe>';  
                        }
            $html .= '<div id="iframe"></div>';
                    }else{
            $html .= ' <strong>File doesn\'t exist</strong>';
                    } }else{ 
            $html .= '<strong>File doesn\'t exist</strong>';
                   }
            $html .= '</div>';
                   } 
            $html .= '</div>';
      }else{
        $html .= '
        <span>Content not found</span>';
      }
  }
  echo $html;
}

public function direction_online_payment($code) {
  $f = 0;
  $paymentCode = base64_decode($code);
  $paymentInfo = $this->home_model->get_paymentInfo_by_paymentcode($paymentCode);
  if(!empty($paymentInfo)){
    $batch_fee = $this->student_model->get_batchfee_bystudent_id($paymentInfo->student_id, $paymentInfo->institute_course_mapping_id); 
    if(!empty($batch_fee) && $batch_fee->course_paymentmethod == 'installment'){
      $installment = $this->common->get_batch_installment($batch_fee->institute_course_mapping_id);
      if(!empty($installment)){
        $amount = $installment[0]->installment_amount;
      }
    }
    if(!empty($batch_fee) && $batch_fee->course_paymentmethod == 'onetime'){
      $amount = $batch_fee->course_totalfee;
    }
    $discount = $this->common->get_student_discount_detailsstatusone($batch_fee->student_id, $batch_fee->course_master_id);
    $discountAmount = 0;
    if(!empty($discount)) {
      foreach($discount as $disc){
        $discountAmount += $disc->discount_amount;
      }
    }
    // show($discountAmount);
    if($discountAmount >= $amount){
      $f = 0;
    }else{
      $amount -= $discountAmount;
      $f = 1;
    }
    $this->data['orderId'] = $paymentInfo->student_id.'-'.$paymentInfo->institute_course_mapping_id;
    $this->data['name'] = $this->common->get_name_by_id('am_students','name',array('student_id'=>$paymentInfo->student_id));
    $this->data['cource'] = $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$batch_fee->course_master_id));
    $this->data['data'] = $amount;
  }else{
    $f = 2;
  }
  $this->data['flag'] = $f;
  $this->load->view('home/direction_online_payment', $this->data);
}

public function ccavenuepayment() {
  // $this->load->helper('Crypto');
  // show($_POST);
  // include(FCPATH.'application\third_party\Crypto.php');
	// error_reporting(0);
	$merchant_data='';
	$working_key='565EA2998D87D6DBE14E23B017423F27';//Shared by CCAVENUES
	$access_code='AVOH85GE27AU24HOUA';//Shared by CCAVENUES
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
  $encrypted_data = '';
  $encrypted_data=$this->encrypt($merchant_data,$working_key); // Method for encrypting the data.
    $html = '<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
    <input type=hidden name=encRequest value="'.$encrypted_data.'">
    <input type=hidden name=access_code value="'.$access_code.'">
    <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value='.$this->security->get_csrf_hash().'" />
    <p>Please wait </p>
    </form>
    </center>
    <script language=\'javascript\'>document.redirect.submit();</script>';
  echo $html;

}

public function redirect_payment(){
    // error_reporting(0);
	  $workingKey='';		//Working Key should be provided here.
	  $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	  $rcvdString=$this->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	  $order_status="";
	  $decryptValues=explode('&', $rcvdString);
	  $dataSize=sizeof($decryptValues);
	  $html .= "<center>";

	  for($i = 0; $i < $dataSize; $i++) {
	  	$information=explode('=',$decryptValues[$i]);
	  	if($i==3)	$order_status=$information[1];
	  }
  
	  if($order_status==="Success") {
	    $html .= "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
	  } else if($order_status==="Aborted") {
	    $html .= "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	  } else if($order_status==="Failure") {
	    $html .= "<br>Thank you for shopping with us.However,the transaction has been declined.";
	  } else {
	    $html .= "<br>Security Error. Illegal access detected";
    }
    
	  $html .= "<br><br>";
	  $html .= "<table cellspacing=4 cellpadding=4>";
	  for($i = 0; $i < $dataSize; $i++) {
	  	$information=explode('=',$decryptValues[$i]);
	    $html .= '<tr><td>'.$information[0].'</td><td>'.urldecode($information[1]).'</td></tr>';
	  }
	  $html .= "</table><br>";
    $html .= "</center>";
    echo $html;
}


/*
* @param1 : Plain String
* @param2 : Working key provided by CCAvenue
* @return : Decrypted String
*/
function encrypt($plainText,$key)
{
	$key = $this->hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt($encryptedText,$key)
{
	$key = $this->hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = $this->hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
}