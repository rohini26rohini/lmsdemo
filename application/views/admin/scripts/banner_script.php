<script>
    $(document).ready(function(){
        $("#type").change(function(){
            var type= $(this).val();
            if(type == 'School_banner'){
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/get_school_for_banner',
                    type: 'POST',
                    data: {type:type,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                    success: function(response) {
                        $("#school_select").html(response);
                        // alert(response);
                    }
                });
            }else{
                $("#school_select").empty();
            }
        });
        var add_validation = 0;
        $("form#banner_form").validate({
            rules: {
                type: {required: true},
                banner: {required: true}
            },
            messages: {
                type: {required: "Please select a type"},
                banner: {required: "Please select a banner"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                var file=$("#banner").get(0).files[0].name;
                if(file){
                    var file_size = $("#banner").get(0).files[0].size/1024;
                    var ext = file.split('.').pop().toLowerCase();
                    if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                        $("#banner_error").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                        add_validation = 0;
                        $(".loader").hide();
                        return;
                    }
                    add_validation = 1;
                }
            }
        });
        $("form#banner_form").submit(function(e) {
            e.preventDefault();
            // alert(add_validation);
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/banner_add',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        add_validation = 0;
                        // alert(response);
                        $('#add_banner').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_banner_ajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });    
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                        }else if(obj.st == 0){
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
        var edit_validation = 0;
        $("form#edit_banner_form").validate({ 
            rules: {
                type: {required: true}
            },
            messages: {
                type: {required: "Please select a type"}
            },
            submitHandler: function(form) { 
                $(".loader").show();
                if($("#edit_banner_image").val() != ''){
                    var file=$("#edit_banner_image").get(0).files[0].name;
                    if(file){
                        var file_size = $("#edit_banner_image").get(0).files[0].size/1024;
                        var ext = file.split('.').pop().toLowerCase();
                        if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                            $("#edit_banner_error1").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                            edit_validation = 0;
                            // alert(edit_validation);
                            $(".loader").hide();
                            return;
                        }
                        edit_validation = 1;
                    }
                }
                edit_validation = 1;
            }
        });
        $("form#edit_banner_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            $("#edit_banner_error").empty();
            // alert(edit_validation);
            if (edit_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/banner_edit',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        edit_validation = 0;
                        // alert(response);
                        $('#edit_banner').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        // alert(obj.st);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_banner_ajaxExtra/'+id,
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    var obj = JSON.parse(response);
                                    $('#type_'+id).html(obj.type);  
                                    $('#image_'+id).html(obj.image);   
                                    $('#school_'+id).html(obj.school); 
                                    $('#action_'+id).html(obj.action); 
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

    function delete_bannerdata(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/banner_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});
                                    $('#row_'+id).empty(); 
                                    $(".loader").hide();
                                }else{
                                    $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
var baseUrl = '<?php echo base_url(); ?>';
    function get_bannerData(id){
        formclear('edit_banner_form');
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_banner_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#edit_type").val(obj.type);
                if(obj.type == 'School_banner'){
                    // alert(response);
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Content/get_school_for_banner_edit/'+obj.school_id,
                        type: 'POST',
                        data: {type:obj.type,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                        success: function(response1) {
                            $("#school_select_edit").html(response1);
                        }
                    });
                }else{
                    $("#school_select_edit").empty();
                }
                $("#banner_image").html('<img  src="<?php echo base_url() ?>/uploads/banner_images/' + obj.banner_image + '"style="width:200px;height:200px;">');
                $('#edit_banner').modal({
                    show: true
                });
                $("#id").val(obj.id);
                $(".loader").hide();
            }
        });
    }
</script>