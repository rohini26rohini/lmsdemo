<script>
    $(document).ready(function(){
        var add_validation = 0;
        $("form#spl_form").validate({
            rules: {
                keyword1: {required: true,
                            maxlength: 53},
                keyword2: {required: true,
                            maxlength: 53},
                keyword3: {required: true,
                            maxlength: 53},
                keyword4: {required: true,
                            maxlength: 53},
                keyword5: {required: true,
                            maxlength: 53},
                keyword6: {required: true,
                            maxlength: 53},
                keyword7: {required: true,
                            maxlength: 53},
                keyword8: {required: true,
                            maxlength: 53},
                keyword9: {required: true,
                            maxlength: 53},
                keyword10: {required: true,
                            maxlength: 53}
               
            },
            messages: {
                keyword1: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword2: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword3: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword4: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword5: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword6: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword7: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword8: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword9: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"},
                keyword10: {required: "Please enter a keyword",
                            maxlength:"Character length upto 53"}
            }
            ,
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
            }
        });
        $("form#spl_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/update_keywords',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        add_validation = 0;
                        // alert(response);
                        $('#add_career').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
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

    function change_special(id) {
        if(id != 0){
            $(".loader").show();
            $("#keywords").empty();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_spl_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    $("#keywords").html(response);
                    $(".loader").hide();
                }
            });
        }else{
            $("#keywords").html('No Keywords');
            $(".loader").hide();
        }
    }
var baseUrl = '<?php echo base_url(); ?>';
</script>