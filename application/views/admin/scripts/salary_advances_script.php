<?php $this->load->view('admin/scripts/includes/main_script'); ?>
<script  type="text/javascript">
    var oTable;
    var aoColumnDefs = [
        {
            "aTargets": [1],
            "mData": 'sl',
            "mRender": function(data, type, row) {
                return data;
            }
        },{
            "aTargets": [2],
            "mData": 'staff',
            "mRender": function(data, type, row) {
                return data;
            }
        },{
            "aTargets": [3],
            "mData": 2,
            "mRender": function(data, type, row) {
                return convert_date(data);
            }
        },{
            "aTargets": [4],
            "mData": 3,
            "mRender": function(data, type, row) {
                return "<span class='amntRight'>"+data+"</span>";
            }
        },{
            "aTargets": [5],
            "mData": 4,
            "mRender": function(data, type, row) {
                 return data;
            }
        },{
            "aTargets": [6],
            "mData": 5,
            "mRender": function(data, type, row) {
                if(data == 1){
                    return "NEW";
                }else{
                    return "PROCESSED";
                }
            }
        },{
            "aTargets": [7],
            "mData": 6,
            "mRender": function(data, type, row) {
                return data;
            }
        },{
            "aTargets": [8],
            "mData": 8,
            "mRender": function(data, type, row) {
                return convert_date(data);
            }
        },{
            "aTargets": [9],
            "mData": getIdAndPayslip,
            "mRender": function(data, type, row) {
                var res = data.split(",");
                if(res[1] != 0){
                    return "&nbsp;";
                }else{
                    return "<a class='btn btn-default option_btn' title='Delete' onclick='delete_salary_advance("+data+")' ><i class='fa fa-trash-o'></i></a>";
                }
            }
        }
    ];
    function getIdAndPayslip(data, type, dataToSet) {
        return data.aid + "," + data.payslip;
    }
    var action_url = $('#salary_advance').attr('action_url');
    oTable = gridSFC('salary_advance', action_url, aoColumnDefs);
    $('#date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
    });
    $.ajax({
        url: '<?php echo base_url() ?>service/Staff_data/get_staff_drop_down',
        type: 'GET',
        success: function (data) {
            var string = '<option value="">Select Staff</option>';
            $.each(data.staff, function (i, v) {
                string += '<option value="' + v.personal_id + '">'+ v.name + '</option>';
            });
            $("#staff").append(string);
        }
    });
    $.ajax({
        url: '<?php echo base_url() ?>service/Rest_shared/get_advance_salary_type_drop_down',
        type: 'GET',
        success: function (data) {
            var string = "";
            $.each(data.data, function (i, v) {
				if(v.name=='DEDUCT') {
                string += '<option value="' + v.id + '" selected="selected">'+ v.name + '</option>';
				}
            });
            $("#type").append(string);
        }
    });
    viewData('<?php echo base_url() ?>service/Salary_data/salary_scheme_edit', function (data) {
        detail_view(data);
    });
    function detail_view(data){
        var viewdata = "";
        viewdata += "<tr>";
        viewdata += "<td><?php echo $this->lang->line('salary_scheme'); ?></td>";
        viewdata += "<td>"+data.main.scheme+"</td>";
        viewdata += "</tr>";
        viewdata += "<tr>";
        viewdata += "<td><?php echo $this->lang->line('from'); ?></td>";
        viewdata += "<td>"+convert_date(data.main.date_from)+"</td>";
        viewdata += "</tr>";
        viewdata += "<tr>";
        viewdata += "<td><?php echo $this->lang->line('to'); ?></td>";
        viewdata += "<td>"+convert_date(data.main.date_to)+"</td>";
        viewdata += "</tr>";
        viewdata += "<tr>";
        viewdata += "<td><?php echo $this->lang->line('amount'); ?></td>";
        viewdata += "<td>INR "+data.main.amount+"</td>";
        viewdata += "</tr>";
        var viewData1 = "";
        viewData1 += "<table class='table table-bordered scrolling table-striped table-sm'>";
        viewData1 += "<thead><tr class='bg-warning text-white'><th><?php echo $this->lang->line('sl'); ?></th><th><?php echo $this->lang->line('salary_head'); ?></th><th><?php echo $this->lang->line('type'); ?></th><th><?php echo $this->lang->line('amount(INR)'); ?></th></tr></thead>";
        viewData1 += "<tbody>";
        var j = 0;
        $.each(data.details, function (i, v) {
            j++;
            viewData1 += "<tr><td>"+j+"</td><td>"+v.head+"</td><td>INR "+v.type+"</td><td>"+v.amount+"</td></tr>";
        });
        viewData1 += "</tbody>";
        viewData1 += "</table>";
        $("#viewModalContent").html(viewdata);
        $("#other_details").html(viewData1);
        $('#viewModal').modal('show');
    }
    $(".plus_btn").click(function () {
        $(".saveButton").text("<?php echo $this->lang->line('save'); ?>");
        $("form.add-edit").attr('action', "<?php echo base_url() ?>service/Salary_data/add_salary_advance");
        clear_form();
        $("#form_title_h2").html('<?php echo $this->lang->line('new_salary_advance'); ?><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />');
        $("#count").val(0);
    });
    function delete_salary_advance(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this Information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>service/Salary_data/delete_salary_advance/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            data = JSON.parse(data);
                            if (data.message === 'error') {
                                $.toaster({
                                    priority: 'danger',
                                    title: '',
                                    message: data.viewMessage
                                });
                            }
                            if (data.message == 'success') {
                                $.toaster({
                                    priority: 'success',
                                    title: 'Success',
                                    message: data.viewMessage
                                });
                                clearControls();
                                $("#" + data.grid).dataTable().fnDraw();
                            } 
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
</script>