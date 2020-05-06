
        <div class="white_card">
            <div class="row">
                <div class="title-header">&nbsp;&nbsp;Passage</div>
                <div class='passage-view col-sm-12'>
                    <?php echo $paragraph_content;?>
                </div>
            </div>
            <form id="standalone" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="row ">
                    <input type="hidden" name="question_set" value="<?php echo $question_set_id;?>">
                    <input type="hidden" name="paragraph_id" value="<?php echo $paragraph_id;?>">
                    <div class='form-group col-sm-2'>
                        <div class="title-header">&nbsp;&nbsp;Difficulty level</div>
                        <select class="form-control" name="difficulty" id="difficulty">
                            <option value="1">Easy</option>
                            <option selected value="2">Medium</option>
                            <option value="3">Hard</option>
                        </select>
                    </div>
                    <div class='form-group col-sm-2'>
                        <div class="title-header">&nbsp;&nbsp;Question Type</div>
                        <select class="form-control" name="question_type" id="question_type">
                            <option selected value="1">Objective</option>
                            <option value="2">Descriptive</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-8 pull-right">
                        <button type="submit" class="btn btn-primary pull-right saveQuestion">Save</button>
                    </div>
                </div>
                <div class="row ">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Question</div>
                        <textarea height="10%" width="100%" class="ckeditor" name="question" id="question"></textarea>
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

    <?php $this->load->view('admin/scripts/materialManagement/group_script',TRUE); ?>
