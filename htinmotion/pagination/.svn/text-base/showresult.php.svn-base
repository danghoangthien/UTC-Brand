<?php
/***
File name : showresult.php -- an example file
Description : Shows the result in page wise
Author : Shijith. M
Date : 6th August 2008
***/
include_once("../../config.php");
include_once("pagination.class.php");  // include main class filw which creates pages


$pagination	=	new pagination();
$query	=	"SELECT * FROM `todaytopic` "; // write the database query
$pagination->createPaging($query,2);
echo '<table border="1" width="400" align="center">';
while($row=mysql_fetch_object($pagination->resultpage)){
	echo '<tr><td>'.$row->todaytopic_id.'</td><td>'.$row->todaytopic_title.'</td></tr>'; 
	// display name and age from database
}
echo '</table>';
echo '<table border="1" width="400" align="center">';
echo '<tr><td>';
$pagination->displayPagingAjax("page","show");
echo '</td></tr>';
echo '</table>';
?>