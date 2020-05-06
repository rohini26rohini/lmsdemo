
    <!-- <section class="top_strip" style="background-image: url(<?php echo base_url('assets/'); ?>images/banner_bg.png);">
        <div class="container">
            <h3>Exam</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Exam
                </li>
            </ol>
        </div>
    </section> -->
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Exam</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Exam</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="grow_wrap">
                        <h1 class="grow_header">
                                Your Result<br>
                                <?php echo $exam; ?>
                        </h1>
                        <div class="table-responsive table_result">
                            <table class="table table-striped">
                                <tr>
                                    <th colspan="2" style="background: #004e94;color: #fff;">
                                        Your Result
                                    </th>
                                </tr>
                                <tr>
                                    <th>Total No. of Questions:</th>
                                    <td><?php echo $totalQuestions; ?></td>
                                </tr>
                                <tr>
                                    <th>Number of Questions attempted :</th>
                                    <td><?php echo $questionsAttempted; ?></td>
                                </tr>
                                <tr>
                                    <th>Number of Correct Answers:</th>
                                    <td><?php echo $correctAnswers; ?></td>
                                </tr>
                                <tr>
                                    <th>Number of Wrong Answers:</th>
                                    <td><?php echo $wrongAnswers; ?></td>
                                </tr>
                                <tr>
                                    <th>Your Score :</th>
                                    <td><?php echo $score; ?></td>
                                </tr>
                            </table>




                        </div>
                        <h4 class="course_header">Answer Key</h4>
                        <hr class="course_hr">
                        <?php 
                            if(!empty($questions)){
                                $i=1;
                                foreach($questions as $key=>$row){
                        ?>
                        <div class="table-responsive  table_result">
                            <table class="table table-striped table-bordered">
                                <tr style="background: #004e94;color: #fff;">
                                    <th style="width:20px"><?php echo $i++; ?>.</th>
                                    <th><?php echo $row->question; ?></th>
                                </tr>
                                <tr>
                                    <td>A.</td>
                                    <td><?php echo $row->question_option_a; ?></td>
                                </tr>
                                <tr>
                                    <td>B.</td>
                                    <td><?php echo $row->question_option_b; ?></td>
                                </tr>
                                <tr>
                                    <td>C.</td>
                                    <td><?php echo $row->question_option_c; ?></td>
                                </tr>
                                <tr>
                                    <td>D.</td>
                                    <td><?php echo $row->question_option_d; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Your Answer : <?php if(!empty($answers)) {echo $answers[$row->question_id]; }?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Correct Answer: <?php echo $row->answer; ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php }} ?>
                    </div>

                </div>
                <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                    <h5 class="grow_banner_head">Our Course
                    </h5>
                    <div id="grow_career" class="carousel slide grow_career" data-ride="carousel">

                        <ul class="carousel-indicators">
                            <li data-target="#grow_career" data-slide-to="0" class="active"></li>
                            <li data-target="#grow_career" data-slide-to="1"></li>
                            <li data-target="#grow_career" data-slide-to="2"></li>
                            <li data-target="#grow_career" data-slide-to="3"></li>
                            <li data-target="#grow_career" data-slide-to="4"></li>
                            <li data-target="#grow_career" data-slide-to="5"></li>
                        </ul>

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="grow_career_wrap" style="background-image: url(<?php echo base_url('assets/'); ?>images/Grow_slider_1.png)">
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="grow_career_wrap" style="background-image: url(<?php echo base_url('assets/'); ?>images/Grow_slider_1.png)"> </div>
                            </div>
                            <div class="carousel-item">
                                <div class="grow_career_wrap" style="background-image: url(<?php echo base_url('assets/'); ?>images/Grow_slider_1.png)"></div>
                            </div>
                            <div class="carousel-item">
                                <div class="grow_career_wrap" style="background-image: url(<?php echo base_url('assets/'); ?>images/Grow_slider_1.png)"></div>
                            </div>
                            <div class="carousel-item">
                                <div class="grow_career_wrap" style="background-image: url(<?php echo base_url('assets/'); ?>images/Grow_slider_1.png)"></div>
                            </div>
                            <div class="carousel-item">
                                <div class="grow_career_wrap" style="background-image: url(<?php echo base_url('assets/'); ?>images/Grow_slider_1.png)"></div>
                            </div>

                        </div>
                    </div>

                    <div class="grow_career_list">
                        <h4>Courses Features</h4>
                        <ul>
                            <a href="<?php echo base_url('direction-ias-study-circle');?>">
                                <li><i class="fa fa-angle-double-right"></i>Direction IAS Study circle</li>
                            </a>
                            <a href="<?php echo base_url('direction-school-for-ssc-examinations');?>">
                                <li><i class="fa fa-angle-double-right"></i>Direction School for SSC Examinations </li>
                            </a>
                            <a href="<?php echo base_url('direction-school-for-netjrf-examinations');?>">
                                <li><i class="fa fa-angle-double-right"></i>Direction School for NET/JRF Examinations</li>
                            </a>
                            <a href="<?php echo base_url('direction-school-of-banking');?>">
                                <li><i class="fa fa-angle-double-right"></i>Direction School of Banking </li>
                            </a>
                            <a href="<?php echo base_url('direction-school-for-psc-examinations');?>">
                                <li><i class="fa fa-angle-double-right"></i>Direction School of PSC examinations </li>
                            </a>
                            <a href="<?php echo base_url('direction-junior');?>">
                                <li><i class="fa fa-angle-double-right"></i>Direction Junior</li>
                            </a>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
