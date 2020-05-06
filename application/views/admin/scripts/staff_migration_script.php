<script>
    var validation=0;
    $("#staffmigration_form").validate({
        rules: {
            question: {
                required: true,
            }
        },
        messages: {
            question: "Please Upload File",
        },
        submitHandler: function(form) {
            $(".loader").show();
                var file=$("#question")[0].files;
                // var files = $('#images')[0].files;
                for(var i = 0; i<file.length; i++){
                    // alert(file[i].name);
                    if(file[i]){
                        var file_size = file[i].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file[i].name.split('.').pop().toLowerCase();
                            if(ext!='xls' && ext!='xlsx' && ext!='csv'){
                                $.toaster({priority:'danger',title:'ERROR',message:'Invalid file format, only xls,xlsx and csv files accepted'});
                                validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            validation = 1;
                        }
                        else{
                            $.toaster({priority:'danger',title:'ERROR',message:'file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>'});
                            $("#image_error").html('<br>One of the file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
        }
    });
    
     $("form#staffmigration_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault()
         //debugger;
            if (validation == 1) 
            {
                 $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Commoncontroller/staff_uploads',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                    if(data.res == 1)
                            {
                                $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                            }
                           else if(data.res == 0)
                            {
                                $.toaster({priority:'warning',title:'ERROR',message:data.row_error});
                            } else if(data.res == 3)
                            {
                                $.toaster({priority:'danger',title:'ERROR',message:'Some thing went wrong'});
                            } 
                            
                        else {
                             $.toaster({priority:'danger',title:'ERROR',message:'It Contains Empty Field(s)/Invalid data'});
                             $("#cell").append(data.html);
                            //  alert(data.html);


                        }
                        $(".loader").hide();
                    }
                });
                
            }
     });
    
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