             
<?php if(check_module_permission('manage_institute')){
                 if($menu_item == "admin-institute"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>admin-institute">Manage Institute</a>
            </li>
<?php } ?>
<?php if(check_module_permission('discount') || check_module_permission('discount_packages')|| check_module_permission('payment_heads') || check_module_permission('fee_defnition') || check_module_permission('fee_head') ){
            if($menu_item == "discount" || $menu_item == "discount-packages" || $menu_item == "fee-defnition" || $menu_item == "fee-head"){ ?>
                <li class="sub_drop drop_a active"  id="drop_a">
                <?php } else { ?>
                    <li class="sub_drop drop_a"  id="drop_a">
                <?php } ?>
   
            <a><?php echo $this->lang->line('manage_fee');?></a>
            <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
                 <?php if(check_module_permission('payment_heads')) { ?>
                   <li <?php if($menu_item == "payment_head"){?> class="active" <?php } ?> >
                        <a href="<?php echo base_url();?>backoffice/payment-heads"><?php echo $this->lang->line('payment_heads');?></a>
                    </li>
                <?php } ?> 
    <?php if(check_module_permission('discount')) { ?>
                   <li <?php if($menu_item == "discount"){?> class="active" <?php } ?> >
                        <a href="<?php echo base_url();?>backoffice/discount"><?php echo $this->lang->line('discount_category');?></a>
                    </li>
    <?php } ?> 
    <?php if(check_module_permission('discount_packages')) { ?>
                    <li <?php if($menu_item == "discount-packages"){?> class="active" <?php } ?> >
                        <a href="<?php echo base_url();?>backoffice/discount-packages"><?php echo $this->lang->line('discount_packages');?></a>
                    </li>
      <?php } ?>
      <?php if(check_module_permission('fee_head')) { ?>
                    <li <?php if($menu_item == "fee-head"){?> class="active" <?php } ?> >
                        <a href="<?php echo base_url();?>backoffice/fee-head"><?php echo $this->lang->line('fee_head');?></a>
                    </li>
      <?php } ?>
      <?php if(check_module_permission('fee_defnition')) { ?>
                    <li <?php if($menu_item == "fee-defnition"){?> class="active" <?php } ?> >
                        <a href="<?php echo base_url();?>backoffice/fee-defnition"><?php echo $this->lang->line('fee_defnition');?></a>
                    </li>
                 <?php } ?>
                </ul>
            </li>
      <?php } ?>  
<?php if(check_module_permission('manage_syllabus')){
             if($menu_item == "admin-syllabus"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>admin-syllabus">Syllabus</a>
            </li>
<?php } ?>
<?php if(check_module_permission('manage_course')){
             if($menu_item == "admin-class"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>admin-course">Manage Courses</a>

            </li>
  <?php } ?> 
<?php if(check_module_permission('manage_batch')){
             if($menu_item == "batchlist"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/manage-batch">Manage Batch</a>
            </li>
    <?php } ?>

     

<?php if(check_module_permission('manage_subject')){
            
             if($menu_item == "admin-subject"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>admin-subject">Manage Subjects</a>
            </li>
<?php } ?> 
<?php if(check_module_permission('subject_syllabus_mapping')){
            if($menu_item == "admin-subject-syllabus"){ ?>
 
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/admin-subject-syllabus">Subject Syllabus Mapping</a>
            </li>
<?php } ?>
<?php if(check_module_permission('manage_classrooms')){
            if($menu_item == "backoffice/manage-classrooms"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/manage-classrooms">Manage Class Rooms</a>
            </li>
<?php } ?>
<?php if(check_module_permission('manage_bus') || check_module_permission('manage_route') || check_module_permission('vehicle_maintenance')){
              if($menu_item == "backoffice/manage-bus" || $menu_item == "backoffice/manage-route" || $menu_item == "trans_fee_def"  || $menu_item == "transport-fee-collection" || $menu_item == "backoffice/vehicle_maintenance" ){ ?><li class="sub_drop drop_a active"  id="drop_a">
              <?php } else { ?> <li class="sub_drop drop_a"  id="drop_a"><?php } ?>
                  
                  <a><?php echo $this->lang->line('manage_transportation');?></a>
                <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
                <?php if(check_module_permission('trans_fee_definition')){ ?>  
                    <!-- <li  <?php if($menu_item == "trans_fee_def"){ ?> class="active"  <?php } ?>>  
                         <a href="<?php echo base_url();?>backoffice/transportation-fee-definition"><?php echo $this->lang->line('fee_defnition');?></a>
                    </li> -->
                    <?php } ?>
                  <?php if(check_module_permission('manage_bus')){ ?>  
                    <li  <?php if($menu_item == "backoffice/manage-bus"){ ?> class="active"  <?php } ?>>  
                         <a href="<?php echo base_url();?>backoffice/manage-bus"><?php echo $this->lang->line('manage_bus');?></a>
                    </li>
                    <?php } ?>
                    <?php if(check_module_permission('manage_route')){ ?>  
                        <li <?php if($menu_item == "backoffice/manage-route"){ ?> class="active" <?php } ?>>
                            <a href="<?php echo base_url();?>backoffice/manage-route"><?php echo $this->lang->line('manage_route');?></a>
                        </li>
                    <?php } ?>
                    <?php if(check_module_permission('transport_fee_collection')){ ?>  
                        <li <?php if($menu_item == "transport-fee-collection"){ ?> class="active" <?php } ?>>
                            <a href="<?php echo base_url();?>backoffice/transport-fee-collection"><?php echo $this->lang->line('fee_collection');?></a>
                        </li>
                    <?php } ?>
                    <?php if(check_module_permission('vehicle_maintenance')){ ?>  
                        <li <?php if($menu_item == "backoffice/vehicle_maintenance"){ ?> class="active" <?php } ?>>
                            <a href="<?php echo base_url();?>backoffice/maintenance"><?php echo $this->lang->line('maintenance');?></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
<?php } ?>
<!--hostel module-->
<?php if(check_module_permission('manage_buildings') || check_module_permission('manage_floors') ||check_module_permission('manage_floors') || check_module_permission('manage_roomtype') || check_module_permission('manage_rooms') || check_module_permission('manage_roombooking') || check_module_permission('search_roombooking') || check_module_permission('manage_hostelfee') || check_module_permission('pay_hostel_rent')){

             if($menu_item == "pay-hostel-rent" || $menu_item == "manage-buildings" || $menu_item == "manage-floors" || $menu_item == "manage-roomtype" || $menu_item == "manage-rooms" || $menu_item == "manage-roombooking" || $menu_item == "manage-roombooking" || $menu_item == "search-roombooking" || $menu_item == "manage-hostelfee"){ ?>
                    <li class="sub_drop drop_a active"  id="drop_a">
                <?php } else { ?>
                    <li class="sub_drop drop_a"  id="drop_a">
                <?php } ?>
           
            <a><?php echo $this->lang->line('manage_hostel');?></a>
                <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
                    <?php if(check_module_permission('manage_buildings')) { ?>
                    <li <?php if($menu_item == "manage-buildings"){?> class="active" <?php } ?> >
                        <a href="<?php echo base_url();?>backoffice/manage-buildings"><?php echo $this->lang->line('buildings');?></a></li>
                    <?php } 
                    if(check_module_permission('manage_floors')) {?>
                    <li  <?php if($menu_item == "manage-floors"){?> class="active" <?php } ?> >
                    <a href="<?php echo base_url();?>backoffice/manage-floors"><?php echo $this->lang->line('floors');?></a></li>
                    <?php } 
                    if(check_module_permission('manage_roomtype')) {?>
                     <li <?php if($menu_item == "manage-roomtype"){?> class="active" <?php } ?> ><a href="<?php echo base_url();?>backoffice/manage-roomtype"><?php echo $this->lang->line('room_types');?></a>
                    </li>
                    <?php } 
                    if(check_module_permission('manage_rooms')) {?>
                    <li <?php if($menu_item == "manage-rooms"){?> class="active" <?php } ?> ><a href="<?php echo base_url();?>backoffice/manage-rooms"><?php echo $this->lang->line('rooms');?></a>
                    </li>
                     <?php }
                    if(check_module_permission('manage_hostelfee')) {?>
                     <li <?php if($menu_item == "manage-hostelfee"){?> class="active" <?php } ?> ><a href="<?php echo base_url();?>backoffice/manage-hostelfee"><?php echo $this->lang->line('hostel_fees');?></a>
                    </li>
                     <?php } 
                    if(check_module_permission('manage_roombooking')) {?>
                    <li <?php if($menu_item == "manage-roombooking"){?> class="active" <?php } ?> ><a href="<?php echo base_url();?>backoffice/manage-roombooking"><?php echo $this->lang->line('room_booking');?></a>
                    </li>
                    <?php } 
                    if(check_module_permission('search_roombooking')) { ?>
                    <li <?php if($menu_item == "search-roombooking"){?> class="active" <?php } ?> ><a href="<?php echo base_url();?>backoffice/search-roombooking"><?php echo $this->lang->line('search_booking');?></a>
                    </li>
                    <?php } 
                    if(check_module_permission('pay_hostel_rent')) { ?>
                    <li <?php if($menu_item == "pay-hostel-rent"){?> class="active" <?php } ?> ><a href="<?php echo base_url();?>backoffice/pay-hostel-rent"><?php echo $this->lang->line('pay_rent');?></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
<?php } ?>
<?php if(check_module_permission('manage_holidays')){
             if($menu_item == "manage-holidays"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/manage-holidays"><?php echo $this->lang->line('manage_holidays');?></a>

            </li>
<?php } ?>

<?php if(check_module_permission('leave_scheme')|| check_module_permission('staff_leave_status') || check_module_permission('leave_head')) { 
        if($menu_item == "leave-scheme" || $menu_item == "staff-leave-status" || $menu_item == "backoffice/leave-head"){ ?> 
                <li class="sub_drop drop_a active"  id="drop_a">
                <?php } else { ?>
                <li class="sub_drop drop_a"  id="drop_a">
                <?php } ?>
               <a><?php echo $this->lang->line('manageleave');?></a>
                    
                     <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
						 <?php if(check_module_permission('leave_head')){ ?>
						 <?php if($menu_item == "backoffice/leave-head"){ ?>
							<li class="active">
						<?php } else { ?>
							<li>
						<?php } ?>
							<a href="<?php echo base_url();?>backoffice/leave-head"><?php echo $this->lang->line('leave_head');?></a>

						</li>
						 <?php } ?>
                       <?php if(check_module_permission('leave_scheme')) { ?>
                            <li <?php if($menu_item == "leave-scheme"){?> class="active" <?php } ?> >
                                <a href="<?php echo base_url();?>backoffice/leave-scheme"><?php echo $this->lang->line('leave_scheme');?></a>
                            </li>
                        <?php } ?>
                         
                         <?php if(check_module_permission('staff_leave_status')) { ?>
                            <li <?php if($menu_item == "staff-leave-status"){?> class="active" <?php } ?> >
                                <a href="<?php echo base_url();?>backoffice/staff-leave-status"><?php echo $this->lang->line('staff_leave_status');?></a>
                            </li>
                        <?php } ?>
                         
                         
                    </ul>
                </li>
<?php } ?>



<?php if(check_module_permission('salary_scheme') || check_module_permission('salary_processing') || check_module_permission('salary_advances') || check_module_permission('salary_component')){ 
        if($menu_item == "salary-scheme" || $menu_item == "salary-processing" || $menu_item == "salary-advances" || $menu_item == "backoffice/salary-component"){ ?> 
                <li class="sub_drop drop_a active"  id="drop_a">
                <?php } else { ?>
                <li class="sub_drop drop_a"  id="drop_a">
                <?php } ?>
               <a><?php echo $this->lang->line('manage-salary');?></a>
                    
                     <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
						 <?php if(check_module_permission('salary_component')){
								 if($menu_item == "backoffice/salary-component"){ ?>
									<li class="active">
								<?php } else { ?>
									<li>
								<?php } ?>
									<a href="<?php echo base_url();?>backoffice/salary-component"><?php echo $this->lang->line('salary_component');?></a>

								</li>
					<?php } ?>
                       <?php if(check_module_permission('salary_scheme')) { ?>
                            <li <?php if($menu_item == "salary-scheme"){?> class="active" <?php } ?> >
                                <a href="<?php echo base_url();?>backoffice/salary-scheme"><?php echo $this->lang->line('salary_scheme');?></a>
                            </li>
                        <?php } ?>
                         <?php if(check_module_permission('salary_advances')) { ?>

                            <li <?php if($menu_item =="salary-advances"){?> class="active" <?php } ?> >
                                <a href="<?php echo base_url();?>backoffice/salary-advances"><?php echo $this->lang->line('salary_advances');?></a>
                            </li>
                        <?php } ?>
                         
                         <?php if(check_module_permission('salary_processing')) { ?>
                            <li <?php if($menu_item == "salary-processing"){ ?> class="active" <?php } ?> >
                                <a href="<?php echo base_url();?>backoffice/salary-processing"><?php echo $this->lang->line('salary_processing');?></a>
                            </li>
                        <?php } ?>
                         
                         
                    </ul>
                </li>
<?php } ?>


      <?php if(check_module_permission('student_migration') || check_module_permission('staff_migration')){
              if($menu_item == "backoffice/data-migration" || $menu_item == "backoffice/staff-migration" ){ ?><li class="sub_drop drop_a active"  id="drop_a">
              <?php } else { ?> <li class="sub_drop drop_a"  id="drop_a"><?php } ?>
                  
                  <a><?php echo $this->lang->line('data_migration');?></a>
                <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
                  <?php if(check_module_permission('student_migration')){ ?>  
                    <li  <?php if($menu_item == "backoffice/data-migration"){ ?> class="active"  <?php } ?>>  
                         <a href="<?php echo base_url();?>backoffice/data-migration"><?php echo $this->lang->line('student_upload');?></a>
                    </li>
                    <?php } ?>
                    <?php if(check_module_permission('staff_migration')){ ?>  
                        <li <?php if($menu_item == "backoffice/staff-migration"){ ?> class="active" <?php } ?>>
                            <a href="<?php echo base_url();?>backoffice/staff-migration"><?php echo $this->lang->line('staff_upload');?></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
<?php } ?>

<?php if(check_module_permission('basic_entity') || check_module_permission('course_mode')){
              if($menu_item == "basic-entity" ){ ?><li class="sub_drop drop_a active"  id="drop_a">
              <?php } else { ?> <li class="sub_drop drop_a"  id="drop_a"><?php } ?>
                  
                  <a><?php echo $this->lang->line('basic_entity');?></a>
                <ul class="sub_drop_ul drop_ul_a" id="drop_ul_a">
                <?php if(check_module_permission('course_mode')){ ?>  
                        <li <?php if($menu_item == "course-mode"){ ?> class="active" <?php } ?>>
                            <a href="<?php echo base_url();?>backoffice/course-mode"><?php echo $this->lang->line('course_mode');?></a>
                        </li>
                    <?php } ?>
                  <?php if(check_module_permission('basic_entity')){ ?>  
                    <li  <?php if($menu_item == "basic-entity"){ ?> class="active"  <?php } ?>>  
                         <a href="<?php echo base_url();?>backoffice/basic-entity"><?php echo $this->lang->line('basic_entity');?></a>
                    </li>
                    <?php } ?>

                    <?php if(check_module_permission('city_creation')){ ?>  
                    <li  <?php if($menu_item == "basic-city"){ ?> class="active"  <?php } ?>>  
                         <a href="<?php echo base_url();?>backoffice/city"><?php echo $this->lang->line('city');?></a>
                    </li>
                    <?php } ?>
                    
                </ul>
            </li>
<?php } ?>
<!-- <?php if(check_module_permission('basic_entity')){ ?>
             <li <?php if($menu_item == "basic-entity"){ ?> class="active" <?php } ?> >
         
             <a href="<?php echo base_url();?>backoffice/basic-entity"><?php echo $this->lang->line('basic_entity');?></a>

         </li>
<?php } ?> -->
<?php if(check_module_permission('config_settings')){ ?>
             
                <li <?php if($menu_item == "config-settings"){ ?> class="active" <?php } ?> >
            
                <a href="<?php echo base_url();?>backoffice/config-settings"><?php echo $this->lang->line('config_settings');?></a>

            </li>
<?php } ?>