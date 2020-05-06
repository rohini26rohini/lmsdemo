<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('career');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <div class="addBtnPosition">
            <button class="btn btn-default add_row add_new_btn btn_add_call " data-toggle="modal" data-target="#add_career" onclick="formclear('gs_form')">
                <?php echo $this->lang->line('add_career');?>
            </button>
            <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>backoffice/received-applications">
                <?php echo $this->lang->line('received_applications');?>
            </a>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('job_title');?></th>
                        <th ><?php echo $this->lang->line('location');?></th> 
                        <th ><?php echo $this->lang->line('carrer_last_date');?></th>
                        <th ><?php echo $this->lang->line('employment_type');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($career_data as $data){ 
                ?>
                    <tr id="row_<?php echo $data->careers_id;?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="careers_<?php echo $data->careers_id;?>"> 
                            <?php echo $data->careers_name;?>
                        </td>
                        <td id="location_<?php echo $data->careers_id;?>">
                            <?php echo $data->careers_location;?>
                        </td>
                        <td id="date_<?php echo $data->careers_id;?>">
                            <?php echo $data->careers_date;?>
                        </td>
                        <td id="employment_type_<?php echo $data->careers_id;?>">
                            <?php echo $data->careers_employment_type;?>
                        </td>
                        <td id="status_<?php echo $data->careers_id;?>">
                            <?php if($data->careers_status == 0){?>
                                <span class="btn mybutton mybuttonInactive" onclick="edit_career_status('<?php echo $data->careers_id; ?>','<?php echo $data->careers_status; ?>')">Inactive</span>
                            <?php }else if($data->careers_status == 1) {?>
                                <span class="btn mybutton  mybuttonActive" onclick="edit_career_status('<?php echo $data->careers_id; ?>','<?php echo $data->careers_status; ?>')">Active</span>
                            <?php }?>
                        </td>
                        <td id="action_<?php echo $data->careers_id;?>">
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_career_Data('<?php echo $data->careers_id;?>')">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <?php if($data->careers_status == 0){?>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_career_Data('<?php echo $data->careers_id;?>')">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <?php }?>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div> 

<!--add discount modal-->
<div id="add_career" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_career');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="career_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('job_title');?> <span class="req redbold">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" onkeypress="return valNames(event);" placeholder="<?php echo $this->lang->line('name');?>" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('location');?> <span class="req redbold">*</span></label>
                                <select class="form-control"  name="location" id="location">
                                    <option value="">Select</option>
                                    <?php foreach($DistrictArr as $district){?>
                                        <option value="<?php echo $district['name'];?>"><?php echo $district['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group">
                                <label><?php echo $this->lang->line('carrer_last_date');?> <span class="req redbold">*</span></label>
                                <input type="text" name="career_date" id="career_date" class="form-control duedate" placeholder="<?php echo $this->lang->line('indian_date_format');?>" autocomplete="off"/>
                                
                            
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group">
                                <label><?php echo $this->lang->line('eligibility');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="eligibility" id="eligibility">
                                    <option value="">Select</option>
                                    <option value="AHSLC">AHSLC</option>
                                    <option value="Anglo Indian School Leaving Certificate">Anglo Indian School Leaving Certificate</option>
                                    <option value="CBSE Xth">CBSE Xth</option>
                                    <option value="ICSE Xth">ICSE Xth</option>
                                    <option value="JTSLC">JTSLC</option>
                                    <option value="Matriculation Certificate">Matriculation Certificate</option>
                                    <option value="Secondary School Examination">Secondary School Examination</option>
                                    <option value="SSC">SSC</option>
                                    <option value="SSLC">SSLC</option>
                                    <option value="SSLC with Agricultural Optional">SSLC with Agricultural Optional</option>
                                    <option value="Standard X Equivalency">Standard X Equivalency</option>
                                    <option value="THSLC Xth">THSLC Xth</option>
                                    <option value="AHSS">AHSS</option>
                                    <option value="CBSE XIIth">CBSE XIIth</option>
                                    <option value="ICSE XIIth">ICSE XIIth</option>
                                    <option value="Plus 2">Plus 2</option>
                                    <option value="Plus Two Equivalency">Plus Two Equivalency</option>
                                    <option value="Pre Degree">Pre Degree</option>
                                    <option value="Pre University">Pre University</option>
                                    <option value="Senior Secondary School Examination">Senior Secondary School Examination</option>
                                    <option value="SSSC">SSSC</option>
                                    <option value="THSE - XII">THSE - XII</option>
                                    <option value="VHSE">VHSE</option>
                                    <option value="VHSE Pass in Trade only for Employment Purpose">VHSE Pass in Trade only for Employment Purpose</option>
                                    <option value="B Voc">B Voc</option>
                                    <option value="BA">BA</option>
                                    <option value="BA Honours">BA Honours</option>
                                    <option value="Bachelor of Audiology and Speech Language Pathology(BASLP)">Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                                    <option value="Bachelor of BusineesAdministration & Bachelor of Laws(Honours)">Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                                    <option value="Bachelor of Design">Bachelor of Design</option>
                                    <option value="Bachelor of Divinity">Bachelor of Divinity</option>
                                    <option value="Bachelor of Occupational Therapy - BOT">Bachelor of Occupational Therapy - BOT</option>
                                    <option value="Bachelor of Science BS">Bachelor of Science BS</option>
                                    <option value="Bachelor of Science in Applied Sciences">Bachelor of Science in Applied Sciences</option>
                                    <option value="Bachelor of Textile">Bachelor of Textile</option>
                                    <option value="BAL">BAL</option>
                                    <option value="BAM">BAM</option>
                                    <option value="BAMS">BAMS</option>
                                    <option value="BArch">BArch</option>
                                    <option value="BBA">BBA</option>
                                    <option value="BBM">BBM</option>
                                    <option value="BBS">BBS</option>
                                    <option value="BBS Bachelor of Business Studies">BBS Bachelor of Business Studies</option>
                                    <option value="BBT">BBT</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BCJ">BCJ</option>
                                    <option value="BCom">BCom</option>
                                    <option value="BComHonours">BComHonours</option>
                                    <option value="BComEd">BComEd</option>
                                    <option value="BCS - Bachelor of Corporate Secretaryship">BCS - Bachelor of Corporate Secretaryship</option>
                                    <option value="BCVT">BCVT </option>
                                    <option value="BDS">BDS</option>
                                    <option value="BE">BE</option>
                                    <option value="BEd">BEd</option>
                                    <option value="BFA">BFA</option>
                                    <option value="BFA Hearing Impaired">BFA Hearing Impaired</option>
                                    <option value="BFSc">BFSc</option>
                                    <option value="BFT">BFT</option>
                                    <option value="BHM">BHM</option>
                                    <option value="BHMS">BHMS</option>
                                    <option value="BIL Bachelor of Industrial Law">BIL Bachelor of Industrial Law</option>
                                    <option value="BIT">BIT</option>
                                    <option value="BLiSc">BLiSc</option>
                                    <option value="BMMC">BMMC</option>
                                    <option value="BBMS - Bachelor of Management StudiesPA">BMS - Bachelor of Management Studies</option>
                                    <option value="BNYS">BNYS</option>
                                    <option value="BPA">BPA</option>
                                    <option value="BPE">BPE</option>
                                    <option value="BPEd">BPEd</option>
                                    <option value="BPharm">BPharm</option>
                                    <option value="BPlan">BPlan</option>
                                    <option value="BPT">BPT</option>
                                    <option value="BRIT - Bachelor of Radiology and Imaging Technology">BRIT - Bachelor of Radiology and Imaging Technology</option>
                                    <option value="BRS - Bachelor in Rehabilitation Scinece">BRS - Bachelor in Rehabilitation Scinece</option>
                                    <option value="BRT Bachelor in Rehabilitation Technology">BRT Bachelor in Rehabilitation Technology</option>
                                    <option value="BSc">BSc</option>
                                    <option value="BSc Honours">BSc Honours </option>
                                    <option value="BSc Honours Agriculture">BSc Honours Agriculture</option>
                                    <option value="BSc MLT">BSc MLT</option>
                                    <option value="BScEd">BScEd</option>
                                    <option value="BSMS">BSMS</option>
                                    <option value="BSW">BSW</option>
                                    <option value="BTech">BTech</option>
                                    <option value="BTHM">BTHM</option>
                                    <option value="BTM (Honours)">BTM (Honours)</option>
                                    <option value="BTS">BTS</option>
                                    <option value="BTTM">BTTM</option>
                                    <option value="BUMS">BUMS</option>
                                    <option value="BVA - Bachelor of Visual Arts">BVA - Bachelor of Visual Arts</option>
                                    <option value="BVC Bachelor of Visual Communication">BVC Bachelor of Visual Communication</option>
                                    <option value="BVSC & AH">BVSC&amp;AH</option>
                                    <option value="Degree from Indian Institute of Forest Management">Degree from Indian Institute of Forest Management</option>
                                    <option value="Degree in Special Training in Teaching HI/VI/MR">Degree in Special Training in Teaching HI/VI/MR</option>
                                    <option value="Graduation in Cardio Vascular Technology">Graduation in Cardio Vascular Technology</option>
                                    <option value="Integrated Five Year BA,LLB Degree">Integrated Five Year BA,LLB Degree</option>
                                    <option value="Integrated Five Year BCom,LLB Degree">Integrated Five Year BCom,LLB Degree</option>
                                    <option value="LLB">LLB</option>
                                    <option value="MBBS">MBBS</option>
                                    <option value="Post Basic B.Sc">Post Basic B.Sc</option>
                                    <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                                    <option value="BA - MA Integrated">BA - MA Integrated</option>
                                    <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                                    <option value="DM">DM</option>
                                    <option value="DNB">DNB</option>
                                    <option value="LLM">LLM</option>
                                    <option value="M Des  Master of Design">M Des  Master of Design</option>
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
                                    <option value="Master of Interior  Architecture and Design">Master of Interior  Architecture and Design</option>
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
                                    <option>Mphil - Medical and Social Psychology"&gt;Mphil - Medical and Social Psychology</option>
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
                                    <option value="PG  Diploma (from Other Institutions)">PG  Diploma (from Other Institutions)</option>
                                    <option value="PG  Diploma (from University)">PG  Diploma (from University)</option>
                                    <option value="PG Certificate in  Career Educational Councelling">PG Certificate in  Career Educational Councelling</option>
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
                                    <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option><option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
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
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                            <label><?php echo $this->lang->line('base_salary');?> <span class="req redbold">*</span></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="base_salary_from" id="base_salary_from">
                                        <option value="">From</option>
                                        <?php for($i=2000; $i<=200000; $i=$i+1000){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="base_salary_to" id="base_salary_to">
                                        <option value="">To</option>
                                        <?php for($i=2000; $i<=200000; $i=$i+1000){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <label><?php echo $this->lang->line('experience');?> <span class="req redbold">*</span></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="experience_from" id="experience_from">
                                        <option value="">From</option>
                                        <?php for($i=0; $i<=35; $i++){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="experience_to" id="experience_to">
                                        <option value="">To</option>
                                        <?php for($i=0; $i<=35; $i++){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('employment_type');?> <span class="req redbold">*</span></label>
                                <select class="form-control"  name="employment_type" id="employment_type">
                                    <option value="">Select</option>
                                    <?php foreach($designation as $data){?>
                                        <option value="<?php echo $data->role_name; ?>"><?php echo $data->role_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('job_description');?> <span class="req redbold"></span></label>
                                <textarea name="job_description" id="job_description" rows="10" cols="80"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit_career" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_career');?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_career_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="id" id="id"/>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('job_title');?> <span class="req redbold">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" onkeypress="return valNames(event);" placeholder="<?php echo $this->lang->line('name');?>" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('location');?> <span class="req redbold">*</span></label>
                                <select class="form-control"  name="location" id="edit_location">
                                    <option value="">Select</option>
                                    <?php foreach($DistrictArr as $district){?>
                                        <option value="<?php echo $district['name'];?>"><?php echo $district['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group">
                                <label><?php echo $this->lang->line('carrer_last_date');?> <span class="req redbold">*</span></label>
                                <input type="text" name="career_date" id="edit_career_date" class="form-control duedate" placeholder="<?php echo $this->lang->line('indian_date_format');?>" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group">
                                <label><?php echo $this->lang->line('eligibility');?> <span class="req redbold">*</span></label>
                                <select class="form-control" name="eligibility" id="edit_eligibility">
                                    <option value="">Select</option>
                                    <option value="AHSLC">AHSLC</option>
                                    <option value="Anglo Indian School Leaving Certificate">Anglo Indian School Leaving Certificate</option>
                                    <option value="CBSE Xth">CBSE Xth</option>
                                    <option value="ICSE Xth">ICSE Xth</option>
                                    <option value="JTSLC">JTSLC</option>
                                    <option value="Matriculation Certificate">Matriculation Certificate</option>
                                    <option value="Secondary School Examination">Secondary School Examination</option>
                                    <option value="SSC">SSC</option>
                                    <option value="SSLC">SSLC</option>
                                    <option value="SSLC with Agricultural Optional">SSLC with Agricultural Optional</option>
                                    <option value="Standard X Equivalency">Standard X Equivalency</option>
                                    <option value="THSLC Xth">THSLC Xth</option>
                                    <option value="AHSS">AHSS</option>
                                    <option value="CBSE XIIth">CBSE XIIth</option>
                                    <option value="ICSE XIIth">ICSE XIIth</option>
                                    <option value="Plus 2">Plus 2</option>
                                    <option value="Plus Two Equivalency">Plus Two Equivalency</option>
                                    <option value="Pre Degree">Pre Degree</option>
                                    <option value="Pre University">Pre University</option>
                                    <option value="Senior Secondary School Examination">Senior Secondary School Examination</option>
                                    <option value="SSSC">SSSC</option>
                                    <option value="THSE - XII">THSE - XII</option>
                                    <option value="VHSE">VHSE</option>
                                    <option value="VHSE Pass in Trade only for Employment Purpose">VHSE Pass in Trade only for Employment Purpose</option>
                                    <option value="B Voc">B Voc</option>
                                    <option value="BA">BA</option>
                                    <option value="BA Honours">BA Honours</option>
                                    <option value="Bachelor of Audiology and Speech Language Pathology(BASLP)">Bachelor of Audiology and Speech Language Pathology(BASLP)</option>
                                    <option value="Bachelor of BusineesAdministration & Bachelor of Laws(Honours)">Bachelor of BusineesAdministration&amp;Bachelor of Laws(Honours)</option>
                                    <option value="Bachelor of Design">Bachelor of Design</option>
                                    <option value="Bachelor of Divinity">Bachelor of Divinity</option>
                                    <option value="Bachelor of Occupational Therapy - BOT">Bachelor of Occupational Therapy - BOT</option>
                                    <option value="Bachelor of Science BS">Bachelor of Science BS</option>
                                    <option value="Bachelor of Science in Applied Sciences">Bachelor of Science in Applied Sciences</option>
                                    <option value="Bachelor of Textile">Bachelor of Textile</option>
                                    <option value="BAL">BAL</option>
                                    <option value="BAM">BAM</option>
                                    <option value="BAMS">BAMS</option>
                                    <option value="BArch">BArch</option>
                                    <option value="BBA">BBA</option>
                                    <option value="BBM">BBM</option>
                                    <option value="BBS">BBS</option>
                                    <option value="BBS Bachelor of Business Studies">BBS Bachelor of Business Studies</option>
                                    <option value="BBT">BBT</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BCJ">BCJ</option>
                                    <option value="BCom">BCom</option>
                                    <option value="BComHonours">BComHonours</option>
                                    <option value="BComEd">BComEd</option>
                                    <option value="BCS - Bachelor of Corporate Secretaryship">BCS - Bachelor of Corporate Secretaryship</option>
                                    <option value="BCVT">BCVT </option>
                                    <option value="BDS">BDS</option>
                                    <option value="BE">BE</option>
                                    <option value="BEd">BEd</option>
                                    <option value="BFA">BFA</option>
                                    <option value="BFA Hearing Impaired">BFA Hearing Impaired</option>
                                    <option value="BFSc">BFSc</option>
                                    <option value="BFT">BFT</option>
                                    <option value="BHM">BHM</option>
                                    <option value="BHMS">BHMS</option>
                                    <option value="BIL Bachelor of Industrial Law">BIL Bachelor of Industrial Law</option>
                                    <option value="BIT">BIT</option>
                                    <option value="BLiSc">BLiSc</option>
                                    <option value="BMMC">BMMC</option>
                                    <option value="BBMS - Bachelor of Management StudiesPA">BMS - Bachelor of Management Studies</option>
                                    <option value="BNYS">BNYS</option>
                                    <option value="BPA">BPA</option>
                                    <option value="BPE">BPE</option>
                                    <option value="BPEd">BPEd</option>
                                    <option value="BPharm">BPharm</option>
                                    <option value="BPlan">BPlan</option>
                                    <option value="BPT">BPT</option>
                                    <option value="BRIT - Bachelor of Radiology and Imaging Technology">BRIT - Bachelor of Radiology and Imaging Technology</option>
                                    <option value="BRS - Bachelor in Rehabilitation Scinece">BRS - Bachelor in Rehabilitation Scinece</option>
                                    <option value="BRT Bachelor in Rehabilitation Technology">BRT Bachelor in Rehabilitation Technology</option>
                                    <option value="BSc">BSc</option>
                                    <option value="BSc Honours">BSc Honours </option>
                                    <option value="BSc Honours Agriculture">BSc Honours Agriculture</option>
                                    <option value="BSc MLT">BSc MLT</option>
                                    <option value="BScEd">BScEd</option>
                                    <option value="BSMS">BSMS</option>
                                    <option value="BSW">BSW</option>
                                    <option value="BTech">BTech</option>
                                    <option value="BTHM">BTHM</option>
                                    <option value="BTM (Honours)">BTM (Honours)</option>
                                    <option value="BTS">BTS</option>
                                    <option value="BTTM">BTTM</option>
                                    <option value="BUMS">BUMS</option>
                                    <option value="BVA - Bachelor of Visual Arts">BVA - Bachelor of Visual Arts</option>
                                    <option value="BVC Bachelor of Visual Communication">BVC Bachelor of Visual Communication</option>
                                    <option value="BVSC & AH">BVSC&amp;AH</option>
                                    <option value="Degree from Indian Institute of Forest Management">Degree from Indian Institute of Forest Management</option>
                                    <option value="Degree in Special Training in Teaching HI/VI/MR">Degree in Special Training in Teaching HI/VI/MR</option>
                                    <option value="Graduation in Cardio Vascular Technology">Graduation in Cardio Vascular Technology</option>
                                    <option value="Integrated Five Year BA,LLB Degree">Integrated Five Year BA,LLB Degree</option>
                                    <option value="Integrated Five Year BCom,LLB Degree">Integrated Five Year BCom,LLB Degree</option>
                                    <option value="LLB">LLB</option>
                                    <option value="MBBS">MBBS</option>
                                    <option value="Post Basic B.Sc">Post Basic B.Sc</option>
                                    <option value="Bsc. - Msc. Integrated"> Bsc. - Msc. Integrated</option>
                                    <option value="BA - MA Integrated">BA - MA Integrated</option>
                                    <option value="BSMS Bachelor of Science Master of Science">BSMS Bachelor of Science Master of Science</option>
                                    <option value="DM">DM</option>
                                    <option value="DNB">DNB</option>
                                    <option value="LLM">LLM</option>
                                    <option value="M Des  Master of Design">M Des  Master of Design</option>
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
                                    <option value="Master of Interior  Architecture and Design">Master of Interior  Architecture and Design</option>
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
                                    <option>Mphil - Medical and Social Psychology"&gt;Mphil - Medical and Social Psychology</option>
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
                                    <option value="PG  Diploma (from Other Institutions)">PG  Diploma (from Other Institutions)</option>
                                    <option value="PG  Diploma (from University)">PG  Diploma (from University)</option>
                                    <option value="PG Certificate in  Career Educational Councelling">PG Certificate in  Career Educational Councelling</option>
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
                                    <option value="Post Graduate Diploma in Applied Nutrition and Dietitics">Post Graduate Diploma in Applied Nutrition and Dietitics</option><option value="00~22000043~7">Post Graduate Diploma in Business Management</option>
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
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                            <label><?php echo $this->lang->line('base_salary');?> <span class="req redbold">*</span></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="base_salary_from" id="edit_base_salary_from">
                                        <option value="">From</option>
                                        <?php for($i=2000; $i<=200000; $i=$i+1000){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="base_salary_to" id="edit_base_salary_to">
                                        <option value="">To</option>
                                        <?php for($i=2000; $i<=200000; $i=$i+1000){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <label><?php echo $this->lang->line('experience');?> <span class="req redbold">*</span></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="experience_from" id="edit_experience_from">
                                        <option value="">From</option>
                                        <?php for($i=0; $i<=35; $i++){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">  
                                    <div class="form-group"> 
                                    <select class="form-control"  name="experience_to" id="edit_experience_to">
                                        <option value="">To</option>
                                        <?php for($i=0; $i<=35; $i++){?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('employment_type');?> <span class="req redbold">*</span></label>
                                <select class="form-control"  name="employment_type" id="edit_employment_type">
                                    <option value="">Select</option>
                                    <?php foreach($designation as $data){?>
                                        <option value="<?php echo $data->role_name; ?>"><?php echo $data->role_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('job_description');?> <span class="req redbold"></span></label>
                                <textarea name="job_description" id="edit_job_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/career_script");?>