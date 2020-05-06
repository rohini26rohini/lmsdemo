<?php if(check_module_permission('student_report')){ ?>
<li <?php if($menu_item == "backoffice/student-report"){ echo"class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/student-report"><?php echo $this->lang->line('student_report');?></a>
</li>
<?php } ?>
<?php if(check_module_permission('student_attendance_report')){ ?>
<li <?php if($menu_item == "student-attendance-report"){ echo"class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/student-attendance-report"><?php echo $this->lang->line('student_attendance_report');?></a>
</li>
<?php } ?>