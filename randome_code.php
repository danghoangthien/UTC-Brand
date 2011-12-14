<?
$HOST="localhost";
$DATABASE="admin_hp";
$USERNAME="admin_hpsurvey";
$PASS="gurus!@#$%^";
define('HOST',$HOST);
define('DATABASE',$DATABASE);
define('USERNAME',$USERNAME);
define('PASS',$PASS);
define('DEBUG',false);
include "htinmotion/orm/adodb5/adodb.inc.php";
include "htinmotion/orm/general/general.php";
$g=new general();
$partner=array();
$partner["partner_email"]=$_REQUEST["code"];
$partner["partner_code"]=substr(strtoupper(md5($partner["partner_email"])), 1, 6);
$arr=$g->getSQL("select partner_email from partner where partner_email='".$partner["partner_email"]."'",0);
if(sizeof($arr)==0)
{
	$lastID=$g->executeInsert("partner",$partner,"");
}
create_image($partner["partner_email"]);
function create_image($strEmail)
{
	$md5_hash = substr(strtoupper(md5($strEmail)), 1, 6);
	$img = imagecreate( 215, 32 ); 
	$background = imagecolorallocate( $img, 243, 243, 243 ); 
	$text_colour = imagecolorallocate( $img, 6, 61, 129 ); 
	imagesetthickness ( $img, 3 );
	$font = 'tahoma.ttf'; 
	imagettftext($img, 12, 0, 25, 25, $text_colour, $font, "M&#227; s&#7889; tham d&#7921; : ".$md5_hash);
	header("Content-Type: image/jpeg");
	imagepng( $img ); 
	imagecolordeallocate( $text_color );
	imagecolordeallocate( $background );
	imagedestroy( $img );
}
?>