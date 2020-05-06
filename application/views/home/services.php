
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Services</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Services</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <?php
                        $i =1;
                        foreach ($serviceArr as $service):
                    ?>
                    <h4 class="title"><?php echo $service['title']?></h4>
                    
                    <p>
                    <?php echo $service['service_content']?>  
                    </p>
                    <?php $i++; endforeach; ?>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                </div>
            </div>
        </div>
    </section>