<script type="text/javascript">
    $(document).ready(function(){
        $("#external_candidates").DataTable();
        load_external_batches_list();
        var validation = 0;
        $("form#add_edit_form").validate({
            rules: {
                batch_name: {
                    required: true,
                    remote: {
                        url: '<?php echo base_url();?>backoffice/Students/checkDuplication_add',
                        type: 'POST',
                        data:{ batch_name: function() { return $("#batch_name").val(); },
                                batch_id: function() { return $("#batch_id").val(); },
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }
                    }
                }
            },
            messages: {
                batch_name: {
                    required:"Please provide an external batch name",
                    remote:"Batch already exist"
                }
            },
            submitHandler: function(form) {
                validation = 1;
                $(".loader").show();
                if(validation == 1){
                    $.ajax({
                        url: base_url+'backoffice/Students/add_edit_ext_batch',
                        type: 'POST',
                        data: $("#add_edit_form").serialize(),
                        success: function(data) {
                            validation = 0;
                            var response=JSON.parse(data);
                            if(response.st == 1){
                                $.toaster({priority:'success',title:'Success',message:response.data}); 
                                load_external_batches_list();
                                $("#add_edit").modal('hide');
                            }else{
                                $.toaster({priority:'danger',title:'Invalid',message:'Somthing went wrong Please try again..!'});
                            }
                            $(".loader").hide();
                        },
                        error: function (jqXHR, exception) {
                            $(".loader").hide();
                            show_ajax_error_message(jqXHR, exception);
                        }
                    });
                }
            }
        });
    });
    function load_external_batches_list(){
		$(".loader").show();
         $.ajax({
            url: base_url+'backoffice/Students/load_external_batches_list',
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                if(response.st == 1){
                    var html = '';
                    var i=0;
                    $.each(response.data,function(k,val){
                        html += '<tr>'+
                                    '<td>'+(++i)+'</td>'+
                                    '<td>'+val.batch_name+'</td>'+
                                    '<td>'+val.batch_code+'</td>'+
                                    '<td>'+val.batch_creationdate+'</td>'+
                                    '<td>'+
                                        // '<button type="button" class="btn btn-default option_btn" onclick="get_ext_batch_details('+val.batch_id+')" title="View details" data-toggle="modal" data-target="#show"><i class="fa fa-eye"></i></button>'+
                                        '<button type="button" class="btn btn-default option_btn" onclick="edit_ext_batch_details('+val.batch_id+')" title="Edit"><i class="fa fa-pencil"></i></button>'+
                                        '<button type="button" class="btn btn-default option_btn" onclick="delete_ext_batch_details('+val.batch_id+')" title="Delete"><i class="fa fa-trash-o"></i></button>'+
                                    '</td>'+
                                '</tr>';
                    });
                    $('#external_candidates').DataTable().destroy();
                    $("#external_candidates_body").html(html);
                    $("#external_candidates").DataTable();
                }else{
                    var html = '<td></td><td></td><td>No batch available</td><td></td><td></td>';
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
    function edit_ext_batch_details(batch_id){
		$(".loader").show();
        $("#add_edit_form").validate().resetForm();
        $('#add_edit_form .form-control').removeClass('error');
        $("#add_edit_form").trigger('reset');
        $("#batch_id").val('');
         $.ajax({
            url: base_url+'backoffice/Students/edit_ext_batch_details/'+batch_id,
            type: 'GET',
            success: function(data){
                var response=JSON.parse(data);
                if(response.st == 1){
                    $("#batch_name").val(response.data.batch_name);
                    $("#batch_id").val(response.data.batch_id);
                    $("#add_edit_title").html('Edit external batch');
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
    function add_ext_batch(){
        $("#batch_name").val('');
        $("#batch_id").val('');
        $("#add_edit_title").html('Add external batch');
        $("#add_edit").modal('show');
    }
    function delete_ext_batch_details(batch_id){
        $.confirm({
            title: 'Delete this external batch?',
            content: '<span style="font-size:14px;">Deleting this external batch will also delete all the candidates registered in this batch.<br> Are you sure you want to continue.</span>',
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
                            url: base_url+'backoffice/Students/delete_ext_batch/'+batch_id,
                            type: 'GET',
                            success: function(data){
                                var response=JSON.parse(data);
                                if(response.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:'Batch deleted successfully..!'}); 
                                    load_external_batches_list();
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
</script>