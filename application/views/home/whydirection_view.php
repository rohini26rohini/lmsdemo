<section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>Why Direction ?</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Why Direction</li>
            </ol>
        </div>
    </section>
    <?php 
        $aboutcontent = '';
        $content = $this->common->get_content('whydirection'); 
        if(!empty($content)) {
            $aboutcontent = $content[0]['content_data'];
        }
    ?>
    <section class="inner_page_wrapper">
        <div class="container">
            <h1 class="inner_head">Why Direction ?</h1>
             <p class="inner_para">      
                    <?php echo $aboutcontent;?>
            </p>
                
                    
<!--
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top: 15px;">
                    <p class="inner_para">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    <p class="inner_para">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </p>
                </div>
-->

        </div>

    </section>