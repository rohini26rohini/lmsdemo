 
        <div class="abtbanner BgGrdOrange ">
            <div class="container maincontainer">
                <h3>How to Prepare</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('direction-school-for-ssc-examinations');?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Success St</li>
                </ol>
            </div>
        </div>
       <!-- <section class="inner_page_wrapper howto">
        <div class="container maincontainer">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-4s col-sm-12 col-12 ">
                   
                        <?php 
                        if(!empty($successArr)):
                        $i =1;
                        foreach ($successArr as $success):
                        ?>
                        <p>
                        <img class="img-fluid" alt="Achievement" src="<?php echo base_url();?>uploads/success_stories/<?php echo $success['document']?>">

                        <?php echo $success['name']?><br>
                        <?php echo $success['document']?><br>
                        <?php echo $success['description']?>
                    </p>
                    <?php $i++; endforeach; endif; ?>

                </div>
            </div>
        </div>
    </section>
    </body>
</html> -->
<div class="card card_stories stories-det">
                        <div class="card-body">
                            <div class="card_stories_wrapper">
                                <?php 
                                // echo '<pre>';
                                // print_r($successArr);
                                if(!empty($successArr)):
                                $i =1;
                                foreach ($successArr as $success):
                                ?>
                                <img src="<?php echo base_url();?>uploads/success_stories/<?php echo $success['document']?>" alt="success" class="img-fluid stories-detImg">
                                <h5> <?php echo $success['name']?>
                                    <small><?php echo $success['location']?></small>
                                </h5>
                                <p><?php echo $success['description']?></p>
                                <?php $i++; endforeach; endif; ?>
                            </div>
                            <div class="card_stories_wrapper_youtube">
                                
                            </div>
                        </div>
                    </div>