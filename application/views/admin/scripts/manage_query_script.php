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
            url:"<?php echo base_url(); ?>backoffice/Call_center/query_fetch",
            method:"POST",
            data:{filter_status:$("#filter_status").val(),filter_sdate:$("#filter_sdate").val(),filter_edate:$("#filter_edate").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success:function(data){
                $('#query_result').html(data);
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
});

function get_query(id)
    {
        $(".loader").show();
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/get_query_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                   // $("#date").val(obj.class_id);
                    $("#name").html(obj.enquiry_name);
                    $("#phone").html(obj.enquiry_phone);
                    $("#email").html(obj.enquiry_email);
                    $("#location").html(obj.enquiry_location);
                    $("#notes").html(obj.enquiry_note);
                     $('#view_queries').modal({
                        show: true
                        });
                        $(".loader").hide();
                }
            });

    }

      function get_val(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $(".loader").show();
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Call_center/get_query_val',
                            type: 'POST',
                            data:{id: id,selectid: $("#query_status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                            success: function(response) {
                                if (response == "1") {
                                    $.alert('Successfully <strong>Changed..!</strong>');
                                }
                                $(".loader").hide();
                            }
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
</script>
