<script>
$(document).ready(function(){
    get_modules()
});

function get_modules(){
    var material_type=$("#materialtype").val();
    if(material_type == 'question')
    {
        $("#upload").hide();
    }
    else
    {
        $("#upload").show();
    }
      $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Questionbank/get_subjects',
        type: 'POST',
        data: {
                'material':$("#materialtype").val(),
                'ci_csrf_token':csrfHash
            },
        success: function(response) {
            var obj=JSON.parse(response);
            $(".loader").hide();
            $("#subject").html(obj['subject'])
                            }
    });
}
    //show the subject or module based on material type in add material
    $("#materialtype").change(function(){
        get_modules()
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
    
    
    //add material
    var validation = 0;
    $("#add_material_form").validate({

      rules: {
                material_type: {
                    required: true,
                },
                subject_id: {
                    required: true
                },module_id: {
                    required: true
                },
          material_name: {
                     required: true,
                    // nospecialChar:true,
              remote: {
                        url: '<?php echo base_url();?>backoffice/Questionbank/material_nameCheck',
                        type: 'POST',
                        data: {
                        material_name: function() {
                              return $("#name").val();
                              },
                     <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }
                       }
                },
          } ,
    messages: {
                material_type:{
                    required:"Please Choose Material Type"
                    } ,
                subject_id:{
                    required:"Please Choose Subject"
                    } ,module_id:{
                    required:"Please Choose Module"
                    } ,
        material_name:{
                    required:"Please Enter Material Name",
                    //nospecialChar:"Please Enter a Valid Name",
                    remote:"This material name already exist"
                    } ,
        },
         submitHandler: function(form) {
                validation = 1;
        }
    });
    $("form#add_material_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault()
         //debugger;
            if (validation == 1)
            {
                 $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Questionbank/add_material',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        validation = 0;
                        var obj=JSON.parse(response);
                        if(obj.st == 1)
                            {
                                $('#myModal').modal('toggle');
                                $('#add_material_form').trigger('reset');
                                $.toaster({priority:'success',title:'Success',message:obj.message});
                                 $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_materialList_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                       
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);
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
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
                            }
                        if(obj.st == 2)
                        {
                          $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                        }
                        if(obj.st == 0)
                        {
                          $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                        }
                        $(".loader").hide();
                    }
                });

            }
     });

    //delete material
function delete_material(id) {
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
                            $(".loader").show();
                        $.post('<?php echo base_url();?>backoffice/Questionbank/delete_material/', {
                            material_id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                               var obj=JSON.parse(data);
                           
                            if (obj['st'] == true) {

                                 // $.alert('Successfully <strong>Deleted..!</strong>');
                                $.toaster({priority:'success',title:'Success',message:'data deleted successfully'});
                                 $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_materialList_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                       
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);

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
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
                            }
                            else
                                {
                                  //$.alert('<strong>Invalid Request</strong>');  
                                    $.toaster({priority:'danger',title:'Invalid',message:'Something went wrong,Please try again later..!'});
                                }
                            $(".loader").hide();
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
    
    function get_materialdata(id)
    {
        $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_material_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    
                    var obj = JSON.parse(response);
                   // alert(obj['material'].subject_id);
                    $("#edit_material_id").val(obj['material'].material_id);
                    $("#edit_subject").html(obj['subject']);
                    $("#edit_subject").val(obj['parent_subject']);
                    $("#edit_modules").html(obj['modules']);
                    $("#edit_modules").val(obj['material'].subject_id);
                    $("#edit_materialname").val(obj['material'].material_name);
                    //$("#edit_materialtype").html(obj['materialtype']);
                    $("#edit_materialtype").val(obj['material'].material_type);
                    if(obj['material'].material_type == "question")
                        {
                            $("#edit_upload").hide();
                        }
                    else{
                         $("#edit_upload").show();
                         $("#edit_materiallink").html(obj['material'].material_link);  
                    }
                   $('#edit_material').modal({
                        show: true
                        });
                      $(".loader").hide();
                }
            });
    }
       

$("#edit_materialtype").change(function(){
   var material_type= $('#edit_materialtype').val();
//    alert(material_type);
    if(material_type == 'question')
           {
              $("#edit_upload").hide();
           }
          else
          {
             $("#edit_upload").show();
           }
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_subjects',
                type: 'POST',
                data: {
                        'material':$("#edit_materialtype").val(),
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj=JSON.parse(response);
                    $(".loader").hide();
                    $("#edit_subject").html(obj['subject'])
                                   }
            });

});
    
     //show the modules under the subject
    $("#edit_subject").change(function(){
         $(".loader").show();
        var sub_id=$("#edit_subject").val();
        if(sub_id != ""){
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
//edit material
     
    var edit_validation = 0;
    $("#edit_material_form").validate({

      rules: {
                material_type: {
                    required: true,
                },
                subject_id: {
                    required: true
                },
          material_name: {
                     required: true,
                     //nospecialChar:true,
              remote: {
                                url: '<?php echo base_url();?>backoffice/Questionbank/editmaterial_nameCheck',
                                type: 'POST',
                                data: {
                                    id:function() {
                                      return $("#edit_material_id").val();
                                      },
                                material_name: function() {
                                      return $("#edit_materialname").val();
                                      },
                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }
                       }
                },
          } ,
    messages: {
                material_type:{
                    required:"Please Choose Material Type"
                    } ,
                subject_id:{
                    required:"Please Choose Subject"
                    } ,
        material_name:{
                    required:"Please Enter Material Name",
                    //nospecialChar:"Please Enter a Valid Name",
                     remote:"This material name already exist"

                    } ,
        },
         submitHandler: function(form) {
                edit_validation = 1;
        }
    });
    
    
    $("form#edit_material_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault()
         //debugger;
    
            if (edit_validation == 1)
            {
                 $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Questionbank/edit_material',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        edit_validation = 0;
                        var obj=JSON.parse(response);
                    if(obj.st == 1)
                            {                                
                                $('#edit_material').modal('toggle');
                                 $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_materialList_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                       
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);

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
                        else if(obj.st == 2)
                        {
                          $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                        }
                        else if(obj.st == 3)
                        {
                          $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                        }
                        else
                        {
                          $.toaster({priority:'danger',title:'ERROR',message:obj.message});
                        }
                        $(".loader").hide();
                    }
                });

            }
     });
</script>
