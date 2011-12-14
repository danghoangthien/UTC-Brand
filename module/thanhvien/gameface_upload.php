<?
include_once '../../config.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';

if ($_POST) 
{
	$g=new general();
	$error=array();	
	/*
	$sql="select face_title from gameface where face_title='".$_POST["title"]."'";
	$arr=$g->getSQL($sql,0);
	if($arr[0])
	{ 
		$error[]=EXISTED_TITLE;
		echo "<script>alert('".EXISTED_TITLE."')</script>";return;
	
	}
	*/
	if(strlen($_POST["title"])<5)
	{
		$error[]=INVALID_TITLE;
	}
	else $member["face_title"]=$_POST["title"];
	if(strlen($_POST["desc"])<15)
	{
		$error[]=INVALID_DESC;
	}
	else $member["face_desc"]=$_POST["desc"];
	if(!$_POST["photofile"])
	{
		$error[]=INVALID_PHOTO;
	}
	if(sizeof($error)==0)
	{
		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		$member["face_dt"]=date("Y-m-d H:i:s");
		$member["face_img"]=$_POST["photofile"];
		$member["status"]="disable";
		$member["member_id"]=$_SESSION["mem"]["member_id"];
		$g->executeInsert("gameface",$member,"");
		echo "<status>".SUCCESS_UPLOAD."</status>";
		
	}
	else
	{
		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		echo "<errors>";
		foreach($error as $e)
		{
			echo "<error>$e</error>";
		}
		echo "</errors>";
		
	}
	
	
}
?>