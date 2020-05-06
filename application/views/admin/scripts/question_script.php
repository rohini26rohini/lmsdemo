<script>
    var validation=0;
    $("#add_question_form").validate({
        rules: {
            school_name: {
                required: true
            },
            question: {
                required: true,
                 
            }
        },
        messages: {
            school_name: "Please Choose a School",
            question: "Please Upload Questions",
        },
        submitHandler: function(form) {
                validation=1; 
        }
    });
    
     $("form#add_question_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault()
         //debugger;
            if (validation == 1) 
            {
                 $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Question/question_upload',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var obj=JSON.parse(response); 
                    if(obj.st == 1)
                            {
                                $('#add_question').modal('toggle');
                                $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                                 $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Question/refresh_question_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#sample_question_data').DataTable().destroy();
                                        $("#sample_question_data").html(data);

                                        $("#sample_question_data").DataTable({
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
                        else if(obj.st == 2)
                            {
                                
                                $.toaster({priority:'warning',title:'Notice',message:'This file type is not allowed'});
                            }
                        else if(obj.st == 3)
                            {
                                
                                $.toaster({priority:'danger',title:'Invalid',message:'Invalid File Format / Please fill all the datas'});
                            }
                        else if (obj.st == 0)
                            {
                              $.toaster({priority:'danger',title:'Invalid',message:obj.msg});  
                            }
                        else{
                             $.toaster({priority:'danger',title:'ERROR',message:'Error Occured'});
                        }
                        $(".loader").hide();
                    }
                });
                
            }
     });
    
    function delete_question(id)
    {
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

                        $.post('<?php echo base_url();?>backoffice/Question/question_delete/', {
                            subject_id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {

                            if (data == 1) {
                               
                                 $.alert('Successfully <strong>Deleted..!</strong>');
                                  $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Question/refresh_question_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#sample_question_data').DataTable().destroy();
                                        $("#sample_question_data").html(data);

                                        $("#sample_question_data").DataTable({
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
                        });

                        /*$.alert('Successfully <strong>Deleted..!</strong>');*/
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
    function get_question(id)
    {
        $(".loader").show();
       // alert("jk");
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Question/get_question_by_id/' + id,
            type: 'POST',
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {

                var obj=JSON.parse(response);
                $("#edit_question_id").val(obj.question_id);
                $("#edit_school").val(obj.school_id);
                $("#edit_serialno").val(obj.question_serialno);
                $("#edit_questions").val(obj.question);
                $("#edit_a").val(obj.question_option_a);
                $("#edit_b").val(obj.question_option_b);
                $("#edit_c").val(obj.question_option_c);
                $("#edit_d").val(obj.question_option_d);
                $("#edit_ans").val(obj.answer);
                 $('#edit_question').modal({
                        show: true
                        });
                $(".loader").hide();
            }
          });
        
    }
    
    var edit_validation=0;
     $("#edit_question_form").validate({
        rules: {
            school_id: {
                required: true
            },
            question: {
                required: true,
                 
            }, 
            question_option_a: {
                required: true,
                 
            },
            question_option_b: {
                required: true,
                 
            },
            question_option_c: {
                required: true,
                 
            },
            question_option_d: {
                required: true,
                 
            }, 
            answer: {
                required: true,
                 
            }
        },
        messages: {
            school_name: "Please Choose a School",
            question: "Please Add Question",
            question_option_a: "Please Add Option A",
            question_option_b: "Please Add Option B",
            question_option_c: "Please Add Option C",
            question_option_d: "Please Add Option D",
            answer: "Please Add Answer"
        },
        submitHandler: function(form) {
                edit_validation=1; 
        }
    });
    $("form#edit_question_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault()
         //debugger;
        var id=$("#edit_question_id").val();
            if (edit_validation == 1) 
            {
                $(".loader").show();
                $.ajax({
                url: '<?php echo base_url();?>backoffice/Question/edit_question',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    var obj=JSON.parse(response);
                    if(obj['res'] == true)
                        {
                            $('#edit_question').modal('toggle'); 
                             $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Question/refresh_question_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#sample_question_data').DataTable().destroy();
                                        $("#sample_question_data").html(data);

                                        $("#sample_question_data").DataTable({
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
                    else{
                         $.toaster({priority:'danger',title:'ERROR',message:'Error Occured'});
                    }
                    $(".loader").hide();
                }
            });
                
            }
     });
    
 $(document).ready(function() {
    $('#sample_question_data').DataTable( { 
        "pageLength" : 10,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
       // "order": [], //Initial no order.
         //"bSort": false,
        "searching" :false,
         "order": [
          [1, "desc" ]
        ],
 
        // Load data for the table's content from an Ajax source
            "ajax": {
            "url": "<?php echo base_url();?>backoffice/Question/sample_questions_ajax",
            "type": "POST",
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                  },
           },
         //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    } );
});
</script>
