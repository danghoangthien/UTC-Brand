<?
include '../../../config.php';
include '../../../htinmotion/orm/adodb5/adodb.inc.php';
include '../../../htinmotion/orm/general/general.php';

if($_POST["quiz_id"])
{
	$g=new general();
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$sql="delete from quiz where quiz_id=".$_POST["quiz_id"];
	$arr=$g->executeSQL($sql);
	echo"<status>".$sql."</status>";
	
}
?>