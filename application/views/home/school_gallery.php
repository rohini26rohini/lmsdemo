<div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Gallery</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php if($breadcrumb == 1){
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
                    }?>
                </li>
                <li class="breadcrumb-item active" aria-current="page">gallery</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper gallery">
        <div class="container maincontainer">
            <div class="row">
            <?php 
                    if(!empty($images)){ 
                        foreach($images as $row){
                ?>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                    <a href="<?php echo base_url('gallery-view/'.$row->gallery_key); ?>">
                        <div class="card">
                            <div class="card-img-top" style="background-image: url(<?php echo base_url().'/uploads/gallery/'.$row->gallery_image; ?>)"></div>

                            <div class="card-body">
                                <h4><?php echo $row->gallery_name; ?></h4>
                                <p class="card-text">Photos(<?php echo $row->total; ?>)</p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php }} ?>
            </div>
        </div>
    </section> 