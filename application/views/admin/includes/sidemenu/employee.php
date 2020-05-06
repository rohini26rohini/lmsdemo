<?php //if(check_module_permission('profile')){ ?>    
<li <?php if($menu_item == "profile"){ echo"class='active'"; }?>>
        <a href="<?php echo base_url();?>employee">Profile</a>
</li>
<?php //} ?>
<?php if(check_module_permission('daily_schedule')){ ?>
<li <?php if($menu_item == "daily_schedule"){ echo "class='active'"; }?>>
        <a href="<?php echo base_url();?>daily-schedule"><?php echo $this->lang->line('daily_schedule');?></a>
</li>
<?php } ?>
<?php if($this->session->userdata('role') == 'faculty') { ?>
<?php if(check_module_permission('calendar')){ ?>        
<li <?php if($menu_item == "schedules"){ echo"class='active'"; }?>>
        <a href="<?php echo base_url();?>view-schedules"><?php echo $this->lang->line('my_schedule');?></a>
</li>
<?php } ?>
<?php } else { ?>
<?php if(check_module_permission('calendar')){ ?>        
<li <?php if($menu_item == "schedules"){ echo"class='active'"; }?>>
        <a href="<?php echo base_url();?>view-schedules"><?php echo $this->lang->line('schedule');?></a>
</li>
<?php } ?>
<?php } ?>
<?php //if(check_module_permission('view-attendance')){ ?>  
<li <?php if($menu_item == "view-attendance"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/view-attendance"><?php echo $this->lang->line('my_attendance');?></a>
</li>
<?php //} ?>

<?php if($this->session->userdata('role') == 'faculty') { ?>
<li <?php if($menu_item == "backoffice/my-exams"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/my-exam"><?php echo $this->lang->line('my_exams');?></a>
</li>
<li <?php if($menu_item == "backoffice/progress_report"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>backoffice/progress-report"><?php echo $this->lang->line('progress_report');?></a>
</li>
<li <?php if($menu_item == "study-materials"){ echo "class='active'"; }?>>
     <a href="<?php echo base_url();?>study-materials"><?php echo $this->lang->line('learning_module');?></a>
</li>
<?php } ?>
<?php $user_id = $this->session->userdata('user_primary_id');
$approvel = $this->common->get_from_tableresult('approval_flow_entity_details', array('status'=>1,'user_id'=>$user_id));
// show($approvel);
?>
<?php if(!empty($approvel)) { ?>
        <li <?php if($menu_item == "approve-management"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>approve-management">
                Approve Management
        </a>
        </li>
<?php }?>
<li <?php if($menu_item == "backoffice/manage-leave"){ ?> class="active" <?php } ?>>
    <a href="<?php echo base_url();?>backoffice/manage-leave">
        <?php echo $this->lang->line('manage_leave'); ?>
    </a>
</li>

<li <?php if($menu_item == "backoffice/change-password"){ ?> class="active" <?php } ?>>
    <a href="<?php echo base_url();?>backoffice/change-password">
        <?php echo $this->lang->line('change_password'); ?>
    </a>
</li>
<?php if($this->session->userdata('role')=='management') { ?>
        <li <?php if($menu_item == "backoffice/reference-list"){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url();?>backoffice/reference-list">
                References
        </a>
        </li>
<?php }?>
<?php if($this->session->userdata('role')=='faculty') { ?>
<!--
<li <?php if($menu_item == "home-work"){ ?> class="active" <?php } ?>>
    <a href="<?php echo base_url();?>backoffice/homework">
        <?php echo $this->lang->line('homeworks');?>
    </a>
</li>

<li <?php if($menu_item == "mentor-view"){ ?> class="active" <?php } ?>>
    <a href="<?php echo base_url();?>backoffice/mentor-view">
        Mentors Meeting
    </a>
</li>
-->
<?php } ?>