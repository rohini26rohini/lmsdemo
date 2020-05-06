
<div class="abtbanner BgGrdOrange ">
    <div class="container maincontainer">
        <h3>Upcoming Exams & Notifications</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('direction-ias-study-circle'); ?>">Direction IAS Study circle</a></li>
            <li class="breadcrumb-item active" aria-current="page">Upcoming Exams & Notifications</li>
        </ol>
        
    </div>
</div>
<section class="inner_page_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="grow_wrap">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table_exam_details">
                            <tr>
                                <th>Sl.No</th>
                                <th>Name</th>
                            </tr>
                            <tr>
                            <?php
                            $i =1;
                            if(!empty($notificationArr)){ 
                            foreach ($notificationArr as $notification){
                            ?>
                                <td><?php echo $i;?></td>
                                <td>
                                <a href="<?php echo base_url('detailed-notification-ias/'.$notification['notification_id']);?>">
                                <?php echo $notification['name']?></a></td>
                            </tr>
                            <?php $i++;  }} else{?>
                                <td colspan="2"><center>No data found</center></td>
                          <?php  } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <!DOCTYPE html>
<html lang="en">
<body>
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Notifications</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper notifications">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class=" noti" id="accordion">
                        <div class="card">
                            <div class="card-header">
                                <a class="card-link collapsed" data-toggle="collapse" href="#collapseOne"
                                    aria-expanded="false">
                                    Direction IAS Study circle
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <ul class=" list-unstyled ">
                                        <li><a href="#">Civil Services Exam For aspirants</a></li>
                                        <li><a href="#">Upsc Civil Services Examinations</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                    Direction School for NET/JRF Examinations
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                                    Direction School for PSC Examinations
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapsefore">
                                    Direction School for SSC Examinations
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapsefive">
                                    Direction School of Banking
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapsesix">Direction
                                    School for entrance examinations
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseseven">
                                    Direction Junior
                                </a>
                            </div>
                            <div id="collapseseven" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class=" list-unstyled ">
                                        <li><a href="#">8th Standard</a></li>
                                        <li><a href="#">10th Standard</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                    <div class="grow_wrap">
                        <h1 class="grow_header">The Nuclear Power Corporation of India Limited (NPCIL) Recruitment
                            through GATE 2019</h1>
                        <p>The Nuclear Power Corporation of India Limited (NPCIL) is a government-owned corporation of
                            India based in Mumbai in the state of Maharashtra. It is wholly owned by the Central
                            Government and is responsible for the generation of nuclear power for electricity. NPCIL is
                            administered by the Department of Atomic Energy, Govt. of India (DAE).
                        </p>
                        <h1 class="inner_head">Details of Post</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table_exam_details">
                                <tbody>
                                    <tr>
                                        <th>Post</th>
                                        <th>Stream</th>
                                        <th>Pay Scale </th>
                                        <th>No. Of Vacancy
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Graduate - Trainee </td>
                                        <td>ME | EE | EC | CE | CH | IN </td>
                                        <td>Rs. 60,000/- – Rs.180,000/- </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h1 class="inner_head">Important Dates</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table_exam_details">
                                <tbody>
                                    <tr>
                                        <th>Online Application Start Date</th>
                                        <td>March / April 2019</td>
                                    </tr>
                                    <tr>
                                        <th>Online Application End Date </th>
                                        <td>March / April 2019</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html> -->
