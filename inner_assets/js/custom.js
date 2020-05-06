$(document).ready(function () {
    $(".add_new_btn").click(function () {

        $(".add_new").toggle();
    });
    $(".filter_btn").click(function () {

        $(".filter_new").toggle();
    });

    $(".edit_syllabus_btn").click(function () {
            $(".add_new").toggle();
        // $(this).parent(".actions").find(".edit_syllabus").toggle();
    });
   
    $(".ham_navigation").click(function () {
        $(".main_nav").addClass("show");
    });
    $(".nav_close").click(function () {
        $(".main_nav").removeClass("show");
    });
    $(".grid_option").click(function () {
        $(".data_table").css("display", "flex")
        $(".data_table").addClass("grid flex-wrap");
    });
    $(".list_option").click(function () {
        $(".data_table").css("display", "block")
        $(".data_table").removeClass("grid flex-wrap");
    });
    $("#add_block").click(function () {
        $('#section_duplicate').show();
        var html = $('#section_duplicate').clone();
        html.find("#add_block").removeClass("btn-default").addClass("btn-info add_wrap_pos remove_section").html("<i class='fa fa-minus'></i>");
        html.find(".no_hr").removeClass("no_hr");
        $("#dupliate_wrapper").append(html);
         $('#section_duplicate').hide();
    });

    $("#add_block2").click(function () {
//        $('#section_duplicate2').show();
            var html = $('#section_duplicate2').clone();
            html.find("#add_block2").removeClass("btn-default").addClass("btn-info add_wrap_pos remove_section remove_section2").html("<i class='fa fa-minus'></i>");
            html.find(".no_hr").removeClass("no_hr");
            $("#duplicate_wrapper2").append(html);
//         $('#section_duplicate2').hide();
    });
    
    $(document).on('click', '.remove_section', function () {
        $(this).closest("#section_duplicate").remove();
    });
        $(document).on('click', '.remove_section2', function () {
        $(this).closest("#section_duplicate2").remove();
    });
     $(document).on('click', '.remove_sectionedit', function () {
        $(this).closest("#section_duplicate_edit").remove();
    });
     $("#btnExpand").click(function () {
            $(this).hide();
        $("#expandBoard").addClass("expandBoard");
         $("#btnCompress").show();

      
    });
    
     $("#btnCompress").click(function () {
            $(this).hide();
        $("#expandBoard").removeClass("expandBoard");
         $("#btnExpand").show();

      
    });
    
});
