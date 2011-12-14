<?
$lv="../../";
include ($lv."config.php");
include_once $lv.'htinmotion/php-cut-html-string/cutstring.php';
include_once $lv.'htinmotion/orm/adodb5/adodb.inc.php';
include_once $lv.'htinmotion/orm/general/general.php';
$cond = "gf.status='enable'";
$order= "ORDER BY gf.face_dt desc";
if(($_POST["face_id"]) && $_POST["face_id"]==113){$plus =1000;}
else{$plus=0;}
if($_POST["type"]=="nmb")
{
	$perpage=12;$block=5;
	$g=new general();
	$ab=$g->getSQL("select count(*) as nmb from gameface gf where $cond",0); 
	$total=$ab[0]["nmb"];
	if($total%$perpage==0) $pageNum = $total / $perpage;
	else 				
	{
		if 	($total<$perpage)	$pageNum=1;
		else 					$pageNum = ($total -($total%$perpage))/$perpage+1;
	}	
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	echo "<pageSet>";
	echo "<total>".$total."</total>";
	echo "<nmb>".$pageNum."</nmb>";
	for($i=1;$i<=$pageNum;$i++)
	{
		echo "<pg>".$i."</pg>";
	}
	echo "</pageSet>";
	return;
}
if($_POST["type"]=="vote")
{	
	$g=new general();	
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	echo "<response>";		
			$arr["face_id"]		=$_POST["face_id"];
			if($_SESSION["mem"])$arr["member_id"]	=$_SESSION["mem"]["member_id"];
			if(!$_SESSION["mem"])$arr["member_id"]	=-1;
			$arr["vote_dt"]	=date("Y-m-d H:i:s");
			$g->executeInsert("facevote",$arr,"");
			$rc=$g->getSQL("select count(*) as totalVote from facevote where face_id=".$_POST["face_id"],0);
			echo "<success><![CDATA["."Bạn đã bình chọn thành công"."]]></success>";
			echo "<totalVote>".($rc[0]["totalVote"]+$plus)."</totalVote>";
	echo "</response>";return;
}
if($_POST["type"]=="select")
{	
	
	$g=new general();
	$sql="select gf.*,count(fv.facevote_id) as totalVote from gameface gf LEFT join facevote fv on gf.face_id=fv.face_id LEFT JOIN member mb on gf.member_id=mb.member_id  where gf.face_id=".$_POST["face_id"]." group by gf.face_id";
	$ab=$g->getSQL($sql,0);
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	echo "<img>
		<face_id>".$ab[0]["face_id"]."</face_id>
		<src>".$ab[0]["face_img"]."</src>
		<title><![CDATA[".truncate($ab[0]["face_title"],36," ..",false,true )."]]></title>
		<title_full><![CDATA[".truncate($ab[0]["face_title"],36," ..",false,true )."]]></title_full>
		<totalVote><![CDATA[".($ab[0]["totalVote"]+$plus)."]]></totalVote>
		<desc><![CDATA[".$ab[0]["face_desc"]."]]></desc>
		</img>";
}
else
{	
	$seq=($_POST["seq"])?$_POST["seq"]:1;
	$str=($_POST["str"])?"and gf.face_title LIKE'%".$_POST["str"]."%' or mb.member_user='".$_POST["str"]."'":"";
	$perBlock=12;
	if($seq==1)
	{
		$from=0;
		$to=$perBlock;
	}
	else
	{
		$to=$perBlock*$seq;
		$from=$to-$perBlock;
		$to=$perBlock;
	}
	$g=new general();
	$sql="select gf.*,count(fv.facevote_id) as totalVote from gameface gf LEFT join facevote fv on gf.face_id=fv.face_id LEFT JOIN member mb on gf.member_id=mb.member_id where $cond $str group by gf.face_id $order limit $from,$to ";
	$ab=$g->getSQL($sql,0);
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	echo "<album>";
	//echo "<sql>".$sql."</sql>";
	echo "<count>".sizeof($ab)."</count>";
	foreach ($ab as $a)
	{
		if($a["face_id"]=="113")$plus=1000;
		echo "<img>
			<face_id>".$a["face_id"]."</face_id>
			<src>".$a["face_img"]."</src>
			<title><![CDATA[".truncate($a["face_title"],36," ..",false,true )."]]></title>
			<title_full><![CDATA[".truncate($a["face_title"],36," ..",false,true )."]]></title_full>
			<totalVote><![CDATA[".($a["totalVote"]+$plus)."]]></totalVote>
			<desc><![CDATA[".$a["face_desc"]."]]></desc>
			</img>";
	}
	echo "</album>";
}
?>