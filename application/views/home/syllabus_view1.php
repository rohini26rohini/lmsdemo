<section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>Syllabus </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Syllabus 
                </li>
            </ol>
        </div>
    </section>
    <section class="inner_page_wrapper">
        <div class="container">
            <div class="row">
                <?php  
                if(!empty($syllabus)) { 
                    
                ?>
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-12">
                    <div class="grow_wrap">
                        <h1 class="grow_header"><?php echo $syllabus['syllabus_name'];?>
                        </h1>
<!--
    <ul class="grow_list">
        <li><i class="fa fa-file-pdf-o"></i> <?php echo $syllabus['subject_name'];?>
        </li>
        <li><i class="fa fa-calendar"></i><?php echo date('jS F Y', strtotime($syllabus['material_createdate']));?>
        </li>


    </ul>
-->
                        <!-- <object data="<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>" type="application/pdf" width="100%" height="800px">
                            <p>Alternative text - include a link <a href="<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>">to the PDF!</a></p>
                        </object> -->
                        <!-- <iframe src="http://docs.google.com/gview?url=<?php echo base_url();?>materials/elearning/<?php echo $material['material_link'];?>&embedded=true" style="width:100%; height:1000px;" frameborder="0"></iframe> -->
                        <embed src="<?php echo base_url();?>materials/syllabus/<?php echo $syllabus['file_name'];?>#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="800px">
                    </div>
                    
                </div>
                <?php } ?>
                <?php 
                if(!empty($syllabuslist)) {
                ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                   <div class="grow_career_list">
                        <h4>Syllabus</h4>
                        <ul>
                            <?php 
                            foreach($syllabuslist as $row) {
                            ?>
                            <a href="<?php echo base_url().$this->uri->segment('1');?>/syllabus-<?php echo $row->syllabus_id;?>">
                                <li><i class="fa fa-angle-double-right"></i><?php echo $row->syllabus_name;?></li>
                            </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>