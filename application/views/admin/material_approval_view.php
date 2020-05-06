<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('material_approval');?></h6>
        <hr>
        <div class="row">
        <?php if(!empty($entitiyArr)){ 
            foreach($entitiyArr as $entitiy){
                if($entitiy->id != 1){ ?>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
            <?php if($entitiy->id == 1) { $url= 'backoffice/question-set-approval-levels';} 
            else if($entitiy->id == 2) { $url= 'backoffice/learning-module-approval-levels';} 
            else if($entitiy->id == 3) { $url= 'backoffice/exam-paper-approval-levels';} ?>
                <a href="<?php echo base_url($url);?>">
                    <div class="dash_box custom_box">
                        <h6 class="text-center"><?php echo $entitiy->entity_name; ?></h6>
                    </div>
                </a>
            </div>
        <?php } } }?>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/maintenance_approval_script");?>
