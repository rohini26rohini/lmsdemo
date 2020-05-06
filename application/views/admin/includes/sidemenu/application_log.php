<?php if(check_module_permission('application_log')){ ?>
<li <?php if($menu_item == "application-log"){ echo"class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/application-log"><?php echo $this->lang->line('application_log');?></a>
</li>
<?php } ?>