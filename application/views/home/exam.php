
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Exam</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php if($breadcrumb == 1){
                        echo '<a href="'.base_url('direction-ias-study-circle').'"> Direction IAS Study circle </a>'; 
                    }else if($breadcrumb == 2){
                        echo '<a href="'.base_url('direction-school-for-netjrf-examinations').'"> Direction School for NET/JRF Examinations </a>'; 
                    }else if($breadcrumb == 3){
                        echo '<a href="'.base_url('direction-school-for-psc-examinations').'"> Direction School for PSC Examinations </a>'; 
                    }else if($breadcrumb == 4){
                        echo '<a href="'.base_url('direction-school-for-ssc-examinations').'"> Direction School for SSC Examinations </a>'; 
                    }else if($breadcrumb == 5){
                        echo '<a href="'.base_url('direction-school-of-banking').'"> Direction School of Banking </a>'; 
                    }else if($breadcrumb == 6){
                        echo '<a href="'.base_url('direction-junior').'"> Direction Junior </a>'; 
                    }else if($breadcrumb == 7){
                        echo '<a href="'.base_url('direction-school-for-entrance-examinations').'"> Direction school for Entrance Examinations </a>'; 
                    }else if($breadcrumb == 8){
                        echo '<a href="'.base_url('direction-school-for-rrb-examinations').'"> Direction school for RRB examinations </a>'; 
                    }?>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Exam</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="grow_wrap">
                        <h1 class="grow_header">Sample test <br><?php echo $this->session->userdata('sample_questionSchool'.$school);?></h1>
                        <ul class="grow_list exam_time">
                            <li><i class="fa fa-clock-o"></i>Time left: <label id="timer"></label></li>
                        </ul>
                        <div class="progress exam_progress">
                            <div class="progress-bar progress-bar-striped active" id="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                        </div>
                        <div class="question_wrap">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <span class="question"><?php echo $this->session->userdata('sample_currentquestionnumber'.$school)+1;?>.Question</span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <span class="point">1 Point</span>
                                </div>
                            </div>
                        </div>
                        <p class="question_index"><?php echo $question->question; ?></p>
                        <div class="answer">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input"  name="optradio" value="A"/><span id="option1"><?php echo $question->question_option_a; ?></span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="B"/><span id="option2" ><?php echo $question->question_option_b; ?></span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="C"/><span id="option3" ><?php echo $question->question_option_c; ?></span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio" value="D"/><span  id="option4"><?php echo $question->question_option_d; ?></span>
                                  
                                </label>
                            </div>
                        </div>

                       <!-- <button class="btn btn-info btn_next_ques btn_prev_ques" id="prevQuestion">Previous</button>-->
                        <button class="btn btn-info btn_next_ques" id="nextQuestion">Next</button>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
        $this->load->view('home/scripts/exam_script');
    ?>
