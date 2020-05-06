
<div class="white_card" style="margin:0px;padding:0px;">
    <div class="table-responsive table_language padding_left_15">
        <?php if(!empty($preview)){ ?>
        <ul class="nav nav-pills">
            <?php foreach($preview as $k=>$row){ $class='';if(!isset($temp)){$temp='';$class='active';}?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $class;?>" data-toggle="pill" href="#sess<?php echo $k;?>" id="sess_<?php echo $k;?>">
                        <?php echo $row[0]->section_name;?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <?php $j=1; foreach($preview as $k=>$row){ ?>
                <div id="sess<?php echo $k;?>" class="tab-pane <?php if($j == "1"){ echo "active";}?>">
                    <table class="table table-bordered table-striped table-sm">
                            <tr>
                                <th style="width: 50px;">Sl No.</th>
                                <th>Question</th>
                            </tr>
                            <?php foreach($row as $qstn){ ?>
                                <tr id="examquestion<?php echo $qstn->id;?>">
                                    <td><?php echo $qstn->question_number; ?></td>
                                    <td style="cursor:pointer;" onclick="get_question(<?php echo $qstn->id;?>);"><?php echo $qstn->question_content; ?></td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
            <?php $j++; } ?> 
        </div>
        <?php } ?>
       
    </div>
</div>