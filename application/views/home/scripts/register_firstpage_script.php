<script>
    var validation=0;
    
    $.validator.addMethod("nospecialChar", function(value, element) {
        return this.optional(element) || /^[a-z0-9-, ]+$/i.test(value);
    }, "name must contain only letters, numbers."); 
    $.validator.addMethod("letters", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "name must contain only letters, space.");
   
    
    
    $("#registration_form").validate({
        
                                rules: {
                                    branch_institute_id:{
                                        required:true, 
                                    },
                                    batch_id:{
                                        required:true, 
                                    },
                                    course_id:{
                                        required:true,
                                    },
                                    gender:{
                                        required:true,
                                    },
                                    name: {
                                        required: true,
                                      letters: true
                                    }, 
                                    blood_group: {
                                        required: true,
                                     
                                    },
                                    address: {
                                        required: true
                                       // nospecialChar: true
                                    },
                                    street: {
                                        required: true
                                        // letters: true
                                    },
                                    state: {
                                        required: true
                                    },
                                    district: {
                                        required: true
                                    },
                                    guardian_number:{
                                         required: true,
                                         number:true,
                                         minlength: 10,
                                         maxlength: 12,
                                    },
                                    contact_number: {
                                        required: true,
                                         number:true,
                                        minlength: 10,
                                        maxlength: 12,
                                        remote: {
                                                    url: '<?php echo base_url();?>Register/contactNumCheck',
                                                    type: 'POST',
                                                    data: {
                                                    whatsapp_number: function() {
                                                          return $("#contact_number").val();
                                                          },
                                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                                        }
                                        }

                                    },
                                    whatsapp_number: {
                                        required: true,
                                         number:true,
                                        minlength: 10,
                                        maxlength: 12,
                                        /* remote: {
                                                    url: '<?php echo base_url();?>Register/whatsappCheck',
                                                    type: 'POST',
                                                    data: {
                                                    whatsapp_number: function() {
                                                          return $( "#whatsapp_number" ).val();
                                                          },
                                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                                        }
                                        }*/

                                    },
                                    mobile_number: {
                                        required: true,
                                        number:true,
                                        minlength: 10,
                                        maxlength: 12,
                                        /*remote: {
                                                    url: '<?php echo base_url();?>Register/mobileCheck',
                                                    type: 'POST',
                                                    data: {
                                                    mobile_number: function() {
                                                          return $( "#mobile_number" ).val();
                                                          },
                                                <?php //echo $this->security->get_csrf_token_name();?>: '<?php //echo $this->security->get_csrf_hash();?>'
                                                        }
                                        }*/

                                    },
                                    email: {
                                        required: true,
                                        emailValidate:true,
                                        remote: {
                                                    url: '<?php echo base_url();?>Register/emailCheck',
                                                    type: 'POST',
                                                    data: {
                                                    email: function() {
                                                          return $( "#email" ).val();
                                                          },
                                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                                        }
                                        }

                                    },
                                    guardian_name: {
                                        required: true,
                                        letters: true

                                    }, 
                                    date_of_birth: {
                                        required: true

                                    }
                                },
                                messages: {

                                    branch_institute_id:{
                                           required:"Please Choose a Branch"
                                    },
                                    batch_id:{
                                           required:"Please Choose a Batch"
                                    },
                                    course_id:{
                                           required:"Please Choose a Course"
                                    },
                                    gender:{
                                           required:"Please Choose a Gender"
                                    },
                                    name:{
                                        required:"Please Enter  Name",
                                      letters:"Please Enter a Valid Name"

                                    } ,
                                    blood_group:{
                                        required:"Please Choose a Blood Group"
                                    },
                                    address:{
                                        required:"Please Enter Address"
                                       // nospecialChar:"Please Enter a Valid Address"
                                    } ,
                                    street: {
                                        required:"Please Enter Street"
                                       // letters:"Please Enter a Valid Street Name"

                                    },
                                    state: "Please Choose a State",
                                    district: "Please Choose a District",
                                    guardian_number:{
                                          required:"Please Enter the Contact Number",
                                          number:"Please Enter valid Contact Number",
                                          minlength: "Please enter a 10 digit mobile number",
                                          maxlength: "Please Enter valid Contact Number",
                                         
                                    } , 
                                    contact_number:{
                                          required:"Please Enter the Contact Number",
                                          number:"Please Enter valid Contact Number",
                                          minlength: "Please enter a 10 digit mobile number",
                                          maxlength: "Please Enter valid Contact Number",
                                          remote:"This Contact Number Already Exist"
                                    } , 
                                    whatsapp_number:{
                                         required:"Please Enter the Whatspp Number",
                                         number:"Please Enter valid Whatspp Number",
                                         minlength: "Please enter a 10 digit mobile number",
                                         maxlength: "Please enter a 12 digit mobile number"
                                         //remote:"This Whatspp Number Already Exist"
                                    } ,
                                    mobile_number:{
                                         required:"Please Enter the Mobile Number",
                                         number:"Please Enter valid Mobile Number",
                                         minlength: "Please enter a 10 digit mobile number",
                                         maxlength: "Please enter a 12 digit mobile number"
                                        // remote:"This Mobile Number Already Exist"
                                    } ,

                                    email: {
                                       required:"Please Enter the Email",
                                       emailValidate:"Please Enter Valid Email Id",
                                       remote:"This Email-Id Already Exist"

                                    },
                                    guardian_name: {
                                        required:"Please Enter Name of Guardian",
                                        letters:"Please Enter a Valid Name"
                                    },
                                    date_of_birth: "Please Choose the Date of Birth"

                                },

                                submitHandler: function(form)
                                {
                        
                                    validation=1;
                                }
         });

     $("form#registration_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
         //debugger;
        // alert(new FormData(this));
        if (validation == 1)
        {
            $(".loader").show();
              $.ajax({
                url: '<?php echo base_url();?>Register/register_second_view',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    $(".loader").hide();
                     validation=0;
                      $("#next_page").html(response);
                     $("#next").focus();
                }
            });
         }
     });


    $("#state").change(function(){
        var state_id=$("#state").val();
             $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>Register/get_district_bystate',
                type: 'POST',
                data: {state_id:state_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                     $(".loader").hide();
                    $("#district").html(response);
                }
            });
    });

   

    $("#contact_number").keyup(function(){
        var contact_num=  $("#contact_number").val();
      // alert(contact_num.length);
       if(contact_num.length >=9){
            $(".loader").show();
             $.ajax({
                    url: '<?php echo base_url();?>Register/check_number',
                    type: 'POST',
                    data: {contact_num:contact_num,
                          <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                    success: function(response)
                    {
                        $(".loader").hide();
                        var obj=JSON.parse(response);
                        if(obj != "")
                        {
                        
                        $("#course").val(obj['course_id']);
                        $("#name").val(obj['name']);
                            if(obj['email_id'] != ""){
                        $("#email").val(obj['email_id']);}
                        $("#whatsapp_number").val(contact_num);
                        $("#mobile_number").val(contact_num);
                        $("#street").val(obj['street']);
                        $("#state").val(obj['state']);
                        $("#district").html(obj['cities']);
                        $("#district").val(obj['district']);
                        $("#course_id").val(obj['course_id']);
                        $("#branch_institute_id").html(obj['branches']);
                        $("#branch_institute_id").val(obj['branch_id']);
                        $("#batch_id").html(obj['batches']);
                       // $("#batch_id").val(obj['batches']);
                        }
                        else{
                             $("#course").val("");
                             $("#name").val("");
                             $("#email").val("");
                             $("#street").val("");
                             $("#whatsapp_number").val(contact_num);
                             $("#mobile_number").val(contact_num);
                        }
                    }
                });
         }

    });


// function'll get branch according to select course
// @params course id
// @author GBS-R
    
$("#course").change(function(){
    
        var course_id =  $(this).val(); //alert(course_id);
     $(".loaderSelect").show();
         $.ajax({
                url: '<?php echo base_url();?>Register/get_branch_by_course_id',
                type: 'POST',
                data: {course_id:course_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                     $(".loaderSelect").hide();
                    if(response!='') {
                        $('#branch_institute_id').html(response);
                        var branch_institute_id = $('#branch_institute_id').val(); //alert(branch_institute_id);
                        $.ajax({
                            url: '<?php echo base_url();?>Register/get_batch_by_insticourse_id',
                            type: 'POST',
                            data: {branch_institute_id:branch_institute_id,
                                  <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                            success: function(response)
                            {
                                if(response!='') {
                                    $('#batch_id').html(response);

                                }
                            } 
                        });
                    }
                } 
            });

    }); 
    
// function'll get batch according to select branch
// @params course center mapp id
// @author GBS-R
    
$("#branch_institute_id").change(function(){
    
        var branch_institute_id =  $(this).val(); //alert(course_id);
     $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>Register/get_batch_by_insticourse_id',
                type: 'POST',
                data: {branch_institute_id:branch_institute_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                     $(".loader").hide();
                    if(response!='') {
                        $('#batch_id').html(response);
                    }
                } 
            });

    }); 
    
    

$(function () {
    $("#file").change(function () { 
     
        $("#dvPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:() ])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) 
        {
            if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) { 
                $("#dvPreview").show();
                $("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this).val();
            }
            else {
                if (typeof (FileReader) != "undefined") {
                    $("#dvPreview").show();
                    $("#dvPreview").append("<img />");
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dvPreview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            }
        } else {
            alert("Please upload a valid image file.");
        }
    });
});
    
         function readURL(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size>2000000){
                    $("#error_msg").css("display","block");
                }else{
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
            }
        }
</script> 
