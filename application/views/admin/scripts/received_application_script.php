<script>
    $(document).ready(function(){
        var add_validation = 0;
        $("form#application_status_change").validate({
            rules: {
                status: {
                    required: true
                }
            },
            messages: {
                status: {
                    required: "Please enter a status"
                }  
            }
            ,
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
            }
        });
        $("form#application_status_change").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/change_application_status',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) { 
                        $('#status_change').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_application_ajaxExtra/'+id,
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    var obj1 = JSON.parse(response); 
                                    $('#status_'+id).html(obj1.status); 
                                    $(".loader").hide();
                                } 
                            });      
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                        }else{
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
    });
var baseUrl = '<?php echo base_url(); ?>';
    function edit_application_status(id,status){
        formclear('application_status_change');
        $('#status').val(status);
        $('#id').val(id);
        $('#status_change').modal({
            show: true
        });
    }
    function view_application_comments(id){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_application_status_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                $("#application_status_table").html(response);
                $('#view_application_comments').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }
    function delete_discount_packages(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Discount/discount_packages_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == "1") {
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                    $("#row_"+id).remove();
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Discount/load_discount_packages_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(response);
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

    function get_discount_packagesdata(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Discount/get_discount_packages_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_package_id").val(obj.package_id);
                $("#edit_package_master_id").val(obj.package_master_id);
                $("#edit_package_type").val(obj.package_type);
                $("#edit_package_amount").val(obj.package_amount);
                $("#edit_package_desc").val(obj.package_desc);
                $('#edit_discount_packages').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }
//------------------------------------------Success Stories-------------------------------------------//
</script>