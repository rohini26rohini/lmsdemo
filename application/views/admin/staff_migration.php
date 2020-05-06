<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Staff Migration</h6>
        <hr>
        <form enctype="multipart/form-data" id="staffmigration_form" method="post" >
            <!-- Data Table Plugin Section Starts Here -->
            <div id="loadreportview" >
                <div class="row">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group"><label>Upload File<span class="req redbold">*</span></label>
                           <!-- <input class="form-control" type="file" name="question" onchange="readURL(this);">-->

                            <input class="form-control" type="file" name="question" id="question">
                            <p>Upload .xls,.xlsx & .csv files only  (Max Size:5MB).</p>

                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                        <label style="display:block">&nbsp</label>
                            <a class="btn btn-info btn_save" href="<?php echo base_url().'uploads/samples/staff_data.xlsx'; ?>" download><i class="entypo-download"></i>Click here to download sample</a>
                            <button type="submit" class="btn btn-info btn_save"><i class="fa fa-upload"></i><?php echo 'Upload';?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive table_language" id="cell">
          
                <!-- <table class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cell No.</th>
                            <th>Cell Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A2</td>
                            <td>Student Name</td>
                        </tr>
                    </tbody>
                </table> -->
            </div>

        </form>
    </div>
</div>

<?php $this->load->view("admin/scripts/staff_migration_script");?>
