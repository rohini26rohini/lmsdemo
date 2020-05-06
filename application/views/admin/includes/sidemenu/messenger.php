<?php if(check_module_permission('messenger')){
    if($menu_item == "backoffice/messenger"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/messenger"><?php echo $this->lang->line('messenger');?></a>
        </li>
<?php } ?>