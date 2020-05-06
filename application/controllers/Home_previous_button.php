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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
    // $this->data['notifications']=$this->success_model->get_stories_list(1);
    $this->data['notification'] = $this->user_model->get_notification_by_school(1);

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
    $this->data['viewload'] = 'home/iasstudycircle';
    // $this->data['batches']=$this->common->get_batches(1);
    // $batches= $this->common->get_batches(1);
    // echo $this->db->last_query();
    // echo '<pre>';
    // print_r($batches);
    // die();

    $this->data['slider']=$this->home_model->get_slidercontent(1);
    $this->data['notificationArr']=$this->home_model->get_notification_list(1);
    $this->data['successArr']=$this->success_model->get_stories_list(1);
    $this->data['teamArr']=$this->home_model->get_team_list(1);
    $this->data['specialArr']=$this->home_model->get_special_list(1);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
    $this->load->view('_layouts_new/_master', $this->data);

  }
      
      
  public function sscexaminations($year="") {
    if($year == ""){
      $year=date('Y');
    }
    $this->load->model('home_model');
    $this->load->model('success_model');
    $this->data['slider']=$this->home_model->get_slidercontent(4);
    $this->data['notificationArr']=$this->home_model->get_notification_list(4);
    $this->data['successArr']=$this->success_model->get_stories_list(4);
    $this->data['teamArr']=$this->home_model->get_team_list(4);
    $this->data['specialArr']=$this->home_model->get_special_list(4);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,4);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(4);
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
    $this->data['slider']=$this->home_model->get_slidercontent(2);
    $this->data['notificationArr']=$this->home_model->get_notification_list(2);
    $this->data['successArr']=$this->success_model->get_stories_list(2);
    $this->data['teamArr']=$this->home_model->get_team_list(2);
    $this->data['specialArr']=$this->home_model->get_special_list(2);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,2);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(2);
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
    $this->data['slider']=$this->home_model->get_slidercontent(5);
    $this->data['notificationArr']=$this->home_model->get_notification_list(5);
    $this->data['successArr']=$this->success_model->get_stories_list(5);
    $this->data['teamArr']=$this->home_model->get_team_list(5);
    $this->data['specialArr']=$this->home_model->get_special_list(5);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,5);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(5);
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
    $this->data['slider']=$this->home_model->get_slidercontent(3);
    $this->data['notificationArr']=$this->home_model->get_notification_list(3);
    $this->data['successArr']=$this->success_model->get_stories_list(3);
    $this->data['teamArr']=$this->home_model->get_team_list(3); 
    $this->data['specialArr']=$this->home_model->get_special_list(3);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,3);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(3);
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
    $this->data['slider']=$this->home_model->get_slidercontent(6);
    $this->data['notificationArr']=$this->home_model->get_notification_list(6);
    $this->data['successArr']=$this->success_model->get_stories_list(6);
    $this->data['teamArr']=$this->home_model->get_team_list(6);
    $this->data['specialArr']=$this->home_model->get_special_list(6);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,6);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(6);
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
    $this->data['slider']=$this->home_model->get_slidercontent(7);
    $this->data['notificationArr']=$this->home_model->get_notification_list(7);
    $this->data['successArr']=$this->success_model->get_stories_list(7);
    $this->data['teamArr']=$this->home_model->get_team_list(7);
    $this->data['specialArr']=$this->home_model->get_special_list(7);
    $this->data['galleryArr']=$this->home_model->get_achievers_list($year,7);
    $this->data['prepareArr']=$this->home_model->get_prepare_list(7);
    $this->data['logo_junior'] = 1;
    $this->data['viewload'] = 'home/entrance_view';
    $this->load->view('_layouts_new/_master', $this->data);
      
  }
      
      
  public function aboutus(){
    $this->data['viewload'] = 'home/aboutus_view';
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);

  }
      
      
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
    // $this->load->view('_layouts/_master', $this->data);
    $this->load->view('_layouts_new/_master', $this->data);
  }
      
  public function growwithus(){
    $this->data['viewload'] = 'home/growwithus_view';
    $this->load->view('_layouts/_master', $this->data);
  }

  public function gallery_view(){
    $this->data['viewload'] = 'home/gallery_view';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function results(){
    $this->data['viewload'] = 'home/results';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function services(){
    $this->data['viewload'] = 'home/services';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function difp(){
    $this->data['viewload'] = 'home/difp';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function sitemap(){
    $this->data['viewload'] = 'home/sitemap';
    $this->load->view('_layouts_new/_master', $this->data);
  }

  public function whydirection(){
    $this->data['viewload'] = 'home/whydirection_view';
    $this->load->view('_layouts/_master', $this->data);
  } 

  public function success_stories(){
    $this->load->model('success_model');
    $this->data['successArr']=$this->success_model->get_stories_list(1);
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
   $tutorial = explode('-', $key); 
   $subject_id = $tutorial[1]; 
   $this->data['tutorials'] = '';
   $this->data['material'] = '';
   if($subject_id!='') {
       $tutorialcontent         = $this->Material_model->get_elearning_materials($subject_id, 'E-learning'); 
       $this->data['tutorials'] = $tutorialcontent;
   } 
   if($module != '') { 
        $module = explode('-', $module); 
        $material_id = $module[1]; 
        $materialcontent        = $this->Material_model->get_elearning_materials_id($material_id, 'E-learning'); 
        $this->data['material'] = $materialcontent; 
   }
   $this->data['viewload'] = 'home/tutoriallisting_view';
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
  $this->load->view('_layouts_new/_master', $this->data);
}
public function netjrfhowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(2);
  $this->data['viewload'] = 'home/howtoprepare_view_net';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function pschowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(3);
  $this->data['viewload'] = 'home/howtoprepare_view_psc';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function sschowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(4); 
  $this->data['viewload'] = 'home/howtoprepare_view_ssc';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function bankinghowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(5);
  $this->data['viewload'] = 'home/howtoprepare_view_banking';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function juniorhowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(6);
  $this->data['viewload'] = 'home/howtoprepare_view_junior';
  $this->load->view('_layouts_new/_master', $this->data);
}
public function entrancehowtoprepare(){
  $this->load->model('home_model');
  $this->data['prepareArr']=$this->home_model->get_prepare_list(1);
  $this->data['viewload'] = 'home/howtoprepare_view_entrance';
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

public function upcoming_notifications_ias(){
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(1);
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

public function detailed_notification_ias($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(1);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,1);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function detailed_notification_net($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(2);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,2);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function detailed_notification_psc($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(3);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,3);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function detailed_notification_ssc($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(4);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,4);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function detailed_notification_banking($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(5);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,5);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function detailed_notification_junior($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(6);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,6);
  $this->data['viewload'] = 'home/detailed_notification_ias';
  $this->load->view('_layouts/_master', $this->data);
}

public function detailed_notification_entrance($notification=""){
  if($notification == ""){
    $notification=  $_POST['notification_id'];
  }
  $this->load->model('home_model');
  $this->data['notificationArr']=$this->home_model->get_notification_list(7);
  $this->data['detailedArr']=$this->home_model->get_detailed_notification($notification,7);
  $this->data['viewload'] = 'home/detailed_notification_entrance';
  $this->load->view('_layouts/_master', $this->data);
}

public function exam($id=''){
  if(!empty($id)){
    //  echo $id;
    $questions = $this->session->userdata('sample_questions'.$id);
    if($id==1){$this->data['logo_ias']='';$time = 300;} //IAS
    if($id==2){$this->data['logo_UGC']='';$time = 600;} //NET/JRF 
    if($id==3){$this->data['logo_psc']='';$time = 600;} //PSC
    if($id==4){$this->data['logo_ssc']='';$time = 300;} //SSC
    if($id==5){$this->data['logo_banking']='';$time = 180;} //BANKING
    if($id==6){$this->data['logo_junior']='';$time = 600;} //JUNIUR
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
      redirect('404');
    }
  }else{
    redirect('404');
  }
}
public function nextQuestion(){
  if($_POST){
   //  print_r($_POST);
    $answer = $this->input->post('answer');
    $question = $this->input->post('question');
    $nextQuestion = $this->input->post('nextQuestion');
    $school = $this->input->post('school');
    $nextQuestionNumber = $this->input->post('nextQuestionNumber');
    $saveAnswer[0][$question] = $answer;

      
    /*SAVE ANSWER*/
    $answered = json_decode($this->session->userdata('sample_answers'.$school));
    if(!is_array($answered) && empty($answered)){$answered = array();}
     // $answered = array_merge($answered,$saveAnswer);
      foreach($answered as $k=>$ans)
      {
   
         if(isset($answered[$k]->$question))
          {
             
              unset($answered[$k]);
          }      
      }
     $answered = array_merge($answered,$saveAnswer);
 // print_r($answered);
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
     // $answers =  json_decode($this->session->userdata('sample_answers'.$school));
        $returnData['answer']="";
        //print_r($answered);
        if(!empty($answered))
       {
           foreach($answered as $key=> $row)
           {
              // print_r($row);
             $obj_key = key((array)$row);
                 //echo $obj_key; 
                   if($nextQuestion == $obj_key)
                   {
                      
                        $returnData['answer'] = $answered[$key]->$obj_key; 
                   }
               
           }
       }
       
        
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
      
      // foreach($raw_questions as $row){
      //   if($answer[$row->question_id] != '' &&  $answer[$row->question_id] != NULL && !empty($answer[$row->question_id])){
      //     $this->data['questionsAttempted']++;
      //     if($answer[$row->question_id] == $row->answer){
      //       $this->data['correctAnswers']++;
      //       $this->data['score']++;
      //     }else{
      //       $this->data['wrongAnswers']++;
      //       if(DAILY_TEST_NEGATIVE){
      //         $this->data['score'] = $this->data['score']-0.25;
      //       }
      //     }
      //   }
      // }
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
      
         $res = $this->home_model->enquiry_add($_POST);
        if($res != 0)
        {
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





public function detailed_batch_ias($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(1);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,1);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_net($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(2);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,2);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_psc($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(3);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,3);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_ssc($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(4);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,4);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_banking($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(5);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,5);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_junior($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(6);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,6);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

public function detailed_batch_entrance($batch=""){
  if($batch == ""){
    $batch=  $_POST['batch_id'];
  }
  $this->data['batchArr']=$this->common->get_batches(7);
  $this->data['detailedArr']=$this->common->get_detailed_notification($batch,7);
  $this->data['viewload'] = 'home/ias_aspirants_view';
  $this->load->view('_layouts_new/_master', $this->data);
}

    
}
