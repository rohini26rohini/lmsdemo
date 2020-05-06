<?php if(check_module_permission('category')){
    if($menu_item == "backoffice/category"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/category"><?php echo $this->lang->line('category');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('banner')){
    if($menu_item == "backoffice/banner"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/banner"><?php echo $this->lang->line('banner');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('special_about_school')){
    if($menu_item == "backoffice/special-about-school"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/special-about-school"><?php echo $this->lang->line('special_about_school');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('services')){
    if($menu_item == "backoffice/services"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/services">Services</a>
        </li>
<?php } ?>

<?php if(check_module_permission('how_to_prepare')){
    if($menu_item == "backoffice/how_to_prepare"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/how_to_prepare">How to Prepare</a>
        </li>
<?php } ?>  

<?php if(check_module_permission('success_stories')){
    if($menu_item == "backoffice/success-stories"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/success-stories">Success Stories</a>
        </li>
<?php } ?>

<?php if(check_module_permission('gallery')){
    if($menu_item == "backoffice/gallery"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/gallery"><?php echo $this->lang->line('gallery');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('general_studies')){
    if($menu_item == "backoffice/general-studies"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/general-studies"><?php echo $this->lang->line('general_studies');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('general_studies')){
    if($menu_item == "backoffice/previous-question-and-syllabus"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/previous-question-and-syllabus"><?php echo $this->lang->line('previous_question_and_syllabus');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('careers')){
    if($menu_item == "backoffice/careers" || $menu_item == "backoffice/received-applications"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/careers"><?php echo $this->lang->line('career');?></a>
        </li>
<?php } ?>

<?php if(check_module_permission('exams_notifications')){
    if($menu_item == "backoffice/exams-notifications"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/exams-notifications">Exams & Notifications</a>
        </li>
<?php } ?>  



<?php if(check_module_permission('result')){
    if($menu_item == "backoffice/result"){ ?>
        <li class="active">
            <?php } else { ?>
        <li>
            <?php } ?>
                <a href="<?php echo base_url();?>backoffice/result">Results</a>
        </li>
<?php } ?>  
<?php if(check_module_permission('question')){ ?>
    
        <li <?php if($menu_item == "sample_questions"){ ?> class="active" <?php } ?>>
            <a href="<?php echo base_url();?>backoffice/sample-questions"><?php echo $this->lang->line('take_a_test');?></a>
        </li>
<?php } ?>