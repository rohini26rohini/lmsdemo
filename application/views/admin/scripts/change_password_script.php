<script>
   /* $(document).ready(function(){
        alert("jkhj");
});
*/
//change password
    $("#password_form").validate({
        rules: {
           old: {
                required: true, 
               remote: {
                        url: '<?php echo base_url();?>backoffice/Commoncontroller/check_password',
                        type: 'POST',
                        data: {
                        old: function() {
                              return $("#old").val();
                              },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }
            }
            },
            new: {
                required: true
            },
            confirm: {
                required: true,
                equalTo : "#new"
            }
        },
        messages: {
            old: {
                  required:"Please enter old password",
                  remote:"Please Enter the Correct Password"
                 },
            new: "Please enter a new password",
            confirm:{
                  required: "Please re-type your new password",
                   equalTo : " Password Mismatch"

            }
            },

        submitHandler: function(form) {

             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/password_change',
                type: 'POST',
                data: $("#password_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1)
                      {
                         $( '#password_form' ).each(function(){ this.reset();});

                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0)
                    {
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }

                    $(".loader").hide();
                }

            });


        }


    });





</script>
