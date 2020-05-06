<?php 
if(!empty($data)) {
$studentdet = $data[0]; 
?>
                    <table class="table table_register_view ">
                        <tbody>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('student_name');?> :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="batchname_view"><?php echo (!empty($studentdet))?$studentdet->name:'';?></span></label>
                                    </div>
                                 </div>    
                                </th>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('place');?> :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="nostudent_view"><?php echo (!empty($studentdet))?$studentdet->street.', '.$studentdet->city:'';?></span></label>
                                    </div>
                                 </div>     
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('course');?> :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="startdate_view"><?php echo (!empty($studentdet))?$studentdet->class_name:'';?></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                <div class="media">
                                <?php echo $this->lang->line('centre');?> :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="enddate_view"><?php echo (!empty($studentdet))?$studentdet->institute_name:'';?></span></label>
                                    </div>
                                 </div>     
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive table_language" style="margin-top:15px;">
            <table  id="subject_data" class="table table-striped table-sm" style="width:100%">
                        <h6>Discount details</h6>
                        <tbody>
                            <tr>
                                <th class="text-left"><?php echo $this->lang->line('title');?></th>
                                <th><?php echo $this->lang->line('discount');?></th>
                                <th><?php echo $this->lang->line('discount_amount');?></th>
                                <th><?php echo $this->lang->line('action');?></th>
                            </tr>
                            <?php
                            foreach($data as $row) {
                            ?>
                            <tr>
                                <td class="text-left"><?php echo $row->package_name;?></td>
                                <td><?php if($row->st_discount_type==2) { echo $row->st_discount.'%';} else { echo 'INR.'.$row->st_discount; } ?></td>
                                <td><?php echo 'INR.'.$row->discount_amount;?></td>
                                <td>
                                <select class="form-control approvediscount" alt="<?php echo $row->st_discount_id;?>" id="approvediscount" name="approvediscount" <?php echo (!empty($studentdet) && $studentdet->studentstatus==1)?'disabled="disabled"':'';?>>
                                    <option value="0" <?php  if($row->discount_status==0) { echo 'selected="selected"'; } ?>>Pending</option>
                                    <option value="1" <?php  if($row->discount_status==1) { echo 'selected="selected"'; } ?>>Approved</option>
                                    <option value="2" <?php  if($row->discount_status==2) { echo 'selected="selected"'; } ?>>Declined</option>
                                </select>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
</div>
<?php } ?>
<script>

    
    //add institite** show parent institute
    $('.approvediscount').change(function() {
        var type = $(this).val();
        id = $(this).attr("alt");
        if (id>0) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Approval/update_discount_approval',
                type: 'POST',
                data: {
                    type: type,id:id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                     $('#show').modal('toggle');
                   if(response==0) {
                       $.toaster({ priority : 'success', title : 'Success', message : 'Pending status is updated' });
                   } else if(response==1) {
                       $.toaster({ priority : 'success', title : 'Success', message : 'Discount is approved succcessfully' });      
                   } else if(response==2){
                       $.toaster({ priority : 'success', title : 'Success', message : 'Discount is declicned successfully' });
                   } else {
                       $.toaster({priority:'danger',title:'INVALID',message:"Failed to update approval status"});
                   }
                     $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Approval/load_discount_approval',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#subject_data').DataTable().destroy();
                                        $("#subject_data").html(data);

                                        $("#subject_data").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }

                                            ]
                                        });
                                    }
                                   });
                    $(".loader").hide();
                }
            });
            
        }
        else{
           $.toaster({priority:'danger',title:'INVALID',message:"Invalid Data."}); 
        }
    });
</script>