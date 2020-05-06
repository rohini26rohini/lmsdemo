

<script>
    
    $("form#add_batch_form").validate({
        rules: {
            last_date:{
               required: true,
              // lessThan: "#end_date" 
            },
            group_name: {
                required: true
            },
            branch_name: {
                required: true
            },
            center_name: {
                required: true
            },
            course_name: {
                required: true
            },
            batch_name: {
                required: true,
                remote:{
                    url: '<?php echo base_url();?>backoffice/Home/check_batchName',
                    type: 'POST',
                    data: {
                         batch_name: function() {
                          return $("#batch_name").val();
                          },
                        batch_id: function() {
                          return $("#batch_id").val();
                          },
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }
                }
            },
            start_date: {
                required: true
             
            },
            end_date: {
                required: true,
               // greaterThan: "#start_date"
            },
            start_time: {
                required: true
            },
            end_time: {
                required: true,
               // greaterThan: "#start_date"
            },
            no_student: {
                required: true,
                number:true
            },
            'weekday[]': {
                required: true
            }
        },
        messages: {
            last_date:{
                required:"Please Choose the last date for Admission",
               // lessThan:"Please Choose a date less than End date"
            },
            group_name: "Please select Group",
            branch_name: "Please select Branch",
            center_name: "Please select Centre",
            course_name: "Please select Course",
            batch_name: {
                required:"Please enter batch name",
                remote:"This Batch Name Already Exist",
            },
            mode: "Please select mode",
            start_date: "Please select start date",
            end_date:{
                required:"Please select end date",
               // greaterThan:"Please choose a date greater than start date"
            }, 
            start_time: "Please select a time",
             end_time:{
                required:"Please select end time",
               // greaterThan:"Please choose a time greater than start Time"
            }, 
            no_student: "Please enter total number of student",
           'weekday[]': "Please select a weekday for the batch"
        },

        submitHandler: function(form) {
            $("#batch_save").attr("disabled", true);
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/check_batch_schedule_exists',
                type: 'POST',
                data: $("#add_batch_form").serialize(),
                success: function(response) {
                    var obj = JSON.parse(response);
			         if (obj.status == true) {
                         
                        $(".loader").hide();
                        $.confirm({
                            title: 'This batch is already scheduled.',
                            content: '<span style="font-size:14px;">Updating this batch details will delete all the future class schedues for this batch.<br> Are you sure you want to continue.</span>',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            opacity: 0.5,
                            fontSize:10,
                            buttons: {
                                'confirm': {
                                    text: 'Yes delete all schedules',
                                    btnClass: 'btn-danger',
                                    action: function() {
                                        $(".loader").show();
                                        save_batch_details();
                                    }
                                },
                                'cancel': {
                                    text: 'Cancel',
                                    btnClass: 'btn-info',
                                    function() {
                                    },
                                }
                            }
                        });
                    }else{
                        save_batch_details();
                        $(".loader").hide();
                       // $.toaster({ priority : 'danger', title : 'Success', message : obj.message });
                    }
                }
            });
        }
    });

    function save_batch_details(){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Home/batch_actions',
            type: 'POST',
            data: $("#add_batch_form").serialize(),
            success: function(response) {
                var obj = JSON.parse(response);
                    if (obj.status == true) {
                    $(".loader").hide();
                    $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                  
                        $("#chartBlock").removeClass(("show"));
                         $(".batch_days").html("");
                            $("#chartBlock").removeClass(("show"));
                         load_batch_ajax();
                         location.reload();
                       // $('#batch_save').attr('disabled', false);
                }else{
                    $(".loader").hide();
                    $.toaster({ priority : 'danger', title : 'Invalid', message : obj.message });
                     $('#batch_save').attr('disabled', false);
                }
            }
        });
    }

    function load_batch_ajax(){
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/load_batch_ajax',
                type: 'POST',
                    data: {
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {   
                    $('#institute_data1').DataTable().destroy();
                    $("#institute_data1").html(response);
                    $("#institute_data1").DataTable({
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
                            }
                            
                        ]
                    });    
                    $(".loader").hide();
                        $('#batch_save').attr('disabled', false);
                } 
        }); 
    }
    
$("#institute_data1").on("click",".getbatchdetails", function(){
//$(".getbatchdetails").click(function(){
    var id = $(this).attr('id');
    clear_id();
    if(id !=""){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Home/get_batchdetails',
            type: 'POST',
            data: {
                batch_id: id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                var res = JSON.parse(response);
                    if (res.status == 1) {
                        obj = res.data;
                        var timing = res.class_timing;
                        $('#group_name').val(obj.group_master_id).prop('selected','selected');
                        $('#branch_name').html(obj.batch_creationdate);
                        $('#center_name').html(obj.created_time);
                        $('#course_name').html(obj.modified_date);
                        $('#batch_name').val(obj.batch_name);
                        $('#no_student').val(obj.batch_capacity);
                        $('#start_date').val(obj.batch_datefrom);
                        $('#end_date').val(obj.batch_dateto);
                        $('#last_date').val(obj.last_date);
                        if(obj.monday==1){
                            $("#monday").prop('checked','checked');
                            $("#monday_div").html(timing.monday);
                        }
                        if(obj.tuesday==1){
                            $("#tuesday").prop('checked','checked');
                             $("#tuesday_div").html(timing.tuesday);
                        }
                        if(obj.wednesday==1){
                            $("#wednesday").prop('checked','checked');
                             $("#wednesday_div").html(timing.wednesday);
                        }
                        if(obj.thursday==1){
                            $("#thursday").prop('checked','checked');
                             $("#thursday_div").html(timing.thursday);
                        }
                        if(obj.friday==1){
                            $("#friday").prop('checked','checked');
                             $("#friday_div").html(timing.friday);
                        }
                        if(obj.saturday==1){
                            $("#saturday").prop('checked','checked');
                             $("#saturday_div").html(timing.saturday);
                        }
                        if(obj.sunday==1){
                            $("#sunday").prop('checked','checked');
                             $("#sunday_div").html(timing.sunday);
                        }
                        // $('input').attr('name', 'weekday').val(obj.monday).prop('checked','checked');
                         $('#installments').html(obj.due_dates);
                        $('#batch_id').val(obj.batch_id);
                    } else {
                        $('#errormsg').html(res.message);
                    }
                    $(".loader").hide();
            }
        });
    }
});


function delete_fromtable(id){

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
                                    url: '<?php echo base_url();?>backoffice/Home/delete_fromwhere',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                            if (obj.status == 1) {
                                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                                                  $("#row_"+id).remove();
                                            } else {
                                               $.toaster({priority:'danger',title:'INVALID',message:obj.message}); 
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
        

    $("#group_name").change(function(){
        var group = $('#group_name').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#branch_name").html(response);

                    }
                });
                $(".loader").hide();
        }
    });

    $("#branch_name").change(function(){
        var branch = $('#branch_name').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center_name").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });

     $("#center_name").change(function(){
        var center = $('#center_name').val();

        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_centercoursemapping',
                type: 'POST',
                data: {
                    center_id: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#course_name").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });

    //show the number of  due date field of course in add batch
    $("#course_name").change(function(){
        var course_id = $('#course_name').val();
        $("#installments").html("");

        if (course_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/get_count_duedate',
                type: 'POST',
                data: {
                    course_id: course_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {

                    var obj=JSON.parse(response);
                    if(obj.st == 1)
                        {
                           $("#installments").html(obj.due_dates);
                        }


                    $(".loader").hide();
                }
            });
        }
        else{
            $("#installments").html("");
        }
    });

    $(window).on('load', function() {
        var group = $('#group_name').val(); 
        if(group != ""){
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: group,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#branch_name").html(response);
                    $(".loader").hide();

                }
            });
        }
    });

    function clear_id(){
        $("#add_batch_form").trigger("reset");
        $("#batch_id").val('');
        $("#branch_name").prop("selected", false);
        $("#center_name").prop("selected", false);
        $("#course_name").prop("selected", false);
        $("option:selected").prop("selected", false);
    }
    
    
    function get_batch_details(id)
    {
        $(".loader").show();
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Home/get_batchdetail_view',
            type: 'POST',
            data: {
                batch_id: id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                var res = JSON.parse(response); 
                    if (res.status == 1) {
                        obj = res.data;
                        $('#cessrow').show();  
                        $('#group_name').val(obj.group_master_id).prop('selected','selected');
                        $('#branch_name').html(obj.batch_creationdate);
                        $('#center_name').html(obj.created_time);
                        $('#course_name').html(obj.modified_date);
                        $('#batchname_view').html(obj.batch_name);
                        $('#nostudent_view').html(obj.batch_capacity);
                        $('#startdate_view').html(obj.batch_datefrom);
                        $('#enddate_view').html(obj.batch_dateto);
                       // $('#start_time_view').html(obj.batch_start_time);
                       // $('#end_time_view').html(obj.batch_end_time);
                        $('#last_date_view').html(obj.last_date);
                        $('#coursedet_view').html(obj.course_master_id);
                        $('#tuition_fee_view').html(obj.course_tuitionfee);
                        $('#cgst_fee_view').html(obj.course_cgst);
                        $('#sgst_fee_view').html(obj.course_sgst);
                        $('#cess_fee_view').html(obj.course_cess);
                        if(obj.cess>0) {
                        $('#cess_fee_val').html(obj.cess+'%');
                        } else {
                        $('#cessrow').hide();    
                        }
                        $('#total_fee_view').html(obj.course_totalfee);
                        $('#mode_fee_view').html(obj.course_paymentmethod);
                        if(obj.monday==1){
                            $("#batch_mon_view").show();
                             $("#v_mon").html(res.monday);            
                          } else { $("#batch_mon_view").hide();$("#v_mon").html("");}
                        if(obj.tuesday==1){$("#batch_tue_view").show(); $("#v_tue").html(res.tuesday);} else { $("#batch_tue_view").hide();$("#v_tue").html("");}
                        if(obj.wednesday==1){
                            $("#batch_wed_view").show(); $("#v_wed").html(res.wednesday);} 
                        else { $("#batch_wed_view").hide(); $("#v_wed").html("");}
                        if(obj.thursday==1){$("#batch_thu_view").show(); $("#v_thu").html(res.thursday);} else { $("#batch_thu_view").hide();  $("#v_thu").html("");}
                        if(obj.friday==1){$("#batch_fri_view").show(); $("#v_fri").html(res.friday);} else { $("#batch_fri_view").hide(); $("#v_fri").html("");}
                        if(obj.saturday==1){$("#batch_sat_view").show(); $("#v_sat").html(res.saturday);} else { $("#batch_sat_view").hide(); $("#v_sat").html("");}
                        if(obj.sunday==1){$("#batch_sun_view").show(); $("#v_sun").html(res.sunday);} else { $("#batch_sun_view").hide(); $("#v_sun").html("");}
                        // $('input').attr('name', 'weekday').val(obj.monday).prop('checked','checked');
                        $('#batch_id').val(obj.batch_id);
                        $('#instalment_details').html(obj.instalment_details);

                    } else {
                        $('#errormsg').html(res.message);
                    }
                    $(".loader").hide();
            }
        });
    }
 
    
     $(function () {
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
             $('#last_date').data("DateTimePicker").maxDate(e.date);
            
        });
         
         //last date of admission sholud be lessthan end date
         $('#last_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         $("#last_date").on("dp.change", function (e) {
           //  alert("jhb");
           // $('#end_date').data("DateTimePicker").maxDate(e.date);
        }); 
         //time validate
         $('#start_time').datetimepicker();
        $('#end_time').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
         
        $("#start_time").on("dp.change", function (e) {
            $('#end_time').data("DateTimePicker").minDate(e.date);
        });
        $("#end_time").on("dp.change", function (e) {
            $('#start_time').data("DateTimePicker").maxDate(e.date);
        });
    });
    
    $(document).ready(function () {
        $(document).on('click', '.chartBlockBtn', function () {
        // $(".chartBlockBtn").click(function () {
            <?php //if(count($batchArr)>=3){ ?>
            //$.toaster({ priority : 'danger', title : 'License expired', message : 'Please renew the license.' });
            <?php //}else{ ?>
            $("#chartBlock").addClass("show");
            $(".close_btn").fadeIn("200");
            <?php //} ?>
        });
        // $(".close_btn").click(function () {
        $(document).on('click', '.close_btn', function () {
            $(this).hide();
            $(".batch_days").html("");
            $("#chartBlock").removeClass(("show"));
        });
    });
    
    
    
    function remove(count,id)
    {
      $("#"+id+'_row_'+count).remove();
        return false;   
    }
    
     $(".date-close").click(function(){
         $("#sunday_div").html("");
         $("#monday_div").html("");
         $("#tuesday_div").html("");
         $("#wednesday_div").html("");
         $("#thursday_div").html("");
         $("#friday_div").html("");
         $("#saturday_div").html("");
     });
   
    
    
</script>
