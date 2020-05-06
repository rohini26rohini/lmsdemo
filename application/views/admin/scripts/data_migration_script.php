<script>
    var validation=0;
    $("#datamigration_form").validate({
        rules: {
            question: {required: true},
            course_id:{required: true},
            branch_id:{required: true},
            center_id:{required: true},
            batch_id:{required: true}
        },
        messages: {
            question: "Please Upload File",
            course_id:"Please Choose Course",
            branch_id:"Please Choose Branch",
            center_id:"Please Choose Centre",
            batch_id:"Please Choose Batch"

            
        },
        submitHandler: function(form) {
            validation=1; 
        }
    });
    
     $("form#datamigration_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault()
         //debugger;
            if (validation == 1) 
            {
                 $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Commoncontroller/excel_uploads',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.res == 1){
                            $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                        }else{
                            $.toaster({priority:'warning',title:'ERROR',message:data.row_error});
                            $("#cell").html(data.html);
                        }
                        $(".loader").hide();
                    }
                });
                
            }
     });
    function get_branch(){
        $("#branch_id").html('');
        $("#center_id").html('');
        $(".loader").show();
        var course_id = $('#course').val();
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_branch_details_cc', 
            type: 'POST',
            data: {course_id:course_id,selected:0,
            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response){
                $(".loader").hide();
                if(response!='') {
                $("#branch_id").html(response);
                } else {
                }
            }
        });
    }

    function get_center(){
        var branch_id = $('#branch_id').val();
        var course_id = $('#course').val();
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_center_details', 
            type: 'POST',
            data: {course_id:course_id,branch_id:branch_id,
            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response)
            {
                $(".loader").hide();
                if(response!='') {
                    var obj = JSON.parse(response);
                    if(obj.data.st=="0") {
                        $("#center_id").html(obj.centers);
                        $("#accordionExample").html(obj.batches);
                        $.toaster({priority:'danger',title:'INVALID',message:obj.data.message});
                    }else {
                        $("#center_id").html(obj.centers);
                        $("#accordionExample").html(obj.batches);

                    }
                }
                else {
                    $("#center_id").html(obj.centers);
                    $("#accordionExample").html(obj.batches);
                }
            }
        });
    }

    function get_batch(){
        var branch_id = $('#branch_id').val();
        var course_id = $('#course').val();
        var center_id = $('#center_id').val();
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_batches_details',
            type: 'POST',
            data: {course_id:course_id,branch_id:branch_id,center_id:center_id,
            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response)
            {
                $(".loader").hide();
                if(response!='') {
                    var obj = JSON.parse(response);
                    if(obj.data.st=="0") {
                        $("#center_id").html(obj.centers);
                        $("#batch_id").html(obj.batches);
                    }else {
                        $("#center_id").html(obj.centers);
                        $("#loadreportview").css("display","none");

                        $("#batch_id").html(obj.batches);
                        $("#loadreportview").css("display","block");


                    }
                }
                else {
                    $("#center_id").html(obj.centers);
                    $("#batch_id").html(obj.batches);

                }
            }
        });
    }
    function readURL(input) {
            /*if (input.files && input.files[0]) {
                if(input.files[0].size>5000000){
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size.' });
                }
                else{
                    var reader = new FileReader();
                reader.onload = function (e) {
                   $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(input.files[0]);
                }
                
            }
        */
         var file = $('input[type="file"]').val();
         var exts = ['xls','xlsx','csv'];
      // first check if file field has any value
       if ( file ) {
        // split file name at dot
        var get_ext = file.split('.');
        // reverse name to check extension
        get_ext = get_ext.reverse();
        // check file type is valid as given in 'exts' array
        if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
        } else {
           $.toaster({ priority : 'danger', title : 'Notice', message : 'The file type you are attempting to upload is not allowed' });
            $('input[type="file"]').val("");
        }
        }
    }

</script>