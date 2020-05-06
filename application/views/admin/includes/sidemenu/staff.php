 <?php if(check_module_permission('manage_staff')){ ?>
            <?php if($menu_item == "backoffice/manage-staff"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/staff-list">Manage Staff</a>
            </li>
<?php }
if(check_module_permission('manage_faculty_availablity')){ ?>
            <?php if($menu_item == "backoffice/manage-faculty-availablity"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/manage-faculty-availablity">Manage Faculty</a>
            </li>
<?php } ?>
<?php
if(check_module_permission('manage-faculty-attendance')){ ?>
            <?php if($menu_item == "manage-faculty-attendance"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/manage-faculty-attendance"><?php echo $this->lang->line('manage_faculty_attendance'); ?></a>
                    
            </li>
<?php } ?>