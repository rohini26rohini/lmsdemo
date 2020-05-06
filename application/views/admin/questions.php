  <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card">
            <h6><?php echo $this->lang->line('sample_questions'); ?></h6>
        <hr>       

                                
                                <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_question">
                                    Add Questions
                                </button>
                                
                           
                        <!-- Data Table Plugin Section Starts Here -->
                       <div class="table-responsive table_language" style="margin-top:15px;">  
                         <table id="sample_question_data" class="table table-striped table-sm" style="width:100%">
                            <thead>
                                <th><?php echo $this->lang->line('sl_no');?></th>
                                <th ><?php echo $this->lang->line('school');?></th>
                                <th>Question Paper Serial No</th>
                                <th ><?php echo $this->lang->line('question');?></th>
                                <th ><?php echo $this->lang->line('action');?></th>
                            </thead>
                            
                           
                            
                        </table>
                        </div>
                        <!-- Data Table Plugin Section Starts Here -->
                    </div>
                </div>

  <div id="add_question" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Questions</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>   <form  method="post" enctype="multipart/form-data" id="add_question_form">
                <div class="modal-body">
                  
                      
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>School<span class="req redbold">*</span></label>
                                                  
                                                    <select class="form-control" name="school_name">
                                                        <option value="">Select School</option>
                                                        <?php foreach($school as $s){?>
                                                        <option value="<?php echo $s['school_id'];?>" ><?php echo $s['school_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="form-group"><label>Questions<span class="req redbold">*</span></label>
                                                    <input class="form-control" type="file" name="question"><!--<p>Upload .xls,.xlsx,csv files only.</p>-->
                                                    <a class="btn btn_download" href="<?php echo base_url();?>uploads/samples/takeatestquestiontemplate.xlsx" download>Click Here to download sample</a>
                                                </div>
                        </div>


                    </div>
                  
                </div> <div class="modal-footer">
         <button class="btn btn-success">Save</button>
         <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div> 
  </form>
            </div>

        </div>
    </div>
<!--edit question-->
<div id="edit_question" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Question</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>     <form  method="post" enctype="multipart/form-data" id="edit_question_form">
                <div class="modal-body">
                  
                    
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="question_id" id="edit_question_id"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>School</label>
                                                  
                                                    <select class="form-control" name="school_id" id="edit_school">
                                                        <option value="">Select School</option>
                                                        <?php foreach($school as $s){?>
                                                        <option value="<?php echo $s['school_id'];?>" ><?php echo $s['school_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="form-group"><label>Question Serial NO</label>
                               <input class="form-control"  id="edit_serialno" name="question_serialno" readonly/>

                           </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="form-group"><label>Question</label>
                               <textarea  name="question" class="form-control" rows="2" id="edit_questions" value=""></textarea>

                           </div>
                        </div>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                           <div class="form-group"><label>Option A</label>
                               <input name="question_option_a" class="form-control"  id="edit_a" />

                           </div>
                           </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                              <div class="form-group"><label>Option B</label>
                               <input name="question_option_b" class="form-control"  id="edit_b" />

                           </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                              <div class="form-group"><label>Option C</label>
                               <input name="question_option_c" class="form-control"  id="edit_c" />

                           </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                              <div class="form-group"><label>Option D</label>
                               <input name="question_option_d" class="form-control"  id="edit_d" />

                           </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="form-group"><label>Answer</label>
                               <input name="answer" class="form-control"  id="edit_ans" />
                                                   
                           </div>
                        </div>
                                   </div>
                 

                </div> <div class="modal-footer">
         <button class="btn btn-success">Save</button>
         <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div> 
  </form>
            </div> 
        </div>
    </div>
<?php $this->load->view("admin/scripts/question_script");?>
