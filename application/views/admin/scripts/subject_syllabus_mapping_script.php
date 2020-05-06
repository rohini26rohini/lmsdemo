<script>
    CKEDITOR.replace('modulecontent');
    CKEDITOR.replace('editmodulecontent');
    
//subject syllabus mapping search function
    
$(".search_syllabus_mapp").change(function(){
     var subject_id  = $('#search_subject').val();
     var syllabus_id = $('#search_syllabus').val();
    if(subject_id || syllabus_id){
         $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_mapdata',
            type: 'POST',
            data: {
                subject: subject_id,syllabus: syllabus_id,
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
                                                }
                                            ]
                                        });  
                    $(".loader").hide();  
                                        
                            }
                        });
}
});
    
// function'll get course details of student
// @params student id, 
// @author GBS-R
$("#institute_data").on("click",".getcoursedetails", function(){ 
        var mapp_id= $(this).attr("id");
         $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_syllabus_subject_details',
                type: 'POST',
                data: {mapp_id:mapp_id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    var obj=JSON.parse(response);
                    if(obj.status==1) {
                        ob = obj.data;
                        $("#syllabus_view").html(ob.syllabus_name);
                        $("#subject_view").html(ob.subjectname);
                        $("#module_view").html(ob.subject_name);
                        $("#content_view").html(ob.module_content);
                    } else {
                       $.toaster({priority:'warning',title:'Warning',message:'Invalid data'}); 
                         $('#show').modal('toggle');
                    }
                    $(".loader").hide();
                }
            });
    });        
    
    
    //show modules in add mapping
    $("#subject").change(function(){
       var subject_id= $(this).val();
       // alert(subject_id);
        if(subject_id !=""){
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_modules_by_subject_id',
                type: 'POST',
                data: {
                    parent_subject: subject_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#modulesname").html(response);
                    loadparentmodule();
                    $(".loader").hide();
                }
            });
              
    }
    });
    //show module content if the same module is already added under the same subject
    $("#modulesname").change(function(){
       var module= $(this).val();
       var subject= $("#subject").val();
        if(module !="" && subject!=""){
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_moduleContent',
                type: 'POST',
                data: {
                    module_master_id: module,
                    subject_master_id: subject,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var obj=JSON.parse(response);
                  if(obj['data'] != false )
                      {
                          CKEDITOR.instances['modulecontent'].setData(obj['data']); 
                      }
                    $(".loader").hide();
                }
            });
              
    }
    });
    
    $("#editsubject").change(function(){
       var subject_id= $(this).val();
       // alert(subject_id);
        if(subject_id !=""){
             $("#editmodulesname").html("");
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_modules_by_subject_id',
                type: 'POST',
                data: {
                    parent_subject: subject_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#editmodulesname").html(response);
                    loadparentmodule();
                    $(".loader").hide();
                }
            });
              
    }
    });

    $("#edit_subject").change(function(){
        $("#edit_modules").html("");

    });
    //show modules edit mapping
    $("#show_modules").click(function(){
       var subject_id= $("#edit_subject").val();
       var edit_course_id= $("#edit_course").val();
        if(subject_id !="" && edit_course_id!=""){
             $(".loader").show();
             $(".modules").html("");
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allmodules_by_subjectid_edit',
                type: 'POST',
                data: {
                    parent_subject: subject_id,
                    course_master_id: edit_course_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $(".modules").html(response);
                   $(".loader").hide();
                }
            });
              
    }
    });
    
    
     //show modules edit mapping-add
    function loadparentmodule() { 
       var syllabus_master_id= $("#syllabus_master_id").val();
       var subject= $("#subject").val();
        if(subject !="" && syllabus_master_id!=""){
             $(".loader").show();
             $("#parent_module_master_id").html("");
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_parent_module_bysyllabus',
                type: 'POST',
                data: {
                    syllabus_master_id: syllabus_master_id,
                    subject: subject,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#parent_module_master_id").html(response);
                   $(".loader").hide();
                }
            });
              
    }
    }
      //show modules edit mapping-edit
    function edit_loadparentmodule() { 
       var syllabus_master_id= $("#editsyllabus_master_id").val();
       var subject= $("#editsubject").val();
        if(subject !="" && syllabus_master_id!=""){
             $(".loader").show();
             $("#editparent_module_master_id").html("");
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_parent_module_bysyllabus',
                type: 'POST',
                data: {
                    syllabus_master_id: syllabus_master_id,
                    subject: subject,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#editparent_module_master_id").html(response);
                   $(".loader").hide();
                }
            });
              
    }
    }
    
    
  var validation = 0;
 $("form#add_mapping_form").validate({
        rules: {
            course_master_id: {
                required: true
            },
            subject_master_id: {
                required: true

            },
              syllabus_master_id: {
                  required: true

              },
            // file_name: {
            //       required: true

            //   },
            modules: {
                  required: true

              }
        },
        messages: {
            course_master_id: "Please Choose a Course",
            subject_master_id: "Please Choose a Subject",
            syllabus_master_id: "Please Choose a Syllabus",
            // file_name: "Please Upload Syllabus",
            modules: "Please Choose Modules"
        },

        submitHandler: function(form) {
               validation = 1;
           

        }


    });
    $("form#add_mapping_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
      
       
         //debugger;
            if (validation == 1) {
                 $(".loader").show();
                         $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/subject_syllabus_add_mapping',
                                    type: 'POST',
                                    data: new FormData(this),
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        //validation = 0;
                                        
                                        var obj=JSON.parse(response);
                                        if (obj['res'] == true) {
                                            $('#add_mapping_form').each(function(){
                                                this.reset();
                                                    });
                                            CKEDITOR.instances['editmodulecontent'].setData("");
                                             $('#add_mapping').modal('toggle');
                                                
                                            
                                            $("#mapping_data").append(obj['html']);
                                            $.toaster({priority:'success',title:'Success',message:'Succesfully Added'});
                                                
                                        }
                                        else if(obj['res']  == "2")
                                        {
                                           //accept only pdf
                                             //alert("Upload only pdf files"); 
                                             $.toaster({priority:'warning',title:'INVALID',message:'Upload only pdf files'});

                                        }
                                        else if(obj['res']  == 3)
                                            {
                                                $('#add_mapping').modal('toggle');
                                                $( '#add_mapping_form' ).each(function(){
                                                this.reset();
                                                    });
                                                 $.toaster({priority:'warning',title:'INVALID',message:'Already Exist'});
                                            }
                                        else{
                                              $.toaster({priority:'danger',title:'ERROR',message:'Error Occured'});
                                        }
                                        $(".loader").hide();
                                    }
                                });
                 
            }
        });

function delete_mapping(id) {
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

                        $.post('<?php echo base_url();?>backoffice/Courses/delete_subject_syllabus_mapping/', {
                            syllabus_master_detail_id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                var obj=JSON.parse(data);
                            if (obj.st == "1") 
                            { $.toaster({priority:'success',title:'Success',message:obj.msg});
                                  $("#row_"+id).remove();
                            }
                            else if (obj.st == "2") 
                            {
                             $.toaster({priority:'warning',title:'Invalid',message:obj.msg});   
                            }
                            else if (obj.st == "0") 
                            {
                              $.toaster({priority:'error',title:'Invalid',message:obj.msg});  
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
    function get_mappingdata(id)
    {
       $(".loader").show();
        $("#edit_modules").html("");
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_subjectSyllabus_mapping_byid/' + id,
            type: 'POST',
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                 $(".loader").hide();
                var obj=JSON.parse(response); 
                $("#editsyllabus_master_detail_id").val(obj.syllabus_master_detail_id);
                $("#editsyllabus_master_id").val(obj.syllabus_master_id);
                $("#editsubject").val(obj.subject_master_id);
                $("#editmodulesname").html(obj.module);
                $("#editparent_module_master_id").html(obj.parent);//module_content
                CKEDITOR.instances['editmodulecontent'].setData(obj.module_content);
                
                if(obj.exist != 0)
                    {
                       
                        $("#save_div").html('<b>This module is already scheduled</b>');
                         $("#show_div").css("display","none");
                    }
                else if(obj.exist == 0){
                    
                 $("#show_div").css("display","block");
                    $("#save_div").html("");
                }
                 $('#edit_mapping').modal({
                        show: true
                        });
            }
          });
        
    }
    
    
   /* edit mapping*/
      var edit_validation = 0;
 $("form#edit_mapping_form").validate({
        rules: {
            editsyllabus_master_id: {
                required: true
            },
            editsubject: {
                required: true

            },
              editmodulesname: {
                  required: true

              },
            // file_name: {
            //       required: false

            //   }
        },
        messages: {
            editsyllabus_master_id: "Please select a syllabus",
            editsubject: "Please select a Subject",
            syllabus_master_id: "Please select module",
          //  file_name: "Please Upload Syllabus"
        },

        submitHandler: function(form) {
               edit_validation = 1;
           

        }


    });
    
    //edit mapping form submit
    
     $("form#edit_mapping_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
      
       for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            } 
         //debugger;
            if (edit_validation == 1) {
                 $(".loader").show();
                         $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/syllabus_module_mapping_edit',
                                    type: 'POST',
                                    data: new FormData(this),
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                         
                            var obj=JSON.parse(response); 
                              if(obj.status==1) {
                               $.toaster({priority:'success',title:'Success',message:obj.message});
                                  $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_syllabus_subject_map',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        $('#edit_mapping').modal('toggle');    
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
                                $(".loader").hide();
                              } else {
                             $(".loader").hide();
                            $.toaster({priority:'warning',title:'INVALID',message:obj.message});       
                              }
                        
                                    }
                                });
                
            }
        });

    /*module scipt in add mapping*/
    $(document).on("change", "input[class='check']", function() {
            if ($(this).is(':checked')) {
                var sub_category = $(this).attr("value");
                var listid = $(this).attr("name");
                $(".selected_service").append("<li id='" + listid + "'><a href='#'class='remove_category'><i class='fa fa-remove '></i></a> " + listid + " <input type='hidden' name='subject_modules[]'  value='" + sub_category + "'/></li>");
             
            } else {
                var sub_category_remove = $(this).attr("name");
                $("#" + sub_category_remove).remove();
            }
        $(".remove_category").click(function() {
                $(this).parent('li').remove();

            });
        });
    
    //on click close of add modal
    $(".add_modal_close").click(function(){
            $(".selected_service").html("");
            $(".modules").html("");
       $('#add_mapping_form').each(function(){
            this.reset();
        });
    });
    
    
    // SYLLABUS MAPPING ACTION
    var add_syllabusvalidation = 0
    $("form#add_syllabus_mapping_form").validate({
        rules: {
            syllabus_master_id: {
                required: true
            },
            subject_master_id: {
                required: true

            },
            module_master_id: {
                  required: true

            },
            modulecontent: {
                  required: false
            }
        },
        messages: {
            syllabus_master_id: "Please select a syllabus",
            subject_master_id: "Please select a subject",
            module_master_id: "Please select module",
            modulecontent: "Please enter modules content"
        },

        submitHandler: function(form) {
            add_syllabusvalidation = 1;
        }


    });

    $("form#add_syllabus_mapping_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
            //  $(".loader").show();
             if(add_syllabusvalidation == 1){
                for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            } 
             $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/syllabus_module_mapping',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) { 
                    var obj=JSON.parse(response);
                    add_syllabusvalidation == 0; 
                    if(obj.status==1) {
                        $.toaster({priority:'success',title:'Success',message:obj.message});
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Courses/load_syllabus_subject_map',
                            type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {
                                $('#add_mapping').modal('toggle');    
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
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                        $(".loader").hide();
                    } else {
                        $(".loader").hide();
                        $.toaster({priority:'warning',title:'INVALID',message:obj.message});       
                    }
                }
            });
        }
    });    

</script>
