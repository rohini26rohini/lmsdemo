<?php if(check_module_permission('center_wise_fee_report')){ ?>
     <li <?php if($menu_item == "center-wise-fee-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/center-wise-fee-report"><?php echo $this->lang->line('center_wise_fee_report');?></a>
</li>
<?php }?>