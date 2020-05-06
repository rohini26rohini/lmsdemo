
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>About DIFP</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('direction-junior'); ?>"> Direction Junior </a></li>
                <li class="breadcrumb-item active" aria-current="page">About DIFP</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h4 class="title">About DIFP</h4>
                    <p>
                   <?php foreach ($DIFP as $DIFP){?>
                    <?php echo $DIFP->service_content?>
                    </p>
                   <?php }?>

                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                </div>
            </div>
        </div>
    </section>