<script>
$(document).ready(function() {
//   $("#button").click(function () {
//       var url = $('#url').val();
//       $("#frame").attr("src", url);
//   });

  
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaDay,listWeek'
        },
        //                defaultDate: '2018-12-12',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [{
                title: 'All Day Event',
                start: '2018-12-01',
            },
            {
                title: 'Long Event',
                start: '2018-12-07',
                end: '2018-12-10'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2018-12-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2018-12-16T16:00:00'
            },
            {
                title: 'Conference',
                start: '2018-12-11',
                end: '2018-12-13'
            },
            {
                title: 'Meeting',
                start: '2018-12-12T10:30:00',
                end: '2018-12-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2018-12-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2018-12-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2018-12-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2018-12-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2018-12-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2018-12-28'
            }
        ]
    });
    $('input[name=created_on]').blur(function() {
        load_data();
    });
});
load_data();
    function load_data(){
        $(".loader").show();
        var date = $("#created_on").val();
        $('#div1').empty();
        $('#div2').empty();
        $('#div3').empty();
        $('#div4').empty();
        $('#div5').empty();
        $('#div6').empty();
        $('#div7').empty();
        $('#div8').empty();
        // alert(date);
        $.ajax({
            url:"<?php echo base_url(); ?>backoffice/Call_center/get_date",
            method:"POST",
            data:{date:$("#created_on").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success:function(data){
                var obj = JSON.parse(data);
                // $('#by_year').html(data);
                $('#div1').html(obj.first);
                $('#div2').html(obj.second);
                $('#div3').html(obj.third);
                $('#div4').html(obj.fourth);
                $('#div5').html(obj.fifth);
                $('#div6').html(obj.sixth);
                $('#div7').html(obj.seventh);
                $('#div8').html(obj.eighth);
                $(".loader").hide();
            }
        })
    }

    $('.filter_class').keyup(function(){
            var inputLength = $(this).val();
            if (inputLength.length >= 3) {
                load_data();
            }
        });
        $('.filter_class').change(function(){
            // var inputLength = $(this).val();
            // if (inputLength.length >= 3) {
                load_data();
            // }
        });
        $('.filter_class').bind('paste', function(e) {
            var inputLength = $(this).val();
            if (inputLength.length >= 3) {
                load_data();
            }
        });
        
    
    
// function'ii get batch details of student
// @params student id, batch
// @author GBS-R

     $(".getbatchdetails").click(function(){ 
        var student_id=$("#student_id").val(); 
         $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_student_batch_details',
                type: 'POST',
                data: {student_id:student_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#view5").html(response);
                    //$("#view6").html(response);
                    } else {
                        //                        $("#selectedbatch").html('');
                        //                        $("#selectedbatch").hide();
                        //                        $.toaster({priority:'danger',title:'Error',message:'No center assigned for this branch!'});
                    }
                    $(".loader").hide();
                }
            });
    });
    

// function'll get payment details of student
// @params student id, 
// @author GBS-R

     $(".getpaymentdetails").click(function(){ 
        var student_id=$("#student_id").val();  
         $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_student_payment_details',
                type: 'POST',
                data: {student_id:student_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#view6").html(response);
                    } else {
//                        $("#selectedbatch").html('');
//                        $("#selectedbatch").hide();
//                        $.toaster({priority:'danger',title:'Error',message:'No center assigned for this branch!'});
                    }
                    $(".loader").hide();
                }
            });
    });
    
// function'll get course details of student
// @params student id, 
// @author GBS-R

     $(".getcoursedetails").click(function(){ 
        var student_id=$("#student_id").val();  
         $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_student_course_details',
                type: 'POST',
                data: {student_id:student_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    if(response!='') {
                    $("#view7").html(response);
                    } else {
//                        $("#selectedbatch").html('');
//                        $("#selectedbatch").hide();
//                        $.toaster({priority:'danger',title:'Error',message:'No center assigned for this branch!'});
                    }
                    $(".loader").hide();
                }
            });
    });    
    

    function view_studentdata(id)
    {
        $(".loader").show();
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_studentview_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#name").html(obj.name);
                    $("#address").html(obj.address);
                    $("#street").html(obj.street);
                    $("#state").html(obj.state);
                    $("#district").html(obj.district);
                    $("#contact_number").html(obj.contact_number);
                    $("#whatsapp_number").html(obj.whatsapp_number);
                    $("#mobile_number").html(obj.mobile_number);
                    $("#guardian_name").html(obj.guardian_name);
                    $("#email").html(obj.email);
                    $("#date_of_birth").html(obj.date_of_birth);
                     $('#view_student').show();
                    $(".loader").hide();
                }
            });

    }
   
 /*
*   function'll get attendance of student
*   @params student id    
*   @author GBS-R
*/

$(".studentattendance").click(function(){
            var student_id = $('#student_id').val(); 
             $(".loader").show(); 
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/attendance',
                type: 'POST',
                data: {
                    student_id:student_id,
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
*   function'll get progress report
*   @params student id
*   @author GBS-R
*/

$(".studentprogress").click(function(){
             $(".loader").show();
            var student_id = $('#student_id').val();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/progress_report',
                type: 'POST',
                data: {
                    student_id:student_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#progressreport").html(response);
                    $(".loader").hide();
                }
            });
    });
    
</script>
