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
                                    Direction IAS Study Circle
                                </a>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <ul class=" list-unstyled ">
                                        <?php $results= $this->common->get_all_results(1); 
                                        // echo $this->db->last_query();
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
                                    Direction School for NET/JRF Examinations
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
                                    Direction School for PSC Examinations
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
                                    Direction School for SSC Examinations
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
                                    Direction School of Banking
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
                                    School for entrance examinations
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
                                    Direction Junior
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
                <h3>No Data Found</h3>
            </div>
        </div>
    </section>