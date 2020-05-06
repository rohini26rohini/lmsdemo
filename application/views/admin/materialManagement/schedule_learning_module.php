
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                        <h6>Schedule Learning Module</h6>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div id='calendar' class="full_calender_wrap"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="view_learning_module" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="text-align: center;" class="modal-title" id="learning_module_namem">Title</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                </div>
                <div class="modal-body" id="finishmodal_body">

                </div>
                <div class="modal-footer" id="finishmodal_footer"></div> 
            </div>
        </div>
    </div>
    <script>
    function view_learning_module(id,schedule_id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/Questionbank/get_single_learning_module'); ?>",
            type: "post",
            data: {id:id,'ci_csrf_token':csrfHash,view:2},
            success: function (response) {
                var obj = JSON.parse(response);
                $("#learning_module_namem").html(obj.data.title);
                $("#finishmodal_body").html(obj.data.body);
                $("#finishmodal_title").html(obj.data.title);
                $("#finishmodal_footer").html('<button class="btn btn-info close" onclick="assign_learning_module('+schedule_id+');" data-dismiss="modal">OK</button>');
                $(".loader").hide();
                $(".loader").hide();
                $('#view_learning_module').modal({
                    show: true
                });
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }
    </script>
    <?php $this->load->view('admin/scripts/materialManagement/learning_module_schedule_script'); ?>
