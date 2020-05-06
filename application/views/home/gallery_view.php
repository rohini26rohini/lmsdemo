 
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Gallery</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> <a href="<?php echo base_url('gallery');?>">gallery</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $key; ?></li>
            </ol>
        </div>
    </div>

    <div class="inner_page_wrapper gallery-view">
        <div class="container maincontainer">
            <div id="links" class="links">
                <div class="masonry-layout">
                <?php 
                        if(!empty($images)){ 
                            foreach($images as $image){
                    ?>
                    <div class="masonry-layout__panel">
                        <div class="masonry-layout__panel-content">
                            <a href="<?php echo base_url();?>/uploads/gallery/<?php echo $image->gallery_image; ?>" data-gallery>
                                <img src="<?php echo base_url();?>/uploads/gallery/<?php echo $image->gallery_image; ?>" alt="gallery" class="img-fluid ">
                            </a>
                        </div>
                    </div>
                    <?php }} ?> 
                </div>
            </div>
            <div id="blueimp-gallery" class="blueimp-gallery">
                <div class="slides"></div>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close"><span>×</span></a>
                <a class="play-pause" style=" background-image: url('<?php echo base_url();?>direction_v2/images/play-pause.png');"></a>
                <ol class="indicator"></ol>
            </div>


        </div>
        <div class="clearfix"></div>
    </div>