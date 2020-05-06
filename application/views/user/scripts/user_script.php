<script>  
function submitForm(id){
    $("#examlist"+id).validate({
        submitHandler: function(form) {
            $(".loader").show();
            if($('#hltText'+id).val() != ''){
                $.ajax({
                    url: '<?php echo base_url();?>user/Student/halltkt_add/'+id,
                    type: 'POST',
                    data: $("#examlist"+id).serialize(),
                    success: function(response) {
                    console.log(response);
                    if(response == 1){
                            //$("#examlist"+id)[0].reset();
                            $.toaster({priority:'success',title:'Success',message:'Submitted Succesfully!'});
                        }
                        else if(response == 2){
                            $.toaster({priority:'danger',title:'Error',message:"Hall ticket already exists."});
                        }  else {
                            $.toaster({priority:'danger',title:'Error',message:'Network Error! Please try agin later'});
                        }
                        $(".loader").hide();
                    }
                });
            }else{
                $.toaster({priority:'danger',title:'Error',message:"Please Enter Hall Ticket Number..!"});
                $(".loader").hide();
            }
        }
    });
}

// $(document).ready(function() {
//     // alert($('#test').attr('id'));
//     $(".form-submit").click(function() {
//         // assuming the button is actually inside its associated form:
//         var parentFormID = $(this).closest("form").attr("id");
//          alert(parentFormID);
//     });
// }); 
    // $(".examlist").validate({
    //     submitHandler: function(form) {
    //         var form = $(this);
    //         alert(this.id);
    //         var id = form.attr('id');
    //         // alert(id);
    //         // $.ajax({
    //         //     url: '<?php echo base_url();?>user/Student/halltkt_add',
    //         //     type: 'POST',
    //         //     data: $(".examlist").serialize(),
    //         //     success: function(response) {
    //         //     if(response == "1")
    //         //         {
    //         //              $(".examlist")[0].reset();
    //         //             $("#success_msg").css("display","block");
    //         //         }
    //         //         else if(response == "2"){
    //         //             $("#error_msg").css("display","block");
    //         //         }
    //         //     }
    //         // });
    //     }
    // });

// function submitForm(id){
//         $("#edit_examlist").validate({
//         submitHandler: function(form) {
//             $.ajax({
//                 url: '<?php echo base_url();?>user/Student/halltkt_edit/'+id,
//                 type: 'POST',
//                 data: $("#edit_examlist").serialize(),
//                 success: function(response) {
//                     // var obj = JSON.parse(response);
//                     // $("#edit_bus_id").val(obj.bus_id);
//                     // $("#edit_vehicle_number").val(obj.vehicle_number);
//                     // $("#edit_vehicle_made").val(obj.vehicle_made);
//                 if(response == 1)
//                     {
//                         // $("#edit_examlist")[0].reset();
//                         $("#success_msg").css("display","block");
//                     }
//                     else{
//                         $("#error_msg").css("display","block");
//                     }
                    
//                 }
//             });
//         }
//     });
// }
  $("#onlinepayform").validate({

        submitHandler: function(form)
        {
             $(".loader").show();
              $.ajax({
                url: '<?php echo base_url();?>user/User/payment_update',  
                type: 'POST',
                data:  $("#onlinepayform").serialize(),
                success: function(response) {
                   var obj=JSON.parse(response);
                    if(obj['response_code'] == 4012)
                        {
                             //$.toaster({priority:'success',title:'SUCCESS',message:'Regirecting to payment gateway. It will take few seconds'});
                             window.location.href = obj['payment_url'];
                        }
                    else{
                          //$.toaster({priority:'warning',title:'ERROR',message:'Error Occured'});

                    }
                $(".loader").hide();
                }
            });
              
        }
         });  


        $(function() {
            $('.js-conveyor-example').jConveyorTicker({
                reverse_elm: true,
                force_loop: true

            });
        });


        $(document).ready(function() {
                create_calendar(850,'');
        });
    
/*
*   function'll get attendance of student
*   @params student id    
*   @author GBS-R
*/

$("#studentattendance").click(function(){
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>user/Student/attendance',
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#attendance").html(response);
                    $(".loader").hide();
                }
            });
    });


    
/*
*   function'll get exams list
*   @params student id    
*   @author GBS-R
*/

$("#studentexams").click(function(){
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>user/Student/myexams',
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#loadmyexam").html(response);
                    $(".loader").hide();
                }
            });
    });


    
    $("form#feepayment_form11").validate({
           
           submitHandler: function(form) {
               $('#paynowbutton').attr("disabled", "disabled");
               $('#allowonlinepayment').attr("disabled", "disabled");
               $(".loader").show();
               $.ajax({
                   url: '<?php echo base_url();?>Transactions',
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
           
/*
*   function'll get exams list
*   @params student id    
*   @author GBS-R
*/

$("#feedetailstab").click(function(){
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>user/Student/load_fee_details',
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#studfeedetails").html(response);
                    $(".loader").hide();
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
                url: '<?php echo base_url();?>user/Student/get_batchfee_installment',
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

/*
*   function'll get exam details
*   @params exam id, student id
*   @author GBS-R
*/

$('body').on('click', '.indiexamdetails', function () {
             $(".loader").show();
            var exam_id = $(this).attr("id");
            var attempt = $(this).attr("alt");
            $.ajax({
                url: '<?php echo base_url();?>user/Student/exam_details',
                type: 'POST',
                data: {
                    exam_id:exam_id,
                    attempt:attempt,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#loadmyexam").html(response);
                    $(".loader").hide();
                }
            });
    });

        
/*
*   function'll get time taken distribution foreach questions
*   @params exam id, student id
*   @author GBS-R
*/

$('body').on('click', '.timedistribution', function () {
             $(".loader").show();
            var exam_id = $(this).attr("id");
            var attempt = $(this).attr("alt");
            $.ajax({
                url: '<?php echo base_url();?>user/Student/taken_distribution_details',
                type: 'POST',
                data: {
                    exam_id:exam_id,
                    attempt:attempt,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#loadmyexam").html(response);
                    $(".loader").hide();
                }
            });
    });
    
/*
*   function'll get exam details
*   @params exam id, student id
*   @author GBS-R
*/

$('body').on('click', '.getquestionbyid', function () {
             $(".loader").show();
            var question_id = $(this).attr("id");
            var selected_choices = $(this).attr("alt");
            var question_type = $(this).attr("status");
            $.ajax({
                url: '<?php echo base_url();?>user/Student/question_details',
                type: 'POST',
                data: {
                    question_id:question_id,
                    selected_choices:selected_choices,
                    question_type:question_type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $(".loader").hide();
					$(".hidequestionclass").hide();
					$("#questionavg"+question_id).show();
					$("#question"+question_id).show();
					$("#question_avg"+question_id).show();
					$("#question_"+question_id).show();
                    $("#loadquestion").html(response);
                }
            });
    });

/*
*   function'll get progress report
*   @params student id
*   @author GBS-R
*/

$("#studentprogress").click(function(){
            //  $(".loader").show();
            // $.ajax({
            //     url: '<?php echo base_url();?>user/Student/progress_report',
            //     type: 'POST',
            //     data: {
            //         <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            //     },
            //     success: function(response) {
            //       //  alert(response);
            //         $("#loadprogressreport").html(response);
            //         $(".loader").hide();
            //     }
            // });
    });


    $(".createcertificate").click(function(){
            $(".loader").show();
            var id = $(this).attr('id');
            $.ajax({
                url: '<?php echo base_url();?>user/Student/student_certificate',
                type: 'POST',
                data: {course_id:id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var obj=JSON.parse(response);
                    if(obj.statusCode==200){
                    //window.location.href = obj.data;
                    window.open(obj.data,'_blank');
                    } else {
                      $.toaster({priority:'warning',title:'ERROR',message:obj.message});  
                    }
                    $(".loader").hide();
                }
            });
    });
    
/*
*   function'll get selected child id
*   @params student id    
*   @author GBS-R
*/

$(".childselection").change(function(){
             $(".loader").show(); 
            var student_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url();?>user/Student/childselection',
                type: 'POST',
                data: {
                    student_id:student_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    var obj=JSON.parse(response);
                    if(obj.status==1){
                    window.location.href = obj.url;
                    } else {
                      $.toaster({priority:'warning',title:'ERROR',message:'Student not admitted yet.'});  
                    }
                    $(".loader").hide();
                }
            });
    });  
/*
*   function'll get homework of student
*   @params student id    
*   @author GBS-L
*/

$("#homework_list").click(function(){
  
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>user/Student/homework',
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#load_homework").html(response);
                    $(".loader").hide();
                }
            });
    });  
    
/*
*   function'll get study material of student
*   @params student id    
*   @author GBS-L
*/

    $("#study_materials").click(function(){
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>user/Student/study_materials',
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#loadstudymaterials").html(response);
                    $(".loader").hide();
                }
            });
    });



    /*
*   function'll get learning of student
*   @params student id    
*   @author GBS-L
*/

$("#studymaterials").click(function(){
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>user/Student/studymaterials',
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#materials").html(response);
                    $(".loader").hide();
                }
            });
    });

    $("#download_pdf").click(function(){
        $(".loader").show(); 
        $.ajax({
            url: '<?php echo base_url();?>user/Student/print_notes',
            type: 'POST',
            data: {},
            success: function(response) {
                // alert(response);
                $(".loader").hide();
            }
        });
    });

$('body').on('click', '.nav-link', function () {
             $('#loadquestion').html('Click question no. to view question and answers.');
    });  


    function view_study_material(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('user/Student/show_study_material'); ?>",
            type: "post",
            data: {'id':id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#body').html(obj.html);
                    $('#title').html(obj.title);
                    $('#view_study_material').modal('toggle');
                }else{
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
            }
        });
    }  
</script>
