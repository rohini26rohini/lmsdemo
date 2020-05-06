 <?php if(check_module_permission('manage_materials')){ ?>
            <li  <?php if($menu_item == "materials"){ ?> class="active" <?php } ?>><a href="<?php echo base_url('backoffice/manage-materials'); ?>">Materials </a></li>
<?php }
if(check_module_permission('manage_questionset')){
?>
            <li  <?php if($menu_item == "questionset"){ ?> class="active" <?php } ?>><a href="<?php echo base_url('backoffice/question-set'); ?>"><?php echo $this->lang->line('question_set');?> </a></li>
<?php } 
if(check_module_permission('manage_questionbank')){
?>
            <?php if($menu_item == "questionbank"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/question-bank'); ?>">Question Bank</a>
            </li>
<?php } 
if(check_module_permission('manage_study_material')){
?>
            <?php if($menu_item == "study_material"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/study-material'); ?>">Study material</a>
            </li>
<?php } ?>
            <!-- <?php if($menu_item == "group"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/create-question-set-group'); ?>">Passaged questions</a>
            </li>

            <?php if($menu_item == "singleton"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/create-question-set-single'); ?>">Non passaged questions</a>
            </li> -->
<?php if(check_module_permission('manage_learning_module') || check_module_permission('create_learning_module') || check_module_permission('schedule_learning_module')){?>
            <?php if($menu_item == "learning_module" || $menu_item == "create_learning_module" || $menu_item == "schedule_learning_module"){ ?>
                <li class="active">
            <?php } else { ?>
                <li>
            <?php } ?>
                <a href="<?php echo base_url('backoffice/learning-module'); ?>">Learning Module</a>
            </li>
<?php } ?>

