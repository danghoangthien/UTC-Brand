<?
include_once '../../config.php';
include_once '../../htinmotion/orm/adodb5/adodb.inc.php';
include_once '../../htinmotion/orm/general/general.php';
header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8'?>";	
$g=new general();
$c=$g->getSQL("select mp3_download_times from colourmission where mp3_id=".$_GET["mp3_id"],0);
$count=$c[0]["mp3_download_times"]+1;
$current=array();
$current["mp3_download_times"]=$count;
$g->executeUpdate("colourmission",$current,"where mp3_id=".$_GET["mp3_id"]);
$c=$g->getSQL("select mp3_download_times from colourmission where mp3_id=".$_GET["mp3_id"],0);
echo "<response>";
echo "<status>success</status>";
echo "<mp3_download_times>".$c[0]["mp3_download_times"]."</mp3_download_times>";
echo "</response>";
?>