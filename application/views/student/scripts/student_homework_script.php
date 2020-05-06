<script>
   
    //delete

     function delete_homework(id,homework_id)
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
                                    url: '<?php echo base_url();?>user/Student/delete_homework',
                                    type: 'POST',
                                    data: {
                                        edit_id: id,
                                        homework_id: homework_id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                           $('#row_' + id).remove(); 
                                            $('#edit').modal('toggle');
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
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
    
    var validation = 0;
    $("form#add_homework").validate({
        rules: {
            'file_name[]': {
                required: true
            }
        },
        messages: {
            'file_name[]': "Please Choose a file"
            
        },

        submitHandler: function(form) {
             var file=$("#file")[0].files;
              //alert(file);
            for(var i = 0; i<file.length; i++){
             if(file[i]){
                        var file_size = file[i].size/1024;
                // alert(file_size);
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file[i].name.split('.').pop().toLowerCase();
                 
                            if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                                $("#image_error").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                                validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            validation = 1;
                        }
                        else{
                            $("#image_error").html('<br>One of the file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
        }
        }
    });
    
     $("form#add_homework").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        //var formData = new FormData(this);
        // debugger;
        if (validation == 1) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>user/Student/add_homework',
                type: "post",
                data: new FormData(this), 
                beforeSend: function(data) {
                     $(".loader").show();
                },
                success: function(data) {
                    var obj=JSON.parse(data); 
                    if(obj.st == 1)
                        {
                          $('#view').modal('toggle');
                          $.toaster({priority:'success',title:'Success',message:obj.message});
                             $("#homework_body").html("");
                             $.ajax({
                                url: '<?php echo base_url();?>user/Student/load_ajax_homework',
                                type: "post",
                                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                success: function(data) 
                                { 
                                    $("#homework_body").html(data);
                                }
                                });
                        }
                    else{
                         $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                    }
                   
                },
                complete: function(data) {
                    $(".loader").hide();

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    });
function add_homework(homework_id)
    {
        $("#tbody").html("");
        $("#assignment_no").val(homework_id);
        $("#homework_id").val(homework_id);
          $.ajax({
                    url: '<?php echo base_url();?>user/Student/get_homework_details',
                    type: "post",
                    data:{homework_id: homework_id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                    success: function(data) 
                    {
                       var obj=JSON.parse(data); 
                        
                            $("#assignment_no").val(homework_id);  
                            
                       
                        if(obj['st'] ==1)
                            {
                             var counter= obj['data'].length;   
                              $("#counter").val(counter);
                              $("#edit_remark").val(obj['data'][0].remarks);  
                              
                              $.each(obj['data'], function (index, value) {
                                     var i=index+1;
                                     $("#tbody").append('<tr id="row_'+i+'"> <td><input type="hidden" name="edit_id[]" value="'+value.id+'"/><input type="hidden" name="browse_'+value.id+'" value="'+value.file_name+'"/><input type="file" name="editfile_name_'+value.id+'"/><a target="_blank" href="<?php echo base_url(); ?>uploads/homeworks/'+value.file_name+'">view file</a></td><td class="text-center"><button type="button" class="btn btn-danger option_btn btn-sm btnRemoveModal" id="removeButton'+value.id+'" onclick="delete_homework('+value.id+','+value.homework_id+');" title="Click here to delete this file" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></td></tr>');
                                  
                                });
                                 $('#edit').modal({
                                    show: true
                            });
                                 
                                
                            }
                        else{
                           
                            $('#view').modal({
                                    show: true
                            });
                        }
                    }
                });
        
    }
    
    function view_homework(homework_id)
    {
        $("#show_uploaded_files").html('');
        $.ajax({
                    url: '<?php echo base_url();?>user/Student/get_homework_details',
                    type: "post",
                    data:{  homework_id: homework_id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                    success: function(data) 
                    {
                       var obj=JSON.parse(data); 
                        if(obj['st'] ==1)
                            {
                              
                              $("#show_date").html(obj['data'][0].submitted_date);  
                              $("#show_remarks").html(obj['data'][0].remarks);  
                              $.each(obj['data'], function (index, value) { 
                                  var i=index+1;
                              $("#show_uploaded_files").append('<li><a title="Click hre to view the file" target="_blank" href="<?php echo base_url(); ?>uploads/homeworks/'+value.file_name+'">File'+i+'</a></li>'); 
                               });
                                
                              
                                
                            }
                        
                    }
                });
        
       $('#show').modal({
        show: true
        });  
    }
    
    
  
   function addNew(){
       var counter=parseInt($("#counter").val()) + 1;
        var markup = '';
        markup += '<tr id="row_' + counter + '">';
        markup += '<td><input type="file" name="file_name[]"/></td>';

        markup += '<td data-title="" class="text-center"><button  class="btn btn-danger option_btn btn-sm btnRemoveModal" id="removeButton' + counter + '" onclick="remove(' + counter + ');" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></td>';
        markup += '</tr>';

        $('#tbody').append(markup);
        $("#counter").val(counter) ;
        counter++;

   }
    
   
    
    function remove(count)
    {
      $('#row_' + count).remove();
        return false;  
    }
    
    var edit_validation=0;
    $("form#edit_homework").validate({
        rules: {
            'file_name[]': {
                required: true
            }
        },
        messages: {
            'file_name[]': "Please Choose a file"
            
        },

        submitHandler: function(form) {
             edit_validation=1;
          }
        
    });
    
    $("form#edit_homework").submit(function(e) {
        e.preventDefault();
        if (edit_validation == 1) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>user/Student/edit_homework',
                type: "post",
                data: new FormData(this), 
                beforeSend: function(data) {
                     $(".loader").show();
                },
                success: function(data) {
                    var obj=JSON.parse(data); 
                    if(obj.st == 1)
                        {
                            $.toaster({priority:'success',title:'Success',message:obj.message});
                              $('#edit').modal('toggle');
                            $('#edit_homework').each(function(){this.reset()}); 
                            $("#homework_body").html("");
                             $.ajax({
                                url: '<?php echo base_url();?>user/Student/load_ajax_homework',
                                type: "post",
                                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                success: function(data) 
                                { 
                                    $("#homework_body").html(data);
                                }
                                });
                        }
                    else if(obj.st == 0)
                        {
                          $.toaster({priority:'danger',title:'Error',message:obj.message});  
                        } 
                    else if(obj.st == 2)
                        {
                          $.toaster({priority:'warning',title:'Error',message:obj.message});  
                        }
                   
                },
                complete: function(data) {
                    $(".loader").hide();

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    });
    
    
</script>
