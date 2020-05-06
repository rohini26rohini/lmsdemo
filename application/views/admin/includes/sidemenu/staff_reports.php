<?php if(check_module_permission('staff_attendance_report')){ ?>
<li <?php if($menu_item == "staff_attendance_report"){ echo"class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/staff-attendance-report"><?php echo $this->lang->line('staff_attendance_report');?></a>
</li>
<?php } ?>
<?php //if(check_module_permission('schedule_report')){ ?>
<!-- <li <?php if($menu_item == "batch-schedule-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/batch-schedule-report"><?php echo $this->lang->line('batch_schedule_report');?></a>
</li> -->
<?php //} ?>
<?php if(check_module_permission('facualty_allocated_report')){ ?>
<li <?php if($menu_item == "facualty-allocated-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/facualty-allocated-report"><?php echo $this->lang->line('facualty_allocated_report');?></a>
</li>
<?php } ?>
<?php if(check_module_permission('staff_leave_report')){ ?>
<li <?php if($menu_item == "staff-leave-report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/staff-leave-report"><?php echo $this->lang->line('staff_leave_report');?></a>
</li>
<?php } ?>
