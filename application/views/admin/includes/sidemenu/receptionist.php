
            <li <?php if($menu_item == "backoffice/profile"){ echo"class='active'"; }?>>
                 <a href="<?php echo base_url();?>backoffice/profile">Profile</a>
            </li>
            <li <?php if($menu_item == "backoffice/maintenance-services"){ ?> class="active" <?php } ?>>
                    <a href="<?php echo base_url();?>backoffice/maintenance-services">
                        <?php echo $this->lang->line('maintenance_services'); ?>
                    </a>
               </li>
            
