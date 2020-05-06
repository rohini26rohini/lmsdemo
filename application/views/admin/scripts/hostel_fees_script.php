<script>
$(document).ready(function(){
    load_table_ajax();
    $(".add_new_btn").click(function(){
        $("#fee_heads").html('');
        $("#fee_heads_errors").html('');
    });
    $("#fee_def").change(function(){
        if($("#fee_def").val()!=''){
            get_fee_heads($("#fee_def").val())
        }else{
            $("#fee_heads").html('');
        }
    });
    $("form#add_edit_hostel_fees").validate({
        rules: {
            room_type: {
                required: true
            },
            mess_type: {
                required: true
            },
            fee_def: {
                required: true
            },
            fees: {
                required: true
            }
        },
        messages: {
            room_type: "Please Choose Room Type",
            mess_type: "Please Choose a Mess Type",
            fee_def: "Please select a fee definition",
            fees: "Please define a monthly fee"
        },
        submitHandler: function(form) {
            var values = $("input[name='feeamount[]']").map(function(){return $(this).val();}).get();
            var feeamount_error = 0;
            $.each(values,function(k,val){
                console.log(val);
                if(val == ''){
                    feeamount_error=1;
                }
            });
            if(feeamount_error==1){
                $("#fee_heads_errors").html('<span class="error">Some fields are empty</span>');
                return false;
            }
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/save_hostel_fees',
                type: 'POST',
                data: $("#add_edit_hostel_fees").serialize(),
                success: function(response) {
                    var obj=JSON.parse(response);
                    if(obj.st == 1){
                        $('#addEditHostelFeeModal').modal('toggle');
                        $.toaster({priority:'success',title:obj.message,message:''});
                        load_table_ajax();
                    }
                    if (obj.st == 2){
                        $.toaster({priority:'warning',title:obj.message,message:''});
                    }
                    $(".loader").hide();
                }
            });
        }
    });
});
function get_fee_heads(fee_def){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_fees_heads/'+$("#fee_def").val(),
        type: 'GET',
        success: function(response) {
            var html = '';
            var obj=JSON.parse(response);
            if(obj.st == 1){
                $.each(obj.data,function(k,val){
                    html += '<input type="hidden" class="form-control" name="feehead[]" value="'+val['ph_id']+'"/>';
                    html += '<div class="col-sm-6"><label>'+val['ph_head_name']+'<span class="req redbold">*</span></label><div class="form-group"><input required type="text" class="form-control" name="feeamount[]" onkeypress="return decimalNum(event)" value=""/></div></div>';
                });
                $("#fee_heads").html(html);
            }
            $(".loader").hide();
        }
    });
}
function load_table_ajax(){
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/load_hostelfee_ajax',
        type: "post",
        data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
        success: function(data) {
            $('#institute_data').DataTable().destroy();
            $("#institute_data").html(data);

            $("#institute_data").DataTable({
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
                        'bSortable': true,
                        'aTargets': [3]
                    },
                    {
                        'bSortable': true,
                        'aTargets': [4]
                    }
                    
                ]
            });
        }
    });
}
function get_feedata(id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_room_type_fees_details/'+id,
        type: 'GET',
        success: function(response) {
            var html = '';
            var obj=JSON.parse(response);
            var data = obj.data;
            if(obj.st == 1){
                $("#room_type").val(data.hostel_fees.room_type).prop('selected',true);
                $("#mess_type").val(data.hostel_fees.mess_type).prop('selected',true);
                $("#fee_def").val(data.hostel_fees.fee_def).prop('selected',true);
                $("#hostel_fee_id").val(data.hostel_fees.hostel_fee_id);
                $("#fees").val(data.hostel_fees.fees);
                $.each(data.hostel_fees_amount,function(k,val){
                    html += '<input type="hidden" class="form-control" name="feehead[]" value="'+val['ph_id']+'"/>';
                    html += '<div class="col-sm-6"><label>'+val['ph_head_name']+'<span class="req redbold">*</span></label><div class="form-group"><input required type="text" class="form-control" name="feeamount[]" onkeypress="return decimalNum(event)" value="'+val['amount']+'"/></div></div>';
                });
                $("#fee_heads").html(html);
                $("#fee_heads_errors").html('');
                $("#addEditHostelFeeModal").modal('show');
            }
            $(".loader").hide();
        }
    });
}
function view_feedata(id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Hostel/view_hostel_room_type_fees_details/'+id,
        type: 'GET',
        success: function(response) {
            var html = '';
            var obj=JSON.parse(response);
            var data = obj.data;
            if(obj.st == 1){
                var html = '';
                /** Room Type */
                if(data.hostel_fees.room_type==1){html += '<div class="form-group col-sm-4"><div class="title-header">Room Type</div><div class="title-body">Non-A/C</div></div>';}
                if(data.hostel_fees.room_type==2){html += '<div class="form-group col-sm-4"><div class="title-header">Room Type</div><div class="title-body">AC</div></div>';}
                if(data.hostel_fees.room_type==3){html += '<div class="form-group col-sm-4"><div class="title-header">Room Type</div><div class="title-body">Standard</div></div>';}
                /** Mess Type */
                if(data.hostel_fees.mess_type=='na'){html += '<div class="form-group col-sm-4"><div class="title-header">Mess Type</div><div class="title-body">NA</div></div>';}
                if(data.hostel_fees.mess_type=='veg'){html += '<div class="form-group col-sm-4"><div class="title-header">Mess Type</div><div class="title-body">Veg</div></div>';}
                if(data.hostel_fees.mess_type=='nonveg'){html += '<div class="form-group col-sm-4"><div class="title-header">Mess Type</div><div class="title-body">Non Veg</div></div>';}
                /** Monthly Fee */
                html += '<div class="form-group col-sm-4"><div class="title-header">Monthly Fee</div><div class="title-body">'+data.hostel_fees.fees+'</div></div>';
                if(data.hostel_fees_amount != ''){
                    $.each(data.hostel_fees_amount,function(k,val){
                        html += '<div class="form-group col-sm-4"><div class="title-header">'+val.ph_head_name+'</div><div class="title-body">'+val.amount+'</div></div>';
                    });
                }
                $("#view_hostel_fees").html(html);
                $("#viewHostelFees").modal('show');
            }
            $(".loader").hide();
        }
    });
}
/** Updated on 08-10-2019*/
/** Old Script */
 var counter=2;
   function addNew(){
       
        var markup = '';

        markup += '<tr id="row_' + counter + '">';
       
        markup += '<td> <div class="form-group form_zero"><select class="roomtype form-control" name="room-type[' + counter + ']" id="room-type_' + counter + '"><option  value=""><?php echo $this->lang->line('select_roomtype');?></option><?php if(!empty($roomTypeArr)){ foreach($roomTypeArr as $row){  ?><option value="<?php echo $row['roomtype_id']; ?>"><?php echo $row['room_type']; ?></option><?php } } ?></select></div></td>';
       
        markup += '<td> <div class="form-group form_zero"><select class="messtype form-control" name="mess-type[' + counter + ']" id="mess-type_' + counter + '"><option value=""><?php echo $this->lang->line('select_messtype');?></option><option  value="veg"><?php echo $this->lang->line('veg');?></option><option value="nonveg"><?php echo $this->lang->line('nonveg');?></option> </select></div></td>';
       
        markup += '<td> <input type="text" placeholder="Fees" class="fees form-control" name="fees[' + counter + ']" id="fees_' + counter + '"  value="" /></td>';

        markup += '<td data-title=""><button  class="btn btn-danger option_btn" id="removeButton' + counter + '" onclick="remove(' + counter + ');" title="Click here to remove this row" style="background-color:#c82333;color:#fff;"><i class="fa fa-remove "></i></button></td>';
        markup += '</tr>';

        $('#hostelfee_table > tbody').append(markup);
        
        counter++;
       
        validation();
     
   }
function remove(count)
    {
        $('#row_' + count).remove();
        return false; 
    }
    
    /* jQuery.validator.addClassRules("roomtype", {
        required: true
    });*/
     
     $("#add_hostel_fees").validate({
         
	  
	    submitHandler: function(form) {
             $(".loader").show();
            validation();
            
           $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_fees_add',
                type: 'POST',
                data: $("#add_hostel_fees").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_hostel_fees' ).each(function(){
                                        this.reset();
                                });
                          
                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_hostelfee_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

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
                                    }
                                   });
                        $.toaster({priority:'success',title:'Success',message:'Successfully added hostel Fee'});
                          
                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:'Please try again later'});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:'Data already exist'});
                    }                   
                    $(".loader").hide();
                }
                
            }); 
        }
	 });
	 
	//get hostel fee data by id
    function get_feedata1(id)
    {
       $(".loader").show();
       $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/get_hostelfee_byId',
                type: 'POST',
                data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                success: function(response) {
                    $(".loader").hide();
                    var obj = JSON.parse(response);
                    //alert(response);
                   // alert(obj['data'].hostel_fee_id);
                     $("#edit_id").val(obj['data'].hostel_fee_id);
                     $("#edit_roomtype").val(obj['data'].room_type);
                     $("#edit_messtype").val(obj['data'].mess_type);
                     $("#edit_fees").val(obj['data'].fees);
                     $('#editModal').modal({
                                    show: true
                                    });
                            
                     
                }
       });
    }

    
    //edit hostel fee
 $("form#edit_hostel_fees").validate({
        rules: {
            room_type: {
                required: true
            },
            messtype: {
                required: true
            },
            fees: {
                required: true
            }
        },
        messages: {
            room_type: "Please Choose Room Type",
            messtype: "Please Choose a Mess Type",
            fees: "Please Enter Fee Amount"
            

        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_fee_edit',
                type: 'POST',
                data: $("#edit_hostel_fees").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_hostel_fees' ).each(function(){
                                        this.reset();
                                });
                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_hostelfee_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

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
                                    }
                                   });
                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }
                    $(".loader").hide();
                }

            });


        }


    });
    
    //delete hostel fee
     
    function delete_hostelfee(id)
    {

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
                                    url: '<?php echo base_url();?>backoffice/Hostel/delete_hostelfee',
                                    type: 'POST',
                                    data: {
                                        /**/id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                            

                                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_hostelfee_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

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
                                    }
                                   });
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                        } 
                                                else {
                                            
                                            $.toaster({priority:'warning',title:'Invalid',message:obj.message});
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


    function validation() {
        
    $('.roomtype').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: "Please Choose Room Type"

            }
        });
    });
    $('.messtype').each(function() {
        $(this).rules('add', {
            required: true,


            messages: {
                required: "Please Choose Mess Type",

            }
        });
    });
    $('.fees').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,

            messages: {
                required: " Please Enter the Fee Amount",
                number: "Please Enter Numbers only",
            }
        });
    });

}
    validation();

    function decimalnum(e) {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
               this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        }

</script>
