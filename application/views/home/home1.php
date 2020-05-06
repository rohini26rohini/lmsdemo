<div id="demo" class="carousel slide index_banner" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo base_url();?>assets/images/banner_back.png" class="img-fluid banner_back" />
                <img class="img-fluid banner_img_a" src="<?php echo base_url();?>assets/images/banner_img.png" />
                <div class="caption_div">
                    <h2 class="b">
                        Direction
                        <small class="p">
                               Take the right turn.
                          </small>
                    </h2>
                </div>
            </div>
        </div>
        <div class="control_panel ">
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    <div class="offer">
        <div class="container">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pad_clear ">
                    <div class="row ">
                        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 offer_wrapper " style="background-image: url(images/list_box.png); ">
                            <div class="offer_box ">
                                What We Offer
                            </div>
                            <ul>
                                <li>
                                    <a href="<?php echo base_url('direction-ias-study-circle');?>" target="_blank ">
                                        <div class="exam_wrap ">
                                            <div class="img_box " style="background-image: url(<?php echo base_url();?>assets/images/ias_icon.png) ">

                                            </div>
                                            <div class="examination_box ">
                                                <h5>Direction IAS Study circle
                                                    <small>Direction , an institution which thrives on hard
                                                    work and systematic</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('direction-school-for-ssc-examinations');?>" target="_blank ">
                                        <div class="exam_wrap ">
                                            <div class="img_box " style="background-image: url(<?php echo base_url();?>assets/images/SSC_icon.png) ">

                                            </div>
                                            <div class="examination_box ">
                                                <h5>Direction School for SSC Examinations
                                                    <small>Direction , an institution which thrives on hard
                                                    work and systematic</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('direction-school-for-netjrf-examinations');?>" target="_blank ">
                                        <div class="exam_wrap ">
                                            <div class="img_box " style="background-image: url(<?php echo base_url();?>assets/images/net_jrf_icon.png) ">

                                            </div>
                                            <div class="examination_box ">
                                                <h5>Direction School for NET/JRF Examinations
                                                    <small>Direction , an institution which thrives on hard
                                                    work and systematic</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('direction-school-of-banking');?>" target="_blank ">
                                        <div class="exam_wrap ">
                                            <div class="img_box " style="background-image: url(<?php echo base_url();?>assets/images/Banking_icon.png) ">
                                            </div>
                                            <div class="examination_box ">
                                                <h5>Direction School of Banking
                                                    <small>Direction , an institution which thrives on hard
                                                    work and systematic</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('direction-school-for-psc-examinations');?>" target="_blank ">
                                        <div class="exam_wrap ">
                                            <div class="img_box " style="background-image: url(<?php echo base_url();?>assets/images/psc_icon.png) ">

                                            </div>
                                            <div class="examination_box ">
                                                <h5>Direction School for PSC Examinations
                                                    <small>Direction , an institution which thrives on hard
                                                    work and systematic</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('direction-junior');?>" target="_blank ">
                                        <div class="exam_wrap ">
                                            <div class="img_box " style="background-image: url(<?php echo base_url();?>assets/images/Junior_icon.png) ">

                                            </div>
                                            <div class="examination_box ">
                                                <h5>Direction Junior
                                                    <small>Direction , an institution which thrives on hard
                                                    work and systematic</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 testimonial " style="background-image: url(<?php echo base_url();?>assets/images/story.png); ">
                            <div class="testimonial_wrap ">
                                <h3>Success Stories</h3>
                                <div id="stories " class="carousel slide " data-ride="carousel ">

                                    <div class="carousel-inner ">
                                    <?php
                                            $i =1;
                                            foreach ($successArr as $success):
                                        ?>
                                        <?php if($i==1){?>
                                        <div class="carousel-item active ">
                                        <?php }else{?>
                                        <div class="carousel-item ">
                                        <?php } ?>
                                            <p><?php echo $success['description']?></p>
                                            <h5><?php echo $success['name']?></h5>
                                        </div>
                                        <?php $i++; endforeach; ?>
                                    </div>
                                    <ul class="carousel-indicators ">
                                        <li data-target="#stories " data-slide-to="0 " class="active "></li>
                                        <li data-target="#stories " data-slide-to="1 "></li>
                                        <li data-target="#stories " data-slide-to="2 "></li>
                                    </ul>
                                    <a href="<?php echo base_url('success-stories');?>"><button class="btn btn-default btn_stories ">More Stories</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="announcement ">
        <div class="container ">
            <h3>Announcements
                <small>Batch information - Exam Information - Result Information - Admission Details</small>
            </h3>
            <div class="owl-carousel owl-theme " id="announcement">
                <?php 
                $iascourses = $this->common->get_coursesby_school(1); 
                if(!empty($iascourses)){
                ?>
                <div class="item " style="background-image:url( '<?php echo base_url();?>assets/images/Announcements_hover.jpg'); ">
                    <div id="box1 " class="carousel slide announcement_carousel_in " data-ride="carousel ">
                        <div class="carousel-inner ">
                            <?php 
                            $i = 1;
                            foreach($iascourses as $course){
                            ?>
                            <div class="carousel-item <?php if($i=1) { echo 'active';} ?> ">

                                <div class="owl_announcement ">
                                    <div class="announcement_avathar_wrapper " style="background-image: url(<?php echo base_url();?>assets/images/avathar.png); ">
                                    </div>
                                    <h4>Direction IAS Study circle
                                    </h4>
                                    <p><?php echo $course->batch_name;?> <?php echo $course->mode;?> Batch</p>
                                    <a href="<?php echo base_url();?>course-detail/<?php echo $course->batch_id;?>"><button class="btn btn-default btn_read_more ">Join</button></a>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <?php } ?>
                            <ul class="carousel-indicators ">
                                <?php 
                                $x = 0;
                                foreach($iascourses as $course){
                                ?>
                                <li data-target="#box1 " data-slide-to="<?php echo $x;?> " class="<?php if($x=0) { echo 'active';}?> "></li>
                                <?php $x++;?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                $ssccourses = $this->common->get_coursesby_school(4); 
                if(!empty($ssccourses)){
                ?>
                <div class="item " style="background-image:url( '<?php echo base_url();?>assets/images/Announcements_hover.jpg'); ">
                    <div id="box2 " class="carousel slide announcement_carousel_in " data-ride="carousel ">
                        <ul class="carousel-indicators ">
                            <?php 
                                $x = 0;
                                foreach($ssccourses as $course){
                                ?>
                                <li data-target="#box2 " data-slide-to="<?php echo $x;?> " class="<?php if($x=0) { echo 'active';}?> "></li>
                                <?php $x++;?>
                                <?php } ?>
                        </ul>
                        <div class="carousel-inner ">
                            <?php 
                            $i = 1;
                            foreach($ssccourses as $course){
                            ?>
                            <div class="carousel-item <?php if($i=1) { echo 'active';} ?> ">
                                <div class="owl_announcement ">
                                    <div class="announcement_avathar_wrapper " style="background-image: url(<?php echo base_url();?>assets/images/avathar.png); ">
                                    </div>
                                    <h4>Direction School for SSC Examinations
                                    </h4>
                                    <p><?php echo $course->batch_name;?> <?php echo $course->mode;?> Batch</p>
                                    <a href="<?php echo base_url();?>course-detail/<?php echo $course->batch_id;?>"><button class="btn btn-default btn_read_more ">Join</button></a>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                $netcourses = $this->common->get_coursesby_school(2); 
                if(!empty($netcourses)){
                ?>
                <div class="item " style="background-image:url( '<?php echo base_url();?>assets/images/Announcements_hover.jpg'); ">
                    <div id="box3 " class="carousel slide announcement_carousel_in " data-ride="carousel ">
                        <ul class="carousel-indicators ">
                            <?php 
                                $x = 0;
                                foreach($netcourses as $course){
                                ?>
                                <li data-target="#box3 " data-slide-to="<?php echo $x;?> " class="<?php if($x=0) { echo 'active';}?> "></li>
                                <?php $x++;?>
                                <?php } ?>
                        </ul>
                        <div class="carousel-inner ">
                            <?php 
                            $i = 1;
                            foreach($netcourses as $course){
                            ?>
                            <div class="carousel-item <?php if($i=1) { echo 'active';} ?> ">
                                <div class="owl_announcement ">
                                    <div class="announcement_avathar_wrapper " style="background-image: url(<?php echo base_url();?>assets/images/avathar.png); ">
                                    </div>
                                    <h4>Direction School for NET/JRF Examinations
                                    </h4>
                                    <p><?php echo $course->batch_name;?> <?php echo $course->mode;?> Batch</p>
                                    <a href="<?php echo base_url();?>course-detail/<?php echo $course->batch_id;?>"><button class="btn btn-default btn_read_more ">Join</button></a>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                $bankcourses = $this->common->get_coursesby_school(5); 
                if(!empty($bankcourses)){
                ?>
                <div class="item " style="background-image:url( '<?php echo base_url();?>assets/images/Announcements_hover.jpg'); ">
                    <div id="box4 " class="carousel slide announcement_carousel_in " data-ride="carousel ">
                        <ul class="carousel-indicators ">
                            <?php 
                                $x = 0;
                                foreach($bankcourses as $course){
                                ?>
                                <li data-target="#box4 " data-slide-to="<?php echo $x;?> " class="<?php if($x=0) { echo 'active';}?> "></li>
                                <?php $x++;?>
                                <?php } ?>
                        </ul>
                        <div class="carousel-inner ">
                            <?php 
                            $i = 1;
                            foreach($bankcourses as $course){
                            ?>
                            <div class="carousel-item <?php if($i=1) { echo 'active';} ?> ">

                                <div class="owl_announcement ">
                                    <div class="announcement_avathar_wrapper " style="background-image: url(<?php echo base_url();?>assets/images/avathar.png); ">
                                    </div>
                                    <h4>Direction School of Banking
                                    </h4>
                                    <p><?php echo $course->batch_name;?> <?php echo $course->mode;?> Batch</p>
                                    <a href="<?php echo base_url();?>course-detail/<?php echo $course->batch_id;?>"><button class="btn btn-default btn_read_more ">Join</button></a>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                $psccourses = $this->common->get_coursesby_school(3); 
                if(!empty($psccourses)){
                ?>
                <div class="item " style="background-image:url( '<?php echo base_url();?>assets/images/Announcements_hover.jpg'); ">
                    <div id="box5 " class="carousel slide announcement_carousel_in " data-ride="carousel ">
                        <ul class="carousel-indicators ">
                            <?php 
                                $x = 0;
                                foreach($psccourses as $course){
                                ?>
                                <li data-target="#box5 " data-slide-to="<?php echo $x;?> " class="<?php if($x=0) { echo 'active';}?> "></li>
                                <?php $x++;?>
                                <?php } ?>
                        </ul>
                        <div class="carousel-inner ">
                            <?php 
                            $i = 1;
                            foreach($psccourses as $course){
                            ?>
                            <div class="carousel-item <?php if($i=1) { echo 'active';} ?> ">
                                <div class="owl_announcement ">
                                    <div class="announcement_avathar_wrapper " style="background-image: url(<?php echo base_url();?>assets/images/avathar.png); ">
                                    </div>
                                    <h4>Direction School for PSC Examinations
                                    </h4>
                                    <p><?php echo $course->batch_name;?> <?php echo $course->mode;?> Batch</p>
                                    <a href="<?php echo base_url();?>course-detail/<?php echo $course->batch_id;?>"><button class="btn btn-default btn_read_more ">Join</button></a>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                $juniorcourses = $this->common->get_coursesby_school(6); 
                if(!empty($juniorcourses)){
                ?>
                <div class="item " style="background-image:url( '<?php echo base_url();?>assets/images/Announcements_hover.jpg'); ">
                    <div id="box6 " class="carousel slide announcement_carousel_in " data-ride="carousel ">
                        <ul class="carousel-indicators ">
                            <?php 
                                $x = 0;
                                foreach($juniorcourses as $course){
                                ?>
                                <li data-target="#box6 " data-slide-to="<?php echo $x;?> " class="<?php if($x=0) { echo 'active';}?> "></li>
                                <?php $x++;?>
                                <?php } ?>
                        </ul>
                        <div class="carousel-inner ">
                            <?php 
                            $i = 1;
                            foreach($juniorcourses as $course){
                            ?>
                            <div class="carousel-item <?php if($i=1) { echo 'active';} ?> ">
                                <div class="owl_announcement ">
                                    <div class="announcement_avathar_wrapper " style="background-image: url(<?php echo base_url();?>assets/images/avathar.png); ">
                                    </div>
                                    <h4>Direction Junior
                                    </h4>
                                    <p><?php echo $course->batch_name;?> <?php echo $course->mode;?> Batch</p>
                                    <a href="<?php echo base_url();?>course-detail/<?php echo $course->batch_id;?>"><button class="btn btn-default btn_read_more ">Join</button></a>
                                </div>
                            </div>
                        <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <section class="why_section" style="background-image: url(<?php echo base_url();?>assets/images/banner_why.jpg);">
        <div class="container ">
            <div class="row ">
                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 offset-xl-7 offset-lg-7 offset-md-6 offset-sm-6 ">
                    <h3>Why Direction ?</h3>
                    <p>
                    <?php 
                        $content = $this->common->get_content('whydirection'); 
                        if(!empty($content)) {
                            echo $aboutcontent = substr($content[0]['content_data'], 0, 220).'...'; 
                        }
                    ?>
                    </p>
                    <a href="<?php echo base_url('why-direction');?>"><button class="btn btn-default ">Read More</button></a>
                </div>
            </div>
        </div>
    </section>
    <section class="blank_white_area"></section>
    <section class="features">
        <div class="container">
            <div class="feature_top">
                <h3>Direction Core Features
                    <small>Our Essence</small>
                </h3>
                <div class="owl-carousel owl-theme " id="features_owl">
                    <?php 
                        if(!empty($corefeatures)){
                            foreach($corefeatures as $row){
                    ?>
                        <div class="item ">
                            <div class="feature_box " style="background-image: url(<?php echo base_url($row->corefeature_image);?>) "></div>
                            <h4><?php echo $row->corefeature_name;?></h4>
                            <p><?php echo $row->corefeature_description;?></p>
                        </div>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </section>



  