<?
//$lv="../../";
include_once ("../../config.php");
include_once '../../htinmotion/php-cut-html-string/cutstring.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
include_once '../../htinmotion/php-cut-html-string/cutstring.php';
if($_GET["page"]=="json")
	{
		echo"{returns:[{\"hoten\":\"a\"}]}";
		return;
	//	Response.Write("{'user':[{'hoten':'giatrihoten','diachi':'giatridiachi','phone':'giatriphone',}]}";
	}	
	
header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8'?>";	
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
echo "<result>";
foreach ($tp as $t)
{
	echo "<news id='".$t["todaytopic_id"]."'>";
	echo "<id><![CDATA[".$t["todaytopic_id"]."]]></id>";
	echo "<title><![CDATA[".truncate($t["todaytopic_title"],$text," ...",false,true )."]]></title>";
	echo "<title_full><![CDATA[".$t["todaytopic_title"]."]]></title_full>";
	echo "<desc><![CDATA[".truncate($t["todaytopic_desc"],$desc_txt," ...",false,true )."]]></desc>";
	echo "<content><![CDATA[".$t["todaytopic_content"]."]]></content>";
	echo "<dt><![CDATA[".date("d-m-Y",strtotime($t["todaytopic_datetime"]))."]]></dt>";
	echo "</news>";
}
echo "</result>";
?>
