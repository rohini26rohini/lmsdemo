    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Previous Question Papers</h3>
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
                <li class="breadcrumb-item active" aria-current="page">Previous Question Papers</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper">
        <div class="container maincontainer">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <form class="search">
                        <div class="input-group form_input_group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"
                                        style=" font-size: 16px;"></i></span>
                            </div>
                            <input type="hidden" id="segment" name="segment" value="<?php echo $this->uri->segment(1); ?>">
                            <input type="hidden" id="school" name="school" value="<?php echo $breadcrumb; ?>">
                            <input list="title" name="search" id="search" class="form-control" autocomplete="off" placeholder="Search...">
                            <datalist id="title">
                            <?php
                            foreach($tutorials as $tutorial){ ?>
                                <option value="<?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$tutorial->category_id));?>">
                                <?php }?>
                            </datalist>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" id="searchContent">
                   <div class="  Topicswrapper ">
                        <ul class="TopicList">
                            <?php 
                            if(!empty($tutorials)) {
                                foreach($tutorials as $tutorial) {
                            ?>
                            <li class="<?php if($tutorial->category_key == $this->uri->segment(2)){ echo 'active-2'; }?>"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$tutorial->category_key;?>"><?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$tutorial->category_id));?></a></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                    <?php 
                    if(!empty($material)) {
                    ?>
                    <div class="grow_wrap TopicListDet" >
                    <?php 
                    $file = './uploads/webcontent/generalstudies/'.$material->topic_attachment;
                    if($material->topic_attachment != '') {
                    if(file_exists($file)) {
                        $ext = pathinfo($material->topic_attachment, PATHINFO_EXTENSION);
                        if($ext != 'pdf'){
                            $url = 'https://view.officeapps.live.com/op/embed.aspx?'.http_build_query(array('src'=>base_url('uploads/webcontent/generalstudies/'.$material->topic_attachment)));
                            $iframe = '<iframe src="'.$url.'" frameborder="0" width="100%" height="800px"></iframe>';  
                        }?>
                        <div id="iframe"></div>
                    <?php }else{?>
                        <strong>File doesn't exist</strong>
                    <?php } }else{ ?>
                        <strong>File doesn't exist</strong>
                   <?php }?>
                    </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php if(isset($iframe)){ ?>
        <script>
            $(document).ready(function(){
                $("#iframe").html('<?php echo $iframe;?>');
            });
        </script>
    <?php } ?>
    <script>
$("#search").keyup(function(){
    var search=$("#search").val();
    var school=$("#school").val();
    var segment =$("#segment").val();
    if(search != ""){
        $(".loader").show();
            $.ajax({
            url: '<?php echo base_url();?>Home/previous_question_viewSearch',
            type: 'POST',
            data: {
                    'search':search,
                    'school':school,
                    'segment':segment,
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