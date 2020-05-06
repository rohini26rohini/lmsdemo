
<div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Success Stories</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
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
                    }?></li>
                    <?php  if($breadcrumb != 0){?>
                <li class="breadcrumb-item active" aria-current="page">Success Stories</li>
                    <?php  }?>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper">
        <div class="container maincontainer">
            <div class="row">
            <?php
            if(!empty($successArr)){
                $i =1;
                // echo '<pre>'; print_r($successArr); 
                // exit;
                foreach ($successArr as $success):
                ?> <?php if($success['document_type'] == 1){?>
                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="card card_stories">
                            <div class="card-body">
                                <div class="card_stories_wrapper">
                                    <img src="<?php echo base_url();?>assets/images/success.png" class="img-fluid" />
                                    <?php if(strlen($success['description']) > 241 ){?>
                                    <p><?php $str1=$success['description'];  $str = substr($str1, 0, 240); echo $str;?><span id="dots_<?php echo $success['success_id']; ?>">...</span></p>
                                    <b><i><a href="<?php echo base_url(); if($breadcrumb == 0){ ?>success-story/<?php } else { echo 'single-school-story/'; }echo $success['success_id'];?>" style="cursor:pointer">Read more</a></i></b>
                                    <?php }else{?>
                                        <p><?php echo $success['description'];?> </p>
                                     <?php }?>
                                    <?php 
                                    if($success['document']!='') {
                                        ?>
                                    <img src="<?php echo base_url();?>uploads/success_stories/<?php echo $success['document']?>" alt="success" class="img-fluid rounded-circle sstoriesImg">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url();?>assets/images/avathar.png" alt="success" class="img-fluid rounded-circle sstoriesImg">   
                                    <?php } ?>
                                </div>
                                <div class="card_stories_wrapper_youtube">
    
    
                                    <h5><?php echo $success['name'];?>
                                        <small><?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$success['school_id']));?></small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }else if($success['document_type'] == 2){?>
                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="card card_stories">
                            <div class="card-body">
                                <iframe src="<?php echo $success['description'];?>"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen=""></iframe>
                                <div class="card_stories_wrapper_youtube">
                                <h5><?php echo $success['name'];?>
                                        <small><?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$success['school_id']));?></small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <?php $i++; endforeach; 
            }else{?>
            <p style="text-align:center;">No success stories available</p>
            <?php }?>
            </div>
        </div>
    </section>
