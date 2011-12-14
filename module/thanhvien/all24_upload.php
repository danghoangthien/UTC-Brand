<?
include_once '../../config.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
if ($_POST) 
{
	$g=new general();
	$error=array();	
	$contest=array();
		header('Content-type: text/xml');
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		$contest["contest_date"]	=date("Y-m-d H:i:s");
		$contest["contest_active"]	="disable";
		$contest["member_id"]		=$_SESSION["mem"]["member_id"];
		$contest["contest_type"]	=$_POST["contest_type"];
		$contest["shirt_size"]		=$_POST["shirtsize"];
		if($_POST["all24file"])		
			{
				$contest["contest_fileup"]=$_POST["all24file"];
				$path_parts = pathinfo("../../".$_POST["all24file"]);
				if($path_parts['extension']=="flv"||$path_parts['extension']=="mp3"||$path_parts['extension']=="jpg"||$path_parts['extension']=="png"||$path_parts['extension']=="gif")
					{
						$contest["contest_video_converted"]=$_POST["all24file"];
					}
			}
		if($_POST["all24title"])	$contest["contest_title"]=$_POST["all24title"];
		if($_POST["all24_intro"])	$contest["contest_desc"]=$_POST["all24_intro"];
		if($_POST["isgroup"])		$contest["isgroup"]=$_POST["isgroup"];		
		$g->executeInsert("contest",$contest,"");
		if($_POST["isgroup"]=="yes")
		{
			for($i=2;$i<=10;$i++)
			{		
				if($_POST["member".$i])
					{
						$group=array();
						$group["member_id"]=$_SESSION["mem"]["member_id"];
						$group["name"]=$_POST["member".$i];
						$group["shirt_size"]=$_POST["shirtsize".$i];
						$g->executeInsert("group_dance",$group,"");
					}
			}
		}
		echo "<status>".SUCCESS_UPLOAD_ALL24."</status>";
	
}
?>