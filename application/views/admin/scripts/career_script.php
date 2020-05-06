<script>
CKEDITOR.replace('job_description');
CKEDITOR.replace('edit_job_description');
    $(document).ready(function(){
        var add_validation = 0;
        $("form#career_form").validate({
            rules: {
                name: {
                    required: true,
                    remote: {
                                url: '<?php echo base_url();?>backoffice/Content/careerNamecheck',
                                type: 'POST',
                                data: {
                                name: function() {
                                      return $("#name").val();
                                      },
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    }
                            }
                },
                location: {required: true},
                career_date: {required: true},
                eligibility: {required: true},
                base_salary_from: {required: true},
                base_salary_to: {required: true},
                experience_from: {required: true},
                experience_to: {required: true},
                employment_type: {required: true}
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    remote:"This career already exist"
                },
                location: {required: "Please select a location"},
                career_date: {required: "Please select a career last date"},
                eligibility: {required: "Please select a eligibility"},
                base_salary_from: {required: "Please select a initial base salary"},
                base_salary_to: {required: "Please select a final base salary"},
                experience_from: {required: "Please select a final base salary"},
                experience_to: {required: "Please select a final base salary"},
                employment_type: {required: "Please select a employment type"}
                
            }
            ,
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                var sfrom = parseInt($("#base_salary_from").val());
                var sto = parseInt($("#base_salary_to").val());
                if(sfrom >= sto){
                    add_validation = 0;
                    $.toaster({priority:'danger',title:'Invalid',message:"Base salary maximum should be grater than minimum"});
                    // alert("dddd");
                    $(".loader").hide();
                }
                var efrom = parseInt($("#experience_from").val());
                var eto = parseInt($("#experience_to").val());
                if(efrom >= eto){
                    add_validation = 0;
                    $.toaster({priority:'danger',title:'Invalid',message:"Experience maximum should be grater than minimum"});
                    // alert("qqqqq");
                    $(".loader").hide();
                }
            }
        });
        $("form#career_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            //add the content
            data.append('job_description', CKEDITOR.instances['job_description'].getData());
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/career_add',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        add_validation = 0;
                        // alert(response);
                        $('#add_career').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_career_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(response);
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });    
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                        }else{
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                contentType: false,
                processData: false
                });
            }
        });
        var edit_validation = 0;
        $("form#edit_career_form").validate({
            rules: {
                name: {
                    required: true,
                    remote: {
                                url: '<?php echo base_url();?>backoffice/Content/careerNamecheck_edit',
                                type: 'POST',
                                data: {
                                name: function() {
                                      return $("#edit_name").val();
                                      },
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    }
                            }
                },
                location: {required: true},
                career_date: {required: true},
                eligibility: {required: true},
                base_salary_from: {required: true},
                base_salary_to: {required: true},
                experience_from: {required: true},
                experience_to: {required: true},
                employment_type: {required: true}
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    remote:"This career already exist"
                },
                location: {required: "Please select a location"},
                career_date: {required: "Please select a career last date"},
                eligibility: {required: "Please select a eligibility"},
                base_salary_from: {required: "Please select a initial base salary"},
                base_salary_to: {required: "Please select a final base salary"},
                experience_from: {required: "Please select a final base salary"},
                experience_to: {required: "Please select a final base salary"},
                employment_type: {required: "Please select a employment type"}
                
            }
            ,
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                var esfrom = parseInt($("#edit_base_salary_from").val());
                var esto = parseInt($("#edit_base_salary_to").val());
                if(esfrom >= esto){
                    edit_validation = 0;
                    $.toaster({priority:'danger',title:'Invalid',message:"Base salary maximum should be grater than minimum"});
                    // alert("dddd");
                    $(".loader").hide();
                }
                var eefrom = parseInt($("#edit_experience_from").val());
                var eeto = parseInt($("#edit_experience_to").val());
                if(eefrom >= eeto){
                    edit_validation = 0;
                    $.toaster({priority:'danger',title:'Invalid',message:"Experience maximum should be grater than minimum"});
                    // alert("qqqqq");
                    $(".loader").hide();
                }
            }
        });
        $("form#edit_career_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            //add the content
            data.append('job_description', CKEDITOR.instances['edit_job_description'].getData());
            if (edit_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/career_edit',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        edit_validation = 0;
                        $('#edit_career').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_career_ajaxExtra/'+id,
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    var obj1 = JSON.parse(response); 
                                    $('#careers_'+id).html(obj1.careers); 
                                    $('#location_'+id).html(obj1.location); 
                                    $('#date_'+id).html(obj1.date); 
                                    $('#employment_type_'+id).html(obj1.employment_type); 
                                    $('#status_'+id).html(obj1.status); 
                                    $('#action_'+id).html(obj1.action); 
                                    $(".loader").hide();
                                } 
                            });
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                        }else{
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
    });

    function delete_career_Data(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this Information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>backoffice/Content/career_delete/', { 
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});
                                    $('#row_'+id).empty();  
                                }else{
                                    $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
var baseUrl = '<?php echo base_url(); ?>';
    function get_career_Data(id){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_career_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#id").val(obj.careers_id);
                $("#edit_name").val(obj.careers_name);
                $("#edit_location").val(obj.careers_location);
                $("#edit_career_date").val(obj.careers_date);
                $("#edit_eligibility").val(obj.careers_eligibility);
                // alert(obj.careers_experience);
                var base = obj.careers_base_salary.split('-');
                $("#edit_base_salary_from").val(base[0]);
                $("#edit_base_salary_to").val(base[1]);
                var exp = obj.careers_experience.split('-');
                $("#edit_experience_from").val(exp[0]);
                $("#edit_experience_to").val(exp[1]);
                $("#edit_employment_type").val(obj.careers_employment_type);
                CKEDITOR.instances['edit_job_description'].setData(obj.careers_job_description);
                $('#edit_career').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }
    function edit_career_status(id, status) {
        // alert(id);
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>backoffice/Content/edit_career_status/', {
                            id: id,status: status,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            $.toaster({priority:'success',title:'Success',message:'Status changed successfuly.!'});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_career_ajaxExtra/'+id,
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    var obj1 = JSON.parse(response); 
                                    $('#careers_'+id).html(obj1.careers); 
                                    $('#location_'+id).html(obj1.location); 
                                    $('#date_'+id).html(obj1.date); 
                                    $('#employment_type_'+id).html(obj1.employment_type); 
                                    $('#status_'+id).html(obj1.status); 
                                    $('#action_'+id).html(obj1.action); 
                                    $(".loader").hide();
                                } 
                            });  
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
//------------------------------------------Success Stories-------------------------------------------//
</script>