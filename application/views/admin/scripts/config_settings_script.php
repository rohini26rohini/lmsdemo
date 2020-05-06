<script>
    $("form#add_config_settings").validate({
        rules: {
            crn:{
                required: true
            },
            gstc:{
                required: true,
                maxlength: 20,
                minlength: 15
            },
            register_mail: {
                required: true,
                email:true,
                emailValidate:true
            },
            payment_mail: {
                required: true,
                email:true,
                emailValidate:true
            },
            callback_mail: {
                required: true,
                email:true,
                emailValidate:true
            },
            gst: {
                required: true
            },
            sgst: {
                required: true
            }
        },
        messages: {
            register_mail:{ 
             required:"Please Enter the Email",
             email:"Please Enter Valid Email Id",
             emailValidate:"Please Enter Valid Email Id",   
            },
            payment_mail: { 
             required:"Please Enter the Email",
             email:"Please Enter Valid Email Id",
             emailValidate:"Please Enter Valid Email Id",   
            },
            callback_mail: { 
             required:"Please Enter the Email",
             email:"Please Enter Valid Email Id",
             emailValidate:"Please Enter Valid Email Id",   
            },
            gst: "Please enter GST",
            sgst: "Please enter SGST"
        },

        submitHandler: function(form) {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Config_settings/add_config_settings',
                type: 'POST',
                data: $("#add_config_settings").serialize(),
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj['st'] == 1) {
                        $.toaster({
                            priority: 'success',
                            title: 'Success',
                            message: obj['msg']
                        });
                    }
                    if (obj['st'] == 0) {
                        $.toaster({
                            priority: 'danger',
                            title: 'Invalid',
                            message: obj['msg']
                        });
                    }
                }
            });
        }
    });

    $("#cessdef").change(function() {
        if($(this).prop('checked')) {
            $('#cesspercntge').show();
        } else {
            $('#cesspercntge').hide();
        }
    });

</script>
