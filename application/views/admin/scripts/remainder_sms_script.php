<script>
    $(document).ready(function() {
        $('#multi-select-demo').multiselect({
      allSelectedText: 'All',
      maxHeight: 200,
      includeSelectAllOption: true
    });
    });
 
    $(document).ready(function(){
        // $('input[name^="answers"]').each(function() {
        //     $(this).rules('add', {
        //         required: true
        //     });
        // });

        $(".smssendingtype").change(function() { 
            $(".loader").show();
            var type = $(this).val();
            $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_remainder_sms_list/'+type,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                $('#multi-select-demo').html(response);
                $("#multi-select-demo").multiselect('destroy');
                $("#multi-select-demo").multiselect({
                        allSelectedText: 'All',
                        maxHeight: 200,
                        includeSelectAllOption: true
                        });
                $('#multi-select-demo').multiselect('refresh');
                $(".loader").hide();
            }
        });
        });


        var edit_validation = 0;
        $("form#remainder_sms_form").validate({
            rules: {
                "type": {required: true},
                "candidate[]": {required: true,minlength: 1},
                "message": {required: true, maxlength: 160}
            },
            messages: {
                "type": {required: "Please select type"}, 
                "candidate[]": {required: "Please select candidate"}, 
                "message": {required: "Please enter message", maxlength:"Character length upto 160"}
            },
            submitHandler: function(form) { 
                $(".loader").show();
                var options = $('#multi-select-demo > option:selected');
                        if(options.length == 0){
                            //alert('no value selected');
                            $('#student_err_mess').html('Please select candidate');
                            edit_validation = 0;
                            $(".loader").hide();
                            return false;
                        } else {
                            $('#student_err_mess').html('');
                            edit_validation = 1;
                        }
                // alert(add_validation);
            }
        });
        $("form#remainder_sms_form").submit(function(e) {
            // alert(add_validation);
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            if (edit_validation == 1) {
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Call_center/send_remainder_sms',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        edit_validation = 0;
                        $(".loader").hide();
                        if(response) {
                        $.toaster({ priority : 'success', title : 'Success', message : 'Message successfully send' });
                        } else {
                            $.toaster({ priority : 'warning', title : 'Warning', message : 'Message sending failed' });    
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });



        $(".selectcentre").change(function() { 
            $(".loader").show();
            var id = $(this).val();
            $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_centre_list/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                $('#centre').html(response);
                $(".loader").hide();
            }
        });
        });


        $(".selectbatch").change(function() { 
            $(".loader").show();
            var id = $(this).val();
            $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_batch_list/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                $('#batch').html(response);
                $(".loader").hide();
            }
        });
        });

        $(".selectstudent").change(function() { 
            $(".loader").show();
            var id = $(this).val();
            $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_student_batch/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                $('#multi-select-demo').html(response);
                $("#multi-select-demo").multiselect('destroy');
                $("#multi-select-demo").multiselect({
                        allSelectedText: 'All',
                        maxHeight: 200,
                        includeSelectAllOption: true
                        });
                $('#multi-select-demo').multiselect('refresh');
                $(".loader").hide();
            }
        });
        });




        var validation = 0;
        $("form#bulk_sms_form").validate({
            rules: {
                "branch": {required: true},
                "centre": {required: true},
                "batch": {required: true},
                "candidate[]": {required: true},
                "message": {required: true, maxlength:160}
            },
            messages: {
                "branch": {required: "Please select branch"}, 
                "centre": {required: "Please select centre"}, 
                "batch": {required: "Please select batch"}, 
                "candidate[]": {required: "Please select student"}, 
                "message": {required: "Please enter message", maxlength:"Character length upto 160"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                var options = $('#multi-select-demo > option:selected');
                        if(options.length == 0){
                            //alert('no value selected');
                            $('#student_err_mess').html('Please select candidate');
                            validation = 0;
                            $(".loader").hide();
                            return false;
                        } else {
                            $('#student_err_mess').html('');
                            validation = 1;
                        }
                
                // alert(add_validation);
            }
        });
        $("form#bulk_sms_form").submit(function(e) {
            // alert(add_validation);
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            if (validation == 1) {
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Call_center/send_bulk_sms',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        validation = 0;
                        $(".loader").hide();
                        if(response) {
                        $.toaster({ priority : 'success', title : 'Success', message : 'Message successfully send' });
                        } else {
                            $.toaster({ priority : 'warning', title : 'Warning', message : 'Message sending failed' });    
                        }
                    },
                    cache: false,
                contentType: false,
                processData: false
                });
            }
        });



    });      
</script>