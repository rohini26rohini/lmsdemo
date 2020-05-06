<script>
$(document).ready(function(){
    createNewTextBox();
    $('#addButtonNewId').tooltipster();
    $('.minusButton').tooltipster();
    $('#add_feedef_form input,select,textarea').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        positionTracker: true,
        contentAsHTML: true,
        interactive: true,
        interactiveTolerance: 350,
        theme: 'tooltipster-punk',
        position: 'bottom',
    });

    $("#add_feedef_form").validate({
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
        $('#add_feedef_form input,select,textarea').tooltipster({
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
    $('#edit_route_form input,select,textarea').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        positionTracker: true,
        contentAsHTML: true,
        interactive: true,
        interactiveTolerance: 350,
        theme: 'tooltipster-punk',
        position: 'bottom',
    });

    $("#edit_route_form").validate({
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
        $('#edit_route_form input,select,textarea').tooltipster({
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
var counter = 1;
var result1 = '';
function createNewTextBox() {
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>backoffice/Discount/get_payment_head',
        data:{counter:counter, <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(result) {
            // alert(result);
            result1 = result;
            var newTextBoxDiv = $(document.createElement('div')).attr("id", 'new_textbox' + counter);
            var markup = '';
            markup += '<tr id="stop_tr_' + counter + '" class="tr">';
            markup += '<td data-title="Stop Name">'+ result1 +'</td>';
            // markup += '<td><input type="text"  name="amount[' + counter + ']" placeholder="Amount" class="form-control amount numberswithdecimal"></td>';
            markup += '<td data-title=""><a href="javascript:void(0)" class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="removeButton' + counter + '" onclick="removeTextbox(' + counter + ');" title="Click here to remove fee head" ><i class="fa fa-remove"></i></a></td>';
            markup += '</tr>';
            $('#no-more-tables > tbody').append(markup);
            $("#counter").val(counter);
            counter++;
            // var counter = $("#counter").val();
            validation();
        }
    });
}
$("form#add_feedef_form").validate({       //route
        rules: {
            title: {required: true,
                remote: {
                    url: '<?php echo base_url();?>backoffice/Discount/titleCheck',
                    type: 'POST',
                    data: {
                        title: function() {
                          return $("#title").val();
                          },
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    }
                }
            },
            type:{required: true}
        },
        messages: {
            title: {required: "Please enter title",
                remote:"This title already exist"},
                type: {required: "Please select fee type"}    
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Discount/fee_def_add',
                type: 'POST',
                data: $("#add_feedef_form").serialize(),
                success: function(response) {
                    // alert(response);
                    $('#add_feedeff').modal('toggle');
                    $('#add_feedef_form' ).each(function(){
                        this.reset();
                    });
                    var obj = JSON.parse(response);
                    if(obj.st == 1){
                        $.toaster({ priority : 'success', title : 'Success', message :obj.msg });
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Discount/load_fee_def_ajax',
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
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                    }else if(obj.st == 0){
                        $.toaster({ priority : 'danger', title : 'Error', message :obj.msg  });
                    }
                    $(".loader").hide();
                }
            });
        }
    });
    function statusChange(id,st){
        // alert(id);
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
                        $.post('<?php echo base_url();?>backoffice/Discount/edit_fee_status/', {
                            id: id,st: st,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            $.toaster({priority:'success',title:'Success',message:'Status changed successfuly.!'});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Discount/load_fee_def_ajax',
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

function edit_feedef(id) {
   
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Discount/get_feedef_by_id',
        type: 'POST',
        data:{edit_id:id,
              <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            //  $('#no-more-tables > tbody').empty();
             $("#edit_title").val(obj.name);
             $("#edit_type").val(obj.type);
             $("#edit_fee_id").val(id);
            // var newTextBoxDiv = $(document.createElement('div')).attr("id", 'new_textbox' + obj.counter);
             $('#no-more-tables > tbody').html(obj.html);
            $('#edit_fee').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}


$("form#edit_fee_form").validate({       //route
        rules: {
            title: {required: true},
            type: {required: true}
        },
        messages: {
            title: {required: "Please enter title"},
            type: {required: "Please select fee type"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Discount/fee_def_edit',
                type: 'POST',
                data: $("#edit_fee_form").serialize(),
                success: function(response) {
                    // alert(response);
                    $('#edit_fee').modal('toggle');
                    $('#edit_fee_form' ).each(function(){
                        this.reset();
                    });
                    var obj = JSON.parse(response);
                    if(obj.st == 1){
                        $.toaster({ priority : 'success', title : 'Success', message :obj.msg });
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Discount/load_fee_def_ajax',
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
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                    }else if(obj.st == 0){
                        $.toaster({ priority : 'danger', title : 'Error', message :obj.msg  });
                    }
                    $(".loader").hide();
                }
            });
        }
    });


    function view_feedef(id) {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Discount/view_feedef_by_id',
            type: 'POST',
            data:{id:id,
                  <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                // alert(obj.name);
                 $('#no-more-tables > tbody').empty();
                 $("#view_title").html(obj.name);
                 $("#view_type").html(obj.type);
                 var table = "<div class= 'table-responsive table_language'><table class='table table_followup table-sm table-bordered table-striped'>";
                    table += "<tr><th>Fee Head</th></tr>";
                    table +=obj.html;
                    table += "<table></div>";
                    $("#defnition_view").html(table);
                $(".loader").hide();
            }
        });
    }
// register jQuery extension
jQuery.extend(jQuery.expr[':'], {
    focusable: function (el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});
function removeTextbox(counter_value) {
    
    $('tr#stop_tr_' + counter_value).remove();
    return true;
}

var editcounter = 1;
function edit_createNewTextBox() {
    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'edit_new_textbox' + editcounter);
    var markup = '';
    markup += '<tr id="edit_stop_tr_' + editcounter + '" class="tr">';
    markup += '<td><input type="text" class="stopname form-control" name="name[' + editcounter + ']" id="edit_name_' + editcounter + '"  value="" placeholder="Stop name"  onclick="getstopname(this.id)" /></td>';
    markup += '<td><input type="text" name="distance[' + editcounter + ']" placeholder="Distance" class="form-control distance numberswithdecimal"></td>';
    markup += '<td><input type="text"  name="route_fare[' + editcounter + ']" placeholder="Route Fare/Monthly" class="form-control route_fare numberswithdecimal"></td>';
    markup += '<td><input type="button" name="geo[' + editcounter + ']" id="geo_'+ editcounter + '" placeholder="Location" class="btn btn-info btn-sm exclude-status geo" value="Geo Map" data-toggle="modal" data-target="#myModal" onclick="initMap('+editcounter+');"></td>';
    markup += '<td><div class="form_zero"><input type="text" class="form-control numberswithdecimal latitude" name="lat[' + editcounter + ']" id="lat_' + editcounter + '" placeholder="Latitude" readonly="readonly"/></div></td><td><div class="form_zero"><input type="text" class="form-control numberswithdecimal longitude"  name="lon[' + editcounter + ']" id="lon_' + editcounter + '" placeholder="Longitude" readonly="readonly"/></div></td>';
    markup += '<td><button type="button" class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="edit_removeButton' + editcounter + '" onclick="edit_removeTextbox(' + editcounter + ');" title="Click here to remove the stop" ><i class="fa fa-remove"></i></button></td>';
    markup += '</tr>';
    $('#edit_no-more-tables > tbody').append(markup);
    editcounter++;
}
/*
* This function will remove the dynamic textbox
*/
function edit_removeTextbox(counter_value) {
    $('#stop_tr_' + counter_value).remove();
    return true;
}

function deletefunction(defenition_id,counter) {
        $('tr#fee_def_' +counter).remove();
       
       
    }

    
function validation() {
    $('.stopname').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: "Please enter fee head"

            }
        });
    });
    $('.route_fare').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please enter route fare/monthly"
            }
        });
    });
    $('.latitude').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please select location from Geo Map"
            }
        });
    });
    $('.longitude').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please select location from Geo Map"
            }
        });
    });
}

</script>
