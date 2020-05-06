<div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>How to Prepare</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><?php if($breadcrumb == 1){
                        echo '<a href="'.base_url('direction-ias-study-circle').'"> Direction IAS Study circle </a>'; 
                    }else if($breadcrumb == 2){
                        echo '<a href="'.base_url('direction-school-for-netjrf-examinations').'"> Direction School for NET/JRF Examinations </a>'; 
                    }else if($breadcrumb == 3){
                        echo '<a href="'.base_url('direction-school-for-psc-examinations').'"> Direction School for PSC Examinations </a>'; 
                    }else if($breadcrumb == 4){
                        echo '<a href="'.base_url('direction-school-for-ssc-examinations').'"> Direction School for SSC Examinations </a>'; 
                    }else if($breadcrumb == 5){
                        echo '<a href="'.base_url('direction-school-of-banking').'"> Direction School of Banking </a>'; 
                    }else if($breadcrumb == 6){
                        echo '<a href="'.base_url('direction-junior').'"> Direction Junior </a>'; 
                    }else if($breadcrumb == 7){
                        echo '<a href="'.base_url('direction-school-for-entrance-examinations').'"> Direction school for Entrance Examinations </a>'; 
                    }else if($breadcrumb == 8){
                        echo '<a href="'.base_url('direction-school-for-rrb-examinations').'"> Direction school for RRB examinations </a>'; 
                    }?></li>
                <li class="breadcrumb-item active" aria-current="page">How to Prepare</li>
            </ol>
        </div>
    </div>
    <?php if(!empty($howToPrepare)){?>
    <section class="inner_page_wrapper">
        <div class="container maincontainer tabhowto">
            <div class="row">
                <div class="col-md-3">
                    <form class="search">
                        <div class="input-group form_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"
                                        style=" font-size: 16px;"></i></span>
                            </div>
                            <input type="hidden" id="school" name="school" value="<?php echo $breadcrumb; ?>">
                            <input list="title" name="search" id="search" class="form-control" autocomplete="off" placeholder="Search...">
                            <datalist id="title">
                            <?php
                            foreach($howToPrepare as $howTo){ ?>
                                <option value="<?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$howTo['category_id']));?>">
                                <?php }?>
                            </datalist>
                        </div>
                    </form>
                </div>
            </div><div class="clearfix"></div>
            <div class="row" id="searchContent">
                <div class="col-md-3">
                    <div class="bnkhowprepare" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <ul class="nav flex-column nav-pills">
                            <?php $i=1; foreach($howToPrepare as $howTo){?>
                            <li class=""><a class="nav-link <?php if($i==1){ echo 'active'; }?>" id="v-pills-id-<?php echo $i; ?>" data-toggle="pill" href="#v-pills-<?php echo $i; ?>" role="tab" aria-controls="v-pills-home" aria-selected="true">&nbsp;<?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$howTo['category_id']));?></a></li>
                            <?php $i++; }?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                    <?php $i=1; foreach($howToPrepare as $howTo){ //show($howTo); ?>
                        <div class="tab-pane fade <?php if($i==1){ echo 'show active'; }?>" id="v-pills-<?php echo $i; ?>" role="tabpanel" aria-labelledby="v-pills-id-<?php echo $i; ?>">
                            <h4><?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$howTo['category_id']));?></h4>
                            <p>
                            <?php echo $howTo['content']; ?>
                            </p>
                        </div>
                    <?php $i++; }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php }?>
<script>
$("#search").keyup(function(){
    var search=$("#search").val();
    var school=$("#school").val();
    if(search != ""){
        $(".loader").show();
            $.ajax({
            url: '<?php echo base_url();?>Home/how_to_prepareSearch',
            type: 'POST',
            data: {
                    'search':search,
                    'school':school,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                // alert(response);
                $(".loader").hide();
                $("#searchContent").html(response);
            }
        });
    }
});
</script>