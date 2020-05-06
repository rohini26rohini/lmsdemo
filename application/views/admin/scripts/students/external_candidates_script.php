<script type="text/javascript">
    $(document).ready(function(){
        $("#external_candidates").DataTable();
        load_external_candidates_list();
        $("form#add_edit_form").validate({
            rules: {
                batch_id: {required: true},
                name: {required: true},
                // gender: {required: true},
                // address: {required: true},
                // street: {required: true},
                state: {required: true},
                district: {required: true},
                contact_number: {required: true},
                // whatsapp_number: {required: true},
                // mobile_number: {required: true},
                //email: {required: true},
                // date_of_birth: {required: true}
            },
            messages: {
                batch_id: {required:"Please specify a batch"},
                name: {required:"Candidate name is required"},
                // gender: {required:"Gender is required"},
                // address: {required:"Address is required"},
                // street: {required:"Street is required"},
                state: {required:"State is required"},
                district: {required:"Location is required"},
                contact_number: {required:"Contact number is required"},
                // whatsapp_number: {required:"Whatsapp number is required"},
                // mobile_number: {required:"Mobile number is required"},
                //email: {required:"Email is required"},
                // date_of_birth: {required:"Date of Birth is required"}
            },
            submitHandler: function(form) { alert(1);
                $(".loader").show();
                $.ajax({
                    url: base_url+'backoffice/Students/add_edit_ext_candidate',
                    type: 'POST',
                    data: $("#add_edit_form").serialize(),
                    success: function(data) {
                        var response=JSON.parse(data);
                        if(response.st == 1){
                            $.toaster({priority:'success',title:'Success',message:response.message}); 
                            load_external_candidates_list();
                            $("#add_edit").modal('hide');
                        }
                        $(".loader").hide();
                    },
                    error: function (jqXHR, exception) { alert(2);
                        $(".loader").hide();
                        show_ajax_error_message(jqXHR, exception);
                    }
                });
            }
        });
        $("#state").change(function(){
            load_city($("#state").val());
        });
    });
    function load_external_candidates_list(){
		$(".loader").show();
         $.ajax({
            url: base_url+'backoffice/Students/load_external_candidates_list',
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                if(response.st == 1){
                    var html = '';
                    var i=0;
                    $.each(response.data,function(k,val){
                        html += '<tr>'+
                                    '<td>'+(++i)+'</td>'+
                                    '<td>'+val.name+'</td>'+
                                    '<td>'+val.email+'</td>'+
                                    '<td>'+val.contact_number+'</td>'+
                                    // '<td>'+val.whatsapp_number+'</td>'+
                                    // '<td>'+val.mobile_number+'</td>'+
                                    '<td>'+val.registration_number+'</td>'+
                                    '<td>'+val.batch_name+'</td>'+
                                    '<td>'+
                                        '<button type="button" class="btn btn-default option_btn" onclick="get_ext_candidate_details('+val.student_id+')" title="View details"><i class="fa fa-eye"></i></button>'+
                                        '<button type="button" class="btn btn-default option_btn" onclick="edit_ext_candidate_details('+val.student_id+')" title="Edit"><i class="fa fa-pencil"></i></button>'+
                                        '<button type="button" class="btn btn-default option_btn" onclick="delete_ext_candidate_details('+val.student_id+')" title="Delete"><i class="fa fa-trash-o"></i></button>'+
                                    '</td>'+
                                '</tr>';
                    });
                    $('#external_candidates').DataTable().destroy();
                    $("#external_candidates_body").html(html);
                    $("#external_candidates").DataTable();
                }else{
                    var html = '<td></td><td>No candidates available</td><td></td><td></td><td></td>';
                    $("#external_candidates_body").html(html);
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }
    function get_ext_candidate_details(candidate_id){
		$(".loader").show();
         $.ajax({
            url: base_url+'backoffice/Students/get_ext_candidate_details/'+candidate_id,
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                if(response.st == 1){
                    $("#view_ext_can_batch").html(response.data.batch_name);
                    $("#view_ext_can_name").html(response.data.name);
                    $("#view_ext_can_connum").html(response.data.contact_number);
                    $("#view_ext_can_email").html(response.data.email);
                    $("#view_ext_can_state").html(response.data.statename);
                    $("#view_ext_can_location").html(response.data.locationname);
                    $("#view_ext_can_mobnum").html(response.data.mobile_number);
                    $("#view_ext_can_watnum").html(response.data.whatsapp_number);
                    $("#view_ext_can_dob").html(response.data.date_of_birth);
                    $("#view_ext_can_gen").html(response.data.gender);
                    $("#view_ext_can_addr").html(response.data.address);
                    $("#view_ext_can_strt").html(response.data.street);

                    $("#view_candidates").modal('show');
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });

    }
    function edit_ext_candidate_details(candidate_id){
		$(".loader").show();
        $("#add_edit_form").validate().resetForm();
        $('#add_edit_form .form-control').removeClass('error');
        $("#add_edit_form").trigger('reset');
        $("#student_id").val('');
        $("#state").html('<option value="">Select a State</option>');
        $("#district").html('<option value="">Select a State</option>');
         $.ajax({
            url: base_url+'backoffice/Students/edit_ext_candidate_details/'+candidate_id,
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                if(response.st == 1){
                    $("#batch_id").val(response.data.batch_id).prop('selected',true);
                    $("#name").val(response.data.name);
                    $("#gender").val(response.data.gender).prop('selected',true);
                    $("#address").val(response.data.address);
                    $("#street").val(response.data.street);
                    load_state(response.data.state);
                    load_city(response.data.state,response.data.district);
                    $("#contact_number").val(response.data.contact_number);
                    $("#whatsapp_number").val(response.data.whatsapp_number);
                    $("#mobile_number").val(response.data.mobile_number);
                    $("#email").val(response.data.email);
                    $("#date_of_birth").val(response.data.date_of_birth);
                    $("#student_id").val(response.data.student_id);
                    $("#add_edit_title").html('Edit external candidate details');
                    $("#add_edit").modal('show');
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }
    function add_ext_candidate(){
        $("#add_edit_form").trigger('reset');
        $("#student_id").val('');
        $("#state").html('<option value="">Select a State</option>');
        $("#district").html('<option value="">Select a State</option>');
        load_state(<?php echo DEFAULT_STATE;?>);
        load_city(<?php echo DEFAULT_STATE;?>,<?php echo DEFAULT_CITY;?>);
        $("#add_edit_title").html('Add external candidate');
        $("#add_edit").modal('show');
    }
    function delete_ext_candidate_details(candidate_id){
        $.confirm({
            title: 'Delete this external candidate?',
            content: '<span style="font-size:14px;">Are you sure you want to continue.</span>',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            fontSize:10,
            buttons: {
                'confirm': {
                    text: 'Yes delete',
                    btnClass: 'btn-danger',
                    action: function() {
                        $(".loader").show();
                        $.ajax({
                            url: base_url+'backoffice/Students/delete_ext_candidate/'+candidate_id,
                            type: 'GET',
                            success: function(data){
                                var response=JSON.parse(data);
                                if(response.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:response.data}); 
                                    load_external_candidates_list();
                                }
                                $(".loader").hide();
                            },
                            error: function (jqXHR, exception) {
                                $(".loader").hide();
                                show_ajax_error_message(jqXHR, exception);
                            }
                        });
                    }
                },
                'cancel': {
                    text: 'Cancel',
                    btnClass: 'btn-info',
                    function() {},
                }
            }
        });
    }
    function load_state(state=null){
		$(".loader").show();
        $.ajax({
            url: base_url+'backoffice/commoncontroller/get_states',
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                var html = '<option value="">Select a State</option>';
                $.each(response,function(k,val){
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                });
                $("#state").html(html);
                if(state != null){
                    $("#state").val(state).prop('selected',true);
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }
    function load_city(state,city=null){
		$(".loader").show();
        $.ajax({
            url: base_url+'backoffice/commoncontroller/get_cities/'+state,
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                var html = '<option value="">Select a Location</option>';
                $.each(response,function(k,val){
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                });
                $("#district").html(html);
                if(city != null){
                    $("#district").val(city).prop('selected',true);
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }
</script>