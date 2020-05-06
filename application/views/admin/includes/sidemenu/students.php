 <?php if(check_module_permission('manage_students')){ ?>

             <li <?php if($menu_item == "backoffice/manage-students" || $menu_item == "backoffice/view-student"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/student-list">Manage Students</a>
            </li>
<?php } 
if(check_module_permission('manage_progress_report')){?>
             <li <?php if($menu_item == "backoffice/progress-reportlist"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/progress-reportlist"><?php echo $this->lang->line('progress_report');?></a>
            </li> 
<?php } 
if(check_module_permission('manage_hallticket')){?>
            <li <?php if($menu_item == "backoffice/hallticket"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/hallticket"><?php echo $this->lang->line('hallticket');?></a>
            </li>
<?php } 
if(check_module_permission('manage_mentor')){?>
            <li <?php if($menu_item == "mentor"){ echo "class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/mentor"><?php echo $this->lang->line('mentor');?></a>
            </li>
<?php } 
if(check_module_permission('users-password-reset')){ ?>
             
             <li <?php if($menu_item == "Users-password-reset"){ ?> class="active" <?php } ?> >
         
             <a href="<?php echo base_url();?>backoffice/users-password-reset"><?php echo $this->lang->line('users_password_reset');?></a>

         </li>
<?php }?>

<?php 
     if(check_module_permission('external_batch') || check_module_permission('external_candidates')){
     if(in_array($menu_item,['external_batch','external_candidates'])){$li_active = 'active';}else{$li_active = '';}
?>
     <li class="sub_drop drop_a <?php echo $li_active;?>" id="drop_a">
          <a><?php echo $this->lang->line('manage_external_students');?></a>
          <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
               <?php if(check_module_permission('external_batch')) { ?>
                    <li <?php if($menu_item == "external_batch"){ echo 'class="active"'; } ?> >
                         <a href="<?php echo base_url();?>backoffice/manage-external-batch"><?php echo $this->lang->line('external_batch');?></a>
                    </li>
               <?php } ?>
               <?php if(check_module_permission('external_candidates')) { ?>
                    <li <?php if($menu_item == "external_candidates"){ echo 'class="active"'; } ?> >
                         <a href="<?php echo base_url();?>backoffice/manage-external-candidates"><?php echo $this->lang->line('external_candidates');?></a>
                    </li>
               <?php } ?>
          </ul>
     </li>
<?php } ?>
