<?
$lv="../../";
include ($lv."config.php");
include_once $lv.'htinmotion/php-cut-html-string/cutstring.php';
include_once $lv.'htinmotion/orm/adodb5/adodb.inc.php';
include_once $lv.'htinmotion/orm/general/general.php';
$g = new general();
$perpage=5;
$cond=" contest_active='enable' ";
header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8'?>";	
if( $_GET["load"]=="paging")
{
	$count=$g->getSQL("SELECT count(*) as total FROM contest WHERE $cond and contest_type=".$_POST["contest_type"],0);	
	$total=$count[0]["total"];
	if($total%$perpage==0) $pageNum = $total / $perpage;
	else 				
	{
		if 	($total<$perpage)	$pageNum=1;
		else 					$pageNum = ($total -($total%$perpage))/$perpage+1;
	}	
	echo "<pageSet pgNum='".$pageNum."' totalRecord='".$total."' >";
	for ($i=1;$i<=$pageNum;$i++)
	{
		if ($i == 1) 		echo "<pg id='First'> &lt;&lt; </pg><pg id='Pre'> &lt; </pg>";            		          
    	echo	"<pg id='".$i."'><![CDATA[".$i."&nbsp;"."]]></pg>";
   		if ($i == $pageNum)  echo "<pg id='Next'> &gt; </pg><pg id='Last'> &gt;&gt; </pg>";
	}
	echo "</pageSet>";
}
if($_POST["type"]=="vote")
{		
	echo "<response>";
		$g=new general();
			$arr["contest_id"]		=$_POST["contest_id"];
			if($_SESSION["mem"])$arr["member_id"]	=$_SESSION["mem"]["member_id"];
			if(!$_SESSION["mem"])$arr["member_id"]	=-1;
			$arr["vote_dt"]	=date("Y-m-d H:i:s");
			$g->executeInsert("all24vote",$arr,"");
			$rc=$g->getSQL("select count(*) as totalVote from all24vote where contest_id=".$_POST["contest_id"],0);
			echo "<success><![CDATA["."Bạn đã bình chọn thành công"."]]></success>";
			echo "<totalVote>".$rc[0]["totalVote"]."</totalVote>";				
	echo "</response>";return;
}
if( $_GET["load"]=="record")
{
	//dim from,tor,pid,cond,sql,seq
	$seq=1;
	if  (!$_GET["pid"])	$pid=1;
	else  $pid=$_GET["pid"];
	$tor	=$pid*$perpage;
	$from	=($tor-$perpage);
	$tor=5;
	$lm 	= " LIMIT $from,$tor ";
	$groupby=" group by ct.contest_id ";
	$order=" order by ct.contest_date desc ";
	$recordSet=$g->getSQL("SELECT ct.*,count(av.all24vote_id) as totalVote,mb.member_user from contest ct LEFT JOIN all24vote av ON ct.contest_id=av.contest_id LEFT JOIN member mb on ct.member_id=mb.member_id WHERE $cond and ct.contest_type='".$_POST["contest_type"]."' $groupby $order $lm ",0);
	echo "<recordSet>";
	foreach ($recordSet as $re)
		{
			echo "<record id=\"".$re["contest_id"]."\" seq=\"$seq\" >";
			echo "<contest_title><![CDATA[".$re["contest_title"]."]]></contest_title>";
			echo "<contest_desc><![CDATA[".$re["contest_desc"]."]]></contest_desc>";
			echo "<contest_date>".$re["contest_date"]."</contest_date>";
			
			echo "<totalVote>".$re["totalVote"]."</totalVote>";
			echo "<member_user><![CDATA[".$re["member_user"]."]]></member_user>";
			if(in_array($_POST["contest_type"],array(1,2,3)))
			{
				echo "<contest_fileup>".$re["contest_video_converted"]."</contest_fileup>";//converted
				//echo "<contest_video_converted>".$re["contest_video_converted"]."</contest_fileup>";//converted
				echo "<thumbnail>".$re["contest_ivideo"]."</thumbnail>";//video thumbnail
				echo "<init_video>true</init_video>";
			}
			if(in_array($_POST["contest_type"],array(4,5,6)))
			{
				echo "<contest_fileup>".$re["contest_fileup"]."</contest_fileup>";//is photo only
				echo "<thumbnail>thumb_".$re["contest_fileup"]."</thumbnail>";//video thumbnail
				echo "<init_video>false</init_video>";
			}
			
			echo "</record>";
			$seq++;
		}
	echo "</recordSet>";
}
?>