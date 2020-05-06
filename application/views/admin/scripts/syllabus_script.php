<script>
//edit syllabus and validation
    var edit_validation = 0;
    $("form#edit_syllabus_form").validate({
        rules: {
            title: {
                required: true,
                remote: {    
                                    url: '<?php echo base_url();?>backoffice/Courses/edit_check_syllabus',
                                    type: 'POST',
                                    data: {
                                            syllabus_name: function() {
                                            return $("#edit_title").val();
                                            },
											syllabus_id: function() {
                                            return $("#edit_syllabus_id").val();
                                            },
                                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                          }
                            }
            }
            // file_name: {
            //     required: true

            // }
        },
        messages: {
            title: {
                required:"Please Enter a Syllabus Name",
                remote:"This syllabus already exist"
            }
            // file_name: "Please upload Syllabus",
        },

        submitHandler: function(form) {
            $(".loader").show();

            edit_validation = 1;
        }
    });
    $("form#edit_syllabus_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        // debugger;
        if (edit_validation == 1) {
            var edit_syllabus_id= $("#edit_syllabus_id").val();
            var edit_title= $("#edit_title").val();
            var edit_description= $("#edit_description").val();
            var files= $("#files").val();
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/edit_syllabus',
                type: "post",
                data: new FormData(this),
                beforeSend: function(data) {
                    // Show image container
                },
                success: function(data) {
                   var obj=JSON.parse(data);
                //    alert(obj['res']);
                    if (obj['res'] == "1"){
                        $('#edit_syllabus').modal('toggle');
                        $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Courses/load_upload_academic_syllabus_ajax',
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
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        }); 
                    }else if(obj['res'] == "2" ){
                        $.toaster({priority:'danger',title:'INVALID',message:obj['msg']});
                    }else if(obj['res'] == "0" ){
                        $.toaster({priority:'danger',title:'Error',message:'Data Already Exist'});
                    }
                    else if(obj['res'] == "3" )
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Invalid Request'});
                         
                    }
                    else if(obj['res'] == "4" )
                    {
                        $.toaster({priority:'danger',title:'Error',message:'No file exist'});
                         
                    }
                    $(".loader").hide();
                },
                complete: function(data) {
                    // Hide image container
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });

    //add syllabus and validation
    var validation = 0;
    $("form#add_syllabus_form").validate({
        rules: {
            title: {
                required: true,
                 remote: {    
                                    url: '<?php echo base_url();?>backoffice/Courses/check_syllabus',
                                    type: 'POST',
                                    data: {
                                            syllabus_name: function() {
                                            return $("#title").val();
                                            },
                                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                          }
                            }
            },
            file_name: {
                required: true,
                //extension: "pdf|doc|docx"

            }
        },
        messages: {
            title:{
               required:"Please Enter a Syllabus Name", 
               remote:"This syllabus already exist", 
            },
            
            file_name: {
                required:"Please upload Syllabus",
                //extension:"select valid input file format"
            }
        },

        submitHandler: function(form) {
            $(".loader").show();
            validation = 1;
        }


    });

    $("form#add_syllabus_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        //var formData = new FormData(this);
        // debugger;
        if (validation == 1) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/upload_academic_syllabus',
                type: "post",
                data: new FormData(this), //$("#addingtaskdetailsform").serialize(),
                beforeSend: function(data) {
                    // Show image containers

                },
                success: function(data) {
                    var obj=JSON.parse(data);
                    if (obj['st'] == "1")
                    {
                         $('#myModal').modal('toggle');
                         $('#add_syllabus_form').each(function(){this.reset(); });
                         $.toaster({priority:'success',title:'Success',message:'Syllabus Added Successfully'});

                    //$("#syllabus_data").append(obj['html']);

                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_upload_academic_syllabus_ajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });    
                }
                    else if(obj['st'] == "3" )
                    {
                        $.toaster({priority:'danger',title:'INVALID',message:obj['msg']});

                    }
                    else if(obj['st'] == "2" )
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Data Already Exist'});
                         
                    }
                    
                    $(".loader").hide();
                  
                },
                complete: function(data) {
                    // Hide image container

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    });

    function delete_syllabus(id) {
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

                        $.post('<?php echo base_url();?>backoffice/Courses/delete_syllabus/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if (obj.status == 1) {
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                                  $("#row_"+id).remove();
                                   $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_upload_academic_syllabus_ajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                            } else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message}); 
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
 
    function get_syllabusdata(id)
    {
        // var files= $("#files").val();
        $(".loader").show();

         $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_syllabus_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#edit_syllabus_id").val(obj.syllabus_id);
                    $("#edit_title").val(obj.syllabus_name);
                    $("#edit_description").val(obj.syllabus_description);
                    $("#edit_filename").html(obj.file_name);
                    $("#files").val(obj.file_name);
                     $('#edit_syllabus').modal({
                        show: true
                        });

                        $(".loader").hide();
                }
            });
    }

    function readURL(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size>5000000){
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size.' });
                }
                else{
                    var reader = new FileReader();
                reader.onload = function (e) {
                   $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(input.files[0]);
                }
                
            }
        }

        function editreadURL(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size>5000000){
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'The file you are attempting to upload is larger than the permitted size.' });
                }
                else{
                    var reader = new FileReader();
                reader.onload = function (e) {
                   $('#blah').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(input.files[0]);
                }
                
            }
        }
//         $(function () {
//     $("#file").change(function () { 
     
//         $("#dvPreview").html("");
//         var regex = /^([a-zA-Z0-9\s_\\.\-:() ])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
//         if (regex.test($(this).val().toLowerCase())) 
//         {
//             if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) { 
//                 $("#dvPreview").show();
//                 $("#dvPreview")[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this).val();
//             }
//             else {
//                 if (typeof (FileReader) != "undefined") {
//                     $("#dvPreview").show();
//                     $("#dvPreview").append("<img />");
//                     var reader = new FileReader();
//                     reader.onload = function (e) {
//                         $("#dvPreview img").attr("src", e.target.result);
//                     }
//                     reader.readAsDataURL($(this)[0].files[0]);
//                 } else {
//                     alert("This browser does not support FileReader.");
//                 }
//             }
//         } else {
//             $.toaster({ priority : 'warning', title : 'Notice', message : 'Unsupported file format' });

//             // alert("Please upload a valid image file.");
//         }
//     });
// });
       

</script>
