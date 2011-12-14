<?
include "../../config.php";
include "../../htinmotion/orm/adodb5/adodb.inc.php";
include "../../htinmotion/orm/general/general.php";
if($_POST["User_Email"])
{
	header('Content-type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8'?>";	
	$g=new general();
	//User_Phone
	
	if(!$_POST["User_Cmnd"]||!$_POST["User_RealName"]||!$_POST["User_Company"]||!$_POST["User_Phone2"])
	{
		$status="not_fullfill";
		echo "<status>".$status."</status>";return;
	}
	$ar=$g->getSQL("select partner_email,partner_cmnd from partner where partner_email='".$_POST["User_Email"]."'",0);
	if(sizeof($ar)==0)
	{
		$partner=array();
		$partner["partner_email"]=$_POST["User_Email"];
		$g->executeInsert("partner",$partner,"");
	}
	$ar3=$g->getSQL("select partner_cmnd from partner where partner_cmnd='".$_POST["User_Cmnd"]."'",0);
	$ar2=$g->getSQL("select * from partner_enroll where enroll_email='".$_POST["User_Email"]."'  and week='".CURRENT_WEEK."'",0);

	if(sizeof($ar2)==0)
		{
			$_SESSION["turn"]["email"]=$_POST["User_Email"];
			$partner=array();
			$partner["partner_name"]=$_POST["User_RealName"];
			$partner["partner_company"]=$_POST["User_Company"];
			$partner["partner_phone"]=$_POST["User_Phone"];
			$partner["partner_phone2"]=$_POST["User_Phone2"];
			$partner["partner_cmnd"]=$_POST["User_Cmnd"];
			$g->executeUpdate("partner",$partner," where partner_email='".$_POST["User_Email"]."'");
			$status="pass";		
			echo "<status>".$status."</status>";return;
		}
		if(sizeof($ar2)!=0 )
		{
			$status="enrolled";
			echo "<status>".$status."</status>";return;
		}
	}
	
	


	
	//echo "<status>".$_SESSION["turn"]["email"]."</status>";
//$g=new general();
?>