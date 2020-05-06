<?php if(check_module_permission('student_notification')){ ?>
<li <?php if($menu_item == "student-notification"){ echo "class='active'"; }?>>
        <a href="<?php echo base_url();?>backoffice/student-notification">
            <?php echo $this->lang->line('students');?></a>
</li>
<?php } ?>
<?php if(check_module_permission('staff_notification')){ ?>
<li <?php if($menu_item == "staff-notification"){ echo "class='active'"; }?>>
        <a href="<?php echo base_url();?>backoffice/staff-notification">
            <?php echo $this->lang->line('staff');?></a>
</li>
<?php } ?>