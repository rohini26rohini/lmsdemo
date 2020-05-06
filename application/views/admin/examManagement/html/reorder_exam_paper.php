
<div class="white_card" style="margin:0px;padding:0px;" id="exam_paper_privew_div">
    <div class="table-responsive table_language padding_left_15">
        <?php if(!empty($preview)){ ?>
        <ul class="nav nav-pills" style="font-size:15px;">
            <?php foreach($preview as $k=>$row){ $class='';if(!isset($temp)){$temp='';$class='active';}?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $class;?>" data-toggle="pill" href="#sess_reorder_<?php echo $k;?>" id="sess_reorder<?php echo $k;?>">
                        <?php echo $row[0]->section_name;?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content" style="height: 465px;overflow: scroll;" >
            <?php $j=1; foreach($preview as $k=>$row){ ?>
                <div id="sess_reorder_<?php echo $k;?>" class="tab-pane <?php if($j == "1"){ echo "active";}?>">
                    <ol type="1" class="exam_paper_questions">
                        <?php foreach($row as $qstn){ ?>
                            <li class="dragndrop-element ">
                                <input type="hidden" name="exam_paper_question_id[]" value="<?php echo $qstn->id; ?>">
                                <?php echo $qstn->question_content; ?>
                            </li>
                        <?php } ?>
                    </ol>
                </div>
            <?php $j++; } ?> 
        </div>
        <?php } ?>
    </div>
</div>