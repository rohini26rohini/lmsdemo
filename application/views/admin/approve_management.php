<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Approve Management</h6>
        <hr>
        <div class="row">
            <?php if(!empty($approveManagement)){ 
                foreach($approveManagement as $entitiy){?>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <a href="<?php echo base_url();?>approve-jobs/<?php echo $entitiy->id;?>">
                        <div class="dash_box custom_box">
                            <h6 class="text-center"><?php echo $entitiy->entity_name; ?></h6>
                        </div>
                    </a>
                </div>
            <?php } } ?>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/approve_management_script");?>
