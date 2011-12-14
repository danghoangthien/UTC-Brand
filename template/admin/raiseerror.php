<?php
function raiseerror($array)
{
	$error="";
	if (is_array($array))
	{
		$error.="<h2>Bạn hãy hòan thành các thông tin chưa hợp lệ sau</h2>";
		$error.= "<p class=\"validation_error\" style=\"color:red\">";
		foreach ($array as $key=> $value)
		{
			$error.= "<h3 style=\"color:red\">".$value."<h3/>";			 
		}
		$error.= "</p>";
	}
	echo "<script>jQuery.facebox('".$error."')</script>";
}
function appendError($array)
{
	if (is_array($array))
	{
		$message="<span>Bạn hãy hòan thành các thông tin chưa hợp lệ sau</span><br/>";
		foreach ($array as $key=> $value){$message.= "<span style='color:red'>".$value."</span><br/>";}		
	}
	return $message;
}