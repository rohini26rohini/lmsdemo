<div class="abtbanner BgGrdOrange ">
    <div class="container maincontainer">
        <h3>About Us</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Us</li>
        </ol>
    </div>
</div>
<section class="inner_page_wrapper">
    <div class="container maincontainer">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <?php foreach ($about as $abouts){?>
                <p>
                    <?php echo $abouts->service_content;?>
                </p>
            <?php }?>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                        <div class="abtboxlist">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

