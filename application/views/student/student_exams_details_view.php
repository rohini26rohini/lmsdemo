<?php //echo '<pre>';  print_r($myexams); ?>
<div class="ExmResults">
                        <h6 class="ExamCaption"><?php echo (!empty($myexams)?$myexams->name:'');?></h6>
                        <!--<ul class="nav nav-bar  justify-content-between">
                            <li class="TotalMark">Total Score <span>100</span></li>
                            <li class="TotalMark">Top Score <span>100</span></li>
                        </ul>-->
    <?php //echo '<pre>'; print_r($questions);?>
                        <?php //echo '<pre>';
                        $sectionArr = array(); //print_r($questions);
                        if(!empty($questions)) {
                           foreach($questions as $question) {
                               //$sectionDetid = $this->common->get_from_tablerow('gm_exam_section_config_details', array('details_id'=>$question->exam_section_details_id));
                               //echo $question->exam_section_details_id.'===<br>';
                               array_push($sectionArr, $question->subject_id);
                           }
                           $sectionArr = array_unique($sectionArr);
                        } 
                        ?>
						<?php		
									$secArr 		= array();
									$secrwArr		= array();
									$accuracy 		= array();
									$netscore 		= array();
									$highscore 		= array();
									$highScore		= 0;
									$totalqrcount =0;
									$totalqwcount =0;
									$totalqrcountArr = '';
									$examHighscore 	= $this->common->get_from_tablerow('gm_exam_summary', array('exam_id'=>$myexams->exam_id)); 
									if(!empty($examHighscore)) {
										$highScore = $examHighscore['heigh_mark'];
									}
                                    if(!empty($sectionArr)) {
                                    foreach($sectionArr as $key=>$section) {
                                        $sectionDet 	= $this->common->gm_exam_section_config_subject_id($section); 
										$sectionhighest = $this->common->gm_exam_section_highest($section, $myexams->exam_id);
										$secArr[$key] = $sectionDet['section_name'];
                                        $mark 		= 0;
                                        $nmark		= 0;
										$qrcount 	= 0;
										$qwcount 	= 0;
										$qattend 	= 0;
										$accurcycalc= '';
                                        foreach($questions as $question) {
                                                if($question->subject_id==$section){
                                                $anserclass = '';
                                                $st_answer = $this->common->get_student_answer($myexams->attempt, $myexams->exam_id, $this->session->userdata('user_id'), $question->question_id);
                                                // show($st_answer);
                                                // echo $this->db->last_query(); exit;
                                                // echo $myexams->attempt.', '.$myexams->exam_id.', '.$this->session->userdata('user_id').', '.$question->question_id;
                                                if(!empty($st_answer)) {
                                                    if($st_answer->correct==1) {
                                                         $mark += $st_answer->mark;
														 $qrcount++;
                                                    } else {
                                                        $nmark += $st_answer->negative_mark;
														$qwcount++;
                                                    }
													$qattend++;
                                                }
                                        }
                                        }
										$totalqrcount += $qrcount;
										$totalqwcount += $qwcount;
										if($qrcount>0) {
										$accurcycalc 	= $qrcount/$qattend;
										$accuracy[$key]	= $accurcycalc*100;
										} else {
										$accuracy[$key]	= 0;	
										}
										$secrwArr[$key] = $qrcount.' & '.$qwcount;
										$netscore[$key] = $mark-$nmark;
										$highscore[$key] = $sectionhighest['heigh_mark'];
                                    ?>
                                   <?php //echo $mark-$nmark; print_r($secArr); print_r($secrwArr); print_r($accuracy);?>
                                    
                                    <?php } ?>
									<?php
										$totalqrcountArr = $totalqrcount.' & '.$totalqwcount;
									?>
                                    <?php } ?>
                        <div class="table-responsive">
                            <table class="table ExaminationList">
								<tr>
									<th></th>
									<?php 
									if(!empty($secArr)) {
										foreach($secArr as $row) {
											echo '<th>'.$row.'</th>';
										}
									}
									?>
									<th>Total</th>
								</tr>
								<tr>
									<td>Right & Wrong</td>
									<?php 
									if(!empty($secrwArr)) {
										foreach($secrwArr as $row) {
											echo '<td>'.$row.'</td>';
										}
									}
									?>
									<td><?php echo $totalqrcountArr;?></td>
								</tr>
								<tr>
									<td>Accuracy %</td>
									<?php 
									$totalAccuracy = 0;
									if(!empty($accuracy)) {
										foreach($accuracy as $row) { 
											echo '<td>'.number_format($row, 2).'</td>';
											$totalAccuracy += $row;
										}
									} 
									?>
									<td><?php  echo number_format($totalAccuracy/count($accuracy), 2); ?></td>
								</tr>
								<tr>
									<td>Net Score</td>
									<?php 
									$nettotal = 0;
									if(!empty($netscore)) {
										foreach($netscore as $row) {
											echo '<td>'.$row.'</td>';
											$nettotal += $row;
										}
									}
									?>
									<td><?php echo $nettotal;?></td>
								</tr>
								<tr>
									<td>Highest score of this exam</td>
									<?php 
									if(!empty($highscore)) {
										foreach($highscore as $row) {
											echo '<td>'.$row.'</td>';
										}
									}
									?>
									<td><?php echo $highScore;?></td>
								</tr>
                                <!--<tr>
									<th>Answered</th>
									<th>Mark Obtained</th>
									<th>Nagative mark</th>
									<th>Total Mark</th>
                                    <?php
                                    if(count($sectionArr)>1) {
                                    foreach($sectionArr as $section) {
                                        $sectionDet = $this->common->gm_exam_section_config_subject_id($section);  //print_r($sectionDet);
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
                                    </td>
                                    <?php } ?>
                                    <?php } ?>
                                </tr>-->
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
                                                <a class="nav-link <?php if($c==1) { echo 'active'; } ?> " data-toggle="pill" href="#menu<?php echo $sectionDet['id'];?>"><?php echo $sectionDet['section_name'];?></a>
                                            </li>
                                            <?php $c++; ?>
                                            <?php } ?>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content">
                                       <?php  if(count($sectionArr)==1) { ?>
                                            <div class="tab-pane  active" id="home">
                                                <div class="QuestionNolist questionsummry">
                                                    <ul>
                                                        <?php
                                                        $question_type = '';
                                                        if(!empty($questions)) {
															$x=1;
                                                            foreach($questions as $question) {
                                                                $anserclass = '';
                                                                $st_answer = $this->common->get_student_answer($myexams->attempt, $myexams->exam_id, $this->session->userdata('user_id'), $question->question_id); 
                                                                if(!empty($st_answer)) {
                                                                    if($st_answer->correct==1) {
                                                                        $anserclass = 'rightans';
                                                                    } else {
                                                                        $anserclass = 'wrongans';
                                                                    }
                                                                    $selected_choices = $st_answer->selected_choices;
                                                                    $question_type = $st_answer->question_type;
                                                                } else {
                                                                    $selected_choices = '';
                                                                    $question_type = '';
                                                                }
                                                        ?>
                                                        <li class="questionno getquestionbyid <?php echo $anserclass;?>" id="<?php echo $question->question_id;?>" alt="<?php echo $selected_choices;?>" status="<?php echo $question_type;?>"><?php echo $question->question_number;//$x;?></li>
                                                        <?php 
															$x++;
															} ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if(count($sectionArr)>1) {
											$y=1; $yy =1 ;
                                            foreach($sectionArr as $section) {
                                                $sectionDet = $this->common->gm_exam_section_config_subject_id($section); 
                                            ?>
                                            <div class="tab-pane  <?php if($y==1) { echo 'active'; } else { echo 'fade'; }?>" id="menu<?php echo $sectionDet['id'];?>">
                                                <div class="QuestionNolist questionsummry">
                                                    <ul>
                                                        <?php 
                                                        $question_type = '';
                                                        if(!empty($questions)) {
                                                            foreach($questions as $question) {
                                                                if($question->subject_id==$section){
                                                                $anserclass = '';
                                                                $st_answer = $this->common->get_student_answer($myexams->attempt, $myexams->exam_id, $this->session->userdata('user_id'), $question->question_id);
                                                                if(!empty($st_answer)) {
                                                                    if($st_answer->correct==1) {
                                                                        $anserclass = 'rightans';
                                                                    } else {
                                                                        $anserclass = 'wrongans';
                                                                    }
                                                                    $selected_choices = $st_answer->selected_choices;
                                                                    $question_type = $st_answer->question_type;
                                                                } else {
                                                                    $selected_choices = '';
                                                                    $question_type = '';
                                                                }
                                                        ?>
                                                        <li class="questionno getquestionbyid <?php echo $anserclass;?>" id="<?php echo $question->question_id;?>" alt="<?php echo $selected_choices;?>" status="<?php echo $question_type;?>"><?php echo $question->question_number;?></li>
                                                        <?php 
																$y++;
																} ?>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>

                                            </div>
                                            <?php $yy++; ?>
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
