
    <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12" id="questionPageTag">
        <div class="white_card ">
            <form id="paragraphform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <!-- <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary pull-right saveQuestion">Next</button>
                    </div>
                </div> -->
                <div class="row ">

                    <div class='form-group col-sm-8'>
                        <label>Question set<span class="mandatory-asterisk">*</span></label>
                        <select class="form-control" name="question_set" id="question_set">
                            <?php
                                if(!empty($questionsets)){
                                    foreach($questionsets as $row){
                            ?>
                                <option value="<?php echo $row->question_set_id;?>"><?php echo $row->question_set_name;?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class='form-group col-sm-3'>
                        <label>Select Passage<span class="mandatory-asterisk">*</span></label>
                        <select class="form-control" name="passagetype" id="passagetype">
                            <option value="">Select passage</option>
                            <option value="existing">Existing passage</option>
                            <option value="new">New passage</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-1">
                        <label>&nbsp;&nbsp;</label>
                        <button type="submit" class="form-control btn btn-primary saveParagraph">Next</button>
                    </div>

                </div>

                <div class="row existingpassage">
                    <div class='form-group col-sm-12'>
                        <label>Passage<span class="mandatory-asterisk">*</span></label>
                        <select class="form-control" name="passage_id" id="passage_id">
                            <option value="">No existing passage available please add a new one</option>
                        </select>
                    </div>
                </div>

                <div class="row newpassage">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;Passage<span class="mandatory-asterisk">*</span></div>
                        <textarea class="ckeditor" name="passage" id="passage"></textarea>
                        <label style="color:red;">Note*: Image upload only support gif,jpeg,jpg,png,bmp and maximum file size 2MB.</label>
                    </div>
                </div>

                <!-- <div class="row existingpassage newpassage">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary pull-right saveParagraph">Next</button>
                    </div>
                </div> -->
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            
                <div class="row" id="passage-view-div">
                    <div class="title-header">&nbsp;&nbsp;Passage-Preview</div>
                    <div class='passage-view col-sm-12' id="passage-view"></div>
                </div>
            </form>

        </div>
    </div>
<?php $this->load->view('admin/scripts/materialManagement/passage_script'); ?>
