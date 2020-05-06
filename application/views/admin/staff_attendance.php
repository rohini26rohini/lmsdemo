<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="white_card">
                <h6>Attendance Marking</h6>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="AttendanceNav AttendancBatch">
                            <ul class="nav nav-bar ">

                                <li>
                                    <label>Date</label>
                                    <input type="text" name="date" id="date" class="form-control dob" autocomplete="off" value="<?php echo date('d-m-Y');?>">
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
                <span id="schedulesloader">
                    <div class="row">
                        <div class="col-12">
                            <div class="AttendanceNav">
                                <ul class="nav nav-bar ">
                                    <li>
                                        <span class="bg-success"></span>Marked
                                    </li>
                                    <li>
                                        <span class="bg-primary"></span>Unmarked
                                    </li>
                                    

                                </ul>
                            </div>
                        </div>
                    </div>

                </span>
                <span id="loadattendancesheet">
                    <!-- <div class="AttendanceStatus">
                                    <ul class="nav nav-bar">
                                        <li><h6>Present <i class="fa fa-check" style="color:#28a745;"></i></h6></li>
                                        <li><h6>Absent <i class="fa fa-times" aria-hidden="true" style="color:red;"></i></h6></li>
                                    </ul>



                                </div>
                                <div class="AttendanTabl">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Role</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <?php
                                                        if(!empty($staffArr))
                                                        {
                                                        foreach($staffArr as $staff)                   {
                                                                ?>
                                                       
                                                        <tr>
                                                            <td> <?php echo $staff['name'];?></td>
                                                            <td> <?php echo $staff['role_name'];?></td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                         <?php
                                                                
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                        <tr>
                                                             <th>Name</th>
                                                            <th>Role</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>

                                                        <tr>
                                                            <td>01</td>
                                                            <td>Features</td>
                                                            <td><i class="fa fa-check"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                </span>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/staff_attendance_script");?>
