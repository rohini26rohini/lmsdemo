<script>
    $('#questionset_data').DataTable({
       'aoColumnDefs': [
            {
                'bSortable': true,
                'aTargets': [0] /* 1st one, start by the right */
            },{
                'bSortable': true,
                'aTargets': [1] /* 1st one, start by the right */
            },{
                'bSortable': true,
                'aTargets': [2] /* 1st one, start by the right */
            },{
                'bSortable': true,
                'aTargets': [3] /* 1st one, start by the right */
            },{
                'bSortable': true,
                'aTargets': [4] /* 1st one, start by the right */
            },{
                'bSortable': false,
                'aTargets': [5] /* 1st one, start by the right */
            },{
                'bSortable': false,
                'aTargets': [6] /* 1st one, start by the right */
            },
        ]
    });
    //show the modules under the subject
    $("#subject").change(function(){
        var sub_id=$("#subject").val();
        if(sub_id != ""){
            $(".loader").show();
            $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/get_modules',
            type: 'POST',
            data: {
                    'parent_subject':$("#subject").val(),
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj=JSON.parse(response);
                $(".loader").hide();
                $("#modules").html(obj['modules'])
            }
        });
      }
    });
    //show the materails under the subject
    $("#modules").change(function(){
         
        var sub_id=$("#modules").val();
        if(sub_id != ""){
            $(".loader").show();
                $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_material_subjectId',
                type: 'POST',
                data: {
                        'id':$("#modules").val(),
                        'type':'question',
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $(".loader").hide();
                    $("#material").html(obj['material'])
                                    }
                });
      }
    });
    //show the modules under the subject//in edit
    $("#edit_subject").change(function(){
         
        var sub_id=$("#edit_subject").val();
        if(sub_id != ""){
            $(".loader").show();
                $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_modules',
                type: 'POST',
                data: {
                        'parent_subject':$("#edit_subject").val(),
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $(".loader").hide();
                    $("#edit_modules").html(obj['modules'])
                                    }
                });
      }
    });
    //show the materails under the subject//in edit
    $("#edit_modules").change(function(){
         
        var sub_id=$("#edit_modules").val();
        if(sub_id != ""){
            $(".loader").show();
                $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_material_subjectId',
                type: 'POST',
                data: {
                        'id':$("#edit_modules").val(),
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $(".loader").hide();
                    $("#material_id").html(obj['material'])
                                    }
                });
      }
    });
    $('#approval_chk').change(function() {
        $('#approve_user_div').empty();
        if(this.checked) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_levelOne_user',
                type: 'POST',
                data: {'ci_csrf_token':csrfHash,'id':1},
                success: function(response) {
                    $('#approve_user_div').html(response);
                    $(".loader").hide();
                }
            });
        }else{
            $('#approve_user_div').empty();
        }
    });
    $('#edit_approval_chk').change(function() {
        $('#edit_approve_user_div').empty();
        if(this.checked) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_levelOne_user',
                type: 'POST',
                data: {'ci_csrf_token':csrfHash},
                success: function(response) {
                    $('#edit_approve_user_div').html(response);
                    $(".loader").hide();
                }
            });
        }else{
            $('#edit_approve_user_div').empty();
        }
    });


    //add question set
    $("form#add_questionset_form").validate({
        rules: {
           question_set_name: {
                required: true
            },
            subject_id: {
                required: true
            },
            material_id: {
                required: true
            },
            module_id: {
                required: true
            },
            approve_users: {
                required: true
            },
        },
        messages: {
            question_set_name: "Please Enter a Name",
            subject_id: "Please choose subject",
            module_id: "Please choose module",
            material_id: "Please Choose Material",
            approve_users: "Please Choose a User"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/questionset_add',
                type: 'POST',
                data: $("#add_questionset_form").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_questionset_form' ).each(function(){
                                        this.reset();
                                });
                                $('#approve_user_div').empty();
                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_questionsetList_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {

                                        $('#questionset_data').DataTable().destroy();
                                        $("#questionset_data").html(response);

                                        $("#questionset_data").DataTable({
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
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });
                        $.toaster({priority:'success',title:'Success',message:obj.message});
                          
                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }                   
                    $(".loader").hide();
                    $('#approve_user_div').empty();
                }
                
            });
             

        }


    });
     //edit question set
    $("form#edit_questionset_form").validate({
        rules: {
           question_set_name: {
                required: true
            },
            module_id: {
                required: true
            },
            subject_id: {
                required: true
            },
            material_id: {
                required: true
            }
        },
        messages: {
            question_set_name: "Please Enter a Name",
            subject_id: "Please choose subject",
            module_id: "Please choose module",
            material_id: "Please Choose a Material"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/questionset_edit',
                type: 'POST',
                data: $("#edit_questionset_form").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_questionset_form' ).each(function(){
                                        this.reset();
                                });

                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_questionsetList_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {

                                        $('#questionset_data').DataTable().destroy();
                                        $("#questionset_data").html(response);

                                        $("#questionset_data").DataTable({
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
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });
                        $.toaster({priority:'success',title:'Success',message:obj.message});
                          
                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }                   
                    $(".loader").hide();
                }
                
            });
             

        }


    });
    //delete question set
    function delete_questionset(id)
    {
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
                                    url: '<?php echo base_url();?>backoffice/Questionbank/delete_questionset',
                                    type: 'POST',
                                    data: {
                                        question_set_id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            //$.alert(obj.message);
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_questionsetList_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {

                                        $('#questionset_data').DataTable().destroy();
                                        $("#questionset_data").html(response);

                                        $("#questionset_data").DataTable({
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
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });
                                        } else {
                                           // $.alert(obj.message);
                                            $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                                        }
                                        $(".loader").hide();
                                    }
                                });
                        }

                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
    
     ///get questionset data in edit form
    function get_questionset(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/get_questionset_data_byId',
            type: 'POST',
            data: {
                question_set_id : id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                $(".loader").hide();
                var obj = JSON.parse(response);
                   // alert(obj['subject_html']);
                $("#question_set_id").val(obj['data'].question_set_id);
                $("#question_set_name").val(obj['data'].question_set_name);
                $("#edit_subject").html(obj['subject_html']);
                $("#edit_subject").val(obj.parent_subject);
                $("#edit_modules").html(obj.modules);
                $("#edit_modules").val(obj['data'].subject_id);
                $("#material_id").html(obj.material);
                $("#material_id").val(obj['data'].material_id);
                $('#editModal').modal({
                    show: true
                });
            }
        });
    }

    function view_approve_status(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/get_approve_status',
            type: 'POST',
            data: {
                id : id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                $("#view_approval_status_table").html(response);
                $('#view_approval_status').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }
</script>
