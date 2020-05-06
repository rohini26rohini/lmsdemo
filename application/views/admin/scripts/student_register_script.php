<script>
    var fileValidationFlag = 0;
    $("#transport_place").change(function(){
        $("#pmsg").html("");
        $("#stop_msg").html("");
    })
    $("#transport_place").change(function(){
        $("#pmsg").html("");
        $("#stop_msg").html("");
    })
    function please_save()
    {
      $.toaster({priority:'warning',title:'Warning',message:'Please save the hostel details first and then,check the availability'});
    }
    $("#dob").datetimepicker({
        // defaultDate: new Date(),
            format:'DD/MM/YYYY',
            maxDate: new Date(),
            useCurrent:false
    });
    var validation=0;

    $("#personal_form").validate({
            rules: {
            course_id:{
                    required: true,
                },
            gender:{
                    required: true,
                },
            name: {
                required: true,
                letters: true
            },
            address: {
                required: true,
                addressVal: true
            },
            street: {
                required: true,
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
                            url: '<?php echo base_url();?>backoffice/Students/edit_contact_numberCheck',
                            type: 'POST',
                            data: {
                            mobile_number: function() {
                                        return $("#contact_number").val();
                                    },
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>',
                                    student_id: function() {
                                        return $("#student_id").val();
                                    },
                                }
                }

            },
            whatsapp_number: {
                required: true,
                    number:true,
                minlength: 10,
                maxlength: 10,
                    /*remote: {
                            url: '<?php echo base_url();?>backoffice/Students/whatsappCheck',
                            type: 'POST',
                            data: {
                            whatsapp_number: function() {
                                    return $("#whatsapp_number").val();
                                    },
                        <?php //echo $this->security->get_csrf_token_name();?>: '<?php //echo $this->security->get_csrf_hash();?>'
                                }
                }*/

            },
            mobile_number: {
                required: true,
                number:true,
                minlength: 10,
                maxlength: 10,
               /* remote: {
                            url: '<?php echo base_url();?>backoffice/Students/mobileCheck',
                            type: 'POST',
                            data: {
                            mobile_number: function() {
                                    return $("#mobile_number").val();
                                    },
                        <?php //echo $this->security->get_csrf_token_name();?>: '<?php //echo $this->security->get_csrf_hash();?>'
                                }
                }*/

            },
            email: {
                required: true,
                email:true,
                emailValidate:true,
                remote: {
                            url: '<?php echo base_url();?>backoffice/Students/emailCheck_edit',
                            type: 'POST',
                            data: {
                            email: function() {
                                    return $("#email").val();
                                    },
                                student_id: function() {
                                    return $("#student_id").val();
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
            course_id:{
                    required:"Please Choose a Course",
            },
            gender:{
                    required:"Please Choose Gender",
            },
            name:{
                required:"Please Enter  Name",
                letters:"Please Enter a Valid Name"

            } ,
            address:{
                required:"Please Enter Address",
                addressVal:"Please Enter a Valid Address"
            } ,
            street: {
                required:"Please Enter Street",

            },
            state: "Please Choose a State",
            district: "Please Choose a District",
            guardian_number:{
                    required:"Please Enter the Contact Number",
                    number:"Please Enter valid Contact Number",
                   minlength: "Please enter a 10 digit mobile number",
                    maxlength: "Please do not enter morethan 12 digits",
                    
            } ,  contact_number:{
                    required:"Please Enter the Contact Number",
                    number:"Please Enter valid Contact Number",
                   minlength: "Please enter a 10 digit mobile number",
                    maxlength: "Please do not enter morethan 12 digits",
                    remote:"This Contact Number Already Exist"
            } ,
            whatsapp_number:{
                    required:"Please Enter the Whatspp Number",
                    number:"Please Enter valid Whatspp Number",
                    minlength: "Please enter a 10 digit mobile number",
                    maxlength: "Please enter a 10 digit mobile number"
                   /* remote:"This Whatspp Number Already Exist"*/
            } ,
            mobile_number:{
                    required:"Please Enter the Mobile Number",
                    number:"Please Enter valid Mobile Number",
                    minlength: "Please enter a 10 digit mobile number",
                    maxlength: "Please enter a 10 digit mobile number"
                   /* remote:"This Mobile Number Already Exist"*/
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

        submitHandler: function(form)
        {
            validation=1;
        }
    });
    $("form#personal_form").submit(function(e) { 
        //prevent Default functionality
        e.preventDefault();
        //debugger;
        if (validation == 1){  
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/student_register',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    $(".loader").hide();
                    validation=0;
                    var obj=JSON.parse(response);
                    if(obj['st'] == 1){
                        $("#reg1").removeClass("active");
                        $("#reg_1").removeClass("active");//li
                        $("#reg2").removeClass("fade");
                        $("#reg2" ).addClass("active");
                        $("#reg_2" ).addClass("active");
                        $.toaster({priority:'success',title:'SUCCESS',message:'Successfully Updated'});
                    }else{
                        $.toaster({priority:'warning',title:'INVALID',message:'Invalid Request'});
                    }
                }
            });
        }
    });

    
    
    
     $("form#discount_form").submit(function(e) { 
        //prevent Default functionality
        e.preventDefault();
         //debugger;
        var selectedcourse=$("#selectedcourse").val(); 
        var discount_student_id=$("#discount_student_id").val();
        if(selectedcourse!='' && discount_student_id!='') { 
        $(".loader").show();
              $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/student_discount/'+selectedcourse,
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    $(".loader").hide();
                  var obj=JSON.parse(response);
                    if(obj.status)
                        {
                            $(".getbatchfee").click();
//                            $("#reg7").removeClass("active");
//                            $("#reg_7").removeClass("active");//li
//                            $("#reg6").removeClass("fade");
//                            $("#reg6" ).addClass("active");
//                            $("#reg_6" ).addClass("active");
                            $.toaster({priority:'success',title:'SUCCESS',message:obj['message']});
                        }
                    else{
                         $.toaster({priority:'warning',title:'INVALID',message:obj['message']});

                    }
                    
                  
                }
            });
        } else {
            
        }
     });
    
    $(".getfeediscount").click(function(){
       var selectedcourse=$("#selectedcourse").val(); 
        var discount_student_id=$("#discount_student_id").val();
        $(".loader").show();
        if(selectedcourse!='') { 
        $('#student_discount_table').show();
        $('#student_discount_hide').hide();   
        $(".loader").hide();
        } else {
        $('#student_discount_table').hide();
        $('#student_discount_hide').show();    
        $(".loader").hide();   
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
                    $(".loader").hide();
                }
            });
          
    });

    $(document).ready(function(){

        var err_msg = '<?php echo $this->session->userdata('toaster_error') ?>';
        if(err_msg != ""){
            '<?php $this->session->set_userdata('toaster_error', ""); ?>';
            $.toaster({priority:'danger',title:'INVALID',message:err_msg});
        }

        if($(".hostel").prop('checked') == false)
            {
               $(".hostel_sub").hide();
            }



    $(".hostel").click(function(){
       var need_hostel=$('input:radio[name=hostel]:checked').val()
        if($('input:radio[name=hostel]:checked').val()  == "yes")
            {
                 $(".hostel_sub").show();
            }
        else{
             $(".stayed_in_hostel").prop("checked", false);
             $(".food_habit").prop("checked", false);
             $(".hostel_sub").hide();
        }
    });



     $(".transportation").click(function(){
    if($('input:radio[name=transportation]:checked').val()  == "yes")
            {
                 $("#place").show();
                 $("#show_stop").show();
                 $("#start_date").show();
            }
        else{
             //$("#transport_place").val("");
            // $("#stop").val("");
             $("#place").hide();
             $("#show_stop").hide();
             $("#start_date").hide();
        }
    });
        $(".medical_history").click(function(){
         
    if($('input:radio[name=medical_history]:checked').val()  == "yes")
            {
                 $("#med").show();
            }
        else{
             $("#medical_description").val("");
             $("#med").hide();
        }
    });

        // $('#submits').prop('disabled', true);
        // $('#submitted').prop('disabled', false);

        // $('input[type="text"]').on('input change', function() {
        //     if($(this).val() != '') {
        //     $('#submits').prop('disabled', false);
        //     }else{
        //         $('#submits').prop('disabled', true);
        //     }
        // });
        // $('input[type="file"]').on('input change', function() {
        //     if($(this).val() != '') {
        //     $('#submits').prop('disabled', false);
        //     }else{
        //         $('#submits').prop('disabled', true);
        //     }
        // });

        //  $('#submitted').prop('disabled', true);
        // $('input[type="text"]').on('input change', function() {
        //     if($(this).val() != '') {
        //     $('#submitted').prop('disabled', false);
        //     }else{
        //         $('#submitted').prop('disabled', true);
        //     }
        // });
        // $('input[type="file"]').on('input change', function() {
        //     if($(this).val() != '') {
        //     $('#submitted').prop('disabled', false);
        //     }else{
        //         $('#submitted').prop('disabled', true);
        //     }
        // });



// $("#submit").click(function (){
//             //var modelname=$("#inputmodelname").val();
//             for (var i = 0; i < $("#file1").get(0).files.length; ++i) {
//                 var file1=$("#file1").get(0).files[i].name;

//                 if(file1){                        
//                     var file_size=$("#file1").get(0).files[i].size;
//                     if(file_size<2097152){
//                         var ext = file1.split('.').pop().toLowerCase();                            
//                         if($.inArray(ext,['jpg','pdf','doc','docx'])===-1){
//                             alert("Invalid file extension");
//                             return false;
//                         }

//                     }else{
//                         alert("Screenshot size is too large.");
//                         return false;
//                     }                        
//                 }else{
//                     alert("fill all fields..");         
//                     return false;
//                 }
//             }
//         });


});

    $(document).on('click','#add_more', function(e) {
        createNewTextBox();
    });	
	
    $("#syllabus_id").change(function(){
        $(".error_msg_syllabus").text('');
    });
	
  

    function createNewTextBox(){
        var counter = $("#counter").val();
	    counter++;
        $("#counter").val(counter);
        var html = '';
        html +='<div class="row" id="new_textbox' + counter+'">\
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">\
                        <div class="add_wrap" >\
                            <div class="row">\
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >\
                                    <div class="form-group">\
                                        <input type="hidden" name="category[' + counter+']" value="other" />\
                                        <div class="input-group input_group_form">\
                                            <input type="text" class="form-control " placeholder="Additional Qualifications" id="qual" name="qualification[' + counter+']" value=""/>\
                                            <div class="input-group-append percent_box">\
                                                <input type="text" class="form-control numbersOnly" placeholder="" name="marks[' + counter+']" value="" onkeypress="return decimalNum(event);"/>\
                                            </div>\
                                            <div class="input-group-prepend percentageSpan">\
                                                <span class="input-group-text">%</span>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                                <button type="button"  class="btn add_wrap_pos btn-info remove_section remove_this" id="row[' + counter+']" onclick="delete_others('+counter+')"  data-toggle="tooltip" data-placement="top" title="Delete">\
                                    <i class="fa fa-remove"></i>\
                                </button>\
                            </div>\
                        </div>\
                    </div>\
                </div>';

	    $('#more_others').append(html);
        counter++;
    }
    /*function delete_others(counter){
        if(counter==5){
            return false;
        }
        $("#new_textbox" + counter).remove();
    }*/

    // function check_if_exists() {
    //     var qualification = $("#qualification").val();
    //     $.ajax(
    //         {
    //             type:"post",
    //             url: '<?php echo base_url();?>backoffice/Students/filename_exists',
    //             data:{ qualification:qualification},
    //             success:function(response)
    //             {
    //                 if (response == true) 
    //                 {
    //                     $.toaster({priority:'danger',title:'Error',message:'Data Already Exist'});
    //                 }
    //                 else 
    //                 {
    //                     $.toaster({priority:'danger',title:'Error',message:'sdsfsfs'});
    //                 }  
    //             }
    //         });
    // }

    $("#requirement_form").validate({

        rules: {
            hostel: {
                    required: true
                    },
         transportation: {
                    required: true
        }


        },
        messages: {
            hostel: "Please Select an Option",
            transportation:"Please Select an Option"
                 },

        submitHandler: function(form) {
            
            
              var placeValdation=0;
            var place=$("#transport_place").val();
            var stop=$("#stop").val();
            var startdate=$("#trans_start_date").val();
           
                if($('input:radio[name=transportation]:checked').val()  == "yes" && place == "")
                {
                    $("#pmsg").html("Please Choose a Route");
                    $("#stop_msg").html("Please Choose a Boarding Point");
                    $("#start_date_msg").html("Please Select Starting Date");
                    
                }
            else{

                $("#pmsg").html("");
                placeValdation=1;
            } 
              var stopValdation=0;
              var stop=$("#stop").val();

                if($('input:radio[name=transportation]:checked').val()  == "yes"  && stop== "")
                {

                    $("#stop_msg").html("Please Choose a Boarding Point");

                }
            else{

                $("#stop_msg").html("");
                stopValdation=1;
            }
            datevaldation = 0
            if($('input:radio[name=transportation]:checked').val()  == "yes"  && startdate== "")
                {

                    $("#start_date_msg").html("Please Select Starting Date");

                }
            else{

                $("#start_date_msg").html("");
                datevaldation=1;
            }

            var medicalValdation=0;
            var des=$("#medical_description").val();
             //alert(des);
                if($('input:radio[name=medical_history]:checked').val()  == "yes" && des == "")
                {
                    $("#medical_msg").html("Please Enter the description");
                    
                }
            else{

                $("#medical_msg").html("");
                medicalValdation=1;
            }

             var foodhabit_validation=0;
             var foodhabit=$('input:radio[name=food_habit]:checked').val();

                if($('input:radio[name=hostel]:checked').val()  == "yes")
                 {
                     if(foodhabit == "veg" || foodhabit == "nonveg")
                        {

                            $("#foodhabit_msg").html("");
                            foodhabit_validation=1;
                        }

                    else{

                            $("#foodhabit_msg").html("Please choose a food habit");

                        }
                 }
            else{
                  foodhabit_validation=1;
                }


            if(medicalValdation== 1 && placeValdation == 1 && datevaldation == 1 && foodhabit_validation==1 && stopValdation==1) {
              
                        $(".loader").show();
                        $.ajax({
                        url: '<?php echo base_url();?>backoffice/Students/student_register',
                        type: 'POST',
                        data: $("#requirement_form").serialize(),
                        success: function(response) {
                              var obj=JSON.parse(response);
                            if(obj['st'] == 1)
                                {
                                     $("#reg3").removeClass("active");
                                    $("#reg_3").removeClass("active");//li
                                    $("#reg4").removeClass("fade");
                                    $("#reg4" ).addClass("active");
                                    $("#reg_4" ).addClass("active");
                                    $("#please_save").css("display", "none");
                                    $("#show_button").css("display", "block");

                                     $.toaster({priority:'success',title:'SUCCESS',message:'Successfully Updated'});
                                }
                            else{
                                  $.toaster({priority:'warning',title:'ERROR',message:'Error Occured'});
                                //   alert(data.upl_error);

                            }
                         $(".loader").hide();
                        }
                    }); 
            }
        }
         });

 $("#qualification_form").validate({

        submitHandler: function(form)
        {
             $(".loader").show();
              $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/register_student_qualification',
                type: 'POST',
                data:  $("#qualification_form").serialize(),
                success: function(response) {
                    var obj=JSON.parse(response);

                    if(obj['st']== 1)
                        {
                                    $("#reg2").removeClass("active");
                                    $("#reg_2").removeClass("active");//li
                                    $("#reg3").removeClass("fade");
                                    $("#reg3" ).addClass("active");
                                    $("#reg_3" ).addClass("active");
                              $.toaster({priority:'success',title:'SUCCESS',message:'Successfully Updated'});
                              $("#append_document").html(obj['first']);


                        }
                    else{
                       // alert("Error Occured");
                        $.toaster({priority:'warning',title:'WARNING',message:'Invalid data'});
                    }
                $(".loader").hide();
                }
            });
              
        }
         });


// function'll get branch according to course
// @params course id, branch id
// @author GBS-R

     $("#selectedcourse").change(function(){ 
        var course_id=$(this).val();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_branchlistby_course',
                type: 'POST',
                data: {course_id:course_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#branchlist").html(response);
                    $("#selectedbatch").html('');  
                    $("#loadbatchdetails").html('');     
                    } else {
                        $("#selectedbatch").html('');
                        $("#selectedbatch").hide();
                        $.toaster({priority:'danger',title:'Error',message:'Course not scheduled yet!'});
                    }
                }
            });
    });    
    
    
// function'ii get centers according to course and branch
// @params course id, branch id
// @author GBS-R

     $(".centerlist").change(function(){ 
        var course_id=$("#selectedcourse").val();
        var branch_id=$(this).val();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_centerby_coursebranch',
                type: 'POST',
                data: {course_id:course_id,branch_id:branch_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#selectedbatch").show();
                    $("#selectedbatch").html(response);
                    } else {
                        $("#selectedbatch").html('');
                        $("#selectedbatch").hide();
                        $.toaster({priority:'danger',title:'Error',message:'No center assigned for this branch!'});
                    }
                }
            });
    });
    

// function'ii get batch according to course and center
// @params course id, branch id
// @author GBS-R

     $(".batchlist").change(function(){ 
        var center_course_id=$(this).val();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_center_coursebatch',
                type: 'POST',
                data: {center_course_id:center_course_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#loadbatchdetails").html(response);
                    } else {
                        $("#loadbatchdetails").html('No batch available for this course.');
                        //$("#selectedfees").hide();
                        //$.toaster({priority:'danger',title:'Error',message:'No center assigned for this branch!'});
                    }
                }
            });
    });
    
    $(".dicountsave").click(function(){ 
        $.toaster({priority:'success',title:'Warning',message:'Please click save button apply changes!'});
     });
// function'ii implement extra field according to payment mode
// @params payment mode
// @author GBS-R

   
    // function'll save student batch allocation
    // @params course id, branch id, center id batch id
    // @author GBS-R
    
     $("form#batchallocationform").validate({
            rules: {
            selectedcourse: {required: true},
            branch: {required: true},
            center: {required: true},  
            batch: {required: true}       
        },
        messages: {
            selectedcourse: {required:"Please select course"},
            branch: {required:"Please select Branch"},
            center: {required:"Please select Center"},
            batch: {required:"Please select batch"}
        },
        submitHandler: function(form) {
            
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/student_batch_allocationcheck',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#batchallocationform").serialize(),
                success: function(response) { 
                       if(response==2) {
                        $.toaster({priority:'danger',title:'Error',message:'This course already taken!'});
                //     $.confirm({
                //     title: 'Alert message',
                //     content: 'Do you want to change existing course for this student?',
                //     icon: 'fa fa-question-circle',
                //     animation: 'scale',
                //     closeAnimation: 'scale',
                //     opacity: 0.5,
                //     buttons: {
                //         'confirm': {
                //             text: 'Proceed',
                //             btnClass: 'btn-blue',
                //             action: function() {                   
                //                 $.ajax({
                //                             url: '<?php echo base_url();?>backoffice/Students/student_change_batch_allocation',
                //                             type: 'POST',
                //                             data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                //                             data: $("#batchallocationform").serialize(),
                //                             success: function(response) {
                //                                    if(response==1) {
                //                                         $("#reg5").removeClass("active");
                //                                         $("#reg_5").removeClass("active");//li
                //                                         $("#reg7").removeClass("fade");
                //                                         $("#reg7" ).addClass("active");
                //                                         $("#reg_7" ).addClass("active");
                                                    
                //                                        $.toaster({priority:'success',title:'message',message:'Batch allocation successfully completed!'});
                //                                 } else if(response==2){
                //                                         $.toaster({priority:'danger',title:'Error',message:'Maximum number of student allotted in this batch, Please increase batch capacity to accommodate new students!'});
                //                                 } else {
                //                                     $.toaster({priority:'danger',title:'Error',message:'Batch allocation not completed. Please try again!'});
                //                                 }

                //                             }
                //                         });
                                
                //             }
                //         },
                //         cancel: function() {
                            
                //         },
                //     }
                // });
                       } else {
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Students/student_change_batch_allocation',
                                    //url: '<?php echo base_url();?>backoffice/Students/student_batch_allocation',
                                    type: 'POST',
                                    data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                    data: $("#batchallocationform").serialize(),
                                    success: function(response) {
                                           if(response==1) {
                                            //    $("#reg5").removeClass("active");
                                            //     $("#reg_5").removeClass("active");//li
                                            //     $("#reg7").removeClass("fade");
                                            //     $("#reg7" ).addClass("active");
                                            //     $("#reg_7" ).addClass("active");
                                               $.toaster({priority:'success',title:'message',message:'Batch allocation successfully completed!'});
                                        } else if(response==2){
                                                $.toaster({priority:'danger',title:'Error',message:'Maximum number of student allotted in this batch, Please increase batch capacity to accommodate new students!'});
                                        } else {
                                            $.toaster({priority:'danger',title:'Error',message:'Batch allocation not completed. Please try again!'});
                                        }

                                        reload_batch_allocation();

                                    }
                                });
                       }

                }
            });
            
            
        }
    });
    
        // $(".getothers").click(function(){ 
        //     var stud_id = $("#stud_id").val();
        //     var document_name1 = $("#document_name1").val();
        //     var file1 = $("#file1").val();
        //     var document_verification1 = $("#document_verification1").val();
        //     var filter_status = $("#filter_status").val();
        //     $(".loader").show();
        //     $.ajax({
        //         url:"<?php echo base_url(); ?>backoffice/Students/register_student_qualification",
        //         method:"POST",
        //         data:{stud_id:$("#stud_id").val(),document_name1:$("#document_name1").val(),file1:$("#file1").val(),document_verification1:$("#document_verification1").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        //         success:function(response){
        //             if(response!='') {
        //             // $('#result').html(data);
        //             $('#append_document').html(first);
        //             $(".loader").hide();
        //             }
        //         }
        //     })
        // });
    
// function'ii get batch fee
// @params batch id
// @author GBS-R


     $(".getbatchfee").click(function(){ 
         $(".loader").show();
        var student_id      =   $('#student_id').val();
        //var selectedfees    =   $('#selectedfees').val();
         var institute_center_map_id    =   $('#selectedbatch').val(); //var institute_center_map_id    =   $('#institute_center_map_id').val(); //alert(student_id);alert(selectedfees);
         if(student_id !='' && institute_center_map_id != '') {
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_batchfee_view',
                type: 'POST',
                data: {student_id:student_id,institute_center_map_id:institute_center_map_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                        $("#feepayment_form").html(response);
                        $("#firstinstallslct").trigger("click");
                        //$(".receiptbutton").append('<a class="btn btn-info btn_save" id="download_receipt" onclick="download_receipt('+student_id+')">Download Receipt</a>&nbsp;<a href="<?php echo base_url();?>backoffice/student-reseipt" class="btn btn-info btn_save" id="lol">View Receipt</a>');
                        $(".loader").hide();
                    } else {
                        $('#feepayment_form').html('Error while loading fee, PLease try again.')
                    }
                }
            });
         } else {
             $(".loader").hide();
             $('#feepayment_form').html('Please complete batch allocation process before payment.');
         }
    });


    $(".courseallocation").click(function(){ 
         $(".loader").show();
        var student_id      =   $('#student_id').val();
         var institute_center_map_id    =   $('#selectedbatch').val();
         if(student_id !='') {
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_student_course_view',
                type: 'POST',
                data: {student_id:student_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                        $("#append_course").html(response);
                        //$("#firstinstallslct").trigger("click");
                        //$(".receiptbutton").append('<a class="btn btn-info btn_save" id="download_receipt" onclick="download_receipt('+student_id+')">Download Receipt</a>&nbsp;<a href="<?php echo base_url();?>backoffice/student-reseipt" class="btn btn-info btn_save" id="lol">View Receipt</a>');
                        $(".loader").hide();
                    } else {
                        $('#append_course').html('Error while loading course, PLease try again.')
                    }
                }
            });
         } else {
             $(".loader").hide();
             $('#feepayment_form').html('Invalid data.');
         }
    });
    

    // function'll save student batch payment
    // @params post array, student id, batch id
    // @author GBS-R
    
     $("form#feepayment_form").validate({
           
        submitHandler: function(form) {
            $('#paynowbutton').attr("disabled", "disabled");
            $('#allowonlinepayment').attr("disabled", "disabled");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/student_batch_payment',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#feepayment_form").serialize(),
                success: function(response) {
                    $(".loader").hide();
                   var obj=JSON.parse(response);
                    if(obj['status'] == 1)
                    {
                         $('#paynowbutton').attr("disabled", "disabled");
                         $('#allowonlinepayment').hide();
                         $('#paynowbutton').hide();
                         $(".getbatchfee").click();
                         //$("#reg8").click();
//                        $("#reg6").removeClass("active");
//                        $("#reg_6").removeClass("active");
//                        $("#reg8").removeClass("fade");
//                        $("#reg8" ).addClass("active");
//                        $("#reg_8" ).addClass("active");
                        $.toaster({priority:'success',title:'message',message:obj.message});
                    } else {
                        $.toaster({priority:'danger',title:'Error',message:obj.message});
                        $('#paynowbutton').prop('disabled', false);
                        $('#allowonlinepayment').prop('disabled', false);
                    }

                }
            });
        }
    });  
    
    
    // function'll get student batch installment
    // @params post array
    // @author GBS-R
    
      $(".feepayinstallment").click(function () {
         // alert();
			 $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_batchfee_installment',
                type: 'POST',
                data: {student_id:student_id,batch_id:selectedfees,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#feepayment_form").html(response);
                    } else {
                        $('#feepayment_form').html('Error while loading fee, Please try again.')
                    }
                }
            });
    });
    
    
    function feepayinstallment(amount, id) {
        if($('#installmentdis'+id).prop('disabled') == false){
            $(".loader").show();
        $('#loadfeeamt').html('');
        setTimeout(function () {
        if ($("#paymentcheckbox input:checkbox:checked").length > 0) {
            var numberOfChecked = $('.installmentchk:checked').length;
            var totalCheckboxes = $('input:checkbox').length;
            var numberOfChecked = $('input[name="installment[]"]:checked').length;
            var totalCheckboxes = $('input[name="installment[]"]').length;
            var numberNotChecked = totalCheckboxes - numberOfChecked; 
            if(numberNotChecked==0) {
                $('#discountapplyyes').prop('checked', true);
            }
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_batchfee_installment',
                type: 'POST',
                data: $("#feepayment_form").serialize(),
                success: function(response) 
                {
                    $(".loader").hide();
                    if(response!='') {
                    $("#loadfeeamt").html(response);
                    } else {
                        $('#loadfeeamt').html('Error while loading fee, Please try again.')
                    }
                }
            });
        } else {
          $(".loader").hide();    
          $.toaster({ priority : 'danger', title : 'Error', message : 'Please select one installment.' });  
        }
        },2000);
        $(".loader").hide();
        }
    }

    $("#document_qualification").change(function(){
        $("#document_name").val($("#document_qualification").val());
        if($("#document_qualification").val() !=''){
            $("#document_name").prop('readonly','readonly');
        }else{
            $("#document_name").removeAttr('readonly');
        }
    });
    
    var doc_validation=0;
    $("#document_form").validate({
        rules: {   
            // verification: {
            //     required: true
            // },
            // document_name: {
            //     required: true,
            //     // letters: true
            // },
            // file_name:{
            //     required:true
            // }
        },
        messages: {
            // verification: "Is this document verified?",
            // file_name: "Please Choose a document file",
            // document_name:{
            //     required:"Please enter a document name",
            //     // letters:"Please Enter a Valid Name"
            // } 

        },
        submitHandler: function(form) {
            doc_validation=1; 
        }
    });
    
    $("form#document_form").submit(function(e) {
        e.preventDefault();
        if (doc_validation == 1) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/upload_documents',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if(obj.st==1){
                        $(".loader").hide();
                        $("#document_name").removeAttr('readonly');
                        // $("#document_form").trigger("reset");
                        update_document_table($("#student_id").val());
                                //    $("#reg4").removeClass("active");
                                //     $("#reg_4").removeClass("active");//li
                                    // $("#reg5").removeClass("fade");
                                    // $("#reg5" ).addClass("active");
                                    // $("#reg_5" ).addClass("active");
                        $.toaster({ priority : 'success', title : 'Notice', message : obj.message });
                    }else{
                        $(".loader").hide();
                        $.toaster({ priority : 'danger', title : 'Notice', message : obj.message });
                    }
                }
            });
       }
    });



      var doc1_validation=0;
      var error = 0;

    $("#all_qualification_form").validate({
        onfocusout: function(e) {
        this.element(e);
    },
        rules: {   
            // 'verification1[]': {
            //     required: true
            // },
            // 'document_name1[]': {
            //     required: true,
            //     // letters: true
            // },
            // 'file_name1[]':{
            //     extension: "docx|jpg|doc|pdf"
            // }
        },
        messages: {
            // 'verification1[]': {
            //     required:"Is this document verified?"
            // },
            // 'document_name1[]':{
            //     required:"Please enter a document name"
            //     // letters:"Please Enter a Valid Name"
            // },
            // 'file_name1[]': {
            //     extension:"select valied input file format"
            //     }

        },
        submitHandler: function(form) {
            doc1_validation=1; 
            
                
        }
    });
    
    // $("form#all_qualification_form").submit(function(e) {
    //     e.preventDefault();
    //     if (doc1_validation == "1" /*&& error== "0"*/) {
    //         $(".loader").show();
    //         $.ajax({
    //             url: '<?php echo base_url();?>backoffice/Students/upload_documents_action',
    //             type:'POST',
    //             data: new FormData(this),
    //             processData: false,
    //             contentType: false,
    //             success: function(response) {
    //                 var obj = JSON.parse(response);
    //                 if(obj.st==1){
    //                     $(".loader").hide();
    //                     $("#document_name1").removeAttr('readonly');
    //                     $("#all_qualification_form").trigger("reset");
    //                     update_document_table($("#stud_id").val());
    //                                 // $("#reg4").removeClass("active");
    //                                 // $("#reg_4").removeClass("active");//li
    //                                 // $("#reg5").removeClass("fade");
    //                                 // $("#reg5" ).addClass("active");
    //                                 // $("#reg_5" ).addClass("active");
    //                                 $("#append_document").html(obj['first']);
    //                     $.toaster({ priority : 'success', title : 'Success', message : 'Successfully saved' });
    //                 }else if(obj.st == "2"){
    //                     $.toaster({priority:'danger',title:'INVALID',message:obj.message});
    //                 }
    //                 else if(obj.st == "3"){alert();
    //                     $.toaster({ priority : 'danger', title : 'INVALID', message : obj.message });
    //                 }
    //                 else if(obj.st == "5"){
    //                     $.toaster({priority:'danger',title:'INVALID',message:"Please select a file"});
    //                 }
    //                 else if(obj.st == "0"){
    //                     $.toaster({ priority : 'danger', title : 'INVALID', message : obj.message });
    //                 } else if(obj.st == "6"
    //                          ){
    //                     $.toaster({ priority : 'danger', title : 'Verify', message : obj.message });
    //                 }
    //                 $(".loader").hide();

    //             }
    //         });
    //    }
    // });
     
    function all_qualification_form(){
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/upload_documents_action',
                type:'POST',
                // data: new FormData($("form#all_qualification_form").serialize()),
                data: new FormData(document.getElementById("all_qualification_form")),
                processData: false,
                contentType: false,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if(obj.st==1){
                        $(".loader").hide();
                        $("#document_name1").removeAttr('readonly');
                        $("#all_qualification_form").trigger("reset");
                        update_document_table($("#stud_id").val());
                                    // $("#reg4").removeClass("active");
                                    // $("#reg_4").removeClass("active");//li
                                    // $("#reg5").removeClass("fade");
                                    // $("#reg5" ).addClass("active");
                                    // $("#reg_5" ).addClass("active");
                                    $("#append_document").html(obj['first']);
                        $.toaster({ priority : 'success', title : 'Success', message : 'Successfully saved' });
                    }else if(obj.st == "2"){
                        $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if(obj.st == "3"){alert();
                        $.toaster({ priority : 'danger', title : 'INVALID', message : obj.message });
                    }
                    else if(obj.st == "5"){
                        $.toaster({priority:'danger',title:'INVALID',message:"Please select a file"});
                    }
                    else if(obj.st == "0"){
                        $.toaster({ priority : 'danger', title : 'INVALID', message : obj.message });
                    } else if(obj.st == "6"
                             ){
                        $.toaster({ priority : 'danger', title : 'Verify', message : obj.message });
                    }
                    $(".loader").hide();

                }
            });
    }
    
    function delete_fromtable(id){

        $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Students/delete_student_document',
                                    type:'POST',
                                    data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                    success: function(response) {
                                        $("#row_"+id).remove();
                                        $(".loader").hide();
                                        $.toaster({ priority : 'success', title : 'Success', message : 'Document deleted' });
                                    }
                            });
                        }
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    // function upload_file(){
    //     // $.each(fileids, function( e, val ) {
    //                 //if(val!=-1){
    //                     var ext = $('#file1').val().split('.').pop().toLowerCase();
    //                     if(ext){
    //                         $('.doc_upload').html('');
    //                         if($.inArray(ext, ['pdf','doc','jpg','docx']) == -1) {
    //                             $.toaster({ priority : 'success', title : 'INVALID', message : 'File not recognized. Only Pdf files are accepted' });
    //                             $(".loader").hide();
    //                             error = 1;	
    //                         }
    //                         var fileSize = ($('#file1')[0].files[0].size / 1024 / 1024); //size in MB
    //                         if (fileSize > <?php echo FILE_MAX_SIZE;?>) {
    //                             $.toaster({ priority : 'success', title : 'INVALID', message : 'File too large maximum size to upload is 10MB' });
    //                             $(".loader").hide();
    //                             error = 1;		
    //                         }
    //                     }

    //                // }
    //             // });
    //             if(error){return false;}
    // }
    
    // });

//    function fileValidation(){ 
//     var fileInput = document.getElementById('file1');
//     var filePath = fileInput.value;
//     var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg)$/i;
//     if(!allowedExtensions.exec(filePath)){
//         $.toaster({priority:'danger',title:'INVALID',message:"invalid type"});
//         fileInput.value = '';
//         return false;
//     }else{
//         $.toaster({priority:'success',title:'Success',message:"valid type"});

//     }
// }


// if($('#file1').val() != '') {            
//       $.each($('#file1').prop("files"), function(k,v){
//           var filename = v['name'];    
//           var ext = filename.split('.').pop().toLowerCase();
//           if($.inArray(ext, ['pdf','doc','docx','jpg']) == -1) {
//               alert('Please upload only pdf,doc,docx format files.');
//               return false;
//           }
//       });        
// }


// var selection = document.getElementById('file');
// for (var i=0; i<selection.files.length; i++) {
//     var ext = selection.files[i].name.substr(-3);
//     if(ext!== "pdf" && ext!== "doc" && ext!== "docx")  {
//         alert('not an accepted file extension');
//         return false;
//     }
// } 
    
// $('.myFile').bind('change', function() {

//   //this.files[0].size gets the size of your file.
//     //alert(this.files[0].size);
//     var size = this.files[0].size/1024;
//     if(size><?php echo FILE_MAX_SIZE;?>) {
//         $.toaster({priority:'danger',title:'INVALID',message:"The file you are attempting to upload is larger than the permitted size."});
//         $(this).val('');
//     }

// });    

// function validate(file) {
//     var ext = file.split(".");
//     ext = ext[ext.length-1].toLowerCase();
//     var arrayExtensions = ["jpg" , "pdf", "docx", "doc","jpeg"];

//     if (arrayExtensions.lastIndexOf(ext) == -1) {
//         $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size or Unsupported file format' });
//         $(".doc_upload").html("");
//         // $('#submit').prop('disabled', false);
//     }
// }
$('.myFile').bind('change', function() {

//this.files[0].size gets the size of your file.
  // alert(this.files[0].size);
//   if(fileValidationFlag == 0){
      var size = this.files[0].size/1024;
      if(size><?php echo FILE_MAX_SIZE;?>) {
          $.toaster({priority:'danger',title:'INVALID',message:"The file you are attempting to upload is larger than the permitted size."});
          $(this).val('');
          fileValidationFlag = 1;
      }
//   }
});    

function validate(file) {
  var ext = file[0].name.split(".");
  var size = file[0].size/1024;
  // alert(file[0].name)
  ext = ext[ext.length-1].toLowerCase();
  var arrayExtensions = ["jpg" , "pdf", "docx", "doc","jpeg"];

  if (arrayExtensions.lastIndexOf(ext) == -1) {
      $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size or Unsupported file format' });
      $(".doc_upload").html("");
      // $('#submit').prop('disabled', false);
  }
//   if(fileValidationFlag == 0){
      if(size><?php echo FILE_MAX_SIZE;?>) {
          $.toaster({priority:'danger',title:'INVALID',message:"The file you are attempting to upload is larger than the permitted size."});
          $('.myFile').val('');
          fileValidationFlag = 1;
      }
//   }
  
}

    function verify_document(id){
        $.confirm({
            title: 'Alert message',
            content: 'Change verification status of this document?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Students/verify_document',
                                    type:'POST',
                                    data: {id:id,status:1,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                    success: function(response) {
                                        $(".loader").hide();
                                        $.toaster({ priority : 'warning', title : 'Notice', message : 'Status Changed' });
                                    }
                            });
                        }
                    }
                },
                cancel: function() {
                    update_document_table($("#student_id").val());
                },
            }
        });
    }

    function unverify_document(id){
        $.confirm({
            title: 'Alert message',
            content: 'Change verification status of this document?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Students/verify_document',
                                    type:'POST',
                                    data: {id:id,status:0,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                    success: function(response) {
                                        $(".loader").hide();
                                        $.toaster({ priority : 'warning', title : 'Notice', message : 'Status Changed' });
                                    }
                            });
                        }
                    }
                },
                cancel: function() {
                    update_document_table($("#student_id").val());
                },
            }
        });
    }

    function edit_document(id){
        $(".loader").show();
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_student_document',
                type:'POST',
                data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#document_qualification").val(obj.qualification).prop('selected','selected');
                    $("#document_name").val(obj.document_name);
                    $("#document_verification").val(obj.verification).prop('selected','selected');
                    $("#document_name1").val(obj.document_name);
                    $("#document_verification1").val(obj.verification).prop('selected','selected');
                    $("#document_id").val(obj.student_documents_id);
                    $("#document_file").prop('disabled','false');
                    $("#document_file").val(obj.file);
                    $(".loader").hide();
                }
        });
    }

    function update_document_table(student_id){
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_student_documents',
                type:'POST',
                data: {id:student_id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(data) {
                    $("#student_document_table").html(data);
                }
        });
    }
    
    $("#add_block2").click(function () {
        //var html=''
    });
    
    //mark validation
    $(document).ready(function(){
                   $("#sslc_mark").keyup(function(){
                      var num=$("#sslc_mark").val();
                    if(num > 100)
                        {
                            $("#sslc_mark").val("");
                            $("#sslc_mark_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#sslc_mark_msg").html("");
                        }        
                }); 
                $("#plustwo_mark").keyup(function(){
                      var num=$("#plustwo_mark").val();
                    if(num > 100)
                        {
                            $("#plustwo_mark").val("");
                            $("#plustwo_mark_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#plustwo_mark_msg").html("");
                        }        
                });

                $("#degree_mark").keyup(function(){
                      var num=$("#degree_mark").val();
                    if(num > 100)
                        {
                            $("#degree_mark").val("");
                            $("#degree_mark_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#degree_mark_msg").html("");
                        }        
                }); 

                $("#pg_m").keyup(function(){
                      var num=$("#pg_m").val();
                    if(num > 100)
                        {
                            $("#pg_m").val("");
                            $("#pg_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#pg_msg").html("");
                        }        
                });
                $("#pg_mark").keyup(function(){
                      var num=$("#pg_mark").val();
                    if(num > 100)
                        {
                            $("#pg_mark").val("");
                            $("#pg_mark_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#pg_mark_msg").html("");
                        }          
                });

 $("form#addnewsourse").validate({
            rules: {
                selectedcourse: {required: true}
        },
        messages: {
            selectedcourse: {required:"Please select course"}
        },
        submitHandler: function(form) {            
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/student_batch_allocationcheck',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#batchallocationform").serialize(),
                success: function(response) { 
                       }
            });
            
            
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
        //  alert("Please upload a valid image file.");
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
                   $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(input.files[0]);
                }
                
            }
        }

        function checktype(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size>1000000){
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size.' });
                }else{
                    var reader = new FileReader();
                reader.onload = function (e) {
                   $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(input.files[0]);
                }
                
            }
        }

        function readURL1(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size>5000000){
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size.' });
                }else{
                    var reader = new FileReader();
                reader.onload = function (e) {
                   $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(input.files[0]);
                }
                
            }
        }

    // function delete_others(counter){
    //     if(counter==1){
    //         return false;
    //     }
    //     $("#new_textbox" + counter).remove();
    // }





        function delete_others(counter,id) {
            $.confirm({
                title: 'Alert message',
                content: 'Do you want to remove this Information?',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function() {
                        if(id!=""){
                            $.post('<?php echo base_url();?>backoffice/Students/delete_others/', {
                                counter:counter,
                                id: id,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }, function(data) {

                                if (data == 1) {
                                
                                     $.toaster({ priority : 'success', title : 'Success', message : 'Successfully Deleted..!' });
                                    $("#new_textbox" + counter).remove();
                                    $("#row_"+id).remove();
                                }
                            });
                        }else{
                            $.alert('Successfully <strong>Deleted..!</strong>');
                            $("#new_textbox" + counter).remove();
                            $("#row_"+id).remove();
                        }
                            
                        }
                    },
                    cancel: function() {
                    },
                }
            });
        }

     

$("#reg_8").click(function(){
    $("#loader").show();
    $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/get_student_idcard_preview/<?php echo $studentArr['student_id'];?>',
            type:'POST',
            data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(data) {
                var obj = JSON.parse(data);
                $("#reg8").html(obj.html);
                $("#loader").hide();
            }
    });
});
 $("#loader").hide();


     $("#transport_place").change(function(){
        var route_id=$(this).val();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_stop_by_routeid',
                type: 'POST',
                data: {id:route_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response){
                    var obj=JSON.parse(response);
                    if(obj.html != ''){
                        showfire(obj.id);
                    }
                    $("#stop").html(obj.html);
                }
            });
    });
    function showfire(stop_id){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/get_fare_byStopId',
            type: 'POST',
            data: {id:stop_id,
                  <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj=JSON.parse(response);
                $("#show_fare").html("Fare : "+obj['fare']);
            }
        });
    }
   
    function download_receipt(id, insti_course_mid, install_id = NULL, payment_id = 0){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Receipt/download_receipt/'+id+'/'+insti_course_mid+'/'+install_id+'/'+payment_id,
            type: 'POST',
            data: {
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    window.open(obj.url);
                    $(".loader").hide();
                }
                $(".loader").hide();
            }
        });
    }


    function download_splitreceipt(id, insti_course_mid, install_id = NULL, payment_id = 0, split = 0){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Receipt/download_splitreceipt/'+id+'/'+insti_course_mid+'/'+install_id+'/'+payment_id+'/'+split,
            type: 'POST',
            data: {
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    window.open(obj.url);
                    $(".loader").hide();
                }
                $(".loader").hide();
            }
        });
    }




    function reload_batch_allocation() {
        var selectedbatch = $("input[name='batch']:checked").val(); //alert(selectedbatch);
        var center_course_id=$('#selectedbatch').val();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_center_coursebatch',
                type: 'POST',
                data: {center_course_id:center_course_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#loadbatchdetails").html(response);
                    $("input[name=batch][value=" + selectedbatch + "]").prop('checked', true);
                    } else {
                        //$("#loadbatchdetails").html('No batch available for this course.');
                        //$("#selectedfees").hide();
                        //$.toaster({priority:'danger',title:'Error',message:'No center assigned for this branch!'});
                    }
                }
            });
    }

</script>
