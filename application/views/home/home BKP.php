<script>
setInterval(function(){
    $.ajax({
        url: '<?php echo base_url();?>Home/careerCheck',  
    	type: 'POST',
        data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            // alert(response);
        }
    });
}, 9000);
</script>
    <div class="MainBanner BgGrdOrange ">
        <!-- <div class="container mainc-ontainer">
            <div class="BannerControl">
                <a class="carousel-control-prev" href="#slider" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#slider" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div> -->
            <div class="wapperbanner">
            <!-- 

			    <div id="slider" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                    <?php 
                        $i=0; 
                        // echo "<pre>";
                        //  print_r($banner); exit;
                        foreach($banner as $data){ 
                        ?>
                        <li data-target="#slider" data-slide-to="<?php echo $i; ?>" <?php if($i == 0 ) {echo 'class="active"';}?>></li>
                    <?php  $i++;
                       }
                        ?>
                    </ul>
                    <div class="carousel-inner  d-flex align-items-center">
                    <?php 
                    if(!empty($banner)){
                        $i=1; 
                        foreach($banner as $data){
                        ?>
                        <div class="carousel-item <?php if($i == 1 ) {echo 'active';}?>">
                            <a href="<?php if(!empty($data['school_id'])){
                                if($data['school_id'] == 1){echo base_url('direction-ias-study-circle');}
                                else if($data['school_id'] == 2){echo base_url('direction-school-for-netjrf-examinations');}
                                else if($data['school_id'] == 3){echo base_url('direction-school-for-psc-examinations');}
                                else if($data['school_id'] == 4){echo base_url('direction-school-for-ssc-examinations');}
                                else if($data['school_id'] == 5){echo base_url('direction-school-of-banking');}
                                else if($data['school_id'] == 6){echo base_url('direction-junior');}
                                else if($data['school_id'] == 7){echo base_url('direction-school-for-entrance-examinations');}
                                else if($data['school_id'] == 8){echo base_url('direction-school-for-rrb-examinations');}
                            } ?>" class="linkbanner">
                                <div class="slide" style="background-image: url('<?php echo base_url() ?>/uploads/banner_images/<?php echo $data['banner_image'];?>')">
                                </div>
                            </a>
                        </div>
                        <?php 
                        $i++;
                       } }?>
                    </div>
                </div>

			 -->
            </div>
        </div>
    </div>
    <?php //echo "<pre>";print_r($banner); exit;?>
    <div class="Achievement">
        <div class="container maincontainer">
            <div class="NotificationBox ">
         
            </div>
            <div class="row ">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 paddingright">
                    <div id="Achievementslider" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                    <?php 
                        $i=0;
                        foreach($inner_slider as $data){ 
                        ?>
                            <li data-target="#Achievementslider" data-slide-to="<?php echo $i; ?>" <?php if($i == 0 ) {echo 'class="active"';}?>></li>
                        <?php $i++; }?>
                    </ul>
                    <div class="carousel-inner">
                        <?php 
                        $i=1;
                        // echo "<pre>";
                        //  print_r($inner_slider); exit;
                        foreach($inner_slider as $data){ 
                        ?>
                            <div class="carousel-item <?php if($i == 1 ) {echo 'active';}?>">
                                <div class="AchievementWrap" style="background-image:url(<?php echo base_url() ?>/uploads/banner_images/<?php echo $data['banner_image']?>)">
                                    <!-- <img src="<?php echo base_url() ?>/uploads/banner_images/<?php echo $data['banner_image']?>" alt="Achievement"> -->
                                </div>
                            </div>
                            <?php $i++;
                        }
                        ?>
                        </div>
                        <div class="AchievementCtrl">
                            <a class="carousel-control-prev" href="#Achievementslider" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#Achievementslider" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 Paddingleft d-flex align-items-stretch">
                    <div class="Testimonial BgOrange">
                        <h3>Success <span>Stories</span></h3>
                        <div id="TestimonialSlider" class="carousel slide" data-ride="carousel">
                            <ul class="carousel-indicators ">
                            <?php
                                $i =0;
                                foreach ($successArr as $success){
                                ?>
                                    <li data-target="#TestimonialSlider" data-slide-to="<?php echo $i ?>" <?php if($i == 0 ) {echo 'class="active"';} else{echo '';}?>></li>
                                <?php $i++; } ?>
                            </ul>
                            <div class="carousel-inner">
                                <?php
                                $i =1;
                                foreach ($successArr as $success):
                                ?>
                                    <?php if($i==1){?>
                                    <div class="carousel-item active ">
                                    <?php }else{?>
                                    <div class="carousel-item ">
                                    <?php } ?>
                                        <p><?php $str1=$success['description'];  $str = substr($str1, 0, 150); echo strip_tags($str)."..."; ?></p>
                                        <h5><?php echo $success['name']?></h5>
                                                       
                                    </div>
                                <?php $i++; endforeach; ?>
                            </div>
                            <a href="<?php echo base_url('success-stories');?>">More Stories</a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
