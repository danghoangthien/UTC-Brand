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
<script> $(document).ready( 
					function()
					{
						 /*
						 $("th:eq(0)").css('width','5%'); 
						 $("th:eq(1)").css('width','15%'); 
						 $("th:eq(2)").css('width','25%'); 
						 $("th:eq(3)").css('width','5%'); 
						 $("th:eq(4)").css('width','8%'); 
						 $("th:eq(5)").css('width','10%'); 
						 */
						 $("th").css('color','red');
						 $("th").css('text-align','center');
						 $("th").css('font-weight','bold');
						 $(".change_status").click(function(){
							 alert("a");
							 change_status($(this));
							 
						 });
						 $(".delete").click(function(){
							 var id=$(this).attr("id");
							 $.ajax({
								data		: "id="+id,
								type		: "GET",
								url			: "delete.php",
								dataType: "html",
								success	:function(html)
										{	
											   location.reload();	
											   						
										}//end success callback
							});//end ajax
							 
						 });
						 $(".next").bind('click',function(){
							 $(".change_status").click(function(){
							 change_status($(this));	
						 });
						})
					});
					function change_status(selector){
						
						var id=$(selector).attr("id");
							 $.ajax({
								data		: "id="+id,
								type		: "GET",
								url			: "changestatus.php",
								dataType: "xml",
								success	:function(xml)
										{	
											$("#status_"+id).html($(xml).find("status").text()).css("color","red");								
										}//end success callback
							});//end ajax
					}
					
</script>		
				<?php 					
					$general=new general();		
					if($_GET["face_id"])
					{
						$cond=" Where member_id=(SELECT member_id from gameface where face_id=".$_GET["face_id"].")";
					}
					if($_GET["contest_id"])
					{
						$cond=" Where member_id=(SELECT member_id from contest where contest_id=".$_GET["contest_id"].")";
					}
					$sql='SELECT member_id,member_id,member_rname,member_user,member_DOB,CONCAT("<strong>Email:</strong>",member_email,"<br/><strong>D/c:</strong>",member_add,"<br/><strong>Phone:</strong>",member_phone,"<br/><strong>CMND:</strong>",member_card) AS member_info FROM member ';					
					$arr=$general->getSQL($sql.$cond);	
					echo $sql.$cond;
					//echo $sql;							
					$actions=array(
					//"edit"=>"editconsult.php?u_id=",
					//"change_status"=>"",
					//"edit"=>"edit.php?id=",
					//"delete"=>""
					);
					$header=array("ID","Họ tên","Username","DOB","Thông tin cá nhân");
					$title="Danh sách thành viên tham tham gia chương trình Adidas All In.";
					generateAdminTableHTML($header,$arr,$actions,$title);
					generatePagerHTML("../../../");
				?>									
<?php 
//lay out
include $level.'template/admin/admin_sidebar.php';
include $level.'template/admin/admin_footer.php';
?>