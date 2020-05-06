<html lang="en">
<head>
    <title>Temple Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
        //CSS Files
        add_css('assets/css/dataTables.css');
        add_css('assets/css/bootstrap.min.css');
        add_css('assets/css/okayNav.css');
        add_css('assets/css/bootstrap.css');
        add_css('assets/css/bootstrap-datepicker3.min.css');
        add_css('assets/css/jquery-confirm.min.css');
        add_css('assets/css/custom_version.css');
        add_css('assets/css/developer.css');
        //JS Files
        add_js('assets/js/jquery.min.js');
        add_js('assets/js/jquery-1.11.3.js');
        add_js('assets/js/popper.min.js');
        add_js('assets/js/bootstrap.min.js');
        add_js('assets/js/jquery.dataTables.min.js');
        add_js('assets/js/parsley.js');
        add_js('assets/js/moment.js');
        add_js('assets/js/bootstrap-datepicker.js"');
        add_js('assets/js/jquery-confirm.min.js');
        add_js('assets/js/form.js');
        add_js('assets/js/toaster.js');
        add_js('assets/js/babel/babel.js');
        add_js('assets/js/utils.js');
        add_js('assets/js/bootbox.min.js');
        add_js('assets/js/script.js');
        add_js('assets/js/scrollBar.js');
        add_js('assets/js/jquery.okayNav.js');
        add_js('assets/js/jquery.validate.min.js');
        add_js('assets/js/scrollBar.js');
        add_js('assets/js/jquery.marquee.js');
		add_js('assets/js/Chart.min.js');
		add_js('assets/js/core.js');
        add_js('assets/js/charts.js');
		add_js('assets/js/animated.js');
    ?>
    <?php function add_css($url) { ?>
        <link href="<?php echo base_url($url) . "?v=" . SCRIPT_CACHE_CODE ?>" rel="stylesheet" type="text/css" />
    <?php } ?>
    <?php function add_js($url) { ?>
         <script src="<?php echo base_url($url) . "?v=" . SCRIPT_CACHE_CODE ?>" ></script>
    <?php } ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="load">
        <img src="<?php echo base_url() ?>assets/images/loading.svg">
    </div>
    <section class="header">
        <a href="" class="logo">
            <img src='<?php echo base_url("assets/images/logo.png");?>'   class="img-fluid" >
        </a>
        <h1>Temple Management System</h1>
        
       
        <a href="<?php echo base_url() ?>logout"><span class="fa fa-power-off"></span></a>
        





        <div class="dropdown">
            <a class=" dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fa fa-cog frft"></span>
            </a>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <li class="dropdown-item">
                    <a href="<?php echo base_url('auth/change_password') ?>">Change Password</a>
                </li>
                <li class="dropdown-submenu  left-submenu">
                    <a class="dropdown-item" tabindex="-1" href="#">Switch Language</a>
                    <ul class="dropdown-menu">
                        <?php foreach($languages as $row){
                            if($row->id == $this->session->userdata('language')){
                                echo "<li class='dropdown-item active'>";
                            }else{
                                echo "<li class='dropdown-item'>";
                            }
                            echo "<a href='".base_url()."auth/switch_language/$row->id'>$row->language</a>";
                            echo "</li>";
                        } ?>
                    </ul>
                </li>
                <li class="dropdown-submenu  left-submenu">
                    <a class="dropdown-item" tabindex="-1" href="#">Switch Temple</a>
                    <ul class="dropdown-menu">
                        <?php foreach($temples as $row){
                            if($row->id == $this->session->userdata('temple')){
                                echo "<li class='dropdown-item active'>";
                            }else{
                                echo "<li class='dropdown-item'>";
                            }
                            echo "<a href='".base_url()."auth/switch_temple/$row->id'>$row->temple</a>";
                            echo "</li>";
                        } ?>
                    </ul>
                </li>
            </ul>
        </div>

		<div id="noti">
        <div id="noti_Counter"></div>
        <div id="noti_Button"><i class="fa fa-bell"></i></div>
        <div id="notifications">

            <h3>Notifications </h3>
            <div class="Notlist">
                <div class="sb-container customScrollbar">
                    <ul>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                        <li>
                            <h6>Dummy </h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                <span>4 Hours Ago</span>
                                <p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="seeAll"><a href="#">See All</a></div>

        </div>
    </div>
    

        <span class="user_name"><?php echo $this->session->userdata('name') ?></span>
    </section>
    <section class="menu_wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row MenuBox">
                    <div role="" id="nav-main"  class="okayNav">
                        <ul>
                            <?php 
                            foreach($mainmenu as $row){
                                echo "<li>";
                                if($main_menu_id == $row['id']){
                                    echo "<a class='active' href='".base_url().$row['link']."'>".$row['menu']."</a>";
                                }else{
                                    echo "<a  href='".base_url().$row['link']."'>".$row['menu']."</a>";
                                }
                                echo "</li>";
                            } 
                            ?> 
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<section class="content_section">
   <section class="breadcrumb_section">
      <div class="container-fluid">
         <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a><?php echo $mainMenuLabel['menu'] ?></a></li>
            <li class="breadcrumb-item"><a><?php echo $subMenuLabel['sub_menu']; ?></a></li>
         </ol>
      </div>
   </section>
   <section class="tab_content_section">
      <div class="container-fluid">
         <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-xs-12">
               <nav id="SideNav">
                  <ul>
                     <?php 
                        foreach($submenu as $row){
                          echo "<li class='nav-item'>";
                          if($subMenuId == $row['id']){
                            echo "<a class='nav-link active_sub_menu' style='border-bottom: 1px solid #B14B10;' href='".base_url().$row['link']."'>".$row['sub_menu']."</a>";
                         }else{
                            echo "<a class='nav-link' href='".base_url().$row['link']."'>".$row['sub_menu']."</a>";
                         }
                         echo "</li>";
                        } 
                        ?>
                  </ul>
               </nav>
            </div>
