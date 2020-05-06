<script>
$('#cancelEdit').click(function(){
  redirect('usermanagement-permission');
});
function check_all_view(){
        if($("#main_view:checkbox:checked").length == 0){
            $('.main_menu_view').prop('checked', false);
            $('.sub_menu_view').prop('checked', false);
        }else{
            $('.main_menu_view').prop('checked', true);
            $('.sub_menu_view').prop('checked', true);
        }
    }
    function check_all_modify(){
        if($("#main_modify:checkbox:checked").length == 0){
            $('.main_menu_modify').prop('checked', false);
            $('.sub_menu_modify').prop('checked', false);
        }else{
            $('.main_menu_modify').prop('checked', true);
            $('.sub_menu_modify').prop('checked', true);
        }
    }
    function main_menu_view(val){
        if($("#main_menu_view_"+val+":checkbox:checked").length == 0){
            $('.sub_menu_view_'+val).prop('checked', false);
        }else{
            $('.sub_menu_view_'+val).prop('checked', true);
        }
    }
    function main_menu_modify(val){
        if($("#main_menu_modify_"+val+":checkbox:checked").length == 0){
            $('.sub_menu_modify_'+val).prop('checked', false);
        }else{
            $('.sub_menu_modify_'+val).prop('checked', true);
        }
    }
 $("form#permission").submit(function(e) {
               e.preventDefault();
             $.ajax({
                url: '<?php echo base_url();?>backoffice/Usermanagement/add_permission',
                type: "post",
                data: new FormData(this),
                beforeSend: function(data) {
                     $(".loader").show();
                },
                success: function(data) {
                   var obj=JSON.parse(data);
                if(obj['st'] == 1)
                    {
                         $.toaster({priority:'success',title:'SUCCESS',message:obj['msg']});
                    }
                    else if(obj['st'] == 0)
                        {
                           $.toaster({priority:'warning',title:'INVALID',message:obj['msg']});
                        }


                },
                complete: function(data) {
                   $(".loader").hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
function check_main(main,sub)
    {//sub_menu_view_4
        var countChk = $('input:checkbox.sub_menu_view_'+main+':checked').length;
        if(countChk>0) {
         $('#main_menu_view_'+main).prop('checked', true);
        } else {
            $('#main_menu_view_'+main).prop('checked', false);   
        }
    }

</script>
