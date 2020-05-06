
    <!-- <div class="abtbanner BgGrdOrange ">
         <div class="container maincontainer">
            <h3>Take a Test</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Take a Test</li>
            </ol>
        </div> 
    </div> -->
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
    <div class="series-wapper">
        <div class="container">
            <div class="series-wapper-header d-flex justify-space-between align-self">
                <h3>Course List</h3>
                <div class="d-flex align-items-center mb-30">
                    <span class="mr-2 bold text-muted">Sort:</span> <select class="form-control form-inline">
                        <option value="1">Course Name</option>
                        <option value="2">Price</option>
                        <option value="3">Author</option>
                    </select>
                </div>
            </div>
            <div class="series-body">
                <div class="row">
                <?php 
           foreach($course_Id as $row){?>
                    <div class="col-md-3">
                    <div class="dash-box-shadow course-box">
                        <dv class="d-flex justify-space-between align-self">
                            <h3><?php    echo $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $row->course_id));?></h3>
                            <?php $progress = $this->common->get_course_progress($this->session->userdata('user_id'), $row->course_id); ?>
                            <a href="<?php echo base_url();?>student-dashboard-studyMaterials/<?php echo $row->course_id ?>">Details</a>
                        </dv>
                        <div class="circlechart" data-percentage="<?php echo $progress;?>">Script</div>
                    </div>
                    </div>
                   
         <?php }?>

                </div>
            </div>
        </div>
    </div>
  
    <script>
        $('.circlechart').circlechart();
     </script>