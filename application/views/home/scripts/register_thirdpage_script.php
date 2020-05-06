<script>
     $.validator.addMethod("letters", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "name must contain only letters, space.");

$(document).ready(function(){

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
                        }
                    else{
                        // $("#transport_place").val("");
                         $("#place").hide();
                    }
                });
    
                $(".stayed").click(function(){
                     $(".stayed").removeClass("checkmark-error");
                });
                $(".food_habit").click(function(){
                     $(".food_habit").removeClass("checkmark-error");
                });

                /* $(".medical_history").click(function(){
                if($('input:radio[name=medical_history]:checked').val()  == "yes")
                        {
                             $("#medical_text").show();
                        }
                    else{
                         $("#medical_description").val("");
                         $("#medical_text").hide();
                    }
                });*/
    });



$("#requirement_form").validate({

        rules: {
            hostel: {
                required: true
            },
            transportation: {
                required: true
            },
            declaration: {
                required: true
            }, 
            declaration2: {
                required: true
            },
            declaration3: {
                required: true
            },

        },
        messages: {
            hostel: "Please select the Option",
            transportation: "Please select the Option",
            declaration: "Please check the declaration",
            declaration2: "Please check the declaration",
            declaration3: "Please check the declaration"
        },

        submitHandler: function(form) {
            var placeValdation=0;
            var place=$("#transport_place").val();
                if($('input:radio[name=transportation]:checked').val()  == "yes" && place == "")
                {
                    $("#pmsg").html("Please choose a route");
                    placeValdation=1;
                }
            else{
                    $("#pmsg").html("");
                    placeValdation=0;
                } 
            var hostelValdation=0;
            var stayed_val=0;
            var food_habit_val=0;
            var stayed_in_hostel=$('input:radio[name=stayed_in_hostel]:checked').val();
            var food_habit=$('input:radio[name=food_habit]:checked').val();
            
                if($('input:radio[name=hostel]:checked').val()  == "yes"){
                    if(stayed_in_hostel != "yes" && stayed_in_hostel != "no")
                     {
                          $(".stayed").addClass("checkmark-error");//none selected
                          stayed_val=1;
                     }
                     else
                     {
                            $(".stayed").removeClass("checkmark-error");
                            stayed_val=0;
                     }
                    
                    if(food_habit != "veg" && food_habit != "nonveg")
                     {
                            $(".food_habit").addClass("checkmark-error");//none selected
                            food_habit_val=1;
                     }
                    else
                    {
                            $(".food_habit").removeClass("checkmark-error");
                            food_habit_val=0;
                    }
                       if(stayed_val==0 && food_habit_val==0)
                       {
                            hostelValdation=0;
                       }
                       else{
                            hostelValdation=1;
                       }
                    
                }
            else{
                   $(".stayed").removeClass("checkmark-error");
                   $(".food_habit").removeClass("checkmark-error");
                   $("input:radio[name=stayed_in_hostel]"). prop("checked", false);
                   $("input:radio[name=food_habit]"). prop("checked", false);
               }
          
            if(hostelValdation== 0 && placeValdation == 0){        
                $(".loader").show();
                    $.ajax({
                            url: '<?php echo base_url();?>Register/register',
                            type: 'POST',
                            data: $("#requirement_form").serialize(),
                            success: function(response) {
                                 $(".loader").hide();
                                  $("#next_page").html(response);
                                 $("#next").focus();
                            }
                    });
            }
        }
         });

$(".btn_prev").click(function(){
     $(".loader").show();
    $.ajax({
                url: '<?php echo base_url();?>Register/previous_of_thirdpage',
                type: 'POST',
                data:  $("#requirement_form").serialize(),
                success: function(response) {
                     $(".loader").hide();
                      $("#next_page").html(response);
                     $("#next").focus();
                }
            });
    
});


</script>
