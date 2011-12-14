<?php 
include_once '../../config.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
if($_GET["type"])
{
$g=new general();	
$type=$_GET["type"];
$sql_related = "select * from consult 
				where todaytopic_type_id IN ($type) 
				and content<>'' 
				and status='enable' 
				order by reply_datetime desc limit 0,5";
$con=$g->getSQL($sql_related,0);
?>
<p class="head">Lời khuyên từ STADA</p>  
<?
foreach($con as $c)
	{
?>  
		  
		<div class="news">
			<div>
				<a href="tu-van-chi-tiet.php?c_id=<? echo $c["consult_id"]?>"><? echo $c["title"]?></a>
				<br><? echo $c["content"]?>
			</div>
		</div>   
<?php 
	}//end for
}//end if $type?> 