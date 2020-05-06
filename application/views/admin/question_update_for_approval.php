

    <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <div class="white_card ">
            <div class="row" id="msgshow"></div>
            <form id="standalone" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <?php if(isset($data['passage']->paragraph_id)){ ?>
                <div class="row">
                    <div class='col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Passage<span class="mandatory-asterisk">*</span></div>
                        <input type="hidden" name="paragraph_id" value="<?php echo $data['passage']->paragraph_id;?>">
                        <textarea class="ckeditor" name="passage" id="passage"><?php echo $data['passage']->paragraph_content; ?></textarea>
                    </div>
                </div>
                <?php } ?>
                <div class="row ">
                    <input type="hidden" value="<?php echo $data['question']->question_id; ?>" name="question_id" id="question_id">
                    <input type="hidden" value="<?php echo $data['question']->question_set_id; ?>" name="question_set" id="question_set">
                    <div class='form-group col-sm-3'>
                        <label>Difficulty level</label>
                        <select class="form-control" name="difficulty">
                            <option <?php if($data['question']->question_difficulty==1){echo 'selected';}?> value="1">Easy</option>
                            <option <?php if($data['question']->question_difficulty==2){echo 'selected';}?> value="2">Medium</option>
                            <option <?php if($data['question']->question_difficulty==3){echo 'selected';}?> value="3">Hard</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-9">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary pull-right saveQuestion">Update</button>
                    </div>
                </div>
                <div class="row ">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Question</div>
                        <textarea class="ckeditor" name="question" id="question"><?php echo $data['question']->question_content; ?></textarea>
                    </div>
                </div>

                <div class="row option">
                    <?php 
                        if(!empty($data['options'])){
                            foreach($data['options'] as $key=>$val){
                    ?>
                        <div class="form-group col-sm-6" id="optionContent<?php echo $key+1;?>">
                            <input type="hidden" name="optionname[]" value="<?php echo $key+1;?>">
                            <div class="title-header">
                                &nbsp;&nbsp;Right answer? <input <?php if($val->option_answer==1){echo 'checked';} ?> class="option-answer" type="checkbox" name="answer[]" value="<?php echo $key+1;?>"> <span title="Remove this option" id="removeoption<?php echo $key+1;?>" class="remove-button"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="option[]" class="ckeditor" id="option<?php echo $key+1;?>"><?php echo $val->option_content;?></textarea>
                        </div>
                    <?php }} ?>
                </div>
                
                <div class="row addmoreoptions">
                    <div class="form-group col-sm-12">
                        <button type="button" class="btn addmorebutton">Add More Options</button>
                    </div>
                </div>

                <div class="row ">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Solution</div>
                        <textarea class="ckeditor" name="solution" id="solution"><?php echo $data['question']->question_solution; ?></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary pull-right saveQuestion">Update</button>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>

        </div>
    </div>
    <?php $this->load->view('admin/scripts/question_update_script'); ?>
