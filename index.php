<? include_once "config.php";?>
<? include_once "template/front/head.php";?>
<? include_once "template/front/header.php";?>
<script type="text/javascript">
$(document).ready(function(){
	//$("#User_Email").();
	 var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	$("#enroll").click(function(){
		
		 var numreg=/^[0-9]+$/;
		if($("#User_Email").val()=="" || $("#User_RealName").val()=="" || $("#User_Company").val()=="" || $("#User_Phone").val()=="" || $("#User_Phone2").val()=="" || $("#User_Cmnd").val()=="" )
		{
			jQuery.facebox("<h3 style='color:#0099ff'>Vui l&#242;ng th&#234;m &#273;&#7847;y &#273;&#7911; th&#244;ng tin.</h3>");return;
		}
		else
		{
			if( numreg.test(jQuery.trim($("#User_Phone").val()))==false || numreg.test(jQuery.trim($("#User_Phone2").val()))==false )
			{
				jQuery.facebox("<h3 style='color:#0099ff'>S&#7889; &#273;i&#7879;n tho&#7841;i kh&#244;ng h&#7907;p l&#7879;.</h3>");return;
			}
			else
			{
				if(numreg.test(jQuery.trim($("#User_Cmnd").val()))==false )
				{
					jQuery.facebox("<h3 style='color:#0099ff'>S&#7889; CMND kh&#244;ng h&#7907;p l&#7879;.</h3>");return;	
				}
				else
				{
					if(reg.test($("#User_Email").val()) == false) 
					{
						jQuery.facebox("<h3 style='color:#0099ff'>&#272;&#7883;a ch&#7881; email kh&#244;ng h&#7907;p l&#7879;</h3>");return;
					}
					else
					{
						if(!$("#User_Agree").attr("checked"))
						{
							jQuery.facebox("<strong style='color:#0099ff'> B&#7841;n ph&#7843;i &#273;&#7891;ng &#253; v&#7899;i c&#225;c th&#244;ng tin tr&#234;n l&#224; ch&#237;nh x&#225;c.</strong>");
						}
						if($("#User_Agree").attr("checked"))
						{
							var data={
							User_RealName:$("#User_RealName").val(),
							User_Company :$("#User_Company").val(),
							User_Phone	 :jQuery.trim($("#User_Phone").val()),
							User_Phone2  :jQuery.trim($("#User_Phone2").val()),
							User_Email	 :$("#User_Email").val(),
							User_Cmnd    :jQuery.trim($("#User_Cmnd").val())
							}
							$.ajax({
								data		:data,
								type		: "POST",
								url			: "module/quiz/register.php",
								dataType	: "xml",
								success		:function(xml)
									{	
											if(!$.browser.msie)
											{
												log($(xml).find("status").text());
											}
											if($(xml).find("status").text()=="pass")
											{
												jQuery.facebox("<h3 style='color:#0099ff'>M&#7901;i b&#7841;n tham gia d&#7921; tr&#7843; l&#7901;i.L&#432;u &#253; b&#7841;n ch&#7881; &#273;&#432;&#7907;c d&#7921; &#273;o&#225;n 1 l&#7847;n trong v&#242;ng 1 tu&#7847;n.</h3>");
												setTimeout(function(){
													location.href=("details.php");
												},4500);
												
												return;
											}
											if($(xml).find("status").text()=="enrolled")
											{
												jQuery.facebox("<h3 style='color:#0099ff'>B&#7841;n &#273;&#227; tham gia tr&#7843; l&#7901;i r&#7891;i.M&#7901;i b&#7841;n tr&#7903; l&#7841;i tham gia tr&#7843; l&#7901;i v&#224;o tu&#7847;n k&#7871; ti&#7871;p.</h3>");
												return;
											}
											if($(xml).find("status").text()=="not_fullfill")
											{
												jQuery.facebox("<h3 style='color:#0099ff'>Vui l&#242;ng th&#234;m &#273;&#7847;y &#273;&#7911; th&#244;ng tin.</h3>");
												return;
											}
											
											
									}//end success callback
								});//end ajax
						}
					}
				}
				
			}
		}
	});// end enroll click
});//end doc ready
</script>
<div id="right">
  <strong>K&iacute;nh g&#7917;i qu&yacute; &#273;&#7889;i t&aacute;c</strong>
   <p>HP lu&ocirc;n ghi nh&#7853;n s&#7921; n&#7895; l&#7921;c h&#7907;p t&aacute;c c&#7911;a Qu&yacute; &#273;&#7889;i t&aacute;c trong th&#7901;i gian v&#7915;a qua. V&igrave; v&#7853;y, C&ocirc;ng ty ch&uacute;ng t&ocirc;i t&#7893; ch&#7913;c cu&#7897;c thi<font color="#62b0ff"><strong> &quot; Answers to get back money&quot;</strong></font> nh&#432; m&#7897;t l&#7901;i c&aacute;m &#417;n g&#7917;i &#273;&#7871;n Qu&yacute; &#273;&#7889;i t&aacute;c.</p>
  <p>Ch&#7881; c&#7847;n tham gia v&agrave; tr&#7843; l&#7901;i &#273;&uacute;ng c&aacute;c c&acirc;u h&#7887;i v&#7873; s&#7843;n ph&#7849;m c&#7911;a HP trong th&#7901;i gian nhanh nh&#7845;t, Qu&yacute; &#273;&#7889;i t&aacute;c s&#7869; nh&#7853;n &#273;&#432;&#7907;c ngay m&#7897;t phi&#7871;u mua h&agrave;ng t&#7841;i si&ecirc;u th&#7883; CO.OP Mart tr&#7883; gi&aacute; 500.000 &#273;&#7891;ng.</p>
  <p>Cu&#7897;c thi &#273;&#432;&#7907;c chia th&agrave;nh 4 &#273;&#7907;t<font color="#62b0ff"><strong> ( k&#7875; t&#7915; ng&agrave;y 05/07/2011 &#273;&#7871;n  31/07/2011)</strong></font> v&#7899;i t&#7893;ng gi&#7843;i th&#432;&#7903;ng l&agrave; 40 phi&#7871;u mua h&agrave;ng t&#7841;i si&ecirc;u th&#7883; CO.OP Mart tr&#7883; gi&aacute; <strong>500.000</strong> &#273;&#7891;ng m&#7895;i phi&#7871;u.<font color="#62b0ff"><strong>M&#7895;i &#273;&#7907;t s&#7869; k&#7871;t th&uacute;c v&agrave;o cu&#7889;i m&#7895;i ng&agrave;y ch&#7911; nh&#7853;t h&#7857;ng tu&#7847;n</strong></font>.</p>
  <p><strong>N&#7871;u c&#7847;n th&#234;m th&#244;ng tin v&#7873; ch&#432;&#417;ng tr&#236;nh vui l&#242;ng li&#234;n h&#7879;</strong><br/>
  	Email1 : nhien.tran-thai-hao@hp.com<br/>
    Email2 : thiendang.mediagurus@gmail.com<br/>
    Hotline : (84)- 39.914.291
  </p>	
    <div id="submitdiv">
      <form name="login" id="login" method="post" action="thankyou.php" onSubmit="return  ValidateForm()"> 
      <table width="100%">
      <tr>
        <td width="32%">H&#7885; t&ecirc;n</td><td width="68%">(*)&nbsp;<input name="User_RealName" type="text" id="User_RealName" /></td></tr>
      <tr>
        <td>T&#234;n
          c&ocirc;ng ty</td><td>(*)&nbsp;<input name="User_Company" type="text" id="User_Company" /></td></tr>
      <tr>
        <td>&#272;i&#7879;n tho&#7841;i b&agrave;n</td><td>(*)&nbsp;<input name="User_Phone" type="text" id="User_Phone" /></td></tr>
      <tr>
        <td>&#272;i&#7879;n tho&#7841;i di &#273;&#7897;ng</td>
        <td>(*)&nbsp;<input name="User_Phone2" type="text" id="User_Phone2" /></td></tr>
      <tr>
        <td>&#272;&#7883;a ch&#7881; email</td><td>(*)&nbsp;<input name="User_Email" type="text" id="User_Email" /></td></tr>
      <tr>
        <td>CMND</td><td>(*)&nbsp;<input name="User_Cmnd" type="text" id="User_Cmnd" /></td></tr>
      <tr> 
      	<td colspan="2">(*) : Th&#244;ng tin b&#7855;t bu&#7897;c v&agrave; ch&iacute;nh x&aacute;c &#273;&#7875; ch&uacute;ng t&ocirc;i c&oacute; th&#7875; li&ecirc;n l&#7841;c.</td>
      </tr>
       <tr> 
      	<td colspan="2">
        <input name="agree" type="checkbox" id="User_Agree" />
        T&#244;i x&#225;c nh&#7853;n c&#225;c th&#244;ng tin tr&#234;n l&#224; ch&#237;nh x&#225;c.Ban t&#7893; ch&#7913;c s&#7869; kh&#244;ng gi&#7843;i quy&#7871;t c&#225;c tr&#432;&#7901;ng h&#7907;p cung c&#7845;p th&#244;ng tin sai.</td>
      </tr>  
      <tr>
       <td>&nbsp;</td>
        <td>
        <a id="enroll" href="#t"><img src="images/thamgia.png" width="118" height="26" border="0" style="padding-top:10px;" /></a>
        </td>
      </tr>
      
      </table>
      </form>
    </div> 
  
</div>
<? include_once "template/front/footer.php";?>