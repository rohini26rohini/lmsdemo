<script>
    /*$(document).ready(function() {
    $('#staff_table').DataTable( {
        "pageLength" : 10,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "language": {
        "infoEmpty": "No records available.",
    },
       // "order": [], //Initial no order.
         //"bSort": false,
        "searchable" :true,
         "order": [
          [1, "asc" ]
        ],

        // Load data for the table's content from an Ajax source
            "ajax": {
            "url": "<?php echo base_url();?>backoffice/Notification/load_staffList_byAjax",
            "type": "POST",
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                  },
           },
         //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    } );
} );*/

    function load_data(){

            var filter_role = $("#filter_role").val();
           
            $(".loader").show();
            $.ajax({
                url:"<?php echo base_url(); ?>backoffice/Notification/active_staff_fetch",
                method:"POST",
                data:{
                    filter_role:$("#filter_role").val(),
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data){
                    // if(data!='') {
                    $('#result').html(data);
                    $("#staff_table").DataTable({
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
                                'bSortable': true,
                                'aTargets': [1]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [2]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [3]
                            }
                        ]
                    }); 
                    $(".loader").hide();
                // }else{
                //     $("#export").remove();
                // }
            }
            })
        // }
        }
    $('.filter_change').change(function(){
            var inputLength = $(this).val();
                load_data();
        });
    
    function check_all()
    {
       
        if($("#main:checkbox:checked").length == 0){
            $('.all_staff').prop('checked', false);
           
        }else{
            $('.all_staff').prop('checked', true);
            
        }
    }
    
    $("form#staff_notf").validate({
        rules: {
           message: {
                required: true
            }
        },
        messages: {
            message: "Please enter the message"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Notification/send_message_staff',
                type: 'POST',
                data: $("#staff_notf").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                        $( '#msg_form' ).each(function(){
                                        this.reset();
                                });
                        
                          
                        $.toaster({priority:'success',title:'Success',message:obj.msg});

                      }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.msg});
                    }
                     else{
                         $.toaster({priority:'danger',title:'INVALID',message:'Something went wrong,Please try again later..!'});
                    }
                    $(".loader").hide();
                }

            });


        }


    });
</script>