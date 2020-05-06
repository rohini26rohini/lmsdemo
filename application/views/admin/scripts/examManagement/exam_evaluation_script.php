<script type="text/javascript">
var actual_mark = 0;
function answer_evaluate(attempt,exam_id,question_id,student_id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Exam/get_answer_evaluate',
        type: 'POST',
        data:{
                'attempt':attempt,
                'exam_id':exam_id,
                'question_id':question_id,
                'student_id':student_id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
        success: function(response) {
            var obj = JSON.parse(response);
            var html = '';
            html += '<input type="hidden" name="attempt" value="'+obj.attempt+'">';
            html += '<input type="hidden" name="exam_id" value="'+obj.exam_id+'">';
            html += '<input type="hidden" name="student_id" value="'+obj.student_id+'">';
            html += '<input type="hidden" name="question_id" value="'+obj.question_id+'">';
            if(obj.passage!=''){
                html += '<div class="form-group col-sm-12"><div class="title-header">Passage</div>'+
                        '<div class="title-body">'+obj.passage+'</div></div>';
            }
            html += '<div class="form-group col-sm-12"><div class="title-header">Question</div>'+
                    '<div class="title-body">'+obj.question+'</div></div>';
            html += '<div class="form-group col-sm-12"><div class="title-header">Answer Given</div>'+
                    '<div class="title-body" style="white-space: pre-wrap;">'+obj.answer+'</div></div>';
            if(obj.question_solution!=''){
                html += '<div class="form-group col-sm-12"><div class="title-header">Solution</div>'+
                        '<div class="title-body">'+obj.question_solution+'</div></div>';
            }
            html += '<div class="form-group col-sm-12"><div class="title-header">Mark obtained: '+
                    '<input name="mark" id="mark" onkeypress="return decimalNum(event)" type="text" value="'+obj.mark+'"> '+
                    'out of <b>'+obj.actual_mark+'</b> marks</div></div>';
            html += '<div class="form-group col-sm-12" id="error"></div>';      
            actual_mark = obj.actual_mark;
            $("#answer_details").html(html);
            $("#question_valuate").modal("show");
            $(".loader").hide();
        }
    });
} 
function answer_evaluate_view(attempt,exam_id,question_id,student_id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Exam/get_answer_evaluate',
        type: 'POST',
        data:{
                'attempt':attempt,
                'exam_id':exam_id,
                'question_id':question_id,
                'student_id':student_id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
        success: function(response) {
            var obj = JSON.parse(response);
            var html = '';
            html += '<input type="hidden" name="attempt" value="'+obj.attempt+'">';
            html += '<input type="hidden" name="exam_id" value="'+obj.exam_id+'">';
            html += '<input type="hidden" name="student_id" value="'+obj.student_id+'">';
            html += '<input type="hidden" name="question_id" value="'+obj.question_id+'">';
            if(obj.passage!=''){
                html += '<div class="form-group col-sm-12"><div class="title-header">Passage</div>'+
                        '<div class="title-body">'+obj.passage+'</div></div>';
            }
            html += '<div class="form-group col-sm-12"><div class="title-header">Question</div>'+
                    '<div class="title-body">'+obj.question+'</div></div>';
            html += '<div class="form-group col-sm-12"><div class="title-header">Answer Given</div>'+
                    '<div class="title-body">'+obj.answer+'</div></div>';
            if(obj.question_solution!=''){
                html += '<div class="form-group col-sm-12"><div class="title-header">Solution</div>'+
                        '<div class="title-body">'+obj.question_solution+'</div></div>';
            }
            html += '<div class="form-group col-sm-12"><div class="title-header">Mark obtained: '+
                    '<input name="mark" readonly id="mark" onkeypress="return decimalNum(event)" type="text" value="'+obj.mark+'"> '+
                    'out of <b>'+obj.actual_mark+'</b> marks</div></div>';
            html += '<div class="form-group col-sm-12" id="error"></div>';      
            actual_mark = obj.actual_mark;
            $("#answer_details_view").html(html);
            $("#question_valuate_view").modal("show");
            $(".loader").hide();
        }
    });
}        

$("#answer_evaluate").submit(function(event){
    $(".loader").show();
    event.preventDefault();
    $("#error").html('');
    if(actual_mark<$("#mark").val()){
        $("#error").html('<span class="error">Obtained score cannot be greater than maximum score</span>');
        $(".loader").hide();
        return false;
    }
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Exam/save_evaluate_answer',
        type: 'POST',
        data:$('#answer_evaluate').serialize(),
        success: function(response) {
            var obj = JSON.parse(response);
            if(obj.st){
                var btn_id = 'evaluate_btn_'+obj.data.attempt+'_'+obj.data.exam_id+'_'+obj.data.question_id+'_'+obj.data.student_id;
                var status_id = 'evaluate_status_'+obj.data.attempt+'_'+obj.data.exam_id+'_'+obj.data.question_id+'_'+obj.data.student_id;
                var evaluated_by_id = 'evaluated_by_'+obj.data.attempt+'_'+obj.data.exam_id+'_'+obj.data.question_id+'_'+obj.data.student_id;
                $("#"+btn_id).html('Re-evaluate');
                $("#"+status_id).html('Evaluated');
                $("#"+evaluated_by_id).html('<?php echo $this->session->userdata('name');?>');
                $("#question_valuate").modal("hide");
                $.toaster({priority:'success',title:obj.message,message:''});
            }else{
                $.toaster({priority:'danger',title:obj.message,message:''});
            }
            $(".loader").hide();
        }
    });

});

</script>
     
    