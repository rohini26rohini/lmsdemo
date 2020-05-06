
<style>
    ul {
        list-style-type: none;
    }

    body {
        border-radius: 10px;
    }
    @page {
        size: auto;
        odd-header-name: html_myHeader1;
        even-header-name: html_myHeader2;
        odd-footer-name: html_myFooter1;
        even-footer-name: html_myFooter2;
    }

    @page chapter2 {
        odd-header-name: html_Chapter2HeaderOdd;
        even-header-name: html_Chapter2HeaderEven;
        odd-footer-name: html_Chapter2FooterOdd;
        even-footer-name: html_Chapter2FooterEven;
    }

    @page noheader {
        odd-header-name: _blank;
        even-header-name: _blank;
        odd-footer-name: _blank;
        even-footer-name: _blank;
    }

    div.chapter2 {
        page-break-before: right;
        page: chapter2;
    }

    div.noheader {
        page-break-before: right;
        page: noheader;
    }

    .left-col {
        float: left;
        width: 50%;
    }

    .right-col {
        float: right;
        width: 50%;
    }

    .mytitle {
        font-weight: bold;
        border: 1px solid black;
        border-radius: 10px;
        width: 33%;
        padding: 10px;
        font-size: 25px;
    }
</style>
<?php // show($questionArr); ?>

        <?php  $i=1; 
        $count = count($questionArr)/2;
        $passageTemp = [];
        foreach($questionArr as $question){  ?>
            <ul>  
                <?php 
                    if(isset($passageArr[$question['paragraph_id']])){ 
                        if(!in_array($question['paragraph_id'],$passageTemp)){
                            array_push($passageTemp,$question['paragraph_id']);
                ?>
                <li>   
                    <p>
                        <?php echo '<b>Passage:</b> '.$passageArr[$question['paragraph_id']]['paragraph_content'];?>
                    </p> 
                </li> 
                <?php }} ?>
                <li>   
                    <p>
                        <?php echo $i.".  ";?>
                        <?php echo $question['question_content'];?>
                    </p> 
                    <ul>
                    <?php foreach($question['options'] as $options){  ?>
                        <li>
                            <?php echo $options['option_number']?>) <?php echo $options['option_content'];?>
                        </li>
                    <?php }  ?>
                    </ul> 
                </li> 
            </ul> 
        <?php $i++; } ?> 

