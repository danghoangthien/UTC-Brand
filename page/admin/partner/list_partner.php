<?php 
$level='../../../';
//1 database config
include $level.'config.php';
//2 neccessary library
include $level.'htinmotion/orm/adodb5/adodb.inc.php';
include $level.'htinmotion/orm/general/general.php';
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
	
});
</script>
				<?php 					
					$general=new general();							
					$arr=$general->getSQL(
					"SELECT partner_id,
							partner_company,
							partner_name,
							partner_cmnd,
							partner_email,
							partner_phone,
							partner_phone2
					 FROM   partner order by partner_company",0
					);
					$actions=array(
					//"edit"=>"editquiz.php?quiz_id=",
					//"delete"=>""
					);
					$header=array("Tên công ty","Họ tên","CMND","Partner Email","Điện thọai bàn","Điện thọai di động ");
					echo"<script> $(document).ready( 
					function()
					{
						 $(\"th:eq(0)\").css('width','30%'); 
						 $(\"th:eq(1)\").css('text-align','center'); 
						 $(\"th:eq(2)\").css('text-align','center'); 
						 $(\"th:eq(3)\").css('text-align','center'); 
						 $(\"th:eq(4)\").css('text-align','center'); 
						 $(\"th:eq(5)\").css('width','10%').css('text-align','center'); ; 
						 $(\"th\").css('font-weight','900');
						 $(\"th\").css('text-align','center');
						 $(\"th\").css('font-weight','bold');
					} ); 
					</script>";
					generateAdminTableHTML($header,$arr,$actions);
					generatePagerHTML("../../../");
				?>									
<?php 
//lay out
include $level.'template/admin/admin_sidebar.php';
include $level.'template/admin/admin_footer.php';
?>