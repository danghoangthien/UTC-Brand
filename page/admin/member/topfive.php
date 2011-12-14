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
				<?php 					
					$g= new general();
					$at=unserialize(ATTEND);
					if ($_GET["time"])
					{
						$start	=$at[$_GET["time"]]["start"];
						$end	=$at[$_GET["time"]]["end"];
						$title="Danh s&#225;ch ng&#432;&#7901;i ch&#417;i &#273;i&#7875;m cao Tu&#7847;n $start &#273;&#7871;n $end " ;
					}					
					$sql="	SELECT um.member_id,member_rname,member_card,member_email,member_phone,member_add,MAX(r.max_point) as highest,MAX(r.turn_datetime) AS latest from record r 
							INNER JOIN urc_member um 
							ON r.member_id=um.member_id
							WHERE r.turn_datetime between '$start' AND '$end'
							GROUP BY r.member_id
							ORDER BY highest DESC LIMIT 0,10";
					$countdown=$g->getSQL($sql);
					//print_r($countdown);					
					$actions=array('a'=>'a');	
					$header=array("Name","CMND","Email","Phone","Address","Point","Date");
					echo"<script> $(document).ready( 
					function()
					{
						 $(\"th:eq(0)\").css('width','15%'); 
						 $(\"th:eq(1)\").css('width','10%'); 
						 $(\"th:eq(2)\").css('width','15%'); 
						 $(\"th:eq(3)\").css('width','10%'); 
						 $(\"th:eq(4)\").css('width','15%'); 
						 $(\"th\").css('color','red');
						 $(\"th\").css('text-align','center');
						 $(\"th\").css('font-weight','bold');
					} ); 
					</script>";
					generateAdminTableHTML($header,$countdown,$actions,$title);
					generatePagerHTML("../../../");
				?>									
<?php 
//lay out
include $level.'template/admin/admin_sidebar.php';
include $level.'template/admin/admin_footer.php';
?>