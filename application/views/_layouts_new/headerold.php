<body>
    <div class="loader">
        <img src="<?php echo base_url();?>direction_v2/images/loader.svg">
    </div>
    <header>
        <div class="container maincontainer ">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-lg-flex d-md-block ">
                    <div class="Logo mainlogo">
                        <a href="<?php echo base_url('home');?>">
                            <img src="<?php echo base_url();?>direction_v2/images/logo/logo.png" alt="logo" class="img-fluid">
                        </a>
                    </div>
                    <div class="MainNav align-self-center">
                        <nav> 
                            <a id="resp-menu" class="responsive-menu" href="#"><i class="fas fa-bars"></i></a>
                            <ul class="menu">
                                <li><a class="homer" href="<?php echo base_url();?>"> Home</a>
                                </li>
                                <li><a href="<?php echo base_url('about-us');?>"> About Us</a>
                                </li>
                                <li class="Courses"><a href="#">Courses</a>
                                    <ul class="sub-menu ">
                                        <li><a href="<?php echo base_url('direction-ias-study-circle');?>">Direction IAS Study circle</a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(1); 
                                                if(!empty($batches)) {
                                                    foreach($batches as $batches) {
                                                        echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-netjrf-examinations');?>">Direction School for NET/JRF Examinations </a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(2); 
                                                    if(!empty($batches)) {
                                                        foreach($batches as $batches) {
                                                            echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                        }
                                                    }
                                                ?>
                                                
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-psc-examinations');?>">Direction School for PSC Examinations </a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(3); 
                                                    if(!empty($batches)) {
                                                        foreach($batches as $batches) {
                                                            echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-ssc-examinations');?>">Direction School for SSC Examinations </a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(4); 
                                                    if(!empty($batches)) {
                                                        foreach($batches as $batches) {
                                                            echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-of-banking');?>">Direction School of Banking </a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(5); 
                                                    if(!empty($batches)) {
                                                        foreach($batches as $batches) {
                                                            echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-school-for-entrance-examinations');?>">Direction School for entrance examinations </a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(6); 
                                                    if(!empty($batches)) {
                                                        foreach($batches as $batches) {
                                                            echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="<?php echo base_url('direction-junior');?>">Direction Junior </a>
                                            <ul>
                                                <?php $batches= $this->common->get_batches(7); 
                                                    if(!empty($batches)) {
                                                        foreach($batches as $batches) {
                                                            echo '<li><a href="'.base_url('detailed-batch-ias/'.$batches['batch_id']).'">'.$batches['batch_name'].'</a></li>';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url('services');?>"> Services</a></li>
                                <li><a href="<?php echo base_url('registration');?>"> Admission</a></li>
                                <li><a href="<?php echo base_url('result');?>"> Result</a></li>
                                <li><a href="<?php echo base_url('work-with-us');?>"> Careers</a></li>
                                <li><a href="<?php echo base_url('gallery');?>"> Gallery</a></li>
                                <li><a href="<?php echo base_url('contact-us');?>"> Contact Us</a></li>
                                <li class="relogin  btn BtnOrang"><a href="login.html"> Login</a></li>
                                <li class="login btn BtnOrang"><a href="<?php echo base_url('login');?>">Login</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
