
    <form id="exam_section<?php echo $section->id; ?>" autocomplete="off" method="post" accept-charset="utf-8">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />       
        <div class="card-body" id="row_block">
            <div class="add_wrap">
                <div class="row">
                    <input type="hidden" name="section_id" value="<?php echo $section->id; ?>" />   
                    <div class="col-xl-8 col-md-8 col-lg-8 col-sm-8 col-12">
                        <div class="form-group">
                            <label>Section Name<span class="mandatory-asterisk">*</span></label>
                            <input value="<?php echo $section->section_name; ?>" name="section_name" placeholder="Section Name" class="form-control" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Duration in minute<span class="mandatory-asterisk">*</span></label>
                            <input onkeypress="return decimalNum(event)" value="<?php echo $section->duration_in_min; ?>" name="duration_in_min" placeholder="Duration in minute" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="add_wrap">
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Subject</label>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label>Module</label>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label>No. of questions<span class="mandatory-asterisk">*</span></label>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label>Mark Distribution<span class="mandatory-asterisk">*</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <?php foreach($details as $detail){ ?>
            <input type="hidden" name="detail_id[]" value="<?php echo $detail->id;?>" />       
            <div class="add_wrap">
                <div class="row">
                    <?php 
                        if(!empty($modules)){
                            foreach($modules as $row){
                                if($row->subject_id == $detail->subject_id){
                                    
                    ?>
                        <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" value="<?php echo $row->subjectName; ?>">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-lg-3 col-sm-3 col-12">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" value="<?php echo $row->subject_name; ?>">
                            </div>
                        </div>
                    <?php 
                                break;}
                            }
                        }
                    ?>
                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                        <div class="form-group">
                            <input onkeypress="return valNum(event)" value="<?php if($detail->no_of_questions){echo $detail->no_of_questions;} ?>" name="number_of_questions[]" placeholder="No. questions" class="form-control" />
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                        <div class="form-group">
                            <div class="input-group input_group_form" style="flex-wrap:nowrap;">
                                <div class="input-group-append ">
                                    <input onkeypress="return decimalNum(event)" value="<?php echo $detail->mark_per_question; ?>" type="text" name="positivemark[]" class="form-control" placeholder="Correct Ans(+)">
                                </div>
                                <div class="input-group-prepend percentageSpan">
                                    <span class="input-group-text">+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-2 col-lg-2 col-sm-2 col-12">
                        <div class="form-group">
                            <div class="input-group input_group_form" style="flex-wrap:nowrap;">
                                <div class="input-group-append ">
                                    <input onkeypress="return decimalNum(event)" value="<?php echo $detail->negative_mark_per_question; ?>" type="text" name="negativemark[]" class="form-control" placeholder="Wrong Ans(-)">
                                </div>
                                <div class="input-group-prepend percentageSpan">
                                    <span class="input-group-text">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <input onkeypress="return decimalNum(event)" value="<?php echo $detail->mark_per_question; ?>" type="text" name="positivemark[]" class="form-control" placeholder="Correct Ans(+)">
                                <input onkeypress="return decimalNum(event)" value="<?php echo $detail->negative_mark_per_question; ?>" type="text" name="negativemark[]" class="form-control" placeholder="Wrong Ans(-)">
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <button class="btn btn-info btn_save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        $("#exam_section<?php echo $section->id; ?>").validate({
            rules: {
                section_name: "required",
                duration_in_min: "required",
                'number_of_questions[]': "required",
                'positivemark[]': "required",
                'negativemark[]': "required"
            },
            messages: {
                section_name: "Please enter the section name",
                duration_in_min: "Please enter the duration in minutes",
                'number_of_questions[]': "Number of question from this module?",
                'positivemark[]': "Please give a positive mark",
                'negativemark[]': "Please give a negative mark"
            },
            submitHandler: function (form) {

                $(".loader").show();
                var validation = 1;
                var number_of_questions = $("input[name='number_of_questions[]']",this).map(function(){return $(this).val();}).get();
                var positivemarks = $("input[name='positivemark[]'",this).map(function(){return $(this).val();}).get();
                var negativemarks = $("input[name='negativemark[]'",this).map(function(){return $(this).val();}).get();
                $.each(positivemarks,function(i,v){
                    if($.trim(v)==''){
                        $.toaster({priority:'danger',title:'Error',message:'Some correct answered mark fields are left blank'});
                        validation = 0;
                        $(".loader").hide();
                        return false;
                    }
                    if($.trim(negativemarks[i])==''){
                        $.toaster({priority:'danger',title:'Error',message:'Some wrong answered mark fields are left blank'});
                        validation = 0;
                        $(".loader").hide();
                        return false;
                    }
                    if($.trim(number_of_questions[i])==''){
                        $.toaster({priority:'danger',title:'Error',message:'Some number of questions fields are left blank'});
                        validation = 0;
                        $(".loader").hide();
                        return false;
                    }
                });
                
                if(validation){
                    $('.btn_save').prop('disabled', true);
                    jQuery.ajax({
                        url: "<?php echo base_url('backoffice/exam/update_section_description'); ?>",
                        type: "post",
                        data: $(form).serialize(),
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (obj.st == 1) {
                                $.toaster({priority:'success',title:'Notice',message:obj.message});
                            }else{
                                $.toaster({priority:'warning',title:'Notice',message:obj.message});
                            }
                            $('.btn_save').prop('disabled', false);
                            $(".loader").hide();
                        },
                        error: function () {
                            $(".loader").hide();
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'danger',title:'Notice',message:'Technical error please try again later'});
                        }
                        //Your code for AJAX Ends
                    });
                }
            }

        });
    </script>
