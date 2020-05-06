
            <?php if(check_module_permission('create_exam_section')){ ?>
                <?php if($menu_item == "create_exam_section"){ ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="<?php echo base_url('backoffice/exam-section'); ?>">Exam section templates</a>
                </li>
            <?php } ?>

            <?php if(check_module_permission('create_exam_model')){ ?>
                <?php if($menu_item == "create_exam_model"){ ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="<?php echo base_url('backoffice/exam-template'); ?>">Exam models</a>
                </li>
            <?php } ?>

            <?php if(check_module_permission('create_question_paper')){ ?>
                <?php if($menu_item == "create_question_paper"){ ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="<?php echo base_url('backoffice/exam-paper'); ?>">Exam papers</a>
                </li>
            <?php } ?>

            <?php if(check_module_permission('exam_schedule')){ ?>
                <?php if($menu_item == "exam_schedule"){ ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="<?php echo base_url('backoffice/exam-schedule'); ?>">Exam schedule</a>
                </li>
            <?php } ?>

            <?php if(check_module_permission('exam_valuation')){ ?>
                <?php if($menu_item == "exam_valuation"){ ?>
                    <li class="active">
                <?php } else { ?>
                    <li>
                <?php } ?>
                    <a href="<?php echo base_url('backoffice/exam-valuation'); ?>">Exam Evaluation</a>
                </li>
            <?php } ?>

