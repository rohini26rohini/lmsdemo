 <?php if(check_module_permission('callcentre_dashboard')){ ?>
            <?php 
            if($this->session->userdata('role')=='cch' || $this->session->userdata('role')=='cce') {
            ?>
            <li <?php if($menu_item == "backoffice/cc-dashboard"){ echo "class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/cc-dashboard">Dashboard</a>
            </li>
    <?php }
    }
   if(check_module_permission('callcentre_profile')){?>
            <?php 
            if($this->session->userdata('role')=='cch' || $this->session->userdata('role')=='cce') {
            ?>
            <li <?php if($menu_item == "backoffice/profile"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>employee">Profile</a>
            </li> 
            <?php } ?>
<?php } 
if(check_module_permission('manage_calls')){
?>
            <?php if($menu_item == "backoffice/manage-calls"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/manage-calls">Manage Calls</a>
            </li>
            <?php if($menu_item == "backoffice/remainder-calls"){ ?>
                <li class="active remainder_nav">
            <?php } else { ?>
                <li class="remainder_nav">
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/remainder-calls">Reminder Calls
                <?php if(isset($cntremaindercalls) && $cntremaindercalls>0) { ?>
                <img src="<?php echo base_url();?>inner_assets/images/notifications.png" alt="notifications">
                <?php } ?>
                </a>
            </li>
<?php }
if(check_module_permission('call_summary')){?>
            <li <?php if($menu_item == "backoffice/call-summary"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/call-summary">Call Summary</a>
            </li>
<?php }
if(check_module_permission('fee_structure')){ ?>
            <li <?php if($menu_item == "backoffice/fee-structure"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/fee-structure">Fees Structure</a>
            </li> 
<?php }
if(check_module_permission('remainder_sms')){ ?>
     <li <?php if($menu_item == "backoffice/remainder-sms"){ echo"class='active'"; }?>>
          <a href="<?php echo base_url();?>backoffice/remainder-sms">Reminder SMS</a>
     </li> 
<?php }
if(check_module_permission('bulk_sms')){ ?>
     <li <?php if($menu_item == "backoffice/bulk_sms"){ echo"class='active'"; }?>>
          <a href="<?php echo base_url();?>backoffice/bulk-sms">Bulk SMS</a>
     </li> 
<?php }
/*if(check_module_permission('manage_queries')){?>
             <li <?php if($menu_item == "backoffice/manage-queries"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/manage-queries">Manage Queries</a>
            </li> 
<?php }*/
if(check_module_permission('manage_callbacks')){?>
            <li <?php if($menu_item == "backoffice/manage-callbacks"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/manage-callbacks">Manage Call Backs</a>
            </li>
<?php }?>


<?php 
if($this->session->userdata('role')=='cch' || $this->session->userdata('role')=='cce') {
?>
<!-- <li <?php if($menu_item == "backoffice/manage-leave"){ ?> class="active" <?php } ?>>
<a href="<?php echo base_url();?>backoffice/manage-leave">
     <?php echo $this->lang->line('manage_leave'); ?>
</a>
</li> -->
<?php } ?>
<li <?php if($menu_item == "backoffice/change-password"){ ?> class="active" <?php } ?>>
<a href="<?php echo base_url();?>backoffice/change-password">
     <?php echo $this->lang->line('change_password'); ?>
</a>
</li>


