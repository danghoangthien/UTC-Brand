<?
include "../../config.php";
include "../../htinmotion/orm/adodb5/adodb.inc.php";
include "../../htinmotion/orm/general/general.php";
if($_POST["register_email"])
{
	header('Content-type: text/xml');
	$g=new general();
	$reg=array();
	$reg["register_email"]=$_POST["register_email"];
	$lastID=$g->executeInsert("partner_register",$reg,"");
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	echo "<status>".$lastID."</status>";
	return;
	//echo "<status>".$_SESSION["turn"]["email"]."</status>";
}//$g=new general();
?>