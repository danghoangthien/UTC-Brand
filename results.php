<? include_once "config.php";?>
<? include_once "template/front/head.php";?>
<? include_once "template/front/header.php";?>
<? if(!isset($_SESSION["turn"]))
	{
		echo "<script>
		jQuery.facebox('<h3 style=\"color:#0099ff\">Vui l&#242;ng tham d&#7921; tr&#432;&#7899;cc khi xem k&#7871;t qu&#7843;</h3>');
		</script>";return;
	}
?>
<? if(isset($_SESSION["turn"]))
{
?>
<div id="right3">
     C&aacute;m &#417;n b&#7841;n &#273;&atilde; tham gia ch&#432;&#417;ng tr&igrave;nh <font color="#62b0ff"><strong>&quot; Answers to get back money&quot;<br />
     <br />
     </strong></font>
      <strong>K&#7871;t qu&#7843;:</strong><br />   <br />  
   T&#7893;ng s&#7889; c&acirc;u tr&#7843; l&#7901;i: <strong><? echo sizeof($_SESSION["turn"]["log"])?> c&acirc;u</strong><br />
      C&acirc;u tr&#7843; l&#7901;i &#273;&uacute;ng: <strong><? echo sizeof($_SESSION["turn"]["correct"])?> c&acirc;u</strong><br />
    Th&#7901;i gian tr&#7843; l&#7901;i: <strong><? echo $_SESSION["turn"]["time"]?> gi&#226;y</strong>
<p>Ch&uacute;c b&#7841;n may m&#7855;n ! Th&#244;ng tin th&#7855;ng gi&#7843;i s&#7869; &#273;&#432;&#7907;c  c&#7853;p nh&#7853;t h&#7857;ng tu&#7847;n tr&#234;n website.</p>
      <p>&nbsp;</p>
<p>&nbsp;</p>
</div>
<?
unset($_SESSION["turn"]);
}
?>

<? include_once "template/front/footer.php";?>