
<body>
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Success Story</h3>
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
                    }?>
                </li>
                <?php if($breadcrumb == 2){
                        echo '<li class="breadcrumb-item" aria-current="page"><a href="'.base_url().'school-stories/2"> Success Stories </a></li>';
                    }else if($breadcrumb == 3){
                        echo '<li class="breadcrumb-item" aria-current="page"><a href="'.base_url().'school-stories/3"> Success Stories </a></li>';
                    }else if($breadcrumb == 4){
                        echo '<li class="breadcrumb-item" aria-current="page"><a href="'.base_url().'school-stories/4"> Success Stories </a></li>';
                    }else if($breadcrumb == 5){
                        echo '<li class="breadcrumb-item" aria-current="page"><a href="'.base_url().'school-stories/5"> Success Stories </a></li>';
                    }else if($breadcrumb == 7){
                        echo '<li class="breadcrumb-item" aria-current="page"><a href="'.base_url().'school-stories/7"> Success Stories </a></li>';
                    }else if($breadcrumb == 8){
                        echo '<li class="breadcrumb-item" aria-current="page"><a href="'.base_url().'school-stories/8"> Success Stories </a></li>';
                    }else if($breadcrumb == 0){
                        echo ''; 
                    }?>
                </li>
            <?php foreach ($story as $data){?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $data->name; ?></li>
            <?php }?>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper howto">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">


                <div class="media successdetail">
    <div class="media-left">
    <?php 
    if($data->document!='') { ?>
      <img src="<?php echo base_url();?>uploads/success_stories/<?php echo $data->document;?>" class="media-object " style="width:60px">
    <?php } else { ?>
        <img src="<?php echo base_url();?>assets/images/avathar.png" class="media-object " style="width:60px">
    <?php } ?>
    </div>
    <div class="media-body">
      <p><?php echo $data->description?></p>
      <h5><?php echo $data->name."<span><i class='fas fa-map-marker-alt'></i>"; echo "&nbsp;".$data->location; ?></span>
                                    <small><i class="fas fa-graduation-cap"></i><?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$data->school_id));?></small>
                                </h5>
    </div>
  </div>
  




                </div>
            </div>
        </div>


    </section>
</body>

</html>