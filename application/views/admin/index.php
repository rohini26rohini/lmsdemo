<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="transparent_card ">
        <!-- Data Table Plugin Section Starts Here -->
        <div class="row ">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                <button class="btn btn-default pagination_nav ">
                                    <i class="fa fa-caret-left "></i>
                                </button>
                <button class="btn btn-default pagination_nav ">
                                    <i class="fa fa-caret-right "></i>
                                </button>
                <span class="number_records ">
                                    Showing 1-10 of 103 records.
                                </span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right flex-row-reverse ">
                <button class="btn btn-default option_btn list_option ">
                                    <i class="fa fa-th-list "></i>
                                </button>
                <button class="btn btn-default option_btn grid_option ">
                                    <i class="fa fa-th-large "></i>
                                </button>
                <button class="btn btn-default option_btn filter_btn">
                                    <i class="fa fa-sliders"></i>
                                </button>
                <button class="btn btn-default add_row add_new_btn">
                                    <i class="fa fa-plus "></i>
                                </button>
                <div class="form_box add_new">
                    <div class="form_head">
                        Add New Question
                    </div>
                    <div class="form_body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group"><label>School</label>

                                    <select class="form-control">
                                                        <option value="">Select School</option>
                                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <!--<label>Short Name</label>-->
                                    <input class="form-control" type="file">
                                    <a class="btn btn-info" href="<?php echo base_url();?>uploads/samples/Question_paper_sample.xlsx" download>Click Here to download sample</a>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                                <button class="btn btn-info">Save</button>


                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                                <button class="btn btn-default">Cancel</button>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="form_box filter_new">
                    <div class="form_head">
                        Filter Option
                    </div>
                    <div class="form_body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group"><label>Service Name</label><input class="form-control" type="text" /></div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group"><label>Short Name</label><input class="form-control" type="text" /></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                                <button class="btn btn-info">Filter</button>


                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                                <button class="btn btn-default">Cancel</button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <ul class="data_table ">
                <li class="data_table_head ">
                    <div class="col sl_no ">Sl. No.
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                            <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                        </div>
                    </div>
                    <div class="col avatar ">Avatar</div>
                    <div class="col ">Name of Teacher
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                            <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                        </div>

                    </div>
                    <div class="col ">Email Address
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                            <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                        </div>

                    </div>
                    <div class="col ">Today's Attendance
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                            <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                        </div>

                    </div>
                    <div class="col actions ">Actions</div>
                </li>
                <li>
                    <div class="col sl_no ">1</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">
                        <i class="far present-circle fa-check-circle "></i> Present
                    </div>
                    <div class="col actions ">
                        <button class="btn btn-default view_btn ">VIEW</button>
                        <div class="dropdown ">
                            <button class="action_btn dropdown-toggle " data-toggle="dropdown ">
                                            <i class="fa fa-ellipsis-h "></i>
                                        </button>

                            <div class="dropdown-menu ">
                                <a class="dropdown-item " href="# ">
                                                <i class="fa fa-exclamation-circle "></i>
                                                Leave Taken</a>
                                <a class="dropdown-item " href="# ">
                                                <i class="fa fa-pen-square "></i>
                                                Edit</a>
                                <a class="dropdown-item " href="# ">
                                                <i class="fa fa-trash "></i>
                                                Delete</a>
                            </div>
                        </div>

                    </div>
                </li>
                <li>
                    <div class="col sl_no ">2</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">3</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">4</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">5</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">6</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">7</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">8</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">9</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
                <li>
                    <div class="col sl_no ">10</div>
                    <div class="col avatar "><img src="<?php echo base_url();?>inner_assets/images/avatar.svg " class="img-responsive " /></div>
                    <div class="col ">Daliya Susan George</div>
                    <div class="col ">daliyasusan007@gmail.com</div>
                    <div class="col ">Present</div>
                    <div class="col actions ">--</div>
                </li>
            </ul>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
