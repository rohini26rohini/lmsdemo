<div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer paddleft">
            <h3>Result</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Result</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper result">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="noti" id="accordion">
                        <div class="card ">
                            <div class="card-header ">  <!-- active-->
                                <a class="card-link collapsed " data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                BBA Courses
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <ul class=" list-unstyled ">
                                        <?php $results= $this->common->get_all_results(1); 
                                        if(!empty($results)) {
                                            foreach($results as $results) {
                                                echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/1">'.$results['name'].'</a></li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                NET/JRF Examination Courses
                                </a>
                            </div>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                            <div class="card-body">
                                <ul class=" list-unstyled ">
                                    <?php $results= $this->common->get_all_results(2); 
                                    if(!empty($results)) {
                                        foreach($results as $results) {
                                            echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/2">'.$results['name'].'</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                                MBA Courses
                                </a>
                            </div>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion" style="">
                            <div class="card-body">
                                <ul class=" list-unstyled ">
                                    <?php $results= $this->common->get_all_results(3); 
                                    if(!empty($results)) {
                                        foreach($results as $results) {
                                            echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/3">'.$results['name'].'</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapsefore">
                                SSC Examination Courses
                                </a>
                            </div>
                        </div>
                        <div id="collapsefore" class="collapse" data-parent="#accordion" style="">
                            <div class="card-body">
                                <ul class=" list-unstyled ">
                                    <?php $results= $this->common->get_all_results(4); 
                                    if(!empty($results)) {
                                        foreach($results as $results) {
                                            echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/4">'.$results['name'].'</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapsefive">
                                Banking Examination Courses
                                </a>
                            </div>
                        </div>
                        <div id="collapsefive" class="collapse" data-parent="#accordion" style="">
                            <div class="card-body">
                                <ul class=" list-unstyled ">
                                    <?php $results= $this->common->get_all_results(5); 
                                    if(!empty($results)) {
                                        foreach($results as $results) {
                                            echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/5">'.$results['name'].'</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapsesix">Direction
                                Entrance examination Courses
                                </a>
                            </div>
                        </div>
                        <div id="collapsesix" class="collapse" data-parent="#accordion" style="">
                            <div class="card-body">
                                <ul class=" list-unstyled ">
                                    <?php $results= $this->common->get_all_results(7); 
                                    if(!empty($results)) {
                                        foreach($results as $results) {
                                            echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/7">'.$results['name'].'</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseseven">
                                B-tech Courses 
                                </a>
                            </div>
                            <div id="collapseseven" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <ul class=" list-unstyled ">
                                        <?php $results= $this->common->get_all_results(6); 
                                        if(!empty($results)) {
                                            foreach($results as $results) {
                                                echo '<li><a href="'.base_url('detailed_result/'.$results['notification_id']).'/6">'.$results['name'].'</a></li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                    <div class="resultsection">
                        <?php if(!empty($eresults)){ ?>
                            <h3><?php echo $eresults['name'];?> <span><?php echo $eresults['city_id'];?></span></h3>
                        <?php  }else{ ?>
                        <h3>No Data Found</h3>
                        <?php  }?>
                        <?php
                        if(!empty($detailedArr)):
                        $i =1;
                        foreach ($detailedArr as $res):
                        ?>
                        <div class="resultbox">
                            <div class="card">
                             
                                <?php if($res['file_name']==''){?>
                                    <img class="img-fluid" alt="Achievement" src="<?php echo base_url();?>assets/images/profile_img.png">
                                <?php }else{ ?>
                                    <img class="img-fluid" alt="Achievement" src="<?php echo base_url();?><?php echo $res['file_name']?>">
                                <?php  } ?>
                                <div class="card-body">
                                    <div class="card-text">
                                        <h5>Rank <span> <?php echo $res['rank']?></span></h5>
                                        <h3><?php echo $res['name']?></h3>
                                        <h3><?php echo $res['city_id']?></h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++; endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>