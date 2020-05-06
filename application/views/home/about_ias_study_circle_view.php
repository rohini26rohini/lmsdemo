<section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>About Us</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> About Us</li>
            </ol>
        </div>
    </section>
    <?php 
        $aboutcontent = '';
        $content_image  = '';
        $content = $this->common->get_content('aboutusias'); 
        if(!empty($content)) {
            $aboutcontent = $content[0]['content_data'];
            $content_image = $content[0]['content_image'];
        }
    ?>
    <section class="inner_page_wrapper">
        <div class="container">
            <h1 class="inner_head">About Our Journey</h1>
             <p class="inner_para">
                    <img src="<?php echo base_url();?>uploads/webcontent/<?php echo $content_image;?>" class="img-fluid img_about" />      
                    <?php echo $aboutcontent;?>
            </p>
        </div>
    </section>