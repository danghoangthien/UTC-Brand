<?
$blasts=array(
"14071581",
"14063309",
"14085433",
"14044809",
"14084063",
"14037529",
"14056393",
"14056253",
"14167969",
"14062719",
"14145285",
"14096775",
"14152905"

);
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
	echo "Tracking links for $tr <br/>";
	echo "<div style='margin-left:10%'>";
	$i=1;
	foreach($blasts as $bl)
	{
		echo "<img src='http://app.streamsend.com/v/".$bl."/".$tr."/7aaq'>";
		sleep(1);
		//$links="<a class='blasts' id='".$i."' href='http://app.streamsend.com/v/".$bl."/".$tr."/7aaq' target='_new'>$bl</a><br/>";
		if($i==10) echo "<script>jQuery.facebox('finish tracking')</script>";
		$i++;		
	}
	echo "</div>";
}
?>
<? //$links;?>
</body>
</html>
