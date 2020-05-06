 <?php if(check_module_permission('manage_schedule')){ ?>
            <?php if($menu_item == "index"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/scheduler'); ?>">View all schedules</a>
            </li>
<?php } 
if(check_module_permission('manage_class_schedule')){
?>
            <?php if($menu_item == "class_schedule"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/class-schedule'); ?>">Automated Class Schedule</a>
            </li>
<?php } 
if(check_module_permission('manual_class_schedule')){
?>
            <?php if($menu_item == "manual_class_schedule"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/manual-class-schedule'); ?>">Manual Class Schedule</a>
            </li>
<?php } ?>