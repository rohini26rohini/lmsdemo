<script type="text/javascript">
var block = 1;
$(document).ready(function(){

    $("#sectiondefine").validate({
        rules: {
            section_name: "required",
            'subject[]': "required",
            'module[]': "required",
            'positivemark[]': "required",
            'negativemark[]': "required"
        },
        messages: {
            section_name: "Please enter the section name",
            'subject[]': "Please select a subject",
            'module[]': "Please select a module",
            'positivemark[]': "Positive mark required",
            'negativemark[]': "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Negative mark required"
        },
        submitHandler: function (form) {

            $(".loader").show();
            var validation = 1;
            var subjects = $("select[name='subject[]']").map(function(){return $(this).val();}).get();
            var modules = $("select[name='module[]']").map(function(){return $(this).val();}).get();
            var positivemarks = $("input[name='positivemark[]']").map(function(){return $(this).val();}).get();
            var negativemarks = $("input[name='negativemark[]']").map(function(){return $(this).val();}).get();
            $.each(subjects,function(i,v){
                if($.trim(v)==''){
                    $.toaster({priority:'danger',title:'Error',message:'Some subject fields are not selected'});
                    validation = 0;
                    $(".loader").hide();
                    return false;
                }
                if($.trim(modules[i])==''){
                    $.toaster({priority:'danger',title:'Error',message:'Some module fields are not selected'});
                    validation = 0;
                    $(".loader").hide();
                    return false;
                }
                if($.trim(positivemarks[i])==''){
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
            });
            
            if(validation){
                $('.btn_save').prop('disabled', true);
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/save_section_description'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'success',title:'Message',message:obj.message});
                            <?php if(!isset($section)){ ?>
                                $('#sectiondefine').trigger('reset');
                                setTimeout(function(){
                                    redirect('backoffice/exam-section'); 
                                },2000);
                            <?php } ?>
                        }else{
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'danger',title:'Error',message:obj.message});
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $('.btn_save').prop('disabled', false);
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        $(".loader").hide();
                    }
                    //Your code for AJAX Ends
                });
            }
        }

    });

    $(document).on('change', '.subject', function() {
        var id = $(this).attr('id').substr(7);
        var subject_id = $(this).val();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/exam/get_modules'); ?>",
            type: "GET",
            data: {'id':subject_id},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $("#module"+id).html(obj.html);
                    $(".loader").hide();
                }else{
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    });

    $('#add_block').click(function(){
        block++;
        var blockHtml = '<div class="add_wrap" id="block'+block+'">'+
                            '<div class="row">'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">'+
                                    '<div class="form-group">'+
                                        '<select name="subject[]" class="form-control subject" id="subject'+block+'">'+
                                            '<option value="">Select a subject</option>'+
                                            <?php 
                                                if(!empty($subjects)){
                                                    foreach($subjects as $row){
                                            ?>
                                                        '<option value="<?php echo $row['subject_id'];?>"><?php echo $row['subject_name'];?></option>'+
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">'+
                                    '<div class="form-group">'+
                                        '<select name="module[]" class="form-control" id="module'+block+'">'+
                                            '<option value="">Select a subject</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12">'+
                                    '<div class="form-group">'+
                                        '<div class="input-group">'+
                                            '<input type="text" name="positivemark[]" class="form-control" placeholder="Correct Ans(+)">'+
                                            '<input type="text" name="negativemark[]" class="form-control" placeholder="Wrong Ans(-)">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<button type="button" class="btn btn-default add_wrap_pos" onClick="removeBlock('+block+');">'+
                                '<i class="fa fa-minus"></i>'+
                            '</button>'+
                        '</div>';
        $("#row_block").append(blockHtml);
    });
    
});

function removeBlock(block){
    $("#block"+block).remove();
}
            
</script>
     
    