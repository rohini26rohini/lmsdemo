
    <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Login</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </div>
    </div>
    <section class="inner_page_wrapper loginbox sdadsa">
        <div class="container maincontainer">
            <div class="form_box">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 logbgimg"
                        style="background-image: url('<?php echo base_url();?>direction_v2/images/8.jpg');">
                        <div class="form_box_wrapper">
                            <h4 class="inner_head">Login</h4>
                            <form id="loginform" method="post">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="input-group form_input_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"
                                                    style=" font-size: 16px;"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                    </div>

                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="input-group form_input_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"
                                                    style="font-size:16px;"></i></span>
                                        </div>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    </div>

                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <button class="btn btn-info btn-submit d-block" type="submit" id="loginsubmit">Login</button>
                                
                                </div>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                    </div>
                            </form>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <ul class="nav nav-bar justify-content-md-between Remember">
                                        <!-- <li></li> -->
                                        <!-- <li><label><input type="checkbox" value="">Remember Me</label></li> -->
                                        <li class="">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="example1">
                                                <label class="custom-control-label " for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </li>
                                        <li><a href="#" class="forget_link"  data-toggle="modal" data-target="#Forgot">Forgot Password</a></li>
                                    </ul>
                                </div>

                            

                            <div class="forget_password">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="checkbox">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
    </section>
    <div class="modal forgotmodal fade" id="Forgot">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title inner_head">Forgot Password</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="forgotmodalbox">
                    <form id="forgot_form" method="post">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <label>Email Id</label><span style="color: #ed1c24"> *</span>
                                            <div class="input-group form_input_group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"
                                                            style=" font-size: 16px;"></i></span>
                                                </div>
                                                <input type="email" name="email" class="form-control" placeholder="Email" id="forgot_email" required>
                                            </div>
                                            <small id="err" style="color:red;"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-info btn-submit d-block mysubmit" type="submit" id="forgot_submit" >Submit</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    <?php $this->load->view('admin/scripts/login_script'); ?>
