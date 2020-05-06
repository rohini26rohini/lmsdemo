

    <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <div class="white_card ">
            <div class="row" id="msgshow"></div>
            <form id="standalone" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="row ">
                    <div class='form-group col-sm-6'>
                        <label>Question Set<span class="mandatory-asterisk">*</span></label>
                        <select class="form-control" name="question_set" id="question_set">
                            <?php 
                                if(!empty($questionsets)){
                                    foreach($questionsets as $row){
                            ?>
                                <option value="<?php echo $row->question_set_id;?>"><?php echo $row->question_set_name;?></option>
                            <?php }} ?>
                        </select>
                    </div>
                    <div class='form-group col-sm-2'>
                        <label>Difficulty Level</label>
                        <select class="form-control" name="difficulty" id="difficulty">
                            <option value="1">Easy</option>
                            <option selected value="2">Medium</option>
                            <option value="3">Hard</option>
                        </select>
                    </div>
                    <div class='form-group col-sm-2'>
                        <label>Question Type</label>
                        <select class="form-control" name="question_type" id="question_type">
                            <option selected value="1">Objective</option>
                            <option value="2">Descriptive</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2 pull-right">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary pull-right saveQuestion">Save</button>
                    </div>
                </div>
                <div class="row ">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Question</div>
                        <textarea class="ckeditor" name="question" id="question"></textarea>
                    </div>
                </div>

            <div id="objectivetype">
                <div class="row option">
                    <?php 
                       $default = 1;
                       while($default<=DEFAULT_OPTIONS_COUNT){
                    ?>
                        <div class="form-group col-sm-6" id="optionContent<?php echo $default;?>">
                            <input type="hidden" name="optionname[]" value="<?php echo $default;?>">
                            <div class="title-header">
                                 &nbsp;&nbsp;Right answer? <input class="option-answer"  type="checkbox" name="answer[]" value="<?php echo $default;?>"> <span title="Remove this option" id="removeoption<?php echo $default;?>" class="remove-button"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="option[]" class="ckeditor" id="option<?php echo $default;?>"></textarea>
                        </div>
                    <?php $default++; } ?>
                </div>
                
                <div class="row addmoreoptions">
                    <div class="form-group col-sm-12">
                        <button type="button" class="btn addmorebutton">Add More Options</button>
                    </div>
                </div>
            </div>
                <div class="row ">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Solution</div>
                        <textarea class="ckeditor" name="solution" id="solution"></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary pull-right saveQuestion">Save</button>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>

        </div>
    </div>
    <?php $this->load->view('admin/scripts/materialManagement/single_script'); ?>
