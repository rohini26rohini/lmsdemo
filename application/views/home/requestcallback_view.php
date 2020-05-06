<section class="top_strip" style="background-image: url(<?php echo base_url();?>assets/images/banner_bg.png);">
        <div class="container">
            <h3>Request a Call Back</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Connect Us</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Request a Call Back</li>
            </ol>
        </div>
    </section>
    <section class="inner_page_wrapper">
        <div class="container">
            <div class="form_box">
                
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                        <div class="form_box_wrapper">
                            <h1 class="inner_head">Request a Call Back</h1>
                            <div class="alert alert-success" id="success_msg" style="display:none;">
                                    <strong>Submitted Successfully!</strong>
                                </div>
                            <div class="alert alert-danger" id="error_msg" style="display:none;">
                                    <strong>Network Error! Please try agin later</strong>
                                </div>
                            <form type="post" id="callback">
                                <div class="pad_clearfix">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="input-group form_input_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user" style=" font-size: 24px;"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Name *" name="enquiry_name" id="name">
                                        <input type="hidden" class="form-control"  name="enquiry_type" value="0">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                    </div>

                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="input-group form_input_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-mobile-phone"  style="font-size: 35px;"></i></span>
                                        </div>
                                       <input type="text" class="form-control" placeholder="Phone *" onkeypress="return valNum(event)" name="enquiry_phone" id="phone">
                                    </div>

                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="input-group form_input_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope" style=" font-size: 20px;"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Email *" name="enquiry_email">
                                    </div>

                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="input-group form_input_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker" style=" font-size: 24px;"></i></span>
                                        </div>
                                         <input type="text" class="form-control" placeholder="Location *" name="enquiry_location">
                                    </div>
                                </div>
                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <textarea class="form-control formbox_textarea" rows="4" placeholder="Notes *" name="enquiry_note"></textarea>
                                    </div>
                                </div> -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="btn btn-info btn-submit">Submit</button>

                                </div>
                            </div>
                                </div>
                                </form>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form_bg" style="background-image: url(<?php echo base_url();?>assets/images/Request%20A%20Callback.png)"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>
<?php $this->load->view("home/scripts/requestcallback_script");?>
