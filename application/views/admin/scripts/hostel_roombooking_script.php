<script>
$(document).ready(function(){

  // Initialize select2
  $("#show_students").select2();
 var student_id=$("#studentid").val();
        if(student_id != "")
            {
               
                 $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_student_hostelDetails',
                    type: 'POST',
                    data: {
                        student_id: student_id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                   $(".loader").hide();
                      var obj=JSON.parse(response);
                        if(obj.status == "1")
                            {
                                $('select[id^="building_id"] option[value="'+obj['data'].building_id+'"]').attr("selected","selected");
                                $('select[id^="roomtype_id"] option[value="'+obj['data'].roomtype_id+'"]').attr("selected","selected");
                                $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Hostel/get_floors_by_buildingId',
                                        type: 'POST',
                                        data: {
                                            building_id: obj['data'].building_id,
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                           
                                       $(".loader").hide();
                                            $("#floor_id").html(response);
                                            $('select[id^="floor_id"] option[value="'+obj['data'].floor_id+'"]').attr("selected","selected");
                                             get_rooms(obj['data'].room_id);
                                            
                                            
                                            
                                           
                                            $('.rooms li input:checked').parent("li").addClass("roomSelected");
                                        }
                                    });
                               
                                
                               
                            }

                    }
                });
            }

});
    
//load floor under building
 $("#building_id").change(function(){
     $("#show_fee").html('');
        var building = $('#building_id').val();
        if(building !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_floors_by_buildingId',
                    type: 'POST',
                    data: {
                        building_id: building,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                   $(".loader").hide();
                        $("#floor_id").html(response);

                    }
                });
                
        }
    });
    
    function clearfield(){
        // alert('Don');
        $("#show_fee").html('');
    }
    //load rooms for booking
 function get_rooms(room_id=""){
     $("#show_fee").html('');
        var roomtype_id = $('#roomtype_id').val();
        var floor_id    = $('#floor_id').val();
        var building_id = $('#building_id').val();
        if(roomtype_id !="" && floor_id!="" && building_id !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_roomlist_for_booking',
                    type: 'POST',
                    data: {
                        building_id: building_id,
                        floor_id: floor_id,
                        roomtype_id: roomtype_id,
                        room_id: room_id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                          $(".loader").hide();
                          var obj=JSON.parse(response);
                          $("#show_rooms").html(obj['html']);
                    }
                });
              
        }
    }
    //get student details
    
    function get_student()
    {

        $('.rooms li input:not(:checked)').parent("li").removeClass("roomSelected");
        $('.rooms li input:checked').parent("li").addClass("roomSelected");
                $(".loader").show();
        var student_id=$("#studentid").val();
        if(student_id != "")
                            {
                               //$("#show_students").val(student_id);
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/show_student_for_hostel',
                                    type: 'POST',
                                    data: {
                                        student_id:student_id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                 success: function(response) 
                                    {
                                        $(".loader").hide();
                                        var obj=JSON.parse(response);
                                        $("#show_students").html(obj['html']); 
                                    }
                                });
                            }
        else{
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_studentlist_for_hostel',
                    type: 'POST',
                    data: {
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                          $(".loader").hide();
                          var obj=JSON.parse(response);
                         $("#show_students").html(obj['html']);
                       
                        }
                });
        }

       $('#myModal').modal({show: true});               
    }
    //allocate bed for student
     //edit room
 $("form#allocate_student_room").validate({
        rules: {
            building_id: {
                required: true
            },
            floor_id: {
                required: true
            },
            roomtype_id: {
                required: true
            },
            
             
        },
        messages: {
            building_id: "Please Choose a Building",
            floor_id: "Please Choose a Floor",
            roomtype_id: "Please Choose a Room Type",
           
        },

        submitHandler: function(form) {
            
          var room=  $('input[name=room]:checked').length;
          var student_id=  $('#student').val();
           // alert(room);
           if(room ==0)
               {
                   $("#room_msg").html("Please Choose a Room");
               }
            else
                {
                    $("#room_msg").html(""); 

                if(student_id !="")
                {
                   $(".loader").show();
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Hostel/hostel_rooms_booking',
                        type: 'POST',
                        data: $("#allocate_student_room").serialize(),
                        success: function(response) {

                            var obj=JSON.parse(response)
                              if (obj.st == 1) {
                                        // $('#editModal').modal('toggle');
                                 $( '#allocate_student_room' ).each(function(){ this.reset(); });

                                  $("#save_alert").html("");
                                  $("#show_rooms").html("");
                                $.toaster({priority:'success',title:'Success',message:obj.message});

                              }
                            else if (obj.st == 0){
                                 $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                            }

                            $(".loader").hide();
                        }

                    });
                }
            else
                {
                  $.toaster({priority:'danger',title:'Invalid',message:'Please Choose a Student'});
                }
                }
            }
    });
    //add student
    $(document).ready(function () {
     $("#add_student_form").validate({
        rules: {
            student_list: {required: true,
                        }, 
           
        },
        messages: {
            student_list:{ 
                       required:"Please Choose a Student",
                        },
           
        },
        submitHandler: function(form) {
            var student=$("#show_students").val();
            $("#student").val(student);
            var room_type = $("#roomtype_id").val();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_fee',
                type: 'POST',
                data: {
                    student_id:student,
                    room_type:room_type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var obj=JSON.parse(response);
                    if(obj['fee'] != 0){
                        $("#show_fee").html('Hostel fee '+obj['fee']);
                        $('#myModal').modal('toggle');
                        $("#save_alert").html('Room selection completed,Please click on the save button to complete the process..!');
                        $(".btn_save").removeAttr("disabled");
                    }else{
                        $("#show_fee").html('');
                        $('#myModal').modal('toggle');
                        $("#save_alert").html('Please add fee for this roomtype/messtype..!');
                        $(".btn_save").attr("disabled", "disabled");
                    }
                }
            });
        }
    });
});


</script>
