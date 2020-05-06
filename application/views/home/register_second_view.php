<form id="qualification_form" type="post">
    <div class="registration_panel">
        <div class="row">


            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="register_line">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                            <div class="register_progress circle_1 register_complete"><span>01</span>
                                <input type="text" id="next" style="height:0px;width:0px;border:0px;" />
                            </div>

                            <!--                                            <h5>Personnal Details</h5>-->

                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">

                            <div class="register_progress circle_2 register_active"><span>02</span>

                            </div>

                            <!--                                            <h5>Qualification</h5>-->

                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">


                            <div class="register_progress circle_3"><span>03</span>



                                <!--                                            <h5>Finish</h5>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="register_cap">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="cap_1">


                                <h5>Personnel Details</h5>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="cap_2 cap_active">


                                <h5>Qualification</h5>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

                            <div class="cap_3">


                                <h5>Finish</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" id="second">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="form-group">
                    <label>SSLC Total Marks</label>

                    <div class="input-group">
                        <input type="hidden" name="category[]" value="sslc" />
                        <select class="form-control subject_select" name="qualification[]">
                            <?php echo (isset($_SESSION)&$_SESSION['qualification'][0]!="") ? ' <option>'.$_SESSION['qualification'][0].'</option>' : '';?>


                            <option value="">Select</option>
                            <option>AHSLC</option>
                            <option>Anglo Indian School Leaving Certificate</option>
                            <option>CBSE Xth</option>
                            <option>ICSE Xth</option>
                            <option>JTSLC</option>
                            <option>Matriculation Certificate</option>
                            <option>Secondary School Examination</option>
                            <option>SSC</option>
                            <option>SSLC</option>
                            <option>SSLC with Agricultural Optional</option>
                            <option>Standard X Equivalency</option>
                            <option>THSLC Xth</option>
                            <?php //} ?>
                        </select>
                        <div class="input-group-append percent_box">
                            <input type="text" class="form-control  " name="marks[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['marks'][0] : '';?>" onkeypress="return decimalNum(event);" maxlength="5" id="smark" />
                        </div>
                        <div class="input-group-prepend percentageSpan">
                            <span class="input-group-text">%</span>
                        </div>
                    </div><label class="error" id="smsg"></label>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group"> <label>+2/VHSE</label>
                    <div class="input-group">
                        <input type="hidden" name="category[]" value="plustwo" />
                        <select type="text" class="form-control subject_select" name="qualification[]">
                            <?php echo (isset($_SESSION)&$_SESSION['qualification'][1]!="") ? ' <option>'.$_SESSION['qualification'][1].'</option>' : '';?>
                            <option value="">Select</option>
                            <option>AHSS</option>
                            <option>CBSE XIIth</option>
                            <option>ICSE XIIth</option>
                            <option>Plus 2</option>
                            <option>Plus Two Equivalency</option>
                            <option>Pre Degree</option>
                            <option>Pre University</option>
                            <option>Senior Secondary School Examination</option>
                            <option>SSSC</option>
                            <option>THSE - XII</option>
                            <option>VHSE</option>
                            <option>VHSE Pass in Trade only for Employment Purpose</option>
                        </select>
                        <div class="input-group-append percent_box">
                            <input type="text" class="form-control " id="plustwo_m" name="marks[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['marks'][1] : '';?>" onkeypress="return decimalNum(event);" maxlength="5" />
                        </div>
                        <div class="input-group-prepend percentageSpan">
                            <span class="input-group-text">%</span>
                        </div>
                    </div><label class="error" id="plustwo_msg"></label>

                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group"> <label>Degree</label>
                    <div class="input-group">
                        <input type="hidden" name="category[]" value="degree" />
                        <select type="text" class="form-control subject_select " name="qualification[]">
                            <?php echo (isset($_SESSION)&$_SESSION['qualification'][2]!="") ? ' <option>'.$_SESSION['qualification'][2].'</option>' : '';?>
                            <option value="">Select</option>
                            <option>B Voc</option>
                            <option>BA</option>
                            <option>BA Honours</option>
                            <option>Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                            <option>Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                            <option>Bachelor of Design</option>
                            <option>Bachelor of Divinity</option>
                            <option>Bachelor of Occupational Therapy - BOT</option>
                            <option>Bachelor of Science BS</option>
                            <option>Bachelor of Science in Applied Sciences</option>
                            <option>Bachelor of Textile</option>
                            <option>BAL</option>
                            <option>BAM</option>
                            <option>BAMS</option>
                            <option>BArch</option>
                            <option>BBA</option>
                            <option>BBM</option>
                            <option>BBS</option>
                            <option>BBS Bachelor of Business Studies</option>
                            <option>BBT</option>
                            <option>BCA</option>
                            <option>BCJ</option>
                            <option>BCom</option>
                            <option>BComHonours</option>
                            <option>BComEd</option>
                            <option>BCS - Bachelor of Corporate Secretaryship</option>
                            <option>BCVT </option>
                            <option>BDS</option>
                            <option>BE</option>
                            <option>BEd</option>
                            <option>BFA</option>
                            <option>BFA Hearing Impaired</option>
                            <option>BFSc</option>
                            <option>BFT</option>
                            <option>BHM</option>
                            <option>BHMS</option>
                            <option>BIL Bachelor of Industrial Law</option>
                            <option>BIT</option>
                            <option>BLiSc</option>
                            <option>BMMC</option>
                            <option>BMS - Bachelor of Management Studies</option>
                            <option>BNYS</option>
                            <option>BPA</option>
                            <option>BPE</option>
                            <option>BPEd</option>
                            <option>BPharm</option>
                            <option>BPlan</option>
                            <option>BPT</option>
                            <option>BRIT - Bachelor of Radiology and Imaging Technology</option>
                            <option>BRS - Bachelor in Rehabilitation Scinece</option>
                            <option>BRT Bachelor in Rehabilitation Technology</option>
                            <option>BSc</option>
                            <option>BSc Honours </option>
                            <option>BSc Honours Agriculture</option>
                            <option>BSc MLT</option>
                            <option>BScEd</option>
                            <option>BSMS</option>
                            <option>BSW</option>
                            <option>BTech</option>
                            <option>BTHM</option>
                            <option>BTM (Honours)</option>
                            <option>BTS</option>
                            <option>BTTM</option>
                            <option>BUMS</option>
                            <option>BVA - Bachelor of Visual Arts</option>
                            <option>BVC Bachelor of Visual Communication</option>
                            <option>BVSC&amp;AH</option>
                            <option>Degree from Indian Institute of Forest Management</option>
                            <option>Degree in Special Training in Teaching HI/VI/MR</option>
                            <option>Graduation in Cardio Vascular Technology</option>
                            <option>Integrated Five Year BA,LLB Degree</option>
                            <option>Integrated Five Year BCom,LLB Degree</option>
                            <option>LLB</option>
                            <option>MBBS</option>
                            <option>Post Basic B.Sc</option>
                        </select>
                        <div class="input-group-append percent_box">
                            <input type="text" class="form-control" id="degree_m" name="marks[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['marks'][2] : '';?>" onkeypress="return decimalNum(event);" maxlength="5" />

                        </div>
                        <div class="input-group-prepend percentageSpan">
                            <span class="input-group-text">%</span>
                        </div>
                    </div><label class="error" id="degree_msg"></label>

                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group"> <label>PG</label>
                    <input type="hidden" name="category[]" value="pg" />
                    <div class="input-group">
                        <select type="text" class="form-control subject_select" name="qualification[]">
                            <?php echo (isset($_SESSION)&$_SESSION['qualification'][3]!="") ? ' <option>'.$_SESSION['qualification'][3].'</option>' : '';?>
                            <option value="">Select</option>
                            <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                            <option value="BA - MA Integrated">BA - MA Integrated</option>
                            <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                            <option value="DM">DM</option>
                            <option value="DNB">DNB</option>
                            <option value="LLM">LLM</option>
                            <option value="M Des  Master of Design">M Des Master of Design</option>
                            <option value="MA">MA</option>
                            <option value="MArch">MArch</option>
                            <option value="Master in Audiology and Speech Language Pathology(MASLP)">Master in Audiology and Speech Language Pathology(MASLP)</option>
                            <option value="Master in Software Engineering">Master in Software Engineering</option>
                            <option value="Master of Applied Science">Master of Applied Science</option>
                            <option value="Master of Communication">Master of Communication</option>
                            <option value="Master of Fashion Technology">Master of Fashion Technology</option>
                            <option value="Master of Health Administration">Master of Health Administration</option>
                            <option value="Master of Hospital Administration">Master of Hospital Administration</option>
                            <option value="Master of Human Resource Management">Master of Human Resource Management</option>
                            <option value="Master of Interior  Architecture and Design">Master of Interior Architecture and Design</option>
                            <option value="Master of International Business">Master of International Business</option>
                            <option value="Master of Journalism and Television Production">Master of Journalism and Television Production</option>
                            <option value="Master of Management in Hospitality">Master of Management in Hospitality</option>
                            <option value="Master of Occupational Therapy - MOT">Master of Occupational Therapy - MOT</option>
                            <option value="Master of Public Health">Master of Public Health</option>
                            <option value="Master of Rehabilitation Science">Master of Rehabilitation Science</option>
                            <option value="Master of Rural Development">Master of Rural Development</option>
                            <option value="Master of Technology (Pharm)">Master of Technology (Pharm)</option>
                            <option value="Master of Tourism Management">Master of Tourism Management</option>
                            <option value="Master of Travel and Tourism Management">Master of Travel and Tourism Management</option>
                            <option value="Master of Urban and Rural Planning">Master of Urban and Rural Planning</option>
                            <option value=">Master of Visual Communication">Master of Visual Communication</option>
                            <option value="Master of Womens Studies">Master of Womens Studies</option>
                            <option value="Masters in Business Law">Masters in Business Law</option>
                            <option value="MBA">MBA</option>
                            <option value="MBEM Master of Building Engineering and Management">MBEM Master of Building Engineering and Management </option>
                            <option value="MCA">MCA</option>
                            <option value="MCh">MCh</option>
                            <option value="MCJ">MCJ</option>
                            <option value="MCom">MCom</option>
                            <option value="MCP Master in City Planning">MCP Master in City Planning</option>
                            <option value="MD">MD</option>
                            <option value="MD Homeo">MD Homeo</option>
                            <option>MD SIDHA</option>
                            <option value="MD SIDHA">MD-Ayurveda</option>
                            <option value="MDS">MDS</option>
                            <option value="ME">ME </option>
                            <option value="MEd">MEd</option>
                            <option value="MFA">MFA</option>
                            <option value="MFM Master of Fashion Management">MFM Master of Fashion Management</option>
                            <option value="MFM Master of Financial Management">MFM Master of Financial Management</option>
                            <option value="MFSc">MFSc</option>
                            <option value="MHMS">MHMS</option>
                            <option value="MHSc CCD">MHSc CCD</option>
                            <option value="MLA Master of Landscape Architecture">MLA Master of Landscape Architecture</option>
                            <option value="MLiSc">MLiSc</option>
                            <option value="MPA">MPA</option>
                            <option value="MPE">MPE</option>
                            <option value="MPEd">MPEd</option>
                            <option value="MPharm">MPharm</option>
                            <option value="MPhil - Arts">MPhil - Arts</option>
                            <option value="MPhil - Clinical Psychology">MPhil - Clinical Psychology</option>
                            <option value="MPhil - Commerce">MPhil - Commerce</option>
                            <option value="MPhil - Education">MPhil - Education</option>
                            <option value="MPhil - Futures Studies">MPhil - Futures Studies</option>
                            <option value="MPhil - Management Studies">MPhil - Management Studies</option>
                            <option>Mphil - Medical and Social Psychology">Mphil - Medical and Social Psychology</option>
                            <option value="MPhil - Physical Education">MPhil - Physical Education</option>
                            <option value="MPhil - Science">MPhil - Science</option>
                            <option value="Mphil - Theatre Arts ">Mphil - Theatre Arts </option>
                            <option value="MPlan">MPlan</option>
                            <option value="MPT">MPT</option>
                            <option value="MS Master of Science">MS Master of Science </option>
                            <option value="MS Master of Surgery">MS Master of Surgery</option>
                            <option value="MS Pharm">MS Pharm</option>
                            <option value="MSc">MSc</option>
                            <option value="MSc 5 years">MSc 5 years</option>
                            <option value="MSc MLT">MSc MLT</option>
                            <option value="MScEd">MScEd</option>
                            <option value="MScTech">MScTech</option>
                            <option value="MSW">MSW</option>
                            <option value="MTA">MTA</option>
                            <option value="MTech">MTech</option>
                            <option value="MUD Master of Urban Design">MUD Master of Urban Design</option>
                            <option value="MVA Master of Visual Arts1">MVA Master of Visual Arts</option>
                            <option value="MVSc">MVSc</option>
                            <option value="One Year Post Graduate Diploma in Personnel Management and Industrial Relations">One Year Post Graduate Diploma in Personnel Management and Industrial Relations</option>
                            <option value="P G Diploma in Quality Assurance in Microbiology">P G Diploma in Quality Assurance in Microbiology</option>
                            <option value="PDCFA">PDCFA</option>
                            <option value="PG  Diploma (from Other Institutions)">PG Diploma (from Other Institutions)</option>
                            <option value="PG  Diploma (from University)">PG Diploma (from University)</option>
                            <option value="PG Certificate in  Career Educational Councelling">PG Certificate in Career Educational Councelling</option>
                            <option value="PG Certificate in Criminology and Criminal Justice Admin">PG Certificate in Criminology and Criminal Justice Admin.</option>
                            <option value="PG Diploma in Accomodation Operation and Management">PG Diploma in Accomodation Operation and Management</option>
                            <option value="PG Diploma in Beauty Therapy">PG Diploma in Beauty Therapy</option>
                            <option value="PG Diploma in Beauty Therapy and Cosmetology">PG Diploma in Beauty Therapy and Cosmetology</option>
                            <option value="PG Diploma in Clinical Perfusion">PG Diploma in Clinical Perfusion</option>
                            <option value="PG Diploma in Dialysis Therapy">PG Diploma in Dialysis Therapy</option>
                            <option value="PG Diploma in Food Analysis and Quality Assuarance">PG Diploma in Food Analysis and Quality Assuarance</option>
                            <option value="PG Diploma in Medicine">PG Diploma in Medicine</option>
                            <option value="PG Diploma in Neuro Electro Physiology">PG Diploma in Neuro Electro Physiology</option>
                            <option value="PG Diploma in Plastic Processing and Testing">PG Diploma in Plastic Processing and Testing</option>
                            <option value="PG Diploma in Plastic Processing Technology">PG Diploma in Plastic Processing Technology</option>
                            <option value="PG Diploma in Wind Power Development">PG Diploma in Wind Power Development</option>
                            <option value="PG Professional Diploma in Special Education">PG Professional Diploma in Special Education</option>
                            <option value="PG Translation Diploma English-Hindi">PG Translation Diploma English-Hindi</option>
                            <option value="PGDBA HR">PGDBA HR</option>
                            <option value="PGDHRM">PGDHRM</option>
                            <option value="PGDiploma in Dialysis Technology PGDDT">PGDiploma in Dialysis Technology PGDDT</option>
                            <option value="Pharm D">Pharm D</option>
                            <option value="Post Graduate Diploma in AccommodationOperation and Mngmnt">Post Graduate Diploma in AccommodationOperation and Mngmnt</option>
                            <option value="Post Graduate Diploma in Anaesthesiology (DA)">Post Graduate Diploma in Anaesthesiology (DA)</option>
                            <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option>
                            <option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
                            <option value="Post Graduate Diploma in Child Health">Post Graduate Diploma in Child Health</option>
                            <option value="Post Graduate Diploma in Clinical Child Development">Post Graduate Diploma in Clinical Child Development</option>
                            <option value="Post Graduate Diploma in Clinical Nutrition and Dietetics">Post Graduate Diploma in Clinical Nutrition and Dietetics</option>
                            <option value="Post Graduate Diploma in Clinical Pathology">Post Graduate Diploma in Clinical Pathology</option>
                            <option value="Post Graduate Diploma in Clinical Psychology">Post Graduate Diploma in Clinical Psychology</option>
                            <option value="Post Graduate Diploma in Counselling">Post Graduate Diploma in Counselling</option>
                            <option value="Post Graduate Diploma in Dairy Development">Post Graduate Diploma in Dairy Development</option>
                            <option value="Post Graduate Diploma in Dairy Quality Control">Post Graduate Diploma in Dairy Quality Control</option>
                            <option value="Post Graduate Diploma in Dissaster management">Post Graduate Diploma in Dissaster management</option>
                            <option value="Post Graduate Diploma in eGovernance">Post Graduate Diploma in eGovernance</option>
                            <option value="Post Graduate Diploma in Finance and HR Management">Post Graduate Diploma in Finance and HR Management</option>
                            <option value="Post Graduate Diploma in Financial Management">Post Graduate Diploma in Financial Management</option>
                            <option value="Post Graduate Diploma in Folk Dance and Cultural studies">Post Graduate Diploma in Folk Dance and Cultural studies</option>
                            <option value="Post Graduate Diploma in Food Science and Technology">Post Graduate Diploma in Food Science and Technology </option>
                            <option value="Post Graduate Diploma in International Business Operations">Post Graduate Diploma in International Business Operations</option>
                            <option value="Post Graduate Diploma in IT Enabled Services and BPO">Post Graduate Diploma in IT Enabled Services and BPO</option>
                            <option value="Post Graduate Diploma in Journalism">Post Graduate Diploma in Journalism</option>
                            <option value="Post Graduate Diploma in Journalism and Communication">Post Graduate Diploma in Journalism and Communication</option>
                            <option value="Post Graduate Diploma in Management">Post Graduate Diploma in Management</option>
                            <option value="Post Graduate Diploma in Management (PGDM)">Post Graduate Diploma in Management (PGDM)</option>
                            <option value="Post Graduate Diploma in Management of Learning Disabilities">Post Graduate Diploma in Management of Learning Disabilities</option>
                            <option value="Post Graduate Diploma in Marine Technology (Mechanical)">Post Graduate Diploma in Marine Technology (Mechanical)</option>
                            <option value="Post Graduate Diploma in Marketing Management">Post Graduate Diploma in Marketing Management</option>
                            <option value="Post Graduate Diploma in Nutrition and Dietetics">Post Graduate Diploma in Nutrition and Dietetics</option>
                            <option value="Post Graduate Diploma in Orthopaedics">Post Graduate Diploma in Orthopaedics</option>
                            <option value="Post Graduate Diploma in Otorhyno Laryngology">Post Graduate Diploma in Otorhyno Laryngology</option>
                            <option value="Post Graduate Diploma in Personnel Management">Post Graduate Diploma in Personnel Management</option>
                            <option value="Post Graduate Diploma in Psychiatric Social Work">Post Graduate Diploma in Psychiatric Social Work</option>
                            <option value="Post Graduate Diploma in Public Relations">Post Graduate Diploma in Public Relations</option>
                            <option value="Post Graduate Diploma in Public Relations Management">Post Graduate Diploma in Public Relations Management</option>
                            <option value="Post Graduate Diploma in Regional/City Planning">Post Graduate Diploma in Regional/City Planning</option>
                            <option value="Post Graduate Diploma in Software Engineering">Post Graduate Diploma in Software Engineering</option>
                            <option value="Post graduate Diploma in Town and Country Planning">Post graduate Diploma in Town and Country Planning</option>
                            <option value="Post Graduate Diploma in Travel and Tourism Management">Post Graduate Diploma in Travel and Tourism Management</option>
                            <option value="Professional Diploma in Clinical Psychology">Professional Diploma in Clinical Psychology</option>
                        </select>
                        <div class="input-group-append percent_box">
                            <input type="text" class="form-control" id="pg_m" name="marks[]" value="<?php echo  (array_key_exists("marks",$_SESSION)) ? $_SESSION['marks'][3] : '';?>" onkeypress="return decimalNum(event);" maxlength="5" />
                        </div>
                        <div class="input-group-prepend percentageSpan">
                            <span class="input-group-text">%</span>
                        </div>
                    </div><label class="error" id="pg_msg"></label>

                </div>
            </div>

            <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Additional Qualifications</label>
                    <input type="hidden" name="category[]" value="other" />
                    <div class="input-group">
                        <input type="text" class="form-control otherField" placeholder="Other" name="qualification[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['qualification'][4] : '';?>"/>
                        <div class="input-group-append percent_box">
                            <input type="text" class="form-control"  id="other_m" name="marks[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['marks'][4] : '';?>" onkeypress="return decimalNum(event);"  maxlength="5"  />
                        </div> 
                        <div class="input-group-prepend percentageSpan">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <label class="error" id="other_msg"></label>
                    <button type="button" class="btn btn-default add_wrap_pos" id="add_more"><i class="fa fa-plus"></i></button>
                </div>
            </div> -->

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="adding_section">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Additional Qualifications</label>
                                <input type="hidden" name="category[]" value="other" />
                                <div class="input-group">
                                    <input type="text" class="form-control otherField" placeholder="Additional Qualifications" name="qualification[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['qualification'][4] : '';?>" />
                                    <div class="input-group-append percent_box">
                                        <input type="text" class="form-control" id="other_m" name="marks[]" value="<?php echo (array_key_exists("marks",$_SESSION)) ? $_SESSION['marks'][4] : '';?>" onkeypress="return decimalNum(event);" maxlength="5" />
                                    </div>
                                    <div class="input-group-prepend percentageSpan">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <label class="error" id="other_msg"></label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default add_wrap_pos btn_add_plus" id="add_more_qual"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div id="more_others">
                    <?php
                    // show($_SESSION);$this->session->userdata()
                    if(array_key_exists("qualification",$_SESSION) && array_key_exists("5",$_SESSION['qualification']) && $_SESSION['qualification'][5]!='' && count($_SESSION['qualification'])>5){
                    
                    $other_array=array();
                    $marks_array=array();
                    $category=$_SESSION['category'];
                    $qualification=$_SESSION['qualification'];
                    $marks=$_SESSION['marks'];
                   
                      foreach($category as $key=>$row)
                      { 
                          if($row == 'other')
                          {
                              array_push($other_array,$qualification[$key]);
                              array_push($marks_array,$marks[$key]);
                          }
                      }
                  
                   if(count($other_array) >1)
                   {
                      
                     foreach($other_array as $key1=>$val)
                     { $count=count($other_array);
                         if($key1>=1)
                         { $i=1;
                            ?>
                    <div class="row" id="new_textbox<?php echo $i; ?>">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="adding_section">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group"> <input type="hidden" name="category[]" value="other" />
                                            <div class="input-group input_group_form"> <input type="text" class="form-control otherField" placeholder="Additional Qualifications" id="qual" name="qualification[]" value="<?php echo $val;?>" />
                                                <div class="input-group-append percent_box"><input type="text" class="form-control numbersOnly" placeholder="" name="marks[]" value="<?php echo $marks_array[$key1];?>" onkeypress="return decmalNum(event);" /></div>
                                                <div class="input-group-prepend percentageSpan"> <span class="input-group-text">%</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><button type="button" id="delete" class="btn add_wrap_pos btn-danger remove_section remove_this btn_remove_minus" id="row['<?php echo $i; ?>']" onclick="delete_others('<?php echo $i; ?>')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
               

            <?php
                             
                         }
                     }
                       $i++;
                   }
                    }
                    ?>
        </div>
        <input type="hidden" id="counter" <?php if(array_key_exists("category",$_SESSION) && array_key_exists("5",$_SESSION['category']) && count($_SESSION['category'])>=5){ ?> value="<?php echo $count; ?>" <?php }else{ ?> value="1" <?php } ?>/>
    </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label style="display: block">&nbsp;</label>
                <a class="btn btn-warning btn_prev">Previous</a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label style="display: block">&nbsp;</label>
                <button class="btn btn-warning btn_next" type="submit">Next</button>
            </div>
        </div>

    </div>



    </div>
</form>
<?php $this->load->view("home/scripts/register_secondpage_script");  ?>