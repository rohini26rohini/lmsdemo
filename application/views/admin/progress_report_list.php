<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Batch Progress Summary</h6>
        <hr>
        <form id="search_form">
        <div class="row filter">
             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('school');?></label>
                   
                    <select class="form-control" id="filter_school" onchange="get_course();" name="school_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <?php 
                        $schools=$this->common->get_alldata('am_schools',array("school_status"=>"1"));
                        if(!empty($schools))
                        {
                            foreach($schools as $val)
                            {
                                ?>
                        <option value="<?php echo $val['school_id']; ?>"><?php echo $val['school_name']; ?></option>
                        <?php
                            }
                        }
                        ?>
                        
                    </select>
                </div>
            </div> 
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('centre');?></label>
                   
                    <select class="form-control" id="filter_centre" onchange="get_course();" name="centre_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                        <?php 
                        $centre=$this->common->get_alldata('am_institute_master',array("institute_type_id"=>"3","status"=>"1"));
                        if(!empty($centre))
                        {
                            foreach($centre as $val)
                            {
                                ?>
                        <option value="<?php echo $val['institute_master_id']; ?>"><?php echo $val['institute_name']; ?></option>
                        <?php
                            }
                        }
                        ?>
                        
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('course');?></label>
                   
                    <select class="form-control" id="filter_course" name="course_id">
                     <option value=""><?php echo $this->lang->line('select'); ?></option>  
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-12">
                <div class="form-group">
                <label><?php echo $this->lang->line('batch');?></label>
                    <select class="form-control" id="filter_batch" name="batch_id">
                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                    </select>
                </div>
            </div>
          
            
        </div>
        </form>
    </div>
    <!-- Data Table Plugin Section Starts Here -->
    <div class="white_card" id="loadreportview" style="display:none;">
         <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#view_1" ><?php echo $this->lang->line('batch_performance');?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#view_2"> <?php echo $this->lang->line('individual_student_performance');?></a>
            </li>
        </ul>
        <div class="tab-content"> 
            <div id="view_1" class=" tab-pane active">
                <div class="table-responsive table_language" style="margin-top:15px;">
                    <table id="batch_examlist_table" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                                <th>Exam Name</th>
                            </tr>
                        </thead>
                            
                    </table>
                </div>
            </div>
            <div id="view_2" class=" tab-pane">
                <?php $this->load->view('admin/progress_report/batch_progress_report'); ?>
            </div>
        </div>
       
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<div class="chartBlock" id="chartBlock">
    <div class="chartBlockWrapper">
        <button class="close_btn" >
            <i class="fa fa-arrow-right"></i>
        </button>
    <div class="scroller" id="loadalldatas">
        
        
     
        </div>
    </div>

</div>
<?php //$this->load->view("admin/scripts/studentlist_script");?>
<?php $this->load->view("admin/scripts/progress_reportlist_script");?>
