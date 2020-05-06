<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Add Exam Section Template</h6>
        <hr/>
        
        <form id="sectiondefine" autocomplete="off" method="post" accept-charset="utf-8">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />       
            <div id="row_block">
                <div class="add_wrap">
                    <div class="row">
                        <input type="hidden" name="section_id" value="<?php echo $section->id; ?>" />   
                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Section Template Name<span class="mandatory-asterisk">*</span></label>
                                <input value="<?php echo $section->section_name; ?>" name="section_name" placeholder="Section Name" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add_wrap">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Subject</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Module</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Mark Distribution<span class="mandatory-asterisk">*</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $ki=1000;foreach($details as $detail){$ki++; ?>   
                <div class="add_wrap" id="block<?php echo $ki; ?>">
                    <input type="hidden" name="detail_id[]" value="<?php echo $detail->id;?>" />    
                    <div class="row">
                        <?php 
                            if(!empty($modules)){
                                foreach($modules as $row){
                                    if($row->subject_id == $detail->subject_id){
                                        
                        ?>
                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <select name="subject[]" class="form-control subject" id="subject<?php echo $ki; ?>">
                                        <option value="">Select a subject</option>
                                        <?php 
                                            if(!empty($subjects)){
                                                foreach($subjects as $sub){
                                                    if($row->parent_subject == $sub['subject_id']){
                                                        echo '<option selected value="'.$sub['subject_id'].'">'.$sub['subject_name'].'</option>';
                                                    }else{
                                                        echo '<option value="'.$sub['subject_id'].'">'.$sub['subject_name'].'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <select name="module[]" class="form-control" id="module<?php echo $ki; ?>">
                                        <option value="">Select a module</option>
                                        <?php 
                                            if(!empty($modules)){
                                                foreach($modules as $mod){
                                                    if($row->parent_subject == $mod->parent_subject){
                                                        if($row->subject_id == $mod->subject_id){
                                                            echo '<option selected value="'.$mod->subject_id.'">'.$mod->subject_name.'</option>';
                                                        }else{
                                                            echo '<option value="'.$mod->subject_id.'">'.$mod->subject_name.'</option>';
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php 
                                    break;}
                                }
                            }
                        ?>
                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input value="<?php echo $detail->mark_per_question; ?>" type="text" name="positivemark[]" class="form-control" placeholder="Correct Ans(+)">
                                    <input value="<?php echo $detail->negative_mark_per_question; ?>" type="text" name="negativemark[]" class="form-control" placeholder="Wrong Ans(-)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($ki==1001){ ?>
                        <button type="button" class="btn btn-info add_wrap_pos" id="add_block">
                            <i class="fa fa-plus"></i>
                        </button>
                    <?php }else{ ?>
                        <button type="button" class="btn btn-default add_wrap_pos" onClick="removeBlock(<?php echo $ki; ?>);">
                            <i class="fa fa-minus"></i>
                        </button>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>

            <div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <button class="btn btn-info btn_save">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<?php $this->load->view('admin/scripts/examManagement/exam_section_definition_script'); ?>