<?
include "../../config.php";
include "../../htinmotion/orm/adodb5/adodb.inc.php";
include "../../htinmotion/orm/general/general.php";
$g=new general();
	if($_POST["time"])
	{
		$_SESSION["turn"]["time"]=($_POST["time"])?$_POST["time"]:"-1";
		$_SESSION["end"]=time();
		$_SESSION["turn"]["time"]=$_SESSION["end"]-$_SESSION["start"];
		if(sizeof($_SESSION["turn"]["log"])>0)
		{
			foreach($_SESSION["turn"]["log"] as $key=>$log)
			{
				$arr=$g->getSQL("select * from quiz where quiz_id=$key and correct_id=$log");
				if(sizeof($arr)>0)
				{
					$_SESSION["turn"]["correct"][$key]=$log;
				}
			}
			$partner_enroll=array();
			$partner_enroll["enroll_email"]			=$_SESSION["turn"]["email"];
			$partner_enroll["enroll_dt"]			=$_SESSION["turn"]["dt"];
			$partner_enroll["enroll_total_time"]	=$_SESSION["turn"]["time"];
			$partner_enroll["enroll_total_answer"]	=sizeof($_SESSION["turn"]["log"]);
			$partner_enroll["enroll_total_correct"]	=sizeof($_SESSION["turn"]["correct"]);
			$partner_enroll["week"]					=$_SESSION["turn"]["week"];
			$g->executeUpdate("partner_enroll",$partner_enroll," where enroll_email='".$_SESSION["turn"]["email"]."' and week='".$_SESSION["turn"]["week"]."'");
		}
		header('Content-type: text/xml');
		$turn_time=$_SESSION["turn"]["time"];
		//unset($_SESSION["turn"]);
		echo "<?xml version='1.0' encoding='UTF-8'?>";	
		echo "<status>".$turn_time."</status>";
		
	}
	
?>