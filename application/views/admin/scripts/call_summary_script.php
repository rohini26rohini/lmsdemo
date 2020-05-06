<script>
$(document).ready(function(){
    $('input[name=filter_sdate]').blur(function() {
        load_data();
    });
    $('input[name=filter_edate]').blur(function() {
        load_data();
    });
     $('#staff').change(function() { 
        load_data();
    });
    
    function load_data(){
        var filter_sdate = $("#filter_sdate").val();
        var filter_edate = $("#filter_edate").val();
        var staff = $("#staff").val();
        $(".loader").show();
        $.ajax({
            url:"<?php echo base_url(); ?>backoffice/Call_center/call_summary_filter",
            method:"POST",
            data:{staff:staff,filter_sdate:$("#filter_sdate").val(),filter_edate:$("#filter_edate").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success:function(data){
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
