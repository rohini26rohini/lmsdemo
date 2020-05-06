<script>
    $(document).ready(function(){
        $("form#add_exams_form").validate({
            rules: {
                name: {required: true},
                school_id: {required: true},
                description: {required: true},
                start_date: {required: true},
                end_date: {required: true}

            },
            messages: {
                name: {required:"Please enter a exam name"},
                school_id: {required:"Please enter a school name"},
                description: {required:"Please enter description"},
                start_date: {required:"Please enter start date"},
                end_date: {required:"Please enter end date"}

            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/exam_add',
                    type: 'POST',
                    data: $("#add_exams_form").serialize(),
                    success: function(response) {
                        if (response != "2" && response != "0") {
                            $('#add_exams').modal('toggle');
                            $('#add_exams_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : 'Upcoming Exams & Notifications Added Succesfully ' });
                            // $("#discount_data").append(response);
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_exams_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                        }
                        else if(response == "2")
                        {
                            $.toaster({ priority : 'danger', title : 'Error', message : 'Upcoming Exams & Notifications Already Exist' });
                        
                        }
                        $(".loader").hide();
                    }
                });
            }
        });
// jQuery.validator.addMethod("greaterThan", 
// function(value, element, params) {

//     if (!/Invalid|NaN/.test(new Date(value))) {
//         return new Date(value) > new Date($(params).val());
//     }

//     return isNaN(value) && isNaN($(params).val()) 
//         || (Number(value) > Number($(params).val())); 
// },'Must be greater than {0}.');

        $("form#edit_exams_form").validate({
            rules: {
                name: {required: true},
                school_id: {required: true},
                description: {required: true},
                start_date: {required: true},
                end_date: {required: true}

            },
            messages: {
                name: {required:"Please enter a exam name"},
                school_id: {required:"Please enter a school name"},
                description: {required:"Please enter description"},
                start_date: {required:"Please enter start date"},
                end_date: {required:"Please enter end date"}

            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/exam_edit',
                    type: 'POST',
                    data: $("#edit_exams_form").serialize(),
                    success: function(response) {
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        if (obj.st == 1) {
                            $('#edit_exams').modal('hide');
                            $.toaster({ priority : 'success', title : 'Success', message : 'Upcoming Exams & Notifications Updated Successfully' });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_exams_ajaxExtra/'+id,
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    var obj1 = JSON.parse(response); 
                                    $('#school_'+id).html(obj1.school); 
                                    $('#name_'+id).html(obj1.name); 
                                    $('#post_'+id).html(obj1.post); 
                                    $('#vacancy_'+id).html(obj1.vacancy); 
                                    $('#start_date_'+id).html(obj1.start_date); 
                                    $('#end_date_'+id).html(obj1.end_date); 
                                    $('#action_'+id).html(obj1.action); 
                                    $(".loader").hide();
                                } 
                            });
                        }
                        $(".loader").hide();
                    }
                });
            }
        });
    });

    function delete_exam(id) {
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
                   
                        $.post('<?php echo base_url();?>backoffice/Content/exam_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {

                            var obj = JSON.parse(data);
                            if (obj.status == 1) {
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                                  $("#row_"+id).empty();
                            } else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message}); 
                            }
                        });
                        
                        //$.alert('Successfully <strong>Deleted..!</strong>');
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
   
    function get_examdata(notification_id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_exam_by_id/'+notification_id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#notification_id").val(obj.notification_id);
                $("#edit_school_id").val(obj.school_id);
                $("#edit_name").val(obj.name);
                $("#edit_description").val(obj.description);
                $("#edit_post").val(obj.post);
                $("#edit_stream").val(obj.stream);
                $("#edit_pay_scale").val(obj.pay_scale);
                $("#edit_vacancy").val(obj.vacancy);
                $("#edit_start_date").val(obj.start_date);
                $("#edit_end_date").val(obj.end_date);
                $("#edit_file").val(obj.file);
                $('#edit_exams').modal({
                    show: true
                });
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
        });
        $('#edit_start_date').datetimepicker();
        $('#edit_end_date').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#edit_start_date").on("dp.change", function (e) {
            $('#edit_end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#edit_end_date").on("dp.change", function (e) {
            $('#edit_start_date').data("DateTimePicker").maxDate(e.date);
        });
    });

    $(function () {
        $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
            // minDate: moment(),
            format: 'dd-mm-yyyy'
        });
        $('#start_date').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
            incrementDay.add(1, 'days');
            $('#end_date').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });

        $('#end_date').datetimepicker().on('dp.change', function (e) {
            useCurrent: false //Important! See issue #1075
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(1, 'days');
            $('#start_date').data('DateTimePicker').maxDate(decrementDay);
             $(this).data("DateTimePicker").hide();
        });
    });

    $(function () {
        $('#edit_start_date,#edit_end_date').datetimepicker({
            useCurrent: false,
            // minDate: moment(),
            format: 'dd-mm-yyyy'
        });
        $('#edit_start_date').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
            incrementDay.add(1, 'days');
            $('#edit_end_date').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });

        $('#edit_end_date').datetimepicker().on('dp.change', function (e) {
            useCurrent: false //Important! See issue #1075
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(1, 'days');
            $('#edit_start_date').data('DateTimePicker').maxDate(decrementDay);
             $(this).data("DateTimePicker").hide();
        });
    });


</script>