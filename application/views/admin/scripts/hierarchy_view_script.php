<script>
$(document).ready(function() {
    var myTree = [
        
            {
                text: '<?php echo $groupArr ?>',
                href: '#demo',
                nodes: [
                    <?php foreach($branchArr as $row){ ?>
                        {
                            text: "<?php echo $row['institute_name'] ?>",
                            icon: "fa fa-map-marker",
                            href: '#demo3',
                            nodes: [
                                <?php foreach($centerArr as $val){ ?>
                                    <?php if($row['institute_master_id'] == $val['parent_institute']){ ?>
                                        {
                                            text: "<?php echo $val['institute_name'] ?>",
                                            icon: "fa fa-building-o",
                                            nodes: [
                                                <?php foreach($courseArr as $val1){ ?>
                                                    <?php if($val['institute_master_id'] == $val1['institute_master_id']){ ?>
                                                        {
                                                            text: "<?php echo $val1['class_name'] ?>",
                                                            // href: '#demos'
                                                            
                                                               href: "<?php echo base_url('backoffice/view-branch-students/'.$val1['class_id'].'/'.$val1['institute_master_id']);?>"

                                                        },
                                                    <?php } ?>
                                                <?php } ?>
                                            ]
                                        },
                                    <?php } ?>
                                <?php } ?>
                            ]
                        },
                    <?php } ?>
                ]
        }
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
});

</script>