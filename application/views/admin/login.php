
    <!-- <div class="abtbanner BgGrdOrange ">
        <div class="container maincontainer">
            <h3>Login</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </div>
	</div> -->
	



	
<div class="row m-0">
<div class="col-md-6 p-0">
<div class="login-image"></div>
</div>
<div class="col-md-6 p-0">
	<div class="login-content">
		<div class="d-table">
		<div class="d-table-cell">
		<div class="login-form">
			<!-- <h4 class="inner_head">Login</h4> -->
			<h3>Welcome back</h3>
			<p>Log In to Your Site Account!</p>
                <form id="loginform" method="post">
                    <div class="form-group">
                         <input type="text" class="form-control" name="username" id="username" placeholder="Username">
					</div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
					<div class="form-group">
                        <button class="btn__primary btn-block" type="submit" id="loginsubmit">Login</button> 
					</div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                </form>
				<div class="remember__me">
					<div class="custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
						<label class="custom-control-label " for="customCheck">Remember Me</label>
					</div>

					<a href="#" class="forget_link"  data-toggle="modal" data-target="#Forgot">Forgot Password?</a>
				</div>

			</div>
</div>
</div>
	</div>
</div>

</div>

<!-- ******************************* -->

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
