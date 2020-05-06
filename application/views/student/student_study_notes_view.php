<style>
    .select2-container--open{
        z-index:99999999!important;
    }
    </style>
<?php //echo $userdata->student_image;
            if(isset($userdata) && $userdata->student_image!='') {
               $profile_img =  base_url().$userdata->student_image; 
            } else {
               $profile_img =  base_url().'assets/images/profile_img.png';
            }
            ?>
<section class="nav_profile ">
    <div class="container">
        <ul class="nav nav-pills ">
            <li class="active"><a href="<?php echo base_url('student-dashboard');?>" class="active">Dashboard </a></li>
            <!-- <li><a href="<?php echo base_url('student-dashboard?page=profile');?>">Profile</a></!--> 
            <!-- <li><a data-toggle="pill" href="#feedetails" id="feedetailstab">Fee details</a></li>
            <li><a data-toggle="pill" href="#myschedule">My schedule</a></li>
            <li><a data-toggle="pill" href="#studAttendance" id="studentattendance">Attendance</a></li> -->
             <!-- <li><a data-toggle="pill" href="#studProgress" id="studentprogress">Result</a></!-->  
            <!--<li><a data-toggle="pill" href="#studMaterials" id="studymaterials">Learning Module</a></li>
            <li><a  href="<?php echo base_url();?>student-dashboard-quiz" >My Quiz</a></li>-->
           
            <!-- <li><a  data-toggle="pill"  href="#stud_Materials" id="study_materials">Study Materials</a></li> -->
            <!-- <li><a data-toggle="pill" href="<?php echo base_url('backoffice/messenger');?>"><?php echo $this->lang->line('messenger');?> </a></li> -->
            <!-- <li style="position:relative;"><a data-toggle="pill" href="#stdMessenger"><?php echo $this->lang->line('messenger');?> </a>
            <?php if($notifyCount != 0){
                        echo '<span class="messanger-noty">'.$notifyCount.'</span>';
                    }?>
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
<div class="series-wapper" id="showbody">
        <div class="container">
            <div class="series-wapper-header  study-materialHeader">
            <div class="container breadcrumb-boxs">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('student-dashboard');?>"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Study Material</li>
                </ol>
            </div>
            <div class="d-flex justify-space-between align-self header-Material">
                <h3 class="cus-title" >Study Material</h3>
                <div class="d-flex align-items-center mb-30">
                <div class="viewIcons">
                            <a title="Grid View"><i class="fas fa-th" style="color:#aac2ed;"></i></a>
                            <a title="List View" href="<?php echo base_url();?>course-subject-list/<?php echo $course;?>"><i class="fas fa-list"></i></a>
                        </div>
                    <!-- <span class="mr-2 bold text-muted">Sort:</span> 
                    <select class="form-control form-inline" id="cou_id">
                        <?php  //if(!empty($course_Id)) { 
                           
                            foreach($course_Id as $course){ 
                                if($this->uri->segment('2')==$course->course_id){
                                    $selected='selected';
                                }else{
                                 $selected='';
                                }
                                ?>
                        <option 
                        <?php echo $selected;?> value="<?php echo  $course->course_id;?>">
                        <?php   echo $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $course->course_id));?>                            </option>
                            <?php } //}?>
                    </select> -->
                </div>
            </div>
            </div>
           
            <div class="series-body" id="showstudy">
                <div class="row">
               <?php  if(!empty($materials)) { 
                            foreach($materials as $material){ ?>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                             <?php
                                        if($material->text_content!='') {
                                            // echo '<a target="_blank" href="'.base_url().'user/Student/view_study_material/'.$material->id.'" class="learningmoduleDwld matimg btn btn-info btn_save">
                                            // <i class="fa fa-eye text-right"></i>
                                            // </a>';
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg" onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa-eye text-right"></i>
                                            </a>';
                                        } else if($material->video_content!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg" onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa-play-circle-o text-right"></i>
                                            </a>';
                                        } else if($material->audio_content!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg"  onclick="view_study_material('.$material->id.')">
                                            <i class="fa  fa-file-sound-o text-right"></i>
                                            </a>';
                                        } else if($material->youtube_notes!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg"  onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa fa-youtube text-right"></i>
                                            </a>';
                                        }
                                        ?>
                                <!-- <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image"> -->
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5><?php echo $material->material_name;?></h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><?php echo $material->subject_name?> </p>
                                    <p><?php 
                                    if($material->text_content!='') {
                                        echo 'Text';
                                    } else if($material->video_content!='') {
                                        echo 'Video';
                                    } else if($material->audio_content!='') {
                                        echo 'Audio';
                                    } else if($material->youtube_notes!='') {
                                        echo 'Youtube';
                                    }?>
                                        </p>
                                </div>
                                <!-- <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div> -->
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php }else{?>
                        No Data Found!!
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    
    <div id="view_study_material" class="modal fade form_box modalCustom" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title"></h4>
                <button type="button" id="hidedata" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="studProfile" class="tab-pane fade">
           
           <div class="profile">
               <div class="container">
                   <div class="row">
                       <div class="col-md-3">
                           <div class=" profile-box profile-pic">
                               <img src="<?php echo $profile_img ?>" class="img-fluid" alt="">
                               <h5><?php echo $userdata->name;?></h5>
                               <span><?php echo $userdata->email;?> </span>
                           </div>
                       </div>
                       <div class="col-md-9">
                           <div class="row">
                               <div class="col-md-4">
                                   <div class="profile-box d-flex">
                                       <i class="fa fa-graduation-cap"></i>
                                       <h4>Courses Taken<span><?php echo $course_count;?> </span></h4>
                                   </div>
                               </div>
                               <!-- <div class="col-md-4">
                                   <div class="profile-box d-flex">
                                       <i class="fa fa-book"></i>
                                       <h4>Overall Score<span>592</span></h4>
                                   </div>
                               </div> -->
                               <!-- <div class="col-md-4">
                                   <div class="profile-box d-flex">
                                       <i class="fa fa-question"></i>
                                       <h4>Quizzes Taken<span>12</span></h4>
                                   </div>
                               </div> -->
                           </div>
                       </div>
                   </div>
               </div>
           </div>
                   </div>
<script>
    $('#hidedata').click(function(){
        $('audio').attr('src', '');
        $('iframe').attr('src','');
        $('video').attr('src','');
        })
    $('#cou_id').change(function(){
     var id= $('#cou_id').val();
     //alert(id);
        $.ajax({
            url: "<?php echo base_url('user/Student/study_materials_view'); ?>",
            type: "post",
            data:{id:id},
            success: function(data){
                $('#showstudy').html(data);
            }
        });
    });
function view_study_material(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('user/Student/show_study_material'); ?>",
            type: "post",
            data: {'id':id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#body').html(obj.html);
                    $('#title').html(obj.title);
                    $('#view_study_material').modal('toggle');
                   
                }else{
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
            }
        });
    }  
    
</script>
<?php $this->load->view("user/scripts/user_script"); ?>
