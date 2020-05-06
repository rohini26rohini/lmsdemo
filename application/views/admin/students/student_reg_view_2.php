<form id="qualification_form" method="post">
    <div class="row">
        <input type="hidden" name="student_id" value="<?php echo $studentArr['student_id']; ?>" />
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label>Class X or Below</label>
                <div class="input-group input_group_form">
                    <input type="hidden" name="category[]" value="sslc" />
                    <select type="text" class="form-control" name="qualification[]">
                        <?php
                            $sslcArr=$this->common->get_student_qualification_byid($studentArr['student_id'],"sslc");
                            if(!empty($sslcArr['qualification'])){
                        ?>
                        <option selected ><?php if(!empty($sslcArr['qualification'])){echo $sslcArr['qualification'];}?>
                        <?php }?>
                        <option value="">Select</option>
                        <?php //echo get_sslc();?>
                        <?php
                        $qualifications = $this->common->get_qualifications_type('Classx');
                        if(!empty($qualifications)) {
                            foreach($qualifications as $qualification) {
                                echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                    <div class="input-group-append percent_box">
                        <input type="text" class="form-control" name="marks[]" value="<?php if(!empty($sslcArr['marks'])) {echo $sslcArr['marks']; }?>" onkeypress="return decimalNum(event);" maxlength="5" id="sslc_mark" />
                    </div>
                    <div class="input-group-prepend percentageSpan">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <span class="req redbold" id="sslc_mark_msg"></span>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"> <label>+2/VHSE</label>
                <div class="input-group input_group_form">
                    <input type="hidden" name="category[]" value="plustwo" />
                    <select class="form-control" name="qualification[]">
                        <?php
                            $plustwo=$this->common->get_student_qualification_byid($studentArr['student_id'],"plustwo");
                            if(!empty($plustwo['qualification'])){ 
                       ?>
                        <option selected ><?php if(!empty($plustwo['qualification'])){echo $plustwo['qualification'];}?></option>
                            <?php }?>
                        <option value="">Select</option>
                        <?php
                        $qualifications = $this->common->get_qualifications_type('Classxii');
                        // show($qualifications);
                        if(!empty($qualifications)) {
                            foreach($qualifications as $qualification) {
                                echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                            }
                        }
                        ?>
                        <?php //echo get_pre_degrees();?>
                    </select>
                    <div class="input-group-append percent_box">
                        <input type="text" class="form-control" name="marks[]" value="<?php if(!empty($plustwo['marks'])){ echo $plustwo['marks']; }?>" onkeypress="return decimalNum(event);" maxlength="5" id="plustwo_mark" />
                    </div>
                    <div class="input-group-prepend percentageSpan">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <span class="req redbold" id="plustwo_mark_msg"></span>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"> <label>Degree</label>
                <input type="hidden" name="category[]" value="degree" />
                <div class="input-group input_group_form">
                    <select type="text" class="form-control" name="qualification[]">
                        <?php
                            $degree=$this->common->get_student_qualification_byid($studentArr['student_id'],"degree");
                            if(!empty($degree['qualification'])){
                        ?>
                        <option selected ><?php if(!empty($degree['qualification'])){echo $degree['qualification'];}?></option>
                        <?php }?>
                        <option value="">Select</option>
                        <?php
                        $qualifications = $this->common->get_qualifications_type('Degree');
                        if(!empty($qualifications)) {
                            foreach($qualifications as $qualification) {
                                echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                            }
                        }
                        ?>
                        <?php //echo get_degrees();?>
                    </select>
                    <div class="input-group-append percent_box">
                        <input type="text" class="form-control" name="marks[]" value="<?php if(!empty($degree['marks'])){ echo $degree['marks']; }?>" onkeypress="return decimalNum(event);" maxlength="5" id="degree_mark" />
                    </div>
                    <div class="input-group-prepend percentageSpan">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <span class="req redbold" id="degree_mark_msg"></span>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group"> <label>PG</label>
                <input type="hidden" name="category[]" value="pg" />
                <div class="input-group input_group_form">
                    <select type="text" class="form-control " name="qualification[]">
                        <?php
                            $pg=$this->common->get_student_qualification_byid($studentArr['student_id'],"pg");
                            if(!empty($pg['qualification'])){
                        ?>
                        <option selected ><?php if(!empty($pg['qualification'])){echo $pg['qualification'];}?></option>
                        <?php }?>
                        <option  value="" >Select</option>
                        <?php
                        $qualifications = $this->common->get_qualifications_type('PG');
                        if(!empty($qualifications)) {
                            foreach($qualifications as $qualification) {
                                echo '<option value="'.$qualification->entity_name.'">'.$qualification->entity_name.'</option>';
                            }
                        }
                        ?>
                        <?php //echo get_post_graduates();?>
                    </select>
                    <div class="input-group-append percent_box">
                        <input type="text" class="form-control" name="marks[]" value="<?php if(!empty($pg['marks'])){ echo $pg['marks']; }?>" onkeypress="return decimalNum(event);" maxlength="5" id="pg_mark" />
                    </div>
                    <div class="input-group-prepend percentageSpan">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <span class="req redbold" id="pg_mark_msg"></span>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h6>Additional Qualifications</h6>
            <hr>
            <?php 
                $other=$this->common->get_student_qualification_byid($studentArr['student_id'],"other");
            ?>
            <?php 
            if(!empty($other)){
                $i=3;
                $countInitializer = count($other) + 3;
                echo '<input type="hidden" name="counter" id="counter" value="'.$countInitializer.'">';
                foreach($other as $row){
                    $i++; ?>
                    <div class="row" id="new_textbox<?=$i?>">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="add_wrap">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="hidden" name="category[<?=$i?>]" value="other" />
                                            <div class="input-group input_group_form">
                                                <input type="text" class="form-control" id="qualification"  placeholder="Additional Qualifications" name="qualification[<?=$i?>]" value="<?php echo !empty($row['qualification'])?$row['qualification']:'';?>">
                                                <div class="input-group-append percent_box">
                                                    <input type="text" class="form-control numbersOnly"  name="marks[<?=$i?>]" value="<?php echo !empty($row['marks'])?$row['marks']:'';?>" onkeypress="return decimalNum(event);" maxlength="5" />
                                                </div>
                                                <div class="input-group-prepend percentageSpan">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($i==4){ ?>
                                    <button type="button" class="btn btn-default add_wrap_pos" id="add_more"><i class="fa fa-plus"></i></button>
                                <?php }else{?>
                                    <button class="btn add_wrap_pos btn-info remove_section remove_this" id="delete" type="button"  onclick="delete_others(<?php echo $i;?>,<?php echo $row['qualification_id'];?>)" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                <?php } ?>
                            </div> 
                        </div>
                    </div>
                <?php  
                } 
            }else{ 
                $i=4;?>
                <input type="hidden" name="counter" id="counter" value="4">
                <div class="row" id="new_textbox<?=$i?>">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="add_wrap">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="category[<?=$i?>]" value="other" />
                                        <div class="input-group input_group_form">
                                            <input type="text" class="form-control " id="qualification" onblur="check_if_exists();" placeholder="Additional Qualifications" name="qualification[<?=$i?>]" value="<?php echo !empty($row['qualification'])?$row['qualification']:'';?>">
                                            <div class="input-group-append percent_box">
                                                <input type="text" class="form-control numbersOnly" placeholder="" name="marks[<?=$i?>]" value="<?php echo !empty($row['marks'])?$row['marks']:'';?>" onkeypress="return decimalNum(event);" maxlength="5"/>
                                            </div>
                                            <div class="input-group-prepend percentageSpan">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($i==4){ ?>
                                    <button type="button" class="btn btn-default add_wrap_pos" id="add_more" style="min-width:auto"><i class="fa fa-plus"></i></button>
                                <?php }else{?>
                                <button class="btn add_wrap_pos btn-info remove_section remove_this" type="button"  onclick="delete_others(<?php echo $i;?>,<?php echo $row['qualification_id'];?>)" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fa fa-remove"></i>
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div id="more_others"></div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <button class="btn btn-info btn_save" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
