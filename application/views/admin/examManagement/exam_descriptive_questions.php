
<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Evaluate- <?php echo $exam_name; ?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <!-- <button onClick="resetform();" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal"  onclick="formclear('add_institute_form')">
            Add Model
        </button> -->
        <div class="table-responsive table_language" style="margin-top:15px;">
           <table id="institute_data" class="table table-striped table-sm txtwrap" style="width:100%">
                <thead><tr>
                    <th>Subject</th>
                    <th>Module</th>
                    <th>Question.No</th>
                    <th>Question</th>
                    <th>Action</th>
                </tr></thead>
                <?php $i=1; if(!empty($questions)){ foreach($questions as $row){ ?>
                <tr id="exam<?php echo $row->id;?>" class="exam">
                    <td><?php echo $row->subject_name; ?></td>
                    <td><?php echo $row->module_name; ?></td>
                    <td><?php echo $row->question_number; ?></td>
                    <td><?php echo $row->question_content; ?></td>
                    <td>
                        <button class="btn mybutton mybuttonnew" onclick="redirect('backoffice/get-single-question/<?php echo $row->id;?>/<?php echo $row->question_id;?>')">
                            View answers
                        </button>
                    </td>
                </tr>
                <?php $i++; } }  ?>
                
            </table>
        </div>
    </div>
</div>
<div id="question_valuate" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Evaluate Descriptive Question</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- <form id="banner_form" method="post" enctype="multipart/form-data"> -->
                <div class="modal-body">
                    <div class="row">

                    </div>

                    <div class="row">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<style>
tr.exam img {
    max-width: 100%;
}
</style>
<?php $this->load->view('admin/scripts/examManagement/exam_evaluation_script'); ?>
