<script>
    $(document).ready(function(){
        
       /* $(".clear_date").click(function(){
           // alert("jhghj");
             $('#start_date').datetimepicker({
                useCurrent: true //Important! See issue #1075
                });
                $('#end_date').datetimepicker({
                useCurrent: true //Important! See issue #1075
                });
            
        });*/

   $('#end_date').change(function () {
        var start= $("#start_date").val();		  
        var end= $("#end_date").val();
        $.ajax({
            url:'<?php echo base_url();?>backoffice/Leave/num_days',
            data: {start: start, end:end,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            type: 'post',
            success: function(data) { 
                $("#num_days").val(data);  
            }
        });
    });

     $('#end_date').click(function () {
        var start= $("#start_date").val();		  
        var end= $("#end_date").val();
        $.ajax({
            url:'<?php echo base_url();?>backoffice/Leave/num_days',
            data: {start: start, end:end,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            type: 'post',
            success: function(data) { 
                $("#num_days").val(data);  
            }
        });
    });

        $("form#add_leave_form").validate({
            rules: {
                type_id: {required: true},
                start_date: {   required: true,
                                remote:{
                                    url: '<?php echo base_url();?>backoffice/Leave/duplicate_leave_start',
                                    type: 'POST',
                                    data: {
                                          start_date: function() {
                                          return $("#start_date").val();
                                          },
                                         user_id: function() {
                                          return $("#user_id").val();
                                          },
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        }
                                }
                            },
                 end_date: {
                        required: true,
                        remote:{
                                    url: '<?php echo base_url();?>backoffice/Leave/duplicate_leave_end',
                                    type: 'POST',
                                    data: {
                                          end_date: function() {
                                          return $("#end_date").val();
                                          },
                                         user_id: function() {
                                          return $("#user_id").val();
                                          },
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        }
                                }
                 },
                title: {required: true},
                description: {required: true}
            },
            messages: {
                type_id: {required:"Please choose leave type"},
                start_date: {
                    required:"Please choose start date",
                    remote:"Already a leave is applied on this date"
                },
                 end_date: {
                    required:"Please choose end date",
                    remote:"Already a leave is applied on this date"},
                title: {required:"Please enter subject"},
                description: {required:"Please enter content"},
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Leave/leave_add',
                    type: 'POST',
                    data: $("#add_leave_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if(obj['st'] == 1)
                            {
                               $('#add_leave').modal('toggle');
                               $('#add_leave_form' ).each(function(){
                                this.reset();
                               });
                               $.toaster({ priority : 'success', title : 'Success', message : 'Leave Added Succesfully ' });
                                $.ajax({
                                url: '<?php echo base_url();?>backoffice/Leave/load_leave_ajax',
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
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [5]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                            }
                        
                        else if(obj['st'] == "2")
                        {
                            $.toaster({ priority : 'warning', title : 'Error', message : 'Already a leave is applied on this dates' });
                        
                        }
                        else
                        {
                         $.toaster({ priority : 'danger', title : 'Error', message : 'Something went wrong,Please try again later..!' });   
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#edit_leave_form").validate({
            rules: {
                id: {required: true},
                start_date: {required: true,
                            remote:{
                                    url: '<?php echo base_url();?>backoffice/Leave/duplicate_leave_start_edit',
                                    type: 'POST',
                                    data: {
                                          start_date: function() {
                                          return $("#edit_start_date").val();
                                          },
                                         leave_id: function() {
                                          return $("#edit_leave_id").val();
                                          },
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        }
                                }
                            },
                end_date: {required: true,
                     remote:{
                                    url: '<?php echo base_url();?>backoffice/Leave/duplicate_leave_end_edit',
                                    type: 'POST',
                                    data: {
                                          end_date: function() {
                                          return $("#edit_end_date").val();
                                          },
                                         leave_id: function() {
                                          return $("#edit_leave_id").val();
                                          },
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        }
                                }
                 },
                title: {required: true},
                description: {required: true}
            },
            messages: {
                id: {required:"Please choose leave type"},
                start_date: {required:"Please choose start date",
                            remote:"Already a leave is applied on this date"},
                  end_date: {
                        required:"Please choose end date",
                      remote:"Already a leave is applied on this date"},
                title: {required:"Please enter subject"},
                description: {required:"Please enter content"},
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Leave/leave_edit',
                    type: 'POST',
                    data: $("#edit_leave_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if (obj['st'] == 1) {
                            $('#edit_leave').modal('toggle');
                            $.toaster({ priority : 'success', title : 'Success', message : 'Leave Updated Successfully' });
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_leave_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                        }
                        else{
                          $.toaster({ priority : 'danger', title : 'Error', message : 'Something went wrong,Please try again later..!' });    
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#add_description").validate({
        rules: {
            description : {required: true}
        },
        messages: {
            description: {required:"Please enter description"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Leave/description_add',
                type: 'POST',
                data: $("#add_description").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#description_modal').modal('toggle');
                        $('#add_description' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Reason added succesfully' });
                        // setTimeout(function(){ window.location.reload(); }, 3000);
                        // $("#description_data").append(response);
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_approve_leave_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });
                    }
                    else if(response == "2")
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Reason already exist'});
                         
                    }
                    $(".loader").hide();
                }
            });
        }
    });
});

    function delete_leave(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Leave/leave_delete', 
                               {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj=JSON.parse(data);
                           // alert(obj['st']);
                                if (obj['st'] == 1) {
                                   
                                   $.toaster({priority:'success',title:'Success',message:"Succesfully Deleted..!"});
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_leave_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                                }
                            else{
                                $.toaster({priority:'danger',title:'Invalid',message:"Something went wrong,Please try again later..!"});
                            }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_leavedata(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Leave/get_leave_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_leave_id").val(obj.leave_id);
                $("#edit_id").val(obj.type_id);
                $("#edit_start_date").val(obj.start_date);
                $("#edit_end_date").val(obj.end_date);
                $("#edit_title").val(obj.title);
                $("#edit_description").val(obj.description);
                $("#edit_num_days").val(obj.num_days);

                $('#edit_leave').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }
    // function edit_leave_status(id){
    //     var status=($("#id_"+id).val());
    //     if(status == "1"){
    //         approve_request(id);
    //     }else if(status == "2"){
    //         send_for_rejection(id);
    //     }else if(status == "1"){
    //         show_completion_modal(id);
    //     }
    // }

    // //approve request
    // function approve_request(id){
    //     if(id !=""){
    //     $(".loader").show();
    //         $.ajax({
    //             url: '<?php echo base_url();?>backoffice/Leave/leave_status',
    //             type: 'POST',
    //             data: {
    //                 id: id,
    //                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //             },
    //             success: function(response) {
    //                 var obj = JSON.parse(response);
    //                 if (obj.st == 1) {
    //                     $.ajax({
    //                         url: '<?php echo base_url();?>backoffice/Leave/load_approve_leave_ajax',
    //                         type: "post",
    //                         data: {
    //                                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //                             },
    //                         success: function(data) {
    //                             $('#syllabus_data').DataTable().destroy();
    //                             $("#syllabus_data").html(data);
    //                             $("#syllabus_data").DataTable({
    //                                 "searching": true,
    //                                 "bPaginate": true,
    //                                 "bInfo": true,
    //                                 "pageLength": 10,
    //                         //        "order": [[4, 'asc']],
    //                                 "aoColumnDefs": [
    //                                     {
    //                                         'bSortable': false,
    //                                         'aTargets': [0]
    //                                     },
    //                                     {
    //                                         'bSortable': false,
    //                                         'aTargets': [1]
    //                                     },
    //                                     {
    //                                         'bSortable': false,
    //                                         'aTargets': [2]
    //                                     },
    //                                     {
    //                                         'bSortable': false,
    //                                         'aTargets': [3]
    //                                     },
    //                                     {
    //                                         'bSortable': false,
    //                                         'aTargets': [4]
    //                                     },
    //                                     {
    //                                         'bSortable': false,
    //                                         'aTargets': [5]
    //                                     }

    //                                 ]
    //                             });
    //                         }
    //                     });
    //                     $.toaster({priority:'success',title:'Success',message:obj.message});
    //                 }else {
    //                     $.toaster({priority:'warning',title:'Invalid',message:obj.message});
    //                 }
    //                 $(".loader").hide();
    //             }
    //         });
    //     }
    // }




    function edit_leave_status(id,status)
    {
            
        $.confirm({
            title: 'Alert message',
            content: 'Are you sure you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Approve',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/leave_status',
                                    type: 'POST',
                                    data: {
                                        leave_id: id,
                                        leave_status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    
                                    success: function(response) {
                                        // alert("sfsdfs");
                                        if (response != "2" && response != "0") {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_approve_leave_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                    }
                                   });
                                    $.toaster({priority:'success',title:'Success',message:'Status Changed Successfully!'});
                                            //$("#row_"+id).remove();
                                        }
                                        // else {
                                           
                                        //      $.toaster({priority:'warning',title:'Success',message:'Invalid Request!'});
                                        // }
                                        $(".loader").hide();
                                    }
                                });
                        }

                    }
                },
                reject: function() {
                    $("#leave_id").val(id);
                    $('#description_modal').modal({  show: true });
                },
                cancel: function() {
                },
            }
        });
        }

        function leave_entry(status)
        {
                        // if(id !=""){
                            $(".loader").show();
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/leave_entry',
                                    type: 'POST',
                                    data: {
                                        status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    
                                    success: function(response) {
                                        // alert("sfsdfs");
                                        if (response != "2" && response != "0") {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_approve_leave_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                    }
                                   });
                                    $.toaster({priority:'success',title:'Success',message:'Status Changed Successfully!'});
                                            //$("#row_"+id).remove();
                                        }
                                        // else {
                                           
                                        //      $.toaster({priority:'warning',title:'Success',message:'Invalid Request!'});
                                        // }
                                        $(".loader").hide();
                                    }
                                });
                        // }

                // cancel: function() {
                // }
        }

    function view_leave(id)
    {
        $(".loader").show();
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Leave/get_leave_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#view_head").html(obj.head);
                    $("#view_start_date").html(obj.start_date);
                    $("#view_end_date").html(obj.end_date);
                    $("#view_title").html(obj.title);
                    $("#view_description").html(obj.description);
                     $('#view_leaves').modal({
                        show: true
                        });
                        $(".loader").hide();
                }
            });

    }

    function get_val(id) {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Leave/get_leave_val',
            type: 'POST',
            data:{id: id,selectid: $("#reject_status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                if (response == "1") {
                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_approve_leave_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });
                                    }
                                   });
                }
                $(".loader").hide();
                $("#leave_id").val(id);
                $("#status").val(status);
                $('#description_modal').modal({
                    show: true
                });
            }
        });
    }

   $(document).ready(function(){
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
             $('#last_date').data("DateTimePicker").maxDate(e.date);
            
        });

        $('#edit_start_date').datetimepicker();
        $('#edit_end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#edit_start_date").on("dp.change", function (e) {
            $('#edit_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#edit_end_date").on("dp.change", function (e) {
            $('#edit_start_date').data("DateTimePicker").maxDate(e.date);
             $('#last_date').data("DateTimePicker").maxDate(e.date);
            
        });
    });
  //  });

// function numdays(){
//     var start= $("#start_date").val();		  
//         var end= $("#end_date").val();
//         $.ajax({
//             url:'<?php echo base_url();?>backoffice/Leave/num_days',
//             data: {start: start, end:end,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
//             type: 'post',
//             success: function(data) { 
//                 $("#num_days").val(data);  
//             }
//         });
// }
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
                            $("#show_mtype").html(obj['data'].maintenanacetype_name);
                            $("#show_type").html(obj['data'].type);
                            $("#show_centre").html(obj.centre_name);
                            $("#show_authority").html(obj['data'].approving_authority);
                            $("#show_status").html(obj['data'].approved_status);
                            $("#show_request_date").html(obj['data'].created_on);
                            $("#show_approved_by").html(obj['data'].approved_by);
                            $("#show_date_of_approval").html(obj['data'].date_of_approval);
                            $("#show_comments").html(obj['data'].comments);
                            $("#show_date_of_completion").html(obj['data'].date_of_completion);
                            $("#show_total_amount").html(obj['data'].total_amount);
                            $("#show_requested_amount").html(obj['data'].requested_amount);
                            $("#show_allowed_amount").html(obj['data'].allowed_amount);
                            $("#show_history").append(obj['history']);
                           // $("#edit_center_name").val(obj['data'].institute_id);
                            $('#showModal').modal({
                                    show: true
                                    });
                            }
                    });
  
    }
    //send for approval
    function send_for_rejection(id)
    {
        $("#leave_id").val(id);
        $('#description_modal').modal({  show: true });

    }

</script>
