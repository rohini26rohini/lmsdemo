<script>

    $("#installmentnosdiv").hide();

    $("#group").change(function(){
        var group = $('#group').val();
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
                        $("#branch").html(response);
                    $(".loader").hide();
                    }
                });
            
        }
    });
    
    
    $("#branch").change(function(){
        var branch = $('#branch').val();
        
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
                    $("#center").html(response);
                    $(".loader").hide();
                }
            });
             
        }
        else{
            $("#edit_div").css("display","none");
        }
    });
    
     $("#center").change(function(){
        var center = $('#center').val();
        
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
                    $("#courses").html(response);
                    $(".loader").hide();
                }
            });
            
        }
        else{
            $("#edit_div").css("display","none");
        }
    });
    

    $("#fee_definition").change(function(){
        if($('#fee_definition').val() !=""){
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_fee_heads',
                type: 'POST',
                data: {
                    fee_definition: $('#fee_definition').val(),
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#fee_heads_container").html('');
                    var obj=JSON.parse(response);
                    if(obj.status){
                        create_fee_heads_fields(obj.data);
                    }
                    $(".loader").hide();
                }
            });
        }else{
            $("#fee_heads_container").html('');
        }
    });

    function create_fee_heads_fields(data){
        if(data != ''){
            var html = '';
            $.each(data,function(i,v){
                html += '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">'+
                            '<div class="form-group"><label>'+v.name+'<span class="req redbold">*</span></label>'+
                                '<input class="form-control" onkeypress="return decimalNum(event)" type="text" name="heads[]" placeholder="Amount" value="'+v.value+'">'+
                                '<input type="hidden" name="head_ids[]" value="'+v.id+'">'+
                            '</div>'+
                        '</div>';
            });
            $("#fee_heads_container").html(html);
        }
    }
    
    $("form#institute_course_formadd").validate({
        rules: {
            group_master_id: {
                required: true
            },
            branch_master_id: {
                required: true
            },
            institute_master_id: {
                required: true
            },
            course_master_id: {
                required: true
            },
            // course_tuitionfee: {
            //     required: true,
            //     number: true
            // },
            course_paymentmethod: {
                required: true
            },
            fee_definition: {
                required: true
            }
        },
        messages: {
            group_master_id: "Please Choose a Group",
            branch_master_id: "Please Choose a Branch",
            institute_master_id: "Please Choose a Centre",
            course_master_id: "Please Choose a Course",
            // course_tuitionfee: "Please enter the tuition fee",
            course_paymentmethod: "Please select an payment method",
            fee_definition: "Please select a fee definition"
        },

        submitHandler: function(form) {
            $(".loader").show();
            validation=1;
            var heads = $("input[name='heads[]']").map(function(){return $(this).val();}).get();
            var totalheadfee = 0;
            $.each(heads,function(i,v){
                totalheadfee=totalheadfee+parseFloat(v);
                if($.trim(v)==''){
                    $.toaster({priority:'danger',title:'Error',message:'Some fee definition heads are empty'});
                    $(".loader").hide();
                    validation=0;
                    return false;
                }
            });
            if($('#paymentmethod').val()=='installment'){
                var amount = 0;
                if($('#installmentnos').val() != ''){
                    var installment = $("input[name='installment[]']").map(function(){return $(this).val();}).get();
                    /*var duedate = $("input[name='duedate[]']").map(function(){return $(this).val();}).get();*/
                    $.each(installment,function(i,v){
                        if($.trim(v)==''){
                            $.toaster({priority:'danger',title:'Error',message:'Some installment fields are empty'});
                            $(".loader").hide();
                            validation=0;
                            return false;
                        }
                       /* if($.trim(duedate[i])==''){
                            $.toaster({priority:'danger',title:'Error',message:'Some due date fields are empty'});
                            $(".loader").hide();
                            validation=0;
                            return false;
                        }*/
                        amount=amount+parseFloat(v);
                    });
                    if(validation){
                        // if(amount!=parseFloat($("#totalfee").val())){
                        if(amount!=totalheadfee){
                            $.toaster({priority:'danger',title:'Error',message:'Sum of installments does not match with total fee heads'});
                            $(".loader").hide();
                            validation=0;
                            return false;
                        }
                    }
                }else{
                    $(".loader").hide();
                    $.toaster({ priority : 'danger', title : 'Error', message : "Please specify number of installments"});
                    validation=0;
                    return false;
                }
            }
            if(validation){
                enable_fields();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Courses/institute_course_add_mapping',
                    type: 'POST',
                    data: $("#institute_course_formadd").serialize(),
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({ priority : 'success', title : 'Notice', message :obj.message  });
                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_institutecoursemap_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {   
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);
                                        $("#institute_data").DataTable({
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                            $('#myModal').modal('hide');
                        }else{
                            $.toaster({ priority : 'danger', title : 'Error', message :obj.message  });
                        }
                        $(".loader").hide();
                    }
                });
                if($("#fee_renew").val()==1){
                    disable_fields();
                }
            }
        }
    });
  
    function edit_mapping(id)
    {
        $(".loader").show();
        $('#insticentremappsave').show();
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_institutecourse_mapping_byid',
            type: 'POST',
            data: {institute_course_mapping_id:id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj=JSON.parse(response);
                clear_id();
                $("#mapping_id").val(obj.institute_course_mapping_id);
                $("#group").val(obj.group_master_id);
                $("#branch").html(obj['branch']);
                $("#branch").val(obj.branch_master_id);
                $("#center").html(obj['center']);
                $("#center").val(obj.institute_master_id);
                $("#course").val(obj.course_master_id);
                $("#fee_definition").val(obj.fee_definition_id).prop("selected","selected");
                create_fee_heads_fields(obj.fee_definitions)
                $("#cgst").val(obj.course_cgst);
                $("#sgst").val(obj.course_sgst);
                $("#totalfee").val(obj.course_totalfee);
                $("#tuition_fee").val(obj.course_tuitionfee);
                $("#paymentmethod").val(obj.course_paymentmethod).prop("selected","selected");
                if(obj.course_paymentmethod == 'installment'){
                    $("#installmentnos").val(obj.installmentnos);
                    create_installments(obj.installments);
                    $("#installmentnosdiv").show();
                    $("#installments").show();
                }else{
                    $("#installmentnosdiv").hide();
                    $("#installments").html('');
                }
                $('#myModal').modal('show');
                if(obj.save==1) {
                    $('#insticentremappsave').hide();
                }
                $(".loader").hide();
            }
        });
    }
    
    
function view_mapping(id)
    {
        $("#installmentload").empty();
        $(".loader").show();
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_institutecourse_mapping_view',
            type: 'POST',
            data: {institute_course_mapping_id:id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj=JSON.parse(response);
                clear_id();
                $("#cessrow").show(); 
                $("#branch_view").html(obj['branch']);
                $("#center_view").html(obj.center);
                $("#course_view").html(obj['course']);
                $("#cgst_fee_view").html(obj.course_cgst);
                $("#sgst_fee_view").html(obj.course_sgst);
                $("#cess_fee_view").html(obj.course_cess);
                if(obj.cess>0) {
                $("#cess_fee_val").html(obj.cess+'%');
                } else {
                $("#cessrow").hide();    
                }
                $("#total_fee_view").html(obj.course_totalfee);
                $("#tuition_fee_view").html(obj.course_tuitionfee);
                $("#mode_fee_view").html(obj.course_paymentmethod);
                $("#installmentload").html(obj.installments);
                $(".loader").hide();
            }
        });
    }

    function renew_fee(id)
    {
        $(".loader").show();
        $('#insticentremappsave').show();
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_institutecourse_mapping_byid',
            type: 'POST',
            data: {institute_course_mapping_id:id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj=JSON.parse(response);
                clear_id();
                $("#mapping_id").val(obj.institute_course_mapping_id);
                $("#fee_renew").val(obj.institute_course_mapping_id);
                $("#group").val(obj.group_master_id);
                $("#branch").html(obj['branch']);
                $("#branch").val(obj.branch_master_id);
                $("#center").html(obj['center']);
                $("#center").val(obj.institute_master_id);
                $("#course").val(obj.course_master_id);
                
                disable_fields();

                $("#cgst").val(obj.course_cgst);
                $("#sgst").val(obj.course_sgst);
                $("#totalfee").val(obj.course_totalfee);
                $("#tuition_fee").val(obj.course_tuitionfee);
                $("#paymentmethod").val(obj.course_paymentmethod).prop("selected","selected");
                if(obj.course_paymentmethod == 'installment'){
                    $("#installmentnos").val(obj.installmentnos);
                    create_installments(obj.installments);
                    $("#installmentnosdiv").show();
                    $("#installments").show();
                }else{
                    $("#installmentnosdiv").hide();
                    $("#installments").html('');
                }
                $('#myModal').modal('show');
                $(".loader").hide();
            }
        });
    }

    function create_installments(installmentCost){
        var htmlcontent = '';
        if(installmentCost != '' ){
            $.each(installmentCost, function(i,v) {
                var iNum = parseFloat(v.installment_amount).toFixed(2);
                htmlcontent += '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">'+
                                        '<div class="form-group"><label>Installment '+(i+1)+'<span class="req redbold">*</span></label>'+
                                            '<input class="form-control " onkeypress="return decimalNum(event)" type="text" name="installment[]" placeholder="Amount" value="'+iNum+'">'+
                                        '</div>'+
                                    '</div>';
                
            });
            $("#installments").html(htmlcontent);
            $('.calendarclass').datetimepicker({
                  format:'DD-MM-YYYY',
                  useCurrent:false
            });
        }
    }

    function clear_id()
    {
        $("#institute_course_formadd").trigger("reset");
        $("#mapping_id").val("");
        $("#installments").html("");
        $("#fee_heads_container").html('');
        $("#installmentnosdiv").hide();
        $("#installments").hide();
        enable_fields();
    }

    function enable_fields(){
        $("#group").prop("disabled",false);
        $("#branch").prop("disabled",false);
        $("#center").prop("disabled",false);
        $("#course").prop("disabled",false);
    }

    function disable_fields(){
        $("#group").prop("disabled",true);
        $("#branch").prop("disabled",true);
        $("#center").prop("disabled",true);
        $("#course").prop("disabled",true);
    }

    $(window).on('load', function() {
        var group = $('#group').val(); 
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
                        $("#branch").html(response);
                    $(".loader").hide();
                    }
                });
            
        }
    });


$("#tuition_fee").on("keyup", function() {
    var cgst = <?php echo $config['CGST'];?>;
    var sgst = <?php echo $config['SGST'];?>;
    var tuition_fee = $("#tuition_fee").val();
    var cgstamount = 0;
    var sgstamount = 0;
    var totalamount = 0;
    if(tuition_fee != ""){
        cgstamount = parseFloat(tuition_fee*(cgst/100));
        sgstamount = parseFloat(tuition_fee*(sgst/100));
        totalamount = parseFloat(tuition_fee) + parseFloat(cgstamount) + parseFloat(sgstamount);
    }
    $("#cgst").val(cgstamount);
    $("#sgst").val(sgstamount);
    $("#totalfee").val(totalamount);
    if($("#paymentmethod").val()=='installment'){
        create_installment_add();
    }
});

$("#paymentmethod").on("change", function() {
    if($("#paymentmethod").val() == 'installment'){
        $("#installmentnosdiv").show();
        $("#installments").show();
    }else{
        $("#installmentnosdiv").hide();
        $("#installments").hide();
        $("#installments").html("");
        $("#installmentnos").val("");
    }
});

$("#installmentnos").on("keyup", function() {
    create_installment_add();
});

function create_installment_add(){
    var installmentnos = $("#installmentnos").val();
    // var tuition_fee = $("#totalfee").val();
    var installmentCost = 0;
    // if((tuition_fee != 0) && (tuition_fee!='')){
    //     var installmentCost = parseFloat(tuition_fee/installmentnos).toFixed(2);
    // }
    var i = 1;
    var htmlcontent = '';
    if(installmentnos != '' ){
        while(installmentnos >= i){
            htmlcontent += '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">'+
                                    '<div class="form-group"><label>Installment '+i+'<span class="req redbold">*</span></label>'+
                                        '<input class="form-control " onkeypress="return decimalNum(event)" type="text" name="installment[]" placeholder="Amount" value="'+installmentCost+'">'+
                                    '</div>'+
                                '</div>';
            i++;
        }
        $("#installments").html(htmlcontent);
        $('.calendarclass').datetimepicker({
            format:'DD-MM-YYYY',
            useCurrent:false
        });
    }
}

function delete_mapping(id){
    $.confirm({
            title: 'Alert',
            content: 'Do you want to remove this course from this institute?',
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
                                url: '<?php echo base_url();?>backoffice/courses/delete_institute_course_mapping',
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

    
</script>
