
       <li  <?php if($menu_item == "users"){ ?> class="active"  <?php } ?>>
                <a href="<?php echo base_url('usermanagement-users');?>">Users</a>
        </li>

       <li  <?php if($menu_item == "features"){ ?> class="active"  <?php } ?>>
           <a href="<?php echo base_url('usermanagement-features');?>"><?php echo $this->lang->line('features');?></a>
        </li>

       <li  <?php if($menu_item == "permissions"){ ?> class="active"  <?php } ?>>
                <a href="<?php echo base_url('usermanagement-permission');?>">Permission</a>
        </li>


