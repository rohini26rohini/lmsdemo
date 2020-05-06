<script>
$(document).ready(function() {
     create_calendar(500,base_url+"backoffice/calendar/get_calendar_events?batch_id="+$("#batch_id").val());
    var myTree = [
        <?php foreach($subjectArr as $row){ ?>
        {
            text: "<?php echo $row['subject_name']?>",
            href: '#demo',
            nodes: [
                <?php foreach($moduleArr as $row1){ ?>
                    <?php if($row['subject_id'] == $row1['parent_subject']){ ?>

                {
                    text: "<?php echo $row1['subject_name']?> ",
                    icon: "fa fa-map-marker",
                    href: '#demo3',
                },
                <?php } ?>
                <?php } ?>
            ]
        },
        <?php } ?>
    ];
    $('#default-tree').treeview({
        data: myTree,
        levels: 1,
        expandIcon: 'fa fa-plus',
        collapseIcon: 'fa fa-minus',
        emptyIcon: 'fa',
        nodeIcon: 'fa fa-user',
        selectedIcon: '',
        checkedIcon: 'fa fa-check',
        uncheckedIcon: 'fa fa-unchecked',
        enableLinks: true,
    });

    

     load_data();
        
    
    

});
    function load_data(){
            var batch_id = $("#batch_id").val();
            $(".loader").show();
            $.ajax({
                url:"<?php echo base_url(); ?>backoffice/Home/fetch",
                method:"POST",
                data:{batch_id:$("#batch_id").val(),<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data){
                    $('#studentdatatable').html(data);
                    $(".loader").hide();
                    $('#studentdatatable').DataTable().destroy();
                        $("#studentdatatable").DataTable({
                            "searching": true,
                            "bPaginate": true,
                            "bInfo": true,
                            "pageLength": 10,
                    //        "order": [[4, 'asc']],
                            "aoColumnDefs": [
                                {
                                    'bSortable': false,
                                    'aTargets': [0]
                                },
                                {
                                    'bSortable': false,
                                    'aTargets': [1]
                                },
                                {
                                    'bSortable': false,
                                    'aTargets': [2]
                                }
                            ]
                        }); 
                }
            })
        }
        $('.filter_class').change(function(){
                load_data();
        });
</script>
