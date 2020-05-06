
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Careers</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Careers</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper careers">
        <div class="container maincontainer">
            <h4 class="inner_head">Interested in joining the team?</h4>
            <p class="inner_para">Checkout the latest openings.</p>

            <div id="accordion">
            <?php 
                    if(!empty($careers)){
                        foreach($careers as $row){
                ?>
                <div class="card card_career">
                    <a class="btn btn-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne<?php echo $row->careers_id; ?>"
                        aria-expanded="false" aria-controls="collapseOne"><?php echo $row->careers_name; ?>
                        <span class="btns">
                            <i class="fa fa-angle-right"></i>
                        </span>


                    </a>

                    <div id="collapseOne<?php echo $row->careers_id; ?>" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body careerheader">
                            <ul class="nav nav-bar justify-content-between">
                                <li><i class="fas fa-map-marker-alt"></i>
                                    <h5>Location</h5> <span class="subtitle"><?php echo $row->careers_location; ?></span>
                                </li>
                                <li><i class="far fa-calendar-alt"></i>
                                    <h5>Last Date</h5> <span class="subtitle"><?php echo $row->careers_date; ?></span>
                                </li>
                            </ul>
                            <div class="career_box">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <h5>Eligibility</h5>
                                    </div>
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12 ">
                                        <span><?php echo $row->careers_eligibility; ?></span>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <h5>Experience</h5>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <span class="subtitle"><?php echo $row->careers_experience; ?> Year</span>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <h5>Employment Type</h5>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <span class="subtitle"><?php echo $row->careers_employment_type; ?></span>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <h5>Basic Salary</h5>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <span class="subtitle"><?php echo $row->careers_base_salary; ?></span>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 ">
                                        <h5>Job Description </h5>
                                    </div>
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12 ">
                                        <span class="career-job"><?php echo $row->careers_job_description; ?> </span>
                                        <a id="btn_apply" href="#" data-id="<?php echo $row->careers_id; ?>" class="Apply" data-toggle="modal" data-target="#apply">Apply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }}else{?>
                    <p style="text-align:center;">No career opportunities available</p>
                <?php } ?>
            </div>
        </div>
    </section>
    <div class="modal fade forgotmodal" id="apply">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title inner_head">Apply</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="forgotmodalbox">
                    <form id="applay_form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Name</label><span style="color: #ed1c24"> *</span>
                                            <input type="text" name="name" onkeypress="return valNames(event);" id="name" class="form-control" placeholder="Name">
                                            <input type="hidden" name="career_id" id="career_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Email Id</label><span style="color: #ed1c24"> *</span>
                                            <input type="email" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Phone</label><span style="color: #ed1c24"> *</span>
                                            <input type="text" name="phone"  id="phone" class="form-control" placeholder="Phone" onkeypress="return valNum(event)">
                                        </div> 
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Resume</label><span style="color: #ed1c24"> *</span><small> ( Only pdf and doc file format supported.. Maximum size is 5 MB)</small>
                                            <input type="file" name="resume" id="resume" class="form-control">
                                        </div> 
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div id="resume_error" style="color:red;"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-info btn-submit d-block" type="submit" id="forgot_submit">Submit</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
                    </form>
        </div>
    </div>
    <?php $this->load->view('home/scripts/workwithus_view_script'); ?> 