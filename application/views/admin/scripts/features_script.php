<script>

function check_all_view(){
    var status="";
        if($("#main_view:checkbox:checked").length == 0){
           status=0;
            var alrtmsg = "Do you want to dissable all feature ?";
        //    $('.main_menu_view').prop('checked', false);
        //    $('.sub_menu_view').prop('checked', false);

        }else{
              status=1;
              var alrtmsg = "Do you want to enable all feature ?";
        //    $('.main_menu_view').prop('checked', true);
        //     $('.sub_menu_view').prop('checked', true);
        }
        $.confirm({
            title: 'Notice',
            content: alrtmsg,
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
                            url:'<?php echo base_url();?>backoffice/Usermanagement/all_module_action',
                            type:'POST',
                            data: {
                                    status:status,
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                            success:function(data){
                                 $(".loader").hide();
                                var obj=JSON.parse(data);
                                if(obj.check == 0)
                                    {
                                      $('#main_view').prop('checked', true);
                                    }
                                else{
                                    $('#main_view').prop('checked', false);
                                }
                                if(obj.status =="false")
                                    {
                                        $('.main_menu_view').prop('checked', false);
                                        $('.sub_menu_view').prop('checked', false);
                                    }
                                else if(obj.status =="true")
                                    {
                                         $('.main_menu_view').prop('checked', true);
                                         $('.sub_menu_view').prop('checked', true);
                                    }
                                else{
                                     $.toaster({priority:'warning',title:'INVALID',message:"Something went wrong,Please try again later..!"});
                                }
                            
                            }
                        });
                    }
                },
                cancel: function() {
                    if(status == 0){
                        $('#main_view').prop('checked', true);
                    }
                    if(status == 1){
                        $('#main_view').prop('checked', false);
                    }
                },
            }
        });
    }

    function main_menu_view(val){
        var status=0;
        if($("#main_menu_view_"+val+":checkbox:checked").length == 0)
        {
            status=0;
            var alrtmsg = "Do you want to dissable this feature ?";
           // $('.sub_menu_view_'+val).prop('checked', false);
        }else{
             status=1;
             var alrtmsg = "Do you want to enable this feature ?";
            //$('.sub_menu_view_'+val).prop('checked', true);
        }
        $.confirm({
            title: 'Notice',
            content: alrtmsg,
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
                            url:'<?php echo base_url();?>backoffice/Usermanagement/main_module_action',
                            type:'POST',
                            data: {
                                    status:status,
                                    parent_module_id:val,
                                    backoffice_modules_id:val,
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                            success:function(data){
                                 $(".loader").hide();
                                var obj=JSON.parse(data);
                                if(obj.check == 0)
                                    {
                                      $('#main_view').prop('checked', true);
                                    }
                                else{
                                    $('#main_view').prop('checked', false);
                                }
                                if(obj.status =="false")
                                    {
                                         $('.sub_menu_view_'+val).prop('checked', false);
                                    }
                                else if(obj.status =="true")
                                    {
                                        $('.sub_menu_view_'+val).prop('checked', true);
                                    }
                                else{
                                     $.toaster({priority:'warning',title:'INVALID',message:"Something went wrong,Please try again later..!"});
                                }
                            
                            }
                        });
                    }
                },
                cancel: function() {
                    if(status == 0){
                        $('#main_menu_view_'+val).prop('checked', true);
                        $('.sub_menu_view_'+val).prop('checked', true);
                    }
                    if(status == 1){
                        $('#main_menu_view_'+val).prop('checked', false);
                        $('.sub_menu_view_'+val).prop('checked', false);
                    }
                },
            }
        });
    }

 function sub_menu_view(main,val)
    {
        var status="";
        if($("#sub_menu_view_"+val+":checkbox:checked").length == 0)
        {
            status=0;
            var alrtmsg = "Do you want to dissable this feature ?";
           // $('.sub_menu_view_'+val).prop('checked', false);
        }
        else{
             status=1;
             var alrtmsg = "Do you want to enable this feature ?";
            //$('.sub_menu_view_'+val).prop('checked', true);
        }
        $.confirm({
            title: 'Notice',
            content: alrtmsg,
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
                            url:'<?php echo base_url();?>backoffice/Usermanagement/sub_module_action',
                            type:'POST',
                            data: {
                                    status:status,
                                    backoffice_modules_id:val,
                                    parent_id:main,
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                            success:function(data){
                                 $(".loader").hide();
                                var obj=JSON.parse(data);
                                if(obj.check == 0)
                                    {
                                      $('#main_view').prop('checked', true);
                                      //$('#main_menu_view_'+main).prop('checked', true);
                                    }
                                else{
                                    $('#main_view').prop('checked', false);
                                }
                                if(obj.status =="false")
                                    {
                                         $('#sub_menu_view_'+val).prop('checked', false);
                                    }
                                else if(obj.status =="true")
                                    {
                                        $('#sub_menu_view_'+val).prop('checked', true);
                                        $('#main_menu_view_'+main).prop('checked', true);
                                    }
                                else{
                                     $.toaster({priority:'warning',title:'INVALID',message:"Something went wrong,Please try again later..!"});
                                }
                            
                            }
                        });
                    }
                },
                cancel: function() {
                    if(status == 0){
                        $('#sub_menu_view_'+val).prop('checked', true);
                    }
                    if(status == 1){
                        $('#sub_menu_view_'+val).prop('checked', false);
                    }
                },
            }
        });
    }


</script>
