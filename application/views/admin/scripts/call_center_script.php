<script>
    $(document).ready(function(){
        $("#enquiry_type").change(function(){
            var enquiry_type = $('#enquiry_type').val();
            if (enquiry_type != "1" && enquiry_type != "" && enquiry_type == "Others") {
                $("#other").css("display","block");
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Call_center/get_other_type',
                    type: 'POST',
                    data: {
                        enquiry_type: enquiry_type,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    //  alert(response);

                        $("#other").html(response);
                        $(".loader").hide();
                    }
                });
            }
            else{
                $("#other").css("display","none");
            }
        });
        $("#course").change(function(){
            var course_id = $('#course').val();
            if (course_id == "0") {
                $("#others").css("display","inline-block");
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Call_center/get_progress',
                    type: 'POST',
                    data: {
                        course_id: course_id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                        $("#bb").css("display","none");
                        $("#others").html(response);
                        $(".loader").hide();
                    }
                });
            }
            else{
                $("#others").css("display","none");
                $("#bb").css("display","block");

            }
        });

        $('input[name=filter_date]').blur(function() {
            var date = $('#filter_date').val();
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Call_center/get_remainder_call_ajax',
                    type: 'POST',
                    data: {
                        date: date,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                        if(response!=0) {
                            $('#remaindercallcenter_table').DataTable().destroy();
                            $("#remaindercallcenter_table").html(response);
                            $("#remaindercallcenter_table").DataTable({
                                "searching": true,
                                "bPaginate": true,
                                "bInfo": true,
                                "pageLength": 10,
                    //             "order": [[4, 'asc']],
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
                                    },
                                    {
                                        'bSortable': false,
                                        'aTargets': [8]
                                    },
                                    {
                                        'bSortable': false,
                                        'aTargets': [9]
                                    }
                                ]
                            });    
                            $(".loader").hide();
                        } else {

                        }
                    }
                });
         });

        // $("#edit_enquiry_type").change(function(){
        //     var enquiry_type = $('#edit_enquiry_type').val();
        //     if (enquiry_type != "1" && enquiry_type != "" && enquiry_type == "Others") {
        //         $("#edit_other").css("display","block");
        //         $(".loader").show();
        //         $.ajax({
        //             url: '<?php echo base_url();?>backoffice/Call_center/get_edit_other_type',
        //             type: 'POST',
        //             data: {
        //                 enquiry_type: enquiry_type,
        //                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
        //             },
        //             success: function(response) {
        //             //  alert(response);
        //                 $("#edit_other").html(response);
        //                 $(".loader").hide();
        //             }
        //         });
        //     }
        //     else{
        //         $("#edit_other").css("display","none");
        //     }
        // });


        $('#remaindercallcenter_table').DataTable( { } );

        $('#callcenter_table1').DataTable( {})
    //     "pageLength" : 10,
    //     "processing": true, //Feature control the processing indicator.
    //     "serverSide": true, //Feature control DataTables' server-side processing mode.
    //     "language": {
    //     // "infoEmpty": "No records available.",
    // },
    //    // "order": [], //Initial no order.
    //      //"bSort": false,
    //      "bFilter": false,
    //     "ordering": false,
    //     "searchable" :true,
    //      "order": [
    //       [1, "asc" ]
    //     ],
      
    //     // Load data for the table's content from an Ajax source
    //         "ajax": {
    //         "url": "<?php echo base_url();?>backoffice/Call_center/cc_details_ajax",
    //         "type": "POST",
    //         data:{filter_cce:$("#filter_cce").val(),filter_name:$("#filter_name").val(),filter_course:$("#filter_course").val(),filter_number:$("#filter_number").val(),filter_status:$("#filter_status").val(),filter_sdate:$("#filter_sdate").val(),filter_edate:$("#filter_edate").val(),filter_enquiry :$("#filter_enquiry").val(),filter_place:$("#filter_place").val(),filter_cce:$("#filter_cce").val(),filter_rand_num:$("#filter_rand_num").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},

    //        },
    //      //Set column definition initialisation properties.
    //     "columnDefs": [
    //     { 
    //         "targets": [ 0 ], //first column / numbering column
    //         "orderable": false, //set not orderable
    //     },
    //     ],
    // } );




        var err_msg = '<?php echo $this->session->userdata('toaster_error') ?>';
        if(err_msg != ""){
            '<?php $this->session->set_userdata('toaster_error', ""); ?>';
            $.toaster({priority:'danger',title:'INVALID',message:err_msg});
        }

        var err_msg1 = '<?php echo $this->session->userdata('toaster_error') ?>';
        if(err_msg1 != ""){
            '<?php $this->session->set_userdata('toaster_error', ""); ?>';
            $.toaster({priority:'danger',title:'INVALID',message:err_msg1});
        }
        $('input[name=filter_sdate]').blur(function() {
             
            load_data();

        });
        $('input[name=filter_edate]').blur(function() {
            load_data();
        });

        load_data();
        function load_data(){
            var filter_name = $("#filter_name").val();
            var filter_course = $("#filter_course").val();
            var filter_number = $("#filter_number").val();
            var filter_status = $("#filter_status").val();
            var filter_sdate = $("#filter_sdate").val();
            var filter_edate = $("#filter_edate").val();
            var filter_enquiry = $("#filter_enquiry").val();
            var filter_place = $("#filter_place").val();
            var filter_rand_num = $("#filter_rand_num").val();
            var filter_cce = $("#filter_cce").val();
            $(".loader").show();
            $.ajax({
                url:"<?php echo base_url(); ?>backoffice/Call_center/fetch",
                method:"POST",
                data:{filter_cce:$("#filter_cce").val(),filter_name:$("#filter_name").val(),filter_course:$("#filter_course").val(),filter_number:$("#filter_number").val(),filter_status:$("#filter_status").val(),filter_sdate:$("#filter_sdate").val(),filter_edate:$("#filter_edate").val(),filter_enquiry :$("#filter_enquiry").val(),filter_place:$("#filter_place").val(),filter_cce:$("#filter_cce").val(),filter_rand_num:$("#filter_rand_num").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data){
                    // if(data!='') {
                    $('#result').html(data);
                    $("#callcenter_table").DataTable({
                        "searching": true,
                        "bPaginate": true,
                        "bInfo": true,
                        "pageLength": 10,
                //      "order": [[4, 'asc']],
                        "aoColumnDefs": [
                            {
                                'bSortable': false,
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
                            },
                            {
                                'bSortable': false,
                                'aTargets': [9]
                            }
                        ]
                    }); 
                    $(".loader").hide();
                // }else{
                //     $("#export").remove();
                // }
            }
            })
        // }
        }

        $('.filter_class').keyup(function(){
            var inputLength = $(this).val();
            if (inputLength.length >= 3) {
                load_data();
            } else {
				$.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/fetch',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        $('#callcenter_table').DataTable().destroy();
                                        $("#callcenter_table").html(response);
                                        $("#callcenter_table").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [9]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
			}
        });
        $('.filter_change').change(function(){
            var inputLength = $(this).val();
            // if (inputLength.length > 1) {
                load_data();
            // }
        });
        $('.filter_class').bind('paste', function(e) {
            var inputLength = $(this).val();
            if (inputLength.length > 1) {
                load_data();
            } else {
				$.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/fetch',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        $('#callcenter_table').DataTable().destroy();
                                        $("#callcenter_table").html(response);
                                        $("#callcenter_table").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [9]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
			}
        });

        $('#reset_form').click(function() {
            window.location.href=window.location.href;
        });


// 		jQuery.validator.addMethod("phoneno", function(phone_number, element) {
//     	    phone_number = phone_number.replace(/\s+/g, "");
//     	    return this.optional(element) || phone_number.length > 9 && 
//     	    phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
//     	}, "<br />Please specify a valid phone number");
//     	jQuery.validator.addMethod("specialChar", function(value, element) {
//      return this.optional(element) || /([0-9a-zA-Z\s])$/.test(value);
//   }, "Please Fill Correct Value in Field.");
$.validator.addMethod("valueNotEquals", function(value, element, arg){
    if($("#enquiry_type").val()=="Course related" && $("#branch_id").val()==0){
            return arg !== value;
    }
    // return arg !== value;
 }, "Value must not equal arg.");
    var validation=0;
    $("form#add_call_center_form").validate({
        rules: {
            enquiry_type :{required: true},
            name: {required: true,letters: true},
            caller_details: {required: true},
            course_id: {
                required: function(element) {
                    if ($("#enquiry_type").val()=="Course related") {
                        return true;
                    }else{
                        return false;
                    }
                }
            },
            landline: {number:true,
                minlength: 6,
                        maxlength: 12,},
            comments: {required: true},
            // course_id: {required: true},
            primary_mobile: {required: true,
                            number:true,
                            minlength: 10,
                            maxlength: 12,
                            remote: {
                                url: '<?php echo base_url();?>backoffice/Call_center/primary_mobileCheck',
                                type: 'POST',
                                data: {
                                    primary_mobile: function() {
                                        return $( "#primary_mobile" ).val();
                                        },
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    }
                            }

                        },
            father_mobile: { 
                            number:true,
                            minlength: 10,

                            maxlength: 12
                            },
            mother_mobile: {
                            number:true,
                            minlength: 10,

                            maxlength: 12
                            },
            email_id: { 
                        email:true,
                        remote: {
                                    url: '<?php echo base_url();?>backoffice/Call_center/emailCheck',
                                    type: 'POST',
                                    data: {
                                        email_id: function() {
                                            return $( "#email_id" ).val();
                                            },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        }
                        }

                    }

            
        },
        messages: {
            enquiry_type :{required: "Please Choose an Enquiry Type"},
            caller_details :{required: "Please Choose a Caller Details"},
            course_id :{required: "Please Choose a Course"},
            // branch_id :{required: "Please Choose a Branch"},
            // branch_id: { valueNotEquals: "Please Choose a Branch" },
            name: {required:"Please Enter Name",letters:"Please Enter a Valid Name"},
            // street: {letters:"Please Enter a Valid Street Name" },
            landline:{number:"Please Enter Numbers Only",minlength: "Please enter a 6 digit number",maxlength: "Please enter a 12 digit number"},
            comments: {required:"Please Enter Description"},
            primary_mobile:{ required: "Please Enter Primary Contact Number",number:"Please Enter Numbers Only", minlength: "Please enter a 10 digit mobile number",maxlength: "Please enter a 12 digit mobile number", remote:"This Number Already Exist"},
            father_mobile:{
                            number:"Please Enter valid Father mobile",
                            minlength: "Please enter a 10 digit mobile number",
                            maxlength: "Please enter a 12 digit mobile number"},
            mother_mobile:{
                            number:"Please Enter valid Mother Number",
                            minlength: "Please enter a 10 digit mobile number",
                            maxlength: "Please enter a 12 digit mobile number"},
            email_id:{ 
                    email:"Please Enter Valid Email Id",
                    remote:"This Email-Id Already Exist"
                    },
           
        },
        submitHandler: function(form)

                                { $(".loader").show();
                                    validation=1;
                                }

 });
 $("form#add_call_center_form").submit(function(e) {
        //prevent Default functionality

        e.preventDefault();
         //debugger;
        if (validation == 1)
        {
           
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/call_center_add',
                type: 'POST',
                data: $("#add_call_center_form").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#add_call_center').modal('toggle');
                        $('#add_call_center_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Caller details added successfully' });
                        validation = 0;
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/fetch',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        $('#callcenter_table').DataTable().destroy();
                                        $("#callcenter_table").html(response);
                                        $("#callcenter_table").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [9]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
                        // setTimeout(function(){ window.location.reload(); }, 3000);
                        // alert("Succesfully Added");
                        clear_form();

                        // $("#add_call_center_form").trigger('reset');
                        $("#export").show();
                        $("#call_center_data").append(response);
                    }
                    else if(response == "2")
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Data Already Exist'});
                         
                    }
                    $(".loader").hide();
                }
            });
        }
    });
   

//          $('#edit_course').on('change',function(){
//            load_branch($("#edit_course").val());
//        });
        $('#edit_state').on('change',function(){
            load_district($("#edit_state").val());
        });
        var valid=0;
    $("form#add_followup").validate({
        rules: {
            date : {required: true},
            status: {required: true}
        },
        messages: {
            date: {required:"Please choose a date"},
            status: {required:"Please choose a status"}
        },
        submitHandler: function(form) 
        // {
        { 
        $(".loader").show();
            valid=1;
        }
    });
    $("form#add_followup").submit(function(e) {
        e.preventDefault();
         //debugger;
        if (valid == 1)
        {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/followup_add',
                type: 'POST',
                data: $("#add_followup").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#follow_up').modal('toggle');
                        $('#add_followup' ).each(function(){
                            this.reset();
                        });
                        $('#date').val('<?php echo date("d/m/Y H:i:s a");?>');//18/10/2019 04:38:11 PM
                        // $('#status').val('');
                        // $('#comment').val('');
                        // $('#followup_next_remainder').val('');
                        $.toaster({ priority : 'success', title : 'Success', message : 'Follow up details added succesfully' });
                        $('#history_tab').trigger("click");
                        $("#history_view").append(response);
                    }
                    else if(response == "2")
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Follow up already exist'});
                         
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    // var valids=0;
    // $("form#add_assigned").validate({
    //     rules: {
    //         assigned_to: {required: true}
    //     },
    //     messages: {
    //         assigned_to: {required:"Please choose a person"}
    //     },
    //     submitHandler: function(form) 
    //     // {
    //     { 
    //     $(".loader").show();
    //     valids=1;
    //     }
    // });

    // $("form#add_assigned").submit(function(e) {
    //     e.preventDefault();
    //      //debugger;
    //     if (valids == 1)
    //     {
    //         $.ajax({
    //             url: '<?php echo base_url();?>backoffice/Call_center/assigned_add',
    //             type: 'POST',
    //             data: $("#add_assigned").serialize(),
    //             success: function(response) {
    //                 if (response != "2" && response != "0") {
    //                     $('#assigned').modal('toggle');
    //                     $('#add_assigned').each(function(){
    //                         this.reset();
    //                     });
    //                     $.toaster({ priority : 'success', title : 'Success', message : 'Data added succesfully' });
    //                     $('#history_tab').trigger("click");
    //                     // $(function (){
    //                     //     $('#history_tab').click(get_follow_up_data);
    //                     // });
    //                     // setTimeout(function(){ window.location.reload(); }, 3000);
    //                     $("#history_view").append(response);
    //                 }
    //                 else if(response == "2")
    //                 {
    //                     $.toaster({priority:'danger',title:'Error',message:'Data already exist'});
                         
    //                 }
    //                 $(".loader").hide();
    //             }
    //         });
    //     }
    // });
    $("form#add_assigned").validate({
        rules: {
            assigned_to: { required: true }
        },
        messages: { assigned_to: "Please choose a person" },
        submitHandler: function(form) {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/assigned_add',
                type: 'POST',
                data: $("#add_assigned").serialize(),
                success: function(response) {
                    var obj=JSON.parse(response);
                    if (obj.st == 1) {
                        $('#assigned').modal('toggle');
                        $( '#add_assigned' ).each(function(){
                            this.reset();
                        });
                        $.toaster({priority:'success',title:'Success',message:obj.message});
                    }else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }
                }
            });
        }
    });



});



    var valid=0;
   
    $("form#edit_call_center_form").validate({
        rules: {
            enquiry_type :{required: true},
            // course_id :{required: true},
            // branch_id :{required: true},
            name: {required: true,letters: true},
            // street: {letters: true},
            landline: {number:true,
                minlength: 6,

                    maxlength: 12,},
             comments: {required: true},
            // course_id: {required: true},
            primary_mobile: {required: true,
                            required: true,
                            number:true,
                            minlength: 10,
                            maxlength: 12,
                            // remote: {
                            //     url: '<?php echo base_url();?>backoffice/Call_center/editprimary_mobileCheck',
                            //     type: 'POST',
                            //     data: {
                            //         primary_mobile: function() {
                            //             return $( "#edit_primary_mobile" ).val();
                            //             },
                            // <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            //         }
                            // }
                            remote: {
                            url: '<?php echo base_url();?>backoffice/Call_center/editprimary_mobileCheck',
                            type: 'POST',
                            data: {
                                email: function(){ return $("#edit_primary_mobile").val(); },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>',
                                hidden_user_id:  function(){ return $("#edit_call_id").val(); }
                            }  
                        }  

                        },
            father_mobile: { 
                            number:true,
                            minlength: 10,
                            maxlength: 12
                            },
            mother_mobile: { 
                            number:true,
                            minlength: 10,
                            maxlength: 12
                            },
            email_id: {
                        email:true,
                        remote: {
                            url: '<?php echo base_url();?>backoffice/Call_center/check_email_exists',
                            type: 'POST',
                            data: {
                                email: function(){ return $("#edit_email_id").val(); },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>',
                                hidden_user_id:  function(){ return $("#edit_call_id").val(); }
                            }  
                        }  
                    }

            
        },
        messages: {
            enquiry_type :{required: "Please Choose an Enquiry Type"},
            // course_id :{required: "Please Choose a Course"},
            // branch_id :{required: "Please Choose a Branch"},
            name: {required:"Please Enter Name",letters:"Please Enter a Valid Name"},
            // street: {letters:"Please Enter a Valid Street Name" },
            landline:{number:"Please Enter Numbers Only", minlength: "Please enter a 6 digit number",maxlength: "Please enter a 12 digit number"},
            comments: {required:"Please Enter Description"},
            primary_mobile:{ required: "Please Enter Primary Contact Number",number:"Please Enter Numbers Only", remote:"This Number Already Exist",minlength: "Please enter a 10 digit mobile number",maxlength: "Please enter a 12 digit mobile number"},
            father_mobile:{
                            number:"Please Enter valid Father mobile",
                            minlength: "Please enter a 10 digit mobile number",
                            maxlength: "Please enter a 12 digit mobile number"},
            mother_mobile:{
                            number:"Please Enter valid Mother Number",
                            minlength: "Please enter a 10 digit mobile number",
                            maxlength: "Please enter a 12 digit mobile number"},
            email_id:{ 
                    email:"Please Enter Valid Email Id",
                    remote:"This Email-Id Already Exist"
                    },
           
        },
        submitHandler: function(form)

                                { 

                                    // $(".loader").show();
                                    valid=1;
                                }

 });
 $("form#edit_call_center_form").submit(function(e) {
    //  alert("sfsd");
        //prevent Default functionality
        e.preventDefault();
         //debugger;
        if (valid == 1)
        {
            $(".loader").show();

            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/call_centers_edit',
                type: 'POST',
                data: $("#edit_call_center_form").serialize(),
                success: function(response) {
                    if (response == 1) {
                        // alert("modal");
                        // $('#edit_call_center_form').modal('hide');
                        // $('#edit_call_center_form').modal('hide'); //or  $('#IDModal').modal('hide');
                        // return false;
                        // setInterval(function (){
                        //     location.reload();
                        // }, 2500);
                        $('#edit_call_center').modal('toggle');

                        clear_form();
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/fetch',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        // $('#add_call_center').modal('toggle');    
                                        $('#callcenter_table').DataTable().destroy();
                                        $("#callcenter_table").html(response);
                                        $("#callcenter_table").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [9]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                        $.toaster({ priority : 'success', title : 'Success', message : 'Caller details updated succesfully' });
                                    } 
                                });
                            }
                }
            });

        }

    });
    
    // function'll get course fee details by center
    // @params course id
    // @author GBS-R
    // $('#center_id').change(function(){ 
    //         var course = $('#course').val();
    //         var branch_id = $('#branch_id').val();
    //         var center_id = $(this).val();
    //          $(".loader").show();
	// 		$.ajax({
    //             //url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_batch_details',
    //             url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_center_details', 
    //             type: 'POST',
    //             data: {course_id:course,branch_id:branch_id,center_id:center_id,
    //             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
    //             success: function(response)
    //             {
    //                 $(".loader").hide();
    //                 if(response!='') {
    //                     var obj = JSON.parse(response);
    //                     //$("#center_id").html(obj.centers);
    //                     $("#accordionExample").html(obj.batches);
    //                 } else {
    //                     $('#accordionExample').html('No batches added for this course.')
    //                 }
    //             }
    //         });
    //  });

    function delete_call_centers(id)
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
                                    url: '<?php echo base_url();?>backoffice/Call_center/delete_call_centers',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            $("#row_"+id).remove();
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/fetch',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#callcenter_table').DataTable().destroy();
                                        $("#callcenter_table").html(data);

                                        $("#callcenter_table").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [9]
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                                   $.toaster({priority:'success',title:'Success',message:obj.message});
                                           
                                           
                                        } else {
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

    function delete_followup(followup_id) {
        // alert(id);
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

                        $.post('<?php echo base_url();?>backoffice/Call_center/delete_followup/', {
                            followup_id: followup_id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            if (data == 1) {
                               
                                // setInterval(function (){
                                //     location.reload();
                                //     }, 2500);
                                //   $.alert('Successfully <strong>Deleted..!</strong>');
                                //  $("#row_"+followup_id).remove();
                                setTimeout(function(){
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                    $("#row_"+followup_id).remove();
                                }, 1000);
                            }
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
    function edit_enquiry_type(){
        // alert($('#edit_enquiry_type').val());
        var enquiry_type = $('#edit_enquiry_type').val();
        if (enquiry_type != "1" && enquiry_type != "" && enquiry_type == "Others") {
            $("#edit_other").css("display","block");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/get_edit_other_type',
                type: 'POST',
                data: {
                    enquiry_type: enquiry_type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                //  alert(response);
                    $("#edit_other").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            // alert($('#edit_enquiry_type').val());
            $("#edit_other").css("display","none");
        }
    }

function load_district(val,val1="0"){
    $(".loader").show();
    $.ajax({
        url: "<?php echo base_url('backoffice/Call_center/get_city'); ?>",
        type: "POST",
        data: {id: val,selected:val1,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function (data)
        {
            $("#edit_district").html(data);
            $(".loader").hide();
        }
    });
}

function load_branch(val,val1="0"){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_branch_details_cc', 
        type: "POST",
        data: {id: val,selected:val1,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function (data)
        {
            $("#edit_branch").html(data);
            $(".loader").hide();
        }
    });
}

    function get_val(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $(".loader").show();
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Call_center/get_val',
                            type: 'POST',
                            data:{id: id,selectid: $("#edit_list_status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                            success: function(response) {
                                if (response == "1") {
                                    $.alert('Successfully <strong>Changed..!</strong>');
                                }
                                $(".loader").hide();
                            }
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

      function get_val(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $(".loader").show();
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Call_center/get_val',
                            type: 'POST',
                            data:{id: id,selectid: $("#edit_list_status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                            success: function(response) {
                                if (response == "1") {
                                    $.alert('Successfully <strong>Changed..!</strong>');
                                }
                                $(".loader").hide();
                            }
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    // function'll get caller details
    // @params call id
    // @author GBS-L
    function get_details(id){
        // alert("sfdg");
         $(".loader").show();
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_call_center_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert("sfdg");
                //  $(".loader").hide();
                var obj = JSON.parse(response);
                var hostel = "";
                if(obj.hostel=='1'){
                    hostel=  "Yes";
                }else{
                    hostel= "No";
                }

                var cstatus = "";
                if(obj.call_status == '1'){
                    cstatus = "Call Received";
                }else if(obj.call_status == '2'){
                    cstatus = "In Progress";
                }else if(obj.call_status == '3'){
                    cstatus = "Closed";
                }else if(obj.call_status == '4'){
                    cstatus = "Blacklisted";
                }else if(obj.call_status == '5'){
                    cstatus = "Registered";
                }else{
                    cstatus = "Admitted";
                }

                    $("#show_enquiry_type").html(obj.enquiry_type);
                    $("#name").html(obj.name);
                    $("#pmobile").html(obj.primary_mobile);
                    $("#show_comments").html(obj.comments);
                    $("#email").html(obj.email_id);
                    $("#show_landline").html(obj.landline);
                    // alert(obj.nextremainder);
                    var userDate = '';
                    if(obj.nextremainder != null){
                        var userDate = obj.nextremainder;
                        var date_string = moment(userDate, "YYYY.MM.DD").format("DD-MM-YYYY");
                    }
                        // $("#results").html(date_string);
                    $("#show_nextremainder").html(date_string);
                    $("#progress_status").html(obj.progress);
                    $("#state_name").html(obj.state_name);
                    $("#show_caller_details").html(obj.caller_details);
                    $("#city").html(obj.city_name);
                    $("#street").html(obj.street);
                    $("#qualification").html(obj.qualification);
                    $("#show_course").html(obj.course_name);
                    $("#branch").html(obj.branch_name);
                    $("#center").html(obj.center_name);
                    $("#fmobile").html(obj.father_mobile);
                    $("#mmobile").html(obj.mother_mobile);
                    $("#show_source").html(obj.source);
                    $("#show_timing").html(obj.timing);
                    $("#show_call_status").html(cstatus);
                    $("#show_hostel").html(hostel);
                    $("#staff_name").html(obj.user_id);
                    $("#show_rand_num").html(obj.rand_num);
                    $("#rferenced_by").html(obj.referred_by);
                    $("#show_hotcold").html(obj.progress);
                    $("#secondarycourse").html(obj.seccoursenam);

                //  $("#show").modal('show');
                $('#show').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
        
    }

function get_editdata(id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Call_center/get_call_center_by_id/'+id,
        type: 'POST',
        async:false,
        data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
                    var obj=JSON.parse(response);
                        $("#edit_call_id").val(obj.call_id);
                        $("#edit_enquiry_type").val(obj.enquiry_type);
                        $("#edit_name").val(obj.name);
                        $("#edit_primary_mobile").val(obj.primary_mobile);
                        $("#edit_state").val(obj.state);
                        load_district(obj.state,obj.district);
                        $("#edit_street").val(obj.street);
                        $("#edit_qualification").val(obj.qualification);
                        $("#edit_caller_details").val(obj.caller_details);
                        $("#edit_course").val(obj.course_id);
                        $("#edit_branch").html(obj.branchoption);
                        $("#edit_center").html(obj.centeroption);
                        $("#edit_father_mobile").val(obj.father_mobile);
                        $("#edit_mother_mobile").val(obj.mother_mobile);
                        $("#edit_email_id").val(obj.email_id);
                        $("#edit_source").val(obj.source);
                        $("#edit_timing").val(obj.timing);
                        $("#edit_call_status").val(obj.call_status);
                        $("#edit_hostel").val(obj.hostel);
                        $("#edit_progress").val(obj.progress);
                        $("#edit_comments").val(obj.comments);
                        $("#nextremainder").val(obj.nextremainder);
                        //$("#edit_rand_num").val(obj.rand_num);
						$("#edit_referred_by").val(obj.referred_by);

                        $("#seccourse_edit").html(obj.seccourse);
                        getothers(obj.enquiry_type,obj.other_type);
                        getothercourse(obj.course_id,obj.other_course);

                        $('#edit_call_center').modal({
                            show: true
                        });
                        $(".loader").hide();
                    }
        
    });
// });
    edit_get_type();
    // edit_enquiry_type();
}


function getothers(enquiry_type,other_type){
    if (enquiry_type == "Others") {
                $("#edit_other").css("display","block");
                $("#edit_other_type").val();
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Call_center/get_edit_other_type',
                    type: 'POST',
                    data: {
                        enquiry_type: enquiry_type,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                        $("#edit_other").html(response);
                        $("#edit_other_type").val(other_type);
                        $(".loader").hide();
                    }
                });
            }
}
function getothercourse(course_id,other_course){
    if (course_id == "0") {
        $("#edit_others").css("display","block");
        $("#edit_bb").css("display","none");
        $("#edit_other_course").val();
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_edit_other_course',
            type: 'POST',
            data: {
                course_id: course_id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                $("#edit_bb").css("display","none");
                $("#edit_others").html(response);
                $("#edit_other_course").val(other_course);
                $(".loader").hide();
            }
        });
    }
}
function get_follow_up_data(id){
  $("#assigned_call_id").val(id);
  $("#follow_call_id").val(id);
  $("#history_call_id").val(id);
// alert(his);
   //$(".loader").show();
   $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/get_followup_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                    var table = "<tr><th>Sl. No.</th><th>Date & Time</th><th>Status</th><th>Comments</th><th>Next Remainder Date</th><th>Action</th></tr>";
                    var j = 0;
                    $.each(obj, function (i, v) {
                        j++;
                        var status = "";
                        if(v.status == '1'){
                            status = "Answered";
                        }else if(v.status == '2'){
                            status = "No Answer";
                        }else{
                            status = "Busy";
                        }
                        table += "<tr id=row_"+v.followup_id+"><td>"+j+"</td><td>"+v.date+"</td><td>"+status+"</td><td>"+v.comment+"</td><td>"+v.followup_next_remainder+"</td><td><a class='btn btn-default option_btn' style='width:auto;' title='Delete' onclick='delete_followup("+v.followup_id+")'><i class='fa fa-trash-o'></i></a></td></tr>";
                    });
                    $("#history_view").html(table);
                    $(".loader").hide();
                    // $("#date").html(obj.date);
                    // $("#comment").html(obj.comment);
                }
            });
}

    function get_city(){
        // $('#state').on('change',function(){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Call_center/get_city'); ?>",
                type: "POST",
                data: {id: $('#state').val(),selected:0,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#district").html(data);
                    $(".loader").hide();
                }
            });
        // });
    }
    function get_editcity(){
        // $('#state').on('change',function(){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Call_center/get_city'); ?>",
                type: "POST",
                data: {id: $('#edit_state').val(),selected:0,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#edit_district").html(data);
                    $(".loader").hide();
                }
            });
        // });
    }

    function get_type(){
        $(".loader").show();
        var enquiry_type = $('#enquiry_type').val();
        if(enquiry_type =="Course related"){
            
            $("#course_label").removeClass("mandatoryhidden");
            $("#branch_label").removeClass("mandatoryhidden");

        }else{
            $("#course_label").addClass("mandatoryhidden");
            $("#branch_label").addClass("mandatoryhidden");

        }
        $(".loader").hide();
    }
    function edit_get_type(){
        $(".loader").show();
        // alert($('#edit_enquiry_type').val());
        var enquiry_type = $('#edit_enquiry_type').val();
        if(enquiry_type =="Course related"){
            
            $("#edit_course_label").removeClass("mandatoryhidden");
            $("#edit_branch_label").removeClass("mandatoryhidden");

        }else{
            $("#edit_course_label").addClass("mandatoryhidden");
            $("#edit_branch_label").addClass("mandatoryhidden");

        }
        $(".loader").hide();
    }

     function get_branch(){
    //   $("#course").change(function () {
            $("#branch_id").html('');
            $("#center_id").html('');
            $(".loader").show();
            // var course_id = $(this).val();
            var course_id = $('#course').val();
           $(".loader").show();
			 $.ajax({

                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_branch_details_cc', 
                type: 'POST',
                data: {course_id:course_id,selected:0,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    if(response!='') {
                    $("#branch_id").html(response);
                    } else {
                        //$('#accordionExample').html('No batches added for this course.')
                    }
                }
            });
    // });
    }

    

$(function () {
    $('.datetime').datetimepicker();
    // format:'DD/MM/YYYY HH:mm:ss',
});

$(function () {
    $('.datetimenext').datetimepicker({minDate: new Date(),format:'DD/MM/YYYY'});
    //format:'DD/MM/YYYY',
});


    // function'll get course fee details
    // @params course id
    // @author GBS-R
 
    function get_center(){
      
    // $("#branch_id").change(function () {
            var branch_id = $('#branch_id').val();
            var course_id = $('#course').val();

             $(".loader").show();

			$.ajax({

                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_center_details', 
                type: 'POST',
                data: {course_id:course_id,branch_id:branch_id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    if(response!='') {
                        var obj = JSON.parse(response);
                        if(obj.data.st=="0") {
                            $("#center_id").html(obj.centers);
                            $("#accordionExample").html(obj.batches);
                            //$.toaster({priority:'danger',title:'INVALID',message:obj.data.message});
                        }else {
                            $("#center_id").html(obj.centers);
                            $("#accordionExample").html(obj.batches);
                        }
                    }
                    // else if(obj.st=="1"){
                    //     $("#center_id").html(obj.centers);
                    //     $("#accordionExample").html(obj.batches);
                    // }
                     else {
                        // $('#accordionExample').html('No batches added for this course.')
                        $("#center_id").html(obj.centers);
                        $("#accordionExample").html(obj.batches);
                    }
                }
            });
    // });
    }

    

    
    // FOR EDIT 
    function get_editbranch(){
    //   $("#edit_course").change(function () {
            $("#edit_branch").html(''); 
            $("#edit_center").html('');
            $(".loader").show();
            var course_id = $("#edit_course").val();
           $(".loader").show();
			 $.ajax({

                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_branch_details_cc', 
                type: 'POST',
                data: {course_id:course_id,selected:0,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    if(response!='') {
                    $("#edit_branch").html(response);
                    } else {
                        //$('#accordionExample').html('No batches added for this course.')
                    }
                }
            });
    // });
        }
    
    // EDIT
    function get_editcenter(){
      
    // $("#edit_branch").change(function () {
            var branch_id = $("#edit_branch").val();
            var course_id = $('#edit_course').val();
             $(".loader").show();

			 $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_center_details', 
                type: 'POST',
                data: {course_id:course_id,branch_id:branch_id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    
                    if(response!='') {
                         var obj = JSON.parse(response);
                        if(obj.data.st==0) {
                           
                        //$('#accordionExample').html('No batches added for this course.')
                        $("#edit_center").html(obj.centers);
                        $.toaster({priority:'danger',title:'INVALID',message:obj.data.message});

                    }else{
                       
                        $("#edit_center").html(obj.centers);
                        //$("#accordionExample").html(obj.batches);
                    }
                    } else{
                        
                    }
                }
            });
    // });
        }
    
    
    
    $("#feecourse").change(function () {
            $("#feebranch_id").html('');
            $("#center_id").html('');
            $(".loader").show();
            var course_id = $(this).val();
           $(".loader").show();
			 $.ajax({

                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_branch_details_cc', 
                type: 'POST',
                data: {course_id:course_id,selected:0,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    if(response!='') {
                    $("#feebranch_id").html(response);
                    } else {
                        //$('#accordionExample').html('No batches added for this course.')
                    }
                }
            });
    });
    
    
    $("#feebranch_id").change(function () {
            var branch_id = $(this).val();
            var course_id = $('#feecourse').val();
             $(".loader").show();

			 $.ajax({

                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_center_details', 
                type: 'POST',
                data: {course_id:course_id,branch_id:branch_id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    var obj = JSON.parse(response);
                    if(obj.batches!='') {
                        $("#accordionExample").html(obj.batches);
                    } else {
                        $('#accordionExample').html(obj.message);
                    }
                }
            });
    });

    function clear_form() {
        $("form.add-edit").find("input,textarea,select").each(function(index, element) {
            if ($(element)) {
                var tag = $(element)[0].tagName;
                switch (tag) {
                    case "INPUT":
                        $(element).not(':checkbox').not('.exclude-status').val("");
                        if ($(element).not('.exclude-status').is(":checkbox")) $(element).prop('checked', false);
                        break;
                    case "TEXTAREA":
                        $(element).not('.exclude-status').val("");

                        break;
                    case "SELECT":
                        if ($(element).hasClass("exclude-status")) $(element).val("");
                        var choose_an_item = 0;
                        $(element).find('option').each(function() {
                            if ($(element).val() == "") {
                                choose_an_item = 1;
                            }
                        });
                        if (choose_an_item == 1) {
                            $(element).val("");
                        } else {
                            $(element).val("1");
                        }
                        if ($(element).hasClass("exclude-this")) $(element).val("1");
                        if ($(element).hasClass("exclude-banner")) $(element).val("_blank");
                        break;
                    default:
                        return false;
                }
            }
        });
    }


    function edit_assigned_status(id,status)
        {
            
        $.confirm({
            title: 'Alert message',
            content: 'Are you sure you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Ok',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/assigned_status',
                                    type: 'POST',
                                    data: {
                                        assigned_id: id,
                                        assigned_status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    
                                    success: function(response) {
                                        // alert("sfsdfs");
                                        if (response != "2" && response != "0") {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/load_approve_reference_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);
                                        $("#syllabus_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //      "order": [[4, 'asc']],
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
                                                }
                                                // ,
                                                // {
                                                //     'bSortable': false,
                                                //     'aTargets': [4]
                                                // },
                                                // {
                                                //     'bSortable': false,
                                                //     'aTargets': [5]
                                                // }
                                            ]
                                        });
                                    }
                                   });
                                    $.toaster({priority:'success',title:'Success',message:'Status Changed Successfully!'});
                                            //$("#row_"+id).remove();
                                        }
                                        // else {
                                           
                                        //      $.toaster({priority:'warning',title:'Success',message:'Invalid Request!'});
                                        // }
                                        $(".loader").hide();
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



        function get_statusval(id) {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_assigned_val',
            type: 'POST',
            data:{id: id,selectid: $("#reject_status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                if (response == "1") {
                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Call_center/load_approve_assigned_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);
                                        $("#syllabus_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //      "order": [[4, 'asc']],
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
                                                }
                                                // ,
                                                // {
                                                //     'bSortable': false,
                                                //     'aTargets': [4]
                                                // },
                                                // {
                                                //     'bSortable': false,
                                                //     'aTargets': [5]
                                                // }
                                            ]
                                        });
                                    }
                                   });
                }
                $(".loader").hide();
                $("#leave_id").val(id);
                $("#status").val(status);
                $('#description_modal').modal({
                    show: true
                });
            }
        });
    }
    function export_data(type){
        $('#type').val(type);
        form = $('#filter_form');
        form.submit();
    }
</script>

