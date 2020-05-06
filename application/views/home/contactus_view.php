
<div class="abtbanner BgGrdOrange ">
    <div class="container maincontainer">
        <h3>Contact us</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact us</li>
        </ol>
    </div>
</div>
<section class="inner_page_wrapper">
    <div class="container maincontainer">
        <div class="form_box">
            <div class="row">
                <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12 paddright ">
                    <div class="form_box_wrapper">
                        <div class="pad_clearfix">
                            <div class="alert alert-success" id="success_msg" style="display:none;">
                                <strong>Submitted Succesfully!</strong>
                            </div>
                            <div class="alert alert-danger" id="error_msg" style="display:none;">
                                <strong>Network Error! Please try agin later</strong>
                            </div>
                            <form type="post" id="contactus">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h4 class="inner_head">Request a Callback</h4>
                                        <div class="input-group form_input_group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user" style=" font-size: 16px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="enquiry_name" onkeypress="return valNames(event);" placeholder="Name *">
                                            <input type="hidden" class="form-control"  name="enquiry_type" value="2">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="input-group form_input_group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-mobile-alt" style="font-size: 20px; margin-left: 2px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Phone *" name="enquiry_phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="input-group form_input_group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope" style=" font-size: 15px;"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Email *" name="enquiry_email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <br>
                                            <textarea class="form-control textarea_message" placeholder="Message" rows="4" name="enquiry_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <button class="btn btn-info btn-submit" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-12 paddleft">
                    <div class="form_bg">
                        <ul>
                            <li>
                                <a href="#"><img src="<?php echo base_url();?>direction_v2/images/location-mark.png" alt="Location" class="img-fluid list_img"  data-toggle="modal" data-target="#exampleModalLong"></a>
                                IIHRM.<br> Four square building, 2nd and 3rd Floor <br>
                                NH66<br> Tvm, Kerala, India, 098909
                            </li>
                            <li>
                                <img src="<?php echo base_url();?>direction_v2/images/call_center.png" alt="Mobile" class="img-fluid list_img">
                                23456789 /23456789 <br>info@gbs-plus.com
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3912.8466434596025!2d75.80599561450673!3d11.27268129198595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba65dc7c07127db%3A0x1b5a84ce070b2f2e!2sDIRECTION%20GROUP%20OF%20INSTITUTIONS%20PVT%20LTD!5e0!3m2!1sen!2sin!4v1569237437961!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe> -->
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("home/scripts/contactus_script");?>