<?php if(check_module_permission('exam_avgmark_report')){ ?>
<li <?php if($menu_item == "exam-avgmark-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/exam-avgmark-report"><?php echo $this->lang->line('exam_avgmark_report');?></a>
</li>
<?php }?>