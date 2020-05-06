<script>
    
    var validation = 0;
    $("form#excelform").validate({
        rules: {
            question_set: {
                            required: true,
                          },
            question: {
                required: true,
                //extension: "pdf|doc|docx"

            }
        },
        messages: {
            question_set:{
               required:"Please select a question set", 
            },
            
            question: {
                required:"Please upload question set",
                //extension:"select valid input file format"
            }
        },

        submitHandler: function(form) {
            $(".loader").show();
            validation = 1;
        }


    });
$("form#excelform").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        if (validation == 1) {
             
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/question_upload',
                type: "post",
                data: new FormData(this),
                beforeSend: function(data) {
                   $(".loader").show();
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if(obj.st == 1)
                        {
                            $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                            $('#excelform').trigger('reset');
                        }
                    else{
                        $.toaster({priority:'danger',title:'Invalid',message:obj.msg}); 
                    } 
                },
                complete: function(data) {
                   $(".loader").hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    });


</script>