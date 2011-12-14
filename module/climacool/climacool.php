<?
$lv="";
include_once ("config.php");
include_once 'htinmotion/php-cut-html-string/cutstring.php';
include_once 'htinmotion/orm/adodb5/adodb.inc.php';
include_once 'htinmotion/orm/general/general.php';
$g=new general();
$cm=$g->getSQL("select * from colourmission",0);
?>