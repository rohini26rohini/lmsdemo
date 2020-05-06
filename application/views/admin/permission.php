<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('defined_permission');?></h6>
        <hr>
        
        <!-- Data Table Plugin Section Starts Here -->
        
        <div class="table-responsive table_language" >
        <table id="institute_data" class="table table-striped table-sm" style="width:100%">
            <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('role');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
            <?php
            if(!empty($roles)) {
              
            $i=1; foreach($roles as $role){?>
            <tr >

                <td width="50">
                    <?php echo $i;?>
                </td>
                <td>
                    <?php echo $role['role_name'];?>
                </td>
                <td>
                    <?php// echo $role['user_role'];?>
                </td>
               

                <td>
                   <a class="btn btn-primary btn-sm btn_details_view" href="<?php echo base_url(); ?>define-permission/<?php echo $role['roles_id'];?>"><?php echo $this->lang->line('define_permission');?></a>
                </td>

            </tr>

            <?php $i++; }
            } ?>

            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->



<!-- <?php// $this->load->view("admin/scripts/permission_script");?> -->
