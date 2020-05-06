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
<div class="series-wapper quiz video-wapper">
        <div class="container">
            <div class="row">
            <div class="container breadcrumb-boxs">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('student-dashboard');?>"><i class="fas fa-home"></i> Dashboard</a></li>
                    <?php
                    $previous = "javascript:history.go(-1)";
                    if(isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }
                    ?>
                    <li class="breadcrumb-item" style="display: inline-flex;"><a href="<?php echo $previous; ?>">Course Subjects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Subject Materials</li>
                </ol>
            </div>
                <div class="col-md-12">
                    <div class="series-wapper-header d-flex justify-space-between align-self" style="padding-top: 0px;">
                        <h3 class="cus-title">Course Materials</h3>
                        <!-- <div class="viewIcons">
                            <a href="<?php echo base_url();?>student-dashboard-studyMaterials/<?php echo $course_id;?>"><i class="fas fa-th"></i></a>
                            <a href="#"><i class="fas fa-list"></i></a>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="quiz-body">
                <div class="row">

                    <div class="col-md-4">
                        <div class="card course-lessons vid-list-box">
                            <div class="card-body pzero">
                                <div id="accordion">
                                    <?php
                                    $firstmod = array();
                                    if(!empty($modules)) {
                                        $i = 1;
                                        $x = 1;
                                        foreach($modules as $module) { 
                                            $modules = $this->common->get_module_materials($module->material_id);
                                    ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="<?php if($i > 1) { echo 'collapsed ';}?>card-link" data-toggle="collapse" href="#collapse<?php echo $module->subject_id;?>">
                                                <?php echo $module->subject_name;?>
                                        </a>
                                        </div>
                                        <div id="collapse<?php echo $module->subject_id;?>" class="collapse <?php if($i == 1) { echo 'show';}?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <ul>
                                                    <?php
                                                    if(!empty($modules)) { 
                                                        $d = 1;
                                                        foreach($modules as $module) { 
                                                            if($x==1) {
                                                                $firstmod = $module;
                                                            }
                                                    ?>
                                                    <li class="d-flex justify-space-between acive">
                                                        <a href="#" onclick="study_material_page_view('<?php echo $module->id;?>')"><i 
                                                        <?php
                                                        if($module->video_content!=''){ echo "class='fas fa-video'";} else if($module->youtube_notes!='') {
                                                            echo "class='fas fa-video'";
                                                        } else if($module->audio_content!='') { echo "class='fas fa-file-audio'"; } else {
                                                            echo "class='fa fa-sticky-note-o'"; 
                                                        }
                                                        ?>
                                                        ></i><span><?php echo $d;?></span><?php echo $module->description;?></a>
                                                    </li>
                                                    <?php  $x++; $d++; ?>
                                                    <?php } ?>
                                                        <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8" id="loadtopics">
                        <?php
                        if(!empty($firstmod)) { 
                        ?><div class="title-header">&nbsp;&nbsp;<strong><?php echo $firstmod->description;?> </strong> </div>    
                        <br> 
                        <?php 
                        if($firstmod->youtube_notes!='') {
                            ?>
                        <iframe class="w-100 vid-section" src="<?php echo $firstmod->youtube_notes;?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                        <?php } else if($firstmod->video_content!=''){ ?>
                            <video id="video_player" height="400" width="100%" align="center" controls controlsList="nodownload">
                                <source src="<?php echo base_url($firstmod->video_content);?>" type="video/mp4">
                                Your browser does not support HTML5 video.
                            </video>
                        <?php } else if($firstmod->audio_content){ ?>
                            <audio controls preload="auto" style="width: 100%;">
                                <source  src="<?php echo base_url($firstmod->audio_content);?>"  type="audio/mpeg">
                                Your browser does not support the audio element.
                                <source  src="<?php echo base_url($firstmod->audio_content);?>"  type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                        <?php } else { ?>
                            <div style="width:100%">
                               
                                <div class="passage-view col-sm-12">
                                    <?php echo $firstmod->text_content; ?>
                                </div>
                            </div>  
                      <?php  } ?>
                        <?php } ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div id="view_study_material" class="modal fade form_box modalCustom" role="dialog">
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
    
    
    function study_material_page_view(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('user/Student/study_material_page_view'); ?>",
            type: "post",
            data: {'id':id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#loadtopics').html(obj.html);
                   
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
