  <section class="top_strip" style="background-image: url(<?php echo base_url(); ?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>Team</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Team</li>
            </ol>
        </div>
    </section>
    <section class="inner_page_wrapper">
        <div class="container">
            <h1 class="inner_head">Expert in Education</h1>   <div class="pad_clearfix">
            <div class="row">
         
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="inner_para">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum hasIt has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets</p>

                </div>
                </div>
            </div><div class="pad_clearfix">
            <div class="row">
                <?php 
                $director = $this->common->get_director('Director');
                if(!empty($director)) {
                    foreach($director as $row) {
                ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="card card_team">
                        <img class="card-img-top" src="<?php echo base_url(); ?>uploads/ourteam/<?php echo $row['image'];?>" alt="Card image cap">
                        <div class="card-body">

                            <h5><?php echo $row['name'];?>
                                <small><i><?php echo $row['position'];?></i></small>
                            </h5>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            </div>
            <div class="pad_clearfix">
            <div class="row">
                <?php 
                $director = $this->common->get_othermembers('Director');
                if(!empty($director)) {
                    foreach($director as $row) {
                ?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="card card_team">
                        <img class="card-img-top" src="<?php echo base_url(); ?>uploads/ourteam/<?php echo $row['image'];?>" alt="Card image cap">
                        <div class="card-body">

                            <h5><?php echo $row['name'];?>
                                <small><i><?php echo $row['position'];?></i></small>
                            </h5>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            </div>
        </div>
    </section>