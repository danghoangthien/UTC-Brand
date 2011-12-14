<?
$blasts=array(

);
$tracking_hash=array(
"FAVRy09",//
"VwPykYR",//
"7t2Iuld",
"MjfgChy",
"ez9YttX",
"SaeEB1g",
"k9H5hb7",
"bKbFPai",
"tfPor53",
"QeDtuYs",
"r2P5R7U",
"eURAn5e",
"EwDB0Xk",
"l6nFd3A",
"0yjTwW0",
"CPj3jo4",
"d4F8BDo",
"WPhVPk0",
"FfgA8SZ",
"V4wpwpq",
"Gd5InIr",
"UQx81Fi",
"NhY2e7M",
"8ZB3pUj",
"x6ONzqt",
"rS6LyvR",
"Uru9buW",
"vZp8nvp",
"L8i8Jkp",
"Lt741Sl",
"vGUvOw0",
"FO89h4p","3BRvWa4","6Hga72M","7G6qPTW","vCz1kB5","uw0brG6"
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
<form  method="post" action="streamsend_thien.php">
  <label for="textfield">tracking_id</label>
  <input type="text" name="tracking_id" id="tracking_id" />
  <input type="submit" value="get links" /> 
</form>
<?
$pattern='<img src="http://app.streamsend.com/v/14176037/T6Jr1JB/7aaq">';
if($_POST["tracking_id"])
{
	$tr=trim($_POST["tracking_id"]);	
	$tracking_hash[]=$tr;
	echo "Tracking links for $tr <br/>";
	echo "<div style='margin-left:10%'>";
	$i=1;
	
	foreach($blasts as $bl)
	{
		foreach ($tracking_hash as $hash)
		{
			echo "<img src='http://app.streamsend.com/v/".$bl."/".$hash."/7aaq'>";
		}
		
		//$links="<a class='blasts' id='".$i."' href='http://app.streamsend.com/v/".$bl."/".$tr."/7aaq' target='_new'>$bl</a><br/>";
	}
	echo "</div>";
}
?>
<? //$links;?>
</body>
</html>
