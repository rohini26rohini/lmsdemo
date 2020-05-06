<script>

//pagination
$(document).ready(function() {
    // $('#institute_data').DataTable( {
    //     "pageLength" : 10,
    //     "processing": true, //Feature control the processing indicator.
    //     "serverSide": true, //Feature control DataTables' server-side processing mode.
    //     "language": {
    //     "infoEmpty": "No records available.",
    // },
    //    // "order": [], //Initial no order.
    //     "searchable" :true,
    //     //  "order": [
    //     //   [1, "desc" ]
    //     // ],
    //     searching: false,
       
    //     // Load data for the table's content from an Ajax source
    //         "ajax": {
    //         //"url": "<?php //echo base_url();?>backoffice/Transport/trans_student_list_pagination",
    //         "type": "POST",
    //         data: {
    //             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //               },
    //        },
    //      //Set column definition initialisation properties.
    //     "columnDefs": [
    //     { 
    //         "targets": [ 0 ], //first column / numbering column
    //         "orderable": false, //set not orderable
    //     },
    //     ],
    // } );




    //     $('#hallticket_table').DataTable( {
    //     "pageLength" : 10,
    //     "processing": true, //Feature control the processing indicator.
    //     "serverSide": true, //Feature control DataTables' server-side processing mode.
    //     "language": {
    //     // "infoEmpty": "No records available.",
    // },
    //    // "order": [], //Initial no order.
    //      //"bSort": false,
    //     // "searchable" :false,
    //     //  "order": [
    //     //   [1, "asc" ]
    //     // ],
      
    //     // Load data for the table's content from an Ajax source
    //         "ajax": {
    //         "url": "<?php echo base_url();?>backoffice/Students/hallticket_details_ajax",
    //         "type": "POST",
    //         data:{filter_exam:$("#filter_exam").val(),filter_course:$("#filter_course").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},

    //        },
    //      //Set column definition initialisation properties.
    //     "columnDefs": [
    //     { 
    //         "targets": [ 0 ], //first column / numbering column
    //         "orderable": false, //set not orderable
    //     },
    //     ],
    // } );



    function get_load_data(){
        var filter_exam = $("#filter_exam").val();
         if(filter_exam != null){
                load_data();
            }
    }


     // load_data();
     function load_data(){
            // var inputLength = $(this).val();
            // if (inputLength.length > 3) {

            var filter_exam = $("#filter_exam").val();
            var filter_course = $("#filter_course").val();
            if (filter_course != "" && filter_exam != "") {

            $(".loader").show();
            $.ajax({
                url:"<?php echo base_url(); ?>backoffice/Students/fetch",
                method:"POST",
                data:{filter_exam:$("#filter_exam").val(),filter_course:$("#filter_course").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data){
                    //  if(data!='') {
                    $('#result').html(data);
                    $("#hallticket_table").DataTable({
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
                                'bSortable': true,
                                'aTargets': [2]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [3]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [4]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [5]
                            }
                            ,
                            {
                                'bSortable': false,
                                'aTargets': [6]
                            }
                        ]
                    });
                // } 
                    $(".loader").hide();
                // }else{
                //     $("#export").remove();
                // }
            }
            })
         }
        }

        $('.filter_class').keyup(function(){
            get_load_data();
            // var inputLength = $(this).val();
            // if (inputLength.length >= 3) {
            //     // load_data();
            // }
        });
        $('.filter_change').change(function(){
            // alert("afa");
            get_load_data();
            // var inputLength = $(this).val();
            // if (inputLength.length >= 3) {
                // load_data();
            // }
        });
        $('.filter_class').bind('paste', function(e) {
            get_load_data();
            // var inputLength = $(this).val();
            // if (inputLength.length >= 3) {
            //     // load_data();
            // }
        });

        $('#reset_form').click(function() {
            window.location.href=window.location.href;
        });
        $('.selectedpaymonth').change(function(){
            trans_payment();
        });
} );


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
                            url: '<?php echo base_url();?>backoffice/Students/get_val',
                            type: 'POST',
                            data:{id: id,selectid: $("#status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
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

    // function get_exam() {
    //     $(".loader").show();
    //     $.ajax({
    //         url: '<?php echo base_url();?>backoffice/Students/get_exam',
    //         type: 'POST',
    //         data:{id: id,selectid: $("#status_"+id).val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
    //         success: function(response) {
    //             if (response == "1") {
    //                 $.alert('Successfully <strong>Changed..!</strong>');
    //             }
    //             $(".loader").hide();
    //         }
    //     });
                    
    // }

        function get_exam(){
            $("#filter_exam").html('');
            $(".loader").show();
            var filter_course = $('#filter_course').val();
            $(".loader").show();
			$.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_all_exam_details_cc', 
                type: 'POST',
                data: {filter_course:filter_course,selected:0,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $(".loader").hide();
                    if(response!='') {
                    $("#filter_exam").html(response);
                    } else {
                    }
                }
            });
    }
    $(document).ready(function () {
    $('.hidden').hide()
});
$('.transfeeclose').click(function () {
    $('#videoDiv').next().animate({
        width: 'toggle'
    }, "slow")
});

function loadpayscreen(student_id = NULL, st_id = NULL) { 
    $('#loadpaymentscreen').html('');
    $('#videoDiv').next().animate({
        width: 'toggle'
    }, "slow");
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/get_transportfee/'+student_id+'/'+st_id, 
        type: 'POST',
        data: {
        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response)
        { 
           $('#loadpaymentscreen').html(response);
            $(".loader").hide();
        }
    });
}


function trans_payment() { 
$(".loader").hide();
$('#loadtransfeesummary').html('');
$.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/trans_payment',
        type: 'POST',
        data: $("#recurringpayment").serialize(),
        success: function(response) {
            var obj=JSON.parse(response);
            if (obj.status) { 
                $('#loadtransfeesummary').html(obj.data);
                //$.toaster({priority:'danger',title:'INVALID',message:'Already Exist'});
            } else {
                $.toaster({priority:'danger',title:'INVALID',message:obj.message});
            }
                $(".loader").hide();
        }
        
    });
}

function trans_payment_process() { 
$(".loader").hide();
var student_id = $('#get_student_id').val();
var get_st_id = $('#get_st_id').val(); 
$.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/trans_payment_process',
        type: 'POST',
        data: $("#recurringpaymentprocees").serialize(),
        success: function(response) {
            var obj=JSON.parse(response);
            if (obj.status) { 
                $('#loadtransfeesummary').html('');
                loadpayscreen(student_id, get_st_id);
                $.toaster({priority:'success',title:'Success',message:obj.message});
                loadpayscreen(student_id, get_st_id);
            } else {
                $.toaster({priority:'danger',title:'INVALID',message:obj.message});
            }
                $(".loader").hide();
        }
        
    });
}

function download_receipt(id, inv_id = NULL, pay_id = 0){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Receipt/download_trans_receipt/'+id+'/'+inv_id+'/'+pay_id,
            type: 'POST',
            data: {
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    window.open(obj.url);
                    $(".loader").hide();
                }
                $(".loader").hide();
            }
        });
    }

    $("#applicationno").keyup(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var name = $('#filter_name').val();
        var mobileno = $('#mobileno').val();
        var route = $('#route').val();
        search_reset(applicationno, email, mobileno, name, route);
    }); 

    $("#filter_name").keyup(function(){
        var applicationno = $('#applicationno').val();
        var name = $('#filter_name').val();
        var email = $('#email').val();
        var mobileno = $('#mobileno').val();
        var route = $('#route').val();
        search_reset(applicationno, email, mobileno, name, route);
    }); 

    $("#email").keyup(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var name = $('#filter_name').val();
        var mobileno = $('#mobileno').val();
        var route = $('#route').val();
        search_reset(applicationno, email, mobileno, name, route);
    }); 

    $("#mobileno").keyup(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var name = $('#filter_name').val();
        var mobileno = $('#mobileno').val();
        var route = $('#route').val();
        search_reset(applicationno, email, mobileno, name, route);
    }); 

    $("#route").change(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var name = $('#filter_name').val();
        var mobileno = $('#mobileno').val();
        var route = $('#route').val();
        search_reset(applicationno, email, mobileno, name, route);
    }); 

    $("#searchbutton").click(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var name = $('#filter_name').val();
        var mobileno = $('#mobileno').val();
        var route = $('#route').val();
        search_reset(applicationno, email, mobileno, name, route);
    });  
    // $("#resetbutton").click(function(){
    //     $("#filter_form").trigger("reset");
    //     var applicationno = $('#applicationno').val();
    //     var email = $('#email').val();
    //     var name = $('#filter_name').val();
    //     var mobileno = $('#mobileno').val();
    //     var route = $('#route').val();
    //     search_reset(applicationno, email, mobileno, name, route);
    // });      
    function search_reset(applicationno = NULL, email = NULL, mobileno = NULL, name = NULL, route = NULL) {
        //$(".loader").show(); //alert(applicationno+'='+email+'='+mobileno);
        if(applicationno!='' || email!="" || mobileno!='' || name!='' || route != '') { 
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_student_trans_search',
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>','id':applicationno,'email':email,'mobileno':mobileno,'name':name,'route':route},
                success: function(response) {
                    if(response==0) {
                            //$.toaster({priority:'warning',title:'Warning',message:'No student available in batch'});
                            $("#institute_data").html('');
                            $('#institute_data').DataTable().destroy();
                                    $("#institute_data").DataTable({
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
                    } else {
                    $('#institute_data').DataTable().destroy();
                                    $("#institute_data").html(response);
                                    $("#institute_data").DataTable({
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
                }
            });  
        } else {
            $("#institute_data").html('');
                            $('#institute_data').DataTable().destroy();
                                    $("#institute_data").DataTable({
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
   } 



   function canceltrans() {
    $.confirm({
        title: 'Alert message',
        content: 'Do you want to cancel transportaion?',
        icon: 'fa fa-question-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Proceed',
                btnClass: 'btn-blue',
                action: function() { 
                    var student_id = $('#get_student_id').val();
                    var get_st_id = $('#get_st_id').val(); 
                    $.ajax({
                            url: '<?php echo base_url();?>backoffice/Transport/trans_canncel_process/'+student_id+'/'+get_st_id,
                            type: 'POST',
                            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                            success: function(response) {
                                var obj=JSON.parse(response);
                                if (obj.status) { 
                                    $('#loadtransfeesummary').html('');
                                    loadpayscreen(student_id, get_st_id);
                                    $.toaster({priority:'success',title:'Success',message:obj.message});
                                    loadpayscreen(student_id, get_st_id);
                                } else {
                                    $.toaster({priority:'danger',title:'INVALID',message:obj.message});
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
