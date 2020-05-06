//
//

var base_url = $("#directionBaseURL").val();
var csrfName = $("#csrfName").val();
var csrfHash = $("#csrfHash").val();


function redirect(page){
    window.location.assign(base_url+page);
}

//disable the previous dates
$(function () {
    $('.duedate').datetimepicker({
        defaultDate: new Date(),
          format:'DD-MM-YYYY',
           minDate: new Date(),
          
    });
}); 

 $(function () {
    $('.currentdate').datetimepicker({
        defaultDate: new Date(),
          format:'DD-MM-YYYY',
        //   maxDate: new Date(),
          useCurrent:true
    });
});
$(function () {
    $('.calendarclass').datetimepicker({
       // defaultDate: new Date(),
          format:'DD-MM-YYYY',
        //   maxDate: new Date(),
          useCurrent:false
    });
});

$(function () {
    $('.dob').datetimepicker({
       // defaultDate: new Date(),
          format:'DD-MM-YYYY',
          maxDate: new Date(),
          useCurrent:false
    });
});
$(function () {
    $('.hidefuturedate').datetimepicker({
       // defaultDate: new Date(),
          format:'DD/MM/YYYY hh:mm:ss A',
          maxDate: new Date(),
          useCurrent:true
    });
});


$(function () {
    $('.dateOnly').datetimepicker({
       defaultDate: new Date(),
          format:'DD-MM-YYYY',
        //   maxDate: new Date(),
          useCurrent:false
    });
});

$(function () {
    $('.dates').datetimepicker({
    //    defaultDate: new Date(),
          format:'DD-MM-YYYY',
        //   maxDate: new Date(),
          useCurrent:false
    });
});

$(function () {
    $('.datetime').datetimepicker({
        // maxDate: new Date(),
        defaultDate: new Date(),
        format: 'DD/MM/YYYY hh:mm:ss A'

        // formatTime:"DD/MM/YYYY h:i a",
        // step:60
    });
});

$(function () {
    $('.year').datetimepicker({
        defaultDate: new Date(),
        format:'YYYY'
    });
});

$(function () {
    $('.passingyear').datetimepicker({
          format:'YYYY',
          maxDate: new Date(),
          useCurrent:false
    });
});

$(function () {
    $('.time').datetimepicker({
		format : 'hh:mm a'
    });
});
$(function () {
   $(".month_year").datetimepicker({
        format: "MM-YYYY",
        maxDate: new Date()
    });
});


jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z ]+$/i.test(value);
}, "Letters only please");

 $.validator.addMethod("nospecialChar", function(value, element) {
        return this.optional(element) || /^[a-z0-9-, ]+$/i.test(value);
    }, "Special characters not allowed.Use letters or numbers");

$.validator.addMethod("addressVal", function(value, element) {
        return this.optional(element) || /^[a-z0-9-,-/ ]+$/i.test(value);
    }, "name must contain only letters, numbers,comma,hiphen,slash.");

 $.validator.addMethod("letters", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "name must contain only letters, space.");

 $.validator.addMethod("emailValidate", function(value, element) {
        //return this.optional(element) || /^[a-z0-9-.@]+$/i.test(value);
        return this.optional(element) || /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{0,9})$/i.test(value);
    }, "name must contain only letters, numbers and .");

$.toaster({ settings : {
    'toaster'         :{
        'id'        : 'toaster',
        'container' : 'body',
        'template'  : '<div></div>',
        'class'     : 'toaster',
        'css'       : {
            'position' : 'fixed',
            'top'      : '0',
            'right'      : '0',
            'zIndex'   : 50000,
            'font-family'   : 's-bold',
            'font-size'   : '13px',
            'text-align'   : 'center',
            'bottom':'0',
            'left':'0',
            'width':'40%',
            'margin':'auto',
            'height':'50px',
        }
    },
    'debug'        : false,
    'timeout'      : 5000,
    'stylesheet'   : null,
    'donotdismiss' : []
}});

setInterval(function(){
    if($("#toaster").length != 0) {
        setTimeout(function(){
            $("#toaster").remove();
        }, 5000);
    }
}, 5000);

$(function() {
    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true,
        numberDisplayed: 1

        
    });
    
        $('.numberswithdecimal').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
               this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
    
        $('.numbersOnly').keyup(function () {
            if (this.value != this.value.replace(/[^0-9]/g, '')) {
               this.value = this.value.replace(/[^0-9]/g, '');
            }
        });
    
        $('#logout').click(function () {
          $.confirm({
                title: 'Alert message',
                content: 'Do you want to logout?',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Yes',
                        btnClass: 'btn-blue',
                        action: function() {
                            window.location.href = base_url+"backoffice/logout";

                        }
                    },
                    cancel: function() {
                        //$.alert(' <strong>cancelled</strong>');
                    },
                }
            });
        });
    
});

function alert_message(message){
    $.confirm({
        title: 'Notice',
        content: message,
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'cancel': {
                text: 'OK',
                btnClass: 'btn-blue',
                action: function() {
                }
            }
        }
    });

}

// number validation
function valNum(evt){

     var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  return true; } else {
        if (regex.test(str)) {
            return true;
        }
        else
        {
        event.preventDefault();
        return false;
        }
    }
}

/*number and decimal*/
function decimalNum(event){
    var regex = new RegExp("^[0-9.]+$");
    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  
        return true; 
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            event.preventDefault();
            return false;
        }
    }
}

/*only allow alphabets*/ // allow letters and whitespaces only.
function valNames(e) {
    var regex = new RegExp("^[a-zA-Z]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if(e.which==8 || e.which==32 || e.which==0) {  return true; } else {
    if (regex.test(str)) {
        return true;
    }
    else
    {
    e.preventDefault();
    return false;
    }
    }
}

/*allow numbers and alphabets but no special char*/
function blockSpecialChar(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }
/*number and backwerd slash for date field*/
function ValDate(event){
     var regex = new RegExp("^[0-9/ ]+$");
        var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  return true; } else {
        if (regex.test(str)) {
            return true;
        }
        else
        {
        event.preventDefault();
        return false;
        }
    }
}
//accepts only alphabets,numbers,comma,hiphen and slash
   function addressValidation(e) {
        var regex = new RegExp("^[a-zA-Z0-9 ,-/]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if(e.which==8 || e.which==32 || e.which==0) {  return true; } else {
            if (regex.test(str)) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        }
    }

//accepts only alphabets,numbers
   function txtnumberValidation(e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if(e.which==8) {  return true; } else {
        if (regex.test(str)) {
            return true;
        }
        else
        {
        e.preventDefault();
        return false;
        }
       }
    }

function clearform(formid) {
    $('#'+formid).trigger("reset");
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
}

$('.txtnumOnly').keypress(function (e) { 
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    else
    {
    e.preventDefault();
    return false;
    }
});

$('.txtOnly').keypress(function (e) { 
    var regex = new RegExp("^[a-zA-Z]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    else
    {
    e.preventDefault();
    return false;
    }
});

/** Calendar features Starts*/
function create_calendar(height='',url=''){
    if(url==''){
        url = base_url+"backoffice/calendar/get_calendar_events";
    }
    if(height==''){
        height = 650;
    }
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek',
        },
        buttonText: {
            today:    'Today',
            month:    'Month',
            week:     'Week',
            day:      'Day',
            list:     'List',
        },
        // titleFormat: 'DD - MM - YYYY',
        allDayText: 'All Day',
        height: height,
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        eventLimit: true,
        defaultView: 'agendaDay', // allow "more" link when too many events
        eventSources: [{
            url: url,
            type: 'GET',
            cache: false
        }]
    });
    var html = '<div class="row">'+
                    '<button data-toggle="modal" data-target="#calendar_advanced_filter_modal" class="chartBlockBtn btn btn-default add_row add_new_btn btn_add_call addBtnPosition">Batchwise Filter</button>'+
                '</div><br><br>';
    $('#calendar').prepend(html);
    get_calendar_branch();
}

var update_url = '';
function update_calendar(url=''){
    $(".loader").show();
    if(url==''){
        if(update_url != ''){
            url = update_url;
        }else{
            url = base_url+"backoffice/calendar/get_calendar_events";
        }
    }else{
        update_url = url;
    }
    $('#calendar').fullCalendar('removeEvents', function () { return true; });
    // $('#calendar').fullCalendar('removeEventSource', url);
    $('#calendar').fullCalendar('removeEventSources');
    $('#calendar').fullCalendar('addEventSource', url);  
    $(".loader").hide();
}

function get_calendar_branch(){
    $(".loader").show();
    $.ajax({
        url: base_url+'backoffice/Calendar/get_calendar_filter_content/branch',
        type: 'GET',
        success: function(response) {
            $("#calendar_branch").html(response);
            $(".loader").hide();
        }
    });
}

function get_calendar_center(){
    $(".loader").show();
    var branch = $('#calendar_branch').val();
    if (branch != "") {
        $.ajax({
            url: base_url+'backoffice/Calendar/get_calendar_filter_content/center/'+branch,
            type: 'GET',
            success: function(response) {
                $("#calendar_center").html(response);
                $(".loader").hide();
            }
        });
    }else{
        $("#calendar_center").html("<option value=''>Select Center</option>");
        $("#calendar_course").html("<option value=''>Select Course</option>");
        $("#calendar_batch").html("<option value=''>Select Batch</option>");
        $(".loader").hide();
    }
}

function get_calendar_course(){
    $(".loader").show();
    var center = $('#calendar_center').val();
    if (center != "") {
        $.ajax({
            url: base_url+'backoffice/Calendar/get_calendar_filter_content/course/'+center,
            type: 'GET',
            success: function(response) {
                $("#calendar_course").html(response);
                $(".loader").hide();
            }
        });
    }else{
        $("#calendar_course").html("<option value=''>Select Course</option>");
        $("#calendar_batch").html("<option value=''>Select Batch</option>");
        $(".loader").hide();
    }
}

function get_calendar_batch(){
    $(".loader").show();
    var course = $('#calendar_course').val();
    if (course != "") {
        $.ajax({
            url: base_url+'backoffice/Calendar/get_calendar_filter_content/batch/'+course,
            type: 'GET',
            success: function(response) {
                $("#calendar_batch").html(response);
                $(".loader").hide();
            }
        });
    }else{
        $("#calendar_batch").html("<option value=''>Select Batch</option>");
        $(".loader").hide();
    }
}



/** Calendar features Ends*/


$(document).ready(function(){
    $(".drop_ul_a").hide();
    $(".drop_a").click(function(){
        $(this).find(".drop_ul_a").slideToggle();
    });
      $(".drop_a.active ul.drop_ul_a").show();
//$(".suu").click(function(){
//  alert("The paragraph was clicked.");
//});
    
    //
    $(".sb-container").scrollBox();
});


function formclear(form_id) {
   var validator = $("#"+form_id).validate(); 
    // validator.resetForm();
    //  validator.reset();
     $("#"+form_id).trigger("reset");
    $('select').each( function() {
        $(this).val( $(this).find("option[selected]").val() );
    });

    for (instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
        CKEDITOR.instances[instance].setData('');
    }

    $(".custom-select").val(10);
    $('#insticentremappsave').show();
}

function go_back(){
    window.history.go(-1);
}

$(function () {
  $.ajax({
        url: base_url+'backoffice/Commoncontroller/get_notification',
        type: 'POST',
        data: {
            ci_csrf_token :csrfHash
        },
        success: function(response) {
            var res = JSON.parse(response);
           $("#notificationLink").html(res.icon);
            $("#notificationLink").append(res.data);

        }
    });
setInterval(function(){
   var csrf = csrfName+': '+csrfHash;
  $.ajax({
        url: base_url+'backoffice/Commoncontroller/get_notification',
        type: 'POST',
        data: {
            ci_csrf_token :csrfHash
        },
        success: function(response) {
            var res = JSON.parse(response);
            $("#notificationLink").html(res.icon);
         $("#notificationLink").append(res.data);

        }
    });
//}, 90000);
},5590000);
});

function read_by(id,notif_id)
{
   
    if(id!="")
        {
            $.ajax({
                    url: base_url+'backoffice/Approval/read_notification',
                    type: 'POST',
                    data: {
                        read_by:id,
                        notification_id:notif_id,
                        ci_csrf_token :csrfHash
                    },
                    success: function(response) {
                        return true;

                    }
                });
        }
}

$(document).ready(function(){
    $(".batch_session_days").change(function(){
          var id=(this).id;
          if(this.checked) 
          {
                $("#"+id+"_div").html('<tr><td><div class="batchlist-form" style="width:80px; margin:auto;"><input type="hidden" id="counter_'+id+'" value="1"/><div class="form-group" style="margin-bottom:0"><label>Start time<span class="req redbold">*</span></label><input class="form-control itime" type="text" name="'+id+'_start_time[]" id="'+id+'_start_time_1" placeholder="Start time"></div><div class="form-group" style="margin-bottom:0"><label>End time<span class="req redbold">*</span></label><input class="form-control itime" type="text" name="'+id+'_end_time[]" id="'+id+'_end_time_1" placeholder="End time"></div></div><button type="button" class="btn-round btn btn-block btn-info btn-sm mt-2" onclick=addNew_batch_sessiontime("'+id+'")><i class="fa fa-plus"></i></button></div></td><tr><script>$(".itime").datetimepicker({format : "hh:mm a"});$("#'+id+'_start_time_1").on("dp.change", function (e) {$("#'+id+'_end_time_1").data("DateTimePicker").minDate(e.date); });$("#'+id+'_end_time_1").on("dp.change", function (e) { });</script>');
            }
        else{
             $("#"+id+"_div").html('');
            }
        
    });
});
function addNew_batch_sessiontime(id){  
    var counter=parseInt($("#counter_"+id).val())+1;
    
    var markup = '';
    markup += '<tr id="'+id+'_row_'+counter+'"><td><div class="batchlist-form" style="width:80px; margin:auto;"><input type="hidden" id="counter_'+id+'" value="1"/><div class="form-group " style="margin-bottom:0"><label>Start time<span class="req redbold">*</span></label><input class="form-control itime" type="text" name="'+id+'_start_time[]" id="'+id+'_start_time_'+counter+'" placeholder="Start time"></div>';

    markup+='<div class="form-group" style="margin-bottom:0"><label>End time<span class="req redbold">*</span></label><input class="form-control itime" type="text" name="'+id+'_end_time[]" id="'+id+'_end_time_'+counter+'" placeholder="End time"></div><button type="button" class="btn btn-round btn-danger btn-block option_btn"  onclick=remove("'+counter+'","'+id+'") title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></div></td><tr><script>$(".itime").datetimepicker({format : "hh:mm a"});$("#'+id+'_start_time_'+counter+'").on("dp.change", function (e) {$("#'+id+'_end_time_'+counter+'").data("DateTimePicker").minDate(e.date); });$("#'+id+'_end_time_'+counter+'").on("dp.change", function (e) { });</script>';

    $("#"+id+"_div").append(markup);
    $("#counter_"+id).val(counter);
}
        
function show_ajax_error_message(jqXHR, exception){
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    $.toaster({priority:'warning',title:'Technical Error',message:msg });  
}

