
    <script type="text/javascript">
        $(document).ready(function(){

            $('#material').change(function(){
                $(".loader").show();	   
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Questionbank/get_question_set_material',
                    type: 'POST',
                    data: {
                            'material':$("#material").val(),
                            'ci_csrf_token':csrfHash
                        },
                    success: function(response) {
                        $(".loader").hide();
                        $("#question_set").html(response);
                    }
                });
            });

            $('#viewquestions').click(function(){
                $(".loader").show();	   
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Questionbank/get_questions',
                    type: 'POST',
                    data: {
                            'question_set':$("#question_set").val(),
                            'ci_csrf_token':csrfHash
                        },
                    success: function(response) {
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 0){
                            if(obj.message == "Please select a question set") {
                                $.toaster({ priority : 'warning', title : 'Invalid', message : obj.message });
                            }
                        }else{
                            $(".questions").html(obj.data);
                            $('#institute_data').DataTable({
                                "language": {
                                "infoEmpty": "No records available.",
                                }
                            });
                        }

                    }
                });
            });
        });

        function viewPassage(id){
            $(".loader").show();	   
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_passage_content',
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
                url: '<?php echo base_url();?>backoffice/Questionbank/get_question_content',
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

        function viewUsedMaterials(id){
            $(".loader").show();	   
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_question_usages',
                type: 'POST',
                data: {
                        'question_id':id,
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#modal_body1").html(obj.body);
                    $("#modal_title1").html(obj.title);
                    $(".loader").hide();
                    $('#modal1').modal('show');
                }
            });
        }

        function get_question(id){
            $(".loader").show();	   
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_question',
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
                            window.open('<?php echo base_url('backoffice/update-question-set-group?qid='); ?>'+id, '_blank');
                        }
                    },
                    cancel: function() {
                    },
                }
            });

        }

        
 function delete_question(id)
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

                        $.post('<?php echo base_url();?>backoffice/Questionbank/delete_question', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if(obj['st'] == 1)
                                {
                                 $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                                    $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Questionbank/get_questions',
                                        type: "post",
                                        data: {question_set: $("#question_set").val(),
                                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                            },
                                        success: function(response) {
                                            var data = JSON.parse(response);
                                            $(".questions").html(data.data);
                                            $('#institute_data').DataTable({
                                                "language": {
                                                "infoEmpty": "No records available.",
                                                }
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
    </script>
 
