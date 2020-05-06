<script>
    function view_learning_module(id, roleback = null){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/Employee/get_single_learning_module'); ?>",
            type: "post",
            data: {id:id,'ci_csrf_token':csrfHash},
            success: function (response) {
                var obj = JSON.parse(response);
                $("#learning_module_namem").html(obj.data.title);
                $("#finishmodal_body1").html(obj.data.body);
                $("#finishmodal_title1").html(obj.data.title);
                $("#finishmodal_footer1").html('<button class="btn btn-info close" data-dismiss="modal">Cancel</button>');
                $(".loader").hide();
                $(".loader").hide();
                if(roleback == null){
                    $('#view_learning_module').modal({
                        show: true
                    });
                }
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }
    function view_rejectedRemark(id, user){
        $(".loader").show();
        $("#reason").empty();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/view_rejectedRemark',
            type: 'POST',
            data: {
                    'id':id,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#rejectedUser").html('Rejected by: <b>'+user+'</b>' );
                $("#reason").html('Reason: <b>'+obj.remark+'</b>');
                $("#reasonok").html('<button class="btn btn-info close" data-dismiss="modal">OK</button>');
                $('#view_rejectedRemark').modal({
                    show: true
                });
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }
    function view_question_paper(id) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Employee/save_preview_exam_paper',
                type: 'POST',
                data: {
                        'exam_id':id,
                        'view':1,
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#finishmodal_body").html(obj.data.body);
                    $("#finishmodal_title").html('View question paper');
                    $("#finishmodal_footer").html('<button class="btn btn-info close" data-dismiss="modal">OK</button>');
                    $(".loader").hide();
                    $('#finishmodal').modal('show');
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                }
            });
        }
    function viewPassage(id){
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_passage_content',
            type: 'POST',
            data: {
                    'passage_id':id,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#modal_title").html(obj.title);
                $(".loader").hide();
                $('#modal').modal('show');
            }
        });
    }
    function viewQuestion(id){
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_question_content',
            type: 'POST',
            data: {
                    'question_id':id,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#modal_title").html(obj.title);
                $(".loader").hide();
                $('#modal').modal('show');
            }
        });
    }
    function get_question(id){
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_question',
            type: 'POST',
            data: {
                    'question_id':id,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#modal_title").html(obj.title);
                $(".loader").hide();
                $('#modal').modal('show');
            }
        });
    }
    function edit_question(id){
        $.confirm({
            title: 'Confirm',
            content: 'This will take you to the question edit page',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        window.open('<?php echo base_url('backoffice/update-question-set-forapprovel-group?qid='); ?>'+id, '_blank');
                    }
                },
                cancel: function() {
                },
            }
        });
    }
    function delete_question(id){
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
                        $.post('<?php echo base_url();?>backoffice/Employee/delete_question', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if(obj['st'] == 1)
                                {
                                 $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Employee/load_questions_ajax',
                                    type: "post",
                                    data: {id: id,
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data1').DataTable().destroy();
                                        $("#institute_data1").html(data);
                                        $("#institute_data1").DataTable({
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
                                }
                            else if(obj['st'] == 2)
                                {
                                   $.toaster({priority:'warning',title:'Notice',message:obj.msg} );   
                                }
                            else if(obj['st'] == 0){
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg} );
                            }
                            else{
                                $.toaster({priority:'warning',title:'Notice',message:'Something went wrong,Please try again later..!'} );
                            }
                             });
                       // $.alert('Successfully <strong>Deleted..!</strong>');
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
    function reject_entity_job(entityID,jobId,flowDetailId){
        formclear('reject_entity_job_form');
        $('#id').val(entityID);
        $('#jobId').val(jobId);
        $('#flowDetailId').val(flowDetailId);
        $('#reject_entity_job').modal({
            show: true
        });
    }
    $(document).ready(function(){
        var add_validation = 0;
        $("form#reject_entity_job_form").validate({
            rules: {
                remark: {required: true}
            },
            messages: {
                remark: {required: "Please enter a remark"}  
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
            }
        });
        $("form#reject_entity_job_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Employee/reject_entity_job',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) { 
                        add_validation = 0;
                        $('#reject_entity_job').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                            setTimeout(function () {
                                window.location.href = "<?php echo base_url(); ?>approve-jobs/"+$('#flowDetailId').val(); 
                            }, 2000); 
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
    function approve_entity_job(entityID,jobId,flowDetailId){
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to approve this material?',
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
                            url: '<?php echo base_url();?>backoffice/Employee/approve_entity_job',
                            type: 'POST',
                            data: {
                                    'entityID':entityID,
                                    'jobId':jobId,
                                    'flowDetailId':flowDetailId,
                                    'ci_csrf_token':csrfHash
                                },
                            success: function(response) {
                                var obj = JSON.parse(response);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                                    setTimeout(function () {
                                        window.location.href = "<?php echo base_url(); ?>approve-jobs/"+flowDetailId; 
                                    }, 2000); 
                                }else if(obj.st == 2){
                                    $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                                }else{
                                    $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                                }
                                $(".loader").hide();
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
    function getQuestion(id, lmId){
        $("#finishmodal_body1").empty();
        // view_learning_module(lmId, 1);
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_questionLM',
            type: 'POST',
            data: {
                    'question_id':id,
                    'lmId':lmId,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#finishmodal_body1").html(obj.body);
                $("#modal_title").html(obj.title);
                $(".loader").hide();
                $('#modal').modal('show');
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }
    function getQuestionEP(id, epId){
        $("#finishmodal_body").empty();
        // view_learning_module(lmId, 1);
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_questionEP',
            type: 'POST',
            data: {
                    'question_id':id,
                    'epId':epId,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#finishmodal_body").html(obj.body);
                $("#modal_title").html(obj.title);
                $(".loader").hide();
                $('#modal').modal('show');
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }
</script>