<?php if(check_module_permission('batch_schedule_report')){ ?>
<li <?php if($menu_item == "batch-schedule-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/batch-schedule-report"><?php echo $this->lang->line('batch_schedule_report');?></a>
</li>
<?php } ?>
<?php if(check_module_permission('exam_schedule_report')){ ?>
<li <?php if($menu_item == "exam-schedule-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/exam-schedule-report"><?php echo $this->lang->line('exam_schedule_report');?></a>
</li>
<?php } ?>