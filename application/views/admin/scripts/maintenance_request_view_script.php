<script>
 $(".cancel").click(function(){
     var id="";
     if($("#complete_id").val() != "")
         {
             id=$("#complete_id").val(); 
         }
     else{
          id=$("#id").val(); 
         }
     if(id != "")
         {
            $("#id_"+id).prop('selectedIndex',0);
            $('#id_'+id+' option:first-child').attr("selected", "selected");  
         }
     
     
      
    });
    
function change_status(id){ 

    var status=($("#id_"+id).val());

    if(status == "Approved")
        {

            approve_request(id);
        }
    else if(status == "Waiting for Approval")
        {
           send_for_approval(id);
        }
    else if(status == "Completed")
        {
          show_completion_modal(id);
        }
    else if(status == "Decline")
        {
          decline_request(id);
        }
}
    //decline request
    function decline_request(id)
    {
         $("#decline_id").val(id);
         $('#declineModal').modal({  show: true });

    }
//decline form
$("form#decline_form").validate({
        rules: {
                comments:{
                required: true
                }
               },
       messages: {
              comments:"Please Enter Comments",
              },
        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/decline_request',
                type: 'POST',
                data: $("#decline_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#declineModal').modal('toggle');
                                 $( '#decline_form').each(function(){
                                        this.reset();
                                });

                           $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_view_byAjax',
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
                                },{
                                    'bSortable': false,
                                    'aTargets': [8]
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
                    else
                        {
                           $.toaster({priority:'danger',title:'ERROR',message:"Something went wrong,Please try again later..!"});
                        }

                    $(".loader").hide();
                }

            });


        }


    });

   function show_completion_modal(id)
    {
         $("#complete_id").val(id);
         $('#cModal').modal({  show: true });
    }

    //approve request
     function approve_request(id)
    {
      if(id !=""){
            $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/approve_request_byOperationHead',
                    type: 'POST',
                    data: {
                        id: id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    var obj = JSON.parse(response);
                        if (obj.st == 1) {
                           $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_view_byAjax',
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
                                },{
                                    'bSortable': false,
                                    'aTargets': [8]
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
                        $(".loader").hide();
                    }
                });
        }

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
                            $("#show_mtype").html(obj['data'].maintenanacetype_name);
                            $("#show_type").html(obj['data'].type);
                            $("#show_centre").html(obj.centre_name);
                            $("#show_authority").html(obj['data'].approving_authority);
                            $("#show_status").html(obj['data'].approved_status);
                            $("#show_request_date").html(obj['data'].created_on);
                            $("#show_approved_by").html(obj['data'].approved_by);
                            $("#show_date_of_approval").html(obj['data'].date_of_approval);
                            $("#show_comments").html(obj['data'].comments);
                           // $("#show_date_of_completion").html(obj['data'].date_of_completion);
                           // $("#show_total_amount").html(obj['data'].total_amount);
                            //$("#show_requested_amount").html(obj['data'].requested_amount);
                            $("#show_total_amount").html(obj['old_amount_taken']);
                            $("#show_requested_amount").html(obj['old_amount_requested']);
                            $("#show_date_of_completion").html(obj['old_dates']);
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
    function send_for_approval(id)
    {
        $("#id").val(id);
        $('#myModal').modal({  show: true });

    }
    
    //send for approval
    
    $("form#send_approval_form").validate({
        rules: {
             
            total_amount:{
                required: true
            },
            comments:{
                required: true
            }
        },
        messages: {
           
            total_amount:"Please Enter the Amount",
            comments:"Please Enter Comments",
            
        },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/send_for_approval',
                type: 'POST',
                data: $("#send_approval_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#send_approval_form').each(function(){this.reset(); });

                                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_view_byAjax',
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
                                },{
                                    'bSortable': false,
                                    'aTargets': [8]
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
    
    //completion

    $("form#completion_form").validate({
        rules: {

            total_amount:{
                required: true
            },
        },
        messages: {

            total_amount:"Please Enter the Total Amount"

        },

        submitHandler: function(form) {
             $(".loader").show();

            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/complete_task',
                type: 'POST',
                data: $("#completion_form").serialize(),
                success: function(response) {
                         $(".loader").hide();
                    var obj=JSON.parse(response);
                      if (obj.st == 1)
                        {
                            $('#cModal').modal('toggle');
                            $( '#completion_form').each(function(){
                                this.reset();
                            });
                                 $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/load_service_request_view_byAjax',
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
                                },{
                                    'bSortable': false,
                                    'aTargets': [8]
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
