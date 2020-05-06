<script type="text/javascript">
    $(document).ready(function () {
        $("#chartBlockBtn").click(function () {
            remove_day_timings();
            $("#faculty_availability_form").trigger('reset');
            $("#chartBlock").addClass("show");
            $(".close_btn").fadeIn("200");
        });
        $("#chartBlockBtnEdit").click(function () {
            remove_day_timings();
            $("#faculty_availability_form").trigger('reset');
            $("#chartBlock").addClass("show");
            $(".close_btn").fadeIn("200");
        });
        $(".close_btn").click(function () {
            $(this).hide();
            $(".batch_days").html("");
            $("#chartBlock").removeClass(("show"));
        });
        $(".date-close").click(function(){
            remove_day_timings();
        });
    });
    function remove_day_timings(){
        $("#sunday").prop('checked', false);
        $("#monday").prop('checked', false);
        $("#tuesday").prop('checked', false);
        $("#wednesday").prop('checked', false);
        $("#thursday").prop('checked', false);
        $("#friday").prop('checked', false);
        $("#saturday").prop('checked', false);
        $("#sunday_div").html("");
        $("#monday_div").html("");
        $("#tuesday_div").html("");
        $("#wednesday_div").html("");
        $("#thursday_div").html("");
        $("#friday_div").html("");
        $("#saturday_div").html("");
    }
     $(function () {
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
             $('#last_date').data("DateTimePicker").maxDate(e.date);
            
        });
         
         //last date of admission sholud be lessthan end date
         $('#last_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         $("#last_date").on("dp.change", function (e) {
           //  alert("jhb");
           // $('#end_date').data("DateTimePicker").maxDate(e.date);
        }); 
         //time validate
         $('#start_time').datetimepicker();
        $('#end_time').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#start_time").on("dp.change", function (e) {
            $('#end_time').data("DateTimePicker").minDate(e.date);
        });
        $("#end_time").on("dp.change", function (e) {
            $('#start_time').data("DateTimePicker").maxDate(e.date);
        });
    });
    

    function edit_staff_status(id,status)
    {      
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/edit_staff_status',
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $(".loader").hide();
                    
                    if (obj.st == 1) 
                    {
                     $.toaster({ priority : 'success', title : 'Success', message : obj.msg});
                        $.ajax({
                                url: '<?php echo base_url();?>backoffice/Staff/load_staffList',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {

                                        $('#staff_table').DataTable().destroy();
                                        $("#staff_table").html(response);

                                        $("#staff_table").DataTable({
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
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }
                                            ]
                                        });
                                }
                            });
                    }
                    else if(obj.st == 2) {
                       $.toaster({ priority : 'warning', title : 'Warning', message : obj.msg}); 
                    }
                    else if(obj.st == 0) {
                       $.toaster({ priority : 'danger', title : 'Invalid', message : obj.msg}); 
                    }
                    else{
                         $.toaster({ priority : 'danger', title : 'Invalid', message : "Something went wrong,Please try again later..!"});
                        }
                }
            }); 
     
    }
    
// Id Card ---------------------------------------
  
    function idCard_call(id){
        $("#loader").show();
        // alert("don");
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/get_staff_idcard_preview/'+id,
                type:'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(data) {
                    // alert(data);
                    var obj = JSON.parse(data);
                    $("#idCard").html(obj.html);
                    $("#loader").hide();
                }
        });
    }

    $("#filter_role").change(function(){
       var role= $("#filter_role").val();
        if(role == "faculty")
            {
              $("#show_subject").css('display','block'); 
            }
        else{
             $("#show_subject").css('display','none'); 
            }
        
    });
       
    function load_data(){

            var filter_name = $("#filter_name").val();
            var filter_role = $("#filter_role").val();
         var subject="";
        if(filter_role == "faculty")
            { 
             subject = $("#filter_subject").val();
            }
        else{
             $("#filter_subject").val("");
        }
            $(".loader").show();
            $.ajax({
                url:"<?php echo base_url(); ?>backoffice/Staff/fetch",
                method:"POST",
                data:{
                    subject:subject,
                    filter_role:$("#filter_role").val(),
                    filter_name:$("#filter_name").val(),
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data){
                    // if(data!='') {
                    $('#result').html(data);
                    $("#staff_table").DataTable({
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

    $(document).ready(function(){
        $('.filter_class').keyup(function(){
            var inputLength = $(this).val();
            if (inputLength.length >= 3) {
                load_data();
            }
        });
        $('.filter_change').change(function(){
            var inputLength = $(this).val();
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
        /*filter in manage faculty*/
         function load_filterdata(){

            var filter_name = $("#filter_facultyname").val();
            var filter_centre = $("#filter_centre").val();
    
            $(".loader").show();
            $.ajax({
                url:"<?php echo base_url(); ?>backoffice/Staff/fetch_facultydata",
                method:"POST",
                data:{
                    name:filter_name,
                    centre:filter_centre,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data){
                   
                    $('#institute_data').DataTable().destroy();
                    $("#institute_data").html(data);
                    $("#institute_data").DataTable({
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
                            }
                        ]
                    });
                    $(".loader").hide();
                
            }
            })
        
        }
            
         $('#filter_centre').change(function(){
            var inputLength = $(this).val();
             load_filterdata();
           
        });
        
        
            $('#filter_facultyname').keyup(function(){
                var inputLength = $(this).val();
                if (inputLength.length >= 3) {
                    load_filterdata();
                }
            });
        /*****/
        $('#reset_form').click(function() {
            window.location.href=window.location.href;
        });


                $(".sslcpercentage").keyup(function(){
                    var num=$(this).val();
                    if(num > 100)
                        {
                            $(this).val("");
                            $("#sslc_marks_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#sslc_marks_msg").html("");
                        }        
                }); 
                $(".plustwopercentage").keyup(function(){
                    var num=$(this).val();
                    if(num > 100)
                        {
                            $(this).val("");
                            $("#plustwo_marks_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#plustwo_marks_msg").html("");
                        }        
                }); 
                $(".degreepercentage").keyup(function(){
                    var num=$(this).val();
                    if(num > 100)
                        {
                            $(this).val("");
                            $("#degree_marks_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#degree_marks_msg").html("");
                        }        
                }); 
                $(".pgpercentage").keyup(function(){
                    var num=$(this).val();
                    if(num > 100)
                        {
                            $(this).val("");
                            $("#pg_marks_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#pg_marks_msg").html("");
                        }        
                }); 
                $(".otherspercentage").keyup(function(){
                    var num=$(this).val();
                    if(num > 100)
                        {
                            $(this).val("");
                            $("#others_marks_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#others_marks_msg").html("");
                        }        
                }); 



        $('.typeswitch').on('click',function(){ 
            if($(this).val()==1) {
                // $('#weeklydiv').show();
                $('.daterange').hide();
                // $("#start_date").val("");
                // $("#end_date").val("");

            } else {
                $('.daterange').show();
                // $('#weeklydiv').hide();
                // $(".add_check").prop("checked", false);
            }
        });
        
        $('#spouse_country').on('change',function(){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Staff/get_state'); ?>",
                type: "POST",
                data: {id: $(this).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#spouse_state").html(data);
                    $(".loader").hide();
                }
            });
            // $(".loader").hide();

        });
        $('#spouse_state').on('change',function(){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Staff/get_city'); ?>",
                type: "POST",
                data: {id: $(this).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#spouse_city").html(data);
                    $(".loader").hide();
                }
            });
        });
        $('#father_country').on('change',function(){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Staff/get_state'); ?>",
                type: "POST",
                data: {id: $(this).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#father_state").html(data);
                    $(".loader").hide();
                }
            });
        });
        $('#father_state').on('change',function(){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Staff/get_city'); ?>",
                type: "POST",
                data: {id: $(this).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#father_city").html(data);
                    $(".loader").hide();
                }
            });
            // $(".loader").hide();
        });

        $("#group_name").change(function(){
        var group = $('#group_name').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#branch_name").html(response);

                    }
                });
                $(".loader").hide();
        }
    });

    $("#branch_name").change(function(){
        var branch = $('#branch_name').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center_name").html(response);
                 
                    
                    
                    
                    
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });

     $("#center_name").change(function(){
        var center = $('#center_name').val();

        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_centercoursemapping',
                type: 'POST',
                data: {
                    center_id: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#course_name").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });
        
        
    $("form#faculty_availability_form").validate({
        rules: {
            faculty: {required: true},
            group_name: {required: true},
            branch_name: {required: true},
            center_name: {required: true}
        },
        messages: {
            faculty: {required:"Please select faculty"},
            group_name: {required:"Please select institute"},
            branch_name: {required:"Please select branch"},
            center_name: {required:"Please select center"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/faculty_availability_action',
                type: 'POST',
                data: $("#faculty_availability_form").serialize(),
                success: function(response) { 
                     var obj = JSON.parse(response);
			         if (obj.status == true) {
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Staff/faculty_availability_loadajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) { 
                                    $("#faculty_availability_form").trigger('reset');
                                    $("#chartBlock").removeClass(("show"));
                                    remove_day_timings();
                                    // $('#myModal').modal('toggle');    
                                        $('#faculty_data').DataTable().destroy();
                                        $("#faculty_data").html(response);
                                        $("#faculty_data").DataTable({
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
                                                }
                                            ]
                                        }); 
                                }
                            });
                         $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                     }
                    else if(obj.status == 2)
                            {
                               $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                            }
                            else {
                        $.toaster({priority:'danger',title:'Error',message:obj.message}); 
                     }
                    
                    $(".loader").hide();
                }
            });
        }
    });
    jQuery.validator.addMethod("pan", function(value, element)
    {
        return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
    }, "Please enter a valid PAN");
     //add employee
        var validation=0;
        $("form#add_personal_details_form").validate({
        rules: {
            name: {required: true},
            role: {required: true},
            dob: {required: true},
            blood_group: {required: true},
            mobile: {required: true,
                    number:true,
                            minlength: 10,
                            maxlength: 12,
                            // remote: {
                            //     url: '<?php echo base_url();?>backoffice/Staff/primary_mobileCheck',
                            //     type: 'POST',
                            //     data: {
                            //         primary_mobile: function() {
                            //             return $( "#mobile" ).val();
                            //             },
                            // <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            //         }
                            // }
            },
            landline: {
                number:true,
                minlength: 6,
                maxlength: 11
            },
            pan_no : {pan: true},
            email: {
                required: true,
                email:true,
                emailValidate:true
            },
            spouse_country: {required: true},
            spouse_state: {required: true},
            spouse_city: {required: true},
//            body_reg: {required: true},
//            pan_no: {required: true},
//            ac_no: {required: true},
//            ifsc_code: {required: true},
            aadhar_no: {required: true,
                number:true,
                minlength: 12,
                maxlength: 12},
            permanent_address: {required: true}

        },
        messages: {
            name: {required:"Please enter a name"},
            role: {required:"Please choose a role"},
            blood_group: {required:"Please choose a blood group"},
            dob: {required:"Please choose a date"},
            mobile: {required: "Please Enter Primary Contact Number",
                     number:"Please Enter Numbers Only", 
                     minlength: "Please enter a 10 digit mobile number",
                     maxlength: "Please enter a 12 digit mobile number"/*, remote:"This Number Already Exist"*/},
                     landline:{number:"Please Enter Numbers Only",minlength: "Please enter a 6 digit number",maxlength: "Please enter a 12 digit number"},
            pan_no : {pan: "Please enter a valid PAN"},
            email: {
                required:"Please enter the email",
                email:"Please enter valid email",
                emailValidate:"Please enter valid email"

            },

            spouse_country: {required:"Please select country"},
            spouse_state: {required:"Please select state"},
            spouse_city: {required:"Please select city"},
//            body_reg: {required:"Please enter body registration, if applicable"},
//            pan_no: {required:"Please enter pan number"},
//            ac_no: {required:"Please enter account number"},
//            ifsc_code: {required:"Please enter ifsc code"},
            aadhar_no: {required:"Please enter aadhar number",number:"Please Enter Numbers Only", minlength: "Please enter 12 digit number",maxlength: "Please enter 12 digit number"},
            permanent_address: {required:"Please enter permanent address"}
        },
        submitHandler: function(form) {
            validation=1;

        }
    });

      $("form#add_personal_details_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();

        if (validation == 1) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/staff_personal_add',
                type: 'POST',
                data: new FormData(this),
                               
                processData: false,
                contentType: false,
                success: function(response) {
                    //$(".loader").hide();
                    var obj=JSON.parse(response);

                    if (obj.st== 1) {

                       $.toaster({ priority : 'success', title : 'Success', message : 'Successfully added' });

                        $("#edit_personal_id").val(obj.id);
                        $(".educational_qualification").trigger("click");
                        setInterval(function (){
                            // location.reload();
                            // $(".educational_qualification").trigger("click");

                            window.location.href = "<?php echo base_url('backoffice/manage-staff/');?>"+obj.id;

                        }, 2000);
                        // window.location.href = "<?php echo base_url('backoffice/manage-staff/');?>"+obj.id;

                    }                                                         
                    else if(obj.st == 2)
                    {
                        $.toaster({priority:'warning',title:'Error',message:'Mobile number/Email already exists'});

                    }
                    else if(obj.st == 3)
                    {
                       $.toaster({priority:'warning',title:'Invalid',message:obj.msg});
                    }
                    else {
                        $.toaster({priority:'danger',title:'Error',message:"Something went wrong,please try again later...!"});
                    }
                    $(".loader").hide();
                }
            });
        }
     });


      $("form#add_educational_qualification_form").validate({
        submitHandler: function(form) {
            // $('#Submitbutton').attr('disabled', true);
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/staff_education_add',
                type: 'POST',
                // data: {id: $(this).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#add_educational_qualification_form").serialize(),
                success: function(response) { 
                    if (response != "-1" && response != "0") {
                        $.toaster({ priority : 'success', title : 'Success', message : 'Successfully added' });
                        // $("#staff_personal_data").append(response);
                        $("#edit_personal_id").val(response);
                        $(".work_experience").trigger("click");
                        // $('#Submitbutton').attr('disabled', false);
                        //  window.location.href = "<?php echo base_url('backoffice/staff-list');?>";
                    }
                    else if(response == "2")
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Already Exist'});
                         
                    }
                    $(".loader").hide();
                }
            });
        }
    });
    
    $("form#add_work_experience_form").validate({
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/staff_experience_add',
                type: 'POST',
                // data: {id: $(this).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#add_work_experience_form").serialize(),
                success: function(response) { 
                    //if (response != "-1" && response != "0") {
                     if (response != "-1") {
//                        $('#add_work_experience_form' ).each(function(){
//                            this.reset();
//                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Successfully added' });
                        // $("#staff_personal_data").append(response);
                        $("#edit_personal_id").val(response);
                        $(".other_details").trigger("click");
                        // window.location.href = "<?php echo base_url('backoffice/staff-list');?>";
                    }
                    else if(response == "2")
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Already Exist'});
                         
                    }
                    $(".loader").hide();
                }
            });
        }
    });
        
        $("#branch").change(function(){
        var branch = $('#branch').val();
        
        if (branch != "") {
                $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center").html(response);
                    $(".loader").hide();
                }
            });
             
        }
        else{
            $("#edit_div").css("display","none");
        }
    });    

        jQuery.validator.addClassRules("primary", {
        required: true
    });


    $("form#edit_subject_form").validate({
          rules: {
            primary: {
                required: true
            }
          },
        messages: {
            primary: "Please Choose a Primary Subject",
        },

        submitHandler: function(form) {
           /* var subject_id=$("select[name=strong_subject").val();
            console.log(subject_id); 
            return false;
            
            var selected = [];
            var unselected = [];
            $("input:checkbox[name=selected_question]:checked").each(function(){
            selected.push($(this).val());
            });
            $("input:checkbox[name=selected_question]").each(function(){
            if(selected != ''){
            if($.inArray($(this).val(),selected) == -1){
            unselected.push($(this).val());
            }
            }
            });*/
           $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/faculty_subjectupdate',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#edit_subject_form").serialize(),
                success: function(response) {
                        var obj = JSON.parse(response);
			         if (obj.status == true) {
                         $("#edit_personal_id").val(response);
                         $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                        //$(".proofs").trigger("click");
                         //$.alert(obj.message);
                        }
                        else
                        {
                             $.toaster({priority:'danger',title:'Error',message:obj.message});
                            //$.alert(obj.message);
                        }
                        $(".loader").hide();
                }
            });
        }
    });

            $("form#edit_approval_form").validate({
            rules: {
            designation: {required: true},
            department: {required: true},
            entry_type: {required: true},
            biometric_id: {required: true},
            branch: {required: true},
            salary_scheme_id: {required: true},
            leave_scheme_id: {required: true},
            center: {required: true},
            joining_date: {required: true},
            reporting_head: {required: true} 
                
        },
        messages: {
            designation: {required:"Please Select Designation"},
            department: {required:"Please Select Department"},
            entry_type: {required:"Please Select Entry Type"},
            biometric_id: {required:"Please Enter Biometric ID"},
            branch: {required:"Please Select Branch"},
            salary_scheme_id: {required:"Please Select Salary Scheme"},
            leave_scheme_id: {required:"Please Select Leave Scheme"},
            center: {required:"Please Select Center"},
            joining_date: {required:"Please Select a Joining Date"},
            reporting_head: {required:"Please Select a Reporting Head"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            // alert();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/staff_approvalform',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#edit_approval_form").serialize(),
                success: function(response) {
                        var obj = JSON.parse(response);
			         if (obj.status == true) {
                        $("#edit_personal_id").val(response);
                        //$(".proofs").trigger("click");
                         if($('#staffrole').val()=='faculty') {
                         $('#subjectt').hide();
                         $('#subjecttab').show();
                         $(".subject").trigger("click");
                         }
                        $.toaster({ priority : 'success', title : 'Success', message : 'Staff details verified and approved.'});
                        }
                        else
                        {
                              $.toaster({priority:'danger',title:'Error',message:'Invalid data.'});
                        }
                        $(".loader").hide();
                }
            });
        }
    });
    
    // $("form#add_personal_details_form").validate({
    //     rules: {
    //         name: {
    //             required: true
    //         },
    //     },
    //     messages: {
    //         name: "Please Enter Class Name",
            
    //     },
    //     submitHandler: function(form) {
    //         $.ajax({
    //             url: '<?php echo base_url();?>backoffice/Staff/staff_personals_edit',
    //             type: 'POST',
    //             data: $("#add_personal_details_form").serialize(),
    //             success: function(response) {
    //                 if (response == "1") {
    //                              setInterval(function (){
    //                                 location.reload();
    //                                 }, 2500);
    //                     alert("Succesfully Updated");
                       
    //                         }
    //             }
    //         });

    //     }


    // });
         $("#strong_subject").change(function(){ 
             // var res = "";
             // var res_str = $("#module_holder").val();
             // if($("#module_holder").val() != null){
             //     var res_str1 = res_str.toString();
             //     res = res_str1.replace(',','-');
                 $("#module_selection_holder").css("display","block");
                     $.ajax({
                         url: '<?php echo base_url();?>backoffice/Staff/get_allsub_modules',
                         type: 'POST',
                         data: {
                             //subject_type_id: type,
                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                         },
                         success: function(response) {
                         //  alert(response);
                             $("#module_selection_holder").html(response);
                        
                         }
                     });
             // }
         });
        
        
         $("#entry_type").change(function(){ 
                    var type = $(this).val();
                if(type=='Training' || type=='Probation' || type=='Part-time' || type=='Daily hire') {
                    $("#loadtimeperiod").css("display","block");
                 } else {
                    $("#loadtimeperiod").css("display","none"); 
                 }
         });
        
        
    });

 var doc_validation=0;
    $("#document_form").validate({
        rules: { 
        },
        messages: {
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
                url: '<?php echo base_url();?>backoffice/Staff/upload_documents',
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
                        update_document_table($("#pers_id").val());
                                //    $("#reg4").removeClass("active");
                                //     $("#reg_4").removeClass("active");//li
                                // $("#reg5").removeClass("fade");
                                // $("#reg5" ).addClass("active");
                                // $("#reg_5" ).addClass("active");
                                $("#document_form").trigger("reset");
                                $(".approval").trigger("click");

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
        },
        messages: {
        },
        submitHandler: function(form) {
            doc1_validation=1; 
            
                
        }
    });
    
    $("form#all_qualification_form").submit(function(e) {
        e.preventDefault();
        if (doc1_validation == "1" /*&& error== "0"*/) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/upload_documents_action',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if(obj.st==1){
                        $(".loader").hide();
                        $("#document_name1").removeAttr('readonly');
                        $("#all_qualification_form").trigger("reset");
                        update_document_table($("#pers_id").val());
                        // $("#reg4").removeClass("active");
                        // $("#reg_4").removeClass("active");//li
                        // $("#reg5").removeClass("fade");
                        // $("#reg5" ).addClass("active");
                        // $("#reg_5" ).addClass("active");
                        //$("#append_document").html(obj['first']);
                        //$("#staff_document_table").html(obj.data);
                        $(".approval").trigger("click");

                        $.toaster({ priority : 'success', title : 'Success', message : 'Successfully saved' });
                    }else if(obj.st == "2"){
                        $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if(obj.st == "3"){
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
    });
    








 $(document).on('click','#add_more', function(e) {
        createNewTextBox();
    });	

$('.myFile').bind('change', function() {

//this.files[0].size gets the size of your file.
  //alert(this.files[0].size);
  var size = this.files[0].size/1024;
  if(size><?php echo FILE_MAX_SIZE;?>) {
      $.toaster({priority:'danger',title:'INVALID',message:"The file you are attempting to upload is larger than the permitted size."});
      $(this).val('');
  }

});  

function update_document_table(personal_id){ alert(personal_id);
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/get_staff_documents',
                type:'POST',
                data: {id:personal_id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(data) {
                    $("#staff_document_table").html(data);alert(data);
                }
        });
    }

function validate(file) {
  var ext = file.split(".");
  ext = ext[ext.length-1].toLowerCase();
  var arrayExtensions = ["jpg" , "pdf", "docx", "doc","jpeg"];
// alert("sfsf");
  if (arrayExtensions.lastIndexOf(ext) == -1) {
      $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size or Unsupported file format' });
      $(".doc_upload").html("");
      // $('#submit').prop('disabled', false);
  }
}

function DateCheck(){
	   var startDate = $("#start_date").val();
       var endDate = $("#end_date").val();
	   var eDate = new Date(endDate);
	   var sDate = new Date(startDate);
	    if(startDate!= '' && endDate!= '' && sDate> eDate)
		{
        $.toaster({ priority : 'warning', title : 'Notice', message : 'Please ensure that the End Date is greater than or equal to the Start Date.' });

		// alert("Please ensure that the End Date is greater than or equal to the Start Date.");
		$("#end_date").val('');	
		return false;
		}
	
       

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
                                  url: '<?php echo base_url();?>backoffice/Staff/verify_document',
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
                                  url: '<?php echo base_url();?>backoffice/Staff/verify_document',
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
                  update_document_table($("#personal_id").val());
              },
          }
      });
  }

function update_document_table(personal_id){
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/get_staff_documents',
                type:'POST',
                data: {id:personal_id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(data) {
                    $("#staff_document_table").html(data);
                }
        });
    }


    function createNewTextBox(){
        var counter = $("#counter").val();
	    counter++;
        $("#counter").val(counter);
        var html = '';
        html +='<div class="add_wrap" id="new_textbox' + counter+'">\
                    <div class="row">\
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">\
                            <div class="form-group">\
                                <input name="category[]" value="Others" type="hidden" />\
                                <label>Specification</label>\
                                <input class="form-control spec" name="specification[' + counter+']" id="specification_' + counter+'" placeholder="specification" value="" onkeypress="return addressValidation(event);" />\
                            </div>\
                        </div>\
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">\
                            <div class="form-group">\
                                <label>Marks in Percentage</label>\
                                <input class="form-control otherspercentage" maxlength="5" name="marks[' + counter+']" id="marks" placeholder="Marks in Percentage" value="" onkeypress="return decimalNum(event);" />\
                                <span class="req redbold" id="others_marks_msg"></span>\
                                </div>\
                        </div>\
                    </div>\
                    <button type="button"  class="btn add_wrap_pos btn-info remove_section remove_this" id="row[' + counter+']" onclick="delete_others('+counter+')"  data-toggle="tooltip" data-placement="top" title="Delete">\
                            <i class="fa fa-remove"></i>\
                    </button>\
                </div>';
	    $('#more_others').append(html);
        counter++;
        validation();
    }
    /*function delete_others(counter){
        if(counter==5){
            return false;
        }
        $("#new_textbox" + counter).remove();
    }*/

    function delete_others(counter,id ="") {
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
                            $.post('<?php echo base_url();?>backoffice/Staff/delete_others/', {
                                counter:counter,
                                id: id,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }, function(data) {

                                if (data == 1) {
                                 $.toaster({ priority : 'Success', title : 'Success', message : 'Successfully Deleted.' });
                                   // $.alert('Successfully <strong>Deleted..!</strong>');
                                    $("#new_textbox" + counter).remove();
                                    $("#row_"+id).remove();
                                }
                                else{
                                    $.toaster({ priority : 'warning', title : 'Error', message : 'Something went wrong,Please try again later..!' }); 
                                }
                            });
                        }else{
                             //$.toaster({ priority : 'warning', title : 'Error', message : 'Something went wrong,Please try again later..!' });
                            $("#new_textbox" + counter).remove();
                           
                        }
                            
                        }
                    },
                    cancel: function() {
                    },
                }
            });
        }



function get_editdata(id){
    // alert(id);
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Staff/get_staff_personal_by_id/'+id,
        type: 'POST',
        data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#edit_personal_id").val(obj.personal_id);
            $("#name").val(obj.name);
            $("#edit_file").val(obj.staff_image);
            $("#emp_id").val(obj.emp_id);
            $("#dob").val(obj.dob);
            $("#gender").val(obj.gender);
            $("#height").val(obj.height);
            $("#weight").val(obj.weight);
            $("#blood_group").val(obj.blood_group);
            $("#mobile").val(obj.mobile);
            $("#landline").val(obj.landline);
            $("#email").val(obj.email);
            $("#marital_status").val(obj.marital_status);
            $("#spouse_name").val(obj.spouse_name);
            $("#spouse_job").val(obj.spouse_job);
            $("#spouse_country").val(obj.spouse_country);
            $("#spouse_state").val(obj.spouse_state);
            $("#spouse_city").val(obj.spouse_city);
            $("#father_name").val(obj.father_name);
            $("#father_job").val(obj.father_job);
            $("#father_country").val(obj.father_country);
            $("#father_state").val(obj.father_state);
            $("#father_city").val(obj.father_city);
            $("#body_reg").val(obj.body_reg);
            $("#reg_no").val(obj.reg_no);
            $("#issue_date").val(obj.issue_date);
            $("#exp_date").val(obj.exp_date);
            $("#pan_no").val(obj.pan_no);
            $("#ac_no").val(obj.ac_no);
            $("#ifsc_code").val(obj.ifsc_code);
            $("#aadhar_no").val(obj.aadhar_no);
            $("#permanent_address").val(obj.permanent_address);
            $("#communication_address").val(obj.communication_address);
           
            //  $('#edit_call_center').modal({
            //     show: true
            //     });
            $(".loader").hide();
        }
    });
}

function delete_staff_personals(id) {
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

                    $.post('<?php echo base_url();?>backoffice/Staff/delete_staff_personals/', {
                        id: id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    }, function(data) {

                        if (data == 1) {
                                $.toaster({ priority : 'Success', title : 'Success', message : 'Successfully Deleted.' });
                                $.ajax({
                                url: '<?php echo base_url();?>backoffice/Staff/load_staffList',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {

                                        $('#staff_table').DataTable().destroy();
                                        $("#staff_table").html(response);

                                        $("#staff_table").DataTable({
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
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }
                                            ]
                                        });
                                }
                            });
                        }else{
                            $.toaster({priority:'danger',title:'INVALID',message:'Somthing went wrong!'}); 
                        }
                    });

                    //$.alert('Successfully <strong>Deleted..!</strong>');
                }
            },
            cancel: function() {
                //$.alert(' <strong>cancelled</strong>');
            },
        }
    });
}
function get_modules(subject_id, id) {
    $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Staff/get_modules_by_subject/' + subject_id ,
            success: function(response)
            {
                jQuery('#'+id).html(response);
                /*var valArr = [101,102];
                i = 0, size = valArr.length;
                for(i; i < size; i++){
                  $(".multiselect-ui").multiselect("widget").find(":checkbox[value='"+valArr[i]+"']").attr("checked","checked");
                  $(".multiselect-ui option[value='" + valArr[i] + "']").attr("selected", 1);
                  $(".multiselect-ui").multiselect("refresh");
                }*/

                 $('.multiselect-ui').multiselect({
                        includeSelectAllOption: true,
                        numberDisplayed: 1
                     });
                $('.multiselect-ui').multiselect('refresh');
                $(".loader").hide();
            }
        });
    }
//select the other modules
function get_modules_week(subject_id,count) {
  var id='othersubjects_'+count;
    if(subject_id !="" && id!="")
    {
         $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Staff/get_modules_by_subjectweek/' + subject_id ,
            success: function(response)
            {
                jQuery('#'+id).html(response);
				$('.multiselect-ui').multiselect({
                        includeSelectAllOption: true,
                        numberDisplayed: 1
                     });
                $('.multiselect-ui').multiselect('refresh');
                $(".loader").hide();
            }
        });
    }
        
    }


function delete_docs(id){

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
                            url: '<?php echo base_url();?>backoffice/Staff/delete_staff_document',
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


    function delete_fromtable(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Staff/delete_fromwhere/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == "1") {
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                    if (obj.status == 1) {
                                    $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                                    $("#row_"+id).remove();
                                    } else {
                                           $.toaster({priority:'danger',title:'INVALID',message:obj.message}); 
                                        }
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }


     function delete_faculty(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Staff/delete_faculty/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == "1") {
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                    $("#row_"+id).remove();
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Staff/faculty_availability_loadajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

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
        } 
        // else {
        //     alert("Please upload a valid image file.");
        // }
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


    //edit employee
        var edit_validation=0;
        $("form#edit_personal_details_form").validate({
        rules: {
            name: {required: true},
            role: {required: true},
            dob: {required: true},
            mobile: {required: true,
                    number:true,
                            minlength: 10,
                            maxlength: 12,
                            // remote: {
                            //     url: '<?php echo base_url();?>backoffice/Staff/primary_mobileCheck',
                            //     type: 'POST',
                            //     data: {
                            //         primary_mobile: function() {
                            //             return $( "#mobile" ).val();
                            //             },
                            // <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            //         }
                            // }
            },
            landline: {
                number:true,
                minlength: 6,
                maxlength: 11
            },
            pan_no : {pan: true},
            email: {
                required: true,
                email:true,
                emailValidate:true
            },
            spouse_country: {required: true},
            spouse_state: {required: true},
            spouse_city: {required: true},
//            body_reg: {required: true},
//            pan_no: {required: true},
//            ac_no: {required: true},
            blood_group: {required: true},
            aadhar_no: {required: true,
                number:true,
                minlength: 12,
                maxlength: 12},
            permanent_address: {required: true}

        },
        messages: {
            name: {required:"Please Enter Name"},
            role: {required:"Please choose a role"},
            dob: {required:"Please choose a date"},
            mobile: {required: "Please Enter Primary Contact Number",number:"Please Enter Numbers Only", minlength: "Please enter a 10 digit mobile number",maxlength: "Please enter a 12 digit mobile number"/*, remote:"This Number Already Exist"*/},
            landline:{number:"Please Enter Numbers Only",minlength: "Please enter a 6 digit number",maxlength: "Please enter a 12 digit number"},            
            email: {
                required:"Please enter the email",
                email:"Please enter valid email",
                emailValidate:"Please enter valid email"

            },
            spouse_country: {required:"Please select country"},
            spouse_state: {required:"Please select state"},
            spouse_city: {required:"Please select city"},
            blood_group: {required:"Please select a Blood Group"},
//            body_reg: {required:"Please enter body registration, if applicable"},
//            pan_no: {required:"Please enter pan number"},
//            ac_no: {required:"Please enter account number"},
//            ifsc_code: {required:"Please enter ifsc code"},
            aadhar_no: {required:"Please enter aadhar number",number:"Please Enter Numbers Only", minlength: "Please enter 12 digit number",maxlength: "Please enter 12 digit number"},
            permanent_address: {required:"Please enter permanent address"}
        },
        submitHandler: function(form) {
            edit_validation=1;

        }
    });

      $("form#edit_personal_details_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();

        if (edit_validation == 1) {
           //  $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/staff_personal_edit',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    //$(".loader").hide();
                    var obj=JSON.parse(response);

                    if (obj.st== 1) {

                       $.toaster({ priority : 'success', title : 'Success', message : 'Successfully Updated Staff Details' });
                        $(".educational_qualification").trigger("click");
                       /* $("#edit_personal_id").val(obj.id);
                        $(".educational_qualification").trigger("click");
                        window.location.href = "<?php echo base_url('backoffice/manage-staff/');?>"+obj.id;*/

                    }
                    else if(obj.st == 2)
                    {
                        $.toaster({priority:'warning',title:'Error',message:'Mobile number/Email already exists'});

                    }
                    else if(obj.st == 3)//file upload error
                    {
                       $.toaster({priority:'warning',title:'Invalid',message:obj.msg});
                    }
                    else {
                        $.toaster({priority:'danger',title:'Error',message:"Something went wrong,please try again later...!"});
                    }

                }
            });
        }
     });

$(function () {
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
            //  $('#last_date').data("DateTimePicker").maxDate(e.date);
            
        });

        $('#from_date').datetimepicker();
        $('#to_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#from_date").on("dp.change", function (e) {
            $('#to_date').data("DateTimePicker").minDate(e.date);
        });
        $("#to_date").on("dp.change", function (e) {
            $('#from_date').data("DateTimePicker").maxDate(e.date);
            //  $('#last_date').data("DateTimePicker").maxDate(e.date);
            
        });
         
         //last date of admission sholud be lessthan end date
         $('#last_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         $("#last_date").on("dp.change", function (e) {
           //  alert("jhb");
           // $('#end_date').data("DateTimePicker").maxDate(e.date);
        }); 
         //time validate
         $('#start_time').datetimepicker();
        $('#end_time').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#start_time").on("dp.change", function (e) {
            $('#end_time').data("DateTimePicker").minDate(e.date);
        });
        $("#end_time").on("dp.change", function (e) {
           // $('#start_time').data("DateTimePicker").maxDate(e.date);
        });
    });

    $(document).ready(function() {
        $('#staff_table').dataTable({
            pageLength : 10,
            aaSorting: [[0, 'asc']],
            bFilter: false,
            bInfo: false,
            bSortable: true,
            bRetrieve: true,
            aoColumnDefs: [
                { "aTargets": [ 0 ], "bSortable": true },
                { "aTargets": [ 1 ], "bSortable": true },
                { "aTargets": [ 2 ], "bSortable": true },
                { "aTargets": [ 3 ], "bSortable": true },
                { "aTargets": [ 4 ], "bSortable": true },
                { "aTargets": [ 5 ], "bSortable": true },
                { "aTargets": [ 6 ], "bSortable": true },
                { "aTargets": [ 7 ], "bSortable": false }
            ]
        }); 
        // $('#staff_table').DataTable( {
    //     "pageLength" : 10,
    //     "processing": true, //Feature control the processing indicator.
    //     "serverSide": true, //Feature control DataTables' server-side processing mode.
    //     "language": {
    //     "infoEmpty": "No records available.",
    // },
    //    // "order": [], //Initial no order.
    //      //"bSort": false,
    //     "searchable" :true,
    //      "order": [
    //       [1, "asc" ]
    //     ],

    //     // Load data for the table's content from an Ajax source
    //         "ajax": {
    //         "url": "<?php echo base_url();?>backoffice/Staff/load_staffList_byAjax",
    //         "type": "POST",
    //         data: {
    //             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //               },
    //        },
    //      //Set column definition initialisation properties.
    //     "columnDefs": [
    //     {
    //         "targets": [ 0 ], //first column / numbering column
    //         "orderable": false, //set not orderable
    //     },
    //     ],
    // } );
} );


   /*************************************Edit faculity availability*********************************/

     $("#edit_group_name").change(function(){
        var group = $('#edit_group_name').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#edit_branch_name").html(response);

                    }
                });
                $(".loader").hide();
        }
    });
    $("#edit_branch_name").change(function(){
        var branch = $('#edit_branch_name').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#edit_center_name").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });

    function get_data(id){
         if (id != "") {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/get_faculity_availability_data',
                type: 'POST',
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $("#edit_id").val(obj['data'].avai_id);
                    $("#type").val(obj['data'].staff_id);
                    $("#group_name").val(obj.group_id);
                    $("#branch_name").html(obj.branches);
                    $("#branch_name").val(obj['data'].parent_institute);
                    $("#center_name").html(obj.centres);
                    $("#center_name").val(obj['data'].center_id);
                    $("#center_name").val(obj['data'].center_id);
                    remove_day_timings();
                    var timing = obj.class_timing;
                    if(obj['data'].day_sun == "1"){ $("#sunday").prop('checked', true);$("#sunday_div").html(timing.sunday);}
                    if(obj['data'].day_mon == "1"){ $("#monday").prop('checked', true);$("#monday_div").html(timing.monday);}
                    if(obj['data'].day_tue == "1"){ $("#tuesday").prop('checked', true);$("#tuesday_div").html(timing.tuesday);}
                    if(obj['data'].day_wed == "1"){ $("#wednesday").prop('checked', true);$("#wednesday_div").html(timing.wednesday);}
                    if(obj['data'].day_thu == "1"){ $("#thursday").prop('checked', true);$("#thursday_div").html(timing.thursday);}
                    if(obj['data'].day_fri == "1"){ $("#friday").prop('checked', true);$("#friday_div").html(timing.friday);}
                    if(obj['data'].day_sat == "1"){ $("#saturday").prop('checked', true);$("#saturday_div").html(timing.saturday);}
                    if(obj['data'].type == "1"){
                        // $("#weekly"). prop("checked", true);
                        // $("#weeklydiv").css("display", "block");
                        $(".daterange").hide();
                        $('input[type=radio][value=1]').prop('checked', true);
                        $('input[type=radio][value=2]').prop('checked', false);
                    }
                    if(obj['data'].type == "2"){
                        // $("#weeklydiv").css("display", "none");
                        $(".daterange").show();
                        // $("#date"). prop("checked", true);
                        $('input[type=radio][value=1]').prop('checked', false);
                        $('input[type=radio][value=2]').prop('checked', true);
                        $("#start_date").val(obj['data'].date_from);
                        $("#end_date").val(obj['data'].date_to);
                    }
                    $("#chartBlock").addClass("show");
                    $(".close_btn").fadeIn("200");
                    $(".loader").hide();
                }
            });
        }
    }

    function view_availability(id){
         if (id != "") {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/get_faculity_availability_dataView',
                type: 'POST',
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $('#sundaydiview, #mondaydiview, #tuesdaydiview ,#wednesdaydiview, #thursdaydiview, #fridaydiview, #saturdaydiview').empty();
                    $("#edit_id").val(obj['data'].avai_id);
                    $("#type").val(obj['data'].staff_id);
                    $("#group_name").val(obj.group_id);
                    $("#branch_name").html(obj.branches);
                    $("#branch_name").val(obj['data'].parent_institute);
                    $("#center_name").html(obj.centres);
                    $("#center_name").val(obj['data'].center_id);
                    $("#center_name").val(obj['data'].center_id);
                    // var type = $("#type option:selected").attr('name');
                    var type = $("#type").find('option:selected').text();
                    var group_name = $("#group_name").find('option:selected').text();
                    var center_name = $("#center_name").find('option:selected').text();
                    var branch_name = $("#branch_name").find('option:selected').text();
                    $("#viewfaculty").html(type);
                    $("#viewgroup").html(group_name);
                    $("#viewbranch").html(branch_name);
                    $("#viewcentre").html(center_name);
                    // console.log(branch_name);
                    remove_day_timings();
                    var timing = obj.class_timing;
                    if(obj['data'].day_sun == "1"){
                        $('#sundaydiview').show();
                        $("#sundaydiview").append('<div class="title-header">Sunday</div>');
                        $("#sundaydiview").append(timing.sunday);
                    }
                    if(obj['data'].day_mon == "1"){
                        $('#mondaydiview').show();
                        $("#mondaydiview").append('<div class="title-header">Monday</div>');
                        $("#mondaydiview").append(timing.monday);
                    }
                    if(obj['data'].day_tue == "1"){
                        $('#tuesdaydiview').show();
                        $("#tuesdaydiview").append('<div class="title-header">Tuesday</div>');
                        $("#tuesdaydiview").append(timing.tuesday);
                    }
                    if(obj['data'].day_wed == "1"){
                        $('#wednesdaydiview').show();
                        $("#wednesdaydiview").append('<div class="title-header">Wednesday</div>');
                        $("#wednesdaydiview").append(timing.wednesday);
                    }
                    if(obj['data'].day_thu == "1"){
                        $('#thursdaydiview').show();
                        $("#thursdaydiview").append('<div class="title-header">Thursday</div>');
                        $("#thursdaydiview").append(timing.thursday);
                    }
                    if(obj['data'].day_fri == "1"){
                        $('#fridaydiview').show();
                        $("#fridaydiview").append('<div class="title-header">Friday</div>');
                        $("#fridaydiview").append(timing.friday);
                    }
                    if(obj['data'].day_sat == "1"){
                        $('#saturdaydiview').show();
                        $("#saturdaydiview").append('<div class="title-header">Faturday</div>');
                        $("#saturdaydiview").append(timing.saturday);
                    }
                    // alert(timing.sunday);
                    if(obj['data'].day_sun == "1"){ $("#sunday").prop('checked', true);$("#sunday_div").html(timing.sunday);}
                    if(obj['data'].day_mon == "1"){ $("#monday").prop('checked', true);$("#monday_div").html(timing.monday);}
                    if(obj['data'].day_tue == "1"){ $("#tuesday").prop('checked', true);$("#tuesday_div").html(timing.tuesday);}
                    if(obj['data'].day_wed == "1"){ $("#wednesday").prop('checked', true);$("#wednesday_div").html(timing.wednesday);}
                    if(obj['data'].day_thu == "1"){ $("#thursday").prop('checked', true);$("#thursday_div").html(timing.thursday);}
                    if(obj['data'].day_fri == "1"){ $("#friday").prop('checked', true);$("#friday_div").html(timing.friday);}
                    if(obj['data'].day_sat == "1"){ $("#saturday").prop('checked', true);$("#saturday_div").html(timing.saturday);}
                    if(obj['data'].type == "1"){
                        $('#viewType').html('Weekly');
                    }
                    if(obj['data'].type == "2"){
                        $('#viewdate').show();
                        $('#viewType').html('Day');
                        $("#viewstartDate").html(obj['data'].date_from);
                        $("#viewendDate").html(obj['data'].date_to);
                    }else{
                        $('#viewdate').hide();
                        $("#viewstartDate").empty();
                        $("#viewendDate").empty();
                    }
                    $("#view_chartBlock").modal("show");
                    $(".close_btn").fadeIn("200");
                    $(".loader").hide();
                }
            });
        }
    }
    // function get_data(id){
    //      if (id != "") {
    //        // $(".loader").show();
    //         $.ajax({
    //             url: '<?php echo base_url();?>backoffice/Staff/get_faculity_availability_data',
    //             type: 'POST',
    //             data: {
    //                 id: id,
    //                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //             },
    //             success: function(response) {
    //                 var obj=JSON.parse(response);
    //                 $("#edit_id").val(obj['data'].avai_id);
    //                 $("#edit_type").val(obj['data'].staff_id);
    //                 $("#edit_group_name").val(obj.group_id);
    //                 $("#edit_branch_name").html(obj.branches);
    //                 $("#edit_branch_name").val(obj['data'].parent_institute);
    //                 $("#edit_center_name").html(obj.centres);
    //                 $("#edit_center_name").val(obj['data'].center_id);
    //                 $("#edit_center_name").val(obj['data'].center_id);
    //                 if(obj['data'].type == "1"){
    //                     $("#edit_weekly"). prop("checked", true);
    //                     $("#edit_weeklydiv").css("display", "block");
    //                     $(".editdaterange").css("display", "none");
    //                     if(obj['data'].day_sun == "1"){ $("#sun").prop('checked', true);}
    //                     if(obj['data'].day_mon == "1"){ $("#mon").prop('checked', true);}
    //                     if(obj['data'].day_tue == "1"){ $("#tue").prop('checked', true);}
    //                     if(obj['data'].day_wed == "1"){ $("#wed").prop('checked', true);}
    //                     if(obj['data'].day_thu == "1"){ $("#thu").prop('checked', true);}
    //                     if(obj['data'].day_fri == "1"){ $("#fri").prop('checked', true);}
    //                     if(obj['data'].day_sat == "1"){ $("#sat").prop('checked', true);}
    //                 }else{
    //                     $("#edit_weeklydiv").css("display", "none");
    //                     $(".editdaterange").css("display", "block");
    //                     $("#edit_date"). prop("checked", true);
    //                     $("#edit_start_date").val(obj['data'].date_from);
    //                     $("#edit_end_date").val(obj['data'].date_to);
    //                 }
    //                 $('#editModal').modal({ show: true});
    //                 $(".loader").hide();
    //             }
    //         });
    //     }
    // }

    $('.edit_typeswitch').on('click',function(){
            if($(this).val()==1) {
                $('#edit_weeklydiv').show();
                $('.editdaterange').hide();
                /*$("#edit_start_date").val("");
                $("#edit_end_date").val("");*/

            } else {
                $('.editdaterange').show();
                $('#edit_weeklydiv').hide();
               // $(".edit_check").prop("checked", false);
            }
        });
     $("form#edit_form").validate({
        rules: {
            faculty: {required: true},
            group_name: {required: true},
            branch_name: {required: true},
            center_name: {required: true}
        },
        messages: {
            faculty: {required:"Please select faculty"},
            group_name: {required:"Please select institute"},
            branch_name: {required:"Please select branch"},
            center_name: {required:"Please select center"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Staff/edit_faculity_availability',
                type: 'POST',
                data: $("#edit_form").serialize(),
                success: function(response) {

                     var obj = JSON.parse(response);
			         if (obj.status == true) {
                          $('#editModal').modal('toggle');
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Staff/faculty_availability_loadajax',
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
                                                }
                                            ]
                                        });
                                }
                            });
                         $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                     }
                     else if(obj.status == 2)
                            {
                               $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                            }
                    else {
                        $.toaster({priority:'danger',title:'Error',message:obj.message});
                     }

                    $(".loader").hide();
                }
            });
        }
    });

    function delete_availability(id)
    {
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
                        $.post('<?php echo base_url();?>backoffice/Staff/delete_staff_availability', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if (obj.st == 1) {
                                $.toaster({ priority : 'success', title : 'Success', message : obj.msg });

                                $.ajax({
                                url: '<?php echo base_url();?>backoffice/Staff/faculty_availability_loadajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {

                                        $('#faculty_data').DataTable().destroy();
                                        $("#faculty_data").html(response);

                                        $("#faculty_data").DataTable({
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
                                                }
                                            ]
                                        });
                                }
                            });

                            } else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.msg});
                            }
                        });


                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }

     $(function () {
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });

        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);


        });

         $('#edit_start_date').datetimepicker();
        $('#edit_end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });

        $("#edit_start_date").on("dp.change", function (e) {
            $('#edit_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#edit_end_date").on("dp.change", function (e) {
            $('#edit_start_date').data("DateTimePicker").maxDate(e.date);


        });
     });
    function append_document(id){
        // alert(id);
        if(id !=""){
            $(".loader").show();
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Staff/append_document',
                    type:'POST',
                    data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                    success: function(response) {
                        // var obj = JSON.parse(response);
                        // $("#all_qualification_form").html(response);
                        $("#all_qualification_form").html(response);
                        $(".save").hide();
                        $(".loader").hide();
                        // $.toaster({ priority : 'warning', title : 'Notice', message : 'Status Changed' });
                    }
            });
        }
    }

    var counter=1;
    function addNew()
    {
        var markup = '';

        markup += '<div class="col-12" id="show_other_subject_'+counter+'"><div class="add_wrap"><div class="form-group"><label>Other Subject</label><select class="form-control" name="strong_subject[]" id="strong_subject" onchange="return get_modules_week(this.value,'+counter+')"><option value="">Select Subject</option><?php if(!empty($subjectArr)) {foreach($subjectArr as $subject){?><option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['subject_name'];?></option><?php }} ?></select></div><button  type="button" class="btn add_wrap_pos btn-info remove_section remove_this" id="removeButton1" onclick="remove('+counter+');" title="Click here to remove this row" style="top: unset;bottom: 10px;"><i class="fa fa-remove "></i></button></div><div class="row"><div class="col-12"><span  style="width:100%;" id="othersubjects_'+counter+'"></span></div></div></div>';

        $('#row').append(markup);

        counter++;
    }
    
    function remove(count,id=''){
        if(id==''){
            $('#show_other_subject_'+count).remove();
            return false;
        }else{
            $("#"+id+'_row_'+count).remove();
            return false;   
        }
    }
    
    // function validation() {
    //     var inc = $("#counter").val();
	//     inc++;
    //     $("#counter").val(inc);
    //     $('.spec').each(function() {
    //     $(this).rules('add', {
    //         remote: {
    //                 url: '<?php echo base_url();?>backoffice/Staff/specificationCheck',
    //                 type: 'POST',
    //                 data: {
    //                     'specification[inc]': function() {
    //                         return $('#specification_'+inc).val();
    //                         },
    //             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //                     }
    //             },

    //         messages: {
    //             remote: "Specification Already Exist"

    //         }
    //     });
    // });
    // }
    // $.ajax({
    //     url: '<?php echo base_url();?>backoffice/Staff/get_salary_scheme_drop_down',
    //     type: 'GET',
    //     success: function (data) {
    //         var string = '<option value="">Select Salary Scheme</option>';
    //         $.each(data.data, function (i, v) {
    //             string += '<option value="' + v.id + '">'+ v.scheme + '</option>';
    //         });
    //         $("#salary_scheme_id").append(string);
    //     }
    // });
    // $.ajax({
    //     url: '<?php echo base_url();?>backoffice/Staff/get_leave_scheme_drop_down',
    //     type: 'GET',
    //     success: function (data) {
    //         var string = '<option value="">Select Leave Scheme</option>';
    //         $.each(data.data, function (i, v) {
    //             string += '<option value="' + v.id + '">'+ v.scheme + '</option>';
    //         });
    //         $("#leave_scheme_id").append(string);
    //     }
    // });

    $(function(){
        // var inc = $("#counter").val();
	    // inc++;
        // $("#counter").val(inc);
        $('input[name^="text"]').change(function() {
            var $current = $(this);
            $('input[name^="text"]').each(function() {
                if ($(this).val() == $current.val() && $(this).attr('id') != $current.attr('id'))
                {
                    alert('duplicate found!');
                }
            });
        });
    });

    // $(function(){
    //     $('#add_educational_qualification_form').submit(function(){
    //         $("input[type='submit']", this)
    //         .val("Please Wait...")
    //         .attr('disabled', 'disabled');
    //         return true;
    //     });
    // });
</script>
