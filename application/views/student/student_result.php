<section class="nav_profile ">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a data-toggle="pill" href="#studDashboard" class="active">Dashboard </a></li>
            <li><a data-toggle="pill" href="#studProfile">Profile</a></li>
            <!-- <li><a data-toggle="pill" href="#feedetails" id="feedetailstab">Fee details</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li> 
             <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Progress Report</a></li>
            <li><a data-toggle="pill" href="#studMaterials" id="studymaterials">Learning Module</a></li>-->
            <li><a  href="<?php echo base_url();?>student-dashboard-quiz" >My Quiz</a></li>
           
            <!-- <li><a  data-toggle="pill"  href="#stud_Materials" id="study_materials">Study Materials</a></li> -->
            <!-- <li><a data-toggle="pill" href="<?php echo base_url('backoffice/messenger');?>"><?php echo $this->lang->line('messenger');?> </a></li> -->
            <!-- <li style="position:relative;"><a data-toggle="pill" href="#stdMessenger"><?php echo $this->lang->line('messenger');?> </a>
            <?php //if($notifyCount != 0){
                      //  echo '<span class="messanger-noty">'.$notifyCount.'</span>';
                    //}?>
            </li> -->
            <!-- <li><a data-toggle="pill" href="#homeworks" id="homework_list">Homeworks</a></li> -->
            <?php
            if(!empty($students)) {
            ?>
            <li>
                <div class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo 'Select Child'; ?>
                    </a>
                    <div class="dropdown-menu">
                        <?php
                            foreach($students as $student) {
                                echo '<a class="dropdown-item " href="'.base_url('change/'.$student->student_id).'">'.$student->name.'</a>';
                            }
                        ?>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>
<div class="clearfix"></div>
    <div class="series-wapper quiz">
        <div class="container">
          <div class="series-wapper-header d-flex justify-space-between align-self">
                <h3>Quiz <span>Getting Started with InVision</span></h3>
                <div class="d-flex align-items-center mb-30">
                    <a  href="<?php echo base_url();?>student-dashboard" class="btn">Back to Course </a>
                </div>
            </div>
       
          
             <div class="quiz-body qz_item">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <h5>  Course Name  :  <?php echo  $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $course_id));?></h5>
                                <h5>  Total Attempt  :  <?php  if(!empty($attempt->attempt)){ echo $attempt->attempt;}?></h5>

                                <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Total Questions</th>
                                        <th>Correct Answers</th>
                                        <th>Grade</th>
                                        <th>Attempt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; if(!empty($results)){
                                      foreach($results as $row){?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <th><?php echo $questioncount->count; ?></th>
                                        <td><?php echo  $this->common->get_name_by_id('orido_exam_answers','correct',array('emp_id' => $this->session->userdata('user_id'),
                                    'attempt'=>$row->attemptcount,'assessment_id'=>$row->assessment_id));?></td>
                                        <td><?php echo $row->grade;?></td>
                                        <td><?php echo $row->attemptcount;?></td>
                                    
                                    </tr>
                                       <?php $i++; } }else{?>
                                         <tr>
                                         <td colspan="5">No result...!</td>
                                       
                                     
                                     </tr>   
                                     <?php   }?>
                                   
                                </tbody>
                            </table>
                        </div> 


                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-space-between">
                                    <!-- <a class="btn btn-light pre_btn">Previous</a> -->
                                    <!-- <button type="submit" class="btn btn-success next_btn">Finish</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                        </form>
        </div>
    </div>
    <script>
        
        $('.circlechart').circlechart();
        $(document).ready(function () {

            var qzbox = document.getElementsByClassName("qz_item");
                for (var i = 0; i < qzbox.length; i++) 
                {
                     if(i===0)
                     {
                        qzbox[i].style.display="block"; 
                     }
                     else
                     {
                        qzbox[i].style.display="none";
                     }
                }

            $(".next_btn").on('click', function (event) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                var index = $(".next_btn").index(this);
                index+=1;
                var qzbox = document.getElementsByClassName("qz_item");
                for (var i = 0; i < qzbox.length; i++) 
                {
                     if(index===i)
                     {
                        qzbox[i].style.display="block"; 
                     }
                     else
                     {
                        qzbox[i].style.display="none";
                     }
                }

            });

            $(".pre_btn").on('click', function (event) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                var index = $(".pre_btn").index(this);
                if(index===0)
                {
                    index=0;
                }
                else
                {
                    index-=1;
                }
                
                var qzbox = document.getElementsByClassName("qz_item");
                for (var i = 0; i < qzbox.length; i++) 
                {
                     if(index===i)
                     {
                        qzbox[i].style.display="block"; 
                     }
                     else
                     {
                        qzbox[i].style.display="none";
                     }
                }

            });
        });

       
    </script>
