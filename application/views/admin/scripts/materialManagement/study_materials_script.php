<script>
    function view_study_material(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/questionbank/view_study_material'); ?>",
            type: "post",
            data: {'id':id,'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#body').html(obj.html);
                    $('#title').html(obj.title);
                    $('#view_study_material').modal('toggle');
                }else{
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

    function delete_study_material(id){
        $.confirm({
            title: 'Notice',
            content: 'Are you sure you want to delete this study material',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Delete',
                    btnClass: 'btn-blue',
                    action: function() {
                        $(".loader").show();
                        jQuery.ajax({
                            url: "<?php echo base_url('backoffice/questionbank/delete_study_material'); ?>",
                            type: "post",
                            data: {'id':id,'type':'delete','ci_csrf_token':csrfHash},
                            success: function (data) {
                                var obj = JSON.parse(data);
                                if (obj.st == 1) {
                                    $.toaster({priority:'success',title:'Message',message:obj.message});
                                    $("#study_material_data"+id).remove();
                                }else{
                                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                                }
                                $(".loader").hide();
                            },
                            error: function () {
                                $(".loader").hide();
                                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
                            }
                            //Your code for AJAX Ends
                        });
                    }
                },
                cancel: function() {},
            }
        });
    }

    // function download_study_material(id){
    //     $(".loader").show();
    //     jQuery.ajax({
    //         url: "<?php echo base_url('backoffice/pdfs/download_study_material'); ?>",
    //         type: "post",
    //         data: {'id':id,'ci_csrf_token':csrfHash},
    //         success: function (data) {
    //             // alert("two");
    //             var obj = JSON.parse(data);
    //             if (obj.st == 1) {
    //                 window.open(obj.url,'View study material'); 
    //             }else{
    //                 $.toaster({priority:'warning',title:'Error',message:obj.message});
    //             }
    //             $(".loader").hide();
    //         },
    //         error: function () {
    //             $(".loader").hide();
    //             $.toaster({priority:'danger',title:'Error',message:'Network error please try again later'});
    //         }
    //     });
    // }
</script>
