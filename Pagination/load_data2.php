<?php
include "../config.php";
include "../htinmotion/orm/adodb5/adodb.inc.php";
include "../htinmotion/orm/general/general.php";
include "../htinmotion/orm/adodb5/tojson.inc.php";
include "../htinmotion/pagination/pagingAdvance.php";
$g=new general();
if($_POST['type']=='page')
{
	$query_pag_data = "SELECT * from category";
	pagingJSON($_POST["page"],$query_pag_data,12,false);
	return;
}
if($_POST['type']=="no_of_page")
{
	$count_sql="select count(category_id) as count from category ";
	smartPagingNavi($_POST["cur_page"],$count_sql,12,true);
	return;
}
