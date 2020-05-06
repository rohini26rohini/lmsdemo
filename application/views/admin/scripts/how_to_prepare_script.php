<script>
    CKEDITOR.replace('content');
    CKEDITOR.replace('content_edit');
    var add_validation = 0;
    $("#school").change(function(){
        var school_id = $('#school').val();
        if (school_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_categoryby_school',
                type: 'POST',
                data: {
                    school_id: school_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#category").html(response);
                    $(".loader").hide();
                }
            });
        }
    });
    function getCategory(school_id,category_id){
        if (school_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_categoryby_school_edit',
                type: 'POST',
                data: {
                    school_id: school_id,category_id: category_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#category_edit").html(response);
                    $(".loader").hide();
                }
            });
        }
    }
    $("#school_edit").change(function(){
        var school_id = $('#school_edit').val();
        if (school_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_categoryby_school',
                type: 'POST',
                data: {
                    school_id: school_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#category_edit").html(response);
                    $(".loader").hide();
                }
            });
        }
    });
    $(document).ready(function(){
        var add_validation = 0;
        $("form#add_howtoprepare_form").validate({
            rules: {
                category: {required: true},
                school: {required: true}
            },
            messages: {
                category: {required: "Please select a category"}, 
                school: {required: "Please select a school"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                // alert(add_validation);
            }
        });
        $("form#add_howtoprepare_form").submit(function(e) {
            // alert(add_validation);
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            //add the content
            // CKEDITOR.instances["txtFT_Content"].getData();
            data.append('content', CKEDITOR.instances['content'].getData());
            if (add_validation == 1) {
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/howtoprepare_add',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $('#add_howtoprepare').modal('toggle');
                            $('#add_howtoprepare_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : 'Service Added Succesfully ' });
                            // $("#discount_data").append(response);
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_howtoprepare_ajax',
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
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                            $(".loader").hide();
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
        var edit_validation = 0;
        $("form#edit_howtoprepare_form").validate({
            rules: {
                category: {required: true},
                school: {required: true}
            },
            messages: {
                category: {required: "Please select a category"}, 
                school: {required: "Please select a school"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                // alert(add_validation);
            }
        });
        $("form#edit_howtoprepare_form").submit(function(e) {
            // alert(add_validation);
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            //add the content
            // CKEDITOR.instances["txtFT_Content"].getData();
            data.append('content', CKEDITOR.instances['content_edit'].getData());
            if (edit_validation == 1) {
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/howtoprepare_edit',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        edit_validation = 0;
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        if(obj.st == 1){
                            $('#edit_howtoprepare').modal('toggle');
                            $('#edit_howtoprepare_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            // $("#discount_data").append(response);
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_howtopreparestatus_ajax/'+id,
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    var obj = JSON.parse(response);
                                    $('#category'+id).html(obj.category);  
                                    $('#school'+id).html(obj.school);   
                                    $('#status'+id).html(obj.status); 
                                    $('#action'+id).html(obj.action); 

                                    $(".loader").hide();
                                } 
                            });
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                            $(".loader").hide();
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
    function get_howtoprepare_Data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_howtoprepare_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#school_edit").val(obj.school_id);
                getCategory(obj.school_id,obj.category_id);
                $("#category_edit").val(obj.category_id);
                $('#edit_howtoprepare').modal({
                    show: true
                });
                CKEDITOR.instances['content_edit'].setData(obj.content);
                $("#id").val(obj.prepare_id);
                $(".loader").hide();
            }
        });
    }
    function edit_howtoprepare_status(id, status) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>backoffice/Content/edit_howtoprepare_status/', {
                            id: id,status: status,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            $.toaster({priority:'success',title:'Success',message:'Status changed successfuly.!'});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_howtopreparestatus_ajax/'+id,
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    var obj = JSON.parse(response);
                                    $('#category'+id).html(obj.category);  
                                    $('#school'+id).html(obj.school);   
                                    $('#status'+id).html(obj.status); 
                                    $('#action'+id).html(obj.action); 

                                    $(".loader").hide();
                                } 
                            });
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
    function get_howtoprepare_Data_view(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_howtoprepare_id_view/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                // alert(obj);
                $('#singlecategory').html(obj.category);
                $('#single_name').html(obj.school_name);
                $('#single_content').html(obj.content);
                $('#view_howtoprepare').modal({
                    show: true
                });
                // $('#singlecategory').html()
                $(".loader").hide();
            }
        });
    }
    function delete_howtoprepare_Data(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/howtoprepare_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});
                                    $('#prepare'+id).empty();
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
</script>