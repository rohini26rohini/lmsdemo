
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Gallery</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">gallery</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper gallery">
        <div class="container maincontainer">
            <div class="row">
            <?php 
                    if(!empty($galleries)){ 
                        foreach($galleries as $row){
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