<div class="row">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                <h3>Class Attendance</h3>
                            <hr class="hrCustom">
        <div class="table-responsive dirst_dash">
                            <table class="table table-bordered table-sm table_exam_details">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
<!--                                        <th>Module</th>-->
                                        <th class="align-center">Sessions</th>
                                    </tr>
                                    <?php
                                    if(!empty($attendance)) { 
                                        foreach($attendance as $mark) { //echo '<pre>';print_r($mark);
                                            $dayschedule = $this->common->get_student_attendance($batch->batch_id, $mark->schedule_date);
                                    ?>
                                    <tr>
                                        <td class="cla-time"><?php echo  date('d-M-Y', strtotime($mark->schedule_date));?></td>
<!--
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry. </td>
-->
                                        <td  colspan="10" class="align-center">
                                            <ul class="dir_attendance-session">
                                                    <?php 
                                                        if(!empty($dayschedule)) {
                                                            foreach($dayschedule as $schedule){
                                                                $studentattendance = $this->common->getstudent_attendance($schedule->schedule_id, $this->session->userdata('user_id'),'class');
                                                                //print_r($studentattendance);
                                                    ?>
                                                    <li class="text-center dir_attendance-session-list" style="border:none;">
                                                        <div class="attendance-session">
                                                            <div class="attendance-time">
                                                                <strong><?php echo date('g:i a', strtotime($schedule->schedule_start_time)); ?> - <br>
                                                                <?php echo date('g:i a', strtotime($schedule->schedule_end_time)); ?></strong>
                                                            </div>
                                                            <div class="attendance-description">
                                                                <?php echo $schedule->subject_name;?>
                                                            </div>
                                                        </div>
                                                        <?php if(!empty($studentattendance)) {
                                                                    if($studentattendance->attendance==1) {
                                                                        echo '<i class="fa fa-check"></i>';
                                                                    } else if($studentattendance->attendance==0) {
                                                                        echo '<i class="fa fa-close"></i>';
                                                                    }
                                                                }
                                                        ?>
                                                    </li>
                                                    <?php 
                                                        }
                                                     } 
                                                    ?>
<!--
                                                    <td class="text-center" width="20px" style="border:none;"><i class="fa fa-check"></i></td>
                                                    <td class="text-center" width="20px" style="border:none;"><i class="fa fa-close"></i></td>
                                                    <td class="text-center" width="20px" style="border:none;"><i class="fa fa-check"></i></td>
-->
                                            </ul>
                                        </td>
                                        
                                    </tr>
                                    <?php 
                                    }
                                    } else {
                                        echo '<tr><th colspan="11" >Attendance marking is not started</th></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
    </div>
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h3>Exam Attendance</h3>
                            <hr class="hrCustom">
<div class="table-responsive">
                            <table class="table table-bordered table-sm table_exam_details">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
<!--                                        <th>Module</th>-->
                                        <th class="align-center">Sessions</th>
                                    </tr>
                                    <?php
                                        $examschedule = $this->common->get_examtimetable($batch->batch_id);
										if(!empty($examschedule)) {
                                        foreach($examschedule as $mark){ 
                                            $dayschedule = $this->common->get_examtimetablelike($batch->batch_id, date('Y-m-d', strtotime($mark->start_date_time))); 
                                    ?>
                                    <tr>
                                        <td class="text-center cla-time"><?php echo  date('d-M-Y', strtotime($mark->start_date_time));?></td>
<!--
                                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry. </td>
-->
                                        <td  colspan="10" class="align-center" style="padding:0">
                                        <ul class="dir_attendance-session">
                                                <?php 
                                                        if(!empty($dayschedule)) {
                                                            foreach($dayschedule as $schedule){ 
                                                                $studentattendance = $this->common->getstudent_attendance($schedule->id, $this->session->userdata('user_id'),'exam');
                                                                //print_r($studentattendance);
                                                    ?>
                                                    
                                                    <li class="text-center dir_attendance-session-list">
                                                        <div class="attendance-session">
                                                            <div class="attendance-time">
                                                                <strong><?php echo date('g:i a', strtotime($schedule->start_date_time)); ?> - <br>
                                                                <?php echo date('g:i a', strtotime($schedule->end_date_time)); ?></strong> 
                                                            </div>
                                                            <div class="attendance-description">
                                                                <?php echo $schedule->name;?>
                                                            </div>
                                                            <?php if(!empty($studentattendance)) {
                                                                    if($studentattendance->attendance==1) {
                                                                        echo '<i class="fa fa-check"></i>';
                                                                    } else if($studentattendance->attendance==0) {
                                                                        echo '<i class="fa fa-close"></i>';
                                                                    }
                                                                }
                                                        ?>
                                                        </div>
                                                    </li>
                                                    
<!--
                                                    <td class="text-center" width="20px" style="border:none;"><i class="fa fa-check"></i></td>
                                                    <td class="text-center" width="20px" style="border:none;"><i class="fa fa-close"></i></td>
                                                    <td class="text-center" width="20px" style="border:none;"><i class="fa fa-check"></i></td>
-->
                                                <?php 
                                                        }
                                                     } 
                                                
                                                    ?>
                                            </ul>
                                        </td>
                                        
                                    </tr>
                                    <?php 
                                    }
										} else {
											echo '<tr><td colspan="3" class="text-center">No exam scheduled</td></tr>';
										}
                                    ?>
                                </tbody>
                            </table>
                        </div>
    </div>
    </div>