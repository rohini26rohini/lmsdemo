<script>

/** Get Hostel Fee rent Starts */

$(document).ready(function () {
    update_table();
    $(".close_btn").click(function () {
        $(this).hide();
        $("#chartBlock").removeClass(("show"));
    });
});

function get_hostel_rent(student_id,booking_id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/get_student_hostel_rent/'+student_id+'/'+booking_id,
        type: 'GET',
        success: function(response) {
            var obj = JSON.parse(response);
            $("#fee_details").html(obj);
            $("#chartBlock").addClass("show");
            $(".close_btn").fadeIn("200");
            $(".loader").hide();
        }
    });
}

function trans_payment() { 
    $(".loader").hide();
    $('#loadtransfeesummary').html('');
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_rent',
        type: 'POST',
        data: $("#pay_hostel_rent").serialize(),
        success: function(response) {
            // var obj=JSON.parse(response);
            $('#loadtransfeesummary').html(response);
            $(".loader").hide();
        }
    });
}

function payInitialFees(student_id,booking_id){
    $(".loader").hide();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/payInitial_hostel_rent/'+student_id+'/'+booking_id,
        type: 'POST',
        data: $("#pay_hostel_rent_summary").serialize(),
        success: function(response) {
            $.toaster({priority:'success',title:'Payment Completed Successfully',message:''});
            update_table();
            $("#chartBlock").removeClass(("show"));
            $(".loader").hide();
        }
    });
}

function student_room_checkout(id){
    $.confirm({
        title: 'Alert message',
        content: 'Do you want to checkout this student? This process is irreversible.',
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
                                url: '<?php echo base_url();?>backoffice/Hostel/student_room_checkout/'+id,
                                type: 'GET',
                                success: function(response) {
                                    var obj = JSON.parse(response);
                                    if (obj.st == 1) {
                                        update_table();
                                        $.toaster({priority:'success',title:'Success',message:obj.message});
                                    } 
                                    $(".loader").hide();
                                }
                            });
                    }

                }
            },
            cancel: function() {
                //$.alert(' <strong>cancelled</strong>');
            },
        }
    });  
}

function update_table(){
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/search_booking',
        type: "post",
        data: $("#search_form").serialize(),
        success: function(data) {
            $('#institute_data').DataTable().destroy();
            $("#institute_data").html(data);

            $("#institute_data").DataTable({
                "searching": true,
                "bPaginate": true,
                "bInfo": true,
                "pageLength": 10,
        //        "order": [[4, 'asc']],
                "aoColumnDefs": [
                    {
                        'bSortable': true,
                        'aTargets': [0]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [1]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [2]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [3]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [4]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [5]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [6]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [7]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [8]
                    }
                ]
            });
                $(".loader").hide();
        }
        
    });
}

function download_receipt(student_id,invoice_id){
    $(".loader").show();
    $.ajax({
        url: base_url+'backoffice/Receipt/download_hostel_receipt/'+student_id+'/'+invoice_id,
        type: "GET",
        success: function(response){
            var obj = JSON.parse(response);
            if (obj.st == 1) {
                 window.open(obj.url);
            } 
            $(".loader").hide();
        }
    });
}

/** Get Hostel Fee rent Ends */
$(document).ready(function(){
  $(".select2").select2();
});
    
    $("#edit_status").change(function(){
       
        var status = $('#edit_status').val(); 
        if(status == "checkin" || status == "checkout")
            {  
                if(status == "checkout")
                {
                    $("#date").val(""); 
                }
              
                $('#show_date').css('display', 'block');
            }
        else{
            
            $('#show_date').css('display', 'none');
        }
    });

    
    //load floor under building
 $("#buildingid").change(function(){

        var building = $('#buildingid').val();
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
                    // alert(response);
                        $("#floor_id").html(response);

                    }
                });
                $(".loader").hide();
        }
    });

    
    $("#search_form").submit(function(e){
           e.preventDefault();
       // $(".loader").show();
       update_table()
    });


     function get_roomdata(id) {
         //$(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Hostel/get_booked_roomdata_byId',
            type: 'POST',
            data: {
                id:id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {

                var obj = JSON.parse(response);
                //alert(response);
               
              //  alert(obj.roomData['status']);
                $("#id").val(obj.roomData['id']);
                $("#edit_status").html(obj.statusArr);
                $("#edit_status").val(obj.roomData['status']);
                if(obj.roomData['status'] =="checkin" || obj.roomData['status'] =="checkout")
                {
                    $("#show_date").show();
                    if(obj.roomData['status']=="checkin")
                        {
                            $("#date").val(obj.date);
                        }
                    else{
                          $("#date").val(obj.date);
                        }
                }
                else
                {
                  $("#show_date").hide();
                }
                $("#buildingid").val(obj.roomData['building_id']);
                $("#floor_id").html(obj.floorArr);
                $("#floor_id").val(obj.roomData['floor_id']);
                $("#roomtype_id").html(obj.roomData['roomtypeArr']);
                $("#roomtype_id").val(obj.roomData['roomtype_id']);
                $("#show_rooms").html(obj['html']);
              
              
                $('#myModal').modal({
                        show: true
                        });

                
                //$(".loader").hide();

            }
        });

    }
//load rooms for booking
 function get_rooms(){
        var roomtype_id = $('#roomtype_id').val();
        var floor_id    = $('#floor_id').val();
        var building_id = $('#buildingid').val();
        if(roomtype_id !="" && floor_id!="" && building_id !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_roomlist_for_booking',
                    type: 'POST',
                    data: {
                        building_id: building_id,
                        floor_id: floor_id,
                        roomtype_id: roomtype_id,
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
    
    function get_student()
    {
        $('.rooms li input:not(:checked)').parent("li").removeClass("roomSelected");
        $('.rooms li input:checked').parent("li").addClass("roomSelected");  
    }
    
    //change room
     $(document).ready(function () {
    $("#change_room").validate({
        rules: {
            building_id: {
                required: true
            },
            floor_id: {
                required: true
            },
            roomtype_id: {
                required: true
            }             
        },
        messages: {
            building_id: "Please Choose a Building",
            floor_id: "Please Choose a Floor",
            roomtype_id: "Please Choose a Room Type",
            
           
        },

        submitHandler: function(form) {
            
         
          var status=  $('#edit_status').val();
          var date=  $('#date').val();
            //alert(date);
           var  Validation=0;
            if(status !="alloted" && date =="")
                {
                   $("#date_msg").html("Please Choose the Date");
                }
              else{
                    $("#date_msg").html("");
                    Validation=1;
                }  
          
         // alert(Validation);
            if(Validation== 1){
                  // $(".loader").show();
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Hostel/change_hostelRoom',
                        type: 'POST',
                        data: $("#change_room").serialize(),
                        success: function(response) {
                                Validation=0;
                               var obj=JSON.parse(response)
                              if (obj.st == 1) {
                                $( '#change_room' ).each(function(){ this.reset(); }); 
                                $("#show_rooms").html("");
                                $('#myModal').modal('toggle');
                                update_table();
                                //    $.ajax({
                                //     url: '<?php echo base_url();?>backoffice/Hostel/load_searchbooking_ajax',
                                //     type: "post",
                                //     data: {
                                //             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                //         },
                                //     success: function(data) {
                                //         $('#institute_data').DataTable().destroy();
                                //         $("#institute_data").html(data);

                                //         $("#institute_data").DataTable({
                                //             "searching": true,
                                //             "bPaginate": true,
                                //             "bInfo": true,
                                //             "pageLength": 10,
                                //     //        "order": [[4, 'asc']],
                                //             "aoColumnDefs": [
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [0]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [1]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [2]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [3]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [4]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [5]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [6]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [7]
                                //                 },
                                //                 {
                                //                     'bSortable': false,
                                //                     'aTargets': [8]
                                //                 }
                                //             ]
                                //         });
                                //     }
                                //    });
                                   $.toaster({priority:'success',title:'Success',message:obj.message});

                              }
                            else if (obj.st == 0){
                                 $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                            }

                           // $(".loader").hide();
                        }

                    });
                }
                
            }
    });
    });
    
    function delete_bookedroomdata(id)
    {
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/delete_bookedroomdata',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            update_table();
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                        }else if(obj.status == 2){
                                            $.toaster({priority:'warning',title:'Invalid Request',message:obj.message});  
                                        }else {
                                            $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                                        }
                                        $(".loader").hide();
                                    }
                                });
                        }

                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });  
    }
</script>
