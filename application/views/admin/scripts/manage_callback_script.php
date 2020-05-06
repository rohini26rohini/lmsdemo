<script>
$(document).ready(function(){
    $('input[name=filter_sdate]').blur(function() {
        load_data();
    });
    $('input[name=filter_edate]').blur(function() {
        load_data();
    });
    load_data();
    function load_data(){
        var filter_status = $("#filter_status").val();
        var filter_sdate = $("#filter_sdate").val();
        var filter_edate = $("#filter_edate").val();
        $(".loader").show();
        $.ajax({
            url:"<?php echo base_url(); ?>backoffice/Call_center/callback_fetch",
            method:"POST",
            data:{filter_status:$("#filter_status").val(),filter_sdate:$("#filter_sdate").val(),filter_edate:$("#filter_edate").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success:function(data){
                $('#callback_result').html(data);
                $(".loader").hide();
            }
        })
    }

    $('.filter_class').keyup(function(){
            load_data();
    });
    $('.filter_class').change(function(){
            load_data();
    });
    $('.filter_class').bind('paste', function(e) {
            load_data();
    });

     $("form#add_description").validate({
        rules: {
            description : {required: true}
        },
        messages: {
            description: {required:"Please enter description"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/description_add',
                type: 'POST',
                data: $("#add_description").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#description_modal').modal('toggle');
                        $('#add_description' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Caller details added succesfully' });
                        setTimeout(function(){ window.location.reload(); }, 3000);
                        $("#description_data").append(response);
                    }
                    else if(response == "2")
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Description already exist'});
                         
                    }
                    $(".loader").hide();
                }
            });
        }
    });
});

function get_callback(id)
    {
        $("#enquiry_id").val(id);
        $("#status").val(id);
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Call_center/get_callbacks_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#enquiry_id").html(obj.callback_details.enquiry_id);
                $("#name").html(obj.callback_details.enquiry_name);
                $("#phone").html(obj.callback_details.enquiry_phone);
                $("#email").html(obj.callback_details.enquiry_email);
                $("#location").html(obj.callback_details.enquiry_note);
                var table = "<div class= 'table-responsive table_language'><table class='table table_followup table-sm table-bordered table-striped'>";
                table += "<tr><th>Sl. No.</th><th>Date&Time</th><th>Status</th><th>Description</th></tr>";
                var j = 0;
                $.each(obj.description_details, function (i, v) {
                    j++;
                    // var status = "";
                    //     if(v.status == 'Received'){
                    //         status = "Received";
                    //     }else if(v.status == '2'){
                    //         status = "Replied";
                    //     }else{
                    //         status = "Un necessary";
                    //     }
                    // var date = strtotime(v.modified_on); 
                    // var new_date = date("d/m/Y h:i:s A",date);
                    if(v.status=='Un neccessary'){v.status='Blacklisted';}
                    table += "<tr><td>"+j+"</td><td>"+v.modified_on+"</td><td>"+v.status+"</td><td>"+v.description+"</td></tr>";
                });
                table += "<table></div>";
                $("#history_view").html(table);
                    $('#view_callbacks').modal({
                        show: true
                    });
                    $(".loader").hide();
            }
        });

    }

    function get_val(id) {
        // $.confirm({
            // title: 'Alert message',
            // content: 'Do you want to change?',
            // icon: 'fa fa-question-circle',
            // animation: 'scale',
            // closeAnimation: 'scale',
            // opacity: 0.5,
            // buttons: {
                // 'confirm': {
                    // text: 'Proceed',
                    // btnClass: 'btn-blue',
                    // action: function() {
                        $(".loader").show();
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Call_center/get_callback_val',
                            type: 'POST',
                            data:{id: id,selectid: $("#call_back_status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                            success: function(response) {
                                if (response == "1") {
                                    // $.alert('Successfully <strong>Changed..!</strong>');
                                    // var obj = JSON.parse(response);
                                    // $("#call_back_status_"+id).html(obj.status);
                                }
                                $(".loader").hide();
                                $("#enquiry_id").val(id);
                                // $("#status").val(status);
                                $('#description_modal').modal({
                                    show: true
                                });

                            }
                        });
                    // }
                // },
                // cancel: function() {
                // },
            // }
        // });
    }
</script>
