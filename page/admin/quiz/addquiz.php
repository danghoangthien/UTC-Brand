<?php 
session_start();
//1 database config
include '../../../config.php';
//2 neccessary library
include '../../../htinmotion/orm/adodb5/adodb.inc.php';
include '../../../htinmotion/orm/general/general.php';
include '../../../htinmotion/fckeditor/fckeditor.php';
//3 lay out
include '../../../template/admin/admin_head.php';
include '../../../template/admin/admin_header.php';
//4 code behind
include '../../../htinmotion/orm/resources/class.database.php';
include '../../../htinmotion/orm/generated_classes/class.quiz.php';
include '../../../htinmotion/orm/generated_classes/class.quizanswer.php';
include '../../../htinmotion/formgenerator/formgenerator.php';
include '../../../htinmotion/formgenerator/validators.php';
include '../../../htinmotion/material_upload/image_upload.php';
//5 raise error
include '../../../template/admin/raiseerror.php';
//coding structure

	if($_POST)
	{			
		$q=new quiz();
		if(strlen($_POST["quiz_question"])<5)
		{
			$error[0]=INVALID_TITLE;
		}
		else
		{
			$q->quiz_question=trim($_POST["quiz_question"]);
		}
		if(strlen($_POST["correct_question"])<1)
		{
			$error[0]="Hãy chọn câu đúng.";
		}
		
		if($error==0)
		{
			$q->week1="no";
			$q->week2="no";
			$q->week3="no";
			$q->week4="no";
			$q->insert();
			for($i=1;$i<7;$i++)
			{			
				if(strlen($_POST["quizanswer_content".$i])>=1)
				{		
					$qa=new quizanswer();			
					$qa->quiz_id=$q->quiz_id;
					$qa->quizanswer_content=trim($_POST["quizanswer_content".$i]);
		
					$qa->insert();
					if (trim($_POST["quizanswer_content".$i])==trim($_POST["correct_question"]))
					{
						$q->quiz_question=$_POST["quiz_question"];
						$q->correct_id=$qa->quizanswer_id;
						$q->update($q->quiz_id);
					}				
				}				
			}		
			echo '<script>
			var url = $.url();
			jQuery.facebox("Thêm trắc nghiệm thành công");setTimeout(function(){location.href=url.attr("source")},1500)</script>';				
		}			
		else raiseerror($error);//raiseerror				
	}					    
	?>
<div id='formAdmin'> 
<script type="text/javascript">
$(document).ready(function(){
	$(".quizanswer").dblclick(function(){
		$("#correct_question").val($(this).val());
	});
});
</script>   
<form class="wufoo" id="addquiz" name="addquiz" method="post" action="">
<div class="info">
	<h2>Thêm câu trắc nghiệm</h2>
    <div>Double click vào Câu trả lời để xác định câu trả lời đúng</div>
</div>
<ul>
<li>
	<label class="desc">Câu hỏi(*):<span class="req">*</span></label>
		<div>
        <textarea rows="10" cols="50" name="quiz_question" id="quiz_question" class="field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu hỏi.</p>
</li>
<li>
	<label class="desc">Câu dúng: <span class="req">*</span></label>
		<div>
        <textarea rows="10" cols="50" name="correct_question" id="correct_question" class="field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu đúng.(Double click vào 1 trong các câu trả lời để lấy câu đúng)</p>
</li>
<li>
	<label class="desc">Trả lời 1: <span class="req">*</span></label>
		<div>
        <textarea rows="10" cols="50" name="quizanswer_content1" id="quizanswer_content1" class=" quizanswer field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu trả lời.</p>
</li>
<li>
	<label class="desc">Trả lời 2: <span class="req">*</span></label>
		<div>
        <textarea rows="10" cols="50" name="quizanswer_content2" id="quizanswer_content2" class="quizanswer field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu trả lời.</p>
</li>
<li>
	<label class="desc">Trả lời 3: <span class="req">*</span></label>
		<div>
        <textarea rows="10" cols="50" name="quizanswer_content3" id="quizanswer_content3" class="quizanswer field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu trả lời.</p>
</li>
<li>
	<label class="desc">Trả lời 4: <span class="req">nếu có</span></label>
		<div>
        <textarea rows="10" cols="50" name="quizanswer_content4" id="quizanswer_content4" class="quizanswer field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu trả lời.</p>
</li>
<li>
	<label class="desc">Trả lời 5: <span class="req">nếu có</span></label>
		<div>
        <textarea rows="10" cols="50" name="quizanswer_content5" id="quizanswer_content5" class="quizanswer field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu trả lời.</p>
</li>
<li>
	<label class="desc">Trả lời 6: <span class="req">nếu có</span></label>
		<div>
        <textarea rows="10" cols="50" name="quizanswer_content6" id="quizanswer_content6" class="quizanswer field textarea medium"></textarea>
		</div>
		<p class="instruct">Nhập câu trả lời.</p>
</li>
<li class="buttons">
		<input type="hidden" value="36CxgD" id="prtcode" name="prtcode"><script type="text/javascript">document.getElementById('prtcode').value='36CxgD'</script>
		<input type="submit" value="Thêm" name="form1_submit">
</li>
</ul>
</form>
</div>  
<?    																		           			
//lay out
include '../../../template/admin/admin_sidebar.php';
include '../../../template/admin/admin_footer.php';
?>