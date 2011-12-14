<?php 
$level='../../../';
//1 database config
include $level.'config.php';
//2 neccessary library
include $level.'htinmotion/orm/adodb5/adodb.inc.php';
include $level.'htinmotion/orm/general/general.php';
include $level.'template/admin/excel_export.php';
	$general=new general();							
	$arr=$general->getSQL(
	"SELECT enroll_id,
			partner_name, 
			enroll_email,
			partner_company,
			partner_phone,
			partner_phone2,
			partner_cmnd,
			enroll_total_answer,
			enroll_total_correct,
			enroll_total_time,
			enroll_dt,
			week
	 FROM   partner_enroll 
	 LEFT JOIN partner ON partner.partner_email=partner_enroll.enroll_email
	 WHERE  week='".$_GET["week"]."'
	 ORDER BY enroll_total_correct desc,enroll_total_time ,enroll_dt  
	 LIMIT 0,35",0
	);
	$actions=array(
	//"edit"=>"editquiz.php?quiz_id=",
	//"delete"=>""
	);
	$header=array("Tên người tham dự","Email","Tên công ty","Điện thoại bàn","Di động","CMND","Số câu trả lời","Số câu đúng","Số giây ","Ngày giờ bắt đầu","Tuần");
	if($_POST["type"]=="export")
	{
		//$arr=$general->getSQL($sql,0);	
		$header=array("ID","Tên người tham dự","Email","Tên công ty","Điện thoại bàn","Di động","CMND","Số câu trả lời","Số câu đúng","Số giây ","Ngày giờ bắt đầu","Tuần");
		$header_width=array("30","200","200","200","100","100","100","100","100","100","200","50");
		$filename="hp_partner_top10_".$_GET["week"];
		HTexport($title,$filename,$header_width,$header,$arr);return;
	}

include $level.'template/admin/tablepager.php';//pager html
include $level.'template/admin/tablerender.php';//pager html
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
		 $("th:eq(0)").css('width','15%'); 
		 $("th:eq(1)").css('text-align','center').css('width','15%'); 
		 $("th:eq(2)").css('text-align','center').css('width','15%'); 
		// $("th:eq(3)").css('text-align','center').css('width','20%'); 
		 $("th:eq(4)").css('text-align','center'); 
		 //$("th:eq(5)").css('width','10%').css('text-align','center'); ; 
		 $("th").css('font-weight','900');
		 $("th").css('text-align','center');
		 $("th").css('font-weight','bold');
		 $("#export").css("margin-left","60px")
	});
</script>
<form action="top10.php?week=<?=$_GET["week"]?>" id="export" method="post">
                    <input type="hidden" name="type" value="export"> 
                	<input type="submit" value="Export to Excel( download & open with excel)"/><br/>
</form>	
                <?
					generateAdminTableHTML($header,$arr,$actions,"<br/><h3 style='text-align:center'>Danh sách partner tham gia trả lời <strong>'Answer to get back money'</strong>.</h3><br/>");
					generatePagerHTML("../../../");
				?>									
<?php 
//lay out
include $level.'template/admin/admin_sidebar.php';
include $level.'template/admin/admin_footer.php';
?>