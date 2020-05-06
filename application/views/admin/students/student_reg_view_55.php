 <div class="row">
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12" id="loadbatchdetails">
            <div class="table-responsive table_language table_batch_details" >
                <table class="table table-bordered table-striped table-sm">
                    <tr>
                        <th>Sl</th>
                        <th>Course</th>
                        <th>Start Date</th>
                        <th>Fees</th>
                    </tr>
                <?php
                    if(!empty($courses)) {
                        $i = 1;
                        foreach($courses as $course) { 
                           
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $course->class_name;?></td>
                        <td><?php echo date('d M Y',strtotime($course->created));?></td>
                        <td><?php //echo numberformat($batch['course_totalfee']);?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                    <?php } else { ?>
                    <tr><td colspan="6">No course available</td></tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

            <div class="row">
            <form method="post" id="addnewsourse">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label>Add New Course</label>
                        <div class="multiselect">
                            <div class="selectBox" >
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>"/>
                                <select class="form-control" id="selectedcourse" name="selectedcourse" >
                                    <option value="">Select course</option>
                                    <?php
                                        if(!empty($courseslist)) {
                                            foreach($courseslist as $course) {
                                                echo '<option value="'.$course->class_id.'" '.$selected.'>'.$course->class_name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <div class="multiselect">
                            <div class="selectBox" >
                                <button class="btn btn-info" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>   
</form>
            </div>

        </div>
        
    </div>

    <script>
  $(document).ready(function(){   
    $("form#addnewsourse").validate({
            rules: {
                selectedcourse: {required: true}
        },
        messages: {
            selectedcourse: {required:"Please select course"}
        },
        submitHandler: function(form) {            
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/student_course_adding',
                type: 'POST',
                data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                data: $("#addnewsourse").serialize(),
                success: function(response) { 
                    if(response == 1) {
                        $(".courseallocation").click();
                        $.toaster({priority:'success',title:'message',message:'Course added successfully'});
                    } else {
                        $.toaster({priority:'danger',title:'message',message:'Course adding failed'});
                    }
                       }
            });
            
            
        }
    });
});
    </script>