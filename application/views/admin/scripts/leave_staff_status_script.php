<?php $this->load->view('admin/scripts/includes/main_script'); ?>
<script  type="text/javascript">
    var oTable;
    var aoColumnDefs = [
        {
            "aTargets": [3],
            "mData": 'total_leave_count',
            "mRender": function(data, type, row) {
                return data;
            }
        },{
            "aTargets": [4],
            "mData": 'total_leave_taken',
            "mRender": function(data, type, row) {
                return data;
            }
        },{
            "aTargets": [5],
            "mData": 'balanceLeaveCount',
            "mRender": function(data, type, row) {
                return data;
            }
        },{
            "aTargets": [6],
            "mData": 'extraleave',
            "mRender": function(data, type, row) {
                return data;
            }
        }
    ];
    var action_url = $('#leave_status').attr('action_url');
    oTable = gridSFC('leave_status', action_url, aoColumnDefs);
</script>