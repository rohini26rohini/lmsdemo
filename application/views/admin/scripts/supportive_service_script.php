<script>
    $(document).ready(function(){


    });
  //date validation  
     $('#start_date').datetimepicker({
         format:'DD-MM-YYYY'
     });
        $('#end_date').datetimepicker({
            useCurrent: false, 
            format:'DD-MM-YYYY',
        });
         
        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
             $('#start_date').data("DateTimePicker").maxDate(e.date);

        });
    //date validation in edit
     $('#edit_start_date').datetimepicker({
         format:'DD-MM-YYYY',

     });
        $('#edit_end_date').datetimepicker({
            useCurrent: false,
            format:'DD-MM-YYYY',
        });

        $("#edit_start_date").on("dp.change", function (e) {
            $('#edit_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#edit_end_date").on("dp.change", function (e) {
             $('#edit_start_date').data("DateTimePicker").maxDate(e.date);
             
        });

//add service
    var validation=0;
    $("form#add_service_form").validate({
        rules: {
           description: {
                required: true
            },
            type: {
                required: true
            },
            date_from: {
                required: true
            },
            date_to: {
                required: true
            },
            alert: {
                required: true
            },
            contact_person: {
                required: true
            },
            mobile_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,
                email:true,
                emailValidate:true,
            } /*,
            file: {
                required: true
            }*/
        },
        messages: {
            description: "Please Enter Service Name",
            type: "Please Choose a Contract Type",
            date_from: "Please Choose a Date",
            date_to: "Please Choose a Date",
            alert: "Please Choose an Option",
            contact_person: "Please Enter Contact Person's Name",
            mobile_number: {
               required: "Please Enter Mobile Number",
               number: "Please Enter Numbers Only",
               minlength: "Please Enter a 10 digit Mobile Number",
               maxlength: "Please Enter a 10 digit Mobile Number"
            },
            email:{ 
                required:"Please Enter Email Id",
                email:"Please Enter a valid Email Id",
                emailValidate:"Please Enter a valid  Email Id"
                  }
           // file: "Please Upload a File",
            },

        submitHandler: function(form) {
            validation=1;

        }
    });
    
  
    $("form#add_service_form").submit(function(e) { 
         e.preventDefault();


           if (validation == 1) { 
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/add_service',
                type: 'POST',
                data: new FormData(this),
                beforeSend: function(data) {
                    // Show image container
                     $(".loader").show();
                },
                success: function(response) {
                validation = 0;

                   var obj = JSON.parse(response);
                            if (obj.st == "1") {
                                $('#myModal').modal('toggle');
                                 $( '#add_service_form' ).each(function(){
                                        this.reset();
                                });
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });

                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_supportive_service_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {

                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);

                                        $("#institute_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //        "order": [[4, 'asc']],
                                            "aoColumnDefs": [
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [0]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [1]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [2]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [3]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });

                            }
                    else if(obj.st == "2")
                    {
                            $.toaster({ priority : 'danger', title : 'Invalid', message : obj.message });
                    }
                else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                            }

                },
                complete: function(data) {
                    // Hide image container
                    $(".loader").hide();
                },
                cache: false,
                contentType: false,
                processData: false

            });
        }
    });

    //get service data by id
    function get_servicedata(id)
    {
     // $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Asset/get_serviceData_by_id',
            type: 'POST',
            data: {
                id:id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                
                var obj = JSON.parse(response);
               // alert(obj.start_date);
                //alert(obj.end_date);
               //alert(obj['parent_institutes']);
                $("#edit_title").val(obj.description);
                $("#edit_type").val(obj.type);
                //$("#edit_type").val(obj.institute_type_id);
                if(obj.alert == "1")
                    {
                      $("#alert_yes"). prop("checked", true);
                    }
                else{
                    $("#alert_no"). prop("checked", true);
                }
                $("#edit_contact_person").val(obj.contact_person);
                $("#edit_mobile").val(obj.mobile_number);
                $("#edit_email").val(obj.email_id);
                $("#edit_file").html(obj.file);
                $("#edit_start_date").val(obj.start_date);
                $("#edit_end_date").val(obj.end_date);
                $("#id").val(obj.id);
                $('#editModal').modal({
                        show: true
                        });




                //$(".loader").hide();

            }
        });
    }

    //edit service
    var edit_validation=0;
    $("form#edit_service_form").validate({
        rules: {
           description: {
                required: true
            },
            type: {
                required: true
            },
            from: {
                required: true
            },
            to: {
                required: true
            },
            alert: {
                required: true
            },
            contact_person: {
                required: true
            },
            mobile_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,
            },
            email: {
                required: true,
                email:true,
                emailValidate:true,
            } /*,
            file: {
                required: true
            }*/
        },
        messages: {
            description: "Please Enter Service Name",
            type: "Please Choose a Contract Type",
            from: "Please Choose a Date",
            to: "Please Choose a Date",
            alert: "Please Choose an Option",
            contact_person: "Please Enter Contact Person's Name",
            mobile_number: {
               required: "Please Enter Mobile Number",
                number:"Please Enter Numbers Only",
               minlength: "Please Enter a 10 digit Mobile Number",
               maxlength: "Please Enter a 10 digit Mobile Number",
            },
            email:{
            
                required:"Please Enter Email Id",
                email:"Please Enter a valid Email Id",
                emailValidate:"Please Enter a valid  Email Id"
                  }
           // file: "Please Upload a File",
            },

        submitHandler: function(form) {
            edit_validation=1;

        }
    });


    $("form#edit_service_form").submit(function(e) {
         e.preventDefault();


           if (edit_validation == 1) {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/edit_service',
                type: 'POST',
                data: new FormData(this),
                beforeSend: function(data) {
                    // Show image container
                     $(".loader").show();
                },
                success: function(response) {
                edit_validation=0;

                     var obj = JSON.parse(response);
                            if (obj.st == "1") {
                                $('#editModal').modal('toggle');
                                 $( '#edit_service_form' ).each(function(){
                                        this.reset();
                                });
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });

                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_supportive_service_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {

                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);

                                        $("#institute_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //        "order": [[4, 'asc']],
                                            "aoColumnDefs": [
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [0]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [1]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [2]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [3]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });

                            }
                            else if(obj.st == "2")
                            {
                            $.toaster({ priority : 'danger', title : 'Invalid', message : obj.message });
                            }
                            else
                            {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                            }
                    
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader").hide();
                },
                cache: false,
                contentType: false,
                processData: false
                
            });     
        }
    });
    //delete supportive services

    function delete_servicedata(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Asset/delete_service', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if (obj.status == 1) {
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });

                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_supportive_service_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {

                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);

                                        $("#institute_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //        "order": [[4, 'asc']],
                                            "aoColumnDefs": [
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [0]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [1]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [2]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [3]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });

                            } else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                            }
                        });

                        /*$.alert('Successfully <strong>Deleted..!</strong>');*/
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
    //view service data
     function view_servicedata(id)
    {
       $.ajax({
            url: '<?php echo base_url();?>backoffice/Asset/get_serviceData_by_id',
            type: 'POST',
            data: {
                id:id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {

                var obj = JSON.parse(response);
               //alert(obj['parent_institutes']);
                $("#show_title").html(obj.description);
                $("#show_type").html(obj.type);

                //$("#edit_type").val(obj.institute_type_id);
                if(obj.alert == "1")
                    {
                    $("#show_alert").html('Yes');
                    }
                else{
                    $("#show_alert").html('No');
                }
                $("#show_name").html(obj.contact_person);
                $("#show_number").html(obj.mobile_number);
                $("#show_email").html(obj.email_id);
                //$("#edit_file").html(obj.file);
                $("#show_from").html(obj.start_date);
                $("#show_to").html(obj.end_date);
               // $("#id").val(obj.id);
                $('#show').modal({
                        show: true
                        });




                //$(".loader").hide();

            }
        });
    }


</script>
