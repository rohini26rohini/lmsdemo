<section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>Grow with Us</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('work-with-us'); ?>">Careers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Grow with Us
                </li>
            </ol>
        </div>
    </section>
    <section class="inner_page_wrapper">
        <div class="container">
            <?php 
                $content = '';
                $content_image  = '';
                $data = $this->common->get_content('growwithus'); 
                if(!empty($data)) {
                    $content = $data[0]['content_data'];
                    $content_image = $data[0]['content_image'];
                }
            ?>
            <h1 class="grow_header">Direction IAS Study Circle</h1>
            <p class="inner_para">
                <?php if(!empty($content_image)){ ?>
                        <img src="<?php echo base_url();?>uploads/webcontent/<?php echo $content_image;?>" class="img-fluid img_about" />      
                <?php }?>
                <?php 
                    echo $content;
                ?>
            </p>
        </div>
    </section>