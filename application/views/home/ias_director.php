<!DOCTYPE html>
<html lang="en">
<body>
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Honorary Director</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('direction-ias-study-circle'); ?>">Direction IAS Study circle</a></li>
                <li class="breadcrumb-item active" aria-current="page">Honorary Director</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper howto">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <h4 class="title">Honorary Director</h4>
                    <!-- <img src="<?php echo base_url();?>direction_v2/images/about_img.jpg" class="img-fluid img_about "> -->
                    <p><?php 
                    foreach ($mentor as $mentors){?>
                        <img src="<?php echo base_url();?>uploads/IAS-director/<?php echo $mentors->mentor_image;?>" alt="DIRECTOR" class="Directorimg">
                        <?php echo $mentors->service_content?>
                    <?php }?>
                    </p>


                </div>
            </div>
        </div>
    </section>
</body>

</html>