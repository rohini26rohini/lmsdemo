<script>
    $("#contactus").validate({

        rules: {
            enquiry_name: {
                required: true
            },
            enquiry_phone: {
                required: true, 
                number:true,
                minlength: 10,
                maxlength: 12

            },
            enquiry_email: {
                required: true,
                email:true

            },

        },
        messages: {
            enquiry_name: "Please Enter the Name",
            enquiry_phone:{
                required:"Please Enter the Phone Number",
                number:"Please Enter valid Phone Number",
            } ,
            enquiry_email: {
                           required:"Please Enter the Email",
                           email:"Please Enter Valid Email Id"},



        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>Home/enquiry_add',
                type: 'POST',
                data: $("#contactus").serialize(),
                success: function(response) {
                    // alert(response);
                    if(response == 1){
                        $("#contactus")[0].reset();
                        $.toaster({priority:'success',title:'Success',message:'Submitted Succesfully!'});
                    }
                    else{
                        $.toaster({priority:'danger',title:'Error',message:'Network Error! Please try agin later'});
                    }
                    $(".loader").hide();
                }
            });
        }
         });

</script>
