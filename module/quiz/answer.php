<?
include "../../config.php";
include "../../htinmotion/orm/adodb5/adodb.inc.php";
include "../../htinmotion/orm/general/general.php";
$g=new general();
	if($_POST["quiz_id"])
	{
		$_SESSION["turn"]["log"][$_POST["quiz_id"]]=$_POST["choice"];
		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		echo "<status>".$_POST["quiz_id"].":".$_POST["choice"]."</status>";
	}
	
?>