<script type="text/javascript">
$(document).ready(function () {
	$("#loginform").validate({
		highlight: function(element) {
			$(element).removeClass("error");
		},
		rules: {
			username: "required",
			password: "required"
		},
		messages: {
			username: "Please enter a username",
			password: "Please provide a password"
		},
		submitHandler: function (form) {
			$(".loader").show();
			// alert("don");	   
			jQuery.ajax({
				url: "<?php echo base_url('backoffice/login/authenticate'); ?>",
				type: "post",
				data: $(form).serialize(),
				success: function (data) {
					$(".loader").hide();
					var obj = JSON.parse(data);
					if (obj.st == 1) {
                        // $('#loginform').trigger('reset');
						$.toaster({priority:'success',title:'Success',message:obj.message});
                        window.location.assign(obj.url);
                    }else{
                        $(".loader").hide();
                        // $('#loginsubmit').prop('disabled', false);   
						$.toaster({priority:'danger',title:'Error',message:obj.message});
                    }
				}
			});
		}
	});
	$(".loader").hide();
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
                remote:"This Email Id is not registered / This user is Inactive"
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