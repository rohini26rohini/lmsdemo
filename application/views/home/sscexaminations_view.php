
    <div class="ssc subpagebanner">
        <div class="container maincontainer">
            <div class="row CustomRow">
                <div class="col-md-9 col-sm-12 col-12 paddright">
                    <div class="wapperbanner">
                        <div id="slider" class="carousel slide" data-ride="carousel">
                            <ul class="carousel-indicators">
                            <?php
                                $i =0;
                                foreach ($schoolBannerArr as $Banner){
                                ?>
                                <li data-target="#slider" data-slide-to="<?php echo $i;?>" <?php if($i == 0 ) {echo 'class="active"';}?>></li>
                                <?php $i++; } ?>
                            </ul>
                            <div class="carousel-inner  d-flex align-items-center">
                            <?php
                            // echo "<pre>";
                            // print_r($schoolBannerArr); exit;
                                $i =1;
                                foreach ($schoolBannerArr as $Banner){
                                ?>
                                <div class="carousel-item <?php if($i == 1 ) {echo 'active';}?>">
                                    <div id="ssc" class="slide" style="background-image: url('<?php echo base_url() ?>/uploads/banner_images/<?php echo $Banner['banner_image'];?>')">
                                    </div>
                                </div>
                                <?php $i++; } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-12  paddleft ">
                    <div class="Notifications bgssc">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>Upcoming Exams & Notifications</h4>
                            </div>
                            <?php  if(!empty($notificationArr)){ ?>

                            <div class="panel-body">

                                <ul class="demo1">
                                    <?php
                                     
                                        foreach ($notificationArr as $notification):
                                    ?>
                                    <li class="news-item Aligner">
                                        <img src="<?php echo base_url();?>direction_v2/images/Notifications.png" alt="Notifications" class="img-circle" />
                                        <?php if($notification['file']!=''){ ?>
                                            <p>
                                                <a href="<?php echo $notification['file']?>" target="_blank"><?php echo $notification['name']?></a>
                                            </p>
                                        <?php }else{ ?>
                                            <p><?php echo $notification['name'];?></p>
                                        <?php  } ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <a href="<?php echo base_url('upcoming-notifications-ssc');?>" class="viewbtn">View More</a>
                        <?php  } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="Takesection">
        <div class="container maincontainer">
            <div class="owl-carousel owl-theme Takesection" id="Takebox">
                <div class="item">
                    <div class="subsliderbox  ">
                        <img src="<?php echo base_url();?>direction_v2/images/Take-a-Test.svg" alt="Take a Test">
                        <div class="carousel-caption">
                            <h3>Take a Test</h3>
                            <p>Complete a free test you will get the number of questions you answered correctly.</p>
                            <ul class="nav nav-bar ">
                                <li class="btn bgssc"><a onClick="redirect('sample-test/4');" href="#">Sample Test</a></li>
                                <!-- <button class="btn bgssc" onClick="redirect('sample-test/4');">Sample Test</button> -->
                                <!-- <li class="btn bgssc"><a href="#">Purchase a Test</a></li> -->
                            </ul>
                            <br>
                        <?php $message = $this->session->flashdata('data_name'); 
                            if(isset($message))
                            {
                              echo '<div class="alert alert-danger alert-dismissible fade show">
                                    <strong> '.$message.'.</strong>
                                    </div>';  
                            }
                            
                            ?>
                        </div>
                    </div>
                </div>
                <?php   if(!empty($prepareArr)) {?>
                <div class="item">
                    <div class="subsliderbox Prepare">
                        <img src="<?php echo base_url();?>direction_v2/images/How-to-Prepare.svg" alt="How to Prepare">
                        <div class="carousel-caption">
                        <h3>How to Prepare</h3>
                            <p>Planning to prepare for SSC exams in <?php echo date("Y");?>! Find syllabus here</p>             
                            <ul class="nav nav-bar ">
                                <li class="btn bgssc"><a href="<?php echo base_url('direction-school-for-ssc-examinations-how-to-prepare');?>">View More</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php  }?>
                <?php if($syllabus){?>
                <div class="item">
                    <div class="subsliderbox netjrfStudies">
                        <?php //echo $maxid; ?>
                        <img src="<?php echo base_url();?>direction_v2/images/General-Studies.svg" alt="General Studies">
                        <div class="carousel-caption">
                            <h3>Syllabus</h3>
                            <p>Planning to prepare for SSC exams in <?php echo date("Y");?>! Find syllabus here</p>    
                            <li class="btn bgssc"><a href="<?php echo base_url('direction-school-for-ssc-examinations-syllabus/'.$syllabus.'');?>">View More</a></li>
                        </div>
                    </div>
                </div>
                <?php }if($previous_question){?>
                <div class="item">
                    <div class="subsliderbox netjrfStudies">
                        <img src="<?php echo base_url();?>direction_v2/images/previous-question.png" alt="General Studies">
                        <div class="carousel-caption">
                            <h3>Previous Question</h3>
                            <p>A collection of previous year question papers of School of SSC examinations</p>    
                            <li class="btn bgssc"><a href="<?php echo base_url('direction-school-for-ssc-examinations-previous-question/'.$previous_question.'');?>">View More</a></li>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="Programs">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="ourprograms">
                        <h4>Our Programs</h4>
                        <p>Direction School for SSC Examinations</p>
                        <div id="ourprograms" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $courses = $this->common->get_coursesby_school(4);
                                if(!empty($courses)){

                                $i =1;
                                foreach($courses as $course) {    
                                ?>
                                <div class="carousel-item <?php if($i==1){ echo 'active'; }?>">             
                                    <div class="caption">
                                        <img src="<?php echo base_url();?>direction_v2/images/Our_Programs.png" alt="Our Programs">
                                        <p>Course Duration:
                                            <span> 
                                                <?php   
                                                $datetime1 = new DateTime($course->batch_datefrom);
                                                $datetime2 = new DateTime($course->batch_dateto);
                                                $interval = $datetime1->diff($datetime2);
                                                if($interval->format('%m Months') =='0 Months'){
                                                    echo $interval->format('%d Days');
                                                }else{
                                                    echo $interval->format('%m Months %d Days');
                                                }
                                               
                                                ?>
                                            </span>
                                        </p>
                                        <p>Qualification: <span><?php echo ucfirst($course->basic_qualification);?></span></p>
                                    </div>
                                    <div class="carouselcaption">
                                        <h4><a class="Programstooltip" data-toggle="tooltip" data-placement="right" title="<?php echo $course->batch_name."($course->class_name)";?>"><?php echo substr($course->batch_name."($course->class_name)", 0, 60).'...';?></a>
                                        <span>(<?php echo $course->mode;?> Batch) </span>
                                        <div class="clearfix"></div>
                                        </h4>
                                        <a href="<?php echo base_url();?>detailed_batch/<?php echo $course->class_id.'/'.$course->school_id;?>" class="btn bgssc">More Details</a>
                                    </div>
                                </div>
                                <?php $i++;} }?>
                            </div>
                            <div class="control">
                                <a class="carousel-control-prev" href="#ourprograms" data-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#ourprograms" data-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="success sscsuccess">
                        <h4>Success Story</h4>
                        <div id="successstory" class="carousel slide" data-ride="carousel">
                            <ul class="carousel-indicators">
                            <?php
                            $i =0;
                            foreach ($successArr as $success){
                            ?>
                            <?php if($success['document_type']==1){ ?>
                                <li data-target="#successstory" data-slide-to="<?php echo $i;?>" <?php if($i == 0){ echo 'class="active"'; }?>></li>
                            <?php $i++; }} ?>
                            </ul>
                            <div class="carousel-inner">
                            <?php
                            $i =1;
                            foreach ($successArr as $success):
                            ?>
                            <?php if($success['document_type']==1){?>
                                <div class="carousel-item <?php if($i == 1){ echo 'active'; }?> ">
                                    <div class="caption">
                                        <p><?php $str1=$success['description'];  $str = substr($str1, 0, 120); echo strip_tags($str);?></p>
                                        <!-- <a href="<?php echo base_url();?>single-story/<?php echo $success['success_id'];?>" class="btn bgent">View More</a> -->
                                    </div>
                                    <div class="media media_comment Aligner">
                                    <?php 
                                    if($success['document']=='') {
                                    ?>
                                    <img src="<?php echo base_url();?>assets/images/avathar.png" alt="Success"
                                            class="mr-3 align-self-center rounded-circle img-thumbnail">
                                   <?php } else { ?>
                                        <img src="<?php echo base_url();?>uploads/success_stories/<?php echo $success['document']?>" alt="Success"
                                            class="mr-3 align-self-center rounded-circle img-thumbnail">
                                    <?php } ?>  
                                        <div class="media-body">
                                        <h4><?php echo $success['name']?><small><?php echo "&nbsp;".$success['location']?></small></h4>
                                        </div>
                                    </div><a href="<?php echo base_url();?>school-stories/4" data-toggle="tooltip" data-placement="top" title="" class="SStoryView SscStoryView" data-original-title="More !"><i class="fas fa-chevron-right"></i></a>
                                </div>
                                <?php } ?>
                                <?php $i++; endforeach; ?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php //echo "<pre>"; print_r($schoolgalleryArr); exit;
                if ($schoolgalleryArr != null) {?>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="gallery sscgallery">
                        <h4>Event Gallery</h4>
                        <div class="gallery">
                        <ul class="nav nav-bar">
                        <?php
                            $i =1;
                            foreach ($schoolgalleryArr as $image){?>
                                <li><a href="<?php echo base_url();?>/uploads/gallery/<?php echo $image->gallery_image; ?>">
                                <!-- <img src="<?php echo base_url();?>/uploads/gallery/<?php echo $image->gallery_image; ?>" alt="Gallery"> -->
                                <div style="background-image:url(<?php echo base_url();?>/uploads/gallery/<?php echo $image->gallery_image; ?>);" class="galleryImg"></div>
                            </a></li>
                            <?php }
                            ?>
                            <li class="btnview"><a href="<?php echo base_url('gallery/'.$school);?>">View More</a></li>
                        </ul>
                        </div>
                    </div>
                </div>
                <?php } else{?>
                    
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="gallery">
                    <h4>Event Gallery</h4>
                        <p>No resend gallery found</p>
                    </div>
                </div>
                    <?php }?>
            </div>
        </div>
    </div>

    <div class="special">
        <div class="container maincontainer">
            <div class="title">
                <h4 class="text-center">What is special about Direction school for ssc examinations</h4>
            </div>
            <div class="specialcondent Achievement">
                <div class="condentimg">
                    <img src="<?php echo base_url();?>direction_v2/images/direction-ssc.png" alt="special" class="rounded-circle img-fluid">
                </div>
                <ul class="speciallist rightlist text-left">
                    <?php
                    $i =1;
                    $count = count($specialArr)/2;
                    foreach ($specialArr as $special):
                    ?>
                    <li><?php echo $special['keywords']?></li>
                    <?php if($i == $count){?>
                        </ul>
                        <ul class="speciallist leftlist text-right">
                    <?php } ?>
                    <?php $i++; endforeach; ?> 
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="<?php echo base_url();?>direction_v2/js/simple-lightbox.js"></script>
<script>
	$(function(){
		var $gallery = $('.gallery a').simpleLightbox();

		$gallery.on('show.simplelightbox', function(){
			console.log('Requested for showing');
		})
		.on('shown.simplelightbox', function(){
			console.log('Shown');
		})
		.on('close.simplelightbox', function(){
			console.log('Requested for closing');
		})
		.on('closed.simplelightbox', function(){
			console.log('Closed');
		})
		.on('change.simplelightbox', function(){
			console.log('Requested for change');
		})
		.on('next.simplelightbox', function(){
			console.log('Requested for next');
		})
		.on('prev.simplelightbox', function(){
			console.log('Requested for prev');
		})
		.on('nextImageLoaded.simplelightbox', function(){
			console.log('Next image loaded');
		})
		.on('prevImageLoaded.simplelightbox', function(){
			console.log('Prev image loaded');
		})
		.on('changed.simplelightbox', function(){
			console.log('Image changed');
		})
		.on('nextDone.simplelightbox', function(){
			console.log('Image changed to next');
		})
		.on('prevDone.simplelightbox', function(){
			console.log('Image changed to prev');
		})
		.on('error.simplelightbox', function(e){
			console.log('No image found, go to the next/prev');
			console.log(e);
		});
	});
</script>
</html>