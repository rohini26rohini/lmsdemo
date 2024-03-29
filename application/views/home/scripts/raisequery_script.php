<script>
    $("#query").validate({
        
        rules: {
            enquiry_name: {
                required: true,
                lettersonly: true
            },
            enquiry_phone: {
                required: true,
                number:true,
				minlength: 10,
				maxlength: 10
            },
            enquiry_email: {
                required: true,
                email:true

            },
            enquiry_location: {
                required: true

            }, 
            enquiry_note: {
                required: true

            }
        },
        messages: {
            enquiry_name: {
                required:"Please Enter the Name",
                lettersonly:"Please enter a valid Name"
            },
            enquiry_phone:{
                required:"Please Enter the Phone Number",
                number:"Please Enter valid Phone Number",
                minlength: "Please enter a 10 digit mobile number",
                maxlength: "Please enter a 10 digit mobile number"
            } ,
            enquiry_email: {
                           required:"Please Enter the Email",
                           email:"Please Enter Valid Email Id"},
            enquiry_location: "Please Enter the Location",
            enquiry_note: "Please Enter the Note"
            
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?php echo base_url();?>Home/enquiry_add',
                type: 'POST',
                data: $("#query").serialize(),
                success: function(response) {
                  if(response == 1)
                      {
                            $("#query")[0].reset();
                         $("#success_msg").css("display","block");
                        
                      }
                    else{
                        $("#error_msg").css("display","block");
                    }
                }
            });

        }
         });
        
</script>
