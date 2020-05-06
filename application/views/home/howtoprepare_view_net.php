
        <div class="abtbanner BgGrdOrange ">
            <div class="container maincontainer">
                <h3>How to Prepare</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('direction-school-for-netjrf-examinations');?>">Direction School for NET/JRF Examinations </a></li>
                    <li class="breadcrumb-item active" aria-current="page">How to Prepare</li>
                </ol>
            </div>
        </div>
        <section class="inner_page_wrapper pschowto howto">
            <div class="container maincontainer">
                <div class="row">
                <div class="col-md-12">
                    <ul class="howbody">
                        <li>
                        <?php 
                        $i =1;
                        foreach ($prepareArr as $prepare):?>
                            <h5><?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$prepare['category_id']));?></h5>
                            <p><?php $content =$prepare['content'];
                            $dat = strip_tags($content);
                            $str = preg_replace("/\&nbsp;/",'',$dat);
                            echo substr($str, 0, 50).'...'; ?> <button type="button"
                                    class="txt-toggle" data-toggle="modal" data-target="#exampleModalCenter<?php echo $i; ?>">
                                    More Details
                                </button></p>


                            <div class="modal fade How-modal" id="exampleModalCenter<?php echo $i; ?>" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $this->common->get_name_by_id('web_category','category',array('id'=>$prepare['category_id']));?></h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <?php echo $prepare['content']?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; endforeach; ?>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
        </section>
    </body>
</html>