<script>
    var validation=0;
    $("#personal_form").validate({
        rules: {
            name:   { required: true, letters: true },
            course_id: { required: true },
            gender: { required: true },
            blood_group: { required: true },
            address: { required: true, addressVal: true },
            street: { required: true },
            state: { required: true },
            district: { required: true },
            guardian_number:{ required: true, number:true, maxlength: 12 },
            contact_number: { required: true, number:true,maxlength: 12,
                              remote: {
                                        url: '<?php echo base_url();?>backoffice/Students/contact_numberCheck',
                                        type: 'POST',
                                        data: { whatsapp_number: function() {
                                                   return $("#contact_number").val();
                                                },<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                            }
                                    }
                            },
            mobile_number: { required: true, number:true,maxlength: 12,
              remote: {
                        url: '<?php echo base_url();?>backoffice/Students/contact_numberCheck',
                        type: 'POST',
                        data: { whatsapp_number: function() {
                                   return $("#contact_number").val();
                                },<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }
                    }
            },
            whatsapp_number: {  required: true, number:true, minlength: 10, maxlength: 10 },
            email: { required: true, email:true, emailValidate:true,
                    remote: {
                        url: '<?php echo base_url();?>backoffice/Students/emailCheck',
                        type: 'POST',
                        data: {
                            email: function() {
                                  return $("#email").val();
                            }, <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }
                    }
                    },
            guardian_name: { required: true, letters: true },
            date_of_birth: { required: true }
        },
        messages: {
            name:{
                required:"Please Enter  Name",
                letters:"Please Enter a Valid Name"
            } ,
            course_id:{
                required:"Please Choose  a Course"
            } ,
            blood_group:{
                required:"Please Choose a  Blood group"
            } ,
            gender:{
                required:"Please Choose a  Gender"
            } ,
            address:{
                required:"Please Enter Address",
                addressVal:"Please Enter a Valid Address"
            } ,
            street: {
                required:"Please Enter Street",
                // letters:"Please Enter a Valid Street Name"
            },
            state: "Please Choose a State",
            district: "Please Choose a District",
            guardian_number:{
                required:"Please Enter the Contact Number",
                number:"Please Enter valid Contact Number",
                maxlength: "Please donot enter more than 12 digits"
            },
            contact_number:{
                required:"Please Enter the Contact Number",
                number:"Please Enter valid Contact Number",
                 // minlength: "Please enter a 10 digit mobile number",
                maxlength: "Please donot enter morethan 12 digits",
                remote:"This Contact Number Already Exist"
            } ,
            mobile_number:{
                required:"Please Enter the Mobile Number",
                number:"Please Enter valid Mobile Number",
                 // minlength: "Please enter a 10 digit mobile number",
                maxlength: "Please donot enter morethan 12 digits",
                remote:"This Mobile Number Already Exist"
            } ,
            whatsapp_number:{
                required:"Please Enter the Whatspp Number",
                number:"Please Enter valid Whatspp Number",
                minlength: "Please enter a 10 digit mobile number",
                maxlength: "Please enter a 10 digit mobile number"
                // remote:"Thsis Whatspp Number Already Exist"
            } ,
            mobile_number:{
                required:"Please Enter the Mobile Number",
                number:"Please Enter valid Mobile Number",
                minlength: "Please enter a 10 digit mobile number",
                maxlength: "Please enter a 10 digit mobile number"
                //remote:"This Mobile Number Already Exist"
            } ,
            email: {
                required:"Please Enter the Email",
                email:"Please Enter Valid Email Id",
                emailValidate:"Please Enter Valid Email Id",
                remote:"This Email-Id Already Exist"
            },
            guardian_name: {
                required:"Please Enter Name of Guardian",
                letters:"Please Enter a Valid Name"
            },
            date_of_birth: "Please Choose the Date of Birth"
        }, 
        submitHandler: function(form) {
            $('#submitstudent').attr("disabled", "disabled");
            $(".loader").show();
            validation=1;
            //  $('form#personal_form').submit();
        }
    });            
    $("form#personal_form").submit(function(e) {
        //alert("klj");
        //prevent Default functionality
        e.preventDefault();
        // debugger;
        if (validation == 1) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/register-student',
                type: "post",
                data: new FormData(this),
                beforeSend: function(data) {
                    // Show image container
                },
                success: function(data) {
                    validation = 0;
                    $(".loader").hide();
                    var obj=JSON.parse(data);
                    // alert(data);
                    if(obj['st'] == 11){
                        $.toaster({ priority : 'success', title : 'Success', message : 'Student personal details saved successfully' });
                        window.location.href = "<?php echo base_url().'backoffice/manage-students/';?>"+obj['message'];
                    } else if(obj['st'] == 0) {
                       $.toaster({priority:'warning',title:obj['message'],message:'' });  
                    } 
                    if(obj['st'] == 2)
                    {
                       $.toaster({priority:'warning',title:'Invalid',message:obj['message'] });  
                    }
                },
                complete: function(data) {
                    // Hide image container
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });



    $("#state").change(function(){
        var state_id=$("#state").val();
		$(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_district_bystate',
                type: 'POST',
                data: {state_id:state_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $("#district").html(response);
                }
            });
		$(".loader").hide();
    });

$("#contact_number").keyup(function(){
        var contact_num=  $("#contact_number").val();
       // alert(contact_num);
     if(contact_num.length >=9){
                 $.ajax({
                        url: '<?php echo base_url();?>backoffice/Students/check_number',
                        type: 'POST',
                        data: {contact_num:contact_num,
                              <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                        success: function(response)
                        {
                            //alert(response);
                            var obj=JSON.parse(response);
                            if(obj !=""){
                                $("#course").val(obj['course_id']);
                                $("#name").val(obj['name']);
                                $("#email").val(obj['email_id']);
                                $("#whatsapp_number").val(obj['father_mobile']);
                                $("#mobile_number").val(obj['mother_mobile']);
                                $("#street").val(obj['place']);
                                $("#state").val(obj['state']);
                                $("#district").html(obj['cities']);
                                $("#district").val(obj['district']);
                                $("#street").val(obj['street']);
                            }
                            else{
                                $("#whatsapp_number").val(contact_num);
                                $("#mobile_number").val(contact_num);
                                $("#course").val("");
                                $("#name").val("");
                                $("#email").val("");
                                $("#street").val("");
                            }
                        }
                    });
        }

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
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size.' });
                }else{
                var reader = new FileReader();
                reader.onload = function (e) {
                    //$('#blah').css('background-image', e.target.result);
                    $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };

                reader.readAsDataURL(input.files[0]);
            }
            }
        }
    
    

</script>
