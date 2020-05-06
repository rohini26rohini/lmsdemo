<script>
$(document).ready(function(){
    $("form#add_result_form").validate({       
        rules: {
            school_id: {required: true},
            notification_id: {required: true}
        },
        messages: {
            school_id: {required: "Please Choose School"},
            notification_id: {required: "Please Choose Exam"}
        },
        submitHandler: function(form)
        {
            validation=1;
        }
    });
    $("form#add_result_form").submit(function(e) { 
        e.preventDefault();
        if (validation == 1)
        {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/result_add',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    var obj=JSON.parse(data);
                   if (obj['st'] == "1") {
                        $('#add_result').modal('toggle');
                        $('#add_result_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : obj['msg'] });
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Content/load_result_ajax',
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
                    } else if (obj['st'] ==0) {
                            
                            $.toaster({ priority : 'danger', title : 'Invalid Request', message : obj['msg']});
                           
                        }else if(obj['st'] == "2"){
                            $.toaster({ priority : 'warning', title : 'Error', message : obj['msg']});
                        
                        }else if(obj['st'] == "3"){
                            $.toaster({ priority : 'warning', title : 'Error', message : obj['msg']});
                        
                        }
                        else{
                             $.toaster({ priority : 'danger', title : 'Invalid Request', message : obj['msg'] });
                        }
                    $(".loader").hide();
                }
            });
        }
    });

//edit result and validation
    var edit_validation = 0;
    $("form#edit_result_form").validate({
        rules: {
            school_id: {required: true},
            notification_id: {required: true},
            hall_tkt: {required: true},
            name: {required: true},
            rank: {required: true},
            city_id: {required: true}
        },
        messages: {
            school_id: {required: "Please Choose School"},
            notification_id: {required: "Please Choose Exam"},
            hall_tkt: {required: "Please Enter Hall Ticket Number"},
            name: {required: "Please Enter Name"},
            rank: {required: "Please Enter Rank"},
            city_id: {required: "Please Enter Location"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            edit_validation = 1;
        }
    });
    $("form#edit_result_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        // debugger;
        if (edit_validation == 1) {
            var edit_result_id= $("#edit_result_id").val();
            var edit_hall_tkt= $("#edit_hall_tkt").val();
            var edit_name= $("#edit_name").val();
            var edit_rank= $("#edit_rank").val();
            var edit_city_id= $("#edit_city_id").val();
            var files= $("#resultfiles").val();
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/result_edit',
                type: "post",
                data: new FormData(this),
                beforeSend: function(data) {
                    // Show image container
                },
                success: function(data) {
                   var obj=JSON.parse(data);
                //    alert(obj['res']);
                    if (obj['res'] == "1"){
                        $('#edit_result').modal('toggle');
                        $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Content/load_result_ajax',
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
                    }else if(obj['res'] == "2" ){
                        $.toaster({priority:'danger',title:'INVALID',message:obj['msg']});
                    }
                    // else if(obj['res'] == "0" ){
                    //     $.toaster({priority:'danger',title:'Error',message:'Data Already Exist'});
                    // }
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

    createNewTextBox();
    $('#addButtonNewId').tooltipster();
    $('.minusButton').tooltipster();
    $('#add_result_form input,select,textarea').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        positionTracker: true,
        contentAsHTML: true,
        interactive: true,
        interactiveTolerance: 350,
        theme: 'tooltipster-punk',
        position: 'bottom',
    });

    $("#add_result_form").validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        },
    });
    validation();
    //start new textbox dynamic
    $( "#new_textbox" ).on( "click", ".addButtonNewId", function() {
        $('#add_result_form input,select,textarea').tooltipster({
            trigger: 'custom',
            onlyOne: false,
            positionTracker: true,
            contentAsHTML: true,
            interactive: true,
            interactiveTolerance: 350,
            theme: 'tooltipster-punk',
            position: 'bottom',
        });
        $('.minusButton').tooltipster();
    });
    //end new textbox dynamic

    $('#edit_addButtonNewId').tooltipster();
    $('.minusButton').tooltipster();
    $('#add_result_form input,select,textarea').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        positionTracker: true,
        contentAsHTML: true,
        interactive: true,
        interactiveTolerance: 350,
        theme: 'tooltipster-punk',
        position: 'bottom',
    });

    $("#edit_result_form").validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        },
    });
    //start new edit textbox dynamic
    $( "#edit_new_textbox" ).on( "click", ".addButtonNewId", function() {
        // edit_createNewTextBox();
        $('#edit_result_form input,select,textarea').tooltipster({
            trigger: 'custom',
            onlyOne: false,
            positionTracker: true,
            contentAsHTML: true,
            interactive: true,
            interactiveTolerance: 350,
            theme: 'tooltipster-punk',
            position: 'bottom',
        });
        $('.minusButton').tooltipster();
    });
    //end new edit textbox dynamic
});

function delete_result(id) {
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
                                    url: '<?php echo base_url();?>backoffice/Content/result_delete',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_result_ajax',
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
                                    }
                                   });
                                             $.toaster({priority:'success',title:'Success',message:obj.message});
                                           
                                           
                                        } else {
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

function get_details(id){
    $("#stop_id").val(id);
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Content/view_result_by_id/'+id,
        type: 'POST',
        data:{stop_id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
                $("#view_route_number").html(obj.route_details.route_number);
                $("#view_route_name").html(obj.route_details.route_name);
                $("#view_vehicle_number").html(obj.route_details.vehicle_number);
                $("#view_driver").html(obj.route_details.name);
                $("#view_route_description").html(obj.route_details.description);
                var table = "<div class= 'table-responsive table_language'><table class='table table_followup table-sm table-bordered table-striped'>";
                table += "<tr><th>Sl. No.</th><th>Stop Name</th><th>Distance (Km)</th><th>Route Fare (INR)</th></tr>";
                var j = 0;
                $.each(obj.stop_details, function (i, v) {
                    j++;
                    table += "<tr><td>"+j+"</td><td>"+v.name+"</td><td>"+v.distance+"</td><td>"+v.route_fare+"</td></tr>";
                });
                table += "<table></div>";
                $("#stop_view").html(table);
            $('#view_result').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}

function get_resultdata(id){
    $("#edit_result_id").val(id);
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Content/get_result_by_id/'+id,
        type: 'POST',
        data:{edit_result_id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#edit_result_id").val(obj.discount_array.result_id);
            $("#edit_school_id").val(obj.discount_array.school_id);
            $("#edit_notification_id").val(obj.discount_array.notification_id);
            $("#edit_input").val(obj.discount_array.hall_tkt);
            var img =obj.discount_array.file_name;
            var table = '<div class = "table-responsive table_language"><table class="table table-bordered table-striped table-sm" id="edit_no-more-tables">';
            table += '<thead><tr><th>Hall Ticket Number<span class="req redbold">*</span></th><th>Name<span class="req redbold">*</span></th><th>Rank<span class="req redbold">*</span></th><th>Upload Image<span class="req redbold">*</span></th><th>Location<span class="req redbold">*</span></th></tr></thead><tbody>';
            table += '<tr id="edit_stop_tr" class="tr">';
            table += '<td> <div class="form-group form_zero">';
            table += '<input list="edit_hall_tkt" id="edit_input" class="exam form-control " onchange="get_detail()" autocomplete="off" name="hall_tkt" value="'+obj.discount_array.hall_tkt+'">';
            table += '<datalist class="datas" id="edit_hall_tkt"  >';
            table += '<option value="'+obj.discount_array.hall_tkt+'">';
            table += '<?php if(!empty($hallticketArr)){ foreach($hallticketArr as $row){  ?>';
            table += ' <option id="<?php echo $row['examlist_id']; ?>" value="<?php echo $row['hall_tkt']; ?>"/>';
            table += '<?php } } ?>';
            table += '</datalist>';
            table += '</div>';
            table += '</td>';
            table += '<td><input type="text" id="edit_name" value="'+obj.discount_array.name+'" name="name" placeholder="Name" class="form-control name filter_class" value=""></td>';
            table += '<td><input type="text" id="edit_rank" value="'+obj.discount_array.rank+'"  name="rank" placeholder="Rank" class="form-control rank"></td>';
            table += '<td data-title="Upload Image" class="Upimage"><div class="imgViewTable imageViewAbs" id="edit_imgViewTable" ><img  src="<?php echo base_url();?>/'+obj.discount_array.file_name+'"></div>';
            table += '<input class="form-control" type="hidden" name="files" value="'+obj.discount_array.file_name+'" id="edit_files" >';
            table += '<input type="file"  class="image form-control filter_class"  name="file_name"  id="edit_file"  value="" placeholder="Upload Image" /></td>';
            table += '<td><input type="text" id="edit_city_id" value="'+obj.discount_array.city_id+'"  name="city_id" placeholder="Location" class="form-control city_id filter_class"></td>';
            table += '</tr>';
            table += '</tbody><table></div>';

            $("#hall_tkt_edit").html(table);
            edit_get_exams(obj.discount_array.notification_id);
            $('#edit_result').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}
/**
* This function will add dynamic textboxes to adding vessels
*/
var counter = 1;
function createNewTextBox() {
    var counter = $("#counter").val();
    counter++;
    $("#counter").val(counter);
    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'new_textbox' + counter);
    var markup = '';
    markup += '<tr id="stop_tr_' + counter + '" class="tr">';
    markup += '<td> <div class="form-group form_zero"><input id="input_' + counter + '" class=" hall_tkt exam form-control " onchange="get_detail(' + counter + ')" list="hall_tkt_' + counter + '" name="hall_tkt[' + counter + ']"><datalist class="datas"   id="hall_tkt_' + counter + '" ><option value=""><?php if(!empty($hallticketArr)){ foreach($hallticketArr as $row){  ?><option id="<?php echo $row['examlist_id']; ?>" value="<?php echo $row['hall_tkt']; ?>"/><?php } } ?></datalist></div></td>';
    markup += '<td><input type="text" id="name_' + counter + '" name="name[' + counter + ']" placeholder="Name" class="form-control name filter_class" value=""></td>';
    markup += '<td><input type="text"  name="rank[' + counter + ']" placeholder="Rank" class="form-control rank"></td>';
    markup += '<td data-title="Upload Image" class="resultBoxs"><div class="imgViewTable " id="imgViewTable_' + counter + '"></div>';
    markup += '<input class="form-control" type="hidden" name="files[' + counter + ']" id="files_' + counter + '">';
    markup += '<input type="file"  class="image form-control filter_class"  name="file_name[' + counter + ']" id="file_name_' + counter + '"  value="" placeholder="Upload Image" /><p style="font-size:10px"> ( Only jpeg , jpg & png formats supported. Maximum size is 5 MB)</p></td>';
    markup += '<td><input type="text" id="city_id_' + counter + '"  name="city_id[' + counter + ']" placeholder="Location" class="form-control city_id filter_class"></td>';
    markup += '<td data-title=""><button  class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="removeButton' + counter + '" onclick="removeTextbox(' + counter + ');" title="Click here to remove the stop" ><i class="fa fa-remove"></i></button></td>';
    markup += '</tr>';
    $('#no-more-tables > tbody').append(markup);
    $('#imgViewTable_'+ counter).hide();
    counter++;
    validation();
}

/*
* This function will remove the dynamic textbox
*/
function removeTextbox(counter_value) {
    $('#stop_tr_' + counter_value).remove();
    return false;
}

var editcounter = 1;
function edit_createNewTextBox() {
    var counter = $("#edit_counter").val();
    counter++;
    $("#edit_counter").val(counter);
    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'edit_new_textbox' + editcounter);
    var markup = '';
    markup += '<tr id="edit_stop_tr_' + editcounter + '" class="tr">';
    markup += '<td> <div class="form-group form_zero"><input id="edit_input_' + editcounter + '" class=" hall_tkt exam form-control " onchange="get_detail(' + editcounter + ')" list="hall_tkt_' + editcounter + '" name="hall_tkt[' + editcounter + ']"><datalist class="datas"   id="edit_hall_tkt_' + editcounter + '" ><option value=""><?php if(!empty($hallticketArr)){ foreach($hallticketArr as $row){  ?><option id="<?php echo $row['examlist_id']; ?>" value="<?php echo $row['hall_tkt']; ?>"/><?php } } ?></datalist></div></td>';
    markup += '<td><input type="text" id="edit_name_' + editcounter + '" name="name[' + editcounter + ']" placeholder="Name" class="form-control name filter_class" value=""></td>';
    markup += '<td><input type="text" id="edit_rank"  name="rank[' + editcounter + ']" placeholder="Rank" class="form-control rank"></td>';
    markup += '<td data-title="Upload Image" class="resultBoxs"><span class="req redbold">*</span><div class="imgViewTable" id="edit_imgViewTable" ></div>';
    markup += '<input class="form-control" type="hidden" name="files[' + editcounter + ']" id="edit_files_' + editcounter + '">';
    markup += '<input type="file"  class="image form-control filter_class"  name="file_name[' + editcounter + ']" id="edit_file_' + editcounter + '"  value="" placeholder="Upload Image" /><p> ( Only jpeg , jpg & png formats supported. Maximum size is 5 MB)</p></td>';
    markup += '<td><input type="text" id="edit_city_id_' + editcounter + '"  name="city_id[' + editcounter + ']" placeholder="Location" class="form-control city_id filter_class"></td>';
    markup += '</tr>';
    $('#edit_no-more-tables > tbody').append(markup);
    editcounter++;
}
/*
* This function will remove the dynamic textbox
*/
function edit_removeTextbox(counter_value) {
    $('#edit_stop_tr_' + counter_value).remove();
    return false;
}

function deletefunction(stop_id) {
    var remove_id = $('#' + stop_id).val();
    $('#stop_tr_' + remove_id).remove();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>backoffice/Content/delete_stop',
        data:{stop_id:stop_id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(result) {
            if (result == 1) {
            } else {
                alert('Oops! Something went wrong')
            }
        },

    });
}

function validation() {
    $('.name').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "Please Enter Name"
            }
        });
    });
    $('.rank').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: " Please Enter Rank"
            }
        });
    });
    $('.hall_tkt').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: " Please Enter Hall Ticket Number"
            }
        });
    });
    $('.image ').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: " Please upload a file"
            }
        });
    });
    $('.city_id  ').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "Please Enter a Location"
            }
        });
    });
}

function edit_get_exams(val){
    // alert(val);
     $("#edit_notification_id").html('');
    
    $(".loader").show();
    var edit_school_id = $('#edit_school_id').val();
    // var not = $('#edit_notification_id').val();

    // alert(not);
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Commoncontroller/edit_get_all_exams', 
        type: 'POST',
        data: {edit_school_id:edit_school_id,selected:val,
        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response)
        {
            $(".loader").hide();
            if(response!='') {
            $("#edit_notification_id").html(response);
            
            } else {
            }
        }
    });
}

function get_exams(){
    $("#notification_id").html('');
    $(".loader").show();
    var school_id = $('#school_id').val();
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Commoncontroller/get_all_exams', 
        type: 'POST',
        data: {school_id:school_id,selected:0,
        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response)
        {
            $(".loader").hide();
            if(response!='') {
            $("#notification_id").html(response);
            } else {
            }
        }
    });
}
    
function get_detail(stop_id){
    var get_data = $("#hall_tkt_" + stop_id + " option[value='" + $('#input_'+ stop_id).val() + "']").attr('id');
    if(get_data!=undefined){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>backoffice/Content/fetch/'+get_data,
            data:{hall_ticket_id:get_data,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(data) {
                var obj = JSON.parse(data);
                if(obj.name==''){
                    $('#imgViewTable_'+ stop_id).hide();
                    $('#files_'+ stop_id).hide();
                }else{
                    $('#imgViewTable_'+ stop_id).show();
                    $('#file_name_'+ stop_id).hide();
                    $('#files_'+ stop_id).show();
                    $('#name_'+ stop_id).val(obj.name);
                }
                $('#name_'+ stop_id).val(obj.name);
                $('#city_id_'+ stop_id).val(obj.city_name);
                if(obj.student_image==''){
                    $('#imgViewTable_'+ stop_id).hide();
                    $('#files_'+ stop_id).hide();
                }else{
                    $('#imgViewTable_'+ stop_id).show();
                    $('#file_name_'+ stop_id).hide();
                    $('#files_'+ stop_id).show();
                    // if(obj.student_image==''){
                        // $('#imgViewTable_'+ stop_id).html('<img  src="<?php echo base_url() ?>direction/assets/images/profile_img.png">');
                    // }else{
                        $('#imgViewTable_'+ stop_id).html('<img  src="<?php echo base_url() ?>' + obj.student_image + '">');
                    // }
                }
            },
        });
    }
}
// uploads/results/student_Kiran_5cd11a270dea9.jpg
function delete_result(id) {
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
                            url: '<?php echo base_url();?>backoffice/Content/result_delete',
                            type: 'POST',
                            data: {
                                id: id,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            },
                            success: function(response) {
                                var obj = JSON.parse(response);
                                if (obj.status == 1) {
                                    $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Content/load_result_ajax',
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
                                        }
                                    });
                                    $.toaster({priority:'success',title:'Success',message:obj.message});
                                }else{
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
</script>
