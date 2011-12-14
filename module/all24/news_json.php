<?
//$lv="../../";
include_once ("../../config.php");
include_once '../../htinmotion/php-cut-html-string/cutstring.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
include_once '../../htinmotion/php-cut-html-string/cutstring.php';
$g=new general();
if($_GET["page"]=="index")
	{
		$limit="limit 0,4";
		$text=55;
		$desc_txt=500;
	}
else	{$limit="limit 0,20";$text=40;$desc_txt=500;}
$sql="Select * from todaytopic where todaytopic_type_id=1 and status='enable' order by todaytopic_datetime desc $limit";
$tp=$g->getSQL($sql,0);
$data="";

$data.= '"news":[';
foreach ($tp as $t)
{
	
	$data.=	'{"id":"'.$t["todaytopic_id"].'","title":"0","title_full":"0","desc":"0";"content":"0"},';
	//$data.=	'{"id":"'.$t["todaytopic_id"].'",';
	//$data.=	'"title":"'.truncate($t["todaytopic_title"],$text," ...",false,true ).'",';
	//$data.=	'"title_full":"'.$t["todaytopic_title"].'",';
	//$data.=	'"desc":"'.$t["todaytopic_desc"].'",';
	//$data.=	'"content":"'.$t["todaytopic_content"].'",';
	//$data.=	'"dt":"'.$t["todaytopic_datetime"].'"},';
	
		/*
	echo "<news id='".$t["todaytopic_id"]."'>";
	echo "<id><![CDATA[".$t["todaytopic_id"]."]]></id>";
	echo "<title><![CDATA[".truncate($t["todaytopic_title"],$text," ...",false,true )."]]></title>";
	echo "<title_full><![CDATA[".$t["todaytopic_title"]."]]></title_full>";
	echo "<desc><![CDATA[".truncate($t["todaytopic_desc"],$desc_txt," ...",false,true )."]]></desc>";
	echo "<content><![CDATA[".$t["todaytopic_content"]."]]></content>";
	echo "<dt><![CDATA[".date("d-m-Y",strtotime($t["todaytopic_datetime"]))."]]></dt>";
	echo "</news>";
	*/
}
//$data.=	'{"id":"0","title":"0","title_full":"0","desc":"0";"content":"0"}';
$data.=	']';
echo 	'{'.$data.'}';
?>
