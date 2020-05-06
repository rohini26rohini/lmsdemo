<script>
    var counter=2;
   function addNew(){
        var markup = '';

        markup += '<tr id="row_' + counter + '">';

        markup += '<td> <div class="form-group form_zero"><input type="text" id="description[' + counter + ']" class="description_validate form-control" placeholder="Description" name="description[]"/></div></td>';

        markup += '<td> <input type="file" class="file_validate form-control" id="file_name[' + counter + ']" name="file_name[]" required/><p>Upload .pdf,.docx files only  (Max Size:10MB).</p></td>';

        markup += '<td data-title=""><button  class="btn btn-danger option_btn" id="removeButton' + counter + '" onclick="remove(' + counter + ');" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></td>';
        markup += '</tr>';

        $('#purchasequote_table > tbody').append(markup);

        counter++;
        checkValidation();

   }

  function remove(count)
    {
        $('#row_' + count).remove();
//        checkValidation()
        return false;
    }
    $(document).ready(function(){
        checkValidation();
    });
   
 $(document).ready(function() { 
//edit syllabus and validation
    var edit_validation = 0;
    $("form#edit_form").validate({
        rules: {
            title: {
                required: true
            }
           
        },
        messages: {
            title: "Please Enter a Title"
            
        },

        submitHandler: function(form) {

            edit_validation = 1;
            checkeditValidation();
        }


    });
    $("form#edit_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        // debugger;
        if (edit_validation == 1) {

            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/edit_purchaseQuote',
                type: "post",
                data: new FormData(this),
                beforeSend: function(data) {
                    // Show image container
                    $(".loader").show();
                },
                success: function(data) {
                    edit_validation = 0;
                   var obj=JSON.parse(data);
                        if (obj['st'] == "1"){
                        $('#editModal').modal('toggle');
                        $.toaster({priority:'success',title:'Success',message:obj['msg']});
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_purchaseQuotes_Ajax',
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
                       
                    }
                    else if(obj['st'] == "0" )
                    {
                        $.toaster({priority:'danger',title:'Invalid',message:obj['msg']});
                    }
                    else if(obj['st'] == "2" )
                    {
                        $.toaster({priority:'warning',title:'Warning',message:obj['msg']});
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
     
      });

    //add purchase quote and validation
    var validation = 0;
    
    $("form#add_form").submit(function(e) {
       
        checkValidation();
    });
    
    $("#add_form").validate({
//        rules: {
//            title:"required",
//            'description[]':"required",
//            'file_name[]':"required",
//        },
//        messages: {
//            title: "Please enter a title",
//            'description[]': "Please enter a description",
//            'file_name[]': "Please select a file"
//        },
        submitHandler: function(form) {
            $(".loader").show();
            validation = 1;
            var description = $("input[name='description[]']").map(function(){return $(this).val();}).get();
            var file_name = $("input[name='file_name[]']").map(function(){return $(this).val();}).get();
            $.each(description,function(i,v){
                if($.trim(v)==''){
                    $.toaster({priority:'danger',title:'Error',message:'Some description fields are not entered'});
                    validation = 0;
                    $(".loader").hide();
                    return false;
                }
                if($.trim(file_name[i])==''){
                    $.toaster({priority:'danger',title:'Error',message:'Some files are not selected'});
                    validation = 0;
                    $(".loader").hide();
                    return false;
                }
            });
        }
    });

    $("form#add_form").submit(function(e) {
        e.preventDefault();
        if (validation == 1) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/add_purchase_quotes',
                type: "post",
                data: new FormData(this),
                success: function(data) {
                    validation = 0;
                    var obj=JSON.parse(data);
                    if (obj['st'] == 1){
                        $('#myModal').modal('toggle');
                        $('#add_form').each(function(){this.reset(); });
                        $.toaster({priority:'success',title:'Success',message:obj['msg']});
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Asset/load_purchaseQuotes_Ajax',
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
                    }
                    else if(obj['st'] == 0 ){
                        $.toaster({priority:'danger',title:'INVALID',message:obj['msg']});
                    }else if(obj['st'] == 2 ){
                        $.toaster({priority:'warning',title:'Error',message:obj['msg']});
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
    
    
    function checkValidation() {
        $('.title').rules('add', {
            required: true,
            messages: {
                required: "Please Enter the Quote Name"
            }
        });
        $('.description_validate').each(function() {
            $(this).rules('add', {
                required: true,
                messages: {
                    required: "Please Enter Description"
                }
            });
        });
        $('.file_validate').each(function() {
            $(this).rules('add', {
                required: true,
                messages: {
                    required: "Please Upload Quote File"
                }
            });
        });
    }
    
    function readURL(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size>10000000){
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
                if(input.files[0].size>10000000)
                {
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
    
    
    var edit_counter=1;
   function addNewrow(){
        
        var markup = '';

        markup += '<tr id="new_row_' + edit_counter + '">';

        markup += '<td> <div class="form-group form_zero"><input type="text" id="new_description[' + edit_counter + ']" class="edescriptions form-control" placeholder="Description" name="new_description[]" /></div></td>';

        markup += '<td> <input type="file" class="efile_upload form-control" id="file_name[' + edit_counter + ']" name="file_name[]" /><p>Upload .pdf,.docx files only  (Max Size:10MB).</p></td>';

        markup += '<td data-title=""><button  class="btn btn-danger option_btn" id="new_removeButton' + edit_counter + '" onclick="edit_newremove(' + edit_counter + ');" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></td>';
        markup += '</tr>';

        $('#edit_purchasequote_table > tbody').append(markup);

        edit_counter++;
        checkeditValidation();

   }

  function edit_newremove(count)
    {
        
        $('#new_row_' + count).remove();
        return false;
    }
function edit_remove(count,id)
    {
       
        var quote_id = id.replace('edit_removeButton','');
          
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
                                    url: '<?php echo base_url();?>backoffice/Asset/delete_Quote',
                                    type: 'POST',
                                    data: {
                                        id: quote_id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
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
        $('#edit_row_' + count).remove();
        return false;
    }
    
    function checkeditValidation()
    {
    $('.edescriptions').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "Please Enter Description"

            }
        });
    });
    $('.efile_upload').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "Please Upload Quote File",

            }
        });
    });
}

    function get_data(id){
        $('#edit_purchasequote_table > tbody').html("");
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Asset/get_purchaseQuote_byId',
            type: 'POST',
            data: { id : id, <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>' },
            success: function(response) {
                $(".loader").hide();
                var obj = JSON.parse(response);
                $("#edit_id").val(obj['data'][0].id);
                $("#edit_title").val(obj['data'][0].title);
                var readonly="";
                var disable="";
                var style="";
                $(".show_purchase").css('display', 'none');
                $("#add_moreDiv").css('display', 'block');
                $("#edit_orderno").val("");
                $("#edit_amount").val("");
                $("#edit_date").val("");
                if(obj['data'][0].purchase_status != "Draft"){
                    readonly="readonly"; 
                    disable="disabled"; 
                    style='style="display:none"';
                    $("#edit_title").prop('readonly', true);
                    $("#add_moreDiv").css('display', 'none');
                    $(".show_purchase").css('display', 'block');
                    if(obj['data'][0].purchase_status == "Completed"){
                       $("#edit_orderno").val(obj['data'][0].purchase_order_no); 
                       $("#edit_amount").val(obj['data'][0].amount); 
                       $("#edit_date").val(obj['data'][0].date_of_purchase); 
                    }
                }
                $.each(obj['data'], function(key,value) {
                    var markup = '';
                    if(value.description != null){
                        markup += '<tr id="edit_row_' + key + '">';
                        markup += '<td><input type="hidden"  name="edit_quote_id[]" value="'+value.quote_id+'"/> <input type="hidden" name="oldfile'+value.quote_id+'" value="'+value.quote_file+'"/> <div class="form-group form_zero"><input '+readonly+' type="text" id="edit_description[' + key + ']" class="descriptions form-control" placeholder="Description" name="editdescription'+value.quote_id+'" value="'+value.description+'" required/></div></td>';
                        markup += '<td> <input type="file" '+style+' class="file_upload form-control" id="edit_file_name[' + key + ']" name="editfile_name'+value.quote_id+'" /><a href="<?php echo base_url(); ?>'+value.quote_file+'" target="_blank">View Document</a><p>Upload .pdf,.docx files only  (Max Size:10MB).</p></td>';
                        markup += '<td data-title=""><button '+disable+' class="btn btn-danger option_btn" id="edit_removeButton' +value.quote_id+ '" onclick="edit_remove(' + key + ',this.id);" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></td>';
                        markup += '</tr>';
                    }
                    $('#edit_purchasequote_table > tbody').append(markup);
                });         
                $('#editModal').modal({ show: true  });
            }
       });  
    }
    
    function delete_quote(id)
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
                                    url: '<?php echo base_url();?>backoffice/Asset/delete_purchaseQuote',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_purchaseQuotes_Ajax',
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
    
     //view data
    function view_data(id)
    {
         $('#show_purchasequote_table > tbody').html("");
        $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/get_purchaseQuote_byId',
                type: 'POST',
                data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                success: function(response) 
                    {
                        // alert("don");
                    $(".loader").hide();
                    var obj = JSON.parse(response);
                       
                         $("#show_title").html(obj['data'][0].title);  
                        $("#id").val(obj['data'][0].id);
                         $.each(obj['data'], function(key,value) {
                            var  readonly="";
                             if(obj['data'][0].purchase_status == "Completed")
                            {
                                 readonly="disabled"; 
                            }
                            
                             var markup = '';
                             markup += '<tr>';
                             markup += '<td>'+value.description+'</td>';
                             markup += '<td><a href="<?php echo base_url(); ?>'+value.quote_file+'" target="_blank" title="Click here to view the document">View Document</a></td>';
                             markup += '<td><select '+readonly+' class="form-control tableSelect changeStatus" id="'+value.quote_id+'" name="status[]"><option value="">Select</option><option value="Approved">Approve</option><option value="Declined">Decline</option></select></td>';
                             markup += '</tr>';
                             $('#show_purchasequote_table > tbody').append(markup);
                              if(value.quote_status != "Draft")
                                 {
                                    $("#"+value.quote_id).val(value.quote_status);   
                                 }
                         });
                         $('#showModal').modal('show');
                                    
                                  
                    }
         });
    }
    
    // change status
         $(document).on('change','.changeStatus',function(){
            var value=$(this).val();
            var quote_id = $(this).attr("id");
            var id=$("#id").val();
             //if(value == "Approved"){
              $(".loader").show();
                $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/changeStatus_purchaseQuote',
                type: 'POST',
                data: {
                       id:id,
                       quote_status:value,
                       quote_id:quote_id,
                       <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                     },
               
                success: function(data) {
                     $(".loader").hide();
                   var obj=JSON.parse(data);
                    
                 
                    if (obj['st'] == "1"){
                      $.each(obj['data'], function(key,value) { 
                         $("#"+value.quote_id).val(value.quote_status); 
                      });
                        $('#showModal').modal('toggle');
                        $.toaster({priority:'success',title:'Success',message:obj['msg']});
                         $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/load_purchaseQuotes_Ajax',
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
                       
                    }
                    else if(obj['st'] == "0" )
                    {
                        $.toaster({priority:'danger',title:'Invalid',message:obj['msg']});
                    }
                    
                },
            });
            // }
         });

</script>
