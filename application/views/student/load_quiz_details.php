<section class="nav_profile ">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a href="<?php echo base_url('student-dashboard');?>" class="active">Dashboard </a></li>
            <!-- <li><a data-toggle="pill" href="#studProfile">Profile</a></!--> -->
            <!-- <li><a data-toggle="pill" href="#feedetails" id="feedetailstab">Fee details</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li> 
             <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Progress Report</a></li>
            <li><a data-toggle="pill" href="#studMaterials" id="studymaterials">Learning Module</a></li>-->
            <!-- <li><a  href="<?php echo base_url();?>student-dashboard-quiz" >My Quiz</a></li> -->
           
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
    <div id="showstudy" class="series-wapper quiz">
        <div class="container">
        <div class="container breadcrumb-boxs">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('student-dashboard');?>"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Exam</li>
                </ol>
            </div>
          <div class="series-wapper-header d-flex justify-space-between align-self mb-30">
                <h3 class="cus-title">Exam <span></span></h3>
                <div class="d-flex align-items-center ">
                <a  href="<?php echo base_url();?>student-dashboard" class="btn"> <i class="fa fa-long-arrow-left"></i>Back to Course </a>
                </div>
            </div>
         
            <?php  $j=1; if(!empty($this->session->userdata('session_data'))) { foreach($this->session->userdata('session_data') as $row) { $i= 1; ;?>
              <form  method="POST" id="questionform" >   

            <div class="quiz-body qz_item">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <input type="hidden" class="custom-control-input" value="<?php echo  $row->question_id;?>" name="question_id[]">
                                <input type="hidden" class="custom-control-input" value="<?php echo  $course_id;?>" name="course_id">

                                <h5><?php echo $j." . ".$row->question_content;?></h5>
                                <div class="card-text lessons">
                                <?php $options=$this->common->get_optionBy_ques_id($row->question_id);
                              //  echo $this->db->last_query();
                           
                               if(!empty($options)) {
                                foreach($options as $option) {
                                    ?>
                                     
                                     <div class="d-flex">
                                      <label class="optn"><?php echo $option->option_number;?> </label>
 
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio<?php echo $row->question_id.$i;?>" name="customRadio[<?php echo $row->question_id;?>]"
                                            value="<?php echo  $option->option_number;?>">
                                        <label class="custom-control-label" for="customRadio<?php echo $row->question_id.$i;?>"><?php //echo  $option->option_number;?> <?php echo  $option->option_content;?></label>
                                    </div>
                                    </div>
                                <?php $i++; } } ?>
                                </div>

                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-space-between">
                                    <a class="btn btn-light pre_btn">Previous</a>
                                    <a class="btn btn-success next_btn">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                             <?php $j++; }   ?>

                          
          
                             <div class="quiz-body qz_item">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Do you want to finish?</h5>
                               

                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-space-between">
                                    <a class="btn btn-light pre_btn">Previous</a>
                                    <button type="submit" class="btn btn-success next_btn">Finish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                <?php } else { ?>
                                    <div class="row">
                    <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <p class="card-text" style="text-align: center; padding:15px;">Questions not available for this exam, Please contact co-ordinator.</p>
                               

                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                            
                        </div>
                    </div>
                </div>
                           <?php     } ?>
                        </form>
                        
        </div>
    </div>
    <script>
         $("#questionform").validate({
        
        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>user/Student/add_question_details',
                type: 'POST',
                data: $("#questionform").serialize(),
                 success: function(response) {
                    $('#showstudy').html(response);
                    $(".loader").hide();
                 }
            });
        }
    });
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
