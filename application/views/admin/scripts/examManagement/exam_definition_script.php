<script type="text/javascript">

$(document).ready(function(){
    $("#evaluate_data").dataTable({
        aaSorting: [[0, 'asc']],
        pageLength : 10,
        // bFilter: false,
        // bInfo: false,
        bSortable: true,
        bRetrieve: true,
        aoColumnDefs: [
            { "aTargets": [ 0 ], "bSortable": true },
            { "aTargets": [ 1 ], "bSortable": true },
            { "aTargets": [ 2 ], "bSortable": true },
            { "aTargets": [ 3 ], "bSortable": true },
            { "aTargets": [ 4 ], "bSortable": true },
            { "aTargets": [ 5 ], "bSortable": true },
            { "aTargets": [ 6 ], "bSortable": false }
        ]
    }); 

    $(".noofsections").hide();
    $("#sections").html('');

    $("#examtype").change(function(){
        if($("#examtype").val()==2 || $("#examtype").val()==3){
            $(".noofsections").show();
            $("#noofsections").val('');
            $("#sections").html('');
        }
        if($("#examtype").val()==1){
            $(".noofsections").hide();
            $("#noofsections").val(1);
            var html = generate_sections(1);
            $("#sections").html(html);
        }
        if($("#examtype").val()==''){
            $(".noofsections").hide();
            $("#noofsections").val('');
            $("#sections").html('');
        }
    });
    
    $("#noofsections").on('keyup', function(){
        if($(this).val()){
            var html = generate_sections($(this).val());
            $("#sections").html(html);
        }
    });

    $("#examdefine").validate({
        rules: {
            examname: "required",
            examduration: "required",
            examtype: "required"
        },
        messages: {
            examname: "Please enter an exam name",
            examduration: "Please enter an exam duration",
            examtype: "Please select a exam type"
        },
        submitHandler: function (form) {

            $(".loader").show();
            var validation = 1;
            if($("#examtype").val()!=''){
                if(!$("#noofsections").val()){
                    $.toaster({priority:'danger',title:'Error',message:'Please enter the number of sections'});
                    validation = 0;
                    $(".loader").hide();
                    return false;
                }else{
                    var sectionnames = $("input[name='sections[]']").map(function(){return $(this).val();}).get();
                    var presectionnames = $("select[name='presection[]']").map(function(){return $(this).val();}).get();
                    $.each(sectionnames,function(i,v){
                        k = i+1;
                        if($.trim(v)==''){
                            $.toaster({priority:'danger',title:'Error',message:'Please enter the name of section-'+k});
                            validation = 0;
                            $(".loader").hide();
                            return false;
                        }
                        if($.trim(presectionnames[i])==''){
                            $.toaster({priority:'danger',title:'Error',message:'Please select a predefined section for section-'+k});
                            validation = 0;
                            $(".loader").hide();
                            return false;
                        }
                    });
                }
            }
            
            if(validation){
                $('.btn_save').prop('disabled', true);
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/save_exam_description'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $('#examdefine').trigger('reset');
                            $.toaster({priority:'success',title:'Message',message:obj.message});
                            setTimeout(function(){
                                redirect('backoffice/exam/define_exam_sections?id='+obj.data); 
                            },2000);
                        }else{
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'danger',title:obj.message,message:''});
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $('.btn_save').prop('disabled', false);
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        $(".loader").hide();
                    }
                    //Your code for AJAX Ends
                });
            }
        }

    });

});

    function generate_sections(limit){
        var html = '';
        var i=1;
        if(limit){
            while(i<=limit){
                html = html+'<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">'+
                                '<div class="form-group">'+
                                    '<label>Section-'+i+' Name</label>'+
                                    '<input placeholder="Section name" type="text" class="form-control" name="sections[]"/>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">'+
                                '<div class="form-group">'+
                                    '<label>Select a pre defined section template</label>'+
                                    '<select class="form-control" name="presection[]">'+
                                        '<option value="">Select a pre defined section template</option>'+
                                    <?php if(!empty($sections)){ foreach($sections as $row){ ?>
                                        '<option value="<?php echo $row->id; ?>"><?php echo $row->section_name; ?></option>'+
                                    <?php }}?>
                                    '</select>'+
                                '</div>'+
                            '</div>';
                i++;
            }
        }
        return html;
    }

    function edit_exam(id){
        redirect('backoffice/exam/define_exam_sections?id='+id); 
    }

    function delete_exam(id){
        $.confirm({
                title: 'Warning',
                content:'Do you want to delete this exam model?<br>Adding exam papers or scheduling exams based on this exam model will be blocked',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Delete',
                        btnClass: 'btn-blue',
                        action: function() {
                            $(".loader").show();
                            $.post('<?php echo base_url();?>backoffice/exam/delete_exam_paper/', {
                                exam_id: id,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }, function(data) {
                                var obj=JSON.parse(data);
                                if (obj['st'] == true) {
                                    $("#exam"+id).remove();
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                }else{
                                    $.alert('<strong>Invalid Request</strong>');  
                                }
                                $(".loader").hide();
                            });
                        }
                    },
                    cancel: function() { },
                }
        });
    }

    function resetform(){
        $('#examdefine').trigger('reset');
        $(".noofsections").hide();
        $("#noofsections").val('');
        $("#sections").html('');
    }
</script>
     
