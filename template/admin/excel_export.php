<?
function HTexport($sheet_name,$filename,$header_width_arr,$header_arr,$result_arr)
{
header("Content-Type: text/xml;charset=utf-8");
header("content-disposition: attachment;filename=$filename.xlsx.xml");
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo "<?mso-application progid=\"Excel.Sheet\"?>";
?>
<?
echo'<Workbook
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
 <Worksheet ss:Name="HPSURVEY">
  <ss:Table>';
?>  
   <? 
   foreach ($header_width_arr as $width)
   {
	   echo '<ss:Column ss:Width="'.$width.'"/>';
   }
   ?>
<? echo '<ss:Row>' ; ?>

    <?
    foreach ($header_arr as $key=>$value)
	{
		echo ' <ss:Cell ><Data ss:Type="String">'.$value.'</Data></ss:Cell>';
	}
	?>  
<?  echo'</ss:Row>';    ?>
<?
	 foreach ($result_arr as $key=>$value)
	{
		echo '<ss:Row>';
		foreach($value as $k=>$v)
		{
			echo ' <ss:Cell ><Data ss:Type="String">'.$v.'</Data></ss:Cell>';
		}
		echo '</ss:Row>';
	}
?>
<?   
echo '</ss:Table>
 </Worksheet>
</Workbook>';
}
?>