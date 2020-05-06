<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Add Exam Section Template</h6>
        <hr/>

        <form id="sectiondefine" autocomplete="off" method="post" accept-charset="utf-8">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />       
            <div  id="row_block">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Section Template Name<span class="mandatory-asterisk">*</span></label>
                            <input name="section_name" placeholder="Section Template Name" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="add_wrap">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Select Subject<span class="mandatory-asterisk">*</span></label>
                                <select name="subject[]" class="form-control subject" id="subject1">
                                    <option value="">Select a subject</option>
                                    <?php 
                                        if(!empty($subjects)){
                                            foreach($subjects as $row){
                                                echo '<option value="'.$row['subject_id'].'">'.$row['subject_name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Select Module<span class="mandatory-asterisk">*</span></label>
                                <select name="module[]" class="form-control" id="module1">
                                    <option value="">Select a module</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Mark Distribution<span class="mandatory-asterisk">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="positivemark[]" class="form-control" placeholder="Correct Ans(+)">
                                    <input type="text" name="negativemark[]" class="form-control" placeholder="Wrong Ans(-)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info add_wrap_pos" id="add_block">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn_save">Save</button>
                            <button type="button" onClick="go_back()" class="btn btn-default btn_cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<?php $this->load->view('admin/scripts/examManagement/exam_section_definition_script'); ?>