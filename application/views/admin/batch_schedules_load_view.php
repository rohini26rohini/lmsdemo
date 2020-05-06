<div class="row">
                                    <div class="col-12">
                                        <div class="AttendanceNav">
                                            <ul class="nav nav-bar ">
                                                <li>
                                                    <span class="bg-success"></span>Marked
                                                </li>
                                                <li>
                                                    <span class="bg-primary"></span>Unmarked
                                                </li>
                                                <li>
                                                    <span class="bg-warning"></span>Locked
                                                </li>
<!--
                                                <li>
                                                    <span class="bg-danger"></span>Suspended
                                                </li>
-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $noschedule = 0;
                                $shedules = $this->common->get_timetable($batch_id, $date);
                                if(!empty($shedules)) { 
                                $noschedule = 1;    
                                ?>
                                <div class="hour">
                                    <div class="row">
                                        <?php 
                                            $statuscolor = '';
                                            $locked      = 0;
                                            foreach($shedules as $shedule){ 
                                            $locked = 0;    
                                            $module         = $this->common->get_module($shedule->module_id);
                                            $attendance     = $this->common->get_from_tableresult('am_attendance', array('schedule_id'=>$shedule->schedule_id));    //print_r($attendance);  
                                            if(!empty($attendance)) {
                                                $statuscolor = 'bg-success';
                                            } else {
                                                $statuscolor = 'unmarked';
                                            }    
                                            if(strtotime($date) > strtotime(date('Y-m-d'))) {
                                                $statuscolor    = 'locked';
                                                $locked         = 1;
                                            }
                                            if($shedule->schedule_status==0) {
                                                $statuscolor    = 'suspended';
                                                $locked         = 1;
                                            }
                                        ?>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 fingercursor" 
                                             <?php
                                                if($locked!=1) {
                                              ?>
                                             onclick="loadattendancesheet('<?php echo $shedule->schedule_link_id;?>','<?php echo $shedule->schedule_id;?>','class')" 
                                             <?php } ?>>
                                            <div class="hourBox">
                                                <h4><?php echo $module->subject_name;?></h4>
                                                <p class="<?php echo $statuscolor;?>"><span>Time</span><?php echo date("g:i a", strtotime($shedule->schedule_start_time));?> To <?php echo date("g:i a", strtotime($shedule->schedule_end_time));?></p>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>

                                </div>
                                <?php }  ?>

                                <?php
                                $examshedules = $this->common->get_examtimetable($batch_id, $date); //print_r($shedules);
                                if(!empty($examshedules)) { 
                                $noschedule = 1;        
                                ?>
                                <div class="hour">
                                    <div class="row">
                                        <?php 
                                            $statuscolor = '';
                                            $locked      = 0;
                                            foreach($examshedules as $shedule){ 
                                            $locked = 0;    
                                            //$module         = $this->common->get_module($shedule->module_id);
                                            $attendance     = $this->common->get_from_tableresult('am_attendance', array('schedule_id'=>$shedule->id));    //print_r($attendance);  
                                            if(!empty($attendance)) {
                                                $statuscolor = 'bg-success';
                                            } else {
                                                $statuscolor = 'unmarked';
                                            }    
                                            if(strtotime($date) > strtotime(date('Y-m-d'))) {
                                                $statuscolor    = 'locked';
                                                $locked         = 1;
                                            }
//                                            if($shedule->schedule_status==0) {
//                                                $statuscolor    = 'suspended';
//                                                $locked         = 1;
//                                            }
                                        ?>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 fingercursor" 
                                             <?php
                                                if($locked!=1) {
                                              ?>
                                             onclick="loadattendancesheet('<?php echo $batch_id;?>', '<?php echo $shedule->id;?>','exam')" 
                                             <?php } ?>>
                                            <div class="hourBox hourBoxexam">
                                                <h4><?php echo $shedule->name;?></h4>
                                                <p class="<?php echo $statuscolor;?>"><span>Time</span><?php echo date("g:i a", strtotime($shedule->start_date_time));?> To <?php echo date("g:i a", strtotime($shedule->end_date_time));?></p>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>

                                </div>
                                <?php } if($noschedule!=1) {  echo '<div class="hour"><div class="row"><b>No scheduled class/exam today.</b></div></div>'; } ?>