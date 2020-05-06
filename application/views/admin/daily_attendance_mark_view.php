<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <div class="white_card">
                                <h6>Attendance Marking</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="AttendanceNav AttendancBatch">
                                            <ul class="nav nav-bar ">
                                                <li> 
                                                    <label>Batch</label>
                                                    <select name="batch" id="batch" class="form-control loadschedulesbatch">
                                                    <?php 
                                                        $selectedbatch = '';
                                                        if(!empty($batches)) {
                                                            $i = 1;
                                                            foreach($batches as $batch){
                                                                if($i==1) {
                                                                    $selectedbatch = $batch->batch_id;
                                                                }
                                                                echo '<option value="'.$batch->batch_id.'">'.$batch->batch_name.'</option>';
                                                                $i++;
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </li>
                                                <li>
                                                    <label>Date</label>
                                                    <input type="text" name="date" id="date" class="form-control calendarclass" autocomplete="off" value="<?php echo date('d-m-Y');?>">
                                                </li>
                                                <div class="clearfix"></div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <span id="schedulesloader">
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
                                                    <span class="bg-warning"></span> Locked
                                                </li>
<!--
                                                <li>
                                                    <span class="bg-danger"></span> Suspended
                                                </li>
-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $shedules = $this->common->get_timetable($selectedbatch, date('Y-m-d'));
                                if(!empty($shedules)) { 
                                ?>
                                <div class="hour">
                                    <div class="row">
                                        <?php 
                                            $statuscolor = 'unmarked';
                                            $locked      = 0;
                                            foreach($shedules as $shedule){ //print_r($shedule);
                                            $module = $this->common->get_module($shedule->module_id); 
                                            $attendance     = $this->common->get_from_tableresult('am_attendance', array('schedule_id'=>$shedule->schedule_id));    //print_r($attendance); 
                                            if(!empty($attendance)) {
                                                $statuscolor = 'bg-success';
                                            }  
                                        ?>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 fingercursor" 
                                             <?php
                                                if($locked!=1) {
                                              ?>
                                             onclick="loadattendancesheet('<?php echo $shedule->schedule_link_id;?>','<?php echo $shedule->schedule_id;?>')" 
                                             <?php } ?>>
                                            <div class="hourBox">
                                                <h4><?php echo $module->subject_name;?></h4>
                                                <p class="<?php echo $statuscolor;?>"><span>Time</span><?php echo date("g:i a", strtotime($shedule->schedule_start_time));?> To <?php echo date("g:i a", strtotime($shedule->schedule_end_time));?></p>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>

                                </div>
                                <?php } else {  echo '<div class="hour"><div class="row"><b>No scheduled class today.</b></div></div>'; } ?>
                                </span>        
                                <span id="loadattendancesheet">
<!--
                                <div class="AttendanceStatus">
                                    <ul class="nav nav-bar">
                                        <li><h6>Present <i class="fa fa-check" style="color:#28a745;"></i></h6></li>
                                        <li><h6>Absent <i class="fa fa-times" aria-hidden="true" style="color:red;"></i></h6></li>
                                    </ul>



                                </div>
                                <div class="AttendanTabl">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th>Roll No</th>
                                                            <th>Name</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>

                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th>Roll No</th>
                                                            <th>Name</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>

                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
-->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view("admin/scripts/attendance_script");?>