<div class="relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Add Student Details</h6>
        <hr/>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#reg1" id="reg_1">Personnel Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#reg2" id="reg_2"> Qualifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#reg3" id="reg_3">Others</a>
            </li>
            <li class="nav-item">
                <a class="nav-link getothers"  data-toggle="pill" href="#reg4"   id="reg_4">Documents</a>
            </li>
            <li class="nav-item">
            <!-- <a class="nav-link courseallocation" data-toggle="pill" href="#reg55" id="reg_55">Batch Allocation</!-->
                <a class="nav-link" data-toggle="pill" href="#reg5" id="reg_5">Batch Allocation</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link getfeediscount" data-toggle="pill" href="#reg7" id="reg_7">Fee Discount</a>
            </li>
            <li class="nav-item">
                <a class="nav-link getbatchfee" data-toggle="pill" href="#reg6" id="reg_6">Payment</a>
            </li>
            <?php if($studentArr['status']==1){ ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#reg8" id="reg_8">ID card</a>
                </li>
            <?php } ?> -->
        </ul>
        <div class="tab-content"> 
            <div id="reg1" class=" tab-pane active">
                <?php $this->load->view('admin/students/student_reg_view_1'); ?>
            </div>
            <div id="reg2" class=" tab-pane fade">
                <?php $this->load->view('admin/students/student_reg_view_2'); ?>
            </div>
            <div id="reg3" class=" tab-pane fade">
                <?php $this->load->view('admin/students/student_reg_view_3'); ?>
            </div>
            <div id="reg4" class=" tab-pane fade">
                <div id="append_document">
                <?php $this->load->view('admin/students/student_reg_view_4'); ?>
                </div>
            </div>
            <!-- <div id="reg55" class=" tab-pane fade">
                <div id="append_course">
                <?php //$this->load->view('admin/students/student_reg_view_55'); ?>
                </div>
            </div> -->
            <div id="reg5" class=" tab-pane fade">
                <?php $this->load->view('admin/students/student_reg_view_5'); ?>
            </div>
             <div id="reg7" class=" tab-pane fade">
                <?php $this->load->view('admin/students/student_reg_discount_view'); ?>
            </div> 
            <div id="reg6" class=" tab-pane fade">
                <form id="feepayment_form" method="POST">
                    <?php
                    
                    ?>
                </form>
            </div>
            <?php if($studentArr['status']==1){ ?>
                <div id="reg8" class=" tab-pane fade">
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/student_register_script"); ?> 
