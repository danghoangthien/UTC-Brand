<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"><![endif]-->
<?
include_once "module/themeta/meta.php";
?>
<link media="screen" type="text/css" href="adidas.css" rel="stylesheet"/>
<link media="screen" type="text/css" href="css/redmond/jquery-ui-1.8.4.custom.css" rel="stylesheet"/>
<link type="text/css" media="screen" href="js/facebox/facebox.css" rel="stylesheet"/>
<link rel="image_src" href="images/logo50.png" />  

<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="js/facebox/facebox.js"></script> 
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/AdiHaus_PS_Reg_400.font.js"></script>
<script type="text/javascript" src="js/jquery.innerfade.js"></script>
<script type="text/javascript" src="js/jquery.pngFix.js"></script> 
<!--[if lt IE 7 ]> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js"></script>
<![endif]-->

<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jsmol.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>  
<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
<script type="text/javascript" src="js/round.js"></script>
<script type="text/javascript" src="js/jquery.hash-change.js"></script>
<script type="text/javascript" src="js/jquery.url2.js"></script>

<script type="text/javascript" src="js/tracking.js"></script>

<script type="text/javascript" src="js/rand.js"></script>
<!--
<script type="text/javascript" src="js/jquery.jqDock.min.js" ></script>
-->



<!--
-->
<script type="text/javascript">
	//jQuery.fn.stripTags = function() { return this.replaceWith( this.html().replace(/<\/?[^>]+>/gi, '') ); };
	
function getURLParam(strParamName) {
              var strReturn = "";
              var strHref = window.location.href;
              if (strHref.indexOf("?") > -1) {
                  var strQueryString = strHref.substr(strHref.indexOf("?")).toLowerCase();
                  var aQueryString = strQueryString.split("&");
                  for (var iParam = 0; iParam < aQueryString.length; iParam++) {
                      if (
                      aQueryString[iParam].indexOf(strParamName.toLowerCase() + "=") > -1) {
                          var aParam = aQueryString[iParam].split("=");
                          strReturn = aParam[1];
                          break;
                      }
                  }
              }
              return unescape(strReturn);
          }	
function menu2(alink, name,txt1, txt2,appendTo) {
	  //$(".mainmenu").append('<a href="'+alink+'" onmouseover  ></a>');
	  $("<a/>",
	  {
		href:alink,
	   	id:name,
		html:txt1,
		mouseenter:function(){$(this).html(txt2).css("color","#000");Cufon.replace("#"+name);},
	    mouseleave:function(){$(this).html(txt1).css("color","#333");Cufon.replace("#"+name);}
	  }).appendTo(appendTo);
	  Cufon.replace("#"+name);	  
}	
function sub_menu(parent,alink, name,txt1, txt2,top,left) {
	  //$(".mainmenu").append('<a href="'+alink+'" onmouseover  ></a>');
	 
	$("#"+parent).bind('mouseenter',function(){
		//$("#smb a").remove();
		$("#"+name).remove(); 
		var original_width=$("#"+parent).css("width");
		menu2(alink, name,txt1, txt2,"#smb");
		$("#"+name).css({position:"relative",top:top,left:left});

	});
	$("#smb").bind('mouseleave',function(){
		//$("#"+name).remove(); 		
	});
	$(".gamebg").bind('mouseenter',function(){
		$("#"+name).remove(); 		
	});
	//$(".mainmenu").css("overflow","hidden");
	 
	    
}
  $(document).ready(
				function(){
					if($.browser.msie && $.browser.version=="8.0")
					{
						$(".searchform input[type=text]").css({position:"relative",top:"-10px"});
					}
					menu2("index.php", "menu_home", "HOME", "HOME",".mainmenu");
					menu2("all24.php", "menu_all24", "ALL24 EVENT", "ALL24 EVENT",".mainmenu");
					sub_menu("menu_all24","all24.php", "menu_sub_all24", "HOME", "HOME","0px","-105px");
					sub_menu("menu_all24","all24_rule.php", "menu_sub_all24_2", "RULE&AWARD", "RULE&AWARD","0px","-90px");
					sub_menu("menu_all24","all24_upload.php", "menu_sub_all24_3", "JOIN", "JOIN","0px","-80px");
					sub_menu("menu_all24","alldance.php", "menu_sub_all24_4", "VOTE", "VOTE","0px","-70px");
					menu2("gamefaces.php", "menu_game", "GAMEFACES", "GAMEFACES",".mainmenu");
					sub_menu("menu_game","gamefaces.php", "menu_sub_all24", "HOME", "HOME","0px","-8px");
					sub_menu("menu_game","gamefaces_rule.php", "menu_sub_all24_2", "RULE&AWARD", "RULE&AWARD","0px","10px");
					sub_menu("menu_game","gamefaces_join.php", "menu_sub_all24_3", "JOIN", "JOIN","0px","30px");
					sub_menu("menu_game","#t", "menu_sub_all24_4", "", "","0px","50px");
					menu2("gallery.php", "menu_gall", "ENDORSER", "ENDORSER",".mainmenu");
					menu2("colourmissions.php", "menu_climacool", "CLIMACOOL", "CLIMACOOL",".mainmenu");
					menu2("news.php", "menu_news", "NEWS", "NEWS",".mainmenu");
					//menu2("gallery.php", "menu_gall2", "ENDORSER2", "ENDORSER2",".mainmenu");
					$('#chuyen_1').innerFade({
						speed: 950,
						timeout: 2000,
						type: 'random',
						startDelay:0
					}).click(function(){location.href='all24.php';}).css({cursor:'pointer'});
					$('#chuyen_2').innerFade({
						speed: 950,
						timeout: 2000,
						type: 'random',
						startDelay:1000
					}).click(function(){location.href='gamefaces.php';}).css({cursor:'pointer'});
					$('#chuyen_3').innerFade({
						speed: 950,
						timeout: 2000,
						type: 'random',
						startDelay:2000,
						containerHeight:79		
					});
				
			});				
</script>
<script type="text/javascript">
$(document).ready(function(){
	//crossing browser
	$(".home-gamefaces-desc .newstitle").css("line-height","20px");
	
	if($.browser.msie )
		{
			if($.browser.version==6.0)
			{
									
			}	
			if($.browser.version==8.0)
			{
				//$("#logbut").css({marginTop:'20px',background:'red'});		
			}							
		}

});
</script>

<!-- Cross page script -->
<script type="text/javascript">
$(document).ready(function()
{	
	<?
	if($_SESSION["mem"])
	{
		$member_user=$_SESSION["mem"]["member_user"];
	?>
		$(".login").html(
		'<div style="marwidth:225px;vertical-align:middle">Xin chào <? echo $member_user?>,Thoát <input name="login" onclick="" style="align:middle" type="button" value="" class="logbut" id="logbut_out" /></div>  ');
		$("#logbut_out").click(function(){
			$(".login").load("module/thanhvien/logout.php",function(){$(".login").load("module/template/member_login.html");});	
				
			//$(".login").load("module/template/member_login.html");	
		});
	<?
	}else{		
	?>
		$(".login").load("module/template/member_login.html");
	<? }?>	
});
</script>
<script type="text/javascript">
$(document).ready(function(){$(document).pngFix(); });
</script>
</head>
<!--[if lt IE 7 ]> <body class="ie ie6 lt-ie7 lt-ie8 lt-ie9"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie ie7 lt-ie8 lt-ie9">        <![endif]-->
<!--[if IE 8 ]>    <body class="ie ie8 lt-ie9">               <![endif]-->
<!--[if IE 9 ]>    <body class="ie ie9">                      <![endif]-->
<!--[if gt IE 9]>  <body>                                     <![endif]-->
<!--[if !IE]><!--> <body>                                 <!--<![endif]-->
<div class="container">
<div class="leftmenu" style="padding-right: 5px;"><a href="http://adidas.com" target="_blank"><img src="images/logo.jpg" width="200" height="57" /></a> </div>
<div class="linemenu"></div>
<div class="leftmenu mainmenu">
<!-- <script type="text/javascript">
    document.write('<style>.noscript { display: none; }</style>');	
</script>
<script type="text/javascript">
menu("index.php", "menu_home", "menu_home1.png", "menu_home2.png");
menu("all24.php", "menu_all24", "menu_all241.png", "menu_all242.png");
menu("gamefaces.php", "menu_game", "menu_game1.png", "menu_game2.png");
menu("gallery.php", "menu_gall", "menu_gallery1.png", "menu_gallery2.png");
</script> -->
</div>
<div id="smb" style="float: left; width: 300px; position: relative; top: 40px; height: 0px; left: -300px; background: none repeat scroll 0% 0% black;"></div>
<div class="rightmenu"><a href="http://www.facebook.com/adidasvn" target="_blank" onmouseover="document.fb.src='images/fb2.png';" onmouseout="document.fb.src='images/fb.png';"><img src="images/fb.png" name="fb" width="34" height="34" style="float:left;padding-top: 10px;" /></a>
<div class="linemenu"></div>
<div class="login">
</div></div>
</div>
<div class="header" style="clear:both"></div>
<div class="gamebg" style="clear:both">