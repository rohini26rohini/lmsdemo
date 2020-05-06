<?php if(check_module_permission('asset_category')){ ?>
    <li <?php if($menu_item == "Asset-category"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/Asset-category">
            <?php echo $this->lang->line('asset_category'); ?>
        </a>
    </li>
<?php } ?>
<?php if(check_module_permission('asset')){ ?>
    <li <?php if($menu_item == "Asset"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/Asset">
            <?php echo $this->lang->line('assets'); ?>
        </a>
    </li>
<?php } ?>
<?php

    //if($this->session->userdata('role')=='operationhead' || $this->session->userdata('role')=='admin') { // 
        ?>
   <?php if(check_module_permission('supportive_services')){ ?>
    <li <?php if($menu_item == "backoffice/supportive-services"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/supportive-services">
            <?php echo $this->lang->line('supportive_services'); ?>
        </a>
    </li>
<?php } ?>
<?php if(check_module_permission('maintenance_service_type')){ ?>
    <li <?php if($menu_item == "backoffice/maintenance-service-type"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/maintenance-type">
            <?php echo $this->lang->line('maintenance_service_type'); ?>
        </a>
    </li>
<?php } ?>
    <?php
   // }
   // if($this->session->userdata('role')=='centerhead' || $this->session->userdata('role')=='admin'){
    ?>
<?php if(check_module_permission('maintenance_services')){ ?>
    <li <?php if($menu_item == "backoffice/maintenance-services"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/maintenance-services">
            <?php echo $this->lang->line('maintenance_services'); ?>
        </a>
    </li>
    <?php //} ?>
    <?php } ?>

    <?php
    //if($this->session->userdata('role')=='operationhead' || $this->session->userdata('role')=='admin') { // 
    ?>
<?php if(check_module_permission('view_maintenance_services')){ ?>
    <li <?php if($menu_item == "backoffice/view-maintenance-services"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/view-maintenance-services">
            <?php echo $this->lang->line('maintenance_service_requests'); ?>
        </a>
    </li>
<?php } ?>
<?php if(check_module_permission('manage_purchase_quotes')){ ?>
    <li <?php if($menu_item == "backoffice/manage-purchase-quotes"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/manage-purchase-quotes">
            <?php echo $this->lang->line('purchase_quotes'); ?>
        </a>
    </li>
<?php } ?>
<?php// } ?>

