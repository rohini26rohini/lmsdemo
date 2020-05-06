<!DOCTYPE html>
<html lang="en">
    <body class="iasbdy">
        <div class="ias subpagebanner">
            <div class="container maincontainer">
                <div class="row CustomRow">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 paddright ">
                        <div class="wapperbanner">
                            <div id="slider" class="carousel slide" data-ride="carousel">
                                <ul class="carousel-indicators">
                                    <li data-target="#slider" data-slide-to="0" class="active"></li>
                                    <li data-target="#slider" data-slide-to="1"></li>
                                    <li data-target="#slider" data-slide-to="2"></li>
                                </ul>
                                <div class="carousel-inner  d-flex align-items-center">
                                    <div class="carousel-item active ">
                                        <div class="slide" style="background-image: url('<?php echo base_url();?>direction_v2/images/slider/iasslider.png')"></div>
                                    </div>
                                    <div class="carousel-item ">
                                        <div class="slide" style="background-image: url('<?php echo base_url();?>direction_v2/images/slider/iasslider.png')"></div>
                                    </div>
                                    <div class="carousel-item ">
                                        <div class="slide" style="background-image: url('<?php echo base_url();?>direction_v2/images/slider/iasslider.png')"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12  paddleft ">
                        <div class="Notifications iasbg">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>Upcoming Exams & Notifications</h4>
                                </div>
                                <div class="panel-body">
                                    <ul class="demo1">
                                        <?php
                                        $i =1;
                                        foreach ($notificationArr as $notification):
                                        ?>
                                        <li class="news-item Aligner">
                                            <img src="<?php echo base_url();?>direction_v2/images/Notifications.png" alt="Notifications" class="img-circle" />
                                            <p><?php echo $notification['name']?></p>
                                        </li>
                                        <?php $i++; endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <a href="<?php echo base_url('upcoming-notifications-ias');?>" class="viewbtn">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container maincontainer">
            <div class="owl-carousel owl-theme Takesection" id="Takebox">
                <div class="item">
                    <div class="subsliderbox  ">
                        <img src="<?php echo base_url();?>direction_v2/images/Take-a-Test.svg" alt="Take a Test">
                        <div class="carousel-caption">
                            <h3>Take a Test</h3>
                            <p>Content Needed Content Needed Content Needed</p>
                            <ul class="nav nav-bar ">
                                <li class="btn iasbg"><a onClick="redirect('sample-test/1');" href="#">Sample Test</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="subsliderbox Prepare">
                        <img src="<?php echo base_url();?>direction_v2/images/How-to-Prepare.svg" alt="How to Prepare">
                        <div class="carousel-caption">
                            <h3>How to Prepare</h3>
                            <p>Content Needed Content Needed Content Needed</p>
                            <ul class="nav nav-bar ">
                                <li class="btn iasbg"><a href="<?php echo base_url('how-to-prepare-ias');?>">View More</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="subsliderbox  ">
                        <img src="<?php echo base_url();?>direction_v2/images/General-Studies.svg" alt="General Studies">
                        <div class="carousel-caption">
                            <h3>General Studies</h3>
                            <p>Content Needed Content Needed Content Needed</p>
                            <div class=" s">
                                <div class="owl-carousel owl-theme month_owl General">
                                    <div class="item">
                                        <div class="btn iasbg "><a target="_blank" href="<?php echo base_url();?>direction-ias-study-circle/tutorial-1<?php //echo $row['subject_id'];?>">Topic 1</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-2">Topic 2</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-3">Topic 3</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-4">Topic 4</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-5">Topic 5</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="subsliderbox  ">
                        <img src="<?php echo base_url();?>direction_v2/images/Take-a-Test.svg" alt="Take a Test">
                        <div class="carousel-caption">
                            <h3>Take a Test</h3>
                            <p>Content Needed Content Needed Content Needed</p>
                            <ul class="nav nav-bar ">
                                <li class="btn iasbg"><a onClick="redirect('sample-test/1');" href="#">Sample Test</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="subsliderbox Prepare">
                        <img src="<?php echo base_url();?>direction_v2/images/How-to-Prepare.svg" alt="How to Prepare">
                        <div class="carousel-caption">
                            <h3>How to Prepare</h3>
                            <p>Content Needed Content Needed Content Needed</p>
                            <ul class="nav nav-bar ">
                                <li class="btn iasbg"><a href="<?php echo base_url('how-to-prepare-ias');?>">View More</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="subsliderbox  ">
                        <img src="<?php echo base_url();?>direction_v2/images/General-Studies.svg" alt="General Studies">
                        <div class="carousel-caption">
                            <h3>General Studies</h3>
                            <p>Content Needed Content Needed Content Needed</p>
                            <div class=" s">
                                <div class="owl-carousel owl-theme month_owl General">
                                    <div class="item">
                                        <div class="btn iasbg "><a target="_blank" href="<?php echo base_url();?>direction-ias-study-circle/tutorial-1<?php //echo $row['subject_id'];?>">Topic 1</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-2">Topic 2</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-3">Topic 3</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-4">Topic 4</a></div>
                                    </div>
                                    <div class="item">
                                        <div class="btn iasbg "><a href="<?php echo base_url();?>direction-ias-study-circle/tutorial-5">Topic 5</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iasPrograms Programs">
            <div class="container maincontainer">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="ourprograms iasprograms">
                            <h4>Our Programs</h4>
                            <p>Direction IAS Study circle</p>
                            <div id="ourprograms" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="caption">
                                            <img src="<?php echo base_url();?>direction_v2/images/Our_Programs.png" alt="Our Programs">
                                            <p>Course Duration: <span> 10 Months </span></p>
                                            <p>Qualification <span>Any Degree.</span></p>
                                        </div>
                                        <div class="carouselcaption">
                                            <h4>Civil Services Prelims cum Mains Batch <span>(Regular Batch) </span>
                                            </h4>
                                            <a href="<?php echo base_url('direction-ias-aspirants');?>" class="btn iasbg">More Details</a>
                                        </div>
                                    </div>
                                    <div class="carousel-item ">
                                        <div class="caption">
                                            <img src="<?php echo base_url();?>direction_v2/images/Our_Programs.png" alt="Our Programs">
                                            <p>Course Duration: <span> 10 Months </span></p>
                                            <p>Qualification <span>Any Degree.</span></p>
                                        </div>
                                        <div class="carouselcaption">
                                            <h4>UPSC civil Services Prelims cum mains batch <span>( Holiday and
                                                    weekend)</span></h4>
                                            <a href="<?php echo base_url('direction-ias-upscaspirants');?>" class="btn iasbg">More Details</a>
                                        </div>
                                    </div>
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
                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="success iassuccess">
                            <h4>Our Chief Mentor and <span>Director</span></h4>
                            <div class="caption">
                                <img src="<?php echo base_url();?>direction_v2/images/DIRECTOR.png" alt="DIRECTOR" class="Director">
                                <p>
                                    Mr. C K Ramachandran was born in Calicut and had his early education at the Azhchavattam
                                    Municipal Higher Elementary School,
                                    Zamorin's College High School, Guruvayurappan College and St Joseph's College Devagiri
                                    from where he graduated in Economics.
                                </p>
                                <a href="<?php echo base_url('ias-director');?>" class="btn iasbg">More Details</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="gallery iasgallery">
                            <h4>Event Gallery</h4>
                            <ul class="nav nav-bar">
                                <li><a href="<?php echo base_url('gallery');?>"><img src="<?php echo base_url();?>direction_v2/images/Gallery1.png" alt="Gallery"></a></li>
                                <li><a href="<?php echo base_url('gallery');?>"><img src="<?php echo base_url();?>direction_v2/images/Gallery2.png" alt="Gallery"></a></li>
                                <li><a href="<?php echo base_url('gallery');?>"><img src="<?php echo base_url();?>direction_v2/images/Gallery3.png" alt="Gallery"></a></li>
                                <li><a href="<?php echo base_url('gallery');?>"><img src="<?php echo base_url();?>direction_v2/images/Gallery4.png" alt="Gallery"></a></li>
                                <li><a href="<?php echo base_url('gallery');?>"><img src="<?php echo base_url();?>direction_v2/images/Gallery5.png" alt="Gallery"></a></li>
                                <li class="btnview"><a href="<?php echo base_url('gallery');?>">View More</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="special">
            <div class="container maincontainer">
                <div class="title">
                    <h4 class="text-center">What is special about Direction School for PSC Examinations</h4>
                </div>
                <div class="specialcondent Achievement">
                    <div class="condentimg">
                        <img src="<?php echo base_url();?>direction_v2/images/special-img.png" alt="special" class="rounded-circle img-fluid">
                    </div>
                    <ul class="speciallist leftlist text-right">
                        <li>Analytical and research based approach</li>
                        <li>Highly qualified and experienced faculty</li>
                        <li>Relevant and high quality study materials</li>
                        <li>Personal Mentorship Programme</li>
                        <li>Well furnished class rooms</li>
                    </ul>
                    <ul class="speciallist rightlist text-left">
                        <li>Full fledged library and reading room</li>
                        <li>Direction add on materials</li>
                        <li>Concept building foundation</li>
                        <li>Optional subject mentoring</li>
                        <li>Creative Answer writing techniques</li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </body>
</html>









<section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
    <div class="container">
        <h3>Contact Us</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Contact Us</li>
        </ol>
    </div>
</section>
<section class="inner_page_wrapper">
    <div class="container">
        <div class="form_box">
            <div class="row">
                <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <div class="form_box_wrapper">
                        <h1 class="inner_head">Contact Us</h1>
                        <div class="alert alert-success" id="success_msg" style="display:none;">
                            <strong>Submitted Succesfully!</strong>
                        </div>
                        <div class="alert alert-danger" id="error_msg" style="display:none;">
                            <strong>Network Error! Please try agin later</strong>
                        </div>
                        <form type="post" id="contactus">
                            <div class="pad_clearfix">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="input-group form_input_group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user" style=" font-size: 24px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Name" name="enquiry_name">
                                            <input type="hidden" class="form-control"  name="enquiry_type" value="2">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="input-group form_input_group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mobile-phone"  style="font-size: 35px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Phone" name="enquiry_phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="input-group form_input_group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope" style=" font-size: 20px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="E Mail" name="enquiry_email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <textarea class="form-control textarea_message" placeholder="Message" rows="4" name="enquiry_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <button class="btn btn-info btn-submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form_bg" style="background-color: #00ADD8">
                        <ul>
                            <li><img src="<?php echo base_url();?>assets/images/location-mark.png" class="img-fluid list_img" />Direction Group of Institutions Pvt LTD.<br> IVth Floor,Skytower building <br>Bank road, Mavoor Road Junction<br> CALICUT ,673001 , KERALA , INDIA</li>
                            <li><img src="<?php echo base_url();?>assets/images/call_center.png" class="img-fluid list_img" />0495 4040796 / 0495 4040795 <br>info@direction.org.in</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>