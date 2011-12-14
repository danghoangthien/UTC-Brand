<?php
include_once '../../config.php'; 
include_once '../../htinmotion/pagination/pagination.class.php';
include_once '../../htinmotion/php-cut-html-string/cutstring.php';
$sql="select * from consult where todaytopic_type_id=".LT_ID." and status='enable' order by consult_datetime desc";$pagination	=	new pagination(); 
$pagination->createPaging($sql,5);
//$cm=$g->getSQL($sql,0);
	echo " <div align=\"center\"><a href=\"tu-van-chi-tiet.php?t_id=".LT_ID."\"><img src=\"img/tuvan_luyentap.jpg\"></a></div>";
	echo " <img src=\"img/tuvan_luyentap2.jpg\" width=\"280\" height=\"170\">";
	while($row=mysql_fetch_object($pagination->resultpage))
	{	
		echo 	"       
        <div class=\"news\">     
        <a href=\"tu-van-chi-tiet.php?c_id=".$row->consult_id."\">".strip_tags(truncate($row->title,60," ...",false,true ),"<p>")." </a><br>".strip_tags(truncate($row->content,250," ...",false,true ))."
        </div>
				";
			
	}
	echo "<h4 style='text-align:center'>";
	//if ($row)
	$pagination->displayPagingAjax("page#comment","show","module/tuvan/tvlt_ajax.php","result_lt");
	echo "</h4>";
?>