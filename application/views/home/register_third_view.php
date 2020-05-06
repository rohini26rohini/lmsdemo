<form id="requirement_form" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="registration_panel">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="register_line">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                        <div class="register_progress circle_1 register_complete"><span>01</span>
                                            <input type="text" id="next" style="height:0px;width:0px;border:0px;"/>
                                        </div>

                                        <!--                                            <h5>Personnal Details</h5>-->

                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                        <div class="register_progress circle_2 register_complete"><span>02</span>

                                        </div>

                                        <!--                                            <h5>Qualification</h5>-->

                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">


                                        <div class="register_progress circle_3 register_active"><span>03</span>



                                            <!--                                            <h5>Finish</h5>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="register_cap">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                        <div class="cap_1 ">



                                            <h5>Personnel Details</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                        <div class="cap_2">


                                            <h5>Qualification</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                                        <div class="cap_3 cap_active">


                                            <h5>Finish</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table_register">

                        <?php if(isset($error)){?>
                         <div class="alert alert-danger">
                                    <strong>Error Occured..! Please try again later</strong>
                                </div>
                        <?php } ?>
                        <tr>
                            <td>Hostel Required<span class="show_error">*</span></td>
                            <td nowrap><label class="custom_checkbox hostel">Yes
                                <input type="radio" class="hostel" value="yes" name="hostel"  <?php echo (array_key_exists("hostel",$_SESSION)&&$_SESSION['hostel']=="yes") ? ' checked' : '';?>>
                            <span class="checkmark"></span>
                                </label></td>
                            <td nowrap><label class="custom_checkbox hostel">No
                                <input type="radio" class="hostel" value="no"  name="hostel" <?php  echo (array_key_exists("hostel",$_SESSION)&&$_SESSION['hostel']=="no") ? ' checked' : '';?>>
                                <span class="checkmark" ></span>
                                </label></td>
                        </tr>
                        <?php if(array_key_exists("hostel",$_SESSION)&&$_SESSION['hostel']=="yes"){?>
                        <tr class="hostel_sub">
                            <td>Whether the candidate had stayed in any hostel before <span class="show_error">*</span></td>
                            <td><label class="custom_checkbox">Yes
                            <input type="radio" class="stayed_in_hostel" name="stayed_in_hostel" value="yes" <?php  echo (isset($_SESSION)&$_SESSION['stayed_in_hostel']=="yes") ? ' checked' : '';?>>
                                <span class="checkmark"></span>
                                </label></td>
                            <td><label class="custom_checkbox">No
                                <input type="radio" class="stayed_in_hostel" name="stayed_in_hostel" value="no" <?php echo (isset($_SESSION)&$_SESSION['stayed_in_hostel']=="no") ? ' checked' : '';?>>
                                <span class="checkmark"></span>
                                </label></td>
                        </tr>
                        <tr class="hostel_sub">
                            <td>Food habit of student <span class="show_error">*</span>
                            </td>
                            <td><label class="custom_checkbox">Veg
                                <input type="radio" class="food_habit" name="food_habit" value="veg" <?php echo (isset($_SESSION)&$_SESSION['food_habit']=="veg") ? ' checked' : '';?>>
                                <span class="checkmark"></span>
                                </label></td>
                            <td nowrap><label class="custom_checkbox">Non-Veg
                                    <input type="radio" class="food_habit" name="food_habit" value="nonveg"  <?php echo (isset($_SESSION)&$_SESSION['food_habit']=="nonveg") ? ' checked' : '';?>>
                                        <span class="checkmark"></span>
                                        </label></td>
                        </tr>
                        <?php } else {?>
                        <tr class="hostel_sub" style="display:none;">
                            <td>Whether the candidate had stayed in any hostel before <span class="show_error">*</span></td>
                            <td><label class="custom_checkbox">Yes
                            <input type="radio" name="stayed_in_hostel" value="yes" >
                                <span class="checkmark stayed" ></span>
                                </label></td>
                            <td><label class="custom_checkbox">No
                                <input type="radio" name="stayed_in_hostel" value="no" >
                                <span class="checkmark stayed"></span>
                                </label></td>
                        </tr> 
                        <tr class="hostel_sub" style="display:none;">
                            <td>Food habit of student <span class="show_error">*</span>
                            </td>
                            <td><label class="custom_checkbox">Veg
                                <input type="radio" name="food_habit" value="veg" >
                                <span class="checkmark food_habit"></span>
                                </label></td>
                            <td nowrap><label class="custom_checkbox">Non-Veg
                                    <input type="radio"  name="food_habit" value="nonveg"  >
                                        <span class="checkmark food_habit"></span>
                                        </label></td> 
                        </tr>
                        
                        <?php } ?>
                        <!-- <tr>
                            <td>Whether the candidate has any medical history of aliment</td>
                            <td><label class="custom_checkbox">Yes
                                    <input type="radio" name="medical_history" class="medical_history" value="yes" <?php  echo (array_key_exists("medical_history",$_SESSION)&&$_SESSION['medical_history']=="yes") ? ' checked' : '';?>>
                                  <span class="checkmark"></span>
                                </label>
                            </td>


                            <td><label class="custom_checkbox">No
                                  <input type="radio"  name="medical_history" class="medical_history"  value="no" <?php echo (array_key_exists("medical_history",$_SESSION)&&$_SESSION['medical_history']=="no") ? ' checked' : '';?>>
                                  <span class="checkmark"></span>
                                </label></td>
                        </tr> -->
                        <?php //if(array_key_exists("medical_history",$_SESSION)&&$_SESSION['medical_history']=="yes"){ ?>
                        <!-- <tr id="medical_text">
                            <td>Medical History Description<span class="show_error">*</span></td>
                            <td colspan="2">
                                <div class="form-group">
                                <textarea id="medical_description" class="form-control" placeholder="Description" name="medical_description" onkeypress="return blockSpecialChar(event)"><?php echo (array_key_exists("medical_description",$_SESSION)) ? $_SESSION['medical_description'] : '';?></textarea>

                                     <span style="color:red;font-size: 12px;" id="medical_msg"></span>
                                </div>
                            </td>
                        </tr> -->
                         <?php// } else { ?>
                        <!-- <tr id="medical_text" style="display:none;">
                            <td>Medical History Description<span class="show_error">*</span></td>
                            <td colspan="2">
                                <div class="form-group">

                                    <textarea type="text" id="medical_description" class="form-control" placeholder="Description" name="medical_description"></textarea>
                                    <span style="color:red;font-size: 12px;" id="medical_msg"></span>
                                </div>
                            </td>
                        </tr> -->

                        <?php //} ?>
                        <tr>
                            <td>Transportation Required <span class="show_error">*</span></td>
                            <td><label class="custom_checkbox">Yes
                              <input type="radio" name="transportation" value="yes" class="transportation" <?php echo (array_key_exists("transportation",$_SESSION)&&$_SESSION['transportation']=="yes") ? ' checked' : '';?>>
                              <span class="checkmark"></span>
                            </label></td>
                                <td ><label class="custom_checkbox">No
                              <input type="radio"  name="transportation" value="no" class="transportation" <?php echo (array_key_exists("transportation",$_SESSION)&&$_SESSION['transportation']=="no") ? ' checked' : '';?>>
                              <span class="checkmark"></span>
                            </label></td>
                        </tr>
                         <?php if(array_key_exists("transportation",$_SESSION)&&$_SESSION['transportation']=="yes"){ ?>
                        <tr id="place">
                            <td>Route<span class="show_error">*</span></td>
                            <td colspan="2">
                                <div class="form-group">

                                    <!--<input type="text" id="transport_place" class="form-control" placeholder="Place" name="place" value="<?php echo (array_key_exists("place",$_SESSION)) ? $_SESSION['place'] : '';?>" onkeypress="return addressValidation(event)"/>-->

                                    <select class="form-control" name="place" id="transport_place">

                                        <option value="">Select</option>
                                        <?php
                                        if(!empty($routeArr))
                                        {
                                            foreach($routeArr as $row)
                                            {
                                              ?>
                                        <option <?php if( isset($_SESSION)&& $_SESSION['place']== $row['transport_id']) { echo "selected"; } ?> value="<?php echo $row['transport_id'];?>"><?php echo ucfirst($row['route_name']);?></option>
                                           <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                     <span style="color:red;font-size: 12px;" id="pmsg"></span>
                                </div>
                            </td>
                        </tr>
                        
                        <?php } else { ?>
                        <tr id="place" style="display:none;">
                            <td>Route<span class="show_error">*</span></td>
                            <td colspan="2">
                                <div class="form-group">

                                    <!--<input type="text" id="transport_place" class="form-control" placeholder="Place" name="place" onkeypress="return addressValidation(event)"/>-->
                                    <select class="form-control" name="place" id="transport_place">
                                        <option value="">Select</option>
                                        <?php
                                        if(!empty($routeArr))
                                        {
                                            foreach($routeArr as $row)
                                            {
                                              ?>
                                        <option value="<?php echo $row['transport_id'];?>"><?php echo ucfirst($row['route_name']);?></option>
                                           <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                    <span style="color:red;font-size: 12px;" id="pmsg"></span>
                                </div>
                            </td>
                        </tr>

                        <?php } ?>
                    </table>
                    <table class="table table_register">
                        <tr>
                            <td colspan="3" style="font-family: bold">Declaration<span class="show_error">*</span></td>
                        </tr>
                        <tr>
                            <td><label class="custom_checkbox">
                                  <input type="checkbox" name="declaration">
                                  <span class="checkmark"></span>
                                </label>
                            </td>
                            <td>
                                <font style="font-family: regular;color: #8a8a8a">I hereby declare that,details furnished above are true to that best of my knowledge and belief. I assure fully cooperation in the coaching, which I understand is essential for its success. I also willingly agree that this programme is cardinal in my preparation for the selection and thus have no objection in my name or photo being used in the promotion group of institutions.</font>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="custom_checkbox">
                                  <input type="checkbox" name="declaration2">
                                  <span class="checkmark"></span>
                                </label>
                            </td>
                            <td>
                                <font style="font-family: regular;color: #8a8a8a">For students who only needs materials no classes required.</font>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="custom_checkbox">
                                  <input type="checkbox" name="declaration3">
                                  <span class="checkmark"></span>
                                </label>
                            </td>
                            <td>
                                <font style="font-family: regular;color: #8a8a8a">Fees are not refundable.</font>
                            </td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                               
                                <a class="btn btn-warning btn_prev" >Previous</a>
                                <button class="btn btn-warning btn_next" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>

                </div>

</form>
<?php $this->load->view("home/scripts/register_thirdpage_script");  ?>
