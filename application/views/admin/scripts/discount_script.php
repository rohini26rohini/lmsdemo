<script>
    function clearmodal(){
        formclear('add_fee_head_form');
        $("div.error").remove();
        $(".error").empty();
        $("label.error").hide();
    }
    $(document).ready(function(){
        $("#discount_data").dataTable({
            aaSorting: [[0, 'asc']],
            bPaginate: false,
            bFilter: false,
            bInfo: false,
            bSortable: true,
            bRetrieve: true,
            aoColumnDefs: [
                { "aTargets": [ 0 ], "bSortable": true },
                { "aTargets": [ 1 ], "bSortable": true },
                { "aTargets": [ 2 ], "bSortable": false }
            ]
        }); 
        $("#discount_amount").keyup(function(){
            var package_type = $('#package_type').val();
// alert(package_type);
                if(package_type!="1"){
                      var num=$("#discount_amount").val();
                      
                    if(num > 100)
                        {
                            $("#discount_amount").val("");
                            $("#edit_discount_amount_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#edit_discount_amount_msg").html("");
                        }  
        }      
                }); 

                $("#edit_package_amount").keyup(function(){
                    var edit_package_type = $('#edit_package_type').val();
                 // alert(package_type);
                if(edit_package_type!="1"){
                      var num=$("#edit_package_amount").val();
                    if(num > 100)
                        {
                            $("#edit_package_amount").val("");
                            $("#discount_amount_msg").html("Enter a number which is less than or equal to 100")
                        }
                    else
                        {
                              $("#discount_amount_msg").html("");
                        }   
                }     
                }); 
        $("form#add_discount_form").validate({
            rules: {
                package_name: {
                               required: true,
                               remote: {    
                                        url: '<?php echo base_url();?>backoffice/Discount/check_category_name',
                                        type: 'POST',
                                        data: {
                                                discount_name: function() {
                                                return $("#discount_name").val();
                                                },
                                                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                              }
                                       }
                              }
            },
            messages: {
                package_name: {
                    required:"Please enter a discount name",
                    remote:"This category already exist"
                }
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Discount/discount_add',
                    type: 'POST',
                    data: $("#add_discount_form").serialize(),
                    success: function(response) {
                        if (response != "2" && response != "0") {
                            $('#add_discount').modal('toggle');
                            $('#add_discount_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : 'Discount Category Added Succesfully ' });
                            // $("#discount_data").append(response);
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Discount/load_discount_ajax',
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    $('#discount_data').DataTable().destroy();
                                    $("#discount_data").html(response);
                                    $("#discount_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //        "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': true,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [2]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                        }
                        else if(response == "2")
                        {
                            $.toaster({ priority : 'danger', title : 'Error', message : 'Discount Category Already Exist' });
                        
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#edit_discount_form").validate({
            rules: {
                package_name: {
                    required: true,
                               remote: {    
                                        url: '<?php echo base_url();?>backoffice/Discount/check_category_name_edit',
                                        type: 'POST',
                                        data: {
                                                discount_name: function() {
                                                return $("#edit_package_name").val();
                                                },
                                                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                              }
                                       }
                               }
            },
            messages: {
                package_name: {required:"Please enter a discount name",
                    remote:"This category already exist"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Discount/discount_edit',
                    type: 'POST',
                    data: $("#edit_discount_form").serialize(),
                    success: function(response) {
                        if (response == 1) {
                            $('#edit_discount').modal('hide');
                            $.toaster({ priority : 'success', title : 'Success', message : 'Discount Category Updated Successfully' });
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Discount/load_discount_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                            $('#discount_data').DataTable().destroy();
                                            $("#discount_data").html(response);
                                            $("#discount_data").DataTable({
                                                "searching": true,
                                                "bPaginate": true,
                                                "bInfo": true,
                                                "pageLength": 10,
                                            //        "order": [[4, 'asc']],
                                                "aoColumnDefs": [
                                                    {
                                                        'bSortable': true,
                                                        'aTargets': [0]
                                                    },
                                                    {
                                                        'bSortable': true,
                                                        'aTargets': [1]
                                                    },
                                                    {
                                                        'bSortable': false,
                                                        'aTargets': [2]
                                                    }
                                                ]
                                            });    
                                            $(".loader").hide();
                                        } 
                                }); 
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#add_discount_packages_form").validate({
            rules: {
                package_master_id: {required: true},
                package_type: {required: true},
                package_amount: {required: true},
                package_desc: {required: true}
            },
            messages: {
                package_master_id: {required:"Please choose discount category"},
                package_type: {required:"Please choose a package type"},
                package_amount: {required: "Please enter discount"},
                package_desc: {required: "Please enter description"}

            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Discount/discount_packages_add',
                    type: 'POST',
                    data: $("#add_discount_packages_form").serialize(),
                    success: function(response) {
                      
                        var obj=JSON.parse(response);
                        if(obj['st'] ==1)
                            {
                              $('#add_discount_packages').modal('toggle');
                              $('#add_discount_packages_form' ).each(function(){
                                this.reset();
                              });
                              $.toaster({ priority : 'success', title : 'Success', message : 'Discount Package Added Succesfully ' });  
                                 $.ajax({
                                url: '<?php echo base_url();?>backoffice/Discount/load_discount_packages_ajax',
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
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                            }
                        else if (obj['st'] ==0) {
                            
                            $.toaster({ priority : 'danger', title : 'Invalid Request', message : 'Something went wrong,Please try again later..!' });
                           
                        }else if(obj['st'] == "2"){
                            $.toaster({ priority : 'warning', title : 'Error', message : 'Discount Package already exist' });
                        
                        }
                        else{
                             $.toaster({ priority : 'danger', title : 'Invalid Request', message : 'Something went wrong,Please try again later..!' });
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#edit_discount_packages_form").validate({
        rules: {
            package_master_id: {required: true},
            package_type: {required: true},
            package_amount: {required: true},
            package_desc: {required: true}
        },
        messages: {
            package_master_id: {required:"Please choose discount category"},
            package_type: {required:"Please choose a package type"},
            package_amount: {required: "Please enter discount"},
            package_desc: {required: "Please enter description"}       
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Discount/discount_packages_edit',
                type: 'POST',
                data: $("#edit_discount_packages_form").serialize(),
                success: function(response) {
                     $(".loader").hide();
                    
                    var obj=JSON.parse(response); 
                    if (obj['st'] == 1) {
                        $('#edit_discount_packages').modal('toggle');
                        $.toaster({ priority : 'success', title : 'Success', message : 'Discount Package Updated Successfully' });
                        $.ajax({
                                url: '<?php echo base_url();?>backoffice/Discount/load_discount_packages_ajax',
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
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                    }
                    else if (obj['st'] == 2){
                        $.toaster({ priority : 'warning', title : 'Invalid Request', message : 'This data already exist' });
                    }else {
                        $.toaster({ priority : 'danger', title : 'Invalid Request', message : 'Something went wrong,Please try again later..!' });
                    }
                   
                }
            });
        }
    });

});

    function delete_discount(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Discount/discount_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == 1) {
                                    $.toaster({ priority : 'success', title : 'Success', message : 'Discount category deleted successfully!' });
                                    $("#row_"+id).remove();
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Discount/load_discount_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                            $('#discount_data').DataTable().destroy();
                                            $("#discount_data").html(response);
                                            $("#discount_data").DataTable({
                                                "searching": true,
                                                "bPaginate": true,
                                                "bInfo": true,
                                                "pageLength": 10,
                                                //        "order": [[4, 'asc']],
                                                "aoColumnDefs": [
                                                    {
                                                        'bSortable': true,
                                                        'aTargets': [0]
                                                    },
                                                    {
                                                        'bSortable': true,
                                                        'aTargets': [1]
                                                    },
                                                    {
                                                        'bSortable': false,
                                                        'aTargets': [2]
                                                    }
                                                ]
                                            });    
                                            $(".loader").hide();
                                        } 
                                    }); 
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_discountdata(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Discount/get_discount_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_package_master_id").val(obj.package_master_id);
                $("#edit_package_name").val(obj.package_name);
                $('#edit_discount').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }

    function delete_discount_packages(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Discount/discount_packages_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == 1) {
                                    $.toaster({ priority : 'success', title : 'Success', message : 'Successfully Deleted!' });
                                    $("#row_"+id).remove();
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Discount/load_discount_packages_ajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_discount_packagesdata(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Discount/get_discount_packages_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_package_id").val(obj.package_id);
                $("#edit_package_master_id").val(obj.package_master_id);
                $("#edit_package_type").val(obj.package_type);
                $("#edit_package_amount").val(obj.package_amount);
                $("#edit_package_desc").val(obj.package_desc);
                $('#edit_discount_packages').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }
//------------------------------------------Fee Head--------------------------------------------//

$("form#add_fee_head_form").validate({
    rules: {
        fee_head: {
        required: true,
        remote: {    
                 url: '<?php echo base_url();?>backoffice/Discount/check_fee_head_name',
                 type: 'POST',
                 data: {
                         head_name: function() {
                         return $("#fee_head").val();
                         },
                          <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                       }
                }
        }
    },
    messages: {
        fee_head: {
            required:"Please enter a fee head",
            remote:"This fee head already exist"
        }
    },
    submitHandler: function(form) {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Discount/fee_head_add',
            type: 'POST',
            data: $("#add_fee_head_form").serialize(),
            success: function(response) {
                $(".loader").hide();
                var obj = JSON.parse(response);
                if(obj.st == 1){
                $('#add_fee_head').modal('toggle');
                    $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Discount/load_fe_head_ajax',
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
                }else{
                    $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                }
            },
                
        });
    }
});

function get_feeHeaddata(id){
    $(".loader").show();
	$('#refundedit').prop('checked', false);
	$('#taxableedit').prop('checked', false);
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Discount/get_fee_head_by_id/'+id,
        type: 'POST',
        data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#ph_id").val(obj.ph_id);
            $("#edit_head").val(obj.ph_head_name);
			if(obj.ph_refund==1) {
				$('#refundedit').prop('checked', true);
			}
			if(obj.ph_taxable==1) {
				$('#taxableedit').prop('checked', true);
			}
            $('#edit_fee_head').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}
$("form#edit_fee_head_form").validate({
    rules: {
        fee_head: {
        required: true,
        remote: {    
                url: '<?php echo base_url();?>backoffice/Discount/check_fee_head_name_edit',
                type: 'POST',
                data: {
                        head_name: function() {
                        return $("#edit_head").val();
                        },
                         <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                      }
                }
        }
    },
    messages: {
        fee_head: {
            required:"Please enter a fee head",
            remote:"This fee head already exist"
        }
    },
    submitHandler: function(form) {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Discount/fee_head_edit',
            type: 'POST',
            data: $("#edit_fee_head_form").serialize(),
            success: function(response) {
                $(".loader").hide();
                var obj = JSON.parse(response);
                if(obj.st == 1){
                $('#edit_fee_head').modal('toggle');
                    $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Discount/load_fe_head_ajax',
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
                }else{
                    $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                }
            },
                
        });
    }
});
function statusChange(id,st){
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
                        $.post('<?php echo base_url();?>backoffice/Discount/edit_fee_head_status/', {
                            id: id,st: st,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            $.toaster({priority:'success',title:'Success',message:'Status changed successfully!'});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Discount/load_fe_head_ajax',
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
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
</script>