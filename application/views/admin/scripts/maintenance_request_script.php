<script>
    $(".cancel").click(function(){
        $('.c_status option:first-child').attr("selected", "selected");
    });
    
    $("#group_name").change(function(){
        var group = $('#group_name').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Commoncontroller/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#branch_name").html(response);

                    }
                });
                $(".loader").hide();
        }
    });
    $("#edit_group_name").change(function(){
        var group = $('#edit_group_name').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Commoncontroller/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#edit_branch_name").html(response);

                    }
                });
                $(".loader").hide();
        }
    });
    
     $("#branch_name").change(function(){
        var branch = $('#branch_name').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center_name").html(response);
                    $(".loader").hide();
                }
            });
        }
       
    });
    $("#edit_branch_name").change(function(){
        var branch = $('#edit_branch_name').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Commoncontroller/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#edit_center_name").html(response);
                    $(".loader").hide();
                }
            });
        }
       
    });

//adding maintenance service
 $("form#add_form").validate({
        rules: {
            group_name:{
                required: true
            }, 
            branch_name:{
                required: true
            },
            center_name:{
                required: true
            },
            description: {
                required: true
            },
            maintenance_type: {
                required: true
            },
             type: {
                required: true
            }
        },
        messages: {
            group_name:"Please Choose a Group",
            branch_name:"Please Choose a Branch",
            center_name:"Please Choose a Centre",
            description: "Please enter description",
            maintenance_type: "Please Choose the Maintenance Type",
            type: "Please Choose a Type"
        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/add_maintenance_request',
                type: 'POST',
                data: $("#add_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_form').each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_byAjax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }

                                            ]
                                        });
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
    
    //get data by id
    function get_requestdata(id)
    {
        $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Asset/get_maintenance_request_byId',
                        type: 'POST',
                        data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                             
                           
                            $("#edit_id").val(obj['data'].service_id);
                            $("#edit_description").val(obj['data'].description);
                            $("#edit_mtype").val(obj['data'].maintenance_type);
                            $("#edit_type").val(obj['data'].type);
                          
                            $("#edit_group_name").val(obj.group_id);
                            $("#edit_branch_name").html(obj.branches);
                            $("#edit_branch_name").val(obj.branch_id);
                            $("#edit_center_name").html(obj.centres);
                            $("#edit_center_name").val(obj['data'].institute_id);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });

    }
    
    //edit maintenance service request
    

    $("form#edit_form").validate({
       rules: {
            group_name:{
                required: true
            }, 
            branch_name:{
                required: true
            },
            center_name:{
                required: true
            },
            description: {
                required: true
            },
            maintenance_type: {
                required: true
            },
             type: {
                required: true
            }
        },
        messages: {
            group_name:"Please Choose a Group",
            branch_name:"Please Choose a Branch",
            center_name:"Please Choose a Centre",
            description: "Please enter description",
            maintenance_type: "Please Choose the Maintenance Type",
            type: "Please Choose a Type"
        },
        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/edit_maintenance_request',
                type: 'POST',
                data: $("#edit_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_form' ).each(function(){
                                        this.reset();
                                });
                          
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_byAjax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }

                                            ]
                                        });
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
    //delete

     function delete_requestdata(id)
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
                                    url: '<?php echo base_url();?>backoffice/Asset/delete_maintenanceRequest_data',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_byAjax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }

                                            ]
                                        });
                                    }
                                   });
                                           
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                           
                                        }
                                        else if(obj.st == 2)
                                        {
                                             $.toaster({priority:'warning',title:'Invalid Request',message:obj.message});
                                        }
                                        
                                        else {
                                           
                                             $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                                        }
                                        $(".loader").hide();
                                    }
                                });
                        }

                    }
                },
                cancel: function() {

                },
            }
        });
    }
//show request data
    function show_request_data(id)
    {
        $("#show_history").html("");
       $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Asset/get_maintenance_request_byId',
                        type: 'POST',
                        data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                             
                           
                         
                            $("#show_description").html(obj['data'].description);
                            $("#show_mtype").html(obj['data'].maintenanacetype_name);
                            $("#show_type").html(obj['data'].type);
                            $("#show_centre").html(obj.centre_name);
                            $("#show_authority").html(obj['data'].approving_authority);
                            $("#show_status").html(obj['data'].approved_status);
                            $("#show_request_date").html(obj['data'].created_on);
                            $("#show_approved_by").html(obj['data'].approved_by);
                            $("#show_date_of_approval").html(obj['data'].date_of_approval);
                            $("#show_comments").html(obj['data'].comments);
                            $("#show_date_of_completion").html(obj['old_dates']);
                            $("#show_history").append(obj['history']);
                           // $("#edit_center_name").val(obj['data'].institute_id);
                            $('#showModal').modal({
                                    show: true
                                    });
                            }
                    });
  
    }

    function change_status(id)
    {
    var status=($("#id_"+id).val());

    if(status == "Reopen")
        {

            reopen_request(id);
        }
   }

    function reopen_request(id)
    {
       $("#complete_id").val(id);
       $('#reopenModal').modal({  show: true });
    }

    //re open

    $("form#reopen_form").validate({
        rules: {

            comments:{
                required: true
            },
        },
        messages: {

            comments:"Please Enter the Comments"

        },

        submitHandler: function(form) {
             $(".loader").show();

            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/Reopen_request',
                type: 'POST',
                data: $("#reopen_form").serialize(),
                success: function(response) {
                         $(".loader").hide();
                    var obj=JSON.parse(response);
                      if (obj.st == 1)
                        {
                            $('#reopenModal').modal('toggle');
                            $( '#reopen_form').each(function(){
                                this.reset();
                            });

                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_byAjax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }

                                            ]
                                        });
                                    }
                                   });
                            $.toaster({priority:'success',title:'Success',message:obj.message});
                        }

                        else {

                             $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                        }

                      }
            });


        }


    });
</script>
