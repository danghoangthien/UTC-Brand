<?
function send_mail($from, $namefrom, $to, $nameto, $subject, $message,$username,$password){
	/*  your configuration here  */
//ini_set("sendmail_path","/usr/sbin/sendmail -t");	
ini_set("sendmail_from","thien.dang@mediagurus.vn");	
$header .= "Reply-To: Some One <thiendang.mediagurus@gmail.com>"."\n";
$header .= "Return-Path: Some One <thiendang.mediagurus@gmail.com>"."\n";
$header .= "From: <thien.dang@mediagurus.vn>"."\n";
$header .= "Content-Type: text/html; charset=iso-8859-2 "."\n";
$mail_sent = @mail($to, "a", $message, $header); 
return $mail_sent ? "221" : "500";
}
?>