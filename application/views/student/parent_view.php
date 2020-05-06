<section class="top_strip top_strip_profile" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
    <div class="container">
        <div class="profile_details">
            <?php
               $profile_img =  base_url().'assets/images/profile_img.png';
            ?>
            <div class="profile_details_img" style="background-image: url(<?php echo $profile_img;?>);"></div>
            <h4></h4>
            <ul>
                <li><img src="<?php echo base_url();?>assets/images/mail_round.png" class="img-responsive" /> </li>
                <li><img src="<?php echo base_url();?>assets/images/telephone_profile.png" class="img-responsive" /></li>
                <li><img src="<?php echo base_url();?>assets/images/location-profile.png" class="img-responsive" /></li>
            </ul>
        </div>
    </div>
</section>

<section class="nav_profile">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a data-toggle="pill" href="#studDashboard" class="active">Dashboard </a></li>
            <li><a data-toggle="pill" href="#studProfile">Profile</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li>
            <li><a data-toggle="pill" href="#myexams" id="studentexams">My Exams</a></li>
            <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Progress Report</a></li>
            <li><a data-toggle="pill" href="#studMaterials">Study Materials</a></li>
        </ul>
    </div>
</section>

    <section class="marquee_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="marquee_wrap">
                        <div class="jctkr-label">
                            <span>Exams And Notifications</span>
                        </div>
                        <div class="js-conveyor-example">
                            <ul style="list-style-image: url(images/list_style.png)!important;">
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="profile_page">
    <div class="container">
        <div class="tab-content">
            <div id="studDashboard" class="tab-pane fade  active show">
                <h3>Dashboard</h3>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="Dboard">
                                <h3>Upcoming 5 sections</h3>
                                    <div class="table-responsive">
                                            <table class="table table-bordered table-sm ExaminationList">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th class="text-left">Module</th>
                                                        <th class="text-left">Faculty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="NotBox">
                                 <h3>Notification</h3>
                            </div>
                            <div class="NewsNotification">
                                <div class="block-hdnews">
                                    <div class="list-wrpaaer" >
                                    </div><!-- list-wrpaaer -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="my_profile" class="tab-pane fade  active show">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="parentmodel">
                                <div class="SelectBoxs">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Select Child</label>
                                        <div class="col-sm-9">
                                            <select class="custom-select childselection">
                                                <option selected="selected">Select Child</option>
                                                <?php 
                                                if(!empty($students)) {
                                                foreach($students as $student) {
                                                    echo '<option value="'.$student->student_id.'">'.$student->name.'</option>';
                                                }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</section>

<?php $this->load->view("user/scripts/user_script"); ?>
