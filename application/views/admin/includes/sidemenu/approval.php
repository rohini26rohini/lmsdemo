            <?php
            if($this->session->userdata('role')=='centerhead' || $this->session->userdata('role')=='admin') { // 
            ?>
            <li <?php if($menu_item == "backoffice/Approval"){ ?> class="active" <?php } ?>>
                <a href="<?php echo base_url();?>backoffice/discount-approval">Discount Approval</a>
            </li>
            <?php } ?>
            <?php
            if($this->session->userdata('role')=='management' || $this->session->userdata('role')=='admin') { // 
            ?>
            <li <?php if($menu_item == "backoffice/maintenance-approval"){ ?> class="active" <?php } ?>>
                <a href="<?php echo base_url();?>backoffice/maintenance-amount-approval">Maintenance Approval</a>
            </li>
            <?php } ?>
            <?php if(check_module_permission('material_approval')) { // ?>
                <li <?php if($menu_item == "backoffice/material-approval" || $menu_item == "backoffice/question-set-approval-levels"){ ?> class="active" <?php } ?>>
                    <a href="<?php echo base_url();?>backoffice/material-approval">Material Approval</a>
                </li>
            <?php } ?>
