// JavaScript Document
$(document).ready(
	function()
	{
		//$(".all24galnav").css("height","25px");
		$("#current").css("display","none");
		var contest_type=set_contest_type();	
		$current=$("#current").html();	
		loadpg(contest_type);
		loadblock(1,contest_type);
		goto();
		triggerPassion(passion_param);
		//initVideo('');		
	}
);
function triggerPassion(passion_param)
		{
			if(passion_param=="alldance")
				{
					$('#passion option:eq(1)').attr('selected', 'selected')
				}	
			if(passion_param=="allskate")
				{
					$('#passion option:eq(2)').attr('selected', 'selected')						
				}
			if(passion_param=="allfashion")
				{
					$('#passion option:eq(4)').attr('selected', 'selected')						
				}	
			if(passion_param=="allmodeling")
				{
					$('#passion option:eq(5)').attr('selected', 'selected')						
				}			
			if(passion_param=="allmusic")
				{
					$('#passion option:eq(3)').attr('selected', 'selected')						
				}			
			if(passion_param=="allfootball")
				{
					$('#passion option:eq(6)').attr('selected', 'selected')						
				}												
		}
function goto()
{
	$("#passion").change(function(){
				if($("#passion option:selected").val()=="1")
				{
					location.href="alldance.php";
				}
	});
	$("#passion").change(function(){
				if($("#passion option:selected").val()=="2")
				{
					location.href="allskate.php";
				}
	});
	$("#passion").change(function(){
				if($("#passion option:selected").val()=="3")
				{
					location.href="allmusic.php";
				}
	});
	$("#passion").change(function(){
				if($("#passion option:selected").val()=="4")
				{
					location.href="allfashion.php";
				}
	});
	$("#passion").change(function(){
				if($("#passion option:selected").val()=="5")
				{
					location.href="allmodel.php";
				}
	});
	$("#passion").change(function(){
				if($("#passion option:selected").val()=="6")
				{
					location.href="allfootball.php";
				}
	});
}
function generate_capcha(id,img_id)
{
	
	jQuery.facebox("<h3>Bình chọn đã kết thúc.</h3>");
	$("#facebox").css({zIndex:"10000"});		return;

		var rand=$.random(6)+""+$.random(6)+""+$.random(6)+""+$.random(6)+""+$.random(6)+""+$.random(6); 

	jQuery.facebox("<h3 style='text-align:center'>Vui lòng nhập mã xác nhận:</h3>"
					+"<input type='text' id='capcha'/>&nbsp;&nbsp;<span id='gen' >"+rand+"</span>&nbsp;&nbsp;<img src='images/more.png' id='verify'/>");
	$("#facebox").css({zIndex:"10000"});
	$("#facebox #capcha").css({width:"50px",marginLeft:"30%"});
	$("#facebox #gen").css({color:"red",fontSize:"12px"});
	Cufon.replace("#gen");	  
	$("#facebox #verify").attr("align","top").click(function(){
		
		if($("#capcha").val()==rand)
		{
			//alert("vvv");
			vote(id,img_id);
		}
		else
		{
			jQuery.facebox("<h3>Mã xác nhận không đúng.</h3>");
		}
	});				
	//jQuery.facebox(rand);
}
function vote(id,img_id)
{
	jQuery.facebox("Bình chọn đã kết thúc.");return;
	var status="a";
	$.ajax({
		data		: "type=vote"+"&contest_id="+id,
		type		: "POST",
		url			: "module/all24/all24.php",
		dataType: "xml",
		success	:function(xml)
				{	
					//alert($(xml).find('error').length);
					if($(xml).find('error').length>0)
					{
						status=$(xml).find('error').text();	
						//$("#facebox").css("z-index",-1);
						
						if($.browser.version==6.0 || $.browser.version==7.0)
						{
							alert(status);
						}
						else
						{
							jQuery.facebox("<h3>"+status+"</h3>");
							$("#facebox").css("z-index",9009);
						}
						
					}
					else
					{
						status=$(xml).find('success').text();							
						if($.browser.version==6.0 || $.browser.version==7.0)
						{
							alert(status);
						}
						else
						{
							jQuery.facebox("<h3>"+status+"</h3>");
							$("#facebox").css("z-index",9009);
						}
						totalVote=$(xml).find('totalVote').text();
						$("#totalVote").html(totalVote);//totalVote	
						$("#"+img_id).attr("totalVote",totalVote);
					//alert(vote);	
					}
							
				}//end success callback
	});//end ajax

}
function initVideo(file)
{
	$("#player1").remove();
	if(file.indexOf(".jpg")>-1||file.indexOf(".jpg")>-1||file.indexOf(".png")>-1||file.indexOf(".gif")>-1)
	{
		$(".all24player").append("<img id='player1' src='"+file+"'/>");
	}
	else
	{
		$(".all24player").append("<div id='video_player'></div>");
	var flashvars = { file:file,autostart:'true',skin:'js/mediaplayer-5.5/skins/modieus.zip',controlbar:'over',idlehide:'true',thumbsinplaylist:'true',image:'../../images/all24_samplepre.png' };
	var params = { allowfullscreen:'true', allowscriptaccess:'always',wmode:'transparent' };
	var attributes = { id:'player1', name:'player1' };
	swfobject.embedSWF('js/mediaplayer-5.5/player.swf','video_player','480','360','9.0.115','false',
	flashvars, params, attributes);
	}
	
}
function  loaddetail(selector)
{
	
	$id			=$(selector).attr("id");
	$title		=$(selector).attr("title");
	$desc		=$(selector).attr("desc");
	$contest_date=$(selector).attr("contest_date");
	$totalVote	=$(selector).attr("totalVote");
	$member_user=$(selector).attr("member_user");
	$full_src	=$(selector).attr("full_src");
	$contest_id	=$(selector).attr("contest_id");
	$contest_fileup=$(selector).attr("contest_fileup");
	//$(".all24player").find("img").attr("src",$full_src);
	$init_video  =$(selector).attr("init_video"); 
	if($init_video=="true") initVideo("../../uploads/"+$contest_fileup);
	if($init_video=="false")	$(".all24player").find("img").attr("src",$full_src);
	$(".all24title").html($title);
	$("#member_user").html($member_user);
	$("#contest_date").html($contest_date);//totalVote
	$("#totalVote").html($totalVote);
	$('.all24votebut img').click(function(){generate_capcha($contest_id,$id)});
	$("#desc").html($desc).css("height","150px");//alert(selector);
} 
function loadblock(block,contest_type)
{
	$(".all24thumb").remove();
	$.ajax({
		data		: "contest_type="+contest_type,
		type		: "POST",
		url			: "module/all24/all24.php?load=record&pid="+block,
		dataType: "xml",
		success	:function(xml)
				{						
					$(xml).find("record").each(function(){	
							var div_id="record_"+$(this).attr("id");
							$("<div/>",
							{
								id:div_id
							}
							).attr("class","all24thumb").appendTo("#currentpage");
							var img_id="img_"+$(this).attr("id")
							$("<img/>",
								{
									id			:img_id,									
									src			:"uploads/"+$(this).find("thumbnail").text(),//thumbnail of video or photo
									title		:$(this).find("contest_title").text(),
									contest_fileup		:$(this).find("contest_fileup").text(),
									desc		:$(this).find("contest_desc").text(),
									init_video	:$(this).find("init_video").text(),
									totalVote	:$(this).find("totalVote").text(),
									member_user	:$(this).find("member_user").text(),
									contest_date:$(this).find("contest_date").text(),
									full_src 	:"uploads/"+$(this).find("contest_fileup").text(),//full photo or image
									contest_id	:$(this).attr("id"),
									click 		:function(){												
												loaddetail("#"+img_id);												
											}
							}).appendTo("#"+div_id);

					});// end find 	pageSet	each
					loaddetail("#"+$("#currentpage div:first img").attr("id"));

				}//end success callback
		});//end ajax
}
function loadpg(contest_type)
{
	$.ajax({
		data		: "contest_type="+contest_type,
		type		: "POST",
		url			: "module/all24/all24.php?load=paging",
		dataType: "xml",
		success	:function(xml)
				{						
					var pageSet=$(xml).find("pageSet").attr("pgNum");
					$(xml).find("pg").each(function(){	
						if($(this).attr("id")!="Next"&&$(this).attr("id")!="Pre"&&$(this).attr("id")!="First"&&$(this).attr("id")!="Last")
						{
							$("<a/>",
							{
								html:$(this).text(),
								id:$(this).attr("id"),
								click:function()
								{
									loadblock($(this).attr("id"),contest_type);
									$current=$(this).attr("id");//alert($current);
								}
							}).appendTo(".all24galnav");			
						}
						if($(this).attr("id")=="Pre")		
						{
							//alert($current);
								
							$("#all24_prev").click(function(){
								if($current>1)
								{
									$current--;
								}	
								else $current=1;
								loadblock($current,contest_type)
							});						
						}		
						if($(this).attr("id")=="Next")		
						{
							$("#all24_next").click(function(){
								if($current!=pageSet)
								{
									$current++;
								}	
								else $current=pageSet;
								loadblock($current,contest_type)
							});			
													
						}											
					});// end find 	pageSet	each
				}//end success callback
		});//end ajax
}
function set_contest_type()
{
	var pathname = window.location.pathname;var contest_type=1;
		if(pathname.toLowerCase().indexOf("alldance.php")>= 0)
		{
			contest_type=1;
		}
		if(pathname.toLowerCase().indexOf("allskate.php")>= 0)
		{
			contest_type=2;
		}
		if(pathname.toLowerCase().indexOf("allmusic.php")>= 0)
		{
			contest_type=3;
		}
		if(pathname.toLowerCase().indexOf("allfashion.php")>= 0)
		{
			contest_type=4;
		}
		if(pathname.toLowerCase().indexOf("allmodel.php")>= 0)
		{
			contest_type=5;
		}
		if(pathname.toLowerCase().indexOf("allfootball.php")>= 0)
		{
			contest_type=6;
		}		
		return contest_type;
}