
    <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12">
        <div class="white_card ">
        <h6><?php if(isset($_GET['id'])){echo 'Edit';}else{echo 'Add';}?> study material</h6>
        <hr>
            <form id="study_material_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <input type="hidden" name="study_material_id" value="<?php if(isset($study_material)){echo $study_material['id'];}?>" />
            
                <div class="row ">
                    <div class='form-group col-sm-4'>
                        <label>Subject<span class="req redbold">*</span></label>
                        <select class="form-control" id="subject" name="subject">
                            <option value="">Select </option>
                            <?php 
                                if(!empty($subjectArr)){
                                    foreach($subjectArr as $sub){
                            ?>
                            <option
                            <?php if(isset($study_material)){if($study_material['subject_id']==$sub['subject_id']){echo 'selected';} }?>
                            value="<?php echo $sub['subject_id'];?>"><?php echo $sub['subject_name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-4">
                        <label><?php echo $this->lang->line('module');?><span class="req redbold">*</span></label>
                        <select class="form-control" id="modules" name="modules">
                            <option value="">Select</option>
                            <?php
                                if(isset($moduleArr)){
                                    foreach($moduleArr as $mod){
                            ?>
                                <option
                                <?php if(isset($study_material)){if($study_material['module_id']==$mod['subject_id']){echo 'selected';} }?>
                                value="<?php echo $mod['subject_id'];?>"><?php echo $mod['subject_name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-4">
                        <label><?php echo $this->lang->line('material');?><span class="req redbold">*</span></label>
                        <select class="form-control" name="material" id="material">
                            <option value=""><?php echo $this->lang->line('select_material');?></option>
                            <?php
                           
                                if(isset($materialArr)){
                                    foreach($materialArr as $row){
                            ?>
                                <option
                                <?php if(isset($study_material)){if($study_material['material_id']==$row['material_id']){echo 'selected';} }?>
                                value="<?php echo $row['material_id'];?>"><?php echo $row['material_name'];?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <label>Topic<span class="req redbold">*</span></label>
                        <input class="form-control" type="text" id="description" name="description" value="<?php if(isset($study_material)){echo $study_material['description'];}?>" placeholder="Study material topic">
                    </div>
                </div>

                <div class="row ">
                    <div class='form-group col-sm-12'>
                        <div class="title-header">&nbsp;&nbsp;<?php echo $this->lang->line('study_notes');?></div>
                        <textarea class="ckeditor" name="study_notes" id="study_notes"><?php if(isset($study_material)){echo $study_material['text_content'];}?></textarea>
                    </div>
                </div>

                <div class="row ">
                    <div class='form-group col-sm-6'>
                        <div class="title-header">&nbsp;&nbsp;<?php echo $this->lang->line('video_lectures');?></div>
                        <input class="form-control" type="file" name="video_notes" id="video_notes">
                        <label>Upload an mp4 video file.</label>
                        <label>Maximum file size up to <?php echo (VIDEO_LECTURE_SIZE/1024).'MB'?></label>
                        <span id="video_error" style="color:red;"></span><br>
                        <?php if(isset($study_material)){
                            if(!empty($study_material['video_content'])){
                                echo "<span id='empty_video_message'><a target='_blank' href='".base_url($study_material['video_content'])."'>Download video lecture</a>
                                        <a title='Delete video lecture' class='btn btn-default option_btn' onclick='delete_video_material(".$study_material['id'].")'>
                                            <i class='fa fa-trash-o'></i>
                                        </a></span>";
                            }else{
                                echo '<span>No video lecture uploaded</span>';
                            }
                        }?>
                    </div>

                    <div class='form-group col-sm-6'>
                        <div class="title-header">&nbsp;&nbsp;<?php echo $this->lang->line('audio_lectures');?></div>
                        <input class="form-control" type="file" name="audio_notes" id="audio_notes">
                        <label>Upload an mp3 audio file.</label>
                        <label>Maximum file size up to <?php echo (AUDIO_LECTURE_SIZE/1024).'MB'?></label>
                        <span id="audio_error" style="color:red;"></span><br>
                        <?php if(isset($study_material)){
                            if(!empty($study_material['audio_content'])){
                                echo "<span id='empty_audio_message'><a target='_blank' href=".base_url($study_material['audio_content']).">Download audio lecture</a>
                                        <a title='Delete audio lecture' class='btn btn-default option_btn' onclick='delete_audio_material(".$study_material['id'].")'>
                                            <i class='fa fa-trash-o'></i>
                                        </a></span>";
                            }else{
                                echo '<span>No audio lecture uploaded</span>';
                            }
                        }?>
                    </div>

                    <div class='form-group col-sm-6'>
                        <div class="title-header">&nbsp;&nbsp;Youtube</div>
                        <input class="form-control" type="text" name="youtube_notes" id="youtube_notes" value="<?php if(isset($study_material)){echo $study_material['youtube_notes'];}?>">
                        <label>Copy and paste youtube embed code </label>
                        <label>example: https://www.youtube.com/embed/CMTmuKe2dEI</label>
                        <span id="audio_error" style="color:red;"></span>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-info pull-right save_study_material">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
<?php $this->load->view('admin/scripts/materialManagement/study_materials_add_edit_script'); ?>
