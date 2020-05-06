<script>
    $(document).ready(function(){
        $("#transfer").on('click', function(){
            $.confirm({
                title: 'Alert message',
                content: 'Do you want to merge.?',
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
                            var fbatch = $('#fbatch').val();
                            var tbatch = $('#tbatch').val();
                            var students =$("input[name='students[]']:checked").map(function(){return $(this).val();}).get();
                            if(fbatch != '' && tbatch != '') {
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Home/merge_batch',
                                    type: 'POST',
                                    data: {
                                            fbatch:fbatch,
                                            tbatch:tbatch,
                                            students:students,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                    success: function(response) { 
                                        $(".loader").hide();
                                        var obj = JSON.parse(response);
                                        if(obj.st == 1){
                                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                                            $('#fbatch').val("");
                                            $('#tbatch').val("");
                                            $('#studentListWapper').html('');
                                        }else if(obj.st == 2){
                                            $.toaster({priority:'warning',title:'Error',message:obj.msg});
                                        }else{ 
                                            $.toaster({priority:'danger',title:'warning',message:obj.msg});
                                        }
                                    }
                                });
                            }else{ 
                                $(".loader").hide();
                                $.toaster({priority:'danger',title:'warning',message:"Please choose all mandatory fields.!"});
                            }
                        }
                    },
                    cancel: function() {
                    },
                }
            });
        });
    });
    $("#fbatch").on('change', function(){
        var fbatch = $(this).val();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Home/get_fbatchStudents',
            type: 'POST',
            data: {
                    fbatch:fbatch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
            success: function(response) { 
                $('#studentListWapper').html(response);
            }
        });
    });
</script>