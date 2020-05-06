<script>
    function load_student_ajax(){
        var student_list = localStorage.getItem("student_list");
        if(student_list!='' && student_list!=null){
            student_list = JSON.parse(student_list);
        }
        if(student_list!='' && student_list!=null && (Date.now()-student_list['timestamp'])<300000){
            build_student_list(student_list['data']);
        }else{
            setTimeout(function(){$(".loader").show();}, 150);
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/load_student_ajax',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    localStorage.setItem("student_list", JSON.stringify({'timestamp':Date.now(),'data':response}));  
                    build_student_list(response);
                    $(".loader").hide();
                } 
            }); 
        }
    }
    function build_student_list(student_list){
        $('#studentlist_table').DataTable().destroy();
        $("#studentlist_table").html(student_list);
        $("#studentlist_table").DataTable({
            "searching": true,
            "bPaginate": true,
            "bInfo": true,
            "pageLength": 10,
            "aoColumnDefs": [
                {
                    'bSortable': true,
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
                },
                {
                    'bSortable': false,
                    'aTargets': [8]
                }
            ]
        });    
    }
    $("#status_change").change(function(){
      var status= $("#status_change").val();
        
        if(status == "5")
            {
                //alert(status);
                $("#show_desc").css("display","block");
            }
        else{
             $("#show_desc").css("display","none");
            }
        
    });
    
    function change_student_status(id)
    {
          $('#myModal').modal('toggle');
          $("#status_id").val(id);
    }
 $("form#add_form").validate({
        rules: {
           status: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            status: "Please Choose a status",
            description: "Please Enter the  Reason"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/status_change_student',
                type: 'POST',
                data: $("#add_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_form' ).each(function(){
                                        this.reset();
                                });
                          $.toaster({priority:'success',title:'Success',message:obj.msg});
                          load_student_ajax();
                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.msg});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'success',title:'Notice',message:obj.msg});
                    }
                    $(".loader").hide();
                }

            });


        }


    });


    var searchRequest = null;
    $(function () {
    var minlength = 3;
        //reg num
         $("#filter_regnum").keyup(function(){

            var that=this,
                value=$(this).val();

            if (value.length >= minlength && value!="")
            {
                if (searchRequest != null)
                    searchRequest.abort();
                    searchRequest = $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>backoffice/Students/search_students/',
                    data: {
                        'registration_number' : value,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    dataType: "text",
                   success: function(response){

                        //var obj=JSON.parse(msg);
                       
                        //$("#students_data").html(obj['html']);
                            
                                           
                                        $('#studentlist_table').DataTable().destroy();
                                        $("#studentlist_table").html(response);

                                        $("#studentlist_table").DataTable({
                                            "searching": false,
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                   
                        }
                    });
           }
        });
        //name
        $("#filter_name").keyup(function(){

            var that=this,
                value=$(this).val();

            if (value.length >= minlength && value!="")
            {
                if (searchRequest != null)
                    searchRequest.abort();
                    searchRequest = $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>backoffice/Students/search_students/',
                    data: {
                        'name' : value,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    dataType: "text",
                    success: function(response){

                        //var obj=JSON.parse(msg);
                       
                        //$("#students_data").html(obj['html']);
                            
                                           
                                        $('#studentlist_table').DataTable().destroy();
                                        $("#studentlist_table").html(response);

                                        $("#studentlist_table").DataTable({
                                            "searching": false,
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                   
                        }
                    });
           }
        });
        //email
        $("#filter_email").keyup(function(){

            var that=this,
                value=$(this).val();

            if (value.length >= minlength && value!="")
            {
                if (searchRequest != null)
                    searchRequest.abort();
                    searchRequest = $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>backoffice/Students/search_students/',
                    data: {
                        'email' : value,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    dataType: "text",
                    success: function(response){

                        //var obj=JSON.parse(msg);
                       
                        //$("#students_data").html(obj['html']);
                            
                                           
                                        $('#studentlist_table').DataTable().destroy();
                                        $("#studentlist_table").html(response);

                                        $("#studentlist_table").DataTable({
                                            "searching": false,
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                   
                        }
                    });
           }
        });
        $("#filter_number").keyup(function(){

            var that=this,
                value=$(this).val();

            if (value.length >= minlength && value!="")
            {
                if (searchRequest != null)
                    searchRequest.abort();
                    searchRequest = $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>backoffice/Students/search_students/',
                    data: {
                        'contact_number' : value,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    dataType: "text",
                    success: function(response){

                        //var obj=JSON.parse(msg);
                       
                        //$("#students_data").html(obj['html']);
                            
                                           
                                        $('#studentlist_table').DataTable().destroy();
                                        $("#studentlist_table").html(response);

                                        $("#studentlist_table").DataTable({
                                            "searching": false,
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                   
                        }
                    });
           }
        });
        //location
        $("#filter_location").keyup(function(){

            var that=this,
                value=$(this).val();

            if (value.length >= minlength && value!="")
            {
                if (searchRequest != null)
                    searchRequest.abort();
                    searchRequest = $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>backoffice/Students/search_students/',
                    data: {
                        'street' : value,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    dataType: "text",
                    success: function(response){

                        //var obj=JSON.parse(msg);
                       
                        //$("#students_data").html(obj['html']);
                            
                                           
                                        $('#studentlist_table').DataTable().destroy();
                                        $("#studentlist_table").html(response);

                                        $("#studentlist_table").DataTable({
                                            "searching": false,
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
        });
    });
    
//pagination
$(document).ready(function() {
    // $('#studentlist_table').DataTable( {
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
    //         "url": "<?php echo base_url();?>backoffice/Students/student_list_pagination",
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

        $('#studentlist_table').dataTable({
            pageLength : 10,
            aaSorting: [[0, 'asc']],
            bFilter: false,
            bInfo: false,
            bSortable: true,
            bRetrieve: true,
            infoEmpty: "No records available.",
            aoColumnDefs: [
                { "aTargets": [ 0 ], "bSortable": true },
                { "aTargets": [ 1 ], "bSortable": true },
                { "aTargets": [ 2 ], "bSortable": true },
                { "aTargets": [ 3 ], "bSortable": true },
                { "aTargets": [ 4 ], "bSortable": true },
                { "aTargets": [ 5 ], "bSortable": true },
                { "aTargets": [ 6 ], "bSortable": true },
                { "aTargets": [ 7 ], "bSortable": true },
                { "aTargets": [ 8 ], "bSortable": false }
            ]
        }); 

        $('#hallticket_table').dataTable({
            pageLength : 10,
            aaSorting: [[0, 'asc']],
            bFilter: false,
            bInfo: false,
            bSortable: true,
            bRetrieve: true,
            infoEmpty: "No records available.",
            aoColumnDefs: [
                { "aTargets": [ 0 ], "bSortable": true },
                { "aTargets": [ 1 ], "bSortable": true },
                { "aTargets": [ 2 ], "bSortable": true },
                { "aTargets": [ 3 ], "bSortable": true },
                { "aTargets": [ 4 ], "bSortable": true },
                { "aTargets": [ 5 ], "bSortable": true },
                { "aTargets": [ 6 ], "bSortable": true }
            ]
        }); 


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


     load_data();
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

    load_student_ajax();
</script>
