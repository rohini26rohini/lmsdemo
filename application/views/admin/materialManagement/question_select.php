
    <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="white_card">
                    <h6>Examination-Question Paper Setup</h6>
                    <hr>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Examination Name</label>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label style="display: block">&nbsp;</label>
                                <button class="btn btn-info btn_save">Save</button>
                                <button class="btn btn-default btn_cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select Question Set</label>
                                <select class="form-control">
                                            <option>Qualification1</option>
                                            <option>Qualification1</option>
                                            <option>Qualification1</option>
                                            <option>Qualification1</option>
                                        </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label style="display: block">&nbsp;</label>
                                <button class="btn btn-info btn_save">Go</button>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="ques_stat">
                                <span>English : 20</span>
                                <span>Mathematics : 20</span>
                                <span>GK : 20</span>
                            </p>
                        </div>
                    </div>
                    <div class="relative">
                        <button class="btn btn-info btn_ques">
                        <i class="fa fa-angle-double-right"></i>
                        </button>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="table-responsive table_language padding_right_15">
                                    <table class="table table-bordered table-striped table-sm">
                                        <tr>
                                            <th colspan="3">Select Questions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th>Question</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Lorem Ipsum dummy text of content</td>
                                            <td><input type="checkbox" value=""></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Lorem Ipsum dummy text of content</td>
                                            <td><input type="checkbox" value=""></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Lorem Ipsum dummy text of content</td>
                                            <td><input type="checkbox" value=""></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="table-responsive table_language padding_left_15">
                                    <table class="table table-bordered table-striped table-sm">
                                        <tr>
                                            <th colspan="3">Selected Questions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th>Question</th>
                                            <th style="width: 50px;">
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Lorem Ipsum dummy text of content</td>
                                            <td><a class="btn btn-default option_btn" title="Delete">
                        <i class="fa fa-trash-o"></i>
                        </a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/scripts/materialManagement/question_select_script'); ?>