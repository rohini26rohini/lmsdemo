<?php //echo '<pre>'; print_r($questions);
if(!empty($questions)) {
?>
<div class="QuestionBox">
    <h5>
       <?php 
         if($questions['paragraph_id']>0) {
             echo $questions['paragraph']->paragraph_content;
         } else {
        if(!empty($questions) && $questions['question_content']!='') { echo $questions['question_content'];}
         }
        ?>
    </h5>
    <?php
    if($questions['paragraph_id']>0) {
             if(!empty($questions) && $questions['question_content']!='') { echo '<p class="quesQ"><b>Q.</b>'.$questions['question_content'].'</p>'; }
         }
    ?>
    <ol class="QuestionOptions">
         <?php 
         if($questions['question_type'] == 2) {
            echo '<ol><li><b>Given Answer: </b>'.base64_decode($selected_choices).'</li></ol>';   
          } else {
        ?>
        <ul>
            <?php 
            if(!empty($questions['options'])){
                $p = 1;
                foreach($questions['options'] as $question){  
                    $answer =   '';
                    $wronganswer = '';
                    // if($selected_choices==$p) {
                    //    $wronganswer = 'Answrong' ;
                    // }
                    if (in_array($p, $selctArr)){
                        $wronganswer = 'Answrong' ;
                     }
                    if($question['option_answer']==1) {
                       $answer = 'AnsRight' ;
                       $wronganswer = '' ;
                    }
            ?>
            <li class="<?php echo $wronganswer; echo ' '.$answer;?>"><span class="text-uppercase quesno" ><?php echo $question['option_number'];?></span><div class="ansBox"><?php echo $question['option_content'];?></div></li>
            <?php $p++;?>
            <?php } ?>
            <?php }?>
<!--
            <li class="Answrong"><span>B</span>one</li>
            <li><span>C</span>one</li>
            <li class="AnsRight"><span>B</span>one</li>
-->
    </ul>
    </ol>
          <?php } ?>           
        <p>
            <?php
            if(!empty($questions) && $questions['question_solution']!='') { echo '<span class="hints">Solution: </span> '.$questions['question_solution'];}
            ?>
            </p>
    </div>
    </div>
<?php } else { ?>
No data found.
<?php } ?>
