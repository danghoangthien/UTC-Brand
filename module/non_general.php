<?
include_once("../config.php");
include_once('../htinmotion/orm/adodb5/adodb.inc.php');
include_once('../htinmotion/orm/general/general.php');
include_once('../htinmotion/orm/adodb5/tohtml.inc.php');//tohtml.inc.php
include_once('../htinmotion/orm/adodb5/tojson.inc.php');
include_once('../htinmotion/orm/adodb5/toxml.inc.php');
if($_GET["type"]=="test")
{
	$g=new general();
	$record=array();
	$record["answer_content2"]="lam gia huy";
	$record["quiz_id"]="1";
	$insertSQL = $g->executeInsert("answer",$record,"");
}
if($_GET["type"]=="test_cache")
{
	$g=new general();
	$sql="select * from attend";
	$sec=1500;
	$rs=$g->executeCacheSQL($sec,"select * from attend");
	rs2html($rs);
	
}
if($_GET["type"]=="flush_cache")
{
	$g=new general();
	$sql="select * from attend";
	$rs=$g->executeCacheSQL(-1,"select * from attend");
}
if($_GET["type"]=="test_json")
{
	$g=new general();
	$sql="select * from attend";
	$rs=$g->getSQL2("select * from attend",0);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	echo rs2json($rs);
}
if($_GET["type"]=="test_xml")
{
	$g=new general();
	$sql="select * from attend";
	$rs=$g->getSQL2("select * from attend",0);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: text/xml');
	//print_r($rs);
	echo rs2xml($rs);
}
?>