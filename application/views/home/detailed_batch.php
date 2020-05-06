<!DOCTYPE html>
<html lang="en">
    <body>
    
        <div class="abtbanner BgGrdOrange ">
            <div class="container maincontainer">
                <h3>Batch Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?php if($breadcrumb == 1){
                        echo '<a href="'.base_url('direction-ias-study-circle').'"> Direction IAS Study circle </a>'; 
                    }else if($breadcrumb == 2){
                        echo '<a href="'.base_url('direction-school-for-netjrf-examinations').'"> Direction School for NET/JRF Examinations </a>'; 
                    }else if($breadcrumb == 3){
                        echo '<a href="'.base_url('direction-school-for-psc-examinations').'"> Direction School for PSC Examinations </a>'; 
                    }else if($breadcrumb == 4){
                        echo '<a href="'.base_url('direction-school-for-ssc-examinations').'"> Direction School for SSC Examinations </a>'; 
                    }else if($breadcrumb == 5){
                        echo '<a href="'.base_url('direction-school-of-banking').'"> Direction School of Banking </a>'; 
                    }else if($breadcrumb == 6){
                        echo '<a href="'.base_url('direction-junior').'"> Direction Junior </a>'; 
                    }else if($breadcrumb == 7){
                        echo '<a href="'.base_url('direction-school-for-entrance-examinations').'"> Direction school for Entrance Examinations </a>'; 
                    }else if($breadcrumb == 8){
                        echo '<a href="'.base_url('direction-school-for-rrb-examinations').'"> Direction school for RRB examinations </a>'; 
                    }else if($breadcrumb == 0){
                        echo '<a href="'.base_url('success-stories').'"> Success Stories </a>'; 
                    }?>
                </li>
                    <li class="breadcrumb-item active" aria-current="page">Batch Details</li>
                </ol>
            </div>
        </div>
        <section class="inner_page_wrapper coursetwo ias">
            <div class="container maincontainer">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="CourseMainBox CourseContent">
                            <!-- <h1>For Aspirants Targeting <span>xvfgd</span></h1> -->
                            <?php 
                            if(!empty($detailedArr)){ 
                            $i =1;
                            foreach ($detailedArr as $row){
                                $today = date('Y-m-d');
                                if(strtotime($row['last_date']) > strtotime($today)) {
                                $sunday=$this->common->get_class_session_byday($row['batch_id'],'Sun');
                                $monday=$this->common->get_class_session_byday($row['batch_id'],'Mon');
                                $tuesday=$this->common->get_class_session_byday($row['batch_id'],'Tue');
                                $wednesday=$this->common->get_class_session_byday($row['batch_id'],'Wed');
                                $thursday=$this->common->get_class_session_byday($row['batch_id'],'Thu');
                                $friday=$this->common->get_class_session_byday($row['batch_id'],'Fri');
                                $saturday=$this->common->get_class_session_byday($row['batch_id'],'Sat');
                            ?>
                            <div class="row">
                            
                                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                <p class="subtitle"><?php echo $row['batch_name'];?></p>
                                    <div class="SideboxCourse">
                                        
                                        <ul class="">
                                            <li><i class="fas fa-user-graduate"></i>Total No of Student <span><?php echo $row['batch_capacity'];?></span>
                                            </li>
                                            <li><i class="far fa-calendar-alt"></i>Last date of Admission
                                                <span><?php echo date('d-m-Y', strtotime($row['last_date']));?></span></li>
                                        </ul>
                                        <ul class="">
                                            <li><i class="far fa-calendar-alt"></i>Start Date <span><?php echo date('d-m-Y', strtotime($row['batch_datefrom']));?></span>
                                            </li>
                                            <li><i class="far fa-calendar-alt"></i>End Date <span><?php echo date('d-m-Y', strtotime($row['batch_dateto']));?></span></li>
                                          
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive">
                                        <h4>Week Days</h4>
                                        <table class="table table-bordered table-sm table_exam_details">
                                            <tbody>
                                                <tr>
                                                    <th style="font-weight:normal;font-size:14px;">Sun</th>
                                                    <th style="font-weight:normal;font-size:14px;">Mon</th>
                                                    <th style="font-weight:normal;font-size:14px;">Tue</th>
                                                    <th style="font-weight:normal;font-size:14px;">Wed</th>
                                                    <th style="font-weight:normal;font-size:14px;">Thu</th>
                                                    <th style="font-weight:normal;font-size:14px;">Fri</th>
                                                    <th style="font-weight:normal;font-size:14px;">Sat</th>
                                                </tr>
                                                <tr>
                                                    <td><?php if($row['sunday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                    <td><?php if($row['monday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                    <td><?php if($row['tuesday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                    <td><?php if($row['wednesday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                    <td><?php if($row['thursday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                    <td><?php if($row['friday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                    <td><?php if($row['saturday']=="1"){ echo "<i class='fas fa-check'></i>";  }else{echo "<i class='fas fa-times'></i>";} ?></td>
                                                </tr>
                                                <tr>
                                        <td>
                                            <span style="display:block" class="batch_days" id="sunday_div">
                                                    <?php echo $sunday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="monday_div">
                                                           <?php echo $monday; ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="tuesday_div">
                                                       <?php echo $tuesday; ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="wednesday_div">
                                                       <?php echo $wednesday; ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="thursday_div">
                                                       <?php echo $thursday; ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="friday_div">
                                                       <?php echo $friday; ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="batch_days" id="saturday_div">
                                                       <?php echo $saturday; ?>
                                            </table>
                                        </td>


                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="CourseContent">
                                <!-- <p class="subtitle">UPSC Civil Services Prelims Cum Mains Batch 2019 (Regular)
                                    <span> Four General Studies</span>
                                </p>
                                <ul class="abtlist">
                                    <li>Focus on General Studies (Preliminary and Mains)and CSAT.</li>
                                    <li>Course covers all relevant areas of the Examination.</li>
                                    <li>Expert guidance, Meticulously Designed Study materials & library Support</li>
                                </ul>


                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer
                                    took a galley of type and scrambled it to make a type specimen book. It has survived not
                                    only
                                    five centuries, but also the leap into electronic typesetting, remaining essentially
                                    unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                    containing
                                    Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                                    PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only
                                    five centuries, but also the leap into electronic typesetting, remaining essentially
                                    unchanged.
                                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum.
                                </p> -->
                                <a href="<?php echo base_url('registration');?>">Join Now</a>
                                <div class="clearfix"></div>
                                <hr>
                            </div>
                            <?php $i++; 
                            }
                        }} ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>