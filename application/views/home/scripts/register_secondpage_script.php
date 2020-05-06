<script>
   

    $("#qualification_form").validate({
        submitHandler: function(form)
        { $(".loader").show();
              $.ajax({
                url: '<?php echo base_url();?>Register/register_third_view',
                type: 'POST',
                data:  $("#qualification_form").serialize(),
                success: function(response) {
                     $(".loader").hide();
                      $("#next_page").html(response);
                     $("#next").focus();
                }
            });
        }
    });

$(".btn_prev").click(function(){
     $(".loader").show();
    $.ajax({
                url: '<?php echo base_url();?>Register/previous_of_secondpage',
                type: 'POST',
                data:  $("#qualification_form").serialize(),
                success: function(response) {
                     $(".loader").hide();
                      $("#next_page").html(response);
                    $("#next").focus();
                }
            });
    
});
    
    $("#smark").keyup(function(){
          var num=$("#smark").val();
        if(num > 100)
            {
                $("#smark").val("");
                $("#smsg").html("Enter a number which is less than or equal to 100")
            }
        else
            {
                  $("#smsg").html("");
            }        
    }); 
    $("#plustwo_m").keyup(function(){
          var num=$("#plustwo_m").val();
        if(num > 100)
            {
                $("#plustwo_m").val("");
                $("#plustwo_msg").html("Enter a number which is less than or equal to 100")
            }
        else
            {
                  $("#plustwo_msg").html("");
            }        
    });
    
    $("#degree_m").keyup(function(){
          var num=$("#degree_m").val();
        if(num > 100)
            {
                $("#degree_m").val("");
                $("#degree_msg").html("Enter a number which is less than or equal to 100")
            }
        else
            {
                  $("#degree_msg").html("");
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
    $("#other_m").keyup(function(){
          var num=$("#other_m").val();
        if(num > 100)
            {
                $("#other_m").val("");
                $("#other_msg").html("Enter a number which is less than or equal to 100")
            }
        else
            {
                  $("#other_msg").html("");
            }        
    });
    
/*number and decimal*/
function decimalNum(event){
    var regex = new RegExp("^[0-9.]+$");
    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  
        return true; 
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            event.preventDefault();
            return false;
        }
    }
}
$(document).ready(function(){
       $("#add_more_qual").click(function(){
                    var val = $("#counter").val(); 
                    var counter=parseInt(val)+1;
           if(counter <=5){
                    var html = '';
                    html +='<div class="row" id="new_textbox' + counter+'"><div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><div class="adding_section" > <div class="row"> <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" ><div class="form-group"> <input type="hidden" name="category[]" value="other" /><div class="input-group input_group_form"> <input type="text" class="form-control otherField" placeholder="Additional Qualifications" id="qual" name="qualification[]" value=""/> <div class="input-group-append percent_box"><input type="text" class="form-control numbersOnly" placeholder="" name="marks[]" value="" onkeypress="return decmalNum(event);"/></div><div class="input-group-prepend percentageSpan"> <span class="input-group-text">%</span></div></div></div></div></div><button type="button" id="delete"  class="btn add_wrap_pos btn-danger remove_section remove_this btn_remove_minus" id="row[' + counter+']" onclick="delete_others('+counter+')"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></button></div> </div> </div> </div> </div>';

                    $('#more_others').append(html);
                    $("#counter").val(counter);
                    } else{
                        return false;
                    } 
           
    });
    
});
   

     function delete_others(counter){
        /*if(counter==5){
            return false;
        }*/
        $("#new_textbox" + counter).remove();
        
    }


    //  function delete_others(counter,id) {
    //         $.confirm({
    //             title: 'Alert message',
    //             content: 'Do you want to remove this Information?',
    //             icon: 'fa fa-question-circle',
    //             animation: 'scale',
    //             closeAnimation: 'scale',
    //             opacity: 0.5,
    //             buttons: {
    //                 'confirm': {
    //                     text: 'Proceed',
    //                     btnClass: 'btn-blue',
    //                     action: function() {
    //                     if(id!=""){

    //                         $.post('<?php echo base_url();?>Register/delete_others/', {
    //                             counter:counter,
    //                             id: id,
    //                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //                         }, function(data) {

    //                             if (data == "1") {
                                
    //                                 setInterval(function (){
    //                                     location.reload();
    //                                     }, 2500);
    //                                 $.alert('Successfully <strong>Deleted..!</strong>');
    //                                 $("#new_textbox" + counter).remove();
    //                                 $("#row_"+id).remove();
    //                             }
    //                         });
    //                     }else{
    //                         $.alert('Successfully <strong>Deleted..!</strong>');
    //                         $("#new_textbox" + counter).remove();
    //                         $("#row_"+id).remove();
    //                     }
                            
    //                     }
    //                 },
    //                 cancel: function() {
    //                 },
    //             }
    //         });
    //     }

</script>
