<?php //echo '<pre>';  print_r($myexams); ?>
<div class="ExmResults">
                        <h6 class="ExamCaption"><?php echo (!empty($myexams)?$myexams->name:'');?></h6>
                        <!--<ul class="nav nav-bar  justify-content-between">
                            <li class="TotalMark">Total Score <span>100</span></li>
                            <li class="TotalMark">Top Score <span>100</span></li>
                        </ul>-->
    <?php //echo '<pre>'; print_r($questions);?>
                        <?php
                        $sectionArr = array();
                        if(!empty($questions)) {
                           foreach($questions as $question) {
                               //array_push($sectionArr, $question->exam_section_details_id);
                               array_push($sectionArr, $question->subject_id);
                           }
                           $sectionArr = array_unique($sectionArr);
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table ExaminationList">
                                <tr>
									<th>Answered</th>
									<th>Mark Obtained</th>
									<th>Negative mark</th>
									<th>Total Mark</th>
                                    <?php
                                    if(count($sectionArr)>1) {
                                    foreach($sectionArr as $section) {
                                        $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
                                    ?>
                                    <th><?php echo $sectionDet['section_name'];?></th>
                                    <?php } ?>
                                    <?php } ?>
                                </tr>
                                <tr>
								<td>
                                        <?php echo (!empty($myexams)?$myexams->correct_answers+$myexams->wrong_answers:'');?>
                                    </td>
								<td>
                                        <?php echo (!empty($myexams)?$myexams->mark_obtained:'');?>
                                    </td>
									<td>
                                        <?php echo (!empty($myexams)?$myexams->negative_mark:'');?>
                                    </td>
								<td>
                                        <span class="score"><?php echo (!empty($myexams)?$myexams->total_mark:'');?></span>
                                        <span class="Tolscore">
                                            <?php
                                            $questionDet = $this->common->get_exam_details_by_scheduleid($myexams->exam_id); if(!empty($questionDet)) { echo $questionDet['totalmarks'];}
                                            ?></span>
                                    </td>
                                    <?php
                                    if(count($sectionArr)>1) {
                                    foreach($sectionArr as $section) {
                                        $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
                                        $mark = 0;
                                        $nmark= 0;
                                        foreach($questions as $question) {
                                                if($question->subject_id==$section){
                                                $anserclass = '';
                                                $st_answer = $this->common->get_student_answer($myexams->attempt, $myexams->exam_id, $this->session->userdata('user_id'), $question->question_id);
                                                if(!empty($st_answer)) {
                                                    if($st_answer->correct==1) {
                                                         $mark += $st_answer->mark;
                                                    } else {
                                                        $nmark += $st_answer->negative_mark;
                                                    }
                                                }
                                        }
                                        }
                                    ?>
                                    <td>
                                        <?php echo $mark-$nmark;?>
<!--                                        <span class="score"> </span>-->
<!--                                        <span class="Tolscore">50</span>-->
                                    </td>
                                    <?php } ?>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="QuestionSection">
                                    <div class="Ans">
                                        <ul class="nav nav-pills">
                                        <?php if(count($sectionArr)==1) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="pill" href="#home">All Questions</a>
                                            </li>
                                            <?php } ?>
                                            <?php if(count($sectionArr)>1) {
                                                $c = 1;
                                            foreach($sectionArr as $section) {
                                                $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if($c==1) { echo 'active'; } ?>" data-toggle="pill" href="#menu<?php echo $sectionDet['id'];?>"><?php echo $sectionDet['section_name'];?></a>
                                            </li>
                                            <?php $c++;?>
                                            <?php } ?>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content">
                                        <?php  if(count($sectionArr)==1) { ?>
                                            <div class="tab-pane  active" id="home">
                                                <div class="QuestionNoBox">
                                                    <ul>
                                                        <?php
                                                        $timetaken = 0;
                                                        $qcount    = 0;
                                                        $question_type      = '';
                                                        if(!empty($questions)) {
															$x = 1;
                                                            foreach($questions as $question) {
                                                                $anserclass = '';
                                                                $time_taken = '';
                                                                $st_answer = $this->common->get_student_answer($myexams->attempt, $myexams->exam_id, $this->session->userdata('user_id'), $question->question_id); 
                                                                if(!empty($st_answer)) {
                                                                    $qcount++;
                                                                    if($st_answer->correct==1) {
                                                                        $anserclass = 'rightans';
                                                                    } else {
                                                                        $anserclass = 'wrongans';
                                                                    }
                                                                    $time_taken = $st_answer->time_taken;
                                                                    $timetaken += $st_answer->time_taken;
                                                                    $selected_choices = $st_answer->selected_choices;
                                                                    $question_type = $st_answer->question_type;
                                                                } else {
                                                                    $selected_choices   = '';
                                                                    $question_type      = '';
                                                                }
                                                        ?>
                                                         <li><a class="questionno getquestionbyid <?php echo $anserclass;?>" id="<?php echo $question->question_id;?>" alt="<?php echo $selected_choices;?>" status="<?php echo $question_type;?>"><?php echo $question->question_number;?></a><span><i
                                                                    class="fa fa-clock-o"></i><?php if($time_taken!='') { echo $time_taken.'sec'; }?></span></li>
<!--                                                        <li class="questionno getquestionbyid <?php echo $anserclass;?>" id="<?php echo $question->question_id;?>" alt="<?php echo $selected_choices;?>"><?php echo $question->question_number;?></li>-->
                                                        <?php 
															$x++;
															} ?>
                                                        <?php } ?>
                                                    </ul>
                                                    <div class="table-responsive col-xl-5 col-lg-5 col-md-6 col-sm-12 col-12">
                                                        <!-- <ul class="nav nav-bar justify-content-between ">
                                                            <li><h4>Total Time Take <span>120 min</span></h4></li>
                                                            <li><h4>Total Time Take <span>120 min</span></h4></li>
                                                        </ul> -->
                                                        <table  class="table table-bordered table-sm Taltme">
                                                            <tr>
                                                                <td>Time taken by you to complete this exam</td>
                                                                <td><?php echo $timetaken;?>sec</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Average time taken by you to answer a question</td>
                                                                <td><?php if($qcount>0) { echo number_format($timetaken/$qcount,2); } else { echo '0';}?>sec</td>
                                                            </tr>
															<?php
															if(!empty($questions)) {
                                                            foreach($questions as $question) {
																$review_answer = $this->common->get_student_answer_review($myexams->exam_id, $question->question_id); 
															?>
															<tr id="questionavg<?php echo $question->question_id;?>" class="hidequestionclass" style="display:none;">
                                                                <td>Avg. time spent on this question by student who got this question right</td>
                                                                <td><?php if(!empty($review_answer)) { echo number_format($review_answer->timetaken,2).'sec'; } ?></td>
                                                            </tr>
															<tr id="question<?php echo $question->question_id;?>" class="hidequestionclass" style="display:none;">
                                                                <td>% of student who got the question right of those who attempted</td>
                                                                <td><?php if(!empty($review_answer)) { echo number_format($review_answer->atnd_percent,2); }?></td>
                                                            </tr>
															<?php 
																	}
																}
															?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if(count($sectionArr)>1) {
											$y = 1; $yy = 1;
                                            foreach($sectionArr as $section) {
                                                $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
                                            ?>
                                            <div class="tab-pane  <?php if($y==1) { echo 'active'; } else { echo 'fade'; }?>"" id="menu<?php echo $sectionDet['id'];?>">
                                                <div class="QuestionNoBox">
                                                    <ul>
                                                        <?php
                                                        $timetaken = 0;
                                                        $qcount    = 0;
                                                        if(!empty($questions)) {
                                                            foreach($questions as $question) {
                                                                if($question->subject_id==$section){
                                                                $anserclass = '';
                                                                $time_taken = '';
                                                                $st_answer = $this->common->get_student_answer($myexams->attempt, $myexams->exam_id, $this->session->userdata('user_id'), $question->question_id);
                                                                if(!empty($st_answer)) {
                                                                    $qcount++;
                                                                    if($st_answer->correct==1) {
                                                                        $anserclass = 'rightans';
                                                                    } else {
                                                                        $anserclass = 'wrongans';
                                                                    }
                                                                    $time_taken = $st_answer->time_taken;
                                                                    $timetaken += $st_answer->time_taken;
                                                                    $selected_choices = $st_answer->selected_choices;
                                                                } else {
                                                                    $selected_choices = '';
                                                                }
                                                        ?>
                                                         <li><a class="questionno getquestionbyid <?php echo $anserclass;?>" id="<?php echo $question->question_id;?>" alt="<?php echo $selected_choices;?>"><?php echo $question->question_number;?></a><span><i
                                                                    class="fa fa-clock-o"></i><?php if($time_taken!='') { echo $time_taken.' sec';} else { echo '0 Sec';}?></span></li>
<!--                                                        <li class="questionno getquestionbyid <?php echo $anserclass;?>" id="<?php echo $question->question_id;?>" alt="<?php echo $selected_choices;?>"><?php echo $y;//$question->question_number;?></li>-->
                                                        <?php 
																$y++;
																} ?>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </ul>
													<div class="table-responsive col-xl-5 col-lg-5 col-md-6 col-sm-12 col-12">
                                                    <table  class="table table-bordered table-sm Taltme">
                                                            <tr>
                                                                <td>Time taken by you to complete this exam</td>
                                                                <td><?php echo $timetaken;?>sec</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Average time taken by you to answer a question</td>
                                                                <td><?php if($qcount>0) { echo number_format($timetaken/$qcount,2);} else { echo '0'; }?>sec</td>
                                                            </tr>
															<?php
															if(!empty($questions)) {
                                                            foreach($questions as $question) {
																$review_answer = $this->common->get_student_answer_review($myexams->exam_id, $question->question_id); 
															?>
															<tr id="question_avg<?php echo $question->question_id;?>" class="hidequestionclass" style="display:none;">
                                                                <td>Avg. time spent on this question by student who got this question right</td>
                                                                <td><?php if(!empty($review_answer)) { echo number_format($review_answer->timetaken,2).'sec'; } ?></td>
                                                            </tr>
															<tr id="question_<?php echo $question->question_id;?>" class="hidequestionclass" style="display:none;">
                                                                <td>% of student who got the question right of those who attempted</td>
                                                                <td><?php if(!empty($review_answer)) { echo number_format($review_answer->atnd_percent,2); }?></td>
                                                            </tr>
															<?php 
																	}
																}
															?>
                                                        </table>
													</div>
                                                </div>

                                            </div>
                                            <?php  $yy++; ?>
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <div id="loadquestion">
                                            Click question no. to view question and answers.
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
