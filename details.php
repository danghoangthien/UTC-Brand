<? include_once "config.php";?>
<? include_once "template/front/head.php";?>
<? include_once "template/front/header.php";?>
<? include_once "module/quiz/quiz.php";?>
<style>
#quiz_list h3{
line-height:1em;
}
#quiz_list h4{
line-height:.2em;

}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$start=-1;
	var count_up=setInterval(function(){
		$start++;
		$("#count_up").html($start);
	},1000);
	$("#top1").jFlow({
		slides			: "#quiz_list",
		controller		: ".navi", // must be class, use . sign
		slideWrapper 	: "#jFlowSlide", // must be id, use # sign
		selectedWrapper	: "jFlowSelected",  // just pure text, no sign
		auto			: true,		//auto change slide, default true
		width			: "320px",
		height			: "400px",
		duration		: 600,
		prev			: ".navi_prev", // must be class, use . sign
		next			: ".navi_next" // must be class, use . sign
	});
	$(".choice").click(function(){
		var choice=$(this).attr("value");
		var quiz_id=$(this).attr("name")
		$.ajax({
		data		:{quiz_id:quiz_id,choice:choice},
		type		: "POST",
		url			: "module/quiz/answer.php",
		dataType: "xml",
		success	:function(xml)
			{	
				if(!$.browser.msie)
				{
					log($(xml).find("status").text());
				}
				
			}//end success callback
  		});//end ajax
	});
	$("#finish").click(function(){
		clearInterval(count_up);
		$.ajax({
		data		:{time:$("#count_up").html()},
		type		: "POST",
		url			: "module/quiz/finish.php",
		dataType: "xml",
		success	:function(xml)
			{	
				if(!$.browser.msie)
				{
					log($(xml).find("status").text());
				}
				jQuery.facebox("<strong style='color:#0099ff'>B&#7841;n &#273;&#227; ho&#224;n th&#224;nh ph&#7847;n thi.</strong>");
				//setTimeout(function(){location.href="results.php"},1000);
			}//end success callback
  		});//end ajax
	})
});
</script>
 <div id="right2" style="position:relative">
    <span id="prev" class="navi_prev" style="position:absolute;top:200px;left:-80px;cursor:pointer"><img src="images/previous.png" width="28" height="50" /></span>
    <span id="next" class="navi_next"style="position:absolute;top:200px;left:340px;cursor:pointer"><img src="images/next.png" width="28" height="50" /></span>    
    <div id="top1">
     	<span style="font-size:15px;"><strong>Th&#7901;i gian </strong></span><br/>
        <span style="font-size:40px;"><strong id="count_up">0</strong></span>
        <? foreach($arr as $a)
			{
			?>
			<span class="navi"></span>
			<?
			}
		?>
     </div>
     <div id="top2">C&#226;u h&#7887;i cho tu&#7847;n 3 ( g&#7891;m c&#243; <? echo $total[0]["total"]?> c&#226;u)</div>
     <div id="quiz_list">
     <?
	 $i=1;
	 foreach($arr as $key=>$ar)
	 {
	 	if(sizeof($ar)>0)
		 {
			 ?><div class="quiz"><?
			  foreach($ar as $k=>$v)
			 {
				 echo "<span>".$i.".".$v["quiz_question"]."</span><br/>"; ?>
					<? $ans=getAns($v["quiz_id"])	;
					foreach ($ans as $an)
					{
					echo "<span><input class='choice' type='radio' value='".$an["quizanswer_id"]."' name='".$v["quiz_id"]."' />".$an["quizanswer_content"]."</span><br />";	
					}			
				 $i++;
			 }
			 	 if($key==(sizeof($arr)-1))	
				    {
						?>
						<div id="top1"><br/><a id="finish" href="javascript:void(0)"><img src="images/hoanthanh.jpg" width="118" height="26" border="0" /></a></div>
						<?
					}
			 ?></div>			 
			 <?
		 }
		 
	 }
	 ?>
     </div><!-- /#Quiz List 	-->
    </div>
<? include_once "template/front/footer.php";?>