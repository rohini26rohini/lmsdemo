<!-- <section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>Tutorials </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tutorials 
                </li>
            </ol>
        </div>
    </section> -->
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Tutorials</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tutorials</li>
            </ol>
        </div>
    </div>
    <?php 
        $aboutcontent = '';
        $content = $this->common->get_content('whydirection'); 
        if(!empty($content)) {
            $aboutcontent = $content[0]['content_data'];
        }
    ?>
    <section class="inner_page_wrapper">
        <div class="container">
            <div class="row">
                <?php  
                if(!empty($tutorials)) {
                    if(!empty($material)) {
                    $material = $material[0];     
                    } else {
                    $material = $tutorials[0]; 
                    }
                ?>
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-12">
                    <div class="grow_wrap">
                        <h1 class="grow_header"><?php echo $material['material_name'];?>
                        </h1>
                        <ul class="grow_list">
                            <li><i class="fa fa-file-pdf-o"></i> <?php echo $material['subject_name'];?>
                            </li>
                            <li><i class="fa fa-calendar"></i><?php echo date('jS F Y', strtotime($material['material_createdate']));?>
                            </li>
                            

                        </ul>
                        <!-- <object data="<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>" type="application/pdf" width="100%" height="800px">
                            <p>Alternative text - include a link <a href="<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>">to the PDF!</a></p>
                        </object> -->
                        <!-- <iframe src="http://docs.google.com/gview?url=<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>&embedded=true" style="width:100%; height:1000px;" frameborder="0"></iframe> -->
                        <embed src="<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="800px">
                    </div>
                    
                </div>
                <?php } ?>
                <?php 
                if(!empty($tutorials)) {
                ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                   <div class="grow_career_list">
                        <h4>Tutorials</h4>
                        <ul>
                            <?php 
                            foreach($tutorials as $row) {
                            ?>
                            <a href="<?php echo base_url().$this->uri->segment('1');?>/tutorial-<?php echo $row['mastersubject_id'];?>/module-<?php echo $row['material_id'];?>">
                                <li><i class="fa fa-angle-double-right"></i><?php echo $row['material_name'];?></li>
                            </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>