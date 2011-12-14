<?php 
$level='../../../';
//1 database config
include $level.'config.php';
//2 neccessary library
include $level.'htinmotion/orm/adodb5/adodb.inc.php';
include $level.'htinmotion/orm/general/general.php';
include $level.'template/admin/excel_export.php';
?>
<?php 					
	$general=new general();							
	$arr=$general->getSQL(
	"SELECT quiz_id,
			quiz_question,
			CONCAT('<span class=\"week\" week_no=\"week1\" quiz_id=\"',quiz_id,'\">',week1,'</span>') as week1,
			CONCAT('<span class=\"week\" week_no=\"week2\" quiz_id=\"',quiz_id,'\">',week2,'</span>') as week2,
			CONCAT('<span class=\"week\" week_no=\"week3\" quiz_id=\"',quiz_id,'\">',week3,'</span>') as week3,
			CONCAT('<span class=\"week\" week_no=\"week4\" quiz_id=\"',quiz_id,'\">',week4,'</span>') as week4 
	 FROM   quiz "
	,0);
	$actions=array(
	"edit"=>"editquiz.php?quiz_id=",
	"delete"=>"");
	$header=array("Câu hỏi Trắc nghiệm","Tuần 1","Tuần 2","Tuần 3","Tuần 4");
	if($_POST["type"]=="export")
	{
		//$arr=$general->getSQL($sql,0);	
		$header_width=array("30","450","50","50","50","50");
		$filename="hp_question";
		HTexport($title,$filename,$header_width,$header,$arr);return;
	}
?>	
<?
include $level.'template/admin/tablepager.php';//pager html
include $level.'template/admin/tablerender.php';//pager html
?>
								

<?
//3 lay out
include $level.'template/admin/admin_head.php';
include $level.'template/admin/admin_header.php';
//4 code behind
?>	
<style>
.week,#y,#n{
cursor:pointer;
}
</style>		
<script type="text/javascript">
$(document).ready(function(){
	$("th:eq(0)").css('width','40%'); 
		 $("th:eq(1)").css('text-align','center'); 
		 $("th:eq(2)").css('text-align','center'); 
		 $("th:eq(3)").css('text-align','center'); 
		 $("th:eq(4)").css('text-align','center'); 
		 $("th:eq(5)").css('width','10%').css('text-align','center'); ; 
		 //$(\"th\").css('color','red');
		 $("th").css('text-align','center');
		 $("th").css('font-weight','bold');
});
$(".week").live("click",function(){
	$(this).addClass("current");
	var quiz_id=$(this).attr("quiz_id");
	var week_no=$(this).attr("week_no");
	
	$.ajax({
		data		:{quiz_id:$(this).attr("quiz_id"),week_no:$(this).attr("week_no")},
		type		: "POST",
		url			: "modify_week_asign.php",
		dataType: "xml",
		success	:function(xml)
			{	
				if($(xml).find("week").length>0)
				{
					$(".current").html("<span style='color:red'>"+$(xml).find("week").text()+"</span>").removeClass("current");
				}
			}//end success callback
  	});//end ajax
});
$(".delete").live("click",function(){
	cs("this",$(this).attr("id"));
	var id=$(this).attr("id");
	jQuery.facebox("<h3 style='text-align:center'>Are you sure?</h3>"+"<h4 style='text-align:center'><span id='y'>yes</span>&nbsp;&nbsp;<span id='n'>no</span></h4>");
	$("#n").css({color:"#0099ff",fontWeight:"900"});
	$("#y").css({color:"red",fontWeight:"900"});
	$("#y").click(function(){
		$.ajax({
		data		:{quiz_id:id},
		type		: "POST",
		url			: "delete.php",
		dataType: "xml",
		success	:function(xml)
			{	
				if($(xml).find("status").length>0)
				{//$("#"+id).parent();
					cs("parent",$("#"+id).parent().parent().html());
					$("#"+id).parent().parent().remove();
					jQuery.facebox("Dữ liệu xóa thành công");
					setTimeout(function(){
						jQuery.facebox("Dữ liệu xóa thành công");
					},1000);
					setTimeout(function(){
						$(document).trigger("close.facebox");	
					},2000);
					
				}
			}//end success callback
  		});//end ajax

	});
	$("#n").click(function(){
		$(document).trigger("close.facebox");
	});
});
</script>
<form action="listquiz.php" method="post">
                    <input type="hidden" name="type" value="export"> 
                	<input type="submit" value="Export to Excel"/>
</form>	
<?
					generateAdminTableHTML($header,$arr,$actions,$title);
					generatePagerHTML("../../../");
?>		
                
<?php 
//lay out
include $level.'template/admin/admin_sidebar.php';
include $level.'template/admin/admin_footer.php';
?>