<?php $this->load->view('admin/includes/header.php'); ?>
<?php $this->load->view('admin/includes/inner_header.php'); ?>
    <div class="base">
       <?php $this->load->view('admin/includes/breadcrumbs.php'); ?>
            <div class="container-fluid">
                <div class="row">
                    <?php if($menu != "report"){?>
                    <div class="sub_nav_wrapper relative col-lg-2 col-md-4 col-sm-4 col-xs-12">
                        <div class="card_wrapper">
                            <ul class="sub_navigation ">
                                <?php $this->load->view('admin/includes/sidemenu/'.$menu); ?>

                                <!-- <?php if($menu != "settings"){ ?>
                                <li class="sub_drop drop_a <?php if($menu_item == "backoffice/Change-Password"){ ?> active <?php } ?>" id="drop_a">
                                    <a href="<?php echo base_url();?>backoffice/change-password">
                                        <?php echo $this->lang->line('settings'); ?>
                                    </a>
                                </li>
                                <?php } ?> -->
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <?php $this->load->view($page); ?>
            </div>
        </div>
    </div>
<?php $this->load->view('admin/includes/footer.php'); ?>
