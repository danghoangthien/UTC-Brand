<?
$lv="";
include_once ("config.php");
include_once 'htinmotion/php-cut-html-string/cutstring.php';
include_once 'htinmotion/orm/adodb5/adodb.inc.php';
include_once 'htinmotion/orm/general/general.php';
$g=new general();
$lt=$g->getSQL("select * from gameface where status='enable'  and face_id IN(86,113,126) ",0);

?>