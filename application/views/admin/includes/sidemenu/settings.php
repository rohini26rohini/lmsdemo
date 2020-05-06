<li <?php if($menu_item == "backoffice/change-password"){ ?> class="active" <?php } ?>>
    <a href="<?php echo base_url();?>backoffice/change-password">
        <?php echo $this->lang->line('change_password'); ?>
    </a>
</li>
<li <?php if($menu_item == "backoffice/manage-leave"){ ?> class="active" <?php } ?>>
    <a href="<?php echo base_url();?>backoffice/manage-leave">
        <?php echo $this->lang->line('manage_leave'); ?>
    </a>
</li>

