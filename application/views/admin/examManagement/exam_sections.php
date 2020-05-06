
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                         <h6>Manage Exam Section Templates</h6>
                        <hr>
                        <!-- Data Table Plugin Section Starts Here -->
                         <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" onClick="redirect('backoffice/exam/section_definition');">
                                    Add Exam Section Template
                                </button>

                       <div class="table-responsive table_language" style="margin-top:15px;">
                            <table id="institute_data" class="table table-striped table-sm" style="width:100%">

                                <thead><tr>
                                    <th width="10%">Sl.No.</th>
                                    <th width="50%">Section Template Name</th>
                                    <th width="20%">Last Modified Date</th>
                                    <th width="20%">Action</th>
                                </tr></thead>
                                <?php $i=1; if(!empty($sections)){ foreach($sections as $row){ ?>
                                <tr id="section<?php echo $row->id;?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->section_name; ?></td>
                                    <td><?php echo date('d-M-Y h:i a',strtotime($row->modified_date)); ?></td>
                                    <td>
                                        <button class="btn btn-default option_btn" title="Edit" onClick="redirect('backoffice/exam/section_definition_edit?id=<?php echo $row->id;?>');">
                                            <i class="fa fa-pencil "></i>
                                        </button>
                                        <button class="btn btn-default option_btn" title="Delete" onclick="delete_section('<?php echo $row->id;?>')">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>

                                </tr>
                                <?php $i++; } } ?>
                                
                            </table>
                        </div>

                    </div>
                </div>


    <script type="text/javascript">
        function delete_section(id) {
            $.confirm({
                title: 'Alert message',
                content: 'Do you want to remove this section?',
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
                            $.post('<?php echo base_url();?>backoffice/exam/delete_section/', {
                                section_id: id,
                                <?php echo $this->security->get_csrf_token_name();?> : '<?php echo $this->security->get_csrf_hash();?>'
                            }, function(data) {
                                var obj=JSON.parse(data);
                                if (obj['st'] == true) {
                                    $("#section"+id).remove();
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
    </script>
