<section class="top_strip" style="background-image: url('<?php echo base_url() ?>assets/images/banner_bg.png');">
    <div class="container">
        <h3>Achievers Meet</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Achievers Meet </li>
        </ol>
    </div>
</section>
<section class="inner_page_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-12">
                <div id="links" class="links">
                    <div class="masonry-layout">
                        <?php
                        $i =1;
                        if(!empty($galleryArr)){ 
                        foreach ($galleryArr as $gallery){
                        ?>
                        <div class="masonry-layout__panel">
                            <div class="masonry-layout__panel-content">
                                <a href="<?php echo base_url();?>uploads/achievers_gallery/<?php echo $gallery['image']?>" data-gallery>
                                    <img src="<?php echo base_url();?>uploads/achievers_gallery/<?php echo $gallery['image']?>" class="img-fluid ">
                                </a>
                            </div>
                        </div>
                        <?php $i++; }}else{?>
                        <?php echo 'Sorry no such gallery exists'; }?>
                    </div>
                </div>
                <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                <div id="blueimp-gallery" class="blueimp-gallery">
                    <div class="slides"></div>
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close"><span>×</span></a>
                    <a class="play-pause" style=" background-image: url(<?php echo base_url('assets/images/play-pause.png'); ?>);"></a>
                    <ol class="indicator"></ol>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="grow_career_list">
                    <h4>Album</h4>
                    <ul>
                        <?php
                        $i =1;
                        if(!empty($yearArr)){ 
                        foreach ($yearArr as $year){
                        ?>
                        <a href="<?php echo base_url('achievers-meet-psc/'.$year->year);?>">
                            <li><i class="fa fa-angle-double-right"></i><?php echo $year->year; ?></li>
                        </a>
                        <?php $i++; }}?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

   