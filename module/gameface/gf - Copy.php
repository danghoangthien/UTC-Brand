<?
$lv="../../";
include ($lv."config.php");
include_once $lv.'htinmotion/php-cut-html-string/cutstring.php';
include_once $lv.'htinmotion/orm/adodb5/adodb.inc.php';
include_once $lv.'htinmotion/orm/general/general.php';
$cond = "gf.status='enable'";
$order= "ORDER BY gf.face_dt desc";
if($_POST["type"]=="nmb")
{
	$perpage=12;
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
	echo "</pageSet>";
	return;
}
if($_POST["type"]=="vote")
{		
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	echo "<response>";
	if(!$_SESSION["mem"])	
	{
		$require="Vui lòng <a href='register.php'><strong>đăng nhập</strong></a> trước khi sử dụng chức năng này";
		echo "<error><![CDATA[$require]]></error>";	
	}
	else
	{		
		$sql="select member_id from facevote where member_id=".$_SESSION["mem"]["member_id"]." and face_id=".$_POST["face_id"];
		$g=new general();
		$fv=$g->getSQL($sql,0);		
		if(sizeof($fv)>0)
		{
			echo "<error><![CDATA["."Bạn đã bình chọn cho nội dung này rồi."."]]></error>";
		}
		else
		{
			$arr["face_id"]		=$_POST["face_id"];
			$arr["member_id"]	=$_SESSION["mem"]["member_id"];
			$arr["vote_dt"]	=date("Y-m-d H:i:s");
			$g->executeInsert("facevote",$arr,"");
			$rc=$g->getSQL("select count(*) as totalVote from facevote where face_id=".$_POST["face_id"],0);
			echo "<success><![CDATA["."Bạn đã bình chọn thành công"."]]></success>";
			echo "<totalVote>".$rc[0]["totalVote"]."</totalVote>";
		}				
	}	
	echo "</response>";return;
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
	echo "<sql>".$sql."</sql>";
	echo "<count>".sizeof($ab)."</count>";
	foreach ($ab as $a)
	{
		echo "<img>
			<face_id>".$a["face_id"]."</face_id>
			<src>".$a["face_img"]."</src>
			<title><![CDATA[".truncate($a["face_title"],36," ..",false,true )."]]></title>
			<title_full><![CDATA[".truncate($a["face_title"],36," ..",false,true )."]]></title_full>
			<totalVote><![CDATA[".$a["totalVote"]."]]></totalVote>
			<desc><![CDATA[".$a["face_desc"]."]]></desc>
			</img>";
	}
	echo "</album>";
}
?>