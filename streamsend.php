<?
$blasts=array(
"14084063",// 7,681  	3,297
"14071581",// 23,782 	4,070
"14085433",// 12,557 	3,601  
"14056393",// 5,183 		3,461
"14056253",// 6,168		3,439
"14063309"
//"14044809",// 5,261		3,799
//"14037529"// 5,856		4,541
);
$tracking_hash=array(
"TbfEyNj",
"aSSLcHT",
"wRHXGwB",
"eryprWn",
"p3VyZgn",
"qxrADn2",
"ssVftEN",
"37nBRx5",
"5dUTIUp",
"l6pJueH",
"5UobNny",
"MF129yp",
"lsgZ8ET",
"MOH6igr",
"Bn38sWl",
"lwybjYV",
"wV6F7s1",
"nzJWxPx",
"Trxnf8P",
"IOU7MBG",
"Effy2sc",
"dtJg6DW",
"PFO6ZFn",
"BXZ7wjZ",
"EGq547n",
"PhVM9j0",
"Rbmgfqq",
"3bNtXmW",
"xAlUxYg",
"PH1VDmV",
"NJhehKT",
"DkKLzx1" //itsmylifevn@zing.vn 
);
/*
14084063 7,681  	3,297
14071581 23,782 	4,070
14085433 12,557 	3,601  
14056393 5,183 		3,461
14056253 6,168		3,439
14044809 5,261		3,799
14037529 5,856		4,541
*/
$links="";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" media="screen" href="js/facebox/facebox.css" rel="stylesheet"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="js/facebox/facebox.js"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		$(".blasts").each(function(){ 
		$timeout=2000;
		setTimeout(function(){},$timeout*$(this).attr("id"))});
	});
	
</script>
</head>

<body>
<form  method="post" action="streamsend.php">
  <label for="textfield">tracking_id</label>
  <input type="text" name="tracking_id" id="tracking_id" />
  <input type="submit" value="get links" /> 
</form>
<?
$pattern='<img src="http://app.streamsend.com/v/14176037/T6Jr1JB/7aaq">';
if($_POST["tracking_id"])
{
	$tr=trim($_POST["tracking_id"]);	
	//$tracking_hash[]=$tr;
	echo "Tracking links for $tr <br/>";
	echo "<div style='margin-left:10%'>";
	$i=1;
	
	foreach($blasts as $bl)
	{
			echo "<img src='http://app.streamsend.com/v/".$bl."/".$tr."/7aaq'>";
		//$links="<a class='blasts' id='".$i."' href='http://app.streamsend.com/v/".$bl."/".$tr."/7aaq' target='_new'>$bl</a><br/>";
	}
	echo "</div>";
}
?>
<? //$links;?>
</body>
</html>
