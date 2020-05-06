<script type="text/javascript">
$(document).ready(function () {
	var add_validation = 0;
	$("#applay_form").validate({
		highlight: function(element) {
			$(element).removeClass("error");
		},
		rules: {
			name: {required:true},
			email: {required:true,
					emailValidate:true},
			phone: {required: true,
                    number:true,
                    minlength: 10,
                    maxlength: 12},
			resume: {required: true}
			},
		messages: {
			name: "Please enter a name",
			email:{
                required:"Please Enter a Verified Email Id",
                emailValidate:"Please Enter a valid Email Id"
            },
			phone:{
                required:"Please Enter the Mobile Number",
                number:"Please Enter valid Mobile Number",
                minlength: "Please enter a 10 digit mobile number",
                maxlength: "Please enter a 12 digit mobile number"
            },
			resume:{
                required:"Please select your resume"
            }
		},
		submitHandler: function (form) {
			$(".loader").show();
			$("#resume_error").empty();
            var file=$("#resume").get(0).files[0].name;
            if(file){
                var file_size = $("#resume").get(0).files[0].size/1024;
                if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                    var ext = file.split('.').pop().toLowerCase();
                    if(ext != 'pdf' && ext != 'doc'){
                        $("#resume_error").html('<br>Invalid file format, only pdf and doc file format supported.');
                        add_validation = 0;
                        $(".loader").hide();
                        return;
                    }
                    add_validation = 1;
                }else{ 
                    $("#resume_error").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                    add_validation = 0;
                    $(".loader").hide();
                    return;
                }
            }
		}
	});
	$("form#applay_form").submit(function(e) {
    //prevent Default functionality
    	e.preventDefault();
    	// alert(add_validation);
    	if (add_validation == 1) {
    	$.ajax({
    	        url: '<?php echo base_url();?>Home/career_apply',  
    	        type: 'POST',
    	        data: new FormData(this),
    	        success: function(response) {
    	            // alert(response);
    	            $('#apply').modal('toggle');
					$(".loader").hide();
					$("#applay_form")[0].reset();
    	            var obj = JSON.parse(response);
    	            if(obj.st == 1){
    	                $.toaster({priority:'success',title:'Success',message:obj.msg})
    	            }else if(obj.st == 2){
    	                $.toaster({priority:'warning',title:'Warning',message:obj.msg});
    	            }else{
    	                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
    	            }
    	        },
    	        cache: false,
    	        contentType: false,
    	        processData: false
    	    });
    	}
	});
});
$(document).on('click', '#btn_apply', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    $('#career_id').val(id);
  });



$.validator.addMethod("emailValidate", function(value, element) {
        //return this.optional(element) || /^[a-z0-9-.@]+$/i.test(value);
        return this.optional(element) || /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{0,9})$/i.test(value);
	}, "name must contain only letters, numbers and .");
	
	
$("#forgot_form").validate({
		highlight: function(element) {
			$(element).removeClass("error");
		},
		rules: {
			email: {
                required:true,
                emailValidate:true,
                 remote: {
                        url: '<?php echo base_url();?>backoffice/Login/emailCheck',
                        type: 'POST',
                        data: {
                        email: function() {
                              return $("#forgot_email").val();
                              },
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }
                    }
            },
           			
		},
		messages: {
			email:{
                required:"Please Enter a Verified Email Id",
                emailValidate:"Please Enter a valid Email Id",
                remote:"This Email Id is not registered"
            } ,
		},
		submitHandler: function (form) {
			$("#forgot_submit").prop('disabled',true); 
			$(".loader").show();	   
			jQuery.ajax({
				url: "<?php echo base_url('backoffice/Login/forgot_password'); ?>",
				type: "post",
				data: $("#forgot_form").serialize(),
				success: function (data) {
					$(".loader").hide();
					var obj = JSON.parse(data);
					if (obj.st == 1) {
						$("#Forgot").modal('hide');
						$('#forgot_form').trigger('reset');
						$.toaster({priority:'success',title:'Success',message:obj.message});
                    }else{  
						$.toaster({priority:'danger',title:'Error',message:obj.message});
					}
					return false;
				}
				//Your code for AJAX Ends
			});
		}
	});
</script>