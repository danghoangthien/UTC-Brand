<?
include '../../../config.php';
include '../../../htinmotion/orm/adodb5/adodb.inc.php';
include '../../../htinmotion/orm/general/general.php';

if($_POST["quiz_id"])
{
	$g=new general();
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$arr=$g->getSQL("select ".$_POST["week_no"]." from quiz where quiz_id=".$_POST["quiz_id"],0);
	$week=array();
	if($arr[0][$_POST["week_no"]]=="yes")
	{
		
		$week[$_POST["week_no"]]="no";
	}
	else
	{
		$week[$_POST["week_no"]]="yes";
	}
		$g->executeUpdate("quiz",$week,"where quiz_id=".$_POST["quiz_id"]);
		echo"<week>".$week[$_POST["week_no"]]."</week>";
	
}
?>