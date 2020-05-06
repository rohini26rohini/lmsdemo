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
                    <li class="breadcrumb-item active" aria-current="page">Course subjects</li>
                </ol>
            </div>
            <div class="container">
                <div class="series-wapper-header d-flex justify-space-between align-self gridviws" style="padding-top: 0px;">
                        <h3 class="cus-title">Course subjects</h3>
                        <div class="viewIcons">
                            <a href="<?php echo base_url();?>student-dashboard-studyMaterials/<?php echo $course;?>" title="Grid View"><i class="fas fa-th" ></i></a>
                            <a title="List View"><i class="fas fa-list" style="color:#aac2ed;"></i></a>
                        </div>
                    </div>
              <div class="row">
                <?php
                if(!empty($subjects)) {
                    foreach($subjects as $subject) { 
                ?>
                <div class="col-md-4" style="padding: 15px;"><a href="<?php echo base_url();?>course-materials/<?php echo $subject->subject_id;?>">
                    <div class="profile-box d-flex">
                                <i class="fa fa-graduation-cap"></i>
                                <h4><?php echo $subject->subject_name;?></h4>
                            </div></a>
                </div>

                    <?php } ?>
                <?php } ?>
                    </div>
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
    
</script>
<?php $this->load->view("user/scripts/user_script"); ?>
