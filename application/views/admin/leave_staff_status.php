<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 "><div class="white_card ">
                    <div class="tab_nav">
                        <div class="tab_box ">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="add_dtl" style="display: none;"></div>
                                    <div class="dtl_tbl show_form_add"  style="min-height: auto;" >
                                                <h6><?php echo $this->lang->line('staff_salary_scheme'); ?></h6>
												<hr class="hrCustom">
                                        <div class="table-responsive table_language">
                                            <table class="table table-striped table-sm dataTable no-footer" id="leave_status" table="leave_status" action_url="<?php echo base_url() ?>service/Leave_data/leave_status_details">
                                                <thead>
                                                    <tr class="bg-warning text-white ">
                                                        <th><?php echo $this->lang->line('id'); ?></th>
                                                        <th><?php echo $this->lang->line('staff'); ?></th>
                                                        <th><?php echo $this->lang->line('leave_scheme'); ?></th>
                                                        <th><?php echo $this->lang->line('allowed_leave_count'); ?></th>
                                                        <th><?php echo $this->lang->line('leave_taken'); ?></th>
                                                        <th><?php echo $this->lang->line('balance_leave_count'); ?></th>
                                                        <th><?php echo $this->lang->line('additional_leave_taken'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<?php $this->load->view('admin/scripts/leave_staff_status_script'); ?>